<?php

declare(strict_types=1);

namespace Proof\Service;

defined('ABSPATH') || exit;

/**
 * Builds a privacy-safe list of recent-sale notifications from real WooCommerce
 * orders.
 *
 * PRIVACY: only a customer's first name and billing city are ever exposed, 
 * never the surname, email, full address, order id or any other PII. The
 * payload returned by {@see self::notifications()} is the exact data sent to the
 * browser, so it is deliberately minimal.
 *
 * The result is cached in a short-lived transient so the storefront never runs
 * an order query on every page load.
 */
final class OrderFeed
{
    private const CACHE_KEY = 'proof_feed_cache';
    private const CACHE_TTL = 5 * MINUTE_IN_SECONDS;

    /** Only orders newer than this are eligible to be shown. */
    private const MAX_AGE_DAYS = 30;

    /** How many recent orders to draw the rotation from. */
    private const MAX_ORDERS = 40;

    /** @var array<string, mixed> */
    private array $settings;

    /**
     * @param array<string, mixed> $settings
     */
    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Privacy-safe notifications for the front end.
     *
     * Each item: ['name' => string, 'city' => string, 'product' => string,
     * 'time' => string (human diff), 'ts' => int (unix)]. Returns an empty array
     * when there is nothing safe to show.
     *
     * @return list<array{name:string,city:string,product:string,time:string,ts:int}>
     */
    public function notifications(): array
    {
        $cached = get_transient(self::CACHE_KEY);
        if (is_array($cached)) {
            /** @var list<array{name:string,city:string,product:string,time:string,ts:int}> $cached */
            return $this->withFreshTimes($cached);
        }

        $items = $this->buildFromOrders();

        set_transient(self::CACHE_KEY, $items, self::CACHE_TTL);

        return $this->withFreshTimes($items);
    }

    /**
     * Query recent paid orders and reduce each to a safe payload.
     *
     * @return list<array{name:string,city:string,product:string,time:string,ts:int}>
     */
    private function buildFromOrders(): array
    {
        if (! function_exists('wc_get_orders')) {
            return [];
        }

        $after = gmdate('Y-m-d H:i:s', time() - (self::MAX_AGE_DAYS * DAY_IN_SECONDS));

        $orders = wc_get_orders([
            'limit'        => self::MAX_ORDERS,
            'orderby'      => 'date',
            'order'        => 'DESC',
            'status'       => ['wc-completed', 'wc-processing'],
            'date_created' => '>=' . $after,
            'type'         => 'shop_order',
            'return'       => 'objects',
        ]);

        if (! is_array($orders)) {
            return [];
        }

        $items = [];
        foreach ($orders as $order) {
            if (! $order instanceof \WC_Order) {
                continue;
            }

            $item = $this->mapOrder($order);
            if ($item !== null) {
                $items[] = $item;
            }
        }

        return $items;
    }

    /**
     * Reduce one order to a safe payload, or null if it has no usable product.
     *
     * @return array{name:string,city:string,product:string,time:string,ts:int}|null
     */
    private function mapOrder(\WC_Order $order): ?array
    {
        $product = $this->firstProductName($order);
        if ($product === '') {
            return null;
        }

        $firstName = trim((string) $order->get_billing_first_name());
        $name      = $firstName !== ''
            ? $firstName
            : (string) ($this->settings['anonymous_name_text'] ?? __('Someone', 'plogins-proof'));

        $city = trim((string) $order->get_billing_city());

        $created = $order->get_date_created();
        $ts      = $created instanceof \WC_DateTime ? $created->getTimestamp() : time();

        return [
            'name'    => $name,
            'city'    => $city,
            'product' => $product,
            'time'    => '',
            'ts'      => $ts,
        ];
    }

    /**
     * The name of the first purchasable line item in an order.
     */
    private function firstProductName(\WC_Order $order): string
    {
        foreach ($order->get_items() as $item) {
            if (! $item instanceof \WC_Order_Item_Product) {
                continue;
            }
            $name = trim((string) $item->get_name());
            if ($name !== '') {
                return $name;
            }
        }

        return '';
    }

    /**
     * Recompute the human-readable "x minutes ago" strings each call so cached
     * timestamps never go stale.
     *
     * @param list<array{name:string,city:string,product:string,time:string,ts:int}> $items
     * @return list<array{name:string,city:string,product:string,time:string,ts:int}>
     */
    private function withFreshTimes(array $items): array
    {
        $now = time();
        foreach ($items as $i => $item) {
            $ts = (int) ($item['ts'] ?? $now);
            /* translators: %s: human-readable time difference, e.g. "2 hours". */
            $items[$i]['time'] = sprintf(__('%s ago', 'plogins-proof'), human_time_diff($ts, $now));
        }

        return $items;
    }

    /**
     * Drop the cached feed (e.g. after a new order or a settings change).
     */
    public static function flushCache(): void
    {
        delete_transient(self::CACHE_KEY);
    }
}

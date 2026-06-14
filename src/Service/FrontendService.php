<?php

declare(strict_types=1);

namespace Proof\Service;

use Proof\Contract\HasHooks;
use Proof\Plugin;
use Proof\Settings\SettingsRepository;

defined('ABSPATH') || exit;

/**
 * Front-end orchestration: decides whether to load on the current request,
 * enqueues the (vanilla JS) popup script + CSS, and hands the privacy-safe feed
 * and timing config to the browser.
 *
 * Renders nothing when disabled, out of scope, or when there are no safe
 * notifications to show — never broken markup, never a fatal.
 */
final class FrontendService implements HasHooks
{
    private SettingsRepository $settings;

    private OrderFeed $feed;

    public function __construct(SettingsRepository $settings, OrderFeed $feed)
    {
        $this->settings = $settings;
        $this->feed     = $feed;
    }

    public function registerHooks(): void
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueueAssets']);

        // Keep the cached feed fresh when orders change.
        add_action('woocommerce_new_order', [OrderFeed::class, 'flushCache']);
        add_action('woocommerce_order_status_changed', [OrderFeed::class, 'flushCache']);
    }

    /**
     * Enqueue assets and localise data — only when everything lines up.
     */
    public function enqueueAssets(): void
    {
        if (! $this->shouldDisplay()) {
            return;
        }

        /**
         * Filter the privacy-safe notifications sent to the browser. PRO
         * companions may append additional real, privacy-safe items here (each
         * must match the {name, city, product, time, ts} shape).
         *
         * @param list<array{name:string,city:string,product:string,time:string,ts:int}> $notifications
         * @param array<string, mixed>                                                    $settings
         */
        $notifications = apply_filters('proof/notifications', $this->feed->notifications(), $this->settings->all());

        if (! is_array($notifications) || $notifications === []) {
            // Nothing safe to show — load nothing rather than an empty widget.
            return;
        }

        wp_enqueue_style(
            'proof',
            Plugin::instance()->url('assets/css/proof.css'),
            [],
            \Proof\VERSION,
        );

        wp_enqueue_script(
            'proof',
            Plugin::instance()->url('assets/js/proof.js'),
            [],
            \Proof\VERSION,
            ['in_footer' => true, 'strategy' => 'defer'],
        );

        wp_localize_script('proof', 'proofData', [
            'notifications' => $notifications,
            'config'        => $this->frontConfig(),
            'i18n'          => [
                'regionLabel' => __('Recent purchase', 'proof'),
                'closeLabel'  => __('Dismiss notification', 'proof'),
                /* translators: connects a name to a city, e.g. "Alex from Berlin". */
                'from'        => __('from', 'proof'),
                /* translators: connects a buyer to a product, e.g. "bought Hoodie". */
                'bought'      => __('bought', 'proof'),
            ],
        ]);
    }

    /**
     * Timing + display config for the browser, all already clamped on save.
     *
     * @return array<string, mixed>
     */
    private function frontConfig(): array
    {
        $s = $this->settings->all();

        return [
            'position'       => (string) $s['position'],
            'initialDelay'   => (int) $s['initial_delay'] * 1000,
            'displayTime'    => (int) $s['display_time'] * 1000,
            'interval'       => (int) $s['interval'] * 1000,
            'maxPerSession'  => (int) $s['max_per_session'],
            'fields'         => [
                'name'    => (bool) $s['show_name'],
                'city'    => (bool) $s['show_city'],
                'product' => (bool) $s['show_product'],
                'time'    => (bool) $s['show_time'],
            ],
        ];
    }

    /**
     * Whether Proof should run on the current request.
     */
    private function shouldDisplay(): bool
    {
        $s = $this->settings->all();

        if (empty($s['enabled']) || is_admin()) {
            return false;
        }

        $scope = (string) $s['display_scope'];
        $match  = match ($scope) {
            'all'     => true,
            'product' => function_exists('is_product') && is_product(),
            default   => $this->isShopContext(),
        };

        /**
         * Filter whether Proof renders on the current request.
         *
         * @param bool                 $match    Whether the current scope matches.
         * @param string               $scope    The configured display scope.
         * @param array<string, mixed> $settings Resolved settings.
         */
        return (bool) apply_filters('proof/should_display', $match, $scope, $s);
    }

    private function isShopContext(): bool
    {
        $isShop    = function_exists('is_shop') && is_shop();
        $isArchive = function_exists('is_product_taxonomy') && is_product_taxonomy();
        $isProduct = function_exists('is_product') && is_product();

        return $isShop || $isArchive || $isProduct;
    }
}

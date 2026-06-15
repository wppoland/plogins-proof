<?php

declare(strict_types=1);

namespace Proof\Service;

use Proof\Contract\HasHooks;
use Proof\Plugin;
use Proof\Settings\SettingsRepository;

defined('ABSPATH') || exit;

/**
 * Front-end handling: decides whether to load on the current request,
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

        $settings = $this->settings->all();

        /**
         * Filters the privacy-safe notification feed before it is sent to the
         * browser. Add-ons (e.g. Proof Pro) append their own items here, using
         * the same shape: {name, city, product, time, ts}.
         *
         * @param list<array{name:string,city:string,product:string,time:string,ts:int}> $notifications Feed built from recent WooCommerce orders.
         * @param array<string, mixed>                                                    $settings      Resolved FREE settings.
         */
        $notifications = apply_filters('proof/notifications', $this->feed->notifications(), $settings);

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
            'position'     => (string) $s['position'],
            'initialDelay' => (int) $s['initial_delay'] * 1000,
            'displayTime'  => (int) $s['display_time'] * 1000,
            'interval'     => (int) $s['interval'] * 1000,
        ];
    }

    /**
     * Whether Proof should run on the current request. Popups load on the
     * storefront when enabled; never in wp-admin.
     */
    private function shouldDisplay(): bool
    {
        if (empty($this->settings->all()['enabled']) || is_admin()) {
            return false;
        }

        return true;
    }
}

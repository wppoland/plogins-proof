<?php
/**
 * Default settings, merged under the option key `proof_settings`.
 *
 * Proof shows privacy-safe social-proof popups built from recent real
 * WooCommerce orders. Only a first name and a city are ever displayed — never
 * full names, emails or addresses. Fake/demo data is OFF by default; the plugin
 * shows nothing unless real qualifying orders exist.
 *
 * @package Proof
 *
 * @return array<string, mixed>
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

return [
    // Master switch.
    'enabled' => true,

    // Where to show: 'all' (whole storefront), 'shop' (shop + product archives
    // + single products) or 'product' (single product pages only).
    'display_scope' => 'shop',

    // Screen corner: bottom-left | bottom-right | top-left | top-right.
    'position' => 'bottom-left',

    // Which fields each popup shows.
    'show_name'    => true,
    'show_city'    => true,
    'show_product' => true,
    'show_time'    => true,

    // Privacy fallback shown when a first name is missing.
    'anonymous_name_text' => 'Someone',

    // Timing (seconds). All clamped to sane ranges on save.
    'initial_delay' => 5,
    'display_time'  => 6,
    'interval'      => 12,

    // Frequency cap: max popups shown per visitor per page view (0 = unlimited).
    'max_per_session' => 8,

    // Source data window.
    'max_age_days' => 30,
    'max_orders'   => 40,

    // Use placeholder demo data when there are no qualifying real orders.
    // OFF by default — Proof only ever shows genuine purchases.
    'fake_data' => false,
];

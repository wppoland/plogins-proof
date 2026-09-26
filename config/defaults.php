<?php
/**
 * Default settings, merged under the option key `proof_settings`.
 *
 * Proof shows privacy-safe social-proof popups built from recent real
 * WooCommerce orders. Only a first name and a city are ever displayed, never
 * full names, emails or addresses. When there are no qualifying real orders,
 * Proof shows nothing.
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

    // Screen corner: bottom-left | bottom-right | top-left | top-right.
    'position' => 'bottom-left',

    // Privacy fallback shown when a first name is missing. Empty on purpose:
    // a literal here can never reach the .pot, so shoppers in every language
    // read the English word. OrderFeed translates it when this is blank, and
    // a shop that types its own wording still wins.
    'anonymous_name_text' => '',

    // Timing (seconds). All clamped to sane ranges on save.
    'initial_delay' => 5,
    'display_time'  => 6,
    'interval'      => 12,
];

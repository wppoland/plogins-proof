<?php
/**
 * Uninstall cleanup for Proof.
 *
 * Removes the plugin's own options and cached feed when it is deleted from
 * wp-admin. Proof stores no custom tables and never touches WooCommerce data.
 *
 * @package Proof
 */

declare(strict_types=1);

defined('WP_UNINSTALL_PLUGIN') || exit;

delete_option('proof_settings');
delete_option('proof_db_version');
delete_transient('proof_feed_cache');

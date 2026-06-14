<?php

declare(strict_types=1);

namespace Proof;

use Proof\Settings\SettingsRepository;

defined('ABSPATH') || exit;

/**
 * Idempotent version migrations, run on every boot. Compares a stored option
 * against VERSION and applies forward steps as needed. Proof stores no custom
 * tables — it reads live WooCommerce orders — so migration only seeds the
 * default settings once.
 */
final class Migrator
{
    private const OPTION = 'proof_db_version';

    public function maybeMigrate(): void
    {
        $current = (string) get_option(self::OPTION, '0');

        if (version_compare($current, VERSION, '>=')) {
            return;
        }

        $this->seedDefaultSettings();

        update_option(self::OPTION, VERSION, false);
    }

    /**
     * Seed the default settings once, without clobbering an existing config.
     */
    private function seedDefaultSettings(): void
    {
        if (get_option(SettingsRepository::OPTION, null) !== null) {
            return;
        }

        /** @var array<string, mixed> $defaults */
        $defaults = require PROOF_DIR . 'config/defaults.php';

        add_option(SettingsRepository::OPTION, $defaults, '', false);
    }
}

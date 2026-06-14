<?php
/**
 * Service wiring. Returns a closure that registers every service in the
 * container. Bindings are lazy: nothing is instantiated here, so the container
 * is safe to build at construction time (e.g. before plugins_loaded).
 *
 * Proof is fully self-contained — all logic lives in these src/ services.
 *
 * @package Proof
 */

declare(strict_types=1);

use Proof\Admin\Settings;
use Proof\Container;
use Proof\Migrator;
use Proof\Service\FrontendService;
use Proof\Service\OrderFeed;
use Proof\Settings\SettingsRepository;

defined('ABSPATH') || exit;

return static function (Container $c): void {
    $c->singleton(Migrator::class, static fn (): Migrator => new Migrator());

    $c->singleton(SettingsRepository::class, static fn (): SettingsRepository => new SettingsRepository());

    $c->singleton(OrderFeed::class, static fn (): OrderFeed => new OrderFeed(
        $c->get(SettingsRepository::class)->all(),
    ));

    $c->singleton(FrontendService::class, static fn (): FrontendService => new FrontendService(
        $c->get(SettingsRepository::class),
        $c->get(OrderFeed::class),
    ));

    // Admin (only needed in wp-admin context).
    if (is_admin()) {
        $c->singleton(Settings::class, static fn (): Settings => new Settings(
            $c->get(SettingsRepository::class),
        ));
    }
};

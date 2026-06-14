<?php
/**
 * Boot order: services listed here are resolved from the container and have
 * their registerHooks() called during Plugin::boot(). Each must implement
 * Proof\Contract\HasHooks.
 *
 * Admin-only services are included only inside wp-admin.
 *
 * @package Proof
 *
 * @return array<class-string>
 */

declare(strict_types=1);

use Proof\Admin\Settings;
use Proof\Service\FrontendService;

defined('ABSPATH') || exit;

return [
    FrontendService::class,
    ...(is_admin() ? [Settings::class] : []),
];

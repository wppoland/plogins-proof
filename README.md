# Proof - Sales Notifications for WooCommerce

Show small popups in a corner of the screen that surface recent **real** purchases
from your WooCommerce store — e.g. *"Alex from Berlin bought Hoodie 2 hours ago"* —
to build trust and a gentle sense of urgency.

Free, self-contained, wp.org-ready. No jQuery, no layout shift, privacy-safe.

## What it does

- Builds a rotation of recent-sale popups from real WooCommerce orders (completed & processing).
- **Privacy-safe:** only first name + billing city are ever exposed to the browser —
  never surnames, emails, addresses or order numbers. Each field is individually toggleable.
- **Real orders only:** demo/placeholder data is off by default; with no qualifying orders
  it renders nothing rather than inventing sales.
- Vanilla-JS widget (loaded `defer` in the footer) rotates popups with a configurable
  initial delay, display time and interval, and respects a per-page-view frequency cap.
- Cached order feed (transient) so the storefront never queries orders on every page load.

## Settings (WooCommerce → Proof)

Enable/disable, display scope (whole store / shop+archives+products / single products),
screen corner, which fields show (name / city / product / time), timing, frequency cap,
maximum order age & count, and an off-by-default demo-data toggle for new stores.

## Accessibility & performance

- Popup lives in an `aria-live="polite"` status region — announced without stealing focus.
- Never traps focus, never blocks content; keyboard-accessible dismiss with a visible focus ring.
- Respects `prefers-reduced-motion`; dark-mode aware (front end and admin).
- Fixed-corner positioning means **no Cumulative Layout Shift**.

## Architecture

- **Bootstrap** (`proof.php`): WooCommerce guard, HPOS + cart/checkout-blocks compat,
  boot on `init` priority 0, `do_action('proof/booted', Plugin::instance())` fired from
  inside `Plugin::boot()` (the hook the PRO companion extends).
- **DI**: `src/Plugin.php` + `src/Container.php`; services in `config/services.php`,
  boot order in `config/hooks.php`, defaults in `config/defaults.php`.
- **Domain**: `src/Service/OrderFeed.php` (privacy-safe feed from orders, cached),
  `src/Service/FrontendService.php` (scope + enqueue), `src/Settings/SettingsRepository.php`
  (read/default/sanitise), `src/Admin/Settings.php` (WooCommerce submenu page).
- **Quality**: PHPCS (WPCS security rules) + PHPStan level 6; CI runs Plugin Check.

## PRO companion

[`wppoland/proof-pro`](https://github.com/wppoland/proof-pro) (private) hooks
`add_action('proof/booted', …)` to add premium features.

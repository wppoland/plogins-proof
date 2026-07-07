=== Plogins Proof - Social Proof for WooCommerce ===
Contributors: motylanogha
Tags: woocommerce, social proof, sales notification, popup, fomo
Requires at least: 6.5
Tested up to: 7.0
Requires PHP: 8.1
Stable tag: 1.0.1
Requires Plugins: woocommerce
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Show a small corner popup of recent WooCommerce sales. Real orders only, first name and city only, no jQuery, no layout shift.

== Description ==

Proof shows a small popup in a corner of your storefront that names a recent purchase, for example "Alex from Berlin bought Hoodie 2 hours ago". The popup is built from orders that actually happened, so visitors see real activity rather than invented counters.

Each popup carries only two pieces of customer data: the billing first name and the billing city. Surnames, emails, full addresses and order numbers never leave the server. When an order has no first name, Proof substitutes a word you choose (the default is "Someone").

If there are no completed or processing orders in the last 30 days, Proof loads nothing at all. No popup, no script, no empty widget.

The front-end script is plain JavaScript with no dependencies. It loads `defer` in the footer, and the popup sits in a fixed corner so it never reflows the page or adds to Cumulative Layout Shift. The order query runs at most once every five minutes and the result is stored in a transient, so a busy storefront does not re-query orders on every page view.

For screen reader users the popup is a `role="status"` region with `aria-live="polite"`, so each notification is announced without grabbing focus. The dismiss button is a real button with a visible focus ring, focus is never trapped, and the styling follows `prefers-reduced-motion` and `prefers-color-scheme: dark`.

What you can configure under WooCommerce -> Proof:

* On/off master switch
* Which of the four corners the popup appears in
* The fallback word used when an order has no first name
* Initial delay before the first popup, how long each popup stays, and the gap between popups

It declares compatibility with WooCommerce High-Performance Order Storage (HPOS) and the Cart and Checkout blocks.

Source and issue tracker: the code lives at https://github.com/wppoland/plogins-proof. Bug reports and patches are welcome there.

== Installation ==

1. Install and activate WooCommerce 8.0 or later.
2. Upload the `proof` folder to `/wp-content/plugins/`, or install the zip from Plugins -> Add New -> Upload Plugin.
3. Activate Proof on the Plugins screen.
4. Open WooCommerce -> Proof to pick a corner and adjust timing. The defaults are reasonable, so you can leave them as they are.
5. Once you have completed or processing orders from the last 30 days, popups start appearing on the storefront.

== Frequently Asked Questions ==

= Documentation and links =

* **Documentation** - https://plogins.com/plogins-proof/docs/
* **Plugin page** - https://plogins.com/plogins-proof/
* **Source code** - https://github.com/wppoland/plogins-proof
* **Bug reports and feature requests** - https://github.com/wppoland/plogins-proof/issues


= Does it show fake sales? =

No. Every popup comes from a real WooCommerce order. With no qualifying orders, nothing is shown.

= What customer data ends up in the browser? =

Only the billing first name and billing city. Surnames, emails, addresses and order numbers stay on the server and are never sent to the page.

= Which orders does it use? =

Up to the 40 most recent orders with the status "completed" or "processing", limited to roughly the last 30 days.

= Will it slow my store down or shift the layout? =

The script is small, dependency-free, and deferred to the footer; the order data is cached in a transient; and the popup is pinned to a corner, so it does not move other content. There is no measurable layout shift.

= Is it usable with a screen reader or keyboard? =

Yes. Notifications are announced through an `aria-live` region, the dismiss button is keyboard reachable with a visible focus ring, focus is never trapped, and animation is dropped when `prefers-reduced-motion` is set.

= How do I remove everything on uninstall? =

Deleting Proof from the Plugins screen removes its two options (`proof_settings` and `proof_db_version`) and the cached feed. It creates no custom tables and does not touch your order data.


= Does this plugin work on WordPress Multisite? =

Yes. This plugin is compatible with WordPress Multisite. Network activate it or activate it on individual sites; each site keeps its own settings and data.

== External Services ==

Proof does not contact any external service. The popups are built from your own WooCommerce orders and the data stays on your site.

== Screenshots ==

1. A recent-sale popup in the corner of the storefront.
2. The Proof settings screen under WooCommerce -> Proof.

== Changelog ==

= 1.0.1 =
* First stable release.

= 0.1.1 =
* Renamed to Plogins Proof for WooCommerce for a more distinctive plugin name.

= 0.1.0 =
* First release: corner popups built from recent completed and processing orders, showing first name and city only. Configurable corner, fallback name and timing (delay, display time, interval). HPOS and Cart/Checkout blocks compatible.
</content>
</invoke>

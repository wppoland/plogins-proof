=== Proof - Sales Notifications for WooCommerce ===
Contributors: wppoland
Tags: woocommerce, social proof, sales notification, popup, fomo
Requires at least: 6.5
Tested up to: 7.0
Requires PHP: 8.1
Stable tag: 0.1.0
Requires Plugins: woocommerce
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Show recent-sale social-proof popups built from real WooCommerce orders. Privacy-safe, accessible, no jQuery, no layout shift.

== Description ==

Proof shows small, tasteful popups in a corner of the screen that surface recent **real** purchases from your store — for example, "Alex from Berlin bought Hoodie 2 hours ago". Genuine recent activity builds trust and a gentle sense of urgency, without fake numbers.

**Privacy first.** Each popup only ever shows a customer's **first name** and **billing city** — never surnames, emails, full addresses, order numbers or any other personal data. You choose which of those fields appear, and you can replace a missing first name with a neutral fallback like "Someone".

**Real orders only.** Popups are built from your recent completed and processing WooCommerce orders. Demo/placeholder data is **off by default**; if there are no qualifying orders, Proof simply shows nothing rather than inventing sales.

**Fast and unobtrusive.**

* **No jQuery.** A tiny vanilla-JavaScript widget, loaded `defer` in the footer.
* **No layout shift.** The popup is fixed to a screen corner and never reflows page content, so it does not hurt Cumulative Layout Shift.
* **Cached feed.** The order query runs at most once every few minutes via a transient, never on every page load.

**Accessible.**

* The popup lives in an `aria-live="polite"` status region, so screen readers announce each notification without stealing focus.
* It never traps focus and never blocks page content.
* A keyboard-focusable dismiss button with a visible focus ring.
* Motion is reduced automatically when the visitor prefers reduced motion.
* Dark-mode aware.

**Features**

* Recent-sale popups from real WooCommerce orders (completed & processing)
* Privacy-safe: first name + city only, every field individually toggleable
* Choose the screen corner (any of the four)
* Configurable initial delay, display time and interval between popups
* Frequency cap (max popups per page view)
* Limit where popups appear: whole storefront, shop/archives/products, or single products only
* Maximum order age and maximum number of orders to draw from
* Optional demo data for previewing on a brand-new store (off by default)
* Clean, dark-mode-aware settings screen under WooCommerce → Proof
* Compatible with WooCommerce HPOS (Custom Order Tables) and Cart/Checkout Blocks

== Installation ==

1. Install and activate WooCommerce (8.0 or later).
2. Install Proof from the WordPress plugin directory, or upload the `proof` folder to `/wp-content/plugins/`.
3. Activate the plugin through the **Plugins** screen.
4. Visit **WooCommerce → Proof** to choose the corner, fields and timing. Sensible defaults work out of the box.
5. Popups appear automatically once you have qualifying recent orders.

== Frequently Asked Questions ==

= Is Proof free? =
Yes. Proof is free and licensed under the GPL.

= Does Proof require WooCommerce? =
Yes. Proof is a WooCommerce extension and requires WooCommerce 8.0 or later. It shows an admin notice and stays inactive if WooCommerce is missing.

= What personal data is shown in a popup? =
Only a customer's first name and billing city, and only the fields you enable. Surnames, emails, full addresses and order numbers are never exposed to the browser.

= Does it show fake sales? =
No. By default Proof only shows real orders. There is an optional demo-data mode for previewing on a new store; it is off by default and only ever activates when there are no real qualifying orders.

= Which orders are used? =
Recent orders with the status "completed" or "processing", newer than your configured maximum age, up to your configured maximum count.

= Will it slow down my store or cause layout shift? =
No. The popup is a small vanilla-JS widget loaded `defer` in the footer, the order data is cached in a transient, and the popup is fixed to a screen corner so it never pushes content around.

= Is it accessible? =
Yes. Notifications are announced via an `aria-live` region, the dismiss button is keyboard-accessible with a visible focus ring, focus is never trapped, and animations respect `prefers-reduced-motion`.

= How do I remove all plugin data? =
Deleting the plugin from the **Plugins** screen removes the `proof_settings` and `proof_db_version` options and the cached feed. Proof creates no custom database tables.

== External Services ==

Proof does not connect to any external services. All data comes from your own WooCommerce orders and stays in your WordPress site.

== Screenshots ==

1. A recent-sale popup in the corner of the storefront.
2. The Proof settings screen under WooCommerce → Proof.

== Changelog ==

= 0.1.0 =
* Initial release: privacy-safe recent-sale popups from real WooCommerce orders, with configurable fields, timing, position, scope and frequency cap.

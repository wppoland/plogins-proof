<?php

declare(strict_types=1);

namespace Proof\Admin;

defined('ABSPATH') || exit;

use Proof\Contract\HasHooks;
use Proof\Service\OrderFeed;
use Proof\Settings\SettingsRepository;

/**
 * WooCommerce submenu settings page for Proof.
 *
 * Stores everything in the single `proof_settings` option (array). All input is
 * sanitised through {@see SettingsRepository::sanitize()}; all output is escaped
 * at the point of echo. The form is nonce-protected and the page requires the
 * `manage_woocommerce` capability.
 */
final class Settings implements HasHooks
{
    private const PAGE  = 'proof-settings';
    private const GROUP = 'proof_settings_group';

    private SettingsRepository $settings;

    public function __construct(SettingsRepository $settings)
    {
        $this->settings = $settings;
    }

    public function registerHooks(): void
    {
        add_action('admin_menu', [$this, 'addMenuPage']);
        add_action('admin_init', [$this, 'registerSettings']);
        add_action('admin_enqueue_scripts', [$this, 'enqueueAssets']);
    }

    public function addMenuPage(): void
    {
        add_submenu_page(
            'woocommerce',
            __('Proof — Sales Notifications', 'proof'),
            __('Proof', 'proof'),
            'manage_woocommerce',
            self::PAGE,
            [$this, 'renderPage'],
        );
    }

    public function registerSettings(): void
    {
        register_setting(
            self::GROUP,
            SettingsRepository::OPTION,
            [
                'type'              => 'array',
                'sanitize_callback' => [$this, 'sanitizeAndFlush'],
                'default'           => $this->settings->defaults(),
            ],
        );
    }

    /**
     * Sanitise on save and drop the cached feed so changes apply immediately.
     *
     * @param mixed $raw
     * @return array<string, mixed>
     */
    public function sanitizeAndFlush(mixed $raw): array
    {
        $clean = $this->settings->sanitize($raw);
        OrderFeed::flushCache();

        return $clean;
    }

    public function enqueueAssets(string $hookSuffix): void
    {
        if ($hookSuffix !== 'woocommerce_page_' . self::PAGE) {
            return;
        }

        wp_enqueue_style(
            'proof-admin',
            \Proof\Plugin::instance()->url('assets/css/admin.css'),
            [],
            \Proof\VERSION,
        );
    }

    public function renderPage(): void
    {
        if (! current_user_can('manage_woocommerce')) {
            return;
        }

        $s = $this->settings->all();

        echo '<div class="wrap proof-settings">';
        echo '<h1>' . esc_html__('Proof — Sales Notifications', 'proof') . '</h1>';
        echo '<p class="proof-intro">' . esc_html__('Show small popups of recent real purchases to build trust and urgency. Only a first name and city are ever shown — never full names, emails or addresses.', 'proof') . '</p>';

        echo '<form action="' . esc_url(admin_url('options.php')) . '" method="post" class="proof-form">';
        settings_fields(self::GROUP);

        $this->sectionGeneral($s);
        $this->sectionFields($s);
        $this->sectionTiming($s);
        $this->sectionSource($s);

        submit_button(__('Save changes', 'proof'));
        echo '</form>';
        echo '</div>';
    }

    /**
     * @param array<string, mixed> $s
     */
    private function sectionGeneral(array $s): void
    {
        echo '<div class="proof-card">';
        echo '<h2>' . esc_html__('General', 'proof') . '</h2>';
        echo '<table class="form-table" role="presentation"><tbody>';

        $this->checkboxRow(
            'enabled',
            __('Enable Proof', 'proof'),
            __('Master switch. When off, no popups are loaded or rendered anywhere on the storefront.', 'proof'),
            (bool) $s['enabled'],
        );

        $this->selectRow(
            'display_scope',
            __('Show on', 'proof'),
            [
                'all'     => __('Entire storefront', 'proof'),
                'shop'    => __('Shop, product archives & product pages', 'proof'),
                'product' => __('Single product pages only', 'proof'),
            ],
            (string) $s['display_scope'],
            __('Limit where popups appear. "Shop" covers the shop page, category/tag archives and single products.', 'proof'),
        );

        $this->selectRow(
            'position',
            __('Screen corner', 'proof'),
            [
                'bottom-left'  => __('Bottom left', 'proof'),
                'bottom-right' => __('Bottom right', 'proof'),
                'top-left'     => __('Top left', 'proof'),
                'top-right'    => __('Top right', 'proof'),
            ],
            (string) $s['position'],
            __('Which corner of the screen the popup slides in from.', 'proof'),
        );

        echo '</tbody></table>';
        echo '</div>';
    }

    /**
     * @param array<string, mixed> $s
     */
    private function sectionFields(array $s): void
    {
        echo '<div class="proof-card">';
        echo '<h2>' . esc_html__('What each popup shows', 'proof') . '</h2>';
        echo '<table class="form-table" role="presentation"><tbody>';

        $this->checkboxRow('show_name', __('Customer first name', 'proof'), __('Show the buyer\'s first name (e.g. "Alex"). Surnames are never shown.', 'proof'), (bool) $s['show_name']);
        $this->checkboxRow('show_city', __('City', 'proof'), __('Show the billing city only (e.g. "Berlin"). Street address and country are never shown.', 'proof'), (bool) $s['show_city']);
        $this->checkboxRow('show_product', __('Product name', 'proof'), __('Show the name of the purchased product.', 'proof'), (bool) $s['show_product']);
        $this->checkboxRow('show_time', __('Time ago', 'proof'), __('Show how long ago the purchase happened (e.g. "2 hours ago").', 'proof'), (bool) $s['show_time']);

        $this->textRow(
            'anonymous_name_text',
            __('Fallback name', 'proof'),
            (string) $s['anonymous_name_text'],
            __('Shown in place of a first name when the order has none. Defaults to "Someone".', 'proof'),
        );

        echo '</tbody></table>';
        echo '</div>';
    }

    /**
     * @param array<string, mixed> $s
     */
    private function sectionTiming(array $s): void
    {
        echo '<div class="proof-card">';
        echo '<h2>' . esc_html__('Timing', 'proof') . '</h2>';
        echo '<table class="form-table" role="presentation"><tbody>';

        $this->numberRow('initial_delay', __('Initial delay (seconds)', 'proof'), (int) $s['initial_delay'], 0, 120, __('How long to wait after the page loads before the first popup appears.', 'proof'));
        $this->numberRow('display_time', __('Display time (seconds)', 'proof'), (int) $s['display_time'], 2, 60, __('How long each popup stays on screen.', 'proof'));
        $this->numberRow('interval', __('Interval between popups (seconds)', 'proof'), (int) $s['interval'], 3, 600, __('Gap between one popup disappearing and the next appearing.', 'proof'));
        $this->numberRow('max_per_session', __('Max popups per page view', 'proof'), (int) $s['max_per_session'], 0, 100, __('Frequency cap: stop after this many popups on a single page view. Set 0 for unlimited.', 'proof'));

        echo '</tbody></table>';
        echo '</div>';
    }

    /**
     * @param array<string, mixed> $s
     */
    private function sectionSource(array $s): void
    {
        echo '<div class="proof-card">';
        echo '<h2>' . esc_html__('Source data', 'proof') . '</h2>';
        echo '<table class="form-table" role="presentation"><tbody>';

        $this->numberRow('max_age_days', __('Maximum order age (days)', 'proof'), (int) $s['max_age_days'], 1, 365, __('Only purchases newer than this are eligible to be shown.', 'proof'));
        $this->numberRow('max_orders', __('Maximum orders to pull', 'proof'), (int) $s['max_orders'], 1, 200, __('How many recent orders to draw the rotation from.', 'proof'));

        $this->checkboxRow(
            'fake_data',
            __('Use demo data when no real orders exist', 'proof'),
            __('Off by default. When on, neutral placeholder popups are shown only if there are no qualifying real orders — useful for previewing on a new store. Turn off for production.', 'proof'),
            (bool) $s['fake_data'],
        );

        echo '</tbody></table>';
        echo '</div>';
    }

    private function fieldName(string $key): string
    {
        return SettingsRepository::OPTION . '[' . $key . ']';
    }

    private function checkboxRow(string $key, string $label, string $help, bool $checked): void
    {
        $id = 'proof_' . $key;
        echo '<tr><th scope="row">' . esc_html($label) . '</th><td>';
        echo '<label class="proof-toggle" for="' . esc_attr($id) . '">';
        echo '<input type="checkbox" id="' . esc_attr($id) . '" name="' . esc_attr($this->fieldName($key)) . '" value="1" ' . checked($checked, true, false) . ' aria-describedby="' . esc_attr($id . '_help') . '" />';
        echo '<span>' . esc_html__('Enabled', 'proof') . '</span>';
        echo '</label>';
        echo '<p class="description" id="' . esc_attr($id . '_help') . '">' . esc_html($help) . '</p>';
        echo '</td></tr>';
    }

    private function textRow(string $key, string $label, string $value, string $help): void
    {
        $id = 'proof_' . $key;
        echo '<tr><th scope="row"><label for="' . esc_attr($id) . '">' . esc_html($label) . '</label></th><td>';
        echo '<input type="text" class="regular-text" id="' . esc_attr($id) . '" name="' . esc_attr($this->fieldName($key)) . '" value="' . esc_attr($value) . '" aria-describedby="' . esc_attr($id . '_help') . '" />';
        echo '<p class="description" id="' . esc_attr($id . '_help') . '">' . esc_html($help) . '</p>';
        echo '</td></tr>';
    }

    private function numberRow(string $key, string $label, int $value, int $min, int $max, string $help): void
    {
        $id = 'proof_' . $key;
        echo '<tr><th scope="row"><label for="' . esc_attr($id) . '">' . esc_html($label) . '</label></th><td>';
        echo '<input type="number" class="small-text" id="' . esc_attr($id) . '" name="' . esc_attr($this->fieldName($key)) . '" value="' . esc_attr((string) $value) . '" min="' . esc_attr((string) $min) . '" max="' . esc_attr((string) $max) . '" step="1" aria-describedby="' . esc_attr($id . '_help') . '" />';
        echo '<p class="description" id="' . esc_attr($id . '_help') . '">' . esc_html($help) . '</p>';
        echo '</td></tr>';
    }

    /**
     * @param array<string, string> $options
     */
    private function selectRow(string $key, string $label, array $options, string $current, string $help): void
    {
        $id = 'proof_' . $key;
        echo '<tr><th scope="row"><label for="' . esc_attr($id) . '">' . esc_html($label) . '</label></th><td>';
        echo '<select id="' . esc_attr($id) . '" name="' . esc_attr($this->fieldName($key)) . '" aria-describedby="' . esc_attr($id . '_help') . '">';
        foreach ($options as $value => $text) {
            echo '<option value="' . esc_attr($value) . '" ' . selected($current, $value, false) . '>' . esc_html($text) . '</option>';
        }
        echo '</select>';
        echo '<p class="description" id="' . esc_attr($id . '_help') . '">' . esc_html($help) . '</p>';
        echo '</td></tr>';
    }
}

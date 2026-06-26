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
            __('Proof: Sales Notifications', 'proof'),
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
        echo '<h1>' . esc_html__('Proof: Sales Notifications', 'proof') . '</h1>';
        echo '<p class="proof-intro">' . esc_html__('Show small popups of recent real purchases to build trust and urgency. Only a first name and city are ever shown, never full names, emails or addresses.', 'proof') . '</p>';

        echo '<form action="' . esc_url(admin_url('options.php')) . '" method="post" class="proof-form">';
        settings_fields(self::GROUP);

        $this->sectionGeneral($s);
        $this->sectionFields($s);
        $this->sectionTiming($s);

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
        echo '<p class="description">' . esc_html__('Each popup shows the buyer\'s first name, billing city, the product name and how long ago the purchase happened. Surnames, emails and full addresses are never shown.', 'proof') . '</p>';

        $this->previewExample();

        echo '<table class="form-table" role="presentation"><tbody>';

        $this->textRow(
            'anonymous_name_text',
            __('Fallback name', 'proof'),
            (string) $s['anonymous_name_text'],
            /* translators: %s is the default fallback word shown when an order has no first name. */
            sprintf(__('Shown in place of a first name when the order has none. Leave blank to use the default, %s.', 'proof'), '“Someone”'),
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

        $this->numberRow('initial_delay', __('Initial delay (seconds)', 'proof'), (int) $s['initial_delay'], 0, 120, __('How long to wait after the page loads before the first popup appears. Default 5 seconds.', 'proof'));
        $this->numberRow('display_time', __('Display time (seconds)', 'proof'), (int) $s['display_time'], 2, 60, __('How long each popup stays on screen before sliding away. Default 6 seconds.', 'proof'));
        $this->numberRow('interval', __('Interval between popups (seconds)', 'proof'), (int) $s['interval'], 3, 600, __('Gap between one popup disappearing and the next appearing. Lower values show more popups; higher values feel calmer. Default 12 seconds.', 'proof'));

        echo '</tbody></table>';
        echo '</div>';
    }

    /**
     * A small, static facsimile of a live popup so admins see the exact shape
     * and wording before saving — show, don't just describe.
     */
    private function previewExample(): void
    {
        echo '<figure class="proof-preview">';
        echo '<figcaption class="proof-preview__label">' . esc_html__('Example', 'proof') . '</figcaption>';
        echo '<div class="proof-preview__slip" aria-hidden="true">';
        echo '<span class="proof-preview__seal">';
        // Inline check mark; decorative, hidden from assistive tech via parent aria-hidden.
        echo '<svg viewBox="0 0 20 20" width="13" height="13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 10.5l4 4 8-9" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>';
        echo '</span>';
        echo '<span class="proof-preview__body">';
        echo '<span class="proof-preview__text"><strong>' . esc_html__('Alex from Berlin', 'proof') . '</strong> ' . esc_html__('bought Merino Hoodie', 'proof') . '</span>';
        echo '<span class="proof-preview__time">' . esc_html__('2 hours ago', 'proof') . '</span>';
        echo '</span>';
        echo '</div>';
        echo '</figure>';
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

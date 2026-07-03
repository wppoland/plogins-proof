<?php

declare(strict_types=1);

namespace Proof\Admin;

defined('ABSPATH') || exit;

/**
 * PRO upgrade promotion, shown ONLY on the Proof settings screen: a dismissible
 * top banner, a sidebar promo panel, and a "what PRO adds" locked-card list.
 *
 * It is pure advertising: no disabled form fields, nothing blocks a free
 * workflow, it is scoped to this one screen and the banner is dismissible per
 * user. That keeps it inside the WordPress.org guidelines (no admin hijacking,
 * no trialware). Content comes from config/pro-upsell.php, generated from the
 * plogins.com registry, so the feature copy always matches the real PRO edition.
 */
final class ProUpsell
{
    private const META   = 'proof_pro_banner_dismissed';
    private const ACTION = 'proof_dismiss_pro';

    /** @var array<string, mixed>|null */
    private ?array $data = null;

    public function registerHooks(): void
    {
        add_action('admin_post_' . self::ACTION, [$this, 'handleDismiss']);
    }

    /** @return array<string, mixed> */
    private function data(): array
    {
        if ($this->data === null) {
            $file = PROOF_DIR . 'config/pro-upsell.php';
            $this->data = is_readable($file) ? (array) require $file : [];
        }
        return $this->data;
    }

    /** Whether to render the promo at all (filterable for white-label builds). */
    public function enabled(): bool
    {
        /**
         * Filters whether the Proof PRO promo is shown on the settings screen.
         *
         * @param bool $show Default true.
         */
        return (bool) apply_filters('proof/show_pro_cta', true) && $this->features() !== [];
    }

    private function url(): string
    {
        $default = (string) ($this->data()['url'] ?? 'https://plogins.com/plogins-proof-pro/pricing/');
        /**
         * Filters the URL the "Upgrade to PRO" buttons point at.
         *
         * @param string $url Default the Proof PRO pricing page.
         */
        return (string) apply_filters('proof/pro_url', $default);
    }

    private function isPolish(): bool
    {
        return str_starts_with((string) get_locale(), 'pl');
    }

    private function priceLabel(): string
    {
        $d = $this->data();
        if ($this->isPolish() && ! empty($d['price_pln'])) {
            /* translators: %d: yearly price in PLN */
            return sprintf(__('od %d zł/rok', 'plogins-proof'), (int) $d['price_pln']);
        }
        if (! empty($d['price_from'])) {
            $cur = ($d['currency'] ?? 'EUR') === 'EUR' ? '€' : (string) $d['currency'] . ' ';
            /* translators: 1: currency symbol, 2: yearly price */
            return sprintf(__('from %1$s%2$d/yr', 'plogins-proof'), $cur, (int) $d['price_from']);
        }
        return '';
    }

    /** @return array<int, array{title: string, desc: string}> */
    private function features(): array
    {
        $lang = $this->isPolish() ? 'pl' : 'en';
        $out  = [];
        foreach ((array) ($this->data()['features'] ?? []) as $f) {
            $x = is_array($f) ? ($f[$lang] ?? $f['en'] ?? null) : null;
            if (is_array($x) && ! empty($x['title'])) {
                $out[] = ['title' => (string) $x['title'], 'desc' => (string) ($x['desc'] ?? '')];
            }
        }
        return $out;
    }

    public function bannerDismissed(): bool
    {
        return (bool) get_user_meta(get_current_user_id(), self::META, true);
    }

    private function dismissUrl(): string
    {
        return wp_nonce_url(admin_url('admin-post.php?action=' . self::ACTION), self::ACTION);
    }

    public function handleDismiss(): void
    {
        if (! current_user_can('manage_woocommerce')) {
            wp_die(esc_html__('Permission denied.', 'plogins-proof'));
        }
        check_admin_referer(self::ACTION);
        update_user_meta(get_current_user_id(), self::META, 1);
        wp_safe_redirect(wp_get_referer() ?: admin_url('admin.php?page=proof-settings'));
        exit;
    }

    /* ------------------------------------------------------------------ */
    /* Render pieces                                                       */
    /* ------------------------------------------------------------------ */

    /** Dismissible strip at the top of the settings screen. */
    public function banner(): void
    {
        if (! $this->enabled() || $this->bannerDismissed()) {
            return;
        }
        $name     = (string) ($this->data()['name'] ?? 'Proof Pro');
        $price    = $this->priceLabel();
        $subtitle = implode(', ', array_slice(array_map(
            static fn (array $f): string => $f['title'],
            $this->features(),
        ), 0, 3));
        ?>
        <div class="proof-pro-banner" role="note">
            <span class="proof-pro-banner__tag">PRO</span>
            <p class="proof-pro-banner__text">
                <strong><?php
                /* translators: %s: PRO edition name */
                printf(esc_html__('Do more with %s', 'plogins-proof'), esc_html($name)); ?></strong>
                <?php if ($subtitle !== '') : ?><span class="proof-pro-banner__sub"><?php echo esc_html($subtitle); ?></span><?php endif; ?>
                <?php if ($price !== '') : ?><span class="proof-pro-banner__price"><?php echo esc_html($price); ?></span><?php endif; ?>
            </p>
            <a class="button button-primary proof-pro-banner__cta" href="<?php echo esc_url($this->url()); ?>" target="_blank" rel="noopener noreferrer">
                <?php esc_html_e('Upgrade to PRO', 'plogins-proof'); ?>
            </a>
            <a class="proof-pro-banner__dismiss" href="<?php echo esc_url($this->dismissUrl()); ?>" aria-label="<?php esc_attr_e('Dismiss this notice', 'plogins-proof'); ?>">&times;</a>
        </div>
        <?php
    }

    /** Sidebar promo panel (sits in the settings two-column layout). */
    public function aside(): void
    {
        if (! $this->enabled()) {
            return;
        }
        $name     = (string) ($this->data()['name'] ?? 'Proof Pro');
        $price    = $this->priceLabel();
        $features = $this->features();
        ?>
        <aside class="proof-card proof-pro-aside" aria-labelledby="proof-pro-aside-h">
            <p class="proof-pro-aside__eyebrow"><?php echo esc_html($name); ?></p>
            <h2 id="proof-pro-aside-h" class="proof-pro-aside__heading"><?php esc_html_e('Unlock every PRO feature', 'plogins-proof'); ?></h2>
            <ul class="proof-pro-aside__list">
                <?php foreach ($features as $f) : ?>
                    <li>
                        <span class="proof-pro-aside__lock" aria-hidden="true"></span>
                        <span><?php echo esc_html($f['title']); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
            <a class="button button-primary button-hero proof-pro-aside__cta" href="<?php echo esc_url($this->url()); ?>" target="_blank" rel="noopener noreferrer">
                <?php esc_html_e('Upgrade to PRO', 'plogins-proof'); ?>
            </a>
            <?php if ($price !== '') : ?>
                <p class="proof-pro-aside__price"><?php echo esc_html($price); ?> · <?php esc_html_e('one licence, every PRO feature', 'plogins-proof'); ?></p>
            <?php endif; ?>
        </aside>
        <?php
    }

    /** "What PRO adds" locked-card grid, appended after the settings form. */
    public function cards(): void
    {
        if (! $this->enabled()) {
            return;
        }
        $features = $this->features();
        $name     = (string) ($this->data()['name'] ?? 'Proof Pro');
        ?>
        <section class="proof-pro-cards" aria-labelledby="proof-pro-cards-h">
            <h2 id="proof-pro-cards-h" class="proof-pro-cards__title">
                <?php
                /* translators: %s: PRO edition name */
                printf(esc_html__('What %s adds', 'plogins-proof'), esc_html($name)); ?>
            </h2>
            <div class="proof-pro-cards__grid">
                <?php foreach ($features as $f) : ?>
                    <article class="proof-pro-card">
                        <span class="proof-pro-card__badge">PRO</span>
                        <span class="proof-pro-card__lock" aria-hidden="true"></span>
                        <h3 class="proof-pro-card__title"><?php echo esc_html($f['title']); ?></h3>
                        <?php if ($f['desc'] !== '') : ?>
                            <p class="proof-pro-card__desc"><?php echo esc_html($f['desc']); ?></p>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
        <?php
    }
}

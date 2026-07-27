<?php
/**
 * PRO upsell content, generated from the plogins.com registry by
 * scripts/gen-pro-upsell.mjs. The admin upsell renders this; curate the
 * feature list to fit this plugin's settings screen (do not invent features).
 *
 * @package plogins-proof-pro
 */

defined('ABSPATH') || exit;

return [
    'name'       => 'Proof Pro',
    'url'        => 'https://plogins.com/plogins-proof-pro/pricing/',
    'sellable'   => true,
    'price_from' => 19,
    'currency'   => 'EUR',
    'price_pln'  => 85,
    'lead'       => [
        'en' => 'The features below ship in the current PRO release.',
        'pl' => 'Poniższe funkcje są dostępne w bieżącym wydaniu PRO.',
    ],
    'features'   => [
        [
            'en' => ['title' => 'Recent-review popups', 'desc' => 'Recent, approved product reviews mixed into the social-proof rotation alongside the recent-sale popups.'],
            'pl' => ['title' => 'Powiadomienia o opiniach', 'desc' => 'Niedawne, zatwierdzone opinie o produktach mieszane do rotacji social proof obok powiadomień o sprzedaży.'],
        ],
        [
            'en' => ['title' => 'Privacy-safe', 'desc' => 'Only a reviewer\'s first name and the product name are ever shown, never the review text or email.'],
            'pl' => ['title' => 'Bezpieczne dla prywatności', 'desc' => 'Pokazywane jest tylko imię recenzenta i nazwa produktu, nigdy treść opinii ani e-mail.'],
        ],
        [
            'en' => ['title' => 'Minimum-rating filter', 'desc' => 'Only show reviews of N stars or more.'],
            'pl' => ['title' => 'Filtr minimalnej oceny', 'desc' => 'Pokazuj tylko opinie o N gwiazdkach lub więcej.'],
        ],
        [
            'en' => ['title' => 'Review window', 'desc' => 'A configurable maximum review count and maximum review age.'],
            'pl' => ['title' => 'Okno opinii', 'desc' => 'Konfigurowalna maksymalna liczba opinii i maksymalny wiek opinii.'],
        ],
        [
            'en' => ['title' => 'Cached feed, real data', 'desc' => 'A transient avoids extra queries on every page load; built entirely on real WooCommerce review data.'],
            'pl' => ['title' => 'Buforowany feed, prawdziwe dane', 'desc' => 'Transient zamiast dodatkowych zapytań przy każdym wczytaniu; budowane wyłącznie na prawdziwych danych opinii.'],
        ],
    ],
];

=== Plogins Proof - Social Proof for WooCommerce ===
Contributors: motylanogha
Tags: woocommerce, social proof, sales notification, popup, fomo
Requires at least: 6.5
Tested up to: 7.0
Requires PHP: 8.1
Stable tag: 1.0.2
Requires Plugins: woocommerce
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Pokaż małe wyskakujące okienko w rogu z najnowszą sprzedażą WooCommerce. Tylko prawdziwe zamówienia, tylko imię i miasto, bez jQuery, bez przeskoków układu.

== Description ==

Proof pokazuje małe wyskakujące okienko w rogu Twojego sklepu z nazwą ostatniego zakupu, na przykład „Alex z Berlina kupił bluzę z kapturem 2 godziny temu”. Wyskakujące okienko powstaje na podstawie faktycznie złożonych zamówień, więc odwiedzający widzą rzeczywistą aktywność, a nie zmyślone liczniki.

Każde wyskakujące okienko zawiera tylko dwie informacje o kliencie: imię i miasto z danych rozliczeniowych. Nazwiska, adresy e-mail, pełne adresy i numery zamówień nigdy nie opuszczają serwera. Gdy zamówienie nie ma imienia, Proof zastępuje je wybranym przez Ciebie słowem (domyślnie „Ktoś”).

Jeśli w ciągu ostatnich 30 dni nie ma żadnych zrealizowanych ani przetwarzanych zamówień, Proof nie ładuje niczego. Żadnego wyskakującego okienka, żadnego skryptu, żadnego pustego widżetu.

Skrypt front-endu to zwykły JavaScript bez zależności. Wczytuje się z atrybutem `defer` w stopce, a wyskakujące okienko znajduje się w stałym rogu, więc nigdy nie przebudowuje strony ani nie zwiększa skumulowanego przesunięcia układu (CLS). Zapytanie o zamówienia wykonuje się najwyżej raz na pięć minut, a wynik jest zapisywany w transiencie, więc obłożony sklep nie odpytuje zamówień przy każdym wyświetleniu strony.

Dla użytkowników czytników ekranu wyskakujące okienko to region `role="status"` z `aria-live="polite"`, więc każde powiadomienie jest ogłaszane bez przejmowania fokusu. Przycisk odrzucenia to prawdziwy przycisk z widocznym obramowaniem fokusu, fokus nigdy nie jest uwięziony, a styl uwzględnia `prefers-reduced-motion` i `prefers-color-scheme: dark`.

Co możesz skonfigurować w WooCommerce -> Proof:

* Główny włącznik/wyłącznik
* W którym z czterech rogów pojawia się wyskakujące okienko
* Słowo zastępcze używane, gdy zamówienie nie ma imienia
* Początkowe opóźnienie przed pierwszym wyskakującym okienkiem, czas wyświetlania każdego okienka oraz przerwa między okienkami

Deklaruje zgodność z WooCommerce High-Performance Order Storage (HPOS) oraz blokami koszyka i kasy.

Kod źródłowy i zgłaszanie problemów: kod znajduje się pod adresem https://github.com/wppoland/plogins-proof. Zgłoszenia błędów i poprawki są tam mile widziane.

== Installation ==

1. Zainstaluj i włącz WooCommerce 8.0 lub nowsze.
2. Prześlij folder `proof` do `/wp-content/plugins/` lub zainstaluj plik zip przez Wtyczki -> Dodaj nową -> Wyślij wtyczkę na serwer.
3. Włącz Proof na ekranie Wtyczki.
4. Otwórz WooCommerce -> Proof, aby wybrać róg i dostosować czasy. Wartości domyślne są rozsądne, więc możesz je pozostawić bez zmian.
5. Gdy pojawią się zrealizowane lub przetwarzane zamówienia z ostatnich 30 dni, w sklepie zaczną wyświetlać się wyskakujące okienka.

== Frequently Asked Questions ==

= Documentation and links =

* <strong>Dokumentacja</strong> - https://plogins.com/pl/plogins-proof/docs/
* <strong>Strona wtyczki</strong> - https://plogins.com/pl/plogins-proof/
* <strong>Kod źródłowy</strong> - https://github.com/wppoland/plogins-proof
* <strong>Zgłoszenia błędów i propozycje funkcji</strong> - https://github.com/wppoland/plogins-proof/issues


= Does it show fake sales? =

Nie. Każde wyskakujące okienko pochodzi z prawdziwego zamówienia WooCommerce. Gdy nie ma kwalifikujących się zamówień, nic nie jest wyświetlane.

= What customer data ends up in the browser? =

Tylko imię i miasto z danych rozliczeniowych. Nazwiska, adresy e-mail, adresy i numery zamówień pozostają na serwerze i nigdy nie są wysyłane na stronę.

= Which orders does it use? =

Do 40 najnowszych zamówień ze statusem „zrealizowane” lub „w trakcie realizacji”, ograniczonych do mniej więcej ostatnich 30 dni.

= Will it slow my store down or shift the layout? =

Skrypt jest mały, pozbawiony zależności i przeniesiony do stopki; dane zamówień są buforowane w transiencie; a wyskakujące okienko jest przypięte do rogu, więc nie przesuwa innej zawartości. Nie ma mierzalnego przesunięcia układu.

= Is it usable with a screen reader or keyboard? =

Tak. Powiadomienia są ogłaszane w regionie `aria-live`, przycisk odrzucenia jest dostępny z klawiatury i ma widoczne obramowanie fokusu, fokus nigdy nie jest uwięziony, a animacja jest wyłączana, gdy ustawiono `prefers-reduced-motion`.

= How do I remove everything on uninstall? =

Usunięcie Proof z ekranu Wtyczki usuwa jego dwie opcje (`proof_settings` i `proof_db_version`) oraz buforowany kanał. Nie tworzy niestandardowych tabel i nie narusza danych Twoich zamówień.


= Does this plugin work on WordPress Multisite? =

Tak. Ta wtyczka jest zgodna z WordPress Multisite. Włącz ją w całej sieci lub na poszczególnych witrynach; każda witryna zachowuje własne ustawienia i dane.

== External Services ==

Proof nie kontaktuje się z żadną usługą zewnętrzną. Wyskakujące okienka powstają na podstawie Twoich własnych zamówień WooCommerce, a dane pozostają w Twojej witrynie.

== Screenshots ==

1. Wyskakujące okienko z ostatnią sprzedażą w rogu sklepu.
2. Ekran ustawień Proof w WooCommerce -> Proof.

== Translations ==

Wtyczka Plogins Proof zawiera polskie, niemieckie i hiszpańskie tłumaczenia interfejsu wtyczki. Domena tekstowa to `plogins-proof`, więc pakiety językowe z WordPress.org mogą również nadpisywać lub rozszerzać te dołączone tłumaczenia.

== Changelog ==

= 1.0.2 =
* Dodano dołączone polskie, niemieckie i hiszpańskie tłumaczenia interfejsu wtyczki.

= 1.0.1 =
* Pierwsza stabilna wersja.

= 0.1.1 =
* Zmieniono nazwę na Plogins Proof dla WooCommerce, aby uzyskać bardziej charakterystyczną nazwę wtyczki.

= 0.1.0 =
* Pierwsza wersja: narożne wyskakujące okienka tworzone na podstawie ostatnio zrealizowanych i przetwarzanych zamówień, pokazujące tylko imię i miasto. Konfigurowalny róg, nazwa zastępcza i czasy (opóźnienie, czas wyświetlania, interwał). Zgodne z HPOS oraz blokami koszyka i kasy.
</content>
</invoke>

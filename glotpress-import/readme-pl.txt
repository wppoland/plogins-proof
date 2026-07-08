=== Plogins Proof - Social Proof for WooCommerce ===
Contributors: motylanogha
Tags: woocommerce, social proof, sales notification, popup, fomo
Requires at least: 6.5
Tested up to: 7.0
Requires PHP: 8.1
Stable tag: 1.0.1
Wymaga wtyczek: woocommerce
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Pokaż małe wyskakujące okienko z najnowszymi sprzedażami WooCommerce. Tylko prawdziwe zamówienia, tylko imię i miasto, bez jQuery, bez zmiany układu.

== Description ==

Dowód pokazuje małe wyskakujące okienko w rogu witryny sklepowej z nazwą ostatniego zakupu, na przykład „Aleks z Berlina kupił bluzę z kapturem 2 godziny temu”. Wyskakujące okienko składa się z faktycznie zrealizowanych zamówień, więc odwiedzający widzą rzeczywistą aktywność, a nie wymyślone liczniki.

Każde wyskakujące okienko zawiera tylko dwie części danych klienta: imię i miasto rozliczeniowe. Nazwiska, e-maile, pełne adresy i numery zamówień nigdy nie opuszczają serwera. Jeśli zamówienie nie ma imienia, Proof zastępuje wybrane przez Ciebie słowo (domyślnie jest to „Ktoś”).

Jeśli w ciągu ostatnich 30 dni nie było żadnych ukończonych ani przetwarzanych zamówień, Próba nie ładuje niczego. Żadnego wyskakującego okienka, żadnego skryptu, żadnego pustego widgetu.

Skrypt front-end to zwykły JavaScript bez zależności. Ładuje „odroczenie” w stopce, a wyskakujące okienko znajduje się w ustalonym rogu, więc nigdy nie powoduje ponownego przepływu strony ani nie dodaje skumulowanego przesunięcia układu. Zapytanie o zamówienie jest uruchamiane najwyżej raz na pięć minut, a wynik jest przechowywany tymczasowo, więc zajęta witryna sklepowa nie wysyła ponownego zapytania o zamówienia przy każdym wyświetleniu strony.

Dla użytkowników czytników ekranu wyskakujące okienko to region `role="status"` z `aria-live="polite"`, więc każde powiadomienie jest ogłaszane bez skupiania uwagi. Przycisk odrzucania to prawdziwy przycisk z widocznym pierścieniem ostrości, ostrość nigdy nie jest uwięziona, a styl jest zgodny z „preferuje-ograniczony-ruch” i „preferuje-schemat kolorów: ciemny”.

Co możesz skonfigurować w WooCommerce -> Dowód:

* Główny włącznik/wyłącznik
* W którym z czterech rogów pojawia się wyskakujące okienko
* Słowo zastępcze używane, gdy zamówienie nie ma imienia
* Początkowe opóźnienie przed pierwszym wyskakującym okienkiem, czas trwania każdego wyskakującego okienka i przerwa między wyskakującymi okienkami

Deklaruje kompatybilność z WooCommerce High-Performance Order Storage (HPOS) oraz blokami koszyka i kasy.

Śledzenie źródeł i problemów: kod znajduje się pod adresem https://github.com/wppoland/plogins-proof. Raporty o błędach i poprawki są tam mile widziane.

== Installation ==

1. Zainstaluj i aktywuj WooCommerce 8.0 lub nowszy.
2. Prześlij folder `proof` do `/wp-content/plugins/` lub zainstaluj zip z Wtyczki -> Dodaj nową -> Prześlij wtyczkę.
3. Aktywuj Próbę na ekranie Wtyczki.
4. Otwórz WooCommerce -> Proof, aby wybrać róg i dostosować czas. Wartości domyślne są rozsądne, więc możesz je pozostawić bez zmian.
5. Po skompletowaniu lub przetworzeniu zamówień z ostatnich 30 dni w witrynie sklepu zaczną pojawiać się wyskakujące okienka.

== Frequently Asked Questions ==

= Documentation and links =

* <strong>Dokumentacja</strong> - https://plogins.com/pl/plogins-proof/docs/
* <strong>Strona wtyczki</strong> - https://plogins.com/pl/plogins-proof/
* <strong>Kod źródłowy</strong> - https://github.com/wppoland/plogins-proof
* <strong>Raporty o błędach i prośby o nowe funkcje</strong> - https://github.com/wppoland/plogins-proof/issues


= Does it show fake sales? =

Nie. Każde wyskakujące okienko pochodzi z prawdziwego zamówienia WooCommerce. W przypadku braku kwalifikujących się zamówień nic nie jest wyświetlane.

= What customer data ends up in the browser? =

Tylko imię i miasto rozliczeniowe. Nazwiska, e-maile, adresy i numery zamówień pozostają na serwerze i nigdy nie są wysyłane na stronę.

= Which orders does it use? =

Do 40 najnowszych zamówień ze statusem „zrealizowane” lub „w trakcie realizacji”, ograniczonych do mniej więcej ostatnich 30 dni.

= Will it slow my store down or shift the layout? =

Skrypt jest mały, niezależny i umieszczony w stopce; dane zamówienia są buforowane w trybie przejściowym; a wyskakujące okienko jest przypięte do rogu, więc nie przenosi innej zawartości. Nie ma mierzalnej zmiany układu.

= Is it usable with a screen reader or keyboard? =

Tak. Powiadomienia są ogłaszane poprzez region „aria-live”, przycisk odrzucania jest dostępny z klawiatury za pomocą widocznego pierścienia ostrości, ostrość nigdy nie jest blokowana, a animacja jest przerywana, gdy ustawiona jest opcja „preferuj zmniejszony ruch”.

= How do I remove everything on uninstall? =

Usunięcie Proof z ekranu Wtyczki usuwa jego dwie opcje („proof_settings” i „proof_db_version”) oraz kanał buforowany. Nie tworzy niestandardowych tabel i nie wpływa na dane zamówienia.


= Does this plugin work on WordPress Multisite? =

Tak. Ta wtyczka jest kompatybilna z WordPress Multisite. Aktywuj go w sieci lub aktywuj na poszczególnych stronach; każda witryna przechowuje własne ustawienia i dane.

== External Services ==

Dowód nie kontaktuje się z żadnym serwisem zewnętrznym. Wyskakujące okienka są tworzone na podstawie Twoich własnych zamówień WooCommerce, a dane pozostają w Twojej witrynie.

== Screenshots ==

1. Wyskakujące okienko z ostatnią wyprzedażą w rogu witryny sklepu.
2. Ekran ustawień Proof w WooCommerce -> Proof.

== Changelog ==

= 1.0.1 =
* Pierwsza stabilna wersja.

= 0.1.1 =
* Zmieniono nazwę na Plogins Proof dla WooCommerce, aby uzyskać bardziej charakterystyczną nazwę wtyczki.

= 0.1.0 =
* Pierwsza wersja: narożne wyskakujące okienka utworzone na podstawie ostatnio zrealizowanych i przetwarzanych zamówień, pokazujące tylko imię i miasto. Konfigurowalny narożnik, nazwa zastępcza i czas (opóźnienie, czas wyświetlania, interwał). Kompatybilne z blokami HPOS i Cart/Checkout.
</treść>
</wywołaj>

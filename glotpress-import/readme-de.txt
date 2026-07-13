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

Zeigt ein kleines Eck-Popup der letzten WooCommerce-Verkäufe an. Nur echte Bestellungen, nur Vorname und Stadt, kein jQuery, keine Layoutverschiebung.

== Description ==

Proof zeigt ein kleines Popup in einer Ecke deines Shops, das einen kürzlich getätigten Kauf nennt, zum Beispiel „Alex aus Berlin hat vor 2 Stunden einen Hoodie gekauft“. Das Popup basiert auf tatsächlich erfolgten Bestellungen, sodass Besucher echte Aktivität statt erfundener Zähler sehen.

Jedes Popup enthält nur zwei Kundendaten: den Rechnungs-Vornamen und die Rechnungs-Stadt. Nachnamen, E-Mail-Adressen, vollständige Adressen und Bestellnummern verlassen niemals den Server. Wenn eine Bestellung keinen Vornamen hat, ersetzt Proof ihn durch ein von dir gewähltes Wort (Standard ist „Jemand“).

Wenn es in den letzten 30 Tagen keine abgeschlossenen oder in Bearbeitung befindlichen Bestellungen gibt, lädt Proof überhaupt nichts. Kein Popup, kein Skript, kein leeres Widget.

Das Frontend-Skript ist reines JavaScript ohne Abhängigkeiten. Es wird mit `defer` in der Fußzeile geladen, und das Popup sitzt in einer festen Ecke, sodass es die Seite nie neu umbricht oder zum Cumulative Layout Shift beiträgt. Die Bestellabfrage läuft höchstens einmal alle fünf Minuten, und das Ergebnis wird in einem Transient gespeichert, sodass ein stark besuchter Shop nicht bei jedem Seitenaufruf erneut Bestellungen abfragt.

Für Nutzer von Screenreadern ist das Popup ein `role="status"`-Bereich mit `aria-live="polite"`, sodass jede Benachrichtigung angekündigt wird, ohne den Fokus zu übernehmen. Der Verwerfen-Button ist ein echter Button mit sichtbarem Fokusring, der Fokus wird nie eingefangen, und das Styling berücksichtigt `prefers-reduced-motion` und `prefers-color-scheme: dark`.

Was du unter WooCommerce -> Proof konfigurieren kannst:

* Ein/Aus-Hauptschalter
* In welcher der vier Ecken das Popup erscheint
* Das Ersatzwort, das verwendet wird, wenn eine Bestellung keinen Vornamen hat
* Anfängliche Verzögerung vor dem ersten Popup, wie lange jedes Popup bleibt und der Abstand zwischen den Popups

Es deklariert Kompatibilität mit WooCommerce High-Performance Order Storage (HPOS) sowie den Warenkorb- und Kassen-Blöcken.

Quellcode und Issue-Tracker: Der Code liegt unter https://github.com/wppoland/plogins-proof. Fehlerberichte und Patches sind dort willkommen.

== Installation ==

1. Installiere und aktiviere WooCommerce 8.0 oder höher.
2. Lade den Ordner `proof` nach `/wp-content/plugins/` hoch oder installiere die ZIP-Datei über Plugins -> Installieren -> Plugin hochladen.
3. Aktiviere Proof auf dem Plugins-Bildschirm.
4. Öffne WooCommerce -> Proof, um eine Ecke auszuwählen und das Timing anzupassen. Die Standardeinstellungen sind sinnvoll, du kannst sie also so belassen, wie sie sind.
5. Sobald du abgeschlossene oder in Bearbeitung befindliche Bestellungen aus den letzten 30 Tagen hast, erscheinen Popups im Shop.

== Frequently Asked Questions ==

= Documentation and links =

* <strong>Dokumentation</strong> - https://plogins.com/de/plogins-proof/docs/
* <strong>Plugin-Seite</strong> - https://plogins.com/de/plogins-proof/
* <strong>Quellcode</strong> - https://github.com/wppoland/plogins-proof
* <strong>Fehlerberichte und Funktionswünsche</strong> - https://github.com/wppoland/plogins-proof/issues


= Does it show fake sales? =

Nein. Jedes Popup stammt aus einer echten WooCommerce-Bestellung. Wenn keine passenden Bestellungen vorliegen, wird nichts angezeigt.

= What customer data ends up in the browser? =

Nur der Rechnungs-Vorname und die Rechnungs-Stadt. Nachnamen, E-Mail-Adressen, Adressen und Bestellnummern bleiben auf dem Server und werden nie an die Seite gesendet.

= Which orders does it use? =

Bis zu die 40 aktuellsten Bestellungen mit dem Status „abgeschlossen“ oder „in Bearbeitung“, begrenzt auf etwa die letzten 30 Tage.

= Will it slow my store down or shift the layout? =

Das Skript ist klein, abhängigkeitsfrei und in die Fußzeile verschoben; die Bestelldaten werden in einem Transient zwischengespeichert; und das Popup ist an eine Ecke angeheftet, sodass es andere Inhalte nicht verschiebt. Es gibt keine messbare Layoutverschiebung.

= Is it usable with a screen reader or keyboard? =

Ja. Benachrichtigungen werden über einen `aria-live`-Bereich angekündigt, der Verwerfen-Button ist per Tastatur mit sichtbarem Fokusring erreichbar, der Fokus wird nie eingefangen, und die Animation entfällt, wenn `prefers-reduced-motion` gesetzt ist.

= How do I remove everything on uninstall? =

Das Löschen von Proof über den Plugins-Bildschirm entfernt seine beiden Optionen (`proof_settings` und `proof_db_version`) sowie den zwischengespeicherten Feed. Es werden keine eigenen Tabellen erstellt, und deine Bestelldaten werden nicht angetastet.


= Does this plugin work on WordPress Multisite? =

Ja. Dieses Plugin ist mit WordPress Multisite kompatibel. Aktiviere es netzwerkweit oder auf einzelnen Websites; jede Website behält ihre eigenen Einstellungen und Daten.

== External Services ==

Proof kontaktiert keinen externen Dienst. Die Popups werden aus deinen eigenen WooCommerce-Bestellungen erstellt, und die Daten verbleiben auf deiner Website.

== Screenshots ==

1. Ein Popup mit einem aktuellen Verkauf in der Ecke des Shops.
2. Der Proof-Einstellungsbildschirm unter WooCommerce -> Proof.

== Translations ==

Plogins Proof enthält deutsche, polnische und spanische Übersetzungen für die Plugin-Oberfläche. Die Textdomain ist `plogins-proof`, sodass Sprachpakete von WordPress.org diese mitgelieferten Übersetzungen ebenfalls überschreiben oder erweitern können.

== Changelog ==

= 1.0.2 =
* Mitgelieferte deutsche, polnische und spanische Übersetzungen für die Plugin-Oberfläche hinzugefügt.

= 1.0.1 =
* Erste stabile Version.

= 0.1.1 =
* Für einen eindeutigeren Plugin-Namen in Plogins Proof für WooCommerce umbenannt.

= 0.1.0 =
* Erste Veröffentlichung: Eck-Popups, die aus kürzlich abgeschlossenen und in Bearbeitung befindlichen Bestellungen erstellt werden und nur Vorname und Stadt anzeigen. Konfigurierbare Ecke, Ersatzname und Timing (Verzögerung, Anzeigezeit, Intervall). Kompatibel mit HPOS und Warenkorb-/Kassen-Blöcken.
</content>
</invoke>

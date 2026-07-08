=== Plogins Proof - Social Proof for WooCommerce ===
Contributors: motylanogha
Tags: woocommerce, social proof, sales notification, popup, fomo
Requires at least: 6.5
Tested up to: 7.0
Requires PHP: 8.1
Stable tag: 1.0.1
Erfordert Plugins: woocommerce
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Zeigt ein kleines Eck-Popup der letzten WooCommerce-Verkäufe an. Nur echte Bestellungen, nur Vorname und Stadt, kein jQuery, keine Layoutverschiebung.

== Description ==

Der Beweis zeigt ein kleines Popup in einer Ecke Ihres Schaufensters, das einen kürzlich getätigten Kauf nennt, zum Beispiel „Alex aus Berlin hat vor 2 Stunden Hoodie gekauft“. Das Popup basiert auf tatsächlich erfolgten Bestellungen, sodass Besucher echte Aktivitäten und keine erfundenen Zähler sehen.

Jedes Popup enthält nur zwei Kundendaten: den Vornamen des Rechnungsstellers und die Stadt des Rechnungsstellers. Nachnamen, E-Mail-Adressen, vollständige Adressen und Bestellnummern verlassen niemals den Server. Wenn eine Bestellung keinen Vornamen hat, ersetzt Proof ein von dir ausgewähltes Wort (die Standardeinstellung ist „Jemand“).

Wenn in den letzten 30 Tagen keine abgeschlossenen oder bearbeiteten Bestellungen vorliegen, lädt Proof überhaupt nichts. Kein Popup, kein Skript, kein leeres Widget.

Das Frontend-Skript ist einfaches JavaScript ohne Abhängigkeiten. Es lädt „defer“ in die Fußzeile und das Popup befindet sich in einer festen Ecke, sodass die Seite nie neu umbrochen oder zur kumulativen Layoutverschiebung hinzugefügt wird. Die Bestellabfrage wird höchstens einmal alle fünf Minuten ausgeführt und das Ergebnis wird in einem Transienten gespeichert, sodass eine stark ausgelastete Storefront nicht bei jedem Seitenaufruf erneut Bestellungen abfragt.

Für Benutzer von Bildschirmleseprogrammen ist das Popup ein „role="status"“-Bereich mit „aria-live="polite"`, sodass jede Benachrichtigung angekündigt wird, ohne den Fokus zu greifen. Die Schaltfläche zum Verwerfen ist eine echte Schaltfläche mit einem sichtbaren Fokusring, der Fokus wird niemals blockiert und das Design folgt „bevorzugt reduzierte Bewegung“ und „bevorzugt Farbschema: dunkel“.

Was du unter WooCommerce -> Proof konfigurieren können:

* Ein/Aus-Hauptschalter
* In welcher der vier Ecken das Popup erscheint
* Das Ersatzwort, das verwendet wird, wenn eine Bestellung keinen Vornamen hat
* Anfängliche Verzögerung vor dem ersten Popup, wie lange jedes Popup bleibt und die Lücke zwischen den Popups

Es erklärt die Kompatibilität mit WooCommerce High-Performance Order Storage (HPOS) und den Cart- und Checkout-Blöcken.

Quellen- und Problemverfolgung: Der Code befindet sich unter https://github.com/wppoland/plogins-proof. Dort sind Fehlerberichte und Patches willkommen.

== Installation ==

1. Installieren und aktiviere WooCommerce 8.0 oder höher.
2. Lade den Ordner „proof“ nach „/wp-content/plugins/“ hoch oder installiere die ZIP-Datei über Plugins -> Neu hinzufügen -> Plugin hochladen.
3. Aktiviere Proof auf dem Plugins-Bildschirm.
4. Öffne WooCommerce -> Proof, um eine Ecke auszuwählen und das Timing anzupassen. Die Standardeinstellungen sind angemessen, Du kannst sie also so belassen, wie sie sind.
5. Sobald Sie Bestellungen der letzten 30 Tage abgeschlossen oder bearbeitet haben, erscheinen Popups im Storefront.

== Frequently Asked Questions ==

= Documentation and links =

* <strong>Dokumentation</strong> - https://plogins.com/de/plogins-proof/docs/
* <strong>Plugin-Seite</strong> - https://plogins.com/de/plogins-proof/
* <strong>Quellcode</strong> – https://github.com/wppoland/plogins-proof
* <strong>Fehlerberichte und Funktionsanfragen</strong> – https://github.com/wppoland/plogins-proof/issues


= Does it show fake sales? =

Nein. Jedes Popup stammt aus einer echten WooCommerce-Bestellung. Wenn keine qualifizierten Bestellungen vorliegen, wird nichts angezeigt.

= What customer data ends up in the browser? =

Nur der Vorname und der Ort der Rechnungsstellung. Nachnamen, E-Mail-Adressen, Adressen und Bestellnummern bleiben auf dem Server und werden niemals an die Seite gesendet.

= Which orders does it use? =

Bis zu den 40 aktuellsten Bestellungen mit dem Status „abgeschlossen“ oder „in Bearbeitung“, begrenzt auf etwa die letzten 30 Tage.

= Will it slow my store down or shift the layout? =

Das Skript ist klein, unabhängig von Abhängigkeiten und wird in die Fußzeile verschoben. die Bestelldaten werden transient zwischengespeichert; und das Popup wird an eine Ecke angeheftet, sodass andere Inhalte nicht verschoben werden. Es gibt keine messbare Layoutverschiebung.

= Is it usable with a screen reader or keyboard? =

Ja. Benachrichtigungen werden über einen „Aria-Live“-Bereich angekündigt, die Schaltfläche zum Verwerfen ist über die Tastatur mit einem sichtbaren Fokusring erreichbar, der Fokus wird niemals gefangen und die Animation wird gelöscht, wenn „Prefers-Reduced-Motion“ eingestellt ist.

= How do I remove everything on uninstall? =

Durch das Löschen von Proof aus dem Plugins-Bildschirm werden seine beiden Optionen („proof_settings“ und „proof_db_version“) sowie der zwischengespeicherte Feed entfernt. Es werden keine benutzerdefinierten Tabellen erstellt und deine Bestelldaten werden nicht berührt.


= Does this plugin work on WordPress Multisite? =

Ja. Dieses Plugin ist mit WordPress Multisite kompatibel. Aktiviere es im Netzwerk oder auf einzelnen Websites. Jede Site behält ihre eigenen Einstellungen und Daten.

== External Services ==

Der Nachweis kontaktiert keinen externen Dienst. Die Popups werden aus deinen eigenen WooCommerce-Bestellungen erstellt und die Daten verbleiben auf deiner Website.

== Screenshots ==

1. Ein Popup mit aktuellen Angeboten in der Ecke des Ladens.
2. Der Proof-Einstellungsbildschirm unter WooCommerce -> Proof.

== Changelog ==

= 1.0.1 =
* Erste stabile Version.

= 0.1.1 =
* Für einen eindeutigeren Plugin-Namen in Plogins Proof für WooCommerce umbenannt.

= 0.1.0 =
* Erste Veröffentlichung: Eck-Popups, die aus kürzlich abgeschlossenen und bearbeiteten Bestellungen erstellt wurden und nur den Vornamen und die Stadt anzeigen. Konfigurierbare Ecke, Fallback-Name und Timing (Verzögerung, Anzeigezeit, Intervall). HPOS- und Cart/Checkout-Blöcke kompatibel.
</content>
</invoke>

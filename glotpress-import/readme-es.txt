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

Muestra una pequeña ventana emergente en una esquina con las ventas recientes de WooCommerce. Solo pedidos reales, solo nombre y ciudad, sin jQuery, sin saltos de diseño.

== Description ==

Proof muestra una pequeña ventana emergente en una esquina de tu tienda que menciona una compra reciente, por ejemplo «Alex de Berlín compró una sudadera con capucha hace 2 horas». La ventana emergente se crea a partir de pedidos que realmente ocurrieron, por lo que los visitantes ven actividad real en lugar de contadores inventados.

Cada ventana emergente contiene solo dos datos del cliente: el nombre de facturación y la ciudad de facturación. Los apellidos, los correos electrónicos, las direcciones completas y los números de pedido nunca salen del servidor. Cuando un pedido no tiene nombre, Proof lo sustituye por una palabra que elijas (el valor predeterminado es «Alguien»).

Si no hay pedidos completados o en proceso en los últimos 30 días, Proof no carga nada en absoluto. Sin ventana emergente, sin script, sin widget vacío.

El script del frontend es JavaScript puro y sin dependencias. Se carga con `defer` en el pie de página y la ventana emergente se sitúa en una esquina fija para que nunca redistribuya la página ni contribuya al desplazamiento acumulativo del diseño (CLS). La consulta de pedidos se ejecuta como máximo una vez cada cinco minutos y el resultado se almacena en un transitorio, así que una tienda con mucho tráfico no vuelve a consultar los pedidos en cada vista de página.

Para los usuarios de lectores de pantalla, la ventana emergente es una región `role="status"` con `aria-live="polite"`, de modo que cada notificación se anuncia sin llamar la atención. El botón de descarte es un botón real con un anillo de foco visible, el foco nunca queda atrapado y el estilo respeta `prefers-reduced-motion` y `prefers-color-scheme: dark`.

Lo que puedes configurar en WooCommerce -> Proof:

* Interruptor principal de encendido/apagado
* En cuál de las cuatro esquinas aparece la ventana emergente
* La palabra alternativa que se usa cuando un pedido no tiene nombre
* Retraso inicial antes de la primera ventana emergente, cuánto tiempo permanece cada ventana emergente y el intervalo entre ventanas emergentes

Declara compatibilidad con el almacenamiento de pedidos de alto rendimiento (HPOS) de WooCommerce y los bloques Carrito y Pago.

Código fuente y seguimiento de incidencias: el código se encuentra en https://github.com/wppoland/plogins-proof. Los informes de errores y los parches son bienvenidos allí.

== Installation ==

1. Instala y activa WooCommerce 8.0 o posterior.
2. Sube la carpeta `proof` a `/wp-content/plugins/` o instala el zip desde Plugins -> Añadir nuevo -> Subir plugin.
3. Activa Proof en la pantalla Plugins.
4. Abre WooCommerce -> Proof para elegir una esquina y ajustar los tiempos. Los valores predeterminados son razonables, así que puedes dejarlos como están.
5. Cuando tengas pedidos completados o en proceso de los últimos 30 días, empezarán a aparecer ventanas emergentes en la tienda.

== Frequently Asked Questions ==

= Documentation and links =

* <strong>Documentación</strong> - https://plogins.com/es/plogins-proof/docs/
* <strong>Página del plugin</strong> - https://plogins.com/es/plogins-proof/
* <strong>Código fuente</strong> - https://github.com/wppoland/plogins-proof
* <strong>Informes de errores y peticiones de funciones</strong> - https://github.com/wppoland/plogins-proof/issues


= Does it show fake sales? =

No. Cada ventana emergente proviene de un pedido real de WooCommerce. Sin pedidos que cumplan los requisitos, no se muestra nada.

= What customer data ends up in the browser? =

Solo el nombre de facturación y la ciudad de facturación. Los apellidos, los correos electrónicos, las direcciones y los números de pedido permanecen en el servidor y nunca se envían a la página.

= Which orders does it use? =

Hasta los 40 pedidos más recientes con estado «completado» o «en proceso», limitados a aproximadamente los últimos 30 días.

= Will it slow my store down or shift the layout? =

El script es pequeño, sin dependencias y diferido al pie de página; los datos del pedido se almacenan en caché en un transitorio; y la ventana emergente está fijada en una esquina, por lo que no mueve otro contenido. No hay ningún salto de diseño apreciable.

= Is it usable with a screen reader or keyboard? =

Sí. Las notificaciones se anuncian a través de una región `aria-live`, se puede acceder al botón de descarte con el teclado y tiene un anillo de foco visible, el foco nunca queda atrapado y la animación se desactiva cuando se establece `prefers-reduced-motion`.

= How do I remove everything on uninstall? =

Al eliminar Proof desde la pantalla Plugins se borran sus dos opciones (`proof_settings` y `proof_db_version`) y el feed en caché. No crea tablas personalizadas ni toca los datos de tus pedidos.


= Does this plugin work on WordPress Multisite? =

Sí. Este plugin es compatible con WordPress Multisite. Actívalo en toda la red o en sitios concretos; cada sitio conserva sus propios ajustes y datos.

== External Services ==

Proof no contacta con ningún servicio externo. Las ventanas emergentes se crean a partir de tus propios pedidos de WooCommerce y los datos permanecen en tu sitio.

== Screenshots ==

1. Una ventana emergente de una venta reciente en la esquina de la tienda.
2. La pantalla de ajustes de Proof en WooCommerce -> Proof.

== Translations ==

Plogins Proof incluye traducciones al polaco, al alemán y al español para la interfaz del plugin. El dominio de texto es `plogins-proof`, por lo que los paquetes de idioma de WordPress.org también pueden sobrescribir o ampliar estas traducciones incluidas.

== Changelog ==

= 1.0.2 =
* Se añadieron traducciones incluidas al polaco, al alemán y al español para la interfaz del plugin.

= 1.0.1 =
* Primera versión estable.

= 0.1.1 =
* Renombrado a Plogins Proof para WooCommerce para conseguir un nombre de plugin más distintivo.

= 0.1.0 =
* Primera versión: ventanas emergentes en las esquinas creadas a partir de pedidos completados y en proceso recientes, que muestran solo el nombre y la ciudad. Esquina configurable, nombre alternativo y tiempos (retraso, tiempo de visualización, intervalo). Compatible con HPOS y bloques de carrito/pago.
</content>
</invoke>

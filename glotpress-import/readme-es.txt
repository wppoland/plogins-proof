=== Plogins Proof - Social Proof for WooCommerce ===
Contributors: motylanogha
Tags: woocommerce, social proof, sales notification, popup, fomo
Requires at least: 6.5
Tested up to: 7.0
Requires PHP: 8.1
Stable tag: 1.0.1
Requiere complementos: woocommerce
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Muestra una pequeña ventana emergente en la esquina de las ventas recientes de WooCommerce. Solo pedidos reales, solo nombre y ciudad, sin jQuery, sin cambio de diseño.

== Description ==

La prueba muestra una pequeña ventana emergente en una esquina de su tienda que menciona una compra reciente, por ejemplo, "Alex de Berlín compró una sudadera con capucha hace 2 horas". La ventana emergente se crea a partir de pedidos que realmente sucedieron, por lo que los visitantes ven la actividad real en lugar de contadores inventados.

Cada ventana emergente contiene solo dos datos del cliente: el nombre de facturación y la ciudad de facturación. Los apellidos, correos electrónicos, direcciones completas y números de pedido nunca salen del servidor. Cuando un pedido no tiene nombre, Proof lo sustituye por una palabra que elijas (el valor predeterminado es "Alguien").

Si no hay pedidos completados o en proceso en los últimos 30 días, Proof no carga nada en absoluto. Sin ventanas emergentes, sin secuencias de comandos, sin widgets vacíos.

El script de front-end es JavaScript simple sin dependencias. Carga "aplazar" en el pie de página y la ventana emergente se ubica en una esquina fija para que nunca redistribuya la página ni añade cambios de diseño acumulativos. La consulta de pedido se ejecuta como máximo una vez cada cinco minutos y el resultado se almacena de forma transitoria, por lo que una tienda ocupada no vuelve a consultar los pedidos en cada vista de página.

Para los usuarios de lectores de pantalla, la ventana emergente es una región `role="status"` con `aria-live="polite"`, por lo que cada notificación se anuncia sin llamar la atención. El botón de descartar es un botón real con un anillo de enfoque visible, el enfoque nunca queda atrapado y el estilo sigue "prefiere movimiento reducido" y "prefiere esquema de color: oscuro".

Lo que puedes configurar en WooCommerce -> Prueba:

* Interruptor principal de encendido/apagado
* ¿En cuál de las cuatro esquinas aparece la ventana emergente?
* La palabra alternativa utilizada cuando un pedido no tiene nombre
* Retraso inicial antes de la primera ventana emergente, cuánto tiempo permanece cada ventana emergente y el espacio entre ventanas emergentes

Declara compatibilidad con el almacenamiento de pedidos de alto rendimiento (HPOS) de WooCommerce y los bloques Carrito y Pago.

Rastreador de fuentes y problemas: el código se encuentra en https://github.com/wppoland/plogins-proof. Los informes de errores y los parches son bienvenidos allí.

== Installation ==

1. Instale y active WooCommerce 8.0 o posterior.
2. Cargue la carpeta `proof` en `/wp-content/plugins/`, o instale el zip desde Complementos -> Añadir nuevo -> Cargar complemento.
3. Active Prueba en la pantalla Complementos.
4. Abra WooCommerce -> Prueba para elegir una esquina y ajustar el tiempo. Los valores predeterminados son razonables, por lo que puedes dejarlos como están.
5. Una vez que haya completado o procesado los pedidos de los últimos 30 días, comenzarán a aparecer ventanas emergentes en el escaparate.

== Frequently Asked Questions ==

= Documentation and links =

* <strong>Documentación</strong> - https://plogins.com/es/plogins-proof/docs/
* <strong>Página de complementos</strong> - https://plogins.com/es/plogins-proof/
* <strong>Código fuente</strong> - https://github.com/wppoland/plogins-proof
* <strong>Informes de errores y solicitudes de funciones</strong> - https://github.com/wppoland/plogins-proof/issues


= Does it show fake sales? =

No. Cada ventana emergente proviene de un pedido real de WooCommerce. Sin pedidos calificados, no se muestra nada.

= What customer data ends up in the browser? =

Solo el nombre de facturación y la ciudad de facturación. Los apellidos, correos electrónicos, direcciones y números de pedido permanecen en el servidor y nunca se envían a la página.

= Which orders does it use? =

Hasta los 40 pedidos más recientes con estado "completado" o "en procesamiento", limitados a aproximadamente los últimos 30 días.

= Will it slow my store down or shift the layout? =

El guión es pequeño, libre de dependencias y diferido al pie de página; los datos del pedido se almacenan en caché de forma transitoria; y la ventana emergente está fijada en una esquina, por lo que no mueve otro contenido. No hay ningún cambio de diseño mensurable.

= Is it usable with a screen reader or keyboard? =

Sí. Las notificaciones se anuncian a través de una región "aria-live", el botón de descartar se puede acceder con el teclado con un anillo de enfoque visible, el enfoque nunca queda atrapado y la animación se elimina cuando se configura "prefiere movimiento reducido".

= How do I remove everything on uninstall? =

Al eliminar Proof de la pantalla Complementos, se eliminan sus dos opciones (`proof_settings` y `proof_db_version`) y el feed en caché. No crea tablas personalizadas y no toca los datos de su pedido.


= Does this plugin work on WordPress Multisite? =

Sí. Este complemento es compatible con WordPress Multisite. Activarlo en red o activarlo en sitios individuales; Cada sitio mantiene su propia configuración y datos.

== External Services ==

La prueba no contacta con ningún servicio externo. Las ventanas emergentes se crean a partir de sus propios pedidos de WooCommerce y los datos permanecen en tu sitio.

== Screenshots ==

1. Una ventana emergente de venta reciente en la esquina del escaparate.
2. La pantalla de configuración de Prueba en WooCommerce -> Prueba.

== Changelog ==

= 1.0.1 =
* Primera versión estable.

= 0.1.1 =
* Renombrado a Plogins Proof para WooCommerce para obtener un nombre de complemento más distintivo.

= 0.1.0 =
* Primera versión: ventanas emergentes en las esquinas creadas a partir de pedidos completados y en procesamiento recientes, que muestran solo el nombre y la ciudad. Esquina configurable, nombre de reserva y tiempo (retraso, tiempo de visualización, intervalo). Compatible con HPOS y bloques de carrito/pago.
</contenido>
</invocar>

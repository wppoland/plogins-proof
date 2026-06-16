/**
 * Proof — recent-sale social-proof popup (vanilla JS, no dependencies).
 *
 * Rotates through a privacy-safe list of recent purchases supplied by PHP via
 * the `proofData` global. Respects an initial delay, a per-popup display time
 * and an interval between popups.
 *
 * Accessibility: the popup lives in an aria-live="polite" region so screen
 * readers announce each notification without stealing focus. It never traps
 * focus and never blocks page content (fixed corner, pointer-events managed).
 */
( function () {
	'use strict';

	var data = window.proofData;
	if ( ! data || ! Array.isArray( data.notifications ) || data.notifications.length === 0 ) {
		return;
	}

	var config = data.config || {};
	var i18n = data.i18n || {};

	var position = config.position || 'bottom-left';
	var initialDelay = toInt( config.initialDelay, 5000 );
	var displayTime = toInt( config.displayTime, 6000 );
	var interval = toInt( config.interval, 12000 );

	var items = data.notifications.slice();
	var index = 0;
	var hideTimer = null;
	var cycleTimer = null;

	var popup = buildPopup();
	var textEl = popup.querySelector( '.proof-popup__text' );
	var dismissed = false;

	document.body.appendChild( popup );

	popup.querySelector( '.proof-popup__close' ).addEventListener( 'click', function () {
		dismissed = true;
		clearTimeout( hideTimer );
		clearTimeout( cycleTimer );
		hide();
	} );

	window.setTimeout( cycle, initialDelay );

	function cycle() {
		if ( dismissed ) {
			return;
		}

		render( items[ index % items.length ] );
		index++;

		show();

		hideTimer = window.setTimeout( function () {
			hide();
			cycleTimer = window.setTimeout( cycle, interval );
		}, displayTime );
	}

	function render( item ) {
		if ( ! item ) {
			return;
		}

		var lead = document.createElement( 'span' );
		if ( item.name ) {
			var nameEl = document.createElement( 'span' );
			nameEl.className = 'proof-popup__name';
			nameEl.textContent = item.name;
			lead.appendChild( nameEl );
		}

		var sentence = '';
		if ( item.city ) {
			sentence += ( lead.textContent ? ' ' : '' ) + fromLabel() + ' ' + item.city;
		}
		if ( item.product ) {
			sentence += ' ' + boughtLabel() + ' ' + item.product;
		}

		// Reset.
		while ( textEl.firstChild ) {
			textEl.removeChild( textEl.firstChild );
		}
		if ( lead.childNodes.length ) {
			textEl.appendChild( lead );
		}
		if ( sentence ) {
			textEl.appendChild( document.createTextNode( sentence ) );
		}

		var existingTime = popup.querySelector( '.proof-popup__time' );
		if ( existingTime ) {
			existingTime.parentNode.removeChild( existingTime );
		}
		if ( item.time ) {
			var timeEl = document.createElement( 'span' );
			timeEl.className = 'proof-popup__time';
			timeEl.textContent = item.time;
			textEl.parentNode.appendChild( timeEl );
		}
	}

	function show() {
		popup.classList.add( 'is-visible' );
	}

	function hide() {
		popup.classList.remove( 'is-visible' );
	}

	function buildPopup() {
		var el = document.createElement( 'aside' );
		el.className = 'proof-popup';
		el.setAttribute( 'data-position', position );
		el.setAttribute( 'role', 'status' );
		el.setAttribute( 'aria-live', 'polite' );
		el.setAttribute( 'aria-label', i18n.regionLabel || 'Recent purchase' );

		var icon = document.createElement( 'span' );
		icon.className = 'proof-popup__icon';
		icon.setAttribute( 'aria-hidden', 'true' );
		// "Approved" seal: a checkmark, like the verified mark a terminal prints
		// when a real transaction clears.
		icon.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m5 12.5 4.5 4.5L19 7"/></svg>';

		var body = document.createElement( 'div' );
		body.className = 'proof-popup__body';
		var text = document.createElement( 'p' );
		text.className = 'proof-popup__text';
		body.appendChild( text );

		var close = document.createElement( 'button' );
		close.type = 'button';
		close.className = 'proof-popup__close';
		close.setAttribute( 'aria-label', i18n.closeLabel || 'Dismiss notification' );
		close.innerHTML = '<span aria-hidden="true">&times;</span>';

		el.appendChild( icon );
		el.appendChild( body );
		el.appendChild( close );

		return el;
	}

	function fromLabel() {
		return i18n.from || 'from';
	}

	function boughtLabel() {
		return i18n.bought || 'bought';
	}

	function toInt( value, fallback ) {
		var n = parseInt( value, 10 );
		return isNaN( n ) ? fallback : n;
	}
} )();

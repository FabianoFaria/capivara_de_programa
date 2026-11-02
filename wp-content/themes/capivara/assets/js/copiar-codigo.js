/* Botão "Copiar" nos blocos de código. */
( function () {
	if ( ! navigator.clipboard ) {
		return;
	}
	// Textos traduzidos vêm do PHP (functions.php); os valores abaixo são só reserva.
	var t = window.capivaraCopiar || { copiar: 'Copiar', copiado: 'Copiado!', rotulo: 'Copiar código' };
	document.querySelectorAll( 'pre.wp-block-code' ).forEach( function ( pre ) {
		var code = pre.querySelector( 'code' ) || pre;
		var btn = document.createElement( 'button' );
		btn.type = 'button';
		btn.className = 'capivara-copy';
		btn.textContent = t.copiar;
		btn.setAttribute( 'aria-label', t.rotulo );
		btn.addEventListener( 'click', function () {
			navigator.clipboard.writeText( code.innerText ).then( function () {
				btn.textContent = t.copiado;
				setTimeout( function () {
					btn.textContent = t.copiar;
				}, 1800 );
			} );
		} );
		pre.appendChild( btn );
	} );
} )();

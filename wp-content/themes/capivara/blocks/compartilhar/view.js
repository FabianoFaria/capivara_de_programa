/* Bloco Compartilhar: menu nativo do aparelho e "Copiar link". */
( function () {
	function anunciar( bloco, texto ) {
		var status = bloco.querySelector( '[data-capivara-share-status]' );
		if ( status ) {
			status.textContent = '';
			setTimeout( function () {
				status.textContent = texto;
			}, 50 );
		}
	}

	function copiarAntigo( texto ) {
		var campo = document.createElement( 'textarea' );
		campo.value = texto;
		campo.setAttribute( 'readonly', '' );
		campo.style.position = 'fixed';
		campo.style.opacity = '0';
		document.body.appendChild( campo );
		campo.select();
		var ok = false;
		try {
			ok = document.execCommand( 'copy' );
		} catch ( e ) {
			ok = false;
		}
		document.body.removeChild( campo );
		return ok;
	}

	document.querySelectorAll( '.capivara-share' ).forEach( function ( bloco ) {
		var nativo = bloco.querySelector( '[data-capivara-share-native]' );
		if ( nativo && typeof navigator.share === 'function' ) {
			nativo.closest( 'li' ).hidden = false;
			nativo.addEventListener( 'click', function () {
				navigator
					.share( {
						title: nativo.getAttribute( 'data-title' ),
						text: nativo.getAttribute( 'data-text' ),
						url: nativo.getAttribute( 'data-url' )
					} )
					.catch( function () {} ); // A pessoa cancelou: nada a fazer.
			} );
		}

		var copiar = bloco.querySelector( '[data-capivara-share-copy]' );
		if ( ! copiar ) {
			return;
		}
		var rotulo = copiar.querySelector( '[data-capivara-share-copy-label]' );
		var original = rotulo ? rotulo.textContent : '';

		function sucesso() {
			var msg = copiar.getAttribute( 'data-copied' );
			if ( rotulo ) {
				rotulo.textContent = msg;
				setTimeout( function () {
					rotulo.textContent = original;
				}, 2000 );
			}
			anunciar( bloco, msg );
		}

		function falha() {
			anunciar( bloco, copiar.getAttribute( 'data-error' ) );
		}

		copiar.addEventListener( 'click', function () {
			var url = copiar.getAttribute( 'data-url' );
			if ( navigator.clipboard && window.isSecureContext ) {
				navigator.clipboard.writeText( url ).then( sucesso, function () {
					if ( copiarAntigo( url ) ) {
						sucesso();
					} else {
						falha();
					}
				} );
			} else if ( copiarAntigo( url ) ) {
				sucesso();
			} else {
				falha();
			}
		} );
	} );
} )();

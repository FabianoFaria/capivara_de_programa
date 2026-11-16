( function ( wp ) {
	var el = wp.element.createElement;
	var __ = wp.i18n.__;
	var useBlockProps = wp.blockEditor.useBlockProps;

	var REDES = [ 'WhatsApp', 'Telegram', 'LinkedIn', 'X', 'Facebook' ];

	wp.blocks.registerBlockType( 'capivara/compartilhar', {
		edit: function () {
			var blockProps = useBlockProps( { className: 'capivara-share' } );
			return el(
				'div',
				blockProps,
				el( 'p', { className: 'capivara-share__label' }, __( 'Compartilhe', 'capivara' ) ),
				el(
					'ul',
					{ className: 'capivara-share__list' },
					REDES.map( function ( nome ) {
						return el(
							'li',
							{ key: nome, className: 'capivara-share__item' },
							el( 'span', { className: 'capivara-share__btn capivara-share__btn--icon', title: nome }, nome.charAt( 0 ) )
						);
					} ),
					el(
						'li',
						{ className: 'capivara-share__item' },
						el( 'span', { className: 'capivara-share__btn capivara-share__btn--copy' }, __( 'Copiar link', 'capivara' ) )
					)
				)
			);
		},
		save: function () {
			return null;
		}
	} );
} )( window.wp );

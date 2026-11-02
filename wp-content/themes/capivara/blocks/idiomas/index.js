( function ( wp ) {
	var el = wp.element.createElement;
	var __ = wp.i18n.__;
	var useBlockProps = wp.blockEditor.useBlockProps;

	wp.blocks.registerBlockType( 'capivara/idiomas', {
		edit: function () {
			var blockProps = useBlockProps( { className: 'capivara-idiomas capivara-idiomas--placeholder' } );
			return el(
				'span',
				blockProps,
				el( 'span', { className: 'capivara-idiomas__link is-current' }, 'PT' ),
				el( 'span', { className: 'capivara-idiomas__link' }, 'EN' ),
				el( 'span', { className: 'screen-reader-text' }, __( 'Seletor de idioma (aparece com o Polylang ativo)', 'capivara' ) )
			);
		},
		save: function () {
			return null;
		}
	} );
} )( window.wp );

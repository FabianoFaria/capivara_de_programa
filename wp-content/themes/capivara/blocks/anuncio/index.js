( function ( wp ) {
	var el = wp.element.createElement;
	var __ = wp.i18n.__;
	var useBlockProps = wp.blockEditor.useBlockProps;
	var InspectorControls = wp.blockEditor.InspectorControls;
	var PanelBody = wp.components.PanelBody;
	var SelectControl = wp.components.SelectControl;

	var SLOTS = [
		{ value: 'horizontal', label: __( 'Horizontal (entre seções)', 'capivara' ) },
		{ value: 'lateral', label: __( 'Lateral (300 × 250)', 'capivara' ) },
		{ value: 'artigo', label: __( 'No meio do artigo', 'capivara' ) },
		{ value: 'vagas', label: __( 'Patrocinado (vagas)', 'capivara' ) }
	];

	function labelFor( slot ) {
		for ( var i = 0; i < SLOTS.length; i++ ) {
			if ( SLOTS[ i ].value === slot ) {
				return SLOTS[ i ].label;
			}
		}
		return slot;
	}

	wp.blocks.registerBlockType( 'capivara/anuncio', {
		edit: function ( props ) {
			var slot = props.attributes.slot || 'horizontal';
			var blockProps = useBlockProps( {
				className: 'capivara-ad capivara-ad--empty capivara-ad--' + slot
			} );

			return el(
				wp.element.Fragment,
				null,
				el(
					InspectorControls,
					null,
					el(
						PanelBody,
						{ title: __( 'Espaço de anúncio', 'capivara' ) },
						el( SelectControl, {
							label: __( 'Espaço', 'capivara' ),
							value: slot,
							options: SLOTS,
							onChange: function ( value ) {
								props.setAttributes( { slot: value } );
							}
						} )
					)
				),
				el(
					'div',
					blockProps,
					el( 'span', { className: 'capivara-ad__label' }, __( 'Publicidade', 'capivara' ) ),
					el( 'span', null, labelFor( slot ) + ' — ' + __( 'o código fica em Aparência › Anúncios', 'capivara' ) )
				)
			);
		},
		save: function () {
			return null;
		}
	} );
} )( window.wp );

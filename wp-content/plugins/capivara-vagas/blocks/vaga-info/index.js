/**
 * Editor do bloco "Dados da vaga". O conteúdo real é montado em PHP (render.php);
 * no editor aparece uma prévia com o layout escolhido.
 */
( function ( wp ) {
	var el = wp.element.createElement;
	var __ = wp.i18n.__;
	var useBlockProps = wp.blockEditor.useBlockProps;
	var InspectorControls = wp.blockEditor.InspectorControls;
	var PanelBody = wp.components.PanelBody;
	var SelectControl = wp.components.SelectControl;

	wp.blocks.registerBlockType( 'capivara/vaga-info', {
		edit: function ( props ) {
			var layout = props.attributes.layout || 'card';
			var blockProps = useBlockProps( {
				className: 'capivara-vaga-info is-layout-' + layout + ' is-preview'
			} );

			var previa = layout === 'resumo'
				? [
					el( 'p', { key: 's', className: 'capivara-vaga-info__salario' }, __( 'R$ 8.000 a R$ 12.000 por mês', 'capivara-vagas' ) ),
					el( 'p', { key: 'l', className: 'capivara-vaga-info__linha' }, __( 'Empresa · Remoto (Brasil) · CLT · Pleno', 'capivara-vagas' ) ),
					el( 'span', { key: 'b', className: 'capivara-vaga-info__botao' }, __( 'Candidatar-se', 'capivara-vagas' ) )
				]
				: [
					el( 'p', { key: 'e', className: 'capivara-vaga-info__linha' }, __( 'Empresa · Remoto (Brasil) · Pleno', 'capivara-vagas' ) ),
					el( 'p', { key: 's', className: 'capivara-vaga-info__salario' }, __( 'R$ 8.000 a R$ 12.000 por mês · CLT', 'capivara-vagas' ) ),
					el( 'p', { key: 't', className: 'capivara-vaga-info__stack' }, 'php · laravel · docker' )
				];

			return el(
				wp.element.Fragment,
				null,
				el(
					InspectorControls,
					null,
					el(
						PanelBody,
						{ title: __( 'Layout', 'capivara-vagas' ) },
						el( SelectControl, {
							label: __( 'Mostrar como', 'capivara-vagas' ),
							value: layout,
							options: [
								{ value: 'card', label: __( 'Card (lista de vagas)', 'capivara-vagas' ) },
								{ value: 'resumo', label: __( 'Resumo com botão (página da vaga)', 'capivara-vagas' ) }
							],
							onChange: function ( valor ) {
								props.setAttributes( { layout: valor } );
							}
						} )
					)
				),
				el( 'div', blockProps, previa )
			);
		},
		save: function () {
			return null;
		}
	} );
} )( window.wp );

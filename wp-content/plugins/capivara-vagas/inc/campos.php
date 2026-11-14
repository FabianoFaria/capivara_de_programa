<?php
/**
 * Campos da vaga (ACF), definidos em código para ficarem no Git.
 *
 * Os valores ficam em post meta comum (mesmo nome do campo). Por isso o site
 * continua exibindo as vagas mesmo se o ACF for desativado; só o formulário
 * de edição depende dele.
 *
 * @package CapivaraVagas
 */

defined( 'ABSPATH' ) || exit;

function capivara_vagas_registrar_campos() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_capivara_vaga',
			'title'                 => __( 'Dados da vaga', 'capivara-vagas' ),
			'show_in_rest'          => 1,
			'position'              => 'acf_after_title',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'vaga',
					),
				),
			),
			'fields'                => array(
				array(
					'key'      => 'field_cv_empresa',
					'name'     => 'empresa',
					'label'    => __( 'Empresa', 'capivara-vagas' ),
					'type'     => 'text',
					'required' => 1,
					'wrapper'  => array( 'width' => '50' ),
				),
				array(
					'key'     => 'field_cv_empresa_site',
					'name'    => 'empresa_site',
					'label'   => __( 'Site da empresa', 'capivara-vagas' ),
					'type'    => 'url',
					'wrapper' => array( 'width' => '50' ),
				),
				array(
					'key'          => 'field_cv_link_candidatura',
					'name'         => 'link_candidatura',
					'label'        => __( 'Como se candidatar', 'capivara-vagas' ),
					'instructions' => __( 'Link da vaga (https://...) ou e-mail para envio do currículo.', 'capivara-vagas' ),
					'type'         => 'text',
					'required'     => 1,
				),
				array(
					'key'           => 'field_cv_contrato',
					'name'          => 'contrato',
					'label'         => __( 'Contrato', 'capivara-vagas' ),
					'type'          => 'select',
					'choices'       => capivara_vagas_contratos(),
					'default_value' => 'clt',
					'return_format' => 'value',
					'wrapper'       => array( 'width' => '33' ),
				),
				array(
					'key'          => 'field_cv_localizacao',
					'name'         => 'localizacao',
					'label'        => __( 'Cidade/UF', 'capivara-vagas' ),
					'instructions' => __( 'Para vagas híbridas ou presenciais. Ex.: São Paulo/SP', 'capivara-vagas' ),
					'type'         => 'text',
					'wrapper'      => array( 'width' => '33' ),
				),
				array(
					'key'           => 'field_cv_paises',
					'name'          => 'paises',
					'label'         => __( 'Países aceitos (remoto)', 'capivara-vagas' ),
					'instructions'  => __( 'Códigos de país separados por vírgula. Ex.: BR ou BR, PT. Vazio = qualquer país (a vaga fica sem o destaque do Google, que exige um país).', 'capivara-vagas' ),
					'type'          => 'text',
					'default_value' => 'BR',
					'wrapper'       => array( 'width' => '33' ),
				),
				array(
					'key'     => 'field_cv_salario_min',
					'name'    => 'salario_min',
					'label'   => __( 'Salário mínimo', 'capivara-vagas' ),
					'type'    => 'number',
					'min'     => 0,
					'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key'     => 'field_cv_salario_max',
					'name'    => 'salario_max',
					'label'   => __( 'Salário máximo', 'capivara-vagas' ),
					'type'    => 'number',
					'min'     => 0,
					'wrapper' => array( 'width' => '25' ),
				),
				array(
					'key'           => 'field_cv_moeda',
					'name'          => 'moeda',
					'label'         => __( 'Moeda', 'capivara-vagas' ),
					'type'          => 'select',
					'choices'       => array(
						'BRL' => 'R$ (BRL)',
						'USD' => 'US$ (USD)',
						'EUR' => '€ (EUR)',
					),
					'default_value' => 'BRL',
					'return_format' => 'value',
					'wrapper'       => array( 'width' => '25' ),
				),
				array(
					'key'           => 'field_cv_periodo',
					'name'          => 'salario_periodo',
					'label'         => __( 'Período', 'capivara-vagas' ),
					'type'          => 'select',
					'choices'       => array(
						'MONTH' => __( 'por mês', 'capivara-vagas' ),
						'YEAR'  => __( 'por ano', 'capivara-vagas' ),
						'HOUR'  => __( 'por hora', 'capivara-vagas' ),
					),
					'default_value' => 'MONTH',
					'return_format' => 'value',
					'wrapper'       => array( 'width' => '25' ),
				),
				array(
					'key'            => 'field_cv_validade',
					'name'           => 'validade',
					'label'          => __( 'Aberta até', 'capivara-vagas' ),
					'instructions'   => __( 'Depois desta data a vaga sai do ar sozinha. Vazio = 30 dias a partir da publicação.', 'capivara-vagas' ),
					'type'           => 'date_picker',
					'display_format' => 'd/m/Y',
					'return_format'  => 'Y-m-d',
					'first_day'      => 0,
					'wrapper'        => array( 'width' => '33' ),
				),
				array(
					'key'          => 'field_cv_destaque',
					'name'         => 'destaque',
					'label'        => __( 'Vaga em destaque', 'capivara-vagas' ),
					'type'         => 'true_false',
					'ui'           => 1,
					'instructions' => __( 'Aparece primeiro na lista, com selo.', 'capivara-vagas' ),
					'wrapper'      => array( 'width' => '33' ),
				),
				array(
					'key'     => 'field_cv_fonte_nome',
					'name'    => 'fonte_nome',
					'label'   => __( 'Fonte (nome)', 'capivara-vagas' ),
					'type'    => 'text',
					'instructions' => __( 'De onde a vaga veio. Ex.: backend-br/vagas, Remotive, formulário do site.', 'capivara-vagas' ),
					'wrapper' => array( 'width' => '33' ),
				),
				array(
					'key'     => 'field_cv_fonte_url',
					'name'    => 'fonte_url',
					'label'   => __( 'Fonte (link)', 'capivara-vagas' ),
					'type'    => 'url',
					'wrapper' => array( 'width' => '100' ),
				),
			),
		)
	);
}
add_action( 'acf/init', 'capivara_vagas_registrar_campos' );

/** Tipos de contrato e o equivalente no schema do Google. */
function capivara_vagas_contratos() {
	return array(
		'clt'        => __( 'CLT', 'capivara-vagas' ),
		'pj'         => __( 'PJ', 'capivara-vagas' ),
		'estagio'    => __( 'Estágio', 'capivara-vagas' ),
		'freelance'  => __( 'Freelance', 'capivara-vagas' ),
		'temporario' => __( 'Temporário', 'capivara-vagas' ),
		'outro'      => __( 'Outro', 'capivara-vagas' ),
	);
}

/**
 * "Como se candidatar" precisa ser um link https ou um e-mail.
 */
function capivara_vagas_validar_link( $valido, $valor ) {
	if ( true !== $valido || '' === trim( (string) $valor ) ) {
		return $valido;
	}
	$valor = trim( $valor );
	if ( is_email( $valor ) || preg_match( '#^https?://#i', $valor ) ) {
		return true;
	}
	return __( 'Use um link começando com https:// ou um e-mail.', 'capivara-vagas' );
}
add_filter( 'acf/validate_value/key=field_cv_link_candidatura', 'capivara_vagas_validar_link', 10, 2 );

/**
 * A validação acima só roda no formulário do painel. Pela API REST (n8n),
 * o mesmo teste é feito aqui, antes de gravar.
 *
 * @param stdClass|WP_Error $post    Post preparado.
 * @param WP_REST_Request   $request Requisição.
 */
function capivara_vagas_validar_link_rest( $post, $request ) {
	$acf = $request->get_param( 'acf' );
	if ( is_wp_error( $post ) || ! is_array( $acf ) || ! array_key_exists( 'link_candidatura', $acf ) ) {
		return $post;
	}
	$resultado = capivara_vagas_validar_link( true, $acf['link_candidatura'] );
	if ( true !== $resultado ) {
		return new WP_Error( 'capivara_link_invalido', $resultado, array( 'status' => 400 ) );
	}
	return $post;
}
add_filter( 'rest_pre_insert_vaga', 'capivara_vagas_validar_link_rest', 10, 2 );

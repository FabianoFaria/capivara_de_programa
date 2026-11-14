<?php
/**
 * Schema JobPosting (Google for Jobs) na página de cada vaga.
 *
 * @package CapivaraVagas
 */

defined( 'ABSPATH' ) || exit;

/**
 * Monta o JobPosting. Devolve null quando a vaga não atende ao mínimo exigido
 * pelo Google (ex.: remota sem país definido), para não gerar marcação inválida.
 */
function capivara_vagas_jobposting( $post_id ) {
	$post = get_post( $post_id );
	if ( ! $post || 'vaga' !== $post->post_type || 'publish' !== $post->post_status ) {
		return null;
	}
	$d = capivara_vagas_dados( $post_id );
	if ( '' === $d['empresa'] ) {
		return null;
	}

	$descricao = apply_filters( 'the_content', $post->post_content );
	$descricao = wp_kses( $descricao, array(
		'p' => array(), 'br' => array(), 'ul' => array(), 'ol' => array(), 'li' => array(),
		'strong' => array(), 'em' => array(), 'b' => array(), 'i' => array(), 'h2' => array(), 'h3' => array(), 'h4' => array(),
	) );
	if ( '' === trim( wp_strip_all_tags( $descricao ) ) ) {
		$descricao = '<p>' . esc_html( get_the_title( $post ) ) . '</p>';
	}

	$empresa = array( '@type' => 'Organization', 'name' => $d['empresa'] );
	if ( $d['empresa_site'] ) {
		$empresa['sameAs'] = $d['empresa_site'];
	}

	$schema = array(
		'@context'           => 'https://schema.org/',
		'@type'              => 'JobPosting',
		'title'              => get_the_title( $post ),
		'description'        => $descricao,
		'datePosted'         => get_post_time( 'c', false, $post ),
		'hiringOrganization' => $empresa,
		'identifier'         => array(
			'@type' => 'PropertyValue',
			'name'  => 'Capivara de Programa',
			'value' => (string) $post_id,
		),
		'url'                => get_permalink( $post ),
	);

	if ( $d['remoto'] ) {
		if ( ! $d['paises'] ) {
			return null; // O Google exige pelo menos um país em vaga 100% remota.
		}
		$schema['jobLocationType']               = 'TELECOMMUTE';
		$schema['applicantLocationRequirements'] = array_map(
			static function ( $pais ) {
				return array( '@type' => 'Country', 'name' => $pais );
			},
			$d['paises']
		);
	} else {
		$endereco = array( '@type' => 'PostalAddress', 'addressCountry' => $d['paises'] ? $d['paises'][0] : 'BR' );
		if ( $d['local'] ) {
			$partes                      = array_map( 'trim', preg_split( '#[/,-]#', $d['local'] ) );
			$endereco['addressLocality'] = $partes[0];
			if ( ! empty( $partes[1] ) ) {
				$endereco['addressRegion'] = $partes[1];
			}
		}
		$schema['jobLocation'] = array( '@type' => 'Place', 'address' => $endereco );
	}

	$tipos = array(
		'clt'        => 'FULL_TIME',
		'pj'         => 'CONTRACTOR',
		'estagio'    => 'INTERN',
		'freelance'  => 'CONTRACTOR',
		'temporario' => 'TEMPORARY',
		'outro'      => 'OTHER',
	);
	if ( isset( $tipos[ $d['contrato'] ] ) ) {
		$schema['employmentType'] = $tipos[ $d['contrato'] ];
	}

	$min = capivara_vagas_numero( $post_id, 'salario_min' );
	$max = capivara_vagas_numero( $post_id, 'salario_max' );
	if ( null !== $min || null !== $max ) {
		$valor = array(
			'@type'    => 'QuantitativeValue',
			'unitText' => get_post_meta( $post_id, 'salario_periodo', true ) ?: 'MONTH',
		);
		if ( null !== $min && null !== $max && $max > $min ) {
			$valor['minValue'] = $min;
			$valor['maxValue'] = $max;
		} else {
			$valor['value'] = null !== $min ? $min : $max;
		}
		$schema['baseSalary'] = array(
			'@type'    => 'MonetaryAmount',
			'currency' => get_post_meta( $post_id, 'moeda', true ) ?: 'BRL',
			'value'    => $valor,
		);
	}

	if ( $d['validade'] ) {
		$schema['validThrough'] = $d['validade']->setTime( 23, 59, 59 )->format( 'c' );
	}

	return apply_filters( 'capivara_vagas_jobposting', $schema, $post_id );
}

function capivara_vagas_imprimir_schema() {
	if ( ! is_singular( 'vaga' ) ) {
		return;
	}
	$schema = capivara_vagas_jobposting( get_queried_object_id() );
	if ( $schema ) {
		echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . "</script>\n";
	}
}
add_action( 'wp_head', 'capivara_vagas_imprimir_schema', 20 );

/**
 * Rank Math: na página de vaga, tira o schema de artigo para não competir
 * com o JobPosting. O restante (site, breadcrumbs) fica.
 */
function capivara_vagas_rank_math_schema( $data ) {
	if ( ! is_singular( 'vaga' ) || ! is_array( $data ) ) {
		return $data;
	}
	foreach ( $data as $chave => $item ) {
		$tipo = is_array( $item ) && isset( $item['@type'] ) ? (array) $item['@type'] : array();
		if ( array_intersect( $tipo, array( 'Article', 'BlogPosting', 'NewsArticle' ) ) ) {
			unset( $data[ $chave ] );
		}
	}
	return $data;
}
add_filter( 'rank_math/json_ld', 'capivara_vagas_rank_math_schema', 99 );

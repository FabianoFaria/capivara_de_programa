<?php
/**
 * Leitura e formatação dos dados de uma vaga. Lê o post meta direto
 * (não depende do ACF estar ativo).
 *
 * @package CapivaraVagas
 */

defined( 'ABSPATH' ) || exit;

/**
 * Data de validade como DateTimeImmutable no fuso do site, ou null.
 * O ACF guarda datas como Ymd; aceita também Y-m-d.
 */
function capivara_vagas_validade( $post_id ) {
	$valor = preg_replace( '/\D/', '', (string) get_post_meta( $post_id, 'validade', true ) );
	if ( 8 !== strlen( $valor ) ) {
		return null;
	}
	$data = DateTimeImmutable::createFromFormat( '!Ymd', $valor, wp_timezone() );
	return $data ?: null;
}

/** Termos de uma taxonomia da vaga, ou array vazio. */
function capivara_vagas_termos( $post_id, $taxonomia ) {
	$termos = get_the_terms( $post_id, $taxonomia );
	return ( $termos && ! is_wp_error( $termos ) ) ? $termos : array();
}

/** Valor numérico de um campo de salário, ou null. */
function capivara_vagas_numero( $post_id, $campo ) {
	$valor = get_post_meta( $post_id, $campo, true );
	return ( '' === $valor || null === $valor || ! is_numeric( $valor ) ) ? null : (float) $valor;
}

/**
 * Salário em texto: "R$ 8.000 a R$ 12.000 por mês", "A partir de US$ 4.000 por mês"
 * ou "" quando não informado.
 */
function capivara_vagas_salario_texto( $post_id ) {
	$min     = capivara_vagas_numero( $post_id, 'salario_min' );
	$max     = capivara_vagas_numero( $post_id, 'salario_max' );
	$moeda   = get_post_meta( $post_id, 'moeda', true ) ?: 'BRL';
	$periodo = get_post_meta( $post_id, 'salario_periodo', true ) ?: 'MONTH';

	if ( null === $min && null === $max ) {
		return '';
	}
	$simbolos = array( 'BRL' => 'R$', 'USD' => 'US$', 'EUR' => '€' );
	$simbolo  = isset( $simbolos[ $moeda ] ) ? $simbolos[ $moeda ] : $moeda;
	$fmt      = static function ( $v ) use ( $simbolo ) {
		return $simbolo . ' ' . number_format( $v, 0, ',', '.' );
	};
	$periodos = array(
		'MONTH' => __( 'por mês', 'capivara-vagas' ),
		'YEAR'  => __( 'por ano', 'capivara-vagas' ),
		'HOUR'  => __( 'por hora', 'capivara-vagas' ),
	);
	$sufixo = isset( $periodos[ $periodo ] ) ? $periodos[ $periodo ] : '';

	if ( null !== $min && null !== $max && $max > $min ) {
		/* translators: 1: salário mínimo, 2: salário máximo, 3: período ("por mês"). */
		return sprintf( __( '%1$s a %2$s %3$s', 'capivara-vagas' ), $fmt( $min ), $fmt( $max ), $sufixo );
	}
	if ( null !== $min && null === $max ) {
		/* translators: 1: salário, 2: período ("por mês"). */
		return sprintf( __( 'A partir de %1$s %2$s', 'capivara-vagas' ), $fmt( $min ), $sufixo );
	}
	return trim( $fmt( null !== $max ? $max : $min ) . ' ' . $sufixo );
}

/** Link de candidatura pronto para href (https ou mailto:), ou "". */
function capivara_vagas_link_candidatura( $post_id ) {
	$valor = trim( (string) get_post_meta( $post_id, 'link_candidatura', true ) );
	if ( is_email( $valor ) ) {
		return 'mailto:' . $valor;
	}
	return preg_match( '#^https?://#i', $valor ) ? esc_url_raw( $valor ) : '';
}

/** Códigos de país (ISO 3166-1 alfa-2) aceitos numa vaga remota. */
function capivara_vagas_paises( $post_id ) {
	$valor = strtoupper( (string) get_post_meta( $post_id, 'paises', true ) );
	preg_match_all( '/\b[A-Z]{2}\b/', $valor, $m );
	return array_values( array_unique( $m[0] ) );
}

/**
 * Tudo o que os blocos e o schema precisam, num array só.
 */
function capivara_vagas_dados( $post_id ) {
	$contratos = capivara_vagas_contratos();
	$contrato  = get_post_meta( $post_id, 'contrato', true );
	$modelos   = capivara_vagas_termos( $post_id, 'vaga_modelo' );

	return array(
		'empresa'      => trim( (string) get_post_meta( $post_id, 'empresa', true ) ),
		'empresa_site' => esc_url_raw( (string) get_post_meta( $post_id, 'empresa_site', true ) ),
		'link'         => capivara_vagas_link_candidatura( $post_id ),
		'contrato'     => $contrato,
		'contrato_txt' => isset( $contratos[ $contrato ] ) ? $contratos[ $contrato ] : '',
		'local'        => trim( (string) get_post_meta( $post_id, 'localizacao', true ) ),
		'paises'       => capivara_vagas_paises( $post_id ),
		'salario'      => capivara_vagas_salario_texto( $post_id ),
		'validade'     => capivara_vagas_validade( $post_id ),
		'destaque'     => (bool) get_post_meta( $post_id, 'destaque', true ),
		'fonte_nome'   => trim( (string) get_post_meta( $post_id, 'fonte_nome', true ) ),
		'fonte_url'    => esc_url_raw( (string) get_post_meta( $post_id, 'fonte_url', true ) ),
		'modelos'      => $modelos,
		'remoto'       => (bool) array_filter( $modelos, static function ( $t ) {
			return 'remoto' === $t->slug;
		} ),
		'senioridades' => capivara_vagas_termos( $post_id, 'vaga_senioridade' ),
		'stacks'       => capivara_vagas_termos( $post_id, 'vaga_stack' ),
	);
}

/** "Remoto (Brasil)", "Híbrido · São Paulo/SP", "Presencial · Recife/PE". */
function capivara_vagas_onde( $d ) {
	$modelo = $d['modelos'] ? $d['modelos'][0]->name : '';
	if ( $d['remoto'] ) {
		if ( array( 'BR' ) === $d['paises'] ) {
			/* translators: modelo de trabalho, ex.: "Remoto". */
			return sprintf( __( '%s (Brasil)', 'capivara-vagas' ), $modelo );
		}
		return $d['paises'] ? $modelo . ' (' . implode( ', ', $d['paises'] ) . ')' : $modelo;
	}
	return trim( $modelo . ( $d['local'] ? ' · ' . $d['local'] : '' ), ' ·' );
}

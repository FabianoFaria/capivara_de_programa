<?php
/**
 * Validade das vagas: 30 dias por padrão e saída automática do ar.
 *
 * Vaga vencida volta para rascunho com a marca _capivara_expirada. Assim ela
 * some do site, do sitemap e do Google (que não aceita vaga vencida no ar).
 * Para reabrir: mude a data "Aberta até" e publique de novo.
 *
 * @package CapivaraVagas
 */

defined( 'ABSPATH' ) || exit;

const CAPIVARA_VAGAS_DIAS_PADRAO = 30;

/**
 * Depois de salvar (painel ou REST, já com campos e termos gravados):
 * preenche a validade vazia e limpa a marca de expirada ao republicar.
 */
function capivara_vagas_depois_de_salvar( $post_id, $post ) {
	if ( 'vaga' !== $post->post_type || wp_is_post_revision( $post_id ) ) {
		return;
	}
	if ( ! capivara_vagas_validade( $post_id ) && 'publish' === $post->post_status ) {
		$base = get_post_datetime( $post, 'date' ) ?: new DateTimeImmutable( 'now', wp_timezone() );
		$data = $base->modify( '+' . CAPIVARA_VAGAS_DIAS_PADRAO . ' days' )->format( 'Ymd' );
		update_post_meta( $post_id, 'validade', $data );
		update_post_meta( $post_id, '_validade', 'field_cv_validade' );
	}
	if ( 'publish' === $post->post_status && ! capivara_vagas_vencida( $post_id ) ) {
		delete_post_meta( $post_id, '_capivara_expirada' );
	}
	capivara_vagas_sincronizar_destaque( $post_id );
}

/**
 * Espelha o campo "destaque" em menu_order (1 ou 0), usado para ordenar a lista
 * com as vagas em destaque primeiro. Grava direto na tabela para não disparar
 * outro salvamento.
 */
function capivara_vagas_sincronizar_destaque( $post_id ) {
	global $wpdb;
	$ordem = get_post_meta( $post_id, 'destaque', true ) ? 1 : 0;
	if ( (int) get_post_field( 'menu_order', $post_id ) !== $ordem ) {
		$wpdb->update( $wpdb->posts, array( 'menu_order' => $ordem ), array( 'ID' => $post_id ) );
		clean_post_cache( $post_id );
	}
}

/** Também quando o destaque muda sozinho (ex.: edição rápida do meta). */
function capivara_vagas_destaque_meta( $meta_id, $post_id, $chave ) {
	if ( 'destaque' === $chave && 'vaga' === get_post_type( $post_id ) ) {
		capivara_vagas_sincronizar_destaque( $post_id );
	}
}
add_action( 'added_post_meta', 'capivara_vagas_destaque_meta', 10, 3 );
add_action( 'updated_post_meta', 'capivara_vagas_destaque_meta', 10, 3 );
add_action( 'deleted_post_meta', 'capivara_vagas_destaque_meta', 10, 3 );
add_action( 'wp_after_insert_post', 'capivara_vagas_depois_de_salvar', 10, 2 );

/** A vaga já passou da data "Aberta até"? (vale até o fim do dia) */
function capivara_vagas_vencida( $post_id ) {
	$validade = capivara_vagas_validade( $post_id );
	if ( ! $validade ) {
		return false;
	}
	$hoje = new DateTimeImmutable( 'today', wp_timezone() );
	return $validade < $hoje;
}

function capivara_vagas_agendar_expiracao() {
	if ( ! wp_next_scheduled( 'capivara_vagas_expirar' ) ) {
		wp_schedule_event( time() + 60, 'hourly', 'capivara_vagas_expirar' );
	}
}
add_action( 'init', 'capivara_vagas_agendar_expiracao' );

/**
 * Tira do ar as vagas vencidas. Roda de hora em hora pelo agendador do WordPress
 * (no servidor, o cron do sistema chama o wp-cron.php a cada 5 minutos).
 *
 * @return int Quantidade de vagas que saíram do ar.
 */
function capivara_vagas_expirar() {
	$hoje = ( new DateTimeImmutable( 'today', wp_timezone() ) )->format( 'Ymd' );
	$ids  = get_posts(
		array(
			'post_type'      => 'vaga',
			'post_status'    => 'publish',
			'fields'         => 'ids',
			'posts_per_page' => 200,
			'no_found_rows'  => true,
			'meta_query'     => array(
				array(
					'key'     => 'validade',
					'value'   => $hoje,
					'compare' => '<',
					'type'    => 'NUMERIC',
				),
			),
		)
	);
	foreach ( $ids as $id ) {
		update_post_meta( $id, '_capivara_expirada', 1 );
		wp_update_post( array( 'ID' => $id, 'post_status' => 'draft' ) );
	}
	if ( $ids && function_exists( 'w3tc_flush_all' ) ) {
		w3tc_flush_all(); // Lista de vagas no cache não pode mostrar vaga vencida.
	}
	return count( $ids );
}
add_action( 'capivara_vagas_expirar', 'capivara_vagas_expirar' );

/**
 * Quando uma vaga entra ou sai do ar, limpa o cache de páginas (W3 Total Cache),
 * para a lista /vagas/, as páginas de stack e a faixa da página inicial não
 * mostrarem vaga velha. Publicar vaga é raro, então limpar tudo é aceitável.
 */
function capivara_vagas_limpar_cache( $novo, $antigo, $post ) {
	if ( 'vaga' !== $post->post_type || ( 'publish' !== $novo && 'publish' !== $antigo ) ) {
		return;
	}
	if ( function_exists( 'w3tc_flush_all' ) ) {
		w3tc_flush_all();
	}
}
add_action( 'transition_post_status', 'capivara_vagas_limpar_cache', 10, 3 );

<?php
/**
 * Painel: aviso do ACF, colunas da lista de vagas e destaque primeiro.
 *
 * @package CapivaraVagas
 */

defined( 'ABSPATH' ) || exit;

function capivara_vagas_aviso_acf() {
	if ( function_exists( 'acf_add_local_field_group' ) || ! current_user_can( 'activate_plugins' ) ) {
		return;
	}
	echo '<div class="notice notice-warning"><p>' . esc_html__( 'Capivara Vagas: instale e ative o plugin Advanced Custom Fields (ACF) para editar os dados das vagas (empresa, salário, validade...).', 'capivara-vagas' ) . '</p></div>';
}
add_action( 'admin_notices', 'capivara_vagas_aviso_acf' );

function capivara_vagas_colunas( $colunas ) {
	$novas = array();
	foreach ( $colunas as $chave => $rotulo ) {
		$novas[ $chave ] = $rotulo;
		if ( 'title' === $chave ) {
			$novas['cv_empresa']  = __( 'Empresa', 'capivara-vagas' );
			$novas['cv_validade'] = __( 'Aberta até', 'capivara-vagas' );
		}
	}
	unset( $novas['author'] );
	return $novas;
}
add_filter( 'manage_vaga_posts_columns', 'capivara_vagas_colunas' );

function capivara_vagas_coluna_valor( $coluna, $post_id ) {
	if ( 'cv_empresa' === $coluna ) {
		echo esc_html( get_post_meta( $post_id, 'empresa', true ) );
		if ( get_post_meta( $post_id, 'destaque', true ) ) {
			echo ' <span title="' . esc_attr__( 'Destaque', 'capivara-vagas' ) . '">★</span>';
		}
	}
	if ( 'cv_validade' === $coluna ) {
		$validade = capivara_vagas_validade( $post_id );
		if ( get_post_meta( $post_id, '_capivara_expirada', true ) ) {
			echo '<strong>' . esc_html__( 'Expirada', 'capivara-vagas' ) . '</strong> · ';
		}
		echo $validade ? esc_html( wp_date( 'd/m/Y', $validade->getTimestamp() ) ) : '—';
	}
}
add_action( 'manage_vaga_posts_custom_column', 'capivara_vagas_coluna_valor', 10, 2 );

/**
 * Na lista pública de vagas (arquivo e taxonomias), as em destaque vêm primeiro
 * e depois as mais recentes.
 */
function capivara_vagas_ordem( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( $query->is_post_type_archive( 'vaga' ) || $query->is_tax( array( 'vaga_stack', 'vaga_modelo', 'vaga_senioridade' ) ) ) {
		$query->set( 'posts_per_page', 20 );
		// O destaque fica espelhado em menu_order (1 = destaque), que ordena sem join de meta.
		$query->set( 'orderby', array( 'menu_order' => 'DESC', 'date' => 'DESC' ) );
	}
}
add_action( 'pre_get_posts', 'capivara_vagas_ordem' );

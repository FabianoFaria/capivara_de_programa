<?php
/**
 * Ao ativar o tema: cria as categorias e a página de Vagas, se ainda não existirem.
 * Nada é apagado ou sobrescrito.
 *
 * @package Capivara
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Cria a estrutura inicial.
 */
function capivara_on_activate() {
	// Nomes fixos em português: são dados do site, não textos da interface, e não podem depender
	// do idioma de quem ativou o tema. A versão em inglês das categorias é criada no Polylang.
	$cats = array(
		'noticias'     => 'Notícias',
		'tutoriais'    => 'Tutoriais',
		'diario-de-dev' => 'Diário de dev',
	);
	foreach ( $cats as $slug => $name ) {
		if ( ! term_exists( $slug, 'category' ) ) {
			wp_insert_term( $name, 'category', array( 'slug' => $slug ) );
		}
	}

	if ( ! get_page_by_path( 'vagas' ) ) {
		$content = '';
		$pattern = WP_Block_Patterns_Registry::get_instance()->get_registered( 'capivara/vagas-pagina' );
		if ( $pattern && ! empty( $pattern['content'] ) ) {
			$content = $pattern['content'];
		}
		$page_id = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'draft',
				'post_title'   => 'Vagas',
				'post_name'    => 'vagas',
				'post_content' => wp_slash( $content ),
			)
		);
		if ( $page_id && ! is_wp_error( $page_id ) ) {
			update_post_meta( $page_id, '_wp_page_template', 'page-vagas' );
		}
	}
}
add_action( 'after_switch_theme', 'capivara_on_activate' );

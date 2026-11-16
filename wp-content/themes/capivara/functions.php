<?php
/**
 * Capivara de Programa — funções do tema.
 *
 * @package Capivara
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CAPIVARA_VERSION', '1.3.1' );

require_once get_template_directory() . '/inc/helpers.php';
require_once get_template_directory() . '/inc/anuncios.php';
require_once get_template_directory() . '/inc/tempo-de-leitura.php';
require_once get_template_directory() . '/inc/miniatura.php';
require_once get_template_directory() . '/inc/ativacao.php';
require_once get_template_directory() . '/inc/idiomas.php';
require_once get_template_directory() . '/inc/compartilhar.php';

/**
 * Recursos do tema.
 */
function capivara_setup() {
	load_theme_textdomain( 'capivara', get_template_directory() . '/languages' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'style.css' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'automatic-feed-links' );
}
add_action( 'after_setup_theme', 'capivara_setup' );

/**
 * CSS e JS do front-end.
 */
function capivara_assets() {
	wp_enqueue_style(
		'capivara-style',
		get_stylesheet_uri(),
		array(),
		CAPIVARA_VERSION
	);

	if ( is_singular() ) {
		wp_enqueue_script(
			'capivara-copiar-codigo',
			get_template_directory_uri() . '/assets/js/copiar-codigo.js',
			array(),
			CAPIVARA_VERSION,
			array(
				'in_footer' => true,
				'strategy'  => 'defer',
			)
		);
		wp_add_inline_script(
			'capivara-copiar-codigo',
			'window.capivaraCopiar = ' . wp_json_encode(
				array(
					'copiar'  => __( 'Copiar', 'capivara' ),
					'copiado' => __( 'Copiado!', 'capivara' ),
					'rotulo'  => __( 'Copiar código', 'capivara' ),
				)
			) . ';',
			'before'
		);
	}
}
add_action( 'wp_enqueue_scripts', 'capivara_assets' );

/**
 * Categoria própria para os padrões do tema.
 */
function capivara_pattern_categories() {
	register_block_pattern_category(
		'capivara',
		array( 'label' => __( 'Capivara de Programa', 'capivara' ) )
	);
}
add_action( 'init', 'capivara_pattern_categories' );

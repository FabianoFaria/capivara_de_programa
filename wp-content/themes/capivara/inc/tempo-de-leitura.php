<?php
/**
 * Tempo de leitura como fonte de "block bindings" (WordPress 6.5+).
 * Num bloco Parágrafo: {"metadata":{"bindings":{"content":{"source":"capivara/tempo-de-leitura"}}}}
 *
 * @package Capivara
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Minutos estimados de leitura de um post (200 palavras por minuto, código conta igual).
 *
 * @param int $post_id ID do post.
 * @return int
 */
function capivara_reading_minutes( $post_id ) {
	$content = get_post_field( 'post_content', $post_id );
	$text    = wp_strip_all_tags( strip_shortcodes( (string) $content ) );
	$words   = preg_split( '/\s+/u', trim( $text ), -1, PREG_SPLIT_NO_EMPTY );
	$count   = is_array( $words ) ? count( $words ) : 0;
	return max( 1, (int) ceil( $count / 200 ) );
}

/**
 * Registro da fonte.
 */
function capivara_register_reading_time_source() {
	if ( ! function_exists( 'register_block_bindings_source' ) ) {
		return;
	}
	register_block_bindings_source(
		'capivara/tempo-de-leitura',
		array(
			'label'              => __( 'Tempo de leitura', 'capivara' ),
			'uses_context'       => array( 'postId' ),
			'get_value_callback' => function ( $source_args, $block_instance ) {
				$post_id = isset( $block_instance->context['postId'] ) ? (int) $block_instance->context['postId'] : get_the_ID();
				if ( ! $post_id ) {
					return '';
				}
				$min = capivara_reading_minutes( $post_id );
				/* translators: %d: minutos */
				return esc_html( sprintf( _n( '%d min de leitura', '%d min de leitura', $min, 'capivara' ), $min ) );
			},
		)
	);
}
add_action( 'init', 'capivara_register_reading_time_source' );

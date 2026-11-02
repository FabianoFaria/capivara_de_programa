<?php
/**
 * Miniatura "terminal" para posts sem imagem destacada.
 * Vale só para o bloco Imagem destacada com a classe "capivara-fallback" (os cards das listas).
 *
 * @package Capivara
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @param string   $content  HTML do bloco.
 * @param array    $block    Bloco analisado.
 * @param WP_Block $instance Instância.
 * @return string
 */
function capivara_featured_image_fallback( $content, $block, $instance ) {
	if ( '' !== trim( $content ) ) {
		return $content;
	}
	$class = isset( $block['attrs']['className'] ) ? $block['attrs']['className'] : '';
	if ( false === strpos( $class, 'capivara-fallback' ) ) {
		return $content;
	}
	$post_id = isset( $instance->context['postId'] ) ? (int) $instance->context['postId'] : 0;
	if ( ! $post_id ) {
		return $content;
	}

	$tags = get_the_tags( $post_id );
	$cats = get_the_category( $post_id );
	$cat  = ( $cats && ! is_wp_error( $cats ) ) ? $cats[0] : null;

	if ( $tags && ! is_wp_error( $tags ) ) {
		$topic = $tags[0]->slug;
	} elseif ( $cat ) {
		$topic = $cat->slug;
	} else {
		$topic = 'post';
	}

	$line1 = '$ cat ' . $topic . '.md';
	$line2 = $cat ? '# ' . $cat->name : '# Capivara de Programa';
	$color = abs( crc32( $cat ? $cat->slug : $topic ) ) % 6;

	return sprintf(
		'<a class="capivara-thumb capivara-thumb--%1$d" href="%2$s" aria-hidden="true" tabindex="-1">%3$s<span>%4$s</span></a>',
		$color,
		esc_url( get_permalink( $post_id ) ),
		esc_html( $line1 ),
		esc_html( $line2 )
	);
}
add_filter( 'render_block_core/post-featured-image', 'capivara_featured_image_fallback', 10, 3 );

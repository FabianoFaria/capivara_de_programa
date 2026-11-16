<?php
/**
 * Bloco "Compartilhar" (capivara/compartilhar): botões para o leitor compartilhar o post ou a vaga.
 *
 * Cada botão é só um link para a página de compartilhamento da rede: nenhum script de terceiros,
 * nenhum rastreamento e nada que dependa de cookies. No celular, o botão "Compartilhar" abre o menu
 * nativo do aparelho (Instagram, Discord etc.), quando o navegador oferece esse recurso.
 *
 * @package Capivara
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Redes exibidas, na ordem. Filtro: capivara_compartilhar_redes.
 *
 * @return string[]
 */
function capivara_share_networks() {
	$redes = array( 'whatsapp', 'telegram', 'linkedin', 'x', 'facebook' );
	return (array) apply_filters( 'capivara_compartilhar_redes', $redes );
}

/**
 * Nome e URL de compartilhamento de cada rede.
 *
 * @param string $rede Rede.
 * @param string $url  Endereço do post.
 * @param string $text Texto (título).
 * @return array|null array( nome, url ) ou null se a rede não existir.
 */
function capivara_share_link( $rede, $url, $text ) {
	switch ( $rede ) {
		case 'whatsapp':
			return array( 'WhatsApp', 'https://wa.me/?text=' . rawurlencode( $text . ' ' . $url ) );
		case 'telegram':
			return array( 'Telegram', 'https://t.me/share/url?url=' . rawurlencode( $url ) . '&text=' . rawurlencode( $text ) );
		case 'linkedin':
			return array( 'LinkedIn', 'https://www.linkedin.com/sharing/share-offsite/?url=' . rawurlencode( $url ) );
		case 'x':
			return array( 'X', 'https://x.com/intent/tweet?text=' . rawurlencode( $text ) . '&url=' . rawurlencode( $url ) );
		case 'facebook':
			return array( 'Facebook', 'https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode( $url ) );
		case 'bluesky':
			return array( 'Bluesky', 'https://bsky.app/intent/compose?text=' . rawurlencode( $text . ' ' . $url ) );
	}
	return null;
}

/**
 * Ícone da rede. Usa os ícones do bloco "Ícones sociais" do próprio WordPress.
 *
 * @param string $rede Rede.
 * @return string SVG.
 */
function capivara_share_icon( $rede ) {
	if ( function_exists( 'block_core_social_link_get_icon' ) ) {
		$svg = block_core_social_link_get_icon( $rede );
		if ( $svg ) {
			return str_replace( '<svg ', '<svg aria-hidden="true" focusable="false" ', $svg );
		}
	}
	return '<span aria-hidden="true">' . esc_html( strtoupper( substr( $rede, 0, 1 ) ) ) . '</span>';
}

/**
 * Renderização do bloco.
 *
 * @param array    $attributes Atributos.
 * @param string   $content    Conteúdo (vazio).
 * @param WP_Block $block      Instância.
 * @return string
 */
function capivara_render_share( $attributes, $content, $block ) {
	$post_id = isset( $block->context['postId'] ) ? (int) $block->context['postId'] : (int) get_queried_object_id();
	if ( ! $post_id || 'publish' !== get_post_status( $post_id ) ) {
		return '';
	}

	$url   = get_permalink( $post_id );
	$title = html_entity_decode( wp_strip_all_tags( get_the_title( $post_id ) ), ENT_QUOTES, 'UTF-8' );

	if ( 'vaga' === get_post_type( $post_id ) ) {
		/* translators: %s: título da vaga */
		$text  = sprintf( __( 'Vaga: %s', 'capivara' ), $title );
		$label = __( 'Compartilhe esta vaga', 'capivara' );
	} else {
		$text  = $title;
		$label = __( 'Compartilhe', 'capivara' );
	}

	$items = '';

	// Menu nativo do aparelho (aparece só onde o navegador suporta; o script tira o "hidden").
	$items .= sprintf(
		'<li class="capivara-share__item capivara-share__item--native" hidden><button type="button" class="capivara-share__btn capivara-share__btn--native" data-capivara-share-native data-title="%1$s" data-text="%2$s" data-url="%3$s"><svg aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><path d="M8.6 13.5l6.8 4M15.4 6.5l-6.8 4"></path></svg><span>%4$s</span></button></li>',
		esc_attr( $title ),
		esc_attr( $text ),
		esc_url( $url ),
		esc_html__( 'Compartilhar', 'capivara' )
	);

	foreach ( capivara_share_networks() as $rede ) {
		$link = capivara_share_link( $rede, $url, $text );
		if ( ! $link ) {
			continue;
		}
		/* translators: %s: nome da rede social */
		$aria   = sprintf( __( 'Compartilhar no %s (abre em nova aba)', 'capivara' ), $link[0] );
		$items .= sprintf(
			'<li class="capivara-share__item"><a class="capivara-share__btn capivara-share__btn--icon capivara-share__btn--%1$s" href="%2$s" target="_blank" rel="noopener noreferrer nofollow" aria-label="%3$s" title="%4$s">%5$s</a></li>',
			esc_attr( $rede ),
			esc_url( $link[1] ),
			esc_attr( $aria ),
			esc_attr( $link[0] ),
			capivara_share_icon( $rede ) // SVG do núcleo do WordPress.
		);
	}

	$items .= sprintf(
		'<li class="capivara-share__item"><button type="button" class="capivara-share__btn capivara-share__btn--copy" data-capivara-share-copy data-url="%1$s" data-copied="%2$s" data-error="%3$s"><svg aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.5.5l3-3a5 5 0 0 0-7-7l-1.7 1.7"></path><path d="M14 11a5 5 0 0 0-7.5-.5l-3 3a5 5 0 0 0 7 7l1.7-1.7"></path></svg><span data-capivara-share-copy-label>%4$s</span></button></li>',
		esc_url( $url ),
		esc_attr__( 'Link copiado!', 'capivara' ),
		esc_attr__( 'Não deu para copiar. Copie o endereço na barra do navegador.', 'capivara' ),
		esc_html__( 'Copiar link', 'capivara' )
	);

	$wrapper = get_block_wrapper_attributes(
		array(
			'class'      => 'capivara-share',
			'aria-label' => $label,
		)
	);

	return sprintf(
		'<nav %1$s><p class="capivara-share__label">%2$s</p><ul class="capivara-share__list">%3$s</ul><span class="capivara-visually-hidden" role="status" aria-live="polite" data-capivara-share-status></span></nav>',
		$wrapper,
		esc_html( $label ),
		$items
	);
}

/**
 * Registro do bloco.
 */
function capivara_register_share_block() {
	register_block_type(
		get_template_directory() . '/blocks/compartilhar',
		array(
			'render_callback' => 'capivara_render_share',
		)
	);
}
add_action( 'init', 'capivara_register_share_block' );

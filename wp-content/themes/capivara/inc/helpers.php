<?php
/**
 * Funções auxiliares usadas pelos padrões.
 *
 * @package Capivara
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * URL de uma categoria ou tag pelo slug. Funciona mesmo antes de o termo existir
 * ou com qualquer estrutura de links permanentes (o WordPress redireciona para a URL bonita).
 *
 * @param string $slug     Slug do termo.
 * @param string $taxonomy 'category' ou 'post_tag'.
 * @return string
 */
function capivara_term_url( $slug, $taxonomy = 'category' ) {
	// 'lang' => '' faz o Polylang (se ativo) buscar em todos os idiomas; sem ele, o argumento é ignorado.
	$terms = get_terms(
		array(
			'taxonomy'   => $taxonomy,
			'slug'       => $slug,
			'hide_empty' => false,
			'number'     => 1,
			'lang'       => '',
		)
	);
	$term  = ( is_array( $terms ) && $terms ) ? capivara_translate_term( $terms[0] ) : null;
	if ( $term && ! is_wp_error( $term ) ) {
		$link = get_term_link( $term );
		if ( ! is_wp_error( $link ) ) {
			return $link;
		}
	}
	$var = ( 'post_tag' === $taxonomy ) ? 'tag' : 'category_name';
	return add_query_arg( $var, $slug, home_url( '/' ) );
}

/**
 * URL de uma página pelo slug.
 *
 * @param string $slug Slug da página.
 * @return string
 */
function capivara_page_url( $slug ) {
	$page = get_page_by_path( $slug );
	if ( $page ) {
		return get_permalink( capivara_translate_post_id( $page->ID ) );
	}
	return add_query_arg( 'pagename', $slug, home_url( '/' ) );
}

/**
 * Endereço da lista de vagas. Com o plugin Capivara Vagas, /vagas/ é o arquivo do
 * tipo de post "vaga"; sem ele, é a página "vagas". Nos dois casos o endereço é o
 * mesmo, e um valor fixo evita que o cache dos padrões guarde um link antigo.
 *
 * @return string
 */
function capivara_vagas_url() {
	return home_url( '/vagas/' );
}

/**
 * Termo equivalente no idioma atual, quando há um plugin de idiomas (Polylang).
 * Sem plugin, ou sem tradução, devolve o próprio termo.
 *
 * @param WP_Term $term Termo.
 * @return WP_Term
 */
function capivara_translate_term( $term ) {
	if ( function_exists( 'pll_get_term' ) ) {
		$id = pll_get_term( $term->term_id );
		if ( $id && (int) $id !== (int) $term->term_id ) {
			$translated = get_term( (int) $id, $term->taxonomy );
			if ( $translated instanceof WP_Term ) {
				return $translated;
			}
		}
	}
	return $term;
}

/**
 * ID do post ou página equivalente no idioma atual (Polylang). Sem plugin, devolve o mesmo ID.
 *
 * @param int $post_id ID.
 * @return int
 */
function capivara_translate_post_id( $post_id ) {
	if ( function_exists( 'pll_get_post' ) ) {
		$id = pll_get_post( $post_id );
		if ( $id ) {
			return (int) $id;
		}
	}
	return (int) $post_id;
}

/**
 * Texto pronto para ir dentro de uma string JSON nos atributos de um bloco
 * (por exemplo {"label":"<?php echo capivara_attr( __( 'Início', 'capivara' ) ); ?>"}).
 * Usa a mesma codificação do editor, então aspas, < e > não quebram o bloco.
 *
 * @param string $text Texto já traduzido.
 * @return string
 */
function capivara_attr( $text ) {
	return substr( serialize_block_attributes( array( (string) $text ) ), 2, -2 );
}

/**
 * URL de uma imagem do tema.
 *
 * @param string $file Nome do arquivo em assets/images.
 * @return string
 */
function capivara_img( $file ) {
	return get_template_directory_uri() . '/assets/images/' . $file;
}

/**
 * Marcação do card de post usada nas listas (Query Loop).
 * Fica num só lugar para a home, o blog, arquivos e busca ficarem iguais.
 *
 * @return string
 */
function capivara_card_markup() {
	return '<!-- wp:group {"className":"capivara-card","style":{"spacing":{"blockGap":"12px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group capivara-card"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/9","className":"capivara-fallback"} /-->

<!-- wp:post-terms {"term":"category","className":"capivara-terms"} /-->

<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"x-large"} /-->

<!-- wp:group {"className":"capivara-meta","style":{"spacing":{"blockGap":"8px"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group capivara-meta"><!-- wp:post-date {"fontSize":"small"} /-->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"capivara/tempo-de-leitura"}}},"textColor":"muted","fontSize":"small"} -->
<p class="has-muted-color has-text-color has-small-font-size"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->';
}

/**
 * "Leia também" (queryId 3): no post aberto, tira o próprio post e prioriza a mesma categoria.
 *
 * @param array    $query Argumentos do WP_Query.
 * @param WP_Block $block Bloco Post Template.
 * @return array
 */
function capivara_related_query( $query, $block ) {
	if ( ! isset( $block->context['queryId'] ) || 3 !== (int) $block->context['queryId'] || ! is_singular( 'post' ) ) {
		return $query;
	}
	$post_id                = get_queried_object_id();
	$query['post__not_in']  = array( $post_id );
	$cats                   = wp_get_post_categories( $post_id );
	if ( $cats ) {
		$query['category__in'] = $cats;
	}
	return $query;
}
add_filter( 'query_loop_block_query_vars', 'capivara_related_query', 10, 2 );

/**
 * Query Loop em grade com o card do tema.
 *
 * @param array $args perPage (int), inherit (bool), pagination (bool), queryId (int).
 * @return string
 */
function capivara_query_markup( $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'perPage'    => 9,
			'inherit'    => true,
			'pagination' => true,
			'queryId'    => 10,
		)
	);

	$query = array(
		'perPage'  => (int) $args['perPage'],
		'pages'    => 0,
		'offset'   => 0,
		'postType' => 'post',
		'order'    => 'desc',
		'orderBy'  => 'date',
		'author'   => '',
		'search'   => '',
		'exclude'  => array(),
		'sticky'   => '',
		'inherit'  => (bool) $args['inherit'],
	);

	$attrs = array(
		'queryId' => (int) $args['queryId'],
		'query'   => $query,
		'align'   => 'wide',
		'layout'  => array( 'type' => 'default' ),
	);

	$out  = '<!-- wp:query ' . wp_json_encode( $attrs, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . " -->\n";
	$out .= '<div class="wp-block-query alignwide">';
	$out .= '<!-- wp:post-template {"style":{"spacing":{"blockGap":"40px"}},"layout":{"type":"grid","columnCount":3,"minimumColumnWidth":"300px"}} -->' . "\n";
	$out .= capivara_card_markup() . "\n";
	$out .= "<!-- /wp:post-template -->\n\n";

	if ( $args['pagination'] ) {
		$out .= '<!-- wp:query-pagination {"style":{"spacing":{"margin":{"top":"48px"}}},"layout":{"type":"flex","justifyContent":"center"}} -->' . "\n";
		$out .= "<!-- wp:query-pagination-previous {\"label\":\"" . capivara_attr( __( 'Anteriores', 'capivara' ) ) . "\"} /-->\n\n<!-- wp:query-pagination-numbers /-->\n\n<!-- wp:query-pagination-next {\"label\":\"" . capivara_attr( __( 'Próximos', 'capivara' ) ) . "\"} /-->\n";
		$out .= "<!-- /wp:query-pagination -->\n\n";
	}

	$out .= "<!-- wp:query-no-results -->\n";
	$out .= '<!-- wp:paragraph {"textColor":"muted"} -->' . "\n" . '<p class="has-muted-color has-text-color">' . esc_html__( 'Nada por aqui ainda. Tente outra busca ou volte em breve.', 'capivara' ) . '</p>' . "\n<!-- /wp:paragraph -->\n";
	$out .= "<!-- /wp:query-no-results --></div>\n";
	$out .= '<!-- /wp:query -->';

	return $out;
}

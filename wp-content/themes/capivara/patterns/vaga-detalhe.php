<?php
/**
 * Title: Página da vaga
 * Slug: capivara/vaga-detalhe
 * Categories: capivara
 * Inserter: no
 * Description: Título, descrição e caixa com os dados e o botão de candidatura (plugin Capivara Vagas).
 *
 * @package Capivara
 */
?>
<!-- wp:group {"tagName":"article","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained","contentSize":"1240px"}} -->
<article class="wp-block-group" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:group {"style":{"spacing":{"blockGap":"16px"}},"layout":{"type":"constrained","contentSize":"920px","justifyContent":"left"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"textColor":"secondary","fontFamily":"mono","fontSize":"small"} -->
<p class="has-secondary-color has-text-color has-mono-font-family has-small-font-size"><a href="<?php echo esc_url( capivara_vagas_url() ); ?>">~ / <?php esc_html_e( 'vagas', 'capivara' ); ?></a></p>
<!-- /wp:paragraph -->

<!-- wp:post-title {"level":1,"fontSize":"huge"} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"6px"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"textColor":"muted","fontSize":"small"} -->
<p class="has-muted-color has-text-color has-small-font-size"><?php esc_html_e( 'Publicada em', 'capivara' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:post-date {"format":"d/m/Y","textColor":"muted","fontSize":"small"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:columns {"style":{"spacing":{"margin":{"top":"var:preset|spacing|50"},"blockGap":{"left":"56px","top":"40px"}}}} -->
<div class="wp-block-columns" style="margin-top:var(--wp--preset--spacing--50)"><!-- wp:column {"width":"64%"} -->
<div class="wp-block-column" style="flex-basis:64%"><!-- wp:post-content {"className":"capivara-content","fontSize":"large","layout":{"type":"default"}} /-->

<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}}} -->
<p style="margin-top:var(--wp--preset--spacing--50)"><a href="<?php echo esc_url( capivara_vagas_url() ); ?>"><?php esc_html_e( '← Ver todas as vagas', 'capivara' ); ?></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"36%"} -->
<div class="wp-block-column" style="flex-basis:36%"><!-- wp:group {"className":"capivara-sticky","layout":{"type":"default"}} -->
<div class="wp-block-group capivara-sticky"><!-- wp:capivara/vaga-info {"layout":"resumo"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></article>
<!-- /wp:group -->

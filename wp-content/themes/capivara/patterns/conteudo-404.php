<?php
/**
 * Title: Conteúdo da página 404
 * Slug: capivara/conteudo-404
 * Categories: capivara
 * Inserter: no
 * Description: Mensagem de "página não encontrada" com busca.
 *
 * @package Capivara
 */
?>
<!-- wp:group {"tagName":"main","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"},"blockGap":"24px"}},"layout":{"type":"constrained"}} -->
<main class="wp-block-group" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:paragraph {"textColor":"primary","fontFamily":"mono"} -->
<p class="has-primary-color has-text-color has-mono-font-family"><?php esc_html_e( '$ cd /pagina', 'capivara' ); ?><br><?php esc_html_e( 'bash: cd: /pagina: No such file or directory', 'capivara' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"fontSize":"huge"} -->
<h1 class="wp-block-heading has-huge-font-size"><?php esc_html_e( 'Erro 404: a capivara não achou essa página.', 'capivara' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted","fontSize":"large"} -->
<p class="has-muted-color has-text-color has-large-font-size"><?php esc_html_e( 'O link pode ter mudado ou o post saiu do ar. Tente uma busca:', 'capivara' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:search {"label":"<?php echo capivara_attr( __( 'Buscar no site', 'capivara' ) ); ?>","showLabel":false,"placeholder":"<?php echo capivara_attr( __( 'Buscar no site…', 'capivara' ) ); ?>","buttonText":"<?php echo capivara_attr( __( 'Buscar', 'capivara' ) ); ?>"} /-->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Voltar para o início', 'capivara' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></main>
<!-- /wp:group -->

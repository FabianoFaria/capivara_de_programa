<?php
/**
 * Title: Faixa de vagas
 * Slug: capivara/vagas-faixa
 * Categories: capivara, call-to-action
 * Description: Chamada mostarda para a página de vagas.
 *
 * @package Capivara
 */
?>
<!-- wp:group {"align":"full","backgroundColor":"secondary","textColor":"base","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-base-color has-secondary-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:columns {"verticalAlignment":"center","align":"wide"} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"60%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:60%"><!-- wp:paragraph {"className":"capivara-pill","fontSize":"x-small"} -->
<p class="capivara-pill has-x-small-font-size"><?php esc_html_e( 'Em breve', 'capivara' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textColor":"base","fontSize":"huge"} -->
<h2 class="wp-block-heading has-base-color has-text-color has-huge-font-size"><?php esc_html_e( 'Vagas de tecnologia, sem poluição.', 'capivara' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"large"} -->
<p class="has-large-font-size"><?php esc_html_e( 'Filtre por stack, remoto de verdade e faixa salarial informada. Grátis, mantido por anúncios discretos.', 'capivara' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"40%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:40%"><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"right"}} -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"base","textColor":"secondary"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-secondary-color has-base-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( capivara_page_url( 'vagas' ) ); ?>"><?php esc_html_e( 'Ver vagas →', 'capivara' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

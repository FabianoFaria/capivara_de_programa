<?php
/**
 * Title: Barra lateral do post
 * Slug: capivara/barra-lateral-post
 * Categories: capivara
 * Inserter: no
 * Description: Anúncio lateral, chamada de vagas e busca.
 *
 * @package Capivara
 */
?>
<!-- wp:group {"tagName":"aside","style":{"spacing":{"blockGap":"24px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<aside class="wp-block-group"><!-- wp:capivara/anuncio {"slot":"lateral"} /-->

<!-- wp:group {"backgroundColor":"secondary","textColor":"base","style":{"border":{"radius":"14px"},"spacing":{"padding":{"top":"22px","bottom":"22px","left":"22px","right":"22px"},"blockGap":"10px"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group has-base-color has-secondary-background-color has-text-color has-background" style="border-radius:14px;padding-top:22px;padding-right:22px;padding-bottom:22px;padding-left:22px"><!-- wp:paragraph {"fontFamily":"display","fontSize":"x-large","style":{"typography":{"fontWeight":"800","lineHeight":"1.2"}}} -->
<p class="has-display-font-family has-x-large-font-size" style="font-weight:800;line-height:1.2"><?php esc_html_e( 'Procurando vaga?', 'capivara' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size"><?php esc_html_e( 'Veja vagas de tecnologia selecionadas, com stack e salário informados.', 'capivara' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"base","textColor":"secondary"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-secondary-color has-base-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( capivara_page_url( 'vagas' ) ); ?>"><?php esc_html_e( 'Ver vagas →', 'capivara' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:search {"label":"<?php echo capivara_attr( __( 'Buscar no site', 'capivara' ) ); ?>","placeholder":"<?php echo capivara_attr( __( 'Buscar tutoriais…', 'capivara' ) ); ?>","buttonText":"<?php echo capivara_attr( __( 'Buscar', 'capivara' ) ); ?>","buttonUseIcon":true} /--></aside>
<!-- /wp:group -->

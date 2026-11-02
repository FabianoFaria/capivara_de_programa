<?php
/**
 * Title: Rodapé
 * Slug: capivara/footer
 * Categories: footer
 * Block Types: core/template-part/footer
 * Inserter: no
 *
 * @package Capivara
 */

$capivara_privacy = get_privacy_policy_url();
if ( ! $capivara_privacy ) {
	$capivara_privacy = capivara_page_url( 'politica-de-privacidade' );
}
?>
<!-- wp:group {"tagName":"footer","backgroundColor":"base-dark","style":{"border":{"top":{"color":"var:preset|color|border","width":"1px"}}},"layout":{"type":"constrained"}} -->
<footer class="wp-block-group has-base-dark-background-color has-background" style="border-top-color:var(--wp--preset--color--border);border-top-width:1px"><!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"40px","bottom":"40px"},"blockGap":"24px"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group alignwide" style="padding-top:40px;padding-bottom:40px"><!-- wp:group {"style":{"spacing":{"blockGap":"12px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"capivara-logo capivara-logo--small"} -->
<figure class="wp-block-image size-full capivara-logo capivara-logo--small"><img src="<?php echo esc_url( capivara_img( 'icone.jpg' ) ); ?>" alt=""/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"fontFamily":"display","style":{"typography":{"fontWeight":"700"}}} -->
<p class="has-display-font-family" style="font-weight:700">Capivara de Programa <span class="has-inline-color has-muted-color">· <?php esc_html_e( 'Programação & Cia.', 'capivara' ); ?></span></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:navigation {"overlayMenu":"never","style":{"spacing":{"blockGap":"24px"}},"fontSize":"small","layout":{"type":"flex","flexWrap":"wrap"}} -->
<!-- wp:navigation-link {"label":"<?php echo capivara_attr( __( 'Sobre', 'capivara' ) ); ?>","url":"<?php echo esc_url( capivara_page_url( 'sobre' ) ); ?>","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"<?php echo capivara_attr( __( 'Anuncie', 'capivara' ) ); ?>","url":"<?php echo esc_url( capivara_page_url( 'anuncie' ) ); ?>","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"<?php echo capivara_attr( __( 'Política de privacidade (LGPD)', 'capivara' ) ); ?>","url":"<?php echo esc_url( $capivara_privacy ); ?>","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"<?php echo capivara_attr( __( 'Contato', 'capivara' ) ); ?>","url":"<?php echo esc_url( capivara_page_url( 'contato' ) ); ?>","kind":"custom","isTopLevelLink":true} /-->
<!-- /wp:navigation -->

<!-- wp:paragraph {"textColor":"muted","fontSize":"small"} -->
<p class="has-muted-color has-text-color has-small-font-size">© <?php echo esc_html( gmdate( 'Y' ) ); ?> capivaradeprograma.com.br</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></footer>
<!-- /wp:group -->

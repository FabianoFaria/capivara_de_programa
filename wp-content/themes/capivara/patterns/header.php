<?php
/**
 * Title: Cabeçalho
 * Slug: capivara/header
 * Categories: header
 * Block Types: core/template-part/header
 * Inserter: no
 *
 * @package Capivara
 */
?>
<!-- wp:group {"tagName":"header","className":"capivara-header","layout":{"type":"constrained"}} -->
<header class="wp-block-group capivara-header"><!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"16px","bottom":"16px"},"blockGap":"16px"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group alignwide" style="padding-top:16px;padding-bottom:16px"><!-- wp:group {"className":"capivara-brand","style":{"spacing":{"blockGap":"12px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group capivara-brand"><!-- wp:image {"sizeSlug":"full","linkDestination":"custom","className":"capivara-logo"} -->
<figure class="wp-block-image size-full capivara-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( capivara_img( 'icone.jpg' ) ); ?>" alt="<?php esc_attr_e( 'Capivara de Programa — início', 'capivara' ); ?>"/></a></figure>
<!-- /wp:image -->

<!-- wp:group {"style":{"spacing":{"blockGap":"2px"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:site-title {"level":0} /-->

<!-- wp:site-tagline /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:navigation {"overlayMenu":"mobile","overlayBackgroundColor":"base","overlayTextColor":"contrast","style":{"spacing":{"blockGap":"24px"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<!-- wp:navigation-link {"label":"<?php echo capivara_attr( __( 'Início', 'capivara' ) ); ?>","url":"<?php echo esc_url( home_url( '/' ) ); ?>","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"<?php echo capivara_attr( __( 'Notícias', 'capivara' ) ); ?>","url":"<?php echo esc_url( capivara_term_url( 'noticias' ) ); ?>","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"<?php echo capivara_attr( __( 'Tutoriais', 'capivara' ) ); ?>","url":"<?php echo esc_url( capivara_term_url( 'tutoriais' ) ); ?>","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"<?php echo capivara_attr( __( 'Vagas', 'capivara' ) ); ?>","url":"<?php echo esc_url( capivara_vagas_url() ); ?>","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"<?php echo capivara_attr( __( 'Lives', 'capivara' ) ); ?>","url":"<?php echo esc_url( home_url( '/#lives' ) ); ?>","kind":"custom","isTopLevelLink":true} /-->
<!-- /wp:navigation -->

<!-- wp:group {"style":{"spacing":{"blockGap":"12px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:capivara/idiomas /-->

<!-- wp:search {"label":"<?php echo capivara_attr( __( 'Buscar', 'capivara' ) ); ?>","showLabel":false,"placeholder":"<?php echo capivara_attr( __( 'Buscar no site…', 'capivara' ) ); ?>","buttonText":"<?php echo capivara_attr( __( 'Buscar', 'capivara' ) ); ?>","buttonPosition":"button-only","buttonUseIcon":true,"isSearchFieldHidden":true} /-->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"accent","textColor":"base","className":"capivara-live-dot","style":{"border":{"radius":"10px"},"spacing":{"padding":{"top":"10px","bottom":"10px","left":"16px","right":"16px"}}}} -->
<div class="wp-block-button capivara-live-dot"><a class="wp-block-button__link has-base-color has-accent-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( home_url( '/#lives' ) ); ?>" style="border-radius:10px;padding-top:10px;padding-right:16px;padding-bottom:10px;padding-left:16px"><?php esc_html_e( 'Próxima live', 'capivara' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></header>
<!-- /wp:group -->

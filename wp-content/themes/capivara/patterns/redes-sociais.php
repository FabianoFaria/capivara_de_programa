<?php
/**
 * Title: Redes sociais e RSS
 * Slug: capivara/redes-sociais
 * Categories: capivara, call-to-action
 * Description: "Acompanhe a evolução de um dev" com links das redes e do feed.
 *
 * @package Capivara
 */
?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"48px","top":"32px"}}}} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"textColor":"muted","fontSize":"x-small","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.3em"}}} -->
<p class="has-muted-color has-text-color has-x-small-font-size" style="letter-spacing:0.3em;text-transform:uppercase"><?php esc_html_e( 'Acompanhe a evolução de um dev', 'capivara' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">@capivaradeprograma</h2>
<!-- /wp:heading -->

<!-- wp:social-links {"iconColor":"contrast","iconColorValue":"#F4F1EA","iconBackgroundColor":"surface","iconBackgroundColorValue":"#17171B","showLabels":true,"size":"has-normal-icon-size","className":"is-style-default","layout":{"type":"flex","flexWrap":"wrap"}} -->
<ul class="wp-block-social-links has-normal-icon-size has-visible-labels has-icon-color has-icon-background-color is-style-default"><!-- wp:social-link {"url":"https://www.youtube.com/@capivaradeprograma","service":"youtube"} /-->

<!-- wp:social-link {"url":"https://www.instagram.com/capivaradeprograma","service":"instagram"} /-->

<!-- wp:social-link {"url":"https://x.com/capivaradeprograma","service":"x"} /-->

<!-- wp:social-link {"url":"#","service":"linkedin"} /-->

<!-- wp:social-link {"url":"#","service":"twitch"} /-->

<!-- wp:social-link {"url":"<?php echo esc_url( get_feed_link() ); ?>","service":"feed","label":"<?php echo capivara_attr( __( 'RSS', 'capivara' ) ); ?>"} /--></ul>
<!-- /wp:social-links --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"backgroundColor":"surface","borderColor":"border","style":{"border":{"width":"1px","radius":"16px"},"spacing":{"padding":{"top":"28px","bottom":"28px","left":"28px","right":"28px"},"blockGap":"14px"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group has-border-color has-border-border-color has-surface-background-color has-background" style="border-width:1px;border-radius:16px;padding-top:28px;padding-right:28px;padding-bottom:28px;padding-left:28px"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php esc_html_e( 'Receba os tutoriais novos', 'capivara' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color"><?php esc_html_e( 'Siga o Squad no daily.dev ou assine o feed RSS no seu leitor favorito.', 'capivara' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Squad no daily.dev', 'capivara' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( get_feed_link() ); ?>"><?php esc_html_e( 'Assinar o RSS', 'capivara' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

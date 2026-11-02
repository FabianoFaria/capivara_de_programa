<?php
/**
 * Title: Card de vaga
 * Slug: capivara/vaga-card
 * Categories: capivara
 * Keywords: vaga, emprego, job
 * Description: Uma vaga com cargo, empresa, modelo, stack e faixa salarial.
 *
 * @package Capivara
 */
?>
<!-- wp:group {"className":"capivara-vaga","backgroundColor":"surface","borderColor":"border","style":{"border":{"width":"1px","radius":"16px"},"spacing":{"padding":{"top":"24px","bottom":"24px","left":"24px","right":"24px"},"blockGap":"16px"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"top"}} -->
<div class="wp-block-group capivara-vaga has-border-color has-border-border-color has-surface-background-color has-background" style="border-width:1px;border-radius:16px;padding-top:24px;padding-right:24px;padding-bottom:24px;padding-left:24px"><!-- wp:group {"style":{"spacing":{"blockGap":"8px"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><a href="#"><?php esc_html_e( 'Desenvolvedor(a) Laravel Pleno', 'capivara' ); ?></a></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted","fontSize":"small"} -->
<p class="has-muted-color has-text-color has-small-font-size"><?php esc_html_e( '[Empresa] · Remoto (Brasil) · CLT', 'capivara' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"textColor":"primary-light","fontFamily":"mono","fontSize":"x-small"} -->
<p class="has-primary-light-color has-text-color has-mono-font-family has-x-small-font-size">php · laravel · mysql · docker</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"textColor":"secondary-light","style":{"typography":{"fontWeight":"700"}}} -->
<p class="has-secondary-light-color has-text-color" style="font-weight:700"><?php esc_html_e( 'R$ [faixa salarial]', 'capivara' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Candidatar-se', 'capivara' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

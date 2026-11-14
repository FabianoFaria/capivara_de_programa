<?php
/**
 * Title: Faixa de vagas
 * Slug: capivara/vagas-faixa
 * Categories: capivara, call-to-action
 * Description: Chamada mostarda para a página de vagas, com as 3 vagas mais recentes (plugin Capivara Vagas).
 *
 * @package Capivara
 */
?>
<!-- wp:group {"align":"full","backgroundColor":"secondary","textColor":"base","className":"capivara-faixa-vagas","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull capivara-faixa-vagas has-base-color has-secondary-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"left":"48px","top":"32px"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%"><!-- wp:paragraph {"className":"capivara-pill","fontSize":"x-small"} -->
<p class="capivara-pill has-x-small-font-size"><?php esc_html_e( 'Vagas', 'capivara' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textColor":"base","fontSize":"huge"} -->
<h2 class="wp-block-heading has-base-color has-text-color has-huge-font-size"><?php esc_html_e( 'Vagas de tecnologia, sem poluição.', 'capivara' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"large"} -->
<p class="has-large-font-size"><?php esc_html_e( 'Filtre por stack e por modelo de trabalho, com o salário sempre que a empresa informa. Grátis, mantido por anúncios discretos.', 'capivara' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"base","textColor":"secondary"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-secondary-color has-base-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( capivara_vagas_url() ); ?>"><?php esc_html_e( 'Ver vagas →', 'capivara' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%"><!-- wp:query {"queryId":22,"query":{"perPage":3,"pages":0,"offset":0,"postType":"vaga","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false}} -->
<div class="wp-block-query"><!-- wp:post-template -->
<!-- wp:group {"className":"capivara-vaga","backgroundColor":"base","style":{"border":{"radius":"14px"},"spacing":{"padding":{"top":"18px","bottom":"18px","left":"20px","right":"20px"},"blockGap":"6px"}},"textColor":"contrast","layout":{"type":"default"}} -->
<div class="wp-block-group capivara-vaga has-contrast-color has-base-background-color has-text-color has-background" style="border-radius:14px;padding-top:18px;padding-right:20px;padding-bottom:18px;padding-left:20px"><!-- wp:post-title {"level":3,"isLink":true,"fontSize":"large"} /-->

<!-- wp:capivara/vaga-info /--></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

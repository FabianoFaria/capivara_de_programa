<?php
/**
 * Title: Abertura com janela da live
 * Slug: capivara/hero-live
 * Categories: capivara, featured
 * Description: Título, chamada e janela "navegador" com a próxima live.
 *
 * @package Capivara
 */
?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"left":"48px","top":"40px"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"54%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:54%"><!-- wp:paragraph {"textColor":"primary","fontFamily":"mono","fontSize":"small"} -->
<p class="has-primary-color has-text-color has-mono-font-family has-small-font-size">&gt; hello world_</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading"><?php esc_html_e( 'Programação & Cia., do terminal à próxima vaga.', 'capivara' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted","fontSize":"x-large"} -->
<p class="has-muted-color has-text-color has-x-large-font-size"><?php esc_html_e( 'Notícias de tecnologia comentadas em português, tutoriais práticos de Linux, Docker, WordPress, n8n, Laravel e Node, e uma busca de vagas feita para devs.', 'capivara' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( capivara_term_url( 'tutoriais' ) ); ?>"><?php esc_html_e( 'Ler os tutoriais →', 'capivara' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( capivara_vagas_url() ); ?>"><?php esc_html_e( 'Buscar vagas', 'capivara' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"46%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:46%"><!-- wp:group {"anchor":"lives","className":"capivara-window","style":{"spacing":{"blockGap":"0"}},"backgroundColor":"code","layout":{"type":"default"}} -->
<div id="lives" class="wp-block-group capivara-window has-code-background-color has-background"><!-- wp:group {"className":"capivara-window__bar","style":{"spacing":{"padding":{"top":"10px","bottom":"10px","left":"64px","right":"16px"}}},"backgroundColor":"accent","textColor":"base","layout":{"type":"default"}} -->
<div class="wp-block-group capivara-window__bar has-base-color has-accent-background-color has-text-color has-background" style="padding-top:10px;padding-right:16px;padding-bottom:10px;padding-left:64px"><!-- wp:paragraph {"align":"center","fontFamily":"mono","fontSize":"x-small","style":{"typography":{"fontWeight":"600"}}} -->
<p class="has-text-align-center has-mono-font-family has-x-small-font-size" style="font-weight:600">capivaradeprograma.com.br/lives</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"capivara-live-cover"} -->
<figure class="wp-block-image size-full capivara-live-cover"><img src="<?php echo esc_url( capivara_img( 'icone.jpg' ) ); ?>" alt="<?php esc_attr_e( 'Mascote do Capivara de Programa', 'capivara' ); ?>"/></figure>
<!-- /wp:image -->

<!-- wp:group {"backgroundColor":"surface","style":{"spacing":{"padding":{"top":"16px","bottom":"16px","left":"20px","right":"20px"},"blockGap":"12px"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group has-surface-background-color has-background" style="padding-top:16px;padding-right:20px;padding-bottom:16px;padding-left:20px"><!-- wp:group {"style":{"spacing":{"blockGap":"2px"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"style":{"typography":{"fontWeight":"600"}}} -->
<p style="font-weight:600"><?php esc_html_e( 'Construindo o Capivara de Programa ao vivo', 'capivara' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"textColor":"muted","fontSize":"small"} -->
<p class="has-muted-color has-text-color has-small-font-size"><?php esc_html_e( '[Dia e horário] · YouTube e Twitch', 'capivara' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"style":{"border":{"radius":"999px"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="https://www.youtube.com/@capivaradeprograma" style="border-radius:999px"><?php esc_html_e( '▶ Assistir', 'capivara' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

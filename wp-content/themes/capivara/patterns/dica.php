<?php
/**
 * Title: Dica da capivara
 * Slug: capivara/dica
 * Categories: capivara, text
 * Keywords: dica, aviso, callout, nota
 * Description: Caixa de destaque para dicas dentro dos tutoriais.
 *
 * @package Capivara
 */
?>
<!-- wp:group {"className":"capivara-dica","backgroundColor":"secondary-dark","style":{"border":{"radius":"14px"},"spacing":{"padding":{"top":"20px","bottom":"20px","left":"22px","right":"22px"},"blockGap":"4px"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group capivara-dica has-secondary-dark-background-color has-background" style="border-radius:14px;padding-top:20px;padding-right:22px;padding-bottom:20px;padding-left:22px"><!-- wp:paragraph {"textColor":"secondary-light","fontFamily":"display","style":{"typography":{"fontWeight":"700"}}} -->
<p class="has-secondary-light-color has-text-color has-display-font-family" style="font-weight:700"><?php esc_html_e( 'Dica da capivara', 'capivara' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php
/* translators: %s: nome de arquivo, como .env */
printf( esc_html__( 'Guarde senhas num arquivo %s e nunca o envie para o Git.', 'capivara' ), '<code>.env</code>' );
?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<?php
/**
 * Title: Título do arquivo
 * Slug: capivara/titulo-arquivo
 * Categories: capivara
 * Inserter: no
 * Description: Abertura das páginas de categoria e tag.
 *
 * @package Capivara
 */
?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|40"}}},"layout":{"type":"constrained","contentSize":"1240px"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--40)"><!-- wp:paragraph {"textColor":"primary","fontFamily":"mono","fontSize":"small"} -->
<p class="has-primary-color has-text-color has-mono-font-family has-small-font-size"><?php esc_html_e( '~ / arquivo', 'capivara' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:query-title {"type":"archive","showPrefix":false,"fontSize":"huge"} /-->

<!-- wp:term-description {"textColor":"muted","fontSize":"large"} /--></div>
<!-- /wp:group -->

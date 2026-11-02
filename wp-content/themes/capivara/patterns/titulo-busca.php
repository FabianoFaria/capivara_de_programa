<?php
/**
 * Title: Título da busca
 * Slug: capivara/titulo-busca
 * Categories: capivara
 * Inserter: no
 * Description: Abertura da página de resultados da busca.
 *
 * @package Capivara
 */
?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|40"}}},"layout":{"type":"constrained","contentSize":"1240px"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--40)"><!-- wp:query-title {"type":"search","fontSize":"huge"} /-->

<!-- wp:search {"label":"<?php echo capivara_attr( __( 'Buscar', 'capivara' ) ); ?>","showLabel":false,"placeholder":"<?php echo capivara_attr( __( 'Buscar no site…', 'capivara' ) ); ?>","buttonText":"<?php echo capivara_attr( __( 'Buscar', 'capivara' ) ); ?>"} /--></div>
<!-- /wp:group -->

<?php
/**
 * Title: Leia também
 * Slug: capivara/leia-tambem
 * Categories: capivara, query
 * Inserter: no
 *
 * @package Capivara
 */
?>
<!-- wp:group {"backgroundColor":"surface","style":{"border":{"top":{"color":"var:preset|color|border","width":"1px"}},"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group has-surface-background-color has-background" style="border-top-color:var(--wp--preset--color--border);border-top-width:1px;padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:heading {"align":"wide"} -->
<h2 class="wp-block-heading alignwide"><?php esc_html_e( 'Leia também', 'capivara' ); ?></h2>
<!-- /wp:heading -->

<?php
echo capivara_query_markup( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- marcação de blocos fixa.
	array(
		'perPage'    => 3,
		'inherit'    => false,
		'pagination' => false,
		'queryId'    => 3,
	)
);
?>
</div>
<!-- /wp:group -->

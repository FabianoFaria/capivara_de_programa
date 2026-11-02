<?php
/**
 * Title: Últimas publicações (grade)
 * Slug: capivara/ultimos-posts
 * Categories: capivara, query
 * Description: Título de seção e os 6 posts mais recentes em cards.
 *
 * @package Capivara
 */

$capivara_posts_page = (int) get_option( 'page_for_posts' );
$capivara_all_url    = $capivara_posts_page ? get_permalink( $capivara_posts_page ) : capivara_term_url( 'tutoriais' );
?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--40)"><!-- wp:group {"align":"wide","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group alignwide"><!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Últimas publicações', 'capivara' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"fontWeight":"600"}}} -->
<p style="font-weight:600"><a href="<?php echo esc_url( $capivara_all_url ); ?>"><?php esc_html_e( 'Ver todas →', 'capivara' ); ?></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<?php
echo capivara_query_markup( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- marcação de blocos fixa.
	array(
		'perPage'    => 6,
		'inherit'    => false,
		'pagination' => false,
		'queryId'    => 1,
	)
);
?>
</div>
<!-- /wp:group -->

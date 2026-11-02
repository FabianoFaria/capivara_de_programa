<?php
/**
 * Title: Tutoriais por stack
 * Slug: capivara/stacks
 * Categories: capivara
 * Description: Grade de atalhos para as tags de cada tecnologia.
 *
 * @package Capivara
 */

$capivara_stacks = array(
	array( 'linux', 'Linux', '~$', __( 'Servidor, terminal e shell', 'capivara' ), 'primary' ),
	array( 'docker', 'Docker', '[ ]', __( 'Containers e Compose', 'capivara' ), 'primary' ),
	array( 'wordpress', 'WordPress', 'wp', __( 'Temas, plugins e deploy', 'capivara' ), 'secondary' ),
	array( 'n8n', 'n8n', '→', __( 'Automações e integrações', 'capivara' ), 'secondary' ),
	array( 'laravel', 'Laravel', '&lt;?', __( 'PHP moderno na prática', 'capivara' ), 'accent' ),
	array( 'node', 'Node', '{ }', __( 'APIs e JavaScript', 'capivara' ), 'accent' ),
);
?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:heading {"align":"wide"} -->
<h2 class="wp-block-heading alignwide"><?php esc_html_e( 'Tutoriais por stack', 'capivara' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"16px"}},"layout":{"type":"grid","minimumColumnWidth":"180px"}} -->
<div class="wp-block-group alignwide">
<?php foreach ( $capivara_stacks as $capivara_s ) : ?>
<!-- wp:group {"backgroundColor":"surface","borderColor":"border","style":{"border":{"width":"1px","radius":"14px"},"spacing":{"padding":{"top":"20px","bottom":"20px","left":"20px","right":"20px"},"blockGap":"6px"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group has-border-color has-border-border-color has-surface-background-color has-background" style="border-width:1px;border-radius:14px;padding-top:20px;padding-right:20px;padding-bottom:20px;padding-left:20px"><!-- wp:paragraph {"textColor":"<?php echo esc_attr( $capivara_s[4] ); ?>","fontFamily":"mono","style":{"typography":{"fontSize":"22px","fontWeight":"600"}}} -->
<p class="has-<?php echo esc_attr( $capivara_s[4] ); ?>-color has-text-color has-mono-font-family" style="font-size:22px;font-weight:600"><?php echo $capivara_s[2]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- texto fixo. ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"typography":{"fontWeight":"600"}}} -->
<p style="font-weight:600"><a href="<?php echo esc_url( capivara_term_url( $capivara_s[0], 'post_tag' ) ); ?>"><?php echo esc_html( $capivara_s[1] ); ?></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"textColor":"muted","fontSize":"small"} -->
<p class="has-muted-color has-text-color has-small-font-size"><?php echo esc_html( $capivara_s[3] ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group --></div>
<!-- /wp:group -->

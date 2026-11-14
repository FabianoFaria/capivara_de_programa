<?php
/**
 * Title: Lista de vagas
 * Slug: capivara/vagas-lista
 * Categories: capivara
 * Inserter: no
 * Description: Topo mostarda com filtros por modelo e stack, anúncio patrocinado e a lista de vagas (plugin Capivara Vagas).
 *
 * @package Capivara
 */
?>
<!-- wp:group {"backgroundColor":"secondary","textColor":"base","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|50"},"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained","contentSize":"1240px"}} -->
<div class="wp-block-group has-base-color has-secondary-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--50)"><!-- wp:paragraph {"fontFamily":"mono","fontSize":"small"} -->
<p class="has-mono-font-family has-small-font-size"><a href="<?php echo esc_url( capivara_vagas_url() ); ?>">~ / <?php esc_html_e( 'vagas', 'capivara' ); ?></a></p>
<!-- /wp:paragraph -->

<!-- wp:query-title {"type":"archive","showPrefix":false,"textColor":"base","fontSize":"huge"} /-->

<!-- wp:paragraph {"fontSize":"large"} -->
<p class="has-large-font-size"><?php esc_html_e( 'Vagas de desenvolvimento e infraestrutura, com stack, modelo de trabalho e salário sempre que a empresa informa.', 'capivara' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:tag-cloud {"taxonomy":"vaga_modelo","smallestFontSize":"14px","largestFontSize":"14px","className":"capivara-chips"} /-->

<!-- wp:tag-cloud {"numberOfTags":24,"taxonomy":"vaga_stack","smallestFontSize":"14px","largestFontSize":"14px","className":"capivara-chips"} /--></div>
<!-- /wp:group -->

<!-- wp:group {"className":"capivara-vagas-lista","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|70"},"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained","contentSize":"1240px"}} -->
<div class="wp-block-group capivara-vagas-lista" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:capivara/anuncio {"slot":"vagas"} /-->

<!-- wp:query {"queryId":21,"query":{"perPage":20,"pages":0,"offset":0,"postType":"vaga","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true}} -->
<div class="wp-block-query"><!-- wp:post-template -->
<!-- wp:group {"className":"capivara-vaga","backgroundColor":"surface","borderColor":"border","style":{"border":{"width":"1px","radius":"16px"},"spacing":{"padding":{"top":"24px","bottom":"24px","left":"24px","right":"24px"},"blockGap":"10px"}},"layout":{"type":"default"}} -->
<div class="wp-block-group capivara-vaga has-border-color has-border-border-color has-surface-background-color has-background" style="border-width:1px;border-radius:16px;padding-top:24px;padding-right:24px;padding-bottom:24px;padding-left:24px"><!-- wp:post-title {"isLink":true,"fontSize":"x-large"} /-->

<!-- wp:capivara/vaga-info /-->

<!-- wp:post-date {"format":"d/m/Y","textColor":"muted","fontSize":"x-small"} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"center"}} -->
<!-- wp:query-pagination-previous {"label":"<?php echo capivara_attr( __( 'Anteriores', 'capivara' ) ); ?>"} /-->

<!-- wp:query-pagination-numbers /-->

<!-- wp:query-pagination-next {"label":"<?php echo capivara_attr( __( 'Próximas', 'capivara' ) ); ?>"} /-->
<!-- /wp:query-pagination -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"fontSize":"large"} -->
<p class="has-large-font-size"><?php esc_html_e( 'Nenhuma vaga aberta por aqui agora. Volte em breve.', 'capivara' ); ?></p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query -->

<!-- wp:paragraph {"textColor":"muted","fontSize":"small"} -->
<p class="has-muted-color has-text-color has-small-font-size"><?php
printf(
	/* translators: 1: link "Anuncie uma vaga", 2: link "avise pelo contato". */
	esc_html__( 'Sua empresa está contratando? %1$s. Viu uma vaga com problema? %2$s.', 'capivara' ),
	'<a href="' . esc_url( capivara_page_url( 'anuncie' ) ) . '">' . esc_html__( 'Anuncie uma vaga', 'capivara' ) . '</a>',
	'<a href="' . esc_url( capivara_page_url( 'contato' ) ) . '">' . esc_html__( 'Avise pelo contato', 'capivara' ) . '</a>'
);
?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<?php
/**
 * Title: Página de vagas (início)
 * Slug: capivara/vagas-pagina
 * Categories: capivara
 * Post Types: page
 * Description: Conteúdo inicial da página Vagas: aviso de "em breve", vagas selecionadas e espaço patrocinado.
 *
 * @package Capivara
 */
?>
<!-- wp:paragraph {"className":"capivara-pill capivara-pill-dark","fontSize":"x-small"} -->
<p class="capivara-pill capivara-pill-dark has-x-small-font-size"><?php esc_html_e( 'Em breve: busca com filtros', 'capivara' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Vagas selecionadas', 'capivara' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color"><?php esc_html_e( 'A busca com filtros por stack, senioridade, remoto de verdade e salário informado está em construção. Enquanto isso, as vagas que valem a pena aparecem aqui.', 'capivara' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:pattern {"slug":"capivara/vaga-card"} /-->

<!-- wp:pattern {"slug":"capivara/vaga-card"} /-->

<!-- wp:capivara/anuncio {"slot":"vagas"} /-->

<!-- wp:paragraph {"textColor":"muted","fontSize":"x-small"} -->
<p class="has-muted-color has-text-color has-x-small-font-size"><?php esc_html_e( 'Dados pessoais (CV e alertas) serão tratados conforme a LGPD, com opção de exportar ou excluir tudo a qualquer momento.', 'capivara' ); ?></p>
<!-- /wp:paragraph -->

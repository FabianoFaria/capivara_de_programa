<?php
/**
 * Bloco "Dados da vaga" no site.
 *
 * @var array    $attributes Atributos (layout: card | resumo).
 * @var WP_Block $block      Instância, com o contexto postId do Loop de consulta.
 *
 * @package CapivaraVagas
 */

defined( 'ABSPATH' ) || exit;

$post_id = isset( $block->context['postId'] ) ? (int) $block->context['postId'] : get_the_ID();
if ( ! $post_id || 'vaga' !== get_post_type( $post_id ) ) {
	return;
}

$layout = ( isset( $attributes['layout'] ) && 'resumo' === $attributes['layout'] ) ? 'resumo' : 'card';
$d      = capivara_vagas_dados( $post_id );

$nivel   = $d['senioridades'] ? $d['senioridades'][0]->name : '';
$onde    = capivara_vagas_onde( $d );
$salario = $d['salario'] ? $d['salario'] : __( 'Salário não informado', 'capivara-vagas' );

$wrapper = get_block_wrapper_attributes(
	array( 'class' => 'capivara-vaga-info is-layout-' . $layout . ( $d['destaque'] ? ' is-destaque' : '' ) )
);

$stacks = '';
if ( $d['stacks'] ) {
	$links = array();
	foreach ( $d['stacks'] as $termo ) {
		$url     = get_term_link( $termo );
		$links[] = is_wp_error( $url )
			? esc_html( $termo->name )
			: '<a href="' . esc_url( $url ) . '">' . esc_html( $termo->name ) . '</a>';
	}
	$stacks = '<p class="capivara-vaga-info__stack">' . implode( ' · ', $links ) . '</p>';
}

if ( 'card' === $layout ) {
	$linha = implode( ' · ', array_filter( array( $d['empresa'], $onde, $nivel ) ) );
	$extra = implode( ' · ', array_filter( array( $salario, $d['contrato_txt'] ) ) );
	?>
<div <?php echo $wrapper; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
	<?php if ( $d['destaque'] ) : ?>
		<span class="capivara-vaga-info__selo"><?php esc_html_e( 'Destaque', 'capivara-vagas' ); ?></span>
	<?php endif; ?>
	<p class="capivara-vaga-info__linha"><?php echo esc_html( $linha ); ?></p>
	<p class="capivara-vaga-info__salario<?php echo $d['salario'] ? '' : ' is-vazio'; ?>"><?php echo esc_html( $extra ); ?></p>
	<?php echo $stacks; // phpcs:ignore WordPress.Security.EscapeOutput -- montado e escapado acima. ?>
</div>
	<?php
	return;
}

// Resumo: caixa da página da vaga, com o botão de candidatura.
$itens = array(
	__( 'Empresa', 'capivara-vagas' )    => $d['empresa_site']
		? '<a href="' . esc_url( $d['empresa_site'] ) . '" rel="nofollow noopener" target="_blank">' . esc_html( $d['empresa'] ) . '</a>'
		: esc_html( $d['empresa'] ),
	__( 'Onde', 'capivara-vagas' )       => esc_html( $onde ),
	__( 'Senioridade', 'capivara-vagas' ) => esc_html( implode( ', ', wp_list_pluck( $d['senioridades'], 'name' ) ) ),
	__( 'Contrato', 'capivara-vagas' )   => esc_html( $d['contrato_txt'] ),
	__( 'Salário', 'capivara-vagas' )    => esc_html( $salario ),
);
if ( $d['validade'] ) {
	$itens[ __( 'Aberta até', 'capivara-vagas' ) ] = esc_html( wp_date( 'd/m/Y', $d['validade']->getTimestamp() ) );
}
?>
<div <?php echo $wrapper; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
	<?php if ( $d['destaque'] ) : ?>
		<span class="capivara-vaga-info__selo"><?php esc_html_e( 'Destaque', 'capivara-vagas' ); ?></span>
	<?php endif; ?>
	<dl class="capivara-vaga-info__lista">
		<?php foreach ( $itens as $rotulo => $valor ) : ?>
			<?php if ( '' !== $valor ) : ?>
				<div><dt><?php echo esc_html( $rotulo ); ?></dt><dd><?php echo $valor; // phpcs:ignore WordPress.Security.EscapeOutput -- escapado acima. ?></dd></div>
			<?php endif; ?>
		<?php endforeach; ?>
	</dl>
	<?php echo $stacks; // phpcs:ignore WordPress.Security.EscapeOutput ?>
	<?php if ( $d['link'] ) : ?>
		<p class="capivara-vaga-info__acao">
			<a class="capivara-vaga-info__botao" href="<?php echo esc_url( $d['link'], array( 'http', 'https', 'mailto' ) ); ?>" rel="nofollow noopener" target="_blank"><?php esc_html_e( 'Candidatar-se', 'capivara-vagas' ); ?></a>
		</p>
	<?php endif; ?>
	<?php if ( $d['fonte_url'] ) : ?>
		<p class="capivara-vaga-info__fonte">
			<?php
			printf(
				/* translators: %s: link para a publicação original da vaga. */
				esc_html__( 'Vaga publicada originalmente em %s.', 'capivara-vagas' ),
				'<a href="' . esc_url( $d['fonte_url'] ) . '" rel="nofollow noopener" target="_blank">' . esc_html( $d['fonte_nome'] ? $d['fonte_nome'] : wp_parse_url( $d['fonte_url'], PHP_URL_HOST ) ) . '</a>'
			);
			?>
		</p>
	<?php endif; ?>
	<p class="capivara-vaga-info__aviso"><?php esc_html_e( 'O Capivara divulga a vaga, mas não participa da seleção. Desconfie de quem pedir pagamento para participar de um processo seletivo.', 'capivara-vagas' ); ?></p>
</div>

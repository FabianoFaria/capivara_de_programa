<?php
/**
 * Espaços de anúncio: página de configuração, bloco "Anúncio" e inserção no meio dos posts.
 *
 * O código do anúncio (AdSense ou outra rede) é colado em Aparência › Anúncios.
 * Enquanto um espaço estiver vazio, visitantes não veem nada; quem administra o site
 * vê uma moldura tracejada indicando onde o anúncio vai aparecer.
 *
 * @package Capivara
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Espaços disponíveis.
 *
 * @return array slug => rótulo
 */
function capivara_ad_slots() {
	return array(
		'horizontal' => __( 'Horizontal (entre seções, 728 × 90 / 320 × 100)', 'capivara' ),
		'lateral'    => __( 'Lateral (barra do post, 300 × 250)', 'capivara' ),
		'artigo'     => __( 'No meio do artigo', 'capivara' ),
		'vagas'      => __( 'Patrocinado na lista de vagas', 'capivara' ),
	);
}

/**
 * Opções salvas, com valores padrão.
 *
 * @return array
 */
function capivara_ad_options() {
	$defaults = array(
		'paragrafo' => 3,
	);
	foreach ( array_keys( capivara_ad_slots() ) as $slot ) {
		$defaults[ $slot ] = '';
	}
	$saved = get_option( 'capivara_anuncios', array() );
	return wp_parse_args( is_array( $saved ) ? $saved : array(), $defaults );
}

/**
 * Página em Aparência › Anúncios.
 */
function capivara_ads_menu() {
	add_theme_page(
		__( 'Anúncios', 'capivara' ),
		__( 'Anúncios', 'capivara' ),
		'edit_theme_options',
		'capivara-anuncios',
		'capivara_ads_page'
	);
}
add_action( 'admin_menu', 'capivara_ads_menu' );

/**
 * Registro da opção.
 */
function capivara_ads_register_setting() {
	register_setting(
		'capivara_anuncios',
		'capivara_anuncios',
		array(
			'type'              => 'array',
			'sanitize_callback' => 'capivara_ads_sanitize',
			'default'           => array(),
		)
	);
}
add_action( 'admin_init', 'capivara_ads_register_setting' );

/**
 * Sanitização. Código de anúncio costuma ter <script>, então só quem pode publicar
 * HTML sem filtro (administradores) consegue salvá-lo inteiro.
 *
 * @param mixed $input Valores enviados.
 * @return array
 */
function capivara_ads_sanitize( $input ) {
	$input = is_array( $input ) ? $input : array();
	$clean = array();

	foreach ( array_keys( capivara_ad_slots() ) as $slot ) {
		$code = isset( $input[ $slot ] ) ? (string) $input[ $slot ] : '';
		$code = trim( wp_unslash( $code ) );
		$clean[ $slot ] = current_user_can( 'unfiltered_html' ) ? $code : wp_kses_post( $code );
	}

	$paragrafo          = isset( $input['paragrafo'] ) ? absint( $input['paragrafo'] ) : 3;
	$clean['paragrafo'] = max( 1, min( 20, $paragrafo ) );

	return $clean;
}

/**
 * Tela de configuração.
 */
function capivara_ads_page() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	$opts = capivara_ad_options();
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Anúncios', 'capivara' ); ?></h1>
		<p><?php esc_html_e( 'Cole aqui o código de cada espaço (por exemplo, um bloco de anúncio do Google AdSense). Espaço vazio não aparece para visitantes.', 'capivara' ); ?></p>
		<?php if ( ! current_user_can( 'unfiltered_html' ) ) : ?>
			<div class="notice notice-warning"><p><?php esc_html_e( 'Seu usuário não pode salvar scripts. Peça a um administrador para colar o código dos anúncios.', 'capivara' ); ?></p></div>
		<?php endif; ?>
		<form method="post" action="options.php">
			<?php settings_fields( 'capivara_anuncios' ); ?>
			<table class="form-table" role="presentation">
				<?php foreach ( capivara_ad_slots() as $slot => $label ) : ?>
					<tr>
						<th scope="row"><label for="capivara-ad-<?php echo esc_attr( $slot ); ?>"><?php echo esc_html( $label ); ?></label></th>
						<td>
							<textarea id="capivara-ad-<?php echo esc_attr( $slot ); ?>" name="capivara_anuncios[<?php echo esc_attr( $slot ); ?>]" rows="6" class="large-text code"><?php echo esc_textarea( $opts[ $slot ] ); ?></textarea>
						</td>
					</tr>
				<?php endforeach; ?>
				<tr>
					<th scope="row"><label for="capivara-ad-paragrafo"><?php esc_html_e( 'Anúncio do artigo aparece depois do parágrafo nº', 'capivara' ); ?></label></th>
					<td><input id="capivara-ad-paragrafo" type="number" min="1" max="20" name="capivara_anuncios[paragrafo]" value="<?php echo esc_attr( $opts['paragrafo'] ); ?>" class="small-text"></td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

/**
 * HTML de um espaço de anúncio.
 *
 * @param string $slot Espaço.
 * @return string
 */
function capivara_render_ad( $slot ) {
	$slots = capivara_ad_slots();
	if ( ! isset( $slots[ $slot ] ) ) {
		$slot = 'horizontal';
	}
	$opts = capivara_ad_options();
	$code = $opts[ $slot ];

	if ( '' === $code ) {
		if ( ! current_user_can( 'edit_theme_options' ) ) {
			return '';
		}
		return sprintf(
			'<div class="capivara-ad capivara-ad--%1$s capivara-ad--empty"><span class="capivara-ad__label">%2$s</span>%3$s</div>',
			esc_attr( $slot ),
			esc_html__( 'Publicidade', 'capivara' ),
			esc_html(
				sprintf(
					/* translators: %s: nome do espaço */
					__( 'Espaço "%s" vazio. Configure em Aparência › Anúncios (só administradores veem este aviso).', 'capivara' ),
					$slots[ $slot ]
				)
			)
		);
	}

	// Código colado por um administrador em Aparência › Anúncios; sai sem escape de propósito.
	return sprintf(
		'<aside class="capivara-ad capivara-ad--%1$s" aria-label="%2$s"><span class="capivara-ad__label">%3$s</span>%4$s</aside>',
		esc_attr( $slot ),
		esc_attr__( 'Publicidade', 'capivara' ),
		'vagas' === $slot ? esc_html__( 'Patrocinado', 'capivara' ) : esc_html__( 'Publicidade', 'capivara' ),
		$code
	);
}

/**
 * Bloco "Anúncio" (capivara/anuncio), para colocar um espaço em qualquer template ou post.
 */
function capivara_register_ad_block() {
	register_block_type(
		get_template_directory() . '/blocks/anuncio',
		array(
			'render_callback' => function ( $attributes ) {
				$slot = isset( $attributes['slot'] ) ? sanitize_key( $attributes['slot'] ) : 'horizontal';
				return capivara_render_ad( $slot );
			},
		)
	);
}
add_action( 'init', 'capivara_register_ad_block' );

/**
 * Insere o anúncio "artigo" depois do parágrafo N dos posts.
 *
 * @param string $content Conteúdo.
 * @return string
 */
function capivara_ad_in_content( $content ) {
	if ( is_feed() || ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}

	$ad = capivara_render_ad( 'artigo' );
	if ( '' === $ad ) {
		return $content;
	}

	$opts  = capivara_ad_options();
	$after = (int) $opts['paragrafo'];
	$parts = explode( '</p>', $content );

	// Só insere se o texto tiver parágrafos suficientes depois do ponto escolhido.
	if ( count( $parts ) <= $after + 1 ) {
		return $content;
	}

	$out = '';
	foreach ( $parts as $i => $part ) {
		$out .= $part;
		if ( $i < count( $parts ) - 1 ) {
			$out .= '</p>';
		}
		if ( $i + 1 === $after ) {
			$out .= $ad;
		}
	}
	return $out;
}
add_filter( 'the_content', 'capivara_ad_in_content', 20 );

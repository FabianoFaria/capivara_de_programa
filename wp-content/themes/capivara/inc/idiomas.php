<?php
/**
 * Preparação para mais de um idioma.
 *
 * O tema não depende de nenhum plugin. Quando o Polylang estiver ativo:
 * - o bloco "Seletor de idioma" (capivara/idiomas) mostra PT · EN no cabeçalho;
 * - os links de categorias, tags e páginas do tema seguem o idioma atual (inc/helpers.php);
 * - os textos fixos do tema vêm de languages/<locale>.mo (en_US.mo já incluído).
 *
 * Sem plugin, o bloco não imprime nada, as traduções não são carregadas e o site fica igual,
 * em português, qualquer que seja o idioma configurado no WordPress.
 *
 * @package Capivara
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * O português é o idioma nativo do tema (os textos do código já estão em PT).
 * As traduções do tema (en_US.mo etc.) só entram com um plugin de idiomas ativo.
 * Assim, se o idioma do WordPress estiver em inglês (o padrão de uma instalação nova),
 * o site continua em português até o Polylang ser configurado.
 *
 * @param bool   $override Se true, o WordPress pula o carregamento.
 * @param string $domain   Domínio de texto.
 * @return bool
 */
function capivara_only_translate_with_language_plugin( $override, $domain ) {
	if ( 'capivara' === $domain && ! function_exists( 'pll_current_language' ) ) {
		return true;
	}
	return $override;
}
add_filter( 'override_load_textdomain', 'capivara_only_translate_with_language_plugin', 10, 2 );

/**
 * Mesma regra para as traduções em JSON dos scripts do editor.
 *
 * @param string|false $file   Arquivo de tradução.
 * @param string       $handle Script.
 * @param string       $domain Domínio de texto.
 * @return string|false
 */
function capivara_only_translate_scripts_with_language_plugin( $file, $handle, $domain ) {
	if ( 'capivara' === $domain && ! function_exists( 'pll_current_language' ) ) {
		return false;
	}
	return $file;
}
add_filter( 'load_script_translation_file', 'capivara_only_translate_scripts_with_language_plugin', 10, 3 );

/**
 * HTML do seletor. Vazio sem Polylang ou com um idioma só.
 *
 * @return string
 */
function capivara_render_language_switcher() {
	if ( ! function_exists( 'pll_the_languages' ) ) {
		return '';
	}

	$langs = pll_the_languages(
		array(
			'echo'                   => 0,
			'raw'                    => 1,
			'hide_if_empty'          => 0,
			'hide_if_no_translation' => 0,
		)
	);
	if ( ! is_array( $langs ) || count( $langs ) < 2 ) {
		return '';
	}

	$links = array();
	foreach ( $langs as $lang ) {
		if ( empty( $lang['url'] ) || empty( $lang['slug'] ) ) {
			continue;
		}
		$current = ! empty( $lang['current_lang'] );
		$links[] = sprintf(
			'<a class="capivara-idiomas__link%1$s" href="%2$s" hreflang="%3$s" lang="%3$s"%4$s title="%5$s">%6$s</a>',
			$current ? ' is-current' : '',
			esc_url( $lang['url'] ),
			esc_attr( ! empty( $lang['locale'] ) ? str_replace( '_', '-', $lang['locale'] ) : $lang['slug'] ),
			$current ? ' aria-current="true"' : '',
			esc_attr( isset( $lang['name'] ) ? $lang['name'] : $lang['slug'] ),
			esc_html( strtoupper( $lang['slug'] ) )
		);
	}
	if ( count( $links ) < 2 ) {
		return '';
	}

	return sprintf(
		'<nav class="capivara-idiomas" aria-label="%1$s">%2$s</nav>',
		esc_attr__( 'Idioma', 'capivara' ),
		implode( '', $links )
	);
}

/**
 * Registro do bloco (renderizado no servidor, então continua funcionando
 * mesmo depois de o cabeçalho ser editado e salvo no Editor do site).
 */
function capivara_register_language_block() {
	register_block_type(
		get_template_directory() . '/blocks/idiomas',
		array(
			'render_callback' => 'capivara_render_language_switcher',
		)
	);
}
add_action( 'init', 'capivara_register_language_block' );

/**
 * Traduções dos scripts dos blocos no editor (arquivos JSON em languages/).
 */
function capivara_block_script_translations() {
	foreach ( array( 'capivara-anuncio-editor-script', 'capivara-idiomas-editor-script', 'capivara-compartilhar-editor-script' ) as $handle ) {
		if ( wp_script_is( $handle, 'registered' ) ) {
			wp_set_script_translations( $handle, 'capivara', get_template_directory() . '/languages' );
		}
	}
}
add_action( 'enqueue_block_editor_assets', 'capivara_block_script_translations' );

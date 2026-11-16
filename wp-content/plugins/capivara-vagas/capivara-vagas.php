<?php
/**
 * Plugin Name:       Capivara Vagas
 * Plugin URI:        https://capivaradeprograma.com.br/vagas/
 * Description:       Vagas de tecnologia para o Capivara de Programa: tipo de post "Vaga", campos (ACF), expiração automática, schema JobPosting para o Google e permissões para o robô do n8n publicar só vagas.
 * Version:           1.1.0
 * Requires at least: 6.6
 * Requires PHP:      7.4
 * Author:            Capivara de Programa
 * License:           GPL-2.0-or-later
 * Text Domain:       capivara-vagas
 *
 * @package CapivaraVagas
 */

defined( 'ABSPATH' ) || exit;

define( 'CAPIVARA_VAGAS_VERSION', '1.1.0' );
define( 'CAPIVARA_VAGAS_DIR', plugin_dir_path( __FILE__ ) );
define( 'CAPIVARA_VAGAS_URL', plugin_dir_url( __FILE__ ) );

require_once CAPIVARA_VAGAS_DIR . 'inc/tipos.php';
require_once CAPIVARA_VAGAS_DIR . 'inc/papeis.php';
require_once CAPIVARA_VAGAS_DIR . 'inc/campos.php';
require_once CAPIVARA_VAGAS_DIR . 'inc/dados.php';
require_once CAPIVARA_VAGAS_DIR . 'inc/expiracao.php';
require_once CAPIVARA_VAGAS_DIR . 'inc/schema.php';
require_once CAPIVARA_VAGAS_DIR . 'inc/admin.php';
require_once CAPIVARA_VAGAS_DIR . 'inc/rest.php';

/**
 * Bloco "Dados da vaga" (dinâmico, renderizado em PHP).
 */
function capivara_vagas_registrar_bloco() {
	register_block_type( CAPIVARA_VAGAS_DIR . 'blocks/vaga-info' );
}
add_action( 'init', 'capivara_vagas_registrar_bloco' );

/**
 * Ativação: tipos, papel do robô, permissões, termos padrão, agendamento e links.
 */
function capivara_vagas_ativar() {
	capivara_vagas_registrar_tipos();
	capivara_vagas_instalar();
	capivara_vagas_agendar_expiracao();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'capivara_vagas_ativar' );

/**
 * Desativação: remove o agendamento e os links. Vagas, papel e permissões ficam.
 */
function capivara_vagas_desativar() {
	wp_clear_scheduled_hook( 'capivara_vagas_expirar' );
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'capivara_vagas_desativar' );

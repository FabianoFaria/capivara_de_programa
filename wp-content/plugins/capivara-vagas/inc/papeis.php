<?php
/**
 * Permissões das vagas e o papel "Robô do Capivara".
 *
 * O robô (usuário do n8n) continua com as permissões de Colaborador para posts
 * (só rascunhos) e ganha permissão para publicar VAGAS, que têm prazo curto.
 *
 * @package CapivaraVagas
 */

defined( 'ABSPATH' ) || exit;

/** Permissões completas das vagas (administrador e editor). */
function capivara_vagas_caps_completas() {
	return array(
		'edit_vagas',
		'edit_others_vagas',
		'edit_private_vagas',
		'edit_published_vagas',
		'publish_vagas',
		'read_private_vagas',
		'delete_vagas',
		'delete_others_vagas',
		'delete_private_vagas',
		'delete_published_vagas',
		'manage_vaga_terms',
	);
}

/** Permissões do robô: cria, publica e atualiza as próprias vagas; não apaga nada. */
function capivara_vagas_caps_robo() {
	return array(
		'read'                 => true,
		'edit_posts'           => true, // Colaborador: rascunhos de posts.
		'delete_posts'         => true, // Colaborador: apaga os próprios rascunhos.
		'edit_vagas'           => true,
		'edit_published_vagas' => true,
		'publish_vagas'        => true,
		'manage_vaga_terms'    => true, // Cria stacks novas.
	);
}

/**
 * Instala (ou atualiza) papel, permissões e termos. Roda na ativação e
 * quando a versão do plugin muda.
 */
function capivara_vagas_instalar() {
	foreach ( array( 'administrator', 'editor' ) as $nome ) {
		$papel = get_role( $nome );
		if ( $papel ) {
			foreach ( capivara_vagas_caps_completas() as $cap ) {
				$papel->add_cap( $cap );
			}
		}
	}

	remove_role( 'capivara_robo' );
	add_role( 'capivara_robo', __( 'Robô do Capivara', 'capivara-vagas' ), capivara_vagas_caps_robo() );

	capivara_vagas_termos_padrao();

	// Ordem de destaque das vagas que já existem.
	foreach ( get_posts( array( 'post_type' => 'vaga', 'post_status' => 'any', 'fields' => 'ids', 'posts_per_page' => -1 ) ) as $id ) {
		capivara_vagas_sincronizar_destaque( $id );
	}
	update_option( 'capivara_vagas_versao', CAPIVARA_VAGAS_VERSION );
}

function capivara_vagas_atualizar_se_preciso() {
	if ( get_option( 'capivara_vagas_versao' ) !== CAPIVARA_VAGAS_VERSION ) {
		capivara_vagas_instalar();
		flush_rewrite_rules();
	}
}
add_action( 'admin_init', 'capivara_vagas_atualizar_se_preciso' );

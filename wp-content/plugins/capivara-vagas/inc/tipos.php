<?php
/**
 * Tipo de post "vaga" e as taxonomias stack, modelo e senioridade.
 *
 * As taxonomias são registradas antes do tipo de post, para que os endereços
 * /vagas/stack/php/ tenham prioridade sobre /vagas/{vaga}/.
 *
 * @package CapivaraVagas
 */

defined( 'ABSPATH' ) || exit;

/**
 * Permissões das taxonomias: o robô cria termos novos (ex.: uma stack nova),
 * mas só administradores e editores apagam.
 */
function capivara_vagas_caps_taxonomia() {
	return array(
		'manage_terms' => 'manage_vaga_terms',
		'edit_terms'   => 'manage_vaga_terms',
		'delete_terms' => 'manage_categories',
		'assign_terms' => 'edit_vagas',
	);
}

function capivara_vagas_registrar_tipos() {
	$comum = array(
		'public'            => true,
		'show_ui'           => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'capabilities'      => capivara_vagas_caps_taxonomia(),
	);

	register_taxonomy(
		'vaga_stack',
		'vaga',
		$comum + array(
			'labels'       => array(
				'name'          => __( 'Stacks', 'capivara-vagas' ),
				'singular_name' => __( 'Stack', 'capivara-vagas' ),
				'add_new_item'  => __( 'Adicionar stack', 'capivara-vagas' ),
				'search_items'  => __( 'Buscar stacks', 'capivara-vagas' ),
			),
			'hierarchical' => false,
			'rewrite'      => array( 'slug' => 'vagas/stack', 'with_front' => false ),
		)
	);

	register_taxonomy(
		'vaga_modelo',
		'vaga',
		$comum + array(
			'labels'       => array(
				'name'          => __( 'Modelos de trabalho', 'capivara-vagas' ),
				'singular_name' => __( 'Modelo de trabalho', 'capivara-vagas' ),
			),
			'hierarchical' => true,
			'rewrite'      => array( 'slug' => 'vagas/modelo', 'with_front' => false ),
		)
	);

	register_taxonomy(
		'vaga_senioridade',
		'vaga',
		$comum + array(
			'labels'       => array(
				'name'          => __( 'Senioridades', 'capivara-vagas' ),
				'singular_name' => __( 'Senioridade', 'capivara-vagas' ),
			),
			'hierarchical' => true,
			'rewrite'      => array( 'slug' => 'vagas/nivel', 'with_front' => false ),
		)
	);

	register_post_type(
		'vaga',
		array(
			'labels'          => array(
				'name'               => __( 'Vagas', 'capivara-vagas' ),
				'singular_name'      => __( 'Vaga', 'capivara-vagas' ),
				'add_new'            => __( 'Adicionar vaga', 'capivara-vagas' ),
				'add_new_item'       => __( 'Adicionar vaga', 'capivara-vagas' ),
				'edit_item'          => __( 'Editar vaga', 'capivara-vagas' ),
				'view_item'          => __( 'Ver vaga', 'capivara-vagas' ),
				'search_items'       => __( 'Buscar vagas', 'capivara-vagas' ),
				'not_found'          => __( 'Nenhuma vaga encontrada.', 'capivara-vagas' ),
				'not_found_in_trash' => __( 'Nenhuma vaga na lixeira.', 'capivara-vagas' ),
				'all_items'          => __( 'Todas as vagas', 'capivara-vagas' ),
				'menu_name'          => __( 'Vagas', 'capivara-vagas' ),
			),
			'description'     => __( 'Vagas de desenvolvimento e infraestrutura.', 'capivara-vagas' ),
			'public'          => true,
			'show_in_rest'    => true,
			'rest_base'       => 'vagas',
			'menu_icon'       => 'dashicons-businessperson',
			'menu_position'   => 6,
			'has_archive'     => 'vagas',
			'rewrite'         => array( 'slug' => 'vagas', 'with_front' => false ),
			'supports'        => array( 'title', 'editor', 'excerpt', 'author', 'revisions', 'custom-fields' ),
			'taxonomies'      => array( 'vaga_stack', 'vaga_modelo', 'vaga_senioridade' ),
			'capability_type' => array( 'vaga', 'vagas' ),
			'map_meta_cap'    => true,
			'template'        => array(
				array(
					'core/paragraph',
					array( 'placeholder' => __( 'Descreva a vaga: o que a pessoa vai fazer, requisitos, diferenciais e benefícios.', 'capivara-vagas' ) ),
				),
			),
		)
	);
}
add_action( 'init', 'capivara_vagas_registrar_tipos', 5 );

/**
 * Termos iniciais de modelo e senioridade (só cria os que faltam).
 */
function capivara_vagas_termos_padrao() {
	$termos = array(
		'vaga_modelo'      => array(
			'remoto'     => __( 'Remoto', 'capivara-vagas' ),
			'hibrido'    => __( 'Híbrido', 'capivara-vagas' ),
			'presencial' => __( 'Presencial', 'capivara-vagas' ),
		),
		'vaga_senioridade' => array(
			'estagio'      => __( 'Estágio', 'capivara-vagas' ),
			'junior'       => __( 'Júnior', 'capivara-vagas' ),
			'pleno'        => __( 'Pleno', 'capivara-vagas' ),
			'senior'       => __( 'Sênior', 'capivara-vagas' ),
			'especialista' => __( 'Especialista', 'capivara-vagas' ),
		),
	);
	foreach ( $termos as $taxonomia => $lista ) {
		foreach ( $lista as $slug => $nome ) {
			if ( ! term_exists( $slug, $taxonomia ) ) {
				wp_insert_term( $nome, $taxonomia, array( 'slug' => $slug ) );
			}
		}
	}
}

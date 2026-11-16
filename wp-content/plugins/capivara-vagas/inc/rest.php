<?php
/**
 * Campo "termos" na API REST das vagas.
 *
 * Permite ao n8n mandar modelo, senioridade e stacks pelo nome ou slug, sem
 * precisar buscar IDs antes. Stacks que ainda não existem são criadas (se o
 * usuário puder criar termos de vaga). Modelos e senioridades só aceitam os
 * termos que já existem.
 *
 * Exemplo: "termos": { "modelo": ["remoto"], "senioridade": ["pleno"], "stack": ["PHP", "Laravel"] }
 *
 * @package CapivaraVagas
 */

defined( 'ABSPATH' ) || exit;

function capivara_vagas_registrar_campo_termos() {
	$lista = array(
		'type'  => 'array',
		'items' => array( 'type' => 'string' ),
	);
	register_rest_field(
		'vaga',
		'termos',
		array(
			'get_callback'    => 'capivara_vagas_termos_rest_ler',
			'update_callback' => 'capivara_vagas_termos_rest_gravar',
			'schema'          => array(
				'description' => __( 'Modelo, senioridade e stacks pelo nome ou slug.', 'capivara-vagas' ),
				'type'        => 'object',
				'context'     => array( 'view', 'edit' ),
				'properties'  => array(
					'modelo'      => $lista,
					'senioridade' => $lista,
					'stack'       => $lista,
				),
			),
		)
	);
}
add_action( 'rest_api_init', 'capivara_vagas_registrar_campo_termos' );

/** Mapa campo da API => taxonomia. */
function capivara_vagas_mapa_termos() {
	return array(
		'modelo'      => 'vaga_modelo',
		'senioridade' => 'vaga_senioridade',
		'stack'       => 'vaga_stack',
	);
}

function capivara_vagas_termos_rest_ler( $objeto ) {
	$saida = array();
	foreach ( capivara_vagas_mapa_termos() as $campo => $taxonomia ) {
		$saida[ $campo ] = wp_list_pluck( capivara_vagas_termos( $objeto['id'], $taxonomia ), 'slug' );
	}
	return $saida;
}

/**
 * @param array   $valor Valor enviado.
 * @param WP_Post $post  Vaga já gravada.
 * @return true|WP_Error
 */
function capivara_vagas_termos_rest_gravar( $valor, $post ) {
	if ( ! is_array( $valor ) ) {
		return true;
	}
	if ( ! current_user_can( 'edit_post', $post->ID ) ) {
		return new WP_Error( 'capivara_sem_permissao', __( 'Sem permissão para alterar esta vaga.', 'capivara-vagas' ), array( 'status' => 403 ) );
	}

	foreach ( capivara_vagas_mapa_termos() as $campo => $taxonomia ) {
		if ( ! isset( $valor[ $campo ] ) || ! is_array( $valor[ $campo ] ) ) {
			continue;
		}
		$ids = array();
		foreach ( array_slice( $valor[ $campo ], 0, 12 ) as $nome ) {
			$nome = trim( wp_strip_all_tags( (string) $nome ) );
			if ( '' === $nome || mb_strlen( $nome ) > 40 ) {
				continue;
			}
			$termo = get_term_by( 'slug', sanitize_title( $nome ), $taxonomia );
			if ( ! $termo ) {
				$termo = get_term_by( 'name', $nome, $taxonomia );
			}
			if ( $termo ) {
				$ids[] = (int) $termo->term_id;
				continue;
			}
			// Só stacks podem nascer pela API; modelos e senioridades são fixos.
			if ( 'vaga_stack' === $taxonomia && current_user_can( 'manage_vaga_terms' ) ) {
				$novo = wp_insert_term( $nome, $taxonomia );
				if ( ! is_wp_error( $novo ) ) {
					$ids[] = (int) $novo['term_id'];
				}
			}
		}
		wp_set_object_terms( $post->ID, array_unique( $ids ), $taxonomia );
	}
	return true;
}

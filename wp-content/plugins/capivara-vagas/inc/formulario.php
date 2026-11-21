<?php
/**
 * Formulário "Divulgar vaga" (Contact Form 7): validação extra e envio ao n8n.
 *
 * O formulário é reconhecido pelo campo oculto [hidden capivara-form "vaga"]. Depois de validado,
 * os dados vão para o webhook do n8n, que grava a vaga em `capivara_vagas` como "nova".
 * Ela entra na próxima triagem e só vai ao ar depois do ✅ no Telegram.
 *
 * Configuração (no wp-config.php, pelo WORDPRESS_CONFIG_EXTRA do compose):
 *   CAPIVARA_VAGAS_WEBHOOK_URL    endereço do webhook do n8n
 *   CAPIVARA_VAGAS_WEBHOOK_TOKEN  valor do cabeçalho X-Capivara-Token
 *
 * @package CapivaraVagas
 */

defined( 'ABSPATH' ) || exit;

/**
 * Lê uma configuração: constante do wp-config.php ou variável de ambiente com o mesmo nome.
 */
function capivara_vagas_config( $nome ) {
	if ( defined( $nome ) ) {
		return (string) constant( $nome );
	}
	$valor = getenv( $nome );
	return false === $valor ? '' : (string) $valor;
}

/**
 * O envio atual é do formulário de vagas?
 */
function capivara_vagas_eh_formulario( $submission ) {
	return $submission && 'vaga' === trim( (string) $submission->get_posted_data( 'capivara-form' ) );
}

/**
 * Valores aceitos nas listas do formulário (o texto que a pessoa vê → o código usado no site).
 */
function capivara_vagas_form_opcoes() {
	return array(
		'senioridade' => array(
			'Estágio'      => 'estagio',
			'Júnior'       => 'junior',
			'Pleno'        => 'pleno',
			'Sênior'       => 'senior',
			'Especialista' => 'especialista',
		),
		'modelo'      => array(
			'Remoto'     => 'remoto',
			'Híbrido'    => 'hibrido',
			'Presencial' => 'presencial',
		),
		'contrato'    => array(
			'CLT'        => 'clt',
			'PJ'         => 'pj',
			'Estágio'    => 'estagio',
			'Freelance'  => 'freelance',
			'Temporário' => 'temporario',
			'Outro'      => 'outro',
		),
		'moeda'       => array(
			'Real (R$)'    => 'BRL',
			'Dólar (US$)'  => 'USD',
			'Euro (€)'     => 'EUR',
		),
		'periodo'     => array(
			'Por mês'  => 'MONTH',
			'Por ano'  => 'YEAR',
			'Por hora' => 'HOUR',
		),
	);
}

/**
 * Converte o texto escolhido no código; aceita também o próprio código.
 */
function capivara_vagas_form_codigo( $lista, $valor ) {
	$opcoes = capivara_vagas_form_opcoes()[ $lista ];
	$valor  = trim( (string) ( is_array( $valor ) ? reset( $valor ) : $valor ) );
	if ( isset( $opcoes[ $valor ] ) ) {
		return $opcoes[ $valor ];
	}
	return in_array( $valor, $opcoes, true ) ? $valor : '';
}

/**
 * Número digitado em formato brasileiro ("8.500", "8500,00") ou simples.
 */
function capivara_vagas_form_numero( $valor ) {
	$valor = preg_replace( '/[^\d,.]/', '', (string) $valor );
	if ( preg_match( '/,\d{1,2}$/', $valor ) ) {
		$valor = str_replace( ',', '.', str_replace( '.', '', $valor ) );
	} elseif ( preg_match( '/^\d{1,3}(\.\d{3})+$/', $valor ) ) {
		$valor = str_replace( '.', '', $valor );
	}
	return is_numeric( $valor ) ? (float) $valor : 0.0;
}

/**
 * IP de quem enviou (atrás do nginx-proxy, o primeiro do X-Forwarded-For).
 */
function capivara_vagas_form_ip() {
	$ip = '';
	if ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		$ip = trim( explode( ',', sanitize_text_field( wp_unslash( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) )[0] );
	}
	if ( ! filter_var( $ip, FILTER_VALIDATE_IP ) && ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
		$ip = sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) );
	}
	return $ip;
}

/**
 * Validação que o Contact Form 7 não faz sozinho: faixa salarial, cidade para vaga
 * híbrida ou presencial, link ou e-mail de candidatura e limite de envios por IP.
 *
 * @param WPCF7_Validation $result Resultado da validação.
 * @param WPCF7_FormTag[]  $tags   Campos do formulário.
 */
function capivara_vagas_form_validar( $result, $tags ) {
	$submission = WPCF7_Submission::get_instance();
	if ( ! capivara_vagas_eh_formulario( $submission ) ) {
		return $result;
	}
	$por_nome = array();
	foreach ( $tags as $tag ) {
		if ( ! empty( $tag->name ) ) {
			$por_nome[ $tag->name ] = $tag;
		}
	}
	$erro = function ( $campo, $mensagem ) use ( $result, $por_nome ) {
		if ( isset( $por_nome[ $campo ] ) && $result->is_valid( $campo ) ) {
			$result->invalidate( $por_nome[ $campo ], $mensagem );
		}
	};
	$dado = function ( $campo ) use ( $submission ) {
		return $submission->get_posted_data( $campo );
	};

	$min = capivara_vagas_form_numero( $dado( 'salario-min' ) );
	$max = capivara_vagas_form_numero( $dado( 'salario-max' ) );
	if ( $min <= 0 ) {
		$erro( 'salario-min', __( 'Informe o salário mínimo da faixa.', 'capivara-vagas' ) );
	}
	if ( $max <= 0 ) {
		$erro( 'salario-max', __( 'Informe o salário máximo da faixa.', 'capivara-vagas' ) );
	} elseif ( $min > 0 && $max < $min ) {
		$erro( 'salario-max', __( 'O máximo precisa ser maior ou igual ao mínimo.', 'capivara-vagas' ) );
	}

	$modelos = array_filter( array_map(
		function ( $m ) {
			return capivara_vagas_form_codigo( 'modelo', $m );
		},
		(array) $dado( 'modelo' )
	) );
	if ( ! $modelos ) {
		$erro( 'modelo', __( 'Escolha pelo menos um modelo de trabalho.', 'capivara-vagas' ) );
	} elseif ( array_diff( $modelos, array( 'remoto' ) ) && '' === trim( (string) $dado( 'cidade' ) ) ) {
		$erro( 'cidade', __( 'Para vaga híbrida ou presencial, informe a cidade e o estado.', 'capivara-vagas' ) );
	}

	$link = trim( (string) $dado( 'candidatura' ) );
	if ( '' !== $link && true !== capivara_vagas_validar_link( true, $link ) ) {
		$erro( 'candidatura', __( 'Use um link começando com https:// ou um e-mail.', 'capivara-vagas' ) );
	}

	$validade = trim( (string) $dado( 'validade' ) );
	if ( '' !== $validade && $validade < wp_date( 'Y-m-d' ) ) {
		$erro( 'validade', __( 'A data precisa ser hoje ou depois.', 'capivara-vagas' ) );
	}

	// Limite por IP: além do Turnstile, no máximo 5 vagas por hora do mesmo endereço.
	$limite = (int) apply_filters( 'capivara_vagas_form_limite_hora', 5 );
	$chave  = 'capivara_vagas_form_' . md5( capivara_vagas_form_ip() );
	if ( $result->is_valid() && $limite > 0 && (int) get_transient( $chave ) >= $limite ) {
		$erro( 'empresa', __( 'Muitos envios seguidos. Tente de novo daqui a uma hora.', 'capivara-vagas' ) );
	}
	return $result;
}
add_filter( 'wpcf7_validate', 'capivara_vagas_form_validar', 20, 2 );

/**
 * Monta os dados que vão para o n8n.
 */
function capivara_vagas_form_dados( $submission ) {
	$dado = function ( $campo, $max = 200 ) use ( $submission ) {
		$v = $submission->get_posted_data( $campo );
		$v = is_array( $v ) ? implode( ', ', $v ) : (string) $v;
		return mb_substr( trim( $v ), 0, $max );
	};
	$modelos = array_values( array_unique( array_filter( array_map(
		function ( $m ) {
			return capivara_vagas_form_codigo( 'modelo', $m );
		},
		(array) $submission->get_posted_data( 'modelo' )
	) ) ) );
	$stack   = array_slice( array_values( array_filter( array_map( 'trim', explode( ',', $dado( 'stack', 300 ) ) ) ) ), 0, 8 );
	$site    = $dado( 'empresa-site', 300 );

	return array(
		'id'               => 'form:' . wp_generate_uuid4(),
		'enviada_em'       => gmdate( 'c' ),
		'empresa'          => $dado( 'empresa', 120 ),
		'empresa_site'     => preg_match( '#^https?://#i', $site ) ? $site : '',
		'contato_nome'     => $dado( 'contato-nome', 120 ),
		'contato_email'    => sanitize_email( $dado( 'contato-email', 200 ) ),
		'titulo'           => $dado( 'titulo', 120 ),
		'senioridade'      => capivara_vagas_form_codigo( 'senioridade', $submission->get_posted_data( 'senioridade' ) ),
		'modelo'           => $modelos,
		'localizacao'      => $dado( 'cidade', 80 ),
		'paises'           => in_array( 'remoto', $modelos, true ) ? 'BR' : '',
		'contrato'         => capivara_vagas_form_codigo( 'contrato', $submission->get_posted_data( 'contrato' ) ) ?: 'outro',
		'salario_min'      => capivara_vagas_form_numero( $submission->get_posted_data( 'salario-min' ) ),
		'salario_max'      => capivara_vagas_form_numero( $submission->get_posted_data( 'salario-max' ) ),
		'moeda'            => capivara_vagas_form_codigo( 'moeda', $submission->get_posted_data( 'moeda' ) ) ?: 'BRL',
		'periodo'          => capivara_vagas_form_codigo( 'periodo', $submission->get_posted_data( 'periodo' ) ) ?: 'MONTH',
		'stack'            => $stack,
		'link_candidatura' => $dado( 'candidatura', 300 ),
		'validade'         => preg_match( '/^\d{4}-\d{2}-\d{2}$/', $dado( 'validade', 10 ) ) ? $dado( 'validade', 10 ) : '',
		'descricao'        => $dado( 'descricao', 6000 ),
		'url_pagina'       => esc_url_raw( (string) $submission->get_meta( 'url' ) ),
	);
}

/**
 * Depois de validado (e antes do e-mail do CF7), envia a vaga ao n8n.
 * Se o n8n não responder, o envio não é bloqueado: o e-mail do CF7 leva todos os dados
 * e o erro fica no log do PHP.
 *
 * @param WPCF7_ContactForm $contact_form Formulário.
 * @param bool              $abort        Passado por referência pelo CF7 (não usado).
 * @param WPCF7_Submission  $submission   Envio.
 */
function capivara_vagas_form_enviar( $contact_form, &$abort, $submission ) {
	if ( ! capivara_vagas_eh_formulario( $submission ) ) {
		return;
	}
	$chave = 'capivara_vagas_form_' . md5( capivara_vagas_form_ip() );
	set_transient( $chave, (int) get_transient( $chave ) + 1, HOUR_IN_SECONDS );

	$url   = capivara_vagas_config( 'CAPIVARA_VAGAS_WEBHOOK_URL' );
	$token = capivara_vagas_config( 'CAPIVARA_VAGAS_WEBHOOK_TOKEN' );
	if ( '' === $url || '' === $token ) {
		error_log( 'Capivara Vagas: CAPIVARA_VAGAS_WEBHOOK_URL ou CAPIVARA_VAGAS_WEBHOOK_TOKEN não configurado; a vaga do formulário ficou só no e-mail.' ); // phpcs:ignore
		return;
	}
	$dados    = capivara_vagas_form_dados( $submission );
	$resposta = wp_remote_post(
		$url,
		array(
			'timeout' => 15,
			'headers' => array(
				'Content-Type'     => 'application/json',
				'X-Capivara-Token' => $token,
			),
			'body'    => wp_json_encode( $dados ),
		)
	);
	$codigo = wp_remote_retrieve_response_code( $resposta );
	if ( is_wp_error( $resposta ) || $codigo < 200 || $codigo >= 300 ) {
		$motivo = is_wp_error( $resposta ) ? $resposta->get_error_message() : $codigo . ' ' . wp_remote_retrieve_body( $resposta );
		error_log( 'Capivara Vagas: o n8n não recebeu a vaga do formulário (' . mb_substr( $motivo, 0, 300 ) . '); ela ficou só no e-mail.' ); // phpcs:ignore
	}
}
add_action( 'wpcf7_before_send_mail', 'capivara_vagas_form_enviar', 10, 3 );

/**
 * Estilo do formulário, só nas páginas que carregam o Contact Form 7.
 */
function capivara_vagas_form_estilo() {
	if ( wp_style_is( 'contact-form-7', 'registered' ) ) {
		wp_enqueue_style( 'capivara-vagas-formulario', CAPIVARA_VAGAS_URL . 'assets/formulario.css', array( 'contact-form-7' ), CAPIVARA_VAGAS_VERSION );
	}
}
add_action( 'wpcf7_enqueue_styles', 'capivara_vagas_form_estilo' );

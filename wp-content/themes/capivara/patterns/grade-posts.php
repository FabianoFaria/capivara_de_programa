<?php
/**
 * Title: Grade de posts (arquivo)
 * Slug: capivara/grade-posts
 * Categories: capivara, query
 * Inserter: no
 * Description: Query Loop que segue a página atual (blog, categoria, tag, busca).
 *
 * @package Capivara
 */

echo capivara_query_markup( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- marcação de blocos fixa.
	array(
		'perPage'    => 9,
		'inherit'    => true,
		'pagination' => true,
		'queryId'    => 2,
	)
);

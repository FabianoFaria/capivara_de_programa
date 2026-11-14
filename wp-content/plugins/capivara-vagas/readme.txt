=== Capivara Vagas ===
Requires at least: 6.6
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later

Vagas de tecnologia para o Capivara de Programa.

== O que faz ==

* Tipo de post "Vaga" em /vagas/, com as taxonomias Stack (/vagas/stack/php/),
  Modelo de trabalho (/vagas/modelo/remoto/) e Senioridade (/vagas/nivel/pleno/).
* Campos da vaga pelo ACF, definidos em código (inc/campos.php): empresa, site, como se
  candidatar, contrato, cidade/UF, países aceitos, salário (mín., máx., moeda, período),
  validade, destaque e fonte. Os valores ficam em post meta comum: sem o ACF, o site
  continua exibindo as vagas, só a edição fica sem formulário.
* Validade: vazia = 30 dias. Vaga vencida volta para rascunho sozinha (de hora em hora)
  e fica marcada como "Expirada" na lista do painel.
* Schema JobPosting (Google for Jobs) na página de cada vaga. Vaga remota precisa de
  pelo menos um país em "Países aceitos" (exigência do Google).
* Bloco "Dados da vaga" (layouts card e resumo), usado pelo tema.
* Papel "Robô do Capivara": permissões de Colaborador para posts e permissão para
  criar, publicar e atualizar vagas e criar stacks. Não apaga nada.
* Vagas em destaque aparecem primeiro na lista.
* Limpa o cache do W3 Total Cache quando uma vaga entra ou sai do ar.

== API REST (para o n8n) ==

Criar e publicar: POST /wp-json/wp/v2/vagas (usuário com o papel Robô do Capivara e
senha de aplicativo).

{
  "title": "Desenvolvedor(a) Laravel Pleno",
  "status": "publish",
  "content": "<p>Descrição...</p>",
  "vaga_modelo": [ID],          // termos: GET /wp-json/wp/v2/vaga_modelo
  "vaga_senioridade": [ID],     // GET /wp-json/wp/v2/vaga_senioridade
  "vaga_stack": [ID, ID],       // GET/POST /wp-json/wp/v2/vaga_stack
  "acf": {
    "empresa": "Acme", "empresa_site": "https://...", "link_candidatura": "https://... ou e-mail",
    "contrato": "clt|pj|estagio|freelance|temporario|outro", "localizacao": "São Paulo/SP",
    "paises": "BR", "salario_min": 8000, "salario_max": 12000, "moeda": "BRL|USD|EUR",
    "salario_periodo": "MONTH|YEAR|HOUR", "validade": "2026-12-31", "destaque": false,
    "fonte_nome": "backend-br/vagas", "fonte_url": "https://github.com/..."
  }
}

Atenção: ao atualizar uma vaga pela API, envie sempre "empresa" e "link_candidatura"
dentro de "acf" (o ACF exige os campos obrigatórios em toda gravação).

== Changelog ==

= 1.0.0 =
* Primeira versão.

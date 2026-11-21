=== Capivara Vagas ===
Requires at least: 6.6
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.2.0
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
  "termos": {                   // pelo nome ou slug; stacks novas são criadas
    "modelo": ["remoto"],       // remoto | hibrido | presencial
    "senioridade": ["pleno"],   // estagio | junior | pleno | senior | especialista
    "stack": ["PHP", "Laravel"]
  },
  // (ou pelos IDs: "vaga_modelo": [ID], "vaga_senioridade": [ID], "vaga_stack": [ID])
  "acf": {
    "empresa": "Acme", "empresa_site": "https://...", "link_candidatura": "https://... ou e-mail",
    "contrato": "clt|pj|estagio|freelance|temporario|outro", "localizacao": "São Paulo/SP",
    "paises": "BR", "salario_min": 8000, "salario_max": 12000, "moeda": "BRL|USD|EUR",
    "salario_periodo": "MONTH|YEAR|HOUR", "validade": "20261231", "destaque": false,
    "fonte_nome": "backend-br/vagas", "fonte_url": "https://github.com/..."
  }
}

Atenção: ao atualizar uma vaga pela API, envie sempre "empresa" e "link_candidatura"
dentro de "acf" (o ACF exige os campos obrigatórios em toda gravação).

== Fontes sem schema ==

Vagas cujo link de fonte é do remotive.com não geram o schema JobPosting: os termos
do Remotive proíbem enviar as vagas deles ao Google Jobs. Elas aparecem no site
normalmente, com o crédito e o link para o Remotive. A lista de domínios pode ser
alterada pelo filtro capivara_vagas_hosts_sem_schema.

== Formulário "Divulgar vaga" ==

Precisa do Contact Form 7. O plugin reconhece o formulário pelo campo oculto
[hidden capivara-form "vaga"] e:

* confere a faixa salarial (máximo maior ou igual ao mínimo), a cidade para vaga
  híbrida ou presencial, o link ou e-mail de candidatura e a data;
* limita a 5 envios por hora por IP (filtro capivara_vagas_form_limite_hora);
* manda a vaga ao webhook do n8n, que grava em capivara_vagas como "nova".

Configuração: variáveis de ambiente (ou constantes no wp-config.php)
CAPIVARA_VAGAS_WEBHOOK_URL e CAPIVARA_VAGAS_WEBHOOK_TOKEN. O token vai no
cabeçalho X-Capivara-Token. Se o n8n não responder, o envio não é bloqueado:
o e-mail do Contact Form 7 leva todos os dados e o erro vai para o log do PHP
("Capivara Vagas: o n8n não recebeu...").

O estilo do formulário (assets/formulario.css) usa as cores do tema e só vale
dentro de .capivara-form-vaga.

== Changelog ==

= 1.2.0 =
* Formulário "Divulgar vaga" (Contact Form 7) ligado ao n8n, com validação extra e limite por IP.


= 1.1.0 =
* Campo "termos" na API REST: modelo, senioridade e stacks pelo nome ou slug (stacks novas são criadas).
* Vagas do Remotive sem schema JobPosting (termos de uso do Remotive).


= 1.0.0 =
* Primeira versão.

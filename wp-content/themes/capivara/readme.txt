=== Capivara de Programa ===
Requires at least: 6.6
Tested up to: 7.1
Stable tag: 1.2.0
Requires PHP: 7.4
License: GPLv2 or later

Tema de blocos (Full Site Editing) escuro para o capivaradeprograma.com.br.

== Instalação ==

1. Painel do WordPress › Aparência › Temas › Adicionar novo › Enviar tema.
2. Envie o arquivo capivara.zip e clique em Ativar.
3. Configurações › Links permanentes: escolha "Estrutura personalizada" com /%category%/%postname%/
   (as URLs ficam /tutoriais/nome-do-post e /noticias/nome-do-post).
4. Ao ativar, o tema cria (se ainda não existirem) as categorias Notícias, Tutoriais
   e Diário de dev, e um RASCUNHO da página "Vagas" já com o modelo "Vagas". Revise e publique.
5. Configurações › Geral: confira o título "Capivara de Programa" e a descrição
   "Programação & Cia." (aparecem no cabeçalho).

== O que vem no tema ==

* Modelos: página inicial, blog, post, página, arquivo (categoria/tag), busca, 404,
  "Vagas" e "Página sem título (largura total)". Tudo editável em Aparência › Editor.
* Padrões (categoria "Capivara de Programa" no inseridor): abertura com janela da live,
  últimas publicações, tutoriais por stack, faixa de vagas, redes sociais e RSS,
  "Dica da capivara" (para os tutoriais) e card de vaga.
* Fontes locais (Montserrat, Inter e JetBrains Mono). Nenhuma requisição ao Google Fonts,
  o que ajuda na LGPD e na velocidade.
* Posts sem imagem destacada ganham uma miniatura no estilo terminal, colorida pela categoria.
* Tempo de leitura automático nos cards e no post.
* Botão "Copiar" nos blocos de código.
* "Leia também" no fim do post, com posts da mesma categoria.

== Idiomas (preparado, ainda desligado) ==

O tema está pronto para ter uma versão em inglês, mas nada muda enquanto não houver
um plugin de idiomas. Sem plugin, o site fica sempre em português, mesmo que o idioma
do WordPress esteja em inglês.

* Todos os textos fixos do tema (menus, botões, "Leia também", "Copiar", tempo de leitura,
  404, busca, vagas) passam pelo sistema de tradução do WordPress (domínio "capivara").
* languages/capivara.pot: modelo com todos os textos. languages/en_US.*: tradução em inglês pronta.
* Bloco "Seletor de idioma": já está no cabeçalho e mostra PT · EN quando o Polylang estiver
  ativo com dois idiomas. Sem o plugin, não aparece.
* Links do tema para categorias, tags e páginas (Notícias, Tutoriais, Vagas, stacks) seguem
  o idioma atual quando a categoria ou página tiver tradução no Polylang.

Para ligar o inglês: instale o Polylang, crie os idiomas Português (padrão) e English,
atribua o conteúdo existente ao português e crie as categorias e a página traduzidas
(Tutorials, News, Jobs), ligando cada uma à original.

Importante: os textos dos modelos (404, busca, arquivo, barra lateral do post, topo de vagas)
agora vêm de padrões do tema. Se um modelo for editado e salvo em Aparência › Editor, ele passa
a ficar no banco com o texto fixo e deixa de ser traduzido. Para voltar ao do tema, use
"Restaurar" no menu do modelo.

== Anúncios ==

Aparência › Anúncios: cole o código de cada espaço (por exemplo, um bloco do Google AdSense).

* Horizontal: entre as seções da página inicial.
* Lateral: barra lateral do post (300 × 250).
* No meio do artigo: entra sozinho depois do parágrafo que você escolher (padrão: 3º).
* Patrocinado (vagas): use o bloco "Anúncio" na página de vagas.

Espaço vazio não aparece para visitantes; administradores veem uma moldura tracejada
indicando onde o anúncio vai ficar. O bloco "Anúncio" pode ser colocado em qualquer
modelo ou post pelo editor.

Para o AdSense, lembre de criar o arquivo ads.txt na raiz do site (o AdSense mostra o conteúdo).

== Ajustes rápidos ==

* Links das redes: edite o padrão "Redes sociais e RSS" na página inicial (Aparência › Editor).
  LinkedIn, Twitch e o Squad do daily.dev estão com "#" até você ter os endereços.
* Live: na página inicial, troque "[Dia e horário]" e, se quiser, a imagem da janela por um
  bloco de incorporação do YouTube.
* Cores e fontes: Aparência › Editor › Estilos.

== Créditos ==

Fontes Montserrat, Inter e JetBrains Mono: SIL Open Font License 1.1 (via Fontsource).

== Vagas (plugin Capivara Vagas) ==

Com o plugin Capivara Vagas ativo, o tema mostra:
* /vagas/: lista com topo mostarda, filtros por modelo de trabalho e stack, espaço
  "Patrocinado" e as vagas (as em destaque primeiro).
* /vagas/stack/..., /vagas/modelo/..., /vagas/nivel/...: a mesma lista, filtrada.
* Página de cada vaga: descrição e caixa com os dados e o botão "Candidatar-se".
* Faixa de vagas da página inicial: as 3 vagas mais recentes.
Sem o plugin, a faixa mostra só a chamada e o tema continua funcionando.

== Changelog ==

= 1.2.0 =
* Modelos de vagas (lista, filtros e página da vaga) para o plugin Capivara Vagas.
* Faixa de vagas da página inicial com as 3 vagas mais recentes.
* Links de vagas apontam para /vagas/; a página "Vagas" deixa de ser criada quando o plugin existe.
* Traduções em inglês atualizadas.


= 1.1.0 =
* Tema preparado para tradução: textos fixos com funções de tradução, .pot e inglês (en_US).
* Bloco "Seletor de idioma" no cabeçalho (só aparece com o Polylang).
* Links de categorias, tags e páginas seguem o idioma atual quando há tradução.
* Textos dos modelos movidos para padrões; links "/" e "/vagas/" agora gerados pelo WordPress.

= 1.0.0 =
* Primeira versão.

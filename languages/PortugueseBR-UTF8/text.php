<?php
switch ($textpart) {
  //browsesources.php, showsource.php
  case "sources":
    $text['browseallsources'] = "Mostrar todas fontes";
    $text['shorttitle'] = "Título abreviado";
    $text['callnum'] = "Número de registro";
    $text['author'] = "Autor(a)";
    $text['publisher'] = "Publicado por";
    $text['other'] = "Informações adicionais";
    $text['sourceid'] = "ID da fonte";
    $text['moresrc'] = "Outras fontes";
    $text['repoid'] = "Identificador do arquivo";
    $text['browseallrepos'] = "Folhar pelos arquivos";
    break;

  //changelanguage.php, savelanguage.php
  case "language":
    $text['newlanguage'] = "Novo idioma";
    $text['changelanguage'] = "Outro idioma";
    $text['languagesaved'] = "Idioma armazenado";
    $text['sitemaint'] = "Manutenção do site em andamento";
    $text['standby'] = "O site está temporariamente fora do ar por manutenção na base de dados. Favor tentar novamente depois de alguns minutos. Se o site permanecer fora do ar por um período mais longo, favor <a href=\"suggest.php\">contatar o proprietário do site</a>.";
    break;

  //gedcom.php, gedform.php
  case "gedcom":
    $text['gedstart'] = "GEDCOM inicia para";
    $text['producegedfrom'] = "Gerar arquivo GEDCOM contendo";
    $text['numgens'] = "Número de gerações";
    $text['includelds'] = "Incluir informações SUD";
    $text['buildged'] = "Gerar GEDCOM";
    $text['gedstartfrom'] = "GEDCOM inicia a partir de";
    $text['nomaxgen'] = "Informe o número máximo de gerações. Por favor, aperte o botão voltar e corrija o erro.";
    $text['gedcreatedfrom'] = "GEDCOM criado a partir de";
    $text['gedcreatedfor'] = "Gerado para";
    $text['creategedfor'] = "Gerar arquivo GEDCOM para";
    $text['email'] = "E-mail";
    $text['suggestchange'] = "Sugestão de alteração para";
    $text['yourname'] = "Seu nome";
    $text['comments'] = "Notas ou comentários";
    $text['comments2'] = "Comentários";
    $text['submitsugg'] = "Submeter a sugestão";
    $text['proposed'] = "Alteração proposta";
    $text['mailsent'] = "Obrigado. Sua mensagem foi enviada.";
    $text['mailnotsent'] = "Sua mensagem não pode ser enviada. Favor contatar xxx diretamente através do e-mail yyy.";
    $text['mailme'] = "Enviar uma cópia a este endereço";
    $text['entername'] = "Por favor, entre seu nome";
    $text['entercomments'] = "Por favor, entre seus comentários";
    $text['sendmsg'] = "Enviar mensagem";
    //added in 9.0.0
    $text['subject'] = "Assunto";
    break;

  //getextras.php, getperson.php
  case "getperson":
    $text['photoshistoriesfor'] = "Fotos e histórias para ";
    $text['indinfofor'] = "Informações individuais sobre";
    $text['pp'] = "pp."; //page abbreviation
    $text['age'] = "Idade";
    $text['agency'] = "Órgão/repartição";
    $text['cause'] = "Causa";
    $text['suggested'] = "Alteração sugerida";
    $text['closewindow'] = "Fechar a janela";
    $text['thanks'] = "Obrigado";
    $text['received'] = "Sua sugestão foi enviada ao administrador.";
    $text['indreport'] = "Relatório Individual";
    $text['indreportfor'] = "Relatório Individual para";
    $text['general'] = "Geral";
    $text['bkmkvis'] = "<strong>Nota:</strong> Estes marcadores são visíveis somente neste navegador, neste computador.";
    //added in 9.0.0
    $text['reviewmsg'] = "Há alterações sugeridas para revisão. Elas são relativas a:";
    $text['revsubject'] = "Alterações sugeridas requerem revisão";
    break;

  //relateform.php, relationship.php, findpersonform.php, findperson.php
  case "relate":
    $text['relcalc'] = "Computar relações de parentesco";
    $text['findrel'] = "Encontrar parentesco";
    $text['person1'] = "Pessoa 1:";
    $text['person2'] = "Pessoa 2:";
    $text['calculate'] = "Computar";
    $text['select2inds'] = "Favor escolher duas pessoas.";
    $text['findpersonid'] = "Encontrar ID de pessoa";
    $text['enternamepart'] = "Forneça uma parte do prenome ou do sobrenome";
    $text['pleasenamepart'] = "Entre com uma parte de um prenome ou sobrenome.";
    $text['clicktoselect'] = "clique para selecionar";
    $text['nobirthinfo'] = "Não há informação de nascimento";
    $text['relateto'] = "Parente de ";
    $text['sameperson'] = "As pessoas são as mesmas.";
    $text['notrelated'] = "As duas pessoas não têm parentesco em xxx gerações."; //xxx will be replaced with number of generations
    $text['findrelinstr'] = "Instruções: Forneça os IDs de duas pessoas (ou utilize as pessoas mostradas). Após clique o botão Computar para mostrar o parentesco até xxx gerações.";
    $text['sometimes'] = "(Às vezes, um resultado diferente pode ser obtido entrando com um número diferente de gerações.)";
    $text['findanother'] = "Encontrar outro parentesco";
    $text['brother'] = "irmão de";
    $text['sister'] = "irmã de";
    $text['sibling'] = "irmão/irmã de";
    $text['uncle'] = "tio xxx de";
    $text['aunt'] = "tia xxx de";
    $text['uncleaunt'] = "tio/tia xxx de";
    $text['nephew'] = "xxx sobrinho de";
    $text['niece'] = "xxx sobrinha de";
    $text['nephnc'] = "xxx sobrinho/sobrinha de";
    $text['removed'] = "vezes removido";
    $text['rhusband'] = "marido de  ";
    $text['rwife'] = "esposa de ";
    $text['rspouse'] = "cônjuge de ";
    $text['son'] = "filho de";
    $text['daughter'] = "filha de";
    $text['rchild'] = "filho/filha de";
    $text['sil'] = "genro de";
    $text['dil'] = "nora de";
    $text['sdil'] = "genro/nora de";
    $text['gson'] = "xxx neto de";
    $text['gdau'] = "xxx neta de";
    $text['gsondau'] = "xxx neto/neta de";
    $text['great'] = "grande";
    $text['spouses'] = "são cônjuges";
    $text['is'] = "é";
    $text['changeto'] = "Mudar para:";
    $text['notvalid'] = "não é um ID válido de pessoa nesta base de dados. Por favor, tente novamente.";
    $text['halfbrother'] = "meio-irmão de";
    $text['halfsister'] = "meia-irmã de";
    $text['halfsibling'] = "meio-irmão de";
    //changed in 8.0.0
    $text['gencheck'] = "Número máximo de<br />gerações a considerar";
    $text['mcousin'] = "xxx primo yyy de";  //male cousin; xxx = cousin number, yyy = times removed
    $text['fcousin'] = "xxx prima yyy de";  //female cousin
    $text['cousin'] = "xxx primo/prima yyy de";
    $text['mhalfcousin'] = "xxx meio-primo yyy de";  //male cousin
    $text['fhalfcousin'] = "xxx meia-prima yyy de";  //female cousin
    $text['halfcousin'] = "xxx meio-primo yyy de";
    //added in 8.0.0
    $text['oneremoved'] = "removido uma vez";
    $text['gfath'] = "xxx avô de";
    $text['gmoth'] = "xxx avó de";
    $text['gpar'] = "xxx avô/avó de";
    $text['mothof'] = "a mãe de";
    $text['fathof'] = "o pai de";
    $text['parof'] = "genitor de";
    $text['maxrels'] = "Número máximo de parentescos mostrados";
    $text['dospouses'] = "Mostrar parentescos envolvendo a esposa";
    $text['rels'] = "Parentescos";
    $text['dospouses2'] = "Mostrar esposas";
    $text['fil'] = "sogro de";
    $text['mil'] = "sogra de";
    $text['fmil'] = "sogro/sogra de";
    $text['stepson'] = "enteado de";
    $text['stepdau'] = "enteada de";
    $text['stepchild'] = "enteado/enteada de";
    $text['stepgson'] = "xxx enteado de";
    $text['stepgdau'] = "xxx enteada de";
    $text['stepgchild'] = "xxx enteado/enteada de";
    //added in 8.1.1
    $text['ggreat'] = "grande";
    //added in 8.1.2
    $text['ggfath'] = "xxx grande avô de";
    $text['ggmoth'] = "xxx grande avó de";
    $text['ggpar'] = "xxx grande avô/avó de";
    $text['ggson'] = "xxx grande neto de";
    $text['ggdau'] = "xxx grande neta de";
    $text['ggsondau'] = "xxx grande neto/neta de";
    $text['gstepgson'] = "xxx grande enteado de";
    $text['gstepgdau'] = "xxx grande enteada de";
    $text['gstepgchild'] = "xxx grande enteado/enteada de";
    $text['guncle'] = "tio xxx grande de";
    $text['gaunt'] = "tia xxx grande de";
    $text['guncleaunt'] = "tio/tia xxx grande de";
    $text['gnephew'] = "xxx grande sobrinho de";
    $text['gniece'] = "xxx grande sobrinha de";
    $text['gnephnc'] = "xxx grande sobrinho/sobrinha de";
    break;

  case "familygroup":
    $text['familygroupfor'] = "Ficha familiar para ";
    $text['ldsords'] = "Informações SUD";
    $text['baptizedlds'] = "Batismo (SUD)";
    $text['endowedlds'] = "Investidura (SUD)";
    $text['sealedplds'] = "Selamento aos pais (SUD)";
    $text['sealedslds'] = "Selamento ao cônjuge (SUD)";
    $text['otherspouse'] = "Outros cônjuges";
    $text['husband'] = "Pai";
    $text['wife'] = "Mãe";
    break;

  //pedigree.php
  case "pedigree":
    $text['capbirthabbr'] = "NASC";
    $text['capaltbirthabbr'] = "EM";
    $text['capdeathabbr'] = "FAL";
    $text['capburialabbr'] = "SEPUL";
    $text['capplaceabbr'] = "EM";
    $text['capmarrabbr'] = "CAS";
    $text['capspouseabbr'] = "ESP";
    $text['redraw'] = "Reapresentar com ";
    $text['scrollnote'] = "Observação: talvez seja necessário rolar para a direita ou para baixo para visualizar todo o diagrama.";
    $text['unknownlit'] = "Desconhecido";
    $text['popupnote1'] = " = Informação adicional";
    $text['popupnote2'] = " = Nova árvore";
    $text['pedcompact'] = "Compacta";
    $text['pedstandard'] = "Padrão";
    $text['pedtextonly'] = "Textual";
    $text['descendfor'] = "Descendentes de ";
    $text['maxof'] = "Mostrar no máximo";
    $text['gensatonce'] = "gerações.";
    $text['sonof'] = "Filho de ";
    $text['daughterof'] = "Filha de ";
    $text['childof'] = "Filho(a) de ";
    $text['stdformat'] = "Formato padrão";
    $text['ahnentafel'] = "Árvore de costado (Ahnentafel)";
    $text['addnewfam'] = "Adicionar nova família";
    $text['editfam'] = "Alterar família";
    $text['side'] = "(lado dos)";
    $text['familyof'] = "Família de ";
    $text['paternal'] = "Lado paterno";
    $text['maternal'] = "lado materno";
    $text['gen1'] = "Próprio";
    $text['gen2'] = "Pais ";
    $text['gen3'] = "Avós 4";
    $text['gen4'] = "Bisavós 8";
    $text['gen5'] = "Tataravós 16";
    $text['gen6'] = "Tetravós 32";
    $text['gen7'] = "Pentavós 64";
    $text['gen8'] = "Hexavós 128";
    $text['gen9'] = "Heptavós 256";
    $text['gen10'] = "Octavós 512";
    $text['gen11'] = "Nonavós 1024";
    $text['gen12'] = "Decavós 2048";
    $text['graphdesc'] = "Representação gráfica dos descendentes";
    $text['pedbox'] = "Completa";
    $text['regformat'] = "Formato Registro";
    $text['extrasexpl'] = "Se houver textos ou fotos para estas pessoas, ícones correspondentes aparecerão junto a seus nomes.";
    $text['popupnote3'] = " = Novo gráfico";
    $text['mediaavail'] = "Mídia disponível";
    $text['pedigreefor'] = "Diagrama de Pedigree para";
    $text['pedigreech'] = "Diagrama de  Pedigree";
    $text['datesloc'] = "Datas e Lugares";
    $text['borchr'] = "Nasc/Bat – Falec/Sepult (dois)";
    $text['nobd'] = "Sem datas de nascimento ou falecimento";
    $text['bcdb'] = " Nasc/Bat/Falec/Sepult (quatro)";
    $text['numsys'] = "Sistema de numeração";
    $text['gennums'] = "Números de Geração";
    $text['henrynums'] = "Números Henry";
    $text['abovnums'] = " Números d'Aboville";
    $text['devnums'] = " Números de Villiers";
    $text['dispopts'] = "Opções de Exibição";
    //added in 10.0.0
    $text['no_ancestors'] = "Sem ancestrais";
    $text['ancestor_chart'] = "Diagrama vertical de ancestrais";
    $text['opennewwindow'] = "Abrir em nova janela";
    $text['pedvertical'] = "Vertical";
    //added in 11.0.0
    $text['familywith'] = "Família com";
    $text['fcmlogin'] = "Favor fazer login para ver mais detalhes";
    $text['isthe'] = "é o";
    $text['otherspouses'] = "outras esposas";
    $text['parentfamily'] = "A família dos pais é ";
    $text['showfamily'] = "Mostrar a família";
    $text['shown'] = "mostrado";
    $text['showparentfamily'] = "mostrar família dos pais";
    $text['showperson'] = "mostrar pessoa";
    //added in 11.0.2
    $text['otherfamilies'] = "Outras famílias";
    break;

  //search.php, searchform.php
  //merged with reports and showreport in 5.0.0
  case "search":
  case "reports":
    $text['noreports'] = "Não há relatórios.";
    $text['reportname'] = "Nome do relatório";
    $text['allreports'] = "Todos relatórios";
    $text['report'] = "Relatório";
    $text['error'] = "Erro";
    $text['reportsyntax'] = "A sintaxe da consulta referente a este relatório é";
    $text['wasincorrect'] = "inválida. O relatório não pode ser criado. Por favor, comunique ao responsável pelo sistema";
    $text['errormessage'] = "Mensagem de erro";
    $text['equals'] = "igual a";
    $text['endswith'] = "termina com";
    $text['soundexof'] = "soundex de";
    $text['metaphoneof'] = "metafon de";
    $text['plusminus10'] = "+/- 10 anos de";
    $text['lessthan'] = "menor que";
    $text['greaterthan'] = "maior que";
    $text['lessthanequal'] = "menor ou igual a";
    $text['greaterthanequal'] = "maior ou igual a";
    $text['equalto'] = "é igual";
    $text['tryagain'] = "Favor tentar novamente";
    $text['joinwith'] = "Conectivo lógico";
    $text['cap_and'] = "E";
    $text['cap_or'] = "OU";
    $text['showspouse'] = "Mostre cônjuge; em caso de vários cônjuges, serão mostradas duplicatas";
    $text['submitquery'] = "Buscar";
    $text['birthplace'] = "Lugar de nascimento";
    $text['deathplace'] = "Lugar de falecimento";
    $text['birthdatetr'] = "Ano de nascimento";
    $text['deathdatetr'] = "Ano de falecimento";
    $text['plusminus2'] = "+/- 2 anos";
    $text['resetall'] = "Limpar todos valores";
    $text['showdeath'] = "Mostrar informações de falecimento/sepultamento";
    $text['altbirthplace'] = "Lugar do batismo";
    $text['altbirthdatetr'] = "Ano do batismo";
    $text['burialplace'] = "Lugar do sepultamento";
    $text['burialdatetr'] = "Ano de sepultamento";
    $text['event'] = "Evento(s)";
    $text['day'] = "Dia";
    $text['month'] = "Mês";
    $text['keyword'] = "Palavra chave (p.ex.: \"ABT\", \"BEF\", \"AFT\")";
    $text['explain'] = "Escrever data (ou parte dela) para obter eventos correspondentes. Deixar em branco para obter todas.";
    $text['enterdate'] = "Favor fornecer ou selecionar ao menos: dia, mês, ano ou palavra chave";
    $text['fullname'] = "Nome completo";
    $text['birthdate'] = "Data do nascimento";
    $text['altbirthdate'] = "Data do batismo";
    $text['marrdate'] = "Data do casamento";
    $text['spouseid'] = "ID do cônjuge";
    $text['spousename'] = "Nome do cônjuge";
    $text['deathdate'] = "Data do falecimento";
    $text['burialdate'] = "Data do sepultamento";
    $text['changedate'] = "Data da última alteração";
    $text['gedcom'] = "Árvore";
    $text['baptdate'] = "Data do batismo (SUD)";
    $text['baptplace'] = "Lugar do batismo (SUD)";
    $text['endldate'] = "Data da Investidura (SUD)";
    $text['endlplace'] = "Lugar da Investidura (SUD)";
    $text['ssealdate'] = "Data do Selamento ao Cônjuge (SUD)";   //Sealed to spouse
    $text['ssealplace'] = "Lugar do Selamento ao Cônjuge (SUD)";
    $text['psealdate'] = "Data do Selamento aos Pais (SUD)";   //Sealed to parents
    $text['psealplace'] = "Lugar do Selamento aos Pais (SUD)";
    $text['marrplace'] = "Lugar do Casamento";
    $text['spousesurname'] = "Sobrenome do cônjuge";
    $text['spousemore'] = "Se você preencher o sobrenome do cônjuge, deverá preencher ao menos um outro campo.";
    $text['plusminus5'] = "+/- 5 anos de agora";
    $text['exists'] = "existe";
    $text['dnexist'] = "não existe";
    $text['divdate'] = "Data de divórcio";
    $text['divplace'] = "Lugar de divórcio";
    $text['otherevents'] = "Outros eventos";
    $text['numresults'] = "Resultados por Página";
    $text['mysphoto'] = "Fotos Misteriosas";
    $text['mysperson'] = "Pessoas Procuradas";
    $text['joinor'] = "A opção 'Junção com OU' não pode ser usada com o Sobrenome da Esposa";
    $text['tellus'] = "Nos informe o que você sabe";
    $text['moreinfo'] = "Mais Informação:";
    //added in 8.0.0
    $text['marrdatetr'] = "Ano do casamento";
    $text['divdatetr'] = "Ano do divórcio";
    $text['mothername'] = "Nome da mãe";
    $text['fathername'] = "Nome do pai";
    $text['filter'] = "Filtro";
    $text['notliving'] = "Falecido";
    $text['nodayevents'] = "Eventos deste mês que não estão associados a dias específicos";
    //added in 9.0.0
    $text['csv'] = "Arquivo CSV";
    //added in 10.0.0
    $text['confdate'] = "Data de confirmação - SUD";
    $text['confplace'] = "Local de confirmação - SUD";
    $text['initdate'] = "Data de iniciação - SUD";
    $text['initplace'] = "Local de iniciação - SUD";
    //added in 11.0.0
    $text['marrtype'] = "Tipo de casamento";
    $text['searchfor'] = "Buscar por";
    $text['searchnote'] = "Observação: Esta busca é realizada usando o Google. O número de respostas depende da quantidade de páginas do sítio que foram indexadas pelo Google.";
    break;

  //showlog.php
  case "showlog":
    $text['logfilefor'] = "Arquivo de log para";
    $text['mostrecentactions'] = "ações mais recentes";
    $text['autorefresh'] = "atualização automática (a cada 30 segundos)";
    $text['refreshoff'] = "desligar a atualização automática";
    break;

  case "headstones":
  case "showphoto":
    $text['cemeteriesheadstones'] = "Cemitérios e Lápides";
    $text['showallhsr'] = "Mostrar todas lápides";
    $text['in'] = "em";
    $text['showmap'] = "Mostrar mapa";
    $text['headstonefor'] = "Lápide de";
    $text['photoof'] = "Fotografia de  ";
    $text['photoowner'] = "Proprietário/fonte";
    $text['nocemetery'] = "Sem cemitério";
    $text['iptc005'] = "Título";
    $text['iptc020'] = "Categorias adicionais";
    $text['iptc040'] = "Instruções especiais";
    $text['iptc055'] = "Data de criação";
    $text['iptc080'] = "Autor";
    $text['iptc085'] = "Função do autor";
    $text['iptc090'] = "Cidade";
    $text['iptc095'] = "Estado";
    $text['iptc101'] = "País";
    $text['iptc103'] = "OTR";
    $text['iptc105'] = "Cabeçalho";
    $text['iptc110'] = "Fonte";
    $text['iptc115'] = "Fonte des Fotografias";
    $text['iptc116'] = "Direitos autorais";
    $text['iptc120'] = "Legenda";
    $text['iptc122'] = "Autor da legenda";
    $text['mapof'] = "Mapa de ";
    $text['regphotos'] = "Visão com miniaturas e texto";
    $text['gallery'] = "Somente miniaturas";
    $text['cemphotos'] = "Fotos de cemitérios";
    $text['photosize'] = "Tamanho";
    $text['iptc010'] = "Prioridade";
    $text['filesize'] = "Tamanho do arquivo";
    $text['seeloc'] = "Ver localização";
    $text['showall'] = "Mostrar tudo";
    $text['editmedia'] = "Editar mídia";
    $text['viewitem'] = "Ver este item";
    $text['editcem'] = "Editar Cemitério";
    $text['numitems'] = "# Ítens";
    $text['allalbums'] = "Todos álbuns";
    $text['slidestop'] = "Suspender apresentação";
    $text['slideresume'] = "Reiniciar apresentação";
    $text['slidesecs'] = "Segundos por slide:";
    $text['minussecs'] = "menos 0.5 segundos";
    $text['plussecs'] = "mais 0.5 segundos";
    $text['nocountry'] = "País desconhecido";
    $text['nostate'] = "Estado desconhecido";
    $text['nocounty'] = "Condado desconhecido";
    $text['nocity'] = "Cidade desconhecida";
    $text['nocemname'] = "Nome de cemitério desconhecido";
    $text['editalbum'] = "Editar Álbum";
    $text['mediamaptext'] = "<strong>Nota:</strong> Mova o ponteiro do mouse sobre a imagem para mostrar nomes. Clique para ver a página correspondente ao nome.";
    //added in 8.0.0
    $text['allburials'] = "Todos sepultamentos";
    $text['moreinfo'] = "Mais Informação:";
    //added in 9.0.0
    $text['iptc025'] = "Palavras chave";
    $text['iptc092'] = "Sub-local";
    $text['iptc015'] = "Categoria";
    $text['iptc065'] = "Programa de origem";
    $text['iptc070'] = "Versão do programa";
    break;

  //surnames.php, surnames100.php, surnames-all.php, surnames-oneletter.php
  case "surnames":
  case "places":
    $text['surnamesstarting'] = "Mostrar sobrenomes que começam com a letra";
    $text['showtop'] = "Mostrar os primeiros ";
    $text['showallsurnames'] = "Mostrar todos sobrenomes";
    $text['sortedalpha'] = "em ordem alfabética";
    $text['byoccurrence'] = "em ordem de ocorrência";
    $text['firstchars'] = "Primeiras letras";
    $text['mainsurnamepage'] = "Página inicial de sobrenomes";
    $text['allsurnames'] = "Todos sobrenomes";
    $text['showmatchingsurnames'] = "Clique no sobrenome para obter mais informações";
    $text['backtotop'] = "Para o topo";
    $text['beginswith'] = "Inicia com";
    $text['allbeginningwith'] = "Todas famílias que começam com a letra";
    $text['numoccurrences'] = "número de ocorrências entre parênteses";
    $text['placesstarting'] = "Mostrar lugares que começam com";
    $text['showmatchingplaces'] = "Clique em um nome para mostrar lugares menores. Clique na pequena lupa para mostrar pessoas no lugar.";
    $text['totalnames'] = "total de nomes";
    $text['showallplaces'] = "Mostrar os lugares mais abrangentes";
    $text['totalplaces'] = "no. de lugares";
    $text['mainplacepage'] = "Página das lugares mais abrangentes";
    $text['allplaces'] = "Todos lugares mais abrangentes";
    $text['placescont'] = "Mostar todos lugares que contém ...";
    //changed in 8.0.0
    $text['top30'] = "xxx sobrenomes mais freqüentes";
    $text['top30places'] = "xxx lugares com mais indivíduos";
    //added in 12.0.0
    $text['firstnamelist'] = "Lista de Prenomes";
    $text['firstnamesstarting'] = "Mostrar os prenomes começando com";
    $text['showallfirstnames'] = "Mostrar todos os prenomes";
    $text['mainfirstnamepage'] = "Página principal de prenomes";
    $text['allfirstnames'] = "Todos Prenomes";
    $text['showmatchingfirstnames'] = "Clique em um prenome para mostrar registros correspondentes.";
    $text['allfirstbegwith'] = "Todos os prenomes começando com";
    $text['top30first'] = "Primeiros xxx prenomes";
    $text['allothers'] = "Todos demais";
    $text['amongall'] = "(entre todos nomes)";
    $text['justtop'] = "Somente os primeiros xxx";
    break;

  //whatsnew.php
  case "whatsnew":
    $text['pastxdays'] = "(últimos xx dias)";

    $text['photo'] = "Fotografias";
    $text['history'] = "Histórias/Documentos";
    $text['husbid'] = " ID do Pai";
    $text['husbname'] = "Nome do Pai";
    $text['wifeid'] = " ID da Mãe";
    //added in 11.0.0
    $text['wifename'] = "Mother's Name";
    break;

  //timeline.php, timeline2.php
  case "timeline":
    $text['text_delete'] = "Excluir";
    $text['addperson'] = "Adicionar pessoa";
    $text['nobirth'] = "A pessoa que segue não tem data de nascimento (não é possível adicioná-la à linha de tempo)";
    $text['event'] = "Evento(s)";
    $text['chartwidth'] = "Largura do diagrama";
    $text['timelineinstr'] = "Adicione até quatro pessoas fornecendo seus IDs:";
    $text['togglelines'] = "Trocar linhas";
    //changed in 9.0.0
    $text['noliving'] = "A pessoa que segue está viva. Por questões de privacidade não pode ser adicionada à linha de tempo";
    break;

  //browsetrees.php
  //login.php, newacctform.php, addnewacct.php
  case "trees":
  case "login":
    $text['browsealltrees'] = "Mostre todas árvores";
    $text['treename'] = "Nome da árvore";
    $text['owner'] = "Proprietário";
    $text['address'] = "Endereço";
    $text['city'] = "Cidade";
    $text['state'] = "Estado";
    $text['zip'] = "CEP";
    $text['country'] = "País";
    $text['email'] = "E-mail";
    $text['phone'] = "Telefone";
    $text['username'] = "Usuário";
    $text['password'] = "Senha";
    $text['loginfailed'] = "O login falhou.";

    $text['regnewacct'] = "Solicitar registro como usuário";
    $text['realname'] = "Nome do usuário";
    $text['phone'] = "Telefone";
    $text['email'] = "E-mail";
    $text['address'] = "Endereço";
    $text['acctcomments'] = "Notas ou comentários";
    $text['submit'] = "Submeter";
    $text['leaveblank'] = "(deixar em branco ao solicitar nova árvore)";
    $text['required'] = "Campos obrigatórios";
    $text['enterpassword'] = "Por favor forneça uma senha.";
    $text['enterusername'] = "Por favor forneça um usuário.";
    $text['failure'] = "Usuário já utilizado. Favor voltar à página anterior usando o botão voltar de seu browser e fornecer outro usuário.";
    $text['success'] = "Obrigado. Sua solicitação de registro foi recebida corretamente. Entraremos em contato consigo.";
    $text['emailsubject'] = "Solicitação de registro de novo usuário";
    $text['website'] = "Página Web (endereço-WWW)";
    $text['nologin'] = "Não possui senha?";
    $text['loginsent'] = "Sua informação de usuário foi enviada";
    $text['loginnotsent'] = "A informação de usuário não foi enviada";
    $text['enterrealname'] = "Favor informar o seu nome.";
    $text['rempass'] = "Permaneça logado neste computador";
    $text['morestats'] = "Mais estatísticas";
    $text['accmail'] = "<strong>NOTA:</strong> Para garantir que você receba e-mail do administrador deste site relativo a sua conta, por favor, assegure-se que seu servidor de e-mail não está bloqueando mensagens desta conta.";
    $text['newpassword'] = "Nova senha";
    $text['resetpass'] = "Criar nova senha";
    $text['nousers'] = "Este formulário não pode ser usado enquanto não existirem usuários registrados. Se você é o proprietários deste site, por favor crie a conta de usuários em Administração/Usuários.";
    $text['noregs'] = "Desculpe, mas não estamos aceitando novos usuários no momento. Por favor <a href=\"suggest.php\">contate-nos</a> diretamente se tiver comentários ou questões sobre este site.";
    //changed in 8.0.0
    $text['emailmsg'] = "Você recebeu um pedido de registro de usuário no TNG. Por favor faça as devidas autorizações como usuário administrador do TNG. Caso concorde com o registro, por favor comunique ao solicitante através deste e-mail.";
    $text['accactive'] = "A conta foi ativada, mas o usuário não terá permissões especiais enquanto você não atribuí-las.";
    $text['accinactive'] = "Vá para Administração/Usuários/Revisão para acessar as propriedades da conta. A conta permanecerá inativa até que você a edite e salvar ao menos uma vez.";
    $text['pwdagain'] = "Repetição da senha";
    $text['enterpassword2'] = "Favor entrar com a senha novamente.";
    $text['pwdsmatch'] = "Senhas diferentes. Favor entrar com a mesma senha em ambos campos.";
    //added in 8.0.0
    $text['acksubject'] = "Obrigado pelo registro"; //for a new user account
    $text['ackmessage'] = "Sua solicitação de uma conta de usuário foi recebida. Sua conta permanecerá inativa até que seja revista pelo administrador do sítio. Você será notificado por email, tão logo a solicitação seja aprovada.";
    //added in 12.0.0
    $text['switch'] = "Chavear";
    break;

  //added in 10.0.0
  case "branches":
    $text['browseallbranches'] = "Varrer todos ramos";
    break;

  //statistics.php
  case "stats":
    $text['quantity'] = "Quantidade";
    $text['totindividuals'] = "Pessoas em geral";
    $text['totmales'] = "Homens";
    $text['totfemales'] = "Mulheres";
    $text['totunknown'] = "Sexo indeterminado";
    $text['totliving'] = "Vivos";
    $text['totfamilies'] = "Famílias";
    $text['totuniquesn'] = "Nomes diferentes";
    //$text['totphotos'] = "Total Photos";
    //$text['totdocs'] = "Total Histories &amp; Documents";
    //$text['totheadstones'] = "Total Headstones";
    $text['totsources'] = "Fontes";
    $text['avglifespan'] = "Tempo média de vida";
    $text['earliestbirth'] = "Nascimento mais antigo";
    $text['longestlived'] = "Mais longevo";
    $text['days'] = "dias";
    $text['age'] = "Idade";
    $text['agedisclaimer'] = "Cálculos relacionados à idade baseiam-se nas pessoas com data de nascimento e data de falecimento registradas. Pelo preenchimento incompleto deste campos (por exemplo, \"1945\" ou \"antes de 1860\") estes cálculos podem não estar 100% corretos.";
    $text['treedetail'] = "Mais informações sobre esta árvore";
    $text['total'] = "Total de";
    //added in 12.0
    $text['totdeceased'] = "Total de Falecidos";
    break;

  case "notes":
    $text['browseallnotes'] = "Percorrer todas notas";
    break;

  case "help":
    $text['menuhelp'] = "Significado dos ícones no menu";
    break;

  case "install":
    $text['perms'] = "Permissões foram atribuídas.";
    $text['noperms'] = "Permissões para estes arquivos não puderam ser atribuídas:";
    $text['manual'] = "Por favor, atribua-as manualmente.";
    $text['folder'] = "Pasta";
    $text['created'] = "foi criada";
    $text['nocreate'] = "não pode ser criada. Favor criar manualmente.";
    $text['infosaved'] = "Informação salva, conexão verficada!";
    $text['tablescr'] = "As tabelas foram criadas!";
    $text['notables'] = "As tabelas a seguir não puderam ser criadas:";
    $text['nocomm'] = "TNG não está comunicando com o servirdor de base de dados. As tabelas não foram criadas.";
    $text['newdb'] = "Informação salva, conexão verficada, novo base de dados criado:";
    $text['noattach'] = "Informação salva. Conexão feita, base de dados criada, mas TNG não consegue acessá-la.";
    $text['nodb'] = "Informação salva. Conexão feita, mas a base de dados não existe e não pode ser criada. Favor verficar o nome da base de dados ou usar seu painel de controle para criá-la.";
    $text['noconn'] = "Informação salva mas conexão falhou. Uma ou mais dos seguintes estão incorretos:";
    $text['exists'] = "existe";
    $text['loginfirst'] = "Você deve fazer login (entrar) primeiro.";
    $text['noop'] = "Nenhuma ação foi executada.";
    //added in 8.0.0
    $text['nouser'] = "O usuário não foi criado. Nome de usuário já existente.";
    $text['notree'] = "A árvore não foi criada. ID da árvore já existente.";
    $text['infosaved2'] = "Informação salva";
    $text['renamedto'] = "renomeada para";
    $text['norename'] = "não pode ser renomeada";
    break;

  case "imgviewer":
    $text['zoomin'] = "Mais Zoom";
    $text['zoomout'] = "Menos Zoom";
    $text['magmode'] = "Modo de magnificação";
    $text['panmode'] = "Mode de varredura";
    $text['pan'] = "Clique e arraste para mover dentro da imagem";
    $text['fitwidth'] = "Ajustar largura";
    $text['fitheight'] = "Ajustar altura";
    $text['newwin'] = "Nova janela";
    $text['opennw'] = "Abrir imagem em uma nova janela";
    $text['magnifyreg'] = "Clique para magnificar uma parte da imagem";
    $text['imgctrls'] = "Habilitar controles da imagem";
    $text['vwrctrls'] = "Habilitar controles do visualizador de imagem";
    $text['vwrclose'] = "Fechar visualizador de imagem";
    break;

  case "dna":
    $text['test_date'] = "Data do teste";
    $text['links'] = "Links relevantes";
    $text['testid'] = "ID do teste";
    //added in 12.0.0
    $text['mode_values'] = "Valores de Modo";
    $text['compareselected'] = "Comparar os Selecionados";
    $text['dnatestscompare'] = "Comparar Testes de  Y-DNA";
    $text['keep_name_private'] = "Manter o Nome Privado";
    $text['browsealltests'] = "Procurar todos os testes";
    $text['all_dna_tests'] = "Todos testes de DNA";
    $text['fastmutating'] = "Mutação Rápida";
    $text['alltypes'] = "Todos Tipos";
    $text['allgroups'] = "Todos Grupos";
    $text['Ydna_LITbox_info'] = "Testes vinculados a esta pessoa não foram necessariamente feitos por esta pessoa. <br /> A coluna 'Haplogrupo' exibe dados em vermelho se o resultado for 'Previsto', e em verde se o teste for 'Confirmado'";
    //added in 12.1.0
    $text['dnatestscompare_mtdna'] = "Comparar testes mtDNA";
    $text['dnatestscompare_atdna'] = "Comparar testes atDNA";
    $text['chromosome'] = "Chr";
    $text['centiMorgans'] = "cM";
    $text['snps'] = "SNPs";
    $text['y_haplogroup'] = "Y-DNA";
    $text['mt_haplogroup'] = "mtDNA";
    $text['sequence'] = "Ref";
    $text['extra_mutations'] = "Mutações extra";
    $text['mrca'] = "Ancestral MRC";
    $text['ydna_test'] = "Testes Y-DNA";
    $text['mtdna_test'] = "Testes mtDNA (Mitochondriais)";
    $text['atdna_test'] = "Testes atDNA (autosômicos)";
    $text['segment_start'] = "Início";
    $text['segment_end'] = "Fim";
    $text['suggested_relationship'] = "Sugerido";
    $text['actual_relationship'] = "Real";
    $text['12markers'] = "Marcadores 1-12";
    $text['25markers'] = "Marcadores 13-25";
    $text['37markers'] = "Marcadores 26-37";
    $text['67markers'] = "Marcadores 38-67";
    $text['111markers'] = "Marcadores 68-111";
    break;
}

//common
$text['matches'] = "Resultados";
$text['description'] = "Descrição";
$text['notes'] = "Notas";
$text['status'] = "Status";
$text['newsearch'] = "Nova consulta";
$text['pedigree'] = "Árvore genealógica";
$text['seephoto'] = "Veja foto";
$text['andlocation'] = "& lugar";
$text['accessedby'] = "acessado por";
$text['family'] = "Família"; //from getperson
$text['children'] = "Filhos(as)";  //from getperson
$text['tree'] = "Árvore";
$text['alltrees'] = "Todas árvores";
$text['nosurname'] = "[sem sobrenome]";
$text['thumb'] = "Miniatura";  //as in Thumbnail
$text['people'] = "Pessoas";
$text['title'] = "Título";  //from getperson
$text['suffix'] = "Sufixo";  //from getperson
$text['nickname'] = "Apelido";  //from getperson
$text['lastmodified'] = "Última alteração";  //from getperson
$text['married'] = "Casamento";  //from getperson
//$text['photos'] = "Photos";
$text['name'] = "Nome"; //from showmap
$text['lastfirst'] = "Sobrenome, prenome";  //from search
$text['bornchr'] = "Nascimento/Batismo";  //from search
$text['individuals'] = "Pessoas";  //from whats new
$text['families'] = "Famílias";
$text['personid'] = "ID da pessoa";
$text['sources'] = "Fontes";  //from getperson (next several)
$text['unknown'] = "desconhecido";
$text['father'] = "Pai";
$text['mother'] = "Mãe";
$text['christened'] = "Batismo";
$text['died'] = "Falecimento";
$text['buried'] = "Sepultamento";
$text['spouse'] = "Cônjuge";  //from search
$text['parents'] = "Pais";  //from pedigree
$text['text'] = "Texto";  //from sources
$text['language'] = "Língua";  //from languages
$text['descendchart'] = "Descendentes";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Pessoa";
$text['edit'] = "Editar";
$text['date'] = "Data";
$text['place'] = "Lugar";
$text['login'] = "Entrar";
$text['logout'] = "Sair";
$text['groupsheet'] = "Ficha familiar";
$text['text_and'] = "e";
$text['generation'] = "Geração";
$text['filename'] = "Nome de arquivo";
$text['id'] = "ID";
$text['search'] = "Buscar";
$text['user'] = "Usuário";
$text['firstname'] = "Prenome";
$text['lastname'] = "Sobrenome";
$text['searchresults'] = "Resultado da busca";
$text['diedburied'] = "Falecido";
$text['homepage'] = "Início";
$text['find'] = "Buscar...";
$text['relationship'] = "Parentesco";    //in German, Verwandtschaft
$text['relationship2'] = "Parentesco"; //different in some languages, at least in German (Beziehung)
$text['timeline'] = "Linha de tempo";
$text['yesabbr'] = "S";               //abbreviation for 'yes'
$text['divorced'] = "Divórcio";
$text['indlinked'] = "Ligado a";
$text['branch'] = "Ramo";
$text['moreind'] = "Mais pessoas";
$text['morefam'] = "Mais famílias";
$text['source'] = "Fonte";
$text['surnamelist'] = "Lista de sobrenomes";
$text['generations'] = "Gerações";
$text['refresh'] = "Atualizar";
$text['whatsnew'] = "Recentes";
$text['reports'] = "Relatório";
$text['placelist'] = "Lista de lugares";
$text['baptizedlds'] = "Batismo (SUD)";
$text['endowedlds'] = "Investidura (SUD)";
$text['sealedplds'] = "Selamento aos pais (SUD)";
$text['sealedslds'] = "Selamento ao cônjuge (SUD)";
$text['ancestors'] = "Ancestrais";
$text['descendants'] = "Descendentes";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Data da última importação de GEDCOM";
$text['type'] = "Tipo";
$text['savechanges'] = "Salvar";
$text['familyid'] = "ID da família";
$text['headstone'] = "Lápides";
$text['historiesdocs'] = "Histórias e Documentos";
$text['anonymous'] = "anônimo";
$text['places'] = "Lugares";
$text['anniversaries'] = "Datas e aniversários";
$text['administration'] = "Administração";
$text['help'] = "Ajuda";
//$text['documents'] = "Documents";
$text['year'] = "Ano";
$text['all'] = "Todos";
$text['repository'] = "Repositório";
$text['address'] = "Endereço";
$text['suggest'] = "Sugestão de alteração";
$text['editevent'] = "Sugestão de alteração deste evento";
$text['findplaces'] = "Encontrar todas pessoas com eventos nestes local";
$text['morelinks'] = "Mais vínculos";
$text['faminfo'] = "Dados da família";
$text['persinfo'] = "Dados da pessoa";
$text['srcinfo'] = "Dados da fonte";
$text['fact'] = "Fato";
$text['goto'] = "Selecione uma página";
$text['tngprint'] = "Imprimir";
$text['databasestatistics'] = "Estatísticas"; //needed to be shorter to fit on menu
$text['child'] = "Filho(a)";  //from familygroup
$text['repoinfo'] = "Informação do local de arquivamento";
$text['tng_reset'] = "Limpar";
$text['noresults'] = "Resultado vazio";
$text['allmedia'] = "Toda mídia";
$text['repositories'] = "Repositórios";
$text['albums'] = "Álbuns";
$text['cemeteries'] = "Cemitérios";
$text['surnames'] = "Sobrenomes";
$text['dates'] = "Datas";
$text['link'] = "Link";
$text['media'] = "Mídia";
$text['gender'] = "Sexo";
$text['latitude'] = "Latitude";
$text['longitude'] = "Longitude";
$text['bookmarks'] = "Marcadores";
$text['bookmark'] = "Adicionar marcadores";
$text['mngbookmarks'] = "Ir para Marcadores";
$text['bookmarked'] = "Marcador Adicionado";
$text['remove'] = "Remover";
$text['find_menu'] = "Buscar";
$text['info'] = "Info"; //this needs to be a very short abbreviation
$text['cemetery'] = "Cemitérios";
$text['gmapevent'] = "Mapa de eventos";
$text['gevents'] = "Evento";
$text['glang'] = "&amp;hl=pt-BR";
$text['googleearthlink'] = "Link para Google Earth";
$text['googlemaplink'] = "Link para Google Maps";
$text['gmaplegend'] = "Legenda";
$text['unmarked'] = "Não marcado";
$text['located'] = "Localizado";
$text['albclicksee'] = "Clicar para ver todos itens do álbum";
$text['notyetlocated'] = "Ainda não localizado";
$text['cremated'] = "Cremação";
$text['missing'] = "Faltando";
$text['pdfgen'] = "Gerador de PDF";
$text['blank'] = "Diagrama Vazio";
$text['none'] = "Nenhum";
$text['fonts'] = "Fontes";
$text['header'] = "Cabeçalho";
$text['data'] = "Dados";
$text['pgsetup'] = "Configuração";
$text['pgsize'] = "Tamanho da Folha";
$text['orient'] = "Orientação"; //for a page
$text['portrait'] = "Retrato";
$text['landscape'] = "Paisagem";
$text['tmargin'] = " Margem Superior";
$text['bmargin'] = " Margem Inferior";
$text['lmargin'] = " Margem Esquerda";
$text['rmargin'] = "Margem Direita";
$text['createch'] = "Criar Diagrama";
$text['prefix'] = "Prefixo";
$text['mostwanted'] = "Mais Procurado";
$text['latupdates'] = "Últimas alterações";
$text['featphoto'] = "Foto do dia";
$text['news'] = "Novidades";
$text['ourhist'] = "Nossa História de Família";
$text['ourhistanc'] = "Nossa História de Família e Ancestrais";
$text['ourpages'] = "Nossas Páginas de Genealogia da Família";
$text['pwrdby'] = "Este site é gerenciado por";
$text['writby'] = "escrito por";
$text['searchtngnet'] = "Buscar em TNG Network (GENDEX)";
$text['viewphotos'] = "Ver todas fotos";
$text['anon'] = "Você está anônimo";
$text['whichbranch'] = "De que ramo você é?";
$text['featarts'] = "Artigos Detalhados";
$text['maintby'] = "Mantido por";
$text['createdon'] = "Criado em";
$text['reliability'] = "Confiabilidade";
$text['labels'] = "Rótulos";
$text['inclsrcs'] = "Incluir Fontes";
$text['cont'] = "(cont.)"; //abbreviation for continued
$text['mnuheader'] = "Página Inicial";
$text['mnusearchfornames'] = "Pesquisar Pessoa";
$text['mnulastname'] = "Sobrenome";
$text['mnufirstname'] = "Prenome";
$text['mnusearch'] = "Pesquisar";
$text['mnureset'] = "Repetir";
$text['mnulogon'] = "Entrar";
$text['mnulogout'] = "Sair";
$text['mnufeatures'] = "Outras Atividades";
$text['mnuregister'] = "Registrar-se como Usuário";
$text['mnuadvancedsearch'] = "Pesquisa Avançada";
$text['mnulastnames'] = "Sobrenomes";
$text['mnustatistics'] = "Estatística";
$text['mnuphotos'] = "Fotos";
$text['mnuhistories'] = "Histórias";
$text['mnumyancestors'] = "Fotos &amp; Histórias dos ancestrais de [Person]";
$text['mnucemeteries'] = "Cemitérios";
$text['mnutombstones'] = "Lápides";
$text['mnureports'] = "Relatórios";
$text['mnusources'] = "Fontes";
$text['mnuwhatsnew'] = "O que há de novo";
$text['mnushowlog'] = "Registro de Acessos";
$text['mnulanguage'] = "Mudar Idioma";
$text['mnuadmin'] = "Página da Administração";
$text['welcome'] = "Bem-vindo";
$text['contactus'] = "Contatar Conosco";
//changed in 8.0.0
$text['born'] = "Nascimento";
$text['searchnames'] = "Pessoas";
//added in 8.0.0
$text['editperson'] = "Editar pessoas";
$text['loadmap'] = "Carregar o mapa";
$text['birth'] = "Nascimento";
$text['wasborn'] = "nasceu em";
$text['startnum'] = "Primeiro número";
$text['searching'] = "Buscando";
//moved here in 8.0.0
$text['location'] = "Localização";
$text['association'] = "Relacionamento";
$text['collapse'] = "Diminuir representação";
$text['expand'] = "Aumentar representação";
$text['plot'] = "Sepultura";
$text['searchfams'] = "Famílias";
//added in 8.0.2
$text['wasmarried'] = "casou com";
$text['anddied'] = "faleceu em";
//added in 9.0.0
$text['share'] = "Compartilhar";
$text['hide'] = "Ocultar";
$text['disabled'] = "Sua conta de usuário foi desabilitada. Favor contatar o administrador do site para informações.";
$text['contactus_long'] = "Se você tem questões ou comentários sobre as informações contidas neste site, por favor <span class=\"emphasis\"><a href=\"suggest.php\">contate-nos</a></span>. Esperamos sua mensagem.";
$text['features'] = "Artigos";
$text['resources'] = "Recursos";
$text['latestnews'] = "Novidades";
$text['trees'] = "Árvores";
$text['wasburied'] = "sepultado em";
//moved here in 9.0.0
$text['emailagain'] = "Repita o email";
$text['enteremail2'] = "Favor entrar com seu email novamente.";
$text['emailsmatch'] = "Emails diferentes. Favor entrar com o mesmo email em ambos campos.";
$text['getdirections'] = "Clique para obter caminho";
$text['calendar'] = "Calendário";
//changed in 9.0.0
$text['directionsto'] = " para ";
$text['slidestart'] = "Apresentação";
$text['livingnote'] = "Pessoa viva ou dados privativos - detalhes ocultos por razões de privacidade";
$text['livingphoto'] = "Ao menos uma pessoa viva está ligada a esta foto - detalhes ocultos por razões de privacidade. ";
$text['waschristened'] = "batizado em";
//added in 10.0.0
$text['branches'] = "Ramos";
$text['detail'] = "Detalhe";
$text['moredetail'] = "Exibir detalhes";
$text['lessdetail'] = "Ocultar detalhes";
$text['otherevents'] = "Outros eventos";
$text['conflds'] = "Confirmação (SUD)";
$text['initlds'] = "Inicialização (SUD)";
$text['wascremated'] = "foi cremado";
//moved here in 11.0.0
$text['text_for'] = "para";
//added in 11.0.0
$text['searchsite'] = "Buscar neste sítio";
$text['searchsitemenu'] = "Busca neste sítio";
$text['kmlfile'] = "Baixe um arquivo .kml para mostrar a localização no Google Earth";
$text['download'] = "Clique para baixar";
$text['more'] = "Mais";
$text['heatmap'] = "Distribuição no mapa";
$text['refreshmap'] = "Recarregar o mapa";
$text['remnums'] = "Limpar números e ícones";
$text['photoshistories'] = "Fotografias &amp; Histórias";
$text['familychart'] = "Diagrama familiar";
//added in 12.0.0
$text['firstnames'] = "Prenomes";
//moved here in 12.0.0
$text['dna_test'] = "DNA Test";
$text['test_type'] = "Tipo de Teste";
$text['test_info'] = "Informação do Teste";
$text['takenby'] = "Indivíduo Examinado";
$text['haplogroup'] = "Haplogrupo";
$text['hvr1'] = "HVR1";
$text['hvr2'] = "HVR2";
$text['relevant_links'] = "Ligações relevantes";
$text['nofirstname'] = "[sem primeiro nome]";
//added in 12.0.1
$text['cookieuse'] = "Nota: este sítio usa cookies.";
$text['dataprotect'] = "Política de Proteção de Dados";
$text['viewpolicy'] = "Ver política";
$text['understand'] = "Eu entendo";
$text['consent'] = "Eu concedo autorização para que este sítio armazene os dados pessoais aqui fornecidos. Eu estou ciente de que posso solicitar a remoção destes dados ao proprietário do sítio, a qualquer tempo.";
$text['consentreq'] = "Por favor, dê seu consentimento para que este site armazene dados pessoais.";

//added in 12.1.0
$text['testsarelinked'] = "Testes DNA estão associdados com";
$text['testislinked'] = "Teste DNA está associado com";

//added in 12.2
$text['quicklinks'] = "Links rápidos";
$text['yourname'] = "Seu nome";
$text['youremail'] = "Seu endereço de email";
$text['liketoadd'] = "Qualquer informação que você gostaria de adicionar";
$text['webmastermsg'] = "Mensagem do webmaster";
$text['gallery'] = "Ver galeria";
$text['wasborn_male'] = "nasceu";
$text['wasborn_female'] = "nasceu";
$text['waschristened_male'] = "foi batizado";
$text['waschristened_female'] = "foi batizado";
$text['died_male'] = "morreu";
$text['died_female'] = "morreu";
$text['wasburied_male'] = "foi enterrado";
$text['wasburied_female'] = "foi enterrado";
$text['wascremated_male'] = "foi cremado";
$text['wascremated_female'] = "foi cremado";
$text['wasmarried_male'] = "casado";
$text['wasmarried_female'] = "casado";
$text['wasdivorced_male'] = "foi divorciado";
$text['wasdivorced_female'] = "foi divorciado";
$text['inplace'] = " em ";
$text['onthisdate'] = " em ";
$text['inthisyear'] = " em ";
$text['and'] = "e ";

//moved here in 12.3
$text['dna_info_head'] = "Informação do Teste de DNA";
$text['firstpage'] = "Primeira páginas";
$text['lastpage'] = "Última página";

@include_once("captcha_text.php");
@include_once("alltext.php");
if (!$alltextloaded) {
  getAllTextPath();
}
?>
<?php
switch ( $textpart ) {
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
		//added in 7.0.0
		$text['sitemaint'] = "Manutenção do site em andamento";
		$text['standby'] = "O site está temporariamente fora do ar por manutenção na base de dados. Favor tentar novamente depois de alguns minutos. Se o site permanecer fora do ar por um período mais longo, favor <a href=\"suggest.php\">contatar o proprietário do site</a>.";
		break;

	//gedcom.php, gedform.php
	case "gedcom":
		$text['gedstart'] = "GEDCOM inicia para";
		$text['producegedfrom'] = "Gerar arquivo GEDCOM contendo";
		$text['numgens'] = "Número de gerações";
		$text['includelds'] = "Incluir informações LDS";
		$text['buildged'] = "Gerar GEDCOM";
		$text['gedstartfrom'] = "GEDCOM inicia a partir de";
		$text['nomaxgen'] = "Informe o número máximo de gerações. Por favor, aperte o botão voltar e corrija o erro.";
		$text['gedcreatedfrom'] = "GEDCOM criado a partir de";
		$text['gedcreatedfor'] = "Gerado para";

		$text['enteremail'] = "Por favor, forneça um e-mail.";
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
		//added in 5.0.5
		$text['entername'] = "Por favor, entre seu nome";
		$text['entercomments'] = "Por favor, entre seus comentários";
		$text['sendmsg'] = "Enviar mensagem";
		break;

	//getextras.php, getperson.php
	case "getperson":
		$text['photoshistoriesfor'] = "Fotos e histórias para ";
		$text['indinfofor'] = "Informações individuais sobre";
		$text['reliability'] = "Confiabilidade";
		$text['pp'] = "pp.";
		$text['age'] = "Idade";
		$text['agency'] = "Órgão/repartição";
		$text['cause'] = "Causa";
		$text['suggested'] = "Alteração sugerida";
		$text['closewindow'] = "Fechar a janela";
		$text['thanks'] = "Obrigado";
		$text['received'] = "Sua sugestão foi enviada ao administrador.";
		//added in 6.0.0
		$text['association'] = "Associação";
		//added in 7.0.0
		$text['indreport'] = "Relatório Individual";
		$text['indreportfor'] = "Relatório Individual para";
		$text['general'] = "Geral";
		$text['labels'] = "Rótulos";
		$text['bkmkvis'] = "<strong>Nota:</strong> Estes marcadores são visíveis somente neste navegador, neste computador.";
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
		$text['enternamepart'] = "Forneça uma parte do nome ou do sobrenome";
		$text['pleasenamepart'] = "Por favor, forneça uma parte do nome ou do sobrenome.";
		$text['clicktoselect'] = "Clique para selecionar";
		$text['nobirthinfo'] = "Não há informação de nascimento";
		$text['relateto'] = "Parente de ";
		$text['sameperson'] = "As pessoas são as mesmas.";
		$text['notrelated'] = "As duas pessoas não têm parentesco em xxx gerações.";
		$text['findrelinstr'] = "Instruções: Forneça os IDs de duas pessoas (ou utilize as pessoas mostradas). Após clique o botão Computar para mostrar o parentesco até xxx gerações.";
		$text['gencheck'] = "Número máximo de<br />gerações a considerar";
		$text['sometimes'] = "(Às vezes, um resultado diferente pode ser obtido entrando com um número diferente de gerações.)";
		$text['findanother'] = "Encontrar outro parentesco";
		//added in 6.0.0
		$text['brother'] = "o irmão de";
		$text['sister'] = "a irmã de";
		$text['sibling'] = "o/a irmão/irmã de";
		$text['uncle'] = "o tio xxx de";
		$text['aunt'] = "a tia xxx de";
		$text['uncleaunt'] = "o/a tio/tia xxx de";
		$text['nephew'] = "o xxx sobrinho de";
		$text['niece'] = "a xxx sobrinha de";
		$text['nephnc'] = "o/a xxx sobrinho/sobrinha de";
		$text['mcousin'] = "o xxx primo de";
		$text['fcousin'] = "a xxx prima de";
		$text['cousin'] = "o xxx primo de";
		$text['removed'] = "vezes removido";
		$text['rhusband'] = "o marido de  ";
		$text['rwife'] = "a esposa de ";
		$text['rspouse'] = "o cônjuge de ";
		$text['son'] = "o filho de";
		$text['daughter'] = "a filha de";
		$text['rchild'] = "o/a filho/filha de";
		$text['sil'] = "o genro de";
		$text['dil'] = "a nora de";
		$text['sdil'] = "o/a genro/nora de";
		$text['gson'] = "o xxx neto de";
		$text['gdau'] = "a xxx neta de";
		$text['gsondau'] = "o/a xxx neto/neta de";
		$text['great'] = "grande";
		$text['spouses'] = "são cônjuges";
		$text['is'] = "é";
		//changed in 6.0.0
		$text['changeto'] = "Mudar para:";
		//added in 6.0.0
		$text['notvalid'] = "não é um ID válido de pessoa nesta base de dados. Por favor, tente novamente.";
		break;

	case "familygroup":
		$text['familygroupfor'] = "Ficha familiar para ";
		$text['ldsords'] = "Informações LDS";
		$text['baptizedlds'] = "Batizado (LDS)";
		$text['endowedlds'] = "Endowed (LDS)";
		$text['sealedplds'] = "Selado aos pais (LDS)";
		$text['sealedslds'] = "Selado ao cônjuge (in) (LDS)";
		$text['otherspouse'] = "Outros cônjuges";
		//changed in 7.0.0
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
		$text['capspouseabbr'] = "SP";
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

		$text['ahnentafel'] = "Ahnentafel (tabela de ancestrais)";
		$text['addnewfam'] = "Adicionar nova família";
		$text['editfam'] = "Alterar família";
		$text['side'] = "Página";
		$text['familyof'] = "Família de ";
		$text['paternal'] = "Lado paterno";
		$text['maternal'] = "lado materno";
		$text['gen1'] = "Próprio";
		$text['gen2'] = "Pais ";
		$text['gen3'] = "Avós 4";
		$text['gen4'] = "Bisavós 8";
		$text['gen5'] = "Trisavós 16";
		$text['gen6'] = "Tetravós 32";
		$text['gen7'] = "5º avós 64";
		$text['gen8'] = "6º avós 128";
		$text['gen9'] = "7º avós 256";
		$text['gen10'] = "8º avós 512";
		$text['gen11'] = "9º avós 1024";
		$text['gen12'] = "10º avós 2048";
		$text['graphdesc'] = "Representação gráfica dos descendentes";
		$text['collapse'] = "Diminuir representação";
		$text['expand'] = "Aumentar representação";
		$text['pedbox'] = "Completa";
		//changed in 6.0.0
		$text['regformat'] = "Formato Registro";
		$text['extrasexpl'] = "Se houver textos ou fotos para estas pessoas, ícones correspondentes aparecerão junto a seus nomes.";
		//added in 6.0.0
		$text['popupnote3'] = " = Novo gráfico";
		$text['mediaavail'] = "Mídia disponível";
		//changed in 7.0.0
		$text['pedigreefor'] = "Diagrama de Pedigree para";
		//added in 7.0.0
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
		$text['query'] = "Consulta";
		$text['errormessage'] = "Mensagem de erro";
		$text['equals'] = "igual a";
		$text['contains'] = "contém";
		$text['startswith'] = "começa com";
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
		$text['text_for'] = "para";
		$text['searchnames'] = "Busca por nome";
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
		$text['baptdate'] = "Data do batismo (LDS)";
		$text['baptplace'] = "Lugar do batismo (LDS)";
		$text['endldate'] = "Data do Endowment (LDS)";
		$text['endlplace'] = "Lugar do Endowment (LDS)";
		$text['ssealdate'] = "Data Selo S (LDS)";
		$text['ssealplace'] = "Lugar Selo S (LDS)";
		$text['psealdate'] = "Data Selo P (LDS)";
		$text['psealplace'] = "Lugar Selo P (LDS)";
		$text['marrplace'] = "Marriage Place";
		$text['spousesurname'] = "Sobrenome do cônjuge";
		//changed in 6.0.0
		$text['spousemore'] = "Se você preencher o sobrenome do cônjuge, deverá preencher ao menos um outro campo.";
		//added in 6.0.0
		$text['plusminus5'] = "+/- 5 anos de agora";
		$text['exists'] = "existe";
		$text['dnexist'] = "não existe";
		//added in 6.0.3
		$text['divdate'] = "Data de divórcio";
		$text['divplace'] = "Lugar de divórcio";
		//changed in 7.0.0
		$text['otherevents'] = "Outros Critérios de Busca";
		//added in 7.0.0
		$text['numresults'] = "Resultados por Página";
		$text['mysphoto'] = "Fotos Misteriosas";
		$text['mysperson'] = "Pessoas Elusivas";
		$text['joinor'] = "A opção 'Junção com OU' não pode ser usada com o Sobrenome da Esposa";
		//added in 7.0.1
		$text['tellus'] = "Tell us what you know";
		$text['moreinfo'] = "More Information:";
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
		$text['firstpage'] = "Primeira páginas";
		$text['lastpage'] = "Última página";
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
		//changed in 6.0.0
		$text['photosize'] = "Tamanho";
		//added in 6.0.0
        	$text['iptc010'] = "Prioridade";
		$text['filesize'] = "Tamanho do arquivo";
		$text['seeloc'] = "Ver localização";
		$text['showall'] = "Mostrar tudo";
		$text['editmedia'] = "Editar mídia";
		$text['viewitem'] = "Ver este item";
		$text['editcem'] = "Editar Cemitério";
		$text['numitems'] = "# Ítens";
		$text['allalbums'] = "Todos álbuns";
		//added in 6.1.0
		$text['slidestart'] = "Iniciar apresentação de slides";
		$text['slidestop'] = "Suspender apresentação";
		$text['slideresume'] = "Reiniciar apresentação";
		$text['slidesecs'] = "Segundos por slide:";
		$text['minussecs'] = "menos 0.5 segundos";
		$text['plussecs'] = "mais 0.5 segundos";
		//added in 7.0.0
		$text['nocountry'] = "País desconhecido";
		$text['nostate'] = "Estado desconhecido";
		$text['nocounty'] = "Condado desconhecido";
		$text['nocity'] = "Cidade desconhecida";
		$text['nocemname'] = "Nome de cemitério desconhecido";
		$text['plot'] = "Sepultura";
		$text['location'] = "Localização";
		$text['editalbum'] = "Editar Álbum";
		$text['mediamaptext'] = "<strong>Nota:</strong> Mova o ponteiro do mouse sobre a imagem para mostrar nomes. Clique para ver a página correspondente ao nome.";
		break;

	//surnames.php, surnames100.php, surnames-all.php, surnames-oneletter.php
	case "surnames":
	case "places";
		$text['surnamesstarting'] = "Mostrar sobrenomes que começam com a letra";
		$text['showtop'] = "Mostrar os primeiros ";
		$text['showallsurnames'] = "Mostrar todos sobrenomes";
		$text['sortedalpha'] = "em ordem alfabética";
		$text['byoccurrence'] = "em ordem de ocorrência";
		$text['firstchars'] = "Primeiras letras";
		$text['top'] = "Topo";
		$text['mainsurnamepage'] = "Página inicial de sobrenomes";
		$text['allsurnames'] = "Todos sobrenomes";
		$text['showmatchingsurnames'] = "Clique no sobrenome para obter mais informações";
		$text['backtotop'] = "Para o topo";
		$text['beginswith'] = "Inicia com";
		$text['allbeginningwith'] = "Todas famílias que começam com a letra";
		$text['numoccurrences'] = "número de ocorrências entre parênteses";
		$text['placesstarting'] = "Mostrar Lugares que começam com";
		$text['showmatchingplaces'] = "Clique num sobrenome para exibir registros coincidentes.";
		$text['totalnames'] = "total de nomes";
		$text['showallplaces'] = "Mostrar as localidades mais abrangentes";
		$text['totalplaces'] = "localidades";
		$text['mainplacepage'] = "Página das localidades mais abrangentes";
		$text['allplaces'] = "Todas localidades mais abrangentes";
		$text['placescont'] = "Mostar todas localidades que contém ...";
		//added in 7.0.0
		$text['top30'] = "30 sobrenomes mais freqüentes";
		$text['top30places'] = "30 maiores lugares";
		break;

	//whatsnew.php
	case "whatsnew":
		$text['pastxdays'] = "(últimos xx dias)";
		$text['historiesdocs'] = "Histórias e Documentos";
		//$text['headstones'] = "Headstones";

		$text['photo'] = "Fotografias";
		$text['history'] = "Histórias/Documentos";
		//changed in 7.0.0
		$text['husbid'] = " ID do Pai";
		$text['husbname'] = "Nome do Pai";
		$text['wifeid'] = " ID da Mãe";
		break;

	//timeline.php, timeline2.php
	case "timeline":
		$text['text_delete'] = "Excluir";
		$text['addperson'] = "Adicionar pessoa";
		$text['nobirth'] = "A pessoa que segue não tem data de nascimento (não é possível adicioná-la à linha de tempo)";
		$text['noliving'] = "A pessoa que segue está viva. Por questões de privacidade não pode ser adicionada à linha de tempo";
		$text['event'] = "Evento(s)";
		$text['chartwidth'] = "Largura do diagrama";
		//changed in 6.0.0
		$text['timelineinstr'] = "Adicione até quatro pessoas fornecendo seus IDs:";
		//added in 6.0.0
		$text['togglelines'] = "Trocar linhas";
		break;
		
	//browsetrees.php
	//login.php, newacctform.php, addnewacct.php
	case "trees":
	case "login":
		$text['browsealltrees'] = "Mostre todas árvores";
		$text['treename'] = "Nome da árvores";
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
		$text['comments'] = "Notas ou comentários";
		$text['submit'] = "Submeter";
		$text['leaveblank'] = "(deixar em branco ao solicitar nova árvore)";
		$text['required'] = "Campos obrigatórios";
		$text['enterpassword'] = "Por favor forneça uma senha.";
		$text['enterusername'] = "Por favor forneça um usuário.";
		$text['failure'] = "Usuário já utilizado. Favor voltar à página anterior usando o botão voltar de seu browser e fornecer outro usuário.";
		$text['success'] = "Obrigado. Sua solicitação de registro foi recebida corretamente. Entraremos em contato consigo.";
		$text['emailsubject'] = "Solicitação de registro de novo usuário";
		$text['emailmsg'] = "Você recebeu um pedido de registro de usuário no TNG. Por favor faça as devidas autorizações como usuário administrador do TNG. Caso concorde com o registro, por favor comunique ao solicitante através deste e-mail.";
		//changed in 5.0.0
		$text['enteremail'] = "Por favor, forneça um e-mail.";
		$text['website'] = "Página Web (endereço-WWW)";
		$text['nologin'] = "Não possui login?";
		$text['loginsent'] = "Sua informação de login foi enviada";
		$text['loginnotsent'] = "A informação de login não foi enviada";
		$text['enterrealname'] = "Favor informar o seu nome.";
		$text['rempass'] = "Permaneça logado neste computador";
		$text['morestats'] = "Mais estatísticas";
		//added in 6.0.0
		$text['accmail'] = "<strong>NOTA:</strong> Para garantir que você receba e-mail do administrador deste site relativo a sua conta, por favor, assegure-se que seu servidor de e-mail não está bloqueando mensagens desta conta.";
		$text['newpassword'] = "Nova senha";
		$text['resetpass'] = "Criar nova senha";
		//added in 6.1.0
		$text['nousers'] = "Este formulário não pode ser usado enquanto não existirem usuários registrados. Se você é o proprietários deste site, por favor crie a conta de usuários em Administração/Usuários.";
		//added in 7.0.0
		$text['noregs'] = "Desculpe, mas não estamos aceitando novos usuários no momento. Por favor <a href=\"suggest.php\">contate-nos</a> diretamente se tiver comentários ou questões sobre este site.";
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
		$text['years'] = "anos";
		$text['days'] = "dias";
		$text['age'] = "Idade";
		$text['agedisclaimer'] = "Cálculos relacionados à idade baseiam-se nas pessoas com data de nascimento e de falecimento registradas. Pelo preenchimento incompleto deste campos (por exemplo, \"1945\" ou antes de  \"BEF 1860\") este cálculos podem não ser 100% corretos.";
		$text['treedetail'] = "Mais informações sobre esta árvore";
		//added in 6.0.0
		$text['total'] = "Total";
		break;

	case "notes":
		$text['browseallnotes'] = "Percorrer todas notas";
		break;

	case "help":
		$text['menuhelp'] = "Significado dos ícones no menu";
		break;

	case "install":
		$text['perms'] = "Permissions have all been set.";
		$text['noperms'] = "Permissions could not be set for these files:";
		$text['manual'] = "Please set them manually.";
		$text['folder'] = "Folder";
		$text['created'] = "has been created";
		$text['nocreate'] = "could not be created. Please create it manually.";
		$text['infosaved'] = "Information saved, connection verified!";
		$text['tablescr'] = "The tables have been created!";
		$text['notables'] = "The following tables could not be created:";
		$text['nocomm'] = "TNG is not communicating with your database. No tables were created.";
		$text['newdb'] = "Information saved, connection verified, new database created:";
		$text['noattach'] = "Information saved. Connection made and database created, but TNG cannot attach to it.";
		$text['nodb'] = "Information saved. Connection made, but database does not exist and could not be created here. Please verify that the database name is correct, or use your control panel to create it.";
		$text['noconn'] = "Information saved but connection failed. One or more of the following is incorrect:";
		$text['exists'] = "existe";
		$text['loginfirst'] = "You must log in first.";
		$text['noop'] = "No operation was performed.";
		break;
}

//common
$text['matches'] = "Resultados";
$text['description'] = "Descrição";
$text['notes'] = "Notas";
$text['status'] = "Status";
$text['newsearch'] = "Nova consulta";
$text['pedigree'] = "Árvore genealógica";
$text['birthabbr'] = "Nasc.";
$text['chrabbr'] = "Bat.";
$text['seephoto'] = "Veja foto";
$text['andlocation'] = "& localidade";
$text['accessedby'] = "acessado por";
$text['go'] = "Executar";
$text['family'] = "Família";
$text['children'] = "Filhos(as)";
$text['tree'] = "Árvore";
$text['alltrees'] = "Todas árvores";
$text['nosurname'] = "[no surname]";
$text['thumb'] = "Miniatura";
$text['people'] = "Pessoas";
$text['title'] = "Título";
$text['suffix'] = "Sufixo";
$text['nickname'] = "Apelido";
$text['deathabbr'] = "fal.";
$text['lastmodified'] = "Última alteração";
$text['married'] = "Casado(a)";
//$text['photos'] = "Photos";
$text['name'] = "Nome";
$text['lastfirst'] = "Sobrenome, nome(s)";
$text['bornchr'] = "Nascimento/Batismo";
$text['individuals'] = "Pessoas";
$text['families'] = "Families";
$text['personid'] = "ID da pessoa";
$text['sources'] = "Fontes";
$text['unknown'] = "desconhecido";
$text['father'] = "Pai";
$text['mother'] = "Mãe";
$text['born'] = "Nascimento";
$text['christened'] = "Batismo";
$text['died'] = "Falecimento";
$text['buried'] = "Sepultamento";
$text['spouse'] = "Cônjuge";
$text['parents'] = "Pais";
$text['text'] = "Texto";
$text['language'] = "Língua";
$text['burialabbr'] = "sep.";
$text['descendchart'] = "Descendentes";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Pessoa";
$text['edit'] = "Editar";
$text['date'] = "Data";
$text['place'] = "Lugar";
$text['login'] = "Log-in";
$text['logout'] = "Log-out";
$text['marrabbr'] = "Cas.";
$text['groupsheet'] = "Ficha familiar";
$text['text_and'] = "e";
$text['generation'] = "Geração";
$text['filename'] = "Nome de arquivo";
$text['id'] = "ID";
$text['search'] = "Busca";
$text['living'] = "Vivo";
$text['user'] = "Usuário";
$text['firstname'] = "Nome";
$text['lastname'] = "Sobrenome";
$text['searchresults'] = "Resultado da busca";
$text['diedburied'] = "Falecido";
$text['homepage'] = "Início";
$text['find'] = "Buscar...";
$text['relationship'] = "Parentesco";
$text['relationship2'] = "Relationship";
$text['timeline'] = "Linha de tempo";
$text['yesabbr'] = "S";
$text['divorced'] = "Separado";
$text['indlinked'] = "Ligado a";
$text['branch'] = "Ramo";
$text['moreind'] = "Mais pessoas";
$text['morefam'] = "Mais famílias";
$text['livingdoc'] = "Ao menos uma pessoa viva está ligada a esta história - detalhes ocultos por razões de privacidade.";
$text['source'] = "Fonte";
$text['surnamelist'] = "Lista de sobrenomes";
$text['generations'] = "Gerações";
$text['refresh'] = "Atualizar";
$text['whatsnew'] = "Novidades";
$text['reports'] = "Relatório";
$text['placelist'] = "Lista de localidades";
$text['baptizedlds'] = "Batizado (LDS)";
$text['endowedlds'] = "Endowed (LDS)";
$text['sealedplds'] = "Selado aos pais (LDS)";
$text['sealedslds'] = "Selado ao cônjuge (in) (LDS)";
//$text['photoshistories'] = "Photos &amp; Histories";
$text['ancestors'] = "Ancestrais";
$text['descendants'] = "Descendentes";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Data da última importação de GEDCOM";
$text['type'] = "Tipo";
$text['savechanges'] = "Salvar";
$text['familyid'] = "ID da família";
$text['headstone'] = "Lápides";
$text['historiesdocs'] = "Histórias e Documentos";
$text['livingnote'] = "Pessoa viva - detalhes ocultos por razões de privacidade";
$text['anonymous'] = "anônimo";
$text['places'] = "Localidades";
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
//changed in 6.0.0
$text['livingphoto'] = "Ao menos uma pessoa viva está ligada a esta foto - detalhes ocultos por razões de privacidade. ";
$text['databasestatistics'] = "Estatística da base de dados";
//moved here in 6.0.0
$text['child'] = "Filho(a)";
$text['repoinfo'] = "Informação do local de arquivamento";
$text['tng_reset'] = "Limpar";
$text['noresults'] = "Resultado vazio";
//added in 6.0.0
$text['allmedia'] = "Toda mídia";
$text['repositories'] = "Repositórios";
$text['albums'] = "Álbuns";
$text['cemeteries'] = "Cemitérios";
$text['surnames'] = "Sobrenomes";
$text['dates'] = "Datas";
$text['link'] = "Link";
$text['media'] = "Mídia";
$text['gender'] = "Gênero";
$text['latitude'] = "Latitude";
$text['longitude'] = "Longitude";
$text['bookmarks'] = "Marcadores";
$text['bookmark'] = "Adicionar marcadores";
$text['mngbookmarks'] = "Ir para Marcadores";
$text['bookmarked'] = "Marcador Adicionado";
$text['remove'] = "Remover";
$text['find_menu'] = "Encontrar";
$text['info'] = "Info";
//moved here in 6.0.3
$text['cemetery'] = "Cemitérios";
//added in 6.1.0
//Google Maps messages
$text['gmapevent'] = "Mapa de eventos";
$text['gevents'] = "Evento";
$text['glang'] = "&amp;hl=pt-BR";
$text['googleearthlink'] = "Link para Google Earth";
$text['googlemaplink'] = "Link para Google Maps";
$text['gmaplegend'] = "Legenda de marcadores";
//moved here in 7.0.0
$text['unmarked'] = "Não marcado";
$text['located'] = "Localizado";
//added in 7.0.0
$text['albclicksee'] = "Clicar para ver todos itens do álbum";
$text['notyetlocated'] = "Ainda não localizado";
$text['cremated'] = "Cremado";
$text['missing'] = "Faltando";
$text['page'] = "Página";
$text['pdfgen'] = "Gerador de PDF";
$text['blank'] = "Diagrama Vazio";
$text['none'] = "Nenhum";
$text['fonts'] = "Fontes";
$text['header'] = "Cabeçalho";
$text['data'] = "Data";
$text['pgsetup'] = "Configuração";
$text['pgsize'] = "Tamanho da Folha";
$text['letter'] = "Carta";
$text['legal'] = "Ofício";
$text['orient'] = "Orientação";
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

//for home page, from Nuke Add-on, added here in 5.0.0
$text['mnuheader'] = "Página Inicial";
$text['mnusearchfornames'] = "Pesquisar Pessoa";
$text['mnulastname'] = "Sobrenome";
$text['mnufirstname'] = "Nome";
$text['mnusearch'] = "Pesquisar";
$text['mnureset'] = "Repetir";
$text['mnulogon'] = "Log In";
$text['mnulogout'] = "Log Out";
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

global $rootpath;
@include_once("captcha_text.php");
if($rootpath) {
	$thislanguage = $mylanguage ? $mylanguage : $language;
	if($cms[support])
		include_once("$rootpath$cms[tngpath]$thislanguage/alltext.php");
	else
		include_once("$rootpath$thislanguage/alltext.php");
}
else
	include_once("alltext.php");
?>

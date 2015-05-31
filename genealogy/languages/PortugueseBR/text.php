<?php
switch ( $textpart ) {
	//browsesources.php, showsource.php
	case "sources":
		$text['browseallsources'] = "Mostrar todas fontes";
		$text['shorttitle'] = "T�tulo abreviado";
		$text['callnum'] = "N�mero de registro";
		$text['author'] = "Autor(a)";
		$text['publisher'] = "Publicado por";
		$text['other'] = "Informa��es adicionais";
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
		$text['sitemaint'] = "Manuten��o do site em andamento";
		$text['standby'] = "O site est� temporariamente fora do ar por manuten��o na base de dados. Favor tentar novamente depois de alguns minutos. Se o site permanecer fora do ar por um per�odo mais longo, favor <a href=\"suggest.php\">contatar o propriet�rio do site</a>.";
		break;

	//gedcom.php, gedform.php
	case "gedcom":
		$text['gedstart'] = "GEDCOM inicia para";
		$text['producegedfrom'] = "Gerar arquivo GEDCOM contendo";
		$text['numgens'] = "N�mero de gera��es";
		$text['includelds'] = "Incluir informa��es LDS";
		$text['buildged'] = "Gerar GEDCOM";
		$text['gedstartfrom'] = "GEDCOM inicia a partir de";
		$text['nomaxgen'] = "Informe o n�mero m�ximo de gera��es. Por favor, aperte o bot�o voltar e corrija o erro.";
		$text['gedcreatedfrom'] = "GEDCOM criado a partir de";
		$text['gedcreatedfor'] = "Gerado para";

		$text['enteremail'] = "Por favor, forne�a um e-mail.";
		$text['creategedfor'] = "Gerar arquivo GEDCOM para";
		$text['email'] = "E-mail";
		$text['suggestchange'] = "Sugest�o de altera��o para";
		$text['yourname'] = "Seu nome";
		$text['comments'] = "Notas ou coment�rios";
		$text['comments2'] = "Coment�rios";
		$text['submitsugg'] = "Submeter a sugest�o";
		$text['proposed'] = "Altera��o proposta";
		$text['mailsent'] = "Obrigado. Sua mensagem foi enviada.";
		$text['mailnotsent'] = "Sua mensagem n�o pode ser enviada. Favor contatar xxx diretamente atrav�s do e-mail yyy.";
		$text['mailme'] = "Enviar uma c�pia a este endere�o";
		//added in 5.0.5
		$text['entername'] = "Por favor, entre seu nome";
		$text['entercomments'] = "Por favor, entre seus coment�rios";
		$text['sendmsg'] = "Enviar mensagem";
		break;

	//getextras.php, getperson.php
	case "getperson":
		$text['photoshistoriesfor'] = "Fotos e hist�rias para ";
		$text['indinfofor'] = "Informa��es individuais sobre";
		$text['reliability'] = "Confiabilidade";
		$text['pp'] = "pp.";
		$text['age'] = "Idade";
		$text['agency'] = "�rg�o/reparti��o";
		$text['cause'] = "Causa";
		$text['suggested'] = "Altera��o sugerida";
		$text['closewindow'] = "Fechar a janela";
		$text['thanks'] = "Obrigado";
		$text['received'] = "Sua sugest�o foi enviada ao administrador.";
		//added in 6.0.0
		$text['association'] = "Associa��o";
		//added in 7.0.0
		$text['indreport'] = "Relat�rio Individual";
		$text['indreportfor'] = "Relat�rio Individual para";
		$text['general'] = "Geral";
		$text['labels'] = "R�tulos";
		$text['bkmkvis'] = "<strong>Nota:</strong> Estes marcadores s�o vis�veis somente neste navegador, neste computador.";
		break;

	//relateform.php, relationship.php, findpersonform.php, findperson.php
	case "relate":
		$text['relcalc'] = "Computar rela��es de parentesco";
		$text['findrel'] = "Encontrar parentesco";
		$text['person1'] = "Pessoa 1:";
		$text['person2'] = "Pessoa 2:";
		$text['calculate'] = "Computar";
		$text['select2inds'] = "Favor escolher duas pessoas.";
		$text['findpersonid'] = "Encontrar ID de pessoa";
		$text['enternamepart'] = "Forne�a uma parte do nome ou do sobrenome";
		$text['pleasenamepart'] = "Por favor, forne�a uma parte do nome ou do sobrenome.";
		$text['clicktoselect'] = "Clique para selecionar";
		$text['nobirthinfo'] = "N�o h� informa��o de nascimento";
		$text['relateto'] = "Parente de ";
		$text['sameperson'] = "As pessoas s�o as mesmas.";
		$text['notrelated'] = "As duas pessoas n�o t�m parentesco em xxx gera��es.";
		$text['findrelinstr'] = "Instru��es: Forne�a os IDs de duas pessoas (ou utilize as pessoas mostradas). Ap�s clique o bot�o Computar para mostrar o parentesco at� xxx gera��es.";
		$text['gencheck'] = "N�mero m�ximo de<br />gera��es a considerar";
		$text['sometimes'] = "(�s vezes, um resultado diferente pode ser obtido entrando com um n�mero diferente de gera��es.)";
		$text['findanother'] = "Encontrar outro parentesco";
		//added in 6.0.0
		$text['brother'] = "o irm�o de";
		$text['sister'] = "a irm� de";
		$text['sibling'] = "o/a irm�o/irm� de";
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
		$text['rspouse'] = "o c�njuge de ";
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
		$text['spouses'] = "s�o c�njuges";
		$text['is'] = "�";
		//changed in 6.0.0
		$text['changeto'] = "Mudar para:";
		//added in 6.0.0
		$text['notvalid'] = "n�o � um ID v�lido de pessoa nesta base de dados. Por favor, tente novamente.";
		break;

	case "familygroup":
		$text['familygroupfor'] = "Ficha familiar para ";
		$text['ldsords'] = "Informa��es LDS";
		$text['baptizedlds'] = "Batizado (LDS)";
		$text['endowedlds'] = "Endowed (LDS)";
		$text['sealedplds'] = "Selado aos pais (LDS)";
		$text['sealedslds'] = "Selado ao c�njuge (in) (LDS)";
		$text['otherspouse'] = "Outros c�njuges";
		//changed in 7.0.0
		$text['husband'] = "Pai";
		$text['wife'] = "M�e";
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
		$text['scrollnote'] = "Observa��o: talvez seja necess�rio rolar para a direita ou para baixo para visualizar todo o diagrama.";
		$text['unknownlit'] = "Desconhecido";
		$text['popupnote1'] = " = Informa��o adicional";
		$text['popupnote2'] = " = Nova �rvore";
		$text['pedcompact'] = "Compacta";
		$text['pedstandard'] = "Padr�o";
		$text['pedtextonly'] = "Textual";
		$text['descendfor'] = "Descendentes de ";
		$text['maxof'] = "Mostrar no m�ximo";
		$text['gensatonce'] = "gera��es.";
		$text['sonof'] = "Filho de ";
		$text['daughterof'] = "Filha de ";
		$text['childof'] = "Filho(a) de ";
		$text['stdformat'] = "Formato padr�o";

		$text['ahnentafel'] = "Ahnentafel (tabela de ancestrais)";
		$text['addnewfam'] = "Adicionar nova fam�lia";
		$text['editfam'] = "Alterar fam�lia";
		$text['side'] = "P�gina";
		$text['familyof'] = "Fam�lia de ";
		$text['paternal'] = "Lado paterno";
		$text['maternal'] = "lado materno";
		$text['gen1'] = "Pr�prio";
		$text['gen2'] = "Pais ";
		$text['gen3'] = "Av�s 4";
		$text['gen4'] = "Bisav�s 8";
		$text['gen5'] = "Trisav�s 16";
		$text['gen6'] = "Tetrav�s 32";
		$text['gen7'] = "5� av�s 64";
		$text['gen8'] = "6� av�s 128";
		$text['gen9'] = "7� av�s 256";
		$text['gen10'] = "8� av�s 512";
		$text['gen11'] = "9� av�s 1024";
		$text['gen12'] = "10� av�s 2048";
		$text['graphdesc'] = "Representa��o gr�fica dos descendentes";
		$text['collapse'] = "Diminuir representa��o";
		$text['expand'] = "Aumentar representa��o";
		$text['pedbox'] = "Completa";
		//changed in 6.0.0
		$text['regformat'] = "Formato Registro";
		$text['extrasexpl'] = "Se houver textos ou fotos para estas pessoas, �cones correspondentes aparecer�o junto a seus nomes.";
		//added in 6.0.0
		$text['popupnote3'] = " = Novo gr�fico";
		$text['mediaavail'] = "M�dia dispon�vel";
		//changed in 7.0.0
		$text['pedigreefor'] = "Diagrama de Pedigree para";
		//added in 7.0.0
		$text['pedigreech'] = "Diagrama de  Pedigree";
		$text['datesloc'] = "Datas e Lugares";
		$text['borchr'] = "Nasc/Bat � Falec/Sepult (dois)";
		$text['nobd'] = "Sem datas de nascimento ou falecimento";
		$text['bcdb'] = " Nasc/Bat/Falec/Sepult (quatro)";
		$text['numsys'] = "Sistema de numera��o";
		$text['gennums'] = "N�meros de Gera��o";
		$text['henrynums'] = "N�meros Henry";
		$text['abovnums'] = " N�meros d'Aboville";
		$text['devnums'] = " N�meros de Villiers";
		$text['dispopts'] = "Op��es de Exibi��o";
		break;

	//search.php, searchform.php
	//merged with reports and showreport in 5.0.0
	case "search":
	case "reports":
		$text['noreports'] = "N�o h� relat�rios.";
		$text['reportname'] = "Nome do relat�rio";
		$text['allreports'] = "Todos relat�rios";
		$text['report'] = "Relat�rio";
		$text['error'] = "Erro";
		$text['reportsyntax'] = "A sintaxe da consulta referente a este relat�rio �";
		$text['wasincorrect'] = "inv�lida. O relat�rio n�o pode ser criado. Por favor, comunique ao respons�vel pelo sistema";
		$text['query'] = "Consulta";
		$text['errormessage'] = "Mensagem de erro";
		$text['equals'] = "igual a";
		$text['contains'] = "cont�m";
		$text['startswith'] = "come�a com";
		$text['endswith'] = "termina com";
		$text['soundexof'] = "soundex de";
		$text['metaphoneof'] = "metafon de";
		$text['plusminus10'] = "+/- 10 anos de";
		$text['lessthan'] = "menor que";
		$text['greaterthan'] = "maior que";
		$text['lessthanequal'] = "menor ou igual a";
		$text['greaterthanequal'] = "maior ou igual a";
		$text['equalto'] = "� igual";
		$text['tryagain'] = "Favor tentar novamente";
		$text['text_for'] = "para";
		$text['searchnames'] = "Busca por nome";
		$text['joinwith'] = "Conectivo l�gico";
		$text['cap_and'] = "E";
		$text['cap_or'] = "OU";
		$text['showspouse'] = "Mostre c�njuge; em caso de v�rios c�njuges, ser�o mostradas duplicatas";
		$text['submitquery'] = "Buscar";
		$text['birthplace'] = "Lugar de nascimento";
		$text['deathplace'] = "Lugar de falecimento";
		$text['birthdatetr'] = "Ano de nascimento";
		$text['deathdatetr'] = "Ano de falecimento";
		$text['plusminus2'] = "+/- 2 anos";
		$text['resetall'] = "Limpar todos valores";

		$text['showdeath'] = "Mostrar informa��es de falecimento/sepultamento";
		$text['altbirthplace'] = "Lugar do batismo";
		$text['altbirthdatetr'] = "Ano do batismo";
		$text['burialplace'] = "Lugar do sepultamento";
		$text['burialdatetr'] = "Ano de sepultamento";
		$text['event'] = "Evento(s)";
		$text['day'] = "Dia";
		$text['month'] = "M�s";
		$text['keyword'] = "Palavra chave (p.ex.: \"ABT\", \"BEF\", \"AFT\")";
		$text['explain'] = "Escrever data (ou parte dela) para obter eventos correspondentes. Deixar em branco para obter todas.";
		$text['enterdate'] = "Favor fornecer ou selecionar ao menos: dia, m�s, ano ou palavra chave";
		$text['fullname'] = "Nome completo";
		$text['birthdate'] = "Data do nascimento";
		$text['altbirthdate'] = "Data do batismo";
		$text['marrdate'] = "Data do casamento";
		$text['spouseid'] = "ID do c�njuge";
		$text['spousename'] = "Nome do c�njuge";
		$text['deathdate'] = "Data do falecimento";
		$text['burialdate'] = "Data do sepultamento";
		$text['changedate'] = "Data da �ltima altera��o";
		$text['gedcom'] = "�rvore";
		$text['baptdate'] = "Data do batismo (LDS)";
		$text['baptplace'] = "Lugar do batismo (LDS)";
		$text['endldate'] = "Data do Endowment (LDS)";
		$text['endlplace'] = "Lugar do Endowment (LDS)";
		$text['ssealdate'] = "Data Selo S (LDS)";
		$text['ssealplace'] = "Lugar Selo S (LDS)";
		$text['psealdate'] = "Data Selo P (LDS)";
		$text['psealplace'] = "Lugar Selo P (LDS)";
		$text['marrplace'] = "Marriage Place";
		$text['spousesurname'] = "Sobrenome do c�njuge";
		//changed in 6.0.0
		$text['spousemore'] = "Se voc� preencher o sobrenome do c�njuge, dever� preencher ao menos um outro campo.";
		//added in 6.0.0
		$text['plusminus5'] = "+/- 5 anos de agora";
		$text['exists'] = "existe";
		$text['dnexist'] = "n�o existe";
		//added in 6.0.3
		$text['divdate'] = "Data de div�rcio";
		$text['divplace'] = "Lugar de div�rcio";
		//changed in 7.0.0
		$text['otherevents'] = "Outros Crit�rios de Busca";
		//added in 7.0.0
		$text['numresults'] = "Resultados por P�gina";
		$text['mysphoto'] = "Fotos Misteriosas";
		$text['mysperson'] = "Pessoas Elusivas";
		$text['joinor'] = "A op��o 'Jun��o com OU' n�o pode ser usada com o Sobrenome da Esposa";
		//added in 7.0.1
		$text['tellus'] = "Tell us what you know";
		$text['moreinfo'] = "More Information:";
		break;

	//showlog.php
	case "showlog":
		$text['logfilefor'] = "Arquivo de log para";
		$text['mostrecentactions'] = "a��es mais recentes";
		$text['autorefresh'] = "atualiza��o autom�tica (a cada 30 segundos)";
		$text['refreshoff'] = "desligar a atualiza��o autom�tica";
		break;

	case "headstones":
	case "showphoto":
		$text['cemeteriesheadstones'] = "Cemit�rios e L�pides";
		$text['showallhsr'] = "Mostrar todas l�pides";
		$text['in'] = "em";
		$text['showmap'] = "Mostrar mapa";
		$text['headstonefor'] = "L�pide de";
		$text['photoof'] = "Fotografia de  ";
		$text['firstpage'] = "Primeira p�ginas";
		$text['lastpage'] = "�ltima p�gina";
		$text['photoowner'] = "Propriet�rio/fonte";

		$text['nocemetery'] = "Sem cemit�rio";
		$text['iptc005'] = "T�tulo";
		$text['iptc020'] = "Categorias adicionais";
		$text['iptc040'] = "Instru��es especiais";
		$text['iptc055'] = "Data de cria��o";
		$text['iptc080'] = "Autor";
		$text['iptc085'] = "Fun��o do autor";
		$text['iptc090'] = "Cidade";
		$text['iptc095'] = "Estado";
		$text['iptc101'] = "Pa�s";
		$text['iptc103'] = "OTR";
		$text['iptc105'] = "Cabe�alho";
		$text['iptc110'] = "Fonte";
		$text['iptc115'] = "Fonte des Fotografias";
		$text['iptc116'] = "Direitos autorais";
		$text['iptc120'] = "Legenda";
		$text['iptc122'] = "Autor da legenda";
		$text['mapof'] = "Mapa de ";
		$text['regphotos'] = "Vis�o com miniaturas e texto";
		$text['gallery'] = "Somente miniaturas";
		$text['cemphotos'] = "Fotos de cemit�rios";
		//changed in 6.0.0
		$text['photosize'] = "Tamanho";
		//added in 6.0.0
        	$text['iptc010'] = "Prioridade";
		$text['filesize'] = "Tamanho do arquivo";
		$text['seeloc'] = "Ver localiza��o";
		$text['showall'] = "Mostrar tudo";
		$text['editmedia'] = "Editar m�dia";
		$text['viewitem'] = "Ver este item";
		$text['editcem'] = "Editar Cemit�rio";
		$text['numitems'] = "# �tens";
		$text['allalbums'] = "Todos �lbuns";
		//added in 6.1.0
		$text['slidestart'] = "Iniciar apresenta��o de slides";
		$text['slidestop'] = "Suspender apresenta��o";
		$text['slideresume'] = "Reiniciar apresenta��o";
		$text['slidesecs'] = "Segundos por slide:";
		$text['minussecs'] = "menos 0.5 segundos";
		$text['plussecs'] = "mais 0.5 segundos";
		//added in 7.0.0
		$text['nocountry'] = "Pa�s desconhecido";
		$text['nostate'] = "Estado desconhecido";
		$text['nocounty'] = "Condado desconhecido";
		$text['nocity'] = "Cidade desconhecida";
		$text['nocemname'] = "Nome de cemit�rio desconhecido";
		$text['plot'] = "Sepultura";
		$text['location'] = "Localiza��o";
		$text['editalbum'] = "Editar �lbum";
		$text['mediamaptext'] = "<strong>Nota:</strong> Mova o ponteiro do mouse sobre a imagem para mostrar nomes. Clique para ver a p�gina correspondente ao nome.";
		break;

	//surnames.php, surnames100.php, surnames-all.php, surnames-oneletter.php
	case "surnames":
	case "places";
		$text['surnamesstarting'] = "Mostrar sobrenomes que come�am com a letra";
		$text['showtop'] = "Mostrar os primeiros ";
		$text['showallsurnames'] = "Mostrar todos sobrenomes";
		$text['sortedalpha'] = "em ordem alfab�tica";
		$text['byoccurrence'] = "em ordem de ocorr�ncia";
		$text['firstchars'] = "Primeiras letras";
		$text['top'] = "Topo";
		$text['mainsurnamepage'] = "P�gina inicial de sobrenomes";
		$text['allsurnames'] = "Todos sobrenomes";
		$text['showmatchingsurnames'] = "Clique no sobrenome para obter mais informa��es";
		$text['backtotop'] = "Para o topo";
		$text['beginswith'] = "Inicia com";
		$text['allbeginningwith'] = "Todas fam�lias que come�am com a letra";
		$text['numoccurrences'] = "n�mero de ocorr�ncias entre par�nteses";
		$text['placesstarting'] = "Mostrar Lugares que come�am com";
		$text['showmatchingplaces'] = "Clique num sobrenome para exibir registros coincidentes.";
		$text['totalnames'] = "total de nomes";
		$text['showallplaces'] = "Mostrar as localidades mais abrangentes";
		$text['totalplaces'] = "localidades";
		$text['mainplacepage'] = "P�gina das localidades mais abrangentes";
		$text['allplaces'] = "Todas localidades mais abrangentes";
		$text['placescont'] = "Mostar todas localidades que cont�m ...";
		//added in 7.0.0
		$text['top30'] = "30 sobrenomes mais freq�entes";
		$text['top30places'] = "30 maiores lugares";
		break;

	//whatsnew.php
	case "whatsnew":
		$text['pastxdays'] = "(�ltimos xx dias)";
		$text['historiesdocs'] = "Hist�rias e Documentos";
		//$text['headstones'] = "Headstones";

		$text['photo'] = "Fotografias";
		$text['history'] = "Hist�rias/Documentos";
		//changed in 7.0.0
		$text['husbid'] = " ID do Pai";
		$text['husbname'] = "Nome do Pai";
		$text['wifeid'] = " ID da M�e";
		break;

	//timeline.php, timeline2.php
	case "timeline":
		$text['text_delete'] = "Excluir";
		$text['addperson'] = "Adicionar pessoa";
		$text['nobirth'] = "A pessoa que segue n�o tem data de nascimento (n�o � poss�vel adicion�-la � linha de tempo)";
		$text['noliving'] = "A pessoa que segue est� viva. Por quest�es de privacidade n�o pode ser adicionada � linha de tempo";
		$text['event'] = "Evento(s)";
		$text['chartwidth'] = "Largura do diagrama";
		//changed in 6.0.0
		$text['timelineinstr'] = "Adicione at� quatro pessoas fornecendo seus IDs:";
		//added in 6.0.0
		$text['togglelines'] = "Trocar linhas";
		break;
		
	//browsetrees.php
	//login.php, newacctform.php, addnewacct.php
	case "trees":
	case "login":
		$text['browsealltrees'] = "Mostre todas �rvores";
		$text['treename'] = "Nome da �rvores";
		$text['owner'] = "Propriet�rio";
		$text['address'] = "Endere�o";
		$text['city'] = "Cidade";
		$text['state'] = "Estado";
		$text['zip'] = "CEP";
		$text['country'] = "Pa�s";
		$text['email'] = "E-mail";
		$text['phone'] = "Telefone";
		$text['username'] = "Usu�rio";
		$text['password'] = "Senha";
		$text['loginfailed'] = "O login falhou.";

		$text['regnewacct'] = "Solicitar registro como usu�rio";
		$text['realname'] = "Nome do usu�rio";
		$text['phone'] = "Telefone";
		$text['email'] = "E-mail";
		$text['address'] = "Endere�o";
		$text['comments'] = "Notas ou coment�rios";
		$text['submit'] = "Submeter";
		$text['leaveblank'] = "(deixar em branco ao solicitar nova �rvore)";
		$text['required'] = "Campos obrigat�rios";
		$text['enterpassword'] = "Por favor forne�a uma senha.";
		$text['enterusername'] = "Por favor forne�a um usu�rio.";
		$text['failure'] = "Usu�rio j� utilizado. Favor voltar � p�gina anterior usando o bot�o voltar de seu browser e fornecer outro usu�rio.";
		$text['success'] = "Obrigado. Sua solicita��o de registro foi recebida corretamente. Entraremos em contato consigo.";
		$text['emailsubject'] = "Solicita��o de registro de novo usu�rio";
		$text['emailmsg'] = "Voc� recebeu um pedido de registro de usu�rio no TNG. Por favor fa�a as devidas autoriza��es como usu�rio administrador do TNG. Caso concorde com o registro, por favor comunique ao solicitante atrav�s deste e-mail.";
		//changed in 5.0.0
		$text['enteremail'] = "Por favor, forne�a um e-mail.";
		$text['website'] = "P�gina Web (endere�o-WWW)";
		$text['nologin'] = "N�o possui login?";
		$text['loginsent'] = "Sua informa��o de login foi enviada";
		$text['loginnotsent'] = "A informa��o de login n�o foi enviada";
		$text['enterrealname'] = "Favor informar o seu nome.";
		$text['rempass'] = "Permane�a logado neste computador";
		$text['morestats'] = "Mais estat�sticas";
		//added in 6.0.0
		$text['accmail'] = "<strong>NOTA:</strong> Para garantir que voc� receba e-mail do administrador deste site relativo a sua conta, por favor, assegure-se que seu servidor de e-mail n�o est� bloqueando mensagens desta conta.";
		$text['newpassword'] = "Nova senha";
		$text['resetpass'] = "Criar nova senha";
		//added in 6.1.0
		$text['nousers'] = "Este formul�rio n�o pode ser usado enquanto n�o existirem usu�rios registrados. Se voc� � o propriet�rios deste site, por favor crie a conta de usu�rios em Administra��o/Usu�rios.";
		//added in 7.0.0
		$text['noregs'] = "Desculpe, mas n�o estamos aceitando novos usu�rios no momento. Por favor <a href=\"suggest.php\">contate-nos</a> diretamente se tiver coment�rios ou quest�es sobre este site.";
		break;

	//statistics.php
	case "stats":
		$text['quantity'] = "Quantidade";
		$text['totindividuals'] = "Pessoas em geral";
		$text['totmales'] = "Homens";
		$text['totfemales'] = "Mulheres";
		$text['totunknown'] = "Sexo indeterminado";
		$text['totliving'] = "Vivos";
		$text['totfamilies'] = "Fam�lias";
		$text['totuniquesn'] = "Nomes diferentes";
		//$text['totphotos'] = "Total Photos";
		//$text['totdocs'] = "Total Histories &amp; Documents";
		//$text['totheadstones'] = "Total Headstones";
		$text['totsources'] = "Fontes";
		$text['avglifespan'] = "Tempo m�dia de vida";
		$text['earliestbirth'] = "Nascimento mais antigo";
		$text['longestlived'] = "Mais longevo";
		$text['years'] = "anos";
		$text['days'] = "dias";
		$text['age'] = "Idade";
		$text['agedisclaimer'] = "C�lculos relacionados � idade baseiam-se nas pessoas com data de nascimento e de falecimento registradas. Pelo preenchimento incompleto deste campos (por exemplo, \"1945\" ou antes de  \"BEF 1860\") este c�lculos podem n�o ser 100% corretos.";
		$text['treedetail'] = "Mais informa��es sobre esta �rvore";
		//added in 6.0.0
		$text['total'] = "Total";
		break;

	case "notes":
		$text['browseallnotes'] = "Percorrer todas notas";
		break;

	case "help":
		$text['menuhelp'] = "Significado dos �cones no menu";
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
$text['description'] = "Descri��o";
$text['notes'] = "Notas";
$text['status'] = "Status";
$text['newsearch'] = "Nova consulta";
$text['pedigree'] = "�rvore geneal�gica";
$text['birthabbr'] = "Nasc.";
$text['chrabbr'] = "Bat.";
$text['seephoto'] = "Veja foto";
$text['andlocation'] = "& localidade";
$text['accessedby'] = "acessado por";
$text['go'] = "Executar";
$text['family'] = "Fam�lia";
$text['children'] = "Filhos(as)";
$text['tree'] = "�rvore";
$text['alltrees'] = "Todas �rvores";
$text['nosurname'] = "[no surname]";
$text['thumb'] = "Miniatura";
$text['people'] = "Pessoas";
$text['title'] = "T�tulo";
$text['suffix'] = "Sufixo";
$text['nickname'] = "Apelido";
$text['deathabbr'] = "fal.";
$text['lastmodified'] = "�ltima altera��o";
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
$text['mother'] = "M�e";
$text['born'] = "Nascimento";
$text['christened'] = "Batismo";
$text['died'] = "Falecimento";
$text['buried'] = "Sepultamento";
$text['spouse'] = "C�njuge";
$text['parents'] = "Pais";
$text['text'] = "Texto";
$text['language'] = "L�ngua";
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
$text['generation'] = "Gera��o";
$text['filename'] = "Nome de arquivo";
$text['id'] = "ID";
$text['search'] = "Busca";
$text['living'] = "Vivo";
$text['user'] = "Usu�rio";
$text['firstname'] = "Nome";
$text['lastname'] = "Sobrenome";
$text['searchresults'] = "Resultado da busca";
$text['diedburied'] = "Falecido";
$text['homepage'] = "In�cio";
$text['find'] = "Buscar...";
$text['relationship'] = "Parentesco";
$text['relationship2'] = "Relationship";
$text['timeline'] = "Linha de tempo";
$text['yesabbr'] = "S";
$text['divorced'] = "Separado";
$text['indlinked'] = "Ligado a";
$text['branch'] = "Ramo";
$text['moreind'] = "Mais pessoas";
$text['morefam'] = "Mais fam�lias";
$text['livingdoc'] = "Ao menos uma pessoa viva est� ligada a esta hist�ria - detalhes ocultos por raz�es de privacidade.";
$text['source'] = "Fonte";
$text['surnamelist'] = "Lista de sobrenomes";
$text['generations'] = "Gera��es";
$text['refresh'] = "Atualizar";
$text['whatsnew'] = "Novidades";
$text['reports'] = "Relat�rio";
$text['placelist'] = "Lista de localidades";
$text['baptizedlds'] = "Batizado (LDS)";
$text['endowedlds'] = "Endowed (LDS)";
$text['sealedplds'] = "Selado aos pais (LDS)";
$text['sealedslds'] = "Selado ao c�njuge (in) (LDS)";
//$text['photoshistories'] = "Photos &amp; Histories";
$text['ancestors'] = "Ancestrais";
$text['descendants'] = "Descendentes";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Data da �ltima importa��o de GEDCOM";
$text['type'] = "Tipo";
$text['savechanges'] = "Salvar";
$text['familyid'] = "ID da fam�lia";
$text['headstone'] = "L�pides";
$text['historiesdocs'] = "Hist�rias e Documentos";
$text['livingnote'] = "Pessoa viva - detalhes ocultos por raz�es de privacidade";
$text['anonymous'] = "an�nimo";
$text['places'] = "Localidades";
$text['anniversaries'] = "Datas e anivers�rios";
$text['administration'] = "Administra��o";
$text['help'] = "Ajuda";
//$text['documents'] = "Documents";
$text['year'] = "Ano";
$text['all'] = "Todos";
$text['repository'] = "Reposit�rio";
$text['address'] = "Endere�o";
$text['suggest'] = "Sugest�o de altera��o";
$text['editevent'] = "Sugest�o de altera��o deste evento";
$text['findplaces'] = "Encontrar todas pessoas com eventos nestes local";
$text['morelinks'] = "Mais v�nculos";
$text['faminfo'] = "Dados da fam�lia";
$text['persinfo'] = "Dados da pessoa";
$text['srcinfo'] = "Dados da fonte";
$text['fact'] = "Fato";
$text['goto'] = "Selecione uma p�gina";
$text['tngprint'] = "Imprimir";
//changed in 6.0.0
$text['livingphoto'] = "Ao menos uma pessoa viva est� ligada a esta foto - detalhes ocultos por raz�es de privacidade. ";
$text['databasestatistics'] = "Estat�stica da base de dados";
//moved here in 6.0.0
$text['child'] = "Filho(a)";
$text['repoinfo'] = "Informa��o do local de arquivamento";
$text['tng_reset'] = "Limpar";
$text['noresults'] = "Resultado vazio";
//added in 6.0.0
$text['allmedia'] = "Toda m�dia";
$text['repositories'] = "Reposit�rios";
$text['albums'] = "�lbuns";
$text['cemeteries'] = "Cemit�rios";
$text['surnames'] = "Sobrenomes";
$text['dates'] = "Datas";
$text['link'] = "Link";
$text['media'] = "M�dia";
$text['gender'] = "G�nero";
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
$text['cemetery'] = "Cemit�rios";
//added in 6.1.0
//Google Maps messages
$text['gmapevent'] = "Mapa de eventos";
$text['gevents'] = "Evento";
$text['glang'] = "&amp;hl=pt-BR";
$text['googleearthlink'] = "Link para Google Earth";
$text['googlemaplink'] = "Link para Google Maps";
$text['gmaplegend'] = "Legenda de marcadores";
//moved here in 7.0.0
$text['unmarked'] = "N�o marcado";
$text['located'] = "Localizado";
//added in 7.0.0
$text['albclicksee'] = "Clicar para ver todos itens do �lbum";
$text['notyetlocated'] = "Ainda n�o localizado";
$text['cremated'] = "Cremado";
$text['missing'] = "Faltando";
$text['page'] = "P�gina";
$text['pdfgen'] = "Gerador de PDF";
$text['blank'] = "Diagrama Vazio";
$text['none'] = "Nenhum";
$text['fonts'] = "Fontes";
$text['header'] = "Cabe�alho";
$text['data'] = "Data";
$text['pgsetup'] = "Configura��o";
$text['pgsize'] = "Tamanho da Folha";
$text['letter'] = "Carta";
$text['legal'] = "Of�cio";
$text['orient'] = "Orienta��o";
$text['portrait'] = "Retrato";
$text['landscape'] = "Paisagem";
$text['tmargin'] = " Margem Superior";
$text['bmargin'] = " Margem Inferior";
$text['lmargin'] = " Margem Esquerda";
$text['rmargin'] = "Margem Direita";
$text['createch'] = "Criar Diagrama";
$text['prefix'] = "Prefixo";
$text['mostwanted'] = "Mais Procurado";
$text['latupdates'] = "�ltimas altera��es";
$text['featphoto'] = "Foto do dia";
$text['news'] = "Novidades";
$text['ourhist'] = "Nossa Hist�ria de Fam�lia";
$text['ourhistanc'] = "Nossa Hist�ria de Fam�lia e Ancestrais";
$text['ourpages'] = "Nossas P�ginas de Genealogia da Fam�lia";
$text['pwrdby'] = "Este site � gerenciado por";
$text['writby'] = "escrito por";
$text['searchtngnet'] = "Buscar em TNG Network (GENDEX)";
$text['viewphotos'] = "Ver todas fotos";
$text['anon'] = "Voc� est� an�nimo";
$text['whichbranch'] = "De que ramo voc� �?";
$text['featarts'] = "Artigos Detalhados";
$text['maintby'] = "Mantido por";
$text['createdon'] = "Criado em";

//for home page, from Nuke Add-on, added here in 5.0.0
$text['mnuheader'] = "P�gina Inicial";
$text['mnusearchfornames'] = "Pesquisar Pessoa";
$text['mnulastname'] = "Sobrenome";
$text['mnufirstname'] = "Nome";
$text['mnusearch'] = "Pesquisar";
$text['mnureset'] = "Repetir";
$text['mnulogon'] = "Log In";
$text['mnulogout'] = "Log Out";
$text['mnufeatures'] = "Outras Atividades";
$text['mnuregister'] = "Registrar-se como Usu�rio";
$text['mnuadvancedsearch'] = "Pesquisa Avan�ada";
$text['mnulastnames'] = "Sobrenomes";
$text['mnustatistics'] = "Estat�stica";
$text['mnuphotos'] = "Fotos";
$text['mnuhistories'] = "Hist�rias";
$text['mnumyancestors'] = "Fotos &amp; Hist�rias dos ancestrais de [Person]";
$text['mnucemeteries'] = "Cemit�rios";
$text['mnutombstones'] = "L�pides";
$text['mnureports'] = "Relat�rios";
$text['mnusources'] = "Fontes";
$text['mnuwhatsnew'] = "O que h� de novo";
$text['mnushowlog'] = "Registro de Acessos";
$text['mnulanguage'] = "Mudar Idioma";
$text['mnuadmin'] = "P�gina da Administra��o";
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

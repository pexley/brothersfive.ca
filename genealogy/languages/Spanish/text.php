<?php
switch ( $textpart ) {
	//browsesources.php, showsource.php
	case "sources":
		$text['browseallsources'] = "Examinar todas las fuentes";
		$text['shorttitle'] = "T�tulo abreviado";
		$text['callnum'] = "N�mero de registro";
		$text['author'] = "Autor";
		$text['publisher'] = "Editor";
		$text['other'] = "Otra informaci�n";
		$text['sourceid'] = "ID de fuente";
		$text['moresrc'] = "M�s fuentes";
		$text['repoid'] = "ID de repositorio";
		$text['browseallrepos'] = "Examinar todos los repositorios";
		break;

	//changelanguage.php, savelanguage.php
	case "language":
		$text['newlanguage'] = "Nuevo idioma";
		$text['changelanguage'] = "Cambiar idioma";
		$text['languagesaved'] = "Idioma guardado";
		//added in 7.0.0
		$text['sitemaint'] = "Mantenimiento del sitio en progreso";
		$text['standby'] = "El sitio web se encuentra moment�neamente fuera de l�nea mientras nosotros actualizamos nuestra base de datos. Por favor intentar nuevamente en algunos minutos. Si el sitio permanece fuera de l�nea por un intervalo de tiempo excesivo, por favor <a href=\"suggest.php\">haga contacto con el due�o del sitio web</a>.";
		break;

	//gedcom.php, gedform.php
	case "gedcom":
		$text['gedstart'] = "Comenzar GEDCOM desde";
		$text['producegedfrom'] = "Generar archivo GEDCOM desde";
		$text['numgens'] = "N�mero de generaciones";
		$text['includelds'] = "Incluir informaci�n LDS";
		$text['buildged'] = "Generar GEDCOM";
		$text['gedstartfrom'] = "GEDCOM iniciando desde";
		$text['nomaxgen'] = "Debe indicar un n�mero m�ximo de generaciones. Por favor, vuelva a la p�gina anterior utilizando el bot�n volver de su navegador y corrija el error";
		$text['gedcreatedfrom'] = "GEDCOM creado desde";
		$text['gedcreatedfor'] = "creado para";

		$text['enteremail'] = "Por favor, escriba una direcci�n de e-mail v�lida.";
		$text['creategedfor'] = "Crear GEDCOM";
		$text['email'] = "Direcci�n e-Mail";
		$text['suggestchange'] = "Sugerir correcciones o cambios";
		$text['yourname'] = "Su Nombre";
		$text['comments'] = "Anotaciones y comentarios";
		$text['comments2'] = "Comentarios";
		$text['submitsugg'] = "Enviar Sugerencias";
		$text['proposed'] = "Cambios Sugeridos";
		$text['mailsent'] = "Gracias. Su mensaje ha sido enviado.";
		$text['mailnotsent'] = "Lo sentimos, pero su mensaje no ha podido ser enviado. Por favor, comunique directamente con xxx en yyy.";
		$text['mailme'] = "Enviar copia a �sta direcci�n";
		//added in 5.0.5
		$text['entername'] = "Por favor, ingrese su nombre.";
		$text['entercomments'] = "Por favor ingrese sus comentarios";
		$text['sendmsg'] = "Enviar Mensaje";
		break;

	//getextras.php, getperson.php
	case "getperson":
		$text['photoshistoriesfor'] = "Fotograf�as e Historias de";
		$text['indinfofor'] = "Informaci�n individual de";
		$text['reliability'] = "Confiabilidad";
		$text['pp'] = "P�g.";
		$text['age'] = "Edad";
		$text['agency'] = "Agencia";
		$text['cause'] = "Causa";
		$text['suggested'] = "Sugerido";
		$text['closewindow'] = "Cerrar esta ventana";
		$text['thanks'] = "Gracias";
		$text['received'] = "Hemos recibido sus sugerencias. El administrador del sitio las evaluar� oportunamente.";
		//added in 6.0.0
		$text['association'] = "Asociaci�n";
		//added in 7.0.0
		$text['indreport'] = "Informe de Individuo";
		$text['indreportfor'] = "Informe Individual para";
		$text['general'] = "General";
		$text['labels'] = "Etiquetas";
		$text['bkmkvis'] = "<strong>Nota:</strong> Estos favoritos solo es posible verlos en esta computadora y utilizando este explorador de internet.";
		break;

	//relateform.php, relationship.php, findpersonform.php, findperson.php
	case "relate":
		$text['relcalc'] = "Calculador de Relaci�n";
		$text['findrel'] = "Encontrar Relaci�n";
		$text['person1'] = "Persona 1:";
		$text['person2'] = "Persona 2:";
		$text['calculate'] = "Calcular";
		$text['select2inds'] = "Por favor seleccionar dos individuos.";
		$text['findpersonid'] = "Encontrar ID de Persona";
		$text['enternamepart'] = "escriba parte del nombre o del apellido";
		$text['pleasenamepart'] = "Por favor, ingrese una parte del nombre o del apellido.";
		$text['clicktoselect'] = "click para seleccionar";
		$text['nobirthinfo'] = "No hay informaci�n de nacimiento";
		$text['relateto'] = "Relaci�n con";
		$text['sameperson'] = "Los dos individuos son la misma persona.";
		$text['notrelated'] = "Los dos individuos seleccionados no est�n relacionados dentro de xxx generaciones.";
		$text['findrelinstr'] = "Puede utilizar los botones 'Buscar' para localizar a los individuos cuya relaci�n de parentesco desee conocer o mantener a los individuos actuales. Luego oprima el bot�n 'Calcular'.";
		$text['gencheck'] = "N�mero m�ximo de generaciones <br />a comprobar";
		$text['sometimes'] = "(Tenga en cuenta que el cambio del n�mero de generaciones puede producir resultados diferentes.)";
		$text['findanother'] = "Buscar otro v�nculo";
		//added in 6.0.0
		$text['brother'] = "el hermano de";
		$text['sister'] = "la hermana de";
		$text['sibling'] = "el hermano de";
		$text['uncle'] = "el t�o xxx de";
		$text['aunt'] = "la t�a xxx de";
		$text['uncleaunt'] = "el t�o/t�a xxx de";
		$text['nephew'] = "el sobrino xxx de";
		$text['niece'] = "la sobrina xxx de";
		$text['nephnc'] = "el sobrino/a xxx de";
		$text['mcousin'] = "el primo xxx de";
		$text['fcousin'] = "la prima xxx de";
		$text['cousin'] = "el primo xxx de";
		$text['removed'] = "veces quitado";
		$text['rhusband'] = "el marido de ";
		$text['rwife'] = "la esposa de ";
		$text['rspouse'] = "el esposo de ";
		$text['son'] = "el hijo de";
		$text['daughter'] = "la hija de";
		$text['rchild'] = "los hijos de";
		$text['sil'] = "el yerno de";
		$text['dil'] = "la nuera de";
		$text['sdil'] = "el yerno o nuera de";
		$text['gson'] = "el nieto xxx de";
		$text['gdau'] = "la nieta xxx de";
		$text['gsondau'] = "el nieto/a xxx de";
		$text['great'] = "gran";
		$text['spouses'] = "son esposos";
		$text['is'] = "es";
		//changed in 6.0.0
		$text['changeto'] = "Cambiar a (ingresar el ID):";
		//added in 6.0.0
		$text['notvalid'] = "no es el ID v�lido de una Persona o no existe en �sta base de datos. Por favor intente de vuelta.";
		break;

	case "familygroup":
		$text['familygroupfor'] = "Hoja de grupo familiar de";
		$text['ldsords'] = "Ord. LDS";
		$text['baptizedlds'] = "Bautismo (LDS)";
		$text['endowedlds'] = "Investido (LDS)";
		$text['sealedplds'] = "Sellado P (LDS)";
		$text['sealedslds'] = "Sellado C (LDS)";
		$text['otherspouse'] = "Otro c�nyuge";
		//changed in 7.0.0
		$text['husband'] = "Esposo";
		$text['wife'] = "Esposa";
		break;

	//pedigree.php
	case "pedigree":
		$text['capbirthabbr'] = "N";
		$text['capaltbirthabbr'] = "A";
		$text['capdeathabbr'] = "F";
		$text['capburialabbr'] = "E";
		$text['capplaceabbr'] = "L";
		$text['capmarrabbr'] = "C";
		$text['capspouseabbr'] = "SP";
		$text['redraw'] = "Volver a generar con";
		$text['scrollnote'] = "Atenci�n: Puede que sea necesario utilizar barras de desplazamiento para ver todo el �rbol.";
		$text['unknownlit'] = "Sin datos";
		$text['popupnote1'] = " = Informaci�n adicional";
		$text['popupnote2'] = " = Nuevo �rbol";
		$text['pedcompact'] = "Compacto";
		$text['pedstandard'] = "Est�ndar";
		$text['pedtextonly'] = "S�lo texto";
		$text['descendfor'] = "Descendientes de";
		$text['maxof'] = "M�ximo de";
		$text['gensatonce'] = "generaciones mostradas de una sola vez.";
		$text['sonof'] = "hijo de";
		$text['daughterof'] = "hija de";
		$text['childof'] = "hijo de";
		$text['stdformat'] = "Formato est�ndar";

		$text['ahnentafel'] = "Metodolog�a Ahnentafel";
		$text['addnewfam'] = "A�adir antepasado";
		$text['editfam'] = "Editar familia";
		$text['side'] = "Rama";
		$text['familyof'] = "Familia de";
		$text['paternal'] = "Paternal";
		$text['maternal'] = "Maternal";
		$text['gen1'] = "Mismo";
		$text['gen2'] = "Padres";
		$text['gen3'] = "Abuelos";
		$text['gen4'] = "Bisabuelos";
		$text['gen5'] = "Tatarabuelos";
		$text['gen6'] = "Tataratatarabuelos";
		$text['gen7'] = "4� bisabuelos";
		$text['gen8'] = "5� bisabuelos";
		$text['gen9'] = "6� bisabuelos";
		$text['gen10'] = "7� bisabuelos";
		$text['gen11'] = "8� bisabuelos";
		$text['gen12'] = "9� bisabuelos";
		$text['graphdesc'] = "Trazar descendencia gr�fica hasta este punto";
		$text['collapse'] = "Colapsar";
		$text['expand'] = "Expandir";
		$text['pedbox'] = "Caja";
		//changed in 6.0.0
		$text['regformat'] = "Registrarse";
		$text['extrasexpl'] = "Al menos una foto, historia u otros medios existen para �ste individuo.";
		//added in 6.0.0
		$text['popupnote3'] = " = Nuevo gr�fico";
		$text['mediaavail'] = "Medios Disponibles";
		//changed in 7.0.0
		$text['pedigreefor'] = "�rbol geneal�gico de";
		//added in 7.0.0
		$text['pedigreech'] = "Gr�fico de Pedigree";
		$text['datesloc'] = "Fechas y Localidades";
		$text['borchr'] = "Naci�/Alt - Muri�/L�pida (dos)";
		$text['nobd'] = "No hay Fechas de Nacer o Morir";
		$text['bcdb'] = "Naci�/Alt/Muri�/L�pida (cuatro)";
		$text['numsys'] = "Sistema de Numeraci�n";
		$text['gennums'] = "N�mero de Generaciones";
		$text['henrynums'] = "N�meros de Henry";
		$text['abovnums'] = "N�meros de d'Aboville";
		$text['devnums'] = "N�meros de de Villiers";
		$text['dispopts'] = "Mostrar Opciones";
		break;

	//search.php, searchform.php
	//merged with reports and showreport in 5.0.0
	case "search":
	case "reports":
		$text['noreports'] = "No hay informes existentes.";
		$text['reportname'] = "Nombre del Informe";
		$text['allreports'] = "Todos los Informes";
		$text['report'] = "Informe";
		$text['error'] = "Error";
		$text['reportsyntax'] = "La sintaxis de la consulta se ejecuta con este informe";
		$text['wasincorrect'] = "no es correcta, de modo que el informe no puede ser producido. Por favor, contacte al administrador del sistema en";
		$text['query'] = "Consulta";
		$text['errormessage'] = "Mensaje de Error";
		$text['equals'] = "es igual a";
		$text['contains'] = "contiene";
		$text['startswith'] = "comienza con";
		$text['endswith'] = "termina con";
		$text['soundexof'] = "soundex de";
		$text['metaphoneof'] = "metafon�a de";
		$text['plusminus10'] = "+/- 10 a�os desde";
		$text['lessthan'] = "menor que";
		$text['greaterthan'] = "mayor que";
		$text['lessthanequal'] = "menor o igual a";
		$text['greaterthanequal'] = "mayor o igual a";
		$text['equalto'] = "igual a";
		$text['tryagain'] = "Por favor, intente nuevamente";
		$text['text_for'] = "para";
		$text['searchnames'] = "Buscar por Nombres";
		$text['joinwith'] = "Unir con";
		$text['cap_and'] = "Y";
		$text['cap_or'] = "O";
		$text['showspouse'] = "Mostrar c�nyuge (en caso de tener el individuo m�s de un c�nyuge mostrar� duplicados)";
		$text['submitquery'] = "Enviar Consulta";
		$text['birthplace'] = "Lugar de Nacimiento";
		$text['deathplace'] = "Lugar de Fallecimiento";
		$text['birthdatetr'] = "A�o de Nacimiento";
		$text['deathdatetr'] = "A�o de Fallecimiento";
		$text['plusminus2'] = "+/- 2 a�os desde";
		$text['resetall'] = "Restaurar Todos los Valores";

		$text['showdeath'] = "Mostrar informaci�n de fallecimiento y/o entierro";
		$text['altbirthplace'] = "Lugar de Bautismo";
		$text['altbirthdatetr'] = "A�o de Bautismo";
		$text['burialplace'] = "Lugar de Entierro";
		$text['burialdatetr'] = "A�o de Entierro";
		$text['event'] = "Evento(s)";
		$text['day'] = "D�a";
		$text['month'] = "Mes";
		$text['keyword'] = "Palabra clave (pej., \"Circa\")";
		$text['explain'] = "Ingrese la fecha para ver los eventos que corresponden. Deje el campo en blanco si quiere ver las coincidencias para todos.";
		$text['enterdate'] = "Por favor, ingrese o seleccione por lo menos uno de los siguientes datos: d�a, mes, a�o, palabra clave";
		$text['fullname'] = "Nombre Completo";
		$text['birthdate'] = "Fecha de Nacimiento";
		$text['altbirthdate'] = "Fecha de Bautismo";
		$text['marrdate'] = "Fecha de Casamiento";
		$text['spouseid'] = "ID del C�nyuge";
		$text['spousename'] = "Nombre del C�nyuge";
		$text['deathdate'] = "Fecha de Fallecimiento";
		$text['burialdate'] = "Fecha de Entierro";
		$text['changedate'] = "Fecha de �ltima Modificaci�n";
		$text['gedcom'] = "�rbol";
		$text['baptdate'] = "Fecha de Bautismo (LDS)";
		$text['baptplace'] = "Lugar de Bautismo (LDS)";
		$text['endldate'] = "Fecha de Investidura (LDS)";
		$text['endlplace'] = "Lugar de Investidura (LDS)";
		$text['ssealdate'] = "Fecha de Sellado Cony. (LDS)";
		$text['ssealplace'] = "Lugar del Sellado Cony. (LDS)";
		$text['psealdate'] = "Fecha de Sellado de Padres (LDS)";
		$text['psealplace'] = "Lugar de Sellado P (LDS)";
		$text['marrplace'] = "Lugar de Casamiento";
		$text['spousesurname'] = "Apellido de los Esposos";
		//changed in 6.0.0
		$text['spousemore'] = "Si usted ingresa un valor para el Apellido de los Esposos, usted debe seleccionar un Sexo.";
		//added in 6.0.0
		$text['plusminus5'] = "+/- 5 a�os desde";
		$text['exists'] = "existe";
		$text['dnexist'] = "no existe";
		//added in 6.0.3
		$text['divdate'] = "Fecha del Divorcio";
		$text['divplace'] = "Lugar del Divorcio";
		//changed in 7.0.0
		$text['otherevents'] = "Otros Eventos";
		//added in 7.0.0
		$text['numresults'] = "Resultados por p�gina";
		$text['mysphoto'] = "Fotos Misteriosas";
		$text['mysperson'] = "Personas Elusivas";
		$text['joinor'] = "La opci�n 'Unir con �' no puede ser usada con el Apellido del Esposo";
		//added in 7.0.1
		$text['tellus'] = "Cuentenos que sabe usted";
		$text['moreinfo'] = "M�s Informaci�n:";
		break;

	//showlog.php
	case "showlog":
		$text['logfilefor'] = "Archivo de log de";
		$text['mostrecentactions'] = "Acciones m�s recientes";
		$text['autorefresh'] = "Esta p�gina se actualiza en forma autom�tica cada 30 segundos";
		$text['refreshoff'] = "Desactivar Auto Refrescado";
		break;

	case "headstones":
	case "showphoto":
		$text['cemeteriesheadstones'] = "Cementerios y L�pidas";
		$text['showallhsr'] = "Mostrar todos los registros de l�pidas";
		$text['in'] = "en";
		$text['showmap'] = "Ver mapa";
		$text['headstonefor'] = "L�pida de";
		$text['photoof'] = "Foto de";
		$text['firstpage'] = "Primera P�gina";
		$text['lastpage'] = "�ltima P�gina";
		$text['photoowner'] = "Propietario/Fuente";

		$text['nocemetery'] = "Sin Cementerio";
		$text['iptc005'] = "T�tulo";
		$text['iptc020'] = "Categor�as Suple.";
		$text['iptc040'] = "Instrucciones Especiales";
		$text['iptc055'] = "Fecha de Creaci�n";
		$text['iptc080'] = "Autor";
		$text['iptc085'] = "Cargo del Autor";
		$text['iptc090'] = "Ciudad";
		$text['iptc095'] = "Provincia/Estado";
		$text['iptc101'] = "Pa�s";
		$text['iptc103'] = "OTRO";
		$text['iptc105'] = "Titulares";
		$text['iptc110'] = "Fuente";
		$text['iptc115'] = "Fuente Gr�fica";
		$text['iptc116'] = "Informaci�n de Copyright";
		$text['iptc120'] = "Encabezado";
		$text['iptc122'] = "Autor de Encabezado";
		$text['mapof'] = "Mapa de";
		$text['regphotos'] = "Vista completa";
		$text['gallery'] = "Ver miniaturas solamente";
		$text['cemphotos'] = "Fotos de cementerios";
		//changed in 6.0.0
		$text['photosize'] = "Tama�o";
		//added in 6.0.0
        	$text['iptc010'] = "Prioridad";
		$text['filesize'] = "Tama�o de Archivo";
		$text['seeloc'] = "Ver Ubicaci�n";
		$text['showall'] = "Mostrar Todo";
		$text['editmedia'] = "Editar Medios";
		$text['viewitem'] = "Ver este item";
		$text['editcem'] = "Editar Cementerio";
		$text['numitems'] = "N� de Items";
		$text['allalbums'] = "Todos los Albums";
		//added in 6.1.0
		$text['slidestart'] = "Comenzar Show de Slides";
		$text['slidestop'] = "Pausar Show de Slides";
		$text['slideresume'] = "Reasumir Show de Slides";
		$text['slidesecs'] = "Segundos para cada slide:";
		$text['minussecs'] = "menos 0.5 segundos";
		$text['plussecs'] = "m�s 0.5 segundos";
		//added in 7.0.0
		$text['nocountry'] = "Pa�s desconocido";
		$text['nostate'] = "Provincia desconocida";
		$text['nocounty'] = "Municipio desconocido";
		$text['nocity'] = "Ciudad desconocida";
		$text['nocemname'] = "Nombre de cementerio desconocido";
		$text['plot'] = "Plot";
		$text['location'] = "Localidad";
		$text['editalbum'] = "Editar Album";
		$text['mediamaptext'] = "<strong>Nota:</strong> Mueva el puntero de su mouse sobre las im�genes para mostrar los nombres. Haga click para ver una p�gina por cada nombre.";
		break;

	//surnames.php, surnames100.php, surnames-all.php, surnames-oneletter.php
	case "surnames":
	case "places";
		$text['surnamesstarting'] = "Seleccionar letra inicial de apellido";
		$text['showtop'] = "Mostrar los primeros";
		$text['showallsurnames'] = "Mostrar todos los apellidos";
		$text['sortedalpha'] = "ordenados alfab�ticamente";
		$text['byoccurrence'] = "ordenados por n�mero de coincidencias";
		$text['firstchars'] = "Iniciales";
		$text['top'] = "Top";
		$text['mainsurnamepage'] = "P�gina principal de apellidos";
		$text['allsurnames'] = "Lista completa de apellidos";
		$text['showmatchingsurnames'] = "Haga clic en un apellido para ver los registros coincidentes";
		$text['backtotop'] = "Volver arriba";
		$text['beginswith'] = "Comienza con";
		$text['allbeginningwith'] = "Todos los apellidos que comienzan con";
		$text['numoccurrences'] = "n�mero de coincidencias entre par�ntesis";
		$text['placesstarting'] = "Mostrar lugares que empiecen por";
		$text['showmatchingplaces'] = "Haga clic en un lugar para mostrar registros coincidentes.";
		$text['totalnames'] = "individuos totales";
		$text['showallplaces'] = "Ver todos los lugares m�s grandes";
		$text['totalplaces'] = "lugares totales";
		$text['mainplacepage'] = "P�gina de inicio de lugares";
		$text['allplaces'] = "Todos los lugares m�s grandes";
		$text['placescont'] = "Mostrar todos los lugares que contienen";
		//added in 7.0.0
		$text['top30'] = "Los 30 apellidos tope";
		$text['top30places'] = "Las 30 localidades m�s grandes";
		break;

	//whatsnew.php
	case "whatsnew":
		$text['pastxdays'] = "(�ltimos xx d�as)";
		$text['historiesdocs'] = "Historias";
		//$text['headstones'] = "L�pidas";

		$text['photo'] = "Foto";
		$text['history'] = "Historia/Documento";
		//changed in 7.0.0
		$text['husbid'] = "ID de esposo";
		$text['husbname'] = "Nombre del esposo";
		$text['wifeid'] = "ID de esposa";
		break;

	//timeline.php, timeline2.php
	case "timeline":
		$text['text_delete'] = "Borrar";
		$text['addperson'] = "A�adir persona";
		$text['nobirth'] = "El siguiente individuo no tiene una fecha de nacimiento v�lida y por lo tanto no puede ser a�adido";
		$text['noliving'] = "El siguiente individuo est� se�alado como persona viva y no puede ser a�adido. Para ello es necesario un nivel superior de permisos.";
		$text['event'] = "Evento(s)";
		$text['chartwidth'] = "Dimensi�n gr�fico";
		//changed in 6.0.0
		$text['timelineinstr'] = "A�ada hasta cuatro individuos m�s ingresando sus ID en los campos siguientes:";
		//added in 6.0.0
		$text['togglelines'] = "Invertir L�neas";
		break;

	//browsetrees.php
	//login.php, newacctform.php, addnewacct.php
	case "trees":
	case "login":
		$text['browsealltrees'] = "Examinar Todos los �rboles";
		$text['treename'] = "Nombre de �rbol";
		$text['owner'] = "Propietario";
		$text['address'] = "Direcci�n";
		$text['city'] = "Ciudad";
		$text['state'] = "Estado/Provincia";
		$text['zip'] = "C�digo Postal/Zip";
		$text['country'] = "Pa�s";
		$text['email'] = "Direcci�n e-Mail";
		$text['phone'] = "Tel�fono";
		$text['username'] = "Nombre de Usuario";
		$text['password'] = "Contrase�a";
		$text['loginfailed'] = "Fallo el Acceso";

		$text['regnewacct'] = "Registrarse para Abrir una Cuenta Nueva";
		$text['realname'] = "Su nombre real";
		$text['phone'] = "Tel�fono";
		$text['email'] = "Direcci�n e-Mail";
		$text['address'] = "Direcci�n";
		$text['comments'] = "Anotaciones y comentarios";
		$text['submit'] = "Enviar";
		$text['leaveblank'] = "(dejar en blanco si est� solicitando un nuevo �rbol)";
		$text['required'] = "Campos requeridos";
		$text['enterpassword'] = "Por favor, ingrese una contrase�a.";
		$text['enterusername'] = "Por favor, ingrese un nombre de usuario.";
		$text['failure'] = "El nombre de usuario escogido por usted ya est� siendo utilizado por otro usuario. Por favor, oprimir el bot�n Volver de su navegador para regresar a la p�gina anterior y escoja un nombre diferente.";
		$text['success'] = "Gracias. Hemos recibido su solicitud de registro. Nos pondremos en contacto con usted tan pronto como su cuenta est� activa o sea necesario ampliar la informaci�n suministrada.";
		$text['emailsubject'] = "Nueva solicitud de registro en TNG";
		$text['emailmsg'] = "Se ha recibido una nueva solicitud de cuenta de usuario TNG. Por favor, ingrese al �rea de administraci�n TNG y asignar los permisos adecuados para esta nueva cuenta. En caso de aprobar este nuevo registro, por favor notifique al solicitante respondiendo a este mensaje.";
		//changed in 5.0.0
		$text['enteremail'] = "Por favor, escriba una direcci�n de e-mail v�lida.";
		$text['website'] = "Sitio Web";
		$text['nologin'] = " �A�n no se registr� para acceder? ";
		$text['loginsent'] = "Se envi� informaci�n de acceso";
		$text['loginnotsent'] = "No se envi� informaci�n de acceso";
		$text['enterrealname'] = "Por favor, ingrese su nombre verdadero.";
		$text['rempass'] = "Recordar el ingreso en este equipo";
		$text['morestats'] = "M�s estad�sticas";
		//added in 6.0.0
		$text['accmail'] = "<strong>NOTA:</strong> Con el fin de recibir mail desde el administrador respecto a su cuenta, por favor asegurarse de no estar bloqueando el email proveniente de �ste dominio.";
		$text['newpassword'] = "Nueva Contrase�a";
		$text['resetpass'] = "Cambiar su contrase�a";
		//added in 6.1.0
		$text['nousers'] = "Este formulario no puede usarse hasta que al menos exista un registro. Si usted es el propietario del sitio web, por favor vaya a Admin/Usuarios para crear su cuenta de Administrador.";
		//added in 7.0.0
		$text['noregs'] = "Sepa disculparnos, pero moment�neamente no estamos aceptando el registro de nuevos usuarios. Por favor <a href=\"suggest.php\">contactenos</a> directamente si es que tiene comentarios o preguntas que se relacionen directamente con el sitio web.";
		break;

	//statistics.php
	case "stats":
		$text['quantity'] = "Cantidad";
		$text['totindividuals'] = "Total de Individuos";
		$text['totmales'] = "Total de Hombres";
		$text['totfemales'] = "Total de Mujeres";
		$text['totunknown'] = "Total de Personas con Sexo Desconocido";
		$text['totliving'] = "Total Individuos Vivos";
		$text['totfamilies'] = "Total de Familias";
		$text['totuniquesn'] = "Total de Apellidos Distintos";
		//$text['totphotos'] = "Total de Fotos";
		//$text['totdocs'] = "Historias Totales &amp; Documentos";
		//$text['totheadstones'] = "Total de L�pidas";
		$text['totsources'] = "Total de Fuentes";
		$text['avglifespan'] = "Promedio A�os de Vida";
		$text['earliestbirth'] = "Primer Nacimiento";
		$text['longestlived'] = "Los m�s Longevos";
		$text['years'] = "a�os";
		$text['days'] = "d�as";
		$text['age'] = "Edad";
		$text['agedisclaimer'] = "Los c�lculos de edad est�n basados en individuos con fecha de nacimiento <EM>y</EM> fallecimiento registradas. Debido a la existencia de campos de fecha incompletos (por ejemplo, una fecha consignada solamente como \"1945\" o \"DESP. 1860\"), estos c�lculos no poseen una precisi�n del 100%.";
		$text['treedetail'] = "M�s informaci�n sobre este �rbol";
		//added in 6.0.0
		$text['total'] = "Total";
		break;

	case "notes":
		$text['browseallnotes'] = "Examinar Todas las Notas";
		break;

	case "help":
		$text['menuhelp'] = "Clave de Men�";
		break;

	case "install":
		$text['perms'] = "Todos los permisos se han establecido.";
		$text['noperms'] = "No se pudo establecer los permisos para los siguientes archivos:";
		$text['manual'] = "Por favor establezca los en forma manual.";
		$text['folder'] = "Carpeta";
		$text['created'] = "se ha creado";
		$text['nocreate'] = "no pudo crearse. Por favor crearla en forma manual.";
		$text['infosaved'] = "�Informaci�n guardada, conexi�n verificada!";
		$text['tablescr'] = "�Las tablas han sido creadas!";
		$text['notables'] = "Las siguientes tablas no se pudieron crear:";
		$text['nocomm'] = "TNG no se est� comunicando con su base de datos. No se creo ninguna tabla.";
		$text['newdb'] = "Informaci�n guardada, conexi�n verificada, nueva base de datos creada:";
		$text['noattach'] = "Informaci�n guardada. Conexi�n realizada y base de datos creada, pero TNG no puede unirse a ella.";
		$text['nodb'] = "Informaci�n guardada. Conexi�n realizada, pero la base de datos no existe y no pudo crearse aqu�. Por favor verificar que el nombre de la base de datos es correcto, o bien use su panel de control para crear a la misma.";
		$text['noconn'] = "Informaci�n guardada pero fallo la conexi�n. Uno de los siguientes o todos son incorrectos:";
		$text['exists'] = "existe";
		$text['loginfirst'] = "Usted debe primero ingresar.";
		$text['noop'] = "No se realiz� operaci�n alguna.";
		break;
}

//common
$text['matches'] = "Coincidencias";
$text['description'] = "Descripci�n";
$text['notes'] = "Notas";
$text['status'] = "Estado";
$text['newsearch'] = "Nueva B�squeda";
$text['pedigree'] = "�rbol Geneal�gico";
$text['birthabbr'] = "n.";
$text['chrabbr'] = "c.";
$text['seephoto'] = "Ver foto";
$text['andlocation'] = "&amp; ubicaci�n";
$text['accessedby'] = "accedido por";
$text['go'] = "Ir";
$text['family'] = "Familia";
$text['children'] = "Hijos";
$text['tree'] = "�rbol";
$text['alltrees'] = "Todos los �rboles";
$text['nosurname'] = "[sin apellido]";
$text['thumb'] = "Miniatura";
$text['people'] = "Personas";
$text['title'] = "Tratamiento";
$text['suffix'] = "Sufijo";
$text['nickname'] = "Apodo";
$text['deathabbr'] = "f.";
$text['lastmodified'] = "�ltima Modificaci�n";
$text['married'] = "Casado";
//$text['photos'] = "Fotos";
$text['name'] = "Nombre";
$text['lastfirst'] = "Apellido, Nombre(s)";
$text['bornchr'] = "Nacido/Bautizado";
$text['individuals'] = "Individuos";
$text['families'] = "Familias";
$text['personid'] = "ID Persona";
$text['sources'] = "Fuentes";
$text['unknown'] = "Desconocido";
$text['father'] = "Padre";
$text['mother'] = "Madre";
$text['born'] = "Nacimiento";
$text['christened'] = "Bautismo";
$text['died'] = "Fallecimiento";
$text['buried'] = "Enterrado/a";
$text['spouse'] = "C�nyuge";
$text['parents'] = "Padres";
$text['text'] = "Texto";
$text['language'] = "Idioma";
$text['burialabbr'] = "ent.";
$text['descendchart'] = "Descendientes";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Individuo";
$text['edit'] = "Editar";
$text['date'] = "Fecha";
$text['place'] = "Lugar";
$text['login'] = "Ingresar";
$text['logout'] = "Salir";
$text['marrabbr'] = "c.";
$text['groupsheet'] = "Hoja del Grupo";
$text['text_and'] = "y";
$text['generation'] = "Generaci�n";
$text['filename'] = "Nombre de archivo";
$text['id'] = "ID";
$text['search'] = "Buscar";
$text['living'] = "En Vida";
$text['user'] = "Usuario";
$text['firstname'] = "Nombre";
$text['lastname'] = "Apellido";
$text['searchresults'] = "Resultados de la B�squeda";
$text['diedburied'] = "Fallecido/Enterrado";
$text['homepage'] = "Inicio";
$text['find'] = "Buscar...";
$text['relationship'] = "Parentesco";
$text['relationship2'] = "Relaci�n indefinida";
$text['timeline'] = "L�nea de tiempo";
$text['yesabbr'] = "S�";
$text['divorced'] = "Divorcio";
$text['indlinked'] = "Vinculado/a";
$text['branch'] = "Rama";
$text['moreind'] = "M�s individuos";
$text['morefam'] = "M�s familias";
$text['livingdoc'] = "Al menos un individuo vivo est� vinculado a este documento - Detalles Reservados.";
$text['source'] = "Fuente";
$text['surnamelist'] = "�ndice de apellidos";
$text['generations'] = "Generaciones";
$text['refresh'] = "Actualizar";
$text['whatsnew'] = "Novedades";
$text['reports'] = "Informes";
$text['placelist'] = "Lista de lugares";
$text['baptizedlds'] = "Bautismo (LDS)";
$text['endowedlds'] = "Investido (LDS)";
$text['sealedplds'] = "Sellado P (LDS)";
$text['sealedslds'] = "Sellado C (LDS)";
//$text['photoshistories'] = "Photos &amp; Histories";
$text['ancestors'] = "�rbol geneal�gico";
$text['descendants'] = "Descendientes";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Fecha de la �ltima importaci�n GEDCOM";
$text['type'] = "Tipo";
$text['savechanges'] = "Guardar cambios";
$text['familyid'] = "ID familia";
$text['headstone'] = "Lapidas";
$text['historiesdocs'] = "Historias";
$text['livingnote'] = "Al menos un individuo vivo est� vinculado a esta nota - Detalles Reservados.";
$text['anonymous'] = "an�nimos";
$text['places'] = "Lugares";
$text['anniversaries'] = "Fechas y aniversarios";
$text['administration'] = "Administraci�n";
$text['help'] = "Ayuda";
//$text['documents'] = "Documentos";
$text['year'] = "A�o";
$text['all'] = "Todos";
$text['repository'] = "Repositorio";
$text['address'] = "Direcci�n";
$text['suggest'] = "Sugerir";
$text['editevent'] = " Sugiera un cambio para este evento";
$text['findplaces'] = "Buscar a todos los individuos que registran eventos en este lugar.";
$text['morelinks'] = "M�s Enlaces";
$text['faminfo'] = "Informaci�n Familiar";
$text['persinfo'] = "Informaci�n Personal";
$text['srcinfo'] = "Fuente de la informaci�n";
$text['fact'] = "Hecho";
$text['goto'] = "Seleccione una p�gina";
$text['tngprint'] = "Imprimir";
//changed in 6.0.0
$text['livingphoto'] = "Al menos un individuo vivo est� vinculado a esta foto - Detalles Reservados.";
$text['databasestatistics'] = "Estad�sticas";
//moved here in 6.0.0
$text['child'] = "Hijos";
$text['repoinfo'] = "Informaci�n Repositorio ";
$text['tng_reset'] = "Refrescar";
$text['noresults'] = "No se han encontrado resultados";
//added in 6.0.0
$text['allmedia'] = "Todos los Medios";
$text['repositories'] = "Repositorios";
$text['albums'] = "Albums";
$text['cemeteries'] = "Cementerios";
$text['surnames'] = "Apellidos";
$text['dates'] = "Fechas";
$text['link'] = "Enlaces";
$text['media'] = "Medios";
$text['gender'] = "Sexo";
$text['latitude'] = "Latitud";
$text['longitude'] = "Longitud";
$text['bookmarks'] = "Favoritos";
$text['bookmark'] = "Agregar Favoritos";
$text['mngbookmarks'] = "Ir a Favoritos";
$text['bookmarked'] = "Favorito Agregado";
$text['remove'] = "Quitar";
$text['find_menu'] = "Buscar";
$text['info'] = "Info";
//moved here in 6.0.3
$text['cemetery'] = "Cementerio";
//added in 6.1.0
//Google Maps messages
$text['gmapevent'] = "Mapa de Eventos";
$text['gevents'] = "Evento";
$text['glang'] = "&amp;hl=es";
$text['googleearthlink'] = "Enlace a Google Earth";
$text['googlemaplink'] = "Enlace a Google Maps";
$text['gmaplegend'] = "Leyenda en el Pin";
//moved here in 7.0.0
$text['unmarked'] = "Sin marcar";
$text['located'] = "Ubicaci�n";
//added in 7.0.0
$text['albclicksee'] = "Haga click para ver todos los items en este album";
$text['notyetlocated'] = "Todav�a sin localizar";
$text['cremated'] = "Cremado";
$text['missing'] = "No Encontrado";
$text['page'] = "P�gina";
$text['pdfgen'] = "Generador PDF";
$text['blank'] = "Gr�fico Vac�o";
$text['none'] = "Ninguno";
$text['fonts'] = "Fuentes";
$text['header'] = "Encabezado";
$text['data'] = "Datos";
$text['pgsetup'] = "Configurar P�gina";
$text['pgsize'] = "Tama�o P�gina";
$text['letter'] = "Carta";
$text['legal'] = "Legal";
$text['orient'] = "Orientaci�n";
$text['portrait'] = "Retrato";
$text['landscape'] = "Apaisado";
$text['tmargin'] = "Margen Superior";
$text['bmargin'] = "Margen Inferior";
$text['lmargin'] = "Margen Izquierdo";
$text['rmargin'] = "Margen Derecho";
$text['createch'] = "Crear Gr�fico";
$text['prefix'] = "Prefijo";
$text['mostwanted'] = "M�s Buscado";
$text['latupdates'] = "�ltimas Actualizaciones";
$text['featphoto'] = "Foto Destacada";
$text['news'] = "Noticias";
$text['ourhist'] = "Historia de Nuestra Familia";
$text['ourhistanc'] = "Historia de Nuestra Familia y Ancestros";
$text['ourpages'] = "Paginas de Genealog�a de Nuestra Familia";
$text['pwrdby'] = "Este sitio est� desarrollado por";
$text['writby'] = "escrito por";
$text['searchtngnet'] = "Buscar en TNG Network (GENDEX)";
$text['viewphotos'] = "Ver todas las fotos";
$text['anon'] = "Actualmente aparece como an�nimo";
$text['whichbranch'] = "�De qu� rama es usted?";
$text['featarts'] = "Art�culo Destacado";
$text['maintby'] = "Mantenido por";
$text['createdon'] = "Creado en";

//for home page, from Nuke Add-on, added here in 5.0.0
$text['mnuheader'] = "P�gina de Inicio";
$text['mnusearchfornames'] = "Buscar nombres";
$text['mnulastname'] = "Apellido";
$text['mnufirstname'] = "Nombre";
$text['mnusearch'] = "Buscar";
$text['mnureset'] = "Empezar de nuevo";
$text['mnulogon'] = "Ingresar";
$text['mnulogout'] = "Salir";
$text['mnufeatures'] = "Otras caracter�sticas";
$text['mnuregister'] = "Solicitar cuenta de usuario";
$text['mnuadvancedsearch'] = "B�squeda avanzada";
$text['mnulastnames'] = "Apellidos";
$text['mnustatistics'] = "Datos";
$text['mnuphotos'] = "Fotos";
$text['mnuhistories'] = "Historias";
$text['mnumyancestors'] = "Fotos &amp; Historias para los Ancestros de [Person]";
$text['mnucemeteries'] = "Cementerios";
$text['mnutombstones'] = "L�pidas";
$text['mnureports'] = "Informes";
$text['mnusources'] = "Fuentes";
$text['mnuwhatsnew'] = "Novedades";
$text['mnushowlog'] = "Registro de los Ingresos";
$text['mnulanguage'] = "Cambiar Idioma";
$text['mnuadmin'] = "Administraci�n";
$text['welcome'] = "Bienvenido";
$text['contactus'] = "Contacto";

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

<?php
switch ($textpart) {
  //browsesources.php, showsource.php
  case "sources":
    $text['browseallsources'] = "Examinar Todas las Fuentes";
    $text['shorttitle'] = "T�tulo Abreviado";
    $text['callnum'] = "N�mero Referencia";
    $text['author'] = "Autor";
    $text['publisher'] = "Editor";
    $text['other'] = "Otra Informaci�n";
    $text['sourceid'] = "ID de Fuente";
    $text['moresrc'] = "M�s fuentes";
    $text['repoid'] = "ID de Repositorio";
    $text['browseallrepos'] = "Examinar Todos los Repositorios";
    break;

  //changelanguage.php, savelanguage.php
  case "language":
    $text['newlanguage'] = "Nuevo idioma";
    $text['changelanguage'] = "Cambiar Idioma";
    $text['languagesaved'] = "Idioma Guardado";
    $text['sitemaint'] = "Mantenimiento del sitio en progreso";
    $text['standby'] = "El sitio web se encuentra moment�neamente fuera de l�nea mientras se actualiza la base de datos. Por favor, int�ntelo nuevamente en algunos minutos. Si el sitio permanece fuera de l�nea por un intervalo de tiempo excesivo, por favor <a href=\"suggest.php\">contacte con el Administrador del sitio web</a>.";
    break;

  //gedcom.php, gedform.php
  case "gedcom":
    $text['gedstart'] = "Comenzar GEDCOM desde";
    $text['producegedfrom'] = "Generar archivo GEDCOM desde";
    $text['numgens'] = "N�mero de generaciones";
    $text['includelds'] = "Incluir informaci�n LDS";
    $text['buildged'] = "Generar GEDCOM";
    $text['gedstartfrom'] = "GEDCOM iniciado desde";
    $text['nomaxgen'] = "Debe indicar un n�mero m�ximo de generaciones. Por favor, vuelva a la p�gina anterior utilizando el bot�n volver de su navegador y corrija el error";
    $text['gedcreatedfrom'] = "GEDCOM creado desde";
    $text['gedcreatedfor'] = "creado para";
    $text['creategedfor'] = "Crear GEDCOM";
    $text['email'] = "Direcci�n E-mail";
    $text['suggestchange'] = "Sugerir un cambio";
    $text['yourname'] = "Su Nombre";
    $text['comments'] = "Notas o Comentarios";
    $text['comments2'] = "Comentarios";
    $text['submitsugg'] = "Presentar Sugerencia";
    $text['proposed'] = "Cambio Propuesto";
    $text['mailsent'] = "Gracias. Su mensaje ha sido enviado.";
    $text['mailnotsent'] = "Lo sentimos, pero su mensaje no ha podido ser enviado. Por favor, comun�quese directamente con xxx en yyy.";
    $text['mailme'] = "Enviar copia a �sta direcci�n";
    $text['entername'] = "Por favor, ingrese su nombre.";
    $text['entercomments'] = "Por favor, ingrese sus comentarios";
    $text['sendmsg'] = "Enviar Mensaje";
    //added in 9.0.0
    $text['subject'] = "Asunto";
    break;

  //getextras.php, getperson.php
  case "getperson":
    $text['photoshistoriesfor'] = "Fotos e Historias para";
    $text['indinfofor'] = "Informaci�n individual para";
    $text['pp'] = "P�g."; //page abbreviation
    $text['age'] = "Edad";
    $text['agency'] = "Organismo";
    $text['cause'] = "Causa";
    $text['suggested'] = "Sugerido";
    $text['closewindow'] = "Cerrar esta ventana";
    $text['thanks'] = "Gracias";
    $text['received'] = "Su sugerencia fue remitida al administrador del sitio para su revisi�n.";
    $text['indreport'] = "Reporte Individual";
    $text['indreportfor'] = "Informe de Individuo para";
    $text['general'] = "General";
    $text['bkmkvis'] = "<strong>Nota:</strong> Estos favoritos solo es posible verlos en esta computadora y utilizando este explorador de internet.";
    //added in 9.0.0
    $text['reviewmsg'] = "Usted tiene disponible una sugerencia que necesita ser revisada. La sugerencia se refiere a:";
    $text['revsubject'] = "Cambios sugeridos necesitan su revisi�n";
    break;

  //relateform.php, relationship.php, findpersonform.php, findperson.php
  case "relate":
    $text['relcalc'] = "Calculador de Parentesco";
    $text['findrel'] = "Buscar Parentesco";
    $text['person1'] = "Persona 1:";
    $text['person2'] = "Persona 2:";
    $text['calculate'] = "Calcular";
    $text['select2inds'] = "Por favor, seleccionar dos individuos.";
    $text['findpersonid'] = "Buscar ID de Persona";
    $text['enternamepart'] = "ingrese parte del nombre o del apellido";
    $text['pleasenamepart'] = "Por favor, ingrese una parte del nombre o del apellido.";
    $text['clicktoselect'] = "Clic para seleccionar";
    $text['nobirthinfo'] = "No hay informaci�n de nacimiento";
    $text['relateto'] = "Parentesco con";
    $text['sameperson'] = "Los dos individuos son la misma persona.";
    $text['notrelated'] = "Los dos individuos seleccionados no est�n relacionados dentro de xxx generaciones."; //xxx will be replaced with number of generations
    $text['findrelinstr'] = "Puede utilizar los botones 'Buscar' para localizar a individuos cuyo parentesco desee conocer o mantener los individuos actuales. Luego oprima el bot�n 'Calcular'.";
    $text['sometimes'] = "(Tenga en cuenta que el cambio del n�mero de generaciones puede producir resultados diversos.)";
    $text['findanother'] = "Buscar otro parentesco";
    $text['brother'] = "el hermano de";
    $text['sister'] = "la hermana de";
    $text['sibling'] = "el hermano de";
    $text['uncle'] = "el xxx t�o de";
    $text['aunt'] = "la xxx t�a de";
    $text['uncleaunt'] = "el xxx t�o/t�a de";
    $text['nephew'] = "el xxx sobrino de";
    $text['niece'] = "la xxx sobrina de";
    $text['nephnc'] = "el xxx sobrino/a de";
    $text['removed'] = "generaci�n";
    $text['rhusband'] = "el marido de ";
    $text['rwife'] = "la esposa de ";
    $text['rspouse'] = "el esposo de ";
    $text['son'] = "el hijo de";
    $text['daughter'] = "la hija de";
    $text['rchild'] = "los hijos de";
    $text['sil'] = "el yerno de";
    $text['dil'] = "la nuera de";
    $text['sdil'] = "el yerno o nuera de";
    $text['gson'] = "el xxx nieto de";
    $text['gdau'] = "la xxx nieta de";
    $text['gsondau'] = "el xxx nieto/a de";
    $text['great'] = "gran";
    $text['spouses'] = "son esposos";
    $text['is'] = "es";
    $text['changeto'] = "Cambiar a (ingresar ID):";
    $text['notvalid'] = "no es el ID v�lido de una Persona o no existe en �sta base de datos. Por favor intente nuevamente.";
    $text['halfbrother'] = "el medio hermano de";
    $text['halfsister'] = "la media hermana de";
    $text['halfsibling'] = "el medio hermano de";
    //changed in 8.0.0
    $text['gencheck'] = "N�mero m�ximo de generaciones <br>a comprobar";
    $text['mcousin'] = "el primo en xxx yyy de";  //male cousin; xxx = cousin number, yyy = times removed
    $text['fcousin'] = "la prima en xxx yyy de";  //female cousin
    $text['cousin'] = "el primo en xxx yyy de";
    $text['mhalfcousin'] = "el medio primo en xxx yyy de";  //male cousin
    $text['fhalfcousin'] = "la media prima en xxx yyy de";  //female cousin
    $text['halfcousin'] = "el medio primo en xxx yyy de";
    //added in 8.0.0
    $text['oneremoved'] = "segunda generaci�n";
    $text['gfath'] = "el xxx abuelo de";
    $text['gmoth'] = "la xxx abuela de";
    $text['gpar'] = "los xxx abuelos de";
    $text['mothof'] = "la madre de";
    $text['fathof'] = "el padre de";
    $text['parof'] = "los padres de";
    $text['maxrels'] = "M�ximo parentesco a mostrar";
    $text['dospouses'] = "Mostrar parentesco que implica un c�nyuge";
    $text['rels'] = "Parentesco";
    $text['dospouses2'] = "Mostrar C�nyuges";
    $text['fil'] = "el suegro de";
    $text['mil'] = "la suegra de";
    $text['fmil'] = "el suegro o la suegra de";
    $text['stepson'] = "el hijastro de";
    $text['stepdau'] = "la hijastra de";
    $text['stepchild'] = "el hijastro/a de";
    $text['stepgson'] = "el xxx nietastro de";
    $text['stepgdau'] = "la xxx nietastra de";
    $text['stepgchild'] = "xxx nieto/a pol�tico/a de";
    //added in 8.1.1
    $text['ggreat'] = "gran";
    //added in 8.1.2
    $text['ggfath'] = "el xxx bisabuelo de";
    $text['ggmoth'] = "la xxx bisabuela de";
    $text['ggpar'] = "es xxx bisabuelo/a de";
    $text['ggson'] = "el xxx bisnieto de";
    $text['ggdau'] = "la xxx bisnieta de";
    $text['ggsondau'] = "es xxx bisnieto/a de";
    $text['gstepgson'] = "el xxx bisnietastro de";
    $text['gstepgdau'] = "la xxx bisnietastra de";
    $text['gstepgchild'] = "los xxx bisnietastros de";
    $text['guncle'] = "el xxx t�o abuelo de";
    $text['gaunt'] = "la xxx t�a abuela de";
    $text['guncleaunt'] = "es xxx t�o/a abuelo/a de";
    $text['gnephew'] = "el xxx sobrino nieto de";
    $text['gniece'] = "la xxx sobrina nieta de";
    $text['gnephnc'] = "es xxx sobrino/a nieto/a de";
    break;

  case "familygroup":
    $text['familygroupfor'] = "Hoja del grupo familiar de";
    $text['ldsords'] = "Ordenanzas LDS";
    $text['baptizedlds'] = "Bautismo (LDS)";
    $text['endowedlds'] = "Investido (LDS)";
    $text['sealedplds'] = "Sellado P (LDS)";
    $text['sealedslds'] = "Sellado C (LDS)";
    $text['otherspouse'] = "Otro c�nyuge";
    $text['husband'] = "Padre";
    $text['wife'] = "Madre";
    break;

  //pedigree.php
  case "pedigree":
    $text['capbirthabbr'] = "N";
    $text['capaltbirthabbr'] = "A";
    $text['capdeathabbr'] = "F";
    $text['capburialabbr'] = "E";
    $text['capplaceabbr'] = "L";
    $text['capmarrabbr'] = "C";
    $text['capspouseabbr'] = "ES";
    $text['redraw'] = "Redise�ar con";
    $text['scrollnote'] = "Notas: Es posible que tenga que desplazarse hacia abajo o hacia la derecha para ver el cuadro.";
    $text['unknownlit'] = "Desconocido";
    $text['popupnote1'] = " = Informaci�n adicional";
    $text['popupnote2'] = " = Nuevo �rbol";
    $text['pedcompact'] = "Compacto";
    $text['pedstandard'] = "Est�ndar";
    $text['pedtextonly'] = "Texto";
    $text['descendfor'] = "Descendencia para";
    $text['maxof'] = "M�ximo de";
    $text['gensatonce'] = "generaciones mostradas a la vez.";
    $text['sonof'] = "hijo de";
    $text['daughterof'] = "hija de";
    $text['childof'] = "hijo de";
    $text['stdformat'] = "Formato est�ndar";
    $text['ahnentafel'] = "M�todo Ahnentafel";
    $text['addnewfam'] = "A�adir Nueva Familia";
    $text['editfam'] = "Editar Familia";
    $text['side'] = "(Ascendentes)";
    $text['familyof'] = "Familia de";
    $text['paternal'] = "Paternal";
    $text['maternal'] = "Maternal";
    $text['gen1'] = "Mismo";
    $text['gen2'] = "Padres";
    $text['gen3'] = "Abuelos";
    $text['gen4'] = "Bisabuelos";
    $text['gen5'] = "Tatarabuelos";
    $text['gen6'] = "Choznos";
    $text['gen7'] = "4� Bisabuelos";
    $text['gen8'] = "5� Bisabuelos";
    $text['gen9'] = "6� Bisabuelos";
    $text['gen10'] = "7� Bisabuelos";
    $text['gen11'] = "8� Bisabuelos";
    $text['gen12'] = "9� Bisabuelos";
    $text['graphdesc'] = "Gr�fico descendencia hasta este punto";
    $text['pedbox'] = "Caja";
    $text['regformat'] = "Registro";
    $text['extrasexpl'] = "Al menos una foto, historia u otros medios existen para �ste individuo.";
    $text['popupnote3'] = " = Nuevo gr�fico";
    $text['mediaavail'] = "Medios Disponibles";
    $text['pedigreefor'] = "Arbol geneal�gico de";
    $text['pedigreech'] = "Gr�fico geneal�gico";
    $text['datesloc'] = "Fechas y Ubicaciones";
    $text['borchr'] = "Naci�/Alt - Muri�/Enterrado";
    $text['nobd'] = "Sin Fecha de Nacimiento o Muerte";
    $text['bcdb'] = "Total datos de Nacimiento/Alt/Muerte/Entierro";
    $text['numsys'] = "Sistema de Numeraci�n";
    $text['gennums'] = "N�mero de Generaciones";
    $text['henrynums'] = "N�meros de Henry";
    $text['abovnums'] = "N�meros de d'Aboville";
    $text['devnums'] = "N�meros de Villiers";
    $text['dispopts'] = "Mostrar Opciones";
    //added in 10.0.0
    $text['no_ancestors'] = "No se encontraron ancestros";
    $text['ancestor_chart'] = "Cuadro vertical de ancestros";
    $text['opennewwindow'] = "Abrir en nueva ventana";
    $text['pedvertical'] = "Vertical";
    //added in 11.0.0
    $text['familywith'] = "Family with";
    $text['fcmlogin'] = "Please log in to see details";
    $text['isthe'] = "is the";
    $text['otherspouses'] = "other spouses";
    $text['parentfamily'] = "The parent family ";
    $text['showfamily'] = "Show family";
    $text['shown'] = "shown";
    $text['showparentfamily'] = "show parent family";
    $text['showperson'] = "show person";
    //added in 11.0.2
    $text['otherfamilies'] = "Other families";
    break;

  //search.php, searchform.php
  //merged with reports and showreport in 5.0.0
  case "search":
  case "reports":
    $text['noreports'] = "No existen reportes";
    $text['reportname'] = "Nombre del Reporte";
    $text['allreports'] = "Todos los Reportes";
    $text['report'] = "Reporte";
    $text['error'] = "Error";
    $text['reportsyntax'] = "La sintaxis de la consulta se ejecuta con este reporte";
    $text['wasincorrect'] = "fue incorrecto, y como resultado el reporte no se pudo ejecutar. Por favor, p�ngase en contacto con el administrador del sitio en";
    $text['errormessage'] = "Mensaje de Error";
    $text['equals'] = "igual a";
    $text['endswith'] = "termina con";
    $text['soundexof'] = "soundex fon�tico de";
    $text['metaphoneof'] = "metafon�a fon�tica de";
    $text['plusminus10'] = "+/- 10 a�os desde";
    $text['lessthan'] = "menor que";
    $text['greaterthan'] = "mayor que";
    $text['lessthanequal'] = "menor o igual a";
    $text['greaterthanequal'] = "mayor o igual a";
    $text['equalto'] = "igual a";
    $text['tryagain'] = "Por favor, intente nuevamente";
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
    $text['resetall'] = "Reiniciar Todos los Valores";
    $text['showdeath'] = "Mostrar informaci�n de fallecimiento y/o entierro";
    $text['altbirthplace'] = "Lugar de Bautismo";
    $text['altbirthdatetr'] = "A�o de Bautismo";
    $text['burialplace'] = "Lugar de Entierro";
    $text['burialdatetr'] = "A�o de Entierro";
    $text['event'] = "Evento(s)";
    $text['day'] = "D�a";
    $text['month'] = "Mes";
    $text['keyword'] = "Palabra clave (pej., \"Abt\")";
    $text['explain'] = "Ingrese la fecha para ver los eventos coincidentes. Deje el campo en blanco si quiere ver coincidencias para todos.";
    $text['enterdate'] = "Por favor, ingrese o seleccione por lo menos uno de los siguientes datos: D�a, Mes, A�o, Palabra Clave";
    $text['fullname'] = "Nombre Completo";
    $text['birthdate'] = "Fecha de Nacimiento";
    $text['altbirthdate'] = "Fecha de Bautismo";
    $text['marrdate'] = "Fecha de Casamiento";
    $text['spouseid'] = "ID del C�nyuge";
    $text['spousename'] = "Nombre del C�nyuge";
    $text['deathdate'] = "Fecha de Fallecimiento";
    $text['burialdate'] = "Fecha de Entierro";
    $text['changedate'] = "Fecha �ltima Modificaci�n";
    $text['gedcom'] = "Arbol";
    $text['baptdate'] = "Fecha de Bautismo (LDS)";
    $text['baptplace'] = "Lugar de Bautismo (LDS)";
    $text['endldate'] = "Fecha de Investidura (LDS)";
    $text['endlplace'] = "Lugar de Investidura (LDS)";
    $text['ssealdate'] = "Fecha de Sellado C�ny. (LDS)";   //Sealed to spouse
    $text['ssealplace'] = "Lugar del Sellado C�ny. (LDS)";
    $text['psealdate'] = "Fecha Sellado de Padres (LDS)";   //Sealed to parents
    $text['psealplace'] = "Lugar Sellado P (LDS)";
    $text['marrplace'] = "Lugar del Casamiento";
    $text['spousesurname'] = "Apellido de los Esposos";
    $text['spousemore'] = "Si usted ingresa un valor para el Apellido de los Esposos, usted debe seleccionar un Sexo.";
    $text['plusminus5'] = "+/- 5 a�os desde";
    $text['exists'] = "ya existe";
    $text['dnexist'] = "no existe";
    $text['divdate'] = "Fecha del Divorcio";
    $text['divplace'] = "Lugar del Divorcio";
    $text['otherevents'] = "Otros Eventos";
    $text['numresults'] = "Resultados por p�gina";
    $text['mysphoto'] = "Fotos Dif�ciles";
    $text['mysperson'] = "Personas Dif�ciles";
    $text['joinor'] = "La opci�n 'Unir con O' no puede ser usada con el Apellido del Esposo";
    $text['tellus'] = "Cu�ntenos que sabe usted";
    $text['moreinfo'] = "Haga Clic para m�s informaci�n sobre esta imagen";
    //added in 8.0.0
    $text['marrdatetr'] = "A�o del Matrimonio";
    $text['divdatetr'] = "A�o del Divorcio";
    $text['mothername'] = "Nombre de la Madre";
    $text['fathername'] = "Nombre del Padre";
    $text['filter'] = "Filtro";
    $text['notliving'] = "No vivo";
    $text['nodayevents'] = "Eventos para este mes que no est�n asociados con un d�a espec�fico :";
    //added in 9.0.0
    $text['csv'] = "Archivo CSV delimitado con comas";
    //added in 10.0.0
    $text['confdate'] = "Fecha de Confirmaci�n (LDS)";
    $text['confplace'] = "Lugar de Confirmaci�n (LDS)";
    $text['initdate'] = "Fecha de Inicio (LDS)";
    $text['initplace'] = "Lugar de Inicio (LDS)";
    //added in 11.0.0
    $text['marrtype'] = "Marriage Type";
    $text['searchfor'] = "Buscar";
    $text['searchnote'] = "Nota: esta p�gina utiliza Google para realizar la b�squeda. El n�mero de coincidencias devueltas se ver� directamente afectado por el grado de indexaci�n del sitio por parte de Google.";
    break;

  //showlog.php
  case "showlog":
    $text['logfilefor'] = "Archivo Log de";
    $text['mostrecentactions'] = "Acciones M�s Recientes";
    $text['autorefresh'] = "Esta p�gina se actualiza en forma autom�tica cada 30 segundos";
    $text['refreshoff'] = "Desactivar Auto Refrescado";
    break;

  case "headstones":
  case "showphoto":
    $text['cemeteriesheadstones'] = "Cementerios y L�pidas";
    $text['showallhsr'] = "Mostrar todos los registros de l�pidas";
    $text['in'] = "en";
    $text['showmap'] = "Mostrar mapa";
    $text['headstonefor'] = "L�pida para";
    $text['photoof'] = "Foto de";
    $text['photoowner'] = "Propietario/Fuente";
    $text['nocemetery'] = "Sin Cementerio";
    $text['iptc005'] = "T�tulo";
    $text['iptc020'] = "Categor�as Suple.";
    $text['iptc040'] = "Instrucciones Especiales";
    $text['iptc055'] = "Fecha de Creaci�n";
    $text['iptc080'] = "Autor";
    $text['iptc085'] = "Posici�n del Autor";
    $text['iptc090'] = "Ciudad";
    $text['iptc095'] = "Provincia/Estado";
    $text['iptc101'] = "Pa�s";
    $text['iptc103'] = "OTR";
    $text['iptc105'] = "Titular";
    $text['iptc110'] = "Fuente";
    $text['iptc115'] = "Fuente de la Foto";
    $text['iptc116'] = "Informaci�n de Copyright";
    $text['iptc120'] = "Encabezado";
    $text['iptc122'] = "Autor del Encabezado";
    $text['mapof'] = "Mapa de";
    $text['regphotos'] = "Vista Descriptiva";
    $text['gallery'] = "S�lo Miniaturas";
    $text['cemphotos'] = "Fotos de Cementerios";
    $text['photosize'] = "Dimensiones";
    $text['iptc010'] = "Prioridad";
    $text['filesize'] = "Tama�o de Archivo";
    $text['seeloc'] = "Ver Ubicaci�n";
    $text['showall'] = "Mostrar Todo";
    $text['editmedia'] = "Editar Medios";
    $text['viewitem'] = "Ver este item";
    $text['editcem'] = "Editar Cementerio";
    $text['numitems'] = "Nro. de Items";
    $text['allalbums'] = "Todos los Albums";
    $text['slidestop'] = "Pausar Visor de Im�genes";
    $text['slideresume'] = "Reanudar Visor de Im�genes";
    $text['slidesecs'] = "Segundos para cada muestra:";
    $text['minussecs'] = "menos 0.5 segundos";
    $text['plussecs'] = "m�s 0.5 segundos";
    $text['nocountry'] = "Pa�s desconocido";
    $text['nostate'] = "Provincia desconocida";
    $text['nocounty'] = "Municipio desconocido";
    $text['nocity'] = "Ciudad desconocida";
    $text['nocemname'] = "Nombre de cementerio desconocido";
    $text['editalbum'] = "Editar Album";
    $text['mediamaptext'] = "<strong>Nota:</strong> Mueva el puntero de su rat�n sobre las im�genes para mostrar los nombres. Haga Clic para ver una p�gina por cada nombre.";
    //added in 8.0.0
    $text['allburials'] = "Todos los Entierros";
    $text['moreinfo'] = "Haga Clic para m�s informaci�n sobre esta imagen";
    //added in 9.0.0
    $text['iptc025'] = "Palabras Clave";
    $text['iptc092'] = "Sub-localizaci�n";
    $text['iptc015'] = "Categor�a";
    $text['iptc065'] = "Programa de Origen";
    $text['iptc070'] = "Versi�n del Programa";
    break;

  //surnames.php, surnames100.php, surnames-all.php, surnames-oneletter.php
  case "surnames":
  case "places":
    $text['surnamesstarting'] = "Mostrar los apellidos que comiencen con";
    $text['showtop'] = "Mostrar los primeros";
    $text['showallsurnames'] = "Mostrar todos los apellidos";
    $text['sortedalpha'] = "ordenados alfab�ticamente";
    $text['byoccurrence'] = "ordenados por frecuencia";
    $text['firstchars'] = "Iniciales";
    $text['mainsurnamepage'] = "P�gina principal de apellidos";
    $text['allsurnames'] = "Todos los Apellidos";
    $text['showmatchingsurnames'] = "Clic en un apellido para ver los registros coincidentes";
    $text['backtotop'] = "Volver arriba";
    $text['beginswith'] = "Comienza con";
    $text['allbeginningwith'] = "Todos los apellidos que comienzan con";
    $text['numoccurrences'] = "n�mero total de coincidencias entre par�ntesis";
    $text['placesstarting'] = "Mostrar los lugares mas grandes que comienzan con";
    $text['showmatchingplaces'] = "Clic en un lugar para mostrar lugares m�s peque�os. Clic en el icono de b�squeda para mostrar individuos coincidentes.";
    $text['totalnames'] = "individuos totales";
    $text['showallplaces'] = "Ver todos los lugares m�s grandes";
    $text['totalplaces'] = "total de lugares";
    $text['mainplacepage'] = "P�gina principal de lugares";
    $text['allplaces'] = "Todos los lugares m�s grandes";
    $text['placescont'] = "Mostrar todos los lugares que contienen";
    //changed in 8.0.0
    $text['top30'] = "Los xxx apellidos m�s frecuentes";
    $text['top30places'] = "Los xxx lugares m�s grandes";
    //added in 12.0.0
    $text['firstnamelist'] = "Lista de Nombres";
    $text['firstnamesstarting'] = "Muestre nombres que empiecen po";
    $text['showallfirstnames'] = "Muestre todos los nombres";
    $text['mainfirstnamepage'] = "Pagina principal de nombres";
    $text['allfirstnames'] = "Todos los Nombres";
    $text['showmatchingfirstnames'] = "Haga clic en un nombre para mostrar los registros coincidentes.";
    $text['allfirstbegwith'] = "Todos los nombres que empiezan por";
    $text['top30first'] = "Los mejores xxx nombres";
    $text['allothers'] = "Todos los Otros";
    $text['amongall'] = "(entre todos los nombres)";
    $text['justtop'] = "Solamente los mejores xxx";
    break;

  //whatsnew.php
  case "whatsnew":
    $text['pastxdays'] = "(�ltimos xx d�as)";

    $text['photo'] = "Foto";
    $text['history'] = "Historia/Documento";
    $text['husbid'] = "ID del Pdre";
    $text['husbname'] = "Nombre del Padre";
    $text['wifeid'] = "ID de la Madre";
    //added in 11.0.0
    $text['wifename'] = "Mother's Name";
    break;

  //timeline.php, timeline2.php
  case "timeline":
    $text['text_delete'] = "Eliminar";
    $text['addperson'] = "A�adir Persona";
    $text['nobirth'] = "El siguiente individuo no tiene una fecha de nacimiento v�lida y por lo tanto no puede ser a�adido";
    $text['event'] = "Evento(s)";
    $text['chartwidth'] = "Ancho del Cuadro";
    $text['timelineinstr'] = "A�adir Personas";
    $text['togglelines'] = "Invertir L�neas";
    //changed in 9.0.0
    $text['noliving'] = "El siguiente individuo est� se�alado como persona viva y no puede ser a�adido. Para ello es necesario un nivel superior de permisos.";
    break;

  //browsetrees.php
  //login.php, newacctform.php, addnewacct.php
  case "trees":
  case "login":
    $text['browsealltrees'] = "Examinar Todos los Arboles";
    $text['treename'] = "Nombre de Arbol";
    $text['owner'] = "Propietario";
    $text['address'] = "Direcci�n";
    $text['city'] = "Ciudad";
    $text['state'] = "Estado/Provincia";
    $text['zip'] = "C�digo Postal/Zip";
    $text['country'] = "Pa�s";
    $text['email'] = "Direcci�n E-mail";
    $text['phone'] = "Tel�fono";
    $text['username'] = "Nombre de Usuario";
    $text['password'] = "Contrase�a";
    $text['loginfailed'] = "Fall� el Acceso";

    $text['regnewacct'] = "Registrarse para Nueva Cuenta de Usuario";
    $text['realname'] = "Su Nombre Real";
    $text['phone'] = "Tel�fono";
    $text['email'] = "Direcci�n E-mail";
    $text['address'] = "Direcci�n";
    $text['acctcomments'] = "Notas o Comentarios";
    $text['submit'] = "Enviar";
    $text['leaveblank'] = "(dejar en blanco si solicita un nuevo �rbol)";
    $text['required'] = "Campos requeridos";
    $text['enterpassword'] = "Por favor, ingrese una contrase�a.";
    $text['enterusername'] = "Por favor, ingrese un nombre de usuario.";
    $text['failure'] = "El nombre de usuario escogido por usted ya est� siendo utilizado por otro usuario. Por favor, oprima el bot�n Volver de su navegador para regresar a la p�gina anterior y escoja un nombre diferente.";
    $text['success'] = "Gracias. Hemos recibido su solicitud de registro. Nos pondremos en contacto con usted tan pronto como su cuenta est� activa o sea necesario ampliar la informaci�n suministrada.";
    $text['emailsubject'] = "Nueva solicitud de registro en TNG";
    $text['website'] = "Sitio Web";
    $text['nologin'] = " �A�n no est� registrado? ";
    $text['loginsent'] = "Se envi� informaci�n de acceso";
    $text['loginnotsent'] = "No se envi� informaci�n de acceso";
    $text['enterrealname'] = "Por favor, ingrese su nombre real.";
    $text['rempass'] = "Recordar el ingreso en este equipo";
    $text['morestats'] = "M�s estad�sticas";
    $text['accmail'] = "<strong>NOTA:</strong> Con el fin de recibir un correo del administrador respecto a su cuenta, por favor asegurarse de no estar bloqueando el correo proveniente de �ste dominio.";
    $text['newpassword'] = "Nueva Contrase�a";
    $text['resetpass'] = "Cambiar su contrase�a";
    $text['nousers'] = "Este formulario no puede usarse hasta que al menos exista un registro. Si usted es el propietario del sitio web, por favor vaya a Administraci�n/Usuarios para crear su cuenta de Administrador.";
    $text['noregs'] = "Sepa disculparnos, pero moment�neamente no estamos aceptando el registro de nuevos usuarios. Por favor, <a href=\"suggest.php\">cont�ctenos</a> directamente si es que tiene comentarios o preguntas que se relacionen especificamente con el sitio web.";
    //changed in 8.0.0
    $text['emailmsg'] = "Se ha recibido una nueva solicitud de cuenta de usuario TNG. Por favor, ingrese al �rea de administraci�n TNG y asigne los permisos adecuados para esta nueva cuenta.";
    $text['accactive'] = "La cuenta ha sido activada, pero el usuario no tendr� derechos especiales hasta que se le asignen.";
    $text['accinactive'] = "Ir a Administracion/Usuarios/Revisi�n para acceder a la configuraci�n de la cuenta. La cuenta permanecer� inactiva hasta que edite y guarde el registro al menos una vez.";
    $text['pwdagain'] = "Nuevamente la Contrase�a";
    $text['enterpassword2'] = "Por favor, ingrese su contrase�a de nuevo.";
    $text['pwdsmatch'] = "Las contrase�as no coinciden. Por favor, introduzca la misma contrase�a en cada campo.";
    //added in 8.0.0
    $text['acksubject'] = "Gracias por registrarse"; //for a new user account
    $text['ackmessage'] = "Su solicitud de una cuenta de usuario ha sido recibida. Su cuenta est� inactiva hasta que haya sido revisada por el administrador del sitio. Usted ser� notificado por correo electr�nico cuando su nombre de usuario est� listo para su uso.";
    //added in 12.0.0
    $text['switch'] = "Cambiar";
    break;

  //added in 10.0.0
  case "branches":
    $text['browseallbranches'] = "Navegar en Todas las Ramas";
    break;

  //statistics.php
  case "stats":
    $text['quantity'] = "Cantidad";
    $text['totindividuals'] = "Total de Individuos";
    $text['totmales'] = "Total de Hombres";
    $text['totfemales'] = "Total de Mujeres";
    $text['totunknown'] = "Total de Personas con Sexo Desconocido";
    $text['totliving'] = "Total de Individuos Vivos";
    $text['totfamilies'] = "Total de Familias";
    $text['totuniquesn'] = "Total de Apellidos Distintos";
    //$text['totphotos'] = "Total Photos";
    //$text['totdocs'] = "Total Histories &amp; Documents";
    //$text['totheadstones'] = "Total Headstones";
    $text['totsources'] = "Total de Fuentes";
    $text['avglifespan'] = "Promedio A�os de Vida";
    $text['earliestbirth'] = "Primer Nacimiento";
    $text['longestlived'] = "Los m�s Longevos";
    $text['days'] = "d�as";
    $text['age'] = "Edad";
    $text['agedisclaimer'] = "Los c�lculos de edad est�n basados en individuos con fecha de nacimiento <EM>y</EM> fallecimiento registrados. Debido a la existencia de campos de fecha incompletos (por ejemplo, una fecha consignada solamente como \"1945\" o \"DESP. 1860\"), estos c�lculos no poseen una precisi�n del 100%.";
    $text['treedetail'] = "M�s informaci�n sobre este �rbol";
    $text['total'] = "Total";
    //added in 12.0
    $text['totdeceased'] = "Total de Fallecidos";
    break;

  case "notes":
    $text['browseallnotes'] = "Examinar Todas las Notas";
    break;

  case "help":
    $text['menuhelp'] = "Clave del Men�";
    break;

  case "install":
    $text['perms'] = "Todos los permisos se han establecido.";
    $text['noperms'] = "No se pudo establecer los permisos para los siguientes archivos:";
    $text['manual'] = "Por favor, establ�zcalos de forma manual.";
    $text['folder'] = "Carpeta";
    $text['created'] = "se ha creado";
    $text['nocreate'] = "no pudo crearse. Por favor, crearla de forma manual.";
    $text['infosaved'] = "�Informaci�n guardada, conexi�n verificada!";
    $text['tablescr'] = "�Las tablas han sido creadas!";
    $text['notables'] = "Las siguientes tablas no se pudieron crear:";
    $text['nocomm'] = "TNG no se est� comunicando con su base de datos. No se creo ninguna tabla.";
    $text['newdb'] = "Informaci�n guardada, conexi�n verificada, nueva base de datos creada:";
    $text['noattach'] = "Informaci�n guardada. Conexi�n realizada y base de datos creada, pero TNG no puede comunicarse con ella.";
    $text['nodb'] = "Informaci�n guardada. Conexi�n realizada, pero la base de datos no existe y no pudo crearse aqu�. Por favor verificar que el nombre de la base de datos es correcto, o bien use su panel de control para crear la misma.";
    $text['noconn'] = "Informaci�n guardada pero fall� la conexi�n. Uno o m�s de los siguientes es incorrecto:";
    $text['exists'] = "ya existe";
    $text['loginfirst'] = "Usted debe primero ingresar.";
    $text['noop'] = "No se realiz� ninguna operaci�n.";
    //added in 8.0.0
    $text['nouser'] = "El usuario no se ha creado. Puede que el Nombre de usuario ya exista.";
    $text['notree'] = "El Arbol no se ha creado. Puede que el ID del �rbol ya exista.";
    $text['infosaved2'] = "Informaci�n guardada";
    $text['renamedto'] = "renombrado como";
    $text['norename'] = "no se pudo cambiar el nombre";
    break;

  case "imgviewer":
    $text['zoomin'] = "Acercar";
    $text['zoomout'] = "Alejar";
    $text['magmode'] = "Modo Ampliado";
    $text['panmode'] = "Modo Panor�mico";
    $text['pan'] = "Haga Clic y arrastre para moverse dentro de la imagen";
    $text['fitwidth'] = "Ajustar ancho";
    $text['fitheight'] = "Ajustar altura";
    $text['newwin'] = "Nueva ventana";
    $text['opennw'] = "Abrir imagen en nueva ventana";
    $text['magnifyreg'] = "Clic para ampliar una regi�n de la imagen";
    $text['imgctrls'] = "Habilitar Controles de Imagen";
    $text['vwrctrls'] = "Habilitar controles del Visor de Im�genes";
    $text['vwrclose'] = "Cerrar Visor de Im�genes";
    break;

  case "dna":
    $text['test_date'] = "Test date";
    $text['links'] = "Relevant links";
    $text['testid'] = "Test ID";
    //added in 12.0.0
    $text['mode_values'] = "Valores del Mode";
    $text['compareselected'] = "Compare los Seleccionados";
    $text['dnatestscompare'] = "Compare los Tests Y-DNA";
    $text['keep_name_private'] = "Deje los Nombres en Privado";
    $text['browsealltests'] = "Examinar todos los Tests";
    $text['all_dna_tests'] = "Todos los Tests DNA";
    $text['fastmutating'] = "Mutaci�n Rapida";
    $text['alltypes'] = "Todos los Tipos";
    $text['allgroups'] = "Todos los Grupos";
    $text['Ydna_LITbox_info'] = "La(s) prueba(s) vinculada(s) a esta persona no fueron tomadas necesariamente por esta persona. <br> La columna 'Haplogroup' muestra datos en rojo si el resultado es 'Predicho' o verde si la prueba est� 'Confirmada'.";
    //added in 12.1.0
    $text['dnatestscompare_mtdna'] = "Compare selected mtDNA Tests";
    $text['dnatestscompare_atdna'] = "Compare selected atDNA Tests";
    $text['chromosome'] = "Chr";
    $text['centiMorgans'] = "cM";
    $text['snps'] = "SNPs";
    $text['y_haplogroup'] = "Y-DNA";
    $text['mt_haplogroup'] = "mtDNA";
    $text['sequence'] = "Ref";
    $text['extra_mutations'] = "Extra Mutations";
    $text['mrca'] = "MRC Ancestor";
    $text['ydna_test'] = "Y-DNA Tests";
    $text['mtdna_test'] = "mtDNA (Mitochondrial) Tests";
    $text['atdna_test'] = "atDNA (autosomal) Tests";
    $text['segment_start'] = "Start";
    $text['segment_end'] = "End";
    $text['suggested_relationship'] = "Suggested";
    $text['actual_relationship'] = "Actual";
    $text['12markers'] = "Markers 1-12";
    $text['25markers'] = "Markers 13-25";
    $text['37markers'] = "Markers 26-37";
    $text['67markers'] = "Markers 38-67";
    $text['111markers'] = "Markers 68-111";
    break;
}

//common
$text['matches'] = "Coincidencias";
$text['description'] = "Descripci�n";
$text['notes'] = "Notas";
$text['status'] = "Estado";
$text['newsearch'] = "Nueva B�squeda";
$text['pedigree'] = "Arbol Geneal�gico";
$text['seephoto'] = "Ver foto";
$text['andlocation'] = "&amp; ubicaci�n";
$text['accessedby'] = "consultado por";
$text['family'] = "Familia"; //from getperson
$text['children'] = "Hijos";  //from getperson
$text['tree'] = "Arbol";
$text['alltrees'] = "Todos los Arboles";
$text['nosurname'] = "[sin apellido]";
$text['thumb'] = "Miniatura";  //as in Thumbnail
$text['people'] = "Personas";
$text['title'] = "T�tulo";  //from getperson
$text['suffix'] = "Sufijo";  //from getperson
$text['nickname'] = "Apodo";  //from getperson
$text['lastmodified'] = "�ltima Modificaci�n";  //from getperson
$text['married'] = "Casado";  //from getperson
//$text['photos'] = "Photos";
$text['name'] = "Nombre"; //from showmap
$text['lastfirst'] = "Apellido, Nombre(s)";  //from search
$text['bornchr'] = "Nacido/Bautizado";  //from search
$text['individuals'] = "Individuos";  //from whats new
$text['families'] = "Familias";
$text['personid'] = "ID Persona";
$text['sources'] = "Fuentes";  //from getperson (next several)
$text['unknown'] = "Desconocido";
$text['father'] = "Padre";
$text['mother'] = "Madre";
$text['christened'] = "Bautismo";
$text['died'] = "Fallecimiento";
$text['buried'] = "Enterrado/a";
$text['spouse'] = "C�nyuge";  //from search
$text['parents'] = "Padres";  //from pedigree
$text['text'] = "Texto";  //from sources
$text['language'] = "Idioma";  //from languages
$text['descendchart'] = "Descendientes";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Individuo";
$text['edit'] = "Editar";
$text['date'] = "Fecha";
$text['place'] = "Lugar";
$text['login'] = "Ingresar";
$text['logout'] = "Salir";
$text['groupsheet'] = "Hoja del Grupo";
$text['text_and'] = "y";
$text['generation'] = "Generaci�n";
$text['filename'] = "Nombre de archivo";
$text['id'] = "ID";
$text['search'] = "Buscar";
$text['user'] = "Usuario";
$text['firstname'] = "Nombre";
$text['lastname'] = "Apellido";
$text['searchresults'] = "Resultados de la B�squeda";
$text['diedburied'] = "Fallecido/Enterrado";
$text['homepage'] = "Inicio";
$text['find'] = "Buscando...";
$text['relationship'] = "Parentesco";    //in German, Verwandtschaft
$text['relationship2'] = "Relaci�n"; //different in some languages, at least in German (Beziehung)
$text['timeline'] = "Cronolog�a";
$text['yesabbr'] = "Si";               //abbreviation for 'yes'
$text['divorced'] = "Divorcio";
$text['indlinked'] = "Vinculado a";
$text['branch'] = "Rama";
$text['moreind'] = "M�s individuos";
$text['morefam'] = "M�s familias";
$text['source'] = "Fuente";
$text['surnamelist'] = "�ndice de apellidos";
$text['generations'] = "Generaciones";
$text['refresh'] = "Refrescar";
$text['whatsnew'] = "Novedades";
$text['reports'] = "Reportes";
$text['placelist'] = "Lista de Lugares";
$text['baptizedlds'] = "Bautismo (LDS)";
$text['endowedlds'] = "Investido (LDS)";
$text['sealedplds'] = "Sellado P (LDS)";
$text['sealedslds'] = "Sellado C (LDS)";
$text['ancestors'] = "Antepasados";
$text['descendants'] = "Descendientes";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Fecha �ltima importaci�n GEDCOM";
$text['type'] = "Tipo";
$text['savechanges'] = "Guardar Cambios";
$text['familyid'] = "ID Familia";
$text['headstone'] = "Lapidas";
$text['historiesdocs'] = "Historias";
$text['anonymous'] = "an�nimos";
$text['places'] = "Lugares";
$text['anniversaries'] = "Fechas y aniversarios";
$text['administration'] = "Administraci�n";
$text['help'] = "Ayuda";
//$text['documents'] = "Documents";
$text['year'] = "A�o";
$text['all'] = "Todos";
$text['repository'] = "Repositorio";
$text['address'] = "Direcci�n";
$text['suggest'] = "Sugerir";
$text['editevent'] = " Sugiera un cambio para este evento";
$text['findplaces'] = "Buscar todos los individuos que registran eventos en este lugar.";
$text['morelinks'] = "M�s Enlaces";
$text['faminfo'] = "Informaci�n Familiar";
$text['persinfo'] = "Informaci�n Personal";
$text['srcinfo'] = "Fuente de la informaci�n";
$text['fact'] = "Hecho";
$text['goto'] = "Seleccione una p�gina";
$text['tngprint'] = "Imprimir";
$text['databasestatistics'] = "Estad�sticas"; //needed to be shorter to fit on menu
$text['child'] = "Hijos";  //from familygroup
$text['repoinfo'] = "Informaci�n Repositorio ";
$text['tng_reset'] = "Reiniciar";
$text['noresults'] = "No se encontraron resultados";
$text['allmedia'] = "Todos los Medios";
$text['repositories'] = "Repositorios";
$text['albums'] = "�lbumes";
$text['cemeteries'] = "Cementerios";
$text['surnames'] = "Apellidos";
$text['dates'] = "Fechas";
$text['link'] = "Enlaces";
$text['media'] = "Medios";
$text['gender'] = "Sexo";
$text['latitude'] = "Latitud";
$text['longitude'] = "Longitud";
$text['bookmarks'] = "Favoritos";
$text['bookmark'] = "A�adir a Favoritos";
$text['mngbookmarks'] = "Ir a Favoritos";
$text['bookmarked'] = "Favorito A�adido";
$text['remove'] = "Quitar";
$text['find_menu'] = "Buscar";
$text['info'] = "Info"; //this needs to be a very short abbreviation
$text['cemetery'] = "Cementerio";
$text['gmapevent'] = "Mapa del Evento";
$text['gevents'] = "Evento";
$text['glang'] = "&amp;hl=es";
$text['googleearthlink'] = "Enlace a Google Earth";
$text['googlemaplink'] = "Enlace a Google Maps";
$text['gmaplegend'] = "Leyenda del Marcador";
$text['unmarked'] = "Sin marcar";
$text['located'] = "Ubicado";
$text['albclicksee'] = "Clic para ver todos los items en este �lbum";
$text['notyetlocated'] = "Todav�a sin ubicar";
$text['cremated'] = "Cremado";
$text['missing'] = "Falta";
$text['pdfgen'] = "Generador PDF";
$text['blank'] = "Cuadro Vac�o";
$text['none'] = "Ninguno";
$text['fonts'] = "Tipograf�a";
$text['header'] = "Encabezado";
$text['data'] = "Datos";
$text['pgsetup'] = "Configurar P�gina";
$text['pgsize'] = "Tama�o P�gina";
$text['orient'] = "Orientaci�n"; //for a page
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
$text['ourpages'] = "Paginas Geneal�gicas de Nuestra Familia";
$text['pwrdby'] = "Este sitio est� desarrollado por";
$text['writby'] = "escrito por";
$text['searchtngnet'] = "Buscar en TNG Network (GENDEX)";
$text['viewphotos'] = "Ver todas las fotos";
$text['anon'] = "Actualmente aparece como an�nimo";
$text['whichbranch'] = "�De qu� rama es usted?";
$text['featarts'] = "Art�culos Destacados";
$text['maintby'] = "Mantenido por";
$text['createdon'] = "Creado en";
$text['reliability'] = "Confiabilidad";
$text['labels'] = "Etiquetas";
$text['inclsrcs'] = "Incluir Fuentes";
$text['cont'] = "(cont.)"; //abbreviation for continued
$text['mnuheader'] = "P�gina de Inicio";
$text['mnusearchfornames'] = "Buscar";
$text['mnulastname'] = "Apellido";
$text['mnufirstname'] = "Nombre";
$text['mnusearch'] = "Buscar";
$text['mnureset'] = "Borrar todo";
$text['mnulogon'] = "Ingresar";
$text['mnulogout'] = "Salir";
$text['mnufeatures'] = "Otras caracter�sticas";
$text['mnuregister'] = "Solicitar Cuenta de Usuario";
$text['mnuadvancedsearch'] = "B�squeda Avanzada";
$text['mnulastnames'] = "Apellidos";
$text['mnustatistics'] = "Estad�sticas";
$text['mnuphotos'] = "Fotos";
$text['mnuhistories'] = "Historias";
$text['mnumyancestors'] = "Fotos &amp; Historias para los Ancestros de [Person]";
$text['mnucemeteries'] = "Cementerios";
$text['mnutombstones'] = "L�pidas";
$text['mnureports'] = "Reportes";
$text['mnusources'] = "Fuentes";
$text['mnuwhatsnew'] = "Novedades";
$text['mnushowlog'] = "Registro de Ingresos";
$text['mnulanguage'] = "Cambiar Idioma";
$text['mnuadmin'] = "Administraci�n";
$text['welcome'] = "Bienvenido";
$text['contactus'] = "Contacto";
//changed in 8.0.0
$text['born'] = "Nacimiento";
$text['searchnames'] = "Buscar Personas";
//added in 8.0.0
$text['editperson'] = "Editar Persona";
$text['loadmap'] = "Cargar el mapa";
$text['birth'] = "Nacimiento";
$text['wasborn'] = "Naci�";
$text['startnum'] = "Primer N�mero";
$text['searching'] = "Buscando";
//moved here in 8.0.0
$text['location'] = "Localidad";
$text['association'] = "Asociaci�n";
$text['collapse'] = "Contraer";
$text['expand'] = "Expandir";
$text['plot'] = "Parcela";
$text['searchfams'] = "Buscar Familias";
//added in 8.0.2
$text['wasmarried'] = "Casado";
$text['anddied'] = "Fallecimiento";
//added in 9.0.0
$text['share'] = "Compartir";
$text['hide'] = "Esconder";
$text['disabled'] = "Su cuenta de usuario fue des-habilitada. Por favor haga contacto con el administrador por m�s informaci�n.";
$text['contactus_long'] = "Si usted tiene alguna pregunta o comentario respecto a la informaci�n existente en este sitio web, por favor p�ngase en <span class=\"emphasis\"><a href=\"suggest.php\">contacto</a></span> con nosotros.";
$text['features'] = "Caracter�sticas";
$text['resources'] = "Recursos";
$text['latestnews'] = "�ltimas Noticias";
$text['trees'] = "�rboles";
$text['wasburied'] = "fue sepultado";
//moved here in 9.0.0
$text['emailagain'] = "Email de nuevo";
$text['enteremail2'] = "Por favor, introduzca su direcci�n de email de nuevo";
$text['emailsmatch'] = "Tu emails no coinciden. Por favor, introduzca la misma direcci�n en cada campo";
$text['getdirections'] = "Clic para conseguir direcciones";
$text['calendar'] = "Calendario";
//changed in 9.0.0
$text['directionsto'] = " al ";
$text['slidestart'] = "Mostrar como diapositivas";
$text['livingnote'] = "Al menos un individuo vivo est� vinculado a esta nota - Detalles Reservados.";
$text['livingphoto'] = "Al menos un individuo vivo est� vinculado a este �tem - Detalles Reservados.";
$text['waschristened'] = "Bautismo";
//added in 10.0.0
$text['branches'] = "Ramas";
$text['detail'] = "Detalles";
$text['moredetail'] = "M�s detalles";
$text['lessdetail'] = "Menos detalles";
$text['otherevents'] = "Otros Eventos";
$text['conflds'] = "Confirmado (LDS)";
$text['initlds'] = "Iniciado (LDS)";
$text['wascremated'] = "fue cremado";
//moved here in 11.0.0
$text['text_for'] = "para";
//added in 11.0.0
$text['searchsite'] = "Busque en este sitio";
$text['searchsitemenu'] = "Buscar en el sitio";
$text['kmlfile'] = "Descarque un archivo .kml para mostrar su ubicaci�n en Google Earth";
$text['download'] = "Click para descargar";
$text['more'] = "Mas";
$text['heatmap'] = "Mapa de Calor";
$text['refreshmap'] = "Refrescar Mapa";
$text['remnums'] = "Borre Numeros y Pines";
$text['photoshistories'] = "Photos &amp; Histories";
$text['familychart'] = "Family Chart";
//added in 12.0.0
$text['firstnames'] = "Nombres";
//moved here in 12.0.0
$text['dna_test'] = "DNA Test";
$text['test_type'] = "Tipo de Test";
$text['test_info'] = "Informacion del Test";
$text['takenby'] = "Taken by";
$text['haplogroup'] = "Haplogroupo";
$text['hvr1'] = "HVR1";
$text['hvr2'] = "HVR2";
$text['relevant_links'] = "Enlaces relevantes";
$text['nofirstname'] = "[no hay nombre]";
//added in 12.0.1
$text['cookieuse'] = "Nota: Este sitio usa cookies.";
$text['dataprotect'] = "Politica de Proteccion de Datos";
$text['viewpolicy'] = "Ver Politica";
$text['understand'] = "Yo entiendo";
$text['consent'] = "Doy mi consentimiento a este sitio para almacenar la informacion personal recogida aqui. Yo entiendo que puedo solicitarle al due�o del sitio que quite la informacion en cualquier momento.";
$text['consentreq'] = "Por favor de su consentimiento a este sitio para almacenar informaci�n personal.";

//added in 12.1.0
$text['testsarelinked'] = "DNA tests are associated with";
$text['testislinked'] = "DNA test is associated with";

//added in 12.2
$text['quicklinks'] = "Enlaces r�pidos";
$text['yourname'] = "Tu nombre";
$text['youremail'] = "Su direcci�n de correo electr�nico";
$text['liketoadd'] = "Cualquier informaci�n que desee agregar";
$text['webmastermsg'] = "Mensaje de webmaster";
$text['gallery'] = "Ver galer�a";
$text['wasborn_male'] = "naci�";    // same as $text['wasborn'] if no gender verb
$text['wasborn_female'] = "naci�";  // same as $text['wasborn'] if no gender verb
$text['waschristened_male'] = "fue bautizado";  // same as $text['waschristened'] if no gender verb
$text['waschristened_female'] = "fue bautizada";  // same as $text['waschristened'] if no gender verb
$text['died_male'] = "falleci�";  // same as $text['anddied'] of no gender verb
$text['died_female'] = "falleci�";  // same as $text['anddied'] of no gender verb
$text['wasburied_male'] = "fue sepultado";  // same as $text['wasburied'] if no gender verb
$text['wasburied_female'] = "fue sepultada";  // same as $text['wasburied'] if no gender verb
$text['wascremated_male'] = "fue incinerado";    // same as $text['wascremated'] if no gender verb
$text['wascremated_female'] = "fue incinerada";  // same as $text['wascremated'] if no gender verb
$text['wasmarried_male'] = "casado";  // same as $text['wasdmarried'] if no gender verb
$text['wasmarried_female'] = "casado";  // same as $text['wasdmarried'] if no gender verb
$text['wasdivorced_male'] = "se divorci�";  // might be the same as $text['divorce'] but as a verb
$text['wasdivorced_female'] = "se divorci�";  // might be the same as $text['divorce'] but as a verb
$text['inplace'] = " en ";      // used as a preposition to the location
$text['onthisdate'] = " en ";    // when used with full date
$text['inthisyear'] = " en ";    // when used with year only or month / year dates
$text['and'] = "and ";    // used in conjunction with wasburied or was cremated

//moved here in 12.3
$text['dna_info_head'] = "Informacion del Test DNA";
$text['firstpage'] = "Primera P�gina";
$text['lastpage'] = "�ltima P�gina";

@include_once "captcha_text.php";
@include_once "alltext.php";
if (!$alltextloaded) {
  getAllTextPath();
}

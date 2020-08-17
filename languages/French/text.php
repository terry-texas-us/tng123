<?php
switch ($textpart) {
  //browsesources.php, showsource.php
  case "sources":
    $text['browseallsources'] = "Toutes les sources";
    $text['shorttitle'] = "Titre court";
    $text['callnum'] = "Num�ro d'archive";
    $text['author'] = "Auteur";
    $text['publisher'] = "�diteur";
    $text['other'] = "Autre information";
    $text['sourceid'] = "ID de la source";
    $text['moresrc'] = "Autres sources";
    $text['repoid'] = "ID du lieu des Archives";
    $text['browseallrepos'] = "Rechercher les lieux des Archives";
    break;

  //changelanguage.php, savelanguage.php
  case "language":
    $text['newlanguage'] = "Nouvelle langue";
    $text['changelanguage'] = "Changer la Langue";
    $text['languagesaved'] = "Langue enregistr�e";
    $text['sitemaint'] = "Site en cours de maintenance";
    $text['standby'] = "Notre site est temporairement hors service pendant que nous mettons � jour notre base de donn�es. Merci de r�essayer dans quelques minutes. Si notre site demeure inaccessible pendant une p�riode prolong�e, vous pouvez <a href=\"suggest.php\">contacter son propri�taire</a>.";
    break;

  //gedcom.php, gedform.php
  case "gedcom":
    $text['gedstart'] = "GEDCOM commence � partir de";
    $text['producegedfrom'] = "G�n�rer un fichier GEDCOM � partir de";
    $text['numgens'] = "Nombre de g�n�rations";
    $text['includelds'] = "Inclure les informations SDJ";
    $text['buildged'] = "Construire GEDCOM";
    $text['gedstartfrom'] = "GEDCOM � partir de";
    $text['nomaxgen'] = "Vous devez sp�cifier un nombre maximum de g�n�rations. Merci de cliquer sur le bouton 'Pr�c�dent' et corriger l'erreur";
    $text['gedcreatedfrom'] = "GEDCOM cr�� � partir de";
    $text['gedcreatedfor'] = "cr�� pour";
    $text['creategedfor'] = "Cr�er un fichier GEDCOM";
    $text['email'] = "Adresse de courriel";
    $text['suggestchange'] = "Sugg�rer une modification";
    $text['yourname'] = "Votre nom";
    $text['comments'] = "Notes ou Commentaires";
    $text['comments2'] = "Commentaires";
    $text['submitsugg'] = "Soumettre une suggestion";
    $text['proposed'] = "Modification propos�e";
    $text['mailsent'] = "Merci. Votre message a �t� envoy�.";
    $text['mailnotsent'] = "D�sol�, mais votre message n'a pu �tre envoy�. Merci de contacter directement xxx � yyy";
    $text['mailme'] = "Envoyer une copie � cette addresse";
    $text['entername'] = "Merci de saisir votre nom";
    $text['entercomments'] = "Merci de saisir vos commentaires";
    $text['sendmsg'] = "Envoyer le message";
    //added in 9.0.0
    $text['subject'] = "Objet";
    break;

  //getextras.php, getperson.php
  case "getperson":
    $text['photoshistoriesfor'] = "Photos et historique de";
    $text['indinfofor'] = "Info personnelle concernant";
    $text['pp'] = "pp."; //page abbreviation
    $text['age'] = "� l'�ge de";
    $text['agency'] = "Agence";
    $text['cause'] = "Cause";
    $text['suggested'] = "Sugg�r�";
    $text['closewindow'] = "Fermer cette fen�tre";
    $text['thanks'] = "Merci";
    $text['received'] = "Le changement que vous avez propos� sera inclus apr�s v�rification par l'administrateur du site.";
    $text['indreport'] = "Rapport individuel";
    $text['indreportfor'] = "Rapport individuel pour";
    $text['general'] = "G�n�ralit�s";
    $text['bkmkvis'] = "<strong>Note:</strong> Ces signets sont seulement visibles sur cet ordinateur et avec ce navigateur.";
    //added in 9.0.0
    $text['reviewmsg'] = "Vous avez une proposition de modification qui n�cessite une v�rification de votre part. Cette proposition concerne:";
    $text['revsubject'] = "Le changement propos� n�cessite une v�rification de votre part";
    break;

  //relateform.php, relationship.php, findpersonform.php, findperson.php
  case "relate":
    $text['relcalc'] = "Calculateur de liens de parent�";
    $text['findrel'] = "Recherche de liens de parent�";
    $text['person1'] = "Personne 1:";
    $text['person2'] = "Personne 2:";
    $text['calculate'] = "Calcul";
    $text['select2inds'] = "S�lectionner deux individus.";
    $text['findpersonid'] = "Trouver l'ID de la personne";
    $text['enternamepart'] = "Saisir le pr�nom ou le nom de famille ";
    $text['pleasenamepart'] = "Merci de saisir le pr�nom ou le nom de famille.";
    $text['clicktoselect'] = "Cliquer pour s�lectionner";
    $text['nobirthinfo'] = "Pas de donn�es de naissance";
    $text['relateto'] = "Liens de parent� avec";
    $text['sameperson'] = "Les deux individus sont identiques";
    $text['notrelated'] = "Les deux individus n'ont pas de lien de parent� sur xxx g�n�rations."; //xxx will be replaced with number of generations
    $text['findrelinstr'] = "Pour afficher les liens de parent� entre deux personnes, utiliser le bouton 'Recherche' ci-dessous pour trouver les individus (ou conserver les individus affich�s), ensuite cliquer sur 'Calculer'.";
    $text['sometimes'] = "(Parfois le fait de v�rifier un autre nombre de g�n�rations donne un r�sultat diff�rent)";
    $text['findanother'] = "Trouver un autre lien";
    $text['brother'] = "le fr�re de";
    $text['sister'] = "la soeur de";
    $text['sibling'] = "le fr�re ou la soeur de";
    $text['uncle'] = "le xxx oncle de";
    $text['aunt'] = "la xxx tante de";
    $text['uncleaunt'] = "le xxx oncle/tante de";
    $text['nephew'] = "le xxx neveu de";
    $text['niece'] = "la xxx ni�ce de";
    $text['nephnc'] = "le xxx neveu/ni�ce de";
    $text['removed'] = "g�n�rations de diff�rence (\"times removed\")";
    $text['rhusband'] = "l'�poux de ";
    $text['rwife'] = "l'�pouse de ";
    $text['rspouse'] = "le conjoint de ";
    $text['son'] = "le fils de";
    $text['daughter'] = "la fille de";
    $text['rchild'] = "l'enfant de";
    $text['sil'] = "le gendre de";
    $text['dil'] = "la bru de";
    $text['sdil'] = "le gendre ou la bru de";
    $text['gson'] = "le xxx petit-fils de";
    $text['gdau'] = "la xxx petite-fille de";
    $text['gsondau'] = "le xxx petit-fils/petite-fille de";
    $text['great'] = "arri�re";
    $text['spouses'] = "sont conjoints";
    $text['is'] = "est";
    $text['changeto'] = "Changer en:";
    $text['notvalid'] = "n'est pas un ID valide ou n'existe pas dans cette base de donn�es. Merci de r�essayer.";
    $text['halfbrother'] = "le demi-fr�re de ";
    $text['halfsister'] = "la demi-soeur de ";
    $text['halfsibling'] = "demi fr�re/soeur de";
    //changed in 8.0.0
    $text['gencheck'] = "G�n�rations max <br />� investiguer";
    $text['mcousin'] = "le xxx cousin yyy de";  //male cousin; xxx = cousin number, yyy = times removed
    $text['fcousin'] = "la xxx cousine yyy de";  //female cousin
    $text['cousin'] = "le xxx cousin yyy de";
    $text['mhalfcousin'] = "le xxx demi cousin  yyy de";  //male cousin
    $text['fhalfcousin'] = "la xxx demi cousine yyy de";  //female cousin
    $text['halfcousin'] = "le xxx demi cousin  yyy de";
    //added in 8.0.0
    $text['oneremoved'] = "au premier degr�";
    $text['gfath'] = "le grand-p�re";
    $text['gmoth'] = "la grand-m�re";
    $text['gpar'] = "les grands-parents";
    $text['mothof'] = "la m�re de";
    $text['fathof'] = "le p�re de";
    $text['parof'] = "le parent de";
    $text['maxrels'] = "nombre maximal de relations � voir";
    $text['dospouses'] = "voir les relations comprenant un �poux/une �pouse";
    $text['rels'] = "relations";
    $text['dospouses2'] = "voir les �pouses";
    $text['fil'] = "le beau-p�re de";
    $text['mil'] = "la belle-m�re de";
    $text['fmil'] = "le beau-p�re ou bell- m�re de";
    $text['stepson'] = "le beau-fils de";
    $text['stepdau'] = "la belle-fille de";
    $text['stepchild'] = "le beau-fils / belle-fille de";
    $text['stepgson'] = "le xxx arri�re beau-petit-fils de";
    $text['stepgdau'] = "la xxx arri�re belle-petite-fille de";
    $text['stepgchild'] = "le xxx arri�re-beau-petit-fils / belle-petite-fille de";
    //added in 8.1.1
    $text['ggreat'] = "arri�re";
    //added in 8.1.2
    $text['ggfath'] = "le xxx arri�re-grand-p�re de";
    $text['ggmoth'] = "la xxx arri�re-grand-m�re de";
    $text['ggpar'] = "les xxx arri�re-grands-parents de";
    $text['ggson'] = "le xxx petit-fils de";
    $text['ggdau'] = "la xxx petite-fille";
    $text['ggsondau'] = "le xxx petit-enfant de";
    $text['gstepgson'] = "le xxx petit-fils de";
    $text['gstepgdau'] = "la xxx petite-fille";
    $text['gstepgchild'] = "le xxx petit-enfant de";
    $text['guncle'] = "le xxx grand-oncle de";
    $text['gaunt'] = "la xxx grande-tante de";
    $text['guncleaunt'] = "xxx grand-oncle / grande-tante de";
    $text['gnephew'] = "le xxx petit-neveu de";
    $text['gniece'] = "la xxx petite-ni�ce de";
    $text['gnephnc'] = "xxx petit-neveu ou petite-ni�ce de";
    break;

  case "familygroup":
    $text['familygroupfor'] = "Page de la famille de";
    $text['ldsords'] = "Ordonnances SDJ";
    $text['baptizedlds'] = "Baptis� (SDJ)";
    $text['endowedlds'] = "Dot� (SDJ)";
    $text['sealedplds'] = "Dot� parents (SDJ)";
    $text['sealedslds'] = "Conjoint(e) dot�(e) (SDJ)";
    $text['otherspouse'] = "Autre conjoint(e)";
    $text['husband'] = "Mari";
    $text['wife'] = "Femme";
    break;

  //pedigree.php
  case "pedigree":
    $text['capbirthabbr'] = "N";
    $text['capaltbirthabbr'] = "A";
    $text['capdeathabbr'] = "D";
    $text['capburialabbr'] = "E";
    $text['capplaceabbr'] = "L";
    $text['capmarrabbr'] = "M";
    $text['capspouseabbr'] = "�P.";
    $text['redraw'] = "Redessiner avec";
    $text['scrollnote'] = "Note : Utiliser les barres de d�filement pour voir tout l'arbre.";
    $text['unknownlit'] = "Inconnu";
    $text['popupnote1'] = " = Information suppl�mentaire";
    $text['popupnote2'] = " = Nouvel arbre";
    $text['pedcompact'] = "Compact";
    $text['pedstandard'] = "Standard";
    $text['pedtextonly'] = "Texte seul";
    $text['descendfor'] = "Descendance de";
    $text['maxof'] = "Maximum de";
    $text['gensatonce'] = "g�n�rations affich�es en m�me temps";
    $text['sonof'] = "fils de";
    $text['daughterof'] = "fille de";
    $text['childof'] = "enfant de";
    $text['stdformat'] = "Format standard";
    $text['ahnentafel'] = "Ahnentafel";
    $text['addnewfam'] = "Ajouter une nouvelle famille";
    $text['editfam'] = "Editer la famille";
    $text['side'] = "(Ascendants)";
    $text['familyof'] = "Famille de";
    $text['paternal'] = "Paternel";
    $text['maternal'] = "Maternel";
    $text['gen1'] = "Soi-m�me";
    $text['gen2'] = "Parents";
    $text['gen3'] = "Grand-parents (A�euls)";
    $text['gen4'] = "Bisa�euls ";
    $text['gen5'] = "Trisa�euls";
    $text['gen6'] = "Quatri�mes a�euls";
    $text['gen7'] = "Cinqui�mes a�euls";
    $text['gen8'] = "Sixi�mes a�euls";
    $text['gen9'] = "Septi�mes a�euls";
    $text['gen10'] = "Huiti�mes a�euls";
    $text['gen11'] = "Neuvi�mes a�euls";
    $text['gen12'] = "Dixi�mes a�euls";
    $text['graphdesc'] = "Tableau de descendance jusqu'� ce point";
    $text['pedbox'] = "Bo�te";
    $text['regformat'] = "Format registre";
    $text['extrasexpl'] = "Si des photos ou des histoires existent pour les individus suivants, les ic�nes correspondantes seront affich�es � c�t� des noms.";
    $text['popupnote3'] = " = Nouveau tableau";
    $text['mediaavail'] = "M�dia disponible";
    $text['pedigreefor'] = "Arbre de";
    $text['pedigreech'] = "Tableau des anc�tres";
    $text['datesloc'] = "Dates et lieux";
    $text['borchr'] = "Naissance/Alt - Mort/Enterrement (deux)";
    $text['nobd'] = "Aucune date de naissance ou de mort";
    $text['bcdb'] = "Naissance/Alt/Mort/Enterrement (quatre)";
    $text['numsys'] = "Syst�me de num�rotation";
    $text['gennums'] = "Num�rotations de g�n�rations";
    $text['henrynums'] = "Num�rotation Henry";
    $text['abovnums'] = "Num�rotation d'Aboville";
    $text['devnums'] = "Num�rotation de Villiers";
    $text['dispopts'] = "Options d'affichage";
    //added in 10.0.0
    $text['no_ancestors'] = "Aucun ascendant";
    $text['ancestor_chart'] = "Tableau d'ascendance";
    $text['opennewwindow'] = "Ouvrir dans un nouvel onglet";
    $text['pedvertical'] = "Vertical";
    //added in 11.0.0
    $text['familywith'] = "famille avec";
    $text['fcmlogin'] = "Connectez-vous pour voir les d�tails";
    $text['isthe'] = "est le";
    $text['otherspouses'] = "autres conjoints";
    $text['parentfamily'] = "La famille des parents ";
    $text['showfamily'] = "Afficher la famille";
    $text['shown'] = "affich�";
    $text['showparentfamily'] = "Afficher la famille des parents";
    $text['showperson'] = "Afficher la personne";
    //added in 11.0.2
    $text['otherfamilies'] = "Autres familles";
    break;

  //search.php, searchform.php
  //merged with reports and showreport in 5.0.0
  case "search":
  case "reports":
    $text['noreports'] = "Aucun rapport.";
    $text['reportname'] = "Nom du rapport";
    $text['allreports'] = "Tous les rapports";
    $text['report'] = "Rapport";
    $text['error'] = "Erreur";
    $text['reportsyntax'] = "La syntaxe de cette requ�te";
    $text['wasincorrect'] = "est incorrecte, et le rapport n'a pu �tre lanc�. Merci de contacter votre administrateur syst�me �";
    $text['errormessage'] = "Message d'erreur";
    $text['equals'] = "�gal";
    $text['endswith'] = "se termine par";
    $text['soundexof'] = "soundex de";
    $text['metaphoneof'] = "m�taphone de";
    $text['plusminus10'] = "+/- 10 ann�es de";
    $text['lessthan'] = "inf. �";
    $text['greaterthan'] = "sup. �";
    $text['lessthanequal'] = "inf. ou �gale �";
    $text['greaterthanequal'] = "sup. ou �gale �";
    $text['equalto'] = "�gale �";
    $text['tryagain'] = "Merci de r�essayer";
    $text['joinwith'] = "Lien";
    $text['cap_and'] = "ET";
    $text['cap_or'] = "OU";
    $text['showspouse'] = "Afficher le conjoint(e) (La personne sera r�p�t�e pour chaque conjoint)";
    $text['submitquery'] = "Rechercher";
    $text['birthplace'] = "Lieu de naissance";
    $text['deathplace'] = "Lieu de d�c�s";
    $text['birthdatetr'] = "Ann�e de naissance";
    $text['deathdatetr'] = "Ann�e de d�c�s";
    $text['plusminus2'] = "+/- 2 ans de";
    $text['resetall'] = "R�initialiser toutes les valeurs";
    $text['showdeath'] = "Afficher l'information sur le d�c�s ou l'inhumation";
    $text['altbirthplace'] = "Lieu de bapt�me";
    $text['altbirthdatetr'] = "Ann�e de bapt�me";
    $text['burialplace'] = "Lieu de la s�pulture";
    $text['burialdatetr'] = "Ann�e de la s�pulture";
    $text['event'] = "�v�nement(s)";
    $text['day'] = "Jour";
    $text['month'] = "Mois";
    $text['keyword'] = "Mot-clef (par exemple, \"Vers\")";
    $text['explain'] = "Saisir les dates pour voir les �v�nements correspondants. Laisser un champ vide pour voir toutes les correspondances.";
    $text['enterdate'] = "Saisir ou s�lectionner au moins un des �l�ments suivants: Jour, Mois, Ann�e, Mot-Clef:";
    $text['fullname'] = "Nom entier";
    $text['birthdate'] = "Date de naissance";
    $text['altbirthdate'] = "Date de bapt�me";
    $text['marrdate'] = "Date de Mariage";
    $text['spouseid'] = "ID de l'�pouse";
    $text['spousename'] = "Nom de l'�pouse";
    $text['deathdate'] = "Date de d�c�s";
    $text['burialdate'] = "Date de la s�pulture";
    $text['changedate'] = "Date de la derni�re modification";
    $text['gedcom'] = "Arbre";
    $text['baptdate'] = "Date de bapt�me (SDJ)";
    $text['baptplace'] = "Lieu de bapt�me (SDJ)";
    $text['endldate'] = "Date de confirmation (SDJ)";
    $text['endlplace'] = "Lieu de confirmation (SDJ)";
    $text['ssealdate'] = "Date du sceau S (SDJ)";   //Sealed to spouse
    $text['ssealplace'] = "Lieu du sceau S (SDJ)";
    $text['psealdate'] = "Date du sceau (SDJ)";   //Sealed to parents
    $text['psealplace'] = "Lieu du Sceau P (SDJ)";
    $text['marrplace'] = "Lieu du mariage";
    $text['spousesurname'] = "Nom de famille de l'�pouse";
    $text['spousemore'] = "Si vous entrez une valeur pour le nom de famille de l'�pouse, vous devez s�lectionner un sexe";
    $text['plusminus5'] = "+/- 5 ans de";
    $text['exists'] = "est d�j� cr��.";
    $text['dnexist'] = "n'existe pas";
    $text['divdate'] = "Date du divorce";
    $text['divplace'] = "Lieu du divorce";
    $text['otherevents'] = "Autres faits";
    $text['numresults'] = "R�sultats par page";
    $text['mysphoto'] = "Photos myst�res";
    $text['mysperson'] = "Qui sont ces personnes ?";
    $text['joinor'] = "L'option 'Lien avec OU' ne peut pas �tre employ�e avec le nom de famille du conjoint";
    $text['tellus'] = "Dites-nous ce que vous savez";
    $text['moreinfo'] = "Plus d'informations :";
    //added in 8.0.0
    $text['marrdatetr'] = "Ann�e de mariage";
    $text['divdatetr'] = "Ann�e de divorce";
    $text['mothername'] = "Nom de la m�re";
    $text['fathername'] = "Nom du p�re";
    $text['filter'] = "filtrage";
    $text['notliving'] = "d�c�d�s";
    $text['nodayevents'] = "�v�nments de ce mois non associ�s � un jour sp�cifique";
    //added in 9.0.0
    $text['csv'] = "Fichier CSV d�limit� par des virgules";
    //added in 10.0.0
    $text['confdate'] = "Date de confirmation (SDJ)";
    $text['confplace'] = "Lieu de confirmation (SDJ)";
    $text['initdate'] = "Date d'initiation (SDJ)";
    $text['initplace'] = "Lieu d'initiation (SDJ)";
    //added in 11.0.0
    $text['marrtype'] = "Type de Mariage";
    $text['searchfor'] = "Rechercher";
    $text['searchnote'] = "Note: Cette page utilise Google pour effectuer sa recherche. Le nombre de r�sultats obtenus sera directement affect� par la facult� d'indexation du site par Google.";
    break;

  //showlog.php
  case "showlog":
    $text['logfilefor'] = "Fichier journal pour";
    $text['mostrecentactions'] = "Derni�res actions";
    $text['autorefresh'] = "Rafra�chissement automatique (30 secondes)";
    $text['refreshoff'] = "Supprimer le rafra�chissement automatique";
    break;

  case "headstones":
  case "showphoto":
    $text['cemeteriesheadstones'] = "Cimeti�res et Pierres tombales";
    $text['showallhsr'] = "Afficher tous les enregistrements de pierres tombales";
    $text['in'] = "en";
    $text['showmap'] = "Afficher la carte";
    $text['headstonefor'] = "Tombe de";
    $text['photoof'] = "Photo de";
    $text['firstpage'] = "Premi�re page";
    $text['lastpage'] = "Derni�re page";
    $text['photoowner'] = "Source ou propri�taire";
    $text['nocemetery'] = "Pas de cimeti�re";
    $text['iptc005'] = "Titre";
    $text['iptc020'] = "Cat�gories suppl�mentaires";
    $text['iptc040'] = "Instructions sp�ciales";
    $text['iptc055'] = "Date de cr�ation";
    $text['iptc080'] = "Auteur";
    $text['iptc085'] = "Position de l'auteur";
    $text['iptc090'] = "Ville";
    $text['iptc095'] = "Etat";
    $text['iptc101'] = "Pays";
    $text['iptc103'] = "OTR";
    $text['iptc105'] = "Titre";
    $text['iptc110'] = "Source";
    $text['iptc115'] = "Source de la photo";
    $text['iptc116'] = "Notice de droit d'auteur";
    $text['iptc120'] = "Sous-titre";
    $text['iptc122'] = "Auteur du sous-titre";
    $text['mapof'] = "Carte de";
    $text['regphotos'] = "Vue Descriptive";
    $text['gallery'] = "Uniquement les vignettes";
    $text['cemphotos'] = "Photos du cimeti�res";
    $text['photosize'] = "Taille";
    $text['iptc010'] = "Priorit�";
    $text['filesize'] = "Taille du fichier";
    $text['seeloc'] = "Voir le lieu";
    $text['showall'] = "Tout afficher";
    $text['editmedia'] = "�dite le m�dia";
    $text['viewitem'] = "Voir cet item";
    $text['editcem'] = "�dite le cimeti�re";
    $text['numitems'] = "# Items";
    $text['allalbums'] = "tous les albums";
    $text['slidestop'] = "Arr�ter le diaporama";
    $text['slideresume'] = "Reprendre le diaporama";
    $text['slidesecs'] = "Secondes pour chaque diapositive:";
    $text['minussecs'] = "moins 0,5 seconde";
    $text['plussecs'] = "plus 0,5 seconde";
    $text['nocountry'] = "Pays inconnu";
    $text['nostate'] = "�tat inconnu";
    $text['nocounty'] = "Comt� inconnu";
    $text['nocity'] = "Ville inconnue";
    $text['nocemname'] = "Nom du cimeti�re inconnu";
    $text['editalbum'] = "�diter l'album";
    $text['mediamaptext'] = "<strong>Note :</strong> D�placer le pointeur de la souris sur l'image pour afficher les noms. Cliquer pour afficher une page pour chaque nom.";
    //added in 8.0.0
    $text['allburials'] = "Toutes les s�pultures";
    $text['moreinfo'] = "Plus d'informations:";
    //added in 9.0.0
    $text['iptc025'] = "Mots-clefs";
    $text['iptc092'] = "Lieu mineur";
    $text['iptc015'] = "Cat�gorie";
    $text['iptc065'] = "Programme d'origine";
    $text['iptc070'] = "Version du programme";
    break;

  //surnames.php, surnames100.php, surnames-all.php, surnames-oneletter.php
  case "surnames":
  case "places":
    $text['surnamesstarting'] = "Afficher les noms de famille commen�ant par";
    $text['showtop'] = "Afficher les ";
    $text['showallsurnames'] = "Afficher tous les noms de famille";
    $text['sortedalpha'] = "par ordre alphab�tique";
    $text['byoccurrence'] = " premiers class�s par occurrence";
    $text['firstchars'] = "Premiers cararact�res";
    $text['mainsurnamepage'] = "noms de famille";
    $text['allsurnames'] = "Tous les noms de famille";
    $text['showmatchingsurnames'] = "Cliquer sur un nom de famille pour afficher les r�sultats.";
    $text['backtotop'] = "Retour en haut de la page";
    $text['beginswith'] = "Commen�ant par";
    $text['allbeginningwith'] = "Tous les noms de famille commen�ant par";
    $text['numoccurrences'] = "nombre de r�sultats entre parenth�ses";
    $text['placesstarting'] = "Afficher les localisations les plus importantes commen�ant par";
    $text['showmatchingplaces'] = "Cliquer sur un nom pour voir les enregistrements associ�s.";
    $text['totalnames'] = "total des individus";
    $text['showallplaces'] = "Afficher les localisations les plus importantes";
    $text['totalplaces'] = "sur la totalit� des lieux";
    $text['mainplacepage'] = "Page des lieux principaux";
    $text['allplaces'] = "Toutes les localisations les plus importantes";
    $text['placescont'] = "Afficher tous les lieux qui contiennent";
    //changed in 8.0.0
    $text['top30'] = "Les xxx principaux noms de famille";
    $text['top30places'] = "Les xxx localisations les plus importantes";
    //added in 12.0.0
    $text['firstnamelist'] = "Liste des pr�noms";
    $text['firstnamesstarting'] = "Afficher les pr�noms commen�ant par";
    $text['showallfirstnames'] = "Afficher tous les pr�noms";
    $text['mainfirstnamepage'] = "Page des principaux pr�noms";
    $text['allfirstnames'] = "Tous les pr�noms";
    $text['showmatchingfirstnames'] = "Cliquer sur un pr�nom pour voir les enregistrements correspondants.";
    $text['allfirstbegwith'] = "Tous les pr�noms commen�ant par";
    $text['top30first'] = "Les xxx pr�noms les plus donn�s";
    $text['allothers'] = "Tous les autres";
    $text['amongall'] = "(parmi tous les noms)";
    $text['justtop'] = "Seulement les xxx premiers";
    break;

  //whatsnew.php
  case "whatsnew":
    $text['pastxdays'] = "(xx derniers jours)";

    $text['photo'] = "Photo";
    $text['history'] = "Histoire/Document";
    $text['husbid'] = "ID �poux";
    $text['husbname'] = "Nom de l'�poux";
    $text['wifeid'] = "ID �pouse";
    //added in 11.0.0
    $text['wifename'] = "Le nom de l'�pouse";
    break;

  //timeline.php, timeline2.php
  case "timeline":
    $text['text_delete'] = "Supprimer";
    $text['addperson'] = "Ajouter Individu";
    $text['nobirth'] = "L'individu suivant n'a pas de date de naissance valide et n'a donc pas �t� ajout�";
    $text['event'] = "�v�nement(s)";
    $text['chartwidth'] = "Largeur du graphique";
    $text['timelineinstr'] = "Ajouter des individus (saisir leur ID)";
    $text['togglelines'] = "Commuter les lignes";
    //changed in 9.0.0
    $text['noliving'] = "L'individu suivant est enregistr� comme �tant en vie ou marqu� priv� et n'est pas affich� parce que vous n'�tes pas connect� avec les autorisations n�cessaires";
    break;

  //browsetrees.php
  //login.php, newacctform.php, addnewacct.php
  case "trees":
  case "login":
    $text['browsealltrees'] = "Tous les arbres";
    $text['treename'] = "Nom de l'arbre";
    $text['owner'] = "Propri�taire";
    $text['address'] = "Adresse";
    $text['city'] = "Ville";
    $text['state'] = "�tat/Province";
    $text['zip'] = "Code Postal";
    $text['country'] = "Pays";
    $text['email'] = "Adresse de courriel";
    $text['phone'] = "T�l�phone";
    $text['username'] = "Nom d'utilisateur";
    $text['password'] = "Mot de passe";
    $text['loginfailed'] = "Erreur de connexion.";

    $text['regnewacct'] = "Enregistrement de nouveau compte utilisateur";
    $text['realname'] = "Votre nom r�el";
    $text['phone'] = "T�l�phone";
    $text['email'] = "Adresse de courriel";
    $text['address'] = "Adresse";
    $text['acctcomments'] = "Notes ou Commentaires";
    $text['submit'] = "Soumettre";
    $text['leaveblank'] = "(laisser en blanc si vous d�sirez un nouvel arbre)";
    $text['required'] = "Champs requis";
    $text['enterpassword'] = "Saisir un mot de passe.";
    $text['enterusername'] = "Saisir un nom d'utilisateur.";
    $text['failure'] = "Ce nom d'utilisateur est d�j� pris. Merci d'utiliser le bouton retour de votre navigateur pour revenir � la page pr�c�dente et s�lectionner un autre nom d'utisateur.";
    $text['success'] = "Merci. Nous avons bien re�u votre enregistrement. Nous vous contacterons quand votre compte sera activ� ou si nous avons besoin de plus d'information.";
    $text['emailsubject'] = "Demande d'enregistrement de nouvel utisateur TNG";
    $text['website'] = "Site Web";
    $text['nologin'] = "Vous n'avez pas de profil de connexion?";
    $text['loginsent'] = "Vos donn�es de connexion ont �t� envoy�es";
    $text['loginnotsent'] = "Vos donn�es de connexion n'ont pas �t� envoy�es";
    $text['enterrealname'] = "Merci d'entrer votre v�ritable nom.";
    $text['rempass'] = "Rester connect� sur cet ordinateur";
    $text['morestats'] = "Statistiques additionnelles";
    $text['accmail'] = "<strong>NOTE:</strong> Afin de pouvoir recevoir des courriels de l'administrateur du site concernant votre compte, assurez-vous de ne pas bloquer les courriels provenant de ce domaine.";
    $text['newpassword'] = "Nouveau mot de passe";
    $text['resetpass'] = "Changer de mot de passe";
    $text['nousers'] = "Ce formulaire ne peut �tre utilis� tant qu'il n'existe pas au moins un enregistrement d'utilisateur. Si vous �tes le propri�taire du site, allez sur Admin/Users pour cr�er votre compte d'Administrateur.";
    $text['noregs'] = "D�sol�s, mais nous n'acceptons pas de nouveaux enregistrements d'utilisateurs pour le moment. Merci de <a href=\"suggest.php\">nous contacter</a> directement si vous avez des commentaires ou des questions concernant n'importe quoi sur ce site Web.";
    //changed in 8.0.0
    $text['emailmsg'] = "Vous avez re�u une nouvelle demande de compte utilisateur TNG. Connectez-vous � la section administration de TNG et accordez � ce nouveau compte les autorisations appropri�es. Si vous approuvez cet enregistrement, informez-en le demandeur en r�pondant � ce message.";
    $text['accactive'] = "Le compte � �t� activ�, mais l'utilisateur n'a pas de droit sp�cifique tant que vous ne les avez pas sp�cifi�s..";
    $text['accinactive'] = "Aller � Admin/utilisateurs/v�rifier pour acc�der aux param�tres des comptes. Le compte reste inactif tant que vous ne l'avez pas �dit� et sauvegard� au moins un fois";
    $text['pwdagain'] = "R�p�ter le mot de passe";
    $text['enterpassword2'] = "Saisir le mot de passe";
    $text['pwdsmatch'] = "Vos mots de passe ne correspondent pas. Merci de saisir le m�me mot de passe dans chacun des deux champs";
    //added in 8.0.0
    $text['acksubject'] = "Merci de vous �tre enregistr�"; //for a new user account
    $text['ackmessage'] = "Votre demande d'un compte d'utilisateur � bien �t� re�ue. Votre compte restera inactif en attendant une v�rification par l'administrateur. Nous vous contacterons par courriel d�s que votre compte sera activ�.";
    //added in 12.0.0
    $text['switch'] = "Commuter";
    break;

  //added in 10.0.0
  case "branches":
    $text['browseallbranches'] = "Naviguer dans toutes les branches";
    break;

  //statistics.php
  case "stats":
    $text['quantity'] = "Nombre";
    $text['totindividuals'] = "Individus";
    $text['totmales'] = "Hommes";
    $text['totfemales'] = "Femmes";
    $text['totunknown'] = "Individus de sexe inconnu";
    $text['totliving'] = "Individus en vie";
    $text['totfamilies'] = "Familles";
    $text['totuniquesn'] = "Noms de famille distincts";
    //$text['totphotos'] = "Total Photos";
    //$text['totdocs'] = "Total Histories &amp; Documents";
    //$text['totheadstones'] = "Total Headstones";
    $text['totsources'] = "Sources";
    $text['avglifespan'] = "Dur�e de vie moyenne";
    $text['earliestbirth'] = "Naissance la plus ancienne";
    $text['longestlived'] = "Vie la plus longue";
    $text['days'] = "jours";
    $text['age'] = "�g� de";
    $text['agedisclaimer'] = "Les calculs li�s � l'�ge sont bas�s sur les individus avec une date de naissance connue <EM> et</EM> une date de d�c�s.  En raison de l'existence de donn�es incompl�tes(ex. une date de d�c�s enregistr�e comme \"1945\" ou \"AVT 1860\"), ces calculs ne sont pas pr�cis � 100%.";
    $text['treedetail'] = "Plus d'information sur cet arbre";
    $text['total'] = "Total";
    //added in 12.0
    $text['totdeceased'] = "Nombre total des morts";
    break;

  case "notes":
    $text['browseallnotes'] = "Afficher toutes les notes";
    break;

  case "help":
    $text['menuhelp'] = "Touche Menu";
    break;

  case "install":
    $text['perms'] = "Les CHMODS ont tous �t� d�finis.";
    $text['noperms'] = "Les CHMODS n'ont pas �t� d�finis pour ces fichiers:";
    $text['manual'] = "Merci de les d�finir manuellement.";
    $text['folder'] = "Le dossier";
    $text['created'] = "a �t� cr��";
    $text['nocreate'] = "n'a pas �t� cr��. Merci de le cr�er manuellement.";
    $text['infosaved'] = "Information sauvegard�e, connexion v�rifi�e.";
    $text['tablescr'] = "Les tables ont �t� cr��es.";
    $text['notables'] = "Les tables suivantes n'ont pas �t� cr��es :";
    $text['nocomm'] = "TNG ne communique pas avec votre base de donn�es. Aucune table n'a �t� cr��e.";
    $text['newdb'] = "Information sauvegard�e, connexion v�rifi�e, la nouvelle base de donn�es a �t� cr��e:";
    $text['noattach'] = "Information sauvegard�e. Connexion �tablie et base de donn�es cr��e, mais TNG ne peut pas s'y connecter.";
    $text['nodb'] = "Information sauvegard�e. Connexion �tablie, mais la base de donn�es n'existe pas et n'a pu �tre cr��e ici. V�rifier que le nom de la base de donn�es est correct, ou utiliser le panneau de commande pour la cr�er.";
    $text['noconn'] = "Information sauv�e mais la connexion n'a pas �t� �tablie. Un ou plusieurs des param�tres suivants est incorrect:";
    $text['exists'] = "est d�j� cr��.";
    $text['loginfirst'] = "Vous devez d'abord ouvrir une session.";
    $text['noop'] = "Aucune op�ration n'a �t� effectu�e.";
    //added in 8.0.0
    $text['nouser'] = "L'utilisateur n'a pas �t� cr��. ce nom de utilisateur est peut-�tre d�ja pris";
    $text['notree'] = "Impossible de cr�e l'arbre. L'ID de Arbre est peut�tre d�ja pris";
    $text['infosaved2'] = "Donne�s sauvegard�es";
    $text['renamedto'] = "renomm� en ";
    $text['norename'] = "n'a pas pu �tre renomm�";
    break;

  case "imgviewer":
    $text['zoomin'] = "Augmenter le Zoom";
    $text['zoomout'] = "Diminuer le Zoom";
    $text['magmode'] = "Mode loupe";
    $text['panmode'] = "Mode Panoramique";
    $text['pan'] = "Cliquer et glisser pour se d�placer � l'int�rieur de l'image";
    $text['fitwidth'] = "Adapter � la largeur";
    $text['fitheight'] = "Adapter � la hauteur";
    $text['newwin'] = "Nouvelle fen�tre";
    $text['opennw'] = "Ouvrir l'image dans une nouvelle fen�tre";
    $text['magnifyreg'] = "Cliquer sur l'image pour agrandir une zone";
    $text['imgctrls'] = "Autoriser les contr�les de l'image";
    $text['vwrctrls'] = "Autoriser les contr�les de la visionneuse d'image";
    $text['vwrclose'] = "Fermer la visionneuse d'image";
    break;

  case "dna":
    $text['test_date'] = "Date du test";
    $text['links'] = "Liens utiles";
    $text['testid'] = "ID du test";
    //added in 12.0.0
    $text['mode_values'] = "Valeurs des Modes";
    $text['compareselected'] = "Comparer les tests s�lectionn�s";
    $text['dnatestscompare'] = "Comparer les Tests ADN-Y";
    $text['keep_name_private'] = "Garder le nom confidentiel";
    $text['browsealltests'] = "Parcourir tous les Tests";
    $text['all_dna_tests'] = "Tous les tests ADN";
    $text['fastmutating'] = "Mutation rapide";
    $text['dna_info_head'] = "Info test ADN";
    $text['alltypes'] = "Tous les types";
    $text['allgroups'] = "Tous les groupes";
    $text['Ydna_LITbox_info'] = "Les tests ADN associ�s � cette personne n'ont pas �t� n�cessairement r�alis�s par cette personne.<br />La colonne 'Haplogroupe' affiche le r�sultat en rouge s'il s'agit d'une 'estimation' ou en vert si le test est 'confirm�'";
    //added in 12.1.0
    $text['dnatestscompare_mtdna'] = "Comparer les tests d'ADNmt s�lectionn�s";
    $text['dnatestscompare_atdna'] = "Comparer les tests d'ADNat s�lectionn�s";
    $text['chromosome'] = "Chr";
    $text['centiMorgans'] = "cM";
    $text['snps'] = "SNPs";
    $text['y_haplogroup'] = "ADN-Y";
    $text['mt_haplogroup'] = "ADNmt";
    $text['sequence'] = "R�f";
    $text['extra_mutations'] = "Mutations additionnelles";
    $text['mrca'] = "Anc�tre RPC";
    $text['ydna_test'] = "Tests ADN-Y ";
    $text['mtdna_test'] = "Tests ADNmt (Mitochondrial)";
    $text['atdna_test'] = "Tests ADNat (autosomal)";
    $text['segment_start'] = "D�but";
    $text['segment_end'] = "Fin";
    $text['suggested_relationship'] = "Sugg�r�";
    $text['actual_relationship'] = "R�el";
    $text['12markers'] = "Marqueurs 1-12";
    $text['25markers'] = "Marqueurs 13-25";
    $text['37markers'] = "Marqueurs 26-37";
    $text['67markers'] = "Marqueurs 38-67";
    $text['111markers'] = "Marqueurs 68-111";
    break;
}

//common
$text['matches'] = "R�sultats";
$text['description'] = "Description";
$text['notes'] = "Notes";
$text['status'] = "Statut";
$text['newsearch'] = "Nouvelle Recherche";
$text['pedigree'] = "Arbre";
$text['seephoto'] = "Voir la photo";
$text['andlocation'] = "et le lieu";
$text['accessedby'] = "consult� par";
$text['family'] = "Famille"; //from getperson
$text['children'] = "Enfants";  //from getperson
$text['tree'] = "Arbre";
$text['alltrees'] = "Tous les arbres";
$text['nosurname'] = "[sans pr�nom]";
$text['thumb'] = "Vignette";  //as in Thumbnail
$text['people'] = "Personnes";
$text['title'] = "Titre";  //from getperson
$text['suffix'] = "Suffixe";  //from getperson
$text['nickname'] = "Autre nom";  //from getperson
$text['lastmodified'] = "Derni�re modif.";  //from getperson
$text['married'] = "Mariage";  //from getperson
//$text['photos'] = "Photos";
$text['name'] = "Nom"; //from showmap
$text['lastfirst'] = "Nom, Pr�nom(s)";  //from search
$text['bornchr'] = "N�/Baptis�";  //from search
$text['individuals'] = "Personnes";  //from whats new
$text['families'] = "Familles";
$text['personid'] = "ID personne";
$text['sources'] = "Sources";  //from getperson (next several)
$text['unknown'] = "Inconnu";
$text['father'] = "P�re";
$text['mother'] = "M�re";
$text['christened'] = "Bapt�me";
$text['died'] = "D�c�s";
$text['buried'] = "S�pulture";
$text['spouse'] = "Conjoint(e)";  //from search
$text['parents'] = "Parents";  //from pedigree
$text['text'] = "Texte";  //from sources
$text['language'] = "Langue";  //from languages
$text['descendchart'] = "Descendants";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Personnes";
$text['edit'] = "�diter";
$text['date'] = "Date";
$text['place'] = "Lieu";
$text['login'] = "Connexion";
$text['logout'] = "D�connexion";
$text['groupsheet'] = "Feuille familiale";
$text['text_and'] = "et";
$text['generation'] = "G�n�ration";
$text['filename'] = "Nom de fichier";
$text['id'] = "ID";
$text['search'] = "Chercher";
$text['user'] = "Utilisateur";
$text['firstname'] = "Pr�nom";
$text['lastname'] = "Nom";
$text['searchresults'] = "R�sultats de la recherche";
$text['diedburied'] = "D�c�s/S�pulture";
$text['homepage'] = "Accueil";
$text['find'] = "Rechercher...";
$text['relationship'] = "Parent�";    //in German, Verwandtschaft
$text['relationship2'] = "Relation"; //different in some languages, at least in German (Beziehung)
$text['timeline'] = "Frise chronologique";
$text['yesabbr'] = "O";               //abbreviation for 'yes'
$text['divorced'] = "a divorc�";
$text['indlinked'] = "Li� �";
$text['branch'] = "Branche";
$text['moreind'] = "Plus d'individus";
$text['morefam'] = "Plus de familles";
$text['source'] = "Source";
$text['surnamelist'] = "Noms de famille";
$text['generations'] = "G�n�rations";
$text['refresh'] = "Rafra�chir";
$text['whatsnew'] = "Quoi de neuf ?";
$text['reports'] = "Rapports";
$text['placelist'] = "Liste de Lieux";
$text['baptizedlds'] = "Baptis� (SDJ)";
$text['endowedlds'] = "Dot� (SDJ)";
$text['sealedplds'] = "Dot� parents (SDJ)";
$text['sealedslds'] = "Conjoint(e) dot�(e) (SDJ)";
$text['ancestors'] = "Anc�tres";
$text['descendants'] = "Descendants";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Date de la derni�re importation GEDCOM";
$text['type'] = "Type";
$text['savechanges'] = "Enregistrer les modifications";
$text['familyid'] = "ID Famille";
$text['headstone'] = "Pierres Tombales";
$text['historiesdocs'] = "Histoires";
$text['anonymous'] = "anonyme";
$text['places'] = "Lieux";
$text['anniversaries'] = "Dates & Anniversaires";
$text['administration'] = "Administration";
$text['help'] = "Aide";
//$text['documents'] = "Documents";
$text['year'] = "Ann�e";
$text['all'] = "Tous";
$text['repository'] = "Archives";
$text['address'] = "Adresse";
$text['suggest'] = "Suggestion";
$text['editevent'] = "Sugg�rer une modification pour cet �v�nement";
$text['findplaces'] = "Trouver tous les individus avec un �v�nement dans ce lieu";
$text['morelinks'] = "Plus de liens";
$text['faminfo'] = "Information sur la Famille";
$text['persinfo'] = "Information Personnelle";
$text['srcinfo'] = "Infos sur la source";
$text['fact'] = "�v�nement";
$text['goto'] = "Selectionner une page";
$text['tngprint'] = "Imprimer";
$text['databasestatistics'] = "Statistiques"; //needed to be shorter to fit on menu
$text['child'] = "Enfant";  //from familygroup
$text['repoinfo'] = "Infos lieu des Archives";
$text['tng_reset'] = "Vider";
$text['noresults'] = "Aucun r�sultat";
$text['allmedia'] = "Tous les m�dias";
$text['repositories'] = "Archives";
$text['albums'] = "Albums";
$text['cemeteries'] = "Cimeti�res";
$text['surnames'] = "Noms de famille";
$text['dates'] = "Dates";
$text['link'] = "Lien";
$text['media'] = "M�dias";
$text['gender'] = "Sexe";
$text['latitude'] = "Latitude";
$text['longitude'] = "Longitude";
$text['bookmarks'] = "Signets";
$text['bookmark'] = "Ajouter un signet";
$text['mngbookmarks'] = "Afficher les signets";
$text['bookmarked'] = "Signet ajout�";
$text['remove'] = "Effacer";
$text['find_menu'] = "Chercher";
$text['info'] = "Info"; //this needs to be a very short abbreviation
$text['cemetery'] = "Cimeti�res";
$text['gmapevent'] = "Carte d'�v�nements";
$text['gevents'] = "�v�nements";
$text['glang'] = "&hl=fr";
$text['googleearthlink'] = "Lien Google Earth";
$text['googlemaplink'] = "Lien Google Map";
$text['gmaplegend'] = "L�gende";
$text['unmarked'] = "non marqu�e(s)";
$text['located'] = "Situ�e(s)";
$text['albclicksee'] = "Cliquer pour voir tous les items dans cet album";
$text['notyetlocated'] = "Pas encore trouv�";
$text['cremated'] = "Incin�r�";
$text['missing'] = "Manquant";
$text['pdfgen'] = "G�n�rateur de PDF";
$text['blank'] = "Diagramme vide";
$text['none'] = "Aucun";
$text['fonts'] = "Polices";
$text['header'] = "En-t�te";
$text['data'] = "Donn�es";
$text['pgsetup'] = "Mise en page";
$text['pgsize'] = "Dimensions de la page";
$text['orient'] = "Orientation"; //for a page
$text['portrait'] = "Portrait";
$text['landscape'] = "Paysage";
$text['tmargin'] = "Marge sup�rieure";
$text['bmargin'] = "Marge inf�rieure";
$text['lmargin'] = "Marge de gauche";
$text['rmargin'] = "Marge de droite";
$text['createch'] = "Cr�er le diagramme";
$text['prefix'] = "Pr�fixe";
$text['mostwanted'] = "Les plus recherch�s";
$text['latupdates'] = "Les derni�res mises � jour";
$text['featphoto'] = "Photo s�lectionn�e";
$text['news'] = "Nouvelles";
$text['ourhist'] = "Histoire de notre famille";
$text['ourhistanc'] = "Histoire et g�n�alogie de notre famille";
$text['ourpages'] = "Page de la g�n�alogie de notre famille";
$text['pwrdby'] = "Ce site est propuls� par le logiciel";
$text['writby'] = "�crit par";
$text['searchtngnet'] = "Recherche dans le TNG Network (GENDEX)";
$text['viewphotos'] = "Regarder toutes les photos";
$text['anon'] = "Vous �tes actuellement anonyme";
$text['whichbranch'] = "De quelle branche �tes-vous ?";
$text['featarts'] = "Articles s�lectionn�s";
$text['maintby'] = "G�r� par";
$text['createdon'] = "Cr�� le";
$text['reliability'] = "Fiabilit�";
$text['labels'] = "�tiquettes";
$text['inclsrcs'] = "Inclure les Sources";
$text['cont'] = "(� suiv.)"; //abbreviation for continued
$text['mnuheader'] = "Accueil";
$text['mnusearchfornames'] = "Recherche";
$text['mnulastname'] = "Nom de famille";
$text['mnufirstname'] = "Pr�nom";
$text['mnusearch'] = "Chercher";
$text['mnureset'] = "Recommencer";
$text['mnulogon'] = "Connexion";
$text['mnulogout'] = "D�connexion";
$text['mnufeatures'] = "Autres fonctions";
$text['mnuregister'] = "Demander un compte utilisateur";
$text['mnuadvancedsearch'] = "Recherche avanc�e";
$text['mnulastnames'] = "Noms de famille";
$text['mnustatistics'] = "Statistiques";
$text['mnuphotos'] = "Photos";
$text['mnuhistories'] = "Histoires";
$text['mnumyancestors'] = "Photos & Histoires des Anc�tres de [Personne]";
$text['mnucemeteries'] = "Cimeti�res";
$text['mnutombstones'] = "Pierres tombales";
$text['mnureports'] = "Rapports";
$text['mnusources'] = "Sources";
$text['mnuwhatsnew'] = "Quoi de neuf?";
$text['mnushowlog'] = "Journal d'acc�s";
$text['mnulanguage'] = "Changer de langue";
$text['mnuadmin'] = "Administration";
$text['welcome'] = "Bienvenue";
$text['contactus'] = "Contactez-nous";
//changed in 8.0.0
$text['born'] = "Naissance";
$text['searchnames'] = "Recherche individus";
//added in 8.0.0
$text['editperson'] = "Modifier individus";
$text['loadmap'] = "Charger la carte";
$text['birth'] = "Naissance";
$text['wasborn'] = "est n�-e ";
$text['startnum'] = "Premier num�ro";
$text['searching'] = "Recherche en cours";
//moved here in 8.0.0
$text['location'] = "Lieu";
$text['association'] = "Association";
$text['collapse'] = "R�duire";
$text['expand'] = "D�velopper";
$text['plot'] = "Lot";
$text['searchfams'] = "Recherche familles";
//added in 8.0.2
$text['wasmarried'] = "a �pous� ";
$text['anddied'] = "est mort-e ";
//added in 9.0.0
$text['share'] = "Partager";
$text['hide'] = "Cacher";
$text['disabled'] = "Votre compte utilisateur a �t� d�sactiv�. Merci de contacter l'administrateur du site pour plus d'information.";
$text['contactus_long'] = "Si vous avez des questions ou des commentaires � propos de l'information publi�e sur ce site, merci de <span class=\"emphasis\"><a href=\"suggest.php\">nous contacter</a></span>. Nous attendons de vos nouvelles.";
$text['features'] = "Articles";
$text['resources'] = "Ressources";
$text['latestnews'] = "Derni�res Nouvelles";
$text['trees'] = "Arbres";
$text['wasburied'] = "a �t� enterr�-e ";
//moved here in 9.0.0
$text['emailagain'] = "Confirmer l'adresse courriel";
$text['enteremail2'] = "Merci de saisir de nouveau votre adresse courriel";
$text['emailsmatch'] = "Vos courriels ne correspondent pas. Merci de saisir la m�me adresse courriel dans chaque case.";
$text['getdirections'] = "Cliquer ici pour obtenir les instructions";
$text['calendar'] = "Calendrier";
//changed in 9.0.0
$text['directionsto'] = " au ";
$text['slidestart'] = "Diaporama";
$text['livingnote'] = "Au moins une personne vivante ou marqu�e priv�e est li�e � cette note - Les d�tails ne sont donc pas publi�s.";
$text['livingphoto'] = "Au moins une personne vivante ou marqu�e priv�e est li�e � cette photo - Details cach�s.";
$text['waschristened'] = "a �t� baptis�-e ";
//added in 10.0.0
$text['branches'] = "Branches";
$text['detail'] = "D�tail";
$text['moredetail'] = "Plus d�tail";
$text['lessdetail'] = "Moins d�tail";
$text['otherevents'] = "Autres �v�nements";
$text['conflds'] = "Confirm�/e (SDJ)";
$text['initlds'] = "Initi�/e (SDJ)";
$text['wascremated'] = "a �t� incin�r�";
//moved here in 11.0.0
$text['text_for'] = "pour";
//added in 11.0.0
$text['searchsite'] = "Rechercher sur ce site";
$text['searchsitemenu'] = "Recherche";
$text['kmlfile'] = "T�l�charger un fichier .kml pour afficher ce lieu dans Google Earth";
$text['download'] = "Cliquer ici pour t�l�charger";
$text['more'] = "Plus";
$text['heatmap'] = "Carte de chaleur";
$text['refreshmap'] = "Actualiser la carte";
$text['remnums'] = "Retirer les nombres et les rep�res";
$text['photoshistories'] = "Photos et r�cits";
$text['familychart'] = "Tableau familial";
//added in 12.0.0
$text['firstnames'] = "Pr�noms";
//moved here in 12.0.0
$text['dna_test'] = "Test ADN";
$text['test_type'] = "Type de test";
$text['test_info'] = "Information du test";
$text['takenby'] = "R�alis� par";
$text['haplogroup'] = "Haplogroupe";
$text['hvr1'] = "HVR1";
$text['hvr2'] = "HVR2";
$text['relevant_links'] = "Connexions pertinentes";
$text['nofirstname'] = "[pas de pr�nom]";
//added in 12.0.1
$text['cookieuse'] = "Note : Ce site utilise des cookies.";
$text['dataprotect'] = "Charte de protection des donn�es";
$text['viewpolicy'] = "Afficher la charte";
$text['understand'] = "Je comprends";
$text['consent'] = "Je donne mon consentement pour que ce site stocke les informations personnelles collect�es ici. Je comprends que je peux demander au propri�taire du site de supprimer ces informations � tout moment.";
$text['consentreq'] = "Merci de donner votre consentement � ce que ce site conserve vos donn�es personnelles.";

//added in 12.1.0
$text['testsarelinked'] = "tests ADN sont associ� �";
$text['testislinked'] = "test ADN est associ� �";

//added in 12.2
$text['quicklinks'] = "Liens rapides";
$text['votrenom'] = "Votre nom";
$text['youremail'] = "Votre adresse email";
$text['liketoadd'] = "Toutes les informations que vous souhaitez ajouter";
$text['webmastermsg'] = "Message du webmaster";
$text['gallery'] = "Voir la galerie";
$text['wasborn_male'] = "est n�";    // same as $text['wasborn'] if no gender verb
$text['wasborn_female'] = "est n�e";  // same as $text['wasborn'] if no gender verb
$text['waschristened_male'] = "a �t� baptis�";  // same as $text['waschristened'] if no gender verb
$text['waschristened_female'] = "a �t� baptis�e";  // same as $text['waschristened'] if no gender verb
$text['died_male'] = "est mort";  // same as $text['anddied'] of no gender verb
$text['died_female'] = "est morte";  // same as $text['anddied'] of no gender verb
$text['wasburied_male'] = "a �t� enterr�";  // same as $text['wasburied'] if no gender verb
$text['wasburied_female'] = "a �t� enterr�e";  // same as $text['wasburied'] if no gender verb
$text['wascremated_male'] = "a �t�t incin�r�";    // same as $text['wascremated'] if no gender verb
$text['wascremated_female'] = "a �t� incin�r�e";  // same as $text['wascremated'] if no gender verb
$text['wasmarried_male'] = "a �pous�";  // same as $text['wasdmarried'] if no gender verb
$text['wasmarried_female'] = "a �pous�";  // same as $text['wasdmarried'] if no gender verb
$text['wasdivorced_male'] = "est divorc�";  // might be the same as $text['divorce'] but as a verb
$text['wasdivorced_female'] = "est divorc�e";  // might be the same as $text['divorce'] but as a verb
$text['inplace'] = " � ";      // used as a preposition to the location
$text['onthisdate'] = " le ";    // when used with full date
$text['inthisyear'] = " en ";    // when used with year only or month / year dates
$text['and'] = "et ";    // used in conjunction with wasburied or was cremated

//moved here in 12.3
$text['dna_info_head'] = "Info test ADN";
$text['firstpage'] = "Premi�re page";
$text['lastpage'] = "Derni�re page";

@include_once "captcha_text.php";
@include_once "alltext.php";
if (!$alltextloaded) {
  getAllTextPath();
}

<?php
switch ($textpart) {
  //browsesources.php, showsource.php
  case "sources":
    $text['browseallsources'] = "Prehliada� v�etky zdroje";
    $text['shorttitle'] = "Kr�tky n�zov";
    $text['callnum'] = "Volacie ��slo";
    $text['author'] = "Autor";
    $text['publisher'] = "Vydavate�";
    $text['other'] = "�al�ie inform�cie";
    $text['sourceid'] = "ID ��slo zdroja";
    $text['moresrc'] = "�al�ie zdroje";
    $text['repoid'] = "ID ��slo arch�vu";
    $text['browseallrepos'] = "Prehliada� v�etky arch�vy";
    break;

  //changelanguage.php, savelanguage.php
  case "language":
    $text['newlanguage'] = "Nov� jazyk";
    $text['changelanguage'] = "Zmena jazyka";
    $text['languagesaved'] = "Jazyk ulo�en�";
    $text['sitemaint'] = "Pr�ve probieha �dr�ba webov�ch str�nok";
    $text['standby'] = "Webov� str�nka je do�asne nedostupn�, preto�e probieha aktualiz�cia datab�zy. Sk�ste to, pros�m, znova o p�r min�t. Ak bude str�nka nedostupn� dlh�iu dobu, kontaktujte majite�a tejto str�nky.";
    break;

  //gedcom.php, gedform.php
  case "gedcom":
    $text['gedstart'] = "GEDCOM za��naj�ci od";
    $text['producegedfrom'] = "Vytvori� GEDCOM s�bor z";
    $text['numgens'] = "Po�et gener�ci�";
    $text['includelds'] = "V��tane �dajov CJKSpd";
    $text['buildged'] = "Vytvor GEDCOM";
    $text['gedstartfrom'] = "GEDCOM za��naj�ci od";
    $text['nomaxgen'] = "Mus�te zada� maxim�lny po�et gener�ci�. Pou�ijte tla��dlo Sp� na n�vrat na predch�dzaj�cu str�nku a chybu opravte.";
    $text['gedcreatedfrom'] = "GEDCOM vytvoren� od";
    $text['gedcreatedfor'] = "vytvoren� pre";
    $text['creategedfor'] = "Vytvori� GEDCOM";
    $text['email'] = "V� email";
    $text['suggestchange'] = "Navrhn�� zmenu";
    $text['yourname'] = "Va�e meno";
    $text['comments'] = "Popis <br />navrhovan�ch zmien";
    $text['comments2'] = "Koment�re";
    $text['submitsugg'] = "Odosla� n�vrh";
    $text['proposed'] = "Navrhovan� zmena";
    $text['mailsent'] = "�akujeme. Va�a spr�va bola odoslan�.";
    $text['mailnotsent'] = "Bohu�ia�, va�a spr�va nemohla by� doru�en�. Kontaktujte, pros�m, xxx priamo na yyy.";
    $text['mailme'] = "Zasla� k�piu na t�to adresu";
    $text['entername'] = "Zadajte, pros�m, va�e meno";
    $text['entercomments'] = "Zadajte, pros�m, va�e pripomienky";
    $text['sendmsg'] = "Posla� spr�vu";
    //added in 9.0.0
    $text['subject'] = "Predmet";
    break;

  //getextras.php, getperson.php
  case "getperson":
    $text['photoshistoriesfor'] = "Fotografie a historky pre";
    $text['indinfofor'] = "Osobn� inform�cie o";
    $text['pp'] = "str."; //page abbreviation
    $text['age'] = "Vek";
    $text['agency'] = "In�tit�cia";
    $text['cause'] = "Pr��ina";
    $text['suggested'] = "Navrhnut�";
    $text['closewindow'] = "Zatvori� toto okno";
    $text['thanks'] = "�akujeme";
    $text['received'] = "V� n�vrh bol odoslan� administr�torovi tejto str�nky na pos�denie.";
    $text['indreport'] = "Zostava osoby";
    $text['indreportfor'] = "Zostava osoby";
    $text['general'] = "V�eobecn�";
    $text['bkmkvis'] = "Pozn�mka: Tieto z�lo�ky s� vidite�n� len na tomto po��ta�i a v tomto prehliada�i.";
    //added in 9.0.0
    $text['reviewmsg'] = "M�te navrhnut� zmenu, ktor� vy�aduje va�e pos�denie. T�to zmena sa t�ka:";
    $text['revsubject'] = "Navrhovan� zmena vy�aduje va�e pos�denie";
    break;

  //relateform.php, relationship.php, findpersonform.php, findperson.php
  case "relate":
    $text['relcalc'] = "Kalkul�tor pr�buznost�";
    $text['findrel'] = "N�js� pr�buzensk� vz�ah";
    $text['person1'] = "Osoba 1:";
    $text['person2'] = "Osoba 2:";
    $text['calculate'] = "Vypo��ta�";
    $text['select2inds'] = "Pros�m, vyberte dve osoby.";
    $text['findpersonid'] = "N�js� ID ��slo osoby";
    $text['enternamepart'] = "zadajte �as� mena a/alebo priezviska";
    $text['pleasenamepart'] = "Pros�m, zadajte �as� mena alebo priezviska.";
    $text['clicktoselect'] = "kliknite na vybratie osoby";
    $text['nobirthinfo'] = "Ch�baj� inform�cie o naroden�";
    $text['relateto'] = "Pr�buzensk� vz�ah k: ";
    $text['sameperson'] = "Tieto dve osoby s� toto�n�";
    $text['notrelated'] = "Tieto dve osoby nemaj� �iadny pr�buzensk� vz�ah v rozsahu xxx gener�ci�"; //xxx will be replaced with number of generations
    $text['findrelinstr'] = "Na zobrazenie vz�ahu medzi dvoma osobami pou�ite tla�idlo 'N�js�' na n�jdenie pr�slu�n�ch os�b, alebo ponechajte zobrazen� osoby, potom kliknite na 'Vypo��ta�'.<br>(Anglick� v�razy vz�ahov sa nie v�dy podar� kalkul�toru spr�vne prelo�i� do sloven�iny.)";
    $text['sometimes'] = "(Pou�itie in�ho po�tu gener�ci� m��e niekedy da� in� v�sledok.)";
    $text['findanother'] = "N�js� in� pr�buzensk� vz�ah";
    $text['brother'] = "brat od";
    $text['sister'] = "sestra od";
    $text['sibling'] = "s�rodenec od";
    $text['uncle'] = " xxx str�ko od";
    $text['aunt'] = " xxx teta od";
    $text['uncleaunt'] = " xxx str�ko/teta od";
    $text['nephew'] = " xxx synovec od";
    $text['niece'] = " xxx neter od";
    $text['nephnc'] = "xxx synovec/neter od";
    $text['removed'] = "vzdialen� pr�buzn�";
    $text['rhusband'] = "man�el od";
    $text['rwife'] = "man�elka od";
    $text['rspouse'] = "partner od";
    $text['son'] = "syn od";
    $text['daughter'] = "dc�ra od";
    $text['rchild'] = "die�a od";
    $text['sil'] = "za� od";
    $text['dil'] = "nevesta od";
    $text['sdil'] = "za� alebo nevesta od";
    $text['gson'] = " xxx vnuk od";
    $text['gdau'] = " xxx vnu�ka od";
    $text['gsondau'] = "xxx vnuk/vnu�ka od";
    $text['great'] = "pra";
    $text['spouses'] = "s� man�elia";
    $text['is'] = "je";
    $text['changeto'] = "Zmeni� na (zadajte ID ��slo):";
    $text['notvalid'] = "nie je platn� ID ��slo osoby alebo neexistuje v tejto datab�ze. Sk�ste to, pros�m, znova.";
    $text['halfbrother'] = "nevlastn� brat od";
    $text['halfsister'] = "nevlastn� sestra od";
    $text['halfsibling'] = "nevlastn� s�rodenec od";
    //changed in 8.0.0
    $text['gencheck'] = "Maxim�lny po�et kontrolovan�ch gener�ci�";
    $text['mcousin'] = "xxx bratranec yyy od";  //male cousin; xxx = cousin number, yyy = times removed
    $text['fcousin'] = "xxx sesternica yyy od";  //female cousin
    $text['cousin'] = " xxx bratranec/sesternica yyy od";
    $text['mhalfcousin'] = "xxx nevlastn� bratranec yyy od";  //male cousin
    $text['fhalfcousin'] = "xxx nevlastn� sesternica yyy od";  //female cousin
    $text['halfcousin'] = "xxx nevlastn� bratranec/sesternica yyy od";
    //added in 8.0.0
    $text['oneremoved'] = "vzdialen� o jednu gener�ciu";
    $text['gfath'] = "xxx star� otec od";
    $text['gmoth'] = "xxx star� mama od";
    $text['gpar'] = "xxx star� rodi� od";
    $text['mothof'] = "matka od";
    $text['fathof'] = "otec od ";
    $text['parof'] = "rodi� od";
    $text['maxrels'] = "Maxim�lny po�et vz�ahov na zobrazenie";
    $text['dospouses'] = "Zobrazi� vz�ahy v��tane man�elov";
    $text['rels'] = "Pr�buzensk� vz�ahy";
    $text['dospouses2'] = "Zobrazi� partnerov";
    $text['fil'] = "svokor od";
    $text['mil'] = "svokra od";
    $text['fmil'] = "svokor alebo svokra od";
    $text['stepson'] = "nevlastn� syn od";
    $text['stepdau'] = "nevlastn� dc�ra od";
    $text['stepchild'] = "nevlastn� die�a od";
    $text['stepgson'] = "xxx nevlastn� vnuk od";
    $text['stepgdau'] = "xxx nevlastn� vnu�ka od";
    $text['stepgchild'] = "xxx nevlastn� vn��a od";
    //added in 8.1.1
    $text['ggreat'] = "pra";
    //added in 8.1.2
    $text['ggfath'] = " xxx pradedko od";
    $text['ggmoth'] = " xxx prababi�ka od";
    $text['ggpar'] = " xxx prarodi� od";
    $text['ggson'] = " xxx pravnuk od";
    $text['ggdau'] = " xxx pravnu�ka od";
    $text['ggsondau'] = " xxx pradie�a od";
    $text['gstepgson'] = "xxx nevlastn� pravnuk od";
    $text['gstepgdau'] = "xxx nevlastn� pravnu�ka od";
    $text['gstepgchild'] = "xxx nevlastn� prapradie�a od";
    $text['guncle'] = " xxx prastr�ko od";
    $text['gaunt'] = " xxx prateta od";
    $text['guncleaunt'] = " xxx prastr�ko/prateta od";
    $text['gnephew'] = " xxx prasynovec od";
    $text['gniece'] = " xxx praneter od";
    $text['gnephnc'] = " xxx prasynovec/praneter od";
    break;

  case "familygroup":
    $text['familygroupfor'] = "Zostava rodiny";
    $text['ldsords'] = "Obrady CJKSpd";
    $text['baptizedlds'] = "Krstenie (CJKSpd)";
    $text['endowedlds'] = "Obdarovanie (CJKSpd)";
    $text['sealedplds'] = "Pe�atenie s rodi�mi (CJKSpd)";
    $text['sealedslds'] = "Pe�atenie s partnerom (CJKSpd)";
    $text['otherspouse'] = "�al�� partner";
    $text['husband'] = "Otec";
    $text['wife'] = "Matka";
    break;

  //pedigree.php
  case "pedigree":
    $text['capbirthabbr'] = "N";
    $text['capaltbirthabbr'] = "K";
    $text['capdeathabbr'] = "Z";
    $text['capburialabbr'] = "P";
    $text['capplaceabbr'] = "v";
    $text['capmarrabbr'] = "S";
    $text['capspouseabbr'] = "M/P";
    $text['redraw'] = "Zobrazit s";
    $text['scrollnote'] = "Pozn�mka: Na zobrazenie diagramu m��ete pou�i� posuvn�k dole alebo doprava.";
    $text['unknownlit'] = "Nezn�my";
    $text['popupnote1'] = " = �al�ie inform�cie";
    $text['popupnote2'] = " = Nov� rodokme�";
    $text['pedcompact'] = "Kompaktne";
    $text['pedstandard'] = "�tandardne";
    $text['pedtextonly'] = "Len text";
    $text['descendfor'] = "Sch�ma potomkov osoby";
    $text['maxof'] = "Najviac";
    $text['gensatonce'] = "gener�ci� zobrazen�ch naraz.";
    $text['sonof'] = "syn od";
    $text['daughterof'] = "dc�ra od";
    $text['childof'] = "die�a od";
    $text['stdformat'] = "�tandardn� form�t";
    $text['ahnentafel'] = "Ahnentafel";
    $text['addnewfam'] = "Prida� nov� rodinu";
    $text['editfam'] = "Upravi� rodinu";
    $text['side'] = "strana";
    $text['familyof'] = "Rodina";
    $text['paternal'] = "Otcova";
    $text['maternal'] = "Matkina";
    $text['gen1'] = "Ja";
    $text['gen2'] = "Rodi�ia";
    $text['gen3'] = "Prarodi�ia";
    $text['gen4'] = "Praprarodi�ia";
    $text['gen5'] = "3xprarodi�ia";
    $text['gen6'] = "4xprarodi�ia";
    $text['gen7'] = "5xprarodi�ia";
    $text['gen8'] = "6xprarodi�ia";
    $text['gen9'] = "7xprarodi�ia";
    $text['gen10'] = "8xprarodi�ia";
    $text['gen11'] = "9xprarodi�ia";
    $text['gen12'] = "10xprarodi�ia";
    $text['graphdesc'] = "Sch�ma potomkov a� do tohto miesta";
    $text['pedbox'] = "R�m�ek";
    $text['regformat'] = "Register";
    $text['extrasexpl'] = "Pri tejto osobe existuje aspo� jedna fotografia, historka alebo in� medi�lna polo�ka.";
    $text['popupnote3'] = " = Nov� sch�ma";
    $text['mediaavail'] = "M�di� s� k dispoz�cii";
    $text['pedigreefor'] = "Sch�ma rodokme�a pre";
    $text['pedigreech'] = "Sch�ma rodokme�a";
    $text['datesloc'] = "D�tumy a miesta";
    $text['borchr'] = "Narod/Krst - �mrtie/Pohr (dva)";
    $text['nobd'] = "Bez d�tumov narodenia alebo �mrtia";
    $text['bcdb'] = "V�etky �daje Narod/Krst/�mrtie/Pohr (�tyri)";
    $text['numsys'] = "Syst�m ��slovania";
    $text['gennums'] = "��sla gener�ci�";
    $text['henrynums'] = "��slovanie pod�a Henryho";
    $text['abovnums'] = "��slovanie pod�a d'Aboville";
    $text['devnums'] = "��slovanie pod�a de Villiers";
    $text['dispopts'] = "Mo�nosti zobrazenia";
    //added in 10.0.0
    $text['no_ancestors'] = "Neboli n�jden� �iadni predkovia";
    $text['ancestor_chart'] = "Zvisl� sch�ma predkov";
    $text['opennewwindow'] = "Otvori� v novom okne";
    $text['pedvertical'] = "Zvisle";
    //added in 11.0.0
    $text['familywith'] = "Rodina s";
    $text['fcmlogin'] = "Pros�m, prihl�ste sa na pozretie detailov";
    $text['isthe'] = "je";
    $text['otherspouses'] = "�al�� partneri";
    $text['parentfamily'] = "Rodina rodi�ov ";
    $text['showfamily'] = "Zobrazi� rodinu";
    $text['shown'] = "zobrazen�";
    $text['showparentfamily'] = "zobrazi� rodinu rodi�ov";
    $text['showperson'] = "zobrazi� osobu";
    //added in 11.0.2
    $text['otherfamilies'] = "�al�ie rodiny";
    break;

  //search.php, searchform.php
  //merged with reports and showreport in 5.0.0
  case "search":
  case "reports":
    $text['noreports'] = "�iadna zostava neexistuje.";
    $text['reportname'] = "N�zov zostavy";
    $text['allreports'] = "V�etky zostavy";
    $text['report'] = "Zostava";
    $text['error'] = "Chyba";
    $text['reportsyntax'] = "Syntax dotazu pre t�to zostavu";
    $text['wasincorrect'] = "bola chybn�, a zostava nemohla by� vytvoren�. Kontaktujte, pros�m, administr�tora syst�mu na";
    $text['errormessage'] = "Hl�senie o chybe";
    $text['equals'] = "rovn� sa";
    $text['endswith'] = "kon�� na";
    $text['soundexof'] = "soundex";
    $text['metaphoneof'] = "metaphone";
    $text['plusminus10'] = "+/- 10 rokov od";
    $text['lessthan'] = "men�� ako";
    $text['greaterthan'] = "v��� ako";
    $text['lessthanequal'] = "men�� alebo rovn�";
    $text['greaterthanequal'] = "v��� alebo rovn�";
    $text['equalto'] = "rovn�";
    $text['tryagain'] = "Pros�m, sk�ste to znova";
    $text['joinwith'] = "Spoji� s";
    $text['cap_and'] = "A";
    $text['cap_or'] = "ALEBO";
    $text['showspouse'] = "Zobrazi� partnera (ak osoba m� viac partnerov, bude zobrazen� viackr�t)";
    $text['submitquery'] = "Vykona� dotaz";
    $text['birthplace'] = "Miesto narodenia";
    $text['deathplace'] = "Miesto �mrtia";
    $text['birthdatetr'] = "Rok narodenia";
    $text['deathdatetr'] = "Rok �mrtia";
    $text['plusminus2'] = "+/- 2 roky od";
    $text['resetall'] = "Obnovi� v�etky hodnoty na v�chodzie";
    $text['showdeath'] = "Zobrazi� inform�cie o �mrt�/pohrebe";
    $text['altbirthplace'] = "Miesto krstu";
    $text['altbirthdatetr'] = "Rok krstu";
    $text['burialplace'] = "Miesto pohrebu";
    $text['burialdatetr'] = "Rok pohrebu";
    $text['event'] = "Udalos�";
    $text['day'] = "De�";
    $text['month'] = "Mesiac";
    $text['keyword'] = "K���ov� slovo (napr. \"asi\")";
    $text['explain'] = "Na zobrazenie odpovedaj�cich udalost� zadajte d�tum. Na zobrazenie v�etk�ch udalost� nechajte pole pr�zdne.";
    $text['enterdate'] = "Pros�m, zadajte alebo vyberte aspo� jedno z nasleduj�cich: De�, Mesiac, Rok, K���ov� slovo";
    $text['fullname'] = "Cel� meno";
    $text['birthdate'] = "D�tum narodenia";
    $text['altbirthdate'] = "D�tum krstu";
    $text['marrdate'] = "D�tum sob�a";
    $text['spouseid'] = "ID ��slo partnera";
    $text['spousename'] = "Meno partnera";
    $text['deathdate'] = "D�tum �mrtia";
    $text['burialdate'] = "D�tum pohrebu";
    $text['changedate'] = "D�tum poslednej zmeny";
    $text['gedcom'] = "Strom";
    $text['baptdate'] = "CJKSpd d�tum krstu";
    $text['baptplace'] = "CJKSpd miesto krstu";
    $text['endldate'] = "CJKSpd d�tum zasn�benia";
    $text['endlplace'] = "CJKSpd miesto zasn�benia";
    $text['ssealdate'] = "CJKSpd d�tum pe�atenia s partnerom";   //Sealed to spouse
    $text['ssealplace'] = "CJKSpd miesto pe�atenia s partnerom";
    $text['psealdate'] = "CJKSpd d�tum pe�atenia s rodi�mi";   //Sealed to parents
    $text['psealplace'] = "CJKSpd miesto pe�atenia s rodi�mi";
    $text['marrplace'] = "Miesto sob�a";
    $text['spousesurname'] = "Priezvisko partnera";
    $text['spousemore'] = "Ak zad�vate priezvisko partnera, mus�te vybra� pohlavie.";
    $text['plusminus5'] = "+/- 5 rokov od";
    $text['exists'] = "existuje";
    $text['dnexist'] = "neexistuje";
    $text['divdate'] = "D�tum rozvodu";
    $text['divplace'] = "Miesto rozvodu";
    $text['otherevents'] = "In� krit�ri� h�adania";
    $text['numresults'] = "Po�et v�sledkov na str�nke";
    $text['mysphoto'] = "Z�hadn� fotografie";
    $text['mysperson'] = "H�adan� osoby";
    $text['joinor'] = "Vo�bu 'Join with OR' nemo�no pou�i� s priezviskom partnera";
    $text['tellus'] = "Ak m�te nejak� inform�cie, nap�te n�m";
    $text['moreinfo'] = "Viac inform�ci�";
    //added in 8.0.0
    $text['marrdatetr'] = "Rok sob�a";
    $text['divdatetr'] = "Rok rozvodu";
    $text['mothername'] = "Meno matky";
    $text['fathername'] = "Meno otca";
    $text['filter'] = "Filter";
    $text['notliving'] = "Zosnul�";
    $text['nodayevents'] = "Udalosti v tomto mesiaci, ktor� nie s� spojen� s ur�it�m d�om:";
    //added in 9.0.0
    $text['csv'] = "S�bor CSV s �dajmi oddelen�mi �iarkami";
    //added in 10.0.0
    $text['confdate'] = "D�tum birmovania (CJKSpd)";
    $text['confplace'] = "Miesto birmovania (CJKSpd)";
    $text['initdate'] = "D�tum zasv�tenia (CJKSpd)";
    $text['initplace'] = "Miesto zasv�tenia (CJKSpd)";
    //added in 11.0.0
    $text['marrtype'] = "Typ sob�a";
    $text['searchfor'] = "H�ada�";
    $text['searchnote'] = "Pozn�mka: T�to str�nka pou��va Google na vykon�vanie h�adania. Po�et n�jden�ch zh�d bude priamo z�visie� od rozsahu, v�akom Google je schopn� indexova� toto webov� s�dlo.";
    break;

  //showlog.php
  case "showlog":
    $text['logfilefor'] = "Protokol�rny s�bor";
    $text['mostrecentactions'] = "Ned�vne aktivity";
    $text['autorefresh'] = "Automatick� obnova (30 sek�nd)";
    $text['refreshoff'] = "Vypn�� automatick� obnovu";
    break;

  case "headstones":
  case "showphoto":
    $text['cemeteriesheadstones'] = "Cintor�ny a n�hrobky";
    $text['showallhsr'] = "Zobrazi� v�etky z�znamy n�hrobkov";
    $text['in'] = "v";
    $text['showmap'] = "Uk�za� mapu";
    $text['headstonefor'] = "N�hrobok pre";
    $text['photoof'] = "Fotografie";
    $text['photoowner'] = "Majite�/P�vodca";
    $text['nocemetery'] = "�iadny cintor�n";
    $text['iptc005'] = "N�zov";
    $text['iptc020'] = "Podporovan� kateg�rie";
    $text['iptc040'] = "Zvl�tne in�trukcie";
    $text['iptc055'] = "D�tum vytvorenia";
    $text['iptc080'] = "Autor";
    $text['iptc085'] = "Autorova funkcia";
    $text['iptc090'] = "Mesto/obec";
    $text['iptc095'] = "�t�t/Kraj";
    $text['iptc101'] = "Krajina";
    $text['iptc103'] = "OTR";
    $text['iptc105'] = "Nadpis";
    $text['iptc110'] = "Zdroj";
    $text['iptc115'] = "Zdroj fotografie";
    $text['iptc116'] = "V�etky pr�va vyhraden�";
    $text['iptc120'] = "Titulok";
    $text['iptc122'] = "Titulok vytvoril";
    $text['mapof'] = "Mapa";
    $text['regphotos'] = "Zobrazenie s popisom";
    $text['gallery'] = "Len miniat�ry";
    $text['cemphotos'] = "Fotky z cintor�nov";
    $text['photosize'] = "Rozmery";
    $text['iptc010'] = "Priorita";
    $text['filesize'] = "Ve�kos� s�boru";
    $text['seeloc'] = "Pozrite si miesto";
    $text['showall'] = "Zobrazi� v�etko";
    $text['editmedia'] = "Upravi� m�dium";
    $text['viewitem'] = "Prezrite si t�to polo�ku";
    $text['editcem'] = "Upravi� cintor�n";
    $text['numitems'] = "Po�et polo�iek";
    $text['allalbums'] = "V�etky albumy";
    $text['slidestop'] = "Pozastavi� prezent�ciu";
    $text['slideresume'] = "Obnovi� prezent�ciu";
    $text['slidesecs'] = "Po�et sek�nd pre ka�d� sn�mku:";
    $text['minussecs'] = "ubra� 0,5 sekundy";
    $text['plussecs'] = "prida� 0,5 sekundy";
    $text['nocountry'] = "Nezn�ma krajina";
    $text['nostate'] = "Nezn�my �t�t/kraj";
    $text['nocounty'] = "Nezn�my okres";
    $text['nocity'] = "Nezn�me mesto/obec";
    $text['nocemname'] = "Nezn�my n�zov cintor�na";
    $text['editalbum'] = "Upravi� album";
    $text['mediamaptext'] = "<strong>Pozn�mka:</strong> Pos�van�m ukazovate�a my�i cez obr�zok sa zobrazia n�zvy. Kliknut�m sa zobraz� str�nka k tomuto n�zvu.";
    //added in 8.0.0
    $text['allburials'] = "V�etky pohreby";
    $text['moreinfo'] = "Kliknut�m sa zobraz� viac inform�ci� o obr�zku";
    //added in 9.0.0
    $text['iptc025'] = "K���ov� slov�";
    $text['iptc092'] = "�as� miesta";
    $text['iptc015'] = "Kateg�ria";
    $text['iptc065'] = "P�vodn� program";
    $text['iptc070'] = "Verzia programu";
    break;

  //surnames.php, surnames100.php, surnames-all.php, surnames-oneletter.php
  case "surnames":
  case "places":
    $text['surnamesstarting'] = "Zobrazi� priezvisk� za��naj�ce na";
    $text['showtop'] = "Zobrazi� prv�ch ";
    $text['showallsurnames'] = "Zobrazi� v�etky priezvisk�";
    $text['sortedalpha'] = "zoraden� pod�a abecedy";
    $text['byoccurrence'] = " zoraden�ch pod�a po�etnosti";
    $text['firstchars'] = "Za�iato�n� p�smen�";
    $text['mainsurnamepage'] = "Hlavn� str�nka priezvisk";
    $text['allsurnames'] = "V�etky priezvisk�";
    $text['showmatchingsurnames'] = "Kliknut�m na priezvisko sa zobrazia odpovedaj�ce z�znamy.";
    $text['backtotop'] = "Sp� na za�iatok";
    $text['beginswith'] = "Za��na na";
    $text['allbeginningwith'] = "V�etky priezvisk� za��naj�ce na";
    $text['numoccurrences'] = "celkov� po�et miest v z�vorke";
    $text['placesstarting'] = "Zobrazi� najv�znamnej�ie miesta, ktor� za��naj� na";
    $text['showmatchingplaces'] = "Kliknut�m na miesto sa zobrazia men�ie lokality. Kliknut�m na ikonu H�ada� sa zobrazia odpovedaj�ce osoby.";
    $text['totalnames'] = "celkom os�b";
    $text['showallplaces'] = "Zobrazi� v�etky najv�znamnej�ie lokality";
    $text['totalplaces'] = "celkom miest";
    $text['mainplacepage'] = "Hlavn� str�nka miest";
    $text['allplaces'] = "V�etky najv�znamnej�ie lokality";
    $text['placescont'] = "Zobrazi� v�etky miesta obsahuj�ce";
    //changed in 8.0.0
    $text['top30'] = "xxx naj�astej�ie sa vyskytuj�cich priezvisk";
    $text['top30places'] = "xxx najv�znamnej��ch lokal�t";
    //added in 12.0.0
    $text['firstnamelist'] = "Zoznam krstn�ch mien";
    $text['firstnamesstarting'] = "Zobrazi� krstn� men� za��naj�ce na";
    $text['showallfirstnames'] = "Zobrazi� v�etky krstn� men�";
    $text['mainfirstnamepage'] = "Hlavn� str�nka krstn�ch mien";
    $text['allfirstnames'] = "V�etky krstn� men�";
    $text['showmatchingfirstnames'] = "Kliknut�m na krstn� meno sa zobrazia odpovedaj�ce z�znamy.";
    $text['allfirstbegwith'] = "V�etky krstn� men� za��naj�ce na";
    $text['top30first'] = "Top xxx naj�astej�ie sa vyskytuj�cich krstn�ch mien";
    $text['allothers'] = "V�etky ostatn�";
    $text['amongall'] = "(medzi v�etk�mi menami)";
    $text['justtop'] = "Len top xxx";
    break;

  //whatsnew.php
  case "whatsnew":
    $text['pastxdays'] = "(v posledn�ch xx d�och)";

    $text['photo'] = "Fotografia";
    $text['history'] = "Historka/Dokument";
    $text['husbid'] = "ID ��slo otca";
    $text['husbname'] = "Meno otca";
    $text['wifeid'] = "ID ��slo matky";
    //added in 11.0.0
    $text['wifename'] = "Meno matky";
    break;

  //timeline.php, timeline2.php
  case "timeline":
    $text['text_delete'] = "Odstr�ni�";
    $text['addperson'] = "Prida� osobu";
    $text['nobirth'] = "Nasleduj�ca osoba nem� platn� d�tum narodenia, a nemo�no ju prida�";
    $text['event'] = "Udalosti";
    $text['chartwidth'] = "��rka sch�my";
    $text['timelineinstr'] = "Prida� osoby";
    $text['togglelines'] = "Prepn�� zobrazenie osi";
    //changed in 9.0.0
    $text['noliving'] = "Nasleduj�ca osoba je ozna�en� ako �ij�ca alebo neverejn�, nemo�no ju pridat, preto�e nem�te n�le�it� pr�stupov� pr�va";
    break;

  //browsetrees.php
  //login.php, newacctform.php, addnewacct.php
  case "trees":
  case "login":
    $text['browsealltrees'] = "Prehliadava� v�etky stromy";
    $text['treename'] = "N�zov stromu";
    $text['owner'] = "Majite�";
    $text['address'] = "Adresa";
    $text['city'] = "Mesto/obec";
    $text['state'] = "�t�t/Kraj";
    $text['zip'] = "PS�";
    $text['country'] = "Krajina";
    $text['email'] = "Email";
    $text['phone'] = "Telef�n";
    $text['username'] = "Pou��vate�. meno";
    $text['password'] = "Heslo";
    $text['loginfailed'] = "Chyba prihl�senia.";

    $text['regnewacct'] = "Registr�cia nov�ho ��tu";
    $text['realname'] = "Va�e meno a priezvisko";
    $text['phone'] = "Telef�n";
    $text['email'] = "Email";
    $text['address'] = "Adresa";
    $text['acctcomments'] = "Pozn�mky";
    $text['submit'] = "Odosla�";
    $text['leaveblank'] = "(nechajte toto pole pr�zdne, ak �iadate o nov� strom)";
    $text['required'] = "Tieto �daje je nutn� vyplni�";
    $text['enterpassword'] = "Zadajte heslo.";
    $text['enterusername'] = "Zadajte pou��vate�sk� meno.";
    $text['failure'] = "Zadan� pou��vate�sk� meno sa u� pou��va. Pros�m, pou�ite tla�idlo Sp� na prehliada�i na n�vrat sp� na predch�dzaj�cu str�nku a zadajte in� pou��vate�sk� meno";
    $text['success'] = "�akujeme, va�a registr�cia prebehla �spe�ne. Budeme v�s informova�, kedy v� ��et bude akt�vny, alebo ak bud� potrebn� �al�ie inform�cie.";
    $text['emailsubject'] = "�iados� o nov� registr�ciu";
    $text['website'] = "Webov� str�nka";
    $text['nologin'] = "Nem�te prihlasovacie �daje?";
    $text['loginsent'] = "Prihlasovacie �daje boli odosl�n�";
    $text['loginnotsent'] = "Prihlasovacie �daje neboli odoslan�";
    $text['enterrealname'] = "Zadajte, pros�m, svoje skuto�n� meno.";
    $text['rempass'] = "Zosta� prihl�sen� na tomto po��ta�i";
    $text['morestats'] = "�al�ia �tatistika";
    $text['accmail'] = "POZN�MKA: Aby ste mohli prija� email z tejto administr�torskej str�nky oh�adom v�ho ��tu, skontrolujte, pros�m, �i neblokujete emaily z tejto dom�ny.";
    $text['newpassword'] = "Nov� heslo";
    $text['resetpass'] = "Obnovi� va�e heslo";
    $text['nousers'] = "Tento formul�r nemo�no pou�i�, k�m nebude vytvoren� aspo� jeden z�znam pou��vate�a. Ak ste majite�om t�chto str�nok, cho�te do ponuky Admin/Pou��vatelia a vytvorte si ��et administr�tora.";
    $text['noregs'] = "Je n�m ��to, ale v s��asnej dobe neprij�mame nov� registr�cie. Kontaktujte n�s, pros�m, priamo, ak m�te nejak� dotazy �i pripomienky oh�adom t�chto webov�ch str�nok.";
    //changed in 8.0.0
    $text['emailmsg'] = "Bola v�m odoslan� nov� �iados� o pou��vate�sk� ��et TNG. Prihl�ste sa, pros�m, do administr�torsk�ho prostredia a dajte nov�mu ��tu patri�n� pr�stupov� pr�va.";
    $text['accactive'] = "��et bol aktivovan�, ale pou��vate� nebude ma� �iadn� zvl�tne pr�va, k�m mu ich nepridel�te.";
    $text['accinactive'] = "Nastavenie ��tu m��ete urobi� v Admin/Pou��vatelia/Presk�ma�. ��et zostane neakt�vny, k�m aspo� raz z�znam neuprav�te a neulo��te.";
    $text['pwdagain'] = "Znova heslo";
    $text['enterpassword2'] = "Pros�m, vlo�te znova svoje heslo.";
    $text['pwdsmatch'] = "Va�e heslo sa nezhoduje. Pros�m, zadajte to ist� heslo do ka�d�ho po�a.";
    //added in 8.0.0
    $text['acksubject'] = "�akujeme za registr�ciu"; //for a new user account
    $text['ackmessage'] = "Va�a �iados� o pou��vate�sk� ��et bola prijat�. V� ��et nebude akt�vny, k�m nebude schv�len� administr�torom. O v�sledku budeme v�s informova� emailom.";
    //added in 12.0.0
    $text['switch'] = "Prepn��";
    break;

  //added in 10.0.0
  case "branches":
    $text['browseallbranches'] = "Prehliadava� v�etky vetvy";
    break;

  //statistics.php
  case "stats":
    $text['quantity'] = "Mno�stvo";
    $text['totindividuals'] = "Celkom os�b";
    $text['totmales'] = "Celkom mu�ov";
    $text['totfemales'] = "Celkom �ien";
    $text['totunknown'] = "Celkom neur�en�ho pohlavia";
    $text['totliving'] = "Celkom �ij�cich";
    $text['totfamilies'] = "Celkom rod�n";
    $text['totuniquesn'] = "Celkom jedine�n�ch priezvisk";
    //$text['totphotos'] = "Total Photos";
    //$text['totdocs'] = "Total Histories &amp; Documents";
    //$text['totheadstones'] = "Total Headstones";
    $text['totsources'] = "Celkom zdrojov";
    $text['avglifespan'] = "Priemern� d�ka �ivota";
    $text['earliestbirth'] = "Najsk�r naroden�";
    $text['longestlived'] = "Najdlh�ie �ij�ci";
    $text['days'] = "dn�";
    $text['age'] = "Vek";
    $text['agedisclaimer'] = "V�po�ty spojen� s vekom sa zakladaj� na �dajoch os�b, ktor� maj� zadan� d�tum narodenia <EM>a</EM> d�tum �mrtia.  Ke�e niektor� �daje s� ne�pln� (napr. pri �mrt� je zadan� len rok \"1945\" alebo \"pred 1860\"), tieto v�po�ty nemusia by� 100% presn�.";
    $text['treedetail'] = "�al�ie inform�cie o tomto strome";
    $text['total'] = "Celkom";
    //added in 12.0
    $text['totdeceased'] = "Celkom zosnul�ch";
    break;

  case "notes":
    $text['browseallnotes'] = "Prehliada� v�etky pozn�mky";
    break;

  case "help":
    $text['menuhelp'] = "Pomocn�k ponuky";
    break;

  case "install":
    $text['perms'] = "V�etky povolenia boli nastaven�.";
    $text['noperms'] = "Povolenia nemohli by� nastaven� pre tieto s�bory:";
    $text['manual'] = "Nastavte ich, pros�m, manu�lne.";
    $text['folder'] = "Prie�inok";
    $text['created'] = "bol vytvoren�";
    $text['nocreate'] = "nemohol by� vytvoren�. Vytvorte ho, pros�m, manu�lne.";
    $text['infosaved'] = "Inform�cie s� ulo�en�, spojenie overen�!";
    $text['tablescr'] = "Tabu�ky boli vytvoren�!";
    $text['notables'] = "Nasleduj�ce tabu�ky nemohli by� vytvoren�:";
    $text['nocomm'] = "TNG nem��e nadviaza� komunik�ciu s va�ou datab�zou. �iadne tabu�ky neboli vytvoren�.";
    $text['newdb'] = "Inform�cie ulo�en�, spojenie overen�, bola vytvoren� nov� datab�za:";
    $text['noattach'] = "Inform�cie ulo�en�. Spojenie nadviazan� a datab�za vytvoren�, ale TNG sa nem��e k nej pripoji�.";
    $text['nodb'] = "Inform�cie ulo�en�. Spojenie nadviazan�, ale datab�za neexistuje a nemohla by� vytvoren�. Overte si, �i n�zov datab�zy je spr�vny alebo pou�ijte ovl�dac� panel a vytvorte ju.";
    $text['noconn'] = "Inform�cie ulo�en�, ale spojenie nebolo nadviazan�.  Niektor� z n�sleduj�ch vec� s� chybn�:";
    $text['exists'] = "u� existuje";
    $text['loginfirst'] = "Najsk�r sa mus�te prihl�si�.";
    $text['noop'] = "Nevykonala sa �iadna oper�cia.";
    //added in 8.0.0
    $text['nouser'] = "��et nebol vytvoren�. Pou��vate�sk� meno asi u� existuje.";
    $text['notree'] = "Strom nebol vytvoren�. ID ��slo stromu asi u� existuje.";
    $text['infosaved2'] = "Inform�cia ulo�en�";
    $text['renamedto'] = "premenovan� na";
    $text['norename'] = "nemohol by� premenovan�";
    break;

  case "imgviewer":
    $text['zoomin'] = "Pribl�i�";
    $text['zoomout'] = "Oddiali�";
    $text['magmode'] = "Re�im zv��ovania";
    $text['panmode'] = "Re�im sledovania";
    $text['pan'] = "Ak obr�zok je v��� ako okno prehliada�a, po obr�zku sa pres�vate kliknut�m a �ahan�m my�ou.";
    $text['fitwidth'] = "Na cel� ��rku";
    $text['fitheight'] = "Na cel� v��ku";
    $text['newwin'] = "Nov� okno";
    $text['opennw'] = "Otvori� obr�zok v novom okne";
    $text['magnifyreg'] = "Kliknut�m my�ou do obr�zka zv���te t�to �as� obr�zka";
    $text['imgctrls'] = "Zapn�� ovl�dacie prvky obr�zka";
    $text['vwrctrls'] = "Zapn�� ovl�dacie prvky prehliada�a obr�zkov";
    $text['vwrclose'] = "Zavrie� prehliada� obr�zkov";
    break;

  case "dna":
    $text['test_date'] = "D�tum testu";
    $text['links'] = "Pr�slu�n� odkazy";
    $text['testid'] = "ID testu";
    //added in 12.0.0
    $text['mode_values'] = "Hodnoty m�du";
    $text['compareselected'] = "Porovna� vybran�";
    $text['dnatestscompare'] = "Porovna� Y-DNA testy";
    $text['keep_name_private'] = "Dr�a� meno ako neverejn�";
    $text['browsealltests'] = "Preh�ad�va� v�etky testy";
    $text['all_dna_tests'] = "V�etky DNA testy";
    $text['fastmutating'] = "R�chle mutovanie";
    $text['alltypes'] = "V�etky typy";
    $text['allgroups'] = "V�etky skupiny";
    $text['Ydna_LITbox_info'] = "Testy spojen� s touto osobou nemuseli by� nutne absolvovan� touto osobou.<br />V st�pci 'Haploskupina' sa zobrazia �daje �ervenou farbou, ak v�sledok je 'Predpovedan�', alebo zelenou farbou, ak test je 'Potvrden�'";
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
$text['matches'] = "Zhody";
$text['description'] = "Popis";
$text['notes'] = "Pozn�mky";
$text['status'] = "Stav";
$text['newsearch'] = "Nov� h�adanie";
$text['pedigree'] = "Rodokme�";
$text['seephoto'] = "Pozrie� fotografiu";
$text['andlocation'] = "&amp; miesto";
$text['accessedby'] = "spr�stupnil";
$text['family'] = "Rodina"; //from getperson
$text['children'] = "Deti";  //from getperson
$text['tree'] = "Strom";
$text['alltrees'] = "V�etky stromy";
$text['nosurname'] = "[bez priezviska]";
$text['thumb'] = "Miniat�ra";  //as in Thumbnail
$text['people'] = "�udia";
$text['title'] = "Titul";  //from getperson
$text['suffix'] = "Pr�pona";  //from getperson
$text['nickname'] = "Prez�vka";  //from getperson
$text['lastmodified'] = "Posledn� zmena";  //from getperson
$text['married'] = "Sob�";  //from getperson
//$text['photos'] = "Photos";
$text['name'] = "Meno"; //from showmap
$text['lastfirst'] = "Priezvisko, meno";  //from search
$text['bornchr'] = "Narod./krst";  //from search
$text['individuals'] = "Osoby";  //from whats new
$text['families'] = "Rodiny";
$text['personid'] = "ID ��slo osoby";
$text['sources'] = "Zdroje";  //from getperson (next several)
$text['unknown'] = "Nezn�me";
$text['father'] = "Otec";
$text['mother'] = "Matka";
$text['christened'] = "Krstenie";
$text['died'] = "�mrtie";
$text['buried'] = "Pohreb";
$text['spouse'] = "Partner";  //from search
$text['parents'] = "Rodi�ia";  //from pedigree
$text['text'] = "Text";  //from sources
$text['language'] = "Jazyk";  //from languages
$text['descendchart'] = "Sch�ma potomkov";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Osoba";
$text['edit'] = "Upravi�";
$text['date'] = "D�tum";
$text['place'] = "Miesto";
$text['login'] = "Prihl�senie";
$text['logout'] = "Odhl�senie";
$text['groupsheet'] = "H�rok rodiny";
$text['text_and'] = "a";
$text['generation'] = "Gener�cia";
$text['filename'] = "N�zov s�boru";
$text['id'] = "ID ��slo";
$text['search'] = "H�ada�";
$text['user'] = "Pou��vate�";
$text['firstname'] = "Meno";
$text['lastname'] = "Priezvisko";
$text['searchresults'] = "V�sledky h�adania";
$text['diedburied'] = "�mrtie/Pohreb";
$text['homepage'] = "Domovsk� str�nka";
$text['find'] = "N�js� (osobu)";
$text['relationship'] = "Pr�buz. vz�ah";    //in German, Verwandtschaft
$text['relationship2'] = "Pr�buz. vz�ah"; //different in some languages, at least in German (Beziehung)
$text['timeline'] = "�asov� os";
$text['yesabbr'] = "�";               //abbreviation for 'yes'
$text['divorced'] = "Rozvod";
$text['indlinked'] = "Spojen� s";
$text['branch'] = "Vetva";
$text['moreind'] = "�al�ie osoby";
$text['morefam'] = "�al�ie rodiny";
$text['source'] = "Zdroj";
$text['surnamelist'] = "Zoznam priezvisk";
$text['generations'] = "Gener�cie";
$text['refresh'] = "Obnovi�";
$text['whatsnew'] = "�o je nov�";
$text['reports'] = "Zostavy";
$text['placelist'] = "Zoznam miest";
$text['baptizedlds'] = "Krstenie (CJKSpd)";
$text['endowedlds'] = "Obdarovanie (CJKSpd)";
$text['sealedplds'] = "Pe�atenie R (CJKSpd)";
$text['sealedslds'] = "Pe�atenie P (CJKSpd)";
$text['ancestors'] = "Predkovia";
$text['descendants'] = "Potomkovia";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "D�tum posledn�ho importu s�boru GEDCOM";
$text['type'] = "Druh";
$text['savechanges'] = "Ulo�i� zmeny";
$text['familyid'] = "ID ��slo rodiny";
$text['headstone'] = "N�hrobky";
$text['historiesdocs'] = "Historky";
$text['anonymous'] = "anonymn�";
$text['places'] = "Miesta";
$text['anniversaries'] = "D�tumy a v�ro�ia";
$text['administration'] = "Administr�cia";
$text['help'] = "Pomocn�k";
//$text['documents'] = "Documents";
$text['year'] = "Rok";
$text['all'] = "V�etko";
$text['repository'] = "Arch�v";
$text['address'] = "Adresa";
$text['suggest'] = "Navrhn��";
$text['editevent'] = "Navrhn�� zmenu pre t�to udalos�";
$text['findplaces'] = "N�js� v�etky osoby s udalos�ami na tomto mieste";
$text['morelinks'] = "Viac odkazov";
$text['faminfo'] = "Inform�cie o rodine";
$text['persinfo'] = "Osobn� inform�cie";
$text['srcinfo'] = "Inform�cie o zdroji";
$text['fact'] = "Fakt";
$text['goto'] = "Vyberte str�nku";
$text['tngprint'] = "Tla�";
$text['databasestatistics'] = "�tatistika datab�zy"; //needed to be shorter to fit on menu
$text['child'] = "Die�a";  //from familygroup
$text['repoinfo'] = "�daje o arch�ve";
$text['tng_reset'] = "Obnovi�";
$text['noresults'] = "Neboli n�jden� �iadne v�sledky";
$text['allmedia'] = "V�etky m�di�";
$text['repositories'] = "Arch�vy";
$text['albums'] = "Albumy";
$text['cemeteries'] = "Cintor�ny";
$text['surnames'] = "Priezvisk�";
$text['dates'] = "D�tumy";
$text['link'] = "Odkaz";
$text['media'] = "M�di�";
$text['gender'] = "Pohlavie";
$text['latitude'] = "Zem. ��rka";
$text['longitude'] = "Zem. d�ka";
$text['bookmarks'] = "Z�lo�ky";
$text['bookmark'] = "Z�lo�ka";
$text['mngbookmarks'] = "Prejs� na z�lo�ky";
$text['bookmarked'] = "Z�lo�ka pridan�";
$text['remove'] = "Odstr�ni�";
$text['find_menu'] = "N�js�";
$text['info'] = "Info"; //this needs to be a very short abbreviation
$text['cemetery'] = "Cintor�n";
$text['gmapevent'] = "Mapa udalost�";
$text['gevents'] = "Udalos�";
$text['glang'] = "&amp;hl=cs";
$text['googleearthlink'] = "Odkaz na Google Earth";
$text['googlemaplink'] = "Odkaz na Google Maps";
$text['gmaplegend'] = "Pripn�� legendu";
$text['unmarked'] = "Neozna�en�";
$text['located'] = "Lokalizovan�";
$text['albclicksee'] = "Kliknite na zobrazenie v�etk�ch polo�iek v tomto albume";
$text['notyetlocated'] = "E�te nelokalizovan�";
$text['cremated'] = "Spopolnen�(�)";
$text['missing'] = "Ch�baj�ci";
$text['pdfgen'] = "Gener�tor PDF";
$text['blank'] = "Pr�zdna";
$text['none'] = "�iadny";
$text['fonts'] = "Fonty";
$text['header'] = "Hlavi�ka";
$text['data'] = "D�ta";
$text['pgsetup'] = "Nastavenie str�nky";
$text['pgsize'] = "Ve�kos� str�nky";
$text['orient'] = "Orient�cia"; //for a page
$text['portrait'] = "Na v��ku";
$text['landscape'] = "Na ��rku";
$text['tmargin'] = "Horn� okraj";
$text['bmargin'] = "Spodn� okraj";
$text['lmargin'] = "�av� okraj";
$text['rmargin'] = "Prav� okraj";
$text['createch'] = "Vytvori�";
$text['prefix'] = "Predpona";
$text['mostwanted'] = "Najh�adanej�ie";
$text['latupdates'] = "Najnov�ie aktualiz�cie";
$text['featphoto'] = "Hlavn� fotografia";
$text['news'] = "Novinky";
$text['ourhist'] = "Hist�ria na�ej rodiny";
$text['ourhistanc'] = "Hist�ria a predkovia na�ej rodiny";
$text['ourpages'] = "Genealogick� str�nky na�ej rodiny";
$text['pwrdby'] = "Tieto str�nky be�ia na";
$text['writby'] = "vytvoril";
$text['searchtngnet'] = "Preh�ada� TNG sie� (GENDEX)";
$text['viewphotos'] = "Prezrie� v�etky fotografie";
$text['anon'] = "Moment�lne ste anonymn�";
$text['whichbranch'] = "Z ktorej vetvy ste?";
$text['featarts'] = "Najzauj�mavej�ie �l�nky";
$text['maintby'] = "Syst�m spravuje";
$text['createdon'] = "Vytvoren�";
$text['reliability'] = "Vierohodnos�";
$text['labels'] = "N�vestia";
$text['inclsrcs'] = "Zahrn�� zdroje";
$text['cont'] = "(pokra�.)"; //abbreviation for continued
$text['mnuheader'] = "Domovsk� str�nka";
$text['mnusearchfornames'] = "H�ada�";
$text['mnulastname'] = "Priezvisko";
$text['mnufirstname'] = "Meno";
$text['mnusearch'] = "H�ada�";
$text['mnureset'] = "Za�a� znova";
$text['mnulogon'] = "Prihl�senie";
$text['mnulogout'] = "Odhl�senie";
$text['mnufeatures'] = "�al�ie vlastnosti";
$text['mnuregister'] = "Registr�cia ��tu pou��vate�a";
$text['mnuadvancedsearch'] = "Roz��ren� h�adanie";
$text['mnulastnames'] = "Priezvisk�";
$text['mnustatistics'] = "�tatistika";
$text['mnuphotos'] = "Fotografie";
$text['mnuhistories'] = "Historky";
$text['mnumyancestors'] = "Fotografie &amp; Historky o predkoch od [Person]";
$text['mnucemeteries'] = "Cintor�ny";
$text['mnutombstones'] = "N�hrobky";
$text['mnureports'] = "Zostavy";
$text['mnusources'] = "Zdroje";
$text['mnuwhatsnew'] = "�o je nov�";
$text['mnushowlog'] = "Protokol pr�stupov";
$text['mnulanguage'] = "Zmena jazyka";
$text['mnuadmin'] = "Administr�cia";
$text['welcome'] = "Vitajte";
$text['contactus'] = "Nap�te n�m";
//changed in 8.0.0
$text['born'] = "Narodenie";
$text['searchnames'] = "H�ada� osoby";
//added in 8.0.0
$text['editperson'] = "Upravi� osobu";
$text['loadmap'] = "Zavies� mapu";
$text['birth'] = "Narodenie";
$text['wasborn'] = "sa narodil(a)";
$text['startnum'] = "Prv� ��slo";
$text['searching'] = "H�adam";
//moved here in 8.0.0
$text['location'] = "Umiestnenie";
$text['association'] = "Spojenie";
$text['collapse'] = "Zbali�";
$text['expand'] = "Rozbali�";
$text['plot'] = "Zazna�i�";
$text['searchfams'] = "H�ada� rodiny";
//added in 8.0.2
$text['wasmarried'] = "sob�. s";
$text['anddied'] = "zomrel(a)";
//added in 9.0.0
$text['share'] = "Zdie�a�";
$text['hide'] = "Skry�";
$text['disabled'] = "V� pou��vate�sk� ��et bol zablokovan�.  Kontaktujte, pros�m, administr�tora t�chto webov�ch str�nok.";
$text['contactus_long'] = "Ak m�te nejak� ot�zky alebo pripomienky oh�adom inform�ci� na t�chto str�nkach alebo by ste mali z�ujem spolupracova� na �al�om v�skume, pr�padne poskytn�� �al�ie inform�cie, nev�hajte a <span class=\"emphasis\"><a href=\"suggest.php\">kontaktujte ma</a></span>.";
$text['features'] = "Vlastnosti";
$text['resources'] = "Prostriedky";
$text['latestnews'] = "Posledn� novinky";
$text['trees'] = "Stromy";
$text['wasburied'] = "pochov.:";
//moved here in 9.0.0
$text['emailagain'] = "Email znova";
$text['enteremail2'] = "Zadajte, pros�m, znova va�u emailov� adresu.";
$text['emailsmatch'] = "Zadan� emailov� adresy nie s� rovnak�. Zadajte rovnak� emailov� adresu do obidvoch pol�.";
$text['getdirections'] = "Kliknite na z�skanie podrobnost�";
$text['calendar'] = "Kalend�r";
//changed in 9.0.0
$text['directionsto'] = " k ";
$text['slidestart'] = "Prezent�cia";
$text['livingnote'] = "S touto pozn�mkou je spojen� aspo� jedna �ij�ca alebo neverejn� osoba - podrobnosti nie s� zverejnen�.";
$text['livingphoto'] = "S touto polo�kou je spojen� aspo� jedna �ij�ca alebo neverejn� osoba - podrobnosti nie s� zverejnen�.";
$text['waschristened'] = "krst.:";
//added in 10.0.0
$text['branches'] = "Vetvy";
$text['detail'] = "Detail";
$text['moredetail'] = "Viac detailov";
$text['lessdetail'] = "Menej detailov";
$text['otherevents'] = "In� udalosti";
$text['conflds'] = "Birmovanie (CJKSpd)";
$text['initlds'] = "Zasv�tenie (CJKSpd)";
$text['wascremated'] = "bol(a) spopolnen�(�)";
//moved here in 11.0.0
$text['text_for'] = "pre";
//added in 11.0.0
$text['searchsite'] = "Preh�ad�va� toto s�dlo";
$text['searchsitemenu'] = "S�dlo h�adania";
$text['kmlfile'] = "Stiahnite s�bor .kml na�zobrazenie tejto lokality v Google Earth";
$text['download'] = "Kliknite na stiahnutie";
$text['more'] = "Viac";
$text['heatmap'] = "Zobrazi� mapu";
$text['refreshmap'] = "Obnovi� mapu";
$text['remnums'] = "Vymaza� ��sla a  �pendl�ky";
$text['photoshistories'] = "Fotografie &amp; Historky";
$text['familychart'] = "Rodinn� sch�ma";
//added in 12.0.0
$text['firstnames'] = "Prv� men�";
//moved here in 12.0.0
$text['dna_test'] = "DNA test";
$text['test_type'] = "Typ testu";
$text['test_info'] = "Inform�cia o teste";
$text['takenby'] = "Zobral: ";
$text['haplogroup'] = "Haploskupina";
$text['hvr1'] = "HVR1";
$text['hvr2'] = "HVR2";
$text['relevant_links'] = "D�le�it� spojenia";
$text['nofirstname'] = "[�iadne krstn� meno]";
//added in 12.0.1
$text['cookieuse'] = "V�imnite si, �e toto webov� s�dlo pou��va cookies.";
$text['dataprotect'] = "Z�sady ochrany �dajov";
$text['viewpolicy'] = "Pozrie� z�sady";
$text['understand'] = "Rozumiem";
$text['consent'] = "D�vam svoj s�hlas pre toto webov� s�dlo na uchov�vanie tu nazbieran�ch osobn�ch inform�ci�. Viem, �e hocikedy m��em po�iada� vlastn�ka tohto s�dla na odstr�nenie t�chto inform�ci�.";
$text['consentreq'] = "Pros�m, dajte svoj s�hlas pre toto webov� s�dlo na ukladanie osobn�ch inform�ci�.";

//added in 12.1.0
$text['testsarelinked'] = "DNA tests are associated with";
$text['testislinked'] = "DNA test is associated with";

//added in 12.2
$text['quicklinks'] = "Quick Links";
$text['yourname'] = "Your Name";
$text['youremail'] = "Your Email Address";
$text['liketoadd'] = "Any info you'd like to add";
$text['webmastermsg'] = "Webmaster Message";
$text['gallery'] = "See Gallery";
$text['wasborn_male'] = "was born";    // same as $text['wasborn'] if no gender verb
$text['wasborn_female'] = "was born";  // same as $text['wasborn'] if no gender verb
$text['waschristened_male'] = "was christened";  // same as $text['waschristened'] if no gender verb
$text['waschristened_female'] = "was christened";  // same as $text['waschristened'] if no gender verb
$text['died_male'] = "died";  // same as $text['anddied'] of no gender verb
$text['died_female'] = "died";  // same as $text['anddied'] of no gender verb
$text['wasburied_male'] = "was buried";  // same as $text['wasburied'] if no gender verb
$text['wasburied_female'] = "was buried";  // same as $text['wasburied'] if no gender verb
$text['wascremated_male'] = "was cremated";    // same as $text['wascremated'] if no gender verb
$text['wascremated_female'] = "was cremated";  // same as $text['wascremated'] if no gender verb
$text['wasmarried_male'] = "married";  // same as $text['wasmarried'] if no gender verb
$text['wasmarried_female'] = "married";  // same as $text['wasmarried'] if no gender verb
$text['wasdivorced_male'] = "was divorced";  // might be the same as $text['divorce'] but as a verb
$text['wasdivorced_female'] = "was divorced";  // might be the same as $text['divorce'] but as a verb
$text['inplace'] = " in ";      // used as a preposition to the location
$text['onthisdate'] = " on ";    // when used with full date
$text['inthisyear'] = " in ";    // when used with year only or month / year dates
$text['and'] = "and ";        // used in conjunction with wasburied or was cremated

//moved here in 12.3
$text['dna_info_head'] = "Inform�cia k DNA testu";
$text['firstpage'] = "Prv� str�nka";
$text['lastpage'] = "Posledn� str�nka";

@include_once("captcha_text.php");
@include_once("alltext.php");
if (!$alltextloaded) {
  getAllTextPath();
}
?>
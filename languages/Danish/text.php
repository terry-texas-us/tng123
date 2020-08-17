<?php
switch ($textpart) {
  //browsesources.php, showsource.php
  case "sources":
    $text['browseallsources'] = "S�g i alle kilder";
    $text['shorttitle'] = "Titel";
    $text['callnum'] = "Nummer";
    $text['author'] = "Forfatter";
    $text['publisher'] = "Udgiver";
    $text['other'] = "Andre oplysninger";
    $text['sourceid'] = "Kilde-ID";
    $text['moresrc'] = "Flere kilder";
    $text['repoid'] = "Arkiv-ID";
    $text['browseallrepos'] = "S�g i alle arkiver";
    break;

  //changelanguage.php, savelanguage.php
  case "language":
    $text['newlanguage'] = "Nyt sprog";
    $text['changelanguage'] = "Skift sprog";
    $text['languagesaved'] = "Sproget er gemt";
    $text['sitemaint'] = "Hjemmesiden opdateres i �jeblikket";
    $text['standby'] = "Hjemmesiden er ikke tilg�ngelig i �jeblikket pga. opdatering. Pr�v igen om nogle minutter. Hvis siden ikke er tilg�ngelig inden for kort tid, <a href=\"suggest.php\">kontakt da hjemmesidens administrator</a>.";
    break;

  //gedcom.php, gedform.php
  case "gedcom":
    $text['gedstart'] = "GEDCOM begynder med";
    $text['producegedfrom'] = "Opret en GEDCOM-fil fra";
    $text['numgens'] = "Antal generationer";
    $text['includelds'] = "Inkluder SDH-oplysninger";
    $text['buildged'] = "Opret GEDCOM";
    $text['gedstartfrom'] = "GEDCOM begynder med";
    $text['nomaxgen'] = "Angiv antal generationer. Brug Tilbage-tasten for at rette fejlen";
    $text['gedcreatedfrom'] = "GEDCOM oprettet fra";
    $text['gedcreatedfor'] = "GEDCOM oprettet for";
    $text['creategedfor'] = "Opret GEDCOM for";
    $text['email'] = "mailadresse";
    $text['suggestchange'] = "Foresl� en �ndring";
    $text['yourname'] = "Dit navn";
    $text['comments'] = "Bem�rkninger og kommentarer";
    $text['comments2'] = "Bem�rkninger";
    $text['submitsugg'] = "Send forslag";
    $text['proposed'] = "Foresl�et �ndring";
    $text['mailsent'] = "Tak. Beskeden er sendt.";
    $text['mailnotsent'] = "Beklager, men beskeden kunne ikke leveres. Kontakt venligst xxx direkte p� yyy.";
    $text['mailme'] = "Send en kopi til denne mailadresse";
    $text['entername'] = "Skriv venligst dit navn";
    $text['entercomments'] = "Skriv venligst dine kommentarer";
    $text['sendmsg'] = "Send meddelelse";
    //added in 9.0.0
    $text['subject'] = "Emne";
    break;

  //getextras.php, getperson.php
  case "getperson":
    $text['photoshistoriesfor'] = "Billeder og fort�llinger for";
    $text['indinfofor'] = "Individuelle oplysninger om";
    $text['pp'] = "pp."; //page abbreviation
    $text['age'] = "Alder";
    $text['agency'] = "Firma";
    $text['cause'] = "�rsag";
    $text['suggested'] = "Foresl�et";
    $text['closewindow'] = "Luk dette vindue";
    $text['thanks'] = "Tak";
    $text['received'] = "Dit forslag er videresendt.";
    $text['indreport'] = "Personrapport";
    $text['indreportfor'] = "Personrapport for ";
    $text['general'] = "Generelt";
    $text['bkmkvis'] = "<strong>Note:</strong> Disse bogm�rker er kun synlige p� denne PC og i denne browser.";
    //added in 9.0.0
    $text['reviewmsg'] = "Du har foresl�et en �ndring, som skal tjekkes. Indsendelsen vedr�rer:";
    $text['revsubject'] = "Foresl�et �ndring kr�ver din godkendelse";
    break;

  //relateform.php, relationship.php, findpersonform.php, findperson.php
  case "relate":
    $text['relcalc'] = "Sl�gtskabsberegner";
    $text['findrel'] = "Find sl�gtskab";
    $text['person1'] = "Person 1:";
    $text['person2'] = "Person 2:";
    $text['calculate'] = "Beregn";
    $text['select2inds'] = "V�lg to personer.";
    $text['findpersonid'] = "Find person-ID";
    $text['enternamepart'] = "indtast del af for- og/eller efternavn";
    $text['pleasenamepart'] = "Indtast del af for- eller efternavn.";
    $text['clicktoselect'] = "klik for at v�lge";
    $text['nobirthinfo'] = "Ingen f�dselsoplysninger";
    $text['relateto'] = "Sl�gtskab til";
    $text['sameperson'] = "De to personer er identiske.";
    $text['notrelated'] = "De to personer er ikke i sl�gt med hinanden indenfor xxx generationer."; //xxx will be replaced with number of generations
    $text['findrelinstr'] = "For at vise sl�gtskabet mellem to personer, skal du bruge 'Find'-knapperne nedenfor for at finde de aktuelle personer (eller behold de viste personer), derefter klikkes p� 'Beregn'.";
    $text['sometimes'] = "(Sommetider kan man ved at v�lge et andet antal generationer f� et andet resultat.)";
    $text['findanother'] = "Find et andet sl�gtskab";
    $text['brother'] = "bror til";
    $text['sister'] = "s�ster til";
    $text['sibling'] = "bror/s�ster";
    $text['uncle'] = "xxx onkel til";
    $text['aunt'] = "xxx tante til";
    $text['uncleaunt'] = "xxx onkel/tante til";
    $text['nephew'] = "xxx nev� til";
    $text['niece'] = "xxx niece til";
    $text['nephnc'] = "xxx nev�/niece til";
    $text['removed'] = "gange forskudt";
    $text['rhusband'] = "�gtemand til ";
    $text['rwife'] = "hustru til ";
    $text['rspouse'] = "�gtef�lle til ";
    $text['son'] = "s�n af";
    $text['daughter'] = "datter af";
    $text['rchild'] = "barn af";
    $text['sil'] = "svigers�n til";
    $text['dil'] = "svigerdatter til";
    $text['sdil'] = "svigerdatter eller -s�n til";
    $text['gson'] = "xxx barnebarn af";
    $text['gdau'] = "xxx barnebarn af";
    $text['gsondau'] = "xxx barnebarn af";
    $text['great'] = "olde";
    $text['spouses'] = "er �gtef�ller";
    $text['is'] = "er";
    $text['changeto'] = "Skift til: (Indtast ID)";
    $text['notvalid'] = "er ikke et gyldigt person-ID eller eksisterer ikke i denne database. Pr�v igen.";
    $text['halfbrother'] = "halvbror til";
    $text['halfsister'] = "halvs�ster til";
    $text['halfsibling'] = "halvs�skende til";
    //changed in 8.0.0
    $text['gencheck'] = "Maks. antal generationer,<br />der skal tjekkes";
    $text['mcousin'] = "xxx f�tter/kusine yyy til";  //male cousin; xxx = cousin number, yyy = times removed
    $text['fcousin'] = "xxx f�tter/kusine yyy til";  //female cousin
    $text['cousin'] = "xxx f�tter/kusine yyy til";
    $text['mhalfcousin'] = "xxx halvf�tter yyy til";  //male cousin
    $text['fhalfcousin'] = "xxx halvkusine yyy til";  //female cousin
    $text['halfcousin'] = "xxx halvf�tter eller halvkusine yyy til";
    //added in 8.0.0
    $text['oneremoved'] = "en gang forskudt";
    $text['gfath'] = "den xxx bedstefar til";
    $text['gmoth'] = "den xxx bedstemor til";
    $text['gpar'] = "den xxx bedstefor�lder til";
    $text['mothof'] = "mor til";
    $text['fathof'] = "far til";
    $text['parof'] = "for�lder til";
    $text['maxrels'] = "Maks. antal sl�gtskaber, der skal vises";
    $text['dospouses'] = "Vis sl�gtskaber, der involverer �gtef�lle";
    $text['rels'] = "Sl�gtskaber";
    $text['dospouses2'] = "Vis �gtef�ller";
    $text['fil'] = "svigerfar til";
    $text['mil'] = "svigermor til";
    $text['fmil'] = "svigerfar/-mor til";
    $text['stepson'] = "steds�n til";
    $text['stepdau'] = "steddatter til";
    $text['stepchild'] = "stedbarn til";
    $text['stepgson'] = "den xxx steds�ns barn til";
    $text['stepgdau'] = "den xxx steddatters barn til";
    $text['stepgchild'] = "den xxx sted-barnebarn af";
    //added in 8.1.1
    $text['ggreat'] = "olde";
    //added in 8.1.2
    $text['ggfath'] = "xxx oldefar til";
    $text['ggmoth'] = "xxx oldemor til";
    $text['ggpar'] = "xxx oldefor�ldre til";
    $text['ggson'] = "xxx oldebarn af";
    $text['ggdau'] = "xxx oldebarn af";
    $text['ggsondau'] = "xxx oldebarn af";
    $text['gstepgson'] = "xxx stedoldebarn af";
    $text['gstepgdau'] = "xxx stedoldebarn af";
    $text['gstepgchild'] = "xxx stedoldebarn af";
    $text['guncle'] = "xxx grandonkel til";
    $text['gaunt'] = "xxx grantante til";
    $text['guncleaunt'] = "xxx grandonkel / grandtante til";
    $text['gnephew'] = "xxx grandnev� af";
    $text['gniece'] = "xxx grandniece af";
    $text['gnephnc'] = "xxx grandnev� / grandniece af";
    break;

  case "familygroup":
    $text['familygroupfor'] = "Familieskema for";
    $text['ldsords'] = "SDH ordinancer";
    $text['baptizedlds'] = "D�bt (SDH)";
    $text['endowedlds'] = "Begavet (SDH)";
    $text['sealedplds'] = "Beseglet F (SDH)";
    $text['sealedslds'] = "Beseglet � (SDH)";
    $text['otherspouse'] = "Andre partnere";
    $text['husband'] = "Far";
    $text['wife'] = "Mor";
    break;

  //pedigree.php
  case "pedigree":
    $text['capbirthabbr'] = "F";
    $text['capaltbirthabbr'] = "Dbt";
    $text['capdeathabbr'] = "D";
    $text['capburialabbr'] = "B";
    $text['capplaceabbr'] = "S";
    $text['capmarrabbr'] = "G";
    $text['capspouseabbr'] = "BT�";
    $text['redraw'] = "Tegn igen";
    $text['scrollnote'] = "NB: Rul ned for at se hele tr�et.";
    $text['unknownlit'] = "Ukendt";
    $text['popupnote1'] = " = Till�gsoplysninger";
    $text['popupnote2'] = " = Ny anetavle";
    $text['pedcompact'] = "Kompakt";
    $text['pedstandard'] = "Standard";
    $text['pedtextonly'] = "Kun tekst";
    $text['descendfor'] = "Efterkommere af";
    $text['maxof'] = "Maksimum";
    $text['gensatonce'] = "generationer vist samtidig.";
    $text['sonof'] = "s�n af";
    $text['daughterof'] = "datter af";
    $text['childof'] = "barn af";
    $text['stdformat'] = "Standardformat";
    $text['ahnentafel'] = "Anetavle";
    $text['addnewfam'] = "Tilf�j ny familie";
    $text['editfam'] = "Redig�r familie";
    $text['side'] = "Side";
    $text['familyof'] = "Familie til";
    $text['paternal'] = "Far";
    $text['maternal'] = "Mor";
    $text['gen1'] = "Selv";
    $text['gen2'] = "For�ldre";
    $text['gen3'] = "Bedstefor�ldre";
    $text['gen4'] = "Oldefor�ldre";
    $text['gen5'] = "Tipoldefor�ldre";
    $text['gen6'] = "Tiptip-oldefor�ldre";
    $text['gen7'] = "3xtip-oldefor�ldre";
    $text['gen8'] = "4xtip-oldefor�ldre";
    $text['gen9'] = "5xtip-oldefor�ldre";
    $text['gen10'] = "6xtip-oldefor�ldre";
    $text['gen11'] = "7xtip-oldefor�ldre";
    $text['gen12'] = "8xtip-oldefor�ldre";
    $text['graphdesc'] = "Efterkommere til dette punkt";
    $text['pedbox'] = "Felt";
    $text['regformat'] = "Register";
    $text['extrasexpl'] = "Hvis der eksisterer billeder eller fort�llinger for de f�lgende personer, vil tilh�rende ikoner blive vist ved siden af navnene.";
    $text['popupnote3'] = " = Ny tavle";
    $text['mediaavail'] = "Tilg�ngelige medier";
    $text['pedigreefor'] = "Aner til";
    $text['pedigreech'] = "Anetavle";
    $text['datesloc'] = "Datoer og steder";
    $text['borchr'] = "F�dsel/Alt - D�d/Begravelse (to)";
    $text['nobd'] = "Ingen f�dsels- eller d�dsdatoer";
    $text['bcdb'] = "F�dsel/Alt/D�d/Begravelse (fire)";
    $text['numsys'] = "Nummersystem";
    $text['gennums'] = "Generationsnumre";
    $text['henrynums'] = "Henry numre";
    $text['abovnums'] = "d'Aboville numre";
    $text['devnums'] = "de Villiers numre";
    $text['dispopts'] = "Vis mulighederne";
    //added in 10.0.0
    $text['no_ancestors'] = "Ingen aner fundet";
    $text['ancestor_chart'] = "Lodret anetavle";
    $text['opennewwindow'] = "�bn i et nyt vindue";
    $text['pedvertical'] = "Lodret";
    //added in 11.0.0
    $text['familywith'] = "Familie med";
    $text['fcmlogin'] = "Log ind for at se flere oplysninger";
    $text['isthe'] = "er den";
    $text['otherspouses'] = "andre partnere";
    $text['parentfamily'] = "Den biologiske familie ";
    $text['showfamily'] = "Vis familie";
    $text['shown'] = "vist";
    $text['showparentfamily'] = "vis den biologiske familie";
    $text['showperson'] = "vis person";
    //added in 11.0.2
    $text['otherfamilies'] = "Andre familier";
    break;

  //search.php, searchform.php
  //merged with reports and showreport in 5.0.0
  case "search":
  case "reports":
    $text['noreports'] = "Der er ingen rapporter.";
    $text['reportname'] = "Rapportnavn";
    $text['allreports'] = "Alle rapporter";
    $text['report'] = "Rapport";
    $text['error'] = "Fejl";
    $text['reportsyntax'] = "Syntaxen for foresp�rgslen k�rer i denne rapport";
    $text['wasincorrect'] = "var forkert, og rapporten kunne ikke oprettes. Kontakt administratoren p�";
    $text['errormessage'] = "Fejlmelding";
    $text['equals'] = "lig med";
    $text['endswith'] = "ender med";
    $text['soundexof'] = "soundex af";
    $text['metaphoneof'] = "metaphone af";
    $text['plusminus10'] = "+/- 10 �r fra";
    $text['lessthan'] = "f�r";
    $text['greaterthan'] = "efter";
    $text['lessthanequal'] = "Pr�cis eller f�r";
    $text['greaterthanequal'] = "Pr�cis eller efter";
    $text['equalto'] = "lig med";
    $text['tryagain'] = "Pr�v igen";
    $text['joinwith'] = "kombiner med";
    $text['cap_and'] = "OG";
    $text['cap_or'] = "ELLER";
    $text['showspouse'] = "Vis partner(e)";
    $text['submitquery'] = "Begynd s�g";
    $text['birthplace'] = "F�dested";
    $text['deathplace'] = "D�dssted";
    $text['birthdatetr'] = "F�dt �r";
    $text['deathdatetr'] = "D�d �r";
    $text['plusminus2'] = "+/- 2 �r fra";
    $text['resetall'] = "Gendan alle v�rdier";
    $text['showdeath'] = "Vis d�ds-/begravelsesoplysninger";
    $text['altbirthplace'] = "D�bssted";
    $text['altbirthdatetr'] = "D�bs�r";
    $text['burialplace'] = "Begravelsessted";
    $text['burialdatetr'] = "Begravelses�r";
    $text['event'] = "Begivenhed(er)";
    $text['day'] = "Dag";
    $text['month'] = "M�ned";
    $text['keyword'] = "N�gleord (f.eks., \"Omkr.\")";
    $text['explain'] = "Skriv del af dato for at se sammenfaldende begivenheder. Lad feltet v�re tomt for at se sammenfald for alle.";
    $text['enterdate'] = "Skriv eller v�lg mindst �n af de f�lgende: Dag, M�ned, �r, N�gleord";
    $text['fullname'] = "Fuldt navn";
    $text['birthdate'] = "F�dselsdato";
    $text['altbirthdate'] = "D�bsdato";
    $text['marrdate'] = "Vielsesdato";
    $text['spouseid'] = "Partners ID";
    $text['spousename'] = "Partners navn";
    $text['deathdate'] = "D�dsdato";
    $text['burialdate'] = "Begravelsesdato";
    $text['changedate'] = "Sidst �ndret dato";
    $text['gedcom'] = "Tr�";
    $text['baptdate'] = "D�bsdato (SDH)";
    $text['baptplace'] = "D�bssted (SDH)";
    $text['endldate'] = "Begavelsesdato (SDH)";
    $text['endlplace'] = "Begavelsessted (SDH)";
    $text['ssealdate'] = "Beseglingsdato � (SDH)";   //Sealed to spouse
    $text['ssealplace'] = "Beseglingssted � (SDH)";
    $text['psealdate'] = "Beseglingsdato F (SDH)";   //Sealed to parents
    $text['psealplace'] = "Beseglingssted F (SDH)";
    $text['marrplace'] = "Vielsessted";
    $text['spousesurname'] = "�gtef�lles efternavn";
    $text['spousemore'] = "Hvis der indtastes en v�rdi for �gtef�lles efternavn, skal der ogs� v�lges k�n.";
    $text['plusminus5'] = "+/- 5 �r fra";
    $text['exists'] = "eksisterer";
    $text['dnexist'] = "eksisterer ikke";
    $text['divdate'] = "Skilsmissedato";
    $text['divplace'] = "Skilsmissested";
    $text['otherevents'] = "Andre begivenheder";
    $text['numresults'] = "Resultater pr. side";
    $text['mysphoto'] = "Uidentificerede billeder";
    $text['mysperson'] = "Personer, der er vanskelige at finde frem til";
    $text['joinor'] = "Muligheden 'Sammenf�j med Eller' kan ikke bruges med en �gtef�lles efternavn.";
    $text['tellus'] = "Fort�l, hvad du ved";
    $text['moreinfo'] = "Klik for at se mere om dette billede";
    //added in 8.0.0
    $text['marrdatetr'] = "�gteskabet indg�et";
    $text['divdatetr'] = "Skilsmisse�r";
    $text['mothername'] = "Mors navn";
    $text['fathername'] = "Fars navn";
    $text['filter'] = "Filtrer";
    $text['notliving'] = "Ikke levende";
    $text['nodayevents'] = "Begivenheder i denne m�ned, der ikke er tilknyttet en specifik dato:";
    //added in 9.0.0
    $text['csv'] = "Kommasepareret CSV fil";
    //added in 10.0.0
    $text['confdate'] = "Bekr�ftelsesdato (SDH)";
    $text['confplace'] = "Bekr�ftelsessted (SDH)";
    $text['initdate'] = "Forberedende dato (SDH)";
    $text['initplace'] = "Forberedende sted (SDH)";
    //added in 11.0.0
    $text['marrtype'] = "�gteskabstype";
    $text['searchfor'] = "S�g efter";
    $text['searchnote'] = "Bem�rk: Denne side bruger Google til at udf�re sin s�gning. Antallet af matches vil blive direkte ber�rt af, i hvilket omfang Google har v�ret i stand til at indeksere sitet.";
    break;

  //showlog.php
  case "showlog":
    $text['logfilefor'] = "Logfil for";
    $text['mostrecentactions'] = "Seneste aktiviteter";
    $text['autorefresh'] = "Automatisk opdatering (30 sekunder)";
    $text['refreshoff'] = "Sl� automatisk opdatering fra";
    break;

  case "headstones":
  case "showphoto":
    $text['cemeteriesheadstones'] = "Kirkeg�rde og gravsten";
    $text['showallhsr'] = "Vis alle gravstens poster";
    $text['in'] = "i";
    $text['showmap'] = "Vis kort";
    $text['headstonefor'] = "Gravsten for";
    $text['photoof'] = "Billeder af";
    $text['photoowner'] = "Ejer/Kilde";
    $text['nocemetery'] = "Ingen kirkeg�rd";
    $text['iptc005'] = "Titel";
    $text['iptc020'] = "Supplerende kategorier";
    $text['iptc040'] = "S�rlige vejledninger";
    $text['iptc055'] = "Dannet dato";
    $text['iptc080'] = "Forfatter";
    $text['iptc085'] = "Forfatters stilling";
    $text['iptc090'] = "By";
    $text['iptc095'] = "Stat";
    $text['iptc101'] = "Land";
    $text['iptc103'] = "OTR";
    $text['iptc105'] = "Overskrift";
    $text['iptc110'] = "Kilde";
    $text['iptc115'] = "Billedkilde";
    $text['iptc116'] = "Copyright bem�rkning";
    $text['iptc120'] = "Billedtekst";
    $text['iptc122'] = "Billedtekst forfatter";
    $text['mapof'] = "Kort over";
    $text['regphotos'] = "Beskrivelse";
    $text['gallery'] = "Kun thumbnails";
    $text['cemphotos'] = "Kirkeg�rdsbilleder";
    $text['photosize'] = "St�rrelse";
    $text['iptc010'] = "Prioritet";
    $text['filesize'] = "Filst�rrelse";
    $text['seeloc'] = "Se sted";
    $text['showall'] = "Vis alle";
    $text['editmedia'] = "Redig�r medie";
    $text['viewitem'] = "Vis dette element";
    $text['editcem'] = "Redig�r kirkeg�rd";
    $text['numitems'] = "# elementer";
    $text['allalbums'] = "Alle albummer";
    $text['slidestop'] = "Pause lysbilledshow";
    $text['slideresume'] = "Genoptag lysbilledshow";
    $text['slidesecs'] = "Sekunder for hvert billede:";
    $text['minussecs'] = "minus 0.5 sekunder";
    $text['plussecs'] = "plus 0.5 sekunder";
    $text['nocountry'] = "Ukendt land";
    $text['nostate'] = "Ukendt stat";
    $text['nocounty'] = "Ukendt amt";
    $text['nocity'] = "Ukendt by";
    $text['nocemname'] = "Ukendt kirkeg�rd";
    $text['editalbum'] = "Redig�r album";
    $text['mediamaptext'] = "<strong>Note:</strong> K�r musen henover billedet for at vise navnene. Klik p� et navn for at se siden.";
    //added in 8.0.0
    $text['allburials'] = "Alle begravelser";
    $text['moreinfo'] = "Klik for at se mere om dette billede";
    //added in 9.0.0
    $text['iptc025'] = "N�gleord";
    $text['iptc092'] = "Underlokation";
    $text['iptc015'] = "Kategori";
    $text['iptc065'] = "Oprindeligt program";
    $text['iptc070'] = "Programversion";
    break;

  //surnames.php, surnames100.php, surnames-all.php, surnames-oneletter.php
  case "surnames":
  case "places":
    $text['surnamesstarting'] = "Vis efternavne, der begynder med";
    $text['showtop'] = "Vis mest brugte";
    $text['showallsurnames'] = "Vis alle efternavne";
    $text['sortedalpha'] = "sorteret alfabetisk";
    $text['byoccurrence'] = "sorteret efter hyppighed";
    $text['firstchars'] = "F�rste bogstav";
    $text['mainsurnamepage'] = "Efternavne";
    $text['allsurnames'] = "Alle efternavne";
    $text['showmatchingsurnames'] = "Klik p� et efternavn for at se data.";
    $text['backtotop'] = "Tilbage til toppen";
    $text['beginswith'] = "Begynder med";
    $text['allbeginningwith'] = "Alle efternavne, der begynder med";
    $text['numoccurrences'] = "hyppigheden i parentes";
    $text['placesstarting'] = "Vis steder, der begynder med";
    $text['showmatchingplaces'] = "Klik p� et efternavn for at vise matchende poster.";
    $text['totalnames'] = "totalt antal navne";
    $text['showallplaces'] = "Vis alle steder";
    $text['totalplaces'] = "totalt antal steder";
    $text['mainplacepage'] = "Steders prim�rside";
    $text['allplaces'] = "Alle steder";
    $text['placescont'] = "Vis alle steder, der indeholder";
    //changed in 8.0.0
    $text['top30'] = "Efternavnes top xxx";
    $text['top30places'] = "Steders top xxx";
    //added in 12.0.0
    $text['firstnamelist'] = "Fornavneliste";
    $text['firstnamesstarting'] = "Vis fornavne begyndende med";
    $text['showallfirstnames'] = "Vis alle fornavne";
    $text['mainfirstnamepage'] = "Forsiden med fornavne";
    $text['allfirstnames'] = "Alle fornavne";
    $text['showmatchingfirstnames'] = "Klik p� et fornavn for at vise matchende poster.";
    $text['allfirstbegwith'] = "Alle fornavne begyndende med";
    $text['top30first'] = "Top xxx fornavne";
    $text['allothers'] = "Alle andre";
    $text['amongall'] = "(blandt alle navne)";
    $text['justtop'] = "Kun top xxx";
    break;

  //whatsnew.php
  case "whatsnew":
    $text['pastxdays'] = "(sidste xx dage)";

    $text['photo'] = "Billede";
    $text['history'] = "Fort�lling/Dokument";
    $text['husbid'] = "Mands ID";
    $text['husbname'] = "Mands navn";
    $text['wifeid'] = "Kvindes ID";
    //added in 11.0.0
    $text['wifename'] = "Kvindes navn";
    break;

  //timeline.php, timeline2.php
  case "timeline":
    $text['text_delete'] = "Slet";
    $text['addperson'] = "Tilf�j person";
    $text['nobirth'] = "Den f�lgende person har ikke en gyldig f�dselsdato og kunne ikke tilf�jes";
    $text['event'] = "Begivenhed(er)";
    $text['chartwidth'] = "Tavlebredde";
    $text['timelineinstr'] = "Tilf�j personer";
    $text['togglelines'] = "Vis/skjul linjer";
    //changed in 9.0.0
    $text['noliving'] = "Den f�lgende person er m�rket som nulevende eller privat og kunne ikke tilf�jes, fordi du ikke er logget ind med korrekte rettigheder";
    break;

  //browsetrees.php
  //login.php, newacctform.php, addnewacct.php
  case "trees":
  case "login":
    $text['browsealltrees'] = "S�g i alle tr�er";
    $text['treename'] = "Tr�navn";
    $text['owner'] = "Ejer";
    $text['address'] = "Adresse";
    $text['city'] = "By";
    $text['state'] = "Stat";
    $text['zip'] = "Postnummer";
    $text['country'] = "Land";
    $text['email'] = "mailadresse";
    $text['phone'] = "Telefon";
    $text['username'] = "Brugernavn";
    $text['password'] = "Kodeord";
    $text['loginfailed'] = "Login mislykkedes";

    $text['regnewacct'] = "Registr�r ny brugerkonto";
    $text['realname'] = "Dit fulde navn";
    $text['phone'] = "Telefon";
    $text['email'] = "mailadresse";
    $text['address'] = "Adresse";
    $text['acctcomments'] = "Bem�rkninger og kommentarer";
    $text['submit'] = "Send";
    $text['leaveblank'] = "(tomt, hvis du vil have nyt tr�)";
    $text['required'] = "N�dvendige felter";
    $text['enterpassword'] = " Indtast venligst en adgangskode.";
    $text['enterusername'] = "Indtast venligst et brugernavn.";
    $text['failure'] = "Det angivne brugernavn er desv�rre allerede i brug. Brug Tilbage-tasten i din browser for at komme tilbage til forrige side og v�lg et andet brugernavn.";
    $text['success'] = "Mange tak for din anmodning om adgang til hjemmesiden. Der sendes en mail, n�r din adgang til hjemmesiden er aktiveret.";
    $text['emailsubject'] = "Ny brugerans�gning";
    $text['website'] = "Hjemmeside";
    $text['nologin'] = "Er du ikke oprettet som bruger?";
    $text['loginsent'] = "Login-oplysninger er sendt";
    $text['loginnotsent'] = "Login-oplysninger er ikke sendt";
    $text['enterrealname'] = "Indtast venligst dit fulde navn.";
    $text['rempass'] = "Forbliv logget ind p� denne computer";
    $text['morestats'] = "Mere statistik";
    $text['accmail'] = "<strong>OBS:</strong> For at kunne modtage mails fra hjemmesiden vedr. registreringen, skal du sikre, at mails fra dette dom�ne ikke er blokeret.";
    $text['newpassword'] = "Ny adgangskode";
    $text['resetpass'] = "Gendan adgangskode";
    $text['nousers'] = "Dette skema kan ikke bruges, f�r der eksisterer mindst een brugerregistrering. Hvis du er ejer af denne side, skal du g� til Admin/Users og oprette en Administratorkonto.";
    $text['noregs'] = "Der kan desv�rre ikke accepteres flere nye brugerregistreringer for �jeblikket. V�r venlig at <a href=\"suggest.php\">kontakte mig</a>, hvis du har kommentarer til eller sp�rgsm�l ang. hjemmesiden.";
    //changed in 8.0.0
    $text['emailmsg'] = "Du har modtaget en anmodning om adgang til din hjemmeside.";
    $text['accactive'] = "Adgangen er blevet aktiveret, men brugeren har ingen ekstra rettigheder, f�r du tildeler dem.";
    $text['accinactive'] = "G� til Admin/Brugere/Gennemse for at godkende brugerens adgang til hjemmesiden. Brugerens konto vil forblive inaktiv, indtil den er redigeret og godkendt.";
    $text['pwdagain'] = "Gentag adgangskode";
    $text['enterpassword2'] = "Indtast din adgangskode igen.";
    $text['pwdsmatch'] = "Dine adgangskoder er ikke ens. Indtast den samme adgangskode i begge felter.";
    //added in 8.0.0
    $text['acksubject'] = "Tak for din henvendelse"; //for a new user account
    $text['ackmessage'] = "Anmodningen er modtaget. Kontoen vil v�re inaktiv, indtil administratoren aktiverer den. Du vil modtage en mail, n�r du kan logge p�.";
    //added in 12.0.0
    $text['switch'] = "Skift";
    break;

  //added in 10.0.0
  case "branches":
    $text['browseallbranches'] = "Gennemse alle grene";
    break;

  //statistics.php
  case "stats":
    $text['quantity'] = "Antal";
    $text['totindividuals'] = "Antal personer";
    $text['totmales'] = "Heraf antal hank�n";
    $text['totfemales'] = "Heraf antal hunk�n";
    $text['totunknown'] = "Ukendt k�n";
    $text['totliving'] = "Antal nulevende";
    $text['totfamilies'] = "Antal familier";
    $text['totuniquesn'] = "Antal unikke efternavne";
    //$text['totphotos'] = "Total Photos";
    //$text['totdocs'] = "Total Histories &amp; Documents";
    //$text['totheadstones'] = "Total Headstones";
    $text['totsources'] = "Antal kilder";
    $text['avglifespan'] = "Gennemsnitlig livsl�ngde";
    $text['earliestbirth'] = "Tidligste f�dsel";
    $text['longestlived'] = "L�ngstlevende person";
    $text['days'] = "dage";
    $text['age'] = "Alder";
    $text['agedisclaimer'] = "Aldersrelaterede beregninger er baseret p� personer med angivne f�dsels- <EM>og</EM> d�dsdatoer.  Fordi der findes ukomplette datofelter(f.eks. en d�dsdato, der kun er skrevet som \"1945\" eller \"F�R 1860\"), kan disse beregninger ikke v�re 100% pr�cise.";
    $text['treedetail'] = "Flere oplysninger om dette tr�";
    $text['total'] = "Antal";
    //added in 12.0
    $text['totdeceased'] = "Antal afd�de";
    break;

  case "notes":
    $text['browseallnotes'] = "S�g i alle notater";
    break;

  case "help":
    $text['menuhelp'] = "Menun�gle";
    break;

  case "install":
    $text['perms'] = "Alle tilladelser er oprettet.";
    $text['noperms'] = "Der kunne ikke oprettes tilladelser for disse filer:";
    $text['manual'] = "V�r venlig at oprette dem manuelt.";
    $text['folder'] = "Mappe";
    $text['created'] = "er oprettet";
    $text['nocreate'] = "Kunne ikke oprettes. V�r venlig at g�re det manuelt.";
    $text['infosaved'] = "Oplysningerne er gemt, forbindelsen er bekr�ftet!";
    $text['tablescr'] = "Tabellerne er oprettet!";
    $text['notables'] = "F�lgende tabeller kunne ikke oprettes:";
    $text['nocomm'] = "TNG kommunikerer ikke med din database. Der er ikke oprettet tabeller.";
    $text['newdb'] = "Oplysningerne er gemt, forbindelsen er bekr�ftet, ny database er oprettet:";
    $text['noattach'] = "Oplysningerne er gemt. Forbindelsen er skabt, og databasen er oprettet, men TNG kan ikke tilknyttes hertil.";
    $text['nodb'] = "Oplysningerne er gemt. Forbindelsen er skabt, men databasen eksisterer ikke og kunne ikke oprettes her. V�r venlig at bekr�fte, at navnet p� databasen er korrekt, eller brug kontrolpanelet til at oprette den.";
    $text['noconn'] = "Oplysningerne er gemt, men forbindelsen mislykkedes. En eller flere af f�lgende er ikke i orden:";
    $text['exists'] = "eksisterer";
    $text['loginfirst'] = "Du skal f�rst logge p�.";
    $text['noop'] = "Der blev ikke udf�rt noget.";
    //added in 8.0.0
    $text['nouser'] = "Bruger blev ikke oprettet. Brugernavnet eksisterer allerede.";
    $text['notree'] = "Tr�et blev ikke oprettet. Tr�-ID findes muligvis allerede.";
    $text['infosaved2'] = "Oplysningerne er gemt";
    $text['renamedto'] = "omd�bt til";
    $text['norename'] = "kunne ikke omd�bes";
    break;

  case "imgviewer":
    $text['zoomin'] = "Zoom ind";
    $text['zoomout'] = "Zoom ud";
    $text['magmode'] = "Forst�rrelse";
    $text['panmode'] = "Panorering";
    $text['pan'] = "Klik og tr�k for at flytte indenfor billedet";
    $text['fitwidth'] = "Tilpas bredde";
    $text['fitheight'] = "Tilpas h�jde";
    $text['newwin'] = "Nyt vindue";
    $text['opennw'] = "�ben billede i nyt vindue";
    $text['magnifyreg'] = "Klik for at forst�rre en del af billedet";
    $text['imgctrls'] = "Aktiver billedv�rkt�jer";
    $text['vwrctrls'] = "Aktiver billedvisningsv�rkt�jer";
    $text['vwrclose'] = "Luk billedfremviseren";
    break;

  case "dna":
    $text['test_date'] = "Testdato";
    $text['links'] = "Relevante links";
    $text['testid'] = "Test-ID";
    //added in 12.0.0
    $text['mode_values'] = "Mode Values";
    $text['compareselected'] = "Sammenlign valgte";
    $text['dnatestscompare'] = "Sammenlign Y-DNA tests";
    $text['keep_name_private'] = "Hold navn privat";
    $text['browsealltests'] = "Gennemse alle tests";
    $text['all_dna_tests'] = "Alle DNA-tests";
    $text['fastmutating'] = "Hurtigmuterende";
    $text['alltypes'] = "Alle typer";
    $text['allgroups'] = "Alle grupper";
    $text['Ydna_LITbox_info'] = "Test(s) knyttet til denne person blev ikke n�dvendigvis taget af denne person.<br />Kolonnen 'Haplogroup' viser data i r�dt, hvis resultatet er 'Forudset' eller gr�nt, hvis testen er 'Bekr�ftet'";
    //added in 12.1.0
    $text['dnatestscompare_mtdna'] = "Sammenlign valgte mtDNA-tests";
    $text['dnatestscompare_atdna'] = "Sammenlign valgte atDNA-tests";
    $text['chromosome'] = "Krom";
    $text['centiMorgans'] = "cM";
    $text['snps'] = "SNPs";
    $text['y_haplogroup'] = "Y-DNA";
    $text['mt_haplogroup'] = "mtDNA";
    $text['sequence'] = "Ref";
    $text['extra_mutations'] = "Ekstra mutationer";
    $text['mrca'] = "Most Recent Common Ancestor";
    $text['ydna_test'] = "Y-DNA-tests";
    $text['mtdna_test'] = "mtDNA (Mitochondrial) Tests";
    $text['atdna_test'] = "atDNA (autosomal) Tests";
    $text['segment_start'] = "Start";
    $text['segment_end'] = "Slut";
    $text['suggested_relationship'] = "Foresl�et";
    $text['actual_relationship'] = "Aktuelt";
    $text['12markers'] = "Mark�rer 1-12";
    $text['25markers'] = "Mark�rer 13-25";
    $text['37markers'] = "Mark�rer 26-37";
    $text['67markers'] = "Mark�rer 38-67";
    $text['111markers'] = "Mark�rer 68-111";
    break;
}

//common
$text['matches'] = "Match";
$text['description'] = "Beskrivelse";
$text['notes'] = "Notater";
$text['status'] = "Status";
$text['newsearch'] = "Ny s�gning";
$text['pedigree'] = "Anetavle";
$text['seephoto'] = "Se billede";
$text['andlocation'] = "& sted";
$text['accessedby'] = "udf�rt af";
$text['family'] = "Familie"; //from getperson
$text['children'] = "B�rn";  //from getperson
$text['tree'] = "Tr�";
$text['alltrees'] = "Alle tr�er";
$text['nosurname'] = "[intet efternavn]";
$text['thumb'] = "Ikon";  //as in Thumbnail
$text['people'] = "Personer";
$text['title'] = "Titel";  //from getperson
$text['suffix'] = "Suffiks";  //from getperson
$text['nickname'] = "K�lenavn";  //from getperson
$text['lastmodified'] = "Sidst �ndret";  //from getperson
$text['married'] = "Gift";  //from getperson
//$text['photos'] = "Photos";
$text['name'] = "Navn"; //from showmap
$text['lastfirst'] = "Efternavn, Fornavn";  //from search
$text['bornchr'] = "F�dt/D�bt";  //from search
$text['individuals'] = "Personer";  //from whats new
$text['families'] = "Familier";
$text['personid'] = "Person-ID";
$text['sources'] = "Kilder";  //from getperson (next several)
$text['unknown'] = "Ukendt";
$text['father'] = "Far";
$text['mother'] = "Mor";
$text['christened'] = "D�bt";
$text['died'] = "D�d";
$text['buried'] = "Begravet";
$text['spouse'] = "�gtef�lle/Partner";  //from search
$text['parents'] = "For�ldre";  //from pedigree
$text['text'] = "Tekst";  //from sources
$text['language'] = "Sprog";  //from languages
$text['descendchart'] = "Eftersl�gt";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Egne data";
$text['edit'] = "Redig�r";
$text['date'] = "Dato";
$text['place'] = "Sted";
$text['login'] = "Login";
$text['logout'] = "Log ud";
$text['groupsheet'] = "Gruppeskema";
$text['text_and'] = "og";
$text['generation'] = "Generation";
$text['filename'] = "Filnavn";
$text['id'] = "ID";
$text['search'] = "S�g";
$text['user'] = "Bruger";
$text['firstname'] = "Fornavn";
$text['lastname'] = "Efternavn";
$text['searchresults'] = "S�geresultat";
$text['diedburied'] = "D�d/Begravet";
$text['homepage'] = "Forside";
$text['find'] = "Find...";
$text['relationship'] = "Sl�gtskab";    //in German, Verwandtschaft
$text['relationship2'] = "Tilknytning"; //different in some languages, at least in German (Beziehung)
$text['timeline'] = "Tidslinje";
$text['yesabbr'] = "Ja";               //abbreviation for 'yes'
$text['divorced'] = "Skilt";
$text['indlinked'] = "Knyttet til";
$text['branch'] = "Gren";
$text['moreind'] = "Flere personer";
$text['morefam'] = "Flere familier";
$text['source'] = "Kilde";
$text['surnamelist'] = "Efternavneliste";
$text['generations'] = "Generationer";
$text['refresh'] = "Opdater";
$text['whatsnew'] = "Nyheder";
$text['reports'] = "Rapporter";
$text['placelist'] = "Stedfortegnelse";
$text['baptizedlds'] = "D�bt (SDH)";
$text['endowedlds'] = "Begavet (SDH)";
$text['sealedplds'] = "Beseglet F (SDH)";
$text['sealedslds'] = "Beseglet � (SDH)";
$text['ancestors'] = "Aner";
$text['descendants'] = "Efterkommere";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Dato for seneste opdatering";
$text['type'] = "Type";
$text['savechanges'] = "Gem �ndringer";
$text['familyid'] = "Familie-ID";
$text['headstone'] = "Gravsten";
$text['historiesdocs'] = "Fort�llinger & Dokumenter";
$text['anonymous'] = "Anonym";
$text['places'] = "Steder";
$text['anniversaries'] = "Datoer & �rsdage";
$text['administration'] = "Administration";
$text['help'] = "Hj�lp";
//$text['documents'] = "Documents";
$text['year'] = "�r";
$text['all'] = "Alle";
$text['repository'] = "Arkiv";
$text['address'] = "Adresse";
$text['suggest'] = "Foresl�";
$text['editevent'] = "Foresl� en �ndring til denne begivenhed";
$text['findplaces'] = "Find alle personer med begivenheder p� dette sted";
$text['morelinks'] = "Flere links";
$text['faminfo'] = "Familieoplysninger";
$text['persinfo'] = "Personlige oplysninger";
$text['srcinfo'] = "Kildeoplysninger";
$text['fact'] = "Fakta";
$text['goto'] = "V�lg en side";
$text['tngprint'] = "Udskriv";
$text['databasestatistics'] = "Databasestatistik"; //needed to be shorter to fit on menu
$text['child'] = "Barn";  //from familygroup
$text['repoinfo'] = "Oplysninger om arkiv";
$text['tng_reset'] = "Gendan";
$text['noresults'] = "Ingen fundet";
$text['allmedia'] = "Alle medier";
$text['repositories'] = "Arkiver";
$text['albums'] = "Albummer";
$text['cemeteries'] = "Kirkeg�rde";
$text['surnames'] = "Efternavne";
$text['dates'] = "Datoer";
$text['link'] = "Link";
$text['media'] = "Medie";
$text['gender'] = "K�n";
$text['latitude'] = "Breddegrad";
$text['longitude'] = "L�ngdegrad";
$text['bookmarks'] = "Bogm�rker";
$text['bookmark'] = "Tilf�j bogm�rke";
$text['mngbookmarks'] = "G� til bogm�rke";
$text['bookmarked'] = "Bogm�rke tilf�jet";
$text['remove'] = "Fjern";
$text['find_menu'] = "Find";
$text['info'] = "Info"; //this needs to be a very short abbreviation
$text['cemetery'] = "Kirkeg�rd";
$text['gmapevent'] = "Begivenhedskort";
$text['gevents'] = "Begivenhed";
$text['glang'] = "&amp;hl=da";
$text['googleearthlink'] = "Link til Google Earth";
$text['googlemaplink'] = "Link til Google Maps";
$text['gmaplegend'] = "Kort forklaring";
$text['unmarked'] = "Um�rket";
$text['located'] = "fundet";
$text['albclicksee'] = "Klik for at se alle poster i dette album";
$text['notyetlocated'] = "Endnu ikke fundet";
$text['cremated'] = "Kremeret";
$text['missing'] = "Savnes";
$text['pdfgen'] = "PDF Generator";
$text['blank'] = "Tomt kort";
$text['none'] = "Ingen";
$text['fonts'] = "Fonte";
$text['header'] = "Sidehoved";
$text['data'] = "Data";
$text['pgsetup'] = "Sideops�tning";
$text['pgsize'] = "Sidest�rrelse";
$text['orient'] = "Orientering"; //for a page
$text['portrait'] = "Portr�t";
$text['landscape'] = "Landskab";
$text['tmargin'] = "Margen �verst";
$text['bmargin'] = "Margen nederst";
$text['lmargin'] = "Margen til venstre";
$text['rmargin'] = "Margen til h�jre";
$text['createch'] = "Opret kort";
$text['prefix'] = "Pr�fiks";
$text['mostwanted'] = "Mest Efters�gte";
$text['latupdates'] = "Seneste opdateringer";
$text['featphoto'] = "Udvalgt billede";
$text['news'] = "Nyheder";
$text['ourhist'] = "Fort�llingen om vores familie";
$text['ourhistanc'] = "Fort�llingen om vores familie og aner";
$text['ourpages'] = "Vores sl�gtsforskningsider";
$text['pwrdby'] = "Hjemmesiden drives af";
$text['writby'] = "forfattet af";
$text['searchtngnet'] = "S�g i TNG Network (GENDEX)";
$text['viewphotos'] = "Se alle billeder";
$text['anon'] = "Du er ikke logget ind";
$text['whichbranch'] = "Hvilken gren tilh�rer du?";
$text['featarts'] = "Temaartikler";
$text['maintby'] = "Opdateres af";
$text['createdon'] = "Oprettet den";
$text['reliability'] = "Trov�rdighed";
$text['labels'] = "Etiketter";
$text['inclsrcs'] = "Medtag kilder";
$text['cont'] = "(fort.)"; //abbreviation for continued
$text['mnuheader'] = "Forside";
$text['mnusearchfornames'] = "S�g";
$text['mnulastname'] = "Efternavn";
$text['mnufirstname'] = "Fornavn";
$text['mnusearch'] = "S�g";
$text['mnureset'] = "Begynd forfra";
$text['mnulogon'] = "Login";
$text['mnulogout'] = "Log ud";
$text['mnufeatures'] = "Andre muligheder";
$text['mnuregister'] = "Registr�r for at f� en brugerkonto";
$text['mnuadvancedsearch'] = "Avanceret s�gning";
$text['mnulastnames'] = "Efternavne";
$text['mnustatistics'] = "Statistikker";
$text['mnuphotos'] = "Billeder";
$text['mnuhistories'] = "Fort�llinger";
$text['mnumyancestors'] = "Billeder af &amp; fort�llinger om aner til [Person]";
$text['mnucemeteries'] = "Kirkeg�rde";
$text['mnutombstones'] = "Gravsten";
$text['mnureports'] = "Rapporter";
$text['mnusources'] = "Kilder";
$text['mnuwhatsnew'] = "Nyheder";
$text['mnushowlog'] = "Adgangslog";
$text['mnulanguage'] = "Skift sprog";
$text['mnuadmin'] = "Administration";
$text['welcome'] = "Velkommen";
$text['contactus'] = "Kontakt";
//changed in 8.0.0
$text['born'] = "F�dt";
$text['searchnames'] = "S�g personer";
//added in 8.0.0
$text['editperson'] = "Redig�r person";
$text['loadmap'] = "Hent kortet";
$text['birth'] = "F�dsel";
$text['wasborn'] = "blev f�dt";
$text['startnum'] = "F�rste nummer";
$text['searching'] = "S�ger";
//moved here in 8.0.0
$text['location'] = "Beliggenhed";
$text['association'] = "Tilknytning";
$text['collapse'] = "Fold sammen";
$text['expand'] = "Udvid";
$text['plot'] = "Plot";
$text['searchfams'] = "S�g familier";
//added in 8.0.2
$text['wasmarried'] = "blev gift med";
$text['anddied'] = "d�de";
//added in 9.0.0
$text['share'] = "Del";
$text['hide'] = "Skjul";
$text['disabled'] = "Din bruger konto er blevet deaktiveret. Kontakt venligst administrator for yderligere oplysninger.";
$text['contactus_long'] = "Hvis du har sp�rgsm�l eller kommentarer til oplysningerne p� denne hjemmeside, s� kontakt os venligst <span class=\"emphasis\"><a href=\"suggest.php\"></a></span>. Vi gl�der os til at h�re fra dig.";
$text['features'] = "Artikler";
$text['resources'] = "Ressourcer";
$text['latestnews'] = "Seneste nyt";
$text['trees'] = "Tr�er";
$text['wasburied'] = "blev begravet";
//moved here in 9.0.0
$text['emailagain'] = "Gentag mail-adresse";
$text['enteremail2'] = "Indtast din mail-adresse igen.";
$text['emailsmatch'] = "Mailadresserne er ikke ens. Indtast den samme mailadresse i begge felter.";
$text['getdirections'] = "Klik for at f� k�rselsanvisninger";
$text['calendar'] = "Kalender";
//changed in 9.0.0
$text['directionsto'] = " til ";
$text['slidestart'] = "Lysbilledshow";
$text['livingnote'] = "Mindst �n nulevende eller privat person er knyttet til denne note - Detaljer er udeladt.";
$text['livingphoto'] = "Mindst �n nulevende person er knyttet til dette - Detaljer er udeladt.";
$text['waschristened'] = "blev d�bt";
//added in 10.0.0
$text['branches'] = "Grene";
$text['detail'] = "Detaljer";
$text['moredetail'] = "Flere detaljer";
$text['lessdetail'] = "F�rre detaljer";
$text['otherevents'] = "Andre begivenheder";
$text['conflds'] = "Bekr�ftet (SDH)";
$text['initlds'] = "Forberedende (SDH)";
$text['wascremated'] = "blev kremeret";
//moved here in 11.0.0
$text['text_for'] = "for";
//added in 11.0.0
$text['searchsite'] = "S�g p� denne hjemmeside";
$text['searchsitemenu'] = "S�g hjemmeside";
$text['kmlfile'] = "Hent en .kml-fil for at se placeringen i Google Earth";
$text['download'] = "Klik for at hente";
$text['more'] = "Mere";
$text['heatmap'] = "Navnekort";
$text['refreshmap'] = "Opdat�r kortet";
$text['remnums'] = "Fjern Numre og kortn�le";
$text['photoshistories'] = "Billeder &amp; Fort�llinger";
$text['familychart'] = "Familietavle";
//added in 12.0.0
$text['firstnames'] = "Fornavne";
//moved here in 12.0.0
$text['dna_test'] = "DNA-test";
$text['test_type'] = "Testtype";
$text['test_info'] = "Testoplysning";
$text['takenby'] = "Taget af";
$text['haplogroup'] = "Haplogroup";
$text['hvr1'] = "HVR1";
$text['hvr2'] = "HVR2";
$text['relevant_links'] = "Relevante links";
$text['nofirstname'] = "[intet fornavn]";
//added in 12.0.1
$text['cookieuse'] = "Bem�rk: Denne hjemmeside bruger cookies.";
$text['dataprotect'] = "EU-persondataforordningen";
$text['viewpolicy'] = "Vis databeskyttelsespolitik";
$text['understand'] = "OK";
$text['consent'] = "Jeg giver mit samtykke til, at denne hjemmeside kan gemme de personlige oplysninger, der er indsamlet her. Jeg forst�r, at jeg kan bede hjemmesidens ejer om at fjerne disse oplysninger til enhver tid.";
$text['consentreq'] = "Jeg giver mit samtykke til, at denne hjemmeside gemmer mine personlige oplysninger.";

//added in 12.1.0
$text['testsarelinked'] = "DNA-tests er knyttet til";
$text['testislinked'] = "DNA-test er knyttet til";

//added in 12.2
$text['quicklinks'] = "Hurtige links";
$text['yourname'] = "Dit navn";
$text['youremail'] = "Din e-mail-adresse";
$text['liketoadd'] = "Alle oplysninger, du gerne vil tilf�je";
$text['webmastermsg'] = "Webmaster-meddelelse";
$text['gallery'] = "Se Galleri";
$text['wasborn_male'] = "blev f�dt";
$text['wasborn_female'] = "blev f�dt";
$text['waschristened_male'] = "blev d�bt";
$text['waschristened_female'] = "blev d�bt";
$text['died_male'] = "d�de";
$text['died_female'] = "d�de";
$text['wasburied_male'] = "blev begravet";
$text['wasburied_female'] = "blev begravet";
$text['wascremated_male'] = "blev kremeret";
$text['wascremated_female'] = "blev kremeret";
$text['wasmarried_male'] = "blev gift med ";
$text['wasmarried_female'] = "blev gift med ";
$text['wasdivorced_male'] = "blev skilt";
$text['wasdivorced_female'] = "blev skilt";
$text['inplace'] = " i ";
$text['onthisdate'] = "";
$text['inthisyear'] = "";
$text['and'] = "og ";

//moved here in 12.3
$text['dna_info_head'] = "DNA-testoplysning";
$text['firstpage'] = "F�rste side";
$text['lastpage'] = "Sidste side";

@include_once "captcha_text.php";
@include_once "alltext.php";
if (!$alltextloaded) {
  getAllTextPath();
}

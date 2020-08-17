<?php
switch ($textpart) {
  //browsesources.php, showsource.php
  case "sources":
    $text['browseallsources'] = "Prohl�dnout v�echny prameny";
    $text['shorttitle'] = "Kr�tk� n�zev";
    $text['callnum'] = "Archivn� ��slo";
    $text['author'] = "Autor";
    $text['publisher'] = "Vydavatel";
    $text['other'] = "Dal�� informace";
    $text['sourceid'] = "ID ��slo pramenu";
    $text['moresrc'] = "Dal�� prameny";
    $text['repoid'] = "ID ��slo �lo�i�t�";
    $text['browseallrepos'] = "Prohl�dnout v�echny �lo�i�t�";
    break;

  //changelanguage.php, savelanguage.php
  case "language":
    $text['newlanguage'] = "Nov� jazyk";
    $text['changelanguage'] = "Zm�na jazyka";
    $text['languagesaved'] = "Jazyk ulo�en";
    $text['sitemaint'] = "Pr�v� prob�h� �dr�ba webov�ch str�nek";
    $text['standby'] = "Webov� str�nky jsou do�asn� nedostupn�, proto�e prob�h� aktualizace datab�ze. Zkuste to, pros�m, znovu za p�r minut. Pokud budou str�nky nedostupn� del�� dobu, kontaktujte majitele t�chto str�nek.";
    break;

  //gedcom.php, gedform.php
  case "gedcom":
    $text['gedstart'] = "GEDCOM za��naj�c� od";
    $text['producegedfrom'] = "Vytvo�it GEDCOM soubor pro";
    $text['numgens'] = "Po�et generac�";
    $text['includelds'] = "V�etn� �daj� CJKSpd";
    $text['buildged'] = "Vytvo� GEDCOM";
    $text['gedstartfrom'] = "GEDCOM za��naj�c� od";
    $text['nomaxgen'] = "Mus�te zadat maxim�ln� po�et generac�. Pou�ijte tla��tko Zp�t k n�vratu na p�edchoz� str�nku a chybu opravte.";
    $text['gedcreatedfrom'] = "GEDCOM vytvo�en od";
    $text['gedcreatedfor'] = "vytvo�en pro";
    $text['creategedfor'] = "Vytvo�it GEDCOM";
    $text['email'] = "Email";
    $text['suggestchange'] = "Navrhnout zm�nu";
    $text['yourname'] = "Va�e jm�no";
    $text['comments'] = "Pozn�mky";
    $text['comments2'] = "Koment��";
    $text['submitsugg'] = "Poslat n�vrh";
    $text['proposed'] = "Navrhovan� zm�na";
    $text['mailsent'] = "D�kujeme. Va�e zpr�va byla odesl�na.";
    $text['mailnotsent'] = "Bohu�el, va�e zpr�va nemohla b�t doru�ena. Kontaktujte pros�m xxx p��mo na yyy.";
    $text['mailme'] = "Zaslat kopii na tuto adresu";
    $text['entername'] = "Zadejte, pros�m, va�e jm�no";
    $text['entercomments'] = "Zadejte, pros�m, va�e p�ipom�nky";
    $text['sendmsg'] = "Poslat zpr�vu";
    //added in 9.0.0
    $text['subject'] = "P�edm�t";
    break;

  //getextras.php, getperson.php
  case "getperson":
    $text['photoshistoriesfor'] = "Fotografie a vypr�v�n� pro";
    $text['indinfofor'] = "Osobn� informace o";
    $text['pp'] = "str."; //page abbreviation
    $text['age'] = "V�k";
    $text['agency'] = "Instituce";
    $text['cause'] = "P���ina";
    $text['suggested'] = "Navr�en�";
    $text['closewindow'] = "Zav��t okno";
    $text['thanks'] = "D�kujeme";
    $text['received'] = "V� n�vrh byl zasl�n administr�torovi t�chto str�nek k posouzen�.";
    $text['indreport'] = "Report osoby";
    $text['indreportfor'] = "Report osoby";
    $text['general'] = "Obecn�";
    $text['bkmkvis'] = "Pozn.: Tyto z�lo�ky jsou viditeln� pouze na tomto po��ta�i a v tomto prohl�e�i.";
    //added in 9.0.0
    $text['reviewmsg'] = "M�te doporu�enou zm�nu, kter� vy�aduje va�e posouzen�. Tato zm�na se t�k�:";
    $text['revsubject'] = "Doporu�en� zm�na vy�aduje va�e posouzen�";
    break;

  //relateform.php, relationship.php, findpersonform.php, findperson.php
  case "relate":
    $text['relcalc'] = "Ur�en� p��buzensk�ho vztahu";
    $text['findrel'] = "Ur�en� p��buzensk�ho vztahu";
    $text['person1'] = "Osoba 1:";
    $text['person2'] = "Osoba 2:";
    $text['calculate'] = "Kalkulovat";
    $text['select2inds'] = "Zvolte dv� osoby.";
    $text['findpersonid'] = "Naj�t ID ��slo osoby";
    $text['enternamepart'] = "zadejte ��st jm�na nebo p��jmen�";
    $text['pleasenamepart'] = "Zadejte, pros�m, ��st jm�na nebo p��jmen�.";
    $text['clicktoselect'] = "kliknut�m vyberte osobu";
    $text['nobirthinfo'] = "Chyb� informace o narozen�";
    $text['relateto'] = "P��buzensk� vztah k: ";
    $text['sameperson'] = "Tyto dv� osoby jsou toto�n�";
    $text['notrelated'] = "Tyto dv� osoby nemaj� ��dn� p��buzensk� vztah v posledn�ch xxx generac�ch"; //xxx will be replaced with number of generations
    $text['findrelinstr'] = "Pro zobrazen� p��buzensk�ho vztahu mezi dv�ma osobami nejprve klikn�te na 'Naj�t', abyste na�li p��slu�n� osoby (nebo zanechte osoby, kter� jsou zobrazen�), pot� klikn�te na 'Kalkulovat'.<br>(�esk� v�razy v n�kter�ch slo�it�j��ch p��padech d�ky jin� struktu�e n�zvoslov� p��buzensk�ch vztah� v anglick�m jazyce a z toho pramen�c�ho obt�n�ho p�ekladu nemus� b�t spr�vn�).";
    $text['sometimes'] = "(Pou�it� jin�ho po�tu generac� m��e m�t n�kdy jin� v�sledek.)";
    $text['findanother'] = "Zjistit jin� p��buzensk� vztah";
    $text['brother'] = "bratr od";
    $text['sister'] = "sestra od";
    $text['sibling'] = "sourozenec od";
    $text['uncle'] = " xxx str�c od";
    $text['aunt'] = " xxx teta od";
    $text['uncleaunt'] = " xxx str�c/teta od";
    $text['nephew'] = " xxx synovec od";
    $text['niece'] = " xxx nete� od";
    $text['nephnc'] = "xxx synovec/nete� od";
    $text['removed'] = "generace";
    $text['rhusband'] = "man�el od";
    $text['rwife'] = "man�elka od";
    $text['rspouse'] = "partner od";
    $text['son'] = "syn od";
    $text['daughter'] = "dcera od";
    $text['rchild'] = "d�t� od";
    $text['sil'] = "ze� od";
    $text['dil'] = "snacha od";
    $text['sdil'] = "ze� nebo snacha od";
    $text['gson'] = " xxx vnuk od";
    $text['gdau'] = " xxx vnu�ka od";
    $text['gsondau'] = "xxx vnuk/vnu�ka od";
    $text['great'] = "pra";
    $text['spouses'] = "jsou man�el�";
    $text['is'] = "je";
    $text['changeto'] = "Zm�nit na:";
    $text['notvalid'] = "nen� platn� ID ��slo osoby nebo neexistuje v t�to datab�zi. Zkuste to pros�m znovu.";
    $text['halfbrother'] = "nevlastn� bratr od";
    $text['halfsister'] = "nevlastn� sestra od";
    $text['halfsibling'] = "nevlastn� sourozenec od";
    //changed in 8.0.0
    $text['gencheck'] = "Maxim�ln� po�et kontrolovan�ch generac�";
    $text['mcousin'] = "xxx bratranec yyy od";  //male cousin; xxx = cousin number, yyy = times removed
    $text['fcousin'] = "xxx sest�enice yyy od";  //female cousin
    $text['cousin'] = " xxx bratranec yyy od";
    $text['mhalfcousin'] = "polovi�n� xxx bratranec yyy od";  //male cousin
    $text['fhalfcousin'] = "polovi�n� xxx sest�enice yyy od";  //female cousin
    $text['halfcousin'] = "polovi�n� xxx bratranec/sest�enice yyy od";
    //added in 8.0.0
    $text['oneremoved'] = "o jednu generaci";
    $text['gfath'] = "xxx d�de�ek od";
    $text['gmoth'] = "xxx babi�ka od";
    $text['gpar'] = "xxx prarodi�e od";
    $text['mothof'] = "matka od";
    $text['fathof'] = "otec od ";
    $text['parof'] = "rodi�e od";
    $text['maxrels'] = "Maxim�ln� po�et vztah� k zobrazen�";
    $text['dospouses'] = "Zobrazit vztahy v�etn� man�el�";
    $text['rels'] = "P��buzensk� vztahy";
    $text['dospouses2'] = "Zobrazit partnery";
    $text['fil'] = "tch�n od";
    $text['mil'] = "tchyn� od";
    $text['fmil'] = "tch�n nebo tchyn� od";
    $text['stepson'] = "nevlastn� syn od";
    $text['stepdau'] = "nevlastn� dcera od";
    $text['stepchild'] = "nevlastn� d�t� od";
    $text['stepgson'] = "xxx nevlastn� vnuk od";
    $text['stepgdau'] = "xxx nevlastn� vnu�ka od";
    $text['stepgchild'] = "xxx nevlastn� vnou�e od";
    //added in 8.1.1
    $text['ggreat'] = "pra";
    //added in 8.1.2
    $text['ggfath'] = " xxx prad�de�ek od";
    $text['ggmoth'] = " xxx prababi�ka od";
    $text['ggpar'] = " xxx prarodi� od";
    $text['ggson'] = " xxx pravnuk od";
    $text['ggdau'] = " xxx pravnu�ka od";
    $text['ggsondau'] = " xxx prad�t� od";
    $text['gstepgson'] = "nevlastn� xxx pravnuk od";
    $text['gstepgdau'] = "nevlastn� xxx pravnu�ka od";
    $text['gstepgchild'] = "nevlastn� xxx praprad�t� od";
    $text['guncle'] = " xxx prastr�c od";
    $text['gaunt'] = " xxx prateta od";
    $text['guncleaunt'] = " xxx prastr�c/prateta od";
    $text['gnephew'] = " xxx prasynovec od";
    $text['gniece'] = " xxx pranete� od";
    $text['gnephnc'] = " xxx prasynovec/pranete� od";
    break;

  case "familygroup":
    $text['familygroupfor'] = "Report rodiny";
    $text['ldsords'] = "Ob�ady CJKSpd";
    $text['baptizedlds'] = "K�est (CJKSpd)";
    $text['endowedlds'] = "Obdarov�n (CJKSpd)";
    $text['sealedplds'] = "Pe�et�n R (CJKSpd)";
    $text['sealedslds'] = "Pe�et�n P (CJKSpd)";
    $text['otherspouse'] = "Dal�� partner";
    $text['husband'] = "Man�el";
    $text['wife'] = "Man�elka";
    break;

  //pedigree.php
  case "pedigree":
    $text['capbirthabbr'] = "Nar.";
    $text['capaltbirthabbr'] = "Nar.";
    $text['capdeathabbr'] = "Zem�.";
    $text['capburialabbr'] = "Poh�.";
    $text['capplaceabbr'] = "v";
    $text['capmarrabbr'] = "S�.";
    $text['capspouseabbr'] = "SP";
    $text['redraw'] = "Zobrazit s";
    $text['scrollnote'] = "Pozn.: pro zobrazen� diagramu m��ete pou��t posuvn�k dol� nebo doprava.";
    $text['unknownlit'] = "Nezn�m�";
    $text['popupnote1'] = " = Dal�� informace";
    $text['popupnote2'] = " = Nov� sch�ma p�edk�";
    $text['pedcompact'] = "Kompaktn�";
    $text['pedstandard'] = "Standardn�";
    $text['pedtextonly'] = "Pouze text";
    $text['descendfor'] = "Sch�ma potomk� osoby";
    $text['maxof'] = "Nejv�ce";
    $text['gensatonce'] = "generac� zobrazen�ch najednou.";
    $text['sonof'] = "syn od";
    $text['daughterof'] = "dcera od";
    $text['childof'] = "d�t� od";
    $text['stdformat'] = "Standardn� form�t";
    $text['ahnentafel'] = "Ahnentafel";
    $text['addnewfam'] = "P�idat novou rodinu";
    $text['editfam'] = "Upravit rodinu";
    $text['side'] = "strana";
    $text['familyof'] = "Rodina";
    $text['paternal'] = "Otcova";
    $text['maternal'] = "Mat�ina";
    $text['gen1'] = "Vlastn�";
    $text['gen2'] = "Rodi�e";
    $text['gen3'] = "Prarodi�e";
    $text['gen4'] = "Praprarodi�e";
    $text['gen5'] = "3xprarodi�e";
    $text['gen6'] = "4xprarodi�e";
    $text['gen7'] = "5xprarodi�e";
    $text['gen8'] = "6xprarodi�e";
    $text['gen9'] = "7xprarodi�e";
    $text['gen10'] = "8xprarodi�e";
    $text['gen11'] = "9xprarodi�e";
    $text['gen12'] = "10xprarodi�e";
    $text['graphdesc'] = "Sch�ma potomk� a� do tohoto m�sta";
    $text['pedbox'] = "R�me�ek";
    $text['regformat'] = "Registr";
    $text['extrasexpl'] = "U t�to osoby existuje fotografie, vypr�v�n� nebo jin� medi�ln� polo�ka.";
    $text['popupnote3'] = " = Nov� sch�ma";
    $text['mediaavail'] = "M�dia k dispozici";
    $text['pedigreefor'] = "Sch�ma p�edk� osoby";
    $text['pedigreech'] = "Sch�ma p�edk�";
    $text['datesloc'] = "Datumy a m�sta";
    $text['borchr'] = "Naroz/K�est - �mrt�/Poh� (dva)";
    $text['nobd'] = "Bez dat narozen� nebo �mrt�";
    $text['bcdb'] = "Naroz/K�est/�mrt�/Poh� (�ty�i)";
    $text['numsys'] = "Syst�m ��slov�n�";
    $text['gennums'] = "��sla generac�";
    $text['henrynums'] = "��slov�n� dle Henryho";
    $text['abovnums'] = "��slov�n� dle d'Aboville";
    $text['devnums'] = "��slov�n� dle de Villiers";
    $text['dispopts'] = "Mo�nosti zobrazen�";
    //added in 10.0.0
    $text['no_ancestors'] = "Nebyli nalezeni ��dn� p�edkov�";
    $text['ancestor_chart'] = "Svisl� sch�ma p�edk�";
    $text['opennewwindow'] = "Otev��t v nov�m okn�";
    $text['pedvertical'] = "Svisle";
    //added in 11.0.0
    $text['familywith'] = "Rodina s";
    $text['fcmlogin'] = "Pro zobrazen� podrobnost� se mus�te p�ihl�sit";
    $text['isthe'] = "je";
    $text['otherspouses'] = "dal�� partne�i/partnerky";
    $text['parentfamily'] = "Rodina rodi�� ";
    $text['showfamily'] = "Zobrazit rodinu";
    $text['shown'] = "zobrazeno";
    $text['showparentfamily'] = "zobrazit rodinu rodi��";
    $text['showperson'] = "zobrazit osobu";
    //added in 11.0.2
    $text['otherfamilies'] = "Dal�� rodiny";
    break;

  //search.php, searchform.php
  //merged with reports and showreport in 5.0.0
  case "search":
  case "reports":
    $text['noreports'] = "��dn� report neexistuje.";
    $text['reportname'] = "N�zev reportu";
    $text['allreports'] = "V�echny reporty";
    $text['report'] = "Report";
    $text['error'] = "Chyba";
    $text['reportsyntax'] = "Syntaxe dotazu pro tento report";
    $text['wasincorrect'] = "byla chybn� a report nemohl b�t vytvo�en. Kontaktujte pros�m administr�tora syst�mu na";
    $text['errormessage'] = "Chybov� hl�en�";
    $text['equals'] = "je";
    $text['endswith'] = "kon�� na";
    $text['soundexof'] = "soundex";
    $text['metaphoneof'] = "metaphone of";
    $text['plusminus10'] = "+/- 10 rok� od";
    $text['lessthan'] = "m�n� ne�";
    $text['greaterthan'] = "v�ce ne�";
    $text['lessthanequal'] = "m�n� nebo rovno";
    $text['greaterthanequal'] = "v�ce nebo rovno";
    $text['equalto'] = "rovno";
    $text['tryagain'] = "Zkusit znovu";
    $text['joinwith'] = "Logika hled�n�";
    $text['cap_and'] = "A";
    $text['cap_or'] = "NEBO";
    $text['showspouse'] = "Zobrazit partnera (pokud m�la doty�n� osoba v�ce partner�, bude zobrazena v�cekr�t)";
    $text['submitquery'] = "Prov�st dotaz";
    $text['birthplace'] = "M�sto narozen�";
    $text['deathplace'] = "M�sto �mrt�";
    $text['birthdatetr'] = "Rok narozen�";
    $text['deathdatetr'] = "Rok �mrt�";
    $text['plusminus2'] = "+/- 2 roky od";
    $text['resetall'] = "Obnovit v�echny hodnoty na v�choz�";
    $text['showdeath'] = "Zobrazit informace o �mrt�/poh�bu";
    $text['altbirthplace'] = "M�sto k�tu";
    $text['altbirthdatetr'] = "Rok k�tu";
    $text['burialplace'] = "M�sto poh�bu";
    $text['burialdatetr'] = "Rok poh�bu";
    $text['event'] = "Ud�lost(i)";
    $text['day'] = "Den";
    $text['month'] = "M�s�c";
    $text['keyword'] = "Kl��ov� slovo (nap�. \"Abt\")";
    $text['explain'] = "Pro zobrazen� odpov�daj�c�ch ud�lost� zadejte datum. Pro zobrazen� v�ech ud�lost� zanechte pole pr�zdn�.";
    $text['enterdate'] = "Zadejte nebo zvolte alespo� jedno z n�sleduj�c�ch: Den, M�s�c, Rok, Kl��ov� slovo";
    $text['fullname'] = "Cel� jm�no";
    $text['birthdate'] = "Datum narozen�";
    $text['altbirthdate'] = "Datum k�tu";
    $text['marrdate'] = "Datum s�atku";
    $text['spouseid'] = "ID ��slo partnera";
    $text['spousename'] = "Jm�no partnera";
    $text['deathdate'] = "Datum �mrt�";
    $text['burialdate'] = "Datum poh�bu";
    $text['changedate'] = "Datum posledn� zm�ny";
    $text['gedcom'] = "Strom";
    $text['baptdate'] = "CJKSpd datum k�tu";
    $text['baptplace'] = "CJKSpd m�sto k�tu";
    $text['endldate'] = "CJKSpd datum zasl�ben�";
    $text['endlplace'] = "CJKSpd m�sto zasl�ben�";
    $text['ssealdate'] = "CJKSpd datum pe�et�n� s partnerem";   //Sealed to spouse
    $text['ssealplace'] = "CJKSpd m�sto pe�et�n� s partnerem";
    $text['psealdate'] = "CJKSpd datum pe�et�n� s rodi�i";   //Sealed to parents
    $text['psealplace'] = "CJKSpd m�sto pe�et�n� s rodi�i";
    $text['marrplace'] = "M�sto s�atku";
    $text['spousesurname'] = "P��jmen� partnera";
    $text['spousemore'] = "Zap�ete-li p��jmen� partnera, mus�te vybrat Pohlav�.";
    $text['plusminus5'] = "+/- 5 roku od";
    $text['exists'] = "existuje";
    $text['dnexist'] = "neexistuje";
    $text['divdate'] = "Datum rozvodu";
    $text['divplace'] = "M�sto rozvodu";
    $text['otherevents'] = "Jin� ud�losti";
    $text['numresults'] = "Po�et v�sledk� na str�nce";
    $text['mysphoto'] = "Tajemn� fotografie";
    $text['mysperson'] = "Hledan� osoby";
    $text['joinor'] = "'Join with OR' mo�nost nelze pou��t s p��jmen�m partnera";
    $text['tellus'] = "M�te-li n�jak� informace, napi�te n�m";
    $text['moreinfo'] = "V�ce informac�";
    //added in 8.0.0
    $text['marrdatetr'] = "Rok s�atku";
    $text['divdatetr'] = "Rok rozvodu";
    $text['mothername'] = "Jm�no matky";
    $text['fathername'] = "Jm�no otce";
    $text['filter'] = "Filtr";
    $text['notliving'] = "Zesnul�";
    $text['nodayevents'] = "Ud�losti v tomto m�s�ci, kter� nejsou spojeny s ur�it�m dnem:";
    //added in 9.0.0
    $text['csv'] = "Soubor CSV odd�len� ��rkami";
    //added in 10.0.0
    $text['confdate'] = "Datum bi�mov�n� (CJKSpd)";
    $text['confplace'] = "M�sto bi�mov�n� (CJKSpd)";
    $text['initdate'] = "Datum zasv�cen� (CJKSpd)";
    $text['initplace'] = "M�sto zasv�cen� (CJKSpd)";
    //added in 11.0.0
    $text['marrtype'] = "Typ s�atku";
    $text['searchfor'] = "Hledat";
    $text['searchnote'] = "Pozn.: Tato str�nka pro vyhled�n� pou��v� Google. Po�et nalezen�ch z�znam� je p��mo ovlivn�n m�rou, jakou m� Google tyto str�nky indexovan�.";
    break;

  //showlog.php
  case "showlog":
    $text['logfilefor'] = "Soubor z�znam� pro";
    $text['mostrecentactions'] = "Ned�vn� aktivita";
    $text['autorefresh'] = "Automatick� zobrazen� (po 30 vte�in�ch)";
    $text['refreshoff'] = "Vypnout automatick� zobrazen�";
    break;

  case "headstones":
  case "showphoto":
    $text['cemeteriesheadstones'] = "H�bitovy a n�hrobky";
    $text['showallhsr'] = "Zobrazit v�echny z�znamy n�hrobk�";
    $text['in'] = "v";
    $text['showmap'] = "Uk�zat mapu";
    $text['headstonefor'] = "N�hrobek pro";
    $text['photoof'] = "Fotografie";
    $text['photoowner'] = "Majitel/Pramen";
    $text['nocemetery'] = "H�bitov nen� uveden";
    $text['iptc005'] = "N�zev";
    $text['iptc020'] = "Podporovan� kategorie";
    $text['iptc040'] = "Zvl�tn� instrukce";
    $text['iptc055'] = "Datum vytvo�en�";
    $text['iptc080'] = "Autor";
    $text['iptc085'] = "Autorova funkce";
    $text['iptc090'] = "M�sto";
    $text['iptc095'] = "Kraj";
    $text['iptc101'] = "Zem�";
    $text['iptc103'] = "OTR";
    $text['iptc105'] = "Nadpis";
    $text['iptc110'] = "Pramen";
    $text['iptc115'] = "Pramen fotografie";
    $text['iptc116'] = "Ve�ker� pr�va vyhrazena";
    $text['iptc120'] = "Popis";
    $text['iptc122'] = "Popis vytvo�il";
    $text['mapof'] = "Mapa";
    $text['regphotos'] = "Zobrazen� s popisem";
    $text['gallery'] = "Pouze n�hledy";
    $text['cemphotos'] = "Obr�zky h�bitov�";
    $text['photosize'] = "Velikost";
    $text['iptc010'] = "Priorita";
    $text['filesize'] = "Velikost souboru";
    $text['seeloc'] = "Prohl�dnete m�sto";
    $text['showall'] = "Zobrazit v�e";
    $text['editmedia'] = "Upravit m�dium";
    $text['viewitem'] = "Prohl�dnout tuto polo�ku";
    $text['editcem'] = "Upravit h�bitov";
    $text['numitems'] = "Po�et polo�ek";
    $text['allalbums'] = "V�echna alba";
    $text['slidestop'] = "Pozastavit prezentaci";
    $text['slideresume'] = "Pokra�ovat v prezentaci";
    $text['slidesecs'] = "Po�et vte�in pro ka�d� sn�mek:";
    $text['minussecs'] = "ubrat 0.5 vte�iny";
    $text['plussecs'] = "p�idat 0.5 vte�iny";
    $text['nocountry'] = "Nezn�m� zem�";
    $text['nostate'] = "Nezn�m� kraj";
    $text['nocounty'] = "Nezn�m� okres";
    $text['nocity'] = "Nezn�m� m�sto";
    $text['nocemname'] = "Nezn�m� h�bitov";
    $text['editalbum'] = "Upravit album";
    $text['mediamaptext'] = "<strong>Pozn.:</strong> Posouv�n�m ukazatele my�i p�es obr�zek zobraz�te popisky r�zn�ch ��st� obr�zku. Zm�n�-li se ukazatel my�i na tvar vzty�en�ho ukazov�ku, m��ete kliknut�m zobrazit str�nku s podrobnostmi.";
    //added in 8.0.0
    $text['allburials'] = "V�echny poh�by";
    $text['moreinfo'] = "Klikn�te pro v�ce informac� o obr�zku";
    //added in 9.0.0
    $text['iptc025'] = "Kl��ov� slova";
    $text['iptc092'] = "Sub-location";
    $text['iptc015'] = "Kategorie";
    $text['iptc065'] = "P�vodn� program";
    $text['iptc070'] = "Verze programu";
    break;

  //surnames.php, surnames100.php, surnames-all.php, surnames-oneletter.php
  case "surnames":
  case "places":
    $text['surnamesstarting'] = "Zobrazit p��jmen� za��naj�c� na";
    $text['showtop'] = "Zobrazit prvn�ch";
    $text['showallsurnames'] = "Zobrazit v�echna p��jmen�";
    $text['sortedalpha'] = "se�azena podle abecedy";
    $text['byoccurrence'] = "se�azen�ch podle �etnosti";
    $text['firstchars'] = "Za��te�n� p�smena";
    $text['mainsurnamepage'] = "Hlavn� str�nka p��jmen�";
    $text['allsurnames'] = "V�echna p��jmen�";
    $text['showmatchingsurnames'] = "Kliknut�m na p��jmen� zobraz�te odpov�daj�c� z�znamy.";
    $text['backtotop'] = "Zp�t na za��tek";
    $text['beginswith'] = "Za��n� na";
    $text['allbeginningwith'] = "V�echna p��jmen� za��naj�c� na";
    $text['numoccurrences'] = "celkov� po�et m�st v z�vorce";
    $text['placesstarting'] = "Zobrazit nejv�znamn�j�� lokality, kter� za��naj� na";
    $text['showmatchingplaces'] = "Kliknut�m na m�sto zobraz�te podrobn�j�� lokality. Kliknut�m na ikonu Hledat zobraz�te odpov�daj�c� osoby.";
    $text['totalnames'] = "celkem osob";
    $text['showallplaces'] = "Zobrazit v�echny nejv�znamn�j�� lokality";
    $text['totalplaces'] = "celkem m�st";
    $text['mainplacepage'] = "Hlavn� str�nka m�st";
    $text['allplaces'] = "V�echny nejv�znamn�j�� lokality";
    $text['placescont'] = "Zobrazit v�echna m�sta obsahuj�c�";
    //changed in 8.0.0
    $text['top30'] = "Top xxx nej�ast�ji se vyskytuj�c�ch p��jmen�";
    $text['top30places'] = "Top xxx nejv�znamn�j��ch lokalit";
    //added in 12.0.0
    $text['firstnamelist'] = "Seznam k�estn�ch jmen";
    $text['firstnamesstarting'] = "Zobrazit k�estn� jm�na za��naj�c� na";
    $text['showallfirstnames'] = "Zobrazit v�echna k�estn� jm�na";
    $text['mainfirstnamepage'] = "Hlavn� str�nka k�estn�ch jmen";
    $text['allfirstnames'] = "V�echna k�estn� jm�na";
    $text['showmatchingfirstnames'] = "Kliknut�m na k�estn� jm�no zobraz�te odpov�daj�c� z�znamy.";
    $text['allfirstbegwith'] = "V�echna k�estn� jm�na za��naj�c� na";
    $text['top30first'] = "Top xxx nej�ast�ji se vyskytuj�c�ch k�estn�ch jmen";
    $text['allothers'] = "V�echna ostatn�";
    $text['amongall'] = "(mezi v�emi jm�ny)";
    $text['justtop'] = "Pouze Top xxx";
    break;

  //whatsnew.php
  case "whatsnew":
    $text['pastxdays'] = "(v posledn�ch xx dnech)";

    $text['photo'] = "Fotografie";
    $text['history'] = "Vypr�v�n�/dokument";
    $text['husbid'] = "ID ��slo otce";
    $text['husbname'] = "Jm�no otce";
    $text['wifeid'] = "ID ��slo matky";
    //added in 11.0.0
    $text['wifename'] = "Jm�no matky";
    break;

  //timeline.php, timeline2.php
  case "timeline":
    $text['text_delete'] = "Vymazat";
    $text['addperson'] = "P�idat osobu";
    $text['nobirth'] = "N�sleduj�c� osoba nem� platn� datum narozen� a nelze ji p�idat";
    $text['event'] = "Ud�lost(i)";
    $text['chartwidth'] = "���ka sch�matu";
    $text['timelineinstr'] = "P�idat osoby";
    $text['togglelines'] = "P�epnout zobrazen� linek";
    //changed in 9.0.0
    $text['noliving'] = "N�sleduj�c� osoba je ozna�ena jako �ij�c� nebo neve�ejn� a nelze ji p�idat, proto�e nem�te pat�i�n� p��stupov� pr�va";
    break;

  //browsetrees.php
  //login.php, newacctform.php, addnewacct.php
  case "trees":
  case "login":
    $text['browsealltrees'] = "Prohl�dnout v�echny stromy";
    $text['treename'] = "N�zev stromu";
    $text['owner'] = "Majitel";
    $text['address'] = "Adresa";
    $text['city'] = "M�sto";
    $text['state'] = "Kraj/provincie";
    $text['zip'] = "PS�";
    $text['country'] = "Zem�";
    $text['email'] = "Email";
    $text['phone'] = "Telefon";
    $text['username'] = "U�ivatelsk� jm�no";
    $text['password'] = "Heslo";
    $text['loginfailed'] = "Chyba p�ihl�en�.";

    $text['regnewacct'] = "Registrace nov�ho ��tu";
    $text['realname'] = "Va�e jm�no a p��jmen�";
    $text['phone'] = "Telefon";
    $text['email'] = "Email";
    $text['address'] = "Adresa";
    $text['acctcomments'] = "Pozn�mky";
    $text['submit'] = "Odeslat";
    $text['leaveblank'] = "(zanechte toto pole pr�zdn�, pokud ��d�te o nov� strom)";
    $text['required'] = "Tyto �daje je nutn� vyplnit";
    $text['enterpassword'] = "Zadejte heslo.";
    $text['enterusername'] = "Zadejte u�ivatelsk� jm�no.";
    $text['failure'] = "Zadan� u�ivatelsk� jm�no je ji� vyhrazen�. Stisknut�m tla��tka zp�t se vra�te na p�edchoz� str�nku a zvolte si jin� u�ivatelsk� jm�no";
    $text['success'] = "Va�e registrace prob�hla �sp�n�. Administr�tor syst�mu v�s bude informovat, kdy bude v� ��et aktivov�n, nebo pokud budou pot�eba dal�� informace.";
    $text['emailsubject'] = "��dost o novou registraci";
    $text['website'] = "Internetov� str�nky";
    $text['nologin'] = "Nem�te p�ihla�ovac� �daje?";
    $text['loginsent'] = "�daje byly odesl�ny";
    $text['loginnotsent'] = "P�ihla�ovac� �daje nebyly odesl�ny";
    $text['enterrealname'] = "Zadejte, pros�m, sv� skute�n� jm�no.";
    $text['rempass'] = "Z�stat p�ihl�en na tomto po��ta�i";
    $text['morestats'] = "Dal�� statistika";
    $text['accmail'] = "POZN.: Abyste mohli obdr�et email od administr�tora ohledne va�eho ��tu, zkontrolujte, pros�m, �e v� emailov� program neblokuje emailov� adresy z t�to dom�ny.";
    $text['newpassword'] = "Nov� heslo";
    $text['resetpass'] = "Obnovit heslo";
    $text['nousers'] = "Tento formul�� nelze pou��t, dokud nebude vytvo�en alespo� jeden z�znam. Pokud jste majitelem t�chto str�nek, jd�te do nab�dky Admin/U�ivatel� a vytvo�te si ��et administr�tora.";
    $text['noregs'] = "Je n�m l�to, ale v sou�asn� dob� nep�ij�m�me nov� registrace. Kontaktujte n�s, pros�m, p��mo, pokud m�te n�jak� dotazy �i p�ipom�nky ohledn� t�chto webov�ch str�nek.";
    //changed in 8.0.0
    $text['emailmsg'] = "Byla v�m zasl�na nov� ��dost o u�ivatelsk� ��et TNG. P�ihlaste se, pros�m, do administr�torsk�ho prost�ed� a dejte nov�mu ��tu pat�i�n� p��stupov� pr�va.";
    $text['accactive'] = "�cet byl aktivov�n, ale u�ivatel nebude m�t ��dn� zvl�tn� pr�va, dokud mu je nep�id�l�te.";
    $text['accinactive'] = "Nastaven� ��tu m��ete prov�st v Admin/U�ivatel�/P�ezkoumat. ��et z�stane neaktivn�, dokud alespo� jednou z�znam neuprav�te a neulo��te.";
    $text['pwdagain'] = "Heslo znovu";
    $text['enterpassword2'] = "Pros�m, vlo�te znovu heslo.";
    $text['pwdsmatch'] = "Heslo neodpov�d�. Pros�m, zadejte stejn� heslo do ka�d�ho pole.";
    //added in 8.0.0
    $text['acksubject'] = "Registrace"; //for a new user account
    $text['ackmessage'] = "Va�e ��dost o u�ivatelsk� ��et byla p�ijata. V� ��et nebude aktivn�, dokud nebude schv�len administr�torem. O schv�len� budete informov�ni emailovou zpr�vou.";
    //added in 12.0.0
    $text['switch'] = "Prohodit";
    break;

  //added in 10.0.0
  case "branches":
    $text['browseallbranches'] = "Prohl�dnout v�echny v�tve";
    break;

  //statistics.php
  case "stats":
    $text['quantity'] = "Mno�stv�";
    $text['totindividuals'] = "Celkem osob";
    $text['totmales'] = "Celkem mu��";
    $text['totfemales'] = "Celkem �en";
    $text['totunknown'] = "Celkem neur�en�ho pohlav�";
    $text['totliving'] = "Celkem �ij�c�ch";
    $text['totfamilies'] = "Celkem rodin";
    $text['totuniquesn'] = "Celkem jedine�n�ch p��jmen�";
    //$text['totphotos'] = "Total Photos";
    //$text['totdocs'] = "Total Histories &amp; Documents";
    //$text['totheadstones'] = "Total Headstones";
    $text['totsources'] = "Celkem pramen�";
    $text['avglifespan'] = "Pr�m�rn� d�lka �ivota";
    $text['earliestbirth'] = "Nejd��ve narozen�";
    $text['longestlived'] = "Osoby, kter� se do�ily nejvy���ho v�ku";
    $text['days'] = "dn�";
    $text['age'] = "V�k";
    $text['agedisclaimer'] = "V�po�ty spojen� s v�kem se zakl�daj� na �daj�ch osob s udan�m datem narozen� <EM>a</EM> �mrt�.  Proto�e jsou n�kter� data ne�pln� (nap�. �mrt� je zaznamen�no pouze jako rok \"1945\" nebo \"p�ed 1860\"), tyto v�po�ty nemus� b�t 100% p�esn�.";
    $text['treedetail'] = "Dal�� informace o tomto stromu";
    $text['total'] = "Celkem";
    //added in 12.0
    $text['totdeceased'] = "Celkem zesnul�ch";
    break;

  case "notes":
    $text['browseallnotes'] = "Prohl�dnout v�echny pozn�mky";
    break;

  case "help":
    $text['menuhelp'] = "N�pov�da nab�dky";
    break;

  case "install":
    $text['perms'] = "V�echna povolen� byla nastavena.";
    $text['noperms'] = "Povolen� nemohla b�t nastavena pro tyto soubory:";
    $text['manual'] = "Nastavte je pros�m manu�ln�.";
    $text['folder'] = "Slo�ka";
    $text['created'] = "byla vytvo�ena";
    $text['nocreate'] = "nemohla b�t vytvo�ena. Zalo�te ji, pros�m, manu�ln�.";
    $text['infosaved'] = "Informace ulo�eny, spojen� potvrzeno!";
    $text['tablescr'] = "Tabulky byly vytvo�eny!";
    $text['notables'] = "N�sleduj�c� tabulky nemohly b�t vytvo�eny:";
    $text['nocomm'] = "TNG nem��e nav�zat komunikaci s va�� datab�z�. ��dn� tabulky nebyly vytvo�eny.";
    $text['newdb'] = "Informace ulo�eny, spojen� potvrzeno, nov� datab�ze byla vytvo�ena:";
    $text['noattach'] = "Informace ulo�eny. Spojen� nav�z�no a datab�ze vytvo�ena, ale TNG se k n� nem��e p�ipojit.";
    $text['nodb'] = "Informace ulo�eny. Spojen� nav�z�no, ale datab�ze neexistuje a nemohla b�t vytvo�ena. Ov��te si, �e n�zev datab�ze je spr�vn� anebo pou�ijte ovl�dac� panel a vytvo�te ji.";
    $text['noconn'] = "Informace ulo�ena, ale spojen� nebylo nav�z�no.  N�kter� z n�sleduj�ch v�c� jsou chybn�:";
    $text['exists'] = "existuje";
    $text['loginfirst'] = "Nejd��ve se mus�te p�ihl�sit.";
    $text['noop'] = "��dn� operace nebyla provedena.";
    //added in 8.0.0
    $text['nouser'] = "��et nebyl vytvo�en. U�ivatelsk� jm�no ji� z�ejm� existuje.";
    $text['notree'] = "Strom nebyl vytvo�en. ID ��slo stromu z�ejm� ji� existuje.";
    $text['infosaved2'] = "Informace ulo�ena";
    $text['renamedto'] = "p�ejmenov�n na";
    $text['norename'] = "nemohl b�t p�ejmenov�n";
    break;

  case "imgviewer":
    $text['zoomin'] = "Zv�t�it";
    $text['zoomout'] = "Zmen�it";
    $text['magmode'] = "Re�im zv�t�ov�n�";
    $text['panmode'] = "Re�im sledov�n�";
    $text['pan'] = "Je-li obr�zek v�t�� ne� okno prohl�e�e, obr�zkem v okn� posunete kliknut�m my�� dovnit� obr�zku a jej�m dr�en�m a ta�en�m";
    $text['fitwidth'] = "Na celou ���ku";
    $text['fitheight'] = "Na celou v��ku";
    $text['newwin'] = "Nov� okno";
    $text['opennw'] = "Otev��t obr�zek v nov�m okn�";
    $text['magnifyreg'] = "Kliknut�m my�i dovnit� obr�zku zv�t��te tuto ��st obr�zku";
    $text['imgctrls'] = "Zapnout ovl�d�n� obr�zku";
    $text['vwrctrls'] = "Zapnout ovl�d�n� prohl�e�e obr�zku";
    $text['vwrclose'] = "Zav��t prohl�e� obr�zku";
    break;

  case "dna":
    $text['test_date'] = "Datum testu";
    $text['links'] = "Odpov�daj�c� odkazy";
    $text['testid'] = "ID testu";
    //added in 12.0.0
    $text['mode_values'] = "Hodnoty m�du";
    $text['compareselected'] = "Porovnat vybran�";
    $text['dnatestscompare'] = "Porovnat testy Y-DNA";
    $text['keep_name_private'] = "Zachovat jm�no neve�ejn�";
    $text['browsealltests'] = "Proch�zet v�echny testy";
    $text['all_dna_tests'] = "V�echny testy DNA";
    $text['fastmutating'] = "Rychl� mutace";
    $text['alltypes'] = "V�echny typy";
    $text['allgroups'] = "V�echny skupiny";
    $text['Ydna_LITbox_info'] = "Test(y) p�ipojen� k t�to osob� nemus� nutn� od t�to osoby poch�zet.<br />Ve sloupci 'Haploskupina' se zobraz� data �erven�, pokud je v�sledek 'P�edpov�zen', nebo zelen�, pokud je test 'Potvrzen'";
    //added in 12.1.0
    $text['dnatestscompare_mtdna'] = "Porovnat vybran� testy mtDNA";
    $text['dnatestscompare_atdna'] = "Porovnat vybran� testy atDNA";
    $text['chromosome'] = "Chr";
    $text['centiMorgans'] = "cM";
    $text['snps'] = "SNP";
    $text['y_haplogroup'] = "Y-DNA";
    $text['mt_haplogroup'] = "mtDNA";
    $text['sequence'] = "Ref";
    $text['extra_mutations'] = "Zvl�tn� mutace";
    $text['mrca'] = "Nejbli��� spole�n� p�edek";
    $text['ydna_test'] = "Testy Y-DNA";
    $text['mtdna_test'] = "Testy mtDNA (mitochondri�ln�)";
    $text['atdna_test'] = "Testy atDNA (autozom�ln�)";
    $text['segment_start'] = "Za��tek";
    $text['segment_end'] = "Konec";
    $text['suggested_relationship'] = "Navrhnut�";
    $text['actual_relationship'] = "Aktu�ln�";
    $text['12markers'] = "Markery 1-12";
    $text['25markers'] = "Markery 13-25";
    $text['37markers'] = "Markery 26-37";
    $text['67markers'] = "Markery 38-67";
    $text['111markers'] = "Markery 68-111";
    break;
}

//common
$text['matches'] = "Z�znamy";
$text['description'] = "Popis";
$text['notes'] = "Pozn�mky";
$text['status'] = "Stav";
$text['newsearch'] = "Nov� hled�n�";
$text['pedigree'] = "Sch�ma p�edk�";
$text['seephoto'] = "Prohl�dnout fotografii";
$text['andlocation'] = "& m�sto";
$text['accessedby'] = "z�znam prohl�el";
$text['family'] = "Rodina"; //from getperson
$text['children'] = "D�ti";  //from getperson
$text['tree'] = "Strom";
$text['alltrees'] = "V�echny stromy";
$text['nosurname'] = "[bez p��jmen�]";
$text['thumb'] = "N�hled";  //as in Thumbnail
$text['people'] = "Lid�";
$text['title'] = "Titul";  //from getperson
$text['suffix'] = "P��pona";  //from getperson
$text['nickname'] = "P�ezd�vka";  //from getperson
$text['lastmodified'] = "Posledn� zm�na";  //from getperson
$text['married'] = "S�atek";  //from getperson
//$text['photos'] = "Photos";
$text['name'] = "Jm�no"; //from showmap
$text['lastfirst'] = "P��jmen�, jm�no";  //from search
$text['bornchr'] = "Narozen�/K�est";  //from search
$text['individuals'] = "Osoby";  //from whats new
$text['families'] = "Rodiny";
$text['personid'] = "ID ��slo osoby";
$text['sources'] = "Prameny";  //from getperson (next several)
$text['unknown'] = "Nezn�m�";
$text['father'] = "Otec";
$text['mother'] = "Matka";
$text['christened'] = "K�est";
$text['died'] = "�mrt�";
$text['buried'] = "Poh�eb";
$text['spouse'] = "Partner";  //from search
$text['parents'] = "Rodi�e";  //from pedigree
$text['text'] = "Text";  //from sources
$text['language'] = "Jazyk";  //from languages
$text['descendchart'] = "Sch�ma potomk�";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Osoba";
$text['edit'] = "Upravit";
$text['date'] = "Datum";
$text['place'] = "M�sto";
$text['login'] = "P�ihl�en�";
$text['logout'] = "Odhl�en�";
$text['groupsheet'] = "Sch�ma rodiny";
$text['text_and'] = "a";
$text['generation'] = "Generace";
$text['filename'] = "N�zev souboru";
$text['id'] = "ID ��slo";
$text['search'] = "Hledat";
$text['user'] = "U�ivatel";
$text['firstname'] = "Jm�no";
$text['lastname'] = "P��jmen�";
$text['searchresults'] = "V�sledky hled�n�";
$text['diedburied'] = "�mrt�/Poh�eb";
$text['homepage'] = "Domovsk� str�nka";
$text['find'] = "Naj�t (osobu)";
$text['relationship'] = "P��buzensk� vztah";    //in German, Verwandtschaft
$text['relationship2'] = "Vztah"; //different in some languages, at least in German (Beziehung)
$text['timeline'] = "�asov� linie";
$text['yesabbr'] = "A";               //abbreviation for 'yes'
$text['divorced'] = "Rozvod";
$text['indlinked'] = "Spojeno s";
$text['branch'] = "V�tev";
$text['moreind'] = "Dal�� osoby";
$text['morefam'] = "Dal�� rodiny";
$text['source'] = "Pramen";
$text['surnamelist'] = "Seznam p��jmen�";
$text['generations'] = "Po�et generac�";
$text['refresh'] = "Obnovit";
$text['whatsnew'] = "Co je nov�ho";
$text['reports'] = "Reporty";
$text['placelist'] = "Seznam m�st";
$text['baptizedlds'] = "K�est (CJKSpd)";
$text['endowedlds'] = "Obdarov�n (CJKSpd)";
$text['sealedplds'] = "Pe�et�n R (CJKSpd)";
$text['sealedslds'] = "Pe�et�n P (CJKSpd)";
$text['ancestors'] = "P�edkov�";
$text['descendants'] = "Potomci";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Datum posledn�ho importu souboru GEDCOM";
$text['type'] = "Druh";
$text['savechanges'] = "Ulo�it zm�ny";
$text['familyid'] = "ID ��slo rodiny";
$text['headstone'] = "N�hrobky";
$text['historiesdocs'] = "Vypr�v�n�";
$text['anonymous'] = "anonymn�";
$text['places'] = "M�sta";
$text['anniversaries'] = "Data a v�ro��";
$text['administration'] = "Administrace";
$text['help'] = "N�pov�da";
//$text['documents'] = "Documents";
$text['year'] = "Rok";
$text['all'] = "V�e";
$text['repository'] = "�lo�i�t�";
$text['address'] = "Adresa";
$text['suggest'] = "Navrhnout";
$text['editevent'] = "Navrhnout zm�nu pro tuto ud�lost";
$text['findplaces'] = "Naj�t v�echny osoby s ud�lostmi v tomto m�st�";
$text['morelinks'] = "V�ce odkaz�";
$text['faminfo'] = "Informace o rodin�";
$text['persinfo'] = "Osobn� informace";
$text['srcinfo'] = "Informace o pramenu";
$text['fact'] = "Fakt";
$text['goto'] = "Zvolte str�nku";
$text['tngprint'] = "Tisk";
$text['databasestatistics'] = "Statistika datab�ze"; //needed to be shorter to fit on menu
$text['child'] = "D�t�";  //from familygroup
$text['repoinfo'] = "�daje o �lo�i�ti";
$text['tng_reset'] = "Obnovit";
$text['noresults'] = "��dn� v�sledky nebyly nalezeny";
$text['allmedia'] = "V�echna m�dia";
$text['repositories'] = "�lo�i�t� pramen�";
$text['albums'] = "Alba";
$text['cemeteries'] = "H�bitovy";
$text['surnames'] = "P��jmen�";
$text['dates'] = "Data";
$text['link'] = "Odkaz";
$text['media'] = "M�dia";
$text['gender'] = "Pohlav�";
$text['latitude'] = "���ka";
$text['longitude'] = "D�lka";
$text['bookmarks'] = "Z�lo�ky";
$text['bookmark'] = "P�idat z�lo�ku";
$text['mngbookmarks'] = "Zobrazit z�lo�ky";
$text['bookmarked'] = "Z�lo�ka p�id�na";
$text['remove'] = "Odebrat";
$text['find_menu'] = "Naj�t";
$text['info'] = "Info"; //this needs to be a very short abbreviation
$text['cemetery'] = "H�bitov";
$text['gmapevent'] = "Mapa ud�lost�";
$text['gevents'] = "Ud�lost";
$text['glang'] = "&amp;hl=cs";
$text['googleearthlink'] = "Odkaz na Google Earth";
$text['googlemaplink'] = "Odkaz na Google Maps";
$text['gmaplegend'] = "Legenda";
$text['unmarked'] = "Neozna�en�";
$text['located'] = "Nach�zej�c� se";
$text['albclicksee'] = "Kliknut�m zobrazit v�echny polo�ky v tomto albu";
$text['notyetlocated'] = "Dosud nenalezen";
$text['cremated'] = "Zpopeln�n";
$text['missing'] = "Chyb�j�c�";
$text['pdfgen'] = "Gener�tor PDF";
$text['blank'] = "Pr�zdn� sch�ma";
$text['none'] = "��dn�";
$text['fonts'] = "Font";
$text['header'] = "Hlavi�ka";
$text['data'] = "Data";
$text['pgsetup'] = "Nastaven� str�nky";
$text['pgsize'] = "Velikost str�nky";
$text['orient'] = "Orientace"; //for a page
$text['portrait'] = "Na v��ku";
$text['landscape'] = "Na ���ku";
$text['tmargin'] = "Horn� okraj";
$text['bmargin'] = "Spodn� okraj";
$text['lmargin'] = "Lev� okraj";
$text['rmargin'] = "Prav� okraj";
$text['createch'] = "Vytvo�it sch�ma";
$text['prefix'] = "P�edpona";
$text['mostwanted'] = "Hled� se";
$text['latupdates'] = "Posledn� aktuality";
$text['featphoto'] = "Hlavn� fotografie";
$text['news'] = "Novinky";
$text['ourhist'] = "Na�e rodinn� historie";
$text['ourhistanc'] = "Historie a p�edkov� na�� rodiny";
$text['ourpages'] = "Genealogick� str�nky na�� rodiny";
$text['pwrdby'] = "Tyto str�nky b�� na";
$text['writby'] = "vytvo�il";
$text['searchtngnet'] = "Prohledat TNG Network (GENDEX)";
$text['viewphotos'] = "Prohl�dnout v�echny fotografie";
$text['anon'] = "Sou�asn� jste anonymn�";
$text['whichbranch'] = "Ze kter� v�tve jste?";
$text['featarts'] = "Nejzaj�mav�j�� �l�nky";
$text['maintby'] = "Syst�m spravuje";
$text['createdon'] = "Vytvo�eno";
$text['reliability'] = "V�rohodnost";
$text['labels'] = "Popisky";
$text['inclsrcs'] = "Zahrnout prameny";
$text['cont'] = "(pokra�.)"; //abbreviation for continued
$text['mnuheader'] = "Domovsk� str�nka";
$text['mnusearchfornames'] = "Hledat";
$text['mnulastname'] = "P��jmen�";
$text['mnufirstname'] = "Jm�no";
$text['mnusearch'] = "Hledat";
$text['mnureset'] = "Za��t znovu";
$text['mnulogon'] = "P�ihl�en�";
$text['mnulogout'] = "Odhl�en�";
$text['mnufeatures'] = "Dal�� mo�nosti";
$text['mnuregister'] = "Registrace nov�ho ��tu";
$text['mnuadvancedsearch'] = "Roz���en� hled�n�";
$text['mnulastnames'] = "P��jmen�";
$text['mnustatistics'] = "Statistika";
$text['mnuphotos'] = "Fotografie";
$text['mnuhistories'] = "Vypr�v�n�";
$text['mnumyancestors'] = "Fotografie &amp; vypr�v�n� pro p�edky od [Person]";
$text['mnucemeteries'] = "H�bitovy";
$text['mnutombstones'] = "N�hrobky";
$text['mnureports'] = "Reporty";
$text['mnusources'] = "Prameny";
$text['mnuwhatsnew'] = "Co je nov�ho";
$text['mnushowlog'] = "Z�znam p��stup�";
$text['mnulanguage'] = "Zm�na jazyka";
$text['mnuadmin'] = "Administrace";
$text['welcome'] = "V�tejte";
$text['contactus'] = "Napi�te n�m";
//changed in 8.0.0
$text['born'] = "Narozen�";
$text['searchnames'] = "Hledat osoby";
//added in 8.0.0
$text['editperson'] = "Upravit Osoby";
$text['loadmap'] = "Nahr�t mapu";
$text['birth'] = "Narozen�";
$text['wasborn'] = "se narodil(a)";
$text['startnum'] = "Prvn� ��slo";
$text['searching'] = "Vyhled�v�m";
//moved here in 8.0.0
$text['location'] = "M�sto";
$text['association'] = "Spojen�";
$text['collapse'] = "Sbalit";
$text['expand'] = "Rozbalit";
$text['plot'] = "Plot";
$text['searchfams'] = "Hledat rodiny";
//added in 8.0.2
$text['wasmarried'] = "byl(a) sezd�n(a) s";
$text['anddied'] = "zem�el(a)";
//added in 9.0.0
$text['share'] = "Sd�let";
$text['hide'] = "Skr�t";
$text['disabled'] = "V� u�ivatelsk� ��et byl zablokov�n.  Kontaktujte, pros�m, administr�tora.";
$text['contactus_long'] = "Pokud m�te n�jak� dotazy nebo p�ipom�nky ohledn� informac� na t�chto str�nk�ch, nebo byste m�li z�jem spolupracovat na dal��m v�zkumu, p��padn� poskytnout dal�� informace, nev�hejte a <span class=\"emphasis\"><a href=\"suggest.php\">kontaktujte m�</a></span>.";
$text['features'] = "Zaj�mavosti";
$text['resources'] = "Zdroje";
$text['latestnews'] = "Posledn� novinky";
$text['trees'] = "Stromy";
$text['wasburied'] = "byl(a) poh�ben(a)";
//moved here in 9.0.0
$text['emailagain'] = "Email znovu";
$text['enteremail2'] = "Zadejte, pros�m, znovu va�i emailovou adresu.";
$text['emailsmatch'] = "Zadan� emailov� adresy nesouhlas�. Zadejte stejnou emailovou adresu do obou pol�.";
$text['getdirections'] = "Klikn�te pro podrobnosti";
$text['calendar'] = "Kalend��";
//changed in 9.0.0
$text['directionsto'] = " to the ";
$text['slidestart'] = "Zah�jit prezentaci";
$text['livingnote'] = "S touto pozn�mkou je spojena alespo� jedna �ij�c� osoba - podrobnosti nejsou zve�ejn�ny.";
$text['livingphoto'] = "S touto polo�kou je spojena alespo� jedna �ij�c� osoba nebo osoba ozna�en� jako neve�ejn� - podrobnosti nejsou zve�ejn�ny.";
$text['waschristened'] = "byl(a) pok�t�n(a)";
//added in 10.0.0
$text['branches'] = "V�tve";
$text['detail'] = "Detail";
$text['moredetail'] = "V�ce detail�";
$text['lessdetail'] = "M�n� detail�";
$text['otherevents'] = "Jin� ud�losti";
$text['conflds'] = "Bi�mov�n (CJKSpd)";
$text['initlds'] = "Zasv�cen (CJKSpd)";
$text['wascremated'] = "byl(a) zpopeln�n(a)";
//moved here in 11.0.0
$text['text_for'] = "pro";
//added in 11.0.0
$text['searchsite'] = "Hledat na t�to str�nce";
$text['searchsitemenu'] = "Hledat na str�nce";
$text['kmlfile'] = "Nahr�t soubor .kml pro zobrazen� tohoto m�sta v Google Earth";
$text['download'] = "Kliknut�m nahr�t";
$text['more'] = "V�ce";
$text['heatmap'] = "Zobrazit mapu";
$text['refreshmap'] = "Obnovit mapu";
$text['remnums'] = "Vymazat ��sla a �pendl�ky";
$text['photoshistories'] = "Fotografie &amp; Vypr�v�n�";
$text['familychart'] = "Graf rodiny";
//added in 12.0.0
$text['firstnames'] = "K�estn� jm�na";
//moved here in 12.0.0
$text['dna_test'] = "Test DNA";
$text['test_type'] = "Typ testu";
$text['test_info'] = "Informace o testu";
$text['takenby'] = "Testovan� osoba";
$text['haplogroup'] = "Haploskupina";
$text['hvr1'] = "HVR1";
$text['hvr2'] = "HVR2";
$text['relevant_links'] = "Relevantn� odkazy";
$text['nofirstname'] = "[��dn� k�estn� jm�no]";
//added in 12.0.1
$text['cookieuse'] = "Pozn�mka: Tyto internetov� str�nky pou��vaj� cookies.";
$text['dataprotect'] = "Ochrana osobn�ch �daj�";
$text['viewpolicy'] = "Zobrazit z�sady";
$text['understand'] = "Rozum�m";
$text['consent'] = "Souhlas�m s ulo�en�m a zpracov�n�m osobn�ch �daj�. Vlastn�ka t�chto internetov�ch str�nek mohu kdykoli po��dat, aby tyto informace odstranil.";
$text['consentreq'] = "Uve�te sv�j souhlas k ukl�d�n� osobn�ch �daj� na tomto webu.";

//added in 12.1.0
$text['testsarelinked'] = "DNA tests are associated with";
$text['testislinked'] = "DNA test is associated with";

//added in 12.2
$text['quicklinks'] = "Rychl� odkazy";
$text['yourname'] = "Va�e jm�no";
$text['youremail'] = "Va�e emailov� adresa";
$text['liketoadd'] = "Jak�koli informace, kter� chcete p�idat";
$text['webmastermsg'] = "Zpr�va webmastera";
$text['gallery'] = "Zobrazit galerii";
$text['wasborn_male'] = "se narodil";    // same as $text['wasborn'] if no gender verb
$text['wasborn_female'] = "se narodila";  // same as $text['wasborn'] if no gender verb
$text['waschristened_male'] = "byl pok�t�n";  // same as $text['waschristened'] if no gender verb
$text['waschristened_female'] = "byla pok�t�na";  // same as $text['waschristened'] if no gender verb
$text['died_male'] = "zem�el";  // same as $text['anddied'] of no gender verb
$text['died_female'] = "zem�ela";  // same as $text['anddied'] of no gender verb
$text['wasburied_male'] = "byl poh�bena";  // same as $text['wasburied'] if no gender verb
$text['wasburied_female'] = "byla poh�bena";  // same as $text['wasburied'] if no gender verb
$text['wascremated_male'] = "byl zpopeln�n";    // same as $text['wascremated'] if no gender verb
$text['wascremated_female'] = "byla zpopeln�na";  // same as $text['wascremated'] if no gender verb
$text['wasmarried_male'] = "byl sezd�n s";  // same as $text['wasdmarried'] if no gender verb
$text['wasmarried_female'] = "byla sezd�na s";  // same as $text['wasdmarried'] if no gender verb
$text['wasdivorced_male'] = "byl rozveden";  // might be the same as $text['divorce'] but as a verb
$text['wasdivorced_female'] = "byla rozveda";  // might be the same as $text['divorce'] but as a verb
$text['inplace'] = " v ";      // used as a preposition to the location
$text['onthisdate'] = " dne ";    // when used with full date
$text['inthisyear'] = " v ";    // when used with year only or month / year dates
$text['and'] = "a ";    // used in conjunction with wasburied or was cremated

//moved here in 12.3
$text['dna_info_head'] = "Info o testu DNA";
$text['firstpage'] = "Prvn� str�nka";
$text['lastpage'] = "Posledn� str�nka";

@include_once "captcha_text.php";
@include_once "alltext.php";
if (!$alltextloaded) {
  getAllTextPath();
}

<?php
switch ($textpart) {
    //browsesources.php, showsource.php
    case "sources":
        $text['browseallsources'] = "L�hdeaineistot";
        $text['shorttitle'] = "Lyhyt nimike";
        $text['callnum'] = "Paikkamerkki";
        $text['author'] = "Kirjoittaja";
        $text['publisher'] = "Julkaisija";
        $text['other'] = "Muut tiedot";
        $text['sourceid'] = "L�hteen ID-numero";
        $text['moresrc'] = "Lis�� l�hteit�";
        $text['repoid'] = "Tietovaraston ID-numero";
        $text['browseallrepos'] = "Selaa kaikki tietovarastot";
        break;

    //changelanguage.php, savelanguage.php
    case "language":
        $text['newlanguage'] = "Uusi kieli";
        $text['changelanguage'] = "Vaihda kielt�";
        $text['languagesaved'] = "Kieli vaihdettu";
        $text['sitemaint'] = "Sivuston yll�pito k�ynniss�";
        $text['standby'] = "Sivusto on tilap�isesti suljettu tietokannan p�ivitt�misen vuoksi. Yrit� uudelleen muutaman minuutin kuluttua. Jos sivusto pysyy suljettuna pidemm�n aikaa, <a href=\"suggest.php\">ota yhteytt� yll�pitoon</a>.";
        break;

    //gedcom.php, gedform.php
    case "gedcom":
        $text['gedstart'] = "GEDCOM alkaen t�st�";
        $text['producegedfrom'] = "Sis�llyt� tiedostoon";
        $text['numgens'] = "Sukupolvien lukum��r�";
        $text['includelds'] = "Sis�llyt� LDS-tiedot";
        $text['buildged'] = "Luo GEDCOM";
        $text['gedstartfrom'] = "GEDCOM alkaen";
        $text['nomaxgen'] = "Sukupolvien enimm�ism��r�tieto puuttuu. K�yt� selaimen takaisin-painiketta palataksesi edelliselle sivulle ja t�yt� kentt�.";
        $text['gedcreatedfrom'] = "GEDCOM luotu alkaen";
        $text['gedcreatedfor'] = "k�ytt�j�lle";
        $text['creategedfor'] = "Luo GEDCOM-tiedosto";
        $text['email'] = "S�hk�posti";
        $text['suggestchange'] = "Ehdota muutosta";
        $text['yourname'] = "Nimesi";
        $text['comments'] = "Kommentit";
        $text['comments2'] = "Kommentit";
        $text['submitsugg'] = "L�het� muutospyynt�";
        $text['proposed'] = "Ehdotettu muutospyynt�";
        $text['mailsent'] = "Kiitos, viestisi on l�hetetty.";
        $text['mailnotsent'] = "Virhe. Pahoittelemme, mutta viesti�si ei voitu toimittaa. Ota yhteys henkil��n xxx osoitteessa yyy.";
        $text['mailme'] = "L�het� kopio t�h�n osoitteeseen.";
        $text['entername'] = "Anna nimesi";
        $text['entercomments'] = "Kirjoita kommenttisi";
        $text['sendmsg'] = "L�het� viesti";
        //added in 9.0.0
        $text['subject'] = "Aihe";
        break;

    //getextras.php, getperson.php
    case "getperson":
        $text['photoshistoriesfor'] = "Kuvat ja el�m�kerrat";
        $text['indinfofor'] = "Henkil�tiedot:";
        $text['pp'] = "s."; //page abbreviation
        $text['age'] = "Ik�";
        $text['agency'] = "Toimisto";
        $text['cause'] = "Syy";
        $text['suggested'] = "Ehdotettu";
        $text['closewindow'] = "Sulje ikkuna";
        $text['thanks'] = "Kiitos";
        $text['received'] = "L�hett�m�si muutospyynt� on vastaanotettu ja l�hetetty sivuston yll�pidolle.";
        $text['indreport'] = "Yksil�raportti";
        $text['indreportfor'] = "Yksil�raportti";
        $text['general'] = "Yleinen";
        $text['bkmkvis'] = "<strong>Huom:</strong> N�m� kirjanmerkit n�kyv�t vain t�ll� tietokoneella ja t�ss� selaimessa.";
        //added in 9.0.0
        $text['reviewmsg'] = "Sinulle on ehdotettu muutosta, joka vaatii hyv�ksynt�si. T�m� ehdotus koskee:";
        $text['revsubject'] = "Ehdotettu muutos vaatii hyv�ksynt�si";
        break;

    //relateform.php, relationship.php, findpersonform.php, findperson.php
    case "relate":
        $text['relcalc'] = "Sukulaisuuslaskuri";
        $text['findrel'] = "Etsi sukulaisuussuhdetta";
        $text['person1'] = "Henkil� 1:";
        $text['person2'] = "Henkil� 2:";
        $text['calculate'] = "Tee haku";
        $text['select2inds'] = "Ole hyv� ja valitse kaksi henkil��.";
        $text['findpersonid'] = "Etsi henkil�n ID";
        $text['enternamepart'] = "anna osa etu- ja/tai sukunimest�";
        $text['pleasenamepart'] = "Ole hyv� ja anna osa etu- ja/tai sukunimest�.";
        $text['clicktoselect'] = "valitse henkil� klikkaamalla linkki�";
        $text['nobirthinfo'] = "Ei syntym�tietoja";
        $text['relateto'] = "Sukulaisuussuhde henkil��n";
        $text['sameperson'] = "Valitsit molempiin kenttiin saman henkil�n!";
        $text['notrelated'] = "Henkil�ille ei l�ydy sukulaisuussuhdetta xxx sukupolven ajalta."; //xxx will be replaced with number of generations
        $text['findrelinstr'] = "Sukulaisuussuhteen selvitt�miseksi, anna kahden henkil�n ID-numerot, tai pid� henkil�t n�kyvill�. Klikkaa sitten 'Selvit�' selvitt��ksesi heid�n sukulaisuussuhteensa.";
        $text['sometimes'] = "(Sukupolvien eri m��r� voi joskus antaa eri tuloksen.)";
        $text['findanother'] = "Selvit� lis�� sukulaisuussuhteita.";
        $text['brother'] = "veli";
        $text['sister'] = "sisar";
        $text['sibling'] = "sisarus";
        $text['uncle'] = "xxx set�";
        $text['aunt'] = "xxx t�ti";
        $text['uncleaunt'] = "xxx set�/t�ti";
        $text['nephew'] = "sisaren/veljenpoika";
        $text['niece'] = "sisaren/veljentyt�r";
        $text['nephnc'] = "xxx sisaren/veljen -tyt�r/poika";
        $text['removed'] = "kertaa poistettu";
        $text['rhusband'] = "mies ";
        $text['rwife'] = "vaimo ";
        $text['rspouse'] = "puoliso ";
        $text['son'] = "poika";
        $text['daughter'] = "tyt�r";
        $text['rchild'] = "lapsi";
        $text['sil'] = "v�vy";
        $text['dil'] = "mini�";
        $text['sdil'] = "mini� tai v�vy";
        $text['gson'] = "xxx pojan/tytt�renpoika";
        $text['gdau'] = "xxx pojan/tytt�rentyt�r";
        $text['gsondau'] = "xxx pojan/tytt�ren poika/tyt�r";
        $text['great'] = "iso";
        $text['spouses'] = "ovat puolisoita";
        $text['is'] = "on";
        $text['changeto'] = "Vaihda henkil�ksi:";
        $text['notvalid'] = "ei ole mahdollinen henkil�n ID-numero tai ei ainakaan ole olemassa t�ss� tietokannassa. Ole hyv� ja yrit� uudestaan.";
        $text['halfbrother'] = "velipuoli";
        $text['halfsister'] = "sisarpuoli";
        $text['halfsibling'] = "sisaruspuoli";
        //changed in 8.0.0
        $text['gencheck'] = "Selvitett�vien<br>sukulaisuussuhteiden maksimim��r�";
        $text['mcousin'] = "xxx serkku yyy";  //male cousin; xxx = cousin number, yyy = times removed
        $text['fcousin'] = "xxx serkku yyy";  //female cousin
        $text['cousin'] = "xxx serkku yyy";
        $text['mhalfcousin'] = "xxx serkkupuoli yyy";  //male cousin
        $text['fhalfcousin'] = "xxx serkkupuoli yyy";  //female cousin
        $text['halfcousin'] = "xxx serkkupuoli yyy";
        //added in 8.0.0
        $text['oneremoved'] = "sukupolven yli";
        $text['gfath'] = "xxx isois�";
        $text['gmoth'] = "xxx iso�iti";
        $text['gpar'] = "xxx isovanhempi";
        $text['mothof'] = "�iti";
        $text['fathof'] = "is�";
        $text['parof'] = "vanhempi";
        $text['maxrels'] = "Suurin n�ytett�vien suhteiden m��r�";
        $text['dospouses'] = "N�yt� suhteet sis�lt�en puolisot";
        $text['rels'] = "Suhteet";
        $text['dospouses2'] = "N�yt� puolisot";
        $text['fil'] = "appi";
        $text['mil'] = "anoppi";
        $text['fmil'] = "appi tai anoppi";
        $text['stepson'] = "velipuoli";
        $text['stepdau'] = "sisarpuoli";
        $text['stepchild'] = "sisar/velipuoli";
        $text['stepgson'] = "xxx pojan/tytt�ren velipuoli";
        $text['stepgdau'] = "xxx pojan/tytt�ren sisarpuoli";
        $text['stepgchild'] = "xxx pojan/tytt�ren veli/sisarpuoli";
        //added in 8.1.1
        $text['ggreat'] = "iso";
        //added in 8.1.2
        $text['ggfath'] = "xxx iso isois�";
        $text['ggmoth'] = "xxx iso iso�iti";
        $text['ggpar'] = "xxx iso isovanhempi";
        $text['ggson'] = "xxx iso pojan/tytt�renpoika";
        $text['ggdau'] = "xxx iso pojan/tytt�rentyt�r";
        $text['ggsondau'] = "xxx iso pojan/tytt�ren poika/tyt�r";
        $text['gstepgson'] = "xxx iso pojan/tytt�ren velipuoli";
        $text['gstepgdau'] = "xxx iso pojan/tytt�ren sisarpuoli";
        $text['gstepgchild'] = "xxx iso pojan/tytt�ren veli/sisarpuoli";
        $text['guncle'] = "xxx iso set�";
        $text['gaunt'] = "xxx iso t�ti";
        $text['guncleaunt'] = "xxx iso set�/t�ti";
        $text['gnephew'] = "xxx iso sisaren/veljenpoika";
        $text['gniece'] = "xxx iso sisaren/veljentyt�r";
        $text['gnephnc'] = "xxx iso sisaren/veljen -tyt�r/poika";
        break;

    case "familygroup":
        $text['familygroupfor'] = "Perhetaulukko:";
        $text['ldsords'] = "LDS-tiedot";
        $text['baptizedlds'] = "Kastettu (LDS)";
        $text['endowedlds'] = "Endaumentti (LDS)";
        $text['sealedplds'] = "Sinet�ity P (LDS)";
        $text['sealedslds'] = "Sinet�ity S (LDS)";
        $text['otherspouse'] = "Toinen puoliso";
        $text['husband'] = "Aviomies";
        $text['wife'] = "Vaimo";
        break;

    //pedigree.php
    case "pedigree":
        $text['capbirthabbr'] = "s";
        $text['capaltbirthabbr'] = "(s)";
        $text['capdeathabbr'] = "k";
        $text['capburialabbr'] = "haud.";
        $text['capplaceabbr'] = "paikka";
        $text['capmarrabbr'] = "vih.";
        $text['capspouseabbr'] = "PUOL";
        $text['redraw'] = "P�ivit�";
        $text['scrollnote'] = "Huomioi: Voit joutua vieritt�m��n sivua alas tai oikealle n�hd�ksesi koko kaavion.";
        $text['unknownlit'] = "Tuntematon";
        $text['popupnote1'] = " = Lis�tietoja";
        $text['popupnote2'] = " = Uusi sukupuu t�st� henkil�st� alkaen";
        $text['pedcompact'] = "Tiivis";
        $text['pedstandard'] = "Vakio";
        $text['pedtextonly'] = "Tekstimuoto";
        $text['descendfor'] = "J�lkel�iset:";
        $text['maxof'] = "N�ytet��n enint��n";
        $text['gensatonce'] = "sukupolvea kerrallaan, ";
        $text['sonof'] = "vanhemmat";
        $text['daughterof'] = "vanhemmat";
        $text['childof'] = "vanhemmat";
        $text['stdformat'] = "Vakiomuoto";
        $text['ahnentafel'] = "Esipolvitaulu";
        $text['addnewfam'] = "Lis�� uusi perhe";
        $text['editfam'] = "Muokkaa perhett�";
        $text['side'] = "Side";
        $text['familyof'] = "Sukutiedot henkil�lle";
        $text['paternal'] = "Is�n suku";
        $text['maternal'] = "�idin suku";
        $text['gen1'] = "Henkil� itse";
        $text['gen2'] = "Vanhemmat";
        $text['gen3'] = "Isovanhemmat";
        $text['gen4'] = "Isovanhempien vanhemmat";
        $text['gen5'] = "Isovanhempien isovanhemmat";
        $text['gen6'] = "6. sukupolvi";
        $text['gen7'] = "7. sukupolvi";
        $text['gen8'] = "8. sukupolvi";
        $text['gen9'] = "9. sukupolvi";
        $text['gen10'] = "10. sukupolvi";
        $text['gen11'] = "11. sukupolvi";
        $text['gen12'] = "12. sukupolvi";
        $text['graphdesc'] = "J�lkipolvikartta t�h�n asti";
        $text['pedbox'] = "Lokero";
        $text['regformat'] = "Rekisterimuoto";
        $text['extrasexpl'] = "Mik�li seuraavilla henkil�ill� on valokuvia tai el�m�kertoja, niiden kuvakkeet n�kyv�t nimen vieress�.";
        $text['popupnote3'] = " = Uusi kaavio";
        $text['mediaavail'] = "Media tarjolla";
        $text['pedigreefor'] = "Sukutaulu:";
        $text['pedigreech'] = "Sukupuu kaavio";
        $text['datesloc'] = "P�iv�m��r�t ja sijainnit";
        $text['borchr'] = "syntym�/Alt - kuolin/hautaus (kaksi)";
        $text['nobd'] = "Ei syntym�- tai kuolinp�ivi�";
        $text['bcdb'] = "syntym�/Alt/kuolin/hautaus (nelj�)";
        $text['numsys'] = "Numerointij�rjestelm�";
        $text['gennums'] = "Sukupolvinumerot";
        $text['henrynums'] = "Henry numerot";
        $text['abovnums'] = "d'Aboville numerot";
        $text['devnums'] = "de Villiers numerot";
        $text['dispopts'] = "N�ytt�asetukset";
        //added in 10.0.0
        $text['no_ancestors'] = "Esi-isi� ei l�ytynyt";
        $text['ancestor_chart'] = "Pystysuora esi-is�kaavio";
        $text['opennewwindow'] = "Avaa uudessa ikkunassa";
        $text['pedvertical'] = "Pystysuora";
        //added in 11.0.0
        $text['familywith'] = "Perhe puolisona";
        $text['fcmlogin'] = "Kirjaudu sis��n n�hd�ksesi yksityiskohdat";
        $text['isthe'] = "on";
        $text['otherspouses'] = "muut puolisot";
        $text['parentfamily'] = "Vanhemman perhe ";
        $text['showfamily'] = "N�yt� perhe";
        $text['shown'] = "n�ytetty";
        $text['showparentfamily'] = "n�yt� vanhemman perhe";
        $text['showperson'] = "n�yt� henkil�";
        //added in 11.0.2
        $text['otherfamilies'] = "Muut perheet";
        break;

    //search.php, searchform.php
    //merged with reports and showreport in 5.0.0
    case "search":
    case "reports":
        $text['noreports'] = "Ei raportteja.";
        $text['reportname'] = "Raportin nimi";
        $text['allreports'] = "Raportit";
        $text['report'] = "Raportti";
        $text['error'] = "Virhe";
        $text['reportsyntax'] = "Raportin";
        $text['wasincorrect'] = "syntaksi oli virheellinen, mink� takia sit� ei voitu koostaa. Ota yhteys palvelun yll�pitoon:";
        $text['errormessage'] = "Virhe";
        $text['equals'] = "on";
        $text['endswith'] = "loppuu";
        $text['soundexof'] = "soundex-haku";
        $text['metaphoneof'] = "metaphone-haku";
        $text['plusminus10'] = "+/- 10 vuotta alkaen";
        $text['lessthan'] = "v�hemm�n kuin";
        $text['greaterthan'] = "enemm�n kuin";
        $text['lessthanequal'] = "v�hemm�n tai yht� kuin";
        $text['greaterthanequal'] = "enemm�n tai yht� kuin";
        $text['equalto'] = "yht� kuin";
        $text['tryagain'] = "Yrit� uudelleen";
        $text['joinwith'] = "Hakuoperaatio";
        $text['cap_and'] = "JA";
        $text['cap_or'] = "TAI";
        $text['showspouse'] = "N�yt� puolisot (mik�li useampi avioliitto)";
        $text['submitquery'] = "Etsi";
        $text['birthplace'] = "Syntym�paikka";
        $text['deathplace'] = "Kuolinpaikka";
        $text['birthdatetr'] = "Syntym�vuosi";
        $text['deathdatetr'] = "Kuolinvuosi";
        $text['plusminus2'] = "+/- 2 vuotta alkaen";
        $text['resetall'] = "Tyhjenn� kent�t";
        $text['showdeath'] = "N�yt� kuolin- ja hautatiedot";
        $text['altbirthplace'] = "Risti�ispaikka";
        $text['altbirthdatetr'] = "Risti�isvuosi";
        $text['burialplace'] = "Hautauspaikka";
        $text['burialdatetr'] = "Hautausvuosi";
        $text['event'] = "Tapahtuma(t)";
        $text['day'] = "P�iv�";
        $text['month'] = "Kuukausi";
        $text['keyword'] = "Avainsana";
        $text['explain'] = "Anna p�iv�m��r�t n�hd�ksesi tapahtumat, tai j�t� kent�t tyhjiksi n�hd�ksesi kaikki.";
        $text['enterdate'] = "Sy�t� ainakin yksi seuraavista avainsanoista: p�iv�, kuukausi, vuosi";
        $text['fullname'] = "Koko nimi";
        $text['birthdate'] = "Syntym�p�iv�";
        $text['altbirthdate'] = "Risti�isp�iv�";
        $text['marrdate'] = "H��p�iv�";
        $text['spouseid'] = "Puolison ID-numero";
        $text['spousename'] = "Puolison nimi";
        $text['deathdate'] = "Kuolinp�iv�";
        $text['burialdate'] = "Hautajaisp�iv�";
        $text['changedate'] = "Viimeisimm�n muutoksen pvm";
        $text['gedcom'] = "Sukupuu";
        $text['baptdate'] = "Kastep�iv� (mormoni)";
        $text['baptplace'] = "Kastepaikka (mormoni)";
        $text['endldate'] = "Endaumentin p�iv� (mormoni)";
        $text['endlplace'] = "Endaumentin paikka (mormoni)";
        $text['ssealdate'] = "Puolison sinet�imisp�iv� (mormoni)";   //Sealed to spouse
        $text['ssealplace'] = "Puolison sinet�imispaikka (mormoni)";
        $text['psealdate'] = "Vanhempien sinet�imisp�iv� (mormoni)";   //Sealed to parents
        $text['psealplace'] = "Vanhempien sinet�imispaikka (mormoni)";
        $text['marrplace'] = "Vihkipaikka";
        $text['spousesurname'] = "Puolison sukunimi";
        $text['spousemore'] = "Jos sy�t�t puolison sukunimi-kentt��n jotain, sinun t�ytyy sy�tt�� jotain v�hint��n yhteen muuhunkin kentt��n.";
        $text['plusminus5'] = "+/- 5 vuotta alkaen";
        $text['exists'] = "on olemassa";
        $text['dnexist'] = "ei ole olemassa";
        $text['divdate'] = "Avioeron p�iv�m��r�";
        $text['divplace'] = "Avioeron paikka";
        $text['otherevents'] = "Muut tapahtumat";
        $text['numresults'] = "Tuloksia per sivu";
        $text['mysphoto'] = "Tunnistamattomat valokuvat";
        $text['mysperson'] = "H�m�r�ksi j��neet henkil�t";
        $text['joinor'] = "'Yhdist� OR:lla' asetusta ei voida k�ytt�� puolison sukunimen kanssa";
        $text['tellus'] = "Kerro, mit� tied�t";
        $text['moreinfo'] = "Lis�tietoja:";
        //added in 8.0.0
        $text['marrdatetr'] = "Vihkivuosi";
        $text['divdatetr'] = "Erovuosi";
        $text['mothername'] = "�idin nimi";
        $text['fathername'] = "is�n nimi";
        $text['filter'] = "suodatin";
        $text['notliving'] = "ei elossa";
        $text['nodayevents'] = "T�m�n kuun tapahtumat, joita ei ole sidottu mihink��n p�iv��n:";
        //added in 9.0.0
        $text['csv'] = "Pilkkueroteltu CSV tiedosto";
        //added in 10.0.0
        $text['confdate'] = "Konfirmaatio aika (LDS)";
        $text['confplace'] = "Konfirmaatio paikka (LDS)";
        $text['initdate'] = "Pesu ja voitelu aika (LDS)";
        $text['initplace'] = "Pesu ja voitelu paikka (LDS)";
        //added in 11.0.0
        $text['marrtype'] = "Avioliiton tyypp";
        $text['searchfor'] = "Etsi";
        $text['searchnote'] = "Huom: T�m� sivu k�ytt�� Google hakua. L�ytyneiden sivujen m��r� on riippuvainen siit�, miss� m��rin Google on pystynyt indeksoimaan sivustoa.";
        break;

    //showlog.php
    case "showlog":
        $text['logfilefor'] = "Tapahtumat:";
        $text['mostrecentactions'] = "viimeisint� tapahtumaa";
        $text['autorefresh'] = "P�ivit� sivu 30 sek. v�lein";
        $text['refreshoff'] = "Ei sivun autom. p�ivityst�";
        break;

    case "headstones":
    case "showphoto":
        $text['cemeteriesheadstones'] = "Hautausmaat ja hautakivet";
        $text['showallhsr'] = "N�yt� kaikki hautakivitiedot";
        $text['in'] = "paikassa";
        $text['showmap'] = "N�yt� kartta";
        $text['headstonefor'] = "Hautakivi:";
        $text['photoof'] = "Valokuva:";
        $text['photoowner'] = "Omistaja/L�hde";
        $text['nocemetery'] = "Ei hautausmaata";
        $text['iptc005'] = "Otsikko";
        $text['iptc020'] = "Lis�kategoriat";
        $text['iptc040'] = "Erityisohjeet";
        $text['iptc055'] = "Luontip�iv�";
        $text['iptc080'] = "Kuvaaja";
        $text['iptc085'] = "Kuvaajan asema";
        $text['iptc090'] = "Kaupunki";
        $text['iptc095'] = "Osavaltio";
        $text['iptc101'] = "Maa";
        $text['iptc103'] = "OTR";
        $text['iptc105'] = "Otsikko";
        $text['iptc110'] = "L�hde";
        $text['iptc115'] = "Valokuvan l�hde";
        $text['iptc116'] = "Tekij�noikeustiedot";
        $text['iptc120'] = "Kuvateksti";
        $text['iptc122'] = "Kuvatekstin kirjoittaja";
        $text['mapof'] = "Kartta:";
        $text['regphotos'] = "Selitysten mukaan";
        $text['gallery'] = "Vain pikkukuvat";
        $text['cemphotos'] = "Hautausmaan kuvat";
        $text['photosize'] = "Kuvan koko";
        $text['iptc010'] = "Arvoj�rjestys";
        $text['filesize'] = "Tiedoston koko";
        $text['seeloc'] = "N�yt� paikka";
        $text['showall'] = "N�yt� kaikki";
        $text['editmedia'] = "Muokkaa aineistoja";
        $text['viewitem'] = "N�yt� t�m� kohta";
        $text['editcem'] = "Muokkaa hautausmaata";
        $text['numitems'] = "# j�sent�";
        $text['allalbums'] = "Kaikki albumit";
        $text['slidestop'] = "Keskeyt� diaesitys";
        $text['slideresume'] = "Jatka diaesityst�";
        $text['slidesecs'] = "Sekuntia per kuva:";
        $text['minussecs'] = "- 0,5 sekuntia";
        $text['plussecs'] = "+ 0,5 sekuntia";
        $text['nocountry'] = "Tuntematon maa";
        $text['nostate'] = "Tuntematon valtio";
        $text['nocounty'] = "Tuntematon l��ni";
        $text['nocity'] = "Tuntematon kaupunki";
        $text['nocemname'] = "Nimet�n hautausmaa";
        $text['editalbum'] = "Muokkaa albumia";
        $text['mediamaptext'] = "<strong>Huom:</strong> Liikuta hiirt� kuvan p��ll� n�hd�ksesi nimet. Klikkaa n�hd�ksesi nime� vastaava sivu.";
        //added in 8.0.0
        $text['allburials'] = "kaikki hautajaiset";
        $text['moreinfo'] = "Lis�tietoja:";
        //added in 9.0.0
        $text['iptc025'] = "Avainsanat";
        $text['iptc092'] = "Alisijainti";
        $text['iptc015'] = "Kategoria";
        $text['iptc065'] = "L�hdeohjelmisto";
        $text['iptc070'] = "Ohjelmaversio";
        break;

    //surnames.php, surnames100.php, surnames-all.php, surnames-oneletter.php
    case "surnames":
    case "places":
        $text['surnamesstarting'] = "N�yt� sukunimet, jotka alkavat kirjaimella";
        $text['showtop'] = "Listaa";
        $text['showallsurnames'] = "N�yt� kaikki sukunimet";
        $text['sortedalpha'] = "aakkosj�rjestyksess�";
        $text['byoccurrence'] = "yleisint� sukunime�";
        $text['firstchars'] = "Alkukirjaimet";
        $text['mainsurnamepage'] = "Sukunimien p��sivu";
        $text['allsurnames'] = "Kaikki sukunimet";
        $text['showmatchingsurnames'] = "Valitse sukunimi listataksesi henkil�t";
        $text['backtotop'] = "Sivun alkuun";
        $text['beginswith'] = "Alkukirjain";
        $text['allbeginningwith'] = "Sukunimet jotka alkavat kirjaimella";
        $text['numoccurrences'] = "lukum��r� suluissa";
        $text['placesstarting'] = "N�yt� paikat, jotka alkavat merkkijonolla";
        $text['showmatchingplaces'] = "Valitse paikka n�ytt��ksesi osumat.";
        $text['totalnames'] = "henkil�iden kokonaism��r�";
        $text['showallplaces'] = "N�yt� suurimmat paikat";
        $text['totalplaces'] = "paikkojen m��r�";
        $text['mainplacepage'] = "Paikkojen p��sivu";
        $text['allplaces'] = "Kaikki paikat";
        $text['placescont'] = "N�yt� kaikki paikat, joissa esiintyy";
        //changed in 8.0.0
        $text['top30'] = "Yleisimm�t xxx sukunime�";
        $text['top30places'] = "Yleisimm�t xxx keskeist� paikkaa";
        //added in 12.0.0
        $text['firstnamelist'] = "Etunimilista";
        $text['firstnamesstarting'] = "N�yt� etunimet, jotka alkavat kirjaimella";
        $text['showallfirstnames'] = "N�yt� kaikki etunimet";
        $text['mainfirstnamepage'] = "Etunimisivu";
        $text['allfirstnames'] = "Kaikki etunimet";
        $text['showmatchingfirstnames'] = "Klikkaa etunime� n�hd�ksesi osumat.";
        $text['allfirstbegwith'] = "Kaikki etunimet alkaen";
        $text['top30first'] = "Yleisimm�t xxx etunime�";
        $text['allothers'] = "Kaikki muut";
        $text['amongall'] = "(kaikista nimist�)";
        $text['justtop'] = "Suosituimmat xxx";
        break;

    //whatsnew.php
    case "whatsnew":
        $text['pastxdays'] = "(xx p�iv�n ajalta)";

        $text['photo'] = "Valokuva";
        $text['history'] = "El�m�kerta/Dokumentti";
        $text['husbid'] = "Miehen ID";
        $text['husbname'] = "Miehen nimi";
        $text['wifeid'] = "Vaimon ID";
        //added in 11.0.0
        $text['wifename'] = "�idin nimi";
        break;

    //timeline.php, timeline2.php
    case "timeline":
        $text['text_delete'] = "Poista";
        $text['addperson'] = "Lis�� henkil�";
        $text['nobirth'] = "Henkil�st� ei ole syntym�tietoja joten h�nt� ei voida lis�t�.";
        $text['event'] = "Tapahtuma(t)";
        $text['chartwidth'] = "Taulukon leveys";
        $text['timelineinstr'] = "Lis�� korkeintaan nelj� henkil�� sy�tt�m�ll� heid�n ID-numeronsa tai k�ytt�m�ll� nimihakua:";
        $text['togglelines'] = "Muuta rivien j�rjestyst�";
        //changed in 9.0.0
        $text['noliving'] = "Elossa olevien henkil�iden lis��minen on sallittu vain kirjautuneille k�ytt�jille.";
        break;

    //browsetrees.php
    //login.php, newacctform.php, addnewacct.php
    case "trees":
    case "login":
        $text['browsealltrees'] = "Sukupuut";
        $text['treename'] = "Sukupuun nimi";
        $text['owner'] = "Omistaja";
        $text['address'] = "Osoite";
        $text['city'] = "Paikkakunta";
        $text['state'] = "L��ni";
        $text['zip'] = "Postinumero";
        $text['country'] = "Maa";
        $text['email'] = "S�hk�posti";
        $text['phone'] = "Puhelinnumero";
        $text['username'] = "K�ytt�j�tunnus";
        $text['password'] = "Salasana";
        $text['loginfailed'] = "Virhe sis��nkirjautumisessa";

        $text['regnewacct'] = "Rekister�idy k�ytt�j�ksi";
        $text['realname'] = "Koko nimi";
        $text['phone'] = "Puhelinnumero";
        $text['email'] = "S�hk�posti";
        $text['address'] = "Osoite";
        $text['acctcomments'] = "Kommentit";
        $text['submit'] = "L�het�";
        $text['leaveblank'] = "(j�t� tyhj�ksi jos haluat rekister�id� uuden sukupuun)";
        $text['required'] = "Pakolliset kent�t";
        $text['enterpassword'] = "Ole hyv� ja t�yt� salasanakentt�.";
        $text['enterusername'] = "Ole hyv� ja t�yt� k�ytt�j�tunnuskentt�.";
        $text['failure'] = "Valitsemasi k�ytt�j�tunnus on jo k�yt�ss�. Palaa edelliselle sivulle ja valitse toinen k�ytt�j�tunnus.";
        $text['success'] = "Kiitos rekister�itymisest�si. Ilmoitamme sinulle kun tunnuksesi on aktivoitu.";
        $text['emailsubject'] = "TNG-rekister�itymispyynt�";
        $text['website'] = "Kotisivu";
        $text['nologin'] = "Puuttuuko sinulta tunnukset?";
        $text['loginsent'] = "Tunnustiedot l�hetetty";
        $text['loginnotsent'] = "Tunnustietoja ei l�htetetty";
        $text['enterrealname'] = "Anna oikea nimesi.";
        $text['rempass'] = "Pysy sis��nkirjautuneen� t�ll� tietokoneella";
        $text['morestats'] = "Lis�� tilastoja";
        $text['accmail'] = "<strong>HUOM:</strong> Varmista, ettei s�hk�postiasetuksissasi ole estetty s�hk�postin vastaanottoa t�lt� verkkotunnukselta. Muuten et voi saada yll�pidon vastausta tunnuspyynt��si.";
        $text['newpassword'] = "Uusi salasana";
        $text['resetpass'] = "Vaihda salasana";
        $text['nousers'] = "T�t� lomaketta ei voi k�ytt�� kunnes j�rjestelm�ss� on v�hint��n yksi tunnus. Jos olet j�rjestelm�n yll�pit�j�, mene Yll�pito-valikon K�ytt�j�t-kohtaan luomaan itsellesi yll�pitotunnus.";
        $text['noregs'] = "Emme ota vastaan uusia k�ytt�j�rekister�intej� t�ll� hetkell�. Ole hyv� ja  <a href=\"suggest.php\">ota yhteytt�</a> suoraan, jos sinulla on kommentteja tai kysymyksi� koskien t�t� sivustoa.";
        //changed in 8.0.0
        $text['emailmsg'] = "Sinulle on saapunut uusi TNG-rekister�itymispyynt�. Kirjaudu sis��n TNG:n hallintaliittym��n ja anna uudelle k�ytt�j�lle sopivat k�ytt�oikeudet. Jos hyv�ksyt rekister�itymisen, ole hyv� ja vastaa t�h�n viestiin ilmoittaaksesi asiasta k�ytt�j�lle.";
        $text['accactive'] = "Tunnus on aktivoitu, mutta k�ytt�j�ll� ei ole erityisoikeuksia ennen kuin annat ne.";
        $text['accinactive'] = "Siirry Yll�pito/K�ytt�j�t/Hyv�ksynt� tarkistamaan tunnus. Tunnus on aktivoimaton kunnes olet muokannut sit� ja tallentanut tiedot v�hint��n kerran.";
        $text['pwdagain'] = "Salasana uudelleen";
        $text['enterpassword2'] = "Anna salasanasi uudelleen.";
        $text['pwdsmatch'] = "Salasanat eiv�t t�sm��. Sy�t� sama salasana kumpaankin kentt��n.";
        //added in 8.0.0
        $text['acksubject'] = "Kiitos rekister�itymisest�si"; //for a new user account
        $text['ackmessage'] = "K�ytt�j�tunnuspyynt�si on vastaanotettu. Tunnuksesi on aktivoimatta kunnes yll�pit�j� tarkistaa sen. Sinulle ilmoitetaan s�hk�postilla, kun tunnuksesi on k�ytett�viss�.";
        //added in 12.0.0
        $text['switch'] = "Vaihda";
        break;

    //added in 10.0.0
    case "branches":
        $text['browseallbranches'] = "Selaa kaikkia haaroja";
        break;

    //statistics.php
    case "stats":
        $text['quantity'] = "Arvo";
        $text['totindividuals'] = "Henkil�it�";
        $text['totmales'] = "Miehi�";
        $text['totfemales'] = "Naisia";
        $text['totunknown'] = "Sukupuoli tuntematon";
        $text['totliving'] = "Elossa";
        $text['totfamilies'] = "Perheit�";
        $text['totuniquesn'] = "Sukunimi�";
        //$text['totphotos'] = "Total Photos";
        //$text['totdocs'] = "Total Histories &amp; Documents";
        //$text['totheadstones'] = "Total Headstones";
        $text['totsources'] = "L�hteit�";
        $text['avglifespan'] = "Keskim��r�inen elinik�";
        $text['earliestbirth'] = "Varhaisin syntym�vuosi";
        $text['longestlived'] = "Pitk�ik�isimm�t henkil�t";
        $text['days'] = "p�iv��";
        $text['age'] = "Ik�";
        $text['agedisclaimer'] = "Ik��n liittyv�t laskelmat perustuvat henkil�ihin joista on tiedossa sek� synnyin- ett� kuolinaika. Puutteellisten aikatietojen (esim. syntym� kirjattu vain \"1945\" tai \"ennen 1860\") takia laskelmat eiv�t ole t�ysin tarkkoja.";
        $text['treedetail'] = "Sukupuun lis�tiedot";
        $text['total'] = "Yhteens�";
        //added in 12.0
        $text['totdeceased'] = "Kuolleita yhteens�";
        break;

    case "notes":
        $text['browseallnotes'] = "Selaa kaikkia muistiinpanoja";
        break;

    case "help":
        $text['menuhelp'] = "Menuavain";
        break;

    case "install":
        $text['perms'] = "Kaikki oikeudet on asetettu.";
        $text['noperms'] = "Oikeuksia ei voitu asettaa n�ille tiedostoille:";
        $text['manual'] = "Aseta ne k�sin.";
        $text['folder'] = "Hakemisto";
        $text['created'] = "on luotu";
        $text['nocreate'] = "ei voitu luoda. Luo se k�sin.";
        $text['infosaved'] = "Tiedot tallennettu, yhteys tarkistettu!";
        $text['tablescr'] = "Taulut luotu!";
        $text['notables'] = "Seuraavia tauluja ei voitu luoda:";
        $text['nocomm'] = "TNG ei saa yhteytt� tietokantaan. Tauluja ei luotu.";
        $text['newdb'] = "Tiedot tallennettu, yhteys tarkistettu, uusi tietokanta luotu:";
        $text['noattach'] = "Tiedot tallennettu. Yhteys ja tietokanta luotu, mutta TNG ei voi k�ytt�� sit�.";
        $text['nodb'] = "Tiedot tallennettu. Yhteys luotu, mutta tietokantaa ei ole tai sit� ei voitu luoda. Tarkista tietokannan nimi tai k�yt� ohjauspaneelia luodaksesi se.";
        $text['noconn'] = "Tiedot tallennettu, mutta yhteys ep�onnistui. Yksi tai useampi seuraavista on v��rin:";
        $text['exists'] = "on olemassa";
        $text['loginfirst'] = "Kirjaudu ensin sis��n.";
        $text['noop'] = "Toimintoa ei suoritettu.";
        //added in 8.0.0
        $text['nouser'] = "K�ytt�j�� ei voitu luoda, sill� k�ytt�j�tunnus saattaa olla jo k�yt�ss�.";
        $text['notree'] = "Sukupuuta ei luotu. Sukupuun ID numero saattaa olla jo olemassa.";
        $text['infosaved2'] = "tieto tallennettu";
        $text['renamedto'] = "nimetty uudelleen";
        $text['norename'] = "ei voitu nimet� uudelleen";
        break;

    case "imgviewer":
        $text['zoomin'] = "Suurenna";
        $text['zoomout'] = "Pienenn�";
        $text['magmode'] = "Suurennus";
        $text['panmode'] = "Panorointi";
        $text['pan'] = "Klikkaa ja raahaa liikkuaksesi kuvan sis�ll�";
        $text['fitwidth'] = "Sovita leveys";
        $text['fitheight'] = "Sovita korkeus";
        $text['newwin'] = "Uusi ikkuna";
        $text['opennw'] = "Avaa kuva uudessa ikkunassa";
        $text['magnifyreg'] = "Klikkaa surentaaksesi kuvan alue";
        $text['imgctrls'] = "Aktivoi kuvatoiminnot";
        $text['vwrctrls'] = "Aktivoi kuvaselaimen toiminnot";
        $text['vwrclose'] = "Sulje kuvaselain";
        break;

    case "dna":
        $text['test_date'] = "Testin p�iv�ys";
        $text['links'] = "Liittyv�t linkit";
        $text['testid'] = "Testin ID";
        //added in 12.0.0
        $text['mode_values'] = "Tila-arvot";
        $text['compareselected'] = "Vertaa valittuja";
        $text['dnatestscompare'] = "Vertaa Y-DNA testej�";
        $text['keep_name_private'] = "Pid� nimi yksityisen�";
        $text['browsealltests'] = "Selaa kaikkia testej�";
        $text['all_dna_tests'] = "Kaikki DNA testit";
        $text['fastmutating'] = "Nopeasti mutatoivat";
        $text['alltypes'] = "Kaikki tyypit";
        $text['allgroups'] = "Kaikki ryhm�t";
        $text['Ydna_LITbox_info'] = "Henkil��n linkitetyt testi(t) eiv�t v�ltt�m�tt� ole henkil�n itsens� suorittamia.<br>'Haploryhm�' sarake n�ytt�� datan punaisella, jos tulos on  'Ennustettu' tai vihre�ll�, jos testi on 'Vahvistettu'";
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
$text['matches'] = "Tulokset";
$text['description'] = "Kuvaus";
$text['notes'] = "Muistiinpanot";
$text['status'] = "Tila";
$text['newsearch'] = "Haku";
$text['pedigree'] = "Sukutaulu";
$text['seephoto'] = "Kts. valokuva";
$text['andlocation'] = "& sijainti";
$text['accessedby'] = "- k�vij�:";
$text['family'] = "Perhe"; //from getperson
$text['children'] = "Lapset";  //from getperson
$text['tree'] = "Sukupuu";
$text['alltrees'] = "Sukupuut";
$text['nosurname'] = "[ei sukunime�]";
$text['thumb'] = "Kuvake";  //as in Thumbnail
$text['people'] = "Henkil�t";
$text['title'] = "Nimike";  //from getperson
$text['suffix'] = "Loppuliite";  //from getperson
$text['nickname'] = "Kutsumanimi";  //from getperson
$text['lastmodified'] = "Muokattu";  //from getperson
$text['married'] = "Vihitty";  //from getperson
//$text['photos'] = "Photos";
$text['name'] = "Nimi"; //from showmap
$text['lastfirst'] = "Sukunimi, Etunimet";  //from search
$text['bornchr'] = "Syntynyt/Kastettu";  //from search
$text['individuals'] = "Henkil�t";  //from whats new
$text['families'] = "Perheet";
$text['personid'] = "Henkil�n ID";
$text['sources'] = "L�hteet";  //from getperson (next several)
$text['unknown'] = "Tuntematon";
$text['father'] = "Is�";
$text['mother'] = "�iti";
$text['christened'] = "Kastettu";
$text['died'] = "Kuollut";
$text['buried'] = "Haudattu";
$text['spouse'] = "Puoliso";  //from search
$text['parents'] = "Vanhemmat";  //from pedigree
$text['text'] = "Teksti";  //from sources
$text['language'] = "Kieli";  //from languages
$text['descendchart'] = "J�lkel�iset";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Henkil�n tiedot";
$text['edit'] = "Muokkaa";
$text['date'] = "P�iv�ys";
$text['place'] = "Paikka";
$text['login'] = "Sis��nkirjautuminen";
$text['logout'] = "Kirjaudu ulos";
$text['groupsheet'] = "Perhetaulukko";
$text['text_and'] = "ja";
$text['generation'] = "Sukupolvi";
$text['filename'] = "Tiedoston nimi";
$text['id'] = "ID";
$text['search'] = "Etsi";
$text['user'] = "K�ytt�j�";
$text['firstname'] = "Etunimi";
$text['lastname'] = "Sukunimi";
$text['searchresults'] = "Haun tulokset";
$text['diedburied'] = "Kuollut/Haudattu";
$text['homepage'] = "Etusivu";
$text['find'] = "Etsi...";
$text['relationship'] = "Sukulaisuus";    //in German, Verwandtschaft
$text['relationship2'] = "Sukulaisuussuhde"; //different in some languages, at least in German (Beziehung)
$text['timeline'] = "Aikajana";
$text['yesabbr'] = "K";               //abbreviation for 'yes'
$text['divorced'] = "Eronnut";
$text['indlinked'] = "Liitetyt henkil�t";
$text['branch'] = "Sukuhaara";
$text['moreind'] = "Lis�� henkil�it�";
$text['morefam'] = "Lis�� perheit�";
$text['source'] = "L�hde";
$text['surnamelist'] = "Sukunimet";
$text['generations'] = "Sukupolvia";
$text['refresh'] = "P�ivit�";
$text['whatsnew'] = "Mit� uutta";
$text['reports'] = "Raportit";
$text['placelist'] = "Paikkaluettelo";
$text['baptizedlds'] = "Kastettu (LDS)";
$text['endowedlds'] = "Endaumentti (LDS)";
$text['sealedplds'] = "Sinet�ity P (LDS)";
$text['sealedslds'] = "Sinet�ity S (LDS)";
$text['ancestors'] = "esi-is�t";
$text['descendants'] = "j�lkel�iset";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Viimeisin GEDCOM-tiedoston tuonti";
$text['type'] = "Tyyppi";
$text['savechanges'] = "Tallenna muutokset";
$text['familyid'] = "Perheen ID";
$text['headstone'] = "Hautakivet";
$text['historiesdocs'] = "El�m�kerrat";
$text['anonymous'] = "nimet�n";
$text['places'] = "Paikat";
$text['anniversaries'] = "Vuosip�iv�t";
$text['administration'] = "Yll�pito";
$text['help'] = "Apua";
//$text['documents'] = "Documents";
$text['year'] = "Vuosi";
$text['all'] = "Kaikki";
$text['repository'] = "Tietovarasto";
$text['address'] = "Osoite";
$text['suggest'] = "Pyynt�";
$text['editevent'] = "Pyyd� muutosta t�h�n tapahtumaan";
$text['findplaces'] = "Etsi kaikki henkil�t, joilla on merkitty tapahtuma t�ll� paikalla";
$text['morelinks'] = "Lis�� linkkej�";
$text['faminfo'] = "Perheen tiedot";
$text['persinfo'] = "Omat tiedot";
$text['srcinfo'] = "L�hteen tiedot";
$text['fact'] = "Fakta";
$text['goto'] = "Valitse sivu";
$text['tngprint'] = "Tulosta";
$text['databasestatistics'] = "Tilastotietoja"; //needed to be shorter to fit on menu
$text['child'] = "Lapsi";  //from familygroup
$text['repoinfo'] = "Tietovaraston tiedot";
$text['tng_reset'] = "Tyhjenn�";
$text['noresults'] = "Hakua vastaavia henkil�it� ei l�ytynyt";
$text['allmedia'] = "Kaikki aineistot";
$text['repositories'] = "Tietovarastot";
$text['albums'] = "Albumit";
$text['cemeteries'] = "Hautausmaat";
$text['surnames'] = "Sukunimet";
$text['dates'] = "P�iv�m��r�t";
$text['link'] = "Linkki";
$text['media'] = "Aineisto";
$text['gender'] = "Sukupuoli";
$text['latitude'] = "Leveysaste";
$text['longitude'] = "Pituusaste";
$text['bookmarks'] = "Kirjanmerkit";
$text['bookmark'] = "Lis�� kirjanmerkki";
$text['mngbookmarks'] = "Muokkaa kirjanmerkkej�";
$text['bookmarked'] = "Kirjanmerkki lis�tty";
$text['remove'] = "Poista";
$text['find_menu'] = "Etsi";
$text['info'] = "Info"; //this needs to be a very short abbreviation
$text['cemetery'] = "Hautausmaa";
$text['gmapevent'] = "Tapahtumakartta";
$text['gevents'] = "Tapahtuma";
$text['glang'] = "&amp;hl=fi";
$text['googleearthlink'] = "Linkkaa Google Earth-palveluun";
$text['googlemaplink'] = "Linkkaa Google Maps-palveluun";
$text['gmaplegend'] = "Nupin selite";
$text['unmarked'] = "Merkitsem�t�n";
$text['located'] = "Sijainti";
$text['albclicksee'] = "Klikkaa n�hd�ksesi kaikki albumin kohteet";
$text['notyetlocated'] = "Ei viel� paikallistettu";
$text['cremated'] = "Tuhkattu";
$text['missing'] = "Puuttu";
$text['pdfgen'] = "PDF tuottaja";
$text['blank'] = "Tyhj� kaavio";
$text['none'] = "Ei mik��n";
$text['fonts'] = "Kirjasimet";
$text['header'] = "Otsikko";
$text['data'] = "Data";
$text['pgsetup'] = "Sivun asetukset";
$text['pgsize'] = "Sivun koko";
$text['orient'] = "Paperin suunta"; //for a page
$text['portrait'] = "Pysty";
$text['landscape'] = "Vaaka";
$text['tmargin'] = "Yl�marginaali";
$text['bmargin'] = "Alamarginaali";
$text['lmargin'] = "Vasen marginaali";
$text['rmargin'] = "Oikea marginaali";
$text['createch'] = "Luo kaavio";
$text['prefix'] = "Etuliite";
$text['mostwanted'] = "Etsityimm�t";
$text['latupdates'] = "Viimeisimm�t p�ivitykset";
$text['featphoto'] = "Erikoiskuvat";
$text['news'] = "Uutiset";
$text['ourhist'] = "Perheemme historia";
$text['ourhistanc'] = "Perheemme historia ja suku";
$text['ourpages'] = "Perheemme sukututkimussivut";
$text['pwrdby'] = "Palvelun toteuttava sovellus";
$text['writby'] = "tekij�";
$text['searchtngnet'] = "Hae TNG verkosta (GENDEX)";
$text['viewphotos'] = "N�yt� kaikki kuvat";
$text['anon'] = "Olet t�ll� hetkell� vierailijana";
$text['whichbranch'] = "Mist� sukuhaarasta olet?";
$text['featarts'] = "Erikoisartikkelit";
$text['maintby'] = "Yll�pit�j�";
$text['createdon'] = "Luotu";
$text['reliability'] = "Luotettavuus";
$text['labels'] = "Nimi�t";
$text['inclsrcs'] = "Ota mukaan l�hteet";
$text['cont'] = "(jatk.)"; //abbreviation for continued
$text['mnuheader'] = "Kotisivu";
$text['mnusearchfornames'] = "Etsi nimi�";
$text['mnulastname'] = "Sukunimi";
$text['mnufirstname'] = "Etunimi";
$text['mnusearch'] = "Etsi";
$text['mnureset'] = "Aloita alusta";
$text['mnulogon'] = "Kirjaudu sis��n";
$text['mnulogout'] = "Kirjaudu ulos";
$text['mnufeatures'] = "Muut ominaisuudet";
$text['mnuregister'] = "Hae k�ytt�j�tunnusta";
$text['mnuadvancedsearch'] = "Tarkennettu haku";
$text['mnulastnames'] = "Sukunimet";
$text['mnustatistics'] = "Tilastot";
$text['mnuphotos'] = "Valokuvat";
$text['mnuhistories'] = "El�m�kerrat";
$text['mnumyancestors'] = "Valokuvat ja el�m�kerrat [Person]in esi-isist�";
$text['mnucemeteries'] = "Hautausmaat";
$text['mnutombstones'] = "Hautakivet";
$text['mnureports'] = "Raportit";
$text['mnusources'] = "L�hteet";
$text['mnuwhatsnew'] = "Mit� uutta";
$text['mnushowlog'] = "Lokitiedot";
$text['mnulanguage'] = "Vaihda kielt�";
$text['mnuadmin'] = "Yll�pito";
$text['welcome'] = "Tervetuloa";
$text['contactus'] = "Ota yhteytt�";
//changed in 8.0.0
$text['born'] = "Syntynyt";
$text['searchnames'] = "Henkil�haku";
//added in 8.0.0
$text['editperson'] = "muokkaa henkil��";
$text['loadmap'] = "lataa kartta";
$text['birth'] = "Syntynyt";
$text['wasborn'] = "syntyi";
$text['startnum'] = "ensimm�inen numero";
$text['searching'] = "hakee";
//moved here in 8.0.0
$text['location'] = "Sijainti";
$text['association'] = "Kytk�s";
$text['collapse'] = "Supista";
$text['expand'] = "Laajenna";
$text['plot'] = "Pohjapiirros";
$text['searchfams'] = "Perhehaku";
//added in 8.0.2
$text['wasmarried'] = "Vihitty";
$text['anddied'] = "Kuollut";
//added in 9.0.0
$text['share'] = "Jaa";
$text['hide'] = "Piilota";
$text['disabled'] = "Tunnuksesi on lukittu. Ole hyv� ja ota yhteytt� sivuston yll�pit�j��n saadaksesi lis�tietoja.";
$text['contactus_long'] = "Jos sinulla on kysymyksi� tai kommentteja koskien t�m�n sivuston sis�lt��, ole hyv� ja <span class=\"emphasis\"><a href=\"suggest.php\">ota yhteytt�</a></span>. Odotamme yhteydenottoasi.";
$text['features'] = "Ominaisuudet";
$text['resources'] = "Resurssit";
$text['latestnews'] = "Viimeisimm�t uutiset";
$text['trees'] = "Sukupuut";
$text['wasburied'] = "was buried";
//moved here in 9.0.0
$text['emailagain'] = "S�hk�posti uudelleen";
$text['enteremail2'] = "Sy�t� s�hk�postiosoitteesi uudelleen.";
$text['emailsmatch'] = "S�hk�postiosoitteet eiv�t t�sm��. Sy�t� sama osoite molempiin kenttiin.";
$text['getdirections'] = "Klikkaa saadaksesi suunnat";
$text['calendar'] = "Kalenteri";
//changed in 9.0.0
$text['directionsto'] = " to the ";
$text['slidestart'] = "Diaesitys";
$text['livingnote'] = "Ainakin yksi el�v� henkil� on linkitetty t�h�n muistiinpanoon - Yksityiskohtaisia tietoja ei n�ytet�.";
$text['livingphoto'] = "Kuvaan liittyy ainakin yksi elossa oleva henkil� - Yksityiskohtia ei n�ytet�.";
$text['waschristened'] = "Kastettu";
//added in 10.0.0
$text['branches'] = "Sukuhaarat";
$text['detail'] = "Yksityiskohta";
$text['moredetail'] = "Lis�� yksityiskohtia";
$text['lessdetail'] = "V�hemm�n yksityiskohtia";
$text['otherevents'] = "Muut tapahtumat";
$text['conflds'] = "Konfirmoitu (LDS)";
$text['initlds'] = "Pesu ja voitelu (LDS)";
$text['wascremated'] = "tuhkattiin";
//moved here in 11.0.0
$text['text_for'] = "haulle";
//added in 11.0.0
$text['searchsite'] = "Hae t�lt� sivustolta";
$text['searchsitemenu'] = "Hae sivustolta";
$text['kmlfile'] = "Lataa .kml tiedosto katsoaksesi t�t� sijaintia Google Earthiss�";
$text['download'] = "Klikkaa ladataksesi";
$text['more'] = "Lis��";
$text['heatmap'] = "Tiheyskartta";
$text['refreshmap'] = "P�ivit� kartta";
$text['remnums'] = "Tyhjenn� numerot ja nastat";
$text['photoshistories'] = "Valokuvat ja Historiat";
$text['familychart'] = "Perhekaavio";
//added in 12.0.0
$text['firstnames'] = "Etunimet";
//moved here in 12.0.0
$text['dna_test'] = "DNA testi";
$text['test_type'] = "Testin tyyppi";
$text['test_info'] = "Testin tiedot";
$text['takenby'] = "Suorittaja";
$text['haplogroup'] = "Haplogroup";
$text['hvr1'] = "HVR1";
$text['hvr2'] = "HVR2";
$text['relevant_links'] = "Relevant links";
$text['nofirstname'] = "[ei etunime�]";
//added in 12.0.1
$text['cookieuse'] = "T�m� sivusto k�ytt�� ev�steit�.";
$text['dataprotect'] = "Tietosuojaseloste";
$text['viewpolicy'] = "N�yt� tietosuojaseloste";
$text['understand'] = "Ymm�rr�n";
$text['consent'] = "Annan suostumukseni tallentaa ker�tyt henkil�tiedot t�lle sivustolle. Ymm�rr�n, ett� voin pyyt�� sivuston yll�pit�j�� poistamaan tietoni pyydett�ess�.";
$text['consentreq'] = "Ole hyv� ja anna suostumuksesi tallentaa henkil�tietoja t�lle sivustolle.";

//added in 12.1.0
$text['testsarelinked'] = "DNA tests are associated with";
$text['testislinked'] = "DNA test is associated with";

//added in 12.2
$text['quicklinks'] = "Pikalinkit";
$text['yourname'] = "Nimesi";
$text['youremail'] = "S�hk�postiosoitteesi";
$text['liketoadd'] = "Kaikki tiedot, jotka haluat lis�t�";
$text['webmastermsg'] = "Verkkovastaavan viesti";
$text['gallery'] = "Katso galleria";
$text['wasborn_male'] = "syntyi";
$text['wasborn_female'] = "syntyi";
$text['waschristened_male'] = "kastettiin";
$text['waschristened_female'] = "kastettiin";
$text['dead_male'] = "kuollut";
$text['dead_female'] = "kuollut";
$text['wasburied_male'] = "haudattiin";
$text['wasburied_female'] = "haudattiin";
$text['wascremated_male'] = "tuhrattiin";
$text['wascremated_female'] = "tuhrattiin";
$text['wasmarried_male'] = "naimisissa";
$text['wasmarried_female'] = "naimisissa";
$text['wasdivorced_male'] = "erotettiin";
$text['wasdivorced_female'] = "erotettiin";
$text['inplace'] = "sis��n";
$text['onthisdate'] = "p��ll�";
$text['inthisyear'] = "sis��n";
$text['and'] = "ja";

//moved here in 12.3
$text['dna_info_head'] = "DNA testi tiedot";
$text['firstpage'] = "Ensimm�inen sivu";
$text['lastpage'] = "Viimeinen sivu";

@include_once "captcha_text.php";
@include_once "alltext.php";
if (!$alltextloaded) getAllTextPath();


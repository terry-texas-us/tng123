<?php
switch ($textpart) {
  //browsesources.php, showsource.php
  case "sources":
    $text['browseallsources'] = "Bl�ddra i k�llor";
    $text['shorttitle'] = "Kort titel";
    $text['callnum'] = "Klassifikation";
    $text['author'] = "F�rfattare";
    $text['publisher'] = "F�rl�ggare";
    $text['other'] = "Annan information";
    $text['sourceid'] = "K�llans ID";
    $text['moresrc'] = "Flera k�llor";
    $text['repoid'] = "Arkivets ID";
    $text['browseallrepos'] = "S�k alla arkiv";
    break;

  //changelanguage.php, savelanguage.php
  case "language":
    $text['newlanguage'] = "Nytt spr�k";
    $text['changelanguage'] = "Byt spr�k";
    $text['languagesaved'] = "Spr�ket har sparats";
    $text['sitemaint'] = "Underh�ll av sajten p�g�r";
    $text['standby'] = "Denna sajt �r tillf�lligt nere pga uppdatering av databasen. F�rs�k igen om n�gra minuter. Om sajten �r nere en l�ngre tid, <a href=\"suggest.php\">kontakta sajtens �gare</a>.";
    break;

  //gedcom.php, gedform.php
  case "gedcom":
    $text['gedstart'] = "GEDCOM startar fr�n";
    $text['producegedfrom'] = "Skapa GEDCOM-fil fr�n";
    $text['numgens'] = "Antal generationer";
    $text['includelds'] = "Inkludera LDS-information";
    $text['buildged'] = "Generera GEDCOM";
    $text['gedstartfrom'] = "GEDCOM startar fr�n";
    $text['nomaxgen'] = "Du m�ste ange maximum antal generationer. Anv�nd bak�tknappen f�r att �terv�nda till f�reg�ende sida och korrigera felet";
    $text['gedcreatedfrom'] = "GEDCOM skapad fr�n";
    $text['gedcreatedfor'] = "skapad f�r";
    $text['creategedfor'] = "Skapa GEDCOM";
    $text['email'] = "E-postadress";
    $text['suggestchange'] = "F�resl� f�r�ndring";
    $text['yourname'] = "Ditt namn";
    $text['comments'] = "Anteckningar och kommentarer";
    $text['comments2'] = "Kommentarer";
    $text['submitsugg'] = "Skicka f�rslaget";
    $text['proposed'] = "F�reslagen f�r�ndring";
    $text['mailsent'] = "Tack. Ditt meddelande har skickats.";
    $text['mailnotsent'] = "Vi beklagar att ditt meddelande inte kunnat skickats. Kontakta xxx direkt p� yyy.";
    $text['mailme'] = "Skicka en kopia till denna adress";
    $text['entername'] = "Skriv in ditt namn";
    $text['entercomments'] = "Skriv in dina kommentarer";
    $text['sendmsg'] = "S�nd meddelandet";
    //added in 9.0.0
    $text['subject'] = "�mne";
    break;

  //getextras.php, getperson.php
  case "getperson":
    $text['photoshistoriesfor'] = "Foton & text-dokument f�r";
    $text['indinfofor'] = "Individuell information f�r";
    $text['pp'] = "sid."; //page abbreviation
    $text['age'] = "�lder";
    $text['agency'] = "Firma";
    $text['cause'] = "Orsak";
    $text['suggested'] = "F�reslagen";
    $text['closewindow'] = "St�ng detta f�nster";
    $text['thanks'] = "Tack";
    $text['received'] = "Ditt f�rslag har skickats till sajtens administrat�r f�r behandling.";
    $text['indreport'] = "Individrapport";
    $text['indreportfor'] = "Individrapport f�r";
    $text['general'] = "Allm�nt";
    $text['bkmkvis'] = "<strong>OBS:</strong> Dessa bokm�rken syns bara p� denna dator och i denna webl�sare.";
    //added in 9.0.0
    $text['reviewmsg'] = "Du har ett �ndringsf�rslag att kontrollera. �ndringen g�ller:";
    $text['revsubject'] = "Ett �ndringsf�rslag beh�ver kontrolleras";
    break;

  //relateform.php, relationship.php, findpersonform.php, findperson.php
  case "relate":
    $text['relcalc'] = "Sl�ktskapsber�kning";
    $text['findrel'] = "Ber�kna sl�ktskap";
    $text['person1'] = "Person 1:";
    $text['person2'] = "Person 2:";
    $text['calculate'] = "Ber�kna";
    $text['select2inds'] = "V�lj tv� individer.";
    $text['findpersonid'] = "S�k person-ID";
    $text['enternamepart'] = "mata in del av f�r- och/eller efternamn";
    $text['pleasenamepart'] = "Mata in en del av ett f�r- eller efternamn.";
    $text['clicktoselect'] = "klicka f�r val";
    $text['nobirthinfo'] = "Ingen f�delseinformation";
    $text['relateto'] = "Sl�ktskap med";
    $text['sameperson'] = "De tv� individerna �r en och samma person.";
    $text['notrelated'] = "De tv� individerna �r inte besl�ktade inom de xxx n�rmaste generationerna."; //xxx will be replaced with number of generations
    $text['findrelinstr'] = "Skriv in ID f�r tv� individer, eller beh�ll de visade personerna, klicka sedan p� 'Ber�kna' f�r att visa deras sl�ktskap.";
    $text['sometimes'] = "(Ibland f�r man olika resultat om man s�ker �ver olika antal generationer.)";
    $text['findanother'] = "Hitta ett annat sl�kskap";
    $text['brother'] = "bror till";
    $text['sister'] = "syster till";
    $text['sibling'] = "syskon till";
    $text['uncle'] = "xxx farbror/morbror till";
    $text['aunt'] = "xxx faster/moster till";
    $text['uncleaunt'] = "xxx farbror/morbror eller faster/moster till";
    $text['nephew'] = "xxx bror-/systerson till";
    $text['niece'] = "xxx bror-/systerdotter till";
    $text['nephnc'] = "xxx brors-/systersbarn till";
    $text['removed'] = "g�nger borttagna";
    $text['rhusband'] = "make till ";
    $text['rwife'] = "maka till ";
    $text['rspouse'] = "make/make till ";
    $text['son'] = "son till";
    $text['daughter'] = "dotter till";
    $text['rchild'] = "barn till";
    $text['sil'] = "sv�rson till";
    $text['dil'] = "sv�rdotter till";
    $text['sdil'] = "sv�rson/-dotter till";
    $text['gson'] = "xxx son-/dotterson till";
    $text['gdau'] = "xxx son-/dotterdotter till";
    $text['gsondau'] = "xxx barnbarn till";
    $text['great'] = "far/mor";
    $text['spouses'] = "�r makar";
    $text['is'] = "�r";
    $text['changeto'] = "�ndra till:";
    $text['notvalid'] = "�r inte ett giltigt person-ID eller finns inte i denna databas. F�rs�k igen!";
    $text['halfbrother'] = "halvbror till";
    $text['halfsister'] = "halvsyster till";
    $text['halfsibling'] = "halvsyskon till";
    //changed in 8.0.0
    $text['gencheck'] = "Max generationer<br />att kontrollera";
    $text['mcousin'] = "xxx kusin yyy till";  //male cousin; xxx = cousin number, yyy = times removed
    $text['fcousin'] = "xxx kusin yyy till";  //female cousin
    $text['cousin'] = "xxx kusin yyy till";
    $text['mhalfcousin'] = "xxx halvkusin yyy till";  //male cousin
    $text['fhalfcousin'] = " xxx halvkusin yyy till ";  //female cousin
    $text['halfcousin'] = " xxx halvkusin yyy till ";
    //added in 8.0.0
    $text['oneremoved'] = "en g�ng borttagen";
    $text['gfath'] = "xxx far-/morfar till";
    $text['gmoth'] = "xxx far-/mormor till";
    $text['gpar'] = "xxx far-/morf�r�lder till";
    $text['mothof'] = "moder till";
    $text['fathof'] = "fader till";
    $text['parof'] = "f�r�lder till";
    $text['maxrels'] = "Maximalt antal relationer att visa";
    $text['dospouses'] = "Visa relationer som innefattar en make/maka";
    $text['rels'] = "Relationer";
    $text['dospouses2'] = "Visa Makar";
    $text['fil'] = "sv�rfader till";
    $text['mil'] = "sv�rmoder till";
    $text['fmil'] = "sv�rf�r�lder till";
    $text['stepson'] = "styvson till";
    $text['stepdau'] = "styvdotter till";
    $text['stepchild'] = "styvbarn till";
    $text['stepgson'] = "xxx barns styvson till";
    $text['stepgdau'] = "xxx barns styvdotter till";
    $text['stepgchild'] = "xxx barns styvbarn till";
    //added in 8.1.1
    $text['ggreat'] = "far/mor (eng. great)";
    //added in 8.1.2
    $text['ggfath'] = "xxx far-/morf�r�ldrars far till";
    $text['ggmoth'] = "xxx far-/morf�r�ldrars mor till";
    $text['ggpar'] = "xxx far-/morf�r�ldrars f�r�ldrar till";
    $text['ggson'] = "xxx barnbarns son till";
    $text['ggdau'] = "xxx barnbarns dotter till";
    $text['ggsondau'] = "xxx barnbarns barn till";
    $text['gstepgson'] = "xxx barnbarns styvson till";
    $text['gstepgdau'] = "xxx barnbarns styvdotter till";
    $text['gstepgchild'] = "xxx barnbarns styvbarn till";
    $text['guncle'] = "xxx far-/morf�r�ldrars far-/morbror till";
    $text['gaunt'] = "xxx far-/morf�r�ldrars fas-/moster till";
    $text['guncleaunt'] = "xxx far-/morf�r�ldrars far-/morbror eller fas-/moster till";
    $text['gnephew'] = "xxx syskonbarns son till";
    $text['gniece'] = "xxx syskonbarns dotter till";
    $text['gnephnc'] = "xxx syskonbarns barn till";
    break;

  case "familygroup":
    $text['familygroupfor'] = "Familje�versikt f�r";
    $text['ldsords'] = "LDS f�rr�ttningar";
    $text['baptizedlds'] = "D�pt (LDS)";
    $text['endowedlds'] = "Beg�vad (LDS)";
    $text['sealedplds'] = "Beseglad F (LDS)";
    $text['sealedslds'] = "Beseglad M (LDS)";
    $text['otherspouse'] = "Annan make/maka";
    $text['husband'] = "Make";
    $text['wife'] = "Maka";
    break;

  //pedigree.php
  case "pedigree":
    $text['capbirthabbr'] = "F";
    $text['capaltbirthabbr'] = "F";
    $text['capdeathabbr'] = "D";
    $text['capburialabbr'] = "B";
    $text['capplaceabbr'] = "P";
    $text['capmarrabbr'] = "V";
    $text['capspouseabbr'] = "M";
    $text['redraw'] = "Rita om med";
    $text['scrollnote'] = "OBS! Du m�ste kanske bl�ddra ned�t eller till h�ger f�r att se diagrammet.";
    $text['unknownlit'] = "Ok�nd";
    $text['popupnote1'] = " = Ytterligare information";
    $text['popupnote2'] = " = Ny antavla";
    $text['pedcompact'] = "Kompakt";
    $text['pedstandard'] = "Standard";
    $text['pedtextonly'] = "Endast text";
    $text['descendfor'] = "�ttlingar till";
    $text['maxof'] = "Maximum";
    $text['gensatonce'] = "generationer visas samtidigt.";
    $text['sonof'] = "son till";
    $text['daughterof'] = "dotter till";
    $text['childof'] = "barn till";
    $text['stdformat'] = "Standardformat";
    $text['ahnentafel'] = "Listad antavla";
    $text['addnewfam'] = "L�gg till familj";
    $text['editfam'] = "Redigera familj";
    $text['side'] = "-sidan";
    $text['familyof'] = "Sl�kt till";
    $text['paternal'] = "P� f�dernet";
    $text['maternal'] = "P� m�dernet";
    $text['gen1'] = "Sj�lv";
    $text['gen2'] = "F�r�ldrar";
    $text['gen3'] = "Far/morf�r�ldrar";
    $text['gen4'] = "4:e generationen";
    $text['gen5'] = "5:e generationen";
    $text['gen6'] = "6:e generationen";
    $text['gen7'] = "7:e generationen";
    $text['gen8'] = "8:e generationen";
    $text['gen9'] = "9:e generationen";
    $text['gen10'] = "10:e generationen";
    $text['gen11'] = "11:e generationen";
    $text['gen12'] = "12:e generationen";
    $text['graphdesc'] = "Grafiskt �ttlingaverk till denna punkt";
    $text['pedbox'] = "Ruta";
    $text['regformat'] = "Registerformat";
    $text['extrasexpl'] = "Om foton eller dokument finns f�r f�ljande personer visas motsvarande symboler intill namnen.";
    $text['popupnote3'] = " = Nytt diagram";
    $text['mediaavail'] = "Media finns";
    $text['pedigreefor'] = "Antavla f�r";
    $text['pedigreech'] = "Antavla";
    $text['datesloc'] = "Datum och Platser";
    $text['borchr'] = "F�delse/Dop - D�d/Begravning (tv�)";
    $text['nobd'] = "Inga f�delse- eller d�dsdatum";
    $text['bcdb'] = "F�delse/Dop/D�d/Begravning (fyra)";
    $text['numsys'] = "Numreringssystem";
    $text['gennums'] = "Generationsnummer";
    $text['henrynums'] = "Henry-nummer";
    $text['abovnums'] = "d'Aboville-nummer";
    $text['devnums'] = "de Villiers-nummer";
    $text['dispopts'] = "Visa alternativ";
    //added in 10.0.0
    $text['no_ancestors'] = "Inga anor funna";
    $text['ancestor_chart'] = "Vertical antavla";
    $text['opennewwindow'] = "�ppna i nytt f�nster";
    $text['pedvertical'] = "Vertikal";
    //added in 11.0.0
    $text['familywith'] = "Familj med";
    $text['fcmlogin'] = "Logga in f�r att se detaljer ";
    $text['isthe'] = "�r";
    $text['otherspouses'] = "andra makar/makor";
    $text['parentfamily'] = "F�r�lderns familj ";
    $text['showfamily'] = "Visa familj";
    $text['shown'] = "visad";
    $text['showparentfamily'] = "visa f�r�lders familj";
    $text['showperson'] = "visa person";
    //added in 11.0.2
    $text['otherfamilies'] = "Andra familjer";
    break;

  //search.php, searchform.php
  //merged with reports and showreport in 5.0.0
  case "search":
  case "reports":
    $text['noreports'] = "Det finns inga rapporter.";
    $text['reportname'] = "Rapportnamn";
    $text['allreports'] = "Rapporter";
    $text['report'] = "Rapport";
    $text['error'] = "Fel";
    $text['reportsyntax'] = "Denna rapports s�k-syntax";
    $text['wasincorrect'] = "var ej korrekt, och rapporten kunde d�rf�r inte skapas. Kontakta systemadministrat�ren p�";
    $text['errormessage'] = "Felmeddelande";
    $text['equals'] = "lika med";
    $text['endswith'] = "slutar med";
    $text['soundexof'] = "soundex av";
    $text['metaphoneof'] = "metaphone av";
    $text['plusminus10'] = "�10 �r fr�n";
    $text['lessthan'] = "mindre �n";
    $text['greaterthan'] = "st�rre �n";
    $text['lessthanequal'] = "mindre �n eller lika med";
    $text['greaterthanequal'] = "st�rre �n eller lika med";
    $text['equalto'] = "lika med";
    $text['tryagain'] = "F�rs�k igen";
    $text['joinwith'] = "Sammanfoga med";
    $text['cap_and'] = "OCH";
    $text['cap_or'] = "ELLER";
    $text['showspouse'] = "Visa make/maka (visar flera om individen har mer �n en make/maka)";
    $text['submitquery'] = "S�k";
    $text['birthplace'] = "F�delseort";
    $text['deathplace'] = "D�dsort";
    $text['birthdatetr'] = "F�delse�r";
    $text['deathdatetr'] = "D�ds�r";
    $text['plusminus2'] = "�2 �r fr�n";
    $text['resetall'] = "�terst�ll alla v�rden";
    $text['showdeath'] = "Visa information om d�d/begravning";
    $text['altbirthplace'] = "Dopplats";
    $text['altbirthdatetr'] = "Dop�r";
    $text['burialplace'] = "Begravningsplats";
    $text['burialdatetr'] = "Begravnings�r";
    $text['event'] = "H�ndelse(r)";
    $text['day'] = "Dag";
    $text['month'] = "M�nad";
    $text['keyword'] = "Nyckelord (t ex \"CA\")";
    $text['explain'] = "Skriv in datumf�lt f�r att se motsvarande h�ndelser. L�mna f�ltet tomt f�r att se alla h�ndelser.";
    $text['enterdate'] = "Skriv in eller v�lj minst en av f�ljande: Dag, M�nad, �r, Nyckelord";
    $text['fullname'] = "Fullst�ndigt namn";
    $text['birthdate'] = "F�delsedag";
    $text['altbirthdate'] = "Dopdag";
    $text['marrdate'] = "Br�llopsdag";
    $text['spouseid'] = "Make/maka ID";
    $text['spousename'] = "Makes/makas namn";
    $text['deathdate'] = "D�dsdag";
    $text['burialdate'] = "Begravningsdag";
    $text['changedate'] = "Senast �ndrad, datum";
    $text['gedcom'] = "Tr�d";
    $text['baptdate'] = "Dopdag (LDS)";
    $text['baptplace'] = "Dopplats (LDS)";
    $text['endldate'] = "Beg�vningsdag (LDS)";
    $text['endlplace'] = "Beg�vningsplats (LDS)";
    $text['ssealdate'] = "Beseglingsdag S (LDS)";   //Sealed to spouse
    $text['ssealplace'] = "Beseglingsplats S (LDS)";
    $text['psealdate'] = "Beseglingsdag P (LDS)";   //Sealed to parents
    $text['psealplace'] = "Beseglingsplats P (LDS)";
    $text['marrplace'] = "Vigselort";
    $text['spousesurname'] = "Makes/makas efternamn";
    $text['spousemore'] = "Om du skriver in makes/makas efternamn, s� m�ste du fylla i ytterligare minst ett f�lt.";
    $text['plusminus5'] = "�5 �r fr�n";
    $text['exists'] = "finns";
    $text['dnexist'] = "finns inte";
    $text['divdate'] = "Skilsm�ssodatum";
    $text['divplace'] = "Skilsm�ssoplats";
    $text['otherevents'] = "Andra H�ndelser";
    $text['numresults'] = "Resultat per sida";
    $text['mysphoto'] = "G�tfulla foton";
    $text['mysperson'] = "Sv�rf�ngade personer";
    $text['joinor'] = "Alternativet 'Sammanfoga med ELLER' kan inte anv�ndas med makes/makas efternamn";
    $text['tellus'] = "Ber�tta vad du vet";
    $text['moreinfo'] = "Mera information:";
    //added in 8.0.0
    $text['marrdatetr'] = "Vigsel�r";
    $text['divdatetr'] = "Skilsm�sso�r";
    $text['mothername'] = "Moderns Namn";
    $text['fathername'] = "Faderns Namn";
    $text['filter'] = "Filter";
    $text['notliving'] = "Inte Levande";
    $text['nodayevents'] = "H�ndelser denna m�nad som inte �r f�rknippade med en viss dag:";
    //added in 9.0.0
    $text['csv'] = "Kommaseparerad CSV-fil";
    //added in 10.0.0
    $text['confdate'] = "Confirmation Date (LDS)";
    $text['confplace'] = "Confirmation Place (LDS)";
    $text['initdate'] = "Initiatory Date (LDS)";
    $text['initplace'] = "Initiatory Place (LDS)";
    //added in 11.0.0
    $text['marrtype'] = "Vigseltyp";
    $text['searchfor'] = "S�k efter";
    $text['searchnote'] = "OBS: Denna sida anv�nder Google f�r sin s�kning. Antal tr�ffar beror p� hur Google lyckats indexera sajten.";
    break;

  //showlog.php
  case "showlog":
    $text['logfilefor'] = "Logg-fil f�r";
    $text['mostrecentactions'] = "Senaste �tg�rder";
    $text['autorefresh'] = "Auto-uppdatering (30 sekunder)";
    $text['refreshoff'] = "St�ng av Auto-uppdatering";
    break;

  case "headstones":
  case "showphoto":
    $text['cemeteriesheadstones'] = "Begravningsplatser och gravstenar";
    $text['showallhsr'] = "Visa alla gravstenar";
    $text['in'] = "i";
    $text['showmap'] = "Visa karta";
    $text['headstonefor'] = "Gravsten f�r";
    $text['photoof'] = "Foto av";
    $text['photoowner'] = "�gare/K�lla";
    $text['nocemetery'] = "Ingen begravningsplats";
    $text['iptc005'] = "Titel";
    $text['iptc020'] = "Till�ggskategorier";
    $text['iptc040'] = "Specialinstruktioner";
    $text['iptc055'] = "Skapat";
    $text['iptc080'] = "F�rfattare";
    $text['iptc085'] = "F�rfattarens position";
    $text['iptc090'] = "Stad";
    $text['iptc095'] = "Stat";
    $text['iptc101'] = "Land";
    $text['iptc103'] = "OTR";
    $text['iptc105'] = "Rubrik";
    $text['iptc110'] = "K�lla";
    $text['iptc115'] = "Fotografiets k�lla";
    $text['iptc116'] = "Upphovsmannar�tten";
    $text['iptc120'] = "Bildtext";
    $text['iptc122'] = "Biltextens f�rfattare";
    $text['mapof'] = "Karta �ver";
    $text['regphotos'] = "Beskrivande �versikt";
    $text['gallery'] = "Endast frim�rksbilder";
    $text['cemphotos'] = "Begravningsplatsfoton";
    $text['photosize'] = "Storlek";
    $text['iptc010'] = "Prioritet";
    $text['filesize'] = "Filstorlek";
    $text['seeloc'] = "Se Plats";
    $text['showall'] = "Visa alla";
    $text['editmedia'] = "Redigera Media";
    $text['viewitem'] = "Se denna post";
    $text['editcem'] = "Redigera begravningsplats";
    $text['numitems'] = "# Poster";
    $text['allalbums'] = "Alla Album";
    $text['slidestop'] = "Pausa Bildspel";
    $text['slideresume'] = "�teruppta Bildspel";
    $text['slidesecs'] = "Sekunder per bild:";
    $text['minussecs'] = "minus 0.5 sekunder";
    $text['plussecs'] = "plus 0.5 sekunder";
    $text['nocountry'] = "Ok�nt land";
    $text['nostate'] = "Ok�nd stat";
    $text['nocounty'] = "Ok�nt l�n";
    $text['nocity'] = "Ok�nd stad";
    $text['nocemname'] = "Ok�nd begravningsplats";
    $text['editalbum'] = "Redigera Album";
    $text['mediamaptext'] = "<strong>OBS:</strong> Flytta muspekaren �ver bilden f�r att visa namn. Klicka f�r att se en sida f�r varje namn.";
    //added in 8.0.0
    $text['allburials'] = "Alla Begravningar";
    $text['moreinfo'] = "Mera information:";
    //added in 9.0.0
    $text['iptc025'] = "Nyckelord";
    $text['iptc092'] = "Plats";
    $text['iptc015'] = "Kategori";
    $text['iptc065'] = "Ursprungligt Program";
    $text['iptc070'] = "Programversion";
    break;

  //surnames.php, surnames100.php, surnames-all.php, surnames-oneletter.php
  case "surnames":
  case "places":
    $text['surnamesstarting'] = "Visa efternamn som b�rjar med";
    $text['showtop'] = "Visa de f�rsta";
    $text['showallsurnames'] = "Visa alla efternamn";
    $text['sortedalpha'] = "sorterade alfabetiskt";
    $text['byoccurrence'] = "sorterade efter f�rekomst";
    $text['firstchars'] = "F�rsta bokstav";
    $text['mainsurnamepage'] = "Huvudsida f�r efternamn";
    $text['allsurnames'] = "Alla efternamn";
    $text['showmatchingsurnames'] = "Klicka p� ett efternamn f�r att visa motsvarande poster.";
    $text['backtotop'] = "Tillbaka till b�rjan";
    $text['beginswith'] = "B�rjar med";
    $text['allbeginningwith'] = "Alla efternamn som b�rjar med";
    $text['numoccurrences'] = "Antal f�rekomster inom parentes";
    $text['placesstarting'] = "Visa platser som b�rjar p�";
    $text['showmatchingplaces'] = "Klicka p� ett ortnamn f�r att visa mindre orter. Klicka p� s�ksymbolen f�r att visa matchande personer.";
    $text['totalnames'] = "alla individer";
    $text['showallplaces'] = "Visa alla st�rsta platser";
    $text['totalplaces'] = "alla platser";
    $text['mainplacepage'] = "Huvudsida f�r platser";
    $text['allplaces'] = "Alla st�rsta platser";
    $text['placescont'] = "Visa alla platser som inneh�ller";
    //changed in 8.0.0
    $text['top30'] = "Topp-xxx efternamn";
    $text['top30places'] = "Topp-xxx platser";
    //added in 12.0.0
    $text['firstnamelist'] = "F�rnamnslista";
    $text['firstnamesstarting'] = "Visa f�rnamn som b�rjar med";
    $text['showallfirstnames'] = "Visa alla f�rnamn";
    $text['mainfirstnamepage'] = "Huvudsida f�r f�rnamn";
    $text['allfirstnames'] = "Alla f�rnamn";
    $text['showmatchingfirstnames'] = "Klicka p� ett f�rnamn f�r att visa alla tr�ffar.";
    $text['allfirstbegwith'] = "Alla f�rnamn som b�rjar med";
    $text['top30first'] = "De xxx vanligaste f�rnamnen";
    $text['allothers'] = "Alla andra";
    $text['amongall'] = "(bland alla namn)";
    $text['justtop'] = "Bara de xxx vanligaste";
    break;

  //whatsnew.php
  case "whatsnew":
    $text['pastxdays'] = "(senaste xx dagarna)";

    $text['photo'] = "Foto";
    $text['history'] = "Text-dokument";
    $text['husbid'] = "Makens ID";
    $text['husbname'] = "Makens namn";
    $text['wifeid'] = "Makans ID";
    //added in 11.0.0
    $text['wifename'] = "Hustruns Namn";
    break;

  //timeline.php, timeline2.php
  case "timeline":
    $text['text_delete'] = "Stryk";
    $text['addperson'] = "L�gg till person";
    $text['nobirth'] = "F�ljande individ har inte korrekt f�delsedatum och kunde inte l�ggas till";
    $text['event'] = "H�ndelse(r)";
    $text['chartwidth'] = "Diagrambredd";
    $text['timelineinstr'] = "L�gg till ytterligare upp till fyra individer genom att mata in deras ID:";
    $text['togglelines'] = "Visa/d�lj linjer";
    //changed in 9.0.0
    $text['noliving'] = "F�ljande individer �r m�rkta s�som levande och kunde inte l�ggas till p.g.a. att du inte �r inloggad med tillr�ckliga r�ttigheter";
    break;

  //browsetrees.php
  //login.php, newacctform.php, addnewacct.php
  case "trees":
  case "login":
    $text['browsealltrees'] = "Bl�ddra i tr�d";
    $text['treename'] = "Tr�dets namn";
    $text['owner'] = "�gare";
    $text['address'] = "Adress";
    $text['city'] = "Ort";
    $text['state'] = "L�n/Provins/Delstat";
    $text['zip'] = "Postnummer";
    $text['country'] = "Land";
    $text['email'] = "E-postadress";
    $text['phone'] = "Telefon";
    $text['username'] = "Anv�ndarnamn";
    $text['password'] = "L�senord";
    $text['loginfailed'] = "Inloggningen misslyckades.";

    $text['regnewacct'] = "Registrera anv�ndarkonto";
    $text['realname'] = "Ditt verkliga namn";
    $text['phone'] = "Telefon";
    $text['email'] = "E-postadress";
    $text['address'] = "Adress";
    $text['acctcomments'] = "Anteckningar och kommentarer";
    $text['submit'] = "S�nd bidrag";
    $text['leaveblank'] = "(l�mna tomt om du �nskar en ny tr�dstruktur)";
    $text['required'] = "Obligatoriska f�lt";
    $text['enterpassword'] = "skriv in ett l�senord.";
    $text['enterusername'] = "Skriv in ett anv�ndarnamn.";
    $text['failure'] = "Tyv�rr �r anv�ndarnamnet i bruk. Anv�nd bak�t-knappen i din bl�ddrare och v�lj ett annat anv�ndarnamn.";
    $text['success'] = "Tack! Vi har emottagit din registrering. Vi kontaktar dig n�r kontot �r aktivt eller om ytterligare information beh�vs.";
    $text['emailsubject'] = "Ny TNG anv�ndarregistrering";
    $text['website'] = "Websajt";
    $text['nologin'] = "Har du ingen inlogging?";
    $text['loginsent'] = "Inloggningsinformationen har skickats";
    $text['loginnotsent'] = "Inloggningsinformationen har inte skickats";
    $text['enterrealname'] = "Skriv in ditt namn.";
    $text['rempass'] = "F�rbli inloggad p� denna dator";
    $text['morestats'] = "Mera statistik";
    $text['accmail'] = "<strong>OBS:</strong> F�r att f� e-post fr�n administrat�ren ang�ende ditt konto, se till att du inte blockerar e-post fr�n denna dom�n!";
    $text['newpassword'] = "Nytt l�senord";
    $text['resetpass'] = "�terst�ll ditt l�senord";
    $text['nousers'] = "Detta formul�r kan inte anv�ndas f�rr�n minst en anv�ndarregistrering gjorts. Om Du �ger denna sajt, g� till Admin/Anv�ndare och skapa Administrator-konto.";
    $text['noregs'] = "Vi tar f�r tillf�llet inte emot nya anv�ndarregistreringar. <a href=\"suggest.php\">Kontakta oss</a> direkt om du har kommentarer eller fr�gor om n�got p� denna sajt.";
    //changed in 8.0.0
    $text['emailmsg'] = "Du har f�tt en beg�ran om ett nytt TNG konto. Logga in p� ditt TNG admin-omr�de f�r att ge r�tta befogengenheter f�r kontot. Om du godk�nner registreringen, meddela personen i fr�ga genom att svara p� denna e-post.";
    $text['accactive'] = "Kontot har aktiverats, men anv�ndaren kommer inte att ha n�gra s�rskilda r�ttigheter f�rr�n du tilldelat dessa.";
    $text['accinactive'] = "G� till Admin/Anv�ndare/Granska f�r att komma �t kontoinst�llningar. Kontot f�rblir inaktivt tills du redigerar och sparar posten minst en g�ng.";
    $text['pwdagain'] = "L�senordet igen";
    $text['enterpassword2'] = "Ange ditt l�senord igen.";
    $text['pwdsmatch'] = "Ditt l�senord st�mmer inte �verens. Ange samma l�senord i b�da f�lten.";
    //added in 8.0.0
    $text['acksubject'] = "Tack f�r att du registrerat dig"; //for a new user account
    $text['ackmessage'] = "Din ans�kan om anv�ndarkonto har tagits emot. Ditt konto kommer att vara inaktivt tills det har granskats av administrat�ren. Du kommer att meddelas via e-post n�r din inloggning �r klar f�r anv�ndning.";
    //added in 12.0.0
    $text['switch'] = "Byt";
    break;

  //added in 10.0.0
  case "branches":
    $text['browseallbranches'] = "Bl�ddra i alla Grenar";
    break;

  //statistics.php
  case "stats":
    $text['quantity'] = "Kvantitet";
    $text['totindividuals'] = "Totalt antal individer";
    $text['totmales'] = "- varav manliga";
    $text['totfemales'] = "- varav kvinnliga";
    $text['totunknown'] = "- varav av ok�nt k�n";
    $text['totliving'] = "- varav levande";
    $text['totfamilies'] = "Antal familjer";
    $text['totuniquesn'] = "Antal unika efternamn";
    //$text['totphotos'] = "Total Photos";
    //$text['totdocs'] = "Total Histories &amp; Documents";
    //$text['totheadstones'] = "Total Headstones";
    $text['totsources'] = "Totalt antal k�llor";
    $text['avglifespan'] = "Medellivsl�ngd";
    $text['earliestbirth'] = "Tidigaste f�delse";
    $text['longestlived'] = "St�rsta livsl�ngd";
    $text['days'] = "dagar";
    $text['age'] = "�lder";
    $text['agedisclaimer'] = "�ldersber�kningarna baserar sig p� individer med registrerade f�delse- <EM>och</EM> d�dsdatum. P.g.a att det kan finnas ofullst�ndiga datumf�lt (t ex enbart \"1945\" eller \"BEF 1860\"), �r dessa ber�kingar inte helt tillf�rlitliga.";
    $text['treedetail'] = "Mera information om detta tr�d";
    $text['total'] = "Totalt antal";
    //added in 12.0
    $text['totdeceased'] = "Totalt antal avlidna";
    break;

  case "notes":
    $text['browseallnotes'] = "Bl�ddra i alla Noteringar";
    break;

  case "help":
    $text['menuhelp'] = "Meny";
    break;

  case "install":
    $text['perms'] = "Alla r�ttigheter �r definierade.";
    $text['noperms'] = "R�ttigheter kunde inte definieras f�r f�ljande filer:";
    $text['manual'] = "St�ll in dem manuellt!";
    $text['folder'] = "Mapp";
    $text['created'] = "har skapats";
    $text['nocreate'] = "kunde inte skapas. Skapa den manuellt!";
    $text['infosaved'] = "Informationen sparad, kopplingen verifierad!";
    $text['tablescr'] = "Tabellerna har skapats!";
    $text['notables'] = "F�ljande tabeller kunde inte skapas:";
    $text['nocomm'] = "TNG kommunicerar inte med databasen. Inga tabeller skapades.";
    $text['newdb'] = "Informationen sparad, kopplingen verifierad, ny databas skapad:";
    $text['noattach'] = "Informationen sparad. Koppling gjord och databas skapad, men TNG kan inte ansluta till den.";
    $text['nodb'] = "Informationen sparad. Koppling gjord, men databasen existerar inte och kunde inte skapas h�r. Verifiera att databasnamnet �r korrekt eller anv�nd din kontrollpanel f�r att skapa den.";
    $text['noconn'] = "Informationen sparad men kopplingen misslyckades. Ett eller flera av f�ljande �r fel:";
    $text['exists'] = "finns";
    $text['loginfirst'] = "Du m�ste f�rst logga in.";
    $text['noop'] = "Ingen �tg�rd har utf�rts.";
    //added in 8.0.0
    $text['nouser'] = "Anv�ndaren skapades inte. Anv�ndarnamnet kanske redan finns.";
    $text['notree'] = "Tr�det skapades inte. Tr�dnamnet kanske redan finns.";
    $text['infosaved2'] = "Informationen sparades";
    $text['renamedto'] = "omd�pt till";
    $text['norename'] = "kunde inte d�pas om";
    break;

  case "imgviewer":
    $text['zoomin'] = "Zooma In";
    $text['zoomout'] = "Zooma Ut";
    $text['magmode'] = "Zooml�ge";
    $text['panmode'] = "Panoreringsl�ge";
    $text['pan'] = "Klicka och drag f�r att man�vrera inom bilden";
    $text['fitwidth'] = "Passa bredd";
    $text['fitheight'] = "Passa h�jd";
    $text['newwin'] = "Nytt f�nster";
    $text['opennw'] = "�ppna bilden i nytt f�nster";
    $text['magnifyreg'] = "Klicka f�r att f�rstora en del av bilden";
    $text['imgctrls'] = "Aktivera Bildkontroller";
    $text['vwrctrls'] = "Aktivera Bildl�sarens kontroller";
    $text['vwrclose'] = "St�ng Bildl�saren";
    break;

  case "dna":
    $text['test_date'] = "Testdatum";
    $text['links'] = "Relevanta l�nkar";
    $text['testid'] = "Test-ID";
    //added in 12.0.0
    $text['mode_values'] = "DNA-l�gesv�rden";
    $text['compareselected'] = "J�mf�r valda";
    $text['dnatestscompare'] = "J�mf�r Y-DNA-tester";
    $text['keep_name_private'] = "Beh�ll namnet privat";
    $text['browsealltests'] = "Bl�ddra i alla tester";
    $text['all_dna_tests'] = "Alla DNA-tester";
    $text['fastmutating'] = "Snabbmuterande";
    $text['alltypes'] = "Alla Typer";
    $text['allgroups'] = "Alla Grupper";
    $text['Ydna_LITbox_info'] = "Test l�nkade till denna person har inte n�dv�ndigtvis tagits av personen sj�lv.<br />Kolumnen 'Haplogrupp' visar data med r�d text om resultatet �r 'Ber�knat' och gr�n om testet �r 'Bekr�ftat'";
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
$text['matches'] = "Tr�ffar";
$text['description'] = "Beskrivning";
$text['notes'] = "Noteringar";
$text['status'] = "Status";
$text['newsearch'] = "Ny s�kning";
$text['pedigree'] = "Antavla";
$text['seephoto'] = "Se foto";
$text['andlocation'] = "& placering";
$text['accessedby'] = "l�st av";
$text['family'] = "Familj"; //from getperson
$text['children'] = "Barn";  //from getperson
$text['tree'] = "Tr�d";
$text['alltrees'] = "Alla tr�d";
$text['nosurname'] = "[Inget efternamn]";
$text['thumb'] = "Frim�rke";  //as in Thumbnail
$text['people'] = "M�nniskor";
$text['title'] = "Titel";  //from getperson
$text['suffix'] = "Suffix";  //from getperson
$text['nickname'] = "Smeknamn";  //from getperson
$text['lastmodified'] = "Senast �ndrad";  //from getperson
$text['married'] = "Gift";  //from getperson
//$text['photos'] = "Photos";
$text['name'] = "Namn"; //from showmap
$text['lastfirst'] = "Efternamn, f�rnamn";  //from search
$text['bornchr'] = "F�dd/D�pt";  //from search
$text['individuals'] = "Individer";  //from whats new
$text['families'] = "Familjer";
$text['personid'] = "Person-ID";
$text['sources'] = "K�llor";  //from getperson (next several)
$text['unknown'] = "Ok�nd";
$text['father'] = "Far";
$text['mother'] = "Mor";
$text['christened'] = "D�pt";
$text['died'] = "D�d";
$text['buried'] = "Begravd";
$text['spouse'] = "Make/Maka";  //from search
$text['parents'] = "F�r�ldrar";  //from pedigree
$text['text'] = "Text";  //from sources
$text['language'] = "Spr�k";  //from languages
$text['descendchart'] = "�ttlingar";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Individ";
$text['edit'] = "Redigera";
$text['date'] = "Datum";
$text['place'] = "Plats";
$text['login'] = "Logga in";
$text['logout'] = "Logga ut";
$text['groupsheet'] = "Familje�versikt";
$text['text_and'] = "och";
$text['generation'] = "Generation";
$text['filename'] = "Filnamn";
$text['id'] = "ID";
$text['search'] = "S�k";
$text['user'] = "Anv�ndare";
$text['firstname'] = "F�rnamn";
$text['lastname'] = "Efternamn";
$text['searchresults'] = "S�kresultat";
$text['diedburied'] = "D�d/Begraven";
$text['homepage'] = "Hem";
$text['find'] = "S�k...";
$text['relationship'] = "Sl�ktskap";    //in German, Verwandtschaft
$text['relationship2'] = "Relation"; //different in some languages, at least in German (Beziehung)
$text['timeline'] = "Tidslinje";
$text['yesabbr'] = "J";               //abbreviation for 'yes'
$text['divorced'] = "Skilda";
$text['indlinked'] = "L�nkad till";
$text['branch'] = "Gren";
$text['moreind'] = "Flera individer";
$text['morefam'] = "Flera familjer";
$text['source'] = "K�lla";
$text['surnamelist'] = "Efternamnslista";
$text['generations'] = "Generationer";
$text['refresh'] = "Uppdatera";
$text['whatsnew'] = "Nyheter";
$text['reports'] = "Rapporter";
$text['placelist'] = "Platslista";
$text['baptizedlds'] = "D�pt (LDS)";
$text['endowedlds'] = "Beg�vad (LDS)";
$text['sealedplds'] = "Beseglad F (LDS)";
$text['sealedslds'] = "Beseglad M (LDS)";
$text['ancestors'] = "Anor";
$text['descendants'] = "�ttlingar";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Senaste GEDCOM import";
$text['type'] = "Typ";
$text['savechanges'] = "Spara �ndringar";
$text['familyid'] = "Familjens ID";
$text['headstone'] = "Gravsten";
$text['historiesdocs'] = "Text-dokument";
$text['anonymous'] = "anonym";
$text['places'] = "Platser";
$text['anniversaries'] = "Datum & Bem�rkelsedagar";
$text['administration'] = "Administration";
$text['help'] = "Hj�lp";
//$text['documents'] = "Documents";
$text['year'] = "�r";
$text['all'] = "Alla";
$text['repository'] = "Arkiv";
$text['address'] = "Adress";
$text['suggest'] = "F�resl�";
$text['editevent'] = "F�resl� �ndring av denna h�ndelse";
$text['findplaces'] = "Hitta alla personer med h�ndelser p� denna plats";
$text['morelinks'] = "Flera l�nkar";
$text['faminfo'] = "Familjeinformation";
$text['persinfo'] = "Personlig information";
$text['srcinfo'] = "Information om k�llan";
$text['fact'] = "Fakta";
$text['goto'] = "V�lj en sida";
$text['tngprint'] = "Skriv ut";
$text['databasestatistics'] = "Databasstatistik"; //needed to be shorter to fit on menu
$text['child'] = "Barn";  //from familygroup
$text['repoinfo'] = "Arkivinformation";
$text['tng_reset'] = "�terst�ll";
$text['noresults'] = "Inget resultat";
$text['allmedia'] = "Alla Media";
$text['repositories'] = "Arkiv";
$text['albums'] = "Album";
$text['cemeteries'] = "Begravningsplatser";
$text['surnames'] = "Efternamn";
$text['dates'] = "Datum";
$text['link'] = "L�nk";
$text['media'] = "Media";
$text['gender'] = "K�n";
$text['latitude'] = "Latitud";
$text['longitude'] = "Longitud";
$text['bookmarks'] = "Bokm�rken";
$text['bookmark'] = "L�gg till Bokm�rke";
$text['mngbookmarks'] = "G� till Bokm�rken";
$text['bookmarked'] = "Bokm�rke tillagt";
$text['remove'] = "Ta bort";
$text['find_menu'] = "Hitta";
$text['info'] = "Info"; //this needs to be a very short abbreviation
$text['cemetery'] = "Begravningsplats";
$text['gmapevent'] = "H�ndelse-karta";
$text['gevents'] = "H�ndelse";
$text['glang'] = "&amp;hl=sv";
$text['googleearthlink'] = "L�nk till Google Earth";
$text['googlemaplink'] = "L�nk till Google Maps";
$text['gmaplegend'] = "Teckenf�rklaring, m�rken";
$text['unmarked'] = "Omarkerad";
$text['located'] = "Lokaliserad";
$text['albclicksee'] = "Klicka f�r att se alla poster i detta album.";
$text['notyetlocated'] = "Ej lokaliserad �nnu";
$text['cremated'] = "Kremerad";
$text['missing'] = "Saknad";
$text['pdfgen'] = "PDF-Generator";
$text['blank'] = "Blankt diagram";
$text['none'] = "Ingen";
$text['fonts'] = "Fonter";
$text['header'] = "Rubrik";
$text['data'] = "Data";
$text['pgsetup'] = "Sidinst�llningar";
$text['pgsize'] = "Sidstorlek";
$text['orient'] = "Orientering"; //for a page
$text['portrait'] = "St�ende";
$text['landscape'] = "Liggande";
$text['tmargin'] = "Toppmarginal";
$text['bmargin'] = "Bottenarginal";
$text['lmargin'] = "V�nstermarginal";
$text['rmargin'] = "H�germarginal";
$text['createch'] = "Skapa diagram";
$text['prefix'] = "Prefix";
$text['mostwanted'] = "Mest efters�kt";
$text['latupdates'] = "Senaste uppdateringar";
$text['featphoto'] = "Specialartikel foto";
$text['news'] = "Nyheter";
$text['ourhist'] = "V�r familjehistoria";
$text['ourhistanc'] = "V�r familjehistoria och anor";
$text['ourpages'] = "V�r familjs sl�ktsida";
$text['pwrdby'] = "Denna sajt �r byggd med";
$text['writby'] = "skapad av";
$text['searchtngnet'] = "S�k TNG Network (GENDEX)";
$text['viewphotos'] = "Se alla foton";
$text['anon'] = "Du �r f�r n�rvarande anonym";
$text['whichbranch'] = "Vilken gren kommer du ifr�n?";
$text['featarts'] = "Specialartiklar";
$text['maintby'] = "Underh�lls av";
$text['createdon'] = "Skapad den";
$text['reliability'] = "Tillf�rlitlighet";
$text['labels'] = "M�rken";
$text['inclsrcs'] = "Ta med k�llor";
$text['cont'] = "(forts.)"; //abbreviation for continued
$text['mnuheader'] = "Hemsida";
$text['mnusearchfornames'] = "S�k namn";
$text['mnulastname'] = "Efternamn";
$text['mnufirstname'] = "F�rnamn";
$text['mnusearch'] = "S�k";
$text['mnureset'] = "Starta om";
$text['mnulogon'] = "Logga in";
$text['mnulogout'] = "Logga ut";
$text['mnufeatures'] = "Andra funktioner";
$text['mnuregister'] = "Ans�k om anv�ndarkonto";
$text['mnuadvancedsearch'] = "Avancerad s�kning";
$text['mnulastnames'] = "Efternamn";
$text['mnustatistics'] = "Statistik";
$text['mnuphotos'] = "Foton";
$text['mnuhistories'] = "Text-dokument";
$text['mnumyancestors'] = "Foton och Dokument f�r Anor till [Person]";
$text['mnucemeteries'] = "Begravningsplatser";
$text['mnutombstones'] = "Gravstenar";
$text['mnureports'] = "Rapporter";
$text['mnusources'] = "K�llor";
$text['mnuwhatsnew'] = "Nyheter";
$text['mnushowlog'] = "G� till Logg";
$text['mnulanguage'] = "Byt spr�k";
$text['mnuadmin'] = "Administration";
$text['welcome'] = "V�lkommen";
$text['contactus'] = "Kontakt";
//changed in 8.0.0
$text['born'] = "F�dd";
$text['searchnames'] = "S�k namn";
//added in 8.0.0
$text['editperson'] = "Redigera person";
$text['loadmap'] = "Ladda kartan";
$text['birth'] = "F�delse";
$text['wasborn'] = "f�ddes";
$text['startnum'] = "Startnummer";
$text['searching'] = "S�ker";
//moved here in 8.0.0
$text['location'] = "Plats";
$text['association'] = "Relation till";
$text['collapse'] = "Komprimera";
$text['expand'] = "Expandera";
$text['plot'] = "Grav";
$text['searchfams'] = "S�k Familjer";
//added in 8.0.2
$text['wasmarried'] = "Gift";
$text['anddied'] = "D�d";
//added in 9.0.0
$text['share'] = "Dela";
$text['hide'] = "D�lj";
$text['disabled'] = "Ditt anv�ndarkonto har blivit inaktiverat. Kontakta webbadministrat�ren f�r mera information.";
$text['contactus_long'] = "Om du har fr�gor eller kommentarer om inneh�llet p� denna webbsida, <span class=\"emphasis\"><a href=\"suggest.php\">kontakta oss</a></span>. Vi ser fram emot att f� h�ra ifr�n dig.";
$text['features'] = "Funktioner";
$text['resources'] = "Resurser";
$text['latestnews'] = "Senaste nytt";
$text['trees'] = "Tr�d";
$text['wasburied'] = "�r begravd";
//moved here in 9.0.0
$text['emailagain'] = "Upprepa e-mail";
$text['enteremail2'] = "Skriv in din e-mailadress igen.";
$text['emailsmatch'] = "Dina e-mailadresser matchar inte. Skriv in samma e-mailadress i b�da f�lten.";
$text['getdirections'] = "Klicka f�r att f� guide";
$text['calendar'] = "Kalender";
//changed in 9.0.0
$text['directionsto'] = " till ";
$text['slidestart'] = "Bildspel";
$text['livingnote'] = "Minst en levande person �r l�nkad till denna notering - Detaljer visas inte.";
$text['livingphoto'] = "Minst en levande person �r l�nkad till denna bild - Detaljinformation visas inte.";
$text['waschristened'] = "D�pt";
//added in 10.0.0
$text['branches'] = "Grenar";
$text['detail'] = "Detalj";
$text['moredetail'] = "Flera detaljer";
$text['lessdetail'] = "F�rre detaljer";
$text['otherevents'] = "Andra H�ndelser";
$text['conflds'] = "Konfirmerad (LDS)";
$text['initlds'] = "Initierad (LDS)";
$text['wascremated'] = "kremerades";
//moved here in 11.0.0
$text['text_for'] = "f�r";
//added in 11.0.0
$text['searchsite'] = "S�k p� denna sajt";
$text['searchsitemenu'] = "S�k p� denna sajt";
$text['kmlfile'] = "Ladda ner en .kml-fil f�r att visa denna plats i Google Earth";
$text['download'] = "Klicka f�r att ladda ner";
$text['more'] = "Mera";
$text['heatmap'] = "Populationskarta";
$text['refreshmap'] = "Ladda om kartan";
$text['remnums'] = "Rensa siffror och mark�rer";
$text['photoshistories'] = "Foton &amp; Historier";
$text['familychart'] = "Familjediagram";
//added in 12.0.0
$text['firstnames'] = "F�rnamn";
//moved here in 12.0.0
$text['dna_test'] = "DNA-test";
$text['test_type'] = "Typ av test";
$text['test_info'] = "Information om testet";
$text['takenby'] = "Tagen av";
$text['haplogroup'] = "Haplogrupp";
$text['hvr1'] = "HVR1";
$text['hvr2'] = "HVR2";
$text['relevant_links'] = "Relevanta l�nkar";
$text['nofirstname'] = "[inget f�rnamn]";
//added in 12.0.1
$text['cookieuse'] = "OBS: Denna sajt anv�nder cookies.";
$text['dataprotect'] = "Dataskyddspolicy ";
$text['viewpolicy'] = "Visa policy";
$text['understand'] = "Jag f�rst�r";
$text['consent'] = "Jag godk�nner att denna sajt lagrar den personliga information som samlas in h�r. Jag f�rst�r att jag n�r som helst kan be sajtens �gare att radera denna information. ";
$text['consentreq'] = "V�nligen ge ditt samtycke till att denna sajt lagrar din personliga information.";

//added in 12.1.0
$text['testsarelinked'] = "DNA tests are associated with";
$text['testislinked'] = "DNA test is associated with";

//added in 12.2
$text['quicklinks'] = "Snabbl�nkar";
$text['yourname'] = "Ditt namn";
$text['youremail'] = "Din e-postadress";
$text['liketoadd'] = "All information du vill l�gga till";
$text['webmastermsg'] = "Webmastermeddelande";
$text['gallery'] = "Se Galleri";
$text['wasborn_male'] = "f�ddes";
$text['wasborn_female'] = "f�ddes";
$text['waschristened_male'] = "d�ptes";
$text['waschristened_female'] = "d�ptes";
$text['died_male'] = "dog";
$text['died_female'] = "dog";
$text['wasburied_male'] = "begravdes";
$text['wasburied_female'] = "begravdes";
$text['wascremated_male'] = "kremerades";
$text['wascremated_female'] = "kremerades";
$text['wasmarried_male'] = "gift";
$text['wasmarried_female'] = "gift";
$text['wasdivorced_male'] = "skildes";
$text['wasdivorced_female'] = "skildes";
$text['inplace'] = " in ";
$text['onthisdate'] = " p� ";
$text['inthisyear'] = " in ";
$text['and'] = "och ";

//moved here in 12.3
$text['dna_info_head'] = "Information om DNA-test";
$text['firstpage'] = "F�rsta sidan";
$text['lastpage'] = "Sista sidan";

@include_once "captcha_text.php";
@include_once "alltext.php";
if (!$alltextloaded) {
  getAllTextPath();
}

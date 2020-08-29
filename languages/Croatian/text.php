<?php
switch ($textpart) {
  //browsesources.php, showsource.php
  case "sources":
    $text['browseallsources'] = "Pretra�i sve izvore";
    $text['shorttitle'] = "Kratki naslov";
    $text['callnum'] = "Pozivni broj";
    $text['author'] = "Autor";
    $text['publisher'] = "Izdava�";
    $text['other'] = "Ostale informacije";
    $text['sourceid'] = "Source ID";
    $text['moresrc'] = "Jo� izvora";
    $text['repoid'] = "Repository ID";
    $text['browseallrepos'] = "Pretra�i sve Repositories";
    break;

  //changelanguage.php, savelanguage.php
  case "language":
    $text['newlanguage'] = "Novi jezik";
    $text['changelanguage'] = "Promijeni jezik";
    $text['languagesaved'] = "Jezik pohranjen";
    $text['sitemaint'] = "Site maintenance in progress";
    $text['standby'] = "The site is temporarily unavailable while we update our database. Please try again in a few minutes. If the site remains down for an extended period of time, please <a href=\"suggest.php\">contact the site owner</a>.";
    break;

  //gedcom.php, gedform.php
  case "gedcom":
    $text['gedstart'] = "GEDCOM po�inje od";
    $text['producegedfrom'] = "Proizvedi GEDCOM datoteku od";
    $text['numgens'] = "Broj generacija";
    $text['includelds'] = "Uklju�i LDS informaciju";
    $text['buildged'] = "Build GEDCOM";
    $text['gedstartfrom'] = "GEDCOM po�etna forma";
    $text['nomaxgen'] = "Morate nazna�iti maksimalni broj generacija. Molim koristite tipku Natrag za povratak na prethodnu stranicu i ispravite pogre�ku";
    $text['gedcreatedfrom'] = "GEDCOM kreirana forma";
    $text['gedcreatedfor'] = "kreirano za";
    $text['creategedfor'] = "Kreiraj GEDCOM";
    $text['email'] = "E-mail adresa";
    $text['suggestchange'] = "Predlo�i promjenu";
    $text['yourname'] = "Va�e ime";
    $text['comments'] = "Komentar";
    $text['comments2'] = "Komentar";
    $text['submitsugg'] = "Po�alji prijedlog";
    $text['proposed'] = "Predlo�ena promjena";
    $text['mailsent'] = "Hvala. Va�a je poruka isporu�ena.";
    $text['mailnotsent'] = "�ao nam je, ali va�a poruka ne mo�e biti isporu�ena. Molim kontaktirajte me direktno na mbralic@gmail.com.";
    $text['mailme'] = "Po�alji kopiju od ove adrese";
    $text['entername'] = "Molim unesite va�e ime";
    $text['entercomments'] = "Molim unesite va� komentar";
    $text['sendmsg'] = "Po�alji poruku";
    //added in 9.0.0
    $text['subject'] = "Subject";
    break;

  //getextras.php, getperson.php
  case "getperson":
    $text['photoshistoriesfor'] = "Fotografije i povijest ";
    $text['indinfofor'] = "Osobna informacija za";
    $text['pp'] = "pp."; //page abbreviation
    $text['age'] = "starost";
    $text['agency'] = "Agencija";
    $text['cause'] = "Uzrok";
    $text['suggested'] = "Predlo�eno";
    $text['closewindow'] = "Zatvori ovaj prozor";
    $text['thanks'] = "Hvala";
    $text['received'] = "Va�a sugestija je proslje�ena administratoru web site-a na uvid.";
    $text['indreport'] = "Individual Report";
    $text['indreportfor'] = "Individual Report for";
    $text['general'] = "General";
    $text['bkmkvis'] = "<strong>Note:</strong> These bookmarks are only visible on this computer and in this browser.";
    //added in 9.0.0
    $text['reviewmsg'] = "You have a suggested change that needs your review. This submission concerns:";
    $text['revsubject'] = "Suggested change needs your review";
    break;

  //relateform.php, relationship.php, findpersonform.php, findperson.php
  case "relate":
    $text['relcalc'] = "Kalkulator rodbinskih veza";
    $text['findrel'] = "Na�i rodbinsku vezu";
    $text['person1'] = "Osoba 1:";
    $text['person2'] = "Osoba 2:";
    $text['calculate'] = "Izra�unaj";
    $text['select2inds'] = "Molim izaberite dvije osobe.";
    $text['findpersonid'] = "Na�i ID osobe";
    $text['enternamepart'] = "unesi dio imena i/ili prezimena";
    $text['pleasenamepart'] = "Molim unesite dio imena ili prezimena.";
    $text['clicktoselect'] = "klikni za izbor";
    $text['nobirthinfo'] = "Fali informacija o ro�enju";
    $text['relateto'] = "Rodbinska veza";
    $text['sameperson'] = "Dvije osobe su jedna te ista osoba.";
    $text['notrelated'] = "Dvije osobe nisu u vezi sa xxx generacija."; //xxx will be replaced with number of generations
    $text['findrelinstr'] = "Za prikazati obiteljsku vezu izme�u dvije osobe, koristi 'Find' tipku dolje da bi locirali osobe (ili nastavi prikazivati osobe), zatim klikni na 'Kalkuliraj'.";
    $text['sometimes'] = "(Ponekad provjera medu razli�itim brojevima generacija daje razli�ite rezultate.)";
    $text['findanother'] = "Na�i drugu rodbinsku vezu";
    $text['brother'] = "brat od";
    $text['sister'] = "sestra od";
    $text['sibling'] = "potomak od";
    $text['uncle'] = "xxx je ujak od";
    $text['aunt'] = "xxx je tetka od";
    $text['uncleaunt'] = "xxx je ujak/tetka od";
    $text['nephew'] = "xxx je ne�ak od";
    $text['niece'] = "xxx je ne�akinja od";
    $text['nephnc'] = "xxx je ne�ak/ne�akinja od";
    $text['removed'] = "times obrisan";
    $text['rhusband'] = "suprug od ";
    $text['rwife'] = "supruga od ";
    $text['rspouse'] = "supruga od ";
    $text['son'] = "sin od";
    $text['daughter'] = "kcerka od";
    $text['rchild'] = "dijete od";
    $text['sil'] = "zet od";
    $text['dil'] = "nevjesta od";
    $text['sdil'] = "zet ili nevjesta od";
    $text['gson'] = "xxx unuk od";
    $text['gdau'] = "xxx unuka od";
    $text['gsondau'] = "xxx unuk/unuka od";
    $text['great'] = "ve�i";
    $text['spouses'] = "su supruge";
    $text['is'] = "je";
    $text['changeto'] = "Promijeni u (unesi ID):";
    $text['notvalid'] = "nije valjan broj osobnog ID-a ili ne postoji u ovoj bazi podataka. Molim poku�ajte ponovo.";
    $text['halfbrother'] = "the half brother of";
    $text['halfsister'] = "the half sister of";
    $text['halfsibling'] = "the half sibling of";
    //changed in 8.0.0
    $text['gencheck'] = "Max generacija<br>za provjeru";
    $text['mcousin'] = "xxx je brati� yyy od";  //male cousin; xxx = cousin number, yyy = times removed
    $text['fcousin'] = "xxx je sestri�na yyy od";  //female cousin
    $text['cousin'] = "xxx je ro�ak yyy od";
    $text['mhalfcousin'] = "xxx pola brati� yyy od";  //male cousin
    $text['fhalfcousin'] = "xxx pola sestri�na yyy od";  //female cousin
    $text['halfcousin'] = "xxx pola ro�ak yyy od";
    //added in 8.0.0
    $text['oneremoved'] = "jedna generacija odmaknut";
    $text['gfath'] = "xxx djed od";
    $text['gmoth'] = "xxx baka od";
    $text['gpar'] = "xxx djed/baka od";
    $text['mothof'] = "majka od";
    $text['fathof'] = "otac od";
    $text['parof'] = "roditelj od";
    $text['maxrels'] = "Maximalni broj veza pokazati";
    $text['dospouses'] = "Poka�i veze koje se ti�u supruge";
    $text['rels'] = "Veze";
    $text['dospouses2'] = "Poka�i Supruge";
    $text['fil'] = "svekar od";
    $text['mil'] = "svekrva od";
    $text['fmil'] = "svekar ili svekrva od";
    $text['stepson'] = "posinak od";
    $text['stepdau'] = "po�erka od";
    $text['stepchild'] = "pastor�e od";
    $text['stepgson'] = "the xxx step-grandson of";
    $text['stepgdau'] = "the xxx step-granddaughter of";
    $text['stepgchild'] = "the xxx step-grandchild of";
    //added in 8.1.1
    $text['ggreat'] = "ve�i";
    //added in 8.1.2
    $text['ggfath'] = "the xxx great grandfather of";
    $text['ggmoth'] = "the xxx great grandmother of";
    $text['ggpar'] = "the xxx great grandparent of";
    $text['ggson'] = "the xxx great grandson of";
    $text['ggdau'] = "the xxx great granddaughter of";
    $text['ggsondau'] = "the xxx great grandchild of";
    $text['gstepgson'] = "the xxx great step-grandson of";
    $text['gstepgdau'] = "the xxx great step-granddaughter of";
    $text['gstepgchild'] = "the xxx great step-grandchild of";
    $text['guncle'] = "the xxx great uncle of";
    $text['gaunt'] = "the xxx great aunt of";
    $text['guncleaunt'] = "the xxx great uncle/aunt of";
    $text['gnephew'] = "the xxx great nephew of";
    $text['gniece'] = "the xxx great niece of";
    $text['gnephnc'] = "the xxx great nephew/niece of";
    break;

  case "familygroup":
    $text['familygroupfor'] = "Obiteljska grupna lista za";
    $text['ldsords'] = "LDS Propisi";
    $text['baptizedlds'] = "Kr�ten (LDS)";
    $text['endowedlds'] = "Endowed (LDS)";
    $text['sealedplds'] = "Sealed P (LDS)";
    $text['sealedslds'] = "Sealed S (LDS)";
    $text['otherspouse'] = "Ostale supruge/supruzi";
    $text['husband'] = "Suprug";
    $text['wife'] = "Supruga";
    break;

  //pedigree.php
  case "pedigree":
    $text['capbirthabbr'] = "B";
    $text['capaltbirthabbr'] = "A";
    $text['capdeathabbr'] = "D";
    $text['capburialabbr'] = "B";
    $text['capplaceabbr'] = "P";
    $text['capmarrabbr'] = "M";
    $text['capspouseabbr'] = "SP";
    $text['redraw'] = "Iscrtati sa";
    $text['scrollnote'] = "Bilje�ke: Mo�ete skrolovati dolje ili desno za vidjeti tablu.";
    $text['unknownlit'] = "Nepoznat";
    $text['popupnote1'] = " = Dodatna informacija";
    $text['popupnote2'] = " = Novo porijeklo";
    $text['pedcompact'] = "Kompakt";
    $text['pedstandard'] = "Standard";
    $text['pedtextonly'] = "Tekst";
    $text['descendfor'] = "Nasljednici za";
    $text['maxof'] = "Maksimum od";
    $text['gensatonce'] = "generacija prikazanih odjednom.";
    $text['sonof'] = "sin od";
    $text['daughterof'] = "k�i od";
    $text['childof'] = "dijete od";
    $text['stdformat'] = "Standardni Format";
    $text['ahnentafel'] = "Ahnentafel";
    $text['addnewfam'] = "Dodaj novu obitelj";
    $text['editfam'] = "Uredi obitelj";
    $text['side'] = "Strana";
    $text['familyof'] = "Obitelj od";
    $text['paternal'] = "O�ev";
    $text['maternal'] = "Materinji";
    $text['gen1'] = "Vlastiti";
    $text['gen2'] = "Roditelji";
    $text['gen3'] = "Djedovi";
    $text['gen4'] = "Pradjedovi";
    $text['gen5'] = "Pra Pra djedovi";
    $text['gen6'] = "3. Pra djedovi";
    $text['gen7'] = "4. Pra djedovi";
    $text['gen8'] = "5. Pra djedovi";
    $text['gen9'] = "6. Pra djedovi";
    $text['gen10'] = "7. Pra djedovi";
    $text['gen11'] = "8. Pra djedovi";
    $text['gen12'] = "9. Pra djedovi";
    $text['graphdesc'] = "Tabla potomaka do ovog trenutka";
    $text['pedbox'] = "Box";
    $text['regformat'] = "Register";
    $text['extrasexpl'] = "= Najmanje jedna fotografija, povijest ili neki drugi media item postoji o ovoj osobi.";
    $text['popupnote3'] = " = Novi dijagram";
    $text['mediaavail'] = "Medija na raspolaganju";
    $text['pedigreefor'] = "Porijeklo za";
    $text['pedigreech'] = "Pedigre Dijagram";
    $text['datesloc'] = "Datumi i Mjesta";
    $text['borchr'] = "Ro�enje/Alt - Smrt/Pogreb (dva)";
    $text['nobd'] = "Nema Datume Ro�enja ili Smrti";
    $text['bcdb'] = " Ro�enje/Alt/Smrt/Pogreb (�etri)";
    $text['numsys'] = "Sistem Numeriranje";
    $text['gennums'] = "Brojevi Generacije";
    $text['henrynums'] = "Henry Brojevi";
    $text['abovnums'] = "d'Aboville Brojevi";
    $text['devnums'] = "de Villiers Brojevi";
    $text['dispopts'] = "Opcije Prikaza";
    //added in 10.0.0
    $text['no_ancestors'] = "No ancestors found";
    $text['ancestor_chart'] = "Vertical ancestor chart";
    $text['opennewwindow'] = "Open in a new window";
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
    $text['noreports'] = "Izvje�ce ne postoji.";
    $text['reportname'] = "Naziv izvje��a";
    $text['allreports'] = "Sva izvje��a";
    $text['report'] = "Izvje��e";
    $text['error'] = "Gre�ka";
    $text['reportsyntax'] = "Sintaksa upita se pokre�e zajedno s ovim izvje��em";
    $text['wasincorrect'] = "je pogre�no, i kao rezultat izvje��e se ne mo�e pokrenuti. Molim da kontaktirate administratora sustava";
    $text['errormessage'] = "Poruka Gre�ke";
    $text['equals'] = "jednako";
    $text['endswith'] = "zavr�ava sa";
    $text['soundexof'] = "Soundex od";
    $text['metaphoneof'] = "metafon od";
    $text['plusminus10'] = "+/- 10 godina od";
    $text['lessthan'] = "manje nego";
    $text['greaterthan'] = "ve�e od";
    $text['lessthanequal'] = "manje ili jednako od";
    $text['greaterthanequal'] = "ve�e ili jednako za";
    $text['equalto'] = "jednako";
    $text['tryagain'] = "Molim poku�ajte ponovo";
    $text['joinwith'] = "Spoji sa";
    $text['cap_and'] = "I";
    $text['cap_or'] = "ILI";
    $text['showspouse'] = "Prikazana suprugu pokazat �e se kao duplikat ako osoba ima vi�e od jedne supruge)";
    $text['submitquery'] = "Po�alji upit";
    $text['birthplace'] = "Mjesto ro�enja";
    $text['deathplace'] = "Mjesto smrti";
    $text['birthdatetr'] = "Godina ro�enja";
    $text['deathdatetr'] = "Godina smrti";
    $text['plusminus2'] = "+/- 2 godine od";
    $text['resetall'] = "Resetiraj sve vrijednosti";
    $text['showdeath'] = "Prika�i smrt/informaciju o pogrebu";
    $text['altbirthplace'] = "Mjesto Kr�tenja";
    $text['altbirthdatetr'] = "Godina Kr�tenja";
    $text['burialplace'] = "Mjesto ukopa";
    $text['burialdatetr'] = "Godina ukopa";
    $text['event'] = "Doga�aj(i)";
    $text['day'] = "Dan";
    $text['month'] = "Mjesec";
    $text['keyword'] = "Klju�na rije� (npr, \"Popr\")";
    $text['explain'] = "Unesi komponente datuma da bi vidio doga�aje koji se sla�u. Ostavi prazno polje da bi vidjio sve doga�aje koji se sla�u.";
    $text['enterdate'] = "Molim unesi ili odaberi najmanje jedan podatak: Dan, Mjesec, Godina, klju�na rije�";
    $text['fullname'] = "Puno ime";
    $text['birthdate'] = "Datum ro�enja";
    $text['altbirthdate'] = "Datum kr�tenja";
    $text['marrdate'] = "Datum vjen�anja";
    $text['spouseid'] = "Suprugin ID";
    $text['spousename'] = "Suprugino ime";
    $text['deathdate'] = "Datum smrti";
    $text['burialdate'] = "Datum ukopa";
    $text['changedate'] = "Datum zadnje modifikacije";
    $text['gedcom'] = "Stablo";
    $text['baptdate'] = "Datum kr�tenja (LDS)";
    $text['baptplace'] = "Mjeto kr�tenja (LDS)";
    $text['endldate'] = "Endowment Date (LDS)";
    $text['endlplace'] = "Endowment Place (LDS)";
    $text['ssealdate'] = "Seal Date S (LDS)";   //Sealed to spouse
    $text['ssealplace'] = "Seal Place S (LDS)";
    $text['psealdate'] = "Seal Date P (LDS)";   //Sealed to parents
    $text['psealplace'] = "Seal Place P (LDS)";
    $text['marrplace'] = "Mjesto vjen�anja";
    $text['spousesurname'] = "Prezime supruge";
    $text['spousemore'] = "Ako unesete vrijednost supruginog prezimena, morate unijeti vrijednost u najmanje jo� jedno polje.";
    $text['plusminus5'] = "+/- 5 godina od";
    $text['exists'] = "postoji";
    $text['dnexist'] = "ne postoji";
    $text['divdate'] = "Datum Razvoda";
    $text['divplace'] = "Mjesto Razvoda";
    $text['otherevents'] = "Ostali doga�aji";
    $text['numresults'] = "Rezultati po stranici";
    $text['mysphoto'] = "Misteriozne Fotografije";
    $text['mysperson'] = "Nedosti�ani Ljudi";
    $text['joinor'] = "Opcija 'Sastavi sa ILI' se nemo�e upotrebiti sa Prezime Supruge";
    $text['tellus'] = "Recite nam �to znate";
    $text['moreinfo'] = "Vi�e Informacije:";
    //added in 8.0.0
    $text['marrdatetr'] = "Godina Vje�anja";
    $text['divdatetr'] = "Godina Razvoda";
    $text['mothername'] = "Ime Majke";
    $text['fathername'] = "Ime Otca";
    $text['filter'] = "Filtar";
    $text['notliving'] = "Ne �ivu�i";
    $text['nodayevents'] = "Doga�aji za ovaj mjesec koje nisu vezane uz odre�eni dan:";
    //added in 9.0.0
    $text['csv'] = "Comma-delimited CSV file";
    //added in 10.0.0
    $text['confdate'] = "Confirmation Date (LDS)";
    $text['confplace'] = "Confirmation Place (LDS)";
    $text['initdate'] = "Initiatory Date (LDS)";
    $text['initplace'] = "Initiatory Place (LDS)";
    //added in 11.0.0
    $text['marrtype'] = "Marriage Type";
    $text['searchfor'] = "Search for";
    $text['searchnote'] = "Note: This page uses Google to perform its search. The number of matches returned will be directly affected by the extent to which Google has been able to index the site.";
    break;

  //showlog.php
  case "showlog":
    $text['logfilefor'] = "Datoteka logova za";
    $text['mostrecentactions'] = "Posljednje aktivnosti";
    $text['autorefresh'] = "Automatsko osvje�avanje (30 sekundi)";
    $text['refreshoff'] = "Isklju�i automatsko osvje�ivanje";
    break;

  case "headstones":
  case "showphoto":
    $text['cemeteriesheadstones'] = "Groblja i nadgrobni spomenici";
    $text['showallhsr'] = "Prika�i sve podatke o nadgrobnim spomenicima";
    $text['in'] = "u";
    $text['showmap'] = "Prika�i mapu";
    $text['headstonefor'] = "Nadgrobni spomenik za";
    $text['photoof'] = "Fotografija od";
    $text['photoowner'] = "Vlasnik/Izvor";
    $text['nocemetery'] = "Nema groblja";
    $text['iptc005'] = "Naslov";
    $text['iptc020'] = "Dopunske kategorije";
    $text['iptc040'] = "Specijalne instrukcije";
    $text['iptc055'] = "Datum kreiranja";
    $text['iptc080'] = "Autor";
    $text['iptc085'] = "Autorova pozicija";
    $text['iptc090'] = "Grad";
    $text['iptc095'] = "State";
    $text['iptc101'] = "Dr�ava";
    $text['iptc103'] = "OTR";
    $text['iptc105'] = "Naslov";
    $text['iptc110'] = "Izvor";
    $text['iptc115'] = "Izvor Fotografije";
    $text['iptc116'] = "Obavijest o autorskim pravima";
    $text['iptc120'] = "Naslov";
    $text['iptc122'] = "Pisac Naslova";
    $text['mapof'] = "Karta od";
    $text['regphotos'] = "Deskriptivan pogled";
    $text['gallery'] = "Sli�ice Samo";
    $text['cemphotos'] = "Fotografije groblja";
    $text['photosize'] = "Dimenzije";
    $text['iptc010'] = "Prioritet";
    $text['filesize'] = "Veli�ina datoteke";
    $text['seeloc'] = "Vidi lokaciju";
    $text['showall'] = "Prika�i sve";
    $text['editmedia'] = "Uredi Media";
    $text['viewitem'] = "Pogledaj ovaj item";
    $text['editcem'] = "Uredi groblja";
    $text['numitems'] = "# Stavka";
    $text['allalbums'] = "Svi albumi";
    $text['slidestop'] = "Pauza Pokaz Prezentacije";
    $text['slideresume'] = "Nastavi Pokaz Prezentacije";
    $text['slidesecs'] = "Sekundi za svaki slajd:";
    $text['minussecs'] = "minus 0.5 sekundi";
    $text['plussecs'] = "plus 0.5 sekundi";
    $text['nocountry'] = "Nepoznata Zemlja";
    $text['nostate'] = "Nepoznata Dr�ava";
    $text['nocounty'] = "Nepoznata �upanija";
    $text['nocity'] = "Nepoznati Grad";
    $text['nocemname'] = "Nepoznato ime groblja";
    $text['editalbum'] = "Uredi Album";
    $text['mediamaptext'] = "<strong>Poruka:</strong> Maknite va� pokaziva� mi�a preko slike za pokazati imena. Kliknite za viditi stranicu za svako ime.";
    //added in 8.0.0
    $text['allburials'] = "Sve sahrane";
    $text['moreinfo'] = "Vi�e Informacije:";
    //added in 9.0.0
    $text['iptc025'] = "Keywords";
    $text['iptc092'] = "Sub-location";
    $text['iptc015'] = "Category";
    $text['iptc065'] = "Originating Program";
    $text['iptc070'] = "Program Version";
    break;

  //surnames.php, surnames100.php, surnames-all.php, surnames-oneletter.php
  case "surnames":
  case "places":
    $text['surnamesstarting'] = "Prika�i prezimena koja po�inju sa";
    $text['showtop'] = "Prika�i prvih";
    $text['showallsurnames'] = "Prika�i sva prezimena";
    $text['sortedalpha'] = "sortiraj abecedno";
    $text['byoccurrence'] = "sortiranih po pojavljivanju";
    $text['firstchars'] = "Prvi znakovi";
    $text['mainsurnamepage'] = "Glavna stranica prezimena";
    $text['allsurnames'] = "Sva prezimena";
    $text['showmatchingsurnames'] = "Kliknite na prezime za vidjeti polja koja se sla�u.";
    $text['backtotop'] = "Nazad na vrh";
    $text['beginswith'] = "Po�inje sa";
    $text['allbeginningwith'] = "Sva prezimena po�inju sa";
    $text['numoccurrences'] = "broj pojavljivanja u zagradama";
    $text['placesstarting'] = "Prika�i najve�i lokalitet koji po�inje s";
    $text['showmatchingplaces'] = "Klikni na mjesto ako �eli� prikazati manji lokalitet. Klikni na ikonu pretrage ako �eli� prikazati osobe koje se sla�u.";
    $text['totalnames'] = "ukupno osoba";
    $text['showallplaces'] = "Prika�i sve najve�e lokalitete";
    $text['totalplaces'] = "ukupno mjesta";
    $text['mainplacepage'] = "Stranica glavnih mjesta";
    $text['allplaces'] = "Svi najve�i lokaliteti";
    $text['placescont'] = "Prika�i sva mjesta koja sadr�e";
    //changed in 8.0.0
    $text['top30'] = "Najbrojnija xxx prezimena";
    $text['top30places'] = "Najbrojnija xxx ve�a mjesta";
    //added in 12.0.0
    $text['firstnamelist'] = "First Name List";
    $text['firstnamesstarting'] = "Show first names starting with";
    $text['showallfirstnames'] = "Show all first names";
    $text['mainfirstnamepage'] = "Main first name page";
    $text['allfirstnames'] = "All First Names";
    $text['showmatchingfirstnames'] = "Click on a first name to show matching records.";
    $text['allfirstbegwith'] = "All first names beginning with";
    $text['top30first'] = "Top xxx first names";
    $text['allothers'] = "All others";
    $text['amongall'] = "(among all names)";
    $text['justtop'] = "Just the top xxx";
    break;

  //whatsnew.php
  case "whatsnew":
    $text['pastxdays'] = "(prethodnih xx dana)";

    $text['photo'] = "Fotografija";
    $text['history'] = "Povijest/Dokument";
    $text['husbid'] = "Suprugov ID";
    $text['husbname'] = "Suprugovo ime";
    $text['wifeid'] = "Suprugin ID";
    //added in 11.0.0
    $text['wifename'] = "Mother's Name";
    break;

  //timeline.php, timeline2.php
  case "timeline":
    $text['text_delete'] = "Obri�i";
    $text['addperson'] = "Dodaj osobu";
    $text['nobirth'] = "Ova osoba nema valjani datum ro�enja i ne mo�e biti dodana";
    $text['event'] = "Doga�aj(i)";
    $text['chartwidth'] = "�irina table";
    $text['timelineinstr'] = "Dodaj ljude";
    $text['togglelines'] = "Dozvoli crte";
    //changed in 9.0.0
    $text['noliving'] = "Slijede�a osoba je ozna�ena kao �ivu�a i ne mo�e biti dodana zbog toga �to nisi logiran s odgovaraju�im ovlastima";
    break;

  //browsetrees.php
  //login.php, newacctform.php, addnewacct.php
  case "trees":
  case "login":
    $text['browsealltrees'] = "Pregledaj sva stabla";
    $text['treename'] = "Naziv stabla";
    $text['owner'] = "Vlasnik";
    $text['address'] = "Adrese";
    $text['city'] = "Grad";
    $text['state'] = "Dr�ava/Pokrajina";
    $text['zip'] = "Po�tanski broj";
    $text['country'] = "Zemlja";
    $text['email'] = "E-mail adresa";
    $text['phone'] = "Telefon";
    $text['username'] = "Korisni�ko Ime";
    $text['password'] = "Lozinka";
    $text['loginfailed'] = "Login nije uspio.";

    $text['regnewacct'] = "Registriraj se za novi korisni�ki account";
    $text['realname'] = "Va�e stvarno ime";
    $text['phone'] = "Telefon";
    $text['email'] = "E-mail adresa";
    $text['address'] = "Adrese";
    $text['acctcomments'] = "Komentar";
    $text['submit'] = "Ulo�i";
    $text['leaveblank'] = "(ostavi prazno ako zahtijevate novo stablo)";
    $text['required'] = "Potrebna polja";
    $text['enterpassword'] = "Molimo unesite zaporku.";
    $text['enterusername'] = "Molimo unesite korisni�ko ime.";
    $text['failure'] = "�ao nam je, ali va�e korisni�ko ime kojeg ste unijeli je ve� kori�teno. Molimo koristite Back button na va�em browser-u za povratak na prethodnu stanicu te odaberi druga�ije korisni�ko ime.";
    $text['success'] = "Hvala. Primili smo va�u registraciju. Kontaktirat �emo vas kada aktiviramo va� account ili ako su potrebne dodatne informacije.";
    $text['emailsubject'] = "Novi zahtjev za registracijom od strane TNG korisnika";
    $text['website'] = "Web Stranica";
    $text['nologin'] = "Nema� login?";
    $text['loginsent'] = "Login informacija poslata";
    $text['loginnotsent'] = "Login informacija nije poslata";
    $text['enterrealname'] = "Molimo unesite va�e realno ime.";
    $text['rempass'] = "Ostani logiran na ovom ra�unalu";
    $text['morestats'] = "Jo� statistike";
    $text['accmail'] = "<strong>NOTE:</strong> Molimo vas da ne blokirate mail s ove domene ako �elite primati email-ove od sistem administratora u vezi va�eg account-a.";
    $text['newpassword'] = "Nova zaporka";
    $text['resetpass'] = "Resetiraj svoju zaporku";
    $text['nousers'] = "Ova forma ne mo�e biti kori�tena sve dok postoji najmanje jedan korisnik. Ako ste vlasnik site-a, molim vas da kreirate va� Administrator account iz Admin/Users.";
    $text['noregs'] = "�ao nam je, ali mi ne prihva�amo nove korisni�ke registracije u ovom trenutku.  Molimo <a href=\"suggest.php\"> kontaktirajte nas </a> direktno ako imate komentare ili pitanja u vezi s bilo �to na ovom mjestu. ";
    //changed in 8.0.0
    $text['emailmsg'] = "Primili ste novi zahtjev za otvaranje TNG korisni�kog account-a. Molimo da se logirate na va� TNG Admin account i dodijelite odgovaraju�e ovlasti novom account-u. Ako odobrite ovu registraciju, molim da obavjestite aplikanta na na�in da odgovorite na ovu poruku.";
    $text['accactive'] = "Korisni�ki ra�un je aktiviran, ali korisnik ne�e imati posebna prava dok ih ne dodijeliti.";
    $text['accinactive'] = "Idite na Admin/Korisnici/Pregled za pristup postavke ra�una. Ra�un �e ostati neaktivan sve dok se ne uredi i spremi zapis barem jedanput.";
    $text['pwdagain'] = "Lozinka ponovo";
    $text['enterpassword2'] = "Molim unesite va�u lozinku ponovo.";
    $text['pwdsmatch'] = "Va�e lozinke ne podudaraju.  Molim unesite istu lozinku u svako polje.";
    //added in 8.0.0
    $text['acksubject'] = "Hvala vam za registraciju"; //for a new user account
    $text['ackmessage'] = "Va� zahtjev za korisni�ki ra�un zaprimljena. Va� ra�un �e biti neaktivan dok ga ne pregleda administrator web stranice. Biti �ete obavije�teni putem email kada je Va�a prijava spreman za upotrebu.";
    //added in 12.0.0
    $text['switch'] = "Switch";
    break;

  //added in 10.0.0
  case "branches":
    $text['browseallbranches'] = "Browse All Branches";
    break;

  //statistics.php
  case "stats":
    $text['quantity'] = "Koli�ina";
    $text['totindividuals'] = "Ukupno osoba";
    $text['totmales'] = "Ukupno mu�karaca";
    $text['totfemales'] = "Ukupno �ena";
    $text['totunknown'] = "Ukupno nepoznatih spolova";
    $text['totliving'] = "Ukuno �ivu�ih";
    $text['totfamilies'] = "Ukupno obitelji";
    $text['totuniquesn'] = "Ukupno jedinstvenih prezimena";
    //$text['totphotos'] = "Total Photos";
    //$text['totdocs'] = "Total Histories &amp; Documents";
    //$text['totheadstones'] = "Total Headstones";
    $text['totsources'] = "Ukupno izvora";
    $text['avglifespan'] = "Prosje�ni �ivotni vijek";
    $text['earliestbirth'] = "Najranije ro�enje";
    $text['longestlived'] = "Najdu�e �ivio";
    $text['days'] = "dana";
    $text['age'] = "starost";
    $text['agedisclaimer'] = "Izra�un baziran na starosti je zasnovan na osobama sa upisanim datumima ro�enja <EM>i</EM> smrti. Zbog nekompletiranih podataka u poljima za datum (npr., datum smrti je prikazan samo kao \"1945\" ili \"BEF 1860\"), ove kalkulacije ne mogu biti 100% to�ne.";
    $text['treedetail'] = "Vi�e informacija o ovom stablu";
    $text['total'] = "Ukupno";
    //added in 12.0
    $text['totdeceased'] = "Total Deceased";
    break;

  case "notes":
    $text['browseallnotes'] = "Pretra�i sve zabilje�ke";
    break;

  case "help":
    $text['menuhelp'] = "Klju� Menija";
    break;

  case "install":
    $text['perms'] = "Dozvole su svi bili postavili.";
    $text['noperms'] = "Dozvole nisu mogle biti postavljena za ove datoteke:";
    $text['manual'] = "Molim da ih ru�no postavite.";
    $text['folder'] = "Mapa";
    $text['created'] = "je stoverena";
    $text['nocreate'] = "nije mogla se stvoriti.  Molimo kreirajte ga ru�no.";
    $text['infosaved'] = "Informacije spremljene, veza provjerena!";
    $text['tablescr'] = "Tablice su stvoreni!";
    $text['notables'] = "Sljede�e tablice nisu se mogle stvoriti:";
    $text['nocomm'] = "TNG ne komunicira s Va�om bazom podataka.  Nijedne tablice su stvorene.";
    $text['newdb'] = "Informacije spremljene, veza provjerena, nova baza podataka stvorena:";
    $text['noattach'] = "Informacije spremljene, veza provjerena i nova baza podataka stvorena, ali TNG ne mo�e prilo�iti za njega.";
    $text['nodb'] = "Informacije spremljene.  Veza provjerena, a baza podataka ne postoji i nije mogla se tu stvoriti.  Molimo provjerite je li naziv baze podataka to�na, ili pomo�u upravlja�ke plo�e da ga stvorite.";
    $text['noconn'] = "Informacije spremljene ali veza nije uspjela.  Jedna ili vi�e od sljede�ih je kriv:";
    $text['exists'] = "postoji";
    $text['loginfirst'] = "Morate se prvo logovati.";
    $text['noop'] = "Nije u�injen operativni zahvat.";
    //added in 8.0.0
    $text['nouser'] = "Korisnik nije stvoren. Korisni�ko ime ve� postoji.";
    $text['notree'] = "Stablo nije stvoren. Stablo ID mo�da ve� postoji.";
    $text['infosaved2'] = "Informacije spremljene";
    $text['renamedto'] = "preimenovana u";
    $text['norename'] = "nije moglo se preimenovati";
    break;

  case "imgviewer":
    $text['zoomin'] = "Pribli�i";
    $text['zoomout'] = "Udalji";
    $text['magmode'] = "Moda Uve�avati";
    $text['panmode'] = "Moda Pomicanje";
    $text['pan'] = "Kliknite i povucite za pomicanje unutar slike";
    $text['fitwidth'] = "Pristaj �irini";
    $text['fitheight'] = "Pristaj Visini";
    $text['newwin'] = "Novi prozor";
    $text['opennw'] = "Otvori sliku u novi prozor";
    $text['magnifyreg'] = "Kliknite pove�ati jedno podru�je slike";
    $text['imgctrls'] = "Omogu�i Kontrole Slike";
    $text['vwrctrls'] = "Omogu�i Kontrole Razglednika Slike";
    $text['vwrclose'] = "Zatvori Razglednik Slika";
    break;

  case "dna":
    $text['test_date'] = "Test date";
    $text['links'] = "Relevant links";
    $text['testid'] = "Test ID";
    //added in 12.0.0
    $text['mode_values'] = "Mode Values";
    $text['compareselected'] = "Compare Selected";
    $text['dnatestscompare'] = "Compare Y-DNA Tests";
    $text['keep_name_private'] = "Keep Name Private";
    $text['browsealltests'] = "Browse All Tests";
    $text['all_dna_tests'] = "All DNA tests";
    $text['fastmutating'] = "Fast&nbsp;Mutating";
    $text['alltypes'] = "All Types";
    $text['allgroups'] = "All Groups";
    $text['Ydna_LITbox_info'] = "Test(s) linked to this person were not necessarily taken by this person.<br>The 'Haplogroup' column displays data in red if the result is 'Predicted' or green if the test is 'Confirmed'";
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
$text['matches'] = "Podudarnosti";
$text['description'] = "Opis";
$text['notes'] = "Zabilje�ke";
$text['status'] = "Status";
$text['newsearch'] = "Novo pretra�ivanje";
$text['pedigree'] = "Porijeklo";
$text['seephoto'] = "Vidi fotografiju";
$text['andlocation'] = "&amp; lokacija";
$text['accessedby'] = "pristupao";
$text['family'] = "Obitelj"; //from getperson
$text['children'] = "Djeca";  //from getperson
$text['tree'] = "Stablo";
$text['alltrees'] = "Sva stabla";
$text['nosurname'] = "[nema prezimena]";
$text['thumb'] = "Sli�ica";  //as in Thumbnail
$text['people'] = "Ljudi";
$text['title'] = "Naslov";  //from getperson
$text['suffix'] = "Sufiks";  //from getperson
$text['nickname'] = "Nadimak";  //from getperson
$text['lastmodified'] = "Zadnji koji je modificiran";  //from getperson
$text['married'] = "O�enjen";  //from getperson
//$text['photos'] = "Photos";
$text['name'] = "Ime"; //from showmap
$text['lastfirst'] = "Prezime, Ime(na)";  //from search
$text['bornchr'] = "Roden/Kr�ten";  //from search
$text['individuals'] = "Osoba";  //from whats new
$text['families'] = "Obitelji";
$text['personid'] = "ID osobe";
$text['sources'] = "Izvori";  //from getperson (next several)
$text['unknown'] = "Nepoznat";
$text['father'] = "Otac";
$text['mother'] = "Majka";
$text['christened'] = "Kr�ten";
$text['died'] = "Umro";
$text['buried'] = "Ukopan";
$text['spouse'] = "Supruga";  //from search
$text['parents'] = "Roditelji";  //from pedigree
$text['text'] = "Tekst";  //from sources
$text['language'] = "Jezik";  //from languages
$text['descendchart'] = "Potomci";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Osoba";
$text['edit'] = "Uredi";
$text['date'] = "Datum";
$text['place'] = "Mjesto";
$text['login'] = "Login";
$text['logout'] = "Logout";
$text['groupsheet'] = "Grupni List";
$text['text_and'] = "i";
$text['generation'] = "Generacija";
$text['filename'] = "Ime datoteke";
$text['id'] = "ID";
$text['search'] = "Tra�i";
$text['user'] = "Korisnik";
$text['firstname'] = "Ime";
$text['lastname'] = "Prezime";
$text['searchresults'] = "Pretra�i rezultate";
$text['diedburied'] = "Umro/Ukopan";
$text['homepage'] = "Po�etna Stranica";
$text['find'] = "Na�i...";
$text['relationship'] = "Veza";    //in German, Verwandtschaft
$text['relationship2'] = "Veza"; //different in some languages, at least in German (Beziehung)
$text['timeline'] = "Vremenska linija";
$text['yesabbr'] = "D";               //abbreviation for 'yes'
$text['divorced'] = "Razveden";
$text['indlinked'] = "Vezan za";
$text['branch'] = "Grana";
$text['moreind'] = "Vi�e osoba";
$text['morefam'] = "Vi�e obitelji";
$text['source'] = "Izvor";
$text['surnamelist'] = "Lista prezimena";
$text['generations'] = "Generacije";
$text['refresh'] = "Osvje�i";
$text['whatsnew'] = "�to je novo dodano";
$text['reports'] = "Izvje��a";
$text['placelist'] = "Lista mjesta";
$text['baptizedlds'] = "Kr�ten (LDS)";
$text['endowedlds'] = "Endowed (LDS)";
$text['sealedplds'] = "Sealed P (LDS)";
$text['sealedslds'] = "Sealed S (LDS)";
$text['ancestors'] = "Pretci";
$text['descendants'] = "Djeca";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Datum zadnjeg GEDCOM uvoza";
$text['type'] = "Tip";
$text['savechanges'] = "Pohrani promjene";
$text['familyid'] = "ID obitelji";
$text['headstone'] = "Nadgrobni spomenik";
$text['historiesdocs'] = "Povijesti";
$text['anonymous'] = "anoniman";
$text['places'] = "Mjesta";
$text['anniversaries'] = "Datumi & Obljetnice";
$text['administration'] = "Administracija";
$text['help'] = "Pomo�";
//$text['documents'] = "Documents";
$text['year'] = "Godina";
$text['all'] = "Svi";
$text['repository'] = "Repozitorij";
$text['address'] = "Adrese";
$text['suggest'] = "Sugestija";
$text['editevent'] = "Predlo�i promjenu za ovaj dogadaj";
$text['findplaces'] = "Prona�i sve osobe koji imaju doga�aje na ovoj lokaciji";
$text['morelinks'] = "Vi�e linkova";
$text['faminfo'] = "Obiteljska informacija";
$text['persinfo'] = "Osobna informacija";
$text['srcinfo'] = "Izvor informacija";
$text['fact'] = "�injenice";
$text['goto'] = "Selektiraj stranicu";
$text['tngprint'] = "Print";
$text['databasestatistics'] = "Statistike"; //needed to be shorter to fit on menu
$text['child'] = "Dijete";  //from familygroup
$text['repoinfo'] = "Informcija Repozitorije";
$text['tng_reset'] = "Vrati u po�etno stanje";
$text['noresults'] = "Rezultati nisu na�eni";
$text['allmedia'] = "Sve Medije";
$text['repositories'] = "Repozitorije";
$text['albums'] = "Albumi";
$text['cemeteries'] = "Groblja";
$text['surnames'] = "Prezimena";
$text['dates'] = "Datumi";
$text['link'] = "Linkovi";
$text['media'] = "Mediji";
$text['gender'] = "Spol";
$text['latitude'] = "Geografska �irina";
$text['longitude'] = "Geografska Du�ina";
$text['bookmarks'] = "Oznaka";
$text['bookmark'] = "Dodaj Oznaku";
$text['mngbookmarks'] = "Idi na Oznake";
$text['bookmarked'] = "Oznak dodan";
$text['remove'] = "Obri�i";
$text['find_menu'] = "Na�i";
$text['info'] = "Info"; //this needs to be a very short abbreviation
$text['cemetery'] = "Groblja";
$text['gmapevent'] = "Karta doga�aja";
$text['gevents'] = "Doga�aj";
$text['glang'] = "&amp;hl=hr";
$text['googleearthlink'] = "Link na Google Earth";
$text['googlemaplink'] = "Link na Google Maps";
$text['gmaplegend'] = "Legenda Igle";
$text['unmarked'] = "Nije ozna�eno";
$text['located'] = "Locirano";
$text['albclicksee'] = "Kliknite da vidite sve stavke iz ovog albuma";
$text['notyetlocated'] = "Ne jo� na�eno";
$text['cremated'] = "Spaljen";
$text['missing'] = "Fali";
$text['pdfgen'] = "PDF Generator";
$text['blank'] = "Prazan Dijagram";
$text['none'] = "Ni�ta";
$text['fonts'] = "Fontovi";
$text['header'] = "Zaglavlje";
$text['data'] = "Podaci";
$text['pgsetup'] = "Postavke Stranice";
$text['pgsize'] = "Veli�ina Stranice";
$text['orient'] = "Orientacija"; //for a page
$text['portrait'] = "Uspravno";
$text['landscape'] = "Vodoravno";
$text['tmargin'] = "Gornja Margina";
$text['bmargin'] = "Donja Margina";
$text['lmargin'] = "Lijeva Margin";
$text['rmargin'] = "Desna Margin";
$text['createch'] = "Kreiraj Dijagram";
$text['prefix'] = "Prefiks";
$text['mostwanted'] = "Naj �eljeni";
$text['latupdates'] = "Najnovije Dopune";
$text['featphoto'] = "Prikazana Fotografija";
$text['news'] = "Vjesti";
$text['ourhist'] = "Na�a Obiteljska Povijest";
$text['ourhistanc'] = "Na�a Obiteljska Povijest i Porijeklo";
$text['ourpages'] = "Stranice Genealogije Na�e Obitelj";
$text['pwrdby'] = "Ova stranica omogu�ena sa";
$text['writby'] = "napisao";
$text['searchtngnet'] = "Tra�i TNG Mre�u (GENDEX)";
$text['viewphotos'] = "Vidi sve fotografije";
$text['anon'] = "Trenutno ste anonimni";
$text['whichbranch'] = "Od koje grane ste vi?";
$text['featarts'] = "Izabrani �lanci";
$text['maintby'] = "Izdr�ava";
$text['createdon'] = "Kreirano na";
$text['reliability'] = "Pouzdanost";
$text['labels'] = "Oznake";
$text['inclsrcs'] = "Uklju�i Izvore";
$text['cont'] = "(dalje)"; //abbreviation for continued
$text['mnuheader'] = "Po�etna Stranica";
$text['mnusearchfornames'] = "Tra�i Imena";
$text['mnulastname'] = "Prezime";
$text['mnufirstname'] = "Ime";
$text['mnusearch'] = "Tra�i";
$text['mnureset'] = "Po�ni ispo�etka";
$text['mnulogon'] = "Login";
$text['mnulogout'] = "Logout";
$text['mnufeatures'] = "Ostale opcije";
$text['mnuregister'] = "Registriraj se za korisnicki ra�un";
$text['mnuadvancedsearch'] = "Napredno pretra�ivanje";
$text['mnulastnames'] = "Prezimena";
$text['mnustatistics'] = "Statistika";
$text['mnuphotos'] = "Fotografije";
$text['mnuhistories'] = "Povijest";
$text['mnumyancestors'] = "Fotografije &amp; Povijest predaka od [Person]";
$text['mnucemeteries'] = "Groblja";
$text['mnutombstones'] = "Nadgobni spomenici";
$text['mnureports'] = "Izvje�ca";
$text['mnusources'] = "Izvori";
$text['mnuwhatsnew'] = "�to je novog";
$text['mnushowlog'] = "Zapis pristupa";
$text['mnulanguage'] = "Promijeni jezik";
$text['mnuadmin'] = "Administracija";
$text['welcome'] = "Dobrodo�li";
$text['contactus'] = "Kontaktirajte nas";
//changed in 8.0.0
$text['born'] = "Ro�en";
$text['searchnames'] = "Tra�i imena";
//added in 8.0.0
$text['editperson'] = "Uredi Osobu";
$text['loadmap'] = "U�itaj kartu";
$text['birth'] = "Ro�enje";
$text['wasborn'] = "je ro�en/ro�ena";
$text['startnum'] = "Prvi Broj";
$text['searching'] = "Pretra�ivanje";
//moved here in 8.0.0
$text['location'] = "Lokacija";
$text['association'] = "Asocijacija";
$text['collapse'] = "Skupi";
$text['expand'] = "Ekspandiraj";
$text['plot'] = "Iscrtaj";
$text['searchfams'] = "Tra�i Obitelji";
//added in 8.0.2
$text['wasmarried'] = "O�enjen";
$text['anddied'] = "Umro";
//added in 9.0.0
$text['share'] = "Share";
$text['hide'] = "Hide";
$text['disabled'] = "Your user account has been disabled. Please contact the site administrator for more information.";
$text['contactus_long'] = "If you have any questions or comments about the information on this site, please <span class=\"emphasis\"><a href=\"suggest.php\">contact us</a></span>. We look forward to hearing from you.";
$text['features'] = "Features";
$text['resources'] = "Resources";
$text['latestnews'] = "Latest News";
$text['trees'] = "Trees";
$text['wasburied'] = "was buried";
//moved here in 9.0.0
$text['emailagain'] = "Email ponovo";
$text['enteremail2'] = "Molim unesite Va�u email adresu ponovo.";
$text['emailsmatch'] = "Va�e email adrese ne podudaraju.  Molim unesite istu email adresu u svako polje.";
$text['getdirections'] = "Kliknite za dobiti upute";
$text['calendar'] = "Kalendar";
//changed in 9.0.0
$text['directionsto'] = " na ";
$text['slidestart'] = "Pokreni Pokaz Prezentacije";
$text['livingnote'] = "Najmanje jedna �ivu�a osoba je vezana za ovaj zapis - Detalji zadr�ani.";
$text['livingphoto'] = "Najmanje jedna �ivu�a osoba je vezana za ovaj item - detalji pridr�ani.";
$text['waschristened'] = "Kr�ten";
//added in 10.0.0
$text['branches'] = "Branches";
$text['detail'] = "Detail";
$text['moredetail'] = "More detail";
$text['lessdetail'] = "Less detail";
$text['otherevents'] = "Ostali doga�aji";
$text['conflds'] = "Confirmed (LDS)";
$text['initlds'] = "Initiatory (LDS)";
$text['wascremated'] = "was cremated";
//moved here in 11.0.0
$text['text_for'] = "za";
//added in 11.0.0
$text['searchsite'] = "Search this site";
$text['searchsitemenu'] = "Search Site";
$text['kmlfile'] = "Download a .kml file to show this location in Google Earth";
$text['download'] = "Click to download";
$text['more'] = "Vi�e";
$text['heatmap'] = "Heat Map";
$text['refreshmap'] = "Refresh Map";
$text['remnums'] = "Clear Numbers and Pins";
$text['photoshistories'] = "Photos &amp; Histories";
$text['familychart'] = "Family Chart";
//added in 12.0.0
$text['firstnames'] = "First Names";
//moved here in 12.0.0
$text['dna_test'] = "DNA Test";
$text['test_type'] = "Test type";
$text['test_info'] = "Test Information";
$text['takenby'] = "Taken by";
$text['haplogroup'] = "Haplogroup";
$text['hvr1'] = "HVR1";
$text['hvr2'] = "HVR2";
$text['relevant_links'] = "Relevant links";
$text['nofirstname'] = "[no first name]";
//added in 12.0.1
$text['cookieuse'] = "Note: This site uses cookies.";
$text['dataprotect'] = "Data Protection Policy";
$text['viewpolicy'] = "View policy";
$text['understand'] = "I understand";
$text['consent'] = "I give my consent for this site to store the personal information collected here. I understand that I may ask the site owner to remove this information at any time.";
$text['consentreq'] = "Please give your consent for this site to store personal information.";

//added in 12.1.0
$text['testsarelinked'] = "DNA tests are associated with";
$text['testislinked'] = "DNA test is associated with";

//added in 12.2
$text['quicklinks'] = "Brze veze";
$text['yourname'] = "Va�e ime";
$text['youremail'] = "Va�a adresa e-po�te";
$text['liketoadd'] = "Sve informacije koje �elite dodati";
$text['webmastermsg'] = "Poruka webmastera";
$text['gallery'] = "Pogledajte galeriju";
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
$text['dna_info_head'] = "DNA Test Info";
$text['firstpage'] = "Prva stranica";
$text['lastpage'] = "Zadnja stranica";

@include_once "captcha_text.php";
@include_once "alltext.php";
if (!$alltextloaded) {
  getAllTextPath();
}

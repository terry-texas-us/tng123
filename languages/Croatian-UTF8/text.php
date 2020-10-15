<?php
switch ($textpart) {
    //browsesources.php, showsource.php
    case "sources":
        $text['browseallsources'] = "Pretraži sve izvore";
        $text['shorttitle'] = "Kratki naslov";
        $text['callnum'] = "Pozivni broj";
        $text['author'] = "Autor";
        $text['publisher'] = "Izdavac";
        $text['other'] = "Ostale informacije";
        $text['sourceid'] = "Source ID";
        $text['moresrc'] = "Još izvora";
        $text['repoid'] = "Repository ID";
        $text['browseallrepos'] = "Pretraži sve Repositories";
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
        $text['gedstart'] = "GEDCOM pocinje od";
        $text['producegedfrom'] = "Proizvedi GEDCOM datoteku od";
        $text['numgens'] = "Broj generacija";
        $text['includelds'] = "Ukljuci LDS informaciju";
        $text['buildged'] = "Build GEDCOM";
        $text['gedstartfrom'] = "GEDCOM pocetna forma";
        $text['nomaxgen'] = "Morate naznaciti maksimalni broj generacija. Molim koristite tipku Natrag za povratak na prethodnu stranicu i ispravite pogrešku";
        $text['gedcreatedfrom'] = "GEDCOM kreirana forma";
        $text['gedcreatedfor'] = "kreirano za";
        $text['creategedfor'] = "Kreiraj GEDCOM";
        $text['email'] = "E-mail adresa";
        $text['suggestchange'] = "Predloži promjenu";
        $text['yourname'] = "Vaše ime";
        $text['comments'] = "Komentar";
        $text['comments2'] = "Komentar";
        $text['submitsugg'] = "Pošalji prijedlog";
        $text['proposed'] = "Predložena promjena";
        $text['mailsent'] = "Hvala. Vaša je poruka isporucena.";
        $text['mailnotsent'] = "Žao nam je, ali vaša poruka ne može biti isporucena. Molim kontaktirajte me direktno na mbralic@gmail.com.";
        $text['mailme'] = "Pošalji kopiju od ove adrese";
        $text['entername'] = "Molim unesite vaše ime";
        $text['entercomments'] = "Molim unesite vaš komentar";
        $text['sendmsg'] = "Pošalji poruku";
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
        $text['suggested'] = "Predloženo";
        $text['closewindow'] = "Zatvori ovaj prozor";
        $text['thanks'] = "Hvala";
        $text['received'] = "Vaša sugestija je prosljedena administratoru web site-a na uvid.";
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
        $text['findrel'] = "Nadi rodbinsku vezu";
        $text['person1'] = "Osoba 1:";
        $text['person2'] = "Osoba 2:";
        $text['calculate'] = "Izracunaj";
        $text['select2inds'] = "Molim izaberite dvije osobe.";
        $text['findpersonid'] = "Nadi ID osobe";
        $text['enternamepart'] = "unesi dio imena i/ili prezimena";
        $text['pleasenamepart'] = "Molim unesite dio imena ili prezimena.";
        $text['clicktoselect'] = "klikni za izbor";
        $text['nobirthinfo'] = "Fali informacija o rodenju";
        $text['relateto'] = "Rodbinska veza";
        $text['sameperson'] = "Dvije osobe su jedna te ista osoba.";
        $text['notrelated'] = "Dvije osobe nisu u vezi sa xxx generacija."; //xxx will be replaced with number of generations
        $text['findrelinstr'] = "Za prikazati obiteljsku vezu izmedu dvije osobe, koristi 'Find' tipku dolje da bi locirali osobe (ili nastavi prikazivati osobe), zatim klikni na 'Kalkuliraj'.";
        $text['sometimes'] = "(Ponekad provjera medu razlicitim brojevima generacija daje razlicite rezultate.)";
        $text['findanother'] = "Nadi drugu rodbinsku vezu";
        $text['brother'] = "brat od";
        $text['sister'] = "sestra od";
        $text['sibling'] = "potomak od";
        $text['uncle'] = "xxx je ujak od";
        $text['aunt'] = "xxx je tetka od";
        $text['uncleaunt'] = "xxx je ujak/tetka od";
        $text['nephew'] = "xxx je necak od";
        $text['niece'] = "xxx je necakinja od";
        $text['nephnc'] = "xxx je necak/necakinja od";
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
        $text['great'] = "veci";
        $text['spouses'] = "su supruge";
        $text['is'] = "je";
        $text['changeto'] = "Promijeni u (unesi ID):";
        $text['notvalid'] = "nije valjan broj osobnog ID-a ili ne postoji u ovoj bazi podataka. Molim pokušajte ponovo.";
        $text['halfbrother'] = "the half brother of";
        $text['halfsister'] = "the half sister of";
        $text['halfsibling'] = "the half sibling of";
        //changed in 8.0.0
        $text['gencheck'] = "Max generacija<br>za provjeru";
        $text['mcousin'] = "xxx je bratic yyy od";  //male cousin; xxx = cousin number, yyy = times removed
        $text['fcousin'] = "xxx je sestricna yyy od";  //female cousin
        $text['cousin'] = "xxx je rodak yyy od";
        $text['mhalfcousin'] = "xxx pola bratic yyy od";  //male cousin
        $text['fhalfcousin'] = "xxx pola sestricna yyy od";  //female cousin
        $text['halfcousin'] = "xxx pola rodak yyy od";
        //added in 8.0.0
        $text['oneremoved'] = "jedna generacija odmaknut";
        $text['gfath'] = "xxx djed od";
        $text['gmoth'] = "xxx baka od";
        $text['gpar'] = "xxx djed/baka od";
        $text['mothof'] = "majka od";
        $text['fathof'] = "otac od";
        $text['parof'] = "roditelj od";
        $text['maxrels'] = "Maximalni broj veza pokazati";
        $text['dospouses'] = "Pokaži veze koje se ticu supruge";
        $text['rels'] = "Veze";
        $text['dospouses2'] = "Pokaži Supruge";
        $text['fil'] = "svekar od";
        $text['mil'] = "svekrva od";
        $text['fmil'] = "svekar ili svekrva od";
        $text['stepson'] = "posinak od";
        $text['stepdau'] = "pocerka od";
        $text['stepchild'] = "pastorce od";
        $text['stepgson'] = "the xxx step-grandson of";
        $text['stepgdau'] = "the xxx step-granddaughter of";
        $text['stepgchild'] = "the xxx step-grandchild of";
        //added in 8.1.1
        $text['ggreat'] = "veci";
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
        $text['baptizedlds'] = "Kršten (LDS)";
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
        $text['scrollnote'] = "Bilješke: Možete skrolovati dolje ili desno za vidjeti tablu.";
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
        $text['daughterof'] = "kci od";
        $text['childof'] = "dijete od";
        $text['stdformat'] = "Standardni Format";
        $text['ahnentafel'] = "Ahnentafel";
        $text['addnewfam'] = "Dodaj novu obitelj";
        $text['editfam'] = "Uredi obitelj";
        $text['side'] = "Strana";
        $text['familyof'] = "Obitelj od";
        $text['paternal'] = "Ocev";
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
        $text['borchr'] = "Rodenje/Alt - Smrt/Pogreb (dva)";
        $text['nobd'] = "Nema Datume Rodenja ili Smrti";
        $text['bcdb'] = " Rodenje/Alt/Smrt/Pogreb (cetri)";
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
        $text['noreports'] = "Izvješce ne postoji.";
        $text['reportname'] = "Naziv izvješca";
        $text['allreports'] = "Sva izvješca";
        $text['report'] = "Izvješce";
        $text['error'] = "Greška";
        $text['reportsyntax'] = "Sintaksa upita se pokrece zajedno s ovim izvješcem";
        $text['wasincorrect'] = "je pogrešno, i kao rezultat izvješce se ne može pokrenuti. Molim da kontaktirate administratora sustava";
        $text['errormessage'] = "Poruka Greške";
        $text['equals'] = "jednako";
        $text['endswith'] = "završava sa";
        $text['soundexof'] = "Soundex od";
        $text['metaphoneof'] = "metafon od";
        $text['plusminus10'] = "+/- 10 godina od";
        $text['lessthan'] = "manje nego";
        $text['greaterthan'] = "vece od";
        $text['lessthanequal'] = "manje ili jednako od";
        $text['greaterthanequal'] = "vece ili jednako za";
        $text['equalto'] = "jednako";
        $text['tryagain'] = "Molim pokušajte ponovo";
        $text['joinwith'] = "Spoji sa";
        $text['cap_and'] = "I";
        $text['cap_or'] = "ILI";
        $text['showspouse'] = "Prikazana suprugu pokazat ce se kao duplikat ako osoba ima više od jedne supruge)";
        $text['submitquery'] = "Pošalji upit";
        $text['birthplace'] = "Mjesto rodenja";
        $text['deathplace'] = "Mjesto smrti";
        $text['birthdatetr'] = "Godina rodenja";
        $text['deathdatetr'] = "Godina smrti";
        $text['plusminus2'] = "+/- 2 godine od";
        $text['resetall'] = "Resetiraj sve vrijednosti";
        $text['showdeath'] = "Prikaži smrt/informaciju o pogrebu";
        $text['altbirthplace'] = "Mjesto Krštenja";
        $text['altbirthdatetr'] = "Godina Krštenja";
        $text['burialplace'] = "Mjesto ukopa";
        $text['burialdatetr'] = "Godina ukopa";
        $text['event'] = "Dogadaj(i)";
        $text['day'] = "Dan";
        $text['month'] = "Mjesec";
        $text['keyword'] = "Kljucna rijec (npr, \"Popr\")";
        $text['explain'] = "Unesi komponente datuma da bi vidio dogadaje koji se slažu. Ostavi prazno polje da bi vidjio sve dogadaje koji se slažu.";
        $text['enterdate'] = "Molim unesi ili odaberi najmanje jedan podatak: Dan, Mjesec, Godina, kljucna rijec";
        $text['fullname'] = "Puno ime";
        $text['birthdate'] = "Datum rodenja";
        $text['altbirthdate'] = "Datum krštenja";
        $text['marrdate'] = "Datum vjencanja";
        $text['spouseid'] = "Suprugin ID";
        $text['spousename'] = "Suprugino ime";
        $text['deathdate'] = "Datum smrti";
        $text['burialdate'] = "Datum ukopa";
        $text['changedate'] = "Datum zadnje modifikacije";
        $text['gedcom'] = "Stablo";
        $text['baptdate'] = "Datum krštenja (LDS)";
        $text['baptplace'] = "Mjeto krštenja (LDS)";
        $text['endldate'] = "Endowment Date (LDS)";
        $text['endlplace'] = "Endowment Place (LDS)";
        $text['ssealdate'] = "Seal Date S (LDS)";   //Sealed to spouse
        $text['ssealplace'] = "Seal Place S (LDS)";
        $text['psealdate'] = "Seal Date P (LDS)";   //Sealed to parents
        $text['psealplace'] = "Seal Place P (LDS)";
        $text['marrplace'] = "Mjesto vjencanja";
        $text['spousesurname'] = "Prezime supruge";
        $text['spousemore'] = "Ako unesete vrijednost supruginog prezimena, morate unijeti vrijednost u najmanje još jedno polje.";
        $text['plusminus5'] = "+/- 5 godina od";
        $text['exists'] = "postoji";
        $text['dnexist'] = "ne postoji";
        $text['divdate'] = "Datum Razvoda";
        $text['divplace'] = "Mjesto Razvoda";
        $text['otherevents'] = "Ostali dogadaji";
        $text['numresults'] = "Rezultati po stranici";
        $text['mysphoto'] = "Misteriozne Fotografije";
        $text['mysperson'] = "Nedostižani Ljudi";
        $text['joinor'] = "Opcija 'Sastavi sa ILI' se nemože upotrebiti sa Prezime Supruge";
        $text['tellus'] = "Recite nam što znate";
        $text['moreinfo'] = "Više Informacije:";
        //added in 8.0.0
        $text['marrdatetr'] = "Godina Vjecanja";
        $text['divdatetr'] = "Godina Razvoda";
        $text['mothername'] = "Ime Majke";
        $text['fathername'] = "Ime Otca";
        $text['filter'] = "Filtar";
        $text['notliving'] = "Ne Živuci";
        $text['nodayevents'] = "Dogadaji za ovaj mjesec koje nisu vezane uz odredeni dan:";
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
        $text['autorefresh'] = "Automatsko osvježavanje (30 sekundi)";
        $text['refreshoff'] = "Iskljuci automatsko osvježivanje";
        break;

    case "headstones":
    case "showphoto":
        $text['cemeteriesheadstones'] = "Groblja i nadgrobni spomenici";
        $text['showallhsr'] = "Prikaži sve podatke o nadgrobnim spomenicima";
        $text['in'] = "u";
        $text['showmap'] = "Prikaži mapu";
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
        $text['iptc101'] = "Država";
        $text['iptc103'] = "OTR";
        $text['iptc105'] = "Naslov";
        $text['iptc110'] = "Izvor";
        $text['iptc115'] = "Izvor Fotografije";
        $text['iptc116'] = "Obavijest o autorskim pravima";
        $text['iptc120'] = "Naslov";
        $text['iptc122'] = "Pisac Naslova";
        $text['mapof'] = "Karta od";
        $text['regphotos'] = "Deskriptivan pogled";
        $text['gallery'] = "Slicice Samo";
        $text['cemphotos'] = "Fotografije groblja";
        $text['photosize'] = "Dimenzije";
        $text['iptc010'] = "Prioritet";
        $text['filesize'] = "Velicina datoteke";
        $text['seeloc'] = "Vidi lokaciju";
        $text['showall'] = "Prikaži sve";
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
        $text['nostate'] = "Nepoznata Država";
        $text['nocounty'] = "Nepoznata Županija";
        $text['nocity'] = "Nepoznati Grad";
        $text['nocemname'] = "Nepoznato ime groblja";
        $text['editalbum'] = "Uredi Album";
        $text['mediamaptext'] = "<strong>Poruka:</strong> Maknite vaš pokazivac miša preko slike za pokazati imena. Kliknite za viditi stranicu za svako ime.";
        //added in 8.0.0
        $text['allburials'] = "Sve sahrane";
        $text['moreinfo'] = "Više Informacije:";
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
        $text['surnamesstarting'] = "Prikaži prezimena koja pocinju sa";
        $text['showtop'] = "Prikaži prvih";
        $text['showallsurnames'] = "Prikaži sva prezimena";
        $text['sortedalpha'] = "sortiraj abecedno";
        $text['byoccurrence'] = "sortiranih po pojavljivanju";
        $text['firstchars'] = "Prvi znakovi";
        $text['mainsurnamepage'] = "Glavna stranica prezimena";
        $text['allsurnames'] = "Sva prezimena";
        $text['showmatchingsurnames'] = "Kliknite na prezime za vidjeti polja koja se slažu.";
        $text['backtotop'] = "Nazad na vrh";
        $text['beginswith'] = "Pocinje sa";
        $text['allbeginningwith'] = "Sva prezimena pocinju sa";
        $text['numoccurrences'] = "broj pojavljivanja u zagradama";
        $text['placesstarting'] = "Prikaži najveci lokalitet koji pocinje s";
        $text['showmatchingplaces'] = "Klikni na mjesto ako želiš prikazati manji lokalitet. Klikni na ikonu pretrage ako želiš prikazati osobe koje se slažu.";
        $text['totalnames'] = "ukupno osoba";
        $text['showallplaces'] = "Prikaži sve najvece lokalitete";
        $text['totalplaces'] = "ukupno mjesta";
        $text['mainplacepage'] = "Stranica glavnih mjesta";
        $text['allplaces'] = "Svi najveci lokaliteti";
        $text['placescont'] = "Prikaži sva mjesta koja sadrže";
        //changed in 8.0.0
        $text['top30'] = "Najbrojnija xxx prezimena";
        $text['top30places'] = "Najbrojnija xxx veca mjesta";
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
        $text['text_delete'] = "Obriši";
        $text['addperson'] = "Dodaj osobu";
        $text['nobirth'] = "Ova osoba nema valjani datum rodenja i ne može biti dodana";
        $text['event'] = "Dogadaj(i)";
        $text['chartwidth'] = "Širina table";
        $text['timelineinstr'] = "Dodaj ljude";
        $text['togglelines'] = "Dozvoli crte";
        //changed in 9.0.0
        $text['noliving'] = "Slijedeca osoba je oznacena kao živuca i ne može biti dodana zbog toga što nisi logiran s odgovarajucim ovlastima";
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
        $text['state'] = "Država/Pokrajina";
        $text['zip'] = "Poštanski broj";
        $text['country'] = "Zemlja";
        $text['email'] = "E-mail adresa";
        $text['phone'] = "Telefon";
        $text['username'] = "Korisnicko Ime";
        $text['password'] = "Lozinka";
        $text['loginfailed'] = "Login nije uspio.";

        $text['regnewacct'] = "Registriraj se za novi korisnicki account";
        $text['realname'] = "Vaše stvarno ime";
        $text['phone'] = "Telefon";
        $text['email'] = "E-mail adresa";
        $text['address'] = "Adrese";
        $text['acctcomments'] = "Komentar";
        $text['submit'] = "Uloži";
        $text['leaveblank'] = "(ostavi prazno ako zahtijevate novo stablo)";
        $text['required'] = "Potrebna polja";
        $text['enterpassword'] = "Molimo unesite zaporku.";
        $text['enterusername'] = "Molimo unesite korisnicko ime.";
        $text['failure'] = "Žao nam je, ali vaše korisnicko ime kojeg ste unijeli je vec korišteno. Molimo koristite Back button na vašem browser-u za povratak na prethodnu stanicu te odaberi drugacije korisnicko ime.";
        $text['success'] = "Hvala. Primili smo vašu registraciju. Kontaktirat cemo vas kada aktiviramo vaš account ili ako su potrebne dodatne informacije.";
        $text['emailsubject'] = "Novi zahtjev za registracijom od strane TNG korisnika";
        $text['website'] = "Web Stranica";
        $text['nologin'] = "Nemaš login?";
        $text['loginsent'] = "Login informacija poslata";
        $text['loginnotsent'] = "Login informacija nije poslata";
        $text['enterrealname'] = "Molimo unesite vaše realno ime.";
        $text['rempass'] = "Ostani logiran na ovom racunalu";
        $text['morestats'] = "Još statistike";
        $text['accmail'] = "<strong>NOTE:</strong> Molimo vas da ne blokirate mail s ove domene ako želite primati email-ove od sistem administratora u vezi vašeg account-a.";
        $text['newpassword'] = "Nova zaporka";
        $text['resetpass'] = "Resetiraj svoju zaporku";
        $text['nousers'] = "Ova forma ne može biti korištena sve dok postoji najmanje jedan korisnik. Ako ste vlasnik site-a, molim vas da kreirate vaš Administrator account iz Admin/Users.";
        $text['noregs'] = "Žao nam je, ali mi ne prihvacamo nove korisnicke registracije u ovom trenutku.  Molimo <a href=\"suggest.php\"> kontaktirajte nas </a> direktno ako imate komentare ili pitanja u vezi s bilo što na ovom mjestu. ";
        //changed in 8.0.0
        $text['emailmsg'] = "Primili ste novi zahtjev za otvaranje TNG korisnickog account-a. Molimo da se logirate na vaš TNG Admin account i dodijelite odgovarajuce ovlasti novom account-u. Ako odobrite ovu registraciju, molim da obavjestite aplikanta na nacin da odgovorite na ovu poruku.";
        $text['accactive'] = "Korisnicki racun je aktiviran, ali korisnik nece imati posebna prava dok ih ne dodijeliti.";
        $text['accinactive'] = "Idite na Admin/Korisnici/Pregled za pristup postavke racuna. Racun ce ostati neaktivan sve dok se ne uredi i spremi zapis barem jedanput.";
        $text['pwdagain'] = "Lozinka ponovo";
        $text['enterpassword2'] = "Molim unesite vašu lozinku ponovo.";
        $text['pwdsmatch'] = "Vaše lozinke ne podudaraju.  Molim unesite istu lozinku u svako polje.";
        //added in 8.0.0
        $text['acksubject'] = "Hvala vam za registraciju"; //for a new user account
        $text['ackmessage'] = "Vaš zahtjev za korisnicki racun zaprimljena. Vaš racun ce biti neaktivan dok ga ne pregleda administrator web stranice. Biti cete obaviješteni putem email kada je Vaša prijava spreman za upotrebu.";
        //added in 12.0.0
        $text['switch'] = "Switch";
        break;

    //added in 10.0.0
    case "branches":
        $text['browseallbranches'] = "Browse All Branches";
        break;

    //statistics.php
    case "stats":
        $text['quantity'] = "Kolicina";
        $text['totindividuals'] = "Ukupno osoba";
        $text['totmales'] = "Ukupno muškaraca";
        $text['totfemales'] = "Ukupno žena";
        $text['totunknown'] = "Ukupno nepoznatih spolova";
        $text['totliving'] = "Ukuno živucih";
        $text['totfamilies'] = "Ukupno obitelji";
        $text['totuniquesn'] = "Ukupno jedinstvenih prezimena";
        //$text['totphotos'] = "Total Photos";
        //$text['totdocs'] = "Total Histories &amp; Documents";
        //$text['totheadstones'] = "Total Headstones";
        $text['totsources'] = "Ukupno izvora";
        $text['avglifespan'] = "Prosjecni životni vijek";
        $text['earliestbirth'] = "Najranije rodenje";
        $text['longestlived'] = "Najduže živio";
        $text['days'] = "dana";
        $text['age'] = "starost";
        $text['agedisclaimer'] = "Izracun baziran na starosti je zasnovan na osobama sa upisanim datumima rodenja <EM>i</EM> smrti. Zbog nekompletiranih podataka u poljima za datum (npr., datum smrti je prikazan samo kao \"1945\" ili \"BEF 1860\"), ove kalkulacije ne mogu biti 100% tocne.";
        $text['treedetail'] = "Više informacija o ovom stablu";
        $text['total'] = "Ukupno";
        //added in 12.0
        $text['totdeceased'] = "Total Deceased";
        break;

    case "notes":
        $text['browseallnotes'] = "Pretraži sve zabilješke";
        break;

    case "help":
        $text['menuhelp'] = "Kljuc Menija";
        break;

    case "install":
        $text['perms'] = "Dozvole su svi bili postavili.";
        $text['noperms'] = "Dozvole nisu mogle biti postavljena za ove datoteke:";
        $text['manual'] = "Molim da ih rucno postavite.";
        $text['folder'] = "Mapa";
        $text['created'] = "je stoverena";
        $text['nocreate'] = "nije mogla se stvoriti.  Molimo kreirajte ga rucno.";
        $text['infosaved'] = "Informacije spremljene, veza provjerena!";
        $text['tablescr'] = "Tablice su stvoreni!";
        $text['notables'] = "Sljedece tablice nisu se mogle stvoriti:";
        $text['nocomm'] = "TNG ne komunicira s Vašom bazom podataka.  Nijedne tablice su stvorene.";
        $text['newdb'] = "Informacije spremljene, veza provjerena, nova baza podataka stvorena:";
        $text['noattach'] = "Informacije spremljene, veza provjerena i nova baza podataka stvorena, ali TNG ne može priložiti za njega.";
        $text['nodb'] = "Informacije spremljene.  Veza provjerena, a baza podataka ne postoji i nije mogla se tu stvoriti.  Molimo provjerite je li naziv baze podataka tocna, ili pomocu upravljacke ploce da ga stvorite.";
        $text['noconn'] = "Informacije spremljene ali veza nije uspjela.  Jedna ili više od sljedecih je kriv:";
        $text['exists'] = "postoji";
        $text['loginfirst'] = "Morate se prvo logovati.";
        $text['noop'] = "Nije ucinjen operativni zahvat.";
        //added in 8.0.0
        $text['nouser'] = "Korisnik nije stvoren. Korisnicko ime vec postoji.";
        $text['notree'] = "Stablo nije stvoren. Stablo ID možda vec postoji.";
        $text['infosaved2'] = "Informacije spremljene";
        $text['renamedto'] = "preimenovana u";
        $text['norename'] = "nije moglo se preimenovati";
        break;

    case "imgviewer":
        $text['zoomin'] = "Približi";
        $text['zoomout'] = "Udalji";
        $text['magmode'] = "Moda Uvecavati";
        $text['panmode'] = "Moda Pomicanje";
        $text['pan'] = "Kliknite i povucite za pomicanje unutar slike";
        $text['fitwidth'] = "Pristaj Širini";
        $text['fitheight'] = "Pristaj Visini";
        $text['newwin'] = "Novi prozor";
        $text['opennw'] = "Otvori sliku u novi prozor";
        $text['magnifyreg'] = "Kliknite povecati jedno podrucje slike";
        $text['imgctrls'] = "Omoguci Kontrole Slike";
        $text['vwrctrls'] = "Omoguci Kontrole Razglednika Slike";
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
$text['notes'] = "Zabilješke";
$text['status'] = "Status";
$text['newsearch'] = "Novo pretraživanje";
$text['pedigree'] = "Porijeklo";
$text['seephoto'] = "Vidi fotografiju";
$text['andlocation'] = "&amp; lokacija";
$text['accessedby'] = "pristupao";
$text['family'] = "Obitelj"; //from getperson
$text['children'] = "Djeca";  //from getperson
$text['tree'] = "Stablo";
$text['alltrees'] = "Sva stabla";
$text['nosurname'] = "[nema prezimena]";
$text['thumb'] = "Slicica";  //as in Thumbnail
$text['people'] = "Ljudi";
$text['title'] = "Naslov";  //from getperson
$text['suffix'] = "Sufiks";  //from getperson
$text['nickname'] = "Nadimak";  //from getperson
$text['lastmodified'] = "Zadnji koji je modificiran";  //from getperson
$text['married'] = "Oženjen";  //from getperson
//$text['photos'] = "Photos";
$text['name'] = "Ime"; //from showmap
$text['lastfirst'] = "Prezime, Ime(na)";  //from search
$text['bornchr'] = "Roden/Kršten";  //from search
$text['individuals'] = "Osoba";  //from whats new
$text['families'] = "Obitelji";
$text['personid'] = "ID osobe";
$text['sources'] = "Izvori";  //from getperson (next several)
$text['unknown'] = "Nepoznat";
$text['father'] = "Otac";
$text['mother'] = "Majka";
$text['christened'] = "Kršten";
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
$text['search'] = "Traži";
$text['user'] = "Korisnik";
$text['firstname'] = "Ime";
$text['lastname'] = "Prezime";
$text['searchresults'] = "Pretraži rezultate";
$text['diedburied'] = "Umro/Ukopan";
$text['homepage'] = "Pocetna Stranica";
$text['find'] = "Nadi...";
$text['relationship'] = "Veza";    //in German, Verwandtschaft
$text['relationship2'] = "Veza"; //different in some languages, at least in German (Beziehung)
$text['timeline'] = "Vremenska linija";
$text['yesabbr'] = "D";               //abbreviation for 'yes'
$text['divorced'] = "Razveden";
$text['indlinked'] = "Vezan za";
$text['branch'] = "Grana";
$text['moreind'] = "Više osoba";
$text['morefam'] = "Više obitelji";
$text['source'] = "Izvor";
$text['surnamelist'] = "Lista prezimena";
$text['generations'] = "Generacije";
$text['refresh'] = "Osvježi";
$text['whatsnew'] = "Što je novo dodano";
$text['reports'] = "Izvješca";
$text['placelist'] = "Lista mjesta";
$text['baptizedlds'] = "Kršten (LDS)";
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
$text['help'] = "Pomoc";
//$text['documents'] = "Documents";
$text['year'] = "Godina";
$text['all'] = "Svi";
$text['repository'] = "Repozitorij";
$text['address'] = "Adrese";
$text['suggest'] = "Sugestija";
$text['editevent'] = "Predloži promjenu za ovaj dogadaj";
$text['findplaces'] = "Pronadi sve osobe koji imaju dogadaje na ovoj lokaciji";
$text['morelinks'] = "Više linkova";
$text['faminfo'] = "Obiteljska informacija";
$text['persinfo'] = "Osobna informacija";
$text['srcinfo'] = "Izvor informacija";
$text['fact'] = "Cinjenice";
$text['goto'] = "Selektiraj stranicu";
$text['tngprint'] = "Print";
$text['databasestatistics'] = "Statistike"; //needed to be shorter to fit on menu
$text['child'] = "Dijete";  //from familygroup
$text['repoinfo'] = "Informcija Repozitorije";
$text['tng_reset'] = "Vrati u pocetno stanje";
$text['noresults'] = "Rezultati nisu nadeni";
$text['allmedia'] = "Sve Medije";
$text['repositories'] = "Repozitorije";
$text['albums'] = "Albumi";
$text['cemeteries'] = "Groblja";
$text['surnames'] = "Prezimena";
$text['dates'] = "Datumi";
$text['link'] = "Linkovi";
$text['media'] = "Mediji";
$text['gender'] = "Spol";
$text['latitude'] = "Geografska Širina";
$text['longitude'] = "Geografska Dužina";
$text['bookmarks'] = "Oznaka";
$text['bookmark'] = "Dodaj Oznaku";
$text['mngbookmarks'] = "Idi na Oznake";
$text['bookmarked'] = "Oznak dodan";
$text['remove'] = "Obriši";
$text['find_menu'] = "Nadi";
$text['info'] = "Info"; //this needs to be a very short abbreviation
$text['cemetery'] = "Groblja";
$text['gmapevent'] = "Karta dogadaja";
$text['gevents'] = "Dogadaj";
$text['glang'] = "&amp;hl=hr";
$text['googleearthlink'] = "Link na Google Earth";
$text['googlemaplink'] = "Link na Google Maps";
$text['gmaplegend'] = "Legenda Igle";
$text['unmarked'] = "Nije oznaceno";
$text['located'] = "Locirano";
$text['albclicksee'] = "Kliknite da vidite sve stavke iz ovog albuma";
$text['notyetlocated'] = "Ne još nadeno";
$text['cremated'] = "Spaljen";
$text['missing'] = "Fali";
$text['pdfgen'] = "PDF Generator";
$text['blank'] = "Prazan Dijagram";
$text['none'] = "Ništa";
$text['fonts'] = "Fontovi";
$text['header'] = "Zaglavlje";
$text['data'] = "Podaci";
$text['pgsetup'] = "Postavke Stranice";
$text['pgsize'] = "Velicina Stranice";
$text['orient'] = "Orientacija"; //for a page
$text['portrait'] = "Uspravno";
$text['landscape'] = "Vodoravno";
$text['tmargin'] = "Gornja Margina";
$text['bmargin'] = "Donja Margina";
$text['lmargin'] = "Lijeva Margin";
$text['rmargin'] = "Desna Margin";
$text['createch'] = "Kreiraj Dijagram";
$text['prefix'] = "Prefiks";
$text['mostwanted'] = "Naj Željeni";
$text['latupdates'] = "Najnovije Dopune";
$text['featphoto'] = "Prikazana Fotografija";
$text['news'] = "Vjesti";
$text['ourhist'] = "Naša Obiteljska Povijest";
$text['ourhistanc'] = "Naša Obiteljska Povijest i Porijeklo";
$text['ourpages'] = "Stranice Genealogije Naše Obitelj";
$text['pwrdby'] = "Ova stranica omogucena sa";
$text['writby'] = "napisao";
$text['searchtngnet'] = "Traži TNG Mrežu (GENDEX)";
$text['viewphotos'] = "Vidi sve fotografije";
$text['anon'] = "Trenutno ste anonimni";
$text['whichbranch'] = "Od koje grane ste vi?";
$text['featarts'] = "Izabrani clanci";
$text['maintby'] = "Izdržava";
$text['createdon'] = "Kreirano na";
$text['reliability'] = "Pouzdanost";
$text['labels'] = "Oznake";
$text['inclsrcs'] = "Ukljuci Izvore";
$text['cont'] = "(dalje)"; //abbreviation for continued
$text['mnuheader'] = "Pocetna Stranica";
$text['mnusearchfornames'] = "Traži Imena";
$text['mnulastname'] = "Prezime";
$text['mnufirstname'] = "Ime";
$text['mnusearch'] = "Traži";
$text['mnureset'] = "Pocni ispocetka";
$text['mnulogon'] = "Login";
$text['mnulogout'] = "Logout";
$text['mnufeatures'] = "Ostale opcije";
$text['mnuregister'] = "Registriraj se za korisnicki racun";
$text['mnuadvancedsearch'] = "Napredno pretraživanje";
$text['mnulastnames'] = "Prezimena";
$text['mnustatistics'] = "Statistika";
$text['mnuphotos'] = "Fotografije";
$text['mnuhistories'] = "Povijest";
$text['mnumyancestors'] = "Fotografije &amp; Povijest predaka od [Person]";
$text['mnucemeteries'] = "Groblja";
$text['mnutombstones'] = "Nadgobni spomenici";
$text['mnureports'] = "Izvješca";
$text['mnusources'] = "Izvori";
$text['mnuwhatsnew'] = "Što je novog";
$text['mnushowlog'] = "Zapis pristupa";
$text['mnulanguage'] = "Promijeni jezik";
$text['mnuadmin'] = "Administracija";
$text['welcome'] = "Dobrodošli";
$text['contactus'] = "Kontaktirajte nas";
//changed in 8.0.0
$text['born'] = "Roden";
$text['searchnames'] = "Traži imena";
//added in 8.0.0
$text['editperson'] = "Uredi Osobu";
$text['loadmap'] = "Ucitaj kartu";
$text['birth'] = "Rodenje";
$text['wasborn'] = "je roden/rodena";
$text['startnum'] = "Prvi Broj";
$text['searching'] = "Pretraživanje";
//moved here in 8.0.0
$text['location'] = "Lokacija";
$text['association'] = "Asocijacija";
$text['collapse'] = "Skupi";
$text['expand'] = "Ekspandiraj";
$text['plot'] = "Iscrtaj";
$text['searchfams'] = "Traži Obitelji";
//added in 8.0.2
$text['wasmarried'] = "Oženjen";
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
$text['enteremail2'] = "Molim unesite Vašu email adresu ponovo.";
$text['emailsmatch'] = "Vaše email adrese ne podudaraju.  Molim unesite istu email adresu u svako polje.";
$text['getdirections'] = "Kliknite za dobiti upute";
$text['calendar'] = "Kalendar";
//changed in 9.0.0
$text['directionsto'] = " na ";
$text['slidestart'] = "Pokreni Pokaz Prezentacije";
$text['livingnote'] = "Najmanje jedna živuca osoba je vezana za ovaj zapis - Detalji zadržani.";
$text['livingphoto'] = "Najmanje jedna živuca osoba je vezana za ovaj item - detalji pridržani.";
$text['waschristened'] = "Kršten";
//added in 10.0.0
$text['branches'] = "Branches";
$text['detail'] = "Detail";
$text['moredetail'] = "More detail";
$text['lessdetail'] = "Less detail";
$text['otherevents'] = "Ostali dogadaji";
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
$text['more'] = "Više";
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
$text['yourname'] = "Vaše ime";
$text['youremail'] = "Vaša adresa e-pošte";
$text['liketoadd'] = "Sve informacije koje želite dodati";
$text['webmastermsg'] = "Poruka webmastera";
$text['gallery'] = "Pogledajte galeriju";
$text['wasborn_male'] = "rođen je";
$text['wasborn_fanish'] = "rođen je";
$text['waschristened_male'] = "kršten je";
$text['waschristened_f ženski'] = "kršten je";
$text['dead_male'] = "umro";
$text['umrla_ žena'] = "umrla";
$text['wasburied_male'] = "Pokopan je";
$text['wasburied_fanish'] = "Pokopan je";
$text['wascremated_male'] = "kreiran";
$text['wascremated_fanish'] = "kremirano";
$text['wasmarried_male'] = "oženjen";
$text['wasmarried_fanish'] = "oženjen";
$text['wasdivorced_male'] = "razvedena je";
$text['wasdivorced_f žene'] = "razvedena je";
$text['inplace'] = "in";
$text['onthisdate'] = "uključeno";
$text['inthisyear'] = "in";
$text['and'] = "i";

//moved here in 12.3
$text['dna_info_head'] = "DNA Test Info";
$text['firstpage'] = "Prva stranica";
$text['lastpage'] = "Zadnja stranica";

@include_once "captcha_text.php";
@include_once "alltext.php";
if (!$alltextloaded) getAllTextPath();


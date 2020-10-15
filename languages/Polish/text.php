<?php
switch ($textpart) {
    //browsesources.php, showsource.php
    case "sources":
        $text['browseallsources'] = "Przegl�daj wszystkie �r�d�a";
        $text['shorttitle'] = "Kr�tki tytu�";
        $text['callnum'] = "Nr wywo�ania";
        $text['author'] = "Autor";
        $text['publisher'] = "Wydawca";
        $text['other'] = "Inne informacje";
        $text['sourceid'] = "ID �r�d�a";
        $text['moresrc'] = "Wi�cej �r�de�";
        $text['repoid'] = "ID repozytorium";
        $text['browseallrepos'] = "Przegl�daj wszystkie repozytoria";
        break;

    //changelanguage.php, savelanguage.php
    case "language":
        $text['newlanguage'] = "Nowy j�zyk";
        $text['changelanguage'] = "Zmiana j�zyka";
        $text['languagesaved'] = "Zapisz j�zyk";
        $text['sitemaint'] = "Strona jest w trakcie aktualizacji";
        $text['standby'] = "Z powodu aktualizacji bazy danych strona jest chwilowo niedost�pna. Prosz� spr�bowa� za jaki� czas ponownie. Je�li strona pozostanie przez d�u�szy czas niedost�pna, prosimy zwr�ci� si� do administratora <a href=\"suggest.php\"></a>.";
        break;

    //gedcom.php, gedform.php
    case "gedcom":
        $text['gedstart'] = "GEDCOM zaczynaj od";
        $text['producegedfrom'] = "Tw�rz plik gedcom z";
        $text['numgens'] = "Liczba generacji";
        $text['includelds'] = "��cznie z informacjami LDS";
        $text['buildged'] = "Buduj GEDCOM";
        $text['gedstartfrom'] = "Zaczynaj GEDCOM od";
        $text['nomaxgen'] = "Musisz wskaza� maksymaln� liczb� generacji. Prosz� powr�� i popraw ten b��d";
        $text['gedcreatedfrom'] = "Tw�rz GEDCOM z";
        $text['gedcreatedfor'] = "buduj dla";
        $text['creategedfor'] = "Tw�rz GEDCOM";
        $text['email'] = "Adres e-mail";
        $text['suggestchange'] = "Proponowane zmiany";
        $text['yourname'] = "Twoje nazwisko";
        $text['comments'] = "Uwagi i komentarze";
        $text['comments2'] = "Komentarze";
        $text['submitsugg'] = "Dodaj sugesti�";
        $text['proposed'] = "Propozycja zmian";
        $text['mailsent'] = "Dziekujemy, list wys�any.";
        $text['mailnotsent'] = "Przepraszamy, Tw�j list nie m�g� byc wys�any. Skontaktuj si� z xxx bezpo�rednio na yyy.";
        $text['mailme'] = "Wy�lij kopi� na ten adres";
        $text['entername'] = "Podaj swoje imi�";
        $text['entercomments'] = "Wpisz swoje uwagi";
        $text['sendmsg'] = "Wy�lij";
        //added in 9.0.0
        $text['subject'] = "Temat";
        break;

    //getextras.php, getperson.php
    case "getperson":
        $text['photoshistoriesfor'] = "Zdj�cia i historie dla";
        $text['indinfofor'] = "Informacja indywidualna dla";
        $text['pp'] = "skr."; //page abbreviation
        $text['age'] = "Wiek";
        $text['agency'] = "Urz�d";
        $text['cause'] = "Przyczyna";
        $text['suggested'] = "Sugerowane";
        $text['closewindow'] = "Zamknij to okno";
        $text['thanks'] = "Dzi�kujemy";
        $text['received'] = "Twoja sugestia zostanie dostarczona do administratora tej strony.";
        $text['indreport'] = "Raport indywidualny";
        $text['indreportfor'] = "Raport indywidualny dla";
        $text['general'] = "Og�lny";
        $text['bkmkvis'] = "<strong>Uwaga:</strong> Te zak�adki b�d� widoczne tylko na tym komputerze i tylko w tej wyszukiwarce internetowej.";
        //added in 9.0.0
        $text['reviewmsg'] = "Masz propozycj� zmian, kt�re potrzebuj� twojej opinii. Ten wniosek dotyczy:";
        $text['revsubject'] = "Proponowane zmiany potrzebuj� twojej opinii";
        break;

    //relateform.php, relationship.php, findpersonform.php, findperson.php
    case "relate":
        $text['relcalc'] = "Kalkulator pokrewie�stwa";
        $text['findrel'] = "Znajd� pokrewie�stwo";
        $text['person1'] = "Osoba 1:";
        $text['person2'] = "Osoba 2:";
        $text['calculate'] = "Oblicz";
        $text['select2inds'] = "Wybierz dwie osoby.";
        $text['findpersonid'] = "Znajd� ID osoby";
        $text['enternamepart'] = "Wpisz cz�� imienia i/lub nazwiska";
        $text['pleasenamepart'] = "Podaj cz�� imienia lub nazwiska.";
        $text['clicktoselect'] = "Kliknij, aby wybra�";
        $text['nobirthinfo'] = "Brak informacji o urodzeniu";
        $text['relateto'] = "Pokrewnie�stwo z";
        $text['sameperson'] = "Ta sama osoba wyst�puje dwa razy.";
        $text['notrelated'] = "Te dwie osoby nie s� spokrewnione w obr�bie xxx pokole�."; //xxx will be replaced with number of generations
        $text['findrelinstr'] = "Dla ustalenia pokrewie�stwa dw�ch os�b naci�nij 'Szukaj' aby zlokalizowa� istniej�ce osoby a nast�pnie kliknij na 'Oblicz'.";
        $text['sometimes'] = "(Czasami sprawdzenie innej liczby pokole� daje inny rezultat.)";
        $text['findanother'] = "Szukaj innego pokrewie�stwa";
        $text['brother'] = "brata(em)";
        $text['sister'] = "siostr�";
        $text['sibling'] = "rodze�stwem";
        $text['uncle'] = "xxx wujem";
        $text['aunt'] = "xxx ciotk�";
        $text['uncleaunt'] = "xxx wujem/ciotk�";
        $text['nephew'] = "xxx bratankiem/siostrzenic�";
        $text['niece'] = "xxx bratanic�/siostrzenic�";
        $text['nephnc'] = "xxx bratankiem,siostrzenic�/bratanic�,siostrzenic�";
        $text['removed'] = "m�odszym(�)";
        $text['rhusband'] = "m�em ";
        $text['rwife'] = "�on� ";
        $text['rspouse'] = "partnerem";
        $text['son'] = "synem";
        $text['daughter'] = "c�rk�";
        $text['rchild'] = "dzieckiem";
        $text['sil'] = "zi�ciem";
        $text['dil'] = "synow�";
        $text['sdil'] = "zi�ciem lub synow�";
        $text['gson'] = "xxx wnukiem";
        $text['gdau'] = "xxx wnuczk�";
        $text['gsondau'] = "xxx wnukiem/wnuczk�";
        $text['great'] = "pra";
        $text['spouses'] = "s� ma��e�stwem";
        $text['is'] = "jest";
        $text['changeto'] = "Zmie� na (podaj ID):";
        $text['notvalid'] = "jest to, albo niewa�ne ID osoby,albo nie ma go w bazie danych. Spr�buj jeszcze raz.";
        $text['halfbrother'] = "przyrodni brat";
        $text['halfsister'] = "przyrodnia siostra";
        $text['halfsibling'] = "przyrodnie rodze�stwo";
        //changed in 8.0.0
        $text['gencheck'] = "Maksymalna liczba pokole�<br>do sprawdzenia";
        $text['mcousin'] = "xxx kuzynem";  //male cousin; xxx = cousin number, yyy = times removed
        $text['fcousin'] = "xxx kuzynk�";  //female cousin
        $text['cousin'] = "xxx kuzynem/kuzynk�";
        $text['mhalfcousin'] = "xxx przyrodnim kuzyn";  //male cousin
        $text['fhalfcousin'] = "xxx przyrodni� kuzynk�";  //female cousin
        $text['halfcousin'] = "xxx przyrodni kuzyn";
        //added in 8.0.0
        $text['oneremoved'] = "m�odszym/m�odsz�";
        $text['gfath'] = "xxx dziadek";
        $text['gmoth'] = "xxx babka";
        $text['gpar'] = "xxx dziadkowie";
        $text['mothof'] = "matka";
        $text['fathof'] = "ojciec";
        $text['parof'] = "rodzice";
        $text['maxrels'] = "Maksymalna ilo�� relacji do pokazania";
        $text['dospouses'] = "Wzajemna relacja, w��czaj�c w to ma��onka";
        $text['rels'] = "Pokrewie�stwo";
        $text['dospouses2'] = "Poka� ma��onk�w";
        $text['fil'] = "te��";
        $text['mil'] = "te�ciowa";
        $text['fmil'] = "te�� lub te�ciowa";
        $text['stepson'] = "pasierbem";
        $text['stepdau'] = "pasierbic�";
        $text['stepchild'] = "pasierb(ica)";
        $text['stepgson'] = "the xxx synem pasierba";
        $text['stepgdau'] = "the xxx c�rk� pasierba";
        $text['stepgchild'] = "the xxx dzieckiem pasierba";
        //added in 8.1.1
        $text['ggreat'] = "pra";
        //added in 8.1.2
        $text['ggfath'] = "xxx pradziadkiem";
        $text['ggmoth'] = "xxx prababk�";
        $text['ggpar'] = "xxx pra rodzicami";
        $text['ggson'] = "xxx prawnukiem";
        $text['ggdau'] = "xxx prawnuczk�";
        $text['ggsondau'] = "xxx prawnukami";
        $text['gstepgson'] = "xxx pra pasierbem";
        $text['gstepgdau'] = "xxx pra pasierbic�";
        $text['gstepgchild'] = "xxx pra pasierbem";
        $text['guncle'] = "xxx pra wujkiem";
        $text['gaunt'] = "xxx pra ciotk�";
        $text['guncleaunt'] = "xxx pra wujkiem/ciotk�";
        $text['gnephew'] = "xxx pra bratankiem/siostrzenic�";
        $text['gniece'] = "xxx pra bratanic�/siostrzenic�";
        $text['gnephnc'] = "xxx pra bratanic�/siostrzenic�";
        break;

    case "familygroup":
        $text['familygroupfor'] = "Arkusz rodzinny dla";
        $text['ldsords'] = "Wy�wi�cony (LDS)";
        $text['baptizedlds'] = "Ochrzczony/a (LDS)";
        $text['endowedlds'] = "Wprowadzony/a (LDS)";
        $text['sealedplds'] = "Przekazani P (LDS)";
        $text['sealedslds'] = "Przekazany/a S (LDS)";
        $text['otherspouse'] = "Inny partner";
        $text['husband'] = "M��";
        $text['wife'] = "�ona";
        break;

    //pedigree.php
    case "pedigree":
        $text['capbirthabbr'] = "ur.";
        $text['capaltbirthabbr'] = "w";
        $text['capdeathabbr'] = "zm.";
        $text['capburialabbr'] = "pog.";
        $text['capplaceabbr'] = "w";
        $text['capmarrabbr'] = "�l.";
        $text['capspouseabbr'] = "SP";
        $text['redraw'] = "Ponownie narysuj z";
        $text['scrollnote'] = "Uwaga: By� mo�e musisz przewin�� w prawo lub w d� aby wszystko zobaczy�.";
        $text['unknownlit'] = "Nieznany";
        $text['popupnote1'] = " = Dodatkowe informacje";
        $text['popupnote2'] = " = Nowy rodow�d";
        $text['pedcompact'] = "Kompaktowe";
        $text['pedstandard'] = "Standartowe";
        $text['pedtextonly'] = "Tekst";
        $text['descendfor'] = "Potomkowie od";
        $text['maxof'] = "Najwi�cej z";
        $text['gensatonce'] = "Poka� generacje jednocze�nie.";
        $text['sonof'] = "syn";
        $text['daughterof'] = "c�rka";
        $text['childof'] = "dzieckiem";
        $text['stdformat'] = "Format standardowy";
        $text['ahnentafel'] = "Rodow�d";
        $text['addnewfam'] = "Dodaj now� rodzin�";
        $text['editfam'] = "Edycja rodziny";
        $text['side'] = "strona";
        $text['familyof'] = "Rodzina";
        $text['paternal'] = "Ojcowski";
        $text['maternal'] = "Matczyny";
        $text['gen1'] = "Sam";
        $text['gen2'] = "Rodzice";
        $text['gen3'] = "Dziadkowie";
        $text['gen4'] = "Pradziadkowie";
        $text['gen5'] = "Prapradziadkowie";
        $text['gen6'] = "Praprapradziadkowie";
        $text['gen7'] = "Prapraprapradziadkowie";
        $text['gen8'] = "Praprapraprapradziadkowie";
        $text['gen9'] = "Prapraprapraprapradziadkowie";
        $text['gen10'] = "Praprapraprapraprapradziadkowie";
        $text['gen11'] = "Prapraprapraprapraprapradziadkowie";
        $text['gen12'] = "Praprapraprapraprapraprapradziadkowie";
        $text['graphdesc'] = "Diagram potomk�w do tego miejsca";
        $text['pedbox'] = "Boks";
        $text['regformat'] = "Pokolenia";
        $text['extrasexpl'] = "= Dla tej osoby istnieje ju� przynajmniej jedno zdj�cie,historia lub inne medium.";
        $text['popupnote3'] = " = Nowy diagram";
        $text['mediaavail'] = "S� media";
        $text['pedigreefor'] = "Rodow�d dla";
        $text['pedigreech'] = "Drzewo genealogiczne";
        $text['datesloc'] = "Daty i miejsca";
        $text['borchr'] = "narodziny/chrzciny - zgon/pogrzeb (dwa)";
        $text['nobd'] = "Brak danych dotycz�cych narodzin lub zgonu";
        $text['bcdb'] = "narodziny/chrzciny/zgon/pogrzeb (cztery)";
        $text['numsys'] = "System numerowania";
        $text['gennums'] = "Numery generacji";
        $text['henrynums'] = "Numerowanie w.g Henry'ego";
        $text['abovnums'] = "Numerowanie w.g d'Aboville";
        $text['devnums'] = "Numerowanie w.g de Villiers";
        $text['dispopts'] = "Opcje widoku";
        //added in 10.0.0
        $text['no_ancestors'] = "Nie znaleziono przodk�w";
        $text['ancestor_chart'] = "Pionowy wykres przodk�w";
        $text['opennewwindow'] = "Otw�rz w nowym oknie";
        $text['pedvertical'] = "Pionowo";
        //added in 11.0.0
        $text['familywith'] = "Rodzina z";
        $text['fcmlogin'] = "Prosz� si� zalogowa�, aby zobaczy� szczeg�y";
        $text['isthe'] = "jest";
        $text['otherspouses'] = "inni ma��onkowie";
        $text['parentfamily'] = "Rodzina rodzica ";
        $text['showfamily'] = "Poka� rodzin�";
        $text['shown'] = "pokazano";
        $text['showparentfamily'] = "poka� rodzin� rodzica";
        $text['showperson'] = "poka� osob�";
        //added in 11.0.2
        $text['otherfamilies'] = "Inne rodziny";
        break;

    //search.php, searchform.php
    //merged with reports and showreport in 5.0.0
    case "search":
    case "reports":
        $text['noreports'] = "Raporty nie istniej�.";
        $text['reportname'] = "Nazwa raportu";
        $text['allreports'] = "Wszystkie raporty";
        $text['report'] = "Raport";
        $text['error'] = "B��d";
        $text['reportsyntax'] = "Sk�adnia pytania do tego raportu";
        $text['wasincorrect'] = "by� b��dny i dlatego raport nie m�g� zosta� utworzony. Skontaktuj si� z administratorem";
        $text['errormessage'] = "B��d";
        $text['equals'] = "r�wne";
        $text['endswith'] = "ko�czy si� na";
        $text['soundexof'] = "soundex of";
        $text['metaphoneof'] = "metaphone of";
        $text['plusminus10'] = "+/- 10 lat od";
        $text['lessthan'] = "mniejszy od";
        $text['greaterthan'] = "wi�cej ni�";
        $text['lessthanequal'] = "Mniejszy lub r�wny z";
        $text['greaterthanequal'] = "Wi�kszy lub r�wny z";
        $text['equalto'] = "r�wny";
        $text['tryagain'] = "Spr�buj ponownie napisa� nazwisko du�ymi literami";
        $text['joinwith'] = "Po��cz z";
        $text['cap_and'] = "ORAZ";
        $text['cap_or'] = "LUB";
        $text['showspouse'] = "Poka� wsp�ma��onka (pokazuje duplikaty je�li osoba ma wi�cej ni� jednego partnera)";
        $text['submitquery'] = "Zatwierdzenie pytania";
        $text['birthplace'] = "Miejsce urodzenia";
        $text['deathplace'] = "Miejsce zgonu";
        $text['birthdatetr'] = "Rok urodzenia";
        $text['deathdatetr'] = "Rok zgonu";
        $text['plusminus2'] = "+/- 2 lata od";
        $text['resetall'] = "Usu� wpisy";
        $text['showdeath'] = "Poka� informacje o zgonie i pogrzebie";
        $text['altbirthplace'] = "Miejsce chrztu";
        $text['altbirthdatetr'] = "Rok chrztu";
        $text['burialplace'] = "Miejsce pogrzebu";
        $text['burialdatetr'] = "Rok pogrzebu";
        $text['event'] = "Wydarzenie(a)";
        $text['day'] = "Dzie�";
        $text['month'] = "Miesi�c";
        $text['keyword'] = "S�owo kluczowe (\"Oko�o\")";
        $text['explain'] = "Podaj sk�adniki daty aby zobaczy� wydarzenia w danym dniu. Pozostaw wolne pole aby zobaczy� wszystkie wydarzenia.";
        $text['enterdate'] = "Podaj lub wybierz ostatni z podanych: dzie�, miesi�c, rok, s�owo kluczowe";
        $text['fullname'] = "Imie i nazwisko";
        $text['birthdate'] = "Data urodzenia";
        $text['altbirthdate'] = "Data chrztu";
        $text['marrdate'] = "Data �lubu";
        $text['spouseid'] = "ID wsp�ma��onka";
        $text['spousename'] = "Imi� wsp�ma��onka";
        $text['deathdate'] = "Data zgonu";
        $text['burialdate'] = "Data pogrzebu";
        $text['changedate'] = "Data ostatniej modyfikacji";
        $text['gedcom'] = "Drzewo";
        $text['baptdate'] = "Data chrztu (LDS)";
        $text['baptplace'] = "Miejsce chrztu (LDS)";
        $text['endldate'] = "Data wprowadzenia (LDS)";
        $text['endlplace'] = "Miejsce wprowadzenia (LDS)";
        $text['ssealdate'] = "Data przekazania S (LDS)";   //Sealed to spouse
        $text['ssealplace'] = "Miejsce przekazania S (LDS)";
        $text['psealdate'] = "Data przekazania P (LDS)";   //Sealed to parents
        $text['psealplace'] = "Miejsce przekazania P (LDS)";
        $text['marrplace'] = "Miejsce �lubu";
        $text['spousesurname'] = "Nazwisko wsp�ma��onka";
        $text['spousemore'] = "Je�eli podasz nazwisko wsp�ma��onka, to musisz poda� r�wnie� p�e�.";
        $text['plusminus5'] = "+/- 5 lat od";
        $text['exists'] = "istnieje";
        $text['dnexist'] = "nie istnieje";
        $text['divdate'] = "Data separacji";
        $text['divplace'] = "Miejsce separacji";
        $text['otherevents'] = "Inne wydarzenia";
        $text['numresults'] = "Wyniki dla strony";
        $text['mysphoto'] = "Zagadkowe zdj�cia";
        $text['mysperson'] = "Zagadkowe osoby";
        $text['joinor'] = "Opcja 'Do��cz w LUB' nie mo�e by� u�yta przy nazwiskach wsp�ma��onk�w";
        $text['tellus'] = "Powiedz nam co wiesz";
        $text['moreinfo'] = "Wi�cej informacji:";
        //added in 8.0.0
        $text['marrdatetr'] = "Rok �lubu";
        $text['divdatetr'] = "Rok rozwodu";
        $text['mothername'] = "Nazwisko matki";
        $text['fathername'] = "Nazwisko ojca";
        $text['filter'] = "Filter";
        $text['notliving'] = "Nie�yj�cy";
        $text['nodayevents'] = "Wydarzenia w tym miesi�cu nie zwi�zane z konkretn� dat�:";
        //added in 9.0.0
        $text['csv'] = "Format pliku CSV (warto�ci rozdzielone przecinkiem)";
        //added in 10.0.0
        $text['confdate'] = "Data konfirmacji (LDS)";
        $text['confplace'] = "Miejsce konfirmacji (LDS)";
        $text['initdate'] = "Data inicjacji (LDS)";
        $text['initplace'] = "Miejsce inicjacji (LDS)";
        //added in 11.0.0
        $text['marrtype'] = "Rodzaj �lubu";
        $text['searchfor'] = "Szukaj";
        $text['searchnote'] = "Uwaga: Ta strona korzysta z Google, aby wykonywa� wyszukiwanie. Ilo�� wyszukowa� b�dzie zale�na od tego w jakim stopniu Google indeksuje witryny.";
        break;

    //showlog.php
    case "showlog":
        $text['logfilefor'] = "Logi dla";
        $text['mostrecentactions'] = "Ostatnich logowa�";
        $text['autorefresh'] = "Autood�wie�anie (30 sekund)";
        $text['refreshoff'] = "Wy��cz autood�wie�anie";
        break;

    case "headstones":
    case "showphoto":
        $text['cemeteriesheadstones'] = "Cmentarze i nagrobki";
        $text['showallhsr'] = "Poka� wszystkie nagrobki";
        $text['in'] = "w";
        $text['showmap'] = "Poka� map�";
        $text['headstonefor'] = "Nagrobek dla";
        $text['photoof'] = "Zdj�cie";
        $text['photoowner'] = "U�ytkownik/�r�d�o";
        $text['nocemetery'] = "Brak cmentarza";
        $text['iptc005'] = "Tytu�";
        $text['iptc020'] = "Dodatkowe kategorie";
        $text['iptc040'] = "Specjalne instrukcje";
        $text['iptc055'] = "Data utworzenia";
        $text['iptc080'] = "Autor";
        $text['iptc085'] = "Pozycja autora";
        $text['iptc090'] = "Miejscowo��";
        $text['iptc095'] = "Wojew�dztwo";
        $text['iptc101'] = "Kraj";
        $text['iptc103'] = "OTR";
        $text['iptc105'] = "Artyku�";
        $text['iptc110'] = "�r�d�o";
        $text['iptc115'] = "�r�d�o zdj�cia";
        $text['iptc116'] = "Prawa autorskie";
        $text['iptc120'] = "Tytu�";
        $text['iptc122'] = "Autor tytu�u";
        $text['mapof'] = "Mapa";
        $text['regphotos'] = "Poka� z opisami";
        $text['gallery'] = "Tylko miniatury";
        $text['cemphotos'] = "Zdj�cia cmentarza";
        $text['photosize'] = "Wymiary";
        $text['iptc010'] = "Priorytet";
        $text['filesize'] = "Rozmiar pliku";
        $text['seeloc'] = "Zobacz lokalizacj�";
        $text['showall'] = "Poka� wszystko";
        $text['editmedia'] = "Edytuj media";
        $text['viewitem'] = "Widok tej pozycji";
        $text['editcem'] = "Edytuj cmentarz";
        $text['numitems'] = "# pozycji";
        $text['allalbums'] = "Wszystkie albumy";
        $text['slidestop'] = "Pauza przegl�du slajd�w";
        $text['slideresume'] = "Zako�cz przegl�d slajd�w";
        $text['slidesecs'] = "Sekundy dla ka�dego slajdu:";
        $text['minussecs'] = "minus 0.5 sekundy";
        $text['plussecs'] = "plus 0.5 sekundy";
        $text['nocountry'] = "Nieznany kraj";
        $text['nostate'] = "Nieznane wojew�dztwo (stan))";
        $text['nocounty'] = "Nieznany powiat";
        $text['nocity'] = "Nieznana miejscowo��";
        $text['nocemname'] = "Nieznana nazwa cmentarza";
        $text['editalbum'] = "Edycja albumu";
        $text['mediamaptext'] = "<strong>Uwaga:</strong> Podczas przesuwania strza�ki myszy po zdj�ciu b�d� si� pokazywa� nazwiska. Klikaj�c na wybrane otrzymasz bardziej szczeg�owe informacje.";
        //added in 8.0.0
        $text['allburials'] = "Wszystkie pogrzeby";
        $text['moreinfo'] = "Wi�cej informacji:";
        //added in 9.0.0
        $text['iptc025'] = "S�owa";
        $text['iptc092'] = "Sub-lokalizacja";
        $text['iptc015'] = "Kategoria";
        $text['iptc065'] = "Pochodzenie programu";
        $text['iptc070'] = "Wersja programu";
        break;

    //surnames.php, surnames100.php, surnames-all.php, surnames-oneletter.php
    case "surnames":
    case "places":
        $text['surnamesstarting'] = "Poka� nazwiska na liter�";
        $text['showtop'] = "Poka�";
        $text['showallsurnames'] = "Poka� wszystkie nazwiska";
        $text['sortedalpha'] = "sortuj alfabetycznie";
        $text['byoccurrence'] = "najcz�ciej wyst�puj�cych";
        $text['firstchars'] = "Pierwsze litery";
        $text['mainsurnamepage'] = "Strona g��wna nazwisk";
        $text['allsurnames'] = "Wszystkie nazwiska";
        $text['showmatchingsurnames'] = "Kliknij na nazwisko, aby zobaczy� wszystkie dane.";
        $text['backtotop'] = "Wr�� do g��wnych";
        $text['beginswith'] = "Rozpoczyna si� na";
        $text['allbeginningwith'] = "Wszystkie nazwiska zaczynaj�ce si� na";
        $text['numoccurrences'] = "liczba wyst�puj�cych w nawiasie";
        $text['placesstarting'] = "Zaczynaj od najwi�kszych miejsc";
    $text['showmatchingplaces'] = "<span style=\\";
    $text['totalnames'] = "wszystkie osoby";
        $text['showallplaces'] = "Poka� wszystkie miejsca";
        $text['totalplaces'] = "Wszystkie miejsca";
        $text['mainplacepage'] = "Strona g��wna miejsc";
        $text['allplaces'] = "Wszystkie najwi�ksze miejsca";
        $text['placescont'] = "Poka� wszystkie miejsca zawieraj�ce ";
        //changed in 8.0.0
        $text['top30'] = "xxx najcz�ciej wyst�puj�cych nazwisk";
        $text['top30places'] = "xxx najwi�kszych lokalizacji";
        //added in 12.0.0
        $text['firstnamelist'] = "Lista imion";
        $text['firstnamesstarting'] = "Przedstawia imiona zaczynaj�ce si� od";
        $text['showallfirstnames'] = "Przedstawia wszystkie imiona";
        $text['mainfirstnamepage'] = "G��wna strona imion";
        $text['allfirstnames'] = "Imiona";
        $text['showmatchingfirstnames'] = "Kliknij na Imi�, aby wy�wietli� pasuj�ce zapisy.";
        $text['allfirstbegwith'] = "Wszystkie imiona zaczynaj�ce si� na";
        $text['top30first'] = "Pierwsze xxx imion(a)";
        $text['allothers'] = "Inne";
        $text['amongall'] = "(w�r�d wszystkich imion)";
        $text['justtop'] = "Tylko pierwsze xxx";
        break;

    //whatsnew.php
    case "whatsnew":
        $text['pastxdays'] = "(ostatnie xx dni)";

        $text['photo'] = "Zdj�cie";
        $text['history'] = "Historia/Dokument";
        $text['husbid'] = "ID m�a";
        $text['husbname'] = "Imi� m�a";
        $text['wifeid'] = "ID �ony";
        //added in 11.0.0
        $text['wifename'] = "Nazwisko matki";
        break;

    //timeline.php, timeline2.php
    case "timeline":
        $text['text_delete'] = "Usu�";
        $text['addperson'] = "Dodaj osob�";
        $text['nobirth'] = "Ta osoba nie mo�e zosta� dodana poniewa� brakuje jej aktualnej daty urodzin";
        $text['event'] = "Wydarzenie(a)";
        $text['chartwidth'] = "Szeroko�� diagramu";
        $text['timelineinstr'] = "Dodaj osob�";
        $text['togglelines'] = "Rysuj linie";
        //changed in 9.0.0
        $text['noliving'] = "Ta osoba jest zaznaczona jako �yj�ca i nie mo�e zosta� dodana, poniewa� nie jeste� do tego uprawniony/a";
        break;

    //browsetrees.php
    //login.php, newacctform.php, addnewacct.php
    case "trees":
    case "login":
        $text['browsealltrees'] = "Przegl�daj wszystkie drzewa";
        $text['treename'] = "Nazwa drzewa";
        $text['owner'] = "W�a�ciciel";
        $text['address'] = "Adres";
        $text['city'] = "Miejscowo��";
        $text['state'] = "Wojew�dztwo.";
        $text['zip'] = "Numer kodu poczt.";
        $text['country'] = "Kraj";
        $text['email'] = "Adres e-mail";
        $text['phone'] = "Telefon";
        $text['username'] = "Nazwisko (login)";
        $text['password'] = "Has�o";
        $text['loginfailed'] = "Logowanie nie powiod�o si�.";

        $text['regnewacct'] = "Rejestracja";
        $text['realname'] = "Nazwisko i imi�";
        $text['phone'] = "Telefon";
        $text['email'] = "Adres e-mail";
        $text['address'] = "Adres";
        $text['acctcomments'] = "Notatki lub komentarz";
        $text['submit'] = "Zapisz";
        $text['leaveblank'] = "(pozostaw puste je�li chodzi o nowe drzewo i wype�nij kolejne pole)";
        $text['required'] = "Pola wymagane";
        $text['enterpassword'] = "Podaj has�o.";
        $text['enterusername'] = "Podaj nazw� u�ytkownika.";
        $text['failure'] = "Przepraszamy. Ta nazwa drzewa jest zaj�ta albo nie podano Tree ID, gdzie trzeba poda� kr�tk� nazw� drzewa, jedno s�owo, bez spacji. Prosimy powr�ci� do rejestracji i wybra� now� nazw�.";
        $text['success'] = "Dzi�kujemy. Twoje dane zosta�y zarejestrowane. Skontaktujemy si� z Tob� po aktywacji Twojego konta lub je�li b�dziemy potrzebowali dalszych informacji.";
        $text['emailsubject'] = "W  zarejestrowa� si� nowy u�ytkownik";
        $text['website'] = "Strona www";
        $text['nologin'] = "Nie masz Nazwy u�ytkownika?";
        $text['loginsent'] = "Informacja zosta�a wys�ana";
        $text['loginnotsent'] = "Informacja nie zosta�a wys�ana";
        $text['enterrealname'] = "Podaj prawdziwe nazwisko i imi�.";
        $text['rempass'] = "Pozosta� zalogowany";
        $text['morestats'] = "Wi�cej statystyk";
        $text['accmail'] = "<strong>UWAGA:</strong> Aby otrzyma� poczt� od administratora dotycz�c� Twego konta sprawd�, czy ta domena nie jest przez Ciebie blokowana <br>(czy wiadomo�� nie zostanie potraktowana jako spam).";
        $text['newpassword'] = "Nowe has�o";
        $text['resetpass'] = "Zmie� has�o";
        $text['nousers'] = "Ta forma nie mo�e zosta� u�yta dla co najmniej jednego istniej�cego zapisu u�ytkownika. Je�li ty jeste� w�a�cicielem strony, przejd� do Administracja / U�ytkownicy, by utworzy� Twoje konto administratora.";
        $text['noregs'] = "Niestety aktualnie nie przyjmujemy rejestracji nowych u�ytkownik�w. W przypadku pyta� lub uwag dotycz�cych tej strony prosimy o <a href=\"suggest.php\">kontakt</a>.";
        //changed in 8.0.0
        $text['emailmsg'] = "Otrzyma�e� wniosek o za�o�enie konta dla nowego u�ytkownika TNG. Zaloguj si� na konto administratora i nadaj mu odpowiednie uprawnienia. Je�li zatwierdzisz t� rejestracj�, powiadom wnioskodawc�, odpowiadaj�c na t� wiadomo��.";
        $text['accactive'] = "Konto zosta�o aktywowane, ale u�ytkownik nie ma specjalnych uprawnie� do czasy, a� zostan� mu nadane.";
        $text['accinactive'] = "Id� do Admin/Users/Review aby uruchomi� ustawienie konta. Konto b�dzie nieaktywne do czasu, a� zostanie edytowane lub, przynajmniej raz, zachowane.";
        $text['pwdagain'] = "Has�o ponownie";
        $text['enterpassword2'] = "Prosz� wpisa� has�o ponownie.";
        $text['pwdsmatch'] = "Wpisane has�a s� r�ne. Prosz� wpisa� to samo has�o w ka�dym polu.";
        //added in 8.0.0
        $text['acksubject'] = "Dzi�kuj� za zarejestrowanie si�"; //for a new user account
        $text['ackmessage'] = "Twoje zapotrzebowanie na otwarcie nowego konta zosta�o odebrane. Konto b�dzie nie aktywne do czasu, a� zostanie zatwierdzone przez Administratora. Zostaniesz powiadomiony emailem kiedy konto b�dzie aktywowane.";
        //added in 12.0.0
        $text['switch'] = "Zmie�";
        break;

    //added in 10.0.0
    case "branches":
        $text['browseallbranches'] = "Przejrzyj wszystkie ga��zie";
        break;

    //statistics.php
    case "stats":
        $text['quantity'] = "Liczba";
        $text['totindividuals'] = "Wszystkie osoby";
        $text['totmales'] = "Wszyscy m�czy�ni";
        $text['totfemales'] = "Wszystkie kobiety";
        $text['totunknown'] = "Wszyscy nieznanej p�ci";
        $text['totliving'] = "Wszyscy �yj�cy";
        $text['totfamilies'] = "Wszystkie rodziny";
        $text['totuniquesn'] = "Wszystkie unikalne nazwiska";
        //$text['totphotos'] = "Total Photos";
        //$text['totdocs'] = "Total Histories &amp; Documents";
        //$text['totheadstones'] = "Total Headstones";
        $text['totsources'] = "Wszystkie �r�d�a";
        $text['avglifespan'] = "�rednia d�ugo�� �ycia";
        $text['earliestbirth'] = "Najwcze�niej urodzony/a";
        $text['longestlived'] = "Najstarsi zmarli";
        $text['days'] = "dni";
        $text['age'] = "Wiek";
        $text['agedisclaimer'] = "Obliczenia bazuj�ce na wieku odnosz� si� do os�b z podan� dat� urodzenia <EM><B>oraz</B></EM> �mierci.  Przy niepe�nych datach(np., data urodzenia podana jako \"1945\" lub \"JAN 1860\"), obliczenia mog� by� nieprecyzyjne.";
        $text['treedetail'] = "Wi�cej informacji o tym drzewie";
        $text['total'] = "Wszystkie";
        //added in 12.0
        $text['totdeceased'] = "Zmarli";
        break;

    case "notes":
        $text['browseallnotes'] = "Przeszukaj wszystkie notatki";
        break;

    case "help":
        $text['menuhelp'] = "Menu pomocy";
        break;

    case "install":
        $text['perms'] = "Uprawnienia zosta�y nadane.";
        $text['noperms'] = "Tym plikom nie mog� zosta� nadane uprawnienia:";
        $text['manual'] = "Prosz� ustawi� je r�cznie.";
        $text['folder'] = "Folder";
        $text['created'] = "zosta�y utworzone";
        $text['nocreate'] = "nie mo�na utworzy�. Prosz� utworzy� go r�cznie.";
        $text['infosaved'] = "Informacje zapisane, po��czenie sprawdzone!";
        $text['tablescr'] = "Tabele zosta�y utworzone!";
        $text['notables'] = "Nast�puj�ce tabele nie mog�y zosta� utworzone:";
        $text['nocomm'] = "TNG nie mo�e skomunikowa� si� z baz� danych. Tabele nie zosta�y utworzone.";
        $text['newdb'] = "Informacje zapisane, sprawdzone po��czenie, nowa baza danych utworzona:";
        $text['noattach'] = "Informacje zapisane. Po��czenia wykonane i uaktualniona baza danych, ale TNG nie mo�e do niej do��czy�.";
        $text['nodb'] = "Informacje zapisane. Po��czenie wykonane, ale baza danych nie istnieje i nie mo�e zosta� utworzona. Prosz� sprawdzi�, czy nazwa bazy danych jest poprawna, lub u�y� panelu sterowania, aby j� utworzy�.";
        $text['noconn'] = "Informacje zapisane, ale po��czenie nie powiod�o si�. Jeden lub wi�cej z nast�puj�cych jest nieprawid�owy:";
        $text['exists'] = "istnieje";
        $text['loginfirst'] = "Musisz si� najpierw zalogowa�.";
        $text['noop'] = "�adna operacja nie zosta�a wykonana.";
        //added in 8.0.0
        $text['nouser'] = "U�ytkownik nie zosta� utworzony. Przypuszczalnie ju� istnieje.";
        $text['notree'] = "Drzewo nie zosta�o utworzone. ID drzewa przypuszczalnie istnieje.";
        $text['infosaved2'] = "Informacja zapisana";
        $text['renamedto'] = "zmieniono nazw� na";
        $text['norename'] = "nazwa nie mo�e by� zmieniona";
        break;

    case "imgviewer":
        $text['zoomin'] = "Powi�ksz";
        $text['zoomout'] = "Zmniejsz";
        $text['magmode'] = "Modu� powiekszenia";
        $text['panmode'] = "Modu� przesuni�cia";
        $text['pan'] = "Kliknij i przeciagnij, aby przesun�� grafik�";
        $text['fitwidth'] = "Dopasuj szeroko��";
        $text['fitheight'] = "Dopasuj wysoko��";
        $text['newwin'] = "Nowe okno";
        $text['opennw'] = "Otw�rz grafik� w nowym oknie";
        $text['magnifyreg'] = "Kliknij, aby powi�kszy� wybrany obszar grafiki";
        $text['imgctrls'] = "Umo�liwienie kontroli obrazu";
        $text['vwrctrls'] = "Umo�liwienie kontroli przegl�darki grafiki";
        $text['vwrclose'] = "Zamknij przegladark� grafiki";
        break;

    case "dna":
        $text['test_date'] = "Data testu";
        $text['links'] = "Wa�ne linki";
        $text['testid'] = "Test ID";
        //added in 12.0.0
        $text['mode_values'] = "Warto�ci Mod";
        $text['compareselected'] = "Por�wnaj Wybrane";
        $text['dnatestscompare'] = "Por�wnaj testy Y-DNA";
        $text['keep_name_private'] = "Zachowaj prywatno��";
        $text['browsealltests'] = "Przegl�daj Wszystkie Testy";
        $text['all_dna_tests'] = "Wszystkie testy DNA";
        $text['fastmutating'] = "Szybka mutacja";
        $text['alltypes'] = "Rodzaje";
        $text['allgroups'] = "Grupy";
        $text['Ydna_LITbox_info'] = "Testy powi�zane z t� osob� niekoniecznie zosta�y wykonane przez t� osob�.<br>Kolumna 'Haplogroup' wy�wietla dane na czerwono, je�li wynik jest 'Przewidywany' lub na zielono je�li test jest 'Potwierdzony'";
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
$text['matches'] = "Wyniki";
$text['description'] = "Opis";
$text['notes'] = "Notatki";
$text['status'] = "Status";
$text['newsearch'] = "Nowe szukanie";
$text['pedigree'] = "Rodow�d";
$text['seephoto'] = "Zobacz zdj�cie";
$text['andlocation'] = "&amp; po�o�enie";
$text['accessedby'] = "odwiedzone przez";
$text['family'] = "Zwi�zek"; //from getperson
$text['children'] = "Dzieci";  //from getperson
$text['tree'] = "Istniej�ce drzewo";
$text['alltrees'] = "Wszystkie drzewa";
$text['nosurname'] = "[bez nazwiska]";
$text['thumb'] = "Miniatura";  //as in Thumbnail
$text['people'] = "Osoby";
$text['title'] = "Tytu�";  //from getperson
$text['suffix'] = "Przyrostek";  //from getperson
$text['nickname'] = "Przydomek";  //from getperson
$text['lastmodified'] = "Ostatnia modyfikacja";  //from getperson
$text['married'] = "�lub";  //from getperson
//$text['photos'] = "Photos";
$text['name'] = "Nazwisko"; //from showmap
$text['lastfirst'] = "Nazwisko, imi�";  //from search
$text['bornchr'] = "Data i miejsce urodzenia";  //from search
$text['individuals'] = "Osoby";  //from whats new
$text['families'] = "Rodziny";
$text['personid'] = "ID osoby";
$text['sources'] = "�r�d�a";  //from getperson (next several)
$text['unknown'] = "Nieznane";
$text['father'] = "Ojciec";
$text['mother'] = "Matka";
$text['christened'] = "Chrzest";
$text['died'] = "Zgon";
$text['buried'] = "Pogrzeb";
$text['spouse'] = "Partner";  //from search
$text['parents'] = "Rodzice";  //from pedigree
$text['text'] = "Tekst";  //from sources
$text['language'] = "J�zyk";  //from languages
$text['descendchart'] = "Linia potomk�w";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Osoba";
$text['edit'] = "Edycja";
$text['date'] = "Data";
$text['place'] = "Miejsce";
$text['login'] = "Zaloguj";
$text['logout'] = "Wyloguj";
$text['groupsheet'] = "Arkusz rodzinny";
$text['text_and'] = "oraz";
$text['generation'] = "Pokolenie";
$text['filename'] = "Nazwa pliku";
$text['id'] = "ID";
$text['search'] = "Szukaj";
$text['user'] = "U�ytkownik";
$text['firstname'] = "Imi�";
$text['lastname'] = "Nazwisko";
$text['searchresults'] = "Szukaj w wynikach";
$text['diedburied'] = "Zmar�";
$text['homepage'] = "Strona g��wna";
$text['find'] = "Znajd�...";
$text['relationship'] = "Pokrewie�stwo";    //in German, Verwandtschaft
$text['relationship2'] = "Wzajemna relacja"; //different in some languages, at least in German (Beziehung)
$text['timeline'] = "Linia czasu";
$text['yesabbr'] = "R";               //abbreviation for 'yes'
$text['divorced'] = "Rozw�d";
$text['indlinked'] = "Link do";
$text['branch'] = "Ga���";
$text['moreind'] = "Wi�cej os�b";
$text['morefam'] = "Wi�cej rodzin";
$text['source'] = "�r�d�o";
$text['surnamelist'] = "Lista nazwisk";
$text['generations'] = "Pokolenia";
$text['refresh'] = "Od�wie�";
$text['whatsnew'] = "Co nowego";
$text['reports'] = "Raporty";
$text['placelist'] = "Lista miejsc";
$text['baptizedlds'] = "Ochrzczony/a (LDS)";
$text['endowedlds'] = "Wprowadzony/a (LDS)";
$text['sealedplds'] = "Przekazani P (LDS)";
$text['sealedslds'] = "Przekazany/a S (LDS)";
$text['ancestors'] = "Przodkowie";
$text['descendants'] = "Potomkowie";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Data ostatniego importu GEDCOM-u";
$text['type'] = "Typ";
$text['savechanges'] = "Zapisz zmiany";
$text['familyid'] = "ID rodziny";
$text['headstone'] = "Nagrobki";
$text['historiesdocs'] = "Historie";
$text['anonymous'] = "anonimowy";
$text['places'] = "Miejsca";
$text['anniversaries'] = "Daty i rocznice";
$text['administration'] = "Administracja";
$text['help'] = "Pomoc";
//$text['documents'] = "Documents";
$text['year'] = "Rok";
$text['all'] = "Wszystko";
$text['repository'] = "Repozytorium";
$text['address'] = "Adres";
$text['suggest'] = "Sugestie";
$text['editevent'] = "Sugestia zmiany dla tego wydarzenia";
$text['findplaces'] = "Wyszukaj wszystkie osoby powi�zane z t� lokalizacj�";
$text['morelinks'] = "Wi�cej ��czy";
$text['faminfo'] = "Informacja o zwi�zku";
$text['persinfo'] = "Info o osobie";
$text['srcinfo'] = "Informacje o �r�dle";
$text['fact'] = "Zdarzenie";
$text['goto'] = "Wybierz stron�";
$text['tngprint'] = "Drukuj";
$text['databasestatistics'] = "Statystyki"; //needed to be shorter to fit on menu
$text['child'] = "Dziecko";  //from familygroup
$text['repoinfo'] = "Informacja o repozytoriach";
$text['tng_reset'] = "Cofnij";
$text['noresults'] = "Brak rezultat�w";
$text['allmedia'] = "Wszystkie media";
$text['repositories'] = "Repozytoria";
$text['albums'] = "Albumy";
$text['cemeteries'] = "Cmentarze";
$text['surnames'] = "Nazwiska";
$text['dates'] = "Daty";
$text['link'] = "Link";
$text['media'] = "Media";
$text['gender'] = "P�e�";
$text['latitude'] = "Szeroko��";
$text['longitude'] = "D�ugo��";
$text['bookmarks'] = "Zak�adki";
$text['bookmark'] = "Dodaj zak�adki";
$text['mngbookmarks'] = "Id� do zak�adek";
$text['bookmarked'] = "Zak�adka dodana";
$text['remove'] = "Usu�";
$text['find_menu'] = "Znajd�";
$text['info'] = "Info"; //this needs to be a very short abbreviation
$text['cemetery'] = "Cmentarz";
$text['gmapevent'] = "Mapa wydarzenia";
$text['gevents'] = "Wydarzenie";
$text['glang'] = "&amp;hl=pl";
$text['googleearthlink'] = "��cze do Google Earth";
$text['googlemaplink'] = "��cze do Google Maps";
$text['gmaplegend'] = "Legenda szpilek";
$text['unmarked'] = "Nieoznakowany";
$text['located'] = "Zlokalizowany";
$text['albclicksee'] = "Kliknij aby pokaza� wszystkie elementy tego albumu";
$text['notyetlocated'] = "Jeszcze nie zlokalizowany";
$text['cremated'] = "Skremowany";
$text['missing'] = "Zaginiony";
$text['pdfgen'] = "Generator PDF";
$text['blank'] = "Pusty diagram";
$text['none'] = "Brak";
$text['fonts'] = "Czcionki";
$text['header'] = "Nag��wek";
$text['data'] = "Dane";
$text['pgsetup'] = "Ustawienia strony";
$text['pgsize'] = "Wielko�� strony";
$text['orient'] = "Ukierunkowanie"; //for a page
$text['portrait'] = "Format pionowy";
$text['landscape'] = "Format poziomy";
$text['tmargin'] = "G�rna kraw�d�";
$text['bmargin'] = "Dolna kraw�d�";
$text['lmargin'] = "Lewa kraw�d�";
$text['rmargin'] = "Prawa kraw�d�";
$text['createch'] = "Tworzenie diagramu";
$text['prefix'] = "Prefix";
$text['mostwanted'] = "Niewyja�nione zagadki";
$text['latupdates'] = "Ostatnia aktualizacja";
$text['featphoto'] = "Przedstawione zdj�cie";
$text['news'] = "Nowo�ci";
$text['ourhist'] = "Historia naszej rodziny";
$text['ourhistanc'] = "Historia i genealogia naszej rodziny";
$text['ourpages'] = "Strona genealogiczna naszej rodziny";
$text['pwrdby'] = "oparty na bazie";
$text['writby'] = "napisanej przez";
$text['searchtngnet'] = "Szukaj w TNG Network (GENDEX)";
$text['viewphotos'] = "Zobacz wszystkie zdj�cia";
$text['anon'] = "Jeste� w tej chwili anonimowy";
$text['whichbranch'] = "Do kt�rej ga��zi nale�ysz?";
$text['featarts'] = "Przedstawione artyku�y";
$text['maintby'] = "Zarz�dzane przez";
$text['createdon'] = "Utworzono dnia";
$text['reliability'] = "Pewno��";
$text['labels'] = "Etykiety";
$text['inclsrcs'] = "Do��cz �r�d�a";
$text['cont'] = "(cont.)"; //abbreviation for continued
$text['mnuheader'] = "Strona domowa";
$text['mnusearchfornames'] = "Szukaj";
$text['mnulastname'] = "Nazwisko";
$text['mnufirstname'] = "Imi�";
$text['mnusearch'] = "Szukaj";
$text['mnureset'] = "Zacznij ponownie";
$text['mnulogon'] = "Zaloguj";
$text['mnulogout'] = "Wyloguj";
$text['mnufeatures'] = "Inne opcje";
$text['mnuregister'] = "Rejestracja nowego<br> konta u�ytkownika";
$text['mnuadvancedsearch'] = "Szukanie zaawansowane";
$text['mnulastnames'] = "Nazwiska";
$text['mnustatistics'] = "Statystyka";
$text['mnuphotos'] = "Zdj�cia";
$text['mnuhistories'] = "Historie";
$text['mnumyancestors'] = "Zdj�cia &amp; Historie przodk�w [osoba]";
$text['mnucemeteries'] = "Lista cmentarzy";
$text['mnutombstones'] = "Nagrobki";
$text['mnureports'] = "Raporty";
$text['mnusources'] = "�r�d�a";
$text['mnuwhatsnew'] = "Co nowego";
$text['mnushowlog'] = "Ostatnie logowania";
$text['mnulanguage'] = "Language (J�zyk)";
$text['mnuadmin'] = "Administracja";
$text['welcome'] = "Zalogowany: ";
$text['contactus'] = "Kontakt";
//changed in 8.0.0
$text['born'] = "Urodzenie";
$text['searchnames'] = "Szukaj";
//added in 8.0.0
$text['editperson'] = "Edytuj osob�";
$text['loadmap'] = "Za�aduj map�";
$text['birth'] = "Urodzenie";
$text['wasborn'] = "urodzony(a)";
$text['startnum'] = "Pierwsza liczba";
$text['searching'] = "Szukanie";
//moved here in 8.0.0
$text['location'] = "Lokalizacja";
$text['association'] = "Relacja";
$text['collapse'] = "Sk�adanie";
$text['expand'] = "Rozszerzanie";
$text['plot'] = "Sektor";
$text['searchfams'] = "Szukaj rodzin�";
//added in 8.0.2
$text['wasmarried'] = "po�lubi�(a)";
$text['anddied'] = "Zgon";
//added in 9.0.0
$text['share'] = "Wsp�lne korzystanie";
$text['hide'] = "Ukryj";
$text['disabled'] = "Twoje konto zosta�o zablokowane. Prosimy o kontakt z administratorem serwisu w celu uzyskania wi�cej informacji.";
$text['contactus_long'] = "Je�li masz jakie� pytania lub komentarze dotycz�ce informacji na tej stronie, prosimy o <span class=\"emphasis\"><a href=\"suggest.php\">kontakt</a></span>. Czekamy na kontakt z Pa�stwem.";
$text['features'] = "Nowe funkcje";
$text['resources'] = "Zasoby";
$text['latestnews'] = "Aktualno�ci";
$text['trees'] = "Drzewa genealogiczne";
$text['wasburied'] = "was buried";
//moved here in 9.0.0
$text['emailagain'] = "Email ponownie";
$text['enteremail2'] = "Wpisz sw�j email adres ponownie.";
$text['emailsmatch'] = "Twoje maile nie zgadzaj� si�. Wpisz ten sam email adres w ka�dym polu.";
$text['getdirections'] = "Kliknij aby uzyska� po��czenie";
$text['calendar'] = "Kalendarz";
//changed in 9.0.0
$text['directionsto'] = " do ";
$text['slidestart'] = "Pokaz slajd�w";
$text['livingnote'] = "<span style=\"color: #f00; \"><b>Dane os�b �yj�cych ukryte. - Dost�pne po zarejestrowaniu.</b></span>";
$text['livingphoto'] = "<span style=\"color: #f00; \"><b>Detale ukryte poniewa� przynajmniej jedna �yj�ca osoba jest zwi�zana z t� informacj�. - Dost�pne po zarejestrowaniu.</b></span>";
$text['waschristened'] = "Chrzest";
//added in 10.0.0
$text['branches'] = "Ga��zie";
$text['detail'] = "Szczeg�owo";
$text['moredetail'] = "Wi�cej szczeg��w";
$text['lessdetail'] = "Mniej szczeg��w";
$text['otherevents'] = "Inne wydarzenia";
$text['conflds'] = "Konfirmacja (LDS)";
$text['initlds'] = "Inicjacja (LDS)";
$text['wascremated'] = "zosta�/zosta�a skremowany";
//moved here in 11.0.0
$text['text_for'] = "dla";
//added in 11.0.0
$text['searchsite'] = "Przeszukaj t� stron�";
$text['searchsitemenu'] = "Szukaj strony";
$text['kmlfile'] = "Pobierz plik .kml aby pokaza� t� lokalizacj� w Google Earth";
$text['download'] = "Kliknij aby pobra�";
$text['more'] = "Wi�cej";
$text['heatmap'] = "Heat Map";
$text['refreshmap'] = "Od�wie� map�";
$text['remnums'] = "Usu� liczby i zaznaczenia";
$text['photoshistories'] = "Zdj�cia &amp; Historie";
$text['familychart'] = "Wykres rodzinny";
//added in 12.0.0
$text['firstnames'] = "Imiona";
//moved here in 12.0.0
$text['dna_test'] = " Test DNA";
$text['test_type'] = "Rodzaj testu";
$text['test_info'] = "Informacja dotycz�ca testu";
$text['takenby'] = "Pobrane przez";
$text['haplogroup'] = "Haplogrupa";
$text['hvr1'] = "HVR1";
$text['hvr2'] = "HVR2";
$text['relevant_links'] = "Powi�zane linki";
$text['nofirstname'] = "[brak imienia]";
//added in 12.0.1
$text['cookieuse'] = "Uwaga: Ta strona u�ywa plik�w cookie.";
$text['dataprotect'] = "Polityka ochrony danych";
$text['viewpolicy'] = "Zobacz zasady ochrony danych";
$text['understand'] = "Rozumiem";
$text['consent'] = "Wyra�am zgod�, dla tej witryny, na umieszczenie, tu zgromadzonych, dotycz�cych mnie, danych osobowych. Rozumiem, �e mog� poprosi� w�a�ciciela witryny o usuni�cie tych informacji w dowolnym momencie. ";
$text['consentreq'] = "Prosz� wyrazi� zgod� na przechowywanie Twoich danych osobowych w tej witrynie.";

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
$text['dna_info_head'] = "Informacja dotycz�ca testu DNA";
$text['firstpage'] = "Pierwsza strona";
$text['lastpage'] = "Ostatnia strona";

@include_once "captcha_text.php";
@include_once "alltext.php";
if (!$alltextloaded) getAllTextPath();


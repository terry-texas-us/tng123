<?php
switch ($textpart) {
  //browsesources.php, showsource.php
  case "sources":
    $text['browseallsources'] = "S�k i alle kilder";
    $text['shorttitle'] = "Tittel";
    $text['callnum'] = "Plassignatur";
    $text['author'] = "Forfatter";
    $text['publisher'] = "Utgiver";
    $text['other'] = "Andre informasjoner";
    $text['sourceid'] = "Kilde ID";
    $text['moresrc'] = "Flere kilder";
    $text['repoid'] = "Arkiv ID";
    $text['browseallrepos'] = "S�k alle arkiver";
    break;

  //changelanguage.php, savelanguage.php
  case "language":
    $text['newlanguage'] = "Nytt spr�k";
    $text['changelanguage'] = "Bytt Spr�k";
    $text['languagesaved'] = "Spr�k lagret";
    $text['sitemaint'] = "Vedlikehold p�g�r";
    $text['standby'] = "Sidene er midlertidig utilgjengelige mens vi oppdaterer v�r database. Pr�v gjerne igjen senere. Hvis sidene forblir nede i en lengre periode, <a href=\"suggest.php\">ta gjerne kontakt</a>.";
    break;

  //gedcom.php, gedform.php
  case "gedcom":
    $text['gedstart'] = "GEDCOM starter fra";
    $text['producegedfrom'] = "Lag en GEDCOM fil for";
    $text['numgens'] = "Antall generasjoner";
    $text['includelds'] = "Inkluder LDS informajon";
    $text['buildged'] = "Lag GEDCOM";
    $text['gedstartfrom'] = "GEDCOM starter fra";
    $text['nomaxgen'] = "Du m� angi antall generasjoner. Bruk Back-knappen for � rette opp feilen";
    $text['gedcreatedfrom'] = "GEDCOM opprettet fra";
    $text['gedcreatedfor'] = "opprettet for";
    $text['creategedfor'] = "Lag GEDCOM";
    $text['email'] = "E-postadresse";
    $text['suggestchange'] = "Foresl� en endring";
    $text['yourname'] = "Ditt navn";
    $text['comments'] = "Kommentarer";
    $text['comments2'] = "Kommentarer";
    $text['submitsugg'] = "Send forslag";
    $text['proposed'] = "Foresl�tt endring";
    $text['mailsent'] = "Takk. Din melding er sendt.";
    $text['mailnotsent'] = "Vi beklager, men meldingen kunne ikke leveres. Vennligst kontakt xxx direkte p� yyy.";
    $text['mailme'] = "Send en kopi til denne adressen";
    $text['entername'] = "Skriv inn ditt navn";
    $text['entercomments'] = "Skriv dine kommentarer";
    $text['sendmsg'] = "Send melding";
    //added in 9.0.0
    $text['subject'] = "Emne";
    break;

  //getextras.php, getperson.php
  case "getperson":
    $text['photoshistoriesfor'] = "Bilder og Historier";
    $text['indinfofor'] = "Personside for";
    $text['pp'] = "s."; //page abbreviation
    $text['age'] = "Alder";
    $text['agency'] = "Firma";
    $text['cause'] = "�rsak";
    $text['suggested'] = "Foresl�tt";
    $text['closewindow'] = "Lukk vinduet";
    $text['thanks'] = "Takk";
    $text['received'] = "Ditt forslag er sendt til Administrator for vurdering.";
    $text['indreport'] = "Personrapport";
    $text['indreportfor'] = "Personrapport for";
    $text['general'] = "Generelt";
    $text['bkmkvis'] = "<strong>NB:</strong> Disse bokmerkene er kun synlige p� denne datamaskinen og i denne nettleseren.";
    //added in 9.0.0
    $text['reviewmsg'] = "Du har mottatt et endringsforslag som krever din gjennomgang. Endringsforslaget gjelder:";
    $text['revsubject'] = "Endringsforslag krever din gjennomgang";
    break;

  //relateform.php, relationship.php, findpersonform.php, findperson.php
  case "relate":
    $text['relcalc'] = "Beregning av slektskap";
    $text['findrel'] = "Finn slektskap";
    $text['person1'] = "Person 1:";
    $text['person2'] = "Person 2:";
    $text['calculate'] = "Beregn";
    $text['select2inds'] = "Vennligst velg to personer.";
    $text['findpersonid'] = "Finn personID";
    $text['enternamepart'] = "angi del av fornavn og/eller etternavn";
    $text['pleasenamepart'] = "Anngi en del av fornavn eller etternavn.";
    $text['clicktoselect'] = "klikk for � velge";
    $text['nobirthinfo'] = "Ingen informasjon om f�dsel";
    $text['relateto'] = "Slektskap til";
    $text['sameperson'] = "De to personene er samme person.";
    $text['notrelated'] = "De to personene er ikke i slektskap innen xxx generasjoner."; //xxx will be replaced with number of generations
    $text['findrelinstr'] = "For � vise slektskap mellom to personer, bruk 'Finn' knappene nedenfor til � angi  to personer (eller behold viste personer, hvis relevante), klikk deretter p� 'Beregn'.";
    $text['sometimes'] = "(Noen ganger kan en ved � sjekke et annet antall generasjoner, f� et annet resultat.)";
    $text['findanother'] = "Finn andre slektskap";
    $text['brother'] = "bror til";
    $text['sister'] = "s�ster til";
    $text['sibling'] = "s�sken til";
    $text['uncle'] = "xxx onkel til";
    $text['aunt'] = "xxx tante til";
    $text['uncleaunt'] = "xxx onkel/tante til";
    $text['nephew'] = "xxx nev� til";
    $text['niece'] = "xxx niese til";
    $text['nephnc'] = "xxx nev�/niese til";
    $text['removed'] = "generasjoner forskj�vet";
    $text['rhusband'] = "ektemann til ";
    $text['rwife'] = "kone til ";
    $text['rspouse'] = "ektefelle til ";
    $text['son'] = "s�nn til";
    $text['daughter'] = "datter til";
    $text['rchild'] = "barn til";
    $text['sil'] = "svigers�nn til";
    $text['dil'] = "svigerdatter til";
    $text['sdil'] = "svigers�nn eller svigerdatter til";
    $text['gson'] = "xxx barnebarn til";
    $text['gdau'] = "xxx barnebarn til";
    $text['gsondau'] = "xxx barnebarn til";
    $text['great'] = "great";
    $text['spouses'] = "er ektefeller";
    $text['is'] = "er";
    $text['changeto'] = "Bytt til (skriv inn ID):";
    $text['notvalid'] = "er ikke et gyldig ID-nummer i denne databasen. Pr�v igjen.";
    $text['halfbrother'] = "halvbror til";
    $text['halfsister'] = "halvs�ster til";
    $text['halfsibling'] = "halvs�sken til";
    //changed in 8.0.0
    $text['gencheck'] = "Maks antall generasjoner<br>� sjekke";
    $text['mcousin'] = "xxx fetter yyy til";  //male cousin; xxx = cousin number, yyy = times removed
    $text['fcousin'] = "xxx kusine yyy til";  //female cousin
    $text['cousin'] = "xxx s�skenbarn yyy til";
    $text['mhalfcousin'] = "xxx halvfetter yyy til";  //male cousin
    $text['fhalfcousin'] = "xxx halvkusine yyy til";  //female cousin
    $text['halfcousin'] = "xxx halvs�skenbarn yyy til";
    //added in 8.0.0
    $text['oneremoved'] = "en generasjon forskj�vet";
    $text['gfath'] = "xxx bestefar til";
    $text['gmoth'] = "xxx bestemor til";
    $text['gpar'] = "xxx besteforelder til";
    $text['mothof'] = "mor til";
    $text['fathof'] = "far til";
    $text['parof'] = "forelder til";
    $text['maxrels'] = "Maksimum slektskap � vise";
    $text['dospouses'] = "Vis slektskap som involverer en partner";
    $text['rels'] = "Slektskap";
    $text['dospouses2'] = "Vis partnere";
    $text['fil'] = "svigerfar til";
    $text['mil'] = "svigermor til";
    $text['fmil'] = "sviger til";
    $text['stepson'] = "stes�nn av";
    $text['stepdau'] = "stedatter av";
    $text['stepchild'] = "stebarn av";
    $text['stepgson'] = "xxx step-grandson of";
    $text['stepgdau'] = "the xxx step-granddaughter of";
    $text['stepgchild'] = "xxx ste-barnebarn av";
    //added in 8.1.1
    $text['ggreat'] = "great";
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
    $text['guncle'] = "xxx grandonkel til";
    $text['gaunt'] = "xxx grandtante til";
    $text['guncleaunt'] = "xxx grand- onkel/tante til";
    $text['gnephew'] = "xxx 'grandnev�' til";
    $text['gniece'] = "xxx 'grandniese' til";
    $text['gnephnc'] = "xxx 'grand- nev�/niese' til";
    break;

  case "familygroup":
    $text['familygroupfor'] = "Familieskjema for";
    $text['ldsords'] = "LDS Ordinasjon";
    $text['baptizedlds'] = "D�pt (LDS)";
    $text['endowedlds'] = "Velsignet (LDS)";
    $text['sealedplds'] = "Bekreftet P (LDS)";
    $text['sealedslds'] = "Bekreftet S (LDS)";
    $text['otherspouse'] = "Andre partnere";
    $text['husband'] = "Mann";
    $text['wife'] = "Hustru";
    break;

  //pedigree.php
  case "pedigree":
    $text['capbirthabbr'] = "F";
    $text['capaltbirthabbr'] = "A";
    $text['capdeathabbr'] = "D";
    $text['capburialabbr'] = "G";
    $text['capplaceabbr'] = "S";
    $text['capmarrabbr'] = "G";
    $text['capspouseabbr'] = "E/P";
    $text['redraw'] = "Tegn p� nytt med";
    $text['scrollnote'] = "NB: Du m� kanskje bla ned for � se hele treet.";
    $text['unknownlit'] = "Ukjent";
    $text['popupnote1'] = " = Tilleggsinformasjon";
    $text['popupnote2'] = " = Nytt anetre";
    $text['pedcompact'] = "Kompakt";
    $text['pedstandard'] = "Standard";
    $text['pedtextonly'] = "Bare Tekst";
    $text['descendfor'] = "Etterkommere av";
    $text['maxof'] = "Maksimum";
    $text['gensatonce'] = "generasjoner vist samtidig.";
    $text['sonof'] = "s�nn av";
    $text['daughterof'] = "datter av";
    $text['childof'] = "barn av";
    $text['stdformat'] = "Standard Format";
    $text['ahnentafel'] = "Generasjonsliste";
    $text['addnewfam'] = "Legg til ny familie";
    $text['editfam'] = "Rediger familie";
    $text['side'] = "Side";
    $text['familyof'] = "Familie til";
    $text['paternal'] = "Far";
    $text['maternal'] = "Mor";
    $text['gen1'] = "Selv";
    $text['gen2'] = "Foreldre";
    $text['gen3'] = "Besteforeldre";
    $text['gen4'] = "Oldeforeldre";
    $text['gen5'] = "Tippoldeforeldre";
    $text['gen6'] = "Tipptipp-oldeforeldre";
    $text['gen7'] = "3.tipp-oldeforeldre";
    $text['gen8'] = "4.tipp-oldeforeldre";
    $text['gen9'] = "5.tipp-oldeforeldre";
    $text['gen10'] = "6.tipp-oldeforeldre";
    $text['gen11'] = "7.tipp-oldeforeldre";
    $text['gen12'] = "8.tipp-oldeforeldre";
    $text['graphdesc'] = "Etterslektstre til dette punkt";
    $text['pedbox'] = "Boks";
    $text['regformat'] = "Generasjon Format";
    $text['extrasexpl'] = "Dersom bilder eller historier finnes for denne personen, vil et ikon vises sammen med navnet.";
    $text['popupnote3'] = " = Nytt skjema";
    $text['mediaavail'] = "Tilgjengelig media";
    $text['pedigreefor'] = "Anetre for";
    $text['pedigreech'] = "Anetre";
    $text['datesloc'] = "Datoer og steder";
    $text['borchr'] = "F�dsel/Alt - D�d/Gravlagt (to)";
    $text['nobd'] = "Ingen datoer for f�dsel eller d�d";
    $text['bcdb'] = "F�dsel/Alt/D�d/Gravlagt (fire)";
    $text['numsys'] = "Nummer-system";
    $text['gennums'] = "Generasjonsnummer";
    $text['henrynums'] = "Henry nummer";
    $text['abovnums'] = "d'Aboville nummer";
    $text['devnums'] = "de Villiers nummer";
    $text['dispopts'] = "Visning";
    //added in 10.0.0
    $text['no_ancestors'] = "Ingen aner funnet";
    $text['ancestor_chart'] = "Vertikalt anetre";
    $text['opennewwindow'] = "�pne i et nytt vindu";
    $text['pedvertical'] = "Vertikalt";
    //added in 11.0.0
    $text['familywith'] = "Familie med";
    $text['fcmlogin'] = "Logg inn for � se detaljer";
    $text['isthe'] = "som vises er";
    $text['otherspouses'] = "Andre partnere";
    $text['parentfamily'] = "Familien ";
    $text['showfamily'] = "Vis denne familien";
    $text['shown'] = "vist";
    $text['showparentfamily'] = "Vis foreldres familie";
    $text['showperson'] = "Vis person";
    //added in 11.0.2
    $text['otherfamilies'] = "Andre familier";
    break;

  //search.php, searchform.php
  //merged with reports and showreport in 5.0.0
  case "search":
  case "reports":
    $text['noreports'] = "Det finnes ingen rapporter.";
    $text['reportname'] = "Rapportnavn";
    $text['allreports'] = "Alle rapporter";
    $text['report'] = "Rapport";
    $text['error'] = "Feil";
    $text['reportsyntax'] = "Syntaksen for sp�rringen til denne rapporten";
    $text['wasincorrect'] = "var feil, og sp�rringen kunne derfor ikke bli utf�rt. Vennligst kontakt system administrator p�";
    $text['errormessage'] = "Feilmelding";
    $text['equals'] = "lik";
    $text['endswith'] = "slutter med";
    $text['soundexof'] = "soundex av";
    $text['metaphoneof'] = "metaphone av";
    $text['plusminus10'] = "+/- 10 �r";
    $text['lessthan'] = "mindre enn";
    $text['greaterthan'] = "st�rre enn";
    $text['lessthanequal'] = "mindre enn eller lik";
    $text['greaterthanequal'] = "st�rre enn eller lik";
    $text['equalto'] = "lik";
    $text['tryagain'] = "Vennligst pr�v igjen";
    $text['joinwith'] = "Kombiner med";
    $text['cap_and'] = "OG";
    $text['cap_or'] = "ELLER";
    $text['showspouse'] = "Vis ektefelle(r)/partner(e)";
    $text['submitquery'] = "Start s�k";
    $text['birthplace'] = "F�dested";
    $text['deathplace'] = "D�d sted";
    $text['birthdatetr'] = "F�dt �r";
    $text['deathdatetr'] = "D�d �r";
    $text['plusminus2'] = "+/- 2 �r";
    $text['resetall'] = "T�m alle felt";
    $text['showdeath'] = "Vis informasjon om d�d/begravelse,";
    $text['altbirthplace'] = "D�pt sted";
    $text['altbirthdatetr'] = "D�pt �r";
    $text['burialplace'] = "Gravlagt sted";
    $text['burialdatetr'] = "Gravlagt �r";
    $text['event'] = "Hendelse(r)";
    $text['day'] = "Dag";
    $text['month'] = "M�ned";
    $text['keyword'] = "N�kkelord (f.eks. \"Abt\")";
    $text['explain'] = "Skriv del av dato for � finne sammenfallende hendelser. La feltet v�re tomt for � se treff p� alle.";
    $text['enterdate'] = "Skriv inn eller velg minst ett av f�lgende: dag, m�ned, �r, n�kkelord";
    $text['fullname'] = "Fullt navn";
    $text['birthdate'] = "F�dt dato";
    $text['altbirthdate'] = "D�pt dato";
    $text['marrdate'] = "Gift dato";
    $text['spouseid'] = "Partners ID";
    $text['spousename'] = "Partners navn";
    $text['deathdate'] = "D�d dato";
    $text['burialdate'] = "Gravlagt dato";
    $text['changedate'] = "Sist endret dato";
    $text['gedcom'] = "Tre";
    $text['baptdate'] = "D�p dato (LDS)";
    $text['baptplace'] = "D�p sted (LDS)";
    $text['endldate'] = "Velsignelse dato (LDS)";
    $text['endlplace'] = "Velsignelse sted (LDS)";
    $text['ssealdate'] = "Bekreftet dato S (LDS)";   //Sealed to spouse
    $text['ssealplace'] = "Bekreftet sted S (LDS)";
    $text['psealdate'] = "Bekreftet dato P (LDS)";   //Sealed to parents
    $text['psealplace'] = "Bekreftet sted P (LDS)";
    $text['marrplace'] = "Gift sted";
    $text['spousesurname'] = "Ektefelles/partners etternavn";
    $text['spousemore'] = "Dersom du skriver inn 'Ektefelles/partners etternavn', m� du i tillegg fylle inn minst ett felt til.";
    $text['plusminus5'] = "+/- 5 �r";
    $text['exists'] = "eksisterer";
    $text['dnexist'] = "eksisterer ikke";
    $text['divdate'] = "Skilt Dato";
    $text['divplace'] = "Skilt Sted";
    $text['otherevents'] = "Andre hendelser";
    $text['numresults'] = "Resultat per side";
    $text['mysphoto'] = "Ukjente bilder";
    $text['mysperson'] = "Ikke identifisert";
    $text['joinor'] = "Valget 'sl� sammen med OR' kan ikke brukes med ektefelles/partners etternavn";
    $text['tellus'] = "Fortell oss hva du vet";
    $text['moreinfo'] = "Mer informasjon:";
    //added in 8.0.0
    $text['marrdatetr'] = "Gift �r";
    $text['divdatetr'] = "Skilt �r";
    $text['mothername'] = "Mors navn";
    $text['fathername'] = "Fars navn";
    $text['filter'] = "Filter";
    $text['notliving'] = "Lever ikke";
    $text['nodayevents'] = "Hendelser denne m�neden som ikke er assosiert med en spesifikk dag:";
    //added in 9.0.0
    $text['csv'] = "Kommaseparert CSV fil";
    //added in 10.0.0
    $text['confdate'] = "Konfirmasjonsdato (LDS)";
    $text['confplace'] = "Konfirmasjonssted (LDS)";
    $text['initdate'] = "Initiatory Date (LDS)";
    $text['initplace'] = "Initiatory Place (LDS)";
    //added in 11.0.0
    $text['marrtype'] = "Type ekteskap";
    $text['searchfor'] = "S�k etter";
    $text['searchnote'] = "Merk: Denne siden bruker Google for � utf�re s�ket. Antallet s�ketreff er avhengig av i hvilken grad Google har v�rt i stand til � indeksere dette nettstedet.";
    break;

  //showlog.php
  case "showlog":
    $text['logfilefor'] = "Logg for";
    $text['mostrecentactions'] = "Siste hendelser";
    $text['autorefresh'] = "Automatisk oppdatering (30 sekunder)";
    $text['refreshoff'] = "Sl� av automatisk oppdatering";
    break;

  case "headstones":
  case "showphoto":
    $text['cemeteriesheadstones'] = "Kirkeg�rder og gravsteiner";
    $text['showallhsr'] = "Vis alle gravsteiner";
    $text['in'] = "i";
    $text['showmap'] = "Vis kart";
    $text['headstonefor'] = "Gravstein til";
    $text['photoof'] = "Bilde av";
    $text['photoowner'] = "Eier/kilde";
    $text['nocemetery'] = "Ingen kirkeg�rder";
    $text['iptc005'] = "Tittel";
    $text['iptc020'] = "Tilleggskategorier";
    $text['iptc040'] = "Spesielle instruksjoner";
    $text['iptc055'] = "Opprettet dato";
    $text['iptc080'] = "Forfatter";
    $text['iptc085'] = "Forfatters stilling";
    $text['iptc090'] = "By";
    $text['iptc095'] = "Kommune/Fylke";
    $text['iptc101'] = "Land";
    $text['iptc103'] = "Referanse for overf�ring";
    $text['iptc105'] = "Overskrift";
    $text['iptc110'] = "Kilde";
    $text['iptc115'] = "Bilde kilde";
    $text['iptc116'] = "Opphavsrett";
    $text['iptc120'] = "Tekst";
    $text['iptc122'] = "Tekstforfatter";
    $text['mapof'] = "Kart over";
    $text['regphotos'] = "Beskrivelse";
    $text['gallery'] = "Kun miniatyrbilder";
    $text['cemphotos'] = "Kirkeg�rdsbilder";
    $text['photosize'] = "Dimensjoner";
    $text['iptc010'] = "Prioritet";
    $text['filesize'] = "Filst�rrelse";
    $text['seeloc'] = "Se lokasjon";
    $text['showall'] = "Vis alle";
    $text['editmedia'] = "Rediger media";
    $text['viewitem'] = "Se p� dette";
    $text['editcem'] = "Rediger kirkeg�rd";
    $text['numitems'] = "Antall";
    $text['allalbums'] = "Alle album";
    $text['slidestop'] = "Pause lysbildefremvisning";
    $text['slideresume'] = "Fortsett lysbildefremvisning";
    $text['slidesecs'] = "Sekunder for hvert bilde:";
    $text['minussecs'] = "minus 0,5 sekunder";
    $text['plussecs'] = "pluss 0,5 sekunder";
    $text['nocountry'] = "Ukjent land";
    $text['nostate'] = "Ukjent Stat/Provins/Grevskap";
    $text['nocounty'] = "Ukjent Fylke/Sokn";
    $text['nocity'] = "Ukjent by";
    $text['nocemname'] = "Ukjent kirkeg�rd";
    $text['editalbum'] = "Rediger album";
    $text['mediamaptext'] = "<strong>NB:</strong> Beveg muspekeren over bildet for � vise navnet. Klikk for � vise en side for hvert navn.";
    //added in 8.0.0
    $text['allburials'] = "Alle begravelser";
    $text['moreinfo'] = "Mer informasjon:";
    //added in 9.0.0
    $text['iptc025'] = "S�keord";
    $text['iptc092'] = "Sted";
    $text['iptc015'] = "Kategori";
    $text['iptc065'] = "Opprettet i program";
    $text['iptc070'] = "Programversjon";
    break;

  //surnames.php, surnames100.php, surnames-all.php, surnames-oneletter.php
  case "surnames":
  case "places":
    $text['surnamesstarting'] = "Vis etternavn som starter med";
    $text['showtop'] = "Vis topp";
    $text['showallsurnames'] = "Vis alle etternavn";
    $text['sortedalpha'] = "sortert alfabetisk";
    $text['byoccurrence'] = "sortert etter forekomst";
    $text['firstchars'] = "F�rste bokstav";
    $text['mainsurnamepage'] = "Etternavnside";
    $text['allsurnames'] = "Alle Etternavn";
    $text['showmatchingsurnames'] = "Klikk p� et etternavn for � se data.";
    $text['backtotop'] = "Tilbake til toppen";
    $text['beginswith'] = "Begynner med";
    $text['allbeginningwith'] = "Alle etternavn som begynner med";
    $text['numoccurrences'] = "totalt antall ganger omr�denavnet er brukt i fulle stedsnavn i parentes";
    $text['placesstarting'] = "Vis st�rste omr�der som starter med";
    $text['showmatchingplaces'] = "Klikk p� et sted for � vise et snevrere omr�de. Klikk p� s�keikonet for � vise personer med tilknytning til omr�det eller stedet.";
    $text['totalnames'] = "totalt antall personer";
    $text['showallplaces'] = "Vis alle omr�der av st�rst geografisk omfang";
    $text['totalplaces'] = "totalt antall steder";
    $text['mainplacepage'] = "Steders hovedside";
    $text['allplaces'] = "Alle steder av st�rst geografisk omfang";
    $text['placescont'] = "Vis alle steder som inneholder";
    //changed in 8.0.0
    $text['top30'] = "Topp xxx etternavn";
    $text['top30places'] = "Topp xxx st�rste omr�der";
    //added in 12.0.0
    $text['firstnamelist'] = "Fornavnsliste";
    $text['firstnamesstarting'] = "Vis fornavn som starter med";
    $text['showallfirstnames'] = "Vis alle fornavn";
    $text['mainfirstnamepage'] = "Fornavnside";
    $text['allfirstnames'] = "Alle fornavn";
    $text['showmatchingfirstnames'] = "Klikk p� et fornavn for � se data.";
    $text['allfirstbegwith'] = "Alle fornavn som begynner med";
    $text['top30first'] = "Topp xxx fornavn";
    $text['allothers'] = "Alle andre";
    $text['amongall'] = "(blant alle navn)";
    $text['justtop'] = "Bare topp xxx";
    break;

  //whatsnew.php
  case "whatsnew":
    $text['pastxdays'] = "(siste xx dagene)";

    $text['photo'] = "Bilder";
    $text['history'] = "Historie/Dokument";
    $text['husbid'] = "Fars ID";
    $text['husbname'] = "Fars navn";
    $text['wifeid'] = "Mors ID";
    //added in 11.0.0
    $text['wifename'] = "Mors navn";
    break;

  //timeline.php, timeline2.php
  case "timeline":
    $text['text_delete'] = "Slett";
    $text['addperson'] = "Legg til person";
    $text['nobirth'] = "F�lgende person har ikke gyldig f�dselsdato og kan derfor ikke oppdateres";
    $text['event'] = "Hendelse(r)";
    $text['chartwidth'] = "Diagrambredde";
    $text['timelineinstr'] = "Legg til inntil fire personer (om gangen) ved � legge inn deres ID i feltene under";
    $text['togglelines'] = "Linjer av/p�";
    //changed in 9.0.0
    $text['noliving'] = "F�lgende person er merket som n�levende eller privat og kan ikke oppdateres fordi du ikke er logget inn med n�dvendige tillatelser";
    break;

  //browsetrees.php
  //login.php, newacctform.php, addnewacct.php
  case "trees":
  case "login":
    $text['browsealltrees'] = "S�k i alle tr�r";
    $text['treename'] = "Treets navn";
    $text['owner'] = "Eier";
    $text['address'] = "Adresse";
    $text['city'] = "By";
    $text['state'] = "Stat/Fylke";
    $text['zip'] = "Postnummer";
    $text['country'] = "Land";
    $text['email'] = "E-postadresse";
    $text['phone'] = "Telefon";
    $text['username'] = "Brukernavn";
    $text['password'] = "Passord";
    $text['loginfailed'] = "Feil ved p�logging.";

    $text['regnewacct'] = "Registrer ny bruker";
    $text['realname'] = "Fullt navn";
    $text['phone'] = "Telefon";
    $text['email'] = "E-postadresse";
    $text['address'] = "Adresse";
    $text['acctcomments'] = "Kommentarer";
    $text['submit'] = "Send";
    $text['leaveblank'] = "(la v�re �pent hvis du �nsker et nytt tre)";
    $text['required'] = "Obligatoriske felt";
    $text['enterpassword'] = "Angi et passord.";
    $text['enterusername'] = "Angi brukernavn.";
    $text['failure'] = "Beklager, men brukernavnet du oppgav er allerede i bruk. Bruk tilbaketasten og velg et annet brukernavn.";
    $text['success'] = "Tusen takk. Vi har mottatt din registrering. Vi tar kontakt n�r din konto er aktivert eller hvis vi trenger mer informasjon.";
    $text['emailsubject'] = "Foresp�rsel om ny TNG brukerkonto";
    $text['website'] = "Nettsted";
    $text['nologin'] = "Har du ikke brukernavn?";
    $text['loginsent'] = "Din p�loggingsinformasjon er sendt";
    $text['loginnotsent'] = "Din p�loggingsinformasjon er ikke sendt";
    $text['enterrealname'] = "Skriv ditt navn.";
    $text['rempass'] = "Forbli innlogget p� denne datamaskinen";
    $text['morestats'] = "Mer statistikk";
    $text['accmail'] = "<strong>NB:</strong> For � kunne motta e-post fra Administrator, m� du p�se at du ikke blokkerer e-post fra dette domenet.";
    $text['newpassword'] = "Nytt passord";
    $text['resetpass'] = "Tilbakestill passordet ditt";
    $text['nousers'] = "Dette skjema kan ikke brukes f�r minst en brukerkonto er opprettet. Dersom du har adminrettigheter, g� til Administrasjon/Brukere for � opprette din Administratorkonto.";
    $text['noregs'] = "Beklager, men vi tar ikke imot flere brukere for �yeblikket. Vennligst <a href=\"suggest.php\">ta kontakt</a> direkte hvis du har noen kommentarer.";
    //changed in 8.0.0
    $text['emailmsg'] = "Du har mottatt en foresp�rsel om en ny TNG brukerkonto. Logg inn i TNG Adminstrasjonsomr�de og tildel n�dvendige tillatelser for den nye brukeren. Dersom du godkjenner denne registreringen m� du gi beskjed til s�ker ved � svare p� denne meldingen.";
    $text['accactive'] = "Brukerkontoen er aktivert, men brukeren vil ikke ha noen spesielle rettigheter f�r du tildeler disse.";
    $text['accinactive'] = "G� til Administrasjon/Brukere/Vurder for � f� tilgang til brukerkontoinnstillinger. Kontoen vil forbli inaktiv inntil du redigerer og lagrer minst en gang.";
    $text['pwdagain'] = "Gjenta passord";
    $text['enterpassword2'] = "Vennligst oppgi passordet igjen";
    $text['pwdsmatch'] = "Passordene er ikke like. Vennligst skriv samme passord i hvert felt.";
    //added in 8.0.0
    $text['acksubject'] = "Takk for at du registrerte deg"; //for a new user account
    $text['ackmessage'] = "Din foresp�rsel om brukerkonto er mottatt. Kontoen vil ikke bli aktivert f�r Administrator har godkjent den. Du vil f� tilsendt mail n�r brukerkontoen er klar for innlogging.";
    //added in 12.0.0
    $text['switch'] = "Bytt";
    break;

  //added in 10.0.0
  case "branches":
    $text['browseallbranches'] = "Bla i alle Grener";
    break;

  //statistics.php
  case "stats":
    $text['quantity'] = "St�rrelser";
    $text['totindividuals'] = "Antall personer";
    $text['totmales'] = "Antall menn";
    $text['totfemales'] = "Antall kvinner";
    $text['totunknown'] = "Antall ukjent kj�nn";
    $text['totliving'] = "Antall n�levende";
    $text['totfamilies'] = "Antall familier";
    $text['totuniquesn'] = "Antall unike etternavn";
    //$text['totphotos'] = "Total Photos";
    //$text['totdocs'] = "Total Histories &amp; Documents";
    //$text['totheadstones'] = "Total Headstones";
    $text['totsources'] = "Antall kilder";
    $text['avglifespan'] = "Gjennomsnittlig levetid";
    $text['earliestbirth'] = "Tidligste f�dselsdato";
    $text['longestlived'] = "Lengstlevende";
    $text['days'] = "dager";
    $text['age'] = "Alder";
    $text['agedisclaimer'] = "Aldersrelaterte beregninger er basert p� personer registrert med f�dselsdato <EM>og</EM> dato for d�d.  Grunnet felter med ukomplette datoer (f.eks, d�dsdato skrevet som \"1945\" eller \"F�r 1860\"), kan disse beregningene ikke v�re 100% n�yaktige.";
    $text['treedetail'] = "Mere informasjon om dette slektstreet";
    $text['total'] = "Antall";
    //added in 12.0
    $text['totdeceased'] = "Antall avd�de";
    break;

  case "notes":
    $text['browseallnotes'] = "Bla gjennom alle notater";
    break;

  case "help":
    $text['menuhelp'] = "Meny n�kkel";
    break;

  case "install":
    $text['perms'] = "Alle rettigheter er satt.";
    $text['noperms'] = "Rettigheter kunne ikke bli satt for disse filene:";
    $text['manual'] = "Vennligst sett de manuelt.";
    $text['folder'] = "Mappe";
    $text['created'] = "har blitt opprettet";
    $text['nocreate'] = "kunne ikke opprettes. Vennligst opprett manuelt.";
    $text['infosaved'] = "Informasjon lagret, forbindelse bekreftet!";
    $text['tablescr'] = "Tabellene har blitt opprettet!";
    $text['notables'] = "F�lgende tabeller kunne ikke bli opprettet:";
    $text['nocomm'] = "TNG har ikke kontakt med databasen. Ingen tabeller ble opprettet.";
    $text['newdb'] = "Informasjon lagret, forbindelse bekreftet, ny database opprettet:";
    $text['noattach'] = "Informasjon lagret. Ny database opprettet, men TNG kan ikke koble seg til den.";
    $text['nodb'] = "Informasjon lagret. Tilkobling fors�kt, men databasen finnes ikke og kan ikke bli opprettet. Vennligst kontroller at navnet p� databasen er korrekt, eller bruk 'cpanel' for � opprette den.";
    $text['noconn'] = "Informasjon lagret men forbindelsen sviktet. En eller flere av f�lgende er feil:";
    $text['exists'] = "eksisterer";
    $text['loginfirst'] = "Du m� f�rst logge p�.";
    $text['noop'] = "Ingenting ble gjort.";
    //added in 8.0.0
    $text['nouser'] = "Brukerkonto ble ikke opprettet. Brukernavnet kan v�re brukt tidligere.";
    $text['notree'] = "Tre ble ikke opprettet. Samme tre ID kan v�re opprettet tidligere.";
    $text['infosaved2'] = "Informasjon lagret";
    $text['renamedto'] = "endret navn til";
    $text['norename'] = "kunne ikke endre navn";
    break;

  case "imgviewer":
    $text['zoomin'] = "Zoom inn";
    $text['zoomout'] = "Zoom ut";
    $text['magmode'] = "Forst�rrelsesmodus";
    $text['panmode'] = "Panoreringsmodus";
    $text['pan'] = "Klikk og dra for � flytte innenfor bildet";
    $text['fitwidth'] = "Tilpass bredde";
    $text['fitheight'] = "Tilpass h�yde";
    $text['newwin'] = "Nytt vindu";
    $text['opennw'] = "�pne bilde i et nytt vindu";
    $text['magnifyreg'] = "Klikk for � forst�rre et omr�de av bildet";
    $text['imgctrls'] = "Aktiver bildekontroller";
    $text['vwrctrls'] = "Aktiver bildevisningskontroller";
    $text['vwrclose'] = "Lukk bildevisning";
    break;

  case "dna":
    $text['test_date'] = "Testdato";
    $text['links'] = "Relevante linker";
    $text['testid'] = "Test ID";
    //added in 12.0.0
    $text['mode_values'] = "'Mode' verdier";
    $text['compareselected'] = "Sammenlign valgte";
    $text['dnatestscompare'] = "Sammenligne Y-DNA tester";
    $text['keep_name_private'] = "Hold navn Privat";
    $text['browsealltests'] = "S�k i alle tester";
    $text['all_dna_tests'] = "Alle DNA tester";
    $text['fastmutating'] = "Hurtigere&nbsp;mutasjonsrate";
    $text['alltypes'] = "Alle typer";
    $text['allgroups'] = "Alle grupper";
    $text['Ydna_LITbox_info'] = "Test(er) koblet til denne personen ble ikke n�dvendigvis tatt av denne personen.<br>'Haplogruppe' kolonnen viser data i r�dt hvis resultatet er 'Beregnet' eller gr�nt hvis testen er 'Bekreftet'";
    //added in 12.1.0
    $text['dnatestscompare_mtdna'] = "Sammenlign valgte mtDNA tester";
    $text['dnatestscompare_atdna'] = "Sammenlign valgte atDNA tester";
    $text['chromosome'] = "Kromosom";
    $text['centiMorgans'] = "cM";
    $text['snps'] = "SNP'er";
    $text['y_haplogroup'] = "Y-DNA";
    $text['mt_haplogroup'] = "mtDNA";
    $text['sequence'] = "Ref";
    $text['extra_mutations'] = "Ekstra mutasjoner";
    $text['mrca'] = "Yngste felles ane";
    $text['ydna_test'] = "Y-DNA tester";
    $text['mtdna_test'] = "mtDNA (Mitokondrial) tester";
    $text['atdna_test'] = "atDNA (autosomal) tester";
    $text['segment_start'] = "Start";
    $text['segment_end'] = "Slutt";
    $text['suggested_relationship'] = "Foresl�tt";
    $text['actual_relationship'] = "Faktisk";
    $text['12markers'] = "Mark�rer 1-12";
    $text['25markers'] = "Mark�rer 13-25";
    $text['37markers'] = "Mark�rer 26-37";
    $text['67markers'] = "Mark�rer 38-67";
    $text['111markers'] = "Mark�rer 68-111";
    break;
}

//common
$text['matches'] = "Treff";
$text['description'] = "Beskrivelse";
$text['notes'] = "Notater";
$text['status'] = "Status";
$text['newsearch'] = "Nytt S�k";
$text['pedigree'] = "Anetre";
$text['seephoto'] = "Se bilde";
$text['andlocation'] = "& lokasjon";
$text['accessedby'] = "utf�rt av";
$text['family'] = "Familie"; //from getperson
$text['children'] = "Barn";  //from getperson
$text['tree'] = "Tre";
$text['alltrees'] = "Alle Tr�r";
$text['nosurname'] = "[mangler etternavn]";
$text['thumb'] = "Miniatyrbilde";  //as in Thumbnail
$text['people'] = "Personer";
$text['title'] = "Tittel";  //from getperson
$text['suffix'] = "Suffiks";  //from getperson
$text['nickname'] = "Kallenavn";  //from getperson
$text['lastmodified'] = "Sist endret";  //from getperson
$text['married'] = "Gift";  //from getperson
//$text['photos'] = "Photos";
$text['name'] = "Navn"; //from showmap
$text['lastfirst'] = "Etternavn, Fornavn";  //from search
$text['bornchr'] = "F�dt/D�pt";  //from search
$text['individuals'] = "Personer";  //from whats new
$text['families'] = "Familier";
$text['personid'] = "Person ID";
$text['sources'] = "Kilder";  //from getperson (next several)
$text['unknown'] = "Ukjent";
$text['father'] = "Far";
$text['mother'] = "Mor";
$text['christened'] = "D�pt";
$text['died'] = "D�d";
$text['buried'] = "Gravlagt";
$text['spouse'] = "Ektefelle/partner";  //from search
$text['parents'] = "Foreldre";  //from pedigree
$text['text'] = "Tekst";  //from sources
$text['language'] = "Spr�k";  //from languages
$text['descendchart'] = "Etterkommere";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Person";
$text['edit'] = "Rediger";
$text['date'] = "Dato";
$text['place'] = "Sted";
$text['login'] = "Logg inn";
$text['logout'] = "Logg ut";
$text['groupsheet'] = "Gruppeskjema";
$text['text_and'] = "og";
$text['generation'] = "Generasjon";
$text['filename'] = "Filnavn";
$text['id'] = "ID";
$text['search'] = "S�k";
$text['user'] = "Bruker";
$text['firstname'] = "Fornavn";
$text['lastname'] = "Etternavn";
$text['searchresults'] = "S�keresultat";
$text['diedburied'] = "D�d/Gravlagt";
$text['homepage'] = "Startside";
$text['find'] = "Finn...";
$text['relationship'] = "Slektskap";    //in German, Verwandtschaft
$text['relationship2'] = "Slektskap"; //different in some languages, at least in German (Beziehung)
$text['timeline'] = "Tidslinje";
$text['yesabbr'] = "J";               //abbreviation for 'yes'
$text['divorced'] = "Skilt";
$text['indlinked'] = "Linket til";
$text['branch'] = "Gren";
$text['moreind'] = "Flere personer";
$text['morefam'] = "Flere familier";
$text['source'] = "Kilde";
$text['surnamelist'] = "Etternavnsliste";
$text['generations'] = "Generasjoner";
$text['refresh'] = "Oppdater";
$text['whatsnew'] = "Hva er nytt?";
$text['reports'] = "Rapporter";
$text['placelist'] = "Stedsliste";
$text['baptizedlds'] = "D�pt (LDS)";
$text['endowedlds'] = "Velsignet (LDS)";
$text['sealedplds'] = "Bekreftet P (LDS)";
$text['sealedslds'] = "Bekreftet S (LDS)";
$text['ancestors'] = "Aner";
$text['descendants'] = "Etterkommere";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Dato for siste GEDCOM import";
$text['type'] = "Type";
$text['savechanges'] = "Lagre endringer";
$text['familyid'] = "Famile ID";
$text['headstone'] = "Gravstein";
$text['historiesdocs'] = "Historier";
$text['anonymous'] = "anonymt";
$text['places'] = "Steder";
$text['anniversaries'] = "Datoer og jubileer";
$text['administration'] = "Administrasjon";
$text['help'] = "Hjelp";
//$text['documents'] = "Documents";
$text['year'] = "�r";
$text['all'] = "Alle";
$text['repository'] = "Arkiv";
$text['address'] = "Adresse";
$text['suggest'] = "Foresl�";
$text['editevent'] = "Foresl� en endring av denne hendelsen";
$text['findplaces'] = "Finn alle personer med hendelser p� dette stedet";
$text['morelinks'] = "Flere koblinger";
$text['faminfo'] = "Familieinformasjon";
$text['persinfo'] = "Personlig informasjon";
$text['srcinfo'] = "Kildeinformasjon";
$text['fact'] = "Fakta";
$text['goto'] = "Velg en side";
$text['tngprint'] = "Skriv ut";
$text['databasestatistics'] = "Databasestatistikk"; //needed to be shorter to fit on menu
$text['child'] = "Barn";  //from familygroup
$text['repoinfo'] = "Informasjon om arkiv";
$text['tng_reset'] = "Tilbakestill";
$text['noresults'] = "Ingen funnet";
$text['allmedia'] = "Alle media";
$text['repositories'] = "Arkiver";
$text['albums'] = "Album";
$text['cemeteries'] = "Kirkeg�rder";
$text['surnames'] = "Etternavn";
$text['dates'] = "Datoer";
$text['link'] = "Kobling";
$text['media'] = "Media";
$text['gender'] = "Kj�nn";
$text['latitude'] = "Breddegrad";
$text['longitude'] = "Lengdegrad";
$text['bookmarks'] = "Bokmerker";
$text['bookmark'] = "Legg til bokmerke";
$text['mngbookmarks'] = "G� til bokmerke";
$text['bookmarked'] = "Bokmerke lagt til";
$text['remove'] = "Fjern";
$text['find_menu'] = "Finn";
$text['info'] = "Info"; //this needs to be a very short abbreviation
$text['cemetery'] = "Kirkeg�rd";
$text['gmapevent'] = "Hendelseskart";
$text['gevents'] = "Hendelse";
$text['glang'] = "&amp;hl=no";
$text['googleearthlink'] = "Link til Google Earth";
$text['googlemaplink'] = "Link til Google Maps";
$text['gmaplegend'] = "Tegnforklaring";
$text['unmarked'] = "Umerket";
$text['located'] = "Lokalisert";
$text['albclicksee'] = "Klikk for � se alt i dette album";
$text['notyetlocated'] = "Ikke lokalisert";
$text['cremated'] = "Kremert";
$text['missing'] = "Savnet";
$text['pdfgen'] = "PDF Generator";
$text['blank'] = "Blankt skjema";
$text['none'] = "Ingen";
$text['fonts'] = "Skrift";
$text['header'] = "Overskrift";
$text['data'] = "Data";
$text['pgsetup'] = "Sideoppsett";
$text['pgsize'] = "Arkst�rrelse";
$text['orient'] = "Orientering"; //for a page
$text['portrait'] = "Portrett";
$text['landscape'] = "Landskap";
$text['tmargin'] = "Toppmarg";
$text['bmargin'] = "Bunnmarg";
$text['lmargin'] = "Venstre marg";
$text['rmargin'] = "H�yre marg";
$text['createch'] = "Lag dokument";
$text['prefix'] = "Prefiks";
$text['mostwanted'] = "Etterlysninger";
$text['latupdates'] = "Siste oppdatering";
$text['featphoto'] = "Siste bilde";
$text['news'] = "Nyheter";
$text['ourhist'] = "V�r historie";
$text['ourhistanc'] = "V�r historie og aner";
$text['ourpages'] = "V�re slektssider";
$text['pwrdby'] = "Sidene drives av";
$text['writby'] = "skrevet av";
$text['searchtngnet'] = "S�k TNG-nettet (GENDEX)";
$text['viewphotos'] = "Se alle bilder";
$text['anon'] = "Du er fremdeles anonym";
$text['whichbranch'] = "Hvilken gren tilh�rer du?";
$text['featarts'] = "Artiklene";
$text['maintby'] = "Redigert av";
$text['createdon'] = "Skrevet den";
$text['reliability'] = "Troverdighet";
$text['labels'] = "Ledetekster";
$text['inclsrcs'] = "Inkluder kilder";
$text['cont'] = "(forts.)"; //abbreviation for continued
$text['mnuheader'] = "Startside";
$text['mnusearchfornames'] = "S�k";
$text['mnulastname'] = "Etternavn";
$text['mnufirstname'] = "Fornavn";
$text['mnusearch'] = "S�k";
$text['mnureset'] = "Start p� nytt";
$text['mnulogon'] = "Logg inn";
$text['mnulogout'] = "Logg ut";
$text['mnufeatures'] = "Flere muligheter";
$text['mnuregister'] = "Be om brukerkonto";
$text['mnuadvancedsearch'] = "Avansert s�k";
$text['mnulastnames'] = "Etternavn";
$text['mnustatistics'] = "Statistikk";
$text['mnuphotos'] = "Bilder";
$text['mnuhistories'] = "Historier";
$text['mnumyancestors'] = "Bilder &amp; Historier for Aner til [Person]";
$text['mnucemeteries'] = "Kirkeg�rder";
$text['mnutombstones'] = "Gravsteiner";
$text['mnureports'] = "Rapporter";
$text['mnusources'] = "Kilder";
$text['mnuwhatsnew'] = "Hva er nytt?";
$text['mnushowlog'] = "Bes�kslogg";
$text['mnulanguage'] = "Bytt Spr�k";
$text['mnuadmin'] = "Administrasjon";
$text['welcome'] = "Velkommen";
$text['contactus'] = "Ta kontakt";
//changed in 8.0.0
$text['born'] = "F�dt";
$text['searchnames'] = "S�k etter navn";
//added in 8.0.0
$text['editperson'] = "Rediger person";
$text['loadmap'] = "Vis kartet";
$text['birth'] = "F�dsel";
$text['wasborn'] = "ble f�dt";
$text['startnum'] = "F�rste tall";
$text['searching'] = "S�ker";
//moved here in 8.0.0
$text['location'] = "Lokasjon";
$text['association'] = "Assosiasjon";
$text['collapse'] = "Kollaps";
$text['expand'] = "Ekspander";
$text['plot'] = "Felt";
$text['searchfams'] = "S�k familier";
//added in 8.0.2
$text['wasmarried'] = "Giftet seg med";
$text['anddied'] = "og d�de";
//added in 9.0.0
$text['share'] = "Del";
$text['hide'] = "Skjul";
$text['disabled'] = "Din brukerkonto har blitt deaktivert. Vennligst kontakt administrator for mer informasjon.";
$text['contactus_long'] = "Har du sp�rsm�l eller kommentarer til informasjonen p� dette nettstedet, <span class=\"emphasis\"><a href=\"suggest.php\">ta gjerne kontakt</a></span>. Vi ser frem til � h�re fra deg.";
$text['features'] = "Aktuelt";
$text['resources'] = "Ressurser";
$text['latestnews'] = "Siste Nytt";
$text['trees'] = "Tr�r";
$text['wasburied'] = "ble begravet";
//moved here in 9.0.0
$text['emailagain'] = "Gjenta e-postadresse";
$text['enteremail2'] = "Skriv inn din e-postadresse en gang til.";
$text['emailsmatch'] = "E-postadressene var ikke like. Skriv inn samme e-postadresse i begge felt.";
$text['getdirections'] = "Klikk for � f� veibeskrivelse";
$text['calendar'] = "Kalender";
//changed in 9.0.0
$text['directionsto'] = " til ";
$text['slidestart'] = "Lysbildefremvisning";
$text['livingnote'] = "Minst en n�levende eller privat person er linket til dette notatet. Detaljer ikke tilgjengelig.";
$text['livingphoto'] = "Minst en n�levende eller privat person er linket til dette bildet. Detaljer ikke tilgjengelig.";
$text['waschristened'] = "ble d�pt";
//added in 10.0.0
$text['branches'] = "Grener";
$text['detail'] = "Detalj";
$text['moredetail'] = "Flere detaljer";
$text['lessdetail'] = "F�rre detaljer";
$text['otherevents'] = "Andre hendelser";
$text['conflds'] = "Konfirmert (LDS)";
$text['initlds'] = "Initiatory (LDS)";
$text['wascremated'] = "ble kremert";
//moved here in 11.0.0
$text['text_for'] = "for";
//added in 11.0.0
$text['searchsite'] = "S�k dette nettstedet";
$text['searchsitemenu'] = "S�k nettsted";
$text['kmlfile'] = "Last ned en .kml fil for � vise dette stedet i Google Earth";
$text['download'] = "Klikk for � laste ned";
$text['more'] = "Mer";
$text['heatmap'] = "Spredningskart";
$text['refreshmap'] = "Frisk opp kart";
$text['remnums'] = "Fjern antall og kartn�ler";
$text['photoshistories'] = "Bilder &amp; Historier";
$text['familychart'] = "Familiediagram";
//added in 12.0.0
$text['firstnames'] = "Fornavn";
//moved here in 12.0.0
$text['dna_test'] = "DNA test";
$text['test_type'] = "Testtype";
$text['test_info'] = "Testinformasjon";
$text['takenby'] = "Test tatt av";
$text['haplogroup'] = "Haplogruppe";
$text['hvr1'] = "HVR1";
$text['hvr2'] = "HVR2";
$text['relevant_links'] = "Relevante linker";
$text['nofirstname'] = "[mangler fornavn]";
//added in 12.0.1
$text['cookieuse'] = "Merk: Dette nettstedet bruker informasjonskapsler (cookies).";
$text['dataprotect'] = "Retningslinjer for personvern";
$text['viewpolicy'] = "Se retningslinjer";
$text['understand'] = "Jeg forst�r";
$text['consent'] = "Jeg gir mitt samtykke til at dette nettstedet lagrer den personlige informasjonen nevnt under 'Retningslinjer for personvern'. JJeg forst�r at jeg kan be nettstedets eier fjerne denne informasjonen n�r som helst.";
$text['consentreq'] = "Vennligst gi ditt samtykke til at dette nettstedet kan lagre personlig informasjon.";

//added in 12.1.0
$text['testsarelinked'] = "DNA tester er linket til";
$text['testislinked'] = "DNA test er linket til";

//added in 12.2
$text['quicklinks'] = "Hurtigkoblinger";
$text['yourname'] = "Ditt navn";
$text['youremail'] = "Din e-postadresse";
$text['liketoadd'] = "All informasjon du vil legge til";
$text['webmastermsg'] = "Webmaster melding";
$text['gallery'] = "Se galleri";
$text['wasborn_male'] = "ble f�dt";
$text['wasborn_female'] = "ble f�dt";
$text['waschristened_male'] = "ble d�pt";
$text['waschristened_female'] = "ble d�pt";
$text['died_male'] = "d�de";
$text['died_female'] = "d�de";
$text['wasburied_male'] = "ble begravet";
$text['wasburied_female'] = "ble begravet";
$text['wascremated_male'] = "ble kremert";
$text['wascremated_female'] = "ble kremert";
$text['wasmarried_male'] = "giftet seg med";
$text['wasmarried_female'] = "giftet seg med";
$text['wasdivorced_male'] = "ble skilt";
$text['wasdivorced_female'] = "ble skilt";
$text['inplace'] = ", ";
$text['onthisdate'] = " ";
$text['inthisyear'] = " ";
$text['and'] = "og ";

//moved here in 12.3
$text['dna_info_head'] = "DNA Test Info";
$text['firstpage'] = "F�rste side";
$text['lastpage'] = "Siste side";

@include_once "captcha_text.php";
@include_once "alltext.php";
if (!$alltextloaded) {
  getAllTextPath();
}

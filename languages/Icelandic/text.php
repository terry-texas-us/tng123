<?php
switch ($textpart) {
  //browsesources.php, showsource.php
  case "sources":
    $text['browseallsources'] = "Sko�a allar heimildir";
    $text['shorttitle'] = "Stuttur titill";
    $text['callnum'] = "S�man�mer";
    $text['author'] = "H�fundur";
    $text['publisher'] = "�tgefandi";
    $text['other'] = "A�rar uppl�singar";
    $text['sourceid'] = "Nr. heimildar";
    $text['moresrc'] = "Fleiri Heimildir";
    $text['repoid'] = "Nr. heimildasafns";
    $text['browseallrepos'] = "Sko�a �ll heimildas�fn";
    break;

  //changelanguage.php, savelanguage.php
  case "language":
    $text['newlanguage'] = "N�tt tungum�l";
    $text['changelanguage'] = "Breyta tungum�li";
    $text['languagesaved'] = "Tungum�l geymt";
    $text['sitemaint'] = "vi�hald � gangi � vefs��unni";
    $text['standby'] = "S��an er ekki a�gengileg � augnablikinu vegna vi�halds � gagnagrunni. Vinsamlegast reyni� aftur eftir nokkrar m�n�tur. Ef s��an er ni�ri � lengri t�ma, vinsamlegast <a href=\"suggest.php\"> hafi� samband vi� vefstj�ra</a>.";
    break;

  //gedcom.php, gedform.php
  case "gedcom":
    $text['gedstart'] = "GEDCOM byrjar fr�";
    $text['producegedfrom'] = "�tb�a GEDCOM skr� fr�";
    $text['numgens'] = "fj�ldi kynsl��a";
    $text['includelds'] = "hafa LDS uppl�singar me�";
    $text['buildged'] = "Byggja GEDCOM";
    $text['gedstartfrom'] = "GEDCOM byrjar fr�";
    $text['nomaxgen'] = "�� ver�ur a� skilgreina fj�lda kynsl��a. Vinsamlegast noti� back takkan til a� fara til baka";
    $text['gedcreatedfrom'] = "GEDCOM skapa� af";
    $text['gedcreatedfor'] = "Skapa� fyrir";
    $text['creategedfor'] = "�tb�a GEDCOM fyrir";
    $text['email'] = "Netfang";
    $text['suggestchange'] = "Stinga upp� breytingu";
    $text['yourname'] = "Nafn �itt";
    $text['comments'] = "Skilabo� e�a athugasemdir";
    $text['comments2'] = "Athugasemdir";
    $text['submitsugg'] = "Senda inn upp�stungu";
    $text['proposed'] = "Breyting";
    $text['mailsent'] = "Takk fyrir. Skilabo� ��n hafa veri� send.";
    $text['mailnotsent'] = "�v� mi�ur komust skilabo�in ekki til. Vinsamlegast haf�u samband vi� xxx beint yyy.";
    $text['mailme'] = "Senda afrit � �etta netfang";
    $text['entername'] = "Vinsamlegast sl��u inn nafni� �itt";
    $text['entercomments'] = "Vinsamlegast sl��u inn athugasemdir";
    $text['sendmsg'] = "Senda skilabo�";
    //added in 9.0.0
    $text['subject'] = "Efni";
    break;

  //getextras.php, getperson.php
  case "getperson":
    $text['photoshistoriesfor'] = "Lj�smyndir og saga fyrir";
    $text['indinfofor'] = "Einstaklings uppl�singar fyrir";
    $text['pp'] = "bls."; //page abbreviation
    $text['age'] = "Aldur";
    $text['agency'] = "Samt�k";
    $text['cause'] = "�st��a";
    $text['suggested'] = "Upp�stunga";
    $text['closewindow'] = "Loka �essum glugga";
    $text['thanks'] = "Takk fyrir";
    $text['received'] = "Upp�stungu hefur veri� komi� �lei�is til vefstj�ra til sko�unar.";
    $text['indreport'] = "Einst�k sk�rsla";
    $text['indreportfor'] = "Individual Report for";
    $text['general'] = "Almennt";
    $text['bkmkvis'] = "<strong>Ath:</strong> �essi b�kamerki eru einungis s�nileg � �essari t�lvu og � �essum vafra.";
    //added in 9.0.0
    $text['reviewmsg'] = "�� �arft a� sko�a athugasemd um breytingu sem ��r hefur veri� send.  �essi athugasemd var�ar:";
    $text['revsubject'] = "Eftirfarandi athugasemd b��ur sko�unar";
    break;

  //relateform.php, relationship.php, findpersonform.php, findperson.php
  case "relate":
    $text['relcalc'] = "Skyldleika reiknir";
    $text['findrel'] = "Rekja saman";
    $text['person1'] = "Einstaklingur 1:";
    $text['person2'] = "Einstaklingur 2:";
    $text['calculate'] = "Reikna";
    $text['select2inds'] = "Veldu 2 einstaklinga.";
    $text['findpersonid'] = "Finna einstaklings n�mer";
    $text['enternamepart'] = "Sl��ur inn hluta fyrra nafns/e�a seinna nafns";
    $text['pleasenamepart'] = "Vinsamlegast sl��u inn hluta nafns.";
    $text['clicktoselect'] = "Smelltu h�r til a� velja";
    $text['nobirthinfo'] = "Engar upll�singar um f��ingardag";
    $text['relateto'] = "Skyldleiki til";
    $text['sameperson'] = "�etta er sama manneskjan.";
    $text['notrelated'] = "�essir 2 einstaklingar eru ekki skyldir innan xxx kynsl��a."; //xxx will be replaced with number of generations
    $text['findrelinstr'] = "Sl��u inn nr. einstaklings, e�a nota�u Finna takkann, smelltu svo � Reikna til a� finna skyldleika �essara tveggja einstaklinga (allt a� xxx kynsl��ir).";
    $text['sometimes'] = "(Stundum �egar athuga� er yfir mismunandi fj�lda kynsl��a kemur �nnur ni�ursta�a.)";
    $text['findanother'] = "Finna annan skyldleika";
    $text['brother'] = "Br��ir";
    $text['sister'] = "Systir";
    $text['sibling'] = "Systkyni";
    $text['uncle'] = "xxx fr�ndi";
    $text['aunt'] = "xxx fr�nka";
    $text['uncleaunt'] = "xxx fr�ndur/fr�nkur";
    $text['nephew'] = "xxx fr�ndi";
    $text['niece'] = "xxx fr�nka";
    $text['nephnc'] = "xxx fr�ndur/fr�nkur";
    $text['removed'] = "oft fjarl��ur";
    $text['rhusband'] = "eiginma�ur ";
    $text['rwife'] = "eiginkona ";
    $text['rspouse'] = "maki ";
    $text['son'] = "sonur";
    $text['daughter'] = "d�ttir";
    $text['rchild'] = "barn";
    $text['sil'] = "Tengdasonur";
    $text['dil'] = "Tengdad�ttir";
    $text['sdil'] = "Tengdasonur e�a d�ttir";
    $text['gson'] = "Barnabarn";
    $text['gdau'] = "xxx barnabarn";
    $text['gsondau'] = "xxx barnabarn";
    $text['great'] = "langa";
    $text['spouses'] = "eru makar";
    $text['is'] = "er";
    $text['changeto'] = "Breyta �:";
    $text['notvalid'] = "er ekki gilt sem nr. einstaklings e�a er ekki til i gagnagrunninum.  Vinsamlegast reyni� aftur.";
    $text['halfbrother'] = "h�lfbr��ir";
    $text['halfsister'] = "h�lfsystir";
    $text['halfsibling'] = "h�lf systkyni";
    //changed in 8.0.0
    $text['gencheck'] = "H�marks fj�ldi kynsl��a<br />sem skal athugast";
    $text['mcousin'] = "xxx fr�ndi yyy";  //male cousin; xxx = cousin number, yyy = times removed
    $text['fcousin'] = "xxx fr�ndi yyy";  //female cousin
    $text['cousin'] = "xxx fr�ndi yyy";
    $text['mhalfcousin'] = "the xxx half cousin yyy of";  //male cousin
    $text['fhalfcousin'] = "the xxx half cousin yyy of";  //female cousin
    $text['halfcousin'] = "the xxx half cousin yyy of";
    //added in 8.0.0
    $text['oneremoved'] = "one removed";
    $text['gfath'] = "xxx langafi af";
    $text['gmoth'] = "xxx langamma af";
    $text['gpar'] = "xxx afit of";
    $text['mothof'] = "mamma af";
    $text['fathof'] = "fa�ir af";
    $text['parof'] = "foreldri of";
    $text['maxrels'] = "S�nilegur h�marks skyldleiki";
    $text['dospouses'] = "S�na skyldleika � gegnum maka";
    $text['rels'] = "Skyldleikar";
    $text['dospouses2'] = "S�na maka";
    $text['fil'] = "tengdafa�ir";
    $text['mil'] = "tengdam��ir";
    $text['fmil'] = "tengdaforeldrar";
    $text['stepson'] = "stj�psonur";
    $text['stepdau'] = "stj�pd�ttir";
    $text['stepchild'] = "stj�pbarn";
    $text['stepgson'] = "stj�p-sonarsonur hans";
    $text['stepgdau'] = "stj�p-d�ttursonur";
    $text['stepgchild'] = "stj�p barnabarn";
    //added in 8.1.1
    $text['ggreat'] = "langa";
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
    $text['familygroupfor'] = "Fj�lskyldu bla� fyrir";
    $text['ldsords'] = "LDS Ordinances";
    $text['baptizedlds'] = "Sk�r�ur (LDS)";
    $text['endowedlds'] = "Fermdur (LDS)";
    $text['sealedplds'] = "Sealed P (LDS)";
    $text['sealedslds'] = "Sealed S (LDS)";
    $text['otherspouse'] = "Annar/ur maki";
    $text['husband'] = "Eiginma�ur";
    $text['wife'] = "Eiginkona";
    break;

  //pedigree.php
  case "pedigree":
    $text['capbirthabbr'] = "F";
    $text['capaltbirthabbr'] = "A";
    $text['capdeathabbr'] = "D";
    $text['capburialabbr'] = "G";
    $text['capplaceabbr'] = "S";
    $text['capmarrabbr'] = "G";
    $text['capspouseabbr'] = "SP";
    $text['redraw'] = "Endura�a me�";
    $text['scrollnote'] = "Ath: �� �arft kannski a� skruna ni�ur e�a til h�gri til a� sj�.";
    $text['unknownlit'] = "�skr��";
    $text['popupnote1'] = " = Frekari uppl�singar";
    $text['popupnote2'] = " = N�tt ni�jatal";
    $text['pedcompact'] = "�jappa�";
    $text['pedstandard'] = "Sta�la�";
    $text['pedtextonly'] = "Einungis texti";
    $text['descendfor'] = "Afkomendur";
    $text['maxof'] = "H�mark af";
    $text['gensatonce'] = "kynsl��ir birtar � einu.";
    $text['sonof'] = "foreldrar:";
    $text['daughterof'] = "foreldrar:";
    $text['childof'] = "barn";
    $text['stdformat'] = "Sta�la� sni�";
    $text['ahnentafel'] = "Fram�tt";
    $text['addnewfam'] = "B�ta vi� fj�lskyldu";
    $text['editfam'] = "Breyta fj�lskyldu";
    $text['side'] = "Hli�";
    $text['familyof'] = "Fj�lskylda";
    $text['paternal'] = "Paternal";
    $text['maternal'] = "Maternal";
    $text['gen1'] = "Sj�lf/ur";
    $text['gen2'] = "Foreldrar";
    $text['gen3'] = "�mmur og afar";
    $text['gen4'] = "Lang�mmur og afar";
    $text['gen5'] = "� annan �ttli�";
    $text['gen6'] = "� �ri�ja �ttli�";
    $text['gen7'] = "� fj�r�a �ttli�";
    $text['gen8'] = "� fimmta �ttli�";
    $text['gen9'] = "� sj�tta �ttli�";
    $text['gen10'] = "� Sj�unda �ttli�";
    $text['gen11'] = "� �ttunda �ttli�";
    $text['gen12'] = "� n�unda �ttli�";
    $text['graphdesc'] = "Graf�skt ni�jatal a� �essum punkti";
    $text['pedbox'] = "Kassar";
    $text['regformat'] = "Ni�jatal";
    $text['extrasexpl'] = "Ef a� lj�smyndir e�a s�gur eru til um vi�komandi einstakling, koma vi�eigandi myndir n�st vi� n�fnin.";
    $text['popupnote3'] = " = N�tt ";
    $text['mediaavail'] = "Margmi�lun tilt�k";
    $text['pedigreefor'] = "Ni�jatal fyrir";
    $text['pedigreech'] = "�ttarb�karmynd";
    $text['datesloc'] = "Dagsetningar og sta�setningar";
    $text['borchr'] = "F�ddur/E�a - d�in/jar�a�ur (tveir)";
    $text['nobd'] = "Engin f��ingar- e�a d�nardagur";
    $text['bcdb'] = "F�ddur/Alt/d�nar/jar�a�ur (four)";
    $text['numsys'] = "N�mera kerfi";
    $text['gennums'] = "Kynsl��ar n�mer";
    $text['henrynums'] = "Henry n�mer";
    $text['abovnums'] = "d'Aboville n�mer";
    $text['devnums'] = "de Villiers Nn�mer";
    $text['dispopts'] = "Valkostir";
    //added in 10.0.0
    $text['no_ancestors'] = "Engir forfe�ur fundust";
    $text['ancestor_chart'] = "L��r�tt �ttartr� (�ar)";
    $text['opennewwindow'] = "Opna � n�jum glugga";
    $text['pedvertical'] = "L��r�tt";
    //added in 11.0.0
    $text['familywith'] = "Family with";
    $text['fcmlogin'] = "Vinsamlegast skr��u �ig inn til a� sko�a n�nar";
    $text['isthe'] = "er";
    $text['otherspouses'] = "a�rir makar";
    $text['parentfamily'] = "The parent family ";
    $text['showfamily'] = "S�na fj�lskyldu";
    $text['shown'] = "shown";
    $text['showparentfamily'] = "show parent family";
    $text['showperson'] = "s�na einstakling";
    //added in 11.0.2
    $text['otherfamilies'] = "Other families";
    break;

  //search.php, searchform.php
  //merged with reports and showreport in 5.0.0
  case "search":
  case "reports":
    $text['noreports'] = "Engar sk�rslur til.";
    $text['reportname'] = "Nafn sk�rslu";
    $text['allreports'] = "Allar sk�rslur";
    $text['report'] = "Sk�rslur";
    $text['error'] = "Villa";
    $text['reportsyntax'] = "Eitthva� vi� �essa fyrirspurn";
    $text['wasincorrect'] = "var rangt, og g�tum vi� ekki s�� sk�rsluna. vinsemlagast hafi� samband vi� vefstj�ra �";
    $text['errormessage'] = "Villu bo�";
    $text['equals'] = "er";
    $text['endswith'] = "endar �";
    $text['soundexof'] = "soundex of";
    $text['metaphoneof'] = "metaphone of";
    $text['plusminus10'] = "+/- 10 �rum fr�";
    $text['lessthan'] = "minna en";
    $text['greaterthan'] = "meira en";
    $text['lessthanequal'] = "minna en e�a jafnt og";
    $text['greaterthanequal'] = "meira en e�a jafnt og";
    $text['equalto'] = "Jafnt og";
    $text['tryagain'] = "Vinsamlegast reyndu aftur";
    $text['joinwith'] = "Sameina me�";
    $text['cap_and'] = "og";
    $text['cap_or'] = "e�a";
    $text['showspouse'] = "S�na maka (s�nir alla ef um fleiri en einn er a� r��a)";
    $text['submitquery'] = "S�kja sk�rslu";
    $text['birthplace'] = "F��ingarsta�ur";
    $text['deathplace'] = "D�narsta�ur";
    $text['birthdatetr'] = "F��ingar�r";
    $text['deathdatetr'] = "D�nar�r";
    $text['plusminus2'] = "+/- 2 �rum fr�";
    $text['resetall'] = "Hreinsa �ll gildi";
    $text['showdeath'] = "S�na uppl�singar um andl�t/jar�setningu";
    $text['altbirthplace'] = "Sk�rnarsta�ur";
    $text['altbirthdatetr'] = "Sk�rnar�r";
    $text['burialplace'] = "Nafn kirkjugar�s";
    $text['burialdatetr'] = "Jar�setningar�r";
    $text['event'] = "Atbur�ir";
    $text['day'] = "Dagur";
    $text['month'] = "M�nu�ur";
    $text['keyword'] = "Lykilor� (t.d, \"Abt\")";
    $text['explain'] = "Sl��u inn dagsetningu til a� sj� atbur�i �ann dag e�a skyldu reitina eftir au�a til a� sj� alla atbur�i.";
    $text['enterdate'] = "Vinsamlegast sl��u inn e�a veldu a� minnsta kosti eitt af eftirfarandi: Dagur, M�nu�ur, �r, Lykil or�";
    $text['fullname'] = "Fullt nafn";
    $text['birthdate'] = "F��ingardagur";
    $text['altbirthdate'] = "Sk�rnardagur";
    $text['marrdate'] = "Giftingardagur";
    $text['spouseid'] = "Nr. maka";
    $text['spousename'] = "Nafn Maka";
    $text['deathdate'] = "D�nardagur";
    $text['burialdate'] = "Jar�setningardagur";
    $text['changedate'] = "Dagsetning s��ustu breytingar";
    $text['gedcom'] = "Tr�";
    $text['baptdate'] = "Ferming (LDS)";
    $text['baptplace'] = "Fermingar sta�ur (LDS)";
    $text['endldate'] = "Endowment Date (LDS)";
    $text['endlplace'] = "Endowment Place (LDS)";
    $text['ssealdate'] = "Seal Date S (LDS)";   //Sealed to spouse
    $text['ssealplace'] = "Seal Place S (LDS)";
    $text['psealdate'] = "Seal Date P (LDS)";   //Sealed to parents
    $text['psealplace'] = "Seal Place P (LDS)";
    $text['marrplace'] = "Hj�nav�gslusta�ur";
    $text['spousesurname'] = "Eftirnafn maka";
    $text['spousemore'] = "Ef �� sl�r� in eftirnafn maka ver�ur �� a� minnsta kosti a� sl� inn � einn annan reit hj� honum.";
    $text['plusminus5'] = "+/- 5 �rum fr�";
    $text['exists'] = "er �egar til";
    $text['dnexist'] = "er ekki til";
    $text['divdate'] = "Dagsetning skilna�ar";
    $text['divplace'] = "Skilna�ar sta�ur";
    $text['otherevents'] = "A�rir atbur�ir";
    $text['numresults'] = "Ni�urst��ur � hverri s��u";
    $text['mysphoto'] = "Myndir sem vantar frekari uppl�singar um";
    $text['mysperson'] = "Einstaklingar sem vantar frekari uppl�singar um";
    $text['joinor'] = "'Skr��u �ig me� valkostur e�a 'ekki er h�gt a� nota me� Eftirnafn maka";
    $text['tellus'] = "Seg�u okkur �a� sem �� veist";
    $text['moreinfo'] = "frekari uppl�singar:";
    //added in 8.0.0
    $text['marrdatetr'] = "Giftingar�r";
    $text['divdatetr'] = "Skilna�ar�r";
    $text['mothername'] = "Nafn m��ur";
    $text['fathername'] = "Nafn f��urs";
    $text['filter'] = "S�a";
    $text['notliving'] = "Ekki � l�fi";
    $text['nodayevents'] = "Atbur�ir �essa m�na�ar, sem ekki eru tengdir vi� tiltekinn dag:";
    //added in 9.0.0
    $text['csv'] = "Comma-delimited CSV file";
    //added in 10.0.0
    $text['confdate'] = "Fermingardagur (LDS)";
    $text['confplace'] = "Fermingarsta�ur (LDS)";
    $text['initdate'] = "Initiatory Date (LDS)";
    $text['initplace'] = "Initiatory Place (LDS)";
    //added in 11.0.0
    $text['marrtype'] = "Tegund hj�nabands";
    $text['searchfor'] = "Leita a�";
    $text['searchnote'] = "Ath: �essi s��a notar Google leitarv�lina til a� leita � �llum g�gnum sem eru skr�� � �essari s��u.  Fj�ldi ni�ursta�a sem fram koma vi� leit, er h��ur �v� hversu vel Google hefur skr�� s��una.";
    break;

  //showlog.php
  case "showlog":
    $text['logfilefor'] = "loggar fyrir";
    $text['mostrecentactions'] = "S��ustu a�ger�ir";
    $text['autorefresh'] = "Sj�lfvirk endurn�jun (� 30 sek�ndu fresti)";
    $text['refreshoff'] = "S�kkva � sj�lfvirk endurn�jun";
    break;

  case "headstones":
  case "showphoto":
    $text['cemeteriesheadstones'] = "Kirkjugar�ar og legsteinar";
    $text['showallhsr'] = "S�na yfirlit yfir alla";
    $text['in'] = "inn";
    $text['showmap'] = "S�na kort";
    $text['headstonefor'] = "legsteinn fyrir";
    $text['photoof'] = "Lj�smynd af";
    $text['photoowner'] = "Eigandi/heimild";
    $text['nocemetery'] = "engin grafreitur";
    $text['iptc005'] = "Titill";
    $text['iptc020'] = "stu�n. Flokkar";
    $text['iptc040'] = "S�rstakar lei�beningar";
    $text['iptc055'] = "Skapa� dags";
    $text['iptc080'] = "H�fundur";
    $text['iptc085'] = "Sta�setning h�fundar";
    $text['iptc090'] = "Borg";
    $text['iptc095'] = "R�ki";
    $text['iptc101'] = "Land";
    $text['iptc103'] = "OTR";
    $text['iptc105'] = "Fyrirs�gn";
    $text['iptc110'] = "spretta";
    $text['iptc115'] = "Lj�smyndaspretta";
    $text['iptc116'] = "H�fundarr�ttur";
    $text['iptc120'] = "Mynd af";
    $text['iptc122'] = "mynda ger� af";
    $text['mapof'] = "kort af";
    $text['regphotos'] = "N�kv�mari uppl�singar";
    $text['gallery'] = "Sj� bara sm�myndir";
    $text['cemphotos'] = "Myndir af kirkjug�r�um";
    $text['photosize'] = "St�r�";
    $text['iptc010'] = "Priority";
    $text['filesize'] = "Skr�arst�r�";
    $text['seeloc'] = "sj� sta�setningu";
    $text['showall'] = "S�na allr";
    $text['editmedia'] = "Breyta margmi�lun";
    $text['viewitem'] = "Sko�a �ennan hlut";
    $text['editcem'] = "Breyta grafreit";
    $text['numitems'] = "# Hlutir";
    $text['allalbums'] = "�ll myndaalb�m";
    $text['slidestop'] = "Stoppa myndas�ningu";
    $text['slideresume'] = "Setja myndas�ningu af sta�";
    $text['slidesecs'] = "Fj�ldi sek�ndna fyrir hverja mynd:";
    $text['minussecs'] = "M�nus 0.5 sek�ndur";
    $text['plussecs'] = "Pl�s 0.5 sek�ndur";
    $text['nocountry'] = "��ekkt land";
    $text['nostate'] = "��ekkt fylki";
    $text['nocounty'] = "��ekkt s�sla";
    $text['nocity'] = "��ekkt borg";
    $text['nocemname'] = "��ekktur kirkjugar�ur";
    $text['editalbum'] = "Breyta myndaalb�mi";
    $text['mediamaptext'] = "<strong>Ath:</strong> F�r�u m�sarbendillinn �inn yfir mynd til a� birta n�fn. Smelltu til a� sj� s��u fyrir hvert nafn.";
    //added in 8.0.0
    $text['allburials'] = "Allir kirkjugar�ar";
    $text['moreinfo'] = "meiri uppl�singar:";
    //added in 9.0.0
    $text['iptc025'] = "Lykilor�";
    $text['iptc092'] = "Sub-location";
    $text['iptc015'] = "Flokkur";
    $text['iptc065'] = "Originating Program";
    $text['iptc070'] = "�tg�fa forrits";
    break;

  //surnames.php, surnames100.php, surnames-all.php, surnames-oneletter.php
  case "surnames":
  case "places":
    $text['surnamesstarting'] = "S�na eftirn�fn sem byrja �";
    $text['showtop'] = "S�na fyrstu";
    $text['showallsurnames'] = "S�na �ll eftirn�fn";
    $text['sortedalpha'] = "� stafr�fsr��";
    $text['byoccurrence'] = "eftir fj�lda";
    $text['firstchars'] = "Fyrstu stafina";
    $text['mainsurnamepage'] = "A�al eftirnafna s��an";
    $text['allsurnames'] = "�ll eftirn�fn";
    $text['showmatchingsurnames'] = "Smelltu � eftirnafn til a� sj� fleiri.";
    $text['backtotop'] = "Aftur efst";
    $text['beginswith'] = "Byrjar �";
    $text['allbeginningwith'] = "�ll sem byrja �";
    $text['numoccurrences'] = "fj�ldi � foreldrart�lu";
    $text['placesstarting'] = "S�na sta�i sem byrja �";
    $text['showmatchingplaces'] = "smelltu � nafn til a� sko�a.";
    $text['totalnames'] = "heildarfj�ldi nafna";
    $text['showallplaces'] = "S�na alla sta�i";
    $text['totalplaces'] = "heildarfj�ldi sta�a";
    $text['mainplacepage'] = "A�al sta�ir s��a";
    $text['allplaces'] = "�ll st�rstu umhverfin";
    $text['placescont'] = "S�na alla sta�i sem innihalda";
    //changed in 8.0.0
    $text['top30'] = "xxx algengustu eftirn�fnin";
    $text['top30places'] = "xxx algengustu sta�irnir";
    //added in 12.0.0
    $text['firstnamelist'] = "Yfirlit yfir forn�fn";
    $text['firstnamesstarting'] = "S�na forn�fn sem byrja �";
    $text['showallfirstnames'] = "S�na �ll forn�fn";
    $text['mainfirstnamepage'] = "Yfirlit yfir �ll skr�� forn�fn";
    $text['allfirstnames'] = "�ll forn�fn";
    $text['showmatchingfirstnames'] = "Smelltu � nafn til a� sj� ni�urst��urnar.";
    $text['allfirstbegwith'] = "�ll forn�fn sem byrja �";
    $text['top30first'] = "Fyrstu xxx forn�fnin";
    $text['allothers'] = "�ll �nnur";
    $text['amongall'] = "(af �llum n�fnum)";
    $text['justtop'] = "A�eins fyrstu xxx";
    break;

  //whatsnew.php
  case "whatsnew":
    $text['pastxdays'] = "(S��ustu xx daga)";

    $text['photo'] = "Lj�smynd";
    $text['history'] = "Saga/Skal";
    $text['husbid'] = "Nr. eiginmanns";
    $text['husbname'] = "Nafn eiginmanns";
    $text['wifeid'] = "Nr. eiginkonu";
    //added in 11.0.0
    $text['wifename'] = "Mother's Name";
    break;

  //timeline.php, timeline2.php
  case "timeline":
    $text['text_delete'] = "Ey�a";
    $text['addperson'] = "B�ta einstakling vi�";
    $text['nobirth'] = "�essi einstaklingur er ekki me� gildan f��ingardag og var �v� ekki h�gt a� b�ta honum vi�";
    $text['event'] = "Vi�bur�ir";
    $text['chartwidth'] = "Breidd";
    $text['timelineinstr'] = "b�ttu allt a� fj�rum fleirri einstaklingum me� �v� a� sl� inn einstaklingsn�meri� �eirra h�r fyrir ne�an:";
    $text['togglelines'] = "Kveikja � l�num";
    //changed in 9.0.0
    $text['noliving'] = "�essi einstaklingur er merktur � l�fi og var �v� ekki h�gt a� b�ta honum vi� �v� �� ert ekki m� r�ttindi til �ess";
    break;

  //browsetrees.php
  //login.php, newacctform.php, addnewacct.php
  case "trees":
  case "login":
    $text['browsealltrees'] = "Sko�a �ll tr�";
    $text['treename'] = "Nafn tr�s";
    $text['owner'] = "Eigandi";
    $text['address'] = "Heimilisfang";
    $text['city'] = "Borg";
    $text['state'] = "S�sla";
    $text['zip'] = "P�stn�mer";
    $text['country'] = "Land";
    $text['email'] = "Netfang";
    $text['phone'] = "S�mi";
    $text['username'] = "Notendanafn";
    $text['password'] = "Lykilor�";
    $text['loginfailed'] = "Innskr�ning mist�kst.";

    $text['regnewacct'] = "Notendaskr�ning";
    $text['realname'] = "Nafn";
    $text['phone'] = "S�mi";
    $text['email'] = "Netfang";
    $text['address'] = "Heimilisfang";
    $text['acctcomments'] = "Skilabo� e�a athugasemdir";
    $text['submit'] = "Senda";
    $text['leaveblank'] = "(haf�u autt ef �ska� er eftir n�ju tr�i)";
    $text['required'] = "Ver�ur a� fylla �t";
    $text['enterpassword'] = "Sl��u inn lykilor�.";
    $text['enterusername'] = "Sl��u inn notendanafn.";
    $text['failure'] = "Notendanafni� sem �� valdir er uppteki�.  Far�u til baka til a� velja ��r n�tt notendanafn.";
    $text['success'] = "Takk fyrir. Skr�ningin ��n hefur veri� m�ttekin. �� ver�ur l�tin vita �egar a�gangur �inn er or�in virkur e�a meiri uppl�singar vantar.";
    $text['emailsubject'] = "�ska� hefur veri� eftir a�gang a� �ttfr��is��unni";
    $text['website'] = "Heimas��a";
    $text['nologin'] = "Vantar �ig notendanafn?";
    $text['loginsent'] = "Uppl�singar sendar";
    $text['loginnotsent'] = "A�gangs uppl�singar ekki sendar";
    $text['enterrealname'] = "Sl��u inn nafni� �itt.";
    $text['rempass'] = "Vera alltaf skr��ur � �essari t�lvu";
    $text['morestats'] = "Meiri t�lfr��i";
    $text['accmail'] = "<strong>ATH:</strong> Gangtu �r skugga um a� ekki �etta l�n s� ekki � lista yfir l�n sem loka� er � p�st fr�.";
    $text['newpassword'] = "N�tt lykilor�";
    $text['resetpass'] = "Breyta lykilor�i";
    $text['nousers'] = "�etta form er ekki h�gt a� nota fyrr en einn notandi er til. Ef �� ert eigandi �essara s��u, far�u � admin/notendur til a� b�a til kerfistj�ra a�gang.";
    $text['noregs'] = "�v� mi�ur, er ekki teki� � m�ti skr�ningum n�na. Vinsamlegast haf�u <a href=\"suggest.php\">samband </a> beint ef �� hefur athugasemdir e�a spurning er var�ar eitthva� � �essari s��u.";
    //changed in 8.0.0
    $text['emailmsg'] = "�a� hefur borist ��r p�stur um a�gang a� ny�jatals s��unni. vinsamlegast skr��u �ig inn � kerfis hluta s��unar og gef�u notenda r�ttindi til a� taka ��tt � a� vi�halda s��unni. Ef �� notandi er � lagi vinsamlegast l�ttu hann vita me� �v� a� svara p�stinum hanns.";
    $text['accactive'] = "A�gangurinn hefur veri� virkja�ur en notandinn hefur engin s�rst�k r�ttindi fyrr en �� gefur honum �au.";
    $text['accinactive'] = "Far�u � Admin / Notandi / yfirlit til a� f� a�gang a� a�gangs stillingum. A�gangurinn ver�ur �fram �virkur �ar til �� breytir og vistar skr�na a� minnsta kosti einu sinni..";
    $text['pwdagain'] = "Lykilor� aftur";
    $text['enterpassword2'] = "Vinsamlegast skr��u inn lykilor�i� �itt aftur.";
    $text['pwdsmatch'] = "lykilor� ��n passa ekki saman. Vinsamlegast sl��u inn sama a�gangsor�i� � hvern reit.";
    //added in 8.0.0
    $text['acksubject'] = "�akka ��r fyrir a� skr� �ig"; //for a new user account
    $text['ackmessage'] = "Bei�ni ��n um notanda hefur veri� m�ttekin. A�gangurinn �inn mun vera �virkur �ar til hann hefur veri� sko�a�ur af  stj�rnanda. ��r ver�ur tilkynnt me� t�lvup�sti �egar tenging ��n er tilb�in til notkunar.";
    //added in 12.0.0
    $text['switch'] = "Switch";
    break;

  //added in 10.0.0
  case "branches":
    $text['browseallbranches'] = "Sko�a allar greinar";
    break;

  //statistics.php
  case "stats":
    $text['quantity'] = "Fj�ldi";
    $text['totindividuals'] = "Fj�ldi einstaklinga";
    $text['totmales'] = "Fj�ldi manna";
    $text['totfemales'] = "Fj�ldi kvenna";
    $text['totunknown'] = "Fj�ldi einstaklinga �ar sem kyn er ekki �ekkt";
    $text['totliving'] = "Fj�ldi lifandi einstaklinga";
    $text['totfamilies'] = "Fj�ldi fj�lskyldna";
    $text['totuniquesn'] = "Fj�ldi eftirnafn";
    //$text['totphotos'] = "Total Photos";
    //$text['totdocs'] = "Total Histories &amp; Documents";
    //$text['totheadstones'] = "Total Headstones";
    $text['totsources'] = "Fj�ldi heimilda";
    $text['avglifespan'] = "Me�al �vilengd";
    $text['earliestbirth'] = "Fyrsta f��ing";
    $text['longestlived'] = "H�sti aldur";
    $text['days'] = "dagar";
    $text['age'] = "Aldur";
    $text['agedisclaimer'] = "Aldurs-tengdir �treikningar eru bygg�ir � einstaklingum me� skr��ar dagsetningar vegna fj�lda �skr��ra dagsetninga er �etta ekki alveg 100 pr�sent n�kv�mt.";
    $text['treedetail'] = "Meiri uppl�singar um �etta tr�";
    $text['total'] = "Samtals";
    //added in 12.0
    $text['totdeceased'] = "Total Deceased";
    break;

  case "notes":
    $text['browseallnotes'] = "Fl�tta � �llum athugasemdum";
    break;

  case "help":
    $text['menuhelp'] = "Valmynd";
    break;

  case "install":
    $text['perms'] = "a�gangsheimildir hafa veri� settar.";
    $text['noperms'] = "a�gangsheimildir var ekki h�gt a� setja � �essar skr�r:";
    $text['manual'] = "Vinsamlegast settu �� inn handvirkt.";
    $text['folder'] = "Mappa";
    $text['created'] = "hefur veri� �tb�inn";
    $text['nocreate'] = "gat ekki veri� �tb�inn. Vinsamlegast ger�u �a� handvirkt.";
    $text['infosaved'] = "Uppl�singar vista�ar, tenging sta�fest!";
    $text['tablescr'] = "T�flur hafa veri� b�nar til!";
    $text['notables'] = "Eftirfarandi t�flur g�tu ekki veri� �tb�nar:";
    $text['nocomm'] = "TNG n�r ekki sambandi vi� gagnagrunn. Engar t�flur voru �tb�nar.";
    $text['newdb'] = "Uppl�singar vistu�, tengingu sta�fest, n�r gagnagrunnur til:";
    $text['noattach'] = "Uppl�singar vista�ar. Tengsl myndu� og gagnasafn skapa�, en TNG getur ekki tengst.";
    $text['nodb'] = "Uppl�singar vista�ar. Tengsl ger�, en gagnagrunnur er ekki til og ekki h�gt a� skapa h�r. Vinsamlegast sta�festu a� gagnagrunns nafn s� r�tt, e�a nota stj�rnbor�i� til a� stofna hann..";
    $text['noconn'] = "Uppl�singar vistu� en tengingin t�kst ekki. Einn e�a fleiri af eftirfarandi er rangt:";
    $text['exists'] = "�egar til";
    $text['loginfirst'] = "�� ver�ur a� skr�  �ig inn fyrst.";
    $text['noop'] = "Ekkert var gert.";
    //added in 8.0.0
    $text['nouser'] = "Notandi var ekki b�inn til. notendanafn er l�klega til.";
    $text['notree'] = "Tr� var ekki b�i� til. tr� er l�klega til.";
    $text['infosaved2'] = "Uppl�singar vista�ar";
    $text['renamedto'] = "endursk�rt �";
    $text['norename'] = "gat ekki veri� endursk�rt";
    break;

  case "imgviewer":
    $text['zoomin'] = "�ysja Inn";
    $text['zoomout'] = "�ysja �r";
    $text['magmode'] = "St�kka";
    $text['panmode'] = "Pan Mode";
    $text['pan'] = "Smelltu til a� flytja innan myndar";
    $text['fitwidth'] = "passa breidd";
    $text['fitheight'] = "passa h��";
    $text['newwin'] = "n�jan glugga";
    $text['opennw'] = "n�ja mynd � n�jum glugga";
    $text['magnifyreg'] = "Smelltu tul a� st�kka hluta af myndinni";
    $text['imgctrls'] = "Virkja myndstj�rnun";
    $text['vwrctrls'] = "Virkja mynd sko�ara stj�rnum Image Viewer Controls";
    $text['vwrclose'] = "loka mynda sko�ara";
    break;

  case "dna":
    $text['test_date'] = "Pr�fdagsetning";
    $text['links'] = "Relevant links";
    $text['testid'] = "Au�kennisnr. pr�fs";
    //added in 12.0.0
    $text['mode_values'] = "Mode Values";
    $text['compareselected'] = "Bera saman vali�";
    $text['dnatestscompare'] = "Bera saman Y-DNA pr�f";
    $text['keep_name_private'] = "Keep Name Private";
    $text['browsealltests'] = "Browse All Tests";
    $text['all_dna_tests'] = "�ll DNA pr�f";
    $text['fastmutating'] = "Fast&nbsp;Mutating";
    $text['alltypes'] = "Allar tegundir";
    $text['allgroups'] = "Allir h�par";
    $text['Ydna_LITbox_info'] = "Test(s) linked to this person were not necessarily taken by this person.<br />The 'Haplogroup' column displays data in red if the result is 'Predicted' or green if the test is 'Confirmed'";
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
$text['matches'] = "Leitarni�urst��ur:";
$text['description'] = "L�sing";
$text['notes'] = "Athugasemdir";
$text['status'] = "Sta�a";
$text['newsearch'] = "N� leit";
$text['pedigree'] = "Ni�jatal";
$text['seephoto'] = "Sj� mynd";
$text['andlocation'] = "& sta�setning";
$text['accessedby'] = "Sko�a� af";
$text['family'] = "Fj�lskylda"; //from getperson
$text['children'] = "B�rn";  //from getperson
$text['tree'] = "Tr�";
$text['alltrees'] = "�ll tr�";
$text['nosurname'] = "[Eftirnafn vantar]";
$text['thumb'] = "Sm�mynd";  //as in Thumbnail
$text['people'] = "F�lk";
$text['title'] = "Titill";  //from getperson
$text['suffix'] = "Fornafn";  //from getperson
$text['nickname'] = "G�lunafn";  //from getperson
$text['lastmodified'] = "S��ast Breytt";  //from getperson
$text['married'] = "Gift(ur)";  //from getperson
//$text['photos'] = "Photos";
$text['name'] = "Fornafn"; //from showmap
$text['lastfirst'] = "Eftirnafn, fornafn";  //from search
$text['bornchr'] = "F�dd(ur)/Sk�r�(ur)";  //from search
$text['individuals'] = "Einstaklingar";  //from whats new
$text['families'] = "Fj�lskyldur";
$text['personid'] = "Nr. einstaklings";
$text['sources'] = "Heimildir";  //from getperson (next several)
$text['unknown'] = "Ekki sk�r�(ur)";
$text['father'] = "Fa�ir";
$text['mother'] = "M��ir";
$text['christened'] = "Sk�r�(ur)";
$text['died'] = "D�in(n)";
$text['buried'] = "Jar�sett(ur)";
$text['spouse'] = "Maki";  //from search
$text['parents'] = "Foreldrar";  //from pedigree
$text['text'] = "Texti";  //from sources
$text['language'] = "Tungum�l";  //from languages
$text['descendchart'] = "Afkomendur";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Einstaklingur";
$text['edit'] = "Breyta";
$text['date'] = "Dags";
$text['place'] = "Sta�ur";
$text['login'] = "Innskr�ning";
$text['logout'] = "�tskr�ning";
$text['groupsheet'] = "H�p Skr�";
$text['text_and'] = "og";
$text['generation'] = "Kynsl��";
$text['filename'] = "Skr�arnafn";
$text['id'] = "ID";
$text['search'] = "Leita";
$text['user'] = "Notandi";
$text['firstname'] = "Fornafn";
$text['lastname'] = "Eftirnafn";
$text['searchresults'] = "Leitarni�urst��ur";
$text['diedburied'] = "D�in(n)/Jar�sett(ur)";
$text['homepage'] = "A�als��a";
$text['find'] = "Finna...";
$text['relationship'] = "Skyldleiki";    //in German, Verwandtschaft
$text['relationship2'] = "Relationship"; //different in some languages, at least in German (Beziehung)
$text['timeline'] = "T�mal�na";
$text['yesabbr'] = "J�";               //abbreviation for 'yes'
$text['divorced'] = "Skilin";
$text['indlinked'] = "Tengist";
$text['branch'] = "Grein";
$text['moreind'] = "Fleiri einstaklingar";
$text['morefam'] = "Fleiri fj�lskyldur";
$text['source'] = "Heimildir";
$text['surnamelist'] = "Listi yfir eftirn�fn";
$text['generations'] = "Kynsl��ir";
$text['refresh'] = "Endurn�ja";
$text['whatsnew'] = "Hva� er n�tt";
$text['reports'] = "Sk�rslur";
$text['placelist'] = "Listi yfir sta�i";
$text['baptizedlds'] = "Sk�r�ur (LDS)";
$text['endowedlds'] = "Fermdur (LDS)";
$text['sealedplds'] = "Sealed P (LDS)";
$text['sealedslds'] = "Sealed S (LDS)";
$text['ancestors'] = "Forfe�ur";
$text['descendants'] = "Afkomendur";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "GEDCOM sk�rsla s��ast innflutt";
$text['type'] = "t�pa";
$text['savechanges'] = "Breytingar vista�ar";
$text['familyid'] = "Nr. fj�lskyldu";
$text['headstone'] = "Legsteinn";
$text['historiesdocs'] = "Saga &<br>Skj�l";
$text['anonymous'] = "�nefndur";
$text['places'] = "Sta�ir";
$text['anniversaries'] = "Dagsetningar og merkisatbur�ir";
$text['administration'] = "Vefstj�rn";
$text['help'] = "Hj�lp";
//$text['documents'] = "Documents";
$text['year'] = "�r";
$text['all'] = "Allt";
$text['repository'] = "Greftrunarsta�ur";
$text['address'] = "Stinga upp�";
$text['suggest'] = "Suggest";
$text['editevent'] = "Stinga upp� a� breyta �essum atbur�";
$text['findplaces'] = "Finna alla einstaklinga me� vi�bur�i � �essum sta�";
$text['morelinks'] = "Fleiri tenglar";
$text['faminfo'] = "Uppl�singar um fj�lskyldu";
$text['persinfo'] = "Uppl�singar um einstakling";
$text['srcinfo'] = "uppsprettu uppl�singar";
$text['fact'] = "Sta�reynd";
$text['goto'] = "Velja s��u";
$text['tngprint'] = "Prenta";
$text['databasestatistics'] = "T�lfr��i"; //needed to be shorter to fit on menu
$text['child'] = "Barn";  //from familygroup
$text['repoinfo'] = "Uppl�singar um heimildas�fn";
$text['tng_reset'] = "Hreinsa";
$text['noresults'] = "Engar ni�urst��ur fundust";
$text['allmedia'] = "�ll margmi�lun";
$text['repositories'] = "Heimildas�fn";
$text['albums'] = "Myndaalb�m";
$text['cemeteries'] = "Kirkjugar�ar";
$text['surnames'] = "Eftirn�fn";
$text['dates'] = "Dagsetningar";
$text['link'] = "Tengill";
$text['media'] = "Margmi�lun";
$text['gender'] = "Kyn";
$text['latitude'] = "Breiddargr��a";
$text['longitude'] = "Lengdargr��a";
$text['bookmarks'] = "B�kamerki";
$text['bookmark'] = "B�ta vi� b�kamerki";
$text['mngbookmarks'] = "Fara � b�karmerki";
$text['bookmarked'] = "B�kamerki b�tt vi�";
$text['remove'] = "Fjarl�gja";
$text['find_menu'] = "Finna";
$text['info'] = "Uppl�singar"; //this needs to be a very short abbreviation
$text['cemetery'] = "Kirkjugar�ur";
$text['gmapevent'] = "Kort yfir atbur�i";
$text['gevents'] = "Atbur�ir";
$text['glang'] = "&amp;hl=is";
$text['googleearthlink'] = "Tengill � Google Earth";
$text['googlemaplink'] = "Tengill � Google Maps";
$text['gmaplegend'] = "Sk�ringar � merkingum";
$text['unmarked'] = "�merkt";
$text['located'] = "Sta�setning";
$text['albclicksee'] = "Smelltu til a� sj� alla hluti � �essu myndaalb�mi";
$text['notyetlocated'] = "ekki fundinn enn";
$text['cremated'] = "Brenndur";
$text['missing'] = "Vantar";
$text['pdfgen'] = "B�a til PDF skjal";
$text['blank'] = "T�mt kort";
$text['none'] = "Ekkert";
$text['fonts'] = "Letur";
$text['header'] = "Haus";
$text['data'] = "Uppl�singar";
$text['pgsetup'] = "S��u uppsetning";
$text['pgsize'] = "S��u St�r�";
$text['orient'] = "Sn�ningur"; //for a page
$text['portrait'] = "Portrait";
$text['landscape'] = "Landscape";
$text['tmargin'] = "Efri sp�ss�a";
$text['bmargin'] = "Ne�ri Sp�ss�a";
$text['lmargin'] = "Vinstri sp�ss�a";
$text['rmargin'] = "H�gri sp�ss�a";
$text['createch'] = "B�a til kort";
$text['prefix'] = "Forskeyti";
$text['mostwanted'] = "Eftirl�singar";
$text['latupdates'] = "S��ustu uppf�rslur";
$text['featphoto'] = "Myndir af handah�fi";
$text['news'] = "Fr�ttir";
$text['ourhist'] = "Fj�lskyldu saga okkar";
$text['ourhistanc'] = "Fj�lskyldusaga okkar og afkomendur";
$text['ourpages'] = "Fj�lskyldu ny�jatal";
$text['pwrdby'] = "�essi s��a er h�nnu� af";
$text['writby'] = "sem er b�i� til af";
$text['searchtngnet'] = "Leita � TNG S��unum (GENDEX)";
$text['viewphotos'] = "Sko�a allar myndir";
$text['anon'] = "�� ert ekki skr��ur undir nafni";
$text['whichbranch'] = "Hva�a grein kemur �� fr�?";
$text['featarts'] = "Grein af hand�fi";
$text['maintby'] = "Umsj�n s��u";
$text['createdon'] = "B�inn til af";
$text['reliability'] = "�rei�anleiki";
$text['labels'] = "Merkingar";
$text['inclsrcs'] = "Hafa Heimildir";
$text['cont'] = "(�framh.)"; //abbreviation for continued
$text['mnuheader'] = "�ttfr��is��a";
$text['mnusearchfornames'] = "Leit";
$text['mnulastname'] = "Eftirnafn";
$text['mnufirstname'] = "Fornafn";
$text['mnusearch'] = "Leita";
$text['mnureset'] = "Byrja upp � n�tt";
$text['mnulogon'] = "Innskr�";
$text['mnulogout'] = "�tskr�ning";
$text['mnufeatures'] = "A�rir kostir";
$text['mnuregister'] = "Skr�ning fyrir notenda a�gang";
$text['mnuadvancedsearch'] = "N�kv�mari leit";
$text['mnulastnames'] = "Eftirn�fn";
$text['mnustatistics'] = "T�lfr��i";
$text['mnuphotos'] = "Myndir";
$text['mnuhistories'] = "S�gur";
$text['mnumyancestors'] = "Photos &amp; Histories for Ancestors of [Person]";
$text['mnucemeteries'] = "Kirkjugar�ar";
$text['mnutombstones'] = "Legsteinar";
$text['mnureports'] = "Sk�rslur";
$text['mnusources'] = "Heimildir";
$text['mnuwhatsnew'] = "Hva� er n�tt";
$text['mnushowlog'] = "Loggar";
$text['mnulanguage'] = "Breyta tungum�li";
$text['mnuadmin'] = "Vefstj�rn";
$text['welcome'] = "Velkomin(n)";
$text['contactus'] = "Haf�u samband";
//changed in 8.0.0
$text['born'] = "F�dd(ur)";
$text['searchnames'] = "Leita � n�fnum";
//added in 8.0.0
$text['editperson'] = "Breytingar � einstakling";
$text['loadmap'] = "hla�a korti";
$text['birth'] = "F��ing";
$text['wasborn'] = "F�ddist �ann";
$text['startnum'] = "Upphafstala";
$text['searching'] = "leita";
//moved here in 8.0.0
$text['location'] = "Sta�setning";
$text['association'] = "Tenging";
$text['collapse'] = "Fella";
$text['expand'] = " �tlista n�nar ";
$text['plot'] = "Plot";
$text['searchfams'] = "Leita � fj�lskyldum";
//added in 8.0.2
$text['wasmarried'] = "giftist";
$text['anddied'] = "og l�st �ann";
//added in 9.0.0
$text['share'] = "Deila";
$text['hide'] = "Fela";
$text['disabled'] = "Notendareikningur �inn hefur veri� ger�ur �virkur.  Vinsamlega haf�u samband vi� stj�rnanda heimas��unnar til a� f� frekari uppl�singar.";
$text['contactus_long'] = "Ef �� hefur einhverjar spurningar e�a athugasemdir um �essa heimas��u, vinsamlega <span class=\"emphasis\"><a href=\"suggest.php\">hafi� samband</a></span>. Vi� hl�kkum til a� heyra fr� ��r.";
$text['features'] = "Features";
$text['resources'] = "Resources";
$text['latestnews'] = "N�justu fr�ttir";
$text['trees'] = "Tr�";
$text['wasburied'] = "var jar�sett(ur) �ann";
//moved here in 9.0.0
$text['emailagain'] = "Netfang aftur";
$text['enteremail2'] = "Vinsamlegast sl��u inn netfangi� �itt aftur.";
$text['emailsmatch'] = "Vinsamlegast sl��u inn sama netfang � hvern reit.";
$text['getdirections'] = "Smelltu til a� f� lei�beningar";
$text['calendar'] = "Dagatal";
//changed in 9.0.0
$text['directionsto'] = " til ";
$text['slidestart'] = "Hefja myndas�ningu";
$text['livingnote'] = "Lifandi einstaklingur - N�nari uppl�singar faldar";
$text['livingphoto'] = "A� minnstakosti einn einstaklingur � �essari mynd er lifandi - uppl�singar um mynd ekki gefnar upp.";
$text['waschristened'] = "var sk�r�(ur)";
//added in 10.0.0
$text['branches'] = "Greinar";
$text['detail'] = "Detail";
$text['moredetail'] = "More detail";
$text['lessdetail'] = "Less detail";
$text['otherevents'] = "A�rir atbur�ir";
$text['conflds'] = "Confirmed (LDS)";
$text['initlds'] = "Initiatory (LDS)";
$text['wascremated'] = "var brennd(ur)";
//moved here in 11.0.0
$text['text_for'] = "fyrir";
//added in 11.0.0
$text['searchsite'] = "Leita � ";
$text['searchsitemenu'] = "Leita � �llum g�gnum";
$text['kmlfile'] = "S�ktu .kml sk�rslu til a� s�na �essa sta�setningu � Google Earth";
$text['download'] = "Smelltu til a� s�kja";
$text['more'] = "Meira";
$text['heatmap'] = "Hitakort";
$text['refreshmap'] = "Endurn�ja kort";
$text['remnums'] = "Clear Numbers and Pins";
$text['photoshistories'] = "Photos &amp; Histories";
$text['familychart'] = "Family Chart";
//added in 12.0.0
$text['firstnames'] = "Forn�fn";
//moved here in 12.0.0
$text['dna_test'] = "DNA pr�f";
$text['test_type'] = "Pr�ftegund";
$text['test_info'] = "Pr�fuppl�singar";
$text['takenby'] = "Teki� af";
$text['haplogroup'] = "Haplogroup";
$text['hvr1'] = "HVR1";
$text['hvr2'] = "HVR2";
$text['relevant_links'] = "Relevant links";
$text['nofirstname'] = "[ekkert fornafn]";
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
$text['quicklinks'] = "Fl�tilei�ir";
$text['yourname'] = "Nafn �itt";
$text['youremail'] = "Netfangi� �itt";
$text['liketoadd'] = "��r uppl. sem �� vilt b�ta vi�";
$text['webmastermsg'] = "Skilabo� vefstj�ra";
$text['gallery'] = "Sj� galler�";
$text['wasborn_male'] = "f�ddist";
$text['wasborn_female'] = "f�ddist";
$text['waschristened_male'] = "var sk�r�ur";
$text['waschristened_female'] = "var sk�r�";
$text['died_male'] = "d�";
$text['died_female'] = "d�";
$text['wasburied_male'] = "var grafinn";
$text['wasburied_female'] = "var grafin";
$text['wascremated_male'] = "var brenndur";
$text['wascremated_female'] = "var brennd";
$text['wasmarried_male'] = "gift";
$text['wasmarried_female'] = "gift";
$text['wasdivorced_male'] = "var skilin";
$text['wasdivorced_female'] = "var skilin";
$text['inplace'] = "�";
$text['onthisdate'] = "�";
$text['inthisyear'] = "�";
$text['and'] = "og";

//moved here in 12.3
$text['dna_info_head'] = "DNA Test Info";
$text['firstpage'] = "Fyrsta s��a";
$text['lastpage'] = "S��asta s��a";

@include_once("captcha_text.php");
@include_once("alltext.php");
if (!$alltextloaded) {
  getAllTextPath();
}
?>
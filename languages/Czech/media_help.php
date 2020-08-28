<?php
include "../../helplib.php";
echo help_header("N�pov�da: M�dia");
?>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<body class="helpbody">
<a name="top"></a>
<table width="100%" cellpadding="10" cellspacing="2" class="tblback normal">
  <tr class="fieldnameback">
    <td class="tngshadow">
      <p style="float:right; text-align:right" class="smaller menu">
        <a href="https://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp; | &nbsp;
        <a href="https://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
        <a href="more_help.php" class="lightlink">&laquo; N�pov�da: V�ce</a> &nbsp; | &nbsp;
        <a href="collections_help.php" class="lightlink">N�pov�da: Kolekce &raquo;</a>
      </p>
      <span class="largeheader">N�pov�da: M�dia</span>
      <p class="smaller menu">
        <a href="#search" class="lightlink">Hledat</a> &nbsp; | &nbsp;
        <a href="#add" class="lightlink">P�idat</a> &nbsp; | &nbsp;
        <a href="#edit" class="lightlink">Upravit</a> &nbsp; | &nbsp;
        <a href="#delete" class="lightlink">Vymazat</a> &nbsp; | &nbsp;
        <a href="#convert" class="lightlink">P�ev�st</a> &nbsp; | &nbsp;
                <a href="#album" class="lightlink">P�idat do alba</a> &nbsp; | &nbsp;
                <a href="#sort" class="lightlink">Se�adit</a> &nbsp; | &nbsp;
                <a href="#thumbs" class="lightlink">N�hledy</a> &nbsp; | &nbsp;
                <a href="#import" class="lightlink">Import</a> &nbsp; | &nbsp;
                <a href="#upload" class="lightlink">Nahr�t</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a name="search"><p class="subheadbold">Hledat</p></a>
            <p>Nalezen� existuj�c�ch m�di� vyhled�n�m cel�ho nebo ��sti <strong>ID ��sla m�dia, titulu, popisu, um�st�n�</strong> nebo
                <strong>z�kladn�ho textu</strong>. Pro dal�� z��en� va�eho v�b�ru pou�ijte dal�� dostupn� mo�nosti.
                Vyhled�v�n� bez vybran�ch voleb a bez zapsan�ch hodnot ve v�b�rov�ch pol� povede k v�b�ru v�ech m�di� z va�� datab�ze. Vyhled�vac� volby obsahuj�:</p>

            <span class="optionhead">Strom</span>
            <p>Omez� v�sledek na m�dia spojen� pouze s vybran�m stromem.</p>

            <span class="optionhead">Kolekce</span>
            <p>Omez� v�sledek na m�dia vybran�ho typu kolekce. Chcete-li p�idat novou kolekci, klikn�te na tla��tko "P�idat kolekci", a v zobrazen�m okn� vypl�te formul��.
                Pro va�i novou kolekci mus�te vytvo�it slo�ku a mus�te vytvo�it vlastn� ikonu (nebo pou��t n�jakou st�vaj�c�). Pole "Stejn� nastaven� jako"
                v�m umo�n� ozna�it, ze kter� ze st�vaj�c�ch kolekc� si nov� kolekce vezme nastaven�.</p>

            <span class="optionhead">P��pona souboru</span>
            <p>P�ed kliknut�m na tla��tko Hledat zapi�te p��ponu souboru (nap�. "jpg" nebo "gif") pro omezen� v�sledku na m�dia
                s n�zvem souboru, kter� obsahuje tuto p��ponu.</p>

            <span class="optionhead">Pouze nep�ipojen�</span>
            <p>P�ed kliknut�m na tla��tko Hledat za�krtn�te toto pol��ko pro omezen� v�sledku na m�dia, kter� nejsou p�ipojena k ��dn� osob�,
                rodin�, pramenu, �lo�i�ti pramen� nebo m�stu.</p>

            <span class="optionhead">Stav</span>
            <p><strong>(pouze N�hrobky)</strong> P�ed kliknut�m na tla��tko Hledat vyberte ze seznamu stav pro zobrazen� v�ech z�znam� n�hrobk� se stejn�m stavem.</p>

            <span class="optionhead">H�bitov</span>
            <p>P�ed kliknut�m na tla��tko Hledat vyberte ze seznamu h�bitov pro zobrazen� v�ech z�znam� n�hrobk� spojen�ch s vybran�m h�bitovem.</p>

            <p>Vyhled�vac� krit�ria, kter� zad�te na t�to str�nce, budou uchov�na, dokud nekliknete na tla��tko <strong>Obnovit</strong>, kter� znovu obnov� v�echny v�choz� hodnoty.</p>

            <span class="optionhead">Akce</span>
            <p>Tla��tko Akce vedle ka�d�ho v�sledku hled�n� v�m umo�n� upravit, vymazat nebo otestovat v�sledek. Chcete-li najednou vymazat v�ce osob, za�krtn�te pol��ko ve sloupci
                <strong>Vybrat</strong> u ka�d�ho z�znamu, kter� m� b�t odstran�n, a pot� klikn�te na tla��tko "Vymazat ozna�en�" na za��tku seznamu. Pro za�krtnut� nebo vy�i�t�n� v�ech v�b�rov�ch pol��ek najednou
                m��ete pou��t tla��tka <strong>Vybrat v�e</strong> nebo <strong>Vy�istit v�e</strong>.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="add"><p class="subheadbold">P�idat nov� m�dium</p></a>

            <p>Chcete-li p�idat nov� m�dium, klikn�te na z�lo�ku <strong>P�idat nov�</strong> a pot� vypl�te formul��. Dal�� informace jako obr�zek mapy, informace o m�st� a
                odkazy na osoby, rodiny a dal�� subjekty m��ete p�idat po ulo�en� nebo zamknut� z�znamu. V�znam jednotliv�ch pol� je n�sleduj�c�:</p>

            <span class="optionhead">Kolekce</span>
            <p>Vyberte typ m�dia, kter�m je va�e polo�ka (nap�. fotografie, dokumenty, n�hrobky, vypr�v�n�, zvukov� z�znam nebo video). ��dn� z <span class="emphasis">kolekc�</span> m�di� nen� omezena typem souboru.</p>

            <span class="optionhead">Toto m�dium je z extern�ho zdroje</span>
            <p>Toto pol��ko za�krtn�te, pokud se obr�zek nach�z� n�kde na internetu jinde ne� na va�em serveru. Do pole ozna�en�ho "URL m�dia" mus�te zapsat
                �plnou webovou adresu (nap�. <em>http://www.tentoweb.com/image.jpg</em>), a
                pokud chcete m�t n�hled tohoto obr�zku, mus�te p�idat vlastn� (TNG jej nevytvo��).</p>

            <span class="optionhead">Soubor s m�diem</span>
            <p>Vyberte fyzick� soubor (ze sv�ho lok�ln�ho po��ta�e nebo z va�ich webov�ch str�nek) pro tuto medi�ln� polo�ku.</p>

            <span class="optionhead">Soubor pro nahr�n�</span>
            <p>Pokud va�e nov� medi�ln� polo�ka je�t� nebyla nahr�na na va�e webov� str�nky, klikn�te na tla��tko "Proch�zet" a vyhledejte ji na va�em disku.
                Je-li tato polo�ka ji� na va�ich str�nk�ch, nechte toto pole pr�zdn�.</p>

            <span class="optionhead">N�zev souboru na str�nk�ch / Media URL</span>
            <p>Pokud jste ji� va�i medi�ln� polo�ku nahr�li na str�nky, zapi�te um�st�n� a n�zev souboru va�� polo�ky tak, jak existuje ve slo�ce odpov�daj�c� kolekce na va�ich webov�ch str�nk�ch,
                nebo klikn�te na tla��tko "Vybrat" a vyhledejte soubor ve slo�ce p��slu�n� kolekce. Pokud nahr�v�te va�i medi�ln� polo�ku nyn�
                pomoc� p�edchoz�ho pole, pou�ijte toto pole pro z�pis um�st�n� a n�zvu souboru a� po nahr�n� souboru. P�edpokl�dan� um�st�n� a
                n�zev souboru bude p�edvypln�no. Pokud jste ozna�ili, �e toto m�dium poch�z� z extern�ho zdroje, popis tohoto pole se zm�n� na "URL m�dia",
                a v tomto p��pad� byste m�li zapsat absolutn� URL.</p>

            <p><strong>POZN.</strong>: Budete-li na str�nky nahr�vat nyn�, adres��, kter� jste zde ozna�ili, mus� existovat a mus� m�t nastaveno pr�vo na z�pis pro v�echny. Pokud ne, pou�ijte v� FTP program
                nebo jin� online souborov� spr�vce, vytvo�te slo�ku a dejte ji p��slu�n� opr�vn�n� (fungovat by m�lo 775, ale na n�kter�ch str�nk�ch je po�adov�no 777). </p>

            <span class="optionhead">NEBO Z�kladn� text</span>
            <p>M�sto nahr�n� fyzick�ho souboru m��ete do tohoto pole zapsat nebo vlo�it text nebo HTML k�d.
                Pro form�tov�n� textu m��ete tak� pou��t ovl�dac� prvky na horn�m okraji pole Z�kladn� text. P�idr��te-li kursor my�i nad ovl�dac�mi prvky, uvid�te jejich funkci.</p>

            <p><strong>POZN.:</strong> Pokud pou��v�te HTML, <strong>nevkl�dejte</strong> HTML nebo BODY tagy.</p>

            <span class="optionhead">Soubor s n�hledem obr�zku</span>
            <p>Jako n�hled (men�� obr�zek) t�to medi�ln� polo�ky m��ete vybrat existuj�c� fyzick� soubor (ze sv�ho lok�ln�ho po��ta�e nebo z va�ich webov�ch str�nek)
                nebo pro v�s tento n�hled vytvo�� TNG. Pokud nevyberete ani jednu volbu, TNG pou�ije v�choz� soubor n�hledu. <strong>Pozn.:</strong>
                N�hled by m�l m�t ide�ln� stranu o velikost 50 a� 100 pixel�. V� n�hled <strong>NEMٮE</strong> b�t toto�n� s origin�ln�m obr�zkem! TNG se ozve, pokud se pokus�te pou��t
                p�vodn� obr�zek jako n�hled. Pokud n�hled ji� nem�te, TNG jej pro v�s m��e vytvo�it, ale pouze, pokud je va�e medi�ln� polo�ka platn� obr�zek JPG, GIF nebo PNG.
                TNG m��e tak� vytvo�it n�hledy z n�kter�ch soubor� PDF, ale st�le m��e po v�s po�adovat, abyste pro jin� soubory (zejm�na star�� soubory PDF) nahrali vlastn� n�hledy.</p>

            <span class="optionhead">Zadat obr�zek/Vytvo�it z origin�lu</span>
            <p>Pokud v� server podporuje knihovnu GD image, uvid�te zde mo�nost zapsat v� vlastn�
                n�hled nebo nechat jej TNG vytvo�it z origin�lu. Vyberete-li druhou mo�nost, bude standardn� n�zev nov�ho souboru stejn� jako n�zev origin�lu, ale s p�edponou
                a/nebo p��ponou nav�c. Tato p�edpona a p��pona, spolu s maxim�ln� v��kou a d�lkou n�hledu, je nastavena v Z�kladn�m nastaven�. <strong>Pozn.:</strong> V�
                n�hled <strong>NEMٮE</strong> b�t toto�n� s origin�ln�m obr�zkem! TNG se ozve, pokud se pokus�te pou��t
                p�vodn� obr�zek jako n�hled. Pokud n�hled ji� nem�te, TNG jej pro v�s m��e vytvo�it, ale pouze, pokud je va�e medi�ln� polo�ka ve form�tu JPG, GIF nebo PNG (v n�kter�m p��pad� i PDF).
                PHP se m��e ozvat, pokud chcete vytvo�it n�hled z p��li� velk�ho obr�zku (v�ce ne� 1MB).</p>

            <span class="optionhead">Soubor pro nahr�n�</span>
            <p>P�i po�adavku na vytvo�en� rodokmenu osoby jsou n�hledy jednotliv�ch fotografi� souvisej�c�ch s danou osobou zobrazeny na stejn� str�nce. Pokud obr�zek n�hledu
                va�� medi�ln� polo�ky je�t� nebyl na va�e webov� str�nky nahr�n, klikn�te na tla��tko "Proch�zet" a vyhledejte n�hled na va�em disku.
                Do dal��ho pole pak mus�te zadat c�lov� um�st�n� a n�zev souboru obr�zku n�hledu.
                Je-li tento n�hled ji� na va�ich str�nk�ch, nechte toto pole pr�zdn�.</p>

            <span class="optionhead">N�zev souboru na str�nk�ch</span>
            <p>Pokud jste ji� v� soubor n�hledu nahr�li na str�nky, zapi�te um�st�n� a n�zev souboru va�eho n�hledu tak, jak existuje ve slo�ce odpov�daj�c� kolekce na va�ich webov�ch str�nk�ch
                (tip: n�hledy m��ete ulo�it v podslo�ce, pokud chcete, aby byly uchov�v�ny odd�len�, nebo maj� stejn� n�zvy jako v�t�� obr�zky). Pokud nezn�te p�esn� n�zev souboru,
                m��ete kliknout na tla��tko "Vybrat" a vyhledejte soubor. Pokud nahr�v�te v� soubor n�hledu nyn� pomoc� p�edchoz�ho pole, pou�ijte toto pole pro z�pis um�st�n� a
                n�zvu souboru a� po nahr�n� souboru. P�edpokl�dan� um�st�n� a n�zev souboru bude p�edvypln�no.</p>

            <p><strong>POZN.</strong>: Budete-li na str�nky nahr�vat nyn�, adres��, kter� jste zde ozna�ili, mus� existovat a mus� m�t nastaveno pr�vo na z�pis pro v�echny. Pokud ne, pou�ijte v� FTP program
                nebo jin� online souborov� spr�vce, vytvo�te slo�ku a dejte ji p��slu�n� opr�vn�n� (fungovat by m�lo 775, ale na n�kter�ch str�nk�ch je po�adov�no 777). </p>

            <span class="optionhead">Soubory ulo�it ve: Slo�ce multim�di� / Slo�ce kolekce</span>
            <p>M��ete zvolit, zda m� b�t tato medi�ln� polo�ka ulo�ena ve slo�ce odpov�daj�c� kolekci vybran� v��e (v�choz� mo�nost) nebo ji m��ete ulo�it v obecn� slo�ce
                multim�di�.</p>

            <span class="optionhead">Titul</span>
            <p>Titul by m�l b�t kr�tk� &#151; pouze p�r slov k identifikaci va�� medi�ln� polo�ky. Bude pou�it jako odkaz na str�nce zobrazuj�c� va�i polo�ku.</p>

            <span class="optionhead">Popis</span>
            <p>Do tohoto pole vlo�te v�ce podrobnost�, v�etn� informace, kdo nebo co je zobrazeno nebo pops�no, apod. Toto pole bude
                doprov�zet kr�tk� popis (viz p�edchoz� pole).</p>

            <span class="optionhead">���ka, v��ka</span>
            <p><strong>(pouze video)</strong> N�kter� p�ehr�va�e videa (nap�. Quicktime) po�aduj� specifickou ���ku a v��ku videa. Nejsou-li tyto rozm�ry specifikov�ny, m��e pak b�t video p��li� o��znut�
                a n�kter� ��sti videa nemus� b�t viditeln�. Proto doporu�ujeme, abyste sem zapsali velikost va�eho videa v pixelech. Pamatujte tak� na to,
                abyste po��tali s asi 16 pixely na ovlada�e videa (ovlada�e play/stop/volume, atd.).</p>

            <span class="optionhead">Majitel/Pramen, Datum po��zen�</span>
            <p>Toto jsou nepovinn� pole. Pokud tyto �daje zn�te, zapi�te je do p��slu�n�ch pol�.</p>

            <span class="optionhead">Strom</span>
            <p>Chcete-li spojit toto m�dium s ur�it�m stromem, vyberte jej zde. Bude to m�t vliv na u�ivatele, kte�� maj� pr�vo pouze upravovat
                polo�ky spojen� s jejich p�id�len�m stromem.</p>

            <span class="optionhead">H�bitov</span>
            <p><strong>(pouze N�hrobky)</strong> H�bitov, na kter�m se n�hrobek nach�z�. Nejprve mus�te h�bitov p�idat do tabulky h�bitov�
                (Admin/H�bitovy), pak bude vid�t v tomto poli.</p>

            <span class="optionhead">Pozemek</span>
            <p><strong>(pouze N�hrobky)</strong> Pozemek, kde se nach�z� n�hrobek (nepovinn�).</p>

            <span class="optionhead">Stav</span>
            <p><strong>(pouze N�hrobky)</strong> Z rozbalovac�ho seznamu vyberte slovo nebo fr�zi, kter� nejl�pe popisuje stav fyzick�ho n�hrobku.</p>

            <span class="optionhead">V�dy viditeln�</span>
            <p>Toto pol��ko za�krtn�te, pokud chcete, aby toto m�dium bylo u p�ipojen�ch osob zobrazeno v�dy bez ohledu na u�ivatelsk� opr�vn�n� nebo zda se jedn� o osobu �ij�c�.</p>

            <span class="optionhead">Otev��t v nov�m okn�</span>
            <p>Toto pol��ko za�krtn�te, pokud chcete, aby se polo�ka po kliknut� na jej� odkaz otev�ela v nov�m okn�.</p>

            <span class="optionhead">Spojit toto m�dium p��mo s vybran�m h�bitovem</span>
            <p><strong>(pouze N�hrobky)</strong> Za�krtnut�m tohoto pol��ka spoj�te tento obr�zek n�hrobku se samotn�m h�bitovem. P�i zobrazen� str�nky h�bitova se v�echny medi�ln� polo�ky
                spojen� se h�bitovem t�mto zp�sobem zobraz� v horn� ��sti str�nky.</p>

            <span class="optionhead">Uk�zat mapu h�bitova a m�dium, kdykoliv bude tato polo�ka zobrazena</span>
            <p><strong>(pouze N�hrobky)</strong> Pokud m� h�bitov, na kter� se n�hrobek nach�z�, p�ilo�enou mapu nebo fotografii, za�krtnut�m tohoto pol��ka se mapa nebo fotografie zobraz� kdykoli
                je zobrazen n�hrobek.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="edit"><p class="subheadbold">Upravit existuj�c� m�dium</p></a>
            <p>Chcete-li upravit existuj�c� m�dium, k nalezen� polo�ky pou�ijte z�lo�ku <a href="#search">Hledat</a>, a pot� klikn�te na ikonu Upravit vedle t�to polo�ky.
                V�znam pol�, kter� nejsou na str�nce "P�idat nov� m�dium", je n�sleduj�c�:</p>

            <span class="optionhead">Odkazy na m�dium</span>
            <p>Toto m�dium m��ete p�ipojit k osob�m, rodin�m, pramen�m, �lo�i�t�m pramen� nebo m�st�m. Pro ka�d� odkaz nejd��ve vyberte strom spojen� se subjektem, se kter�m chcete polo�ku spojit.
                D�le vyberte typ odkazu (osoba, rodina, pramen, �lo�i�t� pramen� nebo m�sto) a na z�v�r ID ��slo nebo n�zev (pouze u m�sta) subjektu, se kter�m polo�ku spojujete.
                Po vlo�en� v�ech t�chto �daj� klikn�te na tla��tko "P�idat".</p>

            <p>Pokud nezn�te ID ��slo nebo p�esn� n�zev m�sta, kliknut�m na ikonu lupy je m��ete vyhledat. Objev� se okno, ve kter�m m��ete hledat.
                Po nalezen� po�adovan�ho popisu subjektu klikn�te na odkaz "P�idat" vlevo. Kliknout na "P�idat" m��ete u v�ce subjekt�. Po ukon�en� vytv��en�
                odkaz� klikn�te na odkaz "Zav��t okno".</p>

            <p><strong>Existuj�c� odkazy:</strong> Existuj�c� odkazy m��ete upravit nebo vymazat kliknut�m na ikonu Upravit nebo Vymazat vedle tohoto odkazu. �prava odkazu
                v�m umo�n� spojit odkaz s ur�itou ud�lost� a p�id�lit mu <strong>Alternativn� titul</strong> a <strong>Alternativn� popis</strong>. Pro ka�d� odkaz m��ete
                kliknut�m na p��slu�n� pol��ko tak� zm�nit <strong>V�choz� fotografii</strong> nebo stav <strong>Zobrazit</strong>. N�e jsou uvedeny dal�� informace o t�chto vlastnostech.</p>

            <p>Kliknut�m na odkaz "Se�adit" vedle jm�na se dostanete rychle na str�nku, na kter� m��ete p�et��dit jednotliv� medi�ln� polo�ky tohoto subjektu. Tut� v�c m��ete prov�st kliknut�m
                na z�lo�ku Se�adit na horn�m okraji str�nky M�dia, ale tento zp�sob je rychlej��.</p>

            <p><strong>VAROV�N�</strong>: Odkazy na ur�it� ud�losti, kter� vytvo��te v TNG, mohou b�t n�sledn�m importem souboru GEDCOM p�eps�ny.</p>

            <span class="optionhead">Nastavit jako v�choz�</span>
            <p>Za�krtnut�m tohoto pol��ka bude n�hled tohoto m�dia pou�it ve sch�matu v�vodu a v horn� ��sti dal��ch str�nek, kter� souvis� s osobou nebo subjektem, ke kter�mu
                je polo�ka p�ipojena.</p>

            <span class="optionhead">Zobrazit</span>
            <p>Toto pol��ko od�krtn�te, pokud nechcete, aby byl n�hled tohoto m�dia zobrazen na str�nce osoby. Toto m��ete ud�lat, kdy� je obr�zek
                ji� sou��st� alba, kter� bylo p�ipojeno k t�e osob�.</p>

            <span class="optionhead">M�sto po��zen�/vytvo�en�</span>
            <p>
            <p>Tato sekce je ve v�choz�m stavu sbalena. Pro jej� rozbalen� klikn�te na v�raz "M�sto po��zen�/vytvo�en�" nebo na �ipku vedle n�j. Zn�te-li n�zev m�sta,
                kde byla fotografie po��zena, zapi�te jej do pole ozna�en�ho "M�sto po��zen�/vytvo�en�".</p>

            <span class="optionhead">Zem�pisn� ���ka a d�lka</span>
            <p>Pokud jsou s va�� medi�ln� polo�kou spojeny sou�adnice zem�pisn� ���ky a d�lky, zapi�te je sem a pom��ete ostatn�m p�esn� ur�it m�sto.
                Jinak m��ete pro nastaven� zem�pisn� ���ky a d�lky m�sta m�dia pou��t funkci geok�dov�n� Google Map. KLiknut�m na tla��tko "Zobrazit/skr�t klikac� mapu"
                se otev�e Google Map.</p>

            <span class="optionhead">P�ibl�en�</span>
            <p>Zadejte �rove� p�ibl�en� nebo upravte ovl�dac� prvek p�ibl�en� v Google Map pro nastaven� �rovn� p�ibl�en�. Tato volba je dostupn� pouze, kdy� jste obdr�eli "kl��"
                od Google a zapsali jej do va�eho nastaven� map v TNG.</p>

            <p>Pozn.: Zem�pisn� ���ka/d�lka/p�ibl�en� je u medi�ln�ch polo�ek pouze z informativn�ch d�vod�. M�sto nen� p�esn� ur�eno na ��dn� map� ve ve�ejn� oblasti.</p>

            <span class="optionhead">Mapa obr�zku</span>
            <p>Tato sekce je ve v�choz�m stavu sbalena. Pro jej� rozbalen� klin�te na v�raz "Mapa obr�zku" nebo na �ipku vedle n�j. V t�to sekci m��ete spojit
                r�zn� ��sti obr�zku s osobami ve va�� datab�zi, nebo zobrazit kr�tk� zpr�vy p�i p�em�st�n� kursoru my�� nad tyto ��sti.</p>

            <p><strong>Pozn.</strong>: Pro pou�it� t�to funkce mus� b�t medi�ln� polo�ka ve form�tu JPG, GIF nebo PNG.</p>

            <p>U ka�d� oblasti, kterou chcete spojit s osobou, nejd��ve zvolte strom dan� osoby, pot� ur�ete na obr�zku oblast nakreslen�m obd�ln�ku ukazatelem va�� my��.
                Nejprve klikn�te do lev�ho horn�ho rohu obd�ln�ku, pot� my� podr�te a p�esunut�m dol� do prava nakreslete obd�ln�k. Dostanete-li se do prav�ho doln�ho roku obd�ln�ku, uvoln�te my�.
                Takto vyberete sou�adnice va�eho obr�zku. Po v�b�ru sou�adnic se objev� okno, ve kter�m m��ete naj�t nebo zapsat ID ��slo osoby. Pro nalezen� z�znamu zapi�te
                cel� jm�no osoby nebo jen jeho ��st anebo ID ��slo, a pot� ze zobrazen�ch kandid�t� vyberte spr�vnou osobu. Okno
                se zav�e a do pole Mapa obr�zku pod obr�zkem bude vlo�en k�d t�to oblasti. V p��pad� pot�eby m��ete k�d upravit nebo
                jej zapsat p��mo.</p>

            <p>Tento postup m��ete opakovat pro dal�� oblasti. Ka�d� nov� k�d bude vlo�en na konec obsahu pole Mapa obr�zku.</p>

            <p>Chcete-li r�zn� ��sti va�eho obr�zku spojit s r�zn�mi str�nkami nebo zobrazit kr�tk� zpr�vy p�i p�em�st�n� kursoru my�� nad tyto ��sti, zapi�te do tohoto pole
                pot�ebn� k�d mapy obr�zku. Vytvo�it svoji vlastn� mapu obr�zku m��ete podle sekce Tvorba mapy obr�zku na konci str�nky.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Top</a></p>
            <a name="delete"><p class="subheadbold">Vymazat m�dium</p></a>

            <p>Chcete-li odstranit jednu medi�ln� polo�ku, pou�ijte z�lo�ku <a href="#search">Hledat</a> pro nalezen� dan� polo�ky, a pot� klikn�te na ikonu Vymazat vedle t�to polo�ky. Tento ��dek zm�n�
                barvu a pot� po odstran�n� polo�ky zmiz�. Chcete-li najednou odstranit v�ce polo�ek, za�krtn�te pol��ko ve sloupci Vybrat vedle ka�d� polo�ky, kterou
                chcete odstranit, a pot� klikn�te na tla��tko "Vymazat vybran�" na str�nce naho�e</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="convert"><p class="subheadbold">P�ev�st m�dium z jedn� kolekce do jin�</p></a>
            Chcete-li p�ev�st medi�ln� polo�ky z jednoho typu m�dia nebo "kolekce" do jin�, za�krtn�te na z�lo�ce <a href="#search">Hledat</a> pol��ko vedle t�chto polo�ek,
            pot� z rozbalovac�ho seznamu v horn� ��sti str�nky vedle tla��tka "P�ev�st vybran� na" vyberte novou kolekci. Na z�v�r klikn�te na tla��tko "P�ev�st vybran� na".
            Str�nka bude zobrazena znovu s �ervenou stavovou zpr�vou naho�e.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="album"><p class="subheadbold">P�idat m�dium do alba</p></a>
            Chcete-li m�dium p�idat do alba, za�krtn�te pol��ko Vybrat vedle polo�ek, kter� maj� b�t p�id�ny, pot� z rozbalovac�ho seznamu v horn� ��sti str�nky
            vedle tla��tka "P�idat do alba" vyberte album. Na z�v�r klikn�te na tla��tko "P�idat do alba". M�dia m��ete do alba p�idat tak� z Admin/Alba.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="sort"><p class="subheadbold">Se�adit m�dia</p></a>
            <p>Standardn� jsou m�dia spojen� s osobou, rodinou, pramenem, �lo�i�t�m pramen� nebo m�stem se�azena v po�ad�, ve kter�m byla k tomuto subjektu p�ipojena. Toto po�ad�
                m��ete zm�nit na z�lo�ce Media/Se�adit.</p>

            <span class="optionhead">Strom, Typ odkazu, Kolekce:</span>
            <p>Zvolte strom spojen� se subjektem, u kter�ho chcete zm�nit po�ad� m�di�. D�le vyberte typ odkazu (osoba, rodina, pramen, �lo�i�t� pramen� nebo m�sto) a
                kolekci, kterou chcete p�et��dit.</p>

            <span class="optionhead">ID ��slo:</span>
            <p>Zapi�te ID ��slo nebo n�zev (pouze m�sta) subjektu. Pokud nezn�te ID ��slo nebo p�esn� n�zev m�sta, kliknut�m na ikonu lupy je m��ete vyhledat.
                Po nalezen� po�adovan�ho subjektu klikn�te na odkaz "Vybrat" vedle tohoto subjektu. Okno se zv�e a vybran� ID ��slo se objev� v poli ID ��slo.</p>

            <span class="optionhead">Spojeno s ur�itou ud�lost�</span>
            <p>Pokud chcete p�et��dit medi�ln� polo�ky p�ipojen� k ur�it� ud�losti spojen� s p�ipojen�m subjektem, za�krtn�te pol��ko ozna�en� "Spojeno s ur�itou ud�lost�" PO
                vypln�n� v�ech ostatn�ch pol�, v�etn� ID ��sla. Objev� se dal�� rozbalovac� seznam, ve kter�m vyberete
                tuto ur�itou ud�lost (nepovinn�).</p>

            <span class="optionhead">Postup t��d�n�</span>
            <p>Po v�b�ru nebo z�pisu ID ��sla klikn�te na tla��tko "Pokra�ovat..." a zobraz� se v�echna m�dia vybran�ho subjektu a kolekce v jejich aktu�ln�m po�ad�.
                Chcete-li polo�ky p�et��dit, klikn�te u n�kter� polo�ky na oblast "T�hnout" a p�i stisknut�m tla��tku my�i p�esu�te polo�ku na po�adovan� m�sto
                v seznamu. Je-li polo�ka na po�adovan�m m�st�, uvoln�te tla��tko my�i ("t�hni a pus�"). V tomto okam�iku budou ulo�eny zm�ny.</p>

            <p>Dal�� mo�nost� p�et��d�n� polo�ek je z�pis po sob� jdouc�ch ��sel do mal�ch pol��ek vedle oblasti "T�hnout", pot� kliknut� na odkaz "Go" pod pol��kem nebo stisknut� Enteru.
                M��e to b�t v�hodn�, pokud je seznam p��li� dlouh� a nevejde se na jednu obrazovku.</p>

            <p>Jakoukoli polo�ku m��ete p�esunout na za��tek seznamu kliknut�m na ikonu "Top" nad pol��kem s po�ad�m.</p>

            <span class="optionhead">V�choz� fotografie</span>
            <p>P�i t��d�n� m��ete zvolit jakoukoli zobrazenou fotografii jako <strong>V�choz� fotografii</strong> aktu�ln�ho subjektu. Znamen� to, �e se n�hled zvolen�ho obr�zku
                objev� ve sch�matu v�vodu a v titulech str�nek s n�zvem nebo popisem aktu�ln�ho subjektu. Chcete-li nastavit nebo vymazat ozna�en� V�choz� fotografie, podr�te
                kurzor my�i nad obr�zkem v seznamu, a pot� klikn�te na jednu z voleb, kter� se objev�: "Nastavit jako v�choz�" nebo "Odstranit". Aktu�ln� v�choz� fotografii
                lze odstranit tak� kliknut�m na odkaz "Odstranit v�choz� fotografii" na str�nce naho�e.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="thumbs"><p class="subheadbold">N�hledy</p></a>

            <span class="optionhead">Vytvo�it n�hledy</span>
            <p>Pop kliknut� na tla��tko "Vygenerovat" pod touto volbou, vytvo�� TNG automaticky n�hledy v�ech obr�zk� form�tu JPG, GIF nebo
                PNG, kter� nemaj� existuj�c� n�hledy. Standardn� bude n�zev obr�zku stejn� jako je n�zev velk�ho obr�zku a bude obsahovat
                p�edponu a/nebo p��ponu, kter� jsou definov�ny v Z�kladn�m nastaven�. Za�krtnut�m pol��ka ozna�en�ho "Obnovit existuj�c� n�hledy" vytvo��te
                n�hledy v�ech obr�zk�, v�etn� t�ch, kter� je ji� maj�. Pol��ko "Obnovit n�zvy cest k n�hled�m, kde soubor neexistuje" za�krtn�te, pokud
                si mysl�te, �e m�te n�kter� n�hledy, kter� ukazuj� na neplatn� soubory. To zp�sob�, �e TNG p�ehodnot� n�zvy cest u n�hled� p�ed obnoven�m n�hled�.
                Bez t�to funkce by doch�zelo k op�tovn�mu vytv��en� n�kter�ch neplatn�ch n�zv� n�hled�.</p>

            <p><strong>POZN.</strong>: Pokud nevid�te sekci Vytvo�it n�hledy, v� server nepodporuje knihovnu GD image.</p>

            <span class="optionhead">P�i�adit v�choz� fotografie</span>
            <p>Tato volba v�m umo�n� nastavit jako v�choz� fotografii prvn� fotografii u ka�d� osoby, rodiny nebo pramenu
                (ta, kter� bude zobrazena ve sch�matu v�vodu, rodiny a naho�e na ka�d� str�nce, kter� je s dan�m subjektem spojena). P�i�azen� m��e b�t provedeno
                pro v�echny osoby, rodiny, prameny a �lo�i�t� pramen� v ur�it�m stromu v�b�rem tohoto stromu z rozbalovac�ho seznamu. Za�krtnut�m pol��ka
                ozna�en�ho "P�epsat existuj�c� nastaven�" nastav�te v�choz� fotografie bez ohledu na to, co bylo nastaveno d��ve. Ponech�n� tohoto pol��ka
                neza�krtnut�ho v�m umo�n� ponechat d��ve nastaven� v�choz� fotografie.</p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="import"><p class="subheadbold">Import m�di�</p></a>

            <span class="optionhead">C�l</span>
            <p>Vytvo�en� z�znamu m�dia pro ka�d� fyzick� soubor ve va�� slo�ce m�di� s n�zvem souboru jako titulem ka�d�ho z�znamu.</p>

            <span class="optionhead">Pou�it�</span>
            <p>Chcete-li import prov�st, zvolte nejprve kolekci (nebo vytvo�te novou kolekci) a strom (pokud maj� b�t vkl�dan� polo�ky spojeny s ur�it�m stromem), pot� klikn�te na tla��tko "Import".
                Existuje-li ji� pro polo�ku z�znam, nov� z�znam se nevytvo��. "Kl��em" (kter� ur��, zda ji� z�znam existuje nebo ne) je
                n�zev souboru a strom. Pokud importujete stejnou polo�ku do v�ce strom� (nebo pokud byla polo�ka kdysi importov�na do "v�ech strom�" a jindy
                jen do ur�it�ho stromu), TNG nepozn�, �e ji� m�te z�znam pro tuto polo�ku a vytvo�� jej znovu.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="upload"><p class="subheadbold">Nahr�n� m�di�</p></a>

            <span class="optionhead">C�l</span>
            <p>D�vkov� nahr�n� v�ce polo�ek m�di�, jejich opat�en� tituly a popisy, v�etn� jejich p�ipojen� k osob�m, rodin�m, pramen�m nebo m�st�m
                p��mo z t�to obrazovky.</p>

            <span class="optionhead">Pou�it�</span>
            <p>Chcete-li tuto funkci pou��t, zvolte nejprve kolekci a strom (pokud maj� b�t vkl�dan� polo�ky spojeny s ur�it�m stromem), pot� klikn�te na "P�idat soubory" a z va�eho po��ta�e vyberte soubory pro nahr�n�. V�t�ina prohl�e�� (mimo Internet
                Explorer) v�m umo�n� soubory chytit a p�et�hnout
                z jin�ho okna p��mo do b�l� oblasti ve st�edu obrazovky. Chcete-li zvolit jako c�l pro nahr�n� va�ich soubor� podslo�ku v r�mci zvolen� slo�ky, zapi�te do pole "Slo�ka" jej� n�zev nebo pou�ijte tla��tko
                "Vybrat" pro v�b�r podslo�ky, kter� ji� existuje. Nechcete-li soubory ulo�it do podslo�ky, nechte pole Slo�ka pr�zdn�.
                Po dokon�en� v�b�ru soubor� a jejich um�st�n� m��ete zah�jit nahr�n� v�ech soubor� najednou kliknut�m
                na tla��tko "Spustit nahr�n�" na str�nce naho�e. Nebo m��ete nahr�t soubory jednotliv� kliknut�m na tla��tko "Spustit" vedle p��slu�n�ho souboru.
                Po ukon�en� nahr�n� m��ete p�idat nov� titul nebo popis, nebo p�ipojit polo�ku k ur�it�mu z�znamu ve va�� datab�zi, nebo je v�echny vymazat.</p>

            <span class="optionhead">Zm�na titulu a popisu</span>
            <p>Po nahr�n� souboru se zobraz� pole pro titul a popis. Chcete-li zm�nit v�choz� hodnoty, nov� �daje zapi�te a klikn�te na "Ulo�it" ve st�edu oblasti.
                Dal�� �daje m��ete pozd�ji p�idat z obrazovky �prava m�dia.</p>

            <span class="optionhead">P�idat odkazy</span>
            <p>Chcete-li p�ipojit ur�itou medi�ln� polo�ku k polo�ce va�� datab�ze, po�kejte na ukon�en� nahr�n�. Pot� klikn�te na tla��tko "Odkazy na m�dium" na stejn�m ��dku.
                Zapi�te ID ��slo a klikn�te na "P�idat" nebo pro vyhled�n� a v�b�r ��sla ID pou�ijte volbu Naj�t.</p>
            <p>Chcete-li p�ipojit v�ce medi�ln�ch polo�ek najednou ke stejn� polo�ce, za�krtn�te z�tr�ku na ��dku u ka�d� polo�ky (nebo pou�ijte tla��tko "Vybrat v�e" pro v�b�r v�ech nahran�ch
                polo�ek), a pot� pou�ijte pole na obrazovce dole pro dokon�en� operace. Zapi�te ID ��slo nebo pro vyhled�n� pou�ijte volbu Naj�t. Je-li ��slo ID
                v poli ID a vybr�na byla alespo� jedna medi�ln� polo�ka, klikn�te na tla��tko "P�ipojit k vybran�m" pro vytvo�en� odkaz�.</p>
        </td>
    </tr>

</table>
</body>
</html>

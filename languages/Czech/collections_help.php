<?php
include "../../helplib.php";
echo help_header("N�pov�da: Kolekce");
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp; | &nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="media_help.php" class="lightlink">&laquo; N�pov�da: M�dia</a> &nbsp; | &nbsp;
                <a href="albums_help.php" class="lightlink">N�pov�da: Alba &raquo;</a>
            </p>
            <h2 class="largeheader">N�pov�da: <small>Kolekce</small></h2>
            <p class="smaller menu">
                <a href="#what" class="lightlink">Co to je?</a> &nbsp; | &nbsp;
                <a href="#add" class="lightlink">P�idat/Upravit/Vymazat</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="what"><h4 class="subheadbold">Co jsou to kolekce?</h4></a>

            <p><strong>Kolekcemi</strong> se v TNG rozum� typ m�dia. Standardn� kolekce v TNG jsou Fotografie, Dokumenty, N�hrobky, Vypr�v�n�, Videa a
                Zvukov� z�znamy,
                ale TNG v�m umo�n� vytvo�it i vlastn� kolekce. Kolekce nen� omezena jedn�m typem souboru. Nap�. obr�zky .jpg mohou b�t sou��st�
                kter�koli kolekce,
                nejen fotografi� a dokument�, a kolekce Fotografie nemus� obsahovat pouze obrazov� soubory.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="add"><h4 class="subheadbold">P�id�n� kolekce</h4></a>

            <p>Chcete-li p�idat novou kolekci, klikn�te na tla��tko "P�idat kolekci" kdekoli je viditeln� (nap�. na obrazovk�ch M�dia, P�idat m�dia a
                Upravit m�dia).
                Po zobrazen� mal�ho okna vypl�te formul��. V�znam jednotliv�ch pol� je n�sleduj�c�:</p>

            <h5 class="optionhead">ID ��slo kolekce</h5>
            <p>Velmi kr�tk� �et�zec znak�, kter� slou�� jako identifik�tor t�to kolekce. Nem�l by obsahovat mezery ani ��dn� znaky, kter� nejsou
                alfanumerick�,
                a m�l m�t maxim�ln� 10 znak�. Nap�. pokud jste vytvo�ili kolekci pro vojensk� z�znamy, do tohoto pole byste m�li zapsat "military".
                Tato hodnota se nikde nezobraz�, tak�e nen� d�le�it�, jak ji pojmenujete, ale mus� b�t jednozna�n�.</p>

            <h5 class="optionhead">Exportovat jako</h5>
            <p>Kdy� exportujete soubor GEDCOM, kter� obsahuje m�dia, soubor bude obsahovat ��dek pro ka�dou polo�ku ozna�uj�c�, o jak� typ m�dia jde.
                M�lo by to b�t
                jedno slovo zapsan� velk�mi p�smeny. Nap�. fotografie se bude exportovat s typem "PHOTO". Pokud jste vytvo�ili novou kolekci nazvanou
                "Noviny",
                do tohoto pole m��ete vlo�it "NEWSPAPER".</p>

            <h5 class="optionhead">Zobrazen� titul</h5>
            <p>Jde o n�zev, kter� bude zobrazen kdekoli je zm�n�na kolekce a kdekoli je zobrazena polo�ka z t�to kolekce. Zobrazen� titul m��e b�t o
                n�co del��
                ne� ID ��slo kolekce, ale m�l by b�t tak� relativn� kr�tk�. P�i pou�it� stejn�ho p��kladu m��ete do tohoto pole vlo�it "Vojensk�
                z�znamy".
                Standardn� bude n�zev, kter� zap�ete, pou�it ve v�ech jazyc�ch. Pokud podporujete v�ce jazyk� a chcete, aby byl Zobrazovan� n�zev
                p�elo�en do jazyk�, kter� podporujete,
                budete do souboru "cust_text.php" ve slo�ce ka�d�ho jazyka muset vytvo�it z�pis. Kl��em prom�nn� $text by m�lo b�t ID ��slo kolekce a
                hodnotou je Zobrazovan� titul. V tomto p��klad� by m�l z�pis vypadat takto:</p>

            <pre>$text['military'] = "Vojensk� z�znamy";</pre>

            <p>Tento z�pis vlo�te do souboru cust_text.php v ka�d�m jazyce a p�elo�te pouze ��st "Vojensk� z�znamy". Kl�� neboli ID ��slo ("military")
                by nem�l
                b�t p�elo�en.</p>

            <h5 class="optionhead">N�zev slo�ky</h5>
            <p>N�zev fyzick� slo�ky nebo adres��e na va�ich webov�ch str�nk�ch, kde budou polo�ky z t�to kolekce ulo�eny. M�l by b�t relativn� kr�tk�,
                bez mezer
                a s pouze alfanumerick�mi znaky (nap�. "military"). Po z�pisu hodnoty m��ete kliknout na tla��tko "Vytvo�it slo�ku". M�li byste
                uvid�t zpr�vu o tom, zda bylo vytvo�en� �sp�n� �i nikoli. Pokud v� server tuto operaci nepovoluje, mus�te pro vytvo�en� slo�ky pou��t
                program FTP nebo
                n�jak� online spr�vce soubor�. Slo�ka by m�la b�t vytvo�ena ve stejn� rodi�ovsk� slo�ce jako slo�ky kolekc� "photos", "documents",
                "histories" a dal��ch.
                Aktu�ln� n�zev mus� p�esn� odpov�dat n�zvu, kter� jste zapsali ("Military" nen� stejn� jako "military").</p>

            <h5 class="optionhead">Lok�ln� um�st�n�</h5>
            <p>Toto pole v�m pom��e stanovit, jak velkou ��st n�zvu lok�ln�ho um�st�n� va�ich m�di� je t�eba ulo�it na va�ich str�nk�ch b�hem importu
                souboru GEDCOM
                pomoc� odebr�n� ��sti n�zvu, kter� je jedine�n� pro v� dom�c� po��ta�. Zadejte z�kladn� cestu nebo cesty (v�ce polo�ek odd�lte
                ��rkami), kde jsou soubory z t�to kolekce
                um�st�ny na va�em dom�c�m po��ta�i. Jin�mi slovy, v p��pad�, �e soubory v po��ta�i se nach�z� ve slo�ce "C:\Genealogie\Soubory", to je
                to, co byste sem m�li zadat.
                TNG pak odd�l� tuto ��st z ka�d�ho p��choz�ho n�zvu cesty a ponech� pouze n�zev souboru nebo n�zev dal�� podslo�ky.
                Pokud soubory pro tuto kolekci jsou v m�stn�m po��ta�i na v�ce m�stech nebo pokud na n� v� soubor GEDCOM odkazuje, ani� by m�ly n�zev
                pln� cesty (nap�. pouze "MojeSoubory"),
                zadejte ty cesty jako v�ce z�pis�.
                Pokud jsou n�kter� z va�ich soubor� um�st�ny v podslo�k�ch tohoto um�st�n� a na sv�ch webov�ch str�nk�ch chcete tuto strukturu
                zachovat, podslo�ky nezad�vejte do tohoto um�st�n�.
                Chcete-li, aby se v�echny soubory dostaly na va�em webu do stejn� slo�ky, ponechte toto pole pr�zdn�. Pokud toto pole je pr�zdn�, TNG
                automaticky odstran� v�echno mimo n�zv� soubor�.
            </p>

            <h5 class="optionhead">Soubor s ikonou</h5>
            <p>Mus�te vytvo�it svoji vlastn� ikonu nebo pou��t n�jakou existuj�c� a n�zev souboru s ikonou zapsat do tohoto pole. Soubor s ikonou m��e
                b�t um�st�n v hlavn� slo�ce TNG
                nebo jej m��ete ulo�it do slo�ky "img" spolu s ostatn�mi standardn�mi ikonami (jako "tng_photo.gif" nebo "tng_doc.gif"). Pokud jej
                ulo��te do slo�ky "img",
                mus�te k n�zvu souboru p�idat p��ponu "img/".</p>

            <h5 class="optionhead">Soubor n�hledu</h5>
            <p>Toto je n�zev v�choz�ho obr�zku n�hledu t�to kolekce. Jin�mi slovy, pokud vytvo��te v t�to kolekci medi�ln� polo�ku a pro tuto
                specifickou polo�ku nepou�ijete
                n�hled, obr�zek zapsan� zde bude pou�it jako n�hled. Obr�zek n�hledu m��e b�t ulo�en v hlavn� slo�ce TNG
                nebo jej m��ete ulo�it do slo�ky "img" spolu s ostatn�mi standardn�mi ikonami. Pokud jej ulo��te do slo�ky "img",
                mus�te k n�zvu souboru p�idat p��ponu "img/".</p>

            <h5 class="optionhead">Po�ad� v zobrazen�</h5>
            <p>Zde zapi�te cel� ��slo, kter� bude ud�vat po�ad�, ve kter� bude va�e vlastn� kolekce zobrazena v rozbalovac�ch nab�dk�ch ve ve�ejn�
                oblasti. Ni��� ��sla se objev� jako prvn�.</p>

            <h5 class="optionhead">Stejn� nastaven� jako</h5>
            <p>Mo�n� jste si v�imli, �e se obrazovky P�idat m�dium a Upravit m�dium tro�ku m�n� v z�vislosti na zvolen� kolekci. Toto pole "stejn�
                nastaven� jako" v�m umo�n�
                ozna�it, kterou standardn� kolekci va�e nov� kolekce nejv�ce p�ipom�n�, s ohledem na uspo��d�n� t�chto obrazovek.</p>

            <h4 class="subheadbold">�prava/Vymaz�n� kolekce</h4>

            <p>Pro �pravu existuj�c� vlastn� kolekce (standardn� nelze m�nit, s v�jimkou hodnot v Z�kladn�m nastaven�) vyberte kolekci z rozbalovac�ho
                seznamu a
                klikn�te na tla��tko Upravit. Zobraz� se stejn� pole, jako jsou v��e uvedena.</p>

            <p>Pro vymaz�n� existuj�c� vlastn� kolekce vyberte kolekci z rozbalovac�ho seznamu a klikn�te na tla��tko Vymazat. Vymaz�na by nem�la b�t
                ani fyzick� slo�ka, kterou jste vytvo�ili,
                ani ��dn� polo�ka nach�zej�c� se v t�to slo�ce.</p>

        </td>
    </tr>

</table>
</body>
</html>

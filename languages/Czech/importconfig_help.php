<?php
include "../../helplib.php";
echo help_header("N�pov�da: Nastaven� importu dat");
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<body class="helpbody">
<a id="top"></a>
<table width="100%" cellpadding="10" cellspacing="2" class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp; | &nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="logconfig_help.php" class="lightlink">&laquo; N�pov�da: Nastaven� protokolov�n�</a> &nbsp; | &nbsp;
                <a href="mapconfig_help.php" class="lightlink">N�pov�da: Nastaven� mapy &raquo;</a>
            </p>
            <h2 class="largeheader">N�pov�da: <small>Nastaven� importu dat</small></h2>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">
            <span class="optionhead">Slo�ka souboru GEDCOM (Import/Export)</span>
            <p>N�zev slo�ky, ze kter� bude TNG importovat soubory GEDCOM a m�sto, kam bude TNG ukl�dat exportovan� soubory GEDCOM.</p>

            <span class="optionhead">Ulo�it stav importu</span>
            <p>Pokud import nebo export z n�jak�ho d�vodu sel�e a nebude dokon�en, vyberte tuto mo�nost a spus�te import/export znovu. Pokud proces
                op�t nedob�hne do konce, klikn�te na odkaz pokra�ovat a import/export bude pokra�ovat z m�sta, kde byl p�eru�en.
                V p��pad� importu pracuje tato volba pouze, je-li v� soubor GEDCOM ve va�� slo�ce GEDCOM (nepracuje se soubory, kter� jsou nahr�v�ny a importov�ny
                p��mo z obrazovky Import dat).</p>

            <span class="optionhead">Po�et z�znam� reportu</span>
            <p>Toto je po�et z�znam�, kter� TNG provede mezi reporty na obrazovce. Aby v� import b�el rychleji, zadejte tento po�et
                o n�co vy��� (kolem ��sla 100). Pokud v� import sel�e nebo li�ta pr�b�hu p�estane ukazovat n�jak� pokrok,
                budete muset toto ��slo sn�it, co� zp�sob�, �e TNG bude reportovat m�n� �asto a obrazovkov� pam� se bude plnit rychleji.</p>

            <span class="optionhead">Interval pr�b�hu (ms)</span>
            <p>Jedn� se o po�et milisekund, kdy TNG p�eru�� testy, aby vid�l, zda bylo reportov�no v�ce importovan�ch z�znam�.</p>

            <span class="optionhead">V�choz� volba Nahrazen�</span>
            <p>Toto ovlivn�, kter� volba importu "Nahradit" bude vybr�na jako v�choz� na str�nce importu.</p>

            <span class="optionhead">Pokud je 'Datum zm�ny' pr�zdn�</span>
            <p>Pokud v� z�znam osoby, rodiny nebo pramene nem� p�ipojeno datum posledn� zm�ny, kter� ozna�uje, kdy byl z�znam
                naposledy aktualizov�n, TNG tuto hodnotu napln� podle t�to volby. M��ete pou��t dne�n� datum nebo toto pole
                nechat pr�zdn�. Ponech�te-li je pr�zdn�, toto pole nep�ep�e existuj�c� datum zm�ny.</p>

            <span class="optionhead">Pokud chyb� datum narozen�, p�edpokl�dat, �e</span>
            <p>TNG ozna�� v�echny p��choz� z�znamy osob jako �ij�c� nebo ne. Pokud osoba nem� datum �mrt� nebo poh�bu nebo m�sto,
                toto ozna�en� bude zalo�eno na dob�, kter� uplynula od narozen� osoby. Pokud tato osoba nem� datum narozen�,
                TNG to m��e interpretovat r�zn�mi zp�soby. Vyberte, zda maj� tyto osoby b�t ozna�eny jako zesnul� nebo �ij�c�.</p>

            <span class="optionhead">Pokud chyb� datum �mrt�, p�edpokl�dat, �e osoba zem�ela, je-li star�� ne�</span>
            <p>Pokud osoba nem� datum �mrt� nebo poh�bu nebo m�sto, ozna�en� �ij�c� bude zalo�eno na dob�,
                kter� uplynula od narozen� osoby. Osoby mlad�� ne� v�k ozna�en� v tomto poli budou pova�ov�ny za �ij�c�.
                V�choz� nastaven� maxim�ln�ho v�ku pro �ij�c� osoby je 110 let.</p>

            <span class="optionhead">Osoba je neve�ejn�, pokud zem�ela p�ed m�n� ne� tolika lety</span>
            <p>TNG nastav� u osoby b�hem importu ozna�en� Neve�ejn�, pokud tato osoba zem�ela p�ed m�n� ne� tolika lety. Toto pole
                nechte pr�zdn� nebo jej nastavte na hodnotu 0, nechcete-li ozna�en� Neve�ejn� nastavovat t�mto zp�sobem.</p>

            <span class="optionhead">Osoba je �ij�c�, pokud zem�ela p�ed m�n� ne� tolika lety</span>
            <p>Podobn� jako v p�edchoz� volb� nastav� TNG b�hem importu souboru GEDCOM ozna�en� �ij�c� u osoby, pokud zem�ela p�ed m�n� ne� tolika lety.
                Toto pole nechte pr�zdn� nebo jej nastavte na hodnotu 0, nechcete-li ozna�en� �ij�c� nastavovat t�mto zp�sobem.</p>

            <span class="optionhead">Vkl�dan� m�dia</span>
            <p>Pokud za�krtnete pol��ko "Nechat TNG pojmenovat vkl�dan� m�dia", TNG bude ignorovat um�st�n� a n�zvy soubor� spojen�ch s va�imi vkl�dan�mi m�dii a p�ipoj�
                nov� n�zev souboru zalo�en� na konvenci ID ��slo stromu + ID ��slo m�dia + p��pona m�dia. Tento soubor pak bude ulo�en do slo�ky fotografi� (jak je definov�no v Z�kladn�m nastaven�).
                Tuto volbu m��ete vybrat, pokud jste importovali vkl�dan� m�dia ji� d��ve, proto�e TNG tuto konvenci pou��val jako v�choz� p�ed verz� 3.4.0. Pokud jste
                n�zvy d��ve importovan�ch m�di� pojmenovali pomoc� TNG a nyn� importujete n�zvy m�di� bez t�to vybran� volby, budete m�t duplicitn� soubory.</p>

            <span class="optionhead">Lok�ln� um�st�n� soubor� fotografi�</span>
            <p>Zapi�te z�kladn� um�st�n� (v�ce z�znam� odd�lujte ��rkou), kde jsou na va�em po��ta�i um�st�ny fotografie. M�lo by to odpov�dat TNG slo�ce fotografi�
                na va�ich webov�ch str�nk�ch. Jin�mi slovy, pokud jsou fotografie na va�em po��ta�i um�st�ny "C:\MyGenealogy\MyPhotos", m�li byste toto um�st�n� zadat sem. Pokud odkazy n�kter�ch fotografi�
                ukazuj� na toto m�sto relativn� (nap�. pouze "MyPhotos"), zadejte relativn� cestu jako v�ce vstup�. Pokud se n�kter� fotografie
                nach�zej� v podslo�k�ch tohoto um�st�n� a tuto strukturu chcete na va�em webu zachovat, nevkl�dejte do tohoto um�st�n� podslo�ky. Pokud chcete, aby v�echny fotografie byly ve stejn�m um�st�n�
                (TNG slo�ka Photos), nechte toto pole pr�zdn� a za�krtn�te "Importovat pouze n�zev souboru" jako posledn� volbu na t�to str�nce.</p>

            <span class="optionhead">Lok�ln� um�st�n� soubor� vypr�v�n�</span>
            <p>Zapi�te z�kladn� um�st�n� (v�ce z�znam� odd�lujte ��rkou), kde jsou na va�em po��ta�i um�st�na vypr�v�n�. M�lo by to odpov�dat TNG slo�ce vypr�v�n�
                na va�ich webov�ch str�nk�ch. Jin�mi slovy, pokud jsou vypr�v�n� na va�em po��ta�i um�st�na "C:\MyGenealogy\MyHistories", m�li byste toto um�st�n� zadat sem. Pokud odkazy n�kter�ch vypr�v�n�
                ukazuj� na toto m�sto relativn� (nap�. pouze "MyHistories"), zadejte relativn� cestu jako v�ce vstup�. Pokud se n�kter� vypr�v�n�
                nach�zej� v podslo�k�ch tohoto um�st�n� a tuto strukturu chcete na va�em webu zachovat, nevkl�dejte do tohoto um�st�n� podslo�ky. Pokud chcete, aby v�echna vypr�v�n� byla ve stejn�m um�st�n�
                (TNG slo�ka Histories), nechte toto pole pr�zdn� a za�krtn�te "Importovat pouze n�zev souboru" jako posledn� volbu na t�to str�nce.</p>

            <span class="optionhead">Lok�ln� um�st�n� soubor� dokument�</span>
            <p>Zapi�te z�kladn� um�st�n� (v�ce z�znam� odd�lujte ��rkou), kde jsou na va�em po��ta�i um�st�ny dokumenty. M�lo by to odpov�dat TNG slo�ce dokument�
                na va�ich webov�ch str�nk�ch. Jin�mi slovy, pokud jsou dokumenty na va�em po��ta�i um�st�ny "C:\MyGenealogy\MyDocuments", m�li byste toto um�st�n� zadat sem. Pokud odkazy n�kter�ch dokument�
                ukazuj� na toto m�sto relativn� (nap�. pouze "MyDocuments"), zadejte relativn� cestu jako v�ce vstup�. Pokud se n�kter� dokumenty
                nach�zej� v podslo�k�ch tohoto um�st�n� a tuto strukturu chcete na va�em webu zachovat, nevkl�dejte do tohoto um�st�n� podslo�ky. Pokud chcete, aby v�echny dokumenty byly ve stejn�m um�st�n�
                (TNG slo�ka Documents), nechte toto pole pr�zdn� a za�krtn�te "Importovat pouze n�zev souboru" jako posledn� volbu na t�to str�nce.</p>

            <span class="optionhead">Lok�ln� um�st�n� soubor� n�hrobk�</span>
            <p>Zapi�te z�kladn� um�st�n� (v�ce z�znam� odd�lujte ��rkou), kde jsou na va�em po��ta�i um�st�ny n�hrobky. M�lo by to odpov�dat TNG slo�ce n�hrobk�
                na va�ich webov�ch str�nk�ch. Jin�mi slovy, pokud jsou n�hrobky na va�em po��ta�i um�st�ny "C:\MyGenealogy\MyHeadstones", m�li byste toto um�st�n� zadat sem. Pokud odkazy n�kter�ch n�hrobk�
                ukazuj� na toto m�sto relativn� (nap�. pouze "MyHeadstones"), zadejte relativn� cestu jako v�ce vstup�. Pokud se n�kter� n�hrobky
                nach�zej� v podslo�k�ch tohoto um�st�n� a tuto strukturu chcete na va�em webu zachovat, nevkl�dejte do tohoto um�st�n� podslo�ky. Pokud chcete, aby v�echny n�hrobky byly ve stejn�m um�st�n�
                (TNG slo�ka Headstones), nechte toto pole pr�zdn� a za�krtn�te "Importovat pouze n�zev souboru" jako posledn� volbu na t�to str�nce.</p>

            <span class="optionhead">Lok�ln� um�st�n� soubor� ostatn�ch m�di�</span>
            <p>Zapi�te z�kladn� um�st�n� (v�ce z�znam� odd�lujte ��rkou), kde jsou na va�em po��ta�i um�st�ny ostatn� m�dia (nap�. videa nebo zvukov� z�znamy). M�lo by to odpov�dat TNG slo�ce multim�di�
                na va�ich webov�ch str�nk�ch. Jin�mi slovy, pokud jsou videa nebo zvukov� z�znamy na va�em po��ta�i um�st�ny "C:\MyGenealogy\MyMultimedia", m�li byste toto um�st�n� zadat sem. Pokud odkazy n�kter�ch multim�di�
                ukazuj� na toto m�sto relativn� (nap�. pouze "MyMultimedia"), zadejte relativn� cestu jako v�ce vstup�. Pokud se n�kter� videa nebo zvukov� z�znamy
                nach�zej� v podslo�k�ch tohoto um�st�n� a tuto strukturu chcete na va�em webu zachovat, nevkl�dejte do tohoto um�st�n� podslo�ky. Pokud chcete, aby v�echna videa nebo zvukov� z�znamy byla ve stejn�m um�st�n�
                (TNG slo�ka Multimedia), nechte toto pole pr�zdn� a za�krtn�te "Importovat pouze n�zev souboru" jako posledn� volbu na t�to str�nce.</p>

            <span class="optionhead">Pokud lok�ln� um�st�n� neodpov�d�</span>
            <p>Pokud je importov�na fotografie nebo vypr�v�n� a um�st�n� souboru neodpov�d� ani jednomu z lok�ln�ch um�st�n� ozna�en�ch v��e, TNG m��e bu� importovat cel� um�st�n� "tak, jak je" (doporu�eno, pokud
                jsou v�echna va�e um�st�n� relativn� a chcete, aby va�e lok�ln� struktura odpov�dala va�� TNG struktu�e slo�ek fotografi�/vypr�v�n�) nebo m��e o��znout �daj o um�st�n� pouze na n�zev souboru
                (doporu�eno, pokud nechcete, aby byla va�e m�dia vlo�ena do podslo�ek TNG slo�ek Photos nebo Histories).</p>

            <span class="optionhead">P�edpona pro neve�ejn� pozn�mky</span>
            <p>Pokud chcete, aby byly n�kter� va�e pozn�mky p�i importu ozna�eny jako "neve�ejn�" a nebyly zobrazeny ve ve�ejn� oblasti, TNG tak m��e u�init, pokud v�echny
                pozn�mky, kter� maj� tomuto popisu odpov�dat, za��naj� stejn�m znakem. Pro tyto ��ely se obvykle pou��v� znak tilda (~) nebo vyk�i�n�k (!).
                P�ed importem va�eho souboru GEDCOM sem zapi�te znak, kter� pro tyto ��ely pou��v�te a automaticky bude p�ipojeno ozna�en� "neve�ejn�".</p>

        </td>
    </tr>

</table>
</body>
</html>

<?php
include "../../helplib.php";
echo help_header("N�pov�da: U�ivatel�");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="https://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="https://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="templateconfig_help.php" class="lightlink">&laquo; N�pov�da: Nastaven� �ablony</a> &nbsp;|&nbsp;
                <a href="trees_help.php" class="lightlink">N�pov�da: Stromy &raquo;</a>
            </p>
            <h2 class="largeheader">N�pov�da: <small>U�ivatel�</small></h2>
            <p class="smaller menu" style="clear: both;">
                <a href="#search" class="lightlink">Hledat</a> &nbsp;|&nbsp;
                <a href="#add" class="lightlink">P�idat nebo Upravit</a> &nbsp;|&nbsp;
                <a href="#delete" class="lightlink">Vymazat</a> &nbsp;|&nbsp;
                <a href="#review" class="lightlink">P�ezkoumat</a> &nbsp;|&nbsp;
                <a href="#rights" class="lightlink">P��stupov� pr�va</a> &nbsp;|&nbsp;
                <a href="#limits" class="lightlink">Omezen� p��stupu</a> &nbsp;|&nbsp;
                <a href="#email" class="lightlink">Email</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="search"><h4 class="subheadbold">Hledat</h4></a>
            <p>Nalezen� existuj�c�ch u�ivatel� vyhled�n�m cel�ho nebo ��sti <strong>U�ivatelsk�ho jm�na, popisu nebo skute�n�ho jm�na</strong> nebo
                <strong>emailu</strong>. Pro z��en� va�eho hled�n� za�krtn�te
                "Zobrazit pouze u�ivatele s administr�torsk�m opr�vn�n�m". V�sledkem hled�n� bez zadan�ch voleb a hodnot ve vyhled�vac�ch pol�ch bude
                seznam v�ech u�ivatel� ve va�� datab�zi.</p>

            <p>Vyhled�vac� krit�ria, kter� zad�te na t�to str�nce, budou uchov�na, dokud nekliknete na tla��tko <strong>Obnovit</strong>, kter� znovu
                obnov� v�echny v�choz� hodnoty.</p>

            <h5 class="optionhead">Akce</h5>
            <p>Tla��tko Akce vedle ka�d�ho v�sledku hled�n� v�m umo�n� upravit nebo odstranit tento v�sledek. Chcete-li najednou odstranit v�ce
                z�znam�, za�krtn�te pol��ko ve sloupci
                <strong>Vybrat</strong> u ka�d�ho z�znamu, kter� m� b�t odstran�n a pot� klikn�te na tla��tko "Vymazat ozna�en�" na za��tku seznamu.
                Pro za�krtnut� nebo vy�i�t�n� v�ech v�b�rov�ch pol��ek najednou
                m��ete pou��t tla��tka <strong>Vybrat v�e</strong> nebo <strong>Vy�istit v�e</strong>.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="add"><h4 class="subheadbold">P�id�n� nov�ho u�ivatele</h4></a>
            <p>Nastaven� u�ivatelsk�ch z�znam� pro va�e n�v�t�vn�ky v�m umo�n� p�id�lit jim zvl�tn� p��stupov� pr�va, kter� vstoup� v platnost jejich
                p�ihl�en�m pomoc� u�ivatelsk�ho jm�na a hesla.
                Prvn� u�ivatel, kter�ho vytvo��te, by m�l b�t administr�tor (n�kdo, kdo m� v�echna pr�va a nen� omezen ��dn�m stromem, obvykle to jste
                vy). Pokud si nep�id�l�te dostate�n� (administr�torsk�) opr�vn�n�,
                nebudete schopni dostat se zp�t do administr�torsk� oblasti programu. Zapomenete-li sv� u�ivatelsk� jm�no, jd�te na str�nku P�ihl�en�
                a zadejte svoji emailovou adresu,
                kter� je spojena s va��m u�ivatelsk�m ��tem a u�ivatelsk� jm�no v�m bude zasl�no emailem. Zapomenete-li sv� heslo, zadejte svoji
                emailovou adresu a u�ivatelsk� jm�no a bude v�m zasl�no
                nov�, do�asn� heslo. Po p�ihl�en� pomoc� nov�ho hesla se vra�te do Admin/U�ivatel� a nastavte si heslo na n�jak� zapamatovateln�.</p>

            <p>Chcete-li p�idat nov�ho u�ivatele, klikn�te na z�lo�ku <strong>P�idat nov�</strong> a pak vypl�te formul��. Chcete-li upravit
                existuj�c�ho u�ivatele, klikn�te na ikonu Upravit vedle tohoto u�ivatele.
                V�znam pol� p�i p�id�n� nebo �prav� u�ivatele je n�sleduj�c�:</p>

            <h5 class="optionhead">Popis</h5>
            <p>Va�emu u�ivateli m��ete p�idat stru�n� popis, abyste v�d�li, o koho jde. M��ete nap�. zapsat "Administr�tor str�nek" nebo "Teta
                Marta".</p>

            <h5 class="optionhead">U�ivatelsk� jm�no</span></h5>
            <p>Jednozna�n� jednoslovn� identifik�tor tohoto u�ivatele (stejn� u�ivatelsk� jm�no nemohou m�t dva u�ivatel�). U�ivatel bude p�i
                p�ihl�en� po��d�n o zad�n� sv�ho u�ivatelsk�ho jm�na v d�lce max. 20 znak�.</p>

            <h5 class="optionhead">Heslo</h5>
            <p>D�v�rn� slovo nebo �et�zec znak� (bez mezer), kter� tento u�ivatel mus� tak� p�i p�ihl�en� zadat. P�i z�pisu do tohoto pole budou
                zapisovan� znaky
                na obrazovce pro zachov�n� utajen� nahrazov�ny hv�zdi�kami nebo jin�mi podobn�mi znaky. D�lka max. 20 znak�. Heslo je v datab�zi
                za�ifrov�no
                a nelze jej nik�m zobrazit, ani t�mto u�ivatelem nebo programem Next Generation.</p>

            <h5 class="optionhead">Skute�n� jm�no</h5>
            <p>Aktu�ln� jm�no (pokud je platn�) u�ivatele, kter� odpov�d� t�mto �daj�m.</p>

            <h5 class="optionhead">Telefon, email, internetov� str�nky, adresa, m�sto, kraj/provincie, PS�, zem�, pozn�mky</h5>
            <p>Nepovinn� �daje, kter� se t�kaj� u�ivatele.</p>

            <h5 class="optionhead">Nepos�lat tomuto u�ivateli hromadn� emaily</h5>
            <p>Toto pol��ko za�krtn�te, pokud nechcete, aby tomuto u�ivateli byly pos�l�ny hromadn� emaily (viz n�e).</p>

            <h5 class="optionhead">Strom / ID ��slo osoby</h5>
            <p>Pokud tento u�ivatel odpov�d� n�kter� osob� z va�� datab�ze, m��ete zde ozna�it strom a ID ��slo osoby jeho z�znamu.
                Umo�n� to zobrazit tomuto u�ivateli v�echny �daje ze sv�ho z�znamu, i kdy� tento z�znam nen� obsa�en v p�ipojen�m stromu nebo
                v�tvi.</p>

            <h5 class="optionhead">Zak�zat p��stup</h5>
            <p>Za�krtnut�m tohoto pol��ka zabr�n�te tomuto u�ivateli p�ihl�sit se, ani� byste vymazali jeho cel� u�ivatelsk� ��et.</p>

            <h5 class="optionhead">Role a p��stupov� pr�va</h5>
            <p>Viz <a href="#rights">n�e, kde jsou uvedeny podrobnosti o rol�ch a p��stupov�ch pr�vech</a>, kter� mohou b�t u�ivateli p�id�lena.</p>

            <p><h5 class="optionhead">Povinn� pole:</h5> Mus�te zadat u�ivatelsk� jm�no, heslo a popis u�ivatele. V�echna ostatn� pole jsou
            nepovinn�, ale doporu�ujeme
            zadat emailovou adresu pro p��pad, �e zapomenete sv� u�ivatelsk� jm�no nebo heslo.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="delete"><h4 class="subheadbold">Vymaz�n� u�ivatel�</h4></a>
            <p>Chcete-li odstranit u�ivatele, pou�ijte z�lo�ku <a href="#search">Hledat</a> k nalezen� u�ivatele, a pot� klikn�te na ikonku Vymazat
                vedle z�znamu tohoto u�ivatele. Tento ��dek zm�n�
                barvu a pot� po odstran�n� polo�ky u�ivatel zmiz�.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="review"><h4 class="subheadbold">P�ezkoumat</h4></a>

            <p>Kliknut�m na z�lo�ku "P�ezkoumat" m��ete spravovat nov� u�ivatelsk� registrace. Tyto u�ivatelsk� z�znamy nebudou aktivn�, dokud je
                nejd��v neuprav�te a neulo��te. Pot�, co se stane
                z�znam aktivn�m, u� nebude vid�t na z�lo�ce P�ezkoumat. M�sto toho jej bude mo�no nal�zt na z�lo�ce "Hledat".</p>

            <p>Nov� u�ivatelsk� z�znamy na z�lo�ce P�ezkoumat mohou b�t vymaz�ny nebo upravov�ny stejn�m zp�sobem jako ��dn� u�ivatelsk� z�znamy. P�i
                �prav� z�znamu nov�ho u�ivatele
                si pov�imn�te n�sleduj�c�ho:</p>

            <h5 class="optionhead">Vyrozum�t tohoto u�ivatele, �e byl ��et aktivov�n</h5>
            <p>Za�krtnut�m tohoto pol��ka po�lete emailem nov�mu u�ivateli informaci o aktivaci ��tu (po ulo�en� str�nky). Text zpr�vy se objev� v
                poli pod
                touto volbou. P�ed odesl�n�m m��ete prov�st zm�ny tohoto textu.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="rights"><h4 class="subheadbold">Role a p��stupov� pr�va</h4></a>

            <p>"P��stupov� pr�vo" je to, co m��e u�ivatel d�lat pot�, co se p�ihl�s�. "Role" je p�eddefinovan� sada p��stupov�ch pr�v, tak�e
                pokud vyberete jinou roli, seznam zvolen�ch p��stupov�ch pr�v (na prav� stran� str�nky) se zm�n� (p��stupov� pr�va "Povolit"
                na konci sloupce se v�b�rem role nezm�n�). V�b�rem role "Vlastn�" m��ete u�ivateli definovat svoji vlastn� sadu p��stupov�ch pr�v.
                N�kter� role v sob� zahrnuj� p�ipojen� u�ivatele k ur�it�mu stromu,
                v jin�ch rol�ch nebude u�ivatel p�ipojen k ��dn�mu stromu. Role, kterou vyberete, m��e pak zp�sobit, �e pole p�ipojen� strom nebude
                za�krtnuto.</p>

            <p>U�ivateli mohou b�t p�ipojena n�sleduj�c� p��stupov� pr�va:</p>

            <h5 class="optionhead">Povolit p�id�vat nov� z�znamy</h5>
            <p>U�ivatel m��e v administr�torsk� oblasti p�idat nov� z�znamy, v�etn� m�di�.</p>

            <h5 class="optionhead">Povolit p�id�vat pouze m�dia</h5>
            <p>U�ivatel m��e v administr�torsk� oblasti p�idat nov� m�dia, nic jin�ho.</p>

            <h5 class="optionhead">Bez pr�v p�id�vat</h5>
            <p>U�ivatel nesm� p�id�vat ��dn� nov� �daje.</p>

            <h5 class="optionhead">Povolit �pravy existuj�c�ch z�znam�</h5>
            <p>U�ivatel m��e v administr�torsk� oblasti upravovat existuj�c� z�znamy, v�etn� m�di�.</p>

            <h5 class="optionhead">Povolit �pravy pouze m�di�</h5>
            <p>U�ivatel m��e v administr�torsk� oblasti upravovat existuj�c� m�dia, nic jin�ho.</p>

            <h5 class="optionhead">Povolit p�edlo�it �pravy pro p�ezkoum�n� administr�torem</h5>
            <p>U�ivatel nem��e v administr�torsk� oblasti z�znamy upravovat. P�edb�n� zm�ny m��e ud�lat ve ve�ejn� oblasti kliknut�m na malou ikonu
                Upravit vedle p��slu�n�ch ud�lost� na str�nk�ch osoby a rodiny. Zm�ny se nestanou trval�mi, dokud nebudou schv�leny
                administr�torem.</p>

            <h5 class="optionhead">Bez pr�v upravovat</h5>
            <p>U�ivatel nesm� prov�d�t �pravy existuj�c�ch z�znam�.</p>

            <h5 class="optionhead">Povolit vymazat existuj�c� z�znamy</h5>
            <p>U�ivatel m��e v administr�torsk� oblasti vymazat existuj�c� z�znamy, v�etn� m�di�.</p>

            <h5 class="optionhead">Povolit vymazat pouze m�dia</h5>
            <p>U�ivatel m��e v administr�torsk� oblasti vymazat m�dia, nic jin�ho.</p>

            <h5 class="optionhead">Bez pr�v vymazat</h5>
            <p>U�ivatel nesm� vymazat ��dn� existuj�c� z�znamy.</p>

            <p>N�sleduj�c� p��stupov� pr�va jsou nez�visl� na zvolen� roli:</p>

            <h5 class="optionhead">Povolit prohl�en� �daj� �ij�c�ch osob</h5>
            <p>U�ivatel m��e ve ve�ejn� oblasti prohl�et �daje �ij�c�ch osob.</p>

            <h5 class="optionhead">Povolit prohl�en� �daj� osob ozna�en�ch jako neve�ejn�</h5>
            <p>U�ivatel m��e ve ve�ejn� oblasti prohl�et �daje osob ozna�en�ch jako neve�ejn�.</p>

            <h5 class="optionhead">Povolit sta�en� souboru GEDCOM</h5>
            <p>U�ivatel m��e ve ve�ejn� oblasti pou��t z�lo�ku GEDCOM ke sta�en� souboru GEDCOM. Toto potla�� nastaven� pro ka�d� strom v
                Administrace/Stromy.</p>

            <h5 class="optionhead">Povolit sta�en� souboru PDF</h5>
            <p>U�ivatel m��e ve ve�ejn� oblasti na r�zn�ch str�nk�ch pou��t volbu PDF pro vytvo�en� souboru PDF. Toto potla�� nastaven� pro ka�d�
                strom v Administrace/Stromy.</p>

            <h5 class="optionhead">Povolit prohl�en� �daj� CJKSpd</h5>
            <p>U�ivatel m��e ve ve�ejn� oblasti prohl�et �daje CJKSpd.</p>

            <h5 class="optionhead">Povolit �pravy u�ivatelsk�ho profilu</h5>
            <p>U�ivatel m��e z odkazu ve ve�ejn� oblasti upravovat sv�j u�ivatelsk� profil (u�ivatelsk� jm�no, heslo, atd.).</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="limits"><h4 class="subheadbold">Omezen� p��stupu</h4></a>

            <p>Toto definuje omezen� u�ivatelsk�ch pr�v. V�ichni u�ivatel� (v�etn� anonymn�ch n�v�t�vn�k�) mohou v�dy vid�t �daje zesnul�ch osob. Zde
                nejsou nutn� ��dn� pr�va
                nebo omezen� p��stup�.</p>

            <h5 class="optionhead">Omezit na strom/v�tev</h5>
            <p>Chcete-li omezit p��stupov� pr�vo u�ivatele na ur�it� strom, vyberte tento strom zde. Chcete-li omezit p��stupov� pr�va na ur�itou
                v�tev
                ve vybran�m strom�, vyberte tuto v�tev tak�. P�ipojen�m v�tve k u�ivateli nezabr�n�te tomuto u�ivateli zobrazit jin� osoby, kter�
                nejsou sou��st� t�to v�tve.</p>

            <h5 class="optionhead">Uplatnit pr�va na v�ce strom�</h5>
            <p>Chcete-li omezit pr�va u�ivatele na v�ce strom�, vyberte tuto mo�nost a pot� pomoc� kl�vesy Ctrl tyto stromy vyberte. Kdy� se u�ivatel
                poprv� p�ihl�s�,
                bude vybr�n prvn� strom z tohoto seznamu. U�ivatel se m��e p�ep�nat mezi stromy pomoc� rozbalovac� nab�dky v horn� ��sti str�nky v
                prav�m rohu nab�dky Administrace
                (rozbalovac� nab�dka je viditeln� pouze v p��pad�, �e je k dispozici v�b�r jin�ho stromu). N�sledn� p�ihl�en� ze stejn�ho prohl�e�e
                zp�sob�, �e na za��tku bude
                vybr�n naposledy pou�it� strom. U�ivatel se m��e p�ep�nat mezi stromy tak� z ve�ejn� str�nky Stromy. V tomto re�imu nelze prov�st
                v�b�r v�tve.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="email"><h4 class="subheadbold">Email</h4></a>
            <p>tato z�lo�ka umo��uje poslat email v�em u�ivatel�m nebo v�em u�ivatel�m p�ipojen�m k ur�it�mu stromu/v�tvi.</p>

            <h5 class="optionhead">P�edm�t</h5>
            <p>P�edm�t va�eho emailu.</p>

            <h5 class="optionhead">Text</h5>
            <p>T�lo va�� emailov� zpr�vy.</p>

            <h5 class="optionhead">Strom</h5>
            <p>Pokud chcete poslat tuto zpr�vu pouze u�ivatel�m p�ipojen�m k ur�it�mu stromu, tento strom vyberte zde.</p>

            <h5 class="optionhead">V�tev</h5>
            <p>Pokud chcete poslat tuto zpr�vu pouze u�ivatel�m p�ipojen�m k ur�it� v�tvi uvnit� vybran�ho stromu, tuto v�tev vyberte zde.</p>

        </td>
    </tr>

</table>
</body>
<?php echo "</html>"; ?>

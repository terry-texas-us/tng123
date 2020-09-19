<?php
include "../../helplib.php";
echo help_header("N�pov�da: V�tve");
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
                <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="trees_help.php" class="lightlink">&laquo; N�pov�da: Stromy</a> &nbsp;|&nbsp;
                <a href="eventtypes_help.php" class="lightlink">N�pov�da: Vlastn� typy ud�lost� &raquo;</a>
            </p>
            <h2 class="largeheader">N�pov�da: <small>V�tve</small></h2>
            <p class="smaller menu" style="clear: both;">
                <a href="#what" class="lightlink">Co to je?</a> &nbsp;|&nbsp;
                <a href="#search" class="lightlink">Hledat</a> &nbsp;|&nbsp;
                <a href="#add" class="lightlink">P�idat nebo upravit</a> &nbsp;|&nbsp;
                <a href="#delete" class="lightlink">Vymazat</a> &nbsp;|&nbsp;
                <a href="#label" class="lightlink">Ozna�it</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="what"><h4 class="subheadbold">Co je to v�tev?</h4></a>>
            <p><strong>V�tev</strong> je skupina osob ve spole�n�m strom�, kter� jsou ozna�eny spole�nou zna�kou. Tato zna�ka umo��uje programu TNG
                pomoc� u�ivatelsk�ch p��stupov�ch pr�v
                omezit p��stup k takto ozna�en�m osob�m. Jin�mi slovy, u�ivatel�, kte�� jsou p�ipojeni k ur�it� v�tvi, budou m�t sv� p��stupov� pr�va
                omezena
                na osoby a rodiny v t�to v�tvi. Osoba v datab�zi m��e pat�it do r�zn�ch v�tv�. U�ivatel� mohou b�t p�ipojeni nanejv��
                k jedn� v�tvi, ale toto omezen� lze obej�t vytvo�en�m tzv. pseudov�tve, jej� n�zev tvo�� textov� �et�zec, kter� m��e b�t sou�asn�
                obsa�en
                v n�zvu jin�ch v�tv�. Nap�. u�ivatel p�ipojen k v�tvi "zeman" m��e m�t pr�va na v�tve "zemanuvsyn" i "jihlavskyzeman", proto�e oba
                n�zvy
                obsahuj� slovo "zeman".</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="search"><h4 class="subheadbold">Hledat</h4></a>
            <p>Nalezen� existuj�c�ch v�tv� vyhled�n�m cel�ho nebo ��sti <strong>ID ��sla v�tve</strong> nebo <strong>Popisu</strong>. Pro z��en�
                va�eho hled�n� vyberte strom.
                V�sledkem hled�n� bez zadan�ch voleb a hodnot ve vyhled�vac�ch pol�ch bude seznam v�ech v�tv� ve va�� datab�zi.</p>

            <p>Vyhled�vac� krit�ria, kter� zad�te na t�to str�nce, budou uchov�na, dokud nekliknete na tla��tko <strong>Obnovit</strong>, kter� znovu
                obnov� v�echny v�choz� hodnoty.</p>

            <h5 class="optionhead">Akce</h5>
            <p>Tla��tko Akce vedle ka�d�ho v�sledku hled�n� v�m umo�n� upravit, odstranit nebo p�idat ozna�en� k t�to v�tvi. Chcete-li najednou
                odstranit v�ce v�tv�, za�krtn�te pol��ko ve sloupci
                <strong>Vybrat</strong> u ka�d� v�tve, kter� m� b�t odstran�na a pot� klikn�te na tla��tko "Vymazat ozna�en�" na za��tku seznamu. Pro
                za�krtnut� nebo vy�i�t�n� v�ech v�b�rov�ch pol��ek najednou
                m��ete pou��t tla��tka <strong>Vybrat v�e</strong> nebo <strong>Vy�istit v�e</strong>.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="add"><h4 class="subheadbold">P�idat novou / Upravit existuj�c� v�tve</h4></a>
            <p>Chcete-li p�idat novou v�tev, klikn�te na z�lo�ku <strong>P�idat nov�</strong> a pak vypl�te formul��.
                V�znam pol� je n�sleduj�c�:</p>

            <h5 class="optionhead">ID ��slo v�tve</h5>
            <p>Toto by m�l b�t kr�tk�, jednozna�n�, jednoslovn� identifik�tor v�tve. Mus� obsahovat pouze alfanumerick� znaky (��slice a p�smena).
                Nepou��vejte p�smena
                s diakritikou a mezery. Tento �daj se nikde nezobrazuje, tak�e m��e b�t zaps�n pouze mal�mi p�smeny v d�lce max. 20 znak�.</p>

            <h5 class="optionhead">Popis:</h5>
            <p>Toto m��e b�t del�� popis v�tve nebo �daj�, kter� v�tev obsahuje.</p>

            <h5 class="optionhead">Starting Individual</h5>
            <p>Enter or find the ID of the individual with whom your branch begins. All
                partial branches are defined by a starting individual and a number of ancestral or descendant generations from that individual. You
                can add additional names
                by repeating this process and picking a different "Starting Individual". When you save your branch, only the most recent Starting
                Individual will be remembered,
                but all labels added previously will not be affected.</p>

            <h5 class="optionhead">V�choz� osoba</h5>
            <p>Zapi�te nebo vyhledejte ID ��slo osoby, kterou va�e v�tev za��n�. V�echny
                d�l�� v�tve jsou definov�ny v�choz� osobou a po�tem generac� p�edk� nebo potomk� po��naje touto osobou. Dal�� jm�na m��ete p�idat
                pozd�ji zopakov�n�m tohoto procesu a volbou jin� "V�choz� osoby". Po ulo�en� v�tve bude zapamatov�na pouze posledn� v�choz� osoba,
                v�echny d��ve p�idan� zna�ky ale nebudou ovlivn�ny.</p>

            <h5 class="optionhead">Po�et generac�</h5>
            <p>Zvolte po�et generac� od v�choz� osoby sm�rem zp�t (p�edkov�) nebo dop�edu (potomci), kter� si p�ejete ozna�it. P�i
                ozna�ov�n� p�edk� m��ete tak� zvolit, kolik m� b�t ozna�eno generac� potomk� od ka�d�ho p�edka.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="delete"><h4 class="subheadbold">Vymaz�n� v�tve</h4></a>
            <p>Chcete-li odstranit v�tev, pou�ijte z�lo�ku <a href="#search">Hledat</a> k nalezen� v�tve, a pot� klikn�te na ikonku Vymazat vedle
                z�znamu t�to v�tve. Tento ��dek zm�n�
                barvu a pot� po odstran�n� polo�ky v�tev zmiz�. Chcete-li najednou odstranit v�ce v�tv�, za�krtn�te tla��tko ve sloupci Vybrat vedle
                ka�d� v�tve, kter� m� b�t
                odstran�na, a pot� klikn�te na tla��tko "Vymazat vybran�" na str�nce naho�e.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="label"><h4 class="subheadbold">Ozna�en� v�tv�</h4></a>
            <p>Chcete-li zna�ku v�tve p�ipojit k osob�m ve sv� datab�zi, klikn�te na tla��tko <strong>P�idat zna�ku</strong> ve spodn� ��sti str�nky
                Upravit v�tev,
                a pokra�ujte podle instrukc� v okn�, kter� se objev�. Po proveden� v�b�ru klikn�te na tla��tko "P�idat zna�ku" ve spodn� ��sti.
                Mo�nosti na t�to str�nce jsou n�sleduj�c�:</p>

            <h5 class="optionhead">Akce</h5>
            <p>Zvolte, zda chcete p�idat nov� zna�ky nebo vymazat existuj�c�. Pokud chcete vymazat existuj�c� zna�ky, mus�te tak� zvolit, zda m� tato
                akce vymazat zna�ky v�tve u v�ech �len�
                va�eho stromu nebo vymazat pouze zna�ky, kter� odpov�daj� vybran�m krit�ri�m.</p>

            <h5 class="optionhead">Existuj�c� zna�ku</h5>
            <p>Touto volbou ur��te, co d�lat, kdy� n�kter� osoba, kterou jste vybrali pro ozna�en�,
                ji� u sebe m� zaznamen�n p��znak jin� v�tve. Existuj�c� zna�ku m��ete nechat netknutou, m��ete ji p�epsat
                nebo se m��ete rozhodnout p�idat novou zna�ku. Pokud vyberete posledn� mo�nost,
                posti�en� osoby budou nyn� pat�it k v�ce v�tv�m.</p>

            <h5 class="optionhead">Zobrazit osoby s t�mto stromem/v�tv� (ozna�en�):</h5>
            <p>Kliknut�m na toto tla��tko zobraz�te v�echny osoby, kter� ji� maj� vybranou v�tev
                vybran�ho stromu. V tomto zobrazen� se kliknut�m na odkaz Zna�ka v�tve m��ete
                vr�t�t na p�edchoz� str�nku nebo kliknut�m na osobu m��ete �pravit jej� osobn� z�znam.</p>
        </td>
    </tr>

</table>
</body>
</html>

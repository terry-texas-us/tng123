<?php
include "../../helplib.php";
echo help_header("N�pov�da: Ud�losti �asov� osy");
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
                <a href="places_googlemap_help.php" class="lightlink">&laquo; N�pov�da: Google Maps</a> &nbsp; | &nbsp;
                <a href="notes2_help.php" class="lightlink">N�pov�da: Pozn�mky &raquo;</a>
            </p>
            <h2 class="largeheader">N�pov�da: <small>Ud�losti �asov� osy</small></h2>
            <p class="smaller menu">
                <a href="#search" class="lightlink">Hledat</a> &nbsp; | &nbsp;
                <a href="#add" class="lightlink">P�idat nebo Upravit</a> &nbsp; | &nbsp;
                <a href="#delete" class="lightlink">Vymazat</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="search"><p class="subheadbold">Hledat</p></a>
            <p>Nalezen� existuj�c�ch ud�lost� �asov� osy vyhled�n�m cel�ho nebo ��sti <strong>roku ud�losti</strong> nebo <strong>podrobnost�
                    ud�losti</strong>.
                V�sledkem hled�n� bez zadan�ch voleb a hodnot ve vyhled�vac�ch pol�ch bude seznam v�ech m�st ve va�� datab�zi.</p>

            <p>Vyhled�vac� krit�ria, kter� zad�te na t�to str�nce, budou uchov�na, dokud nekliknete na tla��tko <strong>Obnovit</strong>, kter� znovu
                obnov� v�echny v�choz� hodnoty.</p>

            <span class="optionhead">Akce</span>
            <p>Tla��tko Akce vedle ka�d�ho v�sledku hled�n� v�m umo�n� upravit, odstranit nebo otestovat tento v�sledek. Chcete-li najednou vymazat
                v�ce z�znam�, za�krtn�te pol��ko ve sloupci
                <strong>Vybrat</strong> u ka�d�ho z�znamu, kter� m� b�t vymaz�n a pot� klikn�te na tla��tko "Vymazat ozna�en�" na za��tku seznamu. Pro
                za�krtnut� nebo vy�i�t�n� v�ech v�b�rov�ch pol��ek najednou
                m��ete pou��t tla��tka <strong>Vybrat v�e</strong> nebo <strong>Vy�istit v�e</strong>.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="add"><p class="subheadbold">P�idat novou / Upravit existuj�c� ud�losti �asov� osy</p></a>
            <p>TNG umo��uje zobrazen� sch�matu �asov� osy pro porovn�n� rozsahu �ivota osob ve va�� datab�zi.
                Roz���it souvislosti t�chto sch�mat m��ete tak� vytvo�en�m ud�lost� �asov� osy. Pokud roky, kter� pokr�v�
                sch�ma �asov� osy, obsahuj� �daje spojen� s t�mito ud�lostmi, jsou ve sch�matu zobrazeny jako
                z�pat�. Tyto ud�losti lze vyu��t pouze v TNG, nelze je exportovat do souboru GEDCOM.</p>

            <p>Chcete-li p�idat novou ud�lost �asov� osy, klikn�te na z�lo�ku <strong>P�idat novou</strong> a pot� vypl�te formul��.
            <p>Chcete-li upravit existuj�c� ud�lost, pou�ijte
                z�lo�ku <a href="#search">Hledat</a> pro nalezen� ud�losti, a pot� klikn�te na ikonu Upravit vedle tohoto ��dku.</p>
            V�znam jednotliv�ch pol� p�i p�id�n� nebo �prav� ud�losti �asov� osy je n�sleduj�c�:</p>

            <span class="optionhead">Po��te�n� datum / Kone�n� datum</span>
          <p>Vyberte v�echny zn�m� slo�ky (den, m�s�c, rok) po��te�n�ho a kone�n�ho data ud�losti. Povinn� je pouze rok po��te�n�ho data.
            Zap�ete-li n�jakou slo�ku kone�n�ho data, pak je tak� zde povinn� rok.</p>

          <span class="optionhead">Titul ud�losti</span><br>
          <p>Zadejte velmi kr�tk� titul ud�losti. Nap�. <em>Potopen� Titanicu</em> nebo <em>1. sv�tov� v�lka</em>. Toto pole bylo zavedeno v TNG 9.0. Ud�losti
            �asov� osy p�idan� p�ed touto verz� nemaj� titul. V tomto p��pad� budou jako Titul ud�losti pou�ity Podrobnosti ud�losti.</p>

            <span class="optionhead">Podrobnosti ud�losti</span><br>
            <p>Zapi�te stru�n� popis ud�losti. M�l by obsahovat pouze n�kolik v�t.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="delete"><p class="subheadbold">Vymazat ud�losti �asov� osy</p></a>
            <p>Chcete-li odstranit ud�lost �asov� osy, pou�ijte z�lo�ku <a href="#search">Hledat</a> pro nalezen� ud�losti, a pot� klikn�te na ikonu
                Vymazat vedle tohoto z�znamu ud�losti. Tento ��dek zm�n�
                barvu a pot� po odstran�n� ud�losti zmiz�. Chcete-li najednou odstranit v�ce ud�lost�, za�krtn�te pol��ko ve sloupci Vybrat vedle
                ka�d� ud�losti, kterou
                chcete odstranit, a pot� klikn�te na tla��tko "Vymazat ozna�en�" na str�nce naho�e</p>

        </td>
    </tr>

</table>
</body>
</html>

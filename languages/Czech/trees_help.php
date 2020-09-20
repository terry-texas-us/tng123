<?php

include "../../helplib.php";
echo help_header("N�pov�da: Stromy");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="users_help.php" class="lightlink">&laquo; N�pov�da: U�ivatel�</a> &nbsp;|&nbsp;
                <a href="branches_help.php" class="lightlink">N�pov�da: V�tve &raquo;</a>
            </p>
            <h2 class="largeheader">N�pov�da: <small>Stromy</small></h2>
            <p class="smaller menu" style="clear: both;">
                <a href="#search" class="lightlink">Hledat</a> &nbsp;|&nbsp;
                <a href="#add" class="lightlink">P�idat nebo upravit</a> &nbsp;|&nbsp;
                <a href="#delete" class="lightlink">Vymazat</a> &nbsp;|&nbsp;
                <a href="#clear" class="lightlink">Vy�istit</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="search"><h4 class="subheadbold">Hledat</h4></a>
            <p>Nalezen� existuj�c�ch strom� vyhled�n�m cel�ho nebo ��sti <strong>ID ��sla stromu, n�zvu stromu, popisu</strong> nebo
                <strong>vlastn�ka</strong>.
                V�sledkem hled�n� bez zadan�ch voleb a hodnot ve vyhled�vac�ch pol�ch bude seznam v�ech strom� ve va�� datab�zi.</p>

            <p>Vyhled�vac� krit�ria, kter� zad�te na t�to str�nce, budou uchov�na, dokud nekliknete na tla��tko <strong>Obnovit</strong>, kter� znovu
                obnov� v�echny v�choz� hodnoty.</p>

            <h5 class="optionhead">Akce</h5>
            <p>Tla��tko Akce vedle ka�d�ho v�sledku hled�n� v�m umo�n� upravit, odstranit nebo p�idat ozna�en� k tomuto stromu.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="add"><h4 class="subheadbold">P�idat nov� / Upravit existuj�c� stromy</h4></a>
            <p><strong>Strom</strong> v TNG je z�sobn�k samostatn�ho souboru rodinn�ch �daj�. TNG umo��uje na va�ich str�nk�ch podporu v�ce strom�,
                ale proto�e
                jsou stromy samostatn�, nelze propojit osobu z jednoho stromu s osobou nebo rodinou z jin�ho stromu. Z tohoto d�vodu by m�ly b�t
                osoby, kter� jsou nebo by m�ly b�t navz�jem
                spojeny,
                udr�ov�ny ve stejn�m strom�.</p>

            <p><strong>POZN.: Strom mus�te p�idat p�ed t�m, ne� budete zad�vat nebo importovat data</strong> osob, rodin, pramen� nebo �lo�i�t�
                pramen�. Pokud jste aktualizovali z ni��� verze,
                nepodporovala stromy, budou va�e data spojena s v�choz�m stromem, kter� m� pr�zdn� ID ��slo stromu. Dal�� �daje tohoto stromu m��ete
                upravit,
                ale ID ��slo stromu z�stane pr�zdn� (program s t�mto dok�e pracovat).</p>

            <p>Chcete-li p�idat nov� strom, klikn�te na z�lo�ku <strong>P�idat nov�</strong> a pak vypl�te formul��.
                V�znam pol� je n�sleduj�c�:</p>

            <h5 class="optionhead">ID ��slo stromu</h5>
            <p>Toto by m�l b�t kr�tk�, jednozna�n�, jednoslovn� identifik�tor stromu. Mus� obsahovat pouze alfanumerick� znaky (��slice a p�smena).
                Nepou��vejte p�smena
                s diakritikou a mezery. Tento �daj se nikde nezobrazuje, s v�jimkou ��dku adresy ve va�em prohl�e�i, tak�e m��e b�t zaps�n pouze
                mal�mi p�smeny. Pozd�ji tento �daj nelze zm�nit.
                D�lka max. 20 znak�.</p>

            <h5 class="optionhead">N�zev stromu:</h5>
            <p>Kr�tk� n�zev nebo fr�ze, kter� se bude zobrazovat a identifikovat strom. Objev� se na v�ech m�stech v�b�ru stromu a podle tohoto n�zvu
                budou u�ivatel� strom zn�t.</p>

            <h5 class="optionhead">Popis:</h5>
            <p>Del�� popis tohoto stromu nebo dat, kter� obsahuje.</p>

            <h5 class="optionhead">Majitel:</h5>
            <p>Osoba nebo organizace, kter� vytvo�ila nebo shrom�dila �daje v tomto strom�, nebo osoba �i organizace odpov�dn� za spr�vu t�chto
                �daj�.</p>

            <h5 class="optionhead">Email:</h5>
            <p>Emailov� adresa majitele. N�vrhy t�kaj�c� se osob v tomto stromu budou pos�l�ny na tuto adresu, pokud existuje (jinak budou n�vrhy
                pos�l�ny na adresu uvedenou v Z�kladn�m nastaven�).</p>

            <h5 class="optionhead">Adresa/m�sto/kraj/PS�/zem�/telefon:</h5>
            <p>Kontaktn� �daje majitele.</p>

            <h5 class="optionhead">Informace o majiteli zachovat neve�ejn�</h5>
            <p>Za�krtnut�m tohoto pol��ka skryjete emailovou adresu a jin� kontaktn� �daje majitele tohoto stromu (pro n�v�t�vn�ky ve ve�ejn�
                oblasti).</p>

            <h5 class="optionhead">Nepovolit u�ivatel�m st�hnut� soubor� GEDCOM</h5>
            <p>Za�krtnut�m tohoto pol��ka zabr�n�te u�ivatel�m st�hnout z tohoto stromu soubory GEDCOM.</p>

            <h5 class="optionhead">Nepovolit u�ivatel�m tvorbu soubor� PDF</h5>
            <p>Za�krtnut�m tohoto pol��ka zabr�n�te u�ivatel�m vytvo�it z tohoto stromu soubory PDF.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="delete"><h4 class="subheadbold">Vymaz�n� strom�</h4></a>
            <p>Chcete-li odstranit strom, pou�ijte z�lo�ku <a href="#search">Hledat</a> k nalezen� stromu, a pot� klikn�te na ikonku Vymazat vedle
                z�znamu tohoto stromu. Tento ��dek zm�n�
                barvu a pot� po odstran�n� polo�ky strom zmiz�. <em>V�echna data spojen� s t�mto stromem (v�etn� osob, rodin,
                    pramen�, �lo�i�� pramen�, m�di� a v�tv�) budou tak� odstran�na</em>.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="clear"><h4 class="subheadbold">Vy�i�t�n� strom�</h4></a>
            <p>Chcete-li strom "vy�istit" (vymazat v�echny �daje, ale strom samotn� ponechat), pou�ijte z�lo�ku <a href="#search">Hledat</a> k
                nalezen� stromu, a pot� klikn�te na ikonku Vy�istit
                vedle z�znamu tohoto stromu.
                <em>V�echny �daje spojen� s t�mto stromem (v�etn� osob, rodin, pramen�, �lo�i�� pramen�, m�di� a v�tv�) budou odstran�ny</em>.</p>

        </td>
    </tr>

</table>
</body>
<?php echo "</html>"; ?>

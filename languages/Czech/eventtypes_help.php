<?php
include "../../helplib.php";
echo help_header("N�pov�da: Vlastn� typy ud�lost�");
?>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<body class="helpbody">
<a name="top"></a>
<table width="100%" cellpadding="10" cellspacing="2" class="tblback normal">
  <tr class="fieldnameback">
    <td class="tngshadow">
      <p style="float:right; text-align:right;" class="smaller menu">
        <a href="https://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp; | &nbsp;
        <a href="https://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
        <a href="branches_help.php" class="lightlink">&laquo; N�pov�da: V�tve</a> &nbsp; | &nbsp;
        <a href="reports_help.php" class="lightlink">N�pov�da: Reporty &raquo;</a>
      </p>
      <span class="largeheader">N�pov�da: Vlastn� typy ud�lost�</span>
      <p class="smaller menu">
        <a href="#search" class="lightlink">Hledat</a> &nbsp; | &nbsp;
        <a href="#add" class="lightlink">P�idat nebo upravit</a> &nbsp; | &nbsp;
        <a href="#accept" class="lightlink">P�ijmout nebo odm�tnout</a> &nbsp; | &nbsp;
        <a href="#delete" class="lightlink">Vymazat</a>
      </p>
    </td>
  </tr>
  <tr class="databack">
    <td class="tngshadow">

      <a name="search"><p class="subheadbold">Hledat</p></a>
      <p>Nalezen� existuj�c�ch vlastn�ch typ� ud�lost� vyhled�n�m cel�ho nebo ��sti <strong>Tagu, Typu/popisu (pro ud�losti EVEN)</strong> nebo <strong>Zobrazit</strong>.
        Pro z��en� va�eho hled�n� vyberte <strong>Spojeno s</strong> nebo zvolte jednu z dal��ch mo�nost�.
        V�sledkem hled�n� bez zadan�ch voleb a hodnot ve vyhled�vac�ch pol�ch bude seznam v�ech vlastn�ch typ� ud�lost� ve va�� datab�zi. Mo�nosti v�b�ru jsou n�sleduj�c�:</p>

      <p><span class="optionhead">Spojeno s</span><br>
        Pro omezen� v�b�ru zvolte z tohoto rozbalovac�ho seznamu vlastn� typy ud�lost� spojen� s osobami, rodinami, prameny nebo �lo�i�ti pramen�.</p>

      <p><span class="optionhead">P�ijmout/Odm�tnout/V�e</span><br>
        V�b�rem jedn� z t�chto voleb omez�te v�b�r vlastn�ch typ� ud�lost� na ty, kter� jsou <strong>p�ijaty</strong>, nebo na ty,
        kter� jsou <strong>odm�tnuty</strong>. Volba <strong>V�e</strong> neomez� v�sledek v�b�ru.</p>

      <p>Vyhled�vac� krit�ria, kter� zad�te na t�to str�nce, budou uchov�na, dokud nekliknete na tla��tko <strong>Obnovit</strong>, kter� znovu obnov� v�echny v�choz� hodnoty.</p>

      <p><span class="optionhead">Smazat/P�ijmout/Odm�tnout/Sbalit vybran�</span><br>
        Klikn�te na za�krt�vac� pol��ko vedle jednoho nebo v�ce typ� ud�lost�, a pot� pou�ijte tato tla��tka k proveden� akce na v�ech vybran�ch typech ud�lost� najednou.</p>

      <span class="optionhead">Akce</span>
      <p>Tla��tko Akce vedle ka�d�ho v�sledku hled�n� v�m umo�n� upravit nebo odstranit tento v�sledek. Chcete-li najednou odstranit v�ce z�znam�, za�krtn�te pol��ko ve sloupci
        <strong>Vybrat</strong> u ka�d�ho z�znamu, kter� m� b�t odstran�n a pot� klikn�te na tla��tko "Vymazat ozna�en�" na za��tku seznamu. Pro za�krtnut� nebo vy�i�t�n� v�ech v�b�rov�ch pol��ek najednou
        m��ete pou��t tla��tka <strong>Vybrat v�e</strong> nebo <strong>Vy�istit v�e</strong>.</p>

    </td>
  </tr>
  <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a name="add"><p class="subheadbold">P�idat nebo upravit vlastn� typy ud�lost�</p></a>

            <p>Nejobvyklej�� neboli "Standardn�" typy ud�lost�, jako jsou Narozen�, �mrt�, S�atek n�kolik dal��ch, jsou spravov�ny p��mo na str�nk�ch osoby, rodiny, pramenu nebo �lo�i�ti pramen�.
                V�echny ostatn� typy ud�lost� jsou spojeny s "vlastn�mi" typy ud�lost�
                a jsou spravov�ny v sekc�ch <strong>Dal�� ud�losti</strong> na str�nk�ch osoby, rodiny, pramenu nebo �lo�i�t� pramen�. P�ed z�pisem n�kter� z t�chto "dal��ch"
                ud�lost� mus�te m�t z�znam s n� spojen�ho vlastn�ho typu ud�losti. TNG automaticky nastav� vlastn� typy ud�lost� pro v�echny nestandardn� ud�losti, kter� obsahuje
                v� soubor GEDCOM, ale nastavit vlastn� typy ud�lost� m��ete tak� ru�n�.</p>

            <p>Chcete-li p�idat nov� vlastn� typ ud�losti, klikn�te na z�lo�ku <strong>P�idat nov�</strong> a pak vypl�te formul��. Chcete-li upravit existuj�c� vlastn� typ ud�losti, pou�ijte
                z�lo�ku <a href="#search">Hledat</a> pro vyhled�n� z�znamu a pot� klikn�te na ikonu Upravit vedle tohoto ��dku.
                V�znam pol� p�i p�id�n� nebo �prav� vlastn�ho typ ud�losti je n�sleduj�c�:</p>

            <span class="optionhead">Spojeno s</span>
            <p>Z tohoto rozbalovac�ho seznamu vyberte volbu, zda je tento typ ud�losti spojen s osobou, rodinou, pramenem nebo �lo�i�t�m pramen�.
                Jednotliv� vlastn� typ ud�losti m��e b�t spojen pouze z jednou z t�chto mo�nost�. Volba tohoto pole
                ur��, kter� mo�nosti se zobraz� v rozbalovac�m seznamu Tag.</p>

            <span class="optionhead">Vybrat tag nebo zadat</span>
            <p>Toto je 3 nebo 4 znakov� zkratka (v�echna velk� p�smena) nebo mnemotechnick� k�d.
                V�t�inu obvykl�ch nestandardn�ch ud�lost� obsahuje v�b�rov� pole Tag. Pokud zde po�adovan� tag nevid�te, zm��ete jej p��mo zadat do pole pod t�mto polem. Vyberete-li tag z tohoto seznamu
                A sou�asn� jej zap�ete do pole, tag, kter� zap�ete do pole, bude m�t p�ednost a tag vybran� ze seznamu bude odm�tnut.</p>

            <span class="optionhead">Type/popis</span>
            <p>Toto pole by m�lo odpov�dat hodnot� "TYPE" pro tento typ ud�losti z va�eho genealogick�ho programu. POZN.: Toto pole se zobraz� pouze, kdy� vyberete
                jako tag "EVEN". U jin�ch tag� bude toto pole ponech�no pr�zdn�.</p>

            <span class="optionhead">Zobrazit</span>
            <p>�daj z tohoto pole se zobraz� ve sloupci nalevo od �daje ud�losti p�i zobrazen� ve ve�ejn� oblasti. Pokud pou��v�te v�ce jazyk�,
                pod t�mto polem uvid�te sekci nazvanou "Dal�� jazyky". Kliknete-li na n�zev t�to sekce, zobraz� se
                zvl�tn� pole Zobrazit pro ka�d� podporovan� jazyk. Chcete-li, aby byl pro ka�d� jazyk zobrazen stejn� v�raz,
                vypl�te pole Zobrazit v��e a nechte pole Zobrazit pro ostatn� jazyky pr�zdn�.</p>

            <span class="optionhead">Po�ad� p�i zobrazen�</span>
            <p>Ud�losti, kter� jsou spojeny s daty, jsou �azeny chronologicky. Ud�losti bez dat jsou �azeny podle tohoto seznamu v po�ad�,
                ve kter�m se objev� v datab�zi. Po�ad� tohoto seznamu lze ovlivnit z�pisem v poli Po�ad� v zobrazen�.
                Ni��� ��slo zp�sob�, �e bude ud�lost �azena v��e.</p>

            <span class="optionhead">�daje ud�losti</span>
            <p>Chcete-li p�ijmout importovan� �daje, kter� odpov�daj� tomuto vlastn�mu typu ud�losti, vyberte <em>P�ijmout</em>. Chcete-li data, kter� odpov�daj� tomuto vlastn�mu typu ud�losti, nep�ijmout
                a zp�sobit, �e nebudou naimportov�na, vyberte <em>Odm�tnout</em>. Kdy� je ud�lost tohoto typu naimportov�na, nastaven�m t�to volby zp�t na Odm�tnout
                nebude tento vlastn� typ ud�losti zobrazov�n.</p>

            <span class="optionhead">Sbalit ud�lost</span>
            <p>Zabere-li �daj t�to ud�losti na str�nce osoby v�ce ne� jeden ��dek, v�echny dal�� ��dky budou ve v�choz�m stavu skryty.
                N�v�t�vn�ci mohou pomoc� kliknut� na mal� troj�heln�k vedle popisu ud�losti zobrazit v�echny �daje k t�to ud�losti.</p>

            <span class="optionhead">Ud�lost CJKSpd</span>
            <p>Pokud by tento typ ud�losti m�l podl�hat stejn�m pravidl�m ochrany osobn�ch �daj�, kter� upravuj� dal�� ud�losti CJKSpd, zvolte zde mo�nost "Ano".</p>

            <p><span class="optionhead">Povinn� pole:</span>Pro va�i ud�lost mus�te vybrat nebo zadat GEDCOM tag. Pokud zvol�te tag "EVEN" (obecn� vlastn� ud�lost),
                mus�te zadat tak� Type/popis. Pokud jako tag nezvol�te EVEN, mus�te nechat pole Type/popis pr�zdn�. Mus�te tak� zadat �et�zec Zobrazit.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a name="accept"><p class="subheadbold">P�ijmout vybran� / Odm�tnout vybran�</p></a>
            <p>Chcete-li najednou ozna�it vlastn� typy ud�lost� jako <strong>P�ijmout</strong> nebo <strong>Odm�tnout</strong>, za�krtn�te pol��ko Vybrat vedle ka�d�ho vlastn�ho typu ud�losti,
                kter� chcete zm�nit, a pot� klikn�te na tla��tko "P�ijmout vybran�" nebo "Odm�tnout vybran�" v horn� ��sti str�nky.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a name="delete"><p class="subheadbold">Vymazat vlastn� typy ud�lost�</p></a>
            <p>Chcete-li odstranit vlastn� typ ud�losti, pou�ijte z�lo�ku <a href="#search">Hledat</a> k nalezen� polo�ky, a pot� klikn�te na ikonku Vymazat vedle tohoto z�znamu. Tento ��dek zm�n�
                barvu a pot� po odstran�n� vlastn�ho typu ud�losti zmiz�. Chcete-li najednou odstranit v�ce z�znam�, za�krtn�te tla��tko ve sloupci Vybrat vedle ka�d�ho z�znamu, kter� m� b�t
                odstran�n, a pot� klikn�te na tla��tko "Vymazat vybran�" na str�nce naho�e.</p>

        </td>
    </tr>

</table>
</body>
</html>

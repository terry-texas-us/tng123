<?php
include "../../helplib.php";
echo help_header("N�pov�da: Obslu�n� programy");
?>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
</head>

<body class="helpbody">
<a name="top"></a>
<table width="100%" border="0" cellpadding="10" cellspacing="2" class="tblback normal">
  <tr class="fieldnameback">
    <td class="tngshadow">
      <p style="float:right; text-align:right" class="smaller menu">
        <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp; | &nbsp;
        <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
        <a href="languages_help.php" class="lightlink">&laquo; N�pov�da: Jazyky</a> &nbsp; | &nbsp;
        <a href="modmanager_help.php" class="lightlink">N�pov�da: Mana�er m�d� &raquo;</a>
      </p>
      <span class="largeheader">N�pov�da: Obslu�n� programy</span>
      <p class="smaller menu">
        <a href="#tables" class="lightlink">Z�loha - Obnova - Optimalizace</a> &nbsp; | &nbsp;
        <a href="#structure" class="lightlink">Z�loha struktury tabulek</a> &nbsp; | &nbsp;
        <a href="#ids" class="lightlink">P�e��slov�n� ID ��sel</a>
      </p>
    </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a name="tables"><p class="subheadbold">Z�lohov�n�, obnovov�n� &amp; optimalizace dat v tabulk�ch</p></a>
            <p>Tyto funkce pou��vejte pro zabezpe�en� va�ich dat a pro udr�en� rychlej��ho b�hu va�ich str�nek.</p>

            <p><em><strong>POZN�MKA:</strong> Je-li va�e datab�ze velmi velk�, m��ete pro z�lohu a obnovu datab�ze pou��t n�jak� nez�visl� n�stroj
                    (nap�. mysqldumper or phpMyAdmin). Alespo� jeden z nich byste m�li m�t k dispozici na ovl�dac�m panelu va�ich str�nek.
                    Pokud je va�e datab�ze p��li� velk� a pokud v� hostitel m� limit omezuj�c� �as k proveden� a dokon�en� skriptu, nemus� b�t operace
                    z�lohov�n� nebo obnovy �sp�n� dokon�ena. Co je to "velk� datab�ze" z�le�� na ka�d�m serveru a jeho dostupn�ch zdroj�ch, ale ur�it�m
                    m���tkem m��e b�t po�et 50 000 osob ve va�em strom�.</em></p>

            <span class="optionhead">Z�loha</span>
            <p>Chcete-li z�lohovat jednotlivou tabulku, klikn�te na ikonu Z�lohovat ve sloupci Akc� vedle tabulky, kterou chcete z�lohovat. Na prav� stran� ��dku se v�m
                zobraz� hl�en� o dokon�en� t�to akce. Aktualizov�n bude tak� obsah sloupce Posledn� z�loha, stejn� jako velikost v�sledn�ho souboru. Pokud operace neprob�hla �sp�n�,
                nem�te z�ejm� vytvo�enou slo�ku "Backups" (nen� nutn� toto pojmenov�n�; pod�vejte se do sv�ho Z�kladn�ho nastaven�) nebo nem� pot�ebn� p��stupov� pr�va.
                Vytvo�te tuto slo�ku ve sv� hlavn� TNG slo�ce a p�id�lte j� pr�va pro �ten�/z�pis/spu�t�n� pro ostatn�/skupinu/majitele (755 nebo 775, n�kter� syst�my vy�aduj� 777),
                pot� jd�te do Z�kladn�ho nastaven� a ujist�te se, �e se n�zev slo�ky zde p�esn� shoduje s aktu�ln�m n�zvem (velikost p�smen). Po vytvo�en�
                �vodn�ho souboru z�loh byste m�li pro zv��en� �rovn� bezpe�nosti nastavit p��stupov� pr�va zp�t na 771.
                <strong>POZN.</strong>: Pokud va�e ve�ker� �daje osob a rodin poch�zej� z importu souboru GEDCOM,
                nen� nutn� z�lohovat tabulky osob, d�t� a rodin, proto�e by tyto z�lohy mohly b�t dost velk� a mohly by zab�rat cenn� m�sto.
                Pokud by do�lo ke ztr�t� dat, m��ete pak tyto tabulky jednodu�e obnovit nov�m importem va�eho souboru GEDCOM.</p>

            <span class="optionhead">Obnova</span>
            <p>Chcete-li obnovit jednotlivou tabulku, klikn�te na ikonu Obnovit ve sloupci Akc� vedle tabulky, kterou chcete obnovit. Na prav� stran� ��dku se v�m
                zobraz� hl�en� o dokon�en� t�to akce. Nen�-li ikona Obnovit vedle n�zvu p��slu�n� tabulky vid�t, nen� pro tuto tabulku k dispozici ��dn� soubor z�lohy.
                <strong>POZN.</strong>: Pokud pokus o obnovu kon�� chybou, je mo�n�, �e se pokou��te obnovit tabulku, jej� aktu�ln� struktura sloupc�
                neodpov�d� struktu�e, kter� byla v dob�, kdy byla vytvo�ena posledn� z�loha. Z�ejm� jste z�lohu vytvo�ili p�ed aktualizac�, kter�
                zm�nila strukturu tabulky.</p>

            <span class="optionhead">Optimalizace</span>
            <p>Chcete-li optimalizovat jednotlivou tabulku, klikn�te na ikonu Optimalizovat ve sloupci Akc� vedle tabulky, kterou chcete optimalizovat. Na prav� stran� ��dku se v�m
                zobraz� hl�en� o dokon�en� t�to akce. Tabulka by m�la b�t optimalizov�na, pokud jste vymazali velkou ��st tabulky, od doby va�� posledn� optimalizace provedli n�kolik import�
                nebo jste provedli mnoho zm�n v pol�ch s prom�nlivou d�lkou. Optimalizac� bude z�sk�no zp�t nevyu�it� m�sto a datov� soubor bude defragmentov�n,
                v�sledkem b�v� obvykle zlep�en� v�kon. S optimalizac� velk�ch tabulek jsou spojena n�kter� nebezpe��, tak�e sv� tabulky p�ed optimalizac� rad�ji zaz�lohujte.</p>

            <span class="optionhead">Z�lohovat vybran� / Obnovit vybran� / Optimalizovat vybran� / Vymazat vybran�</span>
            <p>Chcete-li z�lohovat, obnovit nebo optimalizovat v�ce tabulek najednou, nebo vymazat z�lo�n� soubory, za�krtn�te pol��ko ve sloupci Vybrat vedle po�adovan�ch tabulek, a pot� vyberte
                z rozbalovac�ho seznamu "S vybran�mi" v horn� ��sti str�nky vyberte p��slu�nou akci. Pokud chcete pro n�kterou operaci vybrat v�echny tabulky, klikn�te na tla��tko "Vybrat v�e".
                Podobn� m��ete v�echny v�b�ry zru�it kliknut�m na tla��tko "Vy�istit v�e".</p>

            <span class="optionhead">Dal�� doporu�en�</span>
            <p>Po vytvo�en� z�lohy bude z�lo�n� soubor ulo�en ve slo�ce Backups (podle definice ve va�em Z�kladn�m nastaven�). Doporu�ujeme, abyste si tyto soubory zkop�rovali
                do sv�ho po��ta�e, proto�e katastrofick� ud�lost, kter� m��e postihnout va�e datab�zov� tabulky, m��e tak� postihnout z�lo�n� soubory ulo�en� na stejn�m po��ta�i. Pokud jsou va�e z�lo�n�
                soubory p��li� velk�, m��ete je pot� z va�ich webov�ch str�nek odstranit a nakop�rovat je zp�t a�, kdy� je nutn� obnova.</p>
            <p>Tak� v�m doporu�ujeme, abyste svou slo�ku pro ukl�d�n� z�lo�n�ch soubor� nazvali jinak ne� 'backups', proto�e by n�kte�� u�ivatel� TNG s ne�estn�mi �mysly mohli snadno zcizit va�e data.
                Tak� v�m rad�me, je-li to mo�n�, p�id�lit va�� slo�ce z�loh p��stupov� pr�va 771 (po vytvo�en� po��te�n�ch z�loh), proto�e to zabr�n� komukoli z�skat v�pis slo�ky.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="structure"><p class="subheadbold">Z�lohov�n� struktury tabulek</p></a>
            <p>Chcete-li z�lohovat strukturu va�ich TNG tabulek, klikn�te v t�to sekci na ikonu Z�lohovat. Pokud byla operace �sp�n�, str�nka bude znovu zobrazena s �ervenou zpr�vou naho�e.
                Vypln�n bude tak� obsah sloupce Posledn� z�loha, stejn� jako velikost v�sledn�ho souboru. Z�loha struktury va�ich tabulek v�m umo�n� sn�ze obnovit va�e data
                v p��pad� katastrofy na va�em serveru, zvl�t� pokud se aktu�ln� struktura va�ich tabulek li�� od struktury, kter� byla na po��tku.</p>
            <p>Pokud chcete obnovit strukturu va�ich TNG tabulek, klikn�te v t�to sekci na ikonu Obnovit. Pokud byla operace �sp�n�, str�nka bude znovu zobrazena s �ervenou zpr�vou naho�e.</p>
            <strong>VAROV�N�: Obnova struktury tabulek sma�e v�echna existuj�c� data!</strong></p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="ids"><p class="subheadbold">P�e��slov�n� ID ��sel</p></a>
            <p>Pomoc� t�to funkce m��ete ke v�em va�im osob�m, rodin�m, pramen�m a/nebo �lo�i�t�m pramen� p�i�adit nov�, po sob� jdouc� ID ��sla. V p��pad� t�to operace mus�te b�t re�imu �dr�by.
                Chcete-li spustit re�im �dr�by, jd�te do Admin/Nastaven�/Z�kladn� nastaven� a v sekci "Datab�ze" vyberte volbu Re�im �dr�by.</p>

            <p><strong>VAROV�N�: Proveden� t�to operace by mohlo m�t v�n� vedlej�� ��inky!</strong> Mohlo by p�eru�it propojen� nebo z�lo�ky, kter� ukazuj� na va�e str�nky, mohlo by p�eru�it indexov�n� vyhled�va�e,
                a mohlo by zp�sobit, �e va�e ID ��sla nebudou synchronizov�na s va��m p�vodn�m souborem GEDCOM (pokud n�jak� m�te). Doporu�ujeme, abyste p�ed zah�jen�m t�to operace
                zaz�lohovali sv� tabulky, zvl�t� v p��pad�, kdy v�sledek nedok�ete p�edem odhadnout.</p>

            <p>Volby na t�to str�nce jsou n�sleduj�c�:</p>

            <span class="optionhead">Strom</span>
            <p>Strom mus�te vybrat. Tuto operaci m��ete prov�st pouze v jednom strom�.</p>

            <span class="optionhead">Typ ID ��sla</span>
            <p>Volby jsou osoby, rodiny, prameny nebo �lo�i�t� pramen�. P�e��slov�n� jednoho typu, ani� byste provedli tot� s jin�mi typy, by nem�lo
                m�t ��dn� ne��douc� ��inky, kter� jsou obsahem v��e uveden�ho varov�n�.</p>

            <span class="optionhead">Minim�ln� po�et ��slic</span>
            <p>Toto ��slo ur�uje, jak budou va�e nov� ID ��sla dlouh�. Je-li ��slo dan� osoby men�� ne� minim�ln� po�et ��slic, zb�vaj�c� ��sla
                budou dopln�na nulami zleva. Nap�. pokud je v� minim�ln� po�et ��slic roven 5, va�e nejmen�� ��sla budou I00001, I00002, I00003, atd. Nechcete-li nuly zleva,
                nastavte toto ��slo na 1 (do po�tu nen� zahrnuta p�edpona ID ��sla).</p>

        </td>
    </tr>

</table>
</body>
</html>

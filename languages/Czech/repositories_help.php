<?php
include "../../helplib.php";
echo help_header("N�pov�da: �lo�i�t� pramen�");
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
                <a href="sources_help.php" class="lightlink">&laquo; N�pov�da: Prameny</a> &nbsp; | &nbsp;
                <a href="assoc_help.php" class="lightlink">N�pov�da: Spojen� &raquo;</a>
            </p>
            <span class="largeheader">N�pov�da: �lo�i�t� pramen�</span>
      <p class="smaller menu">
        <a href="#search" class="lightlink">Hledat</a> &nbsp; | &nbsp;
          <a href="#add" class="lightlink">P�idat nov�</a> &nbsp; | &nbsp;
          <a href="#edit" class="lightlink">Upravit existuj�c�</a> &nbsp; | &nbsp;
          <a href="#delete" class="lightlink">Vymazat</a> &nbsp; | &nbsp;
          <a href="#merge" class="lightlink">Slou�it</a>
      </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="search"><p class="subheadbold">Hledat</p></a>
            <p>Nalezen� existuj�c�ch �lo�i�� pramen� vyhled�n�m cel�ho nebo ��sti <strong>ID ��sla �lo�i�t�</strong> nebo <strong>n�zvu �lo�i�t�
                    pramen�</strong>.
                Pro dal�� z��en� va�eho hled�n� vyberte strom nebo za�krtn�te "Pouze p�esn� shoda".
                V�sledkem hled�n� bez zadan�ch voleb a hodnot ve vyhled�vac�ch pol�ch bude seznam v�ech osob ve va�� datab�zi.</p>

            <p>Vyhled�vac� krit�ria, kter� zad�te na t�to str�nce, budou uchov�na, dokud nekliknete na tla��tko <strong>Obnovit</strong>, kter� znovu
                obnov� v�echny v�choz� hodnoty.</p>

            <span class="optionhead">Akce</span>
            <p>Tla��tko Akce vedle ka�d�ho v�sledku hled�n� v�m umo�n� upravit, vymazat nebo otestovat v�sledek. Chcete-li najednou vymazat v�ce
                z�znam�, za�krtn�te pol��ko ve sloupci
                <strong>Vybrat</strong> u ka�d�ho z�znamu, kter� m� b�t vymaz�n, a pot� klikn�te na tla��tko "Vymazat ozna�en�" na za��tku seznamu.
                Pro za�krtnut� nebo vy�i�t�n� v�ech v�b�rov�ch pol��ek najednou
                m��ete pou��t tla��tka <strong>Vybrat v�e</strong> nebo <strong>Vy�istit v�e</strong>.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="add"><p class="subheadbold">P�idat nov� �lo�i�t� pramen�</p></a>
            <p><strong>�lo�i�t� pramen�</strong> je arch�v, sborn�k �i kolekce pramen�, fyzick� �i jin�.</p>

            <p>Chcete-li p�idat nov� �lo�i�t� pramen�, klikn�te na z�lo�ku <strong>P�idat nov�</strong> a pot� vypl�te formul��. N�kter� informace
                (pozn�mky a
                dal�� ud�losti) m��ete p�idat po ulo�en� a zamknut� z�znamu. V�znam jednotliv�ch pol� je n�sleduj�c�:</p>

            <span class="optionhead">Strom</span>
            <p>Pokud m�te pouze jeden strom, vybr�n bude v�dy tento strom. Jinak, pros�m, pro nov� �lo�i�t� pramen� vyberte po�adovan� strom.</p>

            <span class="optionhead">ID ��slo �lo�i�t�</span>
            <p>ID ��slo �lo�i�t� mus� b�t jednozna�n� uvnit� vybran�ho stromu a m�lo by se skl�dat z velk�ch p�smen <strong>REPO</strong> nebo
                <strong>R</strong> n�sledovan�ho ��slem (nejv�ce 22 znak� celkem).
                P�i prvn�m zobrazen� str�nky a kdykoli je vybr�n jin� strom, bude dopln�no voln� a jednozna�n� ��slo, ale pokud chcete, m��ete vlo�it sv� vlastn� ID ��slo.
                Chcete-li zkontrolovat, zda je va�e ID ��slo jednozna�n�, klikn�te na tla��tko <strong>Zkontrolovat</strong>. Objev� se zpr�va, kter� v�m sd�l�, zda je ji� ID ��slo pou�ito nebo ne.
                Chcete-li vygenerovat dal�� jednozna�n� ��slo, klikn�te na <strong>Vygenerovat</strong>. Bude zji�t�no nejvy��� ��slo ve va�� datab�zi a p�id�na 1.
              Chcete-li zajistit, �e zobrazen� ID ��slo nen� n�rokov�no jin�m u�ivatelem, zat�mco vy zapisujete data, klikn�te na tla��tko <strong>Zamknout</strong>.</p>

          <p><strong>POZN.</strong>: Pou��v�te-li tento program spolu s genealogick�m programem pracuj�c�m na platform�ch PC nebo Mac, kter� u nov�ch �lo�i�� pramen� vytv��� tak� ID ��sla,
            D�RAZN� DOPORU�UJEME v�echna tato ��sla v�dy mezi t�mito programy synchronizovat. V�sledkem zanedb�n� t�to �innosti mohou b�t kolize a nepou�itelnost
            odkaz� na va�e m�dia. Pokud v� prim�rn� program vytv��� ID ��sla, kter� neodpov�daj� tradi�n�m standard�m (nap�.
            <strong>R</strong> je na konci a ne na za��tku), m��ete konvence, kter� TNG pou��v�, zm�nit v Z�kladn�m nastaven�.</p>

          <span class="optionhead">N�zev</span>
          <p>Kr�tk� n�zev �lo�i�t�.</p>

            <span class="optionhead">Adresa 1, Adresa 2, M�sto, Kraj/provincie, PS�, Zem�</span><br>
            <p>Um�st�n� �lo�i�t� (p�i vyu�it� t�chto pol� jsou v�echny ��sti voliteln�).</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="edit"><p class="subheadbold">Upravit existuj�c� �lo�i�t� pramen�</p></a>
            <p>Chcete-li upravit existuj�c� �lo�i�t� pramen�, pou�ijte z�lo�ku <a href="#search">Hledat</a> pro nalezen� �lo�i�t� pramen�, a pot�
                klikn�te na ikonu Upravit vedle �lo�i�t�.</p>

            <span class="optionhead">Pozn�mky</span>
            <p>Pozn�mky lze p�ipojit k ud�losti nebo �lo�i�ti pramen� obecn� kliknut�m na ikonu Pozn�mky v horn� ��sti str�nky
                nebo vedle ka�d� ud�losti pod "Dal�� ud�losti". Pokud pro ud�lost ji� existuj� pozn�mky, na ikon� Pozn�mky se v horn�m prav�m rohu
                zobraz� zelen� te�ka.
                V�ce informac� o pozn�mk�ch najdete v odkazu <a href="notes_help.php">N�pov�da</a> v oblasti Pozn�mky.</p>

            <span class="optionhead">Dal�� ud�losti</span>
            <p>Chcete-li p�idat nebo spravovat dal�� ud�losti, klikn�te na tla��tko "P�idat nov�" vedle <strong>Dal��ch ud�lost�</strong>. Viz odkaz
                <a href="events_help.php">N�pov�da</a> v tomto okn� pro v�ce
                informac� o p�id�n� nov�ch ud�lost�. Po p�id�n� ud�losti se v tabulce pod tla��tkem "P�idat nov�" zobraz� kr�tk� shrnut�. Ak�n�
                tla��tka pro
                ka�dou ud�lost v�m umo�n� upravit nebo vymazat ud�lost, nebo p�idat pozn�mky. Po�ad�, ve kter�m jsou ud�losti zobrazeny, z�vis� na datu (pokud je pou�ito),
                a po�ad� zapsan�m u typu ud�losti (nen�-li p�ipojeno datum). Toto po�ad� lze zm�nit p�i �prav� typ� ud�lost�.

            <p><strong>Pozn�mka</strong>: Pozn�mky a zm�ny "Dal��ch" ud�lost� se ukl�daj� automaticky. Jin� zm�ny (nap�. standardn� ud�losti)
                lze ulo�it kliknut�m na tla��tko Ulo�it na konci str�nky, nebo kliknut�m na ikonu Ulo�it na str�nce naho�e. Strom a
                ID ��slo �lo�i�t� nelze zm�nit.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="delete"><p class="subheadbold">Vymazat �lo�i�t� pramen�</p></a>
            <p>Chcete-li odstranit �lo�i�t� pramen�, pou�ijte z�lo�ku <a href="#search">Hledat</a> pro nalezen� �lo�i�t� pramen�, a pot� klikn�te na
                ikonu Vymazat vedle tohoto �lo�i�t�. Tento ��dek zm�n�
                barvu a pot� po odstran�n� �lo�i�t� zmiz�. Chcete-li najednou odstranit v�ce �lo�i�� pramen�, za�krtn�te pol��ko ve sloupci Vybrat
                vedle ka�d�ho �lo�i�t�, kter�
                chcete odstranit, a pot� klikn�te na tla��tko "Vymazat ozna�en�" na str�nce naho�e</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>

            <p>Kliknut�m na tuto z�lo�ku lze p�ezkoumat a slou�it �lo�i�t� pramen�, kter� jsou lehce odli�n�, ale odkazuj� na stejn� materi�l.
                Mus�te rozhodnout, zda jsou tyto z�znamy toto�n� nebo ne.</p>

            <span class="optionhead">Naj�t shodu</span>
            <p>Vyberte nejprve strom. Nelze slu�ovat �lo�i�t� pramen� z r�zn�ch strom�, vybr�n mus� b�t pouze jeden strom. Potom m�te mo�nost vybrat �lo�i�t� pramen� jako
                v�choz� bod va�eho hled�n� (ID ��slo �lo�i�t� 1) nebo nechat, aby prvn� shodu osob za v�s nalezl TNG. Chcete-li, aby TNG nalezl v�echny zm�ny, nechte pole ID ��slo �lo�i�t� 1 pr�zdn�</p>

            <p>Pokud jste vybrali �lo�i�t� pramen� jako ID ��slo �lo�i�t� 1, m��ete tak� ru�n� vybrat ID ��slo �lo�i�t� 2. Chcete-li, aby duplicity �lo�i�t� pramen� 1 nalezl TNG, nechte pole ID ��slo �lo�i�t� 2 pr�zdn�.</p>

            <span class="optionhead">Jin� mo�nosti</span>
          <p><em>Slou�it pozn�mky</em> znamen�, �e pozn�mky z �lo�i�t� pramen� 2 budou p�id�ny k pozn�mk�m
            �lo�i�t� pramen� 1 u v�ech slu�ovan�ch pol�. Nen�-li tato volba vybr�na a pole �lo�i�t� pramen� 2 je za�krtnuto, pozn�mky �lo�i�t� pramen� 2 k tomuto poli budou p�eps�ny
            z�znamy z odpov�daj�c�ho pole �lo�i�t� pramen� 1.</p>

          <p><em>Slou�it m�dia</em> znamen�, �e m�dia z �lo�i�t� pramen� 2 budou zachov�na a p�id�na k ji� existuj�c�m
            u �lo�i�t� pramen� 1, pokud budou tyto dv� �lo�i�t� pramen� slou�eny. Nen�-li tato volba vybr�na, v�echny odkazy na m�dia �lo�i�t� pramen� 2 budou po slou�en� odstran�ny.</p>

          <p><span class="optionhead">Varov�n�!</span> Pokud prob�hlo slou�en�, nelze jej vz�t zp�t! <em>P�ed zah�jen�m operace slu�ov�n� proto v�dy zaz�lohujte sv� datab�zov� tabulky</em>
            pro p��pad, �e byste dv� �lo�i�t� pramen� slou�ili omylem.</p>

          <span class="optionhead">Dal�� shoda</span><br>
          <p>Najde dal�� mo�n� porovn�n�, kter� nezahrne �lo�i�t� pramen� 1. TNG postoup� seznamem mo�n�ch �lo�i�� pramen� v t��d�n� podle ID ��sla �lo�i�t� v textov�m form�tu.
            Znamen� to, �e "10" bude po "1", ale p�ed "2".</p>

          <span class="optionhead">Dal�� duplicita</span><br>
          <p>Najde dal�� mo�nou duplicitu k �lo�i�t� pramen� 1. Pokud v�sledkem nen� z�znam, kter� byl zobrazen u �lo�i�t� pramen� 2, znamen� to, �e duplicita nebyla nalezena.</p>

          <span class="optionhead">Porovnat/Obnovit</span><br>
          <p>Porovn�n� �lo�i�t� pramen� 1 a �lo�i�t� pramen� 2. Je-li toto porovn�n� ji� zobrazeno, kliknut� na toto tla��tko zp�sob� obnoven� str�nky.</p>

          <span class="optionhead">Prohodit</span><br>
          <p>�lo�i�t� pramen� 1 se stane �lo�i�t�m pramen� 2 a naopak.</p>

          <span class="optionhead">Slou�it</span><br>
          <p>�lo�i�t� pramen� 2 bude slou�eno s �lo�i�t�m pramen� 1. ID ��slo �lo�i�t� 1 bude zachov�no, stejn� jako ostatn� �daje �lo�i�t� pramen� 1, pokud nejsou za�krtnuta odpov�daj�c� pol��ka
            u �lo�i�t� pramen� 2. Nap�. pokud je u �lo�i�t� pramen� 2 za�krtnuto pol��ko vedle autora, bude b�hem slou�en� �daj z tohoto pole zkop�rov�n ze z�znamu �lo�i�t� pramen� 2 do z�znamu �lo�i�t� pramen� 1.
            Odpov�daj�c� �daj �lo�i�t� pramen� 1 bude smaz�n. Pol��ka u �lo�i�t� pramen� 2 jsou automaticky za�krtnuta, pokud u �lo�i�t� pramen� 1 nejsou odpov�daj�c� �daje. Nen�-li
            pole zobrazeno ani u jednoho �lo�i�t� pramen�, pak v tomto poli neexistuje ��dn� �daj.</p>

          <span class="optionhead">Upravit</span><br>
          <p>�prava z�znamu �lo�i�t� pramen� v nov�m okn�. Po proveden� zm�n mus�te kliknout na Porovnat/Obnovit, aby se zm�ny projevily na obrazovce Slou�en�.</p>

        </td>
    </tr>

</table>
</body>
</html>

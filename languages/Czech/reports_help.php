<?php
include "../../helplib.php";
echo help_header("N�pov�da: Reporty");
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
        <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp; | &nbsp;
        <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
        <a href="eventtypes_help.php" class="lightlink">&laquo; N�pov�da: Vlastn� typy ud�lost�</a> &nbsp; | &nbsp;
        <a href="dna_help.php" class="lightlink">N�pov�da: Testy DNA &raquo;</a>
      </p>
      <span class="largeheader">N�pov�da: Reporty</span>
      <p class="smaller menu">
        <a href="#search" class="lightlink">Hledat</a> &nbsp; | &nbsp;
        <a href="#add" class="lightlink">P�idat nebo upravit</a> &nbsp; | &nbsp;
        <a href="#delete" class="lightlink">Vymazat</a> &nbsp; | &nbsp;
      </p>
    </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a name="search"><p class="subheadbold">Hledat</p></a>

            <p>Nalezen� existuj�c�ch report� vyhled�n�m cel�ho nebo ��sti <strong>n�zvu reportu</strong> nebo <strong>popisu</strong>.
                V�sledkem hled�n� bez zadan�ch voleb a hodnot ve vyhled�vac�ch pol�ch bude seznam v�ech report� ve va�� datab�zi.</p>

            <p>Vyhled�vac� krit�ria, kter� zad�te na t�to str�nce, budou uchov�na, dokud nekliknete na tla��tko <strong>Obnovit</strong>, kter� znovu obnov� v�echny v�choz� hodnoty.</p>

            <span class="optionhead">Akce</span>
            <p>Tla��tko Akce vedle ka�d�ho v�sledku hled�n� v�m umo�n� upravit, odstranit nebo otestovat tento v�sledek. Chcete-li najednou vymazat v�ce z�znam�, za�krtn�te pol��ko ve sloupci
                <strong>Vybrat</strong> u ka�d�ho z�znamu, kter� m� b�t vymaz�n a pot� klikn�te na tla��tko "Vymazat ozna�en�" na za��tku seznamu. Pro za�krtnut� nebo vy�i�t�n� v�ech v�b�rov�ch pol��ek najednou
                m��ete pou��t tla��tka <strong>Vybrat v�e</strong> nebo <strong>Vy�istit v�e</strong>.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="add"><p class="subheadbold">P�id�n� nebo �prava reportu</p></a>

            <p>Reportem se v TNG rozum� u�ivatelsk� seznam osob z va�� datab�ze. Vy rozhodnete, kter� pole maj� b�t zobrazena, kter� osoby maj� b�t do reportu vlo�eny a jak maj� b�t se�azeny.
                M��ete pou��t rozhran� pro tvorbu report� nebo m��ete m�sto toho pou��t sv� vlastn� p��kazy SQL.</p>

            <p>Chcete-li p�idat nov� report, klikn�te na z�lo�ku <strong>P�idat nov�</strong> a pot� vypl�te formul��.
            <p>Chcete-li upravit existuj�c� report, pou�ijte
                z�lo�ku <a href="#search">Hledat</a> pro nalezen� reportu, a pot� klikn�te na ikonu Upravit vedle tohoto ��dku.</p>
            V�znam jednotliv�ch pol� p�i p�id�n� nebo �prav� reportu je n�sleduj�c�:</p>

            <span class="optionhead">N�zev reportu</span>
            <p>Sv�mu reportu mus�te d�t n�zev. P�i zobrazen� reportu se objev� jako jeho titul.</p>

            <span class="optionhead">Popis</span>
            <p>Sv�j report stru�n� popi�te. Tento popis se objev� p�i zobrazen� reportu pod titulem. Popis by m�l stru�n� vysv�tlit, co report zobrazuje a p�i
                pou�it� jak�ch krit�ri�.</p>

            <span class="optionhead">Po�ad�/Priorita</span>
            <p>Reporty budou t��d�ny alfabeticky podle n�zvu, pokud ka�d�mu nep�id�l�te po�ad� nebo prioritu. Nejd��ve se �ad� ni��� ��sla. Pr�zdn� po�ad� se dostane p�ed ��slo.</p>

            <span class="optionhead">Aktivn�</span>
            <p>V� nov� report nebude na str�nk�ch n�v�t�vn�k� viditeln�, dokud jej neozna��te zde jako aktivn�. Je dobr� p�ed aktivac� nov� report ulo�it a otestovat, zda pracuje tak, jak chcete.</p>

            <span class="optionhead">Zvolte pole pro zobrazen�</span>
            <p>Zkop�rov�n�m z lev� ��sti do prav� ozna�te, kter� pole chcete ve sv�m reportu zobrazit. Prov�st to m��ete
                v�b�rem pole a kliknut�m na tla��tko <em>P�idat >></em> nebo jednodu�e dvojklikem na n�zev pole (pouze IE). </p>

            <p>Ze seznamu pol� pro zobrazen� m��ete pole odstranit jeho v�b�rem
                v prav� ��sti a kliknut�m na tla��tko <em><< Odstranit</em> nebo jednodu�e dvojklikem na n�zev pole (pouze IE). </p>

            <p>Pole v seznamu zobrazen� naho�e jsou zobrazena v reportu nalevo. Zm�nit po�ad� zobrazovan�ch pol�
                m��ete v�b�rem pole v prav� ��sti a kliknut�m na tla��tka <em>Posunout nahoru</em> a <em>Posunout dol�</em> m��ete pole posunout nahoru nebo dol�.</p>

            <span class="optionhead">Vyberte krit�ria</span>
            <p>Volbou krit�ri� ozna�te osoby, kter� chcete vlo�it do sv�ho reportu. Osoby, kter� krit�ri�m neodpov�daj�, v reportu nebudou obsa�eny. P��kazy pro krit�ria jsou
                dob�e zformulov�ny, kdy� obsahuj� n�zev pole a podm�nku. Nap�. "P��jmen� = 'Nov�k' " nebo "M�sto narozen� obsahuje 'Olomouc' ". V�ce krit�ri� mus� b�t spojeno p��kazy A nebo
                NE. Po�ad� je indikov�no pomoc� z�vorek.</p>

            <p>P��kaz za�n�te v�b�rem n�zvu pole z horn�ho lev�ho r�mce a p�idejte jej do prav�ho r�mce. Prov�st to m��ete
              v�b�rem pole a kliknut�m na sousedn� tla��tko <em>P�idat >></em> nebo jednodu�e dvojklikem na n�zev pole (pouze IE).</p>

          <p><strong>POZN.</strong>: V�echna datov� pole mimo Datum posledn� aktualizace se chovaj� jako �et�zce a ne jako
            skute�n� data POKUD NEJSOU ozna�ena jako 'True'. Porovn�n� dat, kter� pou��vaj� textov� nebo �et�zcov� pole, se nejl�pe provede porovn�n�m komponent data,
            jako je pouze rok nebo pouze den. Chcete-li t�mto zp�sobem izolovat komponentu data, vyberte nejd��ve <em>M�s�c pouze</em>,
            <em>Den pouze</em> nebo <em>Rok pouze</em>, a pak vyberte pole data, ze kter�ho tato komponenta poch�z�.</p>

          <p>P�i pr�ci se skute�n�mi datov�mi poli (jako Datum posledn� aktualizace) m��ete porovnat pole p��mo s jin�m skute�n�m datem
            nebo skute�n�mi datov�mi poli. P�eddefinovan� skute�n� datum, kter� m��ete pou��t jako oper�tor, je 'Dnes'. P�i porovn�v�n� dvou skute�n�ch dat m��ete tak� pou��t
            oper�tor 'P�ev�st na dny'. Nap�. pro nalezen� v�ech z�znam�, u kter�ch je Datum posledn� aktualizace men�� ne� 30 dn�,
            m��ete zvolit toto krit�rium:<br><br>

            <i>P�ev�st na dny<br>
              Dnes (true)<br>
              -<br>
              P�ev�st na dny<br>
              Datum posledn� aktualizace<br>
              <=<br>
              30</i></p>

          <p>Po v�b�ru n�zvu pole zvolte d�le ze seznamu <em>Oper�tory &amp; Speci�ln� hodnoty</em> porovn�vac� oper�tor. Jsou to "=, !=, < > <=, >=, obsahuje, za��n� na, kon�� na". Oper�tor
            zkop�rujte do prav� ��sti jeho v�b�rem a kliknut�m na sousedn� tla��tko <em>P�idat >></em> nebo jednodu�e dvojklikem na n�zev oper�tora (pouze IE).</p>

          <p>P��kaz zakon�ete v�b�rem pole nebo hodnoty pro porovn�n� s va��m p�vodn�m polem. M��ete tak� zvolit n�kterou ze speci�ln�ch hodnot: <em>Aktu�ln� m�s�c, aktu�ln� rok</em> nebo
            <em>aktu�ln� den</em>. Chcete-li vybrat hodnotu konstantn�ho �et�zce, zadejte do pole <em>Konstantn� �et�zec</em> hodnotu �et�zce bez uvozovek a klikn�te na sousedn� tla��tko <em>P�idat >></em>.
            Chcete-li p�idat pr�zdn� �et�zec, nechte p�ed kliknut�m na toto tla��tko pole pr�zdn�. Pokud chcete zvolit hodnotu ��seln� konstanty, zadejte do pole <em>��seln� konstanta</em> ��slo a klikn�te na sousedn�
            tla��tko <em>P�idat >></em>.</p>

          <p>Odstranit jakoukoli polo�ku z prav� ��sti m��ete jej�m v�b�rem a kliknut�m na tla��tko <em><< Odstranit</em> nebo jednodu�e dvojklikem na polo�ku (pouze IE).
            Chcete-li zm�nit po�ad� polo�ek v seznamu, vyberte polo�ku a p�esu�te ji nahoru nebo dol� kliknut�m na tla��tka <em>Posunout nahoru</em> nebo <em>Posunout dol�</em>.</p>

          <span class="optionhead">Vybrat t��d�n�</span>
          <p>V�b�rem jednoho nebo v�ce pol� ur��te, jak maj� b�t odpov�daj�c� z�znamy t��d�ny.
            Pokud nelze ur�it po�ad� z�znam� podle prvn�ho pole v seznamu, bude pou�ito druh� pole ze seznamu, a tak d�le. Nen�-li ur�eno ��dn� t��d�n�, odpov�daj�c�
            z�znamy budou zobrazeny v po�ad�, v jak�m byly p�id�ny do datab�ze.
            Pole, podle kter�ch m� b�t t��d�no, vyberte zkop�rov�n�m z lev� ��sti do prav�. Prov�st to m��ete v�b�rem pole a kliknut�m na tla��tko <em>P�idat >></em> nebo jednodu�e dvojklikem na n�zev pole (pouze IE).

          <p>V�echna pole se obvykle t��d� ve vzestupn�m po�ad� (nap�. A-Z nebo 0-9). Chcete-li pole t��dit v sestupn�m po�ad�, pou�ijte pseudopole 'Sestupn� (P�edchoz�)'.
            V�raz 'P�edchoz�' v z�vorce znamen�, �e tento v�raz mus� <i>n�sledovat</i> za polem, kter� upravuje. Jin�mi slovy,
            pokud chcete t��dit podle P��jmen�, zvolte va�e t��d�ni takto:<br><br>

            <i>P��jmen�<br>
              Sestupn� (P�edchoz�)</i></p>

          <span class="optionhead">R�zn�</span>
          <p>Odstranit jakoukoli polo�ku z prav� ��sti m��ete jej�m v�b�rem a kliknut�m na tla��tko <em><< Odstranit</em> nebo jednodu�e dvojklikem na polo�ku (pouze IE).
                Chcete-li zm�nit po�ad� polo�ek v seznamu, vyberte polo�ku a p�esu�te ji nahoru nebo dol� kliknut�m na tla��tka <em>Posunout nahoru</em> nebo <em>Posunout dol�</em>.</p>

            <span class="optionhead">Vlastn� SQL dotaz</span>
            <p>Pokud zn�te SQL (structured query language) a zn�te strukturu tabulek TNG, m��ete nechat oblasti Zobrazit, Krit�ria a T��d�n� pr�zdn� a m�sto toho zapsat do r�me�ku na konci obrazovky p��mo
                SQL p��kaz SELECT.</p>

            <span class="optionhead">Ulo�it report vs. Ulo�it a ukon�it</span>
            <p>Chcete-li report ulo�it, kliknite na "Ulo�it report" a z�stanete na stejn� str�nce a m��ete pokra�ovat v editaci. Kliknut�m na "Ulo�it a ukon�it" report ulo��te a vr�t�te se na menu Reporty.</p>

            <p>N�kolik vzorov�ch report� m��ete vid�t na <a href="http://lythgoes.net/genealogy/demo.php" target="_blank">http://lythgoes.net/genealogy/demo.php</a>. Zvolte zde Administrative Demo a vyhledejte sekci Reporty.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="delete"><p class="subheadbold">Vymaz�n� reportu</p></a>
            <p>Chcete-li odstranit report, pou�ijte z�lo�ku <a href="#search">Hledat</a> k nalezen� reportu, a pot� klikn�te na ikonku Vymazat vedle tohoto z�znamu. Tento ��dek zm�n�
                barvu a pot� po odstran�n� reportu zmiz�.</p>

        </td>
    </tr>

</table>
</body>
</html>

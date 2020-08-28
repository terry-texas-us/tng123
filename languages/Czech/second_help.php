<?php
include "../../helplib.php";
echo help_header("N�pov�da: Druhotn� procesy");
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
        <a href="https://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp; | &nbsp;
        <a href="https://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
        <a href="data_help.php" class="lightlink">&laquo; N�pov�da: Import / Export</a> &nbsp; | &nbsp;
        <a href="setup_help.php" class="lightlink">N�pov�da: Nastaven� &raquo;</a>
      </p>
      <span class="largeheader">N�pov�da: Druhotn� procesy</span>
      <p class="smaller menu">
        <a href="#what" class="lightlink">Co to je?</a>
      </p>
    </td>
  </tr>
  <tr class="databack">
        <td class="tngshadow">

            <a name="what"><p class="subheadbold">Co jsou to druhotn� procesy?</p></a>
            <p>Druhotn� procesy jsou operace, kter� lze prov�st na va�ich datech bezprost�edn� po ukon�en� importu. Chcete-li n�jakou operaci prov�st,
                mus�te nejd��ve vybrat, zda m� b�t provedena ve "V�ech stromech" nebo
                pouze v jednom konkr�tn�m. Pokud pouze v jednom, vyberte tento strom zde. Operace, kter� m��ete prov�st, jsou n�sleduj�c�:</p>

            <span class="optionhead">Vysledovat linie</span>
            <p>Po naimportov�n� va�ich dat kliknut�m sem projdete vybran� strom a ozna��te v�echny osoby s d�tmi, co� n�v�t�vn�kovi va�ich str�nek
                umo�n� snadn�ji naj�t jeho prim�rn� linii potomk�.</p>

            <span class="optionhead">Se�adit d�ti</span>
            <p>V ka�d� rodin� vybran�ho stromu dojde k se�azen� d�t� podle data narozen�. Bude nahrazeno d��v�j�� �azen�, kter� bylo
                provedeno jin�mi sou��stmi TNG nebo va�� desktopovou aplikac�.</p>

            <span class="optionhead">Se�adit partnery</span>
            <p>Partne�i ka�d� osoby vybran�ho stromu budou se�azeni podle data s�atku. Bude nahrazeno d��v�j�� �azen�, kter� bylo
                provedeno jin�mi sou��stmi TNG nebo va�� desktopovou aplikac�.</p>

            <span class="optionhead">Znovu ozna�it v�tve</span>
            <p>Nov� import va�eho souboru GEDCOM s volbou <span class="emphasis">Nahradit v�echna data</span> zp�sob�, �e v�echna d��ve existuj�c� ozna�en� v�tv� budou
                odstran�na. Kliknut�m na toto tla��tko tato ozna�en� obnov�te (��sla ID mus� odpov�dat va�im d��v�j��m dat�m).</p>

            <span class="optionhead">Vytvo�it GENDEX</span>
            <p>Dojde k vytvo�en� indexovan�ho souboru ve form�tu GENDEX. V Z�kladn�m nastaven� ur��te n�zev slo�ky, kam bude soubor ulo�en.
                Pokud vyberete "V�echny stromy", bude tento soubor pojmenov�n "gendex.txt". Pokud vyberete jeden strom, n�zev va�eho souboru GENDEX bude ID ��slo stromu (nikoli n�zev stromu),
                a p��pona .txt. Dal�� informace o souborech GENDEX najdete na
                <a href="http://www.gendexnetwork.org">GenDex Network</a> nebo <a href="http://www.familytreeseeker.com">FamilyTreeSeeker.com</a>.</p>

            <span class="optionhead">Publikov�n� va�eho souboru GENDEX na TNG Network</span>
            <p>M�te-li indexovan� soubor GENDEX, nav�tivte <a href="http://www.gendexnetwork.org">GenDex Network</a> nebo <a href="http://www.familytreeseeker.com">FamilyTreeSeeker.com</a>.
                Budete si muset vytvo�it ��et a pot� budete moci naimportovat v� soubor GENDEX. Poka�d�, kdy� budete cht�t aktualizovat v� v�pis na TNG Network,
                budete pot�ebovat znovu vytvo�it a znovu naimportovat v� soubor GENDEX.</p>

            <span class="optionhead">Zredukovat menu m�di�</span>
            <p>TNG obsahuje polo�ky menu pro n�kolik standardn�ch kolekc� m�di� (Fotografie, Dokumenty, Vypr�v�n�, N�hrobky, Videa a Zvukov� z�znamy). Pokud v n�kter�ch kolekc�ch
                nem�te ��dn� polo�ky, m��ete pomoc� kliknut� na tuto volbu tyto polo�ky z menu odstranit. P�id�te-li v budoucnu do "redukovan�" kolekce n�jakou polo�ku,
                do menu se tato polo�ka automaticky vr�t�.</p>

            <span class="optionhead">Obnovit �ijic�</span>
            <p>Vyhled�ny budou v�echny osoby, kter� nemaj� zapsan� datum �mrt� a kter� se narodily p�ed takovou dobou, �e mohou b�t teoreticky je�t� na�ivu, a budou ozna�eny jako "�ij�c�".
                P�esn� po�et let je ur�en volbou "Pokud chyb� datum �mrt�, p�edpokl�dat, �e osoba zem�ela, je-li star�� ne�" na str�nce Nastaven� importu. Tam, kde je takov� osoba partnerem, dojde
                tak� k ozna�en� rodiny jako �ij�c�. A naopak, tento n�stroj nalezne i v�echny osoby, kter� maj� zapsan� datum �mrt� nebo poh�bu, nebo kter� se nenarodily v tomto �asov�m rozmez�
                a ozna�� je jako zesnul�.</p>

            <span class="optionhead">Vytvo�it neve�ejn�</span>
            <p>Vyhled�ny budou v�echny osoby, kter� zem�ely v ned�vn� minulosti, a budou ozna�eny jako "Neve�ejn�". P�esn� po�et let vych�z� z volby "Osoba je neve�ejn�, pokud zem�ela p�ed m�n� ne� tolika lety"
                na str�nce Nastaven� importu. Tam, kde je takov� osoba partnerem, dojde tak� k ozna�en� rodiny jako neve�ejn�. Na rozd�l od n�stroje Obnovit �ijic� zde
                nedojde u ��dn� osoby k odstran�n� ozna�en� Neve�ejn�.
            </p>
        </td>
    </tr>
</table>
</body>
</html>

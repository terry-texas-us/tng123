<?php
include "../../helplib.php";
echo help_header("N�pov�da: Google Maps");
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
        <a href="places_help.php" class="lightlink">&laquo; N�pov�da: M�sta</a> &nbsp; | &nbsp;
        <a href="tlevents_help.php" class="lightlink">N�pov�da: Ud�losti �asov� osy &raquo;</a>
      </p>
      <span class="largeheader">N�pov�da: Google Maps</span>
      <p class="smaller menu">
        <a href="#show" class="lightlink">Zobrazit</a> &nbsp; | &nbsp;
        <a href="#search" class="lightlink">Hledat</a> &nbsp; | &nbsp;
        <a href="#controls" class="lightlink">Ovl�d�n� mapy</a> &nbsp; | &nbsp;
        <a href="#help" class="lightlink">N�pov�da</a>
      </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">
            <a name="show"><p class="subheadbold">Zobrazit/skr�t klikac� mapu</p></a>
            <p>Kliknut�m na tla��tko "Zobrazit/skr�t klikac� mapu" se zobraz� Google Maps a mo�nost vyhledat m�sta pro geok�dov�n�
                nebo se po dokon�en� mapa skryje. V�choz� nastaven� je specifikov�no v Admin/Nastaven�/Nastaven� mapy.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="search"><p class="subheadbold">Hledat</p></a>
            <p>Google Map Geocoder v�m umo�n� nal�zt sou�adnice zem�pisn� ���ky a d�lky pro n�zev m�sta p�i pou�it� pole Geok�dovat um�st�n� jako vstupn�ho pole.
                Pro vyhled�n� sou�adnic m��ete tak� vyu��t aplikaci Streetmap (<a href="http://www.streetmap.co.uk" target="_blank">http://www.streetmap.co.uk</a>).</p>

            <span class="optionhead">Geok�dovat um�st�n�</span>
            <p>Pokud ji� bylo m�sto zavedeno v TNG, obsahuje pole Geok�dovat um�st�n� n�zev tohoto m�sta. P�i p�id�n� nov�ho m�sta bude do pole Geok�dovat um�st�n�
                dopln�n n�zev m�sta z TNG. P�i p�id�n� h�bitov� nebo m�di� nejsou n�zvy m�st dopln�ny. </p>
            <p>U existuj�c�ch n�zv� m�st v TNG je n�kdy t�eba ve vstupn�m poli Geok�dovat um�st�n� upravit n�zev m�sta. Nap�. Google nem� r�d n�zvy okres�
                jako sou��st n�zv� m�st v USA, ani si neporad� s novoz�landsk�mi provinciemi. Jako vstup m��ete tak� cht�t vlo�it pouze n�zev m�sta a zemi.
                N�zev zem� m��ete tak� zapsat v angli�tin�.</p>
            <span class="optionhead">P��klady n�zv� m�st</span>
            <p>N�sleduj� p��klady, jak maj� b�t zaps�na m�sta, aby v�sledek obsahoval spr�vn� �daje o zem�pisn� ���ce a d�lce:
            <ul>
                <li>1102 Shipwatch Circle, Tampa, Florida</li>
                <li>Klippan 1, 41451 Sweden</li>
                <li>Avenida de Velasquez 126, Malaga</li>
                <li>49 Rue de Tournai, Lille, France</li>
                <li>Ocean Drive, Twin Waters, Queensland, Australia</li>
                <li>Rue de la Wastinne 45, 1301 Wavre, Belgium</li>
                <li>Via Villanova 31, 40050 Bologna villanova, Italy</li>
                <li>Europaboulevard 10, Amsterdam</li>
                <li>Lise-Meitner-Strasse 2, 60486 Frankfurt, Germany</li>
            </ul>
            </p>

            <p>Geocoder nem��e pracovat s mapami n�kter�ch st�t� z n�rodnostn�ch nebo licen�n�ch d�vod�.
                Pro tyto st�ty mus�te pou��t odkaz <a href="http://maps.google.com/" target="_blank">Pln� vyhled�v�n� v Google Maps</a>.</p>

            <span class="optionhead">Zem�pisn� ���ka a d�lka</span>
            <p>P�i p�ijet� sou�adnic zem�pisn� ���ky a d�lky, kter� v�m nab�z� vyhled�v�n� v map�, mus�te b�t velmi pe�liv�. P�inejmen��m byste m�li alespo� trochu
                v�d�t, kde se dan� m�sto nach�z� a co o�ek�v�te p�ed t�m, ne� p�ijmete v�sledek z hled�n� v map�. Pokud se �pendl�k na map�
                nenach�z� na m�st�, kde byste jej �ekali, zem�pisn� ���ka a d�lka, kter� je vr�cena, nemus� b�t spr�vn�. V takov�m p��pad� byste m�li zpozorn�t a kliknout na
                Google Maps pro pozici k lep��mu um�st�n�.</p>

            <p>P�ijatou zem�pisnou ���ku a d�lku byste m�li tak� otestovat kliknut�m na ikonu Test v seznamu m�st a pot� kliknut�m na �pendl�k ov��it
                na extern� map�, �e um�st�n� je spr�vn�.</p>

            <span class="optionhead">P�ibl�en�</span>
            <p>Nen�-li m�sto na map� v po�adovan�m p�ibl�en�, m��ete pou��t n�e popsan� ovlada� p�ibl�en� k p�izp�soben� zobrazen�
                mapy, zvlṻe pro omezen� chybov�ch hl�en�, �e Google neobsahuje mapu v t�to �rovni p�ibl�en�. Hodnota v�sledn�ho p�ibl�en� bude
                ulo�ena ve va�� datab�zi TNG.</p>

            <span class="optionhead">�rove� s�dla</span>
            <p>Rozbalovac� seznam �rove� s�dla m��ete pou��t k v�b�ru �rovn� �len�n� s�dla zastoupen�ho n�zvem m�sta. K dispozici je �est �rovn� v rozsahu od adresy po zemi,
                kde adresa je nejpodrobn�j��. P�epsat obsah prom�nn� $admtext pro �rovn� 1 a� 6, kter� jsou v souboru alltext.php, m��ete ve sv�m souboru cust_text.php.
                Tagy pro �rovn� 2 a� 5 m��ete zm�nit, aby reflektovali nap�. kostel/nemocnice/h�bitov, m�sto/obec, okres/department, kraj/provincie/region.
                R�zn� barevn� �pendl�ky ozna�uj� �len�n� �rovn� s�dla na str�nce osoby. Indik�tor �rovn� s�dla se neobjevuje
                v tabulce h�bitov� a m�di�. �pendl�ky zobrazen� v tabulce h�bitov� jsou v �rovni 2, co� umo��uje, �e n�hrobky jsou zobrazeny v nejpodrobn�j�� �rovni.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="controls"><p class="subheadbold">Ovl�dac� prvky Google Maps</p></a>

            <span class="optionhead">Bod / Klik</span>
            <p>Chcete-li zp�esnit �daj o zem�pisn� ���ce a d�lce u dan�ho m�sta, klikn�te v Google Maps na bod, kde si mysl�te, �e se m�sto nach�z�. Pro obdr�en� lep��ch �daj�
                o zem�pisn� ���ce a d�lce pro n�zev m�sta v TNG m��ete tak� v Google Maps pou��t tla��tka Mapa nebo Satelitn�. </p>

            <span class="optionhead">T�hnout a posunout</span>
            <p>Mapy se daj� posunovat, tak�e m��ete pou��t my� nebo sm�rov� �ipky pro posun doleva, doprava, nahoru nebo dol� pro zobrazen� oblast�, kter� jsou skryt�
                mimo obrazovku. Mo�nost t�hnout a posunout znamen�, �e nemus�te klikat ani �ekat na nov� na�ten� grafiky poka�d�, kdy� chcete vid�t p�ilehl� ��sti mapy.</p>

            <span class="optionhead">P�ibl�en�</span>
            <p>Zna�ky plus (+) a minus (-) nebo posuvn�k p�ibl�en� m��ete pou��t pro p�ibl�en� nebo odd�len� mapy. P�i p�ibl�en� mapy m��ete pou��t sm�rov� �ipky
                pro vylep�en� pozice na map�. Zm�n�te-li �rove� p�ibl�en�, hodnota p�ibl�en� bude ulo�ena v tabulce TNG.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="help"><p class="subheadbold">N�pov�da Google Maps</p></a>

            <p>Dal�� n�pov�du najdete na <a href="http://www.google.com/apis/maps/documentation/" target="_blank">Google Maps API</a>.</p>
        </td>
    </tr>

</table>
</body>
</html>

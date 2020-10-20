<?php
include "../../helplib.php";
echo help_header("N�pov�da: Nastaven� sch�mat");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="config_help.php" class="lightlink">&laquo; N�pov�da: Z�kladn� nastaven�</a> &nbsp;|&nbsp;
                <a href="logconfig_help.php" class="lightlink">N�pov�da: Nastaven� protokolov�n� &raquo;</a>
            </p>
            <h2 class="largeheader">N�pov�da: <small>Nastaven� sch�mat</small></h2>
            <p class="smaller menu clear-both">
                <a href="#ped" class="lightlink">P�edkov�</a> &nbsp;|&nbsp;
                <a href="#desc" class="lightlink">Potomci</a> &nbsp;|&nbsp;
                <a href="#rel" class="lightlink">P��buzensk� vztahy</a> &nbsp;|&nbsp;
                <a href="#time" class="lightlink">�asov� osa</a> &nbsp;|&nbsp;
                <a href="#common" class="lightlink">Spole�n� prvky</a> &nbsp;|&nbsp;
                <a href="#thumb" class="lightlink">N�hledy</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">
            <a id="ped"><h4 class="subheadbold">P�edkov�</h4></a>

            <h5>V�choz� zobrazen�</h5>
            <p>Pomoc� t�to volby nastav�te v�choz� form�t sch�matu p�edk�. Je-li vybr�no Standardn�, v�echna data narozen�, s�atku a �mrt�/poh�bu
                (jsou-li k dispozici) budou vlo�ena do skryt�ho vyskakovac�ho r�me�ku. Fotografie osoby bude zobrazena (pokud existuje). Tam, kde jsou
                data k dispozici,
                bude na st�edu pod spodn�m okrajem r�me�k� sch�matu um�st�n obrazov� soubor (nap�. ArrowDown.gif), a kdy� je vyvol�n vyskakovac�
                r�me�ek, objev� se pod r�me�kem sch�matu.
                Kompaktn� form�t je podobn� Standardn�mu, ale velikost r�me�ku je v�razn� zmen�ena, a nejsou zobrazeny fotografie. Kdy� je vybr�n
                form�t R�me�ek,
                standardn� �daje se v�dy objev� v r�me�c�ch sch�matu. Je-li vybr�n Pouze text, bude nejprve zobrazena textov� verze sch�matu p�edk�
                (��dn� r�me�ky ani vyskakovac� okna).
                Volba Svisle zobraz� v�choz� osobu dole a p�edkov� osoby budou zobrazeni nad n�.
                Po zobrazen� v�choz�ho form�tu m� u�ivatel v�dy mo�nost p�epnout mezi jednotliv�mi typy.</p>

            <h5>Maxim�ln� po�et generac�</h5>
            <p>Maxim�ln� po�et generac�, kter� povol�te u�ivateli zobrazit najednou.</p>

            <h5>V�choz� po�et generac�</h5>
            <p>Po�et generac�, kter� budou zobrazeny na za��tku. Nen�-li nic specifikov�no, bude tato hodnota nastavena na 4.</p>

            <h5>Partne�i ve vyskakovac�ch oknech</h5>
            <p>Pou��vaj�-li se vyskakovac� okna, za�krtnut�m t�to volby budou do vyskakovac�ch r�me�k� vlo�eny odkazy na partnery. Ve v�choz�m stavu
                nen� za�krtnuto.</p>

            <h5>D�ti ve vyskakovac�ch oknech</h5>
            <p>Pou��vaj�-li se vyskakovac� okna a volba Partne�i ve vyskakovac�ch oknech je za�krtnuta, za�krtnut�m t�to volby budou do vyskakovac�ch
                r�me�k� vlo�eny odkazy na d�ti. Ve v�choz�m stavu nen� za�krtnuto.</p>

            <h5>Odkazy na sch�mata ve vyskakovac�ch oknech</h5>
            <p>Pou��vaj�-li se vyskakovac� okna (a volby Partne�i nebo d�ti ve vyskakovac�ch oknech jsou za�krtnuty), za�krtnut�m t�to volby budou do
                vyskakovac�ch r�me�k� vlo�eny odkazy na sch�mata partner� a d�t�.
                Ve v�choz�m stavu je za�krtnuto.</p>

            <h5>Skr�t pr�zdn� r�me�ky</h5>
            <p>V�b�rem 'Ano' odstran�te ze sch�matu pr�zdn� r�me�ky.</p>

            <h5>���ka r�me�ku (bez vyskakovac�ch oken)</h5>
            <p>Pevn� ���ka v�ech r�me�k� sch�matu (v pixelech), nepou��vaj�-li se vyskakovac� okna. V�choz� hodnota je 211. Bude-li zad�n� ��slo men��
                ne� 21, bude pou�ito 21.
                Pou�it� ��slo by m�lo b�t v�dy lich�, tak�e bude-li vlo�eno sud� ��slo, bude zv�t�eno o 1.</p>

            <h5>V��ka r�me�ku (bez vyskakovac�ch oken)</h5>
            <p>V��ka v�ech r�me�k� sch�matu (v pixelech), nepou��vaj�-li se vyskakovac� okna, jestli�e nen� specifikovan� nenulov� posunut� v��ky
                r�me�ku (viz n�e), v tomto p��pad� je V��ka r�me�ku
                v��kou prvn�ho r�me�ku ve sch�matu. V�choz� hodnota je 121. Bude-li zad�n� ��slo men�� ne� 21, bude pou�ito 21. Pou�it� ��slo by m�lo
                b�t v�dy lich�, tak�e bude-li vlo�eno sud� ��slo, bude zv�t�eno o 1.</p>

            <h5>Zarovn�n� r�me�ku (bez vyskakovac�ch oken)</h5>
            <p>Zarovn�n� �daj�, kter� se objev� v zobrazen�m vyskakovac�m okn�.
                Pozn.: Data a m�sta budou v�dy zarovn�na doleva, ale blok, kter� je obsahuje, bude zarovn�n podle tohoto nastaven�.</p>

            <h5>Posunut� v��ky r�me�ku (bez vyskakovac�ch oken)</h5>
            <p>Hodnota, podle kter� by se m�la v��ka r�me�k� sch�matu m�nit u dal��ch generac� (v pixelech), kdy� se nepou��vaj� vyskakovac� okna.
                M�lo by to b�t z�porn� ��slo. V�choz� hodnota je -2. Je-li vlo�ena hodnota 0, neobjev� se v rozm�rech r�me�ku ��dn� zm�na.
                Pou�it� ��slo by m�lo b�t v�dy lich�, tak�e bude-li vlo�eno sud� ��slo, bude zv�t�eno o 1.</p>

            <h3>Svisl� sch�ma</h3>

            <h5>���ka r�me�ku</h5>
            <p>���ka r�me�ku se jm�nem v pixelech ve svisl�m sch�matu.</p>

            <h5>V��ka r�me�ku</h5>
            <p>V��ka r�me�ku se jm�nem v pixelech ve svisl�m sch�matu.</p>

            <h5>Vzd�lenost mezi r�me�ky</h5>
            <p>Vodorovn� vzd�lenost v pixelech mezi r�me�ky se jm�ny.</p>

            <h5>Velikost jm�na v r�me�ku</h5>
            <p>Velikost p�sma (v bodech) u jmen zobrazen�ch ve svisl�m sch�matu.</p>

            <h3>V�j��ov� graf</h3>
            <p>N�kter� nastaven� zobrazen� v�j��ov�ho grafu (barvy, v��ka, typ a velikost p�sma, po�et generac�, zobrazen� informa�n�ch r�me�k�)
                lze prov�st v souboru <b>fan_config.php</b>, kter� se nach�z� ve slo�ce TNG.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="desc"><h4 class="subheadbold">Potomci</h4></a>

            <h5>V�choz� zobrazen�</h5>
            <p>Pomoc� t�to volby nastav�te v�choz� form�t potomk�. Je-li vybr�no Standardn�, v�echna data narozen�, s�atku a �mrt�/poh�bu
                (jsou-li k dispozici) budou vlo�ena do skryt�ho vyskakovac�ho r�me�ku. Fotografie osoby bude zobrazena (pokud existuje). Tam, kde jsou
                data k dispozici,
                bude na st�edu pod spodn�m okrajem r�me�k� sch�matu um�st�n obrazov� soubor (nap�. ArrowDown.gif), a kdy� je vyvol�n vyskakovac�
                r�me�ek, objev� se pod r�me�kem sch�matu.
                Kompaktn� form�t je podobn� Standardn�mu, ale velikost r�me�ku je v�razn� zmen�ena, a nejsou zobrazeny fotografie. Je-li vybr�n Pouze
                text, bude zobrazena textov�
                verze sch�matu potomk� (��dn� r�me�ky ani vyskakovac� okna). Form�t Registr zobraz� stejn� informace ve stylu vypr�v�n�.
                Po zobrazen� v�choz�ho form�tu m� u�ivatel v�dy mo�nost p�epnout mezi jednotliv�mi typy.</p>

            <h5>Maxim�ln� po�et generac�</h5>
            <p>Maxim�ln� po�et generac�, kter� povol�te u�ivateli zobrazit najednou.</p>

            <h5>V�choz� po�et generac�</h5>
            <p>Po�et generac�, kter� budou zobrazeny na za��tku. Nen�-li nic specifikov�no, bude tato hodnota nastavena na 4.</p>

            <h5>Spu�t�n� sch�matu potomk�</h5>
            <p>Vyberte, zda chcete spustit sch�mata potomk� zalo�en� na textu se v�emi generacemi rozbalen�mi nebo sbalen�mi. U�ivatel bude m�t v�dy
                mo�nost
                rodiny sbalit nebo rozbalit.</p>

            <h5>Zobrazit pozn�mky v Registru</h5>
            <p>Ozna�uje, zda budou pozn�mky k osob� nebo rodin� zobrazeny na str�nce Registru.</p>

            <h5>Generace v Registru</h5>
            <p>Vyberte, zda chcete p�i zobrazen� generace zobrazit v�echny osoby nebo po�et osob omezit v�b�rem "Odstranit osoby bez rodin".
                Podle t�to volby budou zobrazeny pouze osoby, kdy� se objev� jako d�ti. Nebudou v�ak zobrazeny znovu,
                kdy� bude jejich cel� generace pops�na v reportu pozd�ji.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Top</a></p>
            <a id="rel"><h4 class="subheadbold">Sch�ma p��buzensk�ch vztah�</h4></a>
            <h5>V�choz� po�et vztah�</h5>
            <p>Tato hodnota ud�v� po�et p��buzensk�ch vztah�, kter� bude TNG hledat p�i prvn�m spu�t�n� sch�matu p��buzensk�ch vztah�. Po nalezen�
                tohoto
                po�tu vztah� se proces zastav�. Pokud v� strom neobsahuje komplikovan� p��buzensk� vztahy, m��ete tuto hodnotu nastavit
                na 1, abyste u�et�ili �as pr�b�hu.</p>

            <h5>Maxim�ln� po�et vztah�</h5>
            <p>Pokud si u�ivatel mysl�, �e existuje v�ce p��buzensk�ch vztah�, m��e toto ��slo zv��it a TNG se je pokus� nal�zt.
                Toto ��slo uv�d� maximum vztah�, kter� povol�te programu hledat. Nenastavujte je na vy��� ��slo,
                ne� je �rove� slo�itosti va�eho stromu. ��m je ��slo ni���, t�m v�ce �asu u�et��te lidem p�i zobrazen� tohoto sch�matu.
                Pokud nap�. mezi dv�ma lidmi existuje pouze jeden p��buzensk� vztah, ale vy jich budete hledat 5,
                TNG bude po nalezen� prvn�ho vztahu d�le hledat marn�.</p>

            <h5>Maxim�ln� po�et generac�</h5>
            <p>Maxim�ln� po�et generac�, kter� povol�te n�v�t�vn�kovi na str�nce p��buzensk�ch vztah� najednou prohledat. M��e to b�t na t�to str�nce
                tak� v�choz� po�et.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="time"><h4 class="subheadbold">Sch�ma �asov� osy</h4></a>
            <h5>V�choz� ���ka sch�matu</h5>
            <p>V�choz� ���ka sch�matu d�lky �ivota v pixelech. N�v�t�vn�ci si mohou ���ku zm�nit na horn�m okraji obrazovky.</p>

            <h5>Povolit �asovou linii Simile</h5>
            <p>V�b�rem volby "Ano" m��ete vedle standardn� �asov� linie TNG tak� na stejn� str�nce zobrazit sch�ma �asov� linie Simile. V�ce
                informac� o sch�matu �asov� linie Simile m��ete naj�t na <a href="http://www.simile-widgets.org/timeline/">http://www.simile-widgets.org/timeline/</a>.
            </p>

            <h5>V��ka sch�matu</h5>
            <p>V��ka �asov� osy ud�lost� (Simile) v pixelech. Je-li zobrazeno mnoho ud�lost� najednou, mohou b�t n�kter� vytla�eny
                mimo viditelnou oblast sch�matu. Pokud se v�m zd�, �e se to stalo, mohlo by zv��en� t�to hodnoty pomoci.</p>

            <h5>Kter� ud�losti zahrnout</h5>
            <p>Ovlivn�, kter� ud�losti budou v �asov� ose ud�lost� zahrnuty. M��ete vybrat zobrazen� v�ech ud�lost� nebo jenom t�ch, kter� spadaj�
                do obdob� �ivota osob ve sch�matu. Pokud m�te mnoho ud�lost�, v�b�rem zobrazen� v�ech m��e m�t za n�sledek,
                �e se sch�ma poprv� zobraz� pomaleji.</p>

            <p>Pozn.: Pokud je najednou ve sch�matu p��li� mnoho ud�lost�, ud�losti na konci nebudou vid�t. M�te-li mnoho ud�lost� �asov� osy a toto
                je �ast�m jevem,
                m��ete uva�ovat o zv�t�en� hodnoty v��ky sch�matu (viz v��e). Dal�� mo�nost� nastaven� jsou k dispozici v souboru <b>timelineconfig.php</b>,
                kter� se nach�z� ve slo�ce TNG:</p>
            <p>
                $band1_pct = "10%"; (Horn� pruh; jsou zde zobrazeny velmi mal� ��rky, hrub� �rove� zobrazen� ud�lost� rodiny (narozen�, k�tu,
                man�elstv�, narozen� d�t�, atd...) Zab�r� 10% celkov� v��ky.)<br>
                $band1_interval = 150; (Po�et pixel� mezi jednotliv�mi zna�kami.)<br>
                $band1_multiple = 1; (Po�et let mezi zna�kami. Pokud je hodnota 2, bude p�esko�en ka�d� druh� rok.)<br>

                $band2_pct = "28%"; (Druh� pruh. Ukazuje ud�losti rodiny podrobn�ji. Zab�r� 28% celkov� v��ky.)<br>
                $band2_interval = 50; (Po�et pixel� mezi jednotliv�mi zna�kami.)<br>
                $band2_multiple = 1; (Po�et let mezi zna�kami. Pokud je hodnota 2, bude p�esko�en ka�d� druh� rok.)<br>

                $band3_pct = "47%"; (T�et� pruh. Ukazuje obecn� ud�losti �asov� osy. Zab�r� 47% celkov� v��ky.)<br>
                $band3_interval = 175; (Po�et pixel� mezi jednotliv�mi zna�kami.)<br>
                $band3_multiple = 1; (Po�et let mezi zna�kami. Pokud je hodnota 2, bude p�esko�en ka�d� druh� rok.)<br>

                $band4_pct = "15%"; (Spodn� pruh; jsou zde zobrazeny velmi mal� ��rky, hrub� �rove� zobrazen� obecn�ch ud�lost� �asov� osy z pruhu 3.
                Zab�r� 15% celkov� v��ky.)<br>
                $band4_interval = 150; (Po�et pixel� mezi jednotliv�mi zna�kami.)<br>
                $band4_multiple = 1; (Po�et let mezi zna�kami. Pokud je hodnota 2, bude p�esko�en ka�d� druh� rok.)<br>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="common"><h4 class="subheadbold">Spole�n� prvky</h4></a>

            <h5>Odsazen� zleva</h5>
            <p>Vodorovn� posun, kter� bude pou�it u cel�ho sch�matu (v pixelech). Lze t�m nap�. zajistit, aby sch�ma nep�ekr�valo
                okraj obr�zku, menu nebo textu, kter� by mohly b�t na lev�m okraji. V�choz� hodnota je 10. Zad�te-li z�pornou hodnotu, bude pou�ita
                0.</p>

            <h5>Velikost jm�na v r�me�ku</h5>
            <p>Velikost (v bodech) v�ech jmen ve sch�matu. V ��dn�m p��pad� nen� mo�no sn�it toto hodnotu na m�n� ne�
                7 bod�. V�choz� hodnota je 12.</p>

            <h5>Velikost data v r�me�ku</h5>
            <p>Velikost (v bodech) ostatn�ch �daj� ve sch�matu (data a m�sta). V ��dn�m p��pad� nen� mo�no sn�it toto hodnotu na m�n� ne�
                7 bod�. V�choz� hodnota je 10.</p>

            <h5>Barva r�me�ku</h5>
            <p>Barva pozad�, kter� bude pou�ita ve v�ech r�me�c�ch sch�matu, pokud nen� specifikov�na nenulov� hodnota Posunu barvy, v tomto p��pad�
                je jedn� o definici barvy
                pozad� prvn�ho r�me�ku ve sch�matu. V�choz� hodnota je #CCCC99 (khaki; b�l� je #FFFFFF).</p>

            <h5>Posun barvy</h5>
            <p>Hodnota v procentech, kter� definuje, jak by m�la b�t hodnota barvy "posunuta" nahoru nebo dol� (k b�l� nebo k �ern�) v rozsahu v�ech
                zobrazen�ch generac�. Zadan� hodnota by m�la b�t mezi -100 a 100. Zad�te-li hodnotu 0, r�me�ky v cel�m sch�matu (mimo ty, kter� jsou
                pr�zdn� &#151; viz Barva pr�zdn�ch)
                budou m�t stejnou barvu pozad�. V�choz� hodnota je 80, co� znamen�, �e barva pozad� r�me�ku zesl�bne o 80% proti p�vodn� barv� sm�rem
                k b�l� tak, jak
                jsou r�me�ky zobrazeny od prvn� generace k posledn� (z�porn� hodnoty posunou barvu sm�rem k �ern�).</p>

            <h5>Barva pr�zdn�ch r�me�k�</h5>
            <p>Barva pozad�, kter� bude pou�ita ve v�ech r�me�c�ch sch�matu, ve kter�ch nejsou ��dn� �daje. V�choz� hodnota je #CCCCCC (st��brn�).</p>

            <h5>Barva okraje</h5>
            <p>Barva, kter� bude pou�ita na okraje r�me�k� a spojnice. V�choz� hodnota je #000000 (�ern�).</p>

            <h5>Barva st�nu</h5>
            <p>Barva, kter� bude pou�ita pro st�ny. V�choz� hodnota je #999999 (�ed�).</p>

            <h5>Posun st�nu</h5>
            <p>Posun, kter� bude pou�it pro vlo�en� st�nu r�me�ku a spojnice (v pixelech). Z�porn� ��slo bude m�t za n�sledek,
                �e bude st�n naho�e a vlevo od r�me�k� a linek. Kladn� ��slo zp�sob�, �e bude st�n dole a vpravo od r�me�k� a linek. Je-li zadan�
                hodnota 0,
                st�ny se neobjev� (proto�e budou striktn� pod r�me�ky a linkami). V�choz� hodnota je 4.</p>

            <h5>Vodorovn� odd�len� r�me�k�</h5>
            <p>Pevn� vodorovn� odd�len� r�me�k� sch�matu mezi jednotliv�mi generacemi (v pixelech). V�choz� hodnota je 31. Pokud je zadan� hodnota
                men�� ne� 7, bude pou�ita 7. Pou�it� ��slo by m�lo b�t v�dy lich�, tak�e bude-li vlo�eno sud� ��slo, bude zv��eno o 1.</p>

            <h5>Svisl� odd�len� r�me�k�</h5>
            <p>Svisl� odd�len� r�me�k� sch�matu mezi jednotliv�mi generacemi (v pixelech), pokud nen� specifikov�na nenulov� hodnota Posunut� v��ky
                r�me�ku, v tomto
                p��pad� bude Svisl� odd�len� r�me�k� pevn�m vodorovn�m odd�len�m r�me�k� sch�matu posledn� zobrazen� generace. V�choz� hodnota je 11.
                Pokud je zadan� hodnota
                men�� ne� 7, bude pou�ita 7. Pou�it� ��slo by m�lo b�t v�dy lich�, tak�e bude-li vlo�eno sud� ��slo, bude zv��eno o 1. Bez ohledu na
                v��e uveden�
                m��e b�t hodnota zv��ena, je-li to nutn� pro zaji�t�n� v�ce m�sta pro st�ny a indik�tory dal��ch informac�.</p>

            <h5>V�choz� velikost str�nky PDF</h5>
            <p>Velikost pap�ru, kter� bude pou�ita ve v�ech v�stupech do PDF (n�v�t�vn�ci ji mohou zm�nit p�ed vytvo�en�m ka�d�ho v�stupu).</p>

            <h5>���ka ��ry</h5>
            <p>���ka ��ry spojuj�c� r�me�ky ve sch�matu (v pixelech). V�choz� hodnota je 1. Pokud je zadan� hodnota men�� ne� 1, bude pou�ita 1.</p>

            <h5>���ka okraje</h5>
            <p>���ka okraje kolem r�me�ku ve sch�matu (v pixelech). V�choz� hodnota je 1. Pokud je zadan� hodnota men�� ne� 1, bude pou�ita 1.</p>

            <h5>Barva vyskakovac�ch oken</h5>
            <p>Barva pozad� pou�it� ve vyskakovac�ch oknech. Pokud bude ponech�na pr�zdn�, bude pou�ita barva, kter� bude posunuta o jednu barvu od
                barvy r�me�ku. V�choz� hodnota je #DDDDDD (sv�tle �ed�). </p>

            <h5>Velikost textu ve vyskakovac�ch oknech</h5>
            <p>Velikost (v bodech) ostatn�ch �daj� (data a m�sta) uvnit� vyskakovac�ch oken. V ��dn�m p��pad� nen� mo�no sn�it toto hodnotu na m�n�
                ne�
                7 bod�. V�choz� hodnota je 10.</p>

            <h5>�asov� zdr�en� vyskakovac�ch oken</h5>
            <p>Pokud se pou��vaj� vyskakovac� okna, jde o po�et milisekund, po kter� z�stane vyskakovac� okno viditeln�. V�choz� hodnota je 500 (1/2
                sekundy). Dobu zobrazen� vyskakovac�ho okna
                mohou ovlivnit dv� podm�nky. Za prv�, m�-li se objevit dal�� vyskakovac� okno, mus� to prvn� viditeln� zmizet. Za druh�, je-li kursor
                nad viditeln�m vyskakovac�m oknem,
                zdr�en�, kter� je zde definov�no, nebude pou�ito, dokud se kursor nep�esune mimo vyskakovac� okno. Znamen� to, �e vyskakovac� okno lez
                podr�et viditeln� po nedefinovanou dobu.</p>

            <h5>Zobrazen� vyskakovac�ho okna</h5>
            <p>Akce my�i, kter� jsou t�eba pro zobrazen� vyskakovac�ho okna. Tato akce je spojena se �ipkou, kter� ozna�uje, �e jsou dostupn� dal��
                �daje. Je-li vybr�na volba
                My� dol�, vyskakovac� okno se zobraz� p�i kliknut� na �ipku. Je-li vybr�na volba My� p�es, vyskakovac� okno se zobraz�, kdy� se kursor
                my�i um�st� na �ipku.</p>

            <h5>���ka r�me�ku (s vyskakovac�m oknem)</h5>
            <p>Pevn� ���ka v�ech r�me�k� sch�matu (v pixelech), pou��vaj�-li se vyskakovac� okna. V�choz� hodnota je 151. Bude-li zad�n� ��slo men��
                ne� 21, bude pou�ito 21.
                Pou�it� ��slo by m�lo b�t v�dy lich�, tak�e bude-li vlo�eno sud� ��slo, bude zv�t�eno o 1.</p>

            <h5>V��ka r�me�ku (s vyskakovac�m oknem)</h5>
            <p>V��ka v�ech r�me�k� sch�matu (v pixelech), pou��vaj�-li se vyskakovac� okna, jestli�e nen� specifikovan� nenulov� posunut� v��ky
                r�me�ku (viz n�e), v tomto p��pad� je V��ka r�me�ku
                v��kou prvn�ho r�me�ku ve sch�matu. V�choz� hodnota je 60. Bude-li zad�no ��slo men�� ne� 21, bude pou�ito 21. Pou�it� ��slo by m�lo
                b�t v�dy lich�, tak�e bude-li vlo�eno sud� ��slo, bude zv�t�eno o 1.</p>

            <h5>Zarovn�n� r�me�ku (s vyskakovac�m oknem)</h5>
            <p>Zarovn�n� �daj�, kter� se objev� v r�me�ku, kdy� se nepou��vaj� vyskakovac� okna.
                Pozn.: Data a m�sta budou v�dy zarovn�na doleva, ale blok, kter� je obsahuje, bude zarovn�n podle tohoto nastaven�.</p>

            <h5>Posunut� v��ky r�me�ku (s vyskakovac�m oknem)</h5>
            <p>Hodnota, podle kter� by se m�la v��ka r�me�k� sch�matu m�nit u dal��ch generac� (v pixelech).
                M�lo by to b�t z�porn� ��slo. V�choz� hodnota je -2. Je-li vlo�ena hodnota 0, neobjev� se v rozm�rech r�me�ku ��dn� zm�na.
                Pou�it� ��slo by m�lo b�t v�dy lich�, tak�e bude-li vlo�eno sud� ��slo, bude zv�t�eno o 1.</p>

            <h5>Vlo�it fotografie</h5>
            <p>Je-li za�krtnuta tato volba, do r�me�k� ve sch�matech budou vlo�eny n�hledy fotografi� (pou��vaj�-li se vyskakovac� okna a soubory
                obr�zk� byly nalezeny -- viz n�e).
                V�choz� volbou je neza�krtnuto.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="thumb"><h4 class="subheadbold">Pozn�mky k vlo�en� n�hled� fotografi�</h4></a>

            <ul>
                <li>Chcete-li ozna�it fotografii jako z�stupce osoby ve sch�matech, jd�te do �pravy fotografie (mus� m�t n�hled) a za�krtn�te pol��ko
                    ozna�en� <span class="emphasis">Nastavit jako v�choz�</span>
                    pod odkazem po�adovan� osoby a str�nku ulo�te. Existuj�c� n�hled pak bude pou�it ve sch�matech. Akce v�b�ru <span class="choice">Nastavit jako v�choz�</span>
                    se pou��vala pro kop�rov�n� existuj�c�ho n�hledu na nov� um�st�n�, kde byl kop�rovan� soubor pojmenov�n <span class="emphasis">Mtreename.###.ext</span>,
                    kde <span class="emphasis">strom</span> byl n�zev stromu,
                    ke kter�mu pat�ila osoba, <span class="emphasis">###</span> bylo ID ��slo osoby ze souboru GEDCOM a ext byla p��pona fotografie
                    definovan� v��e (nap�. <span class="example">MLythgoe.I567.jpg</span>).
                    Tato konvence se ji� nepou��v�, ale existuj�c� n�hledy vytvo�en� t�mto zp�sobem jsou nad�le vyu��v�ny a maj� p�ednost. <span
                        class="emphasis">POZN.:</span> M��ete t�mto zp�sobem vytv��et v�choz� n�hledy
                    ru�n�, pokud nechcete, aby byla v�choz� fotografie odvozena z jin� fotografie p�ipojen� k osob�.
                </li>

                <li>Je-li obr�zek vytvo�en v��e uvedenou konvenc�, jeho velikost m��e b�t zmen�ena, je-li to t�eba k tomu, aby se ve�el do v��ky
                    r�me�ku. <span class="emphasis">Zv�t�en�</span>
                    obr�zku se v�ak neprovede, proto�e by t�m utrp�la kvalita obr�zku. Je t�eba tak� poznamenat, �e zmen�en� velikosti obr�zku nem�
                    vliv na velikost souboru fotografie. Jin�mi slovy
                    to neznamen�, �e kdy� obr�zek vypad� men��, zobraz� se rychleji, ne� kdyby byl zobrazen ve sv� p�vodn� velikosti. Proto by velk�
                    fotografie nem�ly b�t pou��v�ny jako obr�zky ve sch�matech,
                    proto�e by prodlu�ovaly �as na�ten� cel� str�nky.
                </li>

                <li>Vlo�en� fotografi� ovlivn� prostor, kter� v r�me�ku z�stane pro jm�na a dal�� �daje. V tomto p��pad� by bylo vhodn� r�me�ek a
                    velikost p�sma <span class="emphasis">vyladit</span> pou�it�m
                    v��e popsan�ch konfigura�n�ch metod nebo vybrat mo�nost <span class="choice">p�ete�en�</span> popsanou v��e.
                </li>
            </ul>
        </td>
    </tr>

</table>
</body>
<?php echo "</html>"; ?>

<?php
include "../../helplib.php";
echo help_header("N�pov�da: Jazyky");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="dna_help.php" class="lightlink">&laquo; N�pov�da: Testy DNA</a> &nbsp;|&nbsp;
                <a href="backuprestore_help.php" class="lightlink">N�pov�da: Obslu�n� programy &raquo;</a>
            </p>
            <h2 class="largeheader">N�pov�da: <small>Jazyky</small></h2>
            <p class="smaller menu" style="clear: both;">
                <a href="#search" class="lightlink">Hledat</a> &nbsp;|&nbsp;
                <a href="#add" class="lightlink">P�idat nebo upravit</a> &nbsp;|&nbsp;
                <a href="#delete" class="lightlink">Vymazat</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="search"><h4 class="subheadbold">Hledat</h4></a>
            <p>Nalezen� existuj�c�ch jazyk� vyhled�n�m cel�ho nebo ��sti <strong>n�zvu pro zobrazen�</strong> nebo <strong>n�zvu slo�ky</strong>.
                V�sledkem hled�n� bez zadan�ch voleb a hodnot ve vyhled�vac�ch pol�ch bude seznam v�ech jazyk� ve va�� datab�zi.</p>

            <p>Vyhled�vac� krit�ria, kter� zad�te na t�to str�nce, budou uchov�na, dokud nekliknete na tla��tko <strong>Obnovit</strong>, kter� znovu
                obnov� v�echny v�choz� hodnoty.</p>

            <h5 class="optionhead">Akce</h5>
            <p>Tla��tko Akce vedle ka�d�ho v�sledku hled�n� v�m umo�n� upravit nebo odstranit tento jazyk.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="add"><h4 class="subheadbold">P�idat nov� / Upravit existuj�c� jazyky</h4></a>
            <p>TNG zobrazuje programov� v�razy, kter� byly p�elo�eny do n�kolika r�zn�ch jazyk�. Chcete-li umo�nit n�v�t�vn�k�m va�ich str�nek
                zobrazit str�nky mimo va�eho v�choz�ho jazyka
                tak� v jin�ch jazyc�ch, mus�te zde pro ka�d� jazyk, kter� m� b�t podporov�n, p�idat z�znam, <strong>v�etn�</strong> sv�ho v�choz�ho
                jazyka. Nap�.
                je-li va�im v�choz�m jazykem �e�tina a chcete tak� podporovat angli�tinu, mus�te v Admin/Jazyky p�idat z�znam pro �e�tinu i
                angli�tinu.</p>

            <p>Chcete-li p�idat nov� jazyk, klikn�te na z�lo�ku <strong>P�idat nov�</strong> a pot� vypl�te formul��.
                V�znam jednotliv�ch pol� je n�sleduj�c�:</p>

            <h5 class="optionhead">Slo�ka jazyku</h5>
            <p>Pro v�b�r um�st�n� souboru pro jazyk pou�ijte rozbalovac� seznam. Pokud v� nov� jazyk pot�ebuje znakovou sadu UTF-8, vyberte slo�ku s
                "UTF8" v n�zvu.
                Chcete-li podporovat nov� jazyk, kter� je�t� nen� podporov�n programem TNG, p�idejte do slo�ky TNG jazyk� slo�ku pro tento jazyk, a
                pak se vra�te na tuto str�nku a vyberte ji.</p>

            <h5 class="optionhead">N�zev tohoto jazyku, jak bude zobrazen n�v�t�vn�k�m</h5>
            <p>Zadejte n�zev jazyku, jak bude zobrazen n�v�t�vn�k�m v poli pro v�b�r jazyk�. Je vhodn� vlo�it tento n�zev v tomto p��slu�n�m jazyce,
                aby jej mohli n�v�t�vn�ci sn�ze identifikovat. Nap�. pou�ijte "English" m�sto "Angli�tina".</p>

            <h5 class="optionhead">Znakov� sada</h5>
            <p>Znakov� sada pou�it� pro tento jazyk. Nech�te-li toto pole pr�zdn�, bude pou�ita znakov� sada ISO-8859-1. �e�tina pou��v� znakovou sadu
                ISO-8859-2 nebo UTF-8</p>

            <h5 class="optionhead">Povinn� pole:</h5> Zadat mus�te n�zev jazyku pro zobrazen� a zvolit mus�te n�zev slo�ky jazyku.</p>

            <p><strong>D�LE�IT�:</strong> Pokud uva�ujete o umo�n�n� dynamick�ho p�ep�n�n� jazyk�, <strong>mus�te nastavit v� v�choz� jazyk</strong>
                (v Nastaven�/Z�kladn� nastaven�) jako jazyk t�chto str�nek.
                Pokud jej nenastav�te, nebudete se moci po p�epnut� na jin� jazyk p�epnout zp�t na v� v�choz� jazyk.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="delete"><h4 class="subheadbold">Vymaz�n� jazyk�</h4></a>
            <p>Chcete-li odstranit jazyk, pou�ijte z�lo�ku <a href="#search">Hledat</a> k nalezen� jazyku, a pot� klikn�te na ikonku Vymazat vedle
                tohoto z�znamu jazyku. Tento ��dek zm�n�
                barvu a pot� po odstran�n� jazyku zmiz�. <strong>Pozn.</strong>: P��slu�n� slo�ka jazyku nebude z va�ich str�nek vymaz�na.</p>

        </td>
    </tr>

</table>
</body>
<?php echo "</html>"; ?>

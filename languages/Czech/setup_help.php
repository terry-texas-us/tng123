<?php
include "../../helplib.php";
echo help_header("N�pov�da: Nastaven�");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="second_help.php" class="lightlink">&laquo; N�pov�da: Druhotn� procesy</a> &nbsp;|&nbsp;
                <a href="config_help.php" class="lightlink">N�pov�da: Z�kladn� nastaven� &raquo;</a>
            </p>
            <h2 class="largeheader">N�pov�da: <small>Nastaven�</small></h2>
            <p class="smaller menu" style="clear: both;">
                <a href="#config" class="lightlink">Konfigurace</a> &nbsp;|&nbsp;
                <a href="#diag" class="lightlink">Diagnostika</a> &nbsp;|&nbsp;
                <a href="#tables" class="lightlink">Vytvo�en� tabulek</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="config"><h4 class="subheadbold">Konfigurace</h4></a>
            <p>Tato str�nka je p��stupov�m m�stem pro nastaven� r�zn�ch oblast� TNG. �prava nastaven� v ka�d� oblasti se odraz� na vzhledu va�ich
                webov�ch str�nek, na
                datab�zi MySQL a dal��ch mo�nostech. Zm�na dal��ch nastaven� ovlivn� zobrazen� r�zn�ch str�nek.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="diag"><h4 class="subheadbold">Diagnostika</h4></a>

            <h5>Spustit diagnostiku</h5>
            <p>Tato str�nka zobraz� informace o nastaven� va�eho webov�ho serveru, v�etn� varov�n� t�kaj�c�ho se nastaven�, kter� mohou ovlivnit b�h
                TNG.</p>

            <h5>Informace o PHP</h5>
            <p>Tato str�nka zobraz� informace o instalaci PHP. Zobrazen� t�chto informac� je funkc� PHP, nikoli TNG. Str�nka je rozd�lena do blok�,
                kter� popisuj� jednotliv� oblasti konfigurace. Pokud se nejste schopni p�ipojit k datab�zi MySQL, pod�vejte se na tuto str�nku a
                vyhledejte odstavec "mysql".
                Pokud jej nevid�te, znamen� to, �e PHP je�t� nekomunikuje s MySQL. Probl�m by m�l b�t v nastaven� PHP, ne TNG.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="tables"><h4 class="subheadbold">Vytvo�en� tabulek</h4></a>

            <h5>Vytvo�it tabulky</h5>
            <p>Na toto tla��tko klikn�te <strong>POUZE</strong>, kdy� va�i str�nku nastavujete poprv�, proto�e zde budou vytvo�eny datab�zov� tabulky
                pot�ebn�
                k ulo�en� va�ich �daj�. <strong>Pozn.: Pokud tabulky ji� existuj�, v�echna data budou ztracena!</strong> Tuto operaci m��ete prov�st,
                pokud byla va�e data po�kozena a maj� b�t po nov�m vytvo�en� tabulek obnovena ze z�lohy.</p>

            <h5>Porovn�v�n�</h5>
            <p>Pokud pou��v�te znakovou sadu UTF-8, m��ete do tohoto pole p�ed vytvo�en�m tabulek zadat utf8_unicode_ci, utf8_general_ci nebo
                utf8_czech_ci.
                V ostatn�ch p��padech, ponech�te-li toto pole pr�zdn�, p�ijmete v�choz� porovn�v�n�.</p>
        </td>
    </tr>

</table>
</body>
<?php echo "</html>"; ?>

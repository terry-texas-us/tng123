<?php
include("../../helplib.php");
echo help_header("N�pov�da: Nastaven�");
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
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br/>
                <a href="second_help.php" class="lightlink">&laquo; N�pov�da: Druhotn� procesy</a> &nbsp; | &nbsp;
                <a href="config_help.php" class="lightlink">N�pov�da: Z�kladn� nastaven� &raquo;</a>
            </p>
            <span class="largeheader">N�pov�da: Nastaven�</span>
            <p class="smaller menu">
                <a href="#config" class="lightlink">Konfigurace</a> &nbsp; | &nbsp;
                <a href="#diag" class="lightlink">Diagnostika</a> &nbsp; | &nbsp;
                <a href="#tables" class="lightlink">Vytvo�en� tabulek</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a name="config"><p class="subheadbold">Konfigurace</p></a>
            <p>Tato str�nka je p��stupov�m m�stem pro nastaven� r�zn�ch oblast� TNG. �prava nastaven� v ka�d� oblasti se odraz� na vzhledu va�ich webov�ch str�nek, na
                datab�zi MySQL a dal��ch mo�nostech. Zm�na dal��ch nastaven� ovlivn� zobrazen� r�zn�ch str�nek.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="diag"><p class="subheadbold">Diagnostika</p></a>

            <span class="optionhead">Spustit diagnostiku</span>
            <p>Tato str�nka zobraz� informace o nastaven� va�eho webov�ho serveru, v�etn� varov�n� t�kaj�c�ho se nastaven�, kter� mohou ovlivnit b�h TNG.</p>

            <span class="optionhead">Informace o PHP</span>
            <p>Tato str�nka zobraz� informace o instalaci PHP. Zobrazen� t�chto informac� je funkc� PHP, nikoli TNG. Str�nka je rozd�lena do blok�,
                kter� popisuj� jednotliv� oblasti konfigurace. Pokud se nejste schopni p�ipojit k datab�zi MySQL, pod�vejte se na tuto str�nku a vyhledejte odstavec "mysql".
                Pokud jej nevid�te, znamen� to, �e PHP je�t� nekomunikuje s MySQL. Probl�m by m�l b�t v nastaven� PHP, ne TNG.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="diag"><p class="subheadbold">Vytvo�en� tabulek</p></a>

            <span class="optionhead">Vytvo�it tabulky</span>
            <p>Na toto tla��tko klikn�te <strong>POUZE</strong>, kdy� va�i str�nku nastavujete poprv�, proto�e zde budou vytvo�eny datab�zov� tabulky pot�ebn�
                k ulo�en� va�ich �daj�. <strong>Pozn.: Pokud tabulky ji� existuj�, v�echna data budou ztracena!</strong> Tuto operaci m��ete prov�st,
                pokud byla va�e data po�kozena a maj� b�t po nov�m vytvo�en� tabulek obnovena ze z�lohy.</p>

            <span class="optionhead">Porovn�v�n�</span>
            <p>Pokud pou��v�te znakovou sadu UTF-8, m��ete do tohoto pole p�ed vytvo�en�m tabulek zadat utf8_unicode_ci, utf8_general_ci nebo utf8_czech_ci.
                V ostatn�ch p��padech, ponech�te-li toto pole pr�zdn�, p�ijmete v�choz� porovn�v�n�.</p>
        </td>
    </tr>

</table>
</body>
</html>

<?php
include "../../helplib.php";
echo help_header("N�pov�da: Nastaven� protokolov�n�");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="pedconfig_help.php" class="lightlink">&laquo; N�pov�da: Nastaven� sch�mat</a> &nbsp;|&nbsp;
                <a href="importconfig_help.php" class="lightlink">N�pov�da: Nastaven� importu &raquo;</a>
            </p>
            <h2 class="largeheader">N�pov�da: <small>Nastaven� protokolov�n�</small></h2>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">
            <h5 class="optionhead">N�zev souboru protokolu</h5>
            <p>N�zev souboru protokolu je soubor, kam jsou zaznamen�v�ny akce n�v�t�vn�k�. P�vodn� n�zev "genlog.txt" byste nem�li m�nit.</p>

            <h5 class="optionhead">Maxim�ln� po�et ��dk� v protokolu</h5>
            <p>Maxim�ln� po�et ��dk� v protokolu ur�uje, kolik akc� by m�l protokol aktu�ln� uchov�vat.
                Je-li toto ��slo p��li� velk�, m��e se objevit ke sn�en� v�konu.</p>

            <h5 class="optionhead">Vylou�it n�zvy hostitele</h5>
            <p>P�ed proveden�m z�pisu do protokolu TNG tento seznam otestuje. Pokud hostitel n�v�t�vn�ka podl�haj� p��padn�mu z�pisu do protokolu
                je v seznamu, nebude proveden ��dn� z�pis. N�zvy hostitel� by m�ly b�t odd�leny ��rkami (bez mezer) a maj� obsahovat �pln�
                n�zev hostitele, IP adresu nebo ��sti obou. Nap�. "googlebot" bude blokovat "crawler4.googlebot.com".</p>

            <h5 class="optionhead">Vylou�it u�ivatelsk� jm�na</h5>
            <p>P�ed proveden�m z�pisu do protokolu TNG tento seznam otestuje tak�. Pokud je p�ihl�en� u�ivatel
                v seznamu, nebude proveden ��dn� z�pis. U�ivatelsk� jm�na by m�la b�t odd�lena ��rkami (bez mezer).</p>

            <h5 class="optionhead">N�zev souboru protokolu (Admin)</h5>
            <p>N�zev souboru protokolu, kam jsou zaznamen�v�ny akce z administr�torsk� oblasti. P�vodn� n�zev "adminlog.txt" byste nem�li m�nit.</p>

            <h5 class="optionhead">Maxim�ln� po�et ��dk� v protokolu (Admin)</h5>
            <p>Maxim�ln� po�et ��dk� v protokolu ur�uje, kolik akc� by m�l protokol administr�tora aktu�ln� uchov�vat. Je-li toto ��slo p��li� velk�,
                m��e se objevit ke sn�en� v�konu.</p>

            <h5 class="optionhead">Zablokovat n�vrhy nebo nov� u�ivatelsk� registrace</h5></p>

            <h5 class="optionhead">Adresa obsahuje</h5>
            <p>Blokuje v�echny p��choz� n�vrhy nebo nov� u�ivatelsk� registrace, kde emailov� adresa odes�latele obsahuje n�jak� ze zapsan�ch slov
                nebo ��st� slov.
                V�ce slov odd�lujte ��rkou.</p>

            <h5 class="optionhead">Zpr�va obsahuje</h5>
            <p>Blokuje v�echny p��choz� n�vrhy nebo nov� u�ivatelsk� registrace, kde t�lo zpr�vy obsahuje n�jak� ze zapsan�ch slov nebo ��st� slov.
                V�ce slov odd�lujte ��rkou.</p>
        </td>
    </tr>

</table>
</body>
<?php echo "</html>"; ?>

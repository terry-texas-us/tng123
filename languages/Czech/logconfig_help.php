<?php
include "../../helplib.php";
echo help_header("N�pov�da: Nastaven� protokolov�n�");
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
        <a href="pedconfig_help.php" class="lightlink">&laquo; N�pov�da: Nastaven� sch�mat</a> &nbsp; | &nbsp;
        <a href="importconfig_help.php" class="lightlink">N�pov�da: Nastaven� importu &raquo;</a>
      </p>
      <span class="largeheader">N�pov�da: Nastaven� protokolov�n�</span>
    </td>
  </tr>
  <tr class="databack">
    <td class="tngshadow">
      <span class="optionhead">N�zev souboru protokolu</span>
      <p>N�zev souboru protokolu je soubor, kam jsou zaznamen�v�ny akce n�v�t�vn�k�. P�vodn� n�zev "genlog.txt" byste nem�li m�nit.</p>

            <span class="optionhead">Maxim�ln� po�et ��dk� v protokolu</span>
            <p>Maxim�ln� po�et ��dk� v protokolu ur�uje, kolik akc� by m�l protokol aktu�ln� uchov�vat.
                Je-li toto ��slo p��li� velk�, m��e se objevit ke sn�en� v�konu.</p>

            <span class="optionhead">Vylou�it n�zvy hostitele</span>
            <p>P�ed proveden�m z�pisu do protokolu TNG tento seznam otestuje. Pokud hostitel n�v�t�vn�ka podl�haj� p��padn�mu z�pisu do protokolu
                je v seznamu, nebude proveden ��dn� z�pis. N�zvy hostitel� by m�ly b�t odd�leny ��rkami (bez mezer) a maj� obsahovat �pln�
                n�zev hostitele, IP adresu nebo ��sti obou. Nap�. "googlebot" bude blokovat "crawler4.googlebot.com".</p>

            <span class="optionhead">Vylou�it u�ivatelsk� jm�na</span>
            <p>P�ed proveden�m z�pisu do protokolu TNG tento seznam otestuje tak�. Pokud je p�ihl�en� u�ivatel
                v seznamu, nebude proveden ��dn� z�pis. U�ivatelsk� jm�na by m�la b�t odd�lena ��rkami (bez mezer).</p>

            <span class="optionhead">N�zev souboru protokolu (Admin)</span>
            <p>N�zev souboru protokolu, kam jsou zaznamen�v�ny akce z administr�torsk� oblasti. P�vodn� n�zev "adminlog.txt" byste nem�li m�nit.</p>

            <span class="optionhead">Maxim�ln� po�et ��dk� v protokolu (Admin)</span>
            <p>Maxim�ln� po�et ��dk� v protokolu ur�uje, kolik akc� by m�l protokol administr�tora aktu�ln� uchov�vat. Je-li toto ��slo p��li� velk�, m��e se objevit ke sn�en� v�konu.</p>

            <span class="optionhead">Zablokovat n�vrhy nebo nov� u�ivatelsk� registrace</span></p>

            <span class="optionhead">Adresa obsahuje</span>
            <p>Blokuje v�echny p��choz� n�vrhy nebo nov� u�ivatelsk� registrace, kde emailov� adresa odes�latele obsahuje n�jak� ze zapsan�ch slov nebo ��st� slov.
                V�ce slov odd�lujte ��rkou.</p>

            <span class="optionhead">Zpr�va obsahuje</span>
            <p>Blokuje v�echny p��choz� n�vrhy nebo nov� u�ivatelsk� registrace, kde t�lo zpr�vy obsahuje n�jak� ze zapsan�ch slov nebo ��st� slov.
                V�ce slov odd�lujte ��rkou.</p>
        </td>
    </tr>

</table>
</body>
</html>

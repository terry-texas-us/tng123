<?php
include "../../helplib.php";
echo help_header("N�pov�da: Spojen�");
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp; | &nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="repositories_help.php" class="lightlink">&laquo; N�pov�da: �lo�i�t� pramen�</a> &nbsp; | &nbsp;
                <a href="notes_help.php" class="lightlink">N�pov�da: Pozn�mky &raquo;</a>
            </p>
            <h2 class="largeheader">N�pov�da: <small>Spojen�</small></h2>
            <p class="smaller menu">
                <a href="#what" class="lightlink">Co to je?</a> &nbsp; | &nbsp;
                <a href="#add" class="lightlink">P�idat/Upravit/Odstranit</a>
            </p>
        </td>
    </tr>

    <tr class="databack">
        <td class="tngshadow">
            <a id="what"><h4 class="subheadbold">Co jsou spojen�?</h4></a>

            <p><strong>Spojen�</strong> je z�znam vztahu mezi dv�ma osobami, mezi dv�ma rodinami nebo mezi osobou a rodinou.
                Ze stromov� struktury va�� datab�ze nemus� b�t vztah z�ejm�. Ve skute�nosti dv� osoby/rodiny, kter� jsou propojeny
                pomoc� spojen�, nemus� b�t v�bec p��buzn�.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="add"><h4 class="subheadbold">P�id�n�/�prava/Odstran�n� spojen�</h4></a>

            <p>Chcete-li p�idat, upravit nebo odstranit spojen� u osoby, vyhledejte osobu v Administrace/Osoba a upravte
                individu�ln� z�znam, a pot� klikn�te na ikonu Spojen� v horn� ��sti obrazovky (pokud spojen� ji� existuj�,
                na ikon� je zelen� te�ka). Po kliknut� na ikonu se objev� mal� okno, kde jsou zobrazena v�echna existuj�c� spojen�
                pro aktivn� osobu. Chcete-li pracovat se spojen�mi u rodin, vyhledejte rodinu v Administrace/Rodiny
                a upravte z�znam rodiny, pot� prove�te tot� jako v p��pad� osoby.</p>

            <p>Chcete-li p�idat nov� spojen�, klikn�te na tla��tko "P�idat nov�" a vypl�te formul��. Pokud vybran� osoba nebo rodina nemaj� ��dn�
                spojen�,
                dostanete se p��mo na obrazovku "P�idat nov� spojen�". Na t�to obrazovce budete moci ozna�it,
                zda spojovan� entita je osoba nebo rodina.</p>

            <p>Chcete-li upravit nebo odstranit existuj�c� spojen�, klikn�te na p��slu�nou ikonu vedle tohoto spojen�.</p>

            <p>P�i p�id�n� nebo �prav� spojen� m�jte na pam�ti n�sleduj�c�:</p>

            <h5 class="optionhead">ID ��sla osoby nebo rodiny</h5>
            <p>Zapi�te ID ��slo osoby nebo rodiny, kter� m� b�t spojena s aktivn� osobou nebo rodinou, nebo klikn�te na ikonu Naj�t a vyhledejte ID
                ��slo.</p>

            <h5 class="optionhead">Vztah</h5>
            <p>Zapi�te povahu spojen�. Nap�. <em>Kmotr</em>, <em>U�itel</em> nebo <em>Sv�dek</em>.</p>

            <h5 class="optionhead">Obr�cen� spojen�?</h5>
            <p>N�kdy jde spojen� ob�ma sm�ry. Nap�. vztah <em>P��tel</em> m��e m�t p�sobnost ob�ma sm�ry. Je-li to pravda,
                a chcete vytvo�it druh� spojen� jdouc� opa�n�m sm�rem, pak klikn�te na tuto volbu. Pokud povaha vztahu nen� takov�, �e by
                platila i v opa�n�m sm�ru (nap�. <em>Kmotr</em> nebo <em>U�itel</em>), pak byste m�li vytvo�it jin� spojen�, za��naj�c�
                od druh� osoby nebo rodiny, kter� zobraz� opa�n� vztah.</p>

            <p>Po ukon�en� p�id�n�, �pravy nebo odstran�n� spojen� u dan� osoby nebo rodiny klikn�te na tla��tko "Ukon�it" a okno se uzav�e.</p>

        </td>
    </tr>

</table>
</body>
</html>

<?php
include("../../helplib.php");
echo help_header("N�pov�da: Citace");
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
                <a href="notes_help.php" class="lightlink">&laquo; N�pov�da: Pozn�mky</a> &nbsp; | &nbsp;
                <a href="events_help.php" class="lightlink">N�pov�da: Ud�losti &raquo;</a>
            </p>
            <span class="largeheader">N�pov�da: Citace</span>
            <p class="smaller menu">
                <a href="#what" class="lightlink">Co je to?</a> &nbsp; | &nbsp;
                <a href="#add" class="lightlink">P�idat/Upravit/Vymazat</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a name="what"><p class="subheadbold">Co jsou to citace?</p></a>

            <p><strong>Citace</strong> je odkaz na z�znam pramenu, proveden� s �myslem prok�zat pravdivost n�jak�ho �daje. Pramen obvykle
                v�eobecn� popisuje, kde byl uveden� �daj nalezen (nap�. matrika nebo s��tac� arch), zat�mco citace obvykle obsahuje konkr�tn� informaci (nap�. na kter� str�nce).
                Jeden z�znam pramenu m��e b�t citov�n v�cekr�t u r�zn�ch osob, rodin, pozn�mek nebo ud�lost�.</p>


        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a name="add"><p class="subheadbold">P�idat/Upravit/Vymazat citace</p></a>

            <p>Chcete-li p�idat, upravit nebo vymazat citace, klikn�te na ikonu Citace na str�nce naho�e nebo vedle n�jak� pozn�mky nebo ud�losti (pokud ji� citace existuje,
                na ikon� je zelen� te�ka). Po kliknut� na ikonu se objev� okno, ve kter�m jsou zobrazeny
                v�echny citace existuj�c� pro aktivn� subjekt nebo ud�lost.</p>

            <p>Chcete-li p�idat novou citaci, klikn�te na tla��tko "P�idat nov�" a vypl�te formul��. Pokud vybran� subjekt nebo ud�lost je�t� nem�ly ��dn�
                citace, dostanete se p��mo na obrazovku "P�idat novou citaci".</p>

            <p>Pokud chcete existuj�c� citaci upravit nebo vymazat, klikn�te na p��slu�nou ikonu vedle t�to citace.</p>

            <p>P�i p�id�n� nebo �prav� citace si v�imn�te n�sleduj�c�ho:</p>

            <span class="optionhead">ID ��slo pramenu</span>
            <p>Zapi�te ID ��slo pramenu, kter� m� b�t citov�n, nebo klikn�te na tla��tko "Naj�t" pro jeho nalezen�. Pokud pramen je�t� nebyl vytvo�en,
                p�ejd�te do Admin/Prameny a vytvo�te pramen v p��slu�n�m strom�. Pot� se vra�te do seznamu citac� nebo m��ete kliknout na tla��tko "Vytvo�it"
                pro z�pis �daj� o nov�m pramenu. Po ulo�en� �daj� bude do tohoto pole vlo�eno nov� ID ��slo pramenu.</p>
            <p>Pokud jste ji� b�hem sv� aktu�ln� relace pro stejn� typ subjektu (osoba, rodina, atd.) vytvo�ili n�jakou citaci, uvid�te tak� tla��tko "Kop�rovat posledn�". Kliknut�
                na toto tla��tko budou v�echna pole vypln�na stejn�mi �daji, jako jste pou�ili ve sv� minul� citaci.</p>

            <!--<span class="optionhead">Description</span>
        <p>If your desktop genealogy program does not assign ID numbers to your sources, your citation will have a Description instead. You will not see
        the Description field for a new citation.</p>-->

            <span class="optionhead">Strana</span>
            <p>Zapi�te str�nku, na kter� se ve vybran�m pramenu nach�z� tato ud�lost (voliteln�).</p>

            <span class="optionhead">V�rohodnost</span>
            <p>Vyberte ��slo (0-3), kter� ozna�uje, na kolik je tento pramen v�rohodn� (voliteln�). Vy��� ��sla ozna�uj� v�t�� v�rohodnost.</p>

            <span class="optionhead">Datum citace</span>
            <p>Datum spojen� s touto citac� (voliteln�).</p>

            <span class="optionhead">Vlastn� text</span>
            <p>Kr�tk� v��atek z materi�lu pramenu (voliteln�).</p>

            <span class="optionhead">Pozn�mky</span>
            <p>U�ite�n� pozn�mky, kter� se t�kaj� tohoto pramenu (voliteln�).</p>

        </td>
    </tr>

</table>
</body>
</html>

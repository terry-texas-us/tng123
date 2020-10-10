<?php
include "../../helplib.php";
echo help_header("N�pov�da: Citace");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="notes_help.php" class="lightlink">&laquo; N�pov�da: Pozn�mky</a> &nbsp;|&nbsp;
                <a href="events_help.php" class="lightlink">N�pov�da: Ud�losti &raquo;</a>
            </p>
            <h2 class="largeheader">N�pov�da: <small>Citace</small></h2>
            <p class="smaller menu" style="clear: both;">
                <a href="#what" class="lightlink">Co je to?</a> &nbsp;|&nbsp;
                <a href="#add" class="lightlink">P�idat/Upravit/Vymazat</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="what"><h4 class="subheadbold">Co jsou to citace?</h4></a>

            <p><strong>Citace</strong> je odkaz na z�znam pramenu, proveden� s �myslem prok�zat pravdivost n�jak�ho �daje. Pramen obvykle
                v�eobecn� popisuje, kde byl uveden� �daj nalezen (nap�. matrika nebo s��tac� arch), zat�mco citace obvykle obsahuje konkr�tn�
                informaci (nap�. na kter� str�nce).
                Jeden z�znam pramenu m��e b�t citov�n v�cekr�t u r�zn�ch osob, rodin, pozn�mek nebo ud�lost�.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="add"><h4 class="subheadbold">P�idat/Upravit/Vymazat citace</h4></a>

            <p>Chcete-li p�idat, upravit nebo vymazat citace, klikn�te na ikonu Citace na str�nce naho�e nebo vedle n�jak� pozn�mky nebo ud�losti
                (pokud ji� citace existuje,
                na ikon� je zelen� te�ka). Po kliknut� na ikonu se objev� okno, ve kter�m jsou zobrazeny
                v�echny citace existuj�c� pro aktivn� subjekt nebo ud�lost.</p>

            <p>Chcete-li p�idat novou citaci, klikn�te na tla��tko "P�idat nov�" a vypl�te formul��. Pokud vybran� subjekt nebo ud�lost je�t� nem�ly
                ��dn�
                citace, dostanete se p��mo na obrazovku "P�idat novou citaci".</p>

            <p>Pokud chcete existuj�c� citaci upravit nebo vymazat, klikn�te na p��slu�nou ikonu vedle t�to citace.</p>

            <p>P�i p�id�n� nebo �prav� citace si v�imn�te n�sleduj�c�ho:</p>

            <h5>ID ��slo pramenu</h5>
            <p>Zapi�te ID ��slo pramenu, kter� m� b�t citov�n, nebo klikn�te na tla��tko "Naj�t" pro jeho nalezen�. Pokud pramen je�t� nebyl vytvo�en,
                p�ejd�te do Admin/Prameny a vytvo�te pramen v p��slu�n�m strom�. Pot� se vra�te do seznamu citac� nebo m��ete kliknout na tla��tko
                "Vytvo�it"
                pro z�pis �daj� o nov�m pramenu. Po ulo�en� �daj� bude do tohoto pole vlo�eno nov� ID ��slo pramenu.</p>
            <p>Pokud jste ji� b�hem sv� aktu�ln� relace pro stejn� typ subjektu (osoba, rodina, atd.) vytvo�ili n�jakou citaci, uvid�te tak� tla��tko
                "Kop�rovat posledn�". Kliknut�
                na toto tla��tko budou v�echna pole vypln�na stejn�mi �daji, jako jste pou�ili ve sv� minul� citaci.</p>

            <!--<h5>Description</h5>
        <p>If your desktop genealogy program does not assign ID numbers to your sources, your citation will have a Description instead. You will not see
        the Description field for a new citation.</p>-->

            <h5>Strana</h5>
            <p>Zapi�te str�nku, na kter� se ve vybran�m pramenu nach�z� tato ud�lost (voliteln�).</p>

            <h5>V�rohodnost</h5>
            <p>Vyberte ��slo (0-3), kter� ozna�uje, na kolik je tento pramen v�rohodn� (voliteln�). Vy��� ��sla ozna�uj� v�t�� v�rohodnost.</p>

            <h5>Datum citace</h5>
            <p>Datum spojen� s touto citac� (voliteln�).</p>

            <h5>Vlastn� text</h5>
            <p>Kr�tk� v��atek z materi�lu pramenu (voliteln�).</p>

            <h5>Pozn�mky</h5>
            <p>U�ite�n� pozn�mky, kter� se t�kaj� tohoto pramenu (voliteln�).</p>

        </td>
    </tr>

</table>
</body>
<?php echo "</html>"; ?>

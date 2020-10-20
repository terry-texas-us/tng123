<?php
include "../../helplib.php";
echo help_header("N�pov�da: Pozn�mky");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="assoc_help.php" class="lightlink">&laquo; N�pov�da: Spojen�</a> &nbsp;|&nbsp;
                <a href="citations_help.php" class="lightlink">N�pov�da: Citace &raquo;</a>
            </p>
            <h2 class="largeheader">N�pov�da: <small>Pozn�mky</small></h2>
            <p class="smaller menu clear-both">
                <a href="#add" class="lightlink">P�idat/Upravit/Vymazat</a> &nbsp;|&nbsp;
                <a href="#cite" class="lightlink">Citace</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="add"><h4 class="subheadbold">P�idat/Upravit/Vymazat pozn�mky</h4></a>

            <p>Chcete-li p�idat, upravit nebo vymazat pozn�mky u osoby, rodiny, pramene, �lo�i�t� pramen� nebo ud�losti, klikn�te na ikonu Pozn�mky na
                str�nce naho�e nebo vedle n�jak� ud�losti (pokud ji� pozn�mky existuj�,
                na ikon� je zelen� te�ka). Po kliknut� na ikonu se objev� okno, ve kter�m jsou zobrazeny
                v�echny pozn�mky existuj�c� pro aktivn� subjekt nebo ud�lost.</p>

            <p>Chcete-li p�idat novou pozn�mku, klikn�te na tla��tko "P�idat nov�" a vypl�te formul��. Pokud vybran� subjekt nebo ud�lost je�t� nem�ly
                ��dn�
                pozn�mky, dostanete se p��mo na obrazovku "P�idat novou pozn�mku".</p>

            <p>Pokud chcete existuj�c� pozn�mku upravit nebo vymazat, klikn�te na p��slu�nou ikonu vedle t�to pozn�mky.</p>

            <p>P�id�v�te-li nebo upravujete-li pozn�mku, zapisujte, pros�m, va�i pozn�mku nebo va�e zm�ny do velk�ho pole <strong>Pozn�mka</strong> a
                pak klikn�te na tla��tko "Ulo�it". Pozn�mky budou ulo�eny v tomto okam�iku, i kdy� t�eba je�t�
                u aktivn�ho subjektu nejsou ��dn� jin� �daje. Do pole m��ete zapsat HTML k�d. K�dy PHP a Javascript nebudou pracovat.</p>

            <p>Chcete-li pozn�mky p�et��dit, klikn�te kamkoli na ��dek (ne na ikonu) a p�et�hn�te pozn�mku nahoru nebo dol�.</p>

            <h5>Neve�ejn�</h5>
            <p>Za�krtnut�m tohoto pol��ka zamez�te zobrazen� pozn�mky ve ve�ejn� oblasti. Nez�vis� to na ozna�en� Neve�ejn�, kter� m��e b�t spojeno s
                osobou
                nebo rodinou.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="cite"><h4 class="subheadbold">P�id�n� citac� pramen� k pozn�mk�m</h4></a>
            <p>Chcete-li p�idat nebo upravit citaci pramen� u pozn�mky, pozn�mku nejprve ulo�te a pot� klikn�te na ikonu Citace vedle z�znamu t�to
                pozn�mky v aktu�ln�m seznamu pozn�mek.
                V�ce informac� o citac�ch se dozv�te zde: <a href="citations_help.php">N�pov�da: Citace</a>.</p>

        </td>
    </tr>

</table>
</body>
<?php echo "</html>"; ?>

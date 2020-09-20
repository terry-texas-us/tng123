<?php
include "../../helplib.php";
echo help_header("Nápověda: Nastavení");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="second_help.php" class="lightlink">&laquo; Nápověda: Druhotné procesy</a> &nbsp;|&nbsp;
                <a href="config_help.php" class="lightlink">Nápověda: Základní nastavení &raquo;</a>
            </p>
            <h2 class="largeheader">Nápověda: <small>Nastavení</small></h2>
            <p class="smaller menu" style="clear: both;">
                <a href="#config" class="lightlink">Konfigurace</a> &nbsp;|&nbsp;
                <a href="#diag" class="lightlink">Diagnostika</a> &nbsp;|&nbsp;
                <a href="#tables" class="lightlink">Vytvoření tabulek</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="config"><h4 class="subheadbold">Konfigurace</h4></a>
            <p>Tato stránka je přístupovým místem pro nastavení různých oblastí TNG. Úprava nastavení v každé oblasti se odrazí na vzhledu vašich
                webových stránek, na
                databázi MySQL a dalších možnostech. Změna dalších nastavení ovlivní zobrazení různých stránek.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="diag"><h4 class="subheadbold">Diagnostika</h4></a>

            <h5 class="optionhead">Spustit diagnostiku</h5>
            <p>Tato stránka zobrazí informace o nastavení vašeho webového serveru, včetně varování týkajícího se nastavení, která mohou ovlivnit běh
                TNG.</p>

            <h5 class="optionhead">Informace o PHP</h5>
            <p>Tato stránka zobrazí informace o instalaci PHP. Zobrazení těchto informací je funkcí PHP, nikoli TNG. Stránka je rozdělena do bloků,
                které popisují jednotlivé oblasti konfigurace. Pokud se nejste schopni připojit k databázi MySQL, podívejte se na tuto stránku a
                vyhledejte odstavec "mysql".
                Pokud jej nevidíte, znamená to, že PHP ještě nekomunikuje s MySQL. Problém by měl být v nastavení PHP, ne TNG.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="tables"><h4 class="subheadbold">Vytvoření tabulek</h4></a>

            <h5 class="optionhead">Vytvořit tabulky</h5>
            <p>Na toto tlačítko klikněte <strong>POUZE</strong>, když vaši stránku nastavujete poprvé, protože zde budou vytvořeny databázové tabulky
                potřebné
                k uložení vašich údajů. <strong>Pozn.: Pokud tabulky již existují, všechna data budou ztracena!</strong> Tuto operaci můžete provést,
                pokud byla vaše data poškozena a mají být po novém vytvoření tabulek obnovena ze zálohy.</p>

            <h5 class="optionhead">Porovnávání</h5>
            <p>Pokud používáte znakovou sadu UTF-8, můžete do tohoto pole před vytvořením tabulek zadat utf8_unicode_ci, utf8_general_ci nebo
                utf8_czech_ci.
                V ostatních případech, ponecháte-li toto pole prázdné, přijmete výchozí porovnávání.</p>
        </td>
    </tr>

</table>
</body>
<?php echo "</html>"; ?>

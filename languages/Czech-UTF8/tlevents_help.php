<?php
include "../../helplib.php";
echo help_header("Nápověda: Události časové osy");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="places_googlemap_help.php" class="lightlink">&laquo; Nápověda: Google Maps</a> &nbsp;|&nbsp;
                <a href="notes2_help.php" class="lightlink">Nápověda: Poznámky &raquo;</a>
            </p>
            <h2 class="largeheader">Nápověda: <small>Události časové osy</small></h2>
            <p class="smaller menu clear-both">
                <a href="#search" class="lightlink">Hledat</a> &nbsp;|&nbsp;
                <a href="#add" class="lightlink">Přidat nebo Upravit</a> &nbsp;|&nbsp;
                <a href="#delete" class="lightlink">Vymazat</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="search"><h4 class="subheadbold">Hledat</h4></a>
            <p>Nalezení existujících událostí časové osy vyhledáním celého nebo části <strong>roku události</strong> nebo <strong>podrobností
                    události</strong>.
                Výsledkem hledání bez zadaných voleb a hodnot ve vyhledávacích polích bude seznam všech míst ve vaší databázi.</p>

            <p>Vyhledávací kritéria, která zadáte na této stránce, budou uchována, dokud nekliknete na tlačítko <strong>Obnovit</strong>, které znovu
                obnoví všechny výchozí hodnoty.</p>

            <h5>Akce</h5>
            <p>Tlačítko Akce vedle každého výsledku hledání vám umožní upravit, odstranit nebo otestovat tento výsledek. Chcete-li najednou vymazat
                více záznamů, zaškrtněte políčko ve sloupci
                <strong>Vybrat</strong> u každého záznamu, která má být vymazán a poté klikněte na tlačítko "Vymazat označené" na začátku seznamu. Pro
                zaškrtnutí nebo vyčištění všech výběrových políček najednou
                můžete použít tlačítka <strong>Vybrat vše</strong> nebo <strong>Vyčistit vše</strong>.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="add"><h4 class="subheadbold">Přidat novou / Upravit existující události časové osy</h4></a>
            <p>TNG umožňuje zobrazení schématu časové osy pro porovnání rozsahu života osob ve vaší databázi.
                Rozšířit souvislosti těchto schémat můžete také vytvořením událostí časové osy. Pokud roky, které pokrývá
                schéma časové osy, obsahují údaje spojené s těmito událostmi, jsou ve schématu zobrazeny jako
                zápatí. Tyto události lze využít pouze v TNG, nelze je exportovat do souboru GEDCOM.</p>

            <p>Chcete-li přidat novou událost časové osy, klikněte na záložku <strong>Přidat novou</strong> a poté vyplňte formulář.
            <p>Chcete-li upravit existující událost, použijte
                záložku <a href="#search">Hledat</a> pro nalezení události, a poté klikněte na ikonu Upravit vedle tohoto řádku.</p>
            Význam jednotlivých polí při přidání nebo úpravě události časové osy je následující:</p>

            <h5>Počáteční datum / Konečné datum</h5>
            <p>Vyberte všechny známé složky (den, měsíc, rok) počátečního a konečného data události. Povinný je pouze rok počátečního data.
                Zapíšete-li nějakou složku konečného data, pak je také zde povinný rok.</p>

            <h5>Titul události</h5>
            <p>Zadejte velmi krátký titul události. Např. <em>Potopení Titanicu</em> nebo <em>1. světová válka</em>. Toto pole bylo zavedeno v TNG
                9.0. Události
                časové osy přidané před touto verzí nemají titul. V tomto případě budou jako Titul události použity Podrobnosti události.</p>

            <h5>Podrobnosti události</h5>
            <p>Zapište stručný popis události. Měl by obsahovat pouze několik vět.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="delete"><h4 class="subheadbold">Vymazat události časové osy</h4></a>
            <p>Chcete-li odstranit událost časové osy, použijte záložku <a href="#search">Hledat</a> pro nalezení události, a poté klikněte na ikonu
                Vymazat vedle tohoto záznamu události. Tento řádek změní
                barvu a poté po odstranění události zmizí. Chcete-li najednou odstranit více událostí, zaškrtněte políčko ve sloupci Vybrat vedle
                každé události, kterou
                chcete odstranit, a poté klikněte na tlačítko "Vymazat označené" na stránce nahoře</p>

        </td>
    </tr>

</table>
</body>
<?php echo "</html>"; ?>

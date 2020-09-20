<?php
include "../../helplib.php";
echo help_header("Nápověda: Jazyky");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="dna_help.php" class="lightlink">&laquo; Nápověda: Testy DNA</a> &nbsp;|&nbsp;
                <a href="backuprestore_help.php" class="lightlink">Nápověda: Obslužné programy &raquo;</a>
            </p>
            <h2 class="largeheader">Nápověda: <small>Jazyky</small></h2>
            <p class="smaller menu" style="clear: both;">
                <a href="#search" class="lightlink">Hledat</a> &nbsp;|&nbsp;
                <a href="#add" class="lightlink">Přidat nebo upravit</a> &nbsp;|&nbsp;
                <a href="#delete" class="lightlink">Vymazat</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="search"><h4 class="subheadbold">Hledat</h4></a>
            <p>Nalezení existujících jazyků vyhledáním celého nebo části <strong>názvu pro zobrazení</strong> nebo <strong>názvu složky</strong>.
                Výsledkem hledání bez zadaných voleb a hodnot ve vyhledávacích polích bude seznam všech jazyků ve vaší databázi.</p>

            <p>Vyhledávací kritéria, která zadáte na této stránce, budou uchována, dokud nekliknete na tlačítko <strong>Obnovit</strong>, které znovu
                obnoví všechny výchozí hodnoty.</p>

            <h5 class="optionhead">Akce</h5>
            <p>Tlačítko Akce vedle každého výsledku hledání vám umožní upravit nebo odstranit tento jazyk.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="add"><h4 class="subheadbold">Přidat nový / Upravit existující jazyky</h4></a>
            <p>TNG zobrazuje programové výrazy, které byly přeloženy do několika různých jazyků. Chcete-li umožnit návštěvníkům vašich stránek
                zobrazit stránky mimo vašeho výchozího jazyka
                také v jiných jazycích, musíte zde pro každý jazyk, který má být podporován, přidat záznam, <strong>včetně</strong> svého výchozího
                jazyka. Např.
                je-li vašim výchozím jazykem čeština a chcete také podporovat angličtinu, musíte v Admin/Jazyky přidat záznam pro češtinu i
                angličtinu.</p>

            <p>Chcete-li přidat nový jazyk, klikněte na záložku <strong>Přidat nový</strong> a poté vyplňte formulář.
                Význam jednotlivých polí je následující:</p>

            <h5 class="optionhead">Složka jazyku</h5>
            <p>Pro výběr umístění souboru pro jazyk použijte rozbalovací seznam. Pokud váš nový jazyk potřebuje znakovou sadu UTF-8, vyberte složku s
                "UTF8" v názvu.
                Chcete-li podporovat nový jazyk, který ještě není podporován programem TNG, přidejte do složky TNG jazyků složku pro tento jazyk, a
                pak se vraťte na tuto stránku a vyberte ji.</p>

            <h5 class="optionhead">Název tohoto jazyku, jak bude zobrazen návštěvníkům</h5>
            <p>Zadejte název jazyku, jak bude zobrazen návštěvníkům v poli pro výběr jazyků. Je vhodné vložit tento název v tomto příslušném jazyce,
                aby jej mohli návštěvníci snáze identifikovat. Např. použijte "English" místo "Angličtina".</p>

            <h5 class="optionhead">Znaková sada</h5>
            <p>Znaková sada použitá pro tento jazyk. Necháte-li toto pole prázdné, bude použita znaková sada ISO-8859-1. Čeština používá znakovou sadu
                ISO-8859-2 nebo UTF-8</p>

            <h5 class="optionhead">Povinná pole:</h5> Zadat musíte název jazyku pro zobrazení a zvolit musíte název složky jazyku.</p>

            <p><strong>DŮLEŽITÉ:</strong> Pokud uvažujete o umožnění dynamického přepínání jazyků, <strong>musíte nastavit váš výchozí jazyk</strong>
                (v Nastavení/Základní nastavení) jako jazyk těchto stránek.
                Pokud jej nenastavíte, nebudete se moci po přepnutí na jiný jazyk přepnout zpět na váš výchozí jazyk.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="delete"><h4 class="subheadbold">Vymazání jazyků</h4></a>
            <p>Chcete-li odstranit jazyk, použijte záložku <a href="#search">Hledat</a> k nalezení jazyku, a poté klikněte na ikonku Vymazat vedle
                tohoto záznamu jazyku. Tento řádek změní
                barvu a poté po odstranění jazyku zmizí. <strong>Pozn.</strong>: Příslušná složka jazyku nebude z vašich stránek vymazána.</p>

        </td>
    </tr>

</table>
</body>
<?php echo "</html>"; ?>

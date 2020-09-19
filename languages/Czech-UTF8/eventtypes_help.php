<?php
include "../../helplib.php";
echo help_header("Nápověda: Vlastní typy událostí");
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
                <a href="https://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="https://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="branches_help.php" class="lightlink">&laquo; Nápověda: Větve</a> &nbsp;|&nbsp;
                <a href="reports_help.php" class="lightlink">Nápověda: Reporty &raquo;</a>
            </p>
            <h2 class="largeheader">Nápověda: <small>Vlastní typy událostí</small></h2>
            <p class="smaller menu" style="clear: both;">
                <a href="#search" class="lightlink">Hledat</a> &nbsp;|&nbsp;
                <a href="#add" class="lightlink">Přidat nebo upravit</a> &nbsp;|&nbsp;
                <a href="#accept" class="lightlink">Přijmout nebo odmítnout</a> &nbsp;|&nbsp;
                <a href="#delete" class="lightlink">Vymazat</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="search"><h4 class="subheadbold">Hledat</h4></a>
            <p>Nalezení existujících vlastních typů událostí vyhledáním celého nebo části <strong>Tagu, Typu/popisu (pro události EVEN)</strong> nebo
                <strong>Zobrazit</strong>.
                Pro zúžení vašeho hledání vyberte <strong>Spojeno s</strong> nebo zvolte jednu z dalších možností.
                Výsledkem hledání bez zadaných voleb a hodnot ve vyhledávacích polích bude seznam všech vlastních typů událostí ve vaší databázi.
                Možnosti výběru jsou následující:</p>

            <p><h5 class="optionhead">Spojeno s</h5>
            Pro omezení výběru zvolte z tohoto rozbalovacího seznamu vlastní typy událostí spojené s osobami, rodinami, prameny nebo úložišti
            pramenů.</p>

            <p><h5 class="optionhead">Přijmout/Odmítnout/Vše</h5>
            Výběrem jedné z těchto voleb omezíte výběr vlastních typů událostí na ty, které jsou <strong>přijaty</strong>, nebo na ty,
            které jsou <strong>odmítnuty</strong>. Volba <strong>Vše</strong> neomezí výsledek výběru.</p>

            <p>Vyhledávací kritéria, která zadáte na této stránce, budou uchována, dokud nekliknete na tlačítko <strong>Obnovit</strong>, které znovu
                obnoví všechny výchozí hodnoty.</p>

            <p><h5 class="optionhead">Smazat/Přijmout/Odmítnout/Sbalit vybrané</h5>
            Klikněte na zaškrtávací políčko vedle jednoho nebo více typů událostí, a poté použijte tato tlačítka k provedení akce na všech vybraných
            typech událostí najednou.</p>

            <h5 class="optionhead">Akce</h5>
            <p>Tlačítko Akce vedle každého výsledku hledání vám umožní upravit nebo odstranit tento výsledek. Chcete-li najednou odstranit více
                záznamů,
                zaškrtněte políčko ve sloupci
                <strong>Vybrat</strong> u každého záznamu, který má být odstraněn a poté klikněte na tlačítko "Vymazat označené" na začátku seznamu.
                Pro
                zaškrtnutí nebo vyčištění všech výběrových políček najednou
                můžete použít tlačítka <strong>Vybrat vše</strong> nebo <strong>Vyčistit vše</strong>.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="add"><h4 class="subheadbold">Přidat nebo upravit vlastní typy událostí</h4></a>

            <p>Nejobvyklejší neboli "Standardní" typy událostí, jako jsou Narození, Úmrtí, Sňatek několik dalších, jsou spravovány přímo na stránkách
                osoby, rodiny, pramenu nebo úložišti pramenů.
                Všechny ostatní typy událostí jsou spojeny s "vlastními" typy událostí
                a jsou spravovány v sekcích <strong>Další události</strong> na stránkách osoby, rodiny, pramenu nebo úložiště pramenů. Před zápisem
                některé z těchto "dalších"
                událostí musíte mít záznam s ní spojeného vlastního typu události. TNG automaticky nastaví vlastní typy událostí pro všechny
                nestandardní události, které obsahuje
                váš soubor GEDCOM, ale nastavit vlastní typy událostí můžete také ručně.</p>

            <p>Chcete-li přidat nový vlastní typ události, klikněte na záložku <strong>Přidat nový</strong> a pak vyplňte formulář. Chcete-li upravit
                existující vlastní typ události, použijte
                záložku <a href="#search">Hledat</a> pro vyhledání záznamu a poté klikněte na ikonu Upravit vedle tohoto řádku.
                Význam polí při přidání nebo úpravě vlastního typ události je následující:</p>

            <h5 class="optionhead">Spojeno s</h5>
            <p>Z tohoto rozbalovacího seznamu vyberte volbu, zda je tento typ události spojen s osobou, rodinou, pramenem nebo úložištěm pramenů.
                Jednotlivý vlastní typ události může být spojen pouze z jednou z těchto možností. Volba tohoto pole
                určí, které možnosti se zobrazí v rozbalovacím seznamu Tag.</p>

            <h5 class="optionhead">Vybrat tag nebo zadat</h5>
            <p>Toto je 3 nebo 4 znaková zkratka (všechna velká písmena) nebo mnemotechnický kód.
                Většinu obvyklých nestandardních událostí obsahuje výběrové pole Tag. Pokud zde požadovaný tag nevidíte, zmůžete jej přímo zadat do
                pole pod tímto polem. Vyberete-li tag z tohoto seznamu
                A současně jej zapíšete do pole, tag, který zapíšete do pole, bude mít přednost a tag vybraný ze seznamu bude odmítnut.</p>

            <h5 class="optionhead">Type/popis</h5>
            <p>Toto pole by mělo odpovídat hodnotě "TYPE" pro tento typ události z vašeho genealogického programu. POZN.: Toto pole se zobrazí pouze,
                když vyberete
                jako tag "EVEN". U jiných tagů bude toto pole ponecháno prázdné.</p>

            <h5 class="optionhead">Zobrazit</h5>
            <p>Údaj z tohoto pole se zobrazí ve sloupci nalevo od údaje události při zobrazení ve veřejné oblasti. Pokud používáte více jazyků,
                pod tímto polem uvidíte sekci nazvanou "Další jazyky". Kliknete-li na název této sekce, zobrazí se
                zvláštní pole Zobrazit pro každý podporovaný jazyk. Chcete-li, aby byl pro každý jazyk zobrazen stejný výraz,
                vyplňte pole Zobrazit výše a nechte pole Zobrazit pro ostatní jazyky prázdné.</p>

            <h5 class="optionhead">Pořadí při zobrazení</h5>
            <p>Události, které jsou spojeny s daty, jsou řazeny chronologicky. Události bez dat jsou řazeny podle tohoto seznamu v pořadí,
                ve kterém se objeví v databázi. Pořadí tohoto seznamu lze ovlivnit zápisem v poli Pořadí v zobrazení.
                Nižší číslo způsobí, že bude událost řazena výše.</p>

            <h5 class="optionhead">Údaje události</h5>
            <p>Chcete-li přijmout importované údaje, která odpovídají tomuto vlastnímu typu události, vyberte <em>Přijmout</em>. Chcete-li data, která
                odpovídají tomuto vlastnímu typu události, nepřijmout
                a způsobit, že nebudou naimportována, vyberte <em>Odmítnout</em>. Když je událost tohoto typu naimportována, nastavením této volby
                zpět na Odmítnout
                nebude tento vlastní typ události zobrazován.</p>

            <h5 class="optionhead">Sbalit událost</h5>
            <p>Zabere-li údaj této události na stránce osoby více než jeden řádek, všechny další řádky budou ve výchozím stavu skryty.
                Návštěvníci mohou pomocí kliknutí na malý trojúhelník vedle popisu události zobrazit všechny údaje k této události.</p>

            <h5 class="optionhead">Událost CJKSpd</h5>
            <p>Pokud by tento typ události měl podléhat stejným pravidlům ochrany osobních údajů, které upravují další události CJKSpd, zvolte zde
                možnost "Ano".</p>

            <p><h5 class="optionhead">Povinná pole:</h5>Pro vaši událost musíte vybrat nebo zadat GEDCOM tag. Pokud zvolíte tag "EVEN" (obecná
            vlastní událost),
            musíte zadat také Type/popis. Pokud jako tag nezvolíte EVEN, musíte nechat pole Type/popis prázdné. Musíte také zadat řetězec
            Zobrazit.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="accept"><h4 class="subheadbold">Přijmout vybrané / Odmítnout vybrané</h4></a>
            <p>Chcete-li najednou označit vlastní typy událostí jako <strong>Přijmout</strong> nebo <strong>Odmítnout</strong>, zaškrtněte políčko
                Vybrat vedle každého vlastního typu události,
                který chcete změnit, a poté klikněte na tlačítko "Přijmout vybrané" nebo "Odmítnout vybrané" v horní části stránky.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="delete"><h4 class="subheadbold">Vymazat vlastní typy událostí</h4></a>
            <p>Chcete-li odstranit vlastní typ události, použijte záložku <a href="#search">Hledat</a> k nalezení položky, a poté klikněte na ikonku
                Vymazat vedle tohoto záznamu. Tento řádek změní
                barvu a poté po odstranění vlastního typu události zmizí. Chcete-li najednou odstranit více záznamů, zaškrtněte tlačítko ve sloupci
                Vybrat vedle každého záznamu, který má být
                odstraněn, a poté klikněte na tlačítko "Vymazat vybrané" na stránce nahoře.</p>

        </td>
    </tr>

</table>
</body>
</html>

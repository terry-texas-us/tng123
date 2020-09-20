<?php
include "../../helplib.php";
echo help_header("Nápověda: Větve");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="trees_help.php" class="lightlink">&laquo; Nápověda: Stromy</a> &nbsp;|&nbsp;
                <a href="eventtypes_help.php" class="lightlink">Nápověda: Vlastní typy událostí &raquo;</a>
            </p>
            <h2 class="largeheader">Nápověda: <small>Větve</small></h2>
            <p class="smaller menu" style="clear: both;">
                <a href="#what" class="lightlink">Co to je?</a> &nbsp;|&nbsp;
                <a href="#search" class="lightlink">Hledat</a> &nbsp;|&nbsp;
                <a href="#add" class="lightlink">Přidat nebo upravit</a> &nbsp;|&nbsp;
                <a href="#delete" class="lightlink">Vymazat</a> &nbsp;|&nbsp;
                <a href="#label" class="lightlink">Označit</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="what"><h4 class="subheadbold">Co je to větev?</h4></a>>
            <p><strong>Větev</strong> je skupina osob ve společném stromě, které jsou označeny společnou značkou. Tato značka umožňuje programu TNG
                pomocí uživatelských přístupových práv
                omezit přístup k takto označeným osobám. Jinými slovy, uživatelé, kteří jsou připojeni k určité větvi, budou mít svá přístupová práva
                omezena
                na osoby a rodiny v této větvi. Osoba v databázi může patřit do různých větví. Uživatelé mohou být připojeni nanejvýš
                k jedné větvi, ale toto omezení lze obejít vytvořením tzv. pseudovětve, jejíž název tvoří textový řetězec, který může být současně
                obsažen
                v názvu jiných větví. Např. uživatel připojen k větvi "zeman" může mít práva na větve "zemanuvsyn" i "jihlavskyzeman", protože oba
                názvy
                obsahují slovo "zeman".</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="search"><h4 class="subheadbold">Hledat</h4></a>
            <p>Nalezení existujících větví vyhledáním celého nebo části <strong>ID čísla větve</strong> nebo <strong>Popisu</strong>. Pro zúžení
                vašeho hledání vyberte strom.
                Výsledkem hledání bez zadaných voleb a hodnot ve vyhledávacích polích bude seznam všech větví ve vaší databázi.</p>

            <p>Vyhledávací kritéria, která zadáte na této stránce, budou uchována, dokud nekliknete na tlačítko <strong>Obnovit</strong>, které znovu
                obnoví všechny výchozí hodnoty.</p>

            <h5 class="optionhead">Akce</h5>
            <p>Tlačítko Akce vedle každého výsledku hledání vám umožní upravit, odstranit nebo přidat označení k této větvi. Chcete-li najednou
                odstranit více větví, zaškrtněte políčko ve sloupci
                <strong>Vybrat</strong> u každé větve, která má být odstraněna a poté klikněte na tlačítko "Vymazat označené" na začátku seznamu. Pro
                zaškrtnutí nebo vyčištění všech výběrových políček najednou
                můžete použít tlačítka <strong>Vybrat vše</strong> nebo <strong>Vyčistit vše</strong>.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="add"><h4 class="subheadbold">Přidat novou / Upravit existující větve</h4></a>
            <p>Chcete-li přidat novou větev, klikněte na záložku <strong>Přidat nový</strong> a pak vyplňte formulář.
                Význam polí je následující:</p>

            <h5 class="optionhead">ID číslo větve</h5>
            <p>Toto by měl být krátký, jednoznačný, jednoslovný identifikátor větve. Musí obsahovat pouze alfanumerické znaky (číslice a písmena).
                Nepoužívejte písmena
                s diakritikou a mezery. Tento údaj se nikde nezobrazuje, takže může být zapsán pouze malými písmeny v délce max. 20 znaků.</p>

            <h5 class="optionhead">Popis:</h5>
            <p>Toto může být delší popis větve nebo údajů, které větev obsahuje.</p>

            <h5 class="optionhead">Starting Individual</h5>
            <p>Enter or find the ID of the individual with whom your branch begins. All
                partial branches are defined by a starting individual and a number of ancestral or descendant generations from that individual. You
                can add additional names
                by repeating this process and picking a different "Starting Individual". When you save your branch, only the most recent Starting
                Individual will be remembered,
                but all labels added previously will not be affected.</p>

            <h5 class="optionhead">Výchozí osoba</h5>
            <p>Zapište nebo vyhledejte ID číslo osoby, kterou vaše větev začíná. Všechny
                dílčí větve jsou definovány výchozí osobou a počtem generací předků nebo potomků počínaje touto osobou. Další jména můžete přidat
                později zopakováním tohoto procesu a volbou jiné "Výchozí osoby". Po uložení větve bude zapamatována pouze poslední výchozí osoba,
                všechny dříve přidané značky ale nebudou ovlivněny.</p>

            <h5 class="optionhead">Počet generací</h5>
            <p>Zvolte počet generací od výchozí osoby směrem zpět (předkové) nebo dopředu (potomci), které si přejete označit. Při
                označování předků můžete také zvolit, kolik má být označeno generací potomků od každého předka.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="delete"><h4 class="subheadbold">Vymazání větve</h4></a>
            <p>Chcete-li odstranit větev, použijte záložku <a href="#search">Hledat</a> k nalezení větve, a poté klikněte na ikonku Vymazat vedle
                záznamu této větve. Tento řádek změní
                barvu a poté po odstranění položky větev zmizí. Chcete-li najednou odstranit více větví, zaškrtněte tlačítko ve sloupci Vybrat vedle
                každé větve, která má být
                odstraněna, a poté klikněte na tlačítko "Vymazat vybrané" na stránce nahoře.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="label"><h4 class="subheadbold">Označení větví</h4></a>
            <p>Chcete-li značku větve připojit k osobám ve své databázi, klikněte na tlačítko <strong>Přidat značku</strong> ve spodní části stránky
                Upravit větev,
                a pokračujte podle instrukcí v okně, které se objeví. Po provedení výběru klikněte na tlačítko "Přidat značku" ve spodní části.
                Možnosti na této stránce jsou následující:</p>

            <h5 class="optionhead">Akce</h5>
            <p>Zvolte, zda chcete přidat nové značky nebo vymazat existující. Pokud chcete vymazat existující značky, musíte také zvolit, zda má tato
                akce vymazat značky větve u všech členů
                vašeho stromu nebo vymazat pouze značky, které odpovídají vybraným kritériím.</p>

            <h5 class="optionhead">Existující značku</h5>
            <p>Touto volbou určíte, co dělat, když některá osoba, kterou jste vybrali pro označení,
                již u sebe má zaznamenán příznak jiné větve. Existující značku můžete nechat netknutou, můžete ji přepsat
                nebo se můžete rozhodnout přidat novou značku. Pokud vyberete poslední možnost,
                postižené osoby budou nyní patřit k více větvím.</p>

            <h5 class="optionhead">Zobrazit osoby s tímto stromem/větví (označení):</h5>
            <p>Kliknutím na toto tlačítko zobrazíte všechny osoby, které již mají vybranou větev
                vybraného stromu. V tomto zobrazení se kliknutím na odkaz Značka větve můžete
                vrátít na předchozí stránku nebo kliknutím na osobu můžete úpravit její osobní záznam.</p>
        </td>
    </tr>

</table>
</body>
<?php echo "</html>"; ?>

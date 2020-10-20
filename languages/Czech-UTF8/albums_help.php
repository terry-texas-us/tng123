<?php
include "../../helplib.php";
echo help_header("Nápověda: Alba");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="collections_help.php" class="lightlink">&laquo; Nápověda: Kolekce</a> &nbsp;|&nbsp;
                <a href="cemeteries_help.php" class="lightlink">Nápověda: Hřbitovy &raquo;</a>
            </p>
            <h2 class="largeheader">Nápověda: <small>Alba</small></h2>
            <p class="smaller menu clear-both">
                <a href="#search" class="lightlink">Hledat</a> &nbsp;|&nbsp;
                <a href="#add" class="lightlink">Přidat nové</a> &nbsp;|&nbsp;
                <a href="#edit" class="lightlink">Upravit existující</a> &nbsp;|&nbsp;
                <a href="#delete" class="lightlink">Vymazat</a> &nbsp;|&nbsp;
                <a href="#sort" class="lightlink">Třídit</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="search"><h4 class="subheadbold">Hledat</h4></a>
            <p>Existující média vyhledáte zadáním úplného výrazu nebo části <strong>Názvu alba, Popisu</strong> nebo
                <strong>Klíčových slov</strong>. Pokud do vyhledávacích polí nezadáte žádná výběrová kritéria, budou nalezena všechna alba, která se
                nacházejí ve vaší databázi.</p>

            <p>Vyhledávací kritéria, která zadáte na této stránce, budou uchována, dokud nekliknete na tlačítko <strong>Obnovit</strong>, které znovu
                obnoví všechny výchozí hodnoty.</p>

            <h5>Akce</h5>
            <p>Tlačítko Akce vedle každého alba vám umožní upravit, vymazat nebo zobrazit náhled tohoto alba.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="add"><h4 class="subheadbold">Přidání nových alb</h4></a>
            <p><strong>Album</strong> v TNG je skupina médií. Album může obsahovat jakýkoli počet médií a konkrétní médium může být součástí více alb.
                Podobně jako jednotlivé médium může být album připojeno k osobě, rodině, pramenu, úložišti pramenů nebo místu.</p>

            <p>Chcete-li přidat nové album, klikněte na záložku <strong>Přidat nové</strong> a poté vyplňte formulář. Další informace jako média,
                která má album obsahovat, a
                odkazy na osobu, rodinu a jiné entity, můžete přidat po uložení záznamu. Význam jednotlivých polí je následující:</p>

            <h5>Název alba</h5>
            <p>Název vašeho alba.</p>

            <h5>Popis</h5>
            <p>Krátký popis alba nebo položek, které obsahuje.</p>

            <h5>Klíčová slova</h5>
            <p>Jakýkoli počet klíčových slov mimo název alba a popis, která mají být použita při vyhledávání tohoto alba.</p>

            <h5>Aktivní</h5>
            <p>Je-li album označeno jako "Aktivní", bude zobrazeno na vašich stránkách ve veřejném seznamu. Je-li příznak Aktivní nastaven na "Ne",
                návštěvníci vašich stránek
                toto album vidět nebudou.</p>

            <h5>Vždy viditelné</h5>
            <p>Je-li aktivní album označeno jako "Vždy viditelné" a je připojeno k osobě, rodině, pramenu nebo úložišti pramenů, bude na stránkách u
                těchto entit vždy viditelné, i když je
                připojeno k žijící osobě nebo rodině. Jinak jsou aktivní alba nebo média, která jsou připojená k žijícím osobám, skryta pro
                návštěvníky,
                kteří nemají oprávnění prohlížet data žijících osob.
            </p>

            <h5>Pole, která musí být vyplněna:</h5>
            <p>Název alba je jediné pole, které je nutné vyplnit, ale je ve vašem zájmu
                vyplnit i ostatní pole.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="edit"><h4 class="subheadbold">Úprava existujícího alba</h4></a>
            <p>Chcete-li upravit existující album, použijte záložku <a href="#search">Hledat</a> pro vyhledání alba a poté klikněte na ikonu Upravit
                vedle tohoto alba.
                Význam následujících polí, která nejsou na stránce "Přidat nové album":</p>

            <h5>Média v albu</h5>
            <p>Chcete-li do alba přidat média, klikněte na tlačítko "Přidat médium", a poté použijte formulář v zobrazeném okně pro výběr médií z
                položek, které obsahuje
                vaše databáze. Můžete použít Kolekce a/nebo Strom (obě volby jsou nepovinné), poté do pole "Najít" zapište část názvu alba nebo popisu
                a klikněte na tlačítko "Hledat". Když najdete položku, kterou byste chtěli přidat do alba, klikněte na odkaz "Přidat" vlevo na řádku
                položky. Tato
                položka bude do alba přidána a okno zůstane zobrazené. Tento postup opakujte pro další média, která chcete přidat, nebo klikněte na
                odkaz "Zavřít okno" pro návrat na stránku Úprava alba.</p>

            <p>Chcete-li z alba odstranit médium, přesuňte kursor myši nad tuto položku. Zobrazí se odkaz "Odstranit". Pro odstranění položky klikněte
                na tento odkaz. Po
                potvrzení bude položka zatemněna.</p>

            <p>Pro výběr náhledu, který má být pro toto album <strong>Výchozí fotografií</strong>, přesuňte kursor myši nad tuto položku. Zobrazí se
                odkaz "Nastavit jako výchozí".
                Kliknutím na tento odkaz určíte tento náhled jako výchozí fotografii tohoto alba. Chcete-li vybrat jinou výchozí fotografii, opakujte
                tento postup s jinou
                položkou ze seznamu. Chcete-li odstranit výchozí fotografii, klikněte na odkaz "Odstranit výchozí fotografii" v horní části této
                stránky.</p>

            <p>Chcete-li v albu přeřadit média, klikněte na oblast "Táhnout" u určité položky a při stisknutém tlačítku myši přetáhněte položku na
                požadované místo
                v oblasti seznamu. Je-li položka na požadovaném místě, uvolněte tlačítko myši ("uchopit a táhnout"). V tomto okamžiku jsou změny
                automaticky uloženy.</p>

            <p>Další možností jak přetřídit položky je zápis po sobě jdoucích čísel do malého políčka vedle oblasti "Táhnout", a poté kliknout na
                odkaz "Jdi" pod oknem a stiskněte Enter.
                To může být vhodné pro přesun položek, je-li seznam příliš dlouhý a všechny položky se nevejdou najednou na stránku.</p>

            <p>Kliknutím na ikonu dvojité šipky napravo od oblasti "Táhnout" můžete položku přesunout přímo na čelní místo seznamu.</p>

            <h5>Odkazy na album</h5>
            <p>Toto album můžete připojit k osobě, rodině, pramenu, úložišti pramenů nebo místu. Pro každé připojení nejprve vyberte strom spojený s
                entitou, kterou chci připojit.
                Dále vyberte typ propojení (osoba, rodina, pramen, úložiště pramenů nebo míst), a na závěr zapište číslo ID nebo název (pouze u míst)
                entity, kterou chcete připojit. Po
                vložení všech údajů klikněte na tlačítko "Přidat".</p>

            <p>Pokud neznáte ID číslo nebo přesný název místa, klikněte na ikonu lupy pro vyhledání těchto údajů. Zobrazí se okno, ve kterém můžete
                vyhledávat.
                Po nalezení popisu požadované entity klikněte na odkaz "Přidat" vlevo. Kliknout na "Přidat" můžete u více entit. Po dokončení tvorby
                propojení
                klikněte na odkaz "Zavřít okno".</p>

            <p>POZNÁMKA: Všechny změny, které se medií v albech a odkazů na alba, jsou uloženy okamžitě a není nutné kliknout na tlačítko "Uložit" na
                spodním okraji obrazovky.
                Pro uložení změn v sekci "Informace o albu" je nutné kliknout na "Uložit".</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="delete"><h4 class="subheadbold">Vymazat alba</h4></a>
            <p>Chcete-li album odstranit, použijte záložku <a href="#search">Hledat</a> pro nalezení alba, a poté klikněte na ikonu Vymazat vedle
                tohoto alba. Tento řádek změní
                barvu a poté po odstranění položky zmizí.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="sort"><h4 class="subheadbold">Třídění alb</h4></a>
            <p>Standardně jsou alba, která jsou propojena s osobou, rodinou, pramenem, úložištěm pramenů nebo místem, seřazena v pořadí, ve kterém
                byla k této entitě připojena. Chcete-li
                toto pořadí změnit, nové pořadí nastavíte na záložce Album/Třídit.</p>

            <h5>Strom, Typ odkazu, Kolekce:</h5>
            <p>Vyberte strom spojený s entitou, u které chcete třídit alba. Poté vyberte typ odkazu (osoba, rodina, pramen, úložiště pramenů nebo
                místo) a
                kolekci, kterou chcete třídit.</p>

            <h5>ID:</h5>
            <p>Zapište číslo ID nebo název (pouze u místa) entity. Pokud neznáte ID číslo nebo přesný název místa, klikněte na ikonu lupy pro
                vyhledání těchto údajů.
                Po nalezení požadované entity klikněte na odkaz "Vybrat" vedle této entity. Zobrazené okno se uzavře a vybrané ID číslo se objeví v
                poli ID číslo.</p>

            <h5>Procedura řazení</h5>
            <p>Po výběru nebo zapsání ID čísla klikněte na tlačítko "Pokračovat" pro zobrazení všech alb pro vybranou entitu a kolekci v jejich
                aktuálním pořadí.
                Chcete-li v alba přeřadit, klikněte na oblast "Táhnout" u určité položky a při stisknutém tlačítku myši přetáhněte položku na
                požadované místo
                v oblasti seznamu. Je-li položka na požadovaném místě, uvolněte tlačítko myši ("uchopit a táhnout"). V tomto okamžiku jsou změny
                automaticky uloženy.</p>

            <p>Další možností jak přetřídit položky je zápis po sobě jdoucích čísel do malého políčka vedle oblasti "Táhnout", a poté kliknout na
                odkaz "Jdi" pod oknem a stiskněte Enter.
                To může být vhodné pro přesun položek, je-li seznam příliš dlouhý a všechny položky se nevejdou najednou na stránku.</p>

            <p>Kliknutím na ikonu dvojité šipky napravo od oblasti "Táhnout" můžete položku přesunout přímo na čelní místo seznamu.</p>

        </td>
    </tr>

</table>
</body>
<?php echo "</html>"; ?>

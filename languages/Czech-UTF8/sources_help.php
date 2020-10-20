<?php
include "../../helplib.php";
echo help_header("Nápověda: Prameny");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="families_help.php" class="lightlink">&laquo; Nápověda: Rodiny</a> &nbsp;|&nbsp;
                <a href="repositories_help.php" class="lightlink">Nápověda: Úložiště pramenů &raquo;</a>
            </p>
            <h2 class="largeheader">Nápověda: <small>Prameny</small></h2>
            <p class="smaller menu clear-both">
                <a href="#search" class="lightlink">Hledat</a> &nbsp;|&nbsp;
                <a href="#add" class="lightlink">Přidat nový</a> &nbsp;|&nbsp;
                <a href="#edit" class="lightlink">Upravit existující</a> &nbsp;|&nbsp;
                <a href="#delete" class="lightlink">Vymazat</a> &nbsp;|&nbsp;
                <a href="#merge" class="lightlink">Sloučit</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="search"><h4 class="subheadbold">Hledat</h4></a>
            <p>Nalezení existujících pramenů vyhledáním celého nebo části <strong>ID čísla pramenu, názvu pramenu, autora, archivačního čísla</strong>
                nebo <strong>vydavatele</strong>.
                Pro další zúžení vašeho hledání vyberte strom nebo zaškrtněte "Pouze přesná shoda".
                Výsledkem hledání bez zadaných voleb a hodnot ve vyhledávacích polích bude seznam všech osob ve vaší databázi.</p>

            <p>Vyhledávací kritéria, která zadáte na této stránce, budou uchována, dokud nekliknete na tlačítko <strong>Obnovit</strong>, které znovu
                obnoví všechny výchozí hodnoty.</p>

            <h5>Akce</h5>
            <p>Tlačítko Akce vedle každého výsledku hledání vám umožní upravit, vymazat nebo otestovat výsledek. Chcete-li najednou vymazat více
                záznamů, zaškrtněte políčko ve sloupci
                <strong>Vybrat</strong> u každého záznamu, která má být vymazán, a poté klikněte na tlačítko "Vymazat označené" na začátku seznamu.
                Pro zaškrtnutí nebo vyčištění všech výběrových políček najednou
                můžete použít tlačítka <strong>Vybrat vše</strong> nebo <strong>Vyčistit vše</strong>.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="add"><h4 class="subheadbold">Přidat nový pramen</h4></a>
            <p><strong>Pramen</strong> je nějaká forma důkazu, která slouží k prokázání nebo doložení údajů ve vaší databázi. Stejný pramen může být
                citován vícekrát
                u více osob, rodin nebo událostí.</p>

            <p>Chcete-li přidat nový pramen, klikněte na záložku <strong>Přidat nový</strong> a poté vyplňte formulář. Některé informace (poznámky a
                další události) můžete přidat po uložení a zamknutí záznamu. Význam jednotlivých polí je následující:</p>

            <h5>Strom</h5>
            <p>Pokud máte pouze jeden strom, vybrán bude vždy tento strom. Jinak, prosím, pro novou rodinu vyberte požadovaný strom.</p>

            <h5>ID číslo pramenu</h5>
            <p>ID číslo pramenu musí být jednoznačné uvnitř vybraného stromu a mělo by se skládat z velkého písmene <strong>S</strong> následovaného
                číslem (nejvíce 21 číslic).
                Při prvním zobrazení stránky a kdykoli je vybrán jiný strom, bude doplněno volné a jednoznačné číslo, ale pokud chcete, můžete vložit
                své vlastní ID číslo.
                Chcete-li zkontrolovat, zda je vaše ID číslo jednoznačné, klikněte na tlačítko <strong>Zkontrolovat</strong>. Objeví se zpráva, která
                vám sdělí, zda je již ID číslo použito nebo ne.
                Chcete-li vygenerovat další jednoznačné číslo, klikněte na <strong>Vygenerovat</strong>. Bude zjištěno nejvyšší číslo ve vaší databázi
                a přidána 1.
                Chcete-li zajistit, že zobrazení ID číslo není nárokováno jiným uživatelem, zatímco vy zapisujete data, klikněte na tlačítko <strong>Zamknout</strong>.
            </p>

            <p><strong>POZN.</strong>: Používáte-li tento program spolu s genealogickým programem pracujícím na platformách PC nebo Mac, který u
                nových pramenů vytváří také ID čísla,
                DŮRAZNĚ DOPORUČUJEME všechna tato čísla vždy mezi těmito programy synchronizovat. Výsledkem zanedbání této činnosti mohou být kolize a
                nepoužitelnost
                odkazů na vaše média. Pokud váš primární program vytváří ID čísla, která neodpovídají tradičním standardům (např.
                <strong>S</strong> je na konci a ne na začátku), můžete konvence, které TNG používá, změnit v Základním nastavení.</p>

            <h5>Krátký název</h5>
            <p>Zkrácený název pramenu.</p>

            <h5>Dlouhý název</h5>
            <p>Dlouhý název pramene.</p>

            <h5>Autor, archivační číslo, vydavatel</h5>
            <p>Další informace spojené s pramenem (pokud existují).</p>

            <h5>Úložiště pramenů</h5>
            <p>Vyberte úložiště pramenů, ve kterém se pramen nachází (je-li tato skutečnost známa). Pokud dané úložiště pramenů ještě v databázi
                neexistuje, jděte na Administrace/Úložiště pramenů a
                kde jej založte, pak se vraťte a zde jej vyberte.</p>

            <h5>Vlastní text</h5>
            <p>Citace z materiálu pramene (volitelné).</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="edit"><h4 class="subheadbold">Upravit existující prameny</h4></a>
            <p>Chcete-li upravit existující pramen, použijte záložku <a href="#search">Hledat</a> pro nalezení pramenu, a poté klikněte na ikonu
                Upravit vedle pramenu.</p>

            <h5>Poznámky</h5>
            <p>Poznámky lze připojit k událostem nebo pramenu obecně kliknutím na ikonu Poznámky v horní části stránky
                nebo vedle každé události pod "Další události". Pokud pro událost již existují poznámky, na ikoně Poznámky se v horním pravém rohu
                zobrazí zelená tečka.
                Více informací o poznámkách najdete v odkazu <a href="notes_help.php">Nápověda</a> v oblasti Poznámky.</p>

            <h5>Další události</h5>
            <p>Chcete-li přidat nebo spravovat další události, klikněte na tlačítko "Přidat nové" vedle <strong>Dalších událostí</strong>. Viz odkaz
                <a href="events_help.php">Nápověda</a> v tomto okně pro více
                informací o přidání nových událostí. Po přidání události se v tabulce pod tlačítkem "Přidat nové" zobrazí krátké shrnutí. Akční
                tlačítka pro
                každou událost vám umožní upravit nebo vymazat událost, nebo přidat poznámky. Pořadí, ve kterém jsou události zobrazeny, závisí na
                datu (pokud je použito),
                a pořadí zapsaném u typu události (není-li připojeno datum). Toto pořadí lze změnit při úpravě typů událostí.

            <p><strong>Poznámka</strong>: Poznámky a změny "Dalších" událostí se ukládají automaticky. Jiné změny (např. standardní události)
                lze uložit kliknutím na tlačítko Uložit na konci stránky, nebo kliknutím na ikonu Uložit na stránce nahoře. Strom a
                ID číslo pramenu nelze změnit.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="delete"><h4 class="subheadbold">Vymazat prameny</h4></a>
            <p>Chcete-li odstranit pramen, použijte záložku <a href="#search">Hledat</a> pro nalezení pramenu, a poté klikněte na ikonu Vymazat vedle
                tohoto pramenu. Tento řádek změní
                barvu a poté po odstranění pramenu zmizí (všechny připojené citace budou také vymazány). Chcete-li najednou odstranit více pramenů,
                zaškrtněte políčko ve sloupci Vybrat vedle každého pramenu, který
                chcete odstranit, a poté klikněte na tlačítko "Vymazat označené" na stránce nahoře</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="merge"><h4 class="subheadbold">Sloučit</h4></a>
            <p>Kliknutím na tuto záložku lze přezkoumat a sloučit prameny, které jsou lehce odlišné, ale odkazují na stejný materiál.
                Musíte rozhodnout, zda jsou tyto záznamy totožné nebo ne.</p>

            <h5>Najít shodu</h5>
            <p>Vyberte nejprve strom. Nelze slučovat prameny z různých stromů, vybrán musí být pouze jeden strom. Potom máte možnost vybrat pramen
                jako
                výchozí bod vašeho hledání (ID číslo pramenu 1) nebo nechat, aby první shodu osob za vás nalezl TNG. Chcete-li, aby TNG nalezl všechny
                změny, nechte pole ID číslo pramenu 1 prázdné</p>

            <p>Pokud jste vybrali pramen jako ID číslo pramenu 1, můžete také ručně vybrat ID číslo pramenu 2. Chcete-li, aby duplicity Pramenu 1
                nalezl TNG, nechte pole ID číslo pramenu 2 prázdné.</p>

            <h5>Porovnat následující pole</h5>
            <p>Toto jsou kritéria, která TNG používá k určení možných duplicit. Standardně jsou vybrány krátký název a (dlouhý) název, což znamená, že
                tato pole
                musí být shodná, aby mohly být dva záznamy považovány za potenciálně duplicitní. Vyberete-li také pole autor, vydavatel, úložiště
                pramenů nebo vlastní text, musí být také tato pole shodná.</p>

            <h5>Jiné možnosti</h5>
            <p><em>Odmítnout prázdné</em> znamená, že prázdná pole nebudou brána v potaz. Např. pramen s krátkým názvem, ale bez titulu
                nebude brán jako shodný s jiným záznamem, pokud je titul mezi vybranými kritérii.</p>

            <p><em>Sloučit poznámky</em> znamená, že poznámky z pramene 2 budou přidány k poznámkám
                pramenu 1 u všech slučovaných polí. Není-li tato volba vybrána a pole pramenu 2 je zaškrtnuto, poznámky pramenu 2 k tomuto poli budou
                přepsány
                záznamy z odpovídajícího pole pramenu 1.</p>

            <p><em>Sloučit média</em> znamená, že média z pramenu 2 budou zachována a přidána k již existujícím
                u pramenu 1, pokud budou tyto dva prameny sloučeny. Není-li tato volba vybrána, všechny odkazy na média pramenu 2 budou po sloučení
                odstraněny.</p>

            <p><h5>Varování!</h5> Pokud proběhlo sloučení, nelze jej vzít zpět! <em>Před zahájením operace slučování proto vždy
                zazálohujte své databázové tabulky</em>
            pro případ, že byste dva prameny sloučili omylem.</p>

            <h5>Další shoda</h5>
            <p>Najde další možné porovnání, která nezahrne pramen 1. TNG postoupí seznamem možných pramenů v třídění podle ID čísla v textovém
                formátu.
                Znamená to, že "10" bude po "1", ale před "2".</p>

            <h5>Další duplicita</h5>
            <p>Najde další možnou duplicitu k pramenu 1. Pokud výsledkem není záznam, který byl zobrazen u pramenu 2, znamená to, že duplicita nebyla
                nalezena.</p>

            <h5>Porovnat/Obnovit</h5>
            <p>Porovnání pramenu 1 a pramenu 2. Je-li toto porovnání již zobrazeno, kliknutí na toto tlačítko způsobí obnovení stránky.</p>

            <h5>Prohodit</h5>
            <p>Pramen 1 se stane pramenem 2 a naopak.</p>

            <h5>Sloučit</h5>
            <p>Pramen 2 bude sloučen s pramenem 1. ID číslo pramene 1 bude zachováno, stejně jako ostatní údaje pramenu 1, pokud nejsou zaškrtnuta
                odpovídající políčka
                u pramenu 2. Např. pokud je u pramenu 2 zaškrtnuto políčko vedle autora, bude během sloučení údaj z tohoto pole zkopírován ze záznamu
                pramenu 2 do záznamu pramenu 1.
                Odpovídající údaj pramenu 1 bude smazán. Políčka u pramenu 2 jsou automaticky zaškrtnuta, pokud u pramenu 1 nejsou odpovídající údaje.
                Není-li
                pole zobrazeno ani u jednoho pramenu, pak v tomto poli neexistuje žádný údaj.</p>

            <h5>Upravit</h5>
            <p>Úprava záznamu pramenu v novém okně. Po provedení změn musíte kliknout na Porovnat/Obnovit, aby se změny projevily na obrazovce
                Sloučení.</p>

        </td>
    </tr>

</table>
</body>
<?php echo "</html>"; ?>

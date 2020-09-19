<?php
include "../../helplib.php";
echo help_header("Nápověda: Osoby");
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
                <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="index_help.php" class="lightlink">&laquo; Nápověda: Začínáme</a> &nbsp;|&nbsp;
                <a href="families_help.php" class="lightlink">Nápověda: Rodiny &raquo;</a>
            </p>
            <h2 class="largeheader">Nápověda: <small>Osoby</small></h2>
            <p class="smaller menu" style="clear: both;">
                <a href="#search" class="lightlink">Hledat</a> &nbsp;|&nbsp;
                <a href="#add" class="lightlink">Přidat novou</a> &nbsp;|&nbsp;
                <a href="#edit" class="lightlink">Upravit existující</a> &nbsp;|&nbsp;
                <a href="#delete" class="lightlink">Vymazat</a> &nbsp;|&nbsp;
                <a href="#review" class="lightlink">Přezkoumat</a> &nbsp;|&nbsp;
                <a href="#merge" class="lightlink">Sloučit</a>
            </p></td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">
            <a id="search">

                <h4 class="subheadbold">Hledat</h4></a>
            <p>Nalezení existujících osob vyhledáním celého nebo části <strong>ID čísla osoby</strong> nebo <strong>Jména</strong>. Pro další zúžení
                vašeho
                hledání vyberte strom nebo jednu z dalších možností.
                Výsledkem hledání bez zadaných voleb a hodnot ve vyhledávacích polích bude seznam všech osob ve vaší databázi.</p>
            <p>Vyhledávací kritéria, která zadáte na této stránce, budou uchována, dokud nekliknete na tlačítko <strong>Obnovit</strong>, které znovu
                obnoví
                všechny výchozí hodnoty.</p>

            <h5 class="optionhead">Akce</h5>
            <p>Tlačítko Akce vedle každého výsledku hledání vám umožní upravit, vymazat nebo otestovat výsledek. Chcete-li najednou vymazat více osob,
                zaškrtněte políčko ve sloupci
                <strong>Vybrat</strong> u každého záznamu, která má být odstraněn, a poté klikněte na tlačítko "Vymazat
                označené" na začátku seznamu. Pro zaškrtnutí nebo vyčištění všech výběrových políček najednou
                můžete použít tlačítka <strong>Vybrat vše</strong> nebo <strong>Vyčistit vše</strong>.
            </p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="add"><h4 class="subheadbold">Přidat novou osobu</h4></a>
            <p>Chcete-li přidat novou osobu, klikněte na záložku <strong>Přidat nové</strong> a poté vyplňte formulář. Další informace jako poznámky,
                citace, spojení a
                další události, můžete přidat po uložení nebo zamknutí záznamu. Význam jednotlivých polí je následující:</p>

            <h5 class="optionhead">Strom</h5>
            <p>Pokud máte pouze jeden strom, vybrán bude vždy tento strom. Jinak, prosím, pro novou osobu vyberte požadovaný strom.</p>

            <h5 class="optionhead">Větev (volitelné)</h5>
            <p>Připojení osoby ke "větvi" omezí přístup k informacím o osobě pro uživatele, kteří jsou spojeni k téže větvi. Je-li definována alespoň
                jedna větev
                a váš uživatelský účet není spojen se žádnou konkrétní větví, můžete novou osobu připojit k více existujícím větvím. Chcete-li větev
                vybrat,
                kliknutím na odkaz "Upravit" se otevře box se všemi větvemi ve vybraném stromě. Pro výběr více větví použijte klávesu Control
                (Windows) nebo Command (Mac).
                Po dokončení vašeho výběru přesuňte kursor myši mimo okno úprav a toto okno zmizí.</p>

            <h5 class="optionhead">ID číslo osoby</h5>
            <p>ID číslo osoby musí být jednoznačné uvnitř vybraného stromu a mělo by se skládat z velkého písmene <strong>I</strong> následovaného
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
                nových osob vytváří také ID čísla,
                DŮRAZNĚ DOPORUČUJEME všechny tato čísla vždy mezi těmito programy synchronizovat. Výsledkem zanedbání této činnosti mohou být kolize a
                nepoužitelnost
                odkazů na vaše média. Pokud váš primární program vytváří ID čísla, která neodpovídají tradičním standardům (např.
                <strong>I</strong> je na konci a ne na začátku), můžete konvence, které TNG používá, změnit v Základním nastavení.</p>

            <h5 class="optionhead">Jméno</h5>
            <p>Zapište křestní jméno a/nebo příjmení osoby. Druhá jména by měla být vložena do křestního jména. Pokud jste nastavili podporu
                předpon příjmení jako oddělených subjektů (předpony budou během třídění ignorovány), zapište předponu do pole označeného jako Předpona
                příjmení.
                <strong>Pozn.:</strong> Pokud toto pole není viditelné, přejděte do Nastavení/Základní nastavení a zaškrtněte volbu o použití předpon
                příjmení.</p>

            <h5 class="optionhead">Pohlaví / Přezdívka / Titul / Předpona / Přípona / Pořadí jména a příjmení</h5>
            <p>Zapište tolik údajů, kolik jich znáte. <strong>Přezdívka</strong> je neformální jméno spojené někdy s osobou.
                <strong>Titul</strong> se používá před jménem (např. <em>Ing.</em> nebo <em>MUDr.</em>), ale není součástí jména.
                <strong>Předpona</strong> se používá před jménem a obvykle je součástí
                jména. <strong>Přípona</strong> se používá za jménem (např. <em>CSc.</em> nebo <em>MBA</em>). <strong>Pořadí jména a příjmení</strong>
                můžete použít pro změnu zobrazení pořadí.
                Pořadí jména a příjmení pro všechny osoby v databázi můžete změnit v Nastavení/Základní nastavení.</p>

            <h5 class="optionhead">Žijící</h5>
            <p>Pokud tato osoba žije nebo si přejete omezit přístup k údajům této osoby pouze na uživatele, kteří jsou přihlášeni a mají práva
                zobrazovat data žijících osob,
                zaškrtněte toto políčko.</p>

            <h5 class="optionhead">Neveřejné</h5>
            <p>Bez ohledu na to, zda tato osoba žije nebo ne, můžete přístupová práva k údajům této osoby omezit zaškrtnutím této volby.
                Informace spojené s "neveřejnou" osobou budou moci vidět pouze uživatelé s právy zobrazovat neveřejná data.</p>

            <h5 class="optionhead">Události</h5>
            <p>Zapište data a místa k zobrazeným standardním událostem (pokud je znáte). Další události lze přidat po uložení a zamknutí záznamu. Data
                vždy zapisujte
                ve standardním genealogickém formátu DD MMM RRRR (např. <em>18 Úno 2008</em>). Informaci o místě řaďte za sebou od místního po obecnou
                a oddělujte každý údaj čárkou
                (např. <em>Bludov, Šumperk, Olomoucký kraj, Česká republika</em>), nebo kliknutím na ikonu "Najít" vyberte existující místo (lupa).
                Chcete-li omezit počet nalezených výsledků, před kliknutím na ikonu Najít zapište část místa. Všechny výsledky budou obsahovat to, co
                jste zapsali jako název místa.</p>

            <p><h5 class="optionhead">Údaje CJKSpd (Křest, Obdarování, Biřmování, Zasvěcení)</h5>
            Tyto události jsou spojeny s obřady prováděnými Církví Ježíše Krista Svatých posledních dní (mormonská církev, která vytvořila
            standard GEDCOM).
            <strong>Pozn.:</strong> Nechcete-li vidět pole spojené s CJKSpd, jděte na Nastavení/Základní nastavení a zde tuto možnost vypněte (je
            třeba se pak odhlásit a znovu přihlásit).</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="edit"><h4 class="subheadbold">Upravit existující osobu</h4></a>
            <p>Chcete-li upravit existující osobu, použijte záložku <a href="#search">Hledat</a> pro nalezení osoby, a poté klikněte na ikonu Upravit
                vedle této osoby.</p>

            <h5 class="optionhead">Poznámky / Citace / Spojení / "Více"</h5>
            <p>Poznámky, citace a spojení lze připojit k událostem nebo osobě obecně kliknutím na připojené ikony v horní části stránky
                nebo vedle každé události. Ke každé události můžete také přidat "více" informací kliknutím na ikonu "Plus". Pokud v nějaké této
                kategorii existují údaje,
                na odpovídající ikoně bude v horním pravém rohu zelená tečka. Chcete-li znát více informací o každé kategorii, jděte na odkazy
                nápovědy,
                které budou viditelné po kliknutí na tyto ikony.</p>

            <h5 class="optionhead">Jiné události</h5>
            <p>Chcete-li přidat další události, klikněte na tlačítko "Přidat nové" vedle <strong>Jiné události</strong>. Viz odkaz <a
                    href="events_help.php">Nápověda</a> pro více
                informací o přidání nových událostí. Po přidání události se pod tlačítkem "Přidat nové" zobrazí v tabulce krátké shrnutí. Tlačítka
                akcí
                pro každou událost vám umožní událost upravit nebo odstranit, nebo přidat poznámky nebo citace. Pořadí, ve kterém se události zobrazí,
                závisí na datu (je-li zapsáno)
                a prioritě, kterou má daný typ události (není-li připojeno datum). Při úpravě typu události můžete prioritu změnit.

            <p><strong>Poznámka</strong>: Poznámky, citace pramenů, spojení, "jiné" události a "více" informací se ukládá u standardních automaticky.
                Jiné změny (např. jméno nebo
                standardní události) se uloží kliknutím na tlačítko Uložit na konci stránky nebo kliknutím na ikonu Uložit na stránce nahoře. Strom a
                ID číslo osoby nelze změnit.</p>

            <h5 class="optionhead">Rodiče</h5>
            <p>Pokud má aktuální osoba rodiče, pod sekcí Události se bude nacházet sekce <strong>Rodiče</strong>. Sekce bude na začátku zobrazena jako
                zúžená a v závorkách bude
                počet párů rodičů). Chcete-li sekci rozšířit a zobrazit všechny páry rodičů, klikněte na slovo "Rodiče" nebo na šipku vedle. Některé
                údaje, včetně povahy
                vztahu mezi aktuální osobou a každým párem rodičů lze upravit v každém bloku. Pokud jste kurzorem myši nad párem rodičů, bude v horním
                pravém rohu
                viditelná volba <strong>Odpojit</strong>. Chcete-li aktuální osobu odpojit od tohoto páru rodičů, klikněte na tento odkaz.</p>

            <p>Nový pár rodičů k aktuální osobě můžete přidat kliknutím na odkaz <strong>Přidat nové</strong> vedle sekce
                Rodiče. V tomto okamžiku se vám zobrazí zpráva, která se vás zeptá, zda chcete uložit nejdříve vaše změny ("OK" nebo "Storno").
                Pokud vyberete "OK", stránka bude uložena a octnete se na stránce Nová rodina s aktuální osobou jako dítětem.
                Pokud zvolíte "Storno", neuloží se žádné změny, ale stejně budete nasměrováni na stránku Nová rodina s aktuální osobou jako dítětem.
                Pak budete mít možnost zadat nebo vybrat nové rodiče a podrobnosti o nové rodině.</p>

            <p>Nové rodiče můžete přidat také výběrem volby "Přejít na novou rodinu s touto osobou jako dítětem" na konci stránky.</p>

            <h5 class="optionhead">Manželé/Partneři</h5>
            <p>Pokud má aktuální osoba nějakého partnera, pod sekcí Rodiče se bude nacházet sekce <strong>Manželé/Partneři</strong> . Sekce bude na
                začátku zobrazena jako zúžená a v závorkách bude
                počet párů manželů/partnerů). Chcete-li sekci rozšířit a zobrazit všechny partnery, klikněte na slova "Manželé/Partneři" nebo na šipku
                vedle. Pokud jste kurzorem myši nad partnerem, bude v horním pravém rohu
                viditelná volba <strong>Odpojit</strong> . Chcete-li aktuální osobu odpojit od tohoto partnera, klikněte na tento odkaz.</p>

            <p>Nového partnera aktuální osoby můžete přidat kliknutím na odkaz <strong>Přidat nové</strong> vedle sekce
                Partneři. V tomto okamžiku se vám zobrazí zpráva, která se vás zeptá, zda chcete uložit nejdříve vaše změny ("OK" nebo "Storno").
                Pokud vyberete "OK", stránka bude uložena a octnete se na stránce Nová rodina s aktuální osobou jako manželem nebo manželkou (podle
                pohlaví dané osoby).
                Pokud zvolíte "Storno", neuloží se žádné změny, ale stejně budete nasměrováni na stránku Nová rodina s aktuální osobou jako partnerem.
                Pak budete mít možnost zadat nebo vybrat nového partnera a podrobnosti o nové rodině.</p>

            <p>Nového partnera můžete přidat také výběrem volby "Přejít na novou rodinu s touto osobou jako partnerem" na konci stránky.</p>

            <h5 class="optionhead">Pořadí rodičů nebo partnerů</h5>
            <p>Pokud existuje více partnerů nebo párů rodičů,
                můžete jejich pořadí změnit "přetažením" bloků nahoru nebo dolů. Chcete-li blok přetáhnout, klikněte myší na tlačítko "Táhnout", toto
                tlačítko podržte, a vaši myš přesuňte na stránce nahoru
                nebo dolů. Po přesunu bloku do požadované pozice tlačítko pusťte. Změny pořadí budou automaticky uloženy.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="delete"><h4 class="subheadbold">Vymazat osobu</h4></a>
            <p>Chcete-li odstranit osobu, použijte záložku <a href="#search">Hledat</a> pro nalezení dané osoby, a poté klikněte na ikonu Vymazat
                vedle této osoby. Tento řádek změní
                barvu a poté po odstranění položky zmizí. Chcete-li najednou odstranit více osob, zaškrtněte políčko ve sloupci Vybrat vedle každé
                osoby, kterou
                chcete odstranit, a poté klikněte na tlačítko "Vymazat vybrané" na stránce nahoře</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="review"><h4 class="subheadbold">Předběžné prohlédnutí úprav</h4></a>
            Chcete-li si předběžně prohlédnout změny provedené ostatními uživateli, klikněte na záložku "Přezkoumat". Můžete se pak rozhodnout, zda
            tyto navrhované změny uložíte nebo odstraníte.
            Změny můžete prohlédnout podle stromu nebo podle uživatele nebo podle obojího. Po uložení navrhovaných změn není zaslán žádný mail, ale
            pokud nové změny existují, na záložce Přezkoumat se objeví hvězdička (*).</p>

            <h5 class="optionhead">Vybrat událost a akci</h5>
            <p>V tabulce, která popisuje události, které si přejete přezkoumat nebo odstranit, vyberte řádek. Seznam výsledků můžete zúžit výběrem
                uživatele (osoba
                odpovědná za navrhované změny) a/nebo strom. Po zobrazení výsledků klikněte na jednu z možných akcí nalevo od tohoto řádku. Chcete-li
                změny přezkoumat a
                případně začlenit do databáze, vyberte <em>Přezkoumat</em>. Chcete-li navrhované změny zamítnout, vyberte <em>Odstranit</em>.</p>

            <h5 class="optionhead">Přezkoumat</h5>
            <p>Na obrazovce Přezkoumat můžete provést další potřebné změny, včetně poznámek a pramenů, a poté klikněte na "Uložit a vymazat" pro
                uložení do databáze a odstranění dočasného záznamu. Kliknutím na "Odmítnout a vymazat" můžete rovněž odstranit dočasný záznam, aniž
                byste jej uložili,
                nebo můžete své rozhodnutí odložit na pozdější dobu kliknutím na "Odložit".</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="merge"><h4 class="subheadbold">Sloučení osob</h4></a>
            Chcete-li přezkoumat a sloučit duplicitní záznamy, klikněte na záložku "Sloučit". Zde rozhodnete, zda jsou dva záznamy totožné nebo
            ne.</p>

            <h5 class="optionhead">Najít shodu</h5>
            <p>Vyberte nejprve strom. Nelze slučovat osoby z různých stromů, vybrán musí být pouze jeden strom. Potom máte možnost vybrat osobu jako
                výchozí bod vašeho hledání (osoba 1) nebo nechat, aby první shodu osob za vás nalezl TNG. Chcete-li, aby TNG nalezl všechny změny,
                nechte pole ID číslo osoby 1 prázdné</p>

            <p>Pokud jste vybrali osobu jako Osobu 1, můžete také ručně vybrat ID číslo osoby 2. Chcete-li, aby duplicity Osoby 1 nalezl TNG, nechte
                pole ID číslo osoby 2 prázdné.</p>

            <h5 class="optionhead">Porovnat následující pole</h5>
            <p>Toto jsou kritéria, která TNG používá k určení možných duplicit. Standardně jsou vybrány křestní jméno a příjmení, což znamená, že tato
                pole
                musí být shodná, aby mohly být dva záznamy považovány za potenciálně duplicitní. Vyberete-li také datum narození, místo narození,
                datum úmrtí a/nebo místo úmrtí, musí být také tato pole shodná.</p>

            <h5 class="optionhead">Jiné možnosti</h5>

            <p><em>Odmítnout prázdné</em> znamená, že prázdná pole nebudou brána v potaz. Např. někdo s příjmením, ale bez vyplněného křestního jména
                nebude brán jako shodný s jiným záznamem, pokud je křestní jméno mezi vybranými kritérii.</p>

            <p><em>Použít Soundex</em> znamená, že při porovnávání jmen bude použita funkce MySQL Soundex. V tomto případě bude
                text "Blakely" považován za shodný s textem "Blackley".</p>

            <p><em>Sloučit poznámky &amp; citace</em> znamená, že poznámky a citace osoby 2 budou přidány k poznámkám a citacím
                osoby 1 u všech slučovaných polí. Není-li tato volba vybrána a pole osoby 2 je zaškrtnuto, poznámky a citace osoby 2 k tomuto poli
                budou přepsány
                záznamy z odpovídajícího pole osoby 1.</p>

            <p><em>Sloučit média</em> znamená, že fotografie a historie osoby 2 budou zachovány a přidány k již existujícím
                u osoby 1, pokud budou tyto dvě osoby sloučeny. Není-li tato volba vybrána, všechny odkazy na fotografie, historie a náhrobky osoby 2
                budou po sloučení odstraněny.</p>

            <p><h5 class="optionhead">Varování!</h5> Pokud proběhlo sloučení, nelze jej vzít zpět! <em>Před zahájením operace slučování proto vždy
                zazálohujte své databázové tabulky</em>
            pro případ, že byste dvě osoby sloučili omylem.</p>

            <h5 class="optionhead">Další shoda</h5>
            <p>Najde další možné porovnání, která nezahrne osobu 1. TNG postoupí seznamem možných osob v třídění podle ID čísla v textovém formátu.
                Znamená to, že "10" bude po "1", ale před "2".</p>

            <h5 class="optionhead">Další duplicita</h5>
            <p>Najde další možnou duplicitu k osobě 1. Pokud výsledkem není záznam, který byl zobrazen u osoby 2, znamená to, že duplicita nebyla
                nalezena.</p>

            <h5 class="optionhead">Porovnat/Obnovit</h5>
            <p>Porovnání osoby 1 a osoby 2. Je-li toto porovnání již zobrazeno, kliknutí na toto tlačítko způsobí obnovení stránky.</p>

            <h5 class="optionhead">Prohodit</h5>
            <p>Osoba 1 se stane osobou 2 a naopak.</p>

            <h5 class="optionhead">Sloučit</h5>
            <p>Osoba 2 bude sloučena s osobou 1. ID číslo osoby 1 bude zachováno, stejně jako ostatní údaje osoby 1, pokud nejsou zaškrtnuta
                odpovídající políčka
                u osoby 2. Např. pokud je u osoby 2 zaškrtnuto políčko vedle data narození, bude během sloučení údaj z tohoto pole zkopírován ze
                záznamu osoby 2 do záznamu osoby 1.
                Odpovídající údaj osoby 1 bude smazán. Políčka u osoby 2 jsou automaticky zaškrtnuta, pokud u osoby 1 nejsou odpovídající údaje.
                Není-li
                pole zobrazeno ani u jedné osoby, pak v tomto poli neexistuje žádný údaj.</p>

            <h5 class="optionhead">Upravit</h5>
            <p>Úprava záznamu osoby v novém okně. Po provedení změn musíte kliknout na Porovnat/Obnovit, aby se změny projevily na obrazovce
                Sloučení.</p>

        </td>
    </tr>
</table>
</body>
</html>

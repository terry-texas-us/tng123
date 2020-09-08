<?php
include "../../helplib.php";
echo help_header("Nápověda: Manažer módů");
?>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<body class="helpbody">
<a name="top"></a>
<table width="100%" cellpadding="10" cellspacing="2" class="tblback normal">
  <tr class="fieldnameback">
    <td class="tngshadow">
      <p style="float:right; text-align:right;" class="smaller menu">
        <a href="https://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp; | &nbsp;
        <a href="https://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
        <a href="backuprestore_help.php" class="lightlink">&laquo; Nápověda: Obslužné programy</a> &nbsp; | &nbsp;
        <a href="index_help.php" class="lightlink">Nápověda: Začínáme &raquo;</a>
      </p>
      <span class="largeheader">Nápověda: Manažer módů
        </span>
      <p class="smaller menu">
        <a href="#overview" class="lightlink">Přehled</a> &nbsp; | &nbsp;
        <a href="#operation" class="lightlink">Operace</a> &nbsp; | &nbsp;
        <a href="#status" class="lightlink">Stav</a> &nbsp; | &nbsp;
        <a href="#syntax" class="lightlink">Syntaxe módů</a> &nbsp; | &nbsp;
                <a href="#files" class="lightlink">Konfigurační soubory</a> &nbsp; | &nbsp;
                <a href="#batch" class="lightlink">Dávkové operace</a> &nbsp; | &nbsp;
                <a href="#options" class="lightlink">Možnosti</a> &nbsp; | &nbsp;
                <a href="#analyze" class="lightlink">Analýza souborů TNG</a> &nbsp; | &nbsp;
                <a href="#parser" class="lightlink">Tabulka parseru</a> &nbsp; | &nbsp;
                <a href="#custtext" class="lightlink">Doporučené aktualizace</a>

            </p></td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">
            <a name="overview"><p class="subheadbold">Přehled</p></a>
            <p>Manažer módů TNG verze 12 je založen na Manažeru módů, který byl původně vyvinut Brianem McFadyenem, následně zaktualizován Seanem Schwoerem pro práci s Joomla TNG Component
                a ve verzi 10.0.3 a 10.1 zaktualizován o integrovanější způsob instalace, odstranění a řízení změn softwarového balíku TNG.</p>
            <p>Nový Manažer módů nabízí jednoduchý řádkový souhrn stavů módů, který může být rozšířen na zobrazení kompletního popisu a chyb.
                Seznam souborů, které daný mód ovlivňuje, lze zobrazit přejetím kursorem myši nad znaménkem + ve sloupci Soubory.
                K rozbalení všech záznamů a zobrazení stavu můžete podobně jako ve starém Manažeru módů použít také tlačítko <strong>Rozbalit vše</strong> v horním menu.
                Volba Rozbalit vše je užitečná při filtrování seznamu na stavy <strong>Částečně nainstalováno</strong> nebo <strong>Nelze nainstalovat</strong>, takže můžete vidět chyby, které se
                zde objevují.</p>
            <p>Manažer módů je pro snazší přístup přidán na stránku Administrace TNG. Manažer módů vytváří v TNG tyto složky:
            <ul>
                <li><strong>mods</strong> obsahuje konfigurační soubory módů a přidružené podpůrné soubory módů. Složka mods může být přejmenována. Manažer módů používá pro práci s názvem složky proměnnou $modspath.</li>
                <li><strong>extensions</strong> obsahuje některá rozšíření módů, které jsou instalovány jinými konfiguračními soubory manažeru módů. Složka extensions může být přejmenována. Manažer módů používá pro práci s názvem složky proměnnou
                    $modspath.
                </li>
                <li><strong>classes</strong> obsahuje třídy Objektově orientovaného programování (Object Orient Progamming classes), které byly rozděleny a vylepšeny z předchozího souboru managemods.class.php, který vytvořil Sean Schwoere z původní kódu
                    Manažeru módů od Briana McFadyena.
                </li>
            </ul>
            </p>

            <p>Záložka <strong>Seznam módů</strong> nyní spojuje předchozí Seznam módů a Dávkové instalace, které do TNG 10.0.3 přidal Rick Bisbee, a umožňuje vykonat stejnou akci pro více módů. Popis a rozšířený stav lze zobrazit pomocí kliknutí na šipku
                vpravo ve sloupci Stav nebo kdekoli na řádku. Přejetím kurzorem myši nad řádkem se zvýrazní řádek a usnadní se tak výběru stavu pro rozšířené zobrazení. Přejetím kurzoru myši přes znaménko + ve sloupci Soubory se zobrazí seznam souborů,
                které daný mód mění, vytváří nebo kopíruje.</p>
            <p>Pokud je povolena možnost Zobrazit další nástroje pro vývojáře, TNG v12 přidává následující změny:
            <ul>
                <li>kliknutím na název souboru se otevře tabulka parseru pro tento mód</li>
                <li>kliknutím na název souboru cfg se zobrazí soubor cfg na jiné záložce</li>
                <li>tlačítko <strong>Podrobnosti</strong> v buňce Stav funguje jako přepínač pro rozbalení nebo sbalení zobrazení směrnic souboru ve stavu Instalovat nebo Lze instalovat.</li>
            </ul>
            </p>

            <p>Záložku <strong>Zobrazit protokol</strong> přidal do TNG 10.0.3 Ken Roy a zobrazuje protokol Manažeru módů, který je nyní oddělen od protokolu Administrace. Protokol manažeru módů je přeformátovaný protokol z Manažeru módů vytvořeného Rickem
                Bisbee a Robinem Richmondem v TNG 10.0.3 a srozumitelnost vykonaných akcí zaznamenaných v protokolu je nyní lepší. Zprávy a hlášení byly značně zjednodušeny.</p>
            <p>Záložka <strong>Možnosti</strong> je modifikací záložky přidané Kenem Royem do TNG 10.0.3 a umožňuje měnit některé chování manažeru módů.</p>
            <p>Záložka <strong>Analýza souboru TNG</strong> je volitelná záložka, jejíž zobrazení lze povolit na obrazovce Možnosti, a umožňuje vybrat soubor TNG a zobrazit, které módy jej mění.</p>
            <p>Záložka <strong>Tabulka parseru</strong> je volitelná záložka, jejíž zobrazení lze povolit na obrazovce Možnosti povolením <strong>Další nástroje pro vývojáře</strong>, a umožní zobrazit, jak je daný mód analyzován Manažerem módů.</p>
            <p>Záložka <strong>Doporučené aktualizace</strong> je volitelná záložka, jejíž zobrazení lze povolit na obrazovce Možnosti, která vám umožní aktualizovat soubory cust_text.php, pokud jste tak neučinili v rámci aktualizace TNG.</p>

            <p>Další informace můžete najít v článku
                <a href="https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager" target="_blank">Manažer módů (v angličtině)</a> a v kategorii článků
                <a href="https://tng.lythgoes.net/wiki/index.php?title=Category:TNG_Mod_Manager" target="_blank">TNG Mod Manager (v angličtině)</a> na TNG Wiki.</p>
            <p>You can view the <a href="https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_Enhancements" target="_blank">Mod Manager</a> article in TNG Wiki to see what enhancements were made in TNG v12.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">
            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a name="operation"><p class="subheadbold">Operace</p></a>
            <p>Manažer módů prozkoumá složku módů a přečte každý soubor <strong>cfg</strong>, který najde. Soubory <strong>cfg</strong> jsou direktivní soubory, které popisují mód, soubory a umístění, které má být modifikováno, a kód, který je při
                modifikaci použit.
            <p>Manažer módů zkontroluje následující:
            <ul>
                <li>zajistí, že je uživatel přihlášen
                <li>prověří umístění a změnu každého kódu
                    <ul>
                        <li>zajistí, že lze umístění nalézt</li>
                        <li>zajistí, že cílové místo je jedinečné</li>
                        <li>určí, zda cílové umístění již bylo nainstalováno</li>
                    </ul>
                <li>vytvoří zadanou složku nebo adresář</li>
                <li>identifikuje nové soubory, které mají být vytvořeny. Pokud je soubor označen jako chráněný, nebude odstraněn Odinstalací ani Vyčištěním.</li>
                <li>identifikuje soubory, které mají být zkopírovány do kořenové složky TNG nebo do určené složky. Pokud je soubor označen jako chráněný, nebude odstraněn Odinstalací ani Vyčištěním.</li>
            </ul>
            </p>

        </td>
    </tr>

    <tr class="databack">
        <td class="tngshadow">
            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a name="status"><p class="subheadbold">Stav</p></a>
            <p>Manažer módů vrací následující stavy:
            <ul>
                <li><strong>Lze instalovat</strong>, pokud mód ještě nebyl nainstalován a cílové umístění je identifikováno, pak je uvedena možnost <strong>Instalovat</strong>
                </li>
                <li><strong>Instalováno</strong>, pokud již mód byl nainstalován, je uvedena možnost <strong>Odinstalovat</strong> mód a možnost <strong>Upravit</strong> parametry, pokud nějaké existují. Módy s editačními parametry jsou identifikovány
                    podle [Možnosti] za stavem Instalováno.
                </li>
                <li><strong>Částečně instalováno</strong>, pokud mód byl částečně nainstalován, je k dispozici tlačítko <strong>Vyčistit</strong>. Operace Vyčištění se pokusí odstranit vložený kód, obnovit a nahradit kód, a odstranit jakékoli vytvořené
                    nebo zkopírované soubory.
                </li>
                <li><strong>Nelze nainstalovat</strong>, pokud mód <strong>nelze</strong> instalovat. Rozšíření (zobrazení kompletní informace) stavu poskytne více informací o tom, proč mód nelze nainstalovat.
                </li>
            </ul>
            <p>Příklady obrazovek stavu manažeru módů a jak interpretovat různé stavy najdete na
                <a href="https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_-_Interpreting_Status" target="_blank">Manažer módů - interpretace stavů (v angličtině)</a>
            </p></td>
    </tr>

    <tr class="databack">
        <td class="tngshadow">
            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a name="syntax"><p class="subheadbold">Syntaxe módů</p></a>
            <p>Syntaxe manažera módů v zásadě zahrnuje:
            <p><strong>Sekci záhlaví</strong>, která obsahuje</p>
            <ul>
                <li>Název (name) - název módu, článek na TNG Wiki a název souboru</li>
                <li>Verze (version) - verze módu, kde první 3 číslice představují nejnižší verzi TNG, ve které mód funguje</li>
                <li>Popis (description) - obsahuje stručný popis módu, jméno vývojáře a URL článku o daném módu na TNG Wiki.</li>
            </ul>
            </p>
            <p><strong>Cílovou sekci (target)</strong>, kde je specifikován soubor, který je opravným módem změněn, a následně obsahuje příkazy. K cílové sekce lze přidat poznámku.</p>
            <ul>
                <li>Umístění (location) - určuje umístění kódu, který je v souboru měněn. K umístění lze přidat poznámku.</li>
                <li>Klíčové slovo akce - určuje, zda přepsat (Replace) nebo vložit (Insert) kód před (Before) nebo za (After) toto umístění</li>
            </ul>
            </p>
            <p><strong>Příkaz Nový soubor (New File)</strong>, který po instalaci módu vytvoří nový soubor</p>
            <p><strong>Příkaz Kopírovat soubor (Copy File)</strong>, který nakopíruje určitý soubor do řídící složky TNG (%copyfile) nebo do podsložky (%copyfile2)</p>
            <p>Detailní informace týkající se syntaxe módů najdete v článku <a href="https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_Syntax" target="_blank">Mod Manager Syntax (v angličtině)</a></p>
        </td>
    </tr>

    <tr class="databack">
        <td class="tngshadow">
            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a name="files"><p class="subheadbold">Konfigurační soubory</p></a>

            <span class="optionhead">Instalování módů</span>
            <p>Informace o <a href="https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_-_Installing_Config_Files" target="_blank">instalaci konfiguračních souborů (v angličtině)</a> k instalaci módů najdete na TNG Wiki.</p>

            <span class="optionhead">Interpretace stavu</span>
            <p>Informace o <a href="https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_-_Interpreting_Status" target="_blank">interpretaci stavu (v angličtině)</a> najdete na TNG Wiki.</p>

            <span class="optionhead">Syntaxe konfiguračních souborů</span>
            <p>Informace o <a href="https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_Syntax" target="_blank">syntaxi manažeru módů (v angličtině)</a> najdete na TNG Wiki.</p>

            <span class="optionhead">Vytvoření konfiguračního souboru</span>
            <p>Informace pro vývojáře o <a href="https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_-_Creating_Config_Files" target="_blank">vytvoření konfiguračních souborů (v angličtině)</a> najdete na TNG Wiki.</p>
        </td>
    </tr>

    <tr class="databack">
        <td class="tngshadow">
            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a name="batch"><p class="subheadbold">Dávkové operace</p></a>

            <p>Funkce Dávkové operace, v TNG 10.0.3 představená jako Dávkové instalace, je nyní součástí Seznamu módů a umožní provést specifické akce týkající se více módů pomocí výběru filtru.
                Z filtru seznamu stavů musíte vybrat požadovaný stav a kliknutím na <strong>Provést</strong> zobrazíte dostupná ovládací tlačítka pro vybraný stav.

                Akce <strong>Vymazat</strong> je k dispozici pouze pro stav Částečně nainstalováno, pokud povolíte příslušnou předvolbu. Doporučujeme ji nastavit na Ne, kromě případů, kdy je potřeba vymazat více módů ve stavu
                Částečně nainstalováno, jako např. předchozí verze téhož módu. Stejně tak je zde možnost Vymazat instalované módy, která umožní vymazání nainstalovaných módů, aniž byste je nejprve odinstalovali. Tato možnost byla přidána,
                aby bylo možné vymazat předchozí verze téhož módu, pokud jste je zapomněli vymazat před instalací nové verze. Zde opět doporučujeme ponechat možnost jako Ne a povolit ji jen v případě potřeby.
                Tlačítko <strong>Vymazat</strong> se zobrazí pouze v seznamu Vybrat, pokud jsou povoleny oba možnosti vymazání.
            </p>

            <p><strong><font color="red">Upozornění: Dávkové operace používejte pouze tehdy, pokud máte zálohu vašich webových stránek a můžete je snadno obnovit v případě, že vlivem dávkových operací dojde k poškození vašich stránek, což se může snadno
                        stát, pokud nevymažete předchozí verze módů.</font>
                    Je doporučeno Před provedením aktualizace TNG doporučujeme odinstalovat všechny nainstalované módy a poté vyčistit všechny částečně nainstalované módy.</strong></p>

            <p>Možnosti výběrového filtru jsou tyto:
            <ul>
                <li><strong>Vše</strong> - zobrazí se úplný seznam všech souborů .cfg ze složky mods. Pokud zvolíte určitý stav, objeví se dostupná tlačítka jednotlivých akcí</li>
                <li><strong>Lze nainstalovat</strong> - zobrazí se seznam všech módů, které mohou být</li>
                <ul>
                    <li>Nainstalovány - na základě vašeho výběru a kliknutím na tlačítko <strong>Instalovat</strong></li>
                    <li>Vymazány ze složky mods - na základě vašeho výběru a kliknutím na tlačítko <strong>Vymazat</strong></li>
                </ul>
                <li><strong>Instalováno</strong> - zobrazí se seznam všech módů, které jsou aktuálně nainstalovány, a mohou být</li>
                <ul>
                    <li>Odstraněny - na základě vašeho výběru a kliknutím na tlačítko <strong>Odstranit</strong></li>
                </ul>
                <li><strong>Částečně instalováno</strong> - zobrazí se seznam všech módů, které jsou částečně instalovány a musí být</li>
                <ul>
                    <li>Vyčištěny - na základě vašeho výběru a kliknutím na tlačítko <strong>Vyčistit vybrané</strong></li>
                </ul>
                <li><strong>Nelze nainstalovat</strong> - zobrazí se seznam všech módů, které nelze nainstalovat z důvodu chybného cílového souboru nebo chybějících souborů, a mohou být</li>
                <ul>
                    <li>Vymazány ze složky mods - na základě vašeho výběru a kliknutím na tlačítko <strong>Vymazat vybrané</strong></li>
                </ul>
                <li><strong>Vybrat</strong> - přidáno v TNG v12 - zobrazí se seznam všech modů, které mohou být vybrány bez ohledu na stav a poté pouze vrací tyto módy do seznamu</li>
                <ul>
                    <li>Tlačítko <strong>Vymazat</strong> bude dostupné pouze na seznamu Vybrat, pokud máte aktivní volbu Povolit Vymazat vybrané u částečně nainstalovaných módů. Tato funkce byla přidána hlavně pro vývojáře módů k vyčištění jejich
                        testovacích prostředí.
                    </li>
                </ul>
            </ul>
            </p>
        </td>
    </tr>

    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a name="options"><p class="subheadbold">Možnosti</p></a>

            <p>Možnosti vám umožní specifikovat chování manažeru módů.

            <p><strong>Možnosti protokolu Manažeru módů</strong>
            <ul>
                <li><strong>Název protokolu</strong> - umožní vám určit název souboru, který bude použit pro protokol manažeru módů. Výchozí volbou je <strong>modmgrlog.txt</strong>.</li>
                <li><strong>Maximální počet transakcí</strong> - umožní vám určit, kolik transakcí bude zachováváno v protokolu. Výchozí volbou je <strong>200</strong> transakcí.</li>
                <li><strong>Sbalit zobrazení protokolu</strong> - umožní vám určit, zda chcete při úvodním zobrazení vidět protokol v zúženém nebo rozšířeném stavu. Výchozí volbou je <strong>Ano</strong>.</li>
                <li><strong>Přesměrovat na protokol</strong> - umožní vám určit, zda chcete být ze Seznamu módů přesměrováni na záložku Zobrazit protokol v případě <strong>Pouze chyb</strong> nebo <strong>Všech transakcí</strong>. Výchozí volbou je
                    přesměrování v případě <strong>Pouze chyb</strong>, která zobrazí protokol pouze v případě, že se vyskytne v průběhu instalace, odinstalace, vyčištění nebo vymazání chyba.
                </li>
                <li><strong>Do protokolu zapsat celou cestu souborů</strong> - umožní vám zapsat Ne, pokud chcete u souborů v protokolu zobrazit pouze relativní cestu. Výchozí volbou je <strong>Ano</strong> pro zobrazení úplné absolutní cesty.</li>
            </ul>
            </p>
            <p><strong>Možnosti nastavení zobrazení</strong>
            <ul>
                <li><strong>Řadit seznamy podle</strong> - umožní vám zvolit, podle kterého sloupce bude řazen Seznam módů. Možnosti jsou Název módu a Název konfiguračního souboru. Výchozí volbou je <strong>Název módu</strong>.</li>
                <li><strong>Použít pevné záhlaví</strong> - umožní vám změnit volbu, aby nebylo zobrazeno pevné záhlaví. Tato volba není zřetelná, pokud máte velký monitor a málo módů. Výchozí volbou je <strong>Ano</strong> pro zobrazení pevného záhlaví.
                    Bez ohledu na nastavení této volby se pevné záhlaví nezobrazí v případě chytrých telefonů (mobilní režim).
                </li>
                <li><strong>Upravit pevné záhlaví</strong> - umožní vám povolit úpravu pevného záhlaví jQuery v případě, že pevné záhlaví není správně zobrazeno. Tato volba je potřeba pouze na určitých monitorech. Výchozí volbou je <strong>Ne</strong> a
                    nepoužívat javascript jQuery pro úpravu pevného záhlaví.
                </li>
                <li><strong>Použít pruhy</strong> - umožní vám změnit volbu a nepoužít pruhy při zobrazení Seznamu módů. Výchozí volbou je <strong>Ano</strong>, která použije třídu databackalt k zobrazení barevných pruhů střídavě po počtu N řádků.</li>
                <li><strong>Pruh po tomto počtu řádků</strong> - umožní nastavit počet řádků, po kterém se budou střídat barevné pruhy. Výchozí volbou jsou <strong>3</strong> řádky jedné barvy a pak 3 řádky jiné barvy.</li>
                <li><strong>Odstranit mezery z názvů souborů v seznamu módů</strong> - umožní odstranit mezery z názvů módů před jejich zobrazením v Seznamu názvů módů. Výchozí volbou je <strong>Ne</strong>, kdy jsou mezery v názvech módů zobrazeny a tyto
                    názvy pak odpovídají názvům článků na TNG Wiki.
                </li>
                <li><strong>Zobrazit záložku Analýza souborů TNG</strong> - umožní určit, zda chcete zobrazit záložku Analýza soouborů TNG. Výchozí volbou je <strong>Ne</strong>, která potlačí zobrazení záložky Analýza soouborů TNG.</li>
                <li><strong>Zobrazit další nástroje pro vývojáře</strong> - umožní určit, zda chcete zobrazit záložku Tabulka parseru. Výchozí volbou je <strong>Ne</strong>, která potlačí zobrazení záložky Tabulka parseru. Tato volba také řídí, zda se na
                    kliknutí na název módu zobrazí tabulka parseru pro daný mod a zda se kliknutím na název konfiguračního souboru zobrazí na nové záložce konfigurační soubor.
                </li>
                <li><strong>Zobrazit záložku Doporučené aktualizace</strong> - umožní určit, zda chcete zobrazit záložku Doporučené aktualizace. Výchozí volbou je <strong>Ne</strong>, která potlačí zobrazení záložky Doporučené aktualizace. Tato záložka
                    nemusí být zobrazena, pokud jste provedli aktualizaci souboru cust_text.php v rámci aktualizace na TNG v12.
                </li>
            </ul>
            </p>
            <p><strong>Jiné možnosti</strong>
            <ul>
                <li><strong>Povolit Vymazat vybrané pro částečně nainstalované módy</strong> - povolí zobrazení tlačítka <strong>Vymazat</strong> v seznamu vybraných Částečně nainstalovaných módů, pomocí kterého lze vymazat více módů najednou, jako např.
                    vymazání předchozích verzí modů, které nebyly vymazány před instalací novější verzí. Výchozí volbou je <strong>Ne</strong>. Tuto volbu doporučujeme povolit pouze v případě, že potřebujete vymazat více modů, aniž byste museli
                    odinstalovat aktuální verze, abyste odstranili předchozí verze módu, když jste zapomněli odinstalovat a vymazat předchozí verze modu před instalací nové verze. Normálně tuto volbu nechte nastavenou na Ne a volbu Ne obnovte po odstranění
                    předchozích verzí módu, které se zobrazují jako částečně nainstalované.
                </li>
                <li><strong>Povolit Vymazat pro samostatně nainstalované módy</strong> - umožní zapnutí volby zobrazení tlačítka <strong>Vymazat</strong> vedle tlačítka Odinstalovat u samostatně instalovaných módů, např. pro vymazání předchozí verze módu,
                    která nebyla vymazána před instalací novější verze. Výchozí volbou je <strong>Ne</strong>. Doporučujeme, abyste tuto volbu povolili pouze v případě, kdy je potřeba vymazat předchozí verzi módu, bez nutnosti odinstalování aktuální verze
                    za účelem vymazání předchozí verze, a za normálních okolností ponechte tuto volbu nastavenou na <strong>Ne</strong> a volbu Ne obnovte po odstranění předchozích verzí módu, které se zobrazují jako nainstalované.
                </li>
                <li><strong>Povolit smazání podpůrné složky po vymazání modu</strong> - umožní zapnutí volby smazání složky (složek) přidružených k módu při mazání módu. Výchozí volbou je <strong>Ne</strong>. Doporučujeme tuto možnost povolit jen tehdy,
                    pokud chápete nebezpečí vymazání nezamýšlených složek. Věříme, že toto riziko je velmi malé.
                </li>
            </ul>
            </p>
        </td>
    </tr>

    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a name="analyze"><p class="subheadbold">Analýza souborů TNG</p></a>

            <p>Tento nástroj na záložce <strong>Analýza souborů TNG</strong>, který vytvořil Rick Bisbee, existoval dříve jako opravný mód. Analýza souborů TNG umožňuje vývojářům zkoumat působení módů navzájem. Situace, kdy dva módy mění stejný úsek
                programového kódu, má téměř vždy za následek chybu v manažeru módů. Chcete-li, aby byla záložka Analýza souborů TNG zobrazena, musíte ji povolit nastavením volby <strong>Analýza souborů TNG</strong> na Ano.</p>

            <p>Analyzér pracuje tak, že prozkoumá všechny módy ve složce mods a vytvoří soupis cílových souborů a úseků programového kódu, který každý mód mění. V levém sloupci uvede názvy dotčených souborů. Po kliknutí na název cílového souboru se na
                pravé straně zobrazí seznam módů, které tento cílový soubor mění. U každého módu je napravo zobrazen odkaz pro otevření sekce stránky zobrazující aktuální změny, které obsahuje konfigurační soubor manažeru módů. Uživatel může porovnat změny
                cílového souboru a vidět, kde mohou být skryty potenciální konflikty.</p>

            <p>To je užitečné nejen pro nalezení konfliktů mezi dvěma módy, ale také pro poznání, které módy je třeba vyčistit a znovu nainstalovat po přepsání daného cílového souboru. </p>
            <p>Vývojáři módů naleznou další informace na TNG Wiki v článku <a href="https://tng.lythgoes.net/wiki/index.php?title=Using_the_Mod_Analyzer" target="_blank">Using the Mod Analyzer (v angličtině)</a>.</p>
        </td>
    </tr>

    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Top</a></p>
            <a name="parser"><p class="subheadbold">Tabulka parseru</p></a>
            <p>Tento nástroj je určen hlavně pro vývojáře. Tabulka parseru ukazuje, jak Manažer módů zanalyzoval konfigurační soubor módu (.cfg) zapracováním jeho komponent do tabulky, která pak prochází do dalších skriptů Manažeru módů pro další
                zpracování. Pokud se vyskytne problém s módem, první místo, které je třeba zkontrolovat, je tabulka parseru, aby se zjistilo, zda jsou správně zachyceny všechny příkazy a argumenty módu.</p>
            <p>Tuto záložku můžete použít k výběru módu ze seznamu, jehož tabulku chcete zobrazit, nebo, pokud jste povolili možnost Zobrazit další nástroje pro vývojáře, můžete kliknout na název módu v Seznamu módů a zobrazit tabulku parseru pro tento
                mód.</p>

            <p>Zobrazení této záložky je volitelné. Chcete-li jej použít, vyberte možnost 'Nastavení zobrazení/Zobrazit další nástroje pro vývojáře' na záložce Možnosti. Pokud je volba záložky vypnuta, odkaz na stránce se seznamem nebude také povolen.</p>

        </td>
    </tr>

    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Top</a></p>
            <a name="custtext"><p class="subheadbold">Doporučené aktualizace</p></a>
            <p>Záložka Doporučené aktualizace je volitelná záložka, která může být povolena na obrazovce Možnosti, a umožní vám aktualizovat soubory cust_text.php, pokud jste tak neučinili jako součást aktualizace TNG.</p>
            <p>Použití záložky se předpokládá v případě, že mód nemůže být nainstalován, protože hledá nový komentářový řetězec v horní části souborů cust_text.php počínaje TNG v12. Tato volba bude vypnuta po kliknutí na tlačítko Aktualizovat a změně
                stávajících souborů cust_text.php. Kód kontroluje, zda byly tyto soubory již dříve aktualizovány.</p>

        </td>
    </tr>

</table>
</body>
</html>

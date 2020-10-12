<?php
include "../../helplib.php";
echo help_header("Nápověda: Základní nastavení");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="https://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="https://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="setup_help.php" class="lightlink">&laquo; Nápověda: Nastavení</a> &nbsp;|&nbsp;
                <a href="pedconfig_help.php" class="lightlink">Nápověda: Nastavení schémat &raquo;</a>
            </p>
            <h2 class="largeheader">Nápověda: <small>Základní nastavení</small></h2>
            <p class="smaller menu" style="clear: both;">
                <a href="#data" class="lightlink">Databáze</a> &nbsp;|&nbsp;
                <a href="#table" class="lightlink">Tabulky</a> &nbsp;|&nbsp;
                <a href="#path" class="lightlink">Umístění a složky</a> &nbsp;|&nbsp;
                <a href="#site" class="lightlink">Stránka</a> &nbsp;|&nbsp;
                <a href="#media" class="lightlink">Média</a> &nbsp;|&nbsp;
                <a href="#lang" class="lightlink">Jazyk</a> &nbsp;|&nbsp;
                <a href="#priv" class="lightlink">Ochrana údajů</a> &nbsp;|&nbsp;
                <a href="#name" class="lightlink">Jména</a> &nbsp;|&nbsp;
                <a href="#cem" class="lightlink">Hřbitovy</a> &nbsp;|&nbsp;
                <a href="#mail" class="lightlink">Mail</a> &nbsp;|&nbsp;
                <a href="#mobile" class="lightlink">Mobil</a> &nbsp;|&nbsp;
                <a href="#pref" class="lightlink">Prefixes</a> &nbsp;|&nbsp;
                <a href="#misc" class="lightlink">Různé</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="data"><h4 class="subheadbold">Databáze</h4></a>

            <h5>Hostitel databáze, název, uživatelské jméno, heslo</h5>
            <p>Tyto údaje použije TNG a PHP k připojení k vaší databázi. Tyto pole musí být vyplněny dřív, než bude vaše databáze
                zpřístupněna. <strong>Pozn.</strong>: Toto uživatelské jméno a heslo může být jiné, než jsou vaše obvyklé přístupové údaje k webové
                stránce.
                Pokud se po vložení těchto údajů objeví chybové hlášení, že TNG nemůže komunikovat s vaší databází,
                pak je některý z těchto údajů chybný. Neznáte-li správné údaje, vyžádejte si je u poskytovatele vašeho
                webového hostingu. Název hostitel může také obsahovat číslo portu nebo cestu do soketu (socket path), např. "localhost:3306" nebo
                "localhost:/path/to/socket".
                Tyto údaje jsou důležité, takže je zadávejte s maximální přesností. Pokud působíte jako svůj vlastní webmaster, ujistěte se, že jste
                vytvořili databázi
                a přidali do ní uživatele (uživatel musí mít VŠECHNA přístupová práva).</p>

            <h5>Režim údržby</h5>
            <p>Je-li TNG v režimu údržby, data nejsou přístupná veřejnosti. Návštěvníkovi se zobrazí zpráva,
                která mu oznámí, že na stránkách probíhá údržba a může se sem vrátit později. Vaši stránku můžete
                přepnout do režimu údržby při importu vašich dat. Pokud chcete přečíslovat vaše ID čísla, přepnutí do režimu údržby
                je nutné. Pokud jste se v režimu údržby "zasekli", můžete přímo opravit váš soubor config.php a obnovit nastavení proměnné
                $tngconfig['maint']
                na 0 nebo prázdnou.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="table"><h4 class="subheadbold">Názvy tabulek</h4></a>

            <h5>Názvy tabulek</h5>
            <p>Výchozí názvy byste neměli měnit, pokud už některé tabulky mají tyto názvy. Všechny názvy tabulek musí být vyplněny a všechny názvy
                musí být jednoznačné.
                Neměňte názvy existujících tabulek.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="path"><h4 class="subheadbold">Umístění a složky</h4></a>

            <h5>Kořenová složka</h5>
            <p>Toto je složka v systému, ve které jsou umístěny vaše soubory TNG. Není to webová adresa.
                Zapsat musíte koncové lomítko. Pokud tuto stránku otevřete poprvé, vaše kořenová složka by měla být vyplněna správně. Neměňte ji,
                pokud nejste pokročilý uživatel
                nebo nejste instruováni, jak to udělat. Pokud smažete obsah tohoto pole a stránku uložíte, správná složka se objeví po opětovném
                načtení této stránky, ale
                stránku musíte uložit znovu, aby se nová složka uložila.</p>

            <h5>Konfigurační složka</h5>
            <p>Pokud chcete vaše konfigurační TNG soubory na bezpečnější místo mimo kořenovou složku webu (takže nebudou přístupny
                z webu), zapište tuto složku zde. <strong>Musí</strong> končit koncovým lomítkem (/). Bude to pravděpodobně část kořenové složky.
                Je-li např. vaše kořenová složka "/home/www/username/public_html/genealogy/", jako konfigurační složku můžete zvolit
                "/home/www/username/".</p>

            <h5>Složky Fotografie / Dokumenty / Vyprávění / Náhrobky / Multimédia / GENDEX / Zálohy / Módy / Extensions</h5>
            <p>Do těchto polí zapište název složky nebo adresáře pro zmíněné entity. Všechny by měly mít globální přístup číst+psát+provést
                (read+write+execute, 755 nebo 775, i když některé systémy vyžadují 777).
                Složka multimédií je určena jako "záchytná" pro všechny položky médií, které se nehodí do jiných kategorií (např. videa a
                zvukové záznamy). Tyto složky mohou být vytvořeny z této obrazovky kliknutím na tlačítka "Vytvořit složku".</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="site"><h4 class="subheadbold">Vzhled a definice stránek</h4></a>

            <h5>Domovská stránka</h5>
            <p>Všechna menu v programu TNG obsahují odkaz na "domovskou stránku". Do tohoto pole zapište adresu tohoto odkazu. Standardně je to
                stránka index.php ve složce s ostatními
                soubory TNG. Musí to být relativní odkaz ("index.php" nebo "../otherhomepage.html"), nikoli absolutní odkaz
                ("http://yoursite.com").</p>

            <h5>URL genealogických stránek</h5>
            <p>Webová adresa vaší genealogické složky (např. "http://mysite.com/genealogy").</p>

            <h5>Název stránek</h5>
            <p>Obsah tohoto pole bude zobrazen v tagu HTML "Title" na každé stránce a bude zobrazen na horním okraji okna vašeho prohlížeče.</p>

            <h5>Popis stránek</h5>
            <p>Krátký popis vašich stránek pro použití v kanálu RSS.</p>

            <h5>Doctype Deklarace</h5>
            <p>Tento text je umístěn v horní části každé stránky ve veřejném prostředí a dá prohlížeči uživatele informaci, kterou potřebuje
                ke správnému zobrazení stránky. Ověřovací testy, které běží na stránkách, použijí tento údaj k určení, jaké se
                mohou objevit problémy. Pokud toto pole necháte prázdné, bude použit výchozí XHTML Transitional doctype.</p>

            <h5>Majitel stránek</h5>
            <p>Vaše jméno, případně vaše obchodní jméno. Toto jméno se objeví v odchozích mailech z TNG.</p>

            <h5>Cílový rámec</h5>
            <p>Pokud vaše stránka používá rámce, toto pole použijte pro označení, ve kterém rámci mají být zobrazeny stránky TNG. Pokud rámce
                nepoužíváte,
                nechte v tomto poli hodnotu "_self".</p>

            <h5>Vlastní záhlaví / zápatí / meta</h5>
            <p>Názvy souborů pro části stránky, které se používají jako záhlaví, zápatí a sekci HEAD ("meta") vaší TNG stránky. Dodávány jsou soubory
                s výchozími názvy.
                Používá-li se v těchto souborech kódování PHP, musí mít přípony .php. Chcete-li je využít v šablonách vzhledu, musíte tato záhlaví a
                zápatí mít nazvaná
                jako topmenu.php a footer.php.</p>

            <h5>Umístění menu</h5>
            <p>TNG menu může být na každé stránce umístěno nahoře vlevo nad jménem osoby nebo jiným číslem stránky, nebo na každé stránce nahoře
                vpravo, přímo proti jménu nebo
                jinému číslu stránky. Dynamický rozbalovací seznam pro výběr jazyku bude na obrazovce umístěn ve stejné sekci.</p>

            <h5>Zobrazit odkazy na domovskou stránku / Hledat / Přihlášení/Odhlášení / Sdílet / Tisk / Přidat záložku</h5>
            <p>Některé tyto volby (Domovská stránka/Hledat/Přihlášení) jsou na každé stránce umístěny nahoře vlevo, pod záhlavím stránky a nad linií
                záložek. Jiné
                (Sdílet/Tisk/Přidat záložku) jsou umístěny nahoře vpravo, pod lištou menu.
                Každou tuto volbu můžete pomocí ovládacích prvků zapnout nebo vypnout.</p>

            <h5>Cíl odkazu Hledat</h5>
            <p>Odkaz Hledat v horní části každé stránky ve výchozím chování otevře malé okno, ve kterém můžete hledat pomocí zápisu jména nebo čísla
                ID. Toto se nazývá "Rychlé hledání".
                Výběrem této předvolby můžete místo toho přejít na stránky Rozšířené hledání.</p>

            <h5>Skrýt popisky křtu</h5>
            <p>Tato volba umožňuje skrýt všechny zmínky o události "křtu".</p>

            <h5>Skrýt všechny stránky a údaje k DNA</h5>
            <p>Pokud nebudete používat programové funkce, které souvisí s DNA, a chtěli byste je odstranit ze všech stránek veřejné části TNG,
                nastavte tuto volbu na Ano. Testy DNA již nebudou přístupné
                z veřejných menu ani nebudou zobrazeny na stránkách jednotlivých osob.</p>

            <h5>Výchozí strom</h5>
            <p>Pokud existuje více stromů, na všech stránkách, kde je možný výběr stromu (včetně funkce hledání
                na vaší domovské stránce) bude výchozí nastavení "Všechny stromy". Chcete-li, aby tento výběr nabízel pouze určitý strom,
                tento strom vyberte zde. Kdekoli uživatel zapíše URL bez ID čísla stromu (nebo s prázdným ID číslem stromu), dotaz
                bude směřovat k tomuto stromu. <strong>POZN.</strong>: Pokud máte pouze jeden strom, je lepší toto pole nechat prázdné.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="media"><h4 class="subheadbold">Média</h4></a>

            <h5>Typ souborů fotografií</h5>
            <p>Přípona souboru všech malých fotografií používaných ve schématech. Ostatní fotografie nemusí obsahovat tuto příponu. Pro většinu
                fotografií je doporučena přípona .jpg.</p>

            <h5>Zobrazit rozšířenou informaci o obrázku</h5>
            <p>Pokud je tato volba zaškrtnuta, budou u každé fotografie zobrazeny rozšířené informace. Ty obsahují fyzický název souboru, rozměry v
                pixelech a
                existující údaje IPTC.</p>

            <h5>Maximální výška a šířka obrázku</h5>
            <p>Jsou-li tyto hodnoty nastaveny (pixely), obrázky větší než tyto rozměry budou při zobrazení ve veřejném prostředí zmenšeny (použitím
                HTML).</p>

            <h5>Předpona/prefix pro náhledy</h5>
            <p>Při automatickém generování náhledu přidá TNG tuto hodnotu před originální název souboru a vytvoří tak název souboru náhledu. Pokud
                název originálního souboru obsahuje údaj o cestě,
                předpona bude vložena přímo před název souboru. Tato předpona může obsahovat název složky (např. "thumbnails/"). Pokud
                použijete název složky jako součást přípony, ujistěte se, že tato složka existuje a má stejná oprávnění jako složka nadřízená
                fotografií.</p>

            <h5>Přípona/sufix pro náhledy</h5>
            <p>Při automatickém generování náhledu přidá TNG tuto hodnotu k originálnímu názvu souboru a vytvoří tak název souboru náhledu.</p>

            <h5>Maximální výška náhledu</h5>
            <p>TNG automaticky vytvoří náhled obrázku, který nebude vyšší, než je nastavená výška (pixely).</p>

            <h5>Maximální šířka náhledu</h5>
            <p>TNG automaticky vytvoří náhled obrázku, který nebude širší, než je nastavená šířka (pixely).</p>

            <h5>Použít výchozí náhledy</h5>
            <p>Pokud osoba nemá výchozí fotografii a tato volba je povolena, na všech stránkách, na kterých je odkaz na tuto osobu, bude použit místo
                toho obecný náhled, který rozlišuje pohlaví.</p>

            <h5>Sloupců v zobrazení náhledů</h5>
            <p>Při prohlížení všech souborů v zobrazení náhledů budou tyto náhledy zobrazeny v jednom řádku. Pokud jich existuje víc,
                budou další řádky zobrazeny až do počtu řádku odpovídajícímu "Maximálnímu počtu výsledků hledání".</p>

            <h5>Maximální počet znaků v seznamu poznámek</h5>
            <p>Chcete-li zkrátit poznámky, které jsou zobrazovány na stránkách se seznamy (jako jsou veřejné stránky fotografie, dokumenty a
                vyprávění), nastavte toto pole na maximální
                počet znaků, který má být zobrazen. Necháte-li jej prázdné, bude zobrazena kompletní poznámka.</p>

            <h5>Povolit prezentaci</h5>
            <p>Umožní automatické postupné zobrazování fotografií ve veřejném prostředí stránek po kliknutí na odkaz "Zahájit prezentaci". Nastavení
                této hodnoty na 'Ne' skryje tento odkaz a zakáže použití této funkce.</p>

            <h5>Automatické opakování prezentace</h5>
            <p>Nastavení této hodnoty na 'Ano' povolí automatický pokračující běh prezentace.</p>

            <h5>Umožnit prohlížeč obrázků</h5>
            <p>Nastavení této volby na 'Vždy' zobrazí každou obrázkovou položku (soubory .jpg, .gif a .png) v prohlížeči obrázků. Nastavení na 'Pouze
                dokumenty' vypne
                prohlížeč obrázků pro všechny obrázková média, které nejsou 'Dokumenty' nebo jiné typy médií, které se chovají jako Dokumenty.</p>

            <h5>Výška prohlížeče obrázků</h5>
            <p>Nastavení této volby na 'Vždy zobrazit celý obrázek' zajistí, že je obrázek viditelný ve výchozích rozměrech. Nastavení na 'Pevná
                (640px)' zapříčiní, že obrázky vyšší než
                640 pixelů budou při zobrazení oříznuty na tuto výšku. Ovládací prvky prohlížeče mohou být dále používány k posunu obrázku nebo
                přiblížení či oddálení.</p>

            <h5>Skrýt média osob</h5>
            <p>Je-li tato předvolba nastavena na "Ano", seznam médií na stránce osoby bude začínat ve sbaleném stavu. Místo náhledů a popisků uvidíte
                pouze celkový počet podle typů médií.
                Návštěvníci budou moci každou sekci médií rozbalit, ale po obnovení načtení stránky bude seznam opět sbalen.</p>

            <h5>Při smazání současně odstranit fyzický soubor</h5>
            <p>Tato volba určuje, co se stane, když bude smazán individuální záznam médií. Je-li tato možnost nastavena na "Ano", přidružený fyzický
                soubor bude také smazán.
                Je-li volba nastavena na hodnotu "Ne", bude odebrán pouze záznam v databázi a fyzický soubor zůstane neporušený. Je-li tato možnost
                nastavena na možnost "Na vyžádání",
                budete vyzváni k rozhodnutí, zda má být přidružený soubor smazán nebo ne.</p>

            <h5>Zobrazit fotografie na jednom řádku</h5>
            <p>Toto se týká náhledů zobrazených na stránce osoby. Pokud je v nějaké oblasti obsaženo více náhledů, lze tuto volbu použít k zobrazení
                všech náhledů vodorovně na jednom řádku
                (pokud je obrázků příliš mnoho na to, aby byly všechny zobrazeny na jednom řádku, budou pokračovat na dalším řádku) nebo v seznamu,
                jak to bylo obvyklé ve starších verzích TNG.
                Pokud jsou náhledy zobrazeny vodorovně, nebudou u nich zobrazeny žádné popisky. Média, která nemají náhledy, budou stále zobrazena
                svisle.</p>

            <h5>Rozdělit média do složek stromů</h5>
            <p>Ve výchozím nastavení jsou všechna fyzická média z každé kolekce (tj. Fotografie, Dokumenty, Historie atd.) uložena ve stejné fyzické
                složce. Aktivace této volby způsobí,
                že TNG bude ukládat média sice ve složkách jejich příslušných kolekcí, ale v podsložkách podle ID jejich přiřazených stromů (pokud
                není připojen žádný strom, soubor zůstane
                ve hlavní složce kolekce). Kliknutím na tlačítko "Převést" přesunete příslušná média do této nové struktury složek. Pokud cílové
                složky stromů neexistují, budou vytvořeny.</p>

            <h5>Favicon</h5>
            <p>"Favicon" je malá ikona zobrazená v adresním řádku prohlížeče nalevo od adresy URL stránky. TNG neobsahuje nástroj, který vám pomůže
                takovou ikonu vytvořit, ale pokud
                nějakou máte k dispozici a chcete ji použít, nahrajte ji do hlavní složky TNG a název souboru zadejte zde.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="lang"><h4 class="subheadbold">Jazyk</h4></a>

            <h5>Jazyk</h5>
            <p>Výchozí složka jazyka (např. 'Czech'). Pro návštěvníky vašich stránek můžete mít dostupných několik jazyků, ale tento jazyk bude vždy
                zobrazen jako první.</p>

            <h5>Znaková sada</h5>
            <p>Znaková sada vašeho výchozího jazyka. Pokud toto pole ponecháte prázdné, bude použita výchozí znaková sada vašeho prohlížeče. Znaková
                sada pro angličtinu a jiné západoevropské jazyky používající 26 znakovou
                římskou abecedu je ISO-8859-1. Převládající kódování češtiny jsou ISO-8859-2, Windows-1250 a UTF-8.</p>

            <h5>Dynamická změna jazyka</h5>
            <p>Pokud máte nastaveno více jazyků a chcete, aby byli uživatelé schopni vybrat jiný jazyk "za chodu",
                vyberte <em>Povolit</em>.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="priv"><h4 class="subheadbold">Ochrana údajů</h4></a>

            <h5>Vyžadovat přihlášení</h5>
            <p>Každý uživatel může běžně prohlížet veřejné prostředí vašich stránek, s přihlášením může volitelně vidět data žijících osob. Pokud však
                chcete, aby se muset přihlásit každý před tím než muže spatřit cokoli z vašich stránek, zaškrtněte toto pole.</p>

            <h5>Omezit přístup pouze na připojený strom</h5>
            <p>Je-li Vyžadovat přihlášení nastaveno na 'Ano', pak nastavení této volby na 'Ano' způsobí, že uživatelé budou moci pouze vidět data
                spojená se svými
                připojenými stromy. Všechny jiné osoby, rodiny, prameny, atd. budou skryty.</p>

            <h5>Zobrazit údaje CJKSpd</h5>
            <p>Chcete-li vždy zobrazovat data CJKSpd (Církev Ježíše Krista Svatých posledních dní (mormoni), jsou-li k dispozici), vyberte
                <em>Vždy</em> (dříve to bylo výchozí). Vypnout zobrazení všech údajů CJKSpd
                a možnosti ručně zapsat údaje CJKSpd můžete výběrem <em>Nikdy</em>. Chcete-li tuto možnost přepínat v závislosti na
                uživatelském oprávnění, vyberte <i>Podle práv uživatele</i>. V tomto případě údaje CJKSpd uvidí pouze přihlášení uživatelé, kteří mají
                oprávnění je vidět.
                Pro ostatní uživatele budou skryty.</p>

            <h5>Zobrazit údaje o živých osobách</h5>
            <p>Chcete-li vždy zobrazovat údaje žijících osob (data a místa), vyberte <i>Vždy</i>. Vypnout zobrazení údajů žijících osob můžete
                výběrem <i>Nikdy</i>. Chcete-li tuto možnost přepínat v závislosti na
                uživatelském oprávnění, vyberte <i>Podle práv uživatele</i>. V tomto případě údaje žijících osob uvidí pouze přihlášení uživatelé,
                kteří mají oprávnění je vidět.
                Pro ostatní uživatele budou skryty.</p>

            <h5>Zobrazit jména žijících osob</h5>
            <p>Chcete-li skrýt jména osob označených jako žijící (chybí údaje o úmrtí nebo pohřbu a zároveň se narodili před více než 110 lety),
                vyberte <em>Ne</em>. Jména žijících
                osob budou nahrazena slovem "Žijící". Pro zobrazení příjmení a iniciály křestního jména žijících osob vyberte <em>Zkrátit křestní
                    jméno</em>. Chcete-li
                jména žijících osob zobrazit každému, vyberte <em>Ano</em>.</p>

            <h5>Zobrazit jména osob označených jako neveřejné</h5>
            <p>Chcete-li skrýt jména osob označených jako Neveřejné, vyberte <em>Ne</em>. Jména neveřejných
                osob budou nahrazena slovem "Neveřejné". Pro zobrazení příjmení a iniciály křestního jména neveřejných osob vyberte <em>Zkrátit
                    křestní jméno</em>. Chcete-li
                jména neveřejných osob zobrazit každému, vyberte <em>Ano</em>.</p>

            <h5>Zobrazit zprávu o povolení cookies</h5>
            <p>Návštěvníkům stránek se zobrazí v pravém dolním rohu obrazovky malé vyskakovací okno a upozorní je, že web používá cookies.
                Jakmile návštěvník klikne na tlačítko "Rozumím", zpráva zmizí a soubor cookie bude nastaven na zapamatování akce.
                Dokud tento soubor cookie přetrvává, návštěvníkovi se při následných návštěvách vyskakovací okno již znovu nezobrazí.</p>

            <h5>Zobrazit odkaz na zásady ochrany dat</h5>
            <p>Návštěvníkům stránek se zobrazí v zápatí v dolní části každé stránky odkaz na zásady ochrany dat na webu.
                Odkaz se také zobrazí ve vyskakovacím okně týkajícím se souborů cookie (viz výše) a na stránkách, kde je návštěvník požádán, aby dal
                souhlas s uložením osobních
                údajů (registrace nového účtu, navrhnout/kontaktujte nás). Kopie těchto zásad lze nalézt ve většině jazykových složek.
                Tento dokument se nazývá data_protection_policy.php. Pokud návštěvník používá jazyk, který neobsahuje překlad těchto zásad, bude mu
                zobrazena anglická verze.</p>

            <h5>Žádost o souhlas ohledně osobních údajů</h5>
            <p>Před odesláním připomínek, návrhů nebo registrace nového uživatele budou návštěvníci stránek vyzváni, aby zaškrtli políčko, ve kterém
                uvedou
                souhlas s uložením údajů ve formuláři, který vyplnili. Není-li políčko zaškrtnuto, tlačítko pro odeslání bude neaktivní. Pokud
                přesto dojde ke kliknutí na toto tlačítko, vyskakovací okno upozorní návštěvníka, že musí před odesláním formuláře zaškrtnouo políčko
                souhlasu.</p>

            <h5>reCAPTCHA</h5>
            <p>reCAPTCHA je bezplatná služba, která chrání vaše stránky před spamem a zneužitím. Využívá nástroj pokročilé analýzy rizik a dokáže
                oddělit lidi a roboty.
                Návštěvníci budou muset pouze zaškrtnout políčko označující, že nejsou robot. Chcete-li tuto službu aktivovat, budete potřebovat dva
                klíče: Site Key a Secret Key.</p>

            <h5>Klíče Site Key a Secret Key</h5>
            <p>Chcete-li získat své klíče Site Key a Secret Key, přejděte na stránku https://www.google.com/recaptcha/admin. Pokud ještě nemáte účet
                Google, bude si jej muset vytvořit.
                Pokud máte účet Google, na vyžádání se přihlaste a postupujte podle pokynů pro vytvoření klíčů. Po zobrazení výzvy k zadání
                adresy/názvu domény NEZADÁVEJTE "www" a
                nezadávejte zadní lomítko. Po vytvoření klíčů je vložte do polí na této stránce.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="name"><h4 class="subheadbold">Jména</h4></a>

            <h5>Pořadí jména a příjmení</h5>
            <p>Určí, jak budou ve většině případů jména zobrazena (některé seznamy vždy zobrazí příjmení jako první). Zvolit můžete zobrazení
                křestního jména jako první nebo příjmení jako první.
                Není-li nic vybráno, bude zobrazeno jako první křestní jméno.</p>

            <h5>Všechna příjmení velkými písmeny</h5>
            <p>Umožní zobrazit všechna příjmení velkými písmeny. Je-li tato volba nastavena na "Ne", budou jména zobrazena tak, jak byla zapsána nebo
                naimportována.</p>

            <h5>Předpony příjmení</h5>
            <p>Určí, jak se bude zacházet s předponami příjmení (např. "de" nebo "van"). Standardně je vše, co je obsaženo v poli příjmení souboru
                GEDCOM součástí příjmení, a podle toho jsou i
                příjmení tříděna ("de Kalb" je dříve než "van Buren"). Předpony příjmení můžete ponechat jako součást příjmení nebo je můžete oddělit
                jako samostatné subjekty (takto bude "van Buren" v řazení před "de Kalb"). Toto nebude mít vliv na existující příjmení, dokud je ručně
                neupravíte nebo nepřevedete pomocí surnameconvert400.php.</p>

            <h5>Zjištění předpon při importu</h5>
            <p>Pokud jste zvolili oddělení předpon jako samostatných subjektů, tato sekce stanoví pravidla, která pomohou rozhodnout importovací
                rutině, co je předponou. Předpony jsou definovány jako
                části jmen oddělené mezerami, ale vy můžete zvolit, kolik předpon každého jména bude součástí předpony v TNG. Jinými slovy, pokud
                určíte, že
                "Počet předpon každého (max)" je 1, pak bude do pole předpona ze jména "van der Merwe" přesunuto pouze "van". Na druhou stranu, pokud
                tuto hodnotu nastavíte na 2 nebo vyšší, předponou
                bude "van der". Označit můžete také určité předpony, které budou vždy odděleny jako samostatné předpony. Jinými slovy, nastavíte-li
                tuto hodnotu na "van der", pak
                bude "van der" vždy uvažována jako platná předpona nezávisle na tom, jak vysoká nebo nízká je předchozí hodnota. Více hodnot oddělujte
                čárkami. Je-li ve jméně předpona oddělena
                apostrofem, tento apostrof uveďte v seznamu také. Např.: "van,vander,van der,d',a',de,das".</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="cem"><h4 class="subheadbold">Hřbitovy</h4></a>

            <h5>Maximální počet řádků ve sloupci (prům.)</h5>
            <p>Pokud máte definováno velké množství hřbitovů, tento údaj řekne TNG, že je-li dosažen zadaný počet, seznam má být rozdělen
                a vytvořen další sloupec.</p>

            <h5>Potlačit kategorii "Neznámé"</h5>
            <p>Definujete-li hřbitov s chybějícími údaji o lokalitě (např. bez kraje nebo okresu), TNG vytvoří záhlaví nazvané
                "Neznámé" a tato prázdná pole zde budou seskupena. Výběr této volby způsobí, že TNG toto záhlaví vynechá.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="mail"><h4 class="subheadbold">Mail a registrace</h4></a>

            <h5>Emailová adresa</h5>
            <p>Vaše emailová adresa. Požádá-li návštěvník o nový uživatelský účet, email bude posílán z této adresy. Na tuto adresu budou také
                zasílány
                všechny zprávy ze stránky "Napište nám". Zprávy pocházející z formuláře "Návrh" přijdou na tuto adresu, pokud není se stromem
                odpovídajícím
                stránce, ze které byl poslán návrh, spojena žádná emailová adresa (jinak bude zpráva poslána na tuto adresu).</p>

            <h5>Posílat všechny maily z výše uvedené adresy</h5>
            <p>Když vám uživatel pošle zprávu prostřednictvím TNG, program se ji pokusí odeslat, jako by pocházela od něj,
                abyste mohli snáze odpovědět. Někteří poskytovatelé hostingu to však neumožňují. Odmítají posílat emaily, když adresa odesílatele
                nepochází ze stejné domény, jako jsou vaše stránky. Pokud zjistíte, že emaily z TNG nejsou posílány, váš hostitel se právě takto
                chová. Je-li to tento případ, nastavení této volby na Ano způsobí, že TNG bude posílat všechny maily z adresy
                administrátora TNG (zapsaná výše). To by mělo problém vyřešit.</p>

            <h5>Povolit nové registrace uživatelů</h5>
            <p>Umožní vypnout možnost návštěvníků požádat o uživatelský účet na vašich stránkách.</p>

            <h5>Upozornit na návrhy k přezkoumání</h5>
            <p>Nastavení této hodnoty na "Ano" zajistí, že administrátorovi bude zaslána emailová zpráva, kdykoliv někdo s právem Vkládání
                vloží předběžnou změnu a čeká na administrativní přezkoumání.</p>

            <h5>Vytvořit nový strom pro uživatele</h5>
            <p>Je-li tato volba nastavena na Ano, pro každou novou uživatelskou registraci bude automaticky vytvořen nový strom a
                uživatel bude připojen k tomuto stromu.</p>

            <h5>Automaticky schválit nové uživatele</h5>
            <p>Všechny nové uživatelské registrace vyžadují běžně schválení administrátora před tím, než se stanou aktivními.
                Změnou tohoto nastavení na Ano budou automaticky aktivní všechny nové uživatelské požadavky. Nastavení uživatelského účtu budete
                ale moci upravit, abyste měli jistotu, že má uživatel přístupová práva, která jste mu chtěli dát.</p>

            <h5>Posílat schvalovací mail</h5>
            <p>Pokud je tato volba nastavena na Ano, každému potenciálnímu novému uživateli bude poslán email, který ho bude informovat, jeho
                požadavek
                byl obdržen a je zpracováván. Toto neplatí, pokud jsou nové registrace automaticky aktivovány.</p>

            <h5>Zahrnout heslo do uvítacího mailu</h5>
            <p>Heslo zvolené uživatelem je běžně zahrnuto na "uvítacího" emailu, který jej informuje, že je účet
                nyní aktivní. Nechcete-li, aby bylo heslo do emailu vkládáno, nastavte tuto hodnotu Ne.</p>

            <h5>Použít ověření SMTP</h5>
            <p>TNG posílá normálně maily pomocí PHP funkce "mail". Chcete-li raději použít Simple Mail Transfer Protocol, pak tuto hodnotu nastavte na
                "Ano".
                Zobrazí se navíc některé další volby: Název SMTP hostitele, Uživatelské jméno pro email, Heslo pro email a Číslo portu. Správné
                hodnoty těchto polí
                by vám měl být schopen dát poskytovatel vašeho hostingu.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Top</a></p>
            <a id="mobile"><h4 class="subheadbold">Mobil</h4></a>

            <p>Sekce Mobil vám umožní určit, jak se bude TNG zobrazovat na chytrých telefonech a tabletech.</p>

            <h5>Povolit responzivní tabulky</h5>
            <p>Je-li tato volba nastavena na Ano, bbude aktivován plugin Tablesaw jQuery, který umožňuje responzivní tabulky.<br>Je-li volba nastavena
                na Ne, plugin Tablesaw jQuery nebude aktivní.</p>

            <h5>Typ responzivní tabulky</h5>
            <p>Typ responzivní tabulky může být nastaven na
            <ul>
                <li><strong>Toggle</strong>, který je výchozí, a zobrazí data ve sloupcích založených na šířce displeje a přiřazené prioritě. Otočením
                    displeje chytrého telefonu nebo tabletu na šířku budou zobrazeny další sloupce dat.
                </li>

                <li><strong>Stack</strong>, který shrne záhlaví tabulky do dvousloupcového návrhu se záhlavím nalevo, je-li šířka výřezu menší než
                    40em (640px).
                </li>

                <li><strong>Swipe</strong>, který umožní uživateli k navigaci sloupců použít gesto posunu (nebo použít levé a pravé tlačítko).</li>
            </ul>
            <br>
            <h5>Povolit přepínač módů responzivních tabulek:</h5>
            <p>Volba přepínače módů umožní uživateli přepínat mezi jednotlivými typy zobrazení sloupců tabulek: toggle, stack nebo swipe.</p>

            <h5>Povolit minimapu responzivních tabulek</h5>
            <p>Použití minimapy přidá sérii malých teček ukazujících, které sloupce jsou aktuálně viditelné a které jsou skryté.
                K dispozici pouze v módu swipe a toggle. </p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Top</a></p>
            <a id="pref"><h4 class="subheadbold">Předpony a přípony</h4></a>

            <p>Tato písmena ve spojení s číslicí tvoří identifikační čísla (ID čísla) osob, rodin, pramenů, úložišť a poznámek ve vaší databázi.
                Většina genealogických
                programů používá stejnou sadu standardních předpon (a žádné přípony). Pokud váš desktopový program používá přípony nebo jiné předpony,
                můžete je zadat zde.
                Nejsou-li zadány správné předpony nebo přípony, některé funkce TNG nebudou pracovat správně.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="misc"><h4 class="subheadbold">Různé</h4></a>

            <h5>Maximální počet výsledků hledání</h5>
            <p>Tato volba omezuje počet výsledků, které mohou být zobrazeny z veřejného vyhledávacího dotazu. Může to být relativně malé, zvládnutelné
                číslo, aby byla
                maximalizována efektivnost a zlepšení zkušeností uživatelů.</p>

            <h5>Osoby začínají na</h5>
            <p>Tato volba označuje, které údaje budou viditelné nejdříve, když je zobrazen záznam osoby. Pokud vyberete
                "Pouze osobní údaje", ostatní kategorie jako Poznámky, Citace nebo Fotografie a Vyprávění
                budou skryty, dokud uživatel nerozkryje příslušnou kategorii nebo "Vše".</p>

            <h5>Zobrazit poznámky</h5>
            <p>Tato volba vám umožní zvolit, kde budou na stránce osoby zobrazeny poznámky. Možnosti jsou následující:</p>

            <ul>
                <li>V sekci poznámek: Všechny poznámky budou zobrazeny ve zvláštním bloku na konci stránky.</li>
                <li>Pod odpovídajícími událostmi, kde je to možné: Poznámky k určitým událostem budou zobrazeny přímo pod odpovídajícími událostmi.
                    Obecné poznámky budou zobrazeny
                    na konci "Osobní" sekce a každé sekce "Rodina". Pokud jsou obecné poznámky dlouhé, objeví se posuvník, který zajistí, že stránka
                    nebude moc dlouhá
                    (maximální výška oblasti je definována v souboru genstyle.css v bloku "notearea").
                </li>
                <li>Pod událostmi mimo obecných poznámek: Totéž jako v předchozím případě, pouze obecné poznámky budou zobrazeny vždy v odděleném
                    bloku na konci stránek. Neukládá se
                    žádná maximální výška.
                </li>
            </ul>

            <h5>Posouvání citací</h5>
            <p>Nastavení této předvolby na "Ano" způsobí, že oblast pramenů na konci každé stránky osoby bude mít maximální výšku. Pokud je u osoby
                přiřazeno více citací pramenů
                než jsou maximální rozměry oblasti, objeví se v této oblasti posuvník.</p>

            <h5>Časový odstup serveru (v hodinách)</h5>
            <p>Nachází-li se váš server v jiné časové zóně než vy, můžete sem napsat rozdíl v hodinách. Je-li váš čas vyšší než čas serveru, zapište
                záporné číslo.</p>

            <h5>Upravit prodlevu (v minutách)</h5>
            <p>Počet minut, který je uživateli povolen pro výhradní právo u editace záznamu osoby nebo rodiny. Během této doby uvidí jiný uživatel,
                který se pokouší upravovat stejný
                záznam, zprávu, která mu sdělí, že je záznam uzamčen. Pokud se blíží čas k zapsanému limitu a původní uživatel stále záznam upravuje,
                uvidí tento uživatel zprávu,
                která jej bude varovat, aby co nejrychleji uložil své změny. Pokud uživatel své změny neuloží před tím, než získá přístup k tomuto
                záznamu jiný uživatel, jeho změny
                budou ztraceny.</p>

            <h5>Maximální počet generací při uložení GEDCOMU</h5>
            <p>Maximální počet generací, které mohou být exportovány ve veřejném požadavku na vytvoření souboru GEDCOM.</p>

            <h5>Co je nového dny</h5>
            <p>Počet dní, po které budou na stránce "Co je nového" zobrazovány nové položky. Toto omezení odstraníte nastavením hodnoty na nulu. To
                zapříčiní, že na seznamu zůstanou
                starší položky, dokud nebudou nahrazeny novějšími.</p>

            <h5>Co je nového limit</h5>
            <p>Maximální počet položek v každé kategorii, který bude zobrazen na stránce "Co je nového".</p>

            <h5>Přednost číselného data</h5>
            <p>Zapíšete-li číselné datum (např. 04/09/2008), tato volba zajistí, zda bude zápis data interpretován jako Měsíc/Den/Rok (9 Dub 2008)
                nebo Den/Měsíc/Rok (4 Zář 2008).</p>

            <h5>První den v týdnu</h5>
            <p>Tento den bude prvním sloupcem zleva při zobrazení stránky kalendáře.</p>

            <h5>Údaje rodičů na stránce osoby</h5>
            <p>Vyberte, které události (pokud nějaké) spojené s rodinou rodičů osoby mají být zobrazeny.</p>

            <h5>Konec řádku</h5>
            <p>Jedná se o znakový řetězec, který bude vložen na konec každého řádku při exportu souboru GEDCOM. Je to též řetězec,
                který bude obsahovat konec řádku při importu. Výchozím je "\r\n", které znamená "návrat na začátek řádku a odřádkování".
                Některé programy nebo operační systémy preferují jen návrat na začátek řádku (\r) nebo odřádkování (\n), takže
                můžete v některých případech toto nastavení měnit.</p>

            <h5>Typ šifrování</h5>
            <p>Před uložením do databáze jsou hesla v TNG šifrována. Díky tomu jednoduše nelze ruční opravou databáze heslo měnit nebo smazat.
                Výchozí metodou šifrování je md5, ale zde můžete vybrat jinou metodu.</p>

            <h5>Připojit záznamy míst ke stromům</h5>
            <p>Je-li tato volba nastavena na "Ano", každý záznam místa pak bude připojen k místu ve vašem stromě. To znamená, že máte-li více stromů,
                může se
                stejné místo objevit v tabulce míst vícekrát, protože je spojeno s více stromy. Změníte-li tuto volbu na "Ne", bude
                vám dána možnost automaticky sloučit všechna místa do jednoho seznamu. Pokud tuto volbu změníte na "Ano", zobrazí se vám možnost
                připojit
                určitý strom ke všem místům (pokud neměly dříve žádné připojení).</p>

            <h5>Geokódovat všechna nová místa</h5>
            <p>Je-li tato volba nastavena na "Ano", všechna nová místa zapsaná v Admin/Osoba a Admin/Rodina budou automaticky geokódována (předpokládá
                to
                připojení k internetu).</p>

            <h5>Znovu použít smazaná ID čísla</h5>
            <p>Je-li tato volba nastavena na "Ano" u nové osoby, rodiny, pramenu a úložišti pramenů, budou znovu použita čísla ID, která byla dříve
                smazána.</p>

            <h5>Zobrazit poslední import</h5>
            <p>Pokud je tato volba nastavena na "Ano", bude na stránkách Co je nového a Statistiky zobrazeno datum posledního importu souboru GEDCOM,
                je-li vybrán strom.</p>

            <h5>Zobrazit oznámení 'Důležité úkoly'</h5>
            <p>Nastavte "Ano", pokud chcete, aby program TNG zobrazoval v horní části nabídky Administrace seznam důležitých úkolů. Ty budou obsahovat
                výzvy k zálohování dat,
                ke kontrole nových uživatelských registrací a další. Můžete i nadále zvolit sbalení zprávy, i když zde umožníte jejich zobrazení.</p>

            <h5>Zobrazit celkové součty záznamů v menu Administrace</h5>
            <p>Umožní TNG zobrazit v hlavní nabídce Administrace součty pro každou kategorii. Například, pokud máte v TNG uloženo 1000 lidí, na pravé
                straně lišty "Osoby" uvidíte "1000".</p>

            <h5>Upozornit, pokud záloha nebyla vytvořena během tohoto počtu dní</h5>
            <p>Po uplynutí zadaného počtu dní od vytvoření poslední zálohy alespoň jedné z vašich tabulek, TNG zařadí upozornění do sekce "Důležité
                úkoly" v horní části nabídky Administrace.
                Pokud nechcete tato upozornění zobrazovat, nastavte tuto hodnotu na nulu.</p>

            <h5>Používám TNG offline</h5>
            <p>Je-li vybráno "Ano", TNG použije lokální verze namísto on-line verzí knihoven třetích stran (např. JQuery) a nebude se pokoušet o
                přístup ke Google mapám.</p>

        </td>
    </tr>

</table>
</body>
<?php echo "</html>"; ?>

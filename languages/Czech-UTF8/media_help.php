<?php
include "../../helplib.php";
echo help_header("Nápověda: Média");
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
                <a href="more_help.php" class="lightlink">&laquo; Nápověda: Více</a> &nbsp;|&nbsp;
                <a href="collections_help.php" class="lightlink">Nápověda: Kolekce &raquo;</a>
            </p>
            <h2 class="largeheader">Nápověda: <small>Média</small></h2>
            <p class="smaller menu" style="clear: both;">
                <a href="#search" class="lightlink">Hledat</a> &nbsp;|&nbsp;
                <a href="#add" class="lightlink">Přidat</a> &nbsp;|&nbsp;
                <a href="#edit" class="lightlink">Upravit</a> &nbsp;|&nbsp;
                <a href="#delete" class="lightlink">Vymazat</a> &nbsp;|&nbsp;
                <a href="#convert" class="lightlink">Převést</a> &nbsp;|&nbsp;
                <a href="#album" class="lightlink">Přidat do alba</a> &nbsp;|&nbsp;
                <a href="#sort" class="lightlink">Seřadit</a> &nbsp;|&nbsp;
                <a href="#thumbs" class="lightlink">Náhledy</a> &nbsp;|&nbsp;
                <a href="#import" class="lightlink">Import</a> &nbsp;|&nbsp;
                <a href="#upload" class="lightlink">Nahrát</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="search"><h4 class="subheadbold">Hledat</h4></a>
            <p>Nalezení existujících médií vyhledáním celého nebo části <strong>ID čísla média, titulu, popisu, umístění</strong> nebo
                <strong>základního textu</strong>. Pro další zúžení vašeho výběru použijte další dostupné možnosti.
                Vyhledávání bez vybraných voleb a bez zapsaných hodnot ve výběrových polí povede k výběru všech médií z vaší databáze. Vyhledávací
                volby obsahují:</p>

            <h5 class="optionhead">Strom</h5>
            <p>Omezí výsledek na média spojená pouze s vybraným stromem.</p>

            <h5 class="optionhead">Kolekce</h5>
            <p>Omezí výsledek na média vybraného typu kolekce. Chcete-li přidat novou kolekci, klikněte na tlačítko "Přidat kolekci", a v zobrazeném
                okně vyplňte formulář.
                Pro vaši novou kolekci musíte vytvořit složku a musíte vytvořit vlastní ikonu (nebo použít nějakou stávající). Pole "Stejné nastavení
                jako"
                vám umožní označit, ze které ze stávajících kolekcí si nová kolekce vezme nastavení.</p>

            <h5 class="optionhead">Přípona souboru</h5>
            <p>Před kliknutím na tlačítko Hledat zapište příponu souboru (např. "jpg" nebo "gif") pro omezení výsledku na média
                s názvem souboru, který obsahuje tuto příponu.</p>

            <h5 class="optionhead">Pouze nepřipojené</h5>
            <p>Před kliknutím na tlačítko Hledat zaškrtněte toto políčko pro omezení výsledku na média, která nejsou připojena k žádné osobě,
                rodině, pramenu, úložišti pramenů nebo místu.</p>

            <h5 class="optionhead">Stav</h5>
            <p><strong>(pouze Náhrobky)</strong> Před kliknutím na tlačítko Hledat vyberte ze seznamu stav pro zobrazení všech záznamů náhrobků se
                stejným stavem.</p>

            <h5 class="optionhead">Hřbitov</h5>
            <p>Před kliknutím na tlačítko Hledat vyberte ze seznamu hřbitov pro zobrazení všech záznamů náhrobků spojených s vybraným hřbitovem.</p>

            <p>Vyhledávací kritéria, která zadáte na této stránce, budou uchována, dokud nekliknete na tlačítko <strong>Obnovit</strong>, které znovu
                obnoví všechny výchozí hodnoty.</p>

            <h5 class="optionhead">Akce</h5>
            <p>Tlačítko Akce vedle každého výsledku hledání vám umožní upravit, vymazat nebo otestovat výsledek. Chcete-li najednou vymazat více osob,
                zaškrtněte políčko ve sloupci
                <strong>Vybrat</strong> u každého záznamu, která má být odstraněn, a poté klikněte na tlačítko "Vymazat označené" na začátku seznamu.
                Pro zaškrtnutí nebo vyčištění všech výběrových políček najednou
                můžete použít tlačítka <strong>Vybrat vše</strong> nebo <strong>Vyčistit vše</strong>.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="add"><h4 class="subheadbold">Přidat nové médium</h4></a>

            <p>Chcete-li přidat nové médium, klikněte na záložku <strong>Přidat nové</strong> a poté vyplňte formulář. Další informace jako obrázek
                mapy, informace o místě a
                odkazy na osoby, rodiny a další subjekty můžete přidat po uložení nebo zamknutí záznamu. Význam jednotlivých polí je následující:</p>

            <h5 class="optionhead">Kolekce</h5>
            <p>Vyberte typ média, kterým je vaše položka (např. fotografie, dokumenty, náhrobky, vyprávění, zvukový záznam nebo video). Žádná z <span
                    class="emphasis">kolekcí</span> médií není omezena typem souboru.</p>

            <h5 class="optionhead">Toto médium je z externího zdroje</h5>
            <p>Toto políčko zaškrtněte, pokud se obrázek nachází někde na internetu jinde než na vašem serveru. Do pole označeného "URL média" musíte
                zapsat
                úplnou webovou adresu (např. <em>http://www.tentoweb.com/image.jpg</em>), a
                pokud chcete mít náhled tohoto obrázku, musíte přidat vlastní (TNG jej nevytvoří).</p>

            <h5 class="optionhead">Soubor s médiem</h5>
            <p>Vyberte fyzický soubor (ze svého lokálního počítače nebo z vašich webových stránek) pro tuto mediální položku.</p>

            <h5 class="optionhead">Soubor pro nahrání</h5>
            <p>Pokud vaše nová mediální položka ještě nebyla nahrána na vaše webové stránky, klikněte na tlačítko "Procházet" a vyhledejte ji na vašem
                disku.
                Je-li tato položka již na vašich stránkách, nechte toto pole prázdné.</p>

            <h5 class="optionhead">Název souboru na stránkách / Media URL</h5>
            <p>Pokud jste již vaši mediální položku nahráli na stránky, zapište umístění a název souboru vaší položky tak, jak existuje ve složce
                odpovídající kolekce na vašich webových stránkách,
                nebo klikněte na tlačítko "Vybrat" a vyhledejte soubor ve složce příslušné kolekce. Pokud nahráváte vaši mediální položku nyní
                pomocí předchozího pole, použijte toto pole pro zápis umístění a názvu souboru až po nahrání souboru. Předpokládané umístění a
                název souboru bude předvyplněno. Pokud jste označili, že toto médium pochází z externího zdroje, popis tohoto pole se změní na "URL
                média",
                a v tomto případě byste měli zapsat absolutní URL.</p>

            <p><strong>POZN.</strong>: Budete-li na stránky nahrávat nyní, adresář, který jste zde označili, musí existovat a musí mít nastaveno právo
                na zápis pro všechny. Pokud ne, použijte váš FTP program
                nebo jiný online souborový správce, vytvořte složku a dejte ji příslušná oprávnění (fungovat by mělo 775, ale na některých stránkách
                je požadováno 777). </p>

            <h5 class="optionhead">NEBO Základní text</h5>
            <p>Místo nahrání fyzického souboru můžete do tohoto pole zapsat nebo vložit text nebo HTML kód.
                Pro formátování textu můžete také použít ovládací prvky na horním okraji pole Základní text. Přidržíte-li kursor myši nad ovládacími
                prvky, uvidíte jejich funkci.</p>

            <p><strong>POZN.:</strong> Pokud používáte HTML, <strong>nevkládejte</strong> HTML nebo BODY tagy.</p>

            <h5 class="optionhead">Soubor s náhledem obrázku</h5>
            <p>Jako náhled (menší obrázek) této mediální položky můžete vybrat existující fyzický soubor (ze svého lokálního počítače nebo z vašich
                webových stránek)
                nebo pro vás tento náhled vytvoří TNG. Pokud nevyberete ani jednu volbu, TNG použije výchozí soubor náhledu. <strong>Pozn.:</strong>
                Náhled by měl mít ideálně stranu o velikost 50 až 100 pixelů. Váš náhled <strong>NEMŮŽE</strong> být totožný s originálním obrázkem!
                TNG se ozve, pokud se pokusíte použít
                původní obrázek jako náhled. Pokud náhled již nemáte, TNG jej pro vás může vytvořit, ale pouze, pokud je vaše mediální položka platný
                obrázek JPG, GIF nebo PNG.
                TNG může také vytvořit náhledy z některých souborů PDF, ale stále může po vás požadovat, abyste pro jiné soubory (zejména starší
                soubory PDF) nahrali vlastní náhledy.</p>

            <h5 class="optionhead">Zadat obrázek/Vytvořit z originálu</h5>
            <p>Pokud váš server podporuje knihovnu GD image, uvidíte zde možnost zapsat váš vlastní
                náhled nebo nechat jej TNG vytvořit z originálu. Vyberete-li druhou možnost, bude standardně název nového souboru stejný jako název
                originálu, ale s předponou
                a/nebo příponou navíc. Tato předpona a přípona, spolu s maximální výškou a délkou náhledu, je nastavena v Základním nastavení.
                <strong>Pozn.:</strong> Váš
                náhled <strong>NEMŮŽE</strong> být totožný s originálním obrázkem! TNG se ozve, pokud se pokusíte použít
                původní obrázek jako náhled. Pokud náhled již nemáte, TNG jej pro vás může vytvořit, ale pouze, pokud je vaše mediální položka ve
                formátu JPG, GIF nebo PNG (v některém případě i PDF).
                PHP se může ozvat, pokud chcete vytvořit náhled z příliš velkého obrázku (více než 1MB).</p>

            <h5 class="optionhead">Soubor pro nahrání</h5>
            <p>Při požadavku na vytvoření rodokmenu osoby jsou náhledy jednotlivých fotografií souvisejících s danou osobou zobrazeny na stejné
                stránce. Pokud obrázek náhledu
                vaší mediální položky ještě nebyl na vaše webové stránky nahrán, klikněte na tlačítko "Procházet" a vyhledejte náhled na vašem disku.
                Do dalšího pole pak musíte zadat cílové umístění a název souboru obrázku náhledu.
                Je-li tento náhled již na vašich stránkách, nechte toto pole prázdné.</p>

            <h5 class="optionhead">Název souboru na stránkách</h5>
            <p>Pokud jste již váš soubor náhledu nahráli na stránky, zapište umístění a název souboru vašeho náhledu tak, jak existuje ve složce
                odpovídající kolekce na vašich webových stránkách
                (tip: náhledy můžete uložit v podsložce, pokud chcete, aby byly uchovávány odděleně, nebo mají stejné názvy jako větší obrázky). Pokud
                neznáte přesný název souboru,
                můžete kliknout na tlačítko "Vybrat" a vyhledejte soubor. Pokud nahráváte váš soubor náhledu nyní pomocí předchozího pole, použijte
                toto pole pro zápis umístění a
                názvu souboru až po nahrání souboru. Předpokládané umístění a název souboru bude předvyplněno.</p>

            <p><strong>POZN.</strong>: Budete-li na stránky nahrávat nyní, adresář, který jste zde označili, musí existovat a musí mít nastaveno právo
                na zápis pro všechny. Pokud ne, použijte váš FTP program
                nebo jiný online souborový správce, vytvořte složku a dejte ji příslušná oprávnění (fungovat by mělo 775, ale na některých stránkách
                je požadováno 777). </p>

            <h5 class="optionhead">Soubory uložit ve: Složce multimédií / Složce kolekce</h5>
            <p>Můžete zvolit, zda má být tato mediální položka uložena ve složce odpovídající kolekci vybrané výše (výchozí možnost) nebo ji můžete
                uložit v obecné složce
                multimédií.</p>

            <h5 class="optionhead">Titul</h5>
            <p>Titul by měl být krátký &#151; pouze pár slov k identifikaci vaší mediální položky. Bude použit jako odkaz na stránce zobrazující vaši
                položku.</p>

            <h5 class="optionhead">Popis</h5>
            <p>Do tohoto pole vložte více podrobností, včetně informace, kdo nebo co je zobrazeno nebo popsáno, apod. Toto pole bude
                doprovázet krátký popis (viz předchozí pole).</p>

            <h5 class="optionhead">Šířka, výška</h5>
            <p><strong>(pouze video)</strong> Některé přehrávače videa (např. Quicktime) požadují specifickou šířku a výšku videa. Nejsou-li tyto
                rozměry specifikovány, může pak být video příliš oříznuté
                a některé části videa nemusí být viditelné. Proto doporučujeme, abyste sem zapsali velikost vašeho videa v pixelech. Pamatujte také na
                to,
                abyste počítali s asi 16 pixely na ovladače videa (ovladače play/stop/volume, atd.).</p>

            <h5 class="optionhead">Majitel/Pramen, Datum pořízení</h5>
            <p>Toto jsou nepovinná pole. Pokud tyto údaje znáte, zapište je do příslušných polí.</p>

            <h5 class="optionhead">Strom</h5>
            <p>Chcete-li spojit toto médium s určitým stromem, vyberte jej zde. Bude to mít vliv na uživatele, kteří mají právo pouze upravovat
                položky spojené s jejich přiděleným stromem.</p>

            <h5 class="optionhead">Hřbitov</h5>
            <p><strong>(pouze Náhrobky)</strong> Hřbitov, na kterém se náhrobek nachází. Nejprve musíte hřbitov přidat do tabulky hřbitovů
                (Admin/Hřbitovy), pak bude vidět v tomto poli.</p>

            <h5 class="optionhead">Pozemek</h5>
            <p><strong>(pouze Náhrobky)</strong> Pozemek, kde se nachází náhrobek (nepovinné).</p>

            <h5 class="optionhead">Stav</h5>
            <p><strong>(pouze Náhrobky)</strong> Z rozbalovacího seznamu vyberte slovo nebo frázi, která nejlépe popisuje stav fyzického náhrobku.</p>

            <h5 class="optionhead">Vždy viditelné</h5>
            <p>Toto políčko zaškrtněte, pokud chcete, aby toto médium bylo u připojených osob zobrazeno vždy bez ohledu na uživatelská oprávnění nebo
                zda se jedná o osobu žijící.</p>

            <h5 class="optionhead">Otevřít v novém okně</h5>
            <p>Toto políčko zaškrtněte, pokud chcete, aby se položka po kliknutí na její odkaz otevřela v novém okně.</p>

            <h5 class="optionhead">Spojit toto médium přímo s vybraným hřbitovem</h5>
            <p><strong>(pouze Náhrobky)</strong> Zaškrtnutím tohoto políčka spojíte tento obrázek náhrobku se samotným hřbitovem. Při zobrazení
                stránky hřbitova se všechny mediální položky
                spojené se hřbitovem tímto způsobem zobrazí v horní části stránky.</p>

            <h5 class="optionhead">Ukázat mapu hřbitova a médium, kdykoliv bude tato položka zobrazena</h5>
            <p><strong>(pouze Náhrobky)</strong> Pokud má hřbitov, na které se náhrobek nachází, přiloženou mapu nebo fotografii, zaškrtnutím tohoto
                políčka se mapa nebo fotografie zobrazí kdykoli
                je zobrazen náhrobek.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="edit"><h4 class="subheadbold">Upravit existující médium</h4></a>
            <p>Chcete-li upravit existující médium, k nalezení položky použijte záložku <a href="#search">Hledat</a>, a poté klikněte na ikonu Upravit
                vedle této položky.
                Význam polí, která nejsou na stránce "Přidat nové médium", je následující:</p>

            <h5 class="optionhead">Odkazy na médium</h5>
            <p>Toto médium můžete připojit k osobám, rodinám, pramenům, úložištím pramenů nebo místům. Pro každý odkaz nejdříve vyberte strom spojený
                se subjektem, se kterým chcete položku spojit.
                Dále vyberte typ odkazu (osoba, rodina, pramen, úložiště pramenů nebo místo) a na závěr ID číslo nebo název (pouze u místa) subjektu,
                se kterým položku spojujete.
                Po vložení všech těchto údajů klikněte na tlačítko "Přidat".</p>

            <p>Pokud neznáte ID číslo nebo přesný název místa, kliknutím na ikonu lupy je můžete vyhledat. Objeví se okno, ve kterém můžete hledat.
                Po nalezení požadovaného popisu subjektu klikněte na odkaz "Přidat" vlevo. Kliknout na "Přidat" můžete u více subjektů. Po ukončení
                vytváření
                odkazů klikněte na odkaz "Zavřít okno".</p>

            <p><strong>Existující odkazy:</strong> Existující odkazy můžete upravit nebo vymazat kliknutím na ikonu Upravit nebo Vymazat vedle tohoto
                odkazu. Úprava odkazu
                vám umožní spojit odkaz s určitou událostí a přidělit mu <strong>Alternativní titul</strong> a <strong>Alternativní popis</strong>.
                Pro každý odkaz můžete
                kliknutím na příslušné políčko také změnit <strong>Výchozí fotografii</strong> nebo stav <strong>Zobrazit</strong>. Níže jsou uvedeny
                další informace o těchto vlastnostech.</p>

            <p>Kliknutím na odkaz "Seřadit" vedle jména se dostanete rychle na stránku, na které můžete přetřídit jednotlivé mediální položky tohoto
                subjektu. Tutéž věc můžete provést kliknutím
                na záložku Seřadit na horním okraji stránky Média, ale tento způsob je rychlejší.</p>

            <p><strong>VAROVÁNÍ</strong>: Odkazy na určité události, které vytvoříte v TNG, mohou být následným importem souboru GEDCOM přepsány.</p>

            <h5 class="optionhead">Nastavit jako výchozí</h5>
            <p>Zaškrtnutím tohoto políčka bude náhled tohoto média použit ve schématu vývodu a v horní části dalších stránek, které souvisí s osobou
                nebo subjektem, ke kterému
                je položka připojena.</p>

            <h5 class="optionhead">Zobrazit</h5>
            <p>Toto políčko odškrtněte, pokud nechcete, aby byl náhled tohoto média zobrazen na stránce osoby. Toto můžete udělat, když je obrázek
                již součástí alba, které bylo připojeno k téže osobě.</p>

            <h5 class="optionhead">Místo pořízení/vytvoření</h5>
            <p>
            <p>Tato sekce je ve výchozím stavu sbalena. Pro její rozbalení klikněte na výraz "Místo pořízení/vytvoření" nebo na šipku vedle něj.
                Znáte-li název místa,
                kde byla fotografie pořízena, zapište jej do pole označeného "Místo pořízení/vytvoření".</p>

            <h5 class="optionhead">Zeměpisná šířka a délka</h5>
            <p>Pokud jsou s vaší mediální položkou spojeny souřadnice zeměpisné šířky a délky, zapište je sem a pomůžete ostatním přesně určit místo.
                Jinak můžete pro nastavení zeměpisné šířky a délky místa média použít funkci geokódování Google Map. KLiknutím na tlačítko
                "Zobrazit/skrýt klikací mapu"
                se otevře Google Map.</p>

            <h5 class="optionhead">Přiblížení</h5>
            <p>Zadejte úroveň přiblížení nebo upravte ovládací prvek přiblížení v Google Map pro nastavení úrovně přiblížení. Tato volba je dostupná
                pouze, když jste obdrželi "klíč"
                od Google a zapsali jej do vašeho nastavení map v TNG.</p>

            <p>Pozn.: Zeměpisná šířka/délka/přiblížení je u mediálních položek pouze z informativních důvodů. Místo není přesně určeno na žádné mapě
                ve veřejné oblasti.</p>

            <h5 class="optionhead">Mapa obrázku</h5>
            <p>Tato sekce je ve výchozím stavu sbalena. Pro její rozbalení kliněte na výraz "Mapa obrázku" nebo na šipku vedle něj. V této sekci
                můžete spojit
                různé části obrázku s osobami ve vaší databázi, nebo zobrazit krátké zprávy při přemístění kursoru myší nad tyto části.</p>

            <p><strong>Pozn.</strong>: Pro použití této funkce musí být mediální položka ve formátu JPG, GIF nebo PNG.</p>

            <p>U každé oblasti, kterou chcete spojit s osobou, nejdříve zvolte strom dané osoby, poté určete na obrázku oblast nakreslením obdélníku
                ukazatelem vaší myší.
                Nejprve klikněte do levého horního rohu obdélníku, poté myš podržte a přesunutím dolů do prava nakreslete obdélník. Dostanete-li se do
                pravého dolního roku obdélníku, uvolněte myš.
                Takto vyberete souřadnice vašeho obrázku. Po výběru souřadnic se objeví okno, ve kterém můžete najít nebo zapsat ID číslo osoby. Pro
                nalezení záznamu zapište
                celé jméno osoby nebo jen jeho část anebo ID číslo, a poté ze zobrazených kandidátů vyberte správnou osobu. Okno
                se zavře a do pole Mapa obrázku pod obrázkem bude vložen kód této oblasti. V případě potřeby můžete kód upravit nebo
                jej zapsat přímo.</p>

            <p>Tento postup můžete opakovat pro další oblasti. Každý nový kód bude vložen na konec obsahu pole Mapa obrázku.</p>

            <p>Chcete-li různé části vašeho obrázku spojit s různými stránkami nebo zobrazit krátké zprávy při přemístění kursoru myší nad tyto části,
                zapište do tohoto pole
                potřebný kód mapy obrázku. Vytvořit svoji vlastní mapu obrázku můžete podle sekce Tvorba mapy obrázku na konci stránky.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Top</a></p>
            <a id="delete"><h4 class="subheadbold">Vymazat médium</h4></a>

            <p>Chcete-li odstranit jednu mediální položku, použijte záložku <a href="#search">Hledat</a> pro nalezení dané položky, a poté klikněte na
                ikonu Vymazat vedle této položky. Tento řádek změní
                barvu a poté po odstranění položky zmizí. Chcete-li najednou odstranit více položek, zaškrtněte políčko ve sloupci Vybrat vedle každé
                položky, kterou
                chcete odstranit, a poté klikněte na tlačítko "Vymazat vybrané" na stránce nahoře</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="convert"><h4 class="subheadbold">Převést médium z jedné kolekce do jiné</h4></a>
            Chcete-li převést mediální položky z jednoho typu média nebo "kolekce" do jiné, zaškrtněte na záložce <a href="#search">Hledat</a> políčko
            vedle těchto položek,
            poté z rozbalovacího seznamu v horní části stránky vedle tlačítka "Převést vybrané na" vyberte novou kolekci. Na závěr klikněte na
            tlačítko "Převést vybrané na".
            Stránka bude zobrazena znovu s červenou stavovou zprávou nahoře.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="album"><h4 class="subheadbold">Přidat médium do alba</h4></a>
            Chcete-li médium přidat do alba, zaškrtněte políčko Vybrat vedle položek, které mají být přidány, poté z rozbalovacího seznamu v horní
            části stránky
            vedle tlačítka "Přidat do alba" vyberte album. Na závěr klikněte na tlačítko "Přidat do alba". Média můžete do alba přidat také z
            Admin/Alba.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="sort"><h4 class="subheadbold">Seřadit média</h4></a>
            <p>Standardně jsou média spojená s osobou, rodinou, pramenem, úložištěm pramenů nebo místem seřazena v pořadí, ve kterém byla k tomuto
                subjektu připojena. Toto pořadí
                můžete změnit na záložce Media/Seřadit.</p>

            <h5 class="optionhead">Strom, Typ odkazu, Kolekce:</h5>
            <p>Zvolte strom spojený se subjektem, u kterého chcete změnit pořadí médií. Dále vyberte typ odkazu (osoba, rodina, pramen, úložiště
                pramenů nebo místo) a
                kolekci, kterou chcete přetřídit.</p>

            <h5 class="optionhead">ID číslo:</h5>
            <p>Zapište ID číslo nebo název (pouze místa) subjektu. Pokud neznáte ID číslo nebo přesný název místa, kliknutím na ikonu lupy je můžete
                vyhledat.
                Po nalezení požadovaného subjektu klikněte na odkaz "Vybrat" vedle tohoto subjektu. Okno se zvře a vybrané ID číslo se objeví v poli
                ID číslo.</p>

            <h5 class="optionhead">Spojeno s určitou událostí</h5>
            <p>Pokud chcete přetřídit mediální položky připojené k určité události spojené s připojeným subjektem, zaškrtněte políčko označené
                "Spojeno s určitou událostí" PO
                vyplnění všech ostatních polí, včetně ID čísla. Objeví se další rozbalovací seznam, ve kterém vyberete
                tuto určitou událost (nepovinné).</p>

            <h5 class="optionhead">Postup třídění</h5>
            <p>Po výběru nebo zápisu ID čísla klikněte na tlačítko "Pokračovat..." a zobrazí se všechna média vybraného subjektu a kolekce v jejich
                aktuálním pořadí.
                Chcete-li položky přetřídit, klikněte u některé položky na oblast "Táhnout" a při stisknutém tlačítku myši přesuňte položku na
                požadované místo
                v seznamu. Je-li položka na požadovaném místě, uvolněte tlačítko myši ("táhni a pusť"). V tomto okamžiku budou uloženy změny.</p>

            <p>Další možností přetřídění položek je zápis po sobě jdoucích čísel do malých políček vedle oblasti "Táhnout", poté kliknutí na odkaz
                "Go" pod políčkem nebo stisknutí Enteru.
                Může to být výhodné, pokud je seznam příliš dlouhý a nevejde se na jednu obrazovku.</p>

            <p>Jakoukoli položku můžete přesunout na začátek seznamu kliknutím na ikonu "Top" nad políčkem s pořadím.</p>

            <h5 class="optionhead">Výchozí fotografie</h5>
            <p>Při třídění můžete zvolit jakoukoli zobrazenou fotografii jako <strong>Výchozí fotografii</strong> aktuálního subjektu. Znamená to, že
                se náhled zvoleného obrázku
                objeví ve schématu vývodu a v titulech stránek s názvem nebo popisem aktuálního subjektu. Chcete-li nastavit nebo vymazat označení
                Výchozí fotografie, podržte
                kurzor myši nad obrázkem v seznamu, a poté klikněte na jednu z voleb, které se objeví: "Nastavit jako výchozí" nebo "Odstranit".
                Aktuální výchozí fotografii
                lze odstranit také kliknutím na odkaz "Odstranit výchozí fotografii" na stránce nahoře.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="thumbs"><h4 class="subheadbold">Náhledy</h4></a>

            <h5 class="optionhead">Vytvořit náhledy</h5>
            <p>Pop kliknutí na tlačítko "Vygenerovat" pod touto volbou, vytvoří TNG automaticky náhledy všech obrázků formátu JPG, GIF nebo
                PNG, které nemají existující náhledy. Standardně bude název obrázku stejný jako je název velkého obrázku a bude obsahovat
                předponu a/nebo příponu, které jsou definovány v Základním nastavení. Zaškrtnutím políčka označeného "Obnovit existující náhledy"
                vytvoříte
                náhledy všech obrázků, včetně těch, které je již mají. Políčko "Obnovit názvy cest k náhledům, kde soubor neexistuje" zaškrtněte,
                pokud
                si myslíte, že máte některé náhledy, které ukazují na neplatné soubory. To způsobí, že TNG přehodnotí názvy cest u náhledů před
                obnovením náhledů.
                Bez této funkce by docházelo k opětovnému vytváření některých neplatných názvů náhledů.</p>

            <p><strong>POZN.</strong>: Pokud nevidíte sekci Vytvořit náhledy, váš server nepodporuje knihovnu GD image.</p>

            <h5 class="optionhead">Přiřadit výchozí fotografie</h5>
            <p>Tato volba vám umožní nastavit jako výchozí fotografii první fotografii u každé osoby, rodiny nebo pramenu
                (ta, která bude zobrazena ve schématu vývodu, rodiny a nahoře na každé stránce, která je s daným subjektem spojena). Přiřazení může
                být provedeno
                pro všechny osoby, rodiny, prameny a úložiště pramenů v určitém stromu výběrem tohoto stromu z rozbalovacího seznamu. Zaškrtnutím
                políčka
                označeného "Přepsat existující nastavení" nastavíte výchozí fotografie bez ohledu na to, co bylo nastaveno dříve. Ponechání tohoto
                políčka
                nezaškrtnutého vám umožní ponechat dříve nastavené výchozí fotografie.</p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="import"><h4 class="subheadbold">Import médií</h4></a>

            <h5 class="optionhead">Cíl</h5>
            <p>Vytvoření záznamu média pro každý fyzický soubor ve vaší složce médií s názvem souboru jako titulem každého záznamu.</p>

            <h5 class="optionhead">Použití</h5>
            <p>Chcete-li import provést, zvolte nejprve kolekci (nebo vytvořte novou kolekci) a strom (pokud mají být vkládané položky spojeny s
                určitým stromem), poté klikněte na tlačítko "Import".
                Existuje-li již pro položku záznam, nový záznam se nevytvoří. "Klíčem" (který určí, zda již záznam existuje nebo ne) je
                název souboru a strom. Pokud importujete stejnou položku do více stromů (nebo pokud byla položka kdysi importována do "všech stromů" a
                jindy
                jen do určitého stromu), TNG nepozná, že již máte záznam pro tuto položku a vytvoří jej znovu.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="upload"><h4 class="subheadbold">Nahrání médií</h4></a>

            <h5 class="optionhead">Cíl</h5>
            <p>Dávkové nahrání více položek médií, jejich opatření tituly a popisy, včetně jejich připojení k osobám, rodinám, pramenům nebo místům
                přímo z této obrazovky.</p>

            <h5 class="optionhead">Použití</h5>
            <p>Chcete-li tuto funkci použít, zvolte nejprve kolekci a strom (pokud mají být vkládané položky spojeny s určitým stromem), poté klikněte
                na "Přidat soubory" a z vašeho počítače vyberte soubory pro nahrání. Většina prohlížečů (mimo Internet
                Explorer) vám umožní soubory chytit a přetáhnout
                z jiného okna přímo do bílé oblasti ve středu obrazovky. Chcete-li zvolit jako cíl pro nahrání vašich souborů podsložku v rámci
                zvolené složky, zapište do pole "Složka" její název nebo použijte tlačítko
                "Vybrat" pro výběr podsložky, která již existuje. Nechcete-li soubory uložit do podsložky, nechte pole Složka prázdné.
                Po dokončení výběru souborů a jejich umístění můžete zahájit nahrání všech souborů najednou kliknutím
                na tlačítko "Spustit nahrání" na stránce nahoře. Nebo můžete nahrát soubory jednotlivě kliknutím na tlačítko "Spustit" vedle
                příslušného souboru.
                Po ukončení nahrání můžete přidat nový titul nebo popis, nebo připojit položku k určitému záznamu ve vaší databázi, nebo je všechny
                vymazat.</p>

            <h5 class="optionhead">Změna titulu a popisu</h5>
            <p>Po nahrání souboru se zobrazí pole pro titul a popis. Chcete-li změnit výchozí hodnoty, nové údaje zapište a klikněte na "Uložit" ve
                středu oblasti.
                Další údaje můžete později přidat z obrazovky Úprava média.</p>

            <h5 class="optionhead">Přidat odkazy</h5>
            <p>Chcete-li připojit určitou mediální položku k položce vaší databáze, počkejte na ukončení nahrání. Poté klikněte na tlačítko "Odkazy na
                médium" na stejném řádku.
                Zapište ID číslo a klikněte na "Přidat" nebo pro vyhledání a výběr čísla ID použijte volbu Najít.</p>
            <p>Chcete-li připojit více mediálních položek najednou ke stejné položce, zaškrtněte zátržku na řádku u každé položky (nebo použijte
                tlačítko "Vybrat vše" pro výběr všech nahraných
                položek), a poté použijte pole na obrazovce dole pro dokončení operace. Zapište ID číslo nebo pro vyhledání použijte volbu Najít.
                Je-li číslo ID
                v poli ID a vybrána byla alespoň jedna mediální položka, klikněte na tlačítko "Připojit k vybraným" pro vytvoření odkazů.</p>
        </td>
    </tr>

</table>
</body>
</html>

<?php
include "../../helplib.php";
echo help_header("Nápověda: Rodiny");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="people_help.php" class="lightlink">&laquo; Nápověda: Osoby</a> &nbsp;|&nbsp;
                <a href="sources_help.php" class="lightlink">Nápověda: Prameny &raquo;</a>
            </p>
            <h2 class="largeheader">Nápověda: <small>Rodiny</small></h2>
            <p class="smaller menu" style="clear: both;">
                <a href="#search" class="lightlink">Hledat</a> &nbsp;|&nbsp;
                <a href="#add" class="lightlink">Přidat novou</a> &nbsp;|&nbsp;
                <a href="#edit" class="lightlink">Upravit existující</a> &nbsp;|&nbsp;
                <a href="#delete" class="lightlink">Vymazat</a> &nbsp;|&nbsp;
                <a href="#review" class="lightlink">Přezkoumat</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">
            <a id="search"><h4 class="subheadbold">Hledat</h4></a>
            <p>Nalezení existujících rodin vyhledáním celého nebo části <strong>ID čísla rodiny</strong>, <strong>Jména otce</strong> nebo <strong>Jména
                    matky</strong>.
                Pro daląí zúľení vaąeho hledání vyberte strom nebo zaąkrtněte "Pouze přesná shoda". Volbou "Jména otce" budou vaąe výběrová kritéria
                porovnána se jmény vąech otců.
                Volbou "Jména matky" budou vaąe výběrová kritéria porovnána se jmény vąech matek. Volbou "Beze jména" budete hledat pouze mezi ID
                čísly rodiny.
                Výsledkem hledání bez zadaných voleb a hodnot ve vyhledávacích polích bude seznam vąech osob ve vaąí databázi.</p>

            <p>Vyhledávací kritéria, která zadáte na této stránce, budou uchována, dokud nekliknete na tlačítko <strong>Obnovit</strong>, které znovu
                obnoví vąechny výchozí hodnoty.</p>

            <h5 class="optionhead">Akce</h5>
            <p>Tlačítko Akce vedle kaľdého výsledku hledání vám umoľní upravit, vymazat nebo otestovat výsledek. Chcete-li najednou vymazat více
                záznamů, zaąkrtněte políčko ve sloupci
                <strong>Vybrat</strong> u kaľdého záznamu, která má být vymazán, a poté klikněte na tlačítko "Vymazat označené" na začátku seznamu.
                Pro zaąkrtnutí nebo vyčiątění vąech výběrových políček najednou
                můľete pouľít tlačítka <strong>Vybrat vąe</strong> nebo <strong>Vyčistit vąe</strong> .</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="add"><h4 class="subheadbold">Přidat novou rodinu</h4></a>
            <p>Výrazem <strong>Rodina</strong> se v tomto programu rozumí kaľdé spojení mezi "otcem" a "matkou" (děti zde mohou nebo nemusí být
                obsaľeny). Pokud byla osoba víckrát sezdána
                nebo má děti s více partnery, měli byste pro kaľdý pár manľelů nebo partnerů vytvořit novou rodinu.</p>

            <p>Chcete-li přidat novou rodinu, klikněte na záloľku <strong>Přidat nové</strong> a poté vyplňte formulář. Některé informace (poznámky,
                citace a
                daląí události) můľete přidat po uloľení a zamknutí záznamu. Význam jednotlivých polí je následující:</p>

            <h5 class="optionhead">Strom</h5>
            <p>Pokud máte pouze jeden strom, vybrán bude vľdy tento strom. Jinak, prosím, pro novou rodinu vyberte poľadovaný strom.</p>

            <h5 class="optionhead">Větev (volitelné)</h5>
            <p>Připojení rodiny ke "větvi" omezí přístup k informacím o rodině pro uľivatele, kteří jsou spojeni k téľe větvi. Je-li definována
                alespoň jedna větev
                a váą uľivatelský účet není spojen se ľádnou konkrétní větví, můľete novou rodinu připojit k více existujícím větvím. Chcete-li větev
                vybrat,
                kliknutím na odkaz "Upravit" se otevře box se vąemi větvemi ve vybraném stromě. Pro výběr více větví pouľijte klávesu Control
                (Windows) nebo Command (Mac).
                Po dokončení vaąeho výběru přesuňte kursor myąi mimo okno úprav a toto okno zmizí.</p>

            <h5 class="optionhead">ID číslo rodiny</h5>
            <p>ID číslo rodiny musí být jednoznačné uvnitř vybraného stromu a mělo by se skládat z velkého písmene <strong>F</strong> následovaného
                číslem (nejvíce 21 číslic).
                Při prvním zobrazení stránky a kdykoli je vybrán jiný strom, bude doplněno volné a jednoznačné číslo, ale pokud chcete, můľete vloľit
                své vlastní ID číslo.
                Chcete-li zkontrolovat, zda je vaąe ID číslo jednoznačné, klikněte na tlačítko <strong>Zkontrolovat</strong>. Objeví se zpráva, která
                vám sdělí, zda je jiľ ID číslo pouľito nebo ne.
                Chcete-li vygenerovat daląí jednoznačné číslo, klikněte na <strong>Vygenerovat</strong>. Bude zjiątěno nejvyąąí číslo ve vaąí databázi
                a přidána 1.
                Chcete-li zajistit, ľe zobrazení ID číslo není nárokováno jiným uľivatelem, zatímco vy zapisujete data, klikněte na tlačítko <strong>Zamknout</strong>.
            </p>

            <p><strong>POZN.</strong>: Pouľíváte-li tento program spolu s genealogickým programem pracujícím na platformách PC nebo Mac, který u
                nových rodin vytváří také ID čísla,
                DŮRAZNĚ DOPORUČUJEME vąechny tato čísla vľdy mezi těmito programy synchronizovat. Výsledkem zanedbání této činnosti mohou být kolize a
                nepouľitelnost
                odkazů na vaąe média. Pokud váą primární program vytváří ID čísla, která neodpovídají tradičním standardům (např.
                <strong>F</strong> je na konci a ne na začátku), můľete konvence, které TNG pouľívá, změnit v Základním nastavení.</p>

            <h5 class="optionhead">Manľelé/Partneři</h5>
            <p>Kliknutím na "Najít..." vyberte existující osoby, které by měly být v této rodině <strong>otcem</strong> nebo <strong>matkou</strong>
                nebo kliknutím na "Vytvořit"
                vytvořte nové osoby. Pokud jste zvolili Vytvořit, budete moci vloľit údaje o nových osobách bez toho, abyste museli opustit aktuální
                stránku.
                Po výběru nebo vytvoření osoby se v poli Otec nebo Matka objeví jméno a ID číslo osoby (nelze upravit přímo).
                Chcete-li partnera odstranit ze vztahu (nebude odstraněn z databáze),
                klikněte na tlačítko "Odstranit". Pokud chcete upravit záznam partnera, klikněte na tlačítko "Upravit".</p>

            <h5 class="optionhead">®ijící</h5>
            <p>Pokud jeden z partnerů ľije nebo si přejete omezit přístup k údajům této rodiny pouze na uľivatele, kteří jsou přihláąeni a mají práva
                zobrazovat data ľijících osob,
                zaąkrtněte toto políčko.</p>

            <h5 class="optionhead">Neveřejné</h5>
            <p>Bez ohledu na to, zda je tato rodina označena jako ®ijící, můľete přístupová práva k údajům této osoby omezit zaąkrtnutím této volby.
                Informace spojené s "neveřejnou" rodinou budou moci vidět pouze uľivatelé s právy zobrazovat neveřejná data.</p>

            <h5 class="optionhead">Události</h5>
            <p>Zapiąte data a místa k zobrazeným standardním událostem (pokud je znáte). Daląí události lze přidat po uloľení a zamknutí záznamu. Data
                vľdy zapisujte
                ve standardním genealogickém formátu DD MMM RRRR (např. <em>18 Úno 2008</em>). Informaci o místě řaďte za sebou od místního po obecnou
                a oddělujte kaľdý údaj čárkou
                (např. <em>Bludov, ©umperk, Olomoucký kraj, Česká republika</em>), nebo kliknutím na ikonu "Najít" vyberte existující místo (lupa).
                Chcete-li omezit počet nalezených výsledků, před kliknutím na ikonu Najít zapiąte část místa. Vąechny výsledky budou obsahovat to, co
                jste zapsali jako název místa.</p>

            <p><h5 class="optionhead">Údaje CJKSpd (Pečetění s partnerem)</h5>
            Tato událost jsou spojena s obřadem prováděným Církví Jeľíąe Krista Svatých posledních dní (mormonská církev, která vytvořila standard
            GEDCOM).
            <strong>Pozn.:</strong> Nechcete-li vidět pole spojené s CJKSpd, jděte na Nastavení/Základní nastavení a zde tuto moľnost vypněte (je
            třeba se pak odhlásit a znovu přihlásit).</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="edit"><h4 class="subheadbold">Upravit existující rodinu</h4></a>
            <p>Chcete-li upravit existující rodinu, pouľijte záloľku <a href="#search">Hledat</a> pro nalezení rodiny, a poté klikněte na ikonu
                Upravit vedle této osoby.</p>

            <h5 class="optionhead">Poznámky / Citace / "Více"</h5>
            <p>Poznámky a citace lze připojit k událostem nebo rodině obecně kliknutím na připojené ikony v horní části stránky
                nebo vedle kaľdé události. Ke kaľdé události můľete také přidat "více" informací kliknutím na ikonu "Plus". Pokud v nějaké této
                kategorii existují údaje,
                na odpovídající ikoně bude v horním pravém rohu zelená tečka. Chcete-li znát více informací o kaľdé kategorii, jděte na odkazy
                nápovědy,
                které budou viditelné po kliknutí na tyto ikony.</p>

            <h5 class="optionhead">Jiné události</h5>
            <p>Chcete-li přidat daląí události, klikněte na tlačítko "Přidat nové" vedle <strong>Jiné události</strong>. Viz odkaz <a
                    href="events_help.php">Nápověda</a> pro více
                informací o přidání nových událostí. Po přidání události se pod tlačítkem "Přidat nové" zobrazí v tabulce krátké shrnutí. Tlačítka
                akcí
                pro kaľdou událost vám umoľní událost upravit nebo odstranit, nebo přidat poznámky nebo citace. Pořadí, ve kterém se události zobrazí,
                závisí na datu (je-li zapsáno)
                a prioritě, kterou má daný typ události (není-li připojeno datum). Při úpravě typu události můľete prioritu změnit.

            <p><strong>Poznámka</strong>: Poznámky, citace pramenů, "jiné" události a "více" informací se ukládá u standardních automaticky. Jiné
                změny (např.
                standardní události) se uloľí kliknutím na tlačítko Uloľit na konci stránky nebo kliknutím na ikonu Uloľit na stránce nahoře. Strom a
                ID číslo osoby nelze změnit.</p>

            <p><h5 class="optionhead">Děti</h5>
            <p>Kliknutím na "Najít..." vyberte existující osoby, které by měly být v této rodině dětmi, nebo kliknutím na "Vytvořit"
                vytvořte nové dítě. Pokud jste zvolili Vytvořit, budete moci vloľit údaje o nové osobě bez toho, abyste museli opustit aktuální
                stránku.
                Po výběru nebo vytvoření osoby se v seznamu dětí jméno, ID číslo a datum narození osoby (nelze upravit přímo). Tento seznam nelze
                upravovat přímo, ale pro odstranění dítěte ze seznamu můľete pouľít odkaz "Odstranit" (viditelný, kdyľ přesunete kurzor myąi nad kaľdé
                dítě). Pouľít
                můľete také odkaz "Vymazat" pro úplné vymazání dítěte z databáze. Můľete pouľít tlačítko "Vymazat" pro vymazání dítěte z databáze
                nebo tlačítko "Upravit" pro úpravu záznamu dítěte.</p>

            <h5 class="optionhead">Pořadí dětí</h5>
            <p>Pokud existuje více dětí,
                můľete jejich pořadí změnit "přetaľením" bloků nahoru nebo dolů. Chcete-li blok přetáhnout, klikněte myąí na tlačítko "Táhnout", toto
                tlačítko podrľte, a vaąi myą přesuňte na stránce nahoru
                nebo dolů. Po přesunu bloku do poľadované pozice tlačítko pus»te. Změny pořadí budou automaticky uloľeny.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="delete"><h4 class="subheadbold">Vymazat rodinu</h4></a>
            <p>Chcete-li odstranit rodinu, pouľijte záloľku <a href="#search">Hledat</a> pro nalezení rodiny, a poté klikněte na ikonu Odstranit vedle
                této rodiny. Tento řádek změní
                barvu a poté po odstranění rodiny zmizí (partneři a děti nebudou odstraněni, ale vztah bude rozpojen). Chcete-li najednou odstranit
                více rodin, zaąkrtněte políčko ve sloupci Vybrat vedle kaľdé rodiny, kterou
                chcete odstranit, a poté klikněte na tlačítko "Vymazat označené" na stránce nahoře</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="review"><h4 class="subheadbold">Předběľné prohlédnutí úprav</h4></a>
            Chcete-li si předběľně prohlédnout změny provedené ostatními uľivateli, klikněte na záloľku "Přezkoumat". Můľete se pak rozhodnout, zda
            tyto navrhované změny uloľíte nebo odstraníte.
            Změny můľete prohlédnout podle stromu nebo podle uľivatele nebo podle obojího. Po uloľení navrhovaných změn není zaslán ľádný mail, ale
            pokud nové změny existují, na záloľce Přezkoumat se objeví hvězdička (*).</p>

            <h5 class="optionhead">Vybrat událost a akci</h5>
            <p>V tabulce, která popisuje události, které si přejete přezkoumat nebo odstranit, vyberte řádek. Seznam výsledků můľete zúľit výběrem
                uľivatele (osoba
                odpovědná za navrhované změny) a/nebo strom. Po zobrazení výsledků klikněte na jednu z moľných akcí nalevo od tohoto řádku. Chcete-li
                změny přezkoumat a
                případně začlenit do databáze, vyberte <em>Přezkoumat</em>. Chcete-li navrhované změny zamítnout, vyberte <em>Odstranit</em>.</p>

            <h5 class="optionhead">Přezkoumat</h5>
            <p>Na obrazovce Přezkoumat můľete provést daląí potřebné změny, včetně poznámek a pramenů, a poté klikněte na "Uloľit a vymazat" pro
                uloľení do databáze a odstranění dočasného záznamu. Kliknutím na "Odmítnout a vymazat" můľete rovněľ odstranit dočasný záznam, aniľ
                byste jej uloľili,
                nebo můľete své rozhodnutí odloľit na pozdějąí dobu kliknutím na "Odloľit".</p>

        </td>
    </tr>

</table>
</body>
<?php echo "</html>"; ?>

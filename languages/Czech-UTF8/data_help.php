<?php
include "../../helplib.php";
echo help_header("Nápověda: Import dat");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="mostwanted_help.php" class="lightlink">&laquo; Nápověda: Hledá se</a> &nbsp;|&nbsp;
                <a href="second_help.php" class="lightlink">Nápověda: Druhotné procesy &raquo;</a>
            </p>
            <h2 class="largeheader">Nápověda: <small>Import / Export</small></h2>
            <p class="smaller menu clear-both">
                <a href="#import" class="lightlink">GEDCOM Import</a> &nbsp;|&nbsp;
                <a href="#export" class="lightlink">GEDCOM Export</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="import"><h4 class="subheadbold">GEDCOM Import</h4></a>
            <p>Na této stránce můžete naimportovat všechna data ze standardního souboru GEDCOM do určitého stromu.</p>

            <p><h5>Před importem:</h5> Z vašeho genealogického programu vytvořte standardní soubor GEDCOM 5.5 (4.0 je také
            akceptovatelný). Neveřejné informace u žijících osob
            můžete vyloučit, ale není to nutné. Není také nutné vyloučit údaje týkající se CJKSpd, protože mohou být také filtrovány v závislosti
            na uživatelských právech.</p>

            <p>Po vytvoření souboru GEDCOM je dalším krokem, jak ho dostat na vaše webové stránky. Význam jednotlivých polí je následující:</p>

            <p><h5>[Import souboru GEDCOM] Z vašeho počítače</h5>
            Chcete-li nahrát a importovat váš soubor na vaše stránky bez použití FTP, klikněte na tlačítko "Prohledat" a najděte soubor na vašem
            disku. Po jeho vyhledání se v tomto poli objeví název a umístění vašeho souboru.
            <strong>POZN.</strong>: Pokud je váš soubor GEDCOM příliš velký (> 2MB), budete muset před nahráním vašeho souboru tímto způsobem
            kontaktovat poskytovatele svého hostingu, protože server může mít omezení maximální
            velikosti pro nahrávání souborů prostřednictvím webového formuláře. Pokud během importu obdržíte chybové hlášení, jedná se o tento případ.
            Zkuste místo toho použít k nakopírování svého souboru do složky GEDCOM program FTP,
            a pak jej naimportujte odtud (viz níže).</p>

            <h5>OR [Import souboru GEDCOM] Z webových stránek (ve složce GEDCOM)</h5>
            <p>Pokud jste pro přenos souboru do složky GEDCOM na vašich stránkách použili FTP nebo nějaký online souborový manažer, zapište sem přesný
                název vašeho souboru, který chcete nahrát nebo klikněte na
                tlačítko "Vybrat" pro jeho nalezení na vašich stránkách. Musí být ve složce GEDCOM nebo jej tlačítko Vybrat nenajde.
                <strong>POZN.</strong>: Pokud vidíte seznam
                souborů, ale tyto nejsou z vaší složky GEDCOM, máte zřejmě problém s umístěním souborů. Ověřte svoji kořenovou složku
                (Admin/Nastavení/Základní nastavení) a vaši složku GEDCOM (Admin/Nastavení/Nastavení importu).</p>

            <h5>Přijmout data pro všechny vlastní typy událostí</h5>
            <p>Váš soubor GEDCOM může obsahovat události, které bude TNG považovat za "vlastní" události. Normálně jsou vlastní typy událostí, které
                soubor GEDCOM obsahuje, vloženy do databáze, ale
                ale je nastaveno, aby data byla ignorována. Stav vlastních typů událostí můžete změnit na "přijmout", aby události tohoto typu byly
                naimportovány (jinými slovy,
                abyste nemuseli váš soubor importovat dvakrát). Pokud tuto volbu zaškrtnete, TNG automaticky nastaví všechny nové vlastní typy
                událostí na "přijmout" a všechny vaše události
                budou importovány napoprvé.</p>

            <h5>Importovat pouze vlastní typy událostí (nebudou vloženy, nahrazeny nebo přidány žádné údaje)</h5>
            <p>Zaškrtnutí této volby způsobí, že budou naimportovány pouze vlastní typy událostí (viz Admin/Vlastní typy událostí). Všechny další
                údaje budou ignorovány. To je ideální možnost
                jak sestavit vaše výchozího nastavení, protože vám umožní vidět, které vlastní události vás soubor GEDCOM obsahuje. Můžete poté
                zvolit, které události
                před importem vaší celé databáze přijmout a které odmítnout.</p>

            <h5>Cílový strom</h5>
            <p>Vyberte strom, do kterého chcete importovat data (povinné). Pokud strom, kam mají data přijít, ještě neexistuje, klikněte na tlačítko
                "Přidat nový strom" a vytvořte jej.
                Objeví se malé okno, které vám umožní zadat informace o novém stromu.</p>

            <h5>Nahradit všechna aktuální data</h5>
            <p>Zvolíte-li tuto možnost, všechny vaše dřívější údaje ze souboru GEDCOM (osoby, rodiny, děti, prameny, úložiště pramenů, události,
                poznámky, spojení a citace; ne média a cokoli jiného)
                budou před importem vymazána.
                <strong>POZN.</strong>: Odkazy na média budou zachovány, pokud se ID čísla osoby/rodiny/pramenu/úložiště pramenů ve vašem novém
                souboru GEDCOM budou shodovat s ID čísly vašich dosavadních dat.
                Většina genealogických programů přiřazují stálá ID čísla každé osobě/rodině/pramenu/úložišti pramenů, ale některé ne. Pokud máte k
                datům připojeny nějaké položky médií, před importem, prosím, zkontrolujte,
                zda se ID čísla ve vašem novém souboru GEDCOM shodují, bez ohledu na to, kterou z těchto možností máte vybránu. Je také vhodné
                vytvořit před importem zálohu vašich tabulek
                (viz Admin/Obslužné programy o vytvoření zálohy).</p>

            <h5>Nahradit pouze odpovídající záznamy</h5>
            <p>S touto volbou jsou přidány nové záznamy a odpovídající záznamy jsou nahrazeny (shoda je podmíněna pouze ID čísly). Staré údaje nejsou
                odstraněny.</p>

            <h5>Nenahradit žádná data</h5>
            <p>Nové záznamy budou přidány, ale shodné záznamy budou ignorovány (nenahrazeny).</p>

            <h5>Přidat všechny záznamy</h5>
            <p>Všechny záznamy budou naimportovány, bez ohledu na existující data, ale jejich ID čísla budou přečíslována. ID čísla importovaných
                záznamů budou vytvořena od prvního volného čísla
                (nebo čísla, které určíte).</p>

            <h5>Všechna příjmení velkými písmeny</h5>
            <p>Zaškrtnutím tohoto políčka před importem způsobí převedení všech příchozích příjmení na velká písmena. Příjmení budou tímto způsobem
                uložena v databázi,
                takže tento proces nelze vzít zpět, pokud váš soubor GEDCOM nenaimportujete znovu.</p>

            <h5>Nepřepočítat označení Žijící</h5>
            <p>Pokud zvolíte "Nahradit pouze odpovídající záznamy", zobrazí se vám tato volba. Před importem tuto volbu zaškrtněte,
                pokud nechcete, aby bylo přepočítáno označení "Žijící" pro osoby, které již jsou v databázi.</p>

            <h5>Nahradit pouze, pokud jsou údaje novější</h5>
            <p>Odpovídající záznamy budou nahrazeny pouze, pokud přicházející záznam je novější než záznam, který se nachází v databázi. Porovnání je
                založeno na "Poslední aktualizace" nebo údaji CHAN,
                který je se s tímto záznamem spojen v souboru GEDCOM.</p>

            <h5>Importovat média, pokud existují</h5>
            <p>Pokud váš soubor GEDCOM obsahuje odkazy na média, zaškrtnutím tohoto políčka umožníte TNG tyto odkazy naimportovat a nastavit příslušné
                propojení.
                Musíte však fyzické soubory, které těmto odkazům odpovídají, nakopírovat na vaše stránky do příslušných složek (např. pomocí FTP).
                Nechcete-li importovat
                žádná média, před zahájením importu toto políčko odškrtněte.</p>

            <h5>Začít číslovat ID čísla od prvního volného čísla/Začít číslovat ID čísla od</h5>
            <p>Pokud zvolíte možnost "Přidat všechny záznamy", zobrazí se vám také tato volba. Výběrem první možnosti vytvoří
                TNG nové ID číslo příchozího záznamu přidělením prvního volného ID čísla v každé kategorii (osoby, rodiny, prameny, úložiště pramenů).
                Druhou možnost vyberte, pokud chcete, aby TNG vytvořil pro příchozí záznam nové ID číslo od určitého čísla (stejné pro každou
                kategorii).
                Vyberete-li tuto možnost, ujistěte se, že v určeném rozsahu neexistují žádné záznamy nebo dojde ke kolizím.</p>

            <h5>Starý styl importu</h5>
            <p>Před verzí TNG 7 se zobrazoval průběh importu. Místo toho se na obrazovce opakovaně objevoval počet importovaných osob a rodin.
                Nový počet byl vždy zobrazen vedle starého počtu, takže brzy přesáhl rozměr stránky. Lišta průběhu je čistší a názornější,
                ale v některých případech starý import pracoval lépe, protože bylo na obrazovce zobrazeno více údajů. Pokud ve vašem případě nový
                import
                selže, můžete zaškrtnutím této volby zkusit, zda starý import neproběhne lépe.</p>

            <p>Pokud jste připraveni, klikněte na tlačítko <strong>Importovat data</strong> a zahájíte proces. Měli byste vidět lištu průběhu a řadu
                čítačů, které znázorňujících
                importované osoby, rodiny, prameny, poznámky a místa (pozn.: počítána jsou pouze místa obsahující zeměpisné souřadnice). Závěrečná
                zpráva
                vám sdělí, zda byl import úspěšně dokončen.</p>

            <h5>Funkce "začít znovu"</h5>
            <p>Pokud neuvidíte zprávu o "dokončení", váš server možná proces importu ukončil, protože trval příliš dlouho.
                Pokud se vám to stalo, jděte na stránku Admin/Nastavení/Nastavení importu
                a zaškrtněte políčko <strong>Uložit stav importu</strong>. Pak se vraťte na stránku importu a zkuste váš import znovu. Pokud jsou
                stejné podmínky,
                import by se měl sám restartovat.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="export"><h4 class="subheadbold">GEDCOM Export</h4></a>
            <p>Tato stránka vám umožní exportovat svá data z určitého stromu do standardního souboru GEDCOM 5.5. Soubor bude uložen ve vaší složce
                GEDCOM (určena v Nastavení importu) a bude pojmenován názvem stromu a příponou ".ged".</p>

            <h5>Větev</h5>
            <p>Chcete-li do exportovaného souboru GEDCOM vložit pouze osoby a rodiny z určité větve, můžete tuto větev vybrat z tohoto seznamu.</p>

            <h5>Vyloučit žijící/Vyloučit neveřejné</h5>
            <p>Zaškrtnutím těchto tlačítek vyloučíte žijící nebo neveřejné osoby z exportovaného souboru GEDCOM.</p>

            <h5>Exportovat odkazy na média</h5>
            <p>Zaškrtnutím této volby vložíte informace, které se vztahují ke všem fotografiím, vyprávěním a jiným médiím připojeným k osobám,
                rodinám,
                pramenům a úložištím pramenů ve vybraném stromě. Tyto informace obsahují název souboru, popis a poznámky.</p>

            <h5>Lokální umístění fotografií/dokumentů/náhrobků/vyprávění/zvukových záznamů/videí</h5>
            <p>Chcete-li připojit ke každému souboru média lokální umístění (např. "C:\mojefotografie\" nebo "..\genealogie\"), zaškrtněte políčko
                "Exportovat odkazy na média", a poté do příslušného pole
                toto umístění zapište (zadat musíte koncové lomítko). Ponecháte-li tyto řádky prázdné, budou do souboru GEDCOM ke každému médiu
                uloženy pouze název souboru a umístění, které jsou v TNG,
                a budou exportovány s tagem "FILE".
            </p>

            <h5>Funkce "začít znovu"</h5>
            <p>Pokud neuvidíte zprávu o "dokončení", vaše data nebyla vyexportovány kompletně.
                Pokud neuvidíte žádné počty, nebo uvidíte počty, ale neuvidíte zprávu o "dokončení", váš server možná proces exportu ukončil, protože
                trval příliš dlouho.
                Pokud se vám to stalo, jděte na stránku Admin/Nastavení/Nastavení importu
                a zaškrtněte políčko <strong>Uložit stav importu</strong>. Pak se vraťte zpět na tuto na stránku a zkuste váš export znovu. Pokud váš
                export nedoběhne do konce, budete nyní moci
                kliknout na odkaz "pokračovat" v horní části stránky pro znovuzahájení exportu.</p>
        </td>
    </tr>

</table>
</body>
<?php echo "</html>"; ?>

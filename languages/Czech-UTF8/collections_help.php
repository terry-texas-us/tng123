<?php
include "../../helplib.php";
echo help_header("Nápověda: Kolekce");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="media_help.php" class="lightlink">&laquo; Nápověda: Média</a> &nbsp;|&nbsp;
                <a href="albums_help.php" class="lightlink">Nápověda: Alba &raquo;</a>
            </p>
            <h2 class="largeheader">Nápověda: <small>Kolekce</small></h2>
            <p class="smaller menu clear-both">
                <a href="#what" class="lightlink">Co to je?</a> &nbsp;|&nbsp;
                <a href="#add" class="lightlink">Přidat/Upravit/Vymazat</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="what"><h4 class="subheadbold">Co jsou to kolekce?</h4></a>

            <p><strong>Kolekcemi</strong> se v TNG rozumí typ média. Standardní kolekce v TNG jsou Fotografie, Dokumenty, Náhrobky, Vyprávění, Videa a
                Zvukové záznamy,
                ale TNG vám umožní vytvořit i vlastní kolekce. Kolekce není omezena jedním typem souboru. Např. obrázky .jpg mohou být součástí
                kterékoli kolekce,
                nejen fotografií a dokumentů, a kolekce Fotografie nemusí obsahovat pouze obrazové soubory.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="add"><h4 class="subheadbold">Přidání kolekce</h4></a>

            <p>Chcete-li přidat novou kolekci, klikněte na tlačítko "Přidat kolekci" kdekoli je viditelné (např. na obrazovkách Média, Přidat média a
                Upravit média).
                Po zobrazení malého okna vyplňte formulář. Význam jednotlivých polí je následující:</p>

            <h5>ID číslo kolekce</h5>
            <p>Velmi krátký řetězec znaků, který slouží jako identifikátor této kolekce. Neměl by obsahovat mezery ani žádné znaky, které nejsou
                alfanumerické,
                a měl mít maximálně 10 znaků. Např. pokud jste vytvořili kolekci pro vojenské záznamy, do tohoto pole byste měli zapsat "military".
                Tato hodnota se nikde nezobrazí, takže není důležité, jak ji pojmenujete, ale musí být jednoznačná.</p>

            <h5>Exportovat jako</h5>
            <p>Když exportujete soubor GEDCOM, který obsahuje média, soubor bude obsahovat řádek pro každou položku označující, o jaký typ média jde.
                Mělo by to být
                jedno slovo zapsané velkými písmeny. Např. fotografie se bude exportovat s typem "PHOTO". Pokud jste vytvořili novou kolekci nazvanou
                "Noviny",
                do tohoto pole můžete vložit "NEWSPAPER".</p>

            <h5>Zobrazený titul</h5>
            <p>Jde o název, který bude zobrazen kdekoli je zmíněna kolekce a kdekoli je zobrazena položka z této kolekce. Zobrazený titul může být o
                něco delší
                než ID číslo kolekce, ale měl by být také relativně krátký. Při použití stejného příkladu můžete do tohoto pole vložit "Vojenské
                záznamy".
                Standardně bude název, který zapíšete, použit ve všech jazycích. Pokud podporujete více jazyků a chcete, aby byl Zobrazovaný název
                přeložen do jazyků, které podporujete,
                budete do souboru "cust_text.php" ve složce každého jazyka muset vytvořit zápis. Klíčem proměnné $text by mělo být ID číslo kolekce a
                hodnotou je Zobrazovaný titul. V tomto příkladě by měl zápis vypadat takto:</p>

            <pre>$text['military'] = "Vojenské záznamy";</pre>

            <p>Tento zápis vložte do souboru cust_text.php v každém jazyce a přeložte pouze část "Vojenské záznamy". Klíč neboli ID číslo ("military")
                by neměl
                být přeložen.</p>

            <h5>Název složky</h5>
            <p>Název fyzické složky nebo adresáře na vašich webových stránkách, kde budou položky z této kolekce uloženy. Měl by být relativně krátký,
                bez mezer
                a s pouze alfanumerickými znaky (např. "military"). Po zápisu hodnoty můžete kliknout na tlačítko "Vytvořit složku". Měli byste
                uvidět zprávu o tom, zda bylo vytvoření úspěšné či nikoli. Pokud váš server tuto operaci nepovoluje, musíte pro vytvoření složky
                použít program FTP nebo
                nějaký online správce souborů. Složka by měla být vytvořena ve stejné rodičovské složce jako složky kolekcí "photos", "documents",
                "histories" a dalších.
                Aktuální název musí přesně odpovídat názvu, který jste zapsali ("Military" není stejné jako "military").</p>

            <h5>Lokální umístění</h5>
            <p>Toto pole vám pomůže stanovit, jak velkou část názvu lokálního umístění vašich médií je třeba uložit na vašich stránkách během importu
                souboru GEDCOM
                pomocí odebrání části názvu, která je jedinečná pro váš domácí počítač. Zadejte základní cestu nebo cesty (více položek oddělte
                čárkami), kde jsou soubory z této kolekce
                umístěny na vašem domácím počítači. Jinými slovy, v případě, že soubory v počítači se nachází ve složce "C:\Genealogie\Soubory", to je
                to, co byste sem měli zadat.
                TNG pak oddělí tuto část z každého příchozího názvu cesty a ponechá pouze název souboru nebo název další podsložky.
                Pokud soubory pro tuto kolekci jsou v místním počítači na více místech nebo pokud na ně váš soubor GEDCOM odkazuje, aniž by měly název
                plné cesty (např. pouze "MojeSoubory"),
                zadejte ty cesty jako více zápisů.
                Pokud jsou některé z vašich souborů umístěny v podsložkách tohoto umístění a na svých webových stránkách chcete tuto strukturu
                zachovat, podsložky nezadávejte do tohoto umístění.
                Chcete-li, aby se všechny soubory dostaly na vašem webu do stejné složky, ponechte toto pole prázdné. Pokud toto pole je prázdné, TNG
                automaticky odstraní všechno mimo názvů souborů.
            </p>

            <h5>Soubor s ikonou</h5>
            <p>Musíte vytvořit svoji vlastní ikonu nebo použít nějakou existující a název souboru s ikonou zapsat do tohoto pole. Soubor s ikonou může
                být umístěn v hlavní složce TNG
                nebo jej můžete uložit do složky "img" spolu s ostatními standardními ikonami (jako "tng_photo.gif" nebo "tng_doc.gif"). Pokud jej
                uložíte do složky "img",
                musíte k názvu souboru přidat příponu "img/".</p>

            <h5>Soubor náhledu</h5>
            <p>Toto je název výchozího obrázku náhledu této kolekce. Jinými slovy, pokud vytvoříte v této kolekci mediální položku a pro tuto
                specifickou položku nepoužijete
                náhled, obrázek zapsaný zde bude použit jako náhled. Obrázek náhledu může být uložen v hlavní složce TNG
                nebo jej můžete uložit do složky "img" spolu s ostatními standardními ikonami. Pokud jej uložíte do složky "img",
                musíte k názvu souboru přidat příponu "img/".</p>

            <h5>Pořadí v zobrazení</h5>
            <p>Zde zapište celé číslo, které bude udávat pořadí, ve které bude vaše vlastní kolekce zobrazena v rozbalovacích nabídkách ve veřejné
                oblasti. Nižší čísla se objeví jako první.</p>

            <h5>Stejné nastavení jako</h5>
            <p>Možná jste si všimli, že se obrazovky Přidat médium a Upravit médium trošku mění v závislosti na zvolené kolekci. Toto pole "stejné
                nastavení jako" vám umožní
                označit, kterou standardní kolekci vaše nová kolekce nejvíce připomíná, s ohledem na uspořádání těchto obrazovek.</p>

            <h4 class="subheadbold">Úprava/Vymazání kolekce</h4>

            <p>Pro úpravu existující vlastní kolekce (standardní nelze měnit, s výjimkou hodnot v Základním nastavení) vyberte kolekci z rozbalovacího
                seznamu a
                klikněte na tlačítko Upravit. Zobrazí se stejná pole, jako jsou výše uvedena.</p>

            <p>Pro vymazání existující vlastní kolekce vyberte kolekci z rozbalovacího seznamu a klikněte na tlačítko Vymazat. Vymazána by neměla být
                ani fyzická složka, kterou jste vytvořili,
                ani žádná položka nacházející se v této složce.</p>

        </td>
    </tr>

</table>
</body>
<?php echo "</html>"; ?>

<?php
include "../../helplib.php";
echo help_header("Nápověda: Druhotné procesy");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="https://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="https://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="data_help.php" class="lightlink">&laquo; Nápověda: Import / Export</a> &nbsp;|&nbsp;
                <a href="setup_help.php" class="lightlink">Nápověda: Nastavení &raquo;</a>
            </p>
            <h2 class="largeheader">Nápověda: <small>Druhotné procesy</small></h2>
            <p class="smaller menu clear-both">
                <a href="#what" class="lightlink">Co to je?</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="what"><h4 class="subheadbold">Co jsou to druhotné procesy?</h4></a>
            <p>Druhotné procesy jsou operace, které lze provést na vašich datech bezprostředně po ukončení importu. Chcete-li nějakou operaci provést,
                musíte nejdříve vybrat, zda má být provedena ve "Všech stromech" nebo
                pouze v jednom konkrétním. Pokud pouze v jednom, vyberte tento strom zde. Operace, které můžete provést, jsou následující:</p>

            <h5>Vysledovat linie</h5>
            <p>Po naimportování vašich dat kliknutím sem projdete vybraný strom a označíte všechny osoby s dětmi, což návštěvníkovi vašich stránek
                umožní snadněji najít jeho primární linii potomků.</p>

            <h5>Seřadit děti</h5>
            <p>V každé rodině vybraného stromu dojde k seřazení dětí podle data narození. Bude nahrazeno dřívější řazení, které bylo
                provedeno jinými součástmi TNG nebo vaší desktopovou aplikací.</p>

            <h5>Seřadit partnery</h5>
            <p>Partneři každé osoby vybraného stromu budou seřazeni podle data sňatku. Bude nahrazeno dřívější řazení, které bylo
                provedeno jinými součástmi TNG nebo vaší desktopovou aplikací.</p>

            <h5>Znovu označit větve</h5>
            <p>Nový import vašeho souboru GEDCOM s volbou <span class="emphasis">Nahradit všechna data</span> způsobí, že všechna dříve existující
                označení větví budou
                odstraněna. Kliknutím na toto tlačítko tato označení obnovíte (čísla ID musí odpovídat vašim dřívějším datům).</p>

            <h5>Vytvořit GENDEX</h5>
            <p>Dojde k vytvoření indexovaného souboru ve formátu GENDEX. V Základním nastavení určíte název složky, kam bude soubor uložen.
                Pokud vyberete "Všechny stromy", bude tento soubor pojmenován "gendex.txt". Pokud vyberete jeden strom, název vašeho souboru GENDEX
                bude ID číslo stromu (nikoli název stromu),
                a přípona .txt. Další informace o souborech GENDEX najdete na
                <a href="http://www.gendexnetwork.org">GenDex Network</a> nebo <a href="http://www.familytreeseeker.com">FamilyTreeSeeker.com</a>.</p>

            <h5>Publikování vašeho souboru GENDEX na TNG Network</h5>
            <p>Máte-li indexovaný soubor GENDEX, navštivte <a href="http://www.gendexnetwork.org">GenDex Network</a> nebo <a
                    href="http://www.familytreeseeker.com">FamilyTreeSeeker.com</a>.
                Budete si muset vytvořit účet a poté budete moci naimportovat váš soubor GENDEX. Pokaždé, když budete chtít aktualizovat váš výpis na
                TNG Network,
                budete potřebovat znovu vytvořit a znovu naimportovat váš soubor GENDEX.</p>

            <h5>Zredukovat menu médií</h5>
            <p>TNG obsahuje položky menu pro několik standardních kolekcí médií (Fotografie, Dokumenty, Vyprávění, Náhrobky, Videa a Zvukové záznamy).
                Pokud v některých kolekcích
                nemáte žádné položky, můžete pomocí kliknutí na tuto volbu tyto položky z menu odstranit. Přidáte-li v budoucnu do "redukované"
                kolekce nějakou položku,
                do menu se tato položka automaticky vrátí.</p>

            <h5>Obnovit Žijicí</h5>
            <p>Vyhledány budou všechny osoby, které nemají zapsané datum úmrtí a které se narodily před takovou dobou, že mohou být teoreticky ještě
                naživu, a budou označeny jako "Žijící".
                Přesný počet let je určen volbou "Pokud chybí datum úmrtí, předpokládat, že osoba zemřela, je-li starší než" na stránce Nastavení
                importu. Tam, kde je taková osoba partnerem, dojde
                také k označení rodiny jako žijící. A naopak, tento nástroj nalezne i všechny osoby, které mají zapsané datum úmrtí nebo pohřbu, nebo
                které se nenarodily v tomto časovém rozmezí
                a označí je jako zesnulé.</p>

            <h5>Vytvořit neveřejné</h5>
            <p>Vyhledány budou všechny osoby, které zemřely v nedávné minulosti, a budou označeny jako "Neveřejné". Přesný počet let vychází z volby
                "Osoba je neveřejná, pokud zemřela před méně než tolika lety"
                na stránce Nastavení importu. Tam, kde je taková osoba partnerem, dojde také k označení rodiny jako neveřejné. Na rozdíl od nástroje
                Obnovit žijicí zde
                nedojde u žádné osoby k odstranění označení Neveřejné.
            </p>
        </td>
    </tr>
</table>
</body>
<?php echo "</html>"; ?>

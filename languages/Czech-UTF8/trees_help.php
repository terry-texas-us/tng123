<?php

include "../../helplib.php";
echo help_header("Nápověda: Stromy");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="users_help.php" class="lightlink">&laquo; Nápověda: Uživatelé</a> &nbsp;|&nbsp;
                <a href="branches_help.php" class="lightlink">Nápověda: Větve &raquo;</a>
            </p>
            <h2 class="largeheader">Nápověda: <small>Stromy</small></h2>
            <p class="smaller menu clear-both">
                <a href="#search" class="lightlink">Hledat</a> &nbsp;|&nbsp;
                <a href="#add" class="lightlink">Přidat nebo upravit</a> &nbsp;|&nbsp;
                <a href="#delete" class="lightlink">Vymazat</a> &nbsp;|&nbsp;
                <a href="#clear" class="lightlink">Vyčistit</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="search"><h4 class="subheadbold">Hledat</h4></a>
            <p>Nalezení existujících stromů vyhledáním celého nebo části <strong>ID čísla stromu, názvu stromu, popisu</strong> nebo
                <strong>vlastníka</strong>.
                Výsledkem hledání bez zadaných voleb a hodnot ve vyhledávacích polích bude seznam všech stromů ve vaší databázi.</p>

            <p>Vyhledávací kritéria, která zadáte na této stránce, budou uchována, dokud nekliknete na tlačítko <strong>Obnovit</strong>, které znovu
                obnoví všechny výchozí hodnoty.</p>

            <h5>Akce</h5>
            <p>Tlačítko Akce vedle každého výsledku hledání vám umožní upravit, odstranit nebo přidat označení k tomuto stromu.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="add"><h4 class="subheadbold">Přidat nový / Upravit existující stromy</h4></a>
            <p><strong>Strom</strong> v TNG je zásobník samostatného souboru rodinných údajů. TNG umožňuje na vašich stránkách podporu více stromů,
                ale protože
                jsou stromy samostatné, nelze propojit osobu z jednoho stromu s osobou nebo rodinou z jiného stromu. Z tohoto důvodu by měly být
                osoby, které jsou nebo by měly být navzájem
                spojeny,
                udržovány ve stejném stromě.</p>

            <p><strong>POZN.: Strom musíte přidat před tím, než budete zadávat nebo importovat data</strong> osob, rodin, pramenů nebo úložiště
                pramenů. Pokud jste aktualizovali z nižší verze,
                nepodporovala stromy, budou vaše data spojena s výchozím stromem, který má prázdné ID číslo stromu. Další údaje tohoto stromu můžete
                upravit,
                ale ID číslo stromu zůstane prázdné (program s tímto dokáže pracovat).</p>

            <p>Chcete-li přidat nový strom, klikněte na záložku <strong>Přidat nový</strong> a pak vyplňte formulář.
                Význam polí je následující:</p>

            <h5>ID číslo stromu</h5>
            <p>Toto by měl být krátký, jednoznačný, jednoslovný identifikátor stromu. Musí obsahovat pouze alfanumerické znaky (číslice a písmena).
                Nepoužívejte písmena
                s diakritikou a mezery. Tento údaj se nikde nezobrazuje, s výjimkou řádku adresy ve vašem prohlížeči, takže může být zapsán pouze
                malými písmeny. Později tento údaj nelze změnit.
                Délka max. 20 znaků.</p>

            <h5>Název stromu:</h5>
            <p>Krátký název nebo fráze, která se bude zobrazovat a identifikovat strom. Objeví se na všech místech výběru stromu a podle tohoto názvu
                budou uživatelé strom znát.</p>

            <h5>Popis:</h5>
            <p>Delší popis tohoto stromu nebo dat, která obsahuje.</p>

            <h5>Majitel:</h5>
            <p>Osoba nebo organizace, která vytvořila nebo shromáždila údaje v tomto stromě, nebo osoba či organizace odpovědná za správu těchto
                údajů.</p>

            <h5>Email:</h5>
            <p>Emailová adresa majitele. Návrhy týkající se osob v tomto stromu budou posílány na tuto adresu, pokud existuje (jinak budou návrhy
                posílány na adresu uvedenou v Základním nastavení).</p>

            <h5>Adresa/město/kraj/PSČ/země/telefon:</h5>
            <p>Kontaktní údaje majitele.</p>

            <h5>Informace o majiteli zachovat neveřejné</h5>
            <p>Zaškrtnutím tohoto políčka skryjete emailovou adresu a jiné kontaktní údaje majitele tohoto stromu (pro návštěvníky ve veřejné
                oblasti).</p>

            <h5>Nepovolit uživatelům stáhnutí souborů GEDCOM</h5>
            <p>Zaškrtnutím tohoto políčka zabráníte uživatelům stáhnout z tohoto stromu soubory GEDCOM.</p>

            <h5>Nepovolit uživatelům tvorbu souborů PDF</h5>
            <p>Zaškrtnutím tohoto políčka zabráníte uživatelům vytvořit z tohoto stromu soubory PDF.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="delete"><h4 class="subheadbold">Vymazání stromů</h4></a>
            <p>Chcete-li odstranit strom, použijte záložku <a href="#search">Hledat</a> k nalezení stromu, a poté klikněte na ikonku Vymazat vedle
                záznamu tohoto stromu. Tento řádek změní
                barvu a poté po odstranění položky strom zmizí. <em>Všechna data spojená s tímto stromem (včetně osob, rodin,
                    pramenů, úložišť pramenů, médií a větví) budou také odstraněna</em>.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="clear"><h4 class="subheadbold">Vyčištění stromů</h4></a>
            Chcete-li strom "vyčistit" (vymazat všechny údaje, ale strom samotný ponechat), použijte záložku <a href="#search">Hledat</a> k nalezení
            stromu, a poté klikněte na ikonku Vyčistit
            vedle záznamu tohoto stromu.
            <em>Všechny údaje spojené s tímto stromem (včetně osob, rodin, pramenů, úložišť pramenů, médií a větví) budou odstraněny</em>.</p>

        </td>
    </tr>

</table>
</body>
<?php echo "</html>"; ?>

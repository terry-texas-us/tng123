<?php
include "../../helplib.php";
echo help_header("Nápověda: Spojení");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="repositories_help.php" class="lightlink">&laquo; Nápověda: Úložiště pramenů</a> &nbsp;|&nbsp;
                <a href="notes_help.php" class="lightlink">Nápověda: Poznámky &raquo;</a>
            </p>
            <h2 class="largeheader">Nápověda: <small>Spojení</small></h2>
            <p class="smaller menu" style="clear: both;">
                <a href="#what" class="lightlink">Co to je?</a> &nbsp;|&nbsp;
                <a href="#add" class="lightlink">Přidat/Upravit/Odstranit</a>
            </p>
        </td>
    </tr>

    <tr class="databack">
        <td class="tngshadow">
            <a id="what"><h4 class="subheadbold">Co jsou spojení?</h4></a>

            <p><strong>Spojení</strong> je záznam vztahu mezi dvěma osobami, mezi dvěma rodinami nebo mezi osobou a rodinou.
                Ze stromové struktury vaší databáze nemusí být vztah zřejmý. Ve skutečnosti dvě osoby/rodiny, které jsou propojeny
                pomocí spojení, nemusí být vůbec příbuzné.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="add"><h4 class="subheadbold">Přidání/Úprava/Odstranění spojení</h4></a>

            <p>Chcete-li přidat, upravit nebo odstranit spojení u osoby, vyhledejte osobu v Administrace/Osoba a upravte
                individuální záznam, a poté klikněte na ikonu Spojení v horní části obrazovky (pokud spojení již existují,
                na ikoně je zelená tečka). Po kliknutí na ikonu se objeví malé okno, kde jsou zobrazena všechna existující spojení
                pro aktivní osobu. Chcete-li pracovat se spojeními u rodin, vyhledejte rodinu v Administrace/Rodiny
                a upravte záznam rodiny, poté proveďte totéž jako v případě osoby.</p>

            <p>Chcete-li přidat nové spojení, klikněte na tlačítko "Přidat nové" a vyplňte formulář. Pokud vybraná osoba nebo rodina nemají žádné
                spojení,
                dostanete se přímo na obrazovku "Přidat nové spojení". Na této obrazovce budete moci označit,
                zda spojovaná entita je osoba nebo rodina.</p>

            <p>Chcete-li upravit nebo odstranit existující spojení, klikněte na příslušnou ikonu vedle tohoto spojení.</p>

            <p>Při přidání nebo úpravě spojení mějte na paměti následující:</p>

            <h5 class="optionhead">ID čísla osoby nebo rodiny</h5>
            <p>Zapište ID číslo osoby nebo rodiny, která má být spojena s aktivní osobou nebo rodinou, nebo klikněte na ikonu Najít a vyhledejte ID
                číslo.</p>

            <h5 class="optionhead">Vztah</h5>
            <p>Zapište povahu spojení. Např. <em>Kmotr</em>, <em>Učitel</em> nebo <em>Svědek</em>.</p>

            <h5 class="optionhead">Obrácené spojení?</h5>
            <p>Někdy jde spojení oběma směry. Např. vztah <em>Přítel</em> může mít působnost oběma směry. Je-li to pravda,
                a chcete vytvořit druhé spojení jdoucí opačným směrem, pak klikněte na tuto volbu. Pokud povaha vztahu není taková, že by
                platila i v opačném směru (např. <em>Kmotr</em> nebo <em>Učitel</em>), pak byste měli vytvořit jiné spojení, začínající
                od druhé osoby nebo rodiny, která zobrazí opačný vztah.</p>

            <p>Po ukončení přidání, úpravy nebo odstranění spojení u dané osoby nebo rodiny klikněte na tlačítko "Ukončit" a okno se uzavře.</p>

        </td>
    </tr>

</table>
</body>
<?php echo "</html>"; ?>

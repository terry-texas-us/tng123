<?php
include "../../helplib.php";
echo help_header("Nápověda: Citace");
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
                <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp; | &nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="notes_help.php" class="lightlink">&laquo; Nápověda: Poznámky</a> &nbsp; | &nbsp;
                <a href="events_help.php" class="lightlink">Nápověda: Události &raquo;</a>
            </p>
            <h2 class="largeheader">Nápověda: <small>Citace</small></h2>
            <p class="smaller menu">
                <a href="#what" class="lightlink">Co je to?</a> &nbsp; | &nbsp;
                <a href="#add" class="lightlink">Přidat/Upravit/Vymazat</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="what"><h4 class="subheadbold">Co jsou to citace?</h4></a>

            <p><strong>Citace</strong> je odkaz na záznam pramenu, provedená s úmyslem prokázat pravdivost nějakého údaje. Pramen obvykle
                všeobecně popisuje, kde byl uvedený údaj nalezen (např. matrika nebo sčítací arch), zatímco citace obvykle obsahuje konkrétní
                informaci (např. na které stránce).
                Jeden záznam pramenu může být citován vícekrát u různých osob, rodin, poznámek nebo událostí.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="add"><h4 class="subheadbold">Přidat/Upravit/Vymazat citace</h4></a>

            <p>Chcete-li přidat, upravit nebo vymazat citace, klikněte na ikonu Citace na stránce nahoře nebo vedle nějaké poznámky nebo události
                (pokud již citace existuje,
                na ikoně je zelená tečka). Po kliknutí na ikonu se objeví okno, ve kterém jsou zobrazeny
                všechny citace existující pro aktivní subjekt nebo událost.</p>

            <p>Chcete-li přidat novou citaci, klikněte na tlačítko "Přidat nové" a vyplňte formulář. Pokud vybraný subjekt nebo událost ještě neměly
                žádné
                citace, dostanete se přímo na obrazovku "Přidat novou citaci".</p>

            <p>Pokud chcete existující citaci upravit nebo vymazat, klikněte na příslušnou ikonu vedle této citace.</p>

            <p>Při přidání nebo úpravě citace si všimněte následujícího:</p>

            <h5 class="optionhead">ID číslo pramenu</h5>
            <p>Zapište ID číslo pramenu, který má být citován, nebo klikněte na tlačítko "Najít" pro jeho nalezení. Pokud pramen ještě nebyl vytvořen,
                přejděte do Admin/Prameny a vytvořte pramen v příslušném stromě. Poté se vraťte do seznamu citací nebo můžete kliknout na tlačítko
                "Vytvořit"
                pro zápis údajů o novém pramenu. Po uložení údajů bude do tohoto pole vloženo nové ID číslo pramenu.</p>
            <p>Pokud jste již během své aktuální relace pro stejný typ subjektu (osoba, rodina, atd.) vytvořili nějakou citaci, uvidíte také tlačítko
                "Kopírovat poslední". Kliknutí
                na toto tlačítko budou všechna pole vyplněna stejnými údaji, jako jste použili ve své minulé citaci.</p>

            <!--<h5 class="optionhead">Description</h5>
        <p>If your desktop genealogy program does not assign ID numbers to your sources, your citation will have a Description instead. You will not see
        the Description field for a new citation.</p>-->

            <h5 class="optionhead">Strana</h5>
            <p>Zapište stránku, na které se ve vybraném pramenu nachází tato událost (volitelné).</p>

            <h5 class="optionhead">Věrohodnost</h5>
            <p>Vyberte číslo (0-3), které označuje, na kolik je tento pramen věrohodný (volitelné). Vyšší čísla označují větší věrohodnost.</p>

            <h5 class="optionhead">Datum citace</h5>
            <p>Datum spojené s touto citací (volitelné).</p>

            <h5 class="optionhead">Vlastní text</h5>
            <p>Krátký výňatek z materiálu pramenu (volitelné).</p>

            <h5 class="optionhead">Poznámky</h5>
            <p>Užitečné poznámky, které se týkají tohoto pramenu (volitelné).</p>

        </td>
    </tr>

</table>
</body>
</html>

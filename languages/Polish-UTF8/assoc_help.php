<?php
include "../../helplib.php";
echo help_header("Pomoc: Związki");
?>

<body class="helpbody">
<a id="top"></a>
<table width="100%" cellpadding="10" cellspacing="2" class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tngforum.us" target="_blank" class="lightlink">TNG Forum</a> &nbsp; | &nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="repositories_help.php" class="lightlink">&laquo; Pomoc: Repozytoria</a> &nbsp; | &nbsp;
                <a href="notes_help.php" class="lightlink">Pomoc: Notatki &raquo;</a>
            </p>
            <span class="largeheader">Pomoc: Związki</span>
            <p class="smaller menu">
                <a href="#what" class="lightlink">Co to są związki?</a> &nbsp; | &nbsp;
                <a href="#add" class="lightlink">Dodaj/Edycja/Usuń</a>
            </p>
        </td>
    </tr>

    <tr class="databack">
        <td class="tngshadow">
            <a id="what"><p class="subheadbold">Co to są związki?</p></a>

            <p><strong>Związek</strong> jest zapisem relacji między dwojgiem ludzi w Twojej bazie danych, które
                nie muszą być oczywiste w regularnej strukturze Twego drzewa genealogicznego. Dwoje ludzi (np. chrześniak i matka chrzestna lub osoba
                zmarła i świadek zgonu),
                którzy są ze sobą powiązani w związku nie musi być ze sobą związanych w rzeczywistości.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="add"><p class="subheadbold">Dodawanie/Edycja/Usuwanie związków</p></a>

            <p>Aby dodać, edytować lub usuwać związki dla osób, zlokalizuj osobę w Administracja / Osoby i edytuj poszczególne zapisy,
                a następnie kliknij na ikonkę <em>Związki</em> na górze ekranu (jeśli istnieją już jakieś związki, ikonka będzie oznaczona zieloną
                kropką).
                Po kliknięciu ikonki, pojawi się małe okienko (popup), w którym zobaczysz wszystkie istniejące dla danej osoby związki.</p>

            <p>Aby dodać nowy związek, kliknij na "Dodaj nowe" i wypełnić formularz. </p>

            <p>Aby edytować lub usunąć istniejące związki, kliknij na odpowiednią ikonkę obok tego związku.</p>

            <p>Podczas dodawania lub edycji związków dostępne są następujące pola:</p>

            <span class="optionhead">ID osoby</span>
            <p>Wprowadź ID osoby, które mają być związane z wybraną osobą, lub kliknij ikonę "Znajdź" aby wyszukać jej ID.</p>

            <span class="optionhead">Wzajemny stosunek</span>
            <p>Wprowadź charakter związku między dwoma osobami. Na przykład, <em>ojciec chrzestny</em>, <em>świadek</em> itp.</p>

            <p>Po dodaniu, edycji lub usunięciu związków tej osoby, kliknij przycisk "Koniec", aby zamknąć okno.</p>
            <li><p>Uwagi dotyczące polskiego tłumaczenia: <a href="mailto:januszkielak@gmail.com">januszkielak@gmail.com</a>. Prosimy zgłaszać ewentualne błędy lub niejasności.</p></li>

        </td>
    </tr>

</table>
</body>
</html>

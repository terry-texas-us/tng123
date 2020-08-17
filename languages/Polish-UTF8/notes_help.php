<?php
include "../../helplib.php";
echo help_header("Pomoc: Notatki");
?>

<body class="helpbody">
<a name="top"></a>
<table width="100%" border="0" cellpadding="10" cellspacing="2" class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right" class="smaller menu">
                <a href="http://tngforum.us" target="_blank" class="lightlink">TNG Forum</a> &nbsp; | &nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br/>
                <a href="assoc_help.php" class="lightlink">&laquo; Pomoc: Związki</a> &nbsp; | &nbsp;
                <a href="citations_help.php" class="lightlink">Pomoc: Cytaty &raquo;</a>
            </p>
            <span class="largeheader">Pomoc: Notatki</span>
            <p class="smaller menu">
                <a href="#add" class="lightlink">Dodaj/Edytuj/Usuń</a> &nbsp; | &nbsp;
                <a href="#cite" class="lightlink">Notatki</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a name="add"><p class="subheadbold">Dodawanie/Edycja/Usuwanie notatek</p></a>

            <p>Aby dodać, edytować lub usuwać notatki dla osoby, rodziny, źródła, repozytorium lub wydarzenia, należy kliknąć na ikonkę na górze ekranu lub obok wybranego pola
                (jeśli istnieją już jakieś notatki, ikonka będzie oznaczona zieloną kropką). Po kliknięciu ikonki, pojawi się małe okienko (popup),
                w którym zobaczysz wszystkie istniejące dla wybranego źródła, wydarzenia itp. notatki.</p>

            <p>Aby dodać nową notatkę, kliknij na "Dodaj nowe" i wypełnić formularz. </p>

            <p>Aby edytować lub usunąć istniejące notatki, kliknij na odpowiednią ikonkę obok tej notatki.</p>

            <p>Podczas dodawania lub edycji notatek dostępne są następujące pola:</p>

            <span class="optionhead">Notatka</span>
            <p>Wpisz swoją notatkę, lub dokonaj zmian w dużym polu <strong>Notatek</strong> i kliknij przycisk "Zapisz".
                Notatka zostanie zapisana, nawet jeśli inne informacje dla aktywnego podmiotu nie są aktywne. Można tu wprowadzić kod HTML. Kody PHP i Javascript nie będą działać.</p>

            <span class="optionhead">Informacja prywatna</span>
            <p>Zaznacz to pole aby zapobiec wyświetlaniu notatki w obszarze publicznym.</p>


        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a name="cite"><p class="subheadbold">Dodawanie do notatek cytatów ze źródeł</p></a>
            <p>Aby dodać lub edytować cytaty ze źródeł w notatkach musisz najpierw zapisać notatkę, a następnie kliknąć na ikonkę "Cytat" obok wybranego zapisu notatki na wyświetlonej liście notatek.
                Aby uzyskać więcej informacji na temat cytatów zobacz <a href="citations_help.php">Pomoc: Cytaty</a>.</p>
            <li><p>Uwagi dotyczące polskiego tłumaczenia: <a href="mailto:januszkielak@gmail.com">januszkielak@gmail.com</a>. Prosimy zgłaszać ewentualne błędy lub niejasności.</p></li>
        </td>
    </tr>

</table>
</body>
</html>

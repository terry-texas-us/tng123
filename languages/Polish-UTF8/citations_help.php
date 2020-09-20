<?php
include "../../helplib.php";
echo help_header("Pomoc: Cytaty");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tngforum.us" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="notes_help.php" class="lightlink">&laquo; Pomoc: Notatki</a> &nbsp;|&nbsp;
                <a href="events_help.php" class="lightlink">Pomoc: Wydarzenia &raquo;</a>
            </p>
            <h2 class="largeheader">Pomoc: <small>Cytaty</small></h2>
            <p class="smaller menu" style="clear: both;">
                <a href="#what" class="lightlink">Co to jest cytat?</a> &nbsp;|&nbsp;
                <a href="#add" class="lightlink">Dodaj/Edycja/Usuń</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="what"><h4 class="subheadbold">Co to są cytaty?</h4></a>

            <p><strong>Cytat</strong> jest odniesieniem do zapisu źródła, dokonanym z zamiarem udowodnienia prawdziwości niektórych informacji. Źródło
                zawiera
                zwykle ogólne dane, gdzie została znaleziona informacja (np. księga lub spis ludności), cytat natomiast zawiera zwylke więcej
                szczegółowych
                informacji (np. na której stronie). To samo źródło może być cytowane w treści dokumentu wiele razy dla różnych osób, rodzin, notatek i
                wydarzeń.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="add"><h4 class="subheadbold">Dodawanie/Edycja/Usuwanie cytatów</h4></a>

            <p>Aby dodać, edytować lub usuwać cytaty, należy kliknąć na ikonkę na górze ekranu lub obok wybranego pola (jeśli istnieją już jakieś
                cytaty,
                ikonka będzie oznaczona zieloną kropką). Po kliknięciu ikonki, pojawi się małe okienko (popup), w którym zobaczysz wszystkie
                istniejące dla wybranego źródła, wydarzenia cytaty.</p>

            <p>Aby dodać nowy cytat, kliknij na "Dodaj nowe" i wypełnić formularz. </p>

            <p>Aby edytować lub usunąć istniejące cytaty, kliknij na odpowiednią ikonkę obok tego cytatu.</p>

            <p>Podczas dodawania lub edycji cytatów dostępne są następujące pola:</p>

            <h5 class="optionhead">Źródło</h5>
            <p>Wybierz istniejące źródło do cytowania. Jeśli źródło, które chcemy cytować nie pojawia się na liście źródeł, to znaczy że
                albo nie zostało jeszcze utworzone albo istnieje w innym drzewie. Najpierw przejdź do Administracja / Źródła i utwórz źródło
                dla właściwego drzewa, a następnie wrócić do listy cytatów i wybierz źródło.</p>

            <!--<h5 class="optionhead">Opis</h5>
        <p>Jeśli Twój program genealogiczny nie przydziela numerów ID swoim źródłom, cytaty będą miały swój opis. Nie zobaczysz pola do opisu nowych cytatów.</p>-->

            <h5 class="optionhead">Strona</h5>
            <p>Podaj stronę z wybranego źródła odnoszącą się do tego wydarzenia (opcjonalne).</p>

            <h5 class="optionhead">Wiarygodność</h5>
            <p>Wybierz cyfrę (0-3) wskazującą, jak wiarygodne jest źródło (opcjonalnie). Wyższe cyfry oznaczają większą wiarygodność.</p>

            <h5 class="optionhead">Data cytatu</h5>
            <p>Data związana z tym cytatem (opcjonalne).</p>

            <h5 class="optionhead">Faktyczny tekst</h5>
            <p>Krótki fragment z materiału źródłowego (opcjonalne).</p>

            <h5 class="optionhead">Notatki</h5>
            <p>Wszelkie uwagi pomocnicze dotyczące tego źródła (opcjonalne).</p><br>
            <li><p>Uwagi dotyczące polskiego tłumaczenia: <a href="mailto:januszkielak@gmail.com">januszkielak@gmail.com</a>. Prosimy zgłaszać
                    ewentualne błędy lub niejasności.</p></li>

        </td>
    </tr>

</table>
</body>
<?php echo "</html>"; ?>

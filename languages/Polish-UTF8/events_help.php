<?php
include "../../helplib.php";
echo help_header("Pomoc: Wydarzenia");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tngforum.us" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="citations_help.php" class="lightlink">&laquo; Pomoc: Cytaty</a> &nbsp;|&nbsp;
                <a href="more_help.php" class="lightlink">Pomoc: Więcej &raquo;</a>
            </p>
            <h2 class="largeheader">Pomoc: <small>Wydarzenia</small></h2>
            <p class="smaller menu clear-both">
                <a href="#what" class="lightlink">Wydarzenia standardowe a niestandardowe</a> &nbsp;|&nbsp;
                <a href="#add" class="lightlink">Dodaj nowe</a> &nbsp;|&nbsp;
                <a href="#edit" class="lightlink">Edycja istniejących</a> &nbsp;|&nbsp;
                <a href="#del" class="lightlink">Usuń</a> &nbsp;|&nbsp;
                <a href="#citations" class="lightlink">Cytaty</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="what"><h4 class="subheadbold">Wydarzenia standardowe a niestandardowe</h4></a>
            Większość wspólnych wydarzeń takich jak narodziny, śmierć, małżeństwo i kilka innych, jest zawarta na głównych stronach osób, rodzin,
            źródeł i repozytoriów.
            Te wydarzenia są przechowywane w odpowiednich tabelach bazy danych. Dokumentacja TNG odnosi się do tych wydarzeń jako "standardowe".
            Wszystkie inne wydarzenia są "niestandardowe" i są zarządzane w sekcji <strong>Inne wydarzenia</strong> na kartach osób, rodzin, źródeł i
            repozytoriów.
            Te wydarzenia są przechowywane w oddzielnym tabelach wydarzeń. Pomoc ta odnosi się do kwestii zarządzania tymi <em>niestandardowymi</em>
            wydarzeniami.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="add"><h4 class="subheadbold">Dodawanie wydarzeń</h4></a>

            <p>Aby dodać nowe wydarzenie, kliknij na "Dodaj nowe" w sekcji Inne wydarzenia, a następnie wypełnij formularz. Jeśli istnieją już jakieś
                wydarzenia,
                będą one wyświetlane w tabeli w sekcji Inne wydarzenia. Dla wyjaśnienia na temat dostępnych pól, patrz rozdział poniżej.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="edit"><h4 class="subheadbold">Edycja wydarzeń</h4></a>

            <p>Aby edytować istniejące wydarzenie, należy kliknąć na ikonkę Edycja obok tego wydarzenia w sekcji Inne wydarzenia (aby edytować dane w
                "standardowym" wydarzeniu takim jak na
                przykład narodziny lub zgon, zmień po prostu tekst).</p>

            <p>Podczas dodawania lub edycji notatki dostępne są następujące pola:</p>

            <h5>Rodzaj wydarzenia</h5>
            <p>Wybierz rodzaj wydarzenia (nie można zmienić rodzaju wydarzenia dla istniejącego wydarzenia). Jeśli potrzebnego rodzaju wydarzenia nie
                ma w polu wyboru, przejdź najpierw do
                Administracja / Niestandardowe rodzaje wydarzeń i ustaw rodzaj wydarzenia, a następnie powrócić na tę kartę, aby je wybrać.</p>

            <h5>Data wydarzenia</h5>
            <p>Rzeczywista lub zbliżona data związana z wydarzeniem.</p>

            <h5>Miejsce wydarzenia</h5>
            <p>Miejsce, gdzie nastąpiło wydarzenie. Podaj nazwę miejsca lub kliknij ikonkę "Znajdź" (lupka), aby zlokalizować wprowadzone wcześniej
                miejsce.</p>

            <h5>Szczegóły</h5>
            <p>Wszelkie dodatkowe wyjaśnienia w przypadku, jeśli jest to konieczne. Jeśli nie ma miejsca lub daty związanych z wydarzeniem, pole
                "szczegóły" powinno zawierać informacje dotyczące tych brakujących danych.</p>

            <h5>Więcej</h5>
            <p>Więcej rzadziej używanych informacji można dodać do każdego wydarzenia klikając na napis "Więcej" lub strzałkę obok niego. W ten sposób
                pojawią dodatkowe pola. Pola te możesz ukryć przez ponowne kliknięcie
                na napis lub strzałkę. Ukrywanie pól nie usuwa zapisanych informacji. Te dodatkowe pola to:</p>

            <p><h5>Wiek</h5>: Wiek osoby w czasie wydarzenia.</p>

            <p><h5>Urząd</h5>: Kompetentny i / lub odpowiedzialny w momencie wydarzenia organ lub instytucja.</p>

            <p><h5>Przyczyna</h5>: Przyczyna zdarzenia (najczęściej używane ze śmiercią).</p>

            <p><h5>Adres 1/Adres 2/Miasto/Województwo/Kod pocztowy/Kraj/Telefon/E-mail/Strona Web</h5>: Adres oraz inne informacje
            kontaktowe związane z wydarzeniem..</p>

            <h5>Wymagane pola:</h5>
            <p>Musisz wybrać rodzaj wydarzenia i wpisać coś w co najmniej jednym z następujących pól: <strong>data wydarzenia</strong>, <strong>miejsce
                    wydarzenia</strong>,
                lub <strong>szczególy</strong>. Wszystkie inne informacje są opcjonalne.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="del"><h4 class="subheadbold">Usuwanie wydarzeń</h4></a>

            <p>Aby usunąć istniejące wydarzenie, należy kliknąć na ikonkę Usuń obok tego wydarzenia w sekcji Inne wydarzenia. Wydarzenie zostanie
                usunięte, niezależnie od tego, czy strona zostanie zapisana.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="citations"><h4 class="subheadbold">Cytaty</h4>
                <p>Aby dodać lub edytować cytat ze źródła do wydarzenia musisz najpierw zapisać wydarzenie, a następnie kliknąć na ikonkę obok zapisu
                    tego wydarzenia na liście wydarzeń. Aby uzyskać więcej informacji na ten temat cytatów, zobacz <a
                        href="citations_help.php">Pomoc: Cytaty</a>.</p>
                <li><p>Uwagi dotyczące polskiego tłumaczenia: <a href="mailto:januszkielak@gmail.com">januszkielak@gmail.com</a>. Prosimy zgłaszać
                        ewentualne błędy lub niejasności.</p></li>

        </td>
    </tr>

</table>
</body>
<?php echo "</html>"; ?>

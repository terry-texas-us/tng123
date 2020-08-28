<?php
include "../../helplib.php";
echo help_header("Pomoc: Cmentarze");
?>

<body class="helpbody">
<a name="top"></a>
<table width="100%" cellpadding="10" cellspacing="2" class="tblback normal">
  <tr class="fieldnameback">
    <td class="tngshadow">
      <p style="float:right; text-align:right" class="smaller menu">
        <a href="http://tngforum.us" target="_blank" class="lightlink">TNG Forum</a> &nbsp; | &nbsp;
        <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
        <a href="albums_help.php" class="lightlink">&laquo; Pomoc: Albumy</a> &nbsp; | &nbsp;
        <a href="places_help.php" class="lightlink">Pomoc: Miejsca &raquo;</a>
      </p>
      <span class="largeheader">Pomoc: Cmentarze</span>
      <p class="smaller menu">
        <a href="#search" class="lightlink">Szukaj</a> &nbsp; | &nbsp;
        <a href="#add" class="lightlink">Dodaj lub edytuj</a> &nbsp; | &nbsp;
        <a href="#delete" class="lightlink">Usuń</a>
      </p>
    </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a name="search"><p class="subheadbold">Szukanie</p></a>
            <p>Znajdź istniejący cmentarz szukając jego pełnej nazwy lub jej części, ID cmentarza, miasta, powiatu, województwa, kraju lub nazwy pliku mapy. Jeśli nic nie wybierzesz,
                w polu wyszukiwania znajdziesz wszystkie cmentarze zapisane w bazie danych.</p>

            <p>Twoje kryteria wyszukiwania na tej stronie zostaną zapamiętane dopóki nie naciśniesz przycisku <strong>Zerowanie</strong>, który przywraca domyślne wartości i wszystkich wyszukiwań.</p>

            <span class="optionhead">Czynność</span>
            <p>Ikonki w polu "czynność" obok każdego wyniku wyszukiwania pozwalają na edycję, usuwanie lub podgląd tego wyniku. Aby usunąć więcej niż jeden rekord jednocześnie, kliknij pole w kolumnie
                <strong>Wybierz</strong> dla każdego rekordu, który ma zostać usunięty, a następnie kliknąć przycisk "Usuń wybrane" znajdujący się na górze listy. Użyj <strong>Wybierz wszystko</strong> lub <strong>Wyczyść wszystko</strong>
                aby zaznaczyć lub usunąć zaznaczenie wszystkich pól wyboru naraz.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Wróć</a></p>
            <a name="add"><p class="subheadbold">Dodawanie nowych / Edycja istniejących cmentarzy</p></a>
            <p>TNG pozwala na grupowanie nagrobków i wyświetlanie przy danym cmentarzu. Aby to zrobić, należy utworzyć nowy cmentarz dla każdej lokalizacji. Zapisy dotyczące cmentarzy w TNG nie są związane z zapisami miejsc
                pogrzebu i w pliku GEDCOM nie mają odwołania do cmentarzy. Jeśli więc nawet plik GEDCOM zawiera nazwy miejsc pogrzebów, nazwy te nie będą połączone z nazwami cmentarzy i po imporcie pliku GEDCOM łącza te muszą być utworzone w TNG.</p>

            <p>Aby dodać nowy cmentarz, kliknij przycisk <strong>Dodaj nowe</strong>, a następnie wypełnić formularz. Aby edytować istniejący cmentarz, należy użyć przycisku <a href="#search">Szukaj</a> aby zlokalizować cmentarz,
                a następnie kliknąć na ikonkę Edycja obok wybranej linii. Podczas dodawania lub edycji cmentarza dostępne są następujące elementy:</p>

            <span class="optionhead">Nazwa cmentarza</span>
            <p>Wpisz pełną nazwę cmentarza. Na przykład cmentarz znajdujący się w Warszawie na Wilanowie należy zapisać jako <em>Cmentarz rzymsko-katolicki w Wilanowie</em> lub <em>Warszawa, Wilanów, cmentarz rzymsko-katolicki</em> a nie tylko
                <em>Warszawa</em> lub <em>Wilanów</em>.</p>

            <span class="optionhead">Zdjęcie mapy do załadowania</span>
            <p>Jeśli masz mapę lub inne zdjęcia z tego cmentarza, które nie zostało jeszcze przesłane do Twojej witryny, kliknij przycisk "Przeglądaj" i znajdź go na dysku twardym Twego komputera. Jeśli zdjęcie jest już w folderze nagrobków na swojej
                stronie,
                zostaw to pole puste i użyj zamiast tego pola "Nazwa pliku mapy w folderze nagrobki"</p>

            <span class="optionhead">Nazwa pliku mapy w folderze Nagrobki</span>
            <p> Jeśli poprzednio załadowałeś plik mapy albo zdjęcie na serwer, podaj ścieżkę dostępu i dokładną nazwę pliku, jaka figuruje w katalogu Nagrobki . Możesz także kliknąć na przycisk Wybierz, aby zlokalizować plik. Jeśli przesyłałeś plik mapy
                lub zdjęcia przy użyciu
                poprzedniego pola, ścieżka i nazwa pliku zostanie Ci zaproponowana.</p>

            <p><span class="optionhead">UWAGA</span>: Jeśli załadowujesz nowy plik, folder musi już istnieć i musi być zapisywalny. Jeśli folder jeszcze nie istnieje możesz skorzystać z funkcji "Utwórz folder" w Ustawieniach głównych. Jeśli to zawiedzie,
                należy użyć programu FTP lub menedżera plików w online.
                Folder ten musi mieć uprawnienia 777 lub 755, które w wielu przypadkach również wystarczą. Nie używaj polskich liter takich jak np. ą, ę ż, ź. Pisz małymi literami, nie rozdzielaj nazwy kropkami lub przecinkami (np. 12.10.99 moje
                zdjęcie.jpg) Staraj się zapisywać nazwy plików jak w przykładzie: <strong>12_10_99_moje_zdjecie.jpg</strong>.</p>

            <p><span class="optionhead">Miasto, powiat, województwo, kraj</span>
            <p>Podaj tyle informacji, ile wiesz o lokalizacji tego cmentarza. Kraj jest wymagany, pozostałe pola opcjonalne.</p>

            <p>W polach <strong>Województwo</strong> i <strong>Kraj</strong> wybierz istniejący zapis korzystając z rozwijanej listy. Jeśli żądanego wpisu nie ma, skorzystaj z "Dodaj nowe", aby go dodać. Jeśli znajdziesz na liście niewłaściwy wpis zaznacz
                go, a następnie kliknij przycisk "Usuń zaznaczone".</p>

            <span class="optionhead">Pokaż/ukryj mapę Google</span>
            <p>Kliknij przycisk "Pokaż / Ukryj mapę Google", aby pokazać mapę. Ta opcja jest dostępna tylko jeśli masz "klucz mapy" z Google i wpisałeś go w Administracja/Ustawienia i konfiguracja/Ustawienia mapy (patrz <a href="mapsettings_help.php">Pomoc:
                    Ustawienia mapy</a>). Kliknij przycisk ponownie, aby ukryć mapę. Aby wyszukać
                miejscowość na mapie, wpisz jej nazwę w polu <strong>Określenie miejsca Geocode</strong> i kliknij "Szukaj". Możesz też kliknąć na mapę i przeciągnąć, aby przenieść "szpilkę" na żądaną lokalizację. Można również użyć kontroli Zoom, aby
                pokazać bardziej szczegółowo żądany obszar. Zobacz stronę
                <a href="places_googlemap_help.php">Pomoc: Mapy Google</a> aby uzyskać więcej informacji. W celu uzyskania informacji na temat domyślnych ustawień mapy patrz również <a href="mapsettings_help.php">Pomoc: Ustawienia mapy</a>.</p>

            <span class="optionhead">Szerokość/długość (geograficzna)</span>
            <p>Wprowadź szerokość i długość geograficzną lokalizacji cmentarza lub kliknij na wybrany punkt na mapie aby ustawić te wartości (opcjonalnie, patrz wyżej).</p>

            <span class="optionhead">Zoom</span>
            <p>Wpisz poziom powiększenia mapy, lub dostosuj poziom przy pomocy suwaka na mapie Google. Ta opcja jest dostępna tylko jeśli masz "klucz mapy" z Google i
                wpisałeś go w Administracja/Ustawienia i konfiguracja/Ustawienia mapy.</p>

            <span class="optionhead">Notatki</span>
            <p> Jeśli do opisania cmentarza lub jego lokalizacji potrzebne są dodatkowe informacje, wprowadź je tutaj (opcjonalnie).</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Wróć</a></p>
            <a name="delete"><p class="subheadbold">Usuwanie cmentarzy</p></a>
            <p>Aby usunąć jeden cmentarz, należy nacisnąć przycisk <a href="#search">Szukaj</a> w celu jego zlokalizowania, a następnie kliknąć na ikonkę Usuń obok tego cmentarza. Wiersz zmieni kolor,
                a następnie zniknie. Cmentarz został usunięty. Aby usunąć więcej niż jeden cmentarz naraz, zaznacz pole w kolumnie Wybierz obok każdego cmentarza, który ma zostać usunięty, a następnie kliknij
                przycisk "Usuń wybrane" znajdujący się na górze strony.</p>
            <li><p>Uwagi dotyczące polskiego tłumaczenia: <a href="mailto:januszkielak@gmail.com">januszkielak@gmail.com</a>. Prosimy zgłaszać ewentualne błędy lub niejasności.</p></li>

        </td>
    </tr>

</table>
</body>
</html>

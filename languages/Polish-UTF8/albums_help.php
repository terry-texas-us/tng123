<?php
include("../../helplib.php");
echo help_header("Pomoc: Albumy");
?>

<body class="helpbody">
<a name="top"></a>
<table width="100%" border="0" cellpadding="10" cellspacing="2" class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right" class="smaller menu">
                <a href="http://tngforum.us" target="_blank" class="lightlink">TNG Forum</a> &nbsp; | &nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br/>
                <a href="collections_help.php" class="lightlink">&laquo; Pomoc: Kolekcje</a> &nbsp; | &nbsp;
                <a href="cemeteries_help.php" class="lightlink">Pomoc: Cmentrze &raquo;</a>
            </p>
            <span class="largeheader">Pomoc: Albumy</span>
            <p class="smaller menu">
                <a href="#search" class="lightlink">Szukaj</a> &nbsp; | &nbsp;
                <a href="#add" class="lightlink">Dodaj nowy</a> &nbsp; | &nbsp;
                <a href="#edit" class="lightlink">Edytuj istniejący</a> &nbsp; | &nbsp;
                <a href="#delete" class="lightlink">Usuń</a> &nbsp; | &nbsp;
                <a href="#sort" class="lightlink">Sortuj</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a name="search"><p class="subheadbold">Szukaj</p></a>
            <p>Znajdź istniejące media szukając całości lub części <strong>nazwy albumu, opisu</strong> lub
                <strong>hasła</strong>. Szukanie bez podania żadnych kryteriów spowoduje, że ukażą się wszystkie albumy z Twojej bazy danych.</p>

            <p>Twoje kryteria wyszukiwania na tej stronie zostaną zapamiętane dopóki nie klikniesz przycisku <strong>Zerowanie</strong>, który przywraca domyślne wartości wszystkich wyszukiwań.</p>

            <span class="optionhead">Czynność</span>
            <p>Naciśnięcie przycisku w kolumnie "czynność" obok każdego albumu pozwala na edycję, usuwanie lub podgląd tego albumu.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Wróć</a></p>
            <a name="add"><p class="subheadbold">Dodawanie nowych albumów</p></a>
            <p><strong>Album</strong> w TNG jest grupą mediów. Album może zawierać dowolną liczbę mediów, pojedyncze media mogą należeć do wielu albumów.
                Podobnie jak poszczególne media, albumy mogą być połączone z osobami, rodzinami, źródłami, repozytoriami lub miejscami.</p>

            <p>Aby dodać nowy album, kliknij przycisk <strong>Dodaj nowe</strong> , a następnie wypełnić formularz. Informacje dotyczące mediów i łącza
                do osób, rodzin i innych podmiotów, mogą zostać dodane dopiero po naciśnięciu przycisku "zapisz i kontynuuj". Do dyspozycji są następujące pola:</p>

            <p><span class="optionhead">Nazwa albumu</span><br/>
                Nazwa Twojego albumu.</p>

            <p><span class="optionhead">Opis</span><br/>
                Krótki opis albumu lub elementów w nim zawartych.</p>

            <p><span class="optionhead">Słowa kluczowe</span><br/>
                Pewna ilość słów kluczowych poza nazwą albumu lub opis, który może być użyty w celu zlokalizowania tego albumu podczas wyszukiwania.</p>

            <p><span class="optionhead">Pola wymagane:</span> Tylko nazwa albumu jest wymagana, ale powinno być w Twoim interesie wypełnić również pozostałe pola.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Wróć</a></p>
            <a name="edit"><p class="subheadbold">Edycja istniejących albumów</p></a>
            <p>Aby wprowadzić zmiany do istniejącego albumu, należy nacisnąć przycisk <a href="#search">Szukaj</a> aby znaleźć album, a następnie kliknąć na ikonkę Edycja obok tego albumu.
                Następujących elementów nie ma na karcie "dodaj nowy album ":</p>

            <span class="optionhead">Album mediów</span>
            <p>Aby dodać media do albumu, kliknij na "Dodaj media", a następnie skorzystaj z wyskakującego okienka, aby wybrać media znajdujące się w bazie danych.
                Aby to zrobić, wybierz Kolekcję i / lub drzewo (oba pola opcjonalne), a następnie wpisz część nazwy lub opisu medium w polu "Szukaj dla" i kliknij "Szukaj".
                Po znalezieniu elementu, który chcesz dodać do albumu, kliknij na "Dodaj" po lewej stronie medium . Ta pozycja zostanie dodana ale okno pozostanie otwarte.
                Powtórz ten krok, aby zlokalizować i dodać więcej mediów, lub zamknij okno klikając na czerwone pole z krzyżykiem w prawym górnym rogu aby powrócić na kartę edycji albumu.</p>

            <p>Aby usunąć medium z albumu, przenieś wskaźnik myszy nad dany element. Ukaże się łącze "Usuń". Kliknij na to łącze, aby usunąć element.
                Po potwierdzeniu, pozycja ta zostanie usunięta z albumu.</p>

            <p>Aby wybrać <strong>zdjęcie standardowe</strong> dla bieżącego albumu, przenieś wskaźnik myszy nad wybrany element. Ukaże się łącze "Jako standard" .
                Kliknij na to łącze aby wybrać miniaturę tego elementu jako standardową dla albumu. Aby wybrać inne zdjęcie standardowe, powtórz ten proces z innej pozycji na liście.
                Aby usunąć zdjęcie standardowe, kliknij na "Usuń zdjęcie standardowe" u góry strony.</p>

            <p>Aby uporządkować media w albumie, kliknij na obszar "Przeciągnij" przy wybranym medium, przytrzymaj przycisk myszy i przesuń do żądanej lokalizacji w obrębie listy.
                Gdy osiągniesz wybrany punkt, zwolnij przycisk myszy ( "przeciągnij i upuść"). Zmiany zapisywane są automatycznie.</p>

            <span class="optionhead">Łącza albumów</span>
            <p>Możesz utworzyć łącze albumu do osób, rodzin, źródeł, repozytoriów lub miejsc. Dla każdego łącza, najpierw należy wybrać drzewo związane z łączem podmiotu.
                Następnie należy wybrać link "Rodzaj łącza" (osoby, rodziny, źródła, repozytoria lub miejsca), i wreszcie wprowadzić numer ID lub nazwę (tylko miejsca)
                linku podmiotu. Po wprowadzeniu wszystkich informacji kliknij przycisk "Dodaj".</p>

            <p>Jeśli nie znasz numeru ID lub dokładnej nazwy miejsca, kliknij na ikonę lupy aby w celu wyszukiwania. Pojawi się okienko popup. Gdy znajdziesz żądany opis podmiotu,
                kliknij przycisk "Dodaj" po lewej stronie. Możesz kliknąć "Dodaj" dla wielu podmiotów. Po zakończeniu tworzenia łączy kliknij na czerwone pole z krzyżykiem w prawym górnym rogu.</p>

            <p>UWAGA: Wszystkie zmiany odnoszące się do albumów mediów i łączy albumów są zapisywane bezpośrednio i nie wymagają klikania na przycisk "Zapisz" u dołu ekranu.
                Zmiany w "Informacje o istniejących albumach" wymagają zapisania.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Wróć</a></p>
            <a name="delete"><p class="subheadbold">Usuwanie albumów</p></a>
            <p>Aby usunąć album, wybierz kartę <a href="#search">Szukaj</a> w celu lokalizacji albumu, a następnie kliknij ikonę "Usuń" obok wybranego albumu.
                Wiersz zmieni kolor, a następnie zostanie usunięty.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Wróć</a></p>
            <a name="sort"><p class="subheadbold">Sortowanie albumów</p></a>
            <p>Domyślnie albumy połączone z osobami, rodzinami, źródłami, repozytoriami lub miejscami są sortowane według kolejności, w jakiej zostały połączone z danym podmiotem.
                Aby zmienić tę kolejność, należy przejść na kartę "Sortuj".</p>

            <span class="optionhead">Drzewo, Rodzaj łącza, Kolekcja:</span>
            <p>Wybierz drzewo powiązane z podmiotem, dla którego chcesz sortować Albumy. Następnie wybierz rodzaj łącza (osoby, rodziny, źródła, repozytoria lub miejsca)
                oraz kolekcję, które chcesz posortować.</p>

            <span class="optionhead">ID:</span>
            <p>Wprowadź numer ID lub nazwę (tylko miejsca) podmiotu. Jeśli nie znasz numeru ID lub dokładnej nazwy miejsca, kliknij ikonę lupy w celu wyszukania.
                Po znalezieniu żądanego podmiotu, kliknij przycisk "Wybierz" obok tego podmiotu. Okienko popup zostanie zamknięte i wybrany identyfikator pojawi się w polu ID.</p>

            <span class="optionhead">Procedura sortowania</span>
            <p>Po wybraniu lub wprowadzeniu ID, kliknij na przycisk "Kontynuuj", aby wyświetlić wszystkie albumy dla wybranych podmiotów i ich zbiory w aktualnym porządku.
                Aby zmienić kolejność albumów, kliknij na obszar "Przeciągnij" przy danym podmiocie, przytrzymaj przycisk myszy i przesuń do żądanej lokalizacji w obrębie listy.
                Gdy osiągniesz wybrany punkt, zwolnij przycisk myszy ( "przeciągnij i upuść"). Zmiany zapisywane są automatycznie.</p>
            <li><p>Uwagi dotyczące polskiego tłumaczenia: <a href="mailto:januszkielak@gmail.com">januszkielak@gmail.com</a>. Prosimy zgłaszać ewentualne błędy lub niejasności.</p></li>

        </td>
    </tr>

</table>
</body>
</html>

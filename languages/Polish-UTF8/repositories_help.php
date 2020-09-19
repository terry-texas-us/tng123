<?php
include "../../helplib.php";
echo help_header("Pomoc: Repozytoria");
?>

<body class="helpbody">
<a id="top"></a>
<table width="100%" cellpadding="10" cellspacing="2" class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tngforum.us" target="_blank" class="lightlink">TNG Forum</a> &nbsp; | &nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="sources_help.php" class="lightlink">&laquo; Pomoc: Źródła</a> &nbsp; | &nbsp;
                <a href="assoc_help.php" class="lightlink">Pomoc: Związki &raquo;</a>
            </p>
            <span class="largeheader">Pomoc: Repozytoria</span>
      <p class="smaller menu">
        <a href="#search" class="lightlink">Szukaj</a> &nbsp; | &nbsp;
          <a href="#add" class="lightlink">Dodaj nowe</a> &nbsp; | &nbsp;
          <a href="#edit" class="lightlink">Edycja istniejących</a> &nbsp; | &nbsp;
          <a href="#delete" class="lightlink">Usuń</a> &nbsp; | &nbsp;
          <a href="#merge" class="lightlink">Scalanie</a>
      </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="search"><p class="subheadbold">Szukanie</p></a>
            <p>Znajdź istniejące repozytoria szukając <strong>ID</strong> lub <strong>nazwy Repozytorium</strong> albo ich części.
                Wybierz drzewo lub zaznacz "Tylko dokładna nazwa" w celu dalszego zawężenia kryteriów wyszukiwania. Jeśli nie wybierzesz żadnej z
                wymienionych opcji,
                w polu wyszukiwania znajdą się wszystkie repozytoria zapisane w bazie danych.</p>

            <p>Twoje kryteria wyszukiwania na tej stronie zostaną zapamiętane dopóki nie naciśniesz przycisku <strong>Zerowanie</strong>, który
                przywraca domyślne wartości i wszystkich wyszukiwań.</p>

            <span class="optionhead">Czynność</span>
            <p>Ikonki w polu "czynność" obok każdego wyniku wyszukiwania pozwalają na edycję, usuwanie lub podgląd tego wyniku. Aby usunąć więcej niż
                jeden rekord jednocześnie, kliknij pole w kolumnie
                <strong>Wybierz</strong> dla każdego rekordu, który ma zostać usunięty, a następnie kliknąć przycisk "Usuń wybrane" znajdujący się na
                górze listy. Użyj <strong>Wybierz wszystko</strong> lub <strong>Wyczyść wszystko</strong>
                aby zaznaczyć lub usunąć zaznaczenie wszystkich pól wyboru naraz.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Wróć</a></p>
            <a id="add"><p class="subheadbold">Dodaj nowe repozytoria</p></a>
            <p><strong>Repozytorium</strong> jest zbiorem źródeł.</p>

            <p>Aby dodać nowe repozytorium, kliknij na <strong>Dodaj nowe</strong> a następnie wypełnić formularz. Niektóre informacje (notatki i
                dodatkowe wydarzenia)
                mogą być dodane dopiero po kliknięciu na przycisk Zapisz i kontynuuj lub Zastosuj. Do dyspozycji są następujące pola:</p>

            <span class="optionhead">Drzewo</span>
            <p>Jeśli masz tylko jedno drzewo, zostanie ono zaznaczone automatycznie. W innym przypadku, należy wybrać drzewo na nowego
                repozytorium.</p>

            <span class="optionhead">ID Repozytorium</span>
            <p>ID repozytorium musi być unikalne w obrębie wybranego drzewa i może składać się ze skrótu <strong>REPO</strong> lub litery
                <strong>R</strong> oraz następujących po nich cyfr (nie więcej niż 22 znaki w sumie).
                Numer ID jest generowany automatycznie za każdym razem, gdy strona jest wyświetlana po raz pierwszy, ale można także w razie potrzeby wpisać własny ID.
                Aby sprawdzić, czy wpisany ID jest unikalny, kliknij przycisk <strong>Sprawdź</strong>. Pojawi się informacja mówiąca, czy wybrany ID jest dostępny.
                Aby wygenerować unikalny ID, kliknij przycisk <strong>Generuj</strong>. Będzie to najwyższa liczba zlokalizowana w bazie danych (najwyższe używane ID + 1). Aby zabezpieczyć wybrany ID przed zajęciem go przez
              innego użytkownika podczas wprowadzania danych, kliknij przycisk <strong>Zastosuj</strong>.</p>

          <p><strong>UWAGA</strong>: Jeśli korzystasz na Twoim komputerze z programu genealogicznego, który także tworzy numery ID dla nowych osób,
            jest WYSOCE ZALECANE zachowanie tych ID dla synchronizacji między dwoma programami. Brak tej synchronizacji może skutkować konfliktami, które mogą spowodować,
            że Twoje łącza do zdjęć, historii i nagrobków mogą stać się nie do użycia. Jeśli Twój program tworzy ID, nie dostosowane do tradycyjnych standardów
            (na przykład <strong>I</strong> jest na końcu, nie na początku), możesz zmodyfikować plik "prefixes.php" tak, aby przyjmował inne prefiksy.</p>

          <span class="optionhead">Nazwa</span>
          <p>Krótka nazwa repozytorium.</p>

            <span class="optionhead">Adres 1, Adres 2, Miasto, Województwo, Kod pocztowy, Kraj</span><br>
            <p>Lokalizacja repozytorium (jeśli dotyczy; wszystkie dane opcjonalne).</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Wróć</a></p>
            <a id="edit"><p class="subheadbold">Edycja istniejących repozytoriów</p></a>
            <p>Aby wprowadzić zmiany dotyczące istniejącego repozytorium, należy kliknąć przycisk <a href="#search">Szukaj</a> w celu jego
                zlokalizowania, a następnie kliknąć na ikonkę "Edycja" obok wybranego repozytorium.</p>

            <span class="optionhead">Notatki</span>
            <p>Notatki możesz łączyć z wydarzeniami lub repozytorium klikając na ikony łączy u góry strony lub obok każdego wydarzenia.
                "Więcej" informacji dla wydarzenia można dodać klikając na ikonkę "Plus ". Jeśli w którejś z kategorii istnieją już jakieś elementy,
                odpowiednie ikonki oznaczone są zielonymi kropkami w prawym górnym rogu. Aby uzyskać więcej informacji na temat każdej z kategorii,
                zobacz <em>Pomoc</em> w okienkach,
                które stają się widoczne, gdy ikona zostanie naciśnięta.</p>

            <span class="optionhead">Inne wydarzenia</span>
            <p>Aby dodać lub zarządzać dodatkowymi wydarzeniami, kliknij na przycisk "Dodaj nowe" obok <strong>Inne wydarzenia</strong>. Klikając <a
                    href="events_help.php">Pomoc</a> znajdziesz więcej informacji na temat dodawania nowych wydarzeń.
                Gdy wydarzenie zostało dodane, pod polem "Dodaj nowe" pokaże się krótkie streszczenie. Przyciski w polu "Czynność" dla każdego wydarzenia pozwalają na edycję
                lub usunięcie wydarzenia, oraz dodawanie notatek lub cytatów. Kolejność, w której wydarzenia są wyświetlane jest ustalana wg daty (jeżeli dotyczy) i przez przypisany w "Rodzajach wydarzeń " priorytet
                (jeśli nie jest związane terminem). Priorytet ten może ulec zmianie podczas edycji rodzajów wydarzeń.

            <p><strong>Uwaga</strong>: Takie informacje o standardowych wydarzeniach jak uwagi, cytaty ze źródeł, związki, "inne" wydarzenia i
                "więcej" są zapisywane
                automatycznie. Inne zmiany (dotyczące np. nazwiska lub standardowego wydarzenia) można zapisać klikając przycisk "Zapisz" na dole
                strony,
                lub klikając na ikonkę "Zapisz" u góry strony. Drzewo oraz ID osoby nie mogą zostać zmienione.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Wróć</a></p>
            <a id="delete"><p class="subheadbold">Usuwanie repozytoriów</p></a>
            <p>Aby usunąć jedno repozytorium, należy nacisnąć przycisk <a href="#search">Szukaj</a> w celu jego zlokalizowania, a następnie kliknąć na
                ikonkę Usuń obok tego repozytorium. Wiersz zmieni kolor,
                a następnie zniknie. Repozytorium zostało usunięte. Aby usunąć więcej niż jedno repozytorium naraz, zaznacz pole w kolumnie Wybierz
                obok każdego repozytorium, które
                ma zostać usunięte, a następnie kliknąć przycisk "Usuń wybrane" znajdujący się na górze strony.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Wróć</a></p>
            <a id="merge"><p class="subheadbold">Scalanie</p></a>
            <p>Aby znaleźć i scalić dwa powtarzające się repozytoria, które mogą być nieco inne, lecz odnoszą się do tego samego materiału, kliknij na
                przycisk "Scalanie".
                Użytkownik decyduje, czy dwa zapisy są identyczne, czy też nie.</p>

            <span class="optionhead">Szukaj zgodności</span>
            <p>Po pierwsze, wybierz drzewo. Nie możesz połączyć repozytoriów z różnych drzew, tak więc tylko jedno drzewo może zostać wybrane. Dalej,
                masz możliwość
                wyboru źródła jako punkt wyjściowy dla Twojego szukania (Repozytorium 1), albo zezwolić TNG na szukanie pierwszej zgodności za Ciebie.
                Jeśli zdecydowałeś,
                że TNG wyszukuje zgodności, pozostaw pole ID Repozytorium 1 puste.</p>

            <p>Jeśli wybrałeś repozytorium jako Repozytorium 1, możesz też wybrać ręcznie ID Repozytorium 2. Wskazane jest jednak, aby pozwolić TNG na
                szukanie duplikatów dla Repozytorium 1,
                pozostawiając pole ID Repozytorium 2 puste.</p>

          <span class="optionhead">Inne opcje</span>
          <p><em>Połącz notatki</em> znaczy, że notatki z Repozytorium 2 będą dodane do notatek z Repozytorium 1 we wszystkich polach. Jeśli ta możliwość nie zostanie wybrana,
            notatki dotyczące Repozytorium 2 zostaną utracone, ponieważ zostaną skasowane przez te, odpowiadające polu Repozytorium 1.</p>

          <p><em>Połącz media</em> znaczy, że media z Repozytorium 2 będą dodane do mediów Repozytorium 1 we wszystkich polach. Jeśli ta możliwość nie zostanie wybrana,
            media dotyczące Repozytorium 2 zostaną utracone, ponieważ zostaną skasowane przez te, odpowiadające polu Repozytorium 1.</p>

          <p><span class="optionhead">Ostrzeżenie!</span> Raz wykonane scalanie nie może zostać cofnięte! Proszę rozważyć wykonanie kopii zapasowej tabel bazy danych zanim dokonasz operacji scalania na wypadek,
            gdybyś scalił niechcąco niewłaściwe osoby.</p>

          <span class="optionhead">Następna zgodność</span><br>
          <p>Znajdź następną możliwą zgodność, która nie wymaga podania Repozytorium 1. TNG zmienia listę możliwych repozytoriów w przyporządkowany ID repozytorium ciąg znaków.
            To znaczy, że "10" następuje po "1" ale przed "2".</p>

          <span class="optionhead">Następny duplikat</span><br>
          <p>Znajdź następny możliwy duplikat dla Repozytorium 1. Jeśli ta operacja zakończy się brakiem zapisu dla Repozytorium 2, znaczy, że duplikat nie został znaleziony.</p>

          <span class="optionhead">Porównaj / odśwież.</span><br>
          <p>Porównanie Repozytoriów 1 i 2. Jeśli to porównanie jest już widoczne, kliknięcie na ten przycisk spowoduje odświeżenie strony.</p>

          <span class="optionhead">Przełącz</span><br>
          <p>Zamiana - Repozytorium 1 staje się Repozytorium 2 i vice versa.</p>

          <span class="optionhead">Scalanie</span>
          <p>Repozytorium 2 jest scalane z Repozytorium 1. ID Repozytorium 1 zostanie zachowane, podobnie jak wszystkie inne dane Repozytorium 1 chyba, że dla Repozytorium 2 zostało
            zaznaczone odpowiednie pole(a). Na przykład, jeśli zaznaczyłeś pole autor dla Repozytorium 2, dane w tym polu będą podczas scalania skopiowane ze Repozytorium 2 do Repozytorium 1.
            Odpowiadające im dane Repozytorium 1 zostaną wtedy usunięte. Pola dla Repozytorium 2 są znaczone automatycznie, jeśli żadne odpowiadające im dane nie istnieją dla Repozytorium 1.
            ID Repozytorium 1 zostanie zachowane. Jeśli pole danych dla Repozytorium 1 lub 2 jest puste, znaczy, że nie istnieją żadne dane dla któregokolwiek repozytorium.</p>

          <span class="optionhead">Edycja</span>
          <p>Edytuj indywidualny zapis dla tego repozytorium w nowym oknie. Jeśli dokonałeś zmian, musisz kliknąć Porównaj / odśwież by zobaczyć zmiany w widoku scalania.</p>

        </td>
    </tr>

</table>
</body>
</html>

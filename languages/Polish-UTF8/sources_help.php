<?php
include "../../helplib.php";
echo help_header("Pomoc: Źródła");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tngforum.us" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="families_help.php" class="lightlink">&laquo; Pomoc: Rodziny</a> &nbsp;|&nbsp;
                <a href="repositories_help.php" class="lightlink">Pomoc: Repozytoria &raquo;</a>
            </p>
            (<h2 class="largeheader">Pomoc: <small>Źródła</small></h2>
            <p class="smaller menu" style="clear: both;">
                <a href="#search" class="lightlink">Szukaj</a> &nbsp;|&nbsp;
                <a href="#add" class="lightlink">Dodaj nowe</a> &nbsp;|&nbsp;
                <a href="#edit" class="lightlink">Edycja</a> &nbsp;|&nbsp;
                <a href="#delete" class="lightlink">Usuń</a> &nbsp;|&nbsp;
                <a href="#merge" class="lightlink">Scalanie</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="search"><h4 class="subheadbold">Szukanie</h4></a>
            <p>Znajdź istniejące źródła szukając pełnego lub części <strong>ID źródła, tytułu, autora, numeru telefonu</strong> lub
                <strong>wydawcy</strong>.
                Wybierz drzewo lub zaznacz "Tylko dokładna nazwa" w celu dalszego zawężenia kryteriów wyszukiwania.
                Jeśli nie wybierzesz żadnej z wymienionych opcji, w polu wyszukiwania znajdą się wszystkie źródła zapisane w bazie danych.</p>

            <p>Twoje kryteria wyszukiwania na tej stronie zostaną zapamiętane dopóki nie naciśniesz przycisku <strong>Zerowanie</strong>, który
                przywraca domyślne wartości i wszystkich wyszukiwań.</p>

            <h5 class="optionhead">Czynność</h5>
            <p>Ikonki w polu "czynność" obok każdego wyniku wyszukiwania pozwalają na edycję, usuwanie lub podgląd tego wyniku. Aby usunąć więcej niż
                jeden rekord jednocześnie, kliknij pole w kolumnie
                <strong>Wybierz</strong> dla każdego rekordu, który ma zostać usunięty, a następnie kliknąć przycisk "Usuń wybrane" znajdujący się na
                górze listy. Użyj <strong>Wybierz wszystko</strong> lub <strong>Wyczyść wszystko</strong>
                aby zaznaczyć lub usunąć zaznaczenie wszystkich pól wyboru naraz.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Wróc</a></p>
            <a id="add"><h4 class="subheadbold">Dodawanie nowego źródła</h4></a>
            <p><strong>Źródło</strong> jest formą ewidencji cytatów przeznaczonych do udowodnienia lub uzasadnienia jakiegoś elementu danych. To samo
                źródło może być cytowane w treści dokumentu wielokrotnie na wielu osób,
                rodzin lub wydarzeń.</p>

            <p>Aby dodać nowe źródło, kliknij na <strong>Dodaj nowe</strong> a następnie wypełnić formularz. Niektóre informacje (notatki i dodatkowe
                wydarzenia) mogą być dodane dopiero po kliknięciu na
                przycisk Zapisz i kontynuuj. Do dyspozycji są następujące pola:</p>

            <h5 class="optionhead">Drzewo</h5>
            <p>Jeśli masz tylko jedno drzewo, zostanie ono zaznaczone automatycznie. W innym przypadku, należy wybrać drzewo na nowej osoby.</p>

            <h5 class="optionhead">ID źródła</h5>
            <p>ID źródła musi być unikalne w obrębie wybranego drzewa i powinno składać się z litery <strong>S</strong> oraz następujących po niej
                cyfr (nie więcej niż 21).
                Numer ID jest generowany automatycznie za każdym razem, gdy strona jest wyświetlana po raz pierwszy, ale można także w razie potrzeby
                wpisać własny ID.
                Aby sprawdzić, czy wpisany ID jest unikalny, kliknij przycisk <strong>Sprawdź</strong>. Pojawi się informacja mówiąca, czy wybrany ID
                jest dostępny.
                Aby wygenerować unikalny ID, kliknij przycisk <strong>Generuj</strong>. Będzie to najwyższa liczba zlokalizowana w bazie danych
                (najwyższe używane ID + 1).
                Aby zabezpieczyć wybrany ID przed zajęciem go przez innego użytkownika podczas wprowadzania danych, kliknij przycisk
                <strong>Zastosuj</strong>.</p>

            <p><strong>UWAGA</strong>: Jeśli korzystasz na Twoim komputerze z programu genealogicznego, który także tworzy numery ID dla nowych osób,
                jest WYSOCE ZALECANE zachowanie tych ID dla synchronizacji między dwoma programami. Brak tej synchronizacji może skutkować
                konfliktami, które mogą spowodować,
                że Twoje łącza do zdjęć, historii i nagrobków mogą stać się nie do użycia. Jeśli Twój program tworzy ID, nie dostosowane do
                tradycyjnych standardów
                (na przykład <strong>I</strong> jest na końcu, nie na początku), możesz zmodyfikować plik "prefixes.php" tak, aby przyjmował inne
                prefiksy.</p>

            <h5 class="optionhead">Krótki tytuł</h5>
            <p>Skrócony tytuł dla źródła.</p>

            <h5 class="optionhead">Długi tytuł</h5>
            <p>Formalny, długi tytuł dla źródła.</p>

            <h5 class="optionhead">Autor, numer telefonu, wydawca</h5>
            <p>Dodatkowa informacja związana ze źródłem (jeśli dostępna).</p>

            <h5 class="optionhead">Repozytorium</h5>
            <p>Wybierz repozytorium, w którym znajduje się to źródło. Jeśli repozytorium jeszcze nie istnieje, przejdź do działu
                Administracja/Repozytoria, dodaj go tam,
                wtedy wróć i wybierz go tutaj.</p>

            <h5 class="optionhead">Faktyczny tekst</h5>
            <p>Cytat albo fragment materiału ze źródła (opcjonalne).</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Wróć</a></p>
            <a id="edit"><h4 class="subheadbold">Edycja istniejących źródeł</h4></a>
            <p>Aby wprowadzić zmiany dotyczące istniejącego źródła, należy kliknąć przycisk <a href="#search">Szukaj</a> w celu jego zlokalizowania, a
                następnie kliknąć na ikonkę "Edycja" obok wybranego źródła.</p>

            <h5 class="optionhead">Notatki</h5>
            <p>Notatki możesz łączyć z wydarzeniami lub źródłami klikając na ikony łączy u góry strony lub obok każdego wydarzenia.
                "Więcej" informacji dla wydarzenia można dodać klikając na ikonkę "Plus ". Jeśli w którejś z kategorii istnieją już jakieś elementy,
                odpowiednie ikonki oznaczone są zielonymi kropkami w prawym górnym rogu. Aby uzyskać więcej informacji na temat każdej z kategorii,
                zobacz <em>Pomoc</em> w okienkach,
                które stają się widoczne, gdy ikona zostanie naciśnięta.</p>

            <h5 class="optionhead">Inne wydarzenia</h5>
            <p>Aby dodać lub zarządzać dodatkowymi wydarzeniami, kliknij na przycisk "Dodaj nowe" obok <strong>Inne wydarzenia</strong>. Klikając <a
                    href="events_help.php">Pomoc</a> znajdziesz więcej informacji na temat dodawania nowych wydarzeń.
                Gdy wydarzenie zostało dodane, pod polem "Dodaj nowe" pokaże się krótkie streszczenie. Przyciski w polu "Czynność" dla każdego
                wydarzenia pozwalają na edycję
                lub usunięcie wydarzenia, oraz dodawanie notatek lub cytatów. Kolejność, w której wydarzenia są wyświetlane jest ustalana wg daty
                (jeżeli dotyczy) i przez przypisany w "Rodzajach wydarzeń " priorytet
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
            <a id="delete"><h4 class="subheadbold">Usuwanie źródeł</h4></a>
            <p>Aby usunąć jedno źródło, należy nacisnąć przycisk <a href="#search">Szukaj</a> w celu jego zlokalizowania, a następnie kliknąć na
                ikonkę Usuń obok tego źródła. Wiersz zmieni kolor,
                a następnie zniknie. Źródło zostało usunięte. Aby usunąć więcej niż jedno źródło naraz, zaznacz pole w kolumnie Wybierz obok każdego
                źródła, które
                ma zostać usunięte, a następnie kliknąć przycisk "Usuń wybrane" znajdujący się na górze strony.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Wróć</a></p>
            <a id="merge"><h4 class="subheadbold">Scalanie</h4></a>
            <p>Aby znaleźć i scalić dwa powtarzające się źródła, które mogą być nieco inne, lecz odnoszą się do tego samego materiału, kliknij na
                przycisk "Scalanie".
                Użytkownik decyduje, czy dwa zapisy są identyczne, czy też nie.</p>

            <h5 class="optionhead">Szukaj zgodności</h5>
            <p>Po pierwsze, wybierz drzewo. Nie możesz połączyć źródeł z różnych drzew, tak więc tylko jedno drzewo może zostać wybrane. Dalej, masz
                możliwość
                wyboru źródła jako punkt wyjściowy dla Twojego szukania (Źródło 1), albo zezwolić TNG na szukanie pierwszej zgodności za Ciebie. Jeśli
                zdecydowałeś,
                że TNG wyszukuje zgodności, pozostaw pole ID źródła 1 puste.</p>

            <p>Jeśli wybrałeś źródło jako Źródło 1, możesz też wybrać ręcznie ID Źródła 2. Wskazane jest jednak, aby pozwolić TNG na szukanie
                duplikatów dla Źródła 1,
                pozostawiając pole ID Źródła 2 puste.</p>

            <h5 class="optionhead">Zgodność następujących pozycji</h5>
            <p>Te kryteria TNG służą do określania możliwych zgodności. Tytuł i krótki tytuł jako domyślne. To oznacza, że te pola muszą zgadzać się w
                obydwóch
                zapisach, aby zostały wzięte pod uwagę jako możliwe zgodności. Jeśli wybierzesz też autora, wydawcę, repozytorium, faktyczny tekst,
                to te pola muszą się też zgadzać.</p>

            <h5 class="optionhead">Inne opcje</h5>
            <p><em>Ignoruj puste pola</em> znaczy, że puste pola nie będą brane pod uwagę. Na przykład, źródła z krótkim, nie pełnym tytułem nie
                zostanie uwzględnione,
                jeśli pełny tytuł jest wśród zaznaczonych kryteriów.</p>

            <p><em>Połącz notatki</em> znaczy, że notatki ze Źródła 2 będą dodane do notatek ze Źródła 1 we wszystkich polach. Jeśli ta możliwość nie
                zostanie wybrana,
                notatki dotyczące Źródła 2 zostaną utracone, ponieważ zostaną skasowane przez te, odpowiadające polu Źródła 1.</p>

            <p><em>Połącz media</em> znaczy, że media ze Źródła 2 będą dodane do mediów ze Źródła 1 we wszystkich polach. Jeśli ta możliwość nie
                zostanie wybrana,
                media dotyczące Źródła 2 zostaną utracone, ponieważ zostaną skasowane przez te, odpowiadające polu Źródła 1.</p>

            <p><h5 class="optionhead">Ostrzeżenie!</h5> Raz wykonane scalanie nie może zostać cofnięte! Proszę rozważyć wykonanie kopii zapasowej
            tabel bazy danych zanim dokonasz operacji scalania na wypadek,
            gdybyś scalił niechcąco niewłaściwe osoby.</p>

            <h5 class="optionhead">Następna zgodność</h5>
            <p>Znajdź następną możliwą zgodność, która nie wymaga podania Źródła 1. TNG zmienia listę możliwych źródeł w przyporządkowany ID źródła
                ciąg znaków. To znaczy, że "10" następuje po "1" ale przed "2".</p>

            <h5 class="optionhead">Następny duplikat</h5>
            <p>Znajdź następny możliwy duplikat dla Źródła 1. Jeśli ta operacja zakończy się brakiem zapisu dla Źródła 2, znaczy, że duplikat nie
                został znaleziony.</p>

            <h5 class="optionhead">Porównaj / odśwież.</h5>
            <p>Porównanie źródeł 1 i 2. Jeśli to porównanie jest już widoczne, kliknięcie na ten przycisk spowoduje odświeżenie strony.</p>

            <h5 class="optionhead">Przełącz</h5>
            <p>Zamiana - Źródło 1 staje się Źródłem 2 i vice versa.</p>

            <h5 class="optionhead">Scalanie</h5>
            <p>Źródło 2 jest scalane ze Źródłem 1. ID Źródła 1 oraz jego wszystkie inne dane zostaną zachowane, chyba, że dla Źródła 2 zostało
                zaznaczone odpowiednie pole(a).
                Na przykład, jeśli zaznaczyłeś pole autor dla Źródła 2, dane w tym polu będą podczas scalania skopiowane ze Źródła 2 do Źródła 1.
                Odpowiadające im dane Źródła 1 zostaną wtedy usunięte.
                Pola dla Źródła 2 są znaczone automatycznie, jeśli żadne odpowiadające im dane nie istnieją dla Źródła 1. Jeśli pole danych dla Źródła
                1 lub 2 jest puste, znaczy, że nie istnieją żadne
                dane dla któregokolwiek źródła.</p>

            <h5 class="optionhead">Edycja</h5>
            <p>Edytuj indywidualny zapis dla tego źródła w nowym oknie. Jeśli dokonałeś zmian, musisz kliknąć Porównaj / odśwież by zobaczyć zmiany w
                widoku scalania.</p>
            <li><p>Uwagi dotyczące polskiego tłumaczenia: <a href="mailto:januszkielak@gmail.com">januszkielak@gmail.com</a>. Prosimy zgłaszać
                    ewentualne błędy lub niejasności.</p></li>

        </td>
    </tr>

</table>
</body>
</html>

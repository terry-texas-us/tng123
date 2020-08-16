<?php
include("../../helplib.php");
echo help_header("Pomoc: Osoby");
?>

<body class="helpbody">
<a name="top"></a>
<table width="100%" border="0" cellpadding="10" cellspacing="2" class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right" class="smaller menu">
                <a href="http://tngforum.us" target="_blank" class="lightlink">TNG Forum</a> &nbsp; | &nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br/>
                <a href="index_help.php" class="lightlink">&laquo; Pomoc: Pierwsze kroki</a> &nbsp; | &nbsp;
                <a href="families_help.php" class="lightlink">Pomoc: Rodziny &raquo;</a>
            </p>
            <span class="largeheader">Pomoc: Osoby</span>
            <p class="smaller menu">
                <a href="#search" class="lightlink">Szukaj</a> &nbsp; | &nbsp;
                <a href="#add" class="lightlink">Dodaj nowe</a> &nbsp; | &nbsp;
                <a href="#edit" class="lightlink">Edycja</a> &nbsp; | &nbsp;
                <a href="#delete" class="lightlink">Usuń</a> &nbsp; | &nbsp;
                <a href="#review" class="lightlink">Przegląd zmian</a> &nbsp; | &nbsp;
                <a href="#merge" class="lightlink">Scalanie</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a name="search"><p class="subheadbold">Szukanie</p></a>
            <p>Znajdź istniejące osoby wpisując <strong>nazwisko</strong> albo <strong>numer ID</strong> lub ich część. Wybierz drzewo oraz / lub jedną z dostępnych opcji w celu dalszego zawężenia kryteriów wyszukiwania.
                Jeśli nie wybierzesz żadnej z proponowanych opcji, w polu wyszukiwania wyświetlą się wszystkie osoby zapisane w bazie danych.</p>

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
            <a name="add"><p class="subheadbold">Dodawanie nowej osoby</p></a>
            <p>Aby dodać nową osobę, kliknij na <strong>Dodaj nowe</strong>, a następnie wypełnij formularz. Niektóre informacje (notatki, cytaty, związki i dodatkowe wydarzenia)
                mogą być dodane dopiero po kliknięciu na przycisk <strong>Zapisz i kontynuuj</strong>. Do dyspozycji są następujące pola:</p>

            <span class="optionhead">Drzewo</span>
            <p>Jeśli masz tylko jedno drzewo, zostanie ono zaznaczone automatycznie. W innym przypadku, należy dla nowej osoby wybrać drzewo.</p>

            <span class="optionhead">Gałąź (opcjonalnie)</span>
            <p>Przypisanie "Gałęzi" do osoby ogranicza dostęp do jej danych do użytkowników którzy są przypisani do tej samej gałęzi. Jeśli co najmniej jedna gałąź została
                zdefiniowana i konto użytkownika nie jest przypisane do danej gałęzi, może on przypisać nową osobę do jednej lub większej liczby istniejących gałęzi. Aby wybrać
                "Gałęzie", kliknij na przycisk "Edycja" w celu otwarcia pola wyboru gałęzi wybranego drzewa. Użyj przycisku Ctrl (Windows) lub Command (Mac), aby wybrać więcej niż jedną gałąź.
                Po dokonaniu wyboru przenieś wskaźnik myszy na pole edycji, a pole wyboru zniknie.</p>

            <span class="optionhead">ID osoby</span>
            <p>ID osoby musi być unikalne w obrębie wybranego drzewa i powinno składać się z litery <strong>I</strong> oraz następujących po niej cyfr (nie więcej niż 21).
                Numer ID jest generowany automatycznie za każdym razem, gdy strona jest wyświetlana po raz pierwszy, ale można także w razie potrzeby wpisać własny ID.
                Aby sprawdzić, czy wpisany ID jest unikalny, kliknij przycisk <strong>Sprawdź</strong>. Pojawi się informacja mówiąca, czy wybrany ID jest dostępny.
                Aby wygenerować unikalny ID, kliknij przycisk <strong>Generuj</strong>. Będzie to najwyższa liczba zlokalizowana w bazie danych (najwyższe używane ID + 1).
                Aby zabezpieczyć wybrany ID przed zajęciem go przez innego użytkownika podczas wprowadzania danych, kliknij przycisk <strong>Zastosuj</strong>.</p>

            <p><strong>UWAGA</strong>: Jeśli korzystasz na Twoim komputerze z programu genealogicznego, który także tworzy numery ID dla nowych osób,
                jest WYSOCE ZALECANE zachowanie tych ID dla synchronizacji między dwoma programami. Brak tej synchronizacji może skutkować konfliktami, które mogą spowodować,
                że Twoje łącza do zdjęć, historii i nagrobków mogą stać się nie do użycia. Jeśli Twój program tworzy ID, nie dostosowane do tradycyjnych standardów
                (na przykład <strong>I</strong> jest na końcu, nie na początku), możesz zmodyfikować plik "prefixes.php" tak, aby przyjmował inne prefiksy.</p>

            <span class="optionhead">Imię i nzwisko</span>
            <p>Podaj dla osoby imię oraz / albo nazwisko. Jeśli zdecydowałeś, by poprzeć prefiksy (np. van, de itp.) i nazwiska jako rozłączną całość (będą one
                ignorowane podczas sortowania), podaj prefiks w polu nazwanym Prefiks do nazwiska.
                <strong>Uwaga:</strong> Jeśli to pole nie jest widoczne, przejdź do Ustawienia i konfiguracja / Ustawienia główne i ustaw odpowiednią opcję, aby można było użyć prefiksów nazwisk.</p>

            <span class="optionhead">Płeć / Przydomek / Tytuł / Prefix / Suffix / Kolejność nazwisko/imię</span>
            <p>Podaj tutaj jak najwięcej informacji o osobie. <strong>Pseudonim</strong> jest nieformalnym imieniem czasami łączonym z osobą.
                <strong>Tytuł</strong> jest używany przed imieniem lub nazwiskiem (np., <em>Hr.</em> albo <em>Prof.</em>) ale nie jest jego częścią. <strong>Prefix</strong> używany jest przed nazwiskiem i jest zwykle uważany za jego część.
                <strong>Suffix</strong> będzie się wyświetlał po przecinku za imieniem lub nawiskiem. <strong>Kolejność nazwisko/imię</strong> kolejność w jakiej powinny być wyświetlane.
                Kolejność nazwisko/imię możesz zmienić dla wszystkich osób w bazie danych pod Ustawienia i konfiguracja / Ustawienia główne.</p>

            <span class="optionhead">Żyjący</span>
            <p>Zaznacz to pole, jeśli ta osoba żyje lub jeśli chcesz ograniczyć widok danych tej osoby (np. data urodzenia, zdjęcia) tylko do użytkowników, którzy są zalogowani z dostatecznymi uprawnieniami.</p>

            <span class="optionhead">Wydarzenia</span>
            <p>Wprowadź daty i miejsca dla wymienionych standardowych wydarzeń (jeśli je znasz).Jeśli nie znasz jakiejś daty, wpisz w odpowiednie pole literkę <strong>Y</strong> (wyświetli się "data nieznana").
                Jeśli pole przeznaczone dla daty pozostanie puste, użytkownicy z uprawnieniami <em>Zgoda na składanie komentarzy do podglądu administratora (tylko ludzie, rodziny i źródła)</em> nie będą mogli składać propozycji zmian dot. daty.
                Dodatkowe wydarzenia mogą zostać dodane po zapisaniu lub kliknięciu przycisku "zastosuj". Daty należy zawsze podawać w standardowym formacie genealogicznych, DD MMM YYYY (na przykład <em>18 Feb 2008</em>).
                Miesiąc należy zawsze wpisywać podając trzy pierwsze litery jego nazwy w języku angielskim (widoczny będzie jego odpowiednik w języku polskim).Oto angielskie odpowiedniki miesięcy: Jan, Feb, Mar, Apr, May, Jun, Jul, Aug, Sep, Oct, Nov, Dec.
                Informacje na temat miejsca powinny być rozdzielane przecinkami ( na przykład, <em>Boston, Suffolk, Massachusetts, USA</em>). Możesz również wybrać istniejącą nazwę miejsca przez kliknięcie ikonki "Znajdź" (lupa).
                Aby ograniczyć ilość wyświetleń, podaj przed kliknięciem część nazwy miejsca. Wyświetlą się wszystkie miejsca zawierające w nazwie podane hasło.</p>

            <p><span class="optionhead">Dane LDS (Baptism, Endowment) Może być niewidoczne!</span><br/>
                Te zdarzenia są związane z nakazami praktykowanymi przez Mormonów w Kościele Jezusa Chrystusa Świętych w Dniach Ostatnich (kościół LDS wymyślił standard GEDCOM).
                <strong>Uwaga:</strong> Jeśli nie chcesz, aby dane LDS były widoczne, przejdź do <em>Ustawienia i konfiguracja/Ustawienia główne</em> i ustaw tam odpowiednią opcję (musisz się wylogować i ponownie zalogować).</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Wróć</a></p>
            <a name="edit"><p class="subheadbold">Edycja istniejących osób</p></a>
            <p>Aby wprowadzić zmiany dotyczące istniejącej osoby, należy kliknąć przycisk <a href="#search">Szukaj</a> w celu jej zlokalizowania, a następnie kliknąć na ikonkę "Edycja" obok wybranej osoby.</p>

            <span class="optionhead">Notatki / Cytaty / Związki / "Więcej"</span>
            <p>Notatki, cytaty i związki możesz łączyć z wydarzeniami lub osobami klikając na ikony łączy u góry strony lub obok każdego wydarzenia.
                "Więcej" informacji dla wydarzenia można dodać klikając na ikonkę "Plus ". Jeśli w którejś z kategorii istnieją już jakieś elementy,
                odpowiednie ikonki oznaczone są zielonymi kropkami w prawym górnym rogu. Aby uzyskać więcej informacji na temat każdej z kategorii, zobacz <em>Pomoc</em> w okienkach,
                które stają się widoczne, gdy ikona zostanie naciśnięta.</p>

            <span class="optionhead">Inne wydarzenia</span>
            <p>Aby dodać lub zarządzać dodatkowymi wydarzeniami, kliknij na przycisk "Dodaj nowe" obok <strong>Inne wydarzenia</strong>. Klikając <a href="events_help.php">Pomoc</a> znajdziesz więcej informacji na temat dodawania nowych wydarzeń.
                Gdy wydarzenie zostało dodane, pod polem "Dodaj nowe" pokaże się krótkie streszczenie. Przyciski w polu "Czynność" dla każdego wydarzenia pozwalają na edycję
                lub usunięcie wydarzenia, oraz dodawanie notatek lub cytatów. Kolejność, w której wydarzenia są wyświetlane jest ustalana wg daty (jeżeli dotyczy) i przez przypisany w "Rodzajach wydarzeń " priorytet
                (jeśli nie jest związane terminem). Priorytet ten może ulec zmianie podczas edycji rodzajów wydarzeń.


            <p><strong>Uwaga</strong>: Takie informacje o standardowych wydarzeniach jak uwagi, cytaty ze źródeł, związki, "inne" wydarzenia i "więcej" są zapisywane
                automatycznie. Inne zmiany (dotyczące np. nazwiska lub standardowego wydarzenia) można zapisać klikając przycisk "Zapisz" na dole strony,
                lub klikając na ikonkę "Zapisz" u góry strony. Drzewo oraz ID osoby nie mogą zostać zmienione.</p>

            <span class="optionhead">Rodzice</span>
            <p>Jeśli dana osoba ma rodziców, sekcja <strong>Rodzice</strong> będzie widoczna w sekcji Wydarzenia. Ta sekcja jest zamknięta i wskazuje w nawiasie liczbę (par) rodziców.
                Aby rozwinąć sekcję i wyświetlić wszystkich rodziców, kliknij na napis "Rodzice" lub strzałkę obok niego. Niektóre informacje, włączając w to wzajemny stosunek pomiędzy daną osobą i każdą parą rodziców,
                mogą być edytowane w każdym polu. Gdy zatrzymasz wskaźnik myszy nad sekcją rodziców, w prawym górnym rogu pola ukaże się opcja <strong>Usuń łącze</strong>
                Kliknij, aby usunąć łącze danej osoby z tą parą rodziców.</p>

            <span class="optionhead">Małżonkowie/partnerzy</span>
            <p>Jeśli dana osoba posiada co najmniej jednego współmałżonka lub partnera, sekcja <strong>Małżonkowie/partnerzy</strong> będzie widoczna w sekcji Rodzice. Ta sekcja jest zamknięta i wskazuje liczbę małżonków / partnerów w nawiasie.
                Aby rozwinąć sekcję i wyświetlić wszystkich małżonków lub partnerów, kliknij na napis "Małżonkowie / partnerzy" lub strzałkę obok niego. Gdy zatrzymasz wskaźnik myszy nad sekcją Małżonkowie / partnerzy, w prawym górnym rogu pola ukaże się
                opcja <strong>Usuń łącze</strong>.
                Kliknij, aby usunąć łącze danej osoby z jej współmałżonkiem lub partnerem.</p>

            <span class="optionhead">Sortowanie rodziców lub małżonów</span>
            <p>Jeżeli istnieje więcej niż jeden małżonek lub para rodziców, można zmienić kolejność przez "przeciąganie" bloków w górę i w dół. Aby to zrobić kliknij myszą na pole "Przeciągnij" i przytrzymaj
                przycisk, a następnie przesuń w górę lub w dół na stronie. Gdy blok znajdzie się w wybranym miejscu zwolnij przycisk myszy. Zmiany dokonane podczas sortowania są zapisywane automatycznie.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Wróć</a></p>
            <a name="delete"><p class="subheadbold">Usuwanie osób</p></a>
            <p>Aby usunąć jedną osobę, należy nacisnąć przycisk <a href="#search">Szukaj</a> w celu jej zlokalizowania, a następnie kliknąć na ikonkę Usuń obok tej osoby. Wiersz zmieni kolor,
                a następnie zniknie. Osoba została usunięta. Aby usunąć więcej niż jedną osobę naraz, zaznacz pole w kolumnie Wybierz obok każdej osoby, która
                ma zostać usunięta, a następnie kliknąć przycisk "Usuń wybrane" znajdujący się na górze strony.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Wróć</a></p>
            <a name="review"><p class="subheadbold">Przegląd zmian</p></a>
            <p>Aby sprawdzić propozycje zmian dokonane przez innych użytkowników, kliknij na przycisk "Przegląd zmian". Jeśli są tam jakieś wpisy, w polu "Propozycje zmian" pojawi się gwiazdka (*).
                Możesz zadecydować o tym, czy przyjąć czy też usunąć proponowane zmiany. W celu przeglądania możesz wybrać pole drzewa, użytkownika lub oba.</p>

            <span class="optionhead">Wybierz wydarzenie i czynność</span><br/>
            <p>Zlokalizuj wiersz w tabeli, która opisuje zdarzenie, które chcesz obejrzeć usunąć. Listę wyników możesz zawęzić przez wybranie użytkownika (osoby odpowiedzialnej za
                proponowaną zmianę) oraz / lub drzewa. Kiedy wyniki zostaną wyświetlone, kliknij na jedną z opcji widocznych z lewej strony wiersza.
                Aby sprawdzić i ewentualnie nanieść zmiany wybierz <em>Przegląd zmian</em>. Aby odrzucić proponowane zmiany, wybierz <em>Usuń</em>.</p>

            <span class="optionhead">Przegląd zmian</span><br/>
            <p>Na tej karcie możesz dokonywać różnych dodatkowych zmian, w tym dotyczących notatek lub źródeł, a następnie kliknąć przycisk "Zapisz i Usuń",
                aby zapisać zmiany i usunąć wpis. Można również zdecydować się na usunięcie propozycji klikając przycisk "Ignoruj i Usuń",
                lub odłożyć decyzję na później klikając przycisk "Odłóż".</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Wróć</a></p>
            <a name="merge"><p class="subheadbold">Scalanie osób</p></a>
            Aby znaleźć i scalić dwa powtarzające się zapisy, kliknij na przycisk "Scalanie". Użytkownik decyduje, czy dwa zapisy są identyczne, czy też nie.</p>

            <span class="optionhead">Szukaj zgodności</span><br/>
            <p>Po pierwsze, wybierz drzewo. Nie możesz połączyć osób z różnych drzew, tak więc tylko jedno drzewo może zostać wybrane. Dalej, masz możliwość wybrać osobę jako punkt wyjściowy
                dla Twojego szukania (Osoba 1), albo zezwolić TNG na szukanie pierwszej zgodności za Ciebie. Jeśli zdecydowałeś, że TNG wyszukuje zgodności, pozostaw pole ID Osoby 1 puste.</p>
            <p>Jeśli wybrałeś osobę jako Osoba 1, możesz też wybrać ręcznie ID Osoby 2. Wskazane jest jednak, aby pozwolić TNG na szukanie duplikatów dla Osoby 1, pozostawiając pole ID Osoby 2 puste.</p>

            <span class="optionhead">Zgodność następujących pozycji</span><br/>
            <p>Te kryteria TNG służą do określania możliwych zgodności. Imię i nazwisko są wybrane jako domyślne. To oznacza, że te pola muszą zgadzać się w obydwóch zapisach, aby zostały wzięte pod uwagę
                jako możliwe zgodności. Jeśli wybierzesz też datę urodzenia, miejsce urodzenia, datę oraz / lub miejsce zgonu, to te pola muszą się też zgadzać.</p>

            <span class="optionhead">Inne opcje</span><br/>
            <p><em>Ignoruj puste pola</em> znaczy, że puste pola nie będą brane pod uwagę. Na przykład, ktoś z nazwiskiem ale bez imienia nie zostanie uwzględniony, jeśli imię będzie wśród zaznaczonych kryteriów.</p>

            <p><em>Użyj Soundex</em> znaczy, że funkcja Soundex MySQL będzie użyta do porównania imion. W tym przypadku, "Blakely" mógłby zostać uznany jako zgodność dla "Blackley".</p>

            <p><em>Wspólne notatki &amp; cytaty</em> znaczy, że notatki i cytaty Osoby 2 będą dodane do notatek i cytatów Osoby 1 we wszystkich polach. Jeśli ta możliwość nie zostanie wybrana,
                notatki i cytaty dotyczące Osoby 2 zostaną utracone, ponieważ zostaną skasowane przez te, odpowiadające polu Osoby 1.</p>

            <p><em>Połącz media</em> znaczy, że media dotyczące Osoby 2 będą dodane do mediów Osoby 1 we wszystkich polach. Jeśli ta możliwość nie zostanie wybrana, media dotyczące Osoby 2
                zostaną utracone, ponieważ zostaną skasowane przez te, odpowiadające polu Osoby 1.</p>

            <p><span class="optionhead">Ostrzeżenie!</span> Raz wykonane scalanie nie może zostać cofnięte! Proszę rozważyć wykonanie kopii zapasowej tabel bazy danych zanim dokonasz operacji scalania na wypadek,
                gdybyś scalił niechcący niewłaściwe osoby.</p>

            <span class="optionhead">Następna zgodność</span><br/>
            <p>Znajdź następną możliwą zgodność, która nie wymaga podania Osoby 1. TNG zmienia listę możliwych osób w przyporządkowany ID osoby ciąg znaków. To znaczy, że "10" następuje po "1" ale przed "2".</p>

            <span class="optionhead">Następny duplikat</span><br/>
            <p>Znajdź następny możliwy duplikat dla Osoby 1. Jeśli ta operacja zakończy się brakiem zapisu dla Osoby 2, znaczy, że duplikat nie został znaleziony.</p>

            <span class="optionhead">Porównaj / odśwież.</span><br/>
            <p>Porównanie osób 1 i 2. Jeśli to porównanie jest już widoczne, kliknięcie na ten przycisk spowoduje odświeżenie strony.</p>

            <span class="optionhead">Przełącz</span><br/>
            <p>Zamiana - Osoba 1 staje się Osobą 2 i vice versa.</p>

            <span class="optionhead">Scalanie</span><br/>
            <p>Osoba 2 jest scalana z osobą 1. ID Osoby 1 oraz jej wszystkie inne dane zostaną zachowane, chyba, że dla Osoby 2 zostało zaznaczone odpowiednie pole(a).
                Na przykład, jeśli zaznaczyłeś pole obok daty urodzenia Osoby 2, dane w tym polu będą podczas scalania skopiowane od Osoby 2 do Osoby 1. Odpowiadające im dane Osoby 1 zostaną wtedy usunięte.
                Pola dla Osoby 2 są znaczone automatycznie, jeśli żadne odpowiadające im dane nie istnieją dla Osoby 1. Jeśli pole danych dla Osoby 1 lub 2 jest puste, znaczy, że nie istnieją żadne dane dla którejkolwiek osoby.</p>

            <span class="optionhead">Edycja</span><br/>
            <p>Edytuj indywidualny zapis dla tej osoby w nowym oknie. Jeśli dokonałeś zmian, musisz kliknąć Porównaj / odśwież by zobaczyć zmiany w widoku scalania.</p>
            <li><p>Uwagi dotyczące polskiego tłumaczenia: <a href="mailto:januszkielak@gmail.com">januszkielak@gmail.com</a>. Prosimy zgłaszać ewentualne błędy lub niejasności.</p></li>
        </td>
    </tr>

</table>
</body>
</html>

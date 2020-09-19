<?php
include "../../helplib.php";
echo help_header("Pomoc: Rodziny");
?>

<body class="helpbody">
<a id="top"></a>
<table width="100%" cellpadding="10" cellspacing="2" class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tngforum.us" target="_blank" class="lightlink">TNG Forum</a> &nbsp; | &nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="people_help.php" class="lightlink">&laquo; Pomoc: Osoby</a> &nbsp; | &nbsp;
                <a href="sources_help.php" class="lightlink">Pomoc: Źródła &raquo;</a>
            </p>
            <h2 class="largeheader">Pomoc: <small>Rodziny</small></h2>
            <p class="smaller menu">
                <a href="#search" class="lightlink">Szukaj</a> &nbsp; | &nbsp;
                <a href="#add" class="lightlink">Dodaj nowe</a> &nbsp; | &nbsp;
                <a href="#edit" class="lightlink">Edytuj istniejące</a> &nbsp; | &nbsp;
                <a href="#delete" class="lightlink">Usuń</a> &nbsp; | &nbsp;
                <a href="#review" class="lightlink">Przegląd zmian</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="search"><p class="subheadbold">Szukanie</p></a>
            <p>Znajdź istniejące rodziny wpisując <strong>ID rodziny</strong>, <strong>Imię męża</strong> lub <strong>Imię żony</strong> albo ich
                część.
                Wybierz drzewo lub zaznacz "Tylko dokładna nazwa" do dalszego zawężenia kryteriów wyszukiwania. Jeśli wybierzesz "Imię męża", będą
                wyszukiwani wszyscy żonaci mężczyźni z Twojej bazy danych.
                Jeśli wybierzesz "Imię żony", będą wyszukiwane wszystkie zamężne kobiety z Twojej bazy danych. Wybierz "Bez imienia" w celu
                wyszukiwania ID rodzin.</p>

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
            <a id="add"><p class="subheadbold">Dodawanie nowych rodzin</p></a>
            <p><strong>Rodzina</strong> Rodzina jest potrzebna dla każdego związku między "Ojcem" i "Matką" (dzieci mogą ale nie muszą zostać dodane).
                Jeżeli dana osoba jest zamężna/żonata
                i ma dzieci z wieloma partnerami, należy utworzyć nową rodzinę dla każdej pary małżonków lub partnerów.</p>

            <p>Aby dodać nową rodzinę, kliknij na <strong>Dodaj nowe</strong>, a następnie wypełnić formularz. Niektóre informacje (notatki, cytaty,
                związki i dodatkowe wydarzenia)
                mogą być dodane dopiero po kliknięciu na przycisk <strong>Zapisz i kontynuuj</strong>. Do dyspozycji są następujące pola:</p>

            <span class="optionhead">Drzewo</span>
            <p>Jeśli masz tylko jedno drzewo, zostanie ono zaznaczone automatycznie. W innym przypadku, należy wybrać drzewo na nowej rodziny.</p>

            <span class="optionhead">Gałąź (opcjonalne)</span><br>
          <p>Przypisanie "Gałęzi" do rodziny ogranicza dostęp do danych rodzinnych do użytkowników którzy są przypisani do tej samej gałęzi. Jeśli co najmniej jedna gałąź została
            zdefiniowana i konto użytkownika nie jest przypisane do danej gałęzi, może on przypisać nową rodzinę do jednej lub większej liczby istniejących gałęzi. Aby wybrać
            "Gałęzie", kliknij na przycisk "Edycja" w celu otwarcia pola wyboru gałęzi wybranego drzewa. Użyj przycisku Ctrl (Windows) lub Command (Mac), aby wybrać więcej niż jedną gałąź.
            Po dokonaniu wyboru przenieś wskaźnik myszy na pole edycji, a pole wyboru zniknie.</p>

          <p><span class="optionhead">ID rodziny</span><br>
            ID rodziny musi być unikalne w obrębie wybranego drzewa i powinno składać się z litery <strong>F</strong> oraz następujących po niej cyfr (nie więcej niż 21).
            Numer ID jest generowany automatycznie za każdym razem, gdy strona jest wyświetlana po raz pierwszy, ale można także w razie potrzeby wpisać własny ID.
            Aby sprawdzić, czy wpisany ID jest unikalny, kliknij przycisk <strong>Sprawdź</strong>. Pojawi się informacja mówiąca, czy wybrany ID jest dostępny.
            Aby wygenerować unikalny ID, kliknij przycisk <strong>Generuj</strong>. Będzie to najwyższa liczba zlokalizowana w bazie danych (najwyższe używane ID + 1).
            Aby zabezpieczyć wybrany ID przed zajęciem go przez innego użytkownika podczas wprowadzania danych, kliknij przycisk <strong>Zastosuj</strong>.</p>

          <p><strong>UWAGA</strong>: Jeśli korzystasz na Twoim komputerze z programu genealogicznego, który także tworzy numery ID dla nowych rodzin,
            jest WYSOCE ZALECANE zachowanie tych ID dla synchronizacji między dwoma programami. Brak tej synchronizacji może skutkować konfliktami, które mogą spowodować,
            że Twoje łącza do zdjęć, historii i nagrobków mogą stać się nie do użycia. Jeśli Twój program tworzy ID, nie dostosowane do tradycyjnych standardów
            (na przykład <strong>I</strong> jest na końcu, nie na początku), możesz zmodyfikować plik "prefixes.php" tak, aby przyjmował inne prefiksy.</p>

            <span class="optionhead">Małżonkowie/partnerzy</span>
            <p>Wybierz istniejące osoby, które mają być <strong>ojcem</strong> lub <strong>matką</strong> w rodzinie klikając przycisk "Znajdź ...", lub twórz nowe klikając" Twórz ".
                Jeśli wybierzesz tworzenie, informacje o nowej osobie będą mogły zostać wprowadzone bez opuszczania tej strony. Po utworzeniu nowej osoby jej nazwisko,
                imię (imiona) oraz numer ID pojawią się w polu ojca lub matki (nie można edytować bezpośrednio). Aby usunąć małżonków ze związku
                (nie usuwając z bazy danych), kliknij przycisk "Usuń". Aby edytować małżonka, kliknij przycisk "Edycja".</p>

            <span class="optionhead">Żyjący</span>
          <p>Zaznacz to pole, jeśli jeden z małżonkó żyje lub jeśli chcesz ograniczyć widok danych tej rodziny (np. daty urodzenia, ślubu, zdjęcia) tylko do użytkowników, którzy są zalogowani z dostatecznymi uprawnieniami.</p>

          <span class="optionhead">Wydarzenia</span>
          <p>Wprowadź daty i miejsca dla wymienionych standardowych wydarzeń (jeśli je znasz).Jeśli nie znasz jakiejś daty, wpisz w odpowiednie pole literkę <strong>Y</strong> (wyświetli się "data nieznana").
            Jeśli pole przeznaczone dla daty pozostanie puste, użytkownicy z uprawnieniami <em>Zgoda na składanie komentarzy do podglądu administratora (tylko ludzie, rodziny i źródła)</em> nie będą mogli składać propozycji zmian dot. daty.
            Dodatkowe wydarzenia mogą zostać dodane po zapisaniu lub kliknięciu przycisku "zastosuj". Daty należy zawsze podawać w standardowym formacie genealogicznych, DD MMM YYYY (na przykład <em>18 Feb 2008</em>).
            Miesiąc należy zawsze wpisywać podając trzy pierwsze litery jego nazwy w języku angielskim (widoczny będzie jego odpowiednik w języku polskim).Oto angielskie odpowiedniki miesięcy: Jan, Feb, Mar, Apr, May, Jun, Jul, Aug, Sep, Oct, Nov, Dec.
            Informacje na temat miejsca powinny być rozdzielane przecinkami ( na przykład, <em>Boston, Suffolk, Massachusetts, USA</em>). Możesz również wybrać istniejącą nazwę miejsca przez kliknięcie ikonki "Znajdź" (lupa).
            Aby ograniczyć ilość wyświetleń, podaj przed kliknięciem część nazwy miejsca. Wyświetlą się wszystkie miejsca zawierające w nazwie podane hasło.</p>

            <p><span class="optionhead">Dane LDS (Baptism, Endowment) Może być niewidoczne!</span><br>
                Te zdarzenia są związane z nakazami praktykowanymi przez Mormonów w Kościele Jezusa Chrystusa Świętych w Dniach Ostatnich (kościół LDS
                wymyślił standard GEDCOM).
                <strong>Uwaga:</strong> Jeśli nie chcesz, aby dane LDS były widoczne, przejdź do <em>Ustawienia i konfiguracja/Ustawienia główne</em>
                i ustaw tam odpowiednią opcję (musisz się wylogować i ponownie zalogować).</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Wróć</a></p>
            <a id="edit"><p class="subheadbold">Edycja istniejących rodzin</p></a>
            <p>Aby wprowadzić zmiany dotyczące istniejącej rodziny, należy kliknąć przycisk <a href="#search">Szukaj</a> w celu jej zlokalizowania, a
                następnie kliknąć na ikonkę "Edycja" obok wybranej rodziny.</p>

            <span class="optionhead">Notatki / Cytaty / "Więcej"</span>
            <p>Notatki, cytaty i związki możesz łączyć z wydarzeniami lub rodzinami klikając na ikony łączy u góry strony lub obok każdego wydarzenia.
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


      <p><strong>Uwaga</strong>: Takie informacje o standardowych wydarzeniach jak uwagi, cytaty ze źródeł, związki, "inne" wydarzenia i "więcej" są zapisywane
        automatycznie. Inne zmiany (dotyczące np. nazwiska lub standardowego wydarzenia) można zapisać klikając przycisk "Zapisz" na dole strony,
        lub klikając na ikonkę "Zapisz" u góry strony. Drzewo oraz ID osoby nie mogą zostać zmienione.</p>

      <p><span class="optionhead">Dzieci</span><br>
        Wybierz istniejące osoby, które mają być dziećmi w tej rodzinie klikając przycisk "Znajdź...", lub utwórz nowe, klikając "Twórz...".
        Jeśli wybierzesz tworzenie, informacje o nowej osobie będą mogły zostać wprowadzone bez opuszczania tej strony. Po utworzeniu nowej osoby
        jej nazwisko, imię (imiona) oraz numer ID pojawią się w polu dzieci. Ta lista nie może być edytowana bezpośrednio, ale możesz użyć przycisku "Usuń"
        (widoczne, gdy umieścisz wskaźnik myszy nad dowolnym dzieckiem), aby usunąć dziecko z listy. Można także użyć przycisku "Usuń" w rubryce czynność.
        Użyj przycisku "Usuń", aby usunąć dziecko z bazy danych, lub "Edycja", aby edytować indywidualny zapis.</p>

            <span class="optionhead">Sortowanie rodziców lub małżonów</span>
            <p>Jeżeli istnieje więcej niż jeden małżonek lub para rodziców, można zmienić kolejność przez "przeciąganie" bloków w górę i w dół. Aby to
                zrobić kliknij myszą na pole "Przeciągnij" i przytrzymaj
                przycisk, a następnie przesuń w górę lub w dół na stronie. Gdy blok znajdzie się w wybranym miejscu zwolnij przycisk myszy. Zmiany
                dokonane podczas sortowania są zapisywane automatycznie.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Wróć</a></p>
            <a id="delete"><p class="subheadbold">Usuwanie rodzin</p></a>
            <p>Aby usunąć jedną rodzinę, należy nacisnąć przycisk <a href="#search">Szukaj</a> w celu jej zlokalizowania, a następnie kliknąć na
                ikonkę Usuń obok tej rodziny. Wiersz zmieni kolor,
                a następnie zniknie. (małżonkowie i dzieci nie zostaną usunięci z bazy danych, ale małżeństwo zostanie rozwiązane). Aby usunąć więcej
                niż jedną rodzinę naraz,
                zaznacz pole w kolumnie Wybierz obok każdej rodziny, która ma zostać usunięta, a następnie kliknąć przycisk "Usuń wybrane" znajdujący
                się na górze strony.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Wróć</a></p>
            <a id="review"><p class="subheadbold">Przegląd zmian</p></a>
            <p>Aby sprawdzić propozycje zmian dokonane przez innych użytkowników, kliknij na przycisk "Przegląd zmian". Jeśli są tam jakieś wpisy, w
                polu "Propozycje zmian" pojawi się gwiazdka (*).
                Możesz zadecydować o tym, czy przyjąć czy też usunąć proponowane zmiany. W celu przeglądania możesz wybrać pole drzewa, użytkownika
                lub oba.</p>

            <span class="optionhead">Wybierz wydarzenie i czynność</span><br>
            <p>Zlokalizuj wiersz w tabeli, która opisuje zdarzenie, które chcesz obejrzeć usunąć. Listę wyników możesz zawęzić przez wybranie
                użytkownika (osoby odpowiedzialnej za
                proponowaną zmianę) oraz / lub drzewa. Kiedy wyniki zostaną wyświetlone, kliknij na jedną z opcji widocznych z lewej strony wiersza.
                Aby sprawdzić i ewentualnie nanieść zmiany wybierz <em>Przegląd zmian</em>. Aby odrzucić proponowane zmiany, wybierz <em>Usuń</em>.
            </p>

            <span class="optionhead">Przegląd zmian</span><br>
            <p>Na tej karcie możesz dokonywać różnych dodatkowych zmian, w tym dotyczących notatek lub źródeł, a następnie kliknąć przycisk "Zapisz i
                Usuń",
        aby zapisać zmiany i usunąć wpis. Można również zdecydować się na usunięcie propozycji klikając przycisk "Ignoruj i Usuń",
        lub odłożyć decyzję na później klikając przycisk "Odłóż".</p>
      <li><p>Uwagi dotyczące polskiego tłumaczenia: <a href="mailto:januszkielak@gmail.com">januszkielak@gmail.com</a>. Prosimy zgłaszać ewentualne błędy lub niejasności.</p></li>

    </td>
  </tr>

</table>
</body>
</html>

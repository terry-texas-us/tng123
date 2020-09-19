<?php
include "../../helplib.php";
echo help_header("Pomoc: Mapy Google");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tngforum.us" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="places_help.php" class="lightlink">&laquo; Pomoc: Miejsca</a> &nbsp;|&nbsp;
                <a href="tlevents_help.php" class="lightlink">Pomoc: Linia czasu wydarzeń &raquo;</a>
            </p>
            <h2 class="largeheader">Pomoc: <small>Mapy Google</small></h2>
            <p class="smaller menu" style="clear: both;">
                <a href="#show" class="lightlink">Search</a> &nbsp;|&nbsp;
                <a href="#search" class="lightlink">Search</a> &nbsp;|&nbsp;
                <a href="#controls" class="lightlink">Map Controls</a> &nbsp;|&nbsp;
                <a href="#help" class="lightlink">Pomoc</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">
            <p><span class="subheadbold">Pokaż/ukryj mapę Google</span><br><br>
                Kliknij przycisk "Pokaż /ukryj mapę Google", aby pokazać mapę Google i szukać szerokości i długości geograficznej lokalizacji oraz
                zoomu, lub ukryć mapę po
                zakończeniu. Domyślnie jest ustawienie początkowe określone w Administrator /Ustawienia i konfiguracja / Ustawienia mapy.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="show"><h4 class="subheadbold">Szukanie</h4></a>
            <p>Interfejs Google Map Geocoder pozwala na zlokalizowanie szerokości i długości geograficznej miejsca za pomocą wywołania poprzez
                kliknięcie w wybrany punkt.
                Możesz również skorzystać z StreetMap (<a href="http://www.streetmap.co.uk" target="_blank">http://www.streetmap.co.uk</a>) aby
                odnaleźć współrzędne w Anglii, lub z Mapy Szukacza (<a href="http://mapa.szukacz.pl" target="_blank">http://mapa.szukacz.pl</a>)
                w Polsce.</p>

            <h5 class="optionhead">Określenie miejsca Geocode</h5>
            <p>Karta dotycząca współrzędnych geograficznych miejsca TNG zawiera nazwę miejsca, jeśli jest ono już zdefiniowane w TNG. Podczas
                dodawania nowej lokalizacji, współrzędne geograficzne będą dodawane do
                każdego miejsca noszącego tę samą nazwę. Podczas dodawania lub cmentarzy mediów będą dotyczyły jednak wyłącznie jednej
                lokalizacji.</p>
            <p>Być może trzeba będzie dla istniejących nazw miejsc w TNG zmienić je w polu "Określenie miejsca Geocode" . Na przykład Google nie lubi
                <em>powiatu (County)</em> jako części nazwy miejsca dla lokalizacji w USA i Szkocji ani nie radzi sobie z
                prowincjami Nowej Zelandii.
                Być może warto spróbować podać dodatkowo nazwę kraju. Można także wpisać nazwę kraju w języku Angielskim.</p>
            <h5 class="optionhead">Przykłady nazw miejsc</h5>
            <p>Oto przykłady, jak powinny być wpisanie nazwy miejsca w celu uzyskania prawidłowych współrzędnych:</p>
            <ul>
                <li>Śląska 12, 66400 Gorzów Wielkopolski, Polska</li>
                <li>1102 Shipwatch Circle, Tampa, Florida</li>
                <li>Klippan 1, 41451 Sweden</li>
                <li>Avenida de Velasquez 126, Malaga</li>
                <li>49 Rue de Tournai, Lille, France</li>
                <li>Ocean Drive, Twin Waters, Queensland, Australia</li>
                <li>Rue de la Wastinne 45, 1301 Wavre, Belgium</li>
                <li>Via Villanova 31, 40050 Bologna villanova, Italy</li>
                <li>Europaboulevard 10, Amsterdam</li>
                <li>Lise-Meitner-Strasse 2, 60486 Frankfurt, Germany</li>
            </ul>

            <p>Mapy niektórych krajów są niedostępne dla geocodera powodu nacjonalistycznych praw autorskich i licencji. Dla tych krajów, będziesz
                musiał użyć linku <a href="http://maps.google.com/" target="_blank">Full Google Map Search</a>.</p>

            <h5 class="optionhead">Szerokość i długość geograficzna</h5>
            <p>Musisz być bardzo ostrożny z przyjęciem szerokości i długości geograficznej, które są oferowane z mapki. Należy przynajmniej trochę
                znać lokalizację miejsca i to,
                czego oczekuje przed zaakceptowaniem tego, co jest proponowane na mapce. Jeżeli "szpilka" na mapie nie znajduje się w oczekiwanej
                lokalizacji, proponowana
                szerokość i długość mogą być niepoprawne. W takim przypadku, należy kliknąć na żądany punkt na mapie w celu ustalenia lepszej
                lokalizacji.</p>

            <p>Należy również sprawdzić przyjęte współrzędne za pomocą ikonki Test na liście miejsc, a następnie kliknąć na "szpilkę" przy wydarzeniu
                w celu otwarcia mapy
                zewnętrznej, aby zweryfikować to położenie.</p>

            <h5 class="optionhead">Zoom</h5>
            <p>Jeśli lokalizacja na mapie nie jest odpowiednio powiększona, możesz użyć opcji kontroli zoomu opisanych poniżej w celu go dostosowania
                do potrzeb. Może to być
                szczególnie potrzebne w celu wyeliminowania komunikatu błędu informującego, że Google nie jest w stanie powiększyć mapy żądanego
                poziomu.
                Ustawione wartości powiększenia będą zapisywane w bazie danych TNG.</p>

            <h5 class="optionhead">Poziom miejsca</h5>
            <p>Możesz skorzystać z rozwijanej listy poziomów miejsc , aby wybrać odpowiedni poziom nazwy miejsca. Do dyspozycji jest sześć poziomów
                począwszy od adresu do kraju. Adres jest najbardziej specyficzny.
                Można określić w Twoim pliku cust_text.php zastępcze preferencje do $admtext dla poziomów od 1 do 6 zawartych w pliku alltext.php.
                Poziomy etykietek od 2 do 5 mogą być zmienione w celu odzwierciedlenia na
                przykład kościółów / szpitali / domów opieki / cmentarzy, miejscowości/ miast / gmin, powiatów / wydziałów, stanów / województw /
                regionów. Różne kolorowe szpilki będą wskazywać różne skale poziomów
                miejsc na karcie osoby. Wskaźnika poziomu nie stosuje się do kart cmentarzy, ani mediów. Szpilki wyświetlane na cmentarzach są
                ustawione domyślnie do poziomu 2 w celu uwidocznienia nagrobków na najbardziej szczegółowym poziomie.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="controls"><h4 class="subheadbold">Sterowanie mapą Google</h4></a>

            <h5 class="optionhead">Punkt / Kliknięcie</h5>
            <p>Aby precyzyjnie ustawić szerokość i długość geograficzną, kliknij na mapę Google w wybranym przez Ciebie miejscu. Być może trzeba
                będzie skorzystać z przycisków Mapa, Satelita lub Hybrydowa
                aby łatwiej było ustalić współrzędne miejsca.</p>

            <h5 class="optionhead">Przesuwanie mapy</h5>
            <p>Aby zobaczy obszar mapy znajdujący się poza obszarem ekranu możesz ją przesuwać używając myszy lub strzałek kierunkowych w lewo, prawo,
                w górę i w dół.
                The drag and pan capability means there is no clicking and waiting for graphics to reload each time you want to view the adjacent
                parts of a map.</p>

            <h5 class="optionhead">Zoom</h5>
            <p>Można użyć plus znaków (+) i minus (-) lub suwaka, aby powiększyć lub zmniejszyć mapę. Być może trzeba będzie użyć strzałek do zmiany
                pozycji mapy przy powiększaniu.
                Jeśli dokonasz zmiany poziomu powiększenia, wartości zoom zostaną zapisane w tabeli TNG.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="help"><h4 class="subheadbold">Pomoc Google Map</h4></a>

            <p>Tutaj możesz uzyskać dodatkową pomoc: <a href="http://www.google.com/apis/maps/documentation/" target="_blank">Google Maps API</a>.</p>
            <p>Możesz również skorzystać z tej: <a href="http://www.google.com/intl/en_us/help/maps/tour/" target="_blank">Google Maps tour</a>.</p>
            <li><p>Uwagi dotyczące polskiego tłumaczenia: <a href="mailto:januszkielak@gmail.com">januszkielak@gmail.com</a>. Prosimy zgłaszać
                    ewentualne błędy lub niejasności.</p></li>

        </td>
    </tr>

</table>
</body>
</html>

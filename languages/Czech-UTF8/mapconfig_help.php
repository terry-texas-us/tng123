<?php
include "../../helplib.php";
echo help_header("Nápověda: Nastavení mapy");
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp; | &nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="importconfig_help.php" class="lightlink">&laquo; Nápověda: Nastavení importu dat</a> &nbsp; | &nbsp;
                <a href="templateconfig_help.php" class="lightlink">Nápověda: Nastavení šablony &raquo;</a>
            </p>
            <h2 class="largeheader">Nápověda: <small>Nastavení mapy</small></h2>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow"><span class="normal">

		<h5 class="optionhead">Klíč k mapě</h5>
		<p>Pro použití map z Google Maps na vašich internetových stránkách musíte od června 2016 získat od Google tzv. <strong>klíč</strong> k mapě. Tento klíč můžete obdržet zde:<br>
		<a href="https://developers.google.com/maps/documentation/javascript/get-api-key#key" target="_blank">https://developers.google.com/maps/documentation/javascript/get-api-key#key</a>. Některé klíčové body:</p>

		<ul>
		<li>Vytvořte API klíč pod položkou "APIs &amp; Services (Credentials)" a přidejte adresu svého webu jako "HTTP referrer".</li>
		<li>V nabídce "Mapy Google" povolte "Maps Javascript API".</li>
		</ul>    
    
		<p>Po získání vašeho klíče jej nakopírujte do pole <strong>Klíč k mapě</strong> na stránce Administrace > Nastavení > Nastavení map. Pokud se později rozhodnete, že mapy z Google Maps již používat nechcete,
		klíč z tohoto pole jednoduše odstraňte a mapy a pole s mapami spojená se vám již nebudou zobrazovat. Více informací o práci s Google Maps najdete na TNG Wiki: 
    <a href="http://tng.lythgoes.net/wiki/index.php/Google_Maps_-_Getting_Started" target="_blank">http://tng.lythgoes.net/wiki/index.php/Google_Maps_-_Getting_Started</a>.</p>

		<h5 class="optionhead">Umožnit mapy</h5>
		<p>Chcete-li na vašich stránkách tam, kde jsou souřadnice zeměpisné šířky a délky, zobrazit Google Maps, nastavte tuto volby na "Ano" (jinými slovy, i když jste umožnili
		tuto volby, mapu neuvidíte, pokud záznamy vašich míst neobsahují souřadnice zeměpisné šířky a délky (nebyly tzv. geokódovány)).</p>

		<h5 class="optionhead">Typ mapy</h5>
		<p>Vyberte, který typ mapy bude zobrazen nejdříve: Terénní, Cestovní mapa, Satelitní nebo Hybridní (satelitní mapa s ulicemi na povrchu).</p>

		<h5 class="optionhead">Výchozí zeměpisná šířka, Výchozí zeměpisná délka</h5>
		<p>Tyto souřadnice určují, kde je výchozí "střed" mapy u míst, která ještě nemají připojeny zeměpisné souřadnice. Špendlík bude zobrazen
		v tomto místě.</p>

		<h5 class="optionhead">Výchozí přiblížení</h5>
		<p>Toto číslo označuje, jak blízko nebo daleko bude při zahájení zobrazena v administrátorské oblasti nová mapa. Nižší číslo znamená, že
		pohled bude dál, zatímco je-li číslo vyšší, pohled bude blíž. Pokud bude přiblížení uloženo s určitou mapou, bude s touto mapou uloženo.</p>

		<h5 class="optionhead">Přiblížení místa</h5>
		<p>Toto číslo označuje, jak blízko nebo daleko bude na Google Maps zobrazeno v administrátorské oblasti místo, po jeho vyhledání a nalezení.</p>

		<h5 class="optionhead">Rozměry na stránkách osob</h5>
		<p>Zadejte rozměry (šířka musí být v pixelech s označením "px" na konci nebo v procentech; výška musí být v pixelech s označením "px" na konci) map
		zobrazených na stránkách osob. Např. chcete-li vytvořit mapu vysokou 500 pixelů, nastavte <strong>výšku</strong> na 500px. Chcete-li vytvořit mapu, která má obsáhnout 80 procent
		místa z přidělené oblasti, nastavte <strong>šířku</strong> na 80%.</p>

		<h5 class="optionhead">Rozměry na stránkách náhrobků</h5>
		<p>Zadejte rozměry (šířka musí být v pixelech s označením "px" na konci nebo v procentech; výška musí být v pixelech s označením "px" na konci) map
		zobrazených na všech stránkách, které jsou spojeny s náhrobky.</p>

		<h5 class="optionhead">Rozměry na stránkách administrátora</h5>
		<p>Zadejte rozměry (šířka musí být v pixelech s označením "px" na konci nebo v procentech; výška musí být v pixelech s označením "px" na konci) map
		zobrazených na všech administrátorských stránkách.</p>

		<h5 class="optionhead">Skrýt na začátku mapy v administrátorské oblasti</h5>
		<p>Chcete-li na stránkách administrátora skrýt mapy, dokud jste neklikli na tlačítko <span class="emphasis">Zobrazit/Skrýt</span>, vyberte zde volbu <span
                class="choice">Ano</span>.
		Chcete-li zobrazit mapy ihned po zobrazení těchto stránek, vyberte volbu <span class="choice">Ne</span>.</p>

		<h5 class="optionhead">Skrýt na začátku mapy ve veřejné oblasti</h5>
		<p>Chcete-li zpozdit zobrazení mapy na stránkách osoby, dokud je uživatel nezavolá, vyberte zde volbu <span class="choice">Ano</span>. Umožní to
		načíst stránku rychleji. Mapa pak bude načtena po kliknutí na tlačítko <span class="emphasis">Zobrazit mapu</span>.  
		Pokud vyberete volbu <span class="choice">Ne</span>, mapa na stránce osoby bude načtena hned po zobrazení této stránky.</p>

		<h5 class="optionhead">Sloučit duplicitní špendlíky</h5>
		<p>Pokud se na stejném místě objeví více událostí, nastavením této volby na <span class="emphasis">Ano</span> zabráním vytvoření duplicitních špendlíků
		u nejednoznačných názvů míst. Pozn.: Nastavením této volby na <span class="emphasis">Ne</span> způsobí, že si duplicitní špendlíky budou vzájemně překážet.</p>

		<h5 class="optionhead">Špendlíky úrovní sídel: Označení a barvy</h5>
		<p>Každé místo se zeměpisnými souřadnicemi může být spojeno s jedním ze šesti <strong>Úrovní sídla</strong> (např. Místo, Město/obec, Okres, atd.). Označení pro tyto úrovně
		naleznete v souboru "alltext.php", který se nachází ve složce příslušného jazyka a přepsat je můžete ve vašem souboru "cust_text.php" (také v každé jazykové složce).</p>

		<p>Barvy špendlíků určují hodnoty v souboru mapconfig.php. Chcete-li barvy špendlíků změnit, jděte na stránku TNG download
		a stáhněte si úplnou paletu 216 různých barev špendlíků, poté otevřete v textovém editoru svůj soubor mapconfig.php a zadejte číslo
		nové barvy špendlíků vedle proměnné odpovídající úrovni sídla. Nakonec nahrajte soubor s novou barvou špendlíku do složky <span
                class="emphasis">googlemaps</span> na vašich stránkách.</p>

		</span>
        </td>
    </tr>

</table>
</body>
</html>

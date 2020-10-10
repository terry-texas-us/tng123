<?php
include "../../helplib.php";
echo help_header("Nápověda: Nastavení protokolování");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="pedconfig_help.php" class="lightlink">&laquo; Nápověda: Nastavení schémat</a> &nbsp;|&nbsp;
                <a href="importconfig_help.php" class="lightlink">Nápověda: Nastavení importu &raquo;</a>
            </p>
            <h2 class="largeheader">Nápověda: <small>Nastavení protokolování</small></h2>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">
            <h5>Název souboru protokolu</h5>
            <p>Název souboru protokolu je soubor, kam jsou zaznamenávány akce návštěvníků. Původní název "genlog.txt" byste neměli měnit.</p>

            <h5>Maximální počet řádků v protokolu</h5>
            <p>Maximální počet řádků v protokolu určuje, kolik akcí by měl protokol aktuálně uchovávat.
                Je-li toto číslo příliš velké, může se objevit ke snížení výkonu.</p>

            <h5>Vyloučit názvy hostitele</h5>
            <p>Před provedením zápisu do protokolu TNG tento seznam otestuje. Pokud hostitel návštěvníka podléhají případnému zápisu do protokolu
                je v seznamu, nebude proveden žádný zápis. Názvy hostitelů by měly být odděleny čárkami (bez mezer) a mají obsahovat úplný
                název hostitele, IP adresu nebo části obou. Např. "googlebot" bude blokovat "crawler4.googlebot.com".</p>

            <h5>Vyloučit uživatelská jména</h5>
            <p>Před provedením zápisu do protokolu TNG tento seznam otestuje také. Pokud je přihlášený uživatel
                v seznamu, nebude proveden žádný zápis. Uživatelská jména by měla být oddělena čárkami (bez mezer).</p>

            <h5>Název souboru protokolu (Admin)</h5>
            <p>Název souboru protokolu, kam jsou zaznamenávány akce z administrátorské oblasti. Původní název "adminlog.txt" byste neměli měnit.</p>

            <h5>Maximální počet řádků v protokolu (Admin)</h5>
            <p>Maximální počet řádků v protokolu určuje, kolik akcí by měl protokol administrátora aktuálně uchovávat. Je-li toto číslo příliš velké,
                může se objevit ke snížení výkonu.</p>

            <h5>Zablokovat návrhy nebo nové uživatelské registrace</h5></p>

            <h5>Adresa obsahuje</h5>
            <p>Blokuje všechny příchozí návrhy nebo nové uživatelské registrace, kde emailová adresa odesílatele obsahuje nějaké ze zapsaných slov
                nebo částí slov.
                Více slov oddělujte čárkou.</p>

            <h5>Zpráva obsahuje</h5>
            <p>Blokuje všechny příchozí návrhy nebo nové uživatelské registrace, kde tělo zprávy obsahuje nějaké ze zapsaných slov nebo částí slov.
                Více slov oddělujte čárkou.</p>
        </td>
    </tr>

</table>
</body>
<?php echo "</html>"; ?>

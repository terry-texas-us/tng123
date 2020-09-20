<?php
include "../../helplib.php";
echo help_header("N�pov�da: Administrace");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="https://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="https://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="modmanager_help.php" class="lightlink">&laquo; N�pov�da: Mana�er m�d�</a> &nbsp;|&nbsp;
                <a href="people_help.php" class="lightlink">N�pov�da: Osoby &raquo;</a>
            </p>
            <h2 class="largeheader">N�pov�da: <small>Za��n�me</small></h2>
            <p class="smaller menu" style="clear: both;">
                <a href="#gettingstarted" class="lightlink">Za��n�me</a> &nbsp;|&nbsp;
                <a href="#notes" class="lightlink">Pozn�mky</a> &nbsp;|&nbsp;
                <a href="#otherresources" class="lightlink">Jin� zdroje</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">
            <a id="gettingstarted"><h4 class="subheadbold">Za��n�me:</h4></a>
            <p>��m za��t nejd��ve? Zde je z�klad:</p>
            <ol>
                <li><p><strong>Pe�liv� dodr�ujte instrukce k instalaci, kter� jsou obsa�en� v souboru <a href="../../readme.html" target="_blank">readme.html</a>
                            .</strong> P��mo z t�to str�nky
                        lze nastavit z�kladn� konfiguraci, ale v�echny pot�ebn� hodnoty m��ete nastavit z volby <strong>Nastaven�</strong> zde z
                        hlavn�ho administr�torsk�ho menu.</p></li>
                <li><p><strong>Vytvo�te alespo� jeden strom.</strong> Nebudete-li m�t v�ce nez�visl�ch soubor� GEDCOM, budete pravd�podobn� pot�ebovat
                        pouze jeden strom.</p></li>
                <li><p><strong>Vytvo�te alespo� jednoho u�ivatele.</strong> Prvn� u�ivatel, kter�ho vytvo��te, mus� b�t Administr�tor (mus� m�t
                        v�echna p��stupov� pr�va a NESM� m�t omezen� t�kaj�c� se ��dn�ho stromu).</p></li>
                <li><p><strong>Naimportujte sv�j soubor GEDCOM nebo za�n�te ru�n� vkl�dat sv� data</strong>. Pokud je budete vkl�dat ru�n�, nez�le��
                        na to, co vlo��te nejd��ve.
                        N�kdo rad�ji vkl�d� nejprve osoby a potom je spoj� do rodin, zat�mco jin� za��naj� rodinami a pak do nich p�id�vaj� osoby.
                        Nemus�te
                        se ��dit ��dnou strategi�.</p></li>
                <li><p><strong>Pod�vejte se na n�sledn� procesy</strong> (po Importu/Exportu) a prove�te ty, o kter�ch si mysl�te, �e jsou nutn� (v�ce
                        informac�
                        dozv�te zde v N�pov�d�).</p></li>
                <li><p><strong>M�dia.</strong> Pokud jste vlo�ili nebo naimportovali sv� data, m��ete je spojit s fotografiemi, vypr�v�n�mi �i jin�mi
                        m�dii. Bavte se!</p></li>
                <li><p><strong>Z�skejte mapov� kl��.</strong> Mapy Google op�t ke sv�mu pou�it� vy�aduj� kl��. P�ejd�te do Nastaven� a potom do
                        Nastaven� map a klikn�te na odkaz N�pov�da. Zde najdete pokyny, jak z�skat kl��
                        a co s n�m d�lat. Va�e mapy nebudou fungovat, dokud to nebude hotovo.</p></li>
                <li><p><strong>N�co jin�ho.</strong> Budete cht�t proj�t tak� dal�� sekce z menu Administrace. Dal�� n�pov�du naleznete
                        na ka�d� str�nce.</p></li>
            </ol>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="notes"><h4 class="subheadbold">Pozn�mky:</h4></a>
            <ol>
                <li><p>Pokud v�m v menu Administrace chyb� n�kter� volby, z�ejm� jste se nep�ihl�sili s �pln�mi p��stupov�mi pr�vy nebo jsou va�e
                        p��stupov� pr�va omezena pouze na ur�it� strom.
                        Chcete-li u�ivatelsk� pr�va zm�nit, odhlaste se a p�ihlaste se jako Administr�tor, nebo svoji datab�zi upravte p��mo pomoc�
                        phpMyAdmin nebo podobn�mi n�stroji.</p></li>
                <li><p>Pomoc� odkazu na domovskou str�nku na horn�m okraji r�mce se dostanete na domovskou str�nku a zobraz�te ji v okn� va�eho
                        prohl�e�e. Pomoc� odkazu na domovskou str�nku v lev�m r�mci otev�ete svoji
                        str�nku vpravo v hlavn�m r�mci, co� v�m umo�n� pohyb po va�ich str�nk�ch a kdykoli n�vrat do sekce Administr�tora jedn�m
                        kliknut�m v lev�m r�mci.</p></li>
            </ol>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="otherresources"><h4 class="subheadbold">Jin� zdroje:</h4></a>
            <ol>
                <li><p>Mailov� seznam pro aktualizace: <a href="mailto:tngusers@lythgoes.net">tngusers@lythgoes.net</a>. P�ij�mat a pos�lat maily na
                        <a href="mailto:tngusers-subscribe@lythgoes.net">tngusers-subscribe@lythgoes.net</a>. Tento seznam se pou��v� v�hradn� na
                        informov�n� u�ivatel�
                        o programov�ch aktualizac�ch a vydan�ch oprav�ch. </p></li>
                <li><p>U�ivatelsk� mailov� seznam: <a href="mailto:tngusers2@lythgoes.net">tngusers2@lythgoes.net</a>. P�ij�mat a pos�lat maily na
                        <a href="mailto:tngusers2-subscribe@lythgoes.net">tngusers2-subscribe@lythgoes.net</a>. Tento seznam se pou��v� pro diskuze
                        mezi u�ivateli TNG. </p></li>
                <li><p>U�ivatelsk� f�rum: <a href="https://tng.community" target="_blank">https://tng.community</a>.</p></li>
                <li><p>TNG Wiki: <a href="https://tng.lythgoes.net/wiki" target="_blank">https://tng.lythgoes.net/wiki</a>. Str�nka MediaWiki, kter�
                        obsahuje:</p>
                    <ul>
                        <li><a href="https://tng.lythgoes.net/wiki/index.php?title=Category:Getting_Started" target="_blank">Pr�vodce uvodem do
                                TNG</a>. Jak nastavit va�e str�nky a vytvo�it u�ivatelsk� str�nky.
                        </li>
                        <li><a href="https://tng.lythgoes.net/wiki/index.php?title=Category:Visitors" target="_blank">Pr�vodce pro n�v�t�vn�ky TNG</a>.
                            Jak se mohou n�v�t�vn�ci pohybovat po va�ich str�nk�ch.
                        </li>
                        <li><a href="https://tng.lythgoes.net/wiki/index.php?title=Category:Registered_Users" target="_blank">Pr�vodce pro
                                registrovan� u�ivatele TNG</a>. Jak vyu��t mo�nosti TNG jako registrovan� u�ivatel nebo Administr�tor.
                        </li>
                        <li><a href="https://tng.lythgoes.net/wiki/index.php?title=Category:Administrator" target="_blank">Pr�vodce pro administr�tora
                                TNG</a>. Poskytne informace pro administr�tora webov�ch str�nek TNG.
                        </li>
                        <li><a href="https://tng.lythgoes.net/wiki/index.php?title=Category:Programmer" target="_blank">Pr�vodce pro program�tora
                                TNG</a>. Pom��e porozum�t, jak TNG pracuje, a pro program�tory, jak vytvo�it zm�ny v TNG.
                        </li>
                        <li><a href="https://tng.lythgoes.net/wiki/index.php?title=TNG_Glossary" target="_blank">Seznam term�n� TNG</a>. Slova a v�ty
                            pou�it� v TNG, kter� souvis� s genealogi�, po��ta�ovou technikou a organizac� archivace.
                        </li>
                    </ul>
                    <br>
                </li>
                <li><p>Odkazy PHP: <a href="http://www.php.net" target="_blank">http://www.php.net</a>.</p></li>
                <li><p>Odkazy MySQL: <a href="http://www.mysql.com" target="_blank">http://www.mysql.com</a>.</p></li>
                <li><p>Odkazy HTML: <a href="http://www.htmlhelp.com" target="_blank">http://www.htmlhelp.com</a>.</p></li>
                <li><p>Kontakt p��mo na autora: <a href="mailto:darrin@lythgoes.net">darrin@lythgoes.net</a>.</p></li>
            </ol>
        </td>
    </tr>

</table>
</body>
<?php echo "</html>"; ?>

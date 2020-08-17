<?php
include "../../helplib.php";
echo help_header("N�pov�da: Nastaven� �ablony");
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
</head>

<body class="helpbody">
<a name="top"></a>
<table width="100%" border="0" cellpadding="10" cellspacing="2" class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right" class="smaller menu">
                <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp; | &nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br/>
                <a href="mapconfig_help.php" class="lightlink">&laquo; N�pov�da: Nastaven� mapy</a> &nbsp; | &nbsp;
                <a href="users_help.php" class="lightlink">N�pov�da: U�ivatel� &raquo;</a>
            </p>
            <span class="largeheader">N�pov�da: Nastaven� �ablony</span>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">
            <p><span class="optionhead">Pou�it� �ablony</span><br/>�ablony TNG umo�n� d�t va�im str�nk�m rychle profesion�ln� vzhled a atmosf�ru. Chcete-li �ablonu pou��t, nejd��ve nastavte
                "Umo�nit v�b�r �ablony" na <strong>Ano</strong>, pak vyberte ��slo �ablony, kterou chcete (viz volby na
                <a href="http://lythgoes.net/genealogy/templates.php">http://lythgoes.net/genealogy/templates.php</a>). Po ulo�en� zm�n bude nov� �ablony ��inkovat.</p>
            <p>Chcete-li zachovat existuj�c� nastaven� str�nky (z verze p�ed 8.1.0), nechte volbu <strong>Umo�nit v�b�r �ablony</strong> nastavenu na <b>Ne</b>.</p>
            <p><span class="optionhead">P�izp�soben�</span><br/>Va�i str�nku m��ete upravit podle toho, co v�m soubory �ablon dovol�. Va�e v�choz� domovsk� str�nka je index.php, va�e
                v�choz� z�hlav� a z�pat� je topmenu.php a footer.php. Soubory s t�mito n�zvy jsou um�st�ny uvnit� slo�ky ka�d� �ablony. Specifick� "styl" �ablony (barvy, p�sma a jin�
                form�tov�n�) je definov�no v souboru templatestyle.css (v podslo�ce "css" u ka�d� �ablony), ale pokud chcete n�co m�nit, je lep�� zm�ny prov�st
                v souboru mytngstyle.css (tak� v podslo�ce "css" u ka�d� �ablony), tak�e va�e zm�ny nebudou v budoucnu p�eps�ny aktualizac� programu.</p>
            <p><span class="optionhead">Podpora v�ce jazyk�</span><br/>Pokud chcete, aby byla n�jak� zpr�va v nastaven� �ablony dostupn� v jin�m jazyku,
                vyberte tento jazyk z rozbalovac�ho seznamu vedle odpov�daj�c� zpr�vy, pot� klikn�te na tla��tko "Prov�st". Objev� se
                nov� pole, kam m��ete zapsat p�eklad t�to zpr�vy. Po kliknut� na tla��tko "Ulo�it" v horn� ��sti str�nky se tato zpr�va stane trvalou sou��st�
                nastaven� �ablony va�� str�nky.</p>
            <p><span class="optionhead">Jednoduch� zm�ny</span><br/>Zm�ny m��ete ud�lat p��mo �pravou soubor� zm�n�n�ch v p�ede�l�m odstavc�ch, ale n�kter� jednoduch� zm�ny m��ete prov�st
                zde v Nastaven� �ablony. Vyberte �ablonu podle ��sla a zobraz� se v�m n�kter� kl��ov� prvky str�nky. Zm�na t�chto nastaven�
                automaticky uprav� va�i str�nku, p�i p�edpokladu, �e ji� jste str�nky neupravili
                ru�n�. M��ete ud�lat zm�n, kolik chcete, ale pokud odstran�te n�kter� PHP k�d,
                nemus� u� tyto zm�ny p�sobit.</p>
            <p><span class="optionhead">Obr�zky</span><br/>Chcete-li zm�nit n�jak� obr�zek, nejjednodu��� je kliknout na tla��tko "Zm�nit" vedle pole obsahuj�c�ho
                n�zev obr�zku. Zobraz� se v�m pak nov� pole, kter� v�m umo�n� naj�t obr�zek na va�em po��ta�i. Po nahr�n� nov�ho obr�zku se jeho
                n�zev zobraz� v poli m�sto n�zvu p�vodn�ho obr�zku. Chcete-li jeho n�zev zm�nit, zadejte v tomto poli jeho nov� n�zev.
                S ohledem na co nejlep�� kvalitu dbejte na to, aby m�l v� nov� obr�zek stejn� rozm�ry jako obr�zek existuj�c�. Rozm�ry obr�zku zjist�te
                kliknut�m prav�m tla��tkem my�i na obr�zek, kter� vid�te ve sv�m prohl�e�i (pou�ijte tla��tko "N�hled"), a v�b�rem "Vlastnosti" nebo "Zobrazit vlastnosti obr�zku". Pokud mus�te
                rozm�ry obr�zku zm�nit, mus�te je zm�nit ru�n�.</p>
            <p>Po nahr�n� obr�zku a dokon�en� v�ech zm�n klikn�te na "Ulo�it" v doln� ��sti str�nky. Pokud tento proces neprob�hne, m��ete m�t chybn� nastavena p��stupov�
                pr�va na va�i slo�ku �ablon. Ujist�te se, zda jsou pr�va nastavena na 755 nebo 777. Pokud st�le nem��ete pracovat, m��ete k nahr�n� nov�ho obr�zku p��mo do podslo�ky "img" ve slo�ce �ablony,
                kterou pou��v�te, pou��t FTP program nebo jin� online spr�vce soubor�.</p>
            <p><span class="optionhead">Odkazy na funkce a zdroje</span><br/>Pokud va�e vybran� �ablona obsahuje n�kterou z t�chto mo�nost�, m��ete vytvo�it odkazy v t�chto
                sekc�ch pomoc� seznamu n�zv� odkaz� a jejich URL na jednom ��dku odd�len�ch ��rkou. Nap�. <em>TNG, http://www.tngsitebuilding.com</em>.</p>
            <p><span class="optionhead">Zm�na n�zoru</span><br/>Volby nastaven� m��ete upravit pro v�ce �ablon, ale pou�ita m��e b�t pouze jedna. Pokud se pozd�ji rozhodnete, �e chcete pou��vat jinou
                �ablonu, v horn� ��sti str�nky Nastaven� �ablony vyberte nov� ��slo �ablony. Zm�ny nastaven�, kter� jste provedli ve va�� p�vodn� �ablon�,
                z�stanou zachov�ny, kdybyste se rozhodli pro n�vrat na p�edchoz� �ablonu.</p>
        </td>
    </tr>

</table>
</body>
</html>

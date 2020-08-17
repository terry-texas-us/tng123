<?php
include "../../helplib.php";
echo help_header("N�pov�da: Ud�losti");
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
                <a href="citations_help.php" class="lightlink">&laquo; N�pov�da: Citace</a> &nbsp; | &nbsp;
                <a href="more_help.php" class="lightlink">N�pov�da: V�ce &raquo;</a>
            </p>
            <span class="largeheader">N�pov�da: Ud�losti</span>
            <p class="smaller menu">
                <a href="#what" class="lightlink">Standardn� a vlastn�</a> &nbsp; | &nbsp;
                <a href="#add" class="lightlink">P�idat nov�</a> &nbsp; | &nbsp;
                <a href="#edit" class="lightlink">Upravit existuj�c�</a> &nbsp; | &nbsp;
                <a href="#del" class="lightlink">Vymazat</a> &nbsp; | &nbsp;
                <a href="#citations" class="lightlink">Citace</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a name="what"><p class="subheadbold">Standardn� a vlastn� ud�losti</p></a>
            <p>Ud�losti obvykl� jako je narozen�, �mrt�, s�atek a n�kter� dal�� se vkl�daj� na hlavn� str�nce osoby, rodiny, pramenu a �lo�i�t� pramen�
                a jsou ulo�eny do odpov�daj�c�ch tabulek v datab�zi. Dokumentace TNG na tyto ud�losti odkazuje jako na "standardn�" ud�losti. V�echny ostatn� ud�losti jsou naz�v�ny "vlastn�" ud�losti
                a jsou spravov�ny v sekci <strong>Dal�� ud�losti</strong> na str�nk�ch osoby, rodiny, pramenu a �lo�i�t� pramen�. Tyto ud�losti se ukl�daj� do zvl�tn�
                tabulky Ud�losti (Events). Toto t�ma n�pov�dy se v�nuje t�mto <em>vlastn�m</em> ud�lostem.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a name="add"><p class="subheadbold">P�idat ud�lost</p></a>

            <p>Chcete-li p�idat novou ud�lost, klikn�te na tla��tko "P�idat nov�" v sekci Dal�� ud�losti a vypl�te formul��. Pokud ud�losti ji� existuj�,
                budou zobrazeny v sekci Dal�� ud�losti v tabulce. V dal�� ��sti jsou vysv�tlena dostupn� pole.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a name="edit"><p class="subheadbold">Upravit ud�lost</p></a>

            <p>Pokud chcete upravit existuj�c� ud�lost, klikn�te v sekci Dal�� ud�losti na ikonu Upravit vedle t�to ud�losti (pro �pravu �daj� "standardn�ch" ud�lost�
                jako je narozen� nebo �mrt� zm��te jednodu�e text).</p>

            <p>P�i p�id�n� nebo �prav� ud�losti si v�imn�te n�sleduj�c�ho:</p>

            <span class="optionhead">Typ ud�losti</span>
            <p>Vyberte typ ud�losti (u existuj�c� ud�losti nelze zm�nit typ ud�losti). Nen�-li typ ud�losti, kter� chcete, ve v�b�rov�m poli typ� ud�lost�,
                jd�te nejprve do Admin/Vlastn� typy ud�lost� a nastavte zde typ ud�losti, pak se vra�te na tuto obrazovku a vyberte jej.</p>

            <span class="optionhead">Datum ud�losti</span>
            <p>Aktu�ln� nebo p�edpokl�dan� datum spojen� s ud�lost�.</p>

            <span class="optionhead">M�sto ud�losti</span>
            <p>M�sto, kde ud�lost prob�hla. Zapi�te n�zev m�sta nebo klikn�te na ikonu Naj�t (lupa).</p>

            <span class="optionhead">Podrobnosti</span>
            <p>Dal�� podrobnosti popisuj�c� ud�lost. Pokud s ud�lost� nen� spojeno ��dn� datum ani m�sto, m��e pole Podrobnosti obsahovat �daje, kter� tuto ud�lost definuj�.</p>

            <span class="optionhead">Duplikovat pro (ID):</span>
            <p>Chcete-li tuto ud�lost duplikovat pro v�ce osob nebo rodin, zapi�te sem ��sla ID t�chto osob nebo rodin. Vkl�d�te-li v�ce ��sel ID, odd�lte je ��rkou.
                Pokud ��slo ID nezn�te, klikn�te na ikonu "Naj�t" vpravo od tohoto pole a m��ete je vyhledat podle jm�na. Po kliknut� na tla��tko "Ulo�it" bude tato ud�lost nakop�rov�na
                t�mto osob�m (rodin�m). Pokud znovu otev�ete okno s �pravou ud�lolsti, toto pole bude pr�zdn�. V�echny zm�ny, kter� od tohoto okam�iku v t�to ud�losti
                provedete, <b>nebudou</b> prom�tnuty do d��ve vytvo�en�ch duplik�t�.</p>

            <span class="optionhead">V�ce</span><br/>
            <p>Kliknut�m na "V�ce" m��ete pro ka�dou ud�lost zapsat n�kter� m�n� b�n� �daje. Objev� se dal�� pole.
                Tato pole lze skr�t op�tovn�m kliknut�m na "V�ce". Skryt� pol� neznamen� vymaz�n� jejich obsahu. Tato pole obsahuj�:</p>

            <p><span class="optionhead">V�k</span>: V�k osoby v dob� ud�losti.</p>

            <p><span class="optionhead">Instituce</span>: Instituce nebo osoba, kter� m�la v dob� ud�losti autoritu nebo odpov�dnost.</p>

            <p><span class="optionhead">P���ina</span>: P���ina ud�losti (nej�ast�ji pou�ita s ud�lost� �mrt�).</p>

            <p><span class="optionhead">Adresa 1/Adresa 2/M�sto/Kraj/provincie/PS�/Zem�/Telefon/Email/Internetov� str�nky</span>: Adresa a ostatn� kontaktn� �daje spojen� s ud�lost�.</p>

            <span class="optionhead">Povinn� pole:</span>
            <p>Vybrat mus�te typ ud�losti a nejm�n� do jednoho z n�sleduj�c�ch pol� mus�te n�co vlo�it: <strong>Datum ud�losti</strong>, <strong>M�sto ud�losti</strong>,
                nebo <strong>Podrobnosti</strong>. V�echna ostatn� pole jsou nepovinn�.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a name="del"><p class="subheadbold">Vymazat ud�lost</p></a>

            <p>Chcete-li vymazat existuj�c� ud�lost, klikn�te v sekci Dal�� ud�losti na ikonu Vymazat vedle t�to ud�losti. Ud�lost bude vymaz�na bez ohledu na to, zda ostatn� �daje na str�nce jsou ulo�eny.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a name="citations"><p class="subheadbold">Pozn�mky a citace</p>
                Chcete-li p�idat nebo upravit pozn�mky nebo citace u ud�losti, ud�lost nejd��ve ulo�te, a pot� klikn�te na p��slu�nou ikonu vedle z�znamu t�to ud�losti v aktu�ln�m seznamu ud�lost�.
                V�ce informac� o pozn�mk�ch naleznete zde: <a href="notes_help.php">N�pov�da: Pozn�mky</a>.
                V�ce informac� o citac�ch naleznete zde: <a href="citations_help.php">N�pov�da: Citace</a>.</p>

        </td>
    </tr>

</table>
</body>
</html>

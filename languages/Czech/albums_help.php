<?php
include "../../helplib.php";
echo help_header("N�pov�da: Alba");
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
                <a href="collections_help.php" class="lightlink">&laquo; N�pov�da: Kolekce</a> &nbsp; | &nbsp;
                <a href="cemeteries_help.php" class="lightlink">N�pov�da: H�bitovy &raquo;</a>
            </p>
            <span class="largeheader">N�pov�da: Alba</span>
            <p class="smaller menu">
                <a href="#search" class="lightlink">Hledat</a> &nbsp; | &nbsp;
                <a href="#add" class="lightlink">P�idat nov�</a> &nbsp; | &nbsp;
                <a href="#edit" class="lightlink">Upravit existuj�c�</a> &nbsp; | &nbsp;
                <a href="#delete" class="lightlink">Vymazat</a> &nbsp; | &nbsp;
                <a href="#sort" class="lightlink">T��dit</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a name="search"><p class="subheadbold">Hledat</p></a>
            <p>Existuj�c� m�dia vyhled�te zad�n�m �pln�ho v�razu nebo ��sti <strong>N�zvu alba, Popisu</strong> nebo
                <strong>Kl��ov�ch slov</strong>. Pokud do vyhled�vac�ch pol� nezad�te ��dn� v�b�rov� krit�ria, budou nalezena v�echna alba, kter� se nach�zej� ve va�� datab�zi.</p>

            <p>Vyhled�vac� krit�ria, kter� zad�te na t�to str�nce, budou uchov�na, dokud nekliknete na tla��tko <strong>Obnovit</strong>, kter� znovu obnov� v�echny v�choz� hodnoty.</p>

            <span class="optionhead">Akce</span>
            <p>Tla��tko Akce vedle ka�d�ho alba v�m umo�n� upravit, vymazat nebo zobrazit n�hled tohoto alba.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="add"><p class="subheadbold">P�id�n� nov�ch alb</p></a>
            <p><strong>Album</strong> v TNG je skupina m�di�. Album m��e obsahovat jak�koli po�et m�di� a konkr�tn� m�dium m��e b�t sou��st� v�ce alb.
                Podobn� jako jednotliv� m�dium m��e b�t album p�ipojeno k osob�, rodin�, pramenu, �lo�i�ti pramen� nebo m�stu.</p>

            <p>Chcete-li p�idat nov� album, klikn�te na z�lo�ku <strong>P�idat nov�</strong> a pot� vypl�te formul��. Dal�� informace jako m�dia, kter� m� album obsahovat, a
                odkazy na osobu, rodinu a jin� entity, m��ete p�idat po ulo�en� z�znamu. V�znam jednotliv�ch pol� je n�sleduj�c�:</p>

            <p><span class="optionhead">N�zev alba</span><br/>
                N�zev va�eho alba.</p>

            <p><span class="optionhead">Popis</span><br/>
                Kr�tk� popis alba nebo polo�ek, kter� obsahuje.</p>

            <p><span class="optionhead">Kl��ov� slova</span><br/>
                Jak�koli po�et kl��ov�ch slov mimo n�zev alba a popis, kter� maj� b�t pou�ita p�i vyhled�v�n� tohoto alba.</p>

            <p><span class="optionhead">Aktivn�</span><br/>
                Je-li album ozna�eno jako "Aktivn�", bude zobrazeno na va�ich str�nk�ch ve ve�ejn�m seznamu. Je-li p��znak Aktivn� nastaven na "Ne", n�v�t�vn�ci va�ich str�nek
                toto album vid�t nebudou.</p>

            <p><span class="optionhead">V�dy viditeln�</span><br/>
                Je-li aktivn� album ozna�eno jako "V�dy viditeln�" a je p�ipojeno k osob�, rodin�, pramenu nebo �lo�i�ti pramen�, bude na str�nk�ch u t�chto entit v�dy viditeln�, i kdy� je
                p�ipojeno k �ij�c� osob� nebo rodin�. Jinak jsou aktivn� alba nebo m�dia, kter� jsou p�ipojen� k �ij�c�m osob�m, skryta pro n�v�t�vn�ky, kte�� nemaj� opr�vn�n� prohl�et data �ij�c�ch osob.
            </p>

            <p><span class="optionhead">Pole, kter� mus� b�t vypln�na:</span> N�zev alba je jedin� pole, kter� je nutn� vyplnit, ale je ve va�em z�jmu vyplnit i ostatn� pole.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="edit"><p class="subheadbold">�prava existuj�c�ho alba</p></a>
            <p>Chcete-li upravit existuj�c� album, pou�ijte z�lo�ku <a href="#search">Hledat</a> pro vyhled�n� alba a pot� klikn�te na ikonu Upravit vedle tohoto alba.
                V�znam n�sleduj�c�ch pol�, kter� nejsou na str�nce "P�idat nov� album":</p>

            <span class="optionhead">M�dia v albu</span>
            <p>Chcete-li do alba p�idat m�dia, klikn�te na tla��tko "P�idat m�dium", a pot� pou�ijte formul�� v zobrazen�m okn� pro v�b�r m�di� z polo�ek, kter� obsahuje
                va�e datab�ze. M��ete pou��t Kolekce a/nebo Strom (ob� volby jsou nepovinn�), pot� do pole "Naj�t" zapi�te ��st n�zvu alba nebo popisu
                a klikn�te na tla��tko "Hledat". Kdy� najdete polo�ku, kterou byste cht�li p�idat do alba, klikn�te na odkaz "P�idat" vlevo na ��dku polo�ky. Tato
                polo�ka bude do alba p�id�na a okno z�stane zobrazen�. Tento postup opakujte pro dal�� m�dia, kter� chcete p�idat, nebo klikn�te na odkaz "Zav��t okno" pro n�vrat na str�nku �prava alba.</p>

            <p>Chcete-li z alba odstranit m�dium, p�esu�te kursor my�i nad tuto polo�ku. Zobraz� se odkaz "Odstranit". Pro odstran�n� polo�ky klikn�te na tento odkaz. Po
                potvrzen� bude polo�ka zatemn�na.</p>

            <p>Pro v�b�r n�hledu, kter� m� b�t pro toto album <strong>V�choz� fotografi�</strong>, p�esu�te kursor my�i nad tuto polo�ku. Zobraz� se odkaz "Nastavit jako v�choz�".
                Kliknut�m na tento odkaz ur��te tento n�hled jako v�choz� fotografii tohoto alba. Chcete-li vybrat jinou v�choz� fotografii, opakujte tento postup s jinou
                polo�kou ze seznamu. Chcete-li odstranit v�choz� fotografii, klikn�te na odkaz "Odstranit v�choz� fotografii" v horn� ��sti t�to str�nky.</p>

            <p>Chcete-li v albu p�e�adit m�dia, klikn�te na oblast "T�hnout" u ur�it� polo�ky a p�i stisknut�m tla��tku my�i p�et�hn�te polo�ku na po�adovan� m�sto
                v oblasti seznamu. Je-li polo�ka na po�adovan�m m�st�, uvoln�te tla��tko my�i ("uchopit a t�hnout"). V tomto okam�iku jsou zm�ny automaticky ulo�eny.</p>

            <p>Dal�� mo�nost� jak p�et��dit polo�ky je z�pis po sob� jdouc�ch ��sel do mal�ho pol��ka vedle oblasti "T�hnout", a pot� kliknout na odkaz "Jdi" pod oknem a stiskn�te Enter.
                To m��e b�t vhodn� pro p�esun polo�ek, je-li seznam p��li� dlouh� a v�echny polo�ky se nevejdou najednou na str�nku.</p>

            <p>Kliknut�m na ikonu dvojit� �ipky napravo od oblasti "T�hnout" m��ete polo�ku p�esunout p��mo na �eln� m�sto seznamu.</p>

            <span class="optionhead">Odkazy na album</span>
            <p>Toto album m��ete p�ipojit k osob�, rodin�, pramenu, �lo�i�ti pramen� nebo m�stu. Pro ka�d� p�ipojen� nejprve vyberte strom spojen� s entitou, kterou chci p�ipojit.
                D�le vyberte typ propojen� (osoba, rodina, pramen, �lo�i�t� pramen� nebo m�st), a na z�v�r zapi�te ��slo ID nebo n�zev (pouze u m�st) entity, kterou chcete p�ipojit. Po
                vlo�en� v�ech �daj� klikn�te na tla��tko "P�idat".</p>

            <p>Pokud nezn�te ID ��slo nebo p�esn� n�zev m�sta, klikn�te na ikonu lupy pro vyhled�n� t�chto �daj�. Zobraz� se okno, ve kter�m m��ete vyhled�vat.
                Po nalezen� popisu po�adovan� entity klikn�te na odkaz "P�idat" vlevo. Kliknout na "P�idat" m��ete u v�ce entit. Po dokon�en� tvorby propojen�
                klikn�te na odkaz "Zav��t okno".</p>

            <p>POZN�MKA: V�echny zm�ny, kter� se medi� v albech a odkaz� na alba, jsou ulo�eny okam�it� a nen� nutn� kliknout na tla��tko "Ulo�it" na spodn�m okraji obrazovky.
                Pro ulo�en� zm�n v sekci "Informace o albu" je nutn� kliknout na "Ulo�it".</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="delete"><p class="subheadbold">Vymazat alba</p></a>
            <p>Chcete-li album odstranit, pou�ijte z�lo�ku <a href="#search">Hledat</a> pro nalezen� alba, a pot� klikn�te na ikonu Vymazat vedle tohoto alba. Tento ��dek zm�n�
                barvu a pot� po odstran�n� polo�ky zmiz�.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="sort"><p class="subheadbold">T��d�n� alb</p></a>
            <p>Standardn� jsou alba, kter� jsou propojena s osobou, rodinou, pramenem, �lo�i�t�m pramen� nebo m�stem, se�azena v po�ad�, ve kter�m byla k t�to entit� p�ipojena. Chcete-li
                toto po�ad� zm�nit, nov� po�ad� nastav�te na z�lo�ce Album/T��dit.</p>

            <span class="optionhead">Strom, Typ odkazu, Kolekce:</span>
            <p>Vyberte strom spojen� s entitou, u kter� chcete t��dit alba. Pot� vyberte typ odkazu (osoba, rodina, pramen, �lo�i�t� pramen� nebo m�sto) a
                kolekci, kterou chcete t��dit.</p>

            <span class="optionhead">ID:</span>
            <p>Zapi�te ��slo ID nebo n�zev (pouze u m�sta) entity. Pokud nezn�te ID ��slo nebo p�esn� n�zev m�sta, klikn�te na ikonu lupy pro vyhled�n� t�chto �daj�.
                Po nalezen� po�adovan� entity klikn�te na odkaz "Vybrat" vedle t�to entity. Zobrazen� okno se uzav�e a vybran� ID ��slo se objev� v poli ID ��slo.</p>

            <span class="optionhead">Procedura �azen�</span>
            <p>Po v�b�ru nebo zaps�n� ID ��sla klikn�te na tla��tko "Pokra�ovat" pro zobrazen� v�ech alb pro vybranou entitu a kolekci v jejich aktu�ln�m po�ad�.
                Chcete-li v alba p�e�adit, klikn�te na oblast "T�hnout" u ur�it� polo�ky a p�i stisknut�m tla��tku my�i p�et�hn�te polo�ku na po�adovan� m�sto
                v oblasti seznamu. Je-li polo�ka na po�adovan�m m�st�, uvoln�te tla��tko my�i ("uchopit a t�hnout"). V tomto okam�iku jsou zm�ny automaticky ulo�eny.</p>

            <p>Dal�� mo�nost� jak p�et��dit polo�ky je z�pis po sob� jdouc�ch ��sel do mal�ho pol��ka vedle oblasti "T�hnout", a pot� kliknout na odkaz "Jdi" pod oknem a stiskn�te Enter.
                To m��e b�t vhodn� pro p�esun polo�ek, je-li seznam p��li� dlouh� a v�echny polo�ky se nevejdou najednou na str�nku.</p>

            <p>Kliknut�m na ikonu dvojit� �ipky napravo od oblasti "T�hnout" m��ete polo�ku p�esunout p��mo na �eln� m�sto seznamu.</p>

        </td>
    </tr>

</table>
</body>
</html>

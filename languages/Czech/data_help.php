<?php
include "../../helplib.php";
echo help_header("N�pov�da: Import dat");
?>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<body class="helpbody">
<a name="top"></a>
<table width="100%" cellpadding="10" cellspacing="2" class="tblback normal">
  <tr class="fieldnameback">
    <td class="tngshadow">
      <p style="float:right; text-align:right;" class="smaller menu">
        <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp; | &nbsp;
        <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
        <a href="mostwanted_help.php" class="lightlink">&laquo; N�pov�da: Hled� se</a> &nbsp; | &nbsp;
        <a href="second_help.php" class="lightlink">N�pov�da: Druhotn� procesy &raquo;</a>
      </p>
      <span class="largeheader">N�pov�da: Import / Export</span>
      <p class="smaller menu">
        <a href="#import" class="lightlink">GEDCOM Import</a> &nbsp; | &nbsp;
        <a href="#export" class="lightlink">GEDCOM Export</a>
      </p>
    </td>
  </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a name="import"><p class="subheadbold">GEDCOM Import</p></a>
            <p>Na t�to str�nce m��ete naimportovat v�echna data ze standardn�ho souboru GEDCOM do ur�it�ho stromu.</p>

            <p><span class="optionhead">P�ed importem:</span> Z va�eho genealogick�ho programu vytvo�te standardn� soubor GEDCOM 5.5 (4.0 je tak� akceptovateln�). Neve�ejn� informace u �ij�c�ch osob
                m��ete vylou�it, ale nen� to nutn�. Nen� tak� nutn� vylou�it �daje t�kaj�c� se CJKSpd, proto�e mohou b�t tak� filtrov�ny v z�vislosti na u�ivatelsk�ch pr�vech.</p>

            <p>Po vytvo�en� souboru GEDCOM je dal��m krokem, jak ho dostat na va�e webov� str�nky. V�znam jednotliv�ch pol� je n�sleduj�c�:</p>

            <p><span class="optionhead">[Import souboru GEDCOM] Z va�eho po��ta�e</span>
                Chcete-li nahr�t a importovat v� soubor na va�e str�nky bez pou�it� FTP, klikn�te na tla��tko "Prohledat" a najd�te soubor na va�em disku. Po jeho vyhled�n� se v tomto poli objev� n�zev a um�st�n� va�eho souboru.
                <strong>POZN.</strong>: Pokud je v� soubor GEDCOM p��li� velk� (> 2MB), budete muset p�ed nahr�n�m va�eho souboru t�mto zp�sobem kontaktovat poskytovatele sv�ho hostingu, proto�e server m��e m�t omezen� maxim�ln�
                velikosti pro nahr�v�n� soubor� prost�ednictv�m webov�ho formul��e. Pokud b�hem importu obdr��te chybov� hl�en�, jedn� se o tento p��pad. Zkuste m�sto toho pou��t k nakop�rov�n� sv�ho souboru do slo�ky GEDCOM program FTP,
                a pak jej naimportujte odtud (viz n�e).</p>

            <span class="optionhead">OR [Import souboru GEDCOM] Z webov�ch str�nek (ve slo�ce GEDCOM)</span>
            <p>Pokud jste pro p�enos souboru do slo�ky GEDCOM na va�ich str�nk�ch pou�ili FTP nebo n�jak� online souborov� mana�er, zapi�te sem p�esn� n�zev va�eho souboru, kter� chcete nahr�t nebo klikn�te na
                tla��tko "Vybrat" pro jeho nalezen� na va�ich str�nk�ch. Mus� b�t ve slo�ce GEDCOM nebo jej tla��tko Vybrat nenajde. <strong>POZN.</strong>: Pokud vid�te seznam
                soubor�, ale tyto nejsou z va�� slo�ky GEDCOM, m�te z�ejm� probl�m s um�st�n�m soubor�. Ov��te svoji ko�enovou slo�ku (Admin/Nastaven�/Z�kladn� nastaven�) a va�i slo�ku GEDCOM (Admin/Nastaven�/Nastaven� importu).</p>

            <span class="optionhead">P�ijmout data pro v�echny vlastn� typy ud�lost�</span>
          <p>V� soubor GEDCOM m��e obsahovat ud�losti, kter� bude TNG pova�ovat za "vlastn�" ud�losti. Norm�ln� jsou vlastn� typy ud�lost�, kter� soubor GEDCOM obsahuje, vlo�eny do datab�ze, ale
            ale je nastaveno, aby data byla ignorov�na. Stav vlastn�ch typ� ud�lost� m��ete zm�nit na "p�ijmout", aby ud�losti tohoto typu byly naimportov�ny (jin�mi slovy,
            abyste nemuseli v� soubor importovat dvakr�t). Pokud tuto volbu za�krtnete, TNG automaticky nastav� v�echny nov� vlastn� typy ud�lost� na "p�ijmout" a v�echny va�e ud�losti
            budou importov�ny napoprv�.</p>

          <span class="optionhead">Importovat pouze vlastn� typy ud�lost� (nebudou vlo�eny, nahrazeny nebo p�id�ny ��dn� �daje)</span>
          <p>Za�krtnut� t�to volby zp�sob�, �e budou naimportov�ny pouze vlastn� typy ud�lost� (viz Admin/Vlastn� typy ud�lost�). V�echny dal�� �daje budou ignorov�ny. To je ide�ln� mo�nost
            jak sestavit va�e v�choz�ho nastaven�, proto�e v�m umo�n� vid�t, kter� vlastn� ud�losti v�s soubor GEDCOM obsahuje. M��ete pot� zvolit, kter� ud�losti
            p�ed importem va�� cel� datab�ze p�ijmout a kter� odm�tnout.</p>

          <span class="optionhead">C�lov� strom</span><br>
          <p>Vyberte strom, do kter�ho chcete importovat data (povinn�). Pokud strom, kam maj� data p�ij�t, je�t� neexistuje, klikn�te na tla��tko "P�idat nov� strom" a vytvo�te jej.
            Objev� se mal� okno, kter� v�m umo�n� zadat informace o nov�m stromu.</p>

          <span class="optionhead">Nahradit v�echna aktu�ln� data</span>
          <p>Zvol�te-li tuto mo�nost, v�echny va�e d��v�j�� �daje ze souboru GEDCOM (osoby, rodiny, d�ti, prameny, �lo�i�t� pramen�, ud�losti, pozn�mky, spojen� a citace; ne m�dia a cokoli jin�ho)
            budou p�ed importem vymaz�na.
            <strong>POZN.</strong>: Odkazy na m�dia budou zachov�ny, pokud se ID ��sla osoby/rodiny/pramenu/�lo�i�t� pramen� ve va�em nov�m souboru GEDCOM budou shodovat s ID ��sly va�ich dosavadn�ch dat.
            V�t�ina genealogick�ch program� p�i�azuj� st�l� ID ��sla ka�d� osob�/rodin�/pramenu/�lo�i�ti pramen�, ale n�kter� ne. Pokud m�te k dat�m p�ipojeny n�jak� polo�ky m�di�, p�ed importem, pros�m, zkontrolujte,
            zda se ID ��sla ve va�em nov�m souboru GEDCOM shoduj�, bez ohledu na to, kterou z t�chto mo�nost� m�te vybr�nu. Je tak� vhodn� vytvo�it p�ed importem z�lohu va�ich tabulek
            (viz Admin/Obslu�n� programy o vytvo�en� z�lohy).</p>

            <span class="optionhead">Nahradit pouze odpov�daj�c� z�znamy</span>
            <p>S touto volbou jsou p�id�ny nov� z�znamy a odpov�daj�c� z�znamy jsou nahrazeny (shoda je podm�n�na pouze ID ��sly). Star� �daje nejsou odstran�ny.</p>

            <span class="optionhead">Nenahradit ��dn� data</span>
            <p>Nov� z�znamy budou p�id�ny, ale shodn� z�znamy budou ignorov�ny (nenahrazeny).</p>

            <span class="optionhead">P�idat v�echny z�znamy</span>
            <p>V�echny z�znamy budou naimportov�ny, bez ohledu na existuj�c� data, ale jejich ID ��sla budou p�e��slov�na. ID ��sla importovan�ch z�znam� budou vytvo�ena od prvn�ho voln�ho ��sla
                (nebo ��sla, kter� ur��te).</p>

            <span class="optionhead">V�echna p��jmen� velk�mi p�smeny</span>
            <p>Za�krtnut�m tohoto pol��ka p�ed importem zp�sob� p�eveden� v�ech p��choz�ch p��jmen� na velk� p�smena. P��jmen� budou t�mto zp�sobem ulo�ena v datab�zi,
                tak�e tento proces nelze vz�t zp�t, pokud v� soubor GEDCOM nenaimportujete znovu.</p>

            <span class="optionhead">Nep�epo��tat ozna�en� �ij�c�</span>
            <p>Pokud zvol�te "Nahradit pouze odpov�daj�c� z�znamy", zobraz� se v�m tato volba. P�ed importem tuto volbu za�krtn�te,
                pokud nechcete, aby bylo p�epo��t�no ozna�en� "�ij�c�" pro osoby, kter� ji� jsou v datab�zi.</p>

            <span class="optionhead">Nahradit pouze, pokud jsou �daje nov�j��</span>
            <p>Odpov�daj�c� z�znamy budou nahrazeny pouze, pokud p�ich�zej�c� z�znam je nov�j�� ne� z�znam, kter� se nach�z� v datab�zi. Porovn�n� je zalo�eno na "Posledn� aktualizace" nebo �daji CHAN,
                kter� je se s t�mto z�znamem spojen v souboru GEDCOM.</p>

            <span class="optionhead">Importovat m�dia, pokud existuj�</span>
            <p>Pokud v� soubor GEDCOM obsahuje odkazy na m�dia, za�krtnut�m tohoto pol��ka umo�n�te TNG tyto odkazy naimportovat a nastavit p��slu�n� propojen�.
                Mus�te v�ak fyzick� soubory, kter� t�mto odkaz�m odpov�daj�, nakop�rovat na va�e str�nky do p��slu�n�ch slo�ek (nap�. pomoc� FTP). Nechcete-li importovat
                ��dn� m�dia, p�ed zah�jen�m importu toto pol��ko od�krtn�te.</p>

            <span class="optionhead">Za��t ��slovat ID ��sla od prvn�ho voln�ho ��sla/Za��t ��slovat ID ��sla od</span>
            <p>Pokud zvol�te mo�nost "P�idat v�echny z�znamy", zobraz� se v�m tak� tato volba. V�b�rem prvn� mo�nosti vytvo��
                TNG nov� ID ��slo p��choz�ho z�znamu p�id�len�m prvn�ho voln�ho ID ��sla v ka�d� kategorii (osoby, rodiny, prameny, �lo�i�t� pramen�).
                Druhou mo�nost vyberte, pokud chcete, aby TNG vytvo�il pro p��choz� z�znam nov� ID ��slo od ur�it�ho ��sla (stejn� pro ka�dou kategorii).
                Vyberete-li tuto mo�nost, ujist�te se, �e v ur�en�m rozsahu neexistuj� ��dn� z�znamy nebo dojde ke koliz�m.</p>

            <span class="optionhead">Star� styl importu</span>
            <p>P�ed verz� TNG 7 se zobrazoval pr�b�h importu. M�sto toho se na obrazovce opakovan� objevoval po�et importovan�ch osob a rodin.
                Nov� po�et byl v�dy zobrazen vedle star�ho po�tu, tak�e brzy p�es�hl rozm�r str�nky. Li�ta pr�b�hu je �ist�� a n�zorn�j��,
                ale v n�kter�ch p��padech star� import pracoval l�pe, proto�e bylo na obrazovce zobrazeno v�ce �daj�. Pokud ve va�em p��pad� nov� import
                sel�e, m��ete za�krtnut�m t�to volby zkusit, zda star� import neprob�hne l�pe.</p>

            <p>Pokud jste p�ipraveni, klikn�te na tla��tko <strong>Importovat data</strong> a zah�j�te proces. M�li byste vid�t li�tu pr�b�hu a �adu ��ta��, kter� zn�zor�uj�c�ch
                importovan� osoby, rodiny, prameny, pozn�mky a m�sta (pozn.: po��t�na jsou pouze m�sta obsahuj�c� zem�pisn� sou�adnice). Z�v�re�n� zpr�va
                v�m sd�l�, zda byl import �sp�n� dokon�en.</p>

            <span class="optionhead">Funkce "za��t znovu"</span>
            <p>Pokud neuvid�te zpr�vu o "dokon�en�", v� server mo�n� proces importu ukon�il, proto�e trval p��li� dlouho.
                Pokud se v�m to stalo, jd�te na str�nku Admin/Nastaven�/Nastaven� importu
                a za�krtn�te pol��ko <strong>Ulo�it stav importu</strong>. Pak se vra�te na str�nku importu a zkuste v� import znovu. Pokud jsou stejn� podm�nky,
                import by se m�l s�m restartovat.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a name="export"><p class="subheadbold">GEDCOM Export</p></a>
            <p>Tato str�nka v�m umo�n� exportovat sv� data z ur�it�ho stromu do standardn�ho souboru GEDCOM 5.5. Soubor bude ulo�en ve va�� slo�ce
                GEDCOM (ur�ena v Nastaven� importu) a bude pojmenov�n n�zvem stromu a p��ponou ".ged".</p>

            <span class="optionhead">V�tev</span>
            <p>Chcete-li do exportovan�ho souboru GEDCOM vlo�it pouze osoby a rodiny z ur�it� v�tve, m��ete tuto v�tev vybrat z tohoto seznamu.</p>

            <span class="optionhead">Vylou�it �ij�c�/Vylou�it neve�ejn�</span>
            <p>Za�krtnut�m t�chto tla��tek vylou��te �ij�c� nebo neve�ejn� osoby z exportovan�ho souboru GEDCOM.</p>

            <span class="optionhead">Exportovat odkazy na m�dia</span>
            <p>Za�krtnut�m t�to volby vlo��te informace, kter� se vztahuj� ke v�em fotografi�m, vypr�v�n�m a jin�m m�di�m p�ipojen�m k osob�m, rodin�m,
                pramen�m a �lo�i�t�m pramen� ve vybran�m strom�. Tyto informace obsahuj� n�zev souboru, popis a pozn�mky.</p>

            <span class="optionhead">Lok�ln� um�st�n� fotografi�/dokument�/n�hrobk�/vypr�v�n�/zvukov�ch z�znam�/vide�</span>
            <p>Chcete-li p�ipojit ke ka�d�mu souboru m�dia lok�ln� um�st�n� (nap�. "C:\mojefotografie\" nebo "..\genealogie\"), za�krtn�te pol��ko "Exportovat odkazy na m�dia", a pot� do p��slu�n�ho pole
                toto um�st�n� zapi�te (zadat mus�te koncov� lom�tko). Ponech�te-li tyto ��dky pr�zdn�, budou do souboru GEDCOM ke ka�d�mu m�diu ulo�eny pouze n�zev souboru a um�st�n�, kter� jsou v TNG,
                a budou exportov�ny s tagem "FILE".
            </p>

            <span class="optionhead">Funkce "za��t znovu"</span>
            <p>Pokud neuvid�te zpr�vu o "dokon�en�", va�e data nebyla vyexportov�ny kompletn�.
                Pokud neuvid�te ��dn� po�ty, nebo uvid�te po�ty, ale neuvid�te zpr�vu o "dokon�en�", v� server mo�n� proces exportu ukon�il, proto�e trval p��li� dlouho.
                Pokud se v�m to stalo, jd�te na str�nku Admin/Nastaven�/Nastaven� importu
                a za�krtn�te pol��ko <strong>Ulo�it stav importu</strong>. Pak se vra�te zp�t na tuto na str�nku a zkuste v� export znovu. Pokud v� export nedob�hne do konce, budete nyn� moci
                kliknout na odkaz "pokra�ovat" v horn� ��sti str�nky pro znovuzah�jen� exportu.</p>
        </td>
    </tr>

</table>
</body>
</html>

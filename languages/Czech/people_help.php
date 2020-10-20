<?php
include "../../helplib.php";
echo help_header("N�pov�da: Osoby");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="index_help.php" class="lightlink">&laquo; N�pov�da: Za��n�me</a> &nbsp;|&nbsp;
                <a href="families_help.php" class="lightlink">N�pov�da: Rodiny &raquo;</a>
            </p>
            <h2 class="largeheader">N�pov�da: <small>Osoby</small></h2>
            <p class="smaller menu clear-both">
                <a href="#search" class="lightlink">Hledat</a> &nbsp;|&nbsp;
                <a href="#add" class="lightlink">P�idat novou</a> &nbsp;|&nbsp;
                <a href="#edit" class="lightlink">Upravit existuj�c�</a> &nbsp;|&nbsp;
                <a href="#delete" class="lightlink">Vymazat</a> &nbsp;|&nbsp;
                <a href="#review" class="lightlink">P�ezkoumat</a> &nbsp;|&nbsp;
                <a href="#merge" class="lightlink">Slou�it</a>
            </p></td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">
            <a id="search">

                <h4 class="subheadbold">Hledat</h4></a>
            <p>Nalezen� existuj�c�ch osob vyhled�n�m cel�ho nebo ��sti <strong>ID ��sla osoby</strong> nebo <strong>Jm�na</strong>. Pro dal�� z��en�
                va�eho
                hled�n� vyberte strom nebo jednu z dal��ch mo�nost�.
                V�sledkem hled�n� bez zadan�ch voleb a hodnot ve vyhled�vac�ch pol�ch bude seznam v�ech osob ve va�� datab�zi.</p>
            <p>Vyhled�vac� krit�ria, kter� zad�te na t�to str�nce, budou uchov�na, dokud nekliknete na tla��tko <strong>Obnovit</strong>, kter� znovu
                obnov�
                v�echny v�choz� hodnoty.</p>

            <h5>Akce</h5>
            <p>Tla��tko Akce vedle ka�d�ho v�sledku hled�n� v�m umo�n� upravit, vymazat nebo otestovat v�sledek. Chcete-li najednou vymazat v�ce osob,
                za�krtn�te pol��ko ve sloupci
                <strong>Vybrat</strong> u ka�d�ho z�znamu, kter� m� b�t odstran�n, a pot� klikn�te na tla��tko "Vymazat
                ozna�en�" na za��tku seznamu. Pro za�krtnut� nebo vy�i�t�n� v�ech v�b�rov�ch pol��ek najednou
                m��ete pou��t tla��tka <strong>Vybrat v�e</strong> nebo <strong>Vy�istit v�e</strong>.
            </p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="add"><h4 class="subheadbold">P�idat novou osobu</h4></a>
            <p>Chcete-li p�idat novou osobu, klikn�te na z�lo�ku <strong>P�idat nov�</strong> a pot� vypl�te formul��. Dal�� informace jako pozn�mky,
                citace, spojen� a
                dal�� ud�losti, m��ete p�idat po ulo�en� nebo zamknut� z�znamu. V�znam jednotliv�ch pol� je n�sleduj�c�:</p>

            <h5>Strom</h5>
            <p>Pokud m�te pouze jeden strom, vybr�n bude v�dy tento strom. Jinak, pros�m, pro novou osobu vyberte po�adovan� strom.</p>

            <h5>V�tev (voliteln�)</h5>
            <p>P�ipojen� osoby ke "v�tvi" omez� p��stup k informac�m o osob� pro u�ivatele, kte�� jsou spojeni k t�e v�tvi. Je-li definov�na alespo�
                jedna v�tev
                a v� u�ivatelsk� ��et nen� spojen se ��dnou konkr�tn� v�tv�, m��ete novou osobu p�ipojit k v�ce existuj�c�m v�tv�m. Chcete-li v�tev
                vybrat,
                kliknut�m na odkaz "Upravit" se otev�e box se v�emi v�tvemi ve vybran�m strom�. Pro v�b�r v�ce v�tv� pou�ijte kl�vesu Control
                (Windows) nebo Command (Mac).
                Po dokon�en� va�eho v�b�ru p�esu�te kursor my�i mimo okno �prav a toto okno zmiz�.</p>

            <h5>ID ��slo osoby</h5>
            <p>ID ��slo osoby mus� b�t jednozna�n� uvnit� vybran�ho stromu a m�lo by se skl�dat z velk�ho p�smene <strong>I</strong> n�sledovan�ho
                ��slem (nejv�ce 21 ��slic).
                P�i prvn�m zobrazen� str�nky a kdykoli je vybr�n jin� strom, bude dopln�no voln� a jednozna�n� ��slo, ale pokud chcete, m��ete vlo�it
                sv� vlastn� ID ��slo.
                Chcete-li zkontrolovat, zda je va�e ID ��slo jednozna�n�, klikn�te na tla��tko <strong>Zkontrolovat</strong>. Objev� se zpr�va, kter�
                v�m sd�l�, zda je ji� ID ��slo pou�ito nebo ne.
                Chcete-li vygenerovat dal�� jednozna�n� ��slo, klikn�te na <strong>Vygenerovat</strong>. Bude zji�t�no nejvy��� ��slo ve va�� datab�zi
                a p�id�na 1.
                Chcete-li zajistit, �e zobrazen� ID ��slo nen� n�rokov�no jin�m u�ivatelem, zat�mco vy zapisujete data, klikn�te na tla��tko <strong>Zamknout</strong>.
            </p>

            <p><strong>POZN.</strong>: Pou��v�te-li tento program spolu s genealogick�m programem pracuj�c�m na platform�ch PC nebo Mac, kter� u
                nov�ch osob vytv��� tak� ID ��sla,
                D�RAZN� DOPORU�UJEME v�echny tato ��sla v�dy mezi t�mito programy synchronizovat. V�sledkem zanedb�n� t�to �innosti mohou b�t kolize a
                nepou�itelnost
                odkaz� na va�e m�dia. Pokud v� prim�rn� program vytv��� ID ��sla, kter� neodpov�daj� tradi�n�m standard�m (nap�.
                <strong>I</strong> je na konci a ne na za��tku), m��ete konvence, kter� TNG pou��v�, zm�nit v Z�kladn�m nastaven�.</p>

            <h5>Jm�no</h5>
            <p>Zapi�te k�estn� jm�no a/nebo p��jmen� osoby. Druh� jm�na by m�la b�t vlo�ena do k�estn�ho jm�na. Pokud jste nastavili podporu
                p�edpon p��jmen� jako odd�len�ch subjekt� (p�edpony budou b�hem t��d�n� ignorov�ny), zapi�te p�edponu do pole ozna�en�ho jako P�edpona
                p��jmen�.
                <strong>Pozn.:</strong> Pokud toto pole nen� viditeln�, p�ejd�te do Nastaven�/Z�kladn� nastaven� a za�krtn�te volbu o pou�it� p�edpon
                p��jmen�.</p>

            <h5>Pohlav� / P�ezd�vka / Titul / P�edpona / P��pona / Po�ad� jm�na a p��jmen�</h5>
            <p>Zapi�te tolik �daj�, kolik jich zn�te. <strong>P�ezd�vka</strong> je neform�ln� jm�no spojen� n�kdy s osobou.
                <strong>Titul</strong> se pou��v� p�ed jm�nem (nap�. <em>Ing.</em> nebo <em>MUDr.</em>), ale nen� sou��st� jm�na.
                <strong>P�edpona</strong> se pou��v� p�ed jm�nem a obvykle je sou��st�
                jm�na. <strong>P��pona</strong> se pou��v� za jm�nem (nap�. <em>CSc.</em> nebo <em>MBA</em>). <strong>Po�ad� jm�na a p��jmen�</strong>
                m��ete pou��t pro zm�nu zobrazen� po�ad�.
                Po�ad� jm�na a p��jmen� pro v�echny osoby v datab�zi m��ete zm�nit v Nastaven�/Z�kladn� nastaven�.</p>

            <h5>�ij�c�</h5>
            <p>Pokud tato osoba �ije nebo si p�ejete omezit p��stup k �daj�m t�to osoby pouze na u�ivatele, kte�� jsou p�ihl�eni a maj� pr�va
                zobrazovat data �ij�c�ch osob,
                za�krtn�te toto pol��ko.</p>

            <h5>Neve�ejn�</h5>
            <p>Bez ohledu na to, zda tato osoba �ije nebo ne, m��ete p��stupov� pr�va k �daj�m t�to osoby omezit za�krtnut�m t�to volby.
                Informace spojen� s "neve�ejnou" osobou budou moci vid�t pouze u�ivatel� s pr�vy zobrazovat neve�ejn� data.</p>

            <h5>Ud�losti</h5>
            <p>Zapi�te data a m�sta k zobrazen�m standardn�m ud�lostem (pokud je zn�te). Dal�� ud�losti lze p�idat po ulo�en� a zamknut� z�znamu. Data
                v�dy zapisujte
                ve standardn�m genealogick�m form�tu DD MMM RRRR (nap�. <em>18 �no 2008</em>). Informaci o m�st� �a�te za sebou od m�stn�ho po obecnou
                a odd�lujte ka�d� �daj ��rkou
                (nap�. <em>Bludov, �umperk, Olomouck� kraj, �esk� republika</em>), nebo kliknut�m na ikonu "Naj�t" vyberte existuj�c� m�sto (lupa).
                Chcete-li omezit po�et nalezen�ch v�sledk�, p�ed kliknut�m na ikonu Naj�t zapi�te ��st m�sta. V�echny v�sledky budou obsahovat to, co
                jste zapsali jako n�zev m�sta.</p>

            <p><h5>�daje CJKSpd (K�est, Obdarov�n�, Bi�mov�n�, Zasv�cen�)</h5>
            Tyto ud�losti jsou spojeny s ob�ady prov�d�n�mi C�rkv� Je��e Krista Svat�ch posledn�ch dn� (mormonsk� c�rkev, kter� vytvo�ila standard
            GEDCOM).
            <strong>Pozn.:</strong> Nechcete-li vid�t pole spojen� s CJKSpd, jd�te na Nastaven�/Z�kladn� nastaven� a zde tuto mo�nost vypn�te (je
            t�eba se pak odhl�sit a znovu p�ihl�sit).</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="edit"><h4 class="subheadbold">Upravit existuj�c� osobu</h4></a>
            <p>Chcete-li upravit existuj�c� osobu, pou�ijte z�lo�ku <a href="#search">Hledat</a> pro nalezen� osoby, a pot� klikn�te na ikonu Upravit
                vedle t�to osoby.</p>

            <h5>Pozn�mky / Citace / Spojen� / "V�ce"</h5>
            <p>Pozn�mky, citace a spojen� lze p�ipojit k ud�lostem nebo osob� obecn� kliknut�m na p�ipojen� ikony v horn� ��sti str�nky
                nebo vedle ka�d� ud�losti. Ke ka�d� ud�losti m��ete tak� p�idat "v�ce" informac� kliknut�m na ikonu "Plus". Pokud v n�jak� t�to
                kategorii existuj� �daje,
                na odpov�daj�c� ikon� bude v horn�m prav�m rohu zelen� te�ka. Chcete-li zn�t v�ce informac� o ka�d� kategorii, jd�te na odkazy
                n�pov�dy,
                kter� budou viditeln� po kliknut� na tyto ikony.</p>

            <h5>Jin� ud�losti</h5>
            <p>Chcete-li p�idat dal�� ud�losti, klikn�te na tla��tko "P�idat nov�" vedle <strong>Jin� ud�losti</strong>. Viz odkaz <a
                    href="events_help.php">N�pov�da</a> pro v�ce
                informac� o p�id�n� nov�ch ud�lost�. Po p�id�n� ud�losti se pod tla��tkem "P�idat nov�" zobraz� v tabulce kr�tk� shrnut�. Tla��tka
                akc�
                pro ka�dou ud�lost v�m umo�n� ud�lost upravit nebo odstranit, nebo p�idat pozn�mky nebo citace. Po�ad�, ve kter�m se ud�losti zobraz�,
                z�vis� na datu (je-li zaps�no)
                a priorit�, kterou m� dan� typ ud�losti (nen�-li p�ipojeno datum). P�i �prav� typu ud�losti m��ete prioritu zm�nit.

            <p><strong>Pozn�mka</strong>: Pozn�mky, citace pramen�, spojen�, "jin�" ud�losti a "v�ce" informac� se ukl�d� u standardn�ch automaticky.
                Jin� zm�ny (nap�. jm�no nebo
                standardn� ud�losti) se ulo�� kliknut�m na tla��tko Ulo�it na konci str�nky nebo kliknut�m na ikonu Ulo�it na str�nce naho�e. Strom a
                ID ��slo osoby nelze zm�nit.</p>

            <h5>Rodi�e</h5>
            <p>Pokud m� aktu�ln� osoba rodi�e, pod sekc� Ud�losti se bude nach�zet sekce <strong>Rodi�e</strong>. Sekce bude na za��tku zobrazena jako
                z��en� a v z�vork�ch bude
                po�et p�r� rodi��). Chcete-li sekci roz���it a zobrazit v�echny p�ry rodi��, klikn�te na slovo "Rodi�e" nebo na �ipku vedle. N�kter�
                �daje, v�etn� povahy
                vztahu mezi aktu�ln� osobou a ka�d�m p�rem rodi�� lze upravit v ka�d�m bloku. Pokud jste kurzorem my�i nad p�rem rodi��, bude v horn�m
                prav�m rohu
                viditeln� volba <strong>Odpojit</strong>. Chcete-li aktu�ln� osobu odpojit od tohoto p�ru rodi��, klikn�te na tento odkaz.</p>

            <p>Nov� p�r rodi�� k aktu�ln� osob� m��ete p�idat kliknut�m na odkaz <strong>P�idat nov�</strong> vedle sekce
                Rodi�e. V tomto okam�iku se v�m zobraz� zpr�va, kter� se v�s zept�, zda chcete ulo�it nejd��ve va�e zm�ny ("OK" nebo "Storno").
                Pokud vyberete "OK", str�nka bude ulo�ena a octnete se na str�nce Nov� rodina s aktu�ln� osobou jako d�t�tem.
                Pokud zvol�te "Storno", neulo�� se ��dn� zm�ny, ale stejn� budete nasm�rov�ni na str�nku Nov� rodina s aktu�ln� osobou jako d�t�tem.
                Pak budete m�t mo�nost zadat nebo vybrat nov� rodi�e a podrobnosti o nov� rodin�.</p>

            <p>Nov� rodi�e m��ete p�idat tak� v�b�rem volby "P�ej�t na novou rodinu s touto osobou jako d�t�tem" na konci str�nky.</p>

            <h5>Man�el�/Partne�i</h5>
            <p>Pokud m� aktu�ln� osoba n�jak�ho partnera, pod sekc� Rodi�e se bude nach�zet sekce <strong>Man�el�/Partne�i</strong> . Sekce bude na
                za��tku zobrazena jako z��en� a v z�vork�ch bude
                po�et p�r� man�el�/partner�). Chcete-li sekci roz���it a zobrazit v�echny partnery, klikn�te na slova "Man�el�/Partne�i" nebo na �ipku
                vedle. Pokud jste kurzorem my�i nad partnerem, bude v horn�m prav�m rohu
                viditeln� volba <strong>Odpojit</strong> . Chcete-li aktu�ln� osobu odpojit od tohoto partnera, klikn�te na tento odkaz.</p>

            <p>Nov�ho partnera aktu�ln� osoby m��ete p�idat kliknut�m na odkaz <strong>P�idat nov�</strong> vedle sekce
                Partne�i. V tomto okam�iku se v�m zobraz� zpr�va, kter� se v�s zept�, zda chcete ulo�it nejd��ve va�e zm�ny ("OK" nebo "Storno").
                Pokud vyberete "OK", str�nka bude ulo�ena a octnete se na str�nce Nov� rodina s aktu�ln� osobou jako man�elem nebo man�elkou (podle
                pohlav� dan� osoby).
                Pokud zvol�te "Storno", neulo�� se ��dn� zm�ny, ale stejn� budete nasm�rov�ni na str�nku Nov� rodina s aktu�ln� osobou jako partnerem.
                Pak budete m�t mo�nost zadat nebo vybrat nov�ho partnera a podrobnosti o nov� rodin�.</p>

            <p>Nov�ho partnera m��ete p�idat tak� v�b�rem volby "P�ej�t na novou rodinu s touto osobou jako partnerem" na konci str�nky.</p>

            <h5>Po�ad� rodi�� nebo partner�</h5>
            <p>Pokud existuje v�ce partner� nebo p�r� rodi��,
                m��ete jejich po�ad� zm�nit "p�eta�en�m" blok� nahoru nebo dol�. Chcete-li blok p�et�hnout, klikn�te my�� na tla��tko "T�hnout", toto
                tla��tko podr�te, a va�i my� p�esu�te na str�nce nahoru
                nebo dol�. Po p�esunu bloku do po�adovan� pozice tla��tko pus�te. Zm�ny po�ad� budou automaticky ulo�eny.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="delete"><h4 class="subheadbold">Vymazat osobu</h4></a>
            <p>Chcete-li odstranit osobu, pou�ijte z�lo�ku <a href="#search">Hledat</a> pro nalezen� dan� osoby, a pot� klikn�te na ikonu Vymazat
                vedle t�to osoby. Tento ��dek zm�n�
                barvu a pot� po odstran�n� polo�ky zmiz�. Chcete-li najednou odstranit v�ce osob, za�krtn�te pol��ko ve sloupci Vybrat vedle ka�d�
                osoby, kterou
                chcete odstranit, a pot� klikn�te na tla��tko "Vymazat vybran�" na str�nce naho�e</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="review"><h4 class="subheadbold">P�edb�n� prohl�dnut� �prav</h4></a>
            Chcete-li si p�edb�n� prohl�dnout zm�ny proveden� ostatn�mi u�ivateli, klikn�te na z�lo�ku "P�ezkoumat". M��ete se pak rozhodnout, zda
            tyto navrhovan� zm�ny ulo��te nebo odstran�te.
            Zm�ny m��ete prohl�dnout podle stromu nebo podle u�ivatele nebo podle oboj�ho. Po ulo�en� navrhovan�ch zm�n nen� zasl�n ��dn� mail, ale
            pokud nov� zm�ny existuj�, na z�lo�ce P�ezkoumat se objev� hv�zdi�ka (*).</p>

            <h5>Vybrat ud�lost a akci</h5>
            <p>V tabulce, kter� popisuje ud�losti, kter� si p�ejete p�ezkoumat nebo odstranit, vyberte ��dek. Seznam v�sledk� m��ete z��it v�b�rem
                u�ivatele (osoba
                odpov�dn� za navrhovan� zm�ny) a/nebo strom. Po zobrazen� v�sledk� klikn�te na jednu z mo�n�ch akc� nalevo od tohoto ��dku. Chcete-li
                zm�ny p�ezkoumat a
                p��padn� za�lenit do datab�ze, vyberte <em>P�ezkoumat</em>. Chcete-li navrhovan� zm�ny zam�tnout, vyberte <em>Odstranit</em>.</p>

            <h5>P�ezkoumat</h5>
            <p>Na obrazovce P�ezkoumat m��ete prov�st dal�� pot�ebn� zm�ny, v�etn� pozn�mek a pramen�, a pot� klikn�te na "Ulo�it a vymazat" pro
                ulo�en� do datab�ze a odstran�n� do�asn�ho z�znamu. Kliknut�m na "Odm�tnout a vymazat" m��ete rovn� odstranit do�asn� z�znam, ani�
                byste jej ulo�ili,
                nebo m��ete sv� rozhodnut� odlo�it na pozd�j�� dobu kliknut�m na "Odlo�it".</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="merge"><h4 class="subheadbold">Slou�en� osob</h4></a>
            Chcete-li p�ezkoumat a slou�it duplicitn� z�znamy, klikn�te na z�lo�ku "Slou�it". Zde rozhodnete, zda jsou dva z�znamy toto�n� nebo
            ne.</p>

            <h5>Naj�t shodu</h5>
            <p>Vyberte nejprve strom. Nelze slu�ovat osoby z r�zn�ch strom�, vybr�n mus� b�t pouze jeden strom. Potom m�te mo�nost vybrat osobu jako
                v�choz� bod va�eho hled�n� (osoba 1) nebo nechat, aby prvn� shodu osob za v�s nalezl TNG. Chcete-li, aby TNG nalezl v�echny zm�ny,
                nechte pole ID ��slo osoby 1 pr�zdn�</p>

            <p>Pokud jste vybrali osobu jako Osobu 1, m��ete tak� ru�n� vybrat ID ��slo osoby 2. Chcete-li, aby duplicity Osoby 1 nalezl TNG, nechte
                pole ID ��slo osoby 2 pr�zdn�.</p>

            <h5>Porovnat n�sleduj�c� pole</h5>
            <p>Toto jsou krit�ria, kter� TNG pou��v� k ur�en� mo�n�ch duplicit. Standardn� jsou vybr�ny k�estn� jm�no a p��jmen�, co� znamen�, �e tato
                pole
                mus� b�t shodn�, aby mohly b�t dva z�znamy pova�ov�ny za potenci�ln� duplicitn�. Vyberete-li tak� datum narozen�, m�sto narozen�,
                datum �mrt� a/nebo m�sto �mrt�, mus� b�t tak� tato pole shodn�.</p>

            <h5>Jin� mo�nosti</h5>

            <p><em>Odm�tnout pr�zdn�</em> znamen�, �e pr�zdn� pole nebudou br�na v potaz. Nap�. n�kdo s p��jmen�m, ale bez vypln�n�ho k�estn�ho jm�na
                nebude br�n jako shodn� s jin�m z�znamem, pokud je k�estn� jm�no mezi vybran�mi krit�rii.</p>

            <p><em>Pou��t Soundex</em> znamen�, �e p�i porovn�v�n� jmen bude pou�ita funkce MySQL Soundex. V tomto p��pad� bude
                text "Blakely" pova�ov�n za shodn� s textem "Blackley".</p>

            <p><em>Slou�it pozn�mky &amp; citace</em> znamen�, �e pozn�mky a citace osoby 2 budou p�id�ny k pozn�mk�m a citac�m
                osoby 1 u v�ech slu�ovan�ch pol�. Nen�-li tato volba vybr�na a pole osoby 2 je za�krtnuto, pozn�mky a citace osoby 2 k tomuto poli
                budou p�eps�ny
                z�znamy z odpov�daj�c�ho pole osoby 1.</p>

            <p><em>Slou�it m�dia</em> znamen�, �e fotografie a historie osoby 2 budou zachov�ny a p�id�ny k ji� existuj�c�m
                u osoby 1, pokud budou tyto dv� osoby slou�eny. Nen�-li tato volba vybr�na, v�echny odkazy na fotografie, historie a n�hrobky osoby 2
                budou po slou�en� odstran�ny.</p>

            <p><h5>Varov�n�!</h5> Pokud prob�hlo slou�en�, nelze jej vz�t zp�t! <em>P�ed zah�jen�m operace slu�ov�n� proto v�dy
                zaz�lohujte sv� datab�zov� tabulky</em>
            pro p��pad, �e byste dv� osoby slou�ili omylem.</p>

            <h5>Dal�� shoda</h5>
            <p>Najde dal�� mo�n� porovn�n�, kter� nezahrne osobu 1. TNG postoup� seznamem mo�n�ch osob v t��d�n� podle ID ��sla v textov�m form�tu.
                Znamen� to, �e "10" bude po "1", ale p�ed "2".</p>

            <h5>Dal�� duplicita</h5>
            <p>Najde dal�� mo�nou duplicitu k osob� 1. Pokud v�sledkem nen� z�znam, kter� byl zobrazen u osoby 2, znamen� to, �e duplicita nebyla
                nalezena.</p>

            <h5>Porovnat/Obnovit</h5>
            <p>Porovn�n� osoby 1 a osoby 2. Je-li toto porovn�n� ji� zobrazeno, kliknut� na toto tla��tko zp�sob� obnoven� str�nky.</p>

            <h5>Prohodit</h5>
            <p>Osoba 1 se stane osobou 2 a naopak.</p>

            <h5>Slou�it</h5>
            <p>Osoba 2 bude slou�ena s osobou 1. ID ��slo osoby 1 bude zachov�no, stejn� jako ostatn� �daje osoby 1, pokud nejsou za�krtnuta
                odpov�daj�c� pol��ka
                u osoby 2. Nap�. pokud je u osoby 2 za�krtnuto pol��ko vedle data narozen�, bude b�hem slou�en� �daj z tohoto pole zkop�rov�n ze
                z�znamu osoby 2 do z�znamu osoby 1.
                Odpov�daj�c� �daj osoby 1 bude smaz�n. Pol��ka u osoby 2 jsou automaticky za�krtnuta, pokud u osoby 1 nejsou odpov�daj�c� �daje.
                Nen�-li
                pole zobrazeno ani u jedn� osoby, pak v tomto poli neexistuje ��dn� �daj.</p>

            <h5>Upravit</h5>
            <p>�prava z�znamu osoby v nov�m okn�. Po proveden� zm�n mus�te kliknout na Porovnat/Obnovit, aby se zm�ny projevily na obrazovce
                Slou�en�.</p>

        </td>
    </tr>
</table>
</body>
<?php echo "</html>"; ?>

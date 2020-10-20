<?php
include "../../helplib.php";
echo help_header("N�pov�da: Rodiny");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="people_help.php" class="lightlink">&laquo; N�pov�da: Osoby</a> &nbsp;|&nbsp;
                <a href="sources_help.php" class="lightlink">N�pov�da: Prameny &raquo;</a>
            </p>
            <h2 class="largeheader">N�pov�da: <small>Rodiny</small></h2>
            <p class="smaller menu clear-both">
                <a href="#search" class="lightlink">Hledat</a> &nbsp;|&nbsp;
                <a href="#add" class="lightlink">P�idat novou</a> &nbsp;|&nbsp;
                <a href="#edit" class="lightlink">Upravit existuj�c�</a> &nbsp;|&nbsp;
                <a href="#delete" class="lightlink">Vymazat</a> &nbsp;|&nbsp;
                <a href="#review" class="lightlink">P�ezkoumat</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">
            <a id="search"><h4 class="subheadbold">Hledat</h4></a>
            <p>Nalezen� existuj�c�ch rodin vyhled�n�m cel�ho nebo ��sti <strong>ID ��sla rodiny</strong>, <strong>Jm�na otce</strong> nebo <strong>Jm�na
                    matky</strong>.
                Pro dal�� z��en� va�eho hled�n� vyberte strom nebo za�krtn�te "Pouze p�esn� shoda". Volbou "Jm�na otce" budou va�e v�b�rov� krit�ria
                porovn�na se jm�ny v�ech otc�.
                Volbou "Jm�na matky" budou va�e v�b�rov� krit�ria porovn�na se jm�ny v�ech matek. Volbou "Beze jm�na" budete hledat pouze mezi ID
                ��sly rodiny.
                V�sledkem hled�n� bez zadan�ch voleb a hodnot ve vyhled�vac�ch pol�ch bude seznam v�ech osob ve va�� datab�zi.</p>

            <p>Vyhled�vac� krit�ria, kter� zad�te na t�to str�nce, budou uchov�na, dokud nekliknete na tla��tko <strong>Obnovit</strong>, kter� znovu
                obnov� v�echny v�choz� hodnoty.</p>

            <h5>Akce</h5>
            <p>Tla��tko Akce vedle ka�d�ho v�sledku hled�n� v�m umo�n� upravit, vymazat nebo otestovat v�sledek. Chcete-li najednou vymazat v�ce
                z�znam�, za�krtn�te pol��ko ve sloupci
                <strong>Vybrat</strong> u ka�d�ho z�znamu, kter� m� b�t vymaz�n, a pot� klikn�te na tla��tko "Vymazat ozna�en�" na za��tku seznamu.
                Pro za�krtnut� nebo vy�i�t�n� v�ech v�b�rov�ch pol��ek najednou
                m��ete pou��t tla��tka <strong>Vybrat v�e</strong> nebo <strong>Vy�istit v�e</strong> .</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="add"><h4 class="subheadbold">P�idat novou rodinu</h4></a>
            <p>V�razem <strong>Rodina</strong> se v tomto programu rozum� ka�d� spojen� mezi "otcem" a "matkou" (d�ti zde mohou nebo nemus� b�t
                obsa�eny). Pokud byla osoba v�ckr�t sezd�na
                nebo m� d�ti s v�ce partnery, m�li byste pro ka�d� p�r man�el� nebo partner� vytvo�it novou rodinu.</p>

            <p>Chcete-li p�idat novou rodinu, klikn�te na z�lo�ku <strong>P�idat nov�</strong> a pot� vypl�te formul��. N�kter� informace (pozn�mky,
                citace a
                dal�� ud�losti) m��ete p�idat po ulo�en� a zamknut� z�znamu. V�znam jednotliv�ch pol� je n�sleduj�c�:</p>

            <h5>Strom</h5>
            <p>Pokud m�te pouze jeden strom, vybr�n bude v�dy tento strom. Jinak, pros�m, pro novou rodinu vyberte po�adovan� strom.</p>

            <h5>V�tev (voliteln�)</h5>
            <p>P�ipojen� rodiny ke "v�tvi" omez� p��stup k informac�m o rodin� pro u�ivatele, kte�� jsou spojeni k t�e v�tvi. Je-li definov�na alespo�
                jedna v�tev
                a v� u�ivatelsk� ��et nen� spojen se ��dnou konkr�tn� v�tv�, m��ete novou rodinu p�ipojit k v�ce existuj�c�m v�tv�m. Chcete-li v�tev
                vybrat,
                kliknut�m na odkaz "Upravit" se otev�e box se v�emi v�tvemi ve vybran�m strom�. Pro v�b�r v�ce v�tv� pou�ijte kl�vesu Control
                (Windows) nebo Command (Mac).
                Po dokon�en� va�eho v�b�ru p�esu�te kursor my�i mimo okno �prav a toto okno zmiz�.</p>

            <h5>ID ��slo rodiny</h5>
            <p>ID ��slo rodiny mus� b�t jednozna�n� uvnit� vybran�ho stromu a m�lo by se skl�dat z velk�ho p�smene <strong>F</strong> n�sledovan�ho
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
                nov�ch rodin vytv��� tak� ID ��sla,
                D�RAZN� DOPORU�UJEME v�echny tato ��sla v�dy mezi t�mito programy synchronizovat. V�sledkem zanedb�n� t�to �innosti mohou b�t kolize a
                nepou�itelnost
                odkaz� na va�e m�dia. Pokud v� prim�rn� program vytv��� ID ��sla, kter� neodpov�daj� tradi�n�m standard�m (nap�.
                <strong>F</strong> je na konci a ne na za��tku), m��ete konvence, kter� TNG pou��v�, zm�nit v Z�kladn�m nastaven�.</p>

            <h5>Man�el�/Partne�i</h5>
            <p>Kliknut�m na "Naj�t..." vyberte existuj�c� osoby, kter� by m�ly b�t v t�to rodin� <strong>otcem</strong> nebo <strong>matkou</strong>
                nebo kliknut�m na "Vytvo�it"
                vytvo�te nov� osoby. Pokud jste zvolili Vytvo�it, budete moci vlo�it �daje o nov�ch osob�ch bez toho, abyste museli opustit aktu�ln�
                str�nku.
                Po v�b�ru nebo vytvo�en� osoby se v poli Otec nebo Matka objev� jm�no a ID ��slo osoby (nelze upravit p��mo).
                Chcete-li partnera odstranit ze vztahu (nebude odstran�n z datab�ze),
                klikn�te na tla��tko "Odstranit". Pokud chcete upravit z�znam partnera, klikn�te na tla��tko "Upravit".</p>

            <h5>�ij�c�</h5>
            <p>Pokud jeden z partner� �ije nebo si p�ejete omezit p��stup k �daj�m t�to rodiny pouze na u�ivatele, kte�� jsou p�ihl�eni a maj� pr�va
                zobrazovat data �ij�c�ch osob,
                za�krtn�te toto pol��ko.</p>

            <h5>Neve�ejn�</h5>
            <p>Bez ohledu na to, zda je tato rodina ozna�ena jako �ij�c�, m��ete p��stupov� pr�va k �daj�m t�to osoby omezit za�krtnut�m t�to volby.
                Informace spojen� s "neve�ejnou" rodinou budou moci vid�t pouze u�ivatel� s pr�vy zobrazovat neve�ejn� data.</p>

            <h5>Ud�losti</h5>
            <p>Zapi�te data a m�sta k zobrazen�m standardn�m ud�lostem (pokud je zn�te). Dal�� ud�losti lze p�idat po ulo�en� a zamknut� z�znamu. Data
                v�dy zapisujte
                ve standardn�m genealogick�m form�tu DD MMM RRRR (nap�. <em>18 �no 2008</em>). Informaci o m�st� �a�te za sebou od m�stn�ho po obecnou
                a odd�lujte ka�d� �daj ��rkou
                (nap�. <em>Bludov, �umperk, Olomouck� kraj, �esk� republika</em>), nebo kliknut�m na ikonu "Naj�t" vyberte existuj�c� m�sto (lupa).
                Chcete-li omezit po�et nalezen�ch v�sledk�, p�ed kliknut�m na ikonu Naj�t zapi�te ��st m�sta. V�echny v�sledky budou obsahovat to, co
                jste zapsali jako n�zev m�sta.</p>

            <p><h5>�daje CJKSpd (Pe�et�n� s partnerem)</h5>
            Tato ud�lost jsou spojena s ob�adem prov�d�n�m C�rkv� Je��e Krista Svat�ch posledn�ch dn� (mormonsk� c�rkev, kter� vytvo�ila standard
            GEDCOM).
            <strong>Pozn.:</strong> Nechcete-li vid�t pole spojen� s CJKSpd, jd�te na Nastaven�/Z�kladn� nastaven� a zde tuto mo�nost vypn�te (je
            t�eba se pak odhl�sit a znovu p�ihl�sit).</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="edit"><h4 class="subheadbold">Upravit existuj�c� rodinu</h4></a>
            <p>Chcete-li upravit existuj�c� rodinu, pou�ijte z�lo�ku <a href="#search">Hledat</a> pro nalezen� rodiny, a pot� klikn�te na ikonu
                Upravit vedle t�to osoby.</p>

            <h5>Pozn�mky / Citace / "V�ce"</h5>
            <p>Pozn�mky a citace lze p�ipojit k ud�lostem nebo rodin� obecn� kliknut�m na p�ipojen� ikony v horn� ��sti str�nky
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

            <p><strong>Pozn�mka</strong>: Pozn�mky, citace pramen�, "jin�" ud�losti a "v�ce" informac� se ukl�d� u standardn�ch automaticky. Jin�
                zm�ny (nap�.
                standardn� ud�losti) se ulo�� kliknut�m na tla��tko Ulo�it na konci str�nky nebo kliknut�m na ikonu Ulo�it na str�nce naho�e. Strom a
                ID ��slo osoby nelze zm�nit.</p>

            <p><h5>D�ti</h5>
            <p>Kliknut�m na "Naj�t..." vyberte existuj�c� osoby, kter� by m�ly b�t v t�to rodin� d�tmi, nebo kliknut�m na "Vytvo�it"
                vytvo�te nov� d�t�. Pokud jste zvolili Vytvo�it, budete moci vlo�it �daje o nov� osob� bez toho, abyste museli opustit aktu�ln�
                str�nku.
                Po v�b�ru nebo vytvo�en� osoby se v seznamu d�t� jm�no, ID ��slo a datum narozen� osoby (nelze upravit p��mo). Tento seznam nelze
                upravovat p��mo, ale pro odstran�n� d�t�te ze seznamu m��ete pou��t odkaz "Odstranit" (viditeln�, kdy� p�esunete kurzor my�i nad ka�d�
                d�t�). Pou��t
                m��ete tak� odkaz "Vymazat" pro �pln� vymaz�n� d�t�te z datab�ze. M��ete pou��t tla��tko "Vymazat" pro vymaz�n� d�t�te z datab�ze
                nebo tla��tko "Upravit" pro �pravu z�znamu d�t�te.</p>

            <h5>Po�ad� d�t�</h5>
            <p>Pokud existuje v�ce d�t�,
                m��ete jejich po�ad� zm�nit "p�eta�en�m" blok� nahoru nebo dol�. Chcete-li blok p�et�hnout, klikn�te my�� na tla��tko "T�hnout", toto
                tla��tko podr�te, a va�i my� p�esu�te na str�nce nahoru
                nebo dol�. Po p�esunu bloku do po�adovan� pozice tla��tko pus�te. Zm�ny po�ad� budou automaticky ulo�eny.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="delete"><h4 class="subheadbold">Vymazat rodinu</h4></a>
            <p>Chcete-li odstranit rodinu, pou�ijte z�lo�ku <a href="#search">Hledat</a> pro nalezen� rodiny, a pot� klikn�te na ikonu Odstranit vedle
                t�to rodiny. Tento ��dek zm�n�
                barvu a pot� po odstran�n� rodiny zmiz� (partne�i a d�ti nebudou odstran�ni, ale vztah bude rozpojen). Chcete-li najednou odstranit
                v�ce rodin, za�krtn�te pol��ko ve sloupci Vybrat vedle ka�d� rodiny, kterou
                chcete odstranit, a pot� klikn�te na tla��tko "Vymazat ozna�en�" na str�nce naho�e</p>

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

</table>
</body>
<?php echo "</html>"; ?>

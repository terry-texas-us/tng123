<?php
include("../../helplib.php");
echo help_header("N�pov�da: Testy DNA");
?>

<body class="helpbody">
<a name="top"></a>
<table width="100%" border="0" cellpadding="10" cellspacing="2" class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right" class="smaller menu">
                <a href="https://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp; | &nbsp;
                <a href="https://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br/>
                <a href="reports_help.php" class="lightlink">&laquo; N�pov�da: Reporty</a> &nbsp; | &nbsp;
                <a href="languages_help.php" class="lightlink">N�pov�da: Jazyky &raquo;</a>
            </p>
            <span class="largeheader">N�pov�da: Testy DNA</span>
            <p class="smaller menu">
                <a href="#search" class="lightlink">Hledat</a> &nbsp; | &nbsp;
                <a href="#add" class="lightlink">P�idat nov�</a> &nbsp; | &nbsp;
                <a href="#edit" class="lightlink">Upravit existuj�c�</a> &nbsp; | &nbsp;
                <a href="#ydna" class="lightlink">Pole Y-DNA</a> &nbsp; | &nbsp;
                <a href="#mtdna" class="lightlink">Pole mtDNA</a> &nbsp; | &nbsp;
                <a href="#atdna" class="lightlink">Pole atDNA</a> &nbsp; | &nbsp;
                <a href="#common" class="lightlink">Spole�n� pole</a> &nbsp; | &nbsp;
                <a href="#delete" class="lightlink">Vymazat</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a name="search"><p class="subheadbold">Hledat</p></a>
            <p>Nalezen� existuj�c�ch test� vyhled�n�m cel�ho nebo ��sti <strong>ID osoby</strong> nebo <strong>jm�na</strong>. Pro dal�� z��en� v�sledk� va�eho hled�n� vyberte strom nebo jin� mo�nosti.
                V�sledkem hled�n� bez zadan�ch voleb a hodnot ve vyhled�vac�ch pol�ch bude seznam v�ech osob ve va�� datab�zi.</p>

            <p>Vyhled�vac� krit�ria, kter� zad�te na t�to str�nce, budou uchov�na, dokud nekliknete na tla��tko <strong>Obnovit</strong>, kter� znovu obnov� v�echny v�choz� hodnoty.</p>

            <span class="optionhead">Akce</span>
            <p>Tla��tko Akce vedle ka�d�ho v�sledku hled�n� v�m umo�n� upravit, odstranit nebo otestovat tento v�sledek. Chcete-li najednou vymazat v�ce z�znam�, za�krtn�te pol��ko ve sloupci
                <strong>Vybrat</strong> u ka�d�ho z�znamu, kter� m� b�t vymaz�n a pot� klikn�te na tla��tko "Vymazat ozna�en�" na za��tku seznamu. Pro za�krtnut� nebo vy�i�t�n� v�ech v�b�rov�ch pol��ek najednou
                m��ete pou��t tla��tka <strong>Vybrat v�e</strong> nebo <strong>Vy�istit v�e</strong>.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="add"><p class="subheadbold">P�id�n� nov�ch test�</p></a>
            <p>Chcete-li p�idat nov� test, klikn�te na z�lo�ku <strong>P�idat nov�</strong>, a vypl�te formul��. Po ulo�en� m��e b�t test p�ipojen k osob� v datab�zi.</p>
            <p>Pole mohou z�stat pr�zdn� a nebudou ve v�t�in� p��pad� zobrazeny.</p>

            <span class="optionhead">Typ testu</span>
            <p>Vyberte typ testu DNA, na kter� tento z�znam odkazuje. (Toto je jedin� povinn� pole)</p>

            <span class="optionhead">��slo testu/n�zev</span>
            <p>Zapi�te ID ��slo spojen� s t�mto testem. Pokud nem��ete ��slo naj�t nebo v�m jej dodavatel nedal, nebojte se vytvo�it ��slo nov�. <br/><strong>V�imn�te si, </strong>�e pokud nezad�te hodnotu do pole ��slo testu/n�zev, nebudete m�t k
                dispozici rychl� odkaz pro �pravu dat DNA z obrazovky prohl�en� DNA, jako je browse_dna_tests.php.</p>

            <span class="optionhead">Dodavatel</span>
            <p>Zadejte n�zev spole�nosti, kter� test provedla.</p>

            <span class="optionhead">Datum testu</span>
            <p>Toto je datum, kdy byl test DNA proveden.</p>

            <span class="optionhead">Datum shody</span>
            <p>Toto je datum, kdy byla zji�t�na shoda va�eho testu s osobou, kter� byl test DNA proveden.</p>

            <span class="optionhead">GEDmatch ID</span>
            <p>��slo ID tohoto testu na webu GEDmatch. Plat� pouze pro testy atDNA.</p>

            <span class="optionhead">Ponechat test neve�ejn�</span>
            <p>Pokud zad�te do pole Ponechat test neve�ejn� Ano, zobrazen� testu bude omezeno pouze na p�ihl�en� u�ivatele, kte�� maj� p��stupov� pr�va nastaven� na <strong>Povolit neve�ejn�</strong>. To umo�n� omezit p��stup k test�m DNA, kter� jste
                ozna�ili jako Ponechat test neve�ejn�. Test bude viditeln� pro administr�tora TNG.</p>

            <span class="optionhead">Testovan� osoba</span>
            <p>Jedn� se o osobu, kter� pat�� test. Vyberte strom a zapi�te ID osoby nebo klikn�te na lupu a vyhledejte osobu podle jm�na. NEBO m��ete zadat jm�no osoby, kter� nen� ve va�� datab�zi.</p>

            <span class="optionhead">Ponechat jm�no neve�ejn�</span>
            <p>Pokud je za�krtnuto toto pol��ko, jm�no uveden� jako "testovan� osoba" se bude zobrazovat jako "Neve�ejn�". Jm�no bude viditeln� pro administr�tora TNG.</p>

            <span class="optionhead">P�idat test ke skupin�</span>
            <p>Test m��ete p�i�adit ke d��ve vytvo�en� skupin� test� DNA.<br/>Chcete-li vytvo�it skupinu test� DNA, p�ejd�te na str�nku Administrace >> Testy DNA >> a klikn�te na kartu Skupiny DNA. Pot� klikn�te na z�lo�ku P�idat skupinu.</p>

            <span class="optionhead">Skupiny DNA</span>
            <p>Skupiny DNA se pou��vaj� k v�b�ru nebo filtrov�n� test� DNA nebo typ� test� v seznamu. M��ete nap��klad vytvo�it skupinu pro va�i otcovskou linii a dal�� skupinu pro mate�skou linii. Skupiny DNA jsou jen zp�sob, jak filtrovat seznam test�.
                Propojen� test� se skupinou je nepovinn�. Pov�imn�te si, �e skupiny DNA jsou nyn� spojeny s typem testu a pro dva r�zn� typy test� nem��ete pou��t stejn� n�zev skupiny DNA.</p>

            <span class="optionhead">Haploskupina</span>
            <p>Haploskupina je genetick� populace lid�, kte�� sd�lej� spole�n�ho p�edka v otcovsk� nebo mate�sk� linii. Haploskupiny jsou ozna�eny p�smeny abecedy (A-T) a jejich up�esn�n� (SNP) obsahuje dal�� kombinace ��slic a p�smen. K dispozici jsou dv�
                samostatn� vstupn� pole, proto�e n�kter� testovac� spole�nosti poskytuj� u test� atDNA ob� odhadovan� haploskupiny nebo si testovan� osoba m��e nechat zhotovit test mtDNA i Y-DNA.</p>
            <p>Pole <strong>Haploskupina mtDNA</strong> je ur�eno pro matriline�ln� haploskupinu, kter� je b�n� v�sledkem testu mtDNA.</p>
            <p>Pole <strong>Haploskupina Y-DNA</strong> je ur�eno pro patriline�ln� haploskupinu, kter� je b�n� v�sledkem testu Y-DNA.</p>
            <p>N�kter� testovac� spole�nosti poskytuj� ve sv�ch testech atDNA haploskupiny mtDNA a Y-DNA. Family Tree DNA toto poskytuje, pokud byly provedeny odpov�daj�c� testy mtDNA a Y-DNA. Ostatn� testovac� spole�nosti p�edpov�daj�, jak� haploskupiny
                mohou b�t.</p>

            <p>Za�krt�vac� pol��ko Potvrzeno slou�� k ozna�en�, �e test poskytl potvrzenou haploskupinu na rozd�l od p�edpokl�dan�. Proto�e haploskupina se skl�d� z podobn�ch haplotyp�, je mo�n� p�edpov�d�t haploskupinu z haplotypu. Pro potvrzen�
                p�edpov�di haploskupiny je vy�adov�n test SNP. Ne v�echny testovac� spole�nosti nab�zej� test SNP, proto jejich p�edpov�di haploskupiny z�kazn�ka jsou n�kdy nep�esn�.</p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="ydna"><p class="subheadbold">Pole v�sledk� test� Y-DNA</p></a>

            <p>Otcovskou linii dan�ho mu�e lze stopovat prost�ednictv�m DNA obsa�en� v jeho chromoz�mu Y (Y-DNA). Test Y-DNA spo��v� v anal�ze segment� DNA chromoz�mu Y (p��tomn�m pouze u mu��), zvan�ch kr�tk� tandemov� repetice (STR z anglick�ho Short
                Tandem Repeat). Testovan� segmenty jsou ozna�ov�ny jako markery a nach�zej� se v nek�duj�c� ��sti DNA. STR vyjad�uj� zm�nu po�tu opakov�n� dan�ho segmentu DNA.</p>

            <p><strong>Po�et marker�</strong></p>
            <p>Genetick� marker je gen nebo sekvence DNA se zn�m�m um�st�n�m na chromozomu, kter� m��e b�t pou�it k identifikaci jednotlivce. Testy DNA se mohou li�it podle po�tu marker�, kter� se testuj�.<br/>Typick� testy Y-DNA mohou b�t provedeny na 12,
                25, 37, 44, 67, 91, 101 nebo 111 marker�.<br/>Vzhledem k tomu, �e Family Tree DNA je v sou�asn� dob� jedin�m dodavatelem nab�zej�c�m testy Y-DNA, je ve porovn�vac�m reportu Y-DNA pou�ito 12, 25, 37, 67 a 111 marker�.</p>

            <span class="optionhead">Hodnoty marker�</span>
            <p>Zadejte hodnoty va�eho Y-DNA markeru odd�len� ��rkou. Nap��klad: "13,24,14,10,11-14,12,12,12,13,14,30,17,9-10,11,11,24,15,19,30,15-15-16-17" (bez uvozovek).<br/>nebo s mezerami za ��rkou pro lep�� �itelnost, "13, 24, 14, 10, 11-14, 12, 12,
                12, 13, 14, 30, 17, 9-10, 11, 11, 24, 15, 19, 30,1 5-15-16-17" (bez uvozovek).</p>
            <p>V�imn�te si, �e Y-DNA markery, kter� maj� rozsah hodnot, mus� b�t zad�ny pomoc� poml�ky mezi hodnotami, proto�e rozsah hodnot m��e b�t prom�nn�</p>

            <strong>SNP</strong>
            <p>SNP (jednonukleotidov� polymorfismus) se vyskytne, kdy� se v pr�b�hu procesu tvorby bun�k zm�n� jedno m�sto v sekvenci genomu a tato mutace v potomstvu p�etrv�. Osoba m� mnoho zd�d�n�ch SNP, kter� spole�n� tvo�� pro dan�ho jedince unik�tn�
                (UEP) vzor DNA.</p>
            <p>V genetick� genealogii je unik�tn� polymorfismus (UEP) genetick�m markerem, kter� odpov�d� mutaci, kter� se pravd�podobn� vyskytuje tak z��dka, �e se p�edpokl�d�, �e je naprosto pravd�podobn�, �e v�ichni jedinci, kte�� sd�lej� tento marker
                po cel�m sv�t�, ji d�d� od shodn�ho spole�n�ho p�edka a shodn� ud�losti jednotliv� mutace.</p>

            <p><strong>Signifikantn� SNPs</strong></p>
            <p>Tyto SNP mohou klinicky souviset, souviset s americk�mi indi�ny, apod.</p>

            <p><strong>Termin�ln� SNP</strong></p>
            <p>Termin�ln� SNP je definovan� SNP posledn� (koncov�) v�tve haploskupiny rozpoznan� aktu�ln�m v�zkumem. M�l by b�t jedine�n� a konstantn� v �ase. N�kdy se "termin�ln� SNP" pou��v� k ozna�en� SNP, pro kter� byl �lov�k naposledy testov�n.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="mtdna"><p class="subheadbold">Pole v�sledk� test� mtDNA</p></a>

            <p>Mate�skou linii p�edk� lze stopovat pomoc� <span class="optionhead">mitochondri�ln� DNA (mtDNA)</span>. Dle sou�asn�ch konvenc� je mtDNA rozd�lena do t�� oblast�. T�mi jsou k�duj�c� oblast a dv� hypervariabiln� oblasti (HVR1 a HVR2)

            <ul>
                <li><strong>HVR1</strong>, ve kter� jsou nukleotidy ��slov�ny v rozsahu od 16001 do 16569.</li>
                <li><strong>HVR2</strong>, ve kter� jsou nukleotidy ��slov�ny v rozsahu od 00001 do 00574.</li>
                <li><strong>K�duj�c� oblast (CR)</strong> je ��st va�� mtDNA, ve kter� jsou nukleotidy ��slov�ny v rozsahu od 00575 do 16000.</li>
            </ul>
            </p>
            <p>V�ce informac� o mtDNA lze naj�t nap�. na str�nk�ch <a href="https://www.familytreedna.com/learn/mtdna-testing/parts-mitochondrial-dna-mtdna-hvr1-hvr2-coding-region/" target="_blank">The Family Tree DNA Learning Center</a></p>

            <p><strong>Referen�n� sekvence</strong></p>
            <p> V pol�ch v�sledk� testu mtDNA m��ete vybrat jednu ze dvou referen�n�ch sekvenc�. Family Tree DNA poskytuje ob� sekvence, tak�e je t�eba zvolit, jakou verzi v�sledk� zad�te do vstupn�ch pol�.
            <ul>
                <li><strong>RSRS</strong> - Reconstructed Sapiens Reference Sequence je referen�n� sekvence mitochondri�ln� DNA (mtDNA), kter� vyu��v� jak glob�ln� vzorkov�n� modern�ch lidsk�ch vzork�, tak vzork� star�ch hominid�. Byla p�edstavena po��tkem
                    roku 2012 jako n�hrada za rCRS (revised Cambridge Reference Sequence). RSRS zachov�v� stejn� syst�m ��slov�n� jako CRS, ale zastupuje d�di�n� genom mitochondri�ln� Evy, ze kter�ho poch�zej� v�echny sou�asn� zn�m� lidsk� mitochondrie.
                </li>

                <li><strong>rCRS</strong> - Revised Cambridge Reference Sequence pro lidskou mitochondri�ln� DNA byla p�edstavena v roce 1981 a vedla k zah�jen� projektu lidsk�ho genomu.</li>
            </ul>
            </p>

            <p><span class="optionhead">Rozd�ly HVR1/HVR2/K�duj�c� oblast, Zvl�tn� mutace</span></p>
            <p>Zadejte v�sledky sv�ho testu mtDNA odd�len� ��rkou.<br/>Nap��klad: "A16129G,T16187C,C16189T,T16223C,G16230A,T16278C,C16311T,C16519T".<br/>V�sledek m��ete tak� zadat s mezerami za ��rkou pro lep�� �itelnost, nap��klad "A16129G, T16187C,
                C16189T, T16223C, G16230A, T16278C, C16311T, C16519T" (bez uvozovek)</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="atdna"><p class="subheadbold">Pole v�sledk� test� atDNA</p></a>

            <p><span class="optionhead">Autozom�ln� DNA (atDNA) </span> testuje va�e autozom�ln� chromoz�my, co� je dal��ch 22 p�r� za pohlavn�mi chromozomy X a Y. Testy autozom�ln� DNA mohou pomoci identifikovat p��buzn�, kte�� sd�lej� ned�vn� p�edky. ��m
                v�ce segment� sd�l�te a ��m v�t�� je d�lka t�chto segment�, t�m v�ce jste sp��zn�ni.</p>

            <p><strong>Sd�len� DNA</strong><br/>
                Sd�len� segmenty DNA, ozna�ovan� tak� jako "odpov�daj�c� segmenty", jsou ��sti DNA, kter� jsou shodn� mezi dv�ma jednotlivci. Tyto segmenty byly pravd�podobn� zd�d�ny od spole�n�ho p�edka. P�i rozhodov�n� o tom, kter� shody DNA budete
                sledovat, postupujte podle t�ch s v�ce ne� jedn�m velk�m segmentem; to jsou va�e bl�zc� p��buzn�, ti, jejich� stromy se snadn�ji spoj� s va�imi.</p>

            <p><strong>Celkov� sd�len� cM</strong><br/>
                Toto je sou�et autosom�ln� DNA, dan� v centimorgans (cM), kter� vy a va�e genetick� shoda sd�l�te.<br/>Viz <a href="https://dnapainter.com/tools/sharedcmv4" traget="_blank">The Shared cM Project Tool</a>, kde je v�ce informac� o
                pravd�podobnosti zp��zn�nosti na z�klad� po�tu celkov�ho po�tu sd�len�ch cM.</p>

            <p><strong>Sd�len� segmenty</strong><br/>
                Po�et sd�len�ch segment� v t�to sd�len� shod� DNA. ��m v�ce segment� sd�l�te a ��m v�t�� je d�lka t�chto segment�, t�m v�ce jste zp��zn�ni.</p>

            <p><strong>Nejv�t�� segment</strong><br/>
                Segmenty, kter� spole�n� sd�lej� velk� mno�stv� centiMorgan�, jsou s v�t�� pravd�podobnost� v�znamn� a ozna�uj� v genealogick�m �asov�m r�mci spole�n�ho p�edka. Toto je nejv�t�� sd�len� segment v t�to shod� DNA.</p>

            <p><strong>Chromoz�m �.</strong><br/>
                Toto je ��slo chromoz�mu nejv�t��ho shodn�ho segmentu.</p>

            <p><strong>Za��tek segmentu</strong><br/>
                Toto je po��te�n� m�sto nejv�t��ho shodn�ho sd�len�ho segmentu DNA</p>

            <p><strong>Konec segmentu</strong><br/>
                Toto je kone�n� m�sto nejv�t��ho shodn�ho sd�len�ho segmentu DNA</p>

            <p><strong>centiMorgany</strong><br/>
                V genetick� genealogii je centiMorgan (cM) nebo mapov� jednotka (m.u.) jednotkou frekvence rekombinace, kter� se pou��v� k m��en� genetick� vzd�lenosti. Toto je po�et cM v nejv�t��m shodn�m segmentu.</p>

            <p><strong>Po�et shodn�ch SNP</strong><br/>
                To je po�et SNP pro nejv�t�� shodn� segment.</p>

            <p><strong>X-shoda</strong><br/>
                Toto pole ud�v�, zda se autosom�ln� DNA shoduje tak� na chromoz�mu X.</p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="common"><p class="subheadbold">Spole�n� pole v�sledk� test�</p></a>

            <p>N�sleduj�c� pole jsou spole�n� pro v�echny typy test�</p>

            <span class="optionhead">Nejvzd�len�j�� p�edek</span>
            <p>Zadejte nejvzd�len�j��ho otcovsk�ho (Y-DNA) nebo mate�sk�ho (mtDNA) p�edka testovan� osoby. R�zn� osoby s testy Y-DNA a mtDNA mohou m�t r�zn� nejvzd�len�j�� p�edky v z�vislosti na tom, jak daleko do minulosti existuje jejich pap�rov�
                stopa.</p>

            <span class="optionhead">Nejbli��� spole�n� p�edek</span>
            <p>Zadejte ID osoby nejbli���ho spole�n�ho p�edka (MRCA). MRCA je sd�len� spole�n� p�edek mezi dv�mi nebo v�ce testovan�mi osobami. MRCA se m��e li�it v z�vislosti na tom, kde se mezi testovan�mi osobami setkaj� jejich linie.</p>

            <span class="optionhead">Rodov� p��jmen�</span>
            <p>Toto pole se vztahuje na v�echny typy test� a bude automaticky vypln�no rodov�mi p��jmen�mi osoby, u kter� byly provedeny testy Y-DNA a mtDNA, odd�len�mi ��rkami<br/>Dopln�n� p��jmen� z�vis� na typu testu a m��ete je jak�mkoli zp�sobem
                upravit. <br/>V Administrace >> Nastaven� >> Konfigurace >> Z�kladn� nastaven� >> Testy DNA je mo�nost vylou�en� p��jmen� jako je nezn�m� nebo NEZN�M�, a mo�nost zobrazit p��jmen� velk�mi p�smeny.<br/>Nyn� je tak� mo�nost zvolit, z kolika
                generac� va�eho rodokmenu se u test� atDNA vr�t� rodov� p��jmen�.</p>

            <span class="optionhead">Pozn�mky</span>
            <p>Zapi�te pozn�mky spojen� s t�mto testem nebo jak�koli jin� informace.</p>

            <span class="optionhead">Pozn�mky administr�tora</span>
            <p>Tot� jako pozn�mky, ale pouze pro zobrazen� u�ivatel�m s pr�vy administr�tora.</p>

            <span class="optionhead">Odpov�daj�c� odkazy</span>
            <p>Pokud existuj� webov� str�nky spojen� s t�mto testem, zadejte je zde. Ka�d� odkaz zadejte na nov� ��dek. Zapi�te str�nky nebo n�zev str�nek a adresu URL,
                odd�len� ��rkou. Nap��klad, "Ancestry.com, https://www.ancestry.com". Pokud nevlo��te str�nky nebo n�zev str�nek, bude odkaz samo o sob� pou�it jako n�zev.</p>

            <span class="optionhead">M�dia</span>
            <p>Zde m��ete k testu p�i�adit fotografie zad�n�m mediaID pro ka�dou fotografii.<br/>V�ce z�znam� odd�lte ��rkou. Nap��klad: "4361,5992"</p>

            <span class="optionhead">Informace o testu k zobrazen�</span>
            <p>Vedle informac� za�krtn�te pol��ko, kter� chcete zobrazit na str�nce osoby (getperson.php).<br/>Na str�nce ka�d�ho testu se zobraz� v�echny zapsan� informace (show_dna_test.php).</p>

            <p>Po dokon�en� klikn�te na tla��tko "Ulo�it" a vr�t�te se zp�t na seznam.</p>

            <p>Dal�� informace (v angli�tin�) najdete na t�chto str�nk�ch TNG Wiki:</p>
            <ul>
                <li><a href="https://tng.lythgoes.net/wiki/index.php/DNA_Tests" target="_blank">DNA Tests<a></li>
                <li><a href="https://tng.lythgoes.net/wiki/index.php/TNG_and_DNA_Tests" target="_blank">TNG and DNA Tests<a></li>
                <li><a href="https://tng.lythgoes.net/wiki/index.php/DNA_Tests_Enhancements?" target="_blank">DNA Tests Enhancements?<a></li>
                <li><a href="https://tng.lythgoes.net/wiki/index.php/Compare_DNA_Test_Results?" target="_blank">Compare DNA Test Results?<a></li>
            </ul>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="edit"><p class="subheadbold">�prava existuj�c�ch test�</p></a>
            <p>Chcete-li upravit existuj�c� test, pou�ijte z�lo�ku <a href="#search">Hledat</a> pro nalezen� testu, a pot� klikn�te na ikonu Upravit vedle tohoto testu.</p>

            <span class="optionhead">Odkazy na test</span>
            <p>Tento test m��ete p�ipojit k osob�m ve va�� datab�zi. U ka�d�ho p�ipojen� zvolte nejprve strom, ke kter�mu je jedinec p�ipojen.
                Pot� zadejte ID ��slo osoby, ke kter� chcete test p�ipojit, a pak kliknut�m na tla��tko "P�idat" vytvo��te spojen�.</p>

            <p>Nezn�te-li ID ��slo, kliknut�m na ikonu lupy jej vyhledejte. Objev� se vyskakovac� okno, ve kter�m provedete vyhled�n�.
                Po nalezen� po�adovan� osoby klikn�te na n�zev osoby, ��m� p�id�te jej� ID do boxu pro p�id�n�, a pot� klikn�te na tla��tko "P�idat", viz v��e.</p>
            <p>Osoba, u kter� byl proveden test, nen� automaticky s testem spojena. Mus�te vytvo�it odkaz.</p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="delete"><p class="subheadbold">Vymaz�n� existuj�c�ch test�</p></a>
            <p>Chcete-li odstranit test, pou�ijte z�lo�ku <a href="#search">Hledat</a> pro nalezen� testu, a pot� klikn�te na ikonu Vymazat vedle tohoto testu. Tento ��dek zm�n�
                barvu a pot� po odstran�n� m�sta zmiz�. Chcete-li najednou odstranit v�c test�, za�krtn�te pol��ko ve sloupci Vybrat vedle ka�d�ho testu, kter�
                chcete odstranit, a pot� klikn�te na tla��tko "Vymazat ozna�en�" na str�nce naho�e</p>

        </td>
    </tr>

</table>
</body>
</html>

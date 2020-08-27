<?php
include "../../helplib.php";
echo help_header("N�pov�da: Mana�er m�d�");
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
        <a href="https://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp; | &nbsp;
        <a href="https://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
        <a href="backuprestore_help.php" class="lightlink">&laquo; N�pov�da: Obslu�n� programy</a> &nbsp; | &nbsp;
        <a href="index_help.php" class="lightlink">N�pov�da: Za��n�me &raquo;</a>
      </p>
      <span class="largeheader">N�pov�da: Mana�er m�d�
        </span>
      <p class="smaller menu">
        <a href="#overview" class="lightlink">P�ehled</a> &nbsp; | &nbsp;
        <a href="#operation" class="lightlink">Operace</a> &nbsp; | &nbsp;
        <a href="#status" class="lightlink">Stav</a> &nbsp; | &nbsp;
        <a href="#syntax" class="lightlink">Syntaxe m�d�</a> &nbsp; | &nbsp;
                <a href="#files" class="lightlink">Konfigura�n� soubory</a> &nbsp; | &nbsp;
                <a href="#batch" class="lightlink">D�vkov� operace</a> &nbsp; | &nbsp;
                <a href="#options" class="lightlink">Mo�nosti</a> &nbsp; | &nbsp;
                <a href="#analyze" class="lightlink">Anal�za soubor� TNG</a> &nbsp; | &nbsp;
                <a href="#parser" class="lightlink">Tabulka parseru</a> &nbsp; | &nbsp;
                <a href="#custtext" class="lightlink">Doporu�en� aktualizace</a>

            </p></td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">
            <a name="overview"><p class="subheadbold">P�ehled</p></a>
            <p>Mana�er m�d� TNG verze 12 je zalo�en na Mana�eru m�d�, kter� byl p�vodn� vyvinut Brianem McFadyenem, n�sledn� zaktualizov�n Seanem Schwoerem pro pr�ci s Joomla TNG Component
                a ve verzi 10.0.3 a 10.1 zaktualizov�n o integrovan�j�� zp�sob instalace, odstran�n� a ��zen� zm�n softwarov�ho bal�ku TNG.</p>
            <p>Nov� Mana�er m�d� nab�z� jednoduch� ��dkov� souhrn stav� m�d�, kter� m��e b�t roz���en na zobrazen� kompletn�ho popisu a chyb.
                Seznam soubor�, kter� dan� m�d ovliv�uje, lze zobrazit p�ejet�m kursorem my�i nad znam�nkem + ve sloupci Soubory.
                K rozbalen� v�ech z�znam� a zobrazen� stavu m��ete podobn� jako ve star�m Mana�eru m�d� pou��t tak� tla��tko <strong>Rozbalit v�e</strong> v horn�m menu.
                Volba Rozbalit v�e je u�ite�n� p�i filtrov�n� seznamu na stavy <strong>��ste�n� nainstalov�no</strong> nebo <strong>Nelze nainstalovat</strong>, tak�e m��ete vid�t chyby, kter� se
                zde objevuj�.</p>
            <p>Mana�er m�d� je pro snaz�� p��stup p�id�n na str�nku Administrace TNG. Mana�er m�d� vytv��� v TNG tyto slo�ky:
            <ul>
                <li><strong>mods</strong> obsahuje konfigura�n� soubory m�d� a p�idru�en� podp�rn� soubory m�d�. Slo�ka mods m��e b�t p�ejmenov�na. Mana�er m�d� pou��v� pro pr�ci s n�zvem slo�ky prom�nnou $modspath.</li>
                <li><strong>extensions</strong> obsahuje n�kter� roz���en� m�d�, kter� jsou instalov�ny jin�mi konfigura�n�mi soubory mana�eru m�d�. Slo�ka extensions m��e b�t p�ejmenov�na. Mana�er m�d� pou��v� pro pr�ci s n�zvem slo�ky prom�nnou
                    $modspath.
                </li>
                <li><strong>classes</strong> obsahuje t��dy Objektov� orientovan�ho programov�n� (Object Orient Progamming classes), kter� byly rozd�leny a vylep�eny z p�edchoz�ho souboru managemods.class.php, kter� vytvo�il Sean Schwoere z p�vodn� k�du
                    Mana�eru m�d� od Briana McFadyena.
                </li>
            </ul>
            </p>

            <p>Z�lo�ka <strong>Seznam m�d�</strong> nyn� spojuje p�edchoz� Seznam m�d� a D�vkov� instalace, kter� do TNG 10.0.3 p�idal Rick Bisbee, a umo��uje vykonat stejnou akci pro v�ce m�d�. Popis a roz���en� stav lze zobrazit pomoc� kliknut� na �ipku
                vpravo ve sloupci Stav nebo kdekoli na ��dku. P�ejet�m kurzorem my�i nad ��dkem se zv�razn� ��dek a usnadn� se tak v�b�ru stavu pro roz���en� zobrazen�. P�ejet�m kurzoru my�i p�es znam�nko + ve sloupci Soubory se zobraz� seznam soubor�,
                kter� dan� m�d m�n�, vytv��� nebo kop�ruje.</p>
            <p>Pokud je povolena mo�nost Zobrazit dal�� n�stroje pro v�voj��e, TNG v12 p�id�v� n�sleduj�c� zm�ny:
            <ul>
                <li>kliknut�m na n�zev souboru se otev�e tabulka parseru pro tento m�d</li>
                <li>kliknut�m na n�zev souboru cfg se zobraz� soubor cfg na jin� z�lo�ce</li>
                <li>tla��tko <strong>Podrobnosti</strong> v bu�ce Stav funguje jako p�ep�na� pro rozbalen� nebo sbalen� zobrazen� sm�rnic souboru ve stavu Instalovat nebo Lze instalovat.</li>
            </ul>
            </p>

            <p>Z�lo�ku <strong>Zobrazit protokol</strong> p�idal do TNG 10.0.3 Ken Roy a zobrazuje protokol Mana�eru m�d�, kter� je nyn� odd�len od protokolu Administrace. Protokol mana�eru m�d� je p�eform�tovan� protokol z Mana�eru m�d� vytvo�en�ho Rickem
                Bisbee a Robinem Richmondem v TNG 10.0.3 a srozumitelnost vykonan�ch akc� zaznamenan�ch v protokolu je nyn� lep��. Zpr�vy a hl�en� byly zna�n� zjednodu�eny.</p>
            <p>Z�lo�ka <strong>Mo�nosti</strong> je modifikac� z�lo�ky p�idan� Kenem Royem do TNG 10.0.3 a umo��uje m�nit n�kter� chov�n� mana�eru m�d�.</p>
            <p>Z�lo�ka <strong>Anal�za souboru TNG</strong> je voliteln� z�lo�ka, jej� zobrazen� lze povolit na obrazovce Mo�nosti, a umo��uje vybrat soubor TNG a zobrazit, kter� m�dy jej m�n�.</p>
            <p>Z�lo�ka <strong>Tabulka parseru</strong> je voliteln� z�lo�ka, jej� zobrazen� lze povolit na obrazovce Mo�nosti povolen�m <strong>Dal�� n�stroje pro v�voj��e</strong>, a umo�n� zobrazit, jak je dan� m�d analyzov�n Mana�erem m�d�.</p>
            <p>Z�lo�ka <strong>Doporu�en� aktualizace</strong> je voliteln� z�lo�ka, jej� zobrazen� lze povolit na obrazovce Mo�nosti, kter� v�m umo�n� aktualizovat soubory cust_text.php, pokud jste tak neu�inili v r�mci aktualizace TNG.</p>

            <p>Dal�� informace m��ete naj�t v �l�nku
                <a href="https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager" target="_blank">Mana�er m�d� (v angli�tin�)</a> a v kategorii �l�nk�
                <a href="https://tng.lythgoes.net/wiki/index.php?title=Category:TNG_Mod_Manager" target="_blank">TNG Mod Manager (v angli�tin�)</a> na TNG Wiki.</p>
            <p>You can view the <a href="https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_Enhancements" target="_blank">Mod Manager</a> article in TNG Wiki to see what enhancements were made in TNG v12.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">
            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="operation"><p class="subheadbold">Operace</p></a>
            <p>Mana�er m�d� prozkoum� slo�ku m�d� a p�e�te ka�d� soubor <strong>cfg</strong>, kter� najde. Soubory <strong>cfg</strong> jsou direktivn� soubory, kter� popisuj� m�d, soubory a um�st�n�, kter� m� b�t modifikov�no, a k�d, kter� je p�i
                modifikaci pou�it.
            <p>Mana�er m�d� zkontroluje n�sleduj�c�:
            <ul>
                <li>zajist�, �e je u�ivatel p�ihl�en
                <li>prov��� um�st�n� a zm�nu ka�d�ho k�du
                    <ul>
                        <li>zajist�, �e lze um�st�n� nal�zt</li>
                        <li>zajist�, �e c�lov� m�sto je jedine�n�</li>
                        <li>ur��, zda c�lov� um�st�n� ji� bylo nainstalov�no</li>
                    </ul>
                <li>vytvo�� zadanou slo�ku nebo adres��</li>
                <li>identifikuje nov� soubory, kter� maj� b�t vytvo�eny. Pokud je soubor ozna�en jako chr�n�n�, nebude odstran�n Odinstalac� ani Vy�i�t�n�m.</li>
                <li>identifikuje soubory, kter� maj� b�t zkop�rov�ny do ko�enov� slo�ky TNG nebo do ur�en� slo�ky. Pokud je soubor ozna�en jako chr�n�n�, nebude odstran�n Odinstalac� ani Vy�i�t�n�m.</li>
            </ul>
            </p>

        </td>
    </tr>

    <tr class="databack">
        <td class="tngshadow">
            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="status"><p class="subheadbold">Stav</p></a>
            <p>Mana�er m�d� vrac� n�sleduj�c� stavy:
            <ul>
                <li><strong>Lze instalovat</strong>, pokud m�d je�t� nebyl nainstalov�n a c�lov� um�st�n� je identifikov�no, pak je uvedena mo�nost <strong>Instalovat</strong>
                </li>
                <li><strong>Instalov�no</strong>, pokud ji� m�d byl nainstalov�n, je uvedena mo�nost <strong>Odinstalovat</strong> m�d a mo�nost <strong>Upravit</strong> parametry, pokud n�jak� existuj�. M�dy s edita�n�mi parametry jsou identifikov�ny
                    podle [Mo�nosti] za stavem Instalov�no.
                </li>
                <li><strong>��ste�n� instalov�no</strong>, pokud m�d byl ��ste�n� nainstalov�n, je k dispozici tla��tko <strong>Vy�istit</strong>. Operace Vy�i�t�n� se pokus� odstranit vlo�en� k�d, obnovit a nahradit k�d, a odstranit jak�koli vytvo�en�
                    nebo zkop�rovan� soubory.
                </li>
                <li><strong>Nelze nainstalovat</strong>, pokud m�d <strong>nelze</strong> instalovat. Roz���en� (zobrazen� kompletn� informace) stavu poskytne v�ce informac� o tom, pro� m�d nelze nainstalovat.
                </li>
            </ul>
            <p>P��klady obrazovek stavu mana�eru m�d� a jak interpretovat r�zn� stavy najdete na
                <a href="https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_-_Interpreting_Status" target="_blank">Mana�er m�d� - interpretace stav� (v angli�tin�)</a>
            </p></td>
    </tr>

    <tr class="databack">
        <td class="tngshadow">
            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="syntax"><p class="subheadbold">Syntaxe m�d�</p></a>
            <p>Syntaxe mana�era m�d� v z�sad� zahrnuje:
            <p><strong>Sekci z�hlav�</strong>, kter� obsahuje</p>
            <ul>
                <li>N�zev (name) - n�zev m�du, �l�nek na TNG Wiki a n�zev souboru</li>
                <li>Verze (version) - verze m�du, kde prvn� 3 ��slice p�edstavuj� nejni��� verzi TNG, ve kter� m�d funguje</li>
                <li>Popis (description) - obsahuje stru�n� popis m�du, jm�no v�voj��e a URL �l�nku o dan�m m�du na TNG Wiki.</li>
            </ul>
            </p>
            <p><strong>C�lovou sekci (target)</strong>, kde je specifikov�n soubor, kter� je opravn�m m�dem zm�n�n, a n�sledn� obsahuje p��kazy. K c�lov� sekce lze p�idat pozn�mku.</p>
            <ul>
                <li>Um�st�n� (location) - ur�uje um�st�n� k�du, kter� je v souboru m�n�n. K um�st�n� lze p�idat pozn�mku.</li>
                <li>Kl��ov� slovo akce - ur�uje, zda p�epsat (Replace) nebo vlo�it (Insert) k�d p�ed (Before) nebo za (After) toto um�st�n�</li>
            </ul>
            </p>
            <p><strong>P��kaz Nov� soubor (New File)</strong>, kter� po instalaci m�du vytvo�� nov� soubor</p>
            <p><strong>P��kaz Kop�rovat soubor (Copy File)</strong>, kter� nakop�ruje ur�it� soubor do ��d�c� slo�ky TNG (%copyfile) nebo do podslo�ky (%copyfile2)</p>
            <p>Detailn� informace t�kaj�c� se syntaxe m�d� najdete v �l�nku <a href="https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_Syntax" target="_blank">Mod Manager Syntax (v angli�tin�)</a></p>
        </td>
    </tr>

    <tr class="databack">
        <td class="tngshadow">
            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="files"><p class="subheadbold">Konfigura�n� soubory</p></a>

            <span class="optionhead">Instalov�n� m�d�</span>
            <p>Informace o <a href="https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_-_Installing_Config_Files" target="_blank">instalaci konfigura�n�ch soubor� (v angli�tin�)</a> k instalaci m�d� najdete na TNG Wiki.</p>

            <span class="optionhead">Interpretace stavu</span>
            <p>Informace o <a href="https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_-_Interpreting_Status" target="_blank">interpretaci stavu (v angli�tin�)</a> najdete na TNG Wiki.</p>

            <span class="optionhead">Syntaxe konfigura�n�ch soubor�</span>
            <p>Informace o <a href="https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_Syntax" target="_blank">syntaxi mana�eru m�d� (v angli�tin�)</a> najdete na TNG Wiki.</p>

            <span class="optionhead">Vytvo�en� konfigura�n�ho souboru</span>
            <p>Informace pro v�voj��e o <a href="https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_-_Creating_Config_Files" target="_blank">vytvo�en� konfigura�n�ch soubor� (v angli�tin�)</a> najdete na TNG Wiki.</p>
        </td>
    </tr>

    <tr class="databack">
        <td class="tngshadow">
            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="batch"><p class="subheadbold">D�vkov� operace</p></a>

            <p>Funkce D�vkov� operace, v TNG 10.0.3 p�edstaven� jako D�vkov� instalace, je nyn� sou��st� Seznamu m�d� a umo�n� prov�st specifick� akce t�kaj�c� se v�ce m�d� pomoc� v�b�ru filtru.
                Z filtru seznamu stav� mus�te vybrat po�adovan� stav a kliknut�m na <strong>Prov�st</strong> zobraz�te dostupn� ovl�dac� tla��tka pro vybran� stav.

                Akce <strong>Vymazat</strong> je k dispozici pouze pro stav ��ste�n� nainstalov�no, pokud povol�te p��slu�nou p�edvolbu. Doporu�ujeme ji nastavit na Ne, krom� p��pad�, kdy je pot�eba vymazat v�ce m�d� ve stavu
                ��ste�n� nainstalov�no, jako nap�. p�edchoz� verze t�ho� m�du. Stejn� tak je zde mo�nost Vymazat instalovan� m�dy, kter� umo�n� vymaz�n� nainstalovan�ch m�d�, ani� byste je nejprve odinstalovali. Tato mo�nost byla p�id�na,
                aby bylo mo�n� vymazat p�edchoz� verze t�ho� m�du, pokud jste je zapomn�li vymazat p�ed instalac� nov� verze. Zde op�t doporu�ujeme ponechat mo�nost jako Ne a povolit ji jen v p��pad� pot�eby.
                Tla��tko <strong>Vymazat</strong> se zobraz� pouze v seznamu Vybrat, pokud jsou povoleny oba mo�nosti vymaz�n�.
            </p>

            <p><strong><font color="red">Upozorn�n�: D�vkov� operace pou��vejte pouze tehdy, pokud m�te z�lohu va�ich webov�ch str�nek a m��ete je snadno obnovit v p��pad�, �e vlivem d�vkov�ch operac� dojde k po�kozen� va�ich str�nek, co� se m��e snadno
                        st�t, pokud nevyma�ete p�edchoz� verze m�d�.</font>
                    Je doporu�eno P�ed proveden�m aktualizace TNG doporu�ujeme odinstalovat v�echny nainstalovan� m�dy a pot� vy�istit v�echny ��ste�n� nainstalovan� m�dy.</strong></p>

            <p>Mo�nosti v�b�rov�ho filtru jsou tyto:
            <ul>
                <li><strong>V�e</strong> - zobraz� se �pln� seznam v�ech soubor� .cfg ze slo�ky mods. Pokud zvol�te ur�it� stav, objev� se dostupn� tla��tka jednotliv�ch akc�</li>
                <li><strong>Lze nainstalovat</strong> - zobraz� se seznam v�ech m�d�, kter� mohou b�t</li>
                <ul>
                    <li>Nainstalov�ny - na z�klad� va�eho v�b�ru a kliknut�m na tla��tko <strong>Instalovat</strong></li>
                    <li>Vymaz�ny ze slo�ky mods - na z�klad� va�eho v�b�ru a kliknut�m na tla��tko <strong>Vymazat</strong></li>
                </ul>
                <li><strong>Instalov�no</strong> - zobraz� se seznam v�ech m�d�, kter� jsou aktu�ln� nainstalov�ny, a mohou b�t</li>
                <ul>
                    <li>Odstran�ny - na z�klad� va�eho v�b�ru a kliknut�m na tla��tko <strong>Odstranit</strong></li>
                </ul>
                <li><strong>��ste�n� instalov�no</strong> - zobraz� se seznam v�ech m�d�, kter� jsou ��ste�n� instalov�ny a mus� b�t</li>
                <ul>
                    <li>Vy�i�t�ny - na z�klad� va�eho v�b�ru a kliknut�m na tla��tko <strong>Vy�istit vybran�</strong></li>
                </ul>
                <li><strong>Nelze nainstalovat</strong> - zobraz� se seznam v�ech m�d�, kter� nelze nainstalovat z d�vodu chybn�ho c�lov�ho souboru nebo chyb�j�c�ch soubor�, a mohou b�t</li>
                <ul>
                    <li>Vymaz�ny ze slo�ky mods - na z�klad� va�eho v�b�ru a kliknut�m na tla��tko <strong>Vymazat vybran�</strong></li>
                </ul>
                <li><strong>Vybrat</strong> - p�id�no v TNG v12 - zobraz� se seznam v�ech mod�, kter� mohou b�t vybr�ny bez ohledu na stav a pot� pouze vrac� tyto m�dy do seznamu</li>
                <ul>
                    <li>Tla��tko <strong>Vymazat</strong> bude dostupn� pouze na seznamu Vybrat, pokud m�te aktivn� volbu Povolit Vymazat vybran� u ��ste�n� nainstalovan�ch m�d�. Tato funkce byla p�id�na hlavn� pro v�voj��e m�d� k vy�i�t�n� jejich
                        testovac�ch prost�ed�.
                    </li>
                </ul>
            </ul>
            </p>
        </td>
    </tr>

    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="options"><p class="subheadbold">Mo�nosti</p></a>

            <p>Mo�nosti v�m umo�n� specifikovat chov�n� mana�eru m�d�.

            <p><strong>Mo�nosti protokolu Mana�eru m�d�</strong>
            <ul>
                <li><strong>N�zev protokolu</strong> - umo�n� v�m ur�it n�zev souboru, kter� bude pou�it pro protokol mana�eru m�d�. V�choz� volbou je <strong>modmgrlog.txt</strong>.</li>
                <li><strong>Maxim�ln� po�et transakc�</strong> - umo�n� v�m ur�it, kolik transakc� bude zachov�v�no v protokolu. V�choz� volbou je <strong>200</strong> transakc�.</li>
                <li><strong>Sbalit zobrazen� protokolu</strong> - umo�n� v�m ur�it, zda chcete p�i �vodn�m zobrazen� vid�t protokol v z��en�m nebo roz���en�m stavu. V�choz� volbou je <strong>Ano</strong>.</li>
                <li><strong>P�esm�rovat na protokol</strong> - umo�n� v�m ur�it, zda chcete b�t ze Seznamu m�d� p�esm�rov�ni na z�lo�ku Zobrazit protokol v p��pad� <strong>Pouze chyb</strong> nebo <strong>V�ech transakc�</strong>. V�choz� volbou je
                    p�esm�rov�n� v p��pad� <strong>Pouze chyb</strong>, kter� zobraz� protokol pouze v p��pad�, �e se vyskytne v pr�b�hu instalace, odinstalace, vy�i�t�n� nebo vymaz�n� chyba.
                </li>
                <li><strong>Do protokolu zapsat celou cestu soubor�</strong> - umo�n� v�m zapsat Ne, pokud chcete u soubor� v protokolu zobrazit pouze relativn� cestu. V�choz� volbou je <strong>Ano</strong> pro zobrazen� �pln� absolutn� cesty.</li>
            </ul>
            </p>
            <p><strong>Mo�nosti nastaven� zobrazen�</strong>
            <ul>
                <li><strong>�adit seznamy podle</strong> - umo�n� v�m zvolit, podle kter�ho sloupce bude �azen Seznam m�d�. Mo�nosti jsou N�zev m�du a N�zev konfigura�n�ho souboru. V�choz� volbou je <strong>N�zev m�du</strong>.</li>
                <li><strong>Pou��t pevn� z�hlav�</strong> - umo�n� v�m zm�nit volbu, aby nebylo zobrazeno pevn� z�hlav�. Tato volba nen� z�eteln�, pokud m�te velk� monitor a m�lo m�d�. V�choz� volbou je <strong>Ano</strong> pro zobrazen� pevn�ho z�hlav�.
                    Bez ohledu na nastaven� t�to volby se pevn� z�hlav� nezobraz� v p��pad� chytr�ch telefon� (mobiln� re�im).
                </li>
                <li><strong>Upravit pevn� z�hlav�</strong> - umo�n� v�m povolit �pravu pevn�ho z�hlav� jQuery v p��pad�, �e pevn� z�hlav� nen� spr�vn� zobrazeno. Tato volba je pot�eba pouze na ur�it�ch monitorech. V�choz� volbou je <strong>Ne</strong> a
                    nepou��vat javascript jQuery pro �pravu pevn�ho z�hlav�.
                </li>
                <li><strong>Pou��t pruhy</strong> - umo�n� v�m zm�nit volbu a nepou��t pruhy p�i zobrazen� Seznamu m�d�. V�choz� volbou je <strong>Ano</strong>, kter� pou�ije t��du databackalt k zobrazen� barevn�ch pruh� st��dav� po po�tu N ��dk�.</li>
                <li><strong>Pruh po tomto po�tu ��dk�</strong> - umo�n� nastavit po�et ��dk�, po kter�m se budou st��dat barevn� pruhy. V�choz� volbou jsou <strong>3</strong> ��dky jedn� barvy a pak 3 ��dky jin� barvy.</li>
                <li><strong>Odstranit mezery z n�zv� soubor� v seznamu m�d�</strong> - umo�n� odstranit mezery z n�zv� m�d� p�ed jejich zobrazen�m v Seznamu n�zv� m�d�. V�choz� volbou je <strong>Ne</strong>, kdy jsou mezery v n�zvech m�d� zobrazeny a tyto
                    n�zvy pak odpov�daj� n�zv�m �l�nk� na TNG Wiki.
                </li>
                <li><strong>Zobrazit z�lo�ku Anal�za soubor� TNG</strong> - umo�n� ur�it, zda chcete zobrazit z�lo�ku Anal�za sooubor� TNG. V�choz� volbou je <strong>Ne</strong>, kter� potla�� zobrazen� z�lo�ky Anal�za sooubor� TNG.</li>
                <li><strong>Zobrazit dal�� n�stroje pro v�voj��e</strong> - umo�n� ur�it, zda chcete zobrazit z�lo�ku Tabulka parseru. V�choz� volbou je <strong>Ne</strong>, kter� potla�� zobrazen� z�lo�ky Tabulka parseru. Tato volba tak� ��d�, zda se na
                    kliknut� na n�zev m�du zobraz� tabulka parseru pro dan� mod a zda se kliknut�m na n�zev konfigura�n�ho souboru zobraz� na nov� z�lo�ce konfigura�n� soubor.
                </li>
                <li><strong>Zobrazit z�lo�ku Doporu�en� aktualizace</strong> - umo�n� ur�it, zda chcete zobrazit z�lo�ku Doporu�en� aktualizace. V�choz� volbou je <strong>Ne</strong>, kter� potla�� zobrazen� z�lo�ky Doporu�en� aktualizace. Tato z�lo�ka
                    nemus� b�t zobrazena, pokud jste provedli aktualizaci souboru cust_text.php v r�mci aktualizace na TNG v12.
                </li>
            </ul>
            </p>
            <p><strong>Jin� mo�nosti</strong>
            <ul>
                <li><strong>Povolit Vymazat vybran� pro ��ste�n� nainstalovan� m�dy</strong> - povol� zobrazen� tla��tka <strong>Vymazat</strong> v seznamu vybran�ch ��ste�n� nainstalovan�ch m�d�, pomoc� kter�ho lze vymazat v�ce m�d� najednou, jako nap�.
                    vymaz�n� p�edchoz�ch verz� mod�, kter� nebyly vymaz�ny p�ed instalac� nov�j�� verz�. V�choz� volbou je <strong>Ne</strong>. Tuto volbu doporu�ujeme povolit pouze v p��pad�, �e pot�ebujete vymazat v�ce mod�, ani� byste museli
                    odinstalovat aktu�ln� verze, abyste odstranili p�edchoz� verze m�du, kdy� jste zapomn�li odinstalovat a vymazat p�edchoz� verze modu p�ed instalac� nov� verze. Norm�ln� tuto volbu nechte nastavenou na Ne a volbu Ne obnovte po odstran�n�
                    p�edchoz�ch verz� m�du, kter� se zobrazuj� jako ��ste�n� nainstalovan�.
                </li>
                <li><strong>Povolit Vymazat pro samostatn� nainstalovan� m�dy</strong> - umo�n� zapnut� volby zobrazen� tla��tka <strong>Vymazat</strong> vedle tla��tka Odinstalovat u samostatn� instalovan�ch m�d�, nap�. pro vymaz�n� p�edchoz� verze m�du,
                    kter� nebyla vymaz�na p�ed instalac� nov�j�� verze. V�choz� volbou je <strong>Ne</strong>. Doporu�ujeme, abyste tuto volbu povolili pouze v p��pad�, kdy je pot�eba vymazat p�edchoz� verzi m�du, bez nutnosti odinstalov�n� aktu�ln� verze
                    za ��elem vymaz�n� p�edchoz� verze, a za norm�ln�ch okolnost� ponechte tuto volbu nastavenou na <strong>Ne</strong> a volbu Ne obnovte po odstran�n� p�edchoz�ch verz� m�du, kter� se zobrazuj� jako nainstalovan�.
                </li>
                <li><strong>Povolit smaz�n� podp�rn� slo�ky po vymaz�n� modu</strong> - umo�n� zapnut� volby smaz�n� slo�ky (slo�ek) p�idru�en�ch k m�du p�i maz�n� m�du. V�choz� volbou je <strong>Ne</strong>. Doporu�ujeme tuto mo�nost povolit jen tehdy,
                    pokud ch�pete nebezpe�� vymaz�n� nezam��len�ch slo�ek. V���me, �e toto riziko je velmi mal�.
                </li>
            </ul>
            </p>
        </td>
    </tr>

    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="analyze"><p class="subheadbold">Anal�za soubor� TNG</p></a>

            <p>Tento n�stroj na z�lo�ce <strong>Anal�za soubor� TNG</strong>, kter� vytvo�il Rick Bisbee, existoval d��ve jako opravn� m�d. Anal�za soubor� TNG umo��uje v�voj���m zkoumat p�soben� m�d� navz�jem. Situace, kdy dva m�dy m�n� stejn� �sek
                programov�ho k�du, m� t�m�� v�dy za n�sledek chybu v mana�eru m�d�. Chcete-li, aby byla z�lo�ka Anal�za soubor� TNG zobrazena, mus�te ji povolit nastaven�m volby <strong>Anal�za soubor� TNG</strong> na Ano.</p>

            <p>Analyz�r pracuje tak, �e prozkoum� v�echny m�dy ve slo�ce mods a vytvo�� soupis c�lov�ch soubor� a �sek� programov�ho k�du, kter� ka�d� m�d m�n�. V lev�m sloupci uvede n�zvy dot�en�ch soubor�. Po kliknut� na n�zev c�lov�ho souboru se na
                prav� stran� zobraz� seznam m�d�, kter� tento c�lov� soubor m�n�. U ka�d�ho m�du je napravo zobrazen odkaz pro otev�en� sekce str�nky zobrazuj�c� aktu�ln� zm�ny, kter� obsahuje konfigura�n� soubor mana�eru m�d�. U�ivatel m��e porovnat zm�ny
                c�lov�ho souboru a vid�t, kde mohou b�t skryty potenci�ln� konflikty.</p>

            <p>To je u�ite�n� nejen pro nalezen� konflikt� mezi dv�ma m�dy, ale tak� pro pozn�n�, kter� m�dy je t�eba vy�istit a znovu nainstalovat po p�eps�n� dan�ho c�lov�ho souboru. </p>
            <p>V�voj��i m�d� naleznou dal�� informace na TNG Wiki v �l�nku <a href="https://tng.lythgoes.net/wiki/index.php?title=Using_the_Mod_Analyzer" target="_blank">Using the Mod Analyzer (v angli�tin�)</a>.</p>
        </td>
    </tr>

    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Top</a></p>
            <a name="parser"><p class="subheadbold">Tabulka parseru</p></a>
            <p>Tento n�stroj je ur�en hlavn� pro v�voj��e. Tabulka parseru ukazuje, jak Mana�er m�d� zanalyzoval konfigura�n� soubor m�du (.cfg) zapracov�n�m jeho komponent do tabulky, kter� pak proch�z� do dal��ch skript� Mana�eru m�d� pro dal��
                zpracov�n�. Pokud se vyskytne probl�m s m�dem, prvn� m�sto, kter� je t�eba zkontrolovat, je tabulka parseru, aby se zjistilo, zda jsou spr�vn� zachyceny v�echny p��kazy a argumenty m�du.</p>
            <p>Tuto z�lo�ku m��ete pou��t k v�b�ru m�du ze seznamu, jeho� tabulku chcete zobrazit, nebo, pokud jste povolili mo�nost Zobrazit dal�� n�stroje pro v�voj��e, m��ete kliknout na n�zev m�du v Seznamu m�d� a zobrazit tabulku parseru pro tento
                m�d.</p>

            <p>Zobrazen� t�to z�lo�ky je voliteln�. Chcete-li jej pou��t, vyberte mo�nost 'Nastaven� zobrazen�/Zobrazit dal�� n�stroje pro v�voj��e' na z�lo�ce Mo�nosti. Pokud je volba z�lo�ky vypnuta, odkaz na str�nce se seznamem nebude tak� povolen.</p>

        </td>
    </tr>

    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Top</a></p>
            <a name="custtext"><p class="subheadbold">Doporu�en� aktualizace</p></a>
            <p>Z�lo�ka Doporu�en� aktualizace je voliteln� z�lo�ka, kter� m��e b�t povolena na obrazovce Mo�nosti, a umo�n� v�m aktualizovat soubory cust_text.php, pokud jste tak neu�inili jako sou��st aktualizace TNG.</p>
            <p>Pou�it� z�lo�ky se p�edpokl�d� v p��pad�, �e m�d nem��e b�t nainstalov�n, proto�e hled� nov� koment��ov� �et�zec v horn� ��sti soubor� cust_text.php po��naje TNG v12. Tato volba bude vypnuta po kliknut� na tla��tko Aktualizovat a zm�n�
                st�vaj�c�ch soubor� cust_text.php. K�d kontroluje, zda byly tyto soubory ji� d��ve aktualizov�ny.</p>

        </td>
    </tr>

</table>
</body>
</html>

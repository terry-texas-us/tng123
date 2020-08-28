<?php
include "../../helplib.php";
echo help_header("N�pov�da: Mana�er m�d�");
?>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<body class="helpbody">
<a name="top"></a>
<table width="100%" cellpadding="10" cellspacing="2" class="tblback normal">
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
                <a href="#batch" class="lightlink">D�vkov� instalace</a> &nbsp; | &nbsp;
                <a href="#options" class="lightlink">Mo�nosti</a>
            </p></td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">
            <a name="overview">
                <p class="subheadbold">P�ehled
                </p></a>
            <p>TNG Mana�er m�d�, kter� p�vodn� vyvinul Brian McFadyen a pro pr�ci s Joomla TNG Component aktualizoval Sean Schwoere, je ur�en k poskytnut� ucelen�j��ho
                zp�sobu instalov�n�, odstra�ov�n� a spr�v� modifikac� TNG software, kter� s t�mto mana�erem dok�e pracovat. Aktualizace v TNG V9 provedli Bart Degryse a Ken Roy.
                Mana�er m�d� je pro snaz�� p��stup p�ipojen ke str�nce Administrace TNG. Mana�er m�d� p�id�v� do TNG tyto slo�ky:
            <ul>
                <li><strong>mods</strong> obsahuje konfigura�n� soubory m�d� a p�idru�en� podp�rn� soubory m�d�
                </li>
                <li><strong>extensions</strong> obsahuje n�kter� roz���en� m�d�, kter� jsou instalov�ny jin�mi konfigura�n�mi soubory mana�eru m�d�
                </li>
            </ul>
            </p>
            <p><strong>D�vkovou instalaci</strong> p�idal do TNG 10.0.3 Rick Bisbee a umo��uje vykonat stejnou akci pro v�ce m�d�. Popup okno s popisem p�idal Jeff Robison.</p>
            <p><strong>Mo�nosti</strong> p�idal do TNG 10.0.3 Ken Roy a umo��uje m�nit n�kter� chov�n� mana�eru m�d�.</p>
            <p><strong>Zobrazit protokol</strong> p�idal do TNG 10.0.3 Ken Roy a zobrazuje protokol mana�eru m�d�, kter� je nyn� odd�len od protokolu administrace.
                Protokol mana�eru m�d� pro snadn�j�� �itelnost akc� p�eform�toval Rick Bisbee.</p>
            <p>Dal�� informace m��ete naj�t v �l�nku
                <a href="https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager" target="_blank">Mana�er m�d�</a> a v kategorii �l�nk�
                <a href="https://tng.lythgoes.net/wiki/index.php?title=Category:TNG_Mod_Manager" target="_blank">TNG Mod Manager</a> na TNG Wiki.
            </p></td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">
            <p style="float:right">
                <a href="#top">Nahoru</a>
            </p>
            <a name="operation">
                <p class="subheadbold">Operace
                </p></a>
            <p>Mana�er m�d� prozkoum� slo�ku m�d� a p�e�te ka�d� soubor <strong>cfg</strong>, kter� najde. Soubory <strong>cfg</strong> jsou direktivn� soubory, kter� popisuj� m�d, soubory a um�st�n�, kter� m� b�t modifikov�no, a k�d, kter� je p�i
                modifikaci pou�it.
            <p>Mana�er m�d� zkontroluje n�sleduj�c�:
            <ul>
                <li>zajist�, �e je u�ivatel p�ihl�en
                <li>prov��� um�st�n� a zm�nu ka�d�ho k�du
                    <ul>
                        <li>zajist�, �e lze um�st�n� nal�zt
                        </li>
                        <li>zajist�, �e c�lov� m�sto je jedine�n�
                        </li>
                        <li>ur��, zda c�lov� um�st�n� ji� bylo nainstalov�no
                        </li>
                    </ul>
                <li>ur�� nov� soubory, kter� maj� b�t vytvo�eny. Pokud nov� soubor ji� existuje, ur�� jeho verzi.
                </li>
            </ul>
            </p>    </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">
            <p style="float:right">
                <a href="#top">Nahoru</a>
            </p>
            <a name="status">
                <p class="subheadbold">Stav
                </p></a>
            <p>Mana�er m�d� vrac� n�sleduj�c� stavy:
            <ul>
                <li><strong>Lze instalovat</strong>, pokud m�d je�t� nebyl nainstalov�n a c�lov� um�st�n� bylo ur�eno, pak je uvedena mo�nost <strong>Instalovat</strong>
                </li>
                <li><strong>Instalov�no</strong>, pokud m�d byl nainstalov�n, je uvedena mo�nost <strong>Odstranit</strong> m�d a mo�nost <strong>Upravit</strong> parametry, pokud n�jak� existuj�
                </li>
                <li><strong>Vy�istit</strong>, pokud m�d byl ��ste�n� nainstalov�n, je k dispozici tla��tko <strong>Vy�istit</strong>. Operace Vy�i�t�n� se pokus� odstranit vlo�en� k�d, obnovit a nahradit k�d, a odstranit vytvo�en� soubor.
                </li>
                <li><strong>Nelze nainstalovat</strong>, pokud m�d <strong>nelze</strong> instalovat. Tato zpr�va bude p�edch�zet jinou zpr�vu, kter� poskytne v�ce informac� o tom, pro� m�d nelze nainstalovat.
                </li>
            </ul>
            <p>P��klady obrazovek stavu mana�eru m�d� a jak interpretovat r�zn� stavy najdete na
                <a href="https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_-_Interpreting_Status" target="_blank">Mana�er m�d� - interpretace stav�</a>
            </p></td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">
            <p style="float:right">
                <a href="#top">Nahoru</a>
            </p>
            <a name="syntax">
                <p class="subheadbold">Syntaxe m�d�
                </p></a>
            <p>The Mod Manager syntax basically includes:
            <p><strong>Sekce z�hlav�</strong>, kter� obsahuje</p>
            <ul>
                <li>N�zev - n�zev m�du, �l�nek na TNG Wiki a n�zev souboru</li>
                <li>Verze - verze m�du, kde prvn� 3 ��slice p�edstavuj� nejni��� verzi TNG, ve kter� m�d funguje</li>
                <li>Popis - obsahuje stru�n� popis m�du, jm�no v�voj��e a URL �l�nku o dan�m m�du na TNG Wiki.</li>
            </ul>
            </p>
            <p><strong>C�lov� sekce (Target)</strong>, kde je specifikov�n soubor, kter� je opravn�m m�dem zm�n�n, a obsahuje tyto p��kazy</p>
            <ul>
                <li>Location - ur�uje um�st�n� k�du, kter� je v souboru m�n�n</li>
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
            <p style="float:right">
                <a href="#top">Nahoru</a>
            </p>
            <a name="files">
                <p class="subheadbold">Konfigura�n� soubory
                </p></a>
            <span class="optionhead">Instalov�n� m�d�
        </span>
            <p>Informace o pou�it�
                <a href="https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_-_Installing_Config_Files" target="_blank">konfigura�n�ch soubor�</a> k instalaci m�d� najdete na TNG Wiki.
            </p>
            <span class="optionhead">Interpretace stavu
        </span>
            <p>Informace o
                <a href="https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_-_Creating_Config_Files" target="_blank">interpretaci stavu</a> najdete na TNG Wiki.
            </p>
            <span class="optionhead">Syntaxe konfigura�n�ch soubor�
        </span>
            <p>Informace o
                <a href="https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_-_Config_File_Syntax" target="_blank">syntaxi konfigura�n�ch soubor�</a> najdete na TNG Wiki.
            </p>
            <span class="optionhead">Vytvo�en� konfigura�n�ho souboru
        </span>
            <p>Informace pro v�voj��e o
                <a href="https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_-_Creating_Config_Files" target="_blank">vytvo�en� konfigura�n�ch soubor�</a> najdete na TNG Wiki.
            </p></td>
    </tr>

    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="batch"><p class="subheadbold">D�vkov� instalace</p></a>

            <p>D�vkov� instalace umo�n� prov�st specifick� akce t�kaj�c� se n�kolika m�d� pomoc� v�b�ru filtru. Z filtru seznamu stav� vyberte po�adovan� stav a kliknut�m na Prov�st zobraz�te
                dostupn� ovl�dac� tla��tka pro vybran� stav. Pro stav Vy�istit nen� k dispozici akce Odstranit, tak�e pro odstran�n� m�d� ve stavu Vy�istit mus�te pou��t z�lo�ku Seznam m�d�.
            <p>Mo�nosti v�b�rov�ho filtru jsou tyto:
            <ul>
                <li><strong>V�e</strong> - zobraz� se �pln� seznam v�ech soubor� .cfg ze slo�ky mods. Pokud zvol�te ur�it� stav, objev� se dostupn� tla��tka jednotliv�ch akc�
                <li><strong>Lze nainstalovat</strong> - zobraz� se seznam v�ech m�d�, kter� mohou b�t</li>
                <ul>
                    <li>Nainstalov�ny - na z�klad� va�eho v�b�ru a kliknut�m na tla��tko <strong>Instalovat</strong></li>
                    <li>Vymaz�ny ze slo�ky mods - na z�klad� va�eho v�b�ru a kliknut�m na tla��tko <strong>Vymazat</strong></li>
                </ul>
                <li><strong>Instalov�no</strong> - zobraz� se seznam v�ech m�d�, kter� jsou aktu�ln� nainstalov�ny, a mohou b�t</li>
                <ul>
                    <li>Odstran�ny - na z�klad� va�eho v�b�ru a kliknut�m na tla��tko <strong>Odstranit</strong></li>
                </ul>
                <li><strong>Vy�istit</strong> - zobraz� se seznam v�ech m�d�, kter� mohou b�t</li>
                <ul>
                    <li>Vy�i�t�ny - na z�klad� va�eho v�b�ru a kliknut�m na tla��tko <strong>Vy�istit</strong></li>
                </ul>
                <li><strong>Nelze nainstalovat</strong> - zobraz� se seznam v�ech m�d�, kter� nelze nainstalovat z d�vodu chybn�ho c�lov�ho souboru nebo chyb�j�c�ch soubor�, a mohou b�t</li>
                <ul>
                    <li>Vymaz�ny ze slo�ky mods - na z�klad� va�eho v�b�ru a kliknut�m na tla��tko <strong>Vymazat</strong></li>
                </ul>
            </ul>
            </p></p>
        </td>
    </tr>

    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="options"><p class="subheadbold">Mo�nosti</p></a>

            <p>Mo�nosti v�m umo�n� specifikovat chov�n� mana�eru m�d� v p��pad�
            <p><strong>Seznamu dot�en�ch soubor�</strong>
            <ul>
                <li><strong>Zobrazit seznam dot�en�ch soubor�</strong> - umo�n� v�m zvolit, zda chcete v tabulce seznamu m�d� zobrazit seznam dot�en�ch soubor�. V�choz� volbou je <strong>Ano</strong>.</li>
                <li><strong>Zobrazit v seznamu nov� soubory</strong> - zobraz� nov� soubory vytvo�en� m�dem. V�choz� volbou je <strong>Ano</strong>.</li>
                <li><strong>Zobrazit v seznamu kop�rovan� soubory</strong> - zobraz� soubory, kter� jsou kop�rov�ny m�dem. V�choz� volbou je <strong>Ano</strong>.</li>
                <li><strong>Zobrazit seznam ve sloupci</strong> - zobraz� seznam dot�en�ch soubor� ve zvolen�m sloupci. V�choz� volbou je sloupec <strong>N�zev konfigura�n�ho souboru</strong>.</li>
                <li><strong>Zobrazit seznam jako</strong> - umo�n� v�m zvolit, zda chcete seznam zobrazit jako tabulku nebo jako hodnoty odd�len� ��rkou. V�choz� volbou je <strong>Tabulka</strong>.</li>
                <li><strong>Zobrazit seznam v D�vkov� instalaci</strong> - umo�n� v�m zvolit, zda chcete seznam zobrazit na z�lo�ce D�vkov� instalace ve vyskakovac�m okn�. V�choz� volbou je <strong>Ano</strong>.</li>
            </ul>
            </p>
            <p><strong>Protokolu mana�eru m�d�</strong>
            <ul>
                <li><strong>Zaznamen�vat akce mana�eru m�d�</strong> - umo�n� v�m zvolit, zda chcete zaznamen�vat potvrzen� a akce mana�eru m�d�. V�choz� volbou je <strong>Ano</strong>.</li>
                <li><strong>N�zev protokolu</strong> - umo�n� v�m ur�it n�zev souboru, kter� bude pou�it pro protokol mana�eru m�d�. V�choz� volbou je <strong>modmgrlog.txt</strong>.</li>
                <li><strong>Maxim�ln� po�et ��dk�</strong> - umo�n� v�m ur�it, kolik ��dk� bude zachov�v�no v protokolu. V�choz� volbou je <strong>2000</strong>.</li>
            </ul>
            </p>
            <p><strong>Jin�</strong>
            <ul>
                <li><strong>�adit seznamy podle</strong> - umo�n� v�m zvolit, podle kter�ho sloupce bude �azen Seznam m�d� a D�vkov� instalace. V�choz� volbou je <strong>N�zev konfigura�n�ho souboru</strong>.</li>
                <li><strong>Vynechat potvrzen�</strong> - umo�n� v�m zvolit, zda chcete vynechat zobrazen� obrazovky Potvrzen� v Seznamu m�d�. I kdy� zvol�te Ano, Potvrzen� bude st�le zapisov�no do protokolu. V�choz� volbou je <strong>Ne</strong>.</li>
                <li><strong>Vynechat zpr�vy o akc�ch</strong> - umo�n� v�m zvolit, zda chcete vynechat zobrazen� obrazovky Zpr�va o akci v Seznamu m�d�. I kdy� zvol�te Ano, Zpr�va o akci bude st�le zapisov�na do protokolu. V�choz� volbou je
                    <strong>Ne</strong>.
                </li>
            </ul>
            </p></p>
        </td>
    </tr>


</table>
</body>
</html>

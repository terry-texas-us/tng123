<?php
include("../../helplib.php");
echo help_header("N�pov�da: H�bitovy");
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
                <a href="albums_help.php" class="lightlink">&laquo; N�pov�da: Alba</a> &nbsp; | &nbsp;
                <a href="places_help.php" class="lightlink">N�pov�da: M�sta &raquo;</a>
            </p>
            <span class="largeheader">N�pov�da: H�bitovy</span>
            <p class="smaller menu">
                <a href="#search" class="lightlink">Hledat</a> &nbsp; | &nbsp;
                <a href="#add" class="lightlink">P�idat nebo Upravit</a> &nbsp; | &nbsp;
                <a href="#delete" class="lightlink">Vymazat</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a name="search"><p class="subheadbold">Hledat</p></a>
            <p>Nalezen� existuj�c�ch h�bitov� vyhled�n�m cel�ho nebo ��sti <strong>ID ��sla h�bitova, n�zvu h�bitova, m�sta, okresu, kraje, zem�</strong> nebo <strong>n�zvu souboru mapy</strong>.
                V�sledkem hled�n� bez zadan�ch voleb a hodnot ve vyhled�vac�ch pol�ch bude seznam v�ech h�bitov� ve va�� datab�zi.</p>

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
            <a name="add"><p class="subheadbold">P�idat nov� / Upravit existuj�c� h�bitovy</p></a>
            <p>TNG v�m umo�n� t��dit a zobrazit va�e fotografie n�hrobk� podle h�bitov�. Aby toto fungovalo, mus�te pro ka�d� m�sto nastavit nov� z�znam h�bitova. Z�znamy
                h�bitov� v TNG se nevztahuj� k z�znam�m m�st a pro h�itovy neexistuje konvence GEDCOM, tak�e pokud v� soubor GEDCOM obsehuje v n�kter�ch m�stech poh�b�
                n�zvy h�bitov�, tyto n�zvy po naimporov�n� souboru GEDCOM nebudou v TNG zalo�eny jako z�znamy h�bitov�.</p>

            <p>Chcete-li p�idat nov� h�bitov, klikn�te na z�lo�ku <strong>P�idat nov�</strong> a pot� vypl�te formul��.
            <p>Chcete-li upravit existuj�c� h�bitov, pou�ijte
                z�lo�ku <a href="#search">Hledat</a> pro nalezen� h�bitova, a pot� klikn�te na ikonu Upravit vedle tohoto ��dku.</p>
            V�znam jednotliv�ch pol� p�i p�id�n� nebo �prav� h�bitova je n�sleduj�c�:</p>

            <span class="optionhead">N�zev h�bitova</span>
            <p>Vlo�te �pln� n�zev h�bitova. Nap�. H�bitov Kl�terec by m�l b�t zaps�n jako <em>H�bitov Kl�terec</em> a ne jen jako <em>Kl�terec</em>.</p>

            <span class="optionhead">Obr�zek pl�nu pro nahr�n�</span>
            <p>Pokud m�te pl�n nebo jinou fotografii tohoto h�bitova a je�t� jste ji nenahr�li na na va�e webov� str�nky, klikn�te na tla��tko "Prohledat" a najd�te ji na sv�m disku.
                Je-li fotografie ji� na va�ich str�nk�ch ve slo�ce n�hrobk�, nechat toto pole pr�zdn� a pou�ijte m�sto toho pole "N�zev souboru pl�nu ve slo�ce n�hrobk�".</p>

            <span class="optionhead">N�zev souboru pl�nu ve slo�ce n�hrobk�</span>
            <p>Pokud jste ji� d��ve nahr�li sv�j pl�n nebo fotografii do slo�ky n�hrobk�, zapi�te um�st�n� a n�zev souboru tak, jak existuje ve slo�ce n�hrobk� na va�ich webov�ch str�nk�ch,
                nebo klikn�te na tla��tko Vybrat pro nalezen� souboru. Jestli�e jste nahr�li sv�j pl�n nebo fotografii
                a� nyn� pomoc� p�edchoz�ho pole, pou�ijte toto pole k z�pisu um�st�n� a n�zvu souboru po jeho nahr�n�. P�edpokl�dan� um�st�n� a n�zev bude pro v�s p�edvypln�n.</p>

            <p><span class="optionhead">POZN.</span>: Budete-li na str�nky nahr�vat nyn�, adres��, kter� jste zde ozna�ili, mus� existovat a mus� m�t nastaveno pr�vo na z�pis.
                Pokud slo�ka neexistuje, m��ete ji vytvo�it pomoc� tla��tka "Vytvo�it slo�ku" v Z�kladn�m nastaven�. Nen�-li tato operace mo�n�, pou�ijte v� FTP program
                nebo jin� online souborov� spr�vce. </p>

            <span class="optionhead">Asociovan� m�sto</span>
            <p>Chcete-li tento h�bitov propojit s m�stem, zadejte sem n�zev m�sta tak, jak existuje ve va�� datab�zi nebo postupujte tak, �e
                vypln�te �daje m�sto, okres/farnost, kraj/provincie, zem� a klikn�te na tla��tko <strong>Doplnit m�sto</strong>.
                Kliknut�m na toto tla��tko se hodnoty, kter� jste zapsali do p�edchoz�ch pol�, vypln� do pole Asociovan� m�sto.</p>

            <p>Je-li h�bitov propojen s m�stem, �daje o h�bitovu budou zobrazeny na str�nce m�sta a seznam poh�b�
                spojen�ch s m�stem bude zobrazen na str�nce h�bitova.</p>

            <span class="optionhead">M�sto, Okres/farnost, Kraj/provincie, Zem�</span>
            <p>Zadejte co nejv�ce �daj� o um�st�n� tohoto h�bitova. Povinn� je zem�, ostatn� pole jsou nepovinn�.</p>

            <p>P�i vypln�n� pol� <strong>Kraj/provincie</strong> a <strong>Zem�</strong> vyberte existuj�c� z�pis z rozbalovac�ho seznamu. Pokud zde po�adovan� �daj nen�, pro p�id�n� do seznamu pou�ijte tla��tko "P�idat nov�".
                Pokud z�pis do tohoto seznamu nepat��, nejd��ve jej vyberte a pak klikn�te na tla��tko "Vymazat vybran�".</p>

            <span class="optionhead">Zobrazit/skr�t klikac� mapu</span>
            <p>Kliknut�m na tla��tko "Zobrazit/skr�t klikac� mapu" se zobraz� Google Map. Tato funkce je aktivn�, pokud jste obdr�eli od Google "kl��" a vlo�ili jej do
                sv�ho nastaven� map v TNG (viz <a href="mapconfig_help.php">N�pov�da pro nastaven� mapy</a> pro v�ce informac�). Op�tovn�m kliknut�m na toto tla��tko bude mapa skryta. Chcete-li, aby bylo um�st�n� vyhled�no v Google Maps,
                zapi�te toto um�st�n� do pole <strong>Geok�dovat um�st�n�</strong> a klikn�te na tla��tko "Hledat". Do mapy m��ete tak� klikat a pohybovat s n�, dokud
                nebude "�pendl�k" na po�adovan�m m�st�. M��ete tak� pou��t ovl�dac� prvek P�ibl�en� pro zobrazen� v�ce podrobnost� v okol� po�adovan� oblasti. Na str�nce
                <a href="places_googlemap_help.php">N�pov�da Google Maps</a> najdete v�ce informac�. Informace o v�choz�m nastaven� va�ich map najdete v <a href="mapconfig_help.php">N�pov�d�: Nastaven� map</a>.</p>

            <span class="optionhead">Zem�pisn� ���ka/d�lka</span>
            <p>Zapi�te sou�adnice zem�pisn� ���ky a d�lky h�bitova nebo pro nastaven� hodnot pou�ijte klikac� Google Map (nepovinn�, viz v��e).</p>

            <span class="optionhead">P�ibl�en�</span>
            <p>Zadejte �rove� p�ibl�en� nebo upravte ovl�dac� prvek p�ibl�en� v Google Map pro nastaven� �rovn� p�ibl�en�. Tato volba je dostupn� pouze, kdy� jste obdr�eli "kl��"
                od Google a zapsali jej do va�eho nastaven� map v TNG.</p>

            <span class="optionhead">Pozn�mky</span>
            <p>Jsou-li t�eba pro popis h�bitova nebo jeho m�sta je�t� dal�� informace, zapi�te je sem (nepovinn�).</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="delete"><p class="subheadbold">Vymazat h�bitovy</p></a>

            <p>Chcete-li odstranit h�bitov, pou�ijte z�lo�ku <a href="#search">Hledat</a> pro nalezen� h�bitova, a pot� klikn�te na ikonu Vymazat vedle tohoto z�znamu h�bitova. Tento ��dek zm�n�
                barvu a pot� po odstran�n� h�bitova zmiz�. Chcete-li najednou odstranit v�ce h�bitov�, za�krtn�te pol��ko ve sloupci Vybrat vedle ka�d�ho h�bitova, kter�
                chcete odstranit, a pot� klikn�te na tla��tko "Vymazat ozna�en�" na str�nce naho�e</p>


        </td>
    </tr>

</table>
</body>
</html>

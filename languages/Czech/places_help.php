<?php
include("../../helplib.php");
echo help_header("N�pov�da: M�sta");
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
                <a href="https://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br/>
                <a href="cemeteries_help.php" class="lightlink">&laquo; N�pov�da: H�bitovy</a> &nbsp; | &nbsp;
                <a href="places_googlemap_help.php" class="lightlink">N�pov�da: Google Maps &raquo;</a>
            </p>
            <span class="largeheader">N�pov�da: M�sta</span>
            <p class="smaller menu">
                <a href="#search" class="lightlink">Hledat</a> &nbsp; | &nbsp;
                <a href="#add" class="lightlink">P�idat nebo Upravit</a> &nbsp; | &nbsp;
                <a href="#delete" class="lightlink">Vymazat</a> &nbsp; | &nbsp;
                <a href="#merge" class="lightlink">Slou�it</a> &nbsp; | &nbsp;
                <a href="#merge" class="lightlink">Geok�dovat</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a name="search"><p class="subheadbold">Hledat</p></a>
            <p>Nalezen� existuj�c�ch m�st vyhled�n�m cel�ho nebo ��sti <strong>n�zvu m�sta</strong>. Pro dal�� z��en� v�sledk� va�eho hled�n� na m�sta spojen� s ur�it�m stromem vyberte tento strom.
                Za�krtnut�m "Chyb� zem�pisn� ���ka nebo d�lka" se zobraz� pouze m�sta, kter� je t�eba doplnit tyto �daje. Za�krtnut�m "Vyhledat pouze k�dy chr�m� CJKSpd" se zobraz� pouze p�tiznakov� n�zvy m�st,
                kter� byly ozna�eny jako chr�my CJKSpd. Za�krtnut�m volby "Pouze p�esn� shoda" v�sledek va�eho hled�n� d�le z���te.
                V�sledkem hled�n� bez zadan�ch voleb a hodnot ve vyhled�vac�ch pol�ch bude seznam v�ech m�st ve va�� datab�zi.</p>

            <p>Za�krtnut�m pol��ka "��dn� p�ipojen� ud�losti" zobraz�te pouze m�sta, kter� nejsou spojena s ��dn�mi ud�lostmi.</p>

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
            <a name="add"><p class="subheadbold">P�idat nov� / Upravit existuj�c� m�sta</p></a>

            <p>TNG automaticky p�id� z�znam nov�ho m�sta poka�d�, kdy� zap�ete nov� m�sto v Admin/Osoba, v Admin/Rodiny nebo jako sou��st n�jak� vlastn� ud�losti.
                Pokud na jak�koli z t�chto obrazovek zm�n�te existuj�c� m�sto a v�sledkem bude nov� jednozna�n� n�zev m�sta, nov� z�znam m�sta bude rovn� vytvo�en.</p>

            <p>Chcete-li p�idat nov� m�sto, klikn�te na z�lo�ku <strong>P�idat nov�</strong> a pot� vypl�te formul��.
            <p>Chcete-li upravit existuj�c� m�sto, pou�ijte
                z�lo�ku <a href="#search">Hledat</a> pro nalezen� m�sta, a pot� klikn�te na ikonu Upravit vedle tohoto ��dku.</p>
            V�znam jednotliv�ch pol� p�i p�id�n� nebo �prav� h�bitova je n�sleduj�c�:</p>

            <span class="optionhead">Strom</span>
            <p>Pokud jsou m�sta ve va�em Z�kladn�m nastaven� programu konfigurov�na tak, �e jsou spojena se stromy, uvid�te zde pole v�b�ru stromu. V tomto p��pad� vyberte jeden z va�ich existuj�c�ch strom�,
                proto�e ka�d� m�sto mus� b�t spojeno se stromem. <strong>Pozn.:</strong> Po vytvo�en� m�sta nelze zm�nit jeho spojen� se stromem
                (m�sto toho vyma�te m�sto a znovu jej zalo�te pod jin�m stromem). Pokud nechcete, aby byla m�sta spojen� se stromy, zm��te nastaven� v Admin/Nastaven�/Z�kladn� nastaven�/R�zn�.</p>

            <span class="optionhead">M�sto</span>
            <p>Zapi�te n�zev va�eho m�sta nejmen�� ��st� m�sta po��naje. V�echny ��sti m�sta by m�la b�t odd�lena ��rkoou. Nap�.
                <em>Kl�terec, �umperk, Olomouck� kraj, �esk� republika</em>. Nepou��vejte neur�it� nebo m�lozn�m� zkratky.</p>

            <span class="optionhead">Zobrazit/skr�t klikac� mapu</span>
            <p>Kliknut�m na tla��tko "Zobrazit/skr�t klikac� mapu" se zobraz� Google Map. Tato funkce je aktivn�, pokud jste obdr�eli od Google "kl��" a vlo�ili jej do
                sv�ho nastaven� map v TNG (viz <a href="mapconfig_help.php">N�pov�da pro nastaven� mapy</a> pro v�ce informac�). Op�tovn�m kliknut�m na toto tla��tko bude mapa skryta. Chcete-li, aby bylo um�st�n� vyhled�no v Google Maps,
                zapi�te toto um�st�n� do pole <strong>Geok�dovat um�st�n�</strong> a klikn�te na tla��tko "Hledat". Do mapy m��ete tak� klikat a pohybovat s n�, dokud
                nebude "�pendl�k" na po�adovan�m m�st�. M��ete tak� pou��t ovl�dac� prvek P�ibl�en� pro zobrazen� v�ce podrobnost� v okol� po�adovan� oblasti. Na str�nce
                <a href="places_googlemap_help.php">N�pov�da Google Maps</a> najdete v�ce informac�. Informace o v�choz�m nastaven� va�ich map najdete v <a href="mapconfig_help.php">N�pov�d�: Nastaven� map</a>.</p>

            <span class="optionhead">Zem�pisn� ���ka/d�lka</span>
            <p>Zapi�te sou�adnice zem�pisn� ���ky a d�lky m�sta nebo pro nastaven� hodnot pou�ijte klikac� Google Map (nepovinn�, viz v��e).</p>

            <span class="optionhead">P�ibl�en�</span>
            <p>Zadejte �rove� p�ibl�en� nebo upravte ovl�dac� prvek p�ibl�en� v Google Map pro nastaven� �rovn� p�ibl�en�. Tato volba je dostupn� pouze, kdy� jste obdr�eli "kl��"
                od Google a zapsali jej do va�eho nastaven� map v TNG.</p>

            <span class="optionhead">�rove� s�dla</span></p>
            <p>�rove� s�dla popisuje �rove� �len�n� s�dla zastoupen�ho n�zvem m�sta. Va�im n�v�t�vn�k�m to m��e pomoci poznat p�esnost um�st�n� �pendl�ku na map�.
                Nap�. chcete-li um�stit �pendl�k do Francie, ale nev�te, kam p�esn�, m�li byste vybrat v t�to volb�
                "Zem�", aby va�i n�v�t�vn�ci v�d�li, um�st�n� �pendl�ku ve Francii nen� p�esn�.</p>

            <span class="optionhead">H�bitovy</span>
            <p>Chcete-li spojit h�bitov s aktu�ln�m m�stem, klikn�te zde na tla��tko <strong>P�idat nov�</strong>.
                V mal�m okn�, kter� se objev�, vyberte ze seznamu, kter� jste vytvo�ili v Admin/H�bitovy h�bitov,
                a pot� klikn�te na tla��tko Go. Chcete-li vymazat h�bitov spojen� s aktu�ln�m m�stem, klikn�te na malou ikonu
                Vymazat vedle tohoto h�bitova.</p>

            <p>Je-li h�bitov propojen s m�stem, �daje o h�bitovu budou zobrazeny na str�nce m�sta a seznam poh�b�
                spojen�ch s m�stem bude zobrazen na str�nce h�bitova.</p>

            <span class="optionhead">Pozn�mky</span>
            <p>Do tohoto pole zapi�te jak�koli pozn�mky, kter� maj� vztah k va�emu m�stu.</p>

            <span class="optionhead">Prov�st zm�ny n�zvu m�sta v existuj�c�ch ud�lostech</span>
            <p>Toto za�krtnut� pol��ko (viditeln� pouze p�i �prav� existuj�c�ho m�sta) ozna�uje, �e budou p�i ulo�en� zm�n
                aktualizov�ny v�echny ud�losti, kde je toto m�sto pou�ito.</p>

            <p><strong>POZN.:</strong> V�echny n�sledn� importy soubor� GEDCOM, kde je za�krtnuta volba "Nahradit v�echna aktu�ln� data" nep�ep�e nebo nevyma�e
                existuj�c� �daje o m�stech, pokud existuj�c� z�znamy obsahuj� �daje v pol�ch zem�pisn� ���ka, d�lka nebo pozn�mky nebo jsou p�ipojena n�jak� m�dia.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="delete"><p class="subheadbold">Vymazat m�sta</p></a>
            <p>Chcete-li odstranit m�sto, pou�ijte z�lo�ku <a href="#search">Hledat</a> pro nalezen� m�sta, a pot� klikn�te na ikonu Vymazat vedle tohoto z�znamu m�sta. Tento ��dek zm�n�
                barvu a pot� po odstran�n� m�sta zmiz�. Chcete-li najednou odstranit v�ce m�st, za�krtn�te pol��ko ve sloupci Vybrat vedle ka�d�ho m�sta, kter�
                chcete odstranit, a pot� klikn�te na tla��tko "Vymazat ozna�en�" na str�nce naho�e</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="merge"><p class="subheadbold">Slou�it m�sta</p></a>
            <p>Kliknut�m na tuto z�lo�ku lze p�ezkoumat a slou�it n�zvy m�st, kter� jsou lehce odli�n�, ale odkazuj� na stejn� m�sto.
                Mus�te rozhodnout, zda jsou tyto z�znamy toto�n� nebo ne.</p>

            <span class="optionhead">Naj�t kandid�ty pro slou�en�</span>
            <p>Pokud je ve va�em Z�kladn�m nastaven� konfigurov�no, �e m�sta jsou spojena se stromy, uvid�te zde v�b�rov� pole Strom. V tomto p��pad� vyberte strom.
                Nelze slu�ovat m�sta z r�zn�ch strom�, tak�e lze vybrat pouze jeden strom. Pot� zadejte v�b�rov� krit�ria,
                kter� budou spole�n� pro v�echny potenci�ln� duplicity. M��ete nap�. zapsat <em>Horn� Star�</em> pro nalezen�
                <em>Horn� Star�</em> a <em>Horn� Star� M�sto</em>.</p>
            <p>Do prvn�ho pole mus�te n�co zapsat, druh� pole je nepovinn�. Chcete-li slou�it dv� m�sta, jejich� n�zvy nejsou moc podobn�,
                m��ete n�co zapsat i do druh�ho pole. Nap�. pokud chcete slou�it <em>TU</em> a <em>Trutnov</em>, bude nejlep�� zapsat do prvn�ho pole <em>TU</em>
                a do druh�ho <em>Trutnov</em>. Po dokon�en� z�pisu krit�ri� klikn�te na "Pokra�ovat".</p>

            <span class="optionhead">Vybrat m�sta pro slou�en�</span>
            <p>Pod t�mto nadpisem uvid�te seznam v�sledk�, kter� odpov�daj� va�im v�b�rov�m krit�ri�m. Pokud n�kter� z nich odkazuj� na stejn� um�st�n�,
                za�krtn�te pol��ko ozna�en� "Slou�it tyto (vymazat)" nalevo od ka�d�ho. Ka�d� vybran� ��dek z�erven�. D�le klikn�te na p�ep�na� ve sloupci ozna�en�m "do t�chto (ponechat)", jeho�
                n�zev m�sta nahrad� v�echny za�krtnut� m�sta. Tento ��dek zezelen�. Nez�le�� to na tom, zda n�zev m�sta, kter� m� b�t ponech�n, je sou�asn�
                za�krtnut jako "Slou�it tyto (vymazat)". Pro "ponech�n�" m��ete vybrat pouze jedno m�sto na jedno slou�en�, ale m��ete vybrat
                n�kolik m�st, kter� chcete slou�it do jednoho. Pokud jste p�ipraveni slou�it m�sta, klikn�te na tla��tko "Slou�it m�sta"
                na obrazovce naho�e nebo dole. V�echny v�skyty vymazan�ch m�st (v z�znamech osoby nebo rodiny) budou nahrazeny n�zvem, kter� jste vybrali, �e m� b�t ponech�n.
                <strong>Pozn.:</strong> Pozn�mky a �daje o zem�pisn� ���ce a d�lce z�stanou u m�st, kter� ponech�v�te.</p>

            <p>Pamatujte na to, �e se zvy�uj�c�m po�tem polo�ek, kter� jsou vybr�ny ke slou�en�, kles� v�kon. Jin�mi slovy slou�en� dvou m�st prob�hne mnohem rychleji ne� slou�en� 20 m�st.</p>

            <p>Chcete-li znovu vyhledat, ani� byste slu�ovali, zapi�te novou hodnotu do pole "Hledat" na obrazovce naho�e a klikn�te znovu na "Pokra�ovat".</p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Nahoru</a></p>
            <a name="geo"><p class="subheadbold">Geok�dovat</p></a>
            <p>N�stroj Geok�dov�n� lze pou��t k nalezen� a ulo�en� sou�adnic zem�pisn� ���ky a d�lky pro m�sta, kter� tyto �daje neobsahuj�.</p>

            <span class="optionhead">Omezen�</span>
            <p>D�lka trv�n� tohoto procesu z�le�� na po�tu m�st, kter� je pot�eba geok�dovat. Google tak� omezuje po�et m�st na 2500 denn�. Z t�chto d�vod� m��ete omezit po�et m�st, kter� maj� b�t ok�dov�na najednou.
                V�choz� po�et je 100. Pokud zjist�te, �e prvn�ch 100 m�st prob�hlo rychle, m��ete v dal�� d�vce tento po�et zv��it.</p>

            <span class="optionhead">Pokud bude pro jedno m�sto nalezeno v�ce v�sledk�:</span>
            <p>Je-li n�zev m�sta nejednozna�n�, Google m��e vr�tit v�ce v�sledk�. V tomto p��pad� doporu�ujeme odm�tnout v�echny vr�cen� v�sledky (tak�e m��ete
                dohled�n� prov�st pozd�ji ru�n�), ale m��ete tak� zvolit, aby TNG akceptoval prvn� nalezen� v�sledek.</p>
        </td>
    </tr>

</table>
</body>
</html>

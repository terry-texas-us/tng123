<?php
include "../../helplib.php";
echo help_header("N�pov�da: Hled� se");
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="misc_help.php" class="lightlink">&laquo; N�pov�da: R�zn�</a> &nbsp;|&nbsp;
                <a href="data_help.php" class="lightlink">N�pov�da: Import / Export &raquo;</a>
            </p>
            <h2 class="largeheader">N�pov�da: <small>Hled� se</small></h2>
            <p class="smaller menu" style="clear: both;">
                <a href="#add" class="lightlink">P�idat nov�</a> &nbsp;|&nbsp;
                <a href="#edit" class="lightlink">Upravit existuj�c�</a> &nbsp;|&nbsp;
                <a href="#sort" class="lightlink">T��dit</a> &nbsp;|&nbsp;
                <a href="#delete" class="lightlink">Vymazat</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="add"><h4 class="subheadbold">P�id�n� nov�ch z�pis�</h4></a>
            <p>Funkce <strong>Hled� se</strong> v�m umo�n� vytvo�it seznam kritick�ch osob nebo fotografi�, se kter�mi m�te ve sv�m b�d�n� probl�my.
                Tento seznam je rozd�len do dvou kategori�, <strong>Hledan� osoby</strong> a <strong>Tajemn� fotografie</strong>. Chcete-li do n�jak�
                kategorie p�idat nov� z�pis,
                klikn�te na tla��tko "P�idat nov�" pod p��slu�n�m nadpisem a pot� vypl�te formul��. V�znam pol� je n�sleduj�c�:</p>

            <h5>Titul</h5>
            <p>Va�emu z�pisu dejte titul, kter� m��e b�t i ot�zkou. Nap�. <em>Kdo je tato osoba?</em> nebo <em>Kdo je otcem Josefa Nov�ka?</em></p>

            <h5>Popis</h5>
            <p>Va�emu z�pisu dejte tak� kr�tk� popis. M��e obsahovat aktu�ln� �daje, kter� jste shrom�dili, p�ek�ky, na kter� jste narazili
                nebo n�jak� konkr�tn� informace, kter� hled�te.</p>

            <h5>Strom</h5>
            <p>Pokud chcete, m��ete spojit tento z�pis se stromem (nepovinn�).</p>

            <h5>Osoba</h5>
            <p>Je-li tento z�pis �zce spojen s n�jakou osobou, zapi�te ID ��slo osoby nebo klikn�te na ikonu lupy pro jej� vyhled�n�. Po nalezen�
                po�adovan�
                osoby klikn�te na odkaz "Vybrat" a vr�t�te se do formul��e Hled� se s vybran�m ID ��slem.</p>

            <h5>Vybrat fotografii</h5>
            <p>Je-li tento z�pis �zce spojen s n�jakou fotografi�, klikn�te na tla��tko "Vybrat fotografii" pro vyhled�n� t�to fotografie ze z�znam�
                fotografi�
                z va�� datab�ze. Po nalezen� po�adovan� fotografie klikn�te na odkaz "Vybrat" a vr�t�te se do formul��e Hled� se s vybran�m ID
                ��slem.</p>

            <p>Po dokon�en� klikn�te na tla��tko "Ulo�it" a vr�t�te se do seznamu. V� nov� z�pis bude p�id�n na konec kategorie, do kter� jste ho
                p�idali.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="edit"><h4 class="subheadbold">�prava existuj�c�ch z�pis�</h4></a>
            <p>Chcete-li existuj�c� z�pis upravit, p�esu�te kursor my�i nad z�znam, kter� chcete upravit. Pod t�mto z�pisem by se m�ly objevit odkazy
                "Upravit" a "Vymazat". Kliknut�m
                na odkaz "Upravit" se zobraz� formul��, ve kter�m m��ete prov�st sv� zm�ny. Pole ve formul��i jsou stejn� jako jsou pops�na v��e v
                odstavci "P�id�n� nov�ch z�pis�".</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="sort"><h4 class="subheadbold">T��d�n� z�pis�</h4></a>
            <p>Chcete-li zm�nit po�ad� z�pis�, kter� jste vytvo�ili v sekci Hled� se, chytn�te je a p�et�hn�te na po�adovan� m�sto (klikn�te na oblast
                "T�hnout", podr�te tla��tko my�i,
                dokud nep�esunete ukazov�tko na po�adovan� m�sto a pak my� uvoln�te). </p>

            <p><strong>POZN.:</strong> Z�pisy <strong>m��ete</strong> p�esunout z jednoho seznamu do druh�ho (nap�. p�esunout z�pis z "Hledan�ch osob"
                do "Tajemn�ch fotografi�").</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Nahoru</a></p>
            <a id="delete"><h4 class="subheadbold">Vymaz�n� existuj�c�ch z�pis�</h4></a>
            <p>Chcete-li existuj�c� z�pis vymazat, p�esu�te kursor my�i nad z�znam, kter� chcete vymazat. Pod t�mto z�pisem by se m�ly objevit odkazy
                "Upravit" a "Vymazat". Kliknut�m
                na odkaz "Vymazat" z�pis odstran�te (p�ed t�m budete po��d�ni o potvrzen� t�to akce).</p>

        </td>
    </tr>

</table>
</body>
<?php echo "</html>"; ?>

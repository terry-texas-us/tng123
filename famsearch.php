<?php
$textpart = "search";
$order = "";
include "tng_begin.php";
global $responsivetables, $tabletype, $enablemodeswitch, $enableminimap;

include "searchlib.php";

@set_time_limit(0);
$maxsearchresults = $nr ? $nr : ($_SESSION['tng_nr'] ? $_SESSION['tng_nr'] : $maxsearchresults);

$_SESSION['tng_search_ftree'] = $tree;
$_SESSION['tng_search_branch'] = $branch;
$_SESSION['tng_search_flnqualify'] = $flnqualify;
$myflastname = trim(stripslashes($myflastname));
$_SESSION['tng_search_flastname'] = cleanIt($myflastname);

$_SESSION['tng_search_ffnqualify'] = $ffnqualify;
$myffirstname = trim(stripslashes($myffirstname));
$_SESSION['tng_search_ffirstname'] = cleanIt($myffirstname);

$_SESSION['tng_search_mlnqualify'] = $mlnqualify;
$mymlastname = trim(stripslashes($mymlastname));
$_SESSION['tng_search_mlastname'] = cleanIt($mymlastname);

$_SESSION['tng_search_mfnqualify'] = $mfnqualify;
$mymfirstname = trim(stripslashes($mymfirstname));
$_SESSION['tng_search_mfirstname'] = cleanIt($mymfirstname);

$_SESSION['tng_search_fidqualify'] = $fidqualify;
$myfamilynid = trim(stripslashes($myfamilyid));
$_SESSION['tng_search_familyid'] = cleanIt($myfamilynid);

$_SESSION['tng_search_mpqualify'] = $mpqualify;
$mymarrplace = trim(stripslashes($mymarrplace));
$_SESSION['tng_search_marrplace'] = cleanIt($mymarrplace);

$_SESSION['tng_search_myqualify'] = $myqualify;
$mymarryear = trim(stripslashes($mymarryear));
$_SESSION['tng_search_marryear'] = cleanIt($mymarryear);

$_SESSION['tng_search_dvpqualify'] = $dvpqualify;
$mydivplace = trim(stripslashes($mydivplace));
$_SESSION['tng_search_divplace'] = cleanIt($mydivplace);

$_SESSION['tng_search_dvyqualify'] = $dvyqualify;
$mydivyear = trim(stripslashes($mydivyear));
$_SESSION['tng_search_divyear'] = cleanIt($mydivyear);

$_SESSION['tng_search_mtqualify'] = $mtqualify;
$mymarrtype = trim(stripslashes($mymarrtype));
$_SESSION['tng_search_marrtype'] = cleanIt($mymarrtype);

$_SESSION['tng_search_fbool'] = $mybool;
$_SESSION['tng_nr'] = $nr;
if ($order) {
    $_SESSION['tng_search_forder'] = $order;
} else {
    $order = $_SESSION['tng_search_forder'] ?? "fname";
}

$marrsort = "marr";
$divsort = "div";
$fnamesort = "fnameup";
$mnamesort = "mnameup";
$orderloc = strpos($_SERVER['QUERY_STRING'], "&order=");
$currargs = $orderloc > 0 ? substr($_SERVER['QUERY_STRING'], 0, $orderloc) : $_SERVER['QUERY_STRING'];
$mybooltext = $mybool == "AND" ? $text['cap_and'] : $text['cap_or'];

if ($order == "marr") {
    $orderstr = "marrdatetr, marrplace, father.lastname, father.firstname";
    $marrsort = "<a href='search.php?$currargs&order=marrup' class='lightlink'>{$text['married']} <img src='img/tng_sort_desc.gif' alt='' class='sortimg inline-block'></a>";
} else {
    $marrsort = "<a href='search.php?$currargs&order=marr' class='lightlink'>{$text['married']} <img src='img/tng_sort_asc.gif' alt='' class='sortimg inline-block'></a>";
    if ($order == "marrup") {
        $orderstr = "marrdatetr DESC, marrplace DESC, father.lastname, father.firstname";
    }
}

if ($order == "div") {
    $orderstr = "divdatetr, divplace, father.lastname, father.firstname, marrdatetr";
    $divsort = "<a href='search.php?$currargs&order=divup' class='lightlink'>{$text['divorced']} <img src='img/tng_sort_desc.gif' alt='' class='sortimg inline-block'></a>";
} else {
    $divsort = "<a href='search.php?$currargs&order=div' class='lightlink'>{$text['divorced']} <img src='img/tng_sort_asc.gif' alt='' class='sortimg inline-block'></a>";
    if ($order == "divup") {
        $orderstr = "divdatetr DESC, divplace DESC, father.lastname, father.firstname, marrdatetr";
    }
}

if ($order == "fname") {
    $orderstr = "father.lastname, father.firstname, marrdatetr";
    $fnamesort = "<a href='search.php?$currargs&order=fnameup' class='lightlink'>{$text['fathername']} <img src='img/tng_sort_desc.gif' alt='' class='sortimg inline-block'></a>";
} else {
    $fnamesort = "<a href='search.php?$currargs&order=fname' class='lightlink'>{$text['fathername']} <img src='img/tng_sort_asc.gif' alt='' class='sortimg inline-block'></a>";
    if ($order == "fnameup") {
        $orderstr = "father.lastname DESC, father.firstname DESC, marrdatetr";
    }
}

if ($order == "mname") {
    $orderstr = "mother.lastname, mother.firstname, marrdatetr";
    $mnamesort = "<a href='search.php?$currargs&order=mnameup' class='lightlink'>{$text['mothername']} <img src='img/tng_sort_desc.gif' alt='' class='sortimg inline-block'></a>";
} else {
    $mnamesort = "<a href='search.php?$currargs&order=mname' class='lightlink'>{$text['mothername']} <img src='img/tng_sort_asc.gif' alt='' class='sortimg inline-block'></a>";
    if ($order == "mnameup") {
        $orderstr = "mother.lastname DESC, mother.firstname DESC, marrdatetr";
    }
}

function buildCriteria($column, $colvar, $qualifyvar, $qualifier, $value, $textstr) {
    global $lnprefixes, $criteria_limit, $criteria_count;

    if ($qualifier == "exists" || $qualifier == "dnexist") {
        $value = $usevalue = "";
    } else {
        $value = urldecode(trim($value));
        $usevalue = addslashes($value);
    }

    if ($column == "father.lastname" && $lnprefixes) {
        $column = "TRIM(CONCAT_WS(' ',father.lnprefix,father.lastname))";
    } elseif ($column == "mother.lastname") {
        $column = "TRIM(CONCAT_WS(' ',mother.lnprefix,mother.lastname))";
    }

    $criteria_count++;
    if ($criteria_count >= $criteria_limit) {
        die("sorry");
    }
    $criteria = "";
    $returnarray = buildColumn($qualifier, $column, $usevalue);
    $criteria .= $returnarray['criteria'];
    $qualifystr = $returnarray['qualifystr'];

    addtoQuery($textstr, $colvar, $criteria, $qualifyvar, $qualifier, $qualifystr, $value);
}

$querystring = "";
$allwhere = "";

if ($myflastname || $flnqualify == "exists" || $flnqualify == "dnexist") {
    if ($myflastname == $text['nosurname']) {
        addtoQuery("lastname", "myflastname", "father.lastname = \"\"", "flnqualify", $text['equals'], $text['equals'], $myflastname);
    } else {
        buildCriteria("father.lastname", "myflastname", "flnqualify", $flnqualify, $myflastname, $text['lastname']);
    }
}
if ($myffirstname || $ffnqualify == "exists" || $ffnqualify == "dnexist") {
    buildCriteria("father.firstname", "myffirstname", "ffnqualify", $ffnqualify, $myffirstname, $text['firstname']);
}

if ($mymlastname || $mlnqualify == "exists" || $mlnqualify == "dnexist") {
    if ($mymlastname == $text['nosurname']) {
        addtoQuery("lastname", "mymlastname", "mother.lastname = \"\"", "mlnqualify", $text['equals'], $text['equals'], $mymlastname);
    } else {
        buildCriteria("mother.lastname", "mymlastname", "mlnqualify", $mlnqualify, $mymlastname, $text['lastname']);
    }
}
if ($mymfirstname || $mfnqualify == "exists" || $mfnqualify == "dnexist") {
    buildCriteria("mother.firstname", "mymfirstname", "mfnqualify", $mfnqualify, $mymfirstname, $text['firstname']);
}

if ($myfamilyid) {
    $myfamilyid = strtoupper($myfamilyid);
    if ($fidqualify == "equals" && is_numeric($myfamilyid)) {
        $myfamilyid = $familyprefix . $myfamilyid . $familysuffix;
    }
    buildCriteria("familyID", "myfamilyid", "fidqualify", $fidqualify, $myfamilyid, $text['familyid']);
}
if ($mymarrplace || $mpqualify == "exists" || $mpqualify == "dnexist") {
    buildCriteria("marrplace", "mymarrplace", "mpqualify", $mpqualify, $mymarrplace, $text['marrplace']);
}
if ($mymarryear || $myqualify == "exists" || $myqualify == "dnexist") {
    buildYearCriteria("marrdatetr", "mymarryear", "myqualify", "", $myqualify, $mymarryear, $text['marrdatetr']);
}
if ($mydivplace || $dvpqualify == "exists" || $dvpqualify == "dnexist") {
    buildCriteria("divplace", "mydivplace", "dvpqualify", $dvpqualify, $mydivplace, $text['divplace']);
}
if ($mydivyear || $dvyqualify == "exists" || $dvyqualify == "dnexist") {
    buildYearCriteria("divdatetr", "mydivyear", "dvyqualify", "", $dvyqualify, $mydivyear, $text['divdatetr']);
}
if ($mymarrtype || $mtqualify == "exists" || $mtqualify == "dnexist") {
    buildCriteria("marrtype", "mymarrtype", "mtqualify", $mtqualify, $mymarrtype, $text['marrtype']);
}

$dontdo = ["MARR", "DIV"];
$cejoin = doCustomEvents("F");

if ($tree) {
    if ($urlstring) $urlstring .= "&amp;";

    $urlstring .= "tree=$tree";

    if ($querystring) $querystring .= " AND ";

    require_once "./admin/trees.php";
    $treerow = getTree($trees_table, $tree);

    $querystring .= $text['tree'] . " {$text['equals']} {$treerow['treename']}";

    if ($allwhere) $allwhere = "($allwhere) AND";

    $allwhere .= " f.gedcom = '$tree'";

    if ($branch) {
        $urlstring .= "&amp;branch=$branch";
        $querystring .= " {$text['cap_and']} ";

        $query = "SELECT description FROM $branches_table WHERE gedcom = '$tree' AND branch = '$branch'";
        $branchresult = tng_query($query);
        $branchrow = tng_fetch_assoc($branchresult);
        tng_free_result($branchresult);

        $querystring .= $text['branch'] . " {$text['equals']} {$branchrow['description']}";

        $allwhere .= " AND f.branch like \"%$branch%\"";
    }
}

$numtrees = getTreesCount($trees_table);

$gotInput = $mymarrplace || $mydivplace || $mymarryear || $mydivyear || $ecount;
$more = getLivingPrivateRestrictions("f", false, $gotInput);

if ($more) {
    if ($allwhere) {
        $allwhere = $tree ? "$allwhere AND " : "($allwhere) AND ";
    }
    $allwhere .= $more;
}

if ($allwhere) {
    $allwhere = "WHERE " . $allwhere . " AND ";
    $querystring = "{$text['text_for']} $querystring";
} else {
    $allwhere = "WHERE ";
}

$max_browsesearch_pages = 5;
if ($offset) {
    $offsetplus = $offset + 1;
    $newoffset = "$offset, ";
} else {
    $offsetplus = 1;
    $newoffset = "";
    $page = 1;
}

//left join to people table twice, once for husband and for wife
$query = "SELECT f.ID, familyID, husband, wife, marrdate, marrplace, divdate, divplace, f.gedcom AS gedcom, f.living, f.private, f.branch, treename, father.lastname as flastname, father.lnprefix as flnprefix, father.firstname as ffirstname, father.living as fliving, father.private as fprivate, father.branch as fbranch, mother.lastname as mlastname, mother.lnprefix as mlnprefix, mother.firstname as mfirstname, mother.living as mliving, mother.private as fprivate, mother.branch as mbranch ";
$query .= "FROM ($families_table f, $trees_table trees) ";
$query .= "$cejoin ";
$query .= "LEFT JOIN $people_table AS father ON f.gedcom=father.gedcom AND husband = father.personID ";
$query .= "LEFT JOIN $people_table AS mother ON f.gedcom=mother.gedcom AND wife = mother.personID ";
$query .= "$allwhere (f.gedcom = trees.gedcom) ";
$query .= "ORDER BY $orderstr ";
$query .= "LIMIT $newoffset" . $maxsearchresults;

$query2 = "SELECT count(f.ID) AS fcount ";
$query2 .= "FROM ($families_table f, $trees_table trees) ";
$query2 .= "$cejoin ";
$query2 .= "LEFT JOIN $people_table AS father ON f.gedcom=father.gedcom AND husband = father.personID ";
$query2 .= "LEFT JOIN $people_table AS mother ON f.gedcom=mother.gedcom AND wife = mother.personID ";
$query2 .= "$allwhere (f.gedcom = trees.gedcom)";

$result = tng_query($query);
$numrows = tng_num_rows($result);

if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $result2 = tng_query($query2) or die ($text['cannotexecutequery'] . ": $query2");
    $countrow = tng_fetch_assoc($result2);
    $totrows = $countrow['fcount'];
    tng_free_result($result2);
} else {
    $totrows = $numrows;
}

if (!$numrows) {
    $msg = $text['noresults'] . " $querystring. " . $text['tryagain'] . ".";
    header("Location: famsearchform.php?msg=" . urlencode($msg));
    exit;
}
echo "<!doctype html>\n";
echo "<html lang='en'>\n";

tng_header($text['searchresults'], $flags);
?>
    <script src="js/search.js"></script>
    <script>
        // <![CDATA[
        const ajx_fampreview = 'ajx_fampreview.php';
        // ]]>
    </script>

    <h2 class="header"><span class="headericon" id="fsearch-hdr-icon"></span><?php echo $text['searchresults']; ?></h2>
    <br style="clear: left;">
<?php
$logstring = "<a href=\"famsearch.php?{$_SERVER['QUERY_STRING']}\">" . xmlcharacters($text['searchresults'] . " $querystring") . "</a>";
writelog($logstring);
preparebookmark($logstring);

$numrowsplus = $numrows + $offset;

echo "<p class='normal'>" . $text['matches'] . " $offsetplus " . $text['to'] . " $numrowsplus " . $text['of'] . " " . number_format($totrows) . " $querystring</p>";

$pagenav = get_browseitems_nav($totrows, "famsearch.php?" . "$urlstring&amp;mybool=$mybool&amp;nr=$maxsearchresults&amp;showspouse=$showspouse&amp;showdeath=$showdeath&amp;offset", $maxsearchresults, $max_browsesearch_pages);
echo "<p class='normal'>$pagenav</p>";

$header = $headerr = "";
if ($enablemodeswitch) {
    $headerr = "data-tablesaw-mode-switch>\n";
} else {
    $headerr = ">\n" . $header;
}

if ($enableminimap) {
    $headerr = " data-tablesaw-minimap " . $headerr;
} else {
    $headerr = $headerr;
}
$header = "<table cellpadding='3' cellspacing='1' border='0' class='whiteback'>\n" . $header;
echo $header;
?>
    <thead>
    <tr>
        <th data-tablesaw-priority="persist" class="fieldnameback nbrcol"><span class="fieldname"># </span></th>
        <th data-tablesaw-priority="3" class="fieldnameback fieldname text-nowrap"><?php echo $text['familyid']; ?></th>
        <th data-tablesaw-priority="1" class="fieldnameback fieldname text-nowrap"><?php echo $fnamesort; ?></th>
        <th data-tablesaw-priority="1" class="fieldnameback fieldname text-nowrap"><?php echo $mnamesort; ?></th>
        <th data-tablesaw-priority="2" class="fieldnameback fieldname text-nowrap"><?php echo $marrsort; ?></th>
        <th data-tablesaw-priority="4" class="fieldnameback fieldname"><?php echo $text['location']; ?></th>
        <?php if ($mydivplace || $mydivyear) { ?>
            <th data-tablesaw-priority="3" class="fieldnameback fieldname text-nowrap"><?php echo $divsort; ?></th>
            <th data-tablesaw-priority="5" class="fieldnameback fieldname"><?php echo $text['location']; ?></th>
            <?php
        }
        if ($numtrees > 1) {
            ?>
            <th data-tablesaw-priority="5" class="fieldnameback fieldname text-nowrap"><?php echo $text['tree']; ?></th>
        <?php } ?>
    </tr>
    </thead>
<?php
$i = $offsetplus;
while ($row = tng_fetch_assoc($result)) {
    //assemble frow and mrow, override family living flag if allow_living for either of these is no
    $frow = [
        "firstname" => $row['ffirstname'],
        "lnprefix" => $row['flnprefix'],
        "lastname" => $row['flastname'],
        "living" => $row['fliving'],
        "private" => $row['fprivate'],
        "branch" => $row['fbranch']
    ];
    $rights = determineLivingPrivateRights($frow);
    $frow['allow_living'] = $rights['living'];
    $frow['allow_private'] = $rights['private'];

    $mrow = [
        "firstname" => $row['mfirstname'],
        "lnprefix" => $row['mlnprefix'],
        "lastname" => $row['mlastname'],
        "living" => $row['mliving'],
        "branch" => $row['mbranch'],
        "private" => $row['mprivate']
    ];
    $rights = determineLivingPrivateRights($mrow);
    $mrow['allow_living'] = $rights['living'];
    $mrow['allow_private'] = $rights['private'];

    $rights = determineLivingPrivateRights($row);
    if ($rights['both']) {
        $marrdate = $row['marrdate'] ? displayDate($row['marrdate']) : "";
        $marrplace = $row['marrplace'] ? $row['marrplace'] . " " . placeImage($row['marrplace']) : "";
        $divdate = $row['divdate'] ? displayDate($row['divdate']) : "";
        $divplace = $row['divplace'] ? $row['divplace'] . " " . placeImage($row['divplace']) : "";
    } else {
        $marrdate = $marrplace = $divdate = $divplace = $livingOK = "";
    }
    $fname = getNameRev($frow);
    $mname = getNameRev($mrow);
    $famidstr = "<a href=\"familygroup.php?familyID={$row['familyID']}&amp;tree={$row['gedcom']}\" class=\"fam\" id=\"f{$row['familyID']}_t{$row['gedcom']}\">{$row['familyID']} </a>";
    echo "<tr>";
    echo "<td class='databack'>$i</td>\n";
    $i++;
    echo "<td class='databack'>$famidstr";
    echo "<div class='person-img' id=\"mi{$row['gedcom']}_{$row['familyID']}\">\n";
    echo "<div class='person-prev' id=\"prev{$row['gedcom']}_{$row['familyID']}\"></div>\n";
    echo "</div>\n";
    echo "&nbsp;</td>";
    echo "<td class='databack'>$fname&nbsp;</td>";
    echo "<td class='databack'>$mname&nbsp;</td>";
    echo "<td class='databack'>$marrdate&nbsp;</td>";
    echo "<td class='databack'>$marrplace&nbsp;</td>";
    if ($mydivyear || $mydivplace) {
        echo "<td class='databack'>$divdate </td>";
        echo "<td class='databack'>$divplace&nbsp;</td>";
    }

    if ($numtrees > 1) {
        echo "<td class='databack'><a href=\"showtree.php?tree={$row['gedcom']}\">{$row['treename']}</a>&nbsp;</td>";
    }

    echo "</tr>\n";
}
tng_free_result($result);
?>
    </table>

<?php
echo "<p>$pagenav</p><br>";
tng_footer("");
?>
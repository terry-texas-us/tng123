<?php

$textpart = "search";
$order = "";
include "tng_begin.php";
include "searchlib.php";
require_once "admin/pagination.php";
require_once "admin/trees.php";

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
$mybooltext = $mybool == "AND" ? _('AND') : _('OR');
if ($order == "marr") {
    $orderstr = "marrdatetr, marrplace, father.lastname, father.firstname";
    $marrsort = "<a href='famsearch.php?$currargs&order=marrup' class='lightlink'>" . _('Married') . " <img src='img/tng_sort_desc.gif' alt='' class='inline-block sortimg'></a>";
} else {
    $marrsort = "<a href='famsearch.php?$currargs&order=marr' class='lightlink'>" . _('Married') . " <img src='img/tng_sort_asc.gif' alt='' class='inline-block sortimg'></a>";
    if ($order == "marrup") {
        $orderstr = "marrdatetr DESC, marrplace DESC, father.lastname, father.firstname";
    }
}
if ($order == "div") {
    $orderstr = "divdatetr, divplace, father.lastname, father.firstname, marrdatetr";
    $divsort = "<a href='famsearch.php?$currargs&order=divup' class='lightlink'>" . _('Divorced') . " <img src='img/tng_sort_desc.gif' alt='' class='inline-block sortimg'></a>";
} else {
    $divsort = "<a href='famsearch.php?$currargs&order=div' class='lightlink'>" . _('Divorced') . " <img src='img/tng_sort_asc.gif' alt='' class='inline-block sortimg'></a>";
    if ($order == "divup") {
        $orderstr = "divdatetr DESC, divplace DESC, father.lastname, father.firstname, marrdatetr";
    }
}
if ($order == "fname") {
    $orderstr = "father.lastname, father.firstname, marrdatetr";
    $fnamesort = "<a href='famsearch.php?$currargs&order=fnameup' class='lightlink'>{_('Father\'s Name')} <img src='img/tng_sort_desc.gif' alt='' class='inline-block sortimg'></a>";
} else {
    $fnamesort = "<a href='famsearch.php?$currargs&order=fname' class='lightlink'>{_('Father\'s Name')} <img src='img/tng_sort_asc.gif' alt='' class='inline-block sortimg'></a>";
    if ($order == "fnameup") {
        $orderstr = "father.lastname DESC, father.firstname DESC, marrdatetr";
    }
}
if ($order == "mname") {
    $orderstr = "mother.lastname, mother.firstname, marrdatetr";
    $mnamesort = "<a href='famsearch.php?$currargs&order=mnameup' class='lightlink'>{_('Mother\'s Name')} <img src='img/tng_sort_desc.gif' alt='' class='inline-block sortimg'></a>";
} else {
    $mnamesort = "<a href='famsearch.php?$currargs&order=mname' class='lightlink'>{_('Mother\'s Name')} <img src='img/tng_sort_asc.gif' alt='' class='inline-block sortimg'></a>";
    if ($order == "mnameup") {
        $orderstr = "mother.lastname DESC, mother.firstname DESC, marrdatetr";
    }
}
/**
 * @param $column
 * @param $colvar
 * @param $qualifyvar
 * @param $qualifier
 * @param $value
 * @param $textstr
 */
function buildCriteria($column, $colvar, $qualifyvar, $qualifier, $value, $textstr) {
    global $lnprefixes, $criteria_limit, $criteria_count;
    if ($qualifier == "exists" || $qualifier == "dnexist") {
        $value = $usevalue = "";
    } else {
        $value = urldecode(trim($value));
        $usevalue = addslashes($value);
    }
    if ($column == "father.lastname" && $lnprefixes) {
        $column = "TRIM(CONCAT_WS(' ', father.lnprefix, father.lastname))";
    } elseif ($column == "mother.lastname") {
        $column = "TRIM(CONCAT_WS(' ', mother.lnprefix, mother.lastname))";
    }
    $criteria_count++;
    if ($criteria_count >= $criteria_limit) die("sorry");
    $criteria = "";
    $returnarray = buildColumn($qualifier, $column, $usevalue);
    $criteria .= $returnarray['criteria'];
    $qualifystr = $returnarray['qualifystr'];
    addtoQuery($textstr, $colvar, $criteria, $qualifyvar, $qualifier, $qualifystr, $value);
}
$querystring = "";
$allwhere = "";
if ($myflastname || $flnqualify == "exists" || $flnqualify == "dnexist") {
    if ($myflastname == _('[no surname]')) {
        addtoQuery("lastname", "myflastname", "father.lastname = \"\"", "flnqualify", _('equals'), _('equals'), $myflastname);
    } else {
        buildCriteria("father.lastname", "myflastname", "flnqualify", $flnqualify, $myflastname, _('Last Name'));
    }
}
if ($myffirstname || $ffnqualify == "exists" || $ffnqualify == "dnexist") {
    buildCriteria("father.firstname", "myffirstname", "ffnqualify", $ffnqualify, $myffirstname, _('First Name'));
}
if ($mymlastname || $mlnqualify == "exists" || $mlnqualify == "dnexist") {
    if ($mymlastname == _('[no surname]')) {
        addtoQuery("lastname", "mymlastname", "mother.lastname = \"\"", "mlnqualify", _('equals'), _('equals'), $mymlastname);
    } else {
        buildCriteria("mother.lastname", "mymlastname", "mlnqualify", $mlnqualify, $mymlastname, _('Last Name'));
    }
}
if ($mymfirstname || $mfnqualify == "exists" || $mfnqualify == "dnexist") {
    buildCriteria("mother.firstname", "mymfirstname", "mfnqualify", $mfnqualify, $mymfirstname, _('First Name'));
}
if ($myfamilyid) {
    $myfamilyid = strtoupper($myfamilyid);
    if ($fidqualify == "equals" && is_numeric($myfamilyid)) {
        $myfamilyid = $familyprefix . $myfamilyid . $familysuffix;
    }
    buildCriteria("familyID", "myfamilyid", "fidqualify", $fidqualify, $myfamilyid, _('Family ID'));
}
if ($mymarrplace || $mpqualify == "exists" || $mpqualify == "dnexist") {
    buildCriteria("marrplace", "mymarrplace", "mpqualify", $mpqualify, $mymarrplace, _('Marriage Place'));
}
if ($mymarryear || $myqualify == "exists" || $myqualify == "dnexist") {
    buildYearCriteria("marrdatetr", "mymarryear", "myqualify", "", $myqualify, $mymarryear, _('Marriage Year'));
}
if ($mydivplace || $dvpqualify == "exists" || $dvpqualify == "dnexist") {
    buildCriteria("divplace", "mydivplace", "dvpqualify", $dvpqualify, $mydivplace, _('Divorce Place'));
}
if ($mydivyear || $dvyqualify == "exists" || $dvyqualify == "dnexist") {
    buildYearCriteria("divdatetr", "mydivyear", "dvyqualify", "", $dvyqualify, $mydivyear, _('Divorce Date (True)'));
}
if ($mymarrtype || $mtqualify == "exists" || $mtqualify == "dnexist") {
    buildCriteria("marrtype", "mymarrtype", "mtqualify", $mtqualify, $mymarrtype, _('Marriage Type'));
}
$dontdo = ["MARR", "DIV"];
$cejoin = doCustomEvents("F");
if ($tree) {
    if ($urlstring) $urlstring .= "&amp;";
    $urlstring .= "tree=$tree";
    if ($querystring) $querystring .= " AND ";
    $treerow = getTree($trees_table, $tree);
    $querystring .= _('Tree') . " " . _('equals') . " {$treerow['treename']}";
    if ($allwhere) $allwhere = "($allwhere) AND";
    $allwhere .= " f.gedcom = '$tree'";
    if ($branch) {
        $urlstring .= "&amp;branch=$branch";
        $querystring .= " " . _('AND') . " ";
        $query = "SELECT description FROM $branches_table WHERE gedcom = '$tree' AND branch = '$branch'";
        $branchresult = tng_query($query);
        $branchrow = tng_fetch_assoc($branchresult);
        tng_free_result($branchresult);
        $querystring .= _('Branch') . " " . _('equals') . " {$branchrow['description']}";
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
    $querystring = "" . _('for') . " $querystring";
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
$families = tng_fetch_all($result);
tng_free_result($result);
$numrows = count($families);
if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $result2 = tng_query($query2) or die (_('Cannot execute query') . ": $query2");
    $countrow = tng_fetch_assoc($result2);
    $totrows = $countrow['fcount'];
    tng_free_result($result2);
} else {
    $totrows = $numrows;
}
if (!$numrows) {
    $msg = _('No results found. Please try again.') . " $querystring. " . _('Please try again') . ".";
    header("Location: famsearchform.php?msg=" . urlencode($msg));
    exit;
}
tng_header(_('Search Results'), $flags);
$logstring = "<a href=\"famsearch.php?{$_SERVER['QUERY_STRING']}\">" . xmlcharacters(_('Search Results') . " $querystring") . "</a>";
writelog($logstring);
preparebookmark($logstring);
$numrowsplus = $numrows + $offset;
?>
    <h2 class="mb-4 header"><span class="headericon" id="fsearch-hdr-icon"></span><?php echo _('Search Results'); ?><br><small class='ml-4'><?php echo $querystring; ?></small></h2>
    <table class='w-11/12 mx-auto whiteback'>
        <thead>
        <tr>
            <th class="p-2 fieldnameback nbrcol"><span class="fieldname"># </span></th>
            <th class="p-2 whitespace-no-wrap fieldnameback fieldname"><?php echo _('Family'); ?></th>
            <th class="p-2 whitespace-no-wrap fieldnameback fieldname"><?php echo $fnamesort; ?></th>
            <th class="p-2 whitespace-no-wrap fieldnameback fieldname"><?php echo $mnamesort; ?></th>
            <th class="p-2 whitespace-no-wrap fieldnameback fieldname"><?php echo $marrsort; ?></th>
            <?php if ($mydivplace || $mydivyear) { ?>
                <th class="p-2 whitespace-no-wrap fieldnameback fieldname"><?php echo $divsort; ?></th>
            <?php } ?>
            <?php if ($numtrees > 1) { ?>
                <th class="hidden p-2 whitespace-no-wrap lg:table-cell fieldnameback fieldname"><?php echo _('Tree'); ?></th>
            <?php } ?>
        </tr>
        </thead>
        <?php
        $i = $offsetplus;
        $peopleIcon = buildSvgElement("img/people.svg", ["class" => "w-4 h-4 fill-current inline-block"]);
        foreach ($families as $row) {
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
            echo "<tr>";
            echo "<td class='p-2 align-top databack'>$i</td>\n";
            $i++;
            echo "<td class='p-2 align-top text-center databack'>";
            echo "<a href=\"familygroup.php?familyID={$row['familyID']}&amp;tree={$row['gedcom']}\" class='fam' id=\"f{$row['familyID']}_t{$row['gedcom']}\">$peopleIcon</a>";
            echo "<div class='person-img' id=\"mi{$row['gedcom']}_{$row['familyID']}\">\n";
            echo "<div class='person-prev' id=\"prev{$row['gedcom']}_{$row['familyID']}\"></div>\n";
            echo "</div>\n";
            echo "</td>";
            echo "<td class='p-2 align-top databack'>$fname</td>";
            echo "<td class='p-2 align-top databack'>$mname</td>";
            echo "<td class='p-2 databack'>$marrdate<br>$marrplace</td>";
            if ($mydivyear || $mydivplace) echo "<td class='p-2 databack'>$divdate <br>$divplace</td>";
            if ($numtrees > 1) {
                echo "<td class='hidden p-2 align-top lg:table-cell databack'><a href=\"showtree.php?tree={$row['gedcom']}\">{$row['treename']}</a></td>";
            }
            echo "</tr>\n";
        }
        ?>
    </table>
    <div class='w-full class=lg:flex my-6'>
        <?php
        echo getPaginationLocationHtml($offsetplus, $numrowsplus, $totrows);
        echo getPaginationControlsHtml($totrows, "famsearch.php?" . "$urlstring&amp;mybool=$mybool&amp;nr=$maxsearchresults&amp;showspouse=$showspouse&amp;showdeath=$showdeath&amp;offset", $maxsearchresults);
        ?>
    </div>
    <script src="js/search.js"></script>
<?php tng_footer(""); ?>
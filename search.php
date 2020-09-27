<?php
$textpart = "search";
$order = "";
include "tng_begin.php";
global $responsivetables, $tabletype, $enablemodeswitch, $enableminimap;

include "searchlib.php";

@set_time_limit(0);
$maxsearchresults = $nr ? ($nr < 200 ? $nr : 200) : ($_SESSION['tng_nr'] ? $_SESSION['tng_nr'] : $maxsearchresults);
if (!isset($mybool) || ($mybool != "AND" && $mybool != "OR")) {
    $mybool = "AND";
}

$_SESSION['tng_search_tree'] = $tree;
$_SESSION['tng_search_branch'] = $branch;
$_SESSION['tng_search_lnqualify'] = $lnqualify;
$mylastname = trim(stripslashes($mylastname));
$_SESSION['tng_search_lastname'] = cleanIt($mylastname);

$_SESSION['tng_search_fnqualify'] = $fnqualify;
$myfirstname = trim(stripslashes($myfirstname));
$_SESSION['tng_search_firstname'] = cleanIt($myfirstname);

$_SESSION['tng_search_idqualify'] = $idqualify;
$mypersonid = trim(stripslashes($mypersonid));
$_SESSION['tng_search_personid'] = cleanIt($mypersonid);

$_SESSION['tng_search_bpqualify'] = $bpqualify;
$mybirthplace = trim(stripslashes($mybirthplace));
$_SESSION['tng_search_birthplace'] = cleanIt($mybirthplace);

$_SESSION['tng_search_byqualify'] = $byqualify;
$mybirthyear = trim(stripslashes($mybirthyear));
$_SESSION['tng_search_birthyear'] = cleanIt($mybirthyear);

$_SESSION['tng_search_cpqualify'] = $cpqualify;
$myaltbirthplace = trim(stripslashes($myaltbirthplace));
$_SESSION['tng_search_altbirthplace'] = cleanIt($myaltbirthplace);

$_SESSION['tng_search_cyqualify'] = $cyqualify;
$myaltbirthyear = trim(stripslashes($myaltbirthyear));
$_SESSION['tng_search_altbirthyear'] = cleanIt($myaltbirthyear);

$_SESSION['tng_search_dpqualify'] = $dpqualify;
$mydeathplace = trim(stripslashes($mydeathplace));
$_SESSION['tng_search_deathplace'] = cleanIt($mydeathplace);

$_SESSION['tng_search_dyqualify'] = $dyqualify;
$mydeathyear = trim(stripslashes($mydeathyear));
$_SESSION['tng_search_deathyear'] = cleanIt($mydeathyear);

$_SESSION['tng_search_brpqualify'] = $brpqualify;
$myburialplace = trim(stripslashes($myburialplace));
$_SESSION['tng_search_burialplace'] = cleanIt($myburialplace);

$_SESSION['tng_search_bryqualify'] = $bryqualify;
$myburialyear = trim(stripslashes($myburialyear));
$_SESSION['tng_search_burialyear'] = cleanIt($myburialyear);

$_SESSION['tng_search_bool'] = $mybool;
$_SESSION['tng_search_showdeath'] = $showdeath;
$_SESSION['tng_search_gender'] = $mygender;

$_SESSION['tng_search_showspouse'] = $showspouse;
$mysplname = trim(stripslashes($mysplname));
$_SESSION['tng_search_mysplname'] = cleanIt($mysplname);

$_SESSION['tng_search_spqualify'] = $spqualify;
$_SESSION['tng_nr'] = $nr;
if ($order) {
    $_SESSION['tng_search_order'] = $order;
} else {
    $order = $_SESSION['tng_search_order'] ?? "name";
    if (!$showdeath && ($order == "death" || $order == "deathup")) {
        $order = "name";
    }
}

$_SERVER['QUERY_STRING'] = str_replace(array('&amp;', '&'), array('&', '&amp;'), $_SERVER['QUERY_STRING']);
$birthsort = "birth";
$deathsort = "death";
$namesort = "nameup";
$branchnames = array();
$orderloc = strpos($_SERVER['QUERY_STRING'], "&amp;order=");
$currargs = $orderloc > 0 ? substr($_SERVER['QUERY_STRING'], 0, $orderloc) : $_SERVER['QUERY_STRING'];
$birthlabel = $tngconfig['hidechr'] ? $text['born'] : $text['bornchr'];
$mybooltext = $mybool == "AND" ? $text['cap_and'] : $text['cap_or'];

if ($order == "birth") {
    $orderstr = "IF(p.birthdatetr, p.birthdatetr, p.altbirthdatetr), p.lastname, p.firstname";
    $birthsort = $tngprint ? $birthlabel : "<a href=\"$search_url$currargs&amp;order=birthup\" class=\"lightlink\">$birthlabel <img src=\"img/tng_sort_desc.gif\" class=\"sortimg\" alt=\"\"></a>";
} else {
    $birthsort = $tngprint ? $birthlabel : "<a href=\"$search_url$currargs&amp;order=birth\" class=\"lightlink\">$birthlabel <img src=\"img/tng_sort_asc.gif\" class=\"sortimg\" alt=\"\"></a>";
    if ($order == "birthup") {
        $orderstr = "IF(p.birthdatetr, p.birthdatetr, p.altbirthdatetr) DESC, p.lastname, p.firstname";
    }
}

if ($order == "death") {
    $orderstr = "IF(p.deathdatetr, p.deathdatetr, p.burialdatetr), p.lastname, p.firstname, IF(p.birthdatetr, p.birthdatetr, p.altbirthdatetr)";
    $deathsort = $tngprint ? $text['diedburied'] : "<a href=\"$search_url$currargs&amp;order=deathup\" class=\"lightlink\">{$text['diedburied']} <img src=\"img/tng_sort_desc.gif\" class=\"sortimg\"></a>";
} else {
    $deathsort = $tngprint ? $text['diedburied'] : "<a href=\"$search_url$currargs&amp;order=death\" class=\"lightlink\">{$text['diedburied']} <img src=\"img/tng_sort_asc.gif\" class=\"sortimg\"></a>";
    if ($order == "deathup") {
        $orderstr = "IF(p.deathdatetr, p.deathdatetr, p.burialdatetr) DESC, p.lastname, p.firstname, IF(p.birthdatetr, p.birthdatetr, p.altbirthdatetr)";
    }
}

$nametitle = isMobile() ? $text['name'] : $text['lastfirst'];
if ($order == "name") {
    $orderstr = "p.lastname, p.firstname, IF(p.birthdatetr, p.birthdatetr, p.altbirthdatetr)";
    $namesort = $tngprint ? $nametitle : "<a href=\"$search_url$currargs&amp;order=nameup\" class=\"lightlink\">$nametitle <img src=\"img/tng_sort_desc.gif\" class=\"sortimg\" alt=\"\"></a>";
} else {
    $namesort = $tngprint ? $nametitle : "<a href=\"$search_url$currargs&amp;order=name\" class=\"lightlink\">$nametitle <img src=\"img/tng_sort_asc.gif\" class=\"sortimg\" alt=\"\"></a>";
    if ($order == "nameup") {
        $orderstr = "p.lastname DESC, p.firstname DESC, IF(p.birthdatetr, p.birthdatetr, p.altbirthdatetr)";
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

    if ($column == "p.firstname") {
        $column = "TRIM(CONCAT_WS(' ',p.firstname,p.nickname))";
    }

    if ($column == "p.lastname" && $lnprefixes) {
        $column = "TRIM(CONCAT_WS(' ',p.lnprefix,p.lastname))";
    } elseif ($column == "spouse.lastname") {
        $column = "TRIM(CONCAT_WS(' ',spouse.lnprefix,spouse.lastname))";
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

if ($mylastname || $lnqualify == "exists" || $lnqualify == "dnexist") {
    if ($mylastname == $text['nosurname']) {
        addtoQuery($text['lastname'], "mylastname", "lastname = \"\"", "lnqualify", $text['equals'], $text['equals'], $mylastname);
    } else {
        buildCriteria("p.lastname", "mylastname", "lnqualify", $lnqualify, $mylastname, $text['lastname']);
    }
}
if ($myfirstname || $fnqualify == "exists" || $fnqualify == "dnexist") {
    if ($myfirstname == $text['nofirstname']) {
        addtoQuery($text['firstname'], "myfirstname", "firstname = \"\"", "fnqualify", $text['equals'], $text['equals'], $myfirstname);
    } else {
        buildCriteria("p.firstname", "myfirstname", "fnqualify", $fnqualify, $myfirstname, $text['firstname']);
    }
}
if ($mysplname || $spqualify == "exists" || $spqualify == "dnexist") {
    buildCriteria("spouse.lastname", "mysplname", "spqualify", $spqualify, $mysplname, $text['spousesurname']);
}
if ($mypersonid) {
    $mypersonid = strtoupper($mypersonid);
    if ($idqualify == "equals" && is_numeric($mypersonid)) {
        $mypersonid = $tngconfig['personprefix'] . $mypersonid . $tngconfig['personsuffix'];
    }
    buildCriteria("p.personID", "mypersonid", "idqualify", $idqualify, $mypersonid, $text['personid']);
}
if ($mytitle || $tqualify == "exists" || $tqualify == "dnexist") {
    buildCriteria("p.title", "mytitle", "tqualify", $tqualify, $mytitle, $text['title']);
}
if ($myprefix || $pfqualify == "exists" || $pfqualify == "dnexist") {
    buildCriteria("p.prefix", "myprefix", "pfqualify", $pfqualify, $myprefix, $text['prefix']);
}
if ($mysuffix || $sfqualify == "exists" || $sfqualify == "dnexist") {
    buildCriteria("p.suffix", "mysuffix", "sfqualify", $sfqualify, $mysuffix, $text['suffix']);
}
if ($mynickname || $nnqualify == "exists" || $nnqualify == "dnexist") {
    buildCriteria("p.nickname", "mynickname", "nnqualify", $nnqualify, $mynickname, $text['nickname']);
}
if ($mybirthplace || $bpqualify == "exists" || $bpqualify == "dnexist") {
    buildCriteria("p.birthplace", "mybirthplace", "bpqualify", $bpqualify, $mybirthplace, $text['birthplace']);
}
if ($mybirthyear || $byqualify == "exists" || $byqualify == "dnexist") {
    buildYearCriteria("p.birthdatetr", "mybirthyear", "byqualify", "p.altbirthdatetr", $byqualify, $mybirthyear, $text['birthdatetr']);
}
if ($myaltbirthplace || $cpqualify == "exists" || $cpqualify == "dnexist") {
    buildCriteria("p.altbirthplace", "myaltbirthplace", "cpqualify", $cpqualify, $myaltbirthplace, $text['altbirthplace']);
}
if ($myaltbirthyear || $cyqualify == "exists" || $cyqualify == "dnexist") {
    buildYearCriteria("p.altbirthdatetr", "myaltbirthyear", "cyqualify", "", $cyqualify, $myaltbirthyear, $text['altbirthdatetr']);
}
if ($mydeathplace || $dpqualify == "exists" || $dpqualify == "dnexist") {
    buildCriteria("p.deathplace", "mydeathplace", "dpqualify", $dpqualify, $mydeathplace, $text['deathplace']);
}
if ($mydeathyear || $dyqualify == "exists" || $dyqualify == "dnexist") {
    buildYearCriteria("p.deathdatetr", "mydeathyear", "dyqualify", "p.burialdatetr", $dyqualify, $mydeathyear, $text['deathdatetr']);
}
if ($myburialplace || $brpqualify == "exists" || $brpqualify == "dnexist") {
    buildCriteria("p.burialplace", "myburialplace", "brpqualify", $brpqualify, $myburialplace, $text['burialplace']);
}
if ($myburialyear || $bryqualify == "exists" || $bryqualify == "dnexist") {
    buildYearCriteria("p.burialdatetr", "myburialyear", "bryqualify", "", $bryqualify, $myburialyear, $text['burialdatetr']);
}
if ($mygender) {
    if ($mygender == "N") {
        $mygender = "";
    }
    buildCriteria("p.sex", "mygender", "gequalify", $gequalify, $mygender, $text['gender']);
}

$dontdo = array("ADDR", "BIRT", "CHR", "DEAT", "BURI", "NICK", "TITL", "NSFX");
$cejoin = doCustomEvents("I");

if ($tree) {
    if ($urlstring) {
        $urlstring .= "&amp;";
    }
    $urlstring .= "tree=$tree";

    if ($querystring) {
        $querystring .= " {$text['cap_and']} ";
    }

    require_once "./admin/trees.php";
    $treerow = getTree($trees_table, $tree);

    $querystring .= $text['tree'] . " {$text['equals']} {$treerow['treename']}";

    if ($allwhere) {
        $allwhere = "($allwhere) AND";
    }
    $allwhere .= " p.gedcom=\"$tree\"";

    if ($branch) {
        $urlstring .= "&amp;branch=$branch";
        $querystring .= " {$text['cap_and']} ";

        $query = "SELECT description FROM $branches_table WHERE gedcom = '$tree' AND branch = '$branch'";
        $branchresult = tng_query($query);
        $branchrow = tng_fetch_assoc($branchresult);
        tng_free_result($branchresult);

        $querystring .= $text['branch'] . " {$text['equals']} {$branchrow['description']}";

        $allwhere .= " AND p.branch like \"%$branch%\"";
    }
}

$treequery = "SELECT count(gedcom) AS treecount FROM $trees_table";
$treeresult = tng_query($treequery);
$treerow = tng_fetch_assoc($treeresult);
$numtrees = $treerow['treecount'];
tng_free_result($treeresult);

$branchquery = "SELECT count(branch) AS branchcount FROM $branches_table";
$branchresult = tng_query($branchquery);
$branchrow = tng_fetch_assoc($branchresult);
$numbranches = $branchrow['branchcount'];
tng_free_result($branchresult);

$gotInput = $mytitle || $myprefix || $mysuffix || $mynickname || $mybirthplace || $mydeathplace || $mybirthyear || $mydeathyear || $ecount;
$more = getLivingPrivateRestrictions("p", $myfirstname, $gotInput);

if ($more) {
    if ($allwhere) {
        $allwhere = $tree ? "$allwhere AND " : "($allwhere) AND ";
    }
    $allwhere .= $more;
}

if ($allwhere) {
    $allwhere = "WHERE " . $allwhere;
    $querystring = $text['text_for'] . " $querystring";
}

if ($orderstr) {
    $orderstr = "ORDER BY $orderstr";
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

if (($mysplname && $mygender) || $spqualify == "exists" || $spqualify == "dnexist") {
    $gstring = $mygender == "F" ? "p.personID = wife AND spouse.personID = husband" : "p.personID = husband AND spouse.personID = wife";
    $query = "SELECT p.ID, spouse.personID AS spersonID, p.personID, p.lastname, p.lnprefix, p.firstname, p.nickname, p.living, p.private, p.branch, p.suffix, p.prefix, p.nameorder, p.title, p.birthplace, p.birthdate, p.deathplace, p.deathdate, p.altbirthdate, p.altbirthplace, p.burialdate, p.burialplace, p.gedcom, treename ";
    $query .= "FROM ($people_table p, $families_table families, $people_table spouse, $trees_table trees) ";
    $query .= "$cejoin ";
    $query .= "$allwhere AND (p.gedcom = trees.gedcom AND p.gedcom = families.gedcom AND spouse.gedcom = families.gedcom AND $gstring) ";
    $query .= "$orderstr ";
    $query .= "LIMIT $newoffset" . $maxsearchresults;
    $showspouse = "yess";

    $query2 = "SELECT count(p.ID) AS pcount ";
    $query2 .= "FROM ($people_table p, $families_table families, $people_table spouse) ";
    $query2 .= "$cejoin ";
    $query2 .= "$allwhere AND (p.gedcom = families.gedcom AND spouse.gedcom = families.gedcom AND $gstring)";
} else {
    if ($showspouse == "yes") {
        $families_join = "LEFT JOIN $families_table families1 ON (p.gedcom = families1.gedcom AND p.personID = families1.husband ) ";
        $families_join .= "LEFT JOIN $families_table families2 ON (p.gedcom = families2.gedcom AND p.personID = families2.wife ) ";
        $huswife = ", families1.wife as wife, families2.husband as husband";
    } else {
        $families_join = "";
        $huswife = "";
    }

    $query = "SELECT p.ID, p.personID, lastname, lnprefix, firstname, p.living, p.private, p.branch, nickname, prefix, suffix, nameorder, title, birthplace, birthdate, deathplace, deathdate, altbirthdate, altbirthplace, burialdate, burialplace, p.gedcom, treename $huswife ";
    $query .= "FROM $people_table p ";
    $query .= "$families_join ";
    $query .= "LEFT JOIN $trees_table trees ON p.gedcom = trees.gedcom ";
    $query .= "$cejoin ";
    $query .= "$allwhere ";
    $query .= "$orderstr ";
    $query .= "LIMIT $newoffset" . $maxsearchresults;

    $query2 = "SELECT count(p.ID) AS pcount ";
    $query2 .= "FROM $people_table AS p ";
    $query2 .= "$families_join ";
    $query2 .= "$cejoin ";
    $query2 .= "$allwhere";
}
$result = tng_query($query);
$numrows = tng_num_rows($result);

if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $result2 = tng_query($query2) or die ($text['cannotexecutequery'] . ": $query2");
    $countrow = tng_fetch_assoc($result2);
    $totrows = $countrow['pcount'];
    tng_free_result($result2);
} else {
    $totrows = $numrows;
}

if (!$numrows) {
    $msg = $text['noresults'] . " $querystring. {$text['tryagain']}.";
    header("Location: searchform.php?msg=" . urlencode($msg));
    exit;
} elseif ($numrows == 1 && !$offset) {
    $row = tng_fetch_assoc($result);
    tng_free_result($result);
    header("Location: getperson.php?personID=" . $row['personID'] . "&tree=" . $row['gedcom']);
    exit;
}

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

tng_header($text['searchresults'], $flags);
?>
<?php
if ($sitever != "mobile") {
    ?>
    <script src="js/search.js"></script>
    <script>
        // <![CDATA[
        const ajx_perspreview = 'ajx_perspreview.php"';
        // ]]>
    </script>
    <?php
}
?>

    <h2 class="header"><span class="headericon" id="search-hdr-icon"></span><?php echo $text['searchresults']; ?></h2>
    <br style="clear: left;">
<?php
$logstring = "<a href=\"search.php?" . $_SERVER['QUERY_STRING'] . "\">" . xmlcharacters($text['searchresults'] . " $querystring") . "</a>";
writelog($logstring);
preparebookmark($logstring);

$numrowsplus = $numrows + $offset;

echo "<p class='normal'>{$text['matches']} $offsetplus {$text['to']} $numrowsplus {$text['of']} " . number_format($totrows) . " $querystring</p>";

$pagenav = get_browseitems_nav($totrows, "search.php?$urlstring&amp;mybool=$mybool&amp;nr=$maxsearchresults&amp;showspouse=$showspouse&amp;showdeath=$showdeath&amp;offset", $maxsearchresults, $max_browsesearch_pages);
$heatmap = !$cejoin ? "<a href=\"heatmap.php?" . $_SERVER['QUERY_STRING'] . "\" class=\"snlink\">{$text['heatmap']}</a>" : "";
if ($pagenav && !$cejoin) {
    $heatmap = " | " . $heatmap;
}
echo "<p class='normal'>$pagenav$heatmap</p>";

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

if (isMobile()) {
    if ($tabletype == "toggle") {
        $header = "<table cellpadding=\"3\" cellspacing='1' border=\"0\" width=\"100%\" class=\"tablesaw whiteback\" data-tablesaw-mode=\"columntoggle\"" . $headerr;
    } elseif ($tabletype == "stack") {
        $header = "<table cellpadding=\"3\" cellspacing='1' border=\"0\" width=\"100%\" class=\"tablesaw whiteback\" data-tablesaw-mode=\"stack\"" . $headerr;
    } elseif ($tabletype == "swipe") {
        $header = "<table cellpadding=\"3\" cellspacing='1' border=\"0\" width=\"100%\" class=\"tablesaw whiteback\" data-tablesaw-mode=\"swipe\"" . $headerr;
    } else {
        $header = "<table cellpadding=\"3\" cellspacing='1' border=\"0\" class=\"whiteback\">\n";
    }
} else {
    $header = "<table cellpadding=\"3\" cellspacing='1' border=\"0\" class=\"whiteback\">\n" . $header;
}
echo $header;
?>
    <thead>
    <tr>
        <th data-tablesaw-priority="persist" class="fieldnameback nbrcol"><span class="fieldname">&nbsp;# </span></th>
        <th data-tablesaw-priority="1" class="fieldnameback nw"><span class="fieldname">&nbsp;<?php echo $namesort; ?>&nbsp;</span></th>
        <?php
        if ($sitever != "mobile") {
            ?>
            <th data-tablesaw-priority="5" class="fieldnameback fieldname nw">&nbsp;<b><?php echo $text['personid']; ?></b>&nbsp;</th>
            <?php if ($myprefix) { ?>
                <th class="fieldnameback fieldname">&nbsp;<b><?php echo $text['prefix']; ?></b>&nbsp;</th><?php } ?>
            <?php if ($mysuffix) { ?>
                <th class="fieldnameback fieldname">&nbsp;<b><?php echo $text['suffix']; ?></b>&nbsp;</th><?php } ?>
            <?php if ($mytitle) { ?>
                <th class="fieldnameback fieldname">&nbsp;<b><?php echo $text['title']; ?></b>&nbsp;</th><?php } ?>
            <?php if ($mynickname) { ?>
                <th class="fieldnameback fieldname">&nbsp;<b><?php echo $text['nickname']; ?></b>&nbsp;</th><?php } ?>
            <?php
        }
        ?>
        <th data-tablesaw-priority="2" class="fieldnameback fieldname nw">&nbsp;<?php echo $birthsort; ?>&nbsp;</th>
        <th data-tablesaw-priority="4" class="fieldnameback fieldname">&nbsp;<?php echo $text['location']; ?>&nbsp;</th>
        <?php
        if ($mydeathyear || $mydeathplace || $myburialyear || $myburialplace || $showdeath) {
            ?>
            <th data-tablesaw-priority="6" class="fieldnameback fieldname nw">&nbsp;<?php echo $deathsort; ?>&nbsp;</th>
            <th data-tablesaw-priority="5" class="fieldnameback fieldname">&nbsp;<?php echo $text['location']; ?>&nbsp;</th><?php } ?>
        <?php
        if ($showspouse) {
            ?>
            <th data-tablesaw-priority="4" class="fieldnameback fieldname">&nbsp;<?php echo $text['spouse']; ?>&nbsp;</th>
            <?php
        }
        if (isMobile()) {
            ?>
            <th data-tablesaw-priority="5" class="fieldnameback fieldname nw">&nbsp;<b><?php echo $text['personid']; ?></b>&nbsp;</th>
            <?php
        }
        if ($numtrees > 1 || $numbranches) {
            ?>
            <th data-tablesaw-priority="6" class="fieldnameback fieldname nw">&nbsp;<?php echo $text['tree']; ?><?php if ($numbranches) {
                    echo " | " . $text['branch'];
                } ?>&nbsp;
            </th>
            <?php
        }
        ?>
    </tr>
    </thead>
<?php
$i = $offsetplus;
$chartlink = "<img src=\"img/Chart.gif\" class=\"chartimg\" alt=\"\">";
while ($row = tng_fetch_assoc($result)) {
    $rights = determineLivingPrivateRights($row);
    $row['allow_living'] = $rights['living'];
    $row['allow_private'] = $rights['private'];
    if ($rights['both']) {
        if ($row['birthdate'] || ($row['birthplace'] && !$row['altbirthdate'])) {
            $birthdate = $text['birthabbr'] . " " . displayDate($row['birthdate']);
            $birthplace = $row['birthplace'] ? $row['birthplace'] . " " . placeImage($row['birthplace']) : "";
        } else {
            if ($row['altbirthdate'] || $row['altbirthplace']) {
                $birthdate = $text['chrabbr'] . " " . displayDate($row['altbirthdate']);
                $birthplace = $row['altbirthplace'] ? $row['altbirthplace'] . " " . placeImage($row['altbirthplace']) : "";
            } else {
                $birthdate = "";
                $birthplace = "";
            }
        }
        if ($row['deathdate'] || ($row['deathplace'] && !$row['burialdate'])) {
            $deathdate = $text['deathabbr'] . " " . displayDate($row['deathdate']);
            $deathplace = $row['deathplace'] ? $row['deathplace'] . " " . placeImage($row['deathplace']) : "";
        } else {
            if ($row['burialdate'] || $row['burialplace']) {
                $deathdate = $text['burialabbr'] . " " . displayDate($row['burialdate']);
                $deathplace = $row['burialplace'] ? $row['burialplace'] . " " . placeImage($row['burialplace']) : "";
            } else {
                $deathdate = "";
                $deathplace = "";
            }
        }
        $prefix = $row['prefix'];
        $suffix = $row['suffix'];
        $title = $row['title'];
        $nickname = $row['nickname'];
    } else {
        $prefix = $suffix = $title = $nickname = $birthdate = $birthplace = $deathdate = $deathplace = "";
    }
    echo "<tr>";
    $name = getNameRev($row);
    if ($row['nickname'] && ($row['allow_living'] || !$nonames) && ($row['allow_private'] || !$tngconfig['nnpriv'])) {
        $name .= " \"{$row['nickname']}\"";
    }
    echo "<td class='databack'>$i</td>\n";
    $i++;
    echo "<td class='databack nw'>";
    if ($sitever != "mobile") {
        echo "<div class=\"person-img\" id=\"mi{$row['gedcom']}_{$row['personID']}\"><div class=\"person-prev\" id=\"prev{$row['gedcom']}_{$row['personID']}\"></div></div>\n";
    }
    echo "<a href=\"pedigree.php?personID={$row['personID']}&amp;tree={$row['gedcom']}\">$chartlink</a> ";
    echo "<a href=\"getperson.php?personID={$row['personID']}&amp;tree={$row['gedcom']}\" class=\"pers\" id=\"p{$row['personID']}_t{$row['gedcom']}\">$name</a>";

    echo "</td>";
    if ($sitever != "mobile") {
        echo "<td class='databack'>{$row['personID']} </td>";
    }

    if ($showspouse) {
        $spouse = "";
        if ($showspouse == "yess") {
            $spouseID = $row['spersonID'];
        } else {
            $spouseID = $row['husband'] ? $row['husband'] : $row['wife'];
        }
        if ($spouseID) {
            $query = "SELECT lastname, lnprefix, firstname, prefix, suffix, nameorder, living, private, branch, gedcom FROM $people_table WHERE personID = \"$spouseID\" AND gedcom = \"{$row['gedcom']}\"";
            $spresult = tng_query($query);
            if ($spresult) {
                $sprow = tng_fetch_assoc($spresult);
                $sprights = determineLivingPrivateRights($sprow);
                $sprow['allow_living'] = $sprights['living'];
                $sprow['allow_private'] = $sprights['private'];
                $spouse = getName($sprow);
                tng_free_result($spresult);
            }
        }
        $spousestr = $spouse ? "<a href=\"getperson.php?personID=$spouseID&amp;tree={$row['gedcom']}\">$spouse</a>&nbsp;" : "";
    } else {
        $spousestr = "";
    }

    if ($sitever != "mobile") {
        if ($myprefix) {
            echo "<td class='databack'>$prefix &nbsp;</td>";
        }
        if ($mysuffix) {
            echo "<td class='databack'>$suffix &nbsp;</td>";
        }
        if ($mytitle) {
            echo "<td class='databack'>$title &nbsp;</td>";
        }
        if ($mynickname) {
            echo "<td class='databack'>$nickname &nbsp;</td>";
        }

    }
    echo "<td class='databack'>&nbsp;$birthdate </td>";
    echo "<td class='databack'>$birthplace &nbsp;</td>";
    if ($mydeathyear || $mydeathplace || $myburialyear || $myburialplace || $showdeath) {
        echo "<td class='databack'>$deathdate &nbsp;</td>";
        echo "<td class='databack'>$deathplace &nbsp;</td>";
    }

    if ($showspouse) {
        echo "<td class='databack'>$spousestr</td>";
    }

    if (isMobile()) {
        echo "<td class='databack'>{$row['personID']} </td>";
    }
    if ($numtrees > 1 || $numbranches) {
        echo "<td class='databack'><a href=\"showtree.php?tree={$row['gedcom']}\">{$row['treename']}</a>";
        if ($row['branch']) {
            $branches = explode(",", $row['branch']);
            echo " | ";
            $branchstr = "";
            foreach ($branches as $branch) {
                $key = $row['gedcom'] . "_" . $branch;
                $branchname = $branchnames[$key];
                if (!$branchname) {
                    $query = "SELECT description FROM $branches_table WHERE gedcom = \"{$row['gedcom']}\" AND branch = '$branch'";
                    $brresult = tng_query($query);
                    $brrow = tng_fetch_assoc($brresult);
                    $branchname = $brrow['description'];
                    $branchnames[$key] = $branchname;
                    tng_free_result($brresult);
                }
                //check the saved array for the name
                //if not there, look it up, save in saved array
                if ($branchstr) {
                    $branchstr .= ", ";
                }
                if ($branchname) {
                    $branchstr .= $branchname;
                } else {
                    $branchstr .= $row['branch'];
                }
            }
            echo $branchstr;
        }
        echo "</td>";
    }

    echo "</tr>\n";
}
tng_free_result($result);

?>
    </table>

<?php
echo "<p>$pagenav$heatmap</p>\n<br>\n";
tng_footer("");
?>
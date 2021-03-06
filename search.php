<?php

$textpart = "search";
$order = "";
include "tng_begin.php";
include "searchlib.php";
require_once "admin/pagination.php";
@set_time_limit(0);
$maxsearchresults = !empty($nr) ? ($nr < 200 ? $nr : 200) : (!empty($_SESSION['tng_nr']) ? $_SESSION['tng_nr'] : $maxsearchresults);
if (!isset($mybool) || ($mybool != "AND" && $mybool != "OR")) {
    $mybool = "AND";
}
$varlist = ['bpqualify', 'branch', 'brpqualify', 'bryqualify', 'byqualify', 'cpqualify', 'cyqualify', 'dpqualify', 'dyqualify', 'ecount', 'fnqualify', 'idqualify', 'lnqualify', 'myaltbirthplace', 'myaltbirthyear', 'mybirthplace', 'mybirthyear', 'myburialplace', 'myburialyear', 'mydeathplace', 'mydeathyear', 'myfirstname', 'mygender', 'mylastname', 'mynickname', 'mypersonid', 'myprefix', 'mysplname', 'mysuffix', 'mytitle', 'nnqualify', 'pfqualify', 'sfqualify', 'showdeath', 'showspouse', 'spqualify', 'tngprint', 'tqualify', 'urlstring'];
foreach ($varlist as $var) {
    if (!isset(${$var}))
        ${$var} = "";
}
if (!isset($offset)) $offset = 0;
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
$_SESSION['tng_nr'] = isset($nr) ? $nr : $maxsearchresults;
if ($order) {
    $_SESSION['tng_search_order'] = $order;
} else {
    $order = isset($_SESSION['tng_search_order']) ? $_SESSION['tng_search_order'] : "name";
    if (!$showdeath && ($order == "death" || $order == "deathup")) {
        $order = "name";
    }
}
$_SERVER['QUERY_STRING'] = str_replace(['&amp;', '&'], ['&', '&amp;'], $_SERVER['QUERY_STRING']);
$birthsort = "birth";
$deathsort = "death";
$namesort = "nameup";
$branchnames = [];
$orderloc = strpos($_SERVER['QUERY_STRING'], "&amp;order=");
$currargs = $orderloc > 0 ? substr($_SERVER['QUERY_STRING'], 0, $orderloc) : $_SERVER['QUERY_STRING'];
$birthlabel = $tngconfig['hidechr'] ? _('Born') : _('Born/Christened');
$mybooltext = $mybool == "AND" ? _('AND') : _('OR');
if ($order == "birth") {
    $orderstr = "IF(p.birthdatetr, p.birthdatetr, p.altbirthdatetr), p.lastname, p.firstname";
    if ($tngprint) {
        $birthsort = $birthlabel;
    } else {
        $birthsort = "<a href='search.php?$currargs&amp;order=birthup' class='lightlink'>";
        $birthsort .= "$birthlabel <img src='img/tng_sort_desc.gif' alt='' class='inline-block sortimg'>";
        $birthsort .= "</a>";
    }
} else {
    if ($tngprint) {
        $birthsort = $birthlabel;
    } else {
        $birthsort = "<a href='search.php?$currargs&amp;order=birth' class='lightlink'>";
        $birthsort .= "$birthlabel <img src='img/tng_sort_asc.gif' alt='' class='inline-block sortimg'>";
        $birthsort .= "</a>";
    }
    if ($order == "birthup") {
        $orderstr = "IF(p.birthdatetr, p.birthdatetr, p.altbirthdatetr) DESC, p.lastname, p.firstname";
    }
}
if ($order == "death") {
    $orderstr = "IF(p.deathdatetr, p.deathdatetr, p.burialdatetr), p.lastname, p.firstname, IF(p.birthdatetr, p.birthdatetr, p.altbirthdatetr)";
    if ($tngprint) {
        $deathsort = _('Died/Buried');
    } else {
        $deathsort = "<a href='search.php?$currargs&amp;order=deathup' class='lightlink'>";
        $deathsort .= "" . _('Died/Buried') . " <img src='img/tng_sort_desc.gif' alt='' class='inline-block sortimg'>";
        $deathsort .= "</a>";
    }
} else {
    if ($tngprint) {
        $deathsort = _('Died/Buried');
    } else {
        $deathsort = "<a href='search.php?$currargs&amp;order=death' class='lightlink'>";
        $deathsort .= "" . _('Died/Buried') . " <img src='img/tng_sort_asc.gif' alt='' class='inline-block sortimg'>";
        $deathsort .= "</a>";
    }
    if ($order == "deathup") {
        $orderstr = "IF(p.deathdatetr, p.deathdatetr, p.burialdatetr) DESC, p.lastname, p.firstname, IF(p.birthdatetr, p.birthdatetr, p.altbirthdatetr)";
    }
}
$nametitle = _('Last Name, First Name');
if ($order == "name") {
    $orderstr = "p.lastname, p.firstname, IF(p.birthdatetr, p.birthdatetr, p.altbirthdatetr)";
    if ($tngprint) {
        $namesort = $nametitle;
    } else {
        $namesort = "<a href='search.php?$currargs&amp;order=nameup' class='lightlink'>";
        $namesort .= "$nametitle <img src='img/tng_sort_desc.gif' alt='' class='inline-block sortimg'>";
        $namesort .= "</a>\n";
    }
} else {
    if ($tngprint) {
        $namesort = $nametitle;
    } else {
        $namesort = "<a href='search.php?$currargs&amp;order=name' class='lightlink'>$nametitle <img src='img/tng_sort_asc.gif' alt='' class='inline-block sortimg'></a>";
    }
    if ($order == "nameup") {
        $orderstr = "p.lastname DESC, p.firstname DESC, IF(p.birthdatetr, p.birthdatetr, p.altbirthdatetr)";
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
    if ($column == "p.firstname") {
        $column = "TRIM(CONCAT_WS(' ', p.firstname, p.nickname))";
    }
    if ($column == "p.lastname" && $lnprefixes) {
        $column = "TRIM(CONCAT_WS(' ',p.lnprefix,p.lastname))";
    } elseif ($column == "spouse.lastname") {
        $column = "TRIM(CONCAT_WS(' ',spouse.lnprefix,spouse.lastname))";
    }
    $criteria_count++;
    if ($criteria_count >= $criteria_limit) {
        die("Error: Too many criteria chosen");
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
    if ($mylastname == _('[no surname]')) {
        addtoQuery(_('Last Name'), "mylastname", "lastname = ''", "lnqualify", _('equals'), _('equals'), $mylastname);
    } else {
        buildCriteria("p.lastname", "mylastname", "lnqualify", $lnqualify, $mylastname, _('Last Name'));
    }
}
if ($myfirstname || $fnqualify == "exists" || $fnqualify == "dnexist") {
    if ($myfirstname == _('[no first name]')) {
        addtoQuery(_('First Name'), "myfirstname", "firstname = ''", "fnqualify", _('equals'), _('equals'), $myfirstname);
    } else {
        buildCriteria("p.firstname", "myfirstname", "fnqualify", $fnqualify, $myfirstname, _('First Name'));
    }
}
if ($mysplname || $spqualify == "exists" || $spqualify == "dnexist") {
    buildCriteria("spouse.lastname", "mysplname", "spqualify", $spqualify, $mysplname, _('Spouse\'s Last Name'));
}
if ($mypersonid) {
    $mypersonid = strtoupper($mypersonid);
    if ($idqualify == "equals" && is_numeric($mypersonid)) {
        $mypersonid = $tngconfig['personprefix'] . $mypersonid . $tngconfig['personsuffix'];
    }
    buildCriteria("p.personID", "mypersonid", "idqualify", $idqualify, $mypersonid, _('Person ID'));
}
if ($mytitle || $tqualify == "exists" || $tqualify == "dnexist") {
    buildCriteria("p.title", "mytitle", "tqualify", $tqualify, $mytitle, _('Title'));
}
if ($myprefix || $pfqualify == "exists" || $pfqualify == "dnexist") {
    buildCriteria("p.prefix", "myprefix", "pfqualify", $pfqualify, $myprefix, _('Prefix'));
}
if ($mysuffix || $sfqualify == "exists" || $sfqualify == "dnexist") {
    buildCriteria("p.suffix", "mysuffix", "sfqualify", $sfqualify, $mysuffix, _('Suffix'));
}
if ($mynickname || $nnqualify == "exists" || $nnqualify == "dnexist") {
    buildCriteria("p.nickname", "mynickname", "nnqualify", $nnqualify, $mynickname, _('Nickname'));
}
if ($mybirthplace || $bpqualify == "exists" || $bpqualify == "dnexist") {
    buildCriteria("p.birthplace", "mybirthplace", "bpqualify", $bpqualify, $mybirthplace, _('Birth Place'));
}
if ($mybirthyear || $byqualify == "exists" || $byqualify == "dnexist") {
    buildYearCriteria("p.birthdatetr", "mybirthyear", "byqualify", "p.altbirthdatetr", $byqualify, $mybirthyear, _('Birth Date (True)'));
}
if ($myaltbirthplace || $cpqualify == "exists" || $cpqualify == "dnexist") {
    buildCriteria("p.altbirthplace", "myaltbirthplace", "cpqualify", $cpqualify, $myaltbirthplace, _('Christening Place'));
}
if ($myaltbirthyear || $cyqualify == "exists" || $cyqualify == "dnexist") {
    buildYearCriteria("p.altbirthdatetr", "myaltbirthyear", "cyqualify", "", $cyqualify, $myaltbirthyear, _('Christening Year'));
}
if ($mydeathplace || $dpqualify == "exists" || $dpqualify == "dnexist") {
    buildCriteria("p.deathplace", "mydeathplace", "dpqualify", $dpqualify, $mydeathplace, _('Death Place'));
}
if ($mydeathyear || $dyqualify == "exists" || $dyqualify == "dnexist") {
    buildYearCriteria("p.deathdatetr", "mydeathyear", "dyqualify", "p.burialdatetr", $dyqualify, $mydeathyear, _('Death Date (True)'));
}
if ($myburialplace || $brpqualify == "exists" || $brpqualify == "dnexist") {
    buildCriteria("p.burialplace", "myburialplace", "brpqualify", $brpqualify, $myburialplace, _('Burial Place'));
}
if ($myburialyear || $bryqualify == "exists" || $bryqualify == "dnexist") {
    buildYearCriteria("p.burialdatetr", "myburialyear", "bryqualify", "", $bryqualify, $myburialyear, _('Burial Date (True)'));
}
if ($mygender) {
    if ($mygender == "N") $mygender = "";
    buildCriteria("p.sex", "mygender", "gequalify", $gequalify, $mygender, _('Gender'));
}
$dontdo = ["ADDR", "BIRT", "CHR", "DEAT", "BURI", "NICK", "TITL", "NSFX"];
$cejoin = doCustomEvents("I");
if ($tree) {
    if ($urlstring) $urlstring .= "&amp;";
    $urlstring .= "tree=$tree";
    if ($querystring) $querystring .= " " . _('AND') . " ";
    require_once "./admin/trees.php";
    $treerow = getTree($trees_table, $tree);
    $querystring .= _('Tree') . " " . _('equals') . " {$treerow['treename']}";
    if ($allwhere) $allwhere = "($allwhere) AND";
    $allwhere .= " p.gedcom='$tree'";
    if ($branch) {
        $urlstring .= "&amp;branch=$branch";
        $querystring .= " " . _('AND') . " ";
        if ($branch != "-1") {
            $query = "SELECT description FROM $branches_table WHERE gedcom = '$tree' AND branch = '$branch'";
            $branchresult = tng_query($query);
            $branchrow = tng_fetch_assoc($branchresult);
            tng_free_result($branchresult);
            $querystring .= _('Branch') . " " . _('equals') . " {$branchrow['description']}";
            $allwhere .= " AND p.branch like '%$branch%'";
        } else {
            $querystring .= _('Branch') . " " . _('equals') . " " . _('No Branch') . "";
            $allwhere .= " AND p.branch = ''";
        }
    }
}
$treequery = "SELECT COUNT(gedcom) AS treecount FROM $trees_table";
$treeresult = tng_query($treequery);
$treerow = tng_fetch_assoc($treeresult);
$numtrees = $treerow['treecount'];
tng_free_result($treeresult);
$branchquery = "SELECT COUNT(branch) AS branchcount FROM $branches_table";
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
    $querystring = _('for') . " $querystring";
}
if ($orderstr) $orderstr = "ORDER BY $orderstr";
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
    $query2 = "SELECT COUNT(p.ID) AS pcount ";
    $query2 .= "FROM ($people_table p, $families_table families, $people_table spouse) ";
    $query2 .= "$cejoin ";
    $query2 .= "$allwhere AND (p.gedcom = families.gedcom AND spouse.gedcom = families.gedcom AND $gstring)";
} else {
    if ($showspouse == "yes") {
        $families_join = "LEFT JOIN $families_table families1 ON (p.gedcom = families1.gedcom AND p.personID = families1.husband ) ";
        $families_join .= "LEFT JOIN $families_table families2 ON (p.gedcom = families2.gedcom AND p.personID = families2.wife ) ";
        $huswife = ", families1.wife AS wife, families2.husband AS husband";
    } else {
        $families_join = "";
        $huswife = "";
    }
    $query = "SELECT p.ID, p.personID, lastname, lnprefix, firstname, p.living, p.private, p.branch, nickname, prefix, suffix, nameorder, title, birthplace, birthdate, birthdatetr, deathplace, deathdate, altbirthdate, altbirthdatetr, altbirthplace, burialdate, burialplace, p.gedcom, treename $huswife ";
    $query .= "FROM $people_table p ";
    $query .= "$families_join ";
    $query .= "LEFT JOIN $trees_table trees ON p.gedcom = trees.gedcom ";
    $query .= "$cejoin ";
    $query .= "$allwhere ";
    $query .= "$orderstr ";
    $query .= "LIMIT $newoffset" . $maxsearchresults;
    $query2 = "SELECT COUNT(p.ID) AS pcount ";
    $query2 .= "FROM $people_table p ";
    $query2 .= "$families_join ";
    $query2 .= "$cejoin ";
    $query2 .= "$allwhere";
}
$result = tng_query($query);
$people = tng_fetch_all($result);
tng_free_result($result);
$numrows = count($people);
if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $result2 = tng_query($query2) or die (_('Cannot execute query') . ": $query2");
    $countrow = tng_fetch_assoc($result2);
    $totrows = $countrow['pcount'];
    tng_free_result($result2);
} else {
    $totrows = $numrows;
}
if (!$numrows) {
    $msg = _('No results found. Please try again.') . " $querystring. " . _('Please try again') . ".";
    header("Location: searchform.php?msg=" . urlencode($msg));
    exit;
} elseif ($numrows == 1 && !$offset) {
    $row = $people[0];
    header("Location: getperson.php?personID=" . $row['personID'] . "&tree=" . $row['gedcom']);
    exit;
}
tng_header(_('Search Results'), $flags);
?>
    <h2 class="header"><span class="headericon" id="search-hdr-icon"></span><?php echo _('Search Results'); ?></h2>
    <br style="clear: left;">
<?php
$logstring = "<a href=\"search.php?{$_SERVER['QUERY_STRING']}\">" . xmlcharacters(_('Search Results') . " $querystring") . "</a>";
writelog($logstring);
preparebookmark($logstring);
$numrowsplus = $numrows + $offset;
$heatmap = !$cejoin && empty($mysplname) ? "<a href=\"heatmap.php?{$_SERVER['QUERY_STRING']}\" class='rounded snlink'>" . _('Heat Map') . "</a>" : "";
echo "<p class='normal'>$heatmap</p>";
?>
    <table class='whiteback normal'>
    <thead>
    <tr>
        <th class="hidden p-2 sm:table-cell fieldnameback nbrcol"><span class="fieldname">#</span></th>
        <th class="p-2 whitespace-no-wrap fieldnameback"><span class="fieldname"><?php echo $namesort; ?></span></th>
        <th class="hidden p-2 whitespace-no-wrap fieldnameback md:table-cell fieldname"><?php echo _('Person ID'); ?></th>
        <?php if ($myprefix) { ?>
            <th class="p-2 fieldnameback fieldname"><?php echo _('Prefix'); ?></th>
        <?php } ?>
        <?php if ($mysuffix) { ?>
            <th class="p-2 fieldnameback fieldname"><?php echo _('Suffix'); ?></th>
        <?php } ?>
        <?php if ($mytitle) { ?>
            <th class="p-2 fieldnameback fieldname"><?php echo _('Title'); ?></th>
        <?php } ?>
        <?php if ($mynickname) { ?>
            <th class="p-2 fieldnameback fieldname"><?php echo _('Nickname'); ?></th>
        <?php } ?>
            <th class="p-2 fieldnameback fieldname"><?php echo $birthsort; ?></th>
            <?php if ($mydeathyear || $mydeathplace || $myburialyear || $myburialplace || $showdeath) { ?>
                <th class="p-2 fieldnameback fieldname whitespace-no-wrap"><?php echo $deathsort; ?></th>
                <th class="p-2 fieldnameback fieldname"><?php echo _('Location'); ?></th>
            <?php } ?>
            <?php if ($showspouse) { ?>
                <th class="p-2 fieldnameback fieldname"><?php echo _('Spouse'); ?></th>
            <?php } ?>
            <?php if ($numtrees > 1 || $numbranches) { ?>
                <th class="p-2 fieldnameback fieldname whitespace-no-wrap">
                    <?php echo _('Tree'); ?><?php if ($numbranches) {
                        echo " | " . _('Branch');
                    } ?>
                </th>
            <?php } ?>
        </tr>
        </thead>
<?php
$i = $offsetplus;
foreach ($people as $row) {
    $rights = determineLivingPrivateRights($row);
    $row['allow_living'] = $rights['living'];
    $row['allow_private'] = $rights['private'];
    if ($rights['both']) {
        if ($row['birthdate'] || ($row['birthplace'] && !$row['altbirthdate'])) {
            $birthdate = _('b.') . " " . displayDate($row['birthdate']);
            $birthplace = $row['birthplace'] ? $row['birthplace'] . " " . placeImage($row['birthplace']) : "";
        } elseif ($row['altbirthdate'] || $row['altbirthplace']) {
            $birthdate = _('c.') . " " . displayDate($row['altbirthdate']);
            $birthplace = $row['altbirthplace'] ? $row['altbirthplace'] . " " . placeImage($row['altbirthplace']) : "";
        } else {
            $birthdate = "";
            $birthplace = "";
        }
        if ($row['deathdate'] || ($row['deathplace'] && !$row['burialdate'])) {
            $deathdate = _('d.') . " " . displayDate($row['deathdate']);
            $deathplace = $row['deathplace'] ? $row['deathplace'] . " " . placeImage($row['deathplace']) : "";
        } elseif ($row['burialdate'] || $row['burialplace']) {
            $deathdate = _('bur.') . " " . displayDate($row['burialdate']);
            $deathplace = $row['burialplace'] ? $row['burialplace'] . " " . placeImage($row['burialplace']) : "";
        } else {
            $deathdate = "";
            $deathplace = "";
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
    echo "<td class='hidden p-2 align-top sm:table-cell databack'>$i</td>\n";
    $i++;
    echo "<td class='p-2 align-top databack whitespace-no-wrap'>\n";
    echo "<div class='person-img' id='mi{$row['gedcom']}_{$row['personID']}'>\n";
    echo "<div class='person-prev' id='prev{$row['gedcom']}_{$row['personID']}'></div>\n";
    echo "</div>\n";
    echo "<a href='pedigree.php?personID={$row['personID']}&amp;tree={$row['gedcom']}'>";
    echo "<img src='img/chart.gif' alt='' class='inline-block chartimg'>";
    echo "</a> ";
    echo "<a href='getperson.php?personID={$row['personID']}&amp;tree={$row['gedcom']}' class='pers' id='p{$row['personID']}_t{$row['gedcom']}'>$name</a>";
    echo "</td>";
    echo "<td class='hidden p-2 md:table-cell databack'>{$row['personID']} </td>";
    if ($showspouse) {
        $spouse = "";
        if ($showspouse == "yess") {
            $spouseID = $row['spersonID'];
        } else {
            $spouseID = $row['husband'] ? $row['husband'] : $row['wife'];
        }
        if ($spouseID) {
            $query = "SELECT lastname, lnprefix, firstname, nickname, prefix, suffix, nameorder, title, living, private, branch, gedcom, birthplace, birthdate, birthdatetr, deathplace, deathdate, altbirthdate, altbirthdatetr, altbirthplace, burialdate ";
            $query .= "FROM $people_table ";
            $query .= "WHERE personID = '$spouseID' AND gedcom = '{$row['gedcom']}'";
            $spresult = tng_query($query);
            $sprow = tng_fetch_assoc($spresult);
            if ($sprow) {
                $sprights = determineLivingPrivateRights($sprow);
                $sprow['allow_living'] = $sprights['living'];
                $sprow['allow_private'] = $sprights['private'];
                $spouse = getName($sprow);
            }
            tng_free_result($spresult);
        }
        $spousestr = $spouse ? "<a href='getperson.php?personID=$spouseID&amp;tree={$row['gedcom']}'>$spouse</a>&nbsp;" : "";
    } else {
        $spousestr = "";
    }
    if ($myprefix) echo "<td class='p-2 databack'>$prefix &nbsp;</td>";
    if ($mysuffix) echo "<td class='p-2 databack'>$suffix &nbsp;</td>";
    if ($mytitle) echo "<td class='p-2 databack'>$title &nbsp;</td>";
    if ($mynickname) echo "<td class='p-2 databack'>$nickname &nbsp;</td>";
    echo "<td class='p-2 databack'>$birthdate<br>$birthplace</td>";
    if ($mydeathyear || $mydeathplace || $myburialyear || $myburialplace || $showdeath) {
        echo "<td class='p-2 databack'>$deathdate &nbsp;</td>";
        echo "<td class='p-2 databack'>$deathplace &nbsp;</td>";
    }
    if ($showspouse) echo "<td class='p-2 databack'>$spousestr</td>";
    if ($numtrees > 1 || $numbranches) {
        echo "<td class='p-2 databack'><a href='showtree.php?tree={$row['gedcom']}'>{$row['treename']}</a>";
        if ($row['branch']) {
            $branches = explode(",", $row['branch']);
            echo "<br>";
            $branchstr = "";
            foreach ($branches as $branch) {
                $key = $row['gedcom'] . "_" . $branch;
                $branchname = $branchnames[$key];
                if (!$branchname) {
                    $query = "SELECT description FROM $branches_table WHERE gedcom = '{$row['gedcom']}' AND branch = '$branch'";
                    $brresult = tng_query($query);
                    $brrow = tng_fetch_assoc($brresult);
                    $branchname = $brrow['description'];
                    $branchnames[$key] = $branchname;
                    tng_free_result($brresult);
                }
                if ($branchstr) $branchstr .= ", ";
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
echo "</table>\n";
echo "<div class='w-full class=lg:flex my-6'>";
echo getPaginationLocationHtml($offsetplus, $numrowsplus, $totrows);
echo getPaginationControlsHtml($totrows, "search.php?$urlstring&amp;mybool=$mybool&amp;nr=$maxsearchresults&amp;showspouse=$showspouse&amp;showdeath=$showdeath&amp;offset", $maxsearchresults);
echo "</div>";
?>
    <script src="js/search.js"></script>
<?php tng_footer(""); ?>
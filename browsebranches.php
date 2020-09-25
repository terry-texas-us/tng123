<?php
$textpart = "trees";
include "tng_begin.php";

include "functions.php";

function doBranchSearch($instance, $pagenav) {
    global $text, $branchsearch;

    $str = "<span class='normal'>\n";
    $str .= getFORM("browsebranches", "GET", "BranchSearch$instance", "");
    $str .= "<input type='text' name=\"branchsearch\" value=\"$branchsearch\"> <input type='submit' value=\"{$text['search']}\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $str .= $pagenav;
    if ($branchsearch) {
        $str .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"browsebranches.php\">{$text['browsealltrees']}</a>";
    }
    $str .= "</form></span>\n";

    return $str;
}

$max_browsebranch_pages = 5;
if ($offset) {
    $offsetplus = $offset + 1;
    $newoffset = "$offset, ";
} else {
    $offsetplus = 1;
    $newoffset = "";
    $page = 1;
}

$branchsearch = cleanIt(trim($branchsearch));
if ($branchsearch) {
    $wherestr = " AND (branch LIKE \"%$branchsearch%\" OR branches.description LIKE \"%$branchsearch%\")";
} else {
    $wherestr = "";
}
if ($tree) {
    $wherestr .= " AND branches.gedcom = \"$tree\"";
}

$query = "SELECT branches.branch, branches.gedcom, branches.description, treename, personID ";
$query .= "FROM ($branches_table branches, $trees_table trees) ";
$query .= "WHERE branches.gedcom = trees.gedcom $wherestr ";
$query .= "ORDER BY branches.description ";
$query .= "LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);

$numrows = tng_num_rows($result);

if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $query = "SELECT count(branch) AS branchcount FROM $branches_table";
    $result2 = tng_query($query);
    $countrow = tng_fetch_assoc($result2);
    $totrows = $countrow['branchcount'];
} else {
    $totrows = $numrows;
}

$numrowsplus = $numrows + $offset;

$treequery = "SELECT count(gedcom) AS treecount FROM $trees_table";
$treeresult = tng_query($treequery);
$treerow = tng_fetch_assoc($treeresult);
$numtrees = $treerow['treecount'];
tng_free_result($treeresult);

$logstring = "<a href=\"browsebranches.php?tree=$tree&amp;offset=$offset&amp;branchsearch=$branchsearch\">" . xmlcharacters($text['branches']) . "</a>";
writelog($logstring);
preparebookmark($logstring);

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

tng_header($text['branches'], $flags);
?>

    <h2 class="header"><span class="headericon" id="branches-hdr-icon"></span><?php echo $text['branches']; ?></h2>
    <br style="clear: left;">
<?php
echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'browsebranches', 'method' => 'get', 'name' => 'form1', 'id' => 'form1']);

if ($totrows) {
    echo "<p><span class='normal'>{$text['matches']} $offsetplus {$text['to']} $numrowsplus {$text['of']} $totrows</span></p>";
}

$pagenav = get_browseitems_nav($totrows, "browsebranches.php?branchsearch=$branchsearch&amp;offset", $maxsearchresults, $max_browsebranch_pages);
if ($pagenav || $branchsearch) {
    echo doBranchSearch(1, $pagenav);
}

$header = "";
$headerr = $enableminimap ? " data-tablesaw-minimap" : "";
$headerr .= $enablemodeswitch ? " data-tablesaw-mode-switch" : "";

if ($sitever != "standard") {
    if ($tabletype == "toggle") {
        $tabletype = "columntoggle";
    }
    $header = "<table cellpadding=\"3\" cellspacing='1' border=\"0\" width=\"100%\" class=\"tablesaw whiteback normal\" data-tablesaw-mode=\"$tabletype\"{$headerr}>\n";
} else {
    $header = "<table cellpadding=\"3\" cellspacing='1' border=\"0\" class=\"whiteback normal\">";
}
echo $header;
?>
    <thead>
    <tr>
        <th data-tablesaw-priority="persist" class="fieldnameback nbrcol fieldname">&nbsp;#&nbsp;</th>
        <th data-tablesaw-priority="1" class="fieldnameback nw fieldname">&nbsp;<?php echo $text['description']; ?>&nbsp;</th>
        <?php
        if ($numtrees > 1) {
            ?>
            <th data-tablesaw-priority="2" class="fieldnameback nw fieldname">&nbsp;<?php echo $text['treename']; ?>&nbsp;</th>
            <?php
        }
        ?>
        <th data-tablesaw-priority="3" class="fieldnameback nw fieldname">&nbsp;<?php echo $text['startingind']; ?>&nbsp;</th>
        <th data-tablesaw-priority="4" class="fieldnameback nw fieldname">&nbsp;<?php echo $text['individuals']; ?>&nbsp;</th>
        <th data-tablesaw-priority="5" class="fieldnameback nw fieldname">&nbsp;<?php echo $text['families']; ?>&nbsp;</th>
    </tr>
    </thead>
<?php
$i = $offsetplus;
$peoplewhere = getLivingPrivateRestrictions($people_table, false, false);
if ($peoplewhere) {
    $peoplewhere = "AND " . $peoplewhere;
}
$familywhere = getLivingPrivateRestrictions($families_table, false, false);
if ($familywhere) {
    $familywhere = "AND " . $familywhere;
}

while ($row = tng_fetch_assoc($result)) {
    $query = "SELECT count(familyID) AS fcount FROM $families_table WHERE branch LIKE \"%{$row['branch']}%\" $familywhere";
    $famresult = tng_query($query);
    $famrow = tng_fetch_assoc($famresult);
    tng_free_result($famresult);

    $query = "SELECT count(personID) AS pcount FROM $people_table WHERE branch LIKE \"%{$row['branch']}%\" $peoplewhere";
    $indresult = tng_query($query);
    $indrow = tng_fetch_assoc($indresult);
    tng_free_result($indresult);

    $presult = getPersonSimple($row['gedcom'], $row['personID']);
    $prow = tng_fetch_assoc($presult);
    tng_free_result($presult);
    $prights = determineLivingPrivateRights($prow);
    $prow['allow_living'] = $prights['living'];
    $prow['allow_private'] = $prights['private'];
    $namestr = getName($prow);

    echo "<tr>";
    echo "<td class='databack'>$i</td>\n";
    echo "<td class='databack'>{$row['description']}&nbsp;</td>";
    if ($numtrees > 1) {
        echo "<td class='databack'><a href=\"showtree.php?tree={$row['gedcom']}\">{$row['treename']}</a>&nbsp;</td>";
    }
    echo "<td class='databack'><a href=\"getperson.php?personID={$row['personID']}&amp;tree={$row['gedcom']}\">$namestr</a>&nbsp;</td>";
    echo "<td class='databack' align=\"right\"><a href=\"search.php?tree={$row['gedcom']}&amp;branch={$row['branch']}\">" . number_format($indrow['pcount']) . "</a>&nbsp;</td>";
    echo "<td class='databack' align=\"right\"><a href=\"famsearch.php?tree={$row['gedcom']}&amp;branch={$row['branch']}\">" . number_format($famrow['fcount']) . "</a>&nbsp;</td>";
    echo "</tr>\n";
    $i++;
}
tng_free_result($result);
?>
    </table>

<?php
if ($pagenav || $treesearch) {
    echo doBranchSearch(2, $pagenav);
}

tng_footer("");
?>
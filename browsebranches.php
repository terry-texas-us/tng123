<?php

$textpart = "trees";
include "tng_begin.php";
include "functions.php";
require_once "admin/pagination.php";
require_once "admin/trees.php";
if ($offset) {
    $offsetplus = $offset + 1;
    $newoffset = "$offset, ";
} else {
    $offsetplus = 1;
    $newoffset = "";
    $page = 1;
}
$branchsearch = cleanIt(trim($branchsearch));
$query = "SELECT branches.branch, branches.gedcom, branches.description, treename, personID ";
$query .= "FROM ($branches_table branches, $trees_table trees) ";
$query .= "WHERE branches.gedcom = trees.gedcom ";
if ($branchsearch) $query .= " AND (branch LIKE '%$branchsearch%' OR branches.description LIKE '%$branchsearch%')";
if ($tree) $query .= " AND branches.gedcom = '$tree'";
$query .= "ORDER BY branches.description ";
$query .= "LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);
$branches = tng_fetch_all($result);
tng_free_result($result);
$numrows = count($branches);
if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $query = "SELECT COUNT(branch) AS branchcount FROM $branches_table";
    $result = tng_query($query);
    $countrow = tng_fetch_assoc($result);
    $totrows = $countrow['branchcount'];
} else {
    $totrows = $numrows;
}
$numrowsplus = $numrows + $offset;
$numtrees = getTreesCount($trees_table);
$logstring = "<a href=\"browsebranches.php?tree=$tree&amp;offset=$offset&amp;branchsearch=$branchsearch\">" . xmlcharacters(_('Branches')) . "</a>";
writelog($logstring);
preparebookmark($logstring);
tng_header(_('Branches'), $flags);
?>
    <h2 class="mb-4 header"><span class="headericon" id="branches-hdr-icon"></span><?php echo _('Branches'); ?></h2>
<?php echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'browsebranches', 'method' => 'get', 'name' => 'form1', 'id' => 'form1']); ?>
    <div class='mb-4 normal'>
        <form name="branchsearch1" action="browsebranches.php" method="get">
            <label for="branchsearch" hidden><?php echo _('Search'); ?></label>
            <input id="branchsearch" class="p-1 ml-1" name="branchsearch" type="search" value="<?php echo $branchsearch; ?>">
            <input class="p-1 px-2" type="submit" value="<?php echo _('Search'); ?>">
            <input name='tree' type='hidden' value="<?php echo $tree; ?>">
        </form>
    </div>
    <table class='whiteback normal'>
        <thead>
        <tr>
            <th class="hidden p-2 sm:table-cell fieldnameback nbrcol fieldname">#</th>
            <th class="p-2 fieldnameback whitespace-no-wrap fieldname"><?php echo _('Description'); ?></th>
            <?php if ($numtrees > 1) { ?>
                <th class="p-2 fieldnameback whitespace-no-wrap fieldname"><?php echo _('Tree Name'); ?></th>
            <?php } ?>
            <th class="p-2 fieldnameback whitespace-no-wrap fieldname"><?php echo _('Starting Individual'); ?></th>
            <th class="p-2 fieldnameback whitespace-no-wrap fieldname"><?php echo _('individuals'); ?></th>
            <th class="p-2 fieldnameback whitespace-no-wrap fieldname"><?php echo _('Families'); ?></th>
        </tr>
        </thead>
        <?php
        $i = $offsetplus;
        $peoplewhere = getLivingPrivateRestrictions($people_table, false, false);
        if ($peoplewhere) $peoplewhere = "AND " . $peoplewhere;
        $familywhere = getLivingPrivateRestrictions($families_table, false, false);
        if ($familywhere) $familywhere = "AND " . $familywhere;
        foreach ($branches as $row) {
            $query = "SELECT COUNT(familyID) AS fcount FROM $families_table WHERE branch LIKE \"%{$row['branch']}%\" $familywhere";
            $famresult = tng_query($query);
            $famrow = tng_fetch_assoc($famresult);
            tng_free_result($famresult);
            $query = "SELECT COUNT(personID) AS pcount FROM $people_table WHERE branch LIKE \"%{$row['branch']}%\" $peoplewhere";
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
            echo "<td class='hidden p-2 sm:table-cell databack'>$i</td>\n";
            echo "<td class='p-2 databack'>{$row['description']}</td>";
            if ($numtrees > 1) {
                echo "<td class='p-2 databack'><a href=\"showtree.php?tree={$row['gedcom']}\">{$row['treename']}</a>&nbsp;</td>";
            }
            echo "<td class='p-2 databack'><a href=\"getperson.php?personID={$row['personID']}&amp;tree={$row['gedcom']}\">$namestr</a></td>";
            echo "<td class='p-2 text-right databack'><a href=\"search.php?tree={$row['gedcom']}&amp;branch={$row['branch']}\">" . number_format($indrow['pcount']) . "</a></td>";
            echo "<td class='p-2 text-right databack'><a href=\"famsearch.php?tree={$row['gedcom']}&amp;branch={$row['branch']}\">" . number_format($famrow['fcount']) . "</a></td>";
            echo "</tr>\n";
            $i++;
        }
        ?>
    </table>
    <div class='w-full class=lg:flex my-6'>
        <?php
        echo getPaginationLocationHtml($offsetplus, $numrowsplus, $totrows);
        echo getPaginationControlsHtml($totrows, "browsebranches.php?branchsearch=$branchsearch&amp;offset", $maxsearchresults);
        ?>
    </div>
<?php tng_footer(""); ?>
<?php

$textpart = "sources";
include "tng_begin.php";
include "functions.php";
require_once "admin/pagination.php";
if ($offset) {
    $offsetplus = $offset + 1;
    $newoffset = "$offset, ";
} else {
    $offsetplus = 1;
    $newoffset = "";
    $page = 1;
}
$reposearch = cleanIt(trim($reposearch));
if ($tree) {
    $wherestr = "WHERE repositories.gedcom = '$tree'";
    if ($reposearch) {
        $wherestr .= " AND reponame LIKE '%$reposearch%'";
    }
    $join = "INNER JOIN";
} else {
    if ($reposearch) {
        $wherestr = "WHERE reponame LIKE '%$reposearch%'";
    } else {
        $wherestr = "";
    }
    $join = "LEFT JOIN";
}
$query = "SELECT repoID, reponame, repositories.gedcom AS gedcom, treename ";
$query .= "FROM $repositories_table repositories ";
$query .= "$join $trees_table trees ON repositories.gedcom = trees.gedcom ";
$query .= "$wherestr ";
$query .= "ORDER BY reponame ";
$query .= "LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);
$repositories = tng_fetch_all($result);
tng_free_result($result);
$numrows = count($repositories);
if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $query = "SELECT COUNT(repoID) AS scount ";
    $query .= "FROM $repositories_table repositories ";
    if ($tree) $query .= "LEFT JOIN $trees_table trees ON repositories.gedcom = trees.gedcom ";
    $query .= "$wherestr";
    $result = tng_query($query);
    $row = tng_fetch_assoc($result);
    $totrows = $row['scount'];
} else {
    $totrows = $numrows;
}
$numrowsplus = $numrows + $offset;
$treestr = $tree ? " (" . _('Tree') . ": $tree)" : "";
$logstring = "<a href='browserepos.php?tree=$tree&amp;offset=$offset&amp;reposearch=$reposearch'>" . xmlcharacters(_('Repositories') . $treestr) . "</a>";
writelog($logstring);
preparebookmark($logstring);
tng_header(_('Repositories'), $flags);
?>
<h2 class="mb-4 header"><span class="headericon" id="repos-hdr-icon"></span><?php echo _('Repositories'); ?></h2>
<div class='normal'>
    <?php echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'browserepos', 'method' => 'get', 'name' => 'form1', 'id' => 'form1']); ?>
    <div class='mb-4 normal'>
        <form name="reposearch1" action="browserepos.php" method="get">
            <label for="reposearch"><?php echo _('Search'); ?></label>
            <input id="reposearch" class="p-1 ml-1" name="reposearch" type="search" value="<?php echo $reposearch; ?>">
            <input class="p-1 px-2" type="submit" value="<?php echo _('Search'); ?>">
            <input name='tree' type='hidden' value="<?php echo $tree; ?>">
        </form>
    </div>
    <table class='whiteback normal'>
        <thead>
        <tr>
            <th class="hidden p-2 sm:display-cell fieldnameback nbrcol fieldname">#</th>
            <th class="p-2 fieldnameback fieldname"><?php echo _('Repository ID'); ?></th>
            <th class="p-2 fieldnameback fieldname"><?php echo _('Name'); ?></th>
            <?php if ($numtrees > 1) { ?>
                <th class="p-2 fieldnameback"><?php echo _('Tree'); ?></th><?php } ?>
        </tr>
        </thead>
        <tbody>
        <?php
        $i = $offsetplus;
        foreach ($repositories as $row) {
            echo "<tr>\n";
            echo "<td class='hidden p-2 align-top sm:dispay-cell databack'><span class='normal'>$i</span></td>\n";
            echo "<td class='p-2 databack'><span class='normal'><a href=\"showrepo.php?repoID={$row['repoID']}&amp;tree={$row['gedcom']}\">{$row['repoID']}</a>&nbsp;</span></td>";
            echo "<td class='p-2 databack'><span class='normal'><a href=\"showrepo.php?repoID={$row['repoID']}&amp;tree={$row['gedcom']}\">{$row['reponame']}</a>&nbsp;</span></td>";
            if ($numtrees > 1) {
                echo "<td class='p-2 databack whitespace-no-wrap'><span class='normal'>{$row['treename']}&nbsp;</span></td>";
            }
            echo "</tr>\n";
            $i++;
        }
        ?>
        </tbody>
    </table>
    <br>
</div>
<?php
echo "<div class='w-full class=lg:flex my-6'>";
echo getPaginationLocationHtml($offsetplus, $numrowsplus, $totrows);
echo getPaginationControlsHtml($totrows, "browserepos.php?reposearch=$reposearch&amp;offset", $maxsearchresults, 3);
echo "</div>";
tng_footer("");
?>

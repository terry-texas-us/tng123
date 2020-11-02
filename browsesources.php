<?php

$textpart = "sources";
include "tng_begin.php";
include "functions.php";
require_once "admin/pagination.php";

if (!isset($offset)) $offset = 0;
if ($offset) {
    $offsetplus = $offset + 1;
    $newoffset = "$offset, ";
} else {
    $offsetplus = 1;
    $newoffset = "";
    $page = 1;
}
$sourcesearch = isset($sourcesearch) ? cleanIt(trim($sourcesearch)) : "";
if ($tree) {
    $wherestr = "WHERE sources.gedcom = '$tree'";
    if ($sourcesearch) {
        $wherestr .= " AND (title LIKE '%$sourcesearch%' OR shorttitle LIKE '%$sourcesearch%' OR author LIKE '%$sourcesearch%')";
    }
    $join = "INNER JOIN";
} else {
    if ($sourcesearch) {
        $wherestr = "WHERE title LIKE '%$sourcesearch%' OR shorttitle LIKE '%$sourcesearch%' OR author LIKE '%$sourcesearch%'";
    } else {
        $wherestr = "";
    }
    $join = "LEFT JOIN";
}
$query = "SELECT sourceID, title, shorttitle, author, sources.gedcom AS gedcom, treename ";
$query .= "FROM $sources_table sources ";
$query .= "$join $trees_table trees ON sources.gedcom = trees.gedcom ";
$query .= "$wherestr ";
$query .= "ORDER BY title ";
$query .= "LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);
$sources = tng_fetch_all($result);
tng_free_result($result);
$numrows = count($sources);
if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $query = "SELECT COUNT(sourceID) AS scount ";
    $query .= "FROM $sources_table sources ";
    if ($tree) {
        $query .= "LEFT JOIN $trees_table trees ON sources.gedcom = trees.gedcom ";
    }
    $query .= "$wherestr";
    $result2 = tng_query($query);
    $row = tng_fetch_assoc($result2);
    $totrows = $row['scount'];
} else {
    $totrows = $numrows;
}
$numrowsplus = $numrows + $offset;
$treestr = $tree ? " ({$text['tree']}: $tree)" : "";
$logstring = "<a href='browsesources.php?tree=$tree&amp;offset=$offset&amp;sourcesearch=$sourcesearch'>" . xmlcharacters($text['sources'] . $treestr) . "</a>";
writelog($logstring);
preparebookmark($logstring);
tng_header($text['sources'], $flags);
?>
    <h2 class="mb-4 header"><span class="headericon" id="sources-hdr-icon"></span><?php echo $text['sources']; ?></h2>

<?php echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'browsesources', 'method' => 'get', 'name' => 'form1', 'id' => 'form1']); ?>
    <div class='mb-4 normal'>
        <form name="sourcesearch1" action="browsesources.php" method="get">
            <label for="sourcesearch" hidden><?php echo $text['search']; ?></label>
            <input id="sourcesearch" class="p-1 ml-1" name="sourcesearch" type="search" value="<?php echo $sourcesearch; ?>">
            <input class="p-1 px-2" type="submit" value="<?php echo $text['search']; ?>">
            <input name='tree' type='hidden' value="<?php echo $tree; ?>">
        </form>
    </div>
    <table class='whiteback'>
        <thead>
        <tr>
            <th class="hidden p-2 sm:table-cell fieldnameback nbrcol"><span class="fieldname">#</span></th>
            <th class="p-2 fieldnameback whitespace-no-wrap"><span class="fieldname"><?php echo $text['sourceid']; ?></span></th>
            <th class="p-2 fieldnameback whitespace-no-wrap"><span class="fieldname"><?php echo $text['title'] . ", " . $text['author']; ?></span></th>
            <?php if ($numtrees > 1) { ?>
                <th class="p-2 fieldnameback"><span class="fieldname"><?php echo $text['tree']; ?></span></th>
            <?php } ?>
        </tr>
        </thead>
        <?php
        $i = $offsetplus;
        foreach ($sources as $row) {
            $sourcetitle = $row['title'] ? $row['title'] : $row['shorttitle'];
            echo "<tr>";
            echo "<td class='hidden p-2 sm:table-cell databack align-top'><span class='normal'>$i</span></td>\n";
            echo "<td class='p-2 align-top databack'><span class='normal'><a href=\"showsource.php?sourceID={$row['sourceID']}&amp;tree={$row['gedcom']}\">{$row['sourceID']}</a></span></td>";
            echo "<td class='p-2 databack'><span class='normal'><a href=\"showsource.php?sourceID={$row['sourceID']}&amp;tree={$row['gedcom']}\">$sourcetitle</a><br>{$row['author']}&nbsp;</span></td>";
            if ($numtrees > 1) {
                echo "<td class='p-2 databack whitespace-no-wrap'><span class='normal'><a href=\"showtree.php?tree={$row['gedcom']}\">{$row['treename']}</a></span></td>";
            }
            echo "</tr>\n";
            $i++;
        }
        ?>
    </table>
    <br>
<?php
echo "<div class='w-full class=lg:flex my-6'>";
echo getPaginationLocationHtml($offsetplus, $numrowsplus, $totrows);
echo getPaginationControlsHtml($totrows, "browsesources.php?sourcesearch=$sourcesearch&amp;offset", $maxsearchresults, 3);
echo "</div>";
tng_footer("");
?>
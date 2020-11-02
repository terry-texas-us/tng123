<?php

$textpart = "trees";
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
$query = "SELECT COUNT(personID) AS pcount, trees.gedcom, treename, description ";
$query .= "FROM $trees_table trees ";
$query .= "LEFT JOIN $people_table people ON trees.gedcom = people.gedcom ";
if ($treesearch) $query .= "WHERE treename LIKE '%$treesearch%' OR description LIKE '%$treesearch%'";
$query .= "GROUP BY trees.gedcom ";
$query .= "ORDER BY treename ";
$query .= "LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);

$numrows = tng_num_rows($result);
if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $query = "SELECT COUNT(gedcom) AS treecount FROM $trees_table";
    $result2 = tng_query($query);
    $countrow = tng_fetch_assoc($result2);
    $totrows = $countrow['treecount'];
} else {
    $totrows = $numrows;
}
$numrowsplus = $numrows + $offset;
tng_header($text['trees'], $flags);
?>
<h2 class="mb-4 header"><span class="headericon" id="trees-hdr-icon"></span><?php echo $text['trees']; ?></h2>

<div class='mb-4 normal'>
    <form name="treesearch1" action="browsetrees.php" method="get">
        <label for="treesearch" hidden><?php echo $text['search']; ?></label>
        <input id="treesearch" class="p-1 ml-1" name="treesearch" type="search" value="<?php echo $treesearch; ?>">
        <input class="p-1 px-2" type="submit" value="<?php echo $text['search']; ?>">
        <input name='tree' type='hidden' value="<?php echo $tree; ?>">
    </form>
</div>

<div class='w-full class=lg:flex my-6'>
    <?php
    echo getPaginationLocationHtml($offsetplus, $numrowsplus, $totrows);
    echo getPaginationControlsHtml($totrows, "browsesources.php?sourcesearch=$sourcesearch&amp;offset", $maxsearchresults, 3);
    ?>
</div>

<div class="inline-block mr-12">
    <table class='whiteback normal'>
        <thead>
        <tr>
            <th class="p-2 fieldnameback nbrcol fieldname">#</th>
            <th class="p-2 fieldnameback fieldname"><?php echo $text['treename']; ?></th>
            <th class="p-2 fieldnameback fieldname"><?php echo $text['description']; ?></th>
            <th class="p-2 fieldnameback fieldname"><?php echo $text['individuals']; ?></th>
            <th class="p-2 fieldnameback fieldname"><?php echo $text['families']; ?></th>
            <th class="p-2 fieldnameback fieldname"><?php echo $text['sources']; ?></th>
            <?php
            $trees = explode(',', $_SESSION['availabletrees']);
            $numtrees = count($trees);
            if ($numtrees > 1) {
                ?>
                <th class="p-2 fieldnameback fieldname">&nbsp;</th>
            <?php } ?>
        </tr>
        </thead>
        <?php
        $i = $offsetplus;
        $treenames = [];
        while ($row = tng_fetch_assoc($result)) {
            $query = "SELECT count(familyID) AS fcount FROM $families_table WHERE gedcom = \"{$row['gedcom']}\"";
            $famresult = tng_query($query);
            $famrow = tng_fetch_assoc($famresult);
            tng_free_result($famresult);
            $treenames[$row['treename']] = $row['pcount'];
            $query = "SELECT count(sourceID) AS scount FROM $sources_table WHERE gedcom = \"{$row['gedcom']}\"";
            $srcresult = tng_query($query);
            $srcrow = tng_fetch_assoc($srcresult);
            tng_free_result($srcresult);
            echo "<tr>\n";
            echo "<td class='p-2 databack'>$i</td>\n";
            echo "<td class='p-2 databack'><a href=\"showtree.php?tree={$row['gedcom']}\">{$row['treename']}</a>&nbsp;</td>";
            echo "<td class='p-2 databack'>{$row['description']}&nbsp;</td>";
            echo "<td class='p-2 text-right databack'><a href=\"search.php?tree={$row['gedcom']}\">" . number_format($row['pcount']) . "</a>&nbsp;</td>";
            echo "<td class='p-2 text-right databack'><a href=\"famsearch.php?tree={$row['gedcom']}\">" . number_format($famrow['fcount']) . "</a>&nbsp;</td>";
            echo "<td class='p-2 text-right databack'><a href=\"browsesources.php?tree={$row['gedcom']}\">" . number_format($srcrow['scount']) . "</a>&nbsp;</td>";
            if ($numtrees > 1) {
                echo "<td class='text-right p-2databack'>";
                if ($row['gedcom'] == $assignedtree) {
                    echo $admtext['active'];
                } elseif (in_array($row['gedcom'], $trees)) {
                    echo "<a href=\"switchtree.php?newtree={$row['gedcom']}&ret={$homepage}\">{$text['switch']}</a>";
                }
                echo "</td>";
            }
            echo "</tr>\n";
            $i++;
        }
        tng_free_result($result);
        echo "</table>";
        ?>
</div>
<?php if ($totrows > 1) { ?>
    <link href="css/c3.css" rel="stylesheet">
    <script src="js/d3.min.js"></script>
    <script src="js/c3.min.js"></script>

    <div id="charts" style="display:inline-block; width:400px; vertical-align:top;text-align:center;">
        <div id="trees_chart"></div>
    </div>
    <script>
        let trees_chart = c3.generate({
            bindto: '#trees_chart',
            data: {
                columns: [
                    <?php
                    $count = 1;
                    foreach ($treenames as $key => $val) {
                        if ($count > 1) echo ",\n";
                        echo "['data{$count}', {$val}]";
                        if ($count == 10) break;
                        $count++;
                    }
                    ?>
                ],
                type: 'pie',
                names: {
                    <?php
                    $count = 1;
                    foreach ($treenames as $key => $val) {
                        if ($count > 1) echo ",\n";
                        $numnames = number_format($val);
                        echo "data{$count}: '{$key} ({$numnames})'";
                        if ($count == 10) break;
                        $count++;
                    }
                    ?>
                }
            }
        });
    </script>
    <?php
}
tng_footer("");
?>

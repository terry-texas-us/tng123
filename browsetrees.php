<?php
$textpart = "trees";
include "tng_begin.php";

include "functions.php";

function doTreeSearch($instance, $pagenav) {
    global $text, $treesearch;

    $str = "<span class='normal'>\n";
    $str .= getFORM("browsetrees", "GET", "TreeSearch$instance", "");
    $str .= "<input type='text' name=\"treesearch\" value=\"$treesearch\"> <input type='submit' value=\"{$text['search']}\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $str .= $pagenav;
    if ($treesearch) {
        $str .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='browsetrees.php'>{$text['browsealltrees']}</a>";
    }
    $str .= "</form></span>\n";

    return $str;
}

$max_browsetree_pages = 5;
if ($offset) {
    $offsetplus = $offset + 1;
    $newoffset = "$offset, ";
} else {
    $offsetplus = 1;
    $newoffset = "";
    $page = 1;
}

if ($treesearch) {
    $wherestr = "WHERE treename LIKE \"%$treesearch%\" OR description LIKE \"%$treesearch%\"";
} else {
    $wherestr = "";
}

$query = "SELECT count(personID) AS pcount, trees.gedcom, treename, description ";
$query .= "FROM $trees_table trees ";
$query .= "LEFT JOIN $people_table people ON trees.gedcom = people.gedcom ";
$query .= "$wherestr ";
$query .= "GROUP BY trees.gedcom ";
$query .= "ORDER BY treename ";
$query .= "LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);

$numrows = tng_num_rows($result);

if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $query = "SELECT count(gedcom) AS treecount FROM $trees_table";
    $result2 = tng_query($query);
    $countrow = tng_fetch_assoc($result2);
    $totrows = $countrow['treecount'];
} else {
    $totrows = $numrows;
}

$numrowsplus = $numrows + $offset;

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

tng_header($text['trees'], $flags);

if ($totrows > 1) {
    ?>
    <link href="css/c3.css" rel="stylesheet">
    <script src="js/d3.min.js"></script>
    <script src="js/c3.min.js"></script>
<?php } ?>

<h2 class="header"><span class="headericon" id="trees-hdr-icon"></span><?php echo $text['trees']; ?></h2>
<br style="clear: left;">

<?php
if ($totrows) {
    echo "<p><span class='normal'>{$text['matches']} $offsetplus {$text['to']} $numrowsplus {$text['of']} $totrows</span></p>";
}

$pagenav = get_browseitems_nav($totrows, "browsetrees.php?treesearch=$treesearch&amp;offset", $maxsearchresults, $max_browsetree_pages);
if ($pagenav || $treesearch) {
    echo doTreeSearch(1, $pagenav);
}

$header = "";
$headerr = $enableminimap ? " data-tablesaw-minimap" : "";
$headerr .= $enablemodeswitch ? " data-tablesaw-mode-switch" : "";

if (isMobile()) {
    if ($tabletype == "toggle") {
        $tabletype = "columntoggle";
    }
    $header = "<table class='tablesaw whiteback normal w-100' cellpadding='3' cellspacing='1' border='0' data-tablesaw-mode=\"$tabletype\"{$headerr}>\n";
} else {
    $header = "<table class='whiteback normal' cellpadding='3' cellspacing='1' border='0'>";
}
?>
<div style="display:inline-block; margin-right:50px;">
    <?php
    echo $header;
    ?>
    <thead>
    <tr>
        <th data-tablesaw-priority="persist" class="fieldnameback nbrcol fieldname">&nbsp;#&nbsp;
        </td>
        <th data-tablesaw-priority="1" class="fieldnameback text-nowrap fieldname"><?php echo $text['treename']; ?></th>
        <th data-tablesaw-priority="2" class="fieldnameback text-nowrap fieldname"><?php echo $text['description']; ?></th>
        <th data-tablesaw-priority="3" class="fieldnameback text-nowrap fieldname"><?php echo $text['individuals']; ?></th>
        <th data-tablesaw-priority="4" class="fieldnameback text-nowrap fieldname"><?php echo $text['families']; ?></th>
        <th data-tablesaw-priority="5" class="fieldnameback text-nowrap fieldname"><?php echo $text['sources']; ?></th>
        <?php
        $trees = explode(',', $_SESSION['availabletrees']);
        $numtrees = count($trees);
        if ($numtrees > 1) {
            ?>
            <th data-tablesaw-priority="5" class="fieldnameback text-nowrap fieldname">&nbsp;</th>
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

        echo "<tr><td class='databack'>$i</td>\n";
        echo "<td class='databack'><a href=\"showtree.php?tree={$row['gedcom']}\">{$row['treename']}</a>&nbsp;</td>";
        echo "<td class='databack'>{$row['description']}&nbsp;</td>";
        echo "<td class='databack' align=\"right\"><a href=\"search.php?tree={$row['gedcom']}\">" . number_format($row['pcount']) . "</a>&nbsp;</td>";
        echo "<td class='databack' align=\"right\"><a href=\"famsearch.php?tree={$row['gedcom']}\">" . number_format($famrow['fcount']) . "</a>&nbsp;</td>";
        echo "<td class='databack' align=\"right\"><a href=\"browsesources.php?tree={$row['gedcom']}\">" . number_format($srcrow['scount']) . "</a>&nbsp;</td>";
        if ($numtrees > 1) {
            echo "<td class='databack' align=\"right\">";
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
    <br><br>
</div>
<?php
if ($totrows > 1) {
    ?>
    <div id="charts" style="display:inline-block; width:400px; vertical-align:top;text-align:center;">
        <div id="trees_chart"></div>
    </div>
    <script>
        var trees_chart = c3.generate({
            bindto: '#trees_chart',
            data: {
                columns: [
                    <?php
                    $count = 1;
                    foreach ($treenames as $key => $val) {
                        if ($count > 1) {
                            echo ",\n";
                        }
                        echo "['data{$count}', {$val}]";
                        if ($count == 10) {
                            break;
                        }
                        $count++;
                    }
                    ?>
                ],
                type: 'pie',
                names: {
                    <?php
                    $count = 1;
                    foreach ($treenames as $key => $val) {
                        if ($count > 1) {
                            echo ",\n";
                        }
                        $numnames = number_format($val);
                        echo "data{$count}: '{$key} ({$numnames})'";
                        if ($count == 10) {
                            break;
                        }
                        $count++;
                    }
                    ?>
                }
            }
        });
    </script>
<?php } ?>

<br>
<?php
tng_footer("");
?>

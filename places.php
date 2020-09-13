<?php
$textpart = "places";
include "tng_begin.php";

$placesearch_url = getURL("placesearch", 1);
$places_oneletter_url = getURL("places-oneletter", 1);
$places_url = getURL("places", 1);

if ($tree && !$tngconfig['places1tree']) {
    $treestr = "tree=$tree&amp;";
    $treestr2 = "tree=$tree";
    $places_all_url = getURL("places-all", 1);
    $heatmap_url = getURL("heatmap", 1);
    $logstring = "<a href=\"$places_url" . "offset=$offset&amp;$treestr2\">{$text['placelist']} ({$text['tree']}: $tree)</a>";
} else {
    $treestr = $treestr2 = "";
    $places_all_url = getURL("places-all", 0);
    $heatmap_url = getURL("heatmap", 0);
    $logstring = "<a href=\"$places_url\">{$text['placelist']}</a>";
}
$text['top30places'] = preg_replace("/xxx/", "30", $text['top30places']);

writelog($logstring);
preparebookmark($logstring);

tng_header($text['placelist'], $flags);
?>

    <h2 class="header"><span class="headericon" id="places-hdr-icon"></span><?php echo $text['placelist']; ?></h2><br class="clearleft">
<?php
if (!$tngconfig['places1tree']) {
    echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'places', 'method' => 'get', 'name' => 'form1', 'id' => 'form1']);
}

$linkstr = "";
$linkstr2col1 = "";
$linkstr2col2 = "";
$linkstr3col1 = "";
$linkstr3col2 = "";
$collen = $sitever == "mobile" ? 15 : 10;
$cols = $sitever == "mobile" ? 2 : 3;

$offsetorg = $offset;
$offset = $offset ? $offset + 1 : 1;

$query = "SELECT UCASE(LEFT(TRIM(SUBSTRING_INDEX(place, ', ', -$offset)), 1)) AS firstchar, COUNT(UCASE(LEFT(TRIM(SUBSTRING_INDEX(place, ', ', -$offset)), 1))) AS placecount ";
$query .= "FROM $places_table ";
$query .= "WHERE TRIM(SUBSTRING_INDEX(place, ', ', -$offset)) != '' ";
if ($tree && !$tngconfig['places1tree']) {
    $query .= "AND gedcom = '$tree' ";
}
$query .= "GROUP BY firstchar ";
$query .= "ORDER by firstchar";
$result = tng_query($query);
if ($result) {
    $initialchar = 1;

    while ($place = tng_fetch_assoc($result)) {
        if ($initialchar != 1) {
            $linkstr .= " ";
        }
        if ($place['firstchar'] != "") {
            $urlfirstchar = urlencode($place['firstchar']);
            $countstr = $text['placesstarting'] . ": " . $place['firstchar'] . " (" . number_format($place['placecount']) . " " . $text['totalnames'] . ")";
            $linkstr .= "<a href=\"$places_oneletter_url" . "firstchar=$urlfirstchar&amp;{$treestr}offset=$offsetorg&amp;psearch=$psearch\" class=\"snlink\" title=\"$countstr\">{$place['firstchar']}</a> ";
        }
        $initialchar++;
    }
    tng_free_result($result);
}

$query = "SELECT TRIM(SUBSTRING_INDEX(place, ', ', -$offset)) AS myplace, COUNT(place) AS placecount ";
$query .= "FROM $places_table ";
$query .= "WHERE TRIM(SUBSTRING_INDEX(place, ', ', -$offset)) != '' ";
if ($tree && !$tngconfig['places1tree']) {
    $query .= "AND gedcom = '$tree' ";
}
$query .= "GROUP BY myplace ";
$query .= "ORDER by placecount DESC ";
$query .= "LIMIT 30";
$result = tng_query($query);
$maxcount = 0;
if ($result) {
    $count = 1;
    $col = -1;
    while ($place = tng_fetch_assoc($result)) {
        $place2 = urlencode($place['myplace']);
        if ($place2 != "") {
            if (!$maxcount) {
                $maxcount = $place['placecount'];
            }
            $tally = $place['placecount'];
            $tally_fmt = number_format($tally);
            $thiswidth = floor($tally / $maxcount * 100);
            $query = "SELECT COUNT(place) AS placecount ";
            $query .= "FROM $places_table ";
            $query .= "WHERE place = '" . addslashes($place['myplace']) . "' ";
            if ($tree && !$tngconfig['places1tree']) {
                $query .= "AND gedcom = '$tree' ";
            }
            $result2 = tng_query($query);
            $countrow = tng_fetch_assoc($result2);
            $specificcount = $countrow['placecount'];
            tng_free_result($result2);

            $searchlink = $specificcount ? " <a href=\"$placesearch_url" . "{$treestr}psearch=$place2\"><img src=\"{$cms['tngpath']}img/tng_search_small.gif\" alt=\"\" width=\"9\" height=\"9\"></a>" : "";
            $name = $place['placecount'] > 1 || !$specificcount ? "<a href=\"$places_oneletter_url" . "offset=$offset&amp;{$treestr}psearch=$place2\">" . str_replace(["<", ">"], ["&lt;", "&gt;"], $place['myplace']) . "</a> ($tally_fmt)" : $place['myplace'];
            if (($count - 1) % $collen == 0) {
                $col++;
            }
            $chartstr = $col ? "" : "<td width=\"400\"><div style=\"width:{$thiswidth}%;\" class=\"bar rightround\"><a href=\"$places_oneletter_url" . "offset=$offset&amp;{$treestr}psearch=$place2\" title=\"{$place['myplace']} ($tally_fmt)\"></a></div></td>";
            $linkstr2col[$col] .= "<tr><td class=\"snlink\" align=\"right\">$count.</td><td>$name$searchlink</td>$chartstr</tr>\n";
            $count++;
        }
    }
    tng_free_result($result);
}
?>
    <div class="titlebox normal">
        <p class="subhead"><strong><?php echo $text['placesstarting']; ?></strong></p>
        <p class="firstchars"><?php echo $linkstr; ?></p>

        <?php
        $formstr = getFORM("places-oneletter", "get", "", "");
        echo $formstr;
        ?>
        <?php
        echo "{$text['placescont']}: <input type=\"text\" name=\"psearch\">\n";
        if ($tree && !$tngconfig['places1tree']) {
            echo "<input type=\"hidden\" name=\"tree\" value=\"$tree\">\n";
        }
        echo "<input type=\"hidden\" name=\"stretch\" value=\"1\">\n";
        echo "<input type=\"submit\" name=\"pgo\" value=\"{$text['go']}\">\n";
        ?>
        </form>

        <br><?php echo "<a href=\"$places_all_url" . "$treestr2\">{$text['showallplaces']}</a> ({$text['sortedalpha']}) &nbsp;|&nbsp; <a href=\"$heatmap_url{$treestr2}\" class=\"snlink\">{$text['heatmap']}</a>"; ?>
    </div>
    <br>
    <div class="titlebox">
        <table class="table-top30">
            <tr>
                <td colspan="5">
                    <p class="subhead"><strong><?php echo "{$text['top30places']} ({$text['totalplaces']}):"; ?></strong></p>
                </td>
            </tr>
            <tr>
                <?php
                for ($i = 0; $i < $cols; $i++) {
                    if ($i) {
                        echo "<td class=\"table-gutter\">&nbsp;</td>\n";
                    }
                    ?>
                    <td class="aligntop">
                        <table class="normal table-histogram">
                            <?php
                            echo $linkstr2col[$i];
                            ?>
                        </table>
                    </td>
                    <?php
                }
                ?>
            </tr>
            <tr>
                <td colspan="5">
                    <?php
                    $formstr = getFORM("places100", "get", "", "");
                    echo $formstr;
                    echo $text['showtop'];
                    echo " <input type=\"text\" name=\"topnum\" value=\"100\" size=\"4\" maxlength=\"4\"> {$text['byoccurrence']}\n";
                    if ($tree && !$tngconfig['places1tree']) {
                        echo "<input type=\"hidden\" name=\"tree\" value=\"$tree\">\n";
                    }
                    echo "<input type=\"submit\" value=\"{$text['go']}\"></form>\n";
                    ?>
                </td>
            </tr>

        </table>
    </div>
    <br>
<?php
tng_footer("");
?>
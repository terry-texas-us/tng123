<?php
$textpart = "places";
include "tng_begin.php";

if ($tree && !$tngconfig['places1tree']) {
    $treestr = "tree=$tree&amp;";
    $treestr2 = "tree=$tree";
    $treestr3 = "tree=$tree&";
    $logstring = "<a href=\"places-all.php?$treestr2\">{$text['allplaces']} ({$text['tree']}: $tree)</a>";
} else {
    $treestr = $treestr2 = $treestr3 = "";
    $logstring = "<a href='places-all.php'>{$text['allplaces']}</a>";
}
writelog($logstring);
preparebookmark($logstring);

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

tng_header($text['placelist'] . ": " . $text['allplaces'], $flags);
?>
    <a id="top"></a>
    <h2 class="header"><span class="headericon" id="places-hdr-icon"></span><?php echo $text['placelist'] . ": " . $text['allplaces']; ?></h2>
    <br class="clearleft">
<?php
if (!$tngconfig['places1tree']) {
    echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'places-all', 'method' => 'get', 'name' => 'form1', 'id' => 'form1']);
}

$offset = 1;

$linkstr = "";
$query = "SELECT DISTINCT UCASE(LEFT(TRIM(SUBSTRING_INDEX(place, ',', -$offset)), 1)) AS firstchar ";
$query .= "FROM $places_table ";
if ($tree && !$tngconfig['places1tree']) {
    $query .= "WHERE gedcom = '$tree' ";
}
$query .= "GROUP BY firstchar ";
$query .= "ORDER by firstchar";
$result = tng_query($query);
if ($result) {
    $initialchar = 1;

    while ($place = tng_fetch_assoc($result)) {
        if ($initialchar != 1) $linkstr .= " ";

        if ($place['firstchar'] != "" && $place['firstchar'] != "_") {
            $linkstr .= "<a href=\"#char$initialchar\" class='snlink rounded'>{$place['firstchar']}</a> ";
            $firstchars[$initialchar] = $place['firstchar'];
            $initialchar++;
        }
    }
    tng_free_result($result);
}
?>

    <div class="titlebox rounded-lg normal">
        <h3 class="subhead"><?php echo $text['placesstarting']; ?></h3>
        <p class="firstchars"><?php echo $linkstr; ?></p>

        <?php
        $formstr = getFORM("places-oneletter", "get", "", "");
        echo $formstr;
        ?>
        <?php
        echo "{$text['placescont']}: <input type='text' name=\"psearch\">\n";
        if ($tree && !$tngconfig['places1tree']) {
            echo "<input type='hidden' name=\"tree\" value='$tree'>\n";
        }
        echo "<input type='hidden' name=\"stretch\" value='1'>\n";
        echo "<input type='submit' name=\"pgo\" value=\"{$text['go']}\">\n";
        ?>
        </form>

        <br><?php echo "<a href=\"places.php?$treestr2\">{$text['mainplacepage']}</a> &nbsp;|&nbsp; <a href=\"heatmap.php?$treestr2\">{$text['heatmap']}</a>"; ?>
    </div>
    <br>

    <p class="smaller"><?php echo $text['showmatchingplaces']; ?></p>
<?php
for ($scount = 1; $scount < $initialchar; $scount++) {
    ?>
    <div class="titlebox rounded-lg">
    <?php
    $urlfirstchar = addslashes($firstchars[$scount]);
    if ($urlfirstchar) {
        echo "<p class='header'><a id=\"char$scount\"><strong>{$firstchars[$scount]}</strong></a></p>\n";
        ?>
        <table class="sntable">
            <tr>
                <td class="plcol align-top">
                    <?php
                    $query = "SELECT TRIM(SUBSTRING_INDEX(place, ',', -$offset)) AS myplace, COUNT(place) AS placecount, gedcom ";
                    $query .= "FROM $places_table ";
                    $query .= "WHERE TRIM(SUBSTRING_INDEX(place, ',', -$offset)) LIKE '$urlfirstchar%' ";
                    if ($tree && !$tngconfig['places1tree']) {
                        $query .= "AND gedcom = '$tree' ";
                    }
                    $query .= "GROUP BY myplace ";
                    $query .= "ORDER by myplace";
                    $result = tng_query($query);
                    $topnum = tng_num_rows($result);
                    if ($result) {
                        $snnum = 1;
                        if (!isset($numcols)) $numcols = 3;
                        $num_in_col = ceil($topnum / $numcols);
                        if ($numcols > 3) {
                            $numcols = 3;
                            $num_in_col = ceil($topnum / 3);
                        }

                        $num_in_col_ctr = 0;
                        while ($place = tng_fetch_assoc($result)) {
                            $place2 = urlencode($place['myplace']);
                            $commaOnEnd = false;
                            $poffset = $stretch ? "" : "offset=$offset&";
                            if (substr($place['wholeplace'], 0, 1) == ',' && trim(substr($place['wholeplace'], 1)) == $place['myplace']) {
                                $place3 = addslashes($place['wholeplace']);
                                $commaOnEnd = true;
                                $place2 = urlencode($place['wholeplace']);
                                $placetitle = $place['wholeplace'];
                            } else {
                                $place3 = addslashes($place['myplace']);
                                $placetitle = $place['myplace'];
                            }
                            $query = "SELECT COUNT(place) AS placecount ";
                            $query .= "FROM $places_table ";
                            $query .= "WHERE place = '$place3'";
                            if ($tree && !$tngconfig['places1tree']) {
                                $query .= " AND gedcom = '$tree'";
                            }
                            $result2 = tng_query($query);
                            $countrow = tng_fetch_assoc($result2);
                            $specificcount = $countrow['placecount'];
                            tng_free_result($result2);
                            $icon = buildSvgElement("img/search.svg", ["class" => "w-3 h-3 fill-current inline-block"]);
                            $searchlink = $specificcount ? " <a href='placesearch.php?{$treestr3}psearch=$place2' title=\"{$text['findplaces']}\">$icon</a>" : "";
                            if ($place['placecount'] > 1 || ($place['myplace'] != $place['wholeplace'] && !$commaOnEnd)) {
                                $name = "<a href=\"places-oneletter.php?" . $poffset;
                                if ($tree && !$tngconfig['places1tree']) {
                                    $name .= "tree={$place['gedcom']}&";
                                }
                                $name .= "psearch=$place2\">" . str_replace(["<", ">"], ["&lt;", "&gt;"], $place['myplace']) . "</a>";
                                echo "$snnum. $name ({$place['placecount']})$searchlink<br>\n";
                            } else {
                                echo "$snnum. $placetitle$searchlink<br>\n";
                            }
                            $snnum++;
                            $num_in_col_ctr++;
                            if ($num_in_col_ctr == $num_in_col) {
                                echo "</td>\n";
                                echo "<td>&nbsp;&nbsp;</td>\n";
                                echo "<td class='plcol align-top'>";
                                $num_in_col_ctr = 0;
                            }
                        }
                        tng_free_result($result);
                    }
                    ?>
                </td>
            </tr>
        </table>
        </div>

        <br><p class="normal"><a href="#top"><?php echo $text['backtotop']; ?></a></p><br>
        <?php
    }
}

tng_footer("");
?>
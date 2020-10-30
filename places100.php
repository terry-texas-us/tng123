<?php
$textpart = "places";
include "tng_begin.php";
require_once "./core/sql/extractWhereClause.php";

$topnum = preg_replace("/[^0-9]/", '', $topnum);

if ($tree && !$tngconfig['places1tree']) {
    $treestr = "tree=$tree&amp;";
    $treestr2 = "tree=$tree";
    $logstring = "<a href=\"places100.php?topnum=$topnum&amp;tree=$tree\">" . xmlcharacters($text['placelist'] . ": {$text['top']} $topnum ({$text['tree']}: $tree)") . "</a>";
} else {
    $treestr = $treestr2 = "";
    $logstring = "<a href=\"places100.php?topnum=$topnum\">" . xmlcharacters($text['placelist'] . ": {$text['top']} $topnum") . "</a>";
}

writelog($logstring);
preparebookmark($logstring);

tng_header($text['placelist'] . ": {$text['top']} $topnum", $flags);
?>
    <h2 class="header"><span class="headericon" id="places-hdr-icon"></span><?php echo $text['placelist'] . ": {$text['top']} $topnum"; ?></h2>
    <br class="clearleft">
<?php
if ($tree && !$tngconfig['places1tree']) {
    echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'places100', 'method' => 'get', 'name' => 'form1', 'id' => 'form1']);
}

echo getFORM("places100", "get", "", "");
?>
    <div class="titlebox rounded-lg">
        <?php echo $text['showtop']; ?>&nbsp;
        <input type="text" name="topnum" value="<?php echo $topnum; ?>" size="4" maxlength="4"> <?php echo $text['byoccurrence']; ?>&nbsp;
        <input type="submit" value="<?php echo $text['go']; ?>">
    </div>
<?php echo "</form>\n"; ?>
    <br>

<?php echo getFORM("places-oneletter", "get", "", ""); ?>
    <div class="titlebox rounded-lg">
        <?php
        echo "{$text['placescont']}: <input type='text' name=\"psearch\">\n";
        if ($tree && !$tngconfig['places1tree']) {
            echo "<input type='hidden' name=\"tree\" value='$tree'>\n";
        }
        echo "<input type='hidden' name=\"stretch\" value='1'>\n";
        echo "<input type='submit' name=\"pgo\" value=\"{$text['go']}\">\n";
        if (!$decodedfirstchar) {
            $decodedfirstchar = $text['top'] . " $topnum";
        }
        ?>
        <br><br><?php echo "<a href=\"places.php?{$treestr}\">{$text['mainplacepage']}</a> &nbsp;|&nbsp; <a href=\"places-all.php?{$treestr2}\">{$text['showallplaces']}</a>"; ?>
    </div>
<?php echo "</form>\n"; ?>
    <br>
    <div class="titlebox rounded-lg">
        <div>
            <h3 class="subhead"><?php echo "{$text['placelist']}: $decodedfirstchar, {$text['sortedalpha']} ({$text['numoccurrences']}):"; ?></h3>
            <p class="smaller"><?php echo $text['showmatchingplaces']; ?></p>
        </div>
        <table class="sntable">
            <tr>
                <td class="plcol align-top">
                    <?php
                    $offsetorg = $offset;
                    $offset = $offset ? $offset + 1 : 1;
                    $offsetplus = $offset + 1;

                    $topnum = $topnum ? $topnum : 100;
                    $query = "SELECT distinct TRIM(SUBSTRING_INDEX(place, ',', -$offset)) AS myplace, COUNT(place) AS placecount ";
                    $query .= "FROM $places_table ";
                    $restrictions = ["TRIM(SUBSTRING_INDEX(place, ',', -$offset)) != ''"];
                    if ($tree && !$tngconfig['places1tree']) {
                        array_push($restrictions, "gedcom = '$tree");
                    }
                    if ($psearch) {
                        array_push($restrictions, "TRIM(SUBSTRING_INDEX(place, ',', -$offset)) = '$psearch'");
                    }
                    $query .= "WHERE " . implode(" AND ", $restrictions) . " ";
                    $query .= "GROUP BY myplace ";
                    $query .= "ORDER by placecount DESC, myplace ";
                    $query .= "LIMIT $topnum";

                    $result = tng_query($query);
                    $topnum = tng_num_rows($result);
                    if ($result) {
                        $counter = 1;
                        if (!isset($numcols)) $numcols = 3;
                        $num_in_col = ceil($topnum / $numcols);
                        if ($numcols > 3) {
                            $numcols = 3;
                            $num_in_col = ceil($topnum / 3);
                        }

                        $num_in_col_ctr = 0;
                        while ($place = tng_fetch_assoc($result)) {
                            $place2 = urlencode($place['myplace']);
                            $query2 = "SELECT COUNT(place) AS placecount ";
                            $query2 .= "FROM $places_table ";
                            array_unshift($restrictions, "place = '" . addslashes($place['myplace']) . "'");
                            $query2 .= "WHERE " . implode(" AND ", $restrictions);
                            $result2 = tng_query($query2);
                            $countrow = tng_fetch_assoc($result2);
                            $specificcount = $countrow['placecount'];
                            tng_free_result($result2);
                            $icon = buildSvgElement("img/search.svg", ["class" => "w-3 h-3 fill-current inline-block"]);
                            $searchlink = $specificcount ? " <a href='placesearch.php?{$treestr}psearch=$place2'>$icon</a>" : "";
                            if ($place['placecount'] > 1 || !$specificcount) {
                                $name = "<a href=\"places-oneletter.php?offset=$offset&amp;{$treestr}psearch=$place2\">{$place['myplace']}</a>";
                                echo "$counter. $name ({$place['placecount']}) $searchlink<br>\n";
                            } else {
                                echo "$counter. {$place['myplace']} $searchlink<br>\n";
                            }
                            $counter++;
                            $num_in_col_ctr++;
                            if ($num_in_col_ctr == $num_in_col) {
                                echo "</td>\n";
                                echo "<td>&nbsp;&nbsp;</td>\n";
                                echo "<td class='align-top'>";
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
    <br>
<?php tng_footer(""); ?>
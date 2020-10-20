<?php

$textpart = "places";
include "tng_begin.php";

$psearch = cleanIt(trim($psearch));
$decodedfirstchar = $firstchar ? stripslashes(urldecode($firstchar)) : stripslashes($psearch);
$heatargs = $psearch ? "psearch=" : "firstchar=";
$heatargs .= $decodedfirstchar;
$stretchstr = isset($stretch) ? "&amp;stretch=$stretch" : "";
$offsetstr = isset($offset) ? "&amp;offset=$offset" : "";

if ($tree && !$tngconfig['places1tree']) {
    $treestr = "tree=$tree&amp;";
    $treestr2 = "tree=$tree";
    $treestr3 = "tree=$tree&";
    $logstring = "<a href=\"places-oneletter.php?firstchar=$firstchar&amp;psearch=$psearch&amp;tree=$tree$offsetstr$stretchstr\">{$text['placelist']}: $decodedfirstchar ({$text['tree']}: $tree)</a>";
} else {
    $treestr = $treestr2 = $treestr3 = "";
    $logstring = "<a href=\"places-oneletter.php?firstchar=$firstchar&amp;psearch=$psearch$offsetstr$stretchstr\">{$text['placelist']}: $decodedfirstchar</a>";
}

$offsetorg = $offset;
$offset = $offset ? $offset + 1 : 1;

//if doing a locality search, link directly to placesearch
if ($stretch) {
    $query = "SELECT DISTINCT place AS myplace, place AS wholeplace, COUNT(place) AS placecount, gedcom ";
    $places_oneletter_url = "placesearch.php?";
} else {
    $query = "SELECT DISTINCT TRIM(SUBSTRING_INDEX(place, ',', -$offset)) AS myplace, TRIM(place) AS wholeplace, COUNT(place) AS placecount, gedcom ";
    $places_oneletter_url = "places-oneletter.php?";
}
$query .= "FROM $places_table ";

$restrictions = [];
if ($tree && !$tngconfig['places1tree']) {
    array_push($restrictions, "gedcom = '$tree'");
}
if ($firstchar) {
    array_push($restrictions, "TRIM(SUBSTRING_INDEX(place, ',', -$offset)) LIKE '" . addslashes($firstchar) . "%'");
}
if ($psearch) {
    $psearchslashed = addslashes($psearch);
    array_push($restrictions, $offsetorg ? "TRIM(SUBSTRING_INDEX(place, ',', -$offsetorg)) = '$psearchslashed'" : "place LIKE '%$psearch%'");
}
if (!empty($restrictions)) {
    $query .= "WHERE " . implode(" AND ", $restrictions) . " ";
}
$query .= "GROUP BY myplace ";
$query .= "ORDER by myplace";

$result = tng_query($query);
if (tng_num_rows($result) == 1) {
    $row = tng_fetch_assoc($result);
    if ($row['myplace'] == $psearch) {
        header("Location: placesearch.php?{$treestr3}psearch=$psearch&oper=eq");
    } else {
        $result = tng_query($query);
    }
}

writelog($logstring);
preparebookmark($logstring);

$displaychar = $decodedfirstchar ? $decodedfirstchar : $text['all'];

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

tng_header($text['placelist'] . ": $displaychar", $flags);
?>
<h2 class="header"><span class="headericon" id="places-hdr-icon"></span><?php echo $text['placelist'] . ": $displaychar"; ?></h2>
<br class="clearleft">
<?php

$hiddenfields[] = ['name' => 'firstchar', 'value' => $firstchar];
$hiddenfields[] = ['name' => 'psearch', 'value' => $psearch];
$hiddenfields[] = ['name' => 'offset', 'value' => $offsetorg];
if ($tree && !$tngconfig['places1tree']) {
    echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'places-oneletter', 'method' => 'get', 'name' => 'form1', 'id' => 'form1', 'hidden' => $hiddenfields]);
}

$formstr = getFORM("places-oneletter", "get", "", "");
echo $formstr;
?>
<div class="titlebox rounded-lg">
    <?php
    echo "{$text['placescont']}: <input type='text' name=\"psearch\">\n";
    if ($tree && !$tngconfig['places1tree']) {
        echo "<input type='hidden' name=\"tree\" value='$tree'>\n";
    }
    echo "<input type='hidden' name=\"stretch\" value='1'>\n";
    echo "<input type='submit' name=\"pgo\" value=\"{$text['go']}\">\n";
    ?>
    <br><br><?php echo "<a href=\"places.php?{$treestr2}\">{$text['mainplacepage']}</a> &nbsp;|&nbsp; <a href=\"places-all.php?{$treestr2}\">{$text['showallplaces']}</a>"; ?>
</div>
</form>

<br>
<div class="titlebox rounded-lg">
    <div>
        <h3 class="subhead">
            <?php
            echo "{$text['placelist']}: $decodedfirstchar, {$text['sortedalpha']}";
            if (isset($_GET['offset'])) echo " ({$text['numoccurrences']}):";
            ?>
        </h3>
        <p class="smaller"><?php echo $text['showmatchingplaces']; ?> <a href="<?php echo "heatmap.php?" . $treestr . $heatargs; ?>" class="snlink rounded"><?php echo $text['heatmap']; ?></a></p>
    </div>
    <table class="sntable">
        <tr>
            <td class="plcol align-top">
                <?php
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
                        $olplace = $place2 = urlencode($place['myplace']);
                        if ($place2) {
                            $commaOnEnd = false;
                            $poffset = $stretch ? "" : "offset=$offset&amp;";
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
                            $searchlink = $specificcount ? " <a href='placesearch.php?{$treestr3}psearch=$place2' title=\"{$text['findplaces']}\"><img src='img/tng_search_small.gif' alt=\"{$text['findplaces']}\" class='inline-block'></a>" : "";
                            if ($place['placecount'] > 1 || ($place['myplace'] != $place['wholeplace'] && !$commaOnEnd)) {
                                $name = "<a href=\"$places_oneletter_url" . $poffset;
                                if ($tree && !$tngconfig['places1tree']) {
                                    $name .= "tree={$place['gedcom']}&amp;";
                                }
                                $name .= "psearch=$olplace\">";

                                $name .= $place['myplace'];
                                $name .= "</a>";

                                echo "$snnum. $name ({$place['placecount']})$searchlink<br>\n";
                            } else {
                                echo "$snnum. $placetitle$searchlink<br>\n";
                            }
                            $snnum++;
                            $num_in_col_ctr++;
                            if ($num_in_col_ctr == $num_in_col) {
                                echo "</td>\n";
                                echo "<td class='table-dblgutter'>&nbsp;&nbsp;</td>\n";
                                echo "<td class='plcol align-top'>";
                                $num_in_col_ctr = 0;
                            }
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
<?php
tng_footer("");
?>

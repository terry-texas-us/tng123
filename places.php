<?php
$textpart = "places";
include "tng_begin.php";

if ($tree && !$tngconfig['places1tree']) {
    $treestr = "tree=$tree&amp;";
    $treestr2 = "tree=$tree";
    $logstring = "<a href=\"places.php?offset=$offset&amp;$treestr2\">" . _('Place List') . " (" . _('Tree') . ": $tree)</a>";
} else {
    $treestr = $treestr2 = "";
    $logstring = "<a href='places.php'>" . _('Place List') . "</a>";
}
_('Top xxx largest localities') = preg_replace("/xxx/", "30", _('Top xxx largest localities'));

writelog($logstring);
preparebookmark($logstring);

tng_header(_('Place List'), $flags);
?>
    <h2 class="header"><span class="headericon" id="places-hdr-icon"></span><?php echo _('Place List'); ?></h2>
    <br class="clearleft">
<?php
if (!$tngconfig['places1tree']) {
    echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'places', 'method' => 'get', 'name' => 'form1', 'id' => 'form1']);
}
$linkstr = "";
$linkstr2col1 = "";
$linkstr2col2 = "";
$linkstr3col1 = "";
$linkstr3col2 = "";
$collen = 10;
$cols = 3;
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
        if ($initialchar != 1) $linkstr .= " ";

        if ($place['firstchar'] != "") {
            $urlfirstchar = urlencode($place['firstchar']);
            $countstr = _('Show largest localities starting with') . ": " . $place['firstchar'] . " (" . number_format($place['placecount']) . " " . _('total individuals') . ")";
            $linkstr .= "<a href=\"places-oneletter.php?firstchar=$urlfirstchar&amp;{$treestr}offset=$offsetorg&amp;psearch=$psearch\" class='snlink rounded' title=\"$countstr\">{$place['firstchar']}</a> ";
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
            if (!$maxcount) $maxcount = $place['placecount'];

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
            $icon = buildSvgElement("img/search.svg", ["class" => "w-3 h-3 fill-current inline-block"]);
            $searchlink = $specificcount ? " <a href='placesearch.php?{$treestr}psearch=$place2'>$icon</a>" : "";
            $name = $place['placecount'] > 1 || !$specificcount ? "<a href=\"places-oneletter.php?offset=$offset&amp;{$treestr}psearch=$place2\">" . str_replace(["<", ">"], ["&lt;", "&gt;"], $place['myplace']) . "</a> ($tally_fmt)" : $place['myplace'];
            if (($count - 1) % $collen == 0) $col++;
            $chartstr = $col ? "" : "<td width='400'><div style='width: {$thiswidth}%;' class='bar rounded-r'><a href='places-oneletter.php?offset=$offset&amp;{$treestr}psearch=$place2' title=\"{$place['myplace']} ($tally_fmt)\"></a></div></td>";
            $linkstr2col[$col] .= "<tr>";
            $linkstr2col[$col] .= "<td class='snlink rounded' align='right'>$count.</td>";
            $linkstr2col[$col] .= "<td>$name$searchlink</td>";
            $linkstr2col[$col] .= "$chartstr";
            $linkstr2col[$col] .= "</tr>\n";
            $count++;
        }
    }
    tng_free_result($result);
}
?>
    <div class="titlebox rounded-lg normal">
        <h3 class="subhead"><?php echo _('Show largest localities starting with'); ?></h3>
        <p class="firstchars"><?php echo $linkstr; ?></p>

        <?php
        $formstr = getFORM("places-oneletter", "get", "", "");
        echo $formstr;
        ?>
        <?php
        echo "" . _('Show all places containing') . ": <input type='text' name=\"psearch\">\n";
        if ($tree && !$tngconfig['places1tree']) {
            echo "<input type='hidden' name=\"tree\" value='$tree'>\n";
        }
        echo "<input type='hidden' name=\"stretch\" value='1'>\n";
        echo "<input type='submit' name=\"pgo\" value=\"" . _('Go') . "\">\n";
        ?>
        </form>

        <br><?php echo "<a href=\"places-all.php?$treestr2\">" . _('Show all largest localities') . "</a> (" . _('sorted alphabetically') . ") &nbsp;|&nbsp; <a href=\"heatmap.php?$treestr2\" class='snlink rounded'>" . _('Heat Map') . "</a>"; ?>
    </div>
    <br>
    <div class="titlebox rounded-lg">
        <table class="table-top30">
            <tr>
                <td colspan="5">
                    <h3 class="subhead"><?php echo "" . _('Top xxx largest localities') . " (" . _('total places') . "):"; ?></h3>
                </td>
            </tr>
            <tr>
                <?php
                for ($i = 0; $i < $cols; $i++) {
                    if ($i) echo "<td class=\"table-gutter\">&nbsp;</td>\n";

                    ?>
                    <td class="align-top">
                        <table class="normal table-histogram">
                            <?php echo $linkstr2col[$i]; ?>
                        </table>
                    </td>
                <?php } ?>
            </tr>
            <tr>
                <td colspan="5">
                    <?php
                    $formstr = getFORM("places100", "get", "", "");
                    echo $formstr;
                    echo _('Show top');
                    echo " <input type='text' name=\"topnum\" value=\"100\" size='4' maxlength='4'> " . _('ordered by occurrence') . "\n";
                    if ($tree && !$tngconfig['places1tree']) {
                        echo "<input type='hidden' name=\"tree\" value='$tree'>\n";
                    }
                    echo "<input type='submit' value=\"" . _('Go') . "\"></form>\n";
                    ?>
                </td>
            </tr>

        </table>
    </div>
    <br>
<?php
tng_footer("");
?>
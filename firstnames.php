<?php

$textpart = "surnames";
include "tng_begin.php";
require_once "./core/html/getFormStartTag.php";
require_once "./core/sql/extractWhereClause.php";

$treestr = $tree ? " (" . _('Tree') . ": $tree)" : "";
$logstring = "<a href=\"firstnames.php?tree=$tree\">" . xmlcharacters(_('First Name List') . $treestr) . "</a>";
writelog($logstring);
preparebookmark($logstring);

tng_header(_('First Name List'), $flags);
?>
    <h2 class="header"><span class="headericon" id="surnames-hdr-icon"></span><?php echo _('First Name List'); ?></h2>
    <br class="clearleft">
<?php
echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'firstnames', 'method' => 'get', 'name' => 'form1', 'id' => 'form1']);
$linkstr = "";
$linkstr2col1 = "";
$linkstr2col2 = "";
$linkstr3col1 = "";
$linkstr3col2 = "";
$collen = 25;
$cols = 2;
$grtotal = 50;
define("PIE_TOTAL", 10);
$nofirstname = urlencode(_('[no first name]'));
$top30text = preg_replace("/xxx/", $grtotal, _('Top xxx first names'));
$treestr = $orgtree ? "&amp;tree=$tree" : "";
$livingPrivateRestrictions = getLivingPrivateRestrictions($people_table, false, false);
$query = "SELECT UCASE(LEFT(firstname, 1)) AS firstchar, UCASE(LEFT(firstname, 1)) AS binfirstchar, count(UCASE(LEFT(firstname, 1))) AS lncount ";
$query .= "FROM $people_table ";
if ($tree) $query .= "WHERE gedcom = '$tree' ";

if ($livingPrivateRestrictions) {
    $query .= $tree ? "AND $livingPrivateRestrictions " : "WHERE $livingPrivateRestrictions ";
}
$query .= "GROUP BY binfirstchar ";
$query .= "ORDER by binfirstchar";
$result = tng_query($query);
if ($result) {
    $initialchar = 1;

    while ($firstname = tng_fetch_assoc($result)) {
        if ($initialchar != 1) $linkstr .= " ";

        if ($session_charset == "UTF-8" && function_exists('mb_substr')) {
            $firstchar = mb_substr($firstname['firstchar'], 0, 1, 'UTF-8');
        } else {
            $firstchar = substr($firstname['firstchar'], 0, 1);
        }
        $firstchar = strtoupper($firstchar);
        if ($firstchar == "") {
            $linkstr .= "<a href=\"search.php?myfirstname=$nofirstname&amp;fnqualify=equals&amp;mybool=AND$treestr\" class='snlink rounded'>" . _('[no first name]') . "</a> ";
        } else {
            $urlfirstchar = $firstchar;
            $countstr = _('Show first names starting with') . ": " . $firstchar . " (" . number_format($firstname['lncount']) . " " . _('total individuals') . ")";
            $linkstr .= "<a href=\"firstnames-oneletter.php?firstchar=$urlfirstchar$treestr\" class='snlink rounded' title=\"$countstr\">{$firstchar}</a>";
        }
        $initialchar++;
    }
    tng_free_result($result);
}

$query = "SELECT UCASE(SUBSTRING_INDEX(firstname, ' ', 1 )) AS firstname, SUBSTRING_INDEX(firstname, ' ', 1) AS lowername, count(UCASE(SUBSTRING_INDEX(firstname, ' ', 1))) AS lncount ";
$query .= "FROM $people_table ";
if ($tree) $query .= "WHERE gedcom = '$tree' ";

if ($livingPrivateRestrictions) {
    $query .= $tree ? "AND $livingPrivateRestrictions " : "WHERE $livingPrivateRestrictions ";
}
$query .= $tree || $livingPrivateRestrictions ? "AND firstname != '' " : "WHERE firstname != '' ";

$query .= "GROUP BY lowername ";
$query .= "ORDER by lncount DESC, firstname ";
$query .= "LIMIT $grtotal";
$result = tng_query($query);
$maxcount = 0;
$names = [];
$counts = [];
if ($result) {
    $count = 1;
    $col = -1;
    while ($firstname = tng_fetch_assoc($result)) {
        $firstname2 = urlencode($firstname['firstname']);
        if (!$maxcount) $maxcount = $firstname['lncount'];

        $tally = $firstname['lncount'];
        $tally_fmt = number_format($tally);
        $names[$count - 1] = $firstname['lowername'];
        $counts[$count - 1] = $tally;
        $thiswidth = floor($tally / $maxcount * 100);
        if (($count - 1) % $collen == 0) $col++;
        $linkstr2col[$col] .= "<tr>";
        $linkstr2col[$col] .= "<td class='snlink rounded'>$count.</td>";
        $linkstr2col[$col] .= "<td class='whitespace-no-wrap'><a href=\"search.php?myfirstname=$firstname2&amp;fnqualify=startswith&amp;mybool=AND$treestr\">{$firstname['lowername']}</a> ($tally_fmt)</td>";
        if (!$col) {
            $linkstr2col[$col] .= "<td class='bar-holder'>";
            $linkstr2col[$col] .= "<div style='width: {$thiswidth}%;' class='bar rounded-r' title=\"{$firstname['lowername']} ($tally_fmt)\">";
            $linkstr2col[$col] .= "</div>";
            $linkstr2col[$col] .= "</td>";
        }
        $linkstr2col[$col] .= "</tr>";
        $count++;
    }
    tng_free_result($result);
}
?>
    <div class="titlebox rounded-lg normal">
        <h3 class="subhead"><?php echo _('Show first names starting with'); ?></h3>
        <p class="firstchars"><?php echo $linkstr; ?></p>
        <br><?php echo "<a href=\"firstnames-all.php?tree=$tree\">" . _('Show all first names') . "</a> (" . _('sorted alphabetically') . ")"; ?>
    </div>
    <br>
    <div class="titlebox rounded-lg">
        <div style="display:inline-block; margin-right:50px;">
            <table class="table-top30">
                <tr>
                    <td colspan="5">
                        <h3 class="subhead"><?php echo "{$top30text} (" . _('total individuals') . "):"; ?></h3>
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
                        $top20text = preg_replace("/xxx/", PIE_TOTAL, _('Top xxx first names'));
                        $justtop = preg_replace("/xxx/", PIE_TOTAL, _('Just the top xxx'));
                        echo getFormStartTag("firstnames100", "get");
                        echo "<span>" . _('Show top') . "</span>";
                        ?>
                        <input type="text" name="topnum" value="100" size="5" maxlength="5">
                        <span> <?php echo _('ordered by occurrence'); ?></span>
                        <input type="hidden" name="tree" value="<?php echo $tree; ?>">
                        <input type="submit" value="<?php echo _('Go'); ?>">
                        <?php echo "</form>\n"; ?>
                    </td>
                </tr>
            </table>
            <br><br>
        </div>
        <div id="charts" style="display:inline-block; width:400px; vertical-align:top;text-align:center;">
            <h3 class="subhead"><?php echo "{$top20text}<br>" . _('(among all names)') . ""; ?></h3>
            <div id="whole_chart"></div>
            <br><br>
            <h3 class="subhead"><?php echo $justtop; ?></h3>
            <div id="focus_chart"></div>
        </div>
        <?php
        $query2 = "SELECT count(*) AS total_names FROM $people_table " . extractWhereClause($query, ["GROUP BY"]);
        $result = tng_query($query2);
        $row = tng_fetch_assoc($result);
        $total_names = $row['total_names'];
        tng_free_result($result);
        ?>
    </div>
    <br>
    <link href="css/c3.css" rel="stylesheet">
    <script src="js/d3.min.js"></script>
    <script src="js/c3.min.js"></script>
    <script>
        let whole_chart = c3.generate({
            bindto: '#whole_chart',
            data: {
                columns: [
                    <?php
                    $names_total = 0;
                    for ($i = 0; $i < PIE_TOTAL; $i++) {
                        $counter = $i + 1;
                        echo "['data{$counter}', {$counts[$i]}], ";
                        $names_total += $counts[$i];
                    }
                    $counter += 1;
                    $remaining = $total_names - $names_total;
                    echo "['data{$counter}', $remaining]";
                    ?>
                ],
                type: 'pie',
                names: {
                    <?php
                    for ($i = 0; $i < PIE_TOTAL; $i++) {
                        $counter = $i + 1;
                        $cfmt = number_format($counts[$i]);
                        echo "data{$counter}: \"{$names[$i]} ({$cfmt})\", ";
                    }
                    $counter += 1;
                    echo "data{$counter}: \"" . _('All others') . " (" . number_format($remaining) . ")\"";
                    ?>
                },
                colors: {
                    data<?php echo $counter; ?>: '#ccc'
                }
            }
        });
        let focus_chart = c3.generate({
            bindto: '#focus_chart',
            data: {
                columns: [
                    <?php
                    $names_total = 0;
                    for ($i = 0; $i < PIE_TOTAL; $i++) {
                        $counter = $i + 1;
                        echo "['data{$counter}', {$counts[$i]}]";
                        if ($counter < $grtotal) echo ", ";

                    }
                    ?>
                ],
                type: 'pie',
                names: {
                    <?php
                    for ($i = 0; $i < PIE_TOTAL; $i++) {
                        $counter = $i + 1;
                        $cfmt = number_format($counts[$i]);
                        echo "data{$counter}: \"{$names[$i]} ({$cfmt})\"";
                        if ($counter < $grtotal) echo ", ";

                    }
                    ?>
                }
            }
        });
    </script>
<?php tng_footer(""); ?>
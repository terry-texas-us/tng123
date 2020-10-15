<?php
$textpart = "headstones";
include "tng_begin.php";

$query = "SELECT * FROM $cemeteries_table ORDER BY country, state, county, city, cemname";
$cemresult = tng_query($query);
$numcems = $tngconfig['cemrows'] ? $tngconfig['cemrows'] : max(floor(tng_num_rows($cemresult) / 2), 10);

$treestr = $tree ? " ({$text['tree']}: $tree)" : "";
$wherestr = ($tree) ? "AND $medialinks_table.gedcom = '$tree'" : "";

$query = "SELECT $medialinks_table.personID AS personID FROM $medialinks_table, $media_table WHERE $media_table.mediaID = $medialinks_table.mediaID AND mediatypeID=\"headstones\" AND cemeteryID = \"\" $wherestr";
$hsresult = tng_query($query);
$numhs = tng_num_rows($hsresult);
tng_free_result($hsresult);

$logstring = "<a href=\"cemeteries.php?tree=$tree\">{$text['cemeteriesheadstones']}$treestr</a>";
writelog($logstring);
preparebookmark($logstring);

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

tng_header($text['cemeteriesheadstones'], $flags);
?>

<script>
    const collapsemsg = "<?php echo $text['collapse']; ?>";
    const expandmsg = "<?php echo $text['expand']; ?>";

    function toggleSection(key) {

        let sectionSelection = jQuery('#' + key);
        if (sectionSelection.css('display') === 'none') {
            sectionSelection.fadeIn(200);
            swap("plusminus" + key, "minus");
        } else {
            sectionSelection.fadeOut(200);
            swap("plusminus" + key, "plus");
        }
        return false;
    }

    plus = new Image;
    plus.src = "img/tng_expand.gif";
    minus = new Image;
    minus.src = "img/tng_collapse.gif";

    function swap(x, y) {
        jQuery('#' + x).attr('title', y === "minus" ? collapsemsg : expandmsg);
        document.images[x].src = eval(y + '.src');
    }
</script>

<h2 class="header"><span class="headericon" id="cemeteries-hdr-icon"></span><?php echo $text['cemeteriesheadstones']; ?></h2>
<br style="clear: both;">
<?php
echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'cemeteries', 'method' => 'get', 'name' => 'form1', 'id' => 'form1']);

define("DUMMYPLACE", "@@@@@@"); // sincerely hope there's not a place called this anywhere in the world
define("NUMCOLS", 2);           //set as number of columns-1
define("DEFAULT_COLUMN_LENGTH", $numcems);
$numrows = tng_num_rows($cemresult);

$colsize = DEFAULT_COLUMN_LENGTH;
$lastcountry = DUMMYPLACE;
$divctr = $linectr = $colctr = $i = 0;

echo "<div id=\"cemwrapper\">\n";
echo "<p>&nbsp;&nbsp;<a href=\"browsemedia.php?mediatypeID=headstones\" class='snlink'>&raquo; {$text['showallhsr']}</a></p>\n";
echo "<div id=\"cemcontainer\">\n";
echo "<div id=\"col$colctr\">\n";

$cemetery = tng_fetch_assoc($cemresult);
$orphan = false;
$hiding = false;
while ($i < $numrows) {
    if ($cemetery['country'] == $lastcountry) {
        if ($cemetery['state'] == $laststate) {
            if ($cemetery['county'] == $lastcounty) {
                $lastcity = DUMMYPLACE;
                $cityctr = 0;
                while (($i < $numrows) && ($cemetery['county'] == $lastcounty) && ($cemetery['state'] == $laststate) && ($cemetery['country'] == $lastcountry)) { // display all cemeteries in the current county
                    if ($cemetery['city'] != $lastcity) {
                        //end last city if $lastcity != dummy
                        if ($lastcity != DUMMYPLACE) echo "</div>\n";


                        //start a new city
                        $lastcity = $cemetery['city'];
                        $divctr++;
                        if (!$hiding) $linectr++;

                        $divname = "city$divctr";
                        if ($cemetery['city'] || !$tngconfig['cemblanks']) {
                            $txt = $cemetery['city'] ? @htmlspecialchars($cemetery['city'], ENT_QUOTES, $session_charset) : $text['nocity'];
                            echo "<div class=\"pad3\"><img src=\"" . "img/tng_expand.gif\" class=\"expandicon\" title='{$text['expand']}' id='plusminus$divname' onclick=\"return toggleSection('$divname');\" alt=\"\">\n<a href=\"headstones.php?country=" . urlencode($cemetery['country']) . "&amp;state=" . urlencode($cemetery['state']) . "&amp;county=" . urlencode($cemetery['county']) . "&amp;city=" . urlencode($cemetery['city']) . "&amp;tree=$tree\">$txt</a></div>\n";
                            echo "<div id=\"$divname\" class=\"cemblock\" style='display: none;'>\n";
                        } else {
                            echo "<div id=\"$divname\">\n";
                        }
                    }
                    $txt = $cemetery['cemname'] ? $cemetery['cemname'] : $text['nocemname'];
                    $txt = @htmlspecialchars($txt, ENT_QUOTES, $session_charset);
                    echo "- <a href=\"showmap.php?cemeteryID={$cemetery['cemeteryID']}&amp;tree=$tree\">$txt</a><br>\n";
                    $cemetery = tng_fetch_assoc($cemresult);
                    $i++;
                }
                if ($lastcity != DUMMYPLACE) echo "</div>\n";

                echo "</div>\n";                    // displayed all cemeteries in the county

            } else {                                // display the county
                $divname = "county$divctr";
                $divctr++;
                $lastcounty = $cemetery['county'];
                if ($cemetery['county'] || !$tngconfig['cemblanks']) {
                    $linectr++;
                    $txt = $cemetery['county'] ? @htmlspecialchars($cemetery['county'], ENT_QUOTES, $session_charset) : $text['nocounty'];
                    echo "<div class=\"pad3\"><img src=\"" . "img/tng_expand.gif\" class=\"expandicon\" title='{$text['expand']}' id='plusminus$divname' onclick=\"return toggleSection('$divname');\" alt=\"\">\n<a href=\"headstones.php?country=" . urlencode($cemetery['country']) . "&amp;state=" . urlencode($cemetery['state']) . "&amp;county=" . urlencode($cemetery['county']) . "&amp;tree=$tree\">$txt</a></div>\n";
                    echo "<div id=\"$divname\" class=\"cemblock\" style='display: none;'>\n";
                    $hiding = true;
                } else {
                    echo "<div id=\"$divname\">\n";
                    $hiding = false;
                }
            }
        } else {                                // display the State
            if (($colctr < NUMCOLS) && ($linectr > $colsize) && !$orphan) {    // end of a column
                $linectr = 0;
                $colctr++;
                echo "</div>\n<div id=\"col$colctr\">\n<em>{$cemetery['country']} {$text['cont']}</em>\n";
            }
            $orphan = false;

            $laststate = $cemetery['state'];
            $lastcounty = DUMMYPLACE;
            $hiding = false;
            $txt = $cemetery['state'] ? @htmlspecialchars($cemetery['state'], ENT_QUOTES, $session_charset) : $text['nostate'];
            if ($cemetery['state'] || !$tngconfig['cemblanks']) {
                $linectr += 2;        //Add extra line to allow for the <br> at the end
                echo "<br><strong><a href=\"headstones.php?country=" . urlencode($cemetery['country']) . "&amp;state=" . urlencode($cemetery['state']) . "&amp;tree=$tree\">$txt</a></strong><br>\n";
            } else {
                $linectr++;
                echo "<br>\n";
            }
        }
    } else {                                    // display the Country
        if (($colctr < NUMCOLS) && ($linectr > $colsize)) {    // end of a column
            $linectr = 0;
            $colctr++;
            echo "</div>\n<div id=\"col$colctr\">\n";
        }
        $lastcountry = $cemetery['country'];
        $laststate = DUMMYPLACE;
        $lastcounty = DUMMYPLACE;
        $hiding = false;
        if ($linectr) echo "<br>";

        $linectr++;     //Add extra line to allow for the <br> at the end
        $txt = $cemetery['country'] ? @htmlspecialchars($cemetery['country'], ENT_QUOTES, $session_charset) : $text['nocountry'];
        echo "<div class='databack cemcountry subhead rounded'><strong><a href=\"headstones.php?country=" . urlencode($cemetery['country']) . "&amp;tree=$tree\">$txt</a></strong></div>\n";
        $orphan = true;
    }
}
tng_free_result($cemresult);

if ($numhs) {
    echo "<br><div class='databack cemcountry subhead rounded'><strong><a href=\"headstones.php?tree=$tree\">{$text['nocemetery']}</a></strong></div>\n";
}

echo "</div>\n";    //colx
echo "</div>\n";    //container
echo "</div>\n";
echo "<br style=\"clear: both;\">";    //wrapper

tng_footer("");
?>

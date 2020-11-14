<?php
$textpart = "search";
include "tng_begin.php";

$query = "SELECT gedcom, treename FROM $trees_table ORDER BY treename";
$result = tng_query($query);
$numtrees = tng_num_rows($result);

if ($_SESSION['tng_search_ftree']) {
    $tree = $_SESSION['tng_search_ftree'];
}
$flnqualify = $_SESSION['tng_search_flnqualify'];
$myflastname = $_SESSION['tng_search_flastname'];
$ffnqualify = $_SESSION['tng_search_ffnqualify'];
$myffirstname = $_SESSION['tng_search_ffirstname'];
$mlnqualify = $_SESSION['tng_search_mlnqualify'];
$mymlastname = $_SESSION['tng_search_mlastname'];
$mfnqualify = $_SESSION['tng_search_mfnqualify'];
$mymfirstname = $_SESSION['tng_search_mfirstname'];
$fidqualify = $_SESSION['tng_search_fidqualify'];
$myfamilyid = $_SESSION['tng_search_familyid'];
$mpqualify = $_SESSION['tng_search_mpqualify'];
$mymarrplace = $_SESSION['tng_search_marrplace'];
$myqualify = $_SESSION['tng_search_myqualify'];
$mymarryear = $_SESSION['tng_search_marryear'];
$dvpqualify = $_SESSION['tng_search_dvpqualify'];
$mydivplace = $_SESSION['tng_search_divhplace'];
$dvyqualify = $_SESSION['tng_search_dvyqualify'];
$mydivyear = $_SESSION['tng_search_divyear'];
$mymarrtype = $_SESSION['tng_search_marrtype'];
$mybool = $_SESSION['tng_search_fbool'];
$nr = $_SESSION['tng_nr'];

$dontdo = ["MARR", "DIV"];

tng_header(_('Search Families'), $flags);
?>
    <script>
        //<![CDATA[
        function resetValues() {
            <?php if ((!$requirelogin || !$treerestrict || !$assignedtree) && $numtrees > 1) {
            echo "document.famsearch.tree.selectedIndex = 0;";
        } ?>
            document.famsearch.reset();

            document.famsearch.flnqualify.selectedIndex = 0;
            document.famsearch.ffnqualify.selectedIndex = 0;
            document.famsearch.mlnqualify.selectedIndex = 0;
            document.famsearch.mfnqualify.selectedIndex = 0;
            document.famsearch.mpqualify.selectedIndex = 0;
            document.famsearch.myqualify.selectedIndex = 0;
            document.famsearch.dvpqualify.selectedIndex = 0;
            document.famsearch.dvyqualify.selectedIndex = 0;
            document.famsearch.mybool.selectedIndex = 0;
            document.famsearch.fidqualify.selectedIndex = 0;

            document.famsearch.myflastname.value = "";
            document.famsearch.myffirstname.value = "";
            document.famsearch.mymlastname.value = "";
            document.famsearch.mymfirstname.value = "";
            document.famsearch.mymarrplace.value = "";
            document.famsearch.mymarryear.value = "";
            document.famsearch.mydivplace.value = "";
            document.famsearch.mydivyear.value = "";
            document.famsearch.myfamilyid.value = "";
            document.famsearch.mymarrtype.value = "";
            $('errormsg').style.display = "none";
        }

        function toggleSection(flag) {
            if (flag) {
                jQuery('#otherevents').fadeIn(200);
                jQuery('#contract').show();
                jQuery('#expand').hide();
            } else {
                jQuery('#otherevents').fadeOut(200);
                jQuery('#expand').show();
                jQuery('#contract').hide();
            }
            return false;
        }

        function makeURL() {
            var URL;
            var thisform = document.famsearch;
            var thisfield;
            var found = 0;

            URL = "mybool=" + thisform.mybool[thisform.mybool.selectedIndex].value;
            URL = URL + "&nr=" + thisform.nr[thisform.nr.selectedIndex].value;
            <?php if ((!$requirelogin || !$treerestrict || !$assignedtree) && $numtrees > 1) { ?>
            URL = URL + "&tree=" + thisform.tree[thisform.tree.selectedIndex].value;
            <?php
            }
            $qualifiers = ["fln", "ffn", "mln", "mfn", "fid", "mp", "my", "dvp", "dvy", "mt"];
            $criteria = ["flastname", "ffirstname", "mlastname", "mfirstname", "familyid", "marrplace", "marryear", "divplace", "divyear", "marrtype"];

            $qcount = 0;
            $found = 0;
            foreach( $criteria as $criterion ) {
            ?>
            if (thisform.my<?php echo $criterion; ?>.value != "" || thisform.<?php echo $qualifiers[$qcount]; ?>qualify.value == "exists" || thisform.<?php echo $qualifiers[$qcount]; ?>qualify.value == "dnexist") {
                URL = URL + "&my<?php echo $criterion; ?>=" + thisform.my<?php echo $criterion; ?>.value;
                URL = URL + "&<?php echo $qualifiers[$qcount]; ?>qualify=" + thisform.<?php echo $qualifiers[$qcount]; ?>qualify[thisform.<?php echo $qualifiers[$qcount]; ?>qualify.selectedIndex].value;
                found++;
            }
            <?php
            $qcount++;
            }

            //get eventtypeIDs from $eventtypes_table
            $query = "SELECT eventtypeID, tag FROM $eventtypes_table WHERE keep='1' AND type=\"F\"";
            $etresult = tng_query($query);
            while( $row = tng_fetch_assoc($etresult) ) {
            if( !in_array($row['tag'], $dontdo) ) {
            ?>
            if (thisform.cef<?php echo $row['eventtypeID']; ?>.value != "" || thisform.cfq<?php echo $row['eventtypeID']; ?>.value == "exists" || thisform.cfq<?php echo $row['eventtypeID']; ?>.value == "dnexist") {
                URL = URL + "&cef<?php echo $row['eventtypeID']; ?>=" + thisform.cef<?php echo $row['eventtypeID']; ?>.value;
                URL = URL + "&cfq<?php echo $row['eventtypeID']; ?>=" + thisform.cfq<?php echo $row['eventtypeID']; ?>[thisform.cfq<?php echo $row['eventtypeID']; ?>.selectedIndex].value;
            }
            if (thisform.cep<?php echo $row['eventtypeID']; ?>.value != "" || thisform.cpq<?php echo $row['eventtypeID']; ?>.value == "exists" || thisform.cpq<?php echo $row['eventtypeID']; ?>.value == "dnexist") {
                URL = URL + "&cep<?php echo $row['eventtypeID']; ?>=" + thisform.cep<?php echo $row['eventtypeID']; ?>.value;
                URL = URL + "&cpq<?php echo $row['eventtypeID']; ?>=" + thisform.cpq<?php echo $row['eventtypeID']; ?>[thisform.cpq<?php echo $row['eventtypeID']; ?>.selectedIndex].value;
            }
            if (thisform.cey<?php echo $row['eventtypeID']; ?>.value != "" || thisform.cyq<?php echo $row['eventtypeID']; ?>.value == "exists" || thisform.cyq<?php echo $row['eventtypeID']; ?>.value == "dnexist") {
                URL = URL + "&cey<?php echo $row['eventtypeID']; ?>=" + thisform.cey<?php echo $row['eventtypeID']; ?>.value;
                URL = URL + "&cyq<?php echo $row['eventtypeID']; ?>=" + thisform.cyq<?php echo $row['eventtypeID']; ?>[thisform.cyq<?php echo $row['eventtypeID']; ?>.selectedIndex].value;
            }
            <?php
            }
            }
            tng_free_result($etresult);
            ?>
            window.location.href = "famsearch.php?" + URL;
            return false;
        }

        //]]>
    </script>

    <h2 class="header"><span class="headericon" id="fsearch-hdr-icon"></span><?php echo _('Search Families'); ?></h2>
    <br class="clear-both">
<?php
if ($msg) {
    echo "<b id='errormsg' class='msgerror subhead'>" . stripslashes(strip_tags($msg)) . "</b>";
}

$formstr = getFORM("famsearch", "", "famsearch", "", "$('searchbtn').className='fieldnamebacksave';return makeURL();");
echo $formstr;
?>
    <div class="searchformbox">
        <table cellspacing="1" cellpadding="4" class="normal">
            <?php if ((!$requirelogin || !$treerestrict || !$assignedtree) && $numtrees > 1) { ?>
                <tr>
                    <td class="fieldnameback fieldname"><?php echo _('Tree'); ?>:</td>
                    <td class="databack"><?php echo treeSelect($result); ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="2"><strong><?php echo _('Father\'s Name'); ?></strong></td>
            </tr>
            <tr>
                <td class="fieldnameback fieldname"><?php echo _('First Name'); ?>:</td>
                <td class="databack">
                    <select name="ffnqualify" class="mediumfield">
                        <?php
                        $item_array = [[_('contains'), "contains"], [_('equals'), "equals"], [_('starts with'), "startswith"], [_('ends with'), "endswith"], [_('exists'), "exists"], [_('does not exist'), "dnexist"], [_('soundex of'), "soundexof"]];
                        foreach ($item_array as $item) {
                            echo "<option value=\"$item[1]\"";
                            if ($ffnqualify == $item[1]) echo " selected";

                            echo ">$item[0]</option>\n";
                        }
                        ?>
                    </select>
                    <input type="text" name="myffirstname" value="<?php echo $myffirstname; ?>">
                </td>
            </tr>
            <tr>
                <td class="fieldnameback fieldname"><?php echo _('Last Name'); ?>:</td>
                <td class="databack">
                    <select name="flnqualify" class="mediumfield">
                        <?php
                        $item_array = [[_('contains'), "contains"], [_('equals'), "equals"], [_('starts with'), "startswith"], [_('ends with'), "endswith"], [_('exists'), "exists"], [_('does not exist'), "dnexist"], [_('soundex of'), "soundexof"], [_('metaphone of'), "metaphoneof"]];
                        foreach ($item_array as $item) {
                            echo "<option value=\"$item[1]\"";
                            if ($flnqualify == $item[1]) echo " selected";

                            echo ">$item[0]</option>\n";
                        }
                        ?>
                    </select>
                    <input type="text" name="myflastname" value="<?php echo $myflastname; ?>">
                </td>
            </tr>
            <tr>
                <td colspan="2"><strong><?php echo _('Mother\'s Name'); ?></strong></td>
            </tr>
            <tr>
                <td class="fieldnameback fieldname"><?php echo _('First Name'); ?>:</td>
                <td class="databack">
                    <select name="mfnqualify" class="mediumfield">
                        <?php
                        $item_array = [[_('contains'), "contains"], [_('equals'), "equals"], [_('starts with'), "startswith"], [_('ends with'), "endswith"], [_('exists'), "exists"], [_('does not exist'), "dnexist"], [_('soundex of'), "soundexof"]];
                        foreach ($item_array as $item) {
                            echo "<option value=\"$item[1]\"";
                            if ($mfnqualify == $item[1]) echo " selected";

                            echo ">$item[0]</option>\n";
                        }
                        ?>
                    </select>
                    <input type="text" name="mymfirstname" value="<?php echo $mymfirstname; ?>">
                </td>
            </tr>
            <tr>
                <td class="fieldnameback fieldname"><?php echo _('Last Name'); ?>:</td>
                <td class="databack">
                    <select name="mlnqualify" class="mediumfield">
                        <?php
                        $item_array = [[_('contains'), "contains"], [_('equals'), "equals"], [_('starts with'), "startswith"], [_('ends with'), "endswith"], [_('exists'), "exists"], [_('does not exist'), "dnexist"], [_('soundex of'), "soundexof"], [_('metaphone of'), "metaphoneof"]];
                        foreach ($item_array as $item) {
                            echo "<option value=\"$item[1]\"";
                            if ($mlnqualify == $item[1]) echo " selected";

                            echo ">$item[0]</option>\n";
                        }
                        ?>
                    </select>
                    <input type="text" name="mymlastname" value="<?php echo $mymlastname; ?>">
                </td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td class="fieldnameback fieldname"><?php echo _('Family ID'); ?>:</td>
                <td class="databack">
                    <select name="fidqualify" class="mediumfield">
                        <?php
                        $item_array = [[_('equals'), "equals"], [_('contains'), "contains"], [_('starts with'), "startswith"], [_('ends with'), "endswith"]];
                        foreach ($item_array as $item) {
                            echo "<option value=\"$item[1]\"";
                            if ($fidqualify == $item[1]) echo " selected";

                            echo ">$item[0]</option>\n";
                        }
                        ?>
                    </select>
                    <input type="text" name="myfamilyid" value="<?php echo $myfamilyid; ?>">
                </td>
            </tr>
            <tr>
                <td class="fieldnameback fieldname"><?php echo _('Marriage Place'); ?>:</td>
                <td class="databack">
                    <select name="mpqualify" class="mediumfield">
                        <?php
                        $item_array = [[_('contains'), "contains"], [_('equals'), "equals"], [_('starts with'), "startswith"], [_('ends with'), "endswith"], [_('exists'), "exists"], [_('does not exist'), "dnexist"]];
                        foreach ($item_array as $item) {
                            echo "<option value=\"$item[1]\"";
                            if ($mpqualify == $item[1]) echo " selected";

                            echo ">$item[0]</option>\n";
                        }
                        ?>
                    </select>
                    <input type="text" name="mymarrplace" value="<?php echo $mymarrplace; ?>">
                </td>
            </tr>
            <tr>
                <td class="fieldnameback fieldname"><?php echo _('Marriage Year'); ?>:</td>
                <td class="databack">
                    <select name="myqualify" class="mediumfield">
                        <?php
                        $item2_array = [[_('equals'), ""], [_('+/- 2 years from'), "pm2"], [_('+/- 5 years from'), "pm5"], [_('+/- 10 years from'), "pm10"], [_('less than'), "lt"], [_('greater than'), "gt"], [_('less than or equal to'), "lte"], [_('greater than or equal to'), "gte"], [_('exists'), "exists"], [_('does not exist'), "dnexist"]];
                        foreach ($item2_array as $item) {
                            echo "<option value=\"$item[1]\"";
                            if ($myqualify == $item[1]) echo " selected";

                            echo ">$item[0]</option>\n";
                        }
                        ?>
                    </select>
                    <input type="text" name="mymarryear" value="<?php echo $mymarryear; ?>">
                </td>
            </tr>
            <tr>
                <td class="fieldnameback fieldname"><?php echo _('Divorce Place'); ?>:</td>
                <td class="databack">
                    <select name="dvpqualify" class="mediumfield">
                        <?php
                        $item_array = [[_('contains'), "contains"], [_('equals'), "equals"], [_('starts with'), "startswith"], [_('ends with'), "endswith"], [_('exists'), "exists"], [_('does not exist'), "dnexist"]];
                        foreach ($item_array as $item) {
                            echo "<option value=\"$item[1]\"";
                            if ($dvpqualify == $item[1]) echo " selected";

                            echo ">$item[0]</option>\n";
                        }
                        ?>
                    </select>
                    <input type="text" name="mydivplace" value="<?php echo $mydivplace; ?>">
                </td>
            </tr>
            <tr>
                <td class="fieldnameback fieldname"><?php echo _('Divorce Date (True)'); ?>:</td>
                <td class="databack">
                    <select name="dvyqualify" class="mediumfield">
                        <?php
                        $item2_array = [[_('equals'), ""], [_('+/- 2 years from'), "pm2"], [_('+/- 5 years from'), "pm5"], [_('+/- 10 years from'), "pm10"], [_('less than'), "lt"], [_('greater than'), "gt"], [_('less than or equal to'), "lte"], [_('greater than or equal to'), "gte"], [_('exists'), "exists"], [_('does not exist'), "dnexist"]];
                        foreach ($item2_array as $item) {
                            echo "<option value=\"$item[1]\"";
                            if ($dvyqualify == $item[1]) echo " selected";

                            echo ">$item[0]</option>\n";
                        }
                        ?>
                    </select>
                    <input type="text" name="mydivyear" value="<?php echo $mydivyear; ?>">
                </td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td class="fieldnameback fieldname"><?php echo _('Marriage Type'); ?>:</td>
                <td class="databack">
                    <select name="mtqualify" class="mediumfield">
                        <?php
                        $item_array = [[_('contains'), "contains"], [_('equals'), "equals"], [_('starts with'), "startswith"], [_('ends with'), "endswith"], [_('exists'), "exists"], [_('does not exist'), "dnexist"]];
                        foreach ($item_array as $item) {
                            echo "<option value=\"$item[1]\"";
                            if ($mtqualify == $item[1]) echo " selected";

                            echo ">$item[0]</option>\n";
                        }
                        ?>
                    </select>
                    <input type="text" name="mymarrtype" value="<?php echo $mymarrtype; ?>">
                </td>
            </tr>
        </table>
        <input type="hidden" name="offset" value="0">

        <br>
        <hr>
        <h3 class="subhead"><?php echo _('Other Events'); ?></h3>
        <ul id="descendantchart" class="normal text-left">
            <li id="expand" class="othersearch">
                <a href="#" onclick="return toggleSection(1);" class="text-decoration-none">
                    <img src="img/tng_expand.gif" alt="" class="exp-cont inline-block"><?php echo _('Click to display'); ?>
                </a>
            </li>
            <li id="contract" class="othersearch" style="display:none;">
                <a href="#" onclick="return toggleSection(0);" class="text-decoration-none">
                    <img src="img/tng_collapse.gif" alt="" class="exp-cont inline-block"><?php echo _('Click to hide'); ?>
                </a>
            </li>
        </ul>
        <table style="display:none;" id="otherevents">
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
            <?php
            $query = "SELECT eventtypeID, tag, display FROM $eventtypes_table WHERE keep='1' AND type='F' ORDER BY display";
            $result = tng_query($query);
            $eventtypes = [];
            while ($row = tng_fetch_assoc($result)) {
                if (!in_array($row['tag'], $dontdo)) {
                    $row['displaymsg'] = getEventDisplay($row['display']);
                    $displaymsg = strtoupper($row['displaymsg']) . "_" . $row['eventtypeID'];
                    $eventtypes[$displaymsg] = $row;
                }
            }
            tng_free_result($result);
            ksort($eventtypes);

            foreach ($eventtypes as $row) {
                echo "<tr><td colspan='3'><span class='normal'>{$row['displaymsg']}</span></td></tr>\n";

                echo "<tr>\n";
                echo "<td><span class='normal'>&nbsp;&nbsp;&nbsp;" . _('Fact') . ":</span></td>\n";
                echo "<td>\n";
                echo "<select name=\"cfq{$row['eventtypeID']}\" class=\"mediumfield\">\n";
                foreach ($item_array as $item) {
                    echo "<option value=\"$item[1]\"";
                    echo ">$item[0]</option>\n";
                }
                echo "</select>\n";
                echo "</td>\n";
                echo "<td><input type='text' name=\"cef{$row['eventtypeID']}\" value=\"\"></td>\n";
                echo "</tr>\n";

                echo "<tr>\n";
                echo "<td><span class='normal'>&nbsp;&nbsp;&nbsp;" . _('Place') . ":</span></td>\n";
                echo "<td>\n";
                echo "<select name=\"cpq{$row['eventtypeID']}\" class=\"mediumfield\">\n";
                foreach ($item_array as $item) {
                    echo "<option value=\"$item[1]\"";
                    echo ">$item[0]</option>\n";
                }
                echo "</select>\n";
                echo "</td>\n";
                echo "<td><input type='text' name=\"cep{$row['eventtypeID']}\" value=\"\"></td>\n";
                echo "</tr>\n";

                echo "<tr>\n";
                echo "<td><span class='normal'>&nbsp;&nbsp;&nbsp;" . _('Year') . ":</span></td>\n";
                echo "<td>\n";
                echo "<select name=\"cyq{$row['eventtypeID']}\" class=\"mediumfield\">\n";

                $item2_array = [[_('equals'), ""], [_('+/- 2 years from'), "pm2"], [_('+/- 5 years from'), "pm5"], [_('+/- 10 years from'), "pm10"], [_('less than'), "lt"], [_('greater than'), "gt"], [_('less than or equal to'), "lte"], [_('greater than or equal to'), "gte"], [_('exists'), "exists"], [_('does not exist'), "dnexist"]];
                foreach ($item2_array as $item) {
                    echo "<option value=\"$item[1]\"";
                    echo ">$item[0]</option>\n";
                }

                echo "</select>\n";
                echo "</td>\n";
                echo "<td><input type='text' name=\"cey$row[eventtypeID]\" value=\"\"></td>\n";
                echo "</tr>\n";
            }
            ?>
            <tr class="secondsearch">
                <td colspan="3"><br>
                    <input type="button" value="<?php echo _('Search'); ?>" onclick="$('searchbtn').className='fieldnamebacksave';return makeURL();">
                    <input type="button"
                        value="<?php echo _('Reset All Values'); ?>"
                        onclick="resetValues();">
                </td>
            </tr>
        </table>
        <hr>
    </div>

    <div class="searchsidebar">
        <table>
            <tr>
                <td><span class="normal"><?php echo _('Join with'); ?>:</span></td>
                <td>
                    <select name="mybool">
                        <?php
                        $item3_array = [[_('AND'), "AND"], [_('OR'), "OR"]];
                        foreach ($item3_array as $item) {
                            echo "<option value=\"$item[1]\"";
                            if ($mybool == $item[1]) echo " selected";

                            echo ">$item[0]</option>\n";
                        }
                        ?>
                    </select>
                </td>
                <td></td>
            </tr>
            <tr>
                <td><span class="normal"><?php echo _('Results per page'); ?>:</span></td>
                <td>
                    <select name="nr">
                        <?php
                        $item3_array = [[50, 50], [100, 100], [150, 150], [200, 200]];
                        foreach ($item3_array as $item) {
                            echo "<option value=\"$item[1]\"";
                            if ($nr == $item[1]) echo " selected";

                            echo ">$item[0]</option>\n";
                        }
                        ?>
                    </select>
                </td>
                <td></td>
            </tr>
        </table>
        <p></p>
        <input type="submit" id="searchbtn" class="btn" value="<?php echo _('Search'); ?>">
        <input type="button" id="resetbtn" class="btn" value="<?php echo _('Reset'); ?>" onclick="resetValues();">
        </p>
        <br><br>
        <p>
            <a href="searchform.php" class="snlink rounded">&raquo; <?php echo _('Search People'); ?></a>
            <a href="searchsite.php" class="snlink rounded">&raquo; <?php echo _('Search Site'); ?></a>
        </p>
    </div>

    </form>
    <br class="clear-both">
<?php
tng_footer("");
?>
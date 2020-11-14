<?php
$textpart = "search";
include "tng_begin.php";

$query = "SELECT gedcom, treename FROM $trees_table ORDER BY treename";
$result = tng_query($query);
$numtrees = tng_num_rows($result);

$branchquery = "SELECT count(branch) AS branchcount FROM $branches_table";
$branchresult = tng_query($branchquery);
$branchrow = tng_fetch_assoc($branchresult);
$numbranches = $branchrow['branchcount'];
tng_free_result($branchresult);

if (!empty($_SESSION['tng_search_tree'])) $tree = $_SESSION['tng_search_tree'];
if (!empty($_SESSION['tng_search_branch'])) $branch = $_SESSION['tng_search_branch'];
$lnqualify = isset($_SESSION['tng_search_lnqualify']) ? $_SESSION['tng_search_lnqualify'] : "";
$mylastname = isset($_SESSION['tng_search_lastname']) ? $_SESSION['tng_search_lastname'] : "";
$fnqualify = isset($_SESSION['tng_search_fnqualify']) ? $_SESSION['tng_search_fnqualify'] : "";
$myfirstname = isset($_SESSION['tng_search_firstname']) ? $_SESSION['tng_search_firstname'] : "";
$idqualify = isset($_SESSION['tng_search_idqualify']) ? $_SESSION['tng_search_idqualify'] : "";
$mypersonid = isset($_SESSION['tng_search_personid']) ? $_SESSION['tng_search_personid'] : "";
$bpqualify = isset($_SESSION['tng_search_bpqualify']) ? $_SESSION['tng_search_bpqualify'] : "";
$mybirthplace = isset($_SESSION['tng_search_birthplace']) ? $_SESSION['tng_search_birthplace'] : "";
$byqualify = isset($_SESSION['tng_search_byqualify']) ? $_SESSION['tng_search_byqualify'] : "";
$mybirthyear = isset($_SESSION['tng_search_birthyear']) ? $_SESSION['tng_search_birthyear'] : "";
$cpqualify = isset($_SESSION['tng_search_cpqualify']) ? $_SESSION['tng_search_cpqualify'] : "";
$myaltbirthplace = isset($_SESSION['tng_search_altbirthplace']) ? $_SESSION['tng_search_altbirthplace'] : "";
$cyqualify = isset($_SESSION['tng_search_cyqualify']) ? $_SESSION['tng_search_cyqualify'] : "";
$myaltbirthyear = isset($_SESSION['tng_search_altbirthyear']) ? $_SESSION['tng_search_altbirthyear'] : "";
$dpqualify = isset($_SESSION['tng_search_dpqualify']) ? $_SESSION['tng_search_dpqualify'] : "";
$mydeathplace = isset($_SESSION['tng_search_deathplace']) ? $_SESSION['tng_search_deathplace'] : "";
$dyqualify = isset($_SESSION['tng_search_dyqualify']) ? $_SESSION['tng_search_dyqualify'] : "";
$mydeathyear = isset($_SESSION['tng_search_deathyear']) ? $_SESSION['tng_search_deathyear'] : "";
$brpqualify = isset($_SESSION['tng_search_brpqualify']) ? $_SESSION['tng_search_brpqualify'] : "";
$myburialplace = isset($_SESSION['tng_search_burialplace']) ? $_SESSION['tng_search_burialplace'] : "";
$bryqualify = isset($_SESSION['tng_search_bryqualify']) ? $_SESSION['tng_search_bryqualify'] : "";
$myburialyear = isset($_SESSION['tng_search_burialyear']) ? $_SESSION['tng_search_burialyear'] : "";
$mybool = isset($_SESSION['tng_search_bool']) ? $_SESSION['tng_search_bool'] : "";
$showdeath = isset($_SESSION['tng_search_showdeath']) ? $_SESSION['tng_search_showdeath'] : "";
$showspouse = isset($_SESSION['tng_search_showspouse']) ? $_SESSION['tng_search_showspouse'] : "";
$mygender = isset($_SESSION['tng_search_gender']) ? $_SESSION['tng_search_gender'] : "";
$mysplname = isset($_SESSION['tng_search_mysplname']) ? $_SESSION['tng_search_mysplname'] : "";
$spqualify = isset($_SESSION['tng_search_spqualify']) ? $_SESSION['tng_search_spqualify'] : "";
$nr = isset($_SESSION['tng_nr']) ? $_SESSION['tng_nr'] : "";

$dontdo = ["ADDR", "BIRT", "CHR", "DEAT", "BURI", "NICK", "TITL", "NSFX", "NPFX"];

tng_header(_('Search People'), $flags);
?>
    <script>
        //<![CDATA[
        <?php include "branchlibjs.php"; ?>

        function resetValues() {
            <?php if ((!$requirelogin || !$treerestrict || !$assignedtree) && $numtrees > 1) {
            echo "	document.search.tree.selectedIndex = 0;";
        } ?>
            document.search.reset();

            document.search.lnqualify.selectedIndex = 0;
            document.search.fnqualify.selectedIndex = 0;
            document.search.nnqualify.selectedIndex = 0;
            document.search.tqualify.selectedIndex = 0;
            document.search.sfqualify.selectedIndex = 0;
            document.search.bpqualify.selectedIndex = 0;
            document.search.byqualify.selectedIndex = 0;
            document.search.cpqualify.selectedIndex = 0;
            document.search.cyqualify.selectedIndex = 0;
            document.search.dpqualify.selectedIndex = 0;
            document.search.dyqualify.selectedIndex = 0;
            document.search.brpqualify.selectedIndex = 0;
            document.search.bryqualify.selectedIndex = 0;
            document.search.spqualify.selectedIndex = 0;
            document.search.mybool.selectedIndex = 0;
            document.search.idqualify.selectedIndex = 0;

            document.search.mylastname.value = "";
            document.search.myfirstname.value = "";
            document.search.mynickname.value = "";
            document.search.myprefix.value = "";
            document.search.mysuffix.value = "";
            document.search.mytitle.value = "";
            document.search.mybirthplace.value = "";
            document.search.mybirthyear.value = "";
            document.search.myaltbirthplace.value = "";
            document.search.myaltbirthyear.value = "";
            document.search.mydeathplace.value = "";
            document.search.mydeathyear.value = "";
            document.search.myburialplace.value = "";
            document.search.myburialyear.value = "";
            document.search.mygender.selectedIndex = 0;
            document.search.mysplname.value = "";
            document.search.mypersonid.value = "";

            document.search.showdeath.checked = false;
            document.search.showspouse.checked = false;

            jQuery('#errormsg').hide();
        }

        function getTree(treefield) {
            return treefield.options[treefield.selectedIndex].value;
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
            let URL;
            let thisform = document.search;
            let thisfield;
            let found = 0;
            if (thisform.mysplname.value !== "" && (thisform.mygender.selectedIndex < 1 || thisform.mygender.selectedIndex > 2)) {
                alert("<?php echo _('If you enter a value for Spouse\'s Last Name, you must select a Gender.'); ?>");
                return false;
            }
            if (thisform.mysplname.value !== "" && thisform.mybool.selectedIndex > 0) {
                alert("<?php echo _('The \'Join with OR\' option cannot be used with Spouse\'s Last Name'); ?>");
                return false;
            }
            URL = "mybool=" + thisform.mybool[thisform.mybool.selectedIndex].value;
            URL = URL + "&nr=" + thisform.nr[thisform.nr.selectedIndex].value;
            <?php if ((!$requirelogin || !$treerestrict || !$assignedtree) && ($numtrees > 1 || $numbranches)) { ?>
            URL = URL + "&tree=" + thisform.tree[thisform.tree.selectedIndex].value;
            URL = URL + "&branch=" + thisform.branch[thisform.branch.selectedIndex].value;
            <?php } ?>

            if (thisform.showdeath.checked)
                URL = URL + "&showdeath=yes";
            if (thisform.showspouse.checked)
                URL = URL + "&showspouse=yes";

            <?php
            $qualifiers = ["ln", "fn", "id", "bp", "by", "cp", "cy", "dp", "dy", "brp", "bry", "nn", "t", "pf", "sf", "sp", "ge"];
            $criteria = ["lastname", "firstname", "personid", "birthplace", "birthyear", "altbirthplace", "altbirthyear", "deathplace", "deathyear", "burialplace", "burialyear", "nickname", "title", "prefix", "suffix", "splname", "gender"];

            $qcount = 0;
            $found = 0;
            foreach( $criteria as $criterion ) {
            ?>
            if (thisform.my<?php echo $criterion; ?>.value !== "" || thisform.<?php echo $qualifiers[$qcount]; ?>qualify.value === "exists" || thisform.<?php echo $qualifiers[$qcount]; ?>qualify.value === "dnexist") {
                URL = URL + "&my<?php echo $criterion; ?>=" + thisform.my<?php echo $criterion; ?>.value;
                URL = URL + "&<?php echo $qualifiers[$qcount]; ?>qualify=" + thisform.<?php echo $qualifiers[$qcount]; ?>qualify[thisform.<?php echo $qualifiers[$qcount]; ?>qualify.selectedIndex].value;
                found++;
            }
            <?php
            $qcount++;
            }

            $query = "SELECT eventtypeID, tag FROM $eventtypes_table WHERE keep='1' AND type='I'";
            $etresult = tng_query($query);
            while($row = tng_fetch_assoc($etresult)) {
            if( !in_array($row['tag'], $dontdo) ) {
            ?>
            if (thisform.cef<?php echo $row['eventtypeID']; ?>.value !== "" || thisform.cfq<?php echo $row['eventtypeID']; ?>.value === "exists" || thisform.cfq<?php echo $row['eventtypeID']; ?>.value === "dnexist") {
                URL = URL + "&cef<?php echo $row['eventtypeID']; ?>=" + thisform.cef<?php echo $row['eventtypeID']; ?>.value;
                URL = URL + "&cfq<?php echo $row['eventtypeID']; ?>=" + thisform.cfq<?php echo $row['eventtypeID']; ?>[thisform.cfq<?php echo $row['eventtypeID']; ?>.selectedIndex].value;
            }
            if (thisform.cep<?php echo $row['eventtypeID']; ?>.value !== "" || thisform.cpq<?php echo $row['eventtypeID']; ?>.value === "exists" || thisform.cpq<?php echo $row['eventtypeID']; ?>.value === "dnexist") {
                URL = URL + "&cep<?php echo $row['eventtypeID']; ?>=" + thisform.cep<?php echo $row['eventtypeID']; ?>.value;
                URL = URL + "&cpq<?php echo $row['eventtypeID']; ?>=" + thisform.cpq<?php echo $row['eventtypeID']; ?>[thisform.cpq<?php echo $row['eventtypeID']; ?>.selectedIndex].value;
            }
            if (thisform.cey<?php echo $row['eventtypeID']; ?>.value !== "" || thisform.cyq<?php echo $row['eventtypeID']; ?>.value === "exists" || thisform.cyq<?php echo $row['eventtypeID']; ?>.value === "dnexist") {
                URL = URL + "&cey<?php echo $row['eventtypeID']; ?>=" + thisform.cey<?php echo $row['eventtypeID']; ?>.value;
                URL = URL + "&cyq<?php echo $row['eventtypeID']; ?>=" + thisform.cyq<?php echo $row['eventtypeID']; ?>[thisform.cyq<?php echo $row['eventtypeID']; ?>.selectedIndex].value;
            }
            <?php
            }
            }
            tng_free_result($etresult);
            ?>
            window.location.href = "search.php?" + URL;

            return false;
        }
        <?php if ($tree) { ?>
        jQuery(document).ready(function () {
            swapBranches(document.search);
            <?php if ($branch) { ?>
            jQuery('#branch').val('<?php echo $branch; ?>');
            <?php } ?>
        });
        <?php } ?>
        //]]>
    </script>

    <h2 class="header"><span class="headericon" id="search-hdr-icon"></span><?php echo _('Search People'); ?></h2>
    <br class="clear-both">
<?php
if (!empty($msg)) {
    echo "<h3 id='errormsg' class='msgerror subhead'>" . stripslashes(strip_tags($msg)) . "</h3>";
}
$branchchange = "var tree=getTree(this); if( !tree ) tree = 'none'; swapBranches(document.search);";
?>
    <form action="search.php" name="search" onsubmit="$('searchbtn').className='fieldnamebacksave'; return makeURL();">

        <div class="searchformbox">
            <table cellspacing="1" cellpadding="4" class="normal">
                <?php if ((!$requirelogin || !$treerestrict || !$assignedtree) && ($numtrees > 1 || $numbranches)) { ?>
                    <tr>
                        <td class="fieldnameback fieldname"><?php echo _('Tree'); ?><?php if ($numbranches) {
                                echo " | " . _('Branch');
                            } ?>:
                        </td>
                        <td class="databack">
                            <?php echo treeSelect($result, null, $branchchange); ?>
                            <select name="branch" id="branch">
                                <option value=""><?php echo _('All Branches'); ?></option>
                            </select>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td class="fieldnameback fieldname"><?php echo _('First Name'); ?>:</td>
                    <td class="databack">
                        <select name="fnqualify" class="mediumfield">
                            <?php
                            $item_array = [[_('contains'), "contains"], [_('equals'), "equals"], [_('starts with'), "startswith"], [_('ends with'), "endswith"], [_('exists'), "exists"], [_('does not exist'), "dnexist"], [_('soundex of'), "soundexof"]];
                            foreach ($item_array as $item) {
                                echo "<option value=\"$item[1]\"";
                                if ($fnqualify == $item[1]) echo " selected";
                                echo ">$item[0]</option>\n";
                            }
                            ?>
                        </select>
                        <input type="search" name="myfirstname" value="<?php echo $myfirstname; ?>">
                    </td>
                </tr>
                <tr>
                    <td class="fieldnameback fieldname"><?php echo _('Last Name'); ?>:</td>
                    <td class="databack">
                        <select name="lnqualify" class="mediumfield">
                            <?php
                            $item_array = [[_('contains'), "contains"], [_('equals'), "equals"], [_('starts with'), "startswith"], [_('ends with'), "endswith"], [_('exists'), "exists"], [_('does not exist'), "dnexist"], [_('soundex of'), "soundexof"], [_('metaphone of'), "metaphoneof"]];
                            foreach ($item_array as $item) {
                                echo "<option value=\"$item[1]\"";
                                if ($lnqualify == $item[1]) echo " selected";
                                echo ">$item[0]</option>\n";
                            }
                            ?>
                        </select>
                        <input type="search" name="mylastname" value="<?php echo $mylastname; ?>">
                    </td>
                </tr>
                <tr>
                    <td class="fieldnameback fieldname"><?php echo _('Person ID'); ?>:</td>
                    <td class="databack">
                        <select name="idqualify" class="mediumfield">
                            <?php
                            $item_array = [[_('equals'), "equals"], [_('contains'), "contains"], [_('starts with'), "startswith"], [_('ends with'), "endswith"]];
                            foreach ($item_array as $item) {
                                echo "<option value=\"$item[1]\"";
                                if ($idqualify == $item[1]) echo " selected";
                                echo ">$item[0]</option>\n";
                            }
                            ?>
                        </select>
                        <input type="search" name="mypersonid" value="<?php echo $mypersonid; ?>">
                    </td>
                </tr>
                <tr>
                    <td class="fieldnameback fieldname"><?php echo _('Gender'); ?>:</td>
                    <td class="databack">
                        <select name="gequalify" class="mediumfield">
                            <option value="equals"><?php echo _('equals'); ?></option>
                        </select>
                        <select name="mygender">
                            <option value="">&nbsp;</option>
                            <option value="M"<?php if ($mygender == "M") echo " selected"; ?>><?php echo _('Male'); ?></option>
                            <option value="F"<?php if ($mygender == "F") echo " selected"; ?>><?php echo _('Female'); ?></option>
                            <option value="U"<?php if ($mygender == "U") echo " selected"; ?>><?php echo _('Unknown'); ?></option>
                            <option value="N"<?php if ($mygender == "N") echo " selected"; ?>><?php echo _('No encryption'); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td class="fieldnameback fieldname"><?php echo _('Birth Place'); ?>:</td>
                    <td class="databack">
                        <select name="bpqualify" class="mediumfield">
                            <?php
                            $item_array = [[_('contains'), "contains"], [_('equals'), "equals"], [_('starts with'), "startswith"], [_('ends with'), "endswith"], [_('exists'), "exists"], [_('does not exist'), "dnexist"]];
                            foreach ($item_array as $item) {
                                echo "<option value=\"$item[1]\"";
                                if ($bpqualify == $item[1]) echo " selected";
                                echo ">$item[0]</option>\n";
                            }
                            ?>
                        </select>
                        <input type="search" name="mybirthplace" value="<?php echo $mybirthplace; ?>">
                    </td>
                </tr>
                <tr>
                    <td class="fieldnameback fieldname"><?php echo _('Birth Date (True)'); ?>:</td>
                    <td class="databack">
                        <select name="byqualify" class="mediumfield">
                            <?php
                            $item2_array = [[_('equals'), ""], [_('+/- 2 years from'), "pm2"], [_('+/- 5 years from'), "pm5"], [_('+/- 10 years from'), "pm10"], [_('less than'), "lt"], [_('greater than'), "gt"], [_('less than or equal to'), "lte"], [_('greater than or equal to'), "gte"], [_('exists'), "exists"], [_('does not exist'), "dnexist"]];
                            foreach ($item2_array as $item) {
                                echo "<option value=\"$item[1]\"";
                                if ($byqualify == $item[1]) echo " selected";
                                echo ">$item[0]</option>\n";
                            }
                            ?>
                        </select>
                        <input type="text" name="mybirthyear" value="<?php echo $mybirthyear; ?>">
                    </td>
                </tr>
                <tr<?php if ($tngconfig['hidechr']) echo " style='display: none;'"; ?>>
                    <td class="fieldnameback fieldname"><?php echo _('Christening Place'); ?>:</td>
                    <td class="databack">
                        <select name="cpqualify" class="mediumfield">
                            <?php
                            foreach ($item_array as $item) {
                                echo "<option value=\"$item[1]\"";
                                if ($cpqualify == $item[1]) echo " selected";
                                echo ">$item[0]</option>\n";
                            }
                            ?>
                        </select>
                        <input type="search" name="myaltbirthplace" value="<?php echo $myaltbirthplace; ?>">
                    </td>
                </tr>
                <tr<?php if ($tngconfig['hidechr']) echo " style='display: none;'"; ?>>
                    <td class="fieldnameback fieldname"><?php echo _('Christening Year'); ?>:</td>
                    <td class="databack">
                        <select name="cyqualify" class="mediumfield">
                            <?php
                            $item2_array = [[_('equals'), ""], [_('+/- 2 years from'), "pm2"], [_('+/- 5 years from'), "pm5"], [_('+/- 10 years from'), "pm10"], [_('less than'), "lt"], [_('greater than'), "gt"], [_('less than or equal to'), "lte"], [_('greater than or equal to'), "gte"], [_('exists'), "exists"], [_('does not exist'), "dnexist"]];
                            foreach ($item2_array as $item) {
                                echo "<option value=\"$item[1]\"";
                                if ($cyqualify == $item[1]) echo " selected";
                                echo ">$item[0]</option>\n";
                            }
                            ?>
                        </select>
                        <input type="text" name="myaltbirthyear" value="<?php echo $myaltbirthyear; ?>">
                    </td>
                </tr>
                <tr>
                    <td class="fieldnameback fieldname"><?php echo _('Death Place'); ?>:</td>
                    <td class="databack">
                        <select name="dpqualify" class="mediumfield">
                            <?php
                            foreach ($item_array as $item) {
                                echo "<option value=\"$item[1]\"";
                                if ($dpqualify == $item[1]) echo " selected";
                                echo ">$item[0]</option>\n";
                            }
                            ?>
                        </select>
                        <input type="search" name="mydeathplace" value="<?php echo $mydeathplace; ?>">
                    </td>
                </tr>
                <tr>
                    <td class="fieldnameback fieldname"><?php echo _('Death Date (True)'); ?>:</td>
                    <td class="databack">
                        <select name="dyqualify" class="mediumfield">
                            <?php
                            $item2_array = [[_('equals'), ""], [_('+/- 2 years from'), "pm2"], [_('+/- 5 years from'), "pm5"], [_('+/- 10 years from'), "pm10"], [_('less than'), "lt"], [_('greater than'), "gt"], [_('less than or equal to'), "lte"], [_('greater than or equal to'), "gte"], [_('exists'), "exists"], [_('does not exist'), "dnexist"]];
                            foreach ($item2_array as $item) {
                                echo "<option value=\"$item[1]\"";
                                if ($dyqualify == $item[1]) echo " selected";
                                echo ">$item[0]</option>\n";
                            }
                            ?>
                        </select>
                        <input type="text" name="mydeathyear" value="<?php echo $mydeathyear; ?>">
                    </td>
                </tr>
                <tr>
                    <td class="fieldnameback fieldname"><?php echo _('Burial Place'); ?>:</td>
                    <td class="databack">
                        <select name="brpqualify" class="mediumfield">
                            <?php
                            foreach ($item_array as $item) {
                                echo "<option value=\"$item[1]\"";
                                if ($brpqualify == $item[1]) echo " selected";
                                echo ">$item[0]</option>\n";
                            }
                            ?>
                        </select>
                        <input type="search" name="myburialplace" value="<?php echo $myburialplace; ?>">
                    </td>
                </tr>
                <tr>
                    <td class="fieldnameback fieldname"><?php echo _('Burial Date (True)'); ?>:</td>
                    <td class="databack">
                        <select name="bryqualify" class="mediumfield">
                            <?php
                            $item2_array = [[_('equals'), ""], [_('+/- 2 years from'), "pm2"], [_('+/- 5 years from'), "pm5"], [_('+/- 10 years from'), "pm10"], [_('less than'), "lt"], [_('greater than'), "gt"], [_('less than or equal to'), "lte"], [_('greater than or equal to'), "gte"], [_('exists'), "exists"], [_('does not exist'), "dnexist"]];
                            foreach ($item2_array as $item) {
                                echo "<option value=\"$item[1]\"";
                                if ($bryqualify == $item[1]) echo " selected";
                                echo ">$item[0]</option>\n";
                            }
                            ?>
                        </select>
                        <input type="text" name="myburialyear" value="<?php echo $myburialyear; ?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td class="fieldnameback fieldname"><?php echo _('Spouse\'s Last Name'); ?>*:</td>
                    <td class="databack">
                        <select name="spqualify" class="mediumfield">
                            <?php
                            $item_array = [[_('contains'), "contains"], [_('equals'), "equals"], [_('starts with'), "startswith"], [_('ends with'), "endswith"], [_('exists'), "exists"], [_('does not exist'), "dnexist"], [_('soundex of'), "soundexof"], [_('metaphone of'), "metaphoneof"]];
                            foreach ($item_array as $item) {
                                echo "<option value=\"$item[1]\"";
                                if ($spqualify == $item[1]) echo " selected";
                                echo ">$item[0]</option>\n";
                            }
                            ?>
                        </select>
                        <input type="search" name="mysplname" value="<?php echo $mysplname; ?>">
                    </td>
                </tr>
            </table>
            <p class="smaller"><em>*<?php echo _('If you enter a value for Spouse\'s Last Name, you must select a Gender.'); ?></em></p>
            <input type="hidden" name="offset" value="0">

            <hr>
            <h3 class="subhead"><?php echo _('Other Events'); ?></h3>
            <ul class="normal">
                <li id="expand" class="othersearch">
                    <a href="#" class="text-decoration-none" onclick="return toggleSection(1);">
                        <img src="img/tng_expand.gif" alt="" class="exp-cont inline-block"><?php echo _('Click to display'); ?>
                    </a>
                </li>
                <li id="contract" class="othersearch" style="display:none;">
                    <a href="#" class="text-decoration-none" onclick="return toggleSection(0);">
                        <img src="img/tng_collapse.gif" alt="" class="exp-cont inline-block"><?php echo _('Click to hide'); ?>
                    </a>
                </li>
            </ul>
            <table id="otherevents" style="display: none;">
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td><span class="normal"><?php echo _('Nickname'); ?>:</span></td>
                    <td>
                        <select name="nnqualify" class="mediumfield">
                            <?php
                            foreach ($item_array as $item) {
                                echo "<option value=\"$item[1]\"";
                                if (isset($nnqualify) && $nnqualify == $item[1]) echo " selected";
                                echo ">$item[0]</option>\n";
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="mynickname" value="<?php echo isset($mynickname) ? $mynickname : ""; ?>">
                    </td>
                </tr>
                <tr>
                    <td><span class="normal"><?php echo _('Title'); ?>:</span></td>
                    <td>
                        <select name="tqualify" class="mediumfield">
                            <?php
                            foreach ($item_array as $item) {
                                echo "<option value=\"$item[1]\"";
                                if (isset($tqualify) && $tqualify == $item[1]) echo " selected";
                                echo ">$item[0]</option>\n";
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="mytitle" value="<?php echo isset($mytitle) ? $mytitle : ""; ?>">
                    </td>
                </tr>
                <tr>
                    <td><span class="normal"><?php echo _('Prefix'); ?>:</span></td>
                    <td>
                        <select name="pfqualify" class="mediumfield">
                            <?php
                            foreach ($item_array as $item) {
                                echo "<option value=\"$item[1]\"";
                                if (isset($pfqualify) && $pfqualify == $item[1]) echo " selected";
                                echo ">$item[0]</option>\n";
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="myprefix" value="<?php echo isset($myprefix) ? $myprefix : ""; ?>">
                    </td>
                </tr>
                <tr>
                    <td><span class="normal"><?php echo _('Suffix'); ?>:</span></td>
                    <td>
                        <select name="sfqualify" class="mediumfield">
                            <?php
                            foreach ($item_array as $item) {
                                echo "<option value=\"$item[1]\"";
                                if (isset($sfqualify) && $sfqualify == $item[1]) echo " selected";
                                echo ">$item[0]</option>\n";
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="mysuffix" value="<?php echo isset($mysuffix) ? $mysuffix : ""; ?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <?php
                $eventtypes = [];
                $query = "SELECT eventtypeID, tag, display FROM $eventtypes_table WHERE keep='1' AND type='I' ORDER BY display";
                $result = tng_query($query);
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
                    echo "<td><input type='text' name=\"cef{$row['eventtypeID']}\" value=''></td>\n";
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
                    echo "<td><input type='text' name=\"cep{$row['eventtypeID']}\" value=''></td>\n";
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
                    echo "<td><input type='text' name=\"cey{$row['eventtypeID']}\" value=''></td>\n";
                    echo "</tr>\n";
                }
                ?>
                <tr>
                    <td colspan="3"><br>
                        <input type="button" value="<?php echo _('Search'); ?>" onclick="$('searchbtn').className='fieldnamebacksave'; return makeURL();">
                        <input type="button" value="<?php echo _('Reset All Values'); ?>" onclick="resetValues();">
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
            <p class="normal">
                <input type="checkbox" name="showdeath" value="yes"<?php if ($showdeath == "yes") echo " checked"; ?> > <?php echo _('Show death/burial information'); ?><br>
                <input type="checkbox" name="showspouse" value="yes"<?php if ($showspouse == "yes") echo " checked"; ?> > <?php echo _('Show spouse (will show duplicates if individual has more than one spouse)'); ?><br>
                <br>
                <input type="submit" id="searchbtn" class="btn" value="<?php echo _('Search'); ?>">
                <input type="button" id="resetbtn" class="btn" value="<?php echo _('Reset'); ?>" onclick="resetValues();">
            </p>
            <br><br>
            <p>
                <a href="famsearchform.php" class="snlink rounded">&raquo; <?php echo _('Search Families'); ?></a>
                <a href="searchsite.php" class="snlink rounded">&raquo; <?php echo _('Search Site'); ?></a>
            </p>
        </div>

    </form>
    <br class="clear-both">

<?php tng_footer(""); ?>
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

if ($_SESSION['tng_search_tree']) {
    $tree = $_SESSION['tng_search_tree'];
}
if ($_SESSION['tng_search_branch']) {
    $branch = $_SESSION['tng_search_branch'];
}
$lnqualify = $_SESSION['tng_search_lnqualify'];
$mylastname = $_SESSION['tng_search_lastname'];
$fnqualify = $_SESSION['tng_search_fnqualify'];
$myfirstname = $_SESSION['tng_search_firstname'];
$idqualify = $_SESSION['tng_search_idqualify'];
$mypersonid = $_SESSION['tng_search_personid'];
$bpqualify = $_SESSION['tng_search_bpqualify'];
$mybirthplace = $_SESSION['tng_search_birthplace'];
$byqualify = $_SESSION['tng_search_byqualify'];
$mybirthyear = $_SESSION['tng_search_birthyear'];
$cpqualify = $_SESSION['tng_search_cpqualify'];
$myaltbirthplace = $_SESSION['tng_search_altbirthplace'];
$cyqualify = $_SESSION['tng_search_cyqualify'];
$myaltbirthyear = $_SESSION['tng_search_altbirthyear'];
$dpqualify = $_SESSION['tng_search_dpqualify'];
$mydeathplace = $_SESSION['tng_search_deathplace'];
$dyqualify = $_SESSION['tng_search_dyqualify'];
$mydeathyear = $_SESSION['tng_search_deathyear'];
$brpqualify = $_SESSION['tng_search_brpqualify'];
$myburialplace = $_SESSION['tng_search_burialplace'];
$bryqualify = $_SESSION['tng_search_bryqualify'];
$myburialyear = $_SESSION['tng_search_burialyear'];
$mybool = $_SESSION['tng_search_bool'];
$showdeath = $_SESSION['tng_search_showdeath'];
$showspouse = $_SESSION['tng_search_showspouse'];
$mygender = $_SESSION['tng_search_gender'];
$mysplname = $_SESSION['tng_search_mysplname'];
$spqualify = $_SESSION['tng_search_spqualify'];
$nr = $_SESSION['tng_nr'];

$dontdo = ["ADDR", "BIRT", "CHR", "DEAT", "BURI", "NICK", "TITL", "NSFX", "NPFX"];

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

tng_header($text['searchnames'], $flags);
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
            var URL;
            var thisform = document.search;
            var thisfield;
            var found = 0;

            if (thisform.mysplname.value != "" && (thisform.mygender.selectedIndex < 1 || thisform.mygender.selectedIndex > 2)) {
                alert("<?php echo $text['spousemore']; ?>");
                return false;
            }

            if (thisform.mysplname.value != "" && thisform.mybool.selectedIndex > 0) {
                alert("<?php echo $text['joinor']; ?>");
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
            if (thisform.my<?php echo $criterion; ?>.value != "" || thisform.<?php echo $qualifiers[$qcount]; ?>qualify.value == "exists" || thisform.<?php echo $qualifiers[$qcount]; ?>qualify.value == "dnexist") {
                URL = URL + "&my<?php echo $criterion; ?>=" + thisform.my<?php echo $criterion; ?>.value;
                URL = URL + "&<?php echo $qualifiers[$qcount]; ?>qualify=" + thisform.<?php echo $qualifiers[$qcount]; ?>qualify[thisform.<?php echo $qualifiers[$qcount]; ?>qualify.selectedIndex].value;
                found++;
            }
            <?php
            $qcount++;
            }

            //get eventtypeIDs from $eventtypes_table
            $query = "SELECT eventtypeID, tag FROM $eventtypes_table WHERE keep='1' AND type=\"I\"";
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

    <h2 class="header"><span class="headericon" id="search-hdr-icon"></span><?php echo $text['searchnames']; ?></h2>
    <br style="clear: both;">
<?php
if ($msg) {
    echo "<h3 id='errormsg' class='msgerror subhead'>" . stripslashes(strip_tags($msg)) . "</h3>";
}

$branchchange = "var tree=getTree(this); if( !tree ) tree = 'none'; swapBranches(document.search);";

$formstr = getFORM("search", "", "search", "", "$('searchbtn').className='fieldnamebacksave';return makeURL();");
echo $formstr;
?>
    <div class="searchformbox">
        <table cellspacing="1" cellpadding="4" class="normal">
            <?php if ((!$requirelogin || !$treerestrict || !$assignedtree) && ($numtrees > 1 || $numbranches)) { ?>
                <tr>
                    <td class="fieldnameback fieldname"><?php echo $text['tree']; ?><?php if ($numbranches) {
                            echo " | " . $text['branch'];
                        } ?>:
                    </td>
                    <td class="databack">
                        <?php echo treeSelect($result, null, $branchchange); ?>
                        <select name="branch" id="branch">
                            <option value=""><?php echo $admtext['allbranches']; ?></option>
                        </select>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <td class="fieldnameback fieldname"><?php echo $text['firstname']; ?>:</td>
                <td class="databack">
                    <select name="fnqualify" class="mediumfield">
                        <?php
                        $item_array = [[$text['contains'], "contains"], [$text['equals'], "equals"], [$text['startswith'], "startswith"], [$text['endswith'], "endswith"], [$text['exists'], "exists"], [$text['dnexist'], "dnexist"], [$text['soundexof'], "soundexof"]];
                        foreach ($item_array as $item) {
                            echo "<option value=\"$item[1]\"";
                            if ($fnqualify == $item[1]) {
                                echo " selected";
                            }
                            echo ">$item[0]</option>\n";
                        }
                        ?>
                    </select>
                    <input type="search" name="myfirstname" value="<?php echo $myfirstname; ?>">
                </td>
            </tr>
            <tr>
                <td class="fieldnameback fieldname"><?php echo $text['lastname']; ?>:</td>
                <td class="databack">
                    <select name="lnqualify" class="mediumfield">
                        <?php
                        $item_array = [[$text['contains'], "contains"], [$text['equals'], "equals"], [$text['startswith'], "startswith"], [$text['endswith'], "endswith"], [$text['exists'], "exists"],
                            [$text['dnexist'], "dnexist"], [$text['soundexof'], "soundexof"], [$text['metaphoneof'], "metaphoneof"]];
                        foreach ($item_array as $item) {
                            echo "<option value=\"$item[1]\"";
                            if ($lnqualify == $item[1]) {
                                echo " selected";
                            }
                            echo ">$item[0]</option>\n";
                        }
                        ?>
                    </select>
                    <input type="search" name="mylastname" value="<?php echo $mylastname; ?>">
                </td>
            </tr>
            <tr>
                <td class="fieldnameback fieldname"><?php echo $text['personid']; ?>:</td>
                <td class="databack">
                    <select name="idqualify" class="mediumfield">
                        <?php
                        $item_array = [[$text['equals'], "equals"], [$text['contains'], "contains"], [$text['startswith'], "startswith"], [$text['endswith'], "endswith"]];
                        foreach ($item_array as $item) {
                            echo "<option value=\"$item[1]\"";
                            if ($idqualify == $item[1]) {
                                echo " selected";
                            }
                            echo ">$item[0]</option>\n";
                        }
                        ?>
                    </select>
                    <input type="search" name="mypersonid" value="<?php echo $mypersonid; ?>">
                </td>
            </tr>
            <tr>
                <td class="fieldnameback fieldname"><?php echo $text['gender']; ?>:</td>
                <td class="databack">
                    <select name="gequalify" class="mediumfield">
                        <option value="equals"><?php echo $text['equals']; ?></option>
                    </select>
                    <select name="mygender">
                        <option value="">&nbsp;</option>
                        <option value="M"<?php if ($mygender == "M") {
                            echo " selected";
                        } ?>><?php echo $text['male']; ?></option>
                        <option value="F"<?php if ($mygender == "F") {
                            echo " selected";
                        } ?>><?php echo $text['female']; ?></option>
                        <option value="U"<?php if ($mygender == "U") {
                            echo " selected";
                        } ?>><?php echo $text['unknown']; ?></option>
                        <option value="N"<?php if ($mygender == "N") {
                            echo " selected";
                        } ?>><?php echo $text['none']; ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td class="fieldnameback fieldname"><?php echo $text['birthplace']; ?>:</td>
                <td class="databack">
                    <select name="bpqualify" class="mediumfield">
                        <?php
                        $item_array = [[$text['contains'], "contains"], [$text['equals'], "equals"], [$text['startswith'], "startswith"], [$text['endswith'], "endswith"], [$text['exists'], "exists"], [$text['dnexist'], "dnexist"]];
                        foreach ($item_array as $item) {
                            echo "<option value=\"$item[1]\"";
                            if ($bpqualify == $item[1]) {
                                echo " selected";
                            }
                            echo ">$item[0]</option>\n";
                        }
                        ?>
                    </select>
                    <input type="search" name="mybirthplace" value="<?php echo $mybirthplace; ?>">
                </td>
            </tr>
            <tr>
                <td class="fieldnameback fieldname"><?php echo $text['birthdatetr']; ?>:</td>
                <td class="databack">
                    <select name="byqualify" class="mediumfield">
                        <?php
                        $item2_array = [[$text['equals'], ""], [$text['plusminus2'], "pm2"], [$text['plusminus5'], "pm5"], [$text['plusminus10'], "pm10"], [$text['lessthan'], "lt"], [$text['greaterthan'], "gt"], [$text['lessthanequal'], "lte"], [$text['greaterthanequal'], "gte"], [$text['exists'], "exists"], [$text['dnexist'], "dnexist"]];
                        foreach ($item2_array as $item) {
                            echo "<option value=\"$item[1]\"";
                            if ($byqualify == $item[1]) {
                                echo " selected";
                            }
                            echo ">$item[0]</option>\n";
                        }
                        ?>
                    </select>
                    <input type="text" name="mybirthyear" value="<?php echo $mybirthyear; ?>">
                </td>
            </tr>
            <tr<?php if ($tngconfig['hidechr']) {
                echo " style='display: none;'";
            } ?>>
                <td class="fieldnameback fieldname"><?php echo $text['altbirthplace']; ?>:</td>
                <td class="databack">
                    <select name="cpqualify" class="mediumfield">
                        <?php
                        foreach ($item_array as $item) {
                            echo "<option value=\"$item[1]\"";
                            if ($cpqualify == $item[1]) {
                                echo " selected";
                            }
                            echo ">$item[0]</option>\n";
                        }
                        ?>
                    </select>
                    <input type="search" name="myaltbirthplace" value="<?php echo $myaltbirthplace; ?>">
                </td>
            </tr>
            <tr<?php if ($tngconfig['hidechr']) {
                echo " style='display: none;'";
            } ?>>
                <td class="fieldnameback fieldname"><?php echo $text['altbirthdatetr']; ?>:</td>
                <td class="databack">
                    <select name="cyqualify" class="mediumfield">
                        <?php
                        $item2_array = [[$text['equals'], ""], [$text['plusminus2'], "pm2"], [$text['plusminus5'], "pm5"], [$text['plusminus10'], "pm10"], [$text['lessthan'], "lt"], [$text['greaterthan'], "gt"], [$text['lessthanequal'], "lte"], [$text['greaterthanequal'], "gte"], [$text['exists'], "exists"], [$text['dnexist'], "dnexist"]];
                        foreach ($item2_array as $item) {
                            echo "<option value=\"$item[1]\"";
                            if ($cyqualify == $item[1]) {
                                echo " selected";
                            }
                            echo ">$item[0]</option>\n";
                        }
                        ?>
                    </select>
                    <input type="text" name="myaltbirthyear" value="<?php echo $myaltbirthyear; ?>">
                </td>
            </tr>
            <tr>
                <td class="fieldnameback fieldname"><?php echo $text['deathplace']; ?>:</td>
                <td class="databack">
                    <select name="dpqualify" class="mediumfield">
                        <?php
                        foreach ($item_array as $item) {
                            echo "<option value=\"$item[1]\"";
                            if ($dpqualify == $item[1]) {
                                echo " selected";
                            }
                            echo ">$item[0]</option>\n";
                        }
                        ?>
                    </select>
                    <input type="search" name="mydeathplace" value="<?php echo $mydeathplace; ?>">
                </td>
            </tr>
            <tr>
                <td class="fieldnameback fieldname"><?php echo $text['deathdatetr']; ?>:</td>
                <td class="databack">
                    <select name="dyqualify" class="mediumfield">
                        <?php
                        $item2_array = [[$text['equals'], ""], [$text['plusminus2'], "pm2"], [$text['plusminus5'], "pm5"], [$text['plusminus10'], "pm10"], [$text['lessthan'], "lt"], [$text['greaterthan'], "gt"], [$text['lessthanequal'], "lte"], [$text['greaterthanequal'], "gte"], [$text['exists'], "exists"], [$text['dnexist'], "dnexist"]];
                        foreach ($item2_array as $item) {
                            echo "<option value=\"$item[1]\"";
                            if ($dyqualify == $item[1]) {
                                echo " selected";
                            }
                            echo ">$item[0]</option>\n";
                        }
                        ?>
                    </select>
                    <input type="text" name="mydeathyear" value="<?php echo $mydeathyear; ?>">
                </td>
            </tr>
            <tr>
                <td class="fieldnameback fieldname"><?php echo $text['burialplace']; ?>:</td>
                <td class="databack">
                    <select name="brpqualify" class="mediumfield">
                        <?php
                        foreach ($item_array as $item) {
                            echo "<option value=\"$item[1]\"";
                            if ($brpqualify == $item[1]) {
                                echo " selected";
                            }
                            echo ">$item[0]</option>\n";
                        }
                        ?>
                    </select>
                    <input type="search" name="myburialplace" value="<?php echo $myburialplace; ?>">
                </td>
            </tr>
            <tr>
                <td class="fieldnameback fieldname"><?php echo $text['burialdatetr']; ?>:</td>
                <td class="databack">
                    <select name="bryqualify" class="mediumfield">
                        <?php
                        $item2_array = [[$text['equals'], ""], [$text['plusminus2'], "pm2"], [$text['plusminus5'], "pm5"], [$text['plusminus10'], "pm10"], [$text['lessthan'], "lt"], [$text['greaterthan'], "gt"], [$text['lessthanequal'], "lte"], [$text['greaterthanequal'], "gte"], [$text['exists'], "exists"], [$text['dnexist'], "dnexist"]];
                        foreach ($item2_array as $item) {
                            echo "<option value=\"$item[1]\"";
                            if ($bryqualify == $item[1]) {
                                echo " selected";
                            }
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
                <td class="fieldnameback fieldname"><?php echo $text['spousesurname']; ?>*:</td>
                <td class="databack">
                    <select name="spqualify" class="mediumfield">
                        <?php
                        $item_array = [[$text['contains'], "contains"], [$text['equals'], "equals"], [$text['startswith'], "startswith"], [$text['endswith'], "endswith"], [$text['exists'], "exists"], [$text['dnexist'], "dnexist"], [$text['soundexof'], "soundexof"], [$text['metaphoneof'], "metaphoneof"]];
                        foreach ($item_array as $item) {
                            echo "<option value=\"$item[1]\"";
                            if ($spqualify == $item[1]) {
                                echo " selected";
                            }
                            echo ">$item[0]</option>\n";
                        }
                        ?>
                    </select>
                    <input type="search" name="mysplname" value="<?php echo $mysplname; ?>">
                </td>
            </tr>
        </table>
        <p class="smaller"><em>*<?php echo $text['spousemore']; ?></em></p>
        <input type="hidden" name="offset" value="0">

        <hr>
        <h3 class="subhead"><?php echo $text['otherevents']; ?></h3>
        <ul id="descendantchart" class="normal">
            <li id="expand" class="othersearch"><a href="#" onclick="return toggleSection(1);" class="nounderline"><img src="img/tng_expand.gif"
                                                                                                                        alt="" width="15"
                                                                                                                        height="15" class="exp-cont"><?php echo $text['clickdisplay']; ?>
                </a></li>
            <li id="contract" class="othersearch" style="display:none;"><a href="#" onclick="return toggleSection(0);" class="nounderline"><img
                        src="img/tng_collapse.gif" alt="" width="15" height="15"
                        class="exp-cont"><?php echo $text['clickhide']; ?></a></li>
        </ul>
        <table style="display:none;" id="otherevents">
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td><span class="normal"><?php echo $text['nickname']; ?>:</span></td>
                <td>
                    <select name="nnqualify" class="mediumfield">
                        <?php
                        foreach ($item_array as $item) {
                            echo "<option value=\"$item[1]\"";
                            if ($nnqualify == $item[1]) {
                                echo " selected";
                            }
                            echo ">$item[0]</option>\n";
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <input type="text" name="mynickname" value="<?php echo $mynickname; ?>">
                </td>
            </tr>
            <tr>
                <td><span class="normal"><?php echo $text['title']; ?>:</span></td>
                <td>
                    <select name="tqualify" class="mediumfield">
                        <?php
                        foreach ($item_array as $item) {
                            echo "<option value=\"$item[1]\"";
                            if ($tqualify == $item[1]) {
                                echo " selected";
                            }
                            echo ">$item[0]</option>\n";
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <input type="text" name="mytitle" value="<?php echo $mytitle; ?>">
                </td>
            </tr>
            <tr>
                <td><span class="normal"><?php echo $text['prefix']; ?>:</span></td>
                <td>
                    <select name="pfqualify" class="mediumfield">
                        <?php
                        foreach ($item_array as $item) {
                            echo "<option value=\"$item[1]\"";
                            if ($pfqualify == $item[1]) {
                                echo " selected";
                            }
                            echo ">$item[0]</option>\n";
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <input type="text" name="myprefix" value="<?php echo $myprefix; ?>">
                </td>
            </tr>
            <tr>
                <td><span class="normal"><?php echo $text['suffix']; ?>:</span></td>
                <td>
                    <select name="sfqualify" class="mediumfield">
                        <?php
                        foreach ($item_array as $item) {
                            echo "<option value=\"$item[1]\"";
                            if ($sfqualify == $item[1]) {
                                echo " selected";
                            }
                            echo ">$item[0]</option>\n";
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <input type="text" name="mysuffix" value="<?php echo $mysuffix; ?>">
                </td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
            <?php
            $eventtypes = [];
            $query = "SELECT eventtypeID, tag, display FROM $eventtypes_table WHERE keep='1' AND type=\"I\" ORDER BY display";
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
                echo "<tr><td colspan=\"3\"><span class='normal'>{$row['displaymsg']}</span></td></tr>\n";

                echo "<tr>\n";
                echo "<td><span class='normal'>&nbsp;&nbsp;&nbsp;{$text['fact']}:</span></td>\n";
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
                echo "<td><span class='normal'>&nbsp;&nbsp;&nbsp;{$text['place']}:</span></td>\n";
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
                echo "<td><span class='normal'>&nbsp;&nbsp;&nbsp;{$text['year']}:</span></td>\n";
                echo "<td>\n";
                echo "<select name=\"cyq{$row['eventtypeID']}\" class=\"mediumfield\">\n";

                $item2_array = [[$text['equals'], ""], [$text['plusminus2'], "pm2"], [$text['plusminus5'], "pm5"], [$text['plusminus10'], "pm10"], [$text['lessthan'], "lt"], [$text['greaterthan'], "gt"], [$text['lessthanequal'], "lte"], [$text['greaterthanequal'], "gte"], [$text['exists'], "exists"], [$text['dnexist'], "dnexist"]];
                foreach ($item2_array as $item) {
                    echo "<option value=\"$item[1]\"";
                    echo ">$item[0]</option>\n";
                }

                echo "</select>\n";
                echo "</td>\n";
                echo "<td><input type='text' name=\"cey{$row['eventtypeID']}\" value=\"\"></td>\n";
                echo "</tr>\n";
            }
            ?>
            <tr>
                <td colspan="3"><br>
                    <input type="button" value="<?php echo $text['search']; ?>" onclick="$('searchbtn').className='fieldnamebacksave';return makeURL();">
                    <input type="button"
                           value="<?php echo $text['resetall']; ?>"
                           onclick="resetValues();">
                </td>
            </tr>
        </table>
        <hr>
    </div>

    <div class="searchsidebar">
        <table>
            <tr>
                <td><span class="normal"><?php echo $text['joinwith']; ?>:</span></td>
                <td>
                    <select name="mybool">
                        <?php
                        $item3_array = [[$text['cap_and'], "AND"], [$text['cap_or'], "OR"]];
                        foreach ($item3_array as $item) {
                            echo "<option value=\"$item[1]\"";
                            if ($mybool == $item[1]) {
                                echo " selected";
                            }
                            echo ">$item[0]</option>\n";
                        }
                        ?>
                    </select>
                </td>
                <td></td>
            </tr>
            <tr>
                <td><span class="normal"><?php echo $text['numresults']; ?>:</span></td>
                <td>
                    <select name="nr">
                        <?php
                        $item3_array = [[50, 50], [100, 100], [150, 150], [200, 200]];
                        foreach ($item3_array as $item) {
                            echo "<option value=\"$item[1]\"";
                            if ($nr == $item[1]) {
                                echo " selected";
                            }
                            echo ">$item[0]</option>\n";
                        }
                        ?>
                    </select>
                </td>
                <td></td>
            </tr>
        </table>
        <p class="normal">
            <input type="checkbox" name="showdeath" value="yes"<?php if ($showdeath == "yes") {
                echo " checked";
            } ?> > <?php echo $text['showdeath']; ?><br>
            <input type="checkbox" name="showspouse" value="yes"<?php if ($showspouse == "yes") {
                echo " checked";
            } ?> > <?php echo $text['showspouse']; ?><br>
            <br>
            <input type="submit" id="searchbtn" class="btn" value="<?php echo $text['search']; ?>">
            <input type="button" id="resetbtn" class="btn" value="<?php echo $text['tng_reset']; ?>" onclick="resetValues();">
        </p>
        <br><br>
        <p>
            <a href="famsearchform.php" class="snlink">&raquo; <?php echo $text['searchfams']; ?></a>
            <a href="searchsite.php" class="snlink">&raquo; <?php echo $text['searchsitemenu']; ?></a>
        </p>
    </div>

    </form>
    <br style="clear: both;">
<?php
tng_footer("");
?>
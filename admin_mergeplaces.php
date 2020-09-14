<?php
include "begin.php";
include "adminlib.php";
$textpart = "findplace";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$tree) {
    $tree = $_COOKIE['tng_search_places_post']['tree'];
}
if ($place) {
    $useplace = addslashes($place);
    setcookie("tng_merge_places_post[place]", $useplace, 0);
    setcookie("tng_search_places_post[tree]", $tree, $exptime);
    if ($place2) {
        $useplace2 = addslashes($place2);
        setcookie("tng_merge_places_post[place2]", $useplace2, 0);
    }

    $pwherestr = "place LIKE \"%$useplace%\"";
    if ($place2) {
        $pwherestr = "($pwherestr OR place LIKE \"%$useplace2%\")";
    }
    $query = "SELECT ID, place, longitude, latitude, gedcom FROM $places_table
		WHERE ";
    if (!$tngconfig['places1tree']) {
        $query .= "gedcom = \"$tree\" AND ";
    }
    $query .= $pwherestr . " ORDER BY place, gedcom, ID";
    $result = tng_query($query);

    $numrows = tng_num_rows($result);
    if (!$numrows) {
        $message = $admtext['noresults'];
    }
} else {
    $numrows = 0;
    if ($_COOKIE['tng_merge_search_post']['search']) {
        $place = $_COOKIE['tng_search_places_post']['search'];
    } else {
        if ($_COOKIE['tng_merge_places_post']['place']) {
            $place = stripslashes($_COOKIE['tng_merge_places_post']['place']);
            $place2 = stripslashes($_COOKIE['tng_merge_places_post']['place2']);
        }
    }
}

$treequery = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";

$helplang = findhelp("places_help.php");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['mergeplaces'], $flags);
?>
<script type="text/javascript" src="js/mergeplaces.js"></script>
<script type="text/javascript">
    const enterplace = "<?php echo $admtext['enterplace']; ?>";
    const enterkeep = "<?php echo $admtext['enterkeep']; ?>";
    const successmsg = "<?php echo $admtext['pmsucc']; ?>";

    function resetFields() {
        document.form1.place.value = "";
        document.form1.place2.value = "";
        return false;
    }
</script>
</head>

<body background="img/background.gif">

<?php
$placetabs[0] = array(1, "admin_places.php", $admtext['search'], "findplace");
$placetabs[1] = array($allow_add, "admin_newplace.php", $admtext['addnew'], "addplace");
$placetabs[2] = [$allow_edit && $allow_delete, "admin_mergeplaces.php", $admtext['merge'], "merge"];
$placetabs[3] = [$allow_edit, "admin_geocodeform.php", $admtext['geocode'], "geo"];
$innermenu = "<a href=\"#\" onclick=\"return openHelp('$helplang/places_help.php#merge');\" class=\"lightlink\">{$admtext['help']}</a>";
$menu = doMenu($placetabs, "merge", $innermenu);
echo displayHeadline($admtext['places'] . " &gt;&gt; " . $admtext['mergeplaces'], "img/places_icon.gif", $menu, $message);
?>

<table width="100%" cellpadding="10" cellspacing="2" class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <h3 class="subhead">1. <?php echo $admtext['findmerge']; ?></h3>

            <form action="admin_mergeplaces.php" method="post" name="form1" onSubmit="return validateForm1();">
                <table class="normal">
                    <?php
                    if (!$tngconfig['places1tree']) {
                        ?>
                        <tr>
                            <td><?php echo $admtext['tree']; ?>:</td>
                            <td>
                                <select name="tree">
                                    <?php
                                    $treeresult = tng_query($treequery) or die ($admtext['cannotexecutequery'] . ": $treequery");
                                    while ($treerow = tng_fetch_assoc($treeresult)) {
                                        echo "		<option value=\"{$treerow['gedcom']}\"";
                                        if ($treerow['gedcom'] == $tree) {
                                            echo " selected";
                                        }
                                        echo ">{$treerow['treename']}</option>\n";
                                    }
                                    tng_free_result($treeresult);
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td><?php echo $admtext['searchfor']; ?>:</td>
                        <td><input type="text" name="place" size="50" value="<?php echo htmlspecialchars(stripslashes($place)); ?>"></td>
                    </tr>
                    <tr>
                        <td><?php echo $admtext['text_or']; ?>:</td>
                        <td><input type="text" name="place2" size="50" value="<?php echo htmlspecialchars(stripslashes($place2)); ?>"></td>
                    </tr>
                </table>
                <br>
                <input type="submit" name="submit" value="<?php echo $admtext['text_continue']; ?>">
                <input type="submit" name="reset" value="<?php echo $admtext['reset']; ?>" onclick="return resetFields()">
            </form>
            <?php
            if ($place && $numrows) {
                ?>
                <br><br>

                <h3 class="subhead">2. <?php echo $admtext['selectplacemerge']; ?></h3>

                <form action="" method="post" onSubmit="return validateForm2(this);" name="form2">
                    <p><input type="submit" value="<?php echo $admtext['mergeplaces']; ?>"> <img src="img/spinner.gif" id="placespin" style="display:none;">
                        <span id="successmsg1" class="normal msgapproved"></span></p>
                    <table cellpadding="3" cellspacing="1" class="normal">
                        <tr>
                            <th class="fieldnameback" valign="bottom" align="center"><span class="fieldname"><?php echo $admtext['mcol1']; ?></span></th>
                            <th class="fieldnameback" valign="bottom" align="center"><span class="fieldname"><?php echo $admtext['mcol2']; ?></span></th>
                            <th class="fieldnameback" valign="bottom"><span class="fieldname"><?php echo $admtext['place']; ?></span></th>
                            <th class="fieldnameback" valign="bottom" align="center"><span class="fieldname"><?php echo $admtext['latitude']; ?></span></th>
                            <th class="fieldnameback" valign="bottom" align="center"><span class="fieldname"><?php echo $admtext['longitude']; ?></span></th>
                        </tr>

                        <?php
                        while ($row = tng_fetch_assoc($result)) {
                            echo "<tr class=\"mergerows\" id=\"row_{$row['ID']}\">\n";
                            echo "<td class='lightback' valign=\"top\" align=\"center\"><input type=\"checkbox\" class=\"mc\" name=\"mc{$row['ID']}\" onclick=\"handleCheck({$row['ID']});\" value=\"{$row['ID']}\"></td>\n";
                            echo "<td class='lightback' valign=\"top\" align=\"center\"><input type=\"radio\" name=\"keep\" id=\"r{$row['ID']}\" onclick=\"handleRadio({$row['ID']});\" value=\"{$row['ID']}\"></td>\n";
                            $display = $row['place'];
                            $display = preg_replace("/</", "&lt;", $display);
                            $display = preg_replace("/>/", "&gt;", $display);
                            echo "<td class='lightback' valign=\"top\">$display&nbsp;</td>\n";
                            echo "<td class='lightback' valign=\"top\" id=\"lat_{$row['ID']}\">{$row['latitude']}&nbsp;</td>\n";
                            echo "<td class='lightback' valign=\"top\" id=\"long_{$row['ID']}\">{$row['longitude']}&nbsp;</td>\n";
                            echo "</tr>\n";
                        }
                        tng_free_result($result);
                        ?>
                    </table>
                    <br>
                    <input type="submit" value="<?php echo $admtext['mergeplaces']; ?>">
                    <span id="successmsg2" class="normal msgapproved"></span>
                </form>
                <?php
            }
            ?>
        </td>
    </tr>

</table>
<?php echo "<div align=\"right\"><span class='normal'>$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
<?php
include "begin.php";
include "config/importconfig.php";
include "adminlib.php";
$textpart = "trees";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_ged && $assignedtree) {
    $query = "SELECT disallowgedcreate FROM $trees_table WHERE gedcom = '$assignedtree'";
    $result = tng_query($query);
    $row = tng_fetch_assoc($result);
    $disallowgedcreate = $row['disallowgedcreate'];
    tng_free_result($result);

    if ($disallowgedcreate) {
        $message = $admtext['norights'];
        header("Location: admin_login.php?message=" . urlencode($message));
        exit;
    }
} else {
    $row = array();
    $row['gedcom'] = $row['branch'] = "";
}

if ($assignedtree) {
    $wherestr = "WHERE gedcom = \"$assignedtree\"";
} else {
    $wherestr = "";
}
$treequery = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";

$query = "SELECT branch, gedcom, description FROM $branches_table WHERE gedcom = \"{$row['gedcom']}\" ORDER BY description";
$branchresult = tng_query($query);

$helplang = findhelp("data_help.php");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['gedexport'], $flags);
?>
<script type="text/javascript">
    <?php
    include "branchlibjs.php";
    ?>

    function toggleStuff() {
        if (document.form1.exportmedia.checked == true)
            jQuery('#exprows').slideDown(400);
        else
            jQuery('#exprows').slideUp(400);
    }
</script>
</head>

<body background="img/background.gif">

<?php
$datatabs[0] = array(1, "admin_dataimport.php", $admtext['import'], "import");
$datatabs[1] = array($allow_ged, "admin_export.php", $admtext['export'], "export");
$datatabs[2] = array(1, "admin_secondmenu.php", $admtext['secondarymaint'], "second");
$innermenu = "<a href=\"#\" onclick=\"return openHelp('$helplang/data_help.php#export');\" class=\"lightlink\">{$admtext['help']}</a>";
$menu = doMenu($datatabs, "export", $innermenu);
echo displayHeadline($admtext['datamaint'] . " &gt;&gt; " . $admtext['gedexport'], "img/data_icon.gif", $menu, $message);
?>

<table width="100%" cellpadding="10" cellspacing="2" class="lightback normal">
    <tr class="databack">
        <td class="tngshadow">
            <form action="admin_gedcom2.php" method="post" name="form1">
                <table class="normal">
                    <tr>
                        <td><?php echo $admtext['tree']; ?>:</td>
                        <td>
                            <select name="tree" id="treeselect" onchange="swapBranches(document.form1);">
                                <?php
                                $treeresult = tng_query($treequery) or die ($admtext['cannotexecutequery'] . ": $treequery");
                                $firsttree = "";
                                while ($treerow = tng_fetch_assoc($treeresult)) {
                                    if (!$firsttree) {
                                        $firsttree = $treerow['gedcom'];
                                    }
                                    echo "	<option value=\"{$treerow['gedcom']}\"";
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
                    <tr>
                        <td><?php echo $admtext['branch']; ?>:</td>
                        <td>
                            <?php
                            $query = "SELECT branch, gedcom, description FROM $branches_table WHERE gedcom = \"$firsttree\" ORDER BY description";
                            $branchresult = tng_query($query);

                            echo "<select name=\"branch\" id=\"branch\" size=\"$selectnum\">\n";
                            echo "	<option value=\"\">{$admtext['allbranches']}</option>\n";
                            while ($branch = tng_fetch_assoc($branchresult)) {
                                echo "	<option value=\"{$branch['branch']}\"";
                                if ($row['branch'] == $branch['branch']) {
                                    echo " selected";
                                }
                                echo ">{$branch['description']}</option>\n";
                            }
                            echo "</select>\n";
                            ?>
                        </td>
                    </tr>
                </table>

                <br>

                <input type="checkbox" name="exliving" id="exliving" value="1">
                <label for="exliving"><?php echo $admtext['exliving']; ?></label> &nbsp;&nbsp;
                <input type="checkbox" name="exprivate" id="exprivate" value="1">
                <label for="exprivate"><?php echo $admtext['exprivate']; ?></label>
                <br><br>

                <input type="checkbox" name="exportmedia" id="exportmedia" value="1" onClick="toggleStuff();">
                <label for="exportmedia"><?php echo $admtext['exportmedia']; ?></label>

                <br>

                <div style="display:none;" id="exprows">
                    <table class="normal" cellspacing="10">
                        <tr>
                            <td><?php echo $admtext['select']; ?></td>
                            <td><?php echo $admtext['mediatypes']; ?></td>
                            <td><?php echo $admtext['exppaths']; ?>:</td>
                        </tr>
                        <?php
                        foreach ($mediatypes as $mediatype) {
                            $msgID = $mediatype['ID'];
                            switch ($msgID) {
                                case "photos":
                                    $value = strtok($locimppath['photos'], ",");
                                    break;
                                case "histories":
                                    $value = strtok($locimppath['histories'], ",");
                                    break;
                                case "documents":
                                    $value = strtok($locimppath['documents'], ",");
                                    break;
                                case "headstones":
                                    $value = strtok($locimppath['headstones'], ",");
                                    break;
                                default:
                                    if (isset($locimppath[$msgID])) {
                                        $value = strtok($locimppath[$msgID], ",");
                                    } else {
                                        $value = strtok($locimppath['other'], ",");
                                    }
                                    break;
                            }
                            echo "<tr>";
                            echo "<td><input type=\"checkbox\" name=\"incl_$msgID\" value='1' checked></td>\n";
                            echo "<td>" . $mediatype['display'] . ":</td>\n";
                            echo "<td><input type=\"text\" value=\"$value\" name=\"exp_path_$msgID\" class=\"verylongfield\"></td>";
                            echo "</tr>\n";
                        }
                        ?>
                    </table>
                </div>
                <br>
                <input type="submit" name="submit" class="btn" value="<?php echo $admtext['export']; ?>">
            </form>
        </td>
    </tr>

</table>
<?php echo "<div align=\"right\"><span class='normal'>$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>

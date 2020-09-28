<?php

include "begin.php";
include "adminlib.php";
require "./admin/trees.php";

$textpart = "trees";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_edit || ($assignedtree && $assignedtree != $tree)) {
    $message = $admtext['norights'];
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$row = getTree($trees_table, $tree);

$query = "SELECT count(personID) AS pcount FROM $people_table WHERE gedcom = '$tree'";
$result = tng_query($query);
$prow = tng_fetch_assoc($result);
$pcount = number_format($prow['pcount']);
tng_free_result($result);

$query = "SELECT count(familyID) AS fcount FROM $families_table WHERE gedcom = \"{$row['gedcom']}\"";
$famresult = tng_query($query);
$famrow = tng_fetch_assoc($famresult);
$fcount = number_format($famrow['fcount']);
tng_free_result($famresult);

$query = "SELECT count(sourceID) AS scount FROM $sources_table WHERE gedcom = \"{$row['gedcom']}\"";
$srcresult = tng_query($query);
$srcrow = tng_fetch_assoc($srcresult);
$scount = number_format($srcrow['scount']);
tng_free_result($srcresult);

$query = "SELECT count(repoID) AS rcount FROM $repositories_table WHERE gedcom = \"{$row['gedcom']}\"";
$reporesult = tng_query($query);
$reporow = tng_fetch_assoc($reporesult);
$rcount = number_format($reporow['rcount']);
tng_free_result($reporesult);

$query = "SELECT count(noteID) AS ncount FROM $xnotes_table WHERE gedcom = \"{$row['gedcom']}\"";
$nresult = tng_query($query);
$nrow = tng_fetch_assoc($nresult);
$ncount = number_format($nrow['ncount']);
tng_free_result($nresult);

$helplang = findhelp("trees_help.php");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['modifytree'], $flags);
?>
    <script>
        function validateForm() {
            let rval = true;
            if (document.form1.treename.value.length == 0) {
                alert("<?php echo $admtext['entertreename']; ?>");
                rval = false;
            }
            return rval;
        }
    </script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$allow_add_tree = $assignedtree ? 0 : $allow_add;
$treetabs[0] = [1, "admin_trees.php", $admtext['search'], "findtree"];
$treetabs[1] = [$allow_add_tree, "admin_newtree.php", $admtext['addnew'], "addtree"];
$treetabs[2] = [$allow_edit, "#", $admtext['edit'], "edit"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/trees_help.php#edit');\" class='lightlink'>{$admtext['help']}</a>";
$menu = doMenu($treetabs, "edit", $innermenu);
echo displayHeadline($admtext['trees'] . " &gt;&gt; " . $admtext['modifytree'], "img/trees_icon.gif", $menu, "");
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <form action="admin_updatetree.php" method="post" name="form1" onSubmit="return validateForm();">
                    <table class="normal">
                        <tr>
                            <td class='align-top'><?php echo $admtext['treeid']; ?>:</td>
                            <td><?php echo "$tree"; ?></td>
                            <td width="30" rowspan="11">&nbsp;&nbsp;&nbsp;</td>
                            <td class="align-top" rowspan="11">
                                <table class="normal">
                                    <?php
                                    echo "<tr>";
                                    echo "<td>{$admtext['people']}: </td>";
                                    echo "<td>&nbsp;</td>";
                                    echo "<td align=\"right\">$pcount</td>";
                                    echo "</tr>\n";
                                    echo "<tr>";
                                    echo "<td>{$admtext['families']}: </td>";
                                    echo "<td>&nbsp;</td>";
                                    echo "<td align=\"right\">$fcount</td>";
                                    echo "</tr>\n";
                                    echo "<tr>";
                                    echo "<td>{$admtext['sources']}: </td>";
                                    echo "<td>&nbsp;</td>";
                                    echo "<td align=\"right\">$scount</td>";
                                    echo "</tr>\n";
                                    echo "<tr>";
                                    echo "<td>{$admtext['repositories']}: </td>";
                                    echo "<td>&nbsp;</td>";
                                    echo "<td align=\"right\">$rcount</td>";
                                    echo "</tr>\n";
                                    echo "<tr>";
                                    echo "<td>{$admtext['notes']}: </td>";
                                    echo "<td>&nbsp;</td>";
                                    echo "<td align=\"right\">$ncount</td>";
                                    echo "</tr>\n";
                                    ?>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['treename']; ?>:</td>
                            <td>
                                <input type="text" name="treename" size="50" value="<?php echo $row['treename']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td class='align-top'><?php echo $admtext['description']; ?>:</td>
                            <td><textarea cols="40" rows="3" name="description"><?php echo $row['description']; ?></textarea></td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['owner']; ?>:</td>
                            <td>
                                <input type="text" name="owner" size="50" value="<?php echo $row['owner']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['email']; ?>:</td>
                            <td>
                                <input type="text" name="email" size="50" value="<?php echo $row['email']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['address']; ?>:</td>
                            <td>
                                <input type="text" name="address" size="50" value="<?php echo $row['address']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['city']; ?>:</td>
                            <td>
                                <input type="text" name="city" size="50" value="<?php echo $row['city']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['stateprov']; ?>:</td>
                            <td>
                                <input type="text" name="state" size="50" value="<?php echo $row['state']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['zip']; ?>:</td>
                            <td>
                                <input type="text" name="zip" size="50" value="<?php echo $row['zip']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['cap_country']; ?>:</td>
                            <td>
                                <input type="text" name="country" size="50" value="<?php echo $row['country']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['phone']; ?>:</td>
                            <td>
                                <input type="text" name="phone" size="50" value="<?php echo $row['phone']; ?>">
                            </td>
                        </tr>
                    </table>
                    <span class="normal">
<input type="checkbox" name="private" value="1"<?php if ($row['secret']) {
    echo " checked";
} ?>> <?php echo $admtext['keepprivate']; ?><br>
<input type="checkbox" name="disallowgedcreate" value="1"<?php if ($row['disallowgedcreate']) {
    echo " checked";
} ?>> <?php echo $admtext['gedcomextraction']; ?><br>
<input type="checkbox" name="disallowpdf" value="1"<?php if ($row['disallowpdf']) {
    echo " checked";
} ?>> <?php echo $admtext['nopdf']; ?>
<br><br></span>
                    <input type="hidden" name="tree" value="<?php echo "$tree"; ?>">
                    <input type="submit" name="submit" accesskey="s" class="btn" value="<?php echo $admtext['save']; ?>">
                </form>
            </td>
        </tr>

    </table>
<?php echo "<div style=\"text-align: center;\"><span class='normal'>$tng_title</span></div>"; ?>
    </body>
<?php echo "</html>"; ?>
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
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
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

tng_adminheader(_('Edit Existing Tree'), $flags);
?>
    <script>
        function validateForm() {
            let rval = true;
            if (document.form1.treename.value.length == 0) {
                alert("<?php echo _('Please enter a tree name.'); ?>");
                rval = false;
            }
            return rval;
        }
    </script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$allow_add_tree = $assignedtree ? 0 : $allow_add;
$treetabs[0] = [1, "admin_trees.php", _('Search'), "findtree"];
$treetabs[1] = [$allow_add_tree, "admin_newtree.php", _('Add New'), "addtree"];
$treetabs[2] = [$allow_edit, "#", _('Edit'), "edit"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/trees_help.php#edit');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($treetabs, "edit", $innermenu);
echo displayHeadline(_('Trees') . " &gt;&gt; " . _('Edit Existing Tree'), "img/trees_icon.gif", $menu, "");
?>
    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <form action="admin_updatetree.php" method="post" name="form1" onSubmit="return validateForm();">
                    <table class="normal">
                        <tr>
                            <td class='align-top'><?php echo _('Tree ID'); ?>:</td>
                            <td><?php echo "$tree"; ?></td>
                            <td width="30" rowspan="11">&nbsp;&nbsp;&nbsp;</td>
                            <td class="align-top" rowspan="11">
                                <table class="normal">
                                    <?php
                                    echo "<tr>";
                                    echo "<td>" . _('People') . ": </td>";
                                    echo "<td>&nbsp;</td>";
                                    echo "<td class='text-right'>$pcount</td>";
                                    echo "</tr>\n";
                                    echo "<tr>";
                                    echo "<td>" . _('Families') . ": </td>";
                                    echo "<td>&nbsp;</td>";
                                    echo "<td class='text-right'>$fcount</td>";
                                    echo "</tr>\n";
                                    echo "<tr>";
                                    echo "<td>" . _('Sources') . ": </td>";
                                    echo "<td>&nbsp;</td>";
                                    echo "<td class='text-right'>$scount</td>";
                                    echo "</tr>\n";
                                    echo "<tr>";
                                    echo "<td>" . _('Repositories') . ": </td>";
                                    echo "<td>&nbsp;</td>";
                                    echo "<td class='text-right'>$rcount</td>";
                                    echo "</tr>\n";
                                    echo "<tr>";
                                    echo "<td>" . _('Notes') . ": </td>";
                                    echo "<td>&nbsp;</td>";
                                    echo "<td class='text-right'>$ncount</td>";
                                    echo "</tr>\n";
                                    ?>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Tree Name'); ?>:</td>
                            <td>
                                <input type="text" name="treename" size="50" value="<?php echo $row['treename']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td class='align-top'><?php echo _('Description'); ?>:</td>
                            <td><textarea cols="40" rows="3" name="description"><?php echo $row['description']; ?></textarea></td>
                        </tr>
                        <tr>
                            <td><?php echo _('Owner'); ?>:</td>
                            <td>
                                <input type="text" name="owner" size="50" value="<?php echo $row['owner']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('E-mail'); ?>:</td>
                            <td>
                                <input type="text" name="email" size="50" value="<?php echo $row['email']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Address'); ?>:</td>
                            <td>
                                <input type="text" name="address" size="50" value="<?php echo $row['address']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('City'); ?>:</td>
                            <td>
                                <input type="text" name="city" size="50" value="<?php echo $row['city']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('State/Province'); ?>:</td>
                            <td>
                                <input type="text" name="state" size="50" value="<?php echo $row['state']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Zip/Postal Code'); ?>:</td>
                            <td>
                                <input type="text" name="zip" size="50" value="<?php echo $row['zip']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Country'); ?>:</td>
                            <td>
                                <input type="text" name="country" size="50" value="<?php echo $row['country']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Phone'); ?>:</td>
                            <td>
                                <input type="text" name="phone" size="50" value="<?php echo $row['phone']; ?>">
                            </td>
                        </tr>
                    </table>
                    <span class="normal">
                    <input type="checkbox" name="private" value="1"<?php if ($row['secret']) {
                        echo " checked";
                    } ?>> <?php echo _('Keep owner information private'); ?><br>
                    <input type="checkbox" name="disallowgedcreate" value="1"<?php if ($row['disallowgedcreate']) {
                        echo " checked";
                    } ?>> <?php echo _('Don\'t allow users to download GEDCOM files'); ?><br>
                    <input type="checkbox" name="disallowpdf" value="1"<?php if ($row['disallowpdf']) {
                        echo " checked";
                    } ?>> <?php echo _('Don\'t allow users to create PDF files'); ?>
                    <br><br></span>
                    <input type="hidden" name="tree" value="<?php echo "$tree"; ?>">
                    <input type="submit" name="submit" accesskey="s" class="btn" value="<?php echo _('Save'); ?>">
                </form>
            </td>
        </tr>

    </table>

<?php echo tng_adminfooter(); ?>
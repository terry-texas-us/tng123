<?php
include "begin.php";
include "config/mapconfig.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
$orgtree = $tree;
$helplang = findhelp("places_help.php");

tng_adminheader(_('Places'), $flags);

echo "</head>\n";
echo tng_adminlayout();

$placetabs[0] = [1, "admin_places.php", _('Search'), "findplace"];
$placetabs[1] = [$allow_add, "admin_newplace.php", _('Add New'), "addplace"];
$placetabs[2] = [$allow_edit && $allow_delete, "admin_mergeplaces.php", _('Merge'), "merge"];
$placetabs[3] = [$allow_edit, "admin_geocodeform.php", _('Geocode'), "geo"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/places_help.php#modify');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($placetabs, "geo", $innermenu);
echo displayHeadline(_('Places') . " &gt;&gt; " . _('Geocode'), "img/places_icon.gif", $menu, $message);
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <h3 class="subhead"><?php echo _('Geocode all Places without latitude and longitude coordinates'); ?></h3>

                <form action="admin_geocode.php" method="post" name="form1">
                    <?php
                    if ($tngconfig['places1tree']) {
                        echo "<input type='hidden' name=\"tree1\" value=\"\">\n";
                    }
                    ?>
                    <table class="normal">
                        <?php if (!$tngconfig['places1tree']) { ?>
                            <tr>
                                <td><?php echo _('Tree'); ?>:</td>
                                <td>
                                    <select name="tree1">
                                        <?php
                                        if ($assignedtree) {
                                            $wherestr = "WHERE gedcom = '$assignedtree'";
                                        } else {
                                            $wherestr = "";
                                        }
                                        $treequery = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";
                                        $treeresult = tng_query($treequery) or die (_('Cannot execute query') . ": $treequery");
                                    while ($treerow = tng_fetch_assoc($treeresult)) {
                                        echo "	<option value=\"{$treerow['gedcom']}\"";
                                        if ($treerow['gedcom'] == $tree) echo " selected";

                                        echo ">{$treerow['treename']}</option>\n";
                                    }
                                        tng_free_result($treeresult);
                                        ?>
                                    </select>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td><?php echo _('Limit:'); ?></td>
                            <td>
                                <select name="limit">
                                    <option value="10">10</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="250">250</option>
                                    <option value="500">500</option>
                                    <option value="1000">1000</option>
                                    <option value="2500">2500</option>
                                    <option value="5000">5000</option>
                                    <option value="10000">10000</option>
                                    <option value=""><?php echo _('No limit'); ?></option>
                                </select>
                            </td>
                            <td>
                                &nbsp; &nbsp;
                                <input type="checkbox" value="1" name="resetignore"> <?php echo _('Reset'); ?>
                            </td>
                        </tr>
                    </table>
                    <div class="normal">
                        <p><?php echo _('If multiple results are found for a place:'); ?></p>
                        <p>
                            <input type="radio" name="multiples" value="0" checked="checked"> <?php echo _('Ignore all'); ?> &nbsp;&nbsp;
                            <input type="radio" name="multiples" value="1"> <?php echo _('Use first match'); ?>
                        </p>
                        <input type="submit" accesskey="s" class="btn" value="<?php echo _('Geocode'); ?>">
                    </div>
                </form>
            </td>
        </tr>
    </table>
<?php echo tng_adminfooter(); ?>
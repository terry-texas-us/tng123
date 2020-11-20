<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";

if ($assignedtree) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

function getfiletime($filename) {
    global $fileflag, $time_offset;

    $filemodtime = "";
    if ($fileflag) {
        $filemod = filemtime($filename) + (3600 * $time_offset);
        $filemodtime = date("F j, Y h:i:s A", $filemod);
    }
    return $filemodtime;
}

function getfilesize($filename) {
    global $fileflag;

    $filesize = "";
    if ($fileflag) {
        $filesize = ceil(filesize($filename) / 1000) . " Kb";
    }
    return $filesize;
}

function doRow($table_name, $display_name) {
    global $admtext, $rootpath, $backuppath, $fileflag;

    echo "<tr>\n";
    echo "<td class='lightback'><div class='action-btns'><a href='#' onclick=\"return startOptimize('$table_name');\" title=\"" . _('Optimize') . "\" class=\"smallicon admin-opt-icon\"></a>";
    echo "<a href='#' onclick=\"return startBackup('$table_name');\" title=\"" . _('Back up') . "\" class=\"smallicon admin-save-icon\"></a>";
    $fileflag = $table_name && file_exists("$rootpath$backuppath/$table_name.bak");
    echo "<a href='#' id=\"rst_$table_name\" onclick=\"if( confirm('" . _('Are you sure you want to restore the selected tables?') . "') ) {startRestore('$table_name') ;} return false;\" title=\"" . _('Restore') . "\" class=\"smallicon admin-rest-icon\"";
    if (!$fileflag) echo " style=\"visibility:hidden\"";

    echo "></a>";
    echo "</div></td>";
    echo "<td class='lightback normal text-center'><input type='checkbox' class=\"tablechecks\" name=\"$table_name\" value='1' style=\"margin: 0; padding: 0;\"></td>\n";
    echo "<td class='lightback normal'>$display_name &nbsp;</td>\n";
    echo "<td class='lightback normal'><span id=\"time_$table_name\">" . getfiletime("$rootpath$backuppath/$table_name.bak") . "</span>&nbsp;</td>\n";
    echo "<td class='lightback normal' align=\"right\"><span id=\"size_$table_name\">" . getfilesize("$rootpath$backuppath/$table_name.bak") . "</span>&nbsp;</td>\n";
    echo "<td class='lightback normal'><span id=\"msg_$table_name\"></span>&nbsp;</td>\n";
    echo "</tr>\n";
}

$helplang = findhelp("backuprestore_help.php");

if (empty($sub)) $sub = "tables";

if (!isset($message)) $message = "";
tng_adminheader(_('Utilities'), $flags);
?>
<script>
    function toggleAll(flag) {
        for (var i = 0; i < document.form1.elements.length; i++) {
            if (document.form1.elements[i].type == "checkbox") {
                if (flag)
                    document.form1.elements[i].checked = true;
                else
                    document.form1.elements[i].checked = false;
            }
        }
    }

    function startUtility(sel) {
        if (sel.selectedIndex < 1) return false;
        var checks = jQuery('.tablechecks');
        var totalchecked = 0;
        checks.each(function (index, item) {
            if (item.checked) totalchecked = 1;

        });
        if (totalchecked) {
            var selval = sel.options[sel.selectedIndex].value;
            var form = document.form1;
            switch (selval) {
                case "backupall":
                    form.action = 'admin_backup.php';
                    form.submit();
                    break;
                case "optimizeall":
                    form.action = 'admin_optimize.php';
                    form.submit();
                    break;
                case "restoreall":
                    if (confirm('<?php echo _('Are you sure you want to restore the selected tables?'); ?>')) {
                        form.action = 'admin_restore.php';
                        form.submit();
                    }
                    break;
                case "delete":
                    if (confirm('<?php echo _('Are you sure you want to delete the selected backups?'); ?>')) {
                        form.table.value = 'del';
                        form.action = 'admin_backup.php?table=del';
                        form.submit();
                    }
                    break;
            }
        } else {
            alert('<?php echo _('Please select at least one table.'); ?>');
            sel.selectedIndex = 0;
        }
        return false;
    }

    function startBackup(table) {
        var params = {table: table};
        jQuery('#msg_' + table).html('<img src="img/spinner.gif">');
        jQuery.ajax({
            url: 'admin_backup.php',
            data: params,
            dataType: 'html',
            success: function (req) {
                var pairs = req.split('&');
                var table = pairs[0];
                var timestamp = pairs[1];
                var size = pairs[2];
                var message = pairs[3];
                jQuery('#msg_' + table).html(message);
                jQuery('#msg_' + table).effect('highlight', {}, 500);
                jQuery('#time_' + table).html(timestamp);
                jQuery('#time_' + table).effect('highlight', {}, 500);
                jQuery('#size_' + table).html(size);
                jQuery('#size_' + table).effect('highlight', {}, 500);
                jQuery('#rst_' + table).css('visibility', 'visible');
            }
        });
        return false;
    }

    function startOptimize(table) {
        var params = {table: table};
        jQuery('#msg_' + table).html('<img src="img/spinner.gif">');
        jQuery.ajax({
            url: 'admin_optimize.php',
            data: params,
            dataType: 'html',
            success: function (req) {
                var pairs = req.split('&');
                var table = pairs[0];
                var message = pairs[1];
                jQuery('#msg_' + table).html(message);
                jQuery('#msg_' + table).effect('highlight', {}, 500);
            }
        });
        return false;
    }

    function startRestore(table) {
        var params = {table: table};
        jQuery('#msg_' + table).html('<img src="img/spinner.gif">');
        jQuery.ajax({
            url: 'admin_restore.php',
            data: params,
            dataType: 'html',
            success: function (req) {
                var pairs = req.split('&');
                var table = pairs[0];
                var message = pairs[1];
                jQuery('#msg_' + table).html(message);
                jQuery('#msg_' + table).effect('highlight', {}, 500);
            }
        });
        return false;
    }
</script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$utiltabs['0'] = [1, "admin_utilities.php?sub=tables", _('Tables'), "tables"];
$utiltabs['1'] = [1, "admin_utilities.php?sub=structure", _('Table structure'), "structure"];
$utiltabs['2'] = [1, "admin_renumbermenu.php", _('Resequence IDs'), "renumber"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/backuprestore_help.php');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($utiltabs, $sub, $innermenu);
$headline = $sub == "tables" ? _('Utilities') . " &gt;&gt; " . _('Back up, Restore &amp; Optimize Table Data') : _('Utilities') . " &gt;&gt; " . _('Back up Table Structure');
echo displayHeadline($headline, "img/backuprestore_icon.gif", $menu, $message);
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <?php if ($sub == "tables") { ?>
                    <p class="normal">
                        <em><?php echo _('To back up, restore or optimize a table, click on the appropriate action icon for that table, or select multiple tables and apply that action to all selected by choosing the corresponding action at the top of the screen.'); ?></em>
                    </p>

                    <h3 class="subhead"><?php echo _('Back up, Restore &amp; Optimize Table Data'); ?></h3>
                    <p class="normal"><?php echo _('NOTE: If your database is very large, you might want to use an independent tool (like mysqldumper or phpMyAdmin) to back up and restore your tables. At least one of these should be available from your site control panel.'); ?></p>
                    <div class="normal">
                        <form action="" name="form1" id="form1" onsubmit="return startUtility(document.form1.withsel);">
                            <p>
                                <input type="hidden" name="table" value="all">
                                <input type="button" name="selectall" value="<?php echo _('Select All'); ?>" onclick="toggleAll(1);">
                                <input type="button" name="clearall" value="<?php echo _('Clear All'); ?>" onclick="toggleAll(0);">&nbsp;&nbsp;
                                <?php echo _('With selected:'); ?>
                                <select name="withsel">
                                    <option value=""></option>
                                    <option value="backupall"><?php echo _('Back up'); ?></option>
                                    <option value="optimizeall"><?php echo _('Optimize'); ?></option>
                                    <option value="restoreall"><?php echo _('Restore'); ?></option>
                                    <option value="delete"><?php echo _('Delete'); ?></option>
                                </select>
                                <input type="submit" name="go" value="<?php echo _('Go'); ?>">
                            </p>

                            <table class="normal">
                                <tr>
                                    <th class="fieldnameback fieldname"><?php echo _('Action'); ?></th>
                                    <th class="fieldnameback fieldname"><?php echo _('Select'); ?></th>
                                    <th class="fieldnameback fieldname"><?php echo _('Table'); ?></th>
                                    <th class="fieldnameback fieldname"><?php echo _('last backup more than xxx days ago'); ?></th>
                                    <th class="fieldnameback fieldname"><?php echo _('File Size'); ?></th>
                                    <th class="fieldnameback fieldname" style="width:200px;"><?php echo _('Message'); ?></th>
                                </tr>
                                <?php
                                doRow($address_table, _('Addresses'));
                                doRow($albums_table, _('Albums'));
                                doRow($album2entities_table, _('Album Links'));
                                doRow($albumlinks_table, _('Album Media'));
                                doRow($assoc_table, _('Associations'));
                                doRow($branches_table, _('Branches'));
                                doRow($branchlinks_table, _('Branch Links'));
                                doRow($cemeteries_table, _('Cemeteries'));
                                doRow($children_table, _('Children'));
                                doRow($countries_table, _('Countries'));
                                doRow($dna_groups_table, _('DNA Groups'));
                                doRow($dna_links_table, _('DNA Links'));
                                doRow($dna_tests_table, _('DNA Tests'));
                                doRow($events_table, _('Events'));
                                doRow($eventtypes_table, _('Event Types'));
                                doRow($families_table, _('Families'));
                                doRow($languages_table, _('Languages'));
                                doRow($media_table, _('Media Table'));
                                doRow($medialinks_table, _('Media Links'));
                                doRow($mediatypes_table, _('Media Types'));
                                doRow($mostwanted_table, _('Most Wanted'));
                                doRow($notelinks_table, _('Note Links'));
                                doRow($xnotes_table, _('Notes'));
                                doRow($people_table, _('People'));
                                doRow($places_table, _('Places'));
                                doRow($reports_table, _('Reports'));
                                doRow($sources_table, _('Sources'));
                                doRow($repositories_table, _('Repositories'));
                                doRow($citations_table, _('Citations'));
                                doRow($states_table, _('States'));
                                doRow($temp_events_table, _('Temp Events'));
                                doRow($templates_table, _('Template Settings'));
                                doRow($tlevents_table, _('Timeline Events'));
                                doRow($trees_table, _('Trees'));
                                doRow($users_table, _('Users'));
                                ?>
                            </table>
                        </form>

                    </div>
                <?php } elseif ($sub == "structure") { ?>
                    <p class="normal"><em><?php echo _('To back up or restore the table structure, click on the appropriate action icon below. WARNING: Restoring the table structure will delete all existing data!'); ?></em></p>

                    <h3 class="subhead"><?php echo _('Back up Table Structure'); ?></h3>
                    <div class="normal">
                        <table class="normal">
                            <tr>
                                <th class="fieldnameback"><span class="fieldname"><?php echo _('Action'); ?></span></th>
                                <th class="fieldnameback"><span class="fieldname"><?php echo _('last backup more than xxx days ago'); ?></span></th>
                                <th class="fieldnameback"><span class="fieldname"><?php echo _('File Size'); ?></span></th>
                            </tr>
                            <tr>
                                <td class="lightback">
                                    <div class="action-btns2"><a href="admin_backup.php?table=struct" title="<?php echo _('Back up'); ?>" class="smallicon admin-save-icon"></a>
                                        <?php
                                        if (file_exists("$rootpath$backuppath/tng_tablestructure.bak")) {
                                            $fileflag = 1;
                                            ?>
                                            <a href="admin_restore.php?table=struct" onClick="return confirm('<?php echo _('Are you sure you want to restore the table structure? All existing data will be lost!'); ?>');" title="<?php echo _('Restore'); ?>"
                                                class="smallicon admin-rest-icon"></a>
                                            <?php
                                        } else {
                                            $fileflag = 0;
                                        }
                                    ?>
                                </div>
                            </td>
                            <?php
                            if ($fileflag) {
                                echo "<td class='lightback'><span class='normal'>&nbsp;" . getfiletime("$rootpath$backuppath/tng_tablestructure.bak") . "&nbsp;</span></td>\n";
                                echo "<td class='lightback' align=\"right\"><span class='normal'>&nbsp;" . getfilesize("$rootpath$backuppath/tng_tablestructure.bak") . "&nbsp;</span></td>\n";
                            } else {
                                echo "<td class='lightback'><span class='normal'>&nbsp;</span></td>\n";
                                echo "<td class='lightback' align=\"right\"><span class='normal'>&nbsp;</span></td>\n";
                            }
                            ?>
                        </tr>
                    </table>

                </div>
            <?php } ?>
        </td>
    </tr>
</table>
<?php echo tng_adminfooter(); ?>
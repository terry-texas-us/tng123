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

$query = "SELECT userID, description, username, gedcom, branch, allow_edit, allow_add, allow_delete, allow_living, allow_lds, allow_ged, realname, email, DATE_FORMAT(dt_registered,\"%d %b %Y %H:%i:%s\") AS dt_registered_fmt FROM $users_table WHERE allow_living = '-1' ORDER BY dt_registered DESC";
$result = tng_query($query);

$numrows = tng_num_rows($result);

$helplang = findhelp("users_help.php");

tng_adminheader(_('Users'), $flags);
?>
<script>
    function confirmDelete(ID) {
        if (confirm('<?php echo _('Are you sure you want to delete this user?'); ?>'))
            deleteIt('user', ID);
        return false;
    }
</script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$usertabs[0] = [1, "admin_users.php", _('Search'), "finduser"];
$usertabs[1] = [$allow_add, "admin_newuser.php", _('Add New'), "adduser"];
$usertabs[2] = [$allow_edit, "admin_reviewusers.php", _('Review') . $revstar, "review"];
$usertabs[3] = [1, "admin_mailusers.php", _('E-mail'), "mail"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/users_help.php#addreg');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($usertabs, "review", $innermenu);
echo displayHeadline(_('Users') . " &gt;&gt; " . _('Review'), "img/users_icon.gif", $menu, $message);
?>

<table class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <div class="normal">
                <em><?php echo _('Process records for newly registered users. New users have no rights until registrations are processed.'); ?></em><br><br>
                <?php echo "<p>" . _('Matches') . ": <span class='restotal'>$numrows</span></p>"; ?>
                <form action="admin_deleteselected.php" method="post" name="form2">
                    <?php if ($allow_delete) { ?>
                        <p>
                            <input type="button" name="selectall" value="<?php echo _('Select All'); ?>" onClick="toggleAll(1);">
                            <input type="button" name="clearall" value="<?php echo _('Clear All'); ?>" onClick="toggleAll(0);">
                            <input type="submit" name="xruseraction" value="<?php echo _('Delete Selected'); ?>" onClick="return confirm('<?php echo _('Are you sure you want to delete the selected records?'); ?>');">
                        </p>
                    <?php } ?>

                    <table class="normal">
                        <tr>
                            <th class="fieldnameback fieldname"><?php echo _('Action'); ?></th>
                            <?php if ($allow_delete) { ?>
                                <th class="fieldnameback fieldname"><?php echo _('Select'); ?></th>
                            <?php } ?>
                            <th class="fieldnameback fieldname"><?php echo _('Username'); ?></th>
                            <th class="fieldnameback fieldname"><?php echo _('Description'); ?></th>
                            <th class="fieldnameback fieldname"><?php echo _('Real Name') . " / " . _('E-mail'); ?></th>
                            <th class="fieldnameback fieldname"><?php echo _('Date Registered'); ?></th>
                        </tr>

                        <?php
                        if ($numrows) {
                        $actionstr = "";
                        if ($allow_edit) {
                            $actionstr .= "<a href=\"admin_edituser.php?newuser=1&amp;userID=xxx\" title=\"" . _('Edit') . "\" class='smallicon admin-edit-icon'></a>";
                        }
                        if ($allow_delete) {
                            $actionstr .= "<a href='#' onClick=\"return confirmDelete('xxx');\" title=\"" . _('Delete') . "\" class='smallicon admin-delete-icon'></a>";
                        }

                        while ($row = tng_fetch_assoc($result)) {
                            $newactionstr = preg_replace("/xxx/", $row['userID'], $actionstr);
                            echo "<tr id=\"row_{$row['userID']}\"><td class='lightback' nowrap><span class='normal'>{$newactionstr}</span></td>\n";
                            if ($allow_delete) {
                                echo "<td class='lightback text-center'><input type='checkbox' name=\"del{$row['userID']}\" value='1'></td>";
                            }
                            echo "<td class='lightback' nowrap><span class='normal'>{$row['username']}&nbsp;</span></td>\n";
                            echo "<td class='lightback'><span class='normal'>{$row['description']}&nbsp;</span></td>\n";
                            echo "<td class='lightback'><span class='normal'>{$row['realname']}";
                            if ($row['realname'] && $row['email']) echo "<br>";

                            echo "<a href=\"mailto:" . $row['email'] . "\">" . $row['email'] . "</a>&nbsp;</span></td>\n";
                            echo "<td class='lightback'><span class='normal'>{$row['dt_registered_fmt']}&nbsp;</span></td>\n";
                        }
                        ?>
                    </table>
                <?php
                echo "<p>" . _('Matches') . ": <span class=\"restotal\">$numrows</span></p>";
                }
                else {
                    echo _('No records exist.');
                }
                tng_free_result($result);
                ?>
                </form>

            </div>
        </td>
    </tr>

</table>
<?php echo tng_adminfooter(); ?>

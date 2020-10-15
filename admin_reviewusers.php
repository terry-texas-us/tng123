<?php
include "begin.php";
include "adminlib.php";
$textpart = "users";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";

if ($assignedtree) {
    $message = $admtext['norights'];
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$query = "SELECT userID, description, username, gedcom, branch, allow_edit, allow_add, allow_delete, allow_living, allow_lds, allow_ged, realname, email, DATE_FORMAT(dt_registered,\"%d %b %Y %H:%i:%s\") AS dt_registered_fmt FROM $users_table WHERE allow_living = '-1' ORDER BY dt_registered DESC";
$result = tng_query($query);

$numrows = tng_num_rows($result);

$helplang = findhelp("users_help.php");

tng_adminheader($admtext['users'], $flags);
?>
<script>
    function confirmDelete(ID) {
        if (confirm('<?php echo $admtext['confuserdelete']; ?>'))
            deleteIt('user', ID);
        return false;
    }
</script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$usertabs[0] = [1, "admin_users.php", $admtext['search'], "finduser"];
$usertabs[1] = [$allow_add, "admin_newuser.php", $admtext['addnew'], "adduser"];
$usertabs[2] = [$allow_edit, "admin_reviewusers.php", $admtext['review'] . $revstar, "review"];
$usertabs[3] = [1, "admin_mailusers.php", $admtext['email'], "mail"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/users_help.php#addreg');\" class='lightlink'>{$admtext['help']}</a>";
$menu = doMenu($usertabs, "review", $innermenu);
echo displayHeadline($admtext['users'] . " &gt;&gt; " . $admtext['review'], "img/users_icon.gif", $menu, $message);
?>

<table class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <div class="normal">
                <em><?php echo $admtext['editnewusers']; ?></em><br><br>
                <?php echo "<p>{$admtext['matches']}: <span class='restotal'>$numrows</span></p>"; ?>
                <form action="admin_deleteselected.php" method="post" name="form2">
                    <?php if ($allow_delete) { ?>
                        <p>
                            <input type="button" name="selectall" value="<?php echo $admtext['selectall']; ?>" onClick="toggleAll(1);">
                            <input type="button" name="clearall" value="<?php echo $admtext['clearall']; ?>" onClick="toggleAll(0);">
                            <input type="submit" name="xruseraction" value="<?php echo $admtext['deleteselected']; ?>" onClick="return confirm('<?php echo $admtext['confdeleterecs']; ?>');">
                        </p>
                    <?php } ?>

                    <table class="normal">
                        <tr>
                            <th class="fieldnameback fieldname"><?php echo $admtext['action']; ?></th>
                            <?php if ($allow_delete) { ?>
                                <th class="fieldnameback fieldname"><?php echo $admtext['select']; ?></th>
                            <?php } ?>
                            <th class="fieldnameback fieldname"><?php echo $admtext['username']; ?></th>
                            <th class="fieldnameback fieldname"><?php echo $admtext['description']; ?></th>
                            <th class="fieldnameback fieldname"><?php echo $admtext['realname'] . " / " . $admtext['email']; ?></th>
                            <th class="fieldnameback fieldname"><?php echo $admtext['dtregistered']; ?></th>
                        </tr>

                        <?php
                        if ($numrows) {
                        $actionstr = "";
                        if ($allow_edit) {
                            $actionstr .= "<a href=\"admin_edituser.php?newuser=1&amp;userID=xxx\" title=\"{$admtext['edit']}\" class='smallicon admin-edit-icon'></a>";
                        }
                        if ($allow_delete) {
                            $actionstr .= "<a href='#' onClick=\"return confirmDelete('xxx');\" title=\"{$admtext['text_delete']}\" class='smallicon admin-delete-icon'></a>";
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
                echo "<p>{$admtext['matches']}: <span class=\"restotal\">$numrows</span></p>";
                }
                else {
                    echo $admtext['norecords'];
                }
                tng_free_result($result);
                ?>
                </form>

            </div>
        </td>
    </tr>

</table>
<?php echo tng_adminfooter(); ?>

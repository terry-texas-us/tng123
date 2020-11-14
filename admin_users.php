<?php

include "begin.php";
include "adminlib.php";
require_once "admin/pagination.php";
$textpart = "users";
include "$mylanguage/admintext.php";
$admin_login = 1;
include "checklogin.php";
include "version.php";
if ($assignedtree) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$tng_search_users = $_SESSION['tng_search_users'] = 1;
if ($newsearch) {
    $exptime = 0;
    $searchstring = stripslashes(trim($searchstring));
    setcookie("tng_search_users_post[search]", $searchstring, $exptime);
    setcookie("tng_search_users_post[adminonly]", $adminonly, $exptime);
    setcookie("tng_search_users_post[tngpage]", 1, $exptime);
    setcookie("tng_search_users_post[offset]", 0, $exptime);
} else {
    if (!$searchstring) {
        $searchstring = stripslashes($_COOKIE['tng_search_users_post']['search']);
    }
    if (!$adminonly) {
        $adminonly = $_COOKIE['tng_search_users_post']['adminonly'];
    }
    if (!isset($offset)) {
        $tngpage = $_COOKIE['tng_search_users_post']['tngpage'];
        $offset = $_COOKIE['tng_search_users_post']['offset'];
    } else {
        $exptime = 0;
        setcookie("tng_search_users_post[tngpage]", $tngpage, $exptime);
        setcookie("tng_search_users_post[offset]", $offset, $exptime);
    }
}

if ($offset) {
    $offsetplus = $offset + 1;
    $newoffset = "$offset, ";
} else {
    $offsetplus = 1;
    $newoffset = "";
    $tngpage = 1;
}

$wherestr = $searchstring ? " AND (username LIKE \"%$searchstring%\" OR description LIKE \"%$searchstring%\" OR realname LIKE \"%$searchstring%\" OR email LIKE \"%$searchstring%\")" : "";
$wherestr .= $adminonly ? " AND allow_add = '1' AND allow_edit = '1' AND allow_delete = '1' AND gedcom = \"\"" : "";
$query = "SELECT *, DATE_FORMAT(lastlogin,\"%d %b %Y %H:%i:%s\") AS lastlogin FROM $users_table WHERE allow_living != '-1' $wherestr ORDER BY description LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);

$numrows = tng_num_rows($result);
if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $query = "SELECT count(userID) AS ucount FROM $users_table WHERE allow_living != '-1' $wherestr";
    $result2 = tng_query($query);
    $row = tng_fetch_assoc($result2);
    $totrows = $row['ucount'];
    tng_free_result($result2);
} else {
    $totrows = $numrows;
}

$revquery = "SELECT count(userID) AS ucount FROM $users_table WHERE allow_living = \"-1\"";
$revresult = tng_query($revquery) or die (_('Cannot execute query') . ": $revquery");
$revrow = tng_fetch_assoc($revresult);
$revstar = $revrow['ucount'] ? " *" : "";
tng_free_result($revresult);

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
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/users_help.php');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($usertabs, "finduser", $innermenu);
echo displayHeadline(_('Users'), "img/users_icon.gif", $menu, $message);
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <div class="normal">

                    <form action="admin_users.php" name="form1">
                        <table class="normal">
                            <tr>
                                <td><?php echo _('Search for'); ?>:</td>
                                <td>
                                    <input class="longfield" name="searchstring" type="search" value="<?php echo $searchstring; ?>">
                                </td>
                                <td>
                                    <input type="submit" name="submit" value="<?php echo _('Search'); ?>" class="align-top">
                                    <input type="submit" name="submit" value="<?php echo _('Reset'); ?>" onClick="document.form1.searchstring.value=''; document.form1.adminonly.checked=false;"
                                        class="align-top">
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td colspan="2">
                                    <input type="checkbox" name="adminonly" value="yes"<?php if ($adminonly == "yes") {
                                        echo " checked";
                                    } ?>> <?php echo _('Show Admin users only'); ?>
                                </td>
                            </tr>
                        </table>

                        <input type="hidden" name="finduser" value="1">
                        <input type="hidden" name="newsearch" value="1">
                    </form>
                    <?php
                    $numrowsplus = $numrows + $offset;
                    if (!$numrowsplus) $offsetplus = 0;
                ?>
                <form action="admin_deleteselected.php" method="post" name="form2">
                    <?php if ($allow_delete) { ?>
                        <p>
                            <input type="button" name="selectall" value="<?php echo _('Select All'); ?>" onClick="toggleAll(1);">
                            <input type="button" name="clearall" value="<?php echo _('Clear All'); ?>" onClick="toggleAll(0);">
                            <input type="submit" name="xuseraction" value="<?php echo _('Delete Selected'); ?>" onClick="return confirm('<?php echo _('Are you sure you want to delete the selected records?'); ?>');">
                        </p>
                    <?php } ?>

                    <table class="normal">
                        <tr>
                            <th class="fieldnameback"><span class="fieldname"><?php echo _('Action'); ?></span></th>
                            <?php if ($allow_delete) { ?>
                                <th class="fieldnameback"><span class="fieldname"><?php echo _('Select'); ?></span></th>
                            <?php } ?>
                            <th class="fieldnameback fieldname whitespace-no-wrap"><?php echo _('Username'); ?></th>
                            <th class="fieldnameback fieldname whitespace-no-wrap"><?php echo _('Description'); ?></th>
                            <th class="fieldnameback fieldname whitespace-no-wrap"><?php echo _('Real Name') . " / " . _('E-mail'); ?></th>
                            <th class="fieldnameback fieldname whitespace-no-wrap"><?php echo _('Tree'); ?></th>
                            <th class="fieldnameback fieldname whitespace-no-wrap"><?php echo _('Branch'); ?></th>
                            <th class="fieldnameback fieldname whitespace-no-wrap"><?php echo _('Role'); ?></th>
                            <th class="fieldnameback fieldname whitespace-no-wrap"><?php echo _('Living'); ?></th>
                            <th class="fieldnameback fieldname whitespace-no-wrap"><?php echo _('Private'); ?></th>
                            <th class="fieldnameback fieldname whitespace-no-wrap">GED</th>
                            <th class="fieldnameback fieldname whitespace-no-wrap">PDF</th>
                            <th class="fieldnameback fieldname whitespace-no-wrap"><?php echo _('LDS'); ?></th>
                            <th class="fieldnameback fieldname whitespace-no-wrap"><?php echo _('Last Login'); ?></th>
                            <th class="fieldnameback fieldname whitespace-no-wrap"><?php echo _('Disabled'); ?></th>
                        </tr>

                        <?php
                        if ($numrows) {
                        $actionstr = "";
                        if ($allow_edit) {
                            $actionstr .= "<a href=\"admin_edituser.php?userID=xxx\" title=\"" . _('Edit') . "\" class='smallicon admin-edit-icon'></a>";
                        }
                        if ($allow_delete) {
                            $actionstr .= "<a href='#' onClick=\"return confirmDelete('xxx');\" title=\"" . _('Delete') . "\" class='smallicon admin-delete-icon'></a>";
                        }

                        while ($row = tng_fetch_assoc($result)) {
                            $form_allow_admin = $row['gedcom'] || (!$row['allow_edit'] && !$row['allow_add'] && !$row['allow_delete']) ? "" : _('Yes');
                            $form_allow_lds = $row['allow_lds'] ? _('Yes') : "";
                            $form_allow_living = $row['allow_living'] > 0 ? _('Yes') : "";
                            $form_allow_private = $row['allow_private'] > 0 ? _('Yes') : "";
                            $form_allow_ged = $row['allow_ged'] ? _('Yes') : "";
                            $form_allow_pdf = $row['allow_pdf'] ? _('Yes') : "";
                            $form_disabled = $row['disabled'] ? _('Yes') : "";
                            $newactionstr = preg_replace("/xxx/", $row['userID'], $actionstr);
                            echo "<tr id=\"row_{$row['userID']}\"><td class='lightback'><div class=\"action-btns2\">$newactionstr</div></td>\n";
                            if ($allow_delete) {
                                echo "<td class='lightback text-center'><input type='checkbox' name=\"del{$row['userID']}\" value='1'></td>";
                            }
                            $editlink = "admin_edituser.php?userID={$row['userID']}";
                            $username = $allow_edit ? "<a href=\"$editlink\" title=\"" . _('Edit') . "\">" . $row['username'] . "</a>" : $row['username'];
                            echo "<td class='lightback' nowrap>$username</td>\n";
                            echo "<td class='lightback'>{$row['description']}</td>\n";
                            echo "<td class='lightback'>{$row['realname']}";
                            if ($row['realname'] && $row['email']) {
                                echo "<br>";
                            }
                            $rolestr = 'usr' . ($row['role'] ? $row['role'] : 'custom');
                            echo "<a href=\"mailto:" . $row['email'] . "\">" . $row['email'] . "</a></td>\n";
                            echo "<td class='lightback whitespace-no-wrap'>{$row['gedcom']}</td>\n";
                            echo "<td class='lightback whitespace-no-wrap'>{$row['branch']}</td>\n";
                            echo "<td class='lightback whitespace-no-wrap'>{$admtext[$rolestr]}</td>\n";
                            echo "<td class='lightback whitespace-no-wrap'>$form_allow_living</td>\n";
                            echo "<td class='lightback whitespace-no-wrap'>$form_allow_private</td>\n";
                            echo "<td class='lightback whitespace-no-wrap'>$form_allow_ged</td>\n";
                            echo "<td class='lightback whitespace-no-wrap'>$form_allow_pdf</td>\n";
                            echo "<td class='lightback whitespace-no-wrap'>$form_allow_lds</td>\n";
                            echo "<td class='lightback whitespace-no-wrap'>{$row['lastlogin']}</td>\n";
                            echo "<td class='lightback whitespace-no-wrap'>$form_disabled</td>\n";
                            echo "</tr>\n";
                        }
                        ?>
                    </table>
                <?php
                echo "<div class='w-full class=lg:flex my-6'>";
                echo getPaginationLocationHtml($offsetplus, $numrowsplus, $totrows);
                echo getPaginationControlsHtml($totrows, "admin_users.php?searchstring=$searchstring&amp;offset", $maxsearchresults, 3);
                echo "</div>";
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
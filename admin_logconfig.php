<?php
include "begin.php";
include "config/logconfig.php";
include "adminlib.php";

if ($link) {
    $admin_login = 1;
    include "checklogin.php";
    include "version.php";
    if ($assignedtree || !$allow_edit) {
        $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
        header("Location: admin_login.php?message=" . urlencode($message));
        exit;
    }

    $query = "SELECT gedcom, treename FROM $trees_table ORDER BY treename";
    $result = @tng_query($query);
} else {
    $result = false;
}

$helplang = findhelp("logconfig_help.php");

tng_adminheader(_('Modify Log Configuration Settings'), $flags);

echo "</head>\n";
echo tng_adminlayout();

$setuptabs[0] = [1, "admin_setup.php", _('Configuration'), "configuration"];
$setuptabs[1] = [1, "admin_diagnostics.php", _('Diagnostics'), "diagnostics"];
$setuptabs[2] = [1, "admin_setup.php?sub=tablecreation", _('Table Creation'), "tablecreation"];
$setuptabs[3] = [1, "#", _('Log Settings'), "log"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/logconfig_help.php');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($setuptabs, "log", $innermenu);
echo displayHeadline(_('Setup') . " &gt;&gt; " . _('Configuration') . " &gt;&gt; " . _('Log Settings'), "img/setup_icon.gif", $menu, "");
?>

<table class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <form action="admin_updatelogconfig.php" method="post" name="form1">
                <table>
                    <tr>
                        <td class='align-top'><span class="normal"><?php echo _('Log File Name') . " " . _('(Public)'); ?>:</span></td>
                        <td>
                            <input type="text" value="<?php echo $logname; ?>" name="logname" size="20">
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'><span class="normal"><?php echo _('Max Log Lines') . " " . _('(Public)'); ?>:</span></td>
                        <td>
                            <input type="text" value="<?php echo $maxloglines; ?>" name="maxloglines" size="5">
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'><span class="normal"><?php echo _('Exclude Host Names'); ?>*:</span></td>
                        <td>
                            <input type="text" value="<?php echo $badhosts; ?>" name="badhosts" size="80">
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'><span class="normal"><?php echo _('Exclude Usernames'); ?>*:</span></td>
                        <td>
                            <input type="text" value="<?php echo $exusers; ?>" name="exusers" size="80">
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'><span class="normal"><?php echo _('Log File Name') . " " . _('(Admin)'); ?>:</span></td>
                        <td>
                            <input type="text" value="<?php echo $adminlogfile; ?>" name="adminlogfile" size="20">
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'><span class="normal"><?php echo _('Max Log Lines') . " " . _('(Admin)'); ?>:</span></td>
                        <td>
                            <input type="text" value="<?php echo $adminmaxloglines; ?>" name="adminmaxloglines" size="5">
                        </td>
                    </tr>
                    <tr>
                        <td class="align-top" colspan="2"><span class="normal"><br><?php echo _('Block suggestions or new user registrations where'); ?><br><br></span></td>
                    </tr>
                    <tr>
                        <td class='align-top'><span class="normal"><?php echo _('Address contains'); ?>*:</span></td>
                        <td>
                            <input type="text" value="<?php echo $addr_exclude; ?>" name="addr_exclude" size="80">
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'><span class="normal"><?php echo _('Message contains'); ?>*:</span></td>
                        <td>
                            <input type="text" value="<?php echo $msg_exclude; ?>" name="msg_exclude" size="80">
                        </td>
                    </tr>
                </table>
                <br>&nbsp;
                <input type="submit" name="submit" accesskey="s" class="btn" value="<?php echo _('Save'); ?>">
            </form>
            <p><span class="normal">*<?php echo _('Separate multiple entries with commas'); ?></span></p>
        </td>
    </tr>

</table>
<?php echo tng_adminfooter(); ?>

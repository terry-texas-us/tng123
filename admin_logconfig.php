<?php
include "begin.php";
include "config/logconfig.php";
include "adminlib.php";
$textpart = "setup";
include "$mylanguage/admintext.php";


if ($link) {
    $admin_login = 1;
    include "checklogin.php";
    include "version.php";
    if ($assignedtree || !$allow_edit) {
        $message = $admtext['norights'];
        header("Location: admin_login.php?message=" . urlencode($message));
        exit;
    }

    $query = "SELECT gedcom, treename FROM $trees_table ORDER BY treename";
    $result = @tng_query($query);
} else {
    $result = false;
}

$helplang = findhelp("logconfig_help.php");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['modifylogsettings'], $flags);

echo "</head>\n";
echo tng_adminlayout();

$setuptabs[0] = [1, "admin_setup.php", $admtext['configuration'], "configuration"];
$setuptabs[1] = [1, "admin_diagnostics.php", $admtext['diagnostics'], "diagnostics"];
$setuptabs[2] = [1, "admin_setup.php?sub=tablecreation", $admtext['tablecreation'], "tablecreation"];
$setuptabs[3] = [1, "#", $admtext['logconfigsettings'], "log"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/logconfig_help.php');\" class='lightlink'>{$admtext['help']}</a>";
$menu = doMenu($setuptabs, "log", $innermenu);
echo displayHeadline($admtext['setup'] . " &gt;&gt; " . $admtext['configuration'] . " &gt;&gt; " . $admtext['logconfigsettings'], "img/setup_icon.gif", $menu, "");
?>

<table class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <form action="admin_updatelogconfig.php" method="post" name="form1">
                <table>
                    <tr>
                        <td class='align-top'><span class="normal"><?php echo $admtext['logfilename'] . " " . $admtext['text_public']; ?>:</span></td>
                        <td>
                            <input type="text" value="<?php echo $logname; ?>" name="logname" size="20">
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'><span class="normal"><?php echo $admtext['maxloglines'] . " " . $admtext['text_public']; ?>:</span></td>
                        <td>
                            <input type="text" value="<?php echo $maxloglines; ?>" name="maxloglines" size="5">
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'><span class="normal"><?php echo $admtext['badhosts']; ?>*:</span></td>
                        <td>
                            <input type="text" value="<?php echo $badhosts; ?>" name="badhosts" size="80">
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'><span class="normal"><?php echo $admtext['exusers']; ?>*:</span></td>
                        <td>
                            <input type="text" value="<?php echo $exusers; ?>" name="exusers" size="80">
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'><span class="normal"><?php echo $admtext['logfilename'] . " " . $admtext['admin']; ?>:</span></td>
                        <td>
                            <input type="text" value="<?php echo $adminlogfile; ?>" name="adminlogfile" size="20">
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'><span class="normal"><?php echo $admtext['maxloglines'] . " " . $admtext['admin']; ?>:</span></td>
                        <td>
                            <input type="text" value="<?php echo $adminmaxloglines; ?>" name="adminmaxloglines" size="5">
                        </td>
                    </tr>
                    <tr>
                        <td class="align-top" colspan="2"><span class="normal"><br><?php echo $admtext['blockemail']; ?><br><br></span></td>
                    </tr>
                    <tr>
                        <td class='align-top'><span class="normal"><?php echo $admtext['addrcontains']; ?>*:</span></td>
                        <td>
                            <input type="text" value="<?php echo $addr_exclude; ?>" name="addr_exclude" size="80">
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'><span class="normal"><?php echo $admtext['msgcontains']; ?>*:</span></td>
                        <td>
                            <input type="text" value="<?php echo $msg_exclude; ?>" name="msg_exclude" size="80">
                        </td>
                    </tr>
                </table>
                <br>&nbsp;
                <input type="submit" name="submit" accesskey="s" class="btn" value="<?php echo $admtext['save']; ?>">
            </form>
            <p><span class="normal">*<?php echo $admtext['commas']; ?></span></p>
        </td>
    </tr>

</table>
<?php echo "<div style=\"text-align: center;\"><span class='normal'>$tng_title</span></div>"; ?>
</body>
</html>

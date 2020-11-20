<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
$helplang = findhelp("users_help.php");

tng_adminheader(_('E-mail Users'), $flags);
?>
    <script src="js/selectutils.js"></script>
    <script>
        <?php
        include "branchlibjs.php";
        ?>

        function validateForm() {
            let rval = true;
            if (document.form1.subject.value.length == 0) {
                alert("<?php echo _('Please enter a subject for your message.'); ?>");
                rval = false;
            } else if (document.form1.messagetext.value.length == 0) {
                alert("<?php echo _('Please enter the text of your message.'); ?>");
                rval = false;
            }
            return rval;
        }
    </script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$usertabs[0] = [1, "admin_users.php", _('Search'), "finduser"];
$usertabs[1] = [$allow_add, "admin_newuser.php", _('Add New'), "adduser"];
$usertabs[2] = [$allow_edit, "admin_reviewusers.php", _('Review') . $revstar, "review"];
$usertabs[3] = [1, "admin_mailusers.php", _('E-mail'), "mail"];
$innermenu = "<a href=\"javascript:newwindow=window.open('$helplang/users_help.php#add');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($usertabs, "mail", $innermenu);
echo displayHeadline(_('Users') . " &gt;&gt; " . _('E-mail Message To Users'), "img/users_icon.gif", $menu, $message);
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <form action="admin_sendmailusers.php" method="post" name="form1" onSubmit="return validateForm();">
                    <table>
                        <tr>
                            <td class='align-top'><span class="normal"><?php echo _('E-mail Subject'); ?>:</span></td>
                            <td><span class="normal"><input type="text" name="subject" size="50" maxlength="50"></span></td>
                        </tr>
                        <tr>
                            <td class='align-top'><span class="normal"><?php echo _('E-mail Text'); ?>:</span></td>
                            <td><span class="normal"><textarea cols="50" rows="15" name="messagetext"></textarea></span></td>
                        </tr>
                        <tr>
                            <td class="align-top" colspan="2"><span class="normal"><br><strong><?php echo _('Select group to receive e-mail (leave blank to send to all)'); ?></strong></span></td>
                        </tr>
                        <tr>
                            <td class='align-top'>
                                <span class="normal"><?php echo _('Tree'); ?>*:</span></td>
                            <td><span class="normal">
                            <select name="gedcom" id="gedcom" onChange="var tree=getTree(this); if( !tree ) tree = 'none'; <?php echo $swapbranches; ?>">
                                <option value=""></option>
                                    <?php
                                    $query = "SELECT gedcom, treename FROM $trees_table ORDER BY treename";
                                    $treeresult = tng_query($query);

                                    while ($treerow = tng_fetch_assoc($treeresult)) {
                                        echo "	<option value=\"{$treerow['gedcom']}\">{$treerow['treename']}</option>\n";
                                    }
                                    ?>
                            </select> </span>
                            </td>
                        </tr>
                        <tr>
                            <td class='align-top'><span class="normal"><?php echo _('Branch'); ?>**:</span></td>
                            <td><span class="normal">
                            <select name="branch" id="branch">
                                <option value=""></option>
                                <option value="" selected><?php echo _('No Branch'); ?></option>
                            </select>
		                </span></td>
                        </tr>
                    </table>
                    <br>
                    <input type="submit" name="submit" accesskey="s" class="btn" value="<?php echo _('Send E-mail'); ?>">
                </form>
                <br>
                <p class="normal">
                    <?php
                    echo "*" . _('Optional. Choosing a tree will restrict the message to users assigned to that tree.') . "<br>\n";
                    echo "**" . _('Optional. Choosing a branch will restrict the message to users assigned to that branch.') . "<br>\n";
                    ?>
                </p>
            </td>
        </tr>

    </table>

<?php echo tng_adminfooter(); ?>
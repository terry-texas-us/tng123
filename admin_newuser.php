<?php

include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if ($assignedtree || !$allow_add) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$query = "SELECT count(userID) AS ucount FROM $users_table";
$result = @tng_query($query);
if ($result) {
    $row = tng_fetch_assoc($result);
} else {
    $row['ucount'] = 0;
}

$revquery = "SELECT count(userID) AS ucount FROM $users_table WHERE allow_living = '1'";
$revresult = tng_query($revquery) or die (_('Cannot execute query') . ": $revquery");
$revrow = tng_fetch_assoc($revresult);
$revstar = $revrow['ucount'] ? " *" : "";
tng_free_result($revresult);

$helplang = findhelp("users_help.php");

tng_adminheader(_('Add New User'), $flags);
?>
<script src="js/selectutils.js"></script>
<script src="js/users.js"></script>
<script>
    <?php
    include "branchlibjs.php";
    ?>

    function validateForm(form) {
        let rval = true;
        if (form.description.value.length == 0) {
            alert("<?php echo _('Please enter a user description.'); ?>");
            form.description.focus();
            rval = false;
        } else if (form.username.value.length == 0) {
            alert("<?php echo _('Please enter a username.'); ?>");
            form.username.focus();
            rval = false;
        } else if (form.password.value.length == 0) {
            alert("<?php echo _('Please enter a password.'); ?>");
            form.password.focus();
            rval = false;
        } else if (form.email.value.length != 0 && !checkEmail(form.email.value)) {
            alert(enteremail);
            form.email.focus();
            rval = false;
        } else if (form.administrator[1].checked && form.gedcom.selectedIndex < 1) {
            alert("<?php echo _('Please select/add a tree.'); ?>");
            form.gedcom.focus();
            rval = false;
        }
        return rval;
    }

    var orgrealname = "xxx";
    var orgusername = "yyy";
    var orgpassword = "zzz";
    var enteremail = "<?php echo _('Please enter a valid e-mail address.'); ?>";
</script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$usertabs[0] = [1, "admin_users.php", _('Search'), "finduser"];
$usertabs[1] = [$allow_add, "admin_newuser.php", _('Add New'), "adduser"];
$usertabs[2] = [$allow_edit, "admin_reviewusers.php", _('Review') . $revstar, "review"];
$usertabs[3] = [1, "admin_mailusers.php", _('E-mail'), "mail"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/users_help.php#add');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($usertabs, "adduser", $innermenu);
echo displayHeadline(_('Users') . " &gt;&gt; " . _('Add New User'), "img/users_icon.gif", $menu, $message);
?>

<table class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <form action="admin_adduser.php" method="post" name="form1" onSubmit="return validateForm(this);">
                <table class="normal">
                    <tr>
                        <td><?php echo _('Description'); ?>:</td>
                        <td>
                            <input type="text" name="description" size="50" maxlength="50">
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo _('Username'); ?>:</td>
                        <td>
                            <input type="text" name="username" size="20" maxlength="100" onblur="checkNewUser(this,null);">
                            <span id="checkmsg" class="normal"></span>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo _('Password'); ?>:</td>
                        <td>
                            <input type="text" name="password" size="20" maxlength="100">
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo _('Real Name'); ?>:</td>
                        <td>
                            <input type="text" name="realname" size="50" maxlength="50">
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo _('Phone'); ?>:</td>
                        <td>
                            <input type="text" name="phone" size="30" maxlength="30">
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo _('E-mail'); ?>:</td>
                        <td>
                            <input type="text" name="email" size="50" maxlength="100" onblur="checkIfUnique(this);">
                            <span id="emailmsg"></span></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <input type="checkbox" name="no_email" value="1"> <?php echo _('Do not send mass e-mail to this user'); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo _('Web Site'); ?>:</td>
                        <td>
                            <input type="text" name="website" size="50" maxlength="128" value="http://">
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo _('Address'); ?>:</td>
                        <td>
                            <input type="text" name="address" size="50" maxlength="100">
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo _('City'); ?>:</td>
                        <td>
                            <input type="text" name="city" size="50" maxlength="64">
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo _('State/Province'); ?>:</td>
                        <td>
                            <input type="text" name="state" size="50" maxlength="64">
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo _('Zip/Postal Code'); ?>:</td>
                        <td>
                            <input type="text" name="zip" size="20" maxlength="10">
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo _('Country'); ?>:</td>
                        <td>
                            <input type="text" name="country" size="50" maxlength="64">
                        </td>
                    </tr>
                    <?php
                    $query = "SELECT languageID, display FROM $languages_table ORDER BY display";
                    $langresult = tng_query($query);
                    $numlangs = tng_num_rows($langresult);
                    if ($numlangs) {
                        ?>
                        <tr>
                            <td><?php echo _('Preferred language'); ?>:</td>
                            <td>
                                <select name="preflang">
                                    <option value="0"></option>
                                    <?php
                                    while ($langrow = tng_fetch_assoc($langresult)) {
                                        echo "	<option value=\"{$langrow['languageID']}\">{$langrow['display']}</option>\n";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <?php
                    }
                    tng_free_result($langresult);
                    ?>
                    <tr>
                        <td class='align-top'><?php echo _('Notes'); ?>:</td>
                        <td><textarea cols="50" rows="4" name="notes"></textarea></td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo _('Tree'); ?> / <?php echo _('Person ID'); ?>:
                        </td>
                        <td>
                            <select name="mynewgedcom">
                                <option value=""></option>
                                <?php
                                $treequery = "SELECT gedcom, treename FROM $trees_table ORDER BY treename";
                                $treeresult = tng_query($treequery);

                                while ($treerow = tng_fetch_assoc($treeresult)) {
                                    echo "	<option value=\"{$treerow['gedcom']}\">{$treerow['treename']}</option>\n";
                                }
                                ?>
                            </select>
                            <input type="text" name="personID" id="personID" size="20" maxlength="22"> &nbsp;<?php echo _('OR'); ?>&nbsp;
                            <a href="#"
                                onclick="return findItem('I','personID','',document.form1.mynewgedcom.options[document.form1.mynewgedcom.selectedIndex].value,'<?php echo $assignedbranch; ?>');"
                                title="<?php echo _('Find...'); ?>">
                                <img src="img/tng_find.gif" title="<?php echo _('Find...'); ?>" alt="<?php echo _('Find...'); ?>" class="align-middle" width="20" height="20"
                                    style="margin-left:2px;margin-bottom:4px;">
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <input type="checkbox" name="disabled" value="1">
                            <?php echo _('Disabled'); ?></br>
                            <input type="checkbox" name="consented" value="1"> <?php echo _('Consent given'); ?>
                        </td>
                    </tr>
                </table>
                <br><br>

                <div class="normal">
                    <table class="normal">
                        <tr>
                            <td class='align-top'>
                                <p><strong><?php echo _('Roles'); ?>:</strong></p>

                                <?php if ($row['ucount']) { ?>
                                    <p>
                                        <input type="radio" name="role" value="guest" checked="checked"
                                            onclick="assignRightsFromRole('guest');"> <?php echo _('Guest') . "<br><em class=\"smaller indent\">" . _('No add, edit or delete rights.') . " " . _('No access to Admin area.') . "</em>"; ?>
                                    </p>
                                    <p>
                                        <input type="radio" name="role" value="subm"
                                            onclick="assignRightsFromRole('subm');"> <?php echo _('Submitter') . "<br><em class=\"smaller indent\">" . _('Submit changes subject to review.') . " " . _('No access to Admin area.') . "</em>"; ?>
                                    </p>
                                    <p>
                                        <input type="radio" name="role" value="contrib"
                                            onclick="assignRightsFromRole('contrib');"> <?php echo _('Contributor') . "<br><em class=\"smaller indent\">" . _('Add information, including media.') . "</em>"; ?>
                                    </p>
                                    <p>
                                        <input type="radio" name="role" value="editor"
                                            onclick="assignRightsFromRole('editor');"> <?php echo _('Editor') . "<br><em class=\"smaller indent\">" . _('Add, edit and delete all information, including media.') . "</em>"; ?></p>
                                    <p>
                                        <input type="radio" name="role" value="mcontrib"
                                            onclick="assignRightsFromRole('mcontrib');"> <?php echo _('Media Contributor') . "<br><em class=\"smaller indent\">" . _('Add media only.') . "</em>"; ?>
                                    </p>
                                    <p>
                                        <input type="radio" name="role" value="meditor"
                                            onclick="assignRightsFromRole('meditor');"> <?php echo _('Media Editor') . "<br><em class=\"smaller indent\">" . _('Add, edit and delete media only.') . "</em>"; ?>
                                    </p>
                                    <p>
                                        <input type="radio" name="role" value="custom" onclick="assignRightsFromRole('custom');"> <?php echo _('Custom'); ?></p>
                                <?php } ?>
                                <p>
                                    <input type="radio" name="role" value="admin"<?php if (!$row['ucount']) {
                                        echo " checked";
                                    } ?> onclick="assignRightsFromRole('admin');"> <?php echo _('Administrator') . "<br><em class=\"smaller indent\">" . _('All rights.') . "</em>"; ?></p>
                            </td>
                            <td class='align-top'>
                                <p><strong><?php echo _('Rights:'); ?></strong></p>

                                <p>
                                    <input type="radio" name="form_allow_add" class="rights" value="1"<?php if (!$row['ucount']) {
                                        echo " checked";
                                    } ?> onclick="document.form1.role[6].checked='checked';"> <?php echo _('Allow to add any new data'); ?><br>
                                    <?php if ($row['ucount']) { ?>
                                        <input type="radio" name="form_allow_add" class="rights" value="3"
                                            onclick="document.form1.role[6].checked='checked';"> <?php echo _('Allow to add media only'); ?><br>
                                        <input type="radio" name="form_allow_add" class="rights" value="0" onclick="document.form1.role[6].checked='checked';"
                                            checked="checked"> <?php echo _('No add rights'); ?><br>
                                    <?php } ?>
                                </p>

                                <p>
                                    <input type="radio" name="form_allow_edit" class="rights" value="1"<?php if (!$row['ucount']) {
                                        echo " checked";
                                    } ?> onclick="document.form1.role[6].checked='checked';"> <?php echo _('Allow to edit any existing data'); ?><br>
                                    <?php if ($row['ucount']) { ?>
                                        <input type="radio" name="form_allow_edit" class="rights" value="3"
                                            onclick="document.form1.role[6].checked='checked';"> <?php echo _('Allow to edit media only'); ?><br>
                                        <input type="radio" name="form_allow_edit" class="rights" value="2"
                                            onclick="document.form1.role[6].checked='checked';"> <?php echo _('Allow to submit edits for administrative review (People, Families and Sources only)'); ?><br>
                                        <input type="radio" name="form_allow_edit" class="rights" value="0" onclick="document.form1.role[6].checked='checked';"
                                            checked="checked"> <?php echo _('No edit rights'); ?><br>
                                    <?php } ?>
                                </p>

                                <p>
                                    <input type="radio" name="form_allow_delete" class="rights" value="1"<?php if (!$row['ucount']) {
                                        echo " checked";
                                    } ?> onclick="document.form1.role[6].checked='checked';"> <?php echo _('Allow to delete any existing data'); ?><br>
                                    <?php if ($row['ucount']) { ?>
                                        <input type="radio" name="form_allow_delete" class="rights" value="3"
                                            onclick="document.form1.role[6].checked='checked';"> <?php echo _('Allow to delete media only'); ?><br>
                                        <input type="radio" name="form_allow_delete" class="rights" value="0" onclick="document.form1.role[6].checked='checked';"
                                            checked="checked"> <?php echo _('No delete rights'); ?><br>
                                    <?php } ?>
                                </p>

                                <br>
                                <hr>
                                <br>
                                <p>
                                    <input type="checkbox" name="form_allow_living" value="1"<?php if (!$row['ucount']) {
                                        echo " checked";
                                    } ?>> <?php echo _('Allow to view information for living individuals'); ?><br>
                                    <input type="checkbox" name="form_allow_private" value="1"<?php if (!$row['ucount']) {
                                        echo " checked";
                                    } ?>> <?php echo _('Allow to view information for private individuals'); ?><br>
                                    <input type="checkbox" name="form_allow_ged" value="1"<?php if (!$row['ucount']) {
                                        echo " checked";
                                    } ?>> <?php echo _('Allow to download GEDCOMs'); ?><br>
                                    <input type="checkbox" name="form_allow_pdf" value="1"<?php if (!$row['ucount']) {
                                        echo " checked";
                                    } ?>> <?php echo _('Allow to download PDFs'); ?><br>
                                    <input type="checkbox" name="form_allow_lds" value="1"<?php if (!$row['ucount']) {
                                        echo " checked";
                                    } ?>> <?php echo _('Allow to view LDS information'); ?><br>
                                    <input type="checkbox" name="form_allow_profile" value="1"<?php if (!$row['ucount']) {
                                        echo " checked";
                                    } ?>> <?php echo _('Allow to edit user profile and change password'); ?>
                                </p>
                            </td>
                        </tr>
                    </table>
                    <br><br>

                    <?php
                    if ($row['ucount']) {
                        echo "<strong>" . _('Access Limits:') . "</strong><br>\n";
                        ?>

                        <input type="radio" name="administrator" value="1" onclick="handleAdmin('allow');"> <?php echo _('Apply the above rights to all trees and branches.'); ?><br>
                        <input type="radio" name="administrator" value="0" checked="checked" onclick="handleAdmin('restrict');"> <?php echo _('Restrict the above rights to the following:'); ?><br>
                        <div id="restrictions">
                            <table>
                                <tr>
                                    <td class='align-top'>
                                        <span class="normal"><?php echo _('Tree'); ?>*:</span></td>
                                    <td>
                                        <select name="gedcom" id="treeselect" onChange="var tree=getTree(); if( !tree ) tree = 'none'; <?php echo $swapbranches; ?>">
                                            <option value=""></option>
                                            <?php
                                            $treeresult = tng_query($treequery);

                                            while ($treerow = tng_fetch_assoc($treeresult)) {
                                                echo "	<option value=\"{$treerow['gedcom']}\">{$treerow['treename']}</option>\n";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='align-top'><span class="normal"><?php echo _('Branch'); ?>**:</span></td>
                                    <td><span class="normal">
                                        <?php
                                        $query = "SELECT branch, gedcom, description FROM $branches_table WHERE gedcom = \"{$row['gedcom']}\" ORDER BY description";
                                        $branchresult = tng_query($query);

                                        echo "<select name='branch' id='branch'>\n";
                                        echo "	<option value='' selected>" . _('All Branches') . "</option>\n";
                                        if ($assignedtree) {
                                            while ($branch = tng_fetch_assoc($branchresult)) {
                                                echo "	<option value=\"{$branch['branch']}\">{$branch['description']}</option>\n";
                                            }
                                        }
                                        echo "</select>\n";
                                        ?>
                                    </span></td>
                                </tr>
                            </table>
                        </div>
                        <input type="radio" name="administrator" value="2" onclick="handleAdmin('allow_multiple');"> <?php echo _('Apply rights to multiple trees'); ?><br>
                        <div style="margin-left: 30px;display:none;" id="multiple">
                            <select multiple="yes" name="gedcom_mult[]" id="treeselect2">
                                <?php
                                $treeresult = tng_query($treequery);

                                while ($treerow = tng_fetch_assoc($treeresult)) {
                                    echo "	<option value=\"{$treerow['gedcom']}\">{$treerow['treename']}</option>\n";
                                }
                                tng_free_result($treeresult);
                                ?>
                            </select>
                        </div>
                        <?php
                    } else {
                        echo "<b>" . _('The first user you create will be an Administrator (NO tree selected) and will have access to all system settings.') . "</b><input type='hidden' name=\"gedcom\" value=\"\"><input type='hidden' name='branch' value=\"\">";
                    }
                    if ($numlangs <= 1) {
                        echo "<input type='hidden' name=\"preflang\" value='0'>\n";
                    }
                    ?>
                    <br>
                    <input type="checkbox" name="notify" value="1" onClick="replaceText();"> <?php echo _('Notify this user upon account activation'); ?><br>
                    <textarea name="welcome" rows="5" cols="50"
                        style="display:none;"><?php echo "" . _('Hello') . " xxx,\r\n\r\n" . _('Your genealogy user account has been activated.') . " " . _('Your login information is') . ":\r\n\r\n" . _('Username') . ": yyy\r\n" . _('Password') . ": zzz\r\n\r\n$dbowner\r\n$tngdomain"; ?></textarea><br><br>
                    <input type="submit" name="submit" accesskey="s" class="btn" value="<?php echo _('Save'); ?>">
            </form>
            <br>
            <p>
                <?php
                echo "*" . _('Optional. Assigning no tree to the user will result in the user have rights for all trees and all branches. The site administrator should not be assigned a tree.') . "<br>\n";
                echo "**" . _('Optional. Assigning a branch to the user will constrain the rights granted on this page to the assigned branch within the selected tree.') . "<br>\n";
                ?>
            </p>
            </div>
        </td>
    </tr>

</table>

<?php if ($row['ucount']) { ?>
    <script>
        let tree = getTree();
        if (tree) <?php echo $swapbranches; ?>

    </script>
<?php } ?>

<?php echo tng_adminfooter(); ?>

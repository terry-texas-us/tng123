<?php
include "begin.php";
include "adminlib.php";
require_once "core/html/cleanUserProfile.php";


$textpart = "users";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if ($assignedtree || !$allow_edit) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$query = "SELECT *, DATE_FORMAT(lastlogin, '%d %b %Y %H:%i:%s') AS lastlogin, dt_registered, DATE_FORMAT(dt_registered, '%d %b %Y %H:%i:%s') AS dt_registered_fmt, DATE_FORMAT(dt_activated, '%d %b %Y %H:%i:%s') AS dt_activated, dt_consented, DATE_FORMAT(dt_consented, '%d %b %Y %H:%i:%s') AS dt_consented_fmt ";
$query .= "FROM $users_table ";
$query .= "WHERE userID = '$userID'";
$result = tng_query($query);
$row = tng_fetch_assoc($result);
tng_free_result($result);
$row = cleanUserProfile($row);

$deftext = $admtext;
if ($row['languageID']) {
    $query = "SELECT folder FROM $languages_table WHERE languageID = \"{$row['languageID']}\"";
    $result = tng_query($query) or die ("Cannot execute query: $query"); //message is hardcoded because we haven't included the text file yet
    $langrow = tng_fetch_assoc($result);
    tng_free_result($result);

    if ($langrow['folder']) {
        $oldtext = $admtext;
        include "$languages_path{$langrow['folder']}/admintext.php";
        $deftext = $admtext;
        $admtext = $oldtext;
    }
}

$revquery = "SELECT count(userID) AS ucount FROM $users_table WHERE allow_living = '-1'";
$revresult = tng_query($revquery) or die (_('Cannot execute query') . ": $revquery");
$revrow = tng_fetch_assoc($revresult);
$revstar = $revrow['ucount'] ? " *" : "";
tng_free_result($revresult);

$helplang = findhelp("users_help.php");

tng_adminheader(_('Edit Existing User'), $flags);

$style->addSelector("table", ["width" => "100%", "border-collapse" => "separate", "border-spacing" => "2px"]);
$style->addSelector("table td", ["padding" => "10px"]);
echo $style->getStyle();

?>
    <script src="js/selectutils.js"></script>
    <script src="js/users.js"></script>
    <script>
        <?php
        include "branchlibjs.php";
        ?>

        function validateForm() {
            let rval = true;
            if (document.form1.username.value.length == 0) {
                alert("<?php echo _('Please enter a username.'); ?>");
                document.form1.username.focus();
                rval = false;
            } else if (document.form1.password.value.length == 0) {
                alert("<?php echo _('Please enter a password.'); ?>");
                document.form1.password.focus();
                rval = false;
            } else if (form.email.value.length != 0 && !checkEmail(form.email.value)) {
                alert(enteremail);
                form.email.focus();
                rval = false;
            } else if (document.form1.administrator[1].checked && document.form1.gedcom.selectedIndex < 1) {
                alert("<?php echo _('Please select/add a tree.'); ?>");
                document.form1.gedcom.focus();
                rval = false;
            }
            return rval;
        }

        var orgrealname = "<?php echo $row['realname']; ?>";
        var orgusername = "<?php echo $row['username']; ?>";
        var orgpassword = "<?php echo $row['password']; ?>";
        var enteremail = "<?php echo _('Please enter a valid e-mail address.'); ?>";
    </script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$usertabs[0] = [1, "admin_users.php", _('Search'), "finduser"];
$usertabs[1] = [$allow_add, "admin_newuser.php", _('Add New'), "adduser"];
$usertabs[2] = [$allow_edit, "admin_reviewusers.php", _('Review') . $revstar, "review"];
$usertabs[3] = [1, "admin_mailusers.php", _('E-mail'), "mail"];
$usertabs['4'] = [1, "#", _('Edit'), "edit"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/users_help.php');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($usertabs, "edit", $innermenu);
echo displayHeadline(_('Users') . " &gt;&gt; " . _('Edit Existing User'), "img/users_icon.gif", $menu, $message);
?>

    <table class="lightback normal w-full" cellpadding="10" cellspacing="2">
        <tr class="databack">
            <td class="tngshadow">
                <form action="admin_updateuser.php" method="post" name="form1" onSubmit="return validateForm();">
                    <table class="normal">
                        <tr>
                            <td><?php echo _('Description'); ?>:</td>
                            <td>
                                <input type="text" name="description" size="50" maxlength="50" value="<?php echo $row['description']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Username'); ?>:</td>
                            <td>
                                <input type="text" name="username" size="20" maxlength="100" value="<?php echo $row['username']; ?>">
                                <input type="button" value="<?php echo _('Check'); ?>"
                                    onclick="checkNewUser(document.form1.username,document.form1.orguser);">
                                <span id="checkmsg" class="normal"></span>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Password'); ?>:</td>
                            <td>
                                <input type="password" name="password" size="20" maxlength="100" value="<?php echo $row['password']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Real Name'); ?>:</td>
                            <td>
                                <input type="text" name="realname" size="50" maxlength="50" value="<?php echo $row['realname']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Phone'); ?>:</td>
                            <td>
                                <input type="text" name="phone" size="30" maxlength="30" value="<?php echo $row['phone']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('E-mail'); ?>:</td>
                            <td>
                                <input type="text" name="email" size="50" maxlength="100" value="<?php echo $row['email']; ?>"
                                    onblur="checkIfUnique(this);">
                                <span id="emailmsg"></span></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>
                                <input type="checkbox" name="no_email" value="1"<?php if ($row['no_email']) {
                                    echo " checked";
                                } ?>> <?php echo _('Do not send mass e-mail to this user'); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo _('Web Site'); ?>:</td>
                            <td>
                                <input type="text" name="website" size="50" maxlength="128" value="<?php echo $row['website']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Address'); ?>:</td>
                            <td>
                                <input type="text" name="address" size="50" maxlength="100" value="<?php echo $row['address']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('City'); ?>:</td>
                            <td>
                                <input type="text" name="city" size="50" maxlength="64" value="<?php echo $row['city']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('State/Province'); ?>:</td>
                            <td>
                                <input type="text" name="state" size="50" maxlength="64" value="<?php echo $row['state']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Zip/Postal Code'); ?>:</td>
                            <td>
                                <input type="text" name="zip" size="20" maxlength="10" value="<?php echo $row['zip']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Country'); ?>:</td>
                            <td>
                                <input type="text" name="country" size="50" maxlength="64" value="<?php echo $row['country']; ?>">
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
                                            echo "	<option value=\"{$langrow['languageID']}\"";
                                            if ($langrow['languageID'] == $row['languageID']) {
                                                echo " selected";
                                            }
                                            echo ">{$langrow['display']}</option>\n";
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
                            <td><textarea cols="50" rows="4" name="notes"><?php echo $row['notes']; ?></textarea></td>
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
                                        echo "	<option value=\"{$treerow['gedcom']}\"";
                                        if ($treerow['gedcom'] == $row['mygedcom']) {
                                            echo " selected";
                                        }
                                        echo ">{$treerow['treename']}</option>\n";
                                    }
                                    ?>
                                </select>
                                <input type="text" name="personID" id="personID" size="20" maxlength="22" value="<?php echo $row['personID']; ?>">
                                &nbsp;<?php echo _('OR'); ?>&nbsp;
                                <a href="#"
                                    onclick="return findItem('I','personID','',document.form1.mynewgedcom.options[document.form1.mynewgedcom.selectedIndex].value,'<?php echo $assignedbranch; ?>');"
                                    title="<?php echo _('Find...'); ?>">
                                    <img src="img/tng_find.gif" title="<?php echo _('Find...'); ?>" alt="<?php echo _('Find...'); ?>"
                                        class="align-middle" width="20" height="20" style="margin-left:2px; margin-bottom:4px;">
                                </a>
                            </td>
                        </tr>
                        <?php if ($row['dt_registered']) { ?>
                            <tr>
                                <td><?php echo _('Date Registered'); ?>:</span></td>
                                <td><span class="normal"><?php echo $row['dt_registered_fmt']; ?></span></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td><?php echo _('Date Activated'); ?>:</td>
                            <td><?php echo $row['dt_activated']; ?></td>
                        </tr>
                        <?php if (substr($row['dt_consented'], 0, 4) != "0000") { ?>
                            <tr>
                                <td><?php echo _('Date Consented'); ?>:</span></td>
                                <td><span class="normal"><?php echo $row['dt_consented_fmt']; ?></span></td>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <input type="checkbox" name="consented" value="1"> <?php echo _('Consent given'); ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td><?php echo _('Last Login'); ?>:</td>
                            <td><?php echo $row['lastlogin']; ?></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>
                                <input type="checkbox" name="disabled" value="1"<?php if ($row['disabled']) {
                                    echo " checked";
                                } ?>> <?php echo _('Disabled'); ?></td>
                        </tr>
                    </table>
                    <br><br>

                    <table class="normal">
                        <tr>
                            <td class='align-top'>
                                <p><strong><?php echo _('Roles'); ?>:</strong></p>

                                <p>
                                    <input type="radio" name="role" value="guest"<?php if ($row['role'] == "guest") {
                                        echo " checked";
                                    } ?>
                                        onclick="assignRightsFromRole('guest');"> <?php echo _('Guest') . "<br><em class=\"smaller indent\">" . _('No add, edit or delete rights.') . " " . _('No access to Admin area.') . "</em>"; ?>
                                </p>
                                <p>
                                    <input type="radio" name="role" value="subm"<?php if ($row['role'] == "subm") {
                                        echo " checked";
                                    } ?>
                                        onclick="assignRightsFromRole('subm');"> <?php echo _('Submitter') . "<br><em class=\"smaller indent\">" . _('Submit changes subject to review.') . " " . _('No access to Admin area.') . "</em>"; ?>
                                </p>
                                <p>
                                    <input type="radio" name="role" value="contrib"<?php if ($row['role'] == "contrib") {
                                        echo " checked";
                                    } ?>
                                        onclick="assignRightsFromRole('contrib');"> <?php echo _('Contributor') . "<br><em class=\"smaller indent\">" . _('Add information, including media.') . "</em>"; ?>
                                </p>
                                <p>
                                    <input type="radio" name="role" value="editor"<?php if ($row['role'] == "editor") {
                                        echo " checked";
                                    } ?>
                                        onclick="assignRightsFromRole('editor');"> <?php echo _('Editor') . "<br><em class=\"smaller indent\">" . _('Add, edit and delete all information, including media.') . "</em>"; ?>
                                </p>
                                <p>
                                    <input type="radio" name="role" value="mcontrib"<?php if ($row['role'] == "mcontrib") {
                                        echo " checked";
                                    } ?>
                                        onclick="assignRightsFromRole('mcontrib');"> <?php echo _('Media Contributor') . "<br><em class=\"smaller indent\">" . _('Add media only.') . "</em>"; ?>
                                </p>
                                <p>
                                    <input type="radio" name="role" value="meditor"<?php if ($row['role'] == "meditor") {
                                        echo " checked";
                                    } ?>
                                        onclick="assignRightsFromRole('meditor');"> <?php echo _('Media Editor') . "<br><em class=\"smaller indent\">" . _('Add, edit and delete media only.') . "</em>"; ?>
                                </p>
                                <p>
                                    <input type="radio" name="role" value="custom"<?php if (!$row['role'] || $row['role'] == "custom") {
                                        echo " checked";
                                    } ?> onclick="assignRightsFromRole('custom');"> <?php echo _('Custom'); ?></p>
                                <p>
                                    <input type="radio" name="role" value="admin"<?php if ($row['role'] == "admin") {
                                        echo " checked";
                                    } ?>
                                        onclick="assignRightsFromRole('admin');"> <?php echo _('Administrator') . "<br><em class=\"smaller indent\">" . _('All rights.') . "</em>"; ?>
                                </p>
                            </td>
                            <td class='align-top'>
                                <p><strong><?php echo _('Rights:'); ?></strong></p>

                                <p>
                                    <input type="radio" name="form_allow_add" class="rights" value="1"<?php if ($row['allow_add'] == 1) {
                                        echo " checked";
                                    } ?> onclick="document.form1.role[6].checked='checked';"> <?php echo _('Allow to add any new data'); ?><br>
                                    <input type="radio" name="form_allow_add" class="rights" value="3"<?php if ($row['allow_add'] == 3) {
                                        echo " checked";
                                    } ?> onclick="document.form1.role[6].checked='checked';"> <?php echo _('Allow to add media only'); ?><br>
                                    <input type="radio" name="form_allow_add" class="rights" value="0"<?php if (!$row['allow_add']) {
                                        echo " checked";
                                    } ?> onclick="document.form1.role[6].checked='checked';"> <?php echo _('No add rights'); ?><br>
                                </p>

                                <p>
                                    <input type="radio" name="form_allow_edit" class="rights" value="1"<?php if ($row['allow_edit'] == 1) {
                                        echo " checked";
                                    } ?> onclick="document.form1.role[6].checked='checked';"> <?php echo _('Allow to edit any existing data'); ?><br>
                                    <input type="radio" name="form_allow_edit" class="rights" value="3"<?php if ($row['allow_edit'] == 3) {
                                        echo " checked";
                                    } ?> onclick="document.form1.role[6].checked='checked';"> <?php echo _('Allow to edit media only'); ?><br>
                                    <input type="radio" name="form_allow_edit" class="rights" value="2"<?php if ($row['tentative_edit']) {
                                        echo " checked";
                                    } ?> onclick="document.form1.role[6].checked='checked';"> <?php echo _('Allow to submit edits for administrative review (People, Families and Sources only)'); ?><br>
                                    <input type="radio" name="form_allow_edit" class="rights"
                                        value="0"<?php if (!$row['allow_edit'] && !$row['tentative_edit']) {
                                        echo " checked";
                                    } ?> onclick="document.form1.role[6].checked='checked';"> <?php echo _('No edit rights'); ?><br>
                                </p>

                                <p>
                                    <input type="radio" name="form_allow_delete" class="rights" value="1"<?php if ($row['allow_delete'] == 1) {
                                        echo " checked";
                                    } ?> onclick="document.form1.role[6].checked='checked';"> <?php echo _('Allow to delete any existing data'); ?><br>
                                    <input type="radio" name="form_allow_delete" class="rights" value="3"<?php if ($row['allow_delete'] == 3) {
                                        echo " checked";
                                    } ?> onclick="document.form1.role[6].checked='checked';"> <?php echo _('Allow to delete media only'); ?><br>
                                    <input type="radio" name="form_allow_delete" class="rights" value="0"<?php if (!$row['allow_delete']) {
                                        echo " checked";
                                    } ?> onclick="document.form1.role[6].checked='checked';"> <?php echo _('No delete rights'); ?><br>
                                </p>

                                <br>
                                <hr>
                                <br>
                                <p>
                                    <input type="checkbox" name="form_allow_living" value="1"<?php if ($row['allow_living'] > 0) {
                                        echo " checked";
                                    } ?>> <?php echo _('Allow to view information for living individuals'); ?><br>
                                    <input type="checkbox" name="form_allow_private" value="1"<?php if ($row['allow_private'] > 0) {
                                        echo " checked";
                                    } ?>> <?php echo _('Allow to view information for private individuals'); ?><br>
                                    <input type="checkbox" name="form_allow_ged" value="1"<?php if ($row['allow_ged']) {
                                        echo " checked";
                                    } ?>> <?php echo _('Allow to download GEDCOMs'); ?><br>
                                    <input type="checkbox" name="form_allow_pdf" value="1"<?php if ($row['allow_pdf']) {
                                        echo " checked";
                                    } ?>> <?php echo _('Allow to download PDFs'); ?><br>
                                    <input type="checkbox" name="form_allow_lds" value="1"<?php if ($row['allow_lds']) {
                                        echo " checked";
                                    } ?>> <?php echo _('Allow to view LDS information'); ?><br>
                                    <input type="checkbox" name="form_allow_profile" value="1"<?php if ($row['allow_profile']) {
                                        echo " checked";
                                    } ?>> <?php echo _('Allow to edit user profile and change password'); ?>
                                </p>
                            </td>
                        </tr>
                    </table>
                    <br><br>

                    <?php
                    echo "<strong>" . _('Access Limits:') . "</strong><br>\n";
                    $gedcom_mult = explode(',', $row['gedcom']);
                    if (count($gedcom_mult) > 1) {
                        $adminaccess = 2;
                    } else {
                        $adminaccess = $row['gedcom'] || $row['branch'] ? 0 : 1;
                    }
                    ?>
                    <input type="radio" name="administrator" value="1" <?php if ($adminaccess == 1) {
                        echo "checked";
                    } ?> onClick="handleAdmin('allow');"> <?php echo _('Apply the above rights to all trees and branches.'); ?><br>
                    <input type="radio" name="administrator" value="0" <?php if (!$adminaccess) {
                        echo "checked";
                    } ?> onClick="handleAdmin('restrict');"> <?php echo _('Restrict the above rights to the following:'); ?><br>
                    <div id="restrictions" <?php if ($adminaccess) {
                        echo "style='display:none;'";
                    } ?>>
                        <table>
                            <tr>
                                <td class='align-top'>
                                    <span class="normal"><?php echo _('Tree'); ?>*:</span></td>
                                <td><span class="normal">
			<select name="gedcom" id="treeselect" onChange="var tree=getTree(this); if( !tree ) tree = 'none'; <?php echo $swapbranches; ?>">
				<option value=""></option>
<?php
$treeresult = tng_query($treequery);

while ($treerow = tng_fetch_assoc($treeresult)) {
    echo "	<option value=\"{$treerow['gedcom']}\"";
    if ($row['gedcom'] == $treerow['gedcom']) {
        echo " selected";
    }
    echo ">{$treerow['treename']}</option>\n";
}
?>
			</select></span>
                                </td>
                            </tr>
                            <tr>
                                <td class='align-top'><span class="normal"><?php echo _('Branch'); ?>**:</span></td>
                                <td><span class="normal">
<?php
$query = "SELECT branch, gedcom, description FROM $branches_table WHERE gedcom = \"{$row['gedcom']}\" ORDER BY description";
$branchresult = tng_query($query);

echo "<select name='branch' id='branch' size=\"$selectnum\">\n";
echo "	<option value=\"\">" . _('All Branches') . "</option>\n";
while ($branch = tng_fetch_assoc($branchresult)) {
    echo "	<option value=\"{$branch['branch']}\"";
    if ($row['branch'] == $branch['branch']) {
        echo " selected";
    }
    echo ">{$branch['description']}</option>\n";
}
echo "</select>\n";
?>
		</span></td>
                            </tr>
                        </table>
                    </div>
                    <input type="radio" name="administrator" value="2" <?php if ($adminaccess == 2) {
                        echo "checked";
                    } ?> onclick="handleAdmin('allow_multiple');"> <?php echo _('Apply rights to multiple trees'); ?><br>
                    <div style="margin-left: 30px;<?php if ($adminaccess != 2) {
                        echo "display: none;";
                    } ?>" id="multiple">
                        <select multiple="yes" name="gedcom_mult[]" id="treeselect2">
                            <?php
                            $treeresult = tng_query($treequery);

                            while ($treerow = tng_fetch_assoc($treeresult)) {
                                echo "	<option value=\"{$treerow['gedcom']}\"";
                                if (in_array($treerow['gedcom'], $gedcom_mult)) {
                                echo " selected";
                            }
                            echo ">{$treerow['treename']}</option>\n";
                        }
                        tng_free_result($treeresult);
                        ?>
                    </select>
                </div>
                <br>
                <?php
                if ($row['allow_living'] == -1) { //account is inactive
                    echo "<input type='checkbox' name=\"notify\" value='1' checked onClick=\"replaceText();\"> " . _('Notify this user upon account activation') . "<br>\n";
                    $owner = $sitename ? $sitename : $dbowner;
                    echo "<textarea name=\"welcome\" rows='5' cols=\"50\">{$deftext['hello']} {$row['realname']},\r\n\r\n{$deftext['activated']}";
                    if (!$tngconfig['omitpwd']) {
                        echo " {$deftext['infois']}:\r\n\r\n{$deftext['username']}: {$row['username']}\r\n{$deftext['password']}: {$row['password']}\r\n";
                    }
                    echo "\r\n$owner\r\n$tngdomain</textarea><br><br>\n";
                } else {
                    echo "<input type='hidden' name=\"notify\" value='0'>\n";
                }
                if (!$numlangs) {
                    echo "<input type='hidden' name=\"preflang\" value=\"{$row['languageID']}\">\n";
                }
                ?>
                    <input type="hidden" name="userID" value="<?php echo "$userID"; ?>">
                    <input type="hidden" name="orguser" value="<?php echo $row['username']; ?>">
                    <input type="hidden" name="orgemail" value="<?php echo $row['email']; ?>">
                    <input type="hidden" name="newuser" value="<?php echo "$newuser"; ?>">
                    <input type="hidden" name="orgpwd" value="<?php echo $row['password']; ?>">
                    <input type="submit" name="submit" class="btn" value="<?php echo _('Save Changes'); ?>">
                </form>
                <p style="font-size: 8pt;">
                    <?php
                    echo "*" . _('Optional. Assigning no tree to the user will result in the user have rights for all trees and all branches. The site administrator should not be assigned a tree.') . "<br>\n";
                    echo "**" . _('Optional. Assigning a branch to the user will constrain the rights granted on this page to the assigned branch within the selected tree.') . "<br>\n";
                    ?>
                </p>
            </td>
        </tr>

    </table>
<?php echo tng_adminfooter(); ?>
<?php

include "begin.php";
include "adminlib.php";
require_once "core/html/cleanUserProfile.php";

$textpart = "login";
include "$mylanguage/text.php";

include "checklogin.php";
//if no rights, just throw up a message. don't redirect
//remove javascript. put that somewhere global

if (!$currentuser) {
    header("Location: login.php");
    exit;
}

header("Content-type:text/html; charset=" . $session_charset);

$query = "SELECT description, username, password, realname, phone, email, address, city, state, zip, country, website, languageID, notes FROM $users_table WHERE username = '$currentuser'";
$result = tng_query($query);
$row = tng_fetch_assoc($result);
tng_free_result($result);

$row = cleanUserProfile($row);

$allow_user_change = true;
?>

<div class="databack ajaxwindow" id="editprof">
    <form action="ajx_updateuser.php" method="post" name="editprofile"
        onsubmit='if(!this.username.value.length) {
            alert("<?php echo htmlentities(_('Please enter a username.'), ENT_QUOTES); ?>");
            this.username.focus();
            return false;
            }
            else if(!this.password.value.length) {
            alert("<?php echo htmlentities(_('Please enter a password.'), ENT_QUOTES); ?>");
            this.password.focus();
            return false;
            }
            else if(!this.password2.value.length) {
            alert("<?php echo htmlentities(_('Please enter your password again.'), ENT_QUOTES); ?>");
            this.password2.focus();
            return false;
            }
            else if(this.password.value !== this.password2.value) {
            alert("<?php echo htmlentities(_('Your passwords do not match. Please enter the same password in each field.'), ENT_QUOTES); ?>");
            this.password.focus();
            return false;
            }
            else if(!this.realname.value.length) {
            alert("<?php echo htmlentities(_('Please enter your real name.'), ENT_QUOTES); ?>");
            this.realname.focus();
            return false;
            }
            else if(!this.email.value.length || !checkEmail(this.email.value)) {
            alert("<?php echo htmlentities(_('Please enter a valid e-mail address.'), ENT_QUOTES); ?>");
            this.email.focus();
            return false;
            }
            else if(this.em2.value.length === 0) {
            alert("<?php echo htmlentities(_('Please enter your email address again.'), ENT_QUOTES); ?>");
            this.em2.focus();
            return false;
            }
            else if(this.email.value !== this.em2.value) {
            alert("<?php echo htmlentities(_('Your emails do not match. Please enter the same email address in each field.'), ENT_QUOTES); ?>");
            this.em2.focus();
            return false;
            }
            if(!newuserok) {
            return checkNewUser(document.editprofile.username,document.editprofile.orguser,true);
            }'
    >
        <table class="normal" cellspacing="0" cellpadding="2">
            <tr class="databack">
                <td>
                    <h3 class="subhead"><?php echo _('Edit Profile'); ?></h3>
                    <table class="normal" cellpadding="3" cellspacing="0">
                        <tr>
                            <td><?php echo _('Username');
                                if ($allow_user_change) {
                                    echo "*";
                                } ?>:
                            </td>
                            <td>
                                <?php if ($allow_user_change) { ?>
                                    <input name="username" type="text" value="<?php echo $row['username']; ?>" size="20" maxlength="100" onblur="checkNewUser(this,document.editprofile.orguser);">
                                    <span id="checkmsg" class="normal"></span>
                                <?php } else { ?>
                                    <?php echo "<strong>" . $row['username'] . "</strong>\n"; ?>
                                    <input type="hidden" name="username" value="<?php echo $row['username']; ?>">
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Password'); ?>*:</td>
                            <td>
                                <input type="password" name="password" size="20" maxlength="100" value="<?php echo $row['password']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Password again'); ?>*:</td>
                            <td>
                                <input type="password" name="password2" size="20" maxlength="100" value="<?php echo $row['password']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Real Name'); ?>*:</td>
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
                            <td><?php echo _('E-mail'); ?>*:</td>
                            <td>
                                <input type="text" name="email" size="50" maxlength="100" value="<?php echo $row['email']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Email again'); ?>*:</td>
                            <td>
                                <input type="text" name="em2" size="50" maxlength="100" value="<?php echo $row['email']; ?>">
                            </td>
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
                            <td><?php echo _('state'); ?>:</td>
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
                            <td><?php echo _('country'); ?>:</td>
                            <td>
                                <input type="text" name="country" size="50" maxlength="64" value="<?php echo $row['country']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Preferred language'); ?>:</td>
                            <td>
                                <select name="preflang">
                                    <option value=""></option>
                                    <?php
                                    $query = "SELECT languageID, display FROM $languages_table ORDER BY display";
                                    $langresult = tng_query($query);

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
                    </table>
                    <br>
                    <p>*<?php echo _('required'); ?></p>
                    <input type="hidden" name="orguser" value="<?php echo $row['username']; ?>">
                    <input type="hidden" name="orgpwd" value="<?php echo $row['password']; ?>">
                    <input type="hidden" name="ajax" value="1">
                    <input type="submit" name="saveprofile" class="btn" id="saveprofile" value="<?php echo _('Save Changes'); ?>">
                </td>
            </tr>
        </table>

    </form>
</div>
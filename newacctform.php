<?php
$textpart = "login";
include "tng_begin.php";

$query = "SELECT gedcom, treename FROM $trees_table ORDER BY treename";
$treeresult = tng_query($query);
$numtrees = tng_num_rows($treeresult);

$query = "SELECT count(userID) AS ucount FROM $users_table";
$userresult = tng_query($query);
$row = tng_fetch_assoc($userresult);
$ucount = $row['ucount'];
tng_free_result($userresult);

$_SESSION['tng_email'] = generatePassword(1);

tng_header(_('Register for New User Account'), $flags);
?>
    <script>
        function validateForm(form) {
            var rval = true;
            if (form.username.value.length == 0) {
                alert("<?php echo _('Please enter a username.'); ?>");
                rval = false;
            } else if (form.password.value.length == 0) {
                alert("<?php echo _('Please enter a password.'); ?>");
                rval = false;
            } else if (form.password2.value.length == 0) {
                alert("<?php echo _('Please enter your password again.'); ?>");
                rval = false;
            } else if (form.password.value != form.password2.value) {
                alert("<?php echo _('Your passwords do not match. Please enter the same password in each field.'); ?>");
                rval = false;
            } else if (form.realname.value.length == 0) {
                alert("<?php echo _('Please enter your real name.'); ?>");
                rval = false;
            } else if (form.<?php echo $_SESSION['tng_email']; ?>.
            value.length == 0 || !checkEmail(form
        .<?php echo $_SESSION['tng_email']; ?>.
            value
        ))
            {
                alert("<?php echo _('Please enter a valid e-mail address.'); ?>");
                rval = false;
            }
        else
            if (form.em2.value.length == 0) {
                alert("<?php echo _('Please enter your email address again.'); ?>");
                rval = false;
            } else if (form.<?php echo $_SESSION['tng_email']; ?>.
            value != form.em2.value
        )
            {
                alert("<?php echo _('Your emails do not match. Please enter the same email address in each field.'); ?>");
                rval = false;
            }
            <?php if ($tngconfig['askconsent']) { ?>
        else
            if (!form.tng_user_consent.checked) {
                alert("<?php echo _('Please give your consent for this site to store personal information.'); ?>");
                return false;
            }
            <?php } ?>
            return rval;
        }
    </script>

    <h2 class="header"><img src="img/tng_log2.gif" width="20" height="20" alt=""
            class="headericon">&nbsp;<?php echo _('Register for New User Account'); ?></h2>
    <br style="clear: left;">
<?php

@include "TNG_captcha.php";

if (!$tngconfig['disallowreg']) {
    echo "<p class='normal'><strong>*" . _('required') . "</strong></p>\n";
    ?>
    <table cellpadding="0" cellspacing="2">
        <tr>
            <td>
                <?php
                $onsubmit = $ucount ? "return validateForm(this);" : "alert('" . _('No user records exist') . "');return false;";
                $formstr = getFORM("addnewacct", "post", "form1", "", $onsubmit);
                echo $formstr;
                ?>
                <table class="normal">
                    <tr>
                        <td class='align-top'><?php echo _('Username'); ?>*:</td>
                        <td>
                            <input type="text" name="username" size="20" maxlength="20">
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'><?php echo _('Password'); ?>*:</td>
                        <td>
                            <input type="password" name="password" size="20" maxlength="20">
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'><?php echo _('Password again'); ?>*:</td>
                        <td>
                            <input type="password" name="password2" size="20" maxlength="20">
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'><?php echo _('Real Name'); ?>*:</td>
                        <td>
                            <input type="text" name="realname" size="50" maxlength="50">
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'><?php echo _('Phone'); ?>:</td>
                        <td>
                            <input type="text" name="phone" size="30" maxlength="30">
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'><?php echo _('E-mail'); ?>*:</td>
                        <td>
                            <input type="text" name="<?php echo $_SESSION['tng_email']; ?>" size="50" maxlength="100">
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'><?php echo _('Email again'); ?>*:</td>
                        <td>
                            <input type="text" name="em2" size="50" maxlength="100">
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'><?php echo _('Web Site'); ?>:</td>
                        <td>
                            <input type="text" name="website" size="50" maxlength="100" value="http://">
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'><?php echo _('Address'); ?>:</td>
                        <td>
                            <input type="text" name="address" size="50" maxlength="100">
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'><?php echo _('City'); ?>:</td>
                        <td>
                            <input type="text" name="city" size="50" maxlength="64">
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'><?php echo _('state'); ?>:</td>
                        <td>
                            <input type="text" name="state" size="50" maxlength="64">
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'><?php echo _('Zip/Postal Code'); ?>:</td>
                        <td>
                            <input type="text" name="zip" size="20" maxlength="10">
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'><?php echo _('country'); ?>:</td>
                        <td>
                            <input type="text" name="country" size="50" maxlength="64">
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
                                    echo "	<option value=\"{$langrow['languageID']}\">{$langrow['display']}</option>\n";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'><?php echo _('Notes or Comments'); ?>:</td>
                        <td><textarea cols="50" rows="4" name="notes"></textarea></td>
                    </tr>
                </table>
                <p class="normal">
                    <?php if ($tngconfig['askconsent']) { ?>
                        <input type="checkbox" name="tng_user_consent" value="1">
                        <?php
                        echo _('I give my consent for this site to store the personal information collected here. I understand that I may ask the site owner to remove this information at any time.');
                        if ($tngconfig['dataprotect']) {
                            echo "<br><a href='data_protection_policy.php' target='_blank'>" . _('Data Protection Policy') . "</a>\n";
                        }
                    }
                    ?>
                    <br><br>
                    <?php echo _('<strong>NOTE:</strong> In order to receive mail from the site administrator regarding your account, please make sure that you are not blocking mail from this domain.'); ?>
                </p>
                <br>
                <input type="hidden" name="fingerprint" value="realperson">
                <input type="submit" name="submit" class="btn" id="submitbtn" value="<?php echo _('Submit'); ?>">
                </form><br>
            </td>
        </tr>

    </table>
    <?php
} else {
    echo "<p class='normal'>{_('We\'re sorry, but we are not accepting new user registrations at this time. Please <a href=\"suggest.php\">contact us</a> directly if you have comments or questions regarding anything on this site.')}</p>\n";
}

tng_footer("");
?>
<?php
include "begin.php";
$tngconfig['maint'] = "";
include "adminlib.php";
$textpart = "login";
include "$mylanguage/admintext.php";
include "tngmaillib.php";

if (isset($_SESSION['logged_in']) && $_SESSION['session_rp'] == $rootpath && $_SESSION['allow_admin'] && $currentuser) {
    header("Location:admin.php");
    $reset = 1;
}

if (!empty($message)) {
    if ($admtext[$message]) {
        $message = $admtext[$message];
    } elseif ($text[$message]) {
        $message = $text[$message];
    }
}
if (!empty($email)) {

    $sendmail = 0;

    //if username is there too, then look up based on username and get password
    if ($username) {
        $query = "SELECT username, realname FROM $users_table WHERE username = '$username'";
        $result = tng_query($query);
        $row = tng_fetch_assoc($result);
        tng_free_result($result);

        $newpassword = generatePassword(0);
        $query = "UPDATE $users_table SET password = '" . PasswordEncode($newpassword) . "', password_type = '" . PasswordType() . "' WHERE email = '$email' AND username = '$username' AND allow_living != '-1'";
        $result = tng_query($query);
        $success = tng_affected_rows();

        if ($success) {
            $sendmail = 1;
            $content = _('Your new temporary password') . ": $newpassword";
            $message = _('Your new temporary password has been sent to your e-mail address.');
        } else {
            $message = _('The e-mail address and username you provided do not match any user account currently on record. No information has been sent.');
        }
    } else {
        $query = "SELECT username, realname FROM $users_table WHERE email = '$email'";
        $result = tng_query($query);
        $row = tng_fetch_assoc($result);
        tng_free_result($result);

        if ($row['username']) {
            $sendmail = 1;
            $content = "" . _('Your login information') . ":\n\n" . _('Username') . ": {$row['username']}";
            $message = _('Your username has been sent to your e-mail address.');
        } else {
            $message = _('The e-mail address you provided does not match any user account currently on record. No information has been sent.');
        }
    }

    if ($sendmail) {
        $mailmessage = $content;
        $owner = preg_replace("/,/", "", ($sitename ? $sitename : ($dbowner ? $dbowner : "TNG")));

        tng_sendmail($owner, $emailaddr, $row['realname'], $email, _('Your login information'), $mailmessage, $emailaddr, $emailaddr);
    }
}

$home_url = $homepage;

$newroot = preg_replace("/\//", "", $rootpath);
$newroot = preg_replace("/\s*/", "", $newroot);
$newroot = preg_replace("/\./", "", $newroot);
$loggedin = "tngloggedin_$newroot";

if (!isset($_SESSION['logged_in']) && isset($_COOKIE[$loggedin]) && !empty($reset)) {
    //if(1) {
    if (strpos($_SESSION['destinationpage8'], "admin.php") !== false) {
        $continue = "";
    }
    session_start();
    session_unset();
    session_destroy();
    setcookie("tngloggedin_$newroot", "");
    tng_adminheader(_('Login'), "");
    $message = _('Your session has expired.');
}
tng_adminheader(_('Login'), "");
if (!empty($reset)) $_COOKIE[$loggedin] = "";
echo "</head>\n";
echo tng_adminlayout();
?>
<table class="w-3/4 m-auto" cellpadding="10" bgcolor="#fff">
    <tr>
        <td class="rounded-lg fieldnameback">
            <span class="mt-0 text-base whiteheader" style="font-size: large; "><?php echo _('Login') . ": " . _('Administration'); ?></span>
        </td>
    </tr>
    <?php if (!empty($message)) { ?>
        <tr>
            <td>
                <span class="normal" style="color:#f00;"><em><?php echo $message; ?></em></span>
            </td>
        </tr>
    <?php } ?>
    <tr>
        <td class="rounded-lg databack tngshadow">
            <div id="admlogintable" style="position:relative;">
                <div class="float-left altab">
                    <form action="processlogin.php" name="form1" method="post">
                        <table>
                            <tr>
                                <td><span class="normal"><?php echo _('Username'); ?>:</span></td>
                                <td>
                                    <input type="text" class="w-auto loginfont" name="tngusername" size="20">
                                </td>
                            </tr>
                            <tr>
                                <td><span class="normal"><?php echo _('Password'); ?>:</span></td>
                                <td>
                                    <input type="password" class="w-auto loginfont" name="tngpassword" size="20">
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td><span class="normal"><input type="checkbox" name="remember" value="1"> <?php echo _('Stay logged in on this computer'); ?></span></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <input type="submit" class="btn" value="<?php echo _('Login'); ?>">
                                </td>
                            </tr>
                        </table>
                        <p class="normal"><a href="<?php echo $home_url; ?>"><img src="img/tng_home.gif" align="left" width="16" height="15" alt=""><?php echo _('Public Home'); ?></a></p>
                        <input type="hidden" name="admin_login" value="1">
                        <input type="hidden" name="continue" value="<?php echo $continue; ?>">
                    </form>
                </div>
                <div class="float-left altab" width:50px;
                ">&nbsp;&nbsp;&nbsp;
            </div>
            <div class="altab">
                <form action="admin_login.php" name="form2" method="post">
                    <table style="max-width:400px;">
                        <tr>
                            <td colspan="2"><span class="normal"><?php echo _('<strong>Forgot your username or password?</strong><br>Enter your e-mail address below to have your username sent to you.'); ?></span></td>
                        </tr>
                        <tr>
                            <td nowrap><span class="normal"><?php echo _('E-mail'); ?>:</span></td>
                            <td>
                                <input type="text" name="email">
                                <input type="submit" value="<?php echo _('Go'); ?>">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><span class="normal"><br><?php echo _('Enter your e-mail above and your username below to have your password reset (a temporary password will be sent to you).'); ?></span></td>
                        </tr>
                        <tr>
                            <td nowrap><span class="normal"><?php echo _('Username'); ?>:</span></td>
                            <td>
                                <input type="text" name="username">
                                <input type="submit" value="<?php echo _('Go'); ?>">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            </div>
        </td>
    </tr>
</table>
<script>
    document.form1.tngusername.focus();
</script>
</body>
</html>
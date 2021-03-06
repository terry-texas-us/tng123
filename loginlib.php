<?php

?>

<h2 class="header"><span class="headericon" id="unlock-hdr-icon"></span><?php echo _('Login'); ?></h2>

<?php if ($message) { ?>
    <span class="normal" style="color: #f00;"><em><?php echo $text[$message]; ?></em></span>
    <?php
}

$formstr = getFORM("processlogin", "post", "form1", "", "");
echo $formstr;
?>
<div class="normal">
    <div class="whitespace-no-wrap" id="loginblock">
        <div class="loginprompt"><?php echo _('Username'); ?>:</div>
        <input type="text" name="tngusername" class="loginfont <?php echo $loginfieldclass; ?>" id="tngusername">
        <br>

        <div class="loginprompt"><?php echo _('Password'); ?>:</div>
        <input type="password" name="tngpassword" class="loginfont <?php echo $loginfieldclass; ?>" id="tngpassword">

        <div id="resetrow" style="display:none;">
            <div class="loginprompt"><?php echo _('New Password'); ?>:</div>
            <input type="password" name="newpassword" class="medfield" id="newpassword">
        </div>
    </div>
    <div class="login-options">
        <input type="checkbox" name="remember" value="1"> <?php echo _('Stay logged in on this computer'); ?><br>
        <input type="checkbox" name="resetpass" value="1"
            onclick="if(this.checked) {document.getElementById('resetrow').style.display='';} else {document.getElementById('resetrow').style.display='none';}"> <?php echo _('Reset your password'); ?>
    </div>
    <div>
        <input type="submit" class="<?php echo $loginbtnclass; ?>" value="<?php echo _('Login'); ?>">
    </div>
</div>
</form>
<br style="clear:both;">
<?php
$formstr = getFORM("", "post", "form2", "", "return sendLogin(this, 'sendlogin.php');");
echo $formstr;
?>
<div class="normal" id="forgot" style="clear:both;">
    <p><?php echo _('<strong>Forgot your username or password?</strong><br>Enter your e-mail address below to have your username sent to you.'); ?></p>
    <input type="text" class="forgotfield" name="email" id="email" placeholder="<?php echo _('E-mail'); ?>">
    <input type="submit" value="<?php echo _('Go'); ?>">
    <div id="usnmsg" class="smaller"></div>

    <p><?php echo _('Enter your e-mail above and your username below to have your password reset (a temporary password will be sent to you).'); ?></p>
    <input type="text" class="forgotfield" name="username" id="username" placeholder="<?php echo _('Username'); ?>">
    <input type="submit" value="<?php echo _('Go'); ?>">
    <div id="pwdmsg" class="smaller"></div>
</div>
<?php
if (!$tngconfig['disallowreg']) {
    echo "<p class='normal'>{_('Don\'t have a login?')} <a href=\"newacctform.php\">" . _('Register for New User Account') . "</a></p>";
}
?>
</form>
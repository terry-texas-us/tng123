<?php
if ($p) {
    $cms['tngpath'] = urldecode($p);
}
?>

<h2 class="header"><span class="headericon" id="unlock-hdr-icon"></span><?php echo $text['login']; ?></h2>

<?php if ($message) { ?>
    <span class="normal" style="color: #f00;"><em><?php echo $text[$message]; ?></em></span>
    <?php
}

$formstr = getFORM("processlogin", "post", "form1", "", "");
echo $formstr;
?>
<div class="normal">
    <div class="nw" id="loginblock">
        <div class="loginprompt"><?php echo $text['username']; ?>:</div>
        <input type="text" name="tngusername" class="loginfont <?php echo $loginfieldclass; ?>" id="tngusername">
        <br>

        <div class="loginprompt"><?php echo $text['password']; ?>:</div>
        <input type="password" name="tngpassword" class="loginfont <?php echo $loginfieldclass; ?>" id="tngpassword">

        <div id="resetrow" style="display:none;">
            <div class="loginprompt"><?php echo $text['newpassword']; ?>:</div>
            <input type="password" name="newpassword" class="medfield" id="newpassword">
        </div>
    </div>
    <div class="login-options">
        <input type="checkbox" name="remember" value="1"> <?php echo $text['rempass']; ?><br>
        <input type="checkbox" name="resetpass" value="1"
               onclick="if(this.checked) {document.getElementById('resetrow').style.display='';} else {document.getElementById('resetrow').style.display='none';}"> <?php echo $text['resetpass']; ?>
    </div>
    <div>
        <input type="submit" class="<?php echo $loginbtnclass; ?>" value="<?php echo $text['login']; ?>">
    </div>
</div>
</form>
<br style="clear:both;">
<?php
$sendlogin_url = getURL("sendlogin", 0);
$formstr = getFORM("", "post", "form2", "", "return sendLogin(this, '$sendlogin_url');");
echo $formstr;
?>
<div class="normal" id="forgot" style="clear:both;">
    <p><?php echo $text['forgot1']; ?></p>
    <input type="text" class="forgotfield" name="email" id="email" placeholder="<?php echo $text['email']; ?>"> <input type="submit" value="<?php echo $text['go']; ?>">
    <div id="usnmsg" class="smaller"></div>

    <p><?php echo $text['forgot2']; ?></p>
    <input type="text" class="forgotfield" name="username" id="username" placeholder="<?php echo $text['username']; ?>"> <input type="submit" value="<?php echo $text['go']; ?>">
    <div id="pwdmsg" class="smaller"></div>
</div>
<?php
if (!$tngconfig['disallowreg']) {
    echo "<p class='normal'>{$text['nologin']} <a href=\"{$cms['tngpath']}newacctform.php\">{$text['regnewacct']}</a></p>";
}
?>
</form>
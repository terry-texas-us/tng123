<?php
include "begin.php";
$tngconfig['maint'] = "";
include "adminlib.php";
$textpart = "login";
include "$mylanguage/admintext.php";
include "tngmaillib.php";

if (isset($_SESSION['logged_in']) && $_SESSION['session_rp'] == $rootpath && $_SESSION['allow_admin'] && $currentuser) {
  $admin_url = getURL("admin", 0);
  header("Location:$admin_url");
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
    $query = "SELECT username, realname FROM $users_table WHERE username = \"$username\"";
    $result = tng_query($query);
    $row = tng_fetch_assoc($result);
    tng_free_result($result);

    $newpassword = generatePassword(0);
    $query = "UPDATE $users_table SET password = \"" . PasswordEncode($newpassword) . "\", password_type = \"" . PasswordType() . "\" WHERE email = \"$email\" AND username = \"$username\" AND allow_living != \"-1\"";
    $result = tng_query($query);
    $success = tng_affected_rows();

    if ($success) {
      $sendmail = 1;
      $content = $text['newpass'] . ": $newpassword";
      $message = $text['pwdsent'];
    } else {
      $message = $text['loginnotsent3'];
    }
  } else {
    $query = "SELECT username, realname FROM $users_table WHERE email = \"$email\"";
    $result = tng_query($query);
    $row = tng_fetch_assoc($result);
    tng_free_result($result);

    if ($row['username']) {
      $sendmail = 1;
      $content = "{$text['logininfo']}:\n\n{$admtext['username']}: {$row['username']}";
      $message = $text['usersent'];
    } else {
      $message = $text['loginnotsent2'];
    }
  }

  if ($sendmail) {
    $mailmessage = $content;
    $owner = preg_replace("/,/", "", ($sitename ? $sitename : ($dbowner ? $dbowner : "TNG")));

    tng_sendmail($owner, $emailaddr, $row['realname'], $email, $text['logininfo'], $mailmessage, $emailaddr, $emailaddr);
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
  tng_adminheader($admtext['login'], "");
  $message = $admtext['sessexp'];
}
tng_adminheader($admtext['login'], "");
?>
</head>

<?php
if (!empty($reset)) {
  $_COOKIE[$loggedin] = "";
}
?>
<body background="img/background.gif">

<table width="100%" border="0" cellpadding="10" bgcolor="#FFFFFF" class="rounded10">
    <tr>
        <td class="fieldnameback rounded10">
            <span class="whiteheader"><font size="6"><?php echo $admtext['login'] . ": " . $admtext['administration']; ?></font></span>
        </td>
    </tr>
  <?php
  if (!empty($message)) {
    ?>
      <tr>
          <td>
              <span class="normal" style="color:#FF0000"><em><?php echo $message; ?></em></span>
          </td>
      </tr>
    <?php
  }
  ?>
    <tr>
        <td class="databack tngshadow rounded10">
            <div id="admlogintable" style="position:relative">
                <div class="altab" style="float:left">
                    <form action="processlogin.php" name="form1" method="post">
                        <table>
                          <tr>
                            <td><span class="normal"><?php echo $admtext['username']; ?>:</span></td>
                            <td><input type="text" class="loginfont medfield" name="tngusername" size="20"></td>
                          </tr>
                          <tr>
                            <td><span class="normal"><?php echo $admtext['password']; ?>:</span></td>
                            <td><input type="password" class="loginfont medfield" name="tngpassword" size="20"></td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td><span class="normal"><input type="checkbox" name="remember" value="1"> <?php echo $admtext['rempass']; ?></span></td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td><input type="submit" class="btn medfield" value="<?php echo $admtext['login']; ?>"></td>
                          </tr>
                        </table>
                      <p class="normal"><a href="<?php echo $home_url; ?>"><img src="img/tng_home.gif" align="left" width="16" height="15" alt=""><?php echo $admtext['publichome']; ?></a></p>
                      <input type="hidden" name="admin_login" value="1">
                      <input type="hidden" name="continue" value="<?php echo $continue; ?>">
                    </form>
                </div>
              <div class="altab" style="float:left; width:50px;">&nbsp;&nbsp;&nbsp;</div>
              <div class="altab">
                <form action="admin_login.php" name="form2" method="post">
                  <table style="max-width:400px">
                    <tr>
                      <td colspan="2"><span class="normal"><?php echo $text['forgot1']; ?></span></td>
                    </tr>
                    <tr>
                      <td nowrap><span class="normal"><?php echo $admtext['email']; ?>:</span></td>
                      <td><input type="text" name="email"> <input type="submit" value="<?php echo $admtext['go']; ?>"></td>
                    </tr>
                    <tr>
                      <td colspan="2"><span class="normal"><br><?php echo $text['forgot2']; ?></span></td>
                    </tr>
                    <tr>
                      <td nowrap><span class="normal"><?php echo $admtext['username']; ?>:</span></td>
                      <td><input type="text" name="username"> <input type="submit" value="<?php echo $admtext['go']; ?>"></td>
                    </tr>
                  </table>
                </form>
              </div>
            </div>
        </td>
    </tr>
</table>
<script language="JavaScript" type="text/javascript">
  document.form1.tngusername.focus();
</script>
</body>
</html>
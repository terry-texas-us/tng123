<?php
include "begin.php";
include "adminlib.php";
$textpart = "users";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
$helplang = findhelp("users_help.php");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['emailusers'], $flags);
?>
<script src="js/selectutils.js"></script>
<script type="text/javascript">
  <?php
  include "branchlibjs.php";
  ?>

  function validateForm() {
      var rval = true;
      if (document.form1.subject.value.length == 0) {
          alert("<?php echo $admtext['entersubject']; ?>");
          rval = false;
      } else if (document.form1.messagetext.value.length == 0) {
          alert("<?php echo $admtext['entermsgtext']; ?>");
          rval = false;
      }
      return rval;
  }
</script>
</head>

<body background="img/background.gif">

<?php
$usertabs[0] = array(1, "admin_users.php", $admtext['search'], "finduser");
$usertabs[1] = array($allow_add, "admin_newuser.php", $admtext['addnew'], "adduser");
$usertabs[2] = array($allow_edit, "admin_reviewusers.php", $admtext['review'] . $revstar, "review");
$usertabs[3] = array(1, "admin_mailusers.php", $admtext['email'], "mail");
$innermenu = "<a href=\"javascript:newwindow=window.open('$helplang/users_help.php#add');\" class=\"lightlink\">{$admtext['help']}</a>";
$menu = doMenu($usertabs, "mail", $innermenu);
echo displayHeadline($admtext['users'] . " &gt;&gt; " . $admtext['emailmessage'], "img/users_icon.gif", $menu, $message);
?>

<table width="100%" cellpadding="10" cellspacing="2" class="lightback">
  <tr class="databack">
    <td class="tngshadow">
      <form action="admin_sendmailusers.php" method="post" name="form1" onSubmit="return validateForm();">
        <table>
          <tr>
            <td valign="top"><span class="normal"><?php echo $admtext['subject']; ?>:</span></td>
                  <td><span class="normal"><input type="text" name="subject" size="50" maxlength="50"></span></td>
                </tr>
                <tr>
                  <td valign="top"><span class="normal"><?php echo $admtext['messagetext']; ?>:</span></td>
                  <td><span class="normal"><textarea cols="50" rows="15" name="messagetext"></textarea></span></td>
                </tr>
                <tr>
                  <td valign="top" colspan="2"><span class="normal"><br><strong><?php echo $admtext['selectgroup']; ?></strong></span></td>
                </tr>
                <tr>
                  <td valign="top">
                    <span class="normal"><?php echo $admtext['tree']; ?>*:</span></td>
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
                        <td valign="top"><span class="normal"><?php echo $admtext['branch']; ?>**:</span></td>
                        <td><span class="normal">
			<select name="branch" id="branch">
				<option value=""></option>
				<option value="" selected><?php echo $admtext['nobranch']; ?></option>
			</select>
		</span></td>
                    </tr>
              </table>
              <br>
              <input type="submit" name="submit" accesskey="s" class="btn" value="<?php echo $admtext['send']; ?>"></form>
          <br>
          <p class="normal">
            <?php
            echo "*{$admtext['treemailmsg']}<br>\n";
            echo "**{$admtext['branchmailmsg']}<br>\n";
            ?>
          </p>
        </td>
    </tr>

</table>

<?php
echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
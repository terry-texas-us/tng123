<?php
include "begin.php";
include "adminlib.php";
$textpart = "users";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";

if ($assignedtree) {
  $message = $admtext['norights'];
  header("Location: admin_login.php?message=" . urlencode($message));
  exit;
}

$tng_search_users = $_SESSION['tng_search_users'] = 1;
if ($newsearch) {
  $exptime = 0;
  $searchstring = stripslashes(trim($searchstring));
  setcookie("tng_search_users_post[search]", $searchstring, $exptime);
  setcookie("tng_search_users_post[adminonly]", $adminonly, $exptime);
  setcookie("tng_search_users_post[tngpage]", 1, $exptime);
  setcookie("tng_search_users_post[offset]", 0, $exptime);
} else {
  if (!$searchstring) {
    $searchstring = stripslashes($_COOKIE['tng_search_users_post']['search']);
  }
  if (!$adminonly) {
    $adminonly = $_COOKIE['tng_search_users_post']['adminonly'];
  }
  if (!isset($offset)) {
    $tngpage = $_COOKIE['tng_search_users_post']['tngpage'];
    $offset = $_COOKIE['tng_search_users_post']['offset'];
  } else {
    $exptime = 0;
    setcookie("tng_search_users_post[tngpage]", $tngpage, $exptime);
    setcookie("tng_search_users_post[offset]", $offset, $exptime);
  }
}

if ($offset) {
  $offsetplus = $offset + 1;
  $newoffset = "$offset, ";
} else {
  $offsetplus = 1;
  $newoffset = "";
  $tngpage = 1;
}

$wherestr = $searchstring ? " AND (username LIKE \"%$searchstring%\" OR description LIKE \"%$searchstring%\" OR realname LIKE \"%$searchstring%\" OR email LIKE \"%$searchstring%\")" : "";
$wherestr .= $adminonly ? " AND allow_add = \"1\" AND allow_edit = \"1\" AND allow_delete = \"1\" AND gedcom = \"\"" : "";
$query = "SELECT *, DATE_FORMAT(lastlogin,\"%d %b %Y %H:%i:%s\") as lastlogin FROM $users_table WHERE allow_living != \"-1\" $wherestr ORDER BY description LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);

$numrows = tng_num_rows($result);
if ($numrows == $maxsearchresults || $offsetplus > 1) {
  $query = "SELECT count(userID) as ucount FROM $users_table WHERE allow_living != \"-1\" $wherestr";
  $result2 = tng_query($query);
  $row = tng_fetch_assoc($result2);
  $totrows = $row['ucount'];
  tng_free_result($result2);
} else {
  $totrows = $numrows;
}

$revquery = "SELECT count(userID) as ucount FROM $users_table WHERE allow_living = \"-1\"";
$revresult = tng_query($revquery) or die ($admtext['cannotexecutequery'] . ": $revquery");
$revrow = tng_fetch_assoc($revresult);
$revstar = $revrow['ucount'] ? " *" : "";
tng_free_result($revresult);

$helplang = findhelp("users_help.php");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['users'], $flags);
?>
<script type="text/javascript">
    function confirmDelete(ID) {
        if (confirm('<?php echo $admtext['confuserdelete']; ?>'))
            deleteIt('user', ID);
        return false;
    }
</script>
<script type="text/javascript" src="js/admin.js"></script>
</head>

<body background="img/background.gif">

<?php
$usertabs[0] = array(1, "admin_users.php", $admtext['search'], "finduser");
$usertabs[1] = array($allow_add, "admin_newuser.php", $admtext['addnew'], "adduser");
$usertabs[2] = array($allow_edit, "admin_reviewusers.php", $admtext['review'] . $revstar, "review");
$usertabs[3] = array(1, "admin_mailusers.php", $admtext['email'], "mail");
$innermenu = "<a href=\"#\" onclick=\"return openHelp('$helplang/users_help.php');\" class=\"lightlink\">{$admtext['help']}</a>";
$menu = doMenu($usertabs, "finduser", $innermenu);
echo displayHeadline($admtext['users'], "img/users_icon.gif", $menu, $message);
?>

<table width="100%" cellpadding="10" cellspacing="2" class="lightback">
  <tr class="databack">
    <td class="tngshadow">
      <div class="normal">

        <form action="admin_users.php" name="form1">
          <table class="normal">
            <tr>
              <td><?php echo $admtext['searchfor']; ?>:</td>
                            <td><input type="text" name="searchstring" value="<?php echo $searchstring; ?>" class="longfield"></td>
                            <td>
                                <input type="submit" name="submit" value="<?php echo $admtext['search']; ?>" class="aligntop">
                                <input type="submit" name="submit" value="<?php echo $admtext['reset']; ?>" onClick="document.form1.searchstring.value=''; document.form1.adminonly.checked=false;" class="aligntop">
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td colspan="2">
                                <input type="checkbox" name="adminonly" value="yes"<?php if ($adminonly == "yes") {
                                  echo " checked";
                                } ?>> <?php echo $admtext['adminonly']; ?>
                            </td>
                        </tr>
                    </table>

                  <input type="hidden" name="finduser" value="1"><input type="hidden" name="newsearch" value="1">
                </form>
              <br>

              <?php
              $numrowsplus = $numrows + $offset;
              if (!$numrowsplus) {
                $offsetplus = 0;
              }
              echo displayListLocation($offsetplus, $numrowsplus, $totrows);
              $pagenav = get_browseitems_nav($totrows, "admin_users.php?searchstring=$searchstring&amp;offset", $maxsearchresults, 5);
              echo " &nbsp; <span class=\"adminnav\">$pagenav</span></p>";
              ?>
                <form action="admin_deleteselected.php" method="post" name="form2">
                  <?php
                  if ($allow_delete) {
                    ?>
                      <p>
                          <input type="button" name="selectall" value="<?php echo $admtext['selectall']; ?>" onClick="toggleAll(1);">
                          <input type="button" name="clearall" value="<?php echo $admtext['clearall']; ?>" onClick="toggleAll(0);">
                          <input type="submit" name="xuseraction" value="<?php echo $admtext['deleteselected']; ?>" onClick="return confirm('<?php echo $admtext['confdeleterecs']; ?>');">
                      </p>
                    <?php
                  }
                  ?>

                  <table cellpadding="3" cellspacing="1" class="normal">
                    <tr>
                      <td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['action']; ?></b>&nbsp;</nobr></span></td>
                          <?php
                          if ($allow_delete) {
                            ?>
                              <td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['select']; ?></b>&nbsp;</nobr></span></td>
                            <?php
                          }
                          ?>
                            <td class="fieldnameback fieldname nw">&nbsp;<b><?php echo $admtext['username']; ?></b>&nbsp;</td>
                            <td class="fieldnameback fieldname nw">&nbsp;<b><?php echo $admtext['description']; ?></b>&nbsp;</td>
                            <td class="fieldnameback fieldname nw">&nbsp;<b><?php echo $admtext['realname'] . " / " . $admtext['email']; ?></b>&nbsp;</td>
                            <td class="fieldnameback fieldname nw">&nbsp;<b><?php echo $admtext['tree']; ?></b>&nbsp;</td>
                            <td class="fieldnameback fieldname nw">&nbsp;<b><?php echo $admtext['branch']; ?></b>&nbsp;</td>
                            <td class="fieldnameback fieldname nw">&nbsp;<b><?php echo $admtext['role']; ?></b>&nbsp;</td>
                            <td class="fieldnameback fieldname nw">&nbsp;<b><?php echo $admtext['living']; ?></b>&nbsp;</td>
                            <td class="fieldnameback fieldname nw">&nbsp;<b><?php echo $admtext['text_private']; ?></b>&nbsp;</td>
                            <td class="fieldnameback fieldname nw">&nbsp;<b>GED</b>&nbsp;</td>
                            <td class="fieldnameback fieldname nw">&nbsp;<b>PDF</b>&nbsp;</td>
                            <td class="fieldnameback fieldname nw">&nbsp;<b><?php echo $admtext['lds']; ?></b>&nbsp;</td>
                            <td class="fieldnameback fieldname nw">&nbsp;<b><?php echo $admtext['lastlogin']; ?></b>&nbsp;</td>
                            <td class="fieldnameback fieldname nw">&nbsp;<b><?php echo $admtext['disabled']; ?></b>&nbsp;</td>
                        </tr>

                      <?php
                      if ($numrows) {
                      $actionstr = "";
                      if ($allow_edit) {
                        $actionstr .= "<a href=\"admin_edituser.php?userID=xxx\" title=\"{$admtext['edit']}\" class=\"smallicon admin-edit-icon\"></a>";
                      }
                      if ($allow_delete) {
                        $actionstr .= "<a href=\"#\" onClick=\"return confirmDelete('xxx');\" title=\"{$admtext['text_delete']}\" class=\"smallicon admin-delete-icon\"></a>";
                      }

                      while ($row = tng_fetch_assoc($result)) {
                        $form_allow_admin = $row['gedcom'] || (!$row['allow_edit'] && !$row['allow_add'] && !$row['allow_delete']) ? "" : $admtext['yes'];
                        $form_allow_lds = $row['allow_lds'] ? $admtext['yes'] : "";
                        $form_allow_living = $row['allow_living'] > 0 ? $admtext['yes'] : "";
                        $form_allow_private = $row['allow_private'] > 0 ? $admtext['yes'] : "";
                        $form_allow_ged = $row['allow_ged'] ? $admtext['yes'] : "";
                        $form_allow_pdf = $row['allow_pdf'] ? $admtext['yes'] : "";
                        $form_disabled = $row['disabled'] ? $admtext['yes'] : "";
                        $newactionstr = preg_replace("/xxx/", $row['userID'], $actionstr);
                        echo "<tr id=\"row_{$row['userID']}\"><td class=\"lightback\" valign=\"top\"><div class=\"action-btns2\">$newactionstr</div></td>\n";
                        if ($allow_delete) {
                          echo "<td class=\"lightback\" valign=\"top\" align=\"center\"><input type=\"checkbox\" name=\"del{$row['userID']}\" value=\"1\"></td>";
                        }
                        $editlink = "admin_edituser.php?userID={$row['userID']}";
                        $username = $allow_edit ? "<a href=\"$editlink\" title=\"{$admtext['edit']}\">" . $row['username'] . "</a>" : $row['username'];

                        echo "<td class=\"lightback\" valign=\"top\" nowrap>&nbsp;$username&nbsp;</td>\n";
                        echo "<td class=\"lightback\" valign=\"top\">&nbsp;{$row['description']}&nbsp;</td>\n";
                        echo "<td class=\"lightback\" valign=\"top\">&nbsp;" . $row['realname'];
                        if ($row['realname'] && $row['email']) {
                          echo "<br>&nbsp;";
                        }
                        $rolestr = 'usr' . ($row['role'] ? $row['role'] : 'custom');
                        echo "<a href=\"mailto:" . $row['email'] . "\">" . $row['email'] . "</a>&nbsp;</td>\n";

                          echo "<td class=\"lightback nw\" valign=\"top\">&nbsp;{$row['gedcom']}&nbsp;</td>\n";
                        echo "<td class=\"lightback nw\" valign=\"top\">&nbsp;{$row['branch']}&nbsp;</td>\n";
                        echo "<td class=\"lightback nw\" valign=\"top\">&nbsp;{$admtext[$rolestr]}&nbsp;</td>\n";
                        echo "<td class=\"lightback nw\" valign=\"top\">&nbsp;$form_allow_living&nbsp;</td>\n";
                        echo "<td class=\"lightback nw\" valign=\"top\">&nbsp;$form_allow_private&nbsp;</td>\n";
                        echo "<td class=\"lightback nw\" valign=\"top\">&nbsp;$form_allow_ged&nbsp;</td>\n";
                        echo "<td class=\"lightback nw\" valign=\"top\">&nbsp;$form_allow_pdf&nbsp;</td>\n";
                        echo "<td class=\"lightback nw\" valign=\"top\">&nbsp;$form_allow_lds&nbsp;</td>\n";
                        echo "<td class=\"lightback nw\" valign=\"top\">&nbsp;{$row['lastlogin']}&nbsp;</td>\n";
                        echo "<td class=\"lightback nw\" valign=\"top\">&nbsp;$form_disabled&nbsp;</td>\n";
                        echo "</tr>\n";
                      }
                      ?>
                    </table>
                <?php
                echo displayListLocation($offsetplus, $numrowsplus, $totrows);
                echo " &nbsp; <span class=\"adminnav\">$pagenav</span></p>";
                }
                else {
                  echo $admtext['norecords'];
                }
                tng_free_result($result);
                ?>
                </form>

            </div>
        </td>
    </tr>

</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
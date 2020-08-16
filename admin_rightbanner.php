<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");
$maint = $tngconfig['maint'];
$tngconfig['maint'] = "";
include($cms['tngpath'] . "adminlib.php");
$textpart = "index";
//include("getlang.php");
include("$mylanguage/admintext.php");
$admin_login = 2;

if ($link) {
  include($cms['tngpath'] . "checklogin.php");
}
include($cms['tngpath'] . "version.php");

$home_url = $homepage;

$helplang = findhelp("index_help.php");
if ($sitever == "mobile") {
  $tng_title = $tng_abbrev;
}

tng_adminheader($admtext['administration'], "");
?>
</head>

<body class="sideback">
<table cellspacing="0" cellpadding="1" width="100%">
    <tr>
        <td><span class="whiteheader"><strong><?php echo "$tng_title, v.$tng_version"; ?></strong></span></td>
        <td align="right">
          <?php
          if ($link) {
            if ($allow_admin) {
              $trees = explode(',', $_SESSION['availabletrees']);
              if (count($trees) > 1) {
                $query = "";
                foreach ($trees as $t) {
                  if ($query) {
                    $query .= " UNION ";
                  }
                  $query .= "SELECT gedcom, treename FROM $trees_table WHERE gedcom = \"$t\"";
                }
                $query .= " ORDER BY treename";
                $result = tng_query($query);
                echo "<form action=\"{$cms['tngpath']}switchtree.php\" target=\"_parent\" name=\"newtreeform\" style=\"display:inline-block\">\n";
                echo "<input type=\"hidden\" name=\"ret\" value=\"admin.php\">\n";
                echo "<select name=\"newtree\" class=\"normal\" onChange=\"document.newtreeform.submit();\">\n";
                while ($row = tng_fetch_assoc($result)) {
                  echo "<option value=\"{$row['gedcom']}\"";
                  if ($assignedtree == $row['gedcom']) {
                    echo " selected";
                  }
                  echo ">{$row['treename']}</option>\n";
                }
                echo "</select>\n</form>\n";
                tng_free_result($result);
              }
            }
            if ($chooselang) {
              $query = "SELECT languageID, display, folder FROM $languages_table ORDER BY display";
              $result = @tng_query($query);

              if ($result && tng_num_rows($result)) {
                echo "<form action=\"{$cms['tngpath']}admin_savelanguage.php\" method=\"GET\" target=\"_parent\" name=\"language\" style=\"display:inline-block\">\n";
                echo " &nbsp;<select name=\"newlanguage\" class=\"normal\" onChange=\"document.language.submit();\">\n";

                while ($row = tng_fetch_assoc($result)) {
                  echo "<option value=\"{$row['languageID']}\"";
                  if ($languages_path . $row['folder'] == $mylanguage) {
                    echo " selected";
                  }
                  echo ">{$row['display']}</option>\n";
                }
                echo "</select>\n</form>\n";
                tng_free_result($result);
              }
            }
          }
          ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
			<span class="whitetext normal">
			<a href="admin.php" target="_parent" class="lightlink"><?php echo $admtext['adminhome']; ?></a>
			&nbsp;|&nbsp; <a href="<?php echo $home_url; ?>" target="_parent" class="lightlink"><?php echo $admtext['publichome']; ?></a>
<?php
if ($allow_admin) {
  echo "&nbsp;|&nbsp; <a href=\"{$cms['tngpath']}adminshowlog.php\" class=\"lightlink\" target=\"main\">{$admtext['showlog']}</a>\n";
}
if ($sitever != "mobile") {
  ?>
    &nbsp;|&nbsp; <a href="#" onclick="return openHelp('<?php echo $helplang; ?>/index_help.php');" class="lightlink"><?php echo $admtext['getstart']; ?></a>

<?php
  if ($maint) {
    echo "&nbsp;|&nbsp; <strong><span class=\"yellow\">{$text['mainton']}</span></strong>\n";
  }
  ?>
			&nbsp;|&nbsp; <a href="https://tng.lythgoes.net/wiki" class="lightlink" target="_blank">TNG Wiki</a>
			&nbsp;|&nbsp; <a href="https://tng.community" class="lightlink" target="_blank">TNG Forum</a>
  <?php
}
?>
			&nbsp;|&nbsp; <a href="logout.php?admin_login=1" class="lightlink" target="_parent"><?php echo $admtext['logout'] . "&nbsp; (<strong>$currentuser</strong>)"; ?></a>
			</span>
        </td>
    </tr>
</table>
</form>
</body>
</html>
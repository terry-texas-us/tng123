<?php
include "processvars.php";

include "subroot.php";
include "tngconnect.php";
if (!file_exists($subroot . "config.php")) {
  $subroot = $_GET['sr'];
}
include $subroot . "config.php";

$templatepfx = is_numeric($templatenum) ? "template" : "";
$templatepath = $templateswitching && $templatenum ? "templates/$templatepfx$templatenum/" : "";

include "adminlib.php";
if ($subroot != $_GET['sr']) {
  $subroot = $_GET['sr'];
}
$textpart = "setup";

if (isset($sitever)) {
  setcookie("tng_siteversion", $sitever, time() + 31536000, "/");
} elseif (isset($_COOKIE['tng_siteversion'])) {
  $sitever = $_COOKIE['tng_siteversion'];
}

include_once "siteversion.php";
if (!$sitever) {
  $sitever = getSiteVersion();
}

session_start();
$session_language = $_SESSION['session_language'];
$session_charset = $_SESSION['session_charset'];

$languages_path = "languages/";
include "getlang.php";
include "$mylanguage/admintext.php";
$link = tng_db_connect($database_host, $database_name, $database_username, $database_password, $database_port, $database_socket);
if ($link) {
  $admin_login = 1;
  include "checklogin.php";
  if ($assignedtree) {
    $message = $admtext['norights'];
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
  }
}

require_once "./core/templates.php";
$tmp = getTemplateVars($templates_table, $templatenum);

include "version.php";

$error_reporting = ((int)ini_get('error_reporting')) & E_NOTICE;

$helplang = findhelp("setup_help.php");

if (!$sub) {
  $sub = "configuration";
}
$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['setup'], $flags);
?>
</head>

<body background="img/background.gif">

<?php
$setuptabs[0] = array(1, "admin_setup.php", $admtext['configuration'], "configuration");
$setuptabs[1] = array(1, "admin_diagnostics.php", $admtext['diagnostics'], "diagnostics");
$setuptabs[2] = array(1, "admin_setup.php?sub=tablecreation", $admtext['tablecreation'], "tablecreation");
$internallink = $sub == "configuration" ? "config" : "tables";
$innermenu = "<a href=\"#\" onclick=\"return openHelp('$helplang/setup_help.php#$internallink');\" class=\"lightlink\">{$admtext['help']}</a>";
$menu = doMenu($setuptabs, $sub, $innermenu);
echo displayHeadline($admtext['setup'] . " &gt;&gt; " . $admtext[$sub], "img/setup_icon.gif", $menu, "");
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
    <tr class="databack">
        <td class="tngshadow">
          <?php
          if ($sub == "configuration") {
            ?>
              <span class="normal"><i><?php echo $admtext['entersysvars']; ?></i></span><br/><br/>

              <table cellspacing="0" border="0">
                  <tr>
                      <td>
                          <p class="subhead"><img src="img/tng_expand.gif" width="15" height="15" border="0"/> <a href="admin_genconfig.php"><b><?php echo $admtext['configsettings']; ?></b></a></p>
                          <p class="subhead"><img src="img/tng_expand.gif" width="15" height="15" border="0"/> <a href="admin_pedconfig.php"><b><?php echo $admtext['pedconfigsettings']; ?></b></a></p>
                      </td>
                      <td style="width:50px">&nbsp;</td>
                      <td>
                          <p class="subhead"><img src="img/tng_expand.gif" width="15" height="15" border="0"/> <a href="admin_logconfig.php"><b><?php echo $admtext['logconfigsettings']; ?></b></a></p>
                          <p class="subhead"><img src="img/tng_expand.gif" width="15" height="15" border="0"/> <a href="admin_importconfig.php"><b><?php echo $admtext['importconfigsettings']; ?></b></a></p>
                      </td>
                      <td style="width:50px">&nbsp;</td>
                      <td>
                          <p class="subhead"><img src="img/tng_expand.gif" width="15" height="15" border="0"/> <a href="admin_mapconfig.php"><b><?php echo $admtext['mapconfigsettings']; ?></b></a></p>
                          <p class="subhead"><img src="img/tng_expand.gif" width="15" height="15" border="0"/> <a href="admin_templateconfig.php"><b><?php echo $admtext['templateconfigsettings']; ?></b></a></p>
                      </td>
                  </tr>
              </table>
              <br/>
              <p class="normal"><em><?php echo $admtext['custvars']; ?></em></p>
            <?php
          } elseif ($sub == "tablecreation") {
            ?>
              <span class="normal"><i><?php echo $admtext['createdbtables']; ?></i></span><br/>

              <p class="normal"><em><?php echo $admtext['tcwarning']; ?></em></p>
              <form action="">
                <?php echo $admtext['collation']; ?>: <input type="text" name="collation" value="utf8_general_ci"/> <?php echo $admtext['collationexpl']; ?><br/><br/>
                  <input type="button" value="<?php echo $admtext['createtables']; ?>" onClick="if( confirm( '<?php echo $admtext['conftabledelete']; ?>' ) ) window.location.href = 'admin_tablecreate.php';">
              </form>
            <?php
          }
          ?>
        </td>
    </tr>
</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
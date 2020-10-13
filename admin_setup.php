<?php
include "processvars.php";
error_reporting(E_ERROR);
$tngconfig = [];

include "tngconnect.php";
include "config/config.php";

$templatepfx = is_numeric($templatenum) ? "template" : "";
$templatepath = $templateswitching && $templatenum ? "templates/$templatepfx$templatenum/" : "";

include "adminlib.php";
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
tng_adminheader($admtext['setup'], $flags);

echo "</head>\n";
echo tng_adminlayout();

$setuptabs[0] = [1, "admin_setup.php", $admtext['configuration'], "configuration"];
$setuptabs[1] = [1, "admin_diagnostics.php", $admtext['diagnostics'], "diagnostics"];
$setuptabs[2] = [1, "admin_setup.php?sub=tablecreation", $admtext['tablecreation'], "tablecreation"];
$internallink = $sub == "configuration" ? "config" : "tables";
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/setup_help.php#$internallink');\" class='lightlink'>{$admtext['help']}</a>";
$menu = doMenu($setuptabs, $sub, $innermenu);
echo displayHeadline($admtext['setup'] . " &gt;&gt; " . $admtext[$sub], "img/setup_icon.gif", $menu, "");
?>

<table class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <?php if ($sub == "configuration") { ?>
                <span class="normal"><em><?php echo $admtext['entersysvars']; ?></em></span><br><br>

                <table>
                    <tr>
                        <td>
                            <h3 class="subhead"><img src="img/tng_expand.gif" width="15" height="15"> <a href="admin_genconfig.php"><?php echo $admtext['configsettings']; ?></a></h3>
                            <h3 class="subhead"><img src="img/tng_expand.gif" width="15" height="15"> <a href="admin_pedconfig.php"><?php echo $admtext['pedconfigsettings']; ?></a></h3>
                        </td>
                        <td style="width:50px;">&nbsp;</td>
                        <td>
                            <h3 class="subhead"><img src="img/tng_expand.gif" width="15" height="15"> <a href="admin_logconfig.php"><?php echo $admtext['logconfigsettings']; ?></a></h3>
                            <h3 class="subhead"><img src="img/tng_expand.gif" width="15" height="15"> <a href="admin_importconfig.php"><?php echo $admtext['importconfigsettings']; ?></a></h3>
                        </td>
                        <td style="width:50px;">&nbsp;</td>
                        <td>
                            <h3 class="subhead"><img src="img/tng_expand.gif" width="15" height="15"> <a href="admin_mapconfig.php"><?php echo $admtext['mapconfigsettings']; ?></a></h3>
                            <h3 class="subhead"><img src="img/tng_expand.gif" width="15" height="15"> <a href="admin_templateconfig.php"><?php echo $admtext['templateconfigsettings']; ?></a></h3>
                        </td>
                    </tr>
                </table>
                <br>
                <p class="normal"><em><?php echo $admtext['custvars']; ?></em></p>
            <?php } elseif ($sub == "tablecreation") { ?>
                <span class="normal"><em><?php echo $admtext['createdbtables']; ?></em></span><br>

                <p class="normal"><em><?php echo $admtext['tcwarning']; ?></em></p>
                <form action="">
                    <?php echo $admtext['collation']; ?>:
                    <input type="text" name="collation" value="utf8_general_ci"> <?php echo $admtext['collationexpl']; ?><br><br>
                    <input type="button" value="<?php echo $admtext['createtables']; ?>"
                        onClick="if( confirm( '<?php echo $admtext['conftabledelete']; ?>' ) ) window.location.href = 'admin_tablecreate.php';">
                </form>
            <?php } ?>
        </td>
    </tr>
</table>
<?php echo tng_adminfooter(); ?>
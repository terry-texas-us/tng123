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
if (!$sitever) $sitever = getSiteVersion();


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
        $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
        header("Location: admin_login.php?message=" . urlencode($message));
        exit;
    }
}

require_once "./core/templates.php";
$tmp = getTemplateVars($templates_table, $templatenum);

include "version.php";

$error_reporting = ((int)ini_get('error_reporting')) & E_NOTICE;

$helplang = findhelp("setup_help.php");

if (!$sub) $sub = "configuration";

tng_adminheader(_('Setup'), $flags);

echo "</head>\n";
echo tng_adminlayout();

$setuptabs[0] = [1, "admin_setup.php", _('Configuration'), "configuration"];
$setuptabs[1] = [1, "admin_diagnostics.php", _('Diagnostics'), "diagnostics"];
$setuptabs[2] = [1, "admin_setup.php?sub=tablecreation", _('Table Creation'), "tablecreation"];
$internallink = $sub == "configuration" ? "config" : "tables";
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/setup_help.php#$internallink');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($setuptabs, $sub, $innermenu);
echo displayHeadline(_('Setup') . " &gt;&gt; " . $admtext[$sub], "img/setup_icon.gif", $menu, "");
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <?php if ($sub == "configuration") { ?>
                    <span class="normal"><em><?php echo _('Enter values for system variables.'); ?></em></span><br><br>

                    <table>
                        <tr>
                            <td>
                                <h3 class="subhead"><a href="admin_genconfig.php"><img src="img/tng_expand.gif" class="inline-block mr-3"><?php echo _('General Settings'); ?></a></h3>
                                <h3 class="subhead"><a href="admin_pedconfig.php"><img src="img/tng_expand.gif" class="inline-block mr-3"><?php echo _('Chart Settings'); ?></a></h3>
                            </td>
                            <td style="width:50px;">&nbsp;</td>
                            <td>
                                <h3 class="subhead"><a href="admin_logconfig.php"><img src="img/tng_expand.gif" class="inline-block mr-3"><?php echo _('Log Settings'); ?></a></h3>
                                <h3 class="subhead"><a href="admin_importconfig.php"><img src="img/tng_expand.gif" class="inline-block mr-3"><?php echo _('Import Settings'); ?></a></h3>
                            </td>
                            <td style="width:50px;">&nbsp;</td>
                            <td>
                                <h3 class="subhead"><a href="admin_mapconfig.php"><img src="img/tng_expand.gif" class="inline-block mr-3"><?php echo _('Map Settings'); ?></a></h3>
                                <h3 class="subhead"><a href="admin_templateconfig.php"><img src="img/tng_expand.gif" class="inline-block mr-3"><?php echo _('Template Settings'); ?></a></h3>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <p class="normal"><em><?php echo _('Note: You may create your own custom settings in \"customconfig.php\" (open in a text editor and follow the instructions).'); ?></em></p>
                <?php } elseif ($sub == "tablecreation") { ?>
                    <span class="normal"><em><?php echo _('Create the database tables to hold your information.'); ?></em></span><br>

                    <p class="normal">
                        <em><?php echo _('<strong>Warning!</strong> Select this option only when you are setting your site up for the first time. <strong>All existing data, including photos, histories, headstones and cemetery information, will be erased!</strong>'); ?></em>
                    </p>
                    <form action="">
                        <?php echo _('Collation'); ?>:
                        <input type="text" name="collation" value="utf8_general_ci"> <?php echo _('(leave blank to accept the default)'); ?><br><br>
                        <input type="button" value="<?php echo _('Create Tables'); ?>"
                            onClick="if( confirm( '<?php echo _('This will delete ALL your existing data!! Are you sure you want to continue?'); ?>' ) ) window.location.href = 'admin_tablecreate.php';">
                    </form>
                <?php } ?>
        </td>
    </tr>
</table>
<?php echo tng_adminfooter(); ?>
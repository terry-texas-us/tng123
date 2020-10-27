<?php

ob_start('ob_gzhandler');
define('YES', "1");
define('EDITP', 5);

require "begin.php";
require "adminlib.php";
$textpart = "mods";
require "getlang.php";

require "$mylanguage/admintext.php";
$helplang = findhelp("modhandler_help.php");
$thisfile = $_SERVER['PHP_SELF'];

$admin_login = 1;
require "checklogin.php";
require "version.php";
require "classes/version.php";

$cfgfolder = rtrim($rootpath, "/") . '/' . trim($modspath, "/") . '/';
$mhuser = isset($_SESSION['currentuserdesc']) ? $_SESSION['currentuser'] : "";

require "config/mmconfig.php";

$flags['modmgr'] = true;
tng_adminheader($admtext['modmgr'], $flags);

$min_width = '640px';
echo "<style>body {margin: 0; overflow-y: scroll; min-width: $min_width;}</style>";

echo "</head>\n";

echo tng_adminlayout();

$modtabs = set_horizontal_tabs($options['show_analyzer'], $options['show_updates']);
$innermenu = set_innermenu_links($tng_version);
$menu = "<div class='mmmenuwrap'>";
$menu .= doMenu($modtabs, "modlist", $innermenu);
$menu .= "</div>";

if (!isset($message)) $message = "";
$headline = displayHeadline($admtext['modmgr'] . ' - ' . ucwords($admtext['edparams']), "img/modmgr_icon.gif", $menu, $message);

require 'classes/modobjinits.php';

if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        ${$key} = $value;
    }
    if ($submit == "pUpdate") {
        include_once 'classes/modeditor.class.php';
        $oEdit = new modeditor($objinits);
        if ($oEdit->update_parameter($param)) {
            $action = EDITP;
            $cfgpath = $param['cfg'];
        } else {
            header("Location:admin_showmodslog.php");
            exit;
        }
    } elseif ($submit == "pRestore") {
        include_once 'classes/modeditor.class.php';
        $oEdit = new modeditor($objinits);
        if ($oEdit->restore_parameter($param)) {
            $action = EDITP;
            $cfgpath = $param['cfg'];
        } else {
            header("Location:admin_showmodslog.php");
            exit;
        }
    } elseif ($submit == "pCancel") {
        header("Location:admin_modhandler.php");
    }
}
elseif (!empty($_GET)) {
    foreach ($_GET as $key => $value) {
        ${$key} = $value;
    }
    if (isset($a)) {
        $action = $a;
        $cfgfile = isset($m) ? $m : '';
        $cfgpath = isset($m) ? $cfgfolder . $m : '';
    }
}
if ($options['fix_header'] == YES) {
    $headclass = 'mmhead-fixed';
    $tableclass = 'm2table-fixed';
} else {
    $headclass = 'mmhead-scroll';
    $tableclass = 'm2table-scroll';
}

echo "<div id='mmhead' class='$headclass adminback'>";
echo $headline;
echo "</div>";

if (!empty($action) && $action == EDITP) {

    if (!class_exists("modeditor")) {
        require_once 'classes/modeditor.class.php';
        $oEdit = new modeditor($objinits);
    }

    if (!$oEdit->show_editor($cfgpath)) {
        ?>
        <script>
            window.location.href = "admin_showmodslog.php";
        </script>
        <?php
    }
}

echo tng_adminfooter();

ob_end_flush();

/**
 * @param int|string $show_analyzer
 * @param int|string $show_updates
 * @return array
 */
function set_horizontal_tabs($show_analyzer = NO, $show_updates = NO): array {
    global $admtext;

    $modtabs = [];
    $modtabs[0] = [1, "admin_modhandler.php", $admtext['modlist'], "modlist"];
    $modtabs[1] = [1, "admin_showmodslog.php", $admtext['viewlog'], "viewlog"];
    $modtabs[2] = [1, "admin_modoptions.php", $admtext['options'], "options"];
    if ($show_analyzer == YES) {
        $modtabs[3] = [1, "admin_analyzemods.php", $admtext['analyzefiles'], 'files'];
        $modtabs[4] = [1, "admin_modtables.php", $admtext['parsetable'], 'parser'];
    }
    if ($show_updates == YES) {
        $modtabs[5] = [1, "admin_modupdates.php", $admtext['recommendedfixes'], 'updates'];
    }
    return $modtabs;
}

/**
 * @param $tng_version
 * @return string
 */
function set_innermenu_links($tng_version): string {
    global $admtext;

    $parts = explode(".", $tng_version);
    $tngmodver = "{$admtext['tngmods']} v{$parts[0]}";
    $tngmodurl = "Mods_for_TNG_v{$parts[0]}";
    $helplang = findhelp("modhandler_help.php");

    $innermenu = "<a href='#' onclick=\"return openHelp('$helplang/modhandler_help.php');\" class='lightlink'>{$admtext['help']}</a>\n";
    $innermenu .= "&nbsp;|&nbsp;&nbsp;<a href='https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_Syntax' target='_blank' class='lightlink'>{$admtext['modsyntax']}</a>\n";
    $innermenu .= "&nbsp;|&nbsp;&nbsp;<a href='https://tng.lythgoes.net/wiki/index.php?title=Mod_Guidelines' target='_blank' class='lightlink'>{$admtext['modguidelines']}</a>\n";
    $innermenu .= "&nbsp;|&nbsp;&nbsp;<a href='https://tng.lythgoes.net/wiki/index.php?title=Category:$tngmodurl' target='_blank' class='lightlink'>$tngmodver</a>\n";

    return $innermenu;
}
?>
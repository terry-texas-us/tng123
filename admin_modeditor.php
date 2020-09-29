<?php
/*
   Mod Manager 12 parameter editor

   Instantiates modeditor class to do the editing.
*/
define('YES', "1");
define('EDITP', 5);

$debug = false;

include "begin.php";
include "adminlib.php";
$textpart = "mods";
include "getlang.php";

include "$mylanguage/admintext.php";
tng_db_connect($database_host, $database_name, $database_username, $database_password, $database_port, $database_socket) or exit;
$admin_login = 1;
include "checklogin.php";
include "version.php";
include "classes/version.php";
$thisfile = $_SERVER['PHP_SELF'];

include "config/mmconfig.php";
$helplang = findhelp("modhandler_help.php");

$parts = explode(".", $tng_version);        // added to determine TNG vNN for
$tngmodver = "{$admtext['tngmods']} v{$parts[0]}";    // Mods for TNG vNN text display
$tngmodurl = "Mods_for_TNG_v{$parts[0]}";    // Mods for TNG vNN URL

// SETUP THE PAGE HEADER AND MENUS
$modtabs = set_horizontal_tabs($options['show_analyzer'], $options['show_updates']);
$innermenu = set_innermenu_links($tng_version);
$menu = "<div class=\"mmmenuwrap\">";
$menu .= doMenu($modtabs, "modlist", $innermenu);
$menu .= "</div>";

if (!isset($message)) {
    $message = "";
}
$headline = displayHeadline($admtext['modmgr'] . ' - ' . ucwords($admtext['edparams']), "img/modmgr_icon.gif", $menu, $message);
$first_menu = TRUE;

$cfgfolder = rtrim($rootpath, "/") . '/' . trim($modspath, "/") . '/';
$mhuser = isset($_SESSION['currentuserdesc']) ? $_SESSION['currentuser'] : "";

// INITIALIZATIONS FOR MOD OBJECTS
require 'classes/modobjinits.php';

/*
// INITIALIZATIONS FOR MOD OBJECTS
$objinits = array (
   'rootpath'     => $rootpath,
   'modspath'     => $modspath,
   'extspath'     => $extspath,
   'options'      => $options,
   'time_offset'  => $time_offset,
   'sitever'      => $sitever,
   'currentuserdesc' => $mhuser,
   'admtext'      => $admtext,
   'templatenum'  => $templatenum,
   'tng_version'  => $tng_version
);
*/
/*************************************************************************
 * PROCESS POSTED FORM DATA
 *************************************************************************/
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
} /*************************************************************************
 * PROCESS QUERY LINE ARGS
 *************************************************************************/
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

/*************************************************************************
 * SHOW PAGE HEADER
 *************************************************************************/
$flags['tabs'] = $tngconfig['tabs'];
$flags['modmgr'] = true;
tng_adminheader($admtext['modmgr'], $flags);

$min_width = isMobile() ? '0' : '640px';
echo "
<style type='text/css'>
body {
   margin:0;
   overflow-y: scroll;
   min-width:$min_width;
}
</style>";

if ($options['fix_header'] == YES && !isMobile()) {
    $headclass = 'mmhead-fixed';
    $tableclass = 'm2table-fixed';
} else {
    $headclass = 'mmhead-scroll';
    $tableclass = 'm2table-scroll';
}

echo "
</head>
<body class=\"admin-body\">
<div id=\"mmhead\" class=\"$headclass adminback\">
   $headline
</div><!--head-section-->";
/*************************************************************************
 * SHOW EDIT FORM
 *************************************************************************/

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

/*************************************************************************
 * SHOW EDIT FORM
 *************************************************************************/
if (!isMobile() && $options['adjust_headers']) {
    echo "
<script>
   window.scroll(0,0);
   jQuery(document).ready(function() {
      // set position of the title bar (tbar) relative to mmhead
      jQuery('#tbar').position({
         my: 'left top',
         at: 'left bottom',
         of: jQuery('#mmhead'),
         collision: 'none'
      });

      // set position of m3table table relative to title bar (tbar)
      jQuery('#m3table').position({
         my: 'left top',
         at: 'left bottom',
         of: jQuery('#tbar'),
         collision: 'none'
      });
   });
</script>";
}

echo "
</body>
</html>";
exit;

function set_horizontal_tabs($show_analyzer = NO, $show_updates = NO) {
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

function set_innermenu_links($tng_version) {
    global $admtext;

    $parts = explode(".", $tng_version);        // added to determine TNG vNN for
    $tngmodver = "{$admtext['tngmods']} v{$parts[0]}";    // Mods for TNG vNN text display
    $tngmodurl = "Mods_for_TNG_v{$parts[0]}";    // Mods for TNG vNN URL
    $helplang = findhelp("modhandler_help.php");

    // inner menu help
    $innermenu = "<a href='#' onclick=\"return openHelp('$helplang/modhandler_help.php');\" class='lightlink'>{$admtext['help']}</a>";

    // MM syntax
    $innermenu .= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_Syntax\" target='_blank' class='lightlink'>{$admtext['modsyntax']}</a>";

    // mod guidelines
    $innermenu .= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"https://tng.lythgoes.net/wiki/index.php?title=Mod_Guidelines\" target='_blank' class='lightlink'>{$admtext['modguidelines']}</a>";

    // mods for TNGv10
    $innermenu .= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"https://tng.lythgoes.net/wiki/index.php?title=Category:$tngmodurl\" target='_blank' class='lightlink'>$tngmodver</a>";
    return $innermenu;
}

?>
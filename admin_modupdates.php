<?php

include "begin.php";
include "adminlib.php";
$textpart = "mods";
include "getlang.php";

include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";

if (!isset($modspath)) $modspath = '';
if (!isset($extspath)) $extspath = '';

require_once "config/mmconfig.php";

define("YES", 1);
define("NO", 0);

$flags['modmgr'] = true;
tng_adminheader($admtext['modmgr'], $flags);

$min_width = '640px';

if ($options['fix_header'] == YES) {
    ?>
    <style>
        body {
            overflow: hidden;
        }

        .mmcontainer {
            position: fixed;
            float: left;
            height: calc(100vh - 180px);
            overflow-y: scroll;
            overflow-x: hidden;
        }
    </style>
    <?php
}

echo "</head>\n";

echo tng_adminlayout();

$helplang = findhelp("modhandler_help.php");

if (!isset($options['show_analyzer'])) $options['show_analyzer'] = "0";
if (!isset($options['show_developer'])) $options['show_developer'] = "0";
if (!isset($options['show_updates'])) $options['show_updates'] = "0";

$modtabs = set_horizontal_tabs($options['show_analyzer'], $options['show_developer'], $options['show_updates']);
$innermenu = set_innermenu_links($tng_version);

$menu = "<div class='mmmenuwrap'>";
$menu .= doMenu($modtabs, "updates", $innermenu);
$menu .= "</div>";

if (!isset($message)) $message = "";
$headline = displayHeadline($admtext['modmgr'], "img/modmgr_icon.gif", $menu, $message);
$first_menu = TRUE;
if ($options['fix_header'] == YES) {
    $headclass = 'mmhead-fixed';
    $tableclass = 'm2table-fixed';
} else {
    $headclass = 'mmhead-scroll';
    $tableclass = 'm2table-scroll';
}

echo displayHeadline($admtext['modmgr'], "img/modmgr_icon.gif", $menu, $message);

$message = '';
if (!is_writable($rootpath))
    $message .= "{$admtext['checkwrite']} {$admtext['cantwrite']} $rootpath ";

if (!empty($message)) $message = "<span class='msgerror'>$message</span>";

echo "<table id='m2table' border='0' cellpadding='10' cellspacing='2' class='lightback $tableclass w-full' style=\"padding: 0;\">";
echo "<tr class='databack'>";
echo "<td class='tngshadow'>";

echo "<h3>{$admtext['recommendedfixes']}</h3>";
echo "<h4>{$admtext['updcusttext']}</h4>";

echo "<table class='normal'>";
echo "<tr>";
echo "<td>";
echo "<p class='normal'>{$admtext['custtextfixes']}</p>";
echo "<div class='normal'>{$admtext['reasontoupdate']}</div>";
echo "<p class='normal'>{$admtext['newanchor']}</p>";
echo "<p class='normal'>{$admtext['translateissue']}</p>";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo "<form action=''>";
echo "<input class='button space msgapproved' type='button' value=\"{$admtext['update']}\" onClick=\"if (confirm('{$admtext['confirmupdcusttext']}')) window.open('admin_cust_text_update.php', '_blank');\" />";
echo "</form>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<div align='right'><span class='normal'>$tng_title, v.$tng_version</span></div>";

echo tng_adminfooter();
exit;

function set_horizontal_tabs($show_analyzer = NO, $show_developer = NO, $show_updates = NO) {
    global $admtext;

    $modtabs = [];
    $modtabs[0] = [1, "admin_modhandler.php", $admtext['modlist'], "modlist"];
    $modtabs[1] = [1, "admin_showmodslog.php", $admtext['viewlog'], "viewlog"];
    $modtabs[2] = [1, "admin_modoptions.php", $admtext['options'], "options"];
    if ($show_analyzer == YES) {
        $modtabs[3] = [1, "admin_analyzemods.php", $admtext['analyzefiles'], 'files'];
    }
    if ($show_developer == YES) {
        $modtabs[4] = [1, "admin_modtables.php", $admtext['parsetable'], 'parser'];
    }
    if ($show_updates == YES) {
        $modtabs[5] = [1, "admin_modupdates.php", $admtext['recommendedfixes'], 'updates'];
    }
    return $modtabs;
}

function set_innermenu_links($tng_version) {
    global $text, $admtext;

    $parts = explode(".", $tng_version);    // added to determine TNG vNN for
    $tngmodver = "{$admtext['tngmods']} v{$parts[0]}";  // Mods for TNG vNN text display
    $tngmodurl = "Mods_for_TNG_v{$parts[0]}";  // Mods for TNG vNN URL
    $helplang = findhelp("modhandler_help.php");

    $innermenu = "<a href='#' onclick=\"return openHelp('$helplang/modhandler_help.php');\" class='lightlink'>{$admtext['help']}</a>\n";
    $innermenu .= "&nbsp;|&nbsp; <a href='#' class='lightlink' onClick=\"return toggleAll('on');\">{$text['expandall']}</a>\n";
    $innermenu .= "&nbsp;|&nbsp; <a href='#' class='lightlink' onClick=\"return toggleAll('off');\">{$text['collapseall']}</a>\n";
    $innermenu .= "&nbsp;|&nbsp;&nbsp;<a href=\"https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_Syntax\" target='_blank' class='lightlink'>{$admtext['modsyntax']}</a>\n";
    $innermenu .= "&nbsp;|&nbsp;&nbsp;<a href=\"https://tng.lythgoes.net/wiki/index.php?title=Mod_Guidelines\" target='_blank' class='lightlink'>{$admtext['modguidelines']}</a>\n";
    $innermenu .= "&nbsp;|&nbsp;&nbsp;<a href=\"https://tng.lythgoes.net/wiki/index.php?title=Category:$tngmodurl\" target='_blank' class='lightlink'>$tngmodver</a>\n";

    return $innermenu;
}

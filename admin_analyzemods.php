<?php

require 'begin.php';
require 'adminlib.php';
$textpart = "mods";

require "$mylanguage/admintext.php";
$helplang = findhelp("modhandler_help.php");

$admin_login = 1;
require 'checklogin.php';
require 'version.php';

define('YES', "1");
define('NO', "0");

$modspath .= '/';
$modfolder = 'tools/';

$flags['tabs'] = $tngconfig['tabs'];
$flags['modmgr'] = true;
tng_adminheader($admtext['modmgr'], $flags);

include "config/mmconfig.php";

if (!isset($options['show_analyzer'])) $options['show_analyzer'] = "0";
if (!isset($options['show_developer'])) $options['show_developer'] = "0";
if (!isset($options['show_updates'])) $options['show_updates'] = "0";

if ($options['fix_header'] == YES) {
    ?>
    <style>
        body {
            overflow: hidden;
        }

        .mmcontainer {
            position: fixed;
            float: left;
            height: 80%;
            overflow-y: scroll;
            overflow-x: hidden;
        }
    </style>
    <?php
}
$min_width = isMobile() ? '0' : '640px';
echo "<style>body {margin: 0; overflow-y: scroll; min-width: $min_width;}</style>\n";

echo "</head>\n";
echo tng_adminlayout();

$modtabs = set_horizontal_tabs($options['show_analyzer'], $options['show_developer'], $options['show_updates']);
$innermenu = set_innermenu_links($tng_version);

$menu = "<div class='mmmenuwrap'>";
$menu .= doMenu($modtabs, "files", $innermenu);
$menu .= "</div>";

if (!isset($message)) $message = "";

$headline = displayHeadline($admtext['modmgr'], "img/modmgr_icon.gif", $menu, $message);
if (empty($admtext['modguidelines'])) $admtext['modguidelines'] = "Mod Guidelines";

if ($options['fix_header'] == YES && !isMobile()) {
    $headclass = 'mmhead-fixed';
    $tableclass = 'm2table-fixed';
} else {
    $headclass = 'mmhead-scroll';
    $tableclass = 'm2table-scroll';
}

echo "<div id='mmhead' class='$headclass adminback'>";
echo $headline;
echo "</div>";
echo "<div class='mmcontainer'>";
echo "<table id='m2table' class='normal lightback $tableclass'>";
echo "<tr>";
echo "<td class='databack mmleftcol'>";

echo "<table class='normal tfixed'>";
echo "<tr>";
echo "<th class='fieldnameback fieldname'>{$admtext['filesel']}</th>";
echo "</tr>";
$modFiles = get_modfile_names();
$targetFiles = get_targetfile_names($modFiles);
display_targetfiles($targetFiles);
echo "<tr><td>&nbsp;</td></tr>";
echo "</table>";
echo "</td>";

echo "<td class='databack mmrightcol'>";
echo "<table class='normal tfixed'>";
echo "<tr>";
echo "<th class='fieldnameback fieldname'>{$admtext['potconf']}</th>";
echo "</tr>";

if ($_GET && is_array($_GET)) {
    if (!empty($mtarget)) {
        $file_hdr = str_replace('xxx', "<span class=\"mmhighlight\">$mtarget</span>", $admtext['filemod']);
        echo "<tr>";
        echo "<td class='databack'>";
        echo "<h2>$file_hdr:</h2>";
        echo "</td>";
        echo "</tr>";

        $id = 1;

        foreach ($modFiles as $file) {
            $buffer = file_get_contents($modspath . $file);
            $buffer = htmlentities($buffer, ENT_IGNORE);
            $buffer = preg_replace('#([@^~])#', '', $buffer);
            $buffer = str_replace('$modspath', $modspath, $buffer);
            $buffer = str_replace('$extspath', $extspath, $buffer);

            if (strpos($buffer, "%target:$mtarget%") || strpos($buffer, "%target: $mtarget")) {
                echo "<tr>";
                echo "<td class='databack'>";
                display_section_locations($file, $buffer, $mtarget, "id$id");
                $id++;
                echo "</td>";
                echo "</tr>";
            }
        }
    }
}
echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "</div> <!--mmcontainer-->";

echo "
<script>
function toggleSection(sectionName) {
   let section = document.getElementById(sectionName + 'div');
   let link = document.getElementById(sectionName + 'link');
   if (section.style.display === \"none\") {
      section.style.display = \"\";
      link.innerHTML = \"{$admtext['hide']}&nbsp;{$admtext['modifications']}\";
   }
   else {
      section.style.display = \"none\";
      link.innerHTML = \"{$admtext['show']}&nbsp;{$admtext['modifications']}\";
   }
   return false;
}
</script>";

echo tng_adminfooter();

/**
 * @param string $show_analyzer
 * @param string $show_developer
 * @param string $show_updates
 * @return array
 */
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

/**
 * @param $tng_version
 * @return string
 */
function set_innermenu_links($tng_version) {
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

/**
 * @return array
 */
function get_modfile_names() {
    global $modspath;

    $fileNames = [];
    $handle = opendir($modspath);
    if ($handle) {
        while (false !== ($file = readdir($handle))) {
            strtolower($file);
            if (pathinfo($file, PATHINFO_EXTENSION) == 'cfg') {
                $fileNames[] = $file;
            }
        }
        closedir($handle);
        sort($fileNames);
    }
    return $fileNames;
}

/**
 * @param $modFileNames
 * @return array
 */
function get_targetfile_names($modFileNames) {
    global $modspath, $extspath;

    $targets = [];
    foreach ($modFileNames as $fileName) {
        $buffer = file_get_contents($modspath . $fileName);
        $buffer = preg_replace('#([@^~])#', '', $buffer);
        $buffer = str_replace('$modspath', $modspath, $buffer);
        $buffer = str_replace('$extspath', $extspath, $buffer);
        $parts = explode("%target:", $buffer);

        for ($i = 1; $i < count($parts); $i++) {
            $element = substr($parts[$i], 0, (strpos($parts[$i], '%')));
            $args = explode(':', $element, $limit = 2);
            $element = trim($args[0]);
            if ($element == 'files') continue;
            if (strlen($element) > 0 && !in_array($element, $targets)) {
                $targets[] = $element;
            }
        }
    }
    sort($targets);
    return ($targets);
}

/**
 * @param $targetFiles
 */
function display_targetfiles($targetFiles) {
    foreach ($targetFiles as $mtarget) {
        echo "<tr><td class='lightback databack mmrightalign'>";
        echo "<a class='mmlinks' href=\"?mtarget=$mtarget\">$mtarget</a>";
        echo "</td></tr>";
    }
}

/**
 * @param $modfile
 * @param $contentstr
 * @param $mtarget
 * @param $id
 */
function display_section_locations($modfile, $contentstr, $mtarget, $id) {
    global $admtext;

    $contentstr = nl2br($contentstr);
    $sections = array_map('trim', explode("%target:", $contentstr));
    echo "<span class='mmfilenmfont'>$modfile</span>&nbsp;&nbsp;";
    echo "<a href='#' id=\"{$id}link\" onclick=\"return toggleSection('$id');\">{$admtext['show']}&nbsp;{$admtext['modifications']}</a><br>";
    echo "<div id=\"{$id}div\" style='display: none;'><br>";
    for ($i = 1; isset($sections[$i]); $i++) {
        $target_file = trim(preg_replace("#([^%]*)%.*#s", "\${1}", $sections[$i]));
        if (trim($target_file) == trim($mtarget)) {
            $locations = array_map('trim', explode("%location:%", $sections[$i]));
            for ($j = 1; isset($locations[$j]); $j++) {
                $locations[$j] = substr($locations[$j], 0, strripos($locations[$j], '%end:%'));
                $locations[$j] = str_replace("%end:%", "</strong>%end:%", $locations[$j]);
                $locations[$j] .= "%end:%<br>";
                $locations[$j] = preg_replace("@((%location|%end|%trim|%insert|%replace)[^%]*%)@i", "<span class=\"mmkeyword\">$1</span>", $locations[$j]);
                echo "<span class='mmlochdr'>// Location $j</span><br>";
                echo "<span class='mmkeyword'>%location:%</span><strong>{$locations[$j]}";
            }
        }
    }
    echo "</div>";
}

<?php

require "begin.php";
require "adminlib.php";
$textpart = "mods";

require_once "$mylanguage/admintext.php";
$helplang = findhelp("modmanager_help.php");

$admin_login = 1;
require "checklogin.php";
require "version.php";

define('YES', "1");
define('NO', "0");

if (!isset($sub)) $sub = "tables";

$flags['modmgr'] = true;
tng_adminheader($admtext['showlogfile'], $flags);

require "config/mmconfig.php";

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
            height: calc(100vh - 180px);
            overflow-y: scroll;
            overflow-x: hidden;
        }
    </style>
    <?php
}

$min_width = '640px';
echo "<style>body {margin: 0; overflow-y: scroll; min-width: $min_width;}</style>";

if ($options['compress_log'] == YES) {
    ?>
    <style>
        .action {
            padding-left: 15px;
            cursor: pointer;
            background: url(img/tng_expand.gif) no-repeat left center;
        }

        .collapse {
            background: url(img/tng_collapse.gif) no-repeat left center;
        }

        .collapse a {
            text-decoration: none;
        }

        .moddetails {
            display: none;
        }
    </style>
    <?php
    $hideDetails = "style='display: none;'";
} else {
    $hideDetails = "";
}

echo "</head>\n";

echo tng_adminlayout();

$parts = explode(".", $tng_version);

$modtabs = set_horizontal_tabs($options['show_analyzer'], $options['show_developer'], $options['show_updates']);

$innermenu = set_innermenu_links($tng_version);

$menu = "<div class='mmmenuwrap'>";
$menu .= doMenu($modtabs, "viewlog", $innermenu);
$menu .= "</div>";

if (!isset($message)) $message = "";
$headline = displayHeadline($admtext['modmgr'], "img/modmgr_icon.gif", $menu, $message);

$logheader = $admtext['recentactions'];
$first_menu = TRUE;

$clearmmlog = empty($_GET['clearmmlog']) ? false : true;
if ($options['fix_header'] == YES) {
    $headclass = 'mmhead-fixed';
    $ibarclass = 'ibar-fixed';
    $mmlogclass = 'mmlog-fixed';
} else {
    $headclass = 'mmhead-scroll';
    $ibarclass = 'ibar-scroll';
    $mmlogclass = 'mmlog-scroll';
}

echo "<div id='mmhead' class=\"$headclass adminback\">";
echo "$headline";
echo "</div>";

$logfilename = 'modmgrlog.txt';
if (!isset($options['modlogfile'])) $options['modlogfile'] = $logfilename;

if ($clearmmlog || !file_exists($options['modlogfile'])) {
    $content = "#### Mod Manager Log created " . date("D d M Y h:i:s A", time() + (3600 * $time_offset)) . " ####";
    file_put_contents($options['modlogfile'], $content);
}
$nColumns = 1;

echo "<div class='mmcontainer'>";
echo "<table id='infobar' class='normal lightback $ibarclass'>";
echo "<tr><td colspan='1' class='fieldnameback fieldname mmpadleft'>$logheader</td></tr>";
echo "</table>";

echo "<table id='mmlog' class='normal lightback $mmlogclass'>";

$lines = file($options['modlogfile']);
if ($lines) {
    $actionCount = 0;
    $logEntryDetails = "";

    $type1Or2EntryIsActive = false;
    $type3EntryIsActive = false;
    foreach ($lines as $line) {
        $newLogFormat = false;

        if (preg_match("/^\w{3} \d{2} \w{3} \d{4} \d{2}:\d{2}:\d{2} \w{2}/i", $line, $matches)) {
            $br = strpos($line, "<br>");
            if ($br !== false) {
                if (strlen($line) - $br > 20 || $br < 150) {
                    $newLogFormat = true;
                }
            }
        }
        if ($newLogFormat) {
            if ($logEntryDetails) {
                echo "<tr class='databack mmpadleft moddetails' $hideDetails id=\"data$actionCount\"><td colspan=\"$nColumns\">$logEntryDetails</td></tr>\n";
                $type3EntryIsActive = false;
            }
            $actionCount++;

            $heading = str_replace("<hr>", "", substr($line, 0, $br));

            $logEntryDetails = substr($line, $br + 6);
            $type1Or2EntryIsActive = true;

            if (false !== strpos($heading, "errors")) {
                $dynoclass = "msgerror";
            } elseif (false !== stripos($heading, "modrem")) {
                $dynoclass = "ready";
            } elseif (false !== stripos($heading, "installed")) {
                $dynoclass = "installed";
            } elseif (false !== stripos($heading, "updated")) {
                $dynoclass = "installed";
            } elseif (false !== stripos($heading, "filedel")) {
                $dynoclass = "";
            } else {
                $dynoclass = "lightback";
            }
            echo "<tr class=\"$dynoclass mmpadleft\">";
            echo "<td class=\"action\" id=\"action$actionCount\">$actionCount. $heading</td>";
            echo "</tr>\n";
        } else {
            $match = preg_match("/^(\w{3} \d{2} \w{3} \d{4} \d{2}:\d{2}:\d{2} \w{2}) ([.\w_-]*)\.cfg(.*)\(([\w: ]*)\)/i", $line, $matches);
            if ($match) {
                if ($logEntryDetails) {
                    echo "<tr class='databack mmpadleft moddetails' $hideDetails id=\"data$actionCount\"><td colspan=\"$nColumns\">$logEntryDetails</td></tr>\n";
                    $type1Or2EntryIsActive = false;
                    $logEntryDetails = "";
                }
                $actionCount++;
                $modFilename = $matches[2];
                echo "<tr class='databack mmpadleft'>";
                echo "<td class=\"action\" id=\"action$actionCount\">$actionCount. $line</td>";
                echo "</tr>";
                $type3EntryIsActive = true;
            } else {
                if ($type3EntryIsActive) {
                    $logEntryDetails = "$line</span><br>\n$logEntryDetails";
                } else {
                    if ($type1Or2EntryIsActive) {
                        $logEntryDetails .= "<br>$line";
                    } else {
                        echo "<tr><td class='databack mmpadleft' colspan=\"$nColumns\"><b>?? </b>$line</td></tr>\n";
                    }
                }
            }
        }
    }
}
if ($logEntryDetails) {
    echo "<tr class='databack mmpadleft moddetails' $hideDetails id=\"data$actionCount\">";
    echo "<td colspan=\"$nColumns\">$logEntryDetails</td>";
    echo "</tr>\n";
}

echo "</table>\n";
echo "<br>";
echo "</div>\n";

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
    global $text, $admtext;
    $parts = explode(".", $tng_version);
    $tngmodver = "{$admtext['tngmods']} v{$parts[0]}";
    $tngmodurl = "Mods_for_TNG_v{$parts[0]}";
    $helplang = findhelp("modhandler_help.php");

    $innermenu = "<a href='#' onclick=\"return openHelp('$helplang/modhandler_help.php');\" class='lightlink'>{$admtext['help']}</a>\n";
    $innermenu .= "&nbsp;|&nbsp; <a href='#' class='lightlink' id='expandall'> {$text['expandall']}</a>\n";
    $innermenu .= "&nbsp;|&nbsp; <a href='#' class='lightlink' id='collapseall'>{$text['collapseall']}</a>\n";
    $innermenu .= "&nbsp;|&nbsp; <a href=\"admin_showmodslog.php?clearmmlog=true\" onclick=\"return confirm('{$admtext['confirmclearlog']}')\" class='lightlink'>{$admtext['clearlog']}</a>\n";
    $innermenu .= "&nbsp;|&nbsp;&nbsp;<a href=\"https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_Syntax\" target='_blank' class='lightlink'>{$admtext['modsyntax']}</a>\n";
    $innermenu .= "&nbsp;|&nbsp;&nbsp;<a href=\"https://tng.lythgoes.net/wiki/index.php?title=Mod_Guidelines\" target='_blank' class='lightlink'>{$admtext['modguidelines']}</a>\n";
    $innermenu .= "&nbsp;|&nbsp;&nbsp;<a href=\"https://tng.lythgoes.net/wiki/index.php?title=Category:$tngmodurl\" target='_blank' class='lightlink'>$tngmodver</a>\n";

    return $innermenu;
}

?>
<script>
    jQuery(document).ready(function () {
        jQuery('.action').click(function () {
            let myId = jQuery(this).attr("id");
            let dataId = myId.replace("action", "data");
            if (jQuery(this).hasClass("collapse")) {
                jQuery('#' + dataId).hide();
                jQuery(this).removeClass("collapse");
            } else {
                jQuery(this).addClass("collapse");
                jQuery('#' + dataId).show();
            }
        });

        jQuery('#expandall').click(function (event) {
            jQuery(".action").addClass("collapse");
            jQuery(".moddetails").show();
            event.preventDefault();
        });

        jQuery('#collapseall').click(function (event) {
            jQuery(".action").removeClass("collapse");
            jQuery(".moddetails").hide();
            event.preventDefault();
        });
    });
</script>

<?php echo tng_adminfooter(); ?>

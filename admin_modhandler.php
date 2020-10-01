<?php

include "begin.php";
if (empty($rootpath)) {
    echo 'Error ', __LINE__, ': $rootpath missing! Please contact your system administrator.';
    exit;
}

include "adminlib.php";
$textpart = "mods";
include "getlang.php";

include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
include "classes/version.php";

if (!isset($modspath)) $modspath = '';
if (!isset($extspath)) $extspath = '';

define('NAMECOL', 1);
define('FILECOL', 0);
define('YES', "1");
define('NO', "0");
define('ON_ERROR', 0);
define('ON_ALL', 1);

define('ALL', 0);
define('INSTALL', 1);
define('REMOVE', 2);
define('DELETE', 3);
define('CLEANUP', 4);

define('F_SELECT', 5);

include "config/mmconfig.php";

if (isset($_GET['sort'])) $_SESSION['sortby'] = $_GET['sort'];
if (isset($_SESSION['sortby'])) $options['sortby'] = $_SESSION['sortby'];
if (!isset($options['show_analyzer'])) $options['show_analyzer'] = "0";
if (!isset($options['show_developer'])) $options['show_developer'] = "0";
if (!isset($options['show_updates'])) $options['show_updates'] = "0";
if (!isset($options['compress_log'])) $options['compress_log'] = "0";

$message = '';
if (!is_writable($rootpath)) {
    $message .= "{$admtext['checkwrite']} {$admtext['cantwrite']} $rootpath ";
}

if (!empty($message)) {
    $message = "<span class='msgerror'>$message</span>";
}

$cfgfolder = rtrim($rootpath, "/") . '/' . trim($modspath, "/") . '/';
$mhuser = isset($_SESSION['currentuserdesc']) ? $_SESSION['currentuser'] : "";

require 'classes/modobjinits.php';

$modlist = [];
if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        ${$key} = $value;
    }
    if (!empty($submit)) {
        if (!empty($mods)) {
            foreach ($mods as $mod) {
                if (isset($mod['selected'])) {
                    $modlist[] = $cfgfolder . $mod['file'];
                }
            }
        }
        if ($submit == "installall") {
            include_once 'classes/modinstaller.class.php';
            $oInstaller = new modinstaller($objinits);
            if (!$oInstaller->batch_install($modlist) || $options['redirect2log'] == ON_ALL) {
                header("Location:admin_showmodslog.php");
                exit;
            }
        } elseif ($submit == "removeall") {
            include_once 'classes/modremover.class.php';
            $oRemover = new modremover($objinits);
            if (!$oRemover->batch_remove($modlist) || $options['redirect2log'] == ON_ALL) {
                header("Location:admin_showmodslog.php");
                exit;
            }
        } elseif ($submit == "cleanupall") {
            include_once 'classes/modremover.class.php';
            $oRemover = new modremover($objinits);
            if (!$oRemover->batch_remove($modlist) || $options['redirect2log'] == ON_ALL) {
                header("Location:admin_showmodslog.php");
                exit;
            }
        } elseif ($submit == "deleteall") {
            include_once 'classes/moddeleter.class.php';
            $oDeleter = new moddeleter($objinits);
            if (!$oDeleter->batch_delete($modlist) || $options['redirect2log'] == ON_ALL) {
                header("Location:admin_showmodslog.php");
                exit;
            }
        }
    }
} elseif (!empty($_GET)) {
    foreach ($_GET as $key => $value) {
        ${$key} = $value;
    }
    if (isset($a)) {
        $action = $a;
        $cfgpath = isset($m) ? $cfgfolder . $m : '';

        if ($action == INSTALL) {
            include_once 'classes/modinstaller.class.php';
            $obj = new modinstaller($objinits);
            if (!$obj->install($cfgpath) || $options['redirect2log'] == ON_ALL) {
                header("Location:admin_showmodslog.php");
                exit;
            }
        } elseif ($action == REMOVE) {
            include_once 'classes/modremover.class.php';
            $obj = new modremover($objinits);
            if (!$obj->remove($cfgpath) || $options['redirect2log'] == ON_ALL) {
                header("Location:admin_showmodslog.php");
                exit;
            }
        } elseif ($action == DELETE) {
            $error = false;
            include_once 'classes/moddeleter.class.php';
            $obj = new moddeleter($objinits);
            if (!$obj->delete_mod($cfgpath) || $options['redirect2log'] == ON_ALL) {
                header("Location:admin_showmodslog.php");
                exit;
            }
        } elseif ($action == CLEANUP) {
            include_once 'classes/modremover.class.php';
            $obj = new modremover($objinits);
            $obj->classID = "cleaner";
            if (!$obj->remove($cfgpath) || $options['redirect2log'] == ON_ALL) {
                header("Location:admin_showmodslog.php");
                exit;
            }
        }
    }
}

$fbox_checked = false;

if (isset($newlist)) {
    unset($_SESSION['filter']);
    unset($_SESSION['modlist']);
} elseif (isset($_SESSION['filter'])) {
    $filter = $_SESSION['filter'];
    $fbox_checked = true;
} elseif (!empty($filter)) {
    $filter = 0;
} elseif (!isset($filter)) {
    $filter = 0;
}

$flags['tabs'] = $tngconfig['tabs'];
$flags['modmgr'] = true;
tng_adminheader($admtext['modmgr'], $flags);

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

$min_width = isMobile() ? '0' : '640px';
echo "<style>body {margin: 0; overflow-y: scroll; min-width: $min_width;}</style>\n";

echo "</head>\n";

echo tng_adminlayout();

$modtabs = set_horizontal_tabs($options['show_analyzer'], $options['show_developer'], $options['show_updates']);

$innermenu = set_innermenu_links($tng_version);
$menu = "<div class='mmmenuwrap'>";
$menu .= doMenu($modtabs, "modlist", $innermenu);
$menu .= "</div>";

echo displayHeadline($admtext['modmgr'], "img/modmgr_icon.gif", $menu, $message);

$headclass = $options['fix_header'] == YES && !isMobile() ? 'mmhead-fixed' : 'mmhead-scroll';

echo "<div class='mmcontainer whiteback'>";

if ($filter == F_SELECT && !empty($modlist)) {
    $_SESSION['modlist'] = $modlist;
} elseif ($filter == F_SELECT && isset($_SESSION['modlist'])) {
    $modlist = $_SESSION['modlist'];
} else {
    unset($_SESSION['modlist']);
    $modlist = [];
}

require_once 'classes/modlister.class.php';
$oModlist = new modlister($objinits);
$oModlist->filter = $filter;
$oModlist->fbox_checked = $fbox_checked;
$oModlist->templatenum = $templatenum;
$oModlist->modlist = $modlist;
$oModlist->list_mods();

echo "<br><br>";
echo "</div><!-- mmcontainer -->";

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

    $parts = explode(".", $tng_version);
    $tngmodver = "{$admtext['tngmods']} v{$parts[0]}";
    $tngmodurl = "Mods_for_TNG_v{$parts[0]}";
    $helplang = findhelp("modhandler_help.php");

    $innermenu = "<a href='#' onclick=\"return openHelp('$helplang/modhandler_help.php');\" class='lightlink'>{$admtext['help']}</a>\n";
    $innermenu .= "&nbsp;|&nbsp; <a href='#' class='lightlink' id='expandall'> {$text['expandall']}</a>\n";
    $innermenu .= "&nbsp;|&nbsp; <a href='#' class='lightlink' id='collapseall'>{$text['collapseall']}</a>\n";
    $innermenu .= "&nbsp;|&nbsp;&nbsp;<a href=\"https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_Syntax\" target='_blank' class='lightlink'>{$admtext['modsyntax']}</a>\n";
    $innermenu .= "&nbsp;|&nbsp;&nbsp;<a href=\"https://tng.lythgoes.net/wiki/index.php?title=Mod_Guidelines\" target='_blank' class='lightlink'>{$admtext['modguidelines']}</a>\n";
    $innermenu .= "&nbsp;|&nbsp;&nbsp;<a href=\"https://tng.lythgoes.net/wiki/index.php?title=Category:$tngmodurl\" target='_blank' class='lightlink'>$tngmodver</a>\n";

    return $innermenu;
}

$confirm = empty($options['delete_support']) ?
    $admtext['confdelmod1'] :
    $admtext['confdelmod'];

?>
<script>
    jQuery(document).ready(function () {

        jQuery('.flink').click(function () {
            let flinkID = jQuery(this).attr('id');
            let linknum = flinkID.match(/\d+/);
            let linkID = 'link' + linknum;
            toggleStatus(linkID);
        });

        jQuery('.modlink').click(function () {
            let linkID = jQuery(this).attr('id');
            toggleStatus(linkID);
        });

        function toggleStatus(linkID) {
            let divID = linkID + 'div';
            if (jQuery('#' + linkID).hasClass('closed')) {
                jQuery('#' + linkID).addClass('opened').removeClass('closed');
                jQuery('#' + divID).show();
            } else {
                jQuery('#' + linkID).addClass('closed').removeClass('opened');
                jQuery('#' + divID).hide();
            }
        }

        jQuery('#collapseall').click(function () {
            jQuery('.modlink').addClass('closed').removeClass('opened');
            jQuery('.moddiv').hide();
        });

        jQuery('#expandall').click(function () {
            jQuery('.modlink').addClass('opened').removeClass('closed');
            jQuery('.moddiv').show();
        });

        jQuery('#selectAll').click(function () {
            jQuery('input.sbox').prop('checked', true);
        });

        jQuery('#clearAll').click(function () {
            jQuery('input.sbox').prop('checked', false);
        });

        jQuery('#btnDelete').click(function () {
            if (jQuery('input.sbox:checkbox:checked').length > 0) {
                return confirm("<?php echo $confirm; ?>");
            } else {
                alert("<?php echo $admtext['noselected']; ?>");
                return false;
            }
        });
        jQuery('#btnInstall, #btnRemove, #btnClean, #btnChoose').click(function () {
            if (jQuery('input.sbox:checkbox:checked').length > 0) {
                return true;
            } else {
                alert("<?php echo $admtext['noselected']; ?>");
                return false;
            }
        });
        jQuery('#stayon').change(function () {
            if (this.checked) {
                jQuery.post('classes/ajax_filter.php', {filter: '<?php echo $oModlist->filter; ?>'});
            } else {
                jQuery.post('classes/ajax_filter.php', {filter: '0'});
            }
        });
    });

</script>

<?php echo tng_adminfooter(); ?>


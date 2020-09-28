<?php
/*
   Mod Manager 12
      Brian McFadyen: Original concept
      Rick Bisbee: Main script, Mod List, Analyzer, OOP class library
      Ken Roy: View Log, Options, Test Manager
      Robin Richmond: View Log
      Jeff Robison: Affected Files Display

      Uses class objects to acheive various functionality - listing, installing
      removing, and editing mod config files.
*/

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

define('NAMECOL', 1);
define('FILECOL', 0);
define('YES', "1");
define('NO', "0");
define('ON_ERROR', 0);
define('ON_ALL', 1);

define('INSTALL', 1);
define('REMOVE', 2);
define('DELETE', 3);
define('CLEANUP', 4);

define('F_SELECT', 5);

// USER PREFERENCES
include "config/mmconfig.php";

//suppress PHP notices
if (!isset($modspath)) {
    $modspath = '';
}
if (!isset($extspath)) {
    $extspath = '';
}

// VERIFY TNG FILES WRITEABLE
$message = '';
if (!is_writable($rootpath)) {
    $message .= "{$admtext['checkwrite']} {$admtext['cantwrite']} $rootpath ";
}

if (!empty($message)) {
    $message = "<span class=\"msgerror\">$message</span>";
}

// ADJUSTMENTS TO USER PREFERENCES (OPTIONS)
if (isset($_GET['sort'])) {
    $_SESSION['sortby'] = $_GET['sort'];
}
if (isset($_SESSION['sortby'])) {
    $options['sortby'] = $_SESSION['sortby'];
}
if (!isset($options['show_analyzer'])) {
    $options['show_analyzer'] = "0";
}
if (!isset($options['show_developer'])) {
    $options['show_developer'] = "0";
}
if (!isset($options['show_updates'])) {
    $options['show_updates'] = "0";
}
if (!isset($options['compress_log'])) {
    $options['compress_log'] = "0";
}

// SETUP THE PAGE HEADER AND MENUS
$modtabs = set_horizontal_tabs($options['show_analyzer'], $options['show_developer'], $options['show_updates']);
$innermenu = set_innermenu_links($tng_version);
$menu = "<div class=\"mmmenuwrap\">";
$menu .= doMenu($modtabs, "modlist", $innermenu);
$menu .= "</div>";

$headline = displayHeadline($admtext['modmgr'], "img/modmgr_icon.gif", $menu, $message);
$first_menu = TRUE;

$cfgfolder = rtrim($rootpath, "/") . '/' . trim($modspath, "/") . '/';
$mhuser = isset($_SESSION['currentuserdesc']) ? $_SESSION['currentuser'] : "";

// INITIALIZATIONS FOR MOD OBJECTS
require 'classes/modobjinits.php';

/*
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
*
/*************************************************************************
BATCH MOD PROCESSING
*************************************************************************/
$modlist = [];
if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        ${$key} = $value;
    }

    // APPLY FILTER TO MODLIST FOR BATCH OPS
    if (!empty($submit)) {
        if (!empty($mods)) {
            foreach ($mods as $mod) {
                if (isset($mod['selected'])) {
                    $modlist[] = $cfgfolder . $mod['file'];
                }
            }
        }

        // INSTALL ALL
        if ($submit == "installall") {
            include_once 'classes/modinstaller.class.php';
            $oInstaller = new modinstaller($objinits);
            if (!$oInstaller->batch_install($modlist) || $options['redirect2log'] == ON_ALL) {
                header("Location:admin_showmodslog.php");
                exit;
            } else {
                header("Location:admin_modhandler.php");
                exit;
            }
        } // REMOVE ALL
        elseif ($submit == "removeall") {
            include_once 'classes/modremover.class.php';
            $oRemover = new modremover($objinits);
            if (!$oRemover->batch_remove($modlist) || $options['redirect2log'] == ON_ALL) {
                header("Location:admin_showmodslog.php");
                exit;
            } else {
                header("Location:admin_modhandler.php");
                exit;
            }
        } // CLEANUP ALL
        elseif ($submit == "cleanupall") {
            include_once 'classes/modremover.class.php';
            $oRemover = new modremover($objinits);
            if (!$oRemover->batch_remove($modlist) || $options['redirect2log'] == ON_ALL) {
                header("Location:admin_showmodslog.php");
                exit;
            } else {
                header("Location:admin_modhandler.php");
                exit;
            }
        } // DELETE ALL
        elseif ($submit == "deleteall") {
            include_once 'classes/moddeleter.class.php';
            $oDeleter = new moddeleter($objinits);
            if (!$oDeleter->batch_delete($modlist) || $options['redirect2log'] == ON_ALL) {
                header("Location:admin_showmodslog.php");
                exit;
            } else {
                header("Location:admin_modhandler.php");
                exit;
            }
        }
    }
} /*************************************************************************
 * SINGLE MOD PROCESSING
 *************************************************************************/
elseif (!empty($_GET)) {
    foreach ($_GET as $key => $value) {
        ${$key} = $value;
    }
    if (isset($a)) {
        $action = $a;
        $cfgpath = isset($m) ? $cfgfolder . $m : '';

        // INSTALL
        if ($action == INSTALL) {
            include_once 'classes/modinstaller.class.php';
            $obj = new modinstaller($objinits);
            if (!$obj->install($cfgpath) || $options['redirect2log'] == ON_ALL) {
                header("Location:admin_showmodslog.php");
                exit;
            } else {
                header("Location:admin_modhandler.php");
                exit;
            }
        } // REMOVE
        elseif ($action == REMOVE) {
            include_once 'classes/modremover.class.php';
            $obj = new modremover($objinits);
            if (!$obj->remove($cfgpath) || $options['redirect2log'] == ON_ALL) {
                header("Location:admin_showmodslog.php");
                exit;
            } else {
                header("Location:admin_modhandler.php");
                exit;
            }
        } // DELETE
        elseif ($action == DELETE) {
            $error = false;
            include_once 'classes/moddeleter.class.php';
            $obj = new moddeleter($objinits);
            if (!$obj->delete_mod($cfgpath) || $options['redirect2log'] == ON_ALL) {
                header("Location:admin_showmodslog.php");
                exit;
            } else {
                header("Location:admin_modhandler.php");
                exit;
            }
        } // CLEANUP
        elseif ($action == CLEANUP) {
            include_once 'classes/modremover.class.php';
            $obj = new modremover($objinits);
            $obj->classID = "cleaner";
            if (!$obj->remove($cfgpath) || $options['redirect2log'] == ON_ALL) {
                header("Location:admin_showmodslog.php");
                exit;
            } else {
                header("Location:admin_modhandler.php");
                exit;
            }
        }
    }
}

// FILTER IS ONLY RETURNED IF THE 'LOCK' BOX IS CHECKED
$fbox_checked = false;
if (!isset($filter)) {
    // user not asking for filter change
    if (isset($_SESSION['filter'])) {
        $filter = $_SESSION['filter'];
        $fbox_checked = true;
    } else {
        $filter = 0;
        $fbox_checked = false;
    }
} else {
    // filter was set from drop down -- starting over with clean filter checkbox
    if (isset($_SESSION['filter'])) {
        unset($_SESSION['filter']);
    }
}

/*************************************************************************
 * DISPLAY LIST OF MODS
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

// ADJUST LISTING TO BOTTOM OF HEADER MENUS
$headclass = $options['fix_header'] == YES && !isMobile() ? 'mmhead-fixed' : 'mmhead-scroll';
echo "
<script src=\"js/admin.js\"></script>
</head>
<body class=\"admin-body\">
<div id=\"mmhead\" class=\"$headclass adminback\">
   $headline
</div><!--head-section-->";

// IMPLEMENT THE 'SELECT MODS TO DISPLAY' FILTER
if ($filter == F_SELECT && !empty($modlist)) {
    $_SESSION['modlist'] = $modlist;
} elseif ($filter == F_SELECT && isset($_SESSION['modlist'])) {
    $modlist = $_SESSION['modlist'];
} else {
    unset($_SESSION['modlist']);
    $modlist = [];
}
include 'classes/modlister.class.php';
$oModlist = new modlister($objinits);
$oModlist->filter = $filter;
$oModlist->fbox_checked = $fbox_checked;
$oModlist->templatenum = $templatenum;
$oModlist->modlist = $modlist;
$oModlist->list_mods();

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

    // inner menu help
    $innermenu = "<a href=\"#\" onclick=\"return openHelp('$helplang/modhandler_help.php');\" class=\"lightlink\">{$admtext['help']}</a>";

    // expand & collapse all
    $innermenu .= " &nbsp;|&nbsp; <a href=\"#\" class=\"lightlink\" id=\"expandall\"> {$text['expandall']}</a>";
    $innermenu .= " &nbsp;|&nbsp; <a href=\"#\" class=\"lightlink\" id=\"collapseall\">{$text['collapseall']}</a>";

    // MM syntax
    $innermenu .= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_Syntax\" target=\"_blank\" class=\"lightlink\">{$admtext['modsyntax']}</a>";

    // mod guidelines
    $innermenu .= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"https://tng.lythgoes.net/wiki/index.php?title=Mod_Guidelines\" target=\"_blank\" class=\"lightlink\">{$admtext['modguidelines']}</a>";

    // mods for TNGv10
    $innermenu .= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"https://tng.lythgoes.net/wiki/index.php?title=Category:$tngmodurl\" target=\"_blank\" class=\"lightlink\">$tngmodver</a>";
    return $innermenu;
}

/*************************************************************************
 * JQUERY/JAVASCRIPT FUNCTIONS
 *************************************************************************/
$confirm = empty($options['delete_support']) ?
    $admtext['confdelmod1'] :
    $admtext['confdelmod'];
echo "
<script>
jQuery(document).ready(function() {
";

if (!isMobile() && $options['adjust_headers']) {
    echo "
   window.scroll(0,0);

   // set position of status bar relative to #mmhead (jQuery UI)
   jQuery('#fbar').position({
      my: 'left top',
      at: 'left bottom',
      of: jQuery('#mmhead'),
      collision: 'none'
   });

   // set position of listing table relative to filter bar (jQuery UI)
   jQuery('#mmgrid').position({
      my: 'left top',
      at: 'left bottom',
      of: jQuery('#fbar'),
      collision: 'none'
   });
";
}
echo "
   // toggle mod status from other fields
	jQuery('.flink').click(function() {
      var flinkID = jQuery(this).attr('id');
      var linknum = flinkID.match(/\d+/);
      var linkID = 'link'+linknum;
      toggleStatus(linkID);
	});

   // toggle mod status from status field header
	jQuery('.modlink').click(function() {
		var linkID = jQuery(this).attr('id');
      toggleStatus(linkID);
	});

   function toggleStatus( linkID ) {
      var divID = linkID + 'div';
		if( jQuery('#' + linkID).hasClass('closed') ) {
         jQuery('#' + linkID).addClass('opened').removeClass('closed');
		   jQuery('#' + divID).show();
      }
		else {
         jQuery('#' + linkID).addClass('closed').removeClass('opened');
			jQuery('#' + divID).hide();
      }
   }

   // close all
   jQuery('#collapseall').click(function() {
      jQuery('.modlink').addClass('closed').removeClass('opened');
      jQuery('.moddiv').hide();
   });

   // open all
   jQuery('#expandall').click(function() {
      jQuery('.modlink').addClass('opened').removeClass('closed');
      jQuery('.moddiv').show();
   });

   jQuery('#selectAll').click(function(){
      jQuery('input.sbox').prop('checked',true);
   });

   jQuery('#clearAll').click(function(){
      jQuery('input.sbox').prop('checked',false);
   });

   jQuery('#btnDelete').click(function(){
      if(jQuery('input.sbox:checkbox:checked').length>0 ) {
         return confirm(\"{$confirm}\");
      }
      else {
         alert(\"{$admtext['noselected']}\" );
         return false;
      }
   });
   jQuery('#btnInstall, #btnRemove, #btnClean, #btnChoose').click(function(){
      if( jQuery('input.sbox:checkbox:checked').length>0 ) {
         return true;
      }
      else {
         alert(\"{$admtext['noselected']}\" );
         return false;
      }
   });
   jQuery('#stayon').change(function() {
      if(this.checked) {
         jQuery.post('classes/ajax_filter.php', {filter:\"$oModlist->filter\"});
         }
      else {
         jQuery.post('classes/ajax_filter.php', {filter:\"0\"});
      }
   });
});

</script>";

echo "<div class='text-center'><span class='normal'>$tng_title</span></div>";
echo "</body>";
echo "</html>";


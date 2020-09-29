<?php
/*
   Mod Manager 12 Display Parser Tables

   Standalone class to show parse table for selected mods
*/

include 'begin.php';
include 'adminlib.php';
$textpart = 'mods';
include 'getlang.php';

include "$mylanguage/admintext.php";

$admin_login = 1;
include 'checklogin.php';
include 'version.php';
include 'classes/version.php';

$thisfile = $_SERVER['PHP_SELF'];

define('YES', "1");

// USER PREFERENCES
include "config/mmconfig.php";

if (!isset($options['show_analyzer'])) {
    $options['show_analyzer'] = "0";
}
if (!isset($options['show_developer'])) {
    $options['show_developer'] = "0";
}
if (!isset($options['show_updates'])) {
    $options['show_updates'] = "0";
}

// SETUP THE PAGE HEADER AND MENUS
$modtabs = set_horizontal_tabs($options['show_analyzer'], $options['show_developer'], $options['show_updates']);
$innermenu = set_innermenu_links($tng_version);
$menu = "<div class=\"mmmenuwrap\">";
$menu .= doMenu($modtabs, "parser", $innermenu);
$menu .= "</div>";
if (!isset($message)) {
    $message = "";
}
$headline = displayHeadline($admtext['modmgr'], "img/modmgr_icon.gif", $menu, $message);
$first_menu = TRUE;

$cfgfolder = rtrim($rootpath, "/") . '/' . trim($modspath, "/") . '/';
$mhuser = isset($_SESSION['currentuserdesc']) ? $_SESSION['currentuser'] : "";

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
if (!isset($options['compress_log'])) {
    $options['compress_log'] = "0";
}

require 'classes/modobjinits.php';

/*
// INITIALIZATIONS FOR MOD OBJECTS
$fpaths = array (
   'rootpath'  => $rootpath,
   'modspath'  => $modspath,
   'extspath'  => $extspath
);

$objinits = array (
   'fpaths'       => $fpaths,
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
 * DISPLAY THE TNG PAGE HEADER
 *************************************************************************/
$flags['tabs'] = $tngconfig['tabs'];
$flags['modmgr'] = true;
tng_adminheader($admtext['modmgr'], $flags);

// ADJUST WIDTH FOR MOBILE DEVICES
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
</head>
<body class=\"admin-body\">
<div id=\"mmhead\" class=\"$headclass adminback\">
   $headline
</div><!--head-section-->";

/*************************************************************************
 * CREATE A MOD   OBJECT
 *************************************************************************/
include_once 'classes/modparser.class.php';
$oParse = new modparser($objinits);

if ($options['fix_header']) {
    $style = "position:absolute;min-width:98%;top:119;left:05;padding:5px;";
} else {
    $style = "min-width:98%;";
}

if ($options['fix_header']) {
    $pclass = "parse-table";
} else {
    $pclass = '';
}
/*************************************************************************
 * DISPLAY THE MOD FILE SELECTION LIST
 *************************************************************************/
if (empty($modfile)) {
    $modlist = $oParse->get_modfile_names();
    $modnum = 1;
    echo "
<div id=\"parse-sec\" class='lightback parse-table' style=$style>
   <h2>{$admtext['selectmod']}</h2>";
    foreach ($modlist as $modfile) {
        echo "
      <p>" . $modnum++ . ". <a href=\"" . $thisfile . "?modfile=$modfile\">$modfile</a></p>";
    }
    echo "
</div>";
    fix_header($options);
    echo "
</body>
</html>";
    exit;
}

/*************************************************************************
 * DISPLAY THE PARSE TABLE
 *************************************************************************/
$tags = $oParse->parse($modspath . '/' . $modfile);
echo "
<div id=\"parse-sec\" class='lightback parse-table' style=$style>";
$oParse->show_parse_table($tags);

echo "
   <script>
      document.write('<a href=\"' + document.referrer + '\"><button>" . $admtext['backtoprevious'] . "</button></a>');
   </script>
</div>";
fix_header($options);
echo "
</body>
</html>";
exit;

function fix_header($options) {
    if (!isMobile() && $options['adjust_headers']) {
        echo "
   <script>
      jQuery(document).ready(function() {
         // set position of parse-sec div relative to mmhead
         jQuery('#parse-sec').position({
            my: 'left top',
            at: 'left bottom',
            of: jQuery('#mmhead'),
            collision: 'none'
         });
      });
   </script>";
    }


}

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
    global $admtext;

    $parts = explode(".", $tng_version);    // added to determine TNG vNN for
    $tngmodver = "{$admtext['tngmods']} v{$parts[0]}";  // Mods for TNG vNN text display
    $tngmodurl = "Mods_for_TNG_v{$parts[0]}";  // Mods for TNG vNN URL
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

/*************************************************************************
 * JQUERY/JAVASCRIPT FUNCTIONS
 *************************************************************************/
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
         return confirm(\"{$admtext['nomodundo']}\");
      }
      else {
         alert(\"{$admtext['noselected']}\" );
         return false;
      }
   });
   jQuery('#btnInstall, #btnRemove, #btnClean').click(function(){
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

echo "
<div style=\"text-align: center;\"><span class='normal'>$tng_title ($mm_version)</span></div>
</body>
</html>";

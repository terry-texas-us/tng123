<?php
//  admin_showmodmgrlog.php created from the adminshowlog.php
//     by Ken Roy to split the Mod Manager action log from the Admin Change log
//  %version:10.0.3.0%
// Updated May 3, 2014 by Ken Roy
//		- to incorporate Rick's Batch processing module
// Updated May 17, 2014 by Jeff Robison
//		- to add a Clear Log option to the innermenu
// Updated May 20, 2014 by Ken Roy
//		- to add Mod Guidelines, Mod Syntax, and Mods for TNG vnn to the innermenu
// Updated 21 May 2014 by Jeff Robison
//		- to fix the header section
// Updated 22 May 2014 by Ken Roy
//		- to externalize the fixed header style definitions
// Updated 13 Oct 2014 by Robin Richmond
//		- to collapse the details of each mod and open them when the user clicks on an arrow image
// Updated 14 Oct 2014 19:21 by Robin Richmond
//		- to incorporate mod handler help file, mod analyzer, and collapse all and expand all button in the menu & inner menu
// Updated 17 Oct 2014 11:32 by Robin Richmond
//		- to simplify parsing of the first line of the log entry.
// Updated 20 Oct 2014 by Ken Roy
//		- to add options for Analyzer tab and Compress Log
// Updated 21 Oct 2014 21:58 by Robin Richmond
//		- to pay attention to the new compress_log option
// Updated 22 Oct 2014 by Ken Roy
//		- to display Expand All / Collapse All if $sitever == standard or $options['compress_log'] == YES
// Updated 22 Oct 2014 18:18 by Robin Richmond
//		- to use the latest code for identifying legitimate log entries.


// Note: this code deals with three types of log entries:
//  1. The newest, GENIII log entries that consist of on physical line that contains multiple HTML lines.
//     The first line is pipe-delimited and contains the log entry heading.
//  2. Older (probably generated by test versions of GenIII, but I'm sure) log entries that also
//     consist of one physical line that contains multiple HTML lines.  The first line is not pipe-
//     delimited, but it does contains a log entry heading.
//  3. Even older log entries that consist of multiple physical lines, in reverse chronological
//     order.  Thus, the first line we encounter is the last line of the log entry.  But we use that
//    last line as the entry header.

include "begin.php";
include "adminlib.php";
$textpart = "mods";
include "getlang.php";

include "$mylanguage/admintext.php";

//tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
$admin_login = 1;
include "checklogin.php";
include "version.php";

// temporary: these can be set from an options file
// include 'classes/mod.class.config.php';
include $subroot . 'mmconfig.php';

define('YES', "1");
define('NO', "0");

if (!isset($sub)) {
  $sub = "tables";
}
$flags['tabs'] = $tngconfig['tabs'];
$flags['modmgr'] = true;
tng_adminheader($admtext['showlogfile'], $flags);

$min_width = $sitever == 'mobile' ? '0' : '640px';
echo "
<style type='text/css'>
body {
   margin:0;
   overflow-y: scroll;
   min-width:$min_width;
}
</style>";

$helplang = findhelp("modmanager_help.php");

if (!isset($options['show_analyzer'])) {
  $options['show_analyzer'] = "0";
}
if (!isset($options['show_developer'])) {
  $options['show_developer'] = "0";
}
if (!isset($options['show_updates'])) {
  $options['show_updates'] = "0";
}

$parts = explode(".", $tng_version);
$tngmodver = "Mods for TNG v{$parts[0]}";
$modtabs = set_horizontal_tabs($options['show_analyzer'], $options['show_developer'], $options['show_updates']);
$innermenu = set_innermenu_links($tng_version);

$menu = "<div class=\"mmmenuwrap\">";
$menu .= doMenu($modtabs, "viewlog", $innermenu);
$menu .= "</div>";
if (!isset($message)) {
  $message = "";
}
$headline = displayHeadline($admtext['modmgr'], "img/modmgr_icon.gif", $menu, $message);
//$logheader = $options['maxloglines'] . " " . $admtext['recentactions'];
$logheader = $admtext['recentactions'];
$first_menu = TRUE;

$clearmmlog = empty($_GET['clearmmlog']) ? false : true;

if ($options['fix_header'] == YES && $sitever != 'mobile') {
  $headclass = 'mmhead-fixed';
  $ibarclass = 'ibar-fixed';
  $mmlogclass = 'mmlog-fixed';
} else {
  $headclass = 'mmhead-scroll';
  $ibarclass = 'ibar-scroll';
  $mmlogclass = 'mmlog-scroll';
}

echo "
<script type=\"text/javascript\" src=\"js/admin.js\"></script>
</head>
<body background=\"img/background.gif\" style=\"margin:0;\">
<div id=\"mmhead\" class=\"$headclass adminback\">
   $headline
</div><!--head-section-->";

//if ( $sitever == "standard" && $options['compress_log'] == YES) {
if ($options['compress_log'] == YES) {
  echo "
<style>
	.action {padding-left:15px; cursor: pointer; background: url(img/tng_expand.gif) no-repeat left center;}
	.collapse {background: url(img/tng_collapse.gif) no-repeat left center;
	.collapse a { text-decoration: none;}
	.moddetails {display:none;}
</style>";
  $hideDetails = "style=\"display:none;\"";
} else {
  $hideDetails = "";
}

//if (isset( $logfilename) ) $options['modlogfile']=$logfilename; //TEMPORARY CODE - get logfilename from querystring parameter
$logfilename = 'modmgrlog.txt';
if (!isset($options['modlogfile'])) {
  $options['modlogfile'] = $logfilename;
} //TEMPORARY CODE - get logfilename from querystring parameter

if ($clearmmlog || !file_exists($options['modlogfile'])) {
  $content = "#### Mod Manager Log created " . date("D d M Y h:i:s A", time() + (3600 * $time_offset)) . " ####";
  file_put_contents($options['modlogfile'], $content);
}
$nColumns = 1;
//echo "<table cellpadding=\"3\" cellspacing=\"1\" class=\"normal lightback w100\">\n";
//Add the heading with the Mod Manager Recent Actions message
//echo "<tr><td colspan=\"$nColumns\" class=\"fieldnameback fieldname\">$logheader</td></tr>";
//echo "</table>";

echo "
<table id=\"infobar\" class=\"normal lightback $ibarclass\">
   <tr>
      <td colspan=\"1\" class=\"fieldnameback fieldname mmpadleft\">$logheader</td>
   </tr>
</table>";

echo "
<table id=\"mmlog\" class=\"normal lightback $mmlogclass\">";
$lines = file($options['modlogfile']);
if ($lines) {
  $actionCount = 0; // Counts the actions, i.e. the "log entries"
  $logEntryDetails = "";
  // These two boolean variables are used (a) to flag that the first line of a log entry
  // has been output, and (b) to distinguish between newer and older log entries, because
  // the detail lines of old log entries are in reverse chronological order.
  $type1Or2EntryIsActive = false;
  $type3EntryIsActive = false;
  foreach ($lines as $line) {
    //Because there are multiple tests involved, we use this boolean variable as we
    //determine if the log entry is in the newer one-physical-line format.
    $newLogFormat = false;
    //Log entries have to start with a date.  This test is necessary because some old log entries
    //contain
    if (preg_match("/^\w{3} \d{2} \w{3} \d{4} \d{2}:\d{2}:\d{2} \w{2}/i", $line, $matches)) {
      //New log entries have a <br /> more than 20 characters from the end,
      //and less than 150 characters from the beginning
      $br = strpos($line, "<br />");
      if ($br !== false) {
        if (strlen($line) - $br > 20 || $br < 150) {
          $newLogFormat = true;
        }
      }
    }

    if ($newLogFormat) {
      //This is a one-physical-line log entry.
      if ($logEntryDetails) {
        echo "<tr class=\"databack mmpadleft moddetails\" $hideDetails id=\"data$actionCount\"><td colspan=\"$nColumns\">$logEntryDetails</td></tr>\n";
        $type3EntryIsActive = false;
      }
      $actionCount++;
      //Suppress any <hr> elements in the first line of the log entry.
      $heading = str_replace("<hr />", "", substr($line, 0, $br));
      //The rest of the log entry goes into the details.
      $logEntryDetails = substr($line, $br + 6);
      $type1Or2EntryIsActive = true;

      // break out the status from $heading, set $dynoclass and add below
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
      echo "<td class=\"action\" id=\"action$actionCount\">$actionCount. $heading</td></tr>\n";
    } else {
      // This isn't a one-physical-line log entry.  But we also need to look for old log
      // entries that consist of multiple physical lines.
      //This pattern should match old "type 3" log entries.
      //(I know that it isn't perfect, but it's the best I could come up with.)
      $match = preg_match("/^(\w{3} \d{2} \w{3} \d{4} \d{2}:\d{2}:\d{2} \w{2}) ([.\w_-]*)\.cfg(.*)\(([\w: ]*)\)/i", $line, $matches);
      if ($match) {
        //It looks like this is the beginning of an old multiple-physical-line log entry.
        if ($logEntryDetails) {
          echo "<tr class=\"databack mmpadleft moddetails\" $hideDetails id=\"data$actionCount\"><td colspan=\"$nColumns\">$logEntryDetails</td></tr>\n";
          $type1Or2EntryIsActive = false;
          $logEntryDetails = "";
        }
        $actionCount++;
        $modFilename = $matches[2]; //I'm not using this variable now, but hope to later.
        echo "<tr class=\"databack mmpadleft\">";
        echo "<td class=\"action\" id=\"action$actionCount\">$actionCount. $line</td></tr>";
        $type3EntryIsActive = true;
      } else {
        //Couldn't parse the alternate pattern - treat this as an unrecognizable entry
        if ($type3EntryIsActive) {
          //Add the unrecognized entry at the beginning of existing details
          $logEntryDetails = "$line</span><br />\n$logEntryDetails"; //add </span> to close a chronically unclosed span in the log.
        } else {
          if ($type1Or2EntryIsActive) {
            //Add the unrecognized entry at the end of the existing details
            $logEntryDetails .= "<br />$line";
          } else {
            //There's no outstanding log entry to add this to. Just display it without any compression controls
            echo "<tr><td class=\"databack mmpadleft\" colspan=\"$nColumns\"><b>?? </b>$line</td></tr>\n";
          }
        }
      }
    }
  }
}
// Are any details left over from the very last log entry?
if ($logEntryDetails) {
  echo "<tr class=\"databack mmpadleft moddetails\" $hideDetails id=\"data$actionCount\"><td colspan=\"$nColumns\">$logEntryDetails</td></tr>\n";
}

echo "
	</table>";
/*************************************************************************
 * FUNCTIONS
 *************************************************************************/
function set_horizontal_tabs($show_analyzer = NO, $show_developer = NO, $show_updates = NO) {
  global $admtext;

  $modtabs = array();
  $modtabs[0] = array(1, "admin_modhandler.php", $admtext['modlist'], "modlist");
  $modtabs[1] = array(1, "admin_showmodslog.php", $admtext['viewlog'], "viewlog");
  $modtabs[2] = array(1, "admin_modoptions.php", $admtext['options'], "options");
  if ($show_analyzer == YES) {
    $modtabs[3] = array(1, "admin_analyzemods.php", $admtext['analyzefiles'], 'files');
  }
  if ($show_developer == YES) {
    $modtabs[4] = array(1, "admin_modtables.php", $admtext['parsetable'], 'parser');
  }
  if ($show_updates == YES) {
    $modtabs[5] = array(1, "admin_modupdates.php", $admtext['recommendedfixes'], 'updates');
  }
  return $modtabs;
}

function set_innermenu_links($tng_version) {
  global $text, $admtext;
  $parts = explode(".", $tng_version);        // added to determine TNG vNN for
  $tngmodver = "{$admtext['tngmods']} v{$parts[0]}";    // Mods for TNG vNN text display
  $tngmodurl = "Mods_for_TNG_v{$parts[0]}";    // Mods for TNG vNN URL
  $helplang = findhelp("modhandler_help.php");

  // inner menu help
  $innermenu = "<a href=\"#\" onclick=\"return openHelp('$helplang/modhandler_help.php');\" class=\"lightlink\">{$admtext['help']}</a>";

  // expand & collapse all
  $innermenu .= " &nbsp;|&nbsp; <a href=\"#\" class=\"lightlink\" id=\"expandall\"> {$text['expandall']}</a>";
  $innermenu .= " &nbsp;|&nbsp; <a href=\"#\" class=\"lightlink\" id=\"collapseall\">{$text['collapseall']}</a>";

  //This section for View Log only to allow clearing the log
  //if ($options['compress_log'] == YES) {
  $innermenu .= " &nbsp;|&nbsp; <a href=\"admin_showmodslog.php?clearmmlog=true\" onclick=\"return confirm( '{$admtext['confirmclearlog']}')\"; class=\"lightlink\">{$admtext['clearlog']}</a>";
  //}

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
//$sitever = 'mobile'; //bypass jQuery positioning for testing
if ($sitever != 'mobile' && $options['adjust_headers']) {
  echo "
<script type=\"text/javascript\">
   jQuery(document).ready(function() {
	   // set position of table relative to inner menu
	   jQuery('#infobar').position({
	      my: 'left top',
	      at: 'left bottom',
	      of: jQuery('#mmhead'),
	      collision: 'fit'
	   });
	   // set position of listing table relative to info bar
	   jQuery('#mmlog').position({
	      my: 'left top',
	      at: 'left bottom',
	      of: jQuery('#infobar'),
	      collision: 'none'
	   });
	});
</script>";
}
echo "
<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>
</body>
</html>";
?>
<script>
    //qQeury document ready handler and embedded event handlers added by RR
    jQuery(document).ready(function () {
        //Handler for the triangular arrow icon on the first line of each log entry.
        jQuery('.action').click(function () {
            var myId = jQuery(this).attr("id");  //Get the log entry number
            var dataId = myId.replace("action", "data");  //Generate the ID of the mod details
            if (jQuery(this).hasClass("collapse")) {
                //The details are collapsed...no...hmmm... it works right, but I must be using the wrong label for the "collapse" class..
                jQuery('#' + dataId).hide();
                jQuery(this).removeClass("collapse");
            } else {
                jQuery(this).addClass("collapse");
                jQuery('#' + dataId).show();
            }
        });

        //Handler for the "open all" text link
        jQuery('#expandall').click(function (event) {
            //jQuery(this).attr("src","img/tng_collapseall.png");
            jQuery(".action").addClass("collapse");
            jQuery(".moddetails").show();
            event.preventDefault();
        });

        //Handler for the "close all" text link
        jQuery('#collapseall').click(function (event) {
            //jQuery(this).attr("src","img/tng_expandall.png");
            jQuery(".action").removeClass("collapse");
            jQuery(".moddetails").hide();
            event.preventDefault();
        });
    });
</script>

<?php

include "begin.php";
include "adminlib.php";
$textpart = "mods";
include("$mylanguage/admintext.php");
$helplang = findhelp("modhandler_help.php");

$admin_login = 1;
include "checklogin.php";
include "version.php";

define("YES", "1");
define("NO", "0");

define("MODNAME", 0);
define("CFGNAME", 1);
define("ON_ERROR", 0);
define("ON_ALL", 1);

define("ONE", 1);
define("TWO", 2);
define("THREE", 3);
define("FOUR", 4);
define("FIVE", 5);

$optionsfile = "config/mmconfig.php";
include $optionsfile;

if (!isset($options['modlogfile'])) $options['modlogfile'] = "modmgrlog.txt";
if (!isset($options['maxloglines'])) $options['maxloglines'] = "200";
if (!isset($options['compress_log'])) $options['compress_log'] = YES;
if (!isset($options['redirect2log'])) $options['redirect2log'] = ON_ERROR;
if (!isset($options['sortby'])) $options['sortby'] = MODNAME;
if (!isset($options['delete_partial'])) $options['delete_partial'] = NO;
if (!isset($options['delete_installed'])) $options['delete_installed'] = NO;
if (!isset($options['log_full_path'])) $options['log_full_path'] = YES;
if (!isset($options['compress_names'])) $options['compress_names'] = NO;
if (!isset($options['fix_header'])) $options['fix_header'] = YES;
if (!isset($options['show_analyzer'])) $options['show_analyzer'] = NO;
if (!isset($options['show_developer'])) $options['show_developer'] = NO;
if (!isset($options['show_updates'])) $options['show_updates'] = YES;
if (!isset($options['use_striping'])) $options['use_striping'] = YES;
if (!isset($options['stripe_after'])) $options['stripe_after'] = THREE;
if (!isset($options['adjust_headers'])) $options['adjust_headers'] = NO;
if (!isset($options['delete_support'])) $options['delete_support'] = NO;
if (!isset($sub)) $sub = "tables";

$flags['tabs'] = $tngconfig['tabs'];
$flags['modmgr'] = true;
tng_adminheader($admtext['modmgr'], $flags);

$min_width = isMobile() ? '0' : '640px';
echo "<style>body {margin: 0; overflow-y: scroll; min-width: $min_width;}</style>";

echo "</head>\n";

echo tng_adminlayout();

$modtabs = set_horizontal_tabs($options['show_analyzer'], $options['show_developer'], $options['show_updates']);
$innermenu = set_innermenu_links($tng_version);

$menu = "<div class='mmmenuwrap'>";
$menu .= doMenu($modtabs, "options", $innermenu);
$menu .= "</div>";

if (!isset($message)) $message = "";
$headline = displayHeadline($admtext['modmgr'], "img/modmgr_icon.gif", $menu, $message);
$first_menu = TRUE;

if ($options['fix_header'] == YES && !isMobile()) {
    $headclass = 'mmhead-fixed';
    $tableclass = 'm2table-fixed';
} else {
    $headclass = 'mmhead-scroll';
    $tableclass = 'm2table-scroll';
}

echo "
<div id=\"mmhead\" class=\"$headclass adminback\">
   $headline
</div><!--head-section-->";

echo "<form action='admin_updatemodoptions.php' method='post' name='form1'>";

echo "<table id='m2table' class='lightback w-100 %name' style='padding: 0;' border='0' cellpadding='10'$tableclass cellspacing='2'>\n";
echo "<tr class='databack'>\n";
echo "<td class='tngshadow'>\n";

echo displayToggle("plus0", 0, "log", $admtext['logoptions'], "");
echo "
	<div id='log' style='display: none'>
		<table class='normal'>
		    <tr>
                <td width='270px'>
                    <span class=\"normal\">{$admtext['mmlogfilename']}:</span>
                </td>
                <td>
                    <input type=\"text\" value=\"{$options['modlogfile']}\" name=\"options[modlogfile]\" size=\"20\">
                </td>
            </tr>
		    <tr>
                <td>
                    <span class=\"normal\">{$admtext['mmmaxloglines']}:</span>
                </td>
                <td>
                    <input type=\"text\" value=\"{$options['maxloglines']}\" name=\"options[maxloglines]\" size=\"5\">
                </td>
            </tr>
         	<tr>
         		<td width='270px'>{$admtext['compresslog']}:</td>
         		<td>
         			<select name=\"options[compress_log]\">
         				<option value=" . YES;
if ($options['compress_log'] == YES) echo " selected";
echo ">{$admtext['yes']}</option>
         				<option value=" . NO;
if ($options['compress_log'] == NO) echo " selected";
echo ">{$admtext['no']}</option>
         			</select>
         		</td>
         	</tr>
         	<tr>
         		<td width='270px'>{$admtext['redirect2log']}:</td>
         		<td>
         			<select name=\"options[redirect2log]\">
                       <option value=" . ON_ERROR;
if ($options['redirect2log'] == ON_ERROR) echo "  selected";
echo ">{$admtext['on_error']}</option>
                       <option value=" . ON_ALL;
if ($options['redirect2log'] == ON_ALL) echo " selected";
echo ">{$admtext['on_all']}</option>
         			</select>
         		</td>
         	</tr>
			<tr>
			    <td width='270px'>{$admtext['logfullpath']}:</td>
				<td>
					<select name=\"options[log_full_path]\">
					<option value=" . YES;
if ($options['log_full_path'] == YES) echo " selected";
echo ">{$admtext['yes']}</option>
					<option value=" . NO;
if ($options['log_full_path'] == NO) echo " selected";
echo ">{$admtext['no']}</option>
					</select>
				</td>
			</tr>
        </table>
    </div>
</td>
</tr>
<tr class='databack tngshadow'>
<td class=\"tngshadow\">";

echo displayToggle("plus1", 0, "display", $admtext['displayoptions'], "");
echo "
	<div id='display' style='display: none;'>
	            <table class='normal'>
		         <tr>
         			<td width='270px'>{$admtext['sortlistby']}:</td>
         			<td>
         				<select name=\"options[sortby]\">
         					<option value=" . MODNAME;
if ($options['sortby'] == MODNAME) echo " selected";
echo ">{$admtext['modname']}</option>
         					<option value=" . CFGNAME;
if ($options['sortby'] == CFGNAME) echo " selected";
echo ">{$admtext['cfgname']}</option>
         				</select>
         			</td>
         		</tr>
         		<tr>
         			<td width='270px'>{$admtext['fixedheader']}:</td>
         			<td>
         				<select name=\"options[fix_header]\">
         					<option value=" . YES;
if ($options['fix_header'] == YES) echo " selected";
echo ">{$admtext['yes']}</option>
         					<option value=" . NO;
if ($options['fix_header'] == NO) echo " selected";
echo ">{$admtext['no']}</option>
         				</select>
         			</td>
         		</tr>
         		<tr>
         			<td width='270px'>{$admtext['adjusthdrs']}:</td>
         			<td>
         				<select name=\"options[adjust_headers]\">
         					<option value=" . YES;
if ($options['adjust_headers'] == YES) echo " selected";
echo ">{$admtext['yes']}</option>
         					<option value=" . NO;
if ($options['adjust_headers'] == NO) echo " selected";
echo ">{$admtext['no']}</option>
         				</select>
         			</td>
         		</tr>
         		<tr>
         			<td width='270px'>{$admtext['usestriping']}:</td>
         			<td>
         				<select name=\"options[use_striping]\">
         					<option value=" . YES;
if ($options['use_striping'] == YES) echo " selected";
echo ">{$admtext['yes']}</option>
         					<option value=" . NO;
if ($options['use_striping'] == NO) echo " selected";
echo ">{$admtext['no']}</option>
         				</select>
         			</td>
         		</tr>
         		<tr>
         			<td width='270px'>{$admtext['stripeafter']}:</td>
					<td>
						<select name=\"options[stripe_after]\">
							<option value=" . ONE;
if ($options['stripe_after'] == ONE) echo " selected";
echo ">1</option>
							<option value=" . TWO;
if ($options['stripe_after'] == TWO) echo " selected";
echo ">2</option>
							<option value=" . THREE;
if ($options['stripe_after'] == THREE) echo " selected";
echo ">3</option>
							<option value=" . FOUR;
if ($options['stripe_after'] == FOUR) echo " selected";
echo ">4</option>
							<option value=" . FIVE;
if ($options['stripe_after'] == FIVE) echo " selected";
echo ">5</option>
						</select>
					</td>
         		</tr>
         		<tr>
         			<td width='270px'>{$admtext['compressnames']}:</td>
         			<td>
         				<select name=\"options[compress_names]\">
         					<option value=" . YES;
if ($options['compress_names'] == YES) echo " selected";
echo ">{$admtext['yes']}</option>
         					<option value=" . NO;
if ($options['compress_names'] == NO) echo " selected";
echo ">{$admtext['no']}</option>
         				</select>
         			</td>
         		</tr>
         		<tr>
         			<td width='270px'>{$admtext['showanalyzer']}:</td>
         			<td>
         				<select name=\"options[show_analyzer]\">
         					<option value=" . YES;
if ($options['show_analyzer'] == YES) echo " selected";
echo ">{$admtext['yes']}</option>
         					<option value=" . NO;
if ($options['show_analyzer'] == NO) echo " selected";
echo ">{$admtext['no']}</option>
         				</select>
         			</td>
         		</tr>
         		<tr>
         			<td width='270px'>{$admtext['showdeveloper']}:</td>
         			<td>
         				<select name=\"options[show_developer]\">
         					<option value=" . YES;
if ($options['show_developer'] == YES) echo " selected";
echo ">{$admtext['yes']}</option>
         					<option value=" . NO;
if ($options['show_developer'] == NO) echo " selected";
echo ">{$admtext['no']}</option>
         				</select>
         			</td>
         		</tr>
         		<tr>
         			<td width='270px'>{$admtext['showupdates']}:</td>
         			<td>
         				<select name=\"options[show_updates]\">
         					<option value=" . YES;
if ($options['show_updates'] == YES) echo " selected";
echo ">{$admtext['yes']}</option>
         					<option value=" . NO;
if ($options['show_updates'] == NO) echo " selected";
echo ">{$admtext['no']}</option>
         				</select>
         			</td>
         		</tr>
         	   </table>
            </div>
         </td>
      </tr>
     <tr class='databack tngshadow'>
         <td class=\"tngshadow\">";
echo displayToggle("plus2", 0, "other", $admtext['othermmoptions'], "");
echo "
	<div id=\"other\" style='display: none;'>
	    <table class='normal'>
         		<tr>
         			<td width='270px'>{$admtext['allowdeletepartial']}:</td>
         			<td>
         				<select name=\"options[delete_partial]\">
         					<option value=" . YES;
if ($options['delete_partial'] == YES) echo " selected";
echo ">{$admtext['yes']}</option>
         					<option value=" . NO;
if ($options['delete_partial'] == NO) echo " selected";
echo ">{$admtext['no']}</option>
         				</select>
         			</td>
                  <td>
                     <div style=\"padding-left:1em;width:80%;\">{$admtext['delpartinfo']}</div>
                  </td>
         		</tr>
         		<tr>
         			<td width='270px'>{$admtext['allowdeleteinstalled']}:</td>
         			<td>
         				<select name=\"options[delete_installed]\">
         					<option value=" . YES;
if ($options['delete_installed'] == YES) echo " selected";
echo ">{$admtext['yes']}</option>
         					<option value=" . NO;
if ($options['delete_installed'] == NO) echo " selected";
echo ">{$admtext['no']}</option>
         				</select>
         			</td>
                  <td>
                     <div style=\"padding-left:1em;width:80%;\">{$admtext['delinstinfo']}</div>
                  </td>
         		</tr>
               <tr>
         			<td width='270px'>{$admtext['allowdeletesupport']}:</td>
         			<td>
         				<select name=\"options[delete_support]\">
         					<option value=" . YES;
if ($options['delete_support'] == YES) echo " selected";
echo ">{$admtext['yes']}</option>
         					<option value=" . NO;
if ($options['delete_support'] == NO) echo " selected";
echo ">{$admtext['no']}</option>
         				</select>
         			</td>
                  <td>
                     <div style=\"padding-left:1em;width:80%;\">{$admtext['delrisk']}</div>
                  </td>
               </tr>
			</table>
			</div>
		</td></tr>
		<tr class='databack tngshadow'>
			<td class=\"tngshadow\">
            <input type='submit' name=\"submit\" accesskey=\"s\" value=\"{$admtext['save']}\">
			</td>
		</tr>
		</table>
	</form>";

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
    $innermenu .= "&nbsp;|&nbsp; <a href='#' class='lightlink' onClick=\"return toggleAll('on');\">{$text['expandall']}</a>\n";
    $innermenu .= "&nbsp;|&nbsp; <a href='#' class='lightlink' onClick=\"return toggleAll('off');\">{$text['collapseall']}</a>\n";
    $innermenu .= "&nbsp;|&nbsp;&nbsp;<a href=\"https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_Syntax\" target='_blank' class='lightlink'>{$admtext['modsyntax']}</a>\n";
    $innermenu .= "&nbsp;|&nbsp;&nbsp;<a href=\"https://tng.lythgoes.net/wiki/index.php?title=Mod_Guidelines\" target='_blank' class='lightlink'>{$admtext['modguidelines']}</a>\n";
    $innermenu .= "&nbsp;|&nbsp;&nbsp;<a href=\"https://tng.lythgoes.net/wiki/index.php?title=Category:$tngmodurl\" target='_blank' class='lightlink'>$tngmodver</a>\n";

    return $innermenu;
}

?>

<script>
    function toggleAll(display) {
        toggleSection('log', 'plus0', display);
        toggleSection('display', 'plus1', display);
        toggleSection('other', 'plus2', display);
        return false;
    }
</script>

<?php echo tng_adminfooter(); ?>

<?php

include 'begin.php';
include 'adminlib.php';
$textpart = 'mods';

include "$mylanguage/admintext.php";

$admin_login = 1;
include 'checklogin.php';
include 'version.php';
include 'classes/version.php';

$thisfile = $_SERVER['PHP_SELF'];

define('YES', "1");
define('NO', "0");


include $subroot . 'mmconfig.php';

if (isset($_GET['sort'])) $_SESSION['sortby'] = $_GET['sort'];
if (isset($_SESSION['sortby'])) $options['sortby'] = $_SESSION['sortby'];
if (!isset($options['compress_log'])) $options['compress_log'] = "0";
if (!isset($options['show_analyzer'])) $options['show_analyzer'] = "0";
if (!isset($options['show_developer'])) $options['show_developer'] = "0";
if (!isset($options['show_updates'])) $options['show_updates'] = "0";
$headclass = $options['fix_header'] == YES && $sitever != 'mobile' ? 'mmhead-fixed' : 'mmhead-scroll';

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
            height: calc(100vh - 200px);
            overflow-y: scroll;
            overflow-x: hidden;
        }
    </style>
    <?php
}

$min_width = '640px';
echo "<style type='text/css'>body {margin: 0; overflow-y: scroll; min-width: $min_width;}</style>";

echo "</head>\n";

echo tng_adminlayout();

$modtabs = set_horizontal_tabs($options['show_analyzer'], $options['show_developer'], $options['show_updates']);
$innermenu = set_innermenu_links($tng_version);
$menu = "<div class='mmmenuwrap'>";
$menu .= doMenu($modtabs, "parser", $innermenu);
$menu .= "</div>";

if (!isset($message)) $message = "";
$headline = displayHeadline($admtext['modmgr'], "img/modmgr_icon.gif", $menu, $message);
$first_menu = TRUE;

$cfgfolder = rtrim($rootpath, "/") . '/' . trim($modspath, "/") . '/';
$mhuser = isset($_SESSION['currentuserdesc']) ? $_SESSION['currentuser'] : "";

echo "<div id='mmhead' class='$headclass adminback'>\n";
echo $headline;
echo "</div>\n";
?>

<div class='mmcontainer whiteback' style='padding: 15px;'>";
    <?php
    require_once 'classes/modobjinits.php';
    include_once 'classes/modparser.class.php';
    $oParse = new modparser($objinits);

    if (empty($modfile)) {
        echo "<h1>{$admtext['selectmod']}</h1>";
        $modlist = $oParse->get_modfile_names();
        $modnum = 1;
        foreach ($modlist as $modfile) {
            echo "<p'>" . $modnum++ . ". <a href=\"" . $thisfile . "?modfile=$modfile\">$modfile</a></p>";
        }
        echo "<br><br></div><!--mmcontainer-->";

        echo tng_adminfooter();
        exit;
    }

    $tags = $oParse->parse($modspath . '/' . $modfile);
    $oParse->show_parse_table($tags);
    ?>
    <script>
        document.write('<a href=\"' + document.referrer + '\"><button>" . $admtext['
        backtoprevious
        '] . "</button></a>'
        )
        ;
    </script>
    <br><br><br>
</div><!--mmcontainer-->";
<?php
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
    global $admtext;

    $parts = explode(".", $tng_version);
    $tngmodver = "{$admtext['tngmods']} v{$parts[0]}";
    $tngmodurl = "Mods_for_TNG_v{$parts[0]}";
    $helplang = findhelp("modhandler_help.php");

    $innermenu = "<a href='#' onclick=\"return openHelp('$helplang/modhandler_help.php');\" class='lightlink'>{$admtext['help']}</a>";
    $innermenu .= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_Syntax\" target='_blank' class='lightlink'>{$admtext['modsyntax']}</a>";
    $innermenu .= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"https://tng.lythgoes.net/wiki/index.php?title=Mod_Guidelines\" target='_blank' class='lightlink'>{$admtext['modguidelines']}</a>";
    $innermenu .= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"https://tng.lythgoes.net/wiki/index.php?title=Category:$tngmodurl\" target='_blank' class='lightlink'>$tngmodver</a>";

    return $innermenu;
}

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

   jQuery('#expandall').click(function() {
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
                return confirm("<?php echo $admtext['nomodundo']; ?>");
            } else {
                alert("<?php echo $admtext['noselected']; ?> ");
                return false;
            }
        });
        jQuery('#btnInstall, #btnRemove, #btnClean').click(function () {
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

<?php tng_adminfooter() ?>

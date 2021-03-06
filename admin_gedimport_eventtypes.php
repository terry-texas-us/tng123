<?php
@ini_set("magic_quotes_runtime", "0");
@ini_set("auto_detect_line_endings", "1");
$umfs = substr(ini_get("upload_max_filesize"), 0, -1);
if ($umfs < 10) @ini_set("upload_max_filesize", "10M");


include "begin.php";
include "adminlib.php";
$textpart = "gedimport";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_add || !$allow_edit || $assignedbranch) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

include "config/importconfig.php";
require "adminlog.php";
$today = date("Y-m-d H:i:s");

global $prefix;
$helplang = findhelp("data_help.php");

tng_adminheader(_('Import/Export'), $flags);

echo "</head>\n";
echo tng_adminlayout();

$datatabs[0] = [1, "admin_dataimport.php", _('Import'), "import"];
$datatabs[1] = [1, "admin_export.php", _('Export'), "export"];
$datatabs[2] = [1, "admin_secondmenu.php", _('Secondary Processes'), "second"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/data_help.php');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($datatabs, "import", $innermenu);
echo displayHeadline(_('Import/Export') . " &gt;&gt; " . _('GEDCOM Import'), "img/data_icon.gif", $menu, (isset($message) ? $message : ""));
?>
<div class="lightback pad2">
    <div class="databack normal p-1">
        <?php
        $pciteevents = ["NAME", "BIRT", "CHR", "SEX", "DEAT", "BURI", "BAPL", "CONL", "INIT", "ENDL", "SLGC", "NICK", "NSFX", "TITL", "CHAN", "NPFX", "NSFX", "FAMC", "FAMS", "OBJE", "IMAGE", "SOUR", "ASSO", "_LIVING"];
        $fciteevents = ["HUSB", "WIFE", "MARR", "DIV", "SLGS", "CHAN", "CHIL", "OBJE", "SOUR", "ASSO", "_LIVING"];
        $sciteevents = ["ABBR", "AUTH", "CALN", "PUBL", "TITL", "CHAN", "DATA", "TEXT", "OBJE", "REPO"];
        $rciteevents = ["NAME", "ADDR", "CHAN", "OBJE"];

        @set_time_limit(0);
        if ($remotefile && $remotefile != "none") {
            $fp = @fopen($remotefile, "r");
            if ($fp === false) die (_('Cannot open file') . " $remotefile");

            echo "$remotefile " . _('opened...') . "<br>\n";
            $savestate['filename'] = $remotefile;
        } else {
            if ($database) {
                $localfile = $gedpath == "admin" || $gedpath == "" ? $database : "$rootpath$gedpath/$database";
                $fp = @fopen($localfile, "r");
                if (!$fp) {
                    die (_('Cannot open file') . " r=$rootpath, g=$gedpath, l=$localfile");
                }
                echo "$database " . _('opened...') . "<br>\n";
                $savestate['filename'] = $localfile;
            }
        }
        if ($savestate['filename']) $tree = $tree1; //selected

        ?>
        <p class="normal"><strong><?php echo _('Importing GEDCOM...<br>(this may take several minutes)'); ?></strong></p>
        <?php
        //get custom event types
        $query = "SELECT eventtypeID, tag, description, keep, type, display FROM $eventtypes_table";
        $result = tng_query($query);
        $custeventlist = [];
        while ($row = tng_fetch_assoc($result)) {
            $eventtype = $row['type'] . "_" . $row['tag'] . "_" . $row['description'];
            if ($row['keep'] && !in_array($eventtype, $custeventlist)) {
                array_push($custeventlist, $eventtype);
            }
        }
        tng_free_result($result);

        $eventctr = 0;

        function getLine() {
            global $fp, $lineending;

            $lineinfo = [];
            if ($line = ltrim(fgets($fp, 1024))) {
                $patterns = ["/��.*��/", "/��.*/", "/.*��/", "/@@/"];
                $replacements = ["", "", "", "@"];
                $line = preg_replace($patterns, $replacements, $line);

                preg_match("/^(\d+)\s+(\S+) ?(.*)$/", $line, $matches);

                $lineinfo['level'] = trim($matches[1]);
                $lineinfo['tag'] = trim($matches[2]);
                $lineinfo['rest'] = trim($matches[3], $lineending);
            } else {
                $lineinfo['level'] = "";
                $lineinfo['tag'] = "";
                $lineinfo['rest'] = "";
            }
            if (!$lineinfo['tag'] && !feof($fp)) $lineinfo = getLine();


            return $lineinfo;
        }

        function getContinued() {
            global $lineinfo;

            $continued = "";
            $notdone = 1;

            while ($notdone) {
                $lineinfo = getLine();
                if ($lineinfo['tag'] == "CONC") {
                    $continued .= addslashes($lineinfo['rest']);
                } elseif ($lineinfo['tag'] == "CONT") {
                    $continued .= addslashes("\n" . $lineinfo['rest']);
                } else {
                    $notdone = 0;
                }
            }
            return $continued;
        }

        function lookForEvents($prefix, $stdarray) {
            global $lineinfo, $custeventlist, $eventctr, $admtext, $eventtypes_table;

            $lineinfo = getLine();
            while ($lineinfo['tag'] && $lineinfo['level'] >= 1) {
                if ($lineinfo['level'] == 1) {
                    $tag = $lineinfo['tag'];
                    if (!in_array($tag, $stdarray)) {
                        if ($tag == "EVEN") {
                            $fact = addslashes($lineinfo['rest'] . getContinued());

                            if ($lineinfo['tag'] == "TYPE") {
                                $type = trim(addslashes($lineinfo['rest']));
                            } else {
                                if ($fact) {
                                    $type = $fact;
                                } else {
                                    do {
                                        $lineinfo = getLine();
                                    } while ($lineinfo['tag'] != "TYPE");
                                    $type = trim(addslashes($lineinfo['rest']));
                                }
                            }
                            $display = $type;
                        } else {
                            $type = "";
                            $display = "";
                        }
                        $thisevent = $prefix . "_" . $tag . "_" . $type;

                        if (!in_array($thisevent, $custeventlist)) {
                            array_push($custeventlist, $thisevent);
                            if (!$display) {
                                $display = isset($admtext[$tag]) ? $admtext[$tag] : $tag;
                            }
                            $query = "INSERT IGNORE INTO $eventtypes_table (tag, description, display, keep, type)  VALUES(\"$tag\", \"$type\", \"$display\", '0', \"$prefix\")";
                            $result = @tng_query($query) or die (_('Cannot execute query') . ": $query");

                            $eventctr++;
                            echo "<strong>$eventctr</strong> ";
                        }
                    }
                }
                $lineinfo = getLine();
            }
        }

        $lineinfo = getLine();
        while ($lineinfo['tag']) {
            if ($lineinfo['level'] == 0) {
                preg_match("/^@(\S+)@/", $lineinfo['tag'], $matches);
                $id = isset($matches[1]) ? $matches[1] : "";
                switch ($lineinfo['rest']) {
                    case "FAM":
                        lookForEvents("F", $fciteevents);
                        break;
                    case "INDI":
                        lookForEvents("I", $pciteevents);
                        break;
                    case "SOUR":
                        lookForEvents("S", $sciteevents);
                        break;
                    case "REPO":
                        lookForEvents("REPO", $rciteevents);
                        break;
                    default:
                        $lineinfo = getLine();
                        break;
                }
            } else {
                $lineinfo = getLine();
            }
        }
        @fclose($fp);
        ?>
        <span class="normal">
<br><br>
<?php
adminwritelog(_('Import/Export') . ": $eventctr " . _('Event Types'));
echo _('Finished Importing GEDCOM') . "<br>$eventctr " . _('Event Types');
?>
<br>
</span>
        <?php echo "<p><a href=\"admin_dataimport.php\">" . _('Back to Data Import') . "</a></p>"; ?>

        <?php echo tng_adminfooter(); ?>

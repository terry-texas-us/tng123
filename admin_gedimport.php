<?php
@ini_set("magic_quotes_runtime", "0");
@ini_set("auto_detect_line_endings", "1");
@ini_set('memory_limit', '200M');
$umfs = substr(ini_get("upload_max_filesize"), 0, -1);
if ($umfs < 15) {
    @ini_set("upload_max_filesize", "15M");
    @ini_set("post_max_size", "15M");
}

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
require "datelib.php";
require "gedimport_trees.php";
require "gedimport_families.php";
require "gedimport_sources.php";
require "gedimport_people.php";
require "gedimport_misc.php";
require "adminlog.php";
$today = date("Y-m-d H:i:s");

$readmsecs = (!empty($tngimpcfg['readmsecs']) && is_numeric($tngimpcfg['readmsecs'])) ? $tngimpcfg['readmsecs'] : 750;  //every 750 milliseconds
$writeinterval = (!empty($tngimpcfg['rrnum']) && is_numeric($tngimpcfg['rrnum'])) ? $tngimpcfg['rrnum'] : 100;  //every 100 records

global $prefix, $medialinks, $albumlinks;
$medialinks = $albumlinks = [];
$num_medialinks = $num_albumlinks = 0;
$ldsOK = determineLDSRights();

//added in 9.0.3
@ob_implicit_flush(true);

function initEvent() {
    $event = [];
    $event['DATE'] = "";
    $event['PLAC'] = "";
    $event['TEMP'] = "";
    $event['SOUR'] = "";
    $event['FAMC'] = "";
    $event['TYPE'] = "";
    $event['DATETR'] = "0000-00-00";
    $event['parent'] = "";

    return $event;
}

function initEventHolder() {
    $event = [];
    $event['INFO'] = initCustomEvent();
    $event['TAG'] = "";
    $event['TYPE'] = "";

    return $event;
}

function initCustomEvent() {
    $event = initEvent();

    $event['AGE'] = "";
    $event['AGNC'] = "";
    $event['CAUS'] = "";
    $event['ADDR'] = "";

    return $event;
}

function getMediaLinksToSave() {
    global $events_table, $tree, $medialinks_table;

    $medialinks = [];
    $query = "SELECT medialinkID, mediaID, $medialinks_table.eventID, persfamID, eventtypeID, eventdate, eventplace, info ";
    $query .= "FROM ($medialinks_table, $events_table) ";
    $query .= "WHERE $medialinks_table.gedcom = '$tree' AND $medialinks_table.eventID != '' AND $medialinks_table.eventID = $events_table.eventID";
    $result = @tng_query($query);
    while ($row = tng_fetch_assoc($result)) {
        $key = $row['persfamID'] . "::" . $row['eventtypeID'] . "::" . $row['eventdate'] . "::" . substr($row['eventplace'], 0, 40) . "::" . substr($row['info'], 0, 40);
        $key = preg_replace("/[^A-Za-z0-9:]/", "", $key);
        $value = $row['medialinkID'];
        $medialinks[$key][] = $value;
    }
    return $medialinks;
}

function getAlbumLinksToSave() {
    global $events_table, $tree, $album2entities_table;

    $albumlinks = [];
    $query = "SELECT alinkID, albumID, album2entities.eventID, entityID, eventtypeID, eventdate, eventplace, info ";
    $query .= "FROM ($album2entities_table album2entities, $events_table events) ";
    $query .= "WHERE album2entities.gedcom = '$tree' AND album2entities.eventID != '' AND album2entities.eventID = events.eventID";
    $result = @tng_query($query);
    while ($row = tng_fetch_assoc($result)) {
        $key = $row['entityID'] . "::" . $row['eventtypeID'] . "::" . $row['eventdate'] . "::" . substr($row['eventplace'], 0, 40) . "::" . substr($row['info'], 0, 40);
        $key = preg_replace("/[^A-Za-z0-9:]/", "", $key);
        $value = $row['alinkID'];
        $albumlinks[$key][] = $value;
    }
    return $albumlinks;
}

tng_adminheader(_('Import/Export'), $flags);

echo "</head>\n";
echo tng_adminlayout();

if (!empty($old)) {
    $datatabs['0'] = [1, "admin_dataimport.php", _('Import'), "import"];
    $datatabs['1'] = [$allow_export, "admin_export.php", _('Export'), "export"];
    $datatabs['2'] = [1, "admin_secondmenu.php", _('Secondary Processes'), "second"];
    $innermenu = "<a href='#' onclick=\"return openHelp('$helplang/data_help.php');\" class='lightlink'>" . _('Help for this area') . "</a>";
    $menu = doMenu($datatabs, "import", $innermenu);
    echo displayHeadline(_('Import/Export') . " &gt;&gt; " . _('GEDCOM Import'), "img/data_icon.gif", $menu, $message);

    echo "<div class='lightback' style=\"padding:2px;\">\n";
    echo "<div class='databack normal' style=\"padding:5px;\">\n";
}
$stdevents = ["BIRT", "SEX", "DEAT", "BURI", "MARR", "SLGS", "SLGC", "NICK", "NSFX", "TITL", "BAPL", "CONL", "INIT", "ENDL", "CHAN", "CALN", "AUTH", "PUBL", "ABBR", "TEXT"];
$pciteevents = ["NAME", "BIRT", "CHR", "DEAT", "BURI", "BAPL", "CONL", "INIT", "ENDL", "SLGC"];
$fciteevents = ["MARR", "DIV", "SLGS"];

function tng_extract($gedfilename) {
    global $rootpath, $gedpath, $savegedfilename, $basefilename;

    if (class_exists('ZipArchive')) {
        $zip = new ZipArchive();
        if ($zip->open($gedfilename)) {
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $zfile = $zip->getNameIndex($i);
                if (strtolower(pathinfo($zfile, PATHINFO_EXTENSION)) == "ged") {
                    $zip->extractTo("$rootpath$gedpath", $zfile);
                    unlink($gedfilename);
                    $basefilename = $savegedfilename = $zfile;
                    $gedfilename = "$rootpath$gedpath/$zfile";
                    break;
                }
            }
            if ($zip->numFiles) $zip->close();

        }
    }
    return $gedfilename;
}

//read first line into $line
@set_time_limit(0);
$fp = false;
$savestate['filename'] = "";
$openmsg = "";
$clearedtogo = "false";
if (isset($remotefile) && $remotefile && $remotefile != "none") {
    $basefilename = preg_replace("/[^a-zA-Z0-9\._-]/", "_", basename($_FILES['remotefile']['name']));
    $gedfilename = "$rootpath$gedpath/$basefilename";
    $savegedfilename = $basefilename;

    if (@move_uploaded_file($remotefile, $gedfilename)) {
        @chmod($gedfilename, 0644);

        $gedfilename = tng_extract($gedfilename);

        $fp = @fopen($gedfilename, "r");

        if ($fp === false) {
            $openmsg = _('Cannot open file') . " $basefilename. " . _('Your GEDCOM file may be larger than the maximum size allowed by your PHP installation. You can ask your provider to increase the \'upload_max_filesize\' value, or you can copy your file to the \'gedcom\' folder on your site and import it from there instead.');
        } else {
            $fstat = fstat($fp);
            $openmsg = _('Importing GEDCOM...<br>(this may take several minutes)');
            $savestate['filename'] = $gedfilename;
            $clearedtogo = "true";
            if (!empty($old)) {
                echo "<strong>$remotefile " . _('opened...') . "</strong><br>\n";
            }
        }
    } else {
        $openmsg = _('Could not upload file:') . " " . $_FILES['remotefile']['name'] . ". " . _('Your \'gedcom\' folder may have inadequate permissions (try 755 or 777).');
    }
} elseif (isset($database) && $database) {
    $gedfilename = $gedpath == "admin" || $gedpath == "" ? $database : "$rootpath$gedpath/$database";
    $savegedfilename = $database;

    $gedfilename = tng_extract($gedfilename);

    $fp = @fopen($gedfilename, "r");
    if ($fp === false) {
        $openmsg = _('Cannot open file') . " $database";
    } else {
        $fstat = fstat($fp);
        $openmsg = _('Importing GEDCOM...<br>(this may take several minutes)');
        $savestate['filename'] = $gedfilename;
        $clearedtogo = "true";
        if (!empty($old)) {
            echo "<strong>$database " . _('opened...') . "</strong><br>\n";
        }
    }
} elseif (!empty($resuming) && !$resuming) {
    $openmsg = _('Cannot open file') . ". " . _('Your GEDCOM file may be larger than the maximum size allowed by your PHP installation. You can ask your provider to increase the \'upload_max_filesize\' value, or you can copy your file to the \'gedcom\' folder on your site and import it from there instead.');
}

$allcount = 0;
if ($savestate['filename']) {
    $tree = $tree1; //selected
    $query = "UPDATE $trees_table SET lastimportdate=\"$today\", importfilename=\"$savegedfilename\" WHERE gedcom = '$tree'";
    $result = @tng_query($query) or die (_('Cannot execute query') . ": $query");

    if ($del == "append") {
        //calculate offsets
        if ($offsetchoice == "auto") {
            $savestate['ioffset'] = getNewNumericID("person", "person", $people_table);
            $savestate['foffset'] = getNewNumericID("family", "family", $families_table);
            $savestate['soffset'] = getNewNumericID("source", "source", $sources_table);
            $savestate['noffset'] = getNewNumericID("note", "note", $xnotes_table);
            $savestate['roffset'] = getNewNumericID("repo", "repo", $repositories_table);
        } else {
            $savestate['ioffset'] = $savestate['foffset'] = $savestate['soffset'] = $savestate['noffset'] = $savestate['roffset'] = $useroffset;
        }
        $savestate['del'] = "match";
    } else {
        $savestate['del'] = $del;
        $savestate['ioffset'] = $savestate['foffset'] = $savestate['soffset'] = $savestate['noffset'] = $savestate['roffset'] = 0;
        //get all medialinks+events where eventID is not blank
        if ($del != "no") {
            $medialinks = getMediaLinksToSave();
            $num_medialinks = count($medialinks);

            $albumlinks = getAlbumLinksToSave();
            $num_albumlinks = count($albumlinks);
        }
        if ($del == "yes") ClearData($tree);

    }

    $savestate['icount'] = 0;
    $savestate['fcount'] = 0;
    $savestate['scount'] = 0;
    $savestate['mcount'] = 0;
    $savestate['ncount'] = 0;
    $savestate['pcount'] = 0;
    $savestate['offset'] = 0;
    $savestate['ucaselast'] = !empty($ucaselast) ? 1 : 0;
    $savestate['norecalc'] = !empty($norecalc) ? 1 : 0;
    $savestate['neweronly'] = !empty($neweronly) ? 1 : 0;
    $savestate['allevents'] = !empty($allevents) ? 1 : 0;
    $savestate['media'] = !empty($importmedia) ? 1 : 0;
    $savestate['latlong'] = !empty($importlatlong) ? 1 : 0;
    $savestate['branch'] = !empty($branch1) ? $branch1 : "";
    $allcount = 0;
    $mll = $savestate['media'] * 10 + $savestate['latlong'];

    if ($saveimport) {
        $query = "DELETE FROM $saveimport_table";
        $result = @tng_query($query);

        $sql = "INSERT INTO $saveimport_table (filename, icount, ioffset, fcount, foffset, scount, soffset, mcount, pcount, ncount, noffset, roffset, offset, delvar, ucaselast, norecalc, neweronly, allevents, media, gedcom, branch)  
			VALUES(\"{$savestate['filename']}\", 0, \"{$savestate['ioffset']}\", 0, \"{$savestate['foffset']}\", 0, \"{$savestate['soffset']}\", 0, 0, 0, \"{$savestate['noffset']}\", \"{$savestate['roffset']}\", 0, \"$del\", {$savestate['ucaselast']}, {$savestate['norecalc']}, {$savestate['neweronly']}, {$savestate['allevents']}, $mll, '$tree', \"{$savestate['branch']}\")";
        $result = @tng_query($sql) or die (_('Cannot execute query') . ": $sql");
    }
} elseif ($saveimport && !$openmsg) {
    $checksql = "SELECT filename, icount, ioffset, fcount, foffset, scount, soffset, mcount, pcount, ncount, noffset, roffset, offset, ucaselast, norecalc, neweronly, allevents, media, branch, delvar FROM $saveimport_table WHERE gedcom = '$tree'";
    $result = @tng_query($checksql) or die (_('Cannot execute query') . ": $checksql");
    $found = tng_num_rows($result);
    if ($found) {
        $row = tng_fetch_assoc($result);
        $savestate['icount'] = $row['icount'];
        $savestate['fcount'] = $row['fcount'];
        $savestate['scount'] = $row['scount'];
        $savestate['mcount'] = $row['mcount'];
        $savestate['ncount'] = $row['ncount'];
        $savestate['pcount'] = $row['pcount'];
        $allcount = $savestate['icount'] + $savestate['fcount'] + $savestate['scount'] + $savestate['ncount'] + $savestate['mcount'] + $savestate['pcount'];
        $savestate['ioffset'] = $row['ioffset'];
        $savestate['foffset'] = $row['foffset'];
        $savestate['soffset'] = $row['soffset'];
        $savestate['noffset'] = $row['noffset'];
        $savestate['roffset'] = $row['roffset'];
        $savestate['filename'] = $row['filename'];
        $savestate['offset'] = $row['offset'];
        $savestate['del'] = $row['delvar'];
        $savestate['ucaselast'] = $row['ucaselast'];
        $savestate['norecalc'] = $row['norecalc'];
        $savestate['neweronly'] = $row['neweronly'];
        $savestate['allevents'] = $row['allevents'];
        $savestate['media'] = ($row['media'] > 9) ? 1 : 0;
        $savestate['latlong'] = $row['media'] % 2;
        $savestate['branch'] = $row['branch'];
        if ($savestate['del'] == "yes") $savestate['del'] = "match";

        $gedfilename = $savestate['filename'];
        $fp = fopen($savestate['filename'], "r");
        if ($fp !== false) {
            $fstat = fstat($fp);
            fseek($fp, $savestate['offset']);
            $openmsg = _('Importing GEDCOM...<br>(this may take several minutes)');
            $clearedtogo = "true";

            if (!empty($del) && $del != "no") {
                $medialinks = getMediaLinksToSave();
                $num_medialinks = count($medialinks);

                $albumlinks = getAlbumLinksToSave();
                $num_albumlinks = count($albumlinks);
            }
        } else {
            $openmsg = _('Cannot open file') . " " . $savestate['filename'] . " " . _('to resume import');
        }
    } else {
        $openmsg = _('Import could not be resumed.') . " " . _('It may have already finished.');
    }
} elseif (!$openmsg) {
    $openmsg = _('Import could not be resumed.') . " " . _('Make sure \'Save Import State\' is turned on in the Import Settings.');
}

if (!empty($old)) {
    echo "<p class='normal'>$openmsg</p>\n";
    if ($clearedtogo == "true" && $saveimport && (!$remotefile || $remotefile == "none")) {
        echo "<p class='normal'>" . _('If the import fails to run to completion,') . " <a href=\"admin_gedimport.php?tree=$tree&amp;old=1\">" . _('click here to resume') . "</a>.</p>\n";
    }
} else {
    ?>
    <script>
        var idivs, timeoutID;
        parent.started = <?php echo $clearedtogo; ?>;
        var icount = parent.document.getElementById('personcount');
        var fcount = parent.document.getElementById('familycount');
        var scount = parent.document.getElementById('sourcecount');
        var ncount = parent.document.getElementById('notecount');
        var mcount = parent.document.getElementById('mediacount');
        var pcount = parent.document.getElementById('placecount');
        var pbar = parent.document.getElementById('bar');

        function updateCount() {
            idivs = jQuery('div.impc');
            if (idivs.length) {
                var ilen = idivs.length - 1;
                //console.log('file at ' + idivs['ilen'].down('#pr').innerHTML);
                var pr = jQuery(idivs[ilen]).find('#pr');
                if (pr.length) pbar.style.width = pr.html();

                var ic = jQuery(idivs[ilen]).find('#ic');
                if (ic.length) icount.innerHTML = ic.html();

                var fc = jQuery(idivs[ilen]).find('#fc');
                if (fc.length) fcount.innerHTML = fc.html();

                var sc = jQuery(idivs[ilen]).find('#sc');
                if (sc.length) scount.innerHTML = sc.html();

                var nc = jQuery(idivs[ilen]).find('#nc');
                if (nc.length) ncount.innerHTML = nc.html();
                var mc = jQuery(idivs[ilen]).find('#mc');
                if (mc.length) mcount.innerHTML = mc.html();
                var pc = jQuery(idivs[ilen]).find('#pc');
                if (pc.length) pcount.innerHTML = pc.html();
            }
            if (!parent.done)
                timeoutID = setTimeout(updateCount, <?php echo $readmsecs; ?>);
            else if (!parent.suspended) {
                msgdiv.innerHTML = "<?php echo _('Finished Importing GEDCOM'); ?>" + ' &nbsp;<img src="img/tng_check.gif">';
                showCloseMenu();
            }
        }

        function showCloseMenu() {
            var closemsg = '<a href="#" onclick="tnglitbox.remove();return false;"><img src="img/tng_close.gif" align="left" style="margin-right:5px">' + "<?php echo _('Close this window'); ?>" + '</a>';
            if (parent.started)
                parent.document.getElementById('implinks').innerHTML = '<span id="toremove"><a href="#" onclick="return removeFile(\'<?php echo $gedfilename; ?>\');">' + "<?php echo _('Delete GEDCOM file (optional)'); ?>" + '</a></span><p>' + closemsg + ' | <a href="admin_secondmenu.php">' + "<?php echo _('More Options'); ?>" + '</a></p>';
            else
                parent.document.getElementById('implinks').innerHTML = '<p>' + closemsg + '</p>';
        }

        var msgdiv = parent.document.getElementById('importmsg');
        if (parent.started) {
            parent.document.getElementById('impdata').style.visibility = "visible";
            timeoutID = setTimeout(updateCount, <?php echo $readmsecs; ?>);
        } else
            showCloseMenu();
        msgdiv.innerHTML = "<?php echo $openmsg; ?>";
    </script>

    <?php
}

//now kill it on purpose so TNG will restart and be able to show the progress bar.
if (!empty($old) && !$resuming && !$num_medialinks && !$num_albumlinks) exit;

if ($fp !== false) {
    @ob_flush();
    @flush();

    $savestate['livingstr'] = $savestate['norecalc'] ? "" : ", living";
    if (!$tngimpcfg['maxlivingage']) {
        $tngimpcfg['maxlivingage'] = 110;
    }

    //get custom event types
    $query = "SELECT eventtypeID, tag, description, keep, type, display FROM $eventtypes_table";
    $result = @tng_query($query);
    $custeventlist = [];
    while ($row = tng_fetch_assoc($result)) {
        $eventtype = strtoupper($row['type'] . "_" . $row['tag'] . "_" . $row['description']);
        $custevents[$eventtype]['keep'] = $row['keep'];
        $custevents[$eventtype]['display'] = $row['display'];
        $custevents[$eventtype]['eventtypeID'] = $row['eventtypeID'];
        if ($row['keep'] && !in_array($eventtype, $custeventlist)) {
            array_push($custeventlist, $eventtype);
        }
    }
    tng_free_result($result);

    $stdnotes = [];
    $notecount = 0;

    $lineinfo = getLine();
    while ($lineinfo['tag']) {
        if ($lineinfo['level'] == 0) {
            preg_match("/^@(\S+)@/", $lineinfo['tag'], $matches);
            $id = isset($matches[1]) ? $matches[1] : "";
            switch (trim($lineinfo['rest'])) {
                case "FAM":
                    getFamilyRecord($id, 0);
                    break;
                case "INDI":
                    getIndividualRecord($id, 0);
                    break;
                case "SOUR":
                    getSourceRecord($id, 0);
                    break;
                case "REPO":
                    getRepoRecord($id, 0);
                    break;
                case "NOTE":
                    getNoteRecord($id, 0);
                    break;
                case "_LOC":  //alternate place name structure
                    getPlaceRecord($id, 0);
                    break;
                case "OBJE":
                    if ($savestate['media']) {
                        $mminfo = [];
                        getMultimediaRecord($id, 0);
                    } else {
                        $lineinfo = getLine();
                    }
                    break;
                default:
                    if (strtok($lineinfo['rest'], " ") == "NOTE") {
                        getNoteRecord($id, 0);
                    } else {
                        if ($id) {
                            $nextpart = strtok($lineinfo['rest'], " ");
                            $len = strlen($nextpart);
                            $lineinfo['rest'] = substr($lineinfo['rest'], $len + 1);
                        } else {
                            $nextpart = $lineinfo['tag'];
                        }
                        if ($nextpart == "_PLAC" || $nextpart == "_PLAC_DEFN" || $nextpart == "PLAC") {
                            getPlaceRecord($lineinfo['rest'], 0);
                        } else {
                            $lineinfo = getLine();
                        }
                    }
                    break;
            }
        } else {
            $lineinfo = getLine();
        }
        @ob_flush();
        @flush();
    }
    @fclose($fp);

    $treemsg = $tree ? ", " . _('Tree') . ": $tree/" : "";
    adminwritelog("" . _('GEDCOM Import') . ": " . basename(_('File Name')) . ":{$savestate['filename']}$treemsg; {$savestate['icount']} " . _('People') . ", {$savestate['fcount']} " . _('Families') . ", {$savestate['scount']} " . _('Sources') . ", {$savestate['ncount']} " . _('Notes') . ", {$savestate['mcount']} " . _('Media') . ", {$savestate['pcount']} " . _('Places') . "");

    if (!empty($old)) {
        echo "<p>" . _('Finished Importing GEDCOM') . "<br>" . number_format($savestate['icount']) . " " . _('People') . " &nbsp; " . number_format($savestate['fcount']) . " " . _('Families') . " &nbsp; " . number_format($savestate['scount']) . " " . _('Sources') . " &nbsp; " . number_format($savestate['ncount']) . " " . _('Notes') . " &nbsp; " . number_format($savestate['mcount']) . " " . _('Media') . " &nbsp; " . number_format($savestate['pcount']) . " " . _('Places') . "</p>";
    } else {
        echo "<div class='impc'>\n";
        echo "<span id='pr'>500</span><span id='ic'>" . $savestate['icount'] . "</span><span id='fc'>" . $savestate['fcount'] . "</span><span id='sc'>" . $savestate['scount'] . "</span><span id='nc'>" . $savestate['ncount'] . "</span><span id='mc'>" . $savestate['mcount'] . "</span><span id='pc'>" . $savestate['pcount'] . "</span>\n";
        echo "</div>\n";
        ?>
        <script>
            parent.done = true;
        </script>
        <?php
    }
}
if (!empty($old)) {
    echo "<p><a href=\"admin_secondary.php?secaction=" . _('Track Lines') . "&tree=$tree\">" . _('Track Lines') . "</a></p>";
    echo "<p><a href=\"admin_dataimport.php\">" . _('Back to Data Import') . "</a></p>\n";
    echo "</div></div>\n";
}
?>
<?php echo tng_adminfooter(); ?>
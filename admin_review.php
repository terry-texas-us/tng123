<?php
include "begin.php";
include "adminlib.php";
require_once "./admin/trees.php";

$textpart = "review";
include "$mylanguage/admintext.php";

$admin_login = true;
include "checklogin.php";
include "version.php";

$query = "SELECT *, DATE_FORMAT(postdate,\"%d %b %Y %H:%i:%s\") AS postdate FROM $temp_events_table WHERE tempID = \"$tempID\"";
$result = tng_query($query);
$row = tng_fetch_assoc($result);
tng_free_result($result);
$tree = $row['gedcom'];
$personID = $row['personID'];
$familyID = $row['familyID'];
$eventID = $row['eventID'];

$righttree = checktree($tree);

//look up person or family
if ($row['type'] == "I" || $row['type'] == "C") {
    $tng_search_preview = $_SESSION['tng_search_preview'];
    $reviewmsg = _('Accept or decline tentative changes to individuals');

    $query = "SELECT firstname, lastname, lnprefix, nameorder, prefix, suffix, gedcom, branch FROM $people_table WHERE personID = \"$personID\" AND gedcom = '$tree'";
    $result = tng_query($query);
    $prow = tng_fetch_assoc($result);
    tng_free_result($result);

    $persfamID = $personID;
    $rightbranch = $righttree ? checkbranch($prow['branch']) : false;
    $rights = determineLivingPrivateRights($prow, $righttree, $rightbranch);
    $prow['allow_living'] = $rights['living'];
    $prow['allow_private'] = $rights['private'];

    $name = getName($prow);
    $teststr = "  | <a href=\"getperson.php?personID=$personID&amp;tree=$tree\" target='_blank'>" . _('Test') . "</a>";
    $editstr = "  | <a href=\"admin_editperson.php?personID=$personID&amp;tree=$tree\" target='_blank'>" . _('Edit') . "</a>";
} elseif ($row['type'] == "F") {
    $query = "SELECT husband, wife FROM $families_table WHERE familyID = '$familyID' AND gedcom = '$tree'";
    $result = tng_query($query);
    $frow = tng_fetch_assoc($result);
    $hname = $wname = "";
    if ($frow['husband']) {
        $query = "SELECT firstname, lastname, lnprefix, nameorder, prefix, suffix, gedcom, branch FROM $people_table WHERE personID = \"{$frow['husband']}\" AND gedcom = '$tree'";
        $result = tng_query($query);
        $prow = tng_fetch_assoc($result);
        $rightbranch = $righttree ? checkbranch($prow['branch']) : false;
        $prights = determineLivingPrivateRights($prow, $righttree, $rightbranch);
        $prow['allow_living'] = $prights['living'];
        $prow['allow_private'] = $prights['private'];
        tng_free_result($result);
        $hname = getName($prow);
    }
    if ($frow['wife']) {
        $query = "SELECT firstname, lastname, lnprefix, nameorder, prefix, suffix, gedcom, branch FROM $people_table WHERE personID = \"{$frow['wife']}\" AND gedcom = '$tree'";
        $result = tng_query($query);
        $prow = tng_fetch_assoc($result);
        $rightbranch = $righttree ? checkbranch($prow['branch']) : false;
        $prights = determineLivingPrivateRights($prow, $righttree, $rightbranch);
        $prow['allow_living'] = $prights['living'];
        $prow['allow_private'] = $prights['private'];
        tng_free_result($result);
        $wname = getName($prow);
    }

    $persfamID = $familyID;
    $plus = $hname && $wname ? " + " : "";
    $name = "$hname$plus$wname";

    $checkbranch = 1;
    $teststr = "  | <a href=\"familygroup.php?familyID=$familyID&amp;tree=$tree\" target='_blank'>" . _('Test') . "</a>";
    $editstr = "  | <a href=\"admin_editfamily.php?familyID=$familyID&amp;tree=$tree\" target='_blank'>" . _('Edit') . "</a>";
}

if (!$allow_edit || ($assignedtree && $assignedtree != $tree) || !$rightbranch) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

if (is_numeric($eventID)) {
    //custom event type
    $datefield = "eventdate";
    $placefield = "eventplace";
    $factfield = "info";

    $query = "SELECT eventdate, eventplace, info FROM $events_table WHERE eventID = \"$eventID\"";
    $result = tng_query($query);
    $evrow = tng_fetch_assoc($result);
    tng_free_result($result);

    $query = "SELECT display, tag ";
    $query .= "FROM $eventtypes_table eventtypes, $events_table events ";
    $query .= "WHERE eventID = $eventID AND eventtypes.eventtypeID = events.eventtypeID";
    $evresult = tng_query($query);
    $evtrow = tng_fetch_assoc($evresult);

    if ($evtrow['display']) {
        $displayval = getEventDisplay($evtrow['display']);
    } elseif ($evtrow['tag']) {
        $displayval = $eventtype['tag'];
    } else {
        $displayval = $admtext[$eventID];
    }
} else {
    //standard, do switch
    $needfamilies = 0;
    $needchildren = 0;
    switch ($eventID) {
        case "TITL":
            $factfield = "title";
            break;
        case "NPFX":
            $factfield = "prefix";
            break;
        case "NSFX":
            $factfield = "suffix";
            break;
        case "NICK":
            $factfield = "nickname";
            break;
        case "BIRT":
            $datefield = "birthdate";
            $placefield = "birthplace";
            break;
        case "CHR":
            $datefield = "altbirthdate";
            $placefield = "altbirthplace";
            break;
        case "BAPL":
            $datefield = "baptdate";
            $placefield = "baptplace";
            break;
        case "CONL":
            $datefield = "confdate";
            $placefield = "confplace";
            break;
        case "INIT":
            $datefield = "initdate";
            $placefield = "initplace";
            break;
        case "ENDL":
            $datefield = "endldate";
            $placefield = "endlplace";
            break;
        case "DEAT":
            $datefield = "deathdate";
            $placefield = "deathplace";
            break;
        case "BURI":
            $datefield = "burialdate";
            $placefield = "burialplace";
            break;
        case "MARR":
            $datefield = "marrdate";
            $placefield = "marrplace";
            $factfield = "marrtype";
            $needfamilies = 1;
            break;
        case "DIV":
            $datefield = "divdate";
            $placefield = "divplace";
            $needfamilies = 1;
            break;
        case "SLGS":
            $datefield = "sealdate";
            $placefield = "sealplace";
            $needfamilies = 1;
            break;
        case "SLGC":
            $datefield = "sealdate";
            $placefield = "sealplace";
            $needchildren = 1;
            break;
    }

    $fieldstr = $datefield;
    if ($placefield) {
        $fieldstr .= $fieldstr ? ", $placefield" : $placefield;
    }
    if ($factfield) {
        $fieldstr .= $fieldstr ? ", $factfield" : $factfield;
    }

    if ($needfamilies) {
        $query = "SELECT $fieldstr FROM $families_table WHERE familyID = '$familyID' AND gedcom = '$tree'";
    } elseif ($needchildren) {
        $query = "SELECT $fieldstr FROM $children_table WHERE familyID = '$familyID' AND personID = \"$personID\" AND gedcom = '$tree'";
    } else {
        $query = "SELECT $fieldstr FROM $people_table WHERE personID = \"$personID\" AND gedcom = '$tree'";
    }
    $result = tng_query($query);
    $evrow = tng_fetch_assoc($result);
    tng_free_result($result);

    $query = "SELECT count(eventID) AS evcount FROM $events_table WHERE persfamID='$persfamID' AND gedcom ='$tree' AND eventID =\"$eventID\"";
    $morelinks = tng_query($query);
    $more = tng_fetch_assoc($morelinks);
    $gotmore = $more['evcount'] ? "*" : "";
    tng_free_result($morelinks);

    $displayval = $admtext[$eventID];
}

$treerow = getTree($trees_table, $tree);

$query = "SELECT count(ID) AS notecount FROM $notelinks_table WHERE persfamID='$persfamID' AND gedcom ='$tree' AND eventID =\"$eventID\"";
$notelinks = tng_query($query);
$note = tng_fetch_assoc($notelinks);
$gotnotes = $note['notecount'] ? "*" : "";
tng_free_result($notelinks);

$citequery = "SELECT count(citationID) AS citecount FROM $citations_table WHERE persfamID='$persfamID' AND gedcom ='$tree' AND eventID = \"$eventID\"";
$citeresult = tng_query($citequery) or die (_('Cannot execute query') . ": $citequery");
$cite = tng_fetch_assoc($citeresult);
$gotcites = $cite['citecount'] ? "*" : "";
tng_free_result($citeresult);

$helplang = findhelp("people_help.php");

tng_adminheader(_('Review'), $flags);
include_once "eventlib.php";
include_once "eventlib_js.php";
?>
<script>
    var persfamID = "<?php echo $personID; ?>";
</script>

<?php
echo "</head>\n";
echo tng_adminlayout();

if ($row['type'] == "I") {
    $icon = "img/people_icon.gif";
    $hmsg = _('People');
    $peopletabs[0] = [1, "admin_people.php", _('Search'), "findperson"];
    $peopletabs[1] = [$allow_add, "admin_newperson.php", _('Add New'), "addperson"];
    $peopletabs[2] = [$allow_edit, "admin_findreview.php?type=I", _('Review'), "review"];
    $peopletabs[3] = [$allow_edit && $allow_delete, "admin_merge.php", _('Merge'), "merge"];
} else {
    $icon = "img/families_icon.gif";
    $hmsg = _('Families');
    $peopletabs[0] = [1, "admin_families.php", _('Search'), "findperson"];
    $peopletabs[1] = [$allow_add, "admin_newfamily.php", _('Add New'), "addfamily"];
    $peopletabs[2] = [$allow_edit, "admin_findreview.php?type=F", _('Review'), "review"];
}
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/people_help.php#review');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($peopletabs, "review", $innermenu);
echo displayHeadline("$hmsg &gt;&gt; " . _('Review') . "", $icon, $menu, $message);
?>

<table class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <span class="subhead"><strong><?php echo "$persfamID: $name</strong> $teststr $editstr"; ?></span><br><br>
            <div class="normal">

                <form action="admin_savereview.php" method="post" name="form1">
                    <table class="normal">
                        <tr>
                            <td class='align-top'><span class="normal"><?php echo _('Tree'); ?>:</span></td>
                            <td><span class="normal"><?php echo $treerow['treename']; ?></span></td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class='align-top'><h3 class="subhead"><?php echo _('Event(s)'); ?>:</h3></td>
                            <td><h3 class="subhead"><?php echo $displayval; ?></h3></td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <?php
                        if ($datefield) {
                            // TODO span tags out of order datefield and placefield
                            echo "<tr>";
                            echo "<td>" . _('Event Date') . ": </span></td>";
                            echo "<td class='align-top'><span class='normal'>{$evrow[$datefield]}</td>";
                            echo "</tr>\n";
                            echo "<tr>";
                            echo "<td><strong>" . _('Suggested') . ":</strong></td>";
                            echo "<td colspan='2'><input type='text' name=\"newdate\" value=\"{$row['eventdate']}\" onblur=\"checkDate(this);\"></td>";
                            echo "</tr>\n";
                        }
                        if ($placefield) {
                            $row['eventplace'] = preg_replace("/\"/", "&#34;", $row['eventplace']);
                            echo "<tr>";
                            echo "<td>" . _('Event Place') . ":</td>";
                            echo "<td class='align-top'><span class='normal'>{$evrow[$placefield]}</td>";
                            echo "</tr>\n";
                            echo "<tr>";
                            echo "<td><strong>" . _('Suggested') . ":</strong></td>";
                            echo "<td class='align-top'><input type='text' name=\"newplace\" class=\"verylongfield\" id=\"newplace\" size=\"40\" value=\"{$row['eventplace']}\"></td>";
                            echo "<td><a href='#' onclick=\"return openFindPlaceForm('newplace');\" title=\"" . _('Find...') . "\" class=\"smallicon admin-find-icon\"></a></td>";
                            echo "</tr>\n";
                        }
                        if ($factfield) {
                            $row['info'] = preg_replace("/\"/", "&#34;", $row['info']);
                            echo "<tr>";
                            echo "<td class='align-top'>" . _('Detail') . ":</td>";
                            echo "<td class='align-top'>{$row[$factfield]}</td>";
                            echo "</tr>\n";
                            echo "<tr>";
                            echo "<td class='align-top'><strong>" . _('Suggested') . ":</strong></td>";
                            echo "<td class='align-top' colspan='2'><textarea cols=\"60\" rows='4' name=\"newinfo\">{$row['info']}</textarea></td>";
                            echo "</tr>\n";
                        }
                        $row['note'] = preg_replace("/\"/", "&#34;", $row['note']);
                        ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td>
                                <?php
                                $notesicon = $gotnotes ? "admin-note-on-icon" : "admin-note-off-icon";
                                $citesicon = $gotcites ? "admin-cite-on-icon" : "admin-cite-off-icon";
                                $moreicon = $gotmore ? "admin-more-on-icon" : "admin-more-off-icon";
                                if (!is_numeric($eventID)) {
                                    echo "<a href='#' onclick=\"return showMore('$eventID','$persfamID');\" id=\"moreicon$eventID\" class=\"smallicon $moreicon\"></a>\n";
                                }
                                echo "<a href='#' onclick=\"return showNotes('$eventID','$persfamID');\" id=\"notesicon$eventID\" class=\"smallicon $notesicon\"></a>\n";
                                echo "<a href='#' onclick=\"return showCitations('$eventID','$persfamID');\" id=\"citesicon$eventID\" class=\"smallicon $citesicon\"></a>\n";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class='align-top'><?php echo _('Notes regarding<br>suggested change<br>(will not be saved)'); ?>:</td>
                            <td class='align-top'><textarea cols="60" rows="4" name="usernote"><?php echo $row['note']; ?></textarea></td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class='align-top'><?php echo _('Posted on'); ?>:</td>
                            <td><?php echo "{$row['postdate']} ({$row['user']})"; ?></td>
                        </tr>
                    </table>
                    <br>
                    <input type="hidden" name="tempID" value="<?php echo $tempID; ?>">
                    <input type="hidden" name="type" value="<?php echo $row['type']; ?>">
                    <input type="hidden" name="tree" value="<?php echo $tree; ?>">
                    <input type="hidden" name="choice" value="<?php echo _('Save and Delete'); ?>">
                    <input type="submit" class="btn" value="<?php echo _('Save and Delete'); ?>">
                    <input type="submit" class="btn" value="<?php echo _('Postpone'); ?>" onClick="document.form1.choice.value='<?php echo _('Postpone'); ?>';">
                    <input type="submit" class="btn" value="<?php echo _('Ignore and Delete'); ?>" onClick="document.form1.choice.value='<?php echo _('Ignore and Delete'); ?>';">
                    <br>
                </form>
            </div>
        </td>
    </tr>

</table>

<?php echo tng_adminfooter(); ?>

<?php
$textpart = "getperson";
include "tng_begin.php";

$factfield = $datefield = $placefield = "";

$righttree = checktree($tree);

if ($type == "I" || $type == "C") {
    if ($type == "I") {
        $personID = $persfamID;
        $familyID = "";
    } else { //type C
        $ids = explode("::", $persfamID);
        $personID = $ids[0];
        $familyID = $ids[1];
    }
    $result = getPersonSimple($tree, $personID);
    $namerow = tng_fetch_assoc($result);

    $rights = determineLivingPrivateRights($namerow, $righttree);
    $namerow['allow_living'] = $rights['living'];
    $namerow['allow_private'] = $rights['private'];

    $name = getName($namerow);
    tng_free_result($result);
} elseif ($type == "F") {
    $personID = "";
    $familyID = $persfamID;

    $result = getFamilyData($tree, $familyID);
    $frow = tng_fetch_assoc($result);
    $hname = $wname = "";

    $rights = determineLivingPrivateRights($frow, $righttree);
    $frow['allow_living'] = $rights['living'];
    $frow['allow_private'] = $rights['private'];

    if ($frow['husband']) {
        $result = getPersonSimple($tree, $frow['husband']);
        $prow = tng_fetch_assoc($result);
        tng_free_result($result);

        $prights = determineLivingPrivateRights($prow, $righttree);
        $prow['allow_living'] = $prights['living'];
        $prow['allow_private'] = $prights['private'];

        $hname = getName($prow);
    }
    if ($frow['wife']) {
        $result = getPersonSimple($tree, $frow['wife']);
        $prow = tng_fetch_assoc($result);
        tng_free_result($result);

        $prights = determineLivingPrivateRights($prow, $righttree);
        $prow['allow_living'] = $prights['living'];
        $prow['allow_private'] = $prights['private'];

        $wname = getName($prow);
    }

    $persfamID = $familyID;
    $plus = $hname && $wname ? " + " : "";
    $name = _('Family') . " $familyID<br>$hname$plus$wname";
}

if (is_numeric($event)) {
    //custom event type
    $datefield = "eventdate";
    $placefield = "eventplace";
    $factfield = "info";

    if ($rights['both']) {
        $query = "SELECT eventdate, eventplace, info FROM $events_table WHERE eventID = \"$event\"";
        $result = tng_query($query);
        $row = tng_fetch_assoc($result);
        tng_free_result($result);
    } else {
        $row = [];
    }
} else {
    //standard, do switch
    $needfamilies = 0;
    $needchildren = 0;
    switch ($event) {
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

    if ($rights['both']) {
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
        $row = tng_fetch_assoc($result);
        tng_free_result($result);
    } else {
        $row = [];
    }
}

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack ajaxwindow" id="tentedit">
    <h3 class="subhead"><?php echo _('Suggest a change for this event'); ?></h3>

    <h2 class="header"><?php echo "$name: $title"; ?></h2>
    <?php
    echo getFORM("", "post", "form1\" onsubmit=\"return saveTentEdit(this);", "form1");
    ?>
    <input type="hidden" name="tree" value="<?php echo $tree; ?>">
    <input type="hidden" name="personID" value="<?php echo $personID; ?>">
    <input type="hidden" name="familyID" value="<?php echo $familyID; ?>">
    <input type="hidden" name="eventID" value="<?php echo $event; ?>">
    <input type="hidden" name="type" value="<?php echo $type; ?>">
    <table cellspacing="0" cellpadding="2">
        <?php
        if ($datefield) {
            echo "<tr>";
            echo "<td class='align-top'><span class='normal'>" . _('Date') . ": </span></td>";
            echo "<td class='align-top'><span class='normal'>$row[$datefield]</span></td>";
            echo "</tr>\n";
            echo "<tr>";
            echo "<td class='align-top'><span class='normal'>" . _('Suggested') . ": </span></td>";
            echo "<td class='align-top'><input type='text' name=\"newdate\" value=\"$row[$datefield]\" onblur=\"checkDate(this);\"></td>";
            echo "</tr>\n";
            echo "<tr>";
            echo "<td colspan='2'>&nbsp;</td>";
            echo "</tr>\n";
        }
        if ($placefield) {
            $row[$placefield] = preg_replace("/\"/", "&#34;", $row[$placefield]);
            echo "<tr>";
            echo "<td class='align-top'><span class='normal'>" . _('Place') . ": </span></td>";
            echo "<td class='align-top'><span class='normal'>$row[$placefield]</span></td>";
            echo "</tr>\n";
            echo "<tr>";
            echo "<td class='align-top'><span class='normal'>" . _('Suggested') . ": </span></td>";
            echo "<td class='align-top'><input type='text' name=\"newplace\" size=\"40\" value=\"$row[$placefield]\"></td>";
            echo "</tr>\n";
            echo "<tr>";
            echo "<td colspan='2'>&nbsp;</td>";
            echo "</tr>\n";
        }
        if ($factfield) {
            $row[$factfield] = preg_replace("/\"/", "&#34;", $row[$factfield]);
            $factmsg = $event == "MARR" ? _('Type') : _('Detail');
            echo "<tr>";
            echo "<td class='align-top'><span class='normal'>$factmsg: </span></td>";
            echo "<td class='align-top'><span class='normal'>$row[$factfield]</span></td>";
            echo "</tr>\n";
            echo "<tr>";
            echo "<td class='align-top'><span class='normal'>" . _('Suggested') . ": </span></td>";
            echo "<td class='align-top'>";
            if ($event == "MARR") {
                echo "<input type='text' name=\"newinfo\" size=\"40\" value=\"$row[$factfield]\">";
            } else {
                echo "<textarea cols=\"40\" rows='3' name=\"newinfo\">$row[$factfield]</textarea>";
            }
            echo "</td>";
            echo "</tr>\n";
            echo "<tr>";
            echo "<td colspan='2'>&nbsp;</td>";
            echo "</tr>\n";
        }
        ?>
        <tr>
            <td class='align-top'><span class="normal"><?php echo _('Notes'); ?>: </span></td>
            <td class='align-top'><textarea cols="40" rows="3" name="usernote"></textarea></td>
        </tr>
    </table>
    <br>
    <input type="submit" value="<?php echo _('Save Changes'); ?>">
    <span id="tspinner" style="display:none;"><img src="img/spinner.gif"></span>
    </form>

</div>

<div class="databack" style="margin:10px;border:0;display:none;" id="finished">
    <h2 class="header"><?php echo _('Thank you'); ?></h2>
    <p class="normal"><?php echo _('Your suggestion was forwarded to the site administrator for review.'); ?><br><br>
        <a href="#" onclick="tnglitbox.remove();"><?php echo _('Close this window'); ?></a></p>
</div>
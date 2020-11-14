<?php

include "begin.php";
include "adminlib.php";

require_once "./admin/associations.php";
require_once "./admin/citations.php";
require_once "./admin/events.php";
require_once "./admin/notelinks.php";
require_once "./admin/branches.php";
require_once "./admin/trees.php";
require_once "./public/people.php";
$textpart = "people";
include "$mylanguage/admintext.php";
$admin_login = true;
include "checklogin.php";
include "version.php";
if (!isset($cw)) $cw = '';
if (!isset($added)) $added = 0;
$iconChevronDown = buildSvgElement("img/chevron-down.svg", ["class" => "w-3 h-3 ml-2 fill-current inline-block"]);
initMediaTypes();
$row = fetchAndCleanPersonRow($personID, $people_table, $tree);
if ((!$allow_edit && (!$allow_add || !$added)) || ($assignedtree && $assignedtree != $tree) || !checkbranch($row['branch'])) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$editconflict = determineConflict($row, $people_table);
if ($tngconfig['edit_timeout'] === "") {
    $tngconfig['edit_timeout'] = 15;
}
$warnsecs = (intval($tngconfig['edit_timeout']) - 2) * 60 * 1000;

if ($row['sex'] == "M") {
    $spouse = "wife";
    $self = "husband";
    $spouseorder = "husborder";
    $selfdisplay = _('as father');
    $childrel = "frel";
} else {
    if ($row['sex'] == "F") {
        $spouse = "husband";
        $self = "wife";
        $spouseorder = "wifeorder";
        $selfdisplay = _('as mother');
        $childrel = "mrel";
    } else {
        $spouse = "";
        $self = "";
        $spouseorder = "";
        $selfdisplay = _('as spouse');
        $childrel = "";
    }
}

$tng_search_people = $_SESSION['tng_search_people'] ?? '';

$righttree = checktree($tree);
$rightbranch = $righttree ? checkbranch($row['branch']) : false;
$rights = determineLivingPrivateRights($row, $righttree, $rightbranch);
$row['allow_living'] = $rights['living'];
$row['allow_private'] = $rights['private'];

$namestr = getName($row);

$treerow = getTree($trees_table, $tree);

$gotnotes = checkForNoteLinks($personID, $tree);
$gotcites = checkForCitations($personID, $tree);
$gotassoc = checkForAssociations($personID, $tree);
$gotmore = checkForEvents($personID, $tree);

function parentRow($parent, $spouse, $label) {
    global $people_table, $families_table, $admtext, $tree, $righttree, $cw;

    $pout = "";
    $query = "SELECT personID, lastname, lnprefix, firstname, birthdate, birthplace, altbirthdate, altbirthplace, deathdate, burialdate, prefix, suffix, nameorder, sex, people.living, people.private ";
    $query .= "FROM $people_table people, $families_table families ";
    $query .= "WHERE people.personID = families.{$spouse} AND families.familyID = \"{$parent['familyID']}\" AND people.gedcom = '$tree' AND families.gedcom = '$tree'";
    $gotparent = tng_query($query);

    if ($gotparent) {
        $prow = tng_fetch_assoc($gotparent);
        if ($prow['sex'] == "M") {
            $label = "father";
        } elseif ($prow['sex'] == "F") {
            $label = "mother";
        }
        //if unknown, it gets what was passed in

        list($prow, $birthinfo) = getVitalInformation($prow, $righttree);

        $pout = "<tr>\n";
        $pout .= "<td>" . $admtext[$label] . ":</td>\n";
        $pout .= "<td colspan='4'>";
        if ($prow['personID']) {
            $pout .= "<a href=\"admin_editperson.php?personID={$prow['personID']}&amp;tree={$tree}&amp;cw={$cw}\">" . getName($prow) . " - {$prow['personID']}</a>{$birthinfo}";
        }
        $pout .= "</td>\n";
        $pout .= "</tr>\n";
        $pout .= "<tr>\n";
        $pout .= "<td>&nbsp;&nbsp;" . _('Relationship') . ":</td>\n";
        $pout .= "<td colspan='4'>\n";
        $fieldname = $label == "father" ? "frel" : "mrel";
        $pout .= "<select name=\"$fieldname{$parent['familyID']}\">\n";
        $pout .= "<option value=\"\"></option>\n";

        $reltypes = ["adopted", "birth", "foster", "sealing", "step", "putative"];
        foreach ($reltypes as $reltype) {
            $pout .= "<option value=\"$reltype\"";
            if ($parent[$fieldname] == $reltype || $parent[$fieldname] == $admtext[$reltype]) {
                $pout .= " selected";
            }
            $pout .= ">{$admtext[$reltype]}</option>\n";
        }
        $pout .= "</select>\n";
        $pout .= "</td>\n";
        $pout .= "</tr>\n";

        tng_free_result($gotparent);
    }

    return $pout;
}

$helplang = findhelp("people_help.php");

$revstar = checkReview("I");

tng_adminheader(_('Edit Existing Person'), $flags);
$photo = showSmallPhoto($personID, $namestr, 1, 0, "I", $row['sex']);

include_once "eventlib.php";
include_once "eventlib_js.php";
?>
    <script>
        var persfamID = "<?php echo $personID; ?>";
        var allow_cites = true;
        var allow_notes = true;

        function toggleAll(display) {
            toggleSection('names', 'plus0', display);
            toggleSection('events', 'plus1', display);
            toggleSection('parents', 'plus2', display);
            toggleSection('spouses', 'plus3', display);
            return false;
        }

        function startSort() {
            if (jQuery('#parents div.sortrow').length > 1)
                jQuery('#parents').sortable({
                    helper: 'clone',
                    axis: 'y',
                    scroll: false,
                    items: '.sortrow',
                    update: function (event, ui) {
                        var parentlist = removePrefixFromArray(jQuery('#parents').sortable('toArray'), 'parents_');

                        var params = {sequence: parentlist.join(','), action: 'parentorder', personID: persfamID, tree: tree};
                        jQuery.ajax({
                            url: 'ajx_updateorder.php',
                            data: params,
                            dataType: 'html'
                        });
                    },
                    create: function () {
                        jQuery(this).height(jQuery(this).height());
                    }
                });
            if (jQuery('#spouses div.sortrow').length > 1)
                jQuery('#spouses').sortable({
                    helper: 'clone',
                    axis: 'y',
                    scroll: false,
                    items: '.sortrow',
                    update: function (event, ui) {
                        var spouselist = removePrefixFromArray(jQuery('#spouses').sortable('toArray'), 'spouses_');

                        var params = {sequence: spouselist.join(','), action: 'spouseorder', tree: tree, spouseorder: '<?php echo $spouseorder; ?>'};
                        jQuery.ajax({
                            url: 'ajx_updateorder.php',
                            data: params,
                            dataType: 'html'
                        });
                    },
                    create: function () {
                        jQuery(this).height(jQuery(this).height());
                    }
                });
        }

        function unlinkSpouse(familyID) {
            if (confirm("<?php echo _('Are you sure you want to unlink this individual as a spouse in this family?'); ?>")) {
                var params = {action: 'spouseunlink', familyID: familyID, personID: persfamID, tree: tree};
                jQuery.ajax({
                    url: 'ajx_updateorder.php',
                    data: params,
                    dataType: 'html',
                    success: function (req) {
                        jQuery('#spouses_' + familyID).fadeOut(300, function () {
                            jQuery('#spouses_' + familyID).remove();
                            jQuery('#marrcount').html(parseInt(jQuery('#marrcount').html()) - 1);
                        });
                    }
                });
            }
            return false;
        }

        function unlinkChild(familyID) {
            if (confirm("<?php echo _('Are you sure you want to unlink this individual as a child in this family?'); ?>")) {
                var params = {action: 'parentunlink', familyID: familyID, personID: persfamID, tree: tree};
                jQuery.ajax({
                    url: 'ajx_updateorder.php',
                    data: params,
                    dataType: 'html',
                    success: function (req) {
                        jQuery('#parents_' + familyID).fadeOut(300, function () {
                            jQuery('#parents_' + familyID).remove();
                            jQuery('#parentcount').html(parseInt(jQuery('#parentcount').html()) - 1);
                        });
                    }
                });
            }
            return false;
        }

        function addNewFamily(radioval, args) {
            if (confirm("<?php echo _('Save changes first?'); ?>")) {
                jQuery('#radio' + radioval).attr('checked', true);
                document.form1.submit();
            }
            return false;
        }

        function addNewMedia() {
            if (confirm("<?php echo _('Save changes first?'); ?>")) {
                jQuery('#newmedia').val(1);
                document.form1.submit();
            } else
                top.frames['main'].location = 'admin_newmedia.php?personID=<?php echo $personID; ?>&tree=<?php echo $tree; ?>&linktype=I';
            return false;
        }

        function editWarning() {
            alert("<?php echo _('Your lock on this record is about to expire. Save your changes now to prevent them from being overwritten by another user.'); ?>");
        }

        <?php if (!$editconflict && $warnsecs >= 0) { ?>
        setTimeout(editWarning, <?php echo $warnsecs; ?>);
        <?php } ?>
    </script>

<?php
echo "</head>\n";
echo tng_adminlayout(" onload='startSort()'");
$peopletabs[0] = [1, "admin_people.php", _('Search'), "findperson"];
$peopletabs[1] = [$allow_add, "admin_newperson.php", _('Add New'), "addperson"];
$peopletabs[2] = [$allow_edit, "admin_findreview.php?type=I", _('Review') . $revstar, "review"];
$peopletabs[3] = [$allow_edit && $allow_delete, "admin_merge.php", _('Merge'), "merge"];
$peopletabs[4] = [$allow_edit, "admin_editperson.php?personID=$personID&tree=$tree", _('Edit'), "edit"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/people_help.php#edit');\" class='lightlink'>" . _('Help for this area') . "</a>";
$innermenu .= " &nbsp;|&nbsp; <a href='#' class='lightlink' onClick=\"return toggleAll('on');\">" . _('Expand all') . "</a> &nbsp;|&nbsp; <a href='#' class='lightlink' onClick=\"return toggleAll('off');\">" . _('Collapse all') . "</a>";
$innermenu .= " &nbsp;|&nbsp; <a href=\"getperson.php?personID=$personID&amp;tree=$tree\" target='_blank' class='lightlink'>" . _('Test') . "</a>";
if ($allow_add && (!$assignedtree || $assignedtree == $tree)) {
    $innermenu .= " &nbsp;|&nbsp; <a href='#' onclick=\"return addNewMedia();\" class='lightlink'>" . _('Add Media') . "</a>";
}
$menu = doMenu($peopletabs, "edit", $innermenu);
if (!isset($message)) $message = "";
echo displayHeadline(_('People') . " &gt;&gt; " . _('Edit Existing Person'), "img/people_icon.gif", $menu, $message);
?>

    <form action="admin_updateperson.php" method="post" name="form1" id="form1">
        <table class="lightback normal w-full" cellpadding="10" cellspacing="2">
            <tr class="databack"> <!-- Form content Header -->
                <td class="tngshadow">
                    <table cellpadding="0" cellspacing="0" class="normal">
                        <tr>
                            <td class='align-top'>
                                <div id="thumbholder" style="margin-right:5px;<?php if (!$photo) {
                                    echo "display:none";
                                } ?>"><?php echo $photo; ?></div>
                            </td>
                            <td>
                                <span class="plainheader"><?php echo "$namestr ($personID)</span><br>" . getYears($row); ?></span>
                                <div class="topbuffer bottombuffer smallest">
                                    <?php
                                    if ($editconflict) {
                                        echo "<br><p>" . _('Another user is already editing this record. Please try again later.') . "</p>\n";
                                        echo "<p class='normal'><strong><a href='admin_editperson.php?personID=$personID&tree=$tree' class='rounded-lg whitebuttonlink tngshadow'>" . _('Try again') . "</a></strong></p>\n";
                                    } else {
                                        $notesicon = $gotnotes['general'] ? "admin-note-on-icon" : "admin-note-off-icon";
                                        $citesicon = $gotcites['general'] ? "admin-cite-on-icon" : "admin-cite-off-icon";
                                        $associcon = $gotassoc ? "admin-asso-on-icon" : "admin-asso-off-icon";
                                        echo "<a href='#' onclick=\"document.form1.submit();\" class=\"smallicon si-plus admin-save-icon\">" . _('Save') . "</a>\n";
                                        echo "<a href='#' onclick=\"return showNotes('', '$personID');\" id='notesicon' class=\"smallicon si-plus $notesicon\">" . _('Notes') . "</a>\n";
                                        echo "<a href='#' onclick=\"return showCitations('', '$personID');\" id='citesicon' class=\"smallicon si-plus $citesicon\">" . _('Sources') . "</a>\n";
                                        echo "<a href='#' onclick=\"return showAssociations('$personID','I');\" id=\"associcon\" class=\"smallicon si-plus $associcon\">" . _('Associations') . "</a>\n";
                                    }
                                    ?>
                                    <br><br>
                                </div>
                                <span class="smallest"><?php echo _('Last Modified Date') . ": {$row['changedate']} ({$row['changedby']})"; ?></span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <?php if (!$editconflict) { ?>
            <tr class="databack"> <!-- Collapsible section - Name -->
                <td class="tngshadow">
                    <?php echo displayToggle("plus0", 1, "names", _('Name'), ""); ?>
                    <div id="names">
                        <table class="normal topmarginsmall">
                            <tr>
                                <td><?php echo _('First/Given Name(s)'); ?></td>
                                <?php if ($lnprefixes) {
                                    echo "<td>" . _('Surname Prefix') . "</td>\n";
                                } ?>
                                <td><?php echo _('Last/Surname'); ?></td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" value="<?php echo $row['firstname']; ?>" name="firstname" size="35">
                                </td>
                                <?php if ($lnprefixes) {
                                    echo "<td><input type='text' value=\"{$row['lnprefix']}\" name='lnprefix' style=\"width: 80px;\"></td>\n";
                                }
                                ?>
                                <td>
                                    <input type="text" value="<?php echo $row['lastname']; ?>" name="lastname" size="35">
                                </td>
                                <td>
                                    <?php
                                    $notesicon = $gotnotes['NAME'] ? "admin-note-on-icon" : "admin-note-off-icon";
                                    $citesicon = $gotcites['NAME'] ? "admin-cite-on-icon" : "admin-cite-off-icon";
                                    echo "<a href='#' onclick=\"return showNotes('NAME', '$personID');\" title=\"" . _('Notes') . "\" id=\"notesiconNAME\" class=\"smallicon $notesicon\"></a>\n";
                                    echo "<a href='#' onclick=\"return showCitations('NAME', '$personID');\" title=\"" . _('Sources') . "\" id=\"citesiconNAME\" class=\"smallicon $citesicon\"></a>\n";
                                    ?>
                                </td>
                            </tr>
                        </table>
                        <table class="normal topmarginsmall">
                            <tr>
                                <td><?php echo _('Gender'); ?></td>
                                <td><?php echo _('Nickname'); ?></td>
                                <td><?php echo _('Title'); ?></td>
                                <td><?php echo _('Prefix'); ?></td>
                                <td><?php echo _('Suffix'); ?></td>
                                <td><?php echo _('Name Order'); ?></td>
                            </tr>
                            <tr>
                                <td>
                                    <select name="sex" onchange="if(this.value != 'U') {jQuery('#addnewspouse').show();} else {jQuery('#addnewspouse').hide();}">
                                        <option value="U" <?php if ($row['sex'] == "U") {
                                            echo "selected";
                                        } ?>><?php echo _('Unknown'); ?></option>
                                        <option value="M" <?php if ($row['sex'] == "M") {
                                            echo "selected";
                                        } ?>><?php echo _('Male'); ?></option>
                                        <option value="F" <?php if ($row['sex'] == "F") {
                                            echo "selected";
                                        } ?>><?php echo _('Female'); ?></option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" value="<?php echo $row['nickname']; ?>" name="nickname" class="w-24">
                                </td>
                                <td>
                                    <input type="text" value="<?php echo $row['title']; ?>" name="title" class="w-24">
                                </td>
                                <td>
                                    <input type="text" value="<?php echo $row['prefix']; ?>" name="prefix" class="w-24">
                                </td>
                                <td>
                                    <input type="text" value="<?php echo $row['suffix']; ?>" name="suffix" class="w-24">
                                </td>
                                <td>
                                    <select name="pnameorder">
                                        <option value="0"><?php echo _('Default'); ?></option>
                                        <option value="1" <?php if ($row['nameorder'] == "1") {
                                            echo "selected";
                                        } ?>><?php echo _('First name first'); ?></option>
                                        <option value="2" <?php if ($row['nameorder'] == "2") {
                                            echo "selected";
                                        } ?>><?php echo _('Surname first (without commas)'); ?></option>
                                        <option value="3" <?php if ($row['nameorder'] == "3") {
                                            echo "selected";
                                        } ?>><?php echo _('Surname first (with commas)'); ?></option>
                                    </select>
                                </td>
                            </tr>
                        </table>

                        <table class="normal topbuffer">
                            <tr>
                                <td class="whitespace-no-wrap">
                                    <input type="checkbox" name="living" value="1"<?php if ($row['living']) {
                                        echo " checked";
                                    } ?>> <?php echo _('Living'); ?>&nbsp;&nbsp;
                                    <input type="checkbox" name="private" value="1"<?php if ($row['private']) {
                                        echo " checked=\"$checked\"";
                                    } ?>> <?php echo _('Private'); ?>
                                </td>
                                <td class="spaceonleft">
                                    <?php echo _('Tree') . ": " . $treerow['treename']; ?>
                                    <a href="#" onclick="return openChangeTree('person', '<?php echo $tree; ?>', '<?php echo $personID; ?>');">
                                        <?php echo "(" . _('Edit') . "$iconChevronDown)"; ?>
                                    </a>
                                </td>
                                <td class="spaceonleft"><?php echo _('Branch') . ": "; ?>
                                    <?php echo getBranchesSelectionHtml($branches_table, $tree, $row, $assignedbranch); ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <tr class="databack">
                <td class="tngshadow">
                    <?php echo displayToggle("plus1", 1, "events", _('Events'), ""); ?>

                    <div id="events">
                        <p class="normal topmarginsmall"><?php echo _('<strong>Note:</strong> When entering dates, please use the standard genealogical format DD MMM YYYY. For example, 10 Apr 2004.'); ?></p>
                        <table class="normal" id="events_table">
                            <tr>
                                <td>&nbsp;</td>
                                <td><?php echo _('Date'); ?></td>
                                <td><?php echo _('Place'); ?></td>
                                <td colspan="4">&nbsp;</td>
                            </tr>
                            <?php
                            echo showEventRow('birthdate', 'birthplace', 'BIRT', $personID);
                            if (!$tngconfig['hidechr']) {
                                echo showEventRow('altbirthdate', 'altbirthplace', 'CHR', $personID);
                            }
                            echo showEventRow('deathdate', 'deathplace', 'DEAT', $personID);
                            echo showEventRow('burialdate', 'burialplace', 'BURI', $personID);
                            $checked = $row['burialtype'] == 1 ? " checked" : "";
                            echo "<tr>";
                            echo "<td></td>";
                            echo "<td colspan='3'><input type='checkbox' name='burialtype' id='burialtype' value='1'{$checked}> <label for='burialtype'>" . _('Cremated') . "</label></td>";
                            echo "</tr>\n";
                            if ($rights['lds']) {
                                echo showEventRow('baptdate', 'baptplace', 'BAPL', $personID);
                                echo showEventRow('confdate', 'confplace', 'CONL', $personID);
                                echo showEventRow('initdate', 'initplace', 'INIT', $personID);
                                echo showEventRow('endldate', 'endlplace', 'ENDL', $personID);
                            }
                            ?>
                            <tr>
                                <td colspan="2">
                                    <br>
                                    <p class="subhead font-medium">
                                        <?php echo "" . _('Other Events') . ": <input type='button' value=\" " . _('Add New') . " \" onclick=\"newEvent('I', '$personID', '$tree');\">\n"; ?>
                                    </p>
                                </td>
                            </tr>
                            <?php showCustEvents($personID); ?>
                        </table>
                    </div>
                </td>
            </tr>
            <?php
            $query = "SELECT personID, familyID, sealdate, sealplace, frel, mrel FROM $children_table WHERE personID = \"{$personID}\" AND gedcom = '$tree' ORDER BY parentorder";
            $parents = tng_query($query);
            $parentcount = tng_num_rows($parents);
            ?>
            <tr class="databack"> <!-- Collapsible section - Parents -->
                <td class="tngshadow">
                    <?php
                    $newparents = $allow_add && (!$assignedtree || $assignedtree == $tree) ? "&nbsp; <input type='button' value=\"  " . _('Add New') . "  \" onClick=\"return addNewFamily('child','child=$personID&tree=$tree&cw=$cw');\">\n" : "";
                    echo displayToggle("plus2", 1, "parents", _('Parents') . " (<span id=\"parentcount\">$parentcount</span>)", "", $newparents);
                    ?>

                    <div id="parents"><br>
                        <?php
                        while ($parent = tng_fetch_assoc($parents)) {
                        echo "<div class='sortrow' id=\"parents_{$parent['familyID']}\" style=\"clear:both;\" onmouseover=\"jQuery('#unlinkp_{$parent['familyID']}').show();\" onmouseout=\"jQuery('#unlinkp_{$parent['familyID']}').hide();\">\n";
                        echo "<table class='w-full' cellpadding='5' cellspacing='1'>";
                        echo "<tr>\n";
                        if ($parentcount > 1) {
                            echo "<td class='dragarea rounded-lg normal'>";
                            echo "<img src='img/admArrowUp.gif' alt='' class='inline-block'>" . _('Drag') . "<img src='img/admArrowDown.gif' alt='' class='inline-block'>\n";
                            echo "</td>\n";
                        }
                        echo "<td class='lightback normal'>\n";
                        echo "<div id=\"unlinkp_{$parent['familyID']}\" style=\"float:right;display:none;\"><a href='#' onclick=\"return unlinkChild('{$parent['familyID']}');\">" . _('Unlink current individual') . " ($personID) " . _('as child') . "</a></div>\n";
                        echo "<table class='normal'>";
                        echo "<tr>";
                        echo "<td class='align-top'><strong>" . _('Family') . ":</strong></td>\n";
                        echo "<td class='align-top' colspan='4'>\n";
                        echo "<a href=\"admin_editfamily.php?familyID={$parent['familyID']}&amp;tree=$tree&amp;cw=$cw\">{$parent['familyID']}</a>\n";
                        echo "</td>";
                        echo "</tr>";

                        echo parentRow($parent, "husband", "father");
                        echo parentRow($parent, "wife", "mother");

                        $parent['sealplace'] = preg_replace("/\"/", "&#34;", $parent['sealplace']);
                        if ($rights['lds']) {
                            $citquery = "SELECT citationID FROM $citations_table WHERE persfamID = \"$personID" . "::" . "{$parent['familyID']}\" AND gedcom = '$tree'";
                            $citresult = tng_query($citquery) or die (_('Cannot execute query') . ": $citquery");
                            $citesicon = tng_num_rows($citresult) ? "admin-cite-on-icon" : "admin-cite-off-icon";
                            tng_free_result($citresult);
                            echo "<tr>";
                            echo "<td>&nbsp;</td>";
                            echo "<td>" . _('Date') . "</td>";
                            echo "<td>" . _('Place') . "</td>";
                            echo "<td colspan='2'>&nbsp;</td>";
                            echo "</tr>\n";
                            echo "<tr>\n";
                            echo "<td class='align-top whitespace-no-wrap' style='width:110px;'>" . _('Sealed to Parents (LDS)') . ":</td>\n";
                            echo "<td><input type='text' value=\"" . $parent['sealdate'] . "\" name=\"sealpdate" . $parent['familyID'] . "\" onblur=\"checkDate(this);\" maxlength='50' class='w-32'></td>\n";
                            echo "<td><input type='text' value=\"" . $parent['sealplace'] . "\" name=\"sealpplace" . $parent['familyID'] . "\" id=\"sealpplace" . $parent['familyID'] . "\" class=\"longfield\"></td>\n";
                            echo "<td><a href='#' onclick=\"return openFindPlaceForm('sealpplace" . $parent['familyID'] . "',1);\" title=\"" . _('Find...') . "\" class='smallicon admin-temp-icon'></a></td>\n";
                            echo "<td><a href='#' onclick=\"return showCitations('SLGC','$personID::" . $parent['familyID'] . "');\" title=\"" . _('Sources') . "\" id=\"citesiconSLGC$personID::" . $parent['familyID'] . "\" class='smallicon $citesicon'></a></td>\n";
                            echo "</tr>\n";
                            echo "</table>\n";
                        } else {
                        ?>
        </table>
        <input type="hidden" name="sealpdate<?php echo $parent['familyID']; ?>" value="<?php echo $parent['sealdate']; ?>">
        <input type="hidden" name="sealpplace<?php echo $parent['familyID']; ?>" value="<?php echo $parent['sealplace']; ?>">
        <?php }
        echo "</td>";
        echo "</tr>";
        echo "</table>";
        echo "</div>";
        }
        tng_free_result($parents);
        ?>
        </div>
        </td>
        </tr>
        <?php
        $sortclause = $self ? " ORDER BY $spouseorder" : "";
        $query = "SELECT husband, wife, familyID, marrdate FROM $families_table WHERE ($families_table.husband = \"$personID\" OR $families_table.wife = \"$personID\") AND gedcom = '$tree'$sortclause";
        $marriages = tng_query($query);
        $marrcount = tng_num_rows($marriages);

        ?>
        <tr class="databack"> <!-- Collapsible section - Spouses -->
            <td class="tngshadow">
                <?php
                $display = !$row['sex'] || $row['sex'] == "U" ? " style='display: none;'" : "";
                $newspouse = $allow_add && (!$assignedtree || $assignedtree == $tree) ? "&nbsp; <input type='button'$display id=\"addnewspouse\" value=\"  " . _('Add New') . "  \" onClick=\"return addNewFamily('$self','$self=$personID&tree=$tree&cw=$cw');\">\n" : "";
                echo displayToggle("plus3", 1, "spouses", _('Spouses / Partners') . " (<span id=\"marrcount\">$marrcount</span>)", "", $newspouse);
                ?>

                <div id="spouses"><br>
                    <?php
                    if ($marriages && tng_num_rows($marriages)) {
                    while ($marriagerow = tng_fetch_assoc($marriages)) {
                    if ($personID == $marriagerow['husband']) {
                        $self = "husband";
                        $spouse = "wife";
                    } else {
                        if ($personID == $marriagerow['wife']) {
                            $self = "wife";
                            $spouse = "husband";
                        }
                    }
                    echo "<div class='sortrow' id=\"spouses_{$marriagerow['familyID']}\" style=\"clear:both;\" onmouseover=\"jQuery('#unlinks_{$marriagerow['familyID']}').show();\" onmouseout=\"jQuery('#unlinks_{$marriagerow['familyID']}').hide();\">\n";
                    echo "<table class='w-full' cellpadding='5' cellspacing='1'>";
                    echo "<tr>\n";
                    if ($marrcount > 1) {
                        echo "<td class='dragarea rounded-lg normal'>";
                        echo "<img src='img/admArrowUp.gif' alt='' class='inline-block'>" . _('Drag') . "<img src='img/admArrowDown.gif' alt='' class='inline-block'>\n";
                        echo "</td>\n";
                    }
                    echo "<td class='lightback normal'>\n";
                    echo "<table class='normal w-full'>";
                    echo "<tr>";
                    echo "<td class='align-top'><strong>" . _('Family') . ":</strong></td>\n";
                    echo "<td class='align-top' width=\"94%\">\n";
                    echo "<div id=\"unlinks_{$marriagerow['familyID']}\" style=\"float:right;display:none;\">";
                    echo "<a href='#' onclick=\"return unlinkSpouse('{$marriagerow['familyID']}');\">" . _('Unlink current individual') . " ($personID) " . _('as spouse') . "</a>";
                    echo "</div>\n";
                    echo "<a href=\"admin_editfamily.php?familyID={$marriagerow['familyID']}&amp;tree=$tree&amp;cw=$cw\">{$marriagerow['familyID']}</a>\n";
                    echo "</td>";
                    echo "</tr>";
                    if ($marriagerow[$spouse]) {
                        $query = "SELECT personID, lastname, lnprefix, firstname, birthdate, birthplace, altbirthdate, altbirthplace, deathdate, burialdate, prefix, suffix, nameorder, living, private FROM $people_table WHERE personID = \"{$marriagerow[$spouse]}\" AND gedcom = '$tree'";
                        $spouseresult = tng_query($query);
                        $spouserow = tng_fetch_assoc($spouseresult);

                        list($spouserow, $birthinfo) = getVitalInformation($spouserow, $righttree);
                    } else {
                        $spouserow = $birthinfo = "";
                    }
                    ?>
        <tr>
            <td class='align-top'><span class="normal"><?php echo _('Spouse'); ?>:</span></td>
            <td class='align-top'><span class="normal"><?php if (isset($spouserow['personID']) && $spouserow['personID']) {
                        echo "<a href=\"admin_editperson.php?personID={$spouserow['personID']}&amp;tree=$tree&amp;cw=$cw\">" . getName($spouserow) . " - {$spouserow['personID']}</a>$birthinfo";
                    } ?></span></td>
        </tr>
    <?php if (!empty($marriagerow['marrdate']) || !empty($marriagerow['marrplace'])) { ?>
        <tr>
            <td class='align-top'><span class="normal"><?php echo _('Married'); ?>:</span></td>
            <td class='align-top'><span class="normal"><?php echo displayDate($marriagerow['marrdate']); ?></span></td>
        </tr>
        <?php
    }

    $query = "SELECT people.personID AS pID, firstname, lnprefix, lastname, birthdate, birthplace, altbirthdate, altbirthplace, deathdate, burialdate, haskids, living, private, branch, prefix, suffix, nameorder, frel, mrel ";
    $query .= "FROM ($people_table people, $children_table children) ";
    $query .= "WHERE people.personID = children.personID AND children.familyID = \"{$marriagerow['familyID']}\" AND people.gedcom = '$tree' AND children.gedcom = '$tree' ";
    $query .= "ORDER BY ordernum";
    $children = tng_query($query);

    if ($children && tng_num_rows($children)) {
        ?>
        <tr>
            <td class='align-top'><span class="normal"><?php echo _('Children'); ?>:</span></td>
            <td class='align-top'>
                <?php
                $kidcount = 1;
                echo "<table cellpadding = '0' cellspacing = '0'>\n";
                while ($child = tng_fetch_assoc($children)) {
                    $ifkids = $child['haskids'] ? "+" : "&nbsp;";
                    $crights = determineLivingPrivateRights($child);
                    $child['allow_living'] = $crights['living'];
                    $child['allow_private'] = $crights['private'];
                    if ($child['firstname'] || $child['lastname']) {
                        echo "<tr>";
                        echo "<td>$ifkids</td>";
                        echo "<td>";
                        echo "<span class='normal'>$kidcount. ";
                        if ($crights['both']) {
                            if ($rightbranch) {
                                echo "<a href=\"admin_editperson.php?personID={$child['pID']}&amp;tree=$tree&amp;cw=$cw\">" . getName($child) . " - {$child['pID']}</a>";
                            } else {
                                echo getName($child) . " - " . $child['pID'];
                            }
                            list($birthstring, $deathstring) = getVitalsText($child);

                            if ($birthstring || $deathstring) {
                                echo " ($birthstring$deathstring)";
                            }
                            if ($childrel && $child[$childrel]) {
                                echo " [" . $admtext[$child[$childrel]] . "]";
                            }
                        } else {
                            echo ($child['private'] ? _('Private') : _('Living')) . " - " . $child['pID'];
                        }
                        echo "</span>";
                        echo "</td>";
                        echo "</tr>\n";
                    }
                    $kidcount++;
                }
                echo "</table>\n";
                ?>
            </td>
        </tr>
        <?php
        tng_free_result($children);
    }
    ?>
        </table>
        </td>
        </table>
        </div>
    <?php
    }
    tng_free_result($marriages);
    }
    ?>
        </div>
        </td>
        </tr>
        <tr class="databack"> <!-- Form content footer -->
            <td class="tngshadow">
                <p class="normal">
                    <?php
                    echo _('On save') . ":<br>";
                    if ($allow_add && (!$assignedtree || $assignedtree == $tree)) {
                        echo "<input type='radio' name=\"newfamily\" id=\"radiochild\" value=\"child\">" . _('Go to new family with current individual') . " ($personID) " . _('as child') . "<br>\n";
                        if ($row['sex']) {
                            echo "<input type='radio' name=\"newfamily\" id=\"radio$self\" value=\"$self\">" . _('Go to new family with current individual') . " ($personID) $selfdisplay<br>\n";
                        }
                    }
                    echo "<input type='radio' name=\"newfamily\" value='return'> " . _('Return to this page') . "<br>\n";
                    if ($cw) {
                        echo "<input type='radio' name=\"newfamily\" value=\"close\" checked> " . _('Close this window') . "\n";
                    } else {
                        echo "<input type='radio' name=\"newfamily\" value=\"none\" checked> " . _('Return to menu') . "\n";
                    }
                    ?>
                </p>
                <input type="hidden" name="media" id="newmedia" value="">
                <input type="hidden" name="tree" value="<?php echo $tree; ?>">
                <input type="hidden" name="added" value="<?php echo $added; ?>">
                <input type="hidden" name="personID" value="<?php echo "$personID"; ?>">
                <input type="submit" name="submit2" class="btn" accesskey="s" value="<?php echo _('Save'); ?>">
                <?php if (!$lnprefixes) {
                    echo "<input type='hidden' name='lnprefix' value=\"{$row['lnprefix']}\">";
                } ?>
                <?php defineLdsHiddenFields($rights['lds'], $row); ?>
                <input type="hidden" value="<?php echo "$cw"; ?>" name="cw">
            </td>
        </tr>
        <?php } ?> <!-- end of the editconflict conditional -->
        </table>
    </form>

<?php echo tng_adminfooter(); ?>
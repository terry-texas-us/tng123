<?php
include "begin.php";
include "adminlib.php";
require_once "./admin/associations.php";
require_once "./admin/citations.php";
require_once "./admin/events.php";
require_once "./admin/notelinks.php";
require_once "./admin/trees.php";
require_once "./public/families.php";
require_once "./public/people.php";

include "checklogin.php";
include "version.php";

$row = fetchAndCleanFamilyRow($familyID, $families_table, $tree);

if ((!$allow_edit && (!$allow_add || !$added)) || ($assignedtree && $assignedtree != $tree) || !checkbranch($row['branch'])) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$editconflict = determineConflict($row, $families_table);
if ($tngconfig['edit_timeout'] === "") {
    $tngconfig['edit_timeout'] = 15;
}
$warnsecs = (intval($tngconfig['edit_timeout']) - 2) * 60 * 1000;

function getBirth($row) {
    global $admtext;

    $birthstring = $deathstring = "";
    if ($row['birthdate']) {
        $birthstring = "" . _('b.') . " " . displayDate($row['birthdate']);
    } else {
        if ($row['altbirthdate']) {
            $birthstring = "" . _('c.') . " " . displayDate($row['altbirthdate']);
        }
    }
    if ($row['deathdate']) {
        $deathstring = _('d.') . " " . displayDate($row['deathdate']);
    } else {
        if ($row['burialdate']) {
            $deathstring = _('bur.') . " " . displayDate($row['burialdate']);
        }
    }
    if ($birthstring && $deathstring) {
        $deathstring = ", " . $deathstring;
    }
    if ($birthstring || $deathstring) {
        $birthstring = " ($birthstring$deathstring)";
    }
    return $birthstring;
}

$righttree = checktree($tree);
$rightbranch = $righttree ? checkbranch($row['branch']) : false;
$rights = determineLivingPrivateRights($row, $righttree, $rightbranch);
$row['allow_living'] = $rights['living'];
$row['allow_private'] = $rights['private'];

$namestr = getFamilyName($row) . " ($familyID)";

$treerow = getTree($trees_table, $tree);

$gotnotes = checkForNoteLinks($familyID, $tree);
$gotcites = checkForCitations($familyID, $tree);
$gotassoc = checkForAssociations($familyID, $tree);
$gotmore = checkForEvents($familyID, $tree);

$query = "SELECT people.personID AS pID, firstname, lastname, lnprefix, prefix, suffix, nameorder, birthdate, altbirthdate, deathdate, burialdate, living, private, branch, people.gedcom ";
$query .= "FROM $people_table people, $children_table children ";
$query .= "WHERE people.personID = children.personID AND children.familyID = '$familyID' AND people.gedcom = '$tree' AND children.gedcom = '$tree' ";
$query .= "ORDER BY ordernum";
$children = tng_query($query);

$kidcount = tng_num_rows($children);

$helplang = findhelp("families_help.php");

$revstar = checkReview("F");

tng_adminheader(_('Edit Existing Family'), $flags);
$photo = showSmallPhoto($familyID, $namestr, 1, 0, "F");
include_once "eventlib.php";
include_once "eventlib_js.php";
?>
<script>
    var persfamID = "<?php echo $familyID; ?>";
    var childcount = <?php echo $kidcount; ?>;
    var allow_cites = true;
    var allow_notes = true;

    function toggleAll(display) {
        toggleSection('spouses', 'plus0', display);
        toggleSection('events', 'plus1', display);
        toggleSection('children', 'plus2', display);
        return false;
    }

    function startSort() {
        jQuery('#childrenlist').sortable({
            helper: 'clone',
            axis: 'y',
            scroll: false,
            items: '.sortrow',
            update: updateChildrenOrder
        });
    }

    jQuery(document).ready(startSort);

    function updateChildrenOrder(id) {
        var childrenlist = removePrefixFromArray(jQuery('#childrenlist').sortable('toArray'), 'child_');
        var params = {sequence: childrenlist.join(','), action: 'childorder', familyID: persfamID, tree: tree};
        jQuery.ajax({
            url: 'ajx_updateorder.php',
            data: params,
            dataType: 'html'
        });
    }

    function unlinkChild(personID, action) {
        var confmsg = action === "child_delete" ? "<?php echo _('Are you sure you want to delete this person? The individual will be entirely deleted from your tree.'); ?>" : "<?php echo _('Are you sure you want to remove this child from this family? The individual will not be deleted from the database.'); ?>";
        if (confirm(confmsg)) {
            var params = {personID: personID, familyID: persfamID, desc: tree, t: action};
            jQuery.ajax({
                url: 'ajx_delete.php',
                data: params,
                success: function (req) {
                    jQuery('#child_' + personID).fadeOut(300, function () {
                        jQuery('#child_' + personID).remove();
                        childcount -= 1;
                        jQuery('#childcount').html(childcount);
                    });
                }
            });
        }
        return false
    }

    function EditChild(id) {
        window.open('admin_editperson.php?personID=' + id + '&tree=<?php echo $tree; ?>' + '&cw=1');
    }

    function EditSpouse(field) {
        if (field.value.length)
            window.open('admin_editperson.php?personID=' + field.value + '&tree=<?php echo $tree; ?>' + '&cw=1');
    }

    function RemoveSpouse(spouse, spousedisplay) {
        spouse.value = "";
        spousedisplay.value = "";
    }

    var nplitbox;
    var activeidbox = null;
    var activenamebox = null;

    function openCreatePersonForm(idfield, namefield, type, gender, father) {
        activeidbox = idfield;
        activenamebox = namefield;
        nplitbox = new LITBox('admin_newperson2.php?tree=' + tree + '&type=' + type + '&familyID=' + persfamID + '&father=' + father + '&gender=' + gender, {
            width: 620,
            height: 600,
            doneLoading: function () {
                generateID('person', document.npform.personID, document.form1.tree1);
                jQuery('#firstname').focus();
            }
        });
        return false;
    }

    function saveNewPerson(form) {
        form.personID.value = TrimString(form.personID.value);
        var personID = form.personID.value;
        if (personID.length == 0) {
            alert("<?php echo _('Please enter a Person ID'); ?>");
        } else {
            var params = jQuery(form).serialize();
            params += '&order=' + (childcount + 1);
            jQuery.ajax({
                url: 'admin_addperson2.php',
                data: params,
                type: 'post',
                dataType: 'html',
                success: function (req) {
                    if (req.indexOf('error') >= 0) {
                        var vars = eval('(' + req + ')');
                        jQuery('#errormsg').html(vars.error);
                        jQuery('#errormsg').show();
                    } else {
                        nplitbox.remove();
                        if (form.type.value == "child") {
                            jQuery('#childrenlist').append(req);
                            jQuery('#child_' + personID).fadeIn(400);
                            childcount += 1;
                            jQuery('#childcount').html(childcount);
                            startSort();
                        } else if (form.type.value == "spouse") {
                            var vars = eval('(' + req + ')');
                            jQuery('#' + activenamebox).val(vars.name + ' - ' + vars.id);
                            jQuery('#' + activenamebox).effect('highlight', {}, 400);
                            jQuery('#' + activeidbox).val(vars.id);
                        }
                    }
                }
            });
        }
        return false
    }

    function addNewMedia() {
        if (confirm("<?php echo _('Save changes first?'); ?>")) {
            jQuery('#newmedia').val(1);
            document.form1.submit();
        } else
            top.frames['main'].location = 'admin_newmedia.php?personID=<?php echo $familyID; ?>&tree=?php echo $tree; ?>&linktype=F';
        return false;
    }

    function editWarning() {
        alert("<?php echo _('Your lock on this record is about to expire. Save your changes now to prevent them from being overwritten by another user.'); ?>");
    }

    <?php
    if(!$editconflict && $warnsecs >= 0) {
    ?>
    setTimeout(editWarning, <?php echo $warnsecs; ?>);
    <?php } ?>
</script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$familytabs['0'] = [1, "admin_families.php", _('Search'), "findfamily"];
$familytabs['1'] = [$allow_add, "admin_newfamily.php", _('Add New'), "addfamily"];
$familytabs['2'] = [$allow_edit, "admin_findreview.php?type=F", _('Review') . $revstar, "review"];
$familytabs['3'] = [$allow_edit, "admin_editfamily.php?familyID=$familyID&tree=$tree", _('Edit'), "edit"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/families_help.php#edit');\" class='lightlink'>" . _('Help for this area') . "</a>";
$innermenu .= " &nbsp;|&nbsp; <a href='#' class='lightlink' onClick=\"return toggleAll('on');\">" . _('Expand all') . "</a> &nbsp;|&nbsp; <a href='#' class='lightlink' onClick=\"return toggleAll('off');\">" . _('Collapse all') . "</a>";
$innermenu .= " &nbsp;|&nbsp; <a href=\"familygroup.php?familyID=$familyID&amp;tree=$tree\" target='_blank' class='lightlink'>" . _('Test') . "</a>";
if ($allow_add && (!$assignedtree || $assignedtree == $tree)) {
    $innermenu .= " &nbsp;|&nbsp; <a href='#' onclick=\"return addNewMedia();\" class='lightlink'>" . _('Add Media') . "</a>";
}
$menu = doMenu($familytabs, "edit", $innermenu);
echo displayHeadline(_('Families') . " &gt;&gt; " . _('Edit Existing Family'), "img/families_icon.gif", $menu, $message);
?>

    <form action="admin_updatefamily.php" method="post" name="form1" id="form1">
        <table class="lightback">
            <tr class="databack">
            <td class="tngshadow">
                <table cellpadding="0" cellspacing="0" class="normal">
                    <tr>
                        <td class='align-top'>
                            <div id="thumbholder" style="margin-right:5px;<?php if (!$photo) {
                                echo "display:none";
                            } ?>"><?php echo $photo; ?></div>
                        </td>
                        <td>
                            <span class="plainheader"><?php echo $namestr; ?></span><br>
                            <div class="topbuffer bottombuffer smallest">
                                <?php
                                if ($editconflict) {
                                    echo "<br><p>" . _('Another user is already editing this record. Please try again later.') . "</p>\n";
                                    echo "<p class='normal'><strong><a href='admin_editfamily.php?familyID=$familyID&tree=$tree' class='rounded-lg whitebuttonlink tngshadow'>" . _('Try again') . "</a></strong></p>\n";
                                } else {
                                    $notesicon = $gotnotes['general'] ? "admin-note-on-icon" : "admin-note-off-icon";
                                    $citesicon = $gotcites['general'] ? "admin-cite-on-icon" : "admin-cite-off-icon";
                                    $associcon = $gotassoc ? "admin-asso-on-icon" : "admin-asso-off-icon";
                                    echo "<a href='#' onclick=\"document.form1.submit();\" class=\"smallicon si-plus admin-save-icon\">" . _('Save') . "</a>\n";
                                    echo "<a href='#' onclick=\"return showNotes('', '$familyID');\" id='notesicon' class=\"smallicon si-plus $notesicon\">" . _('Notes') . "</a>\n";
                                    echo "<a href='#' onclick=\"return showCitations('', '$familyID');\" id='citesicon' class=\"smallicon si-plus $citesicon\">" . _('Sources') . "</a>\n";
                                    echo "<a href='#' onclick=\"return showAssociations('$familyID','F');\" id=\"associcon\" class=\"smallicon si-plus $associcon\">" . _('Associations') . "</a>\n";
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
                <tr class="databack">
                    <td class="tngshadow">
                        <?php echo displayToggle("plus0", 1, "spouses", _('Spouses / Partners'), ""); ?>

                        <div id="spouses">
                            <table class="normal topmarginsmall">
                                <?php
                                if ($row['husband']) {
                                    $query = "SELECT lastname, lnprefix, firstname, prefix, suffix, nameorder, birthdate, altbirthdate, deathdate, burialdate FROM $people_table WHERE personID = \"{$row['husband']}\" AND gedcom = '$tree'";
                                    $spouseresult = tng_query($query);
                                    $spouserow = tng_fetch_assoc($spouseresult);
                                    tng_free_result($spouseresult);

                                    $srights = determineLivingPrivateRights($spouserow);
                                    $spouserow['allow_living'] = $srights['living'];
                                    $spouserow['allow_private'] = $srights['private'];

                                    $husbstr = getName($spouserow) . getBirth($spouserow) . " - " . $row['husband'];
                                    $husbstr = preg_replace("/\"/", "&#34;", $husbstr);
                                }
                                if (!isset($husbstr)) $husbstr = _('Click Find or Create =>');
                                ?>
                                <tr>
                                    <td><span class="normal"><?php echo _('Father'); ?>:</span></td>
                                    <td>
                                        <input type="text" readonly="readonly" name="husbnameplusid" id="husbnameplusid" size="50" class="verylongfield" value="<?php echo "$husbstr"; ?>">
                                        <input
                                            type="hidden" name="husband" id="husband"
                                            value="<?php echo $row['husband']; ?>">
                                        <input type="button" value="<?php echo _('Find...'); ?>"
                                            onclick="return findItem('I','husband','husbnameplusid','<?php echo $tree; ?>','<?php echo $assignedbranch; ?>');">
                                        <input type="button" value="<?php echo _('Create...'); ?>" onclick="return openCreatePersonForm('husband','husbnameplusid','spouse','M');">
                                        <input type="button" value="  <?php echo _('Edit'); ?>  " onclick="EditSpouse(document.form1.husband);">
                                        <input type="button" value="<?php echo _('Unlink'); ?>" onclick="RemoveSpouse(document.form1.husband,document.form1.husbnameplusid);">
                                    </td>
                                </tr>
                                <?php
                                if ($row['wife']) {
                                    $query = "SELECT lastname, lnprefix, firstname, prefix, suffix, nameorder, birthdate, altbirthdate, deathdate, burialdate FROM $people_table WHERE personID = \"{$row['wife']}\" AND gedcom = '$tree'";
                                    $spouseresult = tng_query($query);
                                    $spouserow = tng_fetch_assoc($spouseresult);
                                    tng_free_result($spouseresult);

                                    $srights = determineLivingPrivateRights($spouserow);
                                    $spouserow['allow_living'] = $srights['living'];
                                    $spouserow['allow_private'] = $srights['private'];

                                    $wifestr = getName($spouserow) . getBirth($spouserow) . " - " . $row['wife'];
                                    $wifestr = preg_replace("/\"/", "&#34;", $wifestr);
                                } else {
                                    $spouserow = "";
                                }
                                if (!isset($wifestr)) $wifestr = _('Click Find or Create =>');
                                ?>
                                <tr>
                                    <td><span class="normal"><?php echo _('Mother'); ?>:</span></td>
                                    <td>
                                        <input type="text" readonly readonly="readonly" name="wifenameplusid" id="wifenameplusid" size="50" class="verylongfield"
                                            value="<?php echo "$wifestr"; ?>">
                                        <input type="hidden" name="wife" id="wife"
                                            value="<?php echo $row['wife']; ?>">
                                        <input type="button" value="<?php echo _('Find...'); ?>"
                                            onclick="return findItem('I','wife','wifenameplusid','<?php echo $tree; ?>','<?php echo $assignedbranch; ?>');">
                                        <input type="button" value="<?php echo _('Create...'); ?>" onclick="return openCreatePersonForm('wife','wifenameplusid','spouse','F');">
                                        <input type="button" value="  <?php echo _('Edit'); ?>  " onClick="EditSpouse(document.form1.wife);">
                                        <input type="button" value="<?php echo _('Unlink'); ?>" onClick="RemoveSpouse(document.form1.wife,document.form1.wifenameplusid);">
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
                                    <td class="spaceonleft"><?php echo _('Tree') . ": " . $treerow['treename']; ?></td>
                                    <td class="spaceonleft"><?php echo _('Branch') . ": "; ?>

                                        <?php
                                        $query = "SELECT branch, description FROM $branches_table WHERE gedcom = '$tree' ORDER BY description";
                                        $branchresult = tng_query($query);
                                        $branchlist = explode(",", $row['branch']);

                                        $descriptions = [];
                                        $options = "";
                                        while ($branchrow = tng_fetch_assoc($branchresult)) {
                                            $options .= "	<option value=\"{$branchrow['branch']}\"";
                                        if (in_array($branchrow['branch'], $branchlist)) {
                                            $options .= " selected";
                                            $descriptions[] = $branchrow['description'];
                                        }
                                        $options .= ">{$branchrow['description']}</option>\n";
                                    }
                                        $desclist = count($descriptions) ? implode(', ', $descriptions) : _('No Branch');
                                    echo "<span id=\"branchlist\">$desclist</span>";
                                    if (!$assignedbranch) {
                                    $totbranches = tng_num_rows($branchresult) + 1;
                                    if ($totbranches < 2) $totbranches = 2;
                                        $selectnum = $totbranches < 8 ? $totbranches : 8;
                                        $select = $totbranches >= 8 ? _('(Scroll to see all choices)') . "<br>" : "";
                                        $select .= "<select name=\"branch[]\" id='branch' multiple size=\"$selectnum\" style=\"overflow:auto;\">\n";
                                    $select .= "	<option value=\"\"";
                                    if ($row['branch'] == "") $select .= " selected";
                                        $select .= ">" . _('No Branch') . "</option>\n";
                                        $select .= "$options</select>\n";
                                    echo " <span class='whitespace-no-wrap'>(";
                                        echo "<a href='#' onclick=\"showBranchEdit('branchedit'); quitBranchEdit('branchedit'); return false;\">";
                                        echo _('Edit');
                                        echo buildSvgElement("img/chevron-down.svg", ["class" => "w-3 h-3 ml-2 fill-current inline-block"]);
                                    echo "</a>";
                                    echo " )</span>";
                                    ?>
                                    <div id="branchedit" class="lightback p-1" style="position:absolute;display:none;" onmouseover="clearTimeout(branchtimer);"
                                        onmouseout="closeBranchEdit('branch','branchedit','branchlist');">
                                        <?php
                                        echo $select;
                                        echo "</div>\n";
                                        }
                                        else {
                                            echo "<input type='hidden' name='branch' value=\"{$row['branch']}\">";
                                        }
                                        echo "<input type='hidden' name=\"orgbranch\" value=\"{$row['branch']}\">";
                                        ?>
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
                            <table class="normal">
                                <tr>
                                    <td>&nbsp;</td>
                                    <td><?php echo _('Date'); ?></td>
                                    <td><?php echo _('Place'); ?></td>
                                    <td colspan="4">&nbsp;</td>
                                </tr>
                                <?php echo showEventRow('marrdate', 'marrplace', 'MARR', $familyID); ?>
                                <tr>
                                    <td><?php echo _('Marriage Type'); ?>:</td>
                                    <td colspan="6">
                                        <input type="text" value="<?php echo $row['marrtype']; ?>" name="marrtype" style="width:494px;" maxlength="50">
                                    </td>
                                </tr>
                                <?php
                                if ($rights['lds']) {
                                    echo showEventRow('sealdate', 'sealplace', 'SLGS', $familyID);
                                }
                                echo showEventRow('divdate', 'divplace', 'DIV', $familyID);
                                ?>
                                <tr>
                                    <td colspan="2">
                                        <br/>
                                        <p class="subhead font-medium">
                                            <?php echo "" . _('Other Events') . ": <input type='button' value=\" " . _('Add New') . " \" onclick=\"newEvent('F', '$familyID', '$tree');\">\n"; ?>
                                        </p>
                                    </td>
                                </tr>
                                <?php showCustEvents($familyID); ?>
                            </table>
                        </div>
                    </td>
                </tr>
                <tr class="databack">
                    <td class="tngshadow">
                        <?php echo displayToggle("plus2", 1, "children", _('Children') . " (<span id=\"childcount\">$kidcount</span>)", ""); ?>

                        <div id="children" style="padding-top:10px;">
                            <table id="ordertbl" width="500px" cellpadding="3" cellspacing="1" class="normal">
                                <tr>
                                    <th class="fieldnameback" style="width:55px;"><span class="fieldname"><?php echo _('Sort'); ?></span></th>
                                    <th class="fieldnameback"><span class="fieldname"><?php echo _('Child'); ?></span></th>
                                </tr>
                            </table>
                            <div id="childrenlist">
                                <?php
                                if ($children && $kidcount) {
                                    $hidecode = "class='smaller hide-right'";
                                    while ($child = tng_fetch_assoc($children)) {
                                        $crights = determineLivingPrivateRights($child);
                                        $child['allow_living'] = $crights['living'];
                                        $child['allow_private'] = $crights['private'];
                                    if ($child['firstname'] || $child['lastname']) {
                                        echo "<div class='sortrow' id=\"child_{$child['pID']}\" style=\"width:500px;clear:both\"";
                                        if ($allow_delete) {
                                            echo " onmouseover=\"jQuery('#unlinkc_{$child['pID']}').css('visibility','visible');\" onmouseout=\"jQuery('#unlinkc_{$child['pID']}').css('visibility','hidden');\"";
                                        }
                                        echo ">\n";
                                        echo "<table class='w-full' cellpadding='5' cellspacing='1'><tr>\n";
                                        echo "<td class='dragarea rounded-lg normal'>";
                                        echo "<img src='img/admArrowUp.gif' alt='' class='inline-block'>" . _('Drag') . "<img src='img/admArrowDown.gif' alt='' class='inline-block'>\n";
                                        echo "</td>\n";
                                        echo "<td class='lightback normal childblock'>\n";
                                        if ($allow_delete) {
                                            echo "<div id=\"unlinkc_{$child['pID']}\" $hidecode><a href='#' onclick=\"return unlinkChild('{$child['pID']}','child_unlink');\">" . _('Unlink') . "</a> &nbsp; | &nbsp; <a href='#' onclick=\"return unlinkChild('{$child['pID']}','child_delete');\">" . _('Delete') . "</a></div>";
                                        }
                                        if ($crights['both']) {
                                            list($birthstring, $deathstring) = getVitalsText($child);
                                            echo "<a href='#' onclick=\"EditChild('{$child['pID']}');\">" . getName($child) . "</a> - {$child['pID']}<br>$birthstring$deathstring";
                                        } else {
                                            echo _('Living') . " - " . $child['pID'];
                                        }
                                        echo "</div>\n</td>\n</tr>\n</table>\n</div>\n";
                                    }
                                    }
                                    tng_free_result($children);
                                }
                                ?>
                            </div>

                            <input type="hidden" name="media" id="newmedia" value="">
                            <input type="hidden" name="tree" value="<?php echo $tree; ?>">
                            <p class="normal"><?php echo _('New Children'); ?>:
                                <input type="button" value="<?php echo _('Find...'); ?>" onclick="return findItem('I','children',null,'<?php echo $tree; ?>','<?php echo $assignedbranch; ?>');">
                                <input type="button" value="<?php echo _('Create...'); ?>" onclick="return openCreatePersonForm('','','child','',document.form1.husband.value);">
                                <input type="hidden" name="familyID" value="<?php echo "$familyID"; ?>">
                            </p>
                        </div>
                    </td>
                </tr>
                <tr class="databack">
                    <td class="tngshadow normal">
                        <?php
                        echo _('On save') . ":<br>";
                        echo "<input type='radio' name=\"newfamily\" value='return'> " . _('Return to this page') . "<br>\n";
                        if ($cw) {
                            echo "<input type='radio' name=\"newfamily\" value=\"close\" checked> " . _('Close this window') . "\n";
                        } else {
                            echo "<input type='radio' name=\"newfamily\" value=\"none\" checked> " . _('Return to menu') . "\n";
                        }
                        ?>
                        <br><br>
                        <input type="submit" class="btn" name="submit2" accesskey="s" value="<?php echo _('Save'); ?>">
                        <?php if (!$rights['lds']) { ?>
                            <input type="hidden" value="<?php echo $row['sealdate']; ?>" name="sealdate">
                            <input type="hidden" name="sealsrc" value="<?php echo $row['sealsrc']; ?>">
                            <input type="hidden" value="<?php echo $row['sealplace']; ?>" name="sealplace">
                        <?php } ?>
                        <input type="hidden" value="<?php echo "$cw"; ?>" name="cw">
                        </span>
                    </td>
                </tr>
            <?php } ?>
    </table>
</form>
    </div>

<?php echo tng_adminfooter(); ?>
<?php
include "begin.php";
include "adminlib.php";
require_once "./admin/associations.php";
require_once "./admin/citations.php";
require_once "./admin/events.php";
require_once "./admin/notelinks.php";
require_once "./admin/trees.php";
require_once "./public/people.php";
require_once "./public/families.php";

if (!$familyID) die("no args");


$textpart = "families";
include "$mylanguage/admintext.php";

include "checklogin.php";

initMediaTypes();

function getBirth($row) {
    global $admtext;

    $birthdate = "";
    if ($row['birthdate']) {
        $birthdate = "" . _('b.') . " " . displayDate($row['birthdate']);
    } else {
        if ($row['altbirthdate']) {
            $birthdate = "" . _('c.') . " " . displayDate($row['altbirthdate']);
        }
    }
    if ($birthdate) $birthdate = " ($birthdate)";

    return $birthdate;
}

$row = fetchAndCleanFamilyRow($familyID, $families_table, $tree);

if ((!$allow_edit && (!$allow_add || !$added)) || ($assignedtree && $assignedtree != $tree) || !checkbranch($row['branch'])) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: ajx_login.php?message=" . urlencode($message));
    exit;
}

$editconflict = determineConflict($row, $families_table);

$righttree = checktree($tree);
$rightbranch = $righttree ? checkbranch($row['branch']) : false;
$rights = determineLivingPrivateRights($row, $righttree, $rightbranch);
$row['allow_living'] = $rights['living'];
$row['allow_private'] = $rights['private'];

$namestr = getFamilyName($row);

$treerow = getTree($trees_table, $tree);

$gotnotes = checkForNoteLinks($familyID, $tree);
$gotcites = checkForCitations($familyID, $tree);
$gotassoc = checkForAssociations($familyID, $tree);
$gotmore = checkForEvents($familyID, $tree);

$query = "SELECT $people_table.personID AS pID, firstname, lastname, lnprefix, prefix, suffix, nameorder, birthdate, altbirthdate, living, private, branch FROM $people_table, $children_table WHERE $people_table.personID = $children_table.personID AND $children_table.familyID = '$familyID' AND $people_table.gedcom = '$tree' AND $children_table.gedcom = '$tree' ORDER BY ordernum";
$children = tng_query($query);

$kidcount = tng_num_rows($children);

$helplang = findhelp("families_help.php");

$photo = showSmallPhoto($familyID, $namestr, 1, 0, true);
header("Content-type:text/html; charset=" . $session_charset);

$righttree = checktree($tree);

include_once "eventlib.php";
?>

<form action="" onsubmit="return updateFamily(this,<?php echo $slot; ?>,'admin_updatefamily.php');" method="post" name="famform1" id="famform1">
    <table class="w-full " cellpadding="10" cellspacing="0">
        <tr class="databack">
            <td class="tngbotshadow">
                <div style="float:right;">
                    <input type="submit" name="submit2" accesskey="s" class="bigsave" value="<?php echo _('Save'); ?>">
                </div>
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
                                    echo "<br><p>" . _('Another user is already editing this record. Please try again later.') . "</p>";
                                } else {
                                    $notesicon = $gotnotes['general'] ? "admin-note-on-icon" : "admin-note-off-icon";
                                    $citesicon = $gotcites['general'] ? "admin-cite-on-icon" : "admin-cite-off-icon";
                                    $associcon = $gotassoc ? "admin-asso-on-icon" : "admin-asso-off-icon";
                                    echo "<a href='#' onclick=\"document.form1.submit();\" class=\"smallicon si-plus admin-save-icon\">" . _('Save') . "</a>\n";
                                    echo "<a href='#' onclick=\"return showNotes('', '$familyID');\" class=\"smallicon si-plus $notesicon\">" . _('Notes') . "</a>\n";
                                    echo "<a href='#' onclick=\"return showCitations('', '$familyID');\" class=\"smallicon si-plus $citesicon\">" . _('Sources') . "</a>\n";
                                    echo "<a href='#' onclick=\"return showAssociations('$familyID','F');\" class=\"smallicon si-plus $associcon\">" . _('Associations') . "</a>\n";
                                }
                                ?>
                                <br class="clear-both">
                            </div>
                            <span class="smallest"><?php echo _('Last Modified Date') . ": {$row['changedate']} ({$row['changedby']})"; ?></span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <?php if (!$editconflict) { ?>
            <tr class="databack">
                <td class="tngbotshadow">
                    <?php echo displayToggle("plus0", 1, "spouses", _('Spouses / Partners'), ""); ?>

                    <div id="spouses">
                        <table class="normal topmarginsmall">
                            <?php
                            if ($row['husband']) {
                                $query = "SELECT lastname, lnprefix, firstname, prefix, suffix, nameorder, living, private, branch, birthdate, altbirthdate FROM $people_table WHERE personID = \"{$row['husband']}\" AND gedcom = '$tree'";
                                $spouseresult = tng_query($query);
                                $spouserow = tng_fetch_assoc($spouseresult);
                                tng_free_result($spouseresult);
                            }
                            if ($row['husband']) {
                                $hrights = determineLivingPrivateRights($spouserow, $righttree);
                                $spouserow['allow_living'] = $hrights['living'];
                                $spouserow['allow_private'] = $hrights['private'];
                                $husbstr = getName($spouserow) . getBirth($spouserow) . " - " . $row['husband'];
                            }
                            if (!isset($husbstr)) $husbstr = _('Click Find or Create =>');
                            ?>
                            <tr>
                                <td><span class="normal"><?php echo _('Father'); ?>:</span></td>
                                <td>
                                    <input type="text" readonly="readonly" name="husbnameplusid" id="husbnameplusid" size="40" value="<?php echo "$husbstr"; ?>">
                                    <input type="hidden" name="husband"
                                        id="husband"
                                        value="<?php echo $row['husband']; ?>">
                                    <input type="button" value="<?php echo _('Find...'); ?>"
                                        onclick="return findItem('I','husband','husbnameplusid','<?php echo $tree; ?>','<?php echo $assignedbranch; ?>');">
                                    <input type="button" value="<?php echo _('Add New'); ?>" onclick="return newPerson('M','spouse');">
                                    <input type="button" value="  <?php echo _('Edit'); ?>  " onclick="editPerson(document.famform1.husband.value,0,'M');">
                                    <input type="button" value="<?php echo _('Remove'); ?>" onclick="removeSpouse(document.famform1.husband,document.famform1.husbnameplusid);">
                                </td>
                            </tr>
                            <?php
                            if ($row['wife']) {
                                $query = "SELECT lastname, lnprefix, firstname, prefix, suffix, nameorder, living, private, branch, birthdate, altbirthdate FROM $people_table WHERE personID = \"{$row['wife']}\" AND gedcom = '$tree'";
                                $spouseresult = tng_query($query);
                                $spouserow = tng_fetch_assoc($spouseresult);
                                tng_free_result($spouseresult);
                            } else {
                                $spouserow = "";
                            }
                            if ($row['wife']) {
                                $wrights = determineLivingPrivateRights($spouserow, $righttree);
                                $spouserow['allow_living'] = $wrights['living'];
                                $spouserow['allow_private'] = $wrights['private'];
                                $wifestr = getName($spouserow) . getBirth($spouserow) . " - " . $row['wife'];
                            }
                            if (!isset($wifestr)) $wifestr = _('Click Find or Create =>');
                            ?>
                            <tr>
                                <td><span class="normal"><?php echo _('Mother'); ?>:</span></td>
                                <td>
                                    <input type="text" readonly readonly="readonly" name="wifenameplusid" id="wifenameplusid" size="40" value="<?php echo "$wifestr"; ?>">
                                    <input type="hidden"
                                        name="wife"
                                        id="wife"
                                        value="<?php echo $row['wife']; ?>">
                                    <input type="button" value="<?php echo _('Find...'); ?>"
                                        onclick="return findItem('I','wife','wifenameplusid','<?php echo $tree; ?>','<?php echo $assignedbranch; ?>');">
                                    <input type="button" value="<?php echo _('Create...'); ?>" onclick="return newPerson('F','spouse');">
                                    <input type="button" value="  <?php echo _('Edit'); ?>  " onclick="editPerson(document.famform1.wife.value,0,'F');">
                                    <input type="button" value="<?php echo _('Remove'); ?>" onclick="removeSpouse(document.famform1.wife,document.famform1.wifenameplusid);">
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
                                    $select = $totbranches >= 8 ? "" . _('(Scroll to see all choices)') . "<br>" : "";
                                    $select .= "<select name=\"branch[]\" id='branch' multiple size=\"$selectnum\" style=\"overflow:auto;\">\n";
                                    $select .= "	<option value=\"\"";
                                    if ($row['branch'] == "") $select .= " selected";
                                    $select .= ">" . _('No Branch') . "</option>\n";
                                    $select .= "$options</select>\n";
                                    echo " &nbsp;<span class='whitespace-no-wrap'>(<a href='#' onclick=\"showBranchEdit('branchedit'); quitBranchEdit('branchedit'); return false;\">";
                                    echo _('Edit');
                                    echo buildSvgElement("img/chevron-down.svg", ["class" => "w-3 h-3 ml-2 fill-current inline-block"]);
                                    echo "</a> )</span><br>";
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
                <td class="tngbotshadow">
                    <?php echo displayToggle("plus1", 1, "events", _('Events'), ""); ?>

                    <div id="events">
                        <p class="smallest topmarginsmall"><?php echo _('<strong>Note:</strong> When entering dates, please use the standard genealogical format DD MMM YYYY. For example, 10 Apr 2004.'); ?></p>
                        <table class="normal" cellpadding="1" cellspacing="2">
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
                <td class="tngbotshadow">
                    <?php echo displayToggle("plus2", 1, "children", _('Children') . " (<span id=\"childcount\">$kidcount</span>)", ""); ?>

                    <div id="children" style="padding-top:10px;">
                        <table id="ordertbl" width="500px" cellpadding="3" cellspacing="1">
                            <tr>
                                <th class="fieldnameback" style="width:55px;"><span class="fieldname"><?php echo _('Sort'); ?></span></th>
                                <th class="fieldnameback"><span class="fieldname"><?php echo _('Child'); ?></span></th>
                            </tr>
                        </table>
                        <div id="childrenlist">
                            <?php
                            if ($children && $kidcount) {
                                while ($child = tng_fetch_assoc($children)) {
                                    $crights = determineLivingPrivateRights($child, $righttree);
                                    $child['allow_living'] = $crights['living'];
                                    $child['allow_private'] = $crights['private'];
                                    if ($child['firstname'] || $child['lastname']) {
                                        echo "<div class='sortrow' id=\"child_{$child['pID']}\" style=\"width:500px;clear:both\"";
                                        if ($allow_delete) {
                                            echo " onmouseover=\"$('unlinkc_{$child['pID']}').style.visibility='visible';\" onmouseout=\"$('unlinkc_{$child['pID']}').style.visibility='hidden';\"";
                                        }
                                        echo ">\n";
                                        echo "<table class='w-full' cellpadding='5' cellspacing='1'><tr>\n";
                                        echo "<td class='dragarea rounded-lg normal'>";
                                        echo "<img src='img/admArrowUp.gif' alt='' class='inline-block'>" . _('Drag') . "<img src='img/admArrowDown.gif' alt='' class='inline-block'>\n";
                                        echo "</td>\n";
                                        echo "<td class='lightback normal childblock'>\n";
                                        if ($allow_delete) {
                                            echo "<div id=\"unlinkc_{$child['pID']}\" class=\"smaller hide-right\"><a href='#' onclick=\"return unlinkChild('{$child['pID']}','child_unlink');\">" . _('Remove') . "</a> &nbsp; | &nbsp; <a href='#' onclick=\"return unlinkChild('{$child['pID']}','child_delete');\">" . _('Delete') . "</a></div>";
                                        }
                                        if ($crights['both']) {
                                            $birthstring = getBirthText($child);

                                            echo getName($child);
                                            echo " - {$child['pID']}<br>$birthstring";
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

                        <input type="hidden" name="tree" value="<?php echo $tree; ?>">
                        <p class="normal"><?php echo _('New Children'); ?>:
                            <input type="button" value="<?php echo _('Find...'); ?>" onclick="return findItem('I','children',null,'<?php echo $tree; ?>');">
                            <input type="button" value="<?php echo _('Create...'); ?>"
                                onclick="return newPerson('','child',document.famform1.husband.value,'<?php echo "$familyID"; ?>','<?php echo $assignedbranch; ?>');">
                            <input type="hidden" name="familyID" value="<?php echo "$familyID"; ?>">
                            <input type="hidden" name="lastperson" value="<?php echo "$lastperson"; ?>">
                            <input type="hidden" name="newfamily" value="ajax">
                            <?php if (!$rights['lds']) { ?>
                                <input type="hidden" value="<?php echo $row['sealdate']; ?>" name="sealdate">
                                <input type="hidden" name="sealsrc" value="<?php echo $row['sealsrc']; ?>">
                                <input type="hidden" value="<?php echo $row['sealplace']; ?>" name="sealplace">
                            <?php } ?>
                        </p>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </table>
</form>
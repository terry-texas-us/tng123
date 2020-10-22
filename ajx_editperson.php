<?php

include "begin.php";
include "adminlib.php";

require_once "./admin/associations.php";
require_once "./admin/citations.php";
require_once "./admin/events.php";
require_once "./admin/notelinks.php";
require_once "./admin/trees.php";
require_once "./public/people.php";

if (!$personID) die("no args");


$textpart = "people";
include "$mylanguage/admintext.php";

include "checklogin.php";

initMediaTypes();

$row = fetchAndCleanPersonRow($personID, $people_table, $tree);

if ((!$allow_edit && (!$allow_add || !$added)) || ($assignedtree && $assignedtree != $tree) || !checkbranch($row['branch'])) {
    $message = $admtext['norights'];
    header("Location: ajx_login.php?message=" . urlencode($message));
    exit;
}

$editconflict = determineConflict($row, $people_table);

if ($row['sex'] == "M") {
    $spouse = "wife";
    $self = "husband";
    $spouseorder = "husborder";
    $selfdisplay = $admtext['ashusband'];
} else {
    if ($row['sex'] == "F") {
        $spouse = "husband";
        $self = "wife";
        $spouseorder = "wifeorder";
        $selfdisplay = $admtext['aswife'];
    } else {
        $spouse = "";
        $self = "";
        $spouseorder = "";
        $selfdisplay = $admtext['asspouse'];
    }
}

$righttree = checktree($tree);

$rights = determineLivingPrivateRights($row, $righttree);
$row['allow_living'] = $rights['living'];
$row['allow_private'] = $rights['private'];

$namestr = getName($row);

$treerow = getTree($trees_table, $tree);

$gotnotes = checkForNoteLinks($personID, $tree);
$gotcites = checkForCitations($personID, $tree);
$gotassoc = checkForAssociations($personID, $tree);
$gotmore = checkForEvents($personID, $tree);

$photo = showSmallPhoto($personID, $namestr, 1, 0, false, $row['sex']);
header("Content-type:text/html; charset=" . $session_charset);

include_once "eventlib.php";
?>

<form action="" method="post" name="form1" id="form1" onsubmit="return updatePerson(this, <?php echo $slot; ?>);">
    <table class="w-full" cellpadding="10" cellspacing="2">
        <tr class="databack">
            <td class="tngbotshadow">
                <div style="float:right;">
                    <input type="submit" name="submit2" accesskey="s" class="bigsave" value="<?php echo $admtext['save']; ?>">
                </div>
                <table cellpadding="0" cellspacing="0" class="normal">
                    <tr>
                        <td class='align-top'>
                            <div id="thumbholder" style="margin-right:5px;<?php if (!$photo) {
                                echo "display:none";
                            } ?>"><?php echo $photo; ?></div>
                        </td>
                        <td>
				            <span class="plainheader"><?php echo "$namestr ($personID)</span><br>" . getYears($row); ?>
				            <div class="topbuffer bottombuffer smallest">
                                <?php
                                if ($editconflict) {
                                    echo "<br><p>{$admtext['editconflict']}</p>";
                                } else {
                                    $notesicon = $gotnotes['general'] ? "admin-note-on-icon" : "admin-note-off-icon";
                                    $citesicon = $gotcites['general'] ? "admin-cite-on-icon" : "admin-cite-off-icon";
                                    $associcon = $gotassoc ? "admin-asso-on-icon" : "admin-asso-off-icon";
                                    echo "<a href='#' onclick=\"document.form1.submit();\" class=\"smallicon si-plus admin-save-icon\">{$admtext['save']}</a>\n";
                                    echo "<a href='#' onclick=\"return showNotes('', '$personID');\" id='notesicon' class=\"smallicon si-plus $notesicon\">{$admtext['notes']}</a>\n";
                                    echo "<a href='#' onclick=\"return showCitations('', '$personID');\" id='citesicon' class=\"smallicon si-plus $citesicon\">{$admtext['sources']}</a>\n";
                                    echo "<a href='#' onclick=\"return showAssociations('$personID','I');\" id=\"associcon\" class=\"smallicon si-plus $associcon\">{$admtext['associations']}</a>\n";
                                }
                                ?>
                                <br class="clear-both">
				            </div>
				            <span class="smallest"><?php echo $admtext['lastmodified'] . ": {$row['changedate']} ({$row['changedby']})"; ?></span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <?php if (!$editconflict) { ?>
        <tr class="databack">
            <td class="tngbotshadow">
                <?php echo displayToggle("plus0", 1, "names", $admtext['name'], ""); ?>

                <div id="names">
                    <table class="normal topmarginsmall">
                        <tr>
                            <td><?php echo $admtext['firstgivennames']; ?></td>
                            <?php if ($lnprefixes) echo "<td>{$admtext['lnprefix']}</td>\n"; ?>
                            <td><?php echo $admtext['lastsurname']; ?></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" value="<?php echo $row['firstname']; ?>" name="firstname" size="35">
                            </td>
                            <?php
                            if ($lnprefixes) {
                                echo "<td><input type='text' value=\"{$row['lnprefix']}\" name='lnprefix' style=\"width:80px;\"></td>\n";
                            }
                            ?>
                            <td>
                                <input type="text" value="<?php echo $row['lastname']; ?>" name="lastname" size="35">
                            </td>
                            <td>
                                <?php
                                $notesicon = "img/" . ($gotnotes['NAME'] ? "tng_anote_on.gif" : "tng_anote.gif");
                                $citesicon = "img/" . ($gotcites['NAME'] ? "tng_cite_on.gif" : "tng_cite.gif");
                                echo "<a href='#' onclick=\"return showNotes('NAME','$personID');\">\n";
                                echo "<img src=\"$notesicon\" title=\"{$admtext['notes']}\" alt=\"{$admtext['notes']}\" width='20' height='20' id=\"notesiconNAME\" class=\"smallicon\">\n";
                                echo "</a>\n";
                                echo "<a href='#' onclick=\"return showCitations('NAME','$personID');\">\n";
                                echo "<img src=\"$citesicon\" title=\"{$admtext['sources']}\" alt=\"{$admtext['sources']}\" width='20' height='20' id=\"citesiconNAME\" class=\"smallicon\">\n";
                                echo "</a>\n";
                                ?>
                            </td>
                        </tr>
                    </table>
                    <table class="normal topmarginsmall">
                        <tr>
                            <td><?php echo $admtext['sex']; ?></td>
                            <td><?php echo $admtext['nickname']; ?></td>
                            <td><?php echo $admtext['title']; ?></td>
                            <td><?php echo $admtext['prefix']; ?></td>
                            <td><?php echo $admtext['suffix']; ?></td>
                            <td><?php echo $admtext['nameorder']; ?></td>
                        </tr>
                        <tr>
                            <td>
                                <select name="sex">
                                    <option value="U" <?php if ($row['sex'] == "U") {
                                        echo "selected";
                                    } ?>><?php echo $admtext['unknown']; ?></option>
                                    <option value="M" <?php if ($row['sex'] == "M") {
                                        echo "selected";
                                    } ?>><?php echo $admtext['male']; ?></option>
                                    <option value="F" <?php if ($row['sex'] == "F") {
                                        echo "selected";
                                    } ?>><?php echo $admtext['female']; ?></option>
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
                                    <option value="0"><?php echo $admtext['default']; ?></option>
                                    <option value="1" <?php if ($row['nameorder'] == "1") {
                                        echo "selected";
                                    } ?>><?php echo $admtext['western']; ?></option>
                                    <option value="2" <?php if ($row['nameorder'] == "2") {
                                        echo "selected";
                                    } ?>><?php echo $admtext['oriental']; ?></option>
                                    <option value="3" <?php if ($row['nameorder'] == "3") {
                                        echo "selected";
                                    } ?>><?php echo $admtext['lnfirst']; ?></option>
                                </select>
                            </td>
                        </tr>
                    </table>

                    <table class="normal topbuffer">
                        <tr>
                            <td class="text-nowrap">
                                <input type="checkbox" name="living" value="1"<?php if ($row['living']) {
                                    echo " checked";
                                } ?>> <?php echo $admtext['living']; ?>&nbsp;&nbsp;
                                <input type="checkbox" name="private" value="1"<?php if ($row['private']) {
                                    echo " checked";
                                } ?>> <?php echo $admtext['text_private']; ?>
                            </td>
                            <td class="spaceonleft"><?php echo $admtext['tree'] . ": " . $treerow['treename']; ?></td>
                            <td class="spaceonleft"><?php echo $admtext['branch'] . ": "; ?>

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
                                $desclist = count($descriptions) ? implode(', ', $descriptions) : $admtext['nobranch'];
                                echo "<span id=\"branchlist\">$desclist</span>";
                                if (!$assignedbranch) {
                                $totbranches = tng_num_rows($branchresult) + 1;
                                if ($totbranches < 2) $totbranches = 2;
                                $selectnum = $totbranches < 8 ? $totbranches : 8;
                                $select = $totbranches >= 8 ? $admtext['scrollbranch'] . "<br>" : "";
                                $select .= "<select name=\"branch[]\" id='branch' multiple size=\"$selectnum\" style=\"overflow:auto;\">\n";
                                $select .= "	<option value=\"\"";
                                if ($row['branch'] == "") $select .= " selected";
                                $select .= ">{$admtext['nobranch']}</option>\n";
                                $select .= "$options</select>\n";
                                echo " &nbsp;<span class='text-nowrap'>(<a href='#' onclick=\"showBranchEdit('branchedit'); quitBranchEdit('branchedit'); return false;\">";
                                echo $admtext['edit'];
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
            </td>
        </tr>
        <tr class="databack">
            <td class="tngbotshadow">
                <?php echo displayToggle("plus1", 1, "events", $admtext['events'], ""); ?>

                <div id="events">
                    <p class="smallest topmarginsmall"><?php echo $admtext['datenote']; ?></p>
                    <table class="normal" cellpadding="1" cellspacing="2">
                        <tr>
                            <td>&nbsp;</td>
                            <td><?php echo $admtext['date']; ?></td>
                            <td><?php echo $admtext['place']; ?></td>
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
                        echo "<td colspan='3'><input type='checkbox' name='burialtype' id='burialtype' value='1'{$checked}> <label for='burialtype'>{$admtext['cremated']}</label></td>";
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
                                    <?php echo $admtext['otherevents'] . ": <input type='button' value=\"  {$admtext['addnew']} \" onClick=\"newEvent('I', '$personID', '$tree');\">\n"; ?>
                                </p>
                            </td>
                        </tr>
                        <?php showCustEvents($personID); ?>
                    </table>
                    <input type="hidden" name="tree" value="<?php echo $tree; ?>">
                    <input type="hidden" name="personID" value="<?php echo "$personID"; ?>">
                    <input type="hidden" name="newfamily" value="ajax">
                    <?php if (!$lnprefixes) {
                        echo "<input type='hidden' name='lnprefix' value=\"{$row['lnprefix']}\">";
                    } ?>
                    <?php defineLdsHiddenFields($rights['lds'], $row); ?>
                </div>
            </td>
        </tr>
        <?php
        $query = "SELECT personID, familyID, sealdate, sealplace, frel, mrel FROM $children_table WHERE personID = \"$personID\" AND gedcom = '$tree' ORDER BY parentorder";
        $parents = tng_query($query);
        $parentcount = tng_num_rows($parents);

        if ($parentcount) {
        ?>
        <tr class="databack">
            <td class="tngbotshadow">
                <?php echo displayToggle("plus2", 0, "parents", $admtext['parents'] . " (<span id=\"parentcount\">$parentcount</span>)", ""); ?>

                <div id="parents" style="display:none;"><br>
                    <?php
                    while ($parent = tng_fetch_assoc($parents))
                    {
                    $query = "SELECT personID, lastname, lnprefix, firstname, birthdate, birthplace, altbirthdate, altbirthplace, prefix, suffix, nameorder, people.living, people.private, people.branch ";
                    $query .= "FROM $people_table people, $families_table families ";
                    $query .= "WHERE people.personID = families.husband AND families.familyID = \"{$parent['familyID']}\" AND people.gedcom = '$tree' AND families.gedcom = '$tree'";
                    $gotfather = tng_query($query);
                    echo "<div class='sortrow' id=\"parents_{$parent['familyID']}\" style=\"clear:both;\" onmouseover=\"$('unlinkp_{$parent['familyID']}').style.display='';\" onmouseout=\"$('unlinkp_{$parent['familyID']}').style.display='none';\">\n";
                    echo "<table class='w-full' cellpadding='5' cellspacing='1'><tr>\n";
                    if ($parentcount > 1) {
                        echo "<td class='dragarea rounded-lg normal'>";
                        echo "<img src='img/admArrowUp.gif' alt='' class='inline-block'>{$admtext['drag']}<img src='img/admArrowDown.gif' alt='' class='inline-block'>\n";
                        echo "</td>\n";
                    }
                    echo "<td class='lightback normal'>\n";
                    echo "<div id=\"unlinkp_{$parent['familyID']}\" style=\"float:right;display:none;\"><a href='#' onclick=\"return unlinkParents('{$parent['familyID']}');\">{$admtext['unlinkindividual']} ($personID) {$admtext['aschild']}</a></div>\n";
                    echo "<table class='normal'>";
                    echo "<tr>";
                    echo "<td class='align-top'><strong>{$admtext['family']}:</strong></td>\n";
                    echo "<td class='align-top' colspan='4'>\n";

                    echo $parent['familyID'] . "\n</td></tr>";
                    if ($gotfather) {
                    $fathrow = tng_fetch_assoc($gotfather);
                    $frights = determineLivingPrivateRights($fathrow, $righttree);
                    $fathrow['allow_living'] = $frights['living'];
                    $fathrow['allow_private'] = $frights['private'];
                    ?>
        <tr>
            <td class='align-top'><?php echo $admtext['father']; ?>:</td>
            <td class="align-top" colspan="4">
                <?php
                if ($fathrow['personID']) {

                    echo getName($fathrow) . " - " . $fathrow['personID'];
                }
                ?>
            </td>
        </tr>
        <tr>
            <td class='align-top'>&nbsp;&nbsp;<?php echo $admtext['relationship']; ?>:</td>
            <td class="align-top" colspan="4">
                <select name="frel<?php echo $parent['familyID']; ?>">
                    <option value=""></option>
                    <?php
                    foreach (PARENT_CHILD_RELATIONSHIP_TYPES as $reltype) {
                        echo "<option value=\"$reltype\"";
                        $lowerrel = strtolower($parent['frel']);
                        if ($lowerrel == $reltype || $lowerrel == $admtext[$reltype]) {
                            echo " selected";
                        }
                        echo ">{$admtext[$reltype]}</option>\n";
                    }
                    ?>
                </select>
            </td>
        </tr>
    <?php
    tng_free_result($gotfather);
    }

    $query = "SELECT personID, lastname, lnprefix, firstname, birthdate, birthplace, altbirthdate, altbirthplace, prefix, suffix, nameorder, people.living, people.private, people.branch ";
    $query .= "FROM $people_table people, $families_table families ";
    $query .= "WHERE people.personID = families.wife AND families.familyID = \"{$parent['familyID']}\" AND people.gedcom = '$tree' AND families.gedcom = '$tree'";
    $gotmother = tng_query($query);

    if ($gotmother) {
        $mothrow = tng_fetch_assoc($gotmother);
        $mrights = determineLivingPrivateRights($mothrow, $righttree);
        $mothrow['allow_living'] = $mrights['living'];
        $mothrow['allow_private'] = $mrights['private']; ?>
        <tr>
            <td class='align-top'><span class="normal"><?php echo $admtext['mother']; ?>:</span></td>
            <td class="align-top" colspan="4">
                <?php
                if ($mothrow['personID']) {

                    echo getName($mothrow) . " - " . $mothrow['personID'];
                }
                ?>
            </td>
        </tr>
        <tr>
            <td class='align-top'>&nbsp;&nbsp;<?php echo $admtext['relationship']; ?>:</td>
            <td class="align-top" colspan="4">
                <select name="mrel<?php echo $parent['familyID']; ?>">
                    <option value=""></option>
                    <?php
                    foreach (PARENT_CHILD_RELATIONSHIP_TYPES as $reltype) {
                        echo "<option value=\"$reltype\"";
                        $lowerrel = strtolower($parent['frel']);
                        if ($lowerrel == $reltype || $lowerrel == $admtext[$reltype]) {
                            echo " selected";
                        }
                        echo ">{$admtext[$reltype]}</option>\n";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <?php
        tng_free_result($gotmother);
    }

    $parent['sealplace'] = preg_replace("/\"/", "&#34;", $parent['sealplace']);
    if ($rights['lds']) {
        $citquery = "SELECT citationID FROM $citations_table WHERE persfamID = \"$personID" . "::" . "{$parent['familyID']}\" AND gedcom = '$tree'";
        $citresult = tng_query($citquery) or die ($text['cannotexecutequery'] . ": $citquery");
        $citesicon = "img/" . (tng_num_rows($citresult) ? "tng_cite_on.gif" : "tng_cite.gif");
        tng_free_result($citresult);
        echo "<table>";
        echo "<tr>";
        echo "<td>&nbsp;</td>";
        echo "<td>" . $admtext['date'] . "</td>";
        echo "<td>" . $admtext['place'] . "</td>";
        echo "<td colspan='2'>&nbsp;</td>";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class='align-top text-nowrap' style='width:110px;'>" . $admtext['SLGC'] . ":</td>\n";
        echo "<td><input type='text' value=\"" . $parent['sealdate'] . "\" name=\"sealpdate" . $parent['familyID'] . "\" onblur=\"checkDate(this);\" maxlength='50' class='w-32'></td>\n";
        echo "<td><input type='text' value=\"" . $parent['sealplace'] . "\" name=\"sealpplace" . $parent['familyID'] . "\" id=\"sealpplace" . $parent['familyID'] . "\" class='longfield'></td>\n";
        echo "<td>\n";
        echo "<a href='#' onclick=\"return openFindPlaceForm('sealpplace" . $parent['familyID'] . "');\">\n";
        echo "<img src=\"img/tng_find.gif\" title=\"{$admtext['find']}\" alt=\"{$admtext['find']}\" width='20' height='20' class='smallicon'>\n";
        echo "</a>\n";
        echo "</td>\n";
        echo "<td>\n";
        echo "<a href='#' onclick=\"return showCitations('SLGC','$personID::" . $parent['familyID'] . "');\">\n";
        echo "<img src=\"$citesicon\" title=\"{$admtext['sources']}\" alt=\"{$admtext['sources']}\" width='20' height='20' id=\"citesiconSLGC$personID::" . $parent['familyID'] . "\" class=\"smallicon\">\n";
        echo "</a>\n";
        echo "</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
    } else {
        ?>
        <input type="hidden" name="sealpdate<?php echo $parent['familyID']; ?>" value="<?php echo $parent['sealdate']; ?>">
        <input type="hidden" name="sealpplace<?php echo $parent['familyID']; ?>" value="<?php echo $parent['sealplace']; ?>">
    <?php } ?>
        </td>
    </table>
    </div>
    <?php
    }
    tng_free_result($parents);
    ?>
    </div>
    </td>
    </tr>
    <?php
    }

    if ($row['sex']) {
        if ($self) {
            $query = "SELECT $spouse, familyID, marrdate FROM $families_table WHERE $families_table.$self = \"$personID\" AND gedcom = '$tree' ORDER BY $spouseorder";
        } else {
            $query = "SELECT husband, wife, familyID, marrdate FROM $families_table WHERE ($families_table.husband = \"$personID\" OR $families_table.wife = \"$personID\") AND gedcom = '$tree'";
        }
        $marriages = tng_query($query);
        $marrcount = tng_num_rows($marriages);

        if ($marrcount) {
            ?>
            <tr class="databack">
            <td class="tngbotshadow">
            <?php echo displayToggle("plus3", 0, "spouses", $admtext['spouses'] . " (<span id=\"marrcount\">$marrcount</span>)", ""); ?>

            <div id="spouses" style="display:none;"><br>
            <?php
            if ($marriages && tng_num_rows($marriages)) {
                while ($marriagerow = tng_fetch_assoc($marriages)) {
                    if (!$spouse) {
                        if ($personID == $marriagerow['husband']) {
                            $self = "husband";
                            $spouse = "wife";
                        } else {
                            if ($personID == $marriagerow['wife']) {
                                $self = "wife";
                            }
                        }
                        $spouse = "husband";
                    }
                    echo "<div class='sortrow' id=\"spouses_{$marriagerow['familyID']}\" style=\"clear:both;\" onmouseover=\"$('unlinks_{$marriagerow['familyID']}').style.display='';\" onmouseout=\"$('unlinks_{$marriagerow['familyID']}').style.display='none';\">\n";
                    echo "<table class='w-full' cellpadding='5' cellspacing='1'><tr>\n";
                    if ($marrcount > 1) {
                        echo "<td class='dragarea normal'>";
                        echo "<img src='img/admArrowUp.gif' alt='' class='inline-block'>{$admtext['drag']}<img src='img/admArrowDown.gif' alt='' class='inline-block'>\n";
                        echo "</td>\n";
                    }
                    echo "<td class='lightback normal'>\n";
                    echo "<table class='normal w-full'\n>";
                    echo "<tr>\n";
                    echo "<td class='align-top'><strong>{$admtext['family']}:</strong></td>\n";
                    echo "<td class='align-top' width=\"94%\">\n";
                    echo "<div id=\"unlinks_{$marriagerow['familyID']}\" style=\"float:right;display:none;\">\n";
                    echo "<a href='#' onclick=\"return unlinkSpouse('{$marriagerow['familyID']}');\">{$admtext['unlinkindividual']} ($personID) {$admtext['asspouse']}</a>\n";
                    echo "</div>\n";

                    echo $marriagerow['familyID'] . "\n</td></tr>";
                    if ($marriagerow[$spouse]) {
                        $query = "SELECT personID, lastname, lnprefix, firstname, prefix, suffix, nameorder, living, private, branch FROM $people_table WHERE personID = \"{$marriagerow[$spouse]}\" AND gedcom = '$tree'";
                        $spouseresult = tng_query($query);
                        $spouserow = tng_fetch_assoc($spouseresult);
                        $srights = determineLivingPrivateRights($spouserow, $righttree);
                        $spouserow['allow_living'] = $srights['living'];
                        $spouserow['allow_private'] = $srights['private'];
                    } else {
                        $spouserow = "";
                    }
                    ?>
                    <tr>
                        <td class='align-top'><?php echo $admtext['spouse']; ?>:</td>
                        <td class='align-top'>
                            <?php
                            if ($spouserow['personID']) {
                                echo getName($spouserow) . " - " . $spouserow['personID'];
                            }
                            ?>
                        </td>
                    </tr>
                    <?php if ($marriagerow['marrdate'] || $marriagerow['marrplace']) { ?>
                        <tr>
                            <td class='align-top'><span class="normal"><?php echo $admtext['married']; ?>:</span></td>
                            <td class='align-top'><span class="normal"><?php echo $marriagerow['marrdate']; ?></span></td>
                        </tr>
                        <?php
                    }
                    $query = "SELECT people.personID AS pID, firstname, lnprefix, lastname, haskids, living, private, branch, prefix, suffix, nameorder ";
                    $query .= "FROM ($people_table people, $children_table children) ";
                    $query .= "WHERE people.personID = children.personID AND children.familyID = \"{$marriagerow['familyID']}\" AND people.gedcom = '$tree' AND children.gedcom = '$tree' ";
                    $query .= "ORDER BY ordernum";
                    $children = tng_query($query);

                    if ($children && tng_num_rows($children)) {
                        ?>
                        <tr>
                            <td class='align-top'><span class="normal"><?php echo $admtext['children']; ?>:</span></td>
                            <td class='align-top'><span class="normal">
                        <?php
                        $kidcount = 1;
                        echo "<table cellpadding = '0' cellspacing = '0'>\n";
                        while ($child = tng_fetch_assoc($children)) {
                            $ifkids = $child['haskids'] ? "&gt" : "&nbsp;";
                            $crights = determineLivingPrivateRights($child, $righttree);
                            $child['allow_living'] = $crights['living'];
                            $child['allow_private'] = $crights['private'];
                            if ($child['firstname'] || $child['lastname']) {
                                echo "<tr>";
                                echo "<td>$ifkids</td>";
                                echo "<td><span class='normal'>$kidcount. ";
                                if ($crights['both']) {
                                    echo getName($child) . " - {$child['pID']}";
                                } else {
                                    echo $admtext['living'] . " - " . $child['pID'];
                                }
                                echo "</span></td>";
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
            <?php
        }
    }

    } //end of the editconflict conditional
    ?>
    </table>
</form>
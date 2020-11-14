<?php
include "begin.php";
include "adminlib.php";
require_once "./admin/trees.php";

$textpart = "people";
include "$mylanguage/admintext.php";

$admin_login = true;
include "checklogin.php";
if (!$allow_add) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$treerow = getTree($trees_table, $tree);

if ($father) {
    $query = "SELECT lnprefix, lastname, branch FROM $people_table WHERE gedcom='$tree' AND personID=\"$father\"";
    $result = tng_query($query);
    $row = tng_fetch_assoc($result);
    tng_free_result($result);
} else {
    $row['lastname'] = $row['lnprefix'] = "";
}

function relateSelect($label) {
    global $admtext;

    $fieldname = $label == "father" ? "frel" : "mrel";
    $pout = "<select name=\"$fieldname\">\n";
    $pout .= "<option value=\"\"></option>\n";

    foreach (PARENT_CHILD_RELATIONSHIP_TYPES as $reltype) {
        $pout .= "<option value=\"$reltype\"";
        if ($parent[$fieldname] == $reltype || $parent[$fieldname] == $admtext[$reltype]) {
            $pout .= " selected";
        }
        $pout .= ">{$admtext[$reltype]}</option>\n";
    }
    $pout .= "</select>\n";

    return $pout;
}

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack ajaxwindow" id="newperson">
    <h3 class="subhead"><?php echo _('Add New Person'); ?></h3>

    <form method="post" name="npform"<?php if ($needped) {
        echo " action=\"admin_addperson2.php\"";
    } else {
        echo " action=\"\" onsubmit=\"return saveNewPerson(this);\"";
    } ?> style="margin-top:10px;">
        <table cellpadding="2" class="normal">
            <tr>
                <td class="align-top" colspan="2"><strong><?php echo _('Please prefix Person ID with \"I\" for \"Individual\"'); ?></strong></td>
            </tr>
            <tr>
                <td><span class="normal"><?php echo _('Person ID'); ?>:</span></td>
                <td>
                    <input type="text" name="personID" size="10" onblur="this.value=this.value.toUpperCase()">
                    <input type="button" value="<?php echo _('Generate'); ?>" onclick="generateID('person',document.npform.personID,document.form1.tree1);">
                    <input type="button" value="<?php echo _('Check'); ?>" onclick="checkID(document.npform.personID.value,'person','checkmsg2',document.form1.tree1);">
                    <span id="checkmsg2" class="normal"></span>
                </td>
            </tr>
        </table>
        <table class="normal topmarginsmall">
            <tr>
                <td><?php echo _('First/Given Name(s)'); ?></td>
                <?php if ($lnprefixes) echo "<td>" . _('Surname Prefix') . "</td>\n"; ?>
                <td><?php echo _('Last/Surname'); ?></td>
            </tr>
            <tr>
                <td>
                    <input type="text" name="firstname" id="firstname" size="30">
                </td>
                <?php
                if ($lnprefixes) {
                    echo "<td><input type='text' name='lnprefix' style=\"width:80px;\" value=\"" . $row['lnprefix'] . "\"></td>\n";
                }
                ?>
                <td>
                    <input type="text" name="lastname" size="30" value="<?php echo $row['lastname']; ?>">
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
            </tr>
            <tr>
                <td>
                    <select name="sex">
                        <option value="U"><?php echo _('Unknown'); ?></option>
                        <option value="M"<?php if ($gender == 'M') {
                            echo " selected";
                        } ?>><?php echo _('Male'); ?></option>
                        <option value="F"<?php if ($gender == 'F') {
                            echo " selected";
                        } ?>><?php echo _('Female'); ?></option>
                    </select>
                </td>
                <td>
                    <input type="text" name="nickname" class="w-24">
                </td>
                <td>
                    <input type="text" name="title" class="w-24">
                </td>
                <td>
                    <input type="text" name="prefix" class="w-24">
                </td>
                <td>
                    <input type="text" name="suffix" class="w-24">
                </td>
            </tr>
        </table>

        <table class="normal topbuffer">
            <tr>
                <td class="whitespace-no-wrap">
                    <input type="checkbox" name="living" value="1" checked="checked"> <?php echo _('Living'); ?>&nbsp;&nbsp;
                    <input type="checkbox" name="private" value="1"> <?php echo _('Private'); ?>
                </td>
                <td class="spaceonleft"><?php echo _('Tree') . ": " . $treerow['treename']; ?></td>
                <td class="spaceonleft"><?php echo _('Branch') . ": "; ?>
                    <?php
                    $query = "SELECT branch, description FROM $branches_table WHERE gedcom = '$tree' ORDER BY description";
                    $branchresult = tng_query($query);
                    $numbranches = tng_num_rows($branchresult);
                    $branchlist = explode(",", $row['branch']);

                    $descriptions = [];
                    $assdesc = "";
                    $options = "";
                    while ($branchrow = tng_fetch_assoc($branchresult)) {
                        $options .= "	<option value=\"{$branchrow['branch']}\">{$branchrow['description']}</option>\n";
                        if ($branchrow['branch'] == $assignedbranch) {
                            $assdesc = $branchrow['description'];
                        }
                    }
                    echo "<span id=\"branchlist2\"></span>";
                    if (!$assignedbranch) {
                    if ($numbranches > 8) $select = _('(Scroll to see all choices)') . "<br>";
                    $select .= "<select name=\"branch[]\" id=\"branch2\" multiple size='8'>\n";
                    $select .= "	<option value=\"\"";
                    if ($row['branch'] == "") $select .= " selected";
                    $select .= ">" . _('No Branch') . "</option>\n";
                    $select .= "$options</select>\n";
                    echo " <span class='whitespace-no-wrap'>(";
                    echo "<a href='#' onclick=\"showBranchEdit('branchedit2'); quitBranchEdit('branchedit2'); return false;\">";
                    echo _('Edit');
                    echo buildSvgElement("img/chevron-down.svg", ["class" => "w-3 h-3 ml-2 fill-current inline-block"]);
                    echo "</a> )</span><br>";
                    ?>
                    <div id="branchedit2" class="lightback p-1" style="position:absolute;display:none;" onmouseover="clearTimeout(branchtimer);" onmouseout="closeBranchEdit('branch2','branchedit2','branchlist2');">
                        <?php
                        echo $select;
                        echo "</div>\n";
                        }
                        else {
                            echo "<input type='hidden' name='branch' value=\"$assignedbranch\">$assdesc ($assignedbranch)";
                        }
                        ?>
                </td>
            </tr>
        </table>

        <p class="normal topmarginsmall" style="margin-bottom:8px;"><?php echo _('<strong>Note:</strong> When entering dates, please use the standard genealogical format DD MMM YYYY. For example, 10 Apr 2004.'); ?></p>
        <table class="normal">
            <tr>
                <td>&nbsp;</td>
                <td><?php echo _('Date'); ?></td>
                <td><?php echo _('Place'); ?></td>
                <td colspan="4">&nbsp;</td>
            </tr>
            <?php
            $noclass = true;
            $currentform = "document.npform";
            echo showEventRow('birthdate', 'birthplace', 'BIRT', '');
            if (!$tngconfig['hidechr']) {
                echo showEventRow('altbirthdate', 'altbirthplace', 'CHR', '');
            }
            echo showEventRow('deathdate', 'deathplace', 'DEAT', '');
            echo showEventRow('burialdate', 'burialplace', 'BURI', '');
            echo "<tr>";
            echo "<td></td>";
            echo "<td colspan='3'><input type='checkbox' name=\"burialtype\" id=\"burialtype\" value='1'> <label for=\"burialtype\">" . _('Cremated') . "</label></td>";
            echo "</tr>\n";
            if (determineLDSRights()) {
                echo showEventRow('baptdate', 'baptplace', 'BAPL', '');
                echo showEventRow('confdate', 'confplace', 'CONL', '');
                echo showEventRow('initdate', 'initplace', 'INIT', '');
                echo showEventRow('endldate', 'endlplace', 'ENDL', '');
            }
            ?>
        </table>

        <?php
        if ($type == "child") {
            echo "<br>\n";
            echo _('Relationship') . " (" . _('Father') . "): " . relateSelect("father") . "&nbsp;&nbsp;";
            echo _('Relationship') . " (" . _('Mother') . "): " . relateSelect("mother");
        }
        ?>

        <input type="hidden" name="tree" value="<?php echo $tree; ?>">
        <input type="hidden" name="needped" value="<?php echo $needped; ?>">
        <input type="hidden" name="familyID" value="<?php echo $familyID; ?>">
        <?php if ($type == "") {
            $type = "text";
        } ?>
        <input type="hidden" name="type" value="<?php echo $type; ?>">
        <?php
        if (!$lnprefixes) {
            echo "<input type='hidden' name='lnprefix' value=\"\">";
        }
        ?>
        <p class="normal" style="margin-top:15px;margin-left:4px;">
            <input type="submit" name="submit" value="<?php echo _('Save'); ?>"> &nbsp; <strong><?php echo _('Note: Additional events, plus event-specific notes and citations, may be added later.'); ?></strong></p>
        <div id="errormsg" class="red" style="display:none;"></div>
    </form>
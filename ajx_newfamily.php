<?php
include "begin.php";
include "adminlib.php";
require_once "./admin/trees.php";

include "checklogin.php";

if (!$allow_add) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: login.php?message=" . urlencode($message));
    exit;
}

if ($child) {
    $newperson = $child;
} else {
    if ($husband) {
        $newperson = $husband;
    } else {
        if ($wife) {
            $newperson = $wife;
        } else {
            $newperson = "";
        }
    }
}

if ($newperson) {
    $query = "SELECT personID, firstname, lnprefix, lastname, prefix, suffix, nameorder, living, private, branch FROM $people_table WHERE personID = \"$newperson\" AND gedcom = '$tree'";
    $result = tng_query($query);
    $newpersonrow = tng_fetch_assoc($result);
    tng_free_result($result);
}

if ($husband) {
    $husbstr = getName($newpersonrow) . " - $husband";
} else {
    if ($wife) $wifestr = getName($newpersonrow) . " - $wife";
}
if (!isset($husbstr)) $husbstr = _('Click Find or Create =>');
if (!isset($wifestr)) $wifestr = _('Click Find or Create =>');

$treerow = getTree($trees_table, $tree);

header("Content-type:text/html; charset=" . $session_charset);

include_once "eventlib.php";
?>

<form action="" method="post" name="famform1" id="famform1" onsubmit="return validateFamily(this,'<?php echo $slot; ?>');">
    <input type="hidden" name="lastperson" value="<?php echo $child; ?>">
    <table class="w-full" cellpadding="10" cellspacing="0">
        <tr class="databack">
            <td class="tngbotshadow">
                <div style="float:right;">
                    <input type="submit" name="submit2" accesskey="s" class="bigsave" value="<?php echo _('Save'); ?>">
                </div>
                <h3 class="subhead togglehead no-underline"><?php echo _('Add New Family'); ?></h3>

                <table class="normal">
                    <tr>
                        <td class="align-top" colspan="2"><span class="normal"><strong><?php echo _('Please prefix Family ID with \"F\" for \"Family\"'); ?></strong></span></td>
                    </tr>
                    <tr>
                        <td><span class="normal"><?php echo _('Family ID'); ?>:</span></td>
                        <td>
                            <input type="text" name="familyID" id="familyID" value="<?php echo $newID; ?>" size="10" onblur="this.value=this.value.toUpperCase()">
                            <input type="button" value="<?php echo _('Generate'); ?>" onClick="generateIDajax('family','familyID');">

                            <input type="button" value="<?php echo _('Check'); ?>" onClick="checkIDajax(jQuery('#familyID').val(),'family','checkmsg');">
                            <span id="checkmsg" class="normal"></span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="databack">
            <td class="tngbotshadow">
                <?php echo displayToggle("plus0", 1, "spouses", _('Spouses / Partners'), ""); ?>

                <div id="spouses">
                    <table class="normal topmarginsmall">
                        <tr>
                            <td><span class="normal"><?php echo _('Father'); ?>:</span></td>
                            <td>
                                <input type="text" readonly="readonly" name="husbnameplusid" id="husbnameplusid" size="40" value="<?php echo "$husbstr"; ?>">
                                <input type="hidden" name="husband" id="husband" value="<?php echo $husband; ?>">
                                <input type="button" value="<?php echo _('Find...'); ?>"
                                    onclick="return findItem('I','husband','husbnameplusid','<?php echo $tree; ?>','<?php echo $assignedbranch; ?>');">
                                <input type="button" value="<?php echo _('Create...'); ?>" onclick="return newPerson('M','spouse');">
                                <input type="button" value="  <?php echo _('Edit'); ?>  " onclick="editPerson(document.famform1.husband.value,0,'M');">
                                <input type="button" value="<?php echo _('Remove'); ?>" onclick="removeSpouse(document.famform1.husband,document.famform1.husbnameplusid);">
                            </td>
                        </tr>
                        <tr>
                            <td><span class="normal"><?php echo _('Mother'); ?>:</span></td>
                            <td>
                                <input type="text" readonly readonly="readonly" name="wifenameplusid" id="wifenameplusid" size="40" value="<?php echo "$wifestr"; ?>">
                                <input type="hidden" name="wife" id="wife" value="<?php echo $wife; ?>">
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
                                <input type="checkbox" name="living" value="1" checked="checked"> <?php echo _('Living'); ?>&nbsp;&nbsp;
                                <input type="checkbox" name="private" value="1"> <?php echo _('Private'); ?>
                            </td>
                            <td class="spaceonleft"><?php echo _('Tree') . ": " . $treerow['treename']; ?></td>
                            <td class="spaceonleft"><?php echo _('Branch') . ": "; ?></td>
                            <td style="height:2em;">
                                <?php
                                $query = "SELECT branch, description FROM $branches_table WHERE gedcom = '$tree' ORDER BY description";
                                $branchresult = tng_query($query);
                                $numbranches = tng_num_rows($branchresult);
                                $branchlist = explode(",", $row['branch']);

                                $descriptions = [];
                                $options = "";
                                while ($branchrow = tng_fetch_assoc($branchresult)) {
                                    $options .= "	<option value=\"{$branchrow['branch']}\">{$branchrow['description']}</option>\n";
                                }
                                echo "<span id=\"fbranchlist\"></span>";
                                if (!$assignedbranch) {
                                if ($numbranches > 8) $select = "" . _('(Scroll to see all choices)') . "<br>";
                                $select .= "<select name=\"branch[]\" id=\"fbranch\" multiple size='8'>\n";
                                $select .= "	<option value=\"\"";
                                if ($row['branch'] == "") $select .= " selected";
                                $select .= ">" . _('No Branch') . "</option>\n";
                                $select .= "$options</select>\n";
                                echo " &nbsp;<span class='whitespace-no-wrap'>(<a href='#' onclick=\"showBranchEdit('fbranchedit'); quitBranchEdit('fbranchedit'); return false;\">";
                                echo buildSvgElement("img/chevron-down.svg", ["class" => "w-3 h-3 ml-2 fill-current inline-block"]);
                                echo _('Edit');
                                echo "</a> )</span><br>";
                                ?>
                                <div id="fbranchedit" class="lightback p-1" style="position:absolute;display:none;" onmouseover="clearTimeout(branchtimer);"
                                    onmouseout="closeBranchEdit('fbranch','fbranchedit','fbranchlist');">
                                    <?php
                                    echo $select;
                                    echo "</div>\n";
                                    }
                                    else {
                                        echo "<input type='hidden' name='branch' value=\"$assignedbranch\">";
                                    }
                                    ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
        <tr class="databack">
            <td>
                <?php echo displayToggle("plus1", 1, "events", _('Events'), ""); ?>

                <div id="events">
                    <p class="smallest topmarginsmall"><?php echo _('<strong>Note:</strong> When entering dates, please use the standard genealogical format DD MMM YYYY. For example, 10 Apr 2004.'); ?></p>
                    <table class="normal">
                        <tr>
                            <td>&nbsp;</td>
                            <td><?php echo _('Date'); ?></td>
                            <td><?php echo _('Place'); ?></td>
                            <td colspan="4">&nbsp;</td>
                        </tr>
                        <?php echo showEventRow('marrdate', 'marrplace', 'MARR', ''); ?>
                        <tr>
                            <td><?php echo _('Marriage Type'); ?>:</td>
                            <td colspan="6">
                                <input type="text" value="" name="marrtype" style="width:494px;" maxlength="50">
                            </td>
                        </tr>
                        <?php
                        if (determineLDSRights()) {
                            echo showEventRow('sealdate', 'sealplace', 'SLGS', '');
                        }
                        echo showEventRow('divdate', 'divplace', 'DIV', '');
                        ?>
                    </table>

                </div>
            </td>
        </tr>
    </table>
    <input type="hidden" name="newfamily" value="ajax">
    <input type="hidden" name="tree1" value="<?php echo $tree; ?>">
</form>
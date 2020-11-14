<?php
include "begin.php";
include "adminlib.php";
require_once "./admin/trees.php";

$textpart = "people";
include "$mylanguage/admintext.php";

include "checklogin.php";

if (!$allow_add) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: login.php?message=" . urlencode($message));
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

header("Content-type:text/html; charset=" . $session_charset);

include_once "eventlib.php";
?>

<form action="" method="post" name="persform1" id="persform1" onSubmit="return validatePerson(this);">
    <table class="w-full" cellpadding="10" cellspacing="0">
        <tr class="databack">
            <td class="tngbotshadow">
                <div style="float:right;">
                    <input type="submit" name="submit2" accesskey="s" class="bigsave" value="<?php echo _('Save'); ?>">
                </div>
                <h3 class="subhead togglehead no-underline"><?php echo _('Add New Person'); ?></h3>

                <table class="normal">
                    <tr>
                        <td class="align-top" colspan="2"><span class="normal"><strong><?php echo _('Please prefix Person ID with \"I\" for \"Individual\"'); ?></strong></span></td>
                    </tr>
                    <tr>
                        <td><span class="normal"><?php echo _('Person ID'); ?>:</span></td>
                        <td>
                            <input type="text" name="personID" id="personID" size="10" onBlur="this.value=this.value.toUpperCase()">
                            <input type="button" value="<?php echo _('Generate'); ?>" onClick="generateIDajax('person','personID');">
                            <input type="button" value="<?php echo _('Check'); ?>" onClick="checkIDajax(document.persform1.personID.value,'person','pcheckmsg');">
                            <span id="pcheckmsg" class="normal"></span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="databack">
            <td class="tngbotshadow">
                <?php echo displayToggle("plus0", 1, "names", _('Name'), ""); ?>

                <div id="names">
                    <table class="normal topmarginsmall">
                        <tr>
                            <td><?php echo _('First/Given Name(s)'); ?></td>
                            <?php if ($lnprefixes) echo "<td>" . _('Surname Prefix') . "</td>\n"; ?>
                            <td><?php echo _('Last/Surname'); ?></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="firstname" size="30" id="firstname">
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
                            <td><?php echo _('Name Order'); ?></td>
                        </tr>
                        <tr>
                            <td>
                                <select name="sex">
                                    <option value="U"><?php echo _('Unknown'); ?></option>
                                    <option value="M"<?php if ($gender == "M") {
                                        echo " selected";
                                    } ?>><?php echo _('Male'); ?></option>
                                    <option value="F"<?php if ($gender == "F") {
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
                            <td>
                                <select name="pnameorder">
                                    <option value="0"><?php echo _('Default'); ?></option>
                                    <option value="1"><?php echo _('First name first'); ?></option>
                                    <option value="2"><?php echo _('Surname first (without commas)'); ?></option>
                                    <option value="3"><?php echo _('Surname first (with commas)'); ?></option>
                                </select>
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
                                echo "<span id=\"pbranchlist\"></span>";
                                if (!$assignedbranch) {
                                if ($numbranches > 8) $select = "" . _('(Scroll to see all choices)') . "<br>";
                                $select .= "<select name=\"branch[]\" id=\"pbranch\" multiple size='8'>\n";
                                $select .= "	<option value=\"\"";
                                if ($row['branch'] == "") $select .= " selected";
                                $select .= ">" . _('No Branch') . "</option>\n";
                                $select .= "$options</select>\n";
                                echo " &nbsp;<span class='whitespace-no-wrap'>(<a href='#' onclick=\"showBranchEdit('pbranchedit'); quitBranchEdit('pbranchedit'); return false;\">";
                                echo buildSvgElement("img/chevron-down.svg", ["class" => "w-3 h-3 ml-2 fill-current inline-block"]);
                                echo _('Edit');
                                echo "</a> )</span><br>";
                                ?>
                                <div id="pbranchedit" class="lightback p-1" style="position:absolute;display:none;" onmouseover="clearTimeout(branchtimer);" onmouseout="closeBranchEdit('pbranch','pbranchedit','pbranchlist');">
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
                        <?php
                        echo showEventRow('birthdate', 'birthplace', 'BIRT', '');
                        if (!$tngconfig['hidechr']) {
                            echo showEventRow('altbirthdate', 'altbirthplace', 'CHR', '');
                        }
                        echo showEventRow('deathdate', 'deathplace', 'DEAT', '');
                        echo showEventRow('burialdate', 'burialplace', 'BURI', '');
                        if ($allow_lds) {
                            echo showEventRow('baptdate', 'baptplace', 'BAPL', '');
                            echo showEventRow('confdate', 'confplace', 'CONL', '');
                            echo showEventRow('initdate', 'initplace', 'INIT', '');
                            echo showEventRow('endldate', 'endlplace', 'ENDL', '');
                        }
                        ?>
                    </table>
                </div>
            </td>
        </tr>

    </table>
    <input type="hidden" name="newperson" value="ajax">
    <input type="hidden" name="tree1" value="<?php echo $tree; ?>">
    <input type="hidden" name="familyID" value="<?php echo $familyID; ?>">
    <input type="hidden" name="type" value="<?php echo $type; ?>">
    <?php
    if (!$lnprefixes) {
        echo "<input type='hidden' name='lnprefix' value=\"\">";
    }
    ?>
</form>
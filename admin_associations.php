<?php

include "begin.php";
include "adminlib.php";

include "checklogin.php";
$query = "SELECT firstname, lastname, lnprefix, nameorder, prefix, suffix, branch, living, private, gedcom ";
$query .= "FROM $people_table ";
$query .= "WHERE personID=\"{$personID}\" AND gedcom='$tree'";
$result = tng_query($query);
$row = tng_fetch_assoc($result);

$righttree = checktree($tree);
$rightbranch = $righttree ? checkbranch($row['branch']) : false;
$rights = determineLivingPrivateRights($row, $righttree, $rightbranch);
$row['allow_living'] = $rights['living'];
$row['allow_private'] = $rights['private'];

$namestr = getName($row);
tng_free_result($result);

$helplang = findhelp("assoc_help.php");

header("Content-type:text/html; charset=" . $session_charset);

$query = "SELECT assocID, passocID, relationship, reltype ";
$query .= "FROM $assoc_table ";
$query .= "WHERE personID=\"{$personID}\" AND gedcom='$tree'";
$assocresult = tng_query($query);
$assoccount = tng_num_rows($assocresult);
?>

<div class="databack ajaxwindow" id="associations"<?php if (!$assoccount) {
    echo " style='display: none;'";
} ?>>
    <form name="assocform">
        <h3 class="subhead"><?php echo _('Associations') . ": $namestr"; ?> |
            <a href="#" onclick="return openHelp('<?php echo $helplang; ?>/assoc_help.php');"><?php echo _('Help for this area'); ?></a></h3>
        <p>
            <?php if ($allow_add) { ?>
                <input type="button" value="<?php echo _('Add New'); ?>" onclick="document.newassocform1.reset();assocType='I';gotoSection('associations','addassociation');">&nbsp;
            <?php } ?>
            <input type="button" value="<?php echo _('Finish'); ?>" onclick="tnglitbox.remove();">
        </p>
        <table id="associationstbl" width="95%" class="normal" cellpadding="3" cellspacing="1" border="0"<?php if (!$assoccount) {
            echo " style='display: none;'";
        } ?>>
            <tbody id="associationstblbody">
            <tr>
                <th class="fieldnameback fieldname"><?php echo _('Action'); ?></th>
                <th class="fieldnameback fieldname" width="85%"><?php echo _('Description'); ?></th>
            </tr>
            <?php
            if ($assocresult && $assoccount) {
                while ($assoc = tng_fetch_assoc($assocresult)) {
                    //run query for name or family
                    $assoc['allow_living'] = 1;
                    if ($assoc['reltype'] == "I") {
                        $query = "SELECT firstname, lastname, lnprefix, nameorder, prefix, suffix, living, private, branch ";
                        $query .= "FROM $people_table ";
                        $query .= "WHERE personID=\"{$assoc['passocID']}\" AND gedcom='$tree'";
                        $nameresult = tng_query($query);
                        $row = tng_fetch_assoc($nameresult);
                        $rights = determineLivingPrivateRights($row);
                        $row['allow_living'] = $rights['living'];
                        $row['allow_private'] = $rights['private'];
                        $assocname = getName($row) . " ({$assoc['passocID']})";
                        tng_free_result($nameresult);
                    } else {
                        $query = "SELECT husband, wife, gedcom, familyID, living, private ";
                        $query .= "FROM $families_table ";
                        $query .= "WHERE familyID=\"{$assoc['passocID']}\" AND gedcom='$tree'";
                        $nameresult = tng_query($query);
                        $row = tng_fetch_assoc($nameresult);
                        $rights = determineLivingPrivateRights($row);
                        $row['allow_living'] = $rights['living'];
                        $row['allow_private'] = $rights['private'];
                        $assocname = getFamilyName($row);
                        tng_free_result($nameresult);
                    }
                    $assocname .= ": " . $assoc['relationship'];
                    $assocname = cleanIt($assocname);
                    $truncated = truncateIt($assocname, 75);
                    $actionstr = $allow_edit ? "<a href='#' onclick=\"return editAssociation({$assoc['assocID']});\" title=\"" . _('Edit') . "\" class='smallicon admin-edit-icon'></a>" : "";
                    $actionstr .= $allow_delete ? "<a href='#' onclick=\"return deleteAssociation({$assoc['assocID']},'$personID','$tree');\" title=\"" . _('Delete') . "\" class='smallicon admin-delete-icon'></a>" : "";
                    echo "<tr id=\"row_{$assoc['assocID']}\">";
                    echo "<td class='lightback'>$actionstr</td>";
                    echo "<td class='lightback'>$truncated</td>";
                    echo "</tr>\n";
                }
                tng_free_result($assocresult);
            }
            ?>
            </tbody>
        </table>
    </form>
</div>

<div class="databack ajaxwindow"<?php if ($assoccount) {
    echo " style='display: none;'";
} ?> id="addassociation">
    <h3 class="subhead"><?php echo _('Add New Association'); ?> |
        <a href="#"
            onclick="return openHelp('<?php echo $helplang; ?>/assoc_help.php#add', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();"><?php echo _('Help for this area'); ?></a>
    </h3>

    <form action="" name="newassocform1" onSubmit="return addAssociation(this);">
        <table width="95%" cellpadding="2" class="normal">
            <tr>
                <td colspan="2">
                    <input type="radio" name="reltype" value="I" checked="checked" onclick="activateAssocType('I');"> <?php echo _('Person'); ?> &nbsp;&nbsp;
                    <input type="radio" name="reltype" value="F" onclick="activateAssocType('F');"> <?php echo _('Family'); ?>
                </td>
            </tr>
            <tr>
                <td><span id="person_label"><?php echo _('Person ID'); ?></span><span id="family_label" style="display:none;"><?php echo _('Family ID'); ?></span>:</td>
                <td class='align-top'>
                    <input type="text" name="passocID" id="passocID"> &nbsp;<?php echo _('OR'); ?>&nbsp;
                    <a href="#" onclick="return findItem(assocType,'passocID',null,'<?php echo $tree; ?>','<?php echo $assignedbranch; ?>');" title="<?php echo _('Find...'); ?>">
                        <img src="img/tng_find.gif" title="<?php echo _('Find...'); ?>" alt="<?php echo _('Find...'); ?>" class="align-middle" width="20" height="20">
                    </a>
                </td>
            </tr>
            <tr>
                <td><?php echo _('Relationship'); ?>:</td>
                <td>
                    <input type="text" name="relationship" size="60">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="checkbox" name="revassoc" value="1"> <?php echo _('Also add reverse association for same two people'); ?>:
                </td>
            </tr>
            </tr>
        </table>
        <input type="hidden" name="personID" value="<?php echo $personID; ?>">
        <input type="hidden" name="orgreltype" value="<?php echo $orgreltype; ?>">
        <input type="hidden" name="tree" value="<?php echo $tree; ?>">
        <input type="submit" name="submit" class="btn" value="<?php echo _('Save'); ?>">
        <input type="button" name="cancel" class="btn" value="<?php echo _('Cancel'); ?>" onclick="gotoSection('addassociation','associations');">
    </form>
    <br>
</div>

<div class="databack ajaxwindow" style="display:none;" id="editassociation">
</div>
<?php

include "begin.php";
include "adminlib.php";
$textpart = "people";
include "$mylanguage/admintext.php";

include "checklogin.php";
if (!$allow_edit) {
    $message = $admtext['norights'];
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$query = "SELECT passocID, relationship, reltype, gedcom ";
$query .= "FROM {$assoc_table} ";
$query .= "WHERE assocID = \"{$assocID}\"";
$result = tng_query($query);
$row = tng_fetch_assoc($result);
tng_free_result($result);
$row['relationship'] = preg_replace("/\"/", "&#34;", $row['relationship']);

$helplang = findhelp("assoc_help.php");

header("Content-type:text/html; charset=" . $session_charset);
?>

<p class="subhead"><strong><?php echo $admtext['modifyassoc']; ?></strong> |
    <a href="#" onclick="return openHelp('<?php echo $helplang; ?>/assoc_help.php#add', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();"><?php echo $admtext['help']; ?></a>
</p>

<form action="" name="findassocform1" onSubmit="return updateAssociation(this);">
    <table width="100%" cellpadding="2" class="normal">
        <tr>
            <td colspan="2">
                <input type="radio" name="reltype" value="I"<?php if ($row['reltype'] == "I") {
                    echo " checked=\"checked\"";
                } ?> onclick="activateAssocType('I');"> <?php echo $admtext['person']; ?> &nbsp;&nbsp;
                <input type="radio" name="reltype" value="F"<?php if ($row['reltype'] == "F") {
                    echo " checked=\"checked\"";
                } ?> onclick="activateAssocType('F');"> <?php echo $admtext['family']; ?>
            </td>
        </tr>
        <tr>
            <td>
                <span id="person_label"<?php if ($row['reltype'] == "F") {
                    echo " style=\"display:none\"";
                } ?>><?php echo $admtext['personid']; ?></span>
                <span id="family_label"<?php if ($row['reltype'] == "I") {
                    echo " style=\"display:none\"";
                } ?>><?php echo $admtext['familyid']; ?></span>:
            </td>
            <td valign="top">
                <input type="text" name="passocID" value="<?php echo $row['passocID']; ?>"> &nbsp;<?php echo $admtext['text_or']; ?>&nbsp;
                <a href="#" onclick="return findItem(assocType,'passocID','<?php echo $tree; ?>','<?php echo $assignedbranch; ?>');">
                    <img src="img/tng_find.gif" title="<?php echo $admtext['find']; ?>" alt="<?php echo $admtext['find']; ?>" class="alignmiddle" width="20" height="20" border="0" vspace="0" hspace="2">
                </a>
            </td>
        </tr>
        <tr>
            <td valign="top"><span class="normal"><?php echo $admtext['relationship']; ?>:</span></td>
            <td><input type="text" name="relationship" size="60" value="<?php echo $row['relationship']; ?>"></td>
        </tr>
    </table>
    <input type="hidden" name="assocID" value="<?php echo $assocID; ?>">
    <input type="hidden" name="tree" value="<?php echo $row['gedcom']; ?>">
    <input type="submit" name="submit" class="btn" value="<?php echo $admtext['save']; ?>">
</form>
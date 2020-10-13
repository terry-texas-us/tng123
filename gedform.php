<?php
$textpart = "gedcom";
include "tng_begin.php";

$result = getPersonDataPlusDates($tree, $personID);
if ($result) {
    $row = tng_fetch_assoc($result);
    $righttree = checktree($tree);
    $rightbranch = checkbranch($row['branch']);
    $rights = determineLivingPrivateRights($row, $righttree, $rightbranch);
    $row['allow_living'] = $rights['living'];
    $row['allow_private'] = $rights['private'];
    $name = getName($row);
    tng_free_result($result);
}

$treeResult = getTreeSimple($tree);
$treerow = tng_fetch_assoc($treeResult);
$disallowgedcreate = $row['disallowgedcreate'];
tng_free_result($treeResult);

if (($disallowgedcreate && (!$allow_ged || !$rightbranch)) || !$personID) {
    header("location:$homepage");
    exit;
}

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

$flags['scripting'] = "<script>
function validateForm() {
	if( document.gedform.email.value == \"\" ) {
		alert('{$text['enteremail']}');
		return false;
	}
	else return true;
}
</script>\n";

tng_header($text['creategedfor'] . ": {$text['gedstartfrom']} $name", $flags);

$photostr = showSmallPhoto($personID, $name, $rights['both'], 0, false, $row['sex']);
echo tng_DrawHeading($photostr, $name, getYears($row));

$innermenu = "&nbsp; \n";

echo tng_menu("I", "gedcom", $personID, $innermenu);

echo "<h3 class='subhead'>{$text['creategedfor']}</h3>\n";

if ($currentuser) {
    $formstr = getFORM("gedcom", "GET", "gedform", "");
} else {
    $formstr = getFORM("gedcom", "GET\" onsubmit=\"return validateForm();", "gedform", "");
}
echo $formstr;
?>
    <input type="hidden" name="personID" value="<?php echo $personID; ?>">
    <input type="hidden" name="tree" value="<?php echo $tree; ?>">
    <table cellspacing="1" cellpadding="4" class="whiteback">
        <tr>
            <td class="fieldnameback" width="30%"><span class="fieldname"><?php echo $text['gedstartfrom']; ?>:&nbsp; </span></td>
            <td class="databack" width="70%"><span class="normal"><?php echo $name; ?></span></td>
        </tr>
        <?php if (!$currentuser) { ?>
            <tr>
                <td class="fieldnameback"><span class="fieldname"><?php echo $text['email']; ?>:&nbsp; </span></td>
                <td class="databack"><span class="normal"><input name="email" type="text" size="20"></span></td>
            </tr>
        <?php } ?>
        <tr>
            <td class="fieldnameback"><span class="fieldname"><?php echo $text['producegedfrom']; ?>:&nbsp; </span></td>
            <td class="databack">
                <span class="normal">
                    <select name="type">
                        <option value="<?php echo $text['ancestors']; ?>" selected><?php echo $text['ancestors']; ?></option>
                        <option value="<?php echo $text['descendants']; ?>"><?php echo $text['descendants']; ?></option>
                    </select>
                </span>
            </td>
        </tr>
        <tr>
            <td class="fieldnameback"><span class="fieldname"><?php echo $text['numgens']; ?>:&nbsp; </span></td>
            <td class="databack"><span class="normal">
<select name="maxgcgen">
<?php
if ($maxgedcom < 1) {
    $maxgedcom = 1;
}
for ($i = 1; $i <= $maxgedcom; $i++)
    echo "<option value=\"$i\">$i</option>\n";
?>
</select>
</span></td>
        </tr>
        <?php if ($rights['lds']) { ?>
            <tr>
                <td class="fieldnameback">&nbsp;</td>
                <td class="databack"><span class="normal"><input type="checkbox" name="lds" value="yes"> <?php echo $text['includelds']; ?></span></td>
            </tr>
        <?php } ?>
    </table>
<?php
if ($currentuser) {
    echo "<input type='hidden' name=\"email\" value=\"$currentuserdesc\">";
}
?>
    <br>
    <input type="submit" class="btn" value="<?php echo $text['buildged']; ?>">
    </form>
    <br>
<?php
tng_footer("");
?>
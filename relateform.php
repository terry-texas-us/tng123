<?php
$textpart = "relate";
include "tng_begin.php";

include "config/pedconfig.php";

$relatepersonID = $_SESSION['relatepersonID'];
$relatetreeID = $_SESSION['relatetreeID'];

$result = getPersonDataPlusDates($tree, $primaryID);
if ($result) {
    $row = tng_fetch_assoc($result);
    $righttree = checktree($tree);
    $rightbranch = checkbranch($row['branch']);
    $rights = determineLivingPrivateRights($row, $righttree, $rightbranch);
    $row['allow_living'] = $rights['living'];
    $row['allow_private'] = $rights['private'];
    if ($rights['both']) {
        $birthdate = "";
        if ($row['birthdate']) {
            $birthdate = "" . _('b.') . " " . displayDate($row['birthdate']);
        } else {
            if ($row['altbirthdate']) {
                $birthdate = "" . _('c.') . " " . displayDate($row['altbirthdate']);
            }
        }
        if ($birthdate) $birthdate = "($birthdate)";

        $namestrplus = " $birthdate - $primaryID";
    } else {
        $namestrplus = " - $primaryID";
    }
    $namestr = getName($row);

    $treeResult = getTreeSimple($tree);
    $treerow = tng_fetch_assoc($treeResult);
    $disallowgedcreate = $treerow['disallowgedcreate'];
    tng_free_result($treeResult);

    tng_free_result($result);
}

$personID = preg_replace("/[^A-Za-z0-9_\-. ]/", '', $primaryID);

$flags['scripting'] = "<script src=\"js/selectutils.js\"></script>\n";

tng_header(_('Relationship Calculator'), $flags);

$photostr = showSmallPhoto($primaryID, $namestr, $rights['both'], 0, false, $row['sex']);
echo tng_DrawHeading($photostr, $namestr, getYears($row));

$innermenu = "&nbsp; \n";

echo tng_menu("I", "relate", $primaryID, $innermenu);

$namestr .= $namestrplus;

echo getFORM("relationship", "get", "form1", "form1", "$('calcbtn').className='fieldnamebacksave';");

$maxupgen = $pedigree['maxupgen'] ? $pedigree['maxupgen'] : 15;
$newstr = preg_replace("/xxx/", $maxupgen, _('To display the relationship between two people, use the \'Find\' buttons below to locate the individuals (or keep the people displayed), then click \'Calculate\'.'));
?>
    <h3 class="subhead"><?php echo _('Find Relationship'); ?></h3>
    <p><span class="normal"><?php echo $newstr; ?></span></p>
    <table class="normal">
        <tr>
            <td class='align-top'>
                <table>
                    <tr>
                        <td><span class="normal"><strong><?php echo _('Person 1:'); ?> </strong></span></td>
                        <td>
                            <div id="name1" class="normal"><?php echo $namestr; ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="normal"><?php echo _('Change to (enter the ID):'); ?> </span></td>
                        <td><span class="normal">
						<input type="text" name="altprimarypersonID" id="altprimarypersonID" size="10">  <input type="button" name="find1" value="<?php echo _('Find...'); ?>" onclick="findItem('I','altprimarypersonID','name1','<?php echo $tree; ?>');">
					</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><span class="normal"><strong><?php echo _('Person 2:'); ?> </strong></span></td>
                        <td>
                            <?php
                            if ($relatepersonID && $relatetreeID == $tree) {
                                $query = "SELECT firstname, lastname, lnprefix, prefix, suffix, nameorder, living, private, branch, birthdate, altbirthdate FROM $people_table WHERE personID = \"$relatepersonID\" AND gedcom = '$tree'";
                                $result2 = tng_query($query);
                                if ($result2) {
                                    $row2 = tng_fetch_assoc($result2);
                                    $rights2 = determineLivingPrivateRights($row2, $righttree);
                                    $row2['allow_living'] = $rights2['living'];
                                    $row2['allow_private'] = $rights2['private'];
                                    if ($row2['allow_living']) {
                                        $birthdate = $row2['birthdate'] ? $row2['birthdate'] : $row2['altbirthdate'];
                                        $birthdate = " ($birthdate)";
                                    } else {
                                        $birthdate = "";
                                    }
                                    $namestr2 = getName($row2) . "$birthdate - $relatepersonID";
                                    tng_free_result($result2);
                                }
                            }
                            echo "<div id=\"name2\" class='normal'>$namestr2</div><input type='hidden' name=\"savedpersonID\" value=\"$relatepersonID\"></td></tr>\n";
                            echo "<tr>";
                            echo "<td><span class='normal'>" . _('Change to (enter the ID):') . " </span></td>";
                            echo "<td>";
                            ?>
                            <input type="text" name="secondpersonID" id="secondpersonID" size="10">
                            <input type="button" name="find2" value="<?php echo _('Find...'); ?>"
                                onclick="findItem('I','secondpersonID','name2','<?php echo $tree; ?>');">
                        </td>
                    </tr>
                </table>
            </td>
            <td class='align-top'>
                <div class="searchsidebar">
                    <table>
                        <tr>
                            <td><?php echo _('Max Relationships'); ?>:</td>
                            <td class="align-bottom">
                                <select name="maxrels">
                                    <?php
                                    $initrels = $pedigree['initrels'] ? $pedigree['initrels'] : 1;
                                    $maxrels = $pedigree['maxrels'] ? $pedigree['maxrels'] : 15;
                                    $dorels = $dorels ? $dorels : $initrels;
                                    for ($i = 1; $i <= $maxrels; $i++) {
                                        echo "<option value=\"$i\"";
                                        if ($i == $dorels) echo " selected";

                                        echo ">$i</option>\n";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td><?php echo _('Show relationships involving a spouse'); ?>:&nbsp;</td>
                            <td class="align-bottom">
                                <select name="disallowspouses">
                                    <?php
                                    $dospouses = $dospouses ? $dospouses : 1;
                                    echo "<option value='0'";
                                    if ($dospouses) echo " selected";

                                    echo ">" . _('Yes') . "</option>\n";
                                    echo "<option value='1'";
                                    if (!$dospouses) echo " selected";

                                    echo ">" . _('No') . "</option>\n";
                                    ?>
                                </select> <?php //echo _('(Sometimes checking over a different number of generations yields a different result.)'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td><?php echo _('Maximum generations to check'); ?>:</td>
                            <td class="align-bottom">
                                <select name="generations">
                                    <?php
                                    $dogens = $dogens ? $dogens : $pedigree['maxupgen'];
                                    $maxgens = $pedigree['maxupgen'] ? $pedigree['maxupgen'] : 15;
                                    for ($i = 1; $i <= $maxgens; $i++) {
                                        echo "<option value=\"$i\"";
                                        if ($i == $dogens) echo " selected";

                                        echo ">$i</option>\n";
                                    }
                                    ?>
                                </select> <?php //echo _('(Sometimes checking over a different number of generations yields a different result.)'); ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
    <br>
    <input type="hidden" name="tree" value="<?php echo $tree; ?>">
    <input type="hidden" name="primarypersonID" id="primarypersonID" value="<?php echo $primaryID; ?>">
    <input type="submit" value="<?php echo _('Calculate'); ?>" id="calcbtn" class="btn" <?php if (!$relatepersonID) {
        echo "onclick=\"if( form1.secondpersonID.value.length == 0 ) {alert('" . _('Please select two individuals.') . "'); return false;}\"";
    } ?> >
    <br><br>
    </form>
<?php
tng_footer("");
?>
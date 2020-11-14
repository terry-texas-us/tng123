<?php
include "begin.php";
include "adminlib.php";
$textpart = "reports";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_add) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$dontdo = ["ADDR", "BIRT", "CHR", "DEAT", "BURI", "NAME", "NICK", "TITL", "NSFX", "NPFX"];

$dfields = [];
$dfields['personID'] = "personid";
$dfields['fullname'] = "fullname";
$dfields['lastfirst'] = "lastfirst";
$dfields['firstname'] = "firstname";
$dfields['lastname'] = "lastname";
$dfields['nickname'] = "nickname";
$dfields['birthdate'] = "birthdate";
$dfields['birthplace'] = "birthplace";
if (!$tngconfig['hidechr']) {
    $dfields['altbirthdate'] = "chrdate";
    $dfields['altbirthplace'] = "chrplace";
}
$dfields['marrdate'] = "marriagedate";
$dfields['marrplace'] = "marriageplace";
$dfields['divdate'] = "divdate";
$dfields['divplace'] = "divplace";
$dfields['spouseid'] = "spouseid";
$dfields['spousename'] = "spousename";
$dfields['deathdate'] = "deathdate";
$dfields['deathplace'] = "deathplace";
$dfields['burialdate'] = "burialdate";
$dfields['burialplace'] = "burialplace";
$dfields['changedate'] = "lastmodified";
$dfields['sex'] = "sex";
$dfields['title'] = "title";
$dfields['prefix'] = "prefix";
$dfields['suffix'] = "suffix";
$dfields['gedcom'] = "tree";
if ($allow_lds) {
    $dfields['baptdate'] = "ldsbapldate";
    $dfields['baptplace'] = "ldsbaplplace";
    $dfields['confdate'] = "ldsconfdate";
    $dfields['confplace'] = "ldsconfplace";
    $dfields['initdate'] = "ldsinitdate";
    $dfields['initplace'] = "ldsinitplace";
    $dfields['endldate'] = "ldsendldate";
    $dfields['endlplace'] = "ldsendlplace";
    $dfields['ssealdate'] = "ldssealsdate";
    $dfields['ssealplace'] = "ldssealsplace";
    $dfields['psealdate'] = "ldssealpdate";
    $dfields['psealplace'] = "ldssealpplace";
}

$cfields = [];
$cfields['personID'] = "personid";
$cfields['firstname'] = "firstname";
$cfields['lastname'] = "lastname";
$cfields['lnprefix'] = "lnprefix";
$cfields['nickname'] = "nickname";
$cfields['monthonly'] = "monthonlyfrom";
$cfields['yearonly'] = "yearonlyfrom";
$cfields['dayonly'] = "dayonlyfrom";
$cfields['desc'] = "desc";
$cfields['birthdate'] = "birthdate";
$cfields['birthdatetr'] = "birthdatetr";
$cfields['birthplace'] = "birthplace";
if (!$tngconfig['hidechr']) {
    $cfields['altbirthdate'] = "chrdate";
    $cfields['altbirthdatetr'] = "chrdatetr";
    $cfields['altbirthplace'] = "chrplace";
}
$cfields['marrdate'] = "marriagedate";
$cfields['marrdatetr'] = "marriagedatetr";
$cfields['marrplace'] = "marriageplace";
$cfields['divdate'] = "divdate";
$cfields['divdatetr'] = "divdatetr";
$cfields['divplace'] = "divplace";
$cfields['deathdate'] = "deathdate";
$cfields['deathdatetr'] = "deathdatetr";
$cfields['deathplace'] = "deathplace";
$cfields['burialdate'] = "burialdate";
$cfields['burialdatetr'] = "burialdatetr";
$cfields['burialplace'] = "burialplace";
$cfields['changedate'] = "lastmodified";
$cfields['sex'] = "sex";
$cfields['title'] = "title";
$cfields['prefix'] = "prefix";
$cfields['suffix'] = "suffix";
$cfields['gedcom'] = "tree";
if ($allow_lds) {
    $cfields['baptdate'] = "ldsbapldate";
    $cfields['baptdatetr'] = "ldsbapldatetr";
    $cfields['baptplace'] = "ldsbaplplace";
    $cfields['confdate'] = "ldsconfdate";
    $cfields['confdatetr'] = "ldsconfdatetr";
    $cfields['confplace'] = "ldsconfplace";
    $cfields['initdate'] = "ldsinitdate";
    $cfields['inittdatetr'] = "ldsinitdatetr";
    $cfields['initplace'] = "ldsinitplace";
    $cfields['endldate'] = "ldsendldate";
    $cfields['endldatetr'] = "ldsendldatetr";
    $cfields['endlplace'] = "ldsendlplace";
    $cfields['ssealdate'] = "ldssealsdate";
    $cfields['ssealdatetr'] = "ldssealsdatetr";
    $cfields['ssealplace'] = "ldssealsplace";
    $cfields['psealdate'] = "ldssealpdate";
    $cfields['psealdatetr'] = "ldssealpdatetr";
    $cfields['psealplace'] = "ldssealpplace";
}

$ofields = [];
$ofields['contains'] = "contains";
$ofields['starts with'] = "startswith";
$ofields['ends with'] = "endswith";
$ofields['OR'] = "text_or";
$ofields['AND'] = "text_and";
$ofields['currmonth'] = "currentmonth";
$ofields['currmonthnum'] = "currentmonthnum";
$ofields['curryear'] = "currentyear";
$ofields['currday'] = "currentday";
$ofields['today'] = "today";
$ofields['to_days'] = "convtodays";

$subtypes = [];
$subtypes['dt'] = _('Date');
$subtypes['tr'] = _('Date (True)');
$subtypes['pl'] = _('Place');
$subtypes['fa'] = _('Fact');

$cetypes = [];
$query = "SELECT eventtypeID, tag, display FROM $eventtypes_table WHERE keep='1' AND type=\"I\" ORDER BY display";
$ceresult = tng_query($query);
while ($cerow = tng_fetch_assoc($ceresult)) {
    if (!in_array($cerow['tag'], $dontdo)) {
        $eventtypeID = $cerow['eventtypeID'];
        $cetypes[$eventtypeID] = $cerow;
    }
}

$helplang = findhelp("reports_help.php");

tng_adminheader(_('Add New Report'), $flags);
?>
    <script src="js/selectutils.js"></script>
    <script src="js/reports.js"></script>
    <script>
        function validateForm() {
            let rval = true;
            if (document.form1.reportname.value.length == 0) {
                alert("<?php echo _('Please enter a Report Name.'); ?>");
                rval = false;
            } else if (document.form1.displayfields.options.length == 0 && document.form1.sqlselect.value.length == 0) {
                alert("<?php echo _('Please select at least one display field.'); ?>");
                rval = false;
            }
            if (rval) finishValidation();
            return rval;
        }
    </script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$reporttabs[0] = [1, "admin_reports.php", _('Search'), "findreport"];
$reporttabs[1] = [$allow_add, "admin_newreport.php", _('Add New'), "addreport"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/reports_help.php#add');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($reporttabs, "addreport", $innermenu);
echo displayHeadline(_('Reports') . " &gt;&gt; " . _('Add New Report'), "img/reports_icon.gif", $menu, $message);
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <form action="admin_addreport.php" method="post" name="form1" id="form1" onSubmit="return validateForm();">
                    <table>
                        <tr>
                            <td><span class="normal"><?php echo _('Report Name'); ?>:</span></td>
                            <td>
                                <input type="text" name="reportname" size="50" maxlength="80">
                            </td>
                        </tr>
                        <tr>
                            <td class='align-top'><span class="normal"><?php echo _('Description'); ?>:</span></td>
                            <td><textarea cols="50" rows="3" name="reportdesc"></textarea></td>
                        </tr>
                        <tr>
                            <td class='align-top'><span class="normal"><?php echo _('Rank/Priority'); ?>:</span></td>
                            <td>
                                <input type="text" name="ranking" size="3" maxlength="3" value="1">
                            </td>
                        </tr>
                        <tr>
                            <td class='align-top'><span class="normal"><?php echo _('Active'); ?>:</span></td>
                            <td><span class="normal"><input type="radio" name="active" value="1"> <?php echo _('Yes'); ?> &nbsp; <input type="radio" name="active" value="0"
                                        checked> <?php echo _('No'); ?></span></td>
                        </tr>
                        <tr>
                            <td class="align-top" colspan="2"><span class="normal"><br>
	                        <img src="img/tng_right.gif" width="17" height="15" align="middle"> = <?php echo _('Add'); ?> &nbsp;&nbsp;
	                        <img src="img/tng_left.gif" width="17" height="15" align="middle"> = <?php echo _('Remove'); ?> &nbsp;&nbsp;
	                        <img src="img/tng_up.gif" width="17" height="15" align="middle"> = <?php echo _('Move Up'); ?> &nbsp;&nbsp;
	                        <img src="img/tng_down.gif" width="17" height="15" align="middle"> = <?php echo _('Move Down'); ?> &nbsp;&nbsp;</span><br><br>
                                <h3 class="subhead"><?php echo _('Choose Fields to Display'); ?>:</h3>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-top" colspan="2">
                                <table cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td class='align-top'>
                                            <select name="availfields" size="15" class="reportcol" onDblClick="AddtoDisplay(document.form1.availfields,document.form1.displayfields);">
                                                <?php
                                                foreach ($dfields as $key => $value)
                                                echo "<option value=\"$key\">{$admtext[$value]}</option>\n";
                                            //now do custom event types
                                            foreach ($cetypes as $cerow) {
                                                $displaymsg = getEventDisplay($cerow['display']);
                                                echo "<option value=\"ce_dt_{$cerow['eventtypeID']}\">$displaymsg: " . _('Date') . "</option>\n";
                                                echo "<option value=\"ce_pl_{$cerow['eventtypeID']}\">$displaymsg: " . _('Place') . "</option>\n";
                                                echo "<option value=\"ce_fa_{$cerow['eventtypeID']}\">$displaymsg: " . _('Fact') . "</option>\n";
                                            }
                                                ?>
                                            </select>
                                        </td>
                                        <td width="40" align="center">
                                            &nbsp;<a href="javascript:AddtoDisplay(document.form1.availfields,document.form1.displayfields);"><img src="img/tng_right.gif"
                                                    alt="<?php echo _('Add'); ?>" width="17"
                                                    height="15"></a>&nbsp;<br><br>
                                            &nbsp;<a href="javascript:RemovefromDisplay(document.form1.displayfields);"><img src="img/tng_left.gif" alt="<?php echo _('Remove'); ?>" width="17"
                                                    height="15"></a>&nbsp;
                                        </td>
                                        <td class='align-top'>
                                            <select name="displayfields" size="15" class="reportcol" onDblClick="RemovefromDisplay(document.form1.displayfields);">
                                            </select><br><br>
                                        </td>
                                        <td>
                                            &nbsp;&nbsp;&nbsp;<a href="javascript:Move(document.form1.displayfields,1);"><img src="img/tng_up.gif" alt="<?php echo _('Move Up'); ?>" width="17"
                                                    height="15"></a>&nbsp;<br><br>
                                            &nbsp;&nbsp;&nbsp;<a href="javascript:RemovefromDisplay(document.form1.displayfields);"><img src="img/tng_left.gif" alt="<?php echo _('Remove'); ?>"
                                                    width="17" height="15"></a>&nbsp;<br><br>
                                            &nbsp;&nbsp;&nbsp;<a href="javascript:Move(document.form1.displayfields,0);"><img src="img/tng_down.gif" alt="<?php echo _('Move Down'); ?>"
                                                    width="17" height="15"></a>&nbsp;<br><br>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-top" colspan="2">
                                <h3 class="subhead"><?php echo _('Choose Criteria'); ?>:</h3>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-top" colspan="2">
                                <table cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td class='align-top'>
                                            <select name="availcriteria" size="12" class="reportcol" onDblClick="AddtoDisplay(document.form1.availcriteria,document.form1.finalcriteria);">
                                                <?php
                                                foreach ($cfields as $key => $value) {
                                                    if ($key != "desc") {
                                                        echo "<option value=\"$key\">{$admtext[$value]}</option>\n";
                                                    }
                                                }
                                                echo "<option value=\"living\">" . _('Living = yes') . "</option>\n";
                                                echo "<option value=\"dead\">" . _('Living = no') . "</option>\n";
                                                echo "<option value=\"private\">" . _('Private = yes') . "</option>\n";
                                                echo "<option value=\"open\">" . _('Private = no') . "</option>\n";

                                                //now do custom event types, prefix with "ce_"
                                                foreach ($cetypes as $cerow) {
                                                    $displaymsg = getEventDisplay($cerow['display']);
                                                    echo "<option value=\"ce_dt_{$cerow['eventtypeID']}\">$displaymsg: " . _('Date') . "</option>\n";
                                                    echo "<option value=\"ce_tr_{$cerow['eventtypeID']}\">$displaymsg: " . _('Date (True)') . "</option>\n";
                                                    echo "<option value=\"ce_pl_{$cerow['eventtypeID']}\">$displaymsg: " . _('Place') . "</option>\n";
                                                    echo "<option value=\"ce_fa_{$cerow['eventtypeID']}\">$displaymsg: " . _('Fact') . "</option>\n";
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td width="40" align="center">
                                            &nbsp;<a href="javascript:AddtoDisplay(document.form1.availcriteria,document.form1.finalcriteria);"><img src="img/tng_right.gif"
                                                    alt="<?php echo _('Add'); ?>" width="17"
                                                    height="15"
                                                    border="0"></a>&nbsp;<br><br>
                                            &nbsp;<a href="javascript:RemovefromDisplay(document.form1.finalcriteria);"><img src="img/tng_left.gif" alt="<?php echo _('Remove'); ?>" width="17"
                                                    height="15"></a>&nbsp;
                                        </td>
                                        <td class="align-top" rowspan="4">
                                            <select name="finalcriteria" size="28" class="reportcol" onDblClick="RemovefromDisplay(document.form1.finalcriteria);">
                                            </select>
                                        </td>
                                        <td width="40" align="center" rowspan="4">
                                            &nbsp;<a href="javascript:Move(document.form1.finalcriteria,1);"><img src="img/tng_up.gif" alt="<?php echo _('Move Up'); ?>" width="17"
                                                    height="15"></a>&nbsp;<br><br>
                                            &nbsp;<a href="javascript:RemovefromDisplay(document.form1.finalcriteria);"><img src="img/tng_left.gif" alt="<?php echo _('Remove'); ?>" width="17"
                                                    height="15"></a>&nbsp;<br><br>
                                            &nbsp;<a href="javascript:Move(document.form1.finalcriteria,0);"><img src="img/tng_down.gif" alt="<?php echo _('Move Down'); ?>" width="17"
                                                    height="15"></a>&nbsp;<br><br><br><br><br><br><br><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='align-top'>
                                            <span class="normal"><?php echo _('Operators'); ?>:<br></span>
                                            <select name="availoperators" size="8" class="reportcol" onDblClick="AddtoDisplay(document.form1.availoperators,document.form1.finalcriteria);">
                                                <option value="eq">=</option>
                                                <option value="neq">!=</option>
                                                <option value="gt">&gt;</option>
                                                <option value="gte">&gt;=</option>
                                                <option value="lt">&lt;</option>
                                                <option value="lte">&lt;=</option>
                                                <?php
                                                foreach ($ofields as $key => $value)
                                                    echo "<option value=\"$key\">{$admtext[$value]}</option>\n";
                                                ?>
                                                <option value="(">(</option>
                                                <option value=")">)</option>
                                                <option value="+">+</option>
                                                <option value="-">-</option>
                                            </select>
                                        </td>
                                        <td width="40" align="center">
                                            &nbsp;<a href="javascript:AddtoDisplay(document.form1.availoperators,document.form1.finalcriteria);"><img src="img/tng_right.gif"
                                                    alt="<?php echo _('Add'); ?>" width="17"
                                                    height="15"></a>&nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='align-top'>
                                            <span class="normal"><?php echo _('Constant String'); ?>:*<br></span>
                                            <input type="text" name="constantstring" size="20">
                                        </td>
                                        <td width="40" align="center"><br>
                                            &nbsp;<a href="javascript:AddConstant(document.form1.constantstring,document.form1.finalcriteria,1);"><img src="img/tng_right.gif"
                                                    alt="<?php echo _('Add'); ?>" width="17"
                                                    height="15"></a>&nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='align-top'>
                                            <span class="normal"><?php echo _('Constant Value'); ?>:<br></span>
                                            <input type="text" name="constantvalue" size="20">
                                        </td>
                                        <td width="40" align="center"><br>
                                            &nbsp;<a href="javascript:AddConstant(document.form1.constantvalue,document.form1.finalcriteria,0);"><img src="img/tng_right.gif"
                                                    alt="<?php echo _('Add'); ?>" width="17"
                                                    height="15"></a>&nbsp;
                                        </td>
                                    </tr>
                                </table>
                                <span class="normal">*<?php echo _('For an empty string, leave this field blank and click \"Add >>.\"'); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-top" colspan="2"><br>
                                <h3 class="subhead"><?php echo _('Choose Sort Fields'); ?>:</h3>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-top" colspan="2">
                                <table cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td class='align-top'>
                                            <select name="availsort" size="10" class="reportcol" onDblClick="AddtoDisplay(document.form1.availsort,document.form1.finalsort);">
                                                <?php
                                                foreach ($cfields as $key => $value)
                                                echo "<option value=\"$key\">{$admtext[$value]}</option>\n";
                                            //now do custom event types, prefix with "ce_"
                                            foreach ($cetypes as $cerow) {
                                                $displaymsg = getEventDisplay($cerow['display']);
                                                echo "<option value=\"ce_dt_{$cerow['eventtypeID']}\">$displaymsg: " . _('Date') . "</option>\n";
                                                echo "<option value=\"ce_tr_{$cerow['eventtypeID']}\">$displaymsg: " . _('Date (True)') . "</option>\n";
                                                echo "<option value=\"ce_pl_{$cerow['eventtypeID']}\">$displaymsg: " . _('Place') . "</option>\n";
                                                echo "<option value=\"ce_fa_{$cerow['eventtypeID']}\">$displaymsg: " . _('Fact') . "</option>\n";
                                            }
                                                ?>
                                            </select>
                                        </td>
                                        <td width="40" align="center">
                                            &nbsp;<a href="javascript:AddtoDisplay(document.form1.availsort,document.form1.finalsort);"><img src="img/tng_right.gif"
                                                    alt="<?php echo _('Add'); ?>" width="17"
                                                    height="15"></a>&nbsp;<br><br>
                                            &nbsp;<a href="javascript:RemovefromDisplay(document.form1.finalsort);"><img src="img/tng_left.gif" alt="<?php echo _('Remove'); ?>" width="17"
                                                    height="15"></a>&nbsp;
                                        </td>
                                        <td class='align-top'>
                                            <select name="finalsort" size="10" class="reportcol" onDblClick="RemovefromDisplay(document.form1.finalsort);">
                                            </select>
                                        </td>
                                        <td width="40" align="center">
                                            &nbsp;<a href="javascript:Move(document.form1.finalsort,1);"><img src="img/tng_up.gif" alt="<?php echo _('Move Up'); ?>" width="17" height="15"></a>&nbsp;<br><br>
                                            &nbsp;<a href="javascript:RemovefromDisplay(document.form1.finalsort);"><img src="img/tng_left.gif" alt="<?php echo _('Remove'); ?>" width="17"
                                                    height="15"></a>&nbsp;<br><br>
                                            &nbsp;<a href="javascript:Move(document.form1.finalsort,0);"><img src="img/tng_down.gif" alt="<?php echo _('Move Down'); ?>" width="17"
                                                    height="15"></a>&nbsp;
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-top" colspan="2"><span class="normal"><br><b><?php echo _('OR Leave Display, Criteria and Sort fields blank and enter direct SQL SELECT statement here'); ?>:</b><br></span></td>
                        </tr>
                        <tr>
                            <td class="align-top" colspan="2"><textarea cols="60" rows="4" name="sqlselect"></textarea></td>
                        </tr>
                    </table>
                    <br>
                    <input type="hidden" name="display" value="">
                    <input type="hidden" name="criteria" value="">
                    <input type="hidden" name="orderby" value="">
                    <input type="submit" name="submit" class="btn" value="<?php echo _('Save Report'); ?>">
                    <input type="submit" name="submitx" class="btn" value="<?php echo _('Save and Exit'); ?>">
                </form>
            </td>
        </tr>

    </table>

<?php echo tng_adminfooter(); ?>
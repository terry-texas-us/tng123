<?php
include "begin.php";
include "adminlib.php";
$textpart = "eventtypes";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_edit) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$query = "SELECT * FROM $eventtypes_table WHERE eventtypeID = \"$eventtypeID\"";
$result = tng_query($query);
$row = tng_fetch_assoc($result);
tng_free_result($result);
$row['display'] = preg_replace("/\"/", "&#34;", $row['display']);
$row['tag'] = preg_replace("/\"/", "&#34;", $row['tag']);
$row['type'] = preg_replace("/\"/", "&#34;", $row['type']);

switch ($row['type']) {
    case "I":
        $displaystr = _('Individual');
        break;
    case "F":
        $displaystr = _('Family');
        break;
    case "S":
        $displaystr = _('Source');
        break;
    case "R":
        $displaystr = _('Repository');
        break;
}

$helplang = findhelp("eventtypes_help.php");

tng_adminheader(_('Edit Existing Event Type'), $flags);
?>
<script src="js/eventtypes.js"></script>
<script>
    var display = "";

    function addToDisplay(lang, newdisplay) {
        if (display) display += "|";
        display += lang + "|" + newdisplay;
    }

    function validateForm() {
        let rval = true;

        <?php
        $dispvalues = explode("|", $row['display']);
        $numvalues = count($dispvalues);
        $disppairs = [];
        if ($numvalues > 1) {
            for ($i = 0; $i < $numvalues; $i += 2) {
                $lang = $dispvalues[$i];
                $disppairs[$lang] = $dispvalues[$i + 1];
            }
        }

        if (count($disppairs) > 1) {
            $defdisplay = "";
            $displaytrstyle = " style='display: none;'";
            $otherlangsstyle = "";
        } else {
            $displaytrstyle = "";
            $otherlangsstyle = " style='display: none;'";
            if (count($disppairs) == 1) {
                $defdisplay = $dispvalues[1];
            } else {
                $defdisplay = $row['display'];
            }
            $disppairs = null;
        }

        $query = "SELECT languageID, display, folder FROM $languages_table ORDER BY display";
        $langresult = tng_query($query);
        if (tng_num_rows($langresult)) {
            $displayrows = "";
            while ($langrow = tng_fetch_assoc($langresult)) {
                $lang = $langrow['folder'];
                $displayval = "";
                if (is_array($disppairs)) {
                    $displayval = isset($disppairs[$lang]) ? $disppairs[$lang] : "";
                } else {
                    $displayval = "";
                }
                $display = _('Display') . " ({$langrow['display']})";
                $displayname = "display" . $langrow['languageID'];
                $displayrows .= "<tr>";
                $displayrows .= "<td class='align-top'>$display</td>";
                $displayrows .= "<td><input type='text' name='$displayname' size='40' value='$displayval' onFocus=\"if(this.value == '') this.value = document.form1.defdisplay.value;\"></td>";
                $displayrows .= "</tr>\n";
                echo "if( document.form1.$displayname.value ) addToDisplay('$lang',document.form1.$displayname.value);\n";
            }
        } else {
            $displayrows = "";
        }
        ?>
        if (document.form1.tag2.value.length == 0 && document.form1.tag1.value.length == 0) {
            alert("<?php echo _('Please select or enter the tag for this event type.'); ?>");
            rval = false;
        } else if ((document.form1.tag2.value == "EVEN" || (document.form1.tag2.value == "" && document.form1.tag1.value == "EVEN")) && document.form1.description.value.length == 0) {
            alert("<?php echo _('Please enter a type/description for this new event type.'); ?>");
            rval = false;
        } else if (display == "" && document.form1.defdisplay.value == "") {
            alert("<?php echo _('Please enter a display string for this new event type.'); ?>");
            rval = false;
        } else
            document.form1.display.value = display;
        return rval;
    }

    <?php
    $messages = ['EVEN', 'ADOP', 'ADDR', 'ALIA', 'ANCI', 'BARM', 'BASM', 'CAST', 'CENS', 'CHRA', 'CONF', 'CREM', 'DESI', 'DSCR', 'EDUC', 'EMIG', 'FCOM', 'GRAD', 'IDNO', 'IMMI', 'LANG', 'NATI', 'NATU', 'NCHI', 'NMR', 'OCCU', 'ORDI', 'ORDN', 'PHON', 'PROB', 'PROP', 'REFN', 'RELI', 'RESI', 'RESN', 'RETI', 'RFN', 'RIN', 'SSN', 'WILL', 'ANUL', 'DIV', 'DIVF', 'ENGA', 'MARB', 'MARC', 'MARR', 'MARL'];
    foreach ($messages as $msg) {
        echo "messages['$msg'] = \"" . $admtext[$msg] . "\";\n";
    }
    ?>
</script>
    </head>

<?php
echo tng_adminlayout();

$evtabs[0] = [1, "admin_eventtypes.php", _('Search'), "findevent"];
$evtabs[1] = [$allow_add, "admin_neweventtype.php", _('Add New'), "addevent"];
$evtabs[2] = [$allow_edit, "#", _('Edit'), "edit"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/eventtypes_help.php#add');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($evtabs, "edit", $innermenu);
echo displayHeadline(_('Custom Event Types') . " &gt;&gt; " . _('Edit Existing Event Type'), "img/customeventtypes_icon.gif", $menu, $message);
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <form action="admin_updateeventtype.php" method="post" name="form1" onsubmit="return validateForm();">
                    <table class="normal">
                        <tr>
                            <td class='align-top'><?php echo _('Associated with'); ?>:</td>
                            <td>
                                <select name="type" onChange="populateTags(this.options[this.selectedIndex].value,'');">
                                    <option value="I"<?php if ($row['type'] == "I") {
                                        echo " selected";
                                    } ?>><?php echo _('Individual'); ?></option>
                                    <option value="F"<?php if ($row['type'] == "F") {
                                        echo " selected";
                                    } ?>><?php echo _('Family'); ?></option>
                                    <option value="S"<?php if ($row['type'] == "S") {
                                        echo " selected";
                                    } ?>><?php echo _('Source'); ?></option>
                                    <option value="R"<?php if ($row['type'] == "R") {
                                        echo " selected";
                                    } ?>><?php echo _('Repository'); ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class='align-top'><?php echo _('Select Tag'); ?>:</td>
                            <td>
                                <select name="tag1" onChange="if(this.options[this.selectedIndex].value == 'EVEN') {toggleTdesc(1);} else {toggleTdesc(0);}">
                                    <option value="<?php echo $row['tag']; ?>"><?php echo $row['tag']; ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class='align-top'>
                                &nbsp; <?php echo _('or enter'); ?>:
                            </td>
                            <td>
                                <input type="text" name="tag2" size="10" onBlur="if(this.value == 'EVEN' || this.value == '') {toggleTdesc(1);} else {toggleTdesc(0);}">
                                (<?php echo _('will take precedence if both fields contain data'); ?>)
                            </td>
                        </tr>
                        <tr id="tdesc">
                            <td class='align-top'><?php echo _('Type/Description'); ?>*:</td>
                            <td>
                                <input type="text" name="description" size="40" value="<?php echo $row['description']; ?>">
                            </td>
                        </tr>
                        <tr id="displaytr"<?php echo $displaytrstyle; ?>>
                            <td class='align-top'><?php echo _('Display'); ?>:</td>
                            <td>
                                <input type="text" name="defdisplay" size="40" value="<?php echo $defdisplay; ?>">
                            </td>
                        </tr>
                        <?php if ($displayrows) { ?>
                            <tr>
                                <td class="align-top" colspan="2">
                                    <br>
                                    <hr style="margin-left:0; width:400px;">
                                    <?php echo displayToggle("plus0", 0, "otherlangs", _('Other Languages'), ''); ?>
                                    <table id="otherlangs"<?php echo $otherlangsstyle; ?> class="normal">
                                        <tr>
                                            <td class="align-top" colspan="2"><br><b><?php echo _('Enter a display message for each language,<br>or leave all blank and enter one display message above.'); ?></b><br><br></td>
                                        </tr>
                                        <?php echo $displayrows; ?>
                                    </table>
                                    <hr style="margin-left:0; width:400px;">
                                    <br>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td class='align-top'><?php echo _('Display Order'); ?>:</td>
                            <td>
                                <input type="text" name="ordernum" size="4" value="<?php echo $row['ordernum']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td class='align-top'><?php echo _('Event Data'); ?>:</td>
                            <td>
                                <input type="radio" name="keep" value="1" <?php if ($row['keep']) {
                                    echo "checked";
                                } ?>> <?php echo _('Accept'); ?> &nbsp;
                                <input type="radio" name="keep" value="0" <?php if ($row['keep'] != 1) {
                                    echo "checked";
                                } ?>> <?php echo _('Ignore'); ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class='align-top'><?php echo _('Collapse Event'); ?>:</td>
                            <td>
                                <input type="radio" name="collapse" value="1" <?php if ($row['collapse']) {
                                    echo "checked";
                                } ?>> <?php echo _('Yes'); ?> &nbsp;
                                <input type="radio" name="collapse" value="0" <?php if ($row['collapse'] != 1) {
                                    echo "checked";
                                } ?>> <?php echo _('No'); ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class='align-top'><?php echo _('LDS Event'); ?>:</td>
                            <td>
                                <input type="radio" name="ldsevent" value="1" <?php if ($row['ldsevent']) {
                                    echo "checked";
                                } ?>> <?php echo _('Yes'); ?> &nbsp;
                                <input type="radio" name="ldsevent" value="0" <?php if ($row['ldsevent'] != 1) {
                                    echo "checked";
                                } ?>> <?php echo _('No'); ?></td>
                            <td></td>
                        </tr>
                    </table>
                    <br>
                    <input type="hidden" name="eventtypeID" value="<?php echo $eventtypeID; ?>">
                    <input type="hidden" name="display" value="">
                    <input type="submit" name="submit" accesskey="s" class="btn" value="<?php echo _('Save Changes'); ?>">
                </form>
                <p class="normal">*<?php echo _('With custom tags (where tag = \"EVEN\"), this is the TYPE and is required. Optional for all other tags.'); ?></p>
            </td>
        </tr>

    </table>
    <script>
        populateTags(<?php echo "\"{$row['type']}\",\"{$row['tag']}\""; ?>);
    </script>

<?php echo tng_adminfooter(); ?>
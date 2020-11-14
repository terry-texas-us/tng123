<?php
include "begin.php";
include "adminlib.php";
$textpart = "timeline";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_add) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$helplang = findhelp("tlevents_help.php");

tng_adminheader(_('Add New Event'), $flags);
?>
    <script>
        function validateForm() {
            let rval = true;
            if (document.form1.evyear.value.length == 0) {
                alert("<?php echo _('Please enter the event year.'); ?>");
                rval = false;
            } else if (document.form1.evdetail.value.length == 0) {
                alert("<?php echo _('Please enter the event detail.'); ?>");
                rval = false;
            } else if (document.form1.endyear.value.length == 0 && (document.form1.endmonth.selectedIndex > 0 || document.form1.endday.selectedIndex > 0)) {
                alert("If you enter a day or month for the ending date, you must also enter an ending year.");
                rval = false;
            } else if ((document.form1.evday.selectedIndex > 0 && document.form1.evmonth.selectedIndex <= 0) || (document.form1.endday.selectedIndex > 0 && document.form1.endmonth.selectedIndex <= 0)) {
                alert("If you select a day, you must also select a month.");
                rval = false;
            } else if (document.form1.endyear.value && parseInt(document.form1.endyear.value) < parseInt(document.form1.evyear.value)) {
                alert("Ending year is less than beginning year.");
                rval = false;
            }
            return rval;
        }
    </script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$timelinetabs[0] = [1, "admin_timelineevents.php", _('Search'), "findtimeline"];
$timelinetabs[1] = [$allow_add, "admin_newtlevent.php", _('Add New'), "addtlevent"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/tlevents_help.php#add');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($timelinetabs, "addtlevent", $innermenu);
echo displayHeadline(_('Timeline Events') . " &gt;&gt; " . _('Add New Event'), "img/tlevents_icon.gif", $menu, "");
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <form action="admin_addtlevent.php" method="post" name="form1" onSubmit="return validateForm();">
                    <table class="normal">
                        <?php
                    function doEventRow($label, $dayname, $monthname, $yearname, $help) {
                        global $dates;
                        ?>
                        <tr>
                            <td><?php echo $label; ?>:</td>
                            <td>
                                <select name="<?php echo $dayname; ?>">
                                    <option value=""></option>
                                    <?php
                                    for ($i = 1; $i <= 31; $i++) {
                                        echo "<option value=\"$i\">$i</option>\n";
                                    }
                                    ?>
                                </select>
                                <select name="<?php echo $monthname; ?>">
                                    <option value=""></option>
                                    <option value="1"><?php echo _('Jan'); ?></option>
                                    <option value="2"><?php echo _('Feb'); ?></option>
                                    <option value="3"><?php echo _('Mar'); ?></option>
                                    <option value="4"><?php echo _('Apr'); ?></option>
                                    <option value="5"><?php echo _('May'); ?></option>
                                    <option value="6"><?php echo _('Jun'); ?></option>
                                    <option value="7"><?php echo _('Jul'); ?></option>
                                    <option value="8"><?php echo _('Aug'); ?></option>
                                    <option value="9"><?php echo _('Sep'); ?></option>
                                    <option value="10"><?php echo _('Oct'); ?></option>
                                    <option value="11"><?php echo _('Nov'); ?></option>
                                    <option value="12"><?php echo _('Dec'); ?></option>
                                </select>
                                <input type="text" name="<?php echo $yearname; ?>" size="4">
                                <span class="normal"><?php echo $help; ?></span>
                            </td>
                        </tr>
                        <?php
                    }

                        doEventRow(_('Start Date'), "evday", "evmonth", "evyear", _('(only year is required)'));
                        doEventRow(_('End Date'), "endday", "endmonth", "endyear", "");
                        ?>
                        <tr>
                            <td><?php echo _('Event title'); ?>:</td>
                            <td>
                                <input type="text" name="evtitle" width="100">
                            </td>
                        </tr>
                        <tr>
                            <td class='align-top'><?php echo _('Event detail'); ?>:</td>
                            <td><textarea cols="80" rows="8" name="evdetail"></textarea></td>
                        </tr>
                    </table>
                    <br>&nbsp;
                    <input type="submit" name="submit" accesskey="s" class="btn" value="<?php echo _('Save'); ?>">
                </form>
            </td>
        </tr>

    </table>
<?php echo tng_adminfooter(); ?>
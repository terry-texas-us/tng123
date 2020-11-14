<?php
include "begin.php";
include "config/importconfig.php";
include "adminlib.php";
$textpart = "setup";
include "$mylanguage/admintext.php";

if ($link) {
    $admin_login = 1;
    include "checklogin.php";
    include "version.php";
    if ($assignedtree || !$allow_edit) {
        $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
        header("Location: admin_login.php?message=" . urlencode($message));
        exit;
    }

    $query = "SELECT gedcom, treename FROM $trees_table ORDER BY treename";
    $result = @tng_query($query);
} else {
    $result = false;
}

if (!$tngimpcfg['maxlivingage']) {
    $tngimpcfg['maxlivingage'] = "110";
}

//for upgrading to 6
if ($localphotopathdisplay && !$locimppath['photos']) {
    $locimppath['photos'] = $localphotopathdisplay;
}
if ($localdocpathdisplay && !$locimppath['histories']) {
    $locimppath['histories'] = $localdocpathdisplay;
}

$helplang = findhelp("importconfig_help.php");

tng_adminheader(_('Modify Import Configuration Settings'), $flags);

echo "</head>\n";
echo tng_adminlayout();

$setuptabs[0] = [1, "admin_setup.php", _('Configuration'), "configuration"];
$setuptabs[1] = [1, "admin_diagnostics.php", _('Diagnostics'), "diagnostics"];
$setuptabs[2] = [1, "admin_setup.php?sub=tablecreation", _('Table Creation'), "tablecreation"];
$setuptabs[3] = [1, "#", _('Import Settings'), "import"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/importconfig_help.php');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($setuptabs, "import", $innermenu);
echo displayHeadline(_('Setup') . " &gt;&gt; " . _('Configuration') . " &gt;&gt; " . _('Import Settings'), "img/setup_icon.gif", $menu, "");
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <form action="admin_updateimportconfig.php" method="post" name="form1">
                    <table class="normal">
                        <tr>
                            <td><?php echo _('GEDCOM Folder (Import/Export)'); ?>:</td>
                            <td>
                                <input type="text" value="<?php echo $gedpath; ?>" name="gedpath" size="50">
                                <input type="button" value="<?php echo _('Make Folder'); ?>" onclick="makeFolder('gedcom',document.form1.gedpath.value);">
                                <span id="msg_gedcom"></td>
                        </tr>
                        <tr>
                            <td><?php echo _('Save Import State'); ?>:</td>
                            <td>
                                <input type="checkbox" name="saveimport" value="1" <?php if ($saveimport) {
                                    echo "checked";
                                } ?>> <?php echo _('Save to allow resume if import fails'); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo _('Record Report Number'); ?>:</td>
                            <td>
                                <input type="text" value="<?php echo $tngimpcfg['rrnum']; ?>" name="rrnum" size="5">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Progress Interval (ms)'); ?>:</td>
                            <td>
                                <input type="text" value="<?php echo $tngimpcfg['readmsecs']; ?>" name="readmsecs" size="5">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Default Replace Option'); ?>:</td>
                            <td>
                                <select name="defimpopt">
                                    <option value="1"<?php if ($tngimpcfg['defimpopt'] == 1) {
                                        echo " selected";
                                    } ?>><?php echo _('All current data'); ?></option>
                                    <option value="0"<?php if (!$tngimpcfg['defimpopt']) {
                                        echo " selected";
                                    } ?>><?php echo _('Matching records only'); ?></option>
                                    <option value="2"<?php if ($tngimpcfg['defimpopt'] == 2) {
                                        echo " selected";
                                    } ?>><?php echo _('Do not replace any data'); ?></option>
                                    <option value="3"<?php if ($tngimpcfg['defimpopt'] == 3) {
                                        echo " selected";
                                    } ?>><?php echo _('Append all records'); ?></option>
                                </select>

                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('If \'Change Date\' is blank'); ?>:</td>
                            <td>
                                <select name="blankchangedt">
                                    <option value="0"<?php if (!$tngimpcfg['chdate']) {
                                        echo " selected";
                                    } ?>><?php echo _('Use current date'); ?></option>
                                    <option value="1"<?php if ($tngimpcfg['chdate']) {
                                        echo " selected";
                                    } ?>><?php echo _('Leave it as is'); ?></option>
                                </select>

                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('If no birth date, assume'); ?>:</td>
                            <td>
                                <select name="livingreqbirth">
                                    <option value="0"<?php if (!$tngimpcfg['livingreqbirth']) {
                                        echo " selected";
                                    } ?>><?php echo _('Person is deceased'); ?></option>
                                    <option value="1"<?php if ($tngimpcfg['livingreqbirth']) {
                                        echo " selected";
                                    } ?>><?php echo _('Person is living'); ?></option>
                                </select>

                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('If no death date, assume deceased<br>if older than'); ?>:</td>
                            <td>
                                <input type="text" value="<?php echo $tngimpcfg['maxlivingage']; ?>" name="maxlivingage" size="5">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Assume private if not dead this many years'); ?>:</td>
                            <td>
                                <input type="text" value="<?php echo $tngimpcfg['maxprivyrs']; ?>" name="maxprivyrs" size="5">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Assume living if not dead this many years'); ?>:</td>
                            <td>
                                <input type="text" value="<?php echo $tngimpcfg['maxdecdyrs']; ?>" name="maxdecdyrs" size="5">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Embedded Media'); ?>:</td>
                            <td>
                                <input type="checkbox" name="assignnames" value="yes" <?php if ($assignnames) {
                                    echo "checked";
                                } ?>> <?php echo _('Allow TNG to assign names to embedded media'); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo _('Local Photo Path(s)'); ?>*:</td>
                            <td>
                                <input type="text" value="<?php echo $locimppath['photos']; ?>" name="localphotopathdisplay" class="verylongfield">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Local History Path(s)'); ?>*:</td>
                            <td>
                                <input type="text" value="<?php echo $locimppath['histories']; ?>" name="localhistorypathdisplay" class="verylongfield">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Local Document Path(s)'); ?>*:</td>
                            <td>
                                <input type="text" value="<?php echo $locimppath['documents']; ?>" name="localdocumentpathdisplay" class="verylongfield">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Local Headstone Path(s)'); ?>*:</td>
                            <td>
                                <input type="text" value="<?php echo $locimppath['headstones']; ?>" name="localhspathdisplay" class="verylongfield">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Local Path(s) for Other Media'); ?>*:</td>
                            <td>
                                <input type="text" value="<?php echo $locimppath['other']; ?>" name="localotherpathdisplay" class="verylongfield">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('If no local path match'); ?>:</td>
                            <td colspan="4">
                                <input type="radio" name="wholepath" value="1" <?php if ($wholepath) {
                                    echo "checked";
                                } ?>> <?php echo _('Import entire path'); ?>
                                <input type="radio" name="wholepath" value="0" <?php if (!$wholepath) {
                                    echo "checked";
                                } ?>> <?php echo _('Import file name only'); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo _('Prefix for private notes'); ?>:</td>
                            <td>
                                <input type="text" value="<?php echo $tngimpcfg['privnote']; ?>" name="privnote" size="5">
                            </td>
                        </tr>
                    </table>
                    <br>&nbsp;
                    <input type="submit" name="submit" accesskey="s" class="btn" value="<?php echo _('Save'); ?>">
                </form>
                <p class="normal">*<?php echo _('Separate multiple entries with commas'); ?></p>
            </td>
        </tr>

    </table>

<?php echo tng_adminfooter(); ?>
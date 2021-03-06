<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_edit) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$query = "SELECT * FROM $languages_table WHERE languageID = '$languageID'";
$result = tng_query($query);
$row = tng_fetch_assoc($result);
tng_free_result($result);

$helplang = findhelp("languages_help.php");

tng_adminheader(_('Edit Existing Language'), $flags);
?>
    <script>
        function validateForm() {
            let rval = true;
            if (document.form1.folder.value.length === 0) {
                alert("<?php echo _('Please enter the name of the folder where files for this language will be stored.'); ?>");
                rval = false;
            } else if (document.form1.display.value.length === 0) {
                alert("<?php echo _('Please enter a language display name.'); ?>");
                rval = false;
            }
            return rval;
        }
    </script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$langtabs[0] = [1, "admin_languages.php", _('Search'), "findlang"];
$langtabs[1] = [$allow_add, "admin_newlanguage.php", _('Add New'), "addlanguage"];
$langtabs[2] = [$allow_edit, "#", _('Edit'), "edit"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/languages_help.php#add');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($langtabs, "edit", $innermenu);
echo displayHeadline(_('Languages') . " &gt;&gt; " . _('Edit Existing Language'), "img/languages_icon.gif", $menu, $message);
?>
    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <form action="admin_updatelanguage.php" method="post" name="form1" onSubmit="return validateForm();">
                    <table class="normal">
                        <tr>
                            <td><?php echo _('Language folder'); ?>:</td>
                            <td>
                                <select name="folder">
                                    <?php
                                    @chdir($rootpath . $endrootpath . $languages_path);
                                    if ($handle = @opendir('.')) {
                                        $dirs = [];
                                        while ($filename = readdir($handle)) {
                                            if (is_dir($filename) && $filename != '..' && $filename != '.') {
                                                array_push($dirs, $filename);
                                            }
                                        }
                                        natcasesort($dirs);
                                        $found_current = 0;
                                        foreach ($dirs as $dir) {
                                            echo "<option value=\"$dir\"";
                                            if ($dir == $row['folder']) {
                                                echo " selected";
                                                $found_current = 1;
                                            }
                                            echo ">$dir</option>\n";
                                        }
                                        if (!$found_current) {
                                            echo "<option value=\"{$row['folder']}\" selected>{$row['folder']}</option>\n";
                                        }
                                        closedir($handle);
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Name for this language<br>as it will be displayed for visitors'); ?>:</td>
                            <td>
                                <input type="text" name="display" size="50" value="<?php echo $row['display']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Character set'); ?>:</td>
                            <td>
                                <input type="text" name="langcharset" size="30" value="<?php echo $row['charset']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Turn off relationship messages'); ?>:</td>
                            <td>
                                <select name="langnorels">
                                    <option value=""<?php if (!$row['norels']) {
                                        echo " selected";
                                    } ?>><?php echo _('No'); ?></option>
                                    <option value="1"<?php if ($row['norels']) {
                                        echo " selected";
                                    } ?>><?php echo _('Yes'); ?></option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <input type="hidden" name="languageID" value="<?php echo "$languageID"; ?>">
                    <input type="submit" name="submit" accesskey="s" class="btn" value="<?php echo _('Save'); ?>">
                </form>
            </td>
        </tr>
    </table>

<?php echo tng_adminfooter(); ?>
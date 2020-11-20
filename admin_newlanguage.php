<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_add) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$helplang = findhelp("languages_help.php");

tng_adminheader(_('Add New Language'), $flags);
?>
    <script>
        function validateForm() {
            let rval = true;
            if (document.form1.folder.value.length == 0) {
                alert("<?php echo _('Please enter the name of the folder where files for this language will be stored.'); ?>");
                rval = false;
            } else if (document.form1.display.value.length == 0) {
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
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/languages_help.php#add');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($langtabs, "addlanguage", $innermenu);
echo displayHeadline(_('Languages') . " &gt;&gt; " . _('Add New Language'), "img/languages_icon.gif", $menu, $message);
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <form action="admin_addlanguage.php" method="post" name="form1" onSubmit="return validateForm();">
                    <table class="normal">
                        <tr>
                            <td><?php echo _('Language folder'); ?>:</td>
                            <td>
                                <select name="folder">
                                    <option value=""></option>
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
                                        foreach ($dirs as $dir) {
                                            echo "<option value=\"$dir\">$dir</option>\n";
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
                                <input type="text" name="display" size="50">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Character set'); ?>:</td>
                            <td>
                                <input type="text" name="langcharset" size="30" value="<?php echo $session_charset; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Turn off relationship messages'); ?>:</td>
                            <td>
                                <select name="langnorels">
                                    <option value=""><?php echo _('No'); ?></option>
                                    <option value="1"><?php echo _('Yes'); ?></option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <input type="submit" name="submit" accesskey="s" class="btn" value="<?php echo _('Save'); ?>">
                </form>
            </td>
        </tr>

    </table>
<?php echo tng_adminfooter(); ?>
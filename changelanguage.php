<?php
$textpart = "language";
include "tng_begin.php";

$currentuser = $_SESSION['currentuser'];
$currentuserdesc = $_SESSION['currentuserdesc'];

$query = "SELECT languageID, display, folder FROM $languages_table ORDER BY display";
$result = tng_query($query);

$numrows = tng_num_rows($result);

tng_header(_('Change Language'), $flags);
?>

<h2 class="header"><?php echo _('Change Language'); ?></h2>
<br class="clear-both">

<?php
if ($numrows) {
    echo getFORM("savelanguage", "post", "", "");
    ?>
    <select name="newlanguage">
        <?php
        while ($row = tng_fetch_assoc($result)) {
            echo "<option value=\"{$row['languageID']}\"";
            if ($row['folder'] == $mylanguage) echo " selected";

            echo ">{$row['display']}</option>\n";
        }
        tng_free_result($result);
        ?>
    </select>
    <br><br>
    <input type="submit" class="btn" value="<?php echo _('Save Changes'); ?>">
    <br><br>
    </form>
    <?php
} else {
    echo _('Language') . ": $mylanguage\n";
}
tng_footer("");
?>

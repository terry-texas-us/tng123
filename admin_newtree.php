<?php
include "begin.php";
include "adminlib.php";

/** @global mixed $beforeimport yes if modal request made 'Add New Tree' during GEDCOM Import */
$beforeimport = $_GET['beforeimport'] ?? null;

$textpart = "trees";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_add) {
    $message = $admtext['norights'];
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$helplang = findhelp("trees_help.php");

if ($beforeimport == "yes") { // ajax html excludes html and body tags
    header("Content-type:text/html; charset=" . $session_charset);
    echo "<div class=\"databack ajaxwindow\" id=\"newtree\">\n";
    echo "<p class=\"subhead\"><strong>{$admtext['addnewtree']}</strong> |\n";
    echo "<a href=\"#\" onclick=\"return openHelp('{$helplang}/trees_help.php#add', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\">{$admtext['help']}></a></p>";
} else {
    $flags['tabs'] = $tngconfig['tabs'];
    tng_adminheader($admtext['addnewtree'], $flags);
    echo "</head>\n";
    echo "<body background=\"img/background.gif\">\n";
    $allow_add_tree = $assignedtree ? 0 : $allow_add;
    $treetabs[0] = [1, "admin_trees.php", $admtext['search'], "findtree"];
    $treetabs[1] = [$allow_add_tree, "admin_newtree.php", $admtext['addnew'], "addtree"];
    $innermenu = "<a href=\"#\" onclick=\"return openHelp('$helplang/trees_help.php#add');\" class=\"lightlink\">{$admtext['help']}</a>";
    $menu = doMenu($treetabs, "addtree", $innermenu);
    echo displayHeadline($admtext['trees'] . " &gt;&gt; " . $admtext['addnewtree'], "img/trees_icon.gif", $menu, $message);
}
?>

    <table cellpadding="10" cellspacing="2" <?php echo !$beforeimport ? " width=\"100%\" class=\"lightback\"" : "" ?>>
        <tr class="databack">
            <td<?php echo !$beforeimport ? " class=\"tngshadow\"" : "" ?>>
                <form action="admin_addtree.php" method="post" name="treeform"
                      onsubmit="return validateTreeForm(this);">
                    <table class="normal">
                        <tr>
                            <td><?php echo $admtext['treeid']; ?>:</td>
                            <td><input type="text" name="gedcom" size="20" maxlength="20"></td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['treename']; ?>:</td>
                            <td><input type="text" name="treename" size="50" value="<?php echo $treename; ?>"></td>
                        </tr>
                        <tr>
                            <td valign="top"><?php echo $admtext['description']; ?>:</td>
                            <td><textarea cols="40" rows="3" name="description"><?php echo $description; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['owner']; ?>:</td>
                            <td><input type="text" name="owner" size="50" value="<?php echo $owner; ?>"></td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['email']; ?>:</td>
                            <td><input type="text" name="email" size="50" value="<?php echo $email; ?>"></td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['address']; ?>:</td>
                            <td><input type="text" name="address" size="50" value="<?php echo $address; ?>"></td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['city']; ?>:</td>
                            <td><input type="text" name="city" size="50" value="<?php echo $city; ?>"></td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['stateprov']; ?>:</td>
                            <td><input type="text" name="state" size="50" value="<?php echo $state; ?>"></td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['zip']; ?>:</td>
                            <td><input type="text" name="zip" size="50" value="<?php echo $zip; ?>"></td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['cap_country']; ?>:</td>
                            <td><input type="text" name="country" size="50" value="<?php echo $country; ?>"></td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['phone']; ?>:</td>
                            <td><input type="text" name="phone" size="50" value="<?php echo $phone; ?>"></td>
                        </tr>
                    </table>
                    <span class="normal">
                <input type="checkbox" name="private" value="1"<?php if ($private) {
                    echo " checked=\"checked\"";
                } ?>> <?php echo $admtext['keepprivate']; ?><br>
                <input type="checkbox" name="disallowgedcreate" value="1"<?php if ($disallowgedcreate) {
                    echo " checked=\"checked\"";
                } ?>> <?php echo $admtext['gedcomextraction']; ?><br>
                <input type="checkbox" name="disallowpdf" value="1"<?php if ($disallowpdf) {
                    echo " checked=\"checked\"";
                } ?>> <?php echo $admtext['nopdf']; ?>
                <br><br>
                </span>
                    <input type="hidden" name="beforeimport" value="<?php echo $beforeimport; ?>">
                    <input type="submit" name="submit" accesskey="s" class="btn"
                           value="<?php echo $admtext['save']; ?>"> <span id="treemsg"
                                                                          class="normal msgapproved"></span>
                </form>
            </td>
        </tr>

    </table>

<?php if ($beforeimport) {
    echo "</div>\n";
} else {
    echo "<div align=\"right\"><span class=\"normal\">{$tng_title}, v . {$tng_version}</span></div>\n";
    ?>
    <script type="text/javascript">
        function validateTreeForm(form) {
            let rval = true;
            if (form.gedcom.value.length == 0) {
                alert("<?php echo $admtext['entertreeid']; ?>");
                rval = false;
            } else {
                if (!alphaNumericCheck(form.gedcom.value)) {
                    alert("<?php echo $admtext['alphanum']; ?>");
                    rval = false;
                } else {
                    if (form.treename.value.length == 0) {
                        alert("<?php echo $admtext['entertreename']; ?>");
                        rval = false;
                    }
                }
            }
            return rval;
        }

        function alphaNumericCheck(string) {
            const regex = /^[0-9A-Za-z_-]+$/;
            return regex.test(string);
        }
    </script>
    <?php
    echo "</body>\n";
    echo "</html>\n";
} ?>
<?php
include "begin.php";
include "adminlib.php";
$textpart = "reports";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";

if ($assignedtree) {
    $message = $admtext['norights'];
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$file = "$rootpath/whatsnew.txt";

$contents = @file($file);

$helplang = findhelp("misc_help.php");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['whatsnew'], $flags);
?>
<script>
    //<![CDATA[
    <?php include "niceditmsgs.php"; ?>
    //]]>
</script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$misctabs[0] = [1, "admin_misc.php", $admtext['menu'], "misc"];
$misctabs[1] = [1, "admin_whatsnewmsg.php", $admtext['whatsnew'], "whatsnew"];
$misctabs[2] = [1, "admin_mostwanted.php", $admtext['mostwanted'], "mostwanted"];
$misctabs[3] = [1, "admin_data_validation.php", $admtext['dataval'], "validation"];
$innermenu = "<a class='lightlink' href='#' onclick=\"return openHelp('$helplang/misc_help.php#add');\">{$admtext['help']}</a>";
$innermenu .= " &nbsp;|&nbsp; <a class='lightlink' href='whatsnew.php' target='_blank'>{$admtext['test']}</a>";
$menu = doMenu($misctabs, "whatsnew", $innermenu);
echo displayHeadline($admtext['misc'] . " &gt;&gt; " . $admtext['whatsnew'], "img/misc_icon.gif", $menu, "");
?>

<table class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <form action="admin_savewhatsnewmsg.php" method="post" name="form1">
                <h3 class="subhead"><?php echo $admtext['wnmsg']; ?>:</h3>
                <p class="normal" id="savedmsg" style="<?php echo($color ? "color:$color;" : "display:none;") ?>"><em><?php echo $message; ?></em></p>
                <textarea cols="150" rows="20" name="whatsnewmsg" id="whatsnewmsg">
                    <?php if (is_array($contents)) {
                        foreach ($contents as $line) {
                            echo $line;
                        }
                    } ?>
                </textarea><br>
                <input type="submit" name="submit" accesskey="s" class="btn" value="<?php echo $admtext['save']; ?>">
            </form>
        </td>
    </tr>
</table>
<?php echo "<div style=\"text-align: center;\"><span class='normal'>$tng_title</span></div>"; ?>
<script src="js/nicedit.js"></script>
<script>
    //<![CDATA[
    bkLib.onDomLoaded(function () {
        new nicEditor({fullPanel: true}).panelInstance('whatsnewmsg');
    });
    //]]>
</script>
</body>
</html>
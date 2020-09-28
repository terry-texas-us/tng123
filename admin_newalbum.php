<?php
include "begin.php";
include "adminlib.php";
$textpart = "photos";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_media_add) {
    $message = $admtext['norights'];
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$helplang = findhelp("albums_help.php");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['addnewalbum'], $flags);
?>
<script>
    function validateForm() {
        let rval = true;
        if (document.form1.albumname.value.length == 0) {
            alert("<?php echo $admtext['enteralbumname']; ?>");
            rval = false;
        }
        return rval;
    }
</script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$albumtabs[0] = [1, "admin_albums.php", $admtext['search'], "findalbum"];
$albumtabs[1] = [$allow_add, "admin_newalbum.php", $admtext['addnew'], "addalbum"];
$albumtabs[2] = [$allow_edit, "admin_orderalbumform.php", $admtext['text_sort'], "sortalbums"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/albums_help.php#add');\" class='lightlink'>{$admtext['help']}</a>";
$menu = doMenu($albumtabs, "addalbum", $innermenu);
echo displayHeadline($admtext['albums'] . " &gt;&gt; " . $admtext['addnewalbum'], "img/albums_icon.gif", $menu, $message);
?>

<form action="admin_addalbum.php" method="post" name="form1" onSubmit="return validateForm();">
    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <?php echo displayToggle("plus0", 1, "details", $admtext['existingalbuminfo'], $admtext['infosubt']); ?>

                <div id="details" class="topbuffer">
                    <table class="normal">
                        <tr>
                            <td><?php echo $admtext['albumname']; ?>:</td>
                            <td>
                                <input type="text" name="albumname" size="50">
                            </td>
                        </tr>
                        <tr>
                            <td class='align-top'><?php echo $admtext['description']; ?>:</td>
                            <td><textarea cols="60" rows="3" name="description"></textarea></td>
                        </tr>
                        <tr>
                            <td class='align-top'><?php echo $admtext['keywords']; ?>:</td>
                            <td><textarea cols="60" rows="3" name="keywords"></textarea></td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['active']; ?>:</td>
                            <td>
                                <input type="radio" name="active" value="1" checked="checked"> <?php echo $admtext['yes']; ?> &nbsp;
                                <input type="radio" name="active" value="0"> <?php echo $admtext['no']; ?></td>
                        </tr>
                        <tr>
                            <td class="align-top" colspan="2">
                                <input type="checkbox" name="alwayson" value="1"> <?php echo $admtext['alwayson']; ?></td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
        <tr class="databack">
            <td class="tngshadow">
                <p class="normal"><strong><?php echo $admtext['alblater']; ?></strong></p>
                <input type="submit" name="saveit" accesskey="a" class="btn" value="<?php echo $admtext['savecont']; ?>">
            </td>
        </tr>
    </table>
</form>

<?php echo "<div style=\"text-align: center;\"><span class='normal'>$tng_title</span></div>"; ?>
</body>
</html>
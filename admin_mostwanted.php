<?php
include "begin.php";
include "adminlib.php";
$textpart = "reports";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
$helplang = findhelp("mostwanted_help.php");

/**
 * @param string $type type of content in the div, 'person' or 'photo'
 */
function showDiv(string $type) {
    global $thumbmaxw, $admtext, $mostwanted_table, $media_table, $people_table, $mediatypes_assoc, $mediapath, $allow_add, $allow_delete, $allow_edit, $rootpath;
    if ($allow_add) {
        echo "<form action=\"\" style='margin: 0; padding-bottom: 5px;' method='post' name=\"form$type\" id=\"form$type\">\n";
        echo "<input type='button' value=\"" . _('Add New') . "\" onclick=\"return openMostWanted('$type','');\">\n";
        echo "</form>\n";
    }
    echo "<div id=\"order$type" . "divs\">\n";
    echo "<table class='w-full normal' id=\"order$type" . "tbl\">\n";
    echo "<tr>\n";
    echo "<th class='w-12 p-1 fieldnameback'><span class='fieldname'>" . _('Sort') . "</span></th>\n";
    echo "<th class='p-1 fieldnameback' style=\"width: {$thumbmaxw}px;\"><span class='fieldname'>" . _('Thumb') . "</span></th>\n";
    echo "<th class='p-1 fieldnameback'><span class='fieldname'>" . _('Description') . "</span></th>\n";
    echo "</tr>\n";
    echo "</table>\n";
    $query = "SELECT mostwanted.ID AS mwID, mwtype, thumbpath, usecollfolder, mediatypeID, media.description AS mtitle, mostwanted.description AS mwdesc, mostwanted.title AS title ";
    $query .= "FROM $mostwanted_table mostwanted ";
    $query .= "LEFT JOIN $media_table media ON mostwanted.mediaID = media.mediaID ";
    $query .= "LEFT JOIN $people_table people ON mostwanted.personID = people.personID AND mostwanted.gedcom = people.gedcom ";
    $query .= "WHERE mwtype = \"$type\" ORDER BY ordernum";
    $result = tng_query($query);

    while ($lrow = tng_fetch_assoc($result)) {
        $lmediatypeID = $lrow['mediatypeID'];
        $usefolder = $lrow['usecollfolder'] ? $mediatypes_assoc[$lmediatypeID] : $mediapath;
        $truncated = substr($lrow['mwdesc'], 0, 90);
        $truncated = strlen($lrow['mwdesc']) > 90 ? substr($truncated, 0, strrpos($truncated, ' ')) . '&hellip;' : $lrow['mwdesc'];
        echo "<div class='sortrow' id=\"order{$lrow['mwtype']}" . "divs_{$lrow['mwID']}\" style=\"clear:both\" onmouseover=\"showEditDelete('{$lrow['mwID']}');\" onmouseout=\"hideEditDelete('{$lrow['mwID']}');\">";
        echo "<table class='w-full'>\n";
        echo "<tr id=\"row_{$lrow['mwID']}\">\n";
        echo "<td class='w-16 p-1 rounded-lg dragarea normal'>";
        echo "<img src='img/admArrowUp.gif' alt='' class='inline-block'>" . _('Drag') . "<img src='img/admArrowDown.gif' alt='' class='inline-block'>\n";
        echo "</td>\n";
        echo "<td class='p-1 lightback' style=\"width: {$thumbmaxw}px;\">";
        if ($lrow['thumbpath'] && file_exists("$rootpath$usefolder/" . $lrow['thumbpath'])) {
            $size = @GetImageSize("$rootpath$usefolder/" . $lrow['thumbpath']);
            echo "<img class='block mx-auto' src=\"$usefolder/" . str_replace("%2F", "/", rawurlencode($lrow['thumbpath'])) . "\" $size[3]} id=\"img_{$lrow['mwID']}\" alt=\"{$lrow['mtitle']}\">";
        } else {
            echo "&nbsp;";
        }
        echo "</td>\n";
        echo "<td class='p-1 lightback normal'>";
        if ($allow_edit) {
            echo "<a href='#' onclick=\"return openMostWanted('{$lrow['mwtype']}','{$lrow['mwID']}');\" id=\"title_{$lrow['mwID']}\">{$lrow['title']}</a>";
        } else {
            echo "<u id=\"title_{$lrow['mwID']}\">{$lrow['title']}</u>";
        }
        echo "<br><span id=\"desc_{$lrow['mwID']}\">$truncated</span><br>";
        echo "<div id=\"del_{$lrow['mwID']}\" class='smaller' style=\"color:gray;visibility:hidden;\">";
        if ($allow_edit) {
            echo "<a href='#' onclick=\"return openMostWanted('{$lrow['mwtype']}','{$lrow['mwID']}');\">" . _('Edit') . "</a>";
            if ($allow_delete) echo " | ";

        }
        if ($allow_delete) {
            echo "<a href='#' onclick=\"return removeFromMostWanted('{$lrow['mwtype']}','{$lrow['mwID']}');\">" . _('Delete') . "</a>";
        }
        echo "</div>\n";
        echo "</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";
    }
    tng_free_result($result);
    echo "</div>\n";
}

$flags['style'] =
    "<style>
    body {
        background-image: url(img/background.gif);
    }
</style>\n";
tng_adminheader(_('Most Wanted'), $flags);
?>
    <script src="js/mostwanted.js"></script>
    <script src="js/selectutils.js"></script>
    <script>
        var mwlitbox;
        var tnglitbox;
        const entertitle = "<?php echo _('Please enter a title'); ?>";
        const enterdesc = "<?php echo _('Please enter a description'); ?>";
        const drag = "<?php echo _('Drag'); ?>";
        var thumbwidth = <?php echo($thumbmaxw + 6); ?>;
        const edittext = "<?php echo _('Edit'); ?>";
        const deletetext = "<?php echo _('Are you sure you want to remove this item?'); ?>";
        const confremmw = "<?php echo _('Menu'); ?>";
        const loading = "<?php echo _('Loading...'); ?>";
        var tree = "<?php echo $assignedtree; ?>";
    </script>
<?php echo "</head>"; ?>

    <body onLoad="startMostWanted()">

    <?php
    $misctabs[0] = [1, "admin_misc.php", _('What\'s New'), "misc"];
    $misctabs[1] = [1, "admin_whatsnewmsg.php", _('Most Wanted'), "whatsnew"];
    $misctabs[2] = [1, "admin_mostwanted.php", _('Data Validation'), "mostwanted"];
    $misctabs[3] = [1, "admin_data_validation.php", _('Help for this area'), "validation"];
    $innermenu = "<a href='#' onclick=\"return openHelp('$helplang/mostwanted_help.php');\" class='lightlink'>" . _('Test') . "</a>";
    $innermenu .= " &nbsp;|&nbsp; <a href=\"mostwanted.php\" target='_blank' class='lightlink'>" . _('Miscellaneous') . "</a>";
    $menu = doMenu($misctabs, "mostwanted", $innermenu);
    echo displayHeadline(_('Most Wanted') . " &gt;&gt; " . _('Elusive People'), "img/misc_icon.gif", $menu, $message);
    ?>

    <table class="w-full lightback">
        <tr class="databack">
            <td class="tngshadow">
                <?php
                echo displayToggle("plus0", 1, "personarea", _('Mystery Photos'), "");
                echo "<div id='personarea'>\n<br>\n";
                showDiv('person');
                echo "<br></div>\n";
                echo "<br>\n";
                echo displayToggle("plus1", 1, "photoarea", _('Mystery Photos'), "");
                echo "<div id='photoarea'>\n<br>\n";
                showDiv('photo');
                echo "</div>\n";
                ?>
            </td>
        </tr>
    </table>

<?php echo tng_adminfooter(); ?>
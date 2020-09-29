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
        echo "<form action=\"\" style=\"margin:0;padding-bottom:5px;\" method=\"post\" name=\"form$type\" id=\"form$type\">\n";
        echo "<input type='button' value=\"" . $admtext['addnew'] . "\" onclick=\"return openMostWanted('$type','');\">\n";
        echo "</form>\n";
    }
    echo "<div id=\"order$type" . "divs\">\n";
    echo "<table class='normal' id=\"order$type" . "tbl\">\n";
    echo "<tr>\n";
    echo "<th class=\"fieldnameback\" style=\"width: 4em;\"><span class=\"fieldname\">" . $admtext['text_sort'] . "</span></th>\n";
    echo "<th class=\"fieldnameback\" style=\"width: {$thumbmaxw}px;\"><span class=\"fieldname\">" . $admtext['thumb'] . "</span></th>\n";
    echo "<th class=\"fieldnameback\"><span class=\"fieldname\">" . $admtext['description'] . "</span></th>\n";
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
        echo "<div class=\"sortrow\" id=\"order{$lrow['mwtype']}" . "divs_{$lrow['mwID']}\" style=\"clear:both\" onmouseover=\"showEditDelete('{$lrow['mwID']}');\" onmouseout=\"hideEditDelete('{$lrow['mwID']}');\">";
        echo "<table>\n";
        echo "<tr id=\"row_{$lrow['mwID']}\">\n";
        echo "<td class=\"dragarea normal\" style=\"width: 4em;\">";
        echo "<img src=\"img/admArrowUp.gif\" alt=\"\"><br>" . $admtext['drag'] . "<br><img src=\"img/admArrowDown.gif\" alt=\"\">\n";
        echo "</td>\n";
        echo "<td class='lightback' style=\"width: {$thumbmaxw}px;\">";
        if ($lrow['thumbpath'] && file_exists("$rootpath$usefolder/" . $lrow['thumbpath'])) {
            $size = @GetImageSize("$rootpath$usefolder/" . $lrow['thumbpath']);
            echo "<img class=\"thumb-center\" src=\"$usefolder/" . str_replace("%2F", "/", rawurlencode($lrow['thumbpath'])) . "\" $size[3]} id=\"img_{$lrow['mwID']}\" alt=\"{$lrow['mtitle']}\">";
        } else {
            echo "&nbsp;";
        }
        echo "</td>\n";
        echo "<td class='lightback normal'>";
        if ($allow_edit) {
            echo "<a href='#' onclick=\"return openMostWanted('{$lrow['mwtype']}','{$lrow['mwID']}');\" id=\"title_{$lrow['mwID']}\">{$lrow['title']}</a>";
        } else {
            echo "<u id=\"title_{$lrow['mwID']}\">{$lrow['title']}</u>";
        }
        echo "<br><span id=\"desc_{$lrow['mwID']}\">$truncated</span><br>";
        echo "<div id=\"del_{$lrow['mwID']}\" class=\"smaller\" style=\"color:gray;visibility:hidden;\">";
        if ($allow_edit) {
            echo "<a href='#' onclick=\"return openMostWanted('{$lrow['mwtype']}','{$lrow['mwID']}');\">{$admtext['edit']}</a>";
            if ($allow_delete) {
                echo " | ";
            }
        }
        if ($allow_delete) {
            echo "<a href='#' onclick=\"return removeFromMostWanted('{$lrow['mwtype']}','{$lrow['mwID']}');\">{$admtext['text_delete']}</a>";
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

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['mostwanted'], $flags);
?>
    <script src="js/mostwanted.js"></script>
    <script src="js/selectutils.js"></script>
    <script>
        var mwlitbox;
        var tnglitbox;
        const entertitle = "<?php echo $admtext['entertitle']; ?>";
        const enterdesc = "<?php echo $admtext['enterdesc']; ?>";
        const drag = "<?php echo $admtext['drag']; ?>";
        var thumbwidth = <?php echo($thumbmaxw + 6); ?>;
        const edittext = "<?php echo $admtext['edit']; ?>";
        const deletetext = "<?php echo $admtext['delete']; ?>";
        const confremmw = "<?php echo $admtext['confremmw']; ?>";
        const loading = "<?php echo $text['loading']; ?>";
        var tree = "<?php echo $assignedtree; ?>";
    </script>
    <style>
        body {
            background-image: url("img/background.gif");
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 2px;
        }

        table th, table td {
            padding: 4px;
        }

        .thumb-center {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
<?php echo "</head>"; ?>

    <body onLoad="startMostWanted()">

    <?php
    $misctabs[0] = [1, "admin_misc.php", $admtext['menu'], "misc"];
    $misctabs[1] = [1, "admin_whatsnewmsg.php", $admtext['whatsnew'], "whatsnew"];
    $misctabs[2] = [1, "admin_mostwanted.php", $admtext['mostwanted'], "mostwanted"];
    $misctabs[3] = [1, "admin_data_validation.php", $admtext['dataval'], "validation"];
    $innermenu = "<a href='#' onclick=\"return openHelp('$helplang/mostwanted_help.php');\" class='lightlink'>{$admtext['help']}</a>";
    $innermenu .= " &nbsp;|&nbsp; <a href=\"mostwanted.php\" target='_blank' class='lightlink'>{$admtext['test']}</a>";
    $menu = doMenu($misctabs, "mostwanted", $innermenu);
    echo displayHeadline($admtext['misc'] . " &gt;&gt; " . $admtext['mostwanted'], "img/misc_icon.gif", $menu, $message);
    ?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <?php
                echo displayToggle("plus0", 1, "personarea", $admtext['mysperson'], "");
                echo "<div id=\"personarea\">\n<br>\n";
                showDiv('person');
                echo "<br></div>\n";
                echo "<br>\n";
                echo displayToggle("plus1", 1, "photoarea", $admtext['mysphoto'], "");
                echo "<div id=\"photoarea\">\n<br>\n";
                showDiv('photo');
                echo "</div>\n";
                ?>
            </td>
        </tr>
    </table>
    <div style="text-align: right;"><span class="normal"><?php echo "$tng_title"; ?></span></div>
    </body>
<?php echo "</html>\n"; ?>
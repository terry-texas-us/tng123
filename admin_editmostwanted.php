<?php

include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";

if ($ID) {
    $query = "SELECT mostwanted.title AS title, mostwanted.personID AS personID, mostwanted.description AS description, mostwanted.mediaID AS mediaID, mostwanted.gedcom AS gedcom, mwtype, thumbpath, usecollfolder, media.description AS mtitle, media.notes AS mdesc, mediatypeID ";
    $query .= "FROM $mostwanted_table mostwanted ";
    $query .= "LEFT JOIN $media_table media ON mostwanted.mediaID = media.mediaID ";
    $query .= "LEFT JOIN $people_table people ON mostwanted.personID = people.personID ";
    $query .= "WHERE mostwanted.ID = '$ID'";
    $result = tng_query($query);
    $row = tng_fetch_assoc($result);
    tng_free_result($result);
    $row['title'] = preg_replace("/\"/", "&#34;", $row['title']);
    $row['description'] = preg_replace("/\"/", "&#34;", $row['description']);
} else {
    $row['title'] = "";
    $row['description'] = "";
}

$helplang = findhelp("mostwanted_help.php");
if ($row['mwtype']) $mwtype = $row['mwtype'];

$typemsg = $mwtype == "person" ? _('Elusive People') : _('Mystery Photos');

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack ajaxwindow" id="more">
    <h3 class="subhead"><?php echo _('Most Wanted') . ": " . $typemsg; ?> |
        <a href="#" onclick="return openHelp('<?php echo $helplang; ?>/mostwanted_help.php');"><?php echo _('Help for this area'); ?></a>
    </h3>
    <form action="" name="editmostwanted" onsubmit="return updateMostWanted(this);">
        <table class="normal">
            <tr>
                <td><?php echo _('Title'); ?>:</td>
                <td>
                    <input class="w-full" name="title" type="text" value="<?php echo $row['title']; ?>" size="60" maxlength="128">
                </td>
            </tr>
            <tr>
                <td><?php echo _('Description'); ?>:</td>
                <td><textarea class="w-full" name="description" rows="4" cols="60"><?php echo $row['description']; ?></textarea></td>
            </tr>
            <tr>
                <td><?php echo _('Tree'); ?>:</td>
                <td>
                    <select name="mwtree" onchange="tree=this.options[this.selectedIndex].value">
                        <?php
                        if ($assignedtree) {
                            $wherestr = "WHERE gedcom = '$assignedtree'";
                            $firsttree = $assignedtree;
                        } else {
                            $wherestr = "";
                            $firsttree = isset($_COOKIE['tng_tree']) ? $_COOKIE['tng_tree'] : $row['gedcom'];
                        }
                        $query = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";
                        $treeresult = tng_query($query);

                        $trees = "";
                        while ($treerow = tng_fetch_assoc($treeresult)) {
                            echo "<option value=\"{$treerow['gedcom']}\"";
                            if ($firsttree == $treerow['gedcom']) echo " selected";

                            echo ">{$treerow['treename']}";
                            echo "</option>\n";
                        }
                        echo $trees;
                        tng_free_result($treeresult);
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><?php echo _('Person'); ?>:</td>
                <td>
                    <div style="float: left;">
                        <input id="personID" name="personID" type="text" value="<?php echo $row['personID']; ?>" placeholder="<?php echo _('Please enter a Person ID'); ?>">
                        <span style="padding: 0.5em;"><?php echo _('OR'); ?></span>
                        <a href="#" class="smallicon admin-find-icon" title="<?php echo _('Find...'); ?>" style="float: right;"
                            onclick="return findItem('I', 'personID', '', document.editmostwanted.mwtree.options[document.editmostwanted.mwtree.selectedIndex].value, '<?php echo $assignedbranch; ?>');"></a>
                    </div>

                </td>
            </tr>
        </table>
        <br>
        <input type="button" value="<?php echo _('Select Photo'); ?>"
            onclick="return openMostWantedMediaFind(document.editmostwanted.mwtree.options[document.editmostwanted.mwtree.selectedIndex].value);">
        <div id="mwphoto">
            <table style="padding-top:6px;">
                <tr>
                    <td class="lightback" id="mwthumb" style="width:<?php echo($thumbmaxw + 6); ?>px;height:<?php echo($thumbmaxh + 6); ?>px;text-align:center;">
                        <?php
                        initMediaTypes();
                        $lmediatypeID = $row['mediatypeID'];
                        $usefolder = $row['usecollfolder'] ? $mediatypes_assoc[$lmediatypeID] : $mediapath;

                        if ($row['thumbpath'] && file_exists("$rootpath$usefolder/" . $row['thumbpath'])) {
                            $photoinfo = @GetImageSize("$rootpath$usefolder/" . $row['thumbpath']);
                            if ($photoinfo[1] < 50) {
                                $photohtouse = $photoinfo[1];
                                $photowtouse = $photoinfo[0];
                            } else {
                                $photohtouse = 50;
                                $photowtouse = intval(50 * $photoinfo[0] / $photoinfo[1]);
                            }
                            echo "<img src=\"$usefolder/" . str_replace("%2F", "/", rawurlencode($row['thumbpath'])) . "\" width=\"$photowtouse\" height=\"$photohtouse\" id=\"img_$ID\" alt=\"{$row['mtitle']}\">";
                        } else {
                            echo "&nbsp;";
                        }
                        $row['mdesc'] = xmlcharacters($row['mdesc']);
                        $truncated = substr($row['mdesc'], 0, 90);
                        $truncated = strlen($row['mdesc']) > 90 ? substr($truncated, 0, strrpos($truncated, ' ')) . '&hellip;' : $row['mdesc'];
                        ?>
                    </td>
                    <td class="lightback normal" id="mwdetails"><?php echo "<u>" . xmlcharacters($row['mtitle']) . "</u><br>" . $truncated; ?>&nbsp;</td>
                </tr>
            </table>
        </div>
        <br>

        <input type="hidden" name="ID" value="<?php echo $ID; ?>">
        <input type="hidden" name="mediaID" id="mediaID" value="<?php echo $row['mediaID']; ?>">
        <input type="hidden" name="orgmediaID" id="orgmediaID" value="<?php echo $row['mediaID']; ?>">
        <input type="hidden" name="mwtype" id="mwtype" value="<?php echo $mwtype; ?>">
        <input type="submit" name="submit" value="<?php echo _('Save'); ?>">
    </form>
</div>
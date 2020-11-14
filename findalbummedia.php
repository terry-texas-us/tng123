<?php
include "begin.php";
include "adminlib.php";
$textpart = "photos";
include "$mylanguage/admintext.php";

include "checklogin.php";

if ($assignedtree) $tree = $assignedtree;

$treequery = "SELECT gedcom, treename ";
$treequery .= "FROM $trees_table ";
if ($assignedtree) $treequery .= "WHERE gedcom = '$assignedtree' ";

$treequery .= "ORDER BY treename";

initMediaTypes();
header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack ajaxwindow" id="finddiv">
    <h3 class="subhead"><?php echo _('Add Media'); ?></h3>
    <form name="find2" onsubmit="getNewMedia(this,1); return false;">
        <table>
            <tr>
                <td><span class="normal"><?php echo _('Collection'); ?>: </span></td>
                <td><span class="normal"><?php echo _('Tree'); ?>: </span></td>
                <td colspan="2"><span class="normal"><?php echo _('Search for'); ?>: </span></td>
            </tr>
            <tr>
                <td>
                    <select name="mediatypeID" onChange="toggleHeadstoneCriteria(document.find2,this.options[this.selectedIndex].value); getNewMedia(document.find2,0);">
                        <option value=""><?php echo _('All'); ?></option>
                        <?php
                        foreach ($mediatypes as $mediatype) {
                            $msgID = $mediatype['ID'];
                            echo "	<option value=\"$msgID\">" . $mediatype['display'] . "</option>\n";
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <select name="searchtree" onchange="getNewMedia(document.find2,0)">
                        <?php
                        if (!$assignedtree) echo "<option value=''>" . _('All Trees') . "</option>\n";
                        $treeresult = tng_query($treequery) or die (_('Cannot execute query') . ": $treequery");
                        while ($treerow = tng_fetch_assoc($treeresult)) {
                            echo "	<option value=\"{$treerow['gedcom']}\"";
                            if ($treerow['gedcom'] == $tree) echo " selected";

                            echo ">{$treerow['treename']}</option>\n";
                        }
                        tng_free_result($treeresult);
                        ?>
                    </select>
                </td>
                <td>
                    <input id="searchstring" name="searchstring" type="search" value="<?php echo $searchstring; ?>">
                </td>
                <td>
                    <input type="submit" name="searchbutton" value="<?php echo _('Search'); ?>" class="align-top">
                    <span id="spinner1" style="display:none;"><img src="img/spinner.gif"></span>
                </td>
            </tr>
        </table>
        <table>
            <tr id="hsstatrow" style="display:none;">
                <td><span class="normal"><?php echo _('Status'); ?>: </span></td>
                <td><span class="normal"><?php echo _('Cemetery'); ?>: </span></td>
            </tr>
            <tr id="cemrow" style="display:none;">
                <td>
                    <select name="hsstat" onchange="getNewMedia(document.find2,0)">
                        <option value="">&nbsp;</option>
                        <option value="<?php echo _('Not yet located'); ?>"><?php echo _('Not yet located'); ?></option>
                        <option value="<?php echo _('Located'); ?>"><?php echo _('Located'); ?></option>
                        <option value="<?php echo _('Unmarked'); ?>"><?php echo _('Unmarked'); ?></option>
                        <option value="<?php echo _('Missing'); ?>"><?php echo _('Missing'); ?></option>
                        <option value="<?php echo _('Cremated'); ?>"><?php echo _('Cremated'); ?></option>
                    </select>
                </td>
                <td>
                    <select name="cemeteryID" onchange="getNewMedia(document.find2,0)" style="width:380px;">
                        <option selected></option>
                        <?php
                        $query = "SELECT cemname, cemeteryID, city, county, state, country FROM $cemeteries_table ORDER BY country, state, county, city, cemname";
                        $cemresult = tng_query($query);
                        while ($cemrow = tng_fetch_assoc($cemresult)) {
                            $cemetery = "{$cemrow['country']}, {$cemrow['state']}, {$cemrow['county']}, {$cemrow['city']}, {$cemrow['cemname']}";
                            echo "		<option value=\"{$cemrow['cemeteryID']}\"";
                            if ($cemeteryID == $cemrow['cemeteryID']) {
                                echo " selected";
                            }
                            echo ">$cemetery</option>\n";
                        }
                        ?>
                    </select>
                </td>
            </tr>
        </table>

    </form>
    <div id="newmedia" style="width:720px;height:430px;overflow:auto;"></div>
    <br>
</div>
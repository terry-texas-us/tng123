<?php
include "begin.php";
include "config/mapconfig.php";
$mapkeystr = $map['key'] && $map['key'] != "1" ? "&amp;key=" . $map['key'] : "";
include "adminlib.php";
require_once "./admin/trees.php";

$textpart = "findplace";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
$tng_search_places = $_SESSION['tng_search_places'];

$query = "SELECT * ";
$query .= "FROM $places_table ";
$query .= "WHERE ";
if (is_numeric($ID)) {
    $query .= "ID = '$ID'";
} else {
    $query .= "place = '$ID'";
    if ($tree && !$tngconfig['places1tree']) {
        $query .= " AND gedcom = '$tree'";
    }
}
$result = tng_query($query);
$row = tng_fetch_assoc($result);
tng_free_result($result);

$orgplace = $row['place'];
$ID = $row['ID'];
$row['place'] = preg_replace("/\"/", "&#34;", $row['place']);

if (!$tngconfig['places1tree']) {
    if ($row['gedcom']) {
        $treerow = getTree($trees_table, $row['gedcom']);
    } else {
        if ($assignedtree) {
            $wherestr = "WHERE gedcom = '$assignedtree'";
        } else {
            $wherestr = "";
        }
        $query = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";
        $treeresult = tng_query($query);
    }
}

$helplang = findhelp("places_help.php");

tng_adminheader(_('Edit Existing Place'), $flags);

if ($map['key'] && $isConnected) {
    echo "<script src=\"{$http}://maps.googleapis.com/maps/api/js?language=" . _('&amp;hl=en') . "$mapkeystr\"></script>\n";
}
?>
    <script>
        function validateForm() {
            let rval = true;
            if (document.form1.place.value.length == 0) {
                alert("<?php echo _('Please enter a place.'); ?>");
                rval = false;
            }
            return rval;
        }

        function deleteCemLink(cemeteryID) {
            if (confirm("<?php echo _('Are you sure you want to unlink this cemetery?'); ?>")) {
                deleteIt('cemlink', cemeteryID, '');
            }
        }

        function copyGeoInfo(cemeteryID) {
            var latitude = document.form1.latitude.value;
            var longitude = document.form1.longitude.value;
            var zoom = document.form1.zoom.value;
            var geo = jQuery('#geo' + cemeteryID);
            geo.attr('src', 'img/spinner.gif');
        geo.css('height', '16px');
        geo.css('width', '16px');

        var params = {cemeteryID: cemeteryID, latitude: latitude, longitude: longitude, zoom: zoom, action: 'geocopy'};
        jQuery.ajax({
            url: 'ajx_updateorder.php',
            data: params,
            dataType: 'json',
            success: function (vars) {
                //add new table row
                if (vars.result == 1) {
                    geo.attr('src', 'img/tng_check.gif');
                    geo.css('height', '18px');
                    geo.css('width', '18px');
                } else
                    alert("Sorry, an error occurred.");
            }
        });
        return false;
    }

    var tnglitbox;

    function pickCemetery() {
        tnglitbox = new LITBox("admin_pickcemetery.php", {
            width: 600, height: 150
        });
    }

        function insertCell(row, index, classname, content) {
            var cell = row.insertCell(index);
            cell.className = classname;
            cell.innerHTML = content ? content : content + '&nbsp;';
            return cell;
        }

        const delmsg = "<?php echo _('Delete'); ?>";

        function addCemLink(cemeteryID) {
            //ajax to add
            var place = '<?php echo urlencode($row['place']); ?>';
            var params = {cemeteryID: cemeteryID, place: place, action: 'addcemlink'};
            jQuery.ajax({
                url: 'ajx_updateorder.php',
                data: params,
                dataType: 'json',
                success: function (vars) {
                    //add new table row
                    var cemtbl = document.getElementById('cemeteries');
                    var newtr = cemtbl.insertRow(cemtbl.rows.length);
                    newtr.id = "row_" + cemeteryID;
                    var actionstr = '<a href="#" onclick="return deleteCemLink(\'' + cemeteryID + '\');" title="' + delmsg + '"  class="smallicon admin-delete-icon"></a>';
                    actionstr += '<a href="#" onclick="return copyGeoInfo(\'' + cemeteryID + '\');\"><img src="img/earth.gif" id="geo' + cemeteryID + '" title="<?php echo _('Copy geocode information below to this cemetery'); ?>" alt="<?php echo _('Copy geocode information below to this cemetery'); ?>" width="15" height="15" class="oldicon"></a>';
                    insertCell(newtr, 0, "nw", actionstr);
                    insertCell(newtr, 1, "nw", vars.location);
                    tnglitbox.remove();
                    var tds = jQuery('tr#row_' + cemeteryID + ' td');
                    jQuery.each(tds, function (index, item) {
                        item.effect('highlight', {}, 1400);
                    })
                }
            });
            return false;
    }
</script>
<?php if ($map['key']) include "googlemaplib2.php"; ?>
    </head>

<?php
$onload = $map['key'] && !$map['startoff'] ? " onload=\"divbox('mapcontainer');\"" : "";
echo tng_adminlayout($onload);

if (!isset($tree)) {
    if (!empty($assignedtree))
        $tree = $assignedtree;
    elseif (!$tngconfig['places1tree'])
        $tree = $row['gedcom'];
}

$placetabs[0] = [1, "admin_places.php", _('Search'), "findplace"];
$placetabs[1] = [$allow_add, "admin_newplace.php", _('Add New'), "addplace"];
$placetabs[2] = [$allow_edit && $allow_delete, "admin_mergeplaces.php", _('Merge'), "merge"];
$placetabs[3] = [$allow_edit, "admin_geocodeform.php", _('Geocode'), "geo"];
$placetabs[4] = [$allow_edit, "#", _('Edit'), "edit"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/places_help.php#add');\" class='lightlink'>" . _('Help for this area') . "</a>";
$innermenu .= " &nbsp;|&nbsp; <a href=\"placesearch.php?psearch=" . urlencode($orgplace) . "\" target='_blank' class='lightlink'>" . _('Test') . "</a>";
$innermenu .= " &nbsp;|&nbsp; <a href=\"admin_newmedia.php?personID={$row['place']}&amp;tree=$tree&amp;linktype=L\" class='lightlink'>" . _('Add Media') . "</a>";
$menu = doMenu($placetabs, "edit", $innermenu);
echo displayHeadline(_('Places') . " &gt;&gt; " . _('Edit Existing Place'), "img/places_icon.gif", $menu, $message);
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <form action="admin_updateplace.php" method="post" name="form1" id="form1" onSubmit="return validateForm();">
                    <p class="plainheader"><?php echo $row['place']; ?></p>
                    <table class="normal w-full">
                        <tr>
                            <td><?php echo _('Tree'); ?>:</td>
                            <td>
                                <?php if (!$tngconfig['places1tree']) { ?>
                                    <?php if (!$row['gedcom']) { ?>
                                        <select name="newtree">
                                            <option value=""></option>
                                            <?php
                                            while ($treerow = tng_fetch_assoc($treeresult)) {
                                                echo "		<option value=\"{$treerow['gedcom']}\">{$treerow['treename']}</option>\n";
                                            }
                                            tng_free_result($treeresult);
                                            ?>
                                        </select>
                                    <?php } else { ?>
                                        <?php echo $treerow['treename']; ?>
                                        <input type="hidden" name="tree" value="<?php echo $row['gedcom']; ?>">
                                    <?php } ?>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Place'); ?>:</td>
                            <td>
                                <input type="text" value="<?php echo $row['place']; ?>" name="place" id="place" size="50" class="longfield">
                            </td>
                        </tr>
                        <?php
                        if (determineLDSRights()) {
                            echo "<tr>";
                            echo "<td>&nbsp;</td>";
                            echo "<td><input type='checkbox' name=\"temple\" value='1'";
                            if ($row['temple']) echo " checked";

                            echo "> " . _('This place name is an LDS temple code') . "</td>";
                            echo "</tr>\n";
                    }
                    if ($map['key']) {
                        ?>
                        <tr>
                            <td colspan="2">
                                <div style="padding:10px;">
                                    <?php
                                    // draw the map here
                                    include "googlemapdrawthemap.php";
                                    ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                        <tr>
                            <td><?php echo _('Latitude'); ?>:</td>
                            <td>
                                <input type="text" name="latitude" value="<?php echo $row['latitude']; ?>" size="20" id="latbox">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Longitude'); ?>:</td>
                            <td>
                                <input type="text" name="longitude" value="<?php echo $row['longitude']; ?>" size="20" id="lonbox">
                            </td>
                        </tr>
                        <?php if ($map['key']) { ?>
                            <tr>
                                <td><?php echo _('Zoom'); ?>:</td>
                                <td>
                                    <input type="text" name="zoom" value="<?php echo $row['zoom']; ?>" size="20" id="zoombox">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Place Level'); ?>:</td>
                                <td>
                                    <select name="placelevel">
                                        <option value=""></option>
                                        <?php
                                        for ($i = 1; $i < 7; $i++) {
                                            echo "<option value=\"$i\"";
                                            if ($i == $row['placelevel']) echo " selected";

                                            echo ">" . $admtext['level' . $i] . "</option>\n";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class='align-top'><?php echo _('Cemeteries'); ?>:</td>
                                <td>
                                    <table id="cemeteries" class="normal" cellpadding="3" cellspacing="1" border="0">
                                        <tbody id="cemeteriestblbody">
                                        <?php
                                        //get cemeteries with no place assoc
                                        $query = "SELECT cemeteryID, cemname, city, county, state, country FROM $cemeteries_table WHERE place = \"{$row['place']}\" ORDER BY cemname";
                                        $cemresult = tng_query($query);
                                        while ($cemrow = tng_fetch_assoc($cemresult)) {
                                            $location = $cemrow['cemname'];
                                            if ($cemrow['city']) {
                                            if ($location) $location .= ", ";

                                            $location .= $cemrow['city'];
                                        }
                                        if ($cemrow['county']) {
                                            if ($location) $location .= ", ";

                                            $location .= $cemrow['county'];
                                        }
                                        if ($cemrow['state']) {
                                            if ($location) $location .= ", ";

                                            $location .= $cemrow['state'];
                                        }
                                        if ($cemrow['country']) {
                                            if ($location) $location .= ", ";
                                            $location .= $cemrow['country'];
                                        }
                                            $actionstr = $allow_delete ? "<a href='#' onclick=\"return deleteCemLink('{$cemrow['cemeteryID']}');\" title=\"" . _('Delete') . "\" class='smallicon admin-delete-icon'></a>" : "&nbsp;";
                                        if ($allow_edit) {
                                            $actionstr .= "<a href='#' onclick=\"return copyGeoInfo('{$cemrow['cemeteryID']}');\"><img src=\"img/earth.gif\" id=\"geo{$cemrow['cemeteryID']}\" title=\"" . _('Copy geocode information below to this cemetery') . "\" alt=\"" . _('Copy geocode information below to this cemetery') . "\" width='15' height='15' class=\"oldicon\"></a>";
                                        }
                                            echo "<tr id=\"row_{$cemrow['cemeteryID']}\">";
                                            echo "<td class='whitespace-no-wrap'>$actionstr</td>";
                                            echo "<td class='whitespace-no-wrap'>$location</td>";
                                            echo "</tr>\n";
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                    <input type="button" value="<?php echo _('Link this place to a cemetery'); ?>" onclick="pickCemetery();">
                                    <img src="img/earth.gif" alt="<?php echo _('Copy geocode information below to this cemetery'); ?>" width="15" height="15" class="oldicon"> = <?php echo _('Copy geocode information below to this cemetery'); ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td class='align-top'><?php echo _('Notes'); ?>:</td>
                            <td><textarea cols="50" rows="5" name="notes"><?php echo $row['notes']; ?></textarea></td>
                        </tr>
                        <?php if (!$assignedbranch) { ?>
                            <tr>
                                <td class="align-top" colspan="2">
                                    <input type="checkbox" name="propagate" value="1" checked> <?php echo _('Make changes to place name in existing events'); ?>:
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td class="align-top" colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php
                                echo _('On save') . ":<br>";
                                echo "<input type='radio' name='newscreen' value='return'> " . _('Return to this page') . "<br>\n";
                                if ($cw) {
                                    echo "<input type='radio' name='newscreen' value=\"close\" checked> " . _('Close this window') . "\n";
                                } else {
                                    echo "<input type='radio' name='newscreen' value=\"none\" checked> " . _('Return to menu') . "\n";
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                    <br>&nbsp;
                    <input type="hidden" name="ID" value="<?php echo "$ID"; ?>">
                    <input type="hidden" name="orgplace" value="<?php echo $row['place']; ?>">
                    <input type="submit" name="submit" accesskey="s" class="btn" value="<?php echo _('Save'); ?>">
                </form>
            </td>
        </tr>

    </table>
<?php echo tng_adminfooter(); ?>
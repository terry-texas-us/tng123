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

if (is_numeric($ID)) {
    $wherestr = "ID = \"$ID\"";
} else {
    $wherestr = "place = \"$ID\"";
    if ($tree && !$tngconfig['places1tree']) {
        $wherestr .= " AND gedcom = \"$tree\"";
    }
}
$query = "SELECT * FROM $places_table WHERE $wherestr";
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
            $wherestr = "WHERE gedcom = \"$assignedtree\"";
        } else {
            $wherestr = "";
        }
        $query = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";
        $treeresult = tng_query($query);
    }
}

$helplang = findhelp("places_help.php");
$placesearch_url = getURL("placesearch", 1);

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['modifyplace'], $flags);

if ($map['key'] && $isConnected) {
    echo "<script type=\"text/javascript\" src=\"{$http}://maps.googleapis.com/maps/api/js?language={$text['glang']}$mapkeystr\"></script>\n";
}
?>
<script src="js/admin.js"></script>
<script type="text/javascript">
    function validateForm() {
        let rval = true;
        if (document.form1.place.value.length == 0) {
            alert("<?php echo $admtext['enterplace']; ?>");
            rval = false;
        }
        return rval;
    }

    function deleteCemLink(cemeteryID) {
        if (confirm("<?php echo $admtext['confdelcemlink']; ?>")) {
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

    const delmsg = "<?php echo $admtext['text_delete']; ?>";

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
                actionstr += '<a href="#" onclick="return copyGeoInfo(\'' + cemeteryID + '\');\"><img src="img/earth.gif" id="geo' + cemeteryID + '" title="<?php echo $admtext['geocopy']; ?>" alt="<?php echo $admtext['geocopy']; ?>" width="15" height="15" class="oldicon"></a>';
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
<?php
if ($map['key']) {
    include "googlemaplib2.php";
}
?>
</head>

<body class="admin-body"<?php if ($map['key']) {
    if (!$map['startoff']) {
        echo " onload=\"divbox('mapcontainer');\"";
    }
} ?>>

<?php
$placetabs[0] = array(1, "admin_places.php", $admtext['search'], "findplace");
$placetabs[1] = array($allow_add, "admin_newplace.php", $admtext['addnew'], "addplace");
$placetabs[2] = array($allow_edit && $allow_delete, "admin_mergeplaces.php", $admtext['merge'], "merge");
$placetabs[3] = array($allow_edit, "admin_geocodeform.php", $admtext['geocode'], "geo");
$placetabs[4] = array($allow_edit, "#", $admtext['edit'], "edit");
$innermenu = "<a href=\"#\" onclick=\"return openHelp('$helplang/places_help.php#add');\" class=\"lightlink\">{$admtext['help']}</a>";
$innermenu .= " &nbsp;|&nbsp; <a href=\"$placesearch_url" . "psearch=" . urlencode($orgplace) . "\" target=\"_blank\" class=\"lightlink\">{$admtext['test']}</a>";
$innermenu .= " &nbsp;|&nbsp; <a href=\"admin_newmedia.php?personID={$row['place']}&amp;tree=$tree&amp;linktype=L\" class=\"lightlink\">{$admtext['addmedia']}</a>";
$menu = doMenu($placetabs, "edit", $innermenu);
echo displayHeadline($admtext['places'] . " &gt;&gt; " . $admtext['modifyplace'], "img/places_icon.gif", $menu, $message);
?>

<table class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <form action="admin_updateplace.php" method="post" name="form1" id="form1" onSubmit="return validateForm();">
                <p class="plainheader"><?php echo $row['place']; ?></p>
                <table class="normal" width="100%">
                    <tr>
                        <td><?php echo $admtext['tree']; ?>:</td>
                        <td>
                            <?php
                            if (!$tngconfig['places1tree']) {
                                if (!$row['gedcom']) {
                                    ?>
                                    <select name="newtree">
                                        <option value=""></option>
                                        <?php
                                        while ($treerow = tng_fetch_assoc($treeresult)) {
                                            echo "		<option value=\"{$treerow['gedcom']}\">{$treerow['treename']}</option>\n";
                                        }
                                        tng_free_result($treeresult);
                                        ?>
                                    </select>
                                    <?php
                                } else {
                                    ?>
                                    <?php echo $treerow['treename']; ?>
                                    <input type="hidden" name="tree" value="<?php echo $row['gedcom']; ?>">
                                    <?php
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $admtext['place']; ?>:</td>
                        <td>
                            <input type="text" value="<?php echo $row['place']; ?>" name="place" id="place" size="50" class="longfield">
                        </td>
                    </tr>
                    <?php
                    if (determineLDSRights()) {
                        echo "<tr>";
                        echo "<td>&nbsp;</td>";
                        echo "<td><input type=\"checkbox\" name=\"temple\" value=\"1\"";
                        if ($row['temple']) {
                            echo " checked";
                        }
                        echo "> {$admtext['istemple']}</td>";
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
                        <?php
                    }
                    ?>
                    <tr>
                        <td><?php echo $admtext['latitude']; ?>:</td>
                        <td>
                            <input type="text" name="latitude" value="<?php echo $row['latitude']; ?>" size="20" id="latbox">
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $admtext['longitude']; ?>:</td>
                        <td>
                            <input type="text" name="longitude" value="<?php echo $row['longitude']; ?>" size="20" id="lonbox">
                        </td>
                    </tr>
                    <?php
                    if ($map['key']) {
                        ?>
                        <tr>
                            <td><?php echo $admtext['zoom']; ?>:</td>
                            <td>
                                <input type="text" name="zoom" value="<?php echo $row['zoom']; ?>" size="20" id="zoombox">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['placelevel']; ?>:</td>
                            <td>
                                <select name="placelevel">
                                    <option value=""></option>
                                    <?php
                                    for ($i = 1; $i < 7; $i++) {
                                        echo "<option value=\"$i\"";
                                        if ($i == $row['placelevel']) {
                                            echo " selected";
                                        }
                                        echo ">" . $admtext['level' . $i] . "</option>\n";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top"><?php echo $admtext['cemeteries']; ?>:</td>
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
                                            if ($location) {
                                                $location .= ", ";
                                            }
                                            $location .= $cemrow['city'];
                                        }
                                        if ($cemrow['county']) {
                                            if ($location) {
                                                $location .= ", ";
                                            }
                                            $location .= $cemrow['county'];
                                        }
                                        if ($cemrow['state']) {
                                            if ($location) {
                                                $location .= ", ";
                                            }
                                            $location .= $cemrow['state'];
                                        }
                                        if ($cemrow['country']) {
                                            if ($location) {
                                                $location .= ", ";
                                            }
                                            $location .= $cemrow['country'];
                                        }
                                        $actionstr = $allow_delete ? "<a href=\"#\" onclick=\"return deleteCemLink('{$cemrow['cemeteryID']}');\" title=\"{$admtext['text_delete']}\" class=\"smallicon admin-delete-icon\"></a>" : "&nbsp;";
                                        if ($allow_edit) {
                                            $actionstr .= "<a href=\"#\" onclick=\"return copyGeoInfo('{$cemrow['cemeteryID']}');\"><img src=\"img/earth.gif\" id=\"geo{$cemrow['cemeteryID']}\" title=\"{$admtext['geocopy']}\" alt=\"{$admtext['geocopy']}\" width=\"15\" height=\"15\" class=\"oldicon\"></a>";
                                        }
                                        echo "<tr id=\"row_{$cemrow['cemeteryID']}\">";
                                        echo "<td class=\"nw\">$actionstr</td>";
                                        echo "<td class=\"nw\">$location</td>";
                                        echo "</tr>\n";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                                <input type="button" value="<?php echo $admtext['linkcem']; ?>" onclick="pickCemetery();">
                                <img src="img/earth.gif" alt="<?php echo $admtext['geocopy']; ?>" width="15" height="15" class="oldicon"> = <?php echo $admtext['geocopy']; ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td valign="top"><?php echo $admtext['notes']; ?>:</td>
                        <td><textarea cols="50" rows="5" name="notes"><?php echo $row['notes']; ?></textarea></td>
                    </tr>
                    <?php
                    if (!$assignedbranch) {
                        ?>
                        <tr>
                            <td valign="top" colspan="2">
                                <input type="checkbox" name="propagate" value="1" checked> <?php echo $admtext['propagate']; ?>:
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td valign="top" colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php
                            echo $admtext['onsave'] . ":<br>";
                            echo "<input type=\"radio\" name=\"newscreen\" value=\"return\"> {$admtext['savereturn']}<br>\n";
                            if ($cw) {
                                echo "<input type=\"radio\" name=\"newscreen\" value=\"close\" checked> {$text['closewindow']}\n";
                            } else {
                                echo "<input type=\"radio\" name=\"newscreen\" value=\"none\" checked> {$admtext['saveback']}\n";
                            }
                            ?>
                        </td>
                    </tr>
                </table>
                <br>&nbsp;
                <input type="hidden" name="ID" value="<?php echo "$ID"; ?>">
                <input type="hidden" name="orgplace" value="<?php echo $row['place']; ?>">
                <input type="submit" name="submit" accesskey="s" class="btn" value="<?php echo $admtext['save']; ?>">
            </form>
        </td>
    </tr>

</table>
<?php echo "<div align=\"right\"><span class='normal'>$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
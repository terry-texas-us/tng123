<?php
$textpart = "search";
$order = "";
$needMap = true;
include "tng_begin.php";

include "searchlib.php";

$heatmap = !isset($mtype) || $mtype == "h";
$markermap = !isset($mtype) || $mtype == "m";

tng_query_noerror(" SET OPTION SQL_BIG_SELECTS = 1 ");

if ($tree) {
    require_once "./admin/trees.php";
    $treerow = getTree($trees_table, $tree);
}

function buildCriteria($column, $colvar, $qualifyvar, $qualifier, $value, $textstr) {
    global $lnprefixes, $criteria_limit, $criteria_count;

    if ($qualifier == "exists" || $qualifier == "dnexist") {
        $value = $usevalue = "";
    } else {
        $value = urldecode(trim($value));
        $usevalue = addslashes($value);
    }

    if ($column == "p.lastname" && $lnprefixes) {
        $column = "TRIM(CONCAT_WS(' ',p.lnprefix,p.lastname))";
    } elseif ($column == "spouse.lastname") {
        $column = "TRIM(CONCAT_WS(' ',spouse.lnprefix,spouse.lastname))";
    }

    $criteria_count++;
    if ($criteria_count >= $criteria_limit) die("sorry");
    $criteria = "";
    $returnarray = buildColumn($qualifier, $column, $usevalue);
    $criteria .= $returnarray['criteria'];
    $qualifystr = $returnarray['qualifystr'];

    addtoQuery($textstr, $colvar, $criteria, $qualifyvar, $qualifier, $qualifystr, $value);
}

@set_time_limit(0);
if (!isset($mybool)) $mybool = "AND";

if (!empty($psearch)) {
    $query = "SELECT place, latitude, longitude, notes FROM $places_table WHERE place LIKE '%$psearch%' AND latitude != '' AND longitude != ''";
    $querystring = _('for') . " " . _('Place') . " " . _('contains') . " " . $psearch;
    if ($tree && !$tngconfig['places1tree']) {
        $query .= " AND gedcom = '$tree'";
        $querystring .= " " . _('AND') . " " . _('Tree') . " " . _('equals') . " {$treerow['treename']}";
    }
    $headline = _('Place List') . " | " . _('Heat Map') . " | " . $psearch;
} elseif (!empty($firstchar)) {
    $query = "SELECT place, latitude, longitude, notes FROM $places_table WHERE place LIKE \"$firstchar%\" AND latitude != \"\" AND longitude != \"\"";
    $querystring = _('for') . " " . _('Place') . " " . _('starts with') . " " . $firstchar;
    if ($tree && !$tngconfig['places1tree']) {
        $query .= " AND gedcom = '$tree'";
        $querystring .= " " . _('AND') . " " . _('Tree') . " " . _('equals') . " {$treerow['treename']}";
    }
    $headline = _('Place List') . " | " . _('Heat Map');
} elseif (!empty($mylastname) || !empty($myfirstname) || !empty($mypersonid) || !empty($mybirthplace) || !empty($mybirthyear) || !empty($myaltbirthplace) || !empty($mydeathplace) || !empty($mydeathyear) || !empty($myburialplace) || !empty($myburialyear) || !empty($mygender) || !empty($branch)) {
    $mylastname = !empty($mylastname) ? trim(stripslashes($mylastname)) : "";
    $myfirstname = !empty($myfirstname) ? trim(stripslashes($myfirstname)) : "";
    $mypersonid = !empty($mypersonid) ? trim(stripslashes($mypersonid)) : "";
    $mybirthplace = !empty($mybirthplace) ? trim(stripslashes($mybirthplace)) : "";
    $mybirthyear = !empty($mybirthyear) ? trim(stripslashes($mybirthyear)) : "";
    $myaltbirthplace = !empty($myaltbirthplace) ? trim(stripslashes($myaltbirthplace)) : "";
    $myaltbirthyear = !empty($myaltbirthyear) ? trim(stripslashes($myaltbirthyear)) : "";
    $mydeathplace = !empty($mydeathplace) ? trim(stripslashes($mydeathplace)) : "";
    $mydeathyear = !empty($mydeathyear) ? trim(stripslashes($mydeathyear)) : "";
    $myburialplace = !empty($myburialplace) ? trim(stripslashes($myburialplace)) : "";
    $myburialyear = !empty($myburialyear) ? trim(stripslashes($myburialyear)) : "";

    $_SERVER['QUERY_STRING'] = str_replace(['&amp;', '&'], ['&', '&amp;'], $_SERVER['QUERY_STRING']);
    $currargs = isset($orderloc) && $orderloc > 0 ? substr($_SERVER['QUERY_STRING'], 0, $orderloc) : $_SERVER['QUERY_STRING'];
    $mybooltext = $mybool == "AND" ? _('AND') : _('OR');

    $querystring = "";
    $allwhere = "";

    if (!empty($mylastname) || (isset($lnqualify) && ($lnqualify == "exists" || $lnqualify == "dnexist"))) {
        if ($mylastname == _('[no surname]')) {
            addtoQuery(_('Last Name'), "mylastname", "lastname = \"\"", "lnqualify", _('equals'), _('equals'), $mylastname);
        } else {
            buildCriteria("p.lastname", "mylastname", "lnqualify", $lnqualify, $mylastname, _('Last Name'));
        }
    }
    if (!empty($myfirstname) || (isset($fnqualify) && ($fnqualify == "exists" || $fnqualify == "dnexist"))) {
        buildCriteria("p.firstname", "myfirstname", "fnqualify", $fnqualify, $myfirstname, _('First Name'));
    }
    if ($mypersonid) {
        $mypersonid = strtoupper($mypersonid);
        if ($idqualify == "equals" && is_numeric($mypersonid)) $mypersonid = $tngconfig['personprefix'] . $mypersonid . $tngconfig['personsuffix'];
        buildCriteria("p.personID", "mypersonid", "idqualify", $idqualify, $mypersonid, _('Person ID'));
    }
    if (!empty($mytitle) || (isset($tqualify) && ($tqualify == "exists" || $tqualify == "dnexist"))) {
        buildCriteria("p.title", "mytitle", "tqualify", $tqualify, $mytitle, _('Title'));
    }
    if (!empty($myprefix) || (isset($pfqualify) && ($pfqualify == "exists" || $pfqualify == "dnexist"))) {
        buildCriteria("p.prefix", "myprefix", "pfqualify", $pfqualify, $myprefix, _('Prefix'));
    }
    if (!empty($mysuffix) || (isset($sfqualify) && ($sfqualify == "exists" || $sfqualify == "dnexist"))) {
        buildCriteria("p.suffix", "mysuffix", "sfqualify", $sfqualify, $mysuffix, _('Suffix'));
    }
    if (!empty($mynickname) || (isset($nnqualify) && ($nnqualify == "exists" || $nnqualify == "dnexist"))) {
        buildCriteria("p.nickname", "mynickname", "nnqualify", $nnqualify, $mynickname, _('Nickname'));
    }
    if (!empty($mybirthplace) || (isset($bpqualify) && ($bpqualify == "exists" || $bpqualify == "dnexist"))) {
        buildCriteria("p.birthplace", "mybirthplace", "bpqualify", $bpqualify, $mybirthplace, _('Birth Place'));
    }
    if (!empty($mybirthyear) || (isset($byqualify) && ($byqualify == "exists" || $byqualify == "dnexist"))) {
        buildYearCriteria("p.birthdatetr", "mybirthyear", "byqualify", "p.altbirthdatetr", $byqualify, $mybirthyear, _('Birth Date (True)'));
    }
    if (!empty($myaltbirthplace) || (isset($cpqualify) && ($cpqualify == "exists" || $cpqualify == "dnexist"))) {
        buildCriteria("p.altbirthplace", "myaltbirthplace", "cpqualify", $cpqualify, $myaltbirthplace, _('Christening Place'));
    }
    if (!empty($myaltbirthyear) || (isset($cyqualify) && ($cyqualify == "exists" || $cyqualify == "dnexist"))) {
        buildYearCriteria("p.altbirthdatetr", "myaltbirthyear", "cyqualify", "", $cyqualify, $myaltbirthyear, _('Christening Year'));
    }
    if (!empty($mydeathplace) || (isset($dpqualify) && ($dpqualify == "exists" || $dpqualify == "dnexist"))) {
        buildCriteria("p.deathplace", "mydeathplace", "dpqualify", $dpqualify, $mydeathplace, _('Death Place'));
    }
    if (!empty($mydeathyear) || (isset($dyqualify) && ($dyqualify == "exists" || $dyqualify == "dnexist"))) {
        buildYearCriteria("p.deathdatetr", "mydeathyear", "dyqualify", "p.burialdatetr", $dyqualify, $mydeathyear, _('Death Date (True)'));
    }
    if (!empty($myburialplace) || (isset($brpqualify) && ($brpqualify == "exists" || $brpqualify == "dnexist"))) {
        buildCriteria("p.burialplace", "myburialplace", "brpqualify", $brpqualify, $myburialplace, _('Burial Place'));
    }
    if (!empty($myburialyear) || (isset($bryqualify) && ($bryqualify == "exists" || $bryqualify == "dnexist"))) {
        buildYearCriteria("p.burialdatetr", "myburialyear", "bryqualify", "", $bryqualify, $myburialyear, _('Burial Date (True)'));
    }
    if (!empty($mygender)) {
        if ($mygender == "N") $mygender = "";
        buildCriteria("p.sex", "mygender", "gequalify", $gequalify, $mygender, _('Gender'));
    }

    if ($tree) {
        if ($urlstring) $urlstring .= "&amp;";
        $urlstring .= "tree=$tree";

        if ($querystring) $querystring .= " " . _('AND') . " ";

        $querystring .= _('Tree') . " " . _('equals') . " {$treerow['treename']}";

        if ($allwhere) $allwhere = "($allwhere) AND";
        $allwhere .= " p.gedcom = '$tree'";

        if ($branch) {
            $urlstring .= "&amp;branch=$branch";
            $querystring .= " " . _('AND') . " ";

            $query = "SELECT description FROM $branches_table WHERE gedcom = '$tree' AND branch = '$branch'";
            $branchresult = tng_query($query);
            $branchrow = tng_fetch_assoc($branchresult);
            tng_free_result($branchresult);

            $querystring .= _('Branch') . " " . _('equals') . " {$branchrow['description']}";

            $allwhere .= " AND p.branch like \"%$branch%\"";
        }
    }

    $gotInput = !empty($mytitle) || !empty($myprefix) || !empty($mysuffix) || !empty($mynickname) || !empty($mybirthplace) || !empty($mydeathplace) || !empty($mybirthyear) || !empty($mydeathyear) || !empty($ecount);
    $more = getLivingPrivateRestrictions("p", $myfirstname, $gotInput);

    if (!empty($more)) {
        if ($allwhere) $allwhere = $tree ? "$allwhere AND " : "($allwhere) AND ";
        $allwhere .= $more;
    }

    $on1 = " ON birthplace = place ";
    $on2 = " ON altbirthplace = place ";

    if ($allwhere) {
        $allwhere = " WHERE " . $allwhere . " AND latitude != \"\" AND longitude != \"\"";
        $querystring = _('for') . " $querystring";
    } else {
        $allwhere = " WHERE latitude != \"\" AND longitude != \"\"";
    }

    $query = "SELECT place, latitude, longitude";
    if ($markermap) {
        $query .= ", p.ID, personID, lastname, lnprefix, firstname, living, private, branch, nickname, prefix, suffix, nameorder, title,
			IF(birthplace, birthplace, altbirthplace) AS birthp, birthdate, altbirthdate, p.gedcom ";
    }
    $query .= "FROM $people_table AS p INNER JOIN $places_table";

    $query = $query . $on1 . $allwhere . " UNION " . $query . $on2 . $allwhere;
    if ($markermap) $query .= " ORDER BY lastname, firstname";
    $headline = _('Search Results') . " | " . _('Heat Map');
} else {
    $query = "SELECT place, latitude, longitude, notes FROM $places_table WHERE latitude != \"\" AND longitude != \"\"";
    if ($tree && !$tngconfig['places1tree']) {
        $query .= " AND gedcom = '$tree'";
        $querystring = _('for') . " " . _('Tree') . " " . _('equals') . " {$treerow['treename']}";
    }
    $headline = _('Place List') . " | " . _('Heat Map');
    $querystr = "";
}

$result = tng_query_noerror($query);
$numrows = tng_num_rows($result);

//pretty much like search, but we're skipping the custom events to begin with
//goal is to end up with a list of places matching the birth places of all the people returned in this search (not just the current page)
//places must have lat & long data and associated person (name)
//we'll then construct a large JS object to feed into the code below

if ($map['key'] && $isConnected) {
    $flags['scripting'] .= "<script src=\"{$http}://maps.googleapis.com/maps/api/js?language=" . _('&amp;hl=en') . "&amp;libraries=visualization{$mapkeystr}\"></script>\n";
}
tng_header($headline, $flags);
?>
    <h2 class="header"><span class="headericon" id="search-hdr-icon"></span><?php echo $headline; ?></h2>
    <br style="clear: left;">
<?php
$logstring = "<a href=\"" . $_SERVER['REQUEST_URI'] . "\">" . xmlcharacters($headline . " $querystring") . "</a>";
writelog($logstring);
preparebookmark($logstring);

echo "<p class='normal'>" . _('Places') . " $querystring (" . number_format($numrows) . ")</p>";

$uniquePlaces = [];
while ($row = tng_fetch_assoc($result)) {
    $key = $row['latitude'] . "_" . $row['longitude'];
    if (!isset($uniquePlaces[$key])) {
        $item = new stdClass();
        $item->latitude = $row['latitude'];
        $item->longitude = $row['longitude'];
        $item->place = $row['place'];
        $item->notes = isset($row['notes']) ? $row['notes'] : "";
        $item->people = [];

        $uniquePlaces[$key] = $item;
    }
    if (isset($row['personID'])) {
        $person = new stdClass();
        $rights = determineLivingPrivateRights($row);
        $row['allow_living'] = $rights['living'];
        $row['allow_private'] = $rights['private'];
        //determine rights?
        $person->name = "<a href=\"getperson.php?personID={$row['personID']}&tree={$row['gedcom']}\">" . getName($row) . "</a>";
        if ($rights['both']) {
            $person->birthplace = $row['birthp'];
            $person->birthdate = $row['birthdate'] ? _('b.') . " " . displayDate($row['birthdate']) : _('c.') . " " . displayDate($row['altbirthdate']);
        }
        $uniquePlaces[$key]->people[] = $person;
    }
}

$index = 0;
$heatOutput = $markerOutput = "";
foreach ($uniquePlaces as $place) {
    if ($index) {
        if ($heatmap) $heatOutput .= ",\n";
        $markerOutput .= ",\n";
    }
    $people = "";
    if ($heatmap) {
        foreach ($place->people as $person) {
            if ($people) $people .= ",";

            if ($session_charset != "UTF-8") {
                $person->name = utf8_encode($person->name);
                $birthplace = utf8_encode($person->birthplace);
                $birthdate = utf8_encode($person->birthdate);
            }

            $name = json_encode(trim($person->name));
            if (!$name) $name = "\"\"";

            $birthplace = json_encode(trim($person->birthplace));
            if (!$birthplace) $birthplace = "\"\"";

            $birthdate = json_encode(trim($person->birthdate));
            if (!$birthdate) $birthdate = "\"\"";

            $people .= "{";
            $people .= "\"name\":$name,";
            $people .= "\"birthplace\":$birthplace,\"birthdate\":$birthdate";
            $people .= "}";
        }
        $heatOutput .= "new google.maps.LatLng({$place->latitude}, {$place->longitude})";
    }
    if ($session_charset != "UTF-8") {
        $thisplace = utf8_encode(trim($place->place));
        $notes = utf8_encode(trim($place->notes));
        $latitude = utf8_encode($place->latitude);
        $longitude = utf8_encode($place->longitude);
    } else {
        $thisplace = trim($place->place);
        $notes = trim($place->notes);
    }

    $thisplace = json_encode($thisplace);
    if (!$thisplace || $thisplace == "null") $thisplace = "\"\"";

    $notes = json_encode($notes);
    if (!$notes) $notes = "\"\"";

    $latitude = json_encode(trim($place->latitude));
    if (!$latitude) $latitude = 0;

    $longitude = json_encode(trim($place->longitude));
    if (!$longitude) $longitude = 0;

    $markerOutput .= "{\"place\":$thisplace,\"latitude\":$latitude,\"longitude\":$longitude,\"people\":[{$people}],\"notes\":$notes}";
    $index++;
}
if ($markermap) {
    ?>
    <script src="js/markerclusterer.js"></script>
<?php } ?>
    <script>
        //<![CDATA[
        var maploaded = false;
        var map = null;
        var bounds;
        var data = {
            "places": [<?php echo $markerOutput; ?>]
        }
        <?php if ($markermap) { ?>
        var markerClusterer = null;
        var infoWindow = new google.maps.InfoWindow();
        var imageUrl = 'http://chart.apis.google.com/chart?cht=mm&chs=24x32&chco=FFFFFF,008CFF,000000&ext=.png';
        <?php } ?>

        function refreshMap() {
            <?php if ($markermap) { ?>
            var markers = [];
            <?php } ?>

            for (var i = 0; i < data.places.length; i++) {
                var latLng = new google.maps.LatLng(data.places[i].latitude, data.places[i].longitude)

                <?php if ($markermap) { ?>
                var imageUrl = 'http://chart.apis.google.com/chart?cht=mm&chs=24x32&chco=FFFFFF,008CFF,000000&ext=.png';
                var markerImage = new google.maps.MarkerImage(imageUrl, new google.maps.Size(24, 32));

                var marker = new google.maps.Marker({
                    'position': latLng
                });

                var fn = markerClickFunction(data.places[i], latLng);
                google.maps.event.addListener(marker, 'click', fn);
                markers.push(marker);
                <?php } ?>
                bounds.extend(latLng);
            }

            <?php if ($markermap) { ?>
            markerClusterer = new MarkerClusterer(map, markers, {
                imagePath: 'img/m'
            });
            <?php } ?>

            if (data.places.length > 1) {
                google.maps.event.addListenerOnce(map, 'zoom_changed', function () {
                    var oldZoom = map.getZoom();
                    if (oldZoom > 8)
                        map.setZoom(8); //Or whatever
                });
                map.fitBounds(bounds);
                map.setCenter(bounds.getCenter());
            } else if (data.places.length === 1) {
                map.setCenter(bounds.getCenter());
                map.setZoom(8);
            } else {
                map.setCenter(bounds.getCenter());
                map.setZoom(2);
            }
        }

        <?php if ($markermap) { ?>
        var markerClickFunction = function (place, latlng) {
            return function (e) {
                e.cancelBubble = true;
                e.returnValue = false;
                if (e.stopPropagation) {
                    e.stopPropagation();
                    e.preventDefault();
                }

                var people = "";
                for (var i = 0; i < place.people.length; i++) {
                    people += place.people[i].name;
                    if (place.people[i].birthdate)
                        people += " (" + place.people[i].birthdate + ")";
                    people += "<br>";
                }
                var infoHtml = '<div class="info"><h4 style="margin-top:0;"><a href="' + 'placesearch.php?psearch=' + place.place + '">' + place.place + '</a></h4>';
                if (people !== "") infoHtml += '<div class="info-body">' + people + '</div>';
                if (place.notes !== "") infoHtml += '<div class="info-body">' + place.notes + '</div>';
                infoHtml += '</div>';

                infoWindow.setContent(infoHtml);
                infoWindow.setPosition(latlng);
                infoWindow.open(map);
            };
        };

        function clearClusters(e) {
            e.preventDefault();
            e.stopPropagation();
            markerClusterer.clearMarkers();
        }
        <?php } ?>

        function ShowTheMap() {
            var myOptions = {
                scrollwheel: false,
                scaleControl: true,
                mapTypeId: google.maps.MapTypeId.TERRAIN
            };
            map = new google.maps.Map(document.getElementById('map'), myOptions);
            bounds = new google.maps.LatLngBounds();

            <?php if ($heatmap) { ?>
            var heatMapData = [<?php echo $heatOutput; ?>];

            var heatmap = new google.maps.visualization.HeatmapLayer({
                data: heatMapData
            });
            heatmap.setOptions({radius: heatmap.get('20')});
            heatmap.setMap(map);
            <?php } ?>

            <?php if ($markermap) { ?>
            var refresh = document.getElementById('refresh');
            google.maps.event.addDomListener(refresh, 'click', refreshMap);

            var clear = document.getElementById('clear');
            google.maps.event.addDomListener(clear, 'click', clearClusters);
            <?php } ?>
            refreshMap();

            maploaded = true;
        }

        function displayMap() {
            if (jQuery('#map').length) ShowTheMap();
        }

        window.onload = displayMap;
        //]]>
    </script>

    <div id="map" class="rounded-lg w-full" style="height: 500px;"></div>
<?php if ($markermap) { ?>
    <br>
    <div id="inline-actions">
        <input id="refresh" type="button" value="<?php echo _('Refresh Map'); ?>" class="item">
        <a href="#" id="clear"><?php echo _('Clear Numbers and Pins'); ?></a>
    </div>
<?php } ?>

<?php tng_footer(""); ?>
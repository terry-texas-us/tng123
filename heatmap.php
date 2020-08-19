<?php
$textpart = "search";
$order = "";
$needMap = true;
include "tng_begin.php";

include $cms['tngpath'] . "searchlib.php";

$placesearch_url = getURL("placesearch", 1);
$getperson_url = getURL("getperson", 1);

$heatmap = $mtype == "h" || !isset($mtype);
$markermap = $mtype == "m" || !isset($mtype);

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
  if ($criteria_count >= $criteria_limit) {
    die("sorry");
  }
  $criteria = "";
  $returnarray = buildColumn($qualifier, $column, $usevalue);
  $criteria .= $returnarray['criteria'];
  $qualifystr = $returnarray['qualifystr'];

  addtoQuery($textstr, $colvar, $criteria, $qualifyvar, $qualifier, $qualifystr, $value);
}

@set_time_limit(0);
if (!isset($mybool)) {
  $mybool = "AND";
}

if ($psearch) {
  $query = "SELECT place, latitude, longitude, notes FROM $places_table WHERE place LIKE \"%$psearch%\" AND latitude != \"\" AND longitude != \"\"";
  $querystring = $text['text_for'] . " " . $text['place'] . " " . $text['contains'] . " " . $psearch;
  if ($tree && !$tngconfig['places1tree']) {
    $query .= " AND gedcom = \"$tree\"";
    $querystring .= " {$text['cap_and']} " . $text['tree'] . " {$text['equals']} {$treerow['treename']}";
  }
  $headline = $text['placelist'] . " | " . $text['heatmap'] . " | " . $psearch;
} elseif ($firstchar) {
  $query = "SELECT place, latitude, longitude, notes FROM $places_table WHERE place LIKE \"$firstchar%\" AND latitude != \"\" AND longitude != \"\"";
  $querystring = $text['text_for'] . " " . $text['place'] . " " . $text['startswith'] . " " . $firstchar;
  if ($tree && !$tngconfig['places1tree']) {
    $query .= " AND gedcom = \"$tree\"";
    $querystring .= " {$text['cap_and']} " . $text['tree'] . " {$text['equals']} {$treerow['treename']}";
  }
  $headline = $text['placelist'] . " | " . $text['heatmap'];
} elseif ($mylastname || $myfirstname || $mypersonid || $mybirthplace || $mybirthyear || $myaltbirthplace || $mydeathplace || $mydeathyear || $myburialplace || $myburialyear || $mygender || $branch) {
  $mylastname = trim(stripslashes($mylastname));
  $myfirstname = trim(stripslashes($myfirstname));
  $mypersonid = trim(stripslashes($mypersonid));
  $mybirthplace = trim(stripslashes($mybirthplace));
  $mybirthyear = trim(stripslashes($mybirthyear));
  $myaltbirthplace = trim(stripslashes($myaltbirthplace));
  $myaltbirthyear = trim(stripslashes($myaltbirthyear));
  $mydeathplace = trim(stripslashes($mydeathplace));
  $mydeathyear = trim(stripslashes($mydeathyear));
  $myburialplace = trim(stripslashes($myburialplace));
  $myburialyear = trim(stripslashes($myburialyear));

  $_SERVER['QUERY_STRING'] = str_replace(array('&amp;', '&'), array('&', '&amp;'), $_SERVER['QUERY_STRING']);
  $currargs = $orderloc > 0 ? substr($_SERVER['QUERY_STRING'], 0, $orderloc) : $_SERVER['QUERY_STRING'];
  $mybooltext = $mybool == "AND" ? $text['cap_and'] : $text['cap_or'];

  $querystring = "";
  $allwhere = "";

  if ($mylastname || $lnqualify == "exists" || $lnqualify == "dnexist") {
    if ($mylastname == $text['nosurname']) {
      addtoQuery($text['lastname'], "mylastname", "lastname = \"\"", "lnqualify", $text['equals'], $text['equals'], $mylastname);
    } else {
      buildCriteria("p.lastname", "mylastname", "lnqualify", $lnqualify, $mylastname, $text['lastname']);
    }
  }
  if ($myfirstname || $fnqualify == "exists" || $fnqualify == "dnexist") {
    buildCriteria("p.firstname", "myfirstname", "fnqualify", $fnqualify, $myfirstname, $text['firstname']);
  }
  if ($mypersonid) {
    $mypersonid = strtoupper($mypersonid);
    if ($idqualify == "equals" && is_numeric($mypersonid)) {
      $mypersonid = $personprefix . $mypersonid . $personsuffix;
    }
    buildCriteria("p.personID", "mypersonid", "idqualify", $idqualify, $mypersonid, $text['personid']);
  }
  if ($mytitle || $tqualify == "exists" || $tqualify == "dnexist") {
    buildCriteria("p.title", "mytitle", "tqualify", $tqualify, $mytitle, $text['title']);
  }
  if ($myprefix || $pfqualify == "exists" || $pfqualify == "dnexist") {
    buildCriteria("p.prefix", "myprefix", "pfqualify", $pfqualify, $myprefix, $text['prefix']);
  }
  if ($mysuffix || $sfqualify == "exists" || $sfqualify == "dnexist") {
    buildCriteria("p.suffix", "mysuffix", "sfqualify", $sfqualify, $mysuffix, $text['suffix']);
  }
  if ($mynickname || $nnqualify == "exists" || $nnqualify == "dnexist") {
    buildCriteria("p.nickname", "mynickname", "nnqualify", $nnqualify, $mynickname, $text['nickname']);
  }
  if ($mybirthplace || $bpqualify == "exists" || $bpqualify == "dnexist") {
    buildCriteria("p.birthplace", "mybirthplace", "bpqualify", $bpqualify, $mybirthplace, $text['birthplace']);
  }
  if ($mybirthyear || $byqualify == "exists" || $byqualify == "dnexist") {
    buildYearCriteria("p.birthdatetr", "mybirthyear", "byqualify", "p.altbirthdatetr", $byqualify, $mybirthyear, $text['birthdatetr']);
  }
  if ($myaltbirthplace || $cpqualify == "exists" || $cpqualify == "dnexist") {
    buildCriteria("p.altbirthplace", "myaltbirthplace", "cpqualify", $cpqualify, $myaltbirthplace, $text['altbirthplace']);
  }
  if ($myaltbirthyear || $cyqualify == "exists" || $cyqualify == "dnexist") {
    buildYearCriteria("p.altbirthdatetr", "myaltbirthyear", "cyqualify", "", $cyqualify, $myaltbirthyear, $text['altbirthdatetr']);
  }
  if ($mydeathplace || $dpqualify == "exists" || $dpqualify == "dnexist") {
    buildCriteria("p.deathplace", "mydeathplace", "dpqualify", $dpqualify, $mydeathplace, $text['deathplace']);
  }
  if ($mydeathyear || $dyqualify == "exists" || $dyqualify == "dnexist") {
    buildYearCriteria("p.deathdatetr", "mydeathyear", "dyqualify", "p.burialdatetr", $dyqualify, $mydeathyear, $text['deathdatetr']);
  }
  if ($myburialplace || $brpqualify == "exists" || $brpqualify == "dnexist") {
    buildCriteria("p.burialplace", "myburialplace", "brpqualify", $brpqualify, $myburialplace, $text['burialplace']);
  }
  if ($myburialyear || $bryqualify == "exists" || $bryqualify == "dnexist") {
    buildYearCriteria("p.burialdatetr", "myburialyear", "bryqualify", "", $bryqualify, $myburialyear, $text['burialdatetr']);
  }
  if ($mygender) {
    if ($mygender == "N") {
      $mygender = "";
    }
    buildCriteria("p.sex", "mygender", "gequalify", $gequalify, $mygender, $text['gender']);
  }

  if ($tree) {
    if ($urlstring) {
      $urlstring .= "&amp;";
    }
    $urlstring .= "tree=$tree";

    if ($querystring) {
      $querystring .= " {$text['cap_and']} ";
    }

    $querystring .= $text['tree'] . " {$text['equals']} {$treerow['treename']}";

    if ($allwhere) {
      $allwhere = "($allwhere) AND";
    }
    $allwhere .= " p.gedcom=\"$tree\"";

    if ($branch) {
      $urlstring .= "&amp;branch=$branch";
      $querystring .= " {$text['cap_and']} ";

      $query = "SELECT description FROM $branches_table WHERE gedcom = \"$tree\" AND branch = \"$branch\"";
      $branchresult = tng_query($query);
      $branchrow = tng_fetch_assoc($branchresult);
      tng_free_result($branchresult);

      $querystring .= $text['branch'] . " {$text['equals']} {$branchrow['description']}";

      $allwhere .= " AND p.branch like \"%$branch%\"";
    }
  }

  $gotInput = $mytitle || $myprefix || $mysuffix || $mynickname || $mybirthplace || $mydeathplace || $mybirthyear || $mydeathyear || $ecount;
  $more = getLivingPrivateRestrictions("p", $myfirstname, $gotInput);

  if ($more) {
    if ($allwhere) {
      $allwhere = $tree ? "$allwhere AND " : "($allwhere) AND ";
    }
    $allwhere .= $more;
  }

  $on1 = " ON birthplace = place ";
  $on2 = " ON altbirthplace = place ";

  if ($allwhere) {
    $allwhere = " WHERE " . $allwhere . " AND latitude != \"\" AND longitude != \"\"";
    $querystring = $text['text_for'] . " $querystring";
  } else {
    $allwhere = " WHERE latitude != \"\" AND longitude != \"\"";
  }

  $query = "SELECT place, latitude, longitude";
  if ($markermap) {
    $query .= ", p.ID, personID, lastname, lnprefix, firstname, living, private, branch, nickname, prefix, suffix, nameorder, title,
			IF(birthplace, birthplace, altbirthplace) as birthp, birthdate, altbirthdate, p.gedcom ";
  }
  $query .= "FROM $people_table AS p INNER JOIN $places_table";

  $query = $query . $on1 . $allwhere . " UNION " . $query . $on2 . $allwhere;
  if ($markermap) {
    $query .= " ORDER BY lastname, firstname";
  }
  $headline = $text['searchresults'] . " | " . $text['heatmap'];
} else {
  $query = "SELECT place, latitude, longitude, notes FROM $places_table WHERE latitude != \"\" AND longitude != \"\"";
  if ($tree && !$tngconfig['places1tree']) {
    $query .= " AND gedcom = \"$tree\"";
    $querystring = $text['text_for'] . " " . $text['tree'] . " {$text['equals']} {$treerow['treename']}";
  }
  $headline = $text['placelist'] . " | " . $text['heatmap'];
  $querystr = "";
}

//echo $query;
$result = tng_query_noerror($query);
$numrows = tng_num_rows($result);

//pretty much like search, but we're skipping the custom events to begin with
//goal is to end up with a list of places matching the birth places of all the people returned in this search (not just the current page)
//places must have lat & long data and associated person (name)
//we'll then construct a large JS object to feed into the code below

if ($map['key'] && $isConnected) {
  $flags['scripting'] .= "<script type=\"text/javascript\" src=\"{$http}://maps.googleapis.com/maps/api/js?language={$text['glang']}&amp;libraries=visualization{$mapkeystr}\"></script>\n";
}

tng_header($headline, $flags);
?>

    <h1 class="header"><span class="headericon" id="search-hdr-icon"></span><?php echo $headline; ?></h1><br clear="left"/>
<?php
$logstring = "<a href=\"" . $_SERVER['REQUEST_URI'] . "\">" . xmlcharacters($headline . " $querystring") . "</a>";
writelog($logstring);
preparebookmark($logstring);

echo "<p class=\"normal\">{$text['places']} $querystring (" . number_format($numrows) . ")</p>";

$uniquePlaces = array();
while ($row = tng_fetch_assoc($result)) {
  $key = $row['latitude'] . "_" . $row['longitude'];
  if (!isset($uniquePlaces[$key])) {
    $item = new stdClass();
    $item->latitude = $row['latitude'];
    $item->longitude = $row['longitude'];
    $item->place = $row['place'];
    $item->notes = isset($row['notes']) ? $row['notes'] : "";
    $item->people = array();

    $uniquePlaces[$key] = $item;
  }
  if (isset($row['personID'])) {
    $person = new stdClass();
    $rights = determineLivingPrivateRights($row);
    $row['allow_living'] = $rights['living'];
    $row['allow_private'] = $rights['private'];
    //determine rights?
    $person->name = "<a href=\"{$getperson_url}personID={$row['personID']}&tree={$row['gedcom']}\">" . getName($row) . "</a>";
    if ($rights['both']) {
      $person->birthplace = $row['birthp'];
      $person->birthdate = $row['birthdate'] ? $text['birthabbr'] . " " . displayDate($row['birthdate']) : $text['chrabbr'] . " " . displayDate($row['altbirthdate']);
    }
    $uniquePlaces[$key]->people[] = $person;
  }
}

$index = 0;
$heatOutput = $markerOutput = "";
foreach ($uniquePlaces as $place) {
  if ($index) {
    if ($heatmap) {
      $heatOutput .= ",\n";
    }
    $markerOutput .= ",\n";
  }
  $people = "";
  if ($heatmap) {
    foreach ($place->people as $person) {
      if ($people) {
        $people .= ",";
      }

      if ($session_charset != "UTF-8") {
        $person->name = utf8_encode($person->name);
        $birthplace = utf8_encode($person->birthplace);
        $birthdate = utf8_encode($person->birthdate);
      }

      $name = json_encode(trim($person->name));
      if (!$name) {
        $name = "\"\"";
      }

      $birthplace = json_encode(trim($person->birthplace));
      if (!$birthplace) {
        $birthplace = "\"\"";
      }

      $birthdate = json_encode(trim($person->birthdate));
      if (!$birthdate) {
        $birthdate = "\"\"";
      }

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
  if (!$thisplace || $thisplace == "null") {
    $thisplace = "\"\"";
  }

  $notes = json_encode($notes);
  if (!$notes) {
    $notes = "\"\"";
  }

  $latitude = json_encode(trim($place->latitude));
  if (!$latitude) {
    $latitude = 0;
  }

  $longitude = json_encode(trim($place->longitude));
  if (!$longitude) {
    $longitude = 0;
  }

  $markerOutput .= "{\"place\":$thisplace,\"latitude\":$latitude,\"longitude\":$longitude,\"people\":[{$people}],\"notes\":$notes}";
  $index++;
}
if ($markermap) {
  ?>
    <script type="text/javascript" src="js/markerclusterer.js"></script>
  <?php
}
?>
    <script type="text/javascript">
        //<![CDATA[
        var maploaded = false;
        var map = null;
        var bounds;
        var data = {
            "places": [<?php echo $markerOutput; ?>]
        }
        <?php
        if($markermap) {
        ?>
        var cmstngpath = '<?php echo $cms['tngpath']; ?>';
        var markerClusterer = null;
        var infoWindow = new google.maps.InfoWindow();
        var imageUrl = 'http://chart.apis.google.com/chart?cht=mm&chs=24x32&chco=FFFFFF,008CFF,000000&ext=.png';
        <?php
        }
        ?>

        function refreshMap() {
          <?php
          if($markermap) {
          ?>
            var markers = [];
            var markerImage = new google.maps.MarkerImage(imageUrl, new google.maps.Size(24, 32));
          <?php
          }
          ?>

            for (var i = 0; i < data.places.length; i++) {
                var latLng = new google.maps.LatLng(data.places[i].latitude, data.places[i].longitude)

              <?php
              if($markermap) {
              ?>
                var imageUrl = 'http://chart.apis.google.com/chart?cht=mm&chs=24x32&chco=FFFFFF,008CFF,000000&ext=.png';
                var markerImage = new google.maps.MarkerImage(imageUrl, new google.maps.Size(24, 32));

                var marker = new google.maps.Marker({
                    'position': latLng
                });

                var fn = markerClickFunction(data.places[i], latLng);
                google.maps.event.addListener(marker, 'click', fn);
                markers.push(marker);
              <?php
              }
              ?>
                bounds.extend(latLng);
            }

          <?php
          if($markermap) {
          ?>
            markerClusterer = new MarkerClusterer(map, markers, {
                imagePath: 'https://cdn.rawgit.com/googlemaps/js-marker-clusterer/gh-pages/images/m'
            });
          <?php
          }
          ?>

            if (data.places.length > 1) {
                google.maps.event.addListenerOnce(map, 'zoom_changed', function () {
                    var oldZoom = map.getZoom();
                    if (oldZoom > 8)
                        map.setZoom(8); //Or whatever
                });
                map.fitBounds(bounds);
                map.setCenter(bounds.getCenter());
            } else if (data.places.length == 1) {
                map.setCenter(bounds.getCenter());
                map.setZoom(8);
            } else {
                map.setCenter(bounds.getCenter());
                map.setZoom(2);
            }
        }

        <?php
        if($markermap) {
        ?>
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
                var infoHtml = '<div class="info"><h4 style="margin-top:0px"><a href="' + cmstngpath + 'placesearch.php?psearch=' + place.place + '">' + place.place + '</a></h4>';
                if (people != "")
                    infoHtml += '<div class="info-body">' + people + '</div>';
                if (place.notes != "")
                    infoHtml += '<div class="info-body">' + place.notes + '</div>';
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
        <?php
        }
        ?>

        function ShowTheMap() {
            var myOptions = {
                scrollwheel: false,
                scaleControl: true,
                mapTypeId: google.maps.MapTypeId.TERRAIN
            };
            map = new google.maps.Map(document.getElementById('map'), myOptions);
            bounds = new google.maps.LatLngBounds();

          <?php
          if($heatmap) {
          ?>
            var heatMapData = [<?php echo $heatOutput; ?>];

            var heatmap = new google.maps.visualization.HeatmapLayer({
                data: heatMapData
            });
            heatmap.setOptions({radius: heatmap.get('20')});
            heatmap.setMap(map);
          <?php
          }
          ?>

          <?php
          if($markermap) {
          ?>
            var refresh = document.getElementById('refresh');
            google.maps.event.addDomListener(refresh, 'click', refreshMap);

            var clear = document.getElementById('clear');
            google.maps.event.addDomListener(clear, 'click', clearClusters);
          <?php
          }
          ?>
            refreshMap();

            maploaded = true;
        }

        function displayMap() {
            if (jQuery('#map').length) {
                ShowTheMap();
            }
        }

        window.onload = displayMap;
        //]]>
    </script>

    <div id="map" class="rounded10" style="width: 100%; height: 500px;"></div>
<?php
if ($markermap) {
  ?>
    <br/>
    <div id="inline-actions">
        <input id="refresh" type="button" value="<?php echo $text['refreshmap']; ?>" class="item"/>
        <a href="#" id="clear"><?php echo $text['remnums']; ?></a>
    </div>
  <?php
}
?>

<?php
tng_footer("");
?>
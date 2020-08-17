<?php
$textpart = "timeline";
include "tng_begin.php";

include($cms['tngpath'] . "datelib.php");

$timeline = $_SESSION['timeline'];
if (!is_array($timeline)) {
  $timeline = array();
}

function getTimelineDate($date) {
  $ret = array();

  preg_match('/(\d\d\d\d)-(\d\d)-(\d\d).*/', $date, $matches);
  if ($matches[2] == "00") {
    $matches[2] = "01";
  }
  if ($matches[3] == "00") {
    $matches[3] = "01";
  }
  $ret['year'] = $matches[1];
  $ret['date_gmt'] = strftime("%b %d {$ret['year']}", gmmktime(12, 0, 0, $matches[2], $matches[3], 2000)) . " GMT";

  return $ret;
}

header('Content-Type: application/xml');
echo "<?xml version=\"1.0\"";
if ($session_charset) {
  echo " encoding=\"$session_charset\"";
}
echo "?>\n";
echo "<data>\n";

$righttree = checktree($timetree);

foreach ($timeline as $timeentry) {
  parse_str($timeentry, $output);
  $query = "SELECT firstname, lnprefix, lastname, prefix, suffix, nameorder, living, private, branch, sex, gedcom, 
		birthdate, birthdatetr, birthplace, deathdate, deathdatetr, deathplace, altbirthdate, altbirthdatetr, altbirthplace, burialdate, burialdatetr, burialplace,
		IF(birthdatetr !='0000-00-00',birthdatetr,altbirthdatetr) as birth, 
		IF(deathdatetr !='0000-00-00',deathdatetr,burialdatetr) as death
		FROM $people_table WHERE personID = \"{$output['timeperson']}\" AND gedcom = \"{$output['timetree']}\"";
  $result = tng_query($query);
  $row = tng_fetch_assoc($result);

  $beg_date = getTimelineDate($row['birth']);
  $beg_year = $beg_date['year'];
  $beg_date_gmt = $beg_date['date_gmt'];
  if ($row['death'] != "0000-00-00") {
    $end_date = getTimelineDate($row['death']);
    $end_year = $end_date['year'];
    $end_date_gmt = $end_date['date_gmt'];
  } else {
    $end_date_gmt = date("M d Y") . " GMT";
    $end_year = "";
  }
  $rights = determineLivingPrivateRights($row, $righttree);
  $row['allow_living'] = $rights['living'];
  $row['allow_private'] = $rights['private'];
  $name = xmlcharacters(getName($row));
  echo "<event start=\"" . $beg_date_gmt . "\" end=\"" . $end_date_gmt . "\" title=\"$name ($beg_year - $end_year)\">{$text['birthabbr']} " . displayDate($row['birthdate']) . " - {$text['deathabbr']} " . displayDate($row['deathdate']) . "</event>\n";

  if ($output['timeperson'] == $primary) {
    if ($row['birthdatetr'] != "0000-00-00") {
      $evdate = getTimelineDate($row['birthdatetr']);
      $evdate_gmt = $evdate['date_gmt'];
      $evdateinfo = displayDate($row['birthdate']);
      if ($row['birthplace']) {
        $evdateinfo .= ", " . $row['birthplace'];
      }
      echo "<event start=\"" . $evdate_gmt . "\" end=\"" . $evdate_gmt . "\" icon=\"img/green-circle.png\" title=\"{$text['born']} ($name)\">$evdateinfo</event>\n";
    }
    if ($row['altbirthdatetr'] != "0000-00-00") {
      $evdate = getTimelineDate($row['altbirthdatetr']);
      $evdate_gmt = $evdate['date_gmt'];
      $evdateinfo = displayDate($row['altbirthdate']);
      if ($row['altbirthplace']) {
        $evdateinfo .= ", " . $row['altbirthplace'];
      }
      echo "<event start=\"" . $evdate_gmt . "\" end=\"" . $evdate_gmt . "\" icon=\"img/green-circle.png\" title=\"{$text['christened']} ($name)\">$evdateinfo</event>\n";
    }
    if ($row['deathdatetr'] != "0000-00-00") {
      $evdate = getTimelineDate($row['deathdatetr']);
      $evdate_gmt = $evdate['date_gmt'];
      $evdateinfo = displayDate($row['deathdate']);
      if ($row['deathplace']) {
        $evdateinfo .= ", " . $row['deathplace'];
      }
      echo "<event start=\"" . $evdate_gmt . "\" end=\"" . $evdate_gmt . "\" icon=\"img/green-circle.png\" title=\"{$text['died']} ($name)\">$evdateinfo</event>\n";
    }
    if ($row['burialdatetr'] != "0000-00-00") {
      $evdate = getTimelineDate($row['burialdatetr']);
      $evdate_gmt = $evdate['date_gmt'];
      $evdateinfo = displayDate($row['burialdate']);
      if ($row['burialplace']) {
        $evdateinfo .= ", " . $row['burialplace'];
      }
      echo "<event start=\"" . $evdate_gmt . "\" end=\"" . $evdate_gmt . "\" icon=\"img/green-circle.png\" title=\"{$text['buried']} ($name)\">$evdateinfo</event>\n";
    }
  }
  tng_free_result($result);

  if ($rights['both']) {
    $query = "SELECT display, eventdate, eventdatetr, eventplace, info FROM ($events_table, $eventtypes_table)
			WHERE persfamID = \"{$output['timeperson']}\" AND $events_table.eventtypeID = $eventtypes_table.eventtypeID AND gedcom = \"{$output['timetree']}\" AND keep = \"1\" AND parenttag = \"\"
			ORDER BY ordernum, tag, description, eventdatetr, info, eventID";
    $custevents = tng_query($query);
    while ($custevent = tng_fetch_assoc($custevents)) {
      if ($custevent['eventdatetr'] != "0000-00-00") {
        $displayval = getEventDisplay($custevent['display']);
        $eventDate = displayDate($custevent['eventdate']);

        $beg_date = getTimelineDate($custevent['eventdatetr']);
        $beg_year = $beg_date['year'];
        $beg_date_gmt = $beg_date['date_gmt'];

        $end_date = "";
        $got_to = stripos($custevent['eventdate'], "to ");
        if ($got_to) {
          $end_date = substr($custevent['eventdate'], $got_to + 3);
        } else {
          $got_and = stripos($custevent['eventdate'], "and ");
          if ($got_and) {
            $end_date = substr($custevent['eventdate'], $got_and + 4);
          }
        }
        if ($end_date) {
          $end_date_array = getTimelineDate(convertDate($end_date));
          $end_date_gmt = $end_date_array['date_gmt'];
        } else {
          $end_date_gmt = $beg_date_gmt;
        }
        //if eventdate contains "to" or "and", take the rest of that string and do a similar match for the end date

        $info = $custevent['eventplace'];
        $info .= $info && $custevent['info'] ? ": " . xmlcharacters($custevent['info']) : xmlcharacters($custevent['info']);
        $title = xmlcharacters("$displayval ($eventDate)");
        echo "<event start=\"" . $beg_date_gmt . "\" end=\"" . $end_date_gmt . "\" icon=\"img/green-circle.png\" title=\" $title\">$info</event>\n";
      }
    }
    tng_free_result($custevents);

    if ($row['sex'] == "M") {
      $self = "husband";
      $spouse = "wife";
      $spouseorder = "husborder";
    } elseif ($row['sex'] == "F") {
      $self = "wife";
      $spouse = "husband";
      $spouseorder = "wifeorder";
    } else {
      $self = "";
      $spouse = "";
      $spouseorder = "";
    }
    //get and loop through all marriages (link to people table on opposite spouse) for this person based on gender
    if ($spouseorder) {
      $marriages = getSpouseFamilyDataPlusDates($output['timetree'], $self, $output['timeperson'], $spouseorder);
    } else {
      $marriages = getSpouseFamilyDataUnionPlusDates($output['timetree'], $output['timeperson']);
    }
    if (!tng_num_rows($marriages) && $spouseorder) {
      $marriages = getSpouseFamilyDataUnionPlusDates($output['timetree'], $output['timeperson']);
    }

    while ($marriagerow = tng_fetch_assoc($marriages)) {
      //do event for marriage date and person (observe living rights)
      if (substr($marriagerow['marrdatetr'], 0, 4) != "0000") {
        if (!$spouseorder) {
          $spouse = $marriagerow['husband'] == $output['timeperson'] ? wife : husband;
        }
        unset($spouserow);
        if ($marriagerow[$spouse]) {
          $spouseresult = getPersonSimple($output['timetree'], $marriagerow[$spouse]);
          $spouserow = tng_fetch_assoc($spouseresult);
          $srights = determineLivingPrivateRights($spouserow, $righttree);
          $spouserow['allow_living'] = $srights['living'];
          $spouserow['allow_private'] = $srights['private'];
          if ($spouserow['firstname'] || $spouserow['lastname']) {
            $spousename = getName($spouserow);
          }
          tng_free_result($spouseresult);
        }

        $rightfbranch = checkbranch($marriagerow['branch']) ? 1 : 0;
        $mrights = determineLivingPrivateRights($marriagerow, $righttree, $rightfbranch);
        $marriagerow['allow_living'] = $mrights['living'];
        $marriagerow['allow_private'] = $mrights['private'];
        if ($mrights['both']) {
          $beg_date = getTimelineDate($marriagerow['marrdatetr']);
          $beg_year = $beg_date['year'];
          $beg_date_gmt = $beg_date['date_gmt'];
          $displayDate = displayDate($marriagerow['marrdate']);

          echo "<event start=\"" . $beg_date_gmt . "\" end=\"" . $beg_date_gmt . "\" title=\"" . xmlcharacters("{$text['married']} $spousename") . "\">" . xmlcharacters("$displayDate, {$marriagerow['marrplace']}") . "</event>\n";
        }
      }
      //get all children (link to people) born to this marriage
      //loop through and make event for each
      $children = getChildrenDataPlusDates($output['timetree'], $marriagerow['familyID']);

      while ($child = tng_fetch_assoc($children)) {
        if ($child['birthdate']) {
          $date = $child['birthdatetr'];
          $displayDate = displayDate($child['birthdate']);
          $abbr = $text['birthabbr'];
        } elseif ($child['altbirthdate']) {
          $date = $child['altbirthdatetr'];
          $displayDate = displayDate($child['altbirthdate']);
          $abbr = $text['chrabbr'];
        }
        if ($date && substr($date, 0, 4) != "0000") {
          $crights = determineLivingPrivateRights($child, $righttree);
          $child['allow_living'] = $crights['living'];
          $child['allow_private'] = $crights['private'];
          if ($crights['both']) {
            if ($child['firstname'] || $child['lastname']) {
              $childname = getName($child);
            }
            $beg_date = getTimelineDate($date);
            $beg_year = $beg_date['year'];
            $beg_date_gmt = $beg_date['date_gmt'];
            echo "<event start=\"" . $beg_date_gmt . "\" end=\"" . $beg_date_gmt . "\" title=\"" . xmlcharacters($text['child'] . ": " . $childname) . "\">" . xmlcharacters("$abbr $displayDate") . "</event>\n";
          }
        }
      }
      tng_free_result($children);
    }
    tng_free_result($marriages);
  }
}

echo "</data>\n";

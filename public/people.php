<?php

declare(strict_types=1);

const PARENT_CHILD_RELATIONSHIP_TYPES = ["adopted", "birth", "foster", "sealing", "step", "putative"];

/**
 * @param $ldsRights
 * @param array $row
 */
function defineLdsHiddenFields($ldsRights, array $row): void {
    if (!$ldsRights) { ?>
        <input type="hidden" value="<?php echo $row['baptdate']; ?>" name="baptdate">
        <input type="hidden" value="<?php echo $row['baptplace']; ?>" name="baptplace">
        <input type="hidden" value="<?php echo $row['confdate']; ?>" name="confdate">
        <input type="hidden" value="<?php echo $row['confplace']; ?>" name="confplace">
        <input type="hidden" value="<?php echo $row['initdate']; ?>" name="initdate">
        <input type="hidden" value="<?php echo $row['initplace']; ?>" name="initplace">
        <input type="hidden" value="<?php echo $row['endldate']; ?>" name="endldate">
        <input type="hidden" value="<?php echo $row['endlplace']; ?>" name="endlplace">
    <?php }
}

/**
 * Fetches all from 'people' cleaning most text and formatting 'changedate'
 * @param string|null &$personID ensures first character capital
 * @param string $people_table 'people' table
 * @param string $tree tree containing person
 * @return array fetched row
 */
function fetchAndCleanPersonRow(?string &$personID, string $people_table, string $tree): array {
    $row = [];
    if ($personID) {
        $personID = ucfirst($personID);
        $query = "SELECT *, DATE_FORMAT(changedate, \"%d %b %Y %H:%i:%s\") as changedate FROM {$people_table} WHERE personID = \"{$personID}\" and gedcom = \"{$tree}\"";
        $result = tng_query($query);
        $row = tng_fetch_assoc($result);
        tng_free_result($result);
        $row['firstname'] = preg_replace("/\"/", "&#34;", $row['firstname']);
        $row['lastname'] = preg_replace("/\"/", "&#34;", $row['lastname']);
        $row['nickname'] = preg_replace("/\"/", "&#34;", $row['nickname']);
        $row['suffix'] = preg_replace("/\"/", "&#34;", $row['suffix']);
        $row['title'] = preg_replace("/\"/", "&#34;", $row['title']);
        $row['birthplace'] = preg_replace("/\"/", "&#34;", $row['birthplace']);
        $row['altbirthplace'] = preg_replace("/\"/", "&#34;", $row['altbirthplace']);
        $row['deathplace'] = preg_replace("/\"/", "&#34;", $row['deathplace']);
        $row['burialplace'] = preg_replace("/\"/", "&#34;", $row['burialplace']);
        $row['baptplace'] = preg_replace("/\"/", "&#34;", $row['baptplace']);
        $row['endlplace'] = preg_replace("/\"/", "&#34;", $row['endlplace']);
        $row['confplace'] = preg_replace("/\"/", "&#34;", $row['confplace']);
        $row['initplace'] = preg_replace("/\"/", "&#34;", $row['initplace']);
    }
    return $row;
}

/**
 * @param bool $both true if user has both living and private rights to person information
 * @param array $person
 * @return array
 */
function getBirthInformation(bool $both, array $person): array {
  global $admtext;

  if ($both) {
    if ($person['birthdate'] || $person['birthplace']) {
      $birthdate = $admtext['birthabbr'] . " " . displayDate($person['birthdate']);
      $birthplace = $person['birthplace'];
    } else {
      if ($person['altbirthdate'] || $person['altbirthplace']) {
        $birthdate = $admtext['chrabbr'] . " " . displayDate($person['altbirthdate']);
        $birthplace = $person['altbirthplace'];
      } else {
        $birthdate = "";
        $birthplace = "";
      }
    }
  } else {
    $birthdate = $birthplace = "";
  }
  return [$birthdate, $birthplace];
}

/**
 * @param array|null $person
 * @return string
 */
function getBirthText(?array $person): string {

    global $admtext;
    if ($person['birthdate']) {
        $birthstring = $admtext['birthabbr'] . " " . displayDate($person['birthdate']);
    } else {
        if ($person['altbirthdate']) {
            $birthstring = $admtext['chrabbr'] . " " . displayDate($person['altbirthdate']);
        } else {
            $birthstring = $admtext['nobirthinfo'];
        }
    }
    return $birthstring;
}

/**
 * @param array|null $person
 * @return string
 */
function getDeathText(?array $person): string {
    global $admtext;

    if ($person['deathdate']) {
        $deathstring = $admtext['deathabbr'] . " " . displayDate($person['deathdate']);
    } else {
        if ($person['burialdate']) {
            $deathstring = $admtext['burialabbr'] . " " . displayDate($person['burialdate']);
        } else {
            $deathstring = "";
        }
    }
    return $deathstring;
}

/**
 * @param array|null $person
 * @param bool $tree
 * @return array
 */
function getVitalInformation(?array $person, bool $tree): array {
    global $admtext;

    $rights = determineLivingPrivateRights($person, $tree);
    $person['allow_living'] = $rights['living'];
    $person['allow_private'] = $rights['private'];

    if ($rights['both']) {
        $birthinfo = "";

        list ($birthstring, $deathstring) = getvitalsText($person);
        if ($birthstring || $deathstring) {
            $birthinfo = " ($birthstring$deathstring)";
        }
    } else {
        $birthinfo = ($person['private'] ? $admtext['text_private'] : $admtext['living']) . " - " . $person['personID'];
    }
    return array($person, $birthinfo);
}

/**
 * @param array|null $person
 * @return array
 */
function getVitalsText(?array $person): array {
    $birthstring = getBirthText($person);
    $deathstring = getDeathText($person);
    if ($birthstring && $deathstring) {
        $deathstring = ", " . $deathstring;
    }
    return array($birthstring, $deathstring);
}



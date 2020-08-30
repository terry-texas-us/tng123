<?php

declare(strict_types=1);

const PARENT_CHILD_RELATIONSHIP_TYPES = ["adopted", "birth", "foster", "sealing", "step", "putative"];

/**
 *
 * @param bool $both true if user has both living and private rights to person information
 * @param array $person
 * @return array
 */
function getBirthInformation(bool $both, array $person): array {
  global $text;
  if ($both) {
    if ($person['birthdate'] || $person['birthplace']) {
      $birthdate = $text['birthabbr'] . " " . displayDate($person['birthdate']);
      $birthplace = $person['birthplace'];
    } else {
      if ($person['altbirthdate'] || $person['altbirthplace']) {
        $birthdate = $text['chrabbr'] . " " . displayDate($person['altbirthdate']);
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
 * @param array $person
 * @param bool $tree
 * @return array
 */
function getVitalInformation(array $person, bool $tree): array {
    global $admtext;

    $rights = determineLivingPrivateRights($person, $tree);
    $person['allow_living'] = $rights['living'];
    $person['allow_private'] = $rights['private'];

    if ($rights['both']) {
        $birthstring = $deathstring = $birthinfo = "";
        if ($person['birthdate']) {
            $birthstring = $admtext['birthabbr'] . " " . displayDate($person['birthdate']);
        } else {
            if ($person['altbirthdate']) {
                $birthstring = $admtext['chrabbr'] . " " . displayDate($person['altbirthdate']);
            }
        }
        if ($person['deathdate']) {
            $deathstring = $admtext['deathabbr'] . " " . displayDate($person['deathdate']);
        } else {
            if ($person['burialdate']) {
                $deathstring = $admtext['burialabbr'] . " " . displayDate($person['burialdate']);
            }
        }
        if ($birthstring && $deathstring) {
            $deathstring = ", " . $deathstring;
        }
        if ($birthstring || $deathstring) {
            $birthinfo = " ($birthstring$deathstring)";
        }
    } else {
        $birthinfo = ($person['private'] ? $admtext['text_private'] : $admtext['living']) . " - " . $person['personID'];
    }
    return array($person, $birthinfo);
}



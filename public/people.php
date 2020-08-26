<?php

declare(strict_types=1);

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


<?php
$criteria_limit = 8;
$criteria_count = 0;
/**
 * @param $qualifier
 * @param $column
 * @param $usevalue
 * @return mixed
 */
function buildColumn($qualifier, $column, $usevalue) {
    global $text;

    $criteria = "";
    switch ($qualifier) {
        case "equals":
            $criteria .= "$column = \"$usevalue\"";
            $qualifystr = _('equals');
            break;
        case "startswith":
            $criteria .= "$column LIKE \"$usevalue%\"";
            $qualifystr = _('starts with');
            break;
        case "endswith":
            $criteria .= "$column LIKE \"%$usevalue\"";
            $qualifystr = _('ends with');
            break;
        case "exists":
            $criteria .= "$column != \"\"";
            $qualifystr = _('exists');
            break;
        case "dnexist":
            $criteria .= "$column = \"\"";
            $qualifystr = _('does not exist');
            break;
        case "soundexof":
            if (count(explode(" ", $usevalue)) > 1) {
                $criteria .= "SOUNDEX($column) = SOUNDEX(\"$usevalue\")";
            } else {
                $criteria .= "(SOUNDEX(SUBSTRING_INDEX($column, ' ', 1)) = SOUNDEX(\"$usevalue\") OR SOUNDEX(SUBSTRING_INDEX(TRIM($column), ' ', -1)) = SOUNDEX(\"$usevalue\"))";
            }
            $qualifystr = _('soundex of');
            break;
        case "metaphoneof":
            $metaphoneprefix = substr($column, 0, 1);
            if ($metaphoneprefix == "f") {
                $mcolumn = "father.metaphone";
            } elseif ($metaphoneprefix == "m") {
                $mcolumn = "mother.metaphone";
            } else {
                $mcolumn = "metaphone";
            }
            $criteria .= "{$mcolumn} = \"" . metaphone($usevalue) . "\"";
            $qualifystr = _('metaphone of');
            break;
        default:
            $criteria .= "$column LIKE \"%$usevalue%\"";
            $qualifystr = _('contains');
            break;
    }
    $returnarray['criteria'] = $criteria;
    $returnarray['qualifystr'] = $qualifystr;

    return $returnarray;
}

/**
 * @param $column
 * @param $colvar
 * @param $qualifyvar
 * @param $altcolumn
 * @param $qualifier
 * @param $value
 * @param $textstr
 */
function buildYearCriteria($column, $colvar, $qualifyvar, $altcolumn, $qualifier, $value, $textstr) {
    global $text, $criteria_limit, $criteria_count;

    if ($qualifier == "exists" || $qualifier == "dnexist") {
        $value = "";
    } else {
        $value = addslashes(urldecode(trim($value)));
        $yearstr1 = $altcolumn ? "IF($column!='0000-00-00',YEAR($column),YEAR($altcolumn))" : "YEAR($column)";
        $yearstr2 = $altcolumn ? "IF($column,YEAR($column), YEAR($altcolumn))" : "YEAR($column)";
    }

    $criteria_count++;
    if ($criteria_count >= $criteria_limit) {
        die("sorry");
    }

    $criteria = "";
    $numvalue = is_numeric($value) ? $value : preg_replace("/[^0-9]/", '', $value);
    switch ($qualifier) {
        case "pm2":
            $criteria = "($yearstr1 < $numvalue + 2 AND $yearstr2 > $numvalue - 2)";
            $qualifystr = _('+/- 2 years from');
            break;
        case "pm5":
            $criteria = "($yearstr1 < $numvalue + 5 AND $yearstr2 > $numvalue - 5)";
            $qualifystr = _('+/- 5 years from');
            break;
        case "pm10":
            $criteria = "($yearstr1 < $numvalue + 10 AND $yearstr2 > $numvalue - 10)";
            $qualifystr = _('+/- 10 years from');
            break;
        case "lt":
            $criteria = "($yearstr1 != \"\" AND $yearstr1 < \"$numvalue\")";
            $qualifystr = _('less than');
            break;
        case "gt":
            $criteria = "$yearstr1 > \"$numvalue\"";
            $qualifystr = _('greater than');
            break;
        case "lte":
            $criteria = "($yearstr1 != \"\" AND $yearstr1 <= \"$numvalue\")";
            $qualifystr = _('less than or equal to');
            break;
        case "gte":
            $criteria = "$yearstr1 >= \"$numvalue\"";
            $qualifystr = _('greater than or equal to');
            break;
        case "exists":
            $criteria = "YEAR($column) != \"\"";
            if ($altcolumn) {
                $criteria = "($criteria OR YEAR($altcolumn) != \"\")";
            }
            $qualifystr = _('exists');
            break;
        case "dnexist":
            $criteria = "YEAR($column) = \"\"";
            if ($altcolumn) $criteria .= " AND YEAR($altcolumn) = \"\"";

            $qualifystr = _('does not exist');
            break;
        default:
            $criteria = "$yearstr1 = '$value'";
            $qualifystr = _('equal to');
            break;
    }
    addtoQuery($textstr, $colvar, $criteria, $qualifyvar, $qualifier, $qualifystr, $value);
}

/**
 * @param $textstr
 * @param $colvar
 * @param $criteria
 * @param $qualifyvar
 * @param $qualifier
 * @param $qualifystr
 * @param $value
 */
function addtoQuery($textstr, $colvar, $criteria, $qualifyvar, $qualifier, $qualifystr, $value) {
    global $allwhere, $mybool, $querystring, $urlstring, $mybooltext, $text;

    if ($urlstring) $urlstring .= "&amp;";

    $urlstring .= "$colvar=" . urlencode($value) . "&amp;$qualifyvar=$qualifier";

    if ($querystring) $querystring .= " $mybooltext ";

    if ($textstr == _('Gender')) {
        switch ($value) {
            case "M":
                $value = _('Male');
                break;
            case "F":
                $value = _('Female');
                break;
            case "U":
                $value = _('Unknown');
                break;
            case "":
            case "N":
                $value = _('No encryption');
                break;
        }
    }
    $querystring .= "$textstr $qualifystr " . stripslashes($value);

    if ($criteria) {
        if ($allwhere) $allwhere .= " " . $mybool;

        $allwhere .= " " . $criteria;
    }
}

/**
 * @param $type
 * @return string
 */
function doCustomEvents($type) {
    global $dontdo, $cejoin, $eventtypes_table, $events_table, $text, $allwhere, $mybool;

    $cejoin = "";
    $query = "SELECT eventtypeID, tag, display FROM $eventtypes_table WHERE keep='1' AND type='$type' ORDER BY display";
    $result = tng_query($query);
    $eventTypes = tng_fetch_all($result);
    tng_free_result($result);
    $needce = 0;
    $ecount = 0;
    if ($type == "F") {
        $persfamfield = "f.familyID";
        $treefield = "f.gedcom";
    } else { //assume for now that $type == "I"
        $persfamfield = "p.personID";
        $treefield = "p.gedcom";
    }

    foreach ($eventTypes as $row) {
        if (!in_array($row['tag'], $dontdo)) {
            $needecount = 1;
            $display = getEventDisplay($row['display']);

            $cefstr = "cef" . $row['eventtypeID'];
            eval("global \$$cefstr;");
            eval("\$cef = \$$cefstr;");
            $cfqstr = "cfq{$row['eventtypeID']}";
            eval("global \$$cfqstr;");
            eval("\$cfq = \$$cfqstr;");
            if ($cef || $cfq == "exists" || $cfq == "dnexist") {
                if ($needecount) {
                    $needecount = 0;
                    $ecount++;
                }
                $tablepfx = "e$ecount.";
                buildCriteria($tablepfx . "info", $cefstr, $cfqstr, $cfq, $cef, "$display (" . _('Fact') . ")");
                $needce = 1;
            }

            $cepstr = "cep" . $row['eventtypeID'];
            eval("global \$$cepstr;");
            eval("\$cep = \$$cepstr;");
            $cpqstr = "cpq" . $row['eventtypeID'];
            eval("global \$$cpqstr;");
            eval("\$cpq = \$$cpqstr;");
            if ($cep || $cpq == "exists" || $cpq == "dnexist") {
                if ($needecount) {
                    $needecount = 0;
                    $ecount++;
                }
                $tablepfx = "e$ecount.";
                buildCriteria($tablepfx . "eventplace", $cepstr, $cpqstr, $cpq, $cep, "$display (" . _('Place') . ")");
                $needce = 1;
            }

            $ceystr = "cey" . $row['eventtypeID'];
            eval("global \$$ceystr;");
            eval("\$cey = \$$ceystr;");
            $cyqstr = "cyq" . $row['eventtypeID'];
            eval("global \$$cyqstr;");
            eval("\$cyq = \$$cyqstr;");
            if ($cey || $cyq == "exists" || $cyq == "dnexist") {
                if ($needecount) {
                    $needecount = 0;
                    $ecount++;
                }
                $tablepfx = "e$ecount.";
                buildYearCriteria($tablepfx . "eventdatetr", $ceystr, $cyqstr, "", $cyq, $cey, "$display (" . _('Year') . ")");
                $needce = 1;
            }
            if ($needce) {
                if ($mybool == "AND") {
                    $cejoin .= "INNER JOIN $events_table as e$ecount ON $treefield = $tablepfx" . "gedcom AND $persfamfield = $tablepfx" . "persfamID ";
                    if ($allwhere) $allwhere .= " $mybool ";

                    $allwhere .= $tablepfx . "eventtypeID = \"{$row['eventtypeID']}\" ";
                } else {  //OR
                    $cejoin .= "LEFT JOIN $events_table as e$ecount ON $treefield = $tablepfx" . "gedcom AND $persfamfield = $tablepfx" . "persfamID AND $tablepfx" . "eventtypeID = \"{$row['eventtypeID']}\" ";
                }
                $needce = 0;
            }
        }
    }
    return $cejoin;
}

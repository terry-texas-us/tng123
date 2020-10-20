<?php
/*
 * tngCalendar - An addon calendar for TNG
 * http://www.tngforum.us/index.php?showtopic=779
 *
 * @author CJ Niemira <siege (at) siege (dot) org>
 * @copyright 2006,2008
 * @license GPL
 * @version 2.0
 */

$textpart = "search";
include "tng_begin.php";
$logstring = "<a href=\"calendar.php?living=$living&amp;hide=$hide&amp;tree=$tree&amp;m=$m&amp;year=$year\">" . xmlcharacters($text['calendar']) . "</a>";
writelog($logstring);
preparebookmark($logstring);
$ucharset = strtoupper($session_charset);
function substr_unicode($str, $start, $len = null) {
    return join("", array_slice(
        preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY), $start, $len));
}

echo "<!doctype html>\n";
echo "<html lang='en'>\n";
$flags['scripting'] = "<script>\n";
$flags['scripting'] .= "function redisplay(key) {window.location.href = jQuery('#' + key).attr('href');}\n";
$flags['scripting'] .= "</script>\n";
tng_header($text['calendar'], $flags);
?>

    <h2 class="header"><span class="headericon" id="calendar-hdr-icon"></span><?php echo $text['calendar']; ?></h2>
    <br style="clear: left;">

<?php
include_once "calsettings.php";
// Make an array of all the event types
$calAllEvents = array_merge($calIndEvent, $calFamEvent, $calEvent);
// Start by getting the date to display for
$current = getdate(time());
$thisMonth = (is_numeric($_GET['m']) && ($_GET['m'] < 13))
    ? sprintf("%02d", $_GET['m'])
    : sprintf("%02d", $current['mon']);
$thisYear = (is_numeric($_GET['y']) && ($_GET['y'] > 1000) && ($_GET['y'] < 3000))
    ? $_GET['y']
    : $current['year'];
$dateString = "$thisYear-$thisMonth-01 00:00:00";
$time = strtotime($dateString);
$startDay = date('w', $time);
$daysInMonth = date('t', $time);
$daysOfWeek = [$text['sunday'], $text['monday'], $text['tuesday'], $text['wednesday'], $text['thursday'], $text['friday'], $text['saturday']];
$thisMonthName = $dates[strtoupper(date('F', $time))];
$nextMonth = date('n', strtotime($dateString . " +1 month"));
$nextMonthYear = $nextMonth == 1 ? $thisYear + 1 : $thisYear;
$nextYear = $thisYear + 1;
$lastMonth = date('n', strtotime($dateString . " -1 month"));
$lastMonthYear = $lastMonth == 12 ? $thisYear - 1 : $thisYear;
$lastYear = $thisYear - 1;
$showLiving = $allow_living ? ($_GET['living'] ?? 2) : 0;
$hideEvents = isset($_GET['hide']) ? explode(',', $_GET['hide']) : $defaultHide;
$thisTree = $tree;
$events = [];
// Query for individual/person events this month
$select = [];
$where = [];
foreach ($calIndEvent as $key => $val) {
    if (in_array($key, $hideEvents)) continue;
    $select[] = $key . "date";
    $select[] = $key . "datetr";
    $select[] = $key . "place";
    $where[] = $key . "datetr LIKE '%-$thisMonth-%'";
}
if (!empty($where)) {
    $sql = "SELECT personID, gedcom, firstname, nickname, lnprefix, lastname, suffix, living, branch, private, " . implode(', ', $select) . "
	FROM $people_table
	WHERE (" . implode(' OR ', $where) . ")";
    if ($showLiving == '1') {
        $sql .= ' AND living = 1';
    } elseif ($showLiving == '0') {
        $sql .= ' AND living = 0';
    }
    if ($thisTree && $thisTree != '-x--all--x-') {
        $sql .= " AND gedcom = '$thisTree'";
        $righttree = checktree($thisTree);
    } else {
        $righttree = -1;
    }
    $result = tng_query($sql);
# BREAK
    if (!$result) {
        echo "Err 1<br>$sql<br>";
        echo tng_error();
        exit;
    }
// Make sure data is normalized
    if (tng_num_rows($result) > 0) {
        while ($row = tng_fetch_assoc($result)) {
            $rights = determineLivingPrivateRights($row, $righttree);
            $row['allow_living'] = $rights['living'];
            $row['allow_private'] = $rights['private'];
            if (($row['living'] && !$row['allow_living']) || ($row['private'] && !$row['allow_private'])) {
                continue;
            } else {
                $longname = getName($row);
                if ($ucharset == "UTF-8") {
                    $name = (mb_strlen($longname) > $truncateNameAfter)
                        ? substr_unicode($longname, 0, $truncateNameAfter) . '...'
                        : $longname;
                } else {
                    $name = (strlen($longname) > $truncateNameAfter)
                        ? substr($longname, 0, $truncateNameAfter) . '...'
                        : $longname;
                }
                foreach ($calIndEvent as $key => $val) {
                    if ($val == null) continue;

                    $field = $key . 'datetr';
                    if (isset($row[$field])) {
                        $date = substr($row[$field], 5);
                        $yearval = substr($row[$key . 'date'], -4);
                        $year = is_numeric($yearval) ? " ($yearval)" : "";
                        $html = '<img src="' . 'img/' . $val . '" class="calIcon" alt=""><a href="getperson.php?personID=' . $row['personID'] . '&amp;tree=' . $row['gedcom'] . '" class="calEvent" title="' . $longname . '">' . $name . '</a>' . $year;
                        if (strpos($date, "-00")) {
                            $html = '<span class="text-nowrap">' . $html . '</span>';
                        }
                        $events[$date][$key][$row['gedcom']][$row['personID']] = $html;
                    }
                }
            }
        }
    }
}
// Query for family events this month
$select = [];
$where = [];
foreach ($calFamEvent as $key => $val) {
    if (in_array($key, $hideEvents)) continue;
    $select[] = $families_table . '.' . $key . 'date';
    $select[] = $families_table . '.' . $key . 'datetr';
    $select[] = $families_table . '.' . $key . 'place';
    $where[] = $key . "datetr LIKE '%-$thisMonth-%'";
}
if (!empty($where)) {
    $sql = "SELECT familyID, gedcom, husband, wife, living, private, " . implode(', ', $select) . "
	FROM $families_table
	WHERE (" . implode(' OR ', $where) . ")";
    if ($showLiving == '1') {
        $sql .= ' AND living = 1';
    } elseif ($showLiving == '0') {
        $sql .= ' AND living = 0';
    }
    if ($thisTree && $thisTree != '-x--all--x-') {
        $sql .= " AND gedcom = '$thisTree'";
    }
    $result = tng_query($sql);
# BREAK
    if (!$result) {
        echo "Err 2<br>";
        echo tng_error();
        exit;
    }
// Make sure data is normalized
    if (tng_num_rows($result) > 0) {
        while ($row = tng_fetch_assoc($result)) {
            $rights = determineLivingPrivateRights($row, $righttree);
            $row['allow_living'] = $rights['living'];
            $row['allow_private'] = $rights['private'];
            if (($row['living'] && !$row['allow_living'] && $nonames == 1) || ($row['private'] && !$row['allow_private'] && $tngconfig['nnpriv'] == 1)) {
                continue;
            } else {
                $longname = getFamilyName($row);
                if ($ucharset == "UTF-8") {
                    $name = (mb_strlen($longname) > $truncateNameAfter)
                        ? substr_unicode($longname, 0, $truncateNameAfter) . '...'
                        : $longname;
                } else {
                    $name = (strlen($longname) > $truncateNameAfter)
                        ? substr($longname, 0, $truncateNameAfter) . '...'
                        : $longname;
                }
                foreach ($calFamEvent as $key => $val) {
                    if ($val == null) continue;
                    $field = $key . 'datetr';
                    if (isset($row[$field])) {
                        $date = substr($row[$field], 5);
                        $yearval = substr($row[$key . 'date'], -4);
                        $year = is_numeric($yearval) ? " ($yearval)" : "";
                        $html = '<img src="' . 'img/' . $val . '" class="calIcon" alt=""><a href="familygroup.php?familyID=' . $row['familyID'] . '&amp;tree=' . $row['gedcom'] . '" class="calEvent" title="' . $longname . '">' . $name . '</a>' . $year;
                        if (strpos($date, "-00")) {
                            $html = '<span class="text-nowrap">' . $html . '</span>';
                        }
                        $events[$date][$key][$row['gedcom']][$row['familyID']] = $html;
                    }
                }
            }
        }
    }
}
// Query for custom events this month
$where = [];
foreach ($calEvent as $key => $val) {
    if (in_array($key, $hideEvents)) continue;
    $where[] = "$eventtypes_table.tag = '$key'";
}
if (!empty($where)) {
    $sql = "SELECT gedcom, persfamID, tag, display, eventdate, eventdatetr, eventplace
	FROM $events_table, $eventtypes_table
	WHERE (" . implode(' OR ', $where) . ") AND $eventtypes_table.eventtypeID = $events_table.eventtypeID AND eventdatetr LIKE '%-$thisMonth-%'";
    if ($thisTree != '-x--all--x-') {
        $sql .= " AND gedcom = '$thisTree'";
    }
    $result = tng_query($sql);
# BREAK
    if (!$result) {
        echo "Err 3<br>";
        echo tng_error();
        exit;
    }
// Make sure the data is normalized
    if (tng_num_rows($result) > 0) {
        while ($row = tng_fetch_assoc($result)) {
            // Ugh... who did this happen to?
            $isFam = 0;
            if ($row['persfamID'][0] == 'I') {
                $sql = "SELECT * FROM $people_table WHERE personID = '" . $row['persfamID'] . "'";
                if ($showLiving == '1') {
                    $sql .= ' AND living = 1';
                } elseif ($showLiving == '0') {
                    $sql .= ' AND living = 0';
                }
                if ($thisTree != '-x--all--x-') {
                    $sql .= " AND gedcom = '$thisTree'";
                }
                $result2 = tng_query($sql);
                # BREAK
                if (!$result2) {
                    echo "Err 4<br>";
                    echo tng_error();
                    exit;
                }
                if (tng_num_rows($result2) < 1) continue;

                $longname = htmlentities(getName(tng_fetch_assoc($result2)), ENT_QUOTES);
            } elseif ($row['persfamID'][0] == 'F') {
                $sql = "SELECT * FROM $families_table WHERE familyID = '" . $row['persfamID'] . "'";
                if ($showLiving == '1') {
                    $sql .= ' AND living = 1';
                } elseif ($showLiving == '0') {
                    $sql .= ' AND living = 0';
                }
                if ($thisTree != '-x--all--x-') {
                    $sql .= " AND gedcom = '$thisTree'";
                }
                $result3 = tng_query($sql);
                # BREAK
                if (!$result3) {
                    echo "Err 5<br>";
                    echo tng_error();
                    exit;
                }
                if (tng_num_rows($result3) < 1) continue;

                $longname = htmlentities(getFamilyName(tng_fetch_assoc($result3)), ENT_QUOTES);
                $isFam = 1;
            } else {
                continue;
            }
            $name = (strlen($longname) > $truncateNameAfter)
                ? substr($longname, 0, $truncateNameAfter) . '...'
                : $longname;
            if (isset($row['eventdatetr'])) {
                $tag = $row['tag'];
                if ($isFam) {
                    $html = '<img src="' . 'img/' . $calEvent[$tag] . '" class="calIcon" alt=""><a href="familygroup.php?familyID=' . $row['persfamID'] . '&amp;tree=' . $row['gedcom'] . '" class="calEvent" title="' . $longname . '">' . $name . '</a>';
                } else {
                    $html = '<img src="' . 'img/' . $calEvent[$tag] . '" class="calIcon" alt=""><a href="getperson.php?personID=' . $row['persfamID'] . '&amp;tree=' . $row['gedcom'] . '" class="calEvent" title="' . $longname . '">' . $name . '</a>';
                }
                $date = substr($row['eventdatetr'], 5);
                $events[$date][$tag][$row['gedcom']][$row['persfamID']] = $html;
            }
        }
    }
}
$args = "?living=$showLiving&amp;hide=" . implode(',', $hideEvents) . "&amp;tree=$thisTree&amp;";
// Write the calendar
echo "<div id=\"calWrapper\">\n";
$hidden = [];
$hidden[] = ['name' => 'm', 'value' => $thisMonth];
$hidden[] = ['name' => 'y', 'value' => $thisYear];
$hidden[] = ['name' => 'living', 'value' => $showLiving];
$hidden[] = ['name' => 'hide', 'value' => implode(',', $hideEvents)];
echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'calendar', 'method' => 'get', 'name' => 'treeform', 'id' => 'treeform', 'hidden' => $hidden]);
?>

    <div id="calHeader">
        <a href="<?php echo $args; ?>m=<?php echo $thisMonth; ?>&amp;y=<?php echo $lastYear; ?>"><img src="img/ArrowLeft.gif" alt=""><img
                src="img/ArrowLeft.gif" alt=""></a>
        &nbsp;
        <a href="<?php echo $args; ?>m=<?php echo $lastMonth; ?>&amp;y=<?php echo $lastMonthYear; ?>"><img src="img/ArrowLeft.gif" alt=""></a>
        &nbsp;
        <?php echo $thisMonthName; ?> <?php echo $thisYear; ?>
        &nbsp;
        <a href="<?php echo $args; ?>m=<?php echo $nextMonth; ?>&amp;y=<?php echo $nextMonthYear; ?>"><img src="img/ArrowRight.gif" alt=""></a>
        &nbsp;
        <a href="<?php echo $args; ?>m=<?php echo $thisMonth; ?>&amp;y=<?php echo $nextYear; ?>"><img src="img/ArrowRight.gif" alt=""><img
                src="img/ArrowRight.gif" alt=""></a>
    </div>

<?php
if ($allow_living) {
    ?>
    <div style="text-align: right;">
        <div style="float: left;">
            <?php
            echo "<a href=\"anniversaries.php?tngmonth=$m&amp;tngneedresults=1\"><strong>&gt;&gt; {$text['anniversaries']}</strong></a>";
            ?>
        </div>
        <?php
        echo "<strong>{$text['filter']}:</strong>&nbsp; ";
        $args = "&amp;hide=" . implode(',', $hideEvents) . "&amp;tree=$thisTree&amp;m=$thisMonth&amp;year=$thisYear";
        echo $showLiving == 2 ? "<strong>{$text['all']}</strong> &nbsp;|&nbsp; " : "<a href=\"?living=2{$args}\">{$text['all']}</a> &nbsp;|&nbsp; ";
        echo $showLiving == 1 ? "<strong>{$text['living']}</strong> &nbsp;|&nbsp; " : "<a href=\"?living=1{$args}\">{$text['living']}</a> &nbsp;|&nbsp; ";
        echo !$showLiving ? "<strong>{$text['notliving']}</strong>" : "<a href=\"?living=0{$args}\">{$text['notliving']}</a>";
        ?>
    </div>
<?php } ?>
    <table align="center" class="calendar rounded-lg">
        <tr>
            <?php
            // Weekday name headers
            for ($i = $startOfWeek; $i < $startOfWeek + 7; $i++) {
                echo "<th class=\"calDay\">" . $daysOfWeek[($i % 7)] . "</th>\n";
            }
            echo "</tr><tr>\n";
            if ($startOfWeek > $startDay) $startOfWeek -= 7;

            $dayInWeek = 0;
            for ($i = $startOfWeek; $i < ($daysInMonth + $startDay); $i++) {
                $dayInWeek++;
                $dayInMonth = $i - $startDay;
                if ($dayInMonth >= $daysInMonth || $dayInMonth < 0) {
                    echo "<td class=\"calSkip\"><div>\n";
                } else {
                    $thisDay = $dayInMonth + 1;
                    $class = ($thisYear == $current['year'] && $thisMonth == $current['mon'] && $thisDay == $current['mday']) ? 'calToday' : 'calDay';
                    echo "<td class=\"$class\">\n";
                    echo "<a href=\"anniversaries.php?tngdaymonth=$thisDay&amp;tngmonth=$thisMonth&amp;tngneedresults=1\" class=\"calDate\">$thisDay</a><br>\n<div class=\"calEvents\">\n";
                    $thisDate = "$thisMonth-" . sprintf("%02d", $thisDay);
                    if (array_key_exists($thisDate, $events)) {
                        $j = 0;
                        foreach (array_keys($events[$thisDate]) as $event) {
                            if ($j > $truncateDateAfter) continue;
                            foreach (array_keys($events[$thisDate][$event]) as $ged) {
                                foreach (array_keys($events[$thisDate][$event][$ged]) as $id) {
                                    if ($j >= $truncateDateAfter) {
                                        echo "<a href=\"anniversaries.php?tngdaymonth=$thisDay&amp;tngmonth=$thisMonth&amp;tngneedresults=1\" class=\"calMore\">" . $text['more'] . "...</a>\n";
                                        $j++;
                                        continue 3;
                                    }
                                    // Print events
                                    echo $events[$thisDate][$event][$ged][$id] . "<br>\n";
                                    $j++;
                                }
                            }
                        }
                    }
                }
                echo "</div>\n</td>\n";
                if (($dayInWeek % 7) == 0) echo "</tr><tr>\n";

            }
            if (($dayInWeek % 7) != 0) echo "</tr><tr>\n";

            ?>

            <td colspan="7">
                <div class="calKey"><?php echo $text['nodayevents'] ?></div>

                <?php
                $thisDate = "$thisMonth-00";
                if (array_key_exists($thisDate, $events)) {
                    foreach (array_keys($events[$thisDate]) as $event) {
                        foreach (array_keys($events[$thisDate][$event]) as $ged) {
                            foreach (array_keys($events[$thisDate][$event][$ged]) as $id) {
                                echo $events[$thisDate][$event][$ged][$id] . " &nbsp; \n";
                            }
                        }
                    }
                } else {
                    echo $text['none'];
                }
                ?>

            </td>
        </tr>
    </table>

    <div id="calLegend" class="rounded-lg">
        <ul class="flat">
            <?php
            // make sure the custom text key is set
            $where = [];
            if (count($calEvent)) {
                foreach ($calEvent as $key => $val)
                    $where[] = "$eventtypes_table.tag = '$key'";
                $sql = "SELECT tag, display
			FROM $eventtypes_table
			WHERE " . implode(' OR ', $where);
                $result = tng_query($sql);
                # BREAK
                if (!$result) {
                    echo "Err 6<br>";
                    echo tng_error();
                    exit;
                }
                if (tng_num_rows($result) > 0) {
                    while ($row = tng_fetch_assoc($result))
                        $text[$row['tag'] . 'date'] = getEventDisplay($row['display']);
                }
            }
            foreach ($calAllEvents as $key => $val) {
                if ($val == null || empty($text[$key . 'date'])) continue;

                if (in_array($key, $hideEvents)) {
                    $class = 'hidden';
                    $checkbox = "<input type='checkbox' onclick=\"redisplay('cal_$key');\">";
                    $toHide = array_diff($hideEvents, [$key]);
                } else {
                    $class = 'nothidden';
                    $checkbox = "<input type='checkbox' checked onclick=\"redisplay('cal_$key');\">";
                    $toHide = $hideEvents;
                    $toHide[] = $key;
                }
                $args = "?living=$showLiving&amp;hide=" . implode(',', $toHide) . "&amp;tree=$thisTree&amp;m=$thisMonth&amp;year=$thisYear";
                echo '<li class="flat text-nowrap"><a href="' . $args . '" class="' . $class . '" id="cal_' . $key . '">' . $checkbox . '<img src="' . 'img/' . $val . '" class="calIcon" alt="">' . $text[$key . 'date'] . '</a></li>' . "\n";
            }
            ?>
        </ul>
    </div>
    </div>

<?php
tng_footer("");
?>
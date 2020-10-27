<?php
// The following page was created by Roger L. Smith (roger@ERC.MsState.Edu), 
// copyright July 2003. Used by permission.
$textpart = "stats";
include "tng_begin.php";
$treestr = $tree ? " ({$text['tree']}: $tree)" : "";
$logstring = "<a href=\"statistics.php?tree=$tree\">" . xmlcharacters($text['databasestatistics'] . $treestr) . "</a>";
writelog($logstring);
preparebookmark($logstring);
echo "<!doctype html>\n";
echo "<html lang='en'>\n";
tng_header($text['databasestatistics'], $flags);
?>
    <h2 class="header"><span class="headericon" id="stats-hdr-icon"></span><?php echo $text['databasestatistics']; ?></h2>
    <br style="clear: left;">
    <link href="css/c3.css" rel="stylesheet">
    <script src="js/d3.min.js"></script>
    <script src="js/c3.min.js"></script>
    <div class="inline-block">
        <?php
        echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'statistics', 'method' => 'get', 'name' => 'form1', 'id' => 'form1']);
        ?>
        <table class='container max-w-lg lg:mx-4 whiteback normal'>
            <thead>
            <tr>
                <th class="fieldnameback fieldname"><?php echo $text['description']; ?></th>
                <th class="w-1/3 text-right fieldnameback fieldname"><?php echo $text['quantity']; ?></th>
            </tr>
            </thead>
            <?php
            $query = "SELECT lastimportdate, treename, secret FROM $trees_table WHERE gedcom = '$tree'";
            $result = tng_query($query);
            $treerow = tng_fetch_array($result, 'assoc');
            $lastimportdate = $treerow['lastimportdate'];
            if ($tree) {
                $wherestr = "WHERE gedcom = '$tree'";
                $wherestr2 = "AND gedcom= '$tree'";
            } else {
                $wherestr = "";
                $wherestr2 = "";
            }
            $query = "SELECT count(id) AS pcount FROM $people_table $wherestr";
            $result = tng_query($query);
            $row = tng_fetch_assoc($result);
            $totalpeople = $row['pcount'];
            tng_free_result($result);
            $query = "SELECT COUNT(id) AS fcount FROM $families_table $wherestr";
            $result = tng_query($query);
            $row = tng_fetch_assoc($result);
            $totalfamilies = $row['fcount'];
            tng_free_result($result);
            $query = "SELECT count(DISTINCT UCASE(lastname)) AS lncount ";
            $query .= "FROM $people_table ";
            $query .= "$wherestr";
            $result = tng_query($query);
            $row = tng_fetch_array($result);
            $uniquesurnames = number_format($row['lncount']);
            tng_free_result($result);
            $totalmedia = [];
            foreach ($mediatypes as $mediatype) {
                $mediatypeID = $mediatype['ID'];
                if ($tree) {
                    $query = "SELECT COUNT(distinct mediaID) AS mcount FROM $media_table WHERE mediatypeID = '$mediatypeID' AND (gedcom = '$tree' OR gedcom = '')";
                } else {
                    $query = "SELECT COUNT(mediaID) AS mcount FROM $media_table WHERE mediatypeID = '$mediatypeID'";
                }
                $result = tng_query($query);
                $row = tng_fetch_assoc($result);
                $totalmedia[$mediatypeID] = $row['mcount'];
                tng_free_result($result);
            }
            $query = "SELECT COUNT(id) AS scount FROM $sources_table $wherestr";
            $result = tng_query($query);
            $row = tng_fetch_assoc($result);
            $totalsources = number_format($row['scount']);
            tng_free_result($result);
            $query = "SELECT COUNT(id) AS pcount FROM $people_table WHERE sex = 'M' $wherestr2";
            $result = tng_query($query);
            $row = tng_fetch_assoc($result);
            $males = $row['pcount'];
            tng_free_result($result);
            $query = "SELECT COUNT(id) AS pcount FROM $people_table WHERE sex = 'F' $wherestr2";
            $result = tng_query($query);
            $row = tng_fetch_assoc($result);
            $females = $row['pcount'];
            tng_free_result($result);
            $unknownsex = $totalpeople - $males - $females;
            $query = "SELECT COUNT(id) AS pcount FROM $people_table WHERE living != 0 $wherestr2";
            $result = tng_query($query);
            $row = tng_fetch_assoc($result);
            $living = $row['pcount'];
            $numliving = number_format($living);
            $numdeceased = $totalpeople - $living;
            tng_free_result($result);
            $query = "SELECT personID, firstname, lnprefix, lastname, birthdate, altbirthdate, gedcom, living, private, branch ";
            $query .= "FROM $people_table WHERE (YEAR(birthdatetr) != '0' OR YEAR(altbirthdatetr) != '0') $wherestr2 ";
            $query .= "ORDER BY IF(birthdatetr != '0000-00-00', birthdatetr, altbirthdatetr) ";
            $query .= "LIMIT 1";
            $result = tng_query($query);
            $firstbirth = tng_fetch_array($result);
            $firstbirthpersonid = $firstbirth['personID'];
            $firstbirthfirstname = $firstbirth['firstname'];
            $firstbirthlnprefix = $firstbirth['lnprefix'];
            $firstbirthlastname = $firstbirth['lastname'];
            $firstbirthdate = $firstbirth['birthdate'] ? $firstbirth['birthdate'] : $firstbirth['altbirthdate'];
            $firstbirthgedcom = $firstbirth['gedcom'];
            $rights = determineLivingPrivateRights($firstbirth);
            $firstallowed = $rights['both'];
            tng_free_result($result);
            $query = "SELECT YEAR( deathdatetr ) - YEAR(IF(birthdatetr !='0000-00-00',birthdatetr,altbirthdatetr)) AS yearsold, DAYOFYEAR( deathdatetr ) - DAYOFYEAR(IF(birthdatetr !='0000-00-00',birthdatetr,altbirthdatetr)) AS daysold, IF(DAYOFYEAR(deathdatetr) and DAYOFYEAR(IF(birthdatetr !='0000-00-00',birthdatetr,altbirthdatetr)),TO_DAYS(deathdatetr) - TO_DAYS(IF(birthdatetr !='0000-00-00',birthdatetr,altbirthdatetr)),(YEAR(deathdatetr) - YEAR(IF(birthdatetr !='0000-00-00',birthdatetr,altbirthdatetr))) * 365) as totaldays ";
            $query .= "FROM $people_table ";
            $query .= "WHERE (birthdatetr != '0000-00-00' OR altbirthdatetr != '0000-00-00') AND deathdatetr != '0000-00-00' AND (birthdate not like 'AFT%' OR altbirthdate not like 'AFT%') AND deathdate not like 'AFT%' AND (birthdate not like 'BEF%' OR altbirthdate not like 'BEF%') AND deathdate not like 'BEF%' AND (birthdate not like 'ABT%' OR altbirthdate not like 'ABT%') AND deathdate not like 'ABT%' AND (birthdate not like 'BET%' OR altbirthdate not like 'BET%') AND deathdate not like 'BET%' AND (birthdate not like 'CAL%' OR altbirthdate not like 'CAL%') AND deathdate not like 'CAL%' $wherestr2 ";
            $query .= "ORDER BY totaldays DESC";
            $result = tng_query($query);
            $numpeople = 0;
            $avgyears = 0;
            $avgdays = 0;
            $totyears = 0;
            $totdays = 0;
            if (!isset($CUTOFF_YEARS)) $CUTOFF_YEARS = 2; // remove from the stats if less than 2 years old
            while ($line = tng_fetch_array($result, 'assoc')) {
                $yearsold = $line['yearsold'];
                $daysold = $line['daysold'];
                if ($daysold < 0) {
                    if ($yearsold > 0) {
                        $yearsold--;
                        $daysold = 365 + $daysold;
                    }
                }
                if ($yearsold >= $CUTOFF_YEARS) {
                    $totyears += $yearsold;
                    $numpeople++;
                    $totdays += $daysold;
                }
            }
            $avgyears = $numpeople ? $totyears / $numpeople : 0;
            // convert the remainder from $avgyears to days
            $avgdays = ($avgyears - floor($avgyears)) * 365;
            // add the number of averge days calculated from $totdays
            $avgdays += $numpeople ? $totdays / $numpeople : 0;
            // if $avgdays is more than a year, we've got to adjust things!
            if ($avgdays > 365) {
                // add the number of additional years $avgdaysgives us
                $avgyears += floor($avgdays / 365);
                //change $avgdays to days left after removing multiple
                //years' worth of days.
                $avgdays = $avgdays - (floor($avgdays / 365) * 365);
            }
            $avgyears = floor($avgyears);
            $avgdays = floor($avgdays);
            tng_free_result($result);
            $percentmales = $totalpeople ? round(100 * $males / $totalpeople, 2) : 0;
            $percentfemales = $totalpeople ? round(100 * $females / $totalpeople, 2) : 0;
            $percentunknownsex = $totalpeople ? round(100 * $unknownsex / $totalpeople, 2) : 0;
            $people = $totalpeople;
            $totalpeople = number_format($people);
            $totalfamilies = number_format($totalfamilies);
            $fmt_males = number_format($males);
            $fmt_females = number_format($females);
            $fmt_unknownsex = number_format($unknownsex);
            $fmt_numdeceased = number_format($numdeceased);
            ?>
            <tr>
                <td class='databack'><span class='normal'><?php echo $text['totindividuals']; ?></span></td>
                <td class='text-right databack'><span class='normal'><?php echo $totalpeople; ?></span></td>
            </tr>
            <tr>
                <td class='databack'><span class='normal'><?php echo $text['totmales']; ?></span></td>
                <td class='text-right databack'><span class='normal'><?php echo "$fmt_males ($percentmales%)"; ?></span></td>
            </tr>
            <tr>
                <td class='databack'><span class='normal'><?php echo $text['totfemales']; ?></span></td>
                <td class='text-right databack'><span class='normal'><?php echo "$fmt_females ($percentfemales%)"; ?></span></td>
            </tr>
            <tr>
                <td class='databack'><span class='normal'><?php echo $text['totunknown']; ?></span></td>
                <td class='text-right databack'><span class='normal'><?php echo "$fmt_unknownsex ($percentunknownsex%)"; ?></span></td>
            </tr>
            <tr>
                <td class='databack'><span class='normal'><?php echo $text['totliving']; ?></span></td>
                <td class='text-right databack'><span class='normal'><?php echo $numliving; ?></span></td>
            </tr>
            <tr>
                <td class='databack'><span class='normal'><?php echo $text['totfamilies']; ?></span></td>
                <td class='text-right databack'><span class='normal'><?php echo $totalfamilies; ?></span></td>
            </tr>
            <tr>
                <td class='databack'><span class='normal'><?php echo $text['totuniquesn']; ?></span></td>
                <td class='text-right databack'><span class='normal'><?php echo $uniquesurnames; ?></span></td>
            </tr>
            <?php
            $media_data = $media_names = [];
            $index = 0;
            foreach ($mediatypes as $mediatype) {
                $mediatypeID = $mediatype['ID'];
                $titlestr = $text[$mediatypeID] ? $text[$mediatypeID] : $mediatypes_display[$mediatypeID];
                ?>
                <tr>
                    <td class='databack'><span class='normal'><?php echo "{$text['total']} $titlestr"; ?></span></td>
                    <td class='text-right databack'><span class='normal'><?php echo number_format($totalmedia[$mediatypeID]); ?></span></td>
                </tr>
                <?php
                array_push($media_data, $totalmedia[$mediatypeID]);
                array_push($media_names, $titlestr);
                if ($index < 16) {
                    $index++;
                } else {
                    $index = 0;
                }
            }
            ?>
            <tr>
                <td class='databack'><span class='normal'><?php echo $text['totsources']; ?></span></td>
                <td class='text-right databack'><span class='normal'><?php echo $totalsources; ?></span></td>
            </tr>
            <tr>
                <td class='databack normal'><?php echo $text['avglifespan']; ?><sup>1</sup></td>
                <td class='text-right databack'><span class='normal'><?php echo "$avgyears {$text['years']}, $avgdays {$text['days']}"; ?></span></td>
            </tr>
            <tr>
                <td class='databack'><span class='normal'><?php echo $text['earliestbirth']; ?>
                        <?php
                        if ($firstallowed) {
                            echo " (<a href=\"getperson.php?personID=$firstbirthpersonid&amp;tree=$firstbirthgedcom\">$firstbirthfirstname $firstbirthlnprefix $firstbirthlastname</a>)";
                        }
                        ?>
            </span></td>
                <td class='text-right databack'><span class='normal'><?php echo displayDate($firstbirthdate); ?></span></td>
            </tr>
            <?php if ($tngconfig['lastimport'] && $treerow['treename'] && $lastimportdate) { ?>
                <tr>
                    <td class='databack'><span class='normal'><?php echo $text['lastimportdate']; ?></span></td>
                    <?php
                    $importtime = strtotime($lastimportdate);
                    if (substr($lastimport, 11, 8) != "00:00:00") {
                        $importtime += ($time_offset * 3600);
                    }
                    $importdate = strftime("%d %b %Y %H:%M:%S", $importtime);
                    ?>
                    <td class='text-right databack'><span class='normal'><?php echo displayDate($importdate); ?></span></td>
                </tr>
            <?php } ?>
        </table>
        <br>
        <table class='container max-w-lg md:mx-4 whiteback normal'>
            <thead>
            <tr>
                <th class="fieldnameback fieldname"><?php echo $text['longestlived']; ?><sup>1</sup></th>
                <th class="w-1/3 text-right fieldnameback fieldname"><?php echo $text['age']; ?></th>
            </tr>
            </thead>
            <?php
            $query = "SELECT personID, firstname, lnprefix, lastname, gedcom, living, private, branch, YEAR( deathdatetr ) - YEAR( birthdatetr ) AS yearsold, DAYOFYEAR( deathdatetr ) - DAYOFYEAR( birthdatetr ) AS daysold, IF(DAYOFYEAR(deathdatetr) and DAYOFYEAR(birthdatetr),TO_DAYS(deathdatetr) - TO_DAYS(birthdatetr),(YEAR(deathdatetr) - YEAR(birthdatetr)) * 365) as totaldays ";
            $query .= "FROM $people_table ";
            $query .= "WHERE birthdatetr != '0000-00-00' AND deathdatetr != '0000-00-00' $wherestr2 AND birthdate not like 'AFT%' AND deathdate not like 'AFT%' AND birthdate not like 'BEF%' AND deathdate not like 'BEF%' AND birthdate not like 'ABT%' AND deathdate not like 'ABT%' AND birthdate not like 'BET%' AND deathdate not like 'BET%' AND birthdate not like 'CAL%' AND deathdate not like 'CAL%' ";
            $query .= "ORDER BY totaldays DESC LIMIT 10";
            $result = tng_query($query);
            $numpeople = tng_num_rows($result);
            while ($line = tng_fetch_array($result, 'assoc')) {
                $personid = $line['personID'];
                $firstname = $line['firstname'];
                $lnprefix = $line['lnprefix'];
                $lastname = $line['lastname'];
                $yearsold = $line['yearsold'];
                $daysold = $line['daysold'];
                $gedcom = $line['gedcom'];
                $rights = determineLivingPrivateRights($line);
                $allowed = $rights['both'];
                $line['allow_living'] = $rights['living'];
                $line['allow_private'] = $rights['private'];
                if ($daysold < 0) {
                    if ($yearsold > 0) {
                        $yearsold--;
                        $daysold = 365 + $daysold;
                    }
                }
                ?>
                <tr>
                    <td class='databack'>
                        <span class='normal'>
                            <a href='getperson.php?personID=$personid&amp;tree=$gedcom'><?php echo getName($line); ?></a>
                        </span>
                    </td>
                    <td class='text-right databack'>
                        <span class='normal'>
                            <?php
                            if ($yearsold) {
                                echo number_format($yearsold) . " " . $text['years'];
                            }
                            if ($daysold) echo " $daysold " . $text['days'];
                            ?>
                        </span>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <br>

        <table class='container max-w-lg md:mx-4 whiteback'>
            <tr>
                <td class='align-top fieldnameback fieldname'><small>1</small></td>
                <td class='databack normal'><?php echo $text['agedisclaimer']; ?></td>
            </tr>
        </table>
        <?php
        tng_free_result($result);
        if ($tree && !$treerow['secret']) {
            ?>
            <br>
            <span class='normal'><a href='showtree.php?tree=$tree'><?php echo $text['treedetail']; ?></a></span>
            <br>
        <?php } ?>
        <br>
    </div>
    <div id="charts" class="container inline-block max-w-md">
        <div id="gender_chart"></div>
        <div id="living_chart"></div>
        <div id="media_chart"></div>
    </div>
    <script>
        const gender_chart = c3.generate({
            bindto: '#gender_chart',
            data: {
                columns: [
                    ['data1', <?php echo $males; ?>],
                    ['data2', <?php echo $females; ?>],
                    ['data3', <?php echo $unknownsex; ?>]
                ],
                type: 'pie',
                names: {
                    data1: "<?php echo $text['totmales'] . " ($fmt_males)"; ?>",
                    data2: "<?php echo $text['totfemales'] . " ($fmt_females)"; ?>",
                    data3: "<?php echo $text['totunknown'] . " ($fmt_unknownsex)"; ?>"
                },
                colors: {
                    data1: '#0af',
                    data2: '#f9c',
                    data3: '#090'
                }
            }
        });
        const living_chart = c3.generate({
            bindto: '#living_chart',
            data: {
                columns: [
                    ['data1', <?php echo $living; ?>],
                    ['data2', <?php echo $people - $living; ?>]
                ],
                type: 'pie',
                names: {
                    data1: "<?php echo $text['totliving'] . " ($numliving)"; ?>",
                    data2: "<?php echo $text['totdeceased'] . " ($fmt_numdeceased)"; ?>"
                },
                colors: {
                    data1: '#900',
                    data2: '#009'
                }
            }
        });
        const media_chart = c3.generate({
            bindto: '#media_chart',
            data: {
                columns: [
                    <?php
                    $count = 0;
                    $tot_media_data = count($media_data);
                    $indexed = [];
                    foreach ($media_data as $data) {
                        $indexed[$count] = $data;
                        $count++;
                        $comma = $count != $tot_media_data ? "," : "";
                        echo "['data{$count}', $data]{$comma}\n";
                    }
                    ?>
                ],
                type: 'pie',
                names: {
                    <?php
                    $count = 0;
                    $tot_media_names = count($media_names);
                    foreach ($media_names as $name) {
                        $total = $indexed[$count];
                        $count++;
                        $comma = $count != $tot_media_names ? "," : "";
                        echo "data{$count}: \"{$name} ({$total})\"{$comma}\n";
                    }
                    ?>
                }
            }
        });
    </script>
<?php tng_footer(""); ?>
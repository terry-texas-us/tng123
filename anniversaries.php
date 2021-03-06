<?php

$textpart = "search";
include "tng_begin.php";
include "functions.php";
require_once "admin/pagination.php";
if (isset($tngyear)) {
    $tngyear = preg_replace("/[^0-9]/", "", $tngyear);
}
$tngkeywords = preg_replace("/[^A-Za-z0-9]/", "", $tngkeywords);
@set_time_limit(0);
if (!$tngneedresults) {
    //get today's date
    $tngdaymonth = date("d", time() + (3600 * $time_offset));
    $tngmonth = date("m", time() + (3600 * $time_offset));
    $tngneedresults = 1;
} else {
    if (isset($tngdaymonth)) {
        $tngdaymonth = preg_replace("/[^0-9]/", '', $tngdaymonth);
    }
    if (isset($tngmonth)) {
        $tngmonth = preg_replace("/[^0-9]/", '', $tngmonth);
    }
    $tngneedresults = preg_replace("/[^0-9]/", '', $tngneedresults);
}
if ($tree && $tree != '-x--all--x-') {
    $righttree = checktree($tree);
} else {
    $righttree = -1;
}
$treestr = $tree ? " (" . _('Tree') . ": $tree)" : "";
$logstring = "<a href=\"anniversaries.php?tngevent=$tngevent&amp;tngdaymonth=$tngdaymonth&amp;tngmonth=$tngmonth&amp;tngyear=$tngyear&amp;tngkeywords=$tngkeywords&amp;tngneedresults=$tngneedresults&amp;offset=$offset&amp;tree=$tree&amp;tngpage=$tngpage\">" . xmlcharacters(_('Dates and Anniversaries') . " $treestr") . "</a>";
writelog($logstring);
preparebookmark($logstring);
//compute $allwhere from submitted criteria
$ldsOK = determineLDSRights();
tng_header(_('Dates and Anniversaries'), $flags);
?>
    <script src="js/search.js"></script>
    <script>
        // <![CDATA[
        function resetForm() {
            let myform = document.form1;
            myform.tngevent.selectedIndex = 0;
            myform.tngdaymonth.value = "";
            myform.tngmonth.selectedIndex = 0;
            myform.tngyear.value = "";
            myform.tngkeywords.value = "";
        }

        function validateForm(form) {
            let rval = true;
            if (form.tngdaymonth.selectedIndex === 0 && form.tngmonth.selectedIndex === 0 && form.tngyear.value.length === 0 && form.tngkeywords.value.length === 0) {
                alert("<?php echo _('Please enter or select at least one of the following: Day, Month, Year, Keyword'); ?>");
                rval = false;
            }
            return rval;
        }

        //]]>
    </script>
    <h2 class="mb-4 header"><span class="headericon" id="dates-hdr-icon"></span><?php echo _('Dates and Anniversaries'); ?></h2>
    <form action="anniversaries2.php" method="get" name="form1" id="form1" onsubmit="return validateForm(this);">
        <?php echo treeDropdown(['startform' => false, 'endform' => false, 'name' => 'form1']); ?>
        <p class="normal"><?php echo _('Enter date components to see matching events. Leave a field blank to see matches for all.'); ?></p>
        <div class="annfield normal">
            <label for="tngevent"><?php echo _('Event(s)'); ?>:</label>
            <br>
            <select id="tngevent" class="p-2" name="tngevent" style="max-width: 335px;">
                <?php
                echo "<option value=''>&nbsp;</option>\n";
                echo "<option value='birth'";
                if ($tngevent == "birth") echo " selected";
                echo ">" . _('Born') . "</option>\n";
                echo "<option value='altbirth'";
                if ($tngevent == "altbirth") echo " selected";
                echo ">" . _('Christened') . "</option>\n";
                echo "<option value='death'";
                if ($tngevent == "death") echo " selected";
                echo ">" . _('Died') . "</option>\n";
                echo "<option value='burial'";
                if ($tngevent == "burial") echo " selected";
                echo ">" . _('Buried') . "</option>\n";
                echo "<option value='marr'";
                if ($tngevent == "marr") echo " selected";
                echo ">" . _('Married') . "</option>\n";
                echo "<option value='div'";
                if ($tngevent == "div") echo " selected";
                echo ">" . _('Divorced') . "</option>\n";
                if ($ldsOK) {
                    echo "<option value='bapt'";
                    if ($tngevent == "bapt") echo " selected";
                    echo ">" . _('Baptized (LDS)') . "</option>\n";
                    echo "<option value='conf'";
                    if ($tngevent == "conf") echo " selected";
                    echo ">" . _('Confirmed (LDS)') . "</option>\n";
                    echo "<option value='init'";
                    if ($tngevent == "init") echo " selected";
                    echo ">" . _('Initiatory (LDS)') . "</option>\n";
                    echo "<option value='endl'";
                    if ($tngevent == "endl") echo " selected";
                    echo ">" . _('Endowed (LDS)') . "</option>\n";
                    echo "<option value='seal'";
                    if ($tngevent == "seal") echo " selected";
                    echo ">" . _('Sealed to Spouse (LDS)') . "</option>\n";
                }
                //loop through custom event types where keep=1, not a standard event
                $query = "SELECT eventtypeID, tag, display FROM $eventtypes_table WHERE keep = '1' AND type = 'I' ORDER BY display";
                $result = tng_query($query);
                $eventTypes = tng_fetch_all($result);
                tng_free_result($result);
                foreach ($eventTypes as $row) {
                    if (!in_array($row['tag'], ["ADDR", "BIRT", "CHR", "DEAT", "BURI", "NAME", "NICK", "TITL", "NSFX", "DIV", "MARR"])) {
                        echo "<option value=\"{$row['eventtypeID']}\"";
                        if ($tngevent == $row['eventtypeID']) echo " selected";
                        echo ">" . getEventDisplay($row['display']) . "</option>\n";
                    }
                }
                ?>
            </select>
        </div>
        <div class="annfield normal">
            <label for="tngdaymonth"><?php echo _('Day'); ?>:</label>
            <br>
            <select class="p-2" name="tngdaymonth" id="tngdaymonth">
                <option value="">&nbsp;</option>
                <?php
                for ($i = 1; $i <= 31; $i++) {
                    echo "<option value=\"$i\"";
                    if ($i == $tngdaymonth) echo " selected";
                    echo ">$i</option>\n";
                }
                $tngkeywordsclean = preg_replace("/\"/", "&#34;", stripslashes($tngkeywords));
                ?>
            </select>
        </div>
        <div class="annfield normal">
            <label for="tngmonth" class="annlabel"><?php echo _('Month'); ?>:</label>
            <br>
            <select class="p-2" name="tngmonth" id="tngmonth">
                <option value="">&nbsp;</option>
                <option value="1"<?php if ($tngmonth == 1) {
                    echo " selected";
                } ?>><?php echo _('January'); ?></option>
                <option value="2"<?php if ($tngmonth == 2) {
                    echo " selected";
                } ?>><?php echo _('February'); ?></option>
                <option value="3"<?php if ($tngmonth == 3) {
                    echo " selected";
                } ?>><?php echo _('March'); ?></option>
                <option value="4"<?php if ($tngmonth == 4) {
                    echo " selected";
                } ?>><?php echo _('April'); ?></option>
                <option value="5"<?php if ($tngmonth == 5) {
                    echo " selected";
                } ?>><?php echo _('May'); ?></option>
                <option value="6"<?php if ($tngmonth == 6) {
                    echo " selected";
                } ?>><?php echo _('June'); ?></option>
                <option value="7"<?php if ($tngmonth == 7) {
                    echo " selected";
                } ?>><?php echo _('July'); ?></option>
                <option value="8"<?php if ($tngmonth == 8) {
                    echo " selected";
                } ?>><?php echo _('August'); ?></option>
                <option value="9"<?php if ($tngmonth == 9) {
                    echo " selected";
                } ?>><?php echo _('September'); ?></option>
                <option value="10"<?php if ($tngmonth == 10) {
                    echo " selected";
                } ?>><?php echo _('October'); ?></option>
                <option value="11"<?php if ($tngmonth == 11) {
                    echo " selected";
                } ?>><?php echo _('November'); ?></option>
                <option value="12"<?php if ($tngmonth == 12) {
                    echo " selected";
                } ?>><?php echo _('December'); ?></option>
            </select>
        </div>
        <div class="annfield normal">
            <label for="tngyear"><?php echo _('Year'); ?>:</label>
            <br>
            <input id="tngyear" class="p-2" name="tngyear" type="text" value="<?php echo $tngyear; ?>" size="6" maxlength="4">
        </div>
        <div class="annfield normal">
            <label for="tngkeywords"><?php echo _('Keyword (ie, \"Abt\")'); ?>:</label>
            <br>
            <input id="tngkeywords" class="p-2" name="tngkeywords" type="text" value="<?php echo stripslashes($tngkeywordsclean); ?>" size="20">
        </div>
        <div class="annfield normal">
            <br>
            <input type="hidden" name="tngneedresults" value="1">
            <input class="p-2" type="submit" value="<?php echo _('Search'); ?>">
            <input class="p-2" type="button" value="<?php echo _('Reset'); ?>" onclick="resetForm();">
            <input class="p-2" type="button" value="<?php echo _('Calendar'); ?>" onclick="window.location.href='<?php echo "calendar.php?m=$tngmonth&amp;year=$tngyear&amp;tree=$tree"; ?>';">
        </div>
    </form>
    <br class="clear-both">
    <br>

<?php
if ($tngneedresults) {
    $successcount = 0;
    if ($tngevent) {
        $tngevents = [$tngevent];
    } else {
        $tngevents = ["birth", "altbirth", "death", "burial", "marr", "div"];
        if ($ldsOK) {
            $ldsevents = ["seal", "endl", "bapt", "conf", "init"];
            $tngevents = array_merge($tngevents, $ldsevents);
        }
        $query = "SELECT tag, eventtypeID FROM $eventtypes_table WHERE keep = '1' AND type = 'I' ORDER BY display";
        $result = tng_query($query);
        $eventTypes = tng_fetch_all($result);
        tng_free_result($result);
        foreach ($eventTypes as $row) {
            if (!in_array($row['tag'], ["ADDR", "BIRT", "CHR", "DEAT", "BURI", "NAME", "NICK", "TITL", "NSFX", "DIV", "MARR"])) {
                array_push($tngevents, $row['eventtypeID']);
            }
        }
    }
    foreach ($tngevents as $tngevent) {
        $allwhere = "";
        $eventsjoin = "";
        $eventsfields = "";
        $needfamilies = "";
        $tngsaveevent = $tngevent;
        switch ($tngevent) {
            case "birth":
                $datetxt = _('Born');
                break;
            case "altbirth":
                $datetxt = _('Christened');
                break;
            case "death":
                $datetxt = _('Died');
                break;
            case "burial":
                $datetxt = _('Buried');
                break;
            case "marr":
                $datetxt = _('Married');
                $needfamilies = 1;
                break;
            case "div":
                $datetxt = _('Divorced');
                $needfamilies = 1;
                break;
            case "seal":
                $datetxt = _('Sealed to Spouse (LDS)');
                $needfamilies = 1;
                break;
            case "endl":
                $datetxt = _('Endowed (LDS)');
                break;
            case "bapt":
                $datetxt = _('Baptized (LDS)');
                break;
            case "conf":
                $datetxt = _('Confirmed (LDS)');
                break;
            case "init":
                $datetxt = _('Initiatory (LDS)');
                break;
            default:
                //look up display
                $query = "SELECT display FROM $eventtypes_table WHERE eventtypeID = '$tngevent' ORDER BY display";
                $evresult = tng_query($query);
                $event = tng_fetch_assoc($evresult);
                $datetxt = getEventDisplay($event['display']);
                tng_free_result($evresult);
                $eventsjoin = ", $events_table events";
                $eventsfields = ", info";
                $allwhere .= " AND $people_table.personID = events.persfamID AND $people_table.gedcom = events.gedcom AND eventtypeID = '$tngevent'";
                $tngevent = "event";
                break;
        }
        if ($needfamilies) {
            $familiessortdate = ", " . $tngevent . "datetr";
        } else {
            $familiessortdate = "";
        }
        $datefield = $tngevent . "date";
        $datefieldtr = $tngevent . "datetr";
        $place = $tngevent . "place";
        if ($tngdaymonth) {
            $allwhere .= " AND DAYOFMONTH($datefieldtr) = '$tngdaymonth'";
        }
        if ($tngmonth) {
            $allwhere .= " AND MONTH($datefieldtr) = '$tngmonth'";
        }
        if ($tngyear) $allwhere .= " AND YEAR($datefieldtr) = '$tngyear'";
        if ($tngkeywords) {
            $allwhere .= " AND $datefield LIKE '%$tngkeywords%'";
        }
        if ($tngdaymonth || $tngmonth || $tngyear) {
            $allwhere .= " AND $datefieldtr != '0000-00-00'";
        }
        if ($tree) {
            if ($urlstring) $urlstring .= "&amp;";
            $urlstring .= "tree=$tree";
            if ($allwhere) $allwhere = " AND (1=1 $allwhere)";
            if ($needfamilies) {
                $allwhere .= " AND families.gedcom='$tree'";
            } else {
                $allwhere .= " AND $people_table.gedcom='$tree'";
            }
        }
        if ($needfamilies) {
            $more = getLivingPrivateRestrictions("families", false, true);
        } else {
            $more = getLivingPrivateRestrictions($people_table, false, true);
        }
        if ($more) $allwhere .= " AND " . $more;
        $max_browsesearch_pages = 5;
        if ($offset) {
            $offsetplus = $offset + 1;
            $newoffset = "$offset, ";
        } else {
            $offset = 0;
            $offsetplus = 1;
            $newoffset = "";
            $tngpage = 1;
        }
        if ($needfamilies) {
            //run query on families table
            //join with both hperson and wperson to get husband and wife info
            $query = "SELECT families.ID, husb.personID AS hpersonID, husb.lastname AS hlastname, husb.lnprefix AS hlnprefix, husb.firstname AS hfirstname, husb.living AS hliving, husb.private AS hprivate, husb.branch AS hbranch, husb.prefix AS hprefix, husb.suffix AS hsuffix, husb.nameorder AS hnameorder, wife.personID AS wpersonID, wife.lastname AS wlastname, wife.lnprefix AS wlnprefix, wife.firstname AS wfirstname, wife.living AS wliving, wife.private AS wprivate, wife.branch AS wbranch, wife.prefix AS wprefix, wife.suffix AS wsuffix, wife.nameorder AS wnameorder, $place, $datefield, families.gedcom, treename, families.living, families.private, families.branch $familiessortdate ";
            $query .= "FROM ($families_table families, $trees_table trees) ";
            $query .= "LEFT JOIN $people_table husb ON families.husband = husb.personID AND families.gedcom = husb.gedcom ";
            $query .= "LEFT JOIN $people_table wife ON families.wife = wife.personID AND families.gedcom = wife.gedcom ";
            $query .= "WHERE families.gedcom = trees.gedcom $allwhere ";
            $query .= " ORDER BY DAY($datefieldtr), MONTH($datefieldtr), YEAR($datefieldtr), hlastname, hfirstname ";
            $query .= "LIMIT $newoffset" . $maxsearchresults;
            //assemble two-row name & person ID values
        } else {
            //run regular query on people table
            $query = "SELECT $people_table.ID, $people_table.personID, lastname, lnprefix, firstname, $people_table.living, $people_table.branch, prefix, suffix, nameorder, $place, $datefield, $people_table.gedcom, treename $familiessortdate $eventsfields ";
            $query .= "FROM ($people_table, $trees_table $eventsjoin) ";
            $query .= "WHERE $people_table.gedcom = $trees_table.gedcom $allwhere ";
            $query .= " ORDER BY DAY($datefieldtr), MONTH($datefieldtr), YEAR($datefieldtr), lastname, firstname ";
            $query .= "LIMIT $newoffset" . $maxsearchresults;
            //"assemble" one-row name & person ID value
        }
        //pass assembled values to the table mechanism below
        $result = tng_query($query);
        $numrows = tng_num_rows($result);
        if ($numrows == $maxsearchresults || $offsetplus > 1) {
            if ($needfamilies) {
                $query = "SELECT count(familyID) AS pcount FROM ($families_table, $trees_table) WHERE $families_table.gedcom = $trees_table.gedcom $allwhere";
            } else {
                $query = "SELECT count(personID) AS pcount FROM ($people_table, $trees_table $eventsjoin) WHERE $people_table.gedcom = $trees_table.gedcom $allwhere";
            }
            $result2 = tng_query($query);
            $countrow = tng_fetch_assoc($result2);
            $totrows = $countrow['pcount'];
        } else {
            $totrows = $numrows;
        }
        if ($numrows) {
            $numrowsplus = $numrows + $offset;
            $successcount++;
            ?>
            <div class='rounded-lg titlebox'>
            <h3 class='subhead'><?php echo $datetxt; ?></h3>
            <div class='w-full class=lg:flex my-6'>
                <?php
                echo getPaginationLocationHtml($offsetplus, $numrowsplus, $totrows);
                echo getPaginationControlsHtml($totrows, "anniversaries2.php?$urlstring&amp;tngevent=$tngsaveevent&amp;tngdaymonth=$tngdaymonth&amp;tngmonth=$tngmonth&amp;tngyear=$tngyear&amp;tngkeywords=$tngkeywords&amp;tngneedresults=1&amp;offset", $maxsearchresults);
                ?>
            </div>
            <table class='whiteback normal'>
                <thead>
                <tr>
                    <th class="hidden p-2 sm:table-cell fieldnameback nbrcol fieldname">#</th>
                    <th class="p-2 whitespace-no-wrap fieldnameback fieldname"><?php echo _('Last Name, First Name'); ?></th>
                    <th class="p-2 fieldnameback fieldname"><?php echo $datetxt; ?></th>
                    <th class="p-2 whitespace-no-wrap fieldnameback fieldname"><?php echo _('Person ID'); ?></th>
                    <?php if ($numtrees > 1) { ?>
                        <th class="p-2 fieldnameback fieldname"><?php echo _('Tree'); ?></th>
                    <?php } ?>
                </tr>
                </thead>
                <?php
                $i = $offsetplus;
                $treestr = $tngconfig['places1tree'] ? "" : "tree=$tree&amp;";
                while ($row = tng_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td class='hidden p-2 sm:table-cell databack'>$i</td>\n";
                    $i++;
                    echo "<td class='p-2 databack'>\n";
                    $personIDstr = $namestr = $hboth = $wboth = "";
                    if ($needfamilies) {
                        //do husband
                        $famrights = determineLivingPrivateRights($row, $righttree);
                        if ($row['hpersonID']) {
                            $row['personID'] = $row['hpersonID'];
                            $row['lastname'] = $row['hlastname'];
                            $row['lnprefix'] = $row['hlnprefix'];
                            $row['firstname'] = $row['hfirstname'];
                            $row['living'] = $row['hliving'];
                            $row['private'] = $row['hprivate'];
                            $row['branch'] = $row['hbranch'];
                            $row['prefix'] = $row['hprefix'];
                            $row['suffix'] = $row['hsuffix'];
                            $row['nameorder'] = $row['hnameorder'];
                            $rights = determineLivingPrivateRights($row);
                            $row['allow_living'] = $rights['living'];
                            $row['allow_private'] = $rights['private'];
                            $hboth = $rights['both'];
                            $name = getNameRev($row);
                            $personIDstr = $row['hpersonID'];
                            $namestr .= "<div class='person-img' id=\"mi{$row['gedcom']}_{$row['personID']}_$tngevent\">\n";
                            $namestr .= "<div class='person-prev' id=\"prev{$row['gedcom']}_{$row['personID']}_$tngevent\"></div>\n";
                            $namestr .= "</div>\n";
                            $namestr .= "<a href=\"pedigree.php?personID={$row['personID']}&amp;tree={$row['gedcom']}\">";
                            $namestr .= "<img src='img/chart.gif' alt='' class='inline-block'>";
                            $namestr .= "</a> <a href=\"getperson.php?personID={$row['personID']}&amp;tree={$row['gedcom']}\" class='pers' id=\"p{$row['personID']}_t{$row['gedcom']}:$tngevent\">$name</a>&nbsp;";
                        }
                        //now dow wife
                        if ($row['wpersonID']) {
                            $row['personID'] = $row['wpersonID'];
                            $row['lastname'] = $row['wlastname'];
                            $row['lnprefix'] = $row['wlnprefix'];
                            $row['firstname'] = $row['wfirstname'];
                            $row['living'] = $row['wliving'];
                            $row['private'] = $row['wprivate'];
                            $row['branch'] = $row['wbranch'];
                            $row['prefix'] = $row['wprefix'];
                            $row['suffix'] = $row['wsuffix'];
                            $row['nameorder'] = $row['wnameorder'];
                            $rights = determineLivingPrivateRights($row);
                            $row['allow_living'] = $rights['living'];
                            $row['allow_private'] = $rights['private'];
                            $wboth = $rights['both'];
                            $name = getNameRev($row);
                            if ($personIDstr) $personIDstr .= "<br>";
                            $personIDstr .= $row['wpersonID'];
                            if ($namestr) $namestr .= "<br>";
                            $namestr .= "<div class='person-img' id=\"mi{$row['gedcom']}_{$row['personID']}_$tngevent\">\n";
                            $namestr .= "<div class='person-prev' id=\"prev{$row['gedcom']}_{$row['personID']}_$tngevent\"></div>\n";
                            $namestr .= "</div>\n";
                            $namestr .= "<a href=\"pedigree.php?personID={$row['personID']}&amp;tree={$row['gedcom']}\">";
                            $namestr .= "<img src='img/chart.gif' alt='' class='inline-block'>";
                            $namestr .= "</a> <a href=\"getperson.php?personID={$row['personID']}&amp;tree={$row['gedcom']}\" class='pers' id=\"p{$row['personID']}_t{$row['gedcom']}:$tngevent\">$name</a>&nbsp;";
                        }
                        $rights['both'] = $hboth && $wboth && $famrights['both'];
                    } else {
                        $rights = determineLivingPrivateRights($row);
                        $row['allow_living'] = $rights['living'];
                        $row['allow_private'] = $rights['private'];
                        $name = getNameRev($row);
                        $personIDstr = $row['personID'];
                        $namestr .= "<div class='person-img' id=\"mi{$row['gedcom']}_{$row['personID']}_$tngevent\">\n";
                        $namestr .= "<div class='person-prev' id=\"prev{$row['gedcom']}_{$row['personID']}_$tngevent\"></div>\n";
                        $namestr .= "</div>\n";
                        $namestr .= "<a href=\"pedigree.php?personID={$row['personID']}&amp;tree={$row['gedcom']}\">";
                        $namestr .= "<img src='img/chart.gif' alt='' class='inline-block'>";
                        $namestr .= "</a> <a href=\"getperson.php?personID={$row['personID']}&amp;tree={$row['gedcom']}\" class='pers' id=\"p{$row['personID']}_t{$row['gedcom']}:$tngevent\">$name</a>&nbsp;";
                    }
                    echo $namestr;
                    if ($rights['both']) {
                        $icon = buildSvgElement("img/search.svg", ["class" => "w-3 h-3 fill-current inline-block"]);
                        $placetxt = $row[$place] ? $row[$place] . " <a href='placesearch.php?{$treestr}psearch=" . urlencode($row[$place]) . "' title=\"" . _('Find all individuals with events at this location') . "\">$icon</a>" : truncateIt($row['info'], 75);
                        $dateval = $row[$datefield];
                    } else {
                        $dateval = $placetxt = "";
                    }
                    echo "</td>\n";
                    echo "<td class='p-2 databack'>" . displayDate($dateval) . "<br>$placetxt</td>";
                    echo "<td class='p-2 databack'>$personIDstr </td>";
                    if ($numtrees > 1) {
                        echo "<td class='p-2 databack'><a href=\"showtree.php?tree={$row['gedcom']}\">{$row['treename']}</a></td>";
                    }
                    echo "</tr>\n";
                }
                tng_free_result($result);
                ?>

            </table>

            <?php
            if ($pagenav) echo "<p>$pagenav</p>";
            echo "</div><br>\n";
        }
    }
    if (!$successcount) echo "<p>" . _('No results found. Please try again.') . ".</p>";
} //end of $tng_needresults
tng_footer("");
?>
<?php

$textpart = "whatsnew";
include "tng_begin.php";

include "functions.php";

require_once "./public/people.php";

$_SESSION['tng_mediatree'] = $tree;
$_SESSION['tng_mediasearch'] = "";

$flags['imgprev'] = true;

if (!$change_cutoff) $change_cutoff = 0;

$pastxdays = $change_cutoff ? " " . preg_replace("/xx/", $change_cutoff, $text['pastxdays']) : "";
$whatsnew = 1;

$branchquery = "SELECT count(branch) AS branchcount FROM $branches_table";
$branchresult = tng_query($branchquery);
$branchrow = tng_fetch_assoc($branchresult);
$numbranches = $branchrow['branchcount'];
tng_free_result($branchresult);

$logstring = "<a href='whatsnew.php'>" . xmlcharacters($text['whatsnew'] . $pastxdays) . "</a>";
writelog($logstring);
preparebookmark($logstring);

tng_header($text['whatsnew'] . " " . $pastxdays, $flags);

//get all users, username + description
//put in assoc table
//pass to media functions
//do lookups in each area
//set $currentuser = "" if only 1

$query = "SELECT username, description FROM $users_table WHERE allow_living != '-1' AND (allow_edit = '1' OR allow_add = '1')";
$result = tng_query($query);
$users = tng_fetch_all($result);
tng_free_result($result);
$userlist = [];
if (count($users) == 1) $currentuser = "";

if ($currentuser) {
    foreach ($users as $row) {
        if ($row['description']) {
            $key = $row['username'];
            $userlist[$key] = $row['description'];
        }
    }
}
?>
    <h2 class="header"><span class="headericon" id="whatsnew-hdr-icon"></span><?php echo $text['whatsnew'] . " " . $pastxdays; ?></h2>
    <br>
<?php
$numtrees = 0;
echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'whatsnew', 'method' => 'get', 'name' => 'form1', 'id' => 'form1', 'lastimport' => true]);
$nametitle = $text['lastfirst'];
$header1 = "<table class = 'w-11/12 mx-auto whiteback normal'>";
$header1 .= "<thead>";
$header1 .= "<tr>\n";
$header1 .= "<th class = 'p-2 text-center fieldnameback thumbnails fieldname'>{$text['thumb']}</th>\n";
$header1 .= "<th class = 'p-2 fieldnameback fieldname'>{$text['description']}</th>\n";
$hsheader = "<th class = 'p-2 fieldnameback fieldname'>{$text['cemetery']}</th>\n";
$hsheader .= "<th class = 'p-2 fieldnameback fieldname'>{$text['status']}</th>\n";
$header2 .= "<th class= 'p-2 fieldnameback fieldname'>{$text['indlinked']}</th>\n";
$header2 .= "<th class = 'hidden p-2 md:w-32 md:table-cell fieldnameback fieldname'>{$text['lastmodified']}</th>\n";
$header2 .= "</tr>\n";
$header2 .= "</thead>\n";
$footer = "</table>\n";
if ($tree) {
    $wherestr = "($media_table.gedcom = '$tree' || $media_table.gedcom = \"\") AND ";
    $wherestr2 = " AND $medialinks_table.gedcom = '$tree'";
} else {
    $wherestr = $wherestr2 = "";
}

if (!$change_limit) $change_limit = 10;

//check for custom message
$file = $rootpath . "whatsnew.txt";
if (file_exists($file)) {
    $contents = file($file);
    foreach ($contents as $line) {
        if (trim($line)) echo "<p>$line</p>";
    }
}

foreach ($mediatypes as $mediatype) {
    $mediatypeID = $mediatype['ID'];
    $header = $mediatypeID == "headstones" ? $header1 . $hsheader . $header2 : $header1 . $header2;
    echo doMedia($mediatypeID);
}

//select from people where date later than cutoff, order by changedate descending, limit = 10
$query = "SELECT people.personID, lastname, lnprefix, firstname, birthdate, prefix, suffix, nameorder, living, private, branch, DATE_FORMAT(changedate,'%e %b %Y') AS changedatef, changedby, LPAD(SUBSTRING_INDEX(birthdate, ' ', -1), 4, '0') AS birthyear, birthplace, altbirthdate, LPAD(SUBSTRING_INDEX(altbirthdate, ' ', -1), 4, '0') AS altbirthyear, altbirthplace, people.gedcom AS gedcom, treename ";
$query .= "FROM $people_table people, $trees_table trees WHERE people.gedcom = trees.gedcom ";
if ($tree) $query .= "AND people.gedcom = '$tree' ";

if ($change_cutoff) {
    $query .= "AND TO_DAYS(NOW()) - TO_DAYS(changedate) <= $change_cutoff ";
}
$livingPrivateRestrictions = getLivingPrivateRestrictions("p", false, false);
if ($livingPrivateRestrictions) {
    $query .= "AND " . $livingPrivateRestrictions . " ";
}
$query .= "ORDER BY changedate DESC, lastname, firstname, birthyear, altbirthyear ";
$query .= "LIMIT $change_limit";
$result = tng_query($query);
$people = tng_fetch_all($result);
tng_free_result($result);
if (count($people)) {
    ?>
    <div class="md:mx-4 md:rounded-lg titlebox">
        <h3 class="subhead"><?php echo $text['people']; ?></h3>
        <table class='w-11/12 mx-auto whiteback normal'>
            <thead>
            <tr>
                <th class="p-2 fieldnameback idcol fieldname"><?php echo ucfirst($text['person']); ?></th>
                <th class="p-2 whitespace-no-wrap fieldnameback fieldname"><?php echo $nametitle; ?></th>
                <th class="p-2 fieldnameback fieldname"><?php echo($tngconfig['hidechr'] ? $text['born'] : $text['bornchr']); ?></th>
                <?php if ($numtrees > 1) { ?>
                    <th class="p-2 whitespace-no-wrap fieldnameback fieldname"><?php echo $text['tree']; ?><?php if ($numbranches) {
                            echo " | " . $text['branch'];
                        } ?></th>
                <?php } ?>
                <th class="hidden p-2 lg:table-cell fieldnameback fieldname"><?php echo $text['lastmodified']; ?></th>
            </tr>
            </thead>
            <?php
            $personIcon = buildSvgElement("img/person.svg", ["class" => "mx-1 w-4 h-4 fill-current inline-block"]);
            $diagram2RightIcon = buildSvgElement("img/diagram-2-right.svg", ["class" => "mx-1 w-4 h-4 fill-current inline-block"]);
            foreach ($people as $row) {
                $rights = determineLivingPrivateRights($row);
                $row['allow_living'] = $rights['living'];
                $row['allow_private'] = $rights['private'];
                $namestr = getNameRev($row);
                $birthplacestr = "";
                [$birthdate, $birthplace] = getBirthInformation($rights['both'], $row);
                if ($birthplace) {
                    $birthplacestr = $birthplace . " <a href=\"placesearch.php?";
                    if (!$tngconfig['places1tree']) {
                        $birthplacestr .= "tree={$row['gedcom']}&amp;";
                    }
                    $icon = buildSvgElement("img/search.svg", ["class" => "w-3 h-3 fill-current inline-block"]);
                    $birthplacestr .= "psearch=" . urlencode($birthplace) . "\">$icon</a>";
                }
                echo "<tr>\n";
                echo "<td class='p-2 text-center databack'>";
                echo "<a href=\"pedigree.php?personID={$row['personID']}&amp;tree={$row['gedcom']}\">$diagram2RightIcon</a>";
                echo "<a href=\"getperson.php?personID={$row['personID']}&amp;tree={$row['gedcom']}\" class='pers' id=\"p{$row['personID']}_t{$row['gedcom']}\">$personIcon</a>";
                echo "<div class='person-img' id=\"mi{$row['gedcom']}_{$row['personID']}\">\n";
                echo "<div class='person-prev' id=\"prev{$row['gedcom']}_{$row['personID']}\"></div>\n";
                echo "</div>\n";
                echo "</td>\n";
                echo "<td class='p-2 databack'>$namestr</td>\n";
                echo "<td class='p-2 databack'>$birthdate<br>$birthplacestr</td>";
                if ($numtrees > 1) {
                    echo "<td class='p-2 databack'><a href=\"showtree.php?tree={$row['gedcom']}\">{$row['treename']}</a></td>";
                }
                $changedby = $row['changedby'];
                $changedbydesc = isset($userlist[$changedby]) ? $userlist[$changedby] : $changedby;
                echo "<td class='hidden p-2 whitespace-no-wrap lg:table-cell databack'>" . displayDate($row['changedatef']) . ($currentuser ? " ({$changedbydesc})" : "") . "</td>\n";
                echo "</tr>\n";
            }
            ?>
        </table>
    </div>
    <br>
    <?php
}

//select husband, wife from families where date later than cutoff, order by changedate descending, limit = 10
$query = "SELECT familyID, husband, wife, marrdate, families.gedcom AS gedcom, families.living AS fliving, families.private AS fprivate, families.branch AS fbranch, DATE_FORMAT(families.changedate,'%e %b %Y') AS changedatef, families.changedby, treename, hpeople.firstname AS hfirstname, hpeople.lnprefix AS hlnprefix, hpeople.lastname AS hlastname, hpeople.prefix AS hprefix, hpeople.suffix AS hsuffix, hpeople.nameorder AS hnameorder, hpeople.living AS hliving, hpeople.private AS hprivate, hpeople.branch AS hbranch, wpeople.firstname AS wfirstname, wpeople.lnprefix AS wlnprefix, wpeople.lastname AS wlastname, wpeople.prefix AS wprefix, wpeople.suffix AS wsuffix, wpeople.nameorder AS wnameorder, wpeople.living AS wliving, wpeople.private AS wprivate, wpeople.branch AS wbranch ";
$query .= "FROM ($families_table families, $trees_table trees) ";
$query .= "LEFT JOIN $people_table hpeople ON hpeople.gedcom = families.gedcom AND hpeople.personID = husband ";
$query .= "LEFT JOIN $people_table wpeople ON wpeople.gedcom = families.gedcom AND wpeople.personID = wife ";
$query .= "WHERE families.gedcom = trees.gedcom ";
if ($tree) $query .= "AND families.gedcom = '$tree' ";

if ($change_cutoff) {
    $query .= "AND TO_DAYS(NOW()) - TO_DAYS(families.changedate) <= $change_cutoff ";
}
$livingPrivateRestrictions = getLivingPrivateRestrictions($families_table, false, false);
if ($livingPrivateRestrictions) {
    $query .= "AND " . $livingPrivateRestrictions . " ";
}
$query .= "ORDER BY families.changedate DESC, hlastname, wlastname ";
$query .= "LIMIT $change_limit";
$result = tng_query($query);
$families = tng_fetch_all($result);
tng_free_result($result);
if (count($families)) {
    ?>
    <div class="md:mx-4 md:rounded-lg titlebox">
        <h3 class="subhead"><?php echo $text['families']; ?></h3>
        <table class='w-11/12 mx-auto rounded-lg whiteback normal'>
            <thead>
            <tr>
                <th class="p-2 fieldnameback nbrcol fieldname"><?php echo $text['family']; ?></th>
                <th class="p-2 whitespace-no-wrap fieldnameback fieldname"><?php echo $text['husbname']; ?></th>
                <th class="p-2 whitespace-no-wrap fieldnameback fieldname"><?php echo $text['wifename']; ?></th>
                <th class="p-2 fieldnameback fieldname"><?php echo $text['married']; ?></th>
                <?php if ($numtrees > 1) { ?>
                    <th class="p-2 fieldnameback fieldname"><?php echo $text['tree']; ?><?php if ($numbranches) {
                            echo " | " . $text['branch'];
                        } ?>
                    </th>
                <?php } ?>
                <th class="hidden p-2 md:w-32 md:table-cell fieldnameback fieldname"><?php echo $text['lastmodified']; ?></th>
            </tr>
            </thead>

            <?php
            $peopleIcon = buildSvgElement("img/people.svg", ["class" => "w-4 h-4 fill-current inline-block"]);
            foreach ($families as $row) {
                $row['living'] = $row['hliving'];
                $row['private'] = $row['hprivate'];
                $row['firstname'] = $row['hfirstname'];
                $row['lnprefix'] = $row['hlnprefix'];
                $row['lastname'] = $row['hlastname'];
                $row['prefix'] = $row['hprefix'];
                $row['suffix'] = $row['hsuffix'];
                $row['nameorder'] = $row['hnameorder'];
                $rights = determineLivingPrivateRights($row);
                $row['allow_living'] = $rights['living'];
                $row['allow_private'] = $rights['private'];
                $hname = getName($row);

                $row['living'] = $row['wliving'];
                $row['private'] = $row['wprivate'];
                $row['firstname'] = $row['wfirstname'];
                $row['lnprefix'] = $row['wlnprefix'];
                $row['lastname'] = $row['wlastname'];
                $row['prefix'] = $row['wprefix'];
                $row['suffix'] = $row['wsuffix'];
                $row['nameorder'] = $row['wnameorder'];
                $rights = determineLivingPrivateRights($row);
                $row['allow_living'] = $rights['living'];
                $row['allow_private'] = $rights['private'];
                $wname = getName($row);
                echo "<tr>\n";
                echo "<td class='p-2 text-center databack'>\n";
                echo "<a href=\"familygroup.php?familyID={$row['familyID']}&amp;tree={$row['gedcom']}\" class='fam' id=\"f{$row['familyID']}_t{$row['gedcom']}\">$peopleIcon</a>\n";
                echo "<div class='person-img' id=\"mi{$row['gedcom']}_{$row['familyID']}\">\n";
                echo "<div class='person-prev' id=\"prev{$row['gedcom']}_{$row['familyID']}\"></div>\n";
                echo "</div>\n";
                echo "</td>";
                echo "<td class='p-2 databack'><a href=\"getperson.php?personID={$row['husband']}&amp;tree={$row['gedcom']}\">$hname</a></td>\n";
                echo "<td class='p-2 databack'><a href=\"getperson.php?personID={$row['wife']}&amp;tree={$row['gedcom']}\">$wname</a></td>\n";
                echo "<td class='p-2 databack'>";
                if ($rights['both']) {
                    $row['branch'] = $row['fbranch'];
                    $row['living'] = $row['fliving'];
                    $row['private'] = $row['fprivate'];
                    $rights = determineLivingPrivateRights($row);
                    $row['allow_living'] = $rights['living'];
                    $row['allow_private'] = $rights['private'];
                    if ($rights['both']) echo displayDate($row['marrdate']);
                }
                echo "</td>\n";
                if ($numtrees > 1) {
                    echo "<td class='p-2 databack'><a href=\"showtree.php?tree={$row['gedcom']}\">{$row['treename']}</a></td>";
                }
                $changedby = $row['changedby'];
                $changedbydesc = isset($userlist[$changedby]) ? $userlist[$changedby] : $changedby;
                echo "<td class='hidden p-2 whitespace-no-wrap md:table-cell databack'>" . displayDate($row['changedatef']) . ($currentuser ? " ({$changedbydesc})" : "") . "</td></tr>\n";
            }
            ?>
        </table>
    </div>
    <br><br>
<?php } ?>
    <script src="js/search.js"></script>
<?php tng_footer($flags); ?>
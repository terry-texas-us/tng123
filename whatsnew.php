<?php

$textpart = "whatsnew";
include "tng_begin.php";

include "functions.php";

require_once "./public/people.php";

$_SESSION['tng_mediatree'] = $tree;
$_SESSION['tng_mediasearch'] = "";

$flags['imgprev'] = true;

if (!$change_cutoff) {
    $change_cutoff = 0;
}
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

$flags['style'] = "<style>\n";
$flags['style'] .= "table {width: 100%; border-collapse: separate; border-spacing: 1px;}\n";
$flags['style'] .= "table th, table td {padding: 3px;}\n";
$flags['style'] .= "</style>\n";

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

tng_header($text['whatsnew'] . " " . $pastxdays, $flags);

//get all users, username + description
//put in assoc table
//pass to media functions
//do lookups in each area
//set $currentuser = "" if only 1

$query = "SELECT username, description FROM $users_table WHERE allow_living != '-1' AND (allow_edit = '1' OR allow_add = '1')";
$result = tng_query($query);
$userlist = array();
if (tng_num_rows($result) == 1) {
    $currentuser = "";
}
if ($currentuser) {
    while ($row = tng_fetch_assoc($result)) {
        if ($row['description']) {
            $key = $row['username'];
            $userlist[$key] = $row['description'];
        }
    }
}
tng_free_result($result);
?>
<?php if ($sitever != "mobile") { ?>
    <script src="js/search.js"></script>
    <script>
        // <![CDATA[
        const ajx_perspreview = 'ajx_perspreview.php';
        const ajx_fampreview = 'ajx_fampreview.php';
        // ]]>
    </script>
<?php } ?>
    <h2 class="header"><span class="headericon" id="whatsnew-hdr-icon"></span><?php echo $text['whatsnew'] . " " . $pastxdays; ?></h2>
    <br>
<?php
$numtrees = 0;
echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'whatsnew', 'method' => 'get', 'name' => 'form1', 'id' => 'form1', 'lastimport' => true]);

$nametitle = $sitever == "mobile" ? $text['name'] : $text['lastfirst'];

if ($sitever != "standard") {
    if ($tabletype == "toggle") {
        $tabletype = "columntoggle";
    }
    $tableStartTag = "<table class = 'tablesaw whiteback normal' data-tablesaw-mode = '$tabletype'";
    if ($enableminimap) {
        $tableStartTag .= " data-tablesaw-minimap";
    }
    if ($enablemodeswitch) {
        $tableStartTag .= " data-tablesaw-mode-switch";
    }
    $tableStartTag .= ">";
} else {
    $tableStartTag = "<table class = 'whiteback normal'>";
}
$header1 = $tableStartTag;

$header1 .= "<thead>";
$header1 .= "<tr>\n";
$header1 .= "<th data-tablesaw-priority = 'persist' class = 'fieldnameback center thumbnails fieldname'>&nbsp;{$text['thumb']}&nbsp;</th>\n";
$header1 .= "<th data-tablesaw-priority = '1' class = 'fieldnameback fieldname'>&nbsp;{$text['description']}&nbsp;</th>\n";
$hsheader = "<th data-tablesaw-priority = '2' class = 'fieldnameback fieldname'>&nbsp;{$text['cemetery']}&nbsp;</th>\n";
$hsheader .= "<th data-tablesaw-priority = '3' class = 'fieldnameback fieldname'>&nbsp;{$text['status']}&nbsp;</th>\n";
$header2 .= "<th data-tablesaw-priority = '5' class= 'fieldnameback fieldname'>&nbsp;{$text['indlinked']}&nbsp;</th>\n";
$header2 .= "<th  data-tablesaw-priority = '5' class = 'fieldnameback fieldname' width = '130'>&nbsp;<b>{$text['lastmodified']}</b>&nbsp;</th>\n";
$header2 .= "</tr>\n";
$header2 .= "</thead>\n";
$footer = "</table>\n";

if ($tree) {
    $wherestr = "($media_table.gedcom = \"$tree\" || $media_table.gedcom = \"\") AND ";
    $wherestr2 = " AND $medialinks_table.gedcom = \"$tree\"";
} else {
    $wherestr = $wherestr2 = "";
}

if (!$change_limit) {
    $change_limit = 10;
}
//check for custom message
$file = $rootpath . "whatsnew.txt";
if (file_exists($file)) {
    $contents = file($file);
    foreach ($contents as $line) {
        if (trim($line)) {
            echo "<p>$line</p>";
        }
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
if ($tree) {
    $query .= "AND people.gedcom = '$tree' ";
}
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
if (tng_num_rows($result)) {
    ?>
    <div class="titlebox">
        <h3 class="subhead"><?php echo $text['individuals']; ?></h3>
        <?php echo $tableStartTag; ?>
        <thead>
        <tr>
            <th data-tablesaw-priority="persist" class="fieldnameback idcol fieldname"><?php echo $text['id']; ?></th>
            <th data-tablesaw-priority="1" class="fieldnameback fieldname"><?php echo $nametitle; ?></th>
            <th data-tablesaw-priority="2" class="fieldnameback fieldname"><?php echo($tngconfig['hidechr'] ? $text['born'] : $text['bornchr']); ?></th>
            <th data-tablesaw-priority="3" class="fieldnameback fieldname"><?php echo $text['location']; ?></th>
            <?php if ($numtrees > 1) { ?>
                <th data-tablesaw-priority="3" class="fieldnameback fieldname"><b><?php echo $text['tree']; ?><?php if ($numbranches) {
                            echo " | " . $text['branch'];
                        } ?></b>
                </th>
            <?php } ?>
            <th data-tablesaw-priority="5" class="fieldnameback fieldname" width="130"><?php echo $text['lastmodified']; ?></th>
        </tr>
        </thead>

        <?php
        $imageSize = @GetImageSize("img/Chart.gif");
        $chartlink = "<img src=\"img/Chart.gif\" alt=\"\" $imageSize[3]>";
        while ($row = tng_fetch_assoc($result)) {
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
                $birthplacestr .= "psearch=" . urlencode($birthplace) . "\"><img src=\"img/tng_search_small.gif\" alt=\"\" width=\"9\" height=\"9\"></a>";
            }
            echo "<tr>\n";
            echo "<td class='databack'><a href=\"getperson.php?personID={$row['personID']}&amp;tree={$row['gedcom']}\">{$row['personID']}</a></td>\n";
            echo "<td class='databack'>\n";
            if ($sitever != "mobile") {
                echo "<div class=\"person-img\" id=\"mi{$row['gedcom']}_{$row['personID']}\">\n";
                echo "<div class=\"person-prev\" id=\"prev{$row['gedcom']}_{$row['personID']}\"></div>\n";
                echo "</div>\n";
            }
            echo "<a href=\"pedigree.php?personID={$row['personID']}&amp;tree={$row['gedcom']}\">$chartlink</a> <a href=\"getperson.php?personID={$row['personID']}&amp;tree={$row['gedcom']}\" class=\"pers\" id=\"p{$row['personID']}_t{$row['gedcom']}\">$namestr</a>&nbsp;</td>\n";
            echo "<td class='databack nw'>$birthdate&nbsp;</td>";
            echo "<td class='databack'>&nbsp;$birthplacestr&nbsp;</td>";
            if ($numtrees > 1) {
                echo "<td class='databack'><a href=\"showtree.php?tree={$row['gedcom']}\">{$row['treename']}</a>&nbsp;</td>";
            }
            $changedby = $row['changedby'];
            $changedbydesc = isset($userlist[$changedby]) ? $userlist[$changedby] : $changedby;
            echo "<td class='databack nw'>" . displayDate($row['changedatef']) . ($currentuser ? " ({$changedbydesc})" : "") . "</td>\n";
            echo "</tr>\n";
        }
        tng_free_result($result);
        echo "</table>\n";
        ?>
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
if ($tree) {
    $query .= "AND families.gedcom = '$tree' ";
}
if ($change_cutoff) {
    $query .= "AND TO_DAYS(NOW()) - TO_DAYS(families.changedate) <= $change_cutoff ";
}
$livingPrivateRestrictions = getLivingPrivateRestrictions($families_table, false, false);
if ($livingPrivateRestrictions) {
    $query .= "AND " . $livingPrivateRestrictions . " ";
}
$query .= "ORDER BY families.changedate DESC, hlastname, wlastname ";
$query .= "LIMIT $change_limit";
$famresult = tng_query($query);
if (tng_num_rows($famresult)) {
    ?>
    <div class="titlebox">
        <h3 class="subhead"><?php echo $text['families']; ?></h3>
        <?php echo $tableStartTag; ?>
        <thead>
        <tr>
            <th data-tablesaw-priority="persist" class="fieldnameback nbrcol fieldname"><?php echo $text['id']; ?></th>
            <th data-tablesaw-priority="4" class="fieldnameback fieldname"><?php echo $text['husbid']; ?></th>
            <th data-tablesaw-priority="1" class="fieldnameback fieldname"><?php echo $text['husbname']; ?></th>
            <th data-tablesaw-priority="5" class="fieldnameback fieldname"><?php echo $text['wifeid']; ?></th>
            <th data-tablesaw-priority="1" class="fieldnameback fieldname"><?php echo $text['wifename']; ?></th>
            <th data-tablesaw-priority="2" class="fieldnameback fieldname"><?php echo $text['married']; ?></th>
            <?php if ($numtrees > 1) { ?>
                <th data-tablesaw-priority="3" class="fieldnameback fieldname"><?php echo $text['tree']; ?><?php if ($numbranches) {
                        echo " | " . $text['branch'];
                    } ?>
                </th>
            <?php } ?>
            <th data-tablesaw-priority="6" class="fieldnameback fieldname" width="130">&nbsp;<?php echo $text['lastmodified']; ?>&nbsp;</th>
        </tr>
        </thead>

        <?php
        while ($row = tng_fetch_assoc($famresult)) {
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
            echo "<td class='databack'>\n";
            echo "<a href=\"familygroup.php?familyID={$row['familyID']}&amp;tree={$row['gedcom']}\" class=\"fam\" id=\"f{$row['familyID']}_t{$row['gedcom']}\">{$row['familyID']}</a>\n";
            if ($sitever != "mobile") {
                echo "<div class=\"person-img\" id=\"mi{$row['gedcom']}_{$row['familyID']}\">\n";
                echo "<div class=\"person-prev\" id=\"prev{$row['gedcom']}_{$row['familyID']}\"></div>\n";
                echo "</div>\n";
            }
            echo "</td>";
            echo "</span></td><td class='databack'><a href=\"getperson.php?personID={$row['husband']}&amp;tree={$row['gedcom']}\">{$row['husband']}</a></td>\n";
            echo "<td class='databack'><a href=\"getperson.php?personID={$row['husband']}&amp;tree={$row['gedcom']}\">$hname</a>&nbsp;</td>\n";
            echo "<td class='databack'><a href=\"getperson.php?personID={$row['wife']}&amp;tree={$row['gedcom']}\">{$row['wife']}</a>&nbsp;</td>\n";
            echo "<td class='databack'><a href=\"getperson.php?personID={$row['wife']}&amp;tree={$row['gedcom']}\">$wname</a>&nbsp;</td>\n";
            echo "<td class='databack'>";
            if ($rights['both']) {
                $row['branch'] = $row['fbranch'];
                $row['living'] = $row['fliving'];
                $row['private'] = $row['fprivate'];
                $rights = determineLivingPrivateRights($row);
                $row['allow_living'] = $rights['living'];
                $row['allow_private'] = $rights['private'];
                if ($rights['both']) {
                    echo displayDate($row['marrdate']);
                }
            }
            echo "&nbsp;</td>\n";
            if ($numtrees > 1) {
                echo "<td class='databack'><a href=\"showtree.php?tree={$row['gedcom']}\">{$row['treename']}</a>&nbsp;</td>";
            }
            $changedby = $row['changedby'];
            $changedbydesc = isset($userlist[$changedby]) ? $userlist[$changedby] : $changedby;
            echo "<td class='databack nw'>" . displayDate($row['changedatef']) . ($currentuser ? " ({$changedbydesc})" : "") . "</td></tr>\n";
        }
        tng_free_result($famresult);
        echo "</table>\n";
        ?>
    </div>
    <br><br>
    <?php
}
tng_footer($flags);
?>
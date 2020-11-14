<?php
include "begin.php";
include "adminlib.php";
require_once "./admin/trees.php";

$textpart = "branches";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
require "adminlog.php";
require "deletelib.php";

if ($assignedbranch) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

@set_time_limit(0);
$husbgender = [];
$husbgender['self'] = "husband";
$husbgender['spouse'] = "wife";
$husbgender['spouseorder'] = "husborder";
$wifegender = [];
$wifegender['self'] = "wife";
$wifegender['spouse'] = "husband";
$wifegender['spouseorder'] = "wifeorder";

$treerow = getTree($trees_table, $tree);

$counter = $fcounter = 0;
$done = $fdone = [];
$names = $famnames = "";

function getGender($personID) {
    global $tree, $people_table, $husbgender, $wifegender;

    $info = [];
    $query = "SELECT firstname, lastname, sex FROM $people_table WHERE personID = \"$personID\" AND gedcom = '$tree'";
    $result = tng_query($query);
    if ($result) {
        $row = tng_fetch_assoc($result);
        if ($row['sex'] == "M") {
            $info = $husbgender;
        } else {
            if ($row['sex'] == "F") {
                $info = $wifegender;
            } else {
                $info['spouse'] = "";
                $info['self'] = "";
                $info['spouseorder'] = "";
            }
        }
        $info['firstname'] = $row['firstname'];
        $info['lastname'] = $row['lastname'];
        tng_free_result($result);
    }
    return $info;
}

function clearBranch($table, $branch) {
    global $tree;

    $query = "UPDATE $table SET branch=\"\" WHERE gedcom = '$tree' AND branch = '$branch'";
    tng_query($query);
    $counter = tng_affected_rows();

    $query = "SELECT branch, ID FROM $table WHERE gedcom='$tree' AND branch LIKE \"%$branch%\"";
    $result = tng_query($query);
    while ($row = tng_fetch_assoc($result)) {
        $oldbranch = trim($row['branch']);

        $newbranch = "";
        $oldbranches = explode(",", $oldbranch);
        foreach ($oldbranches as $tempbranch) {
            if ($tempbranch != $branch) {
                $newbranch .= $newbranch ? ",$tempbranch" : $tempbranch;
            }
        }
        $query = "UPDATE $table SET branch=\"$newbranch\" WHERE ID=\"{$row['ID']}\"";
        tng_query($query);
        $counter++;
    }
    tng_free_result($result);

    return $counter;
}

function deleteBranch($table, $branch) {
    global $tree, $people_table, $children_table;

    $counter = 0;
    if ($table == $people_table) {
        $query = "SELECT ID, personID, branch, sex FROM $table WHERE gedcom='$tree' AND branch LIKE \"%$branch%\"";
        $result = tng_query($query);
        while ($row = tng_fetch_assoc($result)) {
            $branches = explode(",", trim($row['branch']));
            if (in_array($branch, $branches)) {
                deletePersonPlus($row['personID'], $tree, $row['sex']);
                $query = "DELETE FROM $table WHERE ID=\"{$row['ID']}\"";
                tng_query($query);
                $counter++;
            }
        }
        tng_free_result($result);
    } else {
        $query = "SELECT ID, familyID, branch FROM $table WHERE gedcom='$tree' AND branch LIKE \"%$branch%\"";
        $result = tng_query($query);
        while ($row = tng_fetch_assoc($result)) {
            $branches = explode(",", trim($row['branch']));
            if (in_array($branch, $branches)) {
                $familyID = $row['familyID'];
                $query = "DELETE FROM $children_table WHERE ID='$familyID' AND gedcom = '$tree'";
                @tng_query($query);
                $query = "UPDATE $people_table SET famc=\"\" WHERE famc = '$familyID' AND gedcom = '$tree'";
                tng_query($query);

                deleteEvents($familyID, $tree);
                deleteCitations($familyID, $tree);
                deleteNoteLinks($familyID, $tree);
                deleteBranchLinks($familyID, $tree);
                deleteMediaLinks($familyID, $tree);
                deleteAlbumLinks($familyID, $tree);
                $query = "DELETE FROM $table WHERE ID=\"{$row['ID']}\"";
                tng_query($query);
                $counter++;
            }
        }
        tng_free_result($result);
    }

    return $counter;
}

function setPersonLabel($personID) {
    global $tree, $people_table, $branch, $branchlinks_table, $overwrite, $branchaction, $done, $names;

    if ($personID) {
        $row = "";
        if ($branchaction == "delete") {
            $query = "SELECT firstname, lastname, lnprefix, nameorder, living, private, suffix, title, sex FROM $people_table WHERE personID='$personID' AND gedcom = '$tree'";
            $result = @tng_query($query);
            $row = tng_fetch_assoc($result);
            tng_free_result($result);
            $query = "DELETE FROM $people_table WHERE personID = \"$personID\" AND gedcom = '$tree'";
            tng_query($query);

            //also delete children, events, medialinks, citations, notes, other family references
            deletePersonPlus($personID, $tree, $row['sex']);
            doICounter();
        } elseif (!in_array($personID, $done)) {
            $query = "SELECT firstname, lastname, lnprefix, nameorder, living, private, suffix, title, branch FROM $people_table WHERE personID = \"$personID\" AND gedcom = '$tree'";
            $result = tng_query($query);
            $row = tng_fetch_assoc($result);
            tng_free_result($result);

            if ($branch && ($overwrite != 1 || $branchaction == "clear")) { //append or leave
                //appending, so get current value first
                $oldbranch = trim($row['branch']);
                if ($oldbranch && ($overwrite == 2 || $branchaction == "clear")) {
                    $oldbranches = explode(",", $oldbranch);
                    if ($overwrite == 2) {
                        if (!in_array($branch, $oldbranches)) {
                            $newbranch = "$oldbranch,$branch";
                        } else {
                            $newbranch = $oldbranch;
                        }
                    } else { //clearing this branch
                        foreach ($oldbranches as $tempbranch) {
                            if ($tempbranch != $branch) {
                                $newbranch .= $newbranch ? ",$tempbranch" : $tempbranch;
                            }
                        }
                    }
                } else {
                    $newbranch = $branch;
                }
            } else {
                $newbranch = $branch;
                $oldbranch = "";
            }

            if ($overwrite || !$oldbranch) {
                $query = "UPDATE $people_table SET branch = \"$newbranch\" WHERE personID = \"$personID\" AND gedcom = '$tree'";
                tng_query($query);
                doICounter();
            }
            array_push($done, $personID);
        }
        if ($row) {
            $rights = determineLivingPrivateRights($row, true, true);
            $row['allow_living'] = $rights['living'];
            $row['allow_private'] = $rights['private'];
            $names .= "<a href=\"admin_editperson.php?personID={$personID}&amp;tree=$tree&amp;cw=1\" target='_blank'>" . getName($row) . " ($personID)</a><br>\n";
        }

        if ($branchaction == "clear" || $branchaction == "delete") {
            $query = "DELETE FROM $branchlinks_table WHERE persfamID = \"$personID\" AND gedcom = '$tree' AND branch = '$branch'";
            tng_query($query);
        } else {
            if ($overwrite == 1 || !$branch) {
                $query = "DELETE FROM $branchlinks_table WHERE persfamID = \"$personID\" AND gedcom = '$tree'";
                tng_query($query);
            }
            if ($branch) {
                $query = "INSERT IGNORE INTO $branchlinks_table (branch,gedcom,persfamID) VALUES('$branch','$tree',\"$personID\")";
                tng_query($query);
            }
        }
    }
}

function doICounter() {
    global $counter;

    $counter++;
}

function doFCounter() {
    global $fcounter;

    $fcounter++;
}

function setFamilyLabel($personID, $gender) {
    global $tree, $families_table, $branch, $overwrite, $branchlinks_table, $branchaction, $people_table, $fdone, $famnames, $children_table;

    if ($gender['self']) {
        $query = "SELECT branch, familyID, husband, wife, gedcom, living, private FROM $families_table WHERE {$gender['self']} = \"$personID\" AND gedcom = '$tree'";
        $result = tng_query($query);
        while ($row = tng_fetch_assoc($result)) {
            $oldbranch = trim($row['branch']);
            if (!in_array($row['familyID'], $fdone)) {
                $famnames .= "<a href=\"admin_editfamily.php?familyID={$row['familyID']}&amp;tree={$row['gedcom']}&amp;cw=1\" target='_blank'>" . getFamilyName($row) . "</a><br>\n";
            }
            if ($branchaction == "delete") {
                $familyID = $row['familyID'];
                $query = "DELETE FROM $families_table WHERE familyID = '$familyID' AND gedcom = '$tree'";
                tng_query($query);
                $query = "UPDATE $people_table SET famc=\"\" WHERE famc = '$familyID' AND gedcom = '$tree'";
                tng_query($query);

                //also delete children, events, medialinks, citations, notes
                $query = "DELETE FROM $children_table WHERE ID='$familyID' AND gedcom = '$tree'";
                @tng_query($query);

                deleteEvents($familyID, $tree);
                deleteCitations($familyID, $tree);
                deleteNoteLinks($familyID, $tree);
                deleteBranchLinks($familyID, $tree);
                deleteMediaLinks($familyID, $tree);
                deleteAlbumLinks($familyID, $tree);
                doFCounter();
            } elseif (!in_array($row['familyID'], $fdone)) {
                if ($branch && $oldbranch && ($overwrite == 2 || $branchaction == "clear")) {
                    $oldbranches = explode(",", $oldbranch);
                    if ($overwrite == 2) {
                        if (!in_array($branch, $oldbranches)) {
                            $newbranch = "$oldbranch,$branch";
                        } else {
                            $newbranch = $oldbranch;
                        }
                    } else { //clearing this branch
                        foreach ($oldbranches as $tempbranch) {
                            if ($tempbranch != $branch) {
                                $newbranch .= $newbranch ? ",$tempbranch" : $tempbranch;
                            }
                        }
                    }
                } else {
                    $newbranch = $branch;
                }

                if ($overwrite || !$oldbranch) {
                    $query = "UPDATE $families_table SET branch = \"$newbranch\" WHERE familyID = \"{$row['familyID']}\" AND gedcom = '$tree'";
                    tng_query($query);

                    doFCounter();
                }
                array_push($fdone, $row['familyID']);
            }

            if ($branchaction == "clear" || $branchaction == "delete") {
                $query = "DELETE FROM $branchlinks_table WHERE persfamID = \"{$row['familyID']}\" AND gedcom = '$tree' AND branch = '$branch'";
                tng_query($query);
            } else {
                if ($overwrite == 1 || !$branch) {
                    $query = "DELETE FROM $branchlinks_table WHERE persfamID = \"{$row['familyID']}\" AND gedcom = '$tree'";
                    tng_query($query);
                }
                if ($branch) {
                    $query = "INSERT IGNORE INTO $branchlinks_table (branch,gedcom,persfamID) VALUES('$branch','$tree',\"{$row['familyID']}\")";
                    tng_query($query);
                }
            }
        }
        tng_free_result($result);
    }
}

function setSpousesLabel($personID, $gender) {
    global $tree, $families_table;

    setFamilyLabel($personID, $gender);
    if ($gender['self']) {
        $query = "SELECT {$gender['spouse']}, familyID FROM $families_table WHERE {$gender['self']} = \"$personID\" AND gedcom = '$tree' ORDER BY {$gender['spouseorder']}";
        $spouseresult = tng_query($query);
        while ($spouserow = tng_fetch_assoc($spouseresult))
            setPersonLabel($spouserow[$gender['spouse']]);
    }
}

function doAncestors($personID, $gender, $gen) {
    global $dagens, $tree, $agens, $children_table, $families_table, $husbgender, $wifegender, $dospouses;

    setPersonLabel($personID);
    setFamilyLabel($personID, $gender);
    if ($dospouses) setSpousesLabel($personID, $gender);


    $spouses = [];
    if ($gen <= $agens) {
        $query = "SELECT $children_table.familyID AS familyID, husband, wife FROM ($children_table, $families_table) WHERE $children_table.familyID = $families_table.familyID AND personID = \"$personID\" AND $children_table.gedcom = '$tree' AND $families_table.gedcom = '$tree'";
        $familyresult = tng_query($query);

        while ($familyrow = tng_fetch_assoc($familyresult)) {
            if ($dagens) {
                $query = "SELECT personID FROM $children_table WHERE familyID = \"{$familyrow['familyID']}\" AND gedcom = '$tree' AND personID != \"$personID\"";
                $childresult = tng_query($query);
                while ($childrow = tng_fetch_assoc($childresult)) {
                    $newgender = getGender($childrow['personID']);
                    setPersonLabel($childrow['personID']);
                    setFamilyLabel($childrow['personID'], $newgender);
                    if ($dospouses) {
                        setSpousesLabel($childrow['personID'], $newgender);
                    }
                    doDescendants($childrow['personID'], $newgender, 1, $dagens);
                }
            }
            if ($familyrow['husband'] && !in_array($familyrow['husband'], $spouses)) {
                array_push($spouses, $familyrow['husband']);
                doAncestors($familyrow['husband'], $husbgender, $gen + 1);
            }
            if ($familyrow['wife'] && !in_array($familyrow['wife'], $spouses)) {
                array_push($spouses, $familyrow['wife']);
                doAncestors($familyrow['wife'], $wifegender, $gen + 1);
            }
        }
    }
}

function doDescendants($personID, $gender, $gen, $maxgen) {
    global $tree, $families_table, $children_table, $dospouses;

    if ($gender['spouseorder']) {
        $query = "SELECT familyID FROM $families_table WHERE {$gender['self']} = \"$personID\" AND gedcom = '$tree' ORDER BY {$gender['spouseorder']}";
    } else {
        $query = "SELECT familyID FROM $families_table WHERE gedcom = '$tree' AND (husband = \"$personID\" OR wife = \"$personID\")";
    }
    $spouseresult = tng_query($query);
    while ($spouserow = tng_fetch_assoc($spouseresult)) {
        //setPersonLabel( $spouserow[$gender['spouse']] );
        $query = "SELECT personID FROM $children_table WHERE familyID = \"{$spouserow['familyID']}\" AND gedcom = '$tree' ORDER BY ordernum";
        $childresult = tng_query($query);
        while ($childrow = tng_fetch_assoc($childresult)) {
            $newgender = getGender($childrow['personID']);
            setPersonLabel($childrow['personID']);
            setFamilyLabel($childrow['personID'], $newgender);
            if ($dospouses) {
                setSpousesLabel($childrow['personID'], $newgender);
            }
            if ($gen < $maxgen) {
                doDescendants($childrow['personID'], $newgender, $gen + 1, $maxgen);
            }
        }
        tng_free_result($childresult);
    }
    tng_free_result($spouseresult);
}

if ($branchaction == "clear") {
    $branchtitle = _('Clearing Branch Labels');
    $overwrite = 1;
} elseif ($branchaction == "delete") {
    $branchtitle = "DELETING BRANCH";
    $overwrite = 0;
} else {
    $branchtitle = _('Adding Branch Labels');
    $branchclause = $overwrite ? "" : " AND branch = \"\"";
}
header("Content-type:text/html; charset=" . $session_charset);
echo "<p><strong>$branchtitle</strong></p>";

if ($set == "all") {
    //all only works for deleting
    if ($branchaction == "clear") {
        $counter = clearBranch($people_table, $branch);
        $fcounter = clearBranch($families_table, $branch);
    } else {   //deleting
        $counter = deleteBranch($people_table, $branch);
        $fcounter = deleteBranch($families_table, $branch);
    }

    $query = "DELETE FROM $branchlinks_table WHERE gedcom = '$tree' AND branch = '$branch'";
    $result = tng_query($query);
} else {
    $gender = getGender($personID);
    if ($agens > 0) {
        doAncestors($personID, $gender, 1);
    } else {
        setPersonLabel($personID);
        setFamilyLabel($personID, $gender);
        if ($dospouses) setSpousesLabel($personID, $gender);

    }
    if ($dagens > $dgens) $dgens = $dagens;

    if ($dgens > 0) doDescendants($personID, $gender, 1, $dgens);

}
echo "<p class='normal'>" . _('Total Affected') . ": $counter " . _('People') . ", $fcounter " . _('Families') . ".</p>\n";
echo "<p class='normal'>$names</p>\n";
echo "<p class='normal'>$famnames</p>\n";

adminwritelog(_('Label Branches') . ": $tree/$branch ($branchaction/$set)");

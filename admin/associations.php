<?php

/**
 * @param string $id person or family to check
 * @param string $tree tree to check
 * @return string '*' if person has associations, else ''
 */
function checkForAssociations(string $id, string $tree): string {
    global $admtext, $assoc_table;

    $query = "SELECT count(assocID) as acount ";
    $query .= "FROM {$assoc_table} ";
    $query .= "WHERE personID = \"{$id}\" AND gedcom = \"{$tree}\"";
    $result = tng_query($query) or die ($admtext . ": $query");
    $row = tng_fetch_assoc($result);
    tng_free_result($result);
    return $row['acount'] ? "*" : "";
}

/**
 * @param $reltype
 * @param $passocID
 * @param array $tree
 * @return string
 */
function getPersonOrFamilyAssociatedName($reltype, $passocID, array $tree): string {
    global $people_table, $families_table;
    if ($reltype == "I") {
        $query = "SELECT firstname, lastname, lnprefix, nameorder, prefix, suffix ";
        $query .= "FROM {$people_table} ";
        $query .= "WHERE personID=\"$passocID\" AND gedcom=\"{$tree}\"";
        $result = tng_query($query);
        $row = tng_fetch_assoc($result);
        $righttree = checktree($tree);
        $rightbranch = $righttree ? checkbranch($row['branch']) : false;
        $rights = determineLivingPrivateRights($row, $righttree, $rightbranch);
        $row['allow_living'] = $rights['living'];
        $row['allow_private'] = $rights['private'];
        $name = getName($row) . " ($passocID)";
        tng_free_result($result);
    } else {
        $query = "SELECT husband, wife, gedcom, familyID ";
        $query .= "FROM {$families_table} ";
        $query .= "WHERE familyID=\"$passocID\" AND gedcom=\"{$tree}\"";
        $result = tng_query($query);
        $row = tng_fetch_assoc($result);
        $name = getFamilyName($row);
        tng_free_result($result);
    }
    return $name;
}


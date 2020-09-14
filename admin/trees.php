<?php

/**
 * @param $trees_table
 * @param $tree
 * @return array
 */
function getTree($trees_table, $tree): array {
    $query = "SELECT gedcom, treename FROM $trees_table WHERE gedcom = '$tree'";
    $treeresult = tng_query($query);
    $treerow = tng_fetch_assoc($treeresult);
    tng_free_result($treeresult);
    return $treerow;
}

/**
 * @param $assignedtree
 * @param $trees_table
 * @return array
 */
function getOrderedTreesList($assignedtree, $trees_table): array {
    global $admtext;

    $trees = [];
    $treenames = [];
    $tree = $assignedtree ?? "";

    $query = "SELECT gedcom, treename ";
    $query .= "FROM $trees_table ";
    if ($assignedtree) {
        $query .= "WHERE gedcom = '$assignedtree' ";
    }
    $query .= "ORDER BY treename";
    $result = tng_query($query) or die ($admtext . ": $query");
    $treenum = 0;
    while ($row = tng_fetch_assoc($result)) {
        $treenum++;
        $trees[$treenum] = $row['gedcom'];
        $treenames[$treenum] = $row['treename'];
    }
    tng_free_result($result);
    return [$tree, $trees, $treenames, $query];
}

/**
 * @param $assignedtree
 * @param $trees_table
 * @return array
 */
function getOrderedTreesList2($assignedtree, $trees_table): array {
    $trees = [];
    $treenames = [];

    $query = "SELECT gedcom, treename ";
    $query .= "FROM $trees_table ";
    if ($assignedtree) {
        $query .= "WHERE gedcom = '$assignedtree' ";
    }
    $query .= "ORDER BY treename";
    $result = tng_query($query);
    $numtrees = tng_num_rows($result);

    $treenum = 0;
    while ($row = tng_fetch_assoc($result)) {
        $trees[$treenum] = $row['gedcom'];
        $treenames[$treenum] = $row['treename'];
        $treenum++;
    }
    tng_free_result($result);
    return array($numtrees, $treenum, $trees, $treenames);
}

/**
 * Get list of trees, optionally omitting current tree formatted for html select options
 * @param string $trees_table
 * @param string $currentTree
 * @param bool $omitCurrentTree
 * @return array
 */
function getTreeOptions(string $trees_table, string $currentTree, bool $omitCurrentTree = true): array {
    $treelist = "<option value=\"\"></option>\n";
    $currentTreeName = "";

    $query = "SELECT gedcom, treename FROM $trees_table ORDER BY treename";
    $result = tng_query($query);

    while ($row = tng_fetch_assoc($result)) {
        if ($omitCurrentTree == false || $row['gedcom'] != $currentTree) {
            $treelist .= "<option value=\"{$row['gedcom']}\">{$row['treename']}</option>\n";
        } else {
            $currentTreeName = $row['treename'];
        }
    }
    return array($treelist, $currentTreeName);
}

/**
 * @param string $trees_table
 * @return string
 */
function getTreesCount(string $trees_table): string {
    $query = "SELECT count(gedcom) AS treesCount FROM $trees_table";
    $result = tng_query($query);
    $row = tng_fetch_assoc($result);
    tng_free_result($result);
    return $row['treesCount'];
}



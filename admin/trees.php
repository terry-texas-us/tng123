<?php

/**
 * @param $trees_table
 * @param $tree
 * @return array
 */
function getTree($trees_table, $tree) {
  $query = "SELECT treename FROM $trees_table WHERE gedcom = '$tree'";
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
function getOrderedTreesList($assignedtree, $trees_table) {
  global $admtext;

  if ($assignedtree) {
    $wherestr = "WHERE gedcom = '$assignedtree'";
    $tree = $assignedtree;
  } else {
    $wherestr = "";
    $tree = "";
  }
  $trees = array();
  $treename = array();

  $query = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";
  $result = tng_query($query) or die ($admtext . ": $query");
  $treenum = 0;
  while ($row = tng_fetch_assoc($result)) {
    $treenum++;
    $trees[$treenum] = $row['gedcom'];
    $treename[$treenum] = $row['treename'];
  }
  tng_free_result($result);
  return array($tree, $trees, $treename, $query);
}

/**
 * @param $assignedtree
 * @param $trees_table
 * @return array
 */
function getOrderedTreesList2($assignedtree, $trees_table) {
  if ($assignedtree) {
    $wherestr = "WHERE gedcom = \"$assignedtree\"";
  } else {
    $wherestr = "";
  }

  $query = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";
  $result = tng_query($query);
  $numtrees = tng_num_rows($result);

  $treenum = 0;
  $trees = array();
  $treename = array();
  while ($row = tng_fetch_assoc($result)) {
    $trees[$treenum] = $row['gedcom'];
    $treename[$treenum] = $row['treename'];
    $treenum++;
  }
  tng_free_result($result);
  return array($query, $numtrees, $treenum, $trees, $treename);
}


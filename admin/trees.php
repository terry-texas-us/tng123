<?php

/**
 * Class OrderedTreesList
 */
class OrderedTreesList
{
    private string $assignedTree;
    private string $query;
    private array $rows;

    /**
     * @param string $treesTable
     * @param string $assignedTree
     */
    public function __construct(string $treesTable, string $assignedTree) {
        global $admtext;

        $this->assignedTree = $assignedTree ?? "";

        $this->query = "SELECT gedcom, treename FROM $treesTable ";
        if ($assignedTree) {
            $this->query .= "WHERE gedcom = '$assignedTree' ";
        }
        $this->query .= "ORDER BY treename";

        $result = tng_query($this->query) or die ($admtext . ": $this->query");

        $this->rows = tng_fetch_all($result);
        tng_free_result($result);
    }

    /**
     * @return string
     */
    public function getAssignedTree() {
        return $this->assignedTree;
    }

    /**
     * @return string
     */
    public function getQuery() {
        return $this->query;
    }

    /**
     * @param string $gedcom initial option selected
     * @return string
     */
    public function getSelectOptionsHtml($gedcom = "") {
        $html = "";
        foreach ($this->rows as $row) {
            $html .= "<option value='{$row['gedcom']}'";

            if ($row['gedcom'] == $gedcom) {
                $html .= " selected";
            }
            $html .= ">{$row['treename']}</option>\n";
        }
        return $html;
    }
}

/**
 * @param $trees_table
 * @param $tree
 * @return array
 */
function getTree(string $trees_table, string $tree): array {
    $query = "SELECT gedcom, treename FROM $trees_table WHERE gedcom = '$tree'";
    $treeresult = tng_query($query);

    $treerow = tng_fetch_assoc($treeresult);
    tng_free_result($treeresult);
    return $treerow;
}

/**
 * @param string $trees_table
 * @return string
 */
function getTreesCount(string $trees_table): string {
    $query = "SELECT COUNT(gedcom) AS treesCount FROM $trees_table";
    $result = tng_query($query);
    $row = tng_fetch_assoc($result);
    tng_free_result($result);
    return $row['treesCount'];
}

/**
 * Get list of trees, optionally omitting current tree formatted for html select options
 * @param string $trees_table
 * @param string $currentTree
 * @param bool $omitCurrentTree
 * @return array
 */
function getTreesSelectOptionsHtml(string $trees_table, string $currentTree, bool $omitCurrentTree = true): array {
    $query = "SELECT gedcom, treename FROM $trees_table ORDER BY treename";
    $result = tng_query($query);

    $currentTreeName = "";
    $html = "<option value=''></option>\n";

    $rows = tng_fetch_all($result);
    foreach ($rows as $row) {
        if ($omitCurrentTree == false || $row['gedcom'] != $currentTree) {
            $html .= "<option value='{$row['gedcom']}'>{$row['treename']}</option>\n";
        } else {
            $currentTreeName = $row['treename'];
        }
    }
    tng_free_result($result);
    return [$html, $currentTreeName];
}

<?php

/*
	name_cloud - This class creates a "cloud" of names which represent the top n surnames
				 in the database (excluding empty names).
	Author:
		Roger Lee Navarre, based on code originally written by Wendel Voigt
*/

class surname_cloud
{

    public function __construct() {
    }

    /**
     * Generates html code to display the surname cloud
     *
     * @param string $top number of names to put in the cloud (default is 50 names)
     * @param string $surnameTree limit names from this tree (default is "" which means all trees)
     * @param string $surnameBranch limit names from this branch (default is "" which means all branches)
     * @return string
     */
    public function display($top = "50", $surnameTree = "", $surnameBranch = "") {
        global $people_table, $lnprefixes, $assignedtree;
        $treeBranchUrlString = "";

        // If you have surnames you wish to exclude enter them here
        $wherestr = "WHERE lastname<>\"\" AND lastname<>\"Unknown\"AND lastname<>'[--?--]'";  // Ignore these last names

        $more = getLivingPrivateRestrictions($people_table, false, false);

        if ($more) {
            $wherestr .= $wherestr ? " AND " . $more : "WHERE $more";
        }

        if ($assignedtree && $assignedtree != "-x-guest-x-") {
            $surnameTree = $assignedtree;
        }

        if ($surnameTree != "") {
            $treeString = "gedcom = \"" . $surnameTree . "\"";
            $wherestr .= $wherestr ? " AND " . $treeString : "WHERE " . $treeString;
            $treeBranchUrlString .= "&amp;tree=$surnameTree";
        }
        // Get all unique surnames
        $surnamestr = $lnprefixes ? "TRIM(CONCAT_WS(' ',lnprefix,lastname) )" : "lastname";
        $query = "SELECT UCASE(binary $surnamestr) AS surnameuc, $surnamestr AS surname, count(UCASE(binary lastname)) AS count, lastname ";
        $query .= "FROM $people_table ";
        $query .= "$wherestr ";
        $query .= "GROUP BY surname ";
        $query .= "ORDER by lastname";
        $result = tng_query($query) or die ("" . _('Cannot execute query') . ": $query");
        if (!$result) return "";
        // Fetch all surnames into an array
        $surnames = [];
        $idx = 0;
        while ($row = tng_fetch_array($result)) {
            $row['id'] = $idx++;  // Save $surnames index
            $row['selected'] = 0;  // Default to not selected
            $surnames[] = $row;
        }

        // Sort the names array by count
        $countArray = $surnames;
        $tempArray = [];
        foreach ($countArray as $key => $row) {
            $tempArray[$key] = $row['count'];
        }
        array_multisort($tempArray, SORT_DESC, $countArray);
        $tempArray[] = "";

        $SurnameMax = $countArray[0]['count']; // First record should have the most

        $arr_length = count($countArray);
        for ($i = 0, $num = 1; $i < $arr_length && $num <= $top; $i++, $num++) {
            $name = $countArray[$i];
            $idx = $name['id'];
            $surnames[$idx]['selected'] = 1;  // selected for output
            $surnames[$idx]['surnameuc'] = urlencode($surnames[$idx]['surnameuc']);

            // Assign a class to each surname based upon relative number to most used surname
            $percent = 100 * $name['count'] / $SurnameMax;
            if ($percent > 98) {
                $class = 1;
            } else {
                if ($percent > 70) {
                    $class = 2;
                } else {
                    if ($percent > 50) {
                        $class = 3;
                    } else {
                        if ($percent > 30) {
                            $class = 4;
                        } else {
                            if ($percent > 25) {
                                $class = 5;
                            } else {
                                if ($percent > 20) {
                                    $class = 6;
                                } else {
                                    if ($percent > 15) {
                                        $class = 7;
                                    } else {
                                        if ($percent > 10) {
                                            $class = 8;
                                        } else {
                                            if ($percent > 5) {
                                                $class = 9;
                                            } else {
                                                $class = 0;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $surnames[$idx]['class'] = $class;
        }

        // Clean up
        tng_free_result($result);

        // Note: the appearance of the names is controlled by class surnames-cloud which is defined in templatestyle.css
        $output = "<div class='surnames-cloud'>\n";
        foreach ($surnames as $name) {
            if ($name['selected'] == 1) {
                $surname2 = $name['surname'];
                $name['count'] = $name['count'] . ' ' . _('individuals');
                $output .= "<span class='surnames-cloud size" . $name['class'] . "'>";
                $output .= "<a class='surnames-cloud size" . $name['class'] . "' ";
                $output .= "href=\"search.php?mylastname=$surname2&amp;lnqualify=equals&amp;mybool=AND$treeBranchUrlString\" title=\"{$name['count']}\">";
                $output .= $name['surname'];
                $output .= "</a>";
                $output .= "</span>\n";
            }
        }
        $output .= "</div>";
        echo($output);
    }
}

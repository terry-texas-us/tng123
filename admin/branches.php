<?php

/**
 * @param string $branches_table
 * @param string $tree
 * @param array|null $row
 * @param string $assignedbranch
 * @return string $html
 */

function getBranchesSelectionHtml(string $branches_table, string $tree, ?array $row, string $assignedbranch): string {
    global $admtext;

    $query = "SELECT branch, description FROM {$branches_table} WHERE gedcom = \"{$tree}\" ORDER BY description";
    $branchresult = tng_query($query);
    $branchlist = explode(",", $row['branch']);

    $descriptions = [];
    $options = "";
    while ($branchrow = tng_fetch_assoc($branchresult)) {
        $options .= "	<option value=\"{$branchrow['branch']}\"";
        if (in_array($branchrow['branch'], $branchlist)) {
            $options .= " selected";
            $descriptions[] = $branchrow['description'];
        }
        $options .= ">{$branchrow['description']}</option>\n";
    }
    $desclist = count($descriptions) ? implode(', ', $descriptions) : $admtext['nobranch'];
    $html = "<span id=\"branchlist\">$desclist</span>";
    if (!$assignedbranch) {
        $totbranches = tng_num_rows($branchresult) + 1;
        if ($totbranches < 2) {
            $totbranches = 2;
        }
        $selectnum = $totbranches < 8 ? $totbranches : 8;
        $select = $totbranches >= 8 ? $admtext['scrollbranch'] . "<br>" : "";
        $select .= "<select name=\"branch[]\" id=\"branch\" multiple size=\"$selectnum\" style=\"overflow:auto\">\n";
        $select .= "	<option value=\"\"";
        if ($row == "") {
            $select .= " selected";
        }
        $select .= ">{$admtext['nobranch']}</option>\n";

        $select .= "$options</select>\n";
        $html .= " &nbsp;<span class=\"nw\">(<a href=\"#\" onclick=\"showBranchEdit('branchedit'); quitBranchEdit('branchedit'); return false;\"><img src=\"img/ArrowDown.gif\" style=\"margin-left:-4px;margin-right:-2px\">{$admtext['edit']}</a> )</span><br>";
        $html .= "<div id=\"branchedit\" class=\"lightback pad5\" style=\"position:absolute;display:none;\" onmouseover=\"clearTimeout(branchtimer);\" onmouseout=\"closeBranchEdit('branch','branchedit','branchlist');\">";
        $html .= $select;
        $html .= "</div>\n";
    } else {
        $html .= "<input type=\"hidden\" name=\"branch\" value=\"{$row}\">";
    }
    $html .= "<input type=\"hidden\" name=\"orgbranch\" value=\"{$row}\">";
    return $html;
}

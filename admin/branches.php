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

    $query = "SELECT branch, description FROM $branches_table WHERE gedcom = '$tree' ORDER BY description";
    $branchresult = tng_query($query);
    $branchlist = explode(",", $row['branch']);

    $descriptions = [];
    $options = "";
    while ($branchrow = tng_fetch_assoc($branchresult)) {
        $options .= "<option value=\"{$branchrow['branch']}\"";
        if (in_array($branchrow['branch'], $branchlist)) {
            $options .= " selected";
            $descriptions[] = $branchrow['description'];
        }
        $options .= ">{$branchrow['description']}</option>\n";
    }
    $desclist = count($descriptions) ? implode(', ', $descriptions) : _('No Branch');
    $html = "<span id=\"branchlist\">$desclist</span>";
    if (!$assignedbranch) {
        $totbranches = tng_num_rows($branchresult) + 1;
        if ($totbranches < 2) $totbranches = 2;
        $selectnum = $totbranches < 8 ? $totbranches : 8;
        $select = $totbranches >= 8 ? _('(Scroll to see all choices)') . "<br>" : "";
        $select .= "<select name=\"branch[]\" id='branch' multiple size=\"$selectnum\" style=\"overflow:auto;\">\n";
        $select .= "<option value=''";
        if ($row == "") $select .= " selected";
        $select .= ">" . _('No Branch') . "</option>\n";
        $select .= "$options</select>\n";
        $html .= " &nbsp;<span class='whitespace-no-wrap'>(<a href='#' onclick=\"showBranchEdit('branchedit'); quitBranchEdit('branchedit'); return false;\">";
        $html .= _('Edit');
        $html .= buildSvgElement("img/chevron-down.svg", ["class" => "w-3 h-3 ml-2 fill-current inline-block"]);
        $html .= "</a> )</span><br>";
        $html .= "<div id='branchedit' class='lightback p-1' style='position: absolute; display: none;' onmouseover=\"clearTimeout(branchtimer);\" onmouseout=\"closeBranchEdit('branch','branchedit','branchlist');\">";
        $html .= $select;
        $html .= "</div>\n";
    } else {
        $html .= "<input type='hidden' name='branch' value=\"{$row}\">";
    }
    $html .= "<input type='hidden' name=\"orgbranch\" value=\"{$row}\">";
    return $html;
}

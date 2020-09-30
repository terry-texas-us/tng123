<?php
$textpart = "sources";
include "tng_begin.php";
global $responsivetables, $tabletype, $enablemodeswitch, $enableminimap;

include "functions.php";

function doSourceSearch($instance, $pagenav) {
    global $text, $sourcesearch, $tree;

    $str = "<div class='normal'>\n";
    $str .= getFORM("browsesources", "get", "SourceSearch$instance", "");
    $str .= "<input type='text' name=\"sourcesearch\" value=\"$sourcesearch\"> <input type='submit' value=\"{$text['search']}\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $str .= $pagenav;
    $str .= "<input type='hidden' name=\"tree\" value='$tree'>\n";
    if ($sourcesearch) {
        $str .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='browsesources.php'>{$text['browseallsources']}</a>";
    }
    $str .= "</form></div>\n";

    return $str;
}

$max_browsesource_pages = 5;
if ($offset) {
    $offsetplus = $offset + 1;
    $newoffset = "$offset, ";
} else {
    $offsetplus = 1;
    $newoffset = "";
    $page = 1;
}

$sourcesearch = cleanIt(trim($sourcesearch));
if ($tree) {
    $wherestr = "WHERE $sources_table.gedcom = '$tree'";
    if ($sourcesearch) {
        $wherestr .= " AND (title LIKE \"%$sourcesearch%\" OR shorttitle LIKE \"%$sourcesearch%\" OR author LIKE \"%$sourcesearch%\")";
    }
    $join = "INNER JOIN";
} else {
    if ($sourcesearch) {
        $wherestr = "WHERE title LIKE \"%$sourcesearch%\" OR shorttitle LIKE \"%$sourcesearch%\" OR author LIKE \"%$sourcesearch%\"";
    } else {
        $wherestr = "";
    }
    $join = "LEFT JOIN";
}

$query = "SELECT sourceID, title, shorttitle, author, sources.gedcom AS gedcom, treename ";
$query .= "FROM $sources_table sources ";
$query .= "$join $trees_table trees ON sources.gedcom = trees.gedcom ";
$query .= "$wherestr ";
$query .= "ORDER BY title ";
$query .= "LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);

$numrows = tng_num_rows($result);

if ($numrows == $maxsearchresults || $offsetplus > 1) {

    $query = "SELECT count(sourceID) AS scount ";
    $query .= "FROM $sources_table sources ";
    if ($tree) {
        $query .= "LEFT JOIN $trees_table trees ON sources.gedcom = trees.gedcom ";
    }
    $query .= "$wherestr";
    $result2 = tng_query($query);
    $row = tng_fetch_assoc($result2);
    $totrows = $row['scount'];
} else {
    $totrows = $numrows;
}

$numrowsplus = $numrows + $offset;

$treestr = $tree ? " ({$text['tree']}: $tree)" : "";
$logstring = "<a href=\"browsesources.php?tree=$tree&amp;offset=$offset&amp;sourcesearch=$sourcesearch\">" . xmlcharacters($text['sources'] . $treestr) . "</a>";
writelog($logstring);
preparebookmark($logstring);

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

tng_header($text['sources'], $flags);
?>
    <h2 class="header"><span class="headericon" id="sources-hdr-icon"></span><?php echo $text['sources']; ?></h2>
    <br style="clear: left;">
<?php
echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'browsesources', 'method' => 'get', 'name' => 'form1', 'id' => 'form1']);

if ($totrows) {
    echo "<p><span class='normal'>{$text['matches']} $offsetplus {$text['to']} $numrowsplus {$text['of']} $totrows</span></p>";
}

$pagenav = get_browseitems_nav($totrows, "browsesources.php?sourcesearch=$sourcesearch&amp;offset", $maxsearchresults, $max_browsesource_pages);
if ($pagenav || $sourcesearch) {
    echo doSourceSearch(1, $pagenav);
    echo "<br>\n";
}
?>
    <br>
<?php
$header = $headerr = "";
$headerr = $enablemodeswitch ? "data-tablesaw-mode-switch>\n" : ">\n" . $header;
$headerr = $enableminimap ? " data-tablesaw-minimap " . $headerr : $headerr;

if (isMobile()) {
    if ($tabletype == "toggle") {
        $header = "<table cellpadding=\"3\" cellspacing='1' border='0' style=\"width:100%;\" class=\"tablesaw whiteback\" data-tablesaw-mode=\"columntoggle\"" . $headerr;
    } elseif ($tabletype == "stack") {
        $header = "<table cellpadding=\"3\" cellspacing='1' border='0' style=\"width:100%;\" class=\"tablesaw whiteback\" data-tablesaw-mode=\"stack\"" . $headerr;
    } elseif ($tabletype == "swipe") {
        $header = "<table cellpadding=\"3\" cellspacing='1' border='0' style=\"width:100%;\" class=\"tablesaw whiteback\" data-tablesaw-mode=\"swipe\"" . $headerr;
    }
} else {
    $header = "<table cellpadding=\"3\" cellspacing='1' border='0' class=\"whiteback\">\n" . $header;
}

echo $header;
?>
    <thead>
    <tr>
        <th data-tablesaw-priority="persist" class="fieldnameback nbrcol"><span class="fieldname">&nbsp;# </span></th>
        <th data-tablesaw-priority="3" class="fieldnameback nw"><span class="fieldname">&nbsp;<?php echo $text['sourceid']; ?>&nbsp;</span></th>
        <th data-tablesaw-priority="1" class="fieldnameback nw"><span class="fieldname">&nbsp;<?php echo $text['title'] . ", " . $text['author']; ?>&nbsp;</span></th>
        <?php if ($numtrees > 1) { ?>
            <th data-tablesaw-priority="3" class="fieldnameback"><span class="fieldname">&nbsp;<?php echo $text['tree']; ?>&nbsp;</span></th><?php } ?>
    </tr>
    </thead>
<?php
$i = $offsetplus;
while ($row = tng_fetch_assoc($result)) {
    $sourcetitle = $row['title'] ? $row['title'] : $row['shorttitle'];
    echo "<tr>";
    echo "<td class='databack'><span class='normal'>$i</span></td>\n";
    echo "<td class='databack'><span class='normal'><a href=\"showsource.php?sourceID={$row['sourceID']}&amp;tree={$row['gedcom']}\">{$row['sourceID']}</a>&nbsp;</span></td>";
    echo "<td class='databack'><span class='normal'><a href=\"showsource.php?sourceID={$row['sourceID']}&amp;tree={$row['gedcom']}\">$sourcetitle</a><br>{$row['author']}&nbsp;</span></td>";
    if ($numtrees > 1) {
        echo "<td class='databack nw'><span class='normal'><a href=\"showtree.php?tree={$row['gedcom']}\">{$row['treename']}</a>&nbsp;</span></td>";
    }
    echo "</tr>\n";
    $i++;
}
tng_free_result($result);
?>
    </table>
    <br>
<?php
if ($pagenav || $sourcesearch) {
    echo doSourceSearch(2, $pagenav) . "<br>\n";
}

tng_footer("");
?>
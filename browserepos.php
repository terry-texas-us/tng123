<?php
$textpart = "sources";
include "tng_begin.php";

include "functions.php";

function doRepoSearch($instance, $pagenav) {
    global $text, $reposearch, $tree;

    $str = "<span class='normal'>\n";
    $str .= getFORM("browserepos", "get", "RepoSearch$instance", "");
    $str .= "<input type='text' name=\"reposearch\" value=\"$reposearch\"> <input type='submit' value=\"{$text['search']}\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $str .= $pagenav;
    if ($reposearch) {
        $str .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='browserepos.php'>{$text['browseallrepos']}</a>";
    }
    $str .= "<input type='hidden' name=\"tree\" value=\"$tree\">\n";
    $str .= "</form></span>\n";

    return $str;
}

$max_browserepo_pages = 5;
if ($offset) {
    $offsetplus = $offset + 1;
    $newoffset = "$offset, ";
} else {
    $offsetplus = 1;
    $newoffset = "";
    $page = 1;
}

$reposearch = cleanIt(trim($reposearch));
if ($tree) {
    $wherestr = "WHERE $repositories_table.gedcom = \"$tree\"";
    if ($reposearch) {
        $wherestr .= " AND reponame LIKE \"%$reposearch%\"";
    }
    $join = "INNER JOIN";
} else {
    if ($reposearch) {
        $wherestr = "WHERE reponame LIKE \"%$reposearch%\"";
    } else {
        $wherestr = "";
    }
    $join = "LEFT JOIN";
}

$query = "SELECT repoID, reponame, repositories.gedcom AS gedcom, treename ";
$query .= "FROM $repositories_table repositories ";
$query .= "$join $trees_table trees ON repositories.gedcom = trees.gedcom ";
$query .= "$wherestr ";
$query .= "ORDER BY reponame ";
$query .= "LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);

$numrows = tng_num_rows($result);

if ($numrows == $maxsearchresults || $offsetplus > 1) {
    if ($tree) {
        $query = "SELECT count(repoID) AS scount ";
        $query .= "FROM $repositories_table repositories ";
        $query .= "LEFT JOIN $trees_table trees ON repositories.gedcom = trees.gedcom ";
        $query .= "$wherestr";
    } else {
        $query = "SELECT count(repoID) AS scount ";
        $query .= "FROM $repositories_table repositories ";
        $query .= "$wherestr";
    }
    $result2 = tng_query($query);
    $row = tng_fetch_assoc($result2);
    $totrows = $row['scount'];
} else {
    $totrows = $numrows;
}

$numrowsplus = $numrows + $offset;

$treestr = $tree ? " ({$text['tree']}: $tree)" : "";
$logstring = "<a href=\"browserepos.php?tree=$tree&amp;offset=$offset&amp;reposearch=$reposearch\">" . xmlcharacters($text['repositories'] . $treestr) . "</a>";
writelog($logstring);
preparebookmark($logstring);

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

$flags['style'] = "<style>\n";
$flags['style'] .= "table {border-collapse: separate; border-spacing: 1px;}\n";
$flags['style'] .= "table th, table td {padding: 3px;}\n";
$flags['style'] .= "tbody td {vertical-align: top;}\n";
$flags['style'] .= "</style>\n";

tng_header($text['repositories'], $flags);
?>

<h2 class="header"><span class="headericon" id="repos-hdr-icon"></span><?php echo $text['repositories']; ?></h2>
<?php
echo "<div class='normal'>\n";

echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'browserepos', 'method' => 'get', 'name' => 'form1', 'id' => 'form1']);

if ($totrows) {
    echo "<p><span class='normal'>{$text['matches']} $offsetplus {$text['to']} $numrowsplus {$text['of']} $totrows</span></p>";
}

$pagenav = get_browseitems_nav($totrows, "browserepos.php?reposearch=$reposearch&amp;offset", $maxsearchresults, $max_browserepo_pages);
if ($pagenav || $reposearch) {
    echo doRepoSearch(1, $pagenav);
    echo "<br>\n";
}

$header = "";
$headerr = $enableminimap ? " data-tablesaw-minimap" : "";
$headerr .= $enablemodeswitch ? " data-tablesaw-mode-switch" : "";

if ($sitever != "standard") {
    if ($tabletype == "toggle") {
        $header = "<table style=\"width: 100%;\" class=\"tablesaw whiteback normal\" data-tablesaw-mode=\"columntoggle\"{$headerr}>\n";
    } elseif ($tabletype == "stack") {
        $header = "<table style=\"width: 100%;\" class=\"tablesaw whiteback normal\" data-tablesaw-mode=\"stack\"{$headerr}>\n";
    } elseif ($tabletype == "swipe") {
        $header = "<table style=\"width: 100%;\" class=\"tablesaw whiteback normal\" data-tablesaw-mode=\"swipe\"{$headerr}>\n";
    }
} else {
    $header = "<table class=\"whiteback normal\">";
}
echo $header;
?>
<thead>
<tr>
    <th data-tablesaw-priority="persist" class="fieldnameback nbrcol fieldname">&nbsp;#&nbsp;</th>
    <th data-tablesaw-priority="1" class="fieldnameback fieldname">&nbsp;<?php echo $text['repoid']; ?>&nbsp;</th>
    <th data-tablesaw-priority="2" class="fieldnameback fieldname">&nbsp;<?php echo $text['name']; ?>&nbsp;</th>
    <?php if ($numtrees > 1) { ?>
        <th data-tablesaw-priority="3" class="fieldnameback">&nbsp;<?php echo $text['tree']; ?>&nbsp;</th><?php } ?>
</tr>
</thead>
<?php
echo "<tbody>\n";
$i = $offsetplus;
while ($row = tng_fetch_assoc($result)) {
    echo "<tr>\n";
    echo "<td class='databack'><span class='normal'>$i</span></td>\n";
    echo "<td class='databack'><span class='normal'><a href=\"showrepo.php?repoID={$row['repoID']}&amp;tree={$row['gedcom']}\">{$row['repoID']}</a>&nbsp;</span></td>";
    echo "<td class='databack'><span class='normal'><a href=\"showrepo.php?repoID={$row['repoID']}&amp;tree={$row['gedcom']}\">{$row['reponame']}</a>&nbsp;</span></td>";
    if ($numtrees > 1) {
        echo "<td class='databack nw'><span class='normal'>{$row['treename']}&nbsp;</span></td>";
    }
    echo "</tr>\n";
    $i++;
}
tng_free_result($result);
echo "</tbody>\n";
echo "</table><br>\n";
echo "</div>\n";
if ($pagenav || $reposearch) {
    echo doRepoSearch(2, $pagenav) . "<br>\n";
}
tng_footer("");
?>

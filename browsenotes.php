<?php
$textpart = "notes";
include "tng_begin.php";

include "functions.php";
require_once "./core/sql/extractWhereClause.php";

function doNoteSearch($instance, $pagenav) {
    global $text, $notesearch, $tree;

    $str = "<div class='normal'>\n";
    $str .= getFORM("browsenotes", "get", "notesearch$instance", "");
    $str .= "<input type='text' name=\"notesearch\" value=\"$notesearch\"> <input type='submit' value=\"{$text['search']}\"> ";
    $str .= $pagenav;
    if ($notesearch) {
        $str .= "<a href='browsenotes.php'>{$text['browseallnotes']}</a>";
    }
    $str .= "<input type='hidden' name=\"tree\" value='$tree'>\n";
    $str .= "</form>\n";
    $str .= "</div>\n";

    return $str;
}

$max_browsenote_pages = 5;
if ($offset) {
    $offsetplus = $offset + 1;
    $newoffset = "$offset, ";
} else {
    $offset = 0;
    $offsetplus = 1;
    $newoffset = "";
    $page = 1;
}
$query = "SELECT xnotes.ID AS ID, xnotes.note AS note, notelinks.persfamID AS personID, xnotes.gedcom AS gedcom ";
$query .= "FROM ($xnotes_table xnotes, $notelinks_table notelinks) ";
$query .= "WHERE xnotes.ID = notelinks.xnoteID ";
if ($tree) $query .= "AND xnotes.gedcom = '$tree' ";

if (!$allow_private) $query .= "AND notelinks.secret != '1' ";

if ($notesearch) {
    $notesearch2 = addslashes($notesearch);
    $notesearch = cleanIt(stripslashes($notesearch));
    $query .= "AND match(xnotes.note) against( \"{$notesearch2}*\" in boolean mode) ";
}
$query .= "ORDER BY note LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);

$numrows = tng_num_rows($result);

if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $query2 = "SELECT count(xnotes.ID) AS scount ";
    $query2 .= "FROM ($xnotes_table xnotes, $notelinks_table notelinks) ";
    $query2 .= "LEFT JOIN $trees_table trees ON xnotes.gedcom = trees.gedcom ";
    $query2 .= extractWhereClause($query);
    $result2 = tng_query($query2);
    $row = tng_fetch_assoc($result2);
    $totrows = $row['scount'];
} else {
    $totrows = $numrows;
}

$numrowsplus = $numrows + $offset;

$treestr = $tree ? " ({$text['tree']}: $tree)" : "";
$logstring = "<a href=\"browsenotes.php?tree=$tree&amp;offset=$offset&amp;notesearch=" . htmlentities(stripslashes($notesearch), ENT_QUOTES) . "\">" . xmlcharacters($text['notes'] . $treestr) . "</a>";
writelog($logstring);
preparebookmark($logstring);

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

$flags['style'] = "<style>\n";
$flags['style'] .= "table {border-collapse: separate; border-spacing: 1px;}\n";
$flags['style'] .= "table th, table td {padding: 3px;}\n";
$flags['style'] .= "tbody td {vertical-align: top;}\n";
$flags['style'] .= "</style>\n";

tng_header($text['notes'], $flags);
?>
    <h2 class="header"><span class="headericon" id="notes-hdr-icon"></span><?php echo $text['notes']; ?></h2>
<?php
echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'browsenotes', 'method' => 'get', 'name' => 'form1', 'id' => 'form1']);

if ($totrows) {
    echo "<p class='normal'>{$text['matches']} " . number_format($offsetplus) . " {$text['to']} " . number_format($numrowsplus) . " {$text['of']} " . number_format($totrows) . "</p>";
}

$pagenav = get_browseitems_nav($totrows, "browsenotes.php?notesearch=$notesearch&amp;offset", $maxsearchresults, $max_browsenote_pages);
echo doNoteSearch(1, $pagenav);
echo "<br>\n";

$tableStartTag = "<table class = 'whiteback normal'>";
echo $tableStartTag;
?>
    <thead>
    <tr>
        <th data-tablesaw-priority="persist" class="fieldnameback nbrcol fieldname">#</th>
        <th data-tablesaw-priority="1" class="fieldnameback text-nowrap fieldname"><?php echo $text['notes']; ?></th>
        <th data-tablesaw-priority="2" class="fieldnameback fieldname"><?php echo $text['indlinked']; ?></th>
    </tr>
    </thead>
<?php
echo "<tbody>\n";
$i = $offsetplus;
while ($nrow = tng_fetch_assoc($result)) {
    $notelinktext = "";
    $noneliving = 1;
    $noneprivate = 1;
    $query2 = $query;

    if ($nrow['secret']) $nrow['private'] = 1;

    if (!$notelinktext) {
        $query = "SELECT * FROM $people_table WHERE personID = \"{$nrow['personID']}\" AND gedcom = \"{$nrow['gedcom']}\"";
        $result2 = tng_query($query);
        if (tng_num_rows($result2) == 1) {
            $row2 = tng_fetch_assoc($result2);

            if (!$row2['living'] || !$row2['private']) {
                $query = "SELECT count(personID) AS ccount ";
                $query .= "FROM $citations_table citations, $people_table people ";
                $query .= "WHERE citations.sourceID = '{$nrow['personID']}' AND citations.persfamID = people.personID AND citations.gedcom = people.gedcom AND (living = '1' OR private = '1')";
                $nresult2 = tng_query($query);
                $nrow2 = tng_fetch_assoc($nresult2);
                if ($nrow2['ccount']) {
                    $row2['living'] = 1;
                    $row2['private'] = 1;
                }
                tng_free_result($nresult2);
            }

            $nrights = determineLivingPrivateRights($row2);
            $row2['allow_living'] = $nrights['living'];
            $row2['allow_private'] = $nrights['private'];

            if (!$row2['allow_private']) $noneprivate = 0;

            if (!$row2['allow_living']) $noneliving = 0;


            $notelinktext .= "<a href=\"getperson.php?personID={$row2['personID']}&tree={$row2['gedcom']}\">" . getNameRev($row2) . " ({$row2['personID']})</a>\n<br>\n";
            tng_free_result($result2);
        }
    }

    if (!$notelinktext) {
        $query = "SELECT * FROM $families_table WHERE familyID = \"{$nrow['personID']}\" AND gedcom = \"{$nrow['gedcom']}\"";
        $result2 = tng_query($query);
        if (tng_num_rows($result2) == 1) {
            $row2 = tng_fetch_assoc($result2);
            $nrights = determineLivingPrivateRights($row2);
            $row2['allow_living'] = $nrights['living'];
            $row2['allow_private'] = $nrights['private'];

            if (!$row2['allow_private']) $noneprivate = 0;

            if (!$row2['allow_living']) $noneliving = 0;

            $notelinktext .= "<a href=\"familygroup.php?familyID={$row2['familyID']}&tree={$row2['gedcom']}\" target='_blank'>{$text['family']} {$row2['familyID']}</a>\n<br>\n";
            tng_free_result($result2);
        }
    }
    if (!$notelinktext) {
        $query = "SELECT * FROM $sources_table WHERE sourceID = \"{$nrow['personID']}\" AND gedcom = \"{$nrow['gedcom']}\"";
        $result2 = tng_query($query);
        if (tng_num_rows($result2) == 1) {
            $row2 = tng_fetch_assoc($result2);
            $notelinktext .= "<a href=\"showsource.php?sourceID={$row2['sourceID']}&tree={$row2['gedcom']}\" target='_blank'>{$text['source']} $sourcetext ({$row2['sourceID']})</a>\n<br>\n";
            tng_free_result($result2);
        }
    }
    if (!$notelinktext) {
        $query = "SELECT * FROM $repositories_table WHERE repoID = \"{$nrow['personID']}\" AND gedcom = \"{$nrow['gedcom']}\"";
        $result2 = tng_query($query);
        if (tng_num_rows($result2) == 1) {
            $row2 = tng_fetch_assoc($result2);
            $notelinktext .= "<a href=\"showrepo.php?repoID={$row2['repoID']}&tree={$row2['gedcom']}\" target='_blank'>{$text['repository']} $sourcetext ({$row2['repoID']})</a>\n<br>\n";
            tng_free_result($result2);
        }
    }
    echo "<tr>\n";
    echo "<td class='databack'>$i</td>\n";
    echo "<td class='databack'>\n";
    if ($noneliving && $noneprivate) {
        echo nl2br($nrow['note']);
    } else {
        echo $text['livingnote'];
    }
    echo "</td>\n";
    echo "<td class='databack' style=\"width: 175px;\">$notelinktext</td>\n";
    echo "</tr>\n";
    $i++;
}
tng_free_result($result);
echo "</tbody>\n";
echo "</table><br>\n";

if ($pagenav || $notesearch) {
    echo doNoteSearch(2, $pagenav);
    echo "<br>";
}
tng_footer("");
?>
<?php
$textpart = "sources";
include "tng_begin.php";

if (!$repoID) {
    header("Location: thispagedoesnotexist.html");
    exit;
}

include "personlib.php";

$flags['imgprev'] = true;

$firstsection = 1;
$firstsectionsave = "";
$tableid = "";
$cellnumber = 0;

$query = "SELECT * FROM $repositories_table WHERE repoID = '$repoID' AND gedcom = '$tree'";
$result = tng_query($query);
$reporow = tng_fetch_assoc($result);
if (!tng_num_rows($result)) {
    tng_free_result($result);
    header("Location: thispagedoesnotexist.html");
    exit;
}
tng_free_result($result);

$reporow['living'] = 0;
$reporow['allow_living'] = 1;

$reponotes = getNotes($repoID, "R");

$logstring = "<a href=\"showrepo.php?repoID=$repoID&amp;tree=$tree\">" . _('Repository') . " {$reporow['reponame']} ($repoID)</a>";
writelog($logstring);
preparebookmark($logstring);

tng_header($reporow['reponame'], $flags);

$repomedia = getMedia($reporow, "R");
$repoalbums = getAlbums($reporow, "R");
$photostr = showSmallPhoto($repoID, $reporow['reponame'], $reporow['allow_living'], 0);
echo tng_DrawHeading($photostr, $reporow['reponame'], "");

$repotext = "";
$repotext .= "<ul class='nopad'>\n";
$repotext .= beginSection("info");
$repotext .= "<table class='whiteback tfixed' cellspacing='1' cellpadding='4'>\n";
$repotext .= "<col class='labelcol'/><col style=\"width:{$datewidth}px;\"/><col/>\n";
if ($reporow['reponame']) {
    $repotext .= showEvent(["text" => _('Name'), "fact" => $reporow['reponame']]);
}
if ($reporow['addressID']) {
    $reporow['isrepo'] = true;
    $extras = getFact($reporow);
    $repotext .= showEvent(["text" => _('Address'), "fact" => $extras]);
}

//do custom events
resetEvents();
doCustomEvents($repoID, "R");

ksort($events);
foreach ($events as $event)
    $repotext .= showEvent($event);
if ($allow_admin && $allow_edit) {
    $repotext .= showEvent(["text" => _('Repository ID'), "date" => $repoID, "place" => "<a href=\"admin_editrepo.php?repoID=$repoID&amp;tree=$tree&amp;cw=1\" target='_blank'>" . _('Edit') . "</a>", "np" => 1]);
} else {
    $repotext .= showEvent(["text" => _('Repository ID'), "date" => $repoID]);
}

if ($soffset) {
    $soffsetstr = "$soffset, ";
    $newsoffset = $soffset + 1;
} else {
    $soffsetstr = "";
    $newsoffset = 0;
}

$query = "SELECT sourceID, title, shorttitle FROM $sources_table WHERE gedcom = '$tree' AND repoID = '$repoID' ORDER BY title LIMIT $soffsetstr" . ($maxsearchresults + 1);
$sresult = tng_query($query);
$numrows = tng_num_rows($sresult);
$repolinktext = "";
while ($srow = tng_fetch_assoc($sresult)) {
    if ($repolinktext) $repolinktext .= "\n";

    $title = $srow['shorttitle'] ? $srow['shorttitle'] : $srow['title'];
    $repolinktext .= "<a href=\"showsource.php?sourceID={$srow['sourceID']}&amp;tree=$tree\">$title</a>";
}
if ($numrows >= $maxsearchresults) {
    $repolinktext .= "\n[<a href=\"showrepo.php?repoID=$repoID&amp;tree=$tree&amp;foffset=$foffset&amp;soffset=" . ($newsoffset + $maxsearchresults) . "\">" . _('More sources') . "</a>]";
}
tng_free_result($sresult);

if ($repolinktext) {
    $repotext .= showEvent(["text" => _('Linked to'), "fact" => $repolinktext]);
}

$repotext .= "</table>\n";
$repotext .= "<br>\n";
$repotext .= endSection("info");

$media = doMediaSection($repoID, $repomedia, $repoalbums);
if ($media) {
    $repotext .= beginSection("media");
    $repotext .= $media;
    $repotext .= endSection("media");
}

$notes = buildNotes($reponotes, "");
if ($notes) {
    $repotext .= beginSection("notes");
    $repotext .= "<table class='whiteback tfixed' cellspacing='1' cellpadding='4'>\n";
    $repotext .= "<col class='labelcol'/><col/>\n";
    $repotext .= "<tr>\n";
    $repotext .= "<td class='fieldnameback indleftcol align-top' id=\"notes1\"><span class='fieldname'>&nbsp;" . _('Notes') . "&nbsp;</span></td>\n";
    $repotext .= "<td class='databack'>$notes</td>\n";
    $repotext .= "</tr>\n";
    $repotext .= "</table>\n";
    $repotext .= "<br>\n";
    $repotext .= endSection("notes");
}
$repotext .= "</ul>\n";

$tng_alink = $tng_plink = "lightlink";
$innermenu = $num_collapsed ? "<div style=\"float:right;\"><a href='#' onclick=\"return toggleCollapsed(0)\" class='lightlink'>Expand all</a> &nbsp | &nbsp; <a href='#' onclick=\"return toggleCollapsed(1)\" class='lightlink'>Collapse all</a> &nbsp;</div>" : "";
if ($media || $notes) {
    if ($tngconfig['istart']) {
        $tng_plink = "lightlink3";
    } else {
        $tng_alink = "lightlink3";
    }
    $innermenu .= "<a href='#' class=\"$tng_plink\" onclick=\"return infoToggle('info');\" id=\"tng_plink\">" . _('Repository Information') . "</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
    if ($media) {
        $innermenu .= "<a href='#' class='lightlink' onclick=\"return infoToggle('media');\" id=\"tng_mlink\">" . _('Media') . "</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
    }
    if ($notes) {
        $innermenu .= "<a href='#' class='lightlink' onclick=\"return infoToggle('notes');\" id=\"tng_nlink\">" . _('Notes') . "</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
    }
    $innermenu .= "<a href='#' class=\"$tng_alink\" onclick=\"return infoToggle('all');\" id=\"tng_alink\">" . _('All') . "</a>\n";
} else {
    $innermenu .= "<span class=\"lightlink3\" id=\"tng_plink\">" . _('Repository Information') . "</span>\n";
}

$rightbranch = 1;
echo tng_menu("R", "repo", $repoID, $innermenu);
?>
    <script>
        function innerToggle(part, subpart, subpartlink) {
            if (part == subpart)
                turnOn(subpart, subpartlink);
            else
                turnOff(subpart, subpartlink);
        }

        function turnOn(subpart, subpartlink) {
            jQuery('#' + subpartlink).attr('class', 'lightlink3');
            jQuery('#' + subpart).show();
        }

        function turnOff(subpart, subpartlink) {
            jQuery('#' + subpartlink).attr('class', 'lightlink');
            jQuery('#' + subpart).hide();
        }

        function infoToggle(part) {
            if (part == "all") {
                jQuery('#info').show();
                <?php
                if ($media) {
                    echo "\$('#media').show();\n";
                    echo "\$('#tng_mlink').attr('class','lightlink');\n";
                }
                if ($notes) {
                    echo "\$('#notes').show();\n";
                    echo "\$('#tng_nlink').attr('class','lightlink');\n";
                }
                ?>
                jQuery('#tng_alink').attr('class', 'lightlink3');
                jQuery('#tng_plink').attr('class', 'lightlink');
            } else {
                innerToggle(part, "info", "tng_plink");
                <?php
                if ($media) echo "innerToggle(part,\"media\",\"tng_mlink\");\n";

                if ($notes) echo "innerToggle(part,\"notes\",\"tng_nlink\");\n";

                ?>
                jQuery('#tng_alink').attr('class', 'lightlink');
            }
            return false;
        }
    </script>

<?php
echo $repotext;
?>
    <br>

<?php
tng_footer($flags);
?>
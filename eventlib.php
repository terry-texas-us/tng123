<?php

function showCustEvents($id) {
    global $tree, $admtext, $events_table, $eventtypes_table, $allow_edit, $allow_delete, $gotnotes, $gotcites;

    echo "<div id=\"custevents\" style=\"margin-bottom: 5px;\">\n";

    $query = "SELECT display, eventdate, eventplace, info, events.eventID AS eventID ";
    $query .= "FROM $events_table events, $eventtypes_table eventtypes ";
    $query .= "WHERE parenttag = \"\" AND persfamID = \"{$id}\" AND gedcom = '$tree' AND events.eventtypeID = eventtypes.eventtypeID ";
    $query .= "ORDER BY eventdatetr, ordernum";
    $evresult = tng_query($query);
    $eventcount = tng_num_rows($evresult);

    echo "<table id=\"custeventstbl\" class='normal' cellpadding=\"3\" cellspacing=\"1\" border=\"0\"";
    if (!$eventcount) {
        echo " style=\"display:none;\"";
    }
    echo ">";
    echo "<tbody id=\"custeventstblbody\">\n";
    echo "<tr>\n";
    echo "<th class=\"fieldnameback fieldname\">" . $admtext['action'] . "</th>\n";
    echo "<th class=\"fieldnameback fieldname\">" . $admtext['event'] . "</th>\n";
    echo "<th class=\"fieldnameback fieldname\">" . $admtext['eventdate'] . "</th>\n";
    echo "<th class=\"fieldnameback fieldname\">" . $admtext['eventplace'] . "</th>\n";
    echo "<th class=\"fieldnameback fieldname\">" . $admtext['detail'] . "</th>\n";
    echo "</tr>\n";

    if ($evresult && $eventcount) {
        while ($event = tng_fetch_assoc($evresult)) {
            $displayval = getEventDisplay($event['display']);
            $info = cleanIt($event['info']);
            $truncated = substr($info, 0, 90);
            $info = strlen($info) > 90 ? substr($truncated, 0, strrpos($truncated, ' ')) . '&hellip;' : $info;

            $actionstr = $allow_edit ? "<a href=\"#\" onclick=\"return editEvent({$event['eventID']});\" title=\"{$admtext['edit']}\" class=\"smallicon admin-edit-icon\"></a>" : "";
            $actionstr .= $allow_delete ? "<a href=\"#\" onclick=\"return deleteEvent('{$event['eventID']}');\" title=\"{$admtext['text_delete']}\" class=\"smallicon admin-delete-icon\"></a>" : "&nbsp;";
            if (isset($gotnotes)) {
                $notesicon = $gotnotes[$event['eventID']] ? "admin-note-on-icon" : "admin-note-off-icon";
                $actionstr .= "<a href=\"#\" onclick=\"return showNotes('{$event['eventID']}','$id');\" title=\"{$admtext['notes']}\" id=\"notesicon{$event['eventID']}\" class=\"smallicon $notesicon\"></a>";
            }
            if (isset($gotcites)) {
                $citesicon = $gotcites[$event['eventID']] ? "admin-cite-on-icon" : "admin-cite-off-icon";
                $actionstr .= "<a href=\"#\" onclick=\"return showCitations('{$event['eventID']}','$id');\" title=\"{$admtext['sources']}\" id=\"citesicon{$event['eventID']}\" class=\"smallicon $citesicon\"></a>";
            }
            echo "<tr id=\"row_{$event['eventID']}\">\n";
            echo "<td class='lightback nw'>$actionstr</td>\n";
            echo "<td class='lightback'>$displayval</td>\n";
            echo "<td class='lightback'>{$event['eventdate']}</td>\n";
            echo "<td class='lightback'>{$event['eventplace']}</td>\n";
            echo "<td class='lightback'>$info</td>\n";
            echo "</tr>\n";
        }
        tng_free_result($evresult);
    }
    echo "</tbody>\n";
    echo "</table>\n";
    echo "</div>\n";
}

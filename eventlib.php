<?php

/**
 * @param $id
 */
function showCustEvents($id) {
    global $tree, $admtext, $events_table, $eventtypes_table, $allow_edit, $allow_delete, $gotnotes, $gotcites, $mylanguage, $languages_path;
    $query = "SELECT display, eventdate, eventplace, info, events.eventID AS eventID ";
    $query .= "FROM $events_table events, $eventtypes_table eventtypes ";
    $query .= "WHERE parenttag = '' AND persfamID = '$id' AND gedcom = '$tree' AND events.eventtypeID = eventtypes.eventtypeID ";
    $query .= "ORDER BY eventdatetr, ordernum";
    $evresult = tng_query($query);
    $events = tng_fetch_all($evresult);
    tng_free_result($evresult);
    foreach ($events as $event) {
        $dispvalues = explode("|", $event['display']);
        $numvalues = count($dispvalues);
        if ($numvalues > 1) {
            $displayval = "";
            for ($i = 0; $i < $numvalues; $i += 2) {
                $lang = $dispvalues[$i];
                if ($mylanguage == $languages_path . $lang) {
                    $displayval = $dispvalues[$i + 1];
                    break;
                }
            }
        } else {
            $displayval = $event['display'];
        }
        $info = cleanIt($event['info']);
        $rowspan = 0;
        if ($info) $rowspan++;
        if ($event['eventdate'] || $event['eventplace']) $rowspan++;
        if (!$rowspan) {
            $rowspan = 1;
            $info = "&nbsp;";
        }
        $truncated = substr($info, 0, 90);
        $info = strlen($info) > 90 ? substr($truncated, 0, strrpos($truncated, ' ')) . '&hellip;' : $info;
        $actionstr = $allow_edit ? "<a href='#' onclick=\"return editEvent({$event['eventID']});\" title=\"{$admtext['edit']}\" class='smallicon admin-edit-icon'></a>" : "";
        $actionstr .= $allow_delete ? "<a href='#' onclick=\"return deleteEvent('{$event['eventID']}');\" title=\"{$admtext['text_delete']}\" class='smallicon admin-delete-icon'></a>" : "&nbsp;";
        if (isset($gotnotes)) {
            $notesicon = !empty($gotnotes[$event['eventID']]) ? "admin-note-on-icon" : "admin-note-off-icon";
            $actionstr .= "<a href='#' onclick=\"return showNotes('{$event['eventID']}','$id');\" title=\"{$admtext['notes']}\" id=\"notesicon{$event['eventID']}\" class='smallicon $notesicon'></a>";
        }
        if (isset($gotcites)) {
            $citesicon = !empty($gotcites[$event['eventID']]) ? "admin-cite-on-icon" : "admin-cite-off-icon";
            $actionstr .= "<a href='#' onclick=\"return showCitations('{$event['eventID']}','$id');\" title=\"{$admtext['sources']}\" id=\"citesicon{$event['eventID']}\" class='smallicon $citesicon'></a>";
        }
        if ($event['eventdate'] || $event['eventplace']) {
            echo "<tr class=\"row_{$event['eventID']} align-top\" id=\"row_{$event['eventID']}_top\">\n";
            echo "<td rowspan=\"$rowspan\" class='p-1 border-b'>{$displayval}:</td>\n";
            echo "<td class='lightback p-1'>{$event['eventdate']}</td>\n";
            echo "<td class='lightback p-1'>{$event['eventplace']}</td>\n";
            echo "<td class='lightback nw p-1' colspan='4' rowspan='$rowspan'>$actionstr</td>\n";
            echo "</tr>\n";
            if ($info) {
                echo "<tr class=\"row_{$event['eventID']}\" id=\"row_{$event['eventID']}_bot\">\n";
                echo "<td class='lightback p-1' colspan='2'>$info</td>\n";
                echo "</tr>\n";
            }
        } else {
            echo "<tr class=\"row_{$event['eventID']} align-top\" id=\"row_{$event['eventID']}_top\">\n";
            echo "<td class='p-1 border-b'>{$displayval}:</td>\n";
            echo "<td class='lightback p-1' colspan='2'>$info</td>\n";
            echo "<td class='lightback nw p-1' colspan='4'>$actionstr</td>\n";
            echo "</tr>\n";
        }
    }
}
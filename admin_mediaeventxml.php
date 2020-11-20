<?php
include "begin.php";
include "adminlib.php";
$textpart = "photos";
include "$mylanguage/admintext.php";

$admin_login = true;
include "checklogin.php";
function doEvent($eventID, $displayval, $info) {
    echo "<event>\n";
    echo "<eventID>$eventID</eventID>\n";
    echo "<display>" . xmlcharacters($displayval) . "</display>\n";
    if ($info) {
        echo "<info>" . xmlcharacters("($info)") . "</info>\n";
    } else {
        echo "<info>-1</info>\n";
    }
    echo "</event>\n";
}

header('Content-Type: application/xml');
echo "<?xml version=\"1.0\"";
if ($session_charset) echo " encoding=\"$session_charset\"";

echo "?>\n";
echo "<eventlist>\n";

//write out the number for the list to be filled
echo "<targetlist>\n";
echo "<target>$count</target>\n";
echo "</targetlist>\n";

if ($linktype == "I") {
    doEvent("NAME", _("Name"), '');
    doEvent("BIRT", _("Birth"), '');
    doEvent("CHR", _("Christening"), '');
    doEvent("DEAT", _("Death"), '');
    doEvent("BURI", _("Burial"), '');
    if ($allow_lds) {
        doEvent("BAPL", _("Baptism (LDS)"), '');
        doEvent("CONL", _("Confirmation (LDS)"), '');
        doEvent("INIT", _("Initiatory (LDS)"), '');
        doEvent("ENDL", _("Endowment (LDS)"), '');
        doEvent("SLGC", _("Sealed to Parents (LDS)"), '');
    }
} elseif ($linktype == "F") {
    doEvent("MARR", _("Married"), '');
    doEvent("DIV", _("Divorced"), '');
    if ($allow_lds) {
        doEvent("SLGS", _("Sealed to Spouse (LDS)"), '');
    }
}
//now call up custom events linked to passed in entity
$query = "SELECT display, eventdate, eventplace, info, eventID ";
$query .= "FROM $events_table events, $eventtypes_table eventtypes ";
$query .= "WHERE persfamID = \"{$persfamID}\" AND events.eventtypeID = eventtypes.eventtypeID AND gedcom = '$tree' AND keep = '1' AND parenttag = \"\" ";
$query .= "ORDER BY ordernum, tag, description, eventdatetr, info, eventID";
$custevents = tng_query($query);
while ($custevent = tng_fetch_assoc($custevents)) {
    $displayval = getEventDisplay($custevent['display']);
    if ($custevent['eventdate']) {
        $info = displayDate($custevent['eventdate']);
    } elseif ($custevent['eventplace']) {
        $info = $custevent['eventplace'];
    } elseif ($custevent['info']) {
        $info = substr($custevent['info'], 0, 20) . "...";
    }
    doEvent($custevent['eventID'], $displayval, $info);
}
tng_free_result($custevents);

echo "</eventlist>";

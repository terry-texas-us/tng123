<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
if ($assignedtree || !$allow_edit) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

require "adminlog.php";

$reportname = addslashes($reportname);
$reportnameorg = addslashes($reportnameorg);
$reportdesc = addslashes($reportdesc);
$criteria = addslashes($criteria);
$sqlselect = addslashes($sqlselect);

if ($savecopy) {
    if ($reportname == $reportnameorg) {
        $count = 0;
        do {
            $count++;
            $reportname = $reportnameorg . " " . $count;
            $tquery = "SELECT reportID FROM $reports_table WHERE reportname=\"$reportname\"";
            $tresult = tng_query($tquery);
            $alreadygotone = tng_num_rows($tresult);
            tng_free_result($tresult);
        } while ($alreadygotone);
    }
    $query = "INSERT INTO $reports_table (reportname, reportdesc, ranking, active, display, criteria, orderby, sqlselect) VALUES (\"$reportname\",\"$reportdesc\",\"$ranking\",\"$active\",\"$display\",\"$criteria\",\"$orderby\",\"$sqlselect\")";
    $result = tng_query($query);
    $reportID = tng_insert_id();
} else {
    $query = "UPDATE $reports_table SET reportname=\"$reportname\",reportdesc=\"$reportdesc\",ranking=\"$ranking\",active=\"$active\",display=\"$display\",criteria=\"$criteria\",orderby=\"$orderby\",sqlselect=\"$sqlselect\" WHERE reportID=\"$reportID\"";
    $result = tng_query($query);
}

adminwritelog("<a href=\"admin_editreport.php?reportID=$reportID\">" . _('Edit Existing Report') . ": $reportID</a>");

if ($submitx) {
    $message = _('Changes to report') . " $reportID " . _('were successfully saved') . ".";
    header("Location: admin_reports.php?message=" . urlencode($message));
} else {
    header("Location: admin_editreport.php?reportID=$reportID");
}


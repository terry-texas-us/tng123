<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
if ($assignedtree || !$allow_add) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

require "adminlog.php";

$template = "ssssssss";
$query = "INSERT INTO $reports_table (reportname, reportdesc, ranking, active, display, criteria, orderby, sqlselect) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$params = [&$template, &$reportname, &$reportdesc, &$ranking, &$active, &$display, &$criteria, &$orderby, &$sqlselect];
tng_execute($query, $params);
$reportID = tng_insert_id();

adminwritelog("<a href=\"admin_editreport.php?reportID=$reportID\">" . _('Add New Report') . ": $reportID/$reportname</a>");

$message = _('Report') . " $reportID " . _('was successfully added') . ".";
header("Location: admin_reports.php?message=" . urlencode($message));

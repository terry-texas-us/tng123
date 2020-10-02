<?php
include "begin.php";
include "adminlib.php";
$textpart = "trees";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
if ($assignedtree || !$allow_add) {
    $message = $admtext['norights'];
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

require "adminlog.php";

$gedcom = preg_replace("/\s*/", "", $gedcom);
$treenamedisp = stripslashes($treename);

if (!$disallowgedcreate) {
    $disallowgedcreate = 0;
}
if (!$disallowpdf) {
    $disallowpdf = 0;
}
if (!$private) {
    $private = 0;
}
$template = "ssssssssssssss";
$query = "INSERT IGNORE INTO $trees_table (gedcom,treename,description,owner,email,address,city,state,country,zip,phone,secret,disallowgedcreate,disallowpdf) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$params = [&$template, &$gedcom, &$treename, &$description, &$owner, &$email, &$address, &$city, &$state, &$country, &$zip, &$phone, &$private, &$disallowgedcreate, &$disallowpdf];
$affected_rows = tng_execute_noerror($query, $params);
if ($affected_rows == 1) {
    adminwritelog("<a href=\"admin_edittree.php?tree=$gedcom\">{$admtext['addnewtree']}: $gedcom/$treename</a>");

    $message = $admtext['tree'] . " $treenamedisp {$admtext['succadded']}.";
    if ($beforeimport == "yes") {
        echo "1";
    } else {
        header("Location: admin_trees.php?message=" . urlencode($message));
    }
} else {
    $message = $admtext['treeexists'];
    if ($beforeimport) {
        echo $message;
    } else {
        header("Location: admin_newtree.php?message=" . urlencode($message) . "&treename=$treename&description=$description&owner=$owner&email=$email&address=$address&city=$city&state=$state&country=$country&zip=$zip&phone=$phone&private=$private&disallowgedcreate=$disallowgedcreate");
    }
}

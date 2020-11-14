<?php
include "begin.php";
include "adminlib.php";
$textpart = "trees";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
if (!$allow_delete) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

require "adminlog.php";

include "treelib.php";

$message = _('Tree') . " $gedcom " . _('was successfully cleared') . ".";

adminwritelog(_('Deleted') . ": " . _('Tree') . " $tree");

header("Location: admin_trees.php?message=" . urlencode($message));


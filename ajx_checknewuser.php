<?php
include "begin.php";
include "adminlib.php";
$textpart = "checkID";
include "$mylanguage/admintext.php";

include "checklogin.php";

$query = "SELECT username FROM $users_table WHERE username = \"$checkuser\"";
$result = tng_query($query) or die ("" . _('Cannot execute query') . ": $query");

if ($result && tng_num_rows($result)) {
    $message = "<b>$checkuser</b> " . _('is in use. Please choose a different ID') . "";
    $success = "false";
} else {
    $message = "<b>$checkuser</b> " . _('is OK to use') . "";
    $success = "true";
}
tng_free_result($result);

header("Content-Type: application/json; charset=" . $session_charset);
echo "{\"rval\":$success,\"html\":\"$message\"}";


<?php
include "begin.php";
include "adminlib.php";
$textpart = "checkID";
include "$mylanguage/admintext.php";

include "checklogin.php";

$query = "SELECT userId FROM $users_table WHERE LOWER(email) = LOWER(\"$checkemail\")";
$result = tng_query($query) or die ("" . _('Cannot execute query') . ": $query");

if ($result && tng_num_rows($result)) {
    $message = _('is already in use.');
    $success = "msgerror";
} else {
    $message = _('is OK to use');
    $success = "msgapproved";
}
tng_free_result($result);

header("Content-type:text/html; charset=" . $session_charset);
echo "{\"result\":\"$success\",\"message\":\"$message\"}";


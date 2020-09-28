<?php
include "begin.php";
include "adminlib.php";
$textpart = "sources";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
if (!$allow_edit || ($assignedtree && $assignedtree != $tree)) {
    $message = $admtext['norights'];
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

require "adminlog.php";

$reponame = addslashes($reponame);
$address1 = addslashes($address1);
$address2 = addslashes($address2);
$city = addslashes($city);
$state = addslashes($state);
$zip = addslashes($zip);
$country = addslashes($country);
$phone = addslashes($phone);
$email = addslashes($email);
$www = addslashes($www);

$newdate = date("Y-m-d H:i:s", time() + (3600 * $time_offset));

if ($addressID) {
    $query = "UPDATE $address_table SET address1=\"$address1\", address2=\"$address2\", city=\"$city\", state=\"$state\", zip=\"$zip\", country=\"$country\", phone=\"$phone\", email='$email', www=\"$www\" WHERE addressID = \"$addressID\"";
    $result = tng_query($query);
} elseif ($address1 || $address2 || $city || $state || $zip || $country || $phone || $email || $www) {
    $query = "INSERT INTO $address_table (address1, address2, city, state, zip, country, gedcom, phone, email, www)  VALUES(\"$address1\", \"$address2\", \"$city\", \"$state\", \"$zip\", \"$country\", '$tree', \"$phone\", '$email', \"$www\")";
    $result = tng_query($query);
    $addressID = tng_insert_id();
}

$query = "UPDATE $repositories_table SET reponame=\"$reponame\",addressID=\"$addressID\",changedate=\"$newdate\",changedby=\"$currentuser\" WHERE repoID=\"$repoID\" AND gedcom = '$tree'";
$result = tng_query($query);

adminwritelog("<a href=\"editrepo.php?repoID=$repoID&tree=$tree\">{$admtext['modifyrepo']}: $tree/$repoID</a>");

if ($newscreen == "return") {
    header("Location: admin_editrepo.php?repoID=$repoID&tree=$tree");
} else {
    if ($newscreen == "close") {
        ?>
        <!doctype html>
        <html lang="en">

        <body>
        <script>
            top.close();
        </script>
        </body>
        </html>
        <?php
    } else {
        $message = $admtext['changestorepo'] . " $repoID {$admtext['succsaved']}.";
        header("Location: admin_repositories.php?message=" . urlencode($message));
    }
}
?>

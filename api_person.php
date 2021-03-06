<?php
include "begin.php";
include "genlib.php";
include "getlang.php";

include "api_checklogin.php";
include "personlib.php";
include "api_library.php";
include "log.php";

header("Content-Type: application/json; charset=" . $session_charset);

$query = "SELECT *, DATE_FORMAT(changedate,\"%e %b %Y\") AS changedate ";
$query .= "FROM $people_table ";
$query .= "WHERE personID = \"{$personID}\" AND gedcom = '$tree'";
$result = tng_query($query);
$row = tng_fetch_assoc($result);
if (!tng_num_rows($result)) {
    tng_free_result($result);
    echo "{\"error\":\"No one in database with that ID and tree\"}";
    exit;
} else {
    tng_free_result($result);
}

echo "{\n";

$righttree = checktree($tree);
$rightbranch = checkbranch($row['branch']);
$rights = determineLivingPrivateRights($row, $righttree);
$row['allow_living'] = $rights['living'];
$row['allow_private'] = $rights['private'];

$namestr = getName($row);

$logname = $tngconfig['nnpriv'] && $row['private'] ? _('Private') : ($nonames && $row['living'] ? _('Living') : $namestr);

writelog("<a href=\"getperson.php?personID=$personID&amp;tree=$tree\">" . _('Individual info for') . " $logname ($personID)</a>");

$events = [];
echo api_person($row, $fullevents);

echo "}";

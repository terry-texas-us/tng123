<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
if (!$allow_edit || ($assignedtree && $assignedtree != $tree)) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

header("Content-type:text/html; charset=" . $session_charset);
?>

<div style="margin:10px;">
    <h3 class="subhead"><?php echo _('Show people with this tree/branch'); ?></h3>
    <?php
    $query = "SELECT personID, firstname, lastname, lnprefix, prefix, suffix, branch, gedcom, nameorder, living, private ";
    $query .= "FROM $people_table ";
    $query .= "WHERE gedcom = '$tree' and branch LIKE '%$branch%' ";
    $query .= "ORDER BY lastname, firstname";
    $brresult = tng_query($query);
    $numresults = tng_num_rows($brresult);
    $names = "";
    $counter = $fcounter = 0;

    while ($row = tng_fetch_assoc($brresult)) {
        $rights = determineLivingPrivateRights($row, true, true);
        $row['allow_living'] = $rights['living'];
        $row['allow_private'] = $rights['private'];

        $names .= "<a href=\"admin_editperson.php?personID={$row['personID']}&amp;tree={$row['gedcom']}&amp;cw=1\" target='_blank'>" . getName($row) . " ({$row['personID']})</a><br>\n";
        $counter++;
    }
    tng_free_result($brresult);

    $query = "SELECT familyID, husband, wife, gedcom, branch, living, private FROM $families_table WHERE gedcom = '$tree' AND branch LIKE \"%$branch%\" ORDER BY familyID";
    $brresult = tng_query($query);
    $numfresults = tng_num_rows($brresult);

    if ($numresults) $names .= "<br>\n";

    while ($row = tng_fetch_assoc($brresult)) {
        $rights = determineLivingPrivateRights($row, true, true);
        $row['allow_living'] = $rights['living'];
        $row['allow_private'] = $rights['private'];

        $names .= "<a href=\"admin_editfamily.php?familyID={$row['familyID']}&amp;tree={$row['gedcom']}&amp;cw=1\" target='_blank'>" . getFamilyName($row) . "</a><br>\n";
        $fcounter++;
    }
    tng_free_result($brresult);

    if (!$names) {
        echo "<p>" . _('No records exist.') . "</p>";
    } else {
        echo "<p class='normal'>" . _('Existing labels') . ": $counter " . _('People') . ", $fcounter " . _('Families') . ".</p>\n";
        echo $names;
    }
    ?>
</div>

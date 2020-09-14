<?php
include "begin.php";
include "adminlib.php";
require_once "./admin/trees.php";

if (!$mediaID) {
  die("no args");
}

$textpart = "photos";
include "$mylanguage/admintext.php";

include $cms['tngpath'] . "checklogin.php";

initMediaTypes();

$query = "SELECT * FROM $media_table WHERE mediaID = \"$mediaID\"";
$result = tng_query($query);
$row = tng_fetch_assoc($result);
tng_free_result($result);
$row['firstname'] = preg_replace("/\"/", "&#34;", $row['firstname']);

if (!$allow_media_edit && !$allow_media_add) {
  $message = $admtext['norights'];
  header("Location: ajx_login.php?message=" . urlencode($message));
  exit;
}

[$tree, $trees, $treename, $treequery] = getOrderedTreesList($assignedtree, $trees_table);

$query = "SELECT medialinks.medialinkID AS mlinkID, medialinks.personID AS personID, eventID, people.lastname AS lastname, people.lnprefix AS lnprefix, people.firstname AS firstname, people.prefix AS prefix, people.suffix AS suffix, people.nameorder AS nameorder, altdescription, altnotes, medialinks.gedcom AS gedcom, people.branch AS branch, treename, familyID, people.personID AS personID2, wifepeople.personID AS wpersonID, wifepeople.firstname AS wfirstname, wifepeople.lnprefix AS wlnprefix, wifepeople.lastname AS wlastname, wifepeople.prefix AS wprefix, wifepeople.suffix AS wsuffix, wifepeople.nameorder AS wnameorder, husbpeople.personID AS hpersonID, husbpeople.firstname AS hfirstname, husbpeople.lnprefix AS hlnprefix, husbpeople.lastname AS hlastname, husbpeople.prefix AS hprefix, husbpeople.suffix AS hsuffix, husbpeople.nameorder AS hnameorder, sourceID, sources.title, repositories.repoID AS repoID, reponame, defphoto, linktype, dontshow, people.living, people.private, families.living AS fliving, families.private AS fprivate ";
$query .= "FROM $medialinks_table medialinks ";
$query .= "LEFT JOIN $trees_table trees ON medialinks.gedcom = trees.gedcom ";
$query .= "LEFT JOIN $people_table people ON medialinks.personID = people.personID AND medialinks.gedcom = people.gedcom ";
$query .= "LEFT JOIN $families_table families ON medialinks.personID = families.familyID AND medialinks.gedcom = families.gedcom ";
$query .= "LEFT JOIN $sources_table sources ON medialinks.personID = sources.sourceID AND medialinks.gedcom = sources.gedcom ";
$query .= "LEFT JOIN $repositories_table repositories ON medialinks.personID = repositories.repoID AND medialinks.gedcom = repositories.gedcom ";
$query .= "LEFT JOIN $people_table husbpeople ON families.husband = husbpeople.personID AND families.gedcom = husbpeople.gedcom ";
$query .= "LEFT JOIN $people_table wifepeople ON families.wife = wifepeople.personID AND families.gedcom = wifepeople.gedcom ";
$query .= "WHERE mediaID = \"$mediaID\" ";
$query .= "ORDER BY medialinks.medialinkID DESC";
$result2 = tng_query($query);

header("Content-type:text/html; charset=" . $session_charset);
?>

<table width="100%" cellpadding="10" cellspacing="0">
    <tr class="databack">
        <td>
            <h3 class="subhead"><?php echo $admtext['medialinks']; ?></h3>
            <form action="" name="form1" id="form1">
                <?php include "micro_medialinks.php"; ?>
            </form>
        </td>
    </tr>
</table>
<?php
include("begin.php");
include("adminlib.php");
$textpart = "sources";
//include("getlang.php");
include("$mylanguage/admintext.php");

$admin_login = 1;
include("checklogin.php");

if (!$allow_edit || ($assignedtree && $assignedtree != $tree)) {
  $message = $admtext['norights'];
  header("Location: admin_login.php?message=" . urlencode($message));
  exit;
}

require("adminlog.php");

$shorttitle = addslashes($shorttitle);
$title = addslashes($title);
$author = addslashes($author);
$callnum = addslashes($callnum);
$publisher = addslashes($publisher);
$actualtext = addslashes($actualtext);

$newdate = date("Y-m-d H:i:s", time() + (3600 * $time_offset));

$query = "UPDATE $sources_table SET shorttitle=\"$shorttitle\",title=\"$title\",author=\"$author\",callnum=\"$callnum\",publisher=\"$publisher\",repoID=\"$repoID\",actualtext=\"$actualtext\",changedate=\"$newdate\",changedby=\"$currentuser\" WHERE sourceID=\"$sourceID\" AND gedcom = \"$tree\"";
$result = tng_query($query);

adminwritelog("<a href=\"admin_editsource.php?sourceID=$sourceID&amp;tree=$tree\">{$admtext['modifysource']}: $tree/$sourceID</a>");

if ($newscreen == "return") {
  header("Location: admin_editsource.php?sourceID=$sourceID&tree=$tree");
} else {
  if ($newscreen == "close") {
    ?>
      <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
      <html>
      <body>
      <script type="text/javascript">
          top.close();
      </script>
      </body>
      </html>
    <?php
  } else {
    $message = $admtext['changestosource'] . " $sourceID {$admtext['succsaved']}.";
    header("Location: admin_sources.php?message=" . urlencode($message));
  }
}
?>

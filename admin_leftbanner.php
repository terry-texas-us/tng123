<?php
include "begin.php";
include($cms['tngpath'] . "genlib.php");
$maint = $tngconfig['maint'];
$tngconfig['maint'] = "";
include($cms['tngpath'] . "adminlib.php");
$textpart = "index";
include "$mylanguage/admintext.php";
$admin_login = 2;

include($cms['tngpath'] . "checklogin.php");

$home_url = $homepage;

tng_adminheader($admtext['administration'], "");
?>
</head>

<body class="sideback">


<?php
if ($allow_edit || $allow_add || $allow_delete) {
  ?>
    <strong><a href="admin_main.php" class="lightlink2 leftlink" target="main"><?php echo $admtext['administration']; ?></a></strong>
    <a href="admin_people.php" class="lightlink2 leftlink" target="main"><?php echo $admtext['people']; ?></a>
    <a href="admin_families.php" class="lightlink2 leftlink" target="main"><?php echo $admtext['families']; ?></a>
    <a href="admin_sources.php" class="lightlink2 leftlink" target="main"><?php echo $admtext['sources']; ?></a>
    <a href="admin_repositories.php" class="lightlink2 leftlink" target="main"><?php echo $admtext['repositories']; ?></a>
  <?php
}
if ($allow_edit || $allow_add || $allow_delete || $allow_media_add || $allow_media_edit || $allow_media_delete) {
  ?>
    <a href="admin_media.php" class="lightlink2 leftlink" target="main"><?php echo $admtext['media']; ?></a>
    <a href="admin_albums.php" class="lightlink2 leftlink" target="main"><?php echo $admtext['albums']; ?></a>
  <?php
}
if ($allow_edit || $allow_add || $allow_delete) {
  ?>
    <a href="admin_cemeteries.php" class="lightlink2 leftlink" target="main"><?php echo $admtext['cemeteries']; ?></a>
    <a href="admin_places.php" class="lightlink2 leftlink" target="main"><?php echo $admtext['places']; ?></a>
    <a href="admin_timelineevents.php" class="lightlink2 leftlink" target="main"><?php echo $admtext['tlevents']; ?></a>
  <?php
}
if ($allow_edit || $allow_delete) {
  ?>
    <a href="admin_notelist.php" class="lightlink2 leftlink" target="main"><?php echo $admtext['notes']; ?></a>
  <?php
}
if ($allow_edit && $allow_add && $allow_delete && !$assignedtree) {
  ?>
    <a href="admin_misc.php" class="lightlink2 leftlink" target="main"><?php echo $admtext['misc']; ?></a>
  <?php
}
?>
<hr/>
<?php
if ($allow_edit && $allow_add && $allow_delete && !$assignedbranch) {
  ?>
    <a href="admin_dataimport.php" class="lightlink2 leftlink" target="main"><?php echo $admtext['datamaint']; ?></a>
  <?php
}
if ($allow_edit && $allow_add && $allow_delete && !$assignedtree) {
  ?>
    <a href="admin_setup.php" class="lightlink2 leftlink" target="main"><?php echo $admtext['setup']; ?></a>
    <a href="admin_users.php" class="lightlink2 leftlink" target="main"><?php echo $admtext['users']; ?></a>
    <a href="admin_trees.php" class="lightlink2 leftlink" target="main"><?php echo $admtext['trees']; ?></a>
  <?php
  if (!$assignedbranch) {
    ?>
      <a href="admin_branches.php" class="lightlink2 leftlink" target="main"><?php echo $admtext['branches']; ?></a>
    <?php
  }
  ?>
    <a href="admin_eventtypes.php" class="lightlink2 leftlink" target="main"><?php echo $admtext['customeventtypes']; ?></a>
    <a href="admin_reports.php" class="lightlink2 leftlink" target="main"><?php echo $admtext['reports']; ?></a>
    <a href="admin_dna_tests.php" class="lightlink2 leftlink" target="main"><?php echo $admtext['dna_tests']; ?></a>
    <a href="admin_languages.php" class="lightlink2 leftlink" target="main"><?php echo $admtext['languages']; ?></a>
    <a href="admin_utilities.php" class="lightlink2 leftlink" target="main"><?php echo $admtext['backuprestore']; ?></a>
    <a href="admin_modhandler.php" class="lightlink2 leftlink" target="main"><?php echo $admtext['modmgr']; ?></a>
  <?php
}
?>
<strong><a href="<?php echo $home_url; ?>" class="lightlink2 leftlink" target="main"><?php echo $admtext['publichome']; ?>
        <br/><span class="smaller"><?php echo $admtext['inframe']; ?></span></a></strong>

</body>
</html>
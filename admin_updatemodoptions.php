<?php
// updated 1 May 2014 by Ken Roy
//		- to add Display Affected Files list as Table (default) or Comma Separated Values
//		- to add Sort List By Mod Name or Config File Name (default)
// updated 8 May 2014 by Ken Roy
//		- to add Bypass Confirmations (defaults to No)
//		- to add Bypass Action Messages (defaults to No)
// updated 11 May 2014 by Ken Roy
//		- to add Show List in Batch option to control Affected Files List in Batch Updates popup

include "begin.php";
include "adminlib.php";
$textpart = "mods";
include "getlang.php";
include "$mylanguage/admintext.php";
//	$link = tng_db_connect($database_host,$database_name,$database_username,$database_password);
//echo __FILE__,' ',__LINE__;print_r($_POST);exit;

if (!count($_POST['options'])) {
  header("Location: admin_main.php");
  exit;
}
$options = $_POST['options'];

$admin_login = 1;
include "checklogin.php";
include "version.php";

if ($assignedtree || !$allow_edit) {
  $message = $admtext['norights'];
  header("Location: admin_login.php?message=" . urlencode($message));
  exit;
}

// when saving options revert to sort order specified in options
if (isset($_SESSION['sortby'])) {
  unset($_SESSION['sortby']);
}

require "adminlog.php";
$optionsfile = $subroot . 'mmconfig.php';
if (!is_writeable($optionsfile)) {
  $_SESSION['err_msg'] = "{$admtext['checkwrite']} {$admtext['cantwrite']} $optionsfile !";
  header("Location: admin_modhandler.php");  // restored to new Mod Manager screen KCR 140504
} else {
  //$optionsfile = "classes/mod.class.config.php";

  $optionstring = "<?php";
  foreach ($options as $key => $value) {
    $optionstring .= "\n\$options['$key'] = \"$value\";";
  }
  $optionstring .= "\n?>";
  file_put_contents($optionsfile, $optionstring);

  adminwritelog($admtext['modifyoptions']);

  header("Location: admin_modhandler.php");  // restored to new Mod Manager screen KCR 140504
}


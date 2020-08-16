<?php
include("begin.php");
include("adminlib.php");
$textpart = "misc";
//include("getlang.php");
include("$mylanguage/admintext.php");

$admin_login = 1;
include("checklogin.php");
include("version.php");

if ($assignedtree) {
  $message = $admtext['norights'];
  header("Location: admin_login.php?message=" . urlencode($message));
  exit;
}

$helplang = findhelp("misc_help.php");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['misc'], $flags);
?>
</head>

<body background="img/background.gif">

<?php
$misctabs[0] = array(1, "admin_misc.php", $admtext['menu'], "misc");
$misctabs[1] = array(1, "admin_whatsnewmsg.php", $admtext['whatsnew'], "whatsnew");
$misctabs[2] = array(1, "admin_mostwanted.php", $admtext['mostwanted'], "mostwanted");
$misctabs[3] = array(1, "admin_data_validation.php", $admtext['dataval'], "validation");
$innermenu = "<a href=\"#\" onclick=\"return openHelp('$helplang/misc_help.php');\" class=\"lightlink\">{$admtext['help']}</a>";
$menu = doMenu($misctabs, "misc", $innermenu);
echo displayHeadline($admtext['misc'], "img/misc_icon.gif", $menu, $message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <p class="subhead"><img src="img/tng_expand.gif" width="15" height="15" border="0"/> <a href="admin_whatsnewmsg.php"><b><?php echo $admtext['whatsnew']; ?></b></a><br/>
                <span class="normal miscmenu"><?php echo $admtext['whatsnewblurb']; ?></span></p>
            <p class="subhead"><img src="img/tng_expand.gif" width="15" height="15" border="0"/> <a href="admin_mostwanted.php"><b><?php echo $admtext['mostwanted']; ?></b></a><br/>
                <span class="normal miscmenu"><?php echo $admtext['mwblurb']; ?></span></p>
            <p class="subhead"><img src="img/tng_expand.gif" width="15" height="15" border="0"/> <a href="admin_data_validation.php"><b><?php echo $admtext['dataval']; ?></b></a><br/>
                <span class="normal miscmenu"><?php echo $admtext['dvblurb']; ?></span></p>
            <br/><br/><br/><br/><br/><br/>
        </td>
    </tr>

</table>
</div>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
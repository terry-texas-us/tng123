<?php
include "begin.php";
include "adminlib.php";
$textpart = "reports";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";

if ($assignedtree) {
  $message = $admtext['norights'];
  header("Location: admin_login.php?message=" . urlencode($message));
  exit;
}

$file = "$rootpath/whatsnew.txt";

$contents = @file($file);

$whatsnew_url = getURL("whatsnew", 0);
$helplang = findhelp("misc_help.php");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['whatsnew'], $flags);
?>
<script type="text/javascript">
    //<![CDATA[
    <?php
    include "niceditmsgs.php";
    ?>
    //]]>
</script>
</head>

<body background="img/background.gif">

<?php
$misctabs[0] = array(1, "admin_misc.php", $admtext['menu'], "misc");
$misctabs[1] = array(1, "admin_whatsnewmsg.php", $admtext['whatsnew'], "whatsnew");
$misctabs[2] = array(1, "admin_mostwanted.php", $admtext['mostwanted'], "mostwanted");
$misctabs[3] = array(1, "admin_data_validation.php", $admtext['dataval'], "validation");
$innermenu = "<a href=\"#\" onclick=\"return openHelp('$helplang/misc_help.php#add');\" class=\"lightlink\">{$admtext['help']}</a>";
$innermenu .= " &nbsp;|&nbsp; <a href=\"$whatsnew_url\" target=\"_blank\" class=\"lightlink\">{$admtext['test']}</a>";
$menu = doMenu($misctabs, "whatsnew", $innermenu);
echo displayHeadline($admtext['misc'] . " &gt;&gt; " . $admtext['whatsnew'], "img/misc_icon.gif", $menu, "");
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <form action="admin_savewhatsnewmsg.php" method="post" name="form1">
                <p class="subhead"><strong><?php echo $admtext['wnmsg']; ?>:</strong></p>
                <p class="normal" id="savedmsg" style="<?php if ($color) {
                  echo "color:$color;";
                } else echo "display:none;" ?>"><i><?php echo $message; ?></i></p>
                <textarea cols="150" rows="20" name="whatsnewmsg" id="whatsnewmsg"><?php if (is_array($contents)) {
                    foreach ($contents as $line) {
                      echo $line;
                    }
                  } ?></textarea><br/>
                <input type="submit" name="submit" accesskey="s" class="btn" value="<?php echo $admtext['save']; ?>">
            </form>
        </td>
    </tr>

</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
<script type="text/javascript" src="js/nicedit.js"></script>
<script type="text/javascript">
    //<![CDATA[
    bkLib.onDomLoaded(function () {
        new nicEditor({fullPanel: true}).panelInstance('whatsnewmsg');
    });
    //]]>
</script>
</body>
</html>
<?php
include "begin.php";
include "genlib.php";
$maint = $tngconfig['maint'];
$tngconfig['maint'] = "";
include "adminlib.php";
$textpart = "index";
include "$mylanguage/admintext.php";
$admin_login = 2;

if ($link) {
    include "checklogin.php";
}
include "version.php";

$home_url = $homepage;

$helplang = findhelp("index_help.php");
if ($sitever == "mobile") {
    $tng_title = $tng_abbrev;
}
$style->addSelector("table", ["width" => "100%", "border-collapse" => "separate", "border-spacing" => "0px"]);
$style->addSelector("table td", ["padding" => "1px"]);
tng_adminheader($admtext['administration'], "");
echo $style->getStyle();
echo "</head>\n";
?>
    <body class="sideback">
    <table>
        <tr>
            <td>
                <h4 class="whiteheader"><?php echo "$tng_title, v.$tng_version" . ($maint ? " <small class='yellow'>{$text['mainton']}</small>" : ""); ?></h4>
            </td>
            <td style="float: right;">
                <?php
                if ($link) {
                    if ($allow_admin) {
                        $trees = explode(',', $_SESSION['availabletrees']);
                        if (count($trees) > 1) {
                            $query = "";
                            foreach ($trees as $tree) {
                                if ($query) {
                                    $query .= " UNION ";
                                }
                                $query .= "SELECT gedcom, treename FROM $trees_table WHERE gedcom = '$tree'";
                            }
                            $query .= " ORDER BY treename";
                            $result = tng_query($query);
                            echo "<form action='switchtree.php' target='_parent' name='newtreeform' style='display:inline-block;'>\n";
                            echo "<input type='hidden' name='ret' value='admin.php'>\n";
                            echo "<select name='newtree' class='normal' onChange=\"document.newtreeform.submit();\">\n";
                            while ($row = tng_fetch_assoc($result)) {
                                echo "<option value='{$row['gedcom']}'";
                                if ($assignedtree == $row['gedcom']) {
                                    echo " selected";
                                }
                                echo ">{$row['treename']}</option>\n";
                            }
                            echo "</select>\n";
                            echo "</form>\n";
                            tng_free_result($result);
                        }
                    }
                    if ($chooselang) {
                        $query = "SELECT languageID, display, folder FROM $languages_table ORDER BY display";
                        $result = @tng_query($query);
                        if ($result && tng_num_rows($result)) {
                            echo "<form name='language' action='admin_savelanguage.php' method='get' target='_parent' style='display:inline-block;'>\n";
                            echo "<select class='normal' name='newlanguage' onChange='document.language.submit();'>\n";

                            while ($row = tng_fetch_assoc($result)) {
                                echo "<option value='{$row['languageID']}'";
                                if ($languages_path . $row['folder'] == $mylanguage) {
                                    echo " selected";
                                }
                                echo ">{$row['display']}</option>\n";
                            }
                            echo "</select>\n";
                            echo "</form>\n";
                            tng_free_result($result);
                        }
                    }
                }
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="whitetext normal">
                <a class="lightlink" href="admin.php" target="_parent"><?php echo $admtext['adminhome']; ?></a>&nbsp;|&nbsp;
                <a class="lightlink" href="<?php echo $home_url; ?>" target="_parent"><?php echo $admtext['publichome']; ?></a>&nbsp;|&nbsp;
                <?php if ($allow_admin) { ?>
                    <a class="lightlink" href="adminshowlog.php" target="main"><?php echo $admtext['showlog']; ?></a>&nbsp;|&nbsp;
                <?php } ?>
                <?php if ($sitever != "mobile") { ?>
                    <a class="lightlink" href="#"
                       onclick="return openHelp('<?php echo $helplang; ?>/index_help.php');"><?php echo $admtext['getstart']; ?></a>&nbsp;|&nbsp;
                    <a class="lightlink" href="https://tng.lythgoes.net/wiki" target="_blank">TNG Wiki</a>&nbsp;|&nbsp;
                    <a class="lightlink" href="https://tng.community" target="_blank">TNG Forum</a>&nbsp;|&nbsp;
                <?php } ?>
                <a class="lightlink" href="logout.php?admin_login=1"
                   target="_parent"><?php echo $admtext['logout'] . "&nbsp; (<strong>$currentuser</strong>)"; ?></a>
            </td>
        </tr>
    </table>
    </body>
<?php echo "</html>"; ?>
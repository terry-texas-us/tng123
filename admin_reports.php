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

$showreport_url = "showreport.php?";

$tng_search_reports = $_SESSION['tng_search_reports'] = 1;
if ($newsearch) {
    $exptime = 0;
    $searchstring = stripslashes(trim($searchstring));
    setcookie("tng_search_reports_post[search]", $searchstring, $exptime);
    setcookie("tng_search_reports_post[activeonly]", $activeonly, $exptime);
    setcookie("tng_search_reports_post[tngpage]", 1, $exptime);
    setcookie("tng_search_reports_post[offset]", 0, $exptime);
} else {
    if (!$searchstring) {
        $searchstring = $_COOKIE['tng_search_reports_post']['search'];
    }
    if (!$activeonly) {
        $activeonly = $_COOKIE['tng_search_reports_post']['activeonly'];
    }
    if (!isset($offset)) {
        $tngpage = $_COOKIE['tng_search_reports_post']['tngpage'];
        $offset = $_COOKIE['tng_search_reports_post']['offset'];
    } else {
        $exptime = 0;
        setcookie("tng_search_reports_post[tngpage]", $tngpage, $exptime);
        setcookie("tng_search_reports_post[offset]", $offset, $exptime);
    }
}

if ($offset) {
    $offsetplus = $offset + 1;
    $newoffset = "$offset, ";
} else {
    $offsetplus = 1;
    $newoffset = "";
    $tngpage = 1;
}

$wherestr = "";
if ($searchstring) {
    $wherestr .= "(reportname LIKE \"%$searchstring%\" OR reportdesc LIKE \"%$searchstring%\")";
}
if ($activeonly) {
    if ($wherestr) {
        $wherestr .= " AND ";
    }
    $wherestr .= "active = \"1\"";
}
if ($wherestr) {
    $wherestr = "WHERE " . $wherestr;
}

$query = "SELECT reportID, reportname, reportdesc, ranking, active FROM $reports_table $wherestr ORDER BY ranking, reportname, reportID LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);

$numrows = tng_num_rows($result);
if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $query = "SELECT count(reportID) AS rcount FROM $reports_table $wherestr";
    $result2 = tng_query($query);
    $row = tng_fetch_assoc($result2);
    $totrows = $row['rcount'];
    tng_free_result($result2);
} else {
    $totrows = $numrows;
}

$helplang = findhelp("reports_help.php");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['reports'], $flags);
?>
<script type="text/javascript">
    function confirmDelete(ID) {
        if (confirm('<?php echo $admtext['confreportdelete']; ?>'))
            deleteIt('report', ID);
        return false;
    }
</script>
<script type="text/javascript" src="js/admin.js"></script>
</head>

<body background="img/background.gif">

<?php
$reporttabs['0'] = array(1, "admin_reports.php", $admtext['search'], "findreport");
$reporttabs['1'] = array($allow_add, "admin_newreport.php", $admtext['addnew'], "addreport");
$innermenu = "<a href=\"#\" onclick=\"return openHelp('$helplang/reports_help.php');\" class=\"lightlink\">{$admtext['help']}</a>";
$menu = doMenu($reporttabs, "findreport", $innermenu);
echo displayHeadline($admtext['reports'], "img/reports_icon.gif", $menu, $message);
?>

<table width="100%" cellpadding="10" cellspacing="2" class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <div class="normal">

                <form action="admin_reports.php" name="form1">
                    <table>
                        <tr>
                            <td><span class="normal"><?php echo $admtext['searchfor']; ?>: </span></td>
                            <td><input type="text" name="searchstring" value="<?php echo $searchstring; ?>" class="longfield"></td>
                            <td>
                                <input type="submit" name="submit" value="<?php echo $admtext['search']; ?>" class="aligntop">
                                <input type="submit" name="submit" value="<?php echo $admtext['reset']; ?>" onClick="document.form1.searchstring.value='';" class="aligntop">
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;
                            </td>
                            <td colspan="2">
				<span class="normal">
				<input type="checkbox" name="activeonly" value="yes"<?php if ($activeonly == "yes") {
                    echo " checked";
                } ?>> <?php echo $admtext['activeonly']; ?>
				</span>
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" name="newsearch" value="1">
                </form>
                <br>

                <?php
                $numrowsplus = $numrows + $offset;
                if (!$numrowsplus) {
                    $offsetplus = 0;
                }
                echo displayListLocation($offsetplus, $numrowsplus, $totrows);
                $pagenav = get_browseitems_nav($totrows, "admin_reports.php?searchstring=$searchstring&amp;offset", $maxsearchresults, 5);
                echo " &nbsp; <span class=\"adminnav\">$pagenav</span></p>";
                ?>

                <table cellpadding="3" cellspacing="1" class="normal">
                    <tr>
                        <th class="fieldnameback fieldname"><?php echo $admtext['action']; ?></th>
                        <th class="fieldnameback fieldname"><?php echo $admtext['rank']; ?></th>
                        <th class="fieldnameback fieldname"><?php echo $admtext['id']; ?></th>
                        <th class="fieldnameback fieldname"><?php echo $admtext['name'] . ", " . $admtext['description']; ?></th>
                        <th class="fieldnameback fieldname"><?php echo $admtext['active']; ?>?</th>
                    </tr>

                    <?php
                    if ($numrows) {
                    $actionstr = "";
                    if ($allow_edit) {
                        $actionstr .= "<a href=\"admin_editreport.php?reportID=xxx\" title=\"{$admtext['edit']}\" class=\"smallicon admin-edit-icon\"></a>";
                    }
                    if ($allow_delete) {
                        $actionstr .= "<a href=\"#\" onClick=\"return confirmDelete('xxx');\" title=\"{$admtext['text_delete']}\" class=\"smallicon admin-delete-icon\"></a>";
                    }
                    $actionstr .= "<a href=\"$showreport_url" . "reportID=xxx&amp;test=1\" target=\"_blank\" title=\"{$admtext['test']}\" class=\"smallicon admin-test-icon\"></a>";

                    while ($row = tng_fetch_assoc($result)) {
                        $active = $row['active'] ? $admtext['yes'] : $admtext['no'];
                        $newactionstr = preg_replace("/xxx/", $row['reportID'], $actionstr);
                        $editlink = "admin_editreport.php?reportID={$row['reportID']}";
                        $id = $allow_edit ? "<a href=\"$editlink\" title=\"{$admtext['edit']}\">" . $row['reportID'] . "</a>" : $row['reportID'];
                        $name = $allow_edit ? "<a href=\"$editlink\" title=\"{$admtext['edit']}\">" . $row['reportname'] . "</a>" : $row['reportname'];

                        echo "<tr id=\"row_{$row['reportID']}\"><td class='lightback' valign=\"top\"><div class=\"action-btns\">$newactionstr</div></td>\n";
                        echo "<td class='lightback' valign=\"top\">&nbsp;{$row['ranking']}</td>\n";
                        echo "<td class='lightback' valign=\"top\">&nbsp;$id&nbsp;</td>\n";
                        echo "<td class='lightback' valign=\"top\">&nbsp;<u>$name</u><br>&nbsp;{$row['reportdesc']}</span></td>\n";
                        echo "<td class='lightback' valign=\"top\" align=\"center\">&nbsp;$active</td></tr>\n";
                    }
                    ?>
                </table>
            <?php
            echo displayListLocation($offsetplus, $numrowsplus, $totrows);
            echo " &nbsp; <span class=\"adminnav\">$pagenav</span></p>";
            }
            else {
                echo $admtext['norecords'];
            }
            tng_free_result($result);
            ?>

            </div>
        </td>
    </tr>

</table>
</div>
<?php echo "<div align=\"right\"><span class='normal'>$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
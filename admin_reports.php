<?php

include "begin.php";
include "adminlib.php";
require_once "admin/pagination.php";
$textpart = "reports";
include "$mylanguage/admintext.php";
$admin_login = 1;
include "checklogin.php";
include "version.php";
if ($assignedtree) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
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
    if ($wherestr) $wherestr .= " AND ";

    $wherestr .= "active = '1'";
}
if ($wherestr) $wherestr = "WHERE " . $wherestr;


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

tng_adminheader(_('Reports'), $flags);
?>
    <script>
        function confirmDelete(ID) {
            if (confirm('<?php echo _('Are you sure you want to delete this report?'); ?>'))
                deleteIt('report', ID);
            return false;
        }
    </script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$reporttabs['0'] = [1, "admin_reports.php", _('Search'), "findreport"];
$reporttabs['1'] = [$allow_add, "admin_newreport.php", _('Add New'), "addreport"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/reports_help.php');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($reporttabs, "findreport", $innermenu);
echo displayHeadline(_('Reports'), "img/reports_icon.gif", $menu, $message);
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <div class="normal">

                    <form action="admin_reports.php" name="form1">
                        <table>
                            <tr>
                                <td><span class="normal"><?php echo _('Search for'); ?>: </span></td>
                                <td>
                                    <input class="longfield" name="searchstring" type="search" value="<?php echo $searchstring; ?>">
                                </td>
                                <td>
                                    <input type="submit" name="submit" value="<?php echo _('Search'); ?>" class="align-top">
                                    <input type="submit" name="submit" value="<?php echo _('Reset'); ?>" onClick="document.form1.searchstring.value='';" class="align-top">
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;
                                </td>
                                <td colspan="2">
				<span class="normal">
				<input type="checkbox" name="activeonly" value="yes"<?php if ($activeonly == "yes") {
                    echo " checked";
                } ?>> <?php echo _('Active only'); ?>
				</span>
                                </td>
                            </tr>
                        </table>
                        <input type="hidden" name="newsearch" value="1">
                    </form>
                    <?php
                    $numrowsplus = $numrows + $offset;
                    if (!$numrowsplus) $offsetplus = 0;
                    ?>

                    <table class="normal">
                        <tr>
                            <th class="fieldnameback fieldname"><?php echo _('Action'); ?></th>
                            <th class="fieldnameback fieldname"><?php echo _('Rank'); ?></th>
                            <th class="fieldnameback fieldname"><?php echo _('ID'); ?></th>
                            <th class="fieldnameback fieldname"><?php echo _('Name') . ", " . _('Description'); ?></th>
                            <th class="fieldnameback fieldname"><?php echo _('Active'); ?>?</th>
                        </tr>

                        <?php
                        if ($numrows) {
                        $actionstr = "";
                        if ($allow_edit) {
                            $actionstr .= "<a href=\"admin_editreport.php?reportID=xxx\" title=\"" . _('Edit') . "\" class='smallicon admin-edit-icon'></a>";
                        }
                        if ($allow_delete) {
                            $actionstr .= "<a href='#' onClick=\"return confirmDelete('xxx');\" title=\"" . _('Delete') . "\" class='smallicon admin-delete-icon'></a>";
                    }
                        $actionstr .= "<a href=\"showreport.php?reportID=xxx&amp;test=1\" target='_blank' title=\"" . _('Test') . "\" class='smallicon admin-test-icon'></a>";

                    while ($row = tng_fetch_assoc($result)) {
                        $active = $row['active'] ? _('Yes') : _('No');
                        $newactionstr = preg_replace("/xxx/", $row['reportID'], $actionstr);
                        $editlink = "admin_editreport.php?reportID={$row['reportID']}";
                        $id = $allow_edit ? "<a href=\"$editlink\" title=\"" . _('Edit') . "\">" . $row['reportID'] . "</a>" : $row['reportID'];
                        $name = $allow_edit ? "<a href=\"$editlink\" title=\"" . _('Edit') . "\">" . $row['reportname'] . "</a>" : $row['reportname'];
                        echo "<tr id=\"row_{$row['reportID']}\"><td class='lightback'><div class='action-btns'>$newactionstr</div></td>\n";
                        echo "<td class='lightback'>&nbsp;{$row['ranking']}</td>\n";
                        echo "<td class='lightback'>&nbsp;$id&nbsp;</td>\n";
                        echo "<td class='lightback'>&nbsp;<u>$name</u><br>&nbsp;{$row['reportdesc']}</span></td>\n";
                        echo "<td class='lightback text-center'>&nbsp;$active</td></tr>\n";
                    }
                    ?>
                </table>
            <?php
            echo "<div class='w-full class=lg:flex my-6'>";
            echo getPaginationLocationHtml($offsetplus, $numrowsplus, $totrows);
            echo getPaginationControlsHtml($totrows, "admin_reports.php?searchstring=$searchstring&amp;offset", $maxsearchresults, 3);
            echo "</div>";
            }
            else {
                echo _('No records exist.');
            }
            tng_free_result($result);
            ?>

            </div>
        </td>
    </tr>

</table>
    </div>
<?php echo tng_adminfooter(); ?>
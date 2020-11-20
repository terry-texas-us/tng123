<?php
include "begin.php";
include "adminlib.php";

include "checklogin.php";

require_once "./core/html/addCriteria.php";

$tng_search_cemeteries = $_SESSION['tng_search_cemeteries'];
$tng_search_cemeteries_post = $_SESSION['tng_search_cemeteries_post'];
if ($findcemetery) {
    $tng_search_cemeteries = $_SESSION['tng_search_cemeteries'] = 1;
    $tng_search_cemeteries_post = $_SESSION['tng_search_cemeteries_post'] = $_POST;
} else {
    if ($tng_search_cemeteries) {
        foreach ($_SESSION['tng_search_cemeteries_post'] as $key => $value) {
            ${$key} = $value;
        }
    }
}

if ($exactmatch == "yes") {
    $frontmod = "=";
} else {
    $frontmod = "LIKE";
}

$allwhere = "WHERE 1=0";

if ($cemeteryID == "yes") {
    $allwhere .= addCriteria("$cemeteries_table.cemeteryID", $searchstring, $frontmod);
}

if ($maplink == "yes") {
    $allwhere .= addCriteria("maplink", $searchstring, $frontmod);
}

if ($cemname == "yes") {
    $allwhere .= addCriteria("cemname", $searchstring, $frontmod);
}

if ($city == "yes") {
    $allwhere .= addCriteria("city", $searchstring, $frontmod);
}

if ($state == "yes") {
    $allwhere .= addCriteria("state", $searchstring, $frontmod);
}

if ($county == "yes") {
    $allwhere .= addCriteria("county", $searchstring, $frontmod);
}

if ($country == "yes") {
    $allwhere .= addCriteria("country", $searchstring, $frontmod);
}

$query = "SELECT cemeteryID,cemname,city,county,state,country FROM $cemeteries_table $allwhere ORDER BY cemname, city, county, state, country";
$result = tng_query($query);

$numrows = tng_num_rows($result);

if (!$numrows) {
    $message = _('No results found. Please try again.');
    header("Location: cemeteries.php?message=" . urlencode($message));
    exit;
}

$helplang = findhelp("cemeteries_help.html");

tng_adminheader(_('Edit Existing Cemetery'), "");
echo "</head>\n";
echo tng_adminlayout();
?>
<div class="text-center">
    <table class="lightback w-full" cellpadding="5">
        <tr class="fieldnameback">
            <td>
                <img src="cemeteries_icon.gif" width="40" height="40" style="border-width=1px;border-style=solid;" align="right">
                <span class="whiteheader mt-0 text-base" style="font-size: large; "><?php echo _('Edit Existing Cemetery'); ?></span>
            </td>
        </tr>
        <?php if ($message) { ?>
            <tr>
                <td>
                    <span class="normal" style="color: #f00;"><em><?php echo urldecode($message); ?></em></span>
                </td>
            </tr>
        <?php } ?>
        <tr class="databack">
            <td>
                <span class="subhead"><strong><?php echo _('Select Cemetery and Action'); ?></strong>  | <a href="#"
                        onclick="return openHelp('<?php echo $helplang; ?>/cemeteries_help.html#find', 'newwindow', 'height=500,width=600,resizable=yes,scrollbars=yes'); newwindow.focus();"><?php echo _('Help for this area'); ?></a></span><br><br>
                <span class="normal">
	&nbsp;&nbsp;<img src="img/tng_edit.gif" alt="<?php echo _('Edit'); ?>" width="16" height="15"
                        align="middle"> = <?php echo _('Edit'); ?> &nbsp;&nbsp;
	<img src="img/tng_delete.gif" alt="<?php echo _('Delete'); ?>" width="20" height="20"
        align="middle"> = <?php echo _('Delete'); ?>
	<br>
<?php
echo "<p>" . _('Matches') . ": $numrows</p>";
?>
	</span>
                <table cellpadding="3" cellspacing="1" border="0">
                    <tr>
                        <th class="fieldnameback"><span class="fieldname"><?php echo _('Action'); ?></span></th>
                        <th class="fieldnameback"><span class="fieldname"><?php echo _('ID'); ?></span></th>
                        <th class="fieldnameback"><span class="fieldname"><?php echo _('Cemetery'); ?></span></th>
                        <th class="fieldnameback"><span class="fieldname"><?php echo _('Location'); ?></span></th>
                    </tr>

                    <?php
                    $rowcount = 0;
                    $actionstr = "";
                    if ($allow_edit) {
                        $actionstr .= "<a href=\"admin_editcemetery.php?cemeteryID=xxx\"><img src=\"tng_edit.gif\" alt=\"" . _('Edit') . "\" width=\"16\" height=\"16\" vspace=0 hspace=2></a>";
                    }
                    if ($allow_delete) {
                        $actionstr .= "<a href=\"deletecemetery.php?cemeteryID=xxx\" onClick=\"return confirm('" . _('Are you sure you want to delete this cemetery?') . "' );\"><img src=\"tng_delete.gif\" alt=\"" . _('Delete') . "\" width=\"16\" height=\"16\" vspace=0 hspace=2></a>";
                    }

                    while ($rowcount < $numrows && $row = tng_fetch_assoc($result)) {
                        $rowcount++;
                        $location = cemeteryPlace($row);
                        $newactionstr = preg_replace("/xxx/", $row['cemeteryID'], $actionstr);
                        echo "<tr>\n";
                        echo "<td class='lightback'><span class='normal'>{$newactionstr}</span></td>\n";
                        echo "<td class='lightback'><span class='normal'>{$row['cemeteryID']}</span></td>";
                        echo "<td class='lightback'><span class='normal'>{$row['cemname']}</span></td>\n";
                        echo "<td class='lightback'><span class='normal'>$location</span></td>\n";
                        echo "</tr>\n";
                    }
                    tng_free_result($result);

                    ?>
                </table>
            </td>
        </tr>

    </table>
</div>
<?php echo tng_adminfooter(); ?>

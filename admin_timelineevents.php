<?php
include "begin.php";
include "adminlib.php";
$textpart = "timeline";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";

$tng_search_tlevents = $_SESSION['tng_search_tlevents'] = 1;
if ($newsearch) {
    $exptime = 0;
    $searchstring = stripslashes(trim($searchstring));
    setcookie("tng_search_tlevents_post[search]", $searchstring, $exptime);
    setcookie("tng_search_tlevents_post[tngpage]", 1, $exptime);
    setcookie("tng_search_tlevents_post[offset]", 0, $exptime);
} else {
    if (!$searchstring) {
        $searchstring = stripslashes($_COOKIE['tng_search_tlevents_post']['search']);
    }
    if (!isset($offset)) {
        $tngpage = $_COOKIE['tng_search_tlevents_post']['tngpage'];
        $offset = $_COOKIE['tng_search_tlevents_post']['offset'];
    } else {
        $exptime = 0;
        setcookie("tng_search_tlevents_post[tngpage]", $tngpage, $exptime);
        setcookie("tng_search_tlevents_post[offset]", $offset, $exptime);
    }
}
$searchstring_noquotes = preg_replace("/\"/", "&#34;", $searchstring);
$searchstring = addslashes($searchstring);

if ($offset) {
    $offsetplus = $offset + 1;
    $newoffset = "$offset, ";
} else {
    $offsetplus = 1;
    $newoffset = "";
    $tngpage = 1;
}

$wherestr = $searchstring ? "WHERE evyear LIKE \"%$searchstring%\" OR evtitle LIKE \"%$searchstring%\" OR evdetail LIKE \"%$searchstring%\"" : "";
$query = "SELECT tleventID, evyear, endyear, evtitle, evdetail FROM $tlevents_table $wherestr ORDER BY ABS(evyear), evmonth, evday LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);

$numrows = tng_num_rows($result);
if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $query = "SELECT count(tleventID) AS tlcount FROM $tlevents_table $wherestr";
    $result2 = tng_query($query);
    $row = tng_fetch_assoc($result2);
    $totrows = $row['tlcount'];
    tng_free_result($result2);
} else {
    $totrows = $numrows;
}

$helplang = findhelp("tlevents_help.php");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['tlevents'], $flags);

echo "</head>\n";
echo tng_adminlayout();

$timelinetabs[0] = [1, "admin_timelineevents.php", $admtext['search'], "findtimeline"];
$timelinetabs[1] = [$allow_add, "admin_newtlevent.php", $admtext['addnew'], "addtlevent"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/tlevents_help.php');\" class='lightlink'>{$admtext['help']}</a>";
$menu = doMenu($timelinetabs, "findtimeline", $innermenu);
echo displayHeadline($admtext['tlevents'], "img/tlevents_icon.gif", $menu, $message);
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <div class="normal">
                    <form action="admin_timelineevents.php" name="form1">
                        <?php echo $admtext['searchfor']; ?>:
                        <input class="longfield" name="searchstring" type="search" value="<?php echo $searchstring_noquotes; ?>">
                        <input type="hidden" name="findtlevent" value="1">
                        <input type="hidden" name="newsearch" value="1">
                        <input type="submit" name="submit" value="<?php echo $admtext['search']; ?>" class="aligntop">
                        <input type="submit" name="submit" value="<?php echo $admtext['reset']; ?>" onClick="document.form1.searchstring.value='';" class="aligntop">
                    </form>
                    <br>

                    <?php
                    $numrowsplus = $numrows + $offset;
                    if (!$numrowsplus) {
                    $offsetplus = 0;
                }
                echo displayListLocation($offsetplus, $numrowsplus, $totrows);
                $pagenav = get_browseitems_nav($totrows, "admin_timelineevents.php?searchstring=$searchstring&amp;offset", $maxsearchresults, 5);
                    echo " &nbsp; <span class='adminnav'>$pagenav</span></p>";
                ?>
                <form action="admin_deleteselected.php" method="post" name="form2">
                    <?php if ($allow_delete) { ?>
                        <p>
                            <input type="button" name="selectall" value="<?php echo $admtext['selectall']; ?>" onClick="toggleAll(1);">
                            <input type="button" name="clearall" value="<?php echo $admtext['clearall']; ?>" onClick="toggleAll(0);">
                            <input type="submit" name="xtimeaction" value="<?php echo $admtext['deleteselected']; ?>" onClick="return confirm('<?php echo $admtext['confdeleterecs']; ?>');">
                        </p>
                    <?php } ?>
                    <table class="normal">
                        <tr>
                            <th class="fieldnameback"><span class="fieldname"><?php echo $admtext['action']; ?></span></th>
                            <?php if ($allow_delete) { ?>
                                <th class="fieldnameback"><span class="fieldname"><?php echo $admtext['select']; ?></span></th>
                            <?php } ?>
                            <th class="fieldnameback fieldname"><?php echo $admtext['evyear']; ?></th>
                            <th class="fieldnameback fieldname"><?php echo $admtext['enddt']; ?></th>
                            <th class="fieldnameback fieldname"><?php echo $admtext['evtitle']; ?></th>
                            <th class="fieldnameback fieldname"><?php echo $admtext['evdetail']; ?></th>
                        </tr>
                        <?php
                        if ($numrows) {
                        $actionstr = "";
                        if ($allow_edit) {
                            $actionstr .= "<a href=\"admin_edittlevent.php?tleventID=xxx\" title=\"{$admtext['edit']}\" class='smallicon admin-edit-icon'></a>";
                        }
                        if ($allow_delete) {
                            $actionstr .= "<a href='#' onClick=\"if(confirm('{$admtext['confdeletetlevent']}' )){deleteIt('tlevent',xxx);} return false;\" title=\"{$admtext['text_delete']}\" class='smallicon admin-delete-icon'></a>";
                        }

                        while ($rowcount < $numrows && $row = tng_fetch_assoc($result)) {
                            $newactionstr = preg_replace("/xxx/", $row['tleventID'], $actionstr);
                            echo "<tr id=\"row_{$row['tleventID']}\"><td class='lightback'><div class=\"action-btns2\">$newactionstr</div></td>\n";
                            if ($allow_delete) {
                                echo "<td class='lightback text-center'><input type='checkbox' name=\"del{$row['tleventID']}\" value='1'></td>";
                            }
                            echo "<td class='lightback text-center'>{$row['evyear']}&nbsp;</td>\n";
                            echo "<td class='lightback text-center'>{$row['endyear']}&nbsp;</td>";
                            echo "<td class='lightback'>{$row['evtitle']}&nbsp;</td>";
                            echo "<td class='lightback'>{$row['evdetail']}&nbsp;</td></tr>\n";
                        }
                        ?>
                    </table>
                <?php
                echo displayListLocation($offsetplus, $numrowsplus, $totrows);
                echo " &nbsp; <span class='adminnav'>$pagenav</span></p>";
                }
                else {
                    echo $admtext['norecords'];
                }
                tng_free_result($result);
                ?>
                </form>

                </div>
            </td>
        </tr>
    </table>
<?php echo tng_adminfooter(); ?>
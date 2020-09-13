<?php
include "begin.php";
include $subroot . "mapconfig.php";
include "adminlib.php";
$textpart = "cemeteries";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
$tng_search_cemeteries = $_SESSION['tng_search_cemeteries'] = 1;
if ($newsearch) {
    $exptime = 0;
    setcookie("tng_search_cemeteries_post[search]", $searchstring, $exptime);
    setcookie("tng_search_cemeteries_post[offset]", 0, $exptime);
    setcookie("tng_search_cemeteries_post[tngpage]", 1, $exptime);
    setcookie("tng_search_cemeteries_post[offset]", 0, $exptime);
} else {
    if (!$searchstring) {
        $searchstring = stripslashes($_COOKIE['tng_search_cemeteries_post']['search']);
    }
    if (!isset($offset)) {
        $tngpage = $_COOKIE['tng_search_cemeteries_post']['tngpage'];
        $offset = $_COOKIE['tng_search_cemeteries_post']['offset'];
    } else {
        $exptime = 0;
        setcookie("tng_search_cemeteries_post[tngpage]", $tngpage, $exptime);
        setcookie("tng_search_cemeteries_post[offset]", $offset, $exptime);
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

function addCriteria($field, $value, $operator) {
    $criteria = "";

    if ($operator == "=") {
        $criteria = " OR $field $operator \"$value\"";
    } else {
        $innercriteria = "";
        $terms = explode(' ', $value);
        foreach ($terms as $term) {
            if ($innercriteria) {
                $innercriteria .= " AND ";
            }
            $innercriteria .= "$field $operator \"%$term%\"";
        }
        if ($innercriteria) {
            $criteria = " OR ($innercriteria)";
        }
    }

    return $criteria;
}

$showmap_url = getURL("showmap", 1);
$frontmod = "LIKE";
$allwhere = "WHERE 1=0";

$allwhere .= addCriteria("$cemeteries_table.cemeteryID", $searchstring, $frontmod);
$allwhere .= addCriteria("maplink", $searchstring, $frontmod);
$allwhere .= addCriteria("cemname", $searchstring, $frontmod);
$allwhere .= addCriteria("city", $searchstring, $frontmod);
$allwhere .= addCriteria("state", $searchstring, $frontmod);
$allwhere .= addCriteria("county", $searchstring, $frontmod);
$allwhere .= addCriteria("country", $searchstring, $frontmod);

$query = "SELECT cemeteryID,cemname,city,county,state,country,latitude,longitude,zoom FROM $cemeteries_table $allwhere ORDER BY cemname, city, county, state, country LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);

$numrows = tng_num_rows($result);
if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $query = "SELECT count(cemeteryID) AS ccount FROM $cemeteries_table $allwhere";
    $result2 = tng_query($query);
    $row = tng_fetch_assoc($result2);
    $totrows = $row['ccount'];
    tng_free_result($result2);
} else {
    $totrows = $numrows;
}

$helplang = findhelp("cemeteries_help.php");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['cemeteries'], $flags);
?>
<script type="text/javascript">
    function confirmDelete(ID) {
        if (confirm('<?php echo $admtext['confdeletecem']; ?>'))
            deleteIt('cemetery', ID);
        return false;
    }
</script>
<script type="text/javascript" src="js/admin.js"></script>
</head>

<body background="img/background.gif">

<?php
$cemtabs[0] = array(1, "admin_cemeteries.php", $admtext['search'], "findcem");
$cemtabs[1] = array($allow_add, "admin_newcemetery.php", $admtext['addnew'], "addcemetery");
$innermenu = "<a href=\"#\" onclick=\"return openHelp('$helplang/cemeteries_help.php#modify');\" class=\"lightlink\">{$admtext['help']}</a>";
$menu = doMenu($cemtabs, "findcem", $innermenu);
echo displayHeadline($admtext['cemeteries'], "img/cemeteries_icon.gif", $menu, $message);
?>

<table width="100%" cellpadding="10" cellspacing="2" class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <div class="normal">

                <form action="admin_cemeteries.php" name="form1">
                    <table>
                        <tr>
                            <td><span class="normal"><?php echo $admtext['searchfor']; ?>: </span></td>
                            <td><input type="text" name="searchstring" value="<?php echo $searchstring_noquotes; ?>" class="longfield"></td>
                            <td>
                                <input type="submit" name="submit" value="<?php echo $admtext['search']; ?>" class="aligntop">
                                <input type="submit" name="submit" value="<?php echo $admtext['reset']; ?>" onClick="document.form1.searchstring.value='';" class="aligntop">
                            </td>
                        </tr>
                    </table>

                    <input type="hidden" name="findcemetery" value="1"><input type="hidden" name="newsearch" value="1">
                </form>
                <br>
                <?php
                $numrowsplus = $numrows + $offset;
                if (!$numrowsplus) {
                    $offsetplus = 0;
                }
                echo displayListLocation($offsetplus, $numrowsplus, $totrows);
                $pagenav = get_browseitems_nav($totrows, "admin_cemeteries.php?searchstring=$searchstring&amp;exactmatch=$exactmatch&amp;offset", $maxsearchresults, 5);
                echo " &nbsp; <span class=\"adminnav\">$pagenav</span></p>";
                ?>
                <form action="admin_deleteselected.php" method="post" name="form2">
                    <?php
                    if ($allow_delete) {
                        ?>
                        <p>
                            <input type="button" name="selectall" value="<?php echo $admtext['selectall']; ?>" onClick="toggleAll(1);">
                            <input type="button" name="clearall" value="<?php echo $admtext['clearall']; ?>" onClick="toggleAll(0);">
                            <input type="submit" name="xcemaction" value="<?php echo $admtext['deleteselected']; ?>" onClick="return confirm('<?php echo $admtext['confdeleterecs']; ?>');">
                        </p>
                        <?php
                    }
                    ?>

                    <table cellpadding="3" cellspacing="1" class="normal">
                        <tr>
                            <th class="fieldnameback fieldname"><?php echo $admtext['action']; ?></th>
                            <?php if ($allow_delete) { ?>
                                <th class="fieldnameback fieldname"><?php echo $admtext['select']; ?></th>
                            <?php } ?>
                            <th class="fieldnameback fieldname"><?php echo $admtext['cemetery']; ?></th>
                            <th class="fieldnameback fieldname"><?php echo $admtext['location']; ?></th>
                            <?php if ($map['key']) { ?>
                                <th class="fieldnameback fieldname"><?php echo $admtext['googleplace']; ?></th>
                            <?php } else { ?>
                                <th class="fieldnameback fieldname"><?php echo $admtext['latitude']; ?></th>
                                <th class="fieldnameback fieldname"><?php echo $admtext['longitude']; ?></th>
                            <?php } ?>
                        </tr>

                        <?php
                        if ($numrows) {
                        $actionstr = "";
                        if ($allow_edit) {
                            $actionstr .= "<a href=\"admin_editcemetery.php?cemeteryID=xxx\" title=\"{$admtext['edit']}\" class=\"smallicon admin-edit-icon\"></a>";
                        }
                        if ($allow_delete) {
                            $actionstr .= "<a href=\"#\" onClick=\"return confirmDelete('xxx');\" title=\"{$admtext['text_delete']}\" class=\"smallicon admin-delete-icon\"></a>";
                        }
                        $actionstr .= "<a href=\"" . $showmap_url . "cemeteryID=xxx&amp\" target=\"_blank\" title=\"{$admtext['test']}\" class=\"smallicon admin-test-icon\"></a>";

                        while ($row = tng_fetch_assoc($result)) {
                            $location = $row['city'];
                            if ($row['county']) {
                                if ($location) {
                                    $location .= ", ";
                                }
                                $location .= $row['county'];
                            }
                            if ($row['state']) {
                                if ($location) {
                                    $location .= ", ";
                                }
                                $location .= $row['state'];
                            }
                            if ($row['country']) {
                                if ($location) {
                                    $location .= ", ";
                                }
                                $location .= $row['country'];
                            }

                            $newactionstr = preg_replace("/xxx/", $row['cemeteryID'], $actionstr);
                            echo "<tr id=\"row_{$row['cemeteryID']}\"><td class='lightback' valign=\"top\"><div class=\"action-btns\">$newactionstr</div></td>\n";
                            if ($allow_delete) {
                                echo "<td class='lightback' valign=\"top\" align=\"center\"><input type=\"checkbox\" name=\"del{$row['cemeteryID']}\" value=\"1\"></td>";
                            }
                            $editlink = "admin_editcemetery.php?cemeteryID={$row['cemeteryID']}";
                            $cemname = $allow_edit ? "<a href=\"$editlink\" title=\"{$admtext['edit']}\">" . $row['cemname'] . "</a>" : $row['cemname'];

                            echo "<td class='lightback' valign=\"top\">&nbsp;$cemname&nbsp;</td>\n";
                            echo "<td class='lightback' valign=\"top\">&nbsp;$location&nbsp;</td>\n";
                            if ($map['key']) {
                                echo "<td nowrap class='lightback' valign=\"top\">";
                                $geo = "";
                                if ($row['latitude']) {
                                    $geo .= "&nbsp;{$admtext['latitude']}: " . number_format($row['latitude'], 3);
                                }
                                if ($row['longitude']) {
                                    if ($geo) {
                                        $geo .= "<br>";
                                    }
                                    $geo .= "&nbsp;{$admtext['longitude']}: " . number_format($row['longitude'], 3);
                                }
                                if ($row['zoom']) {
                                    if ($geo) {
                                        $geo .= "<br>";
                                    }
                                    $geo .= "&nbsp;{$admtext['zoom']}: " . $row['zoom'];
                                }
                                echo "$geo&nbsp;</td>\n";
                            } else {
                                echo "<td class='lightback' valign=\"top\">&nbsp;{$row['latitude']}&nbsp;</td>\n";
                                echo "<td class='lightback' valign=\"top\">&nbsp;{$row['longitude']}&nbsp;</td></tr>\n";
                            }
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
                </form>

            </div>
        </td>
    </tr>
</table>
<?php echo "<div align=\"right\"><span class='normal'>$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
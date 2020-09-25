<?php
include "begin.php";
include "adminlib.php";
$textpart = "people";
include "$mylanguage/admintext.php";

$admin_login = true;
include "checklogin.php";
include "version.php";
$varlist = array('newsearch', 'searchstring', 'tree', 'living', 'private', 'exactmatch', 'nokids', 'noparents', 'nospouse');
foreach ($varlist as $myvar) {
    if (!isset(${$myvar})) {
        ${$myvar} = "";
    }
}

$exptime = 0;
if ($newsearch) {
    setcookie("tng_search_people_post[search]", $searchstring, $exptime);
    setcookie("tng_search_people_post[tree]", $tree, $exptime);
    setcookie("tng_search_people_post[living]", $living, $exptime);
    setcookie("tng_search_people_post[private]", $private, $exptime);
    setcookie("tng_search_people_post[exactmatch]", $exactmatch, $exptime);
    setcookie("tng_search_people_post[nokids]", $nokids, $exptime);
    setcookie("tng_search_people_post[noparents]", $noparents, $exptime);
    setcookie("tng_search_people_post[nospouse]", $nospouse, $exptime);
    setcookie("tng_search_people_post[tngpage]", 1, $exptime);
    setcookie("tng_search_people_post[offset]", 0, $exptime);
} else {
    if (!$searchstring && isset($_COOKIE['tng_search_people_post']['search'])) {
        $searchstring = stripslashes($_COOKIE['tng_search_people_post']['search']);
    }
    if (!$tree && isset($_COOKIE['tng_search_people_post']['tree'])) {
        $tree = $_COOKIE['tng_search_people_post']['tree'];
    }
    if (!$living && isset($_COOKIE['tng_search_people_post']['living'])) {
        $living = $_COOKIE['tng_search_people_post']['living'];
    }
    if (!$private && isset($_COOKIE['tng_search_people_post']['private'])) {
        $private = $_COOKIE['tng_search_people_post']['private'];
    }
    if (!$exactmatch && isset($_COOKIE['tng_search_people_post']['exactmatch'])) {
        $exactmatch = $_COOKIE['tng_search_people_post']['exactmatch'];
    }
    if (!$nokids && isset($_COOKIE['tng_search_people_post']['nokids'])) {
        $nokids = $_COOKIE['tng_search_people_post']['nokids'];
    }
    if (!$noparents && isset($_COOKIE['tng_search_people_post']['noparents'])) {
        $noparents = $_COOKIE['tng_search_people_post']['noparents'];
    }
    if (!$nospouse && isset($_COOKIE['tng_search_people_post']['nospouse'])) {
        $nospouse = $_COOKIE['tng_search_people_post']['nospouse'];
    }
    if (!isset($offset)) {
        $tngpage = isset($_COOKIE['tng_search_people_post']['tngpage']) ? $_COOKIE['tng_search_people_post']['tngpage'] : 1;
        $offset = isset($_COOKIE['tng_search_people_post']['offset']) ? $_COOKIE['tng_search_people_post']['offset'] : 0;
    } else {
        setcookie("tng_search_people_post[tngpage]", $tngpage, $exptime);
        setcookie("tng_search_people_post[offset]", $offset, $exptime);
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

if ($assignedtree) {
    $wherestr = "WHERE gedcom = \"$assignedtree\"";
    $tree = $assignedtree;
} else {
    $wherestr = "";
}
$orgtree = $tree;

$uquery = "SELECT COUNT(userID) AS ucount FROM $users_table WHERE allow_living = '-1'";
$uresult = tng_query($uquery) or die ($admtext['cannotexecutequery'] . ": $uquery");
$urow = tng_fetch_assoc($uresult);
$numusers = $urow['ucount'];
tng_free_result($uresult);

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

if ($tree) {
    $allwhere = "people.gedcom = \"$tree\" AND people.gedcom = trees.gedcom ";
} else {
    $allwhere = "people.gedcom = trees.gedcom ";
}
if ($assignedbranch) {
    $allwhere .= " AND people.branch LIKE \"%$assignedbranch%\"";
}

if ($searchstring) {
    $allwhere .= " AND (1=0";
    if ($exactmatch == "yes") {
        $frontmod = "=";
    } else {
        $frontmod = "LIKE";
    }

    $allwhere .= addCriteria("people.personID", $searchstring, $frontmod);
    $allwhere .= addCriteria("CONCAT_WS(' ',TRIM(firstname)" . ($lnprefixes ? ",TRIM(lnprefix)" : "") . ",TRIM(lastname))", $searchstring, $frontmod);
    $allwhere .= ")";
}
if ($living == "yes") {
    $allwhere .= " AND people.living = \"1\"";
}
if ($private == "yes") {
    $allwhere .= " AND people.private = \"1\"";
}

if ($noparents) {
    $noparentjoin = "LEFT JOIN $children_table noparents ON people.personID = noparents.personID AND people.gedcom = noparents.gedcom";
    $allwhere .= " AND noparents.familyID is NULL";
} else {
    $noparentjoin = "";
}

if ($nospouse) {
    $nospousejoin = "LEFT JOIN $families_table nospousef ON people.personID = nospousef.husband AND people.gedcom = nospousef.gedcom ";
    $nospousejoin .= "LEFT JOIN $families_table nospousem ON people.personID = nospousem.wife AND people.gedcom = nospousem.gedcom";
    $allwhere .= " AND nospousef.familyID is NULL AND nospousem.familyID is NULL";
} else {
    $nospousejoin = "";
}

if ($nokids) {
    $nokidjoin = "LEFT OUTER JOIN $families_table familiesH ON people.gedcom=familiesH.gedcom AND people.personID=familiesH.husband ";
    $nokidjoin .= "LEFT OUTER JOIN $families_table familiesW ON people.gedcom=familiesW.gedcom AND people.personID=familiesW.wife ";
    $nokidjoin .= "LEFT OUTER JOIN $children_table childrenH ON familiesH.gedcom=childrenH.gedcom AND familiesH.familyID=childrenH.familyID ";
    $nokidjoin .= "LEFT OUTER JOIN $children_table AS childrenW ON familiesW.gedcom=childrenW.gedcom AND familiesW.familyID=childrenW.familyID ";
    $nokidhaving = "HAVING ChildrenCount = 0 ";
    $nokidgroup = "GROUP BY people.personID, people.lastname, people.firstname, people.firstname, people.lnprefix, ";
    $nokidgroup .= "people.prefix, people.suffix, people.nameorder, people.birthdate, birthyear, people.birthplace, people.altbirthdate, altbirthyear, ";
    $nokidgroup .= "people.altbirthplace, people.gedcom, trees.treename ";
    $nokidselect = ", SUM((childrenH.familyID is not NULL) + (childrenW.familyID is not NULL)) AS ChildrenCount ";
    $nokidgroup2 = "GROUP BY people.personID, people.lastname, people.firstname, people.firstname, people.lnprefix ";
} else {
    $nokidjoin = "";
    $nokidhaving = "";
    $nokidgroup = "";
    $nokidselect = "";
}

$query = "SET SQL_BIG_SELECTS=1";
$result = tng_query($query);

$query = "SELECT people.ID, people.personID, lastname, firstname, lnprefix, prefix, suffix, nameorder, birthdate, LPAD(SUBSTRING_INDEX(birthdate, ' ', -1),4,'0') AS birthyear, birthplace, altbirthdate, LPAD(SUBSTRING_INDEX(altbirthdate, ' ', -1),4,'0') AS altbirthyear, altbirthplace, people.gedcom AS gedcom, treename, people.changedby, DATE_FORMAT(people.changedate,\"%d %b %Y\") AS changedate $nokidselect ";
$query .= "FROM ($people_table people, $trees_table trees) $nokidjoin $noparentjoin $nospousejoin ";
$query .= "WHERE $allwhere $nokidgroup $nokidhaving ";
$query .= "ORDER BY lastname, lnprefix, firstname, birthyear, altbirthyear ";
$query .= "LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);

$numrows = tng_num_rows($result);
if ($numrows == $maxsearchresults || $offsetplus > 1) {
    if ($nokids) {
        $query = "SELECT people.ID, people.personID, lastname, firstname, lnprefix $nokidselect ";
        $query .= "FROM ($people_table people, $trees_table trees) $nokidjoin $noparentjoin $nospousejoin ";
        $query .= "WHERE $allwhere $nokidgroup2 $nokidhaving";
        $result2 = tng_query($query);
        $totrows = tng_num_rows($result2);
    } else {
        $query = "SELECT count(people.personID) AS pcount ";
        $query .= "FROM ($people_table people, $trees_table trees) $noparentjoin $nospousejoin ";
        $query .= "WHERE $allwhere";
        $result2 = tng_query($query);
        $row = tng_fetch_assoc($result2);
        $totrows = $row['pcount'];
    }
    tng_free_result($result2);
} else {
    $totrows = $numrows;
}

$helplang = findhelp("people_help.php");

$revstar = checkReview("I");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['people'], $flags);
?>
<script type="text/javascript">
    function confirmDelete(ID) {
        if (confirm('<?php echo $admtext['confdeletepers']; ?>'))
            deleteIt('person', ID, '<?php echo $tree; ?>');
        return false;
    }

    function resetPeople() {
        document.form1.searchstring.value = '';
        document.form1.tree.selectedIndex = 0;
        document.form1.living.checked = false;
        document.form1.private.checked = false;
        document.form1.exactmatch.checked = false;
        document.form1.nokids.checked = false;
        document.form1.noparents.checked = false;
        document.form1.nospouse.checked = false;
    }
</script>
<script type="text/javascript" src="js/admin.js"></script>
</head>

<body class="admin-body">

<?php
$peopletabs['0'] = array(1, "admin_people.php", $admtext['search'], "findperson");
$peopletabs['1'] = array($allow_add, "admin_newperson.php", $admtext['addnew'], "addperson");
$peopletabs['2'] = array($allow_edit, "admin_findreview.php?type=I", $admtext['review'] . $revstar, "review");
$peopletabs['3'] = array($allow_edit && $allow_delete, "admin_merge.php", $admtext['merge'], "merge");
$innermenu = "<a href=\"#\" onclick=\"return openHelp('$helplang/people_help.php');\" class=\"lightlink\">{$admtext['help']}</a>";
$menu = doMenu($peopletabs, "findperson", $innermenu);
if (!isset($message)) {
    $message = '';
}
echo displayHeadline($admtext['people'], "img/people_icon.gif", $menu, $message);
?>

<table class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <div class="normal">

                <form action="admin_people.php" name="form1">
                    <table>
                        <tr>
                            <td><span class="normal"><?php echo $admtext['searchfor']; ?>: </span></td>
                            <td>
                                <?php
                                include "treequery.php";
                                ?>
                                <input type="text" name="searchstring" value="<?php echo $searchstring_noquotes; ?>" class="longfield">
                            </td>
                            <td>
                                <input type="submit" name="submit" value="<?php echo $admtext['search']; ?>" class="aligntop">
                                <input type="submit" name="submit" value="<?php echo $admtext['reset']; ?>" onclick="resetPeople();" class="aligntop">
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;
                            </td>
                            <td colspan="2">
				<span class="normal">
				<input type="checkbox" name="living" value="yes"<?php if ($living == "yes") {
                    echo " checked";
                } ?>> <?php echo $admtext['livingonly']; ?>
				<input type="checkbox" name="private" value="yes"<?php if ($private == "yes") {
                    echo " checked";
                } ?>> <?php echo $admtext['privateonly']; ?>
				<input type="checkbox" name="exactmatch" value="yes"<?php if ($exactmatch == "yes") {
                    echo " checked";
                } ?>> <?php echo $admtext['exactmatch']; ?>
				<input type="checkbox" name="nokids" value="yes"<?php if ($nokids == "yes") {
                    echo " checked";
                } ?>> <?php echo $admtext['nokids']; ?>
				<input type="checkbox" name="noparents" value="yes"<?php if ($noparents == "yes") {
                    echo " checked";
                } ?>> <?php echo $admtext['noparents']; ?>
				<input type="checkbox" name="nospouse" value="yes"<?php if ($nospouse == "yes") {
                    echo " checked";
                } ?>> <?php echo $admtext['nospouse']; ?>
				</span>
                            </td>
                        </tr>
                    </table>

                    <input type="hidden" name="findperson" value="1">
                    <input type="hidden" name="newsearch" value="1">
                </form>
                <br>

                <?php
                $numrowsplus = $numrows + $offset;
                if (!$numrowsplus) {
                    $offsetplus = 0;
                }
                echo displayListLocation($offsetplus, $numrowsplus, $totrows);
                $pagenav = get_browseitems_nav($totrows, "admin_people.php?searchstring=$searchstring&amp;living=$living&amp;private=$private&amp;exactmatch=$exactmatch&amp;offset", $maxsearchresults, 5);
                echo " &nbsp; <span class=\"adminnav\">$pagenav</span></p>";
                ?>
                <form action="admin_deleteselected.php" method="post" name="form2">
                    <?php
                    if ($allow_delete) {
                        ?>
                        <p>
                            <input type="button" name="selectall" value="<?php echo $admtext['selectall']; ?>" onClick="toggleAll(1);">
                            <input type="button" name="clearall" value="<?php echo $admtext['clearall']; ?>" onClick="toggleAll(0);">
                            <input type="submit" name="xperaction" value="<?php echo $admtext['deleteselected']; ?>" onClick="return confirm('<?php echo $admtext['confdeleterecs']; ?>');">
                        </p>
                        <?php
                    }
                    ?>

                    <table class="normal">
                        <tr>
                            <th class="fieldnameback"><span class="fieldname"><?php echo $admtext['action']; ?></span></th>
                            <?php if ($allow_delete) { ?>
                                <th class="fieldnameback"><span class="fieldname"><?php echo $admtext['select']; ?></span></th>
                            <?php } ?>
                            <th class="fieldnameback"><span class="fieldname"><?php echo $admtext['id']; ?></span></th>
                            <th class="fieldnameback"><span class="fieldname"><?php echo $admtext['name']; ?></span></th>
                            <th class="fieldnameback"><span class="fieldname"><?php echo $admtext['birthdate']; ?></span></th>
                            <th class="fieldnameback"><span class="fieldname"><?php echo $admtext['birthplace']; ?></span></th>
                            <?php if ($numtrees > 1) { ?>
                                <th class="fieldnameback"><span class="fieldname"><?php echo $admtext['tree']; ?></span></th>
                                <?php
                            }
                            if ($numusers > 1) {
                                ?>
                                <th class="fieldnameback"><span class="fieldname"><?php echo $admtext['lastmodified']; ?></span></th>
                            <?php } ?>
                        </tr>

                        <?php
                        if ($numrows) {
                        $actionstr = "";
                        if ($allow_edit) {
                            $actionstr .= "<a href=\"admin_editperson.php?personID=xxx&amp;tree=yyy\" title=\"{$admtext['edit']}\" class=\"smallicon admin-edit-icon\"></a>";
                        }
                        if ($allow_delete) {
                            $actionstr .= "<a href=\"#\" onclick=\"return confirmDelete('zzz');\" title=\"{$admtext['text_delete']}\" class=\"smallicon admin-delete-icon\"></a>";
                        }
                        $actionstr .= "<a href=\"getperson.php?personID=xxx&amp;tree=yyy\" target='_blank' title=\"{$admtext['test']}\" class=\"smallicon admin-test-icon\"></a>";

                        while ($row = tng_fetch_assoc($result)) {
                            $rights = determineLivingPrivateRights($row);
                            $row['allow_living'] = $rights['living'];
                            $row['allow_private'] = $rights['private'];
                            if ($row['birthdate']) {
                                $birthdate = $admtext['birthabbr'] . " " . $row['birthdate'];
                                $birthplace = $row['birthplace'];
                            } else {
                                if ($row['altbirthdate']) {
                                    $birthdate = $admtext['chrabbr'] . " " . $row['altbirthdate'];
                                    $birthplace = $row['altbirthplace'];
                                } else {
                                    $birthdate = "";
                                    $birthplace = $row['birthplace'] ? $row['birthplace'] : $row['altbirthplace'];
                                }
                            }
                            $newactionstr = preg_replace("/xxx/", $row['personID'], $actionstr);
                            $newactionstr = preg_replace("/yyy/", $row['gedcom'], $newactionstr);
                            $newactionstr = preg_replace("/zzz/", $row['ID'], $newactionstr);
                            $editlink = "admin_editperson.php?personID={$row['personID']}&amp;tree={$row['gedcom']}";
                            if ($allow_edit) {
                                $id = "<a href=\"$editlink\" title=\"{$admtext['edit']}\">" . $row['personID'] . "</a>";
                            } else {
                                $id = $row['personID'];
                            }
                            echo "<tr id=\"row_{$row['ID']}\"><td class='lightback'><div class=\"action-btns\">$newactionstr</div></td>\n";
                            if ($allow_delete) {
                                echo "<td class='lightback text-center'><input type=\"checkbox\" name=\"del{$row['ID']}\" value='1'></td>";
                            }
                            echo "<td class='lightback'><span class='normal'>&nbsp;$id&nbsp;</span></td>\n";
                            echo "<td class='lightback'><span class='normal'>&nbsp;" . getName($row) . "&nbsp;</span></td>\n";
                            echo "<td class='lightback'><span class='normal'>&nbsp;$birthdate&nbsp;</span></td>\n";
                            echo "<td class='lightback'><span class='normal'>&nbsp;$birthplace&nbsp;</span></td>\n";
                            if ($numtrees > 1) {
                                echo "<td class='lightback'><span class='normal'>&nbsp;{$row['treename']}&nbsp;</span></td>\n";
                            }
                            if ($numusers > 1) {
                                echo "<td class='lightback'><span class='normal'>&nbsp;{$row['changedby']}: {$row['changedate']}&nbsp;</span></td>\n";
                            }
                            echo "</tr>\n";
                        }
                        ?>
                    </table>
                <?php
                echo displayListLocation($offsetplus, $numrowsplus, $totrows);
                echo " &nbsp; <span class=\"adminnav\">$pagenav</span></p>";
                }
                else {
                    echo "</table>\n" . $admtext['norecords'];
                }
                tng_free_result($result);
                ?>
                </form>

            </div>
        </td>
    </tr>
</table>
<?php echo "<div style=\"text-align: center;\"><span class='normal'>$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
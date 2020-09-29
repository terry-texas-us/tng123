<?php
include "begin.php";
include "adminlib.php";
$textpart = "misc";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";

$reports = ['wr_gender', 'unk_gender', 'marr_young', 'marr_aft_death', 'marr_bef_birth', 'died_bef_birth', 'parents_younger', 'children_late', 'not_living', 'not_dead'];
if (!$report || !in_array($report, $reports)) {
    header("Location: admin_data_validation.php");
    exit;
}

$helplang = findhelp("misc_help.php");
$orgtree = $tree;

$flags['tabs'] = $tngconfig['tabs'];
// TODO text ['validation'] was not defined in any language. Manually added here.
tng_adminheader(_todo_('Validation'), $flags);

echo "</head>\n";
echo tng_adminlayout();

$misctabs[0] = [1, "admin_misc.php", $admtext['menu'], "misc"];
$misctabs[1] = [1, "admin_whatsnewmsg.php", $admtext['whatsnew'], "whatsnew"];
$misctabs[2] = [1, "admin_mostwanted.php", $admtext['mostwanted'], "mostwanted"];
$misctabs[3] = [1, "admin_data_validation.php", $admtext['dataval'], "validation"];
$misctabs[4] = [1, "admin_valreport.php?report=$report&amp;tree=$tree", $admtext['report'], "report"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/mostwanted_help.php');\" class='lightlink'>{$admtext['help']}</a>";
$innermenu .= " &nbsp;|&nbsp; <a href=\"mostwanted.php\" target='_blank' class='lightlink'>{$admtext['test']}</a>";
$menu = doMenu($misctabs, "report", $innermenu);
echo displayHeadline($admtext['misc'] . " &gt;&gt; " . $admtext['dataval'] . " &gt;&gt; " . $admtext[$report], "img/misc_icon.gif", $menu, $message);

$query = "";
$nameFields = "$people_table.personID, $people_table.lastname, $people_table.firstname, $people_table.lnprefix, $people_table.prefix, $people_table.suffix, $people_table.nameorder, $people_table.living, $people_table.private, $people_table.branch, $people_table.gedcom";
$hNameFields = "h.personID AS hpersonID, h.lastname AS hlastname, h.firstname AS hfirstname, h.lnprefix AS hlnprefix, h.prefix AS hprefix, h.suffix AS hsuffix, h.nameorder AS hnameorder, h.living AS hliving, h.private AS hprivate, h.branch AS hbranch, h.gedcom AS hgedcom";
$wNameFields = "w.personID AS wpersonID, w.lastname AS wlastname, w.firstname AS wfirstname, w.lnprefix AS wlnprefix, w.prefix AS wprefix, w.suffix AS wsuffix, w.nameorder AS wnameorder, w.living AS wliving, w.private AS wprivate, w.branch AS wbranch, w.gedcom AS wgedcom";

if ($offset) {
    $offsetplus = $offset + 1;
    $newoffset = "$offset, ";
} else {
    $offsetplus = 1;
    $newoffset = "";
    $tngpage = 1;
}

$tree = $assignedtree ? $assignedtree : $tree;
$treestr = $tree ? "AND $people_table.gedcom = '$tree'" : "";
$orderby = "";

switch ($report) {
    case "wr_gender":
        //select from families, join husb and wife with people, return entries where husband is not male or wife is not female, show person and spouse
        $select1a = "SELECT $nameFields, sex, familyID ";
        $select1b = $select2b = "SELECT count($people_table.personID) AS pcount ";
        $query1 = "FROM $families_table, $people_table
				WHERE $people_table.gedcom = $families_table.gedcom AND $people_table.personID = $families_table.husband AND sex != 'M' $treestr
				UNION ";
        $select2a = "SELECT $nameFields, sex, familyID ";
        $query2 = "FROM $families_table, $people_table
				WHERE $people_table.gedcom = $families_table.gedcom AND $people_table.personID = $families_table.wife AND sex != 'F' $treestr ";
        $orderby = "ORDER BY lastname, firstname";
        $display = ['personid', 'name', 'sex', 'familyid', 'treeid'];
        $values = ['personID', 'name', 'sex', 'familyID', 'gedcom'];
        break;
    case "unk_gender":
        $select1a = "SELECT $nameFields, sex ";
        $select1b = "SELECT count($people_table.personID) AS pcount ";
        $query1 = "FROM $people_table
				WHERE (sex = \"\" OR sex = \"U\") $treestr ";
        $orderby = "ORDER BY lastname, firstname";
        $select2a = $select2b = $query2 = "";
        $display = ['personid', 'name', 'sex', 'treeid'];
        $values = ['personID', 'name', 'sex', 'gedcom'];
        break;
    case "marr_young":
        //select from families, join husb and wife with people, return entries where husb younger than 15 at marriage or wife younger than 15 at marriage, show person and spouse
        $select1a = "SELECT $nameFields, familyID, birthdate, marrdate ";
        $select1b = $select2b = "SELECT count($people_table.personID) AS pcount ";
        $query1 = "FROM $families_table, $people_table
				WHERE $people_table.gedcom = $families_table.gedcom AND $people_table.personID = $families_table.husband 
					AND marrdatetr != '0000-00-00' AND birthdatetr < marrdatetr AND marrdatetr < DATE_ADD(birthdatetr, interval 15 year) $treestr
				UNION ";
        $select2a = "SELECT $nameFields, familyID, birthdate, marrdate ";
        $query2 = "FROM $families_table, $people_table
				WHERE $people_table.gedcom = $families_table.gedcom AND $people_table.personID = $families_table.wife 
					AND marrdatetr != '0000-00-00' AND birthdatetr < marrdatetr AND marrdatetr < DATE_ADD(birthdatetr, interval 15 year) $treestr ";
        $orderby = "ORDER BY lastname, firstname";
        $display = ['personid', 'name', 'birthdate', 'marriagedate', 'treeid'];
        $values = ['personID', 'name', 'birthdate', 'marrdate', 'gedcom'];
        break;
    case "marr_aft_death":
        //select from families, join husb and wife with people, return entries were husb death before marriage date or wife death before marriage date, show person and marriage info
        $select1a = "SELECT $nameFields, familyID, deathdate, marrdate ";
        $select1b = $select2b = "SELECT count($people_table.personID) AS pcount ";
        $query1 = "FROM $families_table, $people_table
				WHERE $people_table.gedcom = $families_table.gedcom AND $people_table.personID = $families_table.husband 
					AND deathdatetr != '0000-00-00' AND marrdatetr != '0000-00-00' AND marrdatetr > deathdatetr $treestr
				UNION ";
        $select2a = "SELECT $nameFields, familyID, deathdate, marrdate ";
        $query2 = "FROM $families_table, $people_table
				WHERE $people_table.gedcom = $families_table.gedcom AND $people_table.personID = $families_table.wife 
					AND deathdatetr != '0000-00-00' AND marrdatetr != '0000-00-00' AND marrdatetr > deathdatetr $treestr ";
        $orderby = "ORDER BY lastname, firstname";
        $display = ['personid', 'name', 'marriagedate', 'deathdate', 'treeid'];
        $values = ['personID', 'name', 'marrdate', 'deathdate', 'gedcom'];
        break;
    case "marr_bef_birth":
        //select from families, join husb and wife with people, return entries where husb birth after marriage date or wife birth after marriage date, show person and marriage info
        $select1a = "SELECT $nameFields, familyID, birthdate, marrdate ";
        $select1b = $select2b = "SELECT count($people_table.personID) AS pcount ";
        $query1 = "FROM $families_table, $people_table
				WHERE $people_table.gedcom = $families_table.gedcom AND $people_table.personID = $families_table.husband 
					AND marrdatetr != '0000-00-00' AND marrdatetr < birthdatetr $treestr
				UNION ";
        $select2a = "SELECT $nameFields, familyID, birthdate, marrdate ";
        $query2 = "FROM $families_table, $people_table
				WHERE $people_table.gedcom = $families_table.gedcom AND $people_table.personID = $families_table.wife 
					AND marrdatetr != '0000-00-00' AND marrdatetr < birthdatetr $treestr ";
        $orderby = "ORDER BY lastname, firstname";
        $display = ['personid', 'name', 'birthdate', 'marriagedate', 'treeid'];
        $values = ['personID', 'name', 'birthdate', 'marrdate', 'gedcom'];
        break;
    case "died_bef_birth":
        //select from people, return entries where death date is before birth date, show person and info
        $select1a = "SELECT $nameFields, birthdate, deathdate ";
        $select1b = "SELECT count($people_table.personID) AS pcount ";
        $query1 = "FROM $people_table
				WHERE deathdatetr != '0000-00-00' AND deathdatetr < birthdatetr $treestr ";
        $orderby = "ORDER BY lastname, firstname";
        $display = ['personid', 'name', 'birthdate', 'deathdate', 'treeid'];
        $values = ['personID', 'name', 'birthdate', 'deathdate', 'gedcom'];
        break;
    case "parents_younger":
        //select from children, join child with people, join family with family, join husb and wife with people, return entries where child's birthdatetr is less than marriage date, show child and parent's info
        $select1a = "SELECT $nameFields, h.birthdate AS hbirthdate, w.birthdate AS wbirthdate, $people_table.birthdate, marrdate ";
        $select1b = "SELECT count($children_table.personID) AS pcount ";
        $query1 = "FROM $children_table, $people_table, $families_table ";
        $query1 .= "LEFT JOIN $people_table h ON $families_table.husband = h.personID AND $families_table.gedcom = h.gedcom ";
        $query1 .= "LEFT JOIN $people_table w ON $families_table.wife = w.personID AND $families_table.gedcom = w.gedcom ";
        $query1 .= "WHERE $children_table.personID = $people_table.personID AND $children_table.gedcom = $people_table.gedcom AND $children_table.familyID = $families_table.familyID AND $children_table.gedcom = $families_table.gedcom AND $people_table.birthdatetr != '0000-00-00' AND ((marrdatetr != '0000-00-00' AND $people_table.birthdatetr < marrdatetr) OR (h.birthdatetr != '0000-00-00' AND $people_table.birthdatetr < DATE_ADD(h.birthdatetr, interval 15 year)) OR (w.birthdatetr != '0000-00-00' AND $people_table.birthdatetr < DATE_ADD(w.birthdatetr, interval 15 year))) $treestr ";
        $orderby = "ORDER BY lastname, firstname";
        $select2a = $select2b = $query2 = "";
        $display = ['personid', 'name', 'birthdate', 'parmarr', 'treeid'];
        $values = ['personID', 'name', 'birthdate', 'marrdate', 'gedcom'];
        break;
    case "children_late":
        //select from children, join child with people, join family with family, join wife with people, return entries where wife's birthdatetr is more than 50 years later than child's birthdatetr, show child and parent's info
        $select1a = "SELECT $nameFields, w.birthdate AS wbirthdate, $people_table.birthdate, marrdate ";
        $select1b = "SELECT count($children_table.personID) AS pcount ";
        $query1 = "FROM $children_table, $people_table, $families_table ";
        $query1 .= "LEFT JOIN $people_table w ON $families_table.wife = w.personID AND $families_table.gedcom = w.gedcom ";
        $query1 .= "WHERE $children_table.personID = $people_table.personID AND $children_table.gedcom = $people_table.gedcom AND $children_table.familyID = $families_table.familyID AND $children_table.gedcom = $families_table.gedcom AND $people_table.birthdatetr != '0000-00-00' AND w.birthdatetr != '0000-00-00' AND $people_table.birthdatetr > DATE_ADD(w.birthdatetr, interval 50 year) $treestr ";
        $orderby = "ORDER BY lastname, firstname";
        $select2a = $select2b = $query2 = "";
        $display = ['personid', 'name', 'birthdate', 'motherbirth', 'treeid'];
        $values = ['personID', 'name', 'birthdate', 'wbirthdate', 'gedcom'];
        break;
    case "not_living":
        //select from people, return entries where living box is checked but person has death/burial info, show person and info
        $select1a = "SELECT $nameFields, birthdate, deathdate ";
        $select1b = "SELECT count($people_table.personID) AS pcount ";
        $query1 = "FROM $people_table
				WHERE living = 1 AND (deathdate != '' OR burialdate != '' OR deathplace != '' OR burialplace != '') $treestr ";
        $orderby = "ORDER BY lastname, firstname";
        $select2a = $select2b = $query2 = "";
        $display = ['personid', 'name', 'birthdate', 'deathdate', 'treeid'];
        $values = ['personID', 'name', 'birthdate', 'deathdate', 'gedcom'];
        break;
    case "not_dead":
        //select from people, return entries where living box is NOT checked but person has no death/burial info and birth is less than 110 years ago, show person and info
        $select1a = "SELECT $nameFields, birthdate, deathdate ";
        $select1b = "SELECT count($people_table.personID) AS pcount ";
        $query1 = "FROM $people_table
				WHERE living != 1 AND deathdate = '' AND burialdate = '' AND deathplace = '' AND burialplace = '' AND birthdate != '' 
					AND CURDATE() < DATE_ADD(birthdatetr, interval 110 year) $treestr ";
        $orderby = "ORDER BY lastname, firstname";
        $select2a = $select2b = $query2 = "";
        $display = ['personid', 'name', 'birthdate', 'deathdate', 'treeid'];
        $values = ['personID', 'name', 'birthdate', 'deathdate', 'gedcom'];
        break;
}
//add offset
$query = $select1a . $query1 . $select2a . $query2 . $orderby . " LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);

$numrows = tng_num_rows($result);
if ($numrows == $maxsearchresults || $offsetplus > 1) {
    //run same query with no limit to get total
    $query = $select1b . $query1 . $select2b . $query2;
    $result2 = tng_query($query);
    $totrows = 0;
    while ($row = tng_fetch_assoc($result2))
        $totrows += $row['pcount'];
    tng_free_result($result2);
} else {
    $totrows = $numrows;
}

$numrowsplus = $numrows + $offset;
if (!$numrowsplus) {
    $offsetplus = 0;
}
?>

<table class="lightback">
    <tr class="databack">
        <td class="tngshadow normal">
            <h3 class="subhead"><?php echo $admtext[$report]; ?></h3>
            <?php
            echo displayListLocation($offsetplus, $numrowsplus, $totrows);
            $pagenav = get_browseitems_nav($totrows, "admin_valreport.php?report=$report&amp;offset", $maxsearchresults, 5);
            echo " &nbsp; <span class='adminnav'>$pagenav</span></p>";
            ?>
            <table cellpadding="5" cellspacing="1" class="normal">
                <tr>
                    <?php
                    //show headers
                    for ($i = 0; $i < count($display); $i++) {
                        $header = $admtext[$display[$i]];
                        echo "<td class=\"fieldnameback fieldname\">&nbsp;<b>$header</b>&nbsp;</td>\n";
                    }
                    ?>
                </tr>
                <?php
                if ($numrows) {
                    while ($row = tng_fetch_assoc($result)) {
                        echo "<tr>\n";
                        //data
                        for ($i = 0; $i < count($values); $i++) {
                            if ($values[$i] == "name") {
                                $rights = determineLivingPrivateRights($row);
                                $row['allow_living'] = $rights['living'];
                                $row['allow_private'] = $rights['private'];
                                $value = "<a href=\"admin_editperson.php?personID={$row['personID']}&tree={$row['gedcom']}\" target='_blank'>" . getName($row) . "</a>";
                            } elseif ($values[$i] == "familyID") {
                                $value = "<a href=\"admin_editfamily.php?familyID={$row['familyID']}&tree={$row['gedcom']}\" target='_blank'>{$row['familyID']}</a>";
                            } elseif ($values[$i] == "personID") {
                                $value = "<a href=\"admin_editperson.php?personID={$row['personID']}&tree={$row['gedcom']}\" target='_blank'>{$row['personID']}</a>";
                            } else {
                                $value = $row[$values[$i]];
                            }
                            echo "<td class='lightback'>&nbsp;{$value}&nbsp;</td>\n";
                        }
                        echo "</tr>\n";
                    }
                    echo "</table>\n";
                    echo displayListLocation($offsetplus, $numrowsplus, $totrows);
                    echo " &nbsp; <span class='adminnav'>$pagenav</span></p>";
                } else {
                    echo "</table>\n" . $admtext['norecords'];
                }
                tng_free_result($result);
                ?>
            </table>

            <?php

            ?>
        </td>
    </tr>

</table>
<?php echo tng_adminfooter(); ?>
<?php

$textpart = "surnames";
@set_time_limit(0);
include "tng_begin.php";

$treestr = $tree ? " (" . _('Tree') . ": $tree)" : "";
$logstring = "<a href=\"firstnames-all.php?tree=$tree\">" . _('First Name List') . ": " . _('All First Names') . "$treestr</a>";
writelog($logstring);
preparebookmark($logstring);

tng_header("" . _('First Name List') . " - " . _('All First Names') . "", $flags);
?>
    <a id="top"></a>
    <h2 class="header"><span class="headericon" id="surnames-hdr-icon"></span><?php echo _('First Name List'); ?></h2>
    <br class="clearleft">
<?php
echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'firstnames-all', 'method' => 'get', 'name' => 'form1', 'id' => 'form1']);

$treestr = $orgtree ? "&amp;tree=$tree" : "";

$livingPrivateRestrictions = getLivingPrivateRestrictions($people_table, false, false);

$linkstr = "";
$nofirstname = urlencode(_('[no first name]'));
$query = "SELECT UCASE(LEFT(firstname, 1)) AS firstchar, UCASE($binary LEFT(firstname, 1) ) AS binfirstchar ";
$query .= "FROM $people_table ";
if ($tree) $query .= "WHERE gedcom = '$tree' ";

if ($livingPrivateRestrictions) {
    $query .= $tree ? "AND $livingPrivateRestrictions" : "WHERE $livingPrivateRestrictions ";
}
$query .= "GROUP BY binfirstchar ";
$query .= "ORDER by binfirstchar";
$result = tng_query($query);
if ($result) {
    $initialchar = 1;

    while ($firstname = tng_fetch_assoc($result)) {
        if ($initialchar != 1) $linkstr .= " ";

        if ($firstname['firstchar'] == "") {
            $firstname['firstchar'] = _('[no first name]');
            $linkstr .= "<a href=\"search.php?myfirstname=$nofirstname&amp;fnqualify=equals&amp;mybool=AND$treestr\" class='snlink rounded'>" . _('[no first name]') . "</a> ";
        } else {
            if ($firstname['firstchar'] != "_") {
                $linkstr .= "<a href=\"#char$initialchar\" class='snlink rounded'>{$firstname['firstchar']}</a>";
                $firstchars[$initialchar] = $firstname['firstchar'];
                $initialchar++;
            }
        }
    }
    tng_free_result($result);
}
?>

    <div class="titlebox rounded-lg normal">
        <h3 class="subhead"><?php echo _('Show first names starting with'); ?></h3>
        <p class="firstchars"><?php echo $linkstr; ?></p>
        <br><?php echo "<a href='firstnames.php'>" . _('Main first name page') . "</a>"; ?>
    </div>

    <br>
<?php
for ($scount = 1; $scount < $initialchar; $scount++) {
    echo "<a id=\"char$scount\"></a>\n";
    $urlfirstchar = addslashes($firstchars[$scount]);
    ?>
    <div class="titlebox rounded-lg">
        <h2 class="header"><?php echo $firstchars[$scount]; ?></h2>
        <table class="sntable">
            <tr>
                <td class="sncol align-top">
                    <?php
                    $firstnamestr = $lnprefixes ? "TRIM(CONCAT_WS(' ',lnprefix,firstname) )" : "firstname";
                    if ($tngconfig['ucfirstnames']) {
                        $firstnamestr = "UCASE($firstnamestr)";
                    }
                    $query = "SELECT UCASE( $binary $firstnamestr ) AS firstname, $firstnamestr AS lowername, UCASE($binary firstname) AS binlast, count(UCASE($binary firstname) ) AS lncount ";
                    $query .= "FROM $people_table ";
                    $query .= "WHERE UCASE($binary TRIM(firstname)) LIKE \"$urlfirstchar%\" ";
                    if ($tree) $query .= "AND gedcom = '$tree' ";

                    if ($livingPrivateRestrictions) {
                        $query .= "AND $livingPrivateRestrictions ";
                    }
                    $query .= "GROUP BY lowername ";
                    $query .= "ORDER by binlast";
                    $result = tng_query($query);
                    $topnum = tng_num_rows($result);
                    if ($result) {
                        $snnum = 1;
                        if (!isset($numcols) || $numcols > 5) $numcols = 5;
                        $num_in_col = ceil($topnum / $numcols);

                        $num_in_col_ctr = 0;
                        while ($firstname = tng_fetch_assoc($result)) {
                            $firstname2 = urlencode($firstname['firstname']);
                            $name = $firstname['firstname'] ? "<a href=\"search.php?myfirstname=$firstname2&amp;fnqualify=equals&amp;mybool=AND$treestr\">{$firstname['lowername']}</a>" : "<a href=\"search.php?myfirstname=$nofirstname&amp;fnqualify=equals&amp;mybool=AND$treestr\">" . _('[no first name]') . "</a>";
                            echo "$snnum. $name ({$firstname['lncount']})<br>\n";
                            $snnum++;
                            $num_in_col_ctr++;
                            if ($num_in_col_ctr == $num_in_col) {
                                echo "</td>\n";
                                echo "<td class='table-dblgutter'>&nbsp;&nbsp;</td>\n";
                                echo "<td class='sncol align-top'>";
                                $num_in_col_ctr = 0;
                            }
                        }
                        tng_free_result($result);
                    }
                    ?>
                </td>
            </tr>
        </table>
    </div>

    <br><p class="normal"><a href="#top"><?php echo _('Back to top'); ?></a></p><br>
    <?php
}
tng_footer("");
?>
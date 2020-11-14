<?php

$textpart = "surnames";
@set_time_limit(0);
include "tng_begin.php";

$treestr = $tree ? " (" . _('Tree') . ": $tree)" : "";
$logstring = "<a href=\"surnames-all.php?tree=$tree\">" . _('Surname List') . ": " . _('All Surnames') . "$treestr</a>";
writelog($logstring);
preparebookmark($logstring);

tng_header("" . _('Surname List') . " - " . _('All Surnames') . "", $flags);
?>
    <a id="top"></a>
    <h2 class="header"><span class="headericon" id="surnames-hdr-icon"></span><?php echo _('Surname List'); ?></h2><br class="clearleft">
<?php
echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'surnames-all', 'method' => 'get', 'name' => 'form1', 'id' => 'form1']);

if ($tree) {
    $wherestr = "WHERE gedcom = '$tree'";
    $wherestr2 = "AND gedcom = '$tree'";
} else {
    $wherestr = "";
    $wherestr2 = "";
}
$treestr = $orgtree ? "&amp;tree=$tree" : "";

$allwhere = getLivingPrivateRestrictions($people_table, false, false);

if ($allwhere) {
    $wherestr .= $wherestr ? " AND $allwhere" : "WHERE $allwhere";
    $wherestr2 .= " AND $allwhere";
}

$linkstr = "";
$nosurname = urlencode(_('[no surname]'));
$query = "SELECT UCASE(left(lastname, 1)) AS firstchar, UCASE($binary left(lastname,1)) AS binfirstchar FROM $people_table $wherestr GROUP BY binfirstchar ORDER by binfirstchar";
$result = tng_query($query);
if ($result) {
    $initialchar = 1;

    while ($surname = tng_fetch_assoc($result)) {
        if ($initialchar != 1) $linkstr .= " ";

        if ($surname['firstchar'] == "") {
            $surname['firstchar'] = _('[no surname]');
            $linkstr .= "<a href=\"search.php?mylastname=$nosurname&amp;lnqualify=equals&amp;mybool=AND$treestr\" class='snlink rounded'>" . _('[no surname]') . "</a> ";
        } else {
            if ($surname['firstchar'] != "_") {
                $linkstr .= "<a href=\"#char$initialchar\" class='snlink rounded'>{$surname['firstchar']}</a>";
                $firstchars[$initialchar] = $surname['firstchar'];
                $initialchar++;
            }
        }
    }
    tng_free_result($result);
}
?>
    <div class="titlebox rounded-lg normal">
        <h3 class="subhead"><?php echo _('Show surnames starting with'); ?></h3>
        <p class="firstchars"><?php echo $linkstr; ?></p>
        <br><?php echo "<a href='surnames.php'>" . _('Main surname page') . "</a>"; ?>
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
                    $surnamestr = $lnprefixes ? "TRIM(CONCAT_WS(' ',lnprefix,lastname) )" : "lastname";
                    if ($tngconfig['ucsurnames']) $surnamestr = "UCASE($surnamestr)";

                    $query = "SELECT UCASE($binary $surnamestr) AS lastname, $surnamestr AS lowername, UCASE($binary lastname) AS binlast, count(UCASE($binary lastname)) AS lncount ";
                    $query .= "FROM $people_table ";
                    $query .= "WHERE UCASE($binary TRIM(lastname)) LIKE \"$urlfirstchar%\" $wherestr2 ";
                    $query .= "GROUP BY lowername ";
                    $query .= "ORDER by binlast";
                    $result = tng_query($query);
                    $topnum = tng_num_rows($result);
                    if ($result) {
                        $snnum = 1;
                        if (!isset($numcols) || $numcols > 5) $numcols = 5;
                        $num_in_col = ceil($topnum / $numcols);

                        $num_in_col_ctr = 0;
                        while ($surname = tng_fetch_assoc($result)) {
                            $surname2 = urlencode($surname['lastname']);
                            $name = $surname['lastname'] ? "<a href=\"search.php?mylastname=$surname2&amp;lnqualify=equals&amp;mybool=AND$treestr\">{$surname['lowername']}</a>" : "<a href=\"search.php?mylastname=$nosurname&amp;lnqualify=equals&amp;mybool=AND$treestr\">" . _('[no surname]') . "</a>";
                            echo "$snnum. $name ({$surname['lncount']})<br>\n";
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
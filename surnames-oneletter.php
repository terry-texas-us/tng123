<?php

$textpart = "surnames";
@set_time_limit(0);
include "tng_begin.php";

$firstchar = mb_substr($firstchar, 0, 1, $charset);
$decodedfirstchar = stripslashes(urldecode($firstchar));

$treestr = $tree ? " (" . _('Tree') . ": $tree)" : "";
$logstring = "<a href=\"surnames-oneletter.php?firstchar=$firstchar&amp;tree=$tree\">" . xmlcharacters(_('Surname List') . ": " . _('Begins with') . " $decodedfirstchar$treestr") . "</a>";
writelog($logstring);
preparebookmark($logstring);

tng_header(_('Surname List') . ": " . _('Begins with') . " $decodedfirstchar", $flags);
?>
    <h2 class="header"><span class="headericon"
            id="surnames-hdr-icon"></span><?php echo _('Surname List') . ": " . _('Begins with') . " $decodedfirstchar"; ?></h2>
    <br class="clearleft">
<?php
$hiddenfields[] = ['name' => 'firstchar', 'value' => $firstchar];
echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'surnames-oneletter', 'method' => 'get', 'name' => 'form1', 'id' => 'form1', 'hidden' => $hiddenfields]);
?>
    <div class="titlebox rounded-lg">
        <div>
            <h3 class="subhead"><?php echo "" . _('All surnames beginning with') . " $decodedfirstchar, " . _('sorted alphabetically') . " (" . _('total individuals') . "):"; ?></h3>
            <p class="smaller"><?php echo _('Click on a surname to show matching records.') . "&nbsp;&nbsp;&nbsp;<a href='surnames.php?tree=$tree'>" . _('Main surname page') . "</a> &nbsp;|&nbsp; <a href=\"surnames-all.php?tree=$tree\">" . _('Show all surnames') . "</a>"; ?></p>
        </div>
        <table class="sntable">
            <tr>
                <td class="sncol align-top">
                    <?php
                    $wherestr = $tree ? "AND gedcom = '$tree'" : "";
                    $treestr = $orgtree ? "&amp;tree=$tree" : "";

                    $more = getLivingPrivateRestrictions($people_table, false, false);
                    if ($more) $wherestr .= " AND " . $more;


                    $surnamestr = $lnprefixes ? "TRIM(CONCAT_WS(' ',lnprefix,lastname) )" : "lastname";
                    if ($tngconfig['ucsurnames']) $surnamestr = "UCASE($surnamestr)";

                    $firstchar = $firstchar == "\"" ? "\\\"" : $firstchar;
                    $query = "SELECT UCASE($binary $surnamestr) AS lastname, $surnamestr AS lowername, UCASE($binary lastname) AS binlast, count(UCASE($binary lastname)) AS lncount ";
                    $query .= "FROM $people_table ";
                    $query .= "WHERE UCASE($binary TRIM(lastname)) LIKE \"$firstchar%\" ";
                    $query .= "$wherestr ";
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
                            $name = $surname['lastname'] ? "<a href=\"search.php?mylastname=$surname2&amp;lnqualify=equals&amp;mybool=AND$treestr\">{$surname['lowername']}</a>" : _('[no surname]');
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
    <br>
<?php
tng_footer("");
?>
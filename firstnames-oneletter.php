<?php
$textpart = "surnames";
@set_time_limit(0);
include "tng_begin.php";

$firstchar = mb_substr($firstchar, 0, 1, $charset);
$decodedfirstchar = stripslashes(urldecode($firstchar));

$treestr = $tree ? " ({$text['tree']}: $tree)" : "";
$logstring = "<a href=\"firstnames-oneletter.php?firstchar=$firstchar&amp;tree=$tree\">" . xmlcharacters($text['firstnamelist'] . ": {$text['beginswith']} $decodedfirstchar$treestr") . "</a>";
writelog($logstring);
preparebookmark($logstring);

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

tng_header($text['firstnamelist'] . ": {$text['beginswith']} $decodedfirstchar", $flags);
?>

    <h2 class="header">
        <span class="headericon" id="surnames-hdr-icon"></span><?php echo $text['firstnamelist'] . ": {$text['beginswith']} $decodedfirstchar"; ?>
    </h2>
    <br class="clearleft">
<?php
$hiddenfields[] = ['name' => 'firstchar', 'value' => $firstchar];
echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'firstnames-oneletter', 'method' => 'get', 'name' => 'form1', 'id' => 'form1', 'hidden' => $hiddenfields]);
?>

    <div class="titlebox rounded-lg">
        <div>
            <h3 class="subhead"><?php echo "{$text['allfirstbegwith']} $decodedfirstchar, {$text['sortedalpha']} ({$text['totalnames']}):"; ?></h3>
            <p class="smaller"><?php echo $text['showmatchingfirstnames'] . "&nbsp;&nbsp;&nbsp;<a href=\"firstnames.php?tree=$tree\">{$text['mainfirstnamepage']}</a> &nbsp;|&nbsp; <a href=\"firstnames-all.php?tree=$tree\">{$text['showallfirstnames']}</a>"; ?></p>
        </div>
        <table class="sntable">
            <tr>
                <td class="sncol align-top">
                    <?php
                    $wherestr = $tree ? "AND gedcom = '$tree'" : "";
                    $treestr = $orgtree ? "&amp;tree=$tree" : "";

                    $more = getLivingPrivateRestrictions($people_table, false, false);
                    if ($more) $wherestr .= " AND " . $more;


                    $firstnamestr = $lnprefixes ? "TRIM(CONCAT_WS(' ',lnprefix,firstname) )" : "firstname";
                    if ($tngconfig['ucfirstnames']) {
                        $firstnamestr = "UCASE($firstnamestr)";
                    }
                    $firstchar = $firstchar == "\"" ? "\\\"" : $firstchar;
                    $query = "SELECT UCASE( $binary $firstnamestr ) AS firstname, $firstnamestr AS lowername, UCASE($binary firstname) AS binlast, count( UCASE($binary firstname) ) AS lncount FROM $people_table WHERE UCASE($binary TRIM(firstname)) LIKE \"$firstchar%\" $wherestr GROUP BY lowername ORDER by binlast";
                    $result = tng_query($query);
                    $topnum = tng_num_rows($result);
                    if ($result) {
                        $snnum = 1;
                        if (isMobile()) {
                            $numcols = 2;
                        } elseif (!isset($numcols) || $numcols > 5) {
                            $numcols = 5;
                        }
                        $num_in_col = ceil($topnum / $numcols);

                        $num_in_col_ctr = 0;
                        while ($firstname = tng_fetch_assoc($result)) {
                            $firstname2 = urlencode($firstname['firstname']);
                            $name = $firstname['firstname'] ? "<a href=\"search.php?myfirstname=$firstname2&amp;lnqualify=equals&amp;mybool=AND$treestr\">{$firstname['lowername']}</a>" : $text['nofirstname'];
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
    <br>
<?php
tng_footer("");
?>
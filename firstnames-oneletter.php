<?php
$textpart = "surnames";
@set_time_limit(0);
include "tng_begin.php";

$search_url = getURL("search", 1);
$firstnames_url = getURL("firstnames", 1);
$firstnames_all_url = getURL("firstnames-all", 1);
$firstnames_oneletter_url = getURL("firstnames-oneletter", 1);

$firstchar = mb_substr($firstchar, 0, 1, $charset);
$decodedfirstchar = stripslashes(urldecode($firstchar));

$treestr = $tree ? " ({$text['tree']}: $tree)" : "";
$logstring = "<a href=\"$firstnames_oneletter_url" . "firstchar=$firstchar&amp;tree=$tree\">" . xmlcharacters($text['firstnamelist'] . ": {$text['beginswith']} $decodedfirstchar$treestr") . "</a>";
writelog($logstring);
preparebookmark($logstring);

tng_header($text['firstnamelist'] . ": {$text['beginswith']} $decodedfirstchar", $flags);
?>

    <h1 class="header"><span class="headericon" id="surnames-hdr-icon"></span><?php echo $text['firstnamelist'] . ": {$text['beginswith']} $decodedfirstchar"; ?></h1><br class="clearleft"/>
<?php
$hiddenfields[] = array('name' => 'firstchar', 'value' => $firstchar);
echo treeDropdown(array('startform' => true, 'endform' => true, 'action' => 'firstnames-oneletter', 'method' => 'get', 'name' => 'form1', 'id' => 'form1', 'hidden' => $hiddenfields));
?>

    <div class="titlebox">
        <div>
            <p class="subhead"><b><?php echo "{$text['allfirstbegwith']} $decodedfirstchar, {$text['sortedalpha']} ({$text['totalnames']}):"; ?></b></p>
            <p class="smaller"><?php echo $text['showmatchingfirstnames'] . "&nbsp;&nbsp;&nbsp;<a href=\"$firstnames_url" . "tree=$tree\">{$text['mainfirstnamepage']}</a> &nbsp;|&nbsp; <a href=\"$firstnames_all_url" . "tree=$tree\">{$text['showallfirstnames']}</a>"; ?></p>
        </div>
        <table class="sntable">
            <tr>
                <td class="sncol">
                  <?php
                  $wherestr = $tree ? "AND gedcom = \"$tree\"" : "";
                  $treestr = $orgtree ? "&amp;tree=$tree" : "";

                  $more = getLivingPrivateRestrictions($people_table, false, false);
                  if ($more) {
                    $wherestr .= " AND " . $more;
                  }

                  $firstnamestr = $lnprefixes ? "TRIM(CONCAT_WS(' ',lnprefix,firstname) )" : "firstname";
                  if ($tngconfig['ucfirstnames']) {
                    $firstnamestr = "ucase($firstnamestr)";
                  }
                  $firstchar = $firstchar == "\"" ? "\\\"" : $firstchar;
                  $query = "SELECT ucase( $binary $firstnamestr ) as firstname, $firstnamestr as lowername, ucase($binary firstname) as binlast, count( ucase($binary firstname) ) as lncount FROM $people_table WHERE ucase($binary TRIM(firstname)) LIKE \"$firstchar%\" $wherestr GROUP BY lowername ORDER by binlast";
                  $result = tng_query($query);
                  $topnum = tng_num_rows($result);
                  if ($result) {
                    $snnum = 1;
                    if ($sitever == "mobile") {
                      $numcols = 2;
                    } elseif (!isset($numcols) || $numcols > 5) {
                      $numcols = 5;
                    }
                    $num_in_col = ceil($topnum / $numcols);

                    $num_in_col_ctr = 0;
                    while ($firstname = tng_fetch_assoc($result)) {
                      $firstname2 = urlencode($firstname['firstname']);
                      $name = $firstname['firstname'] ? "<a href=\"$search_url" . "myfirstname=$firstname2&amp;lnqualify=equals&amp;mybool=AND$treestr\">{$firstname['lowername']}</a>" : $text['nofirstname'];
                      echo "$snnum. $name ({$firstname['lncount']})<br/>\n";
                      $snnum++;
                      $num_in_col_ctr++;
                      if ($num_in_col_ctr == $num_in_col) {
                        echo "</td>\n<td class=\"table-dblgutter\">&nbsp;&nbsp;</td>\n<td class=\"sncol\">";
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
    <br/>
<?php
tng_footer("");
?>
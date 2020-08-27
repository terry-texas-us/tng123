<?php
$textpart = "surnames";
@set_time_limit(0);
include "tng_begin.php";

$search_url = getURL("search", 1);
$surnames_url = getURL("surnames", 1);
$surnames_all_url = getURL("surnames-all", 1);
$surnames_oneletter_url = getURL("surnames-oneletter", 1);

$firstchar = mb_substr($firstchar, 0, 1, $charset);
$decodedfirstchar = stripslashes(urldecode($firstchar));

$treestr = $tree ? " ({$text['tree']}: $tree)" : "";
$logstring = "<a href=\"$surnames_oneletter_url" . "firstchar=$firstchar&amp;tree=$tree\">" . xmlcharacters($text['surnamelist'] . ": {$text['beginswith']} $decodedfirstchar$treestr") . "</a>";
writelog($logstring);
preparebookmark($logstring);

tng_header($text['surnamelist'] . ": {$text['beginswith']} $decodedfirstchar", $flags);
?>

  <h1 class="header"><span class="headericon" id="surnames-hdr-icon"></span><?php echo $text['surnamelist'] . ": {$text['beginswith']} $decodedfirstchar"; ?></h1><br class="clearleft">
<?php
$hiddenfields[] = ['name' => 'firstchar', 'value' => $firstchar];
echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'surnames-oneletter', 'method' => 'get', 'name' => 'form1', 'id' => 'form1', 'hidden' => $hiddenfields]);
?>

  <div class="titlebox">
    <div>
      <p class="subhead"><b><?php echo "{$text['allbeginningwith']} $decodedfirstchar, {$text['sortedalpha']} ({$text['totalnames']}):"; ?></b></p>
      <p class="smaller"><?php echo $text['showmatchingsurnames'] . "&nbsp;&nbsp;&nbsp;<a href=\"$surnames_url" . "tree=$tree\">{$text['mainsurnamepage']}</a> &nbsp;|&nbsp; <a href=\"$surnames_all_url" . "tree=$tree\">{$text['showallsurnames']}</a>"; ?></p>
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

                  $surnamestr = $lnprefixes ? "TRIM(CONCAT_WS(' ',lnprefix,lastname) )" : "lastname";
                  if ($tngconfig['ucsurnames']) {
                    $surnamestr = "ucase($surnamestr)";
                  }
                  $firstchar = $firstchar == "\"" ? "\\\"" : $firstchar;
                  $query = "SELECT ucase( $binary $surnamestr ) as lastname, $surnamestr as lowername, ucase($binary lastname) as binlast, count( ucase($binary lastname) ) as lncount FROM $people_table WHERE ucase($binary TRIM(lastname)) LIKE \"$firstchar%\" $wherestr GROUP BY lowername ORDER by binlast";
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
                    while ($surname = tng_fetch_assoc($result)) {
                      $surname2 = urlencode($surname['lastname']);
                      $name = $surname['lastname'] ? "<a href=\"$search_url" . "mylastname=$surname2&amp;lnqualify=equals&amp;mybool=AND$treestr\">{$surname['lowername']}</a>" : $text['nosurname'];
                      echo "$snnum. $name ({$surname['lncount']})<br>\n";
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
  <br>
<?php
tng_footer("");
?>
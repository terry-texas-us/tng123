<?php
?>
<table class="sntable">
    <tr>
        <td class="sncol align-top">
            <?php
            $wherestr = $tree ? "WHERE gedcom = '$tree'" : "";
            $treestr = $orgtree ? "&amp;tree=$tree" : "";

            $more = getLivingPrivateRestrictions($people_table, false, false);
            if ($more) {
                $wherestr .= $wherestr ? " AND " . $more : "WHERE $more";
            }

            $topnum = $topnum ? $topnum : 100;
            $surnamestr = $lnprefixes ? "TRIM(CONCAT_WS(' ',lnprefix,lastname) )" : "lastname";
            if ($tngconfig['ucsurnames']) $surnamestr = "UCASE($surnamestr)";

            $wherestr .= $wherestr ? " AND lastname != \"\"" : "WHERE lastname != \"\"";
            $query = "SELECT UCASE( $binary $surnamestr ) AS lastname, $surnamestr AS lowername, count( UCASE($binary lastname) ) AS lncount FROM $people_table $wherestr GROUP BY lowername ORDER by lncount DESC, lastname LIMIT $topnum";

            $result = tng_query($query);
            $topnum = tng_num_rows($result);
            if ($result) {
                $counter = 1;
                if (!isset($numcols) || $numcols > 5) $numcols = 5;
                $num_in_col = ceil($topnum / $numcols);

                $num_in_col_ctr = 0;
                $nosurname = urlencode(_('[no surname]'));
                while ($surname = tng_fetch_assoc($result)) {
                    $surname2 = urlencode($surname['lastname']);
                    $name = $surname['lastname'] ? "<a href=\"search.php?mylastname=$surname2&amp;lnqualify=equals&amp;mybool=AND$treestr\">{$surname['lowername']}</a>" : "<a href=\"search.php?mylastname=$nosurname&amp;lnqualify=equals&amp;mybool=AND$treestr\">" . _('[no surname]') . "</a>";
                    echo "$counter. $name ({$surname['lncount']})<br>\n";
                    $counter++;
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
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
            $wherestr .= $wherestr ? " AND firstname != \"\"" : "WHERE firstname != \"\"";
            $query = "SELECT UCASE(SUBSTRING_INDEX(firstname, ' ', 1 )) AS firstname, SUBSTRING_INDEX(firstname, ' ', 1 ) AS lowername, count(UCASE(SUBSTRING_INDEX(firstname, ' ', 1 ))) AS lncount ";
            $query .= "FROM $people_table ";
            $query .= "$wherestr ";
            $query .= "GROUP BY lowername ";
            $query .= "ORDER by lncount DESC, firstname ";
            $query .= "LIMIT $topnum";

            $result = tng_query($query);
            $topnum = tng_num_rows($result);
            if ($result) {
                $counter = 1;
                if (!isset($numcols) || $numcols > 5) $numcols = 5;
                $num_in_col = ceil($topnum / $numcols);

                $num_in_col_ctr = 0;
                $nofirstname = urlencode(_('[no first name]'));
                while ($firstname = tng_fetch_assoc($result)) {
                    $firstname2 = urlencode($firstname['firstname']);
                    $name = $firstname['firstname'] ? "<a href=\"search.php?myfirstname=$firstname2&amp;fnqualify=equals&amp;mybool=AND$treestr\">{$firstname['lowername']}</a>" : "<a href=\"search.php?myfirstname=$nofirstname&amp;fnqualify=equals&amp;mybool=AND$treestr\">" . _('[no first name]') . "</a>";
                    echo "$counter. $name ({$firstname['lncount']})<br>\n";
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
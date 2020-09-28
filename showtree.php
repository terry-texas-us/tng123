<?php
$textpart = "trees";
include "tng_begin.php";

function showFact($text, $fact, $numflag = 0) {
    echo "<tr>\n";
    echo "<td class=\"fieldnameback align-top\" nowrap><span class=\"fieldname\">" . $text . "&nbsp;</span></td>\n";
    echo "<td colspan=\"2\" class='databack'";
    echo $numflag ? " align=\"right\"" : "";
    echo ">";
    echo $numflag ? number_format($fact) : $fact;
    echo "&nbsp;</td>\n";
    echo "</tr>\n";
}

$query = "SELECT count(personID) AS pcount, trees.gedcom, treename, description, owner, secret, address, email, city, state, zip, country, phone ";
$query .= "FROM $trees_table trees ";
$query .= "LEFT JOIN $people_table people ON trees.gedcom = people.gedcom ";
$query .= "WHERE trees.gedcom = '$tree' ";
$query .= "GROUP BY trees.gedcom";
$result = tng_query($query);
$row = tng_fetch_assoc($result);
tng_free_result($result);

writelog("<a href=\"showtree.php?tree=$tree\">{$text['tree']}: {$row['treename']}</a>");
preparebookmark("<a href=\"showtree.php?tree=$tree\">{$text['tree']}: {$row['treename']}</a>");

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

$flags['tabs'] = $tngconfig['tabs'];

tng_header($text['tree'] . ": " . $row['treename'], $flags);
?>
    <h2 class="header"><?php echo $text['tree'] . ": " . $row['treename']; ?></h2>
    <br style="clear: both;">

    <table cellspacing="1" cellpadding="4" class="whiteback normal">
        <?php
        if ($row['treename']) {
            showFact($text['treename'], $row['treename']);
        }
        if ($row['description']) {
            showFact($text['description'], $row['description']);
        }

        showFact($text['individuals'], $row['pcount'], true);

        $query = "SELECT count(familyID) AS fcount FROM $families_table WHERE gedcom = \"{$row['gedcom']}\"";
        $famresult = tng_query($query);
        $famrow = tng_fetch_assoc($famresult);
        tng_free_result($famresult);
        showFact($text['families'], $famrow['fcount'], true);

        $query = "SELECT count(sourceID) AS scount FROM $sources_table WHERE gedcom = \"{$row['gedcom']}\"";
        $srcresult = tng_query($query);
        $srcrow = tng_fetch_assoc($srcresult);
        tng_free_result($srcresult);
        showFact($text['sources'], $srcrow['scount'], true);

        if (!$row['secret']) {
            if ($row['owner']) {
                showFact($text['owner'], $row['owner']);
            }
            if ($row['address']) {
                showFact($text['address'], $row['address']);
            }
            if ($row['city']) {
                showFact($text['city'], $row['city']);
            }
            if ($row['state']) {
                showFact($text['state'], $row['state']);
            }
            if ($row['zip']) {
                showFact($text['zip'], $row['zip']);
            }
            if ($row['country']) {
                showFact($text['country'], $row['country']);
            }
            if ($row['email']) {
                showFact($text['email'], "<a href=\"mailto:{$row['email']}\">{$row['email']}</a>");
            }
            if ($row['phone']) {
                showFact($text['phone'], $row['phone']);
            }
        }
        ?>
    </table>
    <br>
<?php
echo "<a href='statistics.php'>{$text['morestats']}</a>\n";
?>
    <br><br>

<?php
tng_footer("");
?>
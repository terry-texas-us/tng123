<?php
$textpart = "trees";
include "tng_begin.php";

/**
 * @param $text
 * @param $fact
 * @param int $numflag
 */
function showFact($text, $fact, $numflag = 0) {
    echo "<tr>\n";
    echo "<td class='fieldnameback align-top' nowrap><span class='fieldname'>" . $text . "&nbsp;</span></td>\n";
    echo "<td colspan='2' class='databack'";
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

writelog("<a href=\"showtree.php?tree=$tree\">" . _('Tree') . ": {$row['treename']}</a>");
preparebookmark("<a href=\"showtree.php?tree=$tree\">" . _('Tree') . ": {$row['treename']}</a>");

tng_header(_('Tree') . ": " . $row['treename'], $flags);
?>
    <h2 class="header"><?php echo _('Tree') . ": " . $row['treename']; ?></h2>
    <br class="clear-both">

    <table cellspacing="1" cellpadding="4" class="whiteback normal">
        <?php
        if ($row['treename']) showFact(_('Tree Name'), $row['treename']);

        if ($row['description']) {
            showFact(_('Description'), $row['description']);
        }

        showFact(_('individuals'), $row['pcount'], true);

        $query = "SELECT count(familyID) AS fcount FROM $families_table WHERE gedcom = \"{$row['gedcom']}\"";
        $famresult = tng_query($query);
        $famrow = tng_fetch_assoc($famresult);
        tng_free_result($famresult);
        showFact(_('Families'), $famrow['fcount'], true);

        $query = "SELECT count(sourceID) AS scount FROM $sources_table WHERE gedcom = \"{$row['gedcom']}\"";
        $srcresult = tng_query($query);
        $srcrow = tng_fetch_assoc($srcresult);
        tng_free_result($srcresult);
        showFact(_('Sources'), $srcrow['scount'], true);

        if (!$row['secret']) {
            if ($row['owner']) showFact(_('Owner'), $row['owner']);

            if ($row['address']) showFact(_('Address'), $row['address']);

            if ($row['city']) showFact(_('City'), $row['city']);

            if ($row['state']) showFact(_('state'), $row['state']);

            if ($row['zip']) showFact(_('Zip/Postal Code'), $row['zip']);

            if ($row['country']) showFact(_('country'), $row['country']);

            if ($row['email']) {
                showFact(_('E-mail'), "<a href=\"mailto:{$row['email']}\">{$row['email']}</a>");
            }
            if ($row['phone']) showFact(_('Phone'), $row['phone']);

        }
        ?>
    </table>
    <br>
<?php
echo "<a href='statistics.php'>" . _('More statistics') . "</a>\n";
?>
    <br><br>

<?php
tng_footer("");
?>
<?php

$textpart = "reports";
include "tng_begin.php";
$query = "SELECT reportname, reportdesc, reportID FROM $reports_table WHERE active = 1 ORDER BY ranking, reportname";
$result = tng_query($query);
$numrows = tng_num_rows($result);
$logstring = "<a href=\"$reports_url\">" . xmlcharacters(_('Reports')) . "</a>";
writelog($logstring);
preparebookmark($logstring);
tng_header(_('Reports'), $flags);
?>
    <h2 class="header"><span class="headericon" id="reports-hdr-icon"></span><?php echo _('Reports'); ?></h2>
    <br style="clear: left;">
<?php
if (!$numrows) {
    echo _('No reports exist');
} else {
    ?>
    <table class='whiteback normal' cellpadding='3' cellspacing='1' border='0'>
        <thead>
        <tr>
            <th class="fieldnameback nbrcol fieldname">&nbsp;#&nbsp;</th>
            <th class="fieldnameback fieldname">&nbsp;<strong><?php echo _('Report Name'); ?></strong>&nbsp;</th>
            <th class="fieldnameback fieldname">&nbsp;<?php echo _('Description'); ?>&nbsp;</th>
        </tr>
        </thead>
        <?php
        $count = 1;
        while ($row = tng_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td class='databack'><span class='normal'>$count.</span></td>";
            echo "<td class='databack'><span class='normal'>&nbsp;<a href=\"showreport.php?reportID={$row['reportID']}\">{$row['reportname']}</a>&nbsp;</span></td>";
            echo "<td class='databack'><span class='normal'>{$row['reportdesc']}&nbsp;</span></td>";
            echo "</tr>\n";
            $count++;
        }
        tng_free_result($result);
        ?>
    </table>
    <br>

    <?php
}
tng_footer("");
?>
<?php

global $flags;
?>

</td>
</tr>
</table>
</td>
</tr>
<tr>
    <td class="tablesubheader" align="center">
        <div class="topmenu" style="text-align:center;">
            <a href="index.php" class="lightlink" target="_top"><?php echo _("Home Page"); ?></a>&nbsp;|&nbsp;
            <a href="whatsnew.php" class="lightlink" target="_top"><?php echo _("What's New"); ?></a>&nbsp;|&nbsp;
            <a href="mostwanted.php" class="lightlink" target="_top"><?php echo _("Most Wanted"); ?></a>&nbsp;|&nbsp;
            <a href="surnames.php" class="lightlink" target="_top"><?php echo _("Surnames"); ?></a>&nbsp;|&nbsp;
            <a href="browsemedia.php?mediatypeID=photos" class="lightlink" target="_top"><?php echo _("Photos"); ?></a>&nbsp;|&nbsp;
            <a href="browsemedia.php?mediatypeID=histories" class="lightlink" target="_top"><?php echo _("Histories"); ?></a>&nbsp;|&nbsp;
            <a href="browsemedia.php?mediatypeID=documents" class="lightlink" target="_top"><?php echo _("Documents"); ?></a>&nbsp;|&nbsp;
            <a href="cemeteries.php" class="lightlink" target="_top"><?php echo _("Cemeteries"); ?></a>&nbsp;|&nbsp;
            <a href="places.php" class="lightlink" target="_top"><?php echo _("Places"); ?></a>&nbsp;|&nbsp;
            <a href="anniversaries.php" class="lightlink" target="_top"><?php echo _("Dates"); ?></a>&nbsp;|&nbsp;
            <a href="reports.php" class="lightlink" target="_top"><?php echo _("Reports"); ?></a>&nbsp;|&nbsp;
            <a href="browsesources.php" class="lightlink" target="_top"><?php echo _("Sources"); ?></a>
        </div>
    </td>
</tr>
<tr>
    <td class="tableheader"><img src="img/spacer.gif" width="25" height="25" alt=""></td>
</tr>
</table>
<br>
<div class="footer small">
    <?php
    $flags['basicfooter'] = true;
    tng_footer($flags);
    ?>
    <br><br>
</div>
</div>

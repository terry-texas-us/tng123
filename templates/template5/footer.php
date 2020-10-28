<?php global $text, $flags; ?>

</td>
</tr>
</table>
</td>
</tr>
<tr>
    <td class="tablesubheader" align="center">
        <div class="topmenu" style="text-align:center;">
            <a href="index.php" class="lightlink" target="_top"><?php echo $text['mnuheader']; ?></a>&nbsp;|&nbsp;
            <a href="whatsnew.php" class="lightlink" target="_top"><?php echo $text['mnuwhatsnew']; ?></a>&nbsp;|&nbsp;
            <a href="mostwanted.php" class="lightlink" target="_top"><?php echo $text['mostwanted']; ?></a>&nbsp;|&nbsp;
            <a href="surnames.php" class="lightlink" target="_top"><?php echo $text['mnulastnames']; ?></a>&nbsp;|&nbsp;
            <a href="browsemedia.php?mediatypeID=photos" class="lightlink"
                target="_top"><?php echo $text['mnuphotos']; ?></a>&nbsp;|&nbsp;
            <a href="browsemedia.php?mediatypeID=histories" class="lightlink"
                target="_top"><?php echo $text['mnuhistories']; ?></a>&nbsp;|&nbsp;
            <a href="browsemedia.php?mediatypeID=documents" class="lightlink"
                target="_top"><?php echo $text['documents']; ?></a>&nbsp;|&nbsp;
            <a href="cemeteries.php" class="lightlink" target="_top"><?php echo $text['mnucemeteries']; ?></a>&nbsp;|&nbsp;
            <a href="places.php" class="lightlink" target="_top"><?php echo $text['places']; ?></a>&nbsp;|&nbsp;
            <a href="anniversaries.php" class="lightlink" target="_top"><?php echo $text['dates']; ?></a>&nbsp;|&nbsp;
            <a href="reports.php" class="lightlink" target="_top"><?php echo $text['mnureports']; ?></a>&nbsp;|&nbsp;
            <a href="browsesources.php" class="lightlink" target="_top"><?php echo $text['mnusources']; ?></a>
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

<?php

$textpart = "surnames";
include "tng_begin.php";

$topnum = preg_replace("/[^0-9]/", '', $topnum);

_('Top xxx surnames') = preg_replace("/xxx/", $topnum, _('Top xxx surnames'));

$treestr = $tree ? " (" . _('Tree') . ": $tree)" : "";
$logstring = "<a href=\"surnames100.php?topnum=$topnum&amp;tree=$tree\">" . xmlcharacters(_('Surname List') . ": " . _('Top') . " $topnum$treestr") . "</a>";
writelog($logstring);
preparebookmark($logstring);

tng_header(_('Surname List') . ": " . _('Top xxx surnames') . "", $flags);
?>
    <h2 class="header"><span class="headericon" id="surnames-hdr-icon"></span><?php echo _('Surname List') . ": " . _('Top xxx surnames') . ""; ?></h2>
    <br class="clearleft">
<?php
echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'surnames100', 'method' => 'get', 'name' => 'form1', 'id' => 'form1']);

echo getFORM("surnames100", "get", "", "");
?>
    <div class="titlebox rounded-lg">
        <?php echo _('Show top'); ?>&nbsp;
        <input type="text" name="topnum" value="<?php echo $topnum; ?>" size="4" maxlength="4"> <?php echo _('ordered by occurrence'); ?>&nbsp;
        <input type="submit" value="<?php echo _('Go'); ?>">
    </div>
<?php echo "</form>"; ?>
    <br>

    <div class="titlebox rounded-lg">
        <h3 class="subhead"><?php echo "" . _('Top xxx surnames') . " (" . _('total individuals') . "):"; ?></h3>
        <p class="smaller"><?php echo _('Click on a surname to show matching records.') . "&nbsp;&nbsp;&nbsp;<a href='surnames.php?tree=$tree'>" . _('Main surname page') . "</a> &nbsp;|&nbsp; <a href=\"surnames-all.php?tree=$tree\">" . _('Show all surnames') . "</a>"; ?></p>
        <?php include "surnamestable.php"; ?>
    </div>
    <br>
<?php tng_footer(""); ?>
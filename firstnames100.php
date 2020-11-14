<?php

$textpart = "surnames";
include "tng_begin.php";

$topnum = preg_replace("/[^0-9]/", '', $topnum);

_('Top xxx first names') = preg_replace("/xxx/", $topnum, _('Top xxx first names'));

$treestr = $tree ? " (" . _('Tree') . ": $tree)" : "";
$logstring = "<a href=\"firstnames100.php?topnum=$topnum&amp;tree=$tree\">" . xmlcharacters(_('First Name List') . ": " . _('Top') . " $topnum$treestr") . "</a>";
writelog($logstring);
preparebookmark($logstring);

tng_header(_('First Name List') . ": " . _('Top xxx first names') . "", $flags);
?>

    <h2 class="header"><span class="headericon" id="surnames-hdr-icon"></span><?php echo _('First Name List') . ": " . _('Top xxx first names') . ""; ?></h2>
    <br class="clearleft">
<?php
echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'firstnames100', 'method' => 'get', 'name' => 'form1', 'id' => 'form1']);

$formstr = getFORM("firstnames100", "get", "", "");
echo $formstr;
?>
    <div class="titlebox rounded-lg">
        <?php echo _('Show top'); ?>&nbsp;
        <input type="text" name="topnum" value="<?php echo $topnum; ?>" size="5" maxlength="5"> <?php echo _('ordered by occurrence'); ?>&nbsp;
        <input type="submit" value="<?php echo _('Go'); ?>">
    </div>
    </form>
    <br>

    <div class="titlebox rounded-lg">
        <h3 class="subhead"><?php echo "" . _('Top xxx first names') . " (" . _('total individuals') . "):"; ?></h3>
        <p class="smaller"><?php echo _('Click on a first name to show matching records.') . "&nbsp;&nbsp;&nbsp;<a href=\"firstnames.php?tree=$tree\">" . _('Main first name page') . "</a> &nbsp;|&nbsp; <a href=\"firstnames-all.php?tree=$tree\">" . _('Show all first names') . "</a>"; ?></p>
        <?php include "firstnamestable.php"; ?>
    </div>
    <br>
<?php tng_footer(""); ?>
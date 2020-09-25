<?php
$textpart = "surnames";
include "tng_begin.php";

$topnum = preg_replace("/[^0-9]/", '', $topnum);

$text['top30first'] = preg_replace("/xxx/", $topnum, $text['top30first']);

$treestr = $tree ? " ({$text['tree']}: $tree)" : "";
$logstring = "<a href=\"firstnames100.php?topnum=$topnum&amp;tree=$tree\">" . xmlcharacters($text['firstnamelist'] . ": {$text['top']} $topnum$treestr") . "</a>";
writelog($logstring);
preparebookmark($logstring);

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

tng_header($text['firstnamelist'] . ": {$text['top30first']}", $flags);
?>

    <h2 class="header"><span class="headericon" id="surnames-hdr-icon"></span><?php echo $text['firstnamelist'] . ": {$text['top30first']}"; ?></h2>
    <br class="clearleft">
<?php
echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'firstnames100', 'method' => 'get', 'name' => 'form1', 'id' => 'form1']);

$formstr = getFORM("firstnames100", "get", "", "");
echo $formstr;
?>
    <div class="titlebox">
        <?php echo $text['showtop']; ?>&nbsp;
        <input type="text" name="topnum" value="<?php echo $topnum; ?>" size="5" maxlength="5"> <?php echo $text['byoccurrence']; ?>&nbsp;
        <input type="submit" value="<?php echo $text['go']; ?>">
    </div>
    </form>
    <br>

    <div class="titlebox">
        <h3 class="subhead"><?php echo "{$text['top30first']} ({$text['totalnames']}):"; ?></h3>
        <p class="smaller"><?php echo $text['showmatchingfirstnames'] . "&nbsp;&nbsp;&nbsp;<a href=\"firstnames.php?tree=$tree\">{$text['mainfirstnamepage']}</a> &nbsp;|&nbsp; <a href=\"firstnames-all.php?tree=$tree\">{$text['showallfirstnames']}</a>"; ?></p>
        <?php
        include "firstnamestable.php";
        ?>
    </div>
    <br>
<?php
tng_footer("");
?>
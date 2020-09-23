<?php
$textpart = "surnames";
include "tng_begin.php";

$topnum = preg_replace("/[^0-9]/", '', $topnum);

$surnames_all_url = getURL("surnames-all", 1);
$surnames_url = getURL("surnames", 1);
$surnames100_url = getURL("surnames100", 1);
$text['top30'] = preg_replace("/xxx/", $topnum, $text['top30']);

$treestr = $tree ? " ({$text['tree']}: $tree)" : "";
$logstring = "<a href=\"$surnames100_url" . "topnum=$topnum&amp;tree=$tree\">" . xmlcharacters($text['surnamelist'] . ": {$text['top']} $topnum$treestr") . "</a>";
writelog($logstring);
preparebookmark($logstring);

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

tng_header($text['surnamelist'] . ": {$text['top30']}", $flags);
?>
    <h2 class="header"><span class="headericon" id="surnames-hdr-icon"></span><?php echo $text['surnamelist'] . ": {$text['top30']}"; ?></h2>
    <br class="clearleft">
<?php
echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'surnames100', 'method' => 'get', 'name' => 'form1', 'id' => 'form1']);

echo getFORM("surnames100", "get", "", "");
?>
    <div class="titlebox">
        <?php echo $text['showtop']; ?>&nbsp;
        <input type="text" name="topnum" value="<?php echo $topnum; ?>" size="4" maxlength="4"> <?php echo $text['byoccurrence']; ?>&nbsp;
        <input type="submit" value="<?php echo $text['go']; ?>">
    </div>
<?php echo "</form>"; ?>
    <br>

    <div class="titlebox">
        <h3 class="subhead"><?php echo "{$text['top30']} ({$text['totalnames']}):"; ?></h3>
        <p class="smaller"><?php echo $text['showmatchingsurnames'] . "&nbsp;&nbsp;&nbsp;<a href=\"$surnames_url" . "tree=$tree\">{$text['mainsurnamepage']}</a> &nbsp;|&nbsp; <a href=\"$surnames_all_url" . "tree=$tree\">{$text['showallsurnames']}</a>"; ?></p>
        <?php include "surnamestable.php"; ?>
    </div>
    <br>
<?php tng_footer(""); ?>
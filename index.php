<?php
include "tng_begin.php";

if ($templateswitching && $templatenum) {
    include "templates/$templatepfx$templatenum/index.php";
    exit;
}

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

$flags = ['noicons' => true, 'noheader' => true];
$headElement = new HeadElementPublic($text['mnuheader'], $flags);

$headElement->addStyleElement(
    "<style>table {border-collapse: separate; border-spacing: 5px;} table td {padding: 0;}</style>");

echo $headElement->getHtml();

tng_header0($headElement, $flags);
preHeaderVariants($headElement, $flags, $tngconfig['maint']);
?>

<h1><?php echo $text['mnuheader']; ?></h1>

<?php
if ($currentuser) {
    echo "<p><strong>{$text['welcome']}, $currentuserdesc.</strong></p>\n";
}
?>

<h2><?php echo $text['mnusearchfornames']; ?></h2>

<form action="search.php" method="get">
    <table>
        <tr>
            <td>
                <small><?php echo $text['mnulastname']; ?>:</small><br>
                <input type="text" name="mylastname" size="14">
            </td>
        </tr>
        <tr>
            <td>
                <small><?php echo $text['mnufirstname']; ?>:</small><br>
                <input type="text" name="myfirstname" size="14">
            </td>
        </tr>
        <tr>
            <td>
                <input type="hidden" name="mybool" value="AND">
                <input type="hidden" name="offset" value="0">
                <input type="submit" name="search" value="<?php echo $text['mnusearch']; ?>">
            </td>
        </tr>
    </table>
</form>

<h2><?php echo $text['mnufeatures']; ?></h2>

<ul>
    <?php
    if ($currentuser) { // this means you're logged in
        echo "<li><a href=\"logout.php\">{$text['mnulogout']}</a></li>\n";
    } else { // this means you're logged out
        echo "<li><a href=\"login.php\">{$text['mnulogon']}</a></li>\n";
    }
    echo "<li><a href=\"newacctform.php\">{$text['mnuregister']}</a></li>\n";
    echo "<li><a href=\"searchform.php\">{$text['mnuadvancedsearch']}</a></li>\n";
    echo "<li><a href=\"surnames.php\">{$text['mnulastnames']}</a></li>\n";
    echo "<li><a href=\"bookmarks.php\">{$text['bookmarks']}</a></li>\n";
    echo "<li><a href=\"statistics.php\">{$text['mnustatistics']}</a></li>\n";
    echo "<li><a href=\"browsemedia.php?mediatypeID=photos\">{$text['mnuphotos']}</a></li>\n";
    echo "<li><a href=\"browsemedia.php?mediatypeID=histories\">{$text['mnuhistories']}</a></li>\n";
    echo "<li><a href=\"browsemedia.php?mediatypeID=documents\">{$text['documents']}</a></li>\n";
    echo "<li><a href=\"browsemedia.php?mediatypeID=videos\">{$text['videos']}</a></li>\n";
    echo "<li><a href=\"browsemedia.php?mediatypeID=recordings\">{$text['recordings']}</a></li>\n";
    echo "<li><a href=\"browsealbums.php\">{$text['albums']}</a></li>\n";
    echo "<li><a href=\"browsemedia.php\">{$text['allmedia']}</a></li>\n";
    echo "<li><a href=\"cemeteries.php\">{$text['mnucemeteries']}</a></li>\n";
    echo "<li><a href=\"browsemedia.php?mediatypeID=headstones\">{$text['mnutombstones']}</a></li>\n";

    echo "<li><a href=\"places.php\">{$text['places']}</a></li>\n";
    echo "<li><a href=\"browsenotes.php\">{$text['notes']}</a></li>\n";
    echo "<li><a href=\"anniversaries.php\">{$text['anniversaries']}</a></li>\n";
    echo "<li><a href=\"reports.php\">{$text['mnureports']}</a></li>\n";
    echo "<li><a href=\"browsesources.php\">{$text['mnusources']}</a></li>\n";
    echo "<li><a href=\"browserepos.php\">{$text['repositories']}</a></li>\n";
    echo "<li><a href=\"whatsnew.php\">{$text['mnuwhatsnew']}</a></li>\n";
    echo "<li><a href=\"mostwanted.php\">{$text['mostwanted']}</a></li>\n";
    echo "<li><a href=\"changelanguage.php\">{$text['mnulanguage']}</a></li>\n";

    if ($allow_admin) {
        echo "<li><a href=\"showlog.php\">{$text['mnushowlog']}</a></li>\n";
        echo "<li><a href=\"admin.php\">{$text['mnuadmin']}</a></li>\n";
    }
    echo "<li><a href=\"suggest.php\">{$text['contactus']}</a></li>\n";
    ?>
</ul>

<p><strong>Please customize this page!</strong></p>

<?php echo "</body>"; ?>
<?php echo "</html>"; ?>

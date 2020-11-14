<?php
include "begin.php";
include "adminlib.php";
$textpart = "sources";
include "$mylanguage/admintext.php";

include "checklogin.php";

if ($session_charset != "UTF-8") {
    $mytitle = tng_utf8_decode($mytitle);
}

$query = "SELECT sourceID, title FROM $sources_table WHERE gedcom = '$tree' AND title LIKE \"%$mytitle%\" ORDER BY title LIMIT 250";
$result = tng_query($query);

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack ajaxwindow" id="findrepodiv">
    <table cellpadding="0">
        <tr>
            <td class='align-top'>
                <h3 class="subhead"><?php echo _('Search Results'); ?></h3><br>
                <span class="normal">(<?php echo _('click to select'); ?>)</span><br>
            </td>
            <td>&nbsp;&nbsp;&nbsp;</td>
            <td>
                <form action="">
                    <input type="button" value="<?php echo _('Find...'); ?>" onClick="reopenFindSourceForm();">
                </form>
            </td>
        </tr>
    </table>
    <br>
    <table cellspacing="1" cellpadding="3">
        <tr>
            <th class="fieldnameback"><span class="fieldname"><?php echo _('Source ID'); ?></span></th>
            <th class="fieldnameback"><span class="fieldname"><?php echo _('Name'); ?></span></th>
        </tr>
        <?php
        while ($row = tng_fetch_assoc($result)) {
            $fixedtitle = addslashes($row['title']);
            echo "<tr>\n";
            echo "<td class='lightback'><span class='normal'><a href=\"findsource2.php\" onClick=\"return returnTitle('{$row['sourceID']}');\">{$row['sourceID']}</a></span></td>\n";
            echo "<td class='lightback'><span class='normal'><a href=\"findsource2.php\" onClick=\"return returnTitle('{$row['sourceID']}');\">" . truncateIt($row['title'], 75) . "</a>&nbsp;</span></td>\n";
            echo "</tr>\n";
        }
        tng_free_result($result);
        ?>
    </table>
    </body>
    </html>

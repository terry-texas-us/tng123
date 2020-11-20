<?php
include "begin.php";
include "adminlib.php";

include "checklogin.php";

$query = "SELECT citations.sourceID AS sourceID, description, page, quay, citedate, citetext, note, title, citations.gedcom AS gedcom ";
$query .= "FROM $citations_table citations ";
$query .= "LEFT JOIN $sources_table sources ON citations.sourceID = sources.sourceID AND sources.gedcom = citations.gedcom ";
$query .= "WHERE citationID = \"$citationID\"";
$result = tng_query($query);
$row = tng_fetch_assoc($result);
tng_free_result($result);
$row['page'] = preg_replace("/\"/", "&#34;", $row['page']);
$row['citetext'] = preg_replace("/\"/", "&#34;", $row['citetext']);
$row['note'] = preg_replace("/\"/", "&#34;", $row['note']);

$helplang = findhelp("citations_help.php");

header("Content-type:text/html; charset=" . $session_charset);
?>

<form action="" name="citeform3" onsubmit="return updateCitation(this);">
    <div style="float:right;text-align:center;">
        <input class="btn" name="submit" type="submit" value="<?php echo _('Save'); ?>">
        <p><a href="#" onclick="return gotoSection('editcitation','citations');"><?php echo _('Cancel'); ?></a></p>
    </div>
    <h3 class="subhead"><?php echo _('Edit Existing Citation'); ?> |
        <a href="#"
            onclick="return openHelp('<?php echo $helplang; ?>/citations_help.php#add', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();"><?php echo _('Help for this area'); ?></a>
    </h3>

    <table cellpadding="2" class="normal">
        <?php if ($row['sourceID']) { ?>
            <tr>
                <td class='align-top'><?php echo _('Source'); ?>:</td>
                <td>
                    <input type="text" name="sourceID" id="sourceID2" value="<?php echo $row['sourceID']; ?>" size="20"> &nbsp;<?php echo _('OR'); ?> &nbsp;
                    <input type="button" value="<?php echo _('Find...'); ?>" onclick="return initFilter('editcitation','findsource','sourceID2','sourceTitle2');">
                    <input type="button" value="<?php echo _('Create...'); ?>"
                        onclick="return initNewItem('source', document.newsourceform.sourceID, 'sourceID2', 'sourceTitle2', 'editcitation','newsource');">
                </td>
            </tr>
            <tr>
                <td></td>
                <td id="sourceTitle2"><?php echo $row['title']; ?></td>
            </tr>
            <?php
        } else {
            echo "<tr>";
            echo "<td>" . _('Description') . ":</td>";
            echo "<td><input type='text' name=\"description\" value=\"{$row['description']}\"><input type='hidden' name=\"sourceID\" value=\"\"></td>\n";
            echo "</tr>";
        }
        ?>
        <tr>
            <td class='align-top'><?php echo _('Page'); ?>:</td>
            <td>
                <input type="text" name="citepage" value="<?php echo $row['page']; ?>" size="60">
            </td>
        </tr>
        <tr>
            <td class='align-top'><?php echo _('Reliability'); ?>*:</td>
            <td>
                <select name="quay">
                    <option value=""></option>
                    <option value="0"<?php if ($row['quay'] == "0") {
                        echo " selected";
                    } ?>>0
                    </option>
                    <option value="1"<?php if ($row['quay'] == "1") {
                        echo " selected";
                    } ?>>1
                    </option>
                    <option value="2"<?php if ($row['quay'] == "2") {
                        echo " selected";
                    } ?>>2
                    </option>
                    <option value="3"<?php if ($row['quay'] == "3") {
                        echo " selected";
                    } ?>>3
                    </option>
                </select> <span class="normal">(<?php echo _('Higher numbers indicate greater reliability.'); ?>)</span>
            </td>
        </tr>
        <tr>
            <td class='align-top'><?php echo _('Citation Date'); ?>:</td>
            <td>
                <input type="text" name="citedate" value="<?php echo $row['citedate']; ?>" size="60" onBlur="checkDate(this);">
            </td>
        </tr>
        <tr>
            <td class='align-top'><?php echo _('Actual Text'); ?>:</td>
            <td><textarea cols="50" rows="5" name="citetext"><?php echo $row['citetext']; ?></textarea></td>
        </tr>
        <tr>
            <td class='align-top'><?php echo _('Notes'); ?>:</td>
            <td><textarea cols="50" rows="5" name="citenote"><?php echo $row['note']; ?></textarea></td>
        </tr>
    </table>
    <input type="hidden" name="citationID" value="<?php echo $citationID; ?>">
    <input type="hidden" name="tree" value="<?php echo $row['gedcom']; ?>">
</form>
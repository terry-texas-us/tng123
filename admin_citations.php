<?php
include "begin.php";
include "adminlib.php";
require "./public/events.php";

$textpart = "sources";
include "$mylanguage/admintext.php";

include "checklogin.php";

if (!isset($tree)) $tree = "";

$wherestr = "WHERE gedcom = '$tree'";

$query = "SELECT eventtypes.eventtypeID, tag, display ";
$query .= "FROM $events_table events ";
$query .= "LEFT JOIN $eventtypes_table eventtypes ON eventtypes.eventtypeID = events.eventtypeID ";
$query .= "WHERE eventID = '$eventID'";
$eventtypes = tng_query($query);
$eventtype = tng_fetch_assoc($eventtypes);

if ($eventtype['display']) {
    $eventtypedesc = getEventDisplay($eventtype['display']);
} elseif ($eventtype['tag']) {
    $eventtypedesc = $eventtype['tag'];
} elseif ($eventID) {
    $eventtypedesc = _($eventID) ? _($eventID) : _('Notes');
} else {
    $eventtypedesc = _('General');
}
tng_free_result($eventtypes);

$helplang = findhelp("citations_help.php");

header("Content-type:text/html; charset=" . $session_charset);

$xnotestr = $noteID ? " OR persfamID = \"$noteID\"" : "";
$query = "SELECT citationID, citations.sourceID AS sourceID, description, title, shorttitle ";
$query .= "FROM $citations_table citations ";
$query .= "LEFT JOIN $sources_table sources ON citations.sourceID = sources.sourceID AND sources.gedcom = citations.gedcom ";
$query .= "WHERE citations.gedcom = '$tree' AND ((persfamID = '$persfamID' AND eventID = \"$eventID\")$xnotestr) ";
$query .= "ORDER BY ordernum, citationID";
$citresult = tng_query($query);
$citationcount = tng_num_rows($citresult);
?>

<div class="databack ajaxwindow" id="citations"<?php if (!$citationcount) {
    echo " style='display: none;'";
} ?>>
    <form name="citeform">
        <h3 class="subhead"><?php echo _('Citations') . ": $eventtypedesc"; ?> |
            <a href="#" onclick="return openHelp('<?php echo $helplang; ?>/citations_help.php');"><?php echo _('Help for this area'); ?></a></h3>
        <p>
            <?php if ($allow_add) { ?>
                <input type="button" value="  <?php echo _('Add New'); ?>  " onclick="document.citeform2.reset();gotoSection('citations','addcitation');">&nbsp;
            <?php } ?>
            <input type="button" value="  <?php echo _('Finish'); ?>  " onclick="if(subpage){gotoSection('citationslist','notelist');subpage=false;}else{tnglitbox.remove();}">
        </p>
        <table id="citationstbl" class="fieldname normal" cellpadding="3" cellspacing="1" border="0"<?php if (!$citationcount) {
            echo " style='display: none;'";
        } ?>>
            <tbody id="citationstblbody">
            <tr>
                <td class="fieldnameback" width="50"><b><?php echo _('Sort'); ?></b></td>
                <td class="fieldnameback" width="70"><b><?php echo _('Action'); ?></b></td>
                <td class="fieldnameback" width="445"><b><?php echo _('Title'); ?></b></td>
            </tr>
            </tbody>
        </table>
        <div id="cites">
            <?php
            if ($citresult && $citationcount) {
                while ($citation = tng_fetch_assoc($citresult)) {
                    $sourcetitle = $citation['title'] ? $citation['title'] : $citation['shorttitle'];
                    $citationsrc = $citation['sourceID'] ? "[{$citation['sourceID']}] $sourcetitle" : $citation['description'];
                    $citationsrc = cleanIt($citationsrc);
                    $truncated = truncateIt($citationsrc, 75);
                    $actionstr = $allow_edit ? "<a href='#' onclick=\"return editCitation({$citation['citationID']});\" title=\"" . _('Edit') . "\" class='smallicon admin-edit-icon'></a>" : "";
                    $actionstr .= $allow_delete ? "<a href='#' onclick=\"return deleteCitation({$citation['citationID']},'$persfamID','$tree','$eventID');\" title=\"" . _('Delete') . "\" class='smallicon admin-delete-icon'></a>" : "";
                    echo "<div class='sortrow' id=\"citations_{$citation['citationID']}\">";
                    echo "<table class='normal' cellpadding='3' cellspacing='1' border='0'>";
                    echo "<tr id=\"row_{$citation['citationID']}\">";
                    echo "<td class='dragarea rounded-lg'><img src='img/admArrowUp.gif' alt='' class='inline-block'><br><img src='img/admArrowDown.gif' alt='' class='inline-block'></td>";
                    echo "<td class='lightback' width='70'>$actionstr</td>";
                    echo "<td class='lightback' width='445'>$truncated</td>";
                    echo "</tr></table></div>\n";
                }
                tng_free_result($citresult);
            }
            ?>
        </div>
    </form>
</div>

<div class="databack ajaxwindow"<?php if ($citationcount) {
    echo " style='display: none;'";
} ?> id="addcitation">
    <form action="" name="citeform2" onSubmit="return addCitation(this);">
        <div style="float:right;text-align:center;">
            <input type="submit" name="submit" class="btn" value="<?php echo _('Save'); ?>">
            <p><a href="#" onclick="return gotoSection('addcitation','citations');"><?php echo _('Cancel'); ?></a></p>
        </div>
        <h3 class="subhead"><?php echo _('Add New Citation'); ?> |
            <a href="#"
                onclick="return openHelp('<?php echo $helplang; ?>/citations_help.php#add', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();"><?php echo _('Help for this area'); ?></a>
        </h3>

        <table cellpadding="2" class="normal">
            <tr>
                <td><?php echo _('Source ID'); ?>:</td>
                <td>
                    <input type="text" name="sourceID" id="sourceID" size="20"> &nbsp;<?php echo _('OR'); ?> &nbsp;
                    <input type="button" value="<?php echo _('Find...'); ?>" onclick="return initFilter('addcitation','findsource','sourceID','sourceTitle');">
                    <input type="button" value="<?php echo _('Create...'); ?>"
                        onclick="return initNewItem('source', document.newsourceform.sourceID, 'sourceID', 'sourceTitle', 'addcitation','newsource');">
                    <?php
                    if (isset($_SESSION['lastcite'])) {
                        $parts = explode("|", $_SESSION['lastcite']);
                        if ($parts[0] == $tree) {
                            echo "<input type='button' value=\"" . _('Copy Last') . "\" onclick=\"return copylast(document.citeform2,'{$parts[1]}');\">";
                            echo "&nbsp; <img src=\"img/spinner.gif\" id=\"lastspinner\" style=\"vertical-align:-3px; display:none;\">";
                        }
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td id="sourceTitle"></td>
            </tr>
            <tr>
                <td><?php echo _('Page'); ?>:</td>
                <td>
                    <input type="text" name="citepage" id="citepage" size="60">
                </td>
            </tr>
            <tr>
                <td><?php echo _('Reliability'); ?>:</td>
                <td>
                    <select name="quay" id="quay">
                        <option value=""></option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select> (<?php echo _('Higher numbers indicate greater reliability.'); ?>)
                </td>
            </tr>
            <tr>
                <td><?php echo _('Citation Date'); ?>:</td>
                <td>
                    <input type="text" name="citedate" id="citedate" size="60" onBlur="checkDate(this);">
                </td>
            </tr>
            <tr>
                <td class='align-top'><?php echo _('Actual Text'); ?>:</td>
                <td><textarea cols="50" rows="5" name="citetext" id="citetext"></textarea></td>
            </tr>
            <tr>
                <td class='align-top'><?php echo _('Notes'); ?>:</td>
                <td><textarea cols="50" rows="5" name="citenote" id="citenote"></textarea></td>
            </tr>
        </table>
        <br>
        <input type="hidden" name="persfamID" value="<?php echo $persfamID; ?>">
        <input type="hidden" name="tree" value="<?php echo $tree; ?>">
        <input type="hidden" name="eventID" value="<?php echo $eventID; ?>">
    </form>
</div>

<div class="databack ajaxwindow" style="display:none;" id="editcitation">
</div>

<?php
$applyfilter = "applyFilter({form:'findsourceform1', fieldId:'mytitle', type:'S', tree:'$tree', destdiv:'sourceresults'});";
?>
<div class="databack ajaxwindow" style="display:none;" id="findsource">
    <form action="" method="post" name="findsourceform1" id="findsourceform1" onsubmit="return <?php echo $applyfilter; ?>">
        <h3 class="subhead"><?php echo _('Find Source ID'); ?><br>
            <span class="normal">(<?php echo _('Enter part of source title'); ?>)</span></h3>
        <table cellspacing="0" cellpadding="2" class="normal">
            <tr>
                <td><?php echo _('Title'); ?>:</td>
                <td>
                    <input type="text" name="mytitle" id="mytitle"
                        onkeyup="filterChanged(event, {form:'findsourceform1', fieldId:'mytitle', type:'S', tree:'<?php echo $tree; ?>', destdiv:'sourceresults'});">
                </td>
                <td>
                    <input type="submit" value="<?php echo _('Search'); ?>">
                    <input type="button" value="<?php echo _('Cancel'); ?>" onclick="gotoSection('findsource',prevsection);">
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <input type="radio" name="filter" value="s" onclick="<?php echo $applyfilter; ?>"> <?php echo _('starts with'); ?> &nbsp;&nbsp;
                    <input type="radio" name="filter" value="c"
                        checked="checked"
                        onclick="<?php echo $applyfilter; ?>"> <?php echo _('contains'); ?>
                </td>
            </tr>
        </table>
    </form>

    <p><strong><?php echo _('Search Results'); ?></strong> (<?php echo _('click to select'); ?>)</p>

    <div id="sourceresults" style="width:605px;height:380px;overflow:auto;"></div>
</div>

<div class="databack ajaxwindow" style="display:none;" id="newsource">
    <form action="" method="post" name="newsourceform" id="newsourceform" onsubmit="return saveSource(this);">
        <div style="float:right;text-align:center;">
            <input type="submit" name="submit" class="bigsave" accesskey="s" value="<?php echo _('Save'); ?>">
            <p><a href="#" onclick="gotoSection('newsource',prevsection);"><?php echo _('Cancel'); ?></a></p>
        </div>
        <h3 class="subhead"><?php echo _('Add New Source'); ?> |
            <a href="#"
                onclick="return openHelp('<?php echo $helplang; ?>/sources_help.php#add', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();"><?php echo _('Help for this area'); ?></a>
        </h3>
        <span class="normal"><strong><?php echo _('Please prefix Source ID with \"S\" for \"Source\"'); ?></strong></span><br>
        <table cellspacing="0" cellpadding="2" class="normal">
            <tr>
                <td><?php echo _('Source ID'); ?>:</td>
                <td>
                    <input type="hidden" name="tree1" value="<?php echo $tree; ?>">
                    <input type="text" name="sourceID" id="sourceIDnew" size="10" onBlur="this.value=this.value.toUpperCase()">
                    <input type="button" value="<?php echo _('Generate'); ?>" onclick="generateID('source',document.newsourceform.sourceIDnew);">
                    <input type="button" value="<?php echo _('Check'); ?>" onclick="checkID(document.newsourceform.sourceIDnew.value,'source','checkmsg');">
                    <span id="checkmsg" class="normal"></span>
                </td>
            </tr>
            <?php include "micro_newsource.php"; ?>
        </table>
        <p class="normal"><strong><?php echo _('Note: Additional events and notes may be added after the new source has been saved.'); ?></strong></p>
    </form>
</div>
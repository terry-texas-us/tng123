<?php
include "begin.php";
include "adminlib.php";
require_once "./admin/trees.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
$iconChevronDown = buildSvgElement("img/chevron-down.svg", ["class" => "w-3 h-3 ml-2 fill-current inline-block"]);
if ((!$allow_edit && (!$allow_add || !$added)) || ($assignedtree && $assignedtree != $tree)) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}
initMediaTypes();
$sourceID = ucfirst($sourceID);

$treerow = getTree($trees_table, $tree);

$query = "SELECT *, DATE_FORMAT(changedate,\"%d %b %Y %H:%i:%s\") AS changedate FROM $sources_table WHERE sourceID = \"$sourceID\" AND gedcom = '$tree'";
$result = tng_query($query);
$row = tng_fetch_assoc($result);
tng_free_result($result);
$row['shorttitle'] = preg_replace("/\"/", "&#34;", $row['shorttitle']);
$row['title'] = preg_replace("/\"/", "&#34;", $row['title']);
$row['author'] = preg_replace("/\"/", "&#34;", $row['author']);
$row['callnum'] = preg_replace("/\"/", "&#34;", $row['callnum']);
$row['publisher'] = preg_replace("/\"/", "&#34;", $row['publisher']);
$row['actualtext'] = preg_replace("/\"/", "&#34;", $row['actualtext']);

$sourcename = $row['title'] ? $row['title'] : $row['shorttitle'];
$row['allow_living'] = 1;

$query = "SELECT DISTINCT eventID AS eventID FROM $notelinks_table WHERE persfamID=\"$sourceID\" AND gedcom ='$tree'";
$notelinks = tng_query($query);
$gotnotes = [];
while ($note = tng_fetch_assoc($notelinks)) {
    if (!$note['eventID']) $note['eventID'] = "general";

    $gotnotes[$note['eventID']] = "*";
}

$helplang = findhelp("sources_help.php");

tng_adminheader(_('Edit Existing Source'), $flags);
$photo = showSmallPhoto($sourceID, $sourcename, 1, 0, "S");
include_once "eventlib.php";
include_once "eventlib_js.php";
?>
<script>
    var persfamID = "<?php echo $sourceID; ?>";
    var allow_cites = false;
    var allow_notes = true;
</script>
    <script src="js/selectutils.js"></script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$sourcetabs[0] = [1, "admin_sources.php", _('Search'), "findsource"];
$sourcetabs[1] = [$allow_add, "admin_newsource.php", _('Add New'), "addsource"];
$sourcetabs[2] = [$allow_edit && $allow_delete, "admin_mergesources.php", _('Merge'), "merge"];
$sourcetabs[3] = [$allow_edit, "admin_editsource.php?sourceID=$sourceID&tree=$tree", _('Edit'), "edit"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/sources_help.php#edit');\" class='lightlink'>" . _('Help for this area') . "</a>";
$innermenu .= " &nbsp;|&nbsp; <a href=\"showsource.php?sourceID=$sourceID&amp;tree=$tree\" target='_blank' class='lightlink'>" . _('Test') . "</a>";
if ($allow_add && (!$assignedtree || $assignedtree == $tree)) {
    $innermenu .= " &nbsp;|&nbsp; <a href=\"admin_newmedia.php?personID=$sourceID&amp;tree=$tree&amp;linktype=S\" class='lightlink'>" . _('Add Media') . "</a>";
}
$menu = doMenu($sourcetabs, "edit", $innermenu);
echo displayHeadline(_('Sources') . " &gt;&gt; " . _('Edit Existing Source'), "img/sources_icon.gif", $menu, $message);
?>

    <form action="admin_updatesource.php" method="post" name="form1">
        <table class="lightback">
            <tr class="databack">
            <td class="tngshadow">
                <table cellpadding="0" cellspacing="0" class="normal">
                    <tr>
                        <td class='align-top'>
                            <div id="thumbholder" style="margin-right:5px;<?php if (!$photo) {
                                echo "display:none";
                            } ?>"><?php echo $photo; ?></div>
                        </td>
                        <td>
				<span class="plainheader"><?php echo "$sourcename ($sourceID)</span>"; ?>
				<div class="topbuffer bottombuffer smallest">
<?php
$notesicon = $gotnotes['general'] ? "admin-note-on-icon" : "admin-note-off-icon";
echo "<a href='#' onclick=\"document.form1.submit();\" class=\"smallicon si-plus admin-save-icon\">" . _('Save') . "</a>\n";
echo "<a href='#' onclick=\"return showNotes('', '$sourceID');\" id='notesicon' class=\"smallicon si-plus $notesicon\">" . _('Notes') . "</a>\n";
?>
                <br class="clear-both">
				</div>
				<span class="smallest"><?php echo _('Last Modified Date') . ": {$row['changedate']} ({$row['changedby']})"; ?></span>
                        </td>
                    </tr>
                </table>
            </td>
            </tr>
            <tr class="databack">
                <td class="tngshadow">
                    <table class="normal">
                        <tr>
                            <td><?php echo _('Tree'); ?>:</td>
                            <td>
                                <?php echo $treerow['treename']; ?>
                                &nbsp;(<a href="#" onclick="return openChangeTree('source','<?php echo $tree; ?>','<?php echo $sourceID; ?>');">
                                    <?php echo "" . _('Edit') . "$iconChevronDown"; ?>
                                </a> )
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Short Title'); ?>:</td>
                            <td>
                                <input type="text" name="shorttitle" size="40" value="<?php echo $row['shorttitle']; ?>">
                                (<?php echo _('required'); ?>)
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Long Title'); ?>:</td>
                            <td>
                                <input type="text" name="title" size="50" value="<?php echo $row['title']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Author'); ?>:</td>
                            <td>
                                <input type="text" name="author" size="40" value="<?php echo $row['author']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Call Number'); ?>:</td>
                            <td>
                                <input type="text" name="callnum" size="20" value="<?php echo $row['callnum']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Publisher'); ?>:</td>
                            <td>
                                <input type="text" name="publisher" size="40" value="<?php echo $row['publisher']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Repository'); ?>:</td>
                            <td>
                                <select name="repoID">
                                    <option value=""></option>
                                    <?php
                                    $query = "SELECT repoID, reponame, gedcom FROM $repositories_table WHERE gedcom = '$tree' ORDER BY reponame";
                                    $reporesult = tng_query($query);
                                    while ($reporow = tng_fetch_assoc($reporesult)) {
                                        echo "		<option value=\"{$reporow['repoID']}\"";
                                        if ($reporow['repoID'] == $row['repoID']) {
                                            echo " selected";
                                    }
                                    if (!$assignedtree && $numtrees > 1) {
                                        echo ">{$reporow['reponame']} (" . _('Tree') . ": {$reporow['gedcom']})</option>\n";
                                    } else {
                                        echo ">{$reporow['reponame']}</option>\n";
                                    }
                                    }
                                    tng_free_result($reporesult);
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class='align-top'><?php echo _('Actual Text'); ?>:</td>
                            <td><textarea cols="50" rows="5" name="actualtext"><?php echo $row['actualtext']; ?></textarea></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <br/>
                                <p class="subhead font-medium">
                                    <?php echo "" . _('Other Events') . ": <input type='button' value=\" " . _('Add New') . " \" onclick=\"newEvent('S', '$sourceID', '$tree');\">\n"; ?>
                                </p>
                            </td>
                        </tr>
                        <?php showCustEvents($sourceID); ?>
                    </table>
                </td>
            </tr>
            <tr class="databack">
                <td class="tngshadow">
                    <p class="normal">
                        <?php
                        echo _('On save') . ":<br>";
                        echo "<input type='radio' name='newscreen' value='return'> " . _('Return to this page') . "<br>\n";
                        if ($cw) {
                            echo "<input type='radio' name='newscreen' value=\"close\" checked> " . _('Close this window') . "\n";
                        } else {
                            echo "<input type='radio' name='newscreen' value=\"none\" checked> " . _('Return to menu') . "\n";
                        }
                        ?>
                    </p>
                    <input type="hidden" name="tree" value="<?php echo $tree; ?>">
                    <input type="hidden" name="sourceID" value="<?php echo "$sourceID"; ?>">
                    <input type="hidden" value="<?php echo "$cw"; ?>" name="cw">
                    <input type="submit" class="btn" name="submit2" accesskey="s" value="<?php echo _('Save'); ?>">
                </td>
            </tr>

        </table>
    </form>

<?php echo tng_adminfooter(); ?>
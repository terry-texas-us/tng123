<?php
include "begin.php";
include "adminlib.php";
require_once "./admin/trees.php";

$textpart = "sources";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if ((!$allow_edit && (!$allow_add || !$added)) || ($assignedtree && $assignedtree != $tree)) {
    $message = $admtext['norights'];
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
    if (!$note['eventID']) {
        $note['eventID'] = "general";
    }
    $gotnotes[$note['eventID']] = "*";
}

$helplang = findhelp("sources_help.php");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['modifysource'], $flags);
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

$sourcetabs[0] = [1, "admin_sources.php", $admtext['search'], "findsource"];
$sourcetabs[1] = [$allow_add, "admin_newsource.php", $admtext['addnew'], "addsource"];
$sourcetabs[2] = [$allow_edit && $allow_delete, "admin_mergesources.php", $admtext['merge'], "merge"];
$sourcetabs[3] = [$allow_edit, "admin_editsource.php?sourceID=$sourceID&tree=$tree", $admtext['edit'], "edit"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/sources_help.php#edit');\" class='lightlink'>{$admtext['help']}</a>";
$innermenu .= " &nbsp;|&nbsp; <a href=\"showsource.php?sourceID=$sourceID&amp;tree=$tree\" target='_blank' class='lightlink'>{$admtext['test']}</a>";
if ($allow_add && (!$assignedtree || $assignedtree == $tree)) {
    $innermenu .= " &nbsp;|&nbsp; <a href=\"admin_newmedia.php?personID=$sourceID&amp;tree=$tree&amp;linktype=S\" class='lightlink'>{$admtext['addmedia']}</a>";
}
$menu = doMenu($sourcetabs, "edit", $innermenu);
echo displayHeadline($admtext['sources'] . " &gt;&gt; " . $admtext['modifysource'], "img/sources_icon.gif", $menu, $message);
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
echo "<a href='#' onclick=\"document.form1.submit();\" class=\"smallicon si-plus admin-save-icon\">{$admtext['save']}</a>\n";
echo "<a href='#' onclick=\"return showNotes('', '$sourceID');\" id='notesicon' class=\"smallicon si-plus $notesicon\">{$admtext['notes']}</a>\n";
?>
                <br style="clear: both;">
				</div>
				<span class="smallest"><?php echo $admtext['lastmodified'] . ": {$row['changedate']} ({$row['changedby']})"; ?></span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="databack">
            <td class="tngshadow">
                <table class="normal">
                    <tr>
                        <td><?php echo $admtext['tree']; ?>:</td>
                        <td>
                            <?php echo $treerow['treename']; ?>
                            &nbsp;(<a href="#" onclick="return openChangeTree('source','<?php echo $tree; ?>','<?php echo $sourceID; ?>');"><img src="img/ArrowDown.gif" style="margin-left:-4px;margin-right:-2px;"><?php echo $admtext['edit']; ?>
                            </a> )
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $admtext['shorttitle']; ?>:</td>
                        <td>
                            <input type="text" name="shorttitle" size="40" value="<?php echo $row['shorttitle']; ?>">
                            (<?php echo $admtext['required']; ?>)
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $admtext['longtitle']; ?>:</td>
                        <td>
                            <input type="text" name="title" size="50" value="<?php echo $row['title']; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $admtext['author']; ?>:</td>
                        <td>
                            <input type="text" name="author" size="40" value="<?php echo $row['author']; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $admtext['callnumber']; ?>:</td>
                        <td>
                            <input type="text" name="callnum" size="20" value="<?php echo $row['callnum']; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $admtext['publisher']; ?>:</td>
                        <td>
                            <input type="text" name="publisher" size="40" value="<?php echo $row['publisher']; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $admtext['repository']; ?>:</td>
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
                                        echo ">{$reporow['reponame']} ({$admtext['tree']}: {$reporow['gedcom']})</option>\n";
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
                        <td class='align-top'><?php echo $admtext['actualtext']; ?>:</td>
                        <td><textarea cols="50" rows="5" name="actualtext"><?php echo $row['actualtext']; ?></textarea></td>
                    </tr>
                </table>
                <br>
                <table class="normal">
                    <tr>
                        <td class='align-top'>
                            <h3 class="subhead" style="color:black;"><?php echo $admtext['otherevents']; ?>:</h3>
                            <?php echo "<p><input type='button' value=\"  " . $admtext['addnew'] . "  \" onclick=\"newEvent('S','$sourceID','$tree');\"></p>\n"; ?>
                        </td>
                        <td class='align-top'>
                            <?php showCustEvents($sourceID); ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="databack">
            <td class="tngshadow">
                <p class="normal">
                    <?php
                    echo $admtext['onsave'] . ":<br>";
                    echo "<input type='radio' name=\"newscreen\" value=\"return\"> {$admtext['savereturn']}<br>\n";
                    if ($cw) {
                        echo "<input type='radio' name=\"newscreen\" value=\"close\" checked> {$text['closewindow']}\n";
                    } else {
                        echo "<input type='radio' name=\"newscreen\" value=\"none\" checked> {$admtext['saveback']}\n";
                    }
                    ?>
                </p>
                <input type="hidden" name="tree" value="<?php echo $tree; ?>">
                <input type="hidden" name="sourceID" value="<?php echo "$sourceID"; ?>">
                <input type="hidden" value="<?php echo "$cw"; ?>" name="cw">
                <input type="submit" class="btn" name="submit2" accesskey="s" value="<?php echo $admtext['save']; ?>">
            </td>
        </tr>

    </table>
</form>

<?php echo tng_adminfooter(); ?>
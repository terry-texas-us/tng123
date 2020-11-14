<?php
include "begin.php";
include "adminlib.php";
require_once "./admin/trees.php";
$textpart = "sources";
include "$mylanguage/admintext.php";
$admin_login = 1;
include "checklogin.php";
include "version.php";
$iconChevronDown = buildSvgElement("img/chevron-down.svg", ["class" => "w-3 h-3 ml-2 fill-current inline-block"]);
if ((!$allow_edit && (!$allow_add || !$added)) || ($assignedtree && $assignedtree != $tree)) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}
$repoID = ucfirst($repoID);
$treerow = getTree($trees_table, $tree);

$query = "SELECT reponame, changedby, repositories.addressID, address1, address2, city, state, zip, country, phone, email, www, DATE_FORMAT(changedate,\"%d %b %Y %H:%i:%s\") AS changedate ";
$query .= "FROM $repositories_table repositories ";
$query .= "LEFT JOIN $address_table address ON repositories.addressID = address.addressID ";
$query .= "WHERE repoID = '$repoID' AND repositories.gedcom = '$tree'";
$result = tng_query($query);
$row = tng_fetch_assoc($result);
tng_free_result($result);
$row['reponame'] = preg_replace("/\"/", "&#34;", $row['reponame']);

$row['allow_living'] = 1;

$query = "SELECT DISTINCT eventID AS eventID FROM $notelinks_table WHERE persfamID='$repoID' AND gedcom ='$tree'";
$notelinks = tng_query($query);
$gotnotes = [];
while ($note = tng_fetch_assoc($notelinks)) {
    if (!$note['eventID']) $note['eventID'] = "general";

    $gotnotes[$note['eventID']] = "*";
}

$helplang = findhelp("repositories_help.php");

tng_adminheader(_('Edit Existing Repository'), $flags);
$photo = showSmallPhoto($repoID, $row['reponame'], 1, 0, "R");
include_once "eventlib.php";
include_once "eventlib_js.php";
?>
    <script>
        var persfamID = "<?php echo $repoID; ?>";
        var allow_cites = false;
        var allow_notes = true;
    </script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$repotabs[0] = [1, "admin_repositories.php", _('Search'), "findrepo"];
$repotabs[1] = [$allow_add, "admin_newrepo.php", _('Add New'), "addrepo"];
$repotabs[2] = [$allow_edit && $allow_delete, "admin_mergerepos.php", _('Merge'), "merge"];
$repotabs[3] = [$allow_edit, "admin_editrepo.php?repoID=$repoID&tree=$tree", _('Edit'), "edit"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/repositories_help.php#repoedit');\" class='lightlink'>" . _('Help for this area') . "</a>";
$innermenu .= " &nbsp;|&nbsp; <a href=\"showrepo.php?repoID=$repoID&amp;tree=$tree\" target='_blank' class='lightlink'>" . _('Test') . "</a>";
if ($allow_add && (!$assignedtree || $assignedtree == $tree)) {
    $innermenu .= " &nbsp;|&nbsp; <a href=\"admin_newmedia.php?personID=$repoID&amp;tree=$tree&amp;linktype=R\" class='lightlink'>" . _('Add Media') . "</a>";
}
$menu = doMenu($repotabs, "edit", $innermenu);
echo displayHeadline(_('Repositories') . " &gt;&gt; " . _('Edit Existing Repository'), "img/repos_icon.gif", $menu, $message);
?>

    <form action="admin_updaterepo.php" method="post" name="form1">
        <table class="lightback">
            <tr class="databack">
            <td class="tngshadow">
                <table cellpadding="0" cellspacing="0" class="normal">
                    <tr>
                        <td class='align-top'>
                            <div id="thumbholder" style="margin-right:5px;<?php if (!$photo) {
                                echo "display:none";
                            } ?>"><?php echo $photo; ?>
                            </div>
                        </td>
                        <td>
                            <span class="plainheader"><?php echo $row['reponame'] . " ($repoID)</span>"; ?>
                            <div class="topbuffer bottombuffer smallest">
                                <?php
                                $notesicon = "img/" . ($gotnotes['general'] ? "tng_anote_on.gif" : "tng_anote.gif");
                                echo "<a href='#' onclick=\"document.form1.submit();\" class=\"smallicon si-plus admin-save-icon\">" . _('Save') . "</a>\n";
                                echo "<a href='#' onclick=\"return showNotes('', '$repoID');\" id='notesicon' class=\"smallicon si-plus $notesicon\">" . _('Notes') . "</a>\n";
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
                                </a>)
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Name'); ?>:</td>
                            <td>
                                <input type="text" name="reponame" size="40" value="<?php echo $row['reponame']; ?>">
                                (<?php echo _('required'); ?>)
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Address 1'); ?>:</td>
                            <td>
                                <input type="text" name="address1" size="50" value="<?php echo $row['address1']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Address 2'); ?>:</td>
                            <td>
                                <input type="text" name="address2" size="50" value="<?php echo $row['address2']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('City'); ?>:</td>
                            <td>
                                <input type="text" name="city" size="50" value="<?php echo $row['city']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('State/Province'); ?>:</td>
                            <td>
                                <input type="text" name="state" size="50" value="<?php echo $row['state']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Zip/Postal Code'); ?>:</td>
                            <td>
                                <input type="text" name="zip" size="20" value="<?php echo $row['zip']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Country'); ?>:</td>
                            <td>
                                <input type="text" name="country" size="50" value="<?php echo $row['country']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Phone'); ?>:</td>
                            <td>
                                <input type="text" name="phone" size="30" value="<?php echo $row['phone']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('E-mail'); ?>:</td>
                            <td>
                                <input type="text" name="email" size="50" value="<?php echo $row['email']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Web Site'); ?>:</td>
                            <td>
                                <input type="text" name="www" size="50" value="<?php echo $row['www']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <br/>
                                <p class="subhead font-medium">
                                    <?php echo "" . _('Other Events') . ": <input type='button' value=\" " . _('Add New') . " \" onclick=\"newEvent('R', '$repoID', '$tree');\">\n"; ?>
                                </p>
                            </td>
                        </tr>
                        <?php showCustEvents($repoID); ?>
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
                    <input type="hidden" name="addressID" value="<?php echo $row['addressID']; ?>">
                    <input type="hidden" name="repoID" value="<?php echo "$repoID"; ?>">
                    <input type="hidden" value="<?php echo "$cw"; ?>" name="cw">
                    <input type="submit" name="submit2" class="btn" accesskey="s" value="<?php echo _('Save'); ?>">
                </td>
            </tr>

        </table>
    </form>

<?php echo tng_adminfooter(); ?>
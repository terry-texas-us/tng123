<?php
include "begin.php";
include "adminlib.php";
require_once "./admin/trees.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
include "config/importconfig.php";

if (!$allow_add || !$allow_edit || $assignedbranch) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

if ($assignedtree) $wherestr = "WHERE gedcom = '$assignedtree'";

else {
    $wherestr = "";
}
$query = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";
$result = tng_query($query);
$numtrees = tng_num_rows($result);

if (!isset($tngimpcfg['defimpopt'])) $tngimpcfg['defimpopt'] = 0;
if (!isset($debug)) $debug = false;

$treenum = 0;
$trees = [];
$treename = [];
while ($treerow = tng_fetch_assoc($result)) {
    $trees[$treenum] = $treerow['gedcom'];
    $treename[$treenum] = $treerow['treename'];
    $treenum++;
}
tng_free_result($result);

$helplang = findhelp("data_help.php");

tng_adminheader(_('Import/Export'), $flags);
?>
    <script src="js/mediautils.js"></script>
    <script src="js/dataimport.js"></script>
    <script>
        const opening = "<?php echo _('Opening'); ?>";
        const uploading = "<?php echo _('Uploading'); ?>";
        const peoplelbl = "<?php echo _('People'); ?>";
        const familieslbl = "<?php echo _('Families'); ?>";
        const sourceslbl = "<?php echo _('Sources'); ?>";
        const noteslbl = "<?php echo _('Notes'); ?>";
        const medialbl = "<?php echo _('Media'); ?>";
        const placeslbl = "<?php echo _('Places'); ?>";
        const stopmsg = "<?php echo _('Stop'); ?>";
        const stoppedmsg = "<?php echo _('Import stopped'); ?>";
        const resumemsg = "<?php echo _('Resume'); ?>";
        const reopenmsg = "<?php echo _('Reopening'); ?>";
        var saveimport = "<?php echo $saveimport; ?>";
        var checksecs = <?php if (isset($checksecs)) {
            echo $checksecs * 1000;
        } else {
            echo "10000";
        } ?>;
        const selectimportfile = "<?php echo _('Please select a file to import.'); ?>";
        const selectdesttree = "<?php echo _('Please select or enter a destination tree.'); ?>";
        const entertreeid = "<?php echo _('Please enter a tree ID.'); ?>";
        const alphanum = "<?php echo _('Please use only alphanumeric characters in your Tree ID.'); ?>";
        const entertreename = "<?php echo _('Please enter a tree name.'); ?>";
        const confdeletefile = "<?php echo _('Are you sure you want to delete this file?'); ?>";
        var branches = new Array();
        var branchcounts = new Array();
        <?php
        $treectr = 0;
        for ($i = 0; $i < $treenum; $i++) {
            $treeref = $trees[$i] ? $trees[$i] : "none";
            echo "branchcounts['$treeref']=-1;\n";
            $treectr++;
        }
    if ($treectr == 1) {
        echo "jQuery(document).ready(function(){getBranches(document.getElementById('tree1'),1);});\n";
    }
    ?>
</script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$allow_export = 1;
if (!$allow_ged && $assignedtree) {
    $query = "SELECT disallowgedcreate FROM $trees_table WHERE gedcom = '$assignedtree'";
    $disresult = tng_query($query);
    $row = tng_fetch_assoc($disresult);
    if ($row['disallowgedcreate']) $allow_export = 0;

    tng_free_result($disresult);
}

$datatabs['0'] = [1, "admin_dataimport.php", _('Import'), "import"];
$datatabs['1'] = [$allow_export, "admin_export.php", _('Export'), "export"];
$datatabs['2'] = [1, "admin_secondmenu.php", _('Secondary Processes'), "second"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/data_help.php');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($datatabs, "import", $innermenu);
echo displayHeadline(_('Import/Export') . " &gt;&gt; " . _('GEDCOM Import'), "img/data_icon.gif", $menu, (isset($message) ? $message : ""));
?>

    <form action="admin_gedimport.php" target="results" name="form1" method="post" enctype="multipart/form-data" onsubmit="return checkFile(this);">
        <table class="lightback">
            <tr class="databack">
                <td class="tngshadow">
                    <div class="normal">
                        <em><?php echo _('Add to or replace your genealogy (may take several minutes, depending on the size of your file)'); ?></em><br><br>

                        <h3 class="subhead"><?php echo _('Import GEDCOM (standard 5.5 format)'); ?>:</h3>
                        <table cellpadding="1" class="normal">
                            <tr>
                                <td>&nbsp;&nbsp;<?php echo _('From your computer'); ?>:</td>
                                <td>
                                    <input type="file" name="remotefile" size="50">
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;&nbsp;<strong><?php echo _('OR'); ?></strong> &nbsp;<?php echo _('From web site (in GEDCOM folder)'); ?>:</td>
                                <td>
                                    <input type="text" name="database" id="database" size="50">
                                    <input type="hidden" id="database_org" value="">
                                    <input type="hidden" id="database_last" value="">
                                    <input
                                        type="button"
                                        value="<?php echo _('Select') . "..."; ?>"
                                        name="gedselect" onclick="FilePicker('database','gedcom');">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><br>
                                    <input type="checkbox" name="allevents" value="yes"
                                        onclick="if(document.form1.allevents.checked && document.form1.eventsonly.checked) {document.form1.eventsonly.checked ='';toggleSections(false)}"> <?php echo _('Accept data for all new Custom Event Types'); ?>
                                    &nbsp;&nbsp;
                                    <input type="checkbox" name="eventsonly" value="yes" onclick="toggleSections(this.checked);"> <?php echo _('Import Custom Event Types only (no data is added, replaced or appended)'); ?>
                                </td>
                            </tr>
                        </table>
                </td>
            </tr>
            <tr class="databack">
                <td class="tngshadow" id="desttree">
                    <h3 class="subhead"><?php echo _('Import into'); ?>:</h3>
                    <table cellpadding="1" class="normal">
                        <tr id="desttree2">
                            <td>&nbsp;&nbsp;<?php echo _('Destination Tree'); ?>:</td>
                            <td>
                                <select name="tree1" id="tree1" onchange="getBranches(this,this.selectedIndex);">
                                    <?php
                                    if ($numtrees != 1) echo "	<option value=''></option>\n";

                                    $treectr = 0;
                                    for ($i = 0; $i < $treenum; $i++) {
                                        echo "<option value='{$trees[$treectr]}'";
                                        if (!empty($newtree) && $newtree == $trees[$treectr]) {
                                            echo " selected";
                                    }
                                    echo ">{$treename[$treectr]}</option>\n";
                                    $treectr++;
                                }
                                    ?>
                                </select>
                                <?php if (!$assignedtree) { ?>
                                    &nbsp;
                                    <input type="button" name="newtree" value="<?php echo _('Add New Tree'); ?>"
                                        onclick="tnglitbox = new LITBox('admin_newtree.php?beforeimport=yes', {width:600, height:530});">
                                <?php } ?>
                            </td>
                        </tr>
                        <tr id="destbranch" style="display:none;">
                            <td>&nbsp;&nbsp;<?php echo _('Destination Branch (optional)'); ?>:</td>
                            <td>
                                <div id="branch1div">
                                    <select name="branch1" id="branch1">
                                    </select>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="databack">
                <td class="tngshadow">
                    <table cellpadding="1" class="normal">
                        <tr id="replace">
                            <td colspan="2">
                                <h3 class="subhead"><?php echo _('Replace (in selected tree)'); ?>:</h3>
                                <input type="radio" name="del" value="yes"<?php if ($tngimpcfg['defimpopt'] == 1) {
                                    echo " checked";
                                } ?> onclick="document.form1.norecalc.checked = false; toggleNorecalcdiv(0); toggleAppenddiv(0);"> <?php echo _('All current data'); ?> &nbsp;
                                <input type="radio" name="del" value="match"<?php if (!$tngimpcfg['defimpopt']) {
                                    echo " checked";
                                } ?> onclick="toggleNorecalcdiv(1); toggleAppenddiv(0);"> <?php echo _('Matching records only'); ?> &nbsp;
                                <input type="radio" name="del" value="no"<?php if ($tngimpcfg['defimpopt'] == 2) {
                                    echo " checked";
                                } ?> onclick="document.form1.norecalc.checked = false; toggleNorecalcdiv(0); toggleAppenddiv(0);"> <?php echo _('Do not replace any data'); ?> &nbsp;
                                <input type="radio" name="del" value="append"<?php if ($tngimpcfg['defimpopt'] == 3) {
                                    echo " checked";
                                } ?> onclick="document.form1.norecalc.checked = false; toggleNorecalcdiv(0); toggleAppenddiv(1);"> <?php echo _('Append all records'); ?><br><br>
                                <span
                                    class="smaller"><em><?php echo _('Hints: All Current Data means all people, families, sources and notes (media associations are not lost as long as IDs remain the same). Matches are always based on IDs only. New records are always added. Append imports all records with new IDs.'); ?></em></span>
                            </td>
                        </tr>
                        <tr id="ioptions">
                            <td class='align-top'>
                                <br>
                                <div>
                                    <input type="checkbox" name="ucaselast" value="1"> <?php echo _('Upper case all surnames'); ?></div>
                                <div id="norecalcdiv"<?php if ($tngimpcfg['defimpopt']) {
                                    echo " style='display: none;'";
                                } ?>>
                                    <input type="checkbox" name="norecalc" value="1"> <?php echo _('Do not recalculate Living flag'); ?><br>
                                    <input type="checkbox" name="neweronly" value="1"> <?php echo _('Replace only if newer'); ?><br>
                                </div>
                                <div>
                                    <input type="checkbox" name="importmedia" value="1"> <?php echo _('Import media if present'); ?></div>
                                <div>
                                    <input type="checkbox" name="importlatlong" value="1"> <?php echo _('Import latitude / longitude data if present'); ?></div>
                            </td>
                            <td class='align-top'>
                                <br>
                                <div id="appenddiv"<?php if ($tngimpcfg['defimpopt'] != 3) {
                                    echo " style='display: none;'";
                                } ?>>
                                    <input type="radio" name="offsetchoice" value="auto" checked> <?php echo _('Start IDs at first available number'); ?>&nbsp;<br>
                                    <input type="radio" name="offsetchoice" value="user"> <?php echo _('Start IDs at:'); ?>&nbsp;<input type="text" name="useroffset" size="10" maxlength="9">
                                </div>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <div style="float:right;" class="normal">
                        <input type="checkbox" name="old" id="old" value="1" onclick="toggleTarget(document.form1);"> <?php echo _('Old style import (no progress bar)'); ?>
                    </div>
                    <input type="submit" name="submit" class="btn" value="<?php echo _('Import Data'); ?>">
                </td>
            </tr>
        </table>
    </form>
    <iframe id="results" height="<?php if ($debug) {
        echo "30";
    } ?>0" width="<?php if ($debug) {
        echo "40";
    } ?>0" frameborder="0" name="results" onload="iframeLoaded();"/>
<?php echo tng_adminfooter(); ?>
<?php
include "begin.php";
include "adminlib.php";
require_once "./admin/trees.php";

$textpart = "index";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
include "config/importconfig.php";

if (!$allow_add || !$allow_edit || $assignedbranch) {
    $message = $admtext['norights'];
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

if (!isset($tngimpcfg['defimpopt'])) {
    $tngimpcfg['defimpopt'] = 0;
}
if (!isset($debug)) {
    $debug = false;
}

[$numtrees, $treenum, $trees, $treenames] = getOrderedTreesList2($assignedtree, $trees_table);

$helplang = findhelp("data_help.php");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['datamaint'], $flags);
?>
<script type="text/javascript" src="js/admin.js?v<?php echo $tng_version; ?>"></script>
<script type="text/javascript" src="js/mediautils.js?v<?php echo $tng_version; ?>"></script>
<script type="text/javascript" src="js/dataimport.js?v<?php echo $tng_version; ?>"></script>
<script type="text/javascript">
    const opening = "<?php echo $admtext['opening']; ?>";
    const uploading = "<?php echo $admtext['uploading']; ?>";
    const peoplelbl = "<?php echo $admtext['people']; ?>";
    const familieslbl = "<?php echo $admtext['families']; ?>";
    const sourceslbl = "<?php echo $admtext['sources']; ?>";
    const noteslbl = "<?php echo $admtext['notes']; ?>";
    const medialbl = "<?php echo $admtext['media']; ?>";
    const placeslbl = "<?php echo $admtext['places']; ?>";
    const stopmsg = "<?php echo $admtext['stop']; ?>";
    const stoppedmsg = "<?php echo $admtext['stopped']; ?>";
    const resumemsg = "<?php echo $admtext['resume']; ?>";
    const reopenmsg = "<?php echo $admtext['reopen']; ?>";
    var saveimport = "<?php echo $saveimport; ?>";
    var checksecs = <?php if (isset($checksecs)) {
        echo $checksecs * 1000;
    } else {
        echo "10000";
    } ?>;
    const selectimportfile = "<?php echo $admtext['selectimportfile']; ?>";
    const selectdesttree = "<?php echo $admtext['selectdesttree']; ?>";
    const entertreeid = "<?php echo $admtext['entertreeid']; ?>";
    const alphanum = "<?php echo $admtext['alphanum']; ?>";
    const entertreename = "<?php echo $admtext['entertreename']; ?>";
    const confdeletefile = "<?php echo $admtext['confdeletefile']; ?>";

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
</head>

<body class="admin-body">

<?php
$allow_export = 1;
if (!$allow_ged && $assignedtree) {
    $query = "SELECT disallowgedcreate FROM $trees_table WHERE gedcom = '$assignedtree'";
    $disresult = tng_query($query);
    $row = tng_fetch_assoc($disresult);
    if ($row['disallowgedcreate']) {
        $allow_export = 0;
    }
    tng_free_result($disresult);
}

$datatabs['0'] = array(1, "admin_dataimport.php", $admtext['import'], "import");
$datatabs['1'] = array($allow_export, "admin_export.php", $admtext['export'], "export");
$datatabs['2'] = array(1, "admin_secondmenu.php", $admtext['secondarymaint'], "second");
$innermenu = "<a href=\"#\" onclick=\"return openHelp('$helplang/data_help.php');\" class=\"lightlink\">{$admtext['help']}</a>";
$menu = doMenu($datatabs, "import", $innermenu);
echo displayHeadline($admtext['datamaint'] . " &gt;&gt; " . $admtext['gedimport'], "img/data_icon.gif", $menu, (isset($message) ? $message : ""));
?>

<form action="admin_gedimport.php" target="results" name="form1" method="post" ENCTYPE="multipart/form-data" onsubmit="return checkFile(this);">
    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <div class="normal">
                    <em><?php echo $admtext['addreplacedata']; ?></em><br><br>

                    <h3 class="subhead"><?php echo $admtext['importgedcom']; ?>:</h3>
                    <table cellpadding="1" class="normal">
                        <tr>
                            <td>&nbsp;&nbsp;<?php echo $admtext['fromyourcomputer']; ?>:</td>
                            <td>
                                <input type="file" name="remotefile" size="50">
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp;<strong><?php echo $admtext['text_or']; ?></strong> &nbsp;<?php echo $admtext['onwebserver']; ?>:</td>
                            <td>
                                <input type="text" name="database" id="database" size="50">
                                <input type="hidden" id="database_org" value="">
                                <input type="hidden" id="database_last" value="">
                                <input
                                    type="button"
                                    value="<?php echo $admtext['select'] . "..."; ?>"
                                    name="gedselect" onclick="FilePicker('database','gedcom');">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><br>
                                <input type="checkbox" name="allevents" value="yes"
                                       onclick="if(document.form1.allevents.checked && document.form1.eventsonly.checked) {document.form1.eventsonly.checked ='';toggleSections(false)}"> <?php echo $admtext['allevents']; ?>
                                &nbsp;&nbsp;
                                <input type="checkbox" name="eventsonly" value="yes" onclick="toggleSections(this.checked);"> <?php echo $admtext['eventsonly']; ?>
                            </td>
                        </tr>
                    </table>
            </td>
        </tr>
        <tr class="databack">
            <td class="tngshadow" id="desttree">
                <h3 class="subhead"><?php echo $admtext['selectexisting']; ?>:</h3>
                <table cellpadding="1" class="normal">
                    <tr id="desttree2">
                        <td>&nbsp;&nbsp;<?php echo $admtext['desttree']; ?>:</td>
                        <td>
                            <select name="tree1" id="tree1" onchange="getBranches(this,this.selectedIndex);">
                                <?php
                                if ($numtrees != 1) {
                                    echo "	<option value=\"\"></option>\n";
                                }
                                $treectr = 0;
                                for ($i = 0; $i < $treenum; $i++) {
                                    echo "	<option value=\"{$trees[$treectr]}\"";
                                    if (!empty($newtree) && $newtree == $trees[$treectr]) {
                                        echo " selected";
                                    }
                                    echo ">{$treenames[$treectr]}</option>\n";
                                    $treectr++;
                                }
                                ?>
                            </select>
                            <?php
                            if (!$assignedtree) {
                                ?>
                                &nbsp;
                                <input type="button" name="newtree" value="<?php echo $admtext['addnewtree']; ?>"
                                       onclick="tnglitbox = new LITBox('admin_newtree.php?beforeimport=yes', {width:600, height:530});">
                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <tr id="destbranch" style="display:none;">
                        <td>&nbsp;&nbsp;<?php echo $admtext['destbranch']; ?>:</td>
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
                            <h3 class="subhead"><?php echo $admtext['replace']; ?>:</h3>
                            <input type="radio" name="del" value="yes"<?php if ($tngimpcfg['defimpopt'] == 1) {
                                echo " checked";
                            } ?> onclick="document.form1.norecalc.checked = false; toggleNorecalcdiv(0); toggleAppenddiv(0);"> <?php echo $admtext['allcurrentdata']; ?> &nbsp;
                            <input type="radio" name="del" value="match"<?php if (!$tngimpcfg['defimpopt']) {
                                echo " checked";
                            } ?> onclick="toggleNorecalcdiv(1); toggleAppenddiv(0);"> <?php echo $admtext['matchingonly']; ?> &nbsp;
                            <input type="radio" name="del" value="no"<?php if ($tngimpcfg['defimpopt'] == 2) {
                                echo " checked";
                            } ?> onclick="document.form1.norecalc.checked = false; toggleNorecalcdiv(0); toggleAppenddiv(0);"> <?php echo $admtext['donotreplace']; ?> &nbsp;
                            <input type="radio" name="del" value="append"<?php if ($tngimpcfg['defimpopt'] == 3) {
                                echo " checked";
                            } ?> onclick="document.form1.norecalc.checked = false; toggleNorecalcdiv(0); toggleAppenddiv(1);"> <?php echo $admtext['appendall']; ?><br><br>
                            <span class="smaller"><em><?php echo $admtext['imphints']; ?></em></span>
                        </td>
                    </tr>
                    <tr id="ioptions">
                        <td valign="top">
                            <br>
                            <div>
                                <input type="checkbox" name="ucaselast" value="1"> <?php echo $admtext['ucaselast']; ?></div>
                            <div id="norecalcdiv"<?php if ($tngimpcfg['defimpopt']) {
                                echo " style=\"display:none;\"";
                            } ?>>
                                <input type="checkbox" name="norecalc" value="1"> <?php echo $admtext['norecalc']; ?><br>
                                <input type="checkbox" name="neweronly" value="1"> <?php echo $admtext['neweronly']; ?><br>
                            </div>
                            <div>
                                <input type="checkbox" name="importmedia" value="1"> <?php echo $admtext['importmedia']; ?></div>
                            <div>
                                <input type="checkbox" name="importlatlong" value="1"> <?php echo $admtext['importlatlong']; ?></div>
                        </td>
                        <td valign="top">
                            <br>
                            <div id="appenddiv"<?php if ($tngimpcfg['defimpopt'] != 3) {
                                echo " style=\"display:none;\"";
                            } ?>>
                                <input type="radio" name="offsetchoice" value="auto" checked> <?php echo $admtext['autooffset']; ?>&nbsp;<br>
                                <input type="radio" name="offsetchoice" value="user"> <?php echo $admtext['useroffset']; ?>&nbsp;<input type="text" name="useroffset" size="10" maxlength="9">
                            </div>
                        </td>
                    </tr>
                </table>
                <br>
                <div style="float:right;" class="normal">
                    <input type="checkbox" name="old" id="old" value="1" onclick="toggleTarget(document.form1);"> <?php echo $admtext['oldimport']; ?>
                </div>
                <input type="submit" name="submit" class="btn" value="<?php echo $admtext['importdata']; ?>">
            </td>
        </tr>
    </table>
</form>
<iframe id="results" height="<?php if ($debug) {
    echo "30";
} ?>0" width="<?php if ($debug) {
    echo "40";
} ?>0" frameborder="0" name="results" onload="iframeLoaded();"/>
<?php echo "<div style=\"text-align: center;\"><span class='normal'>$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
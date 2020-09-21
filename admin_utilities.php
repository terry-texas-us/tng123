<?php
include "begin.php";
include "adminlib.php";
$textpart = "setup";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";

if ($assignedtree) {
    $message = $admtext['norights'];
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

function getfiletime($filename) {
    global $fileflag, $time_offset;

    $filemodtime = "";
    if ($fileflag) {
        $filemod = filemtime($filename) + (3600 * $time_offset);
        $filemodtime = date("F j, Y h:i:s A", $filemod);
    }
    return $filemodtime;
}

function getfilesize($filename) {
    global $fileflag;

    $filesize = "";
    if ($fileflag) {
        $filesize = ceil(filesize($filename) / 1000) . " Kb";
    }
    return $filesize;
}

function doRow($table_name, $display_name) {
    global $admtext, $rootpath, $backuppath, $fileflag;

    echo "<tr>\n";
    echo "<td class='lightback'><div class=\"action-btns\"><a href=\"#\" onclick=\"return startOptimize('$table_name');\" title=\"{$admtext['optimize']}\" class=\"smallicon admin-opt-icon\"></a>";
    echo "<a href=\"#\" onclick=\"return startBackup('$table_name');\" title=\"{$admtext['backup']}\" class=\"smallicon admin-save-icon\"></a>";
    $fileflag = $table_name && file_exists("$rootpath$backuppath/$table_name.bak");
    echo "<a href=\"#\" id=\"rst_$table_name\" onclick=\"if( confirm('{$admtext['surerestore']}') ) {startRestore('$table_name') ;} return false;\" title=\"{$admtext['restore']}\" class=\"smallicon admin-rest-icon\"";
    if (!$fileflag) {
        echo " style=\"visibility:hidden\"";
    }
    echo "></a>";
    echo "</div></td>";
    echo "<td class='lightback normal' align=\"center\"><input type=\"checkbox\" class=\"tablechecks\" name=\"$table_name\" value='1' style=\"margin: 0; padding: 0;\"></td>\n";
    echo "<td class='lightback normal'>$display_name &nbsp;</td>\n";
    echo "<td class='lightback normal'><span id=\"time_$table_name\">" . getfiletime("$rootpath$backuppath/$table_name.bak") . "</span>&nbsp;</td>\n";
    echo "<td class='lightback normal' align=\"right\"><span id=\"size_$table_name\">" . getfilesize("$rootpath$backuppath/$table_name.bak") . "</span>&nbsp;</td>\n";
    echo "<td class='lightback normal'><span id=\"msg_$table_name\"></span>&nbsp;</td>\n";
    echo "</tr>\n";
}

$helplang = findhelp("backuprestore_help.php");

if (empty($sub)) {
    $sub = "tables";
}
if (!isset($message)) {
    $message = "";
}
$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['backuprestore'], $flags);
?>
<script type="text/javascript">
    function toggleAll(flag) {
        for (var i = 0; i < document.form1.elements.length; i++) {
            if (document.form1.elements[i].type == "checkbox") {
                if (flag)
                    document.form1.elements[i].checked = true;
                else
                    document.form1.elements[i].checked = false;
            }
        }
    }

    function startUtility(sel) {
        if (sel.selectedIndex < 1) return false;
        var checks = jQuery('.tablechecks');
        var totalchecked = 0;
        checks.each(function (index, item) {
            if (item.checked) {
                totalchecked = 1;
            }
        });
        if (totalchecked) {
            var selval = sel.options[sel.selectedIndex].value;
            var form = document.form1;
            switch (selval) {
                case "backupall":
                    form.action = 'admin_backup.php';
                    form.submit();
                    break;
                case "optimizeall":
                    form.action = 'admin_optimize.php';
                    form.submit();
                    break;
                case "restoreall":
                    if (confirm('<?php echo $admtext['surerestore']; ?>')) {
                        form.action = 'admin_restore.php';
                        form.submit();
                    }
                    break;
                case "delete":
                    if (confirm('<?php echo $admtext['suredelbk']; ?>')) {
                        form.table.value = 'del';
                        form.action = 'admin_backup.php?table=del';
                        form.submit();
                    }
                    break;
            }
        } else {
            alert('<?php echo $admtext['seltable']; ?>');
            sel.selectedIndex = 0;
        }
        return false;
    }

    function startBackup(table) {
        var params = {table: table};
        jQuery('#msg_' + table).html('<img src="img/spinner.gif">');
        jQuery.ajax({
            url: 'admin_backup.php',
            data: params,
            dataType: 'html',
            success: function (req) {
                var pairs = req.split('&');
                var table = pairs[0];
                var timestamp = pairs[1];
                var size = pairs[2];
                var message = pairs[3];
                jQuery('#msg_' + table).html(message);
                jQuery('#msg_' + table).effect('highlight', {}, 500);
                jQuery('#time_' + table).html(timestamp);
                jQuery('#time_' + table).effect('highlight', {}, 500);
                jQuery('#size_' + table).html(size);
                jQuery('#size_' + table).effect('highlight', {}, 500);
                jQuery('#rst_' + table).css('visibility', 'visible');
            }
        });
        return false;
    }

    function startOptimize(table) {
        var params = {table: table};
        jQuery('#msg_' + table).html('<img src="img/spinner.gif">');
        jQuery.ajax({
            url: 'admin_optimize.php',
            data: params,
            dataType: 'html',
            success: function (req) {
                var pairs = req.split('&');
                var table = pairs[0];
                var message = pairs[1];
                jQuery('#msg_' + table).html(message);
                jQuery('#msg_' + table).effect('highlight', {}, 500);
            }
        });
        return false;
    }

    function startRestore(table) {
        var params = {table: table};
        jQuery('#msg_' + table).html('<img src="img/spinner.gif">');
        jQuery.ajax({
            url: 'admin_restore.php',
            data: params,
            dataType: 'html',
            success: function (req) {
                var pairs = req.split('&');
                var table = pairs[0];
                var message = pairs[1];
                jQuery('#msg_' + table).html(message);
                jQuery('#msg_' + table).effect('highlight', {}, 500);
            }
        });
        return false;
    }
</script>
</head>

<body class="admin-body">

<?php
$utiltabs['0'] = array(1, "admin_utilities.php?sub=tables", $admtext['tables'], "tables");
$utiltabs['1'] = array(1, "admin_utilities.php?sub=structure", $admtext['tablestruct'], "structure");
$utiltabs['2'] = array(1, "admin_renumbermenu.php", $admtext['renumber'], "renumber");
$innermenu = "<a href=\"#\" onclick=\"return openHelp('$helplang/backuprestore_help.php');\" class=\"lightlink\">{$admtext['help']}</a>";
$menu = doMenu($utiltabs, $sub, $innermenu);
$headline = $sub == "tables" ? $admtext['backuprestore'] . " &gt;&gt; " . $admtext['backuprestoretables'] : $admtext['backuprestore'] . " &gt;&gt; " . $admtext['backupstruct'];
echo displayHeadline($headline, "img/backuprestore_icon.gif", $menu, $message);
?>

<table class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <?php
            if ($sub == "tables") {
                ?>
                <p class="normal"><em><?php echo $admtext['brinstructions']; ?></em></p>

                <h3 class="subhead"><?php echo $admtext['backuprestoretables']; ?></h3>
                <p class="normal"><?php echo $admtext['backupnote']; ?></p>
                <div class="normal">
                    <form action="" name="form1" id="form1" onsubmit="return startUtility(document.form1.withsel);">
                        <p>
                            <input type="hidden" name="table" value="all">
                            <input type="button" name="selectall" value="<?php echo $admtext['selectall']; ?>" onclick="toggleAll(1);">
                            <input type="button" name="clearall" value="<?php echo $admtext['clearall']; ?>" onclick="toggleAll(0);">&nbsp;&nbsp;
                            <?php echo $admtext['wsel']; ?>
                            <select name="withsel">
                                <option value=""></option>
                                <option value="backupall"><?php echo $admtext['backup']; ?></option>
                                <option value="optimizeall"><?php echo $admtext['optimize']; ?></option>
                                <option value="restoreall"><?php echo $admtext['restore']; ?></option>
                                <option value="delete"><?php echo $admtext['text_delete']; ?></option>
                            </select>
                            <input type="submit" name="go" value="<?php echo $admtext['go']; ?>">
                        </p>

                        <table class="normal">
                            <tr>
                                <th class="fieldnameback fieldname"><?php echo $admtext['action']; ?></th>
                                <th class="fieldnameback fieldname"><?php echo $admtext['select']; ?></th>
                                <th class="fieldnameback fieldname"><?php echo $admtext['table']; ?></th>
                                <th class="fieldnameback fieldname"><?php echo $admtext['lastbackup']; ?></th>
                                <th class="fieldnameback fieldname"><?php echo $admtext['backupfilesize']; ?></th>
                                <th class="fieldnameback fieldname" style="width:200px;"><?php echo $admtext['msg']; ?></th>
                            </tr>
                            <?php
                            doRow($address_table, $admtext['addresstable']);
                            doRow($albums_table, $admtext['albums']);
                            doRow($album2entities_table, $admtext['album2entitiestable']);
                            doRow($albumlinks_table, $admtext['albumlinkstable']);
                            doRow($assoc_table, $admtext['associations']);
                            doRow($branches_table, $admtext['branches']);
                            doRow($branchlinks_table, $admtext['brlinkstable']);
                            doRow($cemeteries_table, $admtext['cemeteries']);
                            doRow($children_table, $admtext['children']);
                            doRow($countries_table, $admtext['countriestable']);
                            doRow($dna_groups_table, $admtext['dna_groups']);
                            doRow($dna_links_table, $admtext['dna_links']);
                            doRow($dna_tests_table, $admtext['dna_tests']);
                            doRow($events_table, $admtext['events']);
                            doRow($eventtypes_table, $admtext['eventtypes']);
                            doRow($families_table, $admtext['families']);
                            doRow($languages_table, $admtext['languages']);
                            doRow($media_table, $admtext['mediatable']);
                            doRow($medialinks_table, $admtext['medialinkstable']);
                            doRow($mediatypes_table, $admtext['mediatypes']);
                            doRow($mostwanted_table, $admtext['mostwanted']);
                            doRow($notelinks_table, $admtext['notelinkstable']);
                            doRow($xnotes_table, $admtext['notes']);
                            doRow($people_table, $admtext['people']);
                            doRow($places_table, $admtext['places']);
                            doRow($reports_table, $admtext['reports']);
                            doRow($sources_table, $admtext['sources']);
                            doRow($repositories_table, $admtext['repositories']);
                            doRow($citations_table, $admtext['citations']);
                            doRow($states_table, $admtext['statestable']);
                            doRow($temp_events_table, $admtext['temptable']);
                            doRow($templates_table, $admtext['templatestable']);
                            doRow($tlevents_table, $admtext['tleventstable']);
                            doRow($trees_table, $admtext['trees']);
                            doRow($users_table, $admtext['users']);
                            ?>
                        </table>
                    </form>

                </div>

                <?php
            } elseif ($sub == "structure") {
                ?>
                <p class="normal"><em><?php echo $admtext['brinstructions2']; ?></em></p>

                <h3 class="subhead"><?php echo $admtext['backupstruct']; ?></h3>
                <div class="normal">
                    <table class="normal">
                        <tr>
                            <th class="fieldnameback"><span class="fieldname"><?php echo $admtext['action']; ?></span></th>
                            <th class="fieldnameback"><span class="fieldname"><?php echo $admtext['lastbackup']; ?></span></th>
                            <th class="fieldnameback"><span class="fieldname"><?php echo $admtext['backupfilesize']; ?></span></th>
                        </tr>
                        <tr>
                            <td class="lightback">
                                <div class="action-btns2"><a href="admin_backup.php?table=struct" title="<?php echo $admtext['backup']; ?>" class="smallicon admin-save-icon"></a>
                                    <?php
                                    if (file_exists("$rootpath$backuppath/tng_tablestructure.bak")) {
                                        $fileflag = 1;
                                        ?>
                                        <a href="admin_restore.php?table=struct" onClick="return confirm('<?php echo $admtext['surerestorets']; ?>');" title="<?php echo $admtext['restore']; ?>"
                                           class="smallicon admin-rest-icon"></a>
                                        <?php
                                    } else {
                                        $fileflag = 0;
                                    }
                                    ?>
                                </div>
                            </td>
                            <?php
                            if ($fileflag) {
                                echo "<td class='lightback'><span class='normal'>&nbsp;" . getfiletime("$rootpath$backuppath/tng_tablestructure.bak") . "&nbsp;</span></td>\n";
                                echo "<td class='lightback' align=\"right\"><span class='normal'>&nbsp;" . getfilesize("$rootpath$backuppath/tng_tablestructure.bak") . "&nbsp;</span></td>\n";
                            } else {
                                echo "<td class='lightback'><span class='normal'>&nbsp;</span></td>\n";
                                echo "<td class='lightback' align=\"right\"><span class='normal'>&nbsp;</span></td>\n";
                            }
                            ?>
                        </tr>
                    </table>

                </div>
                <?php
            }
            ?>
        </td>
    </tr>
</table>
<?php echo "<div style=\"text-align: center;\"><span class='normal'>$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
<?php

include "begin.php";
include "adminlib.php";
$textpart = "setup";
include "$mylanguage/admintext.php";

$treeList = [];
if ($link) {
    $admin_login = 1;
    include "checklogin.php";
    include "version.php";
    if ($assignedtree || !$allow_edit) {
        $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
        header("Location: admin_login.php?message=" . urlencode($message));
        exit;
    }

    $query = "SELECT gedcom, treename FROM $trees_table ORDER BY treename";
    $result = @tng_query($query);
    while ($row = tng_fetch_assoc($result)) {
        $treeList[] = $row;
    }
} else {
    $result = false;
}

if (!$rootpath) {
    $rootpath = dirname(__FILE__);
    $rootpath .= "/";
    if (preg_match("/WIN/i", PHP_OS)) {
        $rootpath = str_replace("\\", "/", $rootpath);
    }
}

if (!$lineendingdisplay) {
    if ($lineending == "\r\n") {
        $lineendingdisplay = "\\r\\n";
    } elseif ($lineending == "\r") {
        $lineendingdisplay = "\\r";
    } elseif ($lineending == "\n") {
        $lineendingdisplay = "\\n";
    }
}
if (!isset($tngconfig['maxdesc'])) $tngconfig['maxdesc'] = $maxdesc;
if (!$tngconfig['backupdays']) $tngconfig['backupdays'] = 30;

$sitename = preg_replace("/\"/", "&#34;", $sitename);
$site_desc = preg_replace("/\"/", "&#34;", $site_desc);
$dbowner = preg_replace("/\"/", "&#34;", $dbowner);
$tngconfig['footermsg'] = preg_replace("/\"/", "&#34;", $tngconfig['footermsg']);

$helplang = findhelp("config_help.php");

tng_adminheader(_('Modify Configuration Settings'), $flags);
?>
<script>
    function toggleAll(display) {
        toggleSection('db', 'plus0', display);
        toggleSection('tables', 'plus1', display);
        toggleSection('folders', 'plus2', display);
        toggleSection('site', 'plus3', display);
        toggleSection('media', 'plus4', display);
        toggleSection('lang', 'plus5', display);
        toggleSection('priv', 'plus6', display);
        toggleSection('names', 'plus7', display);
        toggleSection('cemeteries', 'plus8', display);
        toggleSection('mailreg', 'plus9', display);
        toggleSection('pref', 'plus10', display);
        toggleSection('mobile', 'plus11', display);
        toggleSection('dna', 'plus12', display);
        toggleSection('misc', 'plus13', display);
        return false;
    }

    function flipTreeRestrict(requirelogin) {
        if (parseInt(requirelogin)) {
            jQuery('#treerestrict').show();
            jQuery('#trdisabled').hide();
        } else {
            jQuery('#treerestrict').hide();
            jQuery('#trdisabled').show();
        }
    }

    function toggleAllowReg() {
        if (document.form1.disallowreg.selectedIndex == 1) {   //off
            jQuery('#autoapp').attr('disabled', 'disabled');
            jQuery('#autotree').attr('disabled', 'disabled');
            jQuery('#ackemail').attr('disabled', 'disabled');
            jQuery('#omitpwd').attr('disabled', 'disabled');
        } else {
            jQuery('#autoapp').attr('disabled', '');
            jQuery('#autotree').attr('disabled', '');
            if (document.form1.autoapp.selectedIndex == 0) {
                jQuery('#ackemail').attr('disabled', '');
            }
            jQuery('#omitpwd').attr('disabled', '');
        }
    }

    function toggleAutoApprove() {
        if (document.form1.autoapp.selectedIndex == 1) {   //off
            jQuery('#ackemail').attr('disabled', 'disabled');
        } else {
            jQuery('#ackemail').attr('disabled', '');
        }
    }

    function flipPlaces(select) {
        if (select.selectedIndex) {
            //change to NO
            jQuery('#merge').show();
            jQuery('#mergeexpl').show();
            jQuery('#convert').hide();
            jQuery('#convertexpl').hide();
            jQuery('#placetree').hide();
        } else {
            //change to YES
            jQuery('#convert').show();
            jQuery('#convertexpl').show();
            jQuery('#placetree').show();
            jQuery('#merge').hide();
            jQuery('#mergeexpl').hide();
        }
    }

    function convertPlaces(command) {
        var options = {action: command};
        if (command == "convert")
            options.placetree = jQuery('#placetree').val();
        jQuery('#' + command + 'expl').html('<img src="img/spinner.gif" style="border: 0; vertical-align: middle;">');

        jQuery.ajax({
            url: 'ajx_placeconvert.php',
            data: options,
            type: 'GET',
            dataType: 'html',
            success: function (req) {
                jQuery('#' + command + 'expl').html(req);
            }
        });

        return false;
    }

    function convertMedia(select) {
        var options = {action: select.val()};
        jQuery('#mediaexpl').html('<img src="img/spinner.gif" style="border: 0; vertical-align: middle;">');

        jQuery.ajax({
            url: 'ajx_mediaconvert.php',
            data: options,
            type: 'GET',
            dataType: 'html',
            success: function (req) {
                jQuery('#mediaexpl').html(req);
            }
        });
        return false;
    }
</script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$setuptabs[0] = [1, "admin_setup.php", _('Configuration'), "configuration"];
$setuptabs[1] = [1, "admin_diagnostics.php", _('Diagnostics'), "diagnostics"];
$setuptabs[2] = [1, "admin_setup.php?sub=tablecreation", _('Table Creation'), "tablecreation"];
$setuptabs[3] = [1, "#", _('General Settings'), "gen"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/config_help.php#modify');\" class='lightlink'>" . _('Help for this area') . "</a>";
$innermenu .= " &nbsp;|&nbsp; <a href='#' class='lightlink' onClick=\"return toggleAll('on');\">" . _('Expand all') . "</a> &nbsp;|&nbsp; <a href='#' class='lightlink' onClick=\"return toggleAll('off');\">" . _('Collapse all') . "</a>";
$menu = doMenu($setuptabs, "gen", $innermenu);
echo displayHeadline(_('Setup') . " &gt;&gt; " . _('Configuration') . " &gt;&gt; " . _('General Settings'), "img/setup_icon.gif", $menu, "");
?>

    <form action="admin_updateconfig.php" method="post" name="form1">

        <table class="lightback">
            <tr class="databack">
                <td class="tngshadow">
                    <?php echo displayToggle("plus0", 0, "db", _('Database'), ""); ?>

                    <div id="db" style="display:none;">
                        <table class="normal">
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td><?php echo _('Database Host'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $database_host; ?>" name="new_database_host" size="20">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Database Name'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $database_name; ?>" name="new_database_name" size="20">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Database User Name'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $database_username; ?>" name="new_database_username" size="20">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Database Password'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $database_password; ?>" name="new_database_password" size="20">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Database Port'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $database_port; ?>" name="new_database_port" size="20">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Database Socket'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $database_socket; ?>" name="new_database_socket" size="20">
                                </td>
                            </tr>
                            <?php
                            $query = "SELECT count(userID) AS ucount FROM $users_table";
                            $uresult = @tng_query($query);
                            if ($uresult) {
                                $urow = tng_fetch_assoc($uresult);
                                tng_free_result($uresult);
                            } else {
                                $urow['ucount'] = 0;
                            }
                            ?>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td><?php echo _('Maintenance Mode'); ?>:</td>
                                <td>
                                    <select name="maint"<?php if (!$urow['ucount']) {
                                        echo " disabled=\"disabled\"";
                                    } ?>>
                                        <option value=""<?php if (!$tngconfig['maint']) {
                                            echo " selected";
                                        } ?>><?php echo _('Off'); ?></option>
                                        <option value="1"<?php if ($tngconfig['maint']) {
                                            echo " selected";
                                        } ?>><?php echo _('On'); ?></option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>

                </td>
            </tr>

            <tr class="databack tngshadow">
                <td class="tngshadow">
                    <?php echo displayToggle("plus1", 0, "tables", _('Table Names'), ""); ?>

                    <div id="tables" style="display:none;"><br>
                        <table cellspacing="0" cellpadding="0" class="normal">
                            <tr>
                                <td>
                                    <table class="normal">
                                        <tr>
                                            <td><?php echo _('People'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $people_table; ?>" name="people_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Families'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $families_table; ?>" name="families_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Children'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $children_table; ?>" name="children_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Albums'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $albums_table; ?>" name="albums_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Album Links'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $album2entities_table; ?>" name="album2entities_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Album Media'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $albumlinks_table; ?>" name="albumlinks_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Media'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $media_table; ?>" name="media_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Media Links'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $medialinks_table; ?>" name="medialinks_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Media Types'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $mediatypes_table; ?>" name="mediatypes_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Addresses'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $address_table; ?>" name="address_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Languages'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $languages_table; ?>" name="languages_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Places'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $places_table; ?>" name="places_table" size="20">
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td>&nbsp;</td>
                                <td>
                                    <table class="normal">
                                        <tr>
                                            <td><?php echo _('Cemeteries'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $cemeteries_table; ?>" name="cemeteries_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('States'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $states_table; ?>" name="states_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Countries'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $countries_table; ?>" name="countries_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Users'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $users_table; ?>" name="users_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Sources'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $sources_table; ?>" name="sources_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Citations'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $citations_table; ?>" name="citations_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Repositories'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $repositories_table; ?>" name="repositories_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Events'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $events_table; ?>" name="events_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Event Types'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $eventtypes_table; ?>" name="eventtypes_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Reports'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $reports_table; ?>" name="reports_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Trees'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $trees_table; ?>" name="trees_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Notes'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $xnotes_table; ?>" name="xnotes_table" size="20">
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td>&nbsp;</td>
                                <td class='align-top'>
                                    <table class="normal">
                                        <tr>
                                            <td><?php echo _('Note Links'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $notelinks_table; ?>" name="notelinks_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Save Import'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $saveimport_table; ?>" name="saveimport_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Branches'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $branches_table; ?>" name="branches_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Branch Links'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $branchlinks_table; ?>" name="branchlinks_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Timeline Events'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $tlevents_table; ?>" name="tlevents_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Temp Events'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $temp_events_table; ?>" name="temp_events_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Associations'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $assoc_table; ?>" name="assoc_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Most Wanted'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $mostwanted_table; ?>" name="mostwanted_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('DNA Tests'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $dna_tests_table; ?>" name="dna_tests_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('DNA Groups'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $dna_groups_table; ?>" name="dna_groups_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('DNA Links'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $dna_links_table; ?>" name="dna_links_table" size="20">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Templates'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $templates_table; ?>" name="templates_table" size="20">
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>

                </td>
            </tr>

            <tr class="databack tngshadow">
                <td class="tngshadow">
                    <?php echo displayToggle("plus2", 0, "folders", _('Paths and Folders'), ""); ?>

                    <div id="folders" style="display:none;">
                        <table class="normal">
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="whitespace-no-wrap"><?php echo _('Root Path'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $rootpath; ?>" name="newrootpath" class="verylongfield">
                                </td>
                            </tr>
                            <tr>
                                <td class="whitespace-no-wrap"><?php echo _('Photo Folder'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $photopath; ?>" name="photopath" class="verylongfield">
                                    <input type="button" value="<?php echo _('Make Folder'); ?>" onclick="makeFolder('photos',document.form1.photopath.value);">
                                    <span id="msg_photos"></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="whitespace-no-wrap"><?php echo _('Document Folder'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $documentpath; ?>" name="documentpath" class="verylongfield">
                                    <input type="button" value="<?php echo _('Make Folder'); ?>" onClick="makeFolder('documents',document.form1.documentpath.value);">
                                    <span
                                        id="msg_documents"></span></td>
                            </tr>
                            <tr>
                                <td class="whitespace-no-wrap"><?php echo _('History Folder'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $historypath; ?>" name="historypath" class="verylongfield">
                                    <input type="button" value="<?php echo _('Make Folder'); ?>" onClick="makeFolder('histories',document.form1.historypath.value);">
                                    <span
                                        id="msg_histories"></span></td>
                            </tr>
                            <tr>
                                <td class="whitespace-no-wrap"><?php echo _('Headstone Folder'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $headstonepath; ?>" name="headstonepath" class="verylongfield">
                                    <input type="button" value="<?php echo _('Make Folder'); ?>" onClick="makeFolder('headstones',document.form1.headstonepath.value);">
                                    <span
                                        id="msg_headstones"></span></td>
                            </tr>
                            <tr>
                                <td class="whitespace-no-wrap"><?php echo _('Multimedia Folder'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $mediapath; ?>" name="mediapath" class="verylongfield">
                                    <input type="button" value="<?php echo _('Make Folder'); ?>" onClick="makeFolder('media',document.form1.mediapath.value);">
                                    <span id="msg_media"></span></td>
                            </tr>
                            <tr>
                                <td class="whitespace-no-wrap"><?php echo _('GENDEX Folder'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $gendexfile; ?>" name="gendexfile" class="verylongfield">
                                    <input type="button" value="<?php echo _('Make Folder'); ?>" onClick="makeFolder('gendex',document.form1.gendexfile.value);">
                                    <span id="msg_gendex"></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="whitespace-no-wrap"><?php echo _('Backup Folder'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $backuppath; ?>" name="backuppath" class="verylongfield">
                                    <input type="button" value="<?php echo _('Make Folder'); ?>" onClick="makeFolder('backups',document.form1.backuppath.value);">
                                    <span id="msg_backups"></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="whitespace-no-wrap"><?php echo _('Extensions Folder'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $extspath; ?>" name="extspath" class="verylongfield">
                                    <input type="button" value="<?php echo _('Make Folder'); ?>" onClick="makeFolder('exts',document.form1.extspath.value);">
                                    <span id="msg_exts"></span></td>
                            </tr>
                        </table>
                    </div>

                </td>
            </tr>

            <tr class="databack tngshadow">
                <td class="tngshadow">
                    <?php echo displayToggle("plus3", 0, "site", _('Site Design and Definition'), ""); ?>

                    <div id="site" style="display:none;">
                        <table class="normal">
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td><?php echo _('Home Page'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $homepage; ?>" name="homepage" size="40">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Genealogy URL'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $tngdomain; ?>" name="tngdomain" size="40">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Site Name'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $sitename; ?>" name="sitename" size="40">
                                </td>
                            </tr>
                            <tr>
                                <td class='align-top'><?php echo _('Site Description'); ?>:</td>
                                <td><textarea name="site_desc" rows="2" cols="65"><?php echo $site_desc; ?></textarea></td>
                            </tr>
                            <tr>
                                <td><?php echo _('Site Owner'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $dbowner; ?>" name="dbowner" size="40">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Target Frame'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $target; ?>" name="target" size="20">
                                </td>
                            </tr>
                            <tr>
                                <td class='align-top'><?php echo _('Custom footer message'); ?>:</td>
                                <td><textarea name="tng_footermsg" rows="2" cols="65"><?php echo $tngconfig['footermsg']; ?></textarea></td>
                            </tr>
                            <tr>
                                <td><?php echo _('Menu Location'); ?>:</td>
                                <td>
                                    <select name="tng_menu">
                                        <option value="0"<?php if (!$tngconfig['menu']) {
                                            echo " selected";
                                        } ?>><?php echo _('Top right, next to heading'); ?></option>
                                        <option value="1"<?php if ($tngconfig['menu'] == 1) {
                                            echo " selected";
                                        } ?>><?php echo _('Top left, over heading'); ?></option>
                                        <option value="2"<?php if ($tngconfig['menu'] == 2) {
                                            echo " selected";
                                        } ?>><?php echo _('Do not display'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Show Home Link'); ?>:</td>
                                <td>
                                    <select name="showhome">
                                        <option value="0"<?php if (!$tngconfig['showhome']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                        <option value="1"<?php if ($tngconfig['showhome']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Show Search Link'); ?>:</td>
                                <td>
                                    <select name="showsearch">
                                        <option value="0"<?php if (!$tngconfig['showsearch']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                        <option value="1"<?php if ($tngconfig['showsearch']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Search Link Destination'); ?>:</td>
                                <td>
                                    <select name="searchchoice">
                                        <option value="0"<?php if (!$tngconfig['searchchoice']) {
                                            echo " selected";
                                        } ?>><?php echo _('Quick Search'); ?></option>
                                        <option value="1"<?php if ($tngconfig['searchchoice']) {
                                            echo " selected";
                                        } ?>><?php echo _('Advanced Search'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Show Login/Logout Link'); ?>:</td>
                                <td>
                                    <select name="showlogin">
                                        <option value="0"<?php if (!$tngconfig['showlogin']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                        <option value="1"<?php if ($tngconfig['showlogin']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Show Share Link'); ?>:</td>
                                <td>
                                    <select name="showshare">
                                        <option value="1"<?php if ($tngconfig['showshare']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                        <option value="0"<?php if (!$tngconfig['showshare']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Show Print Link'); ?>:</td>
                                <td>
                                    <select name="showprint">
                                        <option value="0"<?php if (!$tngconfig['showprint']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                        <option value="1"<?php if ($tngconfig['showprint']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Show Add Bookmark Link'); ?>:</td>
                                <td>
                                    <select name="showbmarks">
                                        <option value="0"<?php if (!$tngconfig['showbmarks']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                        <option value="1"<?php if ($tngconfig['showbmarks']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Hide Christening Labels'); ?>:</td>
                                <td>
                                    <select name="hidechr">
                                        <option value="0"<?php if (!$tngconfig['hidechr']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                        <option value="1"<?php if ($tngconfig['hidechr']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Default Tree'); ?>:</td>
                                <td>
                                    <select name="defaulttree">
                                        <option value=""></option>
                                        <?php
                                        if ($link && $result) {
                                            foreach ($treeList as $treerow) {
                                                echo "	<option value=\"{$treerow['gedcom']}\"";
                                                if ($defaulttree == $treerow['gedcom']) {
                                                    echo " selected";
                                                }
                                            echo ">{$treerow['treename']}</option>\n";
                                        }
                                    } else {
                                        echo "	<option value=\"$defaulttree\" selected>$defaulttree</option>\n";
                                    }
                                    ?>
                                </select>
                                </td>
                            </tr>
                        </table>
                    </div>

                </td>
            </tr>

            <tr class="databack tngshadow">
                <td class="tngshadow">
                    <?php echo displayToggle("plus4", 0, "media", _('Media'), ""); ?>

                    <div id="media" style="display:none;">
                        <table class="normal">
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td><?php echo _('Photos Extension'); ?>:</td>
                                <td>
                                    <select name="photosext">
                                        <option value="jpg"<?php if ($photosext == "jpg") {
                                            echo " selected";
                                        } ?>>.jpg
                                        </option>
                                        <option value="gif"<?php if ($photosext == "gif") {
                                            echo " selected";
                                        } ?>>.gif
                                        </option>
                                    <option value="png"<?php if ($photosext == "png") {
                                        echo " selected";
                                    } ?>>.png
                                    </option>
                                        <option value="bmp"<?php if ($photosext == "bmp") {
                                            echo " selected";
                                        } ?>>.bmp
                                        </option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Show Extended Photo Info'); ?>:</td>
                                <td>
                                    <select name="showextended">
                                        <option value="1"<?php if ($showextended) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                        <option value="0"<?php if (!$showextended) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Image Max Height'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $tngconfig['imgmaxh']; ?>" name="imgmaxh" size="20">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Image Max Width'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $tngconfig['imgmaxw']; ?>" name="imgmaxw" size="20">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Thumbnails Prefix'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $thumbprefix; ?>" name="thumbprefix" size="20">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Thumbnails Suffix'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $thumbsuffix; ?>" name="thumbsuffix" size="20">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Thumbnail Max Height'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $thumbmaxh; ?>" name="thumbmaxh" size="20">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Thumbnail Max Width'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $thumbmaxw; ?>" name="thumbmaxw" size="20">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Use default thumbnails'); ?>:</td>
                                <td>
                                    <select name="tng_usedefthumbs">
                                        <option value="0"<?php if (!$tngconfig['usedefthumbs']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                        <option value="1"<?php if ($tngconfig['usedefthumbs']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Max characters in list notes'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $tngconfig['maxnoteprev']; ?>" name="tng_maxnoteprev" size="20">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Enable Slide Show'); ?>:</td>
                                <td>
                                    <select name="tng_ssdisabled">
                                        <option value="0"<?php if (!$tngconfig['ssdisabled']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                        <option value="1"<?php if ($tngconfig['ssdisabled']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Slide Show Auto Repeat'); ?>:</td>
                                <td>
                                    <select name="tng_ssrepeat">
                                        <option value="1"<?php if ($tngconfig['ssrepeat']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                        <option value="0"<?php if (!$tngconfig['ssrepeat']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Enable image viewer'); ?>:</td>
                                <td>
                                    <select name="tng_imgviewer">
                                        <option value="0"<?php if (!$tngconfig['imgviewer']) {
                                            echo " selected";
                                        } ?>><?php echo _('Always'); ?></option>
                                        <option value="documents"<?php if ($tngconfig['imgviewer'] == "documents") {
                                            echo " selected";
                                        } ?>><?php echo _('Documents only'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Image viewer height'); ?>:</td>
                                <td>
                                    <select name="tng_imgvheight">
                                        <option value="0"<?php if ($tngconfig['imgvheight'] == 1) {
                                            echo " selected";
                                        } ?>><?php echo _('Always show full image'); ?></option>
                                        <option value="640"<?php if ($tngconfig['imgvheight'] == "640") {
                                            echo " selected";
                                        } ?>><?php echo _('Fixed (640px)'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Hide personal media'); ?>:</td>
                                <td>
                                    <select name="hidemedia">
                                        <option value="1"<?php if ($tngconfig['hidemedia']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                        <option value="0"<?php if (!$tngconfig['hidemedia']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Remove physical file on delete'); ?>:</td>
                                <td>
                                    <select name="tng_mediadel">
                                        <option value="0"<?php if (!$tngconfig['mediadel']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                        <option value="1"<?php if ($tngconfig['mediadel'] == 1) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                        <option value="2"<?php if ($tngconfig['mediadel'] == 2) {
                                            echo " selected";
                                        } ?>><?php echo _('On request'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Show photos on one row'); ?>:</td>
                                <td>
                                    <select name="tng_mediathumbs">
                                        <option value="1"<?php if ($tngconfig['mediathumbs']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                        <option value="0"<?php if (!$tngconfig['mediathumbs']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Separate media in tree folders'); ?>:</td>
                                <td>
                                    <select name="tng_mediatrees" id="tng_mediatrees">
                                        <option value="0"<?php if (!$tngconfig['mediatrees']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                        <option value="1"<?php if ($tngconfig['mediatrees']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                    </select>
                                    <input type="button" value="<?php echo _('Convert'); ?>" id="convertmedia" onclick="convertMedia(jQuery('#tng_mediatrees'));">
                                    <div id="mediaexpl" style="display:inline-block;"></div>
                                </td>
                            </tr>
                            <tr>
                                <td>Favicon:</td>
                                <td>
                                    <input type="text" value="<?php echo $tngconfig['favicon']; ?>" name="favicon" size="20">
                                </td>
                            </tr>
                        </table>
                    </div>

                </td>
            </tr>

            <tr class="databack tngshadow">
                <td class="tngshadow">
                    <?php echo displayToggle("plus5", 0, "lang", _('Language'), ""); ?>

                    <div id="lang" style="display:none;">
                        <table class="normal">
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td><?php echo _('Language folder'); ?>:</td>
                                <td>
                                    <select name="language">
                                        <?php
                                        @chdir($rootpath . $endrootpath . $languages_path);
                                        if ($handle = @opendir('.')) {
                                            $dirs = [];
                                            while ($filename = readdir($handle)) {
                                                if (is_dir($filename) && $filename != '..' && $filename != '.') {
                                                    array_push($dirs, $filename);
                                                }
                                        }
                                        natcasesort($dirs);
                                        $found_current = 0;
                                        foreach ($dirs as $dir) {
                                            echo "<option value=\"$dir\"";
                                            if ($dir == $language) {
                                                echo " selected";
                                                $found_current = 1;
                                            }
                                            echo ">$dir</option>\n";
                                        }
                                            if (!$found_current) {
                                                echo "<option value=\"$language\" selected>$language</option>\n";
                                            }
                                            closedir($handle);
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Character set'); ?>:</td>
                                <td>
                                    <select name="charset">
                                        <option value="UTF-8"<?php if (strtoupper($charset) == "UTF-8") {
                                            echo " selected";
                                        } ?>>UTF-8
                                        </option>
                                        <option value="ISO-8859-1"<?php if (strtoupper($charset) == "ISO-8859-1") {
                                            echo " selected";
                                        } ?>>ISO-8859-1 (ANSI)
                                        </option>
                                        <option value="ISO-8859-2"<?php if (strtoupper($charset) == "ISO-8859-2") {
                                            echo " selected";
                                        } ?>>ISO-8859-2
                                        </option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Dynamic Language Change'); ?>:</td>
                                <td>
                                    <select name="chooselang">
                                        <option value="1"<?php if ($chooselang) {
                                            echo " selected";
                                        } ?>><?php echo _('Allow'); ?></option>
                                        <option value="0"<?php if (!$chooselang) {
                                            echo " selected";
                                        } ?>><?php echo _('Disallow'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Turn off relationship messages'); ?>:</td>
                                <td>
                                    <select name="norels">
                                        <option value=""<?php if (!$norels) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                        <option value="1"<?php if ($norels) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>

                </td>
            </tr>

            <tr class="databack tngshadow">
                <td class="tngshadow">
                    <?php echo displayToggle("plus6", 0, "priv", _('Privacy'), ""); ?>

                    <div id="priv" style="display:none;">
                        <table class="normal">
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td><?php echo _('Require Login'); ?>:</td>
                                <td>
                                    <select name="requirelogin" onchange="flipTreeRestrict(this.options[this.selectedIndex].value);">
                                        <option value="1"<?php if ($requirelogin) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                        <option value="0"<?php if (!$requirelogin) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Restrict access to assigned tree'); ?>: &nbsp;&nbsp;</td>
                                <td><span id="trdisabled"<?php if ($requirelogin) {
                                        echo " style='display: none;'";
                                    } ?>><?php echo _('\"Require Login\" must be set to Yes to enable this option'); ?></span>
                                    <select name="treerestrict" id="treerestrict"<?php if (!$requirelogin) {
                                        echo " style='display: none;'";
                                    } ?>>
                                        <option value="0"<?php if (!$treerestrict) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                        <option value="1"<?php if ($treerestrict) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Show LDS Data'); ?>:</td>
                                <td>
                                    <select name="ldsdefault">
                                        <option value="0"<?php if (!$ldsdefault) {
                                            echo " selected";
                                        } ?>><?php echo _('Always'); ?></option>
                                        <option value="1"<?php if ($ldsdefault == 1) {
                                            echo " selected";
                                        } ?>><?php echo _('Never'); ?></option>
                                        <option value="2"<?php if ($ldsdefault == 2) {
                                            echo " selected";
                                        } ?>><?php echo _('Depending on user rights'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Show Living Data'); ?>:</td>
                                <td>
                                    <select name="livedefault">
                                        <option value="2"<?php if ($livedefault == 2) {
                                            echo " selected";
                                        } ?>><?php echo _('Always'); ?></option>
                                        <option value="1"<?php if ($livedefault == 1) {
                                            echo " selected";
                                        } ?>><?php echo _('Never'); ?></option>
                                        <option value="0"<?php if (!$livedefault) {
                                            echo " selected";
                                        } ?>><?php echo _('Depending on user rights'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Show Names for Living'); ?>:</td>
                                <td>
                                    <select name="nonames">
                                        <option value="0"<?php if (!$nonames) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                        <option value="1"<?php if ($nonames == 1) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                        <option value="2"<?php if ($nonames == 2) {
                                            echo " selected";
                                        } ?>><?php echo _('Abbreviate first name'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Show Names for Private'); ?>:</td>
                                <td>
                                    <select name="nnpriv">
                                        <option value="0"<?php if (!$tngconfig['nnpriv']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                        <option value="1"<?php if ($tngconfig['nnpriv'] == 1) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                        <option value="2"<?php if ($tngconfig['nnpriv'] == 2) {
                                            echo " selected";
                                        } ?>><?php echo _('Abbreviate first name'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Show cookie approval message'); ?>:</td>
                                <td>
                                    <select name="tng_cookieapproval">
                                        <option value="0"<?php if (!$tngconfig['cookieapproval']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                        <option value="1"<?php if ($tngconfig['cookieapproval']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Show link to data protection policy'); ?>:</td>
                                <td>
                                    <select name="tng_dataprotect">
                                        <option value="0"<?php if (!$tngconfig['dataprotect']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                        <option value="1"<?php if ($tngconfig['dataprotect']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Prompt for consent regarding personal info'); ?>:</td>
                                <td>
                                    <select name="tng_askconsent">
                                        <option value="0"<?php if (!$tngconfig['askconsent']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                        <option value="1"<?php if ($tngconfig['askconsent']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('reCAPTCHA Site Key'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $tngconfig['sitekey']; ?>" name="rcsitekey" class="longfield">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('reCAPTCHA Secret'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $tngconfig['secret']; ?>" name="rcsecret" class="longfield">
                                </td>
                            </tr>
                        </table>
                    </div>

                </td>
            </tr>

            <tr class="databack tngshadow">
                <td class="tngshadow">
                    <?php echo displayToggle("plus7", 0, "names", _('Names'), ""); ?>

                    <div id="names" style="display:none;">
                        <table class="normal">
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td><?php echo _('Name Order'); ?>:</td>
                                <td>
                                    <select name="nameorder">
                                        <option value=""></option>
                                        <option value="1"<?php if ($nameorder == 1) {
                                            echo " selected";
                                        } ?>><?php echo _('First name first'); ?></option>
                                        <option value="2"<?php if ($nameorder == 2) {
                                            echo " selected";
                                        } ?>><?php echo _('Surname first (without commas)'); ?></option>
                                        <option value="3"<?php if ($nameorder == 3) {
                                            echo " selected";
                                        } ?>><?php echo _('Surname first (with commas)'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Uppercase All Surnames'); ?>:</td>
                                <td>
                                    <select name="ucsurnames">
                                        <option value="0"<?php if (!$tngconfig['ucsurnames']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                        <option value="1"<?php if ($tngconfig['ucsurnames']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Surname Prefixes (i.e., van, de)'); ?>:</td>
                                <td>
                                    <select name="lnprefixes">
                                        <option value="0"<?php if (!$lnprefixes) {
                                            echo " selected";
                                        } ?>><?php echo _('Keep as part of regular surname'); ?></option>
                                        <option value="1"<?php if ($lnprefixes) {
                                            echo " selected";
                                        } ?>><?php echo _('Treat as separate entity'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><?php echo _('Prefix Detection on Import'); ?>:</td>
                            </tr>
                            <tr>
                                <td>&nbsp;&nbsp;<?php echo _('Num. prefixes each  (max)'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $lnpfxnum; ?>" name="lnpfxnum" size="5">
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;&nbsp;<?php echo _('OR These specific prefixes'); ?>*:</td>
                                <td>
                                    <input type="text" value="<?php echo stripslashes($specpfx); ?>" name="specpfx" class="verylongfield">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">*<?php echo _('Separate multiple entries with commas'); ?></td>
                            </tr>
                        </table>
                    </div>

                </td>
            </tr>

            <tr class="databack tngshadow">
                <td class="tngshadow">
                    <?php echo displayToggle("plus8", 0, "cemeteries", _('Cemeteries'), ""); ?>

                    <div id="cemeteries" style="display:none;">
                        <table class="normal">
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td><?php echo _('Max lines per column (approx.)'); ?>:</td>
                                <td colspan="4">
                                    <input type="text" value="<?php echo $tngconfig['cemrows']; ?>" name="cemrows" size="5">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Suppress \"Unknown\" categories'); ?>:</td>
                                <td>
                                    <select name="cemblanks">
                                        <option value="0"<?php if (!$tngconfig['cemblanks']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                        <option value="1"<?php if ($tngconfig['cemblanks']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>

            <tr class="databack tngshadow">
                <td class="tngshadow">
                    <?php echo displayToggle("plus9", 0, "mailreg", _('Mail and Registration'), ""); ?>

                    <div id="mailreg" style="display:none;">
                        <table class="normal">
                            <tr>
                                <td><?php echo _('E-mail Address'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $emailaddr; ?>" name="emailaddr" size="40">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Send all mail from address above'); ?>:</td>
                                <td>
                                    <select name="fromadmin">
                                        <option value="0"<?php if (!$tngconfig['fromadmin']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                        <option value="1"<?php if ($tngconfig['fromadmin']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Allow new user registrations'); ?>:</td>
                                <td>
                                    <select name="disallowreg" onchange="toggleAllowReg();">
                                        <option value="0"<?php if (!$tngconfig['disallowreg']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                        <option value="1"<?php if ($tngconfig['disallowreg']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Notify on reviewable submissions'); ?>:</td>
                                <td>
                                    <select name="revmail">
                                        <option value="0"<?php if (!$tngconfig['revmail']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                        <option value="1"<?php if ($tngconfig['revmail']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Create new tree for user'); ?>:</td>
                                <td>
                                    <select name="autotree" id="autotree">
                                        <option value="0"<?php if (!$tngconfig['autotree']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                        <option value="1"<?php if ($tngconfig['autotree']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Auto approve new users'); ?>:</td>
                                <td>
                                    <select name="autoapp" id="autoapp" onchange="toggleAutoApprove();">
                                        <option value="0"<?php if (!$tngconfig['autoapp']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                        <option value="1"<?php if ($tngconfig['autoapp']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Send acknowledgement email'); ?>:</td>
                                <td>
                                    <select name="ackemail" id="ackemail"<?php if ($tngconfig['autoapp']) {
                                        echo " disabled=\"disabled\"";
                                    } ?>>
                                        <option value="0"<?php if (!$tngconfig['ackemail']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                        <option value="1"<?php if ($tngconfig['ackemail']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Include password in welcome email'); ?>:</td>
                                <td>
                                    <select name="omitpwd" id="omitpwd">
                                        <option value="0"<?php if (!$tngconfig['omitpwd']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                        <option value="1"<?php if ($tngconfig['omitpwd']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Use SMTP authentication'); ?>:</td>
                                <td>
                                    <select name="usesmtp" id="usesmtp" onchange="jQuery('#smtpstuff').toggle(200);">
                                        <option value="0"<?php if (!$tngconfig['usesmtp']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                        <option value="1"<?php if ($tngconfig['usesmtp']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <table class="normal" style="margin-left:5px;<?php if (!$tngconfig['usesmtp']) {
                            echo " display:none";
                        } ?>" id="smtpstuff">
                            <tr>
                                <td><?php echo _('SMTP host name'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $tngconfig['mailhost']; ?>" name="mailhost" size="40">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Mail username'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $tngconfig['mailuser']; ?>" name="mailuser" size="40">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Mail password'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $tngconfig['mailpass']; ?>" name="mailpass" size="40">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Port number'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $tngconfig['mailport']; ?>" name="mailport" size="40">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Encryption'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $tngconfig['mailenc']; ?>" name="mailenc" size="40">
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>

            <tr class="databack tngshadow">
                <td class="tngshadow">
                    <?php echo displayToggle("plus10", 0, "pref", _('Prefixes and Suffixes'), ""); ?>

                    <div id="pref" style="display:none;">
                        <table class="normal">
                            <tr>
                                <td><?php echo _('Person prefix'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $tngconfig['personprefix']; ?>" name="pprefix" size="5">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Person suffix'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $tngconfig['personsuffix']; ?>" name="psuffix" size="5">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Family prefix'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $tngconfig['familyprefix']; ?>" name="fprefix" size="5">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Family suffix'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $tngconfig['familysuffix']; ?>" name="fsuffix" size="5">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Source prefix'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $tngconfig['sourceprefix']; ?>" name="sprefix" size="5">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Source suffix'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $tngconfig['sourcesuffix']; ?>" name="ssuffix" size="5">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Repository prefix'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $tngconfig['repoprefix']; ?>" name="rprefix" size="5">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Repository suffix'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $tngconfig['reposuffix']; ?>" name="rsuffix" size="5">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Note prefix'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $tngconfig['noteprefix']; ?>" name="nprefix" size="5">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Note suffix'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $tngconfig['notesuffix']; ?>" name="nsuffix" size="5">
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>

            <tr class="databack tngshadow">
                <td class="tngshadow">
                    <?php echo displayToggle("plus11", 0, "mobile", _('Mobile'), ""); ?>
                </td>
            </tr>

            <tr class="databack tngshadow">
                <td class="tngshadow">
                    <?php echo displayToggle("plus12", 0, "dna", _('DNA Tests'), ""); ?>
                    <div id="dna" style="display:none;">
                        <table class="normal">
                            <tr>
                                <td><?php echo _('Hide all DNA pages and data'); ?>:</td>
                                <td>
                                    <select name="hidedna">
                                        <option value="0"<?php if (!$tngconfig['hidedna']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                        <option value="1"<?php if ($tngconfig['hidedna']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <?php if (!$maxdnasearchresults) {
                                $maxdnasearchresults = $maxsearchresults;
                            } ?>
                            <tr>
                                <td><?php echo _('DNA Tests') . ' ' . _('Max Search Results'); ?>:</td>
                                <td colspan="4">
                                    <input type="text" value="<?php echo $maxdnasearchresults; ?>" name="maxdnasearchresults" size="3">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Show DNA Test Number Publicly'); ?>:</td>
                                <td>
                                    <select name="showtestnumbers">
                                        <option value="1"<?php if ($showtestnumbers) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                        <option value="0"<?php if (!$showtestnumbers) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Autofill Ancestral Surnames'); ?>:</td>
                                <td>
                                    <select name="autofillancsurnames">
                                        <option value="1"<?php if ($autofillancsurnames) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                        <option value="0"<?php if (!$autofillancsurnames) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Uppercase Ancestral Surnames'); ?>:</td>
                                <td>
                                    <select name="ancsurnameupper">
                                        <option value="1"<?php if ($ancsurnameupper) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                        <option value="0"<?php if (!$ancsurnameupper) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Generations For Ancestral Surnames'); ?>:</td>
                                <td>
                                    <select name="numgens">
                                        <option value="3">3</option>
                                        <?php
                                        for ($i = "4"; $i <= "15"; $i++) {
                                            echo "<option value=\"$i\"";
                                            if ($i == $numgens) echo " selected";

                                            echo ">$i</option>\n";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Exclude From Ancestral Surnames'); ?>*:</td>
                                <td>
                                    <input type="text" value="<?php echo stripslashes($surnameexcl); ?>" name="surnameexcl" class="longfield">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">*<?php echo _('Separate multiple entries with commas'); ?></td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong><?php echo _('Y-DNA Compare Tests Column Heading Colors'); ?></strong>
                            </tr>
                            <?php
                            $mainclass = $bgmain ? 'center' : 'fieldnameback center';
                            $txtmain = $txtmain ? $txtmain : '#FFFFFF';
                            $bgmode = $bgmode ? $bgmode : '#D1EEEE';
                            $txtmode = $txtmode ? $txtmode : '#000000';
                            $bgfastmut = $bgfastmut ? $bgfastmut : '#69001A';
                            $txtfastmut = $txtfastmut ? $txtfastmut : '#FFFFFF';
                            $bg1_12 = $bg1_12 ? $bg1_12 : '#414E68';
                            $txt1_12 = $txt1_12 ? $txt1_12 : '#FFFFFF';
                            $bg13_25 = $bg13_25 ? $bg13_25 : '#41678A';
                            $txt13_25 = $txt13_25 ? $txt13_25 : '#FFFFFF';
                            $bg26_37 = $bg26_37 ? $bg26_37 : '#2E8899';
                            $txt26_37 = $txt26_37 ? $txt26_37 : '#FFFFFF';
                            $bg38_67 = $bg38_67 ? $bg38_67 : '#44A1B8';
                            $txt38_67 = $txt38_67 ? $txt38_67 : '#FFFFFF';
                            $bg111 = $bg111 ? $bg111 : '#05B8CC';
                            $txt111 = $txt111 ? $txt111 : '#FFFFFF';
                            ?>
                            <tr>
                                <td><?php echo _('Main heading background color'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo stripslashes($bgmain); ?>" name="bgmain" size="7">&nbsp;
                                    <?php echo _('Text color'); ?>:
                                    <input type="text" value="<?php echo stripslashes($txtmain); ?>" name="txtmain" size="7">&nbsp;&nbsp;
                                    <input type="text" class="<?php echo $mainclass; ?>" style="background-color:<?php echo $bgmain; ?>; color:<?php echo $txtmain; ?>;"
                                        value="<?php echo _('Text color'); ?>" id="exmain" disabled>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Mode values background color'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo stripslashes($bgmode); ?>" name="bgmode" size="7">&nbsp;
                                    <?php echo _('Text color'); ?>:
                                    <input type="text" value="<?php echo stripslashes($txtmode); ?>" name="txtmode" size="7">&nbsp;&nbsp;
                                    <input type="text" class="text-center" style="background-color:<?php echo $bgmode; ?>; color:<?php echo $txtmode; ?>;" value="<?php echo _('Text color'); ?>"
                                        name="exmode" disabled>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Fast mutating background color'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo stripslashes($bgfastmut); ?>" name="bgfastmut" size="7">&nbsp;
                                    <?php echo _('Text color'); ?>:
                                    <input type="text" value="<?php echo stripslashes($txtfastmut); ?>" name="txtfastmut" size="7">&nbsp;&nbsp;
                                    <input type="text" class="text-center" style="background-color:<?php echo $bgfastmut; ?>; color:<?php echo $txtfastmut; ?>;" value="<?php echo _('Text color'); ?>"
                                        name="exfastmut" disabled>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Markers 1-12 background color'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo stripslashes($bg1_12); ?>" name="bg1_12" size="7">&nbsp;
                                    <?php echo _('Text color'); ?>:
                                    <input type="text" value="<?php echo stripslashes($txt1_12); ?>" name="txt1_12" size="7">&nbsp;&nbsp;
                                    <input type="text" class="text-center" style="background-color:<?php echo $bg1_12; ?>; color:<?php echo $txt1_12; ?>;" value="<?php echo _('Text color'); ?>"
                                        name="ex1_12" disabled>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Markers 13-25 background color'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo stripslashes($bg13_25); ?>" name="bg13_25" size="7">&nbsp;
                                    <?php echo _('Text color'); ?>:
                                    <input type="text" value="<?php echo stripslashes($txt13_25); ?>" name="txt13_25" size="7">&nbsp;&nbsp;
                                    <input type="text" class="text-center" style="background-color:<?php echo $bg13_25; ?>; color:<?php echo $txt13_25; ?>;" value="<?php echo _('Text color'); ?>"
                                        name="ex13_25" disabled>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Markers 26-37 background color'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo stripslashes($bg26_37); ?>" name="bg26_37" size="7">&nbsp;
                                    <?php echo _('Text color'); ?>:
                                    <input type="text" value="<?php echo stripslashes($txt26_37); ?>" name="txt26_37" size="7">&nbsp;&nbsp;
                                    <input type="text" class="text-center" style="background-color:<?php echo $bg26_37; ?>; color:<?php echo $txt26_37; ?>;" value="<?php echo _('Text color'); ?>"
                                        name="ex26_37" disabled>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Markers 38-67 background color'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo stripslashes($bg38_67); ?>" name="bg38_67" size="7">&nbsp;
                                    <?php echo _('Text color'); ?>:
                                    <input type="text" value="<?php echo stripslashes($txt38_67); ?>" name="txt38_67" size="7">&nbsp;&nbsp;
                                    <input type="text" class="text-center" style="background-color:<?php echo $bg38_67; ?>; color:<?php echo $txt38_67; ?>;" value="<?php echo _('Text color'); ?>"
                                        name="ex38_67" disabled>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Markers 68-111 background color'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo stripslashes($bg111); ?>" name="bg111" size="7">&nbsp;
                                    <?php echo _('Text color'); ?>:
                                    <input type="text" value="<?php echo stripslashes($txt111); ?>" name="txt111" size="7">&nbsp;&nbsp;
                                    <input type="text" class="text-center" style="background-color:<?php echo $bg111; ?>; color:<?php echo $txt111; ?>;" value="<?php echo _('Text color'); ?>"
                                        name="ex111" disabled>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2"><?php echo _('Get Color Codes Here'); ?> -> <a href="http://hnl.name/color-schemer-online/" class="snlink rounded"
                                        target="_blank"><?php echo _('ColorSchemer - Online Color Scheme Generator'); ?></a></td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>

            <tr class="databack tngshadow">
                <td class="tngshadow">
                    <?php echo displayToggle("plus13", 0, "misc", _('Miscellaneous'), ""); ?>

                    <div id="misc" style="display:none;">
                        <table class="normal">
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td><?php echo _('Max Search Results'); ?>:</td>
                                <td colspan="4">
                                    <input type="text" value="<?php echo $maxsearchresults; ?>" name="maxsearchresults" size="5">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Individuals start with'); ?>:</td>
                                <td colspan="4">
                                    <select name="tng_istart">
                                        <option value="0"<?php if (!$tngconfig['istart']) {
                                            echo " selected";
                                        } ?>><?php echo _('All information'); ?></option>
                                        <option value="1"<?php if ($tngconfig['istart']) {
                                            echo " selected";
                                        } ?>><?php echo _('Personal information only'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Show Notes'); ?>:</td>
                                <td colspan="4">
                                    <select name="notestogether">
                                        <option value="0"<?php if (!$notestogether) {
                                            echo " selected";
                                        } ?>><?php echo _('In Notes section'); ?></option>
                                        <option value="1"<?php if ($notestogether == 1) {
                                            echo " selected";
                                        } ?>><?php echo _('Underneath corresponding events where possible'); ?></option>
                                        <option value="2"<?php if ($notestogether == 2) {
                                            echo " selected";
                                        } ?>><?php echo _('Underneath events, except general notes'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Scroll citations'); ?>:</td>
                                <td>
                                    <select name="scrollcite">
                                        <option value="1"<?php if ($tngconfig['scrollcite']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                        <option value="0"<?php if (!$tngconfig['scrollcite']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td><?php echo _('Server time offset (hours)'); ?>:</td>
                                <td colspan="4">
                                    <input type="text" value="<?php echo $time_offset; ?>" name="time_offset"
                                        size="5"> <?php echo _('Server time is') . " <strong>" . date("D h:i a") . "</strong> ";
                                    $new_U = date("U") + $time_offset * 3600;
                                    echo _('and site time is') . " <strong>" . date("D h:i a", $new_U) . "</strong>"; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo _('Edit timeout (minutes)'); ?>:</td>
                                <td colspan="4">
                                    <input type="text" value="<?php echo $tngconfig['edit_timeout']; ?>" name="edit_timeout" size="5">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Max Generations, GEDCOM download'); ?>:</td>
                                <td colspan="4">
                                    <input type="text" value="<?php echo $maxgedcom; ?>" name="maxgedcom" size="5">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('\'What\'s New\' Days'); ?>:</td>
                                <td colspan="4">
                                    <input type="text" value="<?php echo $change_cutoff; ?>" name="change_cutoff" size="5"> <?php echo _('Leave blank or set to zero to remove this limit'); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo _('\'What\'s New\' Limit'); ?>:</td>
                                <td colspan="4">
                                    <input type="text" value="<?php echo $change_limit; ?>" name="change_limit" size="5">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Numeric Date Preference'); ?>:</td>
                                <td colspan="4">
                                    <select name="prefereuro">
                                        <option value="false"<?php if ($tngconfig['preferEuro'] == "false") {
                                            echo " selected";
                                        } ?>><?php echo _('Month/Day/Year'); ?></option>
                                        <option value="true"<?php if ($tngconfig['preferEuro'] == "true") {
                                            echo " selected";
                                        } ?>><?php echo _('Day/Month/Year'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('First day of week'); ?>:</td>
                                <td colspan="4">
                                    <select name="calstart">
                                        <option value="0"<?php if (!isset($tngconfig['calstart']) || $tngconfig['calstart'] == "0") {
                                            echo " selected";
                                        } ?>><?php echo _('Sunday'); ?></option>
                                        <option value="1"<?php if ($tngconfig['calstart'] == "1") {
                                            echo " selected";
                                        } ?>><?php echo _('Monday'); ?></option>
                                        <option value="2"<?php if ($tngconfig['calstart'] == "2") {
                                            echo " selected";
                                        } ?>><?php echo _('Tuesday'); ?></option>
                                        <option value="3"<?php if ($tngconfig['calstart'] == "3") {
                                            echo " selected";
                                        } ?>><?php echo _('Wednesday'); ?></option>
                                        <option value="4"<?php if ($tngconfig['calstart'] == "4") {
                                            echo " selected";
                                        } ?>><?php echo _('Thursday'); ?></option>
                                        <option value="5"<?php if ($tngconfig['calstart'] == "5") {
                                            echo " selected";
                                        } ?>><?php echo _('Friday'); ?></option>
                                        <option value="6"<?php if ($tngconfig['calstart'] == "6") {
                                            echo " selected";
                                        } ?>><?php echo _('Saturday'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Parental data on person page'); ?>:</td>
                                <td>
                                    <select name="pardata">
                                        <option value="0"<?php if (!$tngconfig['pardata']) {
                                            echo " selected";
                                        } ?>><?php echo _('Show all events and media'); ?></option>
                                        <option value="1"<?php if ($tngconfig['pardata'] == 1) {
                                            echo " selected";
                                        } ?>><?php echo _('Show only standard family events'); ?></option>
                                        <option value="2"<?php if ($tngconfig['pardata'] == 2) {
                                            echo " selected";
                                        } ?>><?php echo _('Don\'t show any events'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Line Ending'); ?>:</td>
                                <td colspan="4">
                                    <input type="text" value="<?php echo $lineendingdisplay; ?>" name="lineending" size="5">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Encryption type'); ?>:</td>
                                <td>
                                    <select name="password_type">
                                        <?php
                                        $encrtypes = PasswordTypeList();
                                        foreach ($encrtypes as $encrtype) {
                                            $display = $encrtype != "none" ? $encrtype : _('No encryption');
                                            echo "<option value=\"$encrtype\"";
                                            if ($encrtype == $tngconfig['password_type']) {
                                                echo " selected";
                                            }
                                            echo ">$display</option>\n";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Assign Place records to Trees'); ?>:</td>
                                <td>
                                    <select name="places1tree" id="places1tree" onchange="flipPlaces(this);">
                                        <option value="0"<?php if (!$tngconfig['places1tree']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                        <option value="1"<?php if ($tngconfig['places1tree']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                    </select>
                                    <input type="button" value="<?php echo _('Merge'); ?>" id="merge" onclick="convertPlaces('merge');" style="display:none;">
                                    <span id="mergeexpl" style="display:none;"><?php echo _('(This will remove the tree assignment from all Place records)'); ?></span>
                                    <select name="placetree" id="placetree" style="display:none;">
                                        <?php
                                        foreach ($treeList as $treerow) {
                                            echo "	<option value=\"{$treerow['gedcom']}\">{$treerow['treename']}</option>\n";
                                        }
                                        ?>
                                    </select>
                                    <input type="button" value="<?php echo _('Convert'); ?>" id="convert" onclick="convertPlaces('convert');" style="display:none;">
                                    <span id="convertexpl" style="display:none;"><?php echo _('(This will assign all current places to the selected tree)'); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Geocode all new places'); ?>:</td>
                                <td>
                                    <select name="autogeo">
                                        <option value="0"<?php if (!$tngconfig['autogeo']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                        <option value="1"<?php if ($tngconfig['autogeo']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Re-use deleted IDs'); ?>:</td>
                                <td>
                                    <select name="oldids">
                                        <option value=""<?php if (!$tngconfig['oldids']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                        <option value="1"<?php if ($tngconfig['oldids']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Show last import'); ?>:</td>
                                <td>
                                    <select name="lastimport">
                                        <option value=""<?php if (!$tngconfig['lastimport']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                        <option value="1"<?php if ($tngconfig['lastimport']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Show \'Important tasks\' messages'); ?>:</td>
                                <td>
                                    <select name="hidetasks">
                                        <option value=""<?php if (!$tngconfig['hidetasks']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                        <option value="1"<?php if ($tngconfig['hidetasks']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Show record totals on Admin menu'); ?>:</td>
                                <td>
                                    <select name="hidetotals">
                                        <option value=""<?php if (!$tngconfig['hidetotals']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                        <option value="1"<?php if ($tngconfig['hidetotals']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Alert if no backup in this many days'); ?>:</td>
                                <td colspan="4">
                                    <input type="text" value="<?php echo $tngconfig['backupdays']; ?>" name="backupdays" size="5"> <?php echo _('Leave blank or set to zero to remove this limit'); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo _('I am using TNG offline'); ?>:</td>
                                <td>
                                    <select name="tng_offline">
                                        <option value=""<?php if (!$tngconfig['offline']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                        <option value="1"<?php if ($tngconfig['offline']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>

            <tr class="databack tngshadow">
                <td class="tngshadow">
                    <input type="submit" name="submit" accesskey="s" class="btn" value="<?php echo _('Save'); ?>">

                    <input type="hidden" value="1" name="safety">
                    <input type="hidden" value="<?php echo $photos_table; ?>" name="photos_table">
                    <input type="hidden" value="<?php echo $histories_table; ?>" name="histories_table">
                    <input type="hidden" value="<?php echo $headstones_table; ?>" name="headstones_table">
                    <input type="hidden" value="<?php echo $photolinks_table; ?>" name="photolinks_table">
                    <input type="hidden" value="<?php echo $doclinks_table; ?>" name="doclinks_table">
                    <input type="hidden" value="<?php echo $hslinks_table; ?>" name="hslinks_table">
                </td>
            </tr>

    </table>
</form>

<?php echo tng_adminfooter(); ?>
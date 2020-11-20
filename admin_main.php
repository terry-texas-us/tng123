<?php

include "begin.php";
$maint = $tngconfig['maint'];
$tngconfig['maint'] = "";
include "config/mapconfig.php";
include "adminlib.php";

$admin_login = 2;

include "checklogin.php";
include "version.php";

/**
 * @param $destination
 * @param $label
 * @param $number
 * @param $message
 * @param $icon
 * @return string
 */
function adminMenuItem($destination, $label, $number, $message, $icon) {
    $menu = "";
    $iconstr = "<img src=\"img/{$icon}_icon.gif\" alt='$label' class='adminicon float-left rounded m-2 shadow'>\n";
    $msgstr = "<div class='adminsubmsg text-sm'>{$message}</div>\n";
    $menu .= "<a href='$destination' class='lightlink2 admincell fieldnameback'>\n";
    $menu .= $iconstr;
    if ($number) {
        $menu .= "<div class='admintotal float-right'><strong>" . number_format($number) . "</strong></div>\n";
    }
    $menu .= "<div class='adminsubhead text-base mb-1'><strong>$label</strong></div>\n";
    $menu .= $msgstr;
    $menu .= "<div style='clear: both;'></div>\n";
    $menu .= "</a>\n";

    return $menu;
}

/**
 * @param $table
 * @param string $where
 * @return mixed|string
 */
function getTotal($table, $where = "") {
    global $assignedtree, $assignedbranch, $tngconfig;

    $total = "";
    if (!$tngconfig['hidetotals']) {
        if ($assignedtree) {
            if ($where == 1) {
                $where = "gedcom = '$assignedtree'";
                if ($assignedbranch) {
                    $where .= " AND branch LIKE '%{$assignedbranch}%'";
                }
            } elseif ($where == 2) {
                $where = "gedcom = '$assignedtree'";
            }
        }

        $query = "SELECT COUNT(*) AS num FROM $table";

        if ($where) $query .= " WHERE $where";
        $result = tng_query($query);
        $row = tng_fetch_assoc($result);
        $total = $row['num'];
        tng_free_result($result);
    }
    return $total;
}

$genmsg = $mediamsg = "";
if ($allow_add) {
    $genmsg .= _('Add') . " | ";
    $mediamsg = $genmsg;
} elseif ($allow_media_add) {
    $mediamsg = _('Add') . " | ";
}
$genmsg .= _('Find') . " | ";
$mediamsg .= _('Find') . " | ";
$notesmsg = _('Find') . " | ";
if ($allow_edit) {
    $genmsg .= _('Edit') . " | ";
    $mediamsg .= _('Edit') . " | ";
    $notesmsg .= _('Edit') . " | ";
} elseif ($allow_media_edit) {
    $mediamsg .= _('Edit') . " | ";
}
if ($allow_delete) {
    $genmsg .= _('Delete') . " | ";
    $mediamsg .= _('Delete') . " | ";
    $notesmsg .= _('Delete') . " | ";
} elseif ($allow_media_delete) {
    $mediamsg .= _('Delete') . " | ";
}
$sourcesmsg = $peoplemsg = $familiesmsg = $treesmsg = $cemeteriesmsg = $timelinemsg = $placesmsg = $genmsg;
$mediamsg .= _('Sort');
if ($allow_edit) {
    $peoplemsg .= _('Review') . " | ";
    $familiesmsg .= _('Review') . " | ";
}
if ($allow_edit && $allow_delete) {
    $peoplemsg .= _('Merge') . " | ";
    $placesmsg .= _('Merge') . " | ";
    $sourcesmsg .= _('Merge') . " | ";
}
$treesmsg = substr($treesmsg, 0, -3);
$peoplemsg = substr($peoplemsg, 0, -3);
$familiesmsg = substr($familiesmsg, 0, -3);
$sourcesmsg = substr($sourcesmsg, 0, -3);
$cemeteriesmsg = substr($cemeteriesmsg, 0, -3);
$placesmsg = substr($placesmsg, 0, -3);
$timelinemsg = substr($timelinemsg, 0, -3);
$notesmsg = substr($notesmsg, 0, -3);
tng_adminheader(_('Administration'), "");
?>
<script>
    jQuery(document).ready(function () {
        let tngadminmsg = getCookie('tngadminmsg');
        if (tngadminmsg !== "hide" && $('#msgs').length)
            toggleSection('msgs', 'plus0');
        //php: if no msg, then insert javascript to unset the cookie
    });

    function toggleMsg(section, img, display) {
        if (jQuery('#' + section).css('display') === "none")
            setCookie('tngadminmsg', "", 365);
        else
            setCookie('tngadminmsg', "hide", 365);
        toggleSection(section, img, display);

        return false;
    }

    function setCookie(cname, cvalue, exdays) {
        let d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        let expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires;
    }

    function getCookie(cname) {
        let name = cname + "=";
        let ca = document.cookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) === ' ') c = c.substring(1);
            if (c.indexOf(name) === 0) return c.substring(name.length, c.length);
        }
        return "";
    }
</script>
</head>

<?php echo tng_adminlayout("mainback"); ?>

<table class="mainbox m-auto w-full">
    <?php
    //no users?
    $messages = "";
    if ($allow_edit || $allow_add || $allow_delete) {
        $total_users = getTotal($users_table);
        $total_people = getTotal($people_table, 1);
        $total_families = getTotal($families_table, 1);

        if ($allow_edit && $allow_add && $allow_delete && !$assignedtree) {
            if (!$total_users) {
                $messages .= "<li><a href='admin_newuser.php'>" . _('Create a user account for yourself') . "</a></li>\n";
            }
            $total_trees = getTotal($trees_table);
            if (!$total_trees) {
                $messages .= "<li><a href='admin_newtree.php'>" . _('Create your first tree') . "</a></li>\n";
            }
            if (!$total_people) {
                $messages .= "<li><a href='admin_dataimport.php'>" . _('Import a GEDCOM file') . "</a> | <a href='admin_newperson.php'>" . _('add new people') . "</a></li>\n";
            } elseif (!$total_families) {
                $messages .= "<li><a href='admin_newfamily.php'>" . _('Add new families') . "</a></li>\n";
            }
            $review_users = getTotal($users_table, "allow_living = '-1'");
            if ($review_users) {
                $messages .= "<li><a href='admin_reviewusers.php'>" . _('Review new user registrations') . " ($review_users)</a></li>\n";
            }
            $review_people = getTotal("$people_table, $temp_events_table", "$people_table.personID = $temp_events_table.personID AND $people_table.gedcom = $temp_events_table.gedcom AND (type = 'I' OR type = 'C')");
            if ($review_people) {
                $messages .= "<li><a href='admin_findreview.php?type=I'>" . _('Review proposed changes to individual events') . " ($review_people)</a></li>\n";
            }
            $review_families = getTotal("$families_table, $temp_events_table", "$families_table.familyID = $temp_events_table.familyID AND $families_table.gedcom = $temp_events_table.gedcom AND type = 'F'");
            if ($review_families) {
                $messages .= "<li><a href='admin_findreview.php?type=F'>" . _('Review proposed changes to family events') . " ($review_families)</a></li>\n";
            }
            $backupmsg = "";
            $files = glob("$rootpath$backuppath/*.bak");
            $daysSince = $tngconfig['backupdays'];
            if (count($files)) {
                usort($files, function ($a, $b) {
                    if (filemtime($a) == filemtime($b)) {
                        return 0;
                    } else if (filemtime($a) < filemtime($b)) {
                        return 1;
                    } else {
                        return -1;
                    }
                });
                $lastBackupTime = filemtime($files[0]);
                if ($daysSince != "0") {
                    if (!$daysSince) $daysSince = 30;
                    if (time() - $lastBackupTime >= 60 * 60 * 24 * $daysSince) {
                        $backupmsg = preg_replace("/xxx/", $daysSince, _('last backup more than xxx days ago'));
                    }
                }
            } elseif ($total_people && $daysSince != "0") { //no backup ever done
                $backupmsg = _('no backups exist');
            }
            if ($backupmsg) {
                $messages .= "<li><a href='admin_utilities.php'>" . _('Back up the data') . " ($backupmsg)</a></li>\n";
            }
            if (!$map['key'] || $map['key'] == "1") { // need google map api key
                $messages .= "<li><a href='admin_mapconfig.php'>" . _('Get a map key from Google to enable maps display') . "</a></li>\n";
            }
        }
    }
    if (!$tngconfig['hidetasks'] && $messages) {
        $messages = "<ul>\n$messages</ul>\n";
        ?>
        <tr>
            <td class="align-top w-1/2 max-w-lg" colspan="2">
                <div class="tngmsgarea">
                    <a href="#" onclick="return toggleMsg('msgs','plus0');" class="togglehead no-underline">
                        <img src="img/tng_expand.gif" title="toggle display" alt="toggle display" id="plus0" class="inline-block">
                        <strong class="adminsubhead text-base mb-1 ml-1"><?php echo _('Important tasks'); ?></strong>
                    </a>
                    <div id="msgs" style="display:none;">
                        <hr>
                        <?php echo $messages; ?>
                    </div>
                </div>
            </td>
        </tr>
    <?php } ?>
    <tr>
        <td class="align-top w-1/2 max-w-lg">
            <?php
            if ($allow_edit || $allow_add || $allow_delete) {
                echo adminMenuItem("admin_people.php", _('People'), $total_people, $peoplemsg, "people");
                echo adminMenuItem("admin_families.php", _('Families'), $total_families, $familiesmsg, "families");
                echo adminMenuItem("admin_sources.php", _('Sources'), getTotal($sources_table, 2), $sourcesmsg, "sources");
                echo adminMenuItem("admin_repositories.php", _('Repositories'), getTotal($repositories_table, 2), $sourcesmsg, "repos");
            }
            if ($allow_edit || $allow_add || $allow_delete || $allow_media_add || $allow_media_edit || $allow_media_delete) {
                echo adminMenuItem("admin_media.php", _('Media'), getTotal($media_table, 2), $mediamsg, "photos");
                echo adminMenuItem("admin_albums.php", _('Albums'), getTotal($albums_table), $mediamsg, "albums");
            }
            if ($allow_edit || $allow_add || $allow_delete) {
                echo adminMenuItem("admin_cemeteries.php", _('Cemeteries'), getTotal($cemeteries_table), $cemeteriesmsg, "cemeteries");
                echo adminMenuItem("admin_places.php", _('Places'), getTotal($places_table, (!$assignedtree || $tngconfig['places1tree'] ? "" : 2)), $placesmsg, "places");
                echo adminMenuItem("admin_timelineevents.php", _('Timeline Events'), getTotal($tlevents_table), $timelinemsg, "tlevents");
            }
            if ($allow_edit || $allow_delete) {
                echo adminMenuItem("admin_notelist.php", _('Notes'), getTotal($notelinks_table, 2), $notesmsg, "notes");
            }
            if ($allow_edit && $allow_add && $allow_delete && !$assignedtree) {
                echo adminMenuItem("admin_misc.php", _('Miscellaneous'), "", _('What\'s New, Most Wanted, Data Validation'), "misc");
            }
            ?>
        </td>
        <td class="align-top w-1/2 max-w-lg">
            <?php
            if ($allow_edit && $allow_add && $allow_delete && !$assignedbranch) {
                echo adminMenuItem("admin_dataimport.php", _('Import/Export'), "", _('Import a GEDCOM file'), "data");
            }
            if ($allow_edit && $allow_add && $allow_delete && !$assignedtree) {
                echo adminMenuItem("admin_setup.php", _('Setup'), "", _('Create database tables, Set preferences'), "setup");
                echo adminMenuItem("admin_users.php", _('Users'), $total_users, _('Manage users and permissions'), "users");
                echo adminMenuItem("admin_trees.php", _('Trees'), $total_trees, $treesmsg, "trees");

                if (!$assignedbranch) {
                    echo adminMenuItem("admin_branches.php", _('Branches'), getTotal($branches_table, 2), $treesmsg, "branches");
                }
                echo adminMenuItem("admin_eventtypes.php", _('Custom Event Types'), getTotal($eventtypes_table), _('Manage custom tags and event types'), "customeventtypes");
                echo adminMenuItem("admin_reports.php", _('Reports'), getTotal($reports_table), _('Create custom lists and reports'), "reports");
                echo adminMenuItem("admin_dna_tests.php", _('DNA Tests'), getTotal($dna_tests_table), _('Log DNA tests and link them to individuals'), "dna");
                echo adminMenuItem("admin_languages.php", _('Languages'), getTotal($languages_table), $treesmsg, "languages");
                echo adminMenuItem("admin_utilities.php", _('Utilities'), "", _('Back up, restore and optimize database tables'), "backuprestore");
            }
            ?>
        </td>
    </tr>
</table>
<?php echo tng_adminfooter(); ?>

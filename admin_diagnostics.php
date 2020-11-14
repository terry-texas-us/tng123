<?php
//This page written and contributed by Bert Deelman. Thanks, Bert!
include "begin.php";
include "config/logconfig.php";
include "config/importconfig.php";
include "adminlib.php";
$textpart = "setup";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
$file_uploads = (bool)ini_get("file_uploads");
$safe_mode = (bool)ini_get("safe_mode");

error_reporting(E_ERROR | E_PARSE);    //	Disable error reporting for anything but critical errors

$helplang = findhelp("setup_help.php");

$red = "<img src='img/tng_close.gif'>";
$orange = "<img src='img/orange.gif'>";
$green = "<img src='img/tng_check.gif'>";

tng_adminheader(_('Diagnostics'), $flags);

echo "</head>\n";
echo tng_adminlayout();

$setuptabs[0] = [1, "admin_setup.php", _('Configuration'), "configuration"];
$setuptabs[1] = [1, "admin_diagnostics.php", _('Diagnostics'), "diagnostics"];
$setuptabs[2] = [1, "admin_setup.php?sub=tablecreation", _('Table Creation'), "tablecreation"];
$innermenu = "<a href='#' class='lightlink'>" . _('Help for this area') . " onclick='return openHelp(\"$helplang/setup_help.php#diagnostics\");'</a>";
$menu = doMenu($setuptabs, "diagnostics", $innermenu);
echo displayHeadline(_('Setup') . " &gt;&gt; " . _('Diagnostics'), "img/setup_icon.gif", $menu, "");
?>

    <table class="lightback normal w-full" cellpadding="10" cellspacing="2">
        <tr>
            <td class="tngshadow databack" colspan="2"><em><?php echo _('Information about your web site environment.'); ?></em></td>
        </tr>
        <tr>
            <td class="tngshadow databack"><?php echo _('PHP version'); ?>:<br><em><?php echo _('(TNG requires 5.6 or higher.)'); ?></em></td>
            <td class="tngshadow databack">
                <?php
                $phpver = floatval(phpversion());
                if ($phpver >= 5.6) {
                    echo "<p>$green&nbsp;";
                } else {
                    echo "<p>$red&nbsp;";
                }
                echo 'PHP ' . phpversion();
                ?>
                <br>
                <a href="admin_phpinfo.php"><?php echo _('PHP Info Screen'); ?></a>
            </td>
        </tr>
        <tr>
            <td class="tngshadow databack"><?php echo _('GD graphics library'); ?>:<br><em><?php echo _('(Required for TNG\'s thumbnail creation tools.)'); ?></em></td>
            <td class="tngshadow databack">
                <?php
                if (extension_loaded('gd')) {
                    if (ImageTypes() & IMG_GIF) {
                        echo "<p>$green&nbsp;" . _('Available') . "</p>";
                    } else {
                        echo "<p>$orange&nbsp;" . _('Available, but does not support .gif images') . "</p>";
                    }
                } else {
                    echo "<p>$red&nbsp;" . _('Not installed') . "</p>";
                }
                ?>
            </td>
        </tr>
        <tr>
            <td class="tngshadow databack"><?php echo _('Safe Mode'); ?>:</td>
            <td class="tngshadow databack">
                <?php
                if (!$safe_mode) {
                    echo "<p>$green&nbsp;" . _('Off') . "</p>";
                } else {
                    echo "<p>$orange&nbsp;" . _('On') . "</p>";
                }
                ?>
            </td>
        </tr>
        <tr>
            <td class="tngshadow databack"><?php echo _('File Uploads'); ?>:<br><em><?php echo _('(Required for web-based GEDCOM upload, image upload and other form functionality.)'); ?></em></td>
            <td class="tngshadow databack">
                <?php
                if ($file_uploads) {
                    echo "<p>$green&nbsp;" . _('Permitted') . "</p>";
                } else {
                    echo "<p>$red&nbsp;" . _('Not permitted, use FTP instead') . "</p>";
                }
                ?>
            </td>
        </tr>
        <tr>
            <td class="tngshadow databack"><?php echo _('MySQL version'); ?>:<br><em><?php echo _('(TNG requires 5.5 or higher.)'); ?></em></td>
            <td class="tngshadow databack">
                <?php
                $client_info = tng_get_client_info();
                $dbci = floatval(preg_replace("/[^-0-9\.]/", "", $client_info));
                if (strpos($client_info, "mysqlnd") === 0 || $dbci >= 5.5) {
                    echo "<p>$green&nbsp;";
                } else {
                    if ($dbci >= 5) {
                        echo "<p>$orange&nbsp;";
                    } else {
                        echo "<p>$red&nbsp;";
                    }
                }
                echo 'MySQL ' . tng_get_client_info() . " " . _('(client)') . "</p>";
                $dbsi = floatval(preg_replace("/[^-0-9\.]/", "", tng_get_server_info()));
                if ($dbsi >= 5.5) {
                    echo "<p>$green&nbsp;";
                } else {
                    if ($dbsi >= 5) {
                        echo "<p>$orange&nbsp;";
                    } else {
                        echo "<p>$red&nbsp;";
                    }
                }
                echo 'MySQL ' . tng_get_server_info() . " " . _('(server)') . "</p>";
                ?>
            </td>
        </tr>
        <tr>
            <td class="tngshadow databack"><?php echo _('Webserver'); ?>:</td>
            <td class="tngshadow databack">
                <?php
                echo "<p>$green&nbsp;";
                echo $_SERVER['SERVER_SOFTWARE'] . "</p>";
                ?>
            </td>
        </tr>
        <tr>
            <td class="tngshadow databack"><?php echo _('File/Folder Permissions'); ?>:<br><em><?php echo _('(TNG requires some files and folders to have special access rights.)'); ?></em></td>
            <td class="tngshadow databack">
                <?php
                $myuserid = getmyuid();
                if (phpversion() >= '4.1.0') {
                    $mygroupid = getmygid();
                } else {
                    $mygroupid = getmyuid();
                }

                if (function_exists('posix_getuid')) {
                    $posixmyuserid = posix_getuid();
                    $posixuserinfo = posix_getpwuid($posixmyuserid);
                    $posixname = $posixuserinfo['name'];
                    $posixmygroupid = $posixuserinfo['gid'];
                    $posixgroupinfo = posix_getgrgid($posixmygroupid);
                    $posixgroup = $posixgroupinfo['name'];
                } else {
                    $posixmyuserid = $myuserid;
                    $posixname = get_current_user();
                    $posixmygroupid = $mygroupid;
                    $posixgroup = '';
                }

                if ($myuserid != $posixmyuserid) $myuserid = $posixmyuserid;

                if ($mygroupid != $posixmygroupid) $mygroupid = $posixmygroupid;


                $text = '';
                $ftext = '';
                // check files
                if (!(fileReadWrite($myuserid, $mygroupid, 'config/config.php'))) {
                    $text = "<p>$red&nbsp;" . _('File is read-only:') . " config.php</p>";
                }
                $uselog = $logname;
                if (!(fileReadWrite($myuserid, $mygroupid, $uselog))) {
                    $ftext = "<p>$red&nbsp;" . _('File is read-only:') . " " . _('Public log') . " ($logname)</p>";
                }
                if (!(fileReadWrite($myuserid, $mygroupid, $adminlogfile))) {
                    $ftext .= "<p>$red&nbsp;" . _('File is read-only:') . " " . _('Admin log') . " ($adminlogfile)</p>";
                }
                if (!(fileReadWrite($myuserid, $mygroupid, 'config/importconfig.php'))) {
                    $ftext .= "<p>$red&nbsp;" . _('File is read-only:') . " importconfig.php</p>";
                }
                if (!(fileReadWrite($myuserid, $mygroupid, 'config/logconfig.php'))) {
                    $ftext .= "<p>$red&nbsp;" . _('File is read-only:') . " logconfig.php</p>";
                }
                if (!(fileReadWrite($myuserid, $mygroupid, 'config/pedconfig.php'))) {
                    $ftext .= "<p>$red&nbsp;" . _('File is read-only:') . " pedconfig.php</p>";
                }
                if (!(fileReadWrite($myuserid, $mygroupid, 'config/mapconfig.php'))) {
                    $ftext .= "<p>$red&nbsp;" . _('File is read-only:') . " mapconfig.php</p>";
                }

                // check folders
                if (!(dirExists($photopath))) {
                    $ftext .= "<p>$red&nbsp;" . _('Folder does not exist:') . " $photopath</p>";
                } else {
                    if (!(dirReadWrite($myuserid, $mygroupid, $photopath))) {
                        $ftext .= "<p>$orange&nbsp;" . _('Folder is read-only:') . " $photopath ($rootpath$photopath)</p>";
                    }
                }
                if (!(dirExists($headstonepath))) {
                    $ftext .= "<p>$red&nbsp;" . _('Folder does not exist:') . " $headstonepath</p>";
                } else {
                    if (!(dirReadWrite($myuserid, $mygroupid, $headstonepath))) {
                        $ftext .= "<p>$orange&nbsp;" . _('Folder is read-only:') . " $headstonepath ($rootpath$headstonepath)</p>";
                    }
                }
                if (!(dirExists($historypath))) {
                    $ftext .= "<p>$orange&nbsp;" . _('Folder does not exist:') . " $historypath ($rootpath$historypath)</p>";
                } else {
                    if (!(dirReadWrite($myuserid, $mygroupid, $historypath))) {
                        $ftext .= "<p>$orange&nbsp;" . _('Folder is read-only:') . " $historypath ($rootpath$historypath)</p>";
                    }
                }
                if (!(dirExists($backuppath))) {
                    $ftext .= "<p>$orange&nbsp;" . _('Folder does not exist:') . " $backuppath ($rootpath$backuppath)</p>";
                } else {
                    if (!(dirReadWrite($myuserid, $mygroupid, $backuppath))) {
                        $ftext .= "<p>$orange&nbsp;" . _('Folder is read-only:') . " $backuppath ($rootpath$backuppath)</p>";
                    }
                }
                if (!(dirExists($gedpath))) {
                    $ftext .= "<p>$orange&nbsp;" . _('Folder does not exist:') . " $gedpath ($rootpath$gedpath)</p>";
                } else {
                    if (!(dirReadWrite($myuserid, $mygroupid, $gedpath))) {
                        $ftext .= "<p>$orange&nbsp;" . _('Folder is read-only:') . " $gedpath ($rootpath$gedpath)</p>";
                    }
                }
                if ($ftext == '') {
                    $ftext = "<p>$green&nbsp;" . _('Key folders are all read/write') . "</p>";
                }
                echo $ftext;

                if ($text == '') {
                    echo "<p>$green&nbsp;" . _('Configuration files are all read/write') . "</p>";
                }
                echo $text;
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="tngshadow databack">
                <p><img src="img/tng_check.gif"> = <?php echo _('Acceptable.'); ?></p>
                <p><img src="img/orange.gif"> = <?php echo _('Some functionality may be restricted. You may encounter errors during installation or while running TNG.'); ?></p>
                <p><img src="img/tng_close.gif"> = <?php echo _('TNG may not run without changes to your PHP or server configuration.'); ?></p>
                <p><?php echo "" . _('Your browser:') . " {$_SERVER['HTTP_USER_AGENT']}"; ?></p>
            </td>
        </tr>
    </table>
<?php
function fileReadWrite($myuserid, $mygroupid, $fileref) {
    $rval = false;

    $userid = fileowner($fileref);
    $groupid = filegroup($fileref);
    $perms = readPerms(fileperms($fileref));

    if ($myuserid == $userid) {
        if (substr($perms, 2, 1) == 'w') {
            $rval = true;
        } elseif ($mygroupid == $groupid) {
            if (substr($perms, 5, 1) == 'w') {
                $rval = true;
            } elseif (substr($perms, 8, 1) == 'w') {
                $rval = true;
            }
        }
    } elseif ($mygroupid == $groupid) {
        if (substr($perms, 5, 1) == 'w') $rval = true;

    } elseif (substr($perms, 8, 1) == 'w') {
        $rval = true;
    }

    return $rval;
}

function dirExists($dirref) {
    $rval = false;

    if (is_dir($dirref)) {
        $rval = true;
    } else {
        $rval = false;
    }
    return $rval;
}

function dirReadWrite($myuserid, $mygroupid, $dirref) {
    $rval = false;

    $userid = fileowner($dirref);
    $groupid = filegroup($dirref);
    $perms = readPerms(fileperms($dirref));

    if ($myuserid == $userid) {
        if (substr($perms, 2, 1) == 'w') {
            $rval = true;
        } elseif ($mygroupid == $groupid) {
            if (substr($perms, 5, 1) == 'w') {
                $rval = true;
            } elseif (substr($perms, 8, 1) == 'w') {
                $rval = true;
            }
        }
    } elseif ($mygroupid == $groupid) {
        if (substr($perms, 5, 1) == 'w') $rval = true;

    } elseif (substr($perms, 8, 1) == 'w') {
        $rval = true;
    }

    return $rval;
}

function readPerms($in_Perms) {
    $sP = '';

    if ($in_Perms & 0x1000) {
        $sP = 'p'; // FIFO pipe
    } elseif ($in_Perms & 0x2000) {
        $sP = 'c'; // Character special
    } elseif ($in_Perms & 0x4000) {
        $sP = 'd'; // Directory
    } elseif ($in_Perms & 0x6000) {
        $sP = 'b'; // Block special
    } elseif ($in_Perms & 0x8000) {
        $sP = '-'; // Regular
    } elseif ($in_Perms & 0xA000) {
        $sP = 'l'; // Symbolic Link
    } elseif ($in_Perms & 0xC000) {
        $sP = 's'; // Socket
    } else {
        $sP = 'u'; // UNKNOWN
    }

    // owner
    $sP .= (($in_Perms & 0x0100) ? 'r' : '-') . (($in_Perms & 0x0080) ? 'w' : '-') . (($in_Perms & 0x0040) ? (($in_Perms & 0x0800) ? 's' : 'x') : (($in_Perms & 0x0800) ? 'S' : '-'));
    // group
    $sP .= (($in_Perms & 0x0020) ? 'r' : '-') . (($in_Perms & 0x0010) ? 'w' : '-') . (($in_Perms & 0x0008) ? (($in_Perms & 0x0400) ? 's' : 'x') : (($in_Perms & 0x0400) ? 'S' : '-'));
    // world
    $sP .= (($in_Perms & 0x0004) ? 'r' : '-') . (($in_Perms & 0x0002) ? 'w' : '-') . (($in_Perms & 0x0001) ? (($in_Perms & 0x0200) ? 't' : 'x') : (($in_Perms & 0x0200) ? 'T' : '-'));
    return $sP;
}

echo tng_adminfooter();
?>
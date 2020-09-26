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

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['diagnostics'], $flags);
echo "</head>\n";
?>

    <body class="admin-body">

    <?php
    $setuptabs[0] = [1, "admin_setup.php", $admtext['configuration'], "configuration"];
    $setuptabs[1] = [1, "admin_diagnostics.php", $admtext['diagnostics'], "diagnostics"];
    $setuptabs[2] = [1, "admin_setup.php?sub=tablecreation", $admtext['tablecreation'], "tablecreation"];
    $innermenu = "<a href='#' class='lightlink'>{$admtext['help']} onclick='return openHelp(\"$helplang/setup_help.php#diagnostics\");'</a>";
    $menu = doMenu($setuptabs, "diagnostics", $innermenu);
    echo displayHeadline($admtext['setup'] . " &gt;&gt; " . $admtext['diagnostics'], "img/setup_icon.gif", $menu, "");
    ?>

    <table class="lightback normal w-100" cellpadding="10" cellspacing="2">
        <tr>
            <td class="tngshadow databack" colspan="2"><em><?php echo $admtext['sysinfo']; ?></em></td>
        </tr>
        <tr>
            <td class="tngshadow databack"><?php echo $admtext['phpver']; ?>:<br><em><?php echo $admtext['phpreq']; ?></em></td>
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
                <a href="admin_phpinfo.php"><?php echo $admtext['phpinf']; ?></a>
            </td>
        </tr>
        <tr>
            <td class="tngshadow databack"><?php echo $admtext['gdlib']; ?>:<br><em><?php echo $admtext['gdreq']; ?></em></td>
            <td class="tngshadow databack">
                <?php
                if (extension_loaded('gd')) {
                    if (ImageTypes() & IMG_GIF) {
                        echo "<p>$green&nbsp;" . $admtext['available'] . "</p>";
                    } else {
                        echo "<p>$orange&nbsp;" . $admtext['availnogif'] . "</p>";
                    }
                } else {
                    echo "<p>$red&nbsp;" . $admtext['notinst'] . "</p>";
                }
                ?>
            </td>
        </tr>
        <tr>
            <td class="tngshadow databack"><?php echo $admtext['safemode']; ?>:</td>
            <td class="tngshadow databack">
                <?php
                if (!$safe_mode) {
                    echo "<p>$green&nbsp;" . $admtext['off'] . "</p>";
                } else {
                    echo "<p>$orange&nbsp;" . $admtext['on'] . "</p>";
                }
                ?>
            </td>
        </tr>
        <tr>
            <td class="tngshadow databack"><?php echo $admtext['fileuploads']; ?>:<br><em><?php echo $admtext['fureq']; ?></em></td>
            <td class="tngshadow databack">
                <?php
                if ($file_uploads) {
                    echo "<p>$green&nbsp;" . $admtext['perm'] . "</p>";
                } else {
                    echo "<p>$red&nbsp;" . $admtext['notperm'] . "</p>";
                }
                ?>
            </td>
        </tr>
        <tr>
            <td class="tngshadow databack"><?php echo $admtext['sqlver']; ?>:<br><em><?php echo $admtext['sqlreq']; ?></em></td>
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
                echo 'MySQL ' . tng_get_client_info() . " " . $admtext['client'] . "</p>";
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
                echo 'MySQL ' . tng_get_server_info() . " " . $admtext['server'] . "</p>";
                ?>
            </td>
        </tr>
        <tr>
            <td class="tngshadow databack"><?php echo $admtext['wsrvr']; ?>:</td>
            <td class="tngshadow databack">
                <?php
                echo "<p>$green&nbsp;";
                echo $_SERVER['SERVER_SOFTWARE'] . "</p>";
                ?>
            </td>
        </tr>
        <tr>
            <td class="tngshadow databack"><?php echo $admtext['fperms']; ?>:<br><em><?php echo $admtext['fpreq']; ?></em></td>
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

                if ($myuserid != $posixmyuserid) {
                    $myuserid = $posixmyuserid;
                }
                if ($mygroupid != $posixmygroupid) {
                    $mygroupid = $posixmygroupid;
                }

                $text = '';
                $ftext = '';
                // check files
                if (!(fileReadWrite($myuserid, $mygroupid, 'config/config.php'))) {
                    $text = "<p>$red&nbsp;{$admtext['rofile']} config.php</p>";
                }
                $uselog = $logname;
                if (!(fileReadWrite($myuserid, $mygroupid, $uselog))) {
                    $ftext = "<p>$red&nbsp;{$admtext['rofile']} {$admtext['publog']} ($logname)</p>";
                }
                if (!(fileReadWrite($myuserid, $mygroupid, $adminlogfile))) {
                    $ftext .= "<p>$red&nbsp;{$admtext['rofile']} {$admtext['admlog']} ($adminlogfile)</p>";
                }
                if (!(fileReadWrite($myuserid, $mygroupid, 'config/importconfig.php'))) {
                    $ftext .= "<p>$red&nbsp;{$admtext['rofile']} importconfig.php</p>";
                }
                if (!(fileReadWrite($myuserid, $mygroupid, 'config/logconfig.php'))) {
                    $ftext .= "<p>$red&nbsp;{$admtext['rofile']} logconfig.php</p>";
                }
                if (!(fileReadWrite($myuserid, $mygroupid, 'config/pedconfig.php'))) {
                    $ftext .= "<p>$red&nbsp;{$admtext['rofile']} pedconfig.php</p>";
                }
                if (!(fileReadWrite($myuserid, $mygroupid, 'config/mapconfig.php'))) {
                    $ftext .= "<p>$red&nbsp;{$admtext['rofile']} mapconfig.php</p>";
                }

                // check folders
                if (!(dirExists($photopath))) {
                    $ftext .= "<p>$red&nbsp;{$admtext['folderdne']} $photopath</p>";
                } else {
                    if (!(dirReadWrite($myuserid, $mygroupid, $photopath))) {
                        $ftext .= "<p>$orange&nbsp;{$admtext['rofolder']} $photopath ($rootpath$photopath)</p>";
                    }
                }
                if (!(dirExists($headstonepath))) {
                    $ftext .= "<p>$red&nbsp;{$admtext['folderdne']} $headstonepath</p>";
                } else {
                    if (!(dirReadWrite($myuserid, $mygroupid, $headstonepath))) {
                        $ftext .= "<p>$orange&nbsp;{$admtext['rofolder']} $headstonepath ($rootpath$headstonepath)</p>";
                    }
                }
                if (!(dirExists($historypath))) {
                    $ftext .= "<p>$orange&nbsp;{$admtext['folderdne']} $historypath ($rootpath$historypath)</p>";
                } else {
                    if (!(dirReadWrite($myuserid, $mygroupid, $historypath))) {
                        $ftext .= "<p>$orange&nbsp;{$admtext['rofolder']} $historypath ($rootpath$historypath)</p>";
                    }
                }
                if (!(dirExists($backuppath))) {
                    $ftext .= "<p>$orange&nbsp;{$admtext['folderdne']} $backuppath ($rootpath$backuppath)</p>";
                } else {
                    if (!(dirReadWrite($myuserid, $mygroupid, $backuppath))) {
                        $ftext .= "<p>$orange&nbsp;{$admtext['rofolder']} $backuppath ($rootpath$backuppath)</p>";
                    }
                }
                if (!(dirExists($gedpath))) {
                    $ftext .= "<p>$orange&nbsp;{$admtext['folderdne']} $gedpath ($rootpath$gedpath)</p>";
                } else {
                    if (!(dirReadWrite($myuserid, $mygroupid, $gedpath))) {
                        $ftext .= "<p>$orange&nbsp;{$admtext['rofolder']} $gedpath ($rootpath$gedpath)</p>";
                    }
                }
                if ($ftext == '') {
                    $ftext = "<p>$green&nbsp;" . $admtext['keyrw'] . "</p>";
                }
                echo $ftext;

                if ($text == '') {
                    echo "<p>$green&nbsp;" . $admtext['cfgrw'] . "</p>";
                }
                echo $text;
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="tngshadow databack">
                <p><img src="img/tng_check.gif"> = <?php echo $admtext['acceptable']; ?></p>
                <p><img src="img/orange.gif"> = <?php echo $admtext['restricted']; ?></p>
                <p><img src="img/tng_close.gif"> = <?php echo $admtext['needchngs']; ?></p>
                <p><?php echo "{$admtext['yourbrowser']} {$_SERVER['HTTP_USER_AGENT']}"; ?></p>
            </td>
        </tr>
    </table>
    <?php echo "<div style='text-align: center;'><span class='normal'>$tng_title</span></div>"; ?>
    </body>
    </html>
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
        if (substr($perms, 5, 1) == 'w') {
            $rval = true;
        }
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
        if (substr($perms, 5, 1) == 'w') {
            $rval = true;
        }
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
?>
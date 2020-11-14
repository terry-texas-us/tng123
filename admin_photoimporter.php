<?php
include "begin.php";
include "adminlib.php";
$textpart = "photos";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
require "adminlog.php";

if (!$allow_media_add || $assignedtree) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$totalImported = 0;
function importFrom($tngpath, $orgpath, $needsubdirs) {
    global $rootpath, $media_table, $mediatypeID, $tree, $time_offset, $thumbprefix, $thumbsuffix, $totalImported;
    $subdirs = [];

    if ($orgpath) {
        $path = $tngpath . "/" . $orgpath;
        $orgpath .= "/";
    } else {
        $path = $tngpath;
    }
    @chdir("$rootpath$path") or die("Unable to open $rootpath$path. Please check your Root Path (General Settings).");
    if ($handle = @opendir('.')) {
        while ($filename = readdir($handle)) {
            if (is_file($filename)) {
                if (($thumbprefix && strpos($filename, $thumbprefix) !== 0) || ($thumbsuffix && substr($filename, -strlen($thumbsuffix)) != $thumbsuffix)) {
                    echo "Inserting $path/$filename ... ";
                    //insert ignore into database
                    $fileparts = pathinfo($filename);
                    $form = strtoupper($fileparts["extension"]);
                    $newdate = date("Y-m-d H:i:s", time() + (3600 * $time_offset));
                    $query = "INSERT IGNORE INTO $media_table (mediatypeID,mediakey,gedcom,path,thumbpath,description,notes,width,height,datetaken,placetaken,owner,changedate,form,alwayson,map,abspath,status,cemeteryID,showmap,linktocem,latitude,longitude,zoom,bodytext,usenl,newwindow,usecollfolder)
						VALUES (\"$mediatypeID\",\"$path/$filename\",'$tree',\"$orgpath$filename\",\"\",\"$orgpath$filename\",\"\",\"\",\"\",\"\",\"\",\"\",\"$newdate\",\"$form\",'0',\"\",'0',\"\",\"\",'0','0',\"\",\"\",'0',\"\",'0','0','1')";
                    @tng_query($query);
                    $success = tng_affected_rows();

                    if ($success) {
                        echo "success<br>\n";
                        $totalImported++;
                    } else {
                        echo "<strong>failed (duplicate)</strong><br>\n";
                    }
                }
            } elseif ($needsubdirs && is_dir($filename) && $filename != '..' && $filename != '.') {
                // Added to remove Synology @ea type files
                if (fnmatch("@ea*", $filename)) {
                    continue;
                } else {
                    array_push($subdirs, $filename);
                }
            }
        }
        closedir($handle);
    }

    return $subdirs;
}

$helplang = findhelp("data_help.php");
adminwritelog(_('Media') . " &gt;&gt; " . _('Import') . " ($mediatypeID): $tree");

tng_adminheader(_todo_('Photo Import'), $flags);

$tngpath = $mediatypes_assoc[$mediatypeID];

echo "</head>\n";
echo tng_adminlayout();

$mediatabs[0] = [1, "admin_media.php", _('Search'), "findmedia"];
$mediatabs[1] = [$allow_media_add, "admin_newmedia.php", _('Add New'), "addmedia"];
$mediatabs[2] = [$allow_media_edit, "admin_ordermediaform.php", _('Sort'), "sortmedia"];
$mediatabs[3] = [$allow_media_edit && !$assignedtree, "admin_thumbnails.php", _('Thumbnails'), "thumbs"];
$mediatabs[4] = [!$assignedtree, "admin_photoimport.php", _('Import'), "import"];
$mediatabs[5] = [!$assignedtree, "admin_mediaupload.php", _('Upload'), "upload"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/media_help.php#modify');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($mediatabs, "import", $innermenu);
echo displayHeadline(_('Media') . " &gt;&gt; " . _('Import'), "img/photos_icon.gif", $menu, $message);
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow normal">
                <?php
                $subdirs = importFrom($tngpath, '', 1);
                foreach ($subdirs as $subdir) {
                chdir("$rootpath$tngpath/$subdir");
                importFrom($tngpath, $subdir, 0);
            }
            if ($totalImported) {
                $query = "UPDATE $mediatypes_table SET disabled='0' where mediatypeID=\"$mediatypeID\"";
                $result = @tng_query($query);
            }
            ?>
        </td>
    </tr>

</table>
<?php echo tng_adminfooter(); ?>
<?php
include "begin.php";
include "genlib.php";
include "getlang.php";

include "checklogin.php";

$newroot = preg_replace("/\//", "", $rootpath);
$newroot = preg_replace("/\s*/", "", $newroot);
$newroot = preg_replace("/\./", "", $newroot);
$ref = "tngbookmarks_$newroot";
$bookmarks = $_COOKIE[$ref];
$found = 0;

$bookmarks = explode("|", $_COOKIE[$ref]);
$bookmarkstr = "";
$bcount = 0;
foreach ($bookmarks as $bookmark) {
    if (trim($bookmark)) {
        if ($idx != $bcount) {
            $bookmarkstr = $bookmarkstr ? $bookmarkstr . "|" . $bookmark : $bookmark;
        }
        $bcount++;
    }
}

setcookie($ref, stripslashes($bookmarkstr), time() + 31536000, "/");

header("Location: bookmarks.php");



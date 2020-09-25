<?php
include "begin.php";
include "genlib.php";
$textpart = "imgviewer";
include "getlang.php";
include "$mylanguage/text.php";

header("Content-type:text/html;charset=" . $session_charset);
?>
<!doctype html>
<html lang="en">

<head>
    <?php @include $custommeta;
    if ($session_charset) {
        echo "<meta http-equiv=\"Content-type\" content=\"text/html; charset=$session_charset\">\n";
    }
    $title = $_GET['title'];
    $siteprefix = $sitename ? htmlspecialchars($title ? ": " . $sitename : $sitename, ENT_QUOTES, $session_charset) : "";
    $title = htmlspecialchars($title, ENT_QUOTES, $session_charset);
    ?>
    <link href="css/img_viewer.css" rel="stylesheet">
    <script src="js/img_viewer.js"></script>
    <title><?php echo $title; ?></title>
</head>

<body onload="calcHeight(window.innerHeight);">
<?php
include "js/img_utils.js";
echo "<div id=\"loadingdiv2\" style=\"position:static;\">{$text['loading']}</div>\n";
?>

<iframe name="iframe1" id="iframe1"
    src="img_viewer.php?sa=1&mediaID=<?php echo $_GET['mediaID']; ?>&medialinkID=<?php echo $_GET['medialinkID']; ?>"
    width="100%" height="1" onLoad="calcHeight(1);" frameborder="0" marginheight="0" marginwidth="0" scrolling="no">
</iframe>
</body>
</html>
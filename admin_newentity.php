<?php
include "begin.php";
include "adminlib.php";
$textpart = "entities";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
if (!$allow_add) {
    $message = $admtext['norights'];
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack normal" style="margin:10px;border:0;" id="newentity">
    <h3 class="subhead"><?php echo $admtext['enternew'] . " " . $admtext[$entity]; ?></h3>

    <form action="admin_addentity.php" method="post" name="entityform" id="entityform" onsubmit="return addEntity(this);">
        <input type="hidden" name="entity" value="<?php echo "$entity"; ?>">
        &nbsp;<input type="text" name="newitem" id="newitem">
        <input type="submit" value="<?php echo $admtext['add']; ?>">
        <br>
        <div class="normal" id="entitymsg" style="color: #008000;"></div>
    </form>
</div>

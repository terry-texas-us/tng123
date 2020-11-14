<?php

include "begin.php";
include "adminlib.php";
require_once "admin/pagination.php";
$textpart = "language";
include "$mylanguage/admintext.php";
$admin_login = 1;
include "checklogin.php";
include "version.php";
if ($assignedtree) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$tng_search_langs = $_SESSION['tng_search_langs'] = 1;
if ($newsearch) {
    $exptime = 0;
    setcookie("tng_search_langs_post[search]", $searchstring, $exptime);
    setcookie("tng_search_langs_post[tngpage]", 1, $exptime);
    setcookie("tng_search_langs_post[offset]", 0, $exptime);
} else {
    if (!$searchstring) {
        $searchstring = stripslashes($_COOKIE['tng_search_langs_post']['search']);
    }
    if (!isset($offset)) {
        $tngpage = $_COOKIE['tng_search_langs_post']['tngpage'];
        $offset = $_COOKIE['tng_search_langs_post']['offset'];
    } else {
        $exptime = 0;
        setcookie("tng_search_langs_post[tngpage]", $tngpage, $exptime);
        setcookie("tng_search_langs_post[offset]", $offset, $exptime);
    }
}

if ($offset) {
    $offsetplus = $offset + 1;
    $newoffset = "$offset, ";
} else {
    $offsetplus = 1;
    $newoffset = "";
    $tngpage = 1;
}

$wherestr = $searchstring ? "WHERE display LIKE \"%$searchstring%\" OR folder LIKE \"%$searchstring%\"" : "";
$query = "SELECT languageID, display, folder, charset FROM $languages_table $wherestr ORDER BY display LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);

$numrows = tng_num_rows($result);
if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $query = "SELECT count(languageID) AS lcount FROM $languages_table $wherestr";
    $result2 = tng_query($query);
    $row = tng_fetch_assoc($result2);
    $totrows = $row['lcount'];
    tng_free_result($result2);
} else {
    $totrows = $numrows;
}

$helplang = findhelp("languages_help.php");

tng_adminheader(_('Languages'), $flags);

echo "</head>\n";
echo tng_adminlayout();

$langtabs['0'] = [1, "admin_languages.php", _('Search'), "findlang"];
$langtabs['1'] = [$allow_add, "admin_newlanguage.php", _('Add New'), "addlanguage"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/languages_help.php');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($langtabs, "findlang", $innermenu);
echo displayHeadline(_('Languages'), "img/languages_icon.gif", $menu, $message);
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <div class="normal">

                    <form action="admin_languages.php" name="form1">
                        <?php echo _('Search for'); ?>:
                        <input class="longfield" name="searchstring" type="search" value="<?php echo $searchstring; ?>">
                        <input type="hidden" name="findlang" value="1">
                        <input type="hidden" name="newsearch" value="1">
                        <input type="submit" name="submit" value="<?php echo _('Search'); ?>" class="align-top">
                        <input type="submit" name="submit" value="<?php echo _('Reset'); ?>" onClick="document.form1.searchstring.value='';" class="align-top">
                    </form>
                    <?php
                    $numrowsplus = $numrows + $offset;
                    if (!$numrowsplus) $offsetplus = 0;
                    ?>

                    <table class="normal">
                        <tr>
                            <th class="fieldnameback fieldname"><?php echo _('Action'); ?></th>
                            <th class="fieldnameback fieldname"><?php echo _('Display'); ?></th>
                            <th class="fieldnameback fieldname"><?php echo _('Folder'); ?></th>
                            <th class="fieldnameback fieldname"><?php echo _('Character set'); ?></th>
                        </tr>

                        <?php
                        if ($numrows) {
                            $actionstr = "";
                            if ($allow_edit) {
                                $actionstr .= "<a href=\"admin_editlanguage.php?languageID=xxx\" title=\"" . _('Edit') . "\" class='smallicon admin-edit-icon'></a>";
                            }
                            if ($allow_delete) {
                                $actionstr .= "<a href='#' onclick=\"if(confirm('" . _('Are you sure you want to delete this language?') . "' )){deleteIt('language',xxx);} return false;\" title=\"" . _('Delete') . "\" class='smallicon admin-delete-icon'></a>";
                        }
                        while ($row = tng_fetch_assoc($result)) {
                            $newactionstr = preg_replace("/xxx/", $row['languageID'], $actionstr);
                            echo "<tr id=\"row_{$row['languageID']}\"><td class='lightback'><div class=\"action-btns2\">$newactionstr</div></td>\n";
                            echo "<td class='lightback'>{$row['display']}&nbsp;</td>\n";
                            echo "<td class='lightback'>{$row['folder']}&nbsp;</td>\n";
                            echo "<td class='lightback'>{$row['charset']}&nbsp;</td></tr>\n";
                        }
                    }
                    ?>
                </table>
                <?php
                if ($numrows) {
                    echo "<div class='w-full class=lg:flex my-6'>";
                    echo getPaginationLocationHtml($offsetplus, $numrowsplus, $totrows);
                    echo getPaginationControlsHtml($totrows, "languages.php?searchstring=$searchstring&amp;offset", $maxsearchresults, 3);
                    echo "</div>";
                } else {
                    echo _('No records exist.');
                }
                tng_free_result($result);
                ?>

                </div>
            </td>
        </tr>

    </table>
<?php echo tng_adminfooter(); ?>
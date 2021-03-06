<?php
include "begin.php";
include "adminlib.php";
include "getlang.php";

include "checklogin.php";

if ($session_charset != "UTF-8") {
    $myfirstname = tng_utf8_decode($myfirstname);
    $mylastname = tng_utf8_decode($mylastname);
}

$allwhere = "gedcom = '$tree'";
if ($personID) $allwhere .= " AND personID = \"$personID\"";

if ($myfirstname) {
    $allwhere .= " AND firstname LIKE \"%" . trim($myfirstname) . "%\"";
}
if ($mylastname) {
    if ($lnprefixes) {
        $allwhere .= " AND CONCAT_WS(' ',lnprefix,lastname) LIKE \"%" . trim($mylastname) . "%\"";
    } else {
        $allwhere .= " AND lastname LIKE \"%" . trim($mylastname) . "%\"";
    }
}

if ($livedefault < 2 && (!$allow_living_db || $assignedtree) && $nonames == 1) {
    $allwhere .= " AND ";
    if ($allow_living_db) {
        if ($assignedbranch) {
            $allwhere .= "(living != 1 OR branch LIKE '%$assignedbranch%')";
        } else {
            $allwhere .= "living != 1";
        }
    } else {
        $allwhere .= "living != 1 AND private != 1";
    }
}

$query = "SELECT personID, lastname, firstname, lnprefix, birthdate, altbirthdate, deathdate, burialdate, prefix, suffix, nameorder, living, private, branch, gedcom FROM $people_table WHERE $allwhere ORDER BY lastname, lnprefix, firstname LIMIT 250";
$result = tng_query($query);

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack ajaxwindow" id="findpersonresdiv">
    <table cellpadding="0">
        <tr>
            <td>
                <h3 class="subhead"><?php echo _('Search Results'); ?></h3>
                <span class="normal">(<?php echo _('click to select'); ?>)</span><br>
            </td>
            <td>&nbsp;&nbsp;&nbsp;</td>
            <td class='align-top'>
                <form action="">
                    <input type="button" value="<?php echo _('Find...'); ?>" onclick="reopenFindForm()">
                </form>
            </td>
        </tr>
    </table>
    <br>
    <table cellspacing="0" cellpadding="2">
        <?php
        while ($row = tng_fetch_assoc($result)) {
            $birthdate = $deathdate = "";
            $row['allow_living'] = determineLivingRights($row);

            if ($row['allow_living']) {
                if ($row['birthdate']) {
                    $birthdate = "" . _('b.') . " {$row['birthdate']}";
                } else {
                    if ($row['altbirthdate']) {
                        $birthdate = "" . _('c.') . " {$row['altbirthdate']}";
                    }
                }
                if ($row['deathdate']) {
                    $deathdate = "" . _('d.') . " {$row['deathdate']}";
                } else {
                    if ($row['burialdate']) {
                        $deathdate = "" . _('bur.') . " {$row['burial']}";
                    }
                }
                if (!$birthdate && $deathdate) {
                    $birthdate = _('No birth info');
                }
            }
            $name = getName($row);
            if ($fieldtype == "select") {
                $namestr = addslashes($name) . "| - {$row['personID']}<br>$birthdate";
            } elseif ($textchange) {
                $birthdatestr = displayDate($birthdate);
                $namestr = addslashes(preg_replace('/\"/', "&#34;", getName($row) . ($birthdatestr ? " (" . displayDate($birthdate) . ")" : "") . " - {$row['personID']}"));
                $nameplusid = $textchange;
            } elseif ($nameplusid == 1) {
                $namestr = addslashes("$name");
            } elseif ($nameplusid) {
                $namestr = addslashes("$name - {$row['personID']}");
            } else {
                $namestr = addslashes("$name");
            }
            $jsnamestr = str_replace("&#34;", "&lsquo;", $namestr);
            $jsnamestr = str_replace("\\\"", "&lsquo;", $namestr);
            echo "<tr>\n";
            echo "<td class='align-top'><span class='normal'><a href='#' onClick=\"return returnName('{$row['personID']}','$jsnamestr','$fieldtype','$nameplusid');\">{$row['personID']}</a></span></td>\n";
            echo "<td><span class='normal'><a href='#' onClick=\"return returnName('{$row['personID']}','$jsnamestr','$fieldtype','$nameplusid');\">$name</a><br>$birthdate $deathdate</span></td>\n";
            echo "</tr>\n";
        }
        tng_free_result($result);
        ?>
    </table>
</div>
<?php

include_once "pwdlib.php";
include_once "globallib.php";
@include_once "mediatypes.php";
@include_once "tngfiletypes.php";
checkMaintenanceMode(1);
if (isset($map['key']) && $map['key']) {
    include_once "googlemaplib.php";
}

$http_user_agent = strtolower($_SERVER["HTTP_USER_AGENT"]);
$newbrowser = preg_match("/msie/", $http_user_agent) && preg_match("/mac/", $http_user_agent) ? 0 : 1;

$isConnected = isConnected();

function tng_adminheader($title, $flags) {
    global $tng_title, $tng_version, $tng_date, $tng_copyright, $session_charset, $sitename, $cms, $templatepath, $text, $sitever, $tngdomain, $tngconfig, $isConnected;

    header("Content-type:text/html;charset=" . $session_charset);
    echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n\n";
    echo "<!-- $tng_title, v.$tng_version ($tng_date), Written by Darrin Lythgoe, $tng_copyright -->\n";
    echo "<html>\n<head>\n";
    $usesitename = $sitename ? stripslashes($sitename) . ": " : "";
    echo "<title>$usesitename" . "TNG Admin ($title)</title>\n";

    if ($session_charset) {
        echo "<meta http-equiv=\"Content-type\" content=\"text/html; charset=$session_charset\">\n";
    }
    if ($sitever == "mobile") {
        echo "<meta name=\"MobileOptimized\" content=\"320\">\n";
        echo "<meta name=\"viewport\" width=\"device-width, initial-scale=1\">\n";
    }

    if (!$tng_version) {
        $tng_version = "12.0.1";
    }
    echo "<link href=\"{$cms['tngpath']}css/bootstrap-reboot.min.css\" rel=\"stylesheet\" type=\"text/css\">\n";
    echo "<link href=\"{$cms['tngpath']}css/genstyle.css?v=$tng_version\" rel=\"stylesheet\" type=\"text/css\">\n";
    if (isset($flags['modmgr'])) {
        echo "<link href=\"{$cms['tngpath']}css/modmanager.css\" rel=\"stylesheet\" type=\"text/css\">\n";
    }
    if ($sitever == "mobile") {
        echo "<link href=\"{$cms['tngpath']}css/tngmobile.css?v=$tng_version\" rel=\"stylesheet\" type=\"text/css\">\n";
    }
    if (isset($flags['tabs'])) {
        echo "<link href=\"{$cms['tngpath']}{$templatepath}css/{$flags['tabs']}\" rel=\"stylesheet\" type=\"text/css\">\n";
    }
    echo "<link href=\"{$cms['tngpath']}{$templatepath}css/templatestyle.css?v=$tng_version\" rel=\"stylesheet\" type=\"text/css\">\n";
    echo "<link href=\"{$cms['tngpath']}{$templatepath}css/mytngstyle.css?v=$tng_version\" rel=\"stylesheet\" type=\"text/css\">\n";
    if ($sitever != "mobile" && $sitever != "tablet") {
        echo "<link rel=\"shortcut icon\" href=\"$tngdomain/{$tngconfig['favicon']}\">\n";
    }
    echo "<meta name=\"robots\" content=\"noindex,nofollow\">\n";
    include "adminmeta.php";
    echo "<script type=\"text/javascript\">\n";
    echo "function toggleAll(flag) {\n";
    echo "for (var i = 0; i < document.form2.elements.length; i++ ) {\n";
    echo "if (document.form2.elements[i].type == \"checkbox\") {\n";
    echo "if (flag)\n";
    echo "document.form2.elements[i].checked = true;\n";
    echo "else\n";
    echo "document.form2.elements[i].checked = false;\n";
    echo "}\n}\n}\n";
    echo "var closeimg = \"img/tng_close.gif\";\n";
    echo "var cmstngpath='';\n";
    echo "var loadingmsg = \"{$text['loading']}\";\n";
    echo "</script>\n";
    if ($isConnected) {
        echo "<script src=\"https://code.jquery.com/jquery-3.3.1.min.js\" integrity=\"sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=\" crossorigin=\"anonymous\"></script>\n";
        echo "<script src=\"https://code.jquery.com/ui/1.12.1/jquery-ui.min.js\" integrity=\"sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=\" crossorigin=\"anonymous\"></script>\n";
    } else {
        echo "<script type=\"text/javascript\">// <![CDATA[\nwindow.jQuery || document.write(\"<script src='{$cms['tngpath']}js/jquery-3.3.1.min.js?v=910'>\\x3C/script>\")\n//]]></script>\n";
        echo "<script type=\"text/javascript\">// <![CDATA[\nwindow.jQuery.ui || document.write(\"<script src='{$cms['tngpath']}js/jquery-ui-1.12.1.min.js?v=910'>\\x3C/script>\")\n//]]></script>\n";
    }
    echo "<script type=\"text/javascript\" src=\"{$cms['tngpath']}js/jquery.ui.touch-punch.min.js\"></script>\n";
    echo "<script type=\"text/javascript\" src=\"{$cms['tngpath']}js/net.js\"></script>\n";

    echo "<script type=\"text/javascript\" src=\"{$cms['tngpath']}js/litbox.js\"></script>\n";
    initMediaTypes();
}

function getNewNumericID($type, $field, $table) {
    global $tree, $tngconfig;

    eval("\$prefix = \$tngconfig['{$type}prefix'];");
    eval("\$suffix = \$tngconfig['{$type}suffix'];");
    if ($prefix) {
        $prefixlen = strlen($prefix) + 1;
        $query = "SELECT MAX(0+SUBSTRING($field" . "ID,$prefixlen)) AS newID FROM $table WHERE gedcom = '$tree' AND $field" . "ID LIKE \"$prefix%\"";
    } else {
        $query = "SELECT MAX(0+SUBSTRING_INDEX($field" . "ID,'$suffix',1)) AS newID FROM $table WHERE gedcom = '$tree'";
    }

    $result = tng_query($query);
    $maxrow = tng_fetch_array($result);
    tng_free_result($result);

    return $maxrow['newID'] ? $maxrow['newID'] + 1 : 0;
}

function findhelp($helpfile) {
    global $mylanguage, $language;

    if (file_exists("$mylanguage/$helpfile")) { // $mylanguage should already include "languages/"
        $helplang = $mylanguage;
    } elseif (file_exists("languages/$language/$helpfile")) {
        $helplang = "languages/$language";
    } else {
        $helplang = "languages/English";
    }

    return $helplang;
}

function doMenu($tabs, $currtab, $innermenu = 0) {
    global $newbrowser, $sitever;

    $tabctr = 0;
    $menu = "<div style=\"width:100%;\">\n";
    $menu .= "<div>\n";
    $menu .= $newbrowser ? "<ul id=\"tngnav\">\n" : "<div id=\"tabs\">\n";

    $choices = "";
    if (is_array($tabs)) {
        foreach ($tabs as $tab) {
            if ($tab[0]) {
                $choices .= doMenuItem($tabctr++, $tab[1], "", $tab[2], $currtab, $tab[3]);
            }
        }
    }
    if ($sitever == "mobile") {
        $menu .= "<li>\n<a class=\"here\">\n<select id=\"tngtabselect\" onchange=\"window.location.href=this.options[this.selectedIndex].value\">\n$choices</select>\n</a>\n</li>\n";
    } else {
        $menu .= $choices;
    }
    $menu .= $newbrowser ? "</ul>\n" : "</div>\n";
    $menu .= "</div>\n";
    $menu .= "<div id=\"adm-innermenu\" class=\"fieldnameback fieldname smaller\">\n";
    $menu .= $innermenu ? $innermenu : "&nbsp;";
    $menu .= "</div>\n";
    $menu .= "</div>\n";

    return $menu;
}

function checkReview($type) {
    global $people_table, $families_table, $temp_events_table, $assignedbranch, $assignedtree, $admtext;

    if ($type == "I") {
        $revwhere = "$people_table.personID = $temp_events_table.personID AND $people_table.gedcom = $temp_events_table.gedcom AND (type = \"I\" OR type = \"C\")";
        $table = $people_table;
    } else {
        $revwhere = "$families_table.familyID = $temp_events_table.familyID AND $families_table.gedcom = $temp_events_table.gedcom AND type = \"F\"";
        $table = $families_table;
    }
    if ($assignedtree) {
        $revwhere .= " AND $temp_events_table.gedcom = \"$tree\"";
    }
    if ($assignedbranch) {
        $revwhere .= " AND branch LIKE \"%$assignedbranch%\"";
    }
    $revquery = "SELECT count(tempID) AS tcount FROM ($table, $temp_events_table) WHERE $revwhere";
    $revresult = tng_query($revquery) or die ($admtext['cannotexecutequery'] . ": $revquery");
    $revrow = tng_fetch_assoc($revresult);
    tng_free_result($revresult);

    return $revrow['tcount'] ? " *" : "";
}

function deleteNote($noteID, $flag) {
    global $notelinks_table, $xnotes_table;

    $query = "SELECT xnoteID FROM $notelinks_table WHERE ID=\"$noteID\"";
    $result = tng_query($query);
    $nrow = tng_fetch_assoc($result);
    tng_free_result($result);

    $query = "SELECT count(ID) AS xcount FROM $notelinks_table WHERE xnoteID=\"{$nrow['xnoteID']}\"";
    $result = tng_query($query);
    $xrow = tng_fetch_assoc($result);
    tng_free_result($result);

    if ($xrow['xcount'] == 1) {
        $query = "DELETE FROM $xnotes_table WHERE ID=\"{$nrow['xnoteID']}\"";
        $result = tng_query($query);
    }
    if ($flag) {
        $query = "DELETE FROM $notelinks_table WHERE ID=\"$noteID\"";
        $result = tng_query($query);
    }
}

function displayToggle($id, $state, $target, $headline, $subhead, $append = "") {
    global $admtext;

    $rval = "<span class='subhead'><a href=\"#\" onclick=\"return toggleSection('$target','$id');\" class=\"togglehead\" style=\"color:black;\"><img src=\"img/" . ($state ? "tng_collapse.gif" : "tng_expand.gif") . "\" title=\"{$admtext['toggle']}\" alt=\"{$admtext['toggle']}\" width=\"15\" height=\"15\" id=\"$id\">";
    $rval .= "<strong class=\"th-indent\">$headline</strong></a> $append</span><br>\n";
    if ($subhead) {
        $rval .= "<span class=\"normal tsh-indent\"><i>$subhead</i></span><br>\n";
    }

    return $rval;
}

function displayHeadline($headline, $icon, $menu, $message) {
    $rval = "<div class='lightback'>\n<div class=\"pad5\">\n";
    $rval .= "<img src=\"$icon\" width=\"40\" height=\"40\" align=\"left\" title=\"$headline\" alt=\"$headline\" style=\"margin-right:10px;\"><span class=\"plainheader\">$headline</span></div><br>\n";
    if ($message) {
        $rval .= "<p class=\"normal red\">&nbsp;<em>" . urldecode(stripslashes($message)) . "</em></p>\n";
    } else {
        $rval .= "<br>\n";
    }
    $rval .= "$menu\n</div>\n";

    return $rval;
}

function displayListLocation($start, $pagetotal, $grandtotal) {
    global $admtext, $text;

    return "<p>{$admtext['matches']}: " . number_format($start) . " {$text['to']} <span class=\"pagetotal\">" . number_format($pagetotal) . "</span> {$text['of']} <span class=\"restotal\">" . number_format($grandtotal) . "</span>";
}

function showEventRow($datefield, $placefield, $label, $persfamID) {
    global $admtext, $gotmore, $gotnotes, $gotcites, $row, $noclass, $currentform;

    $notesicon = $gotnotes[$label] ? "admin-note-on-icon" : "admin-note-off-icon";
    $citesicon = $gotcites[$label] ? "admin-cite-on-icon" : "admin-cite-off-icon";
    $moreicon = $gotmore[$label] ? "admin-more-on-icon" : "admin-more-off-icon";

    $ldsarray = array("BAPL", "CONL", "INIT", "ENDL", "SLGS", "SLGC");

    if (!isset($currentform)) {
        $currentform = "document.form1";
    }
    $blurAction = ($label == "DEAT" || $label == "BURI") ? " updateLivingBox($currentform,this);" : "";
    $onblur = $blurAction ? " onblur=\"$blurAction\"" : "";

    $short = $noclass ? " style=\"width:100px\"" : " class=\"shortfield\"";
    $long = $noclass ? " style=\"width:270px\"" : " class=\"longfield\"";
    $tr = "<tr>\n";
    $tr .= "<td>" . $admtext[$label] . ":</td>\n";
    $tr .= "<td><input type=\"text\" value=\"" . $row[$datefield] . "\" name=\"$datefield\" onblur=\"checkDate(this);{$blurAction}\" maxlength=\"50\"$short></td>\n";
    $tr .= "<td><input type=\"text\" value=\"" . $row[$placefield] . "\" name=\"$placefield\" {$onblur}id=\"$placefield\"$long></td>\n";
    if (in_array($label, $ldsarray)) {
        $tr .= "<td><a href=\"#\" onclick=\"return openFindPlaceForm('$placefield', 1);\" title=\"{$admtext['find']}\" class=\"smallicon admin-temp-icon\"></a></td>\n";
    } else {
        $tr .= "<td><a href=\"#\" onclick=\"return openFindPlaceForm('$placefield');\" title=\"{$admtext['find']}\" class=\"smallicon admin-find-icon\"></a></td>\n";
    }
    if (isset($gotmore)) {
        $tr .= "<td><a href=\"#\" onclick=\"return showMore('$label','$persfamID');\" title=\"{$admtext['more']}\" id=\"moreicon$label\" class=\"smallicon $moreicon\"></a></td>\n";
    }
    if (isset($gotnotes)) {
        $tr .= "<td><a href=\"#\" onclick=\"return showNotes('$label','$persfamID');\" title=\"{$admtext['notes']}\" id=\"notesicon$label\" class=\"smallicon $notesicon\"></a></td>\n";
    }
    if (isset($gotcites)) {
        $tr .= "<td><a href=\"#\" onclick=\"return showCitations('$label','$persfamID');\" title=\"{$admtext['sources']}\" id=\"citesicon$label\" class=\"smallicon $citesicon\"></a></td>\n";
    }
    $tr .= "</tr>\n";
    return $tr;
}

function cleanID($id) {
    return preg_replace('/[^a-z0-9_-]/', '', strtolower($id));
}

function determineConflict($row, $table) {
    global $currentuser, $tngconfig;

    $editconflict = false;
    $currenttime = time();
    if ($row['edituser'] && $row['edituser'] != $currentuser) {
        if ($tngconfig['edit_timeout'] === "") {
            $tngconfig['edit_timeout'] = 15;
        }
        $expiretime = $row['edittime'] + (intval($tngconfig['edit_timeout']) * 60);

        if ($expiretime > $currenttime) {
            $editconflict = true;
        }
    }

    if (!$editconflict) {
        $query = "UPDATE $table SET edituser = \"$currentuser\", edittime = \"$currenttime\" WHERE ID = \"{$row['ID']}\"";
        $eresult = tng_query($query);
    }

    return $editconflict;
}

function getHasKids($tree, $personID) {
    global $families_table, $children_table;

    $haskids = 0;
    $query = "SELECT familyID FROM $families_table WHERE husband=\"$personID\" AND gedcom='$tree' UNION
		SELECT familyID FROM $families_table WHERE wife=\"$personID\" AND gedcom='$tree'";
    $fresult = @tng_query($query);
    while ($famrow = tng_fetch_assoc($fresult)) {
        $query = "SELECT personID FROM $children_table WHERE familyID=\"{$famrow['familyID']}\" AND gedcom='$tree'";
        $cresult = @tng_query($query);
        $ccount = tng_num_rows($cresult);
        tng_free_result($cresult);
        if ($ccount) {
            $haskids = 1;
            break;
        }
    }
    tng_free_result($fresult);

    return $haskids;
}

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

/**
 * @param $title
 * @param $flags
 */
function tng_adminheader($title, $flags) {
    global $session_charset, $sitename, $templatenum, $tngdomain, $tngconfig, $isConnected;
    $header = "<!-- begin tng_adminheader -->\n";
    header("Content-type:text/html;charset=" . $session_charset);
    $header .= "<!doctype html>\n";
    $header .= "<html lang='en'>\n";
    $header .= "<head>\n";
    $header .= "<meta charset='utf-8'>\n";
    $header .= "<meta name='author' content='Darrin Lythgoe'>\n";
    $header .= "<meta name='viewport' content='width=device-width, initial-scale=1'>\n";
    $header .= "<meta name='robots' content='noindex, nofollow'>\n";
    $usesitename = $sitename ? stripslashes($sitename) . ": " : "";
    $header .= "<title>$usesitename" . "TNG Admin ($title)</title>\n";
    $header .= "<link href='build/styles/style.css' rel='stylesheet'>\n";
    if (is_numeric($templatenum)) $header .= "<link href='build/template{$templatenum}/styles/style.css' rel='stylesheet'>\n";
    $header .= "<link rel='shortcut icon' href='$tngdomain/{$tngconfig['favicon']}'>\n";
    $header .= "<script src='node_modules/jquery/dist/jquery.min.js'></script>\n";
    $header .= "<script src='node_modules/jquery-ui-dist/jquery-ui.min.js'></script>\n";
    $header .= "<script src='node_modules/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js'></script>\n";
    $header .= "<script src='js/net.js'></script>\n";
    $header .= "<script src='js/admin.js'></script>\n";
    $header .= "<script src='js/litbox.js'></script>\n";
    $header .= "<style>#tngnav a, #tabs a {font-size: 11px;}</style>\n";
    if (isset($flags['style'])) $header .= $flags['style'];
    $header .= "<script>
    function toggleAll(flag) {
        for (let i = 0; i < document.form2.elements.length; i++ ) {
            if (document.form2.elements[i].type === 'checkbox') {
                document.form2.elements[i].checked = !!flag;
            }
        }
    }
    const closeimg = 'img/tng_close.gif';
    const loadingMessage = '" . _('Loading...') . "';
    </script>";
    initMediaTypes();
    $header .= "<!-- end tng_adminheader -->\n";
    echo $header;
}

/**
 * @param string $args
 * @return string
 */
function tng_adminlayout($args = "") {
    global $tng_title, $currentuser, $maint, $homepage;
    $output = "<!-- begin tng_adminlayout - $args -->\n";
    $output .= "<body class='m-0 adminbody'$args>\n";
    $output .= "<div class='fixed top-0 w-full m-0 text-base leading-snug topbanner sideback whiteheader'>\n";
    $output .= "<div class='float-left admincorner'>\n";
    $output .= "<a href='http://lythgoes.net/genealogy/software.php' target='_blank'>";
    $output .= "<img src='img/tnglogo.gif' alt='The Next Generation of Genealogy Sitebuilding' width='113' height='50'>";
    $output .= "</a>\n";
    $output .= "</div>\n";
    $output .= "<div class='pl-3 overflow-hidden'>\n";
    $output .= "<h1 class='my-1 whitespace-no-wrap'>$tng_title</h1>\n";
    $output .= "<span class='whitespace-no-wrap whitetext normal'>\n";
    $output .= "<a href='admin.php' class='lightlink'>" . _('Admin Home') . "</a>\n";
    $output .= "<a href='$homepage' class='lightlink'>" . _('Public Home') . "</a>\n";
    if ($maint) {
        $output .= "&nbsp;|&nbsp; <strong><span class='yellow'>" . _('Maintenance Mode is ON') . "</span></strong>\n";
    }
    $output .= "<a href='logout.php?admin_login=1' class='float-right lightlink' target='_parent'>" . _('Logout') . "&nbsp; (<strong>$currentuser</strong>)</a>\n";
    $output .= "</span>\n";
    $output .= "</div>\n";
    $output .= "</div>\n";
    $output .= "<div>\n";
    $leftoffset = $mainoffset = "";
    if (isset($_SESSION['tng_menuhidden']) && $_SESSION['tng_menuhidden'] == "on") {
        $leftoffset = " style='left: -135px'";
        $mainoffset = " style='padding-left: 26px'";
    }
    $output .= "<div id='leftmenu' class='fixed h-full overflow-auto leading-tight leftmenu sideback normal'$leftoffset>\n";
    include "admin_leftmenu.php";
    $output .= "</div>\n";
    $output .= "<div id='maincontent' class='mainback'$mainoffset>\n";
    $output .= "<!-- end tng_adminlayout -->\n";
    return $output;
}

/** Gets html to finish. Besides any footer, html will include closing 2 divs, body and html.
 * @return string
 */
function tng_adminfooter() {
    global $admtext, $allow_admin;
    $html = "<!-- begin tng_adminfooter -->\n";
    $html .= "</div>\n";
    $html .= "</div>\n";
    $helplang = findhelp("index_help.php");
    $html .= "<nav class='flex-wrap items-center justify-around p-6 text-center lg:flex'>\n";
    if ($allow_admin) {
        $html .= "<a href='adminshowlog.php' class='block mt-4 mr-4 text-indigo-200 lg:inline-block lg:mt-0 hover:text-white' target='main'>" . _('Admin Log') . "</a>\n";
    }
    $html .= "<a href='#' onclick=\"return openHelp('{$helplang}/index_help.php');\" class='block mt-4 mr-4 text-indigo-200 lg:inline-block lg:mt-0 hover:text-white'>" . _('Getting Started') . "</a>\n";
    $html .= "<a href='https://tng.lythgoes.net/wiki' class='block mt-4 mr-4 text-indigo-200 lg:inline-block lg:mt-0 hover:text-white' target='_blank'>TNG Wiki</a>\n";
    $html .= "<a href='https://tng.community' class='block mt-4 mr-4 text-indigo-200 lg:inline-block lg:mt-0 hover:text-white' target='_blank'>TNG Forum</a>\n";
    $html .= "</nav>\n";
    $html .= "</body>\n";
    $html .= "</html>\n";
    $html .= "<!-- end tng_adminfooter -->\n";
    return $html;
}

/**
 * @param $type
 * @param $field
 * @param $table
 * @return int|mixed
 */
function getNewNumericID($type, $field, $table) {
    global $tree, $tngconfig;

    eval("\$prefix = \$tngconfig['{$type}prefix'];");
    eval("\$suffix = \$tngconfig['{$type}suffix'];");
    if ($prefix) {
        $prefixlen = strlen($prefix) + 1;
        $query = "SELECT MAX(0+SUBSTRING($field" . "ID,$prefixlen)) AS newID FROM $table WHERE gedcom = '$tree' AND $field" . "ID LIKE '$prefix%'";
    } else {
        $query = "SELECT MAX(0+SUBSTRING_INDEX($field" . "ID,'$suffix',1)) AS newID FROM $table WHERE gedcom = '$tree'";
    }

    $result = tng_query($query);
    $maxrow = tng_fetch_array($result);
    tng_free_result($result);

    return $maxrow['newID'] ? $maxrow['newID'] + 1 : 0;
}

/**
 * @param $helpfile
 * @return string
 */
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

/**
 * @param $tabs
 * @param $currtab
 * @param int $innermenu
 * @return string
 */
function doMenu($tabs, $currtab, $innermenu = 0) {
    global $newbrowser;

    $tabctr = 0;
    $menu = "<div style='width:100%;'>\n";
    $menu .= "<div>\n";
    $menu .= $newbrowser ? "<ul id='tngnav'>\n" : "<div id='tabs'>\n";

    $choices = "";
    if (is_array($tabs)) {
        foreach ($tabs as $tab) {
            if ($tab[0]) {
                $choices .= doMenuItem($tabctr++, $tab[1], "", $tab[2], $currtab, $tab[3]);
            }
        }
    }
    $menu .= $choices;
    $menu .= $newbrowser ? "</ul>\n" : "</div>\n";
    $menu .= "</div>\n";
    $menu .= "<div id='adm-innermenu' class='fieldnameback fieldname smaller'>\n";
    $menu .= $innermenu ? $innermenu : "&nbsp;";
    $menu .= "</div>\n";
    $menu .= "</div>\n";

    return $menu;
}

/**
 * @param $type
 * @return string
 */
function checkReview($type) {
    global $people_table, $families_table, $temp_events_table, $assignedbranch, $assignedtree, $admtext;

    if ($type == "I") {
        $revwhere = "$people_table.personID = $temp_events_table.personID AND $people_table.gedcom = $temp_events_table.gedcom AND (type = 'I' OR type = 'C')";
        $table = $people_table;
    } else {
        $revwhere = "$families_table.familyID = $temp_events_table.familyID AND $families_table.gedcom = $temp_events_table.gedcom AND type = 'F'";
        $table = $families_table;
    }
    if ($assignedtree) {
        $revwhere .= " AND $temp_events_table.gedcom = '$tree'";
    }
    if ($assignedbranch) {
        $revwhere .= " AND branch LIKE '%$assignedbranch%'";
    }
    $revquery = "SELECT count(tempID) AS tcount FROM ($table, $temp_events_table) WHERE $revwhere";
    $revresult = tng_query($revquery) or die (_('Cannot execute query') . ": $revquery");
    $revrow = tng_fetch_assoc($revresult);
    tng_free_result($revresult);

    return $revrow['tcount'] ? " *" : "";
}

/**
 * @param $noteID
 * @param $flag
 */
function deleteNote($noteID, $flag) {
    global $notelinks_table, $xnotes_table;

    $query = "SELECT xnoteID FROM $notelinks_table WHERE ID='$noteID'";
    $result = tng_query($query);
    $nrow = tng_fetch_assoc($result);
    tng_free_result($result);
    $query = "SELECT COUNT(ID) AS xcount FROM $notelinks_table WHERE xnoteID='{$nrow['xnoteID']}'";
    $result = tng_query($query);
    $xrow = tng_fetch_assoc($result);
    tng_free_result($result);

    if ($xrow['xcount'] == 1) {
        $query = "DELETE FROM $xnotes_table WHERE ID='{$nrow['xnoteID']}'";
        tng_query($query);
    }
    if ($flag) {
        $query = "DELETE FROM $notelinks_table WHERE ID='$noteID'";
        tng_query($query);
    }
}

/**
 * @param $id
 * @param $state
 * @param $target
 * @param $headline
 * @param $subhead
 * @param string $append
 * @return string
 */
function displayToggle($id, $state, $target, $headline, $subhead, $append = "") {
    global $admtext;
    $rval = "<span class='subhead'><a href='#' onclick=\"return toggleSection('$target','$id');\" class='no-underline togglehead' style='color:#000;'>";
    $rval .= "<img src='img/" . ($state ? "tng_collapse.gif" : "tng_expand.gif") . "' alt='" . _('toggle display') . "' id='$id' class='inline-block' title='" . _('toggle display') . "'>";
    $rval .= "<strong class='ml-1'>$headline</strong></a> $append</span><br>\n";
    if ($subhead) {
        $rval .= "<span class='normal tsh-indent'><em>$subhead</em></span><br>\n";
    }
    return $rval;
}

/**
 * Returns html which will display an image with associated header, optional status message in red and menu
 * @param $headline
 * @param $icon
 * @param $menu
 * @param $message
 * @return string html text with headline
 */
function displayHeadline($headline, $icon, $menu, $message) {
    $rval = "<div class='lightback'>\n";
    $rval .= "<div class='flex items-center p-1 mb-4'>\n";
    $rval .= "<img src='$icon' alt='$headline' class='mr-3' title='$headline'>";
    $rval .= "<span class='plainheader'>$headline</span>\n";
    $rval .= "</div>\n";
    if ($message) $rval .= "<p class='ml-4 italic normal red'>" . urldecode(stripslashes($message)) . "</p>\n";

    $rval .= "$menu\n";
    $rval .= "</div>\n";

    return $rval;
}

/**
 * @param $datefield
 * @param $placefield
 * @param $label
 * @param $persfamID
 * @return string
 */
function showEventRow($datefield, $placefield, $label, $persfamID) {
    global $admtext, $gotmore, $gotnotes, $gotcites, $row, $noclass, $currentform;

    $notesicon = $gotnotes[$label] ? "admin-note-on-icon" : "admin-note-off-icon";
    $citesicon = $gotcites[$label] ? "admin-cite-on-icon" : "admin-cite-off-icon";
    $moreicon = $gotmore[$label] ? "admin-more-on-icon" : "admin-more-off-icon";

    $ldsarray = ["BAPL", "CONL", "INIT", "ENDL", "SLGS", "SLGC"];

    if (!isset($currentform)) $currentform = "document.form1";
    $blurAction = ($label == "DEAT" || $label == "BURI") ? " updateLivingBox($currentform,this);" : "";
    $onblur = $blurAction ? " onblur='$blurAction'" : "";

    $short = $noclass ? " style='width:100px'" : " class='w-32'";
    $long = $noclass ? " style='width:270px'" : " class='longfield'";
    $tr = "<tr>\n";
    $tr .= "<td>" . $admtext[$label] . ":</td>\n";
    $tr .= "<td><input type='text' value='" . $row[$datefield] . "' name='$datefield' onblur='checkDate(this);{$blurAction}' maxlength='50'$short></td>\n";
    $tr .= "<td><input type='text' value='" . $row[$placefield] . "' name='$placefield' {$onblur}id='$placefield'$long></td>\n";
    if (in_array($label, $ldsarray)) {
        $tr .= "<td><a href='#' onclick=\"return openFindPlaceForm('$placefield', 1);\" title=\"" . _('Find...') . "\" class='smallicon admin-temp-icon'></a></td>\n";
    } else {
        $tr .= "<td><a href='#' onclick=\"return openFindPlaceForm('$placefield');\" title=\"" . _('Find...') . "\" class='smallicon admin-find-icon'></a></td>\n";
    }
    if (isset($gotmore)) {
        $tr .= "<td><a href='#' onclick=\"return showMore('$label', '$persfamID');\" title=\"" . _('More') . "\" id='moreicon$label' class='smallicon $moreicon'></a></td>\n";
    }
    if (isset($gotnotes)) {
        $tr .= "<td><a href='#' onclick=\"return showNotes('$label', '$persfamID');\" title=\"" . _('Notes') . "\" id='notesicon$label' class='smallicon $notesicon'></a></td>\n";
    }
    if (isset($gotcites)) {
        $tr .= "<td><a href='#' onclick=\"return showCitations('$label', '$persfamID');\" title=\"" . _('Sources') . "\" id='citesicon$label' class='smallicon $citesicon'></a></td>\n";
    }
    $tr .= "</tr>\n";
    return $tr;
}

/**
 * @param $id
 * @return string|string[]|null
 */
function cleanID($id) {
    return preg_replace('/[^a-z0-9_-]/', '', strtolower($id));
}

/**
 * @param $row
 * @param $table
 * @return bool
 */
function determineConflict($row, $table) {
    global $currentuser, $tngconfig;

    $editconflict = false;
    $currenttime = time();
    if ($row['edituser'] && $row['edituser'] != $currentuser) {
        if ($tngconfig['edit_timeout'] === "") {
            $tngconfig['edit_timeout'] = 15;
        }
        $expiretime = $row['edittime'] + (intval($tngconfig['edit_timeout']) * 60);

        if ($expiretime > $currenttime) $editconflict = true;

    }

    if (!$editconflict) {
        $query = "UPDATE $table SET edituser = '$currentuser', edittime = '$currenttime' WHERE ID = '{$row['ID']}'";
        tng_query($query);
    }

    return $editconflict;
}

/**
 * @param $tree
 * @param $personID
 * @return int
 */
function getHasKids($tree, $personID) {
    global $families_table, $children_table;

    $haskids = 0;
    $query = "SELECT familyID FROM $families_table WHERE husband='$personID' AND gedcom='$tree' UNION
		SELECT familyID FROM $families_table WHERE wife='$personID' AND gedcom='$tree'";
    $fresult = @tng_query($query);
    while ($famrow = tng_fetch_assoc($fresult)) {
        $query = "SELECT personID FROM $children_table WHERE familyID='{$famrow['familyID']}' AND gedcom='$tree'";
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

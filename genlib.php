<?php

include_once "pwdlib.php";
include_once "globallib.php";
@include_once "mediatypes.php";
@include_once "tngfiletypes.php";
include_once "version.php";
checkMaintenanceMode(0);
if (!empty($needMap)) {
    include "config/mapconfig.php";
    $mapkeystr = $map['key'] && $map['key'] != "1" ? "&amp;key=" . $map['key'] : "";
    if ($map['key']) include_once "googlemaplib.php";

}
$flags = [];
@include "tngrobots.php";
require_once "core/html/HeadElementPublic.php";

$isConnected = isConnected();

$htmldocs = ["HTML", "PHP", "HTM"];
$http_user_agent = strtolower($_SERVER["HTTP_USER_AGENT"]);
$newbrowser = preg_match("/msie/", $http_user_agent) && preg_match("/mac/", $http_user_agent) ? 0 : 1;
$gotlastpage = false;
$flags['error'] = $error;

if (empty($tree)) $tree = "";

if ($requirelogin && $treerestrict && $_SESSION['assignedtree']) {
    if (!$tree) {
        $tree = $_SESSION['assignedtree'];
    } elseif ($tree != $_SESSION['assignedtree']) {
        header("Location:$homepage");
        exit;
    }
}
$orgtree = $tree;
if (!$tree && $defaulttree) {
    $tree = $defaulttree;
} elseif ($tree == "-x--all--x-") {
    $tree = "";
}

/**
 * @param $headElement
 * @param array $flags 'noicons' 'noheader'
 */
function standardHeaderVariants($headElement, array $flags): void {
    global $templatepath;
    global $tngprint;
    $title = $headElement->getTitle();
    $icons = $headElement->getIcons();
    if (!$tngprint && (!isset($flags['noheader']) || !$flags['noheader'])) {
        echo "<!-- begin '{$templatepath}topmenu.php' content -->\n";
        include "{$templatepath}topmenu.php";
        echo "<!-- end '{$templatepath}topmenu.php' content -->\n";
    }
    if ((!isset($flags['noicons']) || !$flags['noicons'])) {
        $icons = tng_icons(1, $title);
    }
    echo $icons;
}

/**
 * @param $title
 * @param $flags
 */
function tng_header($title, $flags) {
    global $tngconfig, $text;
    initMediaTypes();
    $headElement = new HeadElementPublic($title, $flags);
    echo $headElement->getHtml();
    standardHeaderVariants($headElement, $flags);
    //    echo "<body id='bodytop' class='" . pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME) . "'>\n";
    if ($tngconfig['maint']) {
        echo "<span class='fieldnameback yellow p-1'><strong>{$text['mainton']}</strong></span><br><br>\n";
    }
}

/**
 * @param bool[] $flags
 */
function tng_footer($flags = ['basicfooter' => true]) {
    global $tngprint, $map, $text, $dbowner, $tngdomain, $sitename, $templatepath, $tngconfig;
    $needtherest = true;
    if ($tngprint) {
        $printfooter = $sitename;
        if ($dbowner) {
            if ($printfooter) $printfooter .= " - ";
            if ($tngconfig['dataprotect'] && strpos($_SERVER['REQUEST_URI'], "/data_protection_policy.php") === false) {
                $data_protection_link = " | <a href='data_protection_policy.php' class='footer' title='{$text['dataprotect']}' target='_blank'>{$text['dataprotect']}</a>.\n";
            } else {
                $data_protection_link = "";
            }
            $printfooter .= $text['maintby'] . " <a href='suggest.php' class='footer' title='{$text['contactus']}'>$dbowner</a>.{$data_protection_link}";
        }
        echo "<p class='smaller'>" . $printfooter . "<br>\n$tngdomain</p>";
    } else {
        if (isset($flags['basicfooter']) && $flags['basicfooter']) {
            echo tng_basicfooter($flags);
            $needtherest = false;
        } else {
            echo "<!-- begin '{$templatepath}footer.php' content -->\n";
            include "{$templatepath}footer.php";
            echo "<!-- end '{$templatepath}footer.php' content -->\n";
        }
    }
    if ($needtherest) {
        if (isset($flags['more'])) echo $flags['more'];

        if (!$tngprint) echo "<script src='js/litbox.js'></script>\n";

        if (!empty($map['key']) && !empty($map['pins'])) {
            tng_map_pins();
        }

        if (!isset($flags['noend']) || !$flags['noend']) {
            include "end.php";
        }
    }
}

/**
 * @param $flags
 * @return string
 */
function tng_basicfooter($flags) {
    global $sitever;
    $footer = "";
    include "stdsitecredit.php";
    $footer .= $sitecredit;
    if (isset($flags['imgprev'])) {
        ?>
        <script>
            jQuery(document).ready(function () {
                let $previewSelection = jQuery('.media-preview');
                $previewSelection.on('mouseover touchstart', function (e) {
                    e.preventDefault();
                    var items = this.id.match(/img-(\d+)-(\d+)-(.*)/);
                    var key = items[2] && items[2] !== "0" ? items[1] + "_" + items[2] : items[1];
                    if (jQuery('#prev' + key).css('display') === "none")
                        showPreview(items[1], items[2], items[3], key, '<?php echo $sitever; ?>');
                    else
                        closePreview(key);
                });
                $previewSelection.on('mouseout', function (e) {
                    var items = this.id.match(/img-(\d+)-(\d+)-(.*)/);
                    var key = items[2] && items[2] !== "0" ? items[1] + "_" + items[2] : items[1];
                    closePreview(key);
                });
                jQuery(document).on('click touchstart', '.prev-close img', function (e) {
                    var items;
                    items = this.id.match(/close-(\d+)_(\d+)/);
                    if (!items)
                        items = this.id.match(/close-(\d+)/);
                    var key = items[2] && items[2] !== "0" ? items[1] + "_" + items[2] : items[1];
                    closePreview(key);
                });
            });
        </script>
        <?php
    }
    return $footer;
}

/**
 * @param $medialink
 * @return string
 */
function getSmallPhoto($medialink) {
    global $rootpath, $mediapath, $mediatypes_assoc, $thumbmaxw, $thumbmaxh;
    global $mediatypes_thumbs, $tnggallery, $tngconfig;

    if (!$thumbmaxh) $thumbmaxh = 100;
    if (!$thumbmaxw) $thumbmaxw = 80;

    $mediatypeID = $medialink['mediatypeID'];
    $usefolder = $medialink['usecollfolder'] ? $mediatypes_assoc[$mediatypeID] : $mediapath;

    $treestr = !empty($tngconfig['mediatrees']) && $medialink['gedcom'] ? $medialink['gedcom'] . "/" : "";
    if ($medialink['allow_living'] && $medialink['thumbpath'] && file_exists("$rootpath$usefolder/$treestr" . $medialink['thumbpath'])) {
        $thumb = "$usefolder/" . str_replace("%2F", "/", rawurlencode($medialink['thumbpath']));
        $photoinfo = @GetImageSize("$rootpath$usefolder/$treestr" . $medialink['thumbpath']);

        if ($photoinfo[0] <= $thumbmaxw && $photoinfo[1] <= $thumbmaxh) {
            $photohtouse = $photoinfo[1];
            $photowtouse = $photoinfo[0];
        } else {
            if ($photoinfo[0] > $photoinfo[1]) {
                $photowtouse = $thumbmaxw;
                $photohtouse = intval($thumbmaxw * $photoinfo[1] / $photoinfo[0]);
            } else {
                $photohtouse = $thumbmaxh;
                $photowtouse = intval($thumbmaxh * $photoinfo[0] / $photoinfo[1]);
            }
        }
        $dimensions = " height='$photohtouse'";
        $class = " class='thumb'";
    } else {
        $thumb = "img/" . $mediatypes_thumbs[$mediatypeID];
        $dimensions = $class = "";
    }
    if (!isset($medialink['description'])) $medialink['description'] = '';
    $altmsg = $medialink['allow_living'] ? str_replace("\"", "'", $medialink['description']) : "";
    $cleantitle = $tnggallery ? $altmsg : "";
    return "<img src='$thumb' $dimensions alt='$altmsg' title=\"$cleantitle\"$class>";
}

/**
 * @param $photostr
 * @param $namestr
 * @param $years
 * @return string
 */
function tng_DrawHeading($photostr, $namestr, $years) {
    global $tngconfig;
    if ($photostr) {
        $outputstr = "<div style=\"float: left; padding-right: 5px;\">$photostr</div>\n";
        $outputstr .= "<h1 class=\"header fn\" id=\"nameheader\">$namestr</h1>\n";
        $outputstr .= "<span class='normal'>$years</span>\n";
    } else {
        $outputstr = "<h1 class=\"header fn\" id=\"nameheader\">$namestr</h1>\n";
        if ($years) {
            $outputstr .= "<span class='normal'>$years</span><br>\n";
        }
    }
    $outputstr .= "<br style=\"clear: both;\"><br>\n";
    if (empty($tngconfig['webmatches'])) {
        echo "<div id=\"mhmatches\"></div>\n";
    }

    return $outputstr;
}

// UnusedCode function getSurnameOnly
/**
 * @param $row
 * @return mixed|string
 */
function getSurnameOnly($row) {
    global $text, $admtext, $tngconfig;

    $nonames = showNames($row);
    if ($row['allow_living'] || $nonames != 1) {
        $namestr = trim($row['lnprefix'] . " " . $row['lastname']);
        if ($tngconfig['ucsurnames']) $namestr = tng_strtoupper($namestr);

    } elseif ($row['private']) {
        $namestr = $admtext['text_private'];
    } else {
        $namestr = $text['living'];
    }

    return $namestr;
}

/**
 * @param $row
 * @return mixed|string
 */
function getFirstNameOnly($row) {
    global $text, $admtext;

    $nonames = showNames($row);
    if (($row['allow_living'] && $row['allow_private']) || !$nonames) {
        $namestr = strtok($row['firstname'], " ");
    } elseif ($nonames == 2) {
        $namestr = initials($row['firstname']);
    } elseif ($row['private']) {
        $namestr = $admtext['text_private'];
    } else {
        $namestr = $text['living'];
    }

    return $namestr;
}

/**
 * @param $enttype
 * @param $currpage
 * @param $entityID
 * @param $innermenu
 * @return string
 */
function tng_menu($enttype, $currpage, $entityID, $innermenu) {
    global $tree, $text, $disallowgedcreate, $allow_edit;
    global $rightbranch, $allow_ged, $emailaddr, $newbrowser, $tngconfig, $tngprint;

    $nexttab = 0;
    if (!$tngprint) {
        $menu = "<div id='tngmenu'>\n";
        $menu .= $newbrowser ? "<ul id='tngnav'>\n" : "<div id='tabs'>\n";
        $choices = "";
        if ($enttype == "I") {
            $choices .= doMenuItem($nexttab++, "getperson.php?personID=$entityID&amp;tree=$tree", "ind", $text['indinfo'], $currpage, "person");
            $choices .= doMenuItem($nexttab++, "familychart.php?personID=$entityID&amp;tree=$tree", "fam", $text['family'], $currpage, "familychart");
            $choices .= doMenuItem($nexttab++, "pedigree.php?personID=$entityID&amp;tree=$tree", "ped", $text['ancestors'], $currpage, "pedigree");
            $choices .= doMenuItem($nexttab++, "descend.php?personID=$entityID&amp;tree=$tree", "desc", $text['descendants'], $currpage, "descend");
            $choices .= doMenuItem($nexttab++, "relateform.php?primaryID=$entityID&amp;tree=$tree", "rel", $text['relationship'], $currpage, "relate");
            $choices .= doMenuItem($nexttab++, "timeline.php?primaryID=$entityID&amp;tree=$tree", "time", $text['timeline'], $currpage, "timeline");
            if (!$disallowgedcreate || ($allow_ged && $rightbranch)) {
                $choices .= doMenuItem($nexttab++, "gedform.php?personID=$entityID&amp;tree=$tree", "ged", $text['extractgedcom'], $currpage, "gedcom");
            }
            $editstr = "admin_editperson.php?person";
        } elseif ($enttype == "F") {
            $choices .= doMenuItem($nexttab++, "familychart.php?familyID=$entityID&amp;tree=$tree", "fam", $text['familychart'], $currpage, "familychart");
            $choices .= doMenuItem($nexttab++, "familygroup.php?familyID=$entityID&amp;tree=$tree", "rel", $text['groupsheet'], $currpage, "family");
            $editstr = "admin_editfamily.php?family";
        } elseif ($enttype == "S") {
            $choices .= doMenuItem($nexttab++, "showsource.php?sourceID=$entityID&amp;tree=$tree", "ged", $text['source'], $currpage, "source");
            $editstr = "admin_editsource.php?source";
        } elseif ($enttype == "R") {
            $choices .= doMenuItem($nexttab++, "showrepo.php?repoID=$entityID&amp;tree=$tree", "ged", $text['repository'], $currpage, "repo");
            $editstr = "admin_editrepo.php?repo";
        } elseif ($enttype == "D") {
            if (!$_SESSION["ttree"]) $_SESSION["ttree"] = "-x--all--x-";

            $browse_dna_tests_url = "browse_dna_tests.php?tree=" . $_SESSION["ttree"] . "&amp;test_type=" . $_SESSION["ttype"] . "&amp;test_group=" . $_SESSION["tgroup"] . "&amp;testsearch=" . $_SESSION["tsearch"];
            $choices .= doMenuItem($nexttab++, "$browse_dna_tests_url", "ged", $text['all_dna_tests'], $currpage, "alldna");
            $choices .= doMenuItem($nexttab++, "show_dna_test.php?testID=$entityID", "ged", $text['dna_test'], $currpage, "dna");
            $editstr = "admin_edit_dna_test.php?test";
        } elseif ($enttype == "L") {
            $treestr = $tngconfig['places1tree'] ? "" : "&amp;tree=$tree";
            $choices .= doMenuItem($nexttab++, "placesearch.php?psearch=$entityID$treestr", "place", $text['place'], $currpage, "place");
            $editstr = "admin_editplace.php?";
            $entityID = urlencode($entityID);
        }
        if ($allow_edit && $rightbranch) {
            $choices .= doMenuItem($nexttab, "$editstr" . "ID=$entityID&amp;tree=$tree&amp;cw=1\" target=\"_blank", "sugg", $text['edit'], $currpage, "");
        } elseif ($emailaddr) {
            $choices .= doMenuItem($nexttab, "suggest.php?enttype=$enttype&amp;ID=$entityID&amp;tree=$tree", "sugg", $text['suggest'], $currpage, "suggest");
        }
        $menu .= $choices;
        $menu .= $newbrowser ? "</ul>\n" : "</div>\n";
        $menu .= "</div>\n";
        $menu .= "<div id='pub-innermenu' class='fieldnameback fieldname smaller rounded'>\n";
        $menu .= $innermenu;
        $menu .= "</div><br>\n";

    } else {
        $menu = "";
    }
    return $menu;
}

/**
 * @param $options
 * @return string
 */
function tng_smallIcon($options) {
    $target = "";

    $url = isset($options['url']) ? $options['url'] : "#";
    $onclick = isset($options['onclick']) ? "onclick=\"{$options['onclick']}\"" : "";
    $targetloc = $target ? "target=\"$target\"" : "";
    $class = isset($options['class']) ? $options['class'] : "tngsmallicon";
    $rel = isset($options['rel']) ? "rel=\"{$options['rel']}\"" : "";
    return " <a href=\"$url\" $onclick $targetloc $rel title=\"{$options['label']}\" class=\"$class\" id=\"{$options['id']}-smicon\">{$options['label']}</a>\n";
}

/**
 * @return string
 */
function tng_getLeftIcons() {
    global $tngconfig, $text, $homepage, $currentuser, $allow_profile;

    if (!isset($tngconfig['menucount'])) $tngconfig['menucount'] = 0;

    $left_icons = "";
    if (empty($tngconfig['showhome'])) {
        $left_icons .= tng_smallIcon(['url' => $homepage, 'label' => $text['homepage'], 'id' => "home"]);
        $tngconfig['menucount']++;
    }
    if (empty($tngconfig['showsearch'])) {
        $params = ['url' => "searchform.php", 'label' => $text['search'], 'id' => "search"];
        if (empty($tngconfig['searchchoice'])) {
            $params['onclick'] = "return openSearch();";
        }
        $left_icons .= tng_smallIcon($params);
        $tngconfig['menucount']++;
    }
    $profilelink = $userparen = "";
    if ($currentuser) {
        if ($allow_profile) {
            $label = "({$text['editprofile']}: $currentuser)";
            $profilelink = tng_smallIcon(['label' => $label, 'class' => "tngsmallicon3", 'id' => "profile",
                'onclick' => "tnglitbox = new LITBox('ajx_editprofile.php?p=" . urlencode("") . "', {width: 580, height: 750}); return false"]);
            $tngconfig['menucount']++;
        } else {
            $userparen = " ($currentuser)";
        }
    }
    if (empty($tngconfig['showlogin'])) {
        if ($currentuser) {
            $left_icons .= tng_smallIcon(['url' => "logout.php?session=" . session_name(), 'label' => $text['logout'] . $userparen, 'id' => "log"]);
        } else {
            $left_icons .= tng_smallIcon(['label' => $text['login'], 'id' => "log", 'onclick' => "return openLogin('ajx_login.php?p=" . urlencode("") . "');"]);
        }
        $tngconfig['menucount']++;
    }
    $left_icons .= $profilelink;

    return $left_icons;
}

/**
 * @return string
 */
function tng_getRightIcons(): string {
    global $text, $tngconfig, $gotlastpage, $isConnected;

    $right_icons = "";
    if (!empty($tngconfig['showshare']) && $isConnected) {
        $right_icons .= tng_smallIcon(['label' => $text['share'], 'id' => "share", 'onclick' => "jQuery('#shareicons').toggle(200); if(!share) { jQuery('#share-smicon').html('{$text['hide']}'); share=1;} else { jQuery('#share-smicon').html('{$text['share']}'); share=0; }; return false;"]);
    }
    if (empty($tngconfig['showprint'])) {
        $print_url = getScriptName();
        if (preg_match("/\?/", $print_url)) {
            $print_url .= "&amp;tngprint=1";
        } else {
            $print_url .= "?tngprint=1";
        }
        $right_icons .= tng_smallIcon(['label' => $text['tngprint'], 'id' => "print", 'rel' => "nofollow", 'onclick' => "newwindow=window.open('$print_url','tngprint','width=850,height=600,status=no,resizable=yes,scrollbars=yes'); newwindow.focus(); return false;"]);
    }

    if (empty($tngconfig['showbmarks']) && $gotlastpage) {
        $right_icons .= tng_smallIcon(['label' => $text['bookmark'], 'id' => "bmk", 'onclick' => "tnglitbox = new LITBox('ajx_addbookmark.php?p=" . urlencode("") . "', {width:350, height:120}); return false;"]);
        $tngconfig['menucount']++;
    }

    return $right_icons;
}

/**
 * @return string
 */
function tng_getFindMenu() {
    global $tngconfig, $time_offset;

    $menu = tngddrow("surnames.php", "surnames-icon", "", "surnames");
    $menu .= tngddrow("firstnames.php", "firstnames-icon", "", "firstnames");
    $menu .= tngddrow("searchform.php", "search-icon", "", "searchnames");
    $menu .= tngddrow("famsearchform.php", "fsearch-icon", "", "searchfams");
    $menu .= tngddrow("searchsite.php", "searchsite-icon", "", "searchsitemenu");
    $menu .= tngddrow("places.php", "places-icon", "", "places");
    $menu .= tngddrow("anniversaries.php", "dates-icon", "", "dates");
    $tngmonth = date("m", time() + (3600 * intval($time_offset)));
    $menu .= tngddrow("calendar.php?m=$tngmonth", "calendar-icon", "", "calendar");
    $menu .= tngddrow("cemeteries.php", "cemeteries-icon", "", "cemeteries");
    $menu .= tngddrow("bookmarks.php", "bookmarks-icon", "", "bookmarks");

    $tngconfig['menucount'] += 8;

    global $findmenulinks;
    if (isset($findmenulinks)) $menu .= custom_links($findmenulinks);


    return $menu;
}

/**
 * @return string
 */
function tng_getMediaMenu() {
    global $mediatypes, $tngconfig;

    $menu = "";
    foreach ($mediatypes as $mediatype) {
        if (!$mediatype['disabled']) {
            $menu .= tngddrow("browsemedia.php?mediatypeID=" . $mediatype['ID'], $mediatype['ID'] . "-icon", $mediatype['icon'], $mediatype['display'], true);
            $tngconfig['menucount']++;
        }
    }
    $menu .= tngddrow("browsealbums.php", "albums-icon", "", "albums");
    $menu .= tngddrow("browsemedia.php", "media-icon", "", "allmedia");
    $tngconfig['menucount'] += 2;

    global $mediamenulinks;
    if (isset($mediamenulinks)) $menu .= custom_links($mediamenulinks);


    return $menu;
}

/**
 * @param $title
 * @return string
 */
function tng_getInfoMenu($title) {
    global $allow_admin, $tngconfig;

    $menu = tngddrow("whatsnew.php", "whatsnew-icon", "", "whatsnew");
    $menu .= tngddrow("mostwanted.php", "mw-icon", "", "mostwanted");
    $menu .= tngddrow("reports.php", "reports-icon", "", "reports");
    $menu .= tngddrow("statistics.php", "stats-icon", "", "databasestatistics");
    $menu .= tngddrow("browsetrees.php", "trees-icon", "", "trees");
    $menu .= tngddrow("browsebranches.php", "branches-icon", "", "branches");
    $menu .= tngddrow("browsenotes.php", "notes-icon", "", "notes");
    $menu .= tngddrow("browsesources.php", "sources-icon", "", "sources");
    $menu .= tngddrow("browserepos.php", "repos-icon", "", "repositories");
    if (empty($tngconfig['hidedna'])) {
        $menu .= tngddrow("browse_dna_tests.php", "dna-icon", "", "dna_tests");
    }
    if ($allow_admin) {
        $menu .= tngddrow("admin.php", "admin-icon", "", "administration");
        $menu .= tngddrow("showlog.php", "unlock-icon", "", "mnushowlog");
        $tngconfig['menucount'] += 2;
    }
    $menu .= tngddrow("suggest.php?page=" . urlencode(str_replace("?", "", $title)), "contact-icon", "", "contactus");
    $tngconfig['menucount'] += 10;  //everything except the 2 admin links

    global $infomenulinks;
    if (isset($infomenulinks)) $menu .= custom_links($infomenulinks);


    return $menu;
}

/**
 * @param $instance
 * @return string
 */
function tng_getLanguageSelect($instance) {
    global $chooselang, $languages_table, $mylanguage, $languages_path;

    $menu = "";
    if ($chooselang) {
        $query = "SELECT languageID, display, folder FROM $languages_table ORDER BY display";
        $result = tng_query($query);
        $numlangs = tng_num_rows($result);

        if ($numlangs > 1) {
            $menu .= "<li class='langmenu'>\n";
            $menu .= getFORM("savelanguage2", "get", "tngmenu$instance", "");
            $menu .= "<select name=\"newlanguage$instance\" id=\"newlanguage$instance\" style=\"font-size:9pt;\" onchange=\"document.tngmenu$instance.submit();\">";

            while ($row = tng_fetch_assoc($result)) {
                $menu .= "<option value=\"{$row['languageID']}\"";
                if ($languages_path . $row['folder'] == $mylanguage) {
                    $menu .= " selected";
                }
                $menu .= ">{$row['display']}</option>\n";
            }
            $menu .= "</select>\n";
            $menu .= "<input type='hidden' name='instance' value=\"$instance\"></form>\n";
            $menu .= "</li>\n";
        }

        tng_free_result($result);
    }

    return $menu;
}

/**
 * @param $title
 * @return string
 */
function tng_getLangMenu($title) {
    global $chooselang, $languages_table, $mylanguage, $languages_path, $tngconfig;

    $menu = "";
    if ($chooselang) {
        $query = "SELECT languageID, display, folder FROM $languages_table ORDER BY display";
        $result = tng_query($query);
        $numlangs = tng_num_rows($result);

        if ($numlangs > 1) {
            while ($row = tng_fetch_assoc($result)) {
                $prefix = $languages_path . $row['folder'] == $mylanguage ? "*" : "";
                $menu .= tngddrow("savelanguage2.php?newlanguage=" . $row['languageID'], "", "", $prefix . $row['display'], true);
                $tngconfig['menucount']++;
            }
            if ($menu) {
                $menu = "<ul id='mlangmenu' class='mright'>\n" . $menu . "</ul>\n";
            }
        }

        tng_free_result($result);
    }

    return $menu;
}

/**
 * @param $key
 * @param $itemcount
 * @return string
 */
function get_menustyle($key, $itemcount) {
    $mmenustyle = "";
    if ($itemcount) {
        $moffset = 50 * $itemcount;
        $mmenustyle .= "ul#m" . $key . "menu {-webkit-transform: translate3d(0,-" . $moffset . "px,0);}\n";
        $mmenustyle .= "ul#m" . $key . "menu {-moz-transform: translate3d(0,-" . $moffset . "px,0);}\n";
        $mmenustyle .= "ul#m" . $key . "menu {transform: translate3d(0,-" . $moffset . "px,0);}\n";
    }
    return $mmenustyle;
}

/**
 * @param $title
 * @return string
 */
function tng_mobileicons($title) {
    global $text, $tngconfig, $custmenu, $custommobilemenu, $custommenulinks;

    $menu = "<div id='tngheader'>\n";
    $menu .= "<div id='mast'>\n";
    $menu .= "<div class='mhead'>\n";
    $menu .= "<a href='' id='mcore' onclick=\"return toggleMobileMenu('core');\"></a>\n";

    $tngconfig['mmenustyle'] = "";
    $tngconfig['menucount'] = 0;
    $menu .= "<ul id='mcoremenu'>\n";
    $menu .= tng_getLeftIcons();
    $menu .= tng_getRightIcons();
    $menu .= "</ul>\n";
    $tngconfig['mmenustyle'] .= get_menustyle("core", $tngconfig['menucount']);

    $menuicons = "<div id='mmenus'>\n";
    $menuitems = "";

    $tngconfig['menucount'] = 0;
    $finditems = tng_getFindMenu();
    if ($tngconfig['menucount']) {
        $menuitems .= "<ul id='mfindmenu' class='mright'>\n" . $finditems . "</ul>\n";
        $menuicons .= "<a href='' class='mmenu' id='mmenu-find' title=\"{$text['find_menu']}\" onclick=\"return toggleMobileMenu('find');\"></a>\n";
        $tngconfig['mmenustyle'] .= get_menustyle("find", $tngconfig['menucount']);
    }

    $tngconfig['menucount'] = 0;
    $mediaitems = tng_getMediaMenu();
    if ($tngconfig['menucount']) {
        $menuitems .= "<ul id='mmediamenu' class='mright'>\n" . $mediaitems . "</ul>\n";
        $menuicons .= "<a href='' class='mmenu' id='mmenu-media' title=\"{$text['media']}\" onclick=\"return toggleMobileMenu('media');\"></a>\n";
        $tngconfig['mmenustyle'] .= get_menustyle("media", $tngconfig['menucount']);
    }

    $tngconfig['menucount'] = 0;
    $infoitems = tng_getInfoMenu($title);
    if ($tngconfig['menucount']) {
        $menuitems .= "<ul id='minfomenu' class='mright'>\n" . $infoitems . "</ul>\n";
        $menuicons .= "<a href='' class='mmenu' id='mmenu-info' title=\"{$text['info']}\" onclick=\"return toggleMobileMenu('info');\"></a>\n";
        $tngconfig['mmenustyle'] .= get_menustyle("info", $tngconfig['menucount']);
    }
    $tngconfig['menucount'] = 0;
    if (isset($custommobilemenu)) eval($custommobilemenu);

    elseif (isset($custmenu)) {
        $items = custom_links($custommenulinks);
        $menuitems .= custom_menu($custmenu, $items, true);
        $menuicons .= "<a href='' class='mmenu' id='mmenu-cust' title=\"{$custmenu['title_text']}\" onclick=\"return toggleMobileMenu('cust');\"></a>\n";
        $tngconfig['mmenustyle'] .= get_menustyle("cust", $tngconfig['menucount']);
    }
    $tngconfig['menucount'] = 0;
    $menuitems .= tng_getLangMenu($title);
    if ($tngconfig['menucount']) {
        $menuicons .= "<a href='' class='mmenu' id='mmenu-lang' title=\"{$text['language']}\" onclick=\"return toggleMobileMenu('lang');\"></a>\n";
        $tngconfig['mmenustyle'] .= get_menustyle("lang", $tngconfig['menucount']);
    }
    $menuicons .= "</div>\n";
    $menu .= $menuicons . $menuitems . "</div>\n</div>\n</div>\n";

    return $menu;
}

/**
 * @param $instance
 * @param string $title
 * @return string
 */
function tng_icons($instance, $title = "") {
    global $text, $tngconfig, $customshare, $tngprint, $custommenu, $custmenu, $custommenulinks;

    $fullmenu = "";
    if ($tngprint) {
        $fullmenu .= "<div style='float: right;'>";
        $fullmenu .= "<b><a id='printlink' style='text-decoration: underline;' href=\"javascript: {document.getElementById('printlink').style.visibility='hidden'; window.print();}\">&gt; {$text['tngprint']} &lt;</a></b>";
        $fullmenu .= "</div>\n";
    } else {
        if ($tngconfig['menu'] == 1) {
            $iconalign = "float-left";
        } else {
            $iconalign = " float-right";
        }

        $left_icons = tng_getLeftIcons();
        if ($left_icons) {
            $left_icons = "<div class='icons'>\n{$left_icons}&nbsp;\n</div>\n";
        }

        $right_icons = tng_getRightIcons();

        $langmenu = tng_getLanguageSelect($instance);

        $menu = "";
        if ($tngconfig['menu'] < 2) {
            $menu .= "<li><a href='#' class='menulink'>{$text['find_menu']}</a>\n";
            $menu .= "<ul>\n";
            $menu .= tng_getFindMenu();
            $menu .= "</ul>\n";
            $menu .= "</li>\n";

            $menu .= "<li><a href='#' class='menulink'>{$text['media']}</a>\n";
            $menu .= "<ul>\n";
            $menu .= tng_getMediaMenu();
            $menu .= "</ul>\n";
            $menu .= "</li>\n";

            $menu .= "<li><a href='#' class='menulink'>{$text['info']}</a>\n";
            $last = !$langmenu && !isset($custommenu) ? " class='last'" : "";
            $menu .= "<ul{$last}>\n";
            $menu .= tng_getInfoMenu($title);
            $menu .= "</ul>\n";
            $menu .= "</li>\n";

            //hook for custom dropdown options
            if (isset($custommenu)) {
                eval($custommenu);
            } //Rick Bisbee's mod
            elseif (isset($custmenu)) {
                $items = custom_links($custommenulinks);
                $menu .= custom_menu($custmenu, $items);
            }
        }

        $menu .= $langmenu;

        $outermenu = $rightmenu = "";

        if ($tngconfig['menu'] != 1) $outermenu .= $left_icons;


        if ($menu) {
            $outermenu .= "<ul class='tngdd $iconalign' id='tngdd'>\n";

            if ($tngconfig['menu'] != 1) {
                $outermenu .= "<li class='langmenu stubmenu'><br></li>\n";
            }

            $outermenu .= $menu;

            if ($tngconfig['menu'] == 1) {
                $outermenu .= "<li class='langmenu stubmenu-rt'><br></li>\n";
            }

            $outermenu .= "</ul>\n";
        }

        if ($tngconfig['menu'] == 2 && !$langmenu) {
            $outermenu .= "<div class='icons-rt in-bar'>\n$right_icons\n</div>\n";
            $shift_str = " shift100left";
        } else {
            $shift_str = "";
        }

        if ($outermenu) {
            $fullmenu .= "<div class='menucontainer'>\n";
            $fullmenu .= "<div class='innercontainer'>\n";

            $fullmenu .= $outermenu;

            $fullmenu .= "</div>\n";
            $fullmenu .= "</div>\n";

            if (empty($tngconfig['searchchoice']) && empty($tngconfig['showsearch'])) {
                $fullmenu .= '<div id="searchdrop" class="slidedown rounded-lg" style="display:none;">';
                $fullmenu .= "<a href='#' class='float-right' onclick=\"jQuery('#searchdrop').slideUp(200); return false;\"><img src='img/tng_close.gif' alt=''></a>";
                $fullmenu .= "<h3 class='subhead'>{$text['search']} | <a href='searchform.php'>{$text['mnuadvancedsearch']}</a> | <a href='famsearchform.php'>{$text['searchfams']}</a> | <a href='searchsite.php'>{$text['searchsitemenu']}</a></h3>";
                $fullmenu .= getFORM("search", "get", "", "") . "\n";
                $fullmenu .= "<label for='searchfirst' class='mr-2'>{$text['firstname']}:</label>";
                $fullmenu .= "<input type='text' name='myfirstname' id='searchfirst'>\n";
                $fullmenu .= "<label for='searchlast' class='mr-2'>{$text['lastname']}:</label>";
                $fullmenu .= "<input type='text' name='mylastname' id='searchlast'>\n";
                $fullmenu .= "<label for='searchid' class='mr-2'>{$text['id']}:</label>";
                $fullmenu .= "<input type='text' class='w-24' name='mypersonid' id='searchid'>\n";
                $fullmenu .= "<input type='hidden' name='idqualify' value='equals'>\n";
                $fullmenu .= "<input type='submit' value='{$text['search']}'></form></div>";
            }
        }

        if ($tngconfig['menu'] == 1) $fullmenu .= $left_icons;


        $sharemenu = "";
        if (!empty($tngconfig['showshare'])) {
            $sharemenu .= "<div id='shareicons' style='display: none;'>\n";
            // todo shareicons? use of undefined span attribute displaytext
            $sharemenu .= "<span class='st_facebook_hcount' displayText='Facebook'></span>\n";
            $sharemenu .= "<span class='st_twitter_hcount' displayText='Tweet'></span>\n";
            $sharemenu .= "<span class='st_pinterest_hcount' displayText='Pinterest'></span>\n";
            $sharemenu .= "<span class='st_googleplus_hcount' displayText='Google +'></span>\n";
            if (isset($customshare)) eval($customshare);
            $sharemenu .= "</div>\n";
        }

        if ($sharemenu || $right_icons || $tngconfig['menu'] < 2 || $numlangs) {
            $fullmenu .= "<div class='icons-rt$shift_str'>";
            $fullmenu .= $sharemenu;

            if ($tngconfig['menu'] < 2 || $numlangs) {
                $fullmenu .= $right_icons;
            }

            $fullmenu .= "</div>\n";

            if ($tngconfig['menu'] == 1) {
                $fullmenu .= "<br style='clear:both;'><br>\n";
            }
        }

        if ($menu) {
            $fullmenu .= '<script>';
            $fullmenu .= 'var tngdd=new tngdd.dd("tngdd");';
            $fullmenu .= 'tngdd.init("tngdd","menuhover");';
            $fullmenu .= "</script>\n";
        }

    }

    return $fullmenu;
}

/**
 * @param $link
 * @param $id
 * @param $thumb
 * @param $label
 * @param false $labelliteral
 * @return string
 */
function tngddrow($link, $id, $thumb, $label, $labelliteral = false) {
    global $text;
    $uselabel = $labelliteral ? $label : $text[$label];
    $ddrow = "<li><a href=\"$link\">";
    if ($thumb) {
        $ddrow .= "<img src=\"$thumb\" class=\"menu-icon\" alt=\"\">";
    } else {
        $ddrow .= "<span class=\"menu-icon\" id=\"$id\"></span>";
    }
    $ddrow .= " <span class=\"menu-label\">$uselabel</span></a></li>\n";
    return $ddrow;
}

/**
 * @param $forminfo
 * @return string
 */
function treeDropdown($forminfo) {
    global $text, $requirelogin, $assignedtree, $trees_table, $time_offset, $treerestrict, $tree, $numtrees, $tngconfig;

    $ret = "";
    if (!$requirelogin || !$treerestrict || !$assignedtree) {
        $query = "SELECT gedcom, treename, lastimportdate FROM $trees_table ORDER BY treename";
        $treeresult = tng_query($query);
        $numtrees = tng_num_rows($treeresult);
        $foundtree = false;

        if ($numtrees > 1) {
            if ($forminfo['startform']) {
                $ret .= getFORM($forminfo['action'], $forminfo['method'], $forminfo['name'], $forminfo['id']);
            }
            $ret .= "<span class='normal'>{$text['tree']}: </span>";
            $ret .= treeSelect($treeresult, $forminfo['name']);
            $ret .= "&nbsp; <img src=\"img/spinner.gif\" style='display: none;' id=\"treespinner\" alt=\"\" class=\"spinner\">\n";
            if (isset($forminfo['hidden']) && is_array($forminfo['hidden'])) {
                foreach ($forminfo['hidden'] as $hidden)
                    $ret .= "<input type='hidden' name=\"" . $hidden['name'] . "\" value=\"" . $hidden['value'] . "\">\n";
            }
            if ($forminfo['endform']) {
                $ret .= "</form><br>\n";
            } else {
                $ret .= "<br><br>\n";
            }
            $treeresult = tng_query($query);
            if ($tree) {
                $foundtree = true;
                while ($row = tng_fetch_assoc($treeresult)) {
                    if ($row['gedcom'] == $tree) break;
                }
            }
        } else {
            $foundtree = true;
            $row = tng_fetch_assoc($treeresult);
        }
        if ($tngconfig['lastimport'] && $foundtree && $forminfo['lastimport']) {
            $lastimport = $row['lastimportdate'];

            if ($lastimport) {
                $importtime = strtotime($lastimport);
                if (substr($lastimport, 11, 8) != "00:00:00") {
                    $importtime += ($time_offset * 3600);
                }
                $importdate = strtoupper(substr(PHP_OS, 0, 3)) == 'WIN' ? strftime("%#d %b %Y %H:%M:%S", $importtime) : strftime("%e %b %Y %H:%M:%S", $importtime);
                echo "<p class='normal'>{$text['lastimportdate']}: " . displayDate($importdate) . "</p>";
            }
        }
        tng_free_result($treeresult);
    }
    return $ret;
}

/**
 * @param $treeresult
 * @param null $formname
 * @param null $onchange
 * @return string
 */
function treeSelect($treeresult, $formname = null, $onchange = null) {
    global $text, $tree;

    $ret = "<select name=\"tree\" id=\"treeselect\"";
    if ($formname) {
        $ret .= " onchange=\"jQuery('#treespinner').show();document.$formname.submit();\"";
    } elseif ($onchange) {
        $ret .= " onchange=\"$onchange\"";
    }
    $ret .= ">\n";
    $ret .= "<option value=\"-x--all--x-\" ";
    if (!$tree) $ret .= "selected";

    $ret .= ">{$text['alltrees']}</option>\n";

    while ($row = tng_fetch_assoc($treeresult)) {
        $ret .= "<option value=\"{$row['gedcom']}\"";
        if ($tree && $row['gedcom'] == $tree) $ret .= " selected";

        $ret .= ">{$row['treename']}</option>\n";
    }
    $ret .= "</select>\n";
    return $ret;
}

/**
 * @param $row
 * @param $mlflag
 * @return mixed|string
 */
function getMediaHREF($row, $mlflag) {
    global $mediatypes_assoc, $mediapath, $htmldocs, $imagetypes, $videotypes, $recordingtypes;

    $uselink = "";

    if ($row['form']) {
        $form = strtoupper($row['form']);
    } else {
        preg_match("/\.(.+)$/", $row['path'], $matches);
        $form = isset($matches[1]) ? strtoupper($matches[1]) : '';
    }
    $thismediatype = $row['mediatypeID'];
    $usefolder = $row['usecollfolder'] ? $mediatypes_assoc[$thismediatype] : $mediapath;

    if (!$row['abspath'] && (in_array($form, $imagetypes) || in_array($form, $videotypes) || in_array($form, $recordingtypes) || !$form)) {
        $uselink = "showmedia.php?mediaID=" . $row['mediaID'];
        if ($mlflag == 1) {
            $uselink .= "&amp;medialinkID=" . $row['medialinkID'];
        } elseif ($mlflag == 2) {
            $uselink .= "&amp;albumlinkID=" . $row['albumlinkID'];
        } elseif ($mlflag == 3) {
            $uselink .= "&amp;cemeteryID=" . $row['cemeteryID'];
        }
    } else {
        if ($row['abspath'] || substr($row['path'], 0, 4) == "http" || substr($row['path'], 0, 1) == "/") {
            $uselink = $row['path'];
        } else {
            $url = rawurlencode($row['path']);
            $url = str_replace("%2F", "/", $url);
            $url = str_replace("%3F", "?", $url);
            $url = str_replace("%23", "#", $url);
            $url = str_replace("%26", "&", $url);
            $url = str_replace("%3D", "=", $url);
            $uselink = "$usefolder/$url";
        }
    }
    if (!empty($row['newwindow'])) {
        $uselink .= "\" target=\"_blank";
    }

    return $uselink;
}

/**
 * @param $notes
 * @return string
 */
function insertLinks($notes) {
    if ($notes) {
        $pos = 0;
        $notepos = [];
        while (($pos = strpos($notes, "http", $pos)) !== FALSE) {
            if ($pos) $prevchar = substr($notes, $pos - 1, 1);

            if ($pos == 0 || ($prevchar != "\"" && $prevchar != "=")) {
                $notepos[] = $pos++;
            } else {
                $pos++;
            }
        }
        $posidx = count($notepos);
        while ($posidx > 0) {
            $actual = $posidx - 1;
            $pos = $notepos[$actual];
            $firstpart = substr($notes, 0, $pos);
            $rest = substr($notes, $pos);
            $linkstr = strtok($rest, " <\n\r");
            if (substr($linkstr, -1) == ".") {
                $linkstr = substr($linkstr, 0, -1);
            }
            $lastpart = substr($notes, $pos + strlen($linkstr));
            $notes = $firstpart . "<a href=\"$linkstr\" target='_blank'>$linkstr</a>" . $lastpart;
            $posidx--;
        }
    }

    return $notes;
}

/**
 * @param $key
 * @return mixed
 */
function getTemplateMessage($key) {
    global $tmp, $session_language;

    $langkey = $key . "_" . $session_language;

    return isset($tmp[$langkey]) ? $tmp[$langkey] : $tmp[$key];
}

/**
 * @param $linkList
 * @param false $newtab
 * @param null $class
 * @param null $inner_html
 * @return string
 */
function showLinks($linkList, $newtab = false, $class = null, $inner_html = null) {
    $links = explode("\r", $linkList);
    $finishedList = "";
    if (count($links) == 1) $links = explode("\n", $linkList);

    foreach ($links as $link) {
        $parts = explode(",", $link);
        $len = count($parts);
        if ($len == 1) {
            $title = $href = trim($parts[0]);
        } elseif ($len == 2) {
            $title = trim($parts[0]);
            $href = trim($parts[1]);
            $newtab = false;
        } elseif ($len == 3) {
            $title = trim($parts[0]);
            $href = trim($parts[1]);
            $newtab = true;
        } else {
            $href = trim(array_pop($parts));
            $title = implode("", $parts);
        }
        $target = $newtab ? " target='_blank'" : "";
        $finishedList .= "<li";
        if ($class) $finishedList .= " class=\"$class\"";

        if ($inner_html) {
            $html = preg_replace("/xxx/", $title, $inner_html);
        } else {
            $html = $title;
        }
        $finishedList .= "><a href='$href' title=\"$title\"$target>$html</a></li>\n";
    }
    return $finishedList;
}

/**
 * @param $linkList
 * @return string
 */
function showMediaLinks($linkList) {
    global $media_table, $mediapath, $mediatypes_assoc;
    $links = explode(",", $linkList);
    $finishedmedList = "";

    foreach ($links as $link) {
        $thumbquery = "SELECT * FROM $media_table WHERE mediaID = \"$link\"";
        $thumbresult = tng_query($thumbquery);
        $thumbrow = tng_fetch_assoc($thumbresult);
        tng_free_result($thumbresult);
        $mediatypeID = $thumbrow['mediatypeID'];
        $usefolder = $thumbrow['usecollfolder'] ? $mediatypes_assoc[$mediatypeID] : $mediapath;
        $thumb = "$usefolder/" . str_replace("%2F", "/", rawurlencode($thumbrow['thumbpath']));
        $title = !empty($thumbrow['altdescription']) ? $thumbrow['altdescription'] : $thumbrow['description'];
        $imgsrc = "<img src=\"$thumb\" alt=\"$title\" title=\"$title\" class='thumb rounded'>";
        $href = getMediaHREF($thumbrow, 0);
        $finishedmedList .= "<br><a href='$href' title=\"$title\" target='_blank'>" . $imgsrc . "</a>&nbsp;<a href='$href' title=\"$title\" target='_blank' style=\"vertical-align:top;\">$title</a><br>";
    }
    return $finishedmedList;
}

/**
 * @param $custmenu
 * @param $items
 * @param false $mobile
 * @return string
 */
function custom_menu($custmenu, $items, $mobile = false) {
    global $text;

    if (isset($custmenu['title_text'])) {
        $mtext = $custmenu['title_text'];
    } elseif (isset($custmenu['title_index'])) {
        $mtext = $text[$custmenu['title_index']];
    } // Check for deprecated options
    elseif (isset($custmenu['text'])) {
        if ($custmenu['literal'] == true) {
            $mtext = $custmenu['text'];
        } else {
            $mtext = $text[$custmenu['text']];
        }
    } else {
        $mtext = "Other";
    }

    if ($mobile) {
        $menu = "<ul id=\"mcustmenu\" class=\"mright\">\n" . $items . "</ul>\n";
    } else {
        $menu = "<li><a href='#' class='menulink'>$mtext</a>\n";
        $menu .= "<ul class=\"last\">\n" . $items . "\n</ul>\n";
        $menu .= "</li>\n";
    }

    return $menu;
}

/**
 * @param $linkdefs
 * @return string
 */
function custom_links($linkdefs) {
    global $text, $allow_admin, $currentuser, $users_table, $tngconfig;

    $menustr = '';
    for ($i = 0; isset($linkdefs[$i]); $i++) {
        if (isset($linkdefs[$i]['admin']) && $linkdefs[$i]['admin']) {
            if (!$allow_admin) continue;
            $query = "SELECT role FROM $users_table WHERE username='$currentuser'";
            $result = tng_query($query) or die("cannot execute query: $query");
            $row = tng_fetch_assoc($result);
            if ($row['role'] != 'admin') continue;
        }
        if (isset($linkdefs[$i]['user']) && $linkdefs[$i]['user'] === true && !$currentuser) continue;
        if (!isset($linkdefs[$i]['target'])) continue;
        $target = $linkdefs[$i]['target'];
        // add options to target section
        if (!empty($linkdefs[$i]['tip_text'])) {
            $target .= "\" title=\"{$linkdefs[$i]['tip_text']}";
        } elseif (isset($linkdefs[$i]['tip_index'])) {
            $target .= "\" title=\"{$text[$linkdefs[$i]['tip_index']]}";
        }
        if (isset($linkdefs[$i]['newwin'])) $target .= "\" target=\"_blank";

        // set label for the link
        if (isset($linkdefs[$i]['label_text'])) {
            $label = $linkdefs[$i]['label_text'];
            $literal = true;
        } elseif (isset($linkdefs[$i]['label_index'])) {
            $label = $linkdefs[$i]['label_index'];
            $literal = false;
        } // handle deprecated defs
        elseif (isset($linkdefs[$i]['text'])) {
            if ($linkdefs[$i]['literal']) {
                $literal = true;
                $label = $linkdefs[$i]['text'];
            } else {
                $label = $text[$linkdefs[$i]['text']];
                $literal = false;
            }
        }
        if (empty($linkdefs[$i]['sprite'])) $linkdefs[$i]['sprite'] = '';

        if (empty($linkdefs[$i]['icon'])) $linkdefs[$i]['icon'] = '';

        $menustr .= tngddrow(
            $target,
            $linkdefs[$i]['sprite'],
            $linkdefs[$i]['icon'],
            $label,
            $literal
        );
        $tngconfig['menucount']++;
    }

    return $menustr;
}

/**
 * @param $file
 * @return string
 */
function findlangfolder($file) {
    global $mylanguage, $language;

    if (file_exists("$mylanguage/$file")) {
        $foundlang = "$mylanguage";
    } elseif (file_exists("languages/$language/$file")) {
        $foundlang = "languages/$language";
    } else {
        $foundlang = "languages/English";
    }

    return $foundlang;
}

?>
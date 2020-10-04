<?php
//Original code by Chris Moss

include "famconfig.php";
$textpart = 'pedigree';
include "tng_begin.php";

$reverse = $rev;

if ($tngprint) {
    if ($familychart['boxwidth'] > 151) {
        $familychart['boxwidth'] = 151;
    }      #dimensions of individual boxes
    if ($familychart['boxHsep'] > 11) {
        $familychart['boxHsep'] = 11;
    }      #horizontal separation between individual boxes
    $familychart['chartHpad'] = 0;      #padding around chart
    if ($familychart['colsep'] > 200) {
        $familychart['colsep'] = 200;
    }      #between family column centres
}

if (!($familyID || $personID)) {
    die("no args\n");
}

if (!($family = getfamily($tree, $familyID, $personID))) {
    $family = [];
}

doheader($tree, $family);

$fatherID = $family['husband']['personID'];
if ($fatherID && ($patfamilyID = $personID == $fatherID && $familyID ? $familyID :  #not first family if both set
        getresult(getChildFamily($tree, $fatherID, 'parentorder')))) {
    $patfamily = getfamily($tree, $patfamilyID, '');
    $temp = getChild($patfamily, $fatherID);    #backwards compatible php 5.3
    $family['husband']['otherfamilies'] = $temp['otherfamilies'];  #usually null
}
$motherID = $family['wife']['personID'];
if ($motherID && ($matfamilyID = $personID == $motherID && $familyID ? $familyID :
        getresult(getChildFamily($tree, $motherID, 'parentorder')))) {
    $matfamily = getfamily($tree, $matfamilyID, '');
    $temp = getChild($matfamily, $motherID);
    $family['wife']['otherfamilies'] = isset($temp['otherfamilies']) ? $temp['otherfamilies'] : "";
}

if ($personID && $familyID) {    #comment if directed to another family
    $temp = getChild($family, $personID);
    $name = $personID == $fatherID ? $family['husband']['displayname'] : ($personID == $motherID ? $family['wife']['displayname'] : $temp['displayname']);
    [$frel, $mrel] = getResult(tng_query("select frel,mrel from $children_table where personID='$personID' and familyID='$familyID' and gedcom='$tree'"), 1);
    $type = strtolower($frel ? $frel : ($mrel ? $mrel : 'birth'));
    echo $text['parentfamily'] . " " . ($name ? " {$text['of']} $name " : " {$text['shown']} ") . " {$text['isthe']} $admtext[$type] {$text['family']}.";
}

[$patorder, $patsize, $patgrand] = familyorder($patfamily, $fatherID);
[$matorder, $matsize, $matgrand] = familyorder($matfamily, $motherID);
$famsize = is_array($family['children']) ? count($family['children']) : 0;
$parentorder = !$patgrand ? $matorder : (!$matgrand ? $patorder : min($patorder, $matorder));
if ($famsize + $parentorder + 1 > max($patsize, $matsize))  #minimize overall height
{
    $parentorder = max(0, max($patsize, $matsize) - $famsize - 1);
}
if (!$patgrand) {
    $patorder = $parentorder;
}
if (!$matgrand) {
    $matorder = $parentorder;
}

$colsep = $familychart['colsep'];
$boxheight = $familychart['boxheight'];
$boxwidth = $familychart['boxwidth'];
$hsep = $familychart['boxHsep'];
$vsep = $familychart['boxVsep'];
$hpad = $familychart['chartHpad'];
$vpad = $familychart['chartVpad'];
$pheight = $boxheight + $vsep;
$downarrow = "<img src='img/ArrowDown.gif' class='famdownarrow' alt=''>";
$uparrow = "<img src='img/admArrowUp.gif' class='famuparrow' alt=''>";

$famx = $hpad + floor(($boxwidth + $hsep) / 2); #position of parent boxes
$famy = $vpad + $boxheight + $parentorder * $pheight + 2 * $familychart['halfgenheight'];
$chartheight = 2 * ($vpad + $boxheight + $familychart['halfgenheight']) - $vsep
    + $pheight * max($patsize, $matsize, $famsize + $parentorder);
if ($chartheight < 300) {
    $chartheight = 300;
}

echo "<div align='left' id='outer' style='position:relative;padding-top:8px;width:100%;height:{$chartheight}px;'>\n";
$famfx = $fammx = $hpad;
if ($reverse) {
    $famfx += 2 * $colsep;
} else {
    $fammx += 2 * $colsep;
}
setoutparentfamily($patfamily, $fatherID, $famfx, $vpad, $boxwidth, $boxheight, $reverse ? 'M' : 'F');
setoutparentfamily($matfamily, $motherID, $fammx, $vpad, $boxwidth, $boxheight, $reverse ? 'F' : 'M');
setoutmainfamily($family, $colsep, $parentorder, $patorder, $matorder, $famx, $famy, $boxwidth, $boxheight, $reverse);

echo "\n</div>\n";

tng_footer($flags);

function getfamily($tree, $familyID, $personID) {
# yields array(husband, wife, children)
#  of  array(tree, familyID, husband, wife, personID, first, last, sex, birth, death, living, etc)
    global $families_table, $children_table, $people_table;
    if (!$familyID && $personID) {
        if ($familyID = getresult(tng_query("(SELECT familyID FROM $families_table WHERE husband='$personID' and gedcom='$tree' order by husborder limit 1) union (SELECT familyID FROM $families_table WHERE wife='$personID' and gedcom='$tree' order by wifeorder limit 1)"))) {
        } else {
            $familyID = getresult(getChildFamily($tree, $personID, 'parentorder'));
        }
    }
    $query = "SELECT distinct a.gedcom gedcom,a.familyID familyID,husband,wife, c.personID, c.firstname,c.lastname,c.sex,IF(birthdatetr!='0000-00-00',year(birthdatetr),year(altbirthdatetr)) AS birth,IF(deathdatetr !='0000-00-00',year(deathdatetr),year(burialdatetr)) death, marrdate, c.living living, c.private private, c.branch branch, nameorder, lnprefix, title, prefix, suffix, ordernum ";
    $query .= "FROM $families_table a left join $children_table b on a.familyID=b.familyID and a.gedcom=b.gedcom join $people_table c on c.personID in (a.husband,a.wife,b.personID) and a.gedcom=c.gedcom ";
    $query .= "WHERE a.familyID='$familyID' and a.gedcom='$tree' ";
    $query .= "ORDER BY b.ordernum";
    $result = tng_query($query);
    if (tng_num_rows($result) == 0) {
        return '';
    } else {
        $res = [];
        $i = 0;
        $res['children'] = [];
        $righttree = checktree($tree);
        while ($row = tng_fetch_assoc($result)) {
            $rightbranch = $righttree ? checkbranch($row['branch']) : 0;
            $rights = determineLivingPrivateRights($row, $righttree, $rightbranch);
            $row['allow_living'] = $rights['living'];
            $row['allow_private'] = $rights['private'];
            $row['both'] = $rights['both'];
            $row['displayname'] = getName($row);  #respects privacy
            $that = $row['personID'];
            $res['familyID'] = $row['familyID'];
            $res['marrdate'] = $row['marrdate'];
            $res['living'] = $row['living'];
            $res['gedcom'] = $row['gedcom'];
            if ($that == $row['husband']) {
                $res['husband'] = $row;
            } elseif ($that == $row['wife']) {
                $res['wife'] = $row;
            } else {
                if ($t = getOtherFamilies($tree, $that, $familyID)) {
                    $row['otherfamilies'] = $t;
                }
                $res['children'][$i++] = $row;
            }
        }
        tng_free_result($result);
        return $res;
    }
}

function familyorder(&$family, $personID) {
    #return position of a person in a family and number of children
    if (!$family) {
        return [0, 0, 0];
    }
    if ($family['husband'] || $family['wife']) {
        $parents = 1;
    }
    $children =& $family['children'];
    $order = 0;
    $count = count($children);
    foreach ($children as $child) {
        if ($child['personID'] == $personID) {
            return [$order, $count, $parents];
        }
        $order++;
    }
    return [0, $count, $parents];
}

function getresult($result, $multiple = 0) {
    #mysql utility for single result, which can be a row
    if (!$result) {
        print tng_error();
        return '';
    }
    $row = tng_fetch_array($result);
    tng_free_result($result);
    if ($multiple) {
        return $row;
    }
    return $row[0];
}

/*
function doUpArrow($left,$top,$person) {
	global $tree;
	echo "<div style='position:absolute;left:" . ($left-7) . "px;top:" . ($top-14) . "px'><a href=\"familychart.php?personID={$person['personID']}&amp;tree=$tree\" style=\"padding:4px\"><img src=\"img/ArrowUp.gif\"></a></div>";
}
*/

function setoutparentfamily($family, $childID, $left, $top, $width, $height, $swap) {
    #set parent family omitting the child who is the parent, which is done elsewhere
    global $familychart;
    if (!$family) {
        return;
    }
    $hsep = $familychart['boxHsep'];
    $vsep = $familychart['boxVsep'];
    $x = $left + floor(($width + $hsep) / 2);
    $xd = $left + floor($width / 2);
    $y = $top + $height;
    $husband = $family['husband'];
    $wife = $family['wife'];

    if ($husband && $wife) {
        doBox($husband, $left, $top, 'fambox', 'child');

        doBox($wife, $left + $width + $hsep, $top, 'fambox', 'child');

        echo "<div class='descender' style='left: {$xd}px;top: {$y}px;'>&nbsp;</div>\n";
        $both = 1;
    } elseif ($husband) {
        doBox($husband, $x, $top, 'fambox', 'child');
    } elseif ($wife) {
        doBox($wife, $x, $top, 'fambox', 'child');
    }
    $gh = $familychart['halfgenheight'];
    if ($husband || $wife) {
        $dx = $x + $width / 2;
        $ht = $gh;
        if ($both) {
            $y += $gh;
        } else {
            $ht = 2 * $gh;
        }
        echo "<div class='down' style='left:{$dx}px;top:{$y}px;height:{$ht}px;'>&nbsp;</div>\n";
    }
    $top += $height + 2 * $gh;
    $child = 0;
    $margin = $familychart['backborder'];
    $boxht = count($family['children']) * ($height + $vsep) - $vsep + 2 * $margin;
    $boxtop = $top - $margin;
    $boxleft = $x - $margin;
    echo "<div class='fambackground' style='left:{$boxleft}px;top:{$boxtop}px;height:{$boxht}px;'></div>\n";
    foreach ($family['children'] as $child) {
        if ($child['personID'] != $childID) {
            doBox($child, $x, $top, 'fambox', 'parent', $swap == $child['sex'] ? 1 : 0);
        }
        $top += $height + $vsep;
    }
}

function setoutmainfamily($family, $colsep, $order, $patorder, $matorder, $left, $top, $width, $height, $reverse) {
    #includes parents at appropriate positions for their families
    global $familychart;
    $leftparent = $reverse ? $family['wife'] : $family['husband'];
    $rightparent = $reverse ? $family['husband'] : $family['wife'];
    $vsep = $familychart['boxVsep'];
    $halfgen = $familychart['halfgenheight'];
    $margin = $familychart['backborder'];
    $x = $left + $width;
    $hh = floor($height / 2);
    $y = $top + $hh;
    $y2 = $top + $familychart['moreh'];
    if ($leftparent) {
        $leftorder = ($reverse ? $matorder : $patorder) - $order;
        $leftheight = $top + $leftorder * ($height + $vsep);
        doBox($leftparent, $left, $leftheight, 'mfambox', 'child', 0);
        doConnector('left', $x, $x, $x + floor(($colsep - $width) / 2), $top + $hh, $leftheight + $hh);
        doOtherSpouses($leftparent, $reverse ? 'husband' : 'wife', $left - 2 * $margin - $familychart['morew'], $leftheight, $reverse);
    }
    $x += $colsep - floor($width / 2);
    if ($rightparent) {
        $rightorder = ($reverse ? $patorder : $matorder) - $order;
        $rightheight = $top + $rightorder * ($height + $vsep);
        doBox($rightparent, $left + 2 * $colsep, $rightheight, 'mfambox', 'child', 0);
        doConnector('right', $x, $x + floor($colsep / 2), $x, $top + $hh, $rightheight + $hh);
        doOtherSpouses($rightparent, $reverse ? 'wife' : 'husband', $left + 2 * $colsep + $width + 2 * $margin, $rightheight, $reverse);
    }
    if ($family['children']) {
        if ($leftparent || $rightparent) {
            echo "<div class='down' style='left:{$x}px;top:{$y}px;height:{$halfgen}px;'></div>\n";
        }
        $left += $colsep;
        $top += $height; #+$familychart['halfgenheight'];
        $boxht = count($family['children']) * ($height + $vsep) - $vsep + 2 * $margin;
        $boxtop = $top - $margin;
        $boxleft = $left - $margin;
        echo "<div class='fambackground' style='left:{$boxleft}px;top:{$boxtop}px;height:{$boxht}px;'></div>\n";
        foreach ($family['children'] as $child) {
            doBox($child, $left, $top, 'mfambox', 'parent', 0);
            $top += $height + $vsep;
        }
    }
}

function doBox($person, $left, $top, $class, $type, $reverse = 0) {
    #class=fambox or mfambox, $type=parent or child
    global $familychart, $text, $downarrow, $uparrow;
    $name = $person['displayname'];
    $gender = getGenderIcon($person['sex'], 0);
    $rev = $reverse ? '&amp;rev=1' : '';

    if ($person['both']) {
        $birth = $person['birth'] ? $person['birth'] : ' ';
        $death = $person['death'] ? $person['death'] : ' ';
        $life = $birth == ' ' && $death == ' ' ? ' ' : "($birth-$death)";
        if ($person['living'] && $familychart['livingsymbol'] && $familychart['livingalways']) {
            $life .= "<img src='img/alive.png' height='15' width='15' title='{$text['living']}' alt=''>";
        }
    } elseif ($familychart['livingsymbol'] && !$_SESSION['logged_in']) {
        $life = "<a href='login.php' title='{$text['fcmlogin']}'><img src='img/alive.png' height='15' width='15' title='{$text['living']}' alt=''></a>";
    }
    $details = "<br><span class=\"smaller\">$gender $life</span>";
    $andtree = '&amp;tree=' . $person['gedcom'];
    $thisPersonID = $person['personID'];
    $imagestr = "";
    $famlink = "";
    if ($familyID = getfamilyID($person, $type)) {
        if ($type == 'child') {
            $famlink = " <a href='familychart.php?familyID=$familyID$andtree' title='{$text['showparentfamily']}'>$uparrow</a>\n";
        } #in general link through the person
        else {
            $famlink = " <a href='familychart.php?personID=$thisPersonID$andtree$rev' title='{$text['showfamily']}'>$downarrow</a>";
        } #but we want the child link to use the familyID
    }

    echo "\t<div class='$class' style='left:{$left}px;top:{$top}px;'>\n<table class='bare'><tbody><tr>";
    if ($familychart['inclphotos'] && $imagestr = getPhoto($person, $name, $familychart['boxheight'] - 4)) {
        echo "<td class='smallpic' style='padding-left:5px;'>$imagestr</td>";
    }
    if (($imagestr && strlen($name) > $familychart['boxwidth'] / 4.5) || strlen($name) > $familychart['boxwidth'] / 3.2) {
        $name = "<small>$name</small>";
    }
    $link = "<a href='getperson.php?personID=$thisPersonID$andtree' title='{$text['showperson']}'>$name</a>";
    echo "<td>$link$details$famlink</td></tr></tbody></table>\n</div>\n";

    if ($others = $person['otherfamilies']) {
        echo "<div class='more' style='left:" . ($left - $familychart['chartHpad'] - $familychart['morew']) . "px; top:" .
            ($top + $familychart['boxheight'] - 15) . "px;'><img src='img/family_small_icon.gif' onclick='toggle(\"$thisPersonID\");' alt='{$text['otherfamilies']}' title='{$text['otherfamilies']}' >
		<div id='$thisPersonID' class='rounded10 popup hiddenbox'>\n";
        while ($other = array_shift($others))
            echo "\t<a href='familychart.php?familyID={$other['familyID']}&amp;personID=$thisPersonID$andtree'>{$other['text']}</a><br>\n";
        echo "</div></div>\n";
    }
}

function doConnector($side, $x1, $x2, $x3, $y1, $y2) {
    if ($y1 == $y2) {
        echo "<div class='across' style='left: {$x1}px;top:{$y1}px;'></div>\n";
    } else {
        $y = $y2 - $y1;
        echo "<div class='{$side}lower' style='left:{$x2}px;top:{$y1}px; height:{$y}px;'></div>\n";
        echo "<div class='joiner' style='left: {$x3}px;top:{$y1}px;'></div>\n";
    }
}

function doOtherSpouses($person, $spouse, $left, $top, $reverse) {
    #insert html of a plus symbol with popups if other spouse(s)
    global $text, $families_table, $people_table, $tree;

    if ($otherfamilies = getfamilyID($person, 'other')) {
        echo "<div class='more' style='left:{$left}px;top:{$top}px;'>
		<img src='img/tng_more.gif' onclick='toggle(\"$spouse\");' alt='Other spouses' title='{$text['otherspouses']}'>
		<div id='$spouse' class='rounded10 popup hiddenbox'>";
        $tree = $person['gedcom'];
        $rev = $reverse ? '&amp;rev=1' : '';
        $sp = 0;
        while ($fam = $otherfamilies[$sp++]) {
            $query = "SELECT personID, firstname, lnprefix, lastname, prefix, suffix, nameorder, people.living AS living, people.private AS private ";
            $query .= "FROM $families_table families ";
            if ($spouse == "husband") {
                $query .= "LEFT JOIN $people_table people ON families.husband = people.personID AND families.gedcom = people.gedcom ";
                $query .= "WHERE familyID = '$fam' AND people.gedcom = '$tree' ";
                $query .= "ORDER BY husborder";
            } else {
                if ($spouse == "wife") {
                    $query .= "LEFT JOIN $people_table people ON families.wife = people.personID AND families.gedcom = people.gedcom ";
                    $query .= "WHERE familyID = '$fam' AND people.gedcom = '$tree' ";
                    $query .= "ORDER BY wifeorder";
                } else {
                    $query .= "LEFT JOIN $people_table people ON (families.husband = people.personID OR families.wife = people.personID) AND families.gedcom = people.gedcom ";
                    $query .= "WHERE familyID = '$fam' AND people.gedcom = '$tree'";
                }
            }
            $spresult = tng_query($query);

            $spouserow = tng_fetch_assoc($spresult);

            $righttree = checktree($person['gedcom']);
            $rightbranch = $righttree ? checkbranch($person['branch']) : false;

            $spouserights = determineLivingPrivateRights($spouserow, $righttree);
            $spouserow['allow_living'] = $spouserights['living'];
            $spouserow['allow_private'] = $spouserights['private'];

            $spousename = getName($spouserow);
            tng_free_result($spresult);

            echo "<a href='familychart.php?familyID=$fam&amp;tree=$tree$rev'>{$text['familywith']} $spousename</a><br>\n";
        }
        echo "</div></div>\n";
    }
}

function getfamilyID($person, $type) {
    #gets family for type=parent (first), child or 'other', which return array of possibles
    global $families_table, $children_table;
    $partner = ($sex = $person['sex']) == 'M' ? 'husband' : 'wife';
    $order = $sex == 'M' ? 'husborder' : 'wifeorder';
    $personID = $person['personID'];
    $tree = $person['gedcom'];
    if ($type == 'parent') {
        return getresult(tng_query("select familyID from $families_table where $partner='$personID' and gedcom='$tree' order by $order"));
    } elseif ($type == 'child') {
        return getresult(tng_query("select familyID from $children_table where personID='$personID' and gedcom='$tree'"));
    } elseif ($type == 'other') {    #more than one possible
        $familyID = $person['familyID'];
        $result = tng_query("select familyID from $families_table where $partner='$personID' and familyID!='$familyID' and gedcom='$tree' order by marrdatetr");
        $sp = [];
        $spouse = 0;
        while ($row = tng_fetch_array($result))
            $sp[$spouse++] = $row[0];
        return $sp;
    }
}

function getOtherFamilies($tree, $personID, $familyID) {
    #check to see if person has another (usually adopted) family, return ID and text
    global $text, $admtext;
    $result = getChildParentsFamily($tree, $personID);
    $res = [];
    while ($row = tng_fetch_assoc($result)) {
        if (($f = $row['familyID']) != $familyID) {
            $type = strtolower($row['frel'] ? $row['frel'] : ($row['mrel'] ? $row['mrel'] : 'birth'));
            array_push($res, ['familyID' => $f, 'type' => $type, 'text' => "{$text['showfamily']} - $admtext[$type]"]); #language independent
        }
    }
    return $res;
}

function getChild($family, $personID) {
    #extract named child array from family structure
    if (isset($family['children'])) {
        $kids = $family['children'];
        foreach ($kids as $kid)
            if ($kid['personID'] == $personID) {
                return $kid;
            }
    }
    return '';
}

function getPhoto($person, $alt, $height) {    #backwards compatibity version
    #returns link for default photo if visible
    $rights = getRights($person);
    return showSmallPhoto($person['personID'], $alt, $rights['both'], $height, false, $person['sex']);
}

function getRights($person) {
    #return array of rights
    $righttree = checktree($person['tree']);
    $rightbranch = $righttree ? checkbranch($person['branch']) : false;
    return determineLivingPrivateRights($person, $righttree, $rightbranch);
}

function doheader($tree, $family) {
    #calls tng_Drawheading and tng_menu
    global $text, $admtext, $flags, $tngconfig, $rightbranch, $disallowgedcreate, $allowpdf, $allow_pdf, $nonames;

    $f = $family['husband'];
    $m = $family['wife'];
    $familyID = $f ? $f['familyID'] : ($m ? $m['familyID'] : $family['children'][0]['familyID']);
    $familyname = ($f && $m) ? "{$f['displayname']} / {$m['displayname']}" : ($f ? $f['displayname'] : ($m ? $m['displayname'] : $family['children'][0]['displayname']));
    $righttree = checktree($tree);
    $rightbranch = $righttree ? checkbranch($family['branch']) : false;
    $rights = determineLivingPrivateRights($family, $righttree, $rightbranch);

    $treeResult = getTreeSimple($tree);      #patch to 2c
    $treerow = tng_fetch_assoc($treeResult);
    $disallowgedcreate = $treerow['disallowgedcreate'];
    $allowpdf = !$treerow['disallowpdf'] || ($allow_pdf && $rightbranch);
    tng_free_result($treeResult);

    $logname = $tngconfig['nnpriv'] && $family['private'] ? $admtext['text_private'] : ($nonames && $family['living'] ? $text['living'] : $familyname);
    writelog("<a href='familychart.php?familyID=$familyID&amp;tree=$tree'>{$text['familychart']}: $logname ($familyID)</a>");
    preparebookmark("<a href='familychart.php?familyID=$familyID&amp;tree=$tree'>{$text['familychart']}: $familyname ($familyID)</a>");

    echo "<!doctype html>\n";
    echo "<html lang='en'>\n";

    $flags['tabs'] = $tngconfig['tabs'];
    $flags['scripting'] = famStylesheet();

    tng_header($text['family'] . " " . $familyname . " ($familyID)", $flags);
    $photostr = showSmallPhoto($familyID, $familyname, $rights['both'], 0);
    $years = $family['marrdate'] && $rights['both'] ? $text['marrabbr'] . " " . displayDate($family['marrdate']) : "";

    echo tng_DrawHeading($photostr, "{$text['family']}: $familyname ($familyID)", $years);
    $innermenu = "<span class='lightlink3' id='tng_plink'>{$text['familychart']}&nbsp;</span>\n";

    $treeResult = getTreeSimple($tree);
    $treerow = tng_fetch_assoc($treeResult);
    $allowpdf = !$treerow['disallowpdf'] || ($allow_pdf && $rightbranch);
    if ($allowpdf) {
        $innermenu .= " &nbsp;&nbsp; | &nbsp;&nbsp; <a href='#' class='lightlink' ";
        $innermenu .= "onclick=\"tnglitbox = new LITBox('rpt_pdfform.php?pdftype=fam&amp;familyID=$familyID&amp;tree=$tree', {width: 400, height: 480}); return false;\">PDF</a>\n";
    }

    echo tng_menu("F", "familychart", $familyID, $innermenu);
}

function famStylesheet() {
    #css and javascript for this module
    global $familychart;
    $b = $familychart['boxwidth'];
    $bh = $familychart['boxheight'];
    $dw = $b + $familychart['boxHsep'];
    $dh = $familychart['halfgenheight'];
    $aw = floor($b / 2);
    $w = $familychart['colsep'] - floor($b / 2);
    $bw = $b + 2 * $familychart['backborder'];
    $lw = floor(($familychart['colsep'] - $b) / 2);
    $jw = floor($familychart['colsep'] / 2);
    return "
<style>
.fambox, .mfambox {
	width:{$b}px; height:{$bh}px;
	position: absolute; z-index: 5;
	background-color: {$familychart['boxcolor']};
	box-shadow: 5px 5px 5px {$familychart['shadowcolor']};
	border-radius: 10px;
	padding: 0; overflow:hidden;
	text-align: center;
}
.mfambox {
	background-color: {$familychart['fboxcolor']};
}
.fambackground {
	width:{$bw}px;
	position: absolute; z-index: 2;
	border-radius: 12px;
}
.bare, .smallpic {
	width: {$b}px;
	height: {$bh}px;
	padding: 0;
	border-collapse: collapse;
	text-align: center;
}
.smallpic { width: 30px; }
.descender {
	position: absolute; z-index: 3;
	width: {$dw}px;
	height: {$dh}px;
	border-bottom: solid thin #000;
	border-left: solid thin #000;
	border-right: solid thin #000;
}
.leftlower, .rightlower {
	position: absolute; z-index: 3;
	width: {$lw}px;
	border-bottom: solid thin #000;
}
.leftlower { border-right: solid thin #000; }
.rightlower { border-left: solid thin #000;}
.down {
	position: absolute; z-index: 3;
	width: $aw;
	border-left: solid thin #000;
}
.across, .joiner {
	position: absolute; z-index: 3;
	height: 5px;	
	border-top: solid thin #000;
}
.across { width: {$w}px;}
.joiner { width: {$jw}px;}
.more {
	position: absolute;
}
.hiddenbox {
	position:relative;
	display:none;
	z-index:10;
    padding:5px;
    border:1px solid #666;
	background-color: #ddf;
	font-size: 10pt;
}
</style>
<script>
function toggle(elem) {
  if (document.getElementById(elem).style.display)
	document.getElementById(elem).style.display = '';
  else	document.getElementById(elem).style.display = 'block';
}
</script>

";
}


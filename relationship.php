<?php
$textpart = "relate";
include "tng_begin.php";

include "config/pedconfig.php";
include "pedbox.php";

$totalRelationships = 0;
$needmore = true;

if (!isset($disallowspouses)) $disallowspouses = 0;
if (!isset($pedigree['maxrels']) || !$pedigree['maxrels']) {
    $pedigree['maxrels'] = 10;
}
if (!$maxrels || $maxrels > $pedigree['maxrels']) {
    $maxrels = $pedigree['maxrels'];
}

if (!isset($pedigree['maxupgen']) || !$pedigree['maxupgen']) {
    $pedigree['maxupgen'] = 15;
}
if (!$generations || $generations > $pedigree['maxupgen']) {
    $generations = $pedigree['maxupgen'];
}
$maxupgen = $generations;

$slot = 0;
$pedigree['puboxwidth'] += 40;

class Relationship
{
    public $upcount = 0;
    public $downcount = 0;
    public $downarray = [];
    public $uparray = [];
    public $match = 0;
    public $spouseflag = 0;
    public $spouses = 0;
    public $firstone = 1;
    public $offsetH = 0;
    public $offsetV = -1;
    public $split = 0;
    public $half = false;
    public $multparents = 0;
    public $multparent1, $multspouse1, $multspouse2;
    public $uplist = [];
    public $upptr = 0;

    public function reset() {
        $this->match = 0;
        $this->spouseflag = 0;
        $this->spouses = 0;
        $this->firstone = 1;
        $this->offsetH = 0;
        $this->offsetV = -1;
        $this->half = false;
    }

    public function printRelationshipSentence() {
        global $text, $gender1, $gender2, $namestr, $namestr2;

        $spousemsg = "";
        $name1 = $namestr;
        $name2 = $namestr2;
        $g1 = $gender1;
        $g2 = $gender2;

        if ($this->spouses) {
            $relmsg = "$namestr {$text['text_and']} $namestr2 {$text['spouses']}";
        } else {
            if ($this->split || $this->multparents) {  //(tree is split at the top)
                //cousins or siblings or aunt/uncle

                if ($this->downcount == 1 && $this->upcount == 1) {
                    $msgarray = $this->half ? [$text['halfbrother'], $text['halfsister'], $text['halfsibling']] : [$text['brother'], $text['sister'], $text['sibling']];
                    $relmsg = $this->getRelMsg($this->spouseflag, $name1, $g1, $name2, $g2, $msgarray);
                } elseif (!$this->downcount) {
                    if ($this->upcount == 1) {
                        if ($g1 == "M") {
                            $reldesc = $text['stepson'];
                        } elseif ($g1 == "F") {
                            $reldesc = $text['stepdau'];
                        } else {
                            $reldesc = $text['stepchild'];
                        }
                    } elseif ($this->upcount > 1) {
                        $greats = $this->upcount - 2;
                        if ($g1 == "M") {
                            $reldesc = $greats ? $text['gstepgson'] : $text['stepgson'];
                        } elseif ($g1 == "F") {
                            $reldesc = $greats ? $text['gstepgdau'] : $text['stepgdau'];
                        } else {
                            $reldesc = $greats ? $text['gstepgchild'] : $text['stepgchild'];
                        }

                        $greatmsg = $greats > 1 ? "$greats x" : "";
                        $reldesc = preg_replace("/xxx/", $greatmsg, $reldesc);
                    } else {
                        $reldesc = "[undetermined relationship]"; //shouldn't ever get here.
                    }
                    $relmsg = "$name1 {$text['is']} $reldesc $name2";
                } elseif ($this->upcount == 1) {
                    $greats = $this->downcount - 2;
                    $relarray = $greats ? [$text['guncle'], $text['gaunt'], $text['guncleaunt']] : [$text['uncle'], $text['aunt'], $text['uncleaunt']];
                    $greatmsg = $greats > 1 ? "$greats x" : "";
                    $relmsg = $this->getRelMsg($this->spouseflag, $name1, $g1, $name2, $g2, $relarray);
                    $relmsg = preg_replace("/xxx/", $greatmsg, $relmsg);
                } elseif ($this->downcount == 1) {
                    $greats = $this->upcount - 2;
                    $relarray = $greats ? [$text['gnephew'], $text['gniece'], $text['gnephnc']] : [$text['nephew'], $text['niece'], $text['nephnc']];
                    $greatmsg = $greats > 1 ? "$greats x" : "";
                    $relmsg = $this->getRelMsg($this->spouseflag, $name1, $g1, $name2, $g2, $relarray);
                    $relmsg = preg_replace("/xxx/", $greatmsg, $relmsg);
                } else {
                    //they're cousins
                    $cousins = $this->downcount <= $this->upcount ? $this->downcount - 1 : $this->upcount - 1;
                    //get sex of person1 to determine male cousin or female cousin (for languages with gender)
                    $cousinmsg = $cousins > 1 ? "$cousins x" : "";
                    $msgarray = $this->half ? [$text['mhalfcousin'], $text['fhalfcousin'], $text['halfcousin']] : [$text['mcousin'], $text['fcousin'], $text['cousin']];
                    $relmsg = $this->getRelMsg($this->spouseflag, $name1, $g1, $name2, $g2, $msgarray);
                    $relmsg = preg_replace("/xxx/", $cousinmsg, $relmsg);
                    $removed = abs($this->downcount - $this->upcount);
                    if ($removed > 1) {
                        $remmsg = " $removed " . $text['removed'];
                    } elseif ($removed == 1) {
                        $remmsg = " " . $text['oneremoved'];
                    } else {
                        $remmsg = "";
                    }
                    $relmsg = preg_replace("/yyy/", $remmsg, $relmsg);
                }
            } else {
                //direct relationship

                if ($this->downcount == 2 || $this->upcount == 1) {
                    //son/daughter (get sex of person ?)
                    $thisgender = $g1;
                    if ($this->spouseflag) {
                        $reldesc = $g1 == "M" ? $text['fil'] : ($g1 == "F" ? $text['mil'] : $text['fmil']);
                    } else {
                        if ($this->downcount == 2) {
                            if ($thisgender == "M") {
                                $reldesc = $text['fathof'];
                            } elseif ($thisgender == "F") {
                                $reldesc = $text['mothof'];
                            } else {
                                $reldesc = $text['parof'];
                            }
                        } else {
                            if ($thisgender == "M") {
                                $reldesc = $text['son'];
                            } elseif ($thisgender == "F") {
                                $reldesc = $text['daughter'];
                            } else {
                                $reldesc = $text['child'];
                            }
                        }
                    }
                    $relmsg = "$name1 {$text['is']} $reldesc $name2";
                } else {
                    //great grandson/great granddaughter
                    if ($this->downcount) {
                        $greats = $this->downcount - 3;
                        $relarray = $greats ? [$text['ggfath'], $text['ggmoth'], $text['ggpar']] : [$text['gfath'], $text['gmoth'], $text['gpar']];
                    } else {
                        $greats = $this->upcount - 2;
                        $relarray = $greats ? [$text['ggson'], $text['ggdau'], $text['ggsondau']] : [$text['gson'], $text['gdau'], $text['gsondau']];
                    }
                    $greatmsg = $greats > 1 ? "$greats x" : "";
                    $relmsg = $this->getRelMsg($this->spouseflag, $name1, $g1, $name2, $g2, $relarray);
                    $relmsg = preg_replace("/xxx/", $greatmsg, $relmsg);
                }
            }
        }
        echo "<p>" . $relmsg . "</p>\n";
    }

    public function getRelMsg($spouseflag, $namestr, $gender1, $namestr2, $gender2, $messages) {
        global $text;

        if ($spouseflag == 1) {
            $spousemsg = $gender2 == "M" ? $text['rwife'] : ($gender2 == "F" ? $text['rhusband'] : $text['rspouse']);
        } elseif ($spouseflag == 2) { //same sex relationship
            $spousemsg = $gender2 == "M" ? $text['rhusband'] : ($gender2 == "F" ? $text['rwife'] : $text['rspouse']);
        }
        if ($gender1 == "M") {
            $reldesc = $messages['0'];
        } elseif ($gender1 = "F") {
            $reldesc = $messages['1'];
        } else {
            $reldesc = $messages['2'];
        }
        return "$namestr {$text['is']} $reldesc $spousemsg $namestr2";
    }

    public function switchGender($gender) {
        return $gender == "M" ? "F" : ($gender == "F" ? "M" : $gender);
    }

    public function buildUparray() {
        $this->uparray = [];
        $index = $this->upptr;
        $upcount = $this->upcount - 1;
        while ($upcount >= 0) {
            $nextcouple = $this->uplist[$upcount][$index];
            $index = $nextcouple['childindex'];
            unset($nextcouple['childindex']);
            array_push($this->uparray, $nextcouple);
            $upcount--;
        }
    }
}

if ($secondpersonID) {
    if (is_numeric($secondpersonID)) {
        $secondpersonID = $tngconfig['personprefix'] . $secondpersonID . $tngconfig['personsuffix'];
    }
    $relatepersonID = $_SESSION['relatepersonID'] = cleanIt($secondpersonID);
    $relatetreeID = $_SESSION['relatetreeID'] = $tree;
} else {
    $secondpersonID = $savedpersonID;
}
$secondpersonID = strtoupper($secondpersonID);

if ($altprimarypersonID) {
    $primarypersonID = $altprimarypersonID;
}

if (is_numeric($primarypersonID)) {
    $primarypersonID = $tngconfig['personprefix'] . $primarypersonID . $tngconfig['personsuffix'];
}
$primarypersonID = strtoupper($primarypersonID);

$righttree = checktree($tree);

$result = getPersonDataPlusDates($tree, $primarypersonID);
if (tng_num_rows($result)) {
    $row = tng_fetch_assoc($result);
    $rightbranch = checkbranch($row['branch']);
    $rights = determineLivingPrivateRights($row, $righttree, $rightbranch);
    $row['allow_living'] = $rights['living'];
    $row['allow_private'] = $rights['private'];
    $namestr = getName($row);
    $logname = $tngconfig['nnpriv'] && $row['private'] ? $admtext['text_private'] : ($nonames && $row['living'] ? $text['living'] : $namestr);
    $gender1 = $row['sex'];

    $treeResult = getTreeSimple($tree);
    $treerow = tng_fetch_assoc($treeResult);
    $disallowgedcreate = $treerow['disallowgedcreate'];
    tng_free_result($treeResult);
} else {
    $error = $primarypersonID;
}
tng_free_result($result);

$result2 = getPersonSimple($tree, $secondpersonID);
if (tng_num_rows($result2)) {
    $row2 = tng_fetch_assoc($result2);
    $rights2 = determineLivingPrivateRights($row2, $righttree);
    $row2['allow_living'] = $rights2['living'];
    $row2['allow_private'] = $rights2['private'];
    $namestr2 = getName($row2);
    $logname2 = $tngconfig['nnpriv'] && $row2['private'] ? $admtext['text_private'] : ($nonames && $row2['living'] ? $text['living'] : $namestr2);
    $gender2 = $row2['sex'];
} else {
    $error = $secondpersonID;
}
tng_free_result($result2);

writelog("<a href=\"relationship.php?altprimarypersonID=$primarypersonID&amp;tree=$tree&amp;secondpersonID=$secondpersonID\">{$text['relcalc']}: $logname ($primarypersonID) =&gt;$logname2 ($secondpersonID)</a>");
preparebookmark("<a href=\"relationship.php?altprimarypersonID=$primarypersonID&amp;tree=$tree&amp;secondpersonID=$secondpersonID\">{$text['relcalc']}: $namestr ($primarypersonID) =&gt;$namestr2 ($secondpersonID)</a>");

$pedigree['url'] = "pedigree.php?";
$pedigree['cellpad'] = 5;

if ($pedigree['inclphotos'] && (trim($photopath) == "" || trim($photosext) == "")) {
    $pedigree['inclphotos'] = false;
}
if (file_exists("img/Chart.gif")) {
    $imageSize = @GetImageSize("img/Chart.gif");
    $pedigree['chartlink'] = "<img src=\"img/Chart.gif\" $imageSize[3] title=\"{$text['popupnote2']}\" alt=\"\">";
} else {
    $pedigree['chartlink'] = "<span class='normal'><b>P</b></span>";
}
$pedigree['phototree'] = $tree;
if ($tree) {
    $pedigree['phototree'] .= ".";
}

if ($pedigree['usepopups'] == 1) {
    $pedigree['display'] = "standard";
} elseif ($pedigree['usepopups'] == 0) {
    $pedigree['display'] = "box";
} else {
    $pedigree['display'] = "compact";
}

$pedigree['baseR'] = hexdec(substr($pedigree['boxcolor'], 1, 2));
$pedigree['baseG'] = hexdec(substr($pedigree['boxcolor'], 3, 2));
$pedigree['baseB'] = hexdec(substr($pedigree['boxcolor'], 5, 2));

if ($pedigree['colorshift'] > 0) {
    $extreme = $pedigree['baseR'] < $pedigree['baseG'] ? $pedigree['baseR'] : $pedigree['baseG'];
    $extreme = $extreme < $pedigree['baseB'] ? $extreme : $pedigree['baseB'];
} elseif ($pedigree['colorshift'] < 0) {
    $extreme = $pedigree['baseR'] > $pedigree['baseG'] ? $pedigree['baseR'] : $pedigree['baseG'];
    $extreme = $extreme > $pedigree['baseB'] ? $extreme : $pedigree['baseB'];
}
$pedigree['colorshift'] = round($pedigree['colorshift'] / 100 * $extreme / 4);

function drawCouple($couple, $topflag, $linedown) {
    global $pedigree, $gens;

    $drawpersonID = $couple['person'];
    $gens->offsetH = $topflag ? $pedigree['leftindent'] + $pedigree['puboxwidth'] + $pedigree['boxHsep'] : $pedigree['leftindent'];

    if ($drawpersonID) {
        drawBox($drawpersonID, 0, $topflag);
        if ($gens->firstone) {
            //short line below box of first couple
            if ($linedown) {
                echo "<div class=\"boxborder\" style=\"background-color:{$pedigree['bordercolor']}; top:" . ($gens->offsetV + $pedigree['puboxheight'] - intval($pedigree['linewidth'] / 2)) . "px;left:" . ($gens->offsetH + intval($pedigree['puboxwidth'] / 2)) . "px;height:" . (2 * $pedigree['boxVsep']) . "px;width:{$pedigree['linewidth']}px;\"></div>\n";
            }
            $gens->firstone = 0;
        } else {
            //line coming up from top of other boxes
            echo "<div class=\"boxborder\" style=\"background-color:{$pedigree['bordercolor']}; top:" . ($gens->offsetV - (2 * $pedigree['boxVsep']) - intval($pedigree['linewidth'] / 2)) . "px;left:" . ($gens->offsetH + intval($pedigree['puboxwidth'] / 2)) . "px;height:" . (2 * $pedigree['boxVsep']) . "px;width:{$pedigree['linewidth']}px;\"></div>\n";
        }
    }
    $spouseID = $couple['spouse'];
    if ($spouseID) {
        echo "<div class=\"boxborder\" style=\"background-color:{$pedigree['bordercolor']}; top:" . ($gens->offsetV + intval($pedigree['puboxheight'] / 2) - intval($pedigree['linewidth'] / 2)) . "px;left:" . ($gens->offsetH + $pedigree['puboxwidth']) . "px;height:{$pedigree['linewidth']}px;width:" . (intval($pedigree['boxHsep'] / 2) + 1) . "px;z-index:3;overflow:hidden;\"></div>\n";
        $gens->offsetH = $gens->offsetH + $pedigree['puboxwidth'] + intval($pedigree['boxHsep'] / 2);
        drawBox($spouseID, 1, $topflag);
    }
    if ($topflag) {
        //long connecting line
        echo "<div class=\"boxborder\" style=\"background-color:{$pedigree['bordercolor']}; top:" . ($gens->offsetV + $pedigree['puboxheight'] + (2 * $pedigree['boxVsep']) - intval($pedigree['linewidth'] / 2)) . "px;left:" . ($pedigree['leftindent'] + intval($pedigree['puboxwidth'] / 2)) . "px;height:{$pedigree['linewidth']}px;width:" . ((2 * $pedigree['puboxwidth']) + $pedigree['boxHsep'] + $pedigree['leftindent'] + 1) . "px;\"></div>\n";
        $gens->offsetV += (2 * $pedigree['boxVsep']);
    }
    echo "\n\n";
}

function drawBox($drawpersonID, $spouseflag, $topflag) {
    global $gens, $tree, $pedigree;
    global $text, $personID1, $primarypersonID, $slot, $righttree;

    if ($spouseflag && !$topflag) {
        $boxcolortouse = getColor(1);
    } else {
        $boxcolortouse = getColor(0);
    }

    $namefontsztouse = $pedigree['boxnamesize'];
    $pedigree['begnamefont'] = "<span style=\"font-size:$namefontsztouse" . "pt\">";
    $pedigree['endfont'] = "</span>";

    $result = getPersonData($tree, $drawpersonID);
    if ($result) {
        $row = tng_fetch_assoc($result);

        $rights = determineLivingPrivateRights($row, $righttree);
        $row['allow_living'] = $rights['living'];
        $row['allow_private'] = $rights['private'];
        $nameinfo_org = getName($row);
        if ($drawpersonID == $personID1 || $drawpersonID == $primarypersonID) {
            $nameinfo = "<strong>$nameinfo_org</strong>";
        } else {
            $nameinfo = $nameinfo_org;
        }
        $row['birthdatetr'] = $row['altbirthdatetr'] = "0000-00-00"; //this is to suppress the age calculation on the chart
        $pedigree['namelink'] = "<a href=\"getperson.php?personID={$row['personID']}&amp;tree=$tree\">$nameinfo</a>";
        $pedigree['namelink'] .= "<br><span class=\"pedyears\">" . getYears($row) . "</span>";

        $newoffset = $spouseflag ? $gens->offsetV : $gens->offsetV + $pedigree['puboxheight'] + 2 * $pedigree['boxVsep'];
        $gens->offsetV = $gens->offsetV == -1 ? 0 : $newoffset;

        if ($row['famc'] && $pedigree['popupchartlinks']) {
            $iconactions = " onmouseover=\"if($('#ic$slot')) $('#ic$slot').show();\" onmouseout=\"if($('#ic$slot')) $('#ic$slot').hide();\"";
            $iconlinks = "<div class=\"floverlr\" id=\"ic$slot\" style=\"left:" . ($pedigree['puboxwidth'] - 35) . "px;top:" . ($pedigree['puboxheight'] - 15) . "px;display:none;\">";
            $iconlinks .= "<a href=\"{$pedigree['url']}personID=$drawpersonID&amp;tree=$tree&amp;display=standard&amp;generations=" . $pedigree['initpedgens'] . "\" title=\"{$text['popupnote2']}\">{$pedigree['chartlink']}</a>\n";
            $iconlinks .= "</div>\n";
            $slot++;
        } else {
            $iconactions = $iconlinks = "";
        }
        $shadow = $pedigree['shadowoffset'] . "px " . $pedigree['shadowoffset'] . "px " . $pedigree['shadowoffset'] . "px " . $pedigree['shadowcolor'];
        echo "<div class=\"pedbox rounded10\" style=\"background-color:$boxcolortouse; box-shadow:$shadow;top:" . $gens->offsetV . "px; left:" . $gens->offsetH . "px; height:{$pedigree['puboxheight']}" . "px; width:{$pedigree['puboxwidth']}" . "px;border:{$pedigree['borderwidth']}px solid {$pedigree['bordercolor']};\"$iconactions>\n";
        $tableheight = $pedigree['puboxheight'];
        echo "$iconlinks<table border='0' cellpadding='5' cellspacing='0' align=\"{$pedigree['puboxalign']}\" class=\"pedboxtable\"><tr>";

        // implant a picture (maybe)
        if ($pedigree['inclphotos']) {
            $photohtouse = $pedigree['puboxheight'] - ($pedigree['cellpad'] * 2); // take cellpadding into account
            $photoInfo = getPhotoSrc($row['personID'], $rights['both'], $row['sex']);
            if ($photoInfo['ref']) {
                $imagestr = "<img src=\"{$photoInfo['ref']}\" style=\"max-height:{$photohtouse}px;max-width:{$photohtouse}px;\" alt=\"\" class=\"smallimg\">";
                if ($photoInfo['link']) {
                    $imagestr = "<a href=\"{$photoInfo['link']}\">$imagestr</a>";
                }
                echo "<td class=\"lefttop\">$imagestr</td>";
            }
        }

        // name info
        echo "<td align=\"{$pedigree['puboxalign']}\" class=\"pboxname\" style=\"height:$tableheight;\">{$pedigree['begnamefont']}" . $pedigree['namelink'] . $pedigree['endfont'];

        echo "</td></tr></table></div>\n";
        //end box

        //keep track of total chart height
        tng_free_result($result);
    }
}

function doMultSpouse($prispouse1, $prispouse2, $otherspouse) {
    global $pedigree, $gens;

    echo "<div style=\"position:absolute;background-color:{$pedigree['bordercolor']}; top:" . ($gens->offsetV - intval($pedigree['linewidth'] / 2)) . "px;left:" . ($pedigree['leftindent'] + intval($pedigree['puboxwidth'] / 2)) . "px;height:{$pedigree['linewidth']}px;width:" . ((2 * $pedigree['puboxwidth']) + $pedigree['boxHsep'] + $pedigree['leftindent'] + 1) . "px;z-index:3;overflow:hidden;\"></div>\n";
    echo "<div style=\"position:absolute;background-color:{$pedigree['shadowcolor']}; top:" . ($gens->offsetV - intval($pedigree['linewidth'] / 2) + $pedigree['shadowoffset'] + 1) . "px;left:" . ($pedigree['leftindent'] + intval($pedigree['puboxwidth'] / 2) + $pedigree['shadowoffset'] + 1) . "px;height:{$pedigree['linewidth']}px;width:" . ((2 * $pedigree['puboxwidth']) + $pedigree['boxHsep'] + $pedigree['leftindent'] + 1) . "px;z-index:1;overflow:hidden;\"></div>\n";
    $gens->offsetV -= $pedigree['puboxheight'];

    $couple['person'] = $prispouse1;
    $couple['spouse'] = $prispouse2;
    $gens->firstone = 0;
    drawCouple($couple, 0, 0);
    $saveindent = $pedigree['leftindent'];
    $pedigree['leftindent'] += (2 * $pedigree['puboxwidth']) + $pedigree['boxHsep'] + $pedigree['leftindent'];
    $couple['spouse'] = $otherspouse;
    $gens->offsetV -= $pedigree['puboxheight'] + 2 * $pedigree['boxVsep'];
    drawCouple($couple, 0, 0);
    $pedigree['leftindent'] = $saveindent;
    $gens->half = true;
}

function finishRelationship($couple) {
    global $pedigree, $totalRelationships, $needmore, $gens, $maxrels, $session_norels;

    if ($totalRelationships) {
        echo "<hr><br><br>\n";
    }

    echo "<div id=\"tngchart\" align=\"left\" style=\"position:relative;\">\n";

    $downarray = $gens->downarray;
    $upcount = $gens->upcount;
    $downcount = $gens->downcount;

    if ($gens->split) {
        drawCouple(array_shift($downarray), 1, 1);
    } elseif ($gens->multparents) {
        doMultSpouse($gens->multparent1, $gens->multspouse1, $gens->multspouse2);
    } elseif ($upcount || $gens->spouses) {
        drawCouple($couple, 0, 0);
    } else {
        $downcount -= 1;
    }

    $maxwidth = $pedigree['borderwidth'] + $pedigree['puboxwidth'] + $pedigree['boxHsep'] + $saveindent;
    $maxwidth = $gens->upcount ? 2 * $maxwidth : $maxwidth;
    $maxheight = $pedigree['borderwidth'] + $pedigree['puboxheight'] + (2 * $pedigree['boxVsep']);
    if (!$gens->spouses) {
        $maxheight = $upcount > $downcount ? ($upcount + 1) * $maxheight : ($downcount + 1) * $maxheight;
    }
    if ($gens->split || $gens->multparents) {
        $maxheight += $pedigree['borderwidth'] + (2 * $pedigree['boxVsep']);
    }
    echo "<table border='0' cellspacing='0' cellpadding='0' style=\"width:{$maxwidth}px; height:{$maxheight}px;\"><tr><td></td></tr></table>\n";

    //if they're not spouses of each other, draw the rest of the boxes
    $downarray = array_reverse($downarray);
    $uparray = $gens->uparray;

    $getoffsetV = $gens->offsetV;
    if (!$gens->spouses) {
        $saveindent = $pedigree['leftindent'];
        $index = $gens->upptr;
        if ($upcount) {
            $upcount = $upcount - 1;
            while ($upcount >= 0) {
                $nextcouple = $gens->uplist[$upcount][$index];
                $index = $nextcouple['childindex'];
                drawCouple($nextcouple, 0, 1);
                $upcount--;
            }
            $pedigree['leftindent'] += (2 * $pedigree['puboxwidth']) + $pedigree['boxHsep'] + $pedigree['leftindent'];
            $gens->offsetV = $getoffsetV;
        }

        if (count($downarray)) {
            while ($nextcouple = array_pop($downarray))
                drawCouple($nextcouple, 0, 1);
        }

        $pedigree['leftindent'] = $saveindent;
    }

    if (!$session_norels) {
        $gens->printRelationshipSentence();
    }

    $gens->reset();
    $totalRelationships++;
    if ($totalRelationships >= $maxrels) {
        $needmore = false;
    }

    echo "</div>\n";
}

function checkOtherSpouse($parentrow, $parent, $spouse) {
    global $tree, $gens, $needmore;

    if ($parentrow[$parent] && $needmore) {
        $osresult = getSpouseFamilyMinimalExcept($tree, $parent, $parentrow[$parent], $spouse, $parentrow[$spouse]);

        //save husband and wife in $gens
        $gens->multparent1 = $parentrow[$parent];
        $gens->multspouse1 = $parentrow[$spouse];
        while ($osrow = tng_fetch_assoc($osresult)) {
            $gens->multspouse2 = $osrow[$spouse];

            $gens->downarray = [];
            $gens->downcount = 0;

            //is it the new spouse? We already know it isn't the main parent
            checkParent($osrow, $spouse, $parent);  //switched here

            $childresult = getChildrenMinimal($tree, $osrow['familyID']);

            while ($childrow = tng_fetch_assoc($childresult)) {
                checkpersondown($childrow['personID']);
            }
            tng_free_result($childresult);

            $gens->multspouse2 = "";
        }
        $gens->multparent1 = "";
        $gens->multspouse1 = "";
        tng_free_result($osresult);
    }
}

function checkParent($parentrow, $parent, $spouse) {
    global $targetID;

    if ($parentrow[$parent] == $targetID) {
        $couple['person'] = $parentrow[$parent];
        $couple['spouse'] = $parentrow[$spouse];

        finishRelationship($couple);
        $rval = true;
    } else {
        $rval = false;
    }

    return $rval;
}

//check ancestors of person1 to see if you find person2
function checkpersonup($nextcouple) {
    global $tree, $maxupgen, $gens, $needmore;

    $checkpersonID = $nextcouple['person'];
    $spouseID = $nextcouple['spouse'];

    $lastup = $gens->upcount;
    $gens->upcount += 1;
    $gens->buildUparray();

    if (!isset($gens->uplist[$gens->upcount])) $gens->uplist[$gens->upcount] = [];
    $gensup = $gens->upcount;

    //get all families in which this person is a child -- for each family
    $familyresult = getChildFamily($tree, $checkpersonID, "ordernum");
    while ($familyrow = tng_fetch_assoc($familyresult)) {
        //get children in family -- for each child in family
        $parentsresult = getFamilyMinimal($tree, $familyrow['familyID']);

        $gens->downarray = [];
        $gens->downcount = 0;
        //check here if husband or wife is the target
        //if so, start-draw-finish
        $parentrow = tng_fetch_assoc($parentsresult);
        if (!checkParent($parentrow, 'husband', 'wife') && !checkParent($parentrow, 'wife', 'husband')) {
            //push this couple on the $downarray. should be first one.
            if ($parentrow['husband']) {
                $couple['person'] = $parentrow['husband'];
                $couple['spouse'] = $parentrow['wife'];
            } else {
                $couple['person'] = $parentrow['wife'];
                $couple['spouse'] = "";
            }
            array_push($gens->downarray, $couple);
            //we're going down again, so we're assuming cousins or siblings
            $gens->split = 1;

            $childresult = getChildrenMinimalExcept($tree, $familyrow['familyID'], $checkpersonID);
            while ($needmore && $childrow = tng_fetch_assoc($childresult)) {
                checkpersondown($childrow['personID']);
            }
            tng_free_result($childresult);
            $gens->split = 0;

            //now we need to check children of other spouses of each parent
            //find all families where the husband is the same but the wife is different
            $gens->multparents = 1;
            checkOtherSpouse($parentrow, 'husband', 'wife');
            checkOtherSpouse($parentrow, 'wife', 'husband');
            $gens->multparents = 0;
            //if found, then draw original parents on left, other parents to right with line connecting the common spouse
        }
        if ($parentrow['husband'] && ($gensup < $maxupgen)) {
            array_push($gens->uplist[$gensup], ["person" => $parentrow['husband'], "spouse" => $parentrow['wife'], "childindex" => $gens->upptr]);
        }
        if ($parentrow['wife'] && ($gensup < $maxupgen)) {
            array_push($gens->uplist[$gensup], ["person" => $parentrow['wife'], "spouse" => $parentrow['husband'], "childindex" => $gens->upptr]);
        }

        tng_free_result($parentsresult);
    }
    tng_free_result($familyresult);

    /* exp */
    if ($needmore) {
        $gens->upptr++;

        if ($gens->upptr < count($gens->uplist[$lastup])) {
            $nextcouple = $gens->uplist[$lastup][$gens->upptr];
            $gens->upcount--;
        } elseif (is_array($gens->uplist[$gensup])) {
            $gens->upptr = 0;
            $nextcouple = $gens->uplist[$gensup][$gens->upptr];
        }

        if ($nextcouple) {
            checkpersonup($nextcouple);
        }
    }
}

//check descendants of person1 to see if you find person2
function checkpersondown($checkpersonID) {
    global $tree, $targetID, $secondpersonID, $maxupgen;
    global $gens, $otherID, $disallowspouses, $needmore;

    $gens->downcount += 1;
    $gensdown = $gens->downcount;

    //check person
    if ($checkpersonID != $targetID) {
        //get sex of each individual
        $result = getPersonGender($tree, $checkpersonID);
        if ($result) {
            $row = tng_fetch_assoc($result);
            if ($row['sex'] == "M") {
                $spouse = "wife";
                $self = "husband";
                $spouseorder = "husborder";
            } else {
                if ($row['sex'] == "F") {
                    $spouse = "husband";
                    $self = "wife";
                    $spouseorder = "wifeorder";
                } else {
                    $spouseorder = "";
                }
            }
            if ($spouseorder) {
                //get spouses -- for each spouse
                $spouseresult = getSpousesSimple($tree, $self, $checkpersonID, $spouse, $spouseorder);

                while ($needmore && $spouserow = tng_fetch_assoc($spouseresult)) {
                    //build couple
                    $couple['person'] = $checkpersonID;
                    $couple['spouse'] = $spouserow[$spouse];

                    $revcouple['person'] = $spouserow[$spouse];
                    $revcouple['spouse'] = $checkpersonID;
                    //push couple on downarray here
                    //don't push couple after, like previously done
                    $pushed = false;
                    if (!in_array($couple, $gens->uparray) && !in_array($revcouple, $gens->uparray)) {
                        array_push($gens->downarray, $couple);
                        $pushed = true;
                    }
                    //pop it off again after all children checked

                    //check spouse
                    if ($spouserow[$spouse] != $targetID || $disallowspouses) {
                        //get children -- for each child
                        if ($pushed) {
                            if ($gensdown < $maxupgen) {
                                $childresult = getChildrenMinimal($tree, $spouserow['familyID']);
                                while ($needmore && $childrow = tng_fetch_assoc($childresult)) {
                                    checkpersondown($childrow['personID']);
                                }
                                tng_free_result($childresult);
                            }
                            array_pop($gens->downarray);
                        }
                    } elseif ($pushed) {
                        $gens->match = 1;
                        $gens->spouseflag = $row['sex'] != $spouserow['sex'] ? 1 : 2;
                        if ($gens->downcount == 1 && !$gensup && $spouserow[$spouse] == $targetID && $checkpersonID == $otherID) {
                            $gens->spouses = 1;
                        } else {
                            $couple = $revcouple;
                        }
                        finishRelationship($couple);
                        array_pop($gens->downarray);
                    }
                }
                tng_free_result($spouseresult);
            }
            tng_free_result($result);
        }
    } else {
        $gens->downcount = $gensdown;

        $gens->match = 1;
        $couple['person'] = $checkpersonID;
        $couple['spouse'] = "";
        array_push($gens->downarray, $couple);
        finishRelationship($couple);
        array_pop($gens->downarray);
    }
    $gens->downcount -= 1;
}


function getColor($shifts) {
    global $pedigree;

    $shiftval = $shifts * $pedigree['colorshift'];
    $R = $pedigree['baseR'] + $shiftval;
    $G = $pedigree['baseG'] + $shiftval;
    $B = $pedigree['baseB'] + $shiftval;
    if ($R > 255) {
        $R = 255;
    }
    if ($R < 0) {
        $R = 0;
    }
    if ($G > 255) {
        $G = 255;
    }
    if ($G < 0) {
        $G = 0;
    }
    if ($B > 255) {
        $B = 255;
    }
    if ($B < 0) {
        $B = 0;
    }
    $R = str_pad(dechex($R), 2, "0", STR_PAD_LEFT);
    $G = str_pad(dechex($G), 2, "0", STR_PAD_LEFT);
    $B = str_pad(dechex($B), 2, "0", STR_PAD_LEFT);
    return "#$R$G$B";
}

function swapPeople() {
    global $namestr, $namestr2, $gender1, $gender2;

    $namestr3 = $namestr2;
    $namestr2 = $namestr;
    $namestr = $namestr3;
    $gender3 = $gender2;
    $gender2 = $gender1;
    $gender1 = $gender3;
}

$personID = $primarypersonID;

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

tng_header($text['relcalc'], $flags);

$photostr = showSmallPhoto($primarypersonID, $namestr, $rights['both'], 0, false, $row['sex']);
echo tng_DrawHeading($photostr, $namestr, getYears($row));

$innermenu = $text['rels'] . ": &nbsp;";
$innermenu .= "<select name=\"maxrels\" class=\"verysmall\">\n";
for ($i = 1; $i <= $pedigree['maxrels']; $i++) {
    $innermenu .= "<option value=\"$i\"";
    if ($i == $maxrels) {
        $innermenu .= " selected";
    }
    $innermenu .= ">$i</option>\n";
}
$innermenu .= "</select>&nbsp;&nbsp;&nbsp;\n";

$innermenu .= $text['dospouses2'] . ": &nbsp;";
$innermenu .= "<select name=\"disallowspouses\" class=\"verysmall\">\n";
$innermenu .= "<option value='0'";
if (!$disallowspouses) {
    $innermenu .= " selected";
}
$innermenu .= ">{$admtext['yes']}</option>\n";
$innermenu .= "<option value='1'";
if ($disallowspouses) {
    $innermenu .= " selected";
}
$innermenu .= ">{$admtext['no']}</option>\n";
$innermenu .= "</select>&nbsp;&nbsp;&nbsp;\n";

$innermenu .= $text['generations'] . ": &nbsp;";
$innermenu .= "<select name=\"generations\" class=\"verysmall\">\n";
for ($i = 1; $i <= $pedigree['maxupgen']; $i++) {
    $innermenu .= "<option value=\"$i\"";
    if ($i == $generations) {
        $innermenu .= " selected";
    }
    $innermenu .= ">$i</option>\n";
}
$innermenu .= "</select>&nbsp;&nbsp;&nbsp;\n";
$innermenu .= "<a href='#' class='lightlink' onclick=\"document.form1.submit();\">{$text['refresh']}</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"relateform.php?primaryID=$primarypersonID&amp;tree=$tree\" class='lightlink'>{$text['findanother']}</a>\n";

echo getFORM("relationship2", "get", "form1", "form1");
echo tng_menu("I", "relate", $primarypersonID, $innermenu);
echo "<input type='hidden' name=\"primarypersonID\" value=\"$primarypersonID\">\n";
echo "<input type='hidden' name=\"savedpersonID\" value=\"$secondpersonID\">\n";
echo "<input type='hidden' name=\"tree\" value='$tree'>\n";
echo "</form>\n";
?>
    <div id="searching"><img src="img/spinner.gif" alt=""> <?php echo $text['searching']; ?></div>
    <h3 class="subhead"><?php echo $text['relateto'] . " $namestr2"; ?></h3>
<?php
if ($error) {
    echo "<p>$error {$text['notvalid']}</p>\n";
} elseif ($primarypersonID == $secondpersonID) {
    echo "<p>{$text['sameperson']}</p>\n";
} else {
    $gens = new Relationship();

    $personID1 = $secondpersonID;
    $targetID = $secondpersonID;
    $otherID = $primarypersonID;

    checkpersondown($primarypersonID);
    $couple['person'] = $primarypersonID;
    $couple['spouse'] = "";
    $couple['childindex'] = 0;
    $gens->uplist[0] = [];
    array_push($gens->uplist[0], $couple); //exp

    checkpersonup($couple);

    if (!$totalRelationships) {
        $gens = new Relationship();

        $personID1 = $primarypersonID;
        $targetID = $primarypersonID;
        $otherID = $secondpersonID;

        swapPeople();

        checkpersondown($secondpersonID);
        $couple['person'] = $secondpersonID;
        $couple['spouse'] = "";
        $couple['childindex'] = 0;
        $gens->uplist[0] = [];
        array_push($gens->uplist[0], $couple);

        checkpersonup($couple);
    }

    if (!$totalRelationships) {
        $newstr = preg_replace("/xxx/", $generations, $text['notrelated']);
        echo "<p>$newstr</p>\n";
    }
}
?>
    <script>jQuery(document).ready(function () {
            jQuery('#searching').hide();
        });</script>
<?php
tng_footer($flags);
?>
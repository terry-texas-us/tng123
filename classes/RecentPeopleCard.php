<?php

class RecentPeopleCard
{
  public function __construct() {
  }

  /**
   * Html content selected where date later than cutoff, order by changedate descending, limited
   *
   * @param $tree
   * @param $limit
   * @return string
   */
  function buildHtmlContent($tree, $limit) {
    global $people_table, $trees_table, $text, $cms;

    $pedigree_url = getURL("pedigree", 1);
    $getperson_url = getURL("getperson", 1);

    $content = "";
    if ($tree) {
      $allwhere = "AND p.gedcom = \"$tree\"";
    } else {
      $allwhere = "";
    }

    $more = getLivingPrivateRestrictions("p", false, false);
    if ($more) {
      $allwhere .= " AND " . $more;
    }

    $query = "SELECT p.personID, lastname, lnprefix, firstname, birthdate, prefix, suffix, nameorder, living, private, branch, DATE_FORMAT(changedate,'%e %b %Y') as changedatef, changedby, LPAD(SUBSTRING_INDEX(birthdate, ' ', -1),4,'0') as birthyear, birthplace, altbirthdate, LPAD(SUBSTRING_INDEX(altbirthdate, ' ', -1),4,'0') as altbirthyear, altbirthplace, p.gedcom as gedcom, treename
	FROM $people_table as p, $trees_table WHERE p.gedcom = $trees_table.gedcom $allwhere
	ORDER BY changedate DESC, lastname, firstname, birthyear, altbirthyear LIMIT $limit";
    $result = tng_query($query);

    if (tng_num_rows($result)) {
      $content .= "<div class=\"titlebox tablediv\"><span class=\"subhead\"><b>{$text['individuals']}</b></span><br/><br/>";
      $chartlinkimg = @GetImageSize($cms['tngpath'] . "img/Chart.gif");
      $chartlink = "<img src=\"{$cms['tngpath']}img/Chart.gif\" border=\"0\" alt=\"\" $chartlinkimg[3] />";
      while ($row = tng_fetch_assoc($result)) {
        $rights = determineLivingPrivateRights($row);
        $row['allow_living'] = $rights['living'];
        $row['allow_private'] = $rights['private'];
        $namestr = getNameRev($row);
        list($birthdate, $birthplace) = getBirthInformation($rights['both'], $row);
        $content .= "<div class=\"inner-block\">\n";
        $content .= "<a href=\"$pedigree_url" . "personID={$row['personID']}&amp;tree={$row['gedcom']}\">$chartlink</a>";
        $content .= "<a href=\"$getperson_url" . "personID={$row['personID']}&amp;tree={$row['gedcom']}\" id=\"p{$row['personID']}_t{$row['gedcom']}\">$namestr</a>";
        if ($birthdate || $birthplace) {
          $content .= "<br/>&nbsp;&nbsp;&nbsp;";
          if ($birthdate) {
            $content .= "$birthdate";
            if ($birthplace) {
              $content .= ", ";
            }
          }
          if ($birthplace) {
            $content .= $birthplace;
          }
        }
        $content .= "</div>\n";
      }
      tng_free_result($result);
      $content .= "</div>";
    }
    return $content;
  }
}
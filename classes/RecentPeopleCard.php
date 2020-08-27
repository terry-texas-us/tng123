<?php

class RecentPeopleCard
{
  private string $path;

  public function setPath(string $path): void {
    $this->path = $path;
  }

  public function __construct() {
  }

  /**
   * Html content selected ordered by changedate descending, limited
   *
   * @param string $title card title
   * @param array $tables names of the 'people' and 'trees' tables
   * @param string $tree 'tree' name to use, default = "" (all trees)
   * @param int $limit
   * @return string
   */
  function buildHtmlContent($title, $tables, $tree = "", $limit = 10) {
    $people = $tables['people'];
    $trees = $tables['trees'];

    $pedigree_url = getURL("pedigree", 1);
    $getperson_url = getURL("getperson", 1);

    $changedatef = "DATE_FORMAT(changedate,'%e %b %Y') as changedatef";
    $birthyear = "LPAD(SUBSTRING_INDEX(birthdate, ' ', -1), 4, '0') as birthyear";
    $altbirthyear = "LPAD(SUBSTRING_INDEX(altbirthdate, ' ', -1), 4, '0') as altbirthyear";

    $whereClause = $this->buildWhereClause($tables, $tree);

    $query = "SELECT personID, lastname, lnprefix, firstname, birthdate, prefix, suffix, nameorder, living, private, branch, {$changedatef}, changedby, {$birthyear}, birthplace, altbirthdate, {$altbirthyear}, altbirthplace, {$people}.gedcom as gedcom, treename ";
    $query .= "FROM {$people}, {$trees} ";
    $query .= "WHERE {$whereClause} ";
    $query .= "ORDER BY changedate DESC, lastname, firstname, birthyear, altbirthyear ";
    $query .= "LIMIT {$limit}";
    $result = tng_query($query);

    $content = "";
    if (tng_num_rows($result)) {
      $content .= "<div class=\"titlebox tablediv\"><span class=\"subhead\"><b>{$title}</b></span><br/><br/>";
      $imageSize = @GetImageSize("{$this->path}img/Chart.gif");
      $chartlink = "<img src=\"{$this->path}img/Chart.gif\" alt=\"\" $imageSize[3] />";
      while ($row = tng_fetch_assoc($result)) {
        $rights = determineLivingPrivateRights($row);
        $row['allow_living'] = $rights['living'];
        $row['allow_private'] = $rights['private'];
        $namestr = getNameRev($row);
        [$birthdate, $birthplace] = getBirthInformation($rights['both'], $row);
        $content .= "<div class=\"inner-block\">\n";
        $content .= "<a href=\"$getperson_url" . "personID={$row['personID']}&amp;tree={$row['gedcom']}\" id=\"p{$row['personID']}_t{$row['gedcom']}\">$namestr</a>";
        $content .= "<a href=\"$pedigree_url" . "personID={$row['personID']}&amp;tree={$row['gedcom']}\">$chartlink</a>";
        if ($birthdate || $birthplace) {
          $content .= "<br/>";
          if ($birthdate) {
            $content .= "$birthdate";
            if ($birthplace) {
              $content .= "<br/>";
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

  /**
   * @param array $tables names of the 'people' and 'trees' tables
   * @param string $tree 'tree' name to use, default = "" (all trees)
   * @return string where clause joining the 'people' and 'trees' tables with optional restriction for 'tree' and 'living', 'private' rights
   */
  private function buildWhereClause($tables, $tree = ""): string {
    $people = $tables['people'];
    $trees = $tables['trees'];
    $clause = "{$people}.gedcom = {$trees}.gedcom";
    if ($tree) {
      $clause .= " AND {$people}.gedcom = \"$tree\"";
    }
    $livingPrivateRestrictions = getLivingPrivateRestrictions($people, false, false);
    if ($livingPrivateRestrictions) {
      $clause .= " AND " . $livingPrivateRestrictions;
    }
    return $clause;
  }
}
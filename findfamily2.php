<?php
include "begin.php";
include "adminlib.php";
$textpart = "families";
include "$mylanguage/admintext.php";

include $cms['tngpath'] . "checklogin.php";

if ($session_charset != "UTF-8") {
  $myhusbname = tng_utf8_decode($myhusbname);
  $mywifename = tng_utf8_decode($mywifename);
}

$allwhere = "$families_table.gedcom = \"$tree\"";
$joinon = "";
if ($assignedbranch) {
  $allwhere .= " AND $families_table.branch LIKE \"%$assignedbranch%\"";
}

$allwhere2 = "";

if ($mywifename) {
  $terms = explode(' ', $mywifename);
  foreach ($terms as $term) {
    if ($allwhere2) {
      $allwhere2 .= " AND ";
    }
    $allwhere2 .= "CONCAT_WS(' ',wifepeople.firstname,TRIM(CONCAT_WS(' ',wifepeople.lnprefix,wifepeople.lastname))) LIKE \"%$term%\"";
  }
}

if ($myhusbname) {
  $terms = explode(' ', $myhusbname);
  foreach ($terms as $term) {
    if ($allwhere2) {
      $allwhere2 .= " AND ";
    }
    $allwhere2 .= "CONCAT_WS(' ',husbpeople.firstname,TRIM(CONCAT_WS(' ',husbpeople.lnprefix,husbpeople.lastname))) LIKE \"%$term%\"";
  }
}

if ($allwhere2) {
  $allwhere2 = "AND $allwhere2";
}

$query = "SELECT familyID, wifepeople.personID AS wpersonID, wifepeople.firstname AS wfirstname, wifepeople.lnprefix AS wlnprefix, wifepeople.lastname AS wlastname, wifepeople.suffix AS wsuffix, wifepeople.nameorder AS wnameorder, wifepeople.living AS wliving, wifepeople.private AS wprivate, wifepeople.branch AS wbranch, husbpeople.personID AS hpersonID, husbpeople.firstname AS hfirstname, husbpeople.lnprefix AS hlnprefix, husbpeople.lastname AS hlastname, husbpeople.suffix AS hsuffix, husbpeople.nameorder AS hnameorder, husbpeople.living AS hliving, husbpeople.private AS hprivate, husbpeople.branch AS hbranch ";
$query .= "FROM $families_table families ";
$query .= "LEFT JOIN $people_table wifepeople ON families.wife = wifepeople.personID AND families.gedcom = wifepeople.gedcom ";
$query .= "LEFT JOIN $people_table husbpeople ON families.husband = husbpeople.personID AND families.gedcom = husbpeople.gedcom ";
$query .= "WHERE $allwhere $allwhere2 ";
$query .= "ORDER BY hlastname, hlnprefix, hfirstname ";
$query .= "LIMIT 250";
$result = tng_query($query);

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack ajaxwindow" id="findfamilyresdiv">
  <table cellpadding="0">
    <tr>
      <td valign="top">
        <span class="subhead"><strong><?php echo $admtext['searchresults']; ?></strong></span><br>
        <span class="normal">(<?php echo $admtext['clicktoselect']; ?>)</span><br>
      </td>
      <td>&nbsp;&nbsp;&nbsp;</td>
      <td>
        <form action=""><input type="button" value="<?php echo $admtext['find']; ?>" onClick="reopenFindForm();"></form>
      </td>
    </tr>
  </table>
  <br>
  <table cellspacing="0" cellpadding="2">
    <?php
      while ($row = tng_fetch_assoc($result)) {
        $thisfamily = "";
        if ($row['hpersonID']) {
          $person['firstname'] = $row['hfirstname'];
          $person['lnprefix'] = $row['hlnprefix'];
          $person['lastname'] = $row['hlastname'];
          $person['suffix'] = $row['hsuffix'];
          $person['nameorder'] = $row['hnameorder'];
          $person['living'] = $row['hliving'];
          $person['private'] = $row['hprivate'];
          $person['branch'] = $row['hbranch'];
          $person['allow_living'] = determineLivingRights($person);
          $thisfamily .= getName($person);
        }
        if ($row['wpersonID']) {
          if ($thisfamily) {
            $thisfamily .= "<br>";
          }
          $person['firstname'] = $row['wfirstname'];
          $person['lnprefix'] = $row['wlnprefix'];
          $person['lastname'] = $row['wlastname'];
          $person['suffix'] = $row['wsuffix'];
          $person['nameorder'] = $row['wnameorder'];
          $person['living'] = $row['wliving'];
          $person['private'] = $row['wprivate'];
          $person['branch'] = $row['wbranch'];
          $person['allow_living'] = determineLivingRights($person);
          $thisfamily .= getName($person);
        }
        echo "<tr><td valign=\"top\"><span class='normal'><a href=\"#\" onClick=\"return returnName('{$row['familyID']}','','text','{$row['familyID']}');\">{$row['familyID']}</a></span></td><td><span class='normal'><a href=\"#\" onclick=\"return returnName('{$row['familyID']}','','text','{$row['familyID']}');\">$thisfamily</a></span></td></tr>\n";
      }
      tng_free_result($result);
      ?>
    </table>
</div>

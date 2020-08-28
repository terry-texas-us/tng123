<?php
$textpart = "dna";
include "tng_begin.php";
include $cms['tngpath'] . "adminlib.php";
include $cms['tngpath'] . "personlib.php";

if ($tngconfig['hidedna'] && (!$allow_edit || !$allow_add || $assignedtree)) {
  header("Location: thispagedoesnotexist.html");
  exit;
}


$dnatree = isset($_SESSION["ttree"]) ? $_SESSION["ttree"] : "-x--all--x-";
$test_search = isset($_SESSION["tsearch"]) ? $_SESSION["tsearch"] : "";
$test_type = isset($_SESSION["ttype"]) ? $_SESSION["ttype"] : "";
$test_group = isset($_SESSION["tgroup"]) ? $_SESSION["tgroup"] : "";

$compare_selected_mtdna_url = getURL("compare_selected_mtdna", 1);
$browse_dna_tests_url = getURL("browse_dna_tests", 1) . "tree=" . $dnatree . "&amp;testsearch=" . $test_search . "&amp;test_type=" . $test_type . "&amp;test_group=" . $test_group;

$headline = "{$text['dnatestscompare_mtdna']}";
$text['dnatestscompare_mtdna'] .= ": " . $test_group;

$show_dna_test_url = getURL("show_dna_test", 1);
$showtree_url = getURL("showtree", 1);
$getperson_url = getURL("getperson", 1);
$familygroup_url = getURL("familygroup", 1);

$flags['tabs'] = $tngconfig['tabs'];
tng_header($text['dnatestscompare_mtdna'], $flags);


$comptabs[0] = array(1, $browse_dna_tests_url, $text['dna_tests'], "dnatests");
$innermenu = "<a href=\"https://tng.lythgoes.net/wiki/index.php?title=Compare DNA Tests Results\" target=\"_blank\" class=\"lightlink\">{$text['help']}</a>";
// Y-DNA Tests
$innermenu .= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"browse_dna_tests.php?tree=-x--all--x-&testsearch=&test_type=Y-DNA&test_group=\" class=\"lightlink\">{$admtext['ydna_test']}</a>";
// mtDNA Tests
$innermenu .= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"browse_dna_tests.php?tree=-x--all--x-&testsearch=&test_type=mtDNA&test_group=\" class=\"lightlink\">{$admtext['mtdna_test']}</a>";
// atDNA Tests
$innermenu .= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"browse_dna_tests.php?tree=-x--all--x-&testsearch=&test_type=atDNA&test_group=\" class=\"lightlink\">{$admtext['atdna_test']}</a>";

$menu = doMenu($comptabs, "", $innermenu);
?>

<h1 class="header"><span class="headericon" id="dna-hdr-icon"></span><?php echo $text['dnatestscompare_mtdna']; ?></h1><br clear="left">
<?php
echo $menu;
if (isset($_SESSION["ttree"])) {
  $wherestr = "WHERE $dna_tests_table.gedcom = \"{$_SESSION["ttree"]}\"";
  $join = "INNER JOIN";
} else {
  $wherestr = "";
}
$join = "LEFT JOIN";

if (!empty($test_type)) {
  $admtext['dna_tests'] = substr($test_type, 0, -3) . $admtext['dna_tests'];
  if ($wherestr) {
    $wherestr .= " AND $dna_tests_table.test_type = \"{$test_type}\"";
  } else {
    $wherestr = "WHERE $dna_tests_table.test_type = \"{$test_type}\"";
  }
}
if (!empty($test_group)) {
  $admtext['dna_tests'] .= ": " . $test_group;
  if ($wherestr) {
    $wherestr .= " AND $dna_tests_table.dna_group_desc = \"{$test_group}\"";
  } else {
    $wherestr = "WHERE $dna_tests_table.dna_group_desc = \"{$test_group}\"";
  }
}

$treestr = $tree ? " ({$text['tree']}: $tree)" : "";
$logstring = "<a href=\"$compare_selected_mtdna_url" . "tree=$tree&amp;&amp;testsearch=$test_search\">" . xmlcharacters($text['dnatestscompare_mtdna'] . $treestr) . "</a>";
writelog($logstring);
preparebookmark($logstring);

echo "<div class=\"normal\">\n";

$header = "";
$headerr = $enableminimap ? " data-tablesaw-minimap" : "";
$headerr .= $enablemodeswitch ? " data-tablesaw-mode-switch" : "";

if ($sitever != "standard") {
  if ($tabletype == "toggle") {
    $header = "<table cellpadding=\"3\" cellspacing=\"1\" border=\"0\" width=\"100%\" class=\"tablesaw whiteback normal\" data-tablesaw-mode=\"columntoggle\"{$headerr}>\n";
  } elseif ($tabletype == "stack") {
    $header = "<table cellpadding=\"3\" cellspacing=\"1\" border=\"0\" width=\"100%\" class=\"tablesaw whiteback normal\" data-tablesaw-mode=\"stack\"{$headerr}>\n";
  } elseif ($tabletype == "swipe") {
    $header = "<table cellpadding=\"3\" cellspacing=\"1\" border=\"0\" width=\"100%\" class=\"tablesaw whiteback normal\" data-tablesaw-mode=\"swipe\"{$headerr}>\n";
  }
} else {
  $header = "<table cellpadding=\"3\" cellspacing=\"1\" border=\"0\" class=\"whiteback normal\">";
}
echo $header;
?>

<div class="overflowauto">
  <table cellpadding="0" cellspacing="1" width="100%" class="whiteback normal">
    <thead>
    <tr>
      <th data-tablesaw-priority="persist" class="fieldnameback nbrcol fieldname">&nbsp;#&nbsp;</th>

      <?php
          if ($allow_edit || $showtestnumbers) { ?>
              <th data-tablesaw-priority="2" class="fieldnameback fieldname nw">&nbsp;<?php echo $text['test_number']; ?>&nbsp;</th>
            <?php
          }
          ?>
            <th data-tablesaw-priority="1" class="fieldnameback fieldname nw">&nbsp;<?php echo $text['takenby']; ?>&nbsp;</th>
            <th data-tablesaw-priority="3" class="fieldnameback fieldname nw">&nbsp;<?php echo $admtext['haplo']; ?>&nbsp;</th>
            <th data-tablesaw-priority="2" class="fieldnameback fieldname nw">&nbsp;<?php echo $text['sequence']; ?>&nbsp;</th>
            <th data-tablesaw-priority="2" class="fieldnameback fieldname nw">&nbsp;<?php echo $admtext['hvr1_values']; ?>&nbsp;</th>
            <th data-tablesaw-priority="2" class="fieldnameback fieldname nw">&nbsp;<?php echo $admtext['hvr2_values']; ?>&nbsp;</th>
            <th data-tablesaw-priority="1" class="fieldnameback fieldname nw">&nbsp;<?php echo $admtext['mrca']; ?>&nbsp;</th>
            <th data-tablesaw-priority="1" class="fieldnameback fieldname nw">&nbsp;<?php echo $text['testgroup']; ?>&nbsp;</th>
          <?php
          global $numtrees;
          if (!$assignedtree && ($numtrees > 1)) { ?>
              <th data-tablesaw-priority="5" class="fieldnameback fieldname">&nbsp;<?php echo $text['tree']; ?>&nbsp;</th><?php } ?>
        </tr>
        </thead>

      <?php
      $i = 1;
      foreach (array_keys($_POST) as $key) {
        if (substr($key, 0, 3) == "dna") {
          $testID = substr($key, 3);
          $query = "SELECT *
		FROM $dna_tests_table WHERE testID=$testID";
          $result = tng_query($query);
          $row = tng_fetch_assoc($result);

          //	add striping every other row
          if (empty($databack) || $databack == "databack") {
            $databack = "databackalt";
          } else {
            $databack = "databack";
          }

          echo "<tr><td valign=\"top\" class=\"$databack\">$i</td>\n";
          if ($allow_edit || $showtestnumbers) {
            if ($row['private_test']) {
              $privtest = "<br>&nbsp;(" . $admtext['text_private'] . ")";
            } else {
              $privtest = "";
            }
            echo "<td valign=\"top\" class=\"$databack\"><a href=\"$show_dna_test_url" . "group=$test_group&amp;testID={$row['testID']}&amp;tree={$row['gedcom']}\">{$row['test_number']}</a>&nbsp;$privtest</td>";
          }
          $dna_pers_result = getPersonData($row['gedcom'], $row['personID']);
          $dprow = tng_fetch_assoc($dna_pers_result);
          $dna_righttree = checktree($dprow['gedcom']);
          $dna_rightbranch = $dna_righttree ? checkbranch($dprow['branch']) : false;
          $dprights = determineLivingPrivateRights($dprow, $dna_righttree, $dna_rightbranch);
          $dprow['allow_living'] = $dprights['living'];
          $dprow['allow_private'] = $dprights['private'];
          $dbname = getName($dprow);
          $person_name = $row['person_name'];
          $dna_namestr = getName($dprow);
          $vitalinfo = getBirthInfo($dprow);
          if ($row['private_dna'] && $allow_edit) {
            $privacy = "&nbsp;(" . $admtext['text_private'] . ")";
          } else {
            $privacy = "";
          }
          if ($dbname) {
            $dna_namestr = "<a href=\"$getperson_url" . "personID={$row['personID']}&tree={$row['gedcom']}\">$dna_namestr</a>$privacy $vitalinfo";
          } else {
            $dna_namestr = $person_name . $privacy;
          }

          if ($row['private_dna'] && !$allow_edit) {
            $dna_namestr = $admtext['text_private'];
          }
          tng_free_result($dna_pers_result);
          echo "<td valign=\"top\" class=\"$databack\">$dna_namestr&nbsp;</td>";

          $mtdna_haplogroup = "";
          if ($row['mtdna_haplogroup']) {
            if ($row['mtdna_confirmed']) {
              $mtdna_haplogroup = "<span class='confirmed_haplogroup'>" . $row['mtdna_haplogroup'] . "</span>";
            } else {
              $mtdna_haplogroup = "<span class='predicted_haplogroup'>" . $row['mtdna_haplogroup'] . "</span>";
            }
          }
          echo "<td valign=\"top\" class=\"$databack\">&nbsp;$mtdna_haplogroup</td>";
          $seq = $row['ref_seq'];
          if ($seq == "rcrs") {
            $seq = "rCRS";
          }
          if ($seq == "rsrs") {
            $seq = "RSRS";
          }
          echo "<td valign=\"top\" class=\"$databack\">&nbsp;$seq</td>";

          echo "<td valign=\"top\" class=\"$databack  nw\">&nbsp;{$row['hvr1_results']}</td>";

          echo "<td valign=\"top\" class=\"$databack  nw\">&nbsp;{$row['hvr2_results']}</td>";


          $mrcanc_namestr = "";
          $anc_namestr = "";
          if ($row['MRC_ancestorID']) {
            if ($row['MRC_ancestorID'][0] == "I") {
              $dna_anc_result = getPersonDataPlusDates($row['gedcom'], $row['MRC_ancestorID']);
              $ancrow = tng_fetch_assoc($dna_anc_result);
              $dna_righttree = checktree($row['gedcom']);
              $dna_rightbranch = $dna_righttree ? checkbranch($row['branch']) : false;
              $dprights = determineLivingPrivateRights($ancrow, $dna_righttree, $dna_rightbranch);
              $ancrow['allow_living'] = $dprights['living'];
              $ancrow['allow_private'] = $dprights['private'];

                $anc_namestr = getName($ancrow);
              $mrcanc_namestr = "<a href=\"$getperson_url" . "personID={$row['MRC_ancestorID']}&tree={$row['gedcom']}\">$anc_namestr</a>";
              tng_free_result($dna_anc_result);
            } else {
              if ($row['MRC_ancestorID'][0] == "F") {
                $mrcquery = "SELECT familyID, husband, wife, living, private, marrdate, gedcom, branch FROM $families_table WHERE familyID = \"{$row['MRC_ancestorID']}\" AND gedcom = \"{$row['gedcom']}\"";
                $mrcresult = tng_query($mrcquery);
                $famrow = tng_fetch_assoc($mrcresult);
                tng_free_result($mrcresult);

                $righttree = checktree($row['gedcom']);
                $rightbranch = checkbranch($famrow['branch']);
                $rights = determineLivingPrivateRights($famrow, $righttree, $rightbranch);
                $famrow['allow_living'] = $rights['living'];
                $famrow['allow_private'] = $rights['private'];

                $famname = getFamilyName($famrow);
                $mrcanc_namestr = "<a href=\"$familygroup_url" . "familyID={$row['MRC_ancestorID']}&tree={$row['gedcom']}\">$famname</a>";
              }
            }
          }
          echo "<td valign=\"top\" class=\"$databack\">&nbsp;$mrcanc_namestr</td>";

          $group = $row['dna_group_desc'] ? $row['dna_group_desc'] : $text['none'];
          echo "<td valign=\"top\" class=\"$databack\">$group</td>";
          if (!$assignedtree && ($numtrees > 1)) {
            echo "<td valign=\"top\" class=\"$databack nw\"><a href=\"$showtree_url" . "tree={$row['gedcom']}\">{$row['treename']}</a>&nbsp;</td>";
          }
          echo "</tr>\n";
          $i++;
        }

      }
      if (isset($result)) {
        tng_free_result($result);
      }
      ?>
    </table>
</div>
<br>
<?php
tng_footer("");
?>

<?php
$textpart = "dna";
include "tng_begin.php";
include $cms['tngpath'] . "adminlib.php";
include $cms['tngpath'] . "personlib.php";

if ($tngconfig['hidedna'] && (!$allow_edit || !$allow_add || $assignedtree)) {
  header("Location: thispagedoesnotexist.html");
  exit;
}
$dnatree = isset($_SESSION["ttree"]) ? $_SESSION["ttree"] : "";
if (empty($_SESSION["ttree"])) {
  $_SESSION["ttree"] = "-x--all--x-";
}

$test_search = isset($_SESSION["tsearch"]) ? $_SESSION["tsearch"] : "";
$test_type = isset($_SESSION["ttype"]) ? $_SESSION["ttype"] : "";
$test_group = isset($_SESSION["tgroup"]) ? $_SESSION["tgroup"] : "";

$compare_selected_atdna_url = getURL("compare_selected_atdna", 1);
$browse_dna_tests_url = getURL("browse_dna_tests", 1) . "tree=" . $dnatree . "&amp;testsearch=" . $test_search . "&amp;test_type=" . $test_type . "&amp;test_group=" . $test_group;

$getperson_url = getURL("getperson", 1);
$familygroup_url = getURL("familygroup", 1);
$show_dna_test_url = getURL("show_dna_test", 1);
$showtree_url = getURL("showtree", 1);

$headline = "{$text['dnatestscompare']}";
$text['dnatestscompare_atdna'] .= $_SESSION["tgroup"] ? ": " . $_SESSION["tgroup"] : ": " . $text['allgroups'];

$flags['tabs'] = $tngconfig['tabs'];
tng_header($text['dnatestscompare_atdna'], $flags);

$comptabs[0] = array(1, $browse_dna_tests_url, $text['dna_tests'], "dnatests");
$innermenu = "";
$innermenu = "<a href=\"https://tng.lythgoes.net/wiki/index.php?title=Compare DNA Tests Results\" target=\"_blank\" class=\"lightlink\">{$text['help']}</a>";
// Y-DNA Tests
$innermenu .= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"browse_dna_tests.php?tree=-x--all--x-&testsearch=&test_type=Y-DNA&test_group=\" class=\"lightlink\">{$admtext['ydna_test']}</a>";
// mtDNA Tests
$innermenu .= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"browse_dna_tests.php?tree=-x--all--x-&testsearch=&test_type=mtDNA&test_group=\" class=\"lightlink\">{$admtext['mtdna_test']}</a>";
// atDNA Tests
$innermenu .= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"browse_dna_tests.php?tree=-x--all--x-&testsearch=&test_type=atDNA&test_group=\" class=\"lightlink\">{$admtext['atdna_test']}</a>";

$menu = doMenu($comptabs, "", $innermenu);
?>
<h2 class="header"><span class="headericon" id="dna-hdr-icon"></span><?php echo $text['dnatestscompare_atdna']; ?></h2>
<br style="clear: left;">
<?php
echo $menu;
if ($_SESSION["ttree"]) {
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
if ($_SESSION["tgroup"]) {
  $admtext['dna_tests'] .= ": " . $_SESSION["tgroup"];
  if ($wherestr) {
    $wherestr .= " AND $dna_tests_table.dna_group_desc = \"{$_SESSION["tgroup"]}\"";
  } else {
    $wherestr = "WHERE $dna_tests_table.dna_group_desc = \"{$_SESSION["tgroup"]}\"";
  }
}

$treestr = $tree ? " ({$text['tree']}: $tree)" : "";
$logstring = "<a href=\"$compare_selected_atdna_url" . "tree=$tree&amp;&amp;testsearch=$test_search\">" . xmlcharacters($text['dnatestscompare_atdna'] . $treestr) . "</a>";
writelog($logstring);
preparebookmark($logstring);

echo "<div class='normal'>\n";

$header = "";
$headerr = $enableminimap ? " data-tablesaw-minimap" : "";
$headerr .= $enablemodeswitch ? " data-tablesaw-mode-switch" : "";

if ($sitever != "standard") {
  if ($tabletype == "toggle") {
    $header = "<table cellpadding=\"3\" cellspacing='1' border=\"0\" width=\"100%\" class=\"tablesaw whiteback normal\" data-tablesaw-mode=\"columntoggle\"{$headerr}>\n";
  } elseif ($tabletype == "stack") {
      $header = "<table cellpadding=\"3\" cellspacing='1' border=\"0\" width=\"100%\" class=\"tablesaw whiteback normal\" data-tablesaw-mode=\"stack\"{$headerr}>\n";
  } elseif ($tabletype == "swipe") {
      $header = "<table cellpadding=\"3\" cellspacing='1' border=\"0\" width=\"100%\" class=\"tablesaw whiteback normal\" data-tablesaw-mode=\"swipe\"{$headerr}>\n";
  }
} else {
    $header = "<table cellpadding=\"3\" cellspacing='1' border=\"0\" class=\"whiteback normal\">";
}
echo $header;
?>

<div class="overflowauto">
  <table cellpadding="0" cellspacing="1" width="100%" class="whiteback normal">
    <thead>
    <tr>
      <?php
          if ($allow_edit || $showtestnumbers) { ?>
              <th colspan="4" class="fieldnameback fieldname center">&nbsp;<?php echo $text['dna_test']; ?>&nbsp;</th>
            <?php
          } else { ?>
              <th colspan="3" class="fieldnameback fieldname center">&nbsp;<?php echo $text['dna_test']; ?>&nbsp;</th>
            <?php
          }
          ?>
            <th colspan="5" class="fieldnameback fieldname center">&nbsp;<?php echo $admtext['largest_segment']; ?>&nbsp;</th>
            <th data-tablesaw-priority="3" colspan="2" class="fieldnameback fieldname center">&nbsp;<?php echo $text['haplogroup']; ?>&nbsp;</th>
            <th data-tablesaw-priority="4" colspan="4" class="fieldnameback fieldname center">&nbsp;<?php echo $text['relationship']; ?>&nbsp;</th>
            <th data-tablesaw-priority="4" class="fieldnameback fieldname center">&nbsp;</th>
        </tr>
        <tr>
            <th data-tablesaw-priority="persist" class="fieldnameback nbrcol fieldname">&nbsp;#&nbsp;</th>

          <?php
          if ($allow_edit || $showtestnumbers) { ?>
              <th data-tablesaw-priority="2" class="fieldnameback fieldname nw">&nbsp;<?php echo $text['test_number']; ?>&nbsp;</th>
            <?php
          }
          ?>
            <th data-tablesaw-priority="1" class="fieldnameback fieldname nw">&nbsp;<?php echo $text['takenby']; ?>&nbsp;</th>
            <th data-tablesaw-priority="3" class="fieldnameback fieldname nw">&nbsp;<?php echo $admtext['vendor']; ?>&nbsp;</th>
            <th data-tablesaw-priority="2" class="fieldnameback fieldname nw">&nbsp;<?php echo $text['chromosome']; ?>&nbsp;</th>
            <th data-tablesaw-priority="2" class="fieldnameback fieldname nw">&nbsp;<?php echo $text['segment_start']; ?>&nbsp;</th>
            <th data-tablesaw-priority="2" class="fieldnameback fieldname nw">&nbsp;<?php echo $text['segment_end']; ?>&nbsp;</th>
            <th data-tablesaw-priority="2" class="fieldnameback fieldname nw">&nbsp;<?php echo $text['centiMorgans']; ?>&nbsp;</th>
            <th data-tablesaw-priority="2" class="fieldnameback fieldname nw">&nbsp;<?php echo $text['snps']; ?>&nbsp;</th>
            <th data-tablesaw-priority="3" class="fieldnameback fieldname nw">&nbsp;<?php echo $text['y_haplogroup']; ?>&nbsp;</th>
            <th data-tablesaw-priority="3" class="fieldnameback fieldname nw">&nbsp;<?php echo $text['mt_haplogroup']; ?>&nbsp;</th>
            <th data-tablesaw-priority="4" class="fieldnameback fieldname nw">&nbsp;<?php echo $text['suggested_relationship']; ?>&nbsp;</th>
            <th data-tablesaw-priority="4" class="fieldnameback fieldname nw">&nbsp;<?php echo $text['actual_relationship']; ?>&nbsp;</th>
            <th data-tablesaw-priority="4" class="fieldnameback fieldname nw">&nbsp;<?php echo $text['mrca']; ?>&nbsp;</th>
            <th data-tablesaw-priority="4" class="fieldnameback fieldname nw">&nbsp;<?php echo $admtext['related_side']; ?>&nbsp;</th>
            <th data-tablesaw-priority="4" class="fieldnameback fieldname nw">&nbsp;<?php echo $text['testgroup']; ?>&nbsp;</th>
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
          $orderby = "chromosome,segment_start,segment_end";
          $query = "SELECT *
	FROM $dna_tests_table WHERE testID=$testID ORDER BY 'chromosome,segment_start,segment_end' ";
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

          echo "<td valign=\"top\" class=\"$databack\">&nbsp;{$row['vendor']}</td>";

          echo "<td valign=\"top\" class=\"$databack\">&nbsp;{$row['chromosome']}</td>";

          echo "<td valign=\"top\" class=\"$databack\">&nbsp;{$row['segment_start']}</td>";

          echo "<td valign=\"top\" class=\"$databack\">&nbsp;{$row['segment_end']}</td>";

          echo "<td valign=\"top\" class=\"$databack\">&nbsp;{$row['centiMorgans']}</td>";

          echo "<td valign=\"top\" class=\"$databack\">&nbsp;{$row['matching_SNPs']}</td>";

          if ($row['ydna_haplogroup']) {
            if ($row['ydna_confirmed']) {
              $ydna_haplogroup = "<span class='confirmed_haplogroup'>" . $row['ydna_haplogroup'] . "</span>";
            } else {
              $ydna_haplogroup = "<span class='predicted_haplogroup'>" . $row['ydna_haplogroup'] . "</span>";
            }
          } else {
            $ydna_haplogroup = "";
          }
          echo "<td valign=\"top\" class=\"$databack\">&nbsp;$ydna_haplogroup</td>";

          if ($row['mtdna_haplogroup']) {
            if ($row['mtdna_confirmed']) {
              $mtdna_haplogroup = "<span class='confirmed_haplogroup'>" . $row['mtdna_haplogroup'] . "</span>";
            } else {
              $mtdna_haplogroup = "<span class='predicted_haplogroup'>" . $row['mtdna_haplogroup'] . "</span>";
            }
          } else {
            $mtdna_haplogroup = "";
          }
          echo "<td valign=\"top\" class=\"$databack\">&nbsp;$mtdna_haplogroup</td>";


          $anc_namestr = "";
          $mrcanc_namestr = "";
          if ($row['MRC_ancestorID']) {
            if ($row['MRC_ancestorID'][0] == "I") {
              $dna_anc_result = getPersonDataPlusDates($row['gedcom'], $row['MRC_ancestorID']);
              $ancrow = tng_fetch_assoc($dna_anc_result);
              $dna_righttree = checktree($ancrow['gedcom']);
              $dna_rightbranch = $dna_righttree ? checkbranch($ancrow['branch']) : false;
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
          echo "<td valign=\"top\" class=\"$databack\">&nbsp;{$row['suggested_relationship']}</td>";

          echo "<td valign=\"top\" class=\"$databack\">&nbsp;{$row['actual_relationship']}</td>";

          echo "<td valign=\"top\" class=\"$databack\">&nbsp;$mrcanc_namestr</td>";

          echo "<td valign=\"top\" class=\"$databack\">&nbsp;{$row['related_side']}</td>";


          $group = $row['dna_group_desc'] ? $row['dna_group_desc'] : $text['none'];
          echo "<td valign=\"top\" class=\"$databack\">$group</td>";
          global $numtrees;
          if (!$assignedtree && ($numtrees > 1)) {
            echo "<td valign=\"top\" class=\"$databack nw\"><a href=\"$showtree_url" . "tree={$row['gedcom']}\">{$row['treename']}</a>&nbsp;</td>";
          }
          echo "</tr>\n";
          $i++;

        }

      }
      if ($result) {
        tng_free_result($result);
      } else {
        echo "No records found.";
      }

      ?>
    </table>
</div>
<br>
<?php
tng_footer("");
?>

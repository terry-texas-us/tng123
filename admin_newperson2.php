<?php
include "begin.php";
include "adminlib.php";
require_once "./admin/trees.php";

$textpart = "people";
include "$mylanguage/admintext.php";

$admin_login = true;
include "checklogin.php";
if (!$allow_add) {
  $message = $admtext['norights'];
  header("Location: admin_login.php?message=" . urlencode($message));
  exit;
}

$treerow = getTree($trees_table, $tree);

if ($father) {
  $query = "SELECT lnprefix, lastname, branch FROM $people_table WHERE gedcom='$tree' AND personID=\"$father\"";
  $result = tng_query($query);
  $row = tng_fetch_assoc($result);
  tng_free_result($result);
} else {
  $row['lastname'] = $row['lnprefix'] = "";
}

function relateSelect($label) {
  global $admtext;

  $fieldname = $label == "father" ? "frel" : "mrel";
  $pout = "<select name=\"$fieldname\">\n";
  $pout .= "<option value=\"\"></option>\n";

  foreach (PARENT_CHILD_RELATIONSHIP_TYPES as $reltype) {
    $pout .= "<option value=\"$reltype\"";
    if ($parent[$fieldname] == $reltype || $parent[$fieldname] == $admtext[$reltype]) {
      $pout .= " selected";
    }
    $pout .= ">{$admtext[$reltype]}</option>\n";
  }
    $pout .= "</select>\n";

    return $pout;
}

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack ajaxwindow" id="newperson">
    <h3 class="subhead"><?php echo $admtext['addnewperson']; ?></h3>

    <form method="post" name="npform"<?php if ($needped) {
        echo " action=\"admin_addperson2.php\"";
    } else {
        echo " action=\"\" onsubmit=\"return saveNewPerson(this);\"";
    } ?> style="margin-top:10px;">
        <table cellpadding="2" class="normal">
            <tr>
                <td valign="top" colspan="2"><strong><?php echo $admtext['prefixpersonid']; ?></strong></td>
            </tr>
            <tr>
                <td><span class="normal"><?php echo $admtext['personid']; ?>:</span></td>
                <td>
                    <input type="text" name="personID" size="10" onblur="this.value=this.value.toUpperCase()">
                    <input type="button" value="<?php echo $admtext['generate']; ?>" onclick="generateID('person',document.npform.personID,document.form1.tree1);">
                    <input type="button" value="<?php echo $admtext['check']; ?>" onclick="checkID(document.npform.personID.value,'person','checkmsg2',document.form1.tree1);">
                    <span id="checkmsg2" class="normal"></span>
                </td>
            </tr>
        </table>
        <table class="normal topmarginsmall">
            <tr>
                <td><?php echo $admtext['firstgivennames']; ?></td>
              <?php
              if ($lnprefixes) {
                echo "<td>{$admtext['lnprefix']}</td>\n";
              }
              ?>
                <td><?php echo $admtext['lastsurname']; ?></td>
            </tr>
            <tr>
                <td><input type="text" name="firstname" id="firstname" size="30"></td>
              <?php
              if ($lnprefixes) {
                echo "<td><input type=\"text\" name=\"lnprefix\" style=\"width:80px;\" value=\"" . $row['lnprefix'] . "\"></td>\n";
              }
              ?>
                <td><input type="text" name="lastname" size="30" value="<?php echo $row['lastname']; ?>"></td>
            </tr>
        </table>
        <table class="normal topmarginsmall">
            <tr>
                <td><?php echo $admtext['sex']; ?></td>
                <td><?php echo $admtext['nickname']; ?></td>
                <td><?php echo $admtext['title']; ?></td>
                <td><?php echo $admtext['prefix']; ?></td>
                <td><?php echo $admtext['suffix']; ?></td>
            </tr>
            <tr>
                <td>
                    <select name="sex">
                        <option value="U"><?php echo $admtext['unknown']; ?></option>
                        <option value="M"<?php if ($gender == 'M') {
                          echo " selected";
                        } ?>><?php echo $admtext['male']; ?></option>
                        <option value="F"<?php if ($gender == 'F') {
                          echo " selected";
                        } ?>><?php echo $admtext['female']; ?></option>
                    </select>
                </td>
                <td><input type="text" name="nickname" class="veryshortfield"></td>
                <td><input type="text" name="title" class="veryshortfield"></td>
                <td><input type="text" name="prefix" class="veryshortfield"></td>
                <td><input type="text" name="suffix" class="veryshortfield"></td>
            </tr>
        </table>

        <table class="normal topbuffer">
            <tr>
                <td class="nw">
                    <input type="checkbox" name="living" value="1" checked="checked"> <?php echo $admtext['living']; ?>&nbsp;&nbsp;
                    <input type="checkbox" name="private" value="1"> <?php echo $admtext['text_private']; ?>
                </td>
                <td class="spaceonleft"><?php echo $admtext['tree'] . ": " . $treerow['treename']; ?></td>
                <td class="spaceonleft"><?php echo $admtext['branch'] . ": "; ?>
                  <?php
                  $query = "SELECT branch, description FROM $branches_table WHERE gedcom = '$tree' ORDER BY description";
                  $branchresult = tng_query($query);
                  $numbranches = tng_num_rows($branchresult);
                  $branchlist = explode(",", $row['branch']);

                  $descriptions = array();
                  $assdesc = "";
                  $options = "";
                  while ($branchrow = tng_fetch_assoc($branchresult)) {
                    $options .= "	<option value=\"{$branchrow['branch']}\">{$branchrow['description']}</option>\n";
                    if ($branchrow['branch'] == $assignedbranch) {
                      $assdesc = $branchrow['description'];
                    }
                  }
                  echo "<span id=\"branchlist2\"></span>";
                  if (!$assignedbranch) {
                  if ($numbranches > 8) {
                    $select = $admtext['scrollbranch'] . "<br>";
                  }
                  $select .= "<select name=\"branch[]\" id=\"branch2\" multiple size=\"8\">\n";
                  $select .= "	<option value=\"\"";
                  if ($row['branch'] == "") {
                    $select .= " selected";
                  }
                  $select .= ">{$admtext['nobranch']}</option>\n";

                  $select .= "$options</select>\n";
                  echo " &nbsp;<span class=\"nw\">(<a href=\"#\" onclick=\"showBranchEdit('branchedit2'); quitBranchEdit('branchedit2'); return false;\"><img src=\"img/ArrowDown.gif\" style=\"margin-left:-4px;margin-right:-2px;\">" . $admtext['edit'] . "</a> )</span><br>";
                  ?>
                    <div id="branchedit2" class="lightback pad5" style="position:absolute;display:none;" onmouseover="clearTimeout(branchtimer);" onmouseout="closeBranchEdit('branch2','branchedit2','branchlist2');">
                      <?php
                      echo $select;
                      echo "</div>\n";
                      }
                      else {
                        echo "<input type=\"hidden\" name=\"branch\" value=\"$assignedbranch\">$assdesc ($assignedbranch)";
                      }
                      ?>
                </td>
            </tr>
        </table>

        <p class="normal topmarginsmall" style="margin-bottom:8px;"><?php echo $admtext['datenote']; ?></p>
        <table class="normal">
            <tr>
                <td>&nbsp;</td>
                <td><?php echo $admtext['date']; ?></td>
                <td><?php echo $admtext['place']; ?></td>
                <td colspan="4">&nbsp;</td>
            </tr>
            <?php
            $noclass = true;
            $currentform = "document.npform";
            echo showEventRow('birthdate', 'birthplace', 'BIRT', '');
            if (!$tngconfig['hidechr']) {
                echo showEventRow('altbirthdate', 'altbirthplace', 'CHR', '');
            }
            echo showEventRow('deathdate', 'deathplace', 'DEAT', '');
            echo showEventRow('burialdate', 'burialplace', 'BURI', '');
            echo "<tr>";
            echo "<td></td>";
            echo "<td colspan=\"3\"><input type=\"checkbox\" name=\"burialtype\" id=\"burialtype\" value='1'> <label for=\"burialtype\">{$admtext['cremated']}</label></td>";
            echo "</tr>\n";
            if (determineLDSRights()) {
                echo showEventRow('baptdate', 'baptplace', 'BAPL', '');
                echo showEventRow('confdate', 'confplace', 'CONL', '');
                echo showEventRow('initdate', 'initplace', 'INIT', '');
                echo showEventRow('endldate', 'endlplace', 'ENDL', '');
            }
            ?>
        </table>

        <?php
      if ($type == "child") {
        echo "<br>\n";
        echo $admtext['relationship'] . " ({$admtext['father']}): " . relateSelect("father") . "&nbsp;&nbsp;";
        echo $admtext['relationship'] . " ({$admtext['mother']}): " . relateSelect("mother");
      }
      ?>

        <input type="hidden" name="tree" value="<?php echo $tree; ?>">
        <input type="hidden" name="needped" value="<?php echo $needped; ?>">
        <input type="hidden" name="familyID" value="<?php echo $familyID; ?>">
      <?php if ($type == "") {
        $type = "text";
      } ?>
        <input type="hidden" name="type" value="<?php echo $type; ?>">
      <?php
      if (!$lnprefixes) {
        echo "<input type=\"hidden\" name=\"lnprefix\" value=\"\">";
      }
      ?>
        <p class="normal" style="margin-top:15px;margin-left:4px;"><input type="submit" name="submit" value="<?php echo $admtext['save']; ?>"> &nbsp; <strong><?php echo $admtext['pevslater2']; ?></strong></p>
        <div id="errormsg" class="red" style="display:none;"></div>
    </form>
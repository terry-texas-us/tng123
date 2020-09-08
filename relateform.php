<?php
$textpart = "relate";
include "tng_begin.php";

include $subroot . "pedconfig.php";

$relatepersonID = $_SESSION['relatepersonID'];
$relatetreeID = $_SESSION['relatetreeID'];

$result = getPersonDataPlusDates($tree, $primaryID);
if ($result) {
  $row = tng_fetch_assoc($result);
  $righttree = checktree($tree);
  $rightbranch = checkbranch($row['branch']);
  $rights = determineLivingPrivateRights($row, $righttree, $rightbranch);
  $row['allow_living'] = $rights['living'];
  $row['allow_private'] = $rights['private'];
  if ($rights['both']) {
    $birthdate = "";
    if ($row['birthdate']) {
      $birthdate = "{$text['birthabbr']} " . displayDate($row['birthdate']);
    } else {
      if ($row['altbirthdate']) {
        $birthdate = "{$text['chrabbr']} " . displayDate($row['altbirthdate']);
      }
    }
    if ($birthdate) {
      $birthdate = "($birthdate)";
    }
    $namestrplus = " $birthdate - $primaryID";
  } else {
    $namestrplus = " - $primaryID";
  }
  $namestr = getName($row);

  $treeResult = getTreeSimple($tree);
  $treerow = tng_fetch_assoc($treeResult);
  $disallowgedcreate = $treerow['disallowgedcreate'];
  tng_free_result($treeResult);

  tng_free_result($result);
}

$personID = preg_replace("/[^A-Za-z0-9_\-. ]/", '', $primaryID);
$flags['tabs'] = $tngconfig['tabs'];
$flags['scripting'] = "<script type=\"text/javascript\" src=\"{$cms['tngpath']}js/selectutils.js\"></script>\n";
tng_header($text['relcalc'], $flags);

$photostr = showSmallPhoto($primaryID, $namestr, $rights['both'], 0, false, $row['sex']);
echo tng_DrawHeading($photostr, $namestr, getYears($row));

$innermenu = "&nbsp; \n";

echo tng_menu("I", "relate", $primaryID, $innermenu);

$namestr .= $namestrplus;

$findpersonform_url = getURL("findpersonform", 1);
echo getFORM("relationship", "get", "form1", "form1", "$('calcbtn').className='fieldnamebacksave';");

$maxupgen = $pedigree['maxupgen'] ? $pedigree['maxupgen'] : 15;
$newstr = preg_replace("/xxx/", $maxupgen, $text['findrelinstr']);
?>
  <span class="subhead"><strong><?php echo $text['findrel']; ?></strong></span><br>
  <p><span class="normal"><?php echo $newstr; ?></span></p>
  <table class="normal">
    <tr>
      <td valign="top">
        <table>
          <tr>
            <td><span class="normal"><strong><?php echo $text['person1']; ?> </strong></span></td>
            <td>
              <div id="name1" class="normal"><?php echo $namestr; ?></div>
            </td>
          </tr>
          <tr>
            <td><span class="normal"><?php echo $text['changeto']; ?> </span></td>
            <td><span class="normal">
						<input type="text" name="altprimarypersonID" id="altprimarypersonID" size="10">  <input type="button" name="find1" value="<?php echo $text['find']; ?>" onclick="findItem('I','altprimarypersonID','name1','<?php echo $tree; ?>');">
					</span>
            </td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td><span class="normal"><strong><?php echo $text['person2']; ?> </strong></span></td>
            <td>
              <?php
                          if ($relatepersonID && $relatetreeID == $tree) {
                            $query = "SELECT firstname, lastname, lnprefix, prefix, suffix, nameorder, living, private, branch, birthdate, altbirthdate FROM $people_table WHERE personID = \"$relatepersonID\" AND gedcom = '$tree'";
                            $result2 = tng_query($query);
                            if ($result2) {
                              $row2 = tng_fetch_assoc($result2);
                              $rights2 = determineLivingPrivateRights($row2, $righttree);
                              $row2['allow_living'] = $rights2['living'];
                              $row2['allow_private'] = $rights2['private'];
                              if ($row2['allow_living']) {
                                $birthdate = $row2['birthdate'] ? $row2['birthdate'] : $row2['altbirthdate'];
                                $birthdate = " ($birthdate)";
                              } else {
                                $birthdate = "";
                              }
                              $namestr2 = getName($row2) . "$birthdate - $relatepersonID";
                              tng_free_result($result2);
                            }
                          }
              echo "<div id=\"name2\" class=\"normal\">$namestr2</div><input type=\"hidden\" name=\"savedpersonID\" value=\"$relatepersonID\"></td></tr>\n";
              echo "<tr><td><span class=\"normal\">{$text['changeto']} </span></td><td>";
              ?>
              <input type="text" name="secondpersonID" id="secondpersonID" size="10"> <input type="button" name="find2" value="<?php echo $text['find']; ?>" onclick="findItem('I','secondpersonID','name2','<?php echo $tree; ?>');">
            </td>
          </tr>
        </table>
      </td>
      <td valign="top">
        <div class="searchsidebar">
          <table>
            <tr>
              <td><?php echo $text['maxrels']; ?>:</td>
              <td valign="bottom">
                                <select name="maxrels">
                                  <?php
                                  $initrels = $pedigree['initrels'] ? $pedigree['initrels'] : 1;
                                  $maxrels = $pedigree['maxrels'] ? $pedigree['maxrels'] : 15;
                                  $dorels = $dorels ? $dorels : $initrels;
                                  for ($i = 1; $i <= $maxrels; $i++) {
                                    echo "<option value=\"$i\"";
                                    if ($i == $dorels) {
                                      echo " selected=\"selected\"";
                                    }
                                    echo ">$i</option>\n";
                                  }
                                  ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td><?php echo $text['dospouses']; ?>:&nbsp;</td>
                            <td valign="bottom">
                                <select name="disallowspouses">
                                  <?php
                                  $dospouses = $dospouses ? $dospouses : 1;
                                  echo "<option value=\"0\"";
                                  if ($dospouses) {
                                    echo " selected=\"selected\"";
                                  }
                                  echo ">{$admtext['yes']}</option>\n";
                                  echo "<option value=\"1\"";
                                  if (!$dospouses) {
                                    echo " selected=\"selected\"";
                                  }
                                  echo ">{$admtext['no']}</option>\n";
                                  ?>
                                </select> <?php //echo $text['sometimes']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td><?php echo $text['gencheck']; ?>:</td>
                            <td valign="bottom">
                                <select name="generations">
                                  <?php
                                  $dogens = $dogens ? $dogens : $pedigree['maxupgen'];
                                  $maxgens = $pedigree['maxupgen'] ? $pedigree['maxupgen'] : 15;
                                  for ($i = 1; $i <= $maxgens; $i++) {
                                    echo "<option value=\"$i\"";
                                    if ($i == $dogens) {
                                      echo " selected=\"selected\"";
                                    }
                                    echo ">$i</option>\n";
                                  }
                                  ?>
                                </select> <?php //echo $text['sometimes']; ?>
                            </td>
                        </tr>
          </table>
        </div>
      </td>
    </tr>
  </table>
  <br>
  <input type="hidden" name="tree" value="<?php echo $tree; ?>">
  <input type="hidden" name="primarypersonID" id="primarypersonID" value="<?php echo $primaryID; ?>">
  <input type="submit" value="<?php echo $text['calculate']; ?>" id="calcbtn" class="btn" <?php if (!$relatepersonID) {
    echo "onclick=\"if( form1.secondpersonID.value.length == 0 ) {alert('{$text['select2inds']}'); return false;}\"";
  } ?> >
  <br><br>
  </form>
<?php
tng_footer("");
?>
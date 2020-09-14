<?php
include "begin.php";
include "adminlib.php";
$textpart = "people";
include "$mylanguage/admintext.php";

$admin_login = true;
include "checklogin.php";
include "version.php";
if (!$allow_add) {
  $message = $admtext['norights'];
  header("Location: admin_login.php?message=" . urlencode($message));
  exit;
}

if ($assignedtree) {
  $wherestr = "WHERE gedcom = \"$assignedtree\"";
  $firsttree = $assignedtree;
} else {
  $wherestr = "";
  $firsttree = isset($_COOKIE['tng_tree']) ? $_COOKIE['tng_tree'] : "";
}
$query = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";
$result = tng_query($query);

$helplang = findhelp("people_help.php");

$revstar = checkReview("I");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['addnewperson'], $flags);
include_once "eventlib.php";
include_once "eventlib_js.php";
?>
<script type="text/javascript">
    var persfamID = "";
    var allow_cites = false;
    var allow_notes = false;

    function toggleAll(display) {
        toggleSection('names', 'plus0', display);
        toggleSection('events', 'plus1', display);
        return false;
    }

    <?php
    if (!$assignedtree && !$assignedbranch) {
      include "branchlibjs.php";
    } else {
      $query = "SELECT description FROM $branches_table WHERE gedcom = \"$assignedtree\" AND branch = \"$assignedbranch\" ORDER BY description";
      $branchresult = tng_query($query);
      $branch = tng_fetch_assoc($branchresult);
      $dispname = $branch['description'];
      $swapbranches = "";
    }
    ?>

    function validateForm() {
        let rval = true;

        document.form1.personID.value = TrimString(document.form1.personID.value);
        if (document.form1.personID.value.length == 0) {
            alert("<?php echo $admtext['enterpersonid']; ?>");
            rval = false;
        }
        return rval;
    }
</script>
<script src="js/admin.js"></script>
</head>

<body background="img/background.gif" onload="generateID('person',document.form1.personID,document.form1.tree1);">

<?php
$peopletabs[0] = array(1, "admin_people.php", $admtext['search'], "findperson");
$peopletabs[1] = array($allow_add, "admin_newperson.php", $admtext['addnew'], "addperson");
$peopletabs[2] = array($allow_edit, "admin_findreview.php?type=I", $admtext['review'] . $revstar, "review");
$peopletabs[3] = array($allow_edit && $allow_delete, "admin_merge.php", $admtext['merge'], "merge");
$innermenu = "<a href=\"#\" onclick=\"return openHelp('$helplang/people_help.php#add');\" class=\"lightlink\">{$admtext['help']}</a>";
$innermenu .= " &nbsp;|&nbsp; <a href=\"#\" class=\"lightlink\" onClick=\"return toggleAll('on');\">{$text['expandall']}</a> &nbsp;|&nbsp; <a href=\"#\" class=\"lightlink\" onClick=\"return toggleAll('off');\">{$text['collapseall']}</a>";
$menu = doMenu($peopletabs, "addperson", $innermenu);
if (!isset($message)) {
  $message = '';
}
echo displayHeadline($admtext['people'] . " &gt;&gt; " . $admtext['addnewperson'], "img/people_icon.gif", $menu, $message);
?>

<form action="admin_addperson.php" method="post" name="form1" onSubmit="return validateForm();">
  <table width="100%" cellpadding="10" cellspacing="2" class="lightback">
    <tr class="databack">
      <td class="tngshadow">
        <table class="normal">
          <tr>
            <td valign="top" colspan="2"><span class="normal"><strong><?php echo $admtext['prefixpersonid']; ?></strong></span></td>
                    </tr>
                    <tr>
                        <td><span class="normal"><?php echo $admtext['tree']; ?>:</span></td>
                        <td>
                            <select name="tree1" id="gedcom" onChange="<?php echo $swapbranches; ?> generateID('person',document.form1.personID,document.form1.tree1);tree=this.options[this.selectedIndex].value;">
                              <?php
                              while ($row = tng_fetch_assoc($result)) {
                                echo "		<option value=\"{$row['gedcom']}\"";
                                if ($firsttree == $row['gedcom']) {
                                  echo " selected=\"selected\"";
                                }
                                echo ">{$row['treename']}</option>\n";
                              }
                              ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="normal"><?php echo $admtext['branch']; ?>:</span></td>
                        <td style="height:2em;">
                          <?php
                          $query = "SELECT branch, description FROM $branches_table WHERE gedcom = \"$firsttree\" ORDER BY description";
                          $branchresult = tng_query($query);
                          $numbranches = tng_num_rows($branchresult);

                          $descriptions = array();
                          $assdesc = "";
                          $options = "";
                          while ($branchrow = tng_fetch_assoc($branchresult)) {
                            $options .= "	<option value=\"{$branchrow['branch']}\">{$branchrow['description']}</option>\n";
                            if ($branchrow['branch'] == $assignedbranch) {
                              $assdesc = $branchrow['description'];
                            }
                          }
                          echo "<span id=\"branchlist\"></span>";
                          if (!$assignedbranch) {
                          if ($numbranches > 8) {
                            $select = $admtext['scrollbranch'] . "<br>";
                          }
                          $select .= "<select name=\"branch[]\" id=\"branch\" multiple size=\"8\">\n";
                          $select .= "	<option value=\"\"";
                          if ($row['branch'] == "") {
                            $select .= " selected";
                          }
                          $select .= ">{$admtext['nobranch']}</option>\n";

                          $select .= "$options</select>\n";
                          echo " &nbsp;<span class=\"nw\">(<a href=\"#\" onclick=\"showBranchEdit('branchedit'); quitBranchEdit('branchedit'); return false;\"><img src=\"img/ArrowDown.gif\" style=\"margin-left:-4px;margin-right:-2px;\">" . $admtext['edit'] . "</a> )</span><br>";
                          ?>
                            <div id="branchedit" class="lightback pad5" style="position:absolute;display:none;" onmouseover="clearTimeout(branchtimer);" onmouseout="closeBranchEdit('branch','branchedit','branchlist');">
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
                    <tr>
                        <td><span class="normal"><?php echo $admtext['personid']; ?>:</span></td>
                        <td>
                            <input type="text" name="personID" size="10" onblur="this.value=this.value.toUpperCase()">
                            <input type="button" value="<?php echo $admtext['generate']; ?>" onclick="generateID('person',document.form1.personID,document.form1.tree1);">
                            <input type="submit" name="submit" value="<?php echo $admtext['lockid']; ?>" onclick="document.form1.newfamily['2'].checked = true;">
                            <input type="button" value="<?php echo $admtext['check']; ?>" onclick="checkID(document.form1.personID.value,'person','checkmsg',document.form1.tree1);">
                            <span id="checkmsg" class="normal"></span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="databack">
            <td class="tngshadow">
              <?php echo displayToggle("plus0", 1, "names", $admtext['name'], ""); ?>

                <div id="names">
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
                            <td><input type="text" name="firstname" size="30"></td>
                          <?php
                          if ($lnprefixes) {
                            echo "<td><input type=\"text\" name=\"lnprefix\" style=\"width:80px;\"></td>\n";
                          }
                          ?>
                            <td><input type="text" name="lastname" size="30"></td>
                        </tr>
                    </table>
                    <table class="normal topmarginsmall">
                        <tr>
                            <td><?php echo $admtext['sex']; ?></td>
                            <td><?php echo $admtext['nickname']; ?></td>
                            <td><?php echo $admtext['title']; ?></td>
                            <td><?php echo $admtext['prefix']; ?></td>
                            <td><?php echo $admtext['suffix']; ?></td>
                            <td><?php echo $admtext['nameorder']; ?></td>
                        </tr>
                        <tr>
                            <td>
                                <select name="sex">
                                    <option value="U"><?php echo $admtext['unknown']; ?></option>
                                    <option value="M"><?php echo $admtext['male']; ?></option>
                                    <option value="F"><?php echo $admtext['female']; ?></option>
                                </select>
                            </td>
                            <td><input type="text" name="nickname" class="veryshortfield"></td>
                            <td><input type="text" name="title" class="veryshortfield"></td>
                            <td><input type="text" name="prefix" class="veryshortfield"></td>
                            <td><input type="text" name="suffix" class="veryshortfield"></td>
                            <td>
                                <select name="pnameorder">
                                    <option value="0"><?php echo $admtext['default']; ?></option>
                                    <option value="1"><?php echo $admtext['western']; ?></option>
                                    <option value="2"><?php echo $admtext['oriental']; ?></option>
                                    <option value="3"><?php echo $admtext['lnfirst']; ?></option>
                                </select>
                            </td>
                        </tr>
                    </table>

                    <table class="normal topbuffer">
                        <tr>
                            <td class="nw">
                                <input type="checkbox" name="living" value="1" checked="checked"> <?php echo $admtext['living']; ?>&nbsp;&nbsp;
                                <input type="checkbox" name="private" value="1"> <?php echo $admtext['text_private']; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
        <tr class="databack">
            <td class="tngshadow">
              <?php echo displayToggle("plus1", 1, "events", $admtext['events'], ""); ?>

                <div id="events">
                    <p class="normal topmarginsmall"><?php echo $admtext['datenote']; ?></p>
                    <table class="normal">
                        <tr>
                            <td>&nbsp;</td>
                            <td><?php echo $admtext['date']; ?></td>
                            <td><?php echo $admtext['place']; ?></td>
                            <td colspan="4">&nbsp;</td>
                        </tr>
                        <?php
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
                        if ($allow_lds) {
                            echo showEventRow('baptdate', 'baptplace', 'BAPL', '');
                            echo showEventRow('confdate', 'confplace', 'CONL', '');
                            echo showEventRow('initdate', 'initplace', 'INIT', '');
                            echo showEventRow('endldate', 'endlplace', 'ENDL', '');
                        }
                        ?>
                    </table>
                </div>
            </td>
        </tr>
        <tr class="databack">
            <td class="tngshadow">
                <p class="normal"><strong><?php echo $admtext['pevslater']; ?></strong></p>
                <input type="hidden" value="<?php echo "$cw"; /*stands for "close window" */ ?>" name="cw">
              <?php
              if (!$lnprefixes) {
                echo "<input type=\"hidden\" name=\"lnprefix\" value=\"\">";
              }
              ?>
                <input type="submit" class="btn" name="save" accesskey="s" value="<?php echo $admtext['savecont']; ?>">
            </td>
        </tr>

  </table>
</form>

<script type="text/javascript">
    <?php
    echo $swapbranches;
    echo "tree = \"$firsttree\";\n";
    ?>
</script>

<?php echo "<div align=\"right\"><span class='normal'>$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
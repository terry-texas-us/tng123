<?php
include "begin.php";
include "adminlib.php";
$textpart = "eventtypes";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
$tng_search_eventtypes = $_SESSION['tng_search_eventtypes'] = 1;
if ($newsearch) {
  $exptime = 05;
  $searchstring = stripslashes(trim($searchstring));
  setcookie("tng_search_eventtypes_post[search]", $searchstring, $exptime);
  setcookie("tng_search_eventtypes_post[etype]", $etype, $exptime);
  setcookie("tng_search_eventtypes_post[stype]", $stype, $exptime);
  setcookie("tng_search_eventtypes_post[onimport]", $onimport, $exptime);
  setcookie("tng_search_eventtypes_post[tngpage]", 1, $exptime);
  setcookie("tng_search_eventtypes_post[offset]", 0, $exptime);
} else {
  if (!$searchstring) {
    $searchstring = stripslashes($_COOKIE['tng_search_eventtypes_post']['search']);
  }
  if (!$etype) {
    $etype = $_COOKIE['tng_search_eventtypes_post']['etype'];
  }
  if (!$stype) {
    $stype = $_COOKIE['tng_search_eventtypes_post']['stype'];
  }
  if (!$onimport) {
    $onimport = $_COOKIE['tng_search_eventtypes_post']['onimport'];
  }
  if (!isset($offset)) {
    $tngpage = $_COOKIE['tng_search_eventtypes_post']['tngpage'];
    $offset = $_COOKIE['tng_search_eventtypes_post']['offset'];
  } else {
    $exptime = 0;
    setcookie("tng_search_eventtypes_post[tngpage]", $tngpage, $exptime);
    setcookie("tng_search_eventtypes_post[offset]", $offset, $exptime);
  }
}

if ($offset) {
  $offsetplus = $offset + 1;
  $newoffset = "$offset, ";
} else {
  $offsetplus = 1;
  $newoffset = "";
  $tngpage = 1;
}

$wherestr = $searchstring ? "(tag LIKE \"%$searchstring%\" OR description LIKE \"%$searchstring%\" OR display LIKE \"%$searchstring%\")" : "";
if ($etype) {
  $wherestr .= $wherestr ? " AND type = \"$etype\"" : "type = \"$etype\"";
}
if ($onimport || $onimport === "0") {
  $wherestr .= $wherestr ? " AND keep = \"$onimport\"" : "keep = \"$onimport\"";
}
if ($wherestr) {
  $wherestr = "WHERE $wherestr";
}
$eventsort = $stype == "E" ? "total_events DESC, " : "";

$query = "SELECT $eventtypes_table.eventtypeID, tag, description, display, type, keep, collapse, ordernum, count(eventID) as total_events 
	FROM $eventtypes_table LEFT JOIN $events_table on $eventtypes_table.eventtypeID = $events_table.eventtypeID 
	$wherestr GROUP BY eventtypeID ORDER BY {$eventsort}tag, description LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);

$numrows = tng_num_rows($result);
if ($numrows == $maxsearchresults || $offsetplus > 1) {
  $query = "SELECT count(eventtypeID) as ecount FROM $eventtypes_table $wherestr";
  $result2 = tng_query($query);
  $row = tng_fetch_assoc($result2);
  $totrows = $row['ecount'];
  tng_free_result($result2);
} else {
  $totrows = $numrows;
}

$helplang = findhelp("eventtypes_help.php");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['eventtypes'], $flags);
?>
<script type="text/javascript">
    function confirmDelete(ID) {
        if (confirm('<?php echo $admtext['confdeleteevtype']; ?>'))
            deleteIt('eventtype', ID);
        return false;
    }
</script>
<script type="text/javascript" src="js/admin.js"></script>
</head>

<body background="img/background.gif">

<?php
$evtabs['0'] = array(1, "admin_eventtypes.php", $admtext['search'], "findevent");
$evtabs['1'] = array($allow_add, "admin_neweventtype.php", $admtext['addnew'], "addevent");
$innermenu = "<a href=\"#\" onclick=\"return openHelp('$helplang/eventtypes_help.php#modify');\" class=\"lightlink\">{$admtext['help']}</a>";
$menu = doMenu($evtabs, "findevent", $innermenu);
echo displayHeadline($admtext['customeventtypes'], "img/customeventtypes_icon.gif", $menu, $message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <div class="normal">

                <form action="admin_eventtypes.php" name="form1">
                    <table class="normal">
                        <tr>
                            <td><?php echo $admtext['searchfor']; ?>:</td>
                            <td><input type="text" name="searchstring" value="<?php echo $searchstring; ?>" class="longfield"></td>
                            <td>
                                <input type="submit" name="submit" value="<?php echo $admtext['search']; ?>" class="aligntop">
                                <input type="submit" name="submit" value="<?php echo $admtext['reset']; ?>" onClick="document.form1.searchstring.value=''; document.form1.etype.selectedIndex=0; document.form1.onimport['2'].checked=true;" class="aligntop">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['assocwith']; ?>:</td>
                            <td>
                                <select name="etype">
                                    <option value=""><?php echo $admtext['all']; ?></option>
                                    <option value="I"<?php if ($etype == "I") {
                                      echo " selected";
                                    } ?>><?php echo $admtext['individual']; ?></option>
                                    <option value="F"<?php if ($etype == "F") {
                                      echo " selected";
                                    } ?>><?php echo $admtext['family']; ?></option>
                                    <option value="S"<?php if ($etype == "S") {
                                      echo " selected";
                                    } ?>><?php echo $admtext['source']; ?></option>
                                    <option value="R"<?php if ($etype == "R") {
                                      echo " selected";
                                    } ?>><?php echo $admtext['repository']; ?></option>
                                </select> &nbsp;
                              <?php echo $admtext['sortby']; ?>:
                                <select name="stype">
                                    <option value="T"<?php if (!$stype || $stype == "T") {
                                      echo " selected";
                                    } ?>><?php echo $admtext['tag']; ?></option>
                                    <option value="E"<?php if ($stype == "E") {
                                      echo " selected";
                                    } ?>><?php echo $admtext['events']; ?></option>
                                </select>
                            </td>
                            <td>
                                <input type="radio" name="onimport" value="1"<?php if ($onimport) {
                                  echo " checked";
                                } ?>> <?php echo $admtext['accept']; ?>
                                <input type="radio" name="onimport" value="0"<?php if ($onimport === "0") {
                                  echo " checked";
                                } ?>> <?php echo $admtext['ignore']; ?>
                                <input type="radio" name="onimport" value=""<?php if ($onimport === NULL || $onimport === "") {
                                  echo " checked";
                                } ?>> <?php echo $admtext['all']; ?>
                            </td>
                        </tr>
                    </table>

                  <input type="hidden" name="findeventtype" value="1"><input type="hidden" name="newsearch" value="1">
                </form>
              <br>

              <?php
              $numrowsplus = $numrows + $offset;
              if (!$numrowsplus) {
                $offsetplus = 0;
              }
              echo displayListLocation($offsetplus, $numrowsplus, $totrows);
              $pagenav = get_browseitems_nav($totrows, "admin_eventtypes.php?searchstring=$searchstring&amp;etype=$etype&amp;stype=$stype&amp;onimport=$onimport&amp;offset", $maxsearchresults, 5);
              echo " &nbsp; <span class=\"adminnav\">$pagenav</span></p>";
              ?>
                <form action="admin_updateselectedeventtypes.php" method="post" name="form2">
                    <p>
                        <input type="button" name="selectall" value="<?php echo $admtext['selectall']; ?>" onClick="toggleAll(1);">
                        <input type="button" name="clearall" value="<?php echo $admtext['clearall']; ?>" onClick="toggleAll(0);">&nbsp;&nbsp;
                      <?php
                      if ($allow_delete) {
                        ?>
                          <input type="submit" name="cetaction" value="<?php echo $admtext['deleteselected']; ?>" onClick="return confirm('<?php echo $admtext['confdeleterecs']; ?>');">
                        <?php
                      }
                      if ($allow_edit) {
                      ?>
                        <input type="submit" name="cetaction" value="<?php echo $admtext['acceptselected']; ?>">
                        <input type="submit" name="cetaction" value="<?php echo $admtext['ignoreselected']; ?>">
                        <input type="submit" name="cetaction" value="<?php echo $admtext['collapseselected']; ?>">
                        <input type="submit" name="cetaction" value="<?php echo $admtext['expselected']; ?>">
                    </p>
                  <?php
                  }
                  ?>

                    <table cellpadding="3" cellspacing="1" border="0" class="normal">
                        <tr>
                            <td class="fieldnameback fieldname">&nbsp;<b><?php echo $admtext['action']; ?></b>&nbsp;</td>
                          <?php
                          if ($allow_delete || $allow_edit) {
                            ?>
                              <td class="fieldnameback fieldname">&nbsp;<b><?php echo $admtext['select']; ?></b>&nbsp;</td>
                            <?php
                          }
                          ?>
                            <td class="fieldnameback fieldname">&nbsp;<b><?php echo $admtext['tag']; ?></b>&nbsp;</td>
                            <td class="fieldnameback fieldname">&nbsp;<b><?php echo $admtext['typedescription']; ?></b>&nbsp;</td>
                            <td class="fieldnameback fieldname">&nbsp;<b><?php echo $admtext['display']; ?></b>&nbsp;</td>
                            <td class="fieldnameback fieldname">&nbsp;<b><?php echo $admtext['orderpound']; ?></b>&nbsp;</td>
                            <td class="fieldnameback fieldname">&nbsp;<b><?php echo $admtext['indfam']; ?></b>&nbsp;</td>
                            <td class="fieldnameback fieldname">&nbsp;<b><?php echo $admtext['onimport']; ?></b>&nbsp;</td>
                            <td class="fieldnameback fieldname">&nbsp;<b><?php echo $admtext['collapse']; ?></b>&nbsp;</td>
                            <td class="fieldnameback fieldname">&nbsp;<b><?php echo $admtext['events']; ?></b>&nbsp;</td>
                        </tr>

                      <?php
                      if ($numrows) {
                      $actionstr = "";
                      if ($allow_edit) {
                        $actionstr .= "<a href=\"admin_editeventtype.php?eventtypeID=xxx\" title=\"{$admtext['edit']}\" class=\"smallicon admin-edit-icon\"></a>";
                      }
                      if ($allow_delete) {
                        $actionstr .= "<a href=\"#\" onClick=\"return confirmDelete('xxx');\" title=\"{$admtext['text_delete']}\" class=\"smallicon admin-delete-icon\"></a>";
                      }

                      while ($row = tng_fetch_assoc($result)) {
                        $keep = $row['keep'] ? $admtext['accept'] : $admtext['ignore'];
                        $collapse = $row['collapse'] ? $admtext['yes'] : $admtext['no'];
                        switch ($row['type']) {
                          case "I":
                            $type = $admtext['individual'];
                            break;
                          case "F":
                            $type = $admtext['family'];
                            break;
                          case "S":
                            $type = $admtext['source'];
                            break;
                          case "R":
                            $type = $admtext['repository'];
                            break;
                        }
                        $dispvalues = explode("|", $row['display']);
                        $numvalues = count($dispvalues);
                        if ($numvalues > 1) {
                          $displayval = "";
                          for ($i = 0; $i < $numvalues; $i += 2) {
                            $lang = $dispvalues[$i];
                            if ($mylanguage == $languages_path . $lang) {
                              $displayval = $dispvalues[$i + 1];
                              break;
                            }
                          }
                        } else {
                          $displayval = $row['display'];
                        }
                        $newactionstr = preg_replace("/xxx/", $row['eventtypeID'], $actionstr);
                        echo "<tr id=\"row_{$row['eventtypeID']}\"><td class=\"lightback\"><div class=\"action-btns2\">$newactionstr</div></td>\n";
                        if ($allow_delete || $allow_edit) {
                          echo "<td class=\"lightback\" align=\"center\"><input type=\"checkbox\" name=\"et{$row['eventtypeID']}\" value=\"1\"></td>";
                        }
                        echo "<td class=\"lightback\">&nbsp;{$row['tag']}&nbsp;</td><td class=\"lightback\">&nbsp;{$row['description']}&nbsp;</td><td class=\"lightback\">&nbsp;$displayval&nbsp;</td>";
                        echo "<td class=\"lightback\">{$row['ordernum']}</td><td class=\"lightback\">&nbsp;$type&nbsp;</td><td class=\"lightback\">&nbsp;$keep&nbsp;</td><td class=\"lightback\">&nbsp;$collapse&nbsp;</td>";
                        echo "<td class=\"lightback\" style=\"text-align:right\">&nbsp;" . number_format($row['total_events']) . "&nbsp;</td>";
                        echo "</tr>\n";
                      }
                      ?>
                    </table>
                <?php
                echo displayListLocation($offsetplus, $numrowsplus, $totrows);
                echo " &nbsp; <span class=\"adminnav\">$pagenav</span></p>";
                }
                else {
                  echo "</table>\n" . $admtext['norecords'];
                }
                tng_free_result($result);
                ?>
                </form>

            </div>
        </td>
    </tr>

</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
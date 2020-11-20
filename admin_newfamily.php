<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";

if (!$allow_add) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

if ($child) {
    $newperson = $child;
} else {
    if ($husband) {
        $newperson = $husband;
    } else {
        if ($wife) {
            $newperson = $wife;
        } else {
            $newperson = "";
        }
    }
}

if ($newperson) {
    $query = "SELECT personID, firstname, lnprefix, lastname, prefix, suffix, nameorder, living, private, branch, gedcom FROM $people_table WHERE personID = \"$newperson\" AND gedcom = '$tree'";
    $result = tng_query($query);
    $newpersonrow = tng_fetch_assoc($result);

    $righttree = checktree($tree);
    $rightbranch = $righttree ? checkbranch($newpersonrow['branch']) : false;
    $rights = determineLivingPrivateRights($newpersonrow, $righttree, $rightbranch);
    $newpersonrow['allow_living'] = $rights['living'];
    $newpersonrow['allow_private'] = $rights['private'];
    tng_free_result($result);
}

if ($husband) {
    $husbstr = getName($newpersonrow) . " - $husband";
} else {
    if ($wife) $wifestr = getName($newpersonrow) . " - $wife";
}
if (!isset($husbstr)) $husbstr = _('Click Find or Create =>');
if (!isset($wifestr)) $wifestr = _('Click Find or Create =>');

if ($assignedtree) {
    $wherestr = "WHERE gedcom = '$assignedtree'";
    $firsttree = $assignedtree;
} else {
    $wherestr = "";
    $firsttree = $tree ? $tree : (isset($_COOKIE['tng_tree']) ? $_COOKIE['tng_tree'] : "");
}
$query = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";
$result = tng_query($query);

$helplang = findhelp("families_help.php");

$revstar = checkReview("F");

tng_adminheader(_('Add New Family'), $flags);
include_once "eventlib.php";
include_once "eventlib_js.php";
?>
<script>
    var persfamID = "";
    var allow_cites = false;
    var allow_notes = false;

    function toggleAll(display) {
        toggleSection('spouses', 'plus0', display);
        toggleSection('events', 'plus1', display);
        return false;
    }

    <?php
    if (!$assignedtree && !$assignedbranch) {
        include "branchlibjs.php";
    } else {
        $swapbranches = "";
    }
    ?>
    function validateFamily(form) {
        let rval = true;
        form.familyID.value = TrimString(form.familyID.value);
        if (form.familyID.value.length == 0) {
            alert("<?php echo _('Please enter a Family ID.'); ?>");
            return false;
        }
        return true;
    }

    function EditSpouse(field) {
        var tree = getTree(document.form1.tree1);
        if (field.value.length)
            window.open('admin_editperson.php?personID=' + field.value + '&tree=' + tree + '&cw=1');
    }

    function RemoveSpouse(spouse, spousedisplay) {
        spouse.value = "";
        spousedisplay.value = "<?php echo _('Click Find or Create =>'); ?>";
    }

    var nplitbox;
    var activeidbox = null;
    var activenamebox = null;

    function openCreatePersonForm(idfield, namefield, type, gender) {
        activeidbox = idfield;
        activenamebox = namefield;
        nplitbox = new LITBox('admin_newperson2.php?tree=' + document.form1.tree1.options[document.form1.tree1.selectedIndex].value + '&type=' + type + '&familyID=' + persfamID + '&gender=' + gender, {
            width: 620,
            height: 600,
            doneLoading: function () {
                generateID('person', document.npform.personID, document.form1.tree1);
                jQuery('#firstname').focus();
            }
        });
        return false;
    }

    function saveNewPerson(form) {
        form.personID.value = TrimString(form.personID.value);
        var personID = form.personID.value;
        if (personID.length == 0) {
            alert("<?php echo _('Please enter a Person ID'); ?>");
        } else {
            var params = jQuery(form).serialize();
            jQuery.ajax({
                url: 'admin_addperson2.php',
                data: params,
                dataType: 'json',
                type: 'post',
                success: function (vars) {
                    if (vars.error) {
                        jQuery('#errormsg').html(vars.error);
                        jQuery('#errormsg').show();
                    } else {
                        nplitbox.remove();
                        jQuery('#' + activenamebox).val(vars.name + ' - ' + vars.id);
                        jQuery('#' + activenamebox).effect('highlight', {}, 400);
                        jQuery('#' + activeidbox).val(vars.id);
                    }
                }
            });
        }
        return false
    }
</script>

    </head>

<?php
echo tng_adminlayout(" onload=\"generateID('family',document.form1.familyID,document.form1.tree1);\"");

$familytabs[0] = [1, "admin_families.php", _('Search'), "findfamily"];
$familytabs[1] = [$allow_add, "admin_newfamily.php", _('Add New'), "addfamily"];
$familytabs[2] = [$allow_edit, "admin_findreview.php?type=F", _('Review') . $revstar, "review"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/families_help.php#add');\" class='lightlink'>" . _('Help for this area') . "</a>";
$innermenu .= " &nbsp;|&nbsp; <a href='#' class='lightlink' onClick=\"return toggleAll('on');\">" . _('Expand all') . "</a> &nbsp;|&nbsp; <a href='#' class='lightlink' onClick=\"return toggleAll('off');\">" . _('Collapse all') . "</a>";
$menu = doMenu($familytabs, "addfamily", $innermenu);
echo displayHeadline(_('Families') . " &gt;&gt; " . _('Add New Family'), "img/families_icon.gif", $menu, $message);
?>

    <form action="admin_addfamily.php" method="post" name="form1" onSubmit="return validateFamily(this);">
        <input type="hidden" name="lastperson" value="<?php echo $child; ?>">
        <table class="lightback">
            <tr class="databack">
                <td class="tngshadow">
                    <table class="normal">
                        <tr>
                            <td class="align-top" colspan="2"><span class="normal"><strong><?php echo _('Please prefix Family ID with \"F\" for \"Family\"'); ?></strong></span></td>
                        </tr>
                        <tr>
                            <td><span class="normal"><?php echo _('Tree'); ?>:</span></td>
                            <td>
                                <select name="tree1" id="gedcom"
                                    onChange="<?php echo $swapbranches; ?> generateID('family',document.form1.familyID,document.form1.tree1);tree=this.options[this.selectedIndex].value;">
                                    <?php
                                    while ($row = tng_fetch_assoc($result)) {
                                        echo "		<option value=\"{$row['gedcom']}\"";
                                        if ($firsttree == $row['gedcom']) echo " selected";

                                        echo ">{$row['treename']}</option>\n";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="normal"><?php echo _('Branch'); ?>:</span></td>
                            <td style="height:2em;">
                                <?php
                                $query = "SELECT branch, description FROM $branches_table WHERE gedcom = \"$firsttree\" ORDER BY description";
                                $branchresult = tng_query($query);
                                $numbranches = tng_num_rows($branchresult);
                                $branchlist = explode(",", $row['branch']);

                                $descriptions = [];
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
                                if ($numbranches > 8) $select = _('(Scroll to see all choices)') . "<br>";
                            $select .= "<select name=\"branch[]\" id='branch' multiple size='8'>\n";
                            $select .= "	<option value=\"\"";
                            if ($row['branch'] == "") $select .= " selected";
                                $select .= ">" . _('No Branch') . "</option>\n";
                                $select .= "$options</select>\n";
                            echo " <span class='whitespace-no-wrap'>(";
                                echo "<a href='#' onclick=\"showBranchEdit('branchedit'); quitBranchEdit('branchedit'); return false;\">";
                                echo _('Edit');
                                echo buildSvgElement("img/chevron-down.svg", ["class" => "w-3 h-3 ml-2 fill-current inline-block"]);
                            echo "</a> )</span>";
                            ?>
                            <div id="branchedit" class="lightback p-1 absolute" style="display: none;" onmouseover="clearTimeout(branchtimer);"
                                onmouseout="closeBranchEdit('branch','branchedit','branchlist');">
                                <?php
                                echo $select;
                                echo "</div>\n";
                                }
                                else {
                                    echo "<input type='hidden' name='branch' value=\"$assignedbranch\">$assdesc ($assignedbranch)";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="normal"><?php echo _('Family ID'); ?>:</span></td>
                            <td>
                                <input type="text" name="familyID" value="<?php echo $newID; ?>" size="10" onBlur="this.value=this.value.toUpperCase()">
                                <input type="button" value="<?php echo _('Generate'); ?>" onClick="generateID('family',document.form1.familyID,document.form1.tree1);">
                                <input type="button" name="lock" value="<?php echo _('Lock'); ?>"
                                    onClick="document.form1.newfamily[0].checked = true; if( gatherChildren() ) {document.form1.submit();}">
                                <input type="button" value="<?php echo _('Check'); ?>" onClick="checkID(document.form1.familyID.value,'family','checkmsg',document.form1.tree1);">
                                <span id="checkmsg" class="normal"></span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="databack">
                <td class="tngshadow">
                    <?php echo displayToggle("plus0", 1, "spouses", _('Spouses / Partners'), ""); ?>

                    <div id="spouses">
                        <table class="normal topmarginsmall">
                            <tr>
                                <td><span class="normal"><?php echo _('Father'); ?>:</span></td>
                                <td>
                                    <input type="text" readonly="readonly" name="husbnameplusid" id="husbnameplusid" size="40" value="<?php echo "$husbstr"; ?>">
                                    <input type="hidden" name="husband" id="husband" value="<?php echo $husband; ?>">
                                    <input type="button" value="<?php echo _('Find...'); ?>"
                                        onclick="return findItem('I','husband','husbnameplusid',document.form1.tree1.options[document.form1.tree1.selectedIndex].value,'<?php echo $assignedbranch; ?>');">
                                    <input type="button" value="<?php echo _('Create...'); ?>" onclick="return openCreatePersonForm('husband','husbnameplusid','spouse','M');">
                                    <input type="button" value="  <?php echo _('Edit'); ?>  " onclick="EditSpouse(document.form1.husband);">
                                    <input type="button" value="<?php echo _('Remove'); ?>" onclick="RemoveSpouse(document.form1.husband,document.form1.husbnameplusid);">
                                </td>
                            </tr>
                            <tr>
                                <td><span class="normal"><?php echo _('Mother'); ?>:</span></td>
                                <td>
                                    <input type="text" readonly readonly="readonly" name="wifenameplusid" id="wifenameplusid" size="40" value="<?php echo "$wifestr"; ?>">
                                    <input type="hidden" name="wife" id="wife" value="<?php echo $wife; ?>">
                                    <input type="button" value="<?php echo _('Find...'); ?>"
                                        onclick="return findItem('I','wife','wifenameplusid',document.form1.tree1.options[document.form1.tree1.selectedIndex].value,'<?php echo $assignedbranch; ?>');">
                                    <input type="button" value="<?php echo _('Create...'); ?>" onclick="return openCreatePersonForm('wife','wifenameplusid','spouse','F');">
                                    <input type="button" value="  <?php echo _('Edit'); ?>  " onclick="EditSpouse(document.form1.wife);">
                                    <input type="button" value="<?php echo _('Remove'); ?>" onclick="RemoveSpouse(document.form1.wife,document.form1.wifenameplusid);">
                                </td>
                            </tr>
                        </table>

                        <table class="normal topbuffer">
                            <tr>
                                <td class="whitespace-no-wrap">
                                    <input type="checkbox" name="living" value="1" checked="checked"> <?php echo _('Living'); ?>&nbsp;&nbsp;
                                    <input type="checkbox" name="private" value="1"> <?php echo _('Private'); ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <tr class="databack">
                <td class="tngshadow">
                    <?php echo displayToggle("plus1", 1, "events", _('Events'), ""); ?>

                    <div id="events">
                        <p class="normal topmarginsmall"><?php echo _('<strong>Note:</strong> When entering dates, please use the standard genealogical format DD MMM YYYY. For example, 10 Apr 2004.'); ?></p>
                        <table class="normal">
                            <tr>
                                <td>&nbsp;</td>
                                <td><?php echo _('Date'); ?></td>
                                <td><?php echo _('Place'); ?></td>
                                <td colspan="4">&nbsp;</td>
                            </tr>
                            <?php echo showEventRow('marrdate', 'marrplace', 'MARR', ''); ?>
                            <tr>
                                <td><?php echo _('Marriage Type'); ?>:</td>
                                <td colspan="6">
                                    <input type="text" value="" name="marrtype" style="width:494px;" maxlength="50">
                                </td>
                            </tr>
                            <?php
                            if (determineLDSRights()) {
                                echo showEventRow('sealdate', 'sealplace', 'SLGS', '');
                            }
                            echo showEventRow('divdate', 'divplace', 'DIV', '');
                            ?>
                        </table>

                    </div>
                </td>
            </tr>
            <tr class="databack">
                <td class="tngshadow">
                    <p class="normal"><strong><?php echo _('Note: Children and additional events, plus event-specific notes and citations, may be added on the next screen.'); ?></strong></p>
                    <input type="hidden" value="<?php echo "$cw"; ?>" name="cw">
                    <input type="submit" class="btn" name="save" accesskey="s" value="<?php echo _('Save and continue...'); ?>">
                </td>
            </tr>

        </table>
    </form>

    <script>
        <?php
        echo $swapbranches;
        echo "tree = \"$firsttree\";\n";
        ?>
    </script>

<?php echo tng_adminfooter(); ?>
<?php
include "begin.php";
include "adminlib.php";

$admin_login = true;
include "checklogin.php";
include "version.php";
if (!$allow_add) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

if ($assignedtree) {
    $wherestr = "WHERE gedcom = '$assignedtree'";
    $firsttree = $assignedtree;
} else {
    $wherestr = "";
    $firsttree = isset($_COOKIE['tng_tree']) ? $_COOKIE['tng_tree'] : "";
}
$query = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";
$result = tng_query($query);

$helplang = findhelp("people_help.php");

$revstar = checkReview("I");

tng_adminheader(_('Add New Person'), $flags);
include_once "eventlib.php";
include_once "eventlib_js.php";
?>
<script>
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
        $query = "SELECT description FROM $branches_table WHERE gedcom = '$assignedtree' AND branch = \"$assignedbranch\" ORDER BY description";
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
            alert("<?php echo _('Please enter a Person ID'); ?>");
            rval = false;
        }
        return rval;
    }
</script>

    </head>

<?php
echo tng_adminlayout(" onload=\"generateID('person',document.form1.personID,document.form1.tree1);\"");

$peopletabs[0] = [1, "admin_people.php", _('Search'), "findperson"];
$peopletabs[1] = [$allow_add, "admin_newperson.php", _('Add New'), "addperson"];
$peopletabs[2] = [$allow_edit, "admin_findreview.php?type=I", _('Review') . $revstar, "review"];
$peopletabs[3] = [$allow_edit && $allow_delete, "admin_merge.php", _('Merge'), "merge"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/people_help.php#add');\" class='lightlink'>" . _('Help for this area') . "</a>";
$innermenu .= " &nbsp;|&nbsp; <a href='#' class='lightlink' onClick=\"return toggleAll('on');\">" . _('Expand all') . "</a> &nbsp;|&nbsp; <a href='#' class='lightlink' onClick=\"return toggleAll('off');\">" . _('Collapse all') . "</a>";
$menu = doMenu($peopletabs, "addperson", $innermenu);
if (!isset($message)) $message = '';
echo displayHeadline(_('People') . " &gt;&gt; " . _('Add New Person'), "img/people_icon.gif", $menu, $message);
?>

    <form action="admin_addperson.php" method="post" name="form1" onSubmit="return validateForm();">
        <table class="lightback">
            <tr class="databack">
                <td class="tngshadow">
                    <table class="normal">
                        <tr>
                            <td class="align-top" colspan="2"><span class="normal"><strong><?php echo _('Please prefix Person ID with \"I\" for \"Individual\"'); ?></strong></span></td>
                        </tr>
                        <tr>
                            <td><span class="normal"><?php echo _('Tree'); ?>:</span></td>
                            <td>
                                <select name="tree1" id="gedcom" onChange="<?php echo $swapbranches; ?> generateID('person',document.form1.personID,document.form1.tree1);tree=this.options[this.selectedIndex].value;">
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
                            <div id="branchedit" class="lightback p-1" style="position:absolute;display:none;" onmouseover="clearTimeout(branchtimer);" onmouseout="closeBranchEdit('branch','branchedit','branchlist');">
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
                            <td><span class="normal"><?php echo _('Person ID'); ?>:</span></td>
                            <td>
                                <input type="text" name="personID" size="10" onblur="this.value=this.value.toUpperCase()">
                                <input type="button" value="<?php echo _('Generate'); ?>" onclick="generateID('person',document.form1.personID,document.form1.tree1);">
                                <input type="submit" name="submit" value="<?php echo _('Lock'); ?>" onclick="document.form1.newfamily['2'].checked = true;">
                                <input type="button" value="<?php echo _('Check'); ?>" onclick="checkID(document.form1.personID.value,'person','checkmsg',document.form1.tree1);">
                                <span id="checkmsg" class="normal"></span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="databack">
                <td class="tngshadow">
                    <?php echo displayToggle("plus0", 1, "names", _('Name'), ""); ?>

                    <div id="names">
                        <table class="normal topmarginsmall">
                            <tr>
                                <td><?php echo _('First/Given Name(s)'); ?></td>
                                <?php if ($lnprefixes) echo "<td>" . _('Surname Prefix') . "</td>\n"; ?>
                                <td><?php echo _('Last/Surname'); ?></td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="firstname" size="30">
                                </td>
                                <?php
                                if ($lnprefixes) {
                                    echo "<td><input type='text' name='lnprefix' style=\"width:80px;\"></td>\n";
                                }
                                ?>
                                <td>
                                    <input type="text" name="lastname" size="30">
                                </td>
                            </tr>
                        </table>
                        <table class="normal topmarginsmall">
                            <tr>
                                <td><?php echo _('Gender'); ?></td>
                                <td><?php echo _('Nickname'); ?></td>
                                <td><?php echo _('Title'); ?></td>
                                <td><?php echo _('Prefix'); ?></td>
                                <td><?php echo _('Suffix'); ?></td>
                                <td><?php echo _('Name Order'); ?></td>
                            </tr>
                            <tr>
                                <td>
                                    <select name="sex">
                                        <option value="U"><?php echo _('Unknown'); ?></option>
                                        <option value="M"><?php echo _('Male'); ?></option>
                                        <option value="F"><?php echo _('Female'); ?></option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="nickname" class="w-24">
                                </td>
                                <td>
                                    <input type="text" name="title" class="w-24">
                                </td>
                                <td>
                                    <input type="text" name="prefix" class="w-24">
                                </td>
                                <td>
                                    <input type="text" name="suffix" class="w-24">
                                </td>
                                <td>
                                    <select name="pnameorder">
                                        <option value="0"><?php echo _('Default'); ?></option>
                                        <option value="1"><?php echo _('First name first'); ?></option>
                                        <option value="2"><?php echo _('Surname first (without commas)'); ?></option>
                                        <option value="3"><?php echo _('Surname first (with commas)'); ?></option>
                                    </select>
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
                            <?php
                            echo showEventRow('birthdate', 'birthplace', 'BIRT', '');
                            if (!$tngconfig['hidechr']) {
                                echo showEventRow('altbirthdate', 'altbirthplace', 'CHR', '');
                            }
                            echo showEventRow('deathdate', 'deathplace', 'DEAT', '');
                            echo showEventRow('burialdate', 'burialplace', 'BURI', '');
                            echo "<tr>";
                            echo "<td></td>";
                            echo "<td colspan='3'><input type='checkbox' name=\"burialtype\" id=\"burialtype\" value='1'> <label for=\"burialtype\">" . _('Cremated') . "</label></td>";
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
                    <p class="normal"><strong><?php echo _('Note: Additional events, plus event-specific notes and citations, may be added on the next screen.'); ?></strong></p>
                    <input type="hidden" value="<?php echo "$cw"; ?>" name="cw">
                    <?php
                    if (!$lnprefixes) {
                        echo "<input type='hidden' name='lnprefix' value=\"\">";
                    }
                    ?>
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
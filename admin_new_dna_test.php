<?php
include "begin.php";
include "adminlib.php";
$textpart = "dna";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_add) {
    $message = $admtext['norights'];
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

if ($assignedtree) {
    $wherestr = "WHERE gedcom = \"$assignedtree\"";
    $tree = $assignedtree;
} else {
    $wherestr = "";
}

$helplang = findhelp("dna_help.php");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['addnewdna'], $flags);
?>
</head>

<body class="admin-body">

<?php
$dnatabs[0] = array(1, "admin_dna_tests.php", $admtext['search'], "findtest");
$dnatabs[1] = array($allow_add, "admin_new_dna_test.php", $admtext['addnew'], "addtest");
$innermenu = "<a href=\"#\" onclick=\"return openHelp('$helplang/dna_help.php#add');\" class=\"lightlink\">{$admtext['help']}</a> ";
$innermenu .= "&nbsp;|&nbsp;<a href=\"#\" class=\"lightlink\" onClick=\"return toggleAll('on');\">{$text['expandall']}</a> &nbsp;|&nbsp; <a href=\"#\" class=\"lightlink\" onClick=\"return toggleAll('off');\">{$text['collapseall']}</a>";
$menu = doMenu($dnatabs, "addtest", $innermenu);
echo displayHeadline($admtext['dna_tests'] . " &gt;&gt; " . $admtext['addnewdna'], "img/dna_icon.gif", $menu, "");
?>

<form action="admin_add_dna_test.php" method="post" name="form1" id="form1" onsubmit="return validateForm();">
    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <?php echo displayToggle("plus0", 1, "testinfo", $admtext['testinfo'], $admtext['uplsel']); ?>

                <div id="testinfo">
                    <br>
                    <table class="normal">
                        <tr>
                            <td><?php echo $admtext['test_type']; ?>:</td>
                            <td>
                                <select name="test_type" id="test_type">
                                    <option value=""></option>
                                    <option value="atDNA"><?php echo $admtext['atdna_test']; ?></option>
                                    <option value="Y-DNA"><?php echo $admtext['ydna_test']; ?></option>
                                    <option value="mtDNA"><?php echo $admtext['mtdna_test']; ?></option>
                                    <option value="X-DNA"><?php echo $admtext['xdna_test']; ?></option>
                                </select>&nbsp;<img src="img/spinner.gif" style="display:none;" id="treespinner2" alt="" class="spinner">&nbsp;&nbsp;&nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['test_number']; ?>:</td>
                            <td>
                                <input type="text" name="test_number" class="medfield">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['vendor']; ?>:</td>
                            <td>
                                <input type="text" name="vendor" class="medfield">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['test_date']; ?>:</td>
                            <td>
                                <input type="text" name="test_date" class="medfield" onblur="checkDate(this);">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['match_date']; ?>:</td>
                            <td>
                                <input type="text" name="match_date" class="medfield" onblur="checkDate(this);">
                            </td>
                        </tr>
                        <?php if ($test_type == "atDNA") { ?>
                            <tr>
                                <td><?php echo $admtext['gedmatchID']; ?>:</td>
                                <td>
                                    <input type="text" name="GEDmatchID" value="<?php echo $row['GEDmatchID']; ?>" id="GEDmatchID" size="40" maxlength="40">
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td><strong><?php echo $admtext['privatetest']; ?>:</strong>&nbsp;</td>
                            <td>
                                <select name="private_test">
                                    <option value="0"<?php if (!$row['private_test']) {
                                        echo " selected";
                                    } ?>><?php echo $admtext['no']; ?></option>
                                    <option value="1"<?php if ($row['private_test']) {
                                        echo " selected";
                                    } ?>><?php echo $admtext['yes']; ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><br><strong><?php echo $admtext['test_taker']; ?></strong></td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['tree']; ?>:</td>
                            <td>
                                <select name="mynewgedcom">
                                    <option value=""></option>
                                    <?php
                                    $query = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";
                                    $treeresult = tng_query($query);

                                    while ($treerow = tng_fetch_assoc($treeresult)) {
                                        echo "	<option value=\"{$treerow['gedcom']}\">{$treerow['treename']}</option>\n";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo "{$admtext['personid']} "; ?>:</td>
                            <td>

                                <input type="text" name="personID" id="personID" size="20" maxlength="22"> &nbsp;<?php echo $admtext['text_or']; ?>&nbsp;
                                <a href="#" onclick="return findItem('I','personID','',document.form1.mynewgedcom.options[document.form1.mynewgedcom.selectedIndex].value,'<?php echo $assignedbranch; ?>');" title="<?php echo $admtext['find']; ?>">
                                    <img src="img/tng_find.gif" title="<?php echo $admtext['find']; ?>" alt="<?php echo $admtext['find']; ?>" class="alignmiddle" width="20" height="20" style="margin-left:2px;margin-bottom:4px;">
                                </a>
                                <span id="deststrfield"><?php echo $takername; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo "{$admtext['text_or']} {$admtext['person_name']} "; ?></td>
                            <td>
                                <input type="text" name="person_name" value="<?php echo $row['person_name']; ?>" id="person_name" size="40" maxlength="100">
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;<strong><?php echo $text['keep_name_private']; ?>:</strong>&nbsp;<input type="checkbox" name="private_dna" value="1">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>

        <tr class="databack">
            <td class="tngshadow">
                <p class="normal"><strong><?php echo $admtext['dnalater']; ?></strong></p>
                <input type="hidden" value="<?php echo "$cw"; ?>" name="cw">
                <input type="submit" name="submitbtn" class="btn" accesskey="s" value="<?php echo $admtext['savecont']; ?>">
            </td>
        </tr>

    </table>
</form>
<?php echo "<div style=\"text-align: center;\"><span class='normal'>$tng_title</span></div>"; ?>
<script>
    var tree = "<?php echo $tree; ?>";
    var tnglitbox;

    function validateForm() {
        let rval = true;

//req: test number, test type
        var frm = document.form1;
        if (!frm.test_type.selectedIndex) {
            alert("<?php echo $admtext['selecttype']; ?>");
            rval = false;
        }
//removed test_number alert
        return rval;
    }

    function toggleAll(display) {
        toggleSection('testinfo', 'plus0', display);
        return false;
    }
</script>
<script src="js/net.js"></script>
<script src="js/admin.js"></script>
<script src="js/datevalidation.js"></script>
<script src="js/selectutils.js"></script>
<script>
    var preferEuro = <?php echo($tngconfig['preferEuro'] ? $tngconfig['preferEuro'] : "false"); ?>;
    var preferDateFormat = '<?php echo $preferDateFormat; ?>';
</script>
</body>
</html>
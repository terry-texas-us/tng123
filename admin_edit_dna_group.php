<?php
include "begin.php";
include "adminlib.php";
require_once "./admin/trees.php";

$textpart = "dna";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_edit || ($assignedtree && $assignedtree != $tree)) {
    $message = $admtext['norights'];
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$query = "SELECT * FROM $dna_groups_table WHERE gedcom = '$tree' AND dna_group = \"$dna_group\"";
$result = tng_query($query);
$row = tng_fetch_assoc($result);
$row['description'] = preg_replace("/\"/", "&#34;", $row['description']);
tng_free_result($result);

$treerow = getTree($trees_table, $tree);

$helplang = findhelp("dna_help.php");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['modifygroup'], $flags);
?>
<script src="js/selectutils.js"></script>
<script>
    function validateForm() {
        let rval = true;
        var form = document.form1;

        if (form1.description.value.length == 0) {
            alert("<?php echo $admtext['entergroupdesc']; ?>");
            rval = false;
        } else if (document.form1.test_type.selectedIndex == 0) {
            alert("<?php echo $admtext['selecttype']; ?>");
            rval = false;
        }
        return rval;
    }

</script>
</head>

<body class="admin-body">

<?php
$dnatabs[0] = array(1, "admin_dna_groups.php", $admtext['search'], "findtest");
$dnatabs[1] = array($allow_add, "admin_new_dna_group.php", $admtext['addgroup'], "addgroup");
$dnatabs[2] = array($allow_edit, "#", $admtext['edit'], "edit");
$innermenu = "<a href=\"#\" onclick=\"return openHelp('$helplang/dna_help.php#add');\" class=\"lightlink\">{$admtext['help']}</a>";
$menu = doMenu($dnatabs, "edit", $innermenu);
echo displayHeadline($admtext['dna_groups'] . " &gt;&gt; " . $admtext['modifygroup'], "img/dna_icon.gif", $menu, $message);
?>

<table class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <form action="admin_update_dna_groups.php" method="post" name="form1" id="form1" onSubmit="return validateForm();">
                <table class="normal">
                    <tr>
                        <td class='align-top'><?php echo $admtext['tree']; ?>:</td>
                        <td><?php echo $treerow['treename']; ?></td>
                    </tr>
                    <tr>
                        <td class='align-top'><?php echo $admtext['groupid']; ?>:</td>
                        <td><?php echo $row['dna_group']; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $admtext['test_type']; ?>:</td>
                        <td>
                            <select name="test_type">
                                <option value=""></option>
                                <option value="atDNA" <?php if ($row['test_type'] == "atDNA") {
                                    echo "selected='selected'";
                                } ?>><?php echo $admtext['atdna_test']; ?></option>
                                <option value="Y-DNA" <?php if ($row['test_type'] == "Y-DNA") {
                                    echo "selected='selected'";
                                } ?>><?php echo $admtext['ydna_test']; ?></option>
                                <option value="mtDNA" <?php if ($row['test_type'] == "mtDNA") {
                                    echo "selected='selected'";
                                } ?>><?php echo $admtext['mtdna_test']; ?></option>
                                <option value="X-DNA" <?php if ($row['test_type'] == "X-DNA") {
                                    echo "selected='selected'";
                                } ?>><?php echo $admtext['xdna_test']; ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'><?php echo $admtext['description']; ?>:</td>
                        <td>
                            <input type="text" name="description" size="60" value="<?php echo $row['description']; ?>">
                        </td>
                    </tr>

                </table>
                <span class="normal">
	<br></span>
                <input type="hidden" name="tree" value="<?php echo $tree; ?>">
                <input type="hidden" name="dna_group" value="<?php echo $dna_group; ?>">
                <input type="submit" name="submit" class="btn" value="<?php echo $admtext['save']; ?>">
            </form>
        </td>
    </tr>

</table>
<?php echo "<div style=\"text-align: center;\"><span class='normal'>$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>

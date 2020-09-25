<?php
include "begin.php";
include "adminlib.php";
$textpart = "sources";
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
    $firsttree = $assignedtree;
} else {
    $wherestr = "";
    $firsttree = isset($_COOKIE['tng_tree']) ? $_COOKIE['tng_tree'] : "";
}

$helplang = findhelp("sources_help.php");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['addnewsource'], $flags);
?>
<script src="js/selectutils.js"></script>
<script>
    function validateForm() {
        let rval = true;

        document.form1.sourceID.value = TrimString(document.form1.sourceID.value);
        if (document.form1.sourceID.value.length == 0) {
            alert("<?php echo $admtext['entersourceid']; ?>");
            return false;
        }
        return rval;
    }

    const selecttree = "<?php echo $admtext['selecttree']; ?>";
</script>
</head>

<body class="admin-body" onload="generateID('source',document.form1.sourceID,document.form1.tree1);">

<?php
$sourcetabs[0] = array(1, "admin_sources.php", $admtext['search'], "findsource");
$sourcetabs[1] = array($allow_add, "admin_newsource.php", $admtext['addnew'], "addsource");
$sourcetabs[2] = array($allow_edit && $allow_delete, "admin_mergesources.php", $admtext['merge'], "merge");
$innermenu = "<a href=\"#\" onclick=\"return openHelp('$helplang/sources_help.php#add');\" class=\"lightlink\">{$admtext['help']}</a>";
$menu = doMenu($sourcetabs, "addsource", $innermenu);
echo displayHeadline($admtext['sources'] . " &gt;&gt; " . $admtext['addnewsource'], "img/sources_icon.gif", $menu, $message);
?>

<form action="admin_addsource.php" method="post" name="form1" onSubmit="return validateForm();">
    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <table class="normal">
                    <tr>
                        <td colspan="2"><strong><?php echo $admtext['prefixsourceid']; ?></strong></td>
                    </tr>
                    <tr>
                        <td><?php echo $admtext['tree']; ?></td>
                        <td>
                            <select name="tree1" onChange="generateID('source',document.form1.sourceID,document.form1.tree1);">
                                <?php
                                $query = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";
                                $result = tng_query($query);
                                $numtrees = tng_num_rows($result);
                                while ($row = tng_fetch_assoc($result)) {
                                    echo "		<option value=\"{$row['gedcom']}\"";
                                    if ($firsttree == $row['gedcom']) {
                                        echo " selected";
                                    }
                                    echo ">{$row['treename']}</option>\n";
                                }
                                tng_free_result($result);
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="normal"><?php echo $admtext['sourceid']; ?>:</span></td>
                        <td>
                            <input type="text" name="sourceID" size="10" onBlur="this.value=this.value.toUpperCase()">
                            <input type="button" value="<?php echo $admtext['generate']; ?>" onClick="generateID('source',document.form1.sourceID,document.form1.tree1);">
                            <input type="submit" name="submit" value="<?php echo $admtext['lockid']; ?>" onClick="document.form1.newscreen[0].checked = true;">
                            <input type="button" value="<?php echo $admtext['check']; ?>" onClick="checkID(document.form1.sourceID.value,'source','checkmsg',document.form1.tree1);">
                            <span id="checkmsg" class="normal"></span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="databack">
            <td class="tngshadow">
                <table class="normal">
                    <?php include "micro_newsource.php"; ?>
                </table>
            </td>
        </tr>
        <tr class="databack">
            <td class="tngshadow">
                <p class="normal"><strong><?php echo $admtext['sevslater']; ?></strong></p>
                <input type="submit" class="btn" name="save" accesskey="s" value="<?php echo $admtext['savecont']; ?>">
            </td>
        </tr>
    </table>
</form>

<?php echo "<div style=\"text-align: center;\"><span class='normal'>$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
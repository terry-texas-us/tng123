<?php
include "begin.php";
include "adminlib.php";
require_once "./admin/trees.php";

$textpart = "misc";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
$helplang = findhelp("misc_help.php");

$orderedTreesList = new OrderedTreesList($trees_table, $assignedtree);

// TODO text ['validation'] was not defined in any language. Manually added here.
tng_adminheader(_todo_('Validation'), $flags);
?>
<script>
    jQuery(document).ready(function () {
        jQuery('.valreport').bind('click', function (e) {
            let linkval = $(this).attr('href');
            let treeid = $('#treequeryselect').val();
            $(this).attr('href', linkval + treeid);
        });
    });
</script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$misctabs[0] = [1, "admin_misc.php", $admtext['menu'], "misc"];
$misctabs[1] = [1, "admin_whatsnewmsg.php", $admtext['whatsnew'], "whatsnew"];
$misctabs[2] = [1, "admin_mostwanted.php", $admtext['mostwanted'], "mostwanted"];
$misctabs[3] = [1, "admin_data_validation.php", $admtext['dataval'], "validation"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/misc_help.php');\" class='lightlink'>{$admtext['help']}</a>";
$innermenu .= " &nbsp;|&nbsp; <a href=\"mostwanted.php\" target='_blank' class='lightlink'>{$admtext['test']}</a>";
$menu = doMenu($misctabs, "validation", $innermenu);
echo displayHeadline($admtext['misc'] . " &gt;&gt; " . $admtext['dataval'], "img/misc_icon.gif", $menu, $message);

$reports = ['wr_gender', 'unk_gender', 'marr_young', 'marr_aft_death', 'marr_bef_birth', 'died_bef_birth', 'parents_younger', 'children_late', 'not_living', 'not_dead'];
?>

<table class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <h3 class="subhead"><?php echo $admtext['dataval']; ?></h3>

            <?php if (!$assignedtree) { ?>
                <form action="admin_people.php" name="form1">
                    <table>
                        <tr>
                            <td><span class="normal"><?php echo $admtext['tree']; ?>: </span></td>
                            <td>
                                <?php
                                echo "<select id='treequeryselect' name='tree'>";
                                if (!$assignedtree) {
                                    echo "<option value=''>{$admtext['alltrees']}</option>\n";
                                }
                                // todo assigned tree is test and is empty here so likely do not need to pass
                                echo $orderedTreesList->getSelectOptionsHtml($assignedtree);
                                ?>
                            </td>
                        </tr>
                    </table>
                </form><br>
            <?php } ?>
            <table cellpadding="5" cellspacing="1" class="normal">
                <tr>
                    <th class="fieldnameback fieldname">#</th>
                    <th class="fieldnameback fieldname"><?php echo $admtext['report']; ?></th>
                </tr>
                <?php
                for ($i = 1; $i <= count($reports); $i++) {
                    $this_report = $reports[$i - 1];
                    ?>
                    <tr>
                        <td class="lightback" align="right">&nbsp;<?php echo $i; ?></td>
                        <td class="lightback">&nbsp;<a href="admin_valreport.php?report=<?php echo $this_report; ?>&amp;tree=<?php echo $assignedtree; ?>"
                                                       class="valreport"><?php echo $admtext[$this_report]; ?></a></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>

</table>
<?php echo tng_adminfooter(); ?>
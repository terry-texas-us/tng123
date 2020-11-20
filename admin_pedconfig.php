<?php
include "begin.php";
include "config/pedconfig.php";
include "adminlib.php";

if ($link) {
    $admin_login = 1;
    include "checklogin.php";
    include "version.php";
    if ($assignedtree || !$allow_edit) {
        $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
        header("Location: admin_login.php?message=" . urlencode($message));
        exit;
    }
}

$helplang = findhelp("pedconfig_help.php");

tng_adminheader(_('Modify Pedigree Configuration Settings'), $flags);
?>
<script src="js/popupwindow.js"></script>
<script src="js/anchorposition.js"></script>
<script src="js/colorpicker2.js"></script>
<script>
    var cp = new ColorPicker('window');

    function toggleAll(display) {
        toggleSection('ped', 'plus0', display);
        toggleSection('desc', 'plus1', display);
        toggleSection('rel', 'plus2', display);
        toggleSection('time', 'plus3', display);
        toggleSection('peddesc', 'plus4', display);
        return false;
    }
</script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$setuptabs[0] = [1, "admin_setup.php", _('Configuration'), "configuration"];
$setuptabs[1] = [1, "admin_diagnostics.php", _('Diagnostics'), "diagnostics"];
$setuptabs[2] = [1, "admin_setup.php?sub=tablecreation", _('Table Creation'), "tablecreation"];
$setuptabs[3] = [1, "#", _('Chart Settings'), "ped"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/pedconfig_help.php');\" class='lightlink'>" . _('Help for this area') . "</a>";
$innermenu .= " &nbsp;|&nbsp; <a href='#' class='lightlink' onClick=\"return toggleAll('on');\">" . _('Expand all') . "</a> &nbsp;|&nbsp; <a href='#' class='lightlink' onClick=\"return toggleAll('off');\">" . _('Collapse all') . "</a>";
$menu = doMenu($setuptabs, "ped", $innermenu);
echo displayHeadline(_('Setup') . " &gt;&gt; " . _('Configuration') . " &gt;&gt; " . _('Chart Settings'), "img/setup_icon.gif", $menu, "");

if (!isset($pedigree['vwidth'])) $pedigree['vwidth'] = 100;
if (!isset($pedigree['vheight'])) $pedigree['vheight'] = 42;
if (!isset($pedigree['vspacing'])) $pedigree['vspacing'] = 20;
if (!isset($pedigree['vfontsize'])) $pedigree['vfontsize'] = 7;
?>

    <form action="admin_updatepedconfig.php" method="post" name="form1">
        <table class="lightback">
            <tr class="databack">
                <td class="tngshadow">
                    <?php echo displayToggle("plus0", 0, "ped", _('Pedigree Chart'), ""); ?>

                    <div id="ped" style="display:none;">
                        <table class="normal">
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class='align-top'><?php echo _('Initial Display'); ?>:</td>
                                <td>
                                    <select name="usepopups">
                                        <option value="1"<?php if ($pedigree['usepopups'] == 1) {
                                            echo " selected";
                                        } ?>><?php echo _('Standard'); ?></option>
                                        <option value="0"<?php if (!$pedigree['usepopups']) {
                                            echo " selected";
                                        } ?>><?php echo _('Box'); ?></option>
                                        <option value="-1"<?php if ($pedigree['usepopups'] == -1) {
                                            echo " selected";
                                        } ?>><?php echo _('Text Only'); ?></option>
                                        <option value="2"<?php if ($pedigree['usepopups'] == 2) {
                                            echo " selected";
                                        } ?>><?php echo _('Compact'); ?></option>
                                        <option value="3"<?php if ($pedigree['usepopups'] == 3) {
                                            echo " selected";
                                        } ?>><?php echo _('Ahnentafel'); ?></option>
                                        <option value="4"<?php if ($pedigree['usepopups'] == 4) {
                                            echo " selected";
                                        } ?>><?php echo _('Vertical'); ?></option>
                                        <option value="5"<?php if ($pedigree['usepopups'] == 5) {
                                            echo " selected";
                                        } ?>><?php echo _('Fan Chart'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class='align-top'><?php echo _('Max Generations'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $pedigree['maxgen']; ?>" name="maxgen" size="5">
                                </td>
                            </tr>
                            <tr>
                                <td class='align-top'><?php echo _('Initial Generations'); ?>:</td>
                                <td colspan="4">
                                    <input type="text" value="<?php echo $pedigree['initpedgens']; ?>" name="initpedgens" size="5">
                                </td>
                            </tr>
                            <tr>
                                <td class='align-top'><?php echo _('Popup Spouses'); ?>:</td>
                                <td>
                                    <input type="radio" name="popupspouses" value="1" <?php if ($pedigree['popupspouses']) {
                                        echo "checked";
                                    } ?>> <?php echo _('Yes'); ?>
                                    <input type="radio" name="popupspouses" value="0" <?php if (!$pedigree['popupspouses']) {
                                        echo "checked";
                                    } ?>> <?php echo _('No'); ?></td>
                            </tr>
                            <tr>
                                <td class='align-top'><?php echo _('Popup Children'); ?>:</td>
                                <td>
                                    <input type="radio" name="popupkids" value="1" <?php if ($pedigree['popupkids']) {
                                        echo "checked";
                                    } ?>> <?php echo _('Yes'); ?>
                                    <input type="radio" name="popupkids" value="0" <?php if (!$pedigree['popupkids']) {
                                        echo "checked";
                                    } ?>> <?php echo _('No'); ?></td>
                            </tr>
                            <tr>
                                <td class='align-top'><?php echo _('Popup Chart Links'); ?>:</td>
                                <td>
                                    <input type="radio" name="popupchartlinks" value="1" <?php if ($pedigree['popupchartlinks']) {
                                        echo "checked";
                                    } ?>> <?php echo _('Yes'); ?>
                                    <input type="radio" name="popupchartlinks" value="0" <?php if (!$pedigree['popupchartlinks']) {
                                        echo "checked";
                                    } ?>> <?php echo _('No'); ?></td>
                            </tr>
                            <tr>
                                <td class='align-top'><?php echo _('Hide Empty Boxes'); ?>:</td>
                                <td>
                                    <input type="radio" name="hideempty" value="1" <?php if ($pedigree['hideempty']) {
                                        echo "checked";
                                    } ?>> <?php echo _('Yes'); ?>
                                    <input type="radio" name="hideempty" value="0" <?php if (!$pedigree['hideempty']) {
                                        echo "checked";
                                    } ?>> <?php echo _('No'); ?></td>
                            </tr>
                            <tr>
                                <td class='align-top'><?php echo _('Box Width (w/o popups)'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $pedigree['boxwidth']; ?>" name="boxwidth" size="10">
                                </td>
                            </tr>
                            <tr>
                                <td class='align-top'><?php echo _('Box Height (w/o popups)'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $pedigree['boxheight']; ?>" name="boxheight" size="10">
                                </td>
                            </tr>
                            <tr>
                                <td class='align-top'><?php echo _('Box Alignment (w/o popups)'); ?>:</td>
                                <td>
                                    <select name="boxalign">
                                        <option value="center"<?php if ($pedigree['boxalign'] == "center") {
                                            echo " selected";
                                        } ?>><?php echo _('Center'); ?></option>
                                        <option value="left"<?php if ($pedigree['boxalign'] == "left") {
                                            echo " selected";
                                        } ?>><?php echo _('Left'); ?></option>
                                        <option value="right"<?php if ($pedigree['boxalign'] == "right") {
                                            echo " selected";
                                        } ?>><?php echo _('Right'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class='align-top'><?php echo _('Box Height Shift (w/o popups)'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $pedigree['boxheightshift']; ?>" name="boxheightshift" size="10">
                                </td>
                            </tr>
                        </table>

                        <p><strong><?php echo _('Vertical Chart'); ?></strong></p>
                        <table class="normal">
                            <tr>
                                <td class='align-top'><?php echo _('Box Width'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $pedigree['vwidth']; ?>" name="vwidth" size="5">
                                </td>
                            </tr>
                            <tr>
                                <td class='align-top'><?php echo _('Box Height'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $pedigree['vheight']; ?>" name="vheight" size="5">
                                </td>
                            </tr>
                            <tr>
                                <td class='align-top'><?php echo _('Spacing'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $pedigree['vspacing']; ?>" name="vspacing" size="5">
                                </td>
                            </tr>
                            <tr>
                                <td class='align-top'><?php echo _('Box Name Size'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php echo $pedigree['vfontsize']; ?>" name="vfontsize" size="5">
                                </td>
                            </tr>
                        </table>
                    </div>

                </td>
            </tr>

            <tr class="databack tngshadow">
                <td class="tngshadow">
                    <?php echo displayToggle("plus1", 0, "desc", _('Descendancy Chart'), ""); ?>

                    <div id="desc" style="display:none;">
                        <table>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class='align-top'><span class="normal"><?php echo _('Initial Display'); ?>:</span></td>
                                <td>
                                    <select name="defdesc">
                                        <option value="2"<?php if ($pedigree['defdesc'] == 2) {
                                            echo " selected";
                                        } ?>><?php echo _('Standard Format'); ?></option>
                                        <option value="0"<?php if (!$pedigree['defdesc']) {
                                            echo " selected";
                                        } ?>><?php echo _('Text Only'); ?></option>
                                        <option value="3"<?php if ($pedigree['defdesc'] == 3) {
                                            echo " selected";
                                        } ?>><?php echo _('Compact'); ?></option>
                                        <option value="1"<?php if ($pedigree['defdesc'] == 1) {
                                            echo " selected";
                                        } ?>><?php echo _('Register Format'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class='align-top'><span class="normal"><?php echo _('Max Generations'); ?>:</span></td>
                                <td colspan="4">
                                    <input type="text" value="<?php echo $pedigree['maxdesc']; ?>" name="maxdesc" size="5">
                                </td>
                            </tr>
                            <tr>
                                <td class='align-top'><span class="normal"><?php echo _('Initial Generations'); ?>:</span></td>
                                <td colspan="4">
                                    <input type="text" value="<?php echo $pedigree['initdescgens']; ?>" name="initdescgens" size="5">
                                </td>
                            </tr>
                            <tr>
                                <td class='align-top'><span class="normal"><?php echo _('Start Descendancy'); ?>:</span></td>
                                <td>
                                    <select name="stdesc">
                                        <option value="0"<?php if (!$pedigree['stdesc']) {
                                            echo " selected";
                                        } ?>><?php echo _('Expanded'); ?></option>
                                        <option value="1"<?php if ($pedigree['stdesc'] == 1) {
                                            echo " selected";
                                        } ?>><?php echo _('Collapsed'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class='align-top'><span class="normal"><?php echo _('Show Notes and Custom Events on Register'); ?>:</span></td>
                                <td>
                                    <select name="regnotes">
                                        <option value="0"<?php if (!$pedigree['regnotes']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                        <option value="1"<?php if ($pedigree['regnotes']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class='align-top'><span class="normal"><?php echo _('Register Generations'); ?>:</span></td>
                                <td>
                                    <select name="regnosp">
                                        <option value="0"<?php if (!$pedigree['regnosp']) {
                                            echo " selected";
                                        } ?>><?php echo _('Always show everyone'); ?></option>
                                        <option value="1"<?php if ($pedigree['regnosp']) {
                                            echo " selected";
                                        } ?>><?php echo _('Remove individuals with no family'); ?></option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>

                </td>
            </tr>

            <tr class="databack tngshadow">
                <td class="tngshadow">
                    <?php echo displayToggle("plus2", 0, "rel", _('Relationship Chart'), ""); ?>

                    <div id="rel" style="display:none;">
                        <table>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td><span class="normal"><?php echo _('Initial Relationships'); ?>:</span></td>
                                <td>
                                    <input type="text" value="<?php echo $pedigree['initrels']; ?>" name="initrels" size="5">
                                </td>
                            </tr>
                            <tr>
                                <td><span class="normal"><?php echo _('Max Relationships'); ?>:</span></td>
                                <td>
                                    <input type="text" value="<?php echo $pedigree['maxrels']; ?>" name="maxrels" size="5">
                                </td>
                            </tr>
                            <tr>
                                <td><span class="normal"><?php echo _('Max Generations'); ?>:</span></td>
                                <td>
                                    <input type="text" value="<?php echo $pedigree['maxupgen']; ?>" name="maxupgen" size="5">
                                </td>
                            </tr>
                        </table>
                    </div>

                </td>
            </tr>

            <tr class="databack tngshadow">
                <td class="tngshadow">
                    <?php echo displayToggle("plus3", 0, "time", _('Timeline Chart'), ""); ?>

                    <div id="time" style="display:none;">
                        <table>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td><span class="normal"><?php echo _('Starting chart width'); ?>:</span></td>
                                <td>
                                    <input type="text" value="<?php echo $pedigree['tcwidth']; ?>" name="tcwidth" size="5">
                                </td>
                            </tr>
                            <tr>
                                <td><span class="normal"><?php echo _('Enable Simile timeline'); ?>:</span></td>
                                <td>
                                    <select name="simile" onchange="new Effect.toggle('simileTable', 'appear',{duration:.2});">
                                        <option value="0"<?php if (!$pedigree['simile']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                        <option value="1"<?php if ($pedigree['simile']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <table<?php if (!$pedigree['simile']) {
                            echo " style='display: none;'";
                        } ?> id="simileTable">
                            <tr>
                                <td><span class="normal"><?php echo _('Chart height'); ?>:</span></td>
                                <td>
                                    <input type="text" value="<?php echo $pedigree['tcheight']; ?>" name="tcheight" size="5">
                                </td>
                            </tr>
                            <tr>
                                <td><span class="normal"><?php echo _('Events to include'); ?>:</span></td>
                                <td>
                                    <select name="tcevents">
                                        <option value="0"<?php if (!$pedigree['tcevents']) {
                                            echo " selected";
                                        } ?>><?php echo _('All events'); ?></option>
                                        <option value="1"<?php if ($pedigree['tcevents']) {
                                            echo " selected";
                                        } ?>><?php echo _('Only events that fall within the lifespans of the people on the chart'); ?></option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>

                </td>
            </tr>

            <tr class="databack tngshadow">
                <td class="tngshadow">
                    <?php echo displayToggle("plus4", 0, "peddesc", _('Common Elements'), ""); ?>

                    <div id="peddesc" style="display:none;">
                        <table>
                            <tr>
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class='align-top'>
                                    <table class="normal">
                                        <tr>
                                            <td><?php echo _('Left Indent'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $pedigree['leftindent']; ?>" name="leftindent" size="10">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Box Name Size'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $pedigree['boxnamesize']; ?>" name="boxnamesize" size="10">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Box Dates Size'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $pedigree['boxdatessize']; ?>" name="boxdatessize" size="10">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Box Color'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $pedigree['boxcolor']; ?>" name="boxcolor" id="boxcolor" size="8">
                                                <A HREF="#" onClick="cp.select(document.form1.boxcolor,'pick1');return false;" NAME="pick1" ID="pick1"><img
                                                        src="img/tng_colorpicker.gif" alt="" width="19" height="17" border="0"></A></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Color Shift (%)'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $pedigree['colorshift']; ?>" name="colorshift" size="10">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Empty Color'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $pedigree['emptycolor']; ?>" name="emptycolor" id="emptycolor" size="8">
                                                <A HREF="#" onClick="cp.select(document.form1.emptycolor,'pick2');return false;" NAME="pick2"
                                                    ID="pick2"><img src="img/tng_colorpicker.gif" alt="" width="19" height="17"></A></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Border Color'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $pedigree['bordercolor']; ?>" name="bordercolor" id="bordercolor" size="8">
                                                <A HREF="#" onClick="cp.select(document.form1.bordercolor,'pick3');return false;" NAME="pick3"
                                                    ID="pick3"><img src="img/tng_colorpicker.gif" alt="" width="19" height="17"></A></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Shadow Color'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $pedigree['shadowcolor']; ?>" name="shadowcolor" id="shadowcolor" size="8">
                                                <A HREF="#" onClick="cp.select(document.form1.shadowcolor,'pick4');return false;" NAME="pick4"
                                                    ID="pick4"><img src="img/tng_colorpicker.gif" alt="" width="19" height="17"></A></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Shadow Offset'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $pedigree['shadowoffset']; ?>" name="shadowoffset" size="10">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Box Horizontal Separation'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $pedigree['boxHsep']; ?>" name="boxHsep" size="10">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Box Vertical Separation'); ?>:</td>
                                            <td>
                                                <input type="text" value="<?php echo $pedigree['boxVsep']; ?>" name="boxVsep" size="10">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo _('Default PDF Page Size'); ?>:</td>
                                            <td>
                                                <select name="pagesize">
                                                    <option value="a3"<?php if ($pedigree['pagesize'] == "a3") {
                                                        echo " selected";
                                                    } ?>>A3
                                                    </option>
                                                    <option value="a4"<?php if ($pedigree['pagesize'] == "a4") {
                                                        echo " selected";
                                                    } ?>>A4
                                                    </option>
                                                    <option value="a5"<?php if ($pedigree['pagesize'] == "a5") {
                                                        echo " selected";
                                                    } ?>>A5
                                                    </option>
                                                    <option value="letter"<?php if (!$pedigree['pagesize'] || $pedigree['pagesize'] == "letter") {
                                                        echo " selected";
                                                    } ?>><?php echo _('Letter'); ?></option>
                                                    <option value="legal"<?php if ($pedigree['pagesize'] == "legal") {
                                                        echo " selected";
                                                    } ?>><?php echo _('Legal'); ?></option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="20">&nbsp;</td>
                                <td class='align-top'>
                                    <table>
                                        <tr>
                                            <td class='align-top'><span class="normal"><?php echo _('Line Width'); ?>:</span></td>
                                            <td>
                                                <input type="text" value="<?php echo $pedigree['linewidth']; ?>" name="linewidth" size="10">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class='align-top'><span class="normal"><?php echo _('Border Width'); ?>:</span></td>
                                            <td>
                                                <input type="text" value="<?php echo $pedigree['borderwidth']; ?>" name="borderwidth" size="10">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class='align-top'><span class="normal"><?php echo _('Popup Color'); ?>:</span></td>
                                            <td>
                                                <input type="text" value="<?php echo $pedigree['popupcolor']; ?>" name="popupcolor" id="popupcolor" size="8">
                                                <A HREF="#" onClick="cp.select(document.form1.popupcolor,'pick5');return false;" NAME="pick5"
                                                    ID="pick5"><img src="img/tng_colorpicker.gif" alt="" width="19" height="17"></A></td>
                                        </tr>
                                        <tr>
                                            <td class='align-top'><span class="normal"><?php echo _('Popup Info Size'); ?>:</span></td>
                                            <td>
                                                <input type="text" value="<?php echo $pedigree['popupinfosize']; ?>" name="popupinfosize" size="10">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class='align-top'><span class="normal"><?php echo _('Popup Timer (ms)'); ?>:</span></td>
                                            <td>
                                                <input type="text" value="<?php echo $pedigree['popuptimer']; ?>" name="popuptimer" size="10">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class='align-top'><span class="normal"><?php echo _('Popup Event'); ?>:</span></td>
                                            <td>
                                                <select name="pedevent">
                                                    <option value="down"<?php if ($pedigree['event'] == "down") {
                                                        echo " selected";
                                                    } ?>><?php echo _('Mouse Down'); ?></option>
                                                    <option value="over"<?php if ($pedigree['event'] == "over") {
                                                        echo " selected";
                                                    } ?>><?php echo _('Mouse Over'); ?></option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class='align-top'><span class="normal"><?php echo _('Box Width (w/popups)'); ?>:</span></td>
                                            <td>
                                                <input type="text" value="<?php echo $pedigree['puboxwidth']; ?>" name="puboxwidth" size="10">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class='align-top'><span class="normal"><?php echo _('Box Height (w/popups)'); ?>:</span></td>
                                            <td>
                                                <input type="text" value="<?php echo $pedigree['puboxheight']; ?>" name="puboxheight" size="10">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class='align-top'><span class="normal"><?php echo _('Box Alignment (w/popups)'); ?>:</span></td>
                                            <td>
                                                <select name="puboxalign">
                                                    <option value="center"<?php if ($pedigree['puboxalign'] == "center") {
                                                        echo " selected";
                                                    } ?>><?php echo _('Center'); ?></option>
                                                    <option value="left"<?php if ($pedigree['puboxalign'] == "left") {
                                                        echo " selected";
                                                    } ?>><?php echo _('Left'); ?></option>
                                                    <option value="right"<?php if ($pedigree['puboxalign'] == "right") {
                                                        echo " selected";
                                                    } ?>><?php echo _('Right'); ?></option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class='align-top'><span class="normal"><?php echo _('Box Height Shift (w/popups)'); ?>:</span></td>
                                            <td>
                                                <input type="text" value="<?php echo $pedigree['puboxheightshift']; ?>" name="puboxheightshift" size="10">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class='align-top'><span class="normal"><?php echo _('Include Photos'); ?>:</span></td>
                                            <td><span class="normal"><input type="radio" name="inclphotos" value="1" <?php if ($pedigree['popupchartlinks']) {
                                                        echo "checked";
                                                    } ?>> <?php echo _('Yes'); ?> <input type="radio" name="inclphotos" value="0" <?php if (!$pedigree['inclphotos']) {
                                                        echo "checked";
                                                    } ?>> <?php echo _('No'); ?></span></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>

                </td>
            </tr>

            <tr class="databack tngshadow">
                <td class="tngshadow">
                    <input type="submit" name="submit" class="btn" value="<?php echo _('Save'); ?>">
                </td>
            </tr>

        </table>
    </form>
<?php echo tng_adminfooter(); ?>
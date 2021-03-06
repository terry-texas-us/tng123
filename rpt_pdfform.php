<?php
switch ($_GET['pdftype']) {
    case "ped":
    case "desc":
        $textpart = "pedigree";
        break;
    case "fam":
        $textpart = "familygroup";
        break;
    default:
        $textpart = "getperson";
        break;
}

$tngprint = 1;
include "tng_begin.php";
include "config/pedconfig.php";

if ($pdftype == "ped") {
    $dest = "rpt_pedigree";
    $genmax = !$pedigree['maxgen'] || $pedigree['maxgen'] > 6 ? 6 : $pedigree['maxgen'];
    $genmin = 2;
    $allow_blank = 1;
    $allow_cite = 0;
    $hdrFontSizes = [9, 10, 12, 14];
    $hdrFontDefault = 14;
    $lblFontSizes = [];
    $rptFontSizes = [8];
    $titleidx = 'pedigreefor';
} elseif ($pdftype == "desc") {
    $dest = "rpt_descend";
    $genmin = 2;
    $genmax = !$pedigree['maxdesc'] || $pedigree['maxdesc'] > 12 ? 12 : $pedigree['maxdesc'];
    $allow_blank = 0;
    $allow_cite = 0;
    $hdrFontSizes = [9, 10, 12, 14];
    $hdrFontDefault = 14;
    $lblFontSizes = [];
    $rptFontSizes = [9, 10, 12, 14];
    $rptFontDefault = 10;
    $titleidx = 'descendfor';
} elseif ($pdftype == "fam") {
    $dest = "rpt_fam";
    $genmin = 0;
    $genmax = 0;
    $allow_blank = 1;
    $allow_cite = 1;
    $hdrFontSizes = [9, 10, 12, 14];
    $hdrFontDefault = 14;
    $lblFontSizes = [10];
    $rptFontSizes = [9, 10, 12, 14];
    $rptFontDefault = 10;
    $titleidx = 'familygroupfor';
} else {
    $dest = "rpt_ind";
    $genmin = 0;        // no generations option
    $genmax = 0;
    $allow_blank = 1;
    $allow_cite = 1;
    $hdrFontSizes = [9, 10, 12, 14];
    $hdrFontDefault = 14;
    $lblFontSizes = [9];
    $rptFontSizes = [9, 10, 12, 14];
    $rptFontDefault = 10;
    $titleidx = 'indreportfor';
}

function doGenOptions($generations, $first, $last) {
    echo '<select name="genperpage">';
    for ($i = $first; $i <= $last; $i++) {
        echo "<option value=\"$i\"";
        if ($i == $generations) echo " selected";

        echo ">$i</option>\n";
    }
    echo '</select>';
}

function doFontOptions($field, $default = 'helvetica') {
    global $font_list;

    echo "<select name=\"$field\">";
    $fonts = array_keys($font_list);
    sort($fonts);
    foreach ($fonts as $font) {
        echo "<option value=\"$font\"";
        if ($font == $default) print " selected";

        echo ">$font_list[$font]</option>";
    }
    echo '</select>';
}

function doFontSizeOptions($field, $options, $default) {
    if (count($options) == 1) {
        echo "<span class='normal'>$options[0] pt</span>";
        echo "<input type='hidden' name=\"$field\" value=\"$options[0]\">";
    } else {
        echo "<select name=\"$field\">";
        foreach ($options as $size) {
            echo "<option value=\"$size\"";
            if ($default == $size) print " selected";

            echo ">$size</option>";
        }
        echo '</select> pt';
    }
}

$savetype = $pdftype;
// load the list of available fonts
$font_dir = $rootpath . $endrootpath . 'font';
if (is_dir($font_dir)) {
    if ($session_charset == 'UTF-8') {
        if ($dh = opendir($font_dir . '/unifont')) {
            while (($fontfamily = readdir($dh)) !== false) {
                //Added @eaDir to ignore Synology files
                if (is_dir("$font_dir/unifont/$fontfamily") && $fontfamily != "." && $fontfamily != ".." && $fontfamily != "@eaDir") {
                    $font_list[$fontfamily] = $fontfamily;
                }
            }
        }
    } else {
        if ($dh = opendir($font_dir)) {
            while (($fontfamily = readdir($dh)) !== false) {
                //Added @eaDir to ignore Synology files
                if (is_dir("$font_dir/$fontfamily") && $fontfamily != "." && $fontfamily != ".." && $fontfamily != "unifont" && $fontfamily != "@eaDir") {
                    $fontkey = $fontfamily;
                    $font_list[$fontkey] = ucfirst($fontfamily);
                }
            }
        }
    }
}
$pdftype = $savetype;

if ($pdftype == "fam") {
    $result = getFamilyData($tree, $familyID);
    $famrow = tng_fetch_assoc($result);
    $titletext = getFamilyName($famrow);
} else {
    $result = getPersonSimple($tree, $personID);
    if ($result) {
        $row = tng_fetch_assoc($result);

        $righttree = checktree($tree);
        $rights = determineLivingPrivateRights($row, $righttree);
        $row['allow_living'] = $rights['living'];
        $row['allow_private'] = $rights['private'];

        $pedname = getName($row);
        tng_free_result($result);
        $titletext = "$pedname ($personID)";
    }
}

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack ajaxwindow" id="finddiv">
    <h4 class="subhead"><?php echo _('PDF Generator'); ?></h4>
    <br>
    <h5 class="subhead"><span class="normal" style="padding-bottom:3px;"><?php echo $text[$titleidx]; ?></span><br><?php echo $titletext; ?></h5>
    <?php
    if (count($font_list) == 0) {
        echo "ERROR: There are no fonts installed to support character set $session_charset.";
        return;
    }
    echo getFORM($dest, "post", "pdfform", "pdfform");
    // determine if we need to draw a generations option
    if ($genmin > 0 || $genmax > 0) {
        if ($generations < $genmin) $generations = $genmin;

        if ($generations > $genmax) $generations = $genmax;

        ?>
        <table id="genselect" cellpadding="0" class="normal">
            <tr>
                <td>
                    <span class="normal"><?php echo _('Generations'); ?>:</span>
                </td>
                <td>
                    <?php doGenOptions($generations, $genmin, $genmax); ?>
                </td>
            </tr>
            <?php if ($pdftype == "ped" || $pdftype == "desc") { ?>
                <tr>
                    <td class="ws">
                        <span class="normal"><?php echo _('First Number'); ?>:</span>
                    </td>
                    <td>
                        <input type="text" name="startnum" value="1" size="4">
                    </td>
                </tr>
            <?php } ?>
        </table>

        <?php
    }

    // draw the blank form checkbox
    if ($allow_blank) {
        ?>
        <div class="pdfblock normal">
            <input type="checkbox" id="blankform" name="blankform" value="1"> <?php echo _('Blank Chart'); ?></div>
        <?php
    }

    // draw the citations checkbox
    if ($allow_cite) {
        ?>
        <div class="pdfblock normal">
            <input type="checkbox" id="citesources" name="citesources" value="1" checked="1"> <?php echo _('Include Sources'); ?></div>
        <?php
    }
    if ($pdftype == "fam") {
        echo "<input type='hidden' name=\"familyID\" value='$familyID'>\n";
    } else {
        echo "<input type='hidden' name=\"personID\" value=\"$personID\">\n";
    }
    ?>
    <input type="hidden" name="tree" value="<?php echo $tree; ?>">

    <?php if ($pdftype == "desc") { ?>
        // options specific to certain report types
        <div class="pdfblock subhead">
            <a href="#" onClick="return toggleSection('dispopts','dispicon','');" class="pdftoggle">
                <img src="img/tng_expand.gif" id="dispicon" class="inline-block"> <?php echo _('Display Options'); ?>
            </a>
        </div>
        <div style="display:none;" id="dispopts">
            <table id="display" cellpadding="3" class="normal">
                <tr>
                    <td>
                        <span class="normal"><?php echo _('Dates and Locations'); ?>:&nbsp;</span>
                    </td>
                    <td>
                        <select name="getPlace">
                            <option value="1" selected><?php echo _('Birth/Alt - Death/Burial'); ?></option>
                            <option value="2"><?php echo _('No Birth or Death Dates'); ?></option>
                            <option value="3"><?php echo _('All Birth/Alt/Death/Burial data'); ?></option>
                        </select>
                    </td>
                </tr>
                <td>
                    <span class="normal"><?php echo _('Numbering System'); ?>:&nbsp;</span>
                </td>
                <td>
                    <select name="numbering">
                        <option value="0"><?php echo _('No encryption'); ?></option>
                        <option value="1" selected><?php echo _('Generation Numbers'); ?></option>
                        <option value="2"><?php echo _('Henry Numbers'); ?></option>
                        <option value="3"><?php echo _('d\'Aboville Numbers'); ?></option>
                        <option value="4"><?php echo _('de Villiers Numbers'); ?></option>
                    </select>
                </td>
                <tr>
            </table>
            <br>
        </div>
    <?php } ?>

    <!-- Font section -->
    <div class="pdfblock subhead">
        <a href="#" class="pdftoggle" onClick="return toggleSection('font','fonticon','');">
            <img src="img/tng_expand.gif" id="fonticon" class="inline-block"> <?php echo _('Fonts'); ?>
        </a>
    </div>
    <div style="display:none;" id="font">
        <table cellpadding="3" class="normal">
            <tr>
                <td><?php echo _('Family'); ?></td>
                <td>
                    <?php doFontOptions('rptFont'); ?>
                </td>
            </tr>
            <?php
            // header fonts
            if (count($hdrFontSizes) > 1) {
                ?>
                <tr>
                    <td>
                        <span class="normal"><?php echo _('Header'); ?>:&nbsp;</span>
                    </td>
                    <td>
                        <?php doFontSizeOptions('hdrFontSize', $hdrFontSizes, $hdrFontDefault); ?>
                    </td>
                </tr>
                <?php
            }

            // label fonts
            if (count($lblFontSizes) > 1) {
                ?>
                <tr>
                    <td>
                        <span class="normal"><?php echo _('Labels'); ?>:&nbsp;</span>
                    </td>
                    <td>
                        <?php doFontSizeOptions('lblFontSize', $lblFontSizes, $lblFontDefault); ?>
                    </td>
                </tr>
                <?php
            }

            // data fonts
            if (count($rptFontSizes) > 1) {
                ?>
                <tr>
                    <td>
                        <span class="normal"><?php echo _('Data'); ?>:&nbsp;</span>
                    </td>
                    <td>
                        <?php doFontSizeOptions('rptFontSize', $rptFontSizes, $rptFontDefault); ?>
                    </td>
                </tr>
                <?php
            }
            $pagesize = $_COOKIE['tng_pagesize'] ? $_COOKIE['tng_pagesize'] : $pedigree['pagesize'];
            ?>
        </table>
        <?php
        if (count($hdrFontSizes) == 1) {
            echo "<input type='hidden' name=\"hdrFontSize\" value=\"$hdrFontSizes[0]\">";
        }
        if (count($lblFontSizes) == 1) {
            echo "<input type='hidden' name=\"lblFontSize\" value=\"$lblFontSizes[0]\">";
        }
        if (count($rptFontSizes) == 1) {
            echo "<input type='hidden' name=\"rptFontSize\" value=\"$rptFontSizes[0]\">";
        }
        ?>
        <br>
    </div>

    <!-- Page setup section -->
    <div class="pdfblock subhead">
        <a href="#" class="pdftoggle" onClick="return toggleSection('pgsetup','pgicon','');">
            <img src="img/tng_expand.gif" id="pgicon" class="inline-block"> <?php echo _('Page Setup'); ?>
        </a>
    </div>
    <div style="display:none;" id="pgsetup">
        <table cellpadding="3" class="normal">
            <tr>
                <td>
                    <span class="normal"><?php echo _('Page Size'); ?>:&nbsp;</span>
                </td>
                <td>
                    <select name="pagesize">
                        <option value="a3"<?php if ($pagesize == "a3") {
                            echo "selected";
                        } ?>>A3
                        </option>
                        <option value="a4"<?php if ($pagesize == "a4") {
                            echo "selected";
                        } ?>>A4
                        </option>
                        <option value="a5"<?php if ($pagesize == "a5") {
                            echo "selected";
                        } ?>>A5
                        </option>
                        <option value="letter"<?php if (!$pagesize || $pagesize == "letter") {
                            echo "selected";
                        } ?>><?php echo _('Letter'); ?></option>
                        <option value="legal<?php if ($pagesize == "legal") {
                            echo "selected";
                        } ?>"><?php echo _('Legal'); ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="normal"><?php echo _('Orientation'); ?>:&nbsp;</span>
                </td>
                <td>
                    <select name="orient">
                        <option value=p selected><?php echo _('Portrait'); ?></option>
                        <option value=l><?php echo _('Landscape'); ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="normal"><?php echo _('Top Margin'); ?>:&nbsp;</span>
                </td>
                <td>
                    <input type="text" value="0.5" name="topmrg" size="5">
                </td>
            </tr>
            <tr>
                <td>
                    <span class="normal"><?php echo _('Bottom Margin'); ?>:&nbsp;</span>
                </td>
                <td>
                    <input type="text" value="0.5" name="botmrg" size="5">
                </td>
            </tr>
            <tr>
                <td>
                    <span class="normal"><?php echo _('Left Margin'); ?>:&nbsp;</span>
                </td>
                <td>
                    <input type="text" value="0.5" name="lftmrg" size="5">
                </td>
            </tr>
            <tr>
                <td>
                    <span class="normal"><?php echo _('Right Margin'); ?>:&nbsp;</span>
                </td>
                <td>
                    <input type="text" value="0.5" name="rtmrg" size="5">
                </td>
            </tr>
        </table>
    </div>
    <br>
    <input type="submit" onclick="this.form.target='_blank'" class="btn" value="<?php echo _('Create Chart'); ?>">

    </form>

</div>
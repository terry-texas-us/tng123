<?php
include "begin.php";
include "adminlib.php";
$textpart = "templates";
include "$mylanguage/admintext.php";

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

$tmp = getAllTemplatesVars($templates_table);

$languageArray = [];
$query = "SELECT display, folder FROM $languages_table ORDER BY display";
$result = tng_query($query);
$languageList = tng_num_rows($result) ? "<option value=''></option>\n" : "";
while ($row = tng_fetch_assoc($result)) {
    $key = $row['folder'];
    $languageList .= "<option value=\"$key\">{$row['display']}</option>\n";
    $languageArray[$key] = $row['display'];
}
tng_free_result($result);

$treequery = "SELECT gedcom, treename FROM $trees_table ORDER BY treename";
$treeresult = tng_query($treequery) or die (_('Cannot execute query') . ": $treequery");
$treenum = 0;
while ($treerow = tng_fetch_assoc($treeresult)) {
    $treenum++;
    $trees[$treenum] = $treerow['gedcom'];
    $treename[$treenum] = $treerow['treename'];
}
tng_free_result($treeresult);

$helplang = findhelp("templateconfig_help.php");

tng_adminheader(_('Modify Template Configuration Settings'), $flags);
?>
    <script src="js/mediautils.js"></script>
    <script src="js/selectutils.js"></script>
    <script>
        function switchTemplates(newtemp) {
            jQuery('div.tsection').each(function (index, item) {
                item.style.display = item.id === "t" + newtemp ? '' : 'none';
            });
        }

        function insertCell(row, index, content) {
            var cell = row.insertCell(index);
            cell.innerHTML = content ? content : content + '&nbsp;';
            if (!index) cell.vAlign = "top";
            return cell;
        }

        function insertLangRow(rowID, type) {
            var language = jQuery('#lang_' + rowID);
            var langVal = language.val();
            if (langVal && !jQuery('#form_' + rowID + '_' + langVal).length) {
                var row = document.getElementById(rowID);
                var langElem = language[0];
                var langDisplay = langElem.options[langElem.selectedIndex].innerHTML;
                var table = row.parentNode;
                var newtr = table.insertRow(row.rowIndex + 1);
                var label = "&nbsp;&nbsp;" + jQuery('#' + rowID + ' :first-child').html();
                insertCell(newtr, 0, label + "<br>&nbsp;&nbsp;&nbsp;(" + langDisplay + ")");
                var inputstr = type === "textarea" ? "<textarea name=\"form_" + rowID + "_" + langVal + "\" id=\"form_" + rowID + "_" + langVal + "\" rows='3' cols='80'></textarea>" : "<input type='text' class='longfield' name=\"form_" + rowID + "_" + langVal + "\" id=\"form_" + rowID + "_" + langVal + "\">";
                insertCell(newtr, 1, inputstr);
                insertCell(newtr, 2, "");
            }
            return false;
        }

        function showUploadBox(key, folder) {
            jQuery('#div_' + key).html("<input type=\"file\" name=\"upload_" + key + "\" onchange=\"populateFileName(this,jQuery('#form_" + key + "'));\"> <?php echo _('OR'); ?> <input type='button' value=\"<?php echo _('Select'); ?>\" name=\"photoselect_" + key + "\" onclick=\"javascript:FilePicker('form_" + key + "','" + folder + "');\" >");
            jQuery('#div_' + key).toggle();
            return false;
        }

        function populateFileName(source, dest) {
            const temp = source.value.replace(/\\/g, "/");
            const lastslash = temp.lastIndexOf("/") + 1;
            dest.val(lastslash > 0 ? 'img/' + source.value.slice(lastslash) : 'img/' + source.value);
        }

        function preview(sFileName) {
            window.open(escape(sFileName), "File", "width=400,height=250,status=no,resizable=yes,scrollbars=yes");
            return false;
        }

        function getTopValues(flagfield, numfield) {
            const topflagfield = document.formtop1.form_templateswitching;
            flagfield.value = topflagfield.options[topflagfield.selectedIndex].value;
            const topnumfield = document.formtop2.form_templatenum;
            numfield.value = topnumfield.options[topnumfield.selectedIndex].value;
        }

        jQuery(document).ready(function () {
            jQuery('#previewbtn').click(function (e) {
                e.preventDefault();
                jQuery('#previewscroll').toggle();
                jQuery('.prevmsg').toggle();
                return false;
            });
            jQuery('.prevdiv').click(function (e) {
                e.preventDefault();
                const id = this.id.substring(4);
                jQuery('#form_templatenum').val(id);
                switchTemplates(id);
                return false;
            });
        });
    </script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$setuptabs[0] = [1, "admin_setup.php", _('Configuration'), "configuration"];
$setuptabs[1] = [1, "admin_diagnostics.php", _('Diagnostics'), "diagnostics"];
$setuptabs[2] = [1, "admin_setup.php?sub=tablecreation", _('Table Creation'), "tablecreation"];
$setuptabs[3] = [1, "#", _('Template Settings'), "template"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/templateconfig_help.php');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($setuptabs, "template", $innermenu);
echo displayHeadline(_('Setup') . " &gt;&gt; " . _('Configuration') . " &gt;&gt; " . _('Template Settings'), "img/setup_icon.gif", $menu, "");
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <form name="formtop1">
                    <label for="form_templateswitching"><?php echo _('Enable Template Selection'); ?>:</label>
                    <select name="form_templateswitching" id="form_templateswitching">
                        <option value="0"<?php if (!$templateswitching) {
                            echo " selected";
                        } ?>><?php echo _('No'); ?></option>
                        <option value="1"<?php if ($templateswitching) {
                            echo " selected";
                        } ?>><?php echo _('Yes'); ?></option>
                    </select>
                </form>
            </td>
        </tr>
        <tr class="databack">
            <td class="tngshadow">
                <form name="formtop2">
                    <label for="form_templatenum"><b><?php echo _('Template'); ?>:</b></label>
                    <?php
                    chdir($rootpath . $endrootpath . TEMPLATES_PATH);
                    $totaltemplates = 0;
                    $sections = [];
                    $entries = [];
                    $folders = [];
                    if ($handle = @opendir('.')) {
                        while ($filename = readdir($handle)) {
                            if (is_dir($filename) && $filename != "." && $filename != "..") {
                                $i = substr($filename, 0, 8) == "template" && is_numeric(substr($filename, 8)) ? substr($filename, 8) : $filename;
                            $totaltemplates++;
                            $sections['t' . $i] = "";
                            $entries[] = $i;
                            $folders['t' . $i] = $filename;
                        }
                    }
                    closedir($handle);
                }
                natcasesort($entries);
                $entries = array_reverse($entries);
                ?>
                <select name="form_templatenum" id="form_templatenum" onchange="switchTemplates(jQuery(this).val());">
                    <option value=""></option>
                    <?php
                    foreach ($entries as $entry) {
                        echo "<option value=\"$entry\"";
                        if ($templatenum == $entry) echo " selected";

                        $tprefix = is_numeric($entry) ? _('Template') . " " : "";
                        echo ">$tprefix$entry</option>\n";
                    }
                    ?>
                </select>
                    <button id="previewbtn"><span class="prevmsg"><?php echo _('Show Previews'); ?></span><span class="prevmsg" style="display:none;"><?php echo _('Hide Previews'); ?></span></button>
                </form>

                <div style="display:none;" id="previewscroll" class="scroller">
                    <br>
                    <div style="position:absolute;">
                        <?php
                        foreach ($entries as $i) {
                            $newtemplatepfx = is_numeric($i) ? "template" : "";
                            echo "<div class='prevdiv' id=\"prev$i\"><span class='prevnum'>$i:</span>";
                            if (file_exists("{$rootpath}{$endrootpath}templates/$newtemplatepfx$i/img/preview1sm.jpg")) {
                            echo "<img src=\"templates/$newtemplatepfx$i/img/preview1sm.jpg\" class='temppreview mx-2' alt=''>";
                        }
                        if (file_exists("{$rootpath}{$endrootpath}templates/$newtemplatepfx$i/img/preview2sm.jpg")) {
                            echo "<img src=\"templates/$newtemplatepfx$i/img/preview2sm.jpg\" class='temppreview mr-3' alt=''>\n";
                        }
                        echo "</div>\n";
                    }
                    ?>
                </div>
            </div>

            <br><br>
            <?php
            $textareas = ['mainpara', 'searchpara', 'fhpara', 'fhlinkshis', 'fhlinkshers', 'mwpara', 'featurepara', 'respara', 'featurelinks', 'reslinks', 'headtitle', 'headsubtitle', 'latestnews', 'featurepara1', 'featurepara2', 'featurepara3', 'featurepara4', 'featurepara5', 'featurepara6', 'featurepara7', 'featurepara8', 'photocaption', 'newstext', 'featurespara', 'textpara1', 'textpara2', 'textpara3', 'photocaptionl', 'photocaptionr', 'snipinfoone', 'snipinfotwo', 'quote'];
            //needtrans: these fields can be duplicated in another language
            $needtrans = ['headline', 'maintitle', 'welcome', 'hisside', 'herside', 'headtitle1', 'headtitle2', 'headtitle3', 'momside', 'dadside', 'mainpara', 'featurepara', 'searchpara', 'fhpara', 'mwpara', 'respara', 'headtitle', 'headsubtitle', 'latestnews', 'featuretitle1', 'featuretitle2', 'featuretitle3', 'featuretitle4', 'featuretitle5', 'featuretitle6', 'featurepara1', 'featurepara2', 'featurepara3', 'featurepara4', 'featurepara5', 'featurepara6', 'featurepara7', 'featurepara8', 'photocaption', 'newstext', 'menutitle', 'phototitlel', 'photocaptionl', 'phototitler', 'photocaptionr', 'topsurnames', 'featurespara', 'sidebarhead1', 'sidebarhead2', 'sidebarhead3', 'texttitle1', 'texttitle2', 'texttitle3', 'textpara1', 'textpara2', 'textpara3', 'subhead1', 'subhead2', 'snipinfoone', 'snipinfotwo', 'quote', 'subhead'];
            foreach ($tmp as $key => $value) {
                $parts = explode("_", $key);
                $n = $parts[0];
                $label = $parts[1];
                $label_parts = explode("-", $label);
                if (isset($label_parts[1])) {
                    $index = " " . $label_parts[1];
                    $label = $label_parts[0];
                } else {
                    $index = "";
                }
                $index = isset($label_parts[1]) ? " " . $label_parts[1] : "";
                $value = preg_replace("/\"/", "&#34;", $value);
                $sections[$n] .= "<tr id=\"$key\">\n";
                if (in_array($label, $textareas)) {
                    $type = "textarea";
                    $align = " valign='top'";
                } elseif (substr($label, -4) === "tree") {
                    $type = "select";
                    $align = "";
                } else {
                    $type = "text";
                    $align = "";
                }
                $sections[$n] .= "<td$align>";
                $sections[$n] .= isset($parts[2]) ? "&nbsp;&nbsp;{$admtext[$label]}{$index}:" : "{$admtext[$label]}{$index}:";
                $sections[$n] .= isset($parts[2]) ? "<br>&nbsp;&nbsp;&nbsp;&nbsp;(" . $languageArray[$parts[2]] . ")" : "";
                $sections[$n] .= "</td>\n";
                $sections[$n] .= "<td>";
                if ($type == "textarea") {
                    $sections[$n] .= "<textarea name=\"form_$key\" id=\"form_$key\" rows='5' cols='80'>$value</textarea>\n";
                } elseif ($type == "select") {
                    $sections[$n] .= "<select name=\"form_$key\" id=\"form_$key\">\n";
                    for ($j = 1; $j <= $treenum; $j++) {
                        $sections[$n] .= "	<option value=\"$trees[$j]\"";
                        if ($value == $trees[$j]) $sections[$n] .= " selected";

                        $sections[$n] .= ">$treename[$j]</option>\n";
                    }
                    $sections[$n] .= "</select>\n";
                } elseif ($label == "titlechoice") {
                    $sections[$n] .= "<input type='radio' name=\"form_$key\" id=\"form_{$key}_image\" value=\"image\"";
                    if ($value == "image") $sections[$n] .= " checked";

                    $sections[$n] .= "> <label for=\"form_{$key}_image\">" . _('Image') . "</label> &nbsp;";
                    $sections[$n] .= "<input type='radio' name=\"form_$key\" id=\"form_{$key}_text\" value=\"text\"";
                    if ($value == "text") $sections[$n] .= " checked";

                    $sections[$n] .= "> <label for=\"form_{$key}_text\">" . _('Text') . "</label> &nbsp;";
                } else {
                    $sections[$n] .= "<input type='text' class='longfield' name=\"form_$key\" id=\"form_$key\" value='$value'>\n";
                    if (strpos($key, "img") !== false || strpos($key, "image") !== false || strpos($key, "thumb") !== false || strpos($key, "photol") !== false || strpos($key, "photor") !== false) {
                        $sections[$n] .= " <input type='button' onclick=\"if(jQuery('#form_$key').val()) return preview('templates/{$folders[$n]}/' + jQuery('#form_$key').val());\" value=\"" . _('Preview') . "\"> <input type='button' onclick=\"return showUploadBox('$key','{$folders[$n]}');\" value=\"" . _('Change') . "\" >\n";
                        $size = @GetImageSize($rootpath . "templates/{$folders[$n]}/$value");
                        if ($size) {
                            $imagesize1 = $size[0];
                            $imagesize2 = $size[1];
                            $sections[$n] .= " &nbsp; $imagesize1 x $imagesize2 px\n";
                        }
                        $sections[$n] .= "<div id=\"div_$key\" style='display: none;'></div>";
                    } elseif (substr($label, -6) == "person") {
                        $treefield = str_replace("person", "tree", $key);
                        $sections[$n] .= "<a href='#' onclick=\"return findItem('I','form_{$key}','',$('#form_{$treefield}').val(),'');\" title=\"" . _('Find...') . "\">\n";
                        $sections[$n] .= "<img src=\"img/tng_find.gif\" title=\"" . _('Find...') . "\" alt=\"" . _('Find...') . "\" class='align-middle' width='20' height='20' style='margin-left:2px; margin-bottom:4px;'>\n";
                        $sections[$n] .= "</a>\n";
                    }
                }
                if ($languageList && !isset($parts[2]) && in_array($label, $needtrans)) {
                    if ($type == "textarea") $sections[$n] .= "<br>";

                    $sections[$n] .= "" . _('Create copy in') . ": \n<select id=\"lang_$key\">\n$languageList\n</select> <input type='button' value=\"" . _('Go') . "\" onclick=\"return insertLangRow('$key','$type');\" >\n";
                }
                $sections[$n] .= "</td>\n</tr>\n";
            }

            foreach ($entries as $i) {
                $section = $sections['t' . $i];
                if ($section) {
                    $dispstr = $templatenum != $i ? " style='display: none;'" : "";
                    echo "<div$dispstr class='tsection' id=\"t$i\">\n";
                    echo "<form action='admin_updatetemplateconfig.php' method='post' name=\"form$i\" enctype='multipart/form-data' onsubmit=\"getTopValues(this.form_templateswitching,this.form_templatenum);\">\n";
                    $newtemplatepfx = is_numeric($i) ? "template" : "";
                    $imagetext = "";
                    if (file_exists("{$rootpath}templates/$newtemplatepfx$i/img/preview1.jpg")) {
                        $imagetext .= "<img src=\"templates/$newtemplatepfx$i/img/preview1.jpg\" id='preview1' class='temppreview mx-2' alt=''> ";
                    }
                    if (file_exists("{$rootpath}templates/$newtemplatepfx$i/img/preview2.jpg")) {
                        $imagetext .= "<img src=\"templates/$newtemplatepfx$i/img/preview2.jpg\" id='preview2' class='temppreview mx-2' alt=''>\n";
                    }
                    if ($imagetext) echo "$imagetext<br>";
                    echo "<p><input type='submit' name='submittop' accesskey='s' value=\"" . _('Save') . "\"></p>\n";
                    echo "<p><strong>" . _('Folder') . ": templates/" . $folders['t' . $i] . "</strong></p>";
                    echo "<table class='tstable normal'>\n";
                    echo "$section";
                    echo "</table>\n";
                    echo "<br><input type='submit' name='submit' accesskey='s' class='btn' value=\"" . _('Save') . "\">\n";
                    echo "<input type='hidden' name='form_templateswitching' value=''>\n";
                    echo "<input type='hidden' name='form_templatenum' value=''>\n";
                    echo "</form>\n";
                    echo "</div>\n";
                }
            }
            ?>
        </td>
    </tr>

</table>
    </form>
<?php echo tng_adminfooter(); ?>
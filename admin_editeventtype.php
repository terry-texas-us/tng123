<?php
include "begin.php";
include "adminlib.php";
$textpart = "eventtypes";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_edit) {
    $message = $admtext['norights'];
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$query = "SELECT * FROM $eventtypes_table WHERE eventtypeID = \"$eventtypeID\"";
$result = tng_query($query);
$row = tng_fetch_assoc($result);
tng_free_result($result);
$row['display'] = preg_replace("/\"/", "&#34;", $row['display']);
$row['tag'] = preg_replace("/\"/", "&#34;", $row['tag']);
$row['type'] = preg_replace("/\"/", "&#34;", $row['type']);

switch ($row['type']) {
    case "I":
        $displaystr = $admtext['individual'];
        break;
    case "F":
        $displaystr = $admtext['family'];
        break;
    case "S":
        $displaystr = $admtext['source'];
        break;
    case "R":
        $displaystr = $admtext['repository'];
        break;
}

$helplang = findhelp("eventtypes_help.php");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['modifyeventtype'], $flags);
?>
<script src="js/eventtypes.js"></script>
<script>
    var display = "";

    function addToDisplay(lang, newdisplay) {
        if (display) display += "|";
        display += lang + "|" + newdisplay;
    }

    function validateForm() {
        let rval = true;

        <?php
        $dispvalues = explode("|", $row['display']);
        $numvalues = count($dispvalues);
        $disppairs = [];
        if ($numvalues > 1) {
            for ($i = 0; $i < $numvalues; $i += 2) {
                $lang = $dispvalues[$i];
                $disppairs[$lang] = $dispvalues[$i + 1];
            }
        }

        if (count($disppairs) > 1) {
            $defdisplay = "";
            $displaytrstyle = " style=\"display:none;\"";
            $otherlangsstyle = "";
        } else {
            $displaytrstyle = "";
            $otherlangsstyle = " style=\"display:none;\"";
            if (count($disppairs) == 1) {
                $defdisplay = $dispvalues[1];
            } else {
                $defdisplay = $row['display'];
            }
            $disppairs = null;
        }

        $query = "SELECT languageID, display, folder FROM $languages_table ORDER BY display";
        $langresult = tng_query($query);
        if (tng_num_rows($langresult)) {
            $displayrows = "";
            while ($langrow = tng_fetch_assoc($langresult)) {
                $lang = $langrow['folder'];
                $displayval = "";
                if (is_array($disppairs)) {
                    $displayval = isset($disppairs[$lang]) ? $disppairs[$lang] : "";
                } else {
                    $displayval = "";
                }
                $display = "{$admtext['display']} ({$langrow['display']})";
                $displayname = "display" . $langrow['languageID'];
                $displayrows .= "<tr>";
                $displayrows .= "<td class='align-top'>$display</td>";
                $displayrows .= "<td><input type='text' name=\"$displayname\" size=\"40\" value=\"$displayval\" onFocus=\"if(this.value == '') this.value = document.form1.defdisplay.value;\"></td>";
                $displayrows .= "</tr>\n";
                echo "if( document.form1.$displayname.value ) addToDisplay('$lang',document.form1.$displayname.value);\n";
            }
        } else {
            $displayrows = "";
        }
        ?>
        if (document.form1.tag2.value.length == 0 && document.form1.tag1.value.length == 0) {
            alert("<?php echo $admtext['selectentertag']; ?>");
            rval = false;
        } else if ((document.form1.tag2.value == "EVEN" || (document.form1.tag2.value == "" && document.form1.tag1.value == "EVEN")) && document.form1.description.value.length == 0) {
            alert("<?php echo $admtext['entertypedesc']; ?>");
            rval = false;
        } else if (display == "" && document.form1.defdisplay.value == "") {
            alert("<?php echo $admtext['enterdisplay']; ?>");
            rval = false;
        } else
            document.form1.display.value = display;

        return rval;
    }

    <?php
    $messages = ['EVEN', 'ADOP', 'ADDR', 'ALIA', 'ANCI', 'BARM', 'BASM', 'CAST', 'CENS', 'CHRA', 'CONF', 'CREM', 'DESI', 'DSCR', 'EDUC', 'EMIG', 'FCOM', 'GRAD', 'IDNO', 'IMMI', 'LANG', 'NATI', 'NATU', 'NCHI', 'NMR', 'OCCU', 'ORDI', 'ORDN', 'PHON', 'PROB', 'PROP', 'REFN', 'RELI', 'RESI', 'RESN', 'RETI', 'RFN', 'RIN', 'SSN', 'WILL', 'ANUL', 'DIV', 'DIVF', 'ENGA', 'MARB', 'MARC', 'MARR', 'MARL'];
    foreach ($messages as $msg) {
        echo "messages['$msg'] = \"" . $admtext[$msg] . "\";\n";
    }
    ?>
</script>
<script src="js/admin.js"></script>
</head>

<body class="admin-body">

<?php
$evtabs[0] = [1, "admin_eventtypes.php", $admtext['search'], "findevent"];
$evtabs[1] = [$allow_add, "admin_neweventtype.php", $admtext['addnew'], "addevent"];
$evtabs[2] = [$allow_edit, "#", $admtext['edit'], "edit"];
$innermenu = "<a href=\"#\" onclick=\"return openHelp('$helplang/eventtypes_help.php#add');\" class=\"lightlink\">{$admtext['help']}</a>";
$menu = doMenu($evtabs, "edit", $innermenu);
echo displayHeadline($admtext['customeventtypes'] . " &gt;&gt; " . $admtext['modifyeventtype'], "img/customeventtypes_icon.gif", $menu, $message);
?>

<table class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <form action="admin_updateeventtype.php" method="post" name="form1" onsubmit="return validateForm();">
                <table class="normal">
                    <tr>
                        <td class='align-top'><?php echo $admtext['assocwith']; ?>:</td>
                        <td>
                            <select name="type" onChange="populateTags(this.options[this.selectedIndex].value,'');">
                                <option value="I"<?php if ($row['type'] == "I") {
                                    echo " selected";
                                } ?>><?php echo $admtext['individual']; ?></option>
                                <option value="F"<?php if ($row['type'] == "F") {
                                    echo " selected";
                                } ?>><?php echo $admtext['family']; ?></option>
                                <option value="S"<?php if ($row['type'] == "S") {
                                    echo " selected";
                                } ?>><?php echo $admtext['source']; ?></option>
                                <option value="R"<?php if ($row['type'] == "R") {
                                    echo " selected";
                                } ?>><?php echo $admtext['repository']; ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'><?php echo $admtext['selecttag']; ?>:</td>
                        <td>
                            <select name="tag1" onChange="if(this.options[this.selectedIndex].value == 'EVEN') {toggleTdesc(1);} else {toggleTdesc(0);}">
                                <option value="<?php echo $row['tag']; ?>"><?php echo $row['tag']; ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'>
                            &nbsp; <?php echo $admtext['orenter']; ?>:
                        </td>
                        <td>
                            <input type="text" name="tag2" size="10" onBlur="if(this.value == 'EVEN') {toggleTdesc(1);} else {toggleTdesc(0);}">
                            (<?php echo $admtext['ifbothdata']; ?>)
                        </td>
                    </tr>
                    <tr id="tdesc">
                        <td class='align-top'><?php echo $admtext['typedescription']; ?>*:</td>
                        <td>
                            <input type="text" name="description" size="40" value="<?php echo $row['description']; ?>">
                        </td>
                    </tr>
                    <tr id="displaytr"<?php echo $displaytrstyle; ?>>
                        <td class='align-top'><?php echo $admtext['display']; ?>:</td>
                        <td>
                            <input type="text" name="defdisplay" size="40" value="<?php echo $defdisplay; ?>">
                        </td>
                    </tr>
                    <?php
                    if ($displayrows) {
                        ?>
                        <tr>
                            <td class="align-top" colspan="2">
                                <br>
                                <hr style="margin-left:0; width:400px;">
                                <?php echo displayToggle("plus0", 0, "otherlangs", $admtext['othlangs'], ''); ?>
                                <table id="otherlangs"<?php echo $otherlangsstyle; ?> class="normal">
                                    <tr>
                                        <td class="align-top" colspan="2"><br><b><?php echo $admtext['allnone']; ?></b><br><br></td>
                                    </tr>
                                    <?php
                                    echo $displayrows;
                                    ?>
                                </table>
                                <hr style="margin-left:0; width:400px;">
                                <br>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td class='align-top'><?php echo $admtext['displayorder']; ?>:</td>
                        <td>
                            <input type="text" name="ordernum" size="4" value="<?php echo $row['ordernum']; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'><?php echo $admtext['evdata']; ?>:</td>
                        <td>
                            <input type="radio" name="keep" value="1" <?php if ($row['keep']) {
                                echo "checked";
                            } ?>> <?php echo $admtext['accept']; ?> &nbsp;
                            <input type="radio" name="keep" value="0" <?php if ($row['keep'] != 1) {
                                echo "checked";
                            } ?>> <?php echo $admtext['ignore']; ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class='align-top'><?php echo $admtext['collapseev']; ?>:</td>
                        <td>
                            <input type="radio" name="collapse" value="1" <?php if ($row['collapse']) {
                                echo "checked";
                            } ?>> <?php echo $admtext['yes']; ?> &nbsp;
                            <input type="radio" name="collapse" value="0" <?php if ($row['collapse'] != 1) {
                                echo "checked";
                            } ?>> <?php echo $admtext['no']; ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class='align-top'><?php echo $admtext['ldsevent']; ?>:</td>
                        <td>
                            <input type="radio" name="ldsevent" value="1" <?php if ($row['ldsevent']) {
                                echo "checked";
                            } ?>> <?php echo $admtext['yes']; ?> &nbsp;
                            <input type="radio" name="ldsevent" value="0" <?php if ($row['ldsevent'] != 1) {
                                echo "checked";
                            } ?>> <?php echo $admtext['no']; ?></td>
                        <td></td>
                    </tr>
                </table>
                <br>
                <input type="hidden" name="eventtypeID" value="<?php echo $eventtypeID; ?>">
                <input type="hidden" name="display" value="">
                <input type="submit" name="submit" accesskey="s" class="btn" value="<?php echo $admtext['savechanges']; ?>">
            </form>
            <p class="normal">*<?php echo $admtext['typerequired']; ?></p>
        </td>
    </tr>

</table>
<?php echo "<div style=\"text-align: center;\"><span class='normal'>$tng_title</span></div>"; ?>
<script>
    populateTags(<?php echo "\"{$row['type']}\",\"{$row['tag']}\""; ?>);
</script>
</body>
</html>
<?php

include "begin.php";
include "adminlib.php";
$textpart = "eventtypes";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_add) {
    $message = $admtext['norights'];
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$helplang = findhelp("eventtypes_help.php");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['addnewevtype'], $flags);
?>
<script type="text/javascript" src="js/eventtypes.js"></script>
<script type="text/javascript">
    function validateForm() {
        let rval = true;
        var display = "";

        <?php
        $query = "SELECT languageID, display, folder FROM $languages_table ORDER BY display";
        $langresult = tng_query($query);
        if (tng_num_rows($langresult)) {
            $displayrows = "";
            while ($langrow = tng_fetch_assoc($langresult)) {
                $lang = $langrow['folder'];
                $display = $admtext['display'] . " ({$langrow['display']})";
                $displayname = "display" . $langrow['languageID'];
                $displayrows .= "<tr>";
                $displayrows .= "<td class='align-top'><span class='normal'>$display</span></td>";
                $displayrows .= "<td><input type='text' name=\"$displayname\" size=\"40\" value=\"\" onFocus=\"if(this.value == '') this.value = document.form1.defdisplay.value;\"></td>";
                $displayrows .= "</tr>\n";
                echo "if( document.form1.$displayname.value ) display = display + \"$lang\" + \"|\" + document.form1.$displayname.value + \"|\";\n";
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

    var messages = new Array();
    <?php
    $messages = ['EVEN', 'ADOP', 'ADDR', 'ALIA', 'ANCI', 'BARM', 'BASM', 'CAST', 'CENS', 'CHRA', 'CONF', 'CREM', 'DESI', 'DSCR', 'EDUC', 'EMIG', 'FCOM', 'GRAD', 'IDNO', 'IMMI', 'LANG', 'NATI', 'NATU', 'NCHI', 'NMR', 'OCCU', 'ORDI', 'ORDN', 'PHON', 'PROB', 'PROP', 'REFN', 'RELI', 'RESI', 'RESN', 'RETI', 'RFN', 'RIN', 'SSN', 'WILL', 'ANUL', 'DIV', 'DIVF', 'ENGA', 'MARB', 'MARC', 'MARR', 'MARL', 'MARS'];
    foreach ($messages as $msg) {
        echo "messages['$msg'] = \"" . $admtext[$msg] . "\";\n";
    }
    ?>
</script>
<script type="text/javascript" src="js/admin.js"></script>
</head>

<body class="admin-body">

<?php
$evtabs[0] = [1, "admin_eventtypes.php", $admtext['search'], "findevent"];
$evtabs[1] = [$allow_add, "admin_neweventtype.php", $admtext['addnew'], "addevent"];
$innermenu = "<a href=\"#\" onclick=\"return openHelp('$helplang/eventtypes_help.php#add');\" class=\"lightlink\">{$admtext['help']}</a>";
$menu = doMenu($evtabs, "addevent", $innermenu);
echo displayHeadline($admtext['customeventtypes'] . " &gt;&gt; " . $admtext['addnewevtype'], "img/customeventtypes_icon.gif", $menu, $message);
?>

<table class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <form action="admin_addeventtype.php" method="post" name="form1" onSubmit="return validateForm();">
                <table class="normal">
                    <tr>
                        <td class='align-top'><?php echo $admtext['assocwith']; ?>:</td>
                        <td>
                            <select name="type" onChange="populateTags(this.options[this.selectedIndex].value,'');">
                                <option value="I"><?php echo $admtext['individual']; ?></option>
                                <option value="F"><?php echo $admtext['family']; ?></option>
                                <option value="S"><?php echo $admtext['source']; ?></option>
                                <option value="R"><?php echo $admtext['repository']; ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'><?php echo $admtext['selecttag']; ?>:</td>
                        <td>
                            <select name="tag1" onChange="if(this.options[this.selectedIndex].value == 'EVEN') {toggleTdesc(1);} else {toggleTdesc(0);}">
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'>
                            &nbsp; <?php echo $admtext['orenter']; ?>:
                        </td>
                        <td>
                            <input type="text" name="tag2" size="10" onblur="if(this.value == 'EVEN') {toggleTdesc(1);} else {toggleTdesc(0);}">
                            (<?php echo $admtext['ifbothdata']; ?>)
                        </td>
                    </tr>
                    <tr id="tdesc">
                        <td class='align-top'><?php echo $admtext['typedescription']; ?>*:</td>
                        <td>
                            <input type="text" name="description" size="40">
                        </td>
                    </tr>
                    <tr id="displaytr">
                        <td class='align-top'><?php echo $admtext['display']; ?>:</td>
                        <td>
                            <input type="text" name="defdisplay" size="40">
                        </td>
                    </tr>
                    <?php if ($displayrows) { ?>
                        <tr>
                            <td class="align-top" colspan="2">
                                <br>
                                <hr style="margin-left:0; width:400px;">
                                <?php echo displayToggle("plus0", 0, "otherlangs", $admtext['othlangs'], ''); ?>
                                <table style="display:none;" id="otherlangs" class="normal">
                                    <tr>
                                        <td class="align-top" colspan="2"><br><b><?php echo $admtext['allnone']; ?></b><br><br></td>
                                    </tr>
                                    <?php echo $displayrows; ?>
                                </table>
                                <hr style="margin-left:0; width:400px;">
                                <br>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td class='align-top'><?php echo $admtext['displayorder']; ?>:</td>
                        <td>
                            <input type="text" name="ordernum" size="4" value="0">
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'><?php echo $admtext['evdata']; ?>:</td>
                        <td>
                            <input type="radio" name="keep" value="1" checked> <?php echo $admtext['accept']; ?> &nbsp;
                            <input type="radio" name="keep" value="0"> <?php echo $admtext['ignore']; ?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class='align-top'><?php echo $admtext['collapseev']; ?>:</td>
                        <td>
                            <input type="radio" name="collapse" value="1"> <?php echo $admtext['yes']; ?> &nbsp;
                            <input type="radio" name="collapse" value="0"
                                   checked> <?php echo $admtext['no']; ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class='align-top'><?php echo $admtext['ldsevent']; ?>:</td>
                        <td>
                            <input type="radio" name="ldsevent" value="1"> <?php echo $admtext['yes']; ?> &nbsp;
                            <input type="radio" name="ldsevent" value="0"
                                   checked> <?php echo $admtext['no']; ?></td>
                        <td></td>
                    </tr>
                </table>
                <br>
                <input type="hidden" name="eventtypeID" value="<?php echo $eventtypeID; ?>">
                <input type="hidden" name="display" value="">
                <input type="submit" name="submit" accesskey="s" class="btn" value="<?php echo $admtext['save']; ?>">
            </form>
            <p class="normal">*<?php echo $admtext['typerequired']; ?></p>
        </td>
    </tr>

</table>
</body>
<?php echo "<div style=\"text-align: center;\"><span class='normal'>$tng_title, v.$tng_version</span></div>"; ?>
<script type="text/javascript">
    populateTags("I", "");
</script>
</html>
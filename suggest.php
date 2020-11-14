<?php
$textpart = "gedcom";
include "tng_begin.php";

$_SESSION['tng_email'] = generatePassword(1);
$_SESSION['tng_comments'] = generatePassword(1);
$_SESSION['tng_yourname'] = generatePassword(1);

$flags['scripting'] = "<script>
function validateForm() {
	if( document.suggest." . $_SESSION['tng_yourname'] . ".value == \"\" ) {
		alert(\"" . _('Please enter your name') . "\");
		return false;
	}
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,6})$/;
	var address = document.suggest." . $_SESSION['tng_email'] . ".value;
	if(address.length == 0 || reg.test(address) == false){
		alert(\"" . _('Please enter a valid e-mail address.') . "\");
		return false;
	}
	else if( document.suggest.em2.value.length == 0 ) {
		alert(\"" . _('Please enter your email address again.') . "\");
		return false;
	}
	else if( document.suggest.{$_SESSION['tng_email']}.value != document.suggest.em2.value ) {
		alert(\"" . _('Your emails do not match. Please enter the same email address in each field.') . "\");
		return false;
	}
	else if( document.suggest." . $_SESSION['tng_comments'] . ".value == \"\" ) {
		alert(\"" . _('Please enter your comments') . "\");
		return false;
	}";
if ($tngconfig['askconsent']) {
    $flags['scripting'] .= "
	else if( !document.suggest.tng_user_consent.checked ) {
		alert(\"" . _('Please give your consent for this site to store personal information.') . "\");
		return false;
	}";
}
$flags['scripting'] .= "
	return true;
}
</script>\n";

$righttree = checktree($tree);
$enttype = preg_replace("/[^A-Za-z0-9_\-. ]/", '', $enttype);
$ID = preg_replace("/[^A-Za-z0-9_\-. ]/", '', $ID);
$page = strip_tags($page);

if ($currentuser) {
    $query = "SELECT email FROM $users_table WHERE username=\"$currentuser\"";
    $result = tng_query($query);
    $row = tng_fetch_assoc($result);
    $preemail = $row['email'];
    tng_free_result($result);
} else {
    $preemail = "";
}

if ($enttype == "I") {
    $typestr = "person";
    $result = getPersonDataPlusDates($tree, $ID);
    if ($result) {
        $row = tng_fetch_assoc($result);
        $rights = determineLivingPrivateRights($row, $righttree);
        $row['allow_living'] = $rights['living'];
        $row['allow_private'] = $rights['private'];
        $name = getName($row) . " ($ID)";
        tng_free_result($result);
    }

    $treeResult = getTreeSimple($tree);
    $treerow = tng_fetch_assoc($treeResult);
    $disallowgedcreate = $treerow['disallowgedcreate'];
    tng_free_result($treeResult);

    $years = getYears($row);
} elseif ($enttype == "F") {
    $typestr = "family";
    $result = getFamilyData($tree, $ID);
    $row = tng_fetch_assoc($result);
    tng_free_result($result);

    $hname = $wname = "";
    $rights = determineLivingPrivateRights($row, $righttree);
    $row['allow_living'] = $rights['living'];
    $row['allow_private'] = $rights['private'];

    if ($row['husband']) {
        $result = getPersonSimple($tree, $row['husband']);
        $prow = tng_fetch_assoc($result);
        tng_free_result($result);
        $prights = determineLivingPrivateRights($prow, $righttree);
        $prow['allow_living'] = $prights['living'];
        $prow['allow_private'] = $prights['private'];
        $hname = getName($prow);
    }
    if ($row['wife']) {
        $result = getPersonSimple($tree, $row['wife']);
        $prow = tng_fetch_assoc($result);
        tng_free_result($result);
        $prights = determineLivingPrivateRights($prow, $righttree);
        $prow['allow_living'] = $prights['living'];
        $prow['allow_private'] = $prights['private'];
        $wname = getName($prow);
    }

    $plus = $hname && $wname ? " + " : "";
    $name = _('Family') . ": $hname$plus$wname ($ID)";

    $years = $years = $row['marrdate'] && $row['allow_living'] && $row['allow_private'] ? _('m.') . " " . displayDate($row['marrdate']) : "";
} elseif ($enttype == "S") {
    $typestr = "source";
    $query = "SELECT title FROM $sources_table WHERE sourceID = '$ID' AND gedcom = '$tree'";
    $result = tng_query($query);
    $row = tng_fetch_assoc($result);
    tng_free_result($result);

    $query = "SELECT count(personID) AS ccount ";
    $query .= "FROM $citations_table citations, $people_table people ";
    $query .= "WHERE citations.sourceID = '$ID' AND citations.persfamID = people.personID AND citations.gedcom = people.gedcom AND living = '1'";
    $sresult = tng_query($query);
    $srow = tng_fetch_assoc($sresult);
    $row['living'] = $srow['ccount'] ? 1 : 0;

    $rights = determineLivingPrivateRights($row, $righttree);
    $row['allow_living'] = $rights['living'];
    $row['allow_private'] = $rights['private'];
    tng_free_result($sresult);

    $name = _('Source') . ": {$row['title']} ($ID)";
    $years = "";
} elseif ($enttype == "R") {
    $typestr = "repo";
    $query = "SELECT reponame FROM $repositories_table WHERE repoID = '$ID' AND gedcom = '$tree'";
    $result = tng_query($query);
    $row = tng_fetch_assoc($result);
    tng_free_result($result);

    $row['living'] = 0;
    $row['allow_living'] = $row['allow_private'] = 1;

    $name = _('Repository') . ": {$row['reponame']} ($ID)";
} elseif ($enttype == "L") {
    $typestr = "place";
    $row['living'] = 0;
    $row['allow_living'] = $row['allow_private'] = 1;
    $name = $ID;
} else {
    $typestr = "";
}
if ($enttype) {
    $headline = _('Suggest a change') . ": $name";
    $comments = _('Description of<br>proposed changes');

    tng_header($headline, $flags);

    $photostr = showSmallPhoto($ID, $name, $row['allow_living'] && $row['allow_private'], 0, false, $row['sex']);
    echo tng_DrawHeading($photostr, $name, $years);

    $innermenu = "&nbsp; \n";
    echo tng_menu($enttype, "suggest", $ID, $innermenu);
    $buttontext = _('Submit Suggestion');
} else {
    $headline = _('Contact Us');
    $comments = _('Comments');

    tng_header($headline, $flags);
    ?>
    <h2 class="header"><span class="headericon" id="contact-hdr-icon"></span><?php echo $headline; ?></h2>
    <br style="clear: left;">
    <?php
    $buttontext = _('Send Message');
}

if ($message) {
    $newmessage = $text[$message];
    if ($message == "mailnotsent") {
        $newmessage = preg_replace("/xxx/", $sowner, $newmessage);
        $newmessage = preg_replace("/yyy/", $ssendemail, $newmessage);
    }
    echo "<p class='normal'><strong style='color: #f00;'>$newmessage</strong></p>\n";
}

if ($enttype) echo "<h3 class='subhead'>$headline</h3>\n";

@include "TNG_captcha.php";

$formstr = getFORM("tngsendmail", "post\" onsubmit=\"return validateForm();", "suggest", "suggest");
echo $formstr;
?>
<?php if ($typestr) { ?>
    <input type="hidden" name="<?php echo $typestr; ?>ID" value="<?php echo $ID; ?>">
<?php } ?>
    <table cellspacing="1" cellpadding="4" class="whiteback normal">
        <tr>
            <td class="fieldnameback" width="20%"><span class="fieldname"><?php echo _('Your Name'); ?>:&nbsp; </span></td>
            <td class="databack" width="80%">
                <input type="text" name="<?php echo $_SESSION['tng_yourname']; ?>" class="longfield">
            </td>
        </tr>
        <tr>
            <td class="fieldnameback"><span class="fieldname"><?php echo _('E-mail'); ?>:&nbsp; </span></td>
            <td class="databack">
                <input type="text" name="<?php echo $_SESSION['tng_email']; ?>" class="longfield" value="<?php echo $preemail; ?>">
            </td>
        </tr>
        <tr>
            <td class="fieldnameback"><span class="fieldname"><?php echo _('Email again'); ?>:&nbsp; </span></td>
            <td class="databack">
                <input type="text" name="em2" class="longfield" value="<?php echo $preemail; ?>">
            </td>
        </tr>
        <?php if ($page) { ?>
            <tr>
                <td class="fieldnameback"><span class="fieldname"><?php echo _('E-mail Subject'); ?>:&nbsp; </span></td>
                <td class="databack"><?php echo stripslashes($page); ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td class="fieldnameback align-top"><span class="fieldname"><?php echo $comments; ?>:&nbsp; </span></td>
            <td class="databack">
                <textarea style="width:95%;" rows="10" name="<?php echo $_SESSION['tng_comments']; ?>"></textarea>
            </td>
        </tr>
    </table>
    <input type="hidden" name="enttype" value="<?php echo $enttype; ?>">
    <input type="hidden" name="ID" value="<?php echo $ID; ?>">
    <input type="hidden" name="tree" value="<?php echo $tree; ?>">
    <input type="hidden" name="page" value="<?php echo $page; ?>">
<?php
if ($tngconfig['askconsent']) {
    ?>
    <br>
    <input type="checkbox" name="tng_user_consent" value="1">
    <?php
    echo _('I give my consent for this site to store the personal information collected here. I understand that I may ask the site owner to remove this information at any time.');
}
if ($tngconfig['dataprotect']) {
    echo "<br><a href='data_protection_policy.php' target='_blank'>" . _('Data Protection Policy') . "</a>\n";
}
?>
    <br><br>
    <input type="submit" class="btn" id="submitbtn" value="<?php echo $buttontext; ?>">
    </form>
    <br>
<?php
tng_footer("");
?>
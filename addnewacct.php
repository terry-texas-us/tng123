<?php
$textpart = "login";
include "tng_begin.php";

$deftext = $text;
include "$mylanguage/text.php";
include "$mylanguage/cust_text.php"; //needed because alltext.php only gets included once

include "tngmaillib.php";

$valid_user_agent = isset($_SERVER["HTTP_USER_AGENT"]) && ($_SERVER["HTTP_USER_AGENT"] != "");

$emailfield = $_SESSION['tng_email'];
if (!$emailfield) {
    header("location:newacctform.php");
    exit;
}
eval("\$email = \$$emailfield;");
$_SESSION['tng_email'] = "";
if (preg_match("/\n[[:space:]]*(to|bcc|cc|boundary)[[:space:]]*[:|=].*@/i", $email) || !$valid_user_agent) {
    die("sorry!");
}
if (preg_match("/\r/i", $email) || preg_match("/\n/i", $email) || !preg_match("/@/i", $email)) {
    die("sorry!");
}
if (preg_match("/\n[[:space:]]*(to|bcc|cc|boundary)[[:space:]]*[:|=].*@/i", $username)) {
    die("sorry!");
}
if (preg_match("/\n/i", $username)) die("sorry!");
$username = filterString($username);
$password = filterString($password);
$realname = filterString($realname);
$phone = filterString($phone);
$email = filterString($email);
$website = filterString($website);
$address = filterString($address);
$city = filterString($city);
$state = filterString($state);
$zip = filterString($zip);
$country = filterString($country);
$notes = filterString($notes);

$realname = strtok($realname, ",;");
if (strpos($email, ",") !== false || strpos($email, ";") !== false || !$email) {
    die("sorry!");
}

if ($addr_exclude) {
    $bad_addrs = explode(",", $addr_exclude);
    foreach ($bad_addrs as $bad_addr) {
        if ($bad_addr) {
            if (strstr($email, trim($bad_addr))) die("sorry");
        }
    }
}

if ($msg_exclude) {
    $bad_msgs = explode(",", $msg_exclude);
    foreach ($bad_msgs as $bad_msg) {
        if ($bad_msg) {
            if (strstr($username, trim($bad_msg)) || strstr($password, trim($bad_msg)) || strstr($realname, trim($bad_msg)) || strstr($notes, trim($bad_msg))) {
                die("sorry");
            }
        }
    }
}

$username = trim($username);
$password = trim($password);
$realname = trim($realname);
$email = trim($email);
$today = date("Y-m-d H:i:s", time() + (3600 * $time_offset));
$dt_consented = $tng_user_consent ? $today : "";

if ($tngconfig['autotree']) {
    $query = "SELECT MAX(0+SUBSTRING(gedcom,5)) AS oldID FROM $trees_table WHERE gedcom LIKE \"tree%\"";
    $result = tng_query($query);
    if (tng_num_rows($result)) {
        $maxrow = tng_fetch_array($result);
        $gedcom = "tree" . ($maxrow['oldID'] + 1);
    } else {
        $gedcom = "tree1";
    }
    tng_free_result($result);

    if ($tngconfig['autoapp']) {
        $template = "ssssssssss";
        $query = "INSERT IGNORE INTO $trees_table (gedcom, treename, description, owner, email, address, city, state, country, zip, phone, secret, disallowgedcreate) ";
        $query .= "VALUES (?, ?, '', ?, ?, ?, ?, ?, ?, ?, ?, '0', '0')";
        $params = [&$template, &$gedcom, &$realname, &$realname, &$email, &$address, &$city, &$state, &$country, &$zip, &$phone];
        tng_execute($query, $params);
    }
} else {
    $gedcom = $assignedtree ? $assignedtree : "";
}

if ($username && $password && $realname && $email && $fingerprint == "realperson") {
    if ($tngconfig['autoapp']) {
        $allow_living_val = 0;
        $moreinfo = $deftext['accactive'];
        $org_password = $password;
        $password = PasswordEncode($password);
    } else {
        $allow_living_val = -1;
        $moreinfo = $deftext['accinactive'];
    }
    $password_type = PasswordType();
    $template = "sssssssssssssssssss";
    $query = "INSERT INTO $users_table (description, username, password, password_type, realname, phone, email, website, address, city, state, zip, country, languageID, notes, gedcom, role, allow_living, dt_registered, dt_consented) ";
    $query .= "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'guest', ?, ?, ?)";
    $params = [&$template, &$realname, &$username, &$password, &$password_type, &$realname, &$phone, &$email, &$website, &$address, &$city, &$state, &$zip, &$country, &$preflang, &$notes, &$gedcom, &$allow_living_val, &$today, &$dt_consented];
    $success = tng_execute_noerror($query, $params);
} else {
    $success = 0;
}

tng_header(_('Register for New User Account'), $flags);

echo "<h2 class='header'>" . _('Register for New User Account') . "</h2>\n";
echo "<span class='normal'>\n";
if ($success > 0) {
    echo "<p>" . _('Success') . "</p>";
    if ($emailaddr) {
        $emailtouse = $tngconfig['fromadmin'] == 1 ? $emailaddr : $email;
        $message = "{$deftext['name']}: $realname\n{$deftext['username']}: $username\n\n{$deftext['emailmsg']} $moreinfo\n\n" . _('Administration') . ": $tngdomain/admin.php";
        $owner = preg_replace("/,/", "", ($sitename ? $sitename : ($dbowner ? $dbowner : "TNG")));
        tng_sendmail($owner, $emailtouse, $dbowner, $emailaddr, $deftext['emailsubject'], $message, $emailaddr, $email);

        $welcome = "";
        if ($tngconfig['autoapp']) {
            // send email to user saying they're ready to go
            // include password if that feature not turned off
            $welcome = _('Hello') . " $realname,\r\n\r\n" . _('Your genealogy user account has been activated.') . "";
            if (!$tngconfig['omitpwd']) {
                $welcome .= "" . _('Password') . ": $org_password\r\n";
            }
            $welcome .= "\r\n$dbowner\r\n$tngdomain";
            $subject = _('Your genealogy user account has been activated.');
        } elseif ($tngconfig['ackemail']) {
            // send email to user saying that we're working on it
            $welcome = _('Hello') . " $realname,\r\n\r\n" . _('Your request for a user account has been received. Your account will be inactive until it has been reviewed by the site administrator. You will be notified by email when your login is ready for use.') . "\r\n$dbowner\r\n$tngdomain";
            $subject = _('Thank you for registering');
        }
        if ($welcome) {
            tng_sendmail($owner, $emailaddr, $realname, $email, $subject, $welcome, $emailaddr, $emailaddr);
        }
    }
} else {
    echo "<p>{_('We\'re sorry, but the username you entered is already in use. Please use the Back button on your browser to return to the previous page and select a different username.')}</p>";
}
echo "</span>";

tng_footer("");

<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
require "adminlog.php";
include "tngmaillib.php";

if ($assignedtree || !$allow_add) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

if ($gedcom_mult) {
    $gedcom2 = implode(',', $gedcom_mult);
    if ($gedcom2) $gedcom = $gedcom2;

}

$orgpwd = $password;
$password = PasswordEncode($password);
$password_type = PasswordType();

if (!$form_allow_add) $form_allow_add = 0;

if (!$form_allow_delete) $form_allow_delete = 0;

if ($form_allow_edit == 2) {
    $form_tentative_edit = 1;
    $form_allow_edit = 0;
} else {
    $form_tentative_edit = 0;
}
if (!$form_allow_ged) $form_allow_ged = 0;

if (!$form_allow_pdf) $form_allow_pdf = 0;

if (!$form_allow_living) $form_allow_living = 0;

if (!$form_allow_private) $form_allow_private = 0;

if (!$form_allow_lds) $form_allow_lds = 0;

if (!$form_allow_profile) $form_allow_profile = 0;

if (!$no_email) $no_email = 0;

if (!$disabled) $disabled = 0;

if (!$preflang) $preflang = 0;


$today = date("Y-m-d H:i:s", time() + (3600 * $time_offset));
$dt_consent = $consented == 1 ? $today : "";

$duplicate = false;

$query = "SELECT username FROM $users_table ";
$query .= "WHERE LOWER(username) = LOWER('$username')";
if ($email) $query .= " OR LOWER(email) = LOWER('$email')";

$result = tng_query($query);

if ($result && tng_num_rows($result)) $duplicate = true;


if (!$duplicate) {
    $template = "ssssssssssssssssssssssssssssssssss";
    $query = "INSERT IGNORE INTO $users_table (description,username,password,password_type,realname,phone,email,website,address,city,state,zip,country,languageID,notes,gedcom,mygedcom,personID,role,allow_edit,allow_add,tentative_edit,allow_delete,allow_lds,allow_living,allow_private,allow_ged,allow_pdf,allow_profile,branch,dt_activated,dt_consented,no_email,disabled)
		VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $params = [&$template, &$description, &$username, &$password, &$password_type, &$realname, &$phone, &$email, &$website, &$address, &$city, &$state, &$zip, &$country, &$preflang, &$notes, &$gedcom, &$mynewgedcom, &$personID, &$role, &$form_allow_edit, &$form_allow_add, &$form_tentative_edit, &$form_allow_delete, &$form_allow_lds, &$form_allow_living, &$form_allow_private, &$form_allow_ged, &$form_allow_pdf, &$form_allow_profile, &$branch, &$today, &$dt_consent, &$no_email, &$disabled];
    tng_execute($query, $params);

    if ($notify && $email) {
        $owner = preg_replace("/,/", "", ($sitename ? $sitename : ($dbowner ? $dbowner : "TNG")));

        tng_sendmail($owner, $emailaddr, $realname, $email, _('Your genealogy user account has been activated.'), $welcome, $emailaddr, $emailaddr);
    }

    if (tng_affected_rows()) {
        $userID = tng_insert_id();
        adminwritelog("<a href=\"admin_edituser.php?userID=$userID\">" . _('Add New User') . ": $username</a>");
        $message = _('User') . " $username " . _('was successfully added') . ".";
        if ($currentuser == "Administrator-No-Users-Yet") {
            $_SESSION['currentuser'] = $username;
            $_SESSION['currentuserdesc'] = $description;
        }
    } else {
        $message = _('ERROR: Your user could not be created because another user with the same username already exists.') . ".";
    }
} else {
    $message = _('Changes were not saved. Another record with the same key already exists.');
}

header("Location: admin_users.php?message=" . urlencode($message));

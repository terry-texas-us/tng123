<?php
global $dbowner, $tngconfig, $text;
$sitecredit = "<p class='smaller text-center'>" . _('This site powered by') . " <a href='https://tngsitebuilding.com' class='footer' target='_blank' title='Learn more about TNG'>The Next Generation of Genealogy Sitebuilding</a>,  " . _('written by') . " Darrin Lythgoe  &copy; 2001-" . date('Y') . ".</p>\n";
if ($dbowner) {
    if (!empty($tngconfig['dataprotect']) && strpos($_SERVER['REQUEST_URI'], "/data_protection_policy.php") === FALSE) {
        $data_protection_link = " | <a href='data_protection_policy.php' class='footer' title='" . _('Data Protection Policy') . "' target='_blank'>" . _('Data Protection Policy') . "</a>.\n";
    } else {
        $data_protection_link = "";
    }
    $sitecredit .= "<p class='smaller text-center'>" . _('Maintained by') . " <a href='suggest.php' class='footer' title='" . _('Contact Us') . "'>$dbowner</a>.{$data_protection_link}</p>\n";
}
if (!empty($tngconfig['footermsg'])) {
    $sitecredit .= "<p class='smaller text-center '>{$tngconfig['footermsg']}</p>\n";
}

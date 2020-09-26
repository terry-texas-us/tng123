<?php
global $dbowner, $tngconfig, $text;
$sitecredit = "<p class='smaller center'>{$text['pwrdby']} <a href='https://tngsitebuilding.com' class='footer' target='_blank' title='Learn more about TNG'>The Next Generation of Genealogy Sitebuilding</a>,  {$text['writby']} Darrin Lythgoe  &copy; 2001-" . date('Y') . ".</p>\n";
if ($dbowner) {
    if (!empty($tngconfig['dataprotect']) && strpos($_SERVER['REQUEST_URI'], "/data_protection_policy.php") === FALSE) {
        $data_protection_link = " | <a href='data_protection_policy.php' class='footer' title='{$text['dataprotect']}' target='_blank'>{$text['dataprotect']}</a>.\n";
    } else {
        $data_protection_link = "";
    }
    $sitecredit .= "<p class='smaller center'>{$text['maintby']} <a href='suggest.php' class='footer' title='{$text['contactus']}'>$dbowner</a>.{$data_protection_link}</p>\n";
}
if (!empty($tngconfig['footermsg'])) {
    $sitecredit .= "<p class='smaller center '>{$tngconfig['footermsg']}</p>\n";
}

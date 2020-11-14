<?php
global $allow_edit, $allow_delete, $allow_add, $assignedtree, $assignedbranch, $allow_media_add, $allow_media_edit, $allow_media_delete;
global $admtext;
$output .= "<!-- begin admin_leftmenu -->\n";
$output .= "<div id='adminslidebar' class='absolute cursor-pointer m-auto' onclick='toggleAdminMenu();'>\n";
$arrow = isset($_SESSION['tng_menuhidden']) && $_SESSION['tng_menuhidden'] == "on" ? "ArrowRight.gif" : "ArrowLeft.gif";
$output .= "<img src='img/{$arrow}' alt='' id='dirarrow' class='float-right mt-40'><br>\n";
$output .= "</div>\n";

if ($allow_edit || $allow_add || $allow_delete) {
    $output .= "<strong><a href='admin.php' class='lightlink2 leftlink'>" . _('Administration') . "</a></strong>\n";
    $output .= "<a href='admin_people.php' class='lightlink2 leftlink'>" . _('People') . "</a>\n";
    $output .= "<a href='admin_families.php' class='lightlink2 leftlink'>" . _('Families') . "</a>\n";
    $output .= "<a href='admin_sources.php' class='lightlink2 leftlink'>" . _('Sources') . "</a>\n";
    $output .= "<a href='admin_repositories.php' class='lightlink2 leftlink'>" . _('Repositories') . "</a>\n";
}
if ($allow_edit || $allow_add || $allow_delete || $allow_media_add || $allow_media_edit || $allow_media_delete) {
    $output .= "<a href='admin_media.php' class='lightlink2 leftlink'>" . _('Media') . "</a>\n";
    $output .= "<a href='admin_albums.php' class='lightlink2 leftlink'>" . _('Albums') . "</a>\n";
}
if ($allow_edit || $allow_add || $allow_delete) {
    $output .= "<a href='admin_cemeteries.php' class='lightlink2 leftlink'>" . _('Cemeteries') . "</a>\n";
    $output .= "<a href='admin_places.php' class='lightlink2 leftlink'>" . _('Places') . "</a>\n";
    $output .= "<a href='admin_timelineevents.php' class='lightlink2 leftlink'>" . _('Timeline Events') . "</a>\n";
}
if ($allow_edit || $allow_delete) {
    $output .= "<a href='admin_notelist.php' class='lightlink2 leftlink'>" . _('Notes') . "</a>\n";
}
if ($allow_edit && $allow_add && $allow_delete && !$assignedtree) {
    $output .= "<a href='admin_misc.php' class='lightlink2 leftlink'>" . _('Miscellaneous') . "</a>\n";
}
$output .= "<hr class='w-4/5 float-left'><br>";
if ($allow_edit && $allow_add && $allow_delete && !$assignedbranch) {
    $output .= "<a href='admin_dataimport.php' class='lightlink2 leftlink'>" . _('Import/Export') . "</a>\n";
}
if ($allow_edit && $allow_add && $allow_delete && !$assignedtree) {
    $output .= "<a href='admin_setup.php' class='lightlink2 leftlink'>" . _('Setup') . "</a>\n";
    $output .= "<a href='admin_users.php' class='lightlink2 leftlink'>" . _('Users') . "</a>\n";
    $output .= "<a href='admin_trees.php' class='lightlink2 leftlink'>" . _('Trees') . "</a>\n";
    if (!$assignedbranch) {
        $output .= "<a href='admin_branches.php' class='lightlink2 leftlink'>" . _('Branches') . "</a>\n";
    }
    $output .= "<a href='admin_eventtypes.php' class='lightlink2 leftlink'>" . _('Custom Event Types') . "</a>\n";
    $output .= "<a href='admin_reports.php' class='lightlink2 leftlink'>" . _('Reports') . "</a>\n";
    $output .= "<a href='admin_dna_tests.php' class='lightlink2 leftlink'>" . _('DNA Tests') . "</a>\n";
    $output .= "<a href='admin_languages.php' class='lightlink2 leftlink'>" . _('Languages') . "</a>\n";
    $output .= "<a href='admin_utilities.php' class='lightlink2 leftlink'>" . _('Utilities') . "</a>\n";
}
$output .= "<br>\n";
$output .= "<!-- end admin_leftmenu -->\n";

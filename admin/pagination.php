<?php

/**
 * @param $total
 * @param $address
 * @param $perpage
 * @param $pagenavpages
 * @return string
 */
function getPaginationControlsHtml($total, $address, $perpage, $pagenavpages = 5) {
    global $tngpage, $totalpages, $orgtree, $test_type, $test_group;
    $first = ucfirst(_('first'));
    $previous = ucfirst(_('previous'));
    $last = ucfirst(_('last'));
    if (!$tngpage) $tngpage = 1;
    if (!$perpage) $perpage = 50;
    if ($total <= $perpage) return "";
    $totalpages = ceil($total / $perpage);
    if ($tngpage > $totalpages) $tngpage = $totalpages;
    $prevlink = '';
    if ($tngpage > 1) {
        $prevpage = $tngpage - 1;
        $navoffset = (($prevpage * $perpage) - $perpage);
        $prevlink = "<a href=\"$address=$navoffset&amp;tree=$orgtree&amp;test_type=$test_type&amp;test_group=$test_group&amp;tngpage=$prevpage\" class='px-3 py-2 rounded hover:bg-gray-500' title='$previous'>$previous</a>\n";
    }
    $nextlink = '';
    if ($tngpage < $totalpages) {
        $nextpage = $tngpage + 1;
        $navoffset = (($nextpage * $perpage) - $perpage);
        $nextlink = "<a href=\"$address=$navoffset&amp;tree=$orgtree&amp;test_type=$test_type&amp;test_group=$test_group&amp;tngpage=$nextpage\" class='px-3 py-2 rounded hover:bg-gray-500' title=\"" . _('Next') . "\">" . _('Next') . "</a>\n";
    }
    $curpage = 0;
    $pagenav = $firstlink = $lastlink = '';
    while ($curpage++ < $totalpages) {
        $navoffset = (($curpage - 1) * $perpage);
        if (($curpage <= $tngpage - $pagenavpages || $curpage >= $tngpage + $pagenavpages) && $pagenavpages) {
            if ($curpage == 1) {
                $firstlink = "<a href=\"$address=$navoffset&amp;tree=$orgtree&amp;test_type=$test_type&amp;test_group=$test_group&amp;tngpage=$curpage\" class='px-3 py-2 rounded hover:bg-gray-500' title='$first'>$first</a>\n";
            }
            if ($curpage == $totalpages) {
                $lastlink = "<a href=\"$address=$navoffset&amp;tree=$orgtree&amp;test_type=$test_type&amp;test_group=$test_group&amp;tngpage=$curpage\" class='px-3 py-2 rounded hover:bg-gray-500' title='$last'>$last</a>\n";
            }
        } else {
            if ($curpage == $tngpage) {
                $pagenav .= "<span class='px-3 py-2 rounded snlinkact bg-gradient-to-b from-gray-500'>$curpage</span>\n";
            } else {
                $pagenav .= "<a href=\"$address=$navoffset&amp;tree=$orgtree&amp;test_type=$test_type&amp;test_group=$test_group&amp;tngpage=$curpage\" class='px-3 py-2 rounded hover:bg-gray-500'>$curpage</a>\n";
            }
        }
    }
    $html = "<div class='mt-4 mx-1 lg:text-right adminnav lg:inline-block'>\n";
    $html .= "<div class='normal'>\n";
    $html .= "$firstlink $prevlink $pagenav $nextlink $lastlink";
    $html .= "</div>\n";
    $html .= "</div>\n";
    return $html;
}
/**
 * @param $start
 * @param $pagetotal
 * @param $grandtotal
 * @return string
 */
function getPaginationLocationHtml($start, $pagetotal, $grandtotal) {
    $html = "<div class='mx-4 inline'>\n";
    $html .= ucfirst(_('showing')) . number_format($start) . " " . _('to') . " <span class='pagetotal'>" . number_format($pagetotal) . "</span> " . _('of') . " <span class='restotal'>" . number_format($grandtotal) . "</span>";
    $html .= "</div>\n";
    return $html;
}
/**
 * @param $address
 * @param $perpage
 * @return string
 */
function getToPageHtml($address, $perpage) {
    global $orgtree;
    $html = " <div class='rounded mx-4 inline'>";
    $html .= "<span class='pr-2'>" . ucfirst(_todo_("go to page")) . "</span>";
    $html .= "<input type='text' class='w-20 px-3 border-none tngpage' placeholder=\"" . _('Page') . " #\" name='tngpage' onkeyup=\"if(pageEnter(this, event)) {goToPage($(this).next(), '$address', '$orgtree', $perpage);}\"> ";
    $html .= "<input type='button' value=\"" . _('Go') . "\" class='px-3 bg-transparent border-none hover:bg-gray-500' onclick=\"goToPage(this, '$address', '$orgtree', $perpage);\">";
    $html .= "</div>";
    return $html;
}

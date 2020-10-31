<?php

/**
 * @param $total
 * @param $address
 * @param $perpage
 * @param $pagenavpages
 * @return string
 */
function getPaginationControlsHtml($total, $address, $perpage, $pagenavpages) {
    global $tngpage, $totalpages, $text, $orgtree, $test_type, $test_group;
    $first = ucfirst($text['first']);
    $previous = ucfirst($text['previous']);
    $last = ucfirst($text['last']);
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
        $nextlink = "<a href=\"$address=$navoffset&amp;tree=$orgtree&amp;test_type=$test_type&amp;test_group=$test_group&amp;tngpage=$nextpage\" class='px-3 py-2 rounded hover:bg-gray-500' title=\"{$text['text_next']}\">{$text['text_next']}</a>\n";
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
    $html = "<div class='mt-4 text-center lg:text-right lg:w-3/5 adminnav lg:inline-block'>\n";
    $html .= "<div class='normal'>\n";
    $html .= "$firstlink $prevlink $pagenav $nextlink $lastlink";
    //    if ($firstlink || $lastlink) $html .= getToPageHtml($address, $perpage);
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
    global $text;
    $showing = ucfirst($text['showing']);
    $html = "<div class='text-center lg:inline lg:w-2/5'>\n";
    $html .= "$showing " . number_format($start) . " {$text['to']} <span class='pagetotal'>" . number_format($pagetotal) . "</span> {$text['of']} <span class='restotal'>" . number_format($grandtotal) . "</span>";
    $html .= "</div>\n";
    return $html;
}
/**
 * @param $address
 * @param $perpage
 * @return string
 */
function getToPageHtml($address, $perpage) {
    global $text, $orgtree;
    $html = " <div class='inline rounded snlink'>";
    $html .= "<input type='text' class='w-16 text-sm border-none tngpage minifield' placeholder=\"{$text['page']} #\" name='tngpage' onkeyup=\"if(pageEnter(this,event)) {goToPage($(this).next(), '$address', '$orgtree', $perpage);}\"> ";
    $html .= "<input type='button' value=\"{$text['go']}\" class='minibutton' onclick=\"goToPage(this, '$address', '$orgtree', $perpage);\">";
    $html .= "</div>";
    return $html;
}

function togglednaicon() {
    const $toggleSelection = $('.toggleicon2');
    if ($toggleSelection.attr('src').indexOf('desc') > 0) {
        $toggleSelection.attr('src', 'img/tng_sort_asc.gif')
        $toggleSelection.attr('title', collapse);
        $('.dnatest').show();
    } else {
        $toggleSelection.attr('src', 'img/tng_sort_desc.gif')
        $toggleSelection.attr('title', expand);
        $('.dnatest').hide();
    }
}

function show_dnatest() {
    const $toggleSelection = $('.toggleicon2');
    $toggleSelection.attr('src', 'img/tng_sort_asc.gif')
    $toggleSelection.attr('title', collapse);
    $('.dnatest').show();
}

function hide_dnatest() {
    const $toggleSelection = $('.toggleicon2');
    $toggleSelection.attr('src', 'img/tng_sort_desc.gif')
    $toggleSelection.attr('title', expand);
    $('.dnatest').hide();
}

function innerToggle(part, subpart, subpartlink) {
    if (part === subpart)
        turnOn(subpart, subpartlink);
    else
        turnOff(subpart, subpartlink);
}

function turnOn(subpart, subpartlink) {
    jQuery('#' + subpartlink).attr('class', 'lightlink3');
    jQuery('#' + subpart).show();
}

function turnOff(subpart, subpartlink) {
    jQuery('#' + subpartlink).attr('class', 'lightlink');
    jQuery('#' + subpart).hide();
}

function highlightChild(flag, child) {
    jQuery('#child' + child).attr('class', flag ? 'highlightedchild' : 'unhighlightedchild');
}
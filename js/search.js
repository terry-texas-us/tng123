let searchtimer;
jQuery(document).ready(function () {
    jQuery('a.pers').each(function (index, item) {
        let matches = /p(\w*)_t([\w-]*):*(\w*)/.exec(item.id);
        let personID = matches[1];
        let tree = matches[2];
        let event = matches[3];
        item.onmouseover = function () {
            searchtimer = setTimeout('showPersonPreview(\'' + personID + '\',\'' + tree + '\',\'' + event + '\')', 1000);
        };
        item.onmouseout = function () {
            closePersonPreview(personID, tree, event);
        };
        item.onclick = function () {
            closePersonPreview(personID, tree, event);
        };
    });
    jQuery('a.fam').each(function (index, item) {
        let matches = /f(\w*)_t([\w-]*)/.exec(item.id);
        let familyID = matches[1];
        let tree = matches[2];
        item.onmouseover = function () {
            searchtimer = setTimeout('showFamilyPreview(\'' + familyID + '\',\'' + tree + '\')', 1000);
        };
        item.onmouseout = function () {
            closeFamilyPreview(familyID, tree);
        };
        item.onclick = function () {
            closeFamilyPreview(familyID, tree);
        };
    });
});

function showPersonPreview(personID, tree, event) {
    let entitystr = tree + '_' + personID;
    if (event)
        entitystr += "_" + event;
    let $personSelection = jQuery('#prev' + entitystr);
    $personSelection.css('visibility', 'visible');
    if (!$personSelection.html()) {
        $personSelection.html('<div id="ld' + entitystr + '" class="person-inner"><img src="' + 'img/spinner.gif" style="border:0;" alt="" > ' + loadingmsg + '</div>');

        const params = {personID: personID, tree: tree};
        jQuery.ajax({
            url: 'ajx_perspreview.php',
            data: params,
            dataType: 'html',
            success: function (req) {
                jQuery('#ld' + entitystr).html(req);
            }
        });
    }
    return false;
}

function closePersonPreview(personID, tree, event) {
    clearTimeout(searchtimer);
    let entitystr = tree + '_' + personID;
    if (event)
        entitystr += "_" + event;
    //new Effect.Fade('prev'+entitystr,{duration:.01});
    jQuery('#prev' + entitystr).css('visibility', 'hidden');
}

function showFamilyPreview(familyID, tree) {
    let entitystr = tree + "_" + familyID;
    let $familySelection = jQuery('#prev' + entitystr);
    $familySelection.css('visibility', 'visible');
    if (!$familySelection.html()) {
        $familySelection.html('<div id="ld' + entitystr + '" class="person-inner"><img src="' + 'img/spinner.gif" alt=""> ' + loadingmsg + '</div>');
        const params = {familyID: familyID, tree: tree};
        jQuery.ajax({
            url: 'ajx_fampreview.php',
            data: params,
            dataType: 'html',
            success: function (req) {
                jQuery('#ld' + entitystr).html(req);
            }
        });
    }
    return false;
}

function closeFamilyPreview(familyID, tree) {
    clearTimeout(searchtimer);
    let entitystr = tree + '_' + familyID;
    jQuery('#prev' + entitystr).css('visibility', 'hidden');
}

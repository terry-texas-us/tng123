String.prototype.trim = function () {
    return this.replace(/^\s*/, "").replace(/\s*$/, "");
}

function deleteIt(type, id, tree, confirm) {
    var tds = jQuery('#row_' + id + ' td');
    jQuery.each(tds, function (index, item) {
        jQuery(item).effect('highlight', {color: '#ff9999'}, 1500);
    });
    var params = {t: type, id: id, desc: tree, confirm: confirm};
    jQuery.ajax({
        url: cmstngpath + 'ajx_delete.php',
        data: params,
        dataType: 'html',
        success: function (entity) {
            if (jQuery('#row_' + entity).length) {
                jQuery('#row_' + entity).fadeOut(400);
                var allTotals = jQuery('.restotal');
                jQuery.each(allTotals, function (index, item) {
                    var total = jQuery(item);
                    total.html(numberWithCommas(parseInt(total.html().replace(/,/g, '')) - 1));
                });
                var allPageTotals = jQuery('.pagetotal');
                jQuery.each(allPageTotals, function (index, item) {
                    var pagetotal = jQuery(item);
                    pagetotal.html(numberWithCommas(parseInt(pagetotal.html().replace(/,/g, '')) - 1));
                });
            }
        }
    });
    return false;
}

function numberWithCommas(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}

function toggleSection(section, img, display) {
    if (display == 'on') {
        jQuery('#' + img).attr('src', 'img/tng_collapse.gif');
        var doit = true;
        if (section == "modifyexisting") {
            var agent = navigator.userAgent.toLowerCase();
            if (agent.indexOf('safari') != -1) doit = false;
        }
        if (doit)
            jQuery('#' + section).fadeIn(300);
        else
            jQuery('#' + section).show();
    } else if (display == 'off') {
        jQuery('#' + img).attr('src', 'img/tng_expand.gif');
        jQuery('#' + section).fadeOut(300);
    } else {
        jQuery('#' + img).attr('src', jQuery('#' + img).attr('src').indexOf('collapse') > 0 ? 'img/tng_expand.gif' : 'img/tng_collapse.gif');
        var doit = true;
        if (section == "addmedia") {
            var agent = navigator.userAgent.toLowerCase();
            if (agent.indexOf('safari') != -1 && agent.indexOf('version/3') == -1) doit = false;
        }
        if (doit)
            jQuery('#' + section).toggle(300);
        else
            jQuery('#' + section.css('display', jQuery('#' + section).css('display') == 'none' ? '' : 'none'));
    }
    return false;
}

function makeFolder(folder, name) {
    jQuery('#msg_' + folder).html('<img src="img/spinner.gif" />');
    var params = {folder: name};
    jQuery.ajax({
        url: cmstngpath + 'admin_makefolder.php',
        data: params,
        dataType: 'html',
        success: function (req) {
            jQuery('#msg_' + folder).html(req);
            jQuery('#msg_' + folder).effect('highlight', {}, 200);
        }
    });

    return false;
}

function makeDefault(photo) {
    var params = {media: photo.value.substr(1), entity: entity, tree: tree, album: album, action: 'setdef'};
    jQuery.ajax({
        url: cmstngpath + 'ajx_updateorder.php',
        data: params,
        dataType: 'html',
        success: function (req) {
            jQuery('#removedefault').show();
            if (req != "1") {
                jQuery('#thumbholder').html(req);
                jQuery('#thumbholder').fadeIn(400);
                jQuery('#removedefault').css('visibility', 'visible');
            }
        }
    });
}

function removeDefault() {
    jQuery('#removedefault').hide();
    jQuery('#thumbholder').fadeOut(400, function () {
        jQuery('#thumbholder').html('');
    });
    for (var i = 0; i < document.form1.rthumbs.length; i++) {
        if (document.form1.rthumbs[i].checked)
            document.form1.rthumbs[i].checked = '';
    }
    var params = {entity: entity, tree: tree, album: album, action: 'deldef'};
    jQuery.ajax({
        url: cmstngpath + 'ajx_updateorder.php',
        data: params
    });
    return false;
}

function updateLivingBox(form, field) {
    if (field.value)
        form.living.checked = false;
}

function deepOpen(url, winName) {
    window.open('deepindex.php?page=' + encodeURIComponent(url, winName));
    return false;
}
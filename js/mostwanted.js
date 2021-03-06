function startMostWanted() {
    jQuery('#orderpersondivs').sortable({dropOnEmpty: true, tag: 'div', connectWith: '#orderphotodivs', update: updatePersonOrder});
    jQuery('#orderphotodivs').sortable({dropOnEmpty: true, tag: 'div', connectWith: '#orderpersondivs', update: updatePhotoOrder});
}

function updatePersonOrder(event, ui) {
    updateMostWantedOrder('person');
}

function updatePhotoOrder(event, ui) {
    updateMostWantedOrder('photo');
}

function updateMostWantedOrder(mwtype) {
    let linklist;
    if (mwtype === "person")
        linklist = removePrefixFromArray(jQuery('#orderpersondivs').sortable('toArray'), 'orderpersondivs_');
    else
        linklist = removePrefixFromArray(jQuery('#orderphotodivs').sortable('toArray'), 'orderphotodivs_');

    let params = {sequence: linklist.join(','), mwtype: mwtype, action: 'mworder'};
    jQuery.ajax({
        url: 'ajx_updateorder.php',
        data: params,
        dataType: 'html'
    });
}

function openMostWanted(mwtype, ID) {
    mwlitbox = new LITBox('admin_editmostwanted.php?mwtype=' + mwtype + '&ID=' + ID, {width: 660, height: 490});
    return false;
}

function openMostWantedMediaFind(tree) {
    tnglitbox = new LITBox('admin_findmwmedia.php?tree=' + tree, {width: 660, height: 560});
    return false;
}

function updateMostWanted(form) {
    if (form.title.value.length === 0)
        alert(entertitle);
    else if (form.description.value.length === 0)
        alert(enterdesc);
    else {
        var params = jQuery(form).serialize();
        jQuery.ajax({
            url: 'admin_updatemostwanted.php',
            data: params,
            type: 'post',
            dataType: 'json',
            success: function (vars) {
                if (form.ID.value) {
                    //if its old, just update existing row and highlight
                    jQuery('#title_' + vars.ID).html(vars.title);
                    jQuery('#desc_' + vars.ID).html(vars.description);
                    //update thumbnail if necessary
                    if (vars.thumbpath) {
                        let $imageSelection = jQuery('#img_' + vars.ID);
                        $imageSelection.attr('src', vars.thumbpath);
                        $imageSelection.css('width', vars.width + 'px');
                        $imageSelection.css('height', vars.height + 'px');
                    }
                } else {
                    //if it's new, then insert row at bottom
                    var newcontent = '<div class="sortrow" id="order' + vars.mwtype + 'divs_' + vars.ID + '" style="clear:both;" onmouseover="showEditDelete(\'' + vars.ID + '\');" onmouseout="hideEditDelete(\'' + vars.ID + '\');">\n';
                    newcontent += '<table>\n';
                    newcontent += '<tr id="row_' + vars.ID + '">\n';
                    newcontent += '<td class="dragarea rounded-lg normal" style="width: 4em;">\n';
                    newcontent += '<img src="img/admArrowUp.gif" alt="" class="inline-block">' + drag + '<img src="img/admArrowDown.gif" alt="" class="inline-block">\n';
                    newcontent += '</td>\n';
                    newcontent += '<td class="lightback" style="width:' + thumbwidth + 'px;">\n';
                    if (vars.thumbpath)
                        newcontent += '<img class="thumb-center" src="' + vars.thumbpath + '" width="' + vars.width + '" height="' + vars.height + '" id="img_' + vars.ID + '" alt="' + vars.description + '">\n';
                    else
                        newcontent += "&nbsp;";

                    newcontent += '</td>\n';
                    newcontent += '<td class="lightback normal">\n';
                    if (vars.edit)
                        newcontent += '<a href="#" onclick="return openMostWanted(\'' + vars.mwtype + '\',\'' + vars.ID + '\');" id="title_' + vars.ID + '">' + vars.title + '</a>\n';
                    else
                        newcontent += '<u id="title_' + vars.ID + '">' + vars.title + '</u>\n';
                    newcontent += '<br><span id="desc_' + vars.ID + '">' + vars.description + '</span><br>\n';
                    newcontent += '<div id="del_' + vars.ID + '" class="smaller" style="color: #808080; visibility: hidden;">\n';
                    if (vars.edit) {
                        newcontent += '<a href="#" onclick="return openMostWanted(\'' + vars.mwtype + '\',\'' + vars.ID + '\');">' + edittext + '</a>\n';
                        if (vars.del)
                            newcontent += ' | ';
                    }
                    if (vars.del)
                        newcontent += '<a href="#" onclick="return removeFromMostWanted(\'' + vars.mwtype + '\',\'' + vars.ID + '\');">' + deletetext + '</a>\n';
                    newcontent += '</div>\n';
                    newcontent += '</td>\n';
                    newcontent += '</tr>\n';
                    newcontent += '</table>\n';
                    newcontent += '</div>\n';
                    let $orderSelection = jQuery('#order' + vars.mwtype + 'divs');
                    $orderSelection.html(newcontent + $orderSelection.html());
                    if (vars.mwtype === 'person')
                        jQuery('#orderpersondivs').sortable({dropOnEmpty: true, tag: 'div', connectWith: '#orderphotodivs', update: updatePersonOrder});
                    else
                        jQuery('#orderphotodivs').sortable({dropOnEmpty: true, tag: 'div', connectWith: '#orderpersondivs', update: updatePhotoOrder});
                }

                var tds = jQuery('tr#row_' + vars.ID + ' td');
                mwlitbox.remove();
                jQuery.each(tds, function (index, item) {
                    jQuery(item).effect('highlight', {}, 2000);
                });
            }
        });
    }
    return false;
}

function removeFromMostWanted(type, id) {
    if (confirm(confremmw)) {
        var params = {id: id, action: 'remmostwanted'};
        jQuery.ajax({
            url: 'ajx_updateorder.php',
            data: params,
            dataType: 'html',
            success: function () {
                jQuery('#order' + type + 'divs_' + id).fadeOut(400, function () {
                    jQuery('#order' + type + 'divs_' + id).remove();
                    if (type === 'person')
                        jQuery('#orderpersondivs').sortable({dropOnEmpty: true, tag: 'div', connectWith: '#orderphotodivs', update: updatePersonOrder});
                    else
                        jQuery('#orderphotodivs').sortable({dropOnEmpty: true, tag: 'div', connectWith: '#orderpersondivs', update: updatePhotoOrder});
                });
            }
        });
    }
    return false;
}

function showEditDelete(id) {
    let $deleteSelection = jQuery('#del_' + id);
    if ($deleteSelection.length)
        $deleteSelection.css('visibility', 'visible');
}

function hideEditDelete(id) {
    let $deleteSelection = jQuery('#del_' + id);
    if ($deleteSelection.length)
        $deleteSelection.css('visibility', 'hidden');
}

function getNewMwMedia(form) {
    var searchstring = form.searchstring.value;

    doSpinner(1);
    jQuery('#newmedia').html('');
    var searchtree = form.tree.value;
    var mediatypeID = form.mediatypeID.value;

    var strParams = {searchstring: searchstring, searchtree: searchtree, mediatypeID: mediatypeID};
    jQuery.ajax({
        url: 'admin_add2albumxml.php',
        data: strParams,
        dataType: 'html',
        success: showMedia
    });
}

function getMoreMedia(searchstring, mediatypeID, hsstat, cemeteryID, offset, tree, page, albumID) {
    var params = {
        searchstring: searchstring,
        mediatypeID: mediatypeID,
        hsstat: hsstat,
        cemeteryID: cemeteryID,
        offset: offset,
        tree: tree,
        page: page,
        albumID: albumID
    };
    jQuery.ajax({
        url: 'admin_add2albumxml.php',
        data: params,
        dataType: 'html',
        success: showMedia
    });
    return false;
}

function showMedia(req) {
    jQuery('#newmedia').html(req);
    jQuery('#spinner1').hide();
}

function doSpinner(id) {
    lastspinner = jQuery('#spinner' + id);
    lastspinner.show();
}

function selectMedia(mediaID) {
    document.editmostwanted.mediaID.value = mediaID;
    jQuery('#mwthumb').html("&nbsp;");
    jQuery('#mwdetails').html(loading);

    jQuery.ajax({
        url: 'admin_getphotodetails.php',
        data: {mediaID: mediaID},
        dataType: 'html',
        success: function (req) {
            jQuery('#mwphoto').html(req);
        }
    });

    tnglitbox.remove();
    return false;
}
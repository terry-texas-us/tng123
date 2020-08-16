function AddtoDisplay(source, dest) {
    if (source.options[source.selectedIndex].selected) {
        if (navigator.appName == "Netscape") {
            dest.options[dest.options.length] = new Option(source.options[source.selectedIndex].text, source.options[source.selectedIndex].value, false, false)
        } else if (navigator.appName == "Microsoft Internet Explorer") {
            var newElem = document.createElement("OPTION");
            newElem.text = source.options[source.selectedIndex].text;
            newElem.value = source.options[source.selectedIndex].value;
            dest.options.add(newElem);
        }
    }
}

function RemovefromDisplay(fieldlist) {
    if (fieldlist.options[fieldlist.selectedIndex].selected) {
        if (navigator.appName == "Netscape") {
            fieldlist.options[fieldlist.selectedIndex] = null;
        } else if (navigator.appName == "Microsoft Internet Explorer") {
            fieldlist.options.remove(fieldlist.selectedIndex);
        }
    }
}

function Move(fieldlist, dir) {
    var tempval = fieldlist.options[fieldlist.selectedIndex].value;
    var temptxt = fieldlist.options[fieldlist.selectedIndex].text;

    if (dir) {
        fieldlist.options[fieldlist.selectedIndex].value = fieldlist.options[fieldlist.selectedIndex - 1].value;
        fieldlist.options[fieldlist.selectedIndex - 1].value = tempval;
        fieldlist.options[fieldlist.selectedIndex].text = fieldlist.options[fieldlist.selectedIndex - 1].text;
        fieldlist.options[fieldlist.selectedIndex - 1].text = temptxt;
        fieldlist.selectedIndex--;
    } else {
        fieldlist.options[fieldlist.selectedIndex].value = fieldlist.options[fieldlist.selectedIndex + 1].value;
        fieldlist.options[fieldlist.selectedIndex + 1].value = tempval;
        fieldlist.options[fieldlist.selectedIndex].text = fieldlist.options[fieldlist.selectedIndex + 1].text;
        fieldlist.options[fieldlist.selectedIndex + 1].text = temptxt;
        fieldlist.selectedIndex++;
    }
}

function TrimString(sInString) {
    sInString = sInString.replace(/^\s+/g, "");// strip leading
    return sInString.replace(/\s+$/g, "");// strip trailing
}

function getTree(treefield) {
    if (treefield) {
        if (treefield.options.length)
            return treefield.options[treefield.selectedIndex].value;
        else {
            alert(selecttree);
            return false;
        }
    } else
        return tree;  //global tree
}

function generateID(type, dest, treefield) {
    var tree = getTree(treefield);
    if (tree !== false) {
        var params = {type: type, tree: tree};
        jQuery.ajax({
            url: cmstngpath + 'admin_generateID.php',
            data: params,
            dataType: 'html',
            success: function (req) {
                jQuery(dest).val(req);
            }
        });
    }
}

function checkID(checkID, type, dest, treefield) {
    var tree = getTree(treefield);
    if (tree !== false) {
        var params = {checkID: checkID, type: type, tree: tree};
        jQuery.ajax({
            url: cmstngpath + 'admin_checkID.php',
            data: params,
            dataType: 'html',
            success: function (req) {
                jQuery('#' + dest).html(req);
            }
        });
    }
}

function openChangeTree(entity, tree, id) {
    tnglitbox = new LITBox('admin_changetreeform.php?entity=' + entity + '&oldtree=' + tree + '&entityID=' + id, {width: 420, height: 250});
    return false;
}

function onChangeTree(form) {
    if (form.newtree.selectedIndex < 1)
        return false;
    else
        return true;
}

function insertCell(row, index, classname, content) {
    var cell = row.insertCell(index);
    cell.className = classname;
    cell.innerHTML = content ? content : content + '&nbsp;';
    return cell;
}

function getActionButtons(vars, type, notesflag, citesflag) {
    var celltext = "";
    var dims = "width=\"20\" height=\"20\" class=\"smallicon\"";
    var onstr = type == "Citation" ? "-on" : "-off";

    if (vars.allow_edit)
        celltext += "<a href=\"#\" onclick=\"return edit" + type + "('" + vars.id + "');\" title=\"" + editmsg + "\" class=\"smallicon admin-edit-icon\"></a>";
    if (vars.allow_delete)
        celltext += "<a href=\"#\" onclick=\"return delete" + type + "('" + vars.id + "','" + vars.persfamID + "','" + vars.tree + "','" + vars.eventID + "');\" title=\"" + delmsg + "\" class=\"smallicon admin-delete-icon\"></a>";
    if (vars.allow_cite)
        celltext += "<a href=\"#\" onclick=\"return showCitationsInside('N" + vars.id + "','','" + vars.persfamID + "');\" title=\"" + citemsg + "\" id=\"citesiconN" + vars.id + "\" class=\"smallicon admin-cite" + onstr + "-icon\"></a>";
    if (notesflag)
        celltext += "<a href=\"#\" onclick=\"return showNotes('" + vars.id + "','" + vars.persfamID + "');\" title=\"" + notemsg + "\" id=\"notesicon" + vars.id + "\" class=\"smallicon admin-note-off-icon\"></a>";
    if (citesflag)
        celltext += "<a href=\"#\" onclick=\"return showCitations('" + vars.id + "','" + vars.persfamID + "');\" title=\"" + citemsg + "\" id=\"citesicon" + vars.id + "\" class=\"smallicon admin-cite-off-icon\"></a>";

    return celltext;
}

function addEvent(form) {
    if (form.eventtypeID.selectedIndex == 0)
        alert(entereventtype);
    else if (form.eventdate.value.length == 0 && form.eventplace.value.length == 0 && form.info.value.length == 0)
        alert(entereventinfo);
    else {
        var params = jQuery(form).serialize();
        jQuery.ajax({
            url: cmstngpath + 'admin_addevent.php',
            data: params,
            type: 'POST',
            dataType: 'json',
            success: function (vars) {
                var eventtbl = document.getElementById('custeventstbl');
                var newtr = eventtbl.insertRow(eventtbl.rows.length);
                newtr.id = "row_" + vars.id;
                var buttons = getActionButtons(vars, 'Event', allow_notes, allow_cites);
                insertCell(newtr, 0, "lightback nw", buttons);
                insertCell(newtr, 1, "lightback", vars.display);
                insertCell(newtr, 2, "lightback", vars.eventdate + "&nbsp;");
                insertCell(newtr, 3, "lightback", vars.eventplace + "&nbsp;");
                insertCell(newtr, 4, "lightback", vars.info + "&nbsp;");

                eventtbl.style.display = '';
                tnglitbox.remove();
            }
        });
    }
    return false;
}

function updateEvent(form) {
    var eventID = form.eventID.value;
    var params = jQuery(form).serialize();
    jQuery.ajax({
        url: cmstngpath + 'admin_updateevent.php',
        data: params,
        type: 'POST',
        dataType: 'json',
        success: function (vars) {
            var tds = jQuery('tr#row_' + eventID + ' td');
            tds.eq(1).html(vars.display + "&nbsp;");
            tds.eq(2).html(vars.eventdate + "&nbsp;");
            tds.eq(3).html(vars.eventplace + "&nbsp;");
            tds.eq(4).html(vars.info + "&nbsp;");
            tnglitbox.remove();
            jQuery.each(tds, function (index, item) {
                jQuery(item).effect('highlight', {}, 200);
            });
        }
    });
    return false;
}

function editEvent(eventID) {
    tnglitbox = new LITBox(cmstngpath + 'admin_editevent.php?eventID=' + eventID, {
        width: 540, height: 500, doneLoading: function () {
            $('#eventdate').focus();
        }
    });

    return false;
}

function newEvent(prefix, persfamID, tree) {
    tnglitbox = new LITBox(cmstngpath + 'admin_newevent.php?prefix=' + prefix + '&persfamID=' + persfamID + '&tree=' + tree, {
        width: 540, height: 500, doneLoading: function () {
            $('#eventtypeID').focus();
        }
    });

    return false;
}

function deleteEvent(eventID) {
    if (confirm(confdeleteevent)) {
        var tds = jQuery('tr#row_' + eventID + ' td');
        jQuery.each(tds, function (index, item) {
            jQuery(item).effect('highlight', {color: '#ff9999'}, 200);
        });
        var params = {eventID: eventID};
        jQuery.ajax({
            url: cmstngpath + 'admin_deleteevent.php',
            data: params,
            dataType: 'html',
            success: function (req) {
                jQuery('#row_' + eventID).fadeOut(200);
            }
        });
    }
    return false;
}

function showNotes(eventID, persfamID) {
    tnglitbox = new LITBox(cmstngpath + 'admin_notes.php?eventID=' + eventID + '&persfamID=' + persfamID + '&tree=' + tree, {width: 645, height: 540, doneLoading: initNoteSort});
    return false;
}

function showCitations(eventID, persfamID) {
    tnglitbox = new LITBox(cmstngpath + 'admin_citations.php?eventID=' + eventID + '&persfamID=' + persfamID + '&tree=' + tree, {width: 645, height: 540, doneLoading: initCitationSort});
    return false;
}

function showMore(eventID, persfamID) {
    tnglitbox = new LITBox(cmstngpath + 'admin_editmore.php?eventID=' + eventID + '&persfamID=' + persfamID + '&tree=' + tree, {width: 600, height: 480});
    return false;
}

function showAssociations(persfamID, orgreltype) {
    //assocType = "I";
    tnglitbox = new LITBox('admin_associations.php?orgreltype=' + orgreltype + '&personID=' + persfamID + '&tree=' + tree, {width: 645, height: 440});
    return false;
}

var prevsection = null;

function gotoSection(start, end) {
    prevsection = start;
    if (start && end)
        jQuery('#' + start).fadeOut(200, function () {
            jQuery('#' + end).fadeIn(200, function () {
                if (jQuery('#mytitle').length)
                    jQuery('#mytitle').focus();
            });
        });
    else {
        jQuery('#mlbox').remove();
        start.remove();
    }
    return false;
}

function addNote(form) {
    if (form.note.value.length == 0)
        alert(enternote);
    else {
        var params = jQuery(form).serialize();
        jQuery.ajax({
            url: cmstngpath + 'admin_addnote.php',
            data: params,
            type: 'POST',
            dataType: 'json',
            success: function (vars) {
                vars.allow_cite = 1;

                var div = jQuery('<div id="notes_' + vars.id + '" class="sortrow"></div>');

                var newnotetbl = document.createElement("table");
                newnotetbl.className = "normal";
                newnotetbl.cellPadding = 3;
                newnotetbl.cellSpacing = 1;
                newnotetbl.border = 0;
                var newtr = newnotetbl.insertRow(0);
                newtr.id = "row_" + vars.id;
                insertCell(newtr, 0, "dragarea", '<img src="img/admArrowUp.gif" alt=""><br/><img src="img/admArrowDown.gif" alt="">');
                var cell1 = insertCell(newtr, 1, "lightback", getActionButtons(vars, 'Note'));
                cell1.width = "80";
                var cell2 = insertCell(newtr, 2, "lightback", vars.display)
                cell2.width = "435";
                div.append(newnotetbl);
                jQuery('#notes').append(div);
                initNoteSort();

                jQuery('#notestbl').show();
                gotoSection('addnote', 'notelist');
                jQuery('#notesicon' + form.eventID.value).removeClass('admin-note-off-icon');
                jQuery('#notesicon' + form.eventID.value).addClass('admin-note-on-icon');
            }
        });
    }
    return false;
}

function editNote(noteID) {
    var params = {noteID: noteID};
    jQuery.ajax({
        url: cmstngpath + 'admin_editnote.php',
        data: params,
        dataType: 'html',
        success: function (req) {
            jQuery('#editnote').html(req);
            gotoSection('notelist', 'editnote');
        }
    });
    return false;
}

function updateNote(form) {
    if (form.note.value.length == 0)
        alert(enternote);
    else {
        var noteID = form.ID.value;
        var params = jQuery(form).serialize();
        jQuery.ajax({
            url: cmstngpath + 'admin_updatenote.php',
            data: params,
            type: 'POST',
            dataType: 'json',
            success: function (vars) {
                var tds = jQuery('tr#row_' + noteID + ' td');
                tds.eq(2).html(vars.display);
                gotoSection('editnote', 'notelist');
                tds.each(function (index, item) {
                    jQuery(item).effect('highlight', {}, 2500);
                })
            }
        });
    }
    return false;
}

function deleteNote(noteID, personID, tree, eventID) {
    if (confirm(confdeletenote)) {
        var tds = jQuery('tr#row_' + noteID + ' td');
        tds.each(function (index, item) {
            jQuery(item).effect('highlight', {color: '#ff9999'}, 100);
        })
        var params = {noteID: noteID, personID: personID, tree: tree, eventID: eventID};
        jQuery.ajax({
            url: cmstngpath + 'admin_deletenote.php',
            data: params,
            dataType: 'html',
            success: function (req) {
                jQuery('#row_' + noteID).fadeOut(200);
                if (req == '0') {
                    jQuery('#notesicon' + eventID).addClass('admin-note-off-icon');
                    jQuery('#notesicon' + eventID).removeClass('admin-note-on-icon');
                }
            }
        });
    }
    return false;
}

function initNoteSort() {
    jQuery('#notes').sortable({tag: 'div', update: updateNoteOrder});
}

function initCitationSort() {
    jQuery('#cites').sortable({tag: 'div', update: updateCitationOrder});
}

function updateNoteOrder(event, ui) {
    var notelist = removePrefixFromArray(jQuery('#notes').sortable('toArray'), 'notes_');

    var params = {sequence: notelist.join(','), action: 'noteorder'};
    jQuery.ajax({
        url: cmstngpath + 'ajx_updateorder.php',
        data: params,
        dataType: 'html'
    });
}

function updateCitationOrder(event, ui) {
    var citelist = removePrefixFromArray(jQuery('#cites').sortable('toArray'), 'citations_');

    var params = {sequence: citelist.join(','), action: 'citeorder'};
    jQuery.ajax({
        url: cmstngpath + 'ajx_updateorder.php',
        data: params,
        dataType: 'html'
    });
}

function removePrefixFromArray(arr, prefix) {
    for (var i = 0; i < arr.length; i++) {
        if (arr[i].indexOf(prefix) == 0)
            arr[i] = arr[i].substring(prefix.length)
    }
    return arr;
}

var subpage = false;

function showCitationsInside(eventID, noteID, persfamID) {
    subpage = true;
    var xnote = noteID != "" ? noteID : "";
    var params = {eventID: eventID, persfamID: persfamID, noteID: xnote, tree: tree};
    jQuery.ajax({
        url: cmstngpath + 'admin_citations.php',
        data: params,
        dataType: 'html',
        success: function (req) {
            jQuery('#citationslist').html(req);
            gotoSection('notelist', 'citationslist');
            initCitationSort();
        }
    });
    return false;
}

function addCitation(form) {
    if (form.sourceID.value == "")
        alert(selectsource);
    else {
        var params = jQuery(form).serialize();
        jQuery.ajax({
            url: cmstngpath + 'admin_addcitation.php',
            data: params,
            type: 'POST',
            dataType: 'json',
            success: function (vars) {
                var div = jQuery('<div id="citations_' + vars.id + '" class="sortrow"></div>');

                var newcitetbl = document.createElement("table");
                newcitetbl.className = "normal";
                newcitetbl.cellPadding = 3;
                newcitetbl.cellSpacing = 1;
                newcitetbl.border = 0;
                var newtr = newcitetbl.insertRow(0);
                newtr.id = "row_" + vars.id;
                insertCell(newtr, 0, "dragarea", '<img src="img/admArrowUp.gif" alt=""><br/><img src="img/admArrowDown.gif" alt="">');
                var cell1 = insertCell(newtr, 1, "lightback", getActionButtons(vars, 'Citation'));
                cell1.width = "70";
                var cell2 = insertCell(newtr, 2, "lightback", vars.display)
                cell2.width = "445";
                div.append(newcitetbl);
                jQuery('#cites').append(div);
                initCitationSort();

                jQuery('#citationstbl').show();
                gotoSection('addcitation', 'citations');
                var iconid = form.eventID.value == 'SLGC' ? form.persfamID.value : '';
                jQuery('#citesicon' + form.eventID.value + iconid).removeClass('admin-cite-off-icon');
                jQuery('#citesicon' + form.eventID.value + iconid).addClass('admin-cite-on-icon');
            }
        });
    }
    return false;
}

function editCitation(citationID) {
    var params = {citationID: citationID};
    jQuery.ajax({
        url: cmstngpath + 'admin_editcitation.php',
        data: params,
        dataType: 'html',
        success: function (req) {
            jQuery('#editcitation').html(req);
            gotoSection('citations', 'editcitation');
        }
    });
    return false;
}

function updateCitation(form) {
    var citationID = form.citationID.value;
    var params = jQuery(form).serialize();
    jQuery.ajax({
        url: cmstngpath + 'admin_updatecitation.php',
        data: params,
        type: 'POST',
        dataType: 'json',
        success: function (vars) {
            var tds = jQuery('tr#row_' + citationID + ' td');
            tds.eq(2).html(vars.display);
            gotoSection('editcitation', 'citations');
            jQuery.each(tds, function (index, item) {
                jQuery(item).effect('highlight', {}, 2500);
            });
        }
    });
    return false;
}

function deleteCitation(citationID, personID, tree, eventID) {
    if (confirm(confdeletecite)) {
        var tds = jQuery('tr#row_' + citationID + ' td');
        jQuery.each(tds, function (index, item) {
            jQuery(item).effect('highlight', {color: '#ff9999'}, 2500);
        });
        var params = {citationID: citationID, personID: personID, tree: tree, eventID: eventID};
        jQuery.ajax({
            url: cmstngpath + 'admin_deletecitation.php',
            data: params,
            dataType: 'html',
            success: function (req) {
                jQuery('#row_' + citationID).fadeOut(200);
                if (req == '0') {
                    var iconid = eventID == 'SLGC' ? personID : '';
                    jQuery('#citesicon' + eventID + iconid).removeClass('admin-cite-on-icon');
                    jQuery('#citesicon' + eventID + iconid).addClass('admin-cite-off-icon');
                }
            }
        });
    }
    return false;
}

function addAssociation(form) {
    if (form.passocID.value == "")
        alert(enterpassoc);
    else if (form.relationship.value == "")
        alert(enterrela);
    else {
        var params = jQuery(form).serialize();
        jQuery.ajax({
            url: 'admin_addassoc.php',
            data: params,
            dataType: 'json',
            success: function (vars) {
                var associationstbl = document.getElementById('associationstbl');
                var newtr = associationstbl.insertRow(associationstbl.rows.length);
                newtr.id = "row_" + vars.id;
                insertCell(newtr, 0, "lightback", getActionButtons(vars, 'Association'));
                insertCell(newtr, 1, "lightback", vars.display)

                associationstbl.style.display = '';
                gotoSection('addassociation', 'associations');
                jQuery('#associcon').removeClass('admin-asso-off-icon');
                jQuery('#associcon').addClass('admin-asso-on-icon');
            }
        });
    }
    return false;
}

function editAssociation(assocID) {
    var params = {assocID: assocID};
    jQuery.ajax({
        url: 'admin_editassoc.php',
        data: params,
        dataType: 'html',
        success: function (req) {
            jQuery('#editassociation').html(req);
            gotoSection('associations', 'editassociation');
        }
    });
    return false;
}

function updateAssociation(form) {
    var assocID = form.assocID.value;
    var params = jQuery(form).serialize();
    jQuery.ajax({
        url: 'admin_updateassoc.php',
        data: params,
        dataType: 'json',
        success: function (vars) {
            var tds = jQuery('tr#row_' + assocID + ' td');
            tds.eq(1).html(vars.display);
            gotoSection('editassociation', 'associations');
            jQuery.each(tds, function (index, item) {
                jQuery(item).effect('highlight', {}, 2500);
            });
        }
    });
    return false;
}

function deleteAssociation(assocID, personID, tree) {
    if (confirm(confdeleteassoc)) {
        var tds = jQuery('tr#row_' + assocID + ' td');
        jQuery.each(tds, function (index, item) {
            jQuery(item).effect('highlight', {color: '#ff9999'}, 200);
        });
        var params = {assocID: assocID, personID: personID, tree: tree};
        jQuery.ajax({
            url: cmstngpath + 'admin_deleteassoc.php',
            data: params,
            dataType: 'html',
            success: function (req) {
                jQuery('#row_' + assocID).fadeOut(200);
                if (req == '0') {
                    jQuery('#associcon').removeClass('admin-asso-on-icon');
                    jQuery('#associcon').addClass('admin-asso-off-icon');
                }
            }
        });
    }
    return false;
}

function updateMore(form) {
    var params = jQuery(form).serialize();
    jQuery.ajax({
        url: cmstngpath + 'admin_updatemore.php',
        data: params,
        dataType: 'html',
        type: 'POST',
        success: function (req) {
            //if something saved, put an asterisk in the "More" button
            if (req == "1") {
                jQuery('#moreicon' + form.eventtypeID.value).removeClass('admin-more-off-icon');
                jQuery('#moreicon' + form.eventtypeID.value).addClass('admin-more-on-icon');
            } else {
                jQuery('#moreicon' + form.eventtypeID.value).removeClass('admin-more-on-icon');
                jQuery('#moreicon' + form.eventtypeID.value).addClass('admin-more-off-icon');
            }
            tnglitbox.remove();
        }
    });
    return false;
}

var branchtimer;

function showBranchEdit(branchdiv) {
    jQuery('#' + branchdiv).slideToggle(200);
    return false;
}

function updateBranchList(branchselect, branchdiv, branchlistdiv) {
    var branchlist = "";
    var gotnone = false;
    var firstone = null;
    jQuery('#' + branchselect + ' >option:selected').each(function (index, option) {
        if (!option.value) {
            gotnone = true;
            firstone = option;
        }
        if (branchlist) {
            if (gotnone) {
                branchlist = "";
                firstone.selected = false;
                gotnone = false;
            } else
                branchlist += ", ";
        }
        branchlist += option.text;
    });
    jQuery('#' + branchlistdiv).html(branchlist);
    showBranchEdit(branchdiv);
}

function quitBranchEdit(branchdiv) {
    branchtimer = setTimeout("showBranchEdit('" + branchdiv + "')", 3000);
}

function closeBranchEdit(branchselect, branchdiv, branchlistdiv) {
    branchtimer = setTimeout("updateBranchList('" + branchselect + "','" + branchdiv + "','" + branchlistdiv + "')", 500);
}

var activebox;
var seclitbox;

function openFindPlaceForm(field, temple) {
    activebox = field;
    var value = jQuery('#' + field).val();
    var templestr = temple ? "&temple=1" : "";
    seclitbox = new LITBox('findplaceform.php?tree=' + tree + '&place=' + encodeURIComponent(value) + templestr,
        {
            width: 645, height: 540,
            doneLoading: function () {
                jQuery('#myplace').val(value);
                initFilter(null, seclitbox, field, null);
                if (value) {
                    applyFilter({form: 'findform1', fieldId: 'myplace', type: 'L', tree: tree, destdiv: 'placeresults', temple: temple});
                }
                document.findform1.myplace.focus();
            }
        }
    );

    return false;
}

function filterPlace(fieldId, fieldName) {

}

function findItem(type, field, titlediv, findtree, findbranch, media) {
    var newpage, mediaparts, mediastr, branchstr;

    if (media) {
        mediaparts = media.split('_');
        if (mediaparts[0] == 'm')
            mediastr = '&mediaID=' + mediaparts[1];
        else
            mediastr = '&albumID=' + mediaparts[1];
    } else
        mediastr = '';
    //activebox = field;
    switch (type) {
        case "I":
            newpage = "findpersonform.php";
            startfield = "myflastname";
            break;
        case "F":
            newpage = "findfamilyform.php";
            startfield = "myhusbname";
            break;
        case "S":
            newpage = "findsourceform.php";
            startfield = "mytitle";
            break;
        case "R":
            newpage = "findrepoform.php";
            startfield = "mytitle";
            break;
        case "C":
            newpage = "findciteform.php";
            startfield = "mytitle";
            break;
        case "L":
            newpage = "findplaceform.php";
            startfield = "myplace";
            break;
    }
    branchstr = findbranch ? '&branch=' + findbranch : '';
    seclitbox = new LITBox(cmstngpath + newpage + '?tree=' + findtree + branchstr + mediastr, {width: 645, height: 540});
    initFilter(null, seclitbox, field, titlediv);
    jQuery('#' + startfield).focus();

    return false;
}

function returnValue(value) {
    jQuery('#' + activebox).val(value);
    seclitbox.remove();

    if (jQuery('#country').length && !jQuery('#country').prop('selectedIndex') && !jQuery('#state').prop('selectedIndex')) fillCemetery(value);
    return false;
}

function fillCemetery(value) {
    //explode place
    var parts = value.split(',');
    if (parts.length > 0) {
        var ptr = parts.length - 1;
        var current = parts[ptr].trim();
        if (jQuery('#country').prop('selectedIndex') < 1 && jQuery('#state').prop('selectedIndex') < 1 && !jQuery('#county').val() && !jQuery('#city').val() && !jQuery('#cemname').val()) {
            jQuery('#country > option').each(function (index, option) {
                if (this.value == current) {
                    jQuery('#country').prop('selectedIndex', index);
                    ptr -= 1;
                    current = parts[ptr].trim();
                    return false;
                }
            });
            jQuery('#state > option').each(function (index, option) {
                if (this.value == current) {
                    jQuery('#state').prop('selectedIndex', index);
                    ptr -= 1;
                    if (ptr >= 0) {
                        jQuery('#county').val(parts[ptr].trim());
                        ptr -= 1;
                    }
                    if (ptr >= 0) {
                        jQuery('#city').val(parts[ptr].trim());
                        ptr -= 1;
                    }
                    jQuery('#cemname').val(parts[ptr].trim());
                    return false;
                }
            });
        }
    }
}

function fillPlace(form) {
    var place = form.cemname.value;

    if (place && form.city.value) place += ", ";
    place += form.city.value;

    if (place && form.county.value) place += ", ";
    place += form.county.value;

    if (place && form.state.options[form.state.selectedIndex].value) place += ", ";
    place += form.state.options[form.state.selectedIndex].value;

    if (place && form.country.selectedIndex > 0) place += ", ";
    place += form.country.options[form.country.selectedIndex].value;

    jQuery('#place').val(place);
    jQuery('#location').val(place);
    jQuery('#place').effect('highlight', {}, 120);
}

var assocType = "I";

function activateAssocType(type) {
    if (type == "I") {
        jQuery('#person_label').show();
        jQuery('#family_label').hide();
    } else if (type == "F") {
        jQuery('#person_label').hide();
        jQuery('#family_label').show();
    }
    assocType = type;
}

var mrcaType = "I";

function activateMrcaType(type) {
    if (type == "I") {
        jQuery('#person_label').show();
        jQuery('#family_label').hide();
    } else if (type == "F") {
        jQuery('#person_label').hide();
        jQuery('#family_label').show();
    }
    mrcaType = type;
}

var lastFilter = "";
var lastCriteria = "c";
var filterStartSection, filterEndSection, itemIDField, itemTitleDiv;
var timeoutId = 0;

function filterChanged(event, options) {
    clearTimeout(timeoutId);

    var keycode;
    if (event) keycode = event.keyCode;
    else if (e) keycode = e.which;
    else return true;

    if (keycode == 9 || keycode == 13) return false;
    timeoutId = setTimeout(function () {
        applyFilter(options)
    }, 500);
}

function applyFilter(options) {
    var form = document.getElementById(options.form);
    options.criteria = document.getElementById(options.fieldId).value;
    if (form.filter)
        options.filter = form.filter[0].checked ? form.filter[0].value : form.filter[1].value;
    else
        options.filter = "c";

    if (options.criteria == lastCriteria && options.filter == lastFilter) {
        return false; //don't search because it's the same as it was the last time
    }
    jQuery('#' + options.destdiv).html('<span class="subhead">' + loadingmsg + "</span>");
    lastCriteria = options.criteria;
    lastFilter = options.filter;

    jQuery.ajax({
        url: cmstngpath + 'finditems.php',
        data: options,
        dataType: 'html',
        type: 'get',
        success: function (req) {
            jQuery('#' + options.destdiv).html(req);
        }
    });

    return false;
}

function initFilter(start, end, idfield, titlediv) {
    lastCriteria = "";
    filterStartSection = end;
    filterEndSection = start;
    itemIDField = idfield;
    itemTitleDiv = titlediv;

    if (start && end)
        gotoSection(start, end);
    return false;
}

function retItem(id, place) {
    var returntext = jQuery('#item_' + id).text();
    if (itemIDField == "children") {
        var childcount = parseInt(jQuery('#childcount').html()) + 1;
        returntext += "| - " + id + "<br />" + jQuery('#birth_' + id).html();

        var params = {personID: id, display: returntext, familyID: persfamID, tree: tree, order: childcount, action: 'addchild'};
        jQuery.ajax({
            url: 'ajx_updateorder.php',
            data: params,
            type: 'POST',
            dataType: 'html',
            success: function (req) {
                jQuery('#childrenlist').append(req);
                jQuery('#child_' + id).fadeIn(400);
                jQuery('#childcount').html(childcount);
                jQuery('#childrenlist').sortable({tag: 'div', update: updateChildrenOrder});
            }
        });
    } else if (itemIDField == "imagemap") {
        var current = jQuery('#mlbox');
        var pos = current.position();
        var imgpos = jQuery('#myimg').position();

        var x1 = Math.round(pos.left - imgpos.left);
        var y1 = Math.round(pos.top - imgpos.top);
        var x2 = x1 + current.width();
        var y2 = y1 + current.height();

        var maptree = jQuery('#maptree').val();
        var area = '<area coords=\"' + x1 + ',' + y1 + ',' + x2 + ',' + y2 + '\" href=\"' + getperson_url + 'personID=' + id + '&amp;tree=' + maptree + '\" title=\"' + returntext.replace(/\"/g, "'") + '\" />';
        jQuery('#imagemap').val(jQuery('#imagemap').val() + area);

        current.remove();
    } else if (itemIDField == "dupIDs") {
        var all_ids = jQuery('#' + itemIDField).val();
        if (all_ids)
            all_ids += ",";
        all_ids += id;
        jQuery('#' + itemIDField).val(all_ids);
    } else {
        jQuery('#' + itemIDField).val(place ? returntext : id);
        if (itemTitleDiv && jQuery('#' + itemTitleDiv).length) {
            if (jQuery('#birth_' + id).length && jQuery('#birth_' + id).html())
                returntext += " (" + jQuery('#birth_' + id).html() + ")";
            if (jQuery('#id_' + id).length)
                returntext += " - " + id;
            if (jQuery('#' + itemTitleDiv).attr('type') == "text") {
                jQuery('#' + itemTitleDiv).val(returntext);
                jQuery('#' + itemTitleDiv).effect('highlight', {}, 400);
            } else
                jQuery('#' + itemTitleDiv).html(returntext);
        }
        if (jQuery('#deststrfield'))
            jQuery('#deststrfield').html('(' + returntext + ')');
    }
    gotoSection(filterStartSection, filterEndSection);
    if (jQuery('#country').length && !jQuery('#country').prop('selectedIndex') && !jQuery('#state').prop('selectedIndex'))
        fillCemetery(returntext);

    return false;
}

function initNewItem(type, destid, idfield, titlediv, start, end) {
    itemIDField = idfield;
    itemTitleDiv = titlediv;

    generateID(type, destid);
    return gotoSection(start, end);
}

function saveSource(form) {
    if (form.sourceID.value) {
        var params = jQuery(form).serialize();
        params.ajax = 1;
        jQuery.ajax({
            url: 'admin_addsource.php',
            data: params,
            type: 'POST',
            dataType: 'html',
            success: function (req) {
                if (req.indexOf("error:") == 0) {
                    jQuery('#source_error').html(substr(req, 6));
                } else {
                    jQuery('#' + itemIDField).val(form.sourceID.value);
                    jQuery('#' + itemTitleDiv).html(form.shorttitle.value ? form.shorttitle.value : form.title.value);
                    var dest = itemIDField == 'sourceID' ? 'addcitation' : 'editcitation';
                    gotoSection('newsource', dest);
                    jQuery('#source_error').html("");
                    form.reset();
                }
            }
        });
    }
    return false;
}

function getTempleCheck() {
    return (jQuery("#temple").length && jQuery("#temple").prop('checked') ? 1 : 0);
}

function copylast(form, citationID) {
    jQuery('#lastspinner').show();
    var params = {citationID: citationID};
    jQuery.ajax({
        url: 'ajx_getlastcite.php',
        data: params,
        dataType: 'json',
        success: function (vars) {
            //fill in form values
            form.sourceID.value = vars.sourceID;
            form.citepage.value = vars.citepage;
            form.quay.selectedIndex = vars.quay == "" ? 0 : parseInt(vars.quay) + 1;
            form.citedate.value = vars.citedate;
            form.citetext.value = vars.citetext;
            form.citenote.value = vars.citenote;
            jQuery('#sourceTitle').html(vars.title);
            jQuery('#lastspinner').hide();
        }
    });
    return false;
}
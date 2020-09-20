var tnglitbox;
var timecheck;
var lastptr;
var treeval;

var done = false;
var started = false;
var suspended = false;
var submitted = false;

var restarts_left = 15;

function checkFile(form) {
    let rval = true;
    var treeselect = document.form1.tree1;
    if (form.remotefile.value.length == 0 && form.database.value.length == 0) {
        alert(selectimportfile);
        rval = false;
    } else if (form.tree1.selectedIndex == 0 && form.tree1.options[form.tree1.selectedIndex].value == "" && !form.eventsonly.checked) {
        alert(selectdesttree);
        rval = false;
    }

    if (rval && form.target) {
        if (form.action.indexOf("admin_gedimport.php") >= 0) {
            resetimport();
            var popup = '<div class="impcontainer">\n';
            popup += '<div class="impheader"><strong><span id="importmsg" class="subhead">';
            if (form.remotefile.value.length)
                popup += uploading + ' ' + form.remotefile.value;
            else
                popup += opening + ' ' + form.database.value;
            popup += '... &nbsp;<img src="img/spinner.gif"></span></strong></div>\n';
            popup += '<div id="impdata" style="visibility:hidden;">\n';
            popup += '<p id="recordcount">\n<span class="imp">&nbsp;<span class="implabel">' + peoplelbl + ': </span><span id="personcount" class="impctr">0</span></span>\n';
            popup += '<div class="imp">&nbsp;<span class="implabel">' + familieslbl + ': </span><span id="familycount" class="impctr">0</span></div>\n';
            popup += '<div class="imp">&nbsp;<span class="implabel">' + sourceslbl + ': </span><span id="sourcecount" class="impctr">0</span></div>\n';
            popup += '<div class="imp">&nbsp;<span class="implabel">' + noteslbl + ': </span><span id="notecount" class="impctr">0</span></div>\n';
            popup += '<div class="imp">&nbsp;<span class="implabel">' + medialbl + ': </span><span id="mediacount" class="impctr">0</span></div>\n';
            popup += '<div class="imp">&nbsp;<span class="implabel">' + placeslbl + ': </span><span id="placecount" class="impctr">0</span></div>\n</p><br><br>';
            popup += '<div class="progcontainer tngshadow"><div id="progress" class="emptybar">\n<div id="bar" class="colorbar"></div>\n</div>\n</div>\n';
            popup += '</div>\n';
            popup += '<br><div id="implinks" class="subhead"><a href="#" onclick="return suspendimport();">' + stopmsg + '</a>';
            if (saveimport == "1") {
                treeval = treeselect.options[treeselect.selectedIndex].value;
                popup += ' |  <a href="admin_gedimport.php?tree=' + treeval + '&resuming=1" id="resumelink" target="results" onclick="resumeimport();">' + resumemsg + '</a>';
            }
            popup += '</div>\n<div id="errormsg"></div>';
            popup += '</div>';
            tnglitbox = new LITBox(popup, {
                type: 'alert', width: 600, height: 250, onremove: function () {
                    if (!done) stopimport();
                }
            });
            lastptr = 0;
        } else
            document.form1.target = "main";
    }
    return rval;
}

function iframeLoaded() {
    if (submitted && started && !done && !suspended) {
        //restart if that is an option
        var treeselect = document.form1.tree1;
        self.frames[0].location.href = "admin_gedimport.php?tree=" + treeselect.options[treeselect.selectedIndex].value + "&resuming=1";

        //may not be necessary with "onload"
        //v12: putting it back so we can restart if we're not getting partial out
        timecheck = setTimeout(checkIfDone, checksecs);
    }
}

function resetimport() {
    done = false;
    started = false;
    suspended = false;
    submitted = true;
}

function resumeimport() {
    jQuery('#importmsg').html(reopenmsg + ' ' + treeval + '...');
    suspended = false;
}

function stopimport() {
    suspendimport();
    done = true;
}

function suspendimport() {
    if (document.all)
        document.execCommand("stop");
    else
        window.stop();
    jQuery('#importmsg').html(stoppedmsg);
    suspended = true;
    return false;
}

function checkIfDone() {
    if (started && !done && !suspended) {
        //console.log('still going at '+lastptr);
        if (lastptr == $('#bar').width()) {
            var treeselect = document.form1.tree1;
            self.frames[0].location.href = "admin_gedimport.php?tree=" + treeselect.options[treeselect.selectedIndex].value + "&resuming=1";
        } else {
            lastptr = $('#bar').width();
        }
        if (restarts_left) {
            timecheck = setTimeout(checkIfDone, checksecs);
            restarts_left--;
        }
    }
}

function removeFile(filename) {
    var params = {filename: filename};
    jQuery.ajax({
        url: 'admin_deletefile.php',
        data: params,
        dataType: 'html',
        success: function (req) {
            jQuery('#toremove').html(req);
        }
    });
    return false;
}

function validateTreeForm(form) {
    if (form.gedcom.value.length == 0) {
        alert(entertreeid);
        rval = false;
    } else if (!alphaNumericCheck(form.gedcom.value)) {
        alert(alphanum);
    } else if (form.treename.value.length == 0) {
        alert(entertreename);
    } else {
        var params = jQuery(form).serialize();
        jQuery.ajax({
            url: 'admin_addtree.php',
            data: params,
            dataType: 'html',
            success: function (req) {
                if (req == "1") {
                    tnglitbox.remove();
                    var treeselect = document.form1.tree1;
                    var i = treeselect.options.length;
                    if (navigator.appName == "Netscape") {
                        treeselect.options[i] = new Option(form.treename.value, form.gedcom.value, false, false)
                    } else if (navigator.appName == "Microsoft Internet Explorer") {
                        treeselect.add(document.createElement("OPTION"));
                        treeselect.options[i].text = form.treename.value;
                        treeselect.options[i].value = form.gedcom.value;
                    }
                    treeselect.selectedIndex = i;
                } else
                    jQuery('#treemsg').html(req);
            }
        });
    }
    return false;
}

function toggleAppenddiv(flag) {
    if (flag)
        jQuery('#appenddiv').fadeIn(200);
    else
        jQuery('#appenddiv').fadeOut(200);
}

function toggleNorecalcdiv(flag) {
    if (flag)
        jQuery('#norecalcdiv').fadeIn(200);
    else
        jQuery('#norecalcdiv').fadeOut(200);
}

function toggleSections(flag) {
    jQuery('#desttree').toggle(400);
    jQuery('#replace').toggle(400);
    jQuery('#ioptions').toggle(400);
    document.form1.action = flag ? 'admin_gedimport_eventtypes.php' : document.form1.action = 'admin_gedimport.php';
    if (flag) document.form1.allevents.checked = "";
}

function alphaNumericCheck(string) {
    var regex = /^[0-9A-Za-z_-]+$/; //^[a-zA-z]+$/
    return regex.test(string);
}

function getBranches(treeselect, selected) {
    if (selected) {
        var tree = treeselect.options[treeselect.selectedIndex].value;
        var treeidx = tree ? tree : 'none';

        if (branchcounts[treeidx] == -1) {
            var params = {tree: tree};
            jQuery.ajax({
                url: 'admin_branchoptions.php',
                data: params,
                dataType: 'html',
                success: function (req) {
                    branchcounts[treeidx] = req == "0" ? 0 : 1;
                    if (branchcounts[treeidx]) {
                        branches[treeidx] = req;
                    }
                    showBranches(treeidx);
                }
            });
        } else
            showBranches(treeidx);
    } else
        jQuery('#destbranch').fadeOut(200);
}

function showBranches(treeidx) {
    if (branchcounts[treeidx] == 1) {
        jQuery('#branch1div').html('<select name="branch1" id="branch1">' + branches[treeidx] + '</select>');
        jQuery('#destbranch').fadeIn(200);
    } else {
        jQuery('#destbranch').fadeOut(200);
    }
}

function toggleTarget(form) {
    if (form.target)
        form.target = "";
    else
        form.target = "results";
}
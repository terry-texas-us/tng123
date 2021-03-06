<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_media_edit) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

if ($assignedtree) {
    $wherestr = "WHERE gedcom = '$assignedtree'";
    $tree = $assignedtree;
} else {
    $wherestr = "";
}
$treequery = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";

$helplang = findhelp("media_help.php");

tng_adminheader(_('Sort xxx for'), $flags);
?>
<script src="js/mediafind.js"></script>
<script src="js/mediautils.js"></script>
<script src="js/selectutils.js"></script>
<script src="js/datevalidation.js"></script>
<script>
    var preferEuro = <?php echo($tngconfig['preferEuro'] ? $tngconfig['preferEuro'] : "false"); ?>;
    var preferDateFormat = '<?php echo $preferDateFormat; ?>';
    var findopen;
    var album = '';
    var media = '';
    var type = "media";
    //var formname = "find";
    var findform = "find";
    // TODO text ['reshere'] was not defined in any language. Manually added here.
    var resheremsg = '<span class="normal">' + "<?php echo _todo_('reshere'); ?>" + '</span>';
    var tng_thumbmaxw = <?php echo($thumbmaxw ? $thumbmaxw : "80"); ?>;
    var tng_thumbmaxh = <?php echo($thumbmaxh ? $thumbmaxh : "80"); ?>;
    var links_url = "ajx_medialinks.php";
    var findform;
    <?php
    echo "const altdescmsg = \"" . _('Alternate Title') . "\";\n";
    echo "const altnotesmsg = \"" . _('Alternate Description') . "\";\n";
    echo "const makedefaultmsg = \"" . _('Make Default') . "\";\n";
    echo "const eventlinkmsg = \"" . _('Link to specific event') . "\";\n";
    echo "const eventmsg = \"" . _('Event(s)') . "\";\n";
    echo "const sortmsg = \"" . _('Sort') . "\";\n";
    echo "const confdellink = \"" . _('Are you sure you want to delete this link?') . "\";\n";
    echo "const remove_text = \"" . _('Remove Link') . "\";\n";
    echo "const edit_text = \"" . _('Edit') . "\";\n";
    echo "const yesmsg = \"" . _('Yes') . "\";\n";
    ?>

    function enableSave(savebuttonid) {
        jQuery('#q' + savebuttonid).removeAttr('disabled');
        jQuery('#q' + savebuttonid + ' span').show();
        jQuery('#ch' + savebuttonid).hide();
    }

    function validateForm() {
        let rval = true;
        if (document.find.newlink1.value.length == 0) {
            alert("<?php echo _('Please enter an ID for the selected Link Type.'); ?>");
            rval = false;
        }
        return rval;
    }

    function getTree(treeobj) {
        if (treeobj.options.length)
            return treeobj.options[treeobj.selectedIndex].value;
        else {
            alert("<?php echo _('Please select/add a tree.'); ?>");
            return false;
        }
    }

    function confirmDelete(event) {
        if (confirm('<?php echo _('Are you sure you want to delete this media?'); ?>'))
            return true;
        else {
            event.preventDefault();
            event.stopPropagation();
            return false;
        }
    }

    var mediafolders = new Array();
    <?php
    foreach ($mediatypes as $mediatype) {
        $ID = $mediatype['ID'];
        echo "mediafolders['$ID'] = '{$mediatypes_assoc[$ID]}';\n";
    }
    ?>

    function changeCollection(coll) {
        var mediatype = coll.options[coll.selectedIndex].value;
        jQuery('#folderlabel').html(mediafolders[mediatype]);
        jQuery('#folder').val("");
    }

    jQuery(document).ready(function () {
        jQuery('#linker').click(function (e) {
            e.preventDefault();
            if (jQuery('#newlink1').val()) {
                var medialist = "";

                jQuery('.mediacheck:checked').each(function () {
                    medialist += (medialist ? "," + this.id : this.id);
                });
                if (medialist) {
                    var linkermsg = jQuery('#linkermsg');
                    linkermsg.html('&nbsp;<img src="img/spinner.gif">');

                    var params = jQuery('#linkerform').serialize();
                    params += "&medialist=" + medialist + "&action=masslink";
                    jQuery.ajax({
                        url: 'ajx_updateorder.php',
                        data: params,
                        dataType: 'html',
                        success: function (req) {
                            linkermsg.html('<span class="green">' + req + '</span>');
                            linkermsg.effect("highlight", {}, 2500);
                        },
                        error: function (req) {
                            linkermsg.html("An error has occurred. Please try again.");
                        }
                    });
                }
            }
            return false;
        });
    });
</script>
<link rel="stylesheet" href="css/bootstrap.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="css/jquery.fileupload-ui.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript>
    <link rel="stylesheet" href="css/jquery.fileupload-ui-noscript.css">
</noscript>
<!-- Shim to make HTML5 elements usable in older Internet Explorer versions -->
<!--[if lt IE 9]><script src="<?php echo $http; ?>://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

<?php
echo "</head>\n";
echo tng_adminlayout();

$mediatabs[0] = [1, "admin_media.php", _('Search'), "findmedia"];
$mediatabs[1] = [$allow_media_add, "admin_newmedia.php", _('Add New'), "addmedia"];
$mediatabs[2] = [$allow_media_edit, "admin_ordermediaform.php", _('Sort'), "sortmedia"];
$mediatabs[3] = [!$assignedtree, "admin_thumbnails.php", _('Thumbnails'), "thumbs"];
$mediatabs[4] = [$allow_media_add && !$assignedtree, "admin_photoimport.php", _('Import'), "import"];
$mediatabs[5] = [$allow_media_add, "admin_mediaupload.php", _('Upload'), "upload"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/media_help.php#upload');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($mediatabs, "upload", $innermenu);
echo displayHeadline(_('Media') . " &gt;&gt; " . _('Upload'), "img/photos_icon.gif", $menu, $message);
?>

<table class="lightback">
    <tr class="databack">
        <td class="tngshadow normal">
            <h3 class="subhead"><?php echo _('Upload Media'); ?></h3>

            <form id="fileupload" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
                <!-- Redirect browsers with JavaScript disabled to the origin page -->
                <?php echo _('Collection'); ?>:
                <select name="mediatypeID" id="mediatypeID" onchange="changeCollection(this);">
                    <?php
                    foreach ($mediatypes as $mediatype) {
                        $msgID = $mediatype['ID'];
                        echo "	<option value=\"$msgID\">" . $mediatype['display'] . "</option>\n";
                    }
                    ?>
                </select>
                &nbsp;
                <?php
                echo _('Tree') . ": ";
                if ($assignedtree) {
                    if ($row['gedcom']) {
                        $treeresult = tng_query($treequery) or die (_('Cannot execute query') . ": $treequery");
                        $treerow = tng_fetch_assoc($treeresult);
                        echo $treerow['treename'];
                        tng_free_result($treeresult);
                    } else {
                        echo _('All Trees');
                    }
                    echo "<input type='hidden' name='tree' value=\"{$row['gedcom']}\">";
                } else {
                    echo "<select name=\"tree\">";
                    echo "	<option value=\"\">" . _('All Trees') . "</option>\n";
                    if ($row['gedcom']) $tree = $row['gedcom'];

                    $treeresult = tng_query($treequery) or die (_('Cannot execute query') . ": $treequery");
                    while ($treerow = tng_fetch_assoc($treeresult)) {
                        echo "	<option value=\"{$treerow['gedcom']}\"";
                        if ($treerow['gedcom'] == $row['gedcom']) {
                            echo " selected";
                        }
                        echo ">{$treerow['treename']}</option>\n";
                    }
                    echo "</select>&nbsp;&nbsp;\n";
                    tng_free_result($treeresult);
                }
                $mediatypeID = $mediatypes[0]['ID'];
                $folder = $mediatypes_assoc[$mediatypeID];
                echo _('Folder') . ": <span id=\"folderlabel\">$folder</span>/";
                ?>
                <input type="text" id="folder" name="folder" class="w-64">
                <input type="button" value="<?php echo _('Select') . "..."; ?>" name="folderselect" onclick="FilePicker('folder',jQuery('#mediatypeID').val(),1);">
                <br><br>

                <noscript>
                    <input type="hidden" name="redirect" value="{$http}://blueimp.github.com/jQuery-File-Upload/">
                </noscript>
                <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                <div class="float-left row fileupload-buttonbar">
                    <div class="span7">
                        <!-- The fileinput-button span is used to style the file input field as button -->
                        <span class="btn fileinput-button">
		            	<span><?php echo _('Add files...'); ?></span>
		                <input type="file" name="files[]" multiple>
		            </span>&nbsp;
                        <input type="submit" class="btn start" value="<?php echo _('Start upload'); ?>">
                        <input type="reset" class="btn cancel" value="<?php echo _('Cancel upload'); ?>">
                    </div>
                </div>
                <!-- The global progress information -->
                <div class="span5 fileupload-progress fade">
                    <!-- The global progress bar -->
                    <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                        <div class="bar" style="width:0;"></div>
                    </div>
                    <!-- The extended global progress information -->
                    <div class="progress-extended">&nbsp;</div>
                </div>
                <br class="clear-both">
                <!-- The loading indicator is shown during file processing -->
                <div class="fileupload-loading"></div>
                <br>
                <div id="uploadarea">
                    <!-- The table listing the files available for upload/download -->
                    <table role="presentation" class="table table-striped normal">
                        <tbody class="files"></tbody>
                    </table>
                </div>
            </form>

            <br>

            <form action="admin_ordermedia.php" method="get" name="find" id="linkerform" onsubmit="return validateForm();">
                <table cellspacing="2" class="normal">
                    <tr>
                        <td><?php echo _('Tree'); ?></td>
                        <td><?php echo _('Type'); ?></td>
                        <td colspan="3"><?php echo _('ID'); ?></td>
                    </tr>
                    <tr>
                        <td class='align-top'>
                            <select name="tree1">
                                <?php
                                $treeresult = tng_query($treequery) or die (_('Cannot execute query') . ": $treequery");
                                while ($treerow = tng_fetch_assoc($treeresult)) {
                                    echo "	<option value=\"{$treerow['gedcom']}\"";
                                    if ($treerow['gedcom'] == $tree) echo " selected";

                                    echo ">{$treerow['treename']}</option>\n";
                                }
                                tng_free_result($treeresult);
                                ?>
                            </select>
                        </td>
                        <td class='align-top'>
                            <select name="linktype1" onchange="toggleEventLink(this.selectedIndex);">
                                <option value="I"><?php echo _('Person'); ?></option>
                                <option value="F"><?php echo _('Family'); ?></option>
                                <option value="S"><?php echo _('Source'); ?></option>
                                <option value="R"><?php echo _('Repository'); ?></option>
                                <option value="L"><?php echo _('Place'); ?></option>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="newlink1" id="newlink1" value="<?php echo $personID; ?>" onblur="toggleEventRow(document.find.eventlink1.checked);">
                        </td>
                        <td><a href="#"
                                onclick="return findItem(document.find.linktype1.options[document.find.linktype1.selectedIndex].value,'newlink1',null,document.find.tree1.options[document.find.tree1.selectedIndex].value,'<?php echo $assignedbranch; ?>');"
                                title="<?php echo _('Find...'); ?>" class="smallicon admin-find-icon"></a></td>
                        <td>
                            <input type="button" class="toggle" value="<?php echo _('Select All'); ?>">
                            <input type="submit" id="linker" value="<?php echo _('Link to selected'); ?>"> &nbsp; <span id="linkermsg"></span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                        <td colspan="2">
                            <span id="eventlink1" class="normal"><input type="checkbox" name="eventlink1" value="1" onclick="return toggleEventRow(this.checked);"> <?php echo _('Link to specific event'); ?></span><br>
                            <select name="event1" id="eventrow1" style="display:none;">
                                <option value=""></option>
                            </select>
                        </td>
                        <td class="align-top normal">&nbsp;</td>
                    </tr>
                </table>

            </form>

        </td>
    </tr>

</table>

<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="preview"><span class="fade"></span></td>
        <td class="name"><span>{%=file.name%}</span></td>
        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
        {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label label-important">Error</span> {%=file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td>
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
            </td>
            <td class="start">{% if (!o.options.autoUpload) { %}
                <button class="btn">
                    <span><?php echo _('Start'); ?></span>
                </button>
            {% } %}</td>
        {% } else { %}
            <td colspan="2"></td>
        {% } %}
        <td class="cancel">{% if (!i) { %}
            <button class="btn">
                <span><?php echo _('Cancel'); ?></span>
            </button>
        {% } %}</td>
    </tr>
{% } %}


</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        {% if (file.error) { %}
            <td>&nbsp;</td>
            <td class="name"><span>{%=file.name%}</span></td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td class="error"><span class="label label-important">Error</span> {%=file.error%}</td>
        {% } else { %}
            <td class="preview">{% if (file.thumbnail_url) { %}
                <img src="{%=file.thumbnail_url%}" class="thumb">
            {% } %}</td>
			<td>
				<?php echo _('Title') . "<hr>\n" . _('Description'); ?><br><br>
				<button class="savebutton" id="q{%=file.mediaID%}" disabled="disabled">
					<span style="display:none;"><?php echo _('Save'); ?></span><img src="img/tng_check.gif" alt="" id="ch{%=file.mediaID%}" />
				</button> &nbsp;
				<span id="spin{%=file.mediaID%}" style="visibility:hidden"><img src="img/spinner.gif" /></span>
			</td>
            <td class="name">
            	<form id="f{%=file.mediaID%}">
            		<input type="text" id="t{%=file.mediaID%}" value="{%=file.name%}" name="title" class="uploadfield" onkeypress="enableSave('{%=file.mediaID%}');" onpaste="enableSave('{%=file.mediaID%}');"/><br>
            		<textarea id="d{%=file.mediaID%}" name="description" rows="3" class="uploadfield" onkeypress="enableSave('{%=file.mediaID%}');" onpaste="enableSave('{%=file.mediaID%}');"></textarea>
					<input type="hidden" id="mediaID" name="mediaID" value="{%=file.mediaID%}" />
					<table class="uploadmore">
						<tr>
							<td><?php echo _('Owner/Source'); ?>:</td>
							<td><input type="text" id="o{%=file.mediaID%}" name="owner" value="" size="40" onkeypress="enableSave('{%=file.mediaID%}');" onpaste="enableSave('{%=file.mediaID%}');"></td>
						</tr>
						<tr>
							<td><?php echo _('Date Taken/Created'); ?>:</td>
							<td><input type="text" id="k{%=file.mediaID%}" name="datetaken" value="" size="40" onblur="checkDate(this);" onkeypress="enableSave('{%=file.mediaID%}');" onpaste="enableSave('{%=file.mediaID%}');"></td>
						</tr>
					</table>
            	</form>	
            </td>
            <td class="size">
            	<button class="linksbutton" id="l{%=file.mediaID%}">
            		<span class="whitespace-no-wrap"><?php echo _('Media Links'); ?></span>
            	</button><br><br>
            	<span>&nbsp;{%=file.dims%}</span><br>
            	<span>&nbsp;{%=o.formatFileSize(file.size)%}</span><br><br>
				<span>&nbsp;<a href="admin_editmedia.php?mediaID={%=file.mediaID%}" target="_blank"><?php echo _('Edit'); ?></a>
            </td>
            <td>&nbsp;</td>
        {% } %}
        <td class="delete">
            <button class="delbutton" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %} onclick="return confirmDelete(event);">
                <span><?php echo _('Delete'); ?></span>
            </button><br><br>
            &nbsp;<?php echo _('Select'); ?>: <input type="checkbox" name="delete" value="1" class="mediacheck" id="{%=file.mediaID%}">

        </td>
    </tr>
{% } %}


</script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="js/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="js/tmpl.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="js/load-image.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="js/canvas-to-blob.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="js/jquery.fileupload.js"></script>
<!-- The File Upload file processing plugin -->
<script src="js/jquery.fileupload-fp.js"></script>
<!-- The File Upload user interface plugin -->
<script src="js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="js/main.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE8+ -->
<!--[if gte IE 8]>
<script src="js/cors/jquery.xdr-transport.js"></script><![endif]-->

<?php echo tng_adminfooter(); ?>

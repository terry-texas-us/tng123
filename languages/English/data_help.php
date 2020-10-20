<?php
include "../../helplib.php";
echo help_header("Help: Data Import");
?>

    <body class="helpbody">
    <a id="top"></a>
    <table class="tblback normal">
        <tr class="fieldnameback">
            <td class="tngshadow">
                <p style="float:right; text-align:right;" class="smaller menu">
                    <a href="https://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                    <a href="https://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                    <a href="mostwanted_help.php" class="lightlink">&laquo; Help: Most Wanted</a> &nbsp;|&nbsp;
                    <a href="second_help.php" class="lightlink">Help: Secondary Processes &raquo;</a>
                </p>
                <h2 class="largeheader">Help: <small>Import / Export</small></h2>
                <p class="smaller menu clear-both">
                    <a href="#import" class="lightlink">GEDCOM Import</a> &nbsp;|&nbsp;
                    <a href="#export" class="lightlink">GEDCOM Export</a>
                </p>
            </td>
        </tr>
        <tr class="databack">
            <td class="tngshadow">
                <div id="google_translate_element" style="float:right;"></div>
                <script>
                    function googleTranslateElementInit() {
                        new google.translate.TranslateElement({
                            pageLanguage: 'en',
                            includedLanguages: '<?php echo INCLUDED_LANGUAGES; ?>',
                            layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL
                        }, 'google_translate_element');
                    }

                </script>
                <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

                <a id="import"><h4 class="subheadbold">GEDCOM Import</h4></a>
                <p>This page allows you to import all data from a standard GEDCOM file into a particular tree.</p>

                <p><h5>Before Importing:</h5> Use your desktop genealogy software to create a standard 5.5 GEDCOM file (4.0 will
                also work). You may choose to exclude
                private information for living individuals, but this is not necessary. It is also not necessary to exclude LDS information, as this
                can be filtered as well depending on user rights.</p>

                <p>After you've created your GEDCOM file, the next step is to get it to your web site. Please take note of the following items on the
                    page:</p>

                <p><h5>[Import GEDCOM] From your computer</h5>
                To upload and import your file to your site without using FTP, click on the "Browse" button and locate the file on your hard drive.
                The name and path of your file will appear in this field after you select it.
                <strong>NOTE</strong>: If your GEDCOM file is very large (> 2Mb), you might need to check with your hosting provider before you can
                upload your file this way, as the server may have a maximum size
                limit for files uploaded via a web form. If you receive an error during the import, this is likely the case. Try using FTP to copy
                your
                file to the GEDCOM folder instead, then import it from there (see below).</p>

                <h5>OR [Import GEDCOM] From web site (in GEDCOM folder)</h5>
                <p>If you used FTP or an online file manager to transfer the file to the GEDCOM folder on your site, enter the exact name of your
                    uploaded
                    file here, or click on
                    the "Select" button to locate it on your site. It must be in the GEDCOM folder, or the Select button will not find it.
                    <strong>NOTE</strong>: If you see a list
                    of files but they are not from your GEDCOM folder, you likely have a path problem. Check your Root Path (Admin/Setup/General
                    Settings)
                    and your GEDCOM path (Admin/Setup/Import Settings).</p>

                <h5>Accept data for all new Custom Event Types</h5>
                <p>Your GEDCOM file might contain events that TNG considers as "Custom" events. Normally, new Custom Event Types included in a GEDCOM
                    file
                    are entered into the database, but
                    the data is set to be ignored. You would need to change the status of a Custom Event Type to "Accept" in order for events of that
                    type
                    to be imported (in other words,
                    you would need to import your file twice). If you check this option, TNG will automatically set all new Custom Event Types to
                    "Accept", and all your events
                    will be imported the first time.</p>

                <h5>Import Custom Event Types Only (no data is added, replaced or appended)</h5>
                <p>Checking this option will cause only Custom Event Types to be imported (see Admin/Custom Event Types). All other data is ignored.
                    This
                    is an ideal
                    option to select during your initial setup, as it will allow you to see which custom events you have in your gedcom. You can then
                    select which ones
                    to accept and which ones to ignore before importing your entire database.</p>

                <h5>Destination Tree</h5>
                <p>Select a Tree to receive the imported data (required). If the tree to receive the data does not yet exist, click on the "Add New
                    Tree"
                    button to create it.
                    A small popup box will appear and allow you to enter the information for the new tree.</p>

                <h5>Replace all current data</h5>
                <p>If you choose this option, all your previous GEDCOM data (people, families, children, sources, repositories, events, notes,
                    associations and citations; not media or anything else)
                    will be deleted prior to the import.
                    <strong>NOTE</strong>: Links to media will be preserved as long as the people/family/source/repository IDs in your new GEDCOM
                    match
                    the IDs in your existing data.
                    Most desktop genealogy programs assign permanent IDs to each person/family/source/repository, but a few do not. If you have linked
                    in
                    any media items, please check
                    your new GEDCOM to make sure the IDs match before you import, no matter which of these import options you select. It might also be
                    a
                    good idea to backup your tables before
                    performing an import (see Admin/Utilities to perform a backup).</p>

                <h5>Replace matching records only</h5>
                <p>With this option, new records are added and matching records are replaced (matches are determined by ID only). Old data is not
                    deleted.</p>

                <h5>Do not replace any data</h5>
                <p>New records are added, but any matches are ignored (not replaced).</p>

                <h5>Append all records</h5>
                <p>All records are imported, regardless of existing data, but their IDs are recalculated. IDs numbers for the imported records will be
                    added to the first
                    available number (or a number you specify) to create the new ID numbers.</p>

                <h5>Uppercase all surnames</h5>
                <p>Check this box prior to importing if you want all incoming surnames to be converted to upper case. The surnames will be stored in
                    the
                    database this way,
                    so the process is not reversable unless you import your GEDCOM file again.</p>

                <h5>Do not recalculate Living flag</h5>
                <p>If you chose "Replace matching records only" above, you will also see this option. Check this box prior to importing
                    if you do not want the Living flag to be recalculated for individuals that were already in the database.</p>

                <h5>Replace only if newer</h5>
                <p>Matching records will only be replaced if the incoming record is newer than the one in the database. This is based on the "Last
                    Modified" or CHAN
                    date associated with the record in the GEDCOM.</p>

                <h5>Import media if present</h5>
                <p>If your GEDCOM contains links to media, selecting this option will allow TNG to import them and set up the appropriate links.
                    You must still copy the physical files associated with these links to the appropriate folders on your site via other means (e.g.,
                    FTP). If you do not want to
                    import any media links, make sure this box is not checked prior to performing the import.</p>

                <h5>Start IDs at first available number/Start IDs at</h5>
                <p>If you chose "Append all records" above, you will also see this option. Check the first option to have
                    TNG add the numbers for the incoming IDs to the first available slot in each category (individuals, families, sources,
                    repositories)
                    to create the new IDs.
                    Check the second option if you want TNG to create the new IDs by adding the incoming ID numbers to a specific number (same for
                    each
                    category).
                    If you choose this option, be careful that no records exist in the indicated range or you will have collisions.</p>

                <h5>Old style import</h5>
                <p>Prior to TNG 7, the import did not show a progress bar. Instead, a counter was printed repeatedly to the screen for the number of
                    people and families imported.
                    The new number would always be displayed next to the old number, and soon they would be scrolling off the page. The progress bar
                    is
                    cleaner and more intuitive,
                    but in some cases the old import actually works better because more information is being displayed on the screen, a little bit at
                    a
                    time. If the new import
                    fails for you, you might try checking this option to see if the old import performs any better.</p>

                <p>When you're ready, click on the <strong>Import Data</strong> button to begin the process. You should see a progress bar and a
                    series of
                    counter track the
                    individuals, families, sources, notes and places imported (note: only places with associated latitude/longitude data are counted).
                    A
                    final
                    message will indicate the import has finished properly.</p>

                <h5>"Resume" Feature</h5>
                <p>If you do not see the "Finished" message, your server may have killed your import process for running too long.
                    If this happens to you, go to the Admin/Setup/Import Settings page
                    and check the box next to <strong>Save Import State</strong>. Then return to the Import page and try your import again. If the
                    same
                    condition
                    occurs, the import should now be able to restart itself.</p>

            </td>
        </tr>
        <tr class="databack">
            <td class="tngshadow">

                <p style="float:right;"><a href="#top">Top</a></p>
                <a id="export"><h4 class="subheadbold">GEDCOM Export</h4></a>
                <p>This page allows you to export all data from a particular tree to a standard 5.5 GEDCOM file. The file will be available for
                    download
                    in your
                    GEDCOM folder (as indicated in the Import Settings) and will be given the name of the tree's Tree ID plus ".ged".</p>

                <h5>Branch</h5>
                <p>Choose a branch from the list to include only people and families from this branch in the exported GEDCOM file.</p>

                <h5>Exclude Living/Exclude Private</h5>
                <p>Checking these boxes will completely exclude living or private individuals and families from the exported GEDCOM file.</p>

                <h5>Export media links</h5>
                <p>Check this option to include information pertaining to all photos, histories and other media linked to individuals, families,
                    sources and repositories in the selected tree. This information includes the media file name, description and notes.</p>

                <h5>Local paths for Photos/Documents/Headstones/Histories/Recordings/Videos</h5>
                <p>To prepend a common path to each media file name (ie, "C:\myphotos\" or "..\genealogy\"), check the "Export media links" box, then
                    enter that
                    path in the appropriate field (be sure to include a trailing slash). If these lines are left blank, only the file name and path
                    stored
                    in TNG for each media item
                    will be exported in the GEDCOM's "FILE" tag.
                </p>

                <h5>"Resume" Feature</h5>
                <p>If you do not see the "Finished" message, your data was not completely exported.
                    If you do not see any numbers, or if you see numbers but do not see a "Finished" message, your server may have killed your export
                    process for running too long.
                    If this happens to you, go to the Admin/Setup/Import Settings page
                    and check the box next to <strong>Save Import State</strong>. Then return here and try your export again. If the export fails to
                    run
                    to completion, you will now
                    be able to click a "resume" link at the top of the page to resume the export.</p>
            </td>
        </tr>

    </table>
    </body>
<?php echo "</html>"; ?>
<?php
include "../../helplib.php";
echo help_header("Help: Citations");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="https://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="https://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="notes_help.php" class="lightlink">&laquo; Help: Notes</a> &nbsp;|&nbsp;
                <a href="events_help.php" class="lightlink">Help: Events &raquo;</a>
            </p>
            <h2 class="largeheader">Help: <small>Citations</small></h2>
            <p class="smaller menu clear-both">
                <a href="#what" class="lightlink">What are they?</a> &nbsp;|&nbsp;
                <a href="#add" class="lightlink">Add/Edit/Delete</a>
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

            <a id="what"><h4 class="subheadbold">What are Citations?</h4></a>

            <p>A <strong>Citation</strong> is a reference to a Source record, made with the intent of proving the veracity of some piece of
                information. The Source usually
                describes in general where the information was found (e.g., a book or a census), while the Citation usually contains more specific
                information (e.g., on which page).
                The same Source record can be cited multiple times for different people, families, notes and events.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="add"><h4 class="subheadbold">Adding/Editing/Deleting Citations</h4></a>

            <p>To add, edit or delete citations, click on the Citations icon at the top of the screen or next to any note or event (if citations
                already exist,
                a green dot will be present on the icon). When the icon is clicked, a small popup will appear showing
                all citations existing for the active entity or event.</p>

            <p>To add a new citation, click on the "Add New" button and fill out the form. If the selected entity or event did not have any previous
                citations, you will be sent directly to the "Add New Citation" screen.</p>

            <p>To edit or delete an existing citation, click on the appropriate icon next to that citation.</p>

            <p>While adding or editing a citation, please take note of the following:</p>

            <h5>Source ID</h5>
            <p>Enter the ID of the source to be cited, or click the "Find" button to search for it. If the source has not yet been created, you
                can go to Admin/Sources to create the source in the proper tree, then return to the citations list, or you can click the "Create"
                button
                to enter the information for the new source. Once that information is saved, the new Source ID will be entered into this field.</p>
            <p>If you have already made at least one citation for the same type of entity (person, family, etc.) during your current session, you will
                also see a "Copy Last" button. Clicking that
                button will populate all the fields with the same values that you used in your last citation.</p>

            <!--<h5>Description</h5>
        <p>If your desktop genealogy program does not assign ID numbers to your sources, your citation will have a Description instead. You will not see
        the Description field for a new citation.</p>-->

            <h5>Page</h5>
            <p>Enter the page of the selected source relevant to this event (optional).</p>

            <h5>Reliability</h5>
            <p>Select a number (0-3) indicating how reliable the source is (optional). Higher numbers indicate greater reliability.</p>

            <h5>Citation Date</h5>
            <p>The date associated with this citation (optional).</p>

            <h5>Actual Text</h5>
            <p>An short excerpt of the source material (optional).</p>

            <h5>Notes</h5>
            <p>Any helpful comments you may have concerning this source (optional).</p>

        </td>
    </tr>

</table>
</body>
<?php echo "</html>"; ?>

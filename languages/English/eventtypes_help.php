<?php
include "../../helplib.php";
echo help_header("Help: Custom Event Types");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="https://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="https://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="branches_help.php" class="lightlink">&laquo; Help: Branches</a> &nbsp;|&nbsp;
                <a href="reports_help.php" class="lightlink">Help: Reports &raquo;</a>
            </p>
            <h2 class="largeheader">Help: <small>Custom Event Types</small></h2>
            <p class="smaller menu" style="clear: both;">
                <a href="#search" class="lightlink">Search</a> &nbsp;|&nbsp;
                <a href="#add" class="lightlink">Add or Edit</a> &nbsp;|&nbsp;
                <a href="#accept" class="lightlink">Accept vs. Ignore</a> &nbsp;|&nbsp;
                <a href="#delete" class="lightlink">Delete</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">
            <div id="google_translate_element" style="float:right;"></div>
            <script type="text/javascript">
                function googleTranslateElementInit() {
                    new google.translate.TranslateElement({
                        pageLanguage: 'en',
                        includedLanguages: '<?php echo INCLUDED_LANGUAGES; ?>',
                        layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL
                    }, 'google_translate_element');
                }

            </script>
            <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

            <a id="search"><h4 class="subheadbold">Search</h4></a>
            <p>Locate existing Custom Event Types by searching for all or part of the <strong>Tag, Type/Description (for EVEN events)</strong> or
                <strong>Display</strong>.
                Select an <strong>Associated with</strong> type or check one of the other options to further narrow your search.
                Searching with no options selected and no value in the search box will find all Custom Event Types in your database. Search options
                include:</p>

            <p><h5 class="optionhead">Associated with</h5>
            Choose an option from this dropdown box to limit the search to Custom Event Types associated with
            individuals, families, sources or repositories.</p>

            <p><h5 class="optionhead">Accept/Ignore/All</h5>
            Select one of these options to limit the search to Custom Event Types that are being <strong>accepted</strong> or those
            that are being <strong>ignored</strong>. Choosing <strong>All</strong> will not restrict the search results.</p>

            <p>Your search criteria for this page will be remembered until you click the <strong>Reset</strong> button, which restores all default
                values and searches again.</p>

            <p><h5 class="optionhead">Delete/Accept/Ignore/Collapse Selected</h5>
            Click the checkbox next to one or more event types, then use these buttons to perform the action on all selected event types at once.</p>

            <h5 class="optionhead">Actions</h5>
            <p>The Action buttons next to each search result allow you to edit or delete that result. To delete more than one record at a time, click
                the box in the
                <strong>Select</strong> column for each record to be deleted, then click the "Delete Selected" button at the top of the list. Use the
                <strong>Select All</strong> or <strong>Clear All</strong>
                buttons to toggle all select boxes at once.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Top</a></p>
            <a id="add"><h4 class="subheadbold">Adding or Editing Custom Event Types</h4></a>

            <p>The more common or "Standard" event types, such as Birth, Death, Marriage and a few others, are managed directly on the main People,
                Families, Sources and Repositories pages.
                All other events are associated with "Custom" event types
                and are managed in the <strong>Other Events</strong> sections of the People, Families, Sources and Repositories pages. Before you can
                enter one of these "other"
                events, you must have a record for the associated Custom Event Type. TNG automatically sets up Custom Event Types for all non-standard
                events included in
                your GEDCOM file, but you may also set up Custom Event Types by hand.</p>

            <p>To add a new Custom Event Type, click on the "Add New" tab, then fill out the form. To make changes to an existing Custom Event Type,
                use
                the <a href="#search">Search</a> tab to locate the record, then click on the Edit icon next to that line.
                When adding or editing a Custom Event Type, take note of the following:</p>

            <h5 class="optionhead">Associated with</h5>
            <p>Choose an option from this dropdown box to associate this custom event type with individuals, families, sources
                or repositories. A single custom event type may not be associated with more than one of these options. The
                choice made here will dictate what options show in the Tag dropdown box.</p>

            <h5 class="optionhead">Select Tag or enter</h5>
            <p>This is a 3 or 4 character abbreviation (all uppercase) or mnemonic code.
                Many common non-standard event types are listed in the Tag select box. If you do not see the desired tag here, enter it in the box
                directly beneath. If you select a tag from the list
                AND enter one in the box, the tag you entered in the box will be accepted and the tag selected from the list will be ignored.</p>

            <h5 class="optionhead">Type/Description</h5>
            <p>This should match the "Type" output by your PC/Mac genealogy program for this event type. NOTE: This field will only be displayed if
                you
                choose "EVEN" for your tag. For all other tags, this field should be left blank.</p>

            <h5 class="optionhead">Display</h5>
            <p>This will appear in the column to the left of the event data when it is displayed for public viewing. If you have set up multiple
                languages,
                you will see a section below this field titled "Other Languages". If you click on the plus sign, a separate
                Display box will be presented for each language supported. To have the same label display for every language,
                fill in the Display box above and leave the language-specific display boxes blank.</p>

            <h5 class="optionhead">Display Order</h5>
            <p>Events with associated dates are always sorted chronologically. Those events without dates are sorted within
                that list, in the order they appear in the database. The order of this sublist can be affected by assigning
                a Display Order here. A lower number will cause an event to be sorted higher.</p>

            <h5 class="optionhead">Event Data</h5>
            <p>To accept imported data corresponding to this custom event type, select <em>Accept</em>. To reject data corresponding to this type and
                cause it to not
                be imported, choose <em>Ignore</em>. Once an event of this type is imported, you may still elect not to
                display it by setting this option back to Ignore.</p>

            <h5 class="optionhead">Collapse Event</h5>
            <p>If the information for this event results in more than one row of data on the Individual page, all rows after the first will start off
                in the collapsed
                position. Visitors can expand the event and view the hidden information by clicking on the downward-facing triangle next to the event
                label.</p>

            <h5 class="optionhead">LDS Event</h5>
            <p>If this event type should be subject to the same privacy rules that govern other LDS events, choose "Yes" here.</p>

            <p><h5 class="optionhead">Required fields:</h5> You must select or enter a GEDCOM tag for your event. If you choose "EVEN" (generic
            custom event) for
            your Tag, you must also enter a Type/Description. If you do not choose EVEN as your Tag, you must leave the Type/Description field
            blank. You must also enter a Display
            string.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Top</a></p>
            <a id="accept"><h4 class="subheadbold">Accept Selected / Ignore Selected</h4></a>
            <p>To flag multiple custom event types as <strong>Accept</strong> or <strong>Ignore</strong> at the same time, check the Select box next
                to each Custom Event Type
                to be updated, then click either the "Accept Selected" or "Ignore Selected" button at the top of the page.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Top</a></p>
            <a id="delete"><h4 class="subheadbold">Deleting Custom Event Types</h4></a>
            <p>To delete one Custom Event Type, use the <a href="#search">Search</a> tab to locate the item, then click on the Delete icon next to
                that record. The row will
                change color and then vanish as the Custom Event Type is deleted. To delete more than one record at a time, check the box in the
                Select column next to each record to be
                deleted, then click the "Delete Selected" button at the top of the page.</p>

        </td>
    </tr>

</table>
</body>
</html>

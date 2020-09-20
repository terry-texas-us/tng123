<?php
include "../../helplib.php";
echo help_header("Help: Reports");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="https://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="https://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="eventtypes_help.php" class="lightlink">&laquo; Help: Custom Event Types</a> &nbsp;|&nbsp;
                <a href="dna_help.php" class="lightlink">Help: DNA Tests &raquo;</a>
            </p>
            <h2 class="largeheader">Help: <small>Reports</small></h2>
            <p class="smaller menu" style="clear: both;">
                <a href="#search" class="lightlink">Search</a> &nbsp;|&nbsp;
                <a href="#add" class="lightlink">Add or Edit</a> &nbsp;|&nbsp;
                <a href="#delete" class="lightlink">Delete</a> &nbsp;|&nbsp;
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
            <p>Locate existing cemeteries by searching for all or part of the <strong>Report Name</strong> or <strong>Description</strong>.
                Searching with no value in the search box will find all cemeteries in your database.</p>

            <p>Your search criteria for this page will be remembered until you click the <strong>Reset</strong> button, which restores all default
                values and searches again.</p>

            <h5 class="optionhead">Actions</h5>
            <p>The Action buttons next to each Report allow you to edit, delete or preview that Report. To delete more than one Report at a time,
                click the box in the
                <strong>Select</strong> column for each Report to be deleted, then click the "Delete Selected" button at the top of the list. Use the
                <strong>Select All</strong> or <strong>Clear All</strong>
                buttons to toggle all select boxes at once.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Top</a></p>
            <a id="add"><h4 class="subheadbold">Adding or Editing Reports</h4></a>

            <p>A TNG Report is a custom-built listing of people in your database. You decide which fields to display, which people to put in the
                report, and how to sort them.
                You can use the report builder interface, or you can include your own SQL query instead.</p>

            <p>To add a new Report, click on the "Add New" tab, then fill out the form. To make changes to an existing Report, use
                the <a href="#search">Search</a> tab to locate the record, then click on the Edit icon next to that line.
                When adding or editing a Report, take note of the following:</p>

            <h5 class="optionhead">Report Name</h5>
            <p>You must give your report a name. This will appear as the title when the report is displayed.</p>

            <h5 class="optionhead">Description</h5>
            <p>Give your report a short description. This will appear under the title when the report is displayed. It should explain briefly what the
                report shows using
                what criteria.</p>

            <h5 class="optionhead">Rank/Priority</h5>
            <p>Reports will normally sort alphabetically according to name, unless you give each one a ranking or priority. Lower numbers sort first.
                No rank sorts before any number.</p>

            <h5 class="optionhead">Active</h5>
            <p>Your new report will not be visible to regular site visitors until you indicate here that it is active. It's a good idea to save and
                test your report to make sure the
                output looks as you expected it before making active.</p>

            <h5 class="optionhead">Choose Fields to Display</h5>
            <p>Indicate which fields to display in your report by copying them from the lefthand box to the empty box on the right. You can do this by
                selecting a field and then clicking the <em>Add >></em> button, or by simply double-clicking on the field name (IE only). </p>

            <p>You can remove a field from the display list by selecting
                it in the righthand box and then clicking the <em><< Remove</em> button, or by simply double-clicking on the field name (IE only).
            </p>

            <p>Fields at the top of the display list are displayed at the left of the report when it is displayed. To
                change the order of the display fields, select a field in the righthand box and move it up or down within the list by clicking on the
                <em>Move Up</em> and <em>Move Down</em> buttons.</p>

            <h5 class="optionhead">Choose Criteria</h5>
            <p>Indicate which people to include in your report by choosing criteria. People who do not match the criteria will not be included in the
                report. Criteria statements are
                well-formed when they include a field name and a condition. For example, "Last Name = 'Lythgoe' " or "Birth Place contains 'England'
                ". Multiple criteria must be joined with an AND or an
                OR statement. Precedence is indicated by using parentheses.</p>

            <p>Begin any statement by choosing a field name from the upper lefthand box and adding it to the righthand box. You can do this by
                selecting a field and then clicking the adjacent <em>Add >></em> button, or by simply double-clicking on the field name (IE only).
            </p>

            <p><strong>NOTE</strong>: All date fields except Last Modified Date are treated as strings and not
                as true dates UNLESS they are labeled as 'True'. Comparing dates using text or string fields is best done by comparing date
                components,
                such as the year only or the day only. To isolate a date component in this manner, first select <em>Month Only From:</em>,
                <em>Day Only From:</em> or <em>Year Only From:</em>, and then select the date field from which the component will come.</p>

            <p>When working with a true date field (like Last Modified Date), you may compare the field directly to other true dates
                or true date fields. A predefined true date you may use is the Operator 'Today'. You may also use the operator 'Convert
                to Days' when relating two true dates. For example, find all records in which the Last Modified Date is less than 30 days old,
                you could choose for your criteria:<br><br>

                <i>Convert to Days<br>
                    Today (true date)<br>
                    -<br>
                    Convert to Days<br>
                    Last Modified Date<br>
                    <=<br>
                    30</i></p>

            <p>After choosing a field name, next choose a comparision operator from the <em>Operators &amp; Special Values</em> box. These include "=,
                !=, < > <=, >=, contains, starts with, ends with". Copy
                the operator to the righthand box by selecting it and then clicking the adjacent <em>Add >></em> button, or by simply double-clicking
                on the operator name (IE only).</p>

            <p>Finally, complete the statement by selecting a field or value to compare to your original field. You may also select one of the
                following Special Values: <em>Current Month, Current Year</em> or
                <em>Current Day</em>. To select a constant string value, enter the string without quotes in the <em>Constant String</em> field and
                click the adjacent <em>Add >></em> button.
                To add a blank string, leave the field blank before clicking the button. To select a constant numeric value, enter the number in the
                <em>Constant Value</em> field and click the adjacent
                <em>Add >></em> button.</p>

            <p>You can remove any item from the righthand box by selecting it and then clicking the <em><< Remove</em> button, or by simply
                double-clicking on the item (IE only).
                To change the order of the items in the list, select the item and move it up or down within the list by clicking on the <em>Move
                    Up</em>
                and <em>Move Down</em> buttons.</p>

            <h5 class="optionhead">Choose Sort Order</h5>
            <p>Indicate how the matching records should be sorted by choosing one or more fields to determine a sort order.
                If the first field in the list can not determine the order of any two matching records, the next field in the list will be used, and
                so forth. If no sort order is indicated, matching
                records will be displayed in the order they were added to the database.
                Select fields to be in the sort order by copying them from the lefthand box to the right. You can do this by selecting a field and
                then clicking the <em>Add >></em> button, or by simply double-clicking on the field name (IE only).</p>

            <p>By default, all fields sort in ascending order (i.e., A-Z or 0-9). To sort a field in descending order, use the pseudo-field
                'Descending (Prev)'.
                The 'Prev' in parentheses means that this designation must <i>follow</i> the field it modifies. In other words,
                if you want to sort by Last Name, choose this for your sort order:<br><br>

                <i>Last Name<br>
                    Descending (Prev)</i></p>

            <h5 class="optionhead">Miscellaneous</h5>
            <p>You can remove any field from the righthand box by selecting it and then clicking the <em><< Remove</em> button, or by simply
                double-clicking on the field name (IE only).
                To change the order of the fields in the list, select a field and move it up or down within the list by clicking on the <em>Move
                    Up</em> and <em>Move Down</em> buttons.</p>

            <h5 class="optionhead">Custom SQL Query</h5>
            <p>If you know structured query language (SQL) and you're familiar with TNG's table structure, you may leave the Display, Criteria and
                Sort areas blank and instead enter your direct
                SQL SELECT statement in the box at the bottom of the screen.</p>

            <h5 class="optionhead">Save Report vs. Save and Exit</h5>
            <p>When you're ready to save your report, click "Save Report" to save and stay on the same page and continue editing. Click "Save and
                Exit" to save and return to the Reports
                menu.</p>

            <p>To see some sample reports, please visit <a href="http://lythgoes.net/genealogy/demo.php" target="_blank">http://lythgoes.net/genealogy/demo.php</a>,
                choose the Administrative Demo, and browse the Reports section there.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Top</a></p>
            <a id="delete"><h4 class="subheadbold">Deleting Reports</h4></a>
            <p>To delete a Report, use the <a href="#search">Search</a> tab to locate the Report, then click on the Delete icon next to that Report
                record. The row will
                change color and then vanish as the Report is deleted.</p>

        </td>
    </tr>

</table>
</body>
<?php echo "</html>"; ?>

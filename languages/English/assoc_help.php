<?php
include "../../helplib.php";
echo help_header("Help: Associations");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="https://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="https://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="repositories_help.php" class="lightlink">&laquo; Help: Repositories</a> &nbsp;|&nbsp;
                <a href="notes_help.php" class="lightlink">Help: Notes &raquo;</a>
            </p>
            <h2 class="largeheader">Help: <small>Associations</small></h2>
            <p class="smaller menu" style="clear: both;">
                <a href="#what" class="lightlink">What are they?</a> &nbsp;|&nbsp;
                <a href="#add" class="lightlink">Add/Edit/Delete</a>
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

            <a id="what"><h4 class="subheadbold">What are Associations?</h4></a>

            <p>An <strong>Association</strong> is a record of a relationship between two people, between two families, or between a person and a
                family.
                The relationship may not be obvious from the regular tree structure of your genealogy. In fact, two people/families who
                are linked in an Association may not be related at all.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <a id="add"><h4 class="subheadbold">Adding/Editing/Deleting Associations</h4></a>

            <p>To add, edit or delete associations for an individual, look up person in Admin/People and edit
                the individual record, then click on the Associations icon at the top of the screen (if associations already exist,
                a green dot will be present on the icon). When the icon is clicked, a small popup will appear showing
                all associations existing for the active individual. To do the same for family associations, look up the family in Admin/Families
                and edit the family record, then proceed as outlined above.</p>

            <p>To add a new association, click on the "Add New" button and fill out the form. If the selected person or family did not have any
                previous
                associations, you will be sent directly to the "Add New Association" screen. Once you're on that screen, you will be able to indicate
                whether the associated entity is a person or family.</p>

            <p>To edit or delete an existing association, click on the appropriate icon next to that association.</p>

            <p>While adding or editing an association, take note of the following:</p>

            <h5 class="optionhead">Person ID or Family ID</h5>
            <p>Enter the ID of the person or family to be associated with the active person or family, or click the Find icon to search for the
                ID.</p>

            <h5 class="optionhead">Relationship</h5>
            <p>Enter the nature of the association. For example, <em>Godfather</em>, <em>Mentor</em> or <em>Witness</em>.</p>

            <h5 class="optionhead">Reverse Association?</h5>
            <p>Sometimes an association goes both ways. For example, an association relationship of <em>Friend</em> could apply in both directions. If
                that
                is true and you want to create a second association going in the reverse direction, then check this box. If the relationship doesn't
                seem to
                apply when the association is reversed (e.g., <em>Godfather</em> or <em>Mentor</em>), then you should create a different association,
                starting
                from the other person or family, to show the reverse relationship.</p>

            <p>When you are done adding, editing or deleting associations for this person or family, click the "Finish" button to close the
                window.</p>

        </td>
    </tr>

</table>
</body>
<?php echo "</html>"; ?>

<?php
include "../../helplib.php";
echo help_header("Help: Languages");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="https://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="https://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="dna_help.php" class="lightlink">&laquo; Help: DNA Tests</a> &nbsp;|&nbsp;
                <a href="backuprestore_help.php" class="lightlink">Help: Utilities &raquo;</a>
            </p>
            <h2 class="largeheader">Help: <small>Languages</small></h2>
            <p class="smaller menu" style="clear: both;">
                <a href="#search" class="lightlink">Search</a> &nbsp;|&nbsp;
                <a href="#add" class="lightlink">Add or Edit</a> &nbsp;|&nbsp;
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
            <p>Locate existing Languages by searching for all or part of the <strong>Display Name</strong> or <strong>Folder Name</strong>.
                Searching with no value in the search box will find all Languages in your database.</p>

            <p>Your search criteria for this page will be remembered until you click the <strong>Reset</strong> button, which restores all default
                values and searches again.</p>

            <h5 class="optionhead">Actions</h5>
            <p>The Action buttons next to each language allow you to edit or delete that language.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Top</a></p>
            <a id="add"><h4 class="subheadbold">Add New / Edit Existing Languages</h4></a>
            <p>The TNG display messages have been translated into several different languages. To allow visitors to your site to view the site in any
                language besides
                your default language, you must add a record here for each language you support, <strong>including</strong> your default language. For
                example,
                if your default language is English and you want to support French as well, you must add language records in Admin/Languages for both
                English and French.</p>

            <p>To add a new Language, click on the <strong>Add New</strong> tab, then fill out the form.
                Take note of the following:</p>

            <h5 class="optionhead">Language folder</h5>
            <p>Use the dropdown to choose the location of the messages for this language. If your new language needs the UTF-8 character set, be sure
                to choose a folder with "UTF8" in the name.
                If you want to support a new language not previously supported by TNG, add a folder for that language within the TNG languages folder,
                then return to this page to select it.</p>

            <h5 class="optionhead">Name for this language as it will be displayed for visitors</h5>
            <p>Enter the name of the language as it will be shown to visitors in the languages options box. It is recommended that you enter this name
                in the language it
                represents so that visitors can more easily identify it. For example, use "Norsk" instead of "Norwegian".</p>

            <h5 class="optionhead">Character set</h5>
            <p>The character set used for this language. If left blank, ISO-8859-1 will be used.</p>

            <h5 class="optionhead">Turn off relationship messages</h5>
            <p>This will hide the written relationship explanation at the bottom of the Relationship Chart. This might be useful if the wording of the
                explanation doesn't always make sense in this language.</p>

            <h5 class="optionhead">Required fields:</h5> You must enter a language display name, and you must choose the name of the language
            folder.</p>

            <p><strong>IMPORTANT:</strong> If you plan to allow dynamic language switching, <strong>you must set up your default language</strong>
                (from Setup/General Settings) as a language on this page.
                If you do not, you will not be able to switch back to your default language after switching to another one.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right;"><a href="#top">Top</a></p>
            <a id="delete"><h4 class="subheadbold">Deleting Languages</h4></a>
            <p>To delete a Language, use the <a href="#search">Search</a> tab to locate the Language, then click on the Delete icon next to that
                Language record. The row will
                change color and then vanish as the Language is deleted. <strong>Note</strong>: The associated folder on your site will not be
                deleted.</p>

        </td>
    </tr>

</table>
</body>
</html>

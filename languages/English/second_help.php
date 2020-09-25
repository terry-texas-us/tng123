<?php
include "../../helplib.php";
echo help_header("Help: Secondary Processes");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="https://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="https://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="data_help.php" class="lightlink">&laquo; Help: Import / Export</a> &nbsp;|&nbsp;
                <a href="setup_help.php" class="lightlink">Help: Setup &raquo;</a>
            </p>
            <h2 class="largeheader">Help: <small>Secondary Processes</small></h2>
            <p class="smaller menu" style="clear: both;">
                <a href="#what" class="lightlink">What are they?</a>
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

            <a id="what"><h4 class="subheadbold">What are Secondary Processes?</h4></a>
            <p>Secondary Processes are operations you may want to perform on your data directly following an import. To perform one of these
                operations,
                you must first select whether it should apply to "All Trees" or
                only one tree in particular. If only one tree, select that tree here. Operations you can perform include:</p>

            <h5 class="optionhead">Track Lines</h5>
            <p>Once you have imported your data, click here to trace through the selected tree and mark all individuals with children. This will allow
                visitors
                to your site to more easily find your primary lines of descent.</p>

            <h5 class="optionhead">Sort Children</h5>
            <p>Sort the children in each family of the selected tree according to birth date. This will supersede any previous sorting done in
                other parts of TNG or in your desktop application.</p>

            <h5 class="optionhead">Sort Spouses</h5>
            <p>Sort spouses for each person of the selected tree according to marriage date. This will supersede any previous sorting done in
                other parts of TNG or in your desktop application.</p>

            <h5 class="optionhead">Relabel Branches</h5>
            <p>Re-importing your GEDCOM with the <span class="emphasis">Replace All Data</span> option will cause any previously existing branch
                labels to be
                removed. Click this button to restore those labels (IDs must match those from your previous data).</p>

            <h5 class="optionhead">Create GENDEX</h5>
            <p>Create an indexable file in GENDEX format. You determine the folder name (where the file will be stored) in the General Settings.
                If you selected "All Trees", this file will be named "gendex.txt". If you selected a tree, the name of your GENDEX file will be the
                TreeID (not the Tree Name),
                plus .txt for an extension. To have the file indexed by GENDEX, visit
                <a href="http://www.gendexnetwork.org">GenDex Network</a> or <a href="http://www.familytreeseeker.com">FamilyTreeSeeker.com</a> for
                further instructions.</p>

            <h5 class="optionhead">Post your GENDEX file on the TNG Network</h5>
            <p>To have the file indexed by GENDEX, visit <a href="http://www.gendexnetwork.org">GenDex Network</a> or <a
                    href="http://www.familytreeseeker.com">FamilyTreeSeeker.com</a>.
                You will be asked to create an account, after which you will be able to import your GENDEX file. Any time you want to update your
                listings on the TNG Network,
                you will need to recreate and re-import your GENDEX file.</p>

            <h5 class="optionhead">Trim Media Menus</h5>
            <p>TNG includes menu options for several standard media collections (Photos, Documents, Histories, Headstones, Videos and Recordings). If
                you don't have any items
                for one or more of those collections, you can remove them from the menus by clicking this option. If you add an item for any of the
                "trimmed" collections in
                the future, it will automatically be added back for you.</p>

            <h5 class="optionhead">Refresh Living</h5>
            <p>Find all individuals who have no death date and who were born recently enough to still be alive, then mark them as "Living". The exact
                number of years is dictated by
                the option on the Import Settings page labeled "If no death date, assume deceased if older than". Also mark any families as Living
                where
                these individuals are listed as a spouse. Conversely, this utility will also find all individuals
                who have a death or burial date, or who were not born within that timeframe, and mark them as deceased.</p>

            <h5 class="optionhead">Make Private</h5>
            <p>Find all individuals who died in the recent past and mark them as "Private". The exact number of years comes from the "Assume private
                if not dead this many years"
                option on the Import Settings page. Also mark any families as Private where these individuals are listed as a spouse.
                Unlike the Refresh Living utility, this will not remove the Private designation from any individual.</p>
        </td>
    </tr>
</table>
</body>
<?php echo "</html>"; ?>

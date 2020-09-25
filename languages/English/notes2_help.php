<?php
include "../../helplib.php";
echo help_header("Help: Notes");
?>

    <body class="helpbody">
    <a id="top"></a>
    <table class="tblback normal">
        <tr class="fieldnameback">
            <td class="tngshadow">
                <p style="float:right; text-align:right;" class="smaller menu">
                    <a href="https://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                    <a href="https://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                    <a href="tlevents_help.php" class="lightlink">&laquo; Help: Timeline Events</a> &nbsp;|&nbsp;
                    <a href="misc_help.php" class="lightlink">Help: Miscellaneous &raquo;</a>
                </p>
                <h2 class="largeheader">Help: <small>Notes</small></h2>
                <p class="smaller menu" style="clear: both;">
                    <a href="#notes" class="lightlink">Notes</a>
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

                <a id="notes"><h4 class="subheadbold">Notes</h4></a>
                <p>From the <strong>Notes</strong> page, you can search for notes directly based on their content. You don't have to know who or
                    what the notes linked to. Once you've found the note you searched for, you can click on the Edit icon next to that
                    row to edit the note's content. You can also delete the note outright by clicking on the Delete icon next to that row.
                    You may not change who or what the note is linked to from this screen. To do that, you must look up the individual,
                    family or other entity that the note is linked to and do it from there. The IDs of those entities are displayed on
                    the right side of each note row.</p>

            </td>
        </tr>

    </table>
    </body>
<?php echo "</html>"; ?>
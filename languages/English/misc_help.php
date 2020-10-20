<?php
include "../../helplib.php";
echo help_header("Help: Miscellaneous");
?>

    <body class="helpbody">
    <a id="top"></a>
    <table class="tblback normal">
        <tr class="fieldnameback">
            <td class="tngshadow">
                <p style="float:right; text-align:right;" class="smaller menu">
                    <a href="https://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                    <a href="https://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                    <a href="notes2_help.php" class="lightlink">&laquo; Help: Notes</a> &nbsp;|&nbsp;
                    <a href="mostwanted_help.php" class="lightlink">Help: Most Wanted &raquo;</a>
                </p>
                <h2 class="largeheader">Help: <small>Miscellaneous</small></h2>
                <p class="smaller menu clear-both">
                    <a href="#whatsnew" class="lightlink">What's New</a> &nbsp;|&nbsp;
                    <a href="#mostwanted" class="lightlink">Most Wanted</a> &nbsp;|&nbsp;
                    <a href="#validation" class="lightlink">Data Validation</a>
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

                <a id="whatsnew"><h4 class="subheadbold">What's New</h4></a>
                <p>Any text entered on this tab will be displayed at the top of the <strong>What's New</strong> page in the public area.
                    Use this feature if you would like to provide your visitors with a general site update or other timely information. Click on the
                    <strong>Test</strong> link to display the
                    What's New page with your message at the top.</p>

            </td>
        </tr>
        <tr class="databack">
            <td class="tngshadow">

                <p style="float:right;"><a href="#top">Top</a></p>
                <a id="mostwanted"><h4 class="subheadbold">Most Wanted</h4></a>
                <p>The Most Wanted tab allows you to add elusive people and mystery photos to a <strong>Most Wanted</strong> page on your site, in
                    hopes
                    of getting more publicity for the
                    things that are giving you the most trouble. See the <a href="mostwanted_help.php">Help: Most Wanted</a> link for more information
                    on
                    how to build your Most Wanted page.</p>

            </td>
        </tr>
        <tr class="databack">
            <td class="tngshadow">

                <p style="float:right;"><a href="#top">Top</a></p>
                <a id="validation"><h4 class="subheadbold">Data Validation</h4></a>
                <p>Here's where you can run a number of preconfigured reports to help you find possible problems in your information. Running each
                    report
                    will examine your database in real time
                    and return a listing of people who might need some attention. You'll then be able to click through to those records and take a
                    closer
                    look.</p>

            </td>
        </tr>

    </table>
    </body>
<?php echo "</html>"; ?>
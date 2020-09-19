<?php
include "../../helplib.php";
echo help_header("Help: Log Settings");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="https://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="https://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="pedconfig_help.php" class="lightlink">&laquo; Help: Chart Settings</a> &nbsp;|&nbsp;
                <a href="importconfig_help.php" class="lightlink">Help: Import Settings &raquo;</a>
            </p>
            <h2 class="largeheader">Help: <small>Log Settings</small></h2>
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

            <h5 class="optionhead">Log File Name</h5>
            <p>The Log File Name is the file where visitor actions are recorded. You shouldn't have to change this from "genlog.txt".</p>

            <h5 class="optionhead">Max Log Lines</h5>
            <p>Max Log Lines indicates how many actions should be
                retained at any one time. If this number gets too high, you may experience a performance hit.</p>

            <h5 class="optionhead">Exclude Host Names</h5>
            <p>Before making any log entry, TNG will check this list. If the host of the visitor responsible for the potential log entry
                is on the list, no log entry will be made. Host names should be separated by commas (no spaces) and can consist of entire
                host names, IP addresses, or portions of either. For example, "googlebot" will block "crawler4.googlebot.com".</p>

            <h5 class="optionhead">Exclude User Names</h5>
            <p>Before making any log entry, TNG will check this list as well. If the logged-in user
                is on the list, no log entry will be made. User names should be separated by commas (no spaces).</p>

            <h5 class="optionhead">Log File Name (Admin)</h5>
            <p>The log file where actions in the Admin area are recorded. You shouldn't have to change this from "genlog.txt".</p>

            <h5 class="optionhead">Max Log Lines (Admin)</h5>
            <p>Indicates how many actions should be retained at any one time in the Admin log file. If this number gets too high, you may experience a
                performance hit.</p>

            <h5 class="optionhead">Block Suggestions or New User Registrations</h5></p>

            <h5 class="optionhead">Address contains</h5>
            <p>Block any incoming suggestion or new user registration where the e-mail address of the sender contains any of the entered words or word
                segments.
                Separate multiple words with commas.</p>

            <h5 class="optionhead">Message contains</h5>
            <p>Block any incoming suggestion or new user registration where the message body contains any of the entered words or word segments.
                Separate multiple words with commas.</p>
        </td>
    </tr>

</table>
</body>
</html>

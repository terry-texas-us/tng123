<?php
include "../../helplib.php";
echo help_header("Help: More");
?>

<body class="helpbody">
<a id="top"></a>
<table class="tblback normal">
    <tr class="fieldnameback">
        <td class="tngshadow">
            <p style="float:right; text-align:right;" class="smaller menu">
                <a href="https://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                <a href="https://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                <a href="events_help.php" class="lightlink">&laquo; Help: Events</a> &nbsp;|&nbsp;
                <a href="media_help.php" class="lightlink">Help: Media &raquo;</a>
            </p>
            <h2 class="largeheader">Help: <small>More</small></h2>
            <p class="smaller menu" style="clear: both;">
                <a href="#more" class="lightlink">More Information</a>
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

            <a id="more"><h4 class="subheadbold">More Information</h4></a>
            <p>This screen allows you to enter additional information related to TNG's standard event types. When one or more of these fields are
                filled in,
                the More icon (plus sign) will have a green dot in the corner. Fields on the More Information screen include:</p>

            <p><h5>Age</h5>: The age of the individual at the time of the event.</p>

            <p><h5>Agency</h5>: The institution or individual having authority and/or responsibility at the time of the event.
            </p>

            <p><h5>Cause</h5>: The cause of the event (most often used with Death).</p>

            <p><h5>Address 1/Address 2/City/State/Province/Zip/Postal Code/Country/Phone/E-mail/Web Site</h5>: The address and
            other contact information
            associated with the event.</p>

            <p><h5>Required fields:</h5>
            None of the information here is required.</p>
        </td>
    </tr>

</table>
</body>
<?php echo "</html>"; ?>

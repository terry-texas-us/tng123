<?php
include "../../helplib.php";
echo help_header("Help: Template Settings");
?>

    <body class="helpbody">
    <a id="top"></a>
    <table class="tblback normal">
        <tr class="fieldnameback">
            <td class="tngshadow">
                <p style="float:right; text-align:right;" class="smaller menu">
                    <a href="http://tngforum.us" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                    <a href="https://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                    <a href="mapconfig_help.php" class="lightlink">&laquo; Help: Map Settings</a> &nbsp;|&nbsp;
                    <a href="users_help.php" class="lightlink">Help: Users &raquo;</a>
                </p>
                <h2 class="largeheader">Help: <small>Template Settings</small></h2>
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

                <p><h5>Using a Template</h5>TNG templates allow you to quickly give your site a professional look and feel. To use
                a template, first set
                "Enable Template Selection" to <strong>Yes</strong>, then choose the number of the template you want (see the choices at
                <a href="http://lythgoes.net/genealogy/templates.php">http://lythgoes.net/genealogy/templates.php</a>). Once the changes are saved,
                the
                new template style will take effect.</p>
                <p>To maintain an existing site setup (from a version prior to 8.1.0), leave <strong>Enable Template Selection</strong> set to
                    <b>No</b>.
                </p>
                <p><h5>Customizing</h5>You may certainly customize your site beyond what the template files allow. Your default
                home page is index.php, and your
                default header and footer are topmenu.php and footer.php. Files with those names are located within each template folder. The
                template-specific "style" (colors, fonts and other
                formatting) is defined in templatestyle.css (within the "css" subfolder for each template), but if you want to change anything, it is
                best
                to make the changes in
                mytngstyle.css (also within the "css" subfolder for each template), so that your changes will not be overwritten in a future
                upgrade.</p>
                <p><h5>Supporting Multiple Languages</h5>If you want any of the the messages in your Template Settings to be
                available in
                another language, choose that language from the dropdown box beneath the corresponding message, then click the adjacent "Go" button.
                You
                will be
                given a new field where you can enter the translation for that message. Once you click "Save" at the bottom of the page, that message
                will
                become a
                permanent part of your Template Settings page.</p>
                <p><h5>Simple Changes</h5>Changes can be made by directly editing the files mentioned in the previous paragraph,
                but some simple changes can be made just by
                editing the Template Settings. Choose a template by number and you will be shown some of the key elements of the page. Changing
                those settings will automatically update your site, assuming that you have not
                customized the pages by hand already. You may make whatever manual changes you want, but if you remove any of the PHP
                code, these settings may no longer have any effect.</p>
                <p><h5>Images</h5>If you would like to change an image, the easiest way click the "Change" button next to the field
                containing
                that image name. You will then be shown a new field that will let you browse for that image on your computer. When the new image is
                uploaded, it
                will take on the name shown in the original image field. If you want to change that name, then enter the new name in that field.
                For best quality, make your new image has the same dimensions as the existing image. You can find the dimensions
                by right-clicking on the image as you view it in your browser (use the "Preview" button) and selecting "Properties" or "View Image
                Info".
                If you must
                change the image dimensions, you will want to manually update them as they appear in the HTML.</p>

                <p>To upload the image and finalize the change (and all other changes), click "Save" at the bottom of the page. If this process
                    doesn't
                    work, you may have inadequate
                    permissions on your template folders. Make sure the permissions are set to 755 or 777. If you still can't make it work this way,
                    you
                    can use an FTP
                    program or online file manager to upload the new image directly to the "img" subfolder of the template folder you're using.</p>
                <p><h5>Feature and Resource Links</h5>If your selected template includes either of these options, you can create
                links in those
                sections by listing the link label and the link URL on the same line, separated by a comma. For example, <em>TNG,
                    http://www.tngsitebuilding.com</em>.</p>
                <p><h5>Changing Your Mind</h5>You may choose options for multiple templates, but only one will be in use at any
                time. If you decide later that you want
                a different template, just choose a new template number at the top of the Template Settings page. Setting changes you may have made
                for
                your original template will
                still be there if you decide to go back.</p>
            </td>
        </tr>

    </table>
    </body>
<?php echo "</html>"; ?>
<?php
include "../../helplib.php";
echo help_header("Help: General Settings");
?>

    <body class="helpbody">
    <a id="top"></a>
    <table class="tblback normal">
        <tr class="fieldnameback">
            <td class="tngshadow">
                <p style="float:right; text-align:right;" class="smaller menu">
                    <a href="https://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                    <a href="https://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                    <a href="setup_help.php" class="lightlink">&laquo; Help: Setup</a> &nbsp;|&nbsp;
                    <a href="pedconfig_help.php" class="lightlink">Help: Chart Settings &raquo;</a>
                </p>
                <h2 class="largeheader">Help: <small>General Settings</small></h2>
                <p class="smaller menu clear-both">
                    <a href="#data" class="lightlink">Database</a> &nbsp;|&nbsp;
                    <a href="#table" class="lightlink">Tables</a> &nbsp;|&nbsp;
                    <a href="#path" class="lightlink">Paths+Folders</a> &nbsp;|&nbsp;
                    <a href="#site" class="lightlink">Site</a> &nbsp;|&nbsp;
                    <a href="#media" class="lightlink">Media</a> &nbsp;|&nbsp;
                    <a href="#lang" class="lightlink">Language</a> &nbsp;|&nbsp;
                    <a href="#priv" class="lightlink">Privacy</a> &nbsp;|&nbsp;
                    <a href="#name" class="lightlink">Names</a> &nbsp;|&nbsp;
                    <a href="#cem" class="lightlink">Cemeteries</a> &nbsp;|&nbsp;
                    <a href="#mail" class="lightlink">Mail</a> &nbsp;|&nbsp;
                    <a href="#mobile" class="lightlink">Mobile</a> &nbsp;|&nbsp;
                    <a href="#pref" class="lightlink">Prefixes</a> &nbsp;|&nbsp;
                    <a href="#misc" class="lightlink">Misc</a>
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

                <a id="data"><h4 class="subheadbold">Database</h4></a>

                <h5>Database Host, Name, User Name, Password</h5>
                <p>This is the information TNG and PHP will use to connect to your database. These fields must be filled in before your database
                    can be accessed. <strong>Note</strong>: The user name and password mentioned here may be different from
                    your regular web site login. If, after entering this information, you continue to see an error message that TNG is not
                    communicating
                    with your database, then you know at least one of these values is incorrect. If you don't know the correct information, ask your
                    web
                    hosting provider. The host name may also require a port number or a socket path (i.e., "localhost:3306" or
                    "localhost:/path/to/socket").
                    Case is important, so be mindful to type in everything exactly as it was given
                    to you. If you are acting as your own webmaster, be sure you have created a database
                    and added a user to it (the user must have ALL rights).</p>

                <h5>Maintenance Mode</h5>
                <p>When TNG is in Maintenance Mode, the data cannot be accessed from the public side of your site. Instead, visitors will see a
                    polite message telling them that you are performing maintenance on the site and they should try again later. You might wish to
                    put your site in Maintenance Mode while you are re-importing your data. If you are resequencing your IDs, Maintenance Mode is
                    required. If you ever find yourself "stuck" in Maintenance Mode, you can edit your config.php file directly and reset the
                    $tngconfig['maint'] variable
                    to 0 or blank.</p>

            </td>
        </tr>
        <tr class="databack">
            <td class="tngshadow">

                <p style="float:right;"><a href="#top">Top</a></p>
                <a id="table"><h4 class="subheadbold">Table Names</h4></a>

                <h5>Table Names</h5>
                <p>You shouldn't have to change any of the default names unless you already have one or more tables with one or more of these
                    names. Always make sure all table names are filled in and that all names are unique. Do not change any existing table names.</p>

            </td>
        </tr>
        <tr class="databack">
            <td class="tngshadow">

                <p style="float:right;"><a href="#top">Top</a></p>
                <a id="path"><h4 class="subheadbold">Paths and Folders</h4></a>

                <h5>Root Path</h5>
                <p>This is the system path to the folder or directory where your TNG files are located. It is not a web address.
                    You must include a trailing slash. When you first open this page, your Root Path should be correct. Do not change it unless you
                    are an
                    advanced user
                    or have been instructed to do so. If you blank out the field and save the page, the correct path will appear here the next time
                    you
                    load the page, but you
                    will need to save the page again to keep the new path.</p>

                <h5>Config Path</h5>
                <p>If you would like to put your TNG configuration files in a more secure location outside of the "web root" directory (so they aren't
                    accessible from the web), enter that path here. It <strong>must</strong> end with a trailing slash (/). It will likely be the
                    first
                    part of the Root Path.
                    For example, if your Root Path is "/home/www/username/public_html/genealogy/", then you might choose "/home/www/username/" as your
                    Config Path.</p>

                <h5>Photo / Document / History / Headstone / Multimedia / GENDEX / Backup / Mods / Extensions Folders</h5>
                <p>Please enter folder or directory names for these respective entities. All should have global read+write+execute permissions (755 or
                    775, although some systems will require 777).
                    The Multimedia folder is intended as a "catch all" for any media items that don't fit cleanly into the other categories (e.g.,
                    videos
                    and
                    audio recordings). These folders can be created from this screen by clicking on the "Make Folder" buttons.</p>

            </td>
        </tr>
        <tr class="databack">
            <td class="tngshadow">

                <p style="float:right;"><a href="#top">Top</a></p>
                <a id="site"><h4 class="subheadbold">Site Design and Definition</h4></a>

                <h5>Home Page</h5>
                <p>All TNG menus include a link to the "Home Page". Enter the address for this link here. By default this is the index.php page in the
                    folder with your other
                    TNG files. It must be a relative link ("index.php" or "../otherhomepage.html"), not an absolute link ("http://yoursite.com").</p>

                <h5>Genealogy URL</h5>
                <p>The web address for your genealogy folder (i.e., "http://mysite.com/genealogy").</p>

                <h5>Site Name</h5>
                <p>If you enter something here, it will be included in the HTML "Title" tag on every page and will show up at the top of your
                    browser window.</p>

                <h5>Site Description</h5>
                <p>A short description of your site for use on the RSS feed page.</p>

                <h5>Doctype Declaration</h5>
                <p>This string is placed at the top of every page in the public area to give the user's browser the information it needs
                    to render the page correctly. Validation tests run against the pages will use this information to determine what problems
                    may exist. If you leave this blank, the default XHTML Transitional doctype will be used.</p>

                <h5>Site Owner</h5>
                <p>Your name, or your business name. This name will appear on outgoing e-mail messages originating from TNG.</p>

                <h5>Target Frame</h5>
                <p>If your site uses frames, use this field to indicate in which frame the TNG pages should display. If you are not using frames,
                    leave this as "_self".</p>

                <h5>Topmenu / Footer</h5>
                <p>File names for the page fragments to be used as your TNG page header and footer.
                    To use PHP coding in these files, they must have .php extensions. To make use of TNG's design templates, you must keep these the
                    header and footer named topmenu.php and footer.php respectively.</p>

                <h5>Menu Location</h5>
                <p>The TNG menu may be located on the top left of every page, just above the individual's name or other page heading, or on the top
                    right
                    of every page, directly across from
                    the name or other page heading. The dynamic language selection dropdown will be located in the same section of the screen.</p>

                <h5>Show Home / Search / Login/Logout / Share / Print / Add Bookmark Links</h5>
                <p>Some of these options (Home/Search/Login) are located at the top left of every page, just under the page heading and above the row
                    of
                    tabs. The others
                    (Share/Print/Add Bookmark) are located at the top right, just under the menu bar.
                    Each of these options can be turned on or off using these controls.</p>

                <h5>Search Link Destination</h5>
                <p>The default behavior of the Search link at the top of every page is to open a small window where you can search by entering a name
                    or
                    ID. This is called "Quick Search".
                    You may choose instead to have this link go to the Advanced Search page by choosing that option.</p>

                <h5>Hide Christening Labels</h5>
                <p>This option allows you to hide all mention of the "Christening" event.</p>

                <h5>Hide all DNA pages and data</h5>
                <p>If you're not going to use any of the DNA-related features and would like it removed from all public pages, set this option to Yes.
                    DNA
                    Tests will no longer be accessible from the public menus,
                    nor will they be seen on any person's individual page.</p>

                <h5>Default Tree</h5>
                <p>When more than one tree exists, all pages where a selection is possible (including the search utility
                    on your home page) will default to "All Trees". If you instead want to point this to one tree in particular,
                    select that tree here. Whenever a user enters a URL without a tree ID (or with a blank tree ID), the request
                    will be rerouted to this tree. <strong>NOTE</strong>: If you have only one tree, it is better to leave this field blank.</p>

            </td>
        </tr>
        <tr class="databack">
            <td class="tngshadow">

                <p style="float:right;"><a href="#top">Top</a></p>
                <a id="media"><h4 class="subheadbold">Media</h4></a>

                <h5>Photos Extension</h5>
                <p>The file extension assigned to all small pedigree-style photos. Other photos need not have this extension. The .jpg extension is
                    recommended for most photos.</p>

                <h5>Show Extended Photo Info</h5>
                <p>If this option is checked, any available extended information will be displayed for each photo. This includes the physical file
                    name,
                    the dimensions in pixels, and any
                    existing IPTC data.</p>

                <h5>Image Max Height and Width</h5>
                <p>When these values are set (pixels), images larger than these dimensions will be scaled down (using HTML) when displayed in the
                    public
                    area.</p>

                <h5>Thumbnails Prefix</h5>
                <p>When generating thumbnails automatically, TNG will prepend this value to the original image file name to create the thumbnail file
                    name. If the file name of the original includes path
                    information, the prefix will be included directly before the file name. This prefix can include a folder name (ie, "thumbnails/").
                    If
                    you
                    will be using a folder name as part of the prefix, be sure that this folder exists and has the same permissions as the main Photos
                    folder.</p>

                <h5>Thumbnails Suffix</h5>
                <p>When generating thumbnails automatically, TNG will append this value to the original image file name to create the thumbnail file
                    name.</p>

                <h5>Thumbnail Max Height</h5>
                <p>When TNG automatically creates a thumbnail image, the image will be no taller than this (pixels).</p>

                <h5>Thumbnail Max Width</h5>
                <p>When TNG automatically creates a thumbnail image, the image will be no wider than this (pixels).</p>

                <h5>Use default thumbnails</h5>
                <p>If a person does not have a default photo and this option is enabled, a generic, gender-specific thumbnail will be used instead on
                    all
                    pages that reference
                    this person.</p>

                <h5>Columns in Thumbnail View</h5>
                <p>When browsing all photos in thumbnail view, this many thumbnails will be displayed in a single row. If more
                    exist, additional rows will be displayed up to the "Maximum Search Result" number of rows.</p>

                <h5>Max characters in list notes</h5>
                <p>If you want notes to be truncated when they are shown on list pages (like on the public Photos, Documents and Histories pages), set
                    this to the maximum
                    number of characters that should be displayed. Leave it blank to always show the entire note.</p>

                <h5>Enable Slide Show</h5>
                <p>Allows a set of photos to be shown automatically in succession from the public area when the "Start Slideshow" link is clicked.
                    Setting
                    this option to 'No' hides the link and disables the feature.</p>

                <h5>Slide Show Auto Repeat</h5>
                <p>Setting this option to 'Yes' allows the slide show to run continuously.</p>

                <h5>Enable Image Viewer</h5>
                <p>Setting this option to 'Always' shows every image-based media item (.jpg, .gif and .png files) in the image viewer. Setting it to
                    'Documents only' turns the
                    image viewer off for all image-based media that are not 'Documents' or other media types that behave like Documents.</p>

                <h5>Image Viewer Height</h5>
                <p>Setting this option to 'Always show full image' will ensure that the entire image is viewable by default. Setting it to 'Fixed
                    (640px)'
                    causes images taller than
                    640 pixels to be cropped at that height when the image is initially displayed. The viewer controls may still be used to pan around
                    the
                    image or to zoom in or out.</p>

                <h5>Hide Personal Media</h5>
                <p>If this option is set to "Yes", then media listings on a person's individual page will start in a collapsed state. Instead of
                    seeing
                    thumbnails and descriptions,
                    you will see only a total count for each media type. Visitors will still be able to expand each media section, but they will be
                    collapsed again if the page is refreshed.</p>

                <h5>Remove physical file on delete</h5>
                <p>This option dictates what happens when an individual media record is deleted. If this option is set to "Yes", the associated
                    physical
                    file will also be deleted.
                    If the option is set to "No", only the database record will be removed, leaving the physical file intact. If the option is set to
                    "On
                    request", you will be prompted to
                    indicate whether the associated file should be deleted or not.</p>

                <h5>Show photos on one row</h5>
                <p>This pertains to thumbnails shown on a person's individual page. When more than one thumbnail is present in any area, this option
                    can
                    be used to display all of the
                    thumbnails horizontally in a single row (images will wrap if there are too many for them all to be shown on one row) or in a list,
                    as
                    they always were prior to TNG v12.
                    When the thumbnails are displayed horizontally, no captions will be displayed. Media that do not have a thumbnail will still be
                    listed
                    vertically.</p>

                <h5>Separate media in tree folders</h5>
                <p>By default, all physical media in each collection (ie, Photos, Documents, Histories, etc) are stored in the same physical folder.
                    Enabling this option will cause TNG
                    to store media in subfolders of their respective collection folders according to their associated tree IDs (if there is no tree
                    association, the file will remain in the
                    main collection folder). Click the "Convert" button to move affected media into of out of this new folder structure. If the
                    destination tree folders don't exist, they will
                    be created.</p>

                <h5>Favicon</h5>
                <p>A "favicon" is a small icon displayed in the browser's address bar, just to the left of the site URL. TNG does not include a
                    utility to
                    help you create such an icon, but if
                    you have one, upload it to the main TNG folder and enter the file name here.</p>

            </td>
        </tr>
        <tr class="databack">
            <td class="tngshadow">

                <p style="float:right;"><a href="#top">Top</a></p>
                <a id="lang"><h4 class="subheadbold">Language</h4></a>

                <h5>Language</h5>
                <p>Your default language folder (i.e., 'English'). You may have more than one language available to visitors, but this language will
                    always display first.</p>

                <h5>Character Set</h5>
                <p>The character set for your default language. If this is left blank, the browser's default character set will be used. The character
                    set
                    for English and other languages using the 26-character
                    Roman alphabet is ISO-8859-1.</p>

                <h5>Dynamic Language Change</h5>
                <p>If you have set up more than one language and want users to be able to select a different language "on the fly",
                    select <em>Allow</em>.</p>

            </td>
        </tr>
        <tr class="databack">
            <td class="tngshadow">

                <p style="float:right;"><a href="#top">Top</a></p>
                <a id="priv"><h4 class="subheadbold">Privacy</h4></a>

                <h5>Require Login</h5>
                <p>Normally anyone can view your public pages, with a login to see data for living individuals being optional. If, however,
                    you want to require everyone to log in before they can see anything beyond the home page, check this box.</p>

                <h5>Restrict access to assigned tree</h5>
                <p>If Require Login is set to 'Yes', then setting this option to 'Yes' will cause users to only see information associated with their
                    assigned trees. All other individuals, families, sources, etc. will be hidden.</p>

                <h5>Show LDS Data</h5>
                <p>To always show LDS data (where available), select <em>Always</em> (this was the default before). To turn off all LDS
                    information and the ability to manually enter LDS data, select <em>Never</em>. To make this switch dependent on
                    user permissions, select <i>Depending on user rights</i>. In this case, only logged-in users who have rights
                    to see LDS data will see it. It will be hidden from all others.</p>

                <h5>Show Living Data</h5>
                <p>To always show living data (dates and places for living individuals), select <i>Always</i>. To turn off all living
                    information, select <i>Never</i>. To make the display of living data dependent on
                    user permissions, select <i>Depending on user rights</i>. In this case, only logged-in users who have rights
                    to see living data will see it. It will be hidden from all others.</p>

                <h5>Show Names for Living</h5>
                <p>To hide the names of individuals marked as Living (no death or burial information, plus a birthdate less than 110 years ago),
                    select
                    <em>No</em>. Names of living
                    individuals will be replaced with the word "Living". To show the surname and first initial(s) of living individuals, select <em>Abbreviate
                        first name</em>. To
                    always show the names of living individuals for everyone, select <em>Yes</em>.</p>

                <h5>Show Names for Private</h5>
                <p>To hide the names of individuals marked as Private, select <em>No</em>. Names of private
                    individuals will be replaced with the word "Private". To show the surname and first initial(s) of private individuals, select <em>Abbreviate
                        first name</em>. To
                    always show the names of private individuals for everyone, select <em>Yes</em>.</p>

                <h5>Show cookie approval message</h5>
                <p>Site visitors will be shown a small popup in the lower right corner of the screen advising them that the site uses cookies.
                    Once the visitor clicks the "I understand" button, the message will disappear, and a cookie will be set to remember
                    the action. As long as that cookie persists, the visitor will not see the popup again on subsequent visits.</p>

                <h5>Show link to data protection policy</h5>
                <p>Site visitors will be shown a link to the site's Data Protection Policy in the footer that appears at the bottom of every page.
                    A link will also be shown in the cookie popup (see above) and on pages where the visitor is asked to give consent for private
                    information to be stored (new account registration, suggest/contact us). A copy of this policy can be found in most language
                    folders.
                    That document is called data_protection_policy.php. If the visitor is using a language that does not include a translation of this
                    policy, the visitor will be shown the English translation.</p>

                <h5>Prompt for consent regarding personal info</h5>
                <p>Before submitting comments, suggestions or new user registrations, site visitors will be required to check a box indicating they
                    consent to the information in the form being recorded. If the box is not checked, the submit button will be disabled. If the
                    button is clicked anyway, a popup will advise the visitor that the box must be checked before the form can be submitted.</p>

                <h5>reCAPTCHA</h5>
                <p>reCAPTCHA is a free service that protects your site from spam and abuse. It uses advanced risk analysis engine to tell humans and
                    bots apart. Visitors will only need to check a box indicating that they are not a robot. To activate this service, you will need
                    a Site Key and a Secret.</p>

                <h5>Site Key and Secret</h5>
                <p>To get your Site Key and Secret, go to https://www.google.com/recaptcha/admin. If you don't already have a Google account you
                    will need to create one. If you do have a Google account, sign in when prompted, then follow the instructions to create your keys.
                    When prompted for your site address/domain name, do NOT enter the "www" and don't put in a trailing slash. After the keys are
                    created, paste them into the fields here.</p>

            </td>
        </tr>
        <tr class="databack">
            <td class="tngshadow">

                <p style="float:right;"><a href="#top">Top</a></p>
                <a id="name"><h4 class="subheadbold">Names</h4></a>

                <h5>Name Order</h5>
                <p>Dictates how names will be displayed in most cases (some lists always display the surname first). Choose to display the first name
                    first (Western) or the surname first (Oriental).
                    If nothing is selected, names will be displayed "first name first".</p>

                <h5>Uppercase All Surnames</h5>
                <p>Allows you to dispay all surnames in upper case. If this option is set to "No", then names will appear as they were entered or
                    imported.</p>

                <h5>Surname Prefixes</h5>
                <p>Governs how surname prefixes (i.e., "de" or "van") are treated. By default, anything imported in the GEDCOM surname field is part
                    of
                    the surname, and this dictates how
                    surnames are sorted ("de Kalb" comes before "van Buren"). You can elect to keep surname prefixes as part of the surname, or you
                    can
                    choose to treat them
                    as separate entities (thus, "van Buren" would then sort before "de Kalb"). Existing surnames will not be affected unless manually
                    edited or converted with surnameconvert400.php.</p>

                <h5>Prefix Detection on Import</h5>
                <p>If you have elected to treat surname prefixes as separate entities, this section will provide rules to help the import routine
                    decide
                    what is a prefix. Prefixes are defined as
                    portions of the name separated by spaces, but you can choose how many prefixes from each name will be part of TNG's prefix. In
                    other
                    words, if you indicate that
                    the "Num. prefixes each (max)" is 1, then only the "van" from "van der Merwe" would be moved to the prefix field. On the other
                    hand,
                    if you set this value to 2 or higher, "van der"
                    would be the prefix. You may also indicate one or more specific prefixes that should always be treated as full prefixes. In other
                    words, if you set this value to "van der", then
                    "van der" will always be considered a valid prefix, regardless of how high or low you set the previous value. Separate multiple
                    values
                    with commas. To recognize a
                    prefix offset by an apostrophe, include the apostrophe in this list. For example: "van,vander,van der,d',a',de,das".</p>

            </td>
        </tr>
        <tr class="databack">
            <td class="tngshadow">

                <p style="float:right;"><a href="#top">Top</a></p>
                <a id="cem"><h4 class="subheadbold">Cemeteries</h4></a>

                <h5>Max lines per column (approx.)</h5>
                <p>If you have a lot of cemeteries defined, this number will tell TNG to split the list and create another column when the
                    number is reached.</p>

                <h5>Suppress "Unknown" categories</h5>
                <p>If you define a cemetery with a missing locality (e.g., no state or no county), TNG will normally create a heading labeled
                    "Unknown" to accommodate the empty fields. Choosing this option will cause TNG to leave the "Unknown" headings off.</p>

            </td>
        </tr>
        <tr class="databack">
            <td class="tngshadow">

                <p style="float:right;"><a href="#top">Top</a></p>
                <a id="mail"><h4 class="subheadbold">Mail and Registration</h4></a>

                <h5>Email Address</h5>
                <p>Your email address. When visitors request a new user account, an email message will be sent to this address. Submissions from the
                    "Contact Us" page will also be sent to this address. Messages originating from the "Suggest" form will go this address if there is
                    no email address associated with the tree corresponding to the page from which the suggestion was sent (otherwise, the message
                    will be sent there).</p>

                <h5>Send all mail from address above</h5>
                <p>When someone sends you a message using TNG, the program attempts to send it as if it came from them so that you
                    can easily reply. Some hosting providers do not allow that, however. They will refuse to send email unless the sender's
                    email address comes from the same domain as your site. If you find that email from TNG is not being sent, your host
                    may be doing this to you. If that's the case, setting this option to Yes cause TNG to send all mail from the
                    TNG administrator's address (entered above on this page). That should correct the problem.</p>

                <h5>Allow new user registrations</h5>
                <p>Allows you to turn off the option for visitors to request a user account on your site.</p>

                <h5>Notify on reviewable submissions</h5>
                <p>Setting this option to "Yes" will cause an email message to be sent to the administrator whenever a tentative change is entered by
                    someone
                    with "Submitter" rights and is waiting for administrative review.</p>

                <h5>Create new tree for user</h5>
                <p>If this option is set to Yes, a new tree will automatically be created for each new user registration, and the
                    user will be assigned to that tree.</p>

                <h5>Auto approve new users</h5>
                <p>Normally, all new user registrations require the administrator's approval before the accounts can become active.
                    Changing this setting to Yes will automatically activate all new user requests. You will still want to edit
                    the account settings to make sure the user has the rights you want them to have.</p>

                <h5>Send acknowledgement email</h5>
                <p>If this option is set to Yes, an email will be sent to each potential new user, informing them that their request
                    has been received and is being processed. Does not apply if new registrations are automaticaly activated.</p>

                <h5>Include password in welcome email</h5>
                <p>Normally a user's chosen password is included in the "welcome" email informing them that their account is
                    now active. If you don't want the password to be included, set this option to No.</p>

                <h5>Use SMTP Authentication</h5>
                <p>Normally TNG sends email by way of the PHP "mail" function. If you'd rather use the Simple Mail Transfer Protocol (meaning that a
                    login
                    must be supplied by the program before the mail can be sent), then set this option to "Yes". More options will then become
                    visible.
                    They are: SMTP host name,
                    Mail username, Mail password, Port number and Encryption. Your hosting provider should be able to give you the correct values for
                    these fields.</p>

            </td>
        </tr>
        <tr class="databack">
            <td class="tngshadow">

                <p style="float:right;"><a href="#top">Top</a></p>
                <a id="pref"><h4 class="subheadbold">Prefixes and Suffixes</h4></a>

                <p>These letters are combined with a number to form IDs for the people, families, sources, repositories and notes in your database.
                    Most
                    genealogy
                    programs use the same set of standard prefixes (and no suffixes). If your desktop program uses suffixes or different prefixes
                    instead,
                    enter them here.
                    If the proper prefixes or suffixes are not entered, some TNG features may not work correctly.</p>

            </td>
        </tr>
        <tr class="databack">
            <td class="tngshadow">

                <p style="float:right;"><a href="#top">Top</a></p>
                <a id="misc"><h4 class="subheadbold">Miscellaneous</h4></a>

                <h5>Max Search Results</h5>
                <p>This limits the number of results that can be displayed for any public search query. This should be a relatively small, manageable
                    number in order to maximize
                    efficiency and enhance the user experience.</p>

                <h5>Individuals Start With</h5>
                <p>This indicates which information will be initially viewable when an individual record is displayed. If you
                    select "Personal Information Only", then other categories such as Notes, Citations or Photos and Histories will
                    be hidden until they or "All" are explicitly selected by the user.</p>

                <h5>Show Notes</h5>
                <p>Allows you to choose where notes are displayed on the individual page. The options are:</p>

                <ul>
                    <li>In Notes Section: Displays all notes in a separate block at the bottom of the page.</li>
                    <li>Underneath corresponding events where possible: Event-specific notes are displayed directly underneath the events to which
                        they
                        correspond. General notes are displayed
                        at the bottom of the "Personal" section and each "Family" section. If the general notes are long, scroll bars will be provided
                        to
                        prevent the pages from getting too long
                        (the max height of the area can be found in genstyle.css, in the "notearea" block).
                    </li>
                    <li>Underneath events, except general notes: Same as above, but general notes are always displayed in a separate block at the
                        bottom
                        of the page. No max height is imposed.
                    </li>
                </ul>

                <h5>Scroll citations</h5>
                <p>Setting this to "Yes" will cause the Sources area at the bottom of each person's individual page to have a maximum height. If any
                    person has enough source citations
                    to make the area taller than the maximum height, then the area will be scrollable.</p>

                <h5>Server time offset (hours)</h5>
                <p>If your server is in a different time zone than you are, enter the difference in hours here. If your time is behind the server
                    time,
                    enter a negative number.</p>

                <h5>Edit timeout (minutes)</h5>
                <p>The number of minutes a user is allowed to have exclusive edit rights to any individual or family record. During this time, any
                    other
                    user who tries to edit
                    the same record will see a message indicating that the record is locked. If the original user is still editing the record when the
                    time is about to elapse, that user
                    will see a message warning them to save their changes soon. If the user does not attempt to save before another user succeeds in
                    gaining access to the record, those changes
                    will be lost.</p>

                <h5>Max Generations, GEDCOM download</h5>
                <p>The number of maximum number generations that can be exported in a publicly requested GEDCOM file.</p>

                <h5>What's New Days</h5>
                <p>The number of days to keep new items on the "What's New" page. To remove this limitation, set the value to zero. Doing that will
                    cause
                    older
                    items to remain on the list until bumped off by newer items.</p>

                <h5>What's New Limit</h5>
                <p>The maximum number of items in each category to display on the "What's New" page.</p>

                <h5>Numeric Date Preference</h5>
                <p>If you enter a numeric date (e.g., 04/09/2008), this option determines whether to interpret the entry as Month/Day/Year (9 Apr
                    2008)
                    or Day/Month/Year (4 Sep 2008).</p>

                <h5>First day of week</h5>
                <p>When the Calendar page is displayed, this day will be in the first column from the left.</p>

                <h5>Parental data on person page</h5>
                <p>Choose which events (if any) to display relating to the family of the individual's parents.</p>

                <h5>Line Ending</h5>
                <p>This is the character string that will included at the end of each line when exporting a GEDCOM file. It's also
                    the string that will define the end of a line when importing. The default is "\r\n", which means "carriage return
                    plus line feed". Some programs or operating systems prefer just a carriage return (\r) or a line feed (\n), so
                    you may wish to adjust this setting at least temporarily in some cases.</p>

                <h5>Encryption type</h5>
                <p>Passwords in TNG are encrypted before they are stored in the database. Because of that, you can't simply change or remove your
                    password
                    by manually editing the database. The default encryption method is md5, but you may select another method here.</p>

                <h5>Assign Place records to Trees</h5>
                <p>If this is set to "Yes", then each Place record will be associated with one of your Trees. That means that if you have multiple
                    trees,
                    you could have
                    the same place appear multiple times in your Places table because it is associated with more than one tree. If you change this
                    option
                    to "No", you
                    will be given the chance to automatically merge all Places into a single list. If you change this option to "Yes", you will see
                    the
                    option to assign
                    a particular Tree to all the Places (since they previously wouldn't have had any assignment).</p>

                <h5>Geocode all new places</h5>
                <p>If this option is set to "Yes", then all new places entered in Admin/People and Admin/Families will be automatically geocoded
                    (assumes
                    an
                    Internet connection).</p>

                <h5>Re-use deleted IDs</h5>
                <p>If this option is set to "Yes", new People, Families, Sources and Repositories will try to reuse ID numbers that were previously
                    deleted.</p>

                <h5>Show last import</h5>
                <p>If this option is set to "Yes", the date of the most recent GEDCOM import will be shown on the What's New and Statistics pages when
                    a
                    tree is selected.</p>

                <h5>Show 'Important tasks' messages</h5>
                <p>Set to "Yes" to allow TNG to show you a list of important tasks at the top of the Admin menu. These will include prompts to back up
                    your data, deal with new user
                    registrations, and others. You can still choose to collapse the messages even if you allow them to be displayed here.</p>

                <h5>Show record totals on Admin menu</h5>
                <p>Allows TNG to show totals for each category on the main Admin menu. For example, if there are 1,000 people in your TNG trees, you
                    will
                    see "1,000" on the right side of the "People" bar.</p>

                <h5>Alert if no backup in this many days</h5>
                <p>After this many days have elapsed since you last backed up at least one of your tables, TNG will include a reminder message in the
                    "Important Tasks" section at the top. To
                    stop seeing these messages, set this value to zero.</p>

                <h5>I am using TNG offline</h5>
                <p>If "Yes" is selected, TNG will use local instead of online versions of its third-party libraries (ie, jQuery) and will not try
                    to access Google Maps.</p>

            </td>
        </tr>

    </table>
    </body>
<?php echo "</html>"; ?>
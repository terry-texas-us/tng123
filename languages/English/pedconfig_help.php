<?php

include "../../helplib.php";
echo help_header("Help: Chart Settings");
?>

    <body class="helpbody">
    <a id="top"></a>
    <table class="tblback normal">
        <tr class="fieldnameback">
            <td class="tngshadow">
                <p style="float:right; text-align:right;" class="smaller menu">
                    <a href="https://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp;|&nbsp;
                    <a href="https://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
                    <a href="config_help.php" class="lightlink">&laquo; Help: General Settings</a> &nbsp;|&nbsp;
                    <a href="logconfig_help.php" class="lightlink">Help: Log Settings &raquo;</a>
                </p>
                <h2 class="largeheader">Help: <small>Chart Settings</small></h2>
                <p class="smaller menu" style="clear: both;">
                    <a href="#ped" class="lightlink">Pedigree</a> &nbsp;|&nbsp;
                    <a href="#desc" class="lightlink">Descendancy</a> &nbsp;|&nbsp;
                    <a href="#rel" class="lightlink">Relationship</a> &nbsp;|&nbsp;
                    <a href="#time" class="lightlink">Timeline</a> &nbsp;|&nbsp;
                    <a href="#common" class="lightlink">Common Elements</a> &nbsp;|&nbsp;
                    <a href="#thumb" class="lightlink">Thumbnails</a>
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

                <a id="ped"><h4 class="subheadbold">Pedigree Chart</h4></a>

                <h5 class="optionhead">Initial Display</h5>
                <p>This option determines which pedigree format is initially displayed. When Standard is selected, all birth, marriage, and
                    death/burial
                    dates
                    (when available) will be included in a hidden popup box. A photo of the individual is displayed if present. An image file (i.e.,
                    ArrowDown.gif) will be placed below the bottom
                    center of the pedigree boxes wherever information
                    is available, and the popup box will appear beneath the pedigree box when the Popup Event is triggered. The Compact format is
                    similar to Standard, but the box size is greatly reduced, and no photos are displayed. When Box is selected,
                    the standard information will appear in the pedigree boxes at all times. When Text Only is selected, a text-based version of the
                    pedigree chart (no boxes or popup windows)
                    will be shown first. The Vertical option will show the primary individual at the bottom, with the person's ancestors being
                    displayed
                    above them.
                    The user will always have the option to switch among these display types after viewing the initial display.</p>

                <h5 class="optionhead">Max Generations</h5>
                <p>The maximum number of generations you will allow visitors to request at one time.</p>

                <h5 class="optionhead">Initial Generations</h5>
                <p>The number of generations that will be displayed to start with. If nothing is specified here, then this value will default to
                    four.</p>

                <h5 class="optionhead">Popup Spouses</h5>
                <p>If popups are being used, checking this option will result in spouse links being included in popups. Default is not checked.</p>

                <h5 class="optionhead">Popup Children</h5>
                <p>If popups are being used and Popup Spouses is checked, checking this option will result in children links being included in popups.
                    Default is not checked.</p>

                <h5 class="optionhead">Popup Chart Links</h5>
                <p>If popups are being used (and either Popup Spouses or Popup Kids has been checked), checking this option will cause links to
                    pedigree
                    chart pages to be included for
                    spouses and children in popups. Default is on.</p>

                <h5 class="optionhead">Hide Empty Boxes</h5>
                <p>Select 'Yes' to remove unpopulated boxes from the chart.</p>

                <h5 class="optionhead">Box Width (w/o popups)</h5>
                <p>Fixed width of all pedigree boxes (in pixels) when popup boxes are not in use. Default value is 211. If a number less than 21 is
                    entered, 21 will
                    be used. The number used will always be an odd number, so if an even number is entered, it will be increased by 1.</p>

                <h5 class="optionhead">Box Height (w/o popups)</h5>
                <p>Height of all pedigree boxes (in pixels) when popup boxes are not in use, unless a non-zero boxheightshift is specified (see
                    below), in
                    which case Box Height is the
                    height of the first pedigree box on the chart. Default value is 121. If a number less than 21 is entered, 21 will be used. The
                    number
                    used will
                    always be an odd number, so if an even number is entered, it will be increased by 1.</p>

                <h5 class="optionhead">Box Alignment (w/o popups)</h5>
                <p>The alignment of data appearing within the box when popup boxes are in use.
                    Note: Dates and places will always be aligned left, but the block containing them will follow this alignment.</p>

                <h5 class="optionhead">Box Height Shift (w/o popups)</h5>
                <p>The value by which the height of pedigree boxes should be altered for successive generations (in pixels) when popup boxes are not
                    in use. This should be a negative number. Default value is -2. If zero is entered, no change in box sizes
                    will occur. The number used will always be an even number, so if an odd number is entered, it will be increased by 1.</p>

                <h3>Vertical Chart</h3>

                <h5 class="optionhead">Box Width</h5>
                <p>The width in pixels of each name box on the vertical chart.</p>

                <h5 class="optionhead">Box Height</h5>
                <p>The height in pixels of each name box on this chart.</p>

                <h5 class="optionhead">Spacing</h5>
                <p>The horizontal distance in pixels between name boxes.</p>

                <h5 class="optionhead">Box Name Size</h5>
                <p>The font size (in points) for names displayed on the vertical chart.</p>
            </td>
        </tr>
        <tr class="databack">
            <td class="tngshadow">

                <p style="float:right;"><a href="#top">Top</a></p>
                <a id="desc"><h4 class="subheadbold">Descendancy Chart</h4></a>

                <h5 class="optionhead">Initial Display</h5>
                <p>This option determines which descendancy format is initially displayed. When Standard is selected, all birth and death/burial dates
                    (when available) will be included in a hidden popup box. A photo of the individual is displayed if present. An image file (i.e.,
                    ArrowDown.gif) will be placed below the bottom
                    center of the pedigree boxes wherever information
                    is available, and the popup box will appear beneath the descendancy box when the Popup Event is triggered. The Compact format is
                    similar to Standard, but the box size is greatly reduced, and no photos are displayed. When Text Only is selected, a text-based
                    version
                    of the descendancy chart (no boxes or popup windows) will be shown first. The Register format shows the same information in a
                    narrative
                    style. The user will always have the option to switch among these display types after viewing the initial display.</p>

                <h5 class="optionhead">Max Generations</h5>
                <p>The maximum number of generations you will allow visitors to request at one time.</p>

                <h5 class="optionhead">Initial Generations</h5>
                <p>The number of generations that will be displayed to start with. If nothing is specified here, then this value will default to
                    four.</p>

                <h5 class="optionhead">Start Descendancy</h5>
                <p>Choose to start the text-based descendancy chart with all generations expanded or collapsed. The user will always have the option
                    to expand or collapse individual families.</p>

                <h5 class="optionhead">Show Notes on Register</h5>
                <p>Indicates whether notes for individuals and families will be displayed on the Register page.</p>

                <h5 class="optionhead">Register Generations</strong></h5>
                Choose to always show each person when displaying a generation, or avoid redundancy by electing to "Remove individuals
                with no family." That option will only display those individuals when they appear as children. They will not be
                redisplayed when their entire generation is outlined later in the report.</p>

            </td>
        </tr>
        <tr class="databack">
            <td class="tngshadow">

                <p style="float:right;"><a href="#top">Top</a></p>
                <a id="rel"><h4 class="subheadbold">Relationship Chart</h4></a>
                <h5 class="optionhead">Initial Relationships</h5>
                <p>When a new Relationship chart is requested, this is how many relationships TNG will try to find. As soon as that many
                    relationships are found, the process will stop. If your tree contains no complicated relationships, you may want to set
                    this to 1 in order to save processing time.</p>

                <h5 class="optionhead">Max Relationships</h5>
                <p>If the user believes that more relationships exist, they may want to increase the number of relationships TNG will
                    try to find. This number represents to most relationships you will allow the program to search for. Try not to set it
                    higher than the level of complexity in your tree. The lower this number is, the more time you will save people as
                    they view this chart. For example, if only one relationship exists between two people but you are searching for five,
                    TNG will continue searching in vain after the first relationship is found.</p>

                <h5 class="optionhead">Max Generations</h5>
                <p>The maximum number of generations you will allow visitors to search at one time on the Relationship page. This will also be the
                    initial
                    default on that page.</p>

            </td>
        </tr>
        <tr class="databack">
            <td class="tngshadow">

                <p style="float:right;"><a href="#top">Top</a></p>
                <a id="time"><h4 class="subheadbold">Timeline Chart</h4></a>
                <h5 class="optionhead">Starting chart width</h5>
                <p>The initial width in pixels of the lifespan timeline. Visitors can change the width for themselves only at the top
                    of the page.</p>

                <h5 class="optionhead">Enable Simile timeline</h5>
                <p>Along with the standard TNG timeline, you can also display a Simile timeline chart on the same page by choosing "Yes" here. More
                    information on the Simile timeline chart can be found at <a href="http://www.simile-widgets.org/timeline/">http://www.simile-widgets.org/timeline/</a>.
                </p>

                <h5 class="optionhead">Chart height</h5>
                <p>Height in pixels of the event (Simile) timeline. If many events are charted at the same time, some could get pushed
                    down off the chart's visible area. If that seems to be happening, it could help to increase this value.</p>

                <h5 class="optionhead">Events to include</h5>
                <p>Controls which events will be dislayed on the event timeline. Choose to display all events, or only those that fall
                    within the lifespans of the individuals on the chart. If you have a lot of events, choosing to display them all may
                    cause the chart to be slighly slower in its initial display.</p>

                <p>Notes: If too many events are on the chart at once, those at the bottom will not be visible. If you have a lot of timeline events
                    and
                    this is a frequent occurrence,
                    you might consider increasing the Chart Height (see above). More options are available in timelineconfig.php.</p>

            </td>
        </tr>
        <tr class="databack">
            <td class="tngshadow">

                <p style="float:right;"><a href="#top">Top</a></p>
                <a id="common"><h4 class="subheadbold">Common Elements</h4></a>

                <h5 class="optionhead">Left Indent</h5>
                <p>Horizontal offset to be used for the entire pedigree chart (in pixels). This may be needed, for example, to ensure that the chart
                    does
                    not
                    overlay any margin images, menus, or text that are in the left margin. Default value is 10. If a negative number is entered, 0
                    will be
                    used.</p>

                <h5 class="optionhead">Box Name Size</h5>
                <p>The size (in points) of all names on the chart. In no case will the font size be permitted to
                    decrease to less than 7 points. Default value is 12 (72 points are in one inch).</p>

                <h5 class="optionhead">Box Date Size</h5>
                <p>The size (in points) of other chart information (dates and places). In no case will the font size be permitted to
                    decrease to less than 7 points. Default value is 10 (72 points are in one inch).</p>

                <h5 class="optionhead">Box Color</h5>
                <p>The background color to be used in all pedigree boxes, unless a non-zero colorshift is specified, in which case this will define
                    the
                    background
                    color of the first pedigree box on the chart. Default value is #CCCC99 (khaki; white is #FFFFFF).</p>

                <h5 class="optionhead">Color Shift</h5>
                <p>A percentage value that defines how the color values should be "shifted" up or down (towards white or towards black) over the range
                    of
                    all generations shown. The value entered should be between -100 and 100. If zero is entered, all pedigree boxes (except perhaps
                    those
                    that are empty &#151; see emptycolor)
                    will have the same background color. The default value is 80, which means that box background color will fade 80% of the way from
                    the
                    original color to white as
                    the boxes go from the first generation to the last generation displayed (negative values will fade toward black).</p>

                <h5 class="optionhead">Empty Color</h5>
                <p>The background color to be used in all pedigree boxes for which no data exists. Default value is #CCCCCC (silver).</p>

                <h5 class="optionhead">Border Color</h5>
                <p>The color to be used for the borders around pedigree boxes and the connector lines. Default is #000000 (black).</p>

                <h5 class="optionhead">Shadow Color</h5>
                <p>The color to be used for shadows. Default value is #999999 (gray).</p>

                <h5 class="optionhead">Shadow Offset</h5>
                <p>The offset to be used for including box and connector line shadows (in pixels). A negative number will result in
                    shadows that are above, and to the left of boxes and lines. A positive number will result in shadows that are below, and to the
                    right
                    of boxes and lines. If the number entered is
                    zero, the shadows will not be evident (as they will lie strictly below the boxes and lines. Default value is 4.</p>

                <h5 class="optionhead">Box Horizontal Separation</h5>
                <p>Fixed horizontal separation between generations of pedigree boxes (in pixels). Default value is 31. If a
                    number less than 7 is entered, 7 will be used. The number used will always be an odd number, so if an even number is entered, it
                    will
                    be increased by 1.</p>

                <h5 class="optionhead">Box Vertical Separation</h5>
                <p>Vertical separation between generations of pedigree boxes (in pixels), unless a non-zero Box Height Shift is specified, in
                    which case Box Vertical Separation is the fixed horizontal separation between boxes in the last displayed generation. Default
                    value is
                    11. If a number
                    less than 7 is entered, 7 will be used. The number used will always be an odd number, so if an even number is entered, it will be
                    increased by 1. Notwithstanding the foregoing,
                    the value may be increased, if necessary, to ensure there is room between pedigree boxes for shadows and additional information
                    indicators.</p>

                <h5 class="optionhead">Default PDF Page Size</h5>
                <p>The paper size that will be assumed for all PDF reports (visitors may change this before each report created).</p>

                <h5 class="optionhead">Line Width</h5>
                <p>Width of lines connecting pedigree boxes (in pixels). Default value is 1. If a number less than 1 is entered, 1 will be used.</p>

                <h5 class="optionhead">Border Width</h5>
                <p>Width of the border around pedigree boxes (in pixels). Default is 1. If a number less than 1 is entered, 1 will be used.</p>

                <h5 class="optionhead">Popup Color</h5>
                <p>The background color used with popups boxes. If left blank, popup boxes will be one color shift removed from the box color. Default
                    value is #DDDDDD (light gray). </p>

                <h5 class="optionhead">Popup Info Size</h5>
                <p>The size (in points) of other chart information (dates and places) inside a popup. In no case will the font size be permitted to
                    decrease to less than 7 points. Default value is 10 (72 points are in one inch).</p>

                <h5 class="optionhead">Popup Timer</h5>
                <p>If popups are being used, the number of milliseconds a popup should remain visible. Default value is 500 (1/2 second). There are
                    two
                    conditions
                    that can modify the duration of a popup display. First, if another popup is requested, any previously visible popup is removed.
                    Second, while the cursor is present over a visible
                    popup, the timer defined here will not be used until the cursor is moved "out of" the popup. By this means, one can explicitly
                    keep a
                    popup visible for an indefinite period of
                    time.</p>

                <h5 class="optionhead">Popup Event</h5>
                <p>The mouse event required to display the popup. This event is associated with the arrow indicating that additional information is
                    available. If
                    Mouse Down is selected, clicking on the arrow will display the popup. If Mouse Over is selected, the popup will be displayed when
                    the
                    mouse pointer is positioned over the
                    arrow.</p>

                <h5 class="optionhead">Box Width (w/popups)</h5>
                <p>Fixed width of all pedigree boxes (in pixels) when popup boxes are in use. Default value is 151. If a number less than 21 is
                    entered,
                    21 will
                    be used. The number used will always be an odd number, so if an even number is entered, it will be increased by 1.</p>

                <h5 class="optionhead">Box Height (w/popups)</h5>
                <p>Height of all pedigree boxes (in pixels) when popup boxes are in use, unless a non-zero Box Height Shift is specified (see below),
                    in
                    which case Box Height is the
                    height of the first pedigree box on the chart. Default value is 60. If a number less than 21 is entered, 21 will be used. The
                    number
                    used will
                    always be an odd number, so if an even number is entered, it will be increased by 1.</p>

                <h5 class="optionhead">Box Alignment (w/popups)</h5>
                <p>The alignment of data appearing within the box when popup boxes are not in use.
                    Note: Dates and places will always be aligned left, but the block containing them will follow this alignment.</p>

                <h5 class="optionhead">Box Height Shift (w/popups)</h5>
                <p>The value by which the height of pedigree boxes should be altered for successive generations (in pixels).
                    This should be a negative number. Default value is -2. If zero is entered, no change in box sizes
                    will occur. The number used will always be an even number, so if an odd number is entered, it will be increased by 1.</p>

                <h5 class="optionhead">Include Photos</h5>
                <p>If this option is checked, thumbnail photos will be included in the pedigree boxes (when popups are used and the image file can be
                    found -- see below).
                    Default is not checked.</p>

            </td>
        </tr>
        <tr class="databack">
            <td class="tngshadow">

                <p style="float:right;"><a href="#top">Top</a></p>
                <a id="thumb"><h4 class="subheadbold">Notes About Including Thumbnail Photos</h4></a>

                <ul>
                    <li>To designate a photo to represent an individual on the pedigree chart, edit the photo (must be one with a thumbnail) and check
                        the
                        box marked <span class="emphasis">Make Default</span>
                        under the link to the desired individual and save
                        the page. The existing thumbnail will then be used on the pedigree and other charts. The action of selecting <span
                            class="choice">Make Default</span>
                        used to copy the existing
                        thumbnail to a new location, with the copied file being
                        named <span class="emphasis">Mtreename.###.ext</span>, where <span class="emphasis">treename</span> was the name of the tree
                        to
                        which the person belonged, <span
                            class="emphasis">###</span> was the GEDCOM person ID and ext was the Photos
                        Extension defined above (i.e., <span class="example">MLythgoe.I567.jpg</span>). This convention is no longer used, but
                        existing
                        thumbnails created in that manner will still be
                        used and will take precedence. <span
                            class="emphasis">NOTE:</span> You can still create default thumbnails manually in this manner if you don't want the
                        default photo to be derived from any other photo
                        linked to the individual.
                    </li>

                    <li>If an image is located using the foregoing convention, the size may be scaled downward, if necessary, to fit within the height
                        of the associated pedigree box. <span
                            class="emphasis">Upward</span> scaling is not done, however, so that
                        picture quality is not compromised. It should also be noted that any downward scaling of the display does not affect the size
                        of the photo file. In other words, just because
                        the picture looks smaller does not mean it will download any
                        quicker than it would if it were displayed in its normal size. Therefore, large photos should definitely not be used for
                        pedigree images as the download time of the entire page
                        would be severely affected.
                    </li>

                    <li>The inclusion of photos will affect the space remaining in pedigree boxes for names and other information. As such, it may be
                        advisable to <span class="emphasis">tune</span>
                        box and font sizes using previously described configuration
                        options, or to select the <span class="choice">overflow</span> option described above.
                    </li>
                </ul>
            </td>
        </tr>

    </table>
    </body>
<?php echo "</html>"; ?>
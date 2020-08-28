<?php
include "../../helplib.php";
echo help_header("Help: Mod Manager");
?>

<body class="helpbody">
<a name="top"></a>
<table width="100%" cellpadding="10" cellspacing="2" class="tblback normal">
  <tr class="fieldnameback">
    <td class="tngshadow">
      <p style="float:right; text-align:right" class="smaller menu">
        <a href="https://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp; | &nbsp;
        <a href="https://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br>
        <a href="backuprestore_help.php" class="lightlink">&laquo; Help: Utilities</a> &nbsp; | &nbsp;
        <a href="index_help.php" class="lightlink">Help: Getting Started &raquo;</a>
      </p>
      <span class="largeheader">Help: Mod Manager</span>
      <p class="smaller menu">
        <a href="#overview" class="lightlink">Overview</a> &nbsp; | &nbsp;
        <a href="#operation" class="lightlink">Operation</a> &nbsp; | &nbsp;
        <a href="#status" class="lightlink">Status</a> &nbsp; | &nbsp;
        <a href="#syntax" class="lightlink">Mod Syntax</a> &nbsp; | &nbsp;
        <a href="#files" class="lightlink">Config Files</a> &nbsp; | &nbsp;
                <a href="#batch" class="lightlink">Batch Operations</a> &nbsp; | &nbsp;
                <a href="#options" class="lightlink">Options</a> &nbsp; | &nbsp;
                <a href="#analyze" class="lightlink">Analyze TNG Files</a> &nbsp; | &nbsp;
                <a href="#parser" class="lightlink">View Parser Table</a> &nbsp; | &nbsp;
                <a href="#custtext" class="lightlink">Recommended Updates</a>
            </p>
        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">
            <div id="google_translate_element" style="float:right"></div>
            <script type="text/javascript">
                function googleTranslateElementInit() {
                    new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
                }
            </script>
            <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

            <a name="overview"><p class="subheadbold">Overview</p></a>

            <p>The TNG 12 version of the Mod Manager is based on the Mod Manager originally developed by Brian McFadyen, updated by Sean Schwoere to work with the Joomla TNG Component, and updated in TNG 10.0.3 and 10.1 to provide a more integrated way to
                install, remove and manage modifications to the TNG software package that have been coded to work with this manager.</p>
            <p>The new Mod Manager provides a single line summary of the mod status which can be expanded to view the complete Description and errors when applicable. The Affected Files List can be displayed by hovering over the + plus sign in the Files
                column. You can also use the <strong>Expand All</strong> inner menu to expand all entries to show the status like the old Mod Manager used to do. The Expand All option is helpful when filtering the list by <strong>Partially
                    Installed</strong> or <strong>Cannot Install</strong> so you can see what the errors are.</p>
            <p>The Mod Manager is connected into the TNG Administrative page for easy access. The Mod Manager adds the following folders to TNG:
            <ul>
                <li><strong>mods</strong> to contain the Mod configuration files and associated Mod support files. The mods folder can now be renamed. The Mod Manager uses the $modspath variable to resolve the folder name.</li>
                <li><strong>extensions</strong> to contain some of the mod extensions that are installed by other Mod Manager config files. The extensions folder can now be renamed. The Mod Manager uses the $extspath variable to resolve the folder name.
                </li>
                <li><strong>classes</strong> which contain the Object Orient Progamming classes that were split and enhanced from the previous managemods.class.php created by Sean Schwoere from Brian's original Mod Manager code.</li>
            </ul>
            </p>
            <p>The <strong>Mod List</strong> tab now combines the previous Mod List and Batch Updates that was added by Rick Bisbee in TNG 10.0.3 to provide the capability to execute the same action against multiple mods. The Description and extended
                status can be displayed by clicking the right arrow in the Status column or anywhere on the line. Hovering over the line will high light the line to make it easier to select the status to expand. Hovering over the + plus sign in the Files
                column will display the Affected Files list, that is the files modified, created, and copied by this mod.</p>
            <p>TNG v12 adds the following changes if the Show Other Developer Tools option is enabled:
            <ul>
                <li>a click on the file name will open the Parser Table for that mod</li>
                <li>a click on the cfg file name will display the cfg file in another tab</li>
                <li>a <strong>Detail</strong> button in the Status cell acts as a toggle to expand or collapse the display of the file directives when the status is Installed or OK to Install.</li>
            </ul>
            </p>
            <p>The <strong>View Log</strong> tab was added by Ken Roy in TNG 10.0.3 to display the Mod Manager Log which is now split from the Admin Log. The Mod Manager log is the reformated log from the Mod Manager created by Rick Bisbee and Robin
                Richmond in TNG 10.03 for easier readability of the actions. The messages were also greatly simplified.</p>
            <p>The <strong>Options</strong> tab is a modification of the one added by Ken Roy in TNG 10.0.3 to allow changing some of the execution behavior of the Mod Manager.</p>
            <p>The <strong>Analyze TNG Files</strong> tab is an optional tab that can be enabled in the Options screen that allows you to select a TNG file and view which mods change that specific TNG file.</p>
            <p>The <strong>View Parser Table</strong> tab is an optional tab that can be enabled in the Options screen by enabling the <strong>Show Other Development Tools</strong> that allows you to view how the mod is parsed by the Mod Manager.</p>
            <p>The <strong>Recommended Changes</strong> tab is an optional tab that can be enabled in the Options screen that allows you to update your cust_text.php files if you did not do so as part of the TNG upgrade readme.</p>
            <p>Additional information can be found in the <a href="https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager" target="_blank">Mod Manager</a> article and in the <a
                        href="https://tng.lythgoes.net/wiki/index.php?title=Category:TNG_Mod_Manager" target="_blank">TNG Mod Manager</a> category of articles on the TNG Wiki.</p>
            <p>You can view the <a href="https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_Enhancements" target="_blank">Mod Manager</a> article in TNG Wiki to see what enhancements were made in TNG v12.</p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Top</a></p>
            <a name="operation"><p class="subheadbold">Operation</p></a>

            <p>The Mod Manager examines the mods folder and reads each <strong>cfg</strong> file that it finds. The <strong>cfg</strong> files are directive files that describe the mod, the files and locations to be modified, and the code that is used in
                the modification.
            <p>The Mod Manager checks the following:
            <ul>
                <li>ensures the user is logged in
                <li>examines each code location and change
                    <ul>
                        <li>ensures the location can be found</li>
                        <li>ensures the target location is unique</li>
                        <li>identifies whether the target location has already been installed</li>
                    </ul>
                <li>creates any specified folder or directory</li>
                <li>identifies new files to be created. If the file is marked as protected it will not be removed by the Uninstall or Clean Up.</li>
                <li>identifies files to be copied to the TNG root or a specified folder. If the file is marked as protected it will not be removed by the Uninstall or Clean Up.</li>
            </ul>
            </p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Top</a></p>
            <a name="status"><p class="subheadbold">Status</p></a>
            <p>The Mod Manager returns the following status:
            <ul>
                <li><strong>Ok to Install</strong> if the mod is not yet installed and the target locations can be identified, then the <strong>Install</strong> button is displayed</li>
                <li><strong>Installed</strong> if the mod is completely installed, the option to <strong>Uninstall</strong> the Mod is presented and the option to <strong>Edit</strong> parameters if any exist. Mods with edit parameters are identified
                    by[Option] after the Installed status.
                </li>
                <li><strong>Partially installed</strong> if the mod is partially installed, the <strong>Cleanup</strong> button is provided. A Clean up operation will attempt to remove any inserted code, restore and replaced code, and remove any created or
                    copied files.
                </li>
                <li><strong>Cannot Install</strong> if the mod <strong>cannot</strong> be installed. You will need to expand the Status to get more detailed messages as to why the mod cannot be installed.</li>
            </ul>
            <p>For examples of the Mod Manager Status screens and how to interpret the various statuses, see <a href="https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_-_Interpreting_Status" target="_blank">Mod Manager - Interpreting Status</a></p>

            </p>

        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Top</a></p>
            <a name="syntax"><p class="subheadbold">Mod Syntax</p></a>
            <p>The Mod Manager syntax basically includes:
            <p><strong>Header section</strong> that includes</p>
            <ul>
                <li>Name - the name of the mod, wiki article and file name</li>
                <li>Version - the version of the mod, where the first 3 period places represents the lowest TNG version to which the mod applies</li>
                <li>Description - provides a brief description of the mod, the Mod Developer's name, and a URL link to the TNG Wiki article for the mod.</li>
            </ul>
            </p>
            <p><strong>Target sections</strong> that specify the file that is the target of the change and includes the following directives. A note can now be added to the target.</p>
            <ul>
                <li>Location - that specifies the code location to be changed. A note can now be added to the location.</li>
                <li>Action keyword - that specifies whether to replace or insert code before or after the location</li>
            </ul>
            </p>
            <p><strong>New File directives</strong> that create the file when the mod is installed</p>
            <p><strong>Copy File directives</strong> that copy the specified file to the TNG root (%copyfile) or to a subfolder (%copyfile2)</p>
            <p>For detailed information on the Mod Manager Syntax, see <a href="https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_Syntax" target="_blank">Mod Manager Syntax</a></p>


        </td>
    </tr>
    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Top</a></p>
            <a name="files"><p class="subheadbold">Config Files</p></a>

            <span class="optionhead">Installing Mods</span>
            <p>The TNG Wiki provides information on <a href="https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_-_Installing_Config_Files" target="_blank">Installing Config Files</a> to install the TNG mods.</p>

            <span class="optionhead">Interpreting Status</span>
            <p>The TNG Wiki provides information on <a href="https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_-_Interpreting_Status" target="_blank">Interpreting Status</a>.</p>

            <span class="optionhead">Config File Syntax</span>
            <p>The TNG Wiki provides information on the <a href="https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_Syntax" target="_blank">Mod Manager Syntax</a>.</p>

            <span class="optionhead">Creating Config Files</span>
            <p>The TNG Wiki provides information for the mod developers on the <a href="https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_-_Creating_Config_Files" target="_blank">Creating Config Files</a>.</p>
        </td>
    </tr>

    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Top</a></p>
            <a name="batch"><p class="subheadbold">Batch Operations</p></a>

            <p>The Batch Operations function introduced in TNG 10.0.3 as a Batch Updates tab is now combined in the Mod List and allows specific actions on multiple mods using the Select Filter. You must choose from the status filter list pull down and
                click <strong>Go</strong> to display the available controls for the specific status selected. <strong>Delete</strong> is only available for the Partially Installed status if you enable the Option, which we recommend that you leave as No,
                except for when you need to delete multiple mods in the Partially Installed status, such as a prior version of the same mod. Likewise there is a Delete Installed mods option that will allow deleting installed mods without first uninstalling
                them. This option was added to allow deleting previous versions of the same mod, if you forgot to delete them before installing the new version. Here again it is recommend that you leave the option as No and just enable it when needed. The
                <strong>Delete</strong> button is only shown on the Select list if both allow delete options are enabled.</p>
            <p><strong><font color="red">Caution:You should only use Batch Operations if you have a good backup of your website and can quickly restore it if the batch operations renders your site inoperable, which can easily happen if you do not delete
                        previous versions of the mods.</font> Note that it is recommended that you batch Uninstall all your Installed mods and then batch Clean Up all Partially Installed mods before doing a TNG upgrade.</strong></p>
            <p>The Select Filter options are:
            <ul>
                <li><strong>All</strong> - displays all a list of all the .cfg files in the mods folder. When you select a specific status then Action buttons will become available
                <li><strong>Ok to Install</strong> - displays a list of all the mods that can be</li>
                <ul>
                    <li>Installed based on your selections and clicking the <strong>Install</strong> button</li>
                    <li>Deleted from your mods folder based on your selections and clicking the <strong>Delete</strong> button</li>
                </ul>
                <li><strong>Installed</strong> - displays a list of all the mods that are currently installed that can be</li>
                <ul>
                    <li>Removed based on your selections and clicking the <strong>Remove</strong> button</li>
                </ul>
                <li><strong>Partially Installed</strong> - displays a list of all the mods that are partially installed and must be</li>
                <ul>
                    <li>Cleaned up based on your selections and clicking the <strong>Clean Up Selected</strong> button</li>
                </ul>
                <li><strong>Cannot Install</strong> - displays a list of all the mods that cannot be installed, either due to Bad Targets or Missing files, that can be</li>
                <ul>
                    <li>Deleted from your mods folder based on your selections and clicking the <strong>Delete Selected</strong> button</li>
                </ul>
                <li><strong>Select</strong> - added in TNG v12 - displays a list of all the mods that can be selected regardless of status and then just returns those mods in the list</li>
                <ul>
                    <li>The <strong>Delete</strong> button will only be available on the Select list if you Allow Delete Selected of Partially Installed Mods and Allow Delete of individually Installed Mods. This capability was added mainly for the mod
                        developer to clean up their testing environments.
                    </li>
                </ul>
            </ul>
        </td>
    </tr>

    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Top</a></p>
            <a name="options"><p class="subheadbold">Options</p></a>

            <p>The Options allows you to specify some of the Mod Manager behavior for the
            <p><strong>Mod Manager Log Options</strong>
            <ul>
                <li><strong>Log File Name</strong> - allows you to specify the file name to be used for the Mod Manager log. The default is <strong>modmgrlog.txt</strong>.</li>
                <li><strong>Max number of Transactions</strong> - allows you to specify how many log transactions to keep in the log. The default is <strong>200</strong> transactions.</li>
                <li><strong>Collapse Log display</strong> - allows you to specify if you want the View Log displayed in a collapsed or expanded format initially. The default is <strong>Yes</strong> but can be changed to <strong>No</strong> to display the
                    log expanded normally.
                </li>
                <li><strong>Redirect to Log For</strong> - allows you to specify if you want go to the Mod List to be redirected to the View Log on <strong>Errors Only</strong> or for <strong>All Transactions</strong>. The default is to redirect on
                    <strong>Errors Only</strong> which displays the View Log only if errors are encountered in the install, uninstall, clean up, or delete transaction.
                </li>
                <li><strong>Log full path for file actions</strong> - allows you to select No to only display the relative path for files in the log. The default is <strong>Yes</strong> to display the full absolute path.</li>
            </ul>
            </p>
            <p><strong>Display Settings Options</strong>
            <ul>
                <li><strong>Sort Lists by</strong> - allows you to specify on which column to sort the Mod List. Options are Mod Name or Config File Name. The default is <strong>Mod Name</strong>.</li>
                <li><strong>Use Fixed Headers</strong> - allows you to change the option so that fixed headers are not displayed. This option is not noticable if you have a large monitor and few mods. The default is <strong>Yes</strong> to display the
                    fixed headers. Note that regardless of this option setting, fixed headers will not be displayed for smart phones (mobile mode).
                </li>
                <li><strong>Adjust Fixed Headers</strong> - allows you to enable the adjust fixed headers jQuery when the fixed headers are not displayed correctly. This option is only needed on certain monitors. The default is <strong>No</strong> to not
                    use the jQuery javascript to adjust the fixed headers.
                </li>
                <li><strong>Use Stripes</strong> - allows you to change the option not to use stripes when displaying the Mod List. The default is <strong>Yes</strong> which uses the databackalt class to provide alternate color striping after N number of
                    rows.
                </li>
                <li><strong>Stripe after number of rows</strong> - allows you to set the number of rows to display before the alternate color stripe is displayed. The default is <strong>3</strong> rows of databack and then 3 rows of databackalt.</li>
                <li><strong>Remove spaces from file names in Mod List:</strong> - allows you to remove the blanks from the Mod Names before displaying them in the Mod Name list. The default is <strong>No</strong> which will display the embedded blanks in
                    the Mod Name which should match the TNG Wiki article name.
                </li>
                <li><strong>Show Analyze TNG Files tab</strong> - allows you to specify if you want the Analyzer TNG Files tab to be displayed. The default is <strong>No</strong> which is to suppress the display of the Analyze TNG Files tab.</li>
                <li><strong>Show Other Developer tools</strong> - allows you to specify if you want the View Parser Table tab to be displayed. The default is <strong>No</strong> which is to suppress the display of the View Parser Table tab. This option
                    also controls whether a click on the Mod Name will display the Parser Table for that specific mod, and whether a click on the Config File Name will show the config file in another tab.
                </li>
                <li><strong>Show Recommended Updates tab</strong> - allows you to specify if you want the Recommended Updates tab to be displayed. The default is <strong>No</strong> which is to suppress the display of the Recommended Updates tab. Note that
                    this tab should not be necessary if you did the TNG v12 cust_text.php upgrade.
                </li>
            </ul>
            </p>
            <p><strong>Other Options</strong>
            <ul>
                <li><strong>Allow Delete Selected on Partially Installed Mods</strong> - enables the <strong>Delete</strong> button on the Partially Installed filtered list screen that allows deleting more than one mod at a time, such as deleting the prior
                    versions of mods that were not deleted prior to installing the newer versions. The default is <strong>No</strong>. We recommend that you only enable this option when you need it to delete multiple mods without having to uninstall the
                    current versions to delete the prior versions of the mod when you forgot to Uninstall and Delete previous versions of the mod before installing a new version and that you normally leave this option set to No and reset the option to No
                    after you deleted previous versions of the mod that show as partially installed.
                </li>
                <li><strong>Allow Delete of individually Installed Mods</strong> - allows you to turn on the option to display a Delete button next to the Uninstall button for individually installed mods, such as deleting the prior version of a mod that
                    was not deleted prior to installing the newer version. We recommend that you only enable this option when you need it to delete a previous version of a mod without having to uninstall the current version in order to delete the prior
                    version and that you normally leave the option set to <strong>No</strong> and reset the option to No after you deleted previous versions of the mod that show as installed..
                </li>
                <li><strong>Allow Delete support folder when mod is deleted:</strong> - allows you to turn on the option to delete the folder(s) associated with a mod when deleting the mod. The default is <strong>No</strong>. We recommend that you only
                    enable this option if you understand the risk that unintended folders could be deleted. We believe this risk is very small..
                </li>
            </ul>
            </p>
        </td>
    </tr>

    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Top</a></p>
            <a name="analyze"><p class="subheadbold">Analyze TNG Files</p></a>

            <p>Created by Rick Bisbee this tool located under the <strong>Analyze TNG Files</strong> tab was previously provided as a mod. This tool lets developers examine mods to see precisely how they interact with each other. Two mods changing the same
                block of code almost always results in Mod Manager errors. You must enable the <strong>Show Analyzer TNG Files tab</strong> by setting the Options to Yes if want the Analyze TNG Files tab to be displayed.</p>

            <p>The analyzer works by examining every mod in the mods folder and cataloging which target files and which blocks of code each one modifies. It then lists the affected file names in the left hand column. Selecting one of those target files
                displays a list on the right showing all the mods that change it. Each mod shown on the right has a link to open a section of the page displaying the actual modifications made by the Mod Manager Config file. A user can compare changes to
                the target file to see where potential conflicts might be. </p>
            <p>This is helpful not only to find conflicts between two mods but also to know which mods need to be cleaned up and re-installed after replacing the given target file. </p>

            <p>The TNG Wiki provides additional information for the mod developers on <a href="https://tng.lythgoes.net/wiki/index.php?title=Using_the_Mod_Analyzer" target="_blank">Using the Mod Analyzer</a>.</p>
        </td>
    </tr>

    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Top</a></p>
            <a name="parser"><p class="subheadbold">View Parser Table</p></a>
            <p>This tool is designed mainly for developers. The Parser Table shows how the Mod Manager parsed the mod config file (.cfg) for processing its components into a table, which is then passed to other mod manager scripts for further processing.
                If there is a problem with a mod, the first place to check is the parse table to see if all the mod's directives and arguments are being captured properly.</p>

            <p>You can use this tab to select a mod from a list whose table you want to view, or alternatively you can click on the mod name in the Mod List to view the parse table for that mod, if you enabled the Show Other Developer Tools option.</p>

            <p>Displaying this tab is optional. To use it select 'Display Settings/Show Other Developer tools' on the options tab. If the tab option is turned off, the link on the listing page will also be disabled.</p>

        </td>
    </tr>

    <tr class="databack">
        <td class="tngshadow">

            <p style="float:right"><a href="#top">Top</a></p>
            <a name="custtext"><p class="subheadbold">Recommended Changes</p></a>
            <p>The Recommended Changes tab is an optional tab that can be enabled in the Options screen that allows you to update your cust_text.php files if you did not do so as part of the TNG upgrade readme.</p>
            <p>It is intended to be used if a mod cannot be installed because it is looking for the new comment string at the top of the cust_text.php files starting with TNG v12. The option will be turned off when you click the Update button to change
                your existing cust_text.php files. The code checks whether the files have previously been updated.</p>

        </td>
    </tr>

</table>
</body>
</html>
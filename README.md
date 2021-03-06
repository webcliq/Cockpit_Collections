# Cockpit_Collections
This is an alternative Collections module for Cockpit CMS implementing [DataTables](https://datatables.net/). DataTables is a plug-in for the jQuery Javascript library. It is a highly flexible tool, based upon the foundations of progressive enhancement, and will add advanced interaction controls to any HTML table.
# Prerequisites
You will need to have installed the Cockpit CMS system before attempting to use this module. The Module accompanies the latest version of [Cockpit](https://github.com/aheinze/cockpit), known as Cockpit Next. For more detailed information about Cockpit please visit their [website](http://getcockpit.com/).
#Installation
Download the ZIP file and extract the contents to a temporary directory. The sub-directory, entitled Collections, should be copied to the \addons subdirectory of the Cockpit installation. The existing Collections sub-directory, which will be found in \core, should be removed.

    Copy \Collections to \[cockpit directory]\modules\addons
    Remove \[cockpit directory]\modules\core\Collections

#Installation Tip
As a result of helpful feedback from developer users, I believe the following tip to aid installation will be helpful.

As we do not yet have a working data and parameters import system and indeed, in some ways, that perverts the basic idea of a Cockpit system, it may be difficult to get to a point where you can evaluate the potential benefits of using DataTables with Cockpit without taking a few shortcuts.

The problem is that DataTables generates an error when used if no columns are configured, although it happily handles the lack of data. As the Cliq_Collections Documentation explains, the columns have to be configured in the Options of the Collection and logically these need to match the fields in the Collection.

For the purposes of evaluation and an aid to getting started, I propose that you do the following:
Create 4 Collections -

1. name: site, label: Configuration, field: reference
2. name: string, label: Strings, field: reference
3. name: help, label: Help, field: reference
4. name: section, label: Sections, field: reference

Set each one to displayed by DataTables. 

Now copy (and overwrite) the four parameter files from \modules\addons\Collections\assets\parameter_files to \storage\collections.

Now you should be able to refresh the Collections display and check-out a Collection, with its options and fields. Also, a DataTable should now display, albeit without any data.

#Documentation
Comprehensive documentation is provided with the module. Click on the Documentation button which will be found on the new Collections Home Page in order to read the Documentation in PDF form. The Documentation files can be found in \[cockpit directory]\modules\addons\Collections\assets\docs.
#Helpers and Additions
In the same assets folder you will find two sub-directories - \i18n and \parameter-files. 

In the first you will find two Cockpit language files that have already been modified to included the necessary language prompts for the module. If you need to use them, please copy them to the main Cockpit i18n location. We woiuld be grateful to receive translations for other languages to distribute with the Collections Module.

In the second sub-directory are the Collections parameters files that were used for the construction and testing of the Module. You may wish to use them.
#License
This project is licensed under the MIT License.
# Acknowledgements
Clearly the Cliq Collections Module is a modification to the existing Collections Module supplied AgentJo (Artur Heinze).

Equally, the whole purpose of the Module was to improve the existing Collections display by implementing the DataTables facilities.

Finally, the other person to acknowledge is Jos de Jong who produces the [JSON Editor](https://github.com/josdejong/jsoneditor).

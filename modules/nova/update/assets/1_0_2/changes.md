### Nova 1.0.3
* added the 1.0.3 update file
* updated the install data
    * menu items
    * version info
* updated the language files
    * [base\_lang] added labels_you
    * [text\_lang] added character_change
* updated the versions array file
* updated the ajax controller to have a separate method for removing NPCs instead of piggybacking off of the delete character method
* updated the characters controller to put the NPC removal inside its own method instead of using the character removal process
* updated the posts model to clean some code up and added a parameter to the unattended posts method
* updated the dynamic form management pages (bio, docking, specs) to show notices if there are no fields in a section
* updated the panel tabs on the control panel to display a notice if there's no content available
* updated thresher to use the proper regions in the template config file
* updated the user deactivation process to deactivate a users' characters at the same time
* updated the update center to show the links to start the update regardless of whether there's information about the update or not
* updated the auth library to add some debugging code to help track down the remember me bug
* updated the process of updating the system to remove dependence on the versions array file and instead pull a listing of the update directory (we still use the versions array file in the event the directory listing fails)
* fixed bug where the create wiki entry page wasn't showing up in the sub navigation menu
* fixed bug where the posts model wasn't accurately counting unattended posts when a character ID was passed in as an integer instead of array
* fixed bug where errors were thrown when deleting characters and NPCs
* fixed an error being thrown on the write mission post page
* fixed bug where the post notification stayed active even after the post had been updated and/or sent out
* fixed errors that were thrown when adding a rank
* fixed error thrown when there are no fields in a specs form section
* fixed error thrown in the dashboard
* fixed bug where wiki pages were being put in the uncategorized section even if they had categories
* fixed error thrown for missing option parameters
* fixed error thrown during accepting/rejecting a docked ship application
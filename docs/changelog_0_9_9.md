* added the 0.9.9 update file
* updated the versions array file
* updated the install data
* version info
* component info
* permanent credits message
* system email on by default
* menu items
* updated the shiloh skin
* [main] updated the stylesheets
* [wiki] added the wiki section
* updated the pulsar skin
* [admin] added a new small loading circle graphic
* [admin] added styles for upload close and list-grid
* [main] updated the structure stylesheet
* updated the nova license
* updated the language files
* updated the sms config file with directions about what each item is for
* updated to jquery ui version 1.8
* updated the constants config file with a constant for defining whether something is an ajax request
* updated several ajax methods that were vulnerable to outside hijacking
* updated several ajax methods to get the final order integer better
* updated the all news page to handle the lack of news better
* updated the contact page to not show the form if email is disabled
* updated the wiki manage categories page to show a message if there aren't any categories
* updated the wiki view page to only show the revert option if A) there's more than 1 draft and B) the draft row isn't the current page draft
* updated the wiki revert draft functionality to put a generic update message in place
* updated the write mission post page to check for missions and allow admins to create to create them right there
* updated the write mission post page to be able to set an upcoming mission to current on the fly if there aren't no current missions
* updated site settings to change the way the date format setting works
* updated the check for an external bio image to be a little safer
* updated the characters listing to make the tables display better
* updated the npcs listing to make the tables display better
* updated the upload controller to now allow _, - or = in the name of uploaded images
* updated the edit character bio page to handle images in a whole new way and with lots of fun ajax stuff
* updated upload management page to have a link to upload images
* updated mission management with new image upload management code
* fixed bug in the upgrade controller where an error would be thrown in certain circumstances
* fixed bug with adding bio dropdown values
* fixed bug where adding a deck and immediately trying to re-order it wouldn't work (#93)
* fixed error thrown when editing a specs field because of a misnamed array index
* fixed error thrown when editing a tour field because of a misnamed array index
* fixed error thrown when editing a docking field because of a misnamed array index
* fixed bug where adding a docking field dropdown value then immediately updating them would trigger multiple animations
* fixed bug where adding a specs form field dropdown value then immediately updating them would trigger multiple animations
* fixed bug where adding a tour form field dropdown value then immediately updating them would trigger multiple animations
* fixed bug where adding a bio form field dropdown value then immediately updating them would trigger multiple animations
* fixed bug where the description for wiki categories couldn't be edited (#92)
* fixed bug where external images wouldn't display in character bio pages (#91)
* fixed bug where gallery wouldn't work unless there were 3 images
* fixed bug during install caused by not loading a library
* fixed bug during update caused by not loading a library
* fixed bug where reverting a wiki page wiped out the categories for the draft
* fixed bug where adding an int field would error out because it tried to put a default value in (#94)
* fixed bug where in certain situations an error could be thrown pulling online users
* fixed bug where a character's user id was wiped out during the approval process
* fixed IE8 display issue with the control panel
* fixed bug where error was thrown when rejecting an application (#98)
* fixed bug where the post model wasn't taking one of the post author string potentials into account (#96)
* fixed bug where the email language file wasn't extensible (#97)
* fixed bug where creating an award wouldn't have a display set by default
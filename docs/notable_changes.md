# Notable Changes in Nova 3

## Setup

* Nova is now a lot smarter about figuring out exactly what you want to do, (hopefully) giving you exactly the action you want to do. Now, instead of giving you some generic options, Nova uses a range of clues in your database to present you with either the option to do a fresh install, update Nova 3, upgrade from Nova 2, or show you the setup utilities.
* When checking for updates, Nova now respects both the admin's setting for which updates to show as well as any version update that's being ignored.
* A version can be ignored from the setup module instead of just from the admin control panel.

## Log In

* Resetting your password now lets you set the password you want. Nova will then email you a confirmation link. If you log in before going to the confirmation page, the reset will be wiped out, otherwise, your password will be updated.
* All-new lockout code now knows if you're locked out before you try to log in.
* Lockout attempts and lockout time can now be set by an admin from Advanced Site Settings.

## Site Management

* Site Settings now contains only the items that would be most frequently updated. A new Advanced Site Settings will give admins control over the full range of settings Nova has to offer.

## Form Management

* Each form can have its orientation set to be vertical (label on top then the field, the default) or horizontal (label to the left, field to the right).
* Each form field can now have its own help text that will be displayed beneath the field (or next to it if the form is in horizontal orientation).
* Adding, editing, and removing field values is a lot cleaner and more intuitive.
* Different types of fields may hide or show options unique to that type of fields (e.g. rows with text areas).
* Any form can have tabs now.
* Drag-and-drop re-ordering of fields, sections, and tabs.
* Nova will do a wide range of calculations to determine if it should disable sections and/or tabs when fields are deleted/updated. The goal is to make sure that if a section doesn't have any active fields any longer, it should automatically be disabled and then re-enabled automatically when fields are made active or added.

## Characters

* Characters can now hold an unlimited number of positions.

## General

* Nova now allows admins with the proper privileges to edit page headers and page messages right from the page in question. Just click on the content, make your changes, then click Save. Admins can also go to the Site Content management page and make changes from there as well. (Page titles can only be edited from the Site Content management page.)
* The Chain of Command feature has been removed from the Nova core and shifted to a first-party module. More information about this will be available in the future.
* The Docking feature has been removed from the Nova core and shifted to a first-party module. More information about this will be available in the future.
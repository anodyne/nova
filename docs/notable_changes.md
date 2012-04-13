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

## Characters

* Characters can now hold an unlimited number of positions.

## General

* Nova now allows admins with the proper privileges to edit page headers and page messages right from the page in question. Just click on the content, make your changes, then click Save. Admins can also go to the Site Content management page and make changes from there as well. (Page titles can only be edited from the Site Content management page.)
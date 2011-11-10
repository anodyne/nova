## Join Page

* A user should be asked for their email address first. Once they've filled that in, an Ajax call should check to see if that email address exists in the system. If it does, it won't show the name and password fields since those fields are obviously going to be ignored. If the email address doesn't exist in the system, it will show the name and password fields so they can fill them out.

## Dynamic Forms

* Add a field to the database that admins can write help content in. If that field isn't empty, display a question mark icon that when hovered over, shows the help information.
* Proper validation on all fields.
* Fields that only admins can see and edit.

## Awards

* Rename from Crew Awards to Awards
* Categories should actually be called type
* Add the ability to create actual categories to sort awards by different types (level 1, level 2, battle awards, exploration awards, etc.)

## Specs

* Specs needs to be completely overhauled to be more flexible
* Specs should be separated in to tabs
    * Specs
    * Deck listing
    * Tour items
    * Related items (shuttles, etc.)
    
## Catalogues

* If a skin has default sections in it, you shouldn't be able to remove or deactivate it
* Move setting skin defaults into the catalogue instead of Site Settings (?)

## Site Content

* Page titles, headers and content will all be stored in the database and then cached by section so that we can use that content throughout the system without putting a ton of stress on the database with constant calls.
* When any site content is changed, we'll delete the cache and re-cache it automatically.
* Using Kohana's caching system, we'll be able to cache all sub navigation menus for fewer calls to the database.
* When a menu item is updated, we'll delete the cache and re-cache it automatically.

## Access

* There will be 4 access roles provided by default: system administrator, power user, standard user, inactive user. They will be protected so they can't be deleted and will have constants for their IDs in the access role model.
* A warning will be shown when duplicating the system administrator role that it contains a lot of power and caution should be used.
* Need to be able to lock a player out of being able to get a lock on a post (maybe through moderation?)
* When logging in, Nova will check a user's status and if their status is INACTIVE, it will automatically set the access roles to the INACTIVE role instead of whatever role is stored in the database for them.

## Framework

* Use Bootstrap for as many components as possible to get rid of the bulk of jQuery UI.

## Settings

* Set the login attempts through Site Settings.
* Set the login lockout period through Site Settings (set in minutes, calculates to seconds in the Auth class).
* Set the template meta data through Site Settings.

## Users

* Clear a user's login lockout.
* Admins should be able to clear a user's login lockouts.

## Manifest

* Like SharePoint list views, you should be able to create different "views" for the manifest and be able to set criteria for those views. This would allow users to create different views for different manifests to show what they want.
* Views should be able to pull any information from the character and user sets of data.

## Application Review System

* When an application is received, it's thrown in to a review system where approved users can comment on an application and ultimately vote YES, NO or NO DECISION on the application.
* Rules can be set for applications.
    * If an application is received for any departments, add User A to the review process.
    * If an application is received for Departent A, add User B to the review process.
    * If a rule has no users, the state of the rule needs to be changed to INACTIVE so that it won't be triggered by an application.
    * If User A is on LOA or ELOA, they shouldn't be added to the review process.
    * When a user is deactivated, they need to be removed from all rules.
* Does this mean we can't ever delete characters or users? Without it, there would be no access to the history of applications. (If not, we might be able to store an application as XML and then when they're accepted, move them in to the database.)
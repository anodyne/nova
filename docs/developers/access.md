## Model_Access_Role::INACTIVE

Nothing.

## Model_Access_Role::USER

* Log in
* Send/receive messages
    * Messages - Read - 0
    * Messages - Create - 0
    * Messages - Delete - 0
* Update their account
    * User - Edit - 1

## Model_Access_Role::ACTIVE

Parent: Standard User

* Update their character(s) bio
    * Character - Edit - 1
    * Character - Read - 1
* Create mission entry/personal log
    * Post - Create - 0
    * Log - Create - 0
* Create comment on any content
    * Comment - Create - 0
* Upload photos
* Create new NPCs
    * Character - Create - 1
* Edit their own mission entries/personal logs
    * Post - Edit - 1
    * Log - Edit - 1
* Create wiki pages
    * Wiki - Create - 1
* Edit their own wiki pages
    * Wiki - Edit - 1
* Request LOA
    * User - Edit - 1 (already have from inherited role)
* Nominate other users/characters/content for awards
* View sim stats
    * Report - Read - 1
* View milestone report
    * Report - Read - 1
* Writing control panel

## Model_Access_Role::POWERUSER

Parent: Active User

* Edit/revert any wiki page
    * Wiki - Edit - 2
* Edit any NPC
    * Character - Edit - 2
    * Character - Read - 2
* Create announcement
    * Announcement - Create - 0
* Edit their own announcements
    * Announcement - Edit - 1
* View crew activity report
    * Report - Read - 2
* View posting report
    * Report - Read - 2

## Model_Access_Role::ADMIN

Parent: Power User

* Edit any announcement/personal log/mission entry
    * Post - Edit - 2
    * Log - Edit - 2
    * Announcement - Edit - 2
* Edit wiki categories
    * Wiki - Edit - 3
* Give/remove an award to a user/character/content
* Delete any wiki page
    * Wiki - Delete - 1
* Delete any wiki category
    * Wiki - Delete - 2
* Create/edit/delete character (unless the character has content associated with it)
    * Character - Edit - 3
    * Character - Delete - 0
    * Character - Read - 3
* Edit any user
    * User - Edit - 2
* Manage uploads
* Edit/delete comments
    * Comment - Edit - 0
    * Comment - Delete - 0
* View LOA report
    * Report - Read - 3
* View award nomination report
    * Report - Read - 3

## Model_Access_Role::SYSADMIN

Parent: General Admin

* Create user
    * User - Create - 0
* View system events
    * Report - Read - 4
* Notified of new system updates
* Create/edit/delete site ban
    * Ban - Create - 0
    * Ban - Edit - 0
    * Ban - Delete - 0
    * Ban - Read - 0
* Create/edit/delete positions
    * Position - Create - 0
    * Position - Edit - 0
    * Position - Delete - 0
    * Position - Read - 0
* Create/edit/delete ranks
    * Rank - Create - 0
    * Rank - Edit - 0
    * Rank - Delete - 0
    * Rank - Read - 0
* Create/edit/delete departments
    * Department - Create - 0
    * Department - Edit - 0
    * Department - Delete - 0
    * Department - Read - 0
* Create/edit/delete catalogue items
    * Catalog - Create - 0
    * Catalog - Edit - 0
    * Catalog - Delete - 0
    * Catalog - Read - 0
* Create/edit/delete forms
    * Form - Create - 0
    * Form - Edit - 0
    * Form - Delete - 0
    * Form - Read - 0
* Create/edit/delete menus
    * Menu - Create - 0
    * Menu - Edit - 0
    * Menu - Delete - 0
    * Menu - Read - 0
* Create/edit/delete roles
    * Role - Create - 0
    * Role - Edit - 0
    * Role - Delete - 0
    * Role - Read - 0
* Create/edit site content
    * Content - Create - 0
    * Content - Edit - 0
    * Content - Delete - 0
    * Content - Read - 0
* Create/edit site settings
    * Settings - Create - 0
    * Settings - Edit - 0
    * Settings - Delete - 0
    * Settings - Read - 0
* Create/edit/delete specs
    * Specs - Create - 0
    * Specs - Edit - 0
    * Specs - Delete - 0
    * Specs - Read - 0
* Create/edit/delete tour items
    * Tour - Create - 0
    * Tour - Edit - 0
    * Tour - Delete - 0
    * Tour - Read - 0
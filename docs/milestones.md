# Milestones

## M1 - Architecture and Setup Systems

M1 lays the foundation for the rest of Nova 3. The biggest change is the move off of CodeIgniter to FuelPHP. This PHP 5.3 framework provides a larger toolset than CodeIgniter and the added benefit of some of PHP 5.3's features to make this faster, more efficient, and better all around. In addition, we are transitiong off of a homemade authentication library and replacing it with a third-party authentication package (which we've significantly modified). The authentication change has forced us to revisit how we reset passwords as well, so because of that, the entire log in system needed to be built.

* Authentication
* Installation
* Upgrade from Nova 2
* Update within Nova 3
* Transition to FuelPHP from Kohana

## M2 - Character/User Systems

Arguably the biggest chunk of Nova 3 development, M2 focuses on the character and user systems and everything that supports those. At first glance, it doesn't seem like much, but when you dig deeper, you realize that a lot of pieces in Nova support the character and user systems. Everything from dynamic forms to access roles to file uploads need to be built as part of this milestone. The goal is that by the time M2 is complete, a tester should be able to do anything and everything they need/want to with characters and users.

* Dynamic forms
    * Join
    * Character bio
    * User bio
* User management
* Character management
* Image upload and management
* Manifests and manifest views
* Access role management
* Request LOA

## M3 - Posting Systems

M3 targets the posting systems in Nova. This is where most users spend the most time, so it's important to spend time getting it right. There are some significant changes happening "under the hood" that need to be accounted for as well as some user experience changes to how posting is handled. The biggest feature being added to the posting system is the ability to rate posts and logs.

* Mission posts
* Personal logs
* Announcements
* Commenting
* Missions and mission groups
* Post and log ratings

## M4 - Messaging System

* New inbox
* Writing messages
* Replying to messages
* Forwarding messages
* Contact form to messages

## Report Center
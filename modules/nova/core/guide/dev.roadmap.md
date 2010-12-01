# Nova 2 Development Roadmap

With Nova 1's development, we moved to a milestone-based system that allowed us to bite off sections of the system at a time and focus on, for instance, just the private messaging system. The milestone-based approach was a great way to do development and provided the community with specific things we were working on and things they could keep track of. Unfortunately, focusing on one section at a time meant that even if users could see the manifest in M2, they couldn't do anything with it until M6. That was frustrating for the community and us as we were constantly getting bug reports of pages not working that we knew weren't supposed to work.

For Nova 2, we're moving away from a rigid "work on this section" approach and moving to a more fluid "work on features X, Y and Z" approach that'll make it easier for the community to use new milestone builds as they're done. The following list is a partial list of how we've laid out the first few milestones. More information will be added on later milestones as we get closer.

## Milestone 1

The focus of M1 is on the infrastructure of Nova 2. This includes getting Kohana 3 set up and running with all the additional modules and components needed, like porting CodeIgniter's Database Forge feature over to KO3. In addition, M1 will be considered complete when a user can do a fresh install, update from Nova 1, update from Nova 2.x up to a newer version and upgrade to Nova 2 from SMS 2.

*Status:* **COMPLETED**

## Milestone 2

The focus of M2 is on authenticating to the system. In layman's terms, this means being able to log in to the system. The biggest component involved in this is the creation of the Auth library (or rather the porting of the library from Nova 1 to Nova 2). In dealing with authentication, we'll also need to deal with being able to reset passwords and prompting the user to change their password after they've reset it then logged in with the new password.

*Status:* **IN PROGRESS**

## Milestone 3

The focus of M3 is on the user and characters systems in Nova 2. Several of these systems are undergoing major changes, so it's important to take the time to get these things right as they're at the heart of Nova. We want to make user and character management a simple and powerful process. Involved in this is all the user and character listings, including being able to add, edit and delete these items (and yes, that means Nova 2 will allow you to create a new user unlike Nova 1). The dynamic bio form management piece will need to be built (including the addition of radio buttons to dynamic forms). The join page and all the activation pieces that come along with being able to join the RPG.

*Status:* **NOT STARTED**

## Milestone 4

The focus of M4 is the posting system. The posting systems in SMS and Nova have been relatively unchanged over the years and we want to make sure we're taking a critical look at these systems to make sure they're as awesome as possible. Nova 1 brought about the ability to add as many people to a JP as you want and we want to expand on that a little further and make sure the posting system is rock solid. In addition, we're going to take a stab at "locking" a post when someone is editing it to prevent multiple people from updating it at the same time. Minor changes will include things like expanding textareas on the posting pages and a native mechanism to archive posts to an external list.

*Status:* **NOT STARTED**

## Milestone 5

The focus of M5 is private messaging. Our goal with private messaging in Nova 2 is to make it as killer a feature to use as possible. This will include a brand new, highly revolutionary interface. In addition, we're going to start creating conversations, much like Gmail, in Nova 2's messaging system. The goal is that when you hit reply, it'll automatically get added to the string of conversations so you'll be able to take a quick glance and see all of the messages you've had with the person(s). Lots more details on this as we get closer.

*Status:* **NOT STARTED**
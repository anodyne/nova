# The Anatomy of Nova 3's Access Control System

Through the years, we've toyed with a wide range of access control means, working hard to make it incredibly flexible and powerful while still retaining an ease-of-use that didn't make it a chore to manage access and permissions throughout the system.

In its earliest forms, SMS 1.2 used a simple 1-5 numerical value for access. It was simple, but if you wanted to grant someone access to another area of the system, you didn't have a lot of wiggle room. SMS 1.5 expanded that to 9 different values, so there was a wider range, but still pretty limited. In later versions of SMS 2, we moved to a system where each user had custom permissions, but doing that made it tough to make sweeping changes. As SMS 2 drew to a close, we added the option to set default levels for a few hard-coded groups. This was the beginning of a move to a more formalized access control system.

Nova 1 ushered in a real role-based access system that relied on giving users a role. Those roles contained pages that dictated what a role could and couldn't do. For the majority of situations, this worked well, but it lacked true granularity that would give admins even more control over access and permissions. In Nova 3, the old access control system has been expanded to make it both more granular as well as flexible. Additionally, it provides third-party developers an easier interface to add their own permissions and use them as they see fit in their mods.

## Roles

At the highest level, a user is assigned a single role, just like previous versions of Nova. That's where the similarities end though. In addition to shipping with more roles by default, Nova 3 uses an inheritance model to make sure that a role is as simple as possible.

### Inheritance

The basic idea is that the the highest role inherits the majority of its tasks from lower roles. This system of inheritance means that if an admin wants to make a change for everyone, that change can be made at the lowest possible level and it will filter "up" to every role above it. Of course, admins can break that inheritance if they want, but in 99% of cases, that won't be necessary.

## Tasks

In Nova 1 and 2, every role was made up of pages. Unfortunately, this was a pretty rigid structure that quickly bloated (Nova 2 ships with 66 page records). In Nova 3, each role is made up of tasks. Not only is this a more flexible system, but it allowed us to reduce the number of dependent items a role has to look at. Each task is made up of several different pieces that come together to make a highly flexible and granular system to give admins ultimate control.

### Components

Every task has a component which are general areas found throughout the system. An example is the __form__ component. In Nova 2, each form had its own individual access piece. In Nova 3, all forms are under one piece. Why? Simply put, it's easier. (Additionally, we felt that any situations where an admin wants to give one person access to just one form would be a fringe case that we were okay not covering.) Other components include post, log, announcement, missions, reports, etc.

### Actions

Once you've stepped in to a component, the next piece is the action. There are four major actions in Nova 3: create, read, update, and delete (CRUD). These are the actions you can take with any of the components. This means that a user can have permissions to edit something, but not to create new items or delete existing items. Some components have all four, others only have one or two. There's no rigid structure to what must be included in a task.

<dl>
	<dt>Create</dt>
	<dd>Allows a user to create items.</dd>

	<dt>Read</dt>
	<dd>This varies from component to component, but it has everything to do with admin-side things, not non-admin side things.</dd>

	<dt>Update</dt>
	<dd>Allows a user to edit items. In some cases, this includes approving and rejecting items as well.</dd>

	<dt>Delete</dt>
	<dd>Allows a user to delete items. In some cases, there are restrictions about what can and can't be deleted.</dd>
</dl>

### Levels

Within each action, you can have a wide range of levels. Generally, this is one or two levels to allow finer control of what someone can do within an action. Take the _update_ action inside the __post__ component. There are two levels, the first which allows someone to edit their own posts and the second which allows someone to edit all posts.

## 3rd Party Developers
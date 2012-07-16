# Doing a Fresh Install of Nova 3

New to Nova 3 is the setup module, a single place for installing, upgrading, updating, and any utilities you need for managing your Nova installation. The goal of the setup module is to not only be a single point for setup operations, but to make Nova smarter in how it offers up options to you. If you poke around, you'll probably notice that the setup module just kinda knows what you want to do when you get there. We've worked hard to build in a huge amount of logic to make sure that we're offering the most logical choice given the information we have. The result should be a setup experience that eclipses SMS and any previous version of Nova.

## System Requirements

We've tried hard to make sure Nova's requirements are as minimal as possible. We want everyone to be able to use Nova. That being said though, there are some requirements. Nova comes with a file called `install.php` which you can run by going to `http://yoursite/install.php`. This file will run some tests on your server to make sure you can run Nova 3. If something fails, you'll be told what failed and how to fix it (in most cases, it involves talking to your host unfortunately). If your environment passes all the tests, you'll be all set to proceed.

For those who are curious, Nova 3 requires a web server running PHP 5.3 or higher, MySQL 5 or higher, and a standards-compliant browser with JavaScript enabled. Currently, Nova 3 runs on Google Chrome 10 or higher, Firefox 4 or higher, or Internet Explorer 9 or higher.

<p class="alert alert-info"><strong>Note:</strong> IE 9 requires Windows Vista or higher and we realize there may be some people that don't have the ability to upgrade their operating system. For those people, we recommend using Google Chrome or Mozilla Firefox instead.</p>

## Database Setup

Like the previous version, the first thing Nova will do is check for the existence of the database connection file. This is what tells Nova where to look for all your information. (If you're doing a fresh install, there won't be anything there, but that's important information for Nova to know.) Once you're inside the setup wizard, you'll be prompted to enter your database name, database username, database password, and database location. These are pieces of information your host should have provided to you. If you don't remember them or can't find them, contact your host to provide you with that information.

After plugging the information in, Nova will attempt to connect to the database. This is an important part of the process because if something is wrong, Nova will be able to tell you immediately what's wrong so you can correct it. This eliminates putting the wrong information in and then getting cryptic error codes from the database. If you put the information in correctly, you'll be told that you can write the connection file to your server. Once that's complete, you'll be sent on to the next step in the setup process.

## First and Third-Party Modules

New to Nova 3 are modules. Several features that were previously integrated into the core are now first-party modules. Additionally, members of the Anodyne community have third-party modules to further expand Nova's functionality. Using QuickInstall, you can have modules installed with Nova simply by uploading them to the `app/modules` directory. Nova will recognize the QuickInstall file and install the necessary components.

## Installing

Doing a fresh install of Nova 3 couldn't be much easier unless it could read your mind!

The first step of the process, which should take a few minutes to run, will install all of Nova's database tables, put the basic information in, and fill in the genre data (like positions, departments, and ranks). This is the foundation which the rest of Nova is built on.

The next step of the installation involves collecting a little information about the game, you, and your character. After filling out the information, your database will be updated with your user account, your character, and updated settings. Once the system is installed, you'll be able to log in to make other changes if you want.

That's it! Two steps is all we need to get Nova installed and ready to go. Make sure to check out the list of notable changes to Nova 3 and head out to explore your new Nova 3 installation.

Good luck and happy gaming!
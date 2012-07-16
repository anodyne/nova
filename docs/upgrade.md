# Upgrading from Nova 2 to Nova 3

<p class="alert alert-info"><strong>Note:</strong> Nova 3 only provides the option of upgrading from Nova 2. If you're running SMS or Nova 1, please upgrade to Nova 2 and then to Nova 3.</p>

We recognize that many of users have been with us for years now, some as far back as SMS. The idea of upgrading all the information you've collected over years can be daunting, but our goal is to make the process of upgrading to a newer version of Nova as simple and straightforward as possible. Nova 3's new setup module was designed to be a single place for doing anything for managing your Nova installation. Using this module, we've managed to make Nova's setup process smarter than before. When you land on the module, it'll just know what to do based on the information it already has.

## A Word About the Docking Feature

Users who have used the docking feature in the past will probably notice its absence from Nova 3. It isn't gone completely, but we have decided to move it out of the Nova core and into a first-party module. Like ranks and skins though, modules can be installed using QuickInstall. You can download the docking module from AnodyneXtras and upload it to the `app/modules` directory. During the upgrade process, Nova will install the docking module and attempt to upgrade your Nova 2 docking items and form to the Nova 3 format.

## System Requirements

We've tried hard to make sure Nova's requirements are as minimal as possible. We want everyone to be able to use Nova. That being said though, there are some requirements. Nova comes with a file called `install.php` which you can run by going to `http://yoursite/install.php`. This file will run some tests on your server to make sure you can run Nova 3. If something fails, you'll be told what failed and how to fix it (in most cases, it involves talking to your host unfortunately). If your environment passes all the tests, you'll be all set to proceed.

For those who are curious, Nova 3 requires a web server running PHP 5.3 or higher, MySQL 5 or higher, and a standards-compliant browser with JavaScript enabled. Currently, Nova 3 runs on Google Chrome 10 or higher, Firefox 4 or higher, or Internet Explorer 9 or higher.

<p class="alert alert-info"><strong>Note:</strong> IE 9 requires Windows Vista or higher and we realize there may be some people that don't have the ability to upgrade their operating system. For those people, we recommend using Google Chrome or Mozilla Firefox instead.</p>

## Backup

As with all major system updates and upgrades, it's important to do a full database and file backup before you proceed. In the event something goes wrong, you'll have a complete copy of your system to fall back to.

### Database Backup

Using your cPanel, you can access phpMyAdmin and using the Export option. After selecting all the tables, you can export the content as a SQL file which you can save to your desktop for safe keeping.

<p class="alert alert-info">It's a good idea to do this process on a regular basis even if you aren't upgrading so that you have a copy of your database in the event something goes wrong on the server.</p>

### File Backup

You can log in to your server through an FTP client and download all the files in your site to a folder on your desktop. This is a good way to make sure you have a snapshot of your old system before doing any updates. In addition, if you need to access old skins or MODs, you'll have them available on your computer.

<p class="alert alert-info">It's a good idea to do this process on a regular basis even if you aren't upgrading so that you have a copy of your files in the event something goes wrong on the server.</p>

## Database Setup

Like the previous version, the first thing Nova will do is check for the existence of the database connection file. This is what tells Nova where to look for all your information. Once you're inside the setup wizard, you'll be prompted to enter your database name, database username, database password, and database location. These are pieces of information your host should have provided to you. If you don't remember them or can't find them, contact your host to provide you with that information.

After plugging the information in, Nova will attempt to connect to the database. This is an important part of the process because if something is wrong, Nova will be able to tell you immediately what's wrong so you can correct it. This eliminates putting the wrong information in and then getting cryptic error codes from the database. If you put the information in correctly, you'll be told that you can write the connection file to your server. Once that's complete, you'll be sent on to the next step in the setup process.

## Upgrading

Upgrading from Nova 2 couldn't be much easier unless it could read your mind!

The first step of the process should only take a few seconds and will rename all of your tables to have the prefix `nova2_`. This is necessary so that all of the old information can be migrated into a new database. Because of this step, it's important to understand that your database will double in size during the upgrade process. If you host imposes size limits on your database, you'll need to make sure that your database isn't so large that duplicating it would put you over that limit. If you have questions about that, contact your host.

After renaming the existing tables, Nova will do a fresh install to make sure you have all the pieces in place to move forward.

The third step of the process involves selecting which items you want to upgrade. In most cases, the defaults will be fine, but you can select to not upgrade certain components if you want. Depending on how large your database is, the upgrade process could take anywhere between a minute and 10 minutes. There are a lot of things happening in here, including reorganizing a lot of data into a new schema for everything Nova 3 does.

Finally, like the upgrade to Nova 1 (for those who did it), you'll need to choose a system administrator and reset the password for everyone. (This is necessary because Nova 3 moves to a higher level of encryption on passwords.) Once these steps are done, you'll be redirected to your site and be able to start making changes.

Now that your upgrade is finished, you should delete any tables in your database with the `nova2_` prefix to save space on the database server. Since you backed up your database earlier, you already have a copy of that data.

## Wrapping Up

That's it! A few short steps is all we need to get Nova upgraded and ready to go. Make sure to check out the list of notable changes to Nova 3 and head out to explore your new Nova 3 installation.

Good luck and happy gaming!
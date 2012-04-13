# Moving to Another Server

If you want to move your Nova site to another server, you'll have to take a few steps to ensure everything works as expected.

* Export your database to a SQL file through something like phpMyAdmin (likely found in your cPanel). Make sure you save the file to your desktop.
* Download all of your Nova files from your old server to a folder called `nova` on your desktop.
* Go to phpMyAdmin on the new server and import your SQL file into your new database. (phpMyAdmin has an import option at the top once you're inside the database.)
* Upload all of your Nova files from your desktop's `nova` folder to your new server.
* Remove the `app/config/production/db.php` file from your new server. (This means you'll be prompted to go through the config file setup wizard again, but once that's complete, you should be all set.)

## What You Should NOT Do

* Don't try to install a fresh copy of Nova on your new server and then import the data. Nova generates a unique identifier for each installation so the UID for your old site and the UID for your new site will not be the same. The biggest impact this has is on passwords as all passwords are salted with the UID before being hashed. In layman's terms, no one will be able to log in and you'd have to manually update all the passwords.
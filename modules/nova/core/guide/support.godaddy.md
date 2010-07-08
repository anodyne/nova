# Nova 2 and GoDaddy

GoDaddy's shared hosting platform is great for people who want to get up and running with their own website. Unfortunately, dynamic framework-driven systems like Nova tend to have serious problems on GoDaddy servers. To help people combat these issues, the following page is all available information about how to get Nova 2 up and running if you're using a GoDaddy account. (This same information will probably work on other major shared hosting platforms as well.)

## Getting Kohana to Work

Kohana tries to be as smart as possible to figure out what some of its settings should be. Unfortunately, in doing so, the GoDaddy shared hosting platform returns bad information from one of the server variables, causing all sorts of problems. In order to fix this, you'll need to change your boostrap file that's located at <code>application/bootstrap.php</code>. In the file, you'll find a route that looks like this:

<pre>Events::event('preCreate');
$request = Request::instance();
Events::event('postCreate');</pre>

Kohana allows you to pass an array when you instantiate the Request, but if you don't (which is the defualt), Kohana will use some logic to see which node of the $_SERVER array contains the request information. This works fine on most servers, but on shared servers (like Godaddy), the first $_SERVER node (PATH_INFO) checked sends bad information, so to fix it, you just need to pass the Request the correct node. For GoDaddy the node to be used is: REQUEST_URI. Here's how it should look:

<pre>Events::event('preCreate');
$request = Request::instance($_SERVER['REQUEST_URI']);
Events::event('postCreate');</pre>

## Removing index.php From the URL

Sometimes you want to clean up your URLs a little bit and remove the index.php file from your setup altogether. Kohana makes this easy (and even comes with an example <code>.htaccess</code> file), but GoDaddy complicates things a little bit. To get this working, you'll need to change your <code>.htaccess</code> file to look like this:

[!!]This assumes you're installing Nova 2 in the root directory and haven't changed the names of the application, modules and system directories.

<pre># Turn on URL rewriting
RewriteEngine On

# Installation directory
RewriteBase /

# Protect application and system files from being viewed
RewriteRule ^(application|modules|system) - [F,L]

# Allow any files or directories that exist to be displayed directly
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d

# Rewrite all other URLs to index.php/URL
RewriteRule ^(.+)$ index.php?kohana_uri=$1 [L]</pre>
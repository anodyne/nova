# Removing Index.php From the URL

Some people want clean URLs and would prefer not to see the `index.php` in the URL. FuelPHP and Apache offer the ability to rewrite the URL to do just that. If you want to remove `index.php` from the URL, you can do so with a few simple steps.

First, you'll need to create an htaccess file. Nova includes an example file called `example.htaccess`. Simply remove the `example` from the filename so it's only `.htaccess`.

Next, you'll have to modify the `app/config/config.php` file. Find the following line:

<pre>'index_file'  => 'index.php',</pre>

Change that line to:

<pre>'index_file'  => false,</pre>

Now, you can navigate to your site without the `index.php` and everything should work as expected!

## Doesn't Work?

If you're unable to get the rewriting working with the above instructions, there are two options. First, your server doesn't have `mod_rewrite` available. You should contact your host if that's the case. If they ask why you want it, just tell them you're trying to do some URL rewriting for a content management system. Assuming `mod_rewrite` is available, your server may be running FastCGI. The technical details aren't important, but if that's the case (you'll know because you'll get a "No input file specified" error), you can change the htaccess file to the following:

<pre>&lt;IfModule mod_rewrite.c>
    RewriteEngine on

    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d

    RewriteRule ^(.*)$ index.php?/$1 [L]
&lt;/IfModule></pre>
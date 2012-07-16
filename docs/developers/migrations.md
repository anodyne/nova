# Migrations

> __From the FuelPHP documentation:__

> Migrations are a convenient way for you to alter your database in a structured and organized manner. You could edit fragments of SQL by hand but you would then be responsible for telling other developers that they need to go and run them. You'd also have to keep track of which changes need to be run against the production machines next time you deploy.

> The database table `migration` tracks which migrations have already been run so all you have to do is update your application files and call `Migrate::current()` to work out which migrations should be run.

Often modules will only be used to change existing functionality, but there are times where modules will need to make updates to the database either to change existing data or create new tables for your module. Given the expanded use of modules in Nova 3, it was important to provide a standardized way to handle the install and uninstall events for a module. Nova 3 leverages FuelPHP's migrations system to allow you to tell Nova exactly what to do to install your module (and the reverse in order to remove it). As a developer, all you need to do is create your migrations (if you need them) and when a module goes through QuickInstall, it will automatically call your migrations.

That isn't all though. Migrations aren't just useful for installation, but also for updates. If you make major updates to your module which involves changing database tables, creating new tables, or modifying existing data, you can write subsequent migrations that can be run against the database to ensure everything is where it should be.

And just so you don't think we're selling you something we don't believe in: Nova 3's installation and update system is run through migrations.
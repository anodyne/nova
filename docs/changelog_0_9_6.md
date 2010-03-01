* added the 0.9.6 update file
* added the new jquery ui css files
* added the uniform jquery plugin
* added a javascript view for the upload index
* removed the old jquery ui css files
* removed the changes doc
* updated the install data
    * system info
    * system versions info
    * component info
* updated the database schema
    * users::daylight\_savings from enum to varchar
* updated the genre files
    * MOV
    * BAJ
    * ENT
    * TOS
    * KLI
    * ROM
    * BL5
    * AND
    * DS9
* updated the language files
    * [text\_lang] added _text\_dynamic\_emails_
    * [install\_lang] updated _upd\_error\_2_
* updated the sunny skin
    * removed the notes document
    * updated the skin.yml file
    * updated the wiki template file
    * updated the admin template file
    * [admin] updated the images
    * [admin] updated the stylesheets
         * updated the skin stylesheet to match the main section
         * udpated the structure stylesheet to match the main section
    * [wiki] updated the images
    * [wiki] updated the stylesheets
         * updated the skin stylesheet to match the main section
         * udpated the structure stylesheet to match the main section
* updated the titan skin
    * updated the skin.yml file
    * updated the wiki template file
    * [admin] updated the images
    * [admin] updated the stylesheets
         * updated the skin stylesheet to match the main section
         * udpated the structure stylesheet to match the main section
    * [main] updated the stylesheets
    * [wiki] updated the images
    * [wiki] updated the stylesheets
         * updated the skin stylesheet to match the main section
         * udpated the structure stylesheet to match the main section
* updated the dynamic emails to use both sim and ship (ship is left to maintain SMS upgrade compatability)
* updated the way updates are checked to use PHP's version\_compare function
* updated the constants config file
* updated the docking model methods to be listed alphabetically
* updated the jquery ui to version 1.8rc2
* updated the head include files with the new jquery ui css naming scheme
* updated all the skins with the new naming scheme
* updated the user section view files to use the new form layout
* updated the characters section view files to use the new form layout
* updated the skin stylesheets to tweak the new form layout
* updated the manage section view files to use the new form layout on some pages
* updated the site section view files to use the new form layout on some pages
* updated the admin section to clean up some UI inconsistencies
* updated thresher to clean up some UI inconsistencies
* updated markItUp! to version 1.1.6.1
* updated the site settings page to use the form layout
* updated the site settings page to handle rank selection better
* updated the update controller with the registration code
* updated the upgrade controller with the registration code
* updated jquery to version 1.4.2
* updated the controller constructors to cast the daylight savings value as a boolean instead of doing logic against it
* updated files to remove some of the remaining TODOs
* updated the install and upgrade process to try and automatically set the welcome page title
* fixed bug where the site messages always showed the type as page title (#74)
* fixed bug where the system versions accordion broke when there were multiple versions
* fixed bug where the system versions threw an error when only one version was in the database
* fixed bug where thresher threw errors when submitting a page without categories
* fixed bug where thresher still wasn't printing categories properly (should be completely fixed now)
* fixed bug where thresher was missing some language elements
* fixed bug where the rank ajax menus always showed the default rank set (#75)
* fixed bug with the install rank ajax menu where it wasn't passing the right information to the ajax method
* fixed bug with the registration process in the install controller
* added the jquery.ui.mouse file
* added the jquery.ui.widget file
* added the 0.9.4 update file
* updated the mission management page to use the datepicker
* updated the version info in the constants file
* updated the basic install data
    * version information
    * system information
    * jquery component information
    * jquery ui component information
    * removed textboxlist from components list
* updated the database schema
    * added the wiki category description field
* updated the index files in the core directory to use the proper line endings (unix) and encoding (utf8)
* updated the beta skin
    * added the skin.yml file
    * updated the main logo files
    * [admin] removed unused images
    * [admin] updated the skin images
    * [admin] updated the footer of the template
    * [admin] updated the stylesheets
        * added styling for accordion lists
        * updated the skin.css file to match with some of the changes from the login's skin.css
    * [login] removed unused image files
    * [login] updated the image files
    * [login] updated the stylesheets
        * updated the styles to be cleaner and use better practices
        * updated the skin.css file to remove unused styles
        * updated the structure.css file to remove unused styles
    * [main] removed unused images
    * [main] updated the skin images
    * [main] updated the footer of the template
    * [main] updated the stylesheets
        * updated the skin.css file to match with some of the changes from the login's skin.css
    * [wiki] removed the textboxlist images
    * [wiki] removed the textboxlist stylesheets
    * [wiki] removed unused images
    * [wiki] updated the skin images
    * [wiki] updated the footer of the template
    * [wiki] updated the stylesheets
        * updated the skin.css file to match with some of the changes from the login's skin.css
* updated the sunny skin
    * updated the main logo files
    * [admin] updated the stylesheets
        * added styling for accordion lists
    * [main] updated the stylesheets
        * updated the alt row color
        * added the info-full class
    * [login] updated the stylesheets
        * updated the skin.css file to match changes made to main's skin.css
        * updated the skin.css file to remove unused styles
        * updated the structure.css file to remove unused styles
    * [login] removed the ui.theme.css file
    * [login] removed the unused jquery ui theme images
    * [wiki] added the proper images
    * [wiki] removed unused images
    * [wiki] removed the textboxlist images
    * [wiki] removed the textboxlist stylesheets
    * [wiki] updated the stylesheets
        * updated to look like the main section
        * updated the alt row color
        * updated the textboxlist styles to remove the focus shadow
        * added the markitup link fix
* updated the lightness skin
    * [admin] updated the stylesheets
        * added styling for accordion lists
    * [login] updated the stylesheets
        * updated the skin.css file to remove unused styles
        * updated the structure.css file to remove unused styles
	* [wiki] removed the textboxlist images
    * [wiki] removed the textboxlist stylesheets
    * updated the main logo files
* updated the titan skin
	* [wiki] removed the textboxlist images
    * [wiki] removed the textboxlist stylesheets
* updated the redmond skin
    * [login] updated the nova small logo
    * [login] updated the stylesheets
        * updated the skin.css file to remove unused styles
        * updated the structure.css file to remove unused styles
	* [wiki] removed the textboxlist images
    * [wiki] removed the textboxlist stylesheets
* updated jquery to version 1.4.1
* updated jquery ui to version 1.8rc1
* updated the head include files to pull in the jquery.ui.widget file which is now required
* updated the admin's head include file to set some depencies for the ui widgets
* updated the language files
    * [install\_lang] added key _update\_required_
    * [install\_lang] updated key _update\_outofdate\_database_ to change plurality of "links" to "link"
    * [base\_lang] added key _actions\_run_
* updated the update template to not have a copyright statement
* updated the install template to not have a copyright statement
* updated the update versions array
* updated the manage wiki categories page to allow creating a description
* updated the wiki head include to pull in the qtip plugin
* updated the wiki head include to not pull the textboxlist plugin
* updated the wiki page creation to use a different manner of selecting categories
* updated the wiki categories to handle a description as well
* updated the jquery ui images to the base theme
* updated the jquery ui theme stylesheet to the base theme
* updated the version history to use the Markdown parser
* updated the version history accordion to be collapsible
* removed old jquery ui files (version 1.8 uses a new naming scheme for the .js files)
* removed test update file
* removed the version.xml file
* fixed bug where the update panel wasn't showing the proper information at the right times (#71)
* fixed bug where viewing a wiki page or draft with fewer than 2 categories wouldn't display the category
* fixed bug with position sliders not updating the proper item (#72)
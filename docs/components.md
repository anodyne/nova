# System Components

Nova is made up of a wide range of plugins and components to help make it what it is. Knowing what those components and plugins are can open up an array of possibilities for your own code. Below are the PHP and CSS/JavaScript plugins and components used in Nova 3.

## PHP

* FuelPHP
    * Version: 1.1
    * Site: http://fuelphp.com/
    * Location
        * nova/fuel
        * nova/packages/email
        * nova/packages/oil
        * nova/packages/orm
        * nova/packages/parser
    * Notes
        * The hope is to release Nova 3 off of FuelPHP 2.0 but until it reaches a beta state, that's purely speculation
* Sentry
    * Version: 1.1
    * Site: http://sentry.cartalyst.com/
    * Location
        * nova/packages/sentry
    * Notes
        * This is a __highly__ modified version of Sentry 1.1. Updates to Sentry must be integrated manually.
* Nova (module)
    * Version: 3.0
    * Location
        * nova/modules/nova
        * nova/modules/login
        * nova/packages/fusion
* Setup (module)
    * Version: R1
    * Location
        * nova/modules/setup
* Thresher (module)
    * Version: R3
    * Location
        * nova/modules/wiki
* Mako (module)
    * Version: R1
    * Location
        * nova/modules/forums
* Override (module)
    * Location
        * app/modules/override

## CSS and JavaScript

* jQuery
    * Version: 1.7.2
    * Site: http://jquery.com/
    * Location
        * http://code.jquery.com/jquery-1.7.2.min.js
* Bootstrap
    * Version: 2.0.2
    * Site: http://twitter.github.com/bootstrap/
    * Location
        * nova/modules/assets/css/bootstrap-responsive.css
        * nova/modules/assets/css/bootstrap-responsive.min.css
        * nova/modules/assets/css/bootstrap.css
        * nova/modules/assets/css/bootstrap.min.css
        * nova/modules/assets/img/glyphicon-halflings-white.png
        * nova/modules/assets/img/glyphicon-halflings.png
        * nova/modules/assets/js/bootstrap-alert.js
        * nova/modules/assets/js/bootstrap-button.js
        * nova/modules/assets/js/bootstrap-carousel.js
        * nova/modules/assets/js/bootstrap-collapse.js
        * nova/modules/assets/js/bootstrap-dropdown.js
        * nova/modules/assets/js/bootstrap-modal.js
        * nova/modules/assets/js/bootstrap-popover.js
        * nova/modules/assets/js/bootstrap-scrollspy.js
        * nova/modules/assets/js/bootstrap-tab.js
        * nova/modules/assets/js/bootstrap-tooltip.js
        * nova/modules/assets/js/bootstrap-transition.js
        * nova/modules/assets/js/bootstrap-typeahead.js
* jQuery Validation
    * Version: 1.9
    * Site: http://bassistance.de/jquery-plugins/jquery-plugin-validation/
    * Location
        * http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js
        * http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/additional-methods.min.js
* jEditable
    * Version: 1.7.1
    * Site: http://www.appelsiini.net/projects/jeditable
    * Location
        * nova/modules/assets/js/jquery.jeditable.min.js
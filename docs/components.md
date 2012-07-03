# System Components

Nova is made up of a wide range of plugins and components to help make it what it is. Knowing what those components and plugins are can open up an array of possibilities for your own code. Below are the PHP and CSS/JavaScript plugins and components used in Nova 3.

## PHP

* FuelPHP
    * Version: 1.2.1
    * Site: http://fuelphp.com/
    * Location
        * nova/fuel
        * nova/packages/email
        * nova/packages/oil
        * nova/packages/orm
        * nova/packages/parser
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
    * Version: 2.0.4
    * Site: http://twitter.github.com/bootstrap/
    * Location
        * nova/modules/assets/css/bootstrap-responsive.min.css
        * nova/modules/assets/css/bootstrap.min.css
        * nova/modules/assets/img/glyphicon-halflings-white.png
        * nova/modules/assets/img/glyphicon-halflings.png
        * nova/modules/assets/js/bootstrap.min.js
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
* Bootstrap Scripting
    * Version: 2.0
    * Site: http://nikku.github.com/jquery-bootstrap-scripting/
    * Location
        * nova/modules/assets/js/jquery.dialog2.js
        * nova/modules/assets/js/jquery.dialog2.helpers.js
        * nova/modules/assets/js/jquery.controls.js
        * nova/modules/assets/js/jquery.form.js
* Lazy
    * Version: 1.5
    * Site: http://unwrongest.com/projects/lazy/
    * Location
        * nova/modules/assets/js/jquery.lazy.js
* AjaxQ
    * Version: 0.0.1
    * Location
        * nova/modules/assets/js/jquery.ajaxq.js
* jQuery UI
    * Version: 1.8.20
    * Site: http://jqueryui.com
    * Location
        * nova/modules/assets/js/jquery.ui.accordion.min.js
        * nova/modules/assets/js/jquery.ui.autocomplete.min.js
        * nova/modules/assets/js/jquery.ui.button.min.js
        * nova/modules/assets/js/jquery.ui.core.min.js
        * nova/modules/assets/js/jquery.ui.datepicker.min.js
        * nova/modules/assets/js/jquery.ui.dialog.min.js
        * nova/modules/assets/js/jquery.ui.draggable.min.js
        * nova/modules/assets/js/jquery.ui.droppable.min.js
        * nova/modules/assets/js/jquery.ui.mouse.min.js
        * nova/modules/assets/js/jquery.ui.position.min.js
        * nova/modules/assets/js/jquery.ui.progressbar.min.js
        * nova/modules/assets/js/jquery.ui.resizable.min.js
        * nova/modules/assets/js/jquery.ui.selectable.min.js
        * nova/modules/assets/js/jquery.ui.slider.min.js
        * nova/modules/assets/js/jquery.ui.sortable.min.js
        * nova/modules/assets/js/jquery.ui.tabs.min.js
        * nova/modules/assets/js/jquery.ui.widget.min.js
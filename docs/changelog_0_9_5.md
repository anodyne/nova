* added the 0.9.5 update file
* added the 0.9.4 changelog to the docs directory
* added the docking user email view files
* added the docking gm email view files
* added the sim_docked_all view file
* added the sim_docked_one view file
* added the sim/docked js view file
* added the icon-view.png image to the main section
* added add_docking_field ajax view
* added add_docking_sec ajax view
* added del_docking_field ajax view
* added del_docking_sec ajax view
* added edit_docking_field_value ajax view
* added edit_docking_sec ajax view
* added site/dockingform js view
* added site/dockingsections js view
* added site/dockingform view
* added site/dockingform/edit view
* added site/dockingsections view
* added manage\_docked\_edit view file
* added the icon-cross icon
* added the icon-check icon
* added the del\_docked\_item ajax view
* added the approve\_docking ajax view file
* added the docked\_action email view file
* removed the old docking request email views
* updated the database schema
    * added docking table
    * added docking_data table
    * added docking_fields table
    * added docking_sections table
    * added docking_values table
* updated the basic install data
    * updated the version info
    * updated the system info
    * updated the version history info
    * updated the menu items
    * updated the colorbox version info
    * updated the menu items
    * updated the access pages
    * updated the access roles
    * updated the skin catalogue item
    * updated the messages to include docking emails
* updated the 0.9.4 update file
* updated the update versions array
* updated the colorbox plugin to version 1.3.6
* updated the site options page to handle skin previews like site/settings
* updated the language files
    * [base\_lang] added _global\_sims_
    * [base\_lang] added _status\_previous_
    * [base\_lang] added _labels\_requests_
    * [base\_lang] added _flash\_additional\_docking\_section_
    * [base\_lang] added _labels\_fields_
    * [base\_lang] removed _actions\_previous_
    * [email\_lang] added _email\_subject\_docking\_user_
    * [email\_lang] added _email\_subject\_docking\_gm_
    * [email\_lang] added _email\_content\_docking\_user_
    * [email\_lang] added _email\_content\_docking\_gm_
    * [email\_lang] added _email\_subject\_docking\_approved_
    * [email\_lang] added _email\_subject\_docking\_rejected_
    * [text\_lang] added _text\_dockingsections_
    * [text\_lang] added _text\_dockingform_
    * [text\_lang] added _text\_docking\_approve_
    * [text\_lang] added _text\_docking\_reject_
    * [facebox\_lang] added _fbx\_content\_del\_docking\_sec_
    * [facebox\_lang] added _fbx\_content\_add\_docking\_sec_
    * [facebox\_lang] added _fbx\_content\_add\_docking\_field_
    * [facebox\_lang] added _fbx\_content\_del\_docking\_field_
* updated the sunny skin
    * added the preview-main.jpg image
    * removed the preview-main.png image
    * updated the skin.yml file with the new preview image
    * [main] updated the stylesheets
         * updated the panel handle to not have top and side borders
         * updated the main menu styles to fix a strange bug in IE
* updated the beta skin
    * added the preview-main.jpg image
    * added the preview-admin.jpg image
    * added the preview-wiki.jpg image
    * removed the preview-main.png image
    * removed the preview-admin.png image
    * removed the preview-login.png image
    * removed the preview-wiki.png image
    * updated the skin.yml file with the new preview images
* updated the lightness skin
    * added the preview-main.jpg image
    * added the preview-admin.jpg image
	* added the preview-wiki.jpg image
	* removed the preview-admin.png image
    * removed the preview-main.png image
    * removed the preview-wiki.png image
    * updated the skin.yml file with the new preview images
* updated the redmond skin
    * added the preview-main.jpg image
    * added the preview-admin.jpg image
	* added the preview-wiki.jpg image
	* removed the preview-admin.png image
    * removed the preview-main.png image
    * removed the preview-wiki.png image
    * updated the skin.yml file with the new preview images
    * [admin] updated the stylesheets
        * updated the alt row color
	* [main] updated the stylesheets
        * updated the alt row color
	* [wiki] updated the stylesheets
        * updated the alt row color
* updated the main and sim controllers to update some language keys
* updated the docking request form to use the dynamic form
* updated the ajax controller to handle operations for the docking form
* updated the ajax controller to handle operations for the docking sections
* updated the site controller to handle operations for the docking form
* updated the site controller to handle operations for the docking sections
* updated the control panel to notify of docking requests
* updated the manage missions page to use the new form layout
* updated the icon-add.png image
* updated the managed docked items page to be able to edit a docked item
* updated the managed docked items page to display active, inactive and pending docked items
* updated the managed docked items page to be able to edit a docked item
* updated the managed docked items page to display active, inactive and pending docked items
* updated the icon-delete icon
* updated the tour model to include an identifier in the delete\_tour\_field\_data method
* updated the ajax controller to be able to handle deletion confirmation for a docked item
* updated the docked item management page to be able to approve docking requests
* updated the docked item management page to be able to reject docking requests
* updated the ajax controller to handle docking request approval and rejection
* updated the what's new page to show the full changelog as well
* fixed bug where a stray in comma threw errors in IE
* fixed bug in specs form management where values couldn't be added to the dropdown menus
* fixed bug in tour form management where values couldn't be added to the dropdown menus
* fixed bug in bio form management where values couldn't be added to the dropdown menus
* fixed bug where the datepicker wouldn't work if a date was passed to the field
* fixed bug where the bio page wasn't able to handle choosing which of multiple characters to edit if none was in the URI (#73)
* fixed bug where the system wouldn't respect daylight savings time changes
* fixed bug where deleting a tour item would leave orphan dynamic data in the database
* fixed error being thrown in the modal window when rejecting a user
* fixed bug where the initial my links was wrong
# Anatomy of a Nova 3 Skin

At first glance, Nova 3 skins will look incredibly foreign to anyone familiar with Nova 1 and 2 skins. There are a lot less files and a completely different file structure in each skin folder. By the end of this document though, you'll be familiar with all the different components that _can_ make up a skin (but don't necessarily _have_ to make up a skin).

## Components

The components directory is just that, a list of pieces that make up a skin and that skin developers have access to use and override.

### Structures

A structure file is the first piece of a skin that's called in and includes the foundation of the page: the `head` and `body` tags (though there's nothing in the `body` tag except a call to the template). It's in the structure file that the JavaScript plugins and stylesheets are called in (including all the logic to figure out which stylesheets to pull from the skins and where to pull them from), metadata, and other information that should remain static throughout most skins.

Like other files in seamless substitution, skin developers are able to provide their own structure file for their skin where they can make any changes they want to the JavaScript, stylesheets, and other foundation components. In order to do so, a skin developer need only copy the file they wish to modify (most likely found in `nova/modules/nova/views/components/structure`) and paste in to a similar folder in their own skin (`app/views/skin_name/components/structure`) with their changes. Nova will see the new structure file and use it instead of the base structure file.

<p class="alert alert-danger">We don't recommend overriding structure files for a variety of reasons. If items are updated, removed, or added, it'll fall to the skin developer to constantly check the changes made to the structure files and make the necessary changes for their skin. Additionally, these changes could cause Nova to stop working altogether, creating support headaches. Unless you have a very good reason to do so, you should not override structure files.</p>

### Templates

A template file involves everything found inside the page's `body` tag. Any markup needed for the template is found in here, and like the structure files, is stored in the Nova core and can be overridden on a skin-by-skin basis.

In order to override an existing template, a skin developer need only copy the file they wish to modify (most likely found in `nova/modules/nova/views/components/templates`) and paste it in to a similar folder in their own skin (`app/views/skin_name/components/templates`) with their changes. Nova will see the new template file and use it instead of the base template.

### Partials

Nova uses the concept of partial views to render areas of content that may need to be changed frequently. Currently, Nova uses partials to render the footer, the user panel, and the secondary navigation. Using partials like this means that skin developers can change how the footer works for their own skin without causing problems for another skin that's installed.

In order to override an existing partial, a skin developer need only copy the file they wish to modify (most likely found in `nova/modules/nova/views/components/partials`) and paste it in to a similar folder in their own skin (`app/views/skin_name/components/partials`) with their changes. Nova will see the new partial file and use it instead of the base partial for that particular item.

### Pages

Like previous versions of Nova, skin developers can change the way individual pages or JavaScript for individual pages works by using seamless substitution. In order to override an existing page, a skin developer need only copy the file they wish to modify (most likely found in either `nova/modules/nova/views/components/pages` or `nova/modules/nova/views/components/js` depending on which is being changed) and paste it in to a similar folder in their own skin (`app/views/skin_name/components/pages` or `app/views/skin_name/components/js` depending on which is being changed) with their changes. Nova will see the new view file(s) and use it/them instead of the base pages for that particular page.

### Widgets

For anyone who's gone digging through the default Nova skin in the Nova core, you've probably noticed there's a `widgets` directory that stores all the core widgets in the system. Even though that's in the views directory, it is not tied in to seamless substitution, so you cannot override widgets on a skin-by-skin basis. The reason this decision was made is that it could be a detriment to the user experience if a widget acts one way inside one skin and another way inside a different skin.

## Design

As its name implies, the `design` directory handles everything involved with the actual design and presentation of a skin. This is the folder skin developers will likely be spending most of their time. There are a few important things to note about the contents of this directory.

### Custom.css

The preferred way to create a new skin is to create a new directory inside `app/views` with the name of your skin, create the `design` folder, then create a `custom.css` stylesheet and make your changes within that file. Once Nova detects a `custom.css` file, it'll use that. Since the custom stylesheet is called in after all the base styles, any changes a skin developer makes to styles will be used instead of the base styles. (We go in to more detail with this in other pages.)

<p class="alert">Interestingly enough, it's possible to have a skin that doesn't use any stylesheets. If, for instance, a skin developer wanted to change the markup to have a skin that looks identical to the default but moves some of the components in the template around, that'd still be a perfectly valid skin.</p>

### Style.css

Alternatively, it's possible to skip right over Nova's base stylesheet by creating a `style.css` file (in place of `custom.css`) and build your skin from the ground up. Doing this means you'll start with the bare essentials (the Bootstrap framework) but no styling beyond that. This is certainly the more time-intensive option of the two as you would have to go through and build everything from scratch.

<p class="alert alert-danger">We don't recommend replacing the base stylesheet for a variety of reasons. If any styles are changed, removed, or added, your skin will not have those changes. The onus then falls to you to constantly check changes to the base skin and keep your skin in lock-step with the base skin so as to not create issues for users of your skin in Nova 3.</p>

### Images

Any images you want to use in your skin (background images, etc.) should be stored in the skin's `images` directory. In addition, seamless substitution allows you to replace core images with your own on a skin-by-skin basis.

<p class="alert">More information about images in skins is available in other pages.</p>

## Other Files

In addition to the items listed above, skins can also contain two additional files.

### QuickInstall

Like previous versions of Nova, you can create a QuickInstall file to help users get your skin installed and ready to use in no time. More information about creating QuickInstall files can be found in other pages.

### Image Index

New to Nova 3 is the image index, an easy way to remap the image names used from the default. Using a simple PHP array, you can change the image name from the default to something else. (This is especially helpful if you want to use a `.jpg` image instead of a `.png` image for something.) More information about the image index can be found in other pages.

## Word to the Wise

It's important to understand that there's no way for overridden files to be aware of changes to their parent files (in other words, the original file that was used as a template for modifying). Because of this, updates to Nova can break pages or cause functionality to be missing because Nova is using a page that doesn't have the pieces it needs. If you notice problems with your installation, the first place you should start looking is your skins and making sure the skin isn't overriding those pages and creating problems. The easiest way to verify if it's a Nova issue or a skin issue is to change back to the default skin and see if the issue still persists.
So you want to play around with Nova 3? That's awesome! Our philosophy is to start as general as possible and let the community take it from there. It's served Anodyne well since its inception and gives the community more flexibility to make Nova what they want it to be without adding unneeded code to the core for people who don't want those changes. But now you have to figure out how to tackle that mod you want to make. Here are a few general guidelines for how to work with Nova 3.

## Modifying Controllers

When it comes to modifying existing controllers, there are two options.

### App

The simplest and most straightforward approach to modifying existing controllers is to do so from the `app` directory. The main controllers have empty alias files in the `classes/controller` directory. Like previous version of Nova, you can simply make your changes to the methods you want from there (additional work has been done to ensure you don't have to copy an entire method, more information on that can be found in other places). Make your changes, upload them, and you're all set.

### Module

If you're doing something that's more advanced, the best option is to create a new module, make your changes to the controller(s) and then use routing to use your own code instead of what Nova is set up to use.

Let's use the example of replacing the main page of Nova. In that case, we can create a new module in the `app/modules` directory and call it `mainredux`. Because modules in FuelPHP are required to be namespaced, the actual URL to get to your new main page would actually be `http://yoursite/index.php/mainredux/main/index`. Once you're all set, you can open the `app/config/routes.php` file and change the default page to point to `mainredux/main/index`. When Nova launches, it'll go out and use your module page instead of the main page.

<p class="alert">It's important to note that we've skipped a bunch of steps here. Make sure you reference the documentation on creating new modules to ensure you're going through all the steps.</p>

## Modifying Models

If you want your changes to be used throughout the system, your only option is to tweak the models from the `app/classes/model` directory. If you want your changes to only apply to a specific set of pages, you can make changes to the models in a module.

<p class="alert">This encapsulation is actually incredibly powerful as it allows you to completely change something about a model just for your module but not impact the rest of Nova.</p>

## Modifying Classes

If you want your changes to be used throughout the system, your only option is to tweak the classes from the `app/classes` directory. If you want your changes to only apply to a specific set of pages, you can make changes to the classes in a module.

<p class="alert">This encapsulation is actually incredibly powerful as it allows you to completely change something about a class just for your module but not impact the rest of Nova.</p>

## Modifying Views

Seamless substitution is available for modifying views.

## Creating New Pages

For creating new pages, do not create them in the `app/classes/controller` directory. Instead, you should create a new module and build your functionality in to the module. Users will then go to `http://yoursite/index.php/module/controller/action`. If you want it to appear that they're going to a core page, you can use routing to make sure that any request to a specific page (say `main/foo`) will in fact go to `module/controller/foo`.

Additionally, Nova 3 now supports new content pages through the wiki, so unless you need advanced functionality in your pages, the best bet is to use content pages in Thresher.
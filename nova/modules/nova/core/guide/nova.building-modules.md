# Building Modules

At some point, you'll no doubt want to create some custom code for Nova. Doing so is actually really easy with Kohana's cascading file system. If we wanted to create a controller that talked about Nova, say with some history behind the software, we can easily create an <code>aboutnova</code> module, a matching controller and then point a link toward the page. So let's start with doing just that.

## Basic Module Work

#### The Folder Structure

Nova 2 is already set up to handle third party modules. You'll notice a directory called <code>third\_party</code> inside the modules directory. This is where you should be storing your custom modules and any modules you download and use in your installation of Nova. In this case, we're going to create a module called <code>aboutnova</code>. Inside the folder we just created, we're going to create a folder called <code>views</code> and a folder called <code>classes</code> that contains another folder inside it called <code>controller</code>. In the end, our folder structure should look like this:

	* modules
		* third_party
			* aboutnova
				* classes
					* controller
				* views
				
Now that we have our folders, we can put our two files in. Create a blank file called <code>aboutnova.php</code> in the views directory and a file called <code>aboutnova.php</code> in the controller directory. Now, we have the files we need to start building our page. At this point, our folder/file structure should look like this:

	* modules
		* third_party
			* aboutnova
				* classes
					* controller
						- aboutnova.php
				* views
					- aboutnova.php

#### Our Controller

Just like Nova 1, Nova 2 uses controllers to generate pages. Our module here is going to be pretty simple and only use one controller and one method (you could make a much more advanced module that has lots of controllers, libraries, models and views if you wanted to).

<pre><code>&lt;?php defined('SYSPATH') or die('No direct access allowed.');

class Controller_Aboutnova extends Controller_Nova_Main
{
	public function before()
	{
		parent::before();
	}
	
	public function action_index()
	{
		// create a new content view
		$this->template->layout->content = View::factory('aboutnova');
		
		// content
		$this->template->title.= __('About Nova');
		
		// send the response
		$this->request->response = $this->template;
	}
}</code></pre>

As you can see, it's a pretty simple controller that just calls the view file, sets the title and sends the response to the browser. You'll notice that the title is surrounded by <code>__()</code>. This is Kohana's internationalization function and using this will allow someone to translate your module if you they wanted/needed to (if you know someone who speaks another language, you could even have them translate your module for you and offer an internationalized module!).

#### Our View

The view file is even simpler, just straight HTML. Just put whatever you want into the view file, save it and upload it. The controller method will use the <code>aboutnova.php</code> view file.

#### Using Our Module

We've built our module, now it's time to turn it on and use it!

[!!] It's incredibly important that you follow these instructions for enabling modules instead of Kohana's documentation. We have supplemented Kohana's way of doing this to ensure that your custom module declarations don't get overwritten when Nova is updated.

Open up <code>application/config/nova.php</code> and scroll to the bottom where you'll see a section about modules that looks like this:

<pre><code>'modules' => array(
	// 'upgrade' => MODPATH.'nova/upgrade',
	// 'your_mod' => MODPATH.'third_party/your_mod',
),</code></pre>

From here, we can specify new modules to be activated and available to use. If you don't activate a module here, it won't work. Let's copy the __your\_mod__ line and paste it below. The first part of the line is for naming your module, just make sure it doesn't conflict with one of Nova's modules or another third party module. The second part is telling Nova where the module is located. In our case, the final result would look like:

<pre><code>'modules' => array(
	// 'upgrade' => MODPATH.'nova/upgrade',
	// 'your_mod' => MODPATH.'third_party/your_mod',
	'about nova' => MODPATH.'third_party/aboutnova',
),</code></pre>

<code>MODPATH</code> just makes sure we're using the proper name of the modules directory and then from there, everything should be pretty self-explanatory. Save the config file and make sure it's uploaded to the server. Then you can fire up your browser and go to <code>index.php/aboutnova/index</code> and you'll see the content you created in your view file!

## Advanced Module Work

So we already have our module finished, but let's set it up so that when a user goes to <code>index.php/main/about</code>, they're actually seeing our page instead of an error that the page doesn't exist. Your code doesn't have to change at all, we just have to add a file to the root of our module's directory: <code>init.php</code>.

#### The Init File

Because of the complex nature of Nova and how it extends Kohana to provide a flexible solution for managing your RPG, modules can't extend existing controllers. If you extend an existing controller, you could be breaking another MOD that does the same thing. To avoid this, every module should have it's own <code>init.php</code> file that defines the routes for the modules. This allows you to specify a URL you want to use and then point it to your module and controller.

For the example we've been using already, let's build our <code>init.php</code> file so that when someone try to go to <code>index.php/main/about</code> it'll redirect to our module.

<pre><code>Route::set('about nova redirect', 'main/nova')
	->defaults(array(
		'controller' => 'aboutnova',
		'action' => 'index'
	));</code></pre>
	
It may look a little daunting, but really, this is a very simple route. Let's break it down piece by piece so you can see what's going on.

<pre><code>Route::set('about nova redirect', 'main/about')</code></pre>

The above code, very simply, creates a unique name for our route and specifies the URL we want to use as a trigger for the route. In this case, we're naming our route __about nova redirect__ and telling Kohana to trigger this route when a user tries to visit <code>index.php/main/about</code>.

<pre><code>->defaults(array('controller' => 'aboutnova', 'action' => 'index'));</code></pre>

The rest of the route is simply telling Kohana where to redirect to. In this case, we're redirecting to our <code>aboutnova</code> controller and calling the <code>index</code> method. So now, even though the URL may say <code>index.php/main/about</code>, Kohana is really pointing at <code>index.php/aboutnova/index</code> and using the code there to display our page.
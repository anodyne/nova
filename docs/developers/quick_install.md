# Quick Install

One of the exciting additions to Nova was a feature known as QuickInstall that allows skin and rank developers to let admins quickly install new skins and ranks with a single click. Nova leveraged this in several ways from installation, upgrade, update and through to day-to-day operations. For Nova 3, we've made improvements to QuickInstall that allow you to create your own items that can tap in to QuickInstall.

QuickInstall is now an interface that any class can implement. When it comes to ranks, skins, widgets and modules, their respective models implement the QuickInstall interface. This allows us to simply call the `install()` method from the model to install the information into the database. So how does this work?

## What's An Interface?

Simply put, an interface is a contract or a blueprint for certain functionality. In this case, we're talking about a blueprint for implementing QuickInstall for something other than what we've built it for. An interface is nothing more than an empty shell. Unlike an abstract class that builds the methods, an interface just declares what methods any class that implements it must have. Beyond that, the class can contain whatever you want.

## QuickInstallInterface

<pre>interface QuickInstallInterface
{
	/**
	 * Install the item.
	 *
	 * @api
	 * @param	mixed	The location of the item or NULL to install everything.
	 */
	public static function install($location = null);

	/**
	 * Uninstall the item.
	 *
	 * @api
	 * @param	string	The location of the item.
	 */
	public static function uninstall($location);
}</pre>

This is what the interface for QuickInstall looks like. All this does is tell you that your class has to have an install method and an uninstall method. You choose how to build those based on what you need to accomplish.

## Implementation

<pre>class Model_Catalog_Module extends \Model implements \QuickInstallInterface</pre>

The Module Catalog model implements the QuickInstallInterface by using the `implements` keyword when declaring the class. After that, we create the necessary methods somewhere in the model.

<pre>public static function install($location = null)
{
	// Install code goes here...
}

public static function uninstall($location)
{
	// Uninstall code goes here...
}</pre>

Now, we can build the install and uninstall functionality however we want.

## Practical Example

Say your fleet does annual awards for its games. Every year they pick a Game of the Year, Most Improved Game, Recruiter of the Year and Story of the Year. In most cases, they'd simply distribute a banner that someone can put on their site, but in the case, let's assume they want to do more, maybe provide some information about why the game won. To do this, they enlist the help of a programming guru to build a little MOD for Nova that all the games install. After all the votes are in and the winners are announced, the fleet can send a zip file to the winning games that have a QuickInstall item for installing that content into the database and displaying it in the page that was created.

Because the MOD's model implements the QuickInstallInterface, when someone uploads the content to the right place and clicks the install button the MOD developer created, all that information is put into the right place and the page is automatically updated to show the award the game won this year.

There are plenty of other options for using the QuickInstallInterface, but you can see from the simple example above that using this interface gives MOD developers significantly more power to tap in to some of Nova's built-in functionality.
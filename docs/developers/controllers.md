# Controllers

Controllers are PHP classes that can be reached through the URL and take care of handling the request. A controller calls models and other classes to fetch the information. Finally, it will pass everything to a view for output. If a URL like www.yoursite.com/example/index is requested, the first segment ("example") will be the controller that is called and the second segment ("index") will be the method of that controller that is called (also known as an action).

## Base Controllers

A base controller is a shared controller, like Controller_Public or Controller_Admin and are used to share logic between groups of controllers. For example, the Controller_Admin controller could contain your login/logout actions and maybe a dashboard, but it could also contain a before() method that checks to see if the user is logged in as an admin. Then all other controllers in your admin panel will extend this and automatically be secured.

Nova 3 uses a similar concept to create a base controller for every single controller used in the system. This allows us to set up the wide range of variables and components needed to run the system. In most cases, the base controller will never extend a standard page controller. Instead, section base controllers are used to do specific setup for that section.

So why have both a base controller and a section base controller? Using a base controller means that things consistent across every page are handled in one place. Now, if something has to change, it's changed in one place instead of running the risk of forgetting to change it everywhere. That change filters down through all the different section base controllers. Anything then that's section specific is handled just for that section in its section base controller.

## A (Sort Of) Practical Example

This can be a little tough to wrap your head around, especially if you're new to object oriented programming, so let's use a concrete example to illustrate how this works.

Let's think of our base controller like a car. Every car has an engine, transmission, and headlights. Those are the things that make a car a car. By themselves, they don't do very much, just tells us that this is the basis for something being a car. That's what our base controller is. On its own, it's not much, but it's the foundation for what we're building.

<pre>class Car
{
	public $engine;
	public $transmission;
	public $headlights;
	public $wheels;
}</pre>

Next, let's think of our section base controller like a class called Honda. That's quite a bit more specific than just a car. In this instance, our Honda extends car. Because it extends car, Honda now has all the properties of a car, plus, we can build new properties unique to Honda. From inside that Honda class, we can now get anything about the engine, transmission, or headlights because car had those properties.

<pre>class Honda extends Car
{
	public $body;
}

$car = new Honda();
$car->body; // gives us the Honda's body property
$car->engine; // gives us the Honda's engine property through Car</pre>

Dropping down further, let's think of our controller like a class called Civic. Now, we're very specific about what we've got. In this instance, Civic extends Honda. This means that it now has access to all the properties of Honda as well as Car.

<pre>class Civic extends Honda
{
	public $color;
	public $doors;
	public $air_conditioning;
}

$car = new Civic();
$car->color; // gives us the Civic's color
$car->body; // gives us the Civic's body, from Honda
$car->engine; // gives us the Civic's engine, from Car</pre>

You can see here that there's a lot of power and flexibility to be derived from this kind of programming. This is allowing us to layer different pieces together. It also means that we could create a class called Ford that has different properties than Honda and then create a Mustang class that extends Ford. Within any of these classes to, we can change the properties of something that's already been set, further enhancing their flexibility. Take this as an example:

<pre>class Car
{
	public $engine;
	public $transmission;
	public $headlights;
	public $wheels;
	
	public function __construct()
	{
		$this->engine = 'Standard';
	}
}

$car = new Car();
$car->engine; // this will return Standard

class Honda extends Car
{
	public $body;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->engine = '4 cylinder';
	}
}

$car = new Honda();
$car->engine; // this will return 4 cylinder

class Civic extends Honda
{
	public $color;
	public $doors;
	public $air_conditioning;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->engine = '4 cylinder 147 horsepower';
	}
}

$car = new Civic();
$car->engine; // this will return 4 cylinder 147 horsepower</pre>

You can see that we have a whole new level of flexibility by building our code like this. Essentially, this is what Nova's controllers do. The standard controller extends the section base controller which extends the base controller, therefore giving us access to everything in both of the controllers that the page extends. It isn't a perfect metaphor, but you can begin to see the layer by layer approach we take in Nova 3.
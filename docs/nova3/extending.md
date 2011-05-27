# Extending Nova 3

## Controllers

In Nova 1, we introduced seamless substitution as a way to extend the Nova core without ever touching the core files. This had the primary advantage of allowing people's changes to remain intact through an update. Unfortunately, if you wanted to replace a page, it involved copying and pasting a lot of code that didn't really matter. Code duplication is always a bad thing. Really, the majority of people just wanted to change a few things, not make massive changes to how something worked. This fact isn't lost on us and with the tools available to us in Nova 3, we've been able to squarely address that issue and eliminate the majority of the code people have to put in their extended controller methods.

The first advantage of this is making it more clear what you've changed in your extended version. That's particularly important if you're troubleshooting a problem with what you've changed.

Second, it eliminates the need to comb through a lot of code you don't need or don't understand to change something relatively simple.

Third, it finally provides more protection against updates. For instance, if you changed the main page in the personnel section but in an update, we changed some of the logic, in Nova 1 and Nova 2, you'd be out of luck and lose those changes, potentially leaving a bug in the code or worse, losing out on a new feature all because you had to copy and paste the old code to make things work. Why should you have to lose out on bug fixes and new features just because you wanted to change the header? You shouldn't and with the tools available now, you don't have to.

<pre>class Personnel extends Nova_Personnel {
	
	public function action_index()
	{
		parent::action_index();
		
		$this->_data->header = 'The People of Nova';
	}
}</pre>

The above code is all you'd need if you wanted to change the `personnel/index` header from __Manifest__ to __The People of Nova__. Using the `parent::action_index()` call, we can grab all of the code from the original method and then just replace the header variable. (This is possible because all of the template processing is handled in the controller's `after()` method that runs after the controller action finishes running.)

Obviously if you want to do something more advanced, like say replacing news on the front page with mission posts, you'd have to write all the code to pull the items, loop through them and do all the logic before sending the final output to the _same_ variable that are used for news items. In that instance, it's probably best to copy the method from the core and make the changes you want. That's still a perfectly valid option, but these changes ensure that you can make minor changes to the controller methods without losing out on bug fixes or new features on a page.
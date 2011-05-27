# Events and Hooks

Nova 3 comes with a robust events system that allows developers to both tap in to existing events as well as create their own events. Events can be registered with this system and then called later. In addition, the system allows for defining events in a config file to be automatically initialized when the class starts up.

## Anatomy of an Event

So what is an event in Nova 3?

Simply put, an event is a stop sign during the course of the system executing a request. Basically, Nova comes to one of those stop signs, stops for a second to make sure there's no traffic (event callbacks). If there is some traffic, it stops and let's the traffic pass (executes the event callbacks), otherwise, the system just keeps going. During the course of a system request, there are 8 stop signs that Nova 3 observes. Additionally, developers can put their own stop signs in that Nova will pay attention to as well.

One of Nova's features is that admins can ban users by IP address from even visiting the site. In order to enforce a level 2 ban, Nova uses an event callback inside a specific event to check the ban list and take the appropriate action if the person is in the list. Obviously we want that check to happen before the page is displayed (that is, after all, the definition of a level 2 ban), so events work perfectly for this kind of check. Other things that use events are checking to see if the system is in maintenance mode and making sure the user has a supported browser.

So how do these events work in Nova 3?

Events are controlled through the Event class. Using the class, you can manually register events with the class and then trigger them later in the workflow. This is especially handy if you're developing an extension that does some complex logic that you want to keep out of the controller and in its own class. You can register the event at the start of your controller and then at the appropriate point, you can trigger the event to fire. Additionally, you can set up event callbacks (the actually things being done) from the event config file. This is great if you want to tap in to the existing events and take advantage of the stop signs already built in to Nova 3.

## Pre-defined Events

Nova 3 comes with 8 pre-defined events during program execution that provide developers with fine-grained control of when their hooks into the system are executed. The following events are available by default in Nova 3:

* __Pre-create__ - executed before the Request object is available.
* __Post-create__ - executed after the Request object is created by the system.
* __Pre-execute__ - executed before the application has made its requests.
* __Post-execute__ - executed after the application has made its requests.
* __Pre-headers__ - executed before the system has passed the headers along.
* __Post-headers__ - executed after the system has passed the headers along.
* __Pre-response__ - executed before the Response object comes back.
* __Post-response__ - executed after the Response object comes back.

## Tapping in to Existing Events

If you want to tap in to an existing event...
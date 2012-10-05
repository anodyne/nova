# Controller Actions

Controller actions are the methods inside of the controller class. In Nova 3, these methods are set up in such a way to offload many of the common tasks to base methods to avoid repeating the same type of code over and over again.

## The After Method

In order to enhance the flexibility for developers, we've shifted a lot of common processing out of the controller action and in to the controller's `after()` method. This allows developers to extend the controllers and only change what they want without having to copy and paste entire controller methods. More details on this are provided throughout the documentation.

## Controller Variables

The controller variables described here are _protected_ class properties that can only be accessed from inside the class and any classes that extend the base controller. This means that they'll always work inside the controllers that ship with Nova, but if you create a controller that doesn't use the base controller, your code will throw an error if you try to use these.

### \_data

Any data that should be sent through the view needs to be stored in the `_data` variable. Later on during execution, Nova will take the contents of the variable and pass it to the view so any information from the database or anything else is passed along.

<pre>$this->_data->foo = 'Foo';</pre>

#### Special Properties

The `_data` object can accept 3 special properties to be used in specific situations.

<p class="alert alert-info">These 3 special properties will always be used if they've been populated with data, even if that page has content coming out of the database.</p>

__title__: Setting a title property on the `_data` object lets you manually set the title of the page. This should be a simple string and will display in the browser's title bar and the open tab.

<pre>$this->_data->title = 'Test Page';</pre>

__header__: Setting a header property on the `_data` object lets you manually set the header of the page. This should be a simple string and will display above the content of the page.

<pre>$this->_data->header = 'Testing 1 ... 2 ... 3';</pre>

__message__: Setting a message property on the `_data` object lets you manually set the message of the page. This should be text and will display below the header and above the rest of the content of the page.

<pre>$this->_data->message = "This is the intro text that will be shown on the page before the rest of the content.";</pre>

### \_js\_data

Any data that should be sent through the JavaScript view needs to be stored in the `_js_data` variable. Later on during execution, Nova will take the contents of the variable (if there's a JavaScript view to use) and pass it to the JavaScript view so any information from the database or anything else is passed along.

<pre>$this->_js_data->foo = 'Foo';</pre>

### \_view

The `_view` variable should be used for storing a string representation of the view for a particular action. This allows controller actions that are overridden to change the view file being referenced if needed. This variable is used later in execution to grab the view and send it to the user's browser.

<pre>$this->_view = 'main/index';</pre>

### \_js\_view

The `_js_view` variable should be used for storing a string representation of the JavaScript view for a particular action. This allows controller actions that are overridden to change the JavaScript view file being referenced if needed. This variable is used later in execution (if it's set) to grab the JavaScript view and send it to the user's browser.

<pre>$this->_js_view = 'main/index_js';</pre>
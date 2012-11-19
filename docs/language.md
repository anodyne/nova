# I18n

Internationalization, commonly known as I18n (a numeronym where 18 stands for the number of letters between the first _i_ and last _n_ in _internationalization_), is the process of designing software so it can be adapted to various languages and regions without engineering changes. I18n support means that despite Nova being built to support English first and foremost, someone could come in and translate everything to another language without much trouble.

## The `lang` function

To make it easy to handle language strings, Nova's base class include a function called `lang()` that acts as a go-between with Nova and its underlying i18n class. This provides a simple way of translating strings to the user's language. Let's take a look at how to use this function.

### Keys

I18n files in Nova are simply PHP arrays with a key/value structure.

<pre>'key' => 'value'</pre>

The first parameter of the `lang()` function is the key that you want to use. Nova then goes out and pulls back the value for that key and displays it. To help keep things organized in logical ways, language files can also be broken up into sub-arrays. Simple dot-notation allows accessing the nested array items.

<pre>'array' => array('key1' => 'value1', 'key2' => 'value2')</pre>

In the above example, we could get the value we want by simply doing `lang('array.key2')`.

### Variables

While just pulling values out like that can be helpful, there are situations where we need to put one value into another one to build the right string. This also allows us to build generic strings that can include variables that are replaced when the function is called. Because of this, values can have an unlimited number of variables that Nova can replace with other text strings. This makes building dynamic strings a breeze. Variables are specified by using a number-based index preceded by a colon (`:0`, `:1`, `:2`, etc).

<pre>'key' => 'This is the value that :0 will replace with :1.'</pre>

The above example has 2 variables that would be replaced with parameters passed to the `lang()` function, like so:

<pre>lang('key', 'Nova', 'some text string');

// Would output:
This is the value that Nova will replace with some text string.</pre>

This is the most common way the `lang()` function is used throughout Nova, but there are situations where things can get more complex.

### Complex Parameters

In some situations, simple text replacement isn't enough. For those situations, you can nest `lang()` functions inside the parameters. Take the following example:

<pre>'error' => 'An error occurred. :0',
'error1' => 'The :0 page did not respond in a reasonable amount of time.'</pre>

We have 2 language strings here, but both have varaibles. In our code, the call would look like this:

<pre>lang('error', lang('error1', lang('ranks')));</pre>

This may look a little daunting, but if we break it down piece-by-piece, you'll see that it's pretty simple.

First, we're calling the `error` key into the first `lang()` call. This pulls in the error string. Since we have a variable in that, we need a parameter in the first `lang()` instance, but that instance also has its own variable. To address this, we'll simply call another `lang()` function as the parameter so that we can substitute that nested variable. Finally, since _ranks_ is a term we want to be global and able to be substituted for whatever the admin wants, we have a third `lang()` call so that we can get the value of _ranks_.

Fortunately, you won't usually need to do advanced and complex string stuff like this, but you can see that it's pretty easy to deal with complex language strings in Nova 3.
# Oil utility

The Oil utility is a special package command can be used in several ways to facilitate quick development, help with testing your application and for running Tasks.

## Console

The console is the quickest way to test out new classes, models and quick code without even having to open up an IDE. The shell is interactive but due to limitations in PHP it's not quite as interactive as the bash shell unless you enable the readline extension. Either way it works, readline just makes it better.

```
$ php oil console
Kohana 3.1.2 - PHP 5.3.3 (cli) (Aug 22 2010 19:27:08) [Darwin]
>>> "Hello World!"
Hello World!
>>> 1+5
6
>>> $i = 1
>>> ++$i
2
>>> json_encode(array('foo', 'bar'));
["foo","bar"]
>>> $monkey = Model_Monkey::find('first');
>>> $monkey->title
Bobby the Gibbon
```
# Oil utility

The Oil utility is a special package command can be used in several ways to facilitate quick development, help with testing your application and for running Tasks.

## Tasks

### What is a task?

Tasks are classes that can be run through the command line or set up as a cron job. They are generally used for background processes, timed tasks and maintenance tasks. Tasks can calls models and other classes just like controllers.

### Creating a task

Tasks are stored in the tasks directory. Below is an example of the task "example":

```
namespace Nova\Tasks;

class Example {

    public function run($message = 'Hello!')
    {
        echo $message;
    }
}
```

That will be called via the refine utility within oil:

```
$ php oil refine example "Good morning"
```

When just the name of the task is used in the command, the method "run()" is referenced.

### Splitting tasks into more methods

You can add more methods to your task class to break a group of tasks down into more specific tasks which can be called separately.

```
public function current_date()
{
    echo date('Y-m-d');
}
```

We can then call this method using:

```
$ php oil refine example:current_date
```
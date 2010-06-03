# Using the Jelly ORM

We've already talked about what Jelly is, what an ORM is, why Nova's using Jelly and some of the background. Now, let's dig in to Jelly and see how powerful of a tool it really is for Nova developers.

## So how do I use Jelly?

Let's use a concrete example here so it makes sense. We're going to pull information about a specific character and then print out the character's rank, name and position.

<pre>$item = Jelly::select('character', 1);</pre>

That's it.

Wait what?

That's right. With that single line of code, we've managed to pull all the information about the character whose ID is 1. It literally was that simple. Ready to have your mind blown now?

<pre>echo $item->rank->name.' '.$item->fname.' '.$item->lname.' is the '.$item->position1->name;
// would produce: Captain John Doe is the Commanding Officer</pre>

Seems pretty easy to me, but wait, it gets easier.

<pre>echo $item->print_name();// Captain John Doe

echo $item->print_name(FALSE); // John Doe

echo $item->print_name(TRUE, TRUE); // CAPT John Doe

echo $item->print_name(TRUE, FALSE, TRUE); // Captain John William Doe</pre>
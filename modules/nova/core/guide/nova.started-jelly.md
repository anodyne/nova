# Getting Started with the Jelly ORM

Nova 1 used a series of models to interact with the database. Unfortunately, the API for the models was inconsistent and there were simply too many of them. Diving in to models was a complicated and daunting task. The goal with Nova 2 was to make database interaction simpler and easier. To that end, Nova 2 takes advantage of some of PHP 5's abilities and institutes an object relational mapper (ORM) for database interaction.

## What is an ORM?

So what the hell is an ORM anyway?

The simplest way is to think of it in terms of an address book. Every entry in the address book represents a single person along with zero or more phone numbers and zero or more addresses. We can think of the person as an object that has "slots" to hold the data the make up the entry: name, list of phone numbers, list of addresses, etc. The list of phone numbers would itself be an object with "slots" for each of the phone numbers a person has. The awesome thing about an ORM is that the single person contains all the information from all the different sources. From one variable, a developer can access a person, their phone number and their address even if all that information is stored in different database tables.

*Paraphrased from Wikipedia.*

## Why is Nova using an ORM?

The first question people will ask (especially people who are already familiar with Nova's model system) is why did it need to be changed? Simply put, Nova 1's models was a bad way of doing things. Technology was the single biggest constraint. With full PHP 4 support still intact in Nova 1, we couldn't code something as big as the model system leaving anyone on PHP 4 out in the cold.

When it came time to build Nova 2's new model system, the first avenue we took was to leave the model system intact but to build a Core model that would handle 95% of the interaction with the database. The model had methods for retrieving items, updating them, creating them, counting them and deleting them. It was great in theory, but when we started using the Core model we realized that in order to make it work right developers would have to work with large and complex multi-dimensional arrays in order to query the database for anything. What was a few lines in Nova 1 had suddenly become a dozen lines in Nova 2. That was a step in the wrong direction.

We've always said Nova would never use an ORM, but it only took a few minutes with Jelly to change our minds. Jelly is a simple ORM built for Kohana 3 that's easy-to-use, lightweight and incredibly powerful. For us, the turning point was when we finally got the news model set up and with a single line, we were able to pull a news item, its category information and all of its comments. A light went on for us that with a little more work in the models, we could provide developers with far more powerful tools in a much simpler interface.

## Does this mean all my models won't work?

Unfortunately, it does.

If you've developed custom models for MODs or extended Nova's models, those modifications are going away and you'll need to re-build them using Jelly. Fortunately, Jelly's syntax is really easy to pick up and in the next section, we'll talk specifically about how to work with Jelly to get information from the database as well as easily updating, creating and deleting information too.
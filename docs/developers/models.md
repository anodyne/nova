# Models

Models are PHP classes that are designed to handle the "heavy lifting" and business logic in an application. Often (and especially in Nova's case) they interact with a data source like a database to retrieve, create, delete, and update information so that code can be re-used through. Controllers are then used to call the model methods and interact with the data as necessary.

In every sense of the word, models are the heart and soul of Nova.

## The Base Model

Much like controllers have base controllers to set up certain functionality, models have a base model which gives every model access to some common methods that help unify the API and make it easier to interact with Nova's database tables.

### Creating a Record

### Updating a Record

### Deleting a Record

## Extending Existing Models

If in the `app`:

- Must have the namespace `Model`
- Must extend `\Fusion\Model\{Model}`
- Must add item to the app Autoloader to tell Nova to use your version

If in a module:

- Must have the namespace `{Module}\Model`
- Must extend `\Fusion\Model\{Model}`
- Must add item to the app Autoloader to tell Nova to use your version

## Creating New Models
# Models

## Extending Existing Models

If in the `app`:

- Must have the namespace `Model`
- Must extend `\Fusion\Model\{Model}`
- Must add item to the app Autoloader to tell Nova to use your version

If in a module:

- Must have the namespace `{Module}\Model`
- Must extend `\Fusion\Model\{Model}`
- Must add item to the app Autoloader to tell Nova to use your version
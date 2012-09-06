# Laravel 4 Transition

Given the forward-facing nature of Nova 3, we felt it was important to use a framework that reflected those ideals. We started working with FuelPHP extensively, but in the end, felt that the elegance and speed of Laravel was too much to ignore. Instead of building off of Laravel 3.2, we elected to build off of Laravel 4 and leverage some of the wide-reaching changes that have been coming to the PHP ecosystem for the last few months, namely decoupled components (distributed through Packagist), PSR-0 compliance, and more.

The following reflect some of the changes that are happening during the transition from the FuelPHP 1.2 foundation to Laravel 4.

## Standards

There has been a renewed focus on standards in PHP. While Nova wouldn't technically need to fall under these requirements because it isn't a decoupled component, we chose to stick to many of these standards as we moved forward. To that end, Nova 3 is fully compliant with PSR-0 and PSR-1.

In addition, we've worked to implement as many of the PSR-2 guidelines as possible, but in the end, Nova 3 is not fully PSR-2 compliant. Several of the rules simply didn't fit our eye, so we've chosen to ignore them. Specifically, the following rules from PSR-2 have not been implemented:

* Code MUST use an indent of 4 spaces, and MUST NOT use tabs for indenting.
* Property names SHOULD NOT be prefixed with a single underscore to indicate protected or private visibility.

## Dates

Laravel 4 does not contain built-in date features, and as such, we're using the [Date bundle](https://github.com/swt83/laravel-date) by swt83.

Using this bundle with UNIX timestamps (or in Laravel in general) isn't the easiest thing, so we've elected to move away from UNIX timestamps and use standard timestamps. During the upgrade process, Nova will change all UNIX timestamps over to standard timestamps.

`Date::forge(1333857600)->format()`

## Database

### Create observer functionality

Using FuelPHP 1.2 as a model, we need to duplicate the observer functionality for Laravel.

## Views

### Use Blade

We'll transition to using Blade view files.
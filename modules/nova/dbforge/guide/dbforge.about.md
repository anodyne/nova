# What is DBForge?

The Database Forge (or DBForge) is a class with a set of methods that are handy for working with and manipulating databases without having to write tons of SQL queries by hand. In short, the DBForge is for managing your database. Instead of writing long drawn out SQL queries, the DBForge allows you to make calls to methods that will create and drop databases, tables, columns and keys.

## Why Use DBForge?

Nova 2 uses the DBForge as a means of installing the entire system and facilitating updates to the system. The system is robust enough to do just about anything you want. This is a great tool for your own modules if you want to build a small installer to add a table or fields to an existing table. (You should never be dropping core tables ... doing that __will__ break Nova.) Head on over to the [examples](dbforge.examples) page for a walkthrough of how to use the DBForge.

## Credits

The DBForge was originally created by EllisLab as part of CodeIgniter. This class is a port of the CodeIgniter 1.7 version of the Database Forge to Kohana 3. All credit goes to the EllisLab team for first developing this tool.
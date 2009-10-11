<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|---------------------------------------------------------------
| UPDATE - SMS 2 TO 1.0.0
|---------------------------------------------------------------
|
| File: update/update_sms2.php
| System Version: 1.0
|
| File for updating some of the SMS 2 data to the new structures
|
*/

/*

What we're going to update:
	- awards
	- characters
	- globals
	- missions
	- news
	- news categories
	- personal logs
	- posts
	
What we're not going to update:
	- database
	- departments
	- positions
	- ranks
	- private messages
	- specs
	- starbase docking
	- strikes
	- system
	- system versions
	- tour
	- tour decks
	- menu items
	- chain of command

Sequence of events:
	- export the SQL data to a file (text/plain)
	- create new tables
	- insert test data
	- insert genre data
	- copy update-able tables' data to new tables

*/

/* End of file update_sms2.php */
/* Location: ./application/assets/update/update_sms2.php */
<?php

// get the browser info from the url
$browser = (isset($_GET['b'])) ? $_GET['b'] : FALSE;

// get the version info from the url
$version = (isset($_GET['v'])) ? $_GET['v'] : FALSE;

// get the version info from the url
$properVersion = (isset($_GET['pv'])) ? $_GET['pv'] : FALSE;

echo "The version of $browser that you're using, $version, isn't supported by Nova. At this time, Nova 2 requires $browser $properVersion to run. Please update to the latest version of $browser and try again.";
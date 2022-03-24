<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<title><?php echo $rss_feed_name; ?></title>

<link><?php echo $rss_feed_url; ?></link>
<description><?php echo $rss_description; ?></description>
<dc:language><?php echo $rss_feed_lang; ?></dc:language>
<dc:creator><?php echo $rss_creator_email; ?></dc:creator>

<dc:rights>Copyright <?php echo gmdate("Y", time()); ?></dc:rights>
<admin:generatorAgent rdf:resource="http://www.codeigniter.com/" />
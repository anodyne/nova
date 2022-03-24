<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php echo '<?xml version="1.0" encoding="utf-8"?>' . ""; ?>
<rss version="2.0"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:admin="http://webns.net/mvcb/"
	xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
	xmlns:content="http://purl.org/rss/1.0/modules/content/">

	<channel>
		<?php echo $header;?>
		<?php echo $items;?>
	</channel>
</rss>
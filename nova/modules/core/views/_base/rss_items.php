<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php if (isset($entries)): ?>
	<?php foreach($entries as $entry): ?>
		<item>
			<title><?php echo xml_convert($entry['title']); ?></title>
			<link><?php echo $entry['link'];?></link>
			<guid><?php echo $entry['link'];?></guid>
	
			<description><![CDATA[<?php echo $entry['content'];?>]]></description>
			<pubDate><?php echo date('r', $entry['date']);?></pubDate>
		</item>
	<?php endforeach; ?>
<?php endif;?>
<?php foreach($entries as $entry): ?>
	<item>
		<title><?php echo xml_convert($entry['title']); ?></title>
		<link><?php echo site_url('sim/viewpost/'. $entry['id']);?></link>
		<guid><?php echo site_url('sim/viewpost/'. $entry['id']);?></guid>

		<description><![CDATA[<?php echo $entry['content'];?>]]></description>
		<pubDate><?php echo date('r', $entry['date']);?></pubDate>
	</item>
<?php endforeach; ?>
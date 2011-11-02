<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($label['links'], 'h4');?>

<?php if (isset($panel_my_links) && is_array($panel_my_links)): ?>
	<ul class="padding1 fontSmall">
	<?php foreach ($panel_my_links as $link): ?>
		<li><?php echo $link;?></li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>
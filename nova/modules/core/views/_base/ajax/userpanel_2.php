<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php if (isset($panel_characters) && is_array($panel_characters)): ?>

	<?php echo text_output($label['characters'], 'h4');?>
	
	<ul class="padding1 fontSmall">
	<?php foreach ($panel_characters as $char): ?>
		<li>
			<?php echo anchor('personnel/character/'. $char['id'], $char['name']);?> &nbsp;&nbsp;
			<?php echo anchor('characters/bio/'. $char['id'], '[ Edit ]', array('class' => 'edit'));?>
		</li>
	<?php endforeach;?>
	</ul>
<?php endif;?>
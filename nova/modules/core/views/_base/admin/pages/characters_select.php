<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($label['choose_char'], 'h1', 'page-head');?>

<?php if (isset($characters)): ?>
	<?php if (isset($characters['active'])): ?>
		<?php echo text_output($label['type_active'], 'h3', 'page-subhead');?>
		<ul>
		<?php foreach ($characters['active'] as $k => $c): ?>
			<li><strong><?php echo anchor('characters/bio/'. $k, $c);?></strong></li>
		<?php endforeach;?>
		</ul>
	<?php endif;?>
	
	<?php if (isset($characters['npc'])): ?>
		<?php echo text_output($label['type_npc'], 'h3', 'page-subhead');?>
		<ul>
		<?php foreach ($characters['npc'] as $k => $c): ?>
			<li><strong><?php echo anchor('characters/bio/'. $k, $c);?></strong></li>
		<?php endforeach;?>
		</ul>
	<?php endif;?>
	
	<?php if (isset($characters['inactive'])): ?>
		<?php echo text_output($label['type_inactive'], 'h3', 'page-subhead');?>
		<ul>
		<?php foreach ($characters['inactive'] as $k => $c): ?>
			<li><strong><?php echo anchor('characters/bio/'. $k, $c);?></strong></li>
		<?php endforeach;?>
		</ul>
	<?php endif;?>
<?php endif;?>
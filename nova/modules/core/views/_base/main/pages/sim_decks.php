<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php if (isset($specs)): ?>
	<?php if (count($specs) > 0): ?>
		<?php foreach ($specs as $key => $value): ?>
			<?php echo anchor('sim/decks/'.$key, $value['name'], array('class' => 'bold fontMedium')).' &ndash; '.text_output($value['desc'], 'span', 'fontSmall');?>
			<br />
		<?php endforeach;?>
	<?php else: ?>
		<?php echo text_output($label['nodecks'], 'h3', 'orange');?>
	<?php endif;?>
<?php else: ?>
	<p><?php echo link_to_if($edit_valid, 'manage/decks', $label['edit'], array('class' => 'edit fontSmall bold'));?></p>
	
	<?php if (isset($decks)): ?>
		<?php if (isset($decks_menu)): ?>
			<p><?php echo $decks_menu;?></p>
			<hr />
		<?php endif;?>
		
		<?php foreach ($decks as $deck): ?>
			<kbd><a name="<?php echo $deck['id'];?>"></a><?php echo $deck['name'];?></kbd>
			<div class="indent-left"><?php echo text_output($deck['content']);?></div>
		<?php endforeach; ?>
	<?php else: ?>
		<?php echo text_output($label['nodecks'], 'h3', 'orange');?>
	<?php endif; ?>
<?php endif;?>
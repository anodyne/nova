<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo form_open($form_action);?>
	<p>
		<kbd><?php echo $label['author'];?></kbd>
		<?php echo text_output($character['name'], ''); ?>
		<?php echo form_hidden('author', $character['id']);?>
	</p>
	
	<p>
		<kbd><?php echo $label['title'];?></kbd>
		<?php echo form_input($inputs['title']);?>
	</p>
	
	<p>
		<kbd><?php echo $label['category'];?></kbd>
		<?php echo form_dropdown('newscat', $values['category'], $key['cat']);?>
	</p>
	
	<p>
		<kbd><?php echo $label['type'];?></kbd>
		<?php echo form_dropdown('private', $values['private'], $key['private']);?>
	</p>
	
	<p>
		<kbd><?php echo $label['content'];?></kbd>
		<?php echo form_textarea($inputs['content']);?>
	</p>
	
	<p>
		<kbd><?php echo $label['tags'];?></kbd>
		<?php echo text_output($label['tags_sep'], 'span', 'fontSmall gray bold');?><br />
		<?php echo form_input($inputs['tags']);?>
		<?php echo img($images['help']);?>
	</p><br />
	
	<p>
		<?php echo form_button($inputs['post']);?>
		&nbsp;
		<?php echo form_button($inputs['save']);?>
		
		<?php if ($this->uri->segment(3) !== FALSE): ?>
			&nbsp;
			<?php echo form_button($inputs['delete']);?>
		<?php endif; ?>

		&nbsp;
		<?php echo anchor('write/index', $label['back_wcp']);?>
	</p>
<?php echo form_close();?>
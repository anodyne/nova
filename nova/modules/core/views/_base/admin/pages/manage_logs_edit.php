<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<p class="bold"><?php echo anchor('manage/logs', $label['back']);?></p>

<?php echo form_open('manage/logs/edit/'. $id .'/update');?>
	<p>
		<kbd><?php echo $label['status'];?></kbd>
		<?php if (Auth::get_access_level() == 2): ?>
			<?php echo form_dropdown('log_status', $status, $inputs['status']);?>
		<?php else: ?>
			<?php echo text_output(ucfirst($inputs['status']), ''); ?>
			<?php echo form_hidden('log_status', $inputs['status']);?>
		<?php endif; ?>
	</p>
	
	<p>
		<kbd><?php echo $label['author'];?></kbd>
		<?php if (Auth::get_access_level() == 2): ?>
			<?php echo form_dropdown('log_author', $all, $inputs['author'], 'class="chosen"');?>
		<?php else: ?>
			<?php echo text_output($inputs['character'], ''); ?>
			<?php echo form_hidden('log_author', $inputs['author']);?>
		<?php endif; ?>
	</p>
	<p>
		<kbd><?php echo $label['title'];?></kbd>
		<?php echo form_input($inputs['title']);?>
	</p>
	<p>
		<kbd><?php echo $label['content'];?></kbd>
		<?php echo form_textarea($inputs['content']);?>
	</p>
	<p>
		<kbd><?php echo $label['tags'];?></kbd>
		<?php echo text_output($label['tags_inst'], 'span', 'fontSmall gray bold');?><br />
		<?php echo form_input($inputs['tags']);?>
	</p><br />
	
	<p><?php echo form_button($buttons['update']);?></p>
<?php echo form_close();?>
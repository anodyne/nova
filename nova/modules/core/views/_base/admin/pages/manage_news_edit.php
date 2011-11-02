<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<p class="bold"><?php echo anchor('manage/news', $label['back']);?></p>

<?php echo form_open('manage/news/edit/'. $id .'/update');?>
	<p>
		<kbd><?php echo $label['status'];?></kbd>
		<?php if (Auth::get_access_level() == 2): ?>
			<?php echo form_dropdown('news_status', $status, $inputs['status']);?>
		<?php else: ?>
			<?php echo text_output(ucfirst($inputs['status']), ''); ?>
			<?php echo form_hidden('news_status', $inputs['status']);?>
		<?php endif; ?>
	</p>
	
	<p>
		<kbd><?php echo $label['author'];?></kbd>
		<?php if (Auth::get_access_level() == 2): ?>
			<?php echo form_dropdown('news_author', $all, $inputs['author'], 'class="chosen"');?>
		<?php else: ?>
			<?php echo text_output($inputs['character'], ''); ?>
			<?php echo form_hidden('news_author', $inputs['author']);?>
		<?php endif; ?>
	</p>
	<p>
		<kbd><?php echo $label['title'];?></kbd>
		<?php echo form_input($inputs['title']);?>
	</p>
	<p>
		<kbd><?php echo $label['category'];?></kbd>
		<?php if (Auth::get_access_level() == 2): ?>
			<?php echo form_dropdown('news_cat', $categories, $inputs['category']);?>
		<?php else: ?>
			<?php echo text_output($inputs['category_name'], ''); ?>
			<?php echo form_hidden('news_cat', $inputs['category']);?>
		<?php endif; ?>
	</p>
	<p>
		<kbd><?php echo $label['private'];?></kbd>
		<?php if (Auth::get_access_level() == 2): ?>
			<?php echo form_dropdown('news_private', $private, $inputs['private']);?>
		<?php else: ?>
			<?php echo text_output($inputs['private_long'], ''); ?>
			<?php echo form_hidden('news_private', $inputs['private']);?>
		<?php endif; ?>
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
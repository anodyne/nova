<?php echo text_output($header, 'h1', 'page-head');?>

<p class="bold"><?php echo anchor('manage/posts', $label['back']);?></p>

<?php echo form_open('manage/posts/edit/'. $id .'/update');?>
	<p>
		<kbd><?php echo $label['status'];?></kbd>
		<?php if ($this->auth->get_access_level() == 2): ?>
			<?php echo form_dropdown('post_status', $status, $inputs['status']);?>
		<?php else: ?>
			<?php echo text_output(ucfirst($inputs['status']), ''); ?>
			<?php echo form_hidden('post_status', $inputs['status']);?>
		<?php endif;?>
	</p><br />
	
	<p>
		<kbd><?php echo $label['authors'];?></kbd>
		<?php echo form_dropdown('other_authors', $all, '', 'id = "all"');?>
		&nbsp;
		<a href="#" id="add_author" class="fontSmall"><?php echo $label['addauthor'];?></a>
		<input type="hidden" name="to" id="authors_hidden" value="<?php echo $to;?>" />
		<p id="authors">
			<?php if (isset($recipient_list)): ?>
				<?php foreach ($recipient_list as $r): ?>
					<?php echo $r ."\r\n";?>
				<?php endforeach; ?>
			<?php endif; ?>
		</p>
	</p><br />
	
	<p>
		<kbd><?php echo $label['mission'];?></kbd>
		<?php if ($this->auth->get_access_level() == 2): ?>
			<?php echo form_dropdown('post_mission', $missions, $inputs['mission']);?>
		<?php else: ?>
			<?php echo text_output(ucfirst($inputs['mission_name']), ''); ?>
			<?php echo form_hidden('post_mission', $inputs['mission']);?>
		<?php endif;?>
	</p>
	<p>
		<kbd><?php echo $label['title'];?></kbd>
		<?php echo form_input($inputs['title']);?>
	</p>
	<p>
		<kbd><?php echo $label['location'];?></kbd>
		<?php echo form_input($inputs['location']);?>
	</p>
	<p>
		<kbd><?php echo $label['timeline'];?></kbd>
		<?php echo form_input($inputs['timeline']);?>
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
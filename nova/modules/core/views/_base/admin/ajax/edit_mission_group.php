<?php echo text_output($header, 'h2');?>

<?php echo form_open('manage/missiongroups/edit');?>
	<?php echo form_hidden('id', $id);?>
	<p>
		<kbd><?php echo $label['name'];?></kbd>
		<?php echo form_input($inputs['name']);?>
	</p>
	
	<?php if ($inputs['parent'] !== false): ?>
		<p>
			<kbd><?php echo $label['parent'];?></kbd>
			<?php echo form_dropdown('misgroup_parent', $inputs['parent'], $inputs['parent_value'], 'class="hud"');?>
		</p>
	<?php endif;?>
	
	<p>
		<kbd><?php echo $label['order'];?></kbd>
		<?php echo form_input($inputs['order']);?>
	</p>
	<p>
		<kbd><?php echo $label['desc'];?></kbd>
		<?php echo form_textarea($inputs['desc']);?>
	</p>
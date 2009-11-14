<?php echo text_output($header, 'h2');?>
<?php echo text_output($text);?>

<p>
	<?php echo form_open('manage/depts/delete');?>
		<?php echo text_output($label['positions'], 'h3');?>
		
		<p><?php echo '<strong>'. form_label($label['delete'], 'delete_y') .'</strong> '. form_checkbox($inputs['delete']);?></p>
		
		<?php if ($dept_count > 1): ?>
			<p><strong><?php echo $label['reassign'];?></strong></p>
			<p><?php echo form_dropdown_dept('dept', '', 'class="hud"', 'main', '', $id);?></p>
		<?php endif;?>
		
		<?php if ($sub_count > 0): ?>
			<?php echo text_output($label['subdepts'], 'h3');?>
			
			<p>
				<strong><?php echo $label['reassign_sub'];?></strong><br />
				<?php echo text_output($reassign_text, 'span', 'fontSmall orange');?>
			</p>
			<p><?php echo form_dropdown_dept('subdept', '', 'class="hud"', 'main', '', $id, TRUE);?></p>
		<?php endif;?>
		
		<br />
		
		<?php echo form_hidden('id', $id);?>
		<?php echo form_button($inputs['submit']);?>
	<?php echo form_close();?><br />
</p>
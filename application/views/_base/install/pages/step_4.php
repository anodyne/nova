<?php echo text_output($label['inst_step4']);?>

<?php echo form_open('install/step/5');?>
	<table class="table100">
		<tr>
			<td class="cell-label"><?php echo $label['simname'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_input($inputs['sim_name']);?></td>
		</tr>
		<?php echo table_row_spacer(3, 5);?>
		<tr>
			<td class="cell-label"><?php echo $label['sysemail'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_dropdown('s_system_email', $email_v, $this->settings->get_setting('system_email'));?></td>
		</tr>
		<?php echo table_row_spacer(3, 5);?>
		<tr>
			<td class="cell-label"><?php echo $label['emailsubject'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_input($inputs['email_subject']);?></td>
		</tr>
		<?php echo table_row_spacer(3, 5);?>
		<tr>
			<td class="cell-label"><?php echo $label['updates'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_dropdown('s_updates', $updates_v, $this->settings->get_setting('updates'));?></td>
		</tr>
		<?php echo table_row_spacer(3, 5);?>
		<tr>
			<td class="cell-label"><?php echo $label['characters'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_input($inputs['num_chars']);?></td>
		</tr>
		<?php echo table_row_spacer(3, 5);?>
		<tr>
			<td class="cell-label"><?php echo $label['npcs'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_input($inputs['num_npc']);?></td>
		</tr>
		<?php echo table_row_spacer(3, 5);?>
		<tr>
			<td class="cell-label"><?php echo $label['dates'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_dropdown('s_date_format', $dates_v, $this->settings->get_setting('date_format'));?></td>
		</tr>
		
		<?php echo table_row_spacer(3, 15);?>
		
		<tr>
			<td colspan="3"><?php echo form_button($next);?></td>
		</tr>
	</table>
<?php echo form_close();?>
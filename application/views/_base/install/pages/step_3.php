<?php echo text_output($label['inst_step3']);?>

<?php echo form_open('install/step/4');?>
	<table class="table100">
		<tr>
			<td colspan="3" class="fontMedium bold"><?php echo $label['player'];?></td>
		</tr>
		<tr>
			<td class="cell_label"><?php echo $label['name'];?></td>
			<td class="cell_spacer"></td>
			<td><?php echo form_input($inputs['name']);?></td>
		</tr>
		<?php echo table_row_spacer(3, 5);?>
		<tr>
			<td class="cell_label"><?php echo $label['email'];?></td>
			<td class="cell_spacer"></td>
			<td><?php echo form_input($inputs['email']);?></td>
		</tr>
		<?php echo table_row_spacer(3, 5);?>
		<tr>
			<td class="cell_label"><?php echo $label['password'];?></td>
			<td class="cell_spacer"></td>
			<td><?php echo form_password($inputs['password']);?></td>
		</tr>
		<?php echo table_row_spacer(3, 5);?>
		<tr>
			<td class="cell_label"><?php echo $label['dob'];?></td>
			<td class="cell_spacer"></td>
			<td><?php echo form_input($inputs['dob']);?></td>
		</tr>
		<?php echo table_row_spacer(3, 5);?>
		<tr>
			<td class="cell_label"><?php echo $label['question'];?></td>
			<td class="cell_spacer"></td>
			<td><?php echo form_dropdown('security_question', $questions);?></td>
		</tr>
		<?php echo table_row_spacer(3, 5);?>
		<tr>
			<td class="cell_label"><?php echo $label['answer'];?></td>
			<td class="cell_spacer"></td>
			<td>
				<?php echo text_output($label['remember'], 'span', 'fontSmall gray bold');?><br />
				<?php echo form_input($inputs['security_answer']);?>
			</td>
		</tr>
		<?php echo table_row_spacer(3, 5);?>
		<tr>
			<td class="cell_label"><?php echo $label['timezone'];?></td>
			<td class="cell_spacer"></td>
			<td><?php echo timezone_menu('UTC');?></td>
		</tr>
		
		<?php echo table_row_spacer(3, 15);?>
		
		<tr>
			<td colspan="3" class="fontMedium bold"><?php echo $label['character'];?></td>
		</tr>
		<tr>
			<td class="cell_label"><?php echo $label['fname'];?></td>
			<td class="cell_spacer"></td>
			<td><?php echo form_input($inputs['first_name']);?></td>
		</tr>
		<?php echo table_row_spacer(3, 5);?>
		<tr>
			<td class="cell_label"><?php echo $label['lname'];?></td>
			<td class="cell_spacer"></td>
			<td><?php echo form_input($inputs['last_name']);?></td>
		</tr>
		<?php echo table_row_spacer(3, 5);?>
		<tr>
			<td class="cell_label"><?php echo $label['rank'];?></td>
			<td class="cell_spacer"></td>
			<td>
				<?php echo form_dropdown_rank('rank', '', 'id="rank"');?>
				&nbsp; <span id="loading_update_rank" class="hidden fontSmall gray"><?php echo img($loading);?></span>
				<p id="rank_img" class="fontSmall gray"><?php echo img($default_rank);?></p>
			</td>
		</tr>
		<?php echo table_row_spacer(3, 5);?>
		<tr>
			<td class="cell_label"><?php echo $label['position'];?></td>
			<td class="cell_spacer"></td>
			<td>
				<?php echo form_dropdown_position('position', '', 'id="position"', 'open');?>
				&nbsp; <span id="loading_update" class="hidden fontSmall gray"><?php echo img($loading);?></span>
				<p id="position_desc" class="fontSmall gray"></p>
			</td>
		</tr>
		
		<?php echo table_row_spacer(3, 15);?>
		
		<tr>
			<td colspan="3"><?php echo form_button($next);?></td>
		</tr>
	</table>
<?php echo form_close();?>
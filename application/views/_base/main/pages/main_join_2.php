<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo form_open('main/join');?>
	<?php echo text_output($label['user_info'], 'h3', 'page-subhead');?>
	<table class="table100">
		<tr>
			<td class="cell-label"><?php echo $label['name'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_input($inputs['name']);?></td>
		</tr>
		<tr>
			<td class="cell-label"><?php echo $label['email'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_input($inputs['email']);?></td>
		</tr>
		<tr>
			<td class="cell-label"><?php echo $label['password'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_password($inputs['password']);?></td>
		</tr>
		<?php echo table_row_spacer(3, 20);?>
		<tr>
			<td class="cell-label"><?php echo $label['dob'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_input($inputs['dob']);?></td>
		</tr>
		<?php echo table_row_spacer(3, 20);?>
		<tr>
			<td class="cell-label"><?php echo $label['im'];?></td>
			<td class="cell-spacer"></td>
			<td>
				<?php echo text_output($label['im_inst'], 'span', 'fontSmall orange bold');?><br />
				<?php echo form_textarea($inputs['im']);?>
			</td>
		</tr>
	</table><br />
	
	<?php echo text_output($label['character'], 'h3', 'page-subhead');?>
	<table class="table100">
		<tr>
			<td class="cell-label"><?php echo $label['fname'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_input($inputs['first_name']);?></td>
		</tr>
		<tr>
			<td class="cell-label"><?php echo $label['mname'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_input($inputs['middle_name']);?></td>
		</tr>
		<tr>
			<td class="cell-label"><?php echo $label['lname'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_input($inputs['last_name']);?></td>
		</tr>
		<tr>
			<td class="cell-label"><?php echo $label['suffix'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_input($inputs['suffix']);?></td>
		</tr>
		<?php echo table_row_spacer(3, 20);?>
		<tr>
			<td class="cell-label"><?php echo $label['position'];?></td>
			<td class="cell-spacer"></td>
			<td>
				<?php echo form_dropdown_position('position_1', $selected_position, 'id="position"', 'open');?>
				&nbsp; <span id="loading_update" class="hidden fontSmall gray"><?php echo img($loading);?></span>
				<p id="position_desc" class="fontSmall gray"><?php echo text_output($pos_desc, '');?></p>
			</td>
		</tr>
	</table><br />

	<?php if (isset($join)): ?>
		<?php foreach ($join as $a): ?>
			<?php if (isset($a['fields'])): ?>
				<?php echo text_output($a['name'], 'h3', 'page-subhead');?>
				
				<table class="table100">
					<tbody>
						
					<?php foreach ($a['fields'] as $f): ?>
						<tr>
							<td class="cell-label"><?php echo $f['field_label'];?></td>
							<td class="cell-spacer"></td>
							<td><?php echo $f['input'];?></td>
						</tr>
					<?php endforeach; ?>
					
					</tbody>
				</table><br />
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>
	
	<?php if ($this->options['use_sample_post'] == 'y'): ?>
		<?php echo text_output($label['other'], 'h3', 'page-subhead');?>
		<table class="table100">
			<?php if ($this->options['use_sample_post'] == 'y'): ?>
				<tr>
					<td colspan="2"></td>
					<td><?php echo text_output($sample_post_msg, 'p', 'fontSmall bold gray');?></td>
				</tr>
				<tr>
					<td class="cell-label"><?php echo $label['samplepost'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo form_textarea($inputs['sample_post']);?></td>
				</tr>
			<?php endif; ?>
		</table><br />
	<?php endif; ?>
	
	<?php echo form_hidden('submit', 'y');?>
	<p><?php echo form_button($button['submit']);?></p>
<?php echo form_close();?>
<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo form_open('characters/create');?>
	<?php echo text_output($label['character'], 'h3', 'page-subhead');?>
	<table class="table100">
		<tr>
			<td class="cell-label"><?php echo $label['type'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_dropdown('type', $type, 'npc');?></td>
		</tr>
		
		<?php echo table_row_spacer(3, 20);?>
		
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
			<td class="cell-label"><?php echo $label['position1'];?></td>
			<td class="cell-spacer"></td>
			<td>
				<?php echo form_dropdown_position('position_1', $inputs['position1_id'], 'id="position1"', 'all');?>
				&nbsp; <span id="loading_pos1" class="hidden fontSmall gray"><?php echo img($images['loading']);?></span>
				<p id="position1_desc" class="fontSmall gray"><?php echo text_output($inputs['position1_desc'], '');?></p>
			</td>
		</tr>
		
		<tr>
			<td class="cell-label"><?php echo $label['position2'];?></td>
			<td class="cell-spacer"></td>
			<td>
				<?php echo form_dropdown_position('position_2', $inputs['position2_id'], 'id="position2"', 'all');?>
				&nbsp; <span id="loading_pos2" class="hidden fontSmall gray"><?php echo img($images['loading']);?></span>
				<p id="position2_desc" class="fontSmall gray"><?php echo text_output($inputs['position2_desc'], '');?></p>
			</td>
		</tr>
		
		<?php echo table_row_spacer(3, 20);?>
		
		<tr>
			<td class="cell-label"><?php echo $label['rank'];?></td>
			<td class="cell-spacer"></td>
			<td>
				<?php echo form_dropdown_rank('rank', $inputs['rank_id'], 'id="rank"');?>
				&nbsp; <span id="loading_rank" class="hidden fontSmall gray"><?php echo img($images['loading']);?></span>
				<p id="rank_img" class="fontSmall gray"><?php echo img($inputs['rank']);?></p>
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
	
	<br />
	<table class="table100">
		<tbody>
			<tr>
				<td class="cell-label"></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_button($button['submit']);?></td>
			</tr>
		</tbody>
	</table>
<?php echo form_close();?>
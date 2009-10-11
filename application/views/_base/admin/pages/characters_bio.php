<?php echo text_output($header, 'h1', 'page-head');?>

<div id="tabs">
		<ul>
			<li><a href="#one"><span><?php echo $label['info'];?></span></a></li>
			<li><a href="#two"><span><?php echo $label['images'];?></span></a></li>
		</ul>

<?php echo form_open('characters/bio/'. $id);?>
	<div id="one">
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
			
			<?php if ($level >= 2): ?>
				<?php if ($level == 3): ?>
					<tr>
						<td class="cell-label"><?php echo $label['type'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo form_dropdown('crew_type', $values['crew_type'], $inputs['crew_type']);?></td>
					</tr>
					
					<?php echo table_row_spacer(3, 20);?>
				<?php endif;?>
				
				<?php if (($level == 2 && $inputs['crew_type'] == 'npc') || $level == 3): ?>
					<tr>
						<td class="cell-label"><?php echo $label['position1'];?></td>
						<td class="cell-spacer"></td>
						<td>
							<?php echo form_dropdown_position('position_1', $inputs['position1_id'], 'id="position1"', 'all');?>
							&nbsp; <span id="loading_pos1" class="hidden fontSmall gray"><?php echo img($images['loading']);?></span>
							<p id="position1_desc" class="fontSmall gray"><?php echo text_output($inputs['position1_desc'], '');?></p>
							<?php echo form_hidden('position_1_old', $inputs['position1_id']);?>
						</td>
					</tr>
					
					<tr>
						<td class="cell-label"><?php echo $label['position2'];?></td>
						<td class="cell-spacer"></td>
						<td>
							<?php echo form_dropdown_position('position_2', $inputs['position2_id'], 'id="position2"', 'all');?>
							&nbsp; <span id="loading_pos2" class="hidden fontSmall gray"><?php echo img($images['loading']);?></span>
							<p id="position2_desc" class="fontSmall gray"><?php echo text_output($inputs['position2_desc'], '');?></p>
							<?php echo form_hidden('position_2_old', $inputs['position2_id']);?>
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
				<?php endif;?>
			<?php else: ?>
				<tr>
					<td class="cell-label"><?php echo $label['position1'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo $inputs['position1_name'];?></td>
				</tr>
				
				<?php if (!empty($inputs['position2_id'])): ?>
					<tr>
						<td class="cell-label"><?php echo $label['position2'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo $inputs['position2_name'];?></td>
					</tr>
				<?php endif;?>
				
				<?php echo table_row_spacer(3, 20);?>
				
				<tr>
					<td class="cell-label"><?php echo $label['rank'];?></td>
					<td class="cell-spacer"></td>
					<td>
						<?php echo img($inputs['rank']);?><br />
						<?php echo text_output($inputs['rank_name'], 'span', 'fontSmall gray');?>
					</td>
				</tr>
			<?php endif;?>
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
	</div>
	
	<div id="two">
		<?php echo text_output($image_instructions);?>
		
		<p><?php echo anchor('upload/index', img($images['upload']) .' '. $label['upload'], array('class' => 'image fontMedium bold'));?></p>
		
		<?php echo form_textarea($inputs['images']);?>
		<br />
		
		<?php if (isset($myuploads)): ?>
			<?php echo text_output($label['myuploads'], 'h3');?>
			<table class="table100 zebra">
				<tbody>
				<?php foreach ($myuploads as $d): ?>
					<tr>
						<td class="cell-label">
							<a href="#" class="imagepick" myfile="<?php echo $d['file'];?>"><?php echo $d['file'];?></a>
						</td>
						<td class="cell-spacer"></td>
						<td>
							<a href="#" class="imagepick image" myfile="<?php echo $d['file'];?>"><?php echo img($d['image']);?></a>
						</td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table><br />
		<?php endif;?>
		
		<table class="table100 zebra">
			<tbody>
			<?php foreach ($directory as $d): ?>
				<tr>
					<td class="cell-label">
						<a href="#" class="imagepick" myfile="<?php echo $d['file'];?>"><?php echo $d['file'];?></a>
					</td>
					<td class="cell-spacer"></td>
					<td><?php echo img($d['image']);?></td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
	</div>
	
	<br /><?php echo form_button($button['submit']);?></td>
<?php echo form_close();?>
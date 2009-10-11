<?php echo text_output($header, 'h1', 'page-head');?>

<p class="bold fontMedium"><?php echo anchor('manage/missions', $label['back']);?></p>

<div id="tabs">
	<ul>
		<li><a href="#one"><span><?php echo $label['info'];?></span></a></li>
		<li><a href="#two"><span><?php echo $label['images'];?></span></a></li>
	</ul>

	<?php echo form_open('manage/missions/'. $form);?>
	<div id="one">
		<br />
		<table class="table100">
			<tbody>
				<tr>
					<td class="cell-label"><?php echo $label['title'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo form_input($inputs['title']);?></td>
				</tr>
				<tr>
					<td class="cell-label"><?php echo $label['status'];?></td>
					<td class="cell-spacer"></td>
					<td>
						<?php echo form_dropdown('mission_status', $values['status'], $inputs['status']);?>
						<?php echo form_hidden('mission_oldstatus', $inputs['status']);?>
					</td>
				</tr>
				<tr>
					<td class="cell-label"><?php echo $label['order'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo form_input($inputs['order']);?></td>
				</tr>
				
				<?php echo table_row_spacer(3, 15);?>
				
				<tr>
					<td class="cell-label"><?php echo $label['start'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo form_input($inputs['start']);?></td>
				</tr>
				<tr>
					<td class="cell-label"><?php echo $label['end'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo form_input($inputs['end']);?></td>
				</tr>
				
				<?php echo table_row_spacer(3, 15);?>
				
				<tr>
					<td class="cell-label"><?php echo $label['desc'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo form_textarea($inputs['desc']);?></td>
				</tr>
				
				<?php echo table_row_spacer(3, 15);?>
				
				<tr>
					<td class="cell-label"><?php echo $label['summary'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo form_textarea($inputs['summary']);?></td>
				</tr>
				
				<?php echo table_row_spacer(3, 15);?>
				
				<tr>
					<td class="cell-label"><?php echo $label['notes'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo form_textarea($inputs['notes']);?></td>
				</tr>
			</tbody>
		</table>
	</div>
	
	<div id="two">
		<?php echo text_output($image_instructions);?>
		
		<p><?php echo anchor('upload/index', img($images['upload']) .' '. $label['upload'], array('class' => 'image fontMedium bold'));?></p>
		
		<?php echo form_textarea($inputs['images']);?>
		<br />
		
		<table class="table100 zebra">
			<tbody>
			<?php foreach ($directory as $d): ?>
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
		</table>
	</div>
	
	<br />
	<?php echo form_hidden('id', $id);?>
	<?php echo form_button($buttons['submit']);?>
	
	<?php echo form_close();?>
</div>
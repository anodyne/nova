<?php echo text_output($header, 'h1', 'page-head');?>

<p class="bold fontMedium"><?php echo anchor('manage/tour', $label['back']);?></p>

<div id="tabs">
	<ul>
		<li><a href="#one"><span><?php echo $label['info'];?></span></a></li>
		<li><a href="#two"><span><?php echo $label['images'];?></span></a></li>
	</ul>

	<?php echo form_open('manage/tour/'. $form);?>
	<div id="one">
		<br />
		<table class="table100">
			<tbody>
				<tr>
					<td class="cell-label"><?php echo $label['name'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo form_input($inputs['name']);?></td>
				</tr>
				
				<?php echo table_row_spacer(3, 10);?>
				
				<tr>
					<td class="cell-label"><?php echo $label['order'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo form_input($inputs['order']);?></td>
				</tr>
				
				<?php echo table_row_spacer(3, 10);?>
				
				<tr>
					<td class="cell-label"><?php echo $label['display'];?></td>
					<td class="cell-spacer"></td>
					<td>
						<?php echo form_radio($inputs['display_y']) .' '. form_label($label['on'], 'display_y');?>
						<?php echo form_radio($inputs['display_n']) .' '. form_label($label['off'], 'display_n');?>
					</td>
				</tr>
				
				<?php echo table_row_spacer(3, 10);?>
				
				<tr>
					<td class="cell-label"><?php echo $label['summary'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo form_textarea($inputs['summary']);?></td>
				</tr>
				
				<?php echo table_row_spacer(3, 10);?>
				
				<?php if (isset($inputs['fields'])): ?>
					<?php foreach ($inputs['fields'] as $f): ?>
						<tr>
							<td class="cell-label"><?php echo $f['field_label'];?></td>
							<td class="cell-spacer"></td>
							<td><?php echo $f['input'];?></td>
						</tr>
						
						<?php echo table_row_spacer(3, 10);?>
					<?php endforeach;?>
				<?php endif;?>
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
	<?php echo form_button($inputs['submit']);?>
	
	<?php echo form_close();?>
</div>
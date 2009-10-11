<?php echo text_output($header, 'h1', 'page-head');?>

<p class="bold fontMedium"><?php echo anchor('manage/awards', $label['back']);?></p>

<div id="tabs">
	<ul>
		<li><a href="#one"><span><?php echo $label['info'];?></span></a></li>
		<li><a href="#two"><span><?php echo $label['images'];?></span></a></li>
	</ul>

	<?php echo form_open('manage/awards/'. $form);?>
	<div id="one">
		<br />
		<table class="table100">
			<tbody>
				<tr>
					<td class="cell-label"><?php echo $label['name'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo form_input($inputs['name']);?></td>
				</tr>
				<tr>
					<td class="cell-label"><?php echo $label['order'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo form_input($inputs['order']);?></td>
				</tr>
				<tr>
					<td class="cell-label"><?php echo $label['cat'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo form_dropdown('award_cat', $values['cat'], $inputs['cat']);?></td>
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
					<td class="cell-label"><?php echo $label['desc'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo form_textarea($inputs['desc']);?></td>
				</tr>
			</tbody>
		</table>
	</div>
	
	<div id="two">
		<?php echo text_output($image_instructions);?>
		
		<p><?php echo anchor('upload/index', img($images['upload']) .' '. $label['upload'], array('class' => 'image fontMedium bold'));?></p>
		
		<?php echo form_input($inputs['images']);?>
		<br /><br />
		
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
<?php echo text_output($header, 'h1', 'page-head');?>

<p class="bold fontMedium"><?php echo anchor('manage/missions', $label['back']);?></p>

<div id="tabs">
	<ul>
		<li><a href="#one"><span><?php echo $label['info'];?></span></a></li>
		<li><a href="#two"><span><?php echo $label['images'];?></span></a></li>
	</ul>

	<?php echo form_open('manage/missions/'. $form);?>
	<div id="one">
		<p>
			<kbd><?php echo $label['title'];?></kbd>
			<?php echo form_input($inputs['title']);?>
		</p>
		<p>
			<kbd><?php echo $label['status'];?></kbd>
			<?php echo form_dropdown('mission_status', $values['status'], $inputs['status']);?>
			<?php echo form_hidden('mission_oldstatus', $inputs['status']);?>
		</p>
		<p>
			<kbd><?php echo $label['order'];?></kbd>
			<?php echo form_input($inputs['order']);?>
		</p><br />
		
		<p>
			<kbd><?php echo $label['start'];?></kbd>
			<?php echo form_input($inputs['start']);?>
		</p>
		<p>
			<kbd><?php echo $label['end'];?></kbd>
			<?php echo form_input($inputs['end']);?>
		</p><br />
		
		<p>
			<kbd><?php echo $label['desc'];?></kbd>
			<?php echo form_textarea($inputs['desc']);?>
		</p>
		<p>
			<kbd><?php echo $label['summary'];?></kbd>
			<?php echo form_textarea($inputs['summary']);?>
		</p>
		<p>
			<kbd><?php echo $label['notes'];?></kbd>
			<?php echo form_textarea($inputs['notes']);?>
		</p>
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
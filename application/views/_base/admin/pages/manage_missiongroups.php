<?php echo text_output($header, 'h1', 'page-head');?>

<p class="bold">
	<a href="#" id="add" class="image"><?php echo img($images['add']) .' '. $label['addgroup'];?></a>
</p>

<div id="add_group" class="info-full hidden">
	<?php echo form_open('manage/missiongroups/add');?>
		<p>
			<kbd><?php echo $label['name'];?></kbd>
			<input type="text" name="misgroup_name" />
		</p>
		<p>
			<kbd><?php echo $label['order'];?></kbd>
			<input type="text" class="small" name="misgroup_order" value="99" />
		</p>
		<p>
			<kbd><?php echo $label['desc'];?></kbd>
			<textarea name="misgroup_desc" rows="3"></textarea>
		</p>
		<p><?php echo form_button($buttons['add']);?></p>
	<?php echo form_close();?>
</div>

<?php if (isset($groups)): ?>
	<br /><hr /><br />
	
	<div class="zebra">
	<?php echo form_open('manage/missiongroups/edit');?>
	
		<?php foreach ($groups as $g): ?>
			<div id="<?php echo $g['id'];?>" class="padding_p5_0_p5_0">
				<table class="table100">
					<tr>
						<td>
							<?php echo text_output($label['name'], 'span', 'bold');?><br />
							<?php echo form_input($g['name']);?>
						</td>
						<td class="col_150">
							<?php echo text_output($label['order'], 'span', 'bold');?><br />
							<?php echo form_input($g['order']);?>
						</td>
						<td rowspan="2" class="align_right align_middle col_100">
							<strong><?php echo form_label($label['delete'], $g['id'] .'_id');?>?</strong>
							<?php echo form_checkbox($g['delete']);?>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<?php echo text_output($label['desc'], 'span', 'bold');?><br />
							<?php echo form_textarea($g['desc']);?>
						</td>
					</tr>
				</table>
			</div>
		<?php endforeach;?>
		
		<br />
		<?php echo form_button($buttons['update']);?>
	<?php echo form_close();?>
	</div>
<?php endif;?>
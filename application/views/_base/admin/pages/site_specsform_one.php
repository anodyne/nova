<?php echo text_output($header, 'h1', 'page-head');?>

<p class="bold"><?php echo anchor('site/specsform', $label['back']);?></p>

<?php if (isset($inputs)): ?>
	<?php echo form_open('site/specsform/edit/'. $id);?>
		<table class="table100 zebra">
			<tbody>
				<tr>
					<td class="cell-label"><?php echo $label['section'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo form_dropdown('field_section', $values['section'], $defaults['section']);?></td>
				</tr>
				<tr>
					<td class="cell-label"><?php echo $label['type'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo form_dropdown('field_type', $values['type'], $defaults['type']);?></td>
				</tr>
				<tr>
					<td class="cell-label"><?php echo $label['label'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo form_input($inputs['label']);?></td>
				</tr>
				<tr>
					<td class="cell-label"><?php echo $label['order'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo form_input($inputs['order']);?></td>
				</tr>
				<tr>
					<td class="cell-label"><?php echo $label['display'];?></td>
					<td class="cell-spacer"></td>
					<td>
						<?php echo form_radio($inputs['display_y']);?>
						<?php echo form_label($label['yes'], 'field_display_y');?>
						
						<?php echo form_radio($inputs['display_n']);?>
						<?php echo form_label($label['no'], 'field_display_n');?>
					</td>
				</tr>
			</tbody>
		</table><br />
		
		<?php echo text_output($label['html'], 'h4');?>
		
		<table class="table100 zebra">
			<tbody>
				<tr>
					<td class="cell-label"><?php echo $label['name'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo form_input($inputs['name']);?></td>
				</tr>
				<tr>
					<td class="cell-label"><?php echo $label['id'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo form_input($inputs['fid']);?></td>
				</tr>
				<tr>
					<td class="cell-label"><?php echo $label['class'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo form_input($inputs['class']);?></td>
				</tr>
				<tr>
					<td class="cell-label"><?php echo $label['rows'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo form_input($inputs['rows']);?></td>
				</tr>
			</tbody>
		</table><br />
		
		<table class="table100">
			<tbody>
				<tr>
					<td class="cell-label"></td>
					<td class="cell-spacer"></td>
					<td>
						<?php echo form_hidden('field_id', $id);?>
						<?php echo form_button($buttons['submit']);?>
					</td>
				</tr>
			</tbody>
		</table>
	<?php echo form_close();?>
	
	<?php if (isset($select)): ?>
		<br /><hr /><br />
		<?php echo text_output($label['values'], 'h2', 'page-subhead');?>
		<?php echo text_output($label['bioval']);?><br />
		
		<?php echo text_output($label['value'], 'span', 'bold') .'<br />'. form_input($inputs['val_add_value']);?>
		<br /><br />
		<?php echo text_output($label['content'], 'span', 'bold') .'<br />'. form_input($inputs['val_add_content']);?>
		<br /><br />
		
		<?php echo form_button($buttons['add']);?>
		&nbsp;
		<span id="loading_add" class="hidden fontSmall gray"><?php echo img($loading);?></span>
		
		<p>&nbsp;</p>
		
		<div class="UITheme">
			<ul id="list">
				<?php foreach ($select as $key => $value): ?>
					<li class="ui-state-default" id="value_<?php echo $key;?>">
						<div class="float_right"><a href="#" class="remove image" name="remove" id="<?php echo $key;?>">x</a></div>
						<a href="#" rel="facebox" myAction="edit_val" myField="<?php echo $id;?>" class="image" myID="<?php echo $key;?>"/><?php echo $value;?></a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		
		<br />
		<?php echo form_button($buttons['update']);?>
		&nbsp;
		<span id="loading_update" class="hidden fontSmall gray"><?php echo img($loading);?></span>
	<?php endif; ?>
<?php endif; ?>
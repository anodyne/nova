<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo form_open($form_action);?>
	<table class="table100">
		<tr>
			<td class="cell-label"><?php echo $label['author'];?></td>
			<td class="cell-spacer"></td>
			<td>
				<?php echo text_output($character['name'], ''); ?>
				<?php echo form_hidden('author', $character['id']);?>
			</td>
		</tr>
		
		<?php echo table_row_spacer(3, 10);?>
		
		<tr>
			<td class="cell-label"><?php echo $label['title'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_input($inputs['title']);?></td>
		</tr>
		
		<?php echo table_row_spacer(3, 10);?>
		
		<tr>
			<td class="cell-label"><?php echo $label['category'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_dropdown('newscat', $values['category'], $key['cat']);?></td>
		</tr>
		
		<?php echo table_row_spacer(3, 10);?>
		
		<tr>
			<td class="cell-label"><?php echo $label['type'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_dropdown('private', $values['private'], $key['private']);?></td>
		</tr>
		
		<?php echo table_row_spacer(3, 10);?>
		
		<tr>
			<td class="cell-label"><?php echo $label['content'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_textarea($inputs['content']);?></td>
		</tr>
		
		<?php echo table_row_spacer(3, 10);?>
		
		<tr>
			<td class="cell-label"><?php echo $label['tags'];?></td>
			<td class="cell-spacer"></td>
			<td>
				<?php echo text_output($label['tags_sep'], 'span', 'fontSmall gray bold');?><br />
				<?php echo form_input($inputs['tags']);?>
			</td>
		</tr>
		
		<?php echo table_row_spacer(3, 20);?>
		
		<tr>
			<td colspan="2"></td>
			<td>
				<?php echo form_button($inputs['post']);?>
				&nbsp;
				<?php echo form_button($inputs['save']);?>
				
				<?php if ($this->uri->segment(3) !== FALSE): ?>
					&nbsp;
					<?php echo form_button($inputs['delete']);?>
				<?php endif; ?>
			</td>
		</tr>
	</table>
<?php echo form_close();?>
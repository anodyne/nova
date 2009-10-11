<?php echo text_output($header, 'h1', 'page-head');?>

<p class="fontMedium bold"><?php echo anchor('manage/logs', $label['back']);?></p>

<?php echo form_open('manage/logs/edit/'. $id .'/update');?>
	<table class="table100">
		<tr>
			<td class="cell-label"><?php echo $label['title'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_input($inputs['title']);?></td>
		</tr>
		
		<?php echo table_row_spacer(3, 10);?>
		
		<tr>
			<td class="cell-label"><?php echo $label['author'];?></td>
			<td class="cell-spacer"></td>
			<td>
				<?php if ($this->auth->get_access_level() == 2): ?>
					<?php echo form_dropdown('log_author', $all, $inputs['author']);?>
				<?php else: ?>
					<?php echo text_output($inputs['character'], ''); ?>
					<?php echo form_hidden('log_author', $inputs['author']);?>
				<?php endif; ?>
			</td>
		</tr>
		
		<?php echo table_row_spacer(3, 10);?>
		
		<tr>
			<td class="cell-label"><?php echo $label['status'];?></td>
			<td class="cell-spacer"></td>
			<td>
				<?php if ($this->auth->get_access_level() == 2): ?>
					<?php echo form_dropdown('log_status', $status, $inputs['status']);?>
				<?php else: ?>
					<?php echo text_output(ucfirst($inputs['status']), ''); ?>
					<?php echo form_hidden('log_status', $inputs['status']);?>
				<?php endif; ?>
			</td>
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
				<?php echo text_output($label['tags_inst'], 'span', 'fontSmall gray bold');?><br />
				<?php echo form_input($inputs['tags']);?>
			</td>
		</tr>
		
		<?php echo table_row_spacer(3, 20);?>
		
		<tr>
			<td colspan="2"></td>
			<td>
				<?php echo form_button($buttons['update']);?>
			</td>
		</tr>
	</table>
<?php echo form_close();?>
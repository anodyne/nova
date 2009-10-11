<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($msg);?>

<?php echo form_open('main/contact');?>
	<table class="table100">
		<tr>
			<td class="cell-label"><?php echo $label['send'];?></td>
			<td class="cell-spacer"></td>
			<td class="cell_content"><?php echo form_dropdown('to', $values['to'], 0);?></td>
		</tr>
		<?php echo table_row_spacer(3, 5);?>
		<tr>
			<td class="cell-label"><?php echo $label['name'];?></td>
			<td class="cell-spacer"></td>
			<td class="cell_content"><?php echo form_input($inputs['name']);?></td>
		</tr>
		<?php echo table_row_spacer(3, 5);?>
		<tr>
			<td class="cell-label"><?php echo $label['email'];?></td>
			<td class="cell-spacer"></td>
			<td class="cell_content"><?php echo form_input($inputs['email']);?></td>
		</tr>
		<?php echo table_row_spacer(3, 5);?>
		<tr>
			<td class="cell-label"><?php echo $label['subject'];?></td>
			<td class="cell-spacer"></td>
			<td class="cell_content"><?php echo form_input($inputs['subject']);?></td>
		</tr>
		<?php echo table_row_spacer(3, 5);?>
		<tr>
			<td class="cell-label"><?php echo $label['message'];?></td>
			<td class="cell-spacer"></td>
			<td class="cell_content"><?php echo form_textarea($inputs['message']);?></td>
		</tr>
		<?php echo table_row_spacer(3, 15);?>
		<tr>
			<td colspan="2"></td>
			<td class="cell_content"><?php echo form_button($button['submit']);?></td>
		</tr>
	</table>
<?php echo form_close();?>
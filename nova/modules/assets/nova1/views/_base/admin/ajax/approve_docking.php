<?php echo text_output($header, 'h2');?>

<?php echo text_output($text);?>

<?php echo form_open($form);?>
	<table class="table100">
		<tbody>
			<tr>
				<td class="cell-label"><?php echo $label['email'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_textarea($values['email']);?></td>
			</tr>
			
			<?php echo table_row_spacer(3, 15);?>
			
			<tr>
				<td colspan="2"></td>
				<td>
					<?php echo form_hidden('id', $id);?>
					<?php echo form_hidden('action', 'approve');?>
					<?php echo form_button($inputs['submit']);?>
				</td>
			</tr>
		</tbody>
	</table>
<?php echo form_close();?><br />
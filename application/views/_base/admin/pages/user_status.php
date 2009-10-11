<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($label['text']);?>
<br />

<?php echo form_open('user/status');?>
	<table class="table100">
		<tbody>
			<tr>
				<td class="cell-label"><?php echo $label['status'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_dropdown('status', $values['loa'], $inputs['loa']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['duration'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_textarea($inputs['duration']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['reason'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_textarea($inputs['reason']);?></td>
			</tr>
			
			<?php echo table_row_spacer(3, 15);?>
			
			<tr>
				<td colspan="2"></td>
				<td><?php echo form_button($buttons['submit']);?></td>
			</tr>
		</tbody>
	</table>
<?php echo form_close();?>
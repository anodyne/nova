<?php echo text_output($label['text']);?>

<?php echo form_open('update/index');?>
	<table class="table100">
		<tbody>
			<tr>
				<td class="cell-label"><?php echo $label['email'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['email']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['password'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_password($inputs['password']);?></td>
			</tr>
			<?php echo table_row_spacer(3, 15);?>
			<tr>
				<td colspan="2"></td>
				<td><?php echo form_button($inputs['submit']);?></td>
			</tr>
		</tbody>
	</table>
<?php echo form_close();?>
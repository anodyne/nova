<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>
<br />

<?php echo form_open_multipart('upload/index');?>
	<table class="table100">
		<tbody>
			<tr>
				<td class="cell-label"><?php echo $label['type'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_dropdown('type', $values['type']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['name'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_upload($inputs['file']);?></td>
			</tr>
			
			<?php echo table_row_spacer(3, 20);?>
			
			<tr>
				<td colspan="2"></td>
				<td><?php echo form_button($button['upload']);?></td>
		</tbody>
	</table>
<?php echo form_close();?>
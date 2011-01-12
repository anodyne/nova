<?php echo text_output($header, 'h2');?>

<?php echo text_output($text);?>

<?php echo form_open('manage/depts/duplicate/unassigned');?>
	<table class="table100">
		<tbody>
			<tr>
				<td>
					<?php echo form_hidden('id', $id);?>
					<?php echo form_button($inputs['submit']);?>
				</td>
			</tr>
		</tbody>
	</table>
<?php echo form_close();?>
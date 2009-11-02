<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo form_open('wiki/page/0/create');?>
	<table class="table100">
		<tbody>
			<tr>
				<td class="cell-label"><?php echo $label['title'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['title']);?></td>
			</tr>
			
			<?php echo table_row_spacer(3, 10);?>
			
			<tr>
				<td class="cell-label"><?php echo $label['content'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_textarea($inputs['content']);?></td>
			</tr>
			
			<?php echo table_row_spacer(3, 20);?>
			
			<tr>
				<td colspan="2"></td>
				<td><?php echo form_button($buttons['add']);?></td>
			</tr>
		</tbody>
	</table>
<?php echo form_close();?>
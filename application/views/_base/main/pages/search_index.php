<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo form_open('search/results');?>
	<table class="table100 zebra">
		<tr>
			<td class="cell-label"><?php echo $label['type'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_dropdown('type', $type);?></td>
		</tr>
		
		<?php echo table_row_spacer(3, 5);?>
		
		<tr>
			<td class="cell-label"><?php echo $label['search_in'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_dropdown('component', $component);?></td>
		</tr>
		
		<?php echo table_row_spacer(3, 5);?>
		
		<tr>
			<td class="cell-label"><?php echo $label['search_for'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_input($inputs['search']);?></td>
		</tr>
		
		<?php echo table_row_spacer(3, 15);?>
		
		<tr>
			<td colspan="3"><?php echo form_button($inputs['submit']);?></td>
		</tr>
	</table>
<?php echo form_close();?>
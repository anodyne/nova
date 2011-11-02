<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h2');?>

<?php echo form_open('wiki/managecategories/edit');?>
	<table class="table100">
		<tbody>
			<tr>
				<td class="cell-label"><?php echo $label['name'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['name']);?></td>
			</tr>
			
			<?php echo table_row_spacer(3, 5);?>
			
			<tr>
				<td class="cell-label"><?php echo $label['desc'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_textarea($inputs['desc']);?></td>
			</tr>
		</tbody>
	</table>
	<?php echo form_hidden('id', $id);?>
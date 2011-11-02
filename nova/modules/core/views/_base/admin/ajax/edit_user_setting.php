<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h2');?>

<?php echo form_open('site/usersettings/edit');?>
	<table class="table100">
		<tbody>
			<tr>
				<td class="cell-label"><?php echo $label['label'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['label']);?></td>
			</tr>
			
			<?php echo table_row_spacer(3, 10);?>
			
			<tr>
				<td class="cell-label"><?php echo $label['key'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['key']);?></td>
			</tr>
			
			<?php echo table_row_spacer(3, 10);?>
			
			<tr>
				<td class="cell-label"><?php echo $label['value'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_textarea($inputs['value']);?></td>
			</tr>
		</tbody>
	</table>
	<?php echo form_hidden('id', $id);?>
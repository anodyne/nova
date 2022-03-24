<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

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
		</tbody>
	</table>
	<?php echo form_hidden('id', $id);?>
	<?php echo form_hidden('action', 'approve');?>
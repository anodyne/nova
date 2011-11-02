<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h2');?>

<?php echo $text;?>

<?php echo form_open('site/messages/edit');?>
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
				<td class="cell-label"><?php echo $label['type'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_dropdown('message_type', $type, $value['type'], 'class="hud"');?></td>
			</tr>
			
			<?php echo table_row_spacer(3, 10);?>
			
			<tr>
				<td class="cell-label"><?php echo $label['content'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_textarea($inputs['content']);?></td>
			</tr>
		</tbody>
	</table>
	<?php echo form_hidden('old_key', $old_key);?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h2');?>

<?php echo form_open('site/specsform/editval/'. $field);?>
	<table class="table100">
		<tbody>
			<tr>
				<td class="cell-label"><?php echo $label['value'];?></td>
				<td class="cell-spacer"></td>
				<td>
					<?php echo text_output($label['insert'], 'span', 'fontTiny');?><br />
					<?php echo form_input($inputs['value']);?>
				</td>
			</tr>
			
			<?php echo table_row_spacer(3, 10);?>
			
			<tr>
				<td class="cell-label"><?php echo $label['content'];?></td>
				<td class="cell-spacer"></td>
				<td>
					<?php echo text_output($label['dropdown'], 'span', 'fontTiny');?><br />
					<?php echo form_input($inputs['content']);?>
				</td>
			</tr>
			
			<?php echo table_row_spacer(3, 10);?>
			
			<tr>
				<td class="cell-label"><?php echo $label['field'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_dropdown('value_field', $values['fields'], $selected_field, 'class="hud"');?></td>
			</tr>
		</tbody>
	</table>
	<?php echo form_hidden('id', $id);?>
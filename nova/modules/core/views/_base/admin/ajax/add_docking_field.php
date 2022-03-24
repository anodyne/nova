<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h2');?>

<?php echo form_open('site/dockingform/add');?>
	<table class="table100">
		<tbody>
			<tr>
				<td class="cell-label"><?php echo $label['section'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_dropdown('field_section', $values['section'], '', 'class="hud"');?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['type'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_dropdown('field_type', $values['type'], '', 'class="hud"');?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['label'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['label']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['order'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['order']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['display'];?></td>
				<td class="cell-spacer"></td>
				<td>
					<?php echo form_radio($inputs['display_y']);?>
					<?php echo form_label($label['yes'], 'field_display_y');?>
					
					<?php echo form_radio($inputs['display_n']);?>
					<?php echo form_label($label['no'], 'field_display_n');?>
				</td>
			</tr>
			
			<tr>
				<td colspan="3"><?php echo text_output($label['html'], 'h4');?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['name'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['name']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['id'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['id']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['class'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['class']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['rows'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['rows']);?></td>
			</tr>
			
			<tr>
				<td colspan="3"><?php echo text_output($label['select'], 'h4');?></td>
			</tr>
			<tr>
				<td colspan="3" class="fontSmall"><?php echo text_output($label['dropdown_select'], '');?></td>
			</tr>
			<tr>
				<td colspan="3"><?php echo form_textarea($inputs['select']);?></td>
			</tr>
		</tbody>
	</table>
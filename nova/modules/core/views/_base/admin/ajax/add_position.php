<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h2');?>

<?php echo form_open('manage/positions/'. $g_dept .'/add');?>
	<table class="table100">
		<tbody>
			<tr>
				<td class="cell-label"><?php echo $label['name'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['name']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['dept'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_dropdown('pos_dept', $values['depts'], '', 'class="hud"');?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['type'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_dropdown('pos_type', $values['type'], '', 'class="hud"');?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['open'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['open']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['top'];?></td>
				<td class="cell-spacer"></td>
				<td>
					<?php echo form_radio($inputs['top_y']) .' '. form_label($label['yes'], 'top_y');?>
					<?php echo form_radio($inputs['top_n']) .' '. form_label($label['no'], 'top_n');?>
				</td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['order'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['order']);?></td>
			</tr>
			
			<?php echo table_row_spacer(3, 10);?>
			
			<tr>
				<td class="cell-label"><?php echo $label['display'];?></td>
				<td class="cell-spacer"></td>
				<td>
					<?php echo form_radio($inputs['display_y']) .' '. form_label($label['on'], 'display_y');?>
					<?php echo form_radio($inputs['display_n']) .' '. form_label($label['off'], 'display_n');?>
				</td>
			</tr>
			
			<?php echo table_row_spacer(3, 10);?>
			
			<tr>
				<td class="cell-label"><?php echo $label['desc'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_textarea($inputs['desc']);?></td>
			</tr>
		</tbody>
	</table>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h2');?>

<?php echo text_output($text);?>

<?php echo form_open('manage/ranks/'. $set .'/'. $class .'/add');?>
	<table class="table100">
		<tbody>
			<tr>
				<td class="cell-label"><?php echo $label['name'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['name']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['shortname'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['shortname']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['order'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['order']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['class'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['class']);?></td>
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
				<td class="cell-label"><?php echo $label['image'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['image']) . text_output($ext, 'span', 'fontSmall');?></td>
			</tr>
		</tbody>
	</table>
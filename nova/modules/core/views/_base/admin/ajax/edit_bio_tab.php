<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h2');?>

<?php echo form_open('site/biotabs/edit');?>
	<table class="table100">
		<tbody>
			<tr>
				<td class="cell-label"><?php echo $label['name'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['name']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['order'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['order']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['link'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['link']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['display'];?></td>
				<td class="cell-spacer"></td>
				<td>
					<?php echo form_radio($inputs['display_y']);?>
					<?php echo form_label($label['yes'], 'tab_display_y');?>
					
					<?php echo form_radio($inputs['display_n']);?>
					<?php echo form_label($label['no'], 'tab_display_n');?>
				</td>
			</tr>
		</tbody>
	</table>
	<?php echo form_hidden('tab_id', $id);?>
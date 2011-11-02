<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h2');?>

<?php echo text_output($text);?>

<?php echo form_open('write/missionpost/missionCreate');?>
	<table class="table100">
		<tbody>
			<tr>
				<td colspan="2"></td>
				<td><?php echo form_dropdown('action', $missions, 0, 'class="hud" id="addMissionOption"');?></td>
			</tr>
			
			<?php echo table_row_spacer(3, 15);?>
			
			<tr>
				<td class="cell-label"><?php echo $label['title'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['title']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['desc'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_textarea($inputs['desc']);?></td>
			</tr>
		</tbody>
	</table>
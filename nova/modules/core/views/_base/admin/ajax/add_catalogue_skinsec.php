<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h2');?>

<?php echo form_open('site/catalogueskins/section/add');?>
	<table class="table100">
		<tbody>
			<tr>
				<td class="cell-label"><?php echo $label['section'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_dropdown('section', $values['section'], '', 'class="hud"');?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['skin'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_dropdown('skin', $skins, '', 'class="hud"');?></td>
			</tr>
			
			<?php echo table_row_spacer(3, 10);?>
			
			<tr>
				<td class="cell-label"><?php echo $label['preview'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['preview']);?></td>
			</tr>
			
			<?php echo table_row_spacer(3, 10);?>
			
			<tr>
				<td class="cell-label"><?php echo $label['status'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_dropdown('status', $values['status'], '', 'class="hud"');?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['default_theme'];?></td>
				<td class="cell-spacer"></td>
				<td>
					<?php echo form_radio($inputs['default_y']);?>
					<?php echo form_label($label['yes'], 'skin_default_y');?>
					
					<?php echo form_radio($inputs['default_n']);?>
					<?php echo form_label($label['no'], 'skin_default_n');?>
				</td>
			</tr>
		</tbody>
	</table>
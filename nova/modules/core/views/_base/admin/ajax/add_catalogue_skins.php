<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h2');?>

<?php echo form_open('site/catalogueskins/skin/add');?>
	<table class="table100">
		<tbody>
			<tr>
				<td class="cell-label"><?php echo $label['name'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['name']);?></td>
			</tr>
			
			<?php echo table_row_spacer(3, 10);?>
			
			<tr>
				<td class="cell-label"><?php echo $label['location'];?></td>
				<td class="cell-spacer"></td>
				<td>
					<span class="fontSmall"><?php echo APPFOLDER .'/views/';?></span><br />
					<?php echo form_input($inputs['location']);?>
				</td>
			</tr>
			
			<?php echo table_row_spacer(3, 10);?>
			
			<tr>
				<td class="cell-label"><?php echo $label['credits'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_textarea($inputs['credits']);?></td>
			</tr>
		</tbody>
	</table>
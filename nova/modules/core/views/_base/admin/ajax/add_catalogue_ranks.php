<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h2');?>

<?php echo form_open('site/catalogueranks/add');?>
	<table class="table100">
		<tbody>
			<tr>
				<td class="cell-label"><?php echo $label['name'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['name']);?></td>
			</tr>
			
			<?php echo table_row_spacer(3, 10);?>
			
			<tr>
				<td class="cell-label"><?php echo $label['genre'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['genre']);?></td>
			</tr>
			
			<?php echo table_row_spacer(3, 10);?>
			
			<tr>
				<td class="cell-label"><?php echo $label['location'];?></td>
				<td class="cell-spacer"></td>
				<td>
					<span class="fontSmall"><?php echo APPFOLDER .'/assets/common/'. GENRE .'/ranks/';?></span><br />
					<?php echo form_input($inputs['location']);?>
				</td>
			</tr>
			
			<?php echo table_row_spacer(3, 10);?>
			
			<tr>
				<td class="cell-label"><?php echo $label['preview'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['preview']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['blank'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['blank']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['extension'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['extension']);?></td>
			</tr>
			
			<?php echo table_row_spacer(3, 10);?>
			
			<tr>
				<td class="cell-label"><?php echo $label['status'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_dropdown('rank_status', $values['status'], '', 'class="hud"');?></td>
			</tr>
			
			<?php echo table_row_spacer(3, 10);?>
			
			<tr>
				<td class="cell-label"><?php echo $label['credits'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_textarea($inputs['credits']);?></td>
			</tr>
			
			<?php echo table_row_spacer(3, 10);?>
			
			<tr>
				<td class="cell-label"><?php echo $label['default_rank'];?></td>
				<td class="cell-spacer"></td>
				<td>
					<?php echo form_radio($inputs['default_y']);?>
					<?php echo form_label($label['yes'], 'rank_default_y');?>
					
					<?php echo form_radio($inputs['default_n']);?>
					<?php echo form_label($label['no'], 'rank_default_n');?>
				</td>
			</tr>
		</tbody>
	</table>
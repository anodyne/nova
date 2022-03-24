<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h2');?>

<?php echo form_open($form);?>
	<table class="table100">
		<tbody>
			<?php if ($values['user_status'] != 'active'): ?>
				<tr>
					<td class="cell-label"><?php echo $label['role'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo form_dropdown('role', $roles, '', 'class="hud"');?></td>
				</tr>
				
				<?php echo table_row_spacer(3, 10);?>
			<?php endif;?>
			
			<tr>
				<td class="cell-label"><?php echo $label['position'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_dropdown_position('position', $values['position'], 'class="hud"');?></td>
			</tr>
			
			<?php echo table_row_spacer(3, 10);?>
			
			<tr>
				<td class="cell-label"><?php echo $label['rank'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_dropdown_rank('rank', $values['rank'], 'class="hud"');?></td>
			</tr>
			
			<?php echo table_row_spacer(3, 10);?>
			
			<tr>
				<td class="cell-label"><?php echo $label['email'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_textarea($values['email']);?></td>
			</tr>
		</tbody>
	</table>
	<?php echo form_hidden('id', $id);?>
	<?php echo form_hidden('action', 'approve');?>
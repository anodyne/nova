<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h2');?>

<?php echo form_open('site/menucats/edit');?>
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
				<td class="cell-label"><?php echo $label['category'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_dropdown('menucat_menu_cat', $cats, $default['cat'], 'class="hud"');?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['type'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_dropdown('menucat_type', $types, $default['type'], 'class="hud"');?></td>
			</tr>
		</tbody>
	</table>
	<?php echo form_hidden('id', $id);?>
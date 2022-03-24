<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h2');?>

<?php echo form_open('site/rolepages/add');?>
	<table class="table100">
		<tbody>
			<tr>
				<td class="cell-label"><?php echo $label['name'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['name']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['url'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['url']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['level'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['level']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['group'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_dropdown('page_group', $groups, '', 'class="hud"');?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['desc'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_textarea($inputs['desc']);?></td>
			</tr>
		</tbody>
	</table>
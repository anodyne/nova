<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h2');?>

<?php echo form_open('site/menus/add');?>
	<table class="table100">
		<tbody>
			<tr>
				<td class="cell-label"><?php echo $label['name'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['name']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['link'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['link']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['linktype'];?></td>
				<td class="cell-spacer"></td>
				<td>
					<?php echo form_radio($inputs['link_type_on']) .' '. form_label($label['onsite'], 'link_type_on');?>
					<?php echo form_radio($inputs['link_type_off']) .' '. form_label($label['offsite'], 'link_type_off');?>
				</td>
			</tr>
			
			<?php echo table_row_spacer(3, 15);?>
			
			<tr>
				<td colspan="3"><?php echo text_output($label['groupsort'], 'h4');?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['group'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['group']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['order'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['order']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['display'];?></td>
				<td class="cell-spacer"></td>
				<td>
					<?php echo form_radio($inputs['display_y']) .' '. form_label($label['on'], 'display_y');?>
					<?php echo form_radio($inputs['display_n']) .' '. form_label($label['off'], 'display_n');?>
				</td>
			</tr>
			
			<?php echo table_row_spacer(3, 15);?>
			
			<tr>
				<td colspan="3"><?php echo text_output($label['typecat'], 'h4');?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['type'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_dropdown('menu_type', $values['type'], '', 'class="hud"');?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['category'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_dropdown('menu_cat', $cats, '', 'class="hud"');?></td>
			</tr>
			
			<?php echo table_row_spacer(3, 15);?>
			
			<tr>
				<td colspan="3">
					<?php echo text_output($label['control'], 'h4');?>
					<?php echo text_output($label['control_text'], 'p', 'fontSmall');?>
				</td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['login_req'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_dropdown('menu_need_login', $values['login'], '', 'class="hud"');?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['use_access'];?></td>
				<td class="cell-spacer"></td>
				<td>
					<?php echo form_radio($inputs['use_access_y']) .' '. form_label($label['yes'], 'use_access_y');?>
					<?php echo form_radio($inputs['use_access_n']) .' '. form_label($label['no'], 'use_access_n');?>
				</td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['control_url'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['access']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['control_level'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['access_level']);?></td>
			</tr>
			
			<?php echo table_row_spacer(3, 15);?>
			
			<tr>
				<td colspan="3">
					<?php echo text_output($label['simtype'], 'h4');?>
					<?php echo text_output($label['simtype_text'], 'p', 'fontSmall');?>
				</td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['simtype'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_dropdown('menu_sim_type', $values['sim_type'], '', 'class="hud"');?></td>
			</tr>
		</tbody>
	</table>
	<?php echo form_hidden('tab', $tab);?>
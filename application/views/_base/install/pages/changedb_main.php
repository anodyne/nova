<?php echo text_output($label['inst']);?>

<p class="fontMedium bold"><?php echo anchor('install/index', $label['back']);?></p>

<?php echo text_output($label['header_table'], 'h2');?>
<?php echo text_output($label['inst_table']);?>

<?php echo form_open('install/changedb/change/table');?>
	<?php echo text_output($label['prefix'], 'strong') .' '. form_input($inputs['table_name']);?>
	&nbsp;&nbsp;
	<?php echo form_button($inputs['submit']);?>
<?php echo form_close();?><br />

<?php echo text_output($label['header_field'], 'h2');?>
<?php echo text_output($label['inst_field']);?>

<?php echo form_open('install/changedb/change/field');?>
	<table>
		<tbody>
			<tr>
				<td class="cell-label"><?php echo $label['ftable'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_dropdown('table_name', $options, '');?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['fname'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['field_name']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['ftype'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['field_type']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['fconstraint'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['field_constraint']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['fvalue'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['field_value']);?></td>
			</tr>
			
			<?php echo table_row_spacer(3, 15);?>
			
			<tr>
				<td colspan="2"></td>
				<td><?php echo form_button($inputs['submit']);?></td>
			</tr>
		</tbody>
	</table>
<?php echo form_close();?>
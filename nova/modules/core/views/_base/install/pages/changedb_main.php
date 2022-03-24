<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($label['inst'], 'p', 'fontMedium');?>

<?php echo text_output($label['header_table'], 'h2');?>
<?php echo text_output($label['inst_table'], 'p', 'fontMedium');?>

<?php echo form_open('install/changedb/change/table');?>
	<?php echo text_output($label['prefix'], 'strong') .' '. form_input($inputs['table_name']);?>
	&nbsp;&nbsp;
	<?php echo form_button($inputs['submit']);?>
<?php echo form_close();?><br />

<?php echo text_output($label['header_field'], 'h2');?>
<?php echo text_output($label['inst_field'], 'p', 'fontMedium');?>

<?php echo form_open('install/changedb/change/field');?>
	<p>
		<kbd><?php echo $label['ftable'];?></kbd>
		<?php echo form_dropdown('table_name', $options, '');?>
	</p>
	<p>
		<kbd><?php echo $label['fname'];?></kbd>
		<?php echo form_input($inputs['field_name']);?>
	</p>
	<p>
		<kbd><?php echo $label['ftype'];?></kbd>
		<?php echo form_input($inputs['field_type']);?>
	</p>
	<p>
		<kbd><?php echo $label['fconstraint'];?></kbd>
		<?php echo form_input($inputs['field_constraint']);?>
	</p>
	<p>
		<kbd><?php echo $label['fvalue'];?></kbd>
		<?php echo form_input($inputs['field_value']);?>
	</p><br />
	
	<p><?php echo form_button($inputs['submit']);?></p>
<?php echo form_close();?>
<div class="float_right"><a href="#" class="close-popover">Close</a></div>

<?php echo form_open('manage/positions/'.$dept.'/edit');?>
	<p>
		<kbd><?php echo $label['order'];?></kbd>
		<?php echo form_input($order);?>
	</p>
	<p>
		<kbd><?php echo $label['display'];?></kbd>
		<?php echo form_dropdown($id.'_display', $display_options, $display);?>
	</p>
	<p>
		<kbd><?php echo $label['type'];?></kbd>
		<?php echo form_dropdown($id.'_type', $type_options, $type);?>
	</p>
	<p>
		<kbd><?php echo $label['dept'];?></kbd>
		<?php echo form_dropdown_dept($id.'_dept', $dept);?>
	</p>
	<p>
		<kbd><?php echo $label['desc'];?></kbd>
		<?php echo form_textarea($desc);?>
	</p>
	<p><br><?php echo form_button($submit);?></p>
<?php echo form_close();?>
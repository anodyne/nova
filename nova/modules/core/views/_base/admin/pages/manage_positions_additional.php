<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="float_right"><a href="#" class="close-popover">Close</a></div>

<p>
	<kbd><?php echo $label['order'];?></kbd>
	<?php echo form_input($order);?>
</p>
<p>
	<kbd><?php echo $label['display'];?></kbd>
	<?php echo form_dropdown('display', $display_options, $display, "id='".$id."_display'");?>
</p>
<p>
	<kbd><?php echo $label['type'];?></kbd>
	<?php echo form_dropdown('type', $type_options, $type, "id='".$id."_type'");?>
</p>
<p>
	<kbd><?php echo $label['dept'];?></kbd>
	<?php echo form_dropdown_dept('dept', $dept, "id='".$id."_dept'");?>
</p>
<p>
	<kbd><?php echo $label['desc'];?></kbd>
	<?php echo form_textarea($desc);?>
</p>
<p>
	<?php echo form_hidden('id', $id);?>
	<br><?php echo form_button($submit);?>
</p>
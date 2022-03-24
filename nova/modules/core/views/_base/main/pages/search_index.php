<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo form_open('search/results');?>
	<p>
		<kbd><?php echo $label['type'];?></kbd>
		<?php echo form_dropdown('type', $type);?>
	</p>
	
	<p>
		<kbd><?php echo $label['search_in'];?></kbd>
		<?php echo form_dropdown('component', $component);?>
	</p>
	
	<p>
		<kbd><?php echo $label['search_for'];?></kbd>
		<?php echo form_input($inputs['search']);?>
	</p><br />
	
	<p>
		<?php echo form_button($inputs['submit']);?>
	</p>
<?php echo form_close();?>
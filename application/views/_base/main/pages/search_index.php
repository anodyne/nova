<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo form_open('search/results');?>
	<p>
		<strong><?php echo $label['type'];?></strong><br />
		<?php echo form_dropdown('type', $type);?>
	</p>
	
	<p>
		<strong><?php echo $label['search_in'];?></strong><br />
		<?php echo form_dropdown('component', $component);?>
	</p>
	
	<p>
		<strong><?php echo $label['search_for'];?></strong><br />
		<?php echo form_input($inputs['search']);?>
	</p><br />
	
	<p>
		<?php echo form_button($inputs['submit']);?>
	</p>
<?php echo form_close();?>
<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($msg);?><br />

<?php echo form_open('main/contact');?>
	<p>
		<strong><?php echo $label['send'];?></strong><br />
		<?php echo form_dropdown('to', $values['to'], 0);?>
	</p>
	
	<p>
		<strong><?php echo $label['name'];?></strong><br />
		<?php echo form_input($inputs['name']);?>
	</p>
	
	<p>
		<strong><?php echo $label['email'];?></strong><br />
		<?php echo form_input($inputs['email']);?>
	</p>
	
	<p>
		<strong><?php echo $label['subject'];?></strong><br />
		<?php echo form_input($inputs['subject']);?>
	</p>
	
	<p>
		<strong><?php echo $label['message'];?></strong><br />
		<?php echo form_textarea($inputs['message']);?>
	</p><br />
	
	<p>
		<?php echo form_button($button['submit']);?>
	</p>
<?php echo form_close();?>
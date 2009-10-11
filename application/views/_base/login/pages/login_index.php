<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo form_open('login/check_login');?>
	<br /><p>
		<strong class="fontMedium"><?php echo $label['email'];?></strong><br />
		<?php echo form_input($inputs['email']);?>
	</p>
	
	<p>
		<strong class="fontMedium"><?php echo $label['password'];?></strong><br />
		<?php echo form_password($inputs['password']);?>
	</p>
	
	<p>
		<label class="remember" for="remember"><strong><?php echo $label['remember'];?></strong></label>
		<?php echo form_checkbox($inputs['remember_me']);?>
	</p>
	
	<br /><p><?php echo form_button($button_login);?></p>
<?php echo form_close();?>
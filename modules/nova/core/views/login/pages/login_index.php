<h1 class="page-head"><?php echo $header;?></h1>

<?php echo form::open('login/check');?>
	<br /><p>
		<kbd><?php echo ucwords(__('label.email_address'));?></kbd>
		<?php echo form::input('email', NULL, $inputs['email']);?>
	</p>
	
	<p>
		<kbd><?php echo ucfirst(__('label.password'));?></kbd>
		<?php echo form::password('password', NULL, $inputs['password']);?>
	</p>
	
	<p>
		<label class="remember" for="remember"><strong><?php echo __('phrase.remember_me');?></strong></label>
		<?php echo form::checkbox('rememberme', 1, FALSE, $inputs['remember']);?>
	</p>
	
	<br /><p><?php echo form::button('submit', 'Login', $inputs['button']);?></p>
<?php echo form::close();?>
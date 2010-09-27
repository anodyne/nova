<h1 class="page-head"><?php echo $header;?></h1>

<p><?php echo $text;?></p>

<hr/>

<?php echo form::open('login/check');?>
	<p>
		<kbd><?php echo ucwords(__('email address'));?></kbd>
		<?php echo form::input('email', NULL, $inputs['email']);?>
	</p>
	<p>
		<kbd><?php echo ucfirst(__('password'));?></kbd>
		<?php echo form::password('password', NULL, $inputs['password']);?>
	</p>
	<p>
		<kbd>
			<label class="remember" for="remember"><strong><?php echo ucwords(__('remember me'));?></strong></label>
			<?php echo form::checkbox('remember', 1, FALSE, $inputs['remember']);?>
		</kbd>
	</p>
	
	<br /><p><?php echo form::button('submit', ucwords(__('log in')), $inputs['button']);?></p>
<?php echo form::close();?>
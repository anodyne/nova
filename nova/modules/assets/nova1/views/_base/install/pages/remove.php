<?php echo form_open('install/remove');?>
	<p>
		<kbd><?php echo $label['email'];?></kbd>
		<input type="text" name="email" autocomplete="off" />
	</p>
	<p>
		<kbd><?php echo $label['password'];?></kbd>
		<input type="password" name="password" />
	</p>
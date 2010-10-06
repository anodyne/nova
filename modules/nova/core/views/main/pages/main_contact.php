<h1 class="page-head"><?php echo $header;?></h1>

<p><?php echo $message;?></p>

<hr />

<?php echo form::open('main/contact');?>
	<p>
		<kbd><?php echo ucwords(__("your name"));?></kbd>
		<?php echo form::input('name', NULL, $inputs['name']);?>
	</p>
	<p>
		<kbd><?php echo ucwords(__("your email address"));?></kbd>
		<?php echo form::input('email', NULL, $inputs['email']);?>
	</p>
	<p>
		<kbd><?php echo ucwords(__("your message"));?></kbd>
		<?php echo form::textarea('message', NULL, $inputs['message']);?>
	</p>
	<p>
		<kbd>
			<?php echo ucfirst(__("Send me a copy of this message"));?>:
			<?php echo form::checkbox('ccme', 1, FALSE);?>
		</kbd>
	</p><br />
	
	<p><?php echo form::button('submit', ucfirst(__("submit")), $inputs['submit']);?></p>
<?php echo form::close();?>
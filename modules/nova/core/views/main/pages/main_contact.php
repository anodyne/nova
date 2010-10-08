<h1 class="page-head"><?php echo $header;?></h1>

<p><?php echo $message;?></p>

<hr />

<?php echo form::open('main/contact');?>
	<p>
		<kbd><?php echo ucwords(__("your name"));?></kbd>
		<?php if ($errors !== FALSE AND array_key_exists('name', $errors)): ?>
			<p class="bold error">
				<?php echo html::image($images['error']);?>
				<?php echo ucfirst($errors['name']);?>
			</p>
		<?php endif;?>
		<?php echo form::input('name', NULL, $inputs['name']);?>
	</p>
	<p>
		<kbd><?php echo ucwords(__("email address"));?></kbd>
		<?php if ($errors !== FALSE AND array_key_exists('email', $errors)): ?>
			<p class="bold error">
				<?php echo html::image($images['error']);?>
				<?php echo ucfirst($errors['email']);?>
			</p>
		<?php endif;?>
		<?php echo form::input('email', NULL, $inputs['email']);?>
	</p>
	<p>
		<kbd><?php echo ucwords(__("subject"));?></kbd>
		<?php if ($errors !== FALSE AND array_key_exists('subject', $errors)): ?>
			<p class="bold error">
				<?php echo html::image($images['error']);?>
				<?php echo ucfirst($errors['subject']);?>
			</p>
		<?php endif;?>
		<?php echo form::input('subject', NULL, $inputs['subject']);?>
	</p>
	<p>
		<kbd><?php echo ucwords(__("your message"));?></kbd>
		<?php if ($errors !== FALSE AND array_key_exists('message', $errors)): ?>
			<p class="bold error">
				<?php echo html::image($images['error']);?>
				<?php echo ucfirst($errors['message']);?>
			</p>
		<?php endif;?>
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
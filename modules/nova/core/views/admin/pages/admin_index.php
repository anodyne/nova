<h1 class="page-head"><?php echo $header;?></h1>

<?php if ($reset): ?>
	<div class="info-panel">
		<h2>Change Your Password</h2>
		
		<p>I noticed that you've recently reset your password. Before you forget, you should change your password to something a little easier to remember!</p>
		
		<?php echo Form::open('admin/index/password');?>
			<p>
				<kbd>New Password</kbd>
				<?php if ($errors !== false and array_key_exists('password', $errors)): ?>
					<p class="bold error">
						<?php echo html::image(Location::image('exclamation-red.png', null, 'install', 'image'), array('class' => 'inline-image-left'));?>
						<?php echo ucfirst($errors['password']);?>
					</p>
				<?php endif;?>
				<?php echo Form::password('password');?>
			</p>
			<p>
				<kbd>Confirm New Password</kbd>
				<?php if ($errors !== false and array_key_exists('password_confirm', $errors)): ?>
					<p class="bold error">
						<?php echo html::image(Location::image('exclamation-red.png', null, 'install', 'image'), array('class' => 'inline-image-left'));?>
						<?php echo ucfirst($errors['password_confirm']);?>
					</p>
				<?php endif;?>
				<?php echo Form::password('password_confirm');?>
			</p>
			
			<p><br><?php echo Form::button('submit', ucfirst(__('submit')), array('class' => 'btn-main'));?></p>
		<?php echo Form::close();?>
	</div>
<?php endif;?>

<p><?php echo $message;?></p>
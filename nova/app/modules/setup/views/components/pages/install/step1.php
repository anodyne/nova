<p><?php echo $message;?></p>

<hr />

<?php $session = Session::instance();?>
<?php echo form::open('setup/install/step/2');?>
	<h3>Sim Information</h3>
	<div class="indent-left">
		<p>
			<kbd>Sim Name</kbd>
			<?php echo Form::input('sim_name', $session->get('sim_name', ''));?>
		</p>
	</div><br />
	
	<h3>Your Information</h3>
	<div class="indent-left">
		<p>
			<kbd>Your Name</kbd>
			<?php echo Form::input('name', $session->get('name', ''));?>
		</p>
		<p>
			<kbd>Your Email Address</kbd>
			<?php if ($errors !== false and array_key_exists('email', $errors)): ?>
				<p class="bold error">
					<?php echo Html::image(Location::image('exclamation-red.png', null, 'setup', 'image'), array('class' => 'inline-image-left'));?>
					<?php echo ucfirst($errors['email']);?>
				</p>
			<?php endif;?>
			<?php echo Form::input('email', $session->get('email', ''));?>
		</p>
		<p>
			<kbd>Your Password</kbd>
			<?php if ($errors !== false and array_key_exists('password', $errors)): ?>
				<p class="bold error">
					<?php echo Html::image(Location::image('exclamation-red.png', null, 'setup', 'image'), array('class' => 'inline-image-left'));?>
					<?php echo ucfirst($errors['password']);?>
				</p>
			<?php endif;?>
			<?php echo Form::password('password', $session->get('password', ''));?>
		</p>
		<p>
			<kbd>Confirm Your Password</kbd>
			<?php if ($errors !== false and array_key_exists('password_confirm', $errors)): ?>
				<p class="bold error">
					<?php echo Html::image(Location::image('exclamation-red.png', null, 'setup', 'image'), array('class' => 'inline-image-left'));?>
					<?php echo ucfirst($errors['password_confirm']);?>
				</p>
			<?php endif;?>
			<?php echo Form::password('password_confirm');?>
		</p>
		<p>
			<kbd>Your Security Question</kbd>
			<?php if ($errors !== false and array_key_exists('security_question', $errors)): ?>
				<p class="bold error">
					<?php echo Html::image(Location::image('exclamation-red.png', null, 'setup', 'image'), array('class' => 'inline-image-left'));?>
					<?php echo ucfirst($errors['security_question']);?>
				</p>
			<?php endif;?>
			<?php echo Form::select('security_question', $questions, $session->get('security_question', ''));?>
		</p>
		<p>
			<kbd>Your Security Answer</kbd>
			<?php if ($errors !== false and array_key_exists('security_answer', $errors)): ?>
				<p class="bold error">
					<?php echo Html::image(Location::image('exclamation-red.png', null, 'setup', 'image'), array('class' => 'inline-image-left'));?>
					<?php echo ucfirst($errors['security_answer']);?>
				</p>
			<?php endif;?>
			<span class="fontSmall subtle">Remember your answer exactly as you typed it. Security answers are case-sensitive!');?></span><br>
			<?php echo Form::input('security_answer', $session->get('security_answer', ''));?>
		</p>
	</div><br />
	
	<h3>Character Information</h3>
	<div class="indent-left">
		<p>
			<kbd>First Name</kbd>
			<?php echo Form::input('first_name', $session->get('first_name', ''));?>
		</p>
		
		<p>
			<kbd>Last Name</kbd>
			<?php echo Form::input('last_name', $session->get('last_name', ''));?>
		</p>
		
		<p>
			<kbd><?php echo ucfirst(___('position'));?></kbd>
			<?php echo Form::select_position('position', $session->get('position', null), array('id' => 'position'));?>
			&nbsp; <span id="loading_update" class="hidden fontSmall subtle"><?php echo Html::image($loading['src'], $loading['attr']);?></span>
			<p id="position_desc" class="subtle"></p>
		</p>
		
		<p>
			<kbd><?php echo ucfirst(___('rank'));?></kbd>
			<?php echo Form::select_rank('rank', $session->get('rank', null), array('id' => 'rank'));?>
			&nbsp; <span id="loading_update_rank" class="hidden fontSmall subtle"><?php echo Html::image($loading['src'], $loading['attr']);?></span>
			<p id="rank_img" class="subtle"><?php echo Html::image($default_rank['src'], $default_rank['attr']);?></p>
		</p>
	</div>
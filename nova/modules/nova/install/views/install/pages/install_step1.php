<p class="fontMedium"><?php echo $message;?></p>

<hr />

<?php $session = Session::instance();?>
<?php echo form::open('install/step/2');?>
	<h3><?php echo __('Sim Information');?></h3>
	<div class="indent-left">
		<p>
			<kbd><?php echo __('Sim Name');?></kbd>
			<?php echo form::input('sim_name', $session->get('sim_name', ''));?>
		</p>
	</div><br />
	
	<h3><?php echo __('Your Information');?></h3>
	<div class="indent-left">
		<p>
			<kbd><?php echo __('Your Name');?></kbd>
			<?php echo form::input('name', $session->get('name', ''));?>
		</p>
		<p>
			<kbd><?php echo __('Your Email Address');?></kbd>
			<?php if ($errors !== false and array_key_exists('email', $errors)): ?>
				<p class="bold error">
					<?php echo html::image(Location::image('exclamation-red.png', null, 'install', 'image'), array('class' => 'inline-image-left'));?>
					<?php echo ucfirst($errors['email']);?>
				</p>
			<?php endif;?>
			<?php echo form::input('email', $session->get('email', ''));?>
		</p>
		<p>
			<kbd><?php echo __('Your Password');?></kbd>
			<?php if ($errors !== false and array_key_exists('password', $errors)): ?>
				<p class="bold error">
					<?php echo html::image(Location::image('exclamation-red.png', null, 'install', 'image'), array('class' => 'inline-image-left'));?>
					<?php echo ucfirst($errors['password']);?>
				</p>
			<?php endif;?>
			<?php echo form::password('password', $session->get('password', ''));?>
		</p>
		<p>
			<kbd><?php echo __('Confirm Your Password');?></kbd>
			<?php if ($errors !== false and array_key_exists('password_confirm', $errors)): ?>
				<p class="bold error">
					<?php echo html::image(Location::image('exclamation-red.png', null, 'install', 'image'), array('class' => 'inline-image-left'));?>
					<?php echo ucfirst($errors['password_confirm']);?>
				</p>
			<?php endif;?>
			<?php echo form::password('password_confirm');?>
		</p>
		<p>
			<kbd><?php echo __('Your Security Question');?></kbd>
			<?php if ($errors !== false and array_key_exists('security_question', $errors)): ?>
				<p class="bold error">
					<?php echo html::image(Location::image('exclamation-red.png', null, 'install', 'image'), array('class' => 'inline-image-left'));?>
					<?php echo ucfirst($errors['security_question']);?>
				</p>
			<?php endif;?>
			<?php echo form::select('security_question', $questions, $session->get('security_question', ''));?>
		</p>
		<p>
			<kbd><?php echo __('Your Security Answer');?></kbd>
			<?php if ($errors !== false and array_key_exists('security_answer', $errors)): ?>
				<p class="bold error">
					<?php echo html::image(Location::image('exclamation-red.png', null, 'install', 'image'), array('class' => 'inline-image-left'));?>
					<?php echo ucfirst($errors['security_answer']);?>
				</p>
			<?php endif;?>
			<span class="fontSmall subtle"><?php echo __('Remember your answer exactly as you typed it. Security answers are case-sensitive!');?></span><br>
			<?php echo form::input('security_answer', $session->get('security_answer', ''));?>
		</p>
	</div><br />
	
	<h3><?php echo __('Character Information');?></h3>
	<div class="indent-left">
		<p>
			<kbd><?php echo __('First Name');?></kbd>
			<?php echo form::input('first_name', $session->get('first_name', ''));?>
		</p>
		
		<p>
			<kbd><?php echo __('Last Name');?></kbd>
			<?php echo form::input('last_name', $session->get('last_name', ''));?>
		</p>
		
		<p>
			<kbd><?php echo ucfirst(__('position'));?></kbd>
			<?php echo form::select_position('position', $session->get('position', null), array('id' => 'position'));?>
			&nbsp; <span id="loading_update" class="hidden fontSmall subtle"><?php echo html::image($loading['src'], $loading['attr']);?></span>
			<p id="position_desc" class="subtle"></p>
		</p>
		
		<p>
			<kbd><?php echo ucfirst(__('rank'));?></kbd>
			<?php echo form::select_rank('rank', $session->get('rank', null), array('id' => 'rank'));?>
			&nbsp; <span id="loading_update_rank" class="hidden fontSmall subtle"><?php echo html::image($loading['src'], $loading['attr']);?></span>
			<p id="rank_img" class="subtle"><?php echo html::image($default_rank['src'], $default_rank['attr']);?></p>
		</p>
	</div>
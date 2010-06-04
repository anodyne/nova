<p class="fontMedium"><?php echo $message;?></p>

<hr />

<?php echo form::open('install/step/2');?>
	<h3><?php echo __('step1.sim_info');?></h3>
	<div class="indent-left">
		<p>
			<kbd><?php echo __('step1.sim_name');?></kbd>
			<?php echo form::input('sim_name', Session::instance()->get('sim_name', ''));?>
		</p>
	</div><br />
	
	<h3><?php echo __('step1.your_info');?></h3>
	<div class="indent-left">
		<p>
			<kbd><?php echo __('step1.name');?></kbd>
			<?php echo form::input('name', Session::instance()->get('name', ''));?>
		</p>
		
		<p>
			<kbd><?php echo __('step1.email');?></kbd>
			<?php if ($errors !== FALSE && array_key_exists('email', $errors)): ?>
				<p class="bold error">
					<?php echo html::image(location::image('exclamation-red.png', NULL, 'install', 'image'), array('class' => 'inline-image-left'));?>
					<?php echo ucfirst($errors['email']);?>
				</p>
			<?php endif;?>
			<?php echo form::input('email', Session::instance()->get('email', ''));?>
		</p>
		
		<p>
			<kbd><?php echo __('step1.password');?></kbd>
			<?php if ($errors !== FALSE && array_key_exists('password', $errors)): ?>
				<p class="bold error">
					<?php echo html::image(location::image('exclamation-red.png', NULL, 'install', 'image'), array('class' => 'inline-image-left'));?>
					<?php echo ucfirst($errors['password']);?>
				</p>
			<?php endif;?>
			<?php echo form::password('password', Session::instance()->get('password', ''));?>
		</p>
		
		<p>
			<kbd><?php echo __('step1.password_confirm');?></kbd>
			<?php if ($errors !== FALSE && array_key_exists('password_confirm', $errors)): ?>
				<p class="bold error">
					<?php echo html::image(location::image('exclamation-red.png', NULL, 'install', 'image'), array('class' => 'inline-image-left'));?>
					<?php echo ucfirst($errors['password_confirm']);?>
				</p>
			<?php endif;?>
			<?php echo form::password('password_confirm');?>
		</p>
	</div><br />
	
	<h3><?php echo __('step1.character_info');?></h3>
	<div class="indent-left">
		<p>
			<kbd><?php echo __('step1.char_fname');?></kbd>
			<?php echo form::input('first_name', Session::instance()->get('first_name', ''));?>
		</p>
		
		<p>
			<kbd><?php echo __('step1.char_lname');?></kbd>
			<?php echo form::input('last_name', Session::instance()->get('last_name', ''));?>
		</p>
		
		<p>
			<kbd><?php echo __('step1.char_position');?></kbd>
			<?php echo form::select_position('position', Session::instance()->get('position', NULL), array('id' => 'position'));?>
			&nbsp; <span id="loading_update" class="hidden fontSmall subtle"><?php echo html::image($loading['src'], $loading['attr']);?></span>
			<p id="position_desc" class="subtle"></p>
		</p>
		
		<p>
			<kbd><?php echo __('step1.char_rank');?></kbd>
			<?php echo form::select_rank('rank', Session::instance()->get('rank', NULL), array('id' => 'rank'));?>
			&nbsp; <span id="loading_update_rank" class="hidden fontSmall subtle"><?php echo html::image($loading['src'], $loading['attr']);?></span>
			<p id="rank_img" class="subtle"><?php echo html::image($default_rank['src'], $default_rank['attr']);?></p>
		</p>
	</div>
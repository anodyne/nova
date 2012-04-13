<p><?php echo $message;?></p>

<?php if ($allowed === true): ?>
	<?php echo Form::open(array('action' => 'setup/install/index/2', 'method' => 'post', 'id' => 'step1'));?>
		<fieldset>
			<legend>Sim Information</legend>
			
			<div class="control-group">
				<label class="control-label">Sim Name</label>
				<?php echo Form::input('sim_name');?>
			</div>
		</fieldset>
		
		<fieldset>
			<legend>Your Information</legend>
			
			<div class="control-group">
				<label class="control-label">Your Name</label>
				<?php echo Form::input('name');?>
			</div>
			
			<div class="control-group">
				<label class="control-label">Your Email Address</label>
				<?php echo Form::input('email', null, array('type' => 'email'));?>
			</div>
			
			<div class="control-group">
				<label class="control-label">Your Password</label>
				<?php echo Form::password('password', null, array('id' => 'password'));?>
			</div>
			
			<div class="control-group">
				<label class="control-label">Confirm Your Password</label>
				<?php echo Form::password('password_confirm');?>
			</div>
		</fieldset>
		
		<fieldset>
			<legend>Character Information</legend>
			
			<div class="control-group">
				<label class="control-label">First Name</label>
				<?php echo Form::input('first_name');?>
			</div>
			
			<div class="control-group">
				<label class="control-label">Last Name</label>
				<?php echo Form::input('last_name');?>
			</div>
			
			<div class="control-group">
				<label class="control-label">Position</label>
				<?php echo NovaForm::position('position', null, array('id' => 'position'));?>
				&nbsp; <span id="loading_update" class="hide muted"><?php echo $loading;?></span>
				<p id="position_desc" class="help-block"></p>
			</div>
			
			<div class="control-group">
				<label class="control-label">Rank</label>
				<?php echo NovaForm::rank('rank', null, array('id' => 'rank'));?>
				&nbsp; <span id="loading_update_rank" class="hide muted"><?php echo $loading;?></span>
				<p id="rank_img" class="help-block"><?php echo $default_rank;?></p>
			</div>
		</fieldset>
<?php endif;?>
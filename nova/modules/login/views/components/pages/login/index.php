<?php if ($lockout === false): ?>
	<br>
	<?php echo Form::open('login/index');?>
		<div class="control-group">
			<div class="controls">
				<div class="input-prepend">
					<span class="add-on"><i class="icon-user icon-black25"></i></span><input type="email" name="email" id="email" placeholder="<?php echo ucwords(__("email_address"));?>">
				</div>
			</div>
		</div>
		
		<div class="control-group">
			<div class="controls">
				<div class="input-prepend input-append">
					<span class="add-on"><i class="icon-lock icon-black25"></i></span><input type="password" name="password" id="password" placeholder="<?php echo ucfirst(__("password"));?>"><span class="add-on"><a href="<?php echo Uri::create('login/reset');?>" class="tooltip-right" title="<?php echo __('short.forgot_password');?>"><i class="icon-question-sign icon-black25"></i></a></span>
				</div>
			</div>
		</div>

		<div class="control-group">
			<div class="controls">
				<button class="btn btn-primary"><?php echo ucwords(__('action.login'));?></button>
			</div>
		</div>
	<?php echo Form::close();?>
<?php endif;?>
<?php if ($lockout === false): ?>
	<?php echo Form::open('login/index');?>
		<div class="control-group">
			<div class="controls">
				<input type="email" name="email" id="email" class="span4" placeholder="<?php echo lang("email_address", 2);?>">
			</div>
		</div>
		
		<div class="control-group">
			<div class="controls">
				<input type="password" name="password" id="password" class="span4" placeholder="<?php echo lang("password", 1);?>">
				<p class="help-block"><a href="<?php echo Uri::create('login/reset');?>"><?php echo lang("short.forgot_password", 1);?></a></p>
			</div>
		</div>

		<div class="control-group">
			<div class="controls">
				<br>
				<button class="btn btn-primary"><?php echo lang('action.login', 2);?></button>
				<a href="<?php echo Uri::create('main/index');?>" class="btn"><?php echo lang('action.back to site', 1);?></a>
			</div>
		</div>
		<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
	<?php echo Form::close();?>
<?php endif;?>
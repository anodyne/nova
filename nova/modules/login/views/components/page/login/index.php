<?php if ($lockout === false): ?>
	<?php echo Form::open('login/index');?>
		<div class="control-group">
			<div class="controls">
				<input type="email" name="email" id="email" class="span4" placeholder="<?php echo ucwords(lang("email_address"));?>">
			</div>
		</div>
		
		<div class="control-group">
			<div class="controls">
				<input type="password" name="password" id="password" class="span4" placeholder="<?php echo ucfirst(lang("password"));?>">
				<p class="help-block"><a href="<?php echo Uri::create('login/reset');?>"><?php echo lang("short.forgotPassword");?></a></p>
			</div>
		</div>

		<div class="control-group">
			<div class="controls">
				<div class="hidden-phone">
					<button class="btn btn-primary"><?php echo ucwords(lang('action.login'));?></button>
					<a href="<?php echo Uri::create('main/index');?>" class="btn"><?php echo lang('short.backToSite');?></a>
				</div>

				<div class="hidden-desktop hidden-tablet">
					<button class="btn btn-primary btn-block btn-large"><?php echo ucwords(lang('action.login'));?></button>
					<a href="<?php echo Uri::create('main/index');?>" class="btn btn-block btn-large"><?php echo lang('short.backToSite');?></a>
				</div>
			</div>
		</div>
		<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
	<?php echo Form::close();?>
<?php endif;?>
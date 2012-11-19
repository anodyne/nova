<?php echo Form::open('login/reset');?>
	<div class="control-group">
		<div class="controls">
			<input type="email" name="email" id="email" class="span4" placeholder="<?php echo ucwords(lang("email_address"));?>">
		</div>
	</div>
	
	<div class="control-group">
		<div class="controls">
			<input type="password" name="password" id="password" class="span4" placeholder="<?php echo ucwords(lang('short.new', lang('password')));?>">
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<div class="hidden-phone">
				<button class="btn btn-primary"><?php echo ucfirst(lang('action.submit'));?></button>
				<a href="<?php echo Uri::create('login/index');?>" class="btn"><?php echo lang('short.cancelPasswordReset');?></a>
			</div>

			<div class="hidden-desktop hidden-tablet">
				<button class="btn btn-primary btn-block btn-large"><?php echo lang('action.submit', 1);?></button>
				<a href="<?php echo Uri::create('login/index');?>" class="btn btn-block btn-large"><?php echo lang('short.cancelPasswordReset');?></a>
			</div>
		</div>
	</div>
	<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
<?php echo Form::close();?>
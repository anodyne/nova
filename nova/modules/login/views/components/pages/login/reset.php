<br>
<?php echo Form::open('login/reset');?>
	<div class="control-group">
		<div class="controls">
			<div class="input-prepend">
				<span class="add-on"><div class="icn icn16 icn-50" data-icon="e"></div></span><input type="email" name="email" id="email" placeholder="<?php echo lang("email_address", 2);?>">
			</div>
		</div>
	</div>
	
	<div class="control-group">
		<div class="controls">
			<div class="input-prepend input-append">
				<span class="add-on"><div class="icn icn16 icn-50" data-icon="("></div></span><input type="password" name="password" id="password" placeholder="<?php echo lang('status.new password', 2);?>"><span class="add-on"><a href="<?php echo Uri::create('login/index');?>" class="tooltip-right" title="<?php echo lang('short.cancel_password_reset');?>"><div class="icn icn16 icn-50" data-icon="2"></div></a></span>
			</div>
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<br>
			<button class="btn btn-primary"><?php echo lang('action.submit', 1);?></button>
		</div>
	</div>
	<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
<?php echo Form::close();?>
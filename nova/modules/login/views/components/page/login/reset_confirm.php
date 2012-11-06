<?php echo Form::open('login/reset_confirm/'.Uri::segment(3).'/'.Uri::segment(4));?>
	<div class="controls">
		<div class="hidden-phone">
			<button class="btn btn-primary"><?php echo lang('action.confirm password action.reset', 2);?></button>
			<a href="<?php echo Uri::create('login/index');?>" class="btn"><?php echo lang('action.login', 2);?></a>
		</div>

		<div class="hidden-desktop hidden-tablet">
			<button class="btn btn-primary btn-block btn-large"><?php echo lang('action.confirm password action.reset', 2);?></button>
			<a href="<?php echo Uri::create('login/index');?>" class="btn btn-block btn-large"><?php echo lang('action.login', 2);?></a>
		</div>
	</div>
	<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
<?php echo Form::close();?>
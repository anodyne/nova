<?php echo Form::open('login/reset_confirm/'.Uri::segment(3).'/'.Uri::segment(4));?>
	<br>
	<div class="controls">
		<button class="btn btn-primary">Confirm Password Reset</button>
		<a href="<?php echo Uri::create('login/index');?>" class="btn"><?php echo ucwords(__('action.login'));?></a>
	</div>
<?php echo Form::close();?>
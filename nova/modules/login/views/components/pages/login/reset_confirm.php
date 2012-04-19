<?php echo Form::open('login/reset_confirm/'.Uri::segment(3).'/'.Uri::segment(4));?>
	<br>
	<div class="controls">
		<button class="btn btn-primary"><?php echo lang('action.confirm password action.reset', 2);?></button>
		<a href="<?php echo Uri::create('login/index');?>" class="btn"><?php echo lang('action.login', 2);?></a>
	</div>
<?php echo Form::close();?>
<br>
<?php if (Sentry::user()->has_level('character.create', 2)): ?>
	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/application/rules');?>" class="btn tooltip-top" title="<?php echo lang('action.manage rules', 1);?>"><?php echo $images['rules'];?></a>
	</div>
	<br>
<?php endif;?>
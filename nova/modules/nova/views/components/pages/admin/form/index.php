<br>
<?php if (count($forms) > 0): ?>
	<ul class="thumbnails">
	<?php foreach ($forms as $form): ?>
		<li class="span6">
			<div class="thumbnail">
				<div class="caption">
					<?php if (Sentry::user()->has_access('form.update')): ?>
						<div class="btn-group pull-right">
							<a class="btn icn16 dropdown-toggle" data-toggle="dropdown" href="#"><span class="icn icn-50" data-icon=")"></span></a>
							<ul class="dropdown-menu">
								<li>
									<a href="#" class="edit-form" data-key="<?php echo $form->key;?>">
										<?php echo lang('action.edit form', 2);?>
									</a>
								</li>
								<li>
									<a href="<?php echo Uri::create('admin/form/fields/'.$form->key);?>">
										<?php echo lang('action.edit fields', 2);?>
									</a>
								</li>
								<li>
									<a href="<?php echo Uri::create('admin/form/tabs/'.$form->key);?>">
										<?php echo lang('action.edit tabs', 2);?>
									</a>
								</li>
								<li>
									<a href="<?php echo Uri::create('admin/form/sections/'.$form->key);?>">
										<?php echo lang('action.edit sections', 2);?>
									</a>
								</li>
							</ul>
						</div>
					<?php endif;?>

					<h4><?php echo $form->name;?></h4>
				</div>
			</div>
		</li>
	<?php endforeach;?>
	</ul>
<?php endif;?>
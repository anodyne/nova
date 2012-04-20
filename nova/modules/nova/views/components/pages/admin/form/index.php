<br>
<?php if (count($forms) > 0): ?>
	<ul class="thumbnails">
	<?php foreach ($forms as $form): ?>
		<li class="span6">
			<div class="thumbnail">
				<div class="caption">
					<?php if (Sentry::user()->has_access('form.edit')): ?>
						<div class="btn-group pull-right">
							<a class="btn btn-small dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $images['action'];?> <span class="caret"></span></a>
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

					<h3><?php echo $form->name;?></h3>
				</div>
			</div>
		</li>
	<?php endforeach;?>
	</ul>
<?php endif;?>
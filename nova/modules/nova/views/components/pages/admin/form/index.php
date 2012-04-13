<br>
<?php if (count($forms) > 0): ?>
	<ul class="thumbnails">
	<?php foreach ($forms as $form): ?>
		<li class="span6">
			<div class="thumbnail">
				<div class="caption">
					<div class="btn-group pull-right">
						<a href="#" class="btn btn-small edit-form" data-key="<?php echo $form->key;?>"><?php echo ucfirst(__('action.edit'));?></a>
						<a href="<?php echo Uri::create('admin/form/fields/'.$form->key);?>" class="btn btn-small"><?php echo ucfirst(Inflector::pluralize(__('field')));?></a>
						<a href="<?php echo Uri::create('admin/form/tabs/'.$form->key);?>" class="btn btn-small"><?php echo ucfirst(Inflector::pluralize(__('tab')));?></a>
						<a href="<?php echo Uri::create('admin/form/sections/'.$form->key);?>" class="btn btn-small"><?php echo ucfirst(Inflector::pluralize(__('section')));?></a>
					</div>

					<h3><?php echo $form->name;?></h3>
				</div>
			</div>
		</li>
	<?php endforeach;?>
	</ul>
<?php endif;?>
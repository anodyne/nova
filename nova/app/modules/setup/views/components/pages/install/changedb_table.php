<strong><?php echo Database::instance()->table_prefix();?></strong>
<?php echo Form::input('table_name');?>
<span class="loading-table hidden"><?php echo Html::image($images['loading']['src'], $images['loading']['attr']);?></span>

<p>
	<span class="hidden error-table">
		<?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation-red.png', array('class' => 'inline-image-left'));?>
		<strong class="error">Table creation failed</strong>
	</span>
	
	<span class="hidden success-table">
		<?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/tick-circle.png', array('class' => 'inline-image-left'));?>
		<strong class="success">Table created</strong>
	</span>
</p>
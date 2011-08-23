<p>
	<kbd>Your MySQL Query</kbd>
	<span class="fontSmall subtle">This is the query that will be executed on your Nova database</span><br>
	<textarea name="query" rows="5" class="query"></textarea>
</p>

<p>
	<span class="hidden loading-query"><?php echo Html::image($images['loading']['src'], $images['loading']['attr']);?></span>
	
	<span class="hidden error-query">
		<?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation-red.png', array('class' => 'inline-image-left'));?>
		<strong class="error">Query was not successfully run</strong>
	</span>
	
	<span class="hidden success-query">
		<?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/tick-circle.png', array('class' => 'inline-image-left'));?>
		<strong class="success">Query was successfully run</strong>
	</span>
	
	<span class="hidden warning-query">
		<?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation.png', array('class' => 'inline-image-left'));?>
		<strong class="warning">Query was run but no rows were affected</strong>
	</span>
	
	<span class="hidden special-query">
		<?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/information.png', array('class' => 'inline-image-left'));?>
		<strong class="info">Query was run but cannot be automatically verified</strong>
	</span>
</p>
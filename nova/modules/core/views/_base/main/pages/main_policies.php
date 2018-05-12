<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php echo text_output($header, 'h1', 'page-head'); ?>

<div class="fontSmall line_height_18">
	<strong>Policies &mdash;</strong>
	<?php $i = 1; ?>
	<?php foreach ($policies as $key => $value) : ?>
		<?php echo anchor('main/policies/' . $key, $value); ?>
		<?php if ($i < count($policies)) : ?>
			&middot;
		<?php endif; ?>
		<?php ++$i; ?>
	<?php endforeach; ?>
</div>
<hr />

<?php echo text_output($message); ?>

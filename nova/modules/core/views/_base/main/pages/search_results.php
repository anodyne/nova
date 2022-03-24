<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php if (isset($msg)): ?>
	<?php echo text_output($msg);?>
<?php endif; ?>

<p class="fontMedium"><?php echo anchor('search/index', $label['search'], array('class' => 'bold'));?></p>

<?php if (isset($msg)): ?>
	<hr />
<?php endif; ?>

<?php if (isset($results)): ?>
	<ul class="line_height_18">
		<?php foreach ($results as $result): ?>
			<li>
				<strong><?php echo $result['link'];?></strong>
				<div class="line_height_13"><?php echo word_limiter($result['content'], 100);?></div><br />
			</li>
		<?php endforeach; ?>
	</ul>
<?php else: ?>
	<?php echo text_output($label['noresult'], 'h3', 'orange');?>
<?php endif; ?>
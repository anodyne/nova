<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo $syspage;?>

<?php if (isset($pages)): ?>
	<br /><div class="search_cat"></div>
	
	<ul class="square margin1 padding1 cat_search">
	<?php foreach ($pages as $p): ?>
		<li>
			<?php echo anchor('wiki/view/page/'. $p['id'], $p['title']);?>
			<?php if (!empty($p['summary'])): ?>
				<br />
				<?php echo text_output($p['summary'], 'em', 'fontSmall gray');?>
			<?php endif;?>
		</li>
	<?php endforeach;?>
<?php else: ?>
	<?php echo text_output($label['nopages'], 'h3', 'orange');?>
<?php endif;?>
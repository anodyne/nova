<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<div id="tabs">
	<ul>
		<li><a href="#one"><span><?php echo $label['activated'];?></span></a></li>
		<li><a href="#two"><span><?php echo $label['saved'];?></span></a></li>
		
		<?php if (Auth::get_access_level('manage/news') == 2): ?>
			<li><a href="#three"><span><?php echo $label['pending'];?></span></a></li>
		<?php endif;?>
	</ul>
	
	<div id="one">
		<?php echo $activated;?>
	</div>
	
	<div id="two">
		<?php echo $saved;?>
	</div>
	
	<?php if (Auth::get_access_level('manage/news') == 2): ?>
		<div id="three">
			<?php echo $pending;?>
		</div>
	<?php endif;?>
</div>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php if (isset($draft)): ?>
	<?php echo text_output($header, 'h1', 'page-head');?>
	
	<p class="bold"><?php echo anchor('wiki/view/page/'. $draft['page'], $label['back_page']);?></p>
	
	<p class="fontSmall gray bold">
		<?php echo $label['draft'] .' '. $label['created'] .' '. $label['by'] .' '. $draft['created'] .' '. $label['on'] .' '. $draft['created_date'];?>
	</p>
	
	<?php echo text_output($draft['content'], 'p', '', FALSE);?>
	
	<br />
	<div class="info-full fontSmall">
		<p><?php echo text_output($label['categories'], 'strong') .' '. $draft['categories'];?></p>
	</div>
<?php else: ?>
	<?php echo text_output($label['nodraft'], 'h1', 'red');?>
<?php endif;?>